<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class SubjectManagementController extends Controller
{
    protected function authorizeAdmin()
    {
        if (! auth()->check() || ! auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        return view('Admin.subjects.index');
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('Admin.subjects.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject created (placeholder).');
    }

    public function edit($subject)
    {
        $this->authorizeAdmin();
        return view('Admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, $subject)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated (placeholder).');
    }

    public function destroy($subject)
    {
        $this->authorizeAdmin();
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted (placeholder).');
    }

    public function assignTeacher(Request $request, $subjectId)
    {
        $this->authorizeAdmin();

        $request->validate([
            'teacher_id' => 'required|exists:users,id',
        ]);

        $subject = Subject::findOrFail($subjectId);
        $teacher = User::findOrFail($request->teacher_id);

        $subject->update(['teacher_id' => $request->teacher_id]);

        return redirect()->route('admin.subjects.index')
            ->with('success', "Teacher '{$teacher->name}' assigned to subject '{$subject->title}'.");
    }

    // --- SIAS admin views (sias/admin) -----------------
    public function indexSias(Request $request)
    {
        $this->authorizeAdmin();
        
        $subjects = Subject::with('teacher', 'course')
            ->paginate(15);
        
        return view('sias.admin.subject.index', compact('subjects'));
    }

    public function createSias()
    {
        $this->authorizeAdmin();
        $courses = Course::all();
        return view('sias.admin.subject.create', compact('courses'));
    }

    public function editSias($subject)
    {
        $this->authorizeAdmin();
        $subject = Subject::findOrFail($subject);
        $courses = Course::all();
        return view('sias.admin.subject.edit', compact('subject', 'courses'));
    }

    public function storeSias(Request $request)
    {
        $this->authorizeAdmin();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Subject::create($request->only('title', 'course_id', 'teacher_id'));

        return redirect()->route('sias.admin.subject')->with('success', 'Subject created successfully');
    }

    public function updateSias(Request $request, $subject)
    {
        $this->authorizeAdmin();
        
        $subject = Subject::findOrFail($subject);

        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $subject->update($request->only('title', 'course_id', 'teacher_id'));

        return redirect()->route('sias.admin.subject')->with('success', 'Subject updated successfully');
    }

    public function destroySias($subject)
    {
        $this->authorizeAdmin();
        
        $subject = Subject::findOrFail($subject);
        $subject->delete();

        return redirect()->route('sias.admin.subject')->with('success', 'Subject deleted successfully');
    }

    /**
     * Assign or reassign a teacher to a subject (SIAS)
     */
    public function assignTeacherSias(Request $request, $subjectId)
    {
        $this->authorizeAdmin();

        $request->validate([
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $subject = Subject::findOrFail($subjectId);
        $oldTeacher = $subject->teacher;

        $subject->update(['teacher_id' => $request->teacher_id]);

        $newTeacher = $subject->teacher;
        $message = $request->teacher_id
            ? "Teacher '{$newTeacher->name}' assigned to '{$subject->title}'."
            : "Teacher removed from '{$subject->title}'.";

        return redirect()->route('sias.admin.subject')->with('success', $message);
    }
}
