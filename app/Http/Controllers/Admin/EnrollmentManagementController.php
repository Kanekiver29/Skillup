<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentManagementController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['user', 'course', 'subject'])->latest()->paginate(20);
        $totalCount = Enrollment::count();
        $pendingCount = Enrollment::where('status', 'pending')->count();
        $approvedCount = Enrollment::where('status', 'approved')->orWhere('completed', true)->count();

        return view('sias.admin.enrollments.index', compact('enrollments', 'totalCount', 'pendingCount', 'approvedCount'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->orderBy('name')->get();
        $courses = Course::orderBy('title')->get();
        $subjects = Subject::orderBy('title')->get();

        return view('sias.admin.enrollment.add', compact('students', 'courses', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'training_program' => 'required|string|max:255',
            'training_center' => 'required|string|max:255',
            'batch_class' => 'required|string|max:100',
            'training_schedule' => 'required|string|max:150',
            'training_start_date' => 'required|date',
            'training_end_date' => 'required|date|after_or_equal:training_start_date',
            'training_mode' => 'required|in:Face-to-Face,Online,Blended',
            'training_location' => 'required|string|max:255',
            'scholarship_type' => 'required|in:None,TWSP,PESFA,STEP,Other',
            'scholarship_reference_no' => 'nullable|string|max:100',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:Pending,For Verification,Approved,Enrolled,Completed,Cancelled,Rejected',
            'document_status' => 'required|in:Pending,Verified,Rejected',
            'supporting_documents' => 'nullable|array|max:10',
            'supporting_documents.*' => 'file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $subject = ! empty($validated['subject_id']) ? Subject::find($validated['subject_id']) : null;
        $documentPaths = $this->storeDocuments($request);

        Enrollment::create([
            'user_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'subject_id' => $validated['subject_id'] ?? null,
            'qualification_name' => $course->title,
            'qualification_code' => $course->code,
            'training_program' => $validated['training_program'],
            'unit_of_competency' => $subject?->title,
            'training_center' => $validated['training_center'],
            'batch_class' => $validated['batch_class'],
            'training_schedule' => $validated['training_schedule'],
            'training_start_date' => $validated['training_start_date'],
            'training_end_date' => $validated['training_end_date'],
            'training_mode' => $validated['training_mode'],
            'training_location' => $validated['training_location'],
            'scholarship_type' => $validated['scholarship_type'],
            'scholarship_reference_no' => $validated['scholarship_reference_no'] ?? null,
            'enrollment_date' => $validated['enrollment_date'],
            'supporting_documents' => $documentPaths,
            'document_status' => $validated['document_status'],
            'status' => strtolower($validated['status']),
            'progress' => 0,
            'completed' => $validated['status'] === 'Completed',
            'enrolled_at' => $validated['enrollment_date'],
        ]);

        return redirect()->route('sias.admin.enrollments')->with('success', 'Enrollment record created successfully.');
    }

    private function storeDocuments(Request $request): array
    {
        if (! $request->hasFile('supporting_documents')) {
            return [];
        }

        $directory = public_path('uploads/enrollment-documents');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $paths = [];
        foreach ($request->file('supporting_documents') as $document) {
            $filename = now()->format('YmdHis') . '_' . bin2hex(random_bytes(4)) . '_' . preg_replace('/[^A-Za-z0-9._-]+/', '_', $document->getClientOriginalName());
            $document->move($directory, $filename);
            $paths[] = 'uploads/enrollment-documents/' . $filename;
        }

        return $paths;
    }

    public function edit($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $students = User::where('role', 'student')->orderBy('name')->get();
        $courses = Course::orderBy('title')->get();
        $subjects = Subject::orderBy('title')->get();

        return view('sias.admin.enrollment.edit', compact('enrollment', 'students', 'courses', 'subjects'));
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'year_level' => 'nullable|string',
            'semester' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $enrollment->update([
            'user_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'subject_id' => $validated['subject_id'] ?? null,
            'year_level' => $validated['year_level'],
            'semester' => $validated['semester'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('sias.admin.enrollments')->with('success', 'Enrollment updated successfully.');
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('sias.admin.enrollments')->with('success', 'Enrollment record deleted.');
    }
}
