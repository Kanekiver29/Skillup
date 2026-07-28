<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\Course;
use App\Models\Enrollment;
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
            $pointsAwarded = 0;

            if ($question->type !== 'short_answer') {
                $correctAnswerIds = $question->answers()->where('is_correct', true)->pluck('id')->toArray();

                if (is_array($answer)) {
                    // multiple selection - partial credit allowed
                    $selected = array_map('intval', $answer);
                    $intersection = array_intersect($selected, $correctAnswerIds);
                    $correctCount = count($correctAnswerIds) ?: 1;
                    $pointsAwarded = round(($question->points) * (count($intersection) / $correctCount));
                    $isCorrect = (count($intersection) === $correctCount) && count(array_diff($selected, $correctAnswerIds)) === 0;
                    $answerId = $selected[0] ?? null;
                } else {
                    $answerId = $answer;
                    $selectedAnswer = $question->answers()->find($answer);
                    if ($selectedAnswer && $selectedAnswer->is_correct) {
                        $isCorrect = true;
                        $pointsAwarded = $question->points;
                    }
                }
            } else {
                // short answer - stored for review, no auto grading
                $pointsAwarded = 0;
            }

            // accumulate awarded points
            $correctAnswers += $pointsAwarded;

            UserQuizResponse::create([
                'user_quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $questionId,
                'quiz_question_answer_id' => $answerId,
                'answer_text' => $question->type === 'short_answer' ? $answer : (is_array($answer) ? json_encode($answer) : null),
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

        // Broadcast quiz submission
        try {
            event(new \App\Events\QuizSubmitted($attempt));
        } catch (\Throwable $e) {
            // non-fatal
        }

        // Award XP based on score (rounded to nearest 10, minimum 5)
        try {
            $user = auth()->user();
            if ($user) {
                $xpEarned = max(5, round($scorePercentage / 10) * 10);
                $attempt->xp_awarded = $xpEarned;
                $attempt->save();
                $user->addXp($xpEarned);
            }
        } catch (\Throwable $e) {
            // non-fatal
        }

        // Check and award badges based on quiz/module/course completion
        $newBadges = BadgeController::checkAndAwardBadges($userId, $quiz);
        $courseCompleted = $this->syncEnrollmentProgress($userId, $course);

        $flashMessage = 'Quiz completed successfully!';
        if (!empty($newBadges)) {
            $badgeNames = collect($newBadges)->pluck('name')->join(', ');
            $flashMessage .= ' You earned new badge(s): ' . $badgeNames . '!';
        }
        if ($courseCompleted) {
            $flashMessage .= ' Congratulations! Your course certificate is now unlocked.';
        }

        return redirect()->route('quizzes.results', [
            'courseSlug' => $courseSlug,
            'moduleSlug' => $moduleSlug,
            'quizSlug' => $quizSlug,
            'attemptId' => $attempt->id,
        ])->with('success', $flashMessage);
    }

    public function results($courseSlug, $moduleSlug, $quizSlug, $attemptId)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $quiz = $module->quizzes()->where('slug', $quizSlug)->firstOrFail();

        $this->authorize('view', $course);

        $userId = auth()->id();
        $attempt = UserQuizAttempt::with(['responses.question.answers', 'responses.answer', 'quiz'])
            ->where('id', $attemptId)
            ->where('user_id', $userId)
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        $responses = $attempt->responses()->with(['question.answers', 'answer'])->get();
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();
        $isCourseCompleted = $enrollment ? (bool) $enrollment->completed : false;
        $showCorrectAnswers = true;

        return view('courses.quizzes.results', compact(
            'course',
            'module',
            'quiz',
            'attempt',
            'responses',
            'isCourseCompleted',
            'showCorrectAnswers'
        ));
    }

    /**
    * Show creation form for a new quiz.
    */
    public function create()
    {
        $courses = Course::all();
        $modules = Module::all();
        return view('teacher.quizzes.create', compact('courses', 'modules'));
    }

    /**
     * Show the quiz in the teacher UI (by id)
     */
    public function showTeacher(Quiz $quiz)
    {
        // load questions relationship for teacher view
        $quiz->load('questions');
        return view('teacher.quizzes.show', compact('quiz'));
    }

    /**
     * Edit quiz (teacher)
     */
    public function edit(Quiz $quiz)
    {
        return view('teacher.quizzes.edit', compact('quiz'));
    }

    /**
     * Update quiz (teacher)
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('teacher.quizzes.edit', $quiz->id)->with('success', 'Quiz updated. You can now manage questions.');
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'module_id' => 'nullable|exists:modules,id',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'time_limit_minutes' => 'nullable|integer|min:0',
        ]);

        // Create slug and ensure uniqueness
        $slugBase = \Illuminate\Support\Str::slug($validated['title']);
        $slug = $slugBase;
        $i = 1;
        while (Quiz::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $i++;
        }

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'module_id' => $validated['module_id'] ?? null,
            'passing_score' => $validated['passing_score'] ?? 0,
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? null,
            'slug' => $slug,
            'is_published' => false,
        ]);

        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz created successfully.');
    }


    /**
     * Update enrollment progress/completion based on passed quizzes in published modules.
     */
    private function syncEnrollmentProgress(int $userId, Course $course): bool
    {
        $publishedModules = $course->modules()->where('is_published', true)->get();
        $totalModules = $publishedModules->count();
        $completedModules = $publishedModules
            ->filter(fn($module) => $module->getProgress($userId) === 100)
            ->count();

        $progress = $totalModules > 0 ? (int) round(($completedModules / $totalModules) * 100) : 0;
        $completed = $totalModules > 0 && $completedModules === $totalModules;

        $enrollment = Enrollment::firstOrCreate([
            'user_id' => $userId,
            'course_id' => $course->id,
        ]);

        $enrollment->update([
            'progress' => $progress,
            'completed' => $completed,
            'completed_at' => $completed
                ? ($enrollment->completed_at ?? now())
                : null,
        ]);

        return $completed;
    }
}
