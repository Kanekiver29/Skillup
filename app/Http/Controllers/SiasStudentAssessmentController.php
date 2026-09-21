<?php

namespace App\Http\Controllers;

use App\Models\UserQuizAttempt;
use App\Models\Quiz;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiasStudentAssessmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ── Completed quiz attempts ──────────────────────────────────────
        $completedAttempts = UserQuizAttempt::with(['quiz.module'])
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->get()
            ->map(function ($attempt) {
                $quiz   = $attempt->quiz;
                $module = $quiz?->module;
                return [
                    'id'            => $attempt->id,
                    'quiz_title'    => $quiz?->title ?? 'Quiz',
                    'module_title'  => $module?->title ?? '—',
                    'score'         => round($attempt->score_percentage ?? 0, 1),
                    'correct'       => $attempt->correct_answers ?? 0,
                    'total'         => $attempt->total_questions  ?? 0,
                    'passed'        => (bool) $attempt->passed,
                    'passing_score' => $quiz?->passing_score ?? 75,
                    'time_spent'    => $attempt->getFormattedTimeSpent(),
                    'attempt_no'    => $attempt->attempt_number ?? 1,
                    'completed_at'  => $attempt->completed_at?->format('M d, Y g:i A') ?? '—',
                    'xp'            => $attempt->xp_awarded ?? 0,
                ];
            });

        // ── In-progress (started but not completed) ──────────────────────
        $inProgress = UserQuizAttempt::with(['quiz.module'])
            ->where('user_id', $user->id)
            ->whereNull('completed_at')
            ->orderByDesc('started_at')
            ->get()
            ->map(function ($attempt) {
                $quiz = $attempt->quiz;
                return [
                    'id'           => $attempt->id,
                    'quiz_title'   => $quiz?->title ?? 'Quiz',
                    'module_title' => $quiz?->module?->title ?? '—',
                    'quiz_slug'    => $quiz?->slug ?? '',
                    'module_slug'  => $quiz?->module?->slug ?? '',
                    'course_slug'  => $quiz?->module?->course?->slug ?? '',
                    'started_at'   => $attempt->started_at?->format('M d, Y g:i A') ?? '—',
                    'time_limit'   => $quiz?->time_limit_minutes,
                ];
            });

        // ── Summary stats ────────────────────────────────────────────────
        $totalAttempts = $completedAttempts->count();
        $passed        = $completedAttempts->where('passed', true)->count();
        $avgScore      = $totalAttempts > 0
            ? round($completedAttempts->avg('score'), 1)
            : null;
        $totalXp       = $completedAttempts->sum('xp');

        // ── Upcoming / available quizzes not yet attempted ───────────────
        $attemptedQuizIds = UserQuizAttempt::where('user_id', $user->id)
            ->pluck('quiz_id')->unique()->toArray();

        $enrolledCourseIds = $user->enrollments()->pluck('course_id')->toArray();

        $upcoming = Quiz::with('module')
            ->where('is_published', true)
            ->whereHas('module', function ($q) use ($enrolledCourseIds) {
                $q->whereIn('course_id', $enrolledCourseIds);
            })
            ->whereNotIn('id', $attemptedQuizIds)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($quiz) {
                $module = $quiz->module;
                return [
                    'quiz_title'   => $quiz->title,
                    'module_title' => $module?->title ?? '—',
                    'course_slug'  => $module?->course?->slug ?? '',
                    'module_slug'  => $module?->slug ?? '',
                    'quiz_slug'    => $quiz->slug,
                    'time_limit'   => $quiz->time_limit_minutes,
                    'passing_score'=> $quiz->passing_score,
                    'attempt_limit'=> $quiz->attempt_limit,
                ];
            });

        return view('sias.students.assessment.index', compact(
            'user', 'completedAttempts', 'inProgress',
            'upcoming', 'totalAttempts', 'passed', 'avgScore', 'totalXp'
        ));
    }
}
