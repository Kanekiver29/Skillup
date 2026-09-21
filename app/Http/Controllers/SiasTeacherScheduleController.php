<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\Course;
use Illuminate\Http\Request;

class SiasTeacherScheduleController extends Controller
{
    /**
     * Display all schedules for the teacher
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get all schedules for this teacher, ordered by day and time
        $schedules = ClassSchedule::where('teacher_id', $user->id)
            ->with('course')
            ->get()
            ->sortBy(function($schedule) {
                return ClassSchedule::getDayIndex($schedule->day_of_week) * 1000 + 
                       strtotime($schedule->start_time);
            });

        // Get teacher's courses for the form
        $courses = Course::where('instructor_id', $user->id)
            ->orWhere(function($q) use ($user) {
                $q->whereNull('instructor_id')->where('instructor_name', $user->name ?? '');
            })
            ->get();

        // Group schedules by day
        $schedulesByDay = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        foreach ($days as $day) {
            $schedulesByDay[$day] = $schedules->where('day_of_week', $day)->values();
        }

        // Calculate statistics
        $totalClasses = $schedules->count();
        $activeClasses = $schedules->where('is_active', true)->count();
        $totalStudents = $schedules->sum('student_count');
        $hoursPerWeek = 0;
        foreach ($schedules as $schedule) {
            $hoursPerWeek += $schedule->getDurationMinutes() / 60;
        }

        return view('sias.teacher.schedule.index', [
            'schedules' => $schedules,
            'schedulesByDay' => $schedulesByDay,
            'courses' => $courses,
            'totalClasses' => $totalClasses,
            'activeClasses' => $activeClasses,
            'totalStudents' => $totalStudents,
            'hoursPerWeek' => round($hoursPerWeek, 1),
            'days' => $days,
        ]);
    }

    /**
     * Create a new schedule
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $courses = Course::where('instructor_id', $user->id)
            ->orWhere(function($q) use ($user) {
                $q->whereNull('instructor_id')->where('instructor_name', $user->name ?? '');
            })
            ->get();

        return view('sias.teacher.schedule.create', compact('courses'));
    }

    /**
     * Store a new schedule
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'course_id' => 'nullable|exists:courses,id',
            'student_count' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if course belongs to this teacher if provided
        if (!empty($validated['course_id'])) {
            $course = Course::findOrFail($validated['course_id']);
            if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
                abort(403);
            }
        }

        ClassSchedule::create([
            'teacher_id' => $user->id,
            'subject_name' => $validated['subject_name'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room_number' => $validated['room_number'],
            'building' => $validated['building'],
            'course_id' => $validated['course_id'] ?? null,
            'student_count' => $validated['student_count'] ?? 0,
            'notes' => $validated['notes'],
            'is_active' => true,
        ]);

        return redirect()->route('sias.teacher.schedule')->with('success', 'Schedule created successfully!');
    }

    /**
     * Edit a schedule
     */
    public function edit(ClassSchedule $schedule)
    {
        $user = auth()->user();
        
        if ($schedule->teacher_id !== $user->id) {
            abort(403);
        }

        $courses = Course::where('instructor_id', $user->id)
            ->orWhere(function($q) use ($user) {
                $q->whereNull('instructor_id')->where('instructor_name', $user->name ?? '');
            })
            ->get();

        return view('sias.teacher.schedule.edit', compact('schedule', 'courses'));
    }

    /**
     * Update a schedule
     */
    public function update(Request $request, ClassSchedule $schedule)
    {
        $user = auth()->user();
        
        if ($schedule->teacher_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'course_id' => 'nullable|exists:courses,id',
            'student_count' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        // Check if course belongs to this teacher if provided
        if (!empty($validated['course_id'])) {
            $course = Course::findOrFail($validated['course_id']);
            if (!($course->instructor_id === $user->id || (is_null($course->instructor_id) && $course->instructor_name === $user->name))) {
                abort(403);
            }
        }

        $schedule->update([
            'subject_name' => $validated['subject_name'],
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'room_number' => $validated['room_number'],
            'building' => $validated['building'],
            'course_id' => $validated['course_id'] ?? null,
            'student_count' => $validated['student_count'] ?? $schedule->student_count,
            'notes' => $validated['notes'],
            'is_active' => $validated['is_active'] ?? $schedule->is_active,
        ]);

        return redirect()->route('sias.teacher.schedule')->with('success', 'Schedule updated successfully!');
    }

    /**
     * Delete a schedule
     */
    public function destroy(ClassSchedule $schedule)
    {
        $user = auth()->user();
        
        if ($schedule->teacher_id !== $user->id) {
            abort(403);
        }

        $schedule->delete();

        return redirect()->route('sias.teacher.schedule')->with('success', 'Schedule deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggle(ClassSchedule $schedule)
    {
        $user = auth()->user();
        
        if ($schedule->teacher_id !== $user->id) {
            abort(403);
        }

        $schedule->update(['is_active' => !$schedule->is_active]);

        return redirect()->route('sias.teacher.schedule')->with('success', 'Schedule status updated!');
    }
}
