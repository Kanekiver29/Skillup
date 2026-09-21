<?php

namespace App\Http\Controllers;

use App\Models\UserQuizAttempt;

class StudentGradeController extends Controller
{
    public function index()
    {
        $attempts = UserQuizAttempt::with(['quiz.module.course', 'quiz.subject'])
            ->where('user_id', auth()->id())
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->get();

        $grades = $attempts
            ->groupBy('quiz_id')
            ->map(fn ($quizAttempts) => $quizAttempts->sortByDesc('score_percentage')->first())
            ->sortByDesc('completed_at')
            ->values();

        $average = $grades->isNotEmpty() ? round($grades->avg('score_percentage'), 1) : 0;
        $passed = $grades->where('passed', true)->count();

        return view('Userpage.course.grades', [
            'grades' => $grades,
            'average' => $average,
            'passed' => $passed,
            'totalAssessments' => $grades->count(),
        ]);
    }
}