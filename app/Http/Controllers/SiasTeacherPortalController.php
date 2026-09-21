<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AttendanceRecord;
use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SiasTeacherPortalController extends Controller
{
    public function programs()
    {
        $courses = $this->teacherCourses()->loadCount('enrollments');
        return view('sias.teacher.programs.index', compact('courses'));
    }

    public function classes()
    {
        $enrollments = $this->teacherEnrollments();
        $batches = $enrollments->groupBy(fn ($enrollment) => $enrollment->batch_class ?: 'Unassigned batch');
        return view('sias.teacher.classes.index', compact('batches'));
    }

    public function trainees(Request $request)
    {
        $enrollments = $this->teacherEnrollments();
        $batch = $request->query('batch');

        if ($batch) {
            $enrollments = $enrollments->filter(function ($enrollment) use ($batch) {
                return ($enrollment->batch_class ?: 'Unassigned batch') === $batch;
            });
        }

        return view('sias.teacher.trainees.index', compact('enrollments', 'batch'));
    }

    public function attendance(Request $request)
    {
        $enrollments = $this->teacherEnrollments();
        $date = $request->date('date')?->toDateString() ?? now()->toDateString();
        $records = AttendanceRecord::whereIn('enrollment_id', $enrollments->pluck('id'))
            ->whereDate('attendance_date', $date)->get()->keyBy('enrollment_id');
        $summary = $records->countBy('status');
        return view('sias.teacher.attendance.index', compact('enrollments', 'records', 'date', 'summary'));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'attendance_date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*' => ['required', 'in:present,absent,late'],
            'notes' => ['nullable', 'array'],
        ]);
        $enrollments = $this->teacherEnrollments()->keyBy('id');
        foreach ($validated['attendance'] as $id => $status) {
            $enrollment = $enrollments->get((int) $id);
            if (! $enrollment) continue;
            AttendanceRecord::updateOrCreate(
                ['enrollment_id' => $enrollment->id, 'attendance_date' => $validated['attendance_date']],
                ['student_id' => $enrollment->user_id, 'course_id' => $enrollment->course_id, 'status' => $status, 'notes' => $validated['notes'][$id] ?? null, 'recorded_by' => auth()->id()]
            );
        }
        return redirect()->route('sias.teacher.attendance', ['date' => $validated['attendance_date']])->with('success', 'Attendance saved successfully.');
    }

    public function competency()
    {
        $modules = Module::with('course')->whereIn('course_id', $this->teacherCourses()->pluck('id'))->orderBy('course_id')->orderBy('order')->get();
        return view('sias.teacher.competency.index', compact('modules'));
    }

    public function assessments()
    {
        $assessments = Assessment::with('module.course')->whereHas('module', fn ($query) => $query->whereIn('course_id', $this->teacherCourses()->pluck('id')))->latest()->get();
        return view('sias.teacher.assessments.index', compact('assessments'));
    }

    public function materials()
    {
        $modules = Module::with('course')->whereIn('course_id', $this->teacherCourses()->pluck('id'))->latest()->get();
        return view('sias.teacher.materials.index', compact('modules'));
    }

    public function progress()
    {
        $enrollments = $this->teacherEnrollments();
        return view('sias.teacher.progress.index', compact('enrollments'));
    }

    public function reports()
    {
        $enrollments = $this->teacherEnrollments();
        $attendance = AttendanceRecord::whereIn('enrollment_id', $enrollments->pluck('id'))->get();
        $summary = [
            'trainees' => $enrollments->pluck('user_id')->unique()->count(),
            'programs' => $enrollments->pluck('course_id')->unique()->count(),
            'completed' => $enrollments->where('completed', true)->count(),
            'average_progress' => round($enrollments->avg('progress') ?? 0, 1),
            'present' => $attendance->where('status', 'present')->count(),
            'late' => $attendance->where('status', 'late')->count(),
            'absent' => $attendance->where('status', 'absent')->count(),
        ];
        return view('sias.teacher.reports.index', compact('enrollments', 'summary'));
    }

    public function announcements()
    {
        $announcements = NewsItem::published()->where(function ($query) {
            $query->whereNull('target_audience')->orWhere('target_audience', 'like', '%teacher%')->orWhere('target_audience', 'like', '%all%');
        })->latest('published_at')->get();
        return view('sias.teacher.announcements.index', compact('announcements'));
    }

    private function teacherCourses(): Collection
    {
        $teacher = auth()->user();
        return Course::where(function ($query) use ($teacher) {
            $query->where('instructor_id', $teacher->id)->orWhere(function ($fallback) use ($teacher) {
                $fallback->whereNull('instructor_id')->where('instructor_name', $teacher->name);
            });
        })->get();
    }

    private function teacherEnrollments(): Collection
    {
        return Enrollment::with(['user', 'course', 'subject'])
            ->whereIn('course_id', $this->teacherCourses()->pluck('id'))
            ->latest()->get();
    }
}
