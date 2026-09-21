<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of all subjects with their teacher assignments.
     */
    public function index(Request $request)
    {
        $query = Subject::with(['teacher', 'course']);

        // Search filter
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject_code', 'like', "%{$search}%")
                  ->orWhereHas('teacher', function ($tq) use ($search) {
                      $tq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('course', function ($cq) use ($search) {
                      $cq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Course filter
        if ($courseId = $request->query('course_id')) {
            $query->where('course_id', $courseId);
        }

        // Assignment status filter
        if ($status = $request->query('status')) {
            if ($status === 'assigned') {
                $query->whereNotNull('teacher_id');
            } elseif ($status === 'unassigned') {
                $query->whereNull('teacher_id');
            }
        }

        $subjects = $query->orderBy('title')->paginate(20)->withQueryString();
        $courses = Course::orderBy('title')->get(['id', 'title']);

        // Stats
        $totalSubjects = Subject::count();
        $assignedCount = Subject::whereNotNull('teacher_id')->count();
        $unassignedCount = Subject::whereNull('teacher_id')->count();

        return view('staff.teacher and course.list', compact(
            'subjects', 'courses', 'totalSubjects', 'assignedCount', 'unassignedCount'
        ));
    }

    /**
     * Show the form for assigning a teacher to a subject.
     */
    public function create()
    {
        $subjects = Subject::with('course')->orderBy('title')->get();
        $teachers = $this->getTeachers();
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('staff.teacher and course.add', compact('subjects', 'teachers', 'courses'));
    }

    /**
     * Store a teacher assignment (assign teacher_id to subject).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
        ], [
            'subject_id.required' => 'Please select a subject.',
            'teacher_id.required' => 'Please select a teacher.',
        ]);

        if (! empty($validated['course_id'])) {
            $subject = Subject::where('id', $validated['subject_id'])
                ->where('course_id', $validated['course_id'])
                ->firstOrFail();
        } else {
            $subject = Subject::findOrFail($validated['subject_id']);
        }

        try {
            $subject->teacher_id = $validated['teacher_id'];
            $subject->save();

            $teacher = User::find($validated['teacher_id']);

            return redirect()->route('staff.teacher-subjects.index')
                ->with('success', "Teacher \"{$teacher->name}\" has been assigned to \"{$subject->title}\" successfully.");
        } catch (\Exception $e) {
            Log::error('Failed to assign teacher: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to assign teacher. Please try again.');
        }
    }

    /**
     * Show the form for editing a teacher assignment.
     */
    public function edit(Subject $subject)
    {
        $subject->load(['teacher', 'course']);
        $teachers = $this->getTeachers();
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('staff.teacher and course.edit', compact('subject', 'teachers', 'courses'));
    }

    /**
     * Update a teacher assignment.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
        ], [
            'teacher_id.required' => 'Please select a teacher.',
        ]);

        if (! empty($validated['course_id']) && $subject->course_id != $validated['course_id']) {
            $subject->course_id = $validated['course_id'];
        }

        try {
            $subject->teacher_id = $validated['teacher_id'];
            $subject->save();

            $teacher = User::find($validated['teacher_id']);

            return redirect()->route('staff.teacher-subjects.index')
                ->with('success', "Assignment updated — \"{$subject->title}\" is now assigned to \"{$teacher->name}\".");
        } catch (\Exception $e) {
            Log::error('Failed to update teacher assignment: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update assignment. Please try again.');
        }
    }

    /**
     * Remove a teacher assignment (set teacher_id to null).
     */
    public function destroy(Subject $subject)
    {
        try {
            $teacherName = $subject->teacher->name ?? 'Unknown';
            $subjectTitle = $subject->title;

            $subject->teacher_id = null;
            $subject->save();

            return redirect()->route('staff.teacher-subjects.index')
                ->with('success', "Teacher \"{$teacherName}\" has been unassigned from \"{$subjectTitle}\".");
        } catch (\Exception $e) {
            Log::error('Failed to unassign teacher: ' . $e->getMessage());
            return back()->with('error', 'Failed to unassign teacher. Please try again.');
        }
    }

    /**
     * Get all users who qualify as teachers.
     */
    private function getTeachers()
    {
        return User::where(function ($q) {
            $q->where('role', 'teacher')
              ->orWhereIn('staff_type', ['teacher', 'instructor']);
        })->orderBy('name')->get(['id', 'name', 'email', 'role', 'staff_type']);
    }
}

