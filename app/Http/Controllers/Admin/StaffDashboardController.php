<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    /**
     * Show the staff dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->hasStaffAccess()) {
            abort(403, 'Forbidden');
        }

        // Staff metrics - courses created/managed by staff
        $totalCourses = Course::count();
        $activeCoursesCount = Course::where('status', 'Active')->count();
        $draftCoursesCount = Course::where('status', 'Draft')->count();
        $totalStudents = Enrollment::count();
        $pendingStudents = Enrollment::where('status', 'pending')->count(); // adjust column as needed
        $totalUploads = 0; // placeholder: replace with actual Upload model count if available
        $newModulesThisWeek = Module::whereDate('created_at', now()->subWeek())->count(); // placeholder logic

        // Remove duplicate activeCourses assignment
        // $activeCourses = Course::count(); // deprecated
        $enrollmentCount = Enrollment::count();
        $newEnrollmentsToday = Enrollment::whereDate('created_at', now()->toDateString())->count();

        // Demo metrics for badges/hours
        $badges = 45;
        $hours = 1200;
        $progress = 48;

        // Monthly enrollments for the last 6 months
        $monthlyEnrollments = [];
        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->format('M Y');
            $monthlyEnrollments[] = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Daily enrollment data (last 7 days)
        $dailyLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[] = $date->format('M d');
            $dailyData[] = Enrollment::whereDate('created_at', $date->toDateString())->count();
        }

        // Weekly enrollment data (last 4 weeks)
        $weeklyLabels = [];
        $weeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startDate = now()->subWeeks($i)->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();
            $weeklyLabels[] = 'W' . $startDate->format('W');
            $weeklyData[] = Enrollment::whereBetween('created_at', [$startDate, $endDate])->count();
        }

        // Monthly enrollment data (last 6 months) - repeated for chart
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');
            $monthlyData[] = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $totalModules = Module::count();
        $totalLessons = Lesson::count();
        $publishedCourses = Course::where('is_published', true)->count();

        // Student counts for monitoring pie chart
        $totalUsers = User::where('is_admin', false)->count();
        $uniqueEnrolledStudents = Enrollment::distinct('user_id')->count();
        $notEnrolled = max(0, $totalUsers - $uniqueEnrolledStudents);

        $topCourses = Course::withCount('enrollments')
    ->orderByDesc('enrollments_count')
    ->take(5)
    ->get();

$recentEnrollments = Enrollment::with(['user', 'course'])
    ->latest()
    ->take(5)
    ->get();

$recentStudents = $recentEnrollments; // alias for view

$recentActivities = collect(); // placeholder for activity logs

        $recentCourses = Course::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentStudents = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $courses = Course::with('modules')
            ->orderBy('title')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'title' => $c->title,
                    'short_description' => $c->short_description ?? $c->description,
                    'thumbnail' => $c->thumbnail ?? null,
                    'status' => $c->is_published ? 'published' : 'draft',
                    'progress' => intval($c->progress ?? 0),
                    'duration' => $c->duration ?? intval($c->modules->sum('duration')),
                    'modules' => $c->modules->map(function ($m) {
                        return [
                            'id' => $m->id,
                            'module_title' => $m->title ?? ($m->name ?? null),
                            'course_id' => $m->course_id ?? null,
                            'type' => $m->type ?? null,
                            'duration' => $m->duration ?? null,
                            'thumbnail' => $m->thumbnail ?? null,
                        ];
                    })->values()->toArray(),
                ];
            })->toArray();

        $modules = Module::select('id', 'course_id', 'title as module_title', 'type', 'duration', 'thumbnail')
            ->get()
            ->toArray();

        $data = [
            'totalCourses' => $totalCourses,
            'activeCoursesCount' => $activeCoursesCount,
            'draftCoursesCount' => $draftCoursesCount,
            'totalStudents' => $totalStudents,
            'pendingStudents' => $pendingStudents,
            'totalUploads' => $totalUploads,
            'newModulesThisWeek' => $newModulesThisWeek,
            'user' => $user,
            'activeCourses' => $activeCoursesCount,
            'enrollmentCount' => $enrollmentCount,
            'newEnrollmentsToday' => $newEnrollmentsToday,
            'progress' => $progress,
            'badges' => $badges,
            'hours' => $hours,
            'totalModules' => $totalModules,
            'totalLessons' => $totalLessons,
            'publishedCourses' => $publishedCourses,
            'topCourses' => $topCourses,
            'recentEnrollments' => $recentEnrollments,
            'recentCourses' => $recentCourses,
            'recentActivities' => $recentActivities,
            'chartLabels' => $chartLabels,
            'monthlyEnrollments' => $monthlyEnrollments,
            'dailyLabels' => $dailyLabels,
            'dailyData' => $dailyData,
            'weeklyLabels' => $weeklyLabels,
            'weeklyData' => $weeklyData,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
            'courses' => $courses,
            'modules' => $modules,
            'totalUsers' => $totalUsers,
            'uniqueEnrolledStudents' => $uniqueEnrolledStudents,
            'notEnrolled' => $notEnrolled,
        ];

        return view('staff.dashboard', $data);
    }
}
