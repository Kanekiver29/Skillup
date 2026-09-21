<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if user is admin or staff
        if (! $user || (! $user->is_admin && ! $user->hasStaffAccess())) {
            abort(403, 'Forbidden');
        }

        // Redirect staff (non-admin) users to their own dashboard
        if ($user->isStaff() && ! $user->is_admin) {
            return redirect()->route('admin.staff.dashboard');
        }

        $userCount = User::count();
        $recentUsers = User::latest()->take(6)->get();

        // calculate some simple metrics
        $newSignupsToday = User::whereDate('created_at', now()->toDateString())->count();
        $activeCourses = Course::count(); // total course paths
        $enrollmentCount = \App\Models\Enrollment::count();

        // demo metrics for badges/hours remain static until real implementation
        $badges = 124;
        $hours = 2540;
        $progress = 62;

        // Monthly signups & enrollments for the last 6 months (engagement chart)
        $monthlySignups = [];
        $monthlyEnrollments = [];
        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[] = $date->format('M Y');
            $monthlySignups[] = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyEnrollments[] = \App\Models\Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Daily enrollment data (last 7 days)
        $dailyLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[] = $date->format('M d');
            $dailyData[] = \App\Models\Enrollment::whereDate('created_at', $date->toDateString())->count();
        }

        // Weekly enrollment data (last 4 weeks)
        $weeklyLabels = [];
        $weeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startDate = now()->subWeeks($i)->startOfWeek();
            $endDate = $startDate->copy()->endOfWeek();
            $weeklyLabels[] = 'W' . $startDate->format('W');
            $weeklyData[] = \App\Models\Enrollment::whereBetween('created_at', [$startDate, $endDate])->count();
        }

        // Monthly enrollment data (last 6 months)
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');
            $monthlyData[] = \App\Models\Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Yearly enrollment data (last 4 years)
        $yearlyLabels = [];
        $yearlyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            $yearlyLabels[] = (string)$year;
            $yearlyData[] = \App\Models\Enrollment::whereYear('created_at', $year)->count();
        }

        // Enrollment breakdown by course category for college chart
        $collegeBreakdown = Enrollment::join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->selectRaw('COALESCE(NULLIF(courses.category, ""), "Other") as category, COUNT(DISTINCT enrollments.user_id) as students')
            ->groupBy('category')
            ->orderByDesc('students')
            ->get();

        $collegeLabels = $collegeBreakdown->pluck('category')->map(fn ($label) => ucwords($label))->toArray();
        $collegeData = $collegeBreakdown->pluck('students')->toArray();

        if (empty($collegeLabels)) {
            $collegeLabels = ['Business', 'Sciences', 'Arts', 'Architecture'];
            $collegeData = [0, 0, 0, 0];
        }

        $data = [
            'user' => $user,
            'userCount' => $userCount,
            'recentUsers' => $recentUsers,
            'newSignupsToday' => $newSignupsToday,
            'activeCourses' => $activeCourses,
            'enrollmentCount' => $enrollmentCount,
            'progress' => $progress,
            'badges' => $badges,
            'hours' => $hours,
            'chartLabels' => $chartLabels,
            'monthlySignups' => $monthlySignups,
            'monthlyEnrollments' => $monthlyEnrollments,
            'dailyLabels' => $dailyLabels,
            'dailyData' => $dailyData,
            'weeklyLabels' => $weeklyLabels,
            'weeklyData' => $weeklyData,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
            'yearlyLabels' => $yearlyLabels,
            'yearlyData' => $yearlyData,
            'collegeLabels' => $collegeLabels,
            'collegeData' => $collegeData,
        ];

        $dashboardView = $request->routeIs('sias.admin.dashboard')
            ? 'sias.admin.dashboard'
            : 'Admin.dashboard';

        return view($dashboardView, $data);
    }

    /**
     * Return real-time enrollment chart data + recent activity as JSON (polled by the dashboard).
     */
    public function liveData(Request $request)
    {
        $user = $request->user();
        if (!$user || (!$user->is_admin && !$user->hasStaffAccess())) {
            abort(403);
        }

        // --- chart data ---
        $daily = $this->buildSeries('day', 6);
        $weekly = $this->buildSeries('week', 3);
        $monthly = $this->buildSeries('month', 5);
        $yearly = $this->buildSeries('year', 3);

        // --- recent activity (last 15 enrollments) ---
        $recentEnrollments = Enrollment::with(['user:id,name,email,profile_image', 'course:id,title'])
            ->latest()
            ->take(15)
            ->get()
            ->map(fn ($e) => [
                'student'    => $e->user->name ?? 'Unknown',
                'email'      => $e->user->email ?? '',
                'avatar'     => $e->user->profile_image
                    ? asset('uploads/profiles/' . $e->user->profile_image)
                    : null,
                'initials'   => strtoupper(substr($e->user->name ?? '?', 0, 1)),
                'course'     => $e->course->course_title ?? $e->course->title ?? 'Unknown Course',
                'time'       => $e->created_at->diffForHumans(),
                'timestamp'  => $e->created_at->toIso8601String(),
            ]);

        // --- live counters ---
        $onlineToday = User::whereDate('updated_at', now()->toDateString())->count();
        $enrolledToday = Enrollment::whereDate('created_at', now()->toDateString())->count();
        $totalStudents = User::where('is_admin', false)->where('role', '!=', 'staff')->count();

        return response()->json([
            'chart' => [
                'daily'   => $daily,
                'weekly'  => $weekly,
                'monthly' => $monthly,
                'yearly'  => $yearly,
                'college' => $this->buildCollegeSeries(),
            ],
            'activity' => $recentEnrollments,
            'counters' => [
                'onlineToday'   => $onlineToday,
                'enrolledToday' => $enrolledToday,
                'totalStudents' => $totalStudents,
            ],
        ]);
    }

    /**
     * Build labels + data arrays for a given interval.
     */
    private function buildSeries(string $unit, int $lookback): array
    {
        $labels = [];
        $data   = [];

        for ($i = $lookback; $i >= 0; $i--) {
            $date = now()->sub($unit, $i);

            switch ($unit) {
                case 'day':
                    $labels[] = $date->format('M d');
                    $data[]   = Enrollment::whereDate('created_at', $date->toDateString())->count();
                    break;
                case 'week':
                    $start = (clone $date)->startOfWeek();
                    $end   = (clone $date)->endOfWeek();
                    $labels[] = $start->format('M d') . ' – ' . $end->format('M d');
                    $data[]   = Enrollment::whereBetween('created_at', [$start, $end])->count();
                    break;
                case 'month':
                    $labels[] = $date->format('M Y');
                    $data[]   = Enrollment::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)->count();
                    break;
                case 'year':
                    $labels[] = (string) $date->year;
                    $data[]   = Enrollment::whereYear('created_at', $date->year)->count();
                    break;
            }
        }

        return compact('labels', 'data');
    }

    private function buildCollegeSeries(): array
    {
        $breakdown = Enrollment::join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->selectRaw('COALESCE(NULLIF(courses.category, ""), "Other") as category, COUNT(DISTINCT enrollments.user_id) as students')
            ->groupBy('category')
            ->orderByDesc('students')
            ->get();

        $labels = $breakdown->pluck('category')->map(fn ($label) => ucwords($label))->toArray();
        $data = $breakdown->pluck('students')->toArray();

        if (empty($labels)) {
            $labels = ['Business', 'Sciences', 'Arts', 'Architecture'];
            $data = [0, 0, 0, 0];
        }

        return compact('labels', 'data');
    }
}
