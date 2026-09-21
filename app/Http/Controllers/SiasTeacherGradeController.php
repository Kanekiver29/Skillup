<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SiasTeacherGradeController extends Controller
{
    public function subjects()
    {
        $data = $this->getGradeData();

        return view('sias.teacher.subjects.index', $data);
    }

    public function index()
    {
        $data = $this->getGradeData();

        return view('sias.teacher.grades.grade', $data);
    }

    public function monitoringClass()
    {
        $teacher = Auth::user();
        $data = $this->getGradeData();

        $topStudents = $data['enrollments']
            ->filter(fn($enrollment) => is_numeric($enrollment->final_grade))
            ->groupBy('user_id')
            ->map(function ($enrollments) {
                $avgGrade = round($enrollments->avg('final_grade'), 1);
                $user = $enrollments->first()->user;
                return [
                    'name' => $user?->name ?? 'Student',
                    'grade' => $avgGrade,
                ];
            })
            ->sortByDesc('grade')
            ->take(6)
            ->values();

        $courseGrades = $data['courses']->map(function ($course) use ($data) {
            $courseEnrollments = $data['enrollments']->where('course_id', $course->id);
            $avgGrade = $courseEnrollments->filter(fn($enrollment) => is_numeric($enrollment->final_grade))->avg('final_grade');
            return [
                'title' => $course->title,
                'avg_grade' => $avgGrade ? round($avgGrade, 1) : 0,
                'students' => $course->enrollments_count,
            ];
        });

        $attendanceSummary = [
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'unknown' => 0,
            'rate' => 0,
            'trend' => [],
        ];

        $attendanceRows = AttendanceRecord::whereIn('course_id', $data['courses']->pluck('id'))
            ->whereDate('attendance_date', '>=', Carbon::today()->subDays(6))
            ->get();
        if ($attendanceRows->isNotEmpty()) {
            $attendanceSummary['present'] = $attendanceRows->where('status', 'present')->count();
            $attendanceSummary['absent'] = $attendanceRows->where('status', 'absent')->count();
            $attendanceSummary['late'] = $attendanceRows->where('status', 'late')->count();
            $attendanceSummary['rate'] = round(($attendanceSummary['present'] / $attendanceRows->count()) * 100, 1);
            $attendanceSummary['trend'] = $attendanceRows->groupBy(fn ($row) => $row->attendance_date->toDateString())
                ->map(fn ($rows, $day) => ['day' => $day, 'present' => $rows->where('status', 'present')->count()])
                ->values()->all();
        }

        return view('sias.teacher.monitoring-class', array_merge($data, [
            'topStudents' => $topStudents,
            'courseGrades' => $courseGrades,
            'attendanceSummary' => $attendanceSummary,
        ]));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        abort_unless($this->canManageEnrollment($enrollment), 403);

        $validated = $request->validate([
            'final_grade' => ['nullable', 'numeric', 'between:0,100'],
        ]);

        $enrollment->forceFill([
            'final_grade' => $validated['final_grade'] === null || $validated['final_grade'] === ''
                ? null
                : (float) $validated['final_grade'],
        ])->save();

        return redirect()->route('sias.teacher.grades.index')->with('success', 'Grade updated successfully.');
    }

    private function canManageEnrollment(Enrollment $enrollment): bool
    {
        $teacher = Auth::user();

        if (! $teacher) {
            return false;
        }

        $course = $enrollment->course;

        return $course && ($course->instructor_id == $teacher->id || $course->instructor_name === $teacher->name);
    }

    private function getGradeData(): array
    {
        $teacher = Auth::user();

        $courses = Course::query()
            ->withCount('enrollments')
            ->when($teacher, function ($query) use ($teacher) {
                $query->where(function ($courseQuery) use ($teacher) {
                    $courseQuery->where('instructor_id', $teacher->id)
                        ->orWhere('instructor_name', $teacher->name)
                        ->orWhereHas('subjects', function ($subQ) use ($teacher) {
                            $subQ->where('teacher_id', $teacher->id);
                        });
                });
            })
            ->orderBy('title')
            ->get();

        $courseIds = $courses->pluck('id');

        $enrollments = Enrollment::query()
            ->with(['user', 'course', 'subject'])
            ->whereIn('course_id', $courseIds)
            ->orderByDesc('created_at')
            ->get();

        return compact('courses', 'enrollments');
    }
}
