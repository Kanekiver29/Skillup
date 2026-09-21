<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\LessonEnrollment;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use App\Models\User;

class ProgressController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $teacherName = trim((string) (auth()->user()->name ?? ''));

        $enrollments = Enrollment::with([
                'user',
                'subject',
                'course' => fn ($query) => $query->withCount('lessons'),
            ])
            ->whereHas('course', function ($query) use ($userId, $teacherName) {
                $query->where('instructor_id', $userId)
                    ->orWhere('instructor_name', $teacherName)
                    ->orWhereHas('subjects', fn ($subjectQuery) => $subjectQuery->where('teacher_id', $userId));
            })
            ->latest()
            ->get();

        $enrollmentIds = $enrollments->pluck('id');
        $courseIds = $enrollments->pluck('course_id')->unique();
        $studentIds = $enrollments->pluck('user_id')->unique();

        $lessonProgress = LessonEnrollment::whereIn('enrollment_id', $enrollmentIds)
            ->get(['enrollment_id', 'completed', 'completed_at', 'updated_at'])
            ->groupBy('enrollment_id');

        $quizAttempts = UserQuizAttempt::with('quiz.module')
            ->whereIn('user_id', $studentIds)
            ->with('quiz.subject.course')
            ->whereHas('quiz', function ($query) use ($courseIds) {
                $query->whereHas('module', fn ($moduleQuery) => $moduleQuery->whereIn('course_id', $courseIds))
                    ->orWhereHas('subject', fn ($subjectQuery) => $subjectQuery->whereIn('course_id', $courseIds));
            })
            ->latest('completed_at')
            ->get()
            ->filter(fn ($attempt) => $attempt->quiz?->module?->course_id || $attempt->quiz?->subject?->course_id)
            ->groupBy(fn ($attempt) => $attempt->user_id . ':' . ($attempt->quiz->module->course_id ?? $attempt->quiz->subject->course_id));

        foreach ($enrollments as $enrollment) {
            $lessons = $lessonProgress->get($enrollment->id, collect());
            $attempts = $quizAttempts->get($enrollment->user_id . ':' . $enrollment->course_id, collect());
            $lessonCount = (int) ($enrollment->course?->lessons_count ?? 0);
            $completedLessons = $lessons->where('completed', true)->count();

            $enrollment->monitoring_progress = $lessons->isNotEmpty() && $lessonCount > 0
                ? min(100, (int) round(($completedLessons / $lessonCount) * 100))
                : min(100, max(0, (int) ($enrollment->progress ?? 0)));
            $enrollment->completed_lessons = $completedLessons;
            $enrollment->total_lessons = $lessonCount;
            $enrollment->quiz_attempts = $attempts->whereNotNull('completed_at')->count();
            $enrollment->last_activity = collect([
                $lessons->max('updated_at'),
                $attempts->max('completed_at'),
            ])->filter()->sortDesc()->first();
        }

        $summary = [
            'students' => $enrollments->pluck('user_id')->unique()->count(),
            'courses' => $enrollments->pluck('course_id')->unique()->count(),
            'average' => round($enrollments->avg('monitoring_progress') ?? 0, 1),
            'completed' => $enrollments->filter(fn ($enrollment) => $enrollment->monitoring_progress >= 100)->count(),
        ];

        return view('teacher.progress.index', compact('enrollments', 'summary'));
    }

    public function show($student)
    {
        $studentModel = User::findOrFail($student);
        $enrollments = $studentModel->enrollments()
            ->with(['course', 'subject'])
            ->whereHas('course', function ($query) {
                $query->where('instructor_id', auth()->id())
                    ->orWhere('instructor_name', auth()->user()->name ?? '')
                    ->orWhereHas('subjects', fn ($subjectQuery) => $subjectQuery->where('teacher_id', auth()->id()));
            })
            ->latest()
            ->get();

        return view('teacher.progress.show', compact('studentModel', 'enrollments'));
    }
}
