<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SiasTeacherProfileController extends Controller
{
    /**
     * Show the teacher's profile with assigned courses
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get teacher's courses
        if (Schema::hasColumn('courses', 'instructor_id')) {
            $courses = Course::where('instructor_id', $user->id)
                ->orWhere(function($q) use ($user) {
                    $q->whereNull('instructor_id')->where('instructor_name', $user->name ?? '');
                })
                ->orderByDesc('created_at')
                ->get();
        } else {
            $courses = Course::where('instructor_name', $user->name ?? '')
                ->orderByDesc('created_at')
                ->get();
        }

        // Calculate statistics
        $totalCourses = $courses->count();
        $publishedCourses = $courses->where('is_published', true)->count();
        $draftCourses = $courses->where('is_published', false)->count();
        $totalStudents = $courses->sum('students_count');

        // Get recent enrollments for these courses
        $recentEnrollments = Enrollment::whereIn('course_id', $courses->pluck('id'))
            ->with(['user', 'course'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('sias.teacher.profile.index', [
            'user' => $user,
            'courses' => $courses,
            'totalCourses' => $totalCourses,
            'publishedCourses' => $publishedCourses,
            'draftCourses' => $draftCourses,
            'totalStudents' => $totalStudents,
            'recentEnrollments' => $recentEnrollments,
        ]);
    }

    /**
     * Show create course form
     */
    public function create()
    {
        return view('sias.teacher.profile.create-course');
    }

    /**
     * Store a new course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'duration_hours' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        $user = auth()->user();
        
        // Generate unique slug
        $slug = \Illuminate\Support\Str::slug($validated['title']);
        $baseSlug = $slug;
        $i = 1;
        while (Course::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        $course = Course::create([
            'instructor_id' => $user->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'level' => $validated['level'] ?? 'Beginner',
            'duration_hours' => $validated['duration_hours'] ?? 0,
            'instructor_name' => $user->name ?? 'Instructor',
            'instructor_title' => $user->staff_type ?? null,
            'image_url' => $validated['image_url'],
            'is_published' => false,
        ]);

        return redirect()->route('sias.teacher.profile')->with('success', 'Course created successfully!');
    }

    /**
     * Show edit course form
     */
    public function edit(Course $course)
    {
        $user = auth()->user();
        
        // Check authorization
        if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
            abort(403);
        }

        return view('sias.teacher.profile.create-course', compact('course'));
    }

    /**
     * Update course
     */
    public function update(Request $request, Course $course)
    {
        $user = auth()->user();
        
        // Check authorization
        if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'duration_hours' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
            'is_published' => 'nullable|boolean',
        ]);

        $course->update([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'level' => $validated['level'] ?? $course->level,
            'duration_hours' => $validated['duration_hours'] ?? $course->duration_hours,
            'image_url' => $validated['image_url'] ?? $course->image_url,
            'is_published' => $validated['is_published'] ?? $course->is_published,
        ]);

        return redirect()->route('sias.teacher.profile')->with('success', 'Course updated successfully!');
    }

    /**
     * Delete/Archive a course
     */
    public function destroy(Course $course)
    {
        $user = auth()->user();
        
        // Check authorization
        if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
            abort(403);
        }

        $course->delete();

        return redirect()->route('sias.teacher.profile')->with('success', 'Course archived successfully!');
    }

    /**
     * Assign/Enroll a student in a course
     */
    public function assignStudent(Request $request, Course $course)
    {
        $user = auth()->user();
        
        // Check authorization
        if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
            abort(403);
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::findOrFail($validated['student_id']);

        // Check if already enrolled
        $enrollment = $course->enrollments()->where('user_id', $student->id)->first();
        if ($enrollment) {
            return redirect()->back()->with('info', 'Student already enrolled in this course.');
        }

        // Create enrollment
        $course->enrollments()->create([
            'user_id' => $student->id,
            'progress' => 0,
            'completed' => false,
        ]);

        // Update student count
        $course->increment('students_count');

        return redirect()->back()->with('success', 'Student enrolled successfully!');
    }

    /**
     * Remove a student from a course
     */
    public function removeStudent(Request $request, Course $course)
    {
        $user = auth()->user();
        
        // Check authorization
        if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
            abort(403);
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $enrollment = $course->enrollments()->where('user_id', $validated['student_id'])->first();
        if ($enrollment) {
            $enrollment->delete();
            $course->decrement('students_count');
            return redirect()->back()->with('success', 'Student removed from course.');
        }

        return redirect()->back()->with('error', 'Enrollment not found.');
    }

    /**
     * Publish a course
     */
    public function publish(Course $course)
    {
        $user = auth()->user();
        
        // Check authorization
        if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
            abort(403);
        }

        $course->update(['is_published' => true]);

        return redirect()->back()->with('success', 'Course published!');
    }

    /**
     * Unpublish a course
     */
    public function unpublish(Course $course)
    {
        $user = auth()->user();
        
        // Check authorization
        if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
            abort(403);
        }

        $course->update(['is_published' => false]);

        return redirect()->back()->with('success', 'Course unpublished.');
    }
}
