<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of teacher subjects.
     */
    public function index(Request $request)
    {
        $teacherId = Auth::id();
        $query = Subject::with(['teacher', 'course.modules.lessons', 'course.modules.quizzes']);

        // Admins see all subjects; teachers see their own + unassigned
        if (Auth::check() && !Auth::user()->is_admin) {
            $query->where(function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId)
                  ->orWhereNull('teacher_id');
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $subjects = $query->orderBy('title')->paginate(12);
        $coursesCount = Course::count();
        $totalUnits = Subject::where('teacher_id', $teacherId)->sum('units');
        $activeCount = Subject::where('teacher_id', $teacherId)->where('is_active', true)->count();

        return view('teacher.SUBJECT.index', compact('subjects', 'coursesCount', 'totalUnits', 'activeCount'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        $courses = Auth::user()?->is_admin
            ? Course::orderBy('title')->get()
            : Course::where('instructor_id', Auth::id())->orderBy('title')->get();
        return view('teacher.SUBJECT.Add', compact('courses'));
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'nullable|string|max:50',
            'subject_type' => 'nullable|in:Core,Elective,Laboratory,Practical,Seminar,Workshop,Online',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'units'        => 'nullable|integer|min:1|max:20',
            'hours'        => 'nullable|integer|min:1|max:500',
            'course_id'    => 'required|exists:courses,id',
            'is_active'    => 'nullable|boolean',
        ]);

        if (! Auth::user()?->is_admin) {
            Course::whereKey($validated['course_id'])
                ->where('instructor_id', Auth::id())
                ->firstOrFail();
        }

        $validated['teacher_id'] = Auth::id();
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;

        $subject = Subject::create($validated);

        return redirect()->route('teacher.subjects.index')
            ->with('success', "Subject '{$subject->title}' created successfully and linked to Userpage course directory!");
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit(Subject $subject)
    {
        abort_unless($subject->teacher_id === Auth::id() || Auth::user()?->is_admin, 403);
        $courses = Auth::user()?->is_admin
            ? Course::orderBy('title')->get()
            : Course::where('instructor_id', Auth::id())->orderBy('title')->get();
        return view('teacher.SUBJECT.edit', compact('subject', 'courses'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'nullable|string|max:50',
            'subject_type' => 'nullable|in:Core,Elective,Laboratory,Practical,Seminar,Workshop,Online',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'units'        => 'nullable|integer|min:1|max:20',
            'hours'        => 'nullable|integer|min:1|max:500',
            'course_id'    => 'required|exists:courses,id',
            'is_active'    => 'nullable|boolean',
        ]);

        abort_unless($subject->teacher_id === Auth::id() || Auth::user()?->is_admin, 403);
        abort_unless(
            Auth::user()?->is_admin || Course::whereKey($validated['course_id'])->where('instructor_id', Auth::id())->exists(),
            403
        );

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->is_active : true;

        $subject->update($validated);

        return redirect()->route('teacher.subjects.index')
            ->with('success', "Subject '{$subject->title}' updated successfully.");
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy(Subject $subject)
    {
        abort_unless($subject->teacher_id === Auth::id() || Auth::user()?->is_admin, 403);
        $title = $subject->title;
        $subject->delete();

        return redirect()->route('teacher.subjects.index')
            ->with('success', "Subject '{$title}' deleted successfully.");
    }

    /**
     * Display lessons and content management for the subject.
     */
    public function lesson(Subject $subject)
    {
        abort_unless($subject->teacher_id === Auth::id() || Auth::user()?->is_admin, 403);
        $subject->load(['teacher', 'course.modules.lessons', 'course.modules.quizzes', 'course.lessons']);
        return view('teacher.SUBJECT.lesson', compact('subject'));
    }
}
