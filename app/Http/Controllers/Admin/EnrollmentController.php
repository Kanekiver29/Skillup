<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    private function authorizeAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Show all enrollments (optionally filter by course).
     */
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = Enrollment::with(['user', 'course']);

        if ($request->has('course_id') && $request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        $enrollments = $query->latest()->paginate(25);

        return view('Admin.enrollments.index', compact('enrollments'));
    }
}
