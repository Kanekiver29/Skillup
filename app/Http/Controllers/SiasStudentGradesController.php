<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiasStudentGradesController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $enrollments = $user->enrollments()->with(['course.instructor'])->get()->map(function ($enrollment) {
            $course = $enrollment->course;
            $finalGrade = $enrollment->final_grade ?? optional($course)->final_grade ?? null;
            
            // Format grade
            if (is_numeric($finalGrade)) {
                $finalGrade = round((float) $finalGrade, 1);
                $remark = $finalGrade >= 75 ? 'Passed' : 'Failed';
            } else {
                $remark = $finalGrade ? 'Incomplete' : 'No Grade';
            }

            // Safe instructor name resolution (handling stdClass properly)
            $instructorRaw = optional($course)->instructor ?? optional($course)->teacher ?? null;
            $instructorName = is_object($instructorRaw) && property_exists($instructorRaw, 'name')
                ? $instructorRaw->name
                : (is_string($instructorRaw) ? $instructorRaw : 'TBA');

            return [
                'course_code' => $course?->slug ?? $course?->id ?? 'N/A',
                'course_title' => $course?->title ?? 'Untitled Course',
                'instructor' => $instructorName,
                'units' => is_numeric($course?->units) ? (float) $course->units : 3.0,
                'final_grade' => $finalGrade,
                'remark' => $remark,
                'term' => 'First Semester SY 2026-2027', // Placeholder for current term
                'status' => $enrollment->status ?? 'active',
            ];
        });

        // Compute General Weighted Average (GWA) for numeric grades
        $numericGrades = $enrollments->filter(fn($e) => is_numeric($e['final_grade']));
        
        $totalUnits = $numericGrades->sum('units');
        $weightedSum = $numericGrades->sum(function($e) {
            return $e['final_grade'] * $e['units'];
        });

        $gwa = $totalUnits > 0 ? round($weightedSum / $totalUnits, 2) : null;
        $totalEarnedUnits = $enrollments->where('remark', 'Passed')->sum('units');
        
        return view('sias.students.grades.index', compact('user', 'enrollments', 'gwa', 'totalEarnedUnits', 'totalUnits'));
    }
}
