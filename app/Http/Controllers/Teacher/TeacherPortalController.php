<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AttendanceRecord;
use App\Models\ClassSchedule;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class TeacherPortalController extends Controller
{
    public function classes()
    {
        $courses = $this->teacherCourses()->load('enrollments.user');

        return view('teacher.classes.index', compact('courses'));
    }

    public function schedule()
    {
        $schedules = ClassSchedule::with('course')
            ->where('teacher_id', auth()->id())
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->get();

        return view('teacher.schedule.index', compact('schedules'));
    }

    public function createSchedule()
    {
        $courses = \App\Models\Course::where('instructor_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('teacher.schedule.create', compact('courses'));
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['nullable', 'exists:courses,id'],
            'subject_name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room_number' => ['nullable', 'string', 'max:50'],
            'building' => ['nullable', 'string', 'max:100'],
            'student_count' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if (! empty($validated['course_id'])) {
            $course = \App\Models\Course::findOrFail($validated['course_id']);
            abort_unless($course->instructor_id === auth()->id(), 403);
        }

        ClassSchedule::create([
            'teacher_id' => auth()->id(),
            'course_id' => $validated['course_id'] ?? null,
            'subject_name' => $validated['subject_name'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room_number' => $validated['room_number'] ?? null,
            'building' => $validated['building'] ?? null,
            'student_count' => $validated['student_count'] ?? 0,
            'notes' => $validated['notes'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('teacher.schedule.index')->with('success', 'Schedule saved successfully.');
    }

    public function editSchedule(ClassSchedule $schedule)
    {
        abort_unless($schedule->teacher_id === auth()->id(), 403);

        $courses = \App\Models\Course::where('instructor_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('teacher.schedule.edit', compact('schedule', 'courses'));
    }

    public function updateSchedule(Request $request, ClassSchedule $schedule)
    {
        abort_unless($schedule->teacher_id === auth()->id(), 403);

        $validated = $request->validate([
            'course_id' => ['nullable', 'exists:courses,id'],
            'subject_name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room_number' => ['nullable', 'string', 'max:50'],
            'building' => ['nullable', 'string', 'max:100'],
            'student_count' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (! empty($validated['course_id'])) {
            $course = \App\Models\Course::findOrFail($validated['course_id']);
            abort_unless($course->instructor_id === auth()->id(), 403);
        }

        $schedule->update([
            'course_id' => $validated['course_id'] ?? null,
            'subject_name' => $validated['subject_name'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room_number' => $validated['room_number'] ?? null,
            'building' => $validated['building'] ?? null,
            'student_count' => $validated['student_count'] ?? $schedule->student_count,
            'notes' => $validated['notes'] ?? null,
            'is_active' => $validated['is_active'] ?? $schedule->is_active,
        ]);

        return redirect()->route('teacher.schedule.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroySchedule(ClassSchedule $schedule)
    {
        abort_unless($schedule->teacher_id === auth()->id(), 403);

        $schedule->delete();

        return redirect()->route('teacher.schedule.index')->with('success', 'Schedule removed successfully.');
    }

    public function attendance(Request $request)
    {
        $date = $request->date('date')?->toDateString() ?? now()->toDateString();
        $allEnrollments = $this->teacherEnrollments();
        $courseId = $request->integer('course_id') ?: null;
        $section = trim((string) $request->input('section', ''));
        $enrollments = $allEnrollments
            ->when($courseId, fn ($rows) => $rows->where('course_id', $courseId))
            ->when($section !== '', fn ($rows) => $rows->filter(fn ($enrollment) => ($enrollment->section ?: $enrollment->batch_class) === $section))
            ->values();
        $records = AttendanceRecord::whereIn('enrollment_id', $enrollments->pluck('id'))
            ->whereDate('attendance_date', $date)
            ->get()
            ->keyBy('enrollment_id');
        $summary = [
            'total' => $enrollments->count(),
            'present' => $records->where('status', 'present')->count(),
            'absent' => $records->where('status', 'absent')->count(),
            'late' => $records->where('status', 'late')->count(),
            'excused' => $records->where('status', 'excused')->count(),
        ];
        $summary['rate'] = $summary['total'] > 0
            ? round((($summary['present'] + $summary['late']) / $summary['total']) * 100, 1)
            : 0;
        $programs = $allEnrollments->pluck('course')->filter()->unique('id')->sortBy('title')->values();
        $sections = $allEnrollments->map(fn ($enrollment) => $enrollment->section ?: $enrollment->batch_class)
            ->filter()->unique()->sort()->values();

        return view('teacher.attendance.index', compact('enrollments', 'records', 'date', 'summary', 'programs', 'sections', 'courseId', 'section'));
    }

    public function storeAttendance(Request $request)
    {
        $validated = $request->validate([
            'attendance_date' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*' => ['required', 'in:present,absent,late,excused'],
            'time_in' => ['nullable', 'array'],
            'time_in.*' => ['nullable', 'date_format:H:i'],
            'time_out' => ['nullable', 'array'],
            'time_out.*' => ['nullable', 'date_format:H:i'],
            'notes' => ['nullable', 'array'],
            'course_id' => ['nullable', 'integer'],
            'section' => ['nullable', 'string', 'max:100'],
        ]);
        $allowedEnrollments = $this->teacherEnrollments()->keyBy('id');

        foreach ($validated['attendance'] as $enrollmentId => $status) {
            $enrollment = $allowedEnrollments->get((int) $enrollmentId);
            if (! $enrollment) {
                continue;
            }

            AttendanceRecord::updateOrCreate(
                [
                    'enrollment_id' => $enrollment->id,
                    'attendance_date' => $validated['attendance_date'],
                ],
                [
                    'student_id' => $enrollment->user_id,
                    'course_id' => $enrollment->course_id,
                    'status' => $status,
                    'time_in' => $validated['time_in'][$enrollmentId] ?? null,
                    'time_out' => $validated['time_out'][$enrollmentId] ?? null,
                    'notes' => $validated['notes'][$enrollmentId] ?? null,
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('teacher.attendance.index', [
            'date' => $validated['attendance_date'],
            'course_id' => $validated['course_id'] ?? null,
            'section' => $validated['section'] ?? null,
        ])
            ->with('success', 'Attendance saved successfully.');
    }

    public function exportAttendance(Request $request)
    {
        $date = $request->date('date')?->toDateString() ?? now()->toDateString();
        $enrollments = $this->teacherEnrollments()
            ->when($request->integer('course_id'), fn ($rows) => $rows->where('course_id', $request->integer('course_id')))
            ->when(trim((string) $request->input('section', '')) !== '', fn ($rows) => $rows->filter(fn ($enrollment) => ($enrollment->section ?: $enrollment->batch_class) === trim((string) $request->input('section'))));
        $records = AttendanceRecord::with(['student', 'course'])
            ->whereIn('enrollment_id', $enrollments->pluck('id'))
            ->whereDate('attendance_date', $date)
            ->get();

        return response()->streamDownload(function () use ($records) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Trainee', 'Program', 'Date', 'Status', 'Time in', 'Time out', 'Notes']);
            foreach ($records as $record) {
                fputcsv($output, [
                    $record->student?->name ?? 'Unknown student',
                    $record->course?->title ?? '',
                    $record->attendance_date?->format('Y-m-d'),
                    ucfirst($record->status),
                    $record->time_in?->format('H:i'),
                    $record->time_out?->format('H:i'),
                    $record->notes ?? '',
                ]);
            }
            fclose($output);
        }, 'attendance-' . $date . '.csv', ['Content-Type' => 'text/csv']);
    }

    public function attendanceHistory(Request $request)
    {
        $enrollments = $this->teacherEnrollments();
        $courseId = $request->integer('course_id') ?: null;
        $status = trim((string) $request->input('status', ''));
        $from = $request->date('from')?->toDateString();
        $to = $request->date('to')?->toDateString();
        $search = trim((string) $request->input('search', ''));

        $records = AttendanceRecord::with(['student', 'course', 'enrollment'])
            ->whereIn('enrollment_id', $enrollments->pluck('id'))
            ->when($courseId, fn ($query) => $query->where('course_id', $courseId))
            ->when($status !== '' && in_array($status, ['present', 'late', 'absent', 'excused'], true), fn ($query) => $query->where('status', $status))
            ->when($from, fn ($query) => $query->whereDate('attendance_date', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('attendance_date', '<=', $to))
            ->latest('attendance_date')
            ->latest('id')
            ->get();

        if ($search !== '') {
            $records = $records->filter(fn ($record) => str_contains(strtolower($record->student?->name ?? ''), strtolower($search)))->values();
        }

        $summary = [
            'total' => $records->count(),
            'present' => $records->where('status', 'present')->count(),
            'late' => $records->where('status', 'late')->count(),
            'absent' => $records->where('status', 'absent')->count(),
            'excused' => $records->where('status', 'excused')->count(),
        ];
        $summary['rate'] = $summary['total'] > 0
            ? round((($summary['present'] + $summary['late']) / $summary['total']) * 100, 1)
            : 0;
        $programs = $enrollments->pluck('course')->filter()->unique('id')->sortBy('title')->values();

        return view('teacher.attendance.history', compact('records', 'programs', 'summary', 'courseId', 'status', 'from', 'to', 'search'));
    }

    public function attendanceHistoryPrint(Request $request)
    {
        $data = $this->attendanceHistory($request)->getData();

        return view('teacher.attendance.print', $data);
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
            'attendance_present' => $attendance->where('status', 'present')->count(),
            'attendance_late' => $attendance->where('status', 'late')->count(),
            'attendance_absent' => $attendance->where('status', 'absent')->count(),
        ];

        return view('teacher.reports.index', compact('enrollments', 'summary', 'attendance'));
    }

    public function announcements()
    {
        $announcements = NewsItem::published()
            ->where(function ($query) {
                $query->whereNull('target_audience')
                    ->orWhere('target_audience', 'like', '%teacher%')
                    ->orWhere('target_audience', 'like', '%all%');
            })
            ->latest('published_at')
            ->get();

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function materials()
    {
        $modules = Module::with('course')
            ->whereHas('course', fn ($query) => $query->where('instructor_id', auth()->id()))
            ->latest()
            ->get();

        return view('teacher.materials.index', compact('modules'));
    }

    public function competency()
    {
        $modules = Module::with('course')
            ->whereHas('course', fn ($query) => $query->where('instructor_id', auth()->id()))
            ->orderBy('course_id')
            ->orderBy('order')
            ->get();

        return view('teacher.competency.index', compact('modules'));
    }

    public function account()
    {
        return view('teacher.account.index', ['user' => auth()->user()]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        auth()->user()->update(['password' => Hash::make($validated['password'])]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function assessments()
    {
        $assessments = Assessment::with('module.course')
            ->whereHas('module.course', fn ($query) => $query->where('instructor_id', auth()->id()))
            ->latest()
            ->get();

        return view('teacher.assessments.index', compact('assessments'));
    }

    private function teacherCourses(): Collection
    {
        $teacher = auth()->user();

        return \App\Models\Course::with(['enrollments.user', 'subjects', 'modules'])
            ->where(function ($query) use ($teacher) {
                $query->where('instructor_id', $teacher->id)
                    ->orWhere('instructor_name', $teacher->name ?? '')
                    ->orWhereHas('subjects', fn ($subjectQuery) => $subjectQuery->where('teacher_id', $teacher->id));
            })
            ->orderBy('title')
            ->get();
    }

    private function teacherEnrollments(): Collection
    {
        $teacher = auth()->user();

        return Enrollment::with(['user', 'course', 'subject'])
            ->whereHas('course', function ($query) use ($teacher) {
                $query->where('instructor_id', $teacher->id)
                    ->orWhere('instructor_name', $teacher->name ?? '')
                    ->orWhereHas('subjects', fn ($subjectQuery) => $subjectQuery->where('teacher_id', $teacher->id));
            })
            ->latest()
            ->get();
    }
}
