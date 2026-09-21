<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\UserQuizAttempt;
use App\Models\UserQuizResponse;
use App\Models\Subject;
use App\Models\Major;
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

        if ($quiz->is_trivia && (! $quiz->is_published || ($quiz->scheduled_at && $quiz->scheduled_at->isFuture()))) {
            abort(404);
        }

        $userId = auth()->id();

        // Check if user can retry
        if (!$quiz->canUserRetry($userId)) {
            return redirect()->back()->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Create a new attempt
        $attemptNumber = $quiz->getUserAttemptCount($userId) + 1;
        $questions = $quiz->randomize_questions
            ? $quiz->questions()->inRandomOrder()->get()
            : $quiz->questions()->get();
        if ($quiz->question_count) {
            $questions = $questions->take($quiz->question_count)->values();
        }
        $totalQuestions = $questions->count();

        if ($totalQuestions === 0) {
            return redirect()->route('quizzes.show', [$courseSlug, $moduleSlug, $quizSlug])
                ->with('error', 'This quiz has no questions yet. Please try again later.');
        }

        $attempt = UserQuizAttempt::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'attempt_number' => $attemptNumber,
            'total_questions' => $totalQuestions,
            'question_ids' => $questions->pluck('id')->all(),
            'started_at' => now(),
        ]);

        session()->put('quiz_attempt_questions.' . $attempt->id, $questions->pluck('id')->all());

        return view('courses.quizzes.attempt', [
            'course' => $course,
            'module' => $module,
            'quiz' => $quiz,
            'attempt' => $attempt,
            'questions' => $questions,
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

        if ($attempt->completed_at) {
            return redirect()->route('quizzes.results', [
                'courseSlug' => $courseSlug,
                'moduleSlug' => $moduleSlug,
                'quizSlug' => $quizSlug,
                'attemptId' => $attempt->id,
            ]);
        }

        // Calculate score
        $correctQuestionCount = 0;
        $awardedPoints = 0;
        $questionIds = $attempt->question_ids;
        $questions = $questionIds
            ? $quiz->questions()->whereIn('id', $questionIds)->get()->sortBy(fn ($question) => array_search($question->id, $questionIds))->values()
            : $quiz->questions()->get();
        $totalPoints = $questions->sum('points');
        $responses = $request->input('responses', []);
        foreach ($questions as $question) {
            $questionId = $question->id;
            $answer = $responses[$questionId] ?? null;

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
                    $answerId = is_numeric($answer) ? (int) $answer : null;
                    $selectedAnswer = $answerId ? $question->answers()->find($answerId) : null;
                    if ($selectedAnswer && $selectedAnswer->is_correct) {
                        $isCorrect = true;
                        $pointsAwarded = $question->points;
                    }
                }
            } else {
                // short answer - stored for review, no auto grading
                $pointsAwarded = 0;
            }

            if ($isCorrect) {
                $correctQuestionCount++;
            }
            $awardedPoints += $pointsAwarded;

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
        $scorePercentage = $totalPoints > 0 ? round(($awardedPoints / $totalPoints) * 100) : 0;
        $passed = $scorePercentage >= $quiz->passing_score;
        $timeSpent = now()->diffInSeconds($attempt->started_at);

        $attempt->update([
            'correct_answers' => $correctQuestionCount,
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
        $user = auth()->user();
        $courses = $user?->isAdmin()
            ? Course::orderBy('title')->get()
            : Course::where('instructor_id', $user->id)->orderBy('title')->get();
        $modules = Module::with('course')
            ->when(! $user?->isAdmin(), fn ($query) => $query->whereHas('course', fn ($course) => $course->where('instructor_id', $user->id)))
            ->orderBy('title')
            ->get();
        $subjects = Subject::with('course')
            ->when(! $user?->isAdmin(), fn ($query) => $query->where('teacher_id', $user->id)->orWhereHas('course', fn ($course) => $course->where('instructor_id', $user->id)))
            ->orderBy('title')
            ->get();
        $majors = Major::where('is_active', true)->orderBy('name')->get();
        return view('teacher.quizzes.create', compact('courses', 'modules', 'subjects', 'majors'));
    }

    /**
     * List trivia games grouped by the modules the teacher manages.
     */
    public function triviaGames()
    {
        $user = auth()->user();
        $modules = Module::with([
            'course',
            'quizzes' => fn ($query) => $query->where('is_trivia', true)->withCount('questions')->latest(),
        ])
            ->when(! $user?->isAdmin(), fn ($query) => $query->whereHas('course', fn ($course) => $course->where('instructor_id', $user->id)))
            ->whereHas('quizzes', fn ($query) => $query->where('is_trivia', true))
            ->orderBy('title')
            ->get();

        return view('teacher.quizzes.trivia', compact('modules'));
    }

    /**
     * Show the quiz in the teacher UI (by id)
     */
    public function showTeacher(Quiz $quiz)
    {
        $this->authorizeTeacherQuiz($quiz);
        $quiz->load(['questions.answers', 'module.course', 'subject.course', 'major']);

        $attempts = $quiz->attempts()
            ->with(['user:id,name', 'responses.question.answers', 'responses.answer'])
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->get();

        $leaderboard = $attempts
            ->sortByDesc(fn ($attempt) => [$attempt->score_percentage ?? 0, -($attempt->time_spent_seconds ?? PHP_INT_MAX)])
            ->values()
            ->map(function ($attempt, $index) {
                $attempt->leaderboard_rank = $index + 1;
                return $attempt;
            });

        $participationStats = [
            'participants' => $attempts->pluck('user_id')->unique()->count(),
            'attempts' => $attempts->count(),
            'average_score' => $attempts->isNotEmpty() ? round($attempts->avg('score_percentage'), 1) : 0,
            'pass_rate' => $attempts->isNotEmpty() ? round($attempts->where('passed', true)->count() / $attempts->count() * 100, 1) : 0,
            'average_time' => $attempts->isNotEmpty() ? round($attempts->avg('time_spent_seconds')) : 0,
        ];

        $answerReview = $attempts->flatMap(function ($attempt) {
            return $attempt->responses->map(function ($response) use ($attempt) {
                return compact('attempt', 'response');
            });
        });

        return view('teacher.quizzes.show', compact('quiz', 'attempts', 'leaderboard', 'participationStats', 'answerReview'));
    }

    /**
     * Edit quiz (teacher)
     */
    public function edit(Quiz $quiz)
    {
        $this->authorizeTeacherQuiz($quiz);
        $subjects = Subject::with('course')->orderBy('title')->get();
        $majors = Major::where('is_active', true)->orderBy('name')->get();
        return view('teacher.quizzes.edit', compact('quiz', 'subjects', 'majors'));
    }

    /**
     * Update quiz (teacher)
     */
    public function update(Request $request, Quiz $quiz)
    {
        $this->authorizeTeacherQuiz($quiz);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'nullable|exists:subjects,id',
            'is_trivia' => 'sometimes|boolean',
            'major_id' => 'nullable|exists:majors,id',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'question_count' => 'nullable|integer|min:1|max:100',
            'question_time_limit_seconds' => 'nullable|integer|min:5|max:3600',
            'scheduled_at' => 'nullable|date',
            'is_published' => 'sometimes|boolean',
        ]);

        if (! empty($validated['subject_id']) && $quiz->module?->course_id) {
            $subject = Subject::findOrFail($validated['subject_id']);
            if ((int) $subject->course_id !== (int) $quiz->module->course_id) {
                return back()->withErrors(['subject_id' => 'The selected subject must belong to this quiz course.'])->withInput();
            }
        }

        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'subject_id' => $validated['subject_id'] ?? null,
            'is_trivia' => $request->boolean('is_trivia'),
            'major_id' => $validated['major_id'] ?? null,
            'difficulty' => $validated['difficulty'] ?? null,
            'question_count' => $validated['question_count'] ?? null,
            'question_time_limit_seconds' => $validated['question_time_limit_seconds'] ?? null,
            'scheduled_at' => $validated['scheduled_at'] ?? null,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('teacher.quizzes.edit', $quiz->id)->with('success', 'Quiz updated. You can now manage questions.');
    }

    /**
     * Add one questionnaire item to a teacher quiz.
     */
    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $this->authorizeTeacherQuiz($quiz);
        $validated = $request->validate([
            'type' => 'required|in:multiple_choice,true_false,short_answer',
            'question_text' => 'required|string|max:5000',
            'explanation' => 'nullable|string|max:5000',
            'points' => 'required|integer|min:1|max:100',
            'answers' => 'nullable|array|max:6',
            'answers.*.text' => 'nullable|string|max:1000',
            'correct_answer' => 'nullable|integer|min:0|max:5',
        ]);

        $type = $validated['type'];
        $answers = collect($validated['answers'] ?? [])
            ->map(fn ($answer) => trim((string) ($answer['text'] ?? '')))
            ->filter()
            ->values();

        if ($type === 'multiple_choice' && $answers->count() < 2) {
            return back()->withErrors(['answers' => 'Multiple-choice questions need at least two answer choices.'])->withInput();
        }

        if ($type === 'true_false') {
            $answers = collect(['True', 'False']);
        }

        if ($type !== 'short_answer') {
            $correctIndex = (int) ($validated['correct_answer'] ?? -1);
            if ($correctIndex < 0 || ! $answers->has($correctIndex)) {
                return back()->withErrors(['correct_answer' => 'Select the correct answer.'])->withInput();
            }
        }

        $question = $quiz->questions()->create([
            'type' => $type,
            'question_text' => $validated['question_text'],
            'explanation' => $validated['explanation'] ?? null,
            'points' => $validated['points'],
            'order' => ((int) $quiz->questions()->max('order')) + 1,
        ]);

        foreach ($answers as $index => $answerText) {
            $question->answers()->create([
                'answer_text' => $answerText,
                'is_correct' => $type !== 'short_answer' && $index === (int) $validated['correct_answer'],
                'order' => $index,
            ]);
        }

        return redirect()->route('teacher.quizzes.edit', $quiz->id)->with('success', 'Question added to the questionnaire.');
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
            'module_id' => 'required|exists:modules,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'time_limit_minutes' => 'nullable|integer|min:0',
            'is_trivia' => 'sometimes|boolean',
            'major_id' => 'nullable|exists:majors,id',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'question_count' => 'nullable|integer|min:1|max:100',
            'question_time_limit_seconds' => 'nullable|integer|min:5|max:3600',
            'scheduled_at' => 'nullable|date',
            'is_published' => 'sometimes|boolean',
        ]);

        if (! empty($validated['subject_id'])) {
            $subject = Subject::findOrFail($validated['subject_id']);
            if (! empty($validated['course_id']) && (int) $subject->course_id !== (int) $validated['course_id']) {
                return back()->withErrors(['subject_id' => 'The selected subject must belong to the selected course.'])->withInput();
            }
        }

        if ($request->boolean('is_trivia') && empty($validated['module_id'])) {
            return back()->withErrors(['module_id' => 'Trivia games must be assigned to a module.'])->withInput();
        }

        $module = Module::with('course')->findOrFail($validated['module_id']);
        $moduleCourseId = (int) $module->course_id;

        if (! empty($validated['course_id']) && $moduleCourseId !== (int) $validated['course_id']) {
            return back()->withErrors(['module_id' => 'The selected module must belong to the selected course.'])->withInput();
        }

        $validated['course_id'] = $moduleCourseId;

        if (! empty($validated['subject_id'])) {
            $subject = Subject::findOrFail($validated['subject_id']);
            if ((int) $subject->course_id !== $moduleCourseId) {
                return back()->withErrors(['subject_id' => 'The selected subject must belong to the selected module course.'])->withInput();
            }
        }

        $this->authorizeQuizPlacement($validated);

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
            'subject_id' => $validated['subject_id'] ?? null,
            'passing_score' => $validated['passing_score'] ?? 0,
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? null,
            'is_trivia' => $request->boolean('is_trivia'),
            'major_id' => $validated['major_id'] ?? null,
            'difficulty' => $validated['difficulty'] ?? null,
            'question_count' => $validated['question_count'] ?? null,
            'question_time_limit_seconds' => $validated['question_time_limit_seconds'] ?? null,
            'scheduled_at' => $validated['scheduled_at'] ?? null,
            'slug' => $slug,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('teacher.quizzes.edit', $quiz->id)->with('success', 'Quiz created. Add questions to build the questionnaire.');
    }

    private function authorizeTeacherQuiz(Quiz $quiz): void
    {
        $user = auth()->user();
        if ($user?->isAdmin()) {
            return;
        }

        $canManage = Quiz::query()->whereKey($quiz->id)
            ->where(function ($query) use ($user) {
                $query->whereHas('module.course', fn ($course) => $course->where('instructor_id', $user->id))
                    ->orWhereHas('subject', fn ($subject) => $subject->where('teacher_id', $user->id));
            })
            ->exists();

        abort_unless($canManage, 403);
    }

    private function authorizeQuizPlacement(array $validated): void
    {
        $user = auth()->user();
        if ($user?->isAdmin()) {
            return;
        }

        if (! empty($validated['module_id'])) {
            $ownedModule = Module::whereKey($validated['module_id'])
                ->whereHas('course', fn ($course) => $course->where('instructor_id', $user->id))
                ->exists();
            abort_unless($ownedModule, 403);
        }

        if (! empty($validated['course_id'])) {
            abort_unless(Course::whereKey($validated['course_id'])->where('instructor_id', $user->id)->exists(), 403);
        }

        if (! empty($validated['subject_id'])) {
            $ownedSubject = Subject::whereKey($validated['subject_id'])
                ->where(function ($query) use ($user) {
                    $query->where('teacher_id', $user->id)
                        ->orWhereHas('course', fn ($course) => $course->where('instructor_id', $user->id));
                })
                ->exists();
            abort_unless($ownedSubject, 403);
        }
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
