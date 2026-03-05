<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index(Request $request)
    {
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

        $data = [
            'userCount' => $userCount,
            'recentUsers' => $recentUsers,
            'newSignupsToday' => $newSignupsToday,
            'activeCourses' => $activeCourses,
            'enrollmentCount' => $enrollmentCount,
            'progress' => $progress,
            'badges' => $badges,
            'hours' => $hours,
        ];

        return view('Admin.dashboard', $data);
    }
}
