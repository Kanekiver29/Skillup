<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function courseStats($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $userId = auth()->id();

        $this->authorize('view', $course);

        $modules = $course->modules()->with(['quizzes' => function ($query) {
            $query->where('is_published', true);
        }])->get();

        $stats = [
            'course_id' => $course->id,
            'course_title' => $course->title,
            'total_modules' => $modules->count(),
            'completed_modules' => 0,
            'modules' => [],
        ];

        foreach ($modules as $module) {
            $moduleProgress = $module->getProgress($userId);
            $stats['modules'][] = [
                'module_id' => $module->id,
                'module_title' => $module->title,
                'progress_percentage' => $moduleProgress,
                'total_quizzes' => $module->quizzes->count(),
                'completed_quizzes' => $module->quizzes->filter(function ($quiz) use ($userId) {
                    return $quiz->hasUserPassed($userId);
                })->count(),
                'quizzes' => $module->quizzes->map(function ($quiz) use ($userId) {
                    return [
                        'quiz_id' => $quiz->id,
                        'quiz_title' => $quiz->title,
                        'best_score' => $quiz->getUserBestScore($userId),
                        'has_passed' => $quiz->hasUserPassed($userId),
                        'attempt_count' => $quiz->getUserAttemptCount($userId),
                        'attempt_limit' => $quiz->attempt_limit,
                        'can_retry' => $quiz->canUserRetry($userId),
                        'passing_score' => $quiz->passing_score,
                    ];
                })->toArray(),
            ];

            if ($moduleProgress === 100) {
                $stats['completed_modules']++;
            }
        }

        $stats['course_progress_percentage'] = $modules->count() > 0 
            ? round($stats['completed_modules'] / $modules->count() * 100) 
            : 0;

        return response()->json($stats);
    }

    public function quizStats($courseSlug, $moduleSlug, $quizSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $quiz = $module->quizzes()->where('slug', $quizSlug)->firstOrFail();

        $userId = auth()->id();
        $this->authorize('view', $course);

        $attempts = $quiz->userAttempts($userId)->get();

        $stats = [
            'quiz_id' => $quiz->id,
            'quiz_title' => $quiz->title,
            'best_score' => $quiz->getUserBestScore($userId),
            'has_passed' => $quiz->hasUserPassed($userId),
            'attempt_count' => $quiz->getUserAttemptCount($userId),
            'attempt_limit' => $quiz->attempt_limit,
            'can_retry' => $quiz->canUserRetry($userId),
            'passing_score' => $quiz->passing_score,
            'attempts' => $attempts->map(function ($attempt) {
                return [
                    'attempt_id' => $attempt->id,
                    'attempt_number' => $attempt->attempt_number,
                    'score_percentage' => $attempt->score_percentage,
                    'correct_answers' => $attempt->correct_answers,
                    'total_questions' => $attempt->total_questions,
                    'passed' => $attempt->passed,
                    'time_spent' => $attempt->getFormattedTimeSpent(),
                    'completed_at' => $attempt->completed_at?->format('M d, Y H:i'),
                ];
            })->toArray(),
        ];

        return response()->json($stats);
    }

    public function userDashboardStats()
    {
        $userId = auth()->id();
        $user = User::findOrFail($userId);

        $enrollments = $user->enrollments()->with('course')->get();

        $stats = [
            'user_id' => $user->id,
            'user_name' => $user->full_name,
            'total_courses_enrolled' => $enrollments->count(),
            'completed_courses' => 0,
            'in_progress_courses' => 0,
            'total_quizzes_passed' => 0,
            'total_quizzes_failed' => 0,
            'courses' => [],
        ];

        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $courseProgress = $course->modules()->get()->avg(function ($module) use ($userId) {
                return $module->getProgress($userId);
            }) ?? 0;

            $courseStats = [
                'course_id' => $course->id,
                'course_title' => $course->title,
                'progress_percentage' => round($courseProgress),
                'modules' => $course->modules()->count(),
                'completed_modules' => 0,
            ];

            // Count stats
            if ($courseProgress === 100) {
                $stats['completed_courses']++;
            } else {
                $stats['in_progress_courses']++;
            }

            $stats['courses'][] = $courseStats;
        }

        // Calculate total quizzes
        $quizzes = \App\Models\Quiz::whereHas('module.course.enrollments', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('attempts')->get();

        foreach ($quizzes as $quiz) {
            if ($quiz->hasUserPassed($userId)) {
                $stats['total_quizzes_passed']++;
            } else {
                $attempts = $quiz->userAttempts($userId)->get();
                if ($attempts->count() > 0) {
                    $stats['total_quizzes_failed']++;
                }
            }
        }

        return response()->json($stats);
    }

    public function adminCourseStats($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        // Check if user is admin
        if (!auth()->user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $enrollments = $course->enrollments()->with('user')->get();
        $modules = $course->modules()->with('quizzes')->get();

        $stats = [
            'course_id' => $course->id,
            'course_title' => $course->title,
            'total_enrollments' => $enrollments->count(),
            'modules' => [],
            'user_progress' => [],
        ];

        // Module level stats
        foreach ($modules as $module) {
            $totalQuestions = $module->quizzes()->with('questions')->get()->sum(function ($quiz) {
                return $quiz->questions->count();
            });

            $stats['modules'][] = [
                'module_id' => $module->id,
                'module_title' => $module->title,
                'total_quizzes' => $module->quizzes->count(),
                'total_questions' => $totalQuestions,
            ];
        }

        // User progress
        foreach ($enrollments as $enrollment) {
            $userId = $enrollment->user_id;
            $moduleProgress = $modules->map(function ($module) use ($userId) {
                return $module->getProgress($userId);
            })->avg();

            $stats['user_progress'][] = [
                'user_id' => $enrollment->user->id,
                'user_name' => $enrollment->user->full_name,
                'email' => $enrollment->user->email,
                'overall_progress' => round($moduleProgress),
            ];
        }

        return response()->json($stats);
    }
}
