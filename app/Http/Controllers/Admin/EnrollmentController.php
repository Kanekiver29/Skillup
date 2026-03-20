<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Show all enrollments (optionally filter by course).
     */
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);

        if ($request->has('course_id') && $request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        $enrollments = $query->latest()->paginate(25);

        return view('Admin.enrollments.index', compact('enrollments'));
    }
}
