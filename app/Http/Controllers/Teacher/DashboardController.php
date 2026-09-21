<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AttendanceRecord;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        $courseIds = Course::where(function ($query) use ($teacher) {
            $query->where('instructor_id', $teacher->id)
                ->orWhere('instructor_name', $teacher->name ?? '')
                ->orWhereHas('subjects', fn ($subjectQuery) => $subjectQuery->where('teacher_id', $teacher->id));
        })->pluck('id');
        $enrollmentIds = Enrollment::whereIn('course_id', $courseIds)->pluck('id');
        $attendance = AttendanceRecord::whereIn('enrollment_id', $enrollmentIds)->whereDate('attendance_date', now())->get();
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->take(4)
            ->get();

        $activities = $recentEnrollments->map(function (Enrollment $enrollment) {
            $name = $enrollment->user?->name ?: 'A trainee';
            $initials = collect(preg_split('/\s+/', trim($name)))
                ->filter()
                ->take(2)
                ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                ->implode('');

            return [
                'initials' => $initials ?: 'TR',
                'text' => $name . ' enrolled in ' . ($enrollment->course?->title ?: 'a training program'),
                'time' => $enrollment->created_at?->diffForHumans() ?: 'Recently',
            ];
        })->values()->all();

        $stats = [
            'trainees' => Enrollment::whereIn('course_id', $courseIds)->distinct('user_id')->count('user_id'),
            'programs' => $courseIds->count(),
            'active_sessions' => Lesson::whereHas('module', fn ($query) => $query->whereIn('course_id', $courseIds))
                ->where('scheduled_at', '>=', now())
                ->where('scheduled_at', '<=', now()->addDays(7))
                ->count(),
            'upcoming_assessments' => Assessment::whereHas('module', fn ($query) => $query->whereIn('course_id', $courseIds))
                ->where('is_published', true)
                ->count(),
            'attendance_present' => $attendance->where('status', 'present')->count(),
            'attendance_late' => $attendance->where('status', 'late')->count(),
            'attendance_absent' => $attendance->where('status', 'absent')->count(),
        ];

        return view('teacher.dashboard', compact('stats', 'activities'));
    }
}
