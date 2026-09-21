<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleManagementController extends Controller
{
    protected function authorizeAdmin()
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $schedules = ClassSchedule::with(['course', 'teacher'])
            ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->orderBy('start_time')
            ->paginate(15);

        return view('sias.admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $courses = Course::orderBy('title')->get();
        $teachers = User::where(function ($query) {
            $query->where('role', 'teacher')
                ->orWhere(function ($staffQuery) {
                    $staffQuery->where('role', 'staff')->whereIn('staff_type', ['teacher', 'instructor']);
                });
        })->orderBy('name')->get();

        return view('sias.admin.schedules.create', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
            'subject_name' => 'required|string|max:255',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'student_count' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        ClassSchedule::create([
            ...$validated,
            'student_count' => $validated['student_count'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(ClassSchedule $schedule)
    {
        $this->authorizeAdmin();
        $courses = Course::orderBy('title')->get();
        $teachers = User::where(function ($query) {
            $query->where('role', 'teacher')
                ->orWhere(function ($staffQuery) {
                    $staffQuery->where('role', 'staff')->whereIn('staff_type', ['teacher', 'instructor']);
                });
        })->orderBy('name')->get();

        return view('sias.admin.schedules.edit', compact('schedule', 'courses', 'teachers'));
    }

    public function update(Request $request, ClassSchedule $schedule)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
            'subject_name' => 'required|string|max:255',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'student_count' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $schedule->update([
            ...$validated,
            'student_count' => $validated['student_count'] ?? 0,
            'is_active' => $validated['is_active'] ?? false,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(ClassSchedule $schedule)
    {
        $this->authorizeAdmin();
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
