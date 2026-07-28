<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;

class StudentController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get students enrolled in this teacher's courses
        $enrollments = Enrollment::with('user', 'course')
            ->whereHas('course', function($q) use ($userId) {
                $q->where('instructor_id', $userId)
                  ->orWhere(function($q2) use ($userId) {
                      $q2->whereNull('instructor_id')->where('instructor_name', auth()->user()->name ?? '');
                  });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('teacher.students.index', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::with('user', 'course')->find($id);

        if (!$enrollment) {
            $enrollment = Enrollment::with('user', 'course')
                ->where('user_id', $id)
                ->firstOrFail();
        }

        // Ensure the enrollment belongs to one of this teacher's courses
        $course = $enrollment->course;
        if (!($course && (($course->instructor_id ?? null) === auth()->id() || (($course->instructor_id === null) && ($course->instructor_name ?? '') === (auth()->user()->name ?? ''))))) {
            abort(403);
        }

        return view('teacher.students.show', ['enrollment' => $enrollment]);
    }
}
