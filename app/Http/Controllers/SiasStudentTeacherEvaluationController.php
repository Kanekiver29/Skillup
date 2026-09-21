<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\TeacherEvaluation;
use Illuminate\Http\Request;

class SiasStudentTeacherEvaluationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $enrollments = $user->enrollments()->with('course.instructor')->get();
        $completedEnrollmentIds = TeacherEvaluation::where('user_id', $user->id)
            ->pluck('enrollment_id')
            ->toArray();

        return view('sias.students.teacher_evaluation.index', [
            'enrollments' => $enrollments,
            'completedEnrollmentIds' => $completedEnrollmentIds,
        ]);
    }

    public function create(Request $request, Enrollment $enrollment)
    {
        if ($enrollment->user_id !== $request->user()->id) {
            abort(403);
        }

        if (TeacherEvaluation::where('enrollment_id', $enrollment->id)->exists()) {
            return redirect()->route('sias.student.teacher_evaluation')
                ->with('info', 'You have already submitted an evaluation for this course.');
        }

        return view('sias.students.teacher_evaluation.form', [
            'enrollment' => $enrollment,
            'course' => $enrollment->course,
            'questions' => $this->evaluationQuestions(),
        ]);
    }

    public function store(Request $request, Enrollment $enrollment)
    {
        if ($enrollment->user_id !== $request->user()->id) {
            abort(403);
        }

        if (TeacherEvaluation::where('enrollment_id', $enrollment->id)->exists()) {
            return redirect()->route('sias.student.teacher_evaluation')
                ->with('info', 'You have already submitted an evaluation for this course.');
        }

        $questions = $this->evaluationQuestions();
        $rules = ['responses' => 'required|array'];

        foreach ($questions as $section) {
            foreach ($section['items'] as $item) {
                $rules['responses.' . $item['id']] = 'required|integer|min:1|max:5';
            }
        }

        $data = $request->validate(array_merge($rules, [
            'comments' => 'nullable|string|max:2000',
            'anonymous' => 'sometimes|in:1',
        ]));

        $responses = $data['responses'];
        $rating = round(array_sum($responses) / count($responses));
        $instructorId = data_get($enrollment->course, 'instructor_id');

        TeacherEvaluation::create([
            'enrollment_id' => $enrollment->id,
            'user_id' => $request->user()->id,
            'course_id' => $enrollment->course_id,
            'instructor_id' => $instructorId,
            'rating' => max(1, min(5, $rating)),
            'comments' => $data['comments'] ?? null,
            'anonymous' => isset($data['anonymous']),
            'responses' => $responses,
        ]);

        return redirect()->route('sias.student.teacher_evaluation')
            ->with('success', 'Your evaluation has been submitted. Thank you for the feedback!');
    }

    public function show(Request $request, Enrollment $enrollment)
    {
        if ($enrollment->user_id !== $request->user()->id) {
            abort(403);
        }

        $evaluation = TeacherEvaluation::where('enrollment_id', $enrollment->id)->firstOrFail();

        return view('sias.students.teacher_evaluation.show', [
            'enrollment' => $enrollment,
            'course' => $enrollment->course,
            'evaluation' => $evaluation,
            'questions' => $this->evaluationQuestions(),
        ]);
    }

    private function evaluationQuestions(): array
    {
        return [
            [
                'title' => 'I COMMITMENT (25%)',
                'items' => [
                    ['id' => 'a1', 'label' => "Demonstrates sensitivity to students' ability to attend and absorb content information."],
                    ['id' => 'a2', 'label' => 'Integrates sensitively his/her learning objectives with those of the students in a collaborative process.' ],
                    ['id' => 'a3', 'label' => 'Makes self available to students beyond official time.' ],
                    ['id' => 'a4', 'label' => 'Provides appropriate hints and encouragement during class activities.' ],
                ],
            ],
            [
                'title' => 'II CONTENT DELIVERY (25%)',
                'items' => [
                    ['id' => 'b1', 'label' => 'Presents material clearly and logically.' ],
                    ['id' => 'b2', 'label' => 'Uses examples and illustrations that support student understanding.' ],
                    ['id' => 'b3', 'label' => 'Checks for student comprehension throughout the lesson.' ],
                ],
            ],
        ];
    }
}
