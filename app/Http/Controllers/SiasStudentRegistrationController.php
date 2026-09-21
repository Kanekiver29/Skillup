<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiasStudentRegistrationController extends Controller
{
    private function registrationSessionData()
    {
        $course = session('sias_student_registration.course');
        $subjects = session('sias_student_registration.subjects', []);

        if (is_array($course)) {
            $course = (object) $course;
        }

        $courseModel = null;
        if (! empty($course) && is_numeric($course->id ?? null)) {
            $courseModel = Course::find($course->id);
        }

        if (empty($courseModel) && Auth::check()) {
            $userEnrollment = Enrollment::where('user_id', Auth::id())->latest()->first();
            if ($userEnrollment && $userEnrollment->course) {
                $courseModel = $userEnrollment->course;
            }
        }

        $subjectModels = collect();
        if (! empty($subjects)) {
            $ids = collect($subjects)->pluck('id')->filter()->all();
            if (! empty($ids)) {
                $subjectModels = Subject::whereIn('id', $ids)->orderBy('title')->get();
            }
        }

        if (empty($subjectModels) && Auth::check()) {
            $enrolledSubjectIds = Enrollment::where('user_id', Auth::id())
                ->whereNotNull('subject_id')
                ->pluck('subject_id')
                ->all();
            if (! empty($enrolledSubjectIds)) {
                $subjectModels = Subject::whereIn('id', $enrolledSubjectIds)->orderBy('title')->get();
            }
        }

        return [
            'course' => $courseModel ?? $course,
            'subjects' => $subjectModels,
            'allCourses' => Course::orderBy('title')->get(),
            'allSubjects' => $courseModel
                ? $courseModel->subjects()->with('teacher')->where('is_active', true)->orderBy('title')->get()
                : Subject::where('is_active', true)->orderBy('title')->get(),
            'user' => Auth::user(),
        ];
    }

    public function index()
    {
        $data = $this->registrationSessionData();

        return view('sias.students.registration.index', $data);
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $course = Course::findOrFail($request->course_id);
        session(['sias_student_registration.course' => [
            'id' => $course->id,
            'title' => $course->title,
            'slug' => $course->slug,
            'category' => $course->category,
            'description' => $course->description,
        ]]);

        if (Auth::check()) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                ],
                [
                    'status' => 'approved',
                    'progress' => 0,
                    'completed' => false,
                    'enrolled_at' => now(),
                ]
            );
        }

        return redirect()->route('sias.student.registration')->with('success', 'Course registration added successfully.');
    }

    public function storeSubjects(Request $request)
    {
        $request->validate([
            'subject_ids' => ['required', 'array'],
            'subject_ids.*' => ['exists:subjects,id'],
        ]);

        $courseId = session('sias_student_registration.course.id');
        if (! $courseId && Auth::check()) {
            $courseId = Enrollment::where('user_id', Auth::id())->latest()->value('course_id');
        }

        $subjects = Subject::whereIn('id', $request->subject_ids)
            ->when($courseId, fn ($query) => $query->where('course_id', $courseId))
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        if ($subjects->count() !== count($request->subject_ids)) {
            return back()->withErrors(['subject_ids' => 'Select subjects from your assigned course only.'])->withInput();
        }
        session(['sias_student_registration.subjects' => $subjects->map(function ($subject) {
            return [
                'id' => $subject->id,
                'title' => $subject->title,
                'teacher_id' => $subject->teacher_id,
            ];
        })->values()->all()]);

        if (Auth::check()) {
            foreach ($subjects as $subject) {
                Enrollment::firstOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'course_id' => $subject->course_id,
                        'subject_id' => $subject->id,
                    ],
                    [
                        'status' => 'approved',
                        'progress' => 0,
                        'completed' => false,
                        'enrolled_at' => now(),
                    ]
                );
            }
        }

        return redirect()->route('sias.student.registration')->with('success', 'Subjects added to your registration.');
    }

    public function reset()
    {
        session()->forget('sias_student_registration');

        return redirect()->route('sias.student.registration')->with('success', 'Registration form reset.');
    }

    public function enrollmentForm()
    {
        $data = $this->registrationSessionData();

        if (empty($data['course']) && empty($data['subjects'])) {
            return redirect()->route('sias.student.registration')->with('error', 'Please select a course and subject before printing the enrollment form.');
        }

        return view('sias.students.registration.enrollment_form', $data);
    }

    public function assessmentForm()
    {
        $data = $this->registrationSessionData();

        if (empty($data['course']) && empty($data['subjects'])) {
            return redirect()->route('sias.student.registration')->with('error', 'Please complete registration before printing the assessment form.');
        }

        return view('sias.students.registration.assessment_form', $data);
    }

    public function enrollmentCertificate()
    {
        $data = $this->registrationSessionData();

        if (empty($data['course']) && empty($data['subjects'])) {
            return redirect()->route('sias.student.registration')->with('error', 'No student registration found.');
        }

        return view('sias.students.registration.certificate_enrollment', $data);
    }

    public function assessmentCertificate()
    {
        $data = $this->registrationSessionData();

        if (empty($data['course']) && empty($data['subjects'])) {
            return redirect()->route('sias.student.registration')->with('error', 'No assessment data found.');
        }

        return view('sias.students.registration.certificate_assessment', $data);
    }

    public function gradeCertificate()
    {
        $data = $this->registrationSessionData();

        if (empty($data['course']) && empty($data['subjects'])) {
            return redirect()->route('sias.student.registration')->with('error', 'No grade record found.');
        }

        $subjects = $data['subjects'];
        $gradeRows = [];
        foreach ($subjects as $index => $subject) {
            $gradeRows[] = [
                'subject' => $subject->title,
                'grade' => 85 + ($index % 10),
                'remarks' => $index % 2 === 0 ? 'Passed' : 'Very Good',
            ];
        }

        $data['gradeRows'] = $gradeRows;
        $data['averageGrade'] = round(array_sum(array_column($gradeRows, 'grade')) / max(count($gradeRows), 1), 2);

        return view('sias.students.registration.certificate_grade', $data);
    }
}
