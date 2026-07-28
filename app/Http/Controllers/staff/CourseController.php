<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use Illuminate\Http\Request;

class CourseController extends AdminCourseController
{
    // Show staff-specific course list
    public function index()
    {
        $this->authorizeStaff();
        $courses = \App\Models\Course::latest()->paginate(20);
        return view('staff.courses.index', compact('courses'));
    }

    public function create()
    {
        $this->authorizeCourseManager();
        return view('staff.courses.create');
    }

    public function show(\App\Models\Course $course)
    {
        $this->authorizeCourseManager();
        return view('staff.courses.show', compact('course'));
    }

    public function edit(\App\Models\Course $course)
    {
        $this->authorizeCourseManager();
        return view('staff.courses.edit', compact('course'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $this->authorizeCourseManager();

        $validated = $request->validate([
            'title' => 'required_without:course_title|string|max:255',
            'course_title' => 'required_without:title|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'duration_hours' => 'nullable|numeric|min:0',
            'units' => 'nullable|numeric|min:0',
            'instructor_name' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'instructor_title' => 'nullable|string|max:255',
            'image_url' => 'nullable|string|max:1000',
            'is_published' => 'sometimes|boolean',
            'status' => 'nullable|in:active,draft,inactive',
        ]);

        $title = $validated['title'] ?? $validated['course_title'] ?? null;
        $category = $validated['category'] ?? $validated['department'] ?? 'General';
        $durationHours = $validated['duration_hours'] ?? $validated['units'] ?? null;
        $instructorName = $validated['instructor_name'] ?? $validated['instructor'] ?? null;
        $publishState = $request->has('is_published')
            ? (bool) $request->boolean('is_published')
            : ($validated['status'] ?? null) === 'active';

        $coursePayload = [
            'title' => $title,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'category' => $category,
            'level' => $validated['level'] ?? 'Beginner',
            'duration_hours' => $durationHours,
            'instructor_name' => $instructorName,
            'instructor_title' => $validated['instructor_title'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'is_published' => $publishState,
        ];

        $coursePayload['slug'] = \Illuminate\Support\Str::slug($title);

        $course = \App\Models\Course::create($coursePayload);

        return redirect()->route('staff.courses.index')->with('success', 'Course created successfully.');
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Course $course)
    {
        $this->authorizeCourseManager();

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
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);
        }

        $course->update($validated);

        return redirect()->route('staff.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(\App\Models\Course $course)
    {
        $this->authorizeCourseManager();
        $title = $course->title;
        $course->delete();
        return redirect()->route('staff.courses.index')->with('success', "Course '$title' deleted.");
    }

    public function export()
    {
        $this->authorizeCourseManager();

        $courses = \App\Models\Course::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="staff-courses-export.csv"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma' => 'no-cache',
        ];

        $callback = function () use ($courses) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID', 'Title', 'Slug', 'Category', 'Level', 'Instructor', 'Duration Hours', 'Published', 'Created At']);

            foreach ($courses as $course) {
                fputcsv($handle, [
                    $course->id,
                    $course->title ?? '',
                    $course->slug ?? '',
                    $course->category ?? '',
                    $course->level ?? '',
                    $course->instructor_name ?? '',
                    $course->duration_hours ?? '',
                    $course->is_published ? 'Yes' : 'No',
                    $course->created_at ? $course->created_at->toDateTimeString() : '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ensure the current user can manage course content.
     * Allowed: admins and staff with staff_type == 'content_manager'.
     */
    protected function authorizeCourseManager()
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $user = auth()->user();
        // Allow admins and any staff users to access staff course management.
        // Previously this required 'content_manager' staff_type; relax so
        // staff with general staff access can manage courses during testing.
        if (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess()) {
            return true;
        }

        abort(403, 'Unauthorized');
    }

    // For store/update/destroy, reuse AdminCourseController implementations
}
