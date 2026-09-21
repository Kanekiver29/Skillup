<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SiasStudentAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $enrollments = $user->enrollments()->with(['course.instructor'])->get();
        $attendanceData = collect();
        $overallPresent = 0;
        $overallTotal = 0;

        $hasAttendanceTable = Schema::hasTable('attendances');

        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $present = 0;
            $absent = 0;
            $late = 0;
            $total = 0;

            if ($hasAttendanceTable) {
                $query = DB::table('attendances');
                
                // Identify the user column
                if (Schema::hasColumn('attendances', 'user_id')) {
                    $query->where('user_id', $user->id);
                } elseif (Schema::hasColumn('attendances', 'student_id')) {
                    $query->where('student_id', $user->id);
                }

                // Identify the course/class column
                if (Schema::hasColumn('attendances', 'course_id')) {
                    $query->where('course_id', $course->id);
                } elseif (Schema::hasColumn('attendances', 'class_id')) {
                    $query->where('class_id', $course->id);
                }

                $records = $query->get();
                $total = $records->count();
                $present = $records->where('present', 1)->count();
                $absent = $records->where('present', 0)->count();
                
                if (Schema::hasColumn('attendances', 'status')) {
                    $late = $records->where('status', 'late')->count();
                }
            }

            $rate = $total > 0 ? round(($present / $total) * 100) : 0;
            
            $overallPresent += $present;
            $overallTotal += $total;

            $instructorRaw = optional($course)->instructor ?? optional($course)->teacher ?? null;
            $instructorName = is_object($instructorRaw) && property_exists($instructorRaw, 'name')
                ? $instructorRaw->name
                : (is_string($instructorRaw) ? $instructorRaw : 'TBA');

            $attendanceData->push([
                'course_title' => $course?->title ?? 'Untitled Course',
                'course_code' => $course?->slug ?? $course?->id ?? 'N/A',
                'instructor' => $instructorName,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'total' => $total,
                'rate' => $rate,
            ]);
        }

        $overallRate = $overallTotal > 0 ? round(($overallPresent / $overallTotal) * 100) : null;

        return view('sias.students.attendance.index', compact('user', 'attendanceData', 'overallRate', 'overallPresent', 'overallTotal', 'hasAttendanceTable'));
    }
}
