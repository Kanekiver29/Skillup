<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\EnrollmentCreated;

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

        $courses = $query->withCount('likes')->paginate(12);
        
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
            ->with([
                'lessons' => function ($query) {
                    $query->where('is_published', true)->orderBy('order');
                },
                'modules' => function ($query) {
                    $query->where('is_published', true)
                          ->orderBy('order')
                          ->with(['lessons' => function ($query) {
                              $query->where('is_published', true);
                          }]);
                },
            ])
            ->firstOrFail();

        $enrollment = Auth::check()
            ? Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first()
            : null;

        $isEnrolled = (bool) $enrollment;

        return view('courses.show', compact('course', 'isEnrolled', 'enrollment'));
    }

    /**
     * Enroll user in a course.
     */
    public function enroll($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();

        $enrollment = Enrollment::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $course->id,
            ]
        );

        // Broadcast enrollment for realtime dashboards
        try {
            event(new EnrollmentCreated($enrollment));
        } catch (\Throwable $e) {
            // ignore broadcast failures
        }

        // If the course has modules, send the user directly into the first published module
        $firstModule = $course->modules()->where('is_published', true)->orderBy('order')->first();

        if ($firstModule) {
            return redirect()->route('modules.show', [$course->slug, $firstModule->slug])
                ->with('success', 'Enrolled and entering ' . $course->title);
        }

        // Fallback: send user to their learning dashboard
        return redirect()->route('courses.my-learning')
            ->with('success', 'Successfully enrolled in ' . $course->title);
    }

    /**
     * Show user's enrolled courses.
     */
    public function myLearning()
    {
        $enrollments = Enrollment::where('user_id', Auth::id())
            ->with('course')
            ->get();

        return view('courses.my-learning', compact('enrollments'));
    }
    /**
    * Show edit form for a course.
    */
    public function edit(Course $course)
    {
        return view('staff.courses.edit', compact('course'));
    }

    /**
     * Update a course.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'is_published' => 'sometimes|boolean',
        ]);

        $course->update($data);

        return redirect()->route('staff.dashboard')
            ->with('success', 'Course updated successfully.');
    }

}
