<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class StudentManagementController extends Controller
{
    protected function authorizeAdmin()
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $students = User::where('role', 'student')->orderBy('name')->paginate(25);
        return view('sias.admin.students.index', compact('students'));
    }

    public function profiles()
    {
        $this->authorizeAdmin();
        $students = User::where('role', 'student')->orderBy('name')->paginate(25);
        return view('sias.admin.students.profiles.index', compact('students'));
    }

    public function documents()
    {
        $this->authorizeAdmin();
        $students = User::where('role', 'student')->orderBy('name')->get();
        return view('sias.admin.students.documents.index', compact('students'));
    }

    public function status()
    {
        $this->authorizeAdmin();
        $students = User::where('role', 'student')->orderBy('name')->get();
        return view('sias.admin.students.status.index', compact('students'));
    }

    public function show($student)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($student);
        return view('sias.admin.students.show', compact('user'));
    }

    public function print($student)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($student);
        $registration = $user->settings['registration'] ?? [];
        $enrollment = Enrollment::with(['course', 'subject'])
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        return view('sias.admin.students.print', compact('user', 'registration', 'enrollment'));
    }

    public function enrollmentCertificate($student)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($student);
        $enrollments = Enrollment::with(['course', 'subject'])
            ->where('user_id', $user->id)
            ->latest('enrolled_at')
            ->get();

        return view('sias.admin.students.enrollment-certificate', compact('user', 'enrollments'));
    }

    public function gradeCertificate($student)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($student);
        $enrollments = Enrollment::with(['course', 'subject'])
            ->where('user_id', $user->id)
            ->latest('enrolled_at')
            ->get();
        $gradedEnrollments = $enrollments->filter(fn ($enrollment) => is_numeric($enrollment->final_grade));
        $averageGrade = $gradedEnrollments->isEmpty()
            ? null
            : round($gradedEnrollments->avg('final_grade'), 2);

        return view('sias.admin.students.grade-certificate', compact('user', 'enrollments', 'averageGrade'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $courses = Course::where('is_published', true)
            ->orderBy('title')
            ->get(['id', 'title', 'category', 'level']);

        return view('sias.admin.students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:1|max:120',
            'birthdate' => 'nullable|date|before:today',
            'sex' => 'nullable|in:Male,Female,Prefer not to say',
            'civil_status' => 'nullable|in:Single,Married,Widowed,Separated',
            'nationality' => 'nullable|string|max:100',
            'birthplace_city' => 'nullable|string|max:150',
            'birthplace_province' => 'nullable|string|max:150',
            'birthplace_region' => 'nullable|string|max:150',
            'entry_date' => 'required|date',
            'contact_number' => 'nullable|string|max:30',
            'complete_address' => 'nullable|string|max:500',
            'educational_attainment' => 'nullable|string|max:150',
            'education_levels' => 'nullable|array',
            'education_levels.*' => 'string|max:100',
            'school' => 'nullable|string|max:255',
            'year_graduated' => 'nullable|integer|min:1900|max:' . now()->year,
            'employment_status' => 'nullable|in:Employed,Self-employed,Unemployed,Student',
            'employment_type' => 'nullable|in:Full-time,Part-time,Contractual,Seasonal',
            'occupation' => 'nullable|string|max:150',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:100',
            'guardian_contact' => 'nullable|string|max:30',
            'guardian_address' => 'nullable|string|max:500',
            'qualification' => 'nullable|string|max:255',
            'training_program' => 'nullable|string|max:255',
            'training_center' => 'nullable|string|max:255',
            'training_batch' => 'nullable|string|max:100',
            'training_schedule' => 'nullable|string|max:150',
            'training_mode' => 'nullable|in:Face-to-face,Online,Blended',
            'disability_types' => 'nullable|array',
            'disability_types.*' => 'string|max:100',
            'disability_cause' => 'nullable|in:Congenital/Inborn,Illness,Injury',
            'scholarship_package' => 'nullable|string|max:150',
            'learner_classification' => 'nullable|array',
            'learner_classification.*' => 'string|max:100',
            'documents' => 'nullable|array',
            'documents.*' => 'string|max:100',
            'supporting_documents' => 'nullable|array|max:10',
            'supporting_documents.*' => 'file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'thumbprint' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'desired_course' => 'nullable|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'email' => 'nullable|email|max:255|unique:users,email',
            'student_id' => 'required|string|max:50|unique:users,lrn',
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:6|max:100',
            'privacy_confirmation' => 'accepted',
            'privacy_response' => 'required|in:Agree,Disagree',
            'applicant_signature' => 'nullable|string|max:255',
            'signature_date' => 'nullable|date',
            'received_by' => 'nullable|string|max:255',
            'received_date' => 'nullable|date',
        ]);

        $email = $request->input('email');
        if (! $email) {
            $studentId = preg_replace('/[^A-Za-z0-9]+/', '', $request->input('student_id'));
            $email = strtolower($studentId) . '@student.skillup.local';
        }

        $email = strtolower(trim($email));

        $profileImage = null;
        if ($request->hasFile('profile_photo')) {
            $uploadPath = public_path('uploads/profiles');
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $profileImage = time() . '_' . preg_replace('/[^A-Za-z0-9]+/', '', $request->input('student_id')) . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $request->file('profile_photo')->move($uploadPath, $profileImage);
        }

        $thumbprintImage = null;
        if ($request->hasFile('thumbprint')) {
            $uploadPath = public_path('uploads/thumbprints');
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $thumbprintImage = time() . '_' . preg_replace('/[^A-Za-z0-9]+/', '', $request->input('student_id')) . '_thumbprint.' . $request->file('thumbprint')->getClientOriginalExtension();
            $request->file('thumbprint')->move($uploadPath, $thumbprintImage);
        }

        $documentPaths = [];
        if ($request->hasFile('supporting_documents')) {
            $documentPath = public_path('uploads/student-documents');
            if (! is_dir($documentPath)) {
                mkdir($documentPath, 0755, true);
            }

            foreach ($request->file('supporting_documents') as $document) {
                $filename = time() . '_' . bin2hex(random_bytes(4)) . '_' . preg_replace('/[^A-Za-z0-9._-]+/', '_', $document->getClientOriginalName());
                $document->move($documentPath, $filename);
                $documentPaths[] = 'uploads/student-documents/' . $filename;
            }
        }

        $registration = collect($validated)->only([
            'entry_date', 'birthdate', 'sex', 'civil_status', 'nationality',
            'birthplace_city', 'birthplace_province', 'birthplace_region',
            'contact_number', 'complete_address', 'educational_attainment',
            'education_levels', 'school', 'year_graduated', 'employment_status', 'employment_type',
            'occupation', 'guardian_name', 'guardian_relationship', 'guardian_contact',
            'guardian_address', 'qualification', 'training_program', 'training_center',
            'training_batch', 'training_schedule', 'training_mode', 'disability_types',
            'disability_cause', 'scholarship_package',
            'learner_classification', 'documents', 'privacy_confirmation',
            'privacy_response', 'applicant_signature', 'signature_date', 'received_by',
            'received_date',
        ])->all();
        $registration['username'] = $validated['username'];
        $registration['thumbprint'] = $thumbprintImage ? 'uploads/thumbprints/' . $thumbprintImage : null;
        $registration['supporting_documents'] = $documentPaths;

        $user = User::create([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'birthday' => $request->input('birthdate'),
            'email' => $email,
            'lrn' => $request->input('student_id'),
            'password' => $request->input('password', 'SkillUp26'),
            'role' => 'student',
            'is_admin' => false,
            'profile_image' => $profileImage,
            'settings' => ['registration' => $registration],
        ]);

        if ($request->filled('desired_course')) {
            \App\Models\UserProfile::create([
                'user_id' => $user->id,
                'interest' => $request->input('desired_course'),
                'skill_level' => null,
            ]);
        }

        if ($request->filled('course_id')) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $request->integer('course_id'),
                ],
                [
                    'status' => 'active',
                    'progress' => 0,
                    'completed' => false,
                    'enrolled_at' => now(),
                ]
            );
        }

        return redirect()->route('sias.admin.students.print', $user->id);
    }

    public function edit($student)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($student);
        $courses = Course::where('is_published', true)->orderBy('title')->get();
        return view('sias.admin.students.edit', compact('user', 'courses'));
    }

    public function update(Request $request, $student)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($student);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:1|max:120',
            'student_id' => 'required|string|max:50|unique:users,lrn,' . $user->id,
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => strtolower(trim($request->input('email'))),
            'age' => $request->input('age'),
            'lrn' => $request->input('student_id'),
        ]);

        return redirect()->route('sias.admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($student)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($student);
        $user->delete();

        return redirect()->route('sias.admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
