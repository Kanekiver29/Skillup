<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    /**
     * Display a listing of the subjects.
     */
    public function index()
    {
        $subjects = Subject::with(['course'])->get();
        return view('staff.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        $courses = Course::all();
        return view('staff.subjects.create', compact('courses'));
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_code' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'nullable|integer|min:0',
            'hours' => 'nullable|integer|min:0',
            'course_id' => 'required|exists:courses,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            Subject::create($validated);
            return redirect()->route('staff.subjects.index')
                ->with('success', 'Subject created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create subject: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create subject. Please try again.');
        }
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject)
    {
        return view('staff.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit(Subject $subject)
    {
        $courses = Course::all();
        return view('staff.subjects.edit', compact('subject', 'courses'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_code' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'nullable|integer|min:0',
            'hours' => 'nullable|integer|min:0',
            'course_id' => 'required|exists:courses,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            $subject->update($validated);
            return redirect()->route('staff.subjects.index')
                ->with('success', 'Subject updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update subject: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update subject. Please try again.');
        }
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return redirect()->route('staff.subjects.index')
                ->with('success', 'Subject deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete subject: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete subject. Please try again.');
        }
    }
}
