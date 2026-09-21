<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Str;

class CourseManagementController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('subjects')->with('subjects')->latest()->get();
        return view('sias.admin.course.view', compact('courses'));
    }

    public function courseList()
    {
        $courses = Course::withCount('subjects')->latest()->get();
        return view('sias.admin.course.course.course', compact('courses'));
    }

    public function create()
    {
        return view('sias.admin.course.course.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'qualification_title' => 'required|string|max:255',
            'qualification_code' => 'required|string|max:50',
            'department' => 'required|string|max:255',
            'sector_industry' => 'required|string|max:255',
            'qualification_description' => 'nullable|string',
            'qualification_level' => 'required|string|max:100',
            'program_registration_no' => 'nullable|string|max:100',
            'registration_status' => 'required|in:Registered,Pending,Expired,Suspended',
            'registration_date' => 'nullable|date',
            'training_regulations_version' => 'nullable|string|max:100',
            'nominal_training_duration' => 'required|numeric|min:0.01|max:99999',
            'delivery_mode' => 'required|in:Face-to-Face,Online,Blended',
            'maximum_batch_capacity' => 'required|integer|min:1|max:10000',
            'category' => 'required|string|max:100',
            'curriculum' => 'nullable|string|max:255',
            'program_status' => 'required|in:Active,Inactive,Suspended',
            'competencies' => 'nullable|array|max:100',
            'competencies.*.type' => 'required_with:competencies|string|in:Basic,Common,Core',
            'competencies.*.name' => 'required_with:competencies|string|max:255',
        ]);

        $validated['title'] = $validated['qualification_title'];
        $validated['code'] = $validated['qualification_code'];
        $validated['description'] = $validated['qualification_description'] ?? null;
        $validated['duration'] = (int) ceil($validated['nominal_training_duration'] / 8760);
        $validated['is_active'] = $validated['program_status'] === 'Active';
        $validated['slug'] = Str::slug($validated['qualification_title']) . '-' . Str::random(5);
        $validated['is_published'] = true;

        Course::create($validated);

        return redirect()->route('sias.admin.course')->with('success', 'Course created successfully');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('sias.admin.course.course.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'department' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'category' => 'nullable|string|max:100',
            'curriculum' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $course->update($validated);

        return redirect()->route('sias.admin.course')->with('success', 'Course updated successfully');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('sias.admin.course')->with('success', 'Course deleted successfully');
    }
}
