<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\Course;
use App\Models\UserQuizAttempt;
use App\Models\UserQuizResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show($courseSlug, $moduleSlug, $quizSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $quiz = $module->quizzes()->where('slug', $quizSlug)->firstOrFail();

        $this->authorize('view', $course);

        $userId = auth()->id();
        $userAttempts = $quiz->userAttempts($userId)->get();
        $bestScore = $quiz->getUserBestScore($userId);
        $hasUserPassed = $quiz->hasUserPassed($userId);
        $canRetry = $quiz->canUserRetry($userId);
        $attemptCount = $quiz->getUserAttemptCount($userId);

        return view('courses.quizzes.show', [
            'course' => $course,
            'module' => $module,
            'quiz' => $quiz,
            'userAttempts' => $userAttempts,
            'bestScore' => $bestScore,
            'hasUserPassed' => $hasUserPassed,
            'canRetry' => $canRetry,
            'attemptCount' => $attemptCount,
        ]);
    }

    public function start($courseSlug, $moduleSlug, $quizSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $quiz = $module->quizzes()->where('slug', $quizSlug)->firstOrFail();

        $this->authorize('view', $course);

        $userId = auth()->id();

        // Check if user can retry
        if (!$quiz->canUserRetry($userId)) {
            return redirect()->back()->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Create a new attempt
        $attemptNumber = $quiz->getUserAttemptCount($userId) + 1;
        $totalQuestions = $quiz->questions()->count();

        $attempt = UserQuizAttempt::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'attempt_number' => $attemptNumber,
            'total_questions' => $totalQuestions,
            'started_at' => now(),
        ]);

        return view('courses.quizzes.attempt', [
            'course' => $course,
            'module' => $module,
            'quiz' => $quiz,
            'attempt' => $attempt,
            'questions' => $quiz->randomize_questions 
                ? $quiz->questions()->inRandomOrder()->get()
                : $quiz->questions()->get(),
        ]);
    }

    public function submitAttempt(Request $request, $courseSlug, $moduleSlug, $quizSlug)
    {
        $userId = auth()->id();
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $quiz = $module->quizzes()->where('slug', $quizSlug)->firstOrFail();

        $this->authorize('view', $course);

        $attemptId = $request->input('attempt_id');
        $attempt = UserQuizAttempt::findOrFail($attemptId);

        if ($attempt->user_id !== $userId || $attempt->quiz_id !== $quiz->id) {
            return redirect()->back()->with('error', 'Invalid attempt.');
        }

        // Calculate score
        $correctAnswers = 0;
        $totalPoints = 0;
        $responses = $request->input('responses', []);

        foreach ($responses as $questionId => $answer) {
            $question = $quiz->questions()->findOrFail($questionId);
            $totalPoints += $question->points;

            $isCorrect = false;
            $answerId = null;

            if ($question->type !== 'short_answer') {
                $answerId = $answer;
                $selectedAnswer = $question->answers()->find($answer);
                if ($selectedAnswer && $selectedAnswer->is_correct) {
                    $isCorrect = true;
                    $correctAnswers += $question->points;
                }
            } else {
                // For short answer, store the text response
                // In a real scenario, you'd need admin review or AI-based checking
            }

            UserQuizResponse::create([
                'user_quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $questionId,
                'quiz_question_answer_id' => $answerId,
                'answer_text' => $question->type === 'short_answer' ? $answer : null,
                'is_correct' => $isCorrect,
                'answered_at' => now(),
            ]);
        }

        // Update attempt
        $scorePercentage = $totalPoints > 0 ? round(($correctAnswers / $totalPoints) * 100) : 0;
        $passed = $scorePercentage >= $quiz->passing_score;
        $timeSpent = now()->diffInSeconds($attempt->started_at);

        $attempt->update([
            'correct_answers' => $correctAnswers,
            'score_percentage' => $scorePercentage,
            'passed' => $passed,
            'completed_at' => now(),
            'time_spent_seconds' => $timeSpent,
        ]);

        return redirect()->route('quizzes.results', [
            'courseSlug' => $courseSlug,
            'moduleSlug' => $moduleSlug,
            'quizSlug' => $quizSlug,
            'attemptId' => $attempt->id,
        ])->with('success', 'Quiz completed successfully!');
    }

    public function results($courseSlug, $moduleSlug, $quizSlug, $attemptId)
    {
        $userId = auth()->id();
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $quiz = $module->quizzes()->where('slug', $quizSlug)->firstOrFail();

        $this->authorize('view', $course);

        $attempt = UserQuizAttempt::findOrFail($attemptId);

        if ($attempt->user_id !== $userId || $attempt->quiz_id !== $quiz->id) {
            return redirect()->back()->with('error', 'Invalid attempt.');
        }

        $responses = $attempt->responses()->with('question', 'answer')->get();

        return view('courses.quizzes.results', [
            'course' => $course,
            'module' => $module,
            'quiz' => $quiz,
            'attempt' => $attempt,
            'responses' => $responses,
            'showCorrectAnswers' => $quiz->show_correct_answers,
        ]);
    }
}
