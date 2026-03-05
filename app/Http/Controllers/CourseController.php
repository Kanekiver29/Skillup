<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display all courses.
     */
    public function index(Request $request)
    {
        $query = Course::where('is_published', true);

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Level filter
        if ($request->has('level') && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        // Category filter
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $courses = $query->paginate(12);
        
        // Get all unique categories for filter dropdown
        $categories = Course::where('is_published', true)
            ->distinct()
            ->pluck('category')
            ->sort();

        return view('courses.index', compact('courses', 'categories'));
    }

    /**
     * Display a specific course.
     */
    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->with(['lessons' => function ($query) {
                $query->where('is_published', true)->orderBy('order');
            }])
            ->firstOrFail();

        $isEnrolled = auth()->check() ? 
            Enrollment::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->exists() : false;

        return view('courses.show', compact('course', 'isEnrolled'));
    }

    /**
     * Enroll user in a course.
     */
    public function enroll($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'course_id' => $course->id,
            ]
        );

        return redirect()->route('courses.show', $slug)
            ->with('success', 'Successfully enrolled in ' . $course->title);
    }

    /**
     * Show user's enrolled courses.
     */
    public function myLearning()
    {
        $enrollments = Enrollment::where('user_id', auth()->id())
            ->with('course')
            ->get();

        return view('courses.my-learning', compact('enrollments'));
    }
}
