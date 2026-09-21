<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSchedule;

class SiasStudentScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $courseIds = $user->enrollments()->pluck('course_id');

        // Fetch schedules for enrolled courses
        $schedules = ClassSchedule::with(['course', 'teacher'])
            ->whereIn('course_id', $courseIds)
            ->where('is_active', true)
            ->orderBy('start_time')
            ->get();

        // Group by day of week
        $groupedSchedules = $schedules->groupBy('day_of_week');

        // Order the days logically
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        $orderedSchedules = [];
        foreach ($daysOfWeek as $day) {
            if ($groupedSchedules->has($day)) {
                $orderedSchedules[$day] = $groupedSchedules->get($day);
            }
        }

        return view('sias.students.schedule.index', compact('orderedSchedules', 'user'));
    }
}
