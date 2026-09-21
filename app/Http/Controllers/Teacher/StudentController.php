<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\LessonEnrollment;
use App\Models\UserQuizAttempt;

class StudentController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $teacherName = trim((string) (auth()->user()->name ?? ''));

        $enrollments = Enrollment::with([
                'user',
                'course' => fn ($query) => $query->withCount('lessons'),
            ])
            ->whereHas('course', function ($query) use ($userId, $teacherName) {
                $query->where('instructor_id', $userId)
                    ->orWhere('instructor_name', $teacherName)
                    ->orWhereHas('subjects', fn ($subjectQuery) => $subjectQuery->where('teacher_id', $userId));
            })
            ->orderByDesc('created_at')
            ->get();

        $enrollmentIds = $enrollments->pluck('id');
        $lessonProgress = LessonEnrollment::whereIn('enrollment_id', $enrollmentIds)
            ->select('enrollment_id', 'completed', 'completed_at', 'updated_at')
            ->get()
            ->groupBy('enrollment_id');

        foreach ($enrollments as $enrollment) {
            $allLessons = (int) ($enrollment->course?->lessons_count ?? 0);
            $completedLessons = $lessonProgress->get($enrollment->id, collect())->where('completed', true)->count();
            $progress = $allLessons > 0
                ? min(100, (int) round(($completedLessons / $allLessons) * 100))
                : max(0, min(100, (int) ($enrollment->progress ?? 0)));

            $lastActivity = collect([
                $lessonProgress->get($enrollment->id, collect())->max('updated_at'),
                $lessonProgress->get($enrollment->id, collect())->max('completed_at'),
                $enrollment->updated_at,
            ])->filter()->sortDesc()->first();

            $originalStatus = ucfirst(strtolower((string) ($enrollment->status ?? '')));
            if (in_array($originalStatus, ['Active', 'Pending', 'Inactive', 'Dropped'], true)) {
                $status = $originalStatus;
            } elseif ($enrollment->completed || $progress >= 100) {
                $status = 'Completed';
            } else {
                $status = $progress > 0 ? 'Active' : 'Pending';
            }

            if ($progress >= 100 && ! in_array($status, ['Completed'], true)) {
                $status = 'Completed';
            }

            $enrollment->setAttribute('progress', $progress);
            $enrollment->setAttribute('completed_lessons', $completedLessons);
            $enrollment->setAttribute('total_lessons', $allLessons);
            $enrollment->setAttribute('status', $status);
            $enrollment->setAttribute('last_activity_at', $lastActivity);
        }

        return view('teacher.students.index', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::with('user', 'course')->find($id);

        if (!$enrollment) {
            $enrollment = Enrollment::with('user', 'course')
                ->where('user_id', $id)
                ->firstOrFail();
        }

        // Admins can view all student enrollments; teachers remain restricted to their own courses.
        $user = auth()->user();
        if (! $user || ! $user->is_admin) {
            $course = $enrollment->course;
            if (!($course && (($course->instructor_id ?? null) === auth()->id() || (($course->instructor_id === null) && ($course->instructor_name ?? '') === (auth()->user()->name ?? ''))))) {
                abort(403);
            }
        }

        $gradeRecords = \App\Models\GradeRecord::with('teacher')
            ->where('student_id', $enrollment->user_id)
            ->where('course_id', $enrollment->course_id)
            ->latest()
            ->get();

        $lessonProgress = LessonEnrollment::with('lesson')
            ->where('enrollment_id', $enrollment->id)
            ->latest('updated_at')
            ->get();

        $quizAttempts = UserQuizAttempt::with('quiz.module')
            ->where('user_id', $enrollment->user_id)
            ->whereHas('quiz.module', function ($query) use ($enrollment) {
                $query->where('course_id', $enrollment->course_id);
            })
            ->latest('completed_at')
            ->get();

        $recentActivity = $lessonProgress
            ->filter(fn ($item) => $item->updated_at)
            ->map(fn ($item) => [
                'type' => 'Lesson',
                'title' => $item->lesson?->title ?? 'Lesson activity',
                'detail' => $item->completed ? 'Completed lesson' : 'Lesson in progress',
                'score' => null,
                'date' => $item->updated_at,
            ])
            ->concat($quizAttempts->filter(fn ($item) => $item->completed_at)->map(fn ($item) => [
                'type' => 'Quiz',
                'title' => $item->quiz?->title ?? 'Quiz attempt',
                'detail' => $item->passed ? 'Passed quiz' : 'Quiz submitted',
                'score' => $item->score_percentage,
                'date' => $item->completed_at,
            ]))
            ->sortByDesc('date')
            ->take(10)
            ->values();

        return view('teacher.students.show', compact(
            'enrollment',
            'gradeRecords',
            'lessonProgress',
            'quizAttempts',
            'recentActivity'
        ));
    }
}
