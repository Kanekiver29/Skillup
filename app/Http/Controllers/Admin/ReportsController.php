<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use DateTime;

class ReportsController extends Controller
{
    private function authorizeAdmin()
    {
        if (! auth()->check() || ! auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();

        // ── User stats ─────────────────────────────────────────────────────────
        $totalUsers        = User::count();
        $totalAdmins       = User::where('is_admin', true)->count();
        $totalStudents     = User::where('is_admin', false)->count();
        $newUsersThisMonth = User::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // ── Course stats ───────────────────────────────────────────────────────
        $totalCourses     = Course::count();
        $publishedCourses = Course::where('is_published', true)->count();

        // ── Enrollment stats ───────────────────────────────────────────────────
        $totalEnrollments     = Enrollment::count();
        $completedEnrollments = Enrollment::where('completed', true)->count();
        $avgProgress          = round(Enrollment::avg('progress') ?? 0, 1);

        // ── Monthly trends for the last 12 months ─────────────────────────────
        $chartLabels         = [];
        $monthlySignups      = [];
        $monthlyEnrollments  = [];
        $monthlyCompletions  = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabels[]        = $date->format('M Y');
            $monthlySignups[]     = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyEnrollments[] = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyCompletions[] = Enrollment::where('completed', true)
                ->whereYear('completed_at', $date->year)
                ->whereMonth('completed_at', $date->month)
                ->count();
        }

        // ── Top 5 courses by enrollment count ─────────────────────────────────
        $topCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        // ── 10 most recent enrollments ─────────────────────────────────────────
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        return view('Admin.users.reports', compact(
            'totalUsers', 'totalAdmins', 'totalStudents', 'newUsersThisMonth',
            'totalCourses', 'publishedCourses',
            'totalEnrollments', 'completedEnrollments', 'avgProgress',
            'chartLabels', 'monthlySignups', 'monthlyEnrollments', 'monthlyCompletions',
            'topCourses', 'recentEnrollments',
        ));
    }

    public function siaSIndex(Request $request)
    {
        $this->authorizeAdmin();

        $selectedDepartment = trim((string) $request->query('department', ''));
        $selectedCourseId = $request->query('course_id');
        $selectedSubjectId = $request->query('subject_id');
        $hasDepartmentColumn = Schema::hasTable('courses') && Schema::hasColumn('courses', 'department');
        $hasCourseIdColumn = Schema::hasTable('subjects') && Schema::hasColumn('subjects', 'course_id');

        $departmentQuery = Course::query();
        if ($selectedDepartment !== '') {
            $departmentQuery->where(function ($query) use ($selectedDepartment, $hasDepartmentColumn) {
                if ($hasDepartmentColumn) {
                    $query->where('department', 'like', '%' . $selectedDepartment . '%');
                }
                $query->orWhere('category', 'like', '%' . $selectedDepartment . '%');
            });
        }

        $courses = $departmentQuery
            ->withCount('enrollments')
            ->orderByRaw('CASE WHEN category IS NULL OR category = "" THEN 1 ELSE 0 END, category ASC, title ASC')
            ->get();

        $departments = $courses
            ->map(function ($course) {
                return $course->department ?? $course->category ?? 'General';
            })
            ->filter(fn ($value) => ! empty($value))
            ->unique()
            ->sort()
            ->values();

        $activeCourse = null;
        if ($selectedCourseId) {
            $activeCourse = $courses->firstWhere('id', (int) $selectedCourseId);
        }

        if (! $activeCourse && $courses->isNotEmpty()) {
            $activeCourse = $courses->first();
        }

        $selectedCourseId = $activeCourse?->id;

        $subjects = Subject::query()
            ->when($selectedCourseId && $hasCourseIdColumn, function ($query) use ($selectedCourseId) {
                $query->where('course_id', $selectedCourseId);
            })
            ->with('teacher')
            ->orderBy('title')
            ->get();

        if ($selectedSubjectId && $subjects->contains('id', (int) $selectedSubjectId)) {
            $activeSubject = $subjects->firstWhere('id', (int) $selectedSubjectId);
        } else {
            $activeSubject = $subjects->first();
        }

        return view('sias.admin.reports.index', compact(
            'departments',
            'courses',
            'subjects',
            'activeCourse',
            'activeSubject',
            'selectedDepartment',
            'selectedCourseId',
            'selectedSubjectId',
        ));
    }

    /**
     * Export enrollments to Excel (CSV format compatible with Excel)
     */
    public function exportExcel()
    {
        $this->authorizeAdmin();

        // Get enrollment data with user and course info
        $enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->get();

        // CSV headers
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="student_enrollments_' . now()->format('Y-m-d') . '.csv"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        // Create CSV content
        $callback = function () use ($enrollments) {
            $file = fopen('php://output', 'w');

            // Set BOM for UTF-8 (Excel compatibility)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Write headers
            fputcsv($file, [
                'Name',
                'Email',
                'Age',
                'Birthday',
                'Address',
                'Course',
                'Progress (%)',
                'Status',
                'Enrolled Date',
                'Last Updated',
            ]);

            // Write data rows
            foreach ($enrollments as $enrollment) {
                $user = $enrollment->user;
                if (!$user) {
                    fputcsv($file, [
                        'Unknown',
                        'N/A',
                        'N/A',
                        'N/A',
                        'N/A',
                        $enrollment->course->course_title ?? 'Unknown Course',
                        round($enrollment->progress ?? 0, 2),
                        $enrollment->status ?? 'Pending',
                        $enrollment->created_at?->format('Y-m-d H:i') ?? 'N/A',
                        $enrollment->updated_at?->format('Y-m-d H:i') ?? 'N/A',
                    ]);
                    continue;
                }

                $birthDate = $user->birthday ? new DateTime($user->birthday) : null;
                $age = $birthDate ? now()->diffInYears($birthDate) : 'N/A';

                fputcsv($file, [
                    $user->name ?? 'Unknown',
                    $user->email ?? 'N/A',
                    $age,
                    $user->birthday ? (new DateTime($user->birthday))->format('Y-m-d') : 'N/A',
                    $user->location ?? 'N/A',
                    $enrollment->course->course_title ?? 'Unknown Course',
                    round($enrollment->progress ?? 0, 2),
                    $enrollment->status ?? 'Pending',
                    $enrollment->created_at->format('Y-m-d H:i'),
                    $enrollment->updated_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get real-time enrollment data (for live monitoring)
     */
    public function liveEnrollmentData()
    {
        $this->authorizeAdmin();

        $enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(50)
            ->get()
            ->map(function ($enrollment) {
                $user = $enrollment->user;
                $birthDate = $user->birthday ? new DateTime($user->birthday) : null;
                $age = $birthDate ? now()->diffInYears($birthDate) : 'N/A';

                return [
                    'id' => $enrollment->id,
                    'name' => $user->name ?? 'Unknown',
                    'email' => $user->email ?? 'N/A',
                    'age' => $age,
                    'birthday' => $user->birthday ? (new DateTime($user->birthday))->format('M d, Y') : 'N/A',
                    'address' => $user->location ?? 'N/A',
                    'course' => $enrollment->course->course_title ?? 'Unknown Course',
                    'progress' => round($enrollment->progress ?? 0, 2),
                    'status' => $enrollment->status ?? 'Pending',
                    'enrolledDate' => $enrollment->created_at->format('M d, Y'),
                    'lastUpdated' => $enrollment->updated_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $enrollments,
            'count' => $enrollments->count(),
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
