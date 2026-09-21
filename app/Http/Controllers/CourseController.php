<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\Quiz;
use App\Models\TriviaQuickPlayScore;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\EnrollmentCreated;

class CourseController extends Controller
{
    /**
     * Display all courses.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $designatedCourse = $user->designatedCourse();

            if ($designatedCourse) {
                return redirect()->route('courses.show', $designatedCourse->slug);
            }
        }

        $selectedCourseId = $request->query('course_id');
        $query = Course::where('is_published', true);

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Level filter
        if ($request->has('level') && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        // Category filter
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $courses = $query->withCount('likes')->paginate(12);

        $enrolledCourses = Auth::check()
            ? Course::where('is_published', true)
                ->whereHas('enrollments', function ($enrollmentQuery) {
                    $enrollmentQuery->where('user_id', Auth::id())
                        ->where(function ($statusQuery) {
                            $statusQuery->whereIn('status', ['active', 'approved'])
                                ->orWhereNull('status');
                        });
                })
                ->when($selectedCourseId, function ($courseQuery, $courseId) {
                    return $courseQuery->where('id', $courseId);
                })
                ->with([
                    'subjects.teacher',
                    'modules' => function ($moduleQuery) {
                        $moduleQuery->where('is_published', true)
                            ->orderBy('order')
                            ->with([
                                'lessons' => fn ($lessonQuery) => $lessonQuery
                                    ->where('is_published', true)
                                    ->orderBy('order'),
                                'quizzes' => fn ($quizQuery) => $quizQuery
                                    ->where('is_published', true)
                                    ->where('is_archived', false)
                                    ->orderBy('order'),
                            ]);
                    },
                ])
                ->withCount('likes')
                ->orderBy('title')
                ->get()
            : collect();

        $selectedCourse = $enrolledCourses->firstWhere('id', (int) $selectedCourseId) ?? $enrolledCourses->first();

        $enrollment = Auth::check() && $selectedCourse
            ? Enrollment::where('user_id', Auth::id())
                ->where('course_id', $selectedCourse->id)
                ->first()
            : null;
        
        // Get all unique categories for filter dropdown
        $categories = Course::where('is_published', true)
            ->distinct()
            ->pluck('category')
            ->sort();

        return view('Userpage.course.course', compact('courses', 'categories', 'enrolledCourses', 'enrollment', 'selectedCourse'));
    }

    /**
     * Display a specific course.
     */
    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->with([
                'lessons' => function ($query) {
                    $query->where('is_published', true)->orderBy('order');
                },
                'subjects.teacher',
                'modules' => function ($query) {
                    $query->where('is_published', true)
                          ->orderBy('order')
                          ->with([
                              'lessons' => function ($query) {
                                  $query->where('is_published', true);
                              },
                              'quizzes' => function ($query) {
                                  $query->where('is_published', true)
                                      ->where('is_archived', false)
                                      ->orderBy('order');
                              },
                          ]);
                },
            ])
            ->firstOrFail();

        $enrollment = Auth::check()
            ? Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first()
            : null;

        $isEnrolled = (bool) $enrollment;

        return view('Userpage.course.course', [
            'course' => $course,
            'selectedCourse' => $course,
            'enrolledCourses' => $isEnrolled ? collect([$course]) : collect(),
            'isEnrolled' => $isEnrolled,
            'enrollment' => $enrollment,
        ]);
    }

    /**
     * Enroll user in a course.
     */
    public function enroll($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $course->id,
            ]
        );

        // Broadcast enrollment for realtime dashboards
        try {
            event(new EnrollmentCreated($enrollment));
        } catch (\Throwable $e) {
            // ignore broadcast failures
        }

        // If the course has modules, send the user directly into the first published module
        $firstModule = $course->modules()->where('is_published', true)->orderBy('order')->first();

        if ($firstModule) {
            return redirect()->route('modules.show', [$course->slug, $firstModule->slug])
                ->with('success', 'Enrolled and entering ' . $course->title);
        }

        // Fallback: send user to their learning dashboard
        return redirect()->route('courses.my-learning')
            ->with('success', 'Successfully enrolled in ' . $course->title);
    }

    /**
     * Show user's enrolled courses.
     */
    public function myLearning()
    {
        $enrollments = Enrollment::where('user_id', Auth::id())
            ->with('course')
            ->get();

        return view('courses.my-learning', compact('enrollments'));
    }
    /**
    * Show edit form for a course.
    */
    public function edit(Course $course)
    {
        return view('staff.courses.edit', compact('course'));
    }

    /**
     * Update a course.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'is_published' => 'sometimes|boolean',
        ]);

        $course->update($data);

        return redirect()->route('staff.dashboard')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Display quiz page
     */
    public function quiz()
    {
        $quizzes = Quiz::with(['questions.answers'])
            ->where('is_published', true)
            ->orderBy('title')
            ->get();

        return view('Userpage.course.quiz', compact('quizzes'));
    }

    /**
     * Submit quiz answers and render the real result immediately.
     */
    public function submitQuiz(Request $request, $quizId)
    {
        $quiz = Quiz::with(['questions.answers'])->findOrFail($quizId);

        $request->validate([
            'answers' => 'required|array',
        ]);

        $questions = $quiz->questions()->with('answers')->get();
        $correctCount = 0;
        $breakdown = [];

        foreach ($questions as $question) {
            $selectedRaw = $request->input('answers.' . $question->id, null);
            $selectedIds = [];

            if (is_array($selectedRaw)) {
                $selectedIds = array_map('intval', $selectedRaw);
            } elseif ($selectedRaw !== null && $selectedRaw !== '') {
                $selectedIds = [(int) $selectedRaw];
            }

            $correctIds = $question->answers
                ->where('is_correct', true)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->values()
                ->all();

            $selectedIds = array_values(array_unique(array_map('intval', $selectedIds)));
            $isCorrect = !empty($correctIds)
                && count($correctIds) === count($selectedIds)
                && empty(array_diff($correctIds, $selectedIds))
                && empty(array_diff($selectedIds, $correctIds));

            if ($isCorrect) {
                $correctCount++;
            }

            $selectedText = $question->answers
                ->whereIn('id', $selectedIds)
                ->pluck('answer_text')
                ->filter(fn ($answerText) => $answerText !== null && $answerText !== '')
                ->implode(', ');

            $breakdown[] = (object) [
                'question' => $question->question_text ?? $question->question ?? 'Question',
                'selected_text' => $selectedText !== '' ? $selectedText : 'No answer',
                'is_correct' => $isCorrect,
            ];
        }

        $total = $questions->count();
        $percentage = $total > 0 ? round(($correctCount / $total) * 100) : 0;

        $result = (object) [
            'score' => $correctCount,
            'total' => $total,
            'percentage' => $percentage,
            'breakdown' => collect($breakdown),
        ];

        return view('Userpage.course.quiz', compact('quiz', 'result'));
    }

    /**
     * Display subjects page
     */
    public function subjects()
    {
        $selectedCourseId = request()->query('course_id');
        $selectedSubjectId = request()->query('subject_id');

        $subjects = Auth::check()
            ? Subject::with([
                'teacher',
                'course.modules' => function ($query) {
                    $query->where('is_published', true)
                        ->orderBy('order')
                        ->with([
                            'lessons' => fn ($lessonQuery) => $lessonQuery
                                ->where('is_published', true)
                                ->orderBy('order'),
                            'quizzes' => fn ($quizQuery) => $quizQuery
                                ->where('is_published', true)
                                ->where('is_archived', false)
                                ->orderBy('order'),
                        ]);
                },
            ])
                ->when($selectedCourseId, function ($query, $courseId) {
                    return $query->where('course_id', $courseId);
                })
                ->when($selectedSubjectId, function ($query, $subjectId) {
                    return $query->where('id', $subjectId);
                })
                ->where(function ($query) {
                    $query->whereHas('course.enrollments', function ($q) {
                        $q->where('user_id', Auth::id())
                          ->where(function ($sq) {
                              $sq->whereIn('status', ['active', 'approved'])->orWhereNull('status');
                          });
                    })
                    ->orWhereIn('id', function ($subQ) {
                        $subQ->select('subject_id')
                            ->from('enrollments')
                            ->where('user_id', Auth::id())
                            ->whereNotNull('subject_id')
                            ->where(function ($sq) {
                                $sq->whereIn('status', ['active', 'approved'])->orWhereNull('status');
                            });
                    });
                })
                ->orderBy('title')
                ->get()
            : collect();

        if ($subjects->isEmpty()) {
            $subjects = Subject::with([
                'teacher',
                'course.modules.lessons',
                'course.modules.quizzes',
            ])
                ->where('is_active', true)
                ->orderBy('title')
                ->get();
        }

        return view('Userpage.course.subject', compact('subjects'));
    }

    /**
     * Display trivia games page
     */
    public function trivia()
    {
        $triviaGames = Quiz::with(['subject.course', 'module.course'])
            ->withCount('questions')
            ->where('is_trivia', true)
            ->where('is_published', true)
            ->where('is_archived', false)
            ->where(function ($query) {
                $query->whereNull('scheduled_at')->orWhere('scheduled_at', '<=', now());
            })
            ->whereHas('module.course')
            ->whereHas('questions')
            ->orderByDesc('scheduled_at')
            ->orderByDesc('created_at')
            ->get();

        $weekStart = now()->startOfWeek();
        $quizLeaderboard = UserQuizAttempt::query()
            ->selectRaw('user_id, MAX(score_percentage) as score, COUNT(*) as games')
            ->whereHas('quiz', fn ($query) => $query->where('is_trivia', true))
            ->whereNotNull('completed_at')
            ->where('completed_at', '>=', $weekStart)
            ->with('user:id,name')
            ->groupBy('user_id')
            ->get()
            ->toBase()
            ->map(fn ($entry) => [
                'user_id' => $entry->user_id,
                'name' => $entry->user?->name ?? 'Student',
                'score' => (int) $entry->score,
                'games' => (int) $entry->games,
            ]);

        $quickPlayLeaderboard = TriviaQuickPlayScore::query()
            ->where('completed_at', '>=', $weekStart)
            ->with('user:id,name')
            ->selectRaw('user_id, MAX(score_percentage) as score, COUNT(*) as games')
            ->groupBy('user_id')
            ->get()
            ->toBase()
            ->map(fn ($entry) => [
                'user_id' => $entry->user_id,
                'name' => $entry->user?->name ?? 'Student',
                'score' => (int) $entry->score,
                'games' => (int) $entry->games,
            ]);

        $leaderboard = $quizLeaderboard
            ->merge($quickPlayLeaderboard)
            ->groupBy('user_id')
            ->map(fn ($entries) => [
                'name' => $entries->first()['name'],
                'score' => $entries->max('score'),
                'games' => $entries->sum('games'),
            ])
            ->sortByDesc('score')
            ->take(10)
            ->values()
            ->map(fn ($entry, $index) => [
                'rank' => $index + 1,
                ...$entry,
            ]);

        return view('Userpage.course.trivia games', compact('triviaGames', 'leaderboard'));
    }

    public function submitTriviaQuickPlayScore(Request $request)
    {
        $validated = $request->validate([
            'game_type' => ['required', 'in:multiple-choice,true-false,word-match,timed-challenge'],
            'score' => ['required', 'integer', 'min:0'],
            'max_score' => ['required', 'integer', 'min:1'],
        ]);

        $score = min($validated['score'], $validated['max_score']);
        $scorePercentage = (int) round(($score / $validated['max_score']) * 100);

        TriviaQuickPlayScore::create([
            'user_id' => auth()->id(),
            'game_type' => $validated['game_type'],
            'score' => $score,
            'max_score' => $validated['max_score'],
            'score_percentage' => $scorePercentage,
            'completed_at' => now(),
        ]);

        return response()->json([
            'saved' => true,
            'score_percentage' => $scorePercentage,
        ], 201);
    }
}
