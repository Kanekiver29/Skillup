<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::latest()->paginate(20);
        return view('Admin.courses.index', compact('courses'));
    }

    /**
     * Show form to create a new course.
     */
    public function create()
    {
        return view('Admin.courses.create');
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_hours' => 'nullable|numeric|min:0',
            'instructor_name' => 'nullable|string|max:255',
            'instructor_title' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:1000',
            'is_published' => 'sometimes|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show form to edit an existing course.
     */
    public function edit(Course $course)
    {
        return view('Admin.courses.edit', compact('course'));
    }

    /**
     * Update an existing course.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_hours' => 'nullable|numeric|min:0',
            'instructor_name' => 'nullable|string|max:255',
            'instructor_title' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:1000',
            'is_published' => 'sometimes|boolean',
        ]);

        if ($course->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove a course.
     */
    public function destroy(Course $course)
    {
        $title = $course->title;
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', "Course '$title' deleted.");
    }

    /**
     * View enrollments for a course.
     */
    public function enrollments(Course $course)
    {
        $enrollments = Enrollment::where('course_id', $course->id)
            ->with('user')
            ->latest()
            ->paginate(25);

        return view('Admin.courses.enrollments', compact('course', 'enrollments'));
    }
}
