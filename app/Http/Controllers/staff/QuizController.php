<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAnswer;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function schedule()
    {
        $quizzes = Quiz::with(['module.course', 'subject'])
            ->where('is_archived', false)
            ->orderByRaw('scheduled_at IS NULL')
            ->orderBy('scheduled_at')
            ->orderBy('title')
            ->get();

        return view('staff.quizzes.schedule', compact('quizzes'));
    }

    public function results()
    {
        $results = UserQuizAttempt::with(['user', 'quiz'])
            ->latest('completed_at')
            ->paginate(25);

        return view('staff.quizzes.results', compact('results'));
    }

    public function index()
    {
        // Get both active and archived quizzes for filtering
        $quizzes = Quiz::with(['module.course'])
            ->where('is_archived', false)
            ->orderByDesc('created_at')
            ->get();
        
        $archivedCount = Quiz::where('is_archived', true)->count();
        
        return view('staff.quizzes.list', compact('quizzes', 'archivedCount'));
    }

    public function archived()
    {
        // Get archived quizzes
        $quizzes = Quiz::with(['module.course'])
            ->where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get();
        
        return view('staff.quizzes.archived', compact('quizzes'));
    }

    public function create()
    {
        $courses = Course::orderBy('title')->get();
        $modules = Module::orderBy('title')->get();
        return view('staff.quizzes.create', compact('courses', 'modules'));
    }

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

        $slugBase = Str::slug($validated['title']);
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

        return redirect()->route('staff.quizzes.questionnaire', $quiz)->with('success', 'Quiz created successfully. Add or edit the questionnaire now.');
    }

    public function questionnaire(Quiz $quiz)
    {
        $quiz->load(['questions.answers']);
        return view('staff.quizzes.questionnaire', compact('quiz'));
    }

    public function saveQuestionnaire(Request $request, Quiz $quiz)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*.question_text' => 'nullable|string|max:1000',
            'questions.*.points' => 'nullable|integer|min:1|max:20',
            'questions.*.answers' => 'required|array',
            'questions.*.answers.*.answer_text' => 'nullable|string|max:1000',
            'questions.*.correct' => 'nullable|integer|min:0|max:3',
        ]);

        $questionsInput = $request->input('questions', []);
        $existingQuestions = $quiz->questions()->with('answers')->get()->keyBy('order');

        foreach (range(0, 9) as $index) {
            $questionData = $questionsInput[$index] ?? [];
            $questionText = trim($questionData['question_text'] ?? '');
            $points = isset($questionData['points']) ? intval($questionData['points']) : 1;
            $answersInput = $questionData['answers'] ?? [];
            $correctIndex = isset($questionData['correct']) ? intval($questionData['correct']) : null;

            $allAnswersEmpty = true;
            for ($answerIndex = 0; $answerIndex < 4; $answerIndex++) {
                if (trim($answersInput[$answerIndex]['answer_text'] ?? '') !== '') {
                    $allAnswersEmpty = false;
                    break;
                }
            }

            if ($questionText === '' && $allAnswersEmpty) {
                if ($existingQuestions->has($index)) {
                    $existingQuestions->get($index)->delete();
                }
                continue;
            }

            $question = $existingQuestions->has($index)
                ? $existingQuestions->get($index)
                : new QuizQuestion(['quiz_id' => $quiz->id, 'order' => $index, 'type' => 'multiple_choice']);

            $question->question_text = $questionText ?: 'Question ' . ($index + 1);
            $question->points = $points;
            $question->type = 'multiple_choice';
            $question->order = $index;
            $question->save();

            $existingAnswers = $question->answers()->get()->keyBy('order');
            for ($answerIndex = 0; $answerIndex < 4; $answerIndex++) {
                $answerText = trim($answersInput[$answerIndex]['answer_text'] ?? '');
                $isCorrect = $correctIndex === $answerIndex;

                if ($existingAnswers->has($answerIndex)) {
                    $answer = $existingAnswers->get($answerIndex);
                    if ($answerText === '') {
                        $answer->delete();
                        continue;
                    }
                    $answer->answer_text = $answerText;
                    $answer->is_correct = $isCorrect;
                    $answer->order = $answerIndex;
                    $answer->save();
                } elseif ($answerText !== '') {
                    QuizQuestionAnswer::create([
                        'quiz_question_id' => $question->id,
                        'answer_text' => $answerText,
                        'is_correct' => $isCorrect,
                        'order' => $answerIndex,
                    ]);
                }
            }

            $question->answers()->where('order', '>', 3)->delete();
        }

        return redirect()->route('staff.quizzes.questionnaire', $quiz)->with('success', 'Questionnaire saved successfully.');
    }

    public function edit(Quiz $quiz)
    {
        $courses = Course::orderBy('title')->get();
        $modules = Module::orderBy('title')->get();
        return view('staff.quizzes.edit', compact('quiz', 'courses', 'modules'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'module_id' => 'nullable|exists:modules,id',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'time_limit_minutes' => 'nullable|integer|min:0',
        ]);

        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'module_id' => $validated['module_id'] ?? null,
            'passing_score' => $validated['passing_score'] ?? 0,
            'time_limit_minutes' => $validated['time_limit_minutes'] ?? null,
        ]);

        return redirect()->route('staff.quizzes.edit', $quiz)->with('success', 'Quiz updated successfully.');
    }

    public function archive(Quiz $quiz)
    {
        $quiz->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);
        return redirect()->route('staff.quizzes.list')->with('success', 'Quiz archived successfully.');
    }

    public function restore(Quiz $quiz)
    {
        $quiz->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);
        return redirect()->route('staff.quizzes.list')->with('success', 'Quiz restored successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('staff.quizzes.list')->with('success', 'Quiz deleted successfully.');
    }
}
