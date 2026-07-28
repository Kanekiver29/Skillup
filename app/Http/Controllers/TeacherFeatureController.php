<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Lesson;
use App\Models\Quiz;

class TeacherFeatureController extends Controller
{
    public function courses()
    {
        return view('teacher.courses.index');
    }

    public function dashboard()
    {
        // Gather statistics for the teacher dashboard
        $teacherId = auth()->id();
        // Active courses owned by this teacher
        $activeCourses = \App\Models\Course::where('instructor_id', $teacherId)->get();
        $activeCoursesCount = $activeCourses->count();
        // Total students enrolled in teacher's courses
        $totalStudents = \App\Models\Course::where('instructor_id', $teacherId)
            ->withCount('students')
            ->get()
            ->sum('students_count');
        // Assignments due soon (next 7 days)
        $assignmentsDue = \App\Models\Assignment::whereHas('course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(7))
            ->count();
        // Pending grading submissions
        $pendingGrading = \App\Models\Submission::whereHas('assignment.course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->whereNull('grade')
            ->count();
        // Upcoming sessions (lessons) for next 7 days
        $upcomingSessions = \App\Models\Lesson::whereHas('module.course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', now()->addDays(7))
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();
        // Recent submissions (last 5)
        $recentSubmissions = \App\Models\Submission::whereHas('assignment.course', function($q) use ($teacherId) {
                $q->where('instructor_id', $teacherId);
            })
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->with(['student', 'assignment'])
            ->get();
        // Simple teaching tips
        $tips = [
            'Try creating interactive quizzes to boost engagement.',
            'Regular feedback helps students improve faster.',
            'Use diverse content formats to cater to different learning styles.',
        ];
        $stats = [
            'active_courses' => $activeCoursesCount,
            'total_students' => $totalStudents,
            'assignments_due' => $assignmentsDue,
            'pending_grading' => $pendingGrading,
            'average_score' => null,
            'completion_rate' => null,
            'attendance_rate' => null,
            'engagement_level' => null,
        ];
        return view('teacher.dashboard', compact('stats', 'upcomingSessions', 'recentSubmissions', 'activeCourses', 'tips'));
    }

    public function quizzes()
    {
        // Load quizzes with module and course for listing in the teacher UI
        $quizzes = \App\Models\Quiz::with(['module.course'])->withCount('questions')->orderBy('created_at', 'desc')->get();
        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function modules()
    {
        return view('teacher.modules.index');
    }

    public function assignments()
    {
        return view('teacher.assignments.index');
    }

    public function assignmentCreate()
    {
        return view('teacher.assignments.create');
    }

    public function submissions()
    {
        return view('teacher.assignments.submissions');
    }

    public function grades()
    {
        return view('teacher.grades.index');
    }

    public function gradesEntry()
    {
        return view('teacher.grades.entry');
    }

    public function gradesReports()
    {
        return view('teacher.grades.reports');
    }

    public function attendanceToday()
    {
        return view('teacher.attendance.today');
    }

    public function attendanceRecords()
    {
        return view('teacher.attendance.records');
    }

    public function attendanceReports()
    {
        return view('teacher.attendance.reports');
    }

    public function progressOverview()
    {
        return view('teacher.progress.overview');
    }

    public function progressIndividual()
    {
        return view('teacher.progress.individual');
    }

    public function progressAnalytics()
    {
        return view('teacher.progress.analytics');
    }
}
