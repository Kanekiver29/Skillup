<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Assessment;
use App\Models\AttendanceRecord;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SiasTeacherDashboardController extends Controller
{
    /**
     * Show the teacher dashboard
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
                ->get();
        } else {
            $courses = Course::where('instructor_name', $user->name ?? '')
                ->get();
        }

        $courseIds = $courses->pluck('id');

        $teacherEnrollments = Enrollment::whereIn('course_id', $courseIds)->get();
        $totalTrainees = $teacherEnrollments->pluck('user_id')->unique()->count();
        $activeTrainingSessions = ClassSchedule::where('teacher_id', $user->id)->where('is_active', true)->count();
        $upcomingAssessments = Assessment::whereHas('module', fn ($query) => $query->whereIn('course_id', $courseIds))->where('is_published', true)->count();
        $todayAttendance = AttendanceRecord::whereIn('enrollment_id', $teacherEnrollments->pluck('id'))->whereDate('attendance_date', now())->get();
        $attendanceSummary = [
            'present' => $todayAttendance->where('status', 'present')->count(),
            'late' => $todayAttendance->where('status', 'late')->count(),
            'absent' => $todayAttendance->where('status', 'absent')->count(),
        ];

        // Get statistics
        $totalCourses = $courses->count();
        $activeCourses = $courses->where('is_published', true)->count();
        $draftCourses = $totalCourses - $activeCourses;
        $totalStudents = $courses->sum('students_count');
        $averageRating = $courses->avg('rating') ?? 0;

        // Get recent enrollments
        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        // Get students in progress (not completed)
        $studentsInProgress = Enrollment::whereIn('course_id', $courseIds)
            ->where('completed', false)
            ->with(['user', 'course'])
            ->orderByDesc('progress')
            ->take(10)
            ->get();

        // Get courses by level
        $coursesByLevel = $courses->groupBy('level')->map->count();

        // Get this week's enrollments
        $weekStart = Carbon::now()->startOfWeek();
        $enrollmentsThisWeek = Enrollment::whereIn('course_id', $courseIds)
            ->where('created_at', '>=', $weekStart)
            ->count();

        // Calculate completion statistics
        $completedEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->where('completed', true)
            ->count();

        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->count();

        $completionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 1) : 0;

        // Get average progress
        $averageProgress = Enrollment::whereIn('course_id', $courseIds)
            ->avg('progress') ?? 0;

        // ----- Additional data for enhanced dashboard -----

        // Today's schedule
        $todayName = Carbon::now()->format('l'); // e.g. "Monday"
        $todaySchedules = collect();
        try {
            if (Schema::hasTable('class_schedules')) {
                $todaySchedules = ClassSchedule::where('teacher_id', $user->id)
                    ->where('day_of_week', $todayName)
                    ->where('is_active', true)
                    ->orderBy('start_time')
                    ->get();
            }
        } catch (\Exception $e) {
            // class_schedules table might not exist
        }

        // Teacher's subjects
        $subjects = collect();
        try {
            if (Schema::hasTable('subjects')) {
                $subjects = Subject::where('teacher_id', $user->id)->get();
            }
        } catch (\Exception $e) {
            // subjects table might not exist
        }
        $totalSubjects = $subjects->count();

        // Top performing students (highest progress across all teacher's courses)
        $topStudents = Enrollment::whereIn('course_id', $courseIds)
            ->where('progress', '>', 0)
            ->with(['user', 'course'])
            ->orderByDesc('progress')
            ->take(5)
            ->get();

        // Enrollment trend: enrollments per day for last 7 days
        $enrollmentTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $count = Enrollment::whereIn('course_id', $courseIds)
                ->whereDate('created_at', $day->toDateString())
                ->count();
            $enrollmentTrend[] = [
                'label' => $day->format('D'),
                'date' => $day->format('M d'),
                'count' => $count,
            ];
        }

        // Month-over-month enrollment change
        $thisMonthEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
        $lastMonthEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->where('created_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->where('created_at', '<', Carbon::now()->startOfMonth())
            ->count();
        $enrollmentChange = $lastMonthEnrollments > 0
            ? round((($thisMonthEnrollments - $lastMonthEnrollments) / $lastMonthEnrollments) * 100, 1)
            : ($thisMonthEnrollments > 0 ? 100 : 0);

        // Course performance: per-course student count and avg progress
        $coursePerformance = [];
        foreach ($courses->take(6) as $course) {
            $enrollments = Enrollment::where('course_id', $course->id);
            $coursePerformance[] = [
                'title' => $course->title,
                'students' => $enrollments->count(),
                'avg_progress' => round($enrollments->avg('progress') ?? 0, 1),
                'completed' => Enrollment::where('course_id', $course->id)->where('completed', true)->count(),
                'is_published' => $course->is_published,
                'level' => $course->level ?? 'N/A',
            ];
        }

        // Upcoming week schedule count
        $weekScheduleCount = 0;
        try {
            if (Schema::hasTable('class_schedules')) {
                $weekScheduleCount = ClassSchedule::where('teacher_id', $user->id)
                    ->where('is_active', true)
                    ->count();
            }
        } catch (\Exception $e) {}

        // Students needing attention (low progress, enrolled more than 7 days ago)
        $studentsNeedingAttention = Enrollment::whereIn('course_id', $courseIds)
            ->where('completed', false)
            ->where('progress', '<', 25)
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->with(['user', 'course'])
            ->orderBy('progress')
            ->take(5)
            ->get();

        return view('sias.teacher.dashboard.index', [
            'user' => $user,
            'courses' => $courses,
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'draftCourses' => $draftCourses,
            'totalStudents' => $totalStudents,
            'totalTrainees' => $totalTrainees,
            'activeTrainingSessions' => $activeTrainingSessions,
            'upcomingAssessments' => $upcomingAssessments,
            'attendanceSummary' => $attendanceSummary,
            'averageRating' => round($averageRating, 1),
            'recentEnrollments' => $recentEnrollments,
            'studentsInProgress' => $studentsInProgress,
            'coursesByLevel' => $coursesByLevel,
            'enrollmentsThisWeek' => $enrollmentsThisWeek,
            'completedEnrollments' => $completedEnrollments,
            'totalEnrollments' => $totalEnrollments,
            'completionRate' => $completionRate,
            'averageProgress' => round($averageProgress, 1),
            // New data
            'todaySchedules' => $todaySchedules,
            'totalSubjects' => $totalSubjects,
            'topStudents' => $topStudents,
            'enrollmentTrend' => $enrollmentTrend,
            'enrollmentChange' => $enrollmentChange,
            'thisMonthEnrollments' => $thisMonthEnrollments,
            'coursePerformance' => $coursePerformance,
            'weekScheduleCount' => $weekScheduleCount,
            'studentsNeedingAttention' => $studentsNeedingAttention,
            'todayName' => $todayName,
        ]);
    }

    /**
     * Get dashboard data via API (for AJAX updates)
     */
    public function getData(Request $request)
    {
        $user = $request->user();
        
        if (Schema::hasColumn('courses', 'instructor_id')) {
            $courses = Course::where('instructor_id', $user->id)
                ->orWhere(function($q) use ($user) {
                    $q->whereNull('instructor_id')->where('instructor_name', $user->name ?? '');
                })
                ->get();
        } else {
            $courses = Course::where('instructor_name', $user->name ?? '')
                ->get();
        }

        $courseIds = $courses->pluck('id');

        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user', 'course'])
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)->count();
        $completedEnrollments = Enrollment::whereIn('course_id', $courseIds)->where('completed', true)->count();
        $completionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 1) : 0;

        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'recentEnrollments' => $recentEnrollments,
            'totalStudents' => $courses->sum('students_count'),
            'totalEnrollments' => $totalEnrollments,
            'completedEnrollments' => $completedEnrollments,
            'completionRate' => $completionRate,
            'averageProgress' => round(Enrollment::whereIn('course_id', $courseIds)->avg('progress') ?? 0, 1),
        ]);
    }
}
