<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Models\Submission;

class SiasStudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $enrollments = $user->enrollments()->with('course')->get();
        $enrolledCount = $enrollments->count();

        // Attendance today (best-effort)
        $attendanceToday = 0;
        if (Schema::hasTable('attendances')) {
            $attQ = DB::table('attendances');
            if (Schema::hasColumn('attendances', 'user_id')) {
                $attQ->where('user_id', $user->id);
            } elseif (Schema::hasColumn('attendances', 'student_id')) {
                $attQ->where('student_id', $user->id);
            }
            if (Schema::hasColumn('attendances', 'attended_at')) {
                $attendanceToday = $attQ->whereDate('attended_at', Carbon::today())->count();
            } else {
                $attendanceToday = $attQ->whereDate('created_at', Carbon::today())->count();
            }
        }

        // Compute GWA from submissions (best-effort)
        $gwa = null;
        if (Schema::hasTable('submissions')) {
            $subs = Submission::with('assignment.course')->where('user_id', $user->id)->get();
            $courseGrades = [];
            foreach ($enrollments as $en) {
                $grades = $subs->filter(function ($s) use ($en) {
                    return optional($s->assignment)->course_id === $en->course_id;
                })->pluck('grade')->filter(function ($g) { return is_numeric($g); })->map(fn($g) => (float)$g);
                if ($grades->isNotEmpty()) $courseGrades[$en->course_id] = round($grades->average(),1);
            }
            if (count($courseGrades) > 0) $gwa = round(array_sum($courseGrades) / count($courseGrades),1);
        }

        // Recent announcements (best-effort)
        $announcements = collect();
        if (Schema::hasTable('announcements')) {
            $announcements = DB::table('announcements')->orderBy('created_at','desc')->limit(5)->get();
        }

        return view('sias.students.dashboard.index', compact(
            'user', 'enrollments', 'enrolledCount', 'attendanceToday', 'gwa', 'announcements'
        ));
    }
}
