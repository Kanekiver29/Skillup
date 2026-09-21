<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MajorController extends Controller
{
    /**
     * Display all majors.
     */
    public function index()
    {
        $this->authorize('isAdmin');
        
        $majors = Major::withCount('students', 'courses')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.majors.index', compact('majors'));
    }

    /**
     * Show the form for creating a new major.
     */
    public function create()
    {
        $this->authorize('isAdmin');
        
        return view('admin.majors.create');
    }

    /**
     * Store a newly created major in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:majors',
            'code' => 'required|string|max:50|unique:majors',
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        $major = Major::create($validated);

        return redirect()
            ->route('admin.majors.show', $major)
            ->with('success', 'Major created successfully.');
    }

    /**
     * Display the specified major.
     */
    public function show(Major $major)
    {
        $this->authorize('isAdmin');
        
        $major->load(['courses' => function ($query) {
            $query->orderBy('title');
        }, 'students' => function ($query) {
            $query->orderBy('name')->limit(20);
        }]);

        return view('admin.majors.show', compact('major'));
    }

    /**
     * Show the form for editing the specified major.
     */
    public function edit(Major $major)
    {
        $this->authorize('isAdmin');
        
        return view('admin.majors.edit', compact('major'));
    }

    /**
     * Update the specified major in storage.
     */
    public function update(Request $request, Major $major)
    {
        $this->authorize('isAdmin');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:majors,name,' . $major->id,
            'code' => 'required|string|max:50|unique:majors,code,' . $major->id,
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? false;

        $major->update($validated);

        return redirect()
            ->route('admin.majors.show', $major)
            ->with('success', 'Major updated successfully.');
    }

    /**
     * Delete the specified major.
     */
    public function destroy(Major $major)
    {
        $this->authorize('isAdmin');
        
        // Check if major has students enrolled
        if ($major->students()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete a major that has enrolled students.']);
        }

        $majorName = $major->name;
        $major->delete();

        return redirect()
            ->route('admin.majors.index')
            ->with('success', "Major '{$majorName}' deleted successfully.");
    }

    /**
     * Assign a course to a major.
     */
    public function assignCourse(Request $request, Major $major)
    {
        $this->authorize('isAdmin');
        
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'is_primary' => 'nullable|boolean',
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // If marking as primary, unmark other primary courses for this major
        if ($validated['is_primary'] ?? false) {
            $major->courses()->update(['is_primary' => false]);
        }

        $course->update([
            'major_id' => $major->id,
            'is_primary' => $validated['is_primary'] ?? false,
        ]);

        return back()->with('success', 'Course assigned to major successfully.');
    }

    /**
     * Remove a course from a major.
     */
    public function removeCourse(Major $major, Course $course)
    {
        $this->authorize('isAdmin');
        
        if ($course->major_id !== $major->id) {
            return back()->withErrors(['error' => 'This course is not assigned to this major.']);
        }

        $course->update([
            'major_id' => null,
            'is_primary' => false,
        ]);

        return back()->with('success', 'Course removed from major.');
    }

    /**
     * Set a course as the primary course for a major.
     */
    public function setPrimary(Major $major, Course $course)
    {
        $this->authorize('isAdmin');
        
        if ($course->major_id !== $major->id) {
            return back()->withErrors(['error' => 'This course is not assigned to this major.']);
        }

        // Unmark all other primary courses
        $major->courses()->update(['is_primary' => false]);

        // Mark this one as primary
        $course->update(['is_primary' => true]);

        return back()->with('success', 'Course set as primary for this major.');
    }

    /**
     * Get courses available for assignment (not assigned to any major or assigned to this major).
     */
    public function getAvailableCourses(Major $major)
    {
        $courses = Course::where(function ($query) use ($major) {
            $query->whereNull('major_id')
                ->orWhere('major_id', $major->id);
        })
        ->orderBy('title')
        ->get(['id', 'title', 'code']);

        return response()->json($courses);
    }
}
