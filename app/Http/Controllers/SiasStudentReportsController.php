<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class SiasStudentReportsController extends Controller
{
    /**
     * Display the student reports dashboard.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $reportData = $this->getReportData($user);

        return view('sias.students.reports.index', array_merge([
            'user' => $user,
        ], $reportData));
    }

    /**
     * Display a specific student report section.
     */
    public function show(Request $request, $section)
    {
        $user = Auth::user();
        $reportData = $this->getReportData($user);

        $sectionMap = [
            'class-offerings' => [
                'title' => 'Class Offerings',
                'description' => 'A summary of all classes you are enrolled in for the current semester.',
                'view' => 'sias.students.reports.sections.class-offerings',
            ],
            'enrolled-subjects' => [
                'title' => 'Enrolled Subjects',
                'description' => 'A detailed list of your active subjects and course codes.',
                'view' => 'sias.students.reports.sections.enrolled-subjects',
            ],
            'final-grades-match' => [
                'title' => 'Final Grades (Match)',
                'description' => 'Final grades for courses under the matched curriculum.',
                'view' => 'sias.students.reports.sections.final-grades-match',
            ],
            'final-grades-ignore' => [
                'title' => 'Final Grades (Ignore)',
                'description' => 'Final grades for courses under the ignored curriculum.',
                'view' => 'sias.students.reports.sections.final-grades-ignore',
            ],
            'gwa-match' => [
                'title' => 'GWA (Match)',
                'description' => 'Your weighted average for matched curriculum courses.',
                'view' => 'sias.students.reports.sections.gwa-match',
            ],
            'gwa-ignore' => [
                'title' => 'GWA (Ignore)',
                'description' => 'Your weighted average for ignored curriculum courses.',
                'view' => 'sias.students.reports.sections.gwa-ignore',
            ],
            'term-grades-match' => [
                'title' => 'Term Grades (Match)',
                'description' => 'Term grade breakdown for matched curriculum courses.',
                'view' => 'sias.students.reports.sections.term-grades-match',
            ],
            'term-grades-ignore' => [
                'title' => 'Term Grades (Ignore)',
                'description' => 'Term grade breakdown for ignored curriculum courses.',
                'view' => 'sias.students.reports.sections.term-grades-ignore',
            ],
        ];

        if (! array_key_exists($section, $sectionMap)) {
            abort(404);
        }

        return view('sias.students.reports.show', array_merge(
            [
                'user' => $user,
                'sectionMeta' => $sectionMap[$section],
                'currentSection' => $section,
            ],
            $reportData
        ));
    }

    public function print(Request $request, $section)
    {
        $sections = [
            'class-offerings' => ['title' => 'Class Offerings', 'view' => 'sias.students.reports.sections.class-offerings', 'print' => 'sias.students.reports.print'],
            'enrolled-subjects' => ['title' => 'Enrolled Subjects', 'view' => 'sias.students.reports.sections.enrolled-subjects', 'print' => 'sias.students.reports.print'],
            'final-grades-match' => ['title' => 'Final Grades (Match)', 'view' => 'sias.students.reports.sections.final-grades-match', 'print' => 'sias.students.reports.prints.final-grades-match.print'],
            'final-grades-ignore' => ['title' => 'Final Grades (Ignore)', 'view' => 'sias.students.reports.sections.final-grades-ignore', 'print' => 'sias.students.reports.prints.final-grades-ignore.print'],
            'gwa-match' => ['title' => 'GWA (Match)', 'view' => 'sias.students.reports.sections.gwa-match', 'print' => 'sias.students.reports.prints.gwa-match.print'],
            'gwa-ignore' => ['title' => 'GWA (Ignore)', 'view' => 'sias.students.reports.sections.gwa-ignore', 'print' => 'sias.students.reports.prints.gwa-ignore.print'],
            'term-grades-match' => ['title' => 'Term Grades (Match)', 'view' => 'sias.students.reports.sections.term-grades-match', 'print' => 'sias.students.reports.print'],
            'term-grades-ignore' => ['title' => 'Term Grades (Ignore)', 'view' => 'sias.students.reports.sections.term-grades-ignore', 'print' => 'sias.students.reports.print'],
        ];

        abort_unless(isset($sections[$section]), 404);

        return view($sections[$section]['print'], array_merge([
            'user' => Auth::user(),
            'sectionMeta' => $sections[$section],
            'currentSection' => $section,
        ], $this->getReportData(Auth::user())));
    }

    private function getReportData($user)
    {
        $enrollments = $user->enrollments()->with('course')->get();
        $submissions = Submission::with('assignment.course')->where('user_id', $user->id)->get();

        $courseGrades = [];
        $courseSummaries = collect();

        foreach ($enrollments as $enrollment) {
            $course = optional($enrollment)->course;
            $grades = $submissions
                ->filter(function ($submission) use ($enrollment) {
                    return optional($submission->assignment)->course_id === $enrollment->course_id;
                })
                ->pluck('grade')
                ->filter(function ($grade) {
                    return is_numeric($grade);
                })
                ->map(function ($grade) {
                    return (float) $grade;
                });

            $averageGrade = $grades->isNotEmpty() ? round($grades->average(), 1) : null;
            if ($grades->isNotEmpty()) {
                $courseGrades[$enrollment->course_id] = $averageGrade;
            }

            $latestSubmission = $submissions
                ->filter(function ($submission) use ($enrollment) {
                    return optional($submission->assignment)->course_id === $enrollment->course_id;
                })
                ->sortByDesc('created_at')
                ->first();

            $finalGrade = optional($latestSubmission)->grade;
            $units = optional($course)->units ?? optional($course)->credits ?? 3.0;
            $gradeValue = is_numeric($finalGrade) ? round((float) $finalGrade, 1) : $finalGrade;
            $remark = is_numeric($gradeValue) ? ($gradeValue >= 75 ? 'Passed' : 'Incomplete') : ($gradeValue ? 'Incomplete' : 'No grade');
            $instructorRaw = optional($course)->instructor ?? optional($course)->teacher ?? null;
            $instructorName = is_object($instructorRaw)
                ? ($instructorRaw->name ?? 'TBA')
                : ($instructorRaw ?? 'TBA');

            $courseSummaries->push([
                'course_code' => optional($course)->code ?? optional($course)->course_code ?? 'N/A',
                'course_name' => optional($course)->title ?? optional($course)->name ?? 'Untitled Course',
                'instructor' => $instructorName,
                'ave_grade' => $averageGrade,
                'final_grade' => $gradeValue,
                'equiv_grade' => $gradeValue,
                'units' => $units,
                'remark' => $remark,
                'curr_eval' => $remark === 'Passed' ? 'Passed' : 'Incomplete',
            ]);
        }

        $gradeCount = count($courseGrades);
        $gwaMatch = $gradeCount > 0 ? round(array_sum($courseGrades) / $gradeCount, 1) : null;

        $attendanceRecords = collect();
        if (Schema::hasTable('attendances')) {
            $attQuery = DB::table('attendances');
            if (Schema::hasColumn('attendances', 'user_id')) {
                $attQuery->where('user_id', $user->id);
            } elseif (Schema::hasColumn('attendances', 'student_id')) {
                $attQuery->where('student_id', $user->id);
            }
            if (Schema::hasColumn('attendances', 'attended_at')) {
                $attendanceRecords = $attQuery->orderBy('attended_at', 'desc')->limit(30)->get();
            } else {
                $attendanceRecords = $attQuery->orderBy('id', 'desc')->limit(30)->get();
            }
        }

        $ledger = [
            'pending_balance' => 0,
            'last_payment' => null,
            'account_status' => 'Active',
        ];
        if (Schema::hasTable('payments')) {
            $paymentsQuery = DB::table('payments');
            if (Schema::hasColumn('payments', 'user_id')) {
                $paymentsQuery = $paymentsQuery->where('user_id', $user->id);
            } elseif (Schema::hasColumn('payments', 'student_id')) {
                $paymentsQuery = $paymentsQuery->where('student_id', $user->id);
            }

            $lastPayment = (clone $paymentsQuery)->orderBy('created_at', 'desc')->first();
            $totalPaid = (clone $paymentsQuery)->sum('amount');

            $ledger['pending_balance'] = 0;
            if ($lastPayment) {
                $ledger['last_payment'] = (property_exists($lastPayment, 'amount') ? '₱' . number_format($lastPayment->amount, 2) . ' on ' : '') . (property_exists($lastPayment, 'created_at') ? Carbon::parse($lastPayment->created_at)->toDateString() : '');
                $ledger['account_status'] = 'Active';
            } else {
                $ledger['last_payment'] = null;
                $ledger['account_status'] = 'No payments on record';
            }
            $ledger['total_paid'] = $totalPaid;
        }

        return [
            'enrollments' => $enrollments,
            'submissions' => $submissions,
            'courseGrades' => $courseGrades,
            'gwaMatch' => $gwaMatch,
            'ledger' => $ledger,
            'attendanceRecords' => $attendanceRecords,
            'courseSummaries' => $courseSummaries,
        ];
    }
}
