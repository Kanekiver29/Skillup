<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\UserQuizAttempt;
use App\Models\GradeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherFeatureController extends Controller
{
    public function courses()
    {
        return view('teacher.courses.index');
    }

    public function dashboard()
    {
        // Gather statistics for the teacher dashboard
        $teacherId = auth()->id();
        // Active courses owned by this teacher
        $activeCourses = \App\Models\Course::where('instructor_id', $teacherId)->get();
        $activeCoursesCount = $activeCourses->count();
        // Total students enrolled in teacher's courses
        $totalStudents = \App\Models\Course::where('instructor_id', $teacherId)
            ->withCount('students')
            ->get()
            ->sum('students_count');
        // Assignments due soon (next 7 days)
        $assignmentsDue = \App\Models\Assignment::whereHas('course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->count();
        // Pending grading submissions
        $pendingGrading = \App\Models\Submission::whereHas('assignment.course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->whereNull('grade')
            ->count();
        // Upcoming sessions (lessons) for next 7 days
        $upcomingSessions = \App\Models\Lesson::whereHas('module.course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', now()->addDays(7))
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();
        // Recent submissions (last 5)
        $recentSubmissions = \App\Models\Submission::whereHas('assignment.course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->with(['student', 'assignment'])
            ->get();
        // Simple teaching tips
        $tips = [
            'Try creating interactive quizzes to boost engagement.',
            'Regular feedback helps students improve faster.',
            'Use diverse content formats to cater to different learning styles.',
        ];
        $stats = [
            'active_courses' => $activeCoursesCount,
            'total_students' => $totalStudents,
            'assignments_due' => $assignmentsDue,
            'pending_grading' => $pendingGrading,
            'average_score' => null,
            'completion_rate' => null,
            'attendance_rate' => null,
            'engagement_level' => null,
        ];
        return view('teacher.dashboard', compact('stats', 'upcomingSessions', 'recentSubmissions', 'activeCourses', 'tips'));
    }

    public function quizzes()
    {
        $quizzes = \App\Models\Quiz::with(['module.course', 'subject'])
            ->withCount('questions')
            ->where(function ($query) {
                $query->whereHas('module.course', fn ($course) => $course->where('instructor_id', auth()->id()))
                    ->orWhereHas('subject', fn ($subject) => $subject->where('teacher_id', auth()->id()));
            })
            ->orderByDesc('created_at')
            ->get();
        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function modules()
    {
        return view('teacher.modules.index');
    }

    public function assignments()
    {
        return view('teacher.assignments.index');
    }

    public function assignmentCreate()
    {
        return view('teacher.assignments.create');
    }

    public function submissions()
    {
        return view('teacher.assignments.submissions');
    }

    public function grades()
    {
        $courses = $this->teacherCourses();
        $courseIds = $courses->pluck('id');

        $attempts = UserQuizAttempt::with(['user:id,name,email', 'quiz.module.course', 'quiz.subject.course'])
            ->whereNotNull('completed_at')
            ->when(! auth()->user()?->isAdmin(), function ($query) {
                $query->whereHas('quiz', function ($quizQuery) {
                    $quizQuery->whereHas('module.course', fn ($course) => $course->where('instructor_id', auth()->id()))
                        ->orWhereHas('subject', fn ($subject) => $subject->where('teacher_id', auth()->id()));
                });
            })
            ->latest('completed_at')
            ->get();

        $stats = [
            'students' => $attempts->pluck('user_id')->unique()->count(),
            'attempts' => $attempts->count(),
            'average' => $attempts->isNotEmpty() ? round($attempts->avg('score_percentage'), 1) : 0,
            'pass_rate' => $attempts->isNotEmpty() ? round($attempts->where('passed', true)->count() / $attempts->count() * 100, 1) : 0,
        ];

        $enrollments = \App\Models\Enrollment::with('user', 'course')
            ->whereIn('course_id', $courseIds)->orderBy('course_id')->get();
        $manualGrades = GradeRecord::with(['student', 'course', 'module'])
            ->whereIn('course_id', $courseIds)->latest()->get();

        $allScores = $attempts->pluck('score_percentage')->merge($manualGrades->map(fn ($grade) => $grade->percentage));
        $allStudents = $attempts->pluck('user_id')->merge($manualGrades->pluck('student_id'))->unique();
        $passedScores = $attempts->filter->passed->count() + $manualGrades->filter(fn ($grade) => $grade->percentage >= 75)->count();
        $stats = [
            'students' => $allStudents->count(),
            'attempts' => $allScores->count(),
            'average' => $allScores->isNotEmpty() ? round($allScores->avg(), 1) : 0,
            'pass_rate' => $allScores->isNotEmpty() ? round($passedScores / $allScores->count() * 100, 1) : 0,
        ];

        $studentSummaries = $enrollments->groupBy('user_id')->map(function ($studentEnrollments, $studentId) use ($attempts, $manualGrades) {
            $courseIds = $studentEnrollments->pluck('course_id');
            $quizScores = $attempts->where('user_id', $studentId)->filter(function ($attempt) use ($courseIds) {
                $courseId = $attempt->quiz?->module?->course_id ?? $attempt->quiz?->subject?->course_id;
                return $courseIds->contains($courseId);
            })->groupBy('quiz_id')->map(fn ($rows) => (float) $rows->max('score_percentage'));
            $manualScores = $manualGrades->where('student_id', $studentId)->map(fn ($grade) => $grade->percentage);
            $scores = $quizScores->concat($manualScores);
            $average = $scores->isNotEmpty() ? round($scores->avg(), 1) : null;

            return [
                'student' => $studentEnrollments->first()->user,
                'courses' => $studentEnrollments->pluck('course.title')->filter()->unique()->values(),
                'average' => $average,
                'records' => $scores->count(),
                'needs_support' => $average !== null && $average < 75,
            ];
        })->values()->sortByDesc('needs_support')->values();

        return view('teacher.grades.index', compact('attempts', 'stats', 'courses', 'enrollments', 'manualGrades', 'studentSummaries'));
    }

    public function storeGrade(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'module_id' => ['nullable', 'exists:modules,id'],
            'assessment_type' => ['required', 'in:activity,assignment,exam,module'],
            'title' => ['required', 'string', 'max:255'],
            'score' => ['required', 'numeric', 'min:0'],
            'max_score' => ['required', 'numeric', 'gt:0'],
            'remarks' => ['nullable', 'string', 'max:5000'],
        ]);
        abort_unless($this->teacherCourses()->contains('id', (int) $validated['course_id']), 403);

        $enrollment = \App\Models\Enrollment::where('user_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->first();

        abort_if(! $enrollment, 422, 'This student is not enrolled in the selected course.');
        abort_if((float) $validated['score'] > (float) $validated['max_score'], 422, 'Score cannot exceed the maximum score.');

        $gradeRecord = GradeRecord::create($validated + ['graded_by' => auth()->id()]);
        $enrollment->update(['final_grade' => (float) $gradeRecord->percentage]);

        return back()->with('success', 'Grade recorded successfully.');
    }

    public function updateGrade(Request $request, GradeRecord $gradeRecord)
    {
        abort_unless($this->teacherCourses()->contains('id', $gradeRecord->course_id), 403);
        $validated = $request->validate(['score' => ['required', 'numeric', 'min:0'], 'max_score' => ['required', 'numeric', 'gt:0'], 'remarks' => ['nullable', 'string', 'max:5000']]);
        abort_if((float) $validated['score'] > (float) $validated['max_score'], 422, 'Score cannot exceed the maximum score.');

        $gradeRecord->update($validated);

        $enrollment = \App\Models\Enrollment::where('user_id', $gradeRecord->student_id)
            ->where('course_id', $gradeRecord->course_id)
            ->first();

        if ($enrollment) {
            $enrollment->update(['final_grade' => (float) $gradeRecord->fresh()->percentage]);
        }

        return back()->with('success', 'Grade updated successfully.');
    }

    private function teacherCourses()
    {
        $teacher = auth()->user();
        if ($teacher?->isAdmin()) {
            return \App\Models\Course::orderBy('title')->get();
        }

        return \App\Models\Course::where(function ($query) use ($teacher) {
            $query->where('instructor_id', $teacher->id)->orWhereHas('subjects', fn ($subject) => $subject->where('teacher_id', $teacher->id));
        })->orderBy('title')->get();
    }

    public function gradesEntry()
    {
        return redirect()->route('teacher.grades.index');
    }

    public function gradesPrint(Request $request)
    {
        $courses = $this->teacherCourses();
        $courseIds = $courses->pluck('id');
        $studentId = $request->integer('student_id') ?: null;

        $enrollments = \App\Models\Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->when($studentId, fn ($query) => $query->where('user_id', $studentId))
            ->orderBy('user_id')
            ->get();

        $manualGrades = GradeRecord::with(['student', 'course'])
            ->whereIn('course_id', $courseIds)
            ->when($studentId, fn ($query) => $query->where('student_id', $studentId))
            ->latest()
            ->get();

        $attempts = UserQuizAttempt::with(['user:id,name', 'quiz.module.course', 'quiz.subject.course'])
            ->whereNotNull('completed_at')
            ->when($studentId, fn ($query) => $query->where('user_id', $studentId))
            ->whereHas('quiz', function ($query) use ($courseIds) {
                $query->whereHas('module', fn ($module) => $module->whereIn('course_id', $courseIds))
                    ->orWhereHas('subject', fn ($subject) => $subject->whereIn('course_id', $courseIds));
            })
            ->latest('completed_at')
            ->get();

        $students = $enrollments->groupBy('user_id')->map(function ($studentEnrollments, $userId) use ($manualGrades, $attempts) {
            $studentManualGrades = $manualGrades->where('student_id', $userId);
            $studentAttempts = $attempts->where('user_id', $userId);
            $scores = $studentManualGrades->toBase()->map(fn ($grade) => (float) $grade->percentage)
                ->merge($studentAttempts->pluck('score_percentage')->map(fn ($score) => (float) $score));

            return [
                'student' => $studentEnrollments->first()->user,
                'courses' => $studentEnrollments->pluck('course.title')->filter()->unique()->values(),
                'records' => $studentManualGrades->toBase()->map(fn ($grade) => [
                    'course' => $grade->course?->title ?: '—',
                    'title' => $grade->title,
                    'type' => ucfirst($grade->assessment_type),
                    'score' => $grade->score,
                    'max_score' => $grade->max_score,
                    'percentage' => $grade->percentage,
                    'remarks' => $grade->remarks,
                ])->concat($studentAttempts->map(function ($attempt) {
                    $course = $attempt->quiz?->module?->course ?? $attempt->quiz?->subject?->course;

                    return [
                        'course' => $course?->title ?: '—',
                        'title' => $attempt->quiz?->title ?: 'Quiz',
                        'type' => 'Quiz',
                        'score' => null,
                        'max_score' => null,
                        'percentage' => (float) $attempt->score_percentage,
                        'remarks' => $attempt->passed ? 'Passed' : 'Needs improvement',
                    ];
                }))->values(),
                'average' => $scores->isNotEmpty() ? round($scores->avg(), 1) : null,
            ];
        })->values();

        return view('teacher.grades.print', compact('students', 'studentId'));
    }

    public function gradesReports()
    {
        $quizReports = UserQuizAttempt::query()
            ->join('quizzes', 'quizzes.id', '=', 'user_quiz_attempts.quiz_id')
            ->whereNotNull('user_quiz_attempts.completed_at')
            ->when(! auth()->user()?->isAdmin(), function ($query) {
                $query->where(function ($scope) {
                    $scope->whereHas('quiz.module.course', fn ($course) => $course->where('instructor_id', auth()->id()))
                        ->orWhereHas('quiz.subject', fn ($subject) => $subject->where('teacher_id', auth()->id()));
                });
            })
            ->select('quizzes.id', 'quizzes.title')
            ->selectRaw('COUNT(*) as attempts')
            ->selectRaw('COUNT(DISTINCT user_quiz_attempts.user_id) as students')
            ->selectRaw('ROUND(AVG(user_quiz_attempts.score_percentage), 1) as average_score')
            ->selectRaw('ROUND(AVG(CASE WHEN user_quiz_attempts.passed = 1 THEN 100 ELSE 0 END), 1) as pass_rate')
            ->groupBy('quizzes.id', 'quizzes.title')
            ->orderByDesc('attempts')
            ->get();

        return view('teacher.grades.reports', compact('quizReports'));
    }

    public function attendanceToday()
    {
        return view('teacher.attendance.today');
    }

    public function attendanceRecords()
    {
        return view('teacher.attendance.records');
    }

    public function attendanceReports()
    {
        return view('teacher.attendance.reports');
    }

    public function progressOverview()
    {
        return view('teacher.progress.overview');
    }

    public function progressIndividual()
    {
        return view('teacher.progress.individual');
    }

    public function progressAnalytics()
    {
        return view('teacher.progress.analytics');
    }
}
