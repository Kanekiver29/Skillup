<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    /**
     * Display the user's learning roadmap.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect('/login');
        }

        // Get user's enrollments with course details
        // Load enrollments oldest-first so the timeline reads chronologically
        $enrollments = Enrollment::where('user_id', $user->id)
            ->with(['course' => function ($query) {
                // include module count for display in the roadmap
                $query->withCount('modules');
            }])
            ->orderBy('created_at', 'asc')
            ->get();

        // Separate enrollments by status
        $completedCourses = $enrollments->where('completed', true)->values();
        $inProgressCourses = $enrollments->where('completed', false)->where('progress', '>', 0)->values();
        $notStartedCourses = $enrollments->where('completed', false)->where('progress', '<=', 0)->values();

        // Get courses grouped by category for skill development
        $coursesByCategory = Course::where('is_published', true)
            ->get()
            ->groupBy('category');

        $totalEnrolled = $enrollments->count();
        $totalCompleted = $completedCourses->count();
        $completionRate = $totalEnrolled > 0 ? round(($totalCompleted / $totalEnrolled) * 100) : 0;
        $averageProgress = $totalEnrolled > 0
            ? (int) round($enrollments->avg(fn ($e) => (int) $e->progress))
            : 0;

        // Suggest the best course to continue (in progress, sorted by progress desc)
        $nextEnrollment = $inProgressCourses->sortByDesc('progress')->first();

        // Get user's skills from profile
        $userSkills = is_array($user->skills ?? null)
            ? $user->skills
            : (is_string($user->skills ?? null) ? array_filter(array_map('trim', explode(',', $user->skills))) : []);

        return view('Userpage.roadmap', [
            'user' => $user,
            'enrollments' => $enrollments,
            'completedCourses' => $completedCourses,
            'inProgressCourses' => $inProgressCourses,
            'notStartedCourses' => $notStartedCourses,
            'coursesByCategory' => $coursesByCategory,
            'totalEnrolled' => $totalEnrolled,
            'totalCompleted' => $totalCompleted,
            'completionRate' => $completionRate,
            'averageProgress' => $averageProgress,
            'overallProgress' => $averageProgress,
            'nextEnrollment' => $nextEnrollment,
            'userSkills' => $userSkills,
        ]);
    }
}
