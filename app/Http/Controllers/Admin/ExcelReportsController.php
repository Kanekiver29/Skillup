<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelReportsController extends Controller
{
    /**
     * Show Excel reports page with real-time data
     */
    public function index()
    {
        // Get real-time data
        $users = User::where('is_admin', false)
            ->with('enrollments')
            ->get();

        $courses = Course::all();

        $stats = [
            'total_users' => User::where('is_admin', false)->count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
        ];

        return view('Admin.users.excel-reports', compact('users', 'courses', 'stats'));
    }

    /**
     * Export users to Excel with real-time data
     */
    public function exportUsersReport()
    {
        // Create new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('User Report');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);  // ID
        $sheet->getColumnDimension('B')->setWidth(25); // Name
        $sheet->getColumnDimension('C')->setWidth(30); // Email
        $sheet->getColumnDimension('D')->setWidth(15); // Age
        $sheet->getColumnDimension('E')->setWidth(15); // Birthday
        $sheet->getColumnDimension('F')->setWidth(30); // Address
        $sheet->getColumnDimension('G')->setWidth(20); // Enrolled Courses
        $sheet->getColumnDimension('H')->setWidth(15); // Role
        $sheet->getColumnDimension('I')->setWidth(15); // Created At

        // Set print settings
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setBottom(0.75);

        // Add header with styling
        $this->addHeader($sheet);

        // Get real-time user data
        $users = User::where('is_admin', false)
            ->with('enrollments')
            ->orderBy('created_at', 'desc')
            ->get();

        // Add data rows
        $row = 3;
        foreach ($users as $index => $user) {
            $sheet->setCellValue("A$row", $index + 1);
            $sheet->setCellValue("B$row", $user->name ?? 'N/A');
            $sheet->setCellValue("C$row", $user->email ?? 'N/A');
            $sheet->setCellValue("D$row", $user->age ?? 'N/A');
            $sheet->setCellValue("E$row", $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('m/d/Y') : 'N/A');
            $sheet->setCellValue("F$row", $user->location ?? 'N/A');
            $sheet->setCellValue("G$row", $user->enrollments->count());
            $sheet->setCellValue("H$row", ucfirst($user->role ?? 'Student'));
            $sheet->setCellValue("I$row", $user->created_at->format('m/d/Y H:i'));

            // Style data rows
            $this->styleDataRow($sheet, $row);
            $row++;
        }

        // Add freeze panes to keep header visible
        $sheet->freezePane('A3');

        // Add auto-filter
        $sheet->setAutoFilter("A2:I" . ($row - 1));

        // Set print area and add print title
        $sheet->getPageSetup()->setPrintArea("A1:I" . ($row - 1));
        $sheet->getPageSetup()->setRowsToRepeatAtTop([1, 2]);

        // Create writer and save
        $writer = new Xlsx($spreadsheet);
        $filename = 'Users_Report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $writer->save('php://output');
        exit;
    }

    /**
     * Export users with courses to Excel
     */
    public function exportUsersCourses()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Users & Courses');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(12);

        // Set print settings
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // Add header
        $this->addHeaderWithCourses($sheet);

        // Get real-time data
        $enrollments = Enrollment::with(['user', 'course'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Add data
        $row = 3;
        foreach ($enrollments as $index => $enrollment) {
            $user = $enrollment->user;
            $course = $enrollment->course;

            $sheet->setCellValue("A$row", $index + 1);
            $sheet->setCellValue("B$row", $user->name ?? 'N/A');
            $sheet->setCellValue("C$row", $user->email ?? 'N/A');
            $sheet->setCellValue("D$row", $user->age ?? 'N/A');
            $sheet->setCellValue("E$row", $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('m/d/Y') : 'N/A');
            $sheet->setCellValue("F$row", $user->location ?? 'N/A');
            $sheet->setCellValue("G$row", $course->title ?? 'N/A');
            $sheet->setCellValue("H$row", ($enrollment->progress ?? 0) . '%');

            // Style
            $this->styleDataRow($sheet, $row);
            $row++;
        }

        // Set auto-filter and freeze panes
        $sheet->freezePane('A3');
        $sheet->setAutoFilter("A2:H" . ($row - 1));
        $sheet->getPageSetup()->setPrintArea("A1:H" . ($row - 1));
        $sheet->getPageSetup()->setRowsToRepeatAtTop([1, 2]);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Users_Courses_Report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $writer->save('php://output');
        exit;
    }

    /**
     * Export course enrollment report
     */
    public function exportEnrollmentReport()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Enrollment Report');

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

        // Print settings
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

        // Add header
        $sheet->setCellValue('A1', 'USER ENROLLMENT REPORT');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Column headers
        $headers = ['#', 'Course Title', 'Enrolled By', 'Students', 'Status', 'Date'];
        foreach ($headers as $col => $header) {
            $column = chr(65 + $col);
            $sheet->setCellValue("{$column}2", $header);
        }

        $this->styleHeaderRow($sheet, 2, 6);

        // Get real-time enrollment data
        $courses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->get();

        $row = 3;
        foreach ($courses as $index => $course) {
            $sheet->setCellValue("A$row", $index + 1);
            $sheet->setCellValue("B$row", $course->title ?? 'N/A');
            $sheet->setCellValue("C$row", $course->instructor ?? 'N/A');
            $sheet->setCellValue("D$row", $course->enrollments_count);
            $sheet->setCellValue("E$row", ucfirst($course->status ?? 'Active'));
            $sheet->setCellValue("F$row", $course->created_at->format('m/d/Y'));

            $this->styleDataRow($sheet, $row);
            $row++;
        }

        // Auto-filter and freeze
        $sheet->freezePane('A3');
        $sheet->setAutoFilter("A2:F" . ($row - 1));
        $sheet->getPageSetup()->setPrintArea("A1:F" . ($row - 1));

        $writer = new Xlsx($spreadsheet);
        $filename = 'Enrollment_Report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $writer->save('php://output');
        exit;
    }

    /**
     * Get real-time data for AJAX updates
     */
    public function getRealTimeData()
    {
        return response()->json([
            'total_users' => User::where('is_admin', false)->count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'avg_progress' => round(Enrollment::avg('progress') ?? 0),
            'users' => User::where('is_admin', false)
                ->select('id', 'name', 'email', 'age', 'birthday', 'location', 'created_at')
                ->withCount('enrollments')
                ->latest()
                ->limit(10)
                ->get(),
        ]);
    }

    /**
     * Style header row
     */
    private function addHeader($sheet)
    {
        // Title row
        $sheet->setCellValue('A1', 'USER ENROLLMENT REPORT');
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Subtitle with timestamp
        $sheet->setCellValue('A2', 'Generated: ' . now()->format('F d, Y H:i:s'));
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '6B7280']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F4F6']],
        ]);

        // Column headers
        $headers = ['#', 'Name', 'Email', 'Age', 'Birthday', 'Address', 'Courses', 'Role', 'Created'];
        foreach ($headers as $col => $header) {
            $column = chr(65 + $col);
            $sheet->setCellValue("{$column}2", $header);
        }

        $this->styleHeaderRow($sheet, 2, 9);
    }

    /**
     * Add header with courses column
     */
    private function addHeaderWithCourses($sheet)
    {
        $sheet->setCellValue('A1', 'USER ENROLLMENT WITH COURSES');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);

        $sheet->setCellValue('A2', 'Generated: ' . now()->format('F d, Y H:i:s'));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '6B7280']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F4F6']],
        ]);

        $headers = ['#', 'Name', 'Email', 'Age', 'Birthday', 'Address', 'Course', 'Progress'];
        foreach ($headers as $col => $header) {
            $column = chr(65 + $col);
            $sheet->setCellValue("{$column}2", $header);
        }

        $this->styleHeaderRow($sheet, 2, 8);
    }

    /**
     * Style header row
     */
    private function styleHeaderRow($sheet, $row, $colCount)
    {
        for ($col = 0; $col < $colCount; $col++) {
            $column = chr(65 + $col);
            $sheet->getStyle("{$column}{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'border' => [
                    'bottom' => ['style' => Border::BORDER_THIN, 'color' => ['rgb' => '1F2937']],
                ],
            ]);
        }
        $sheet->getRowDimension($row)->setRowHeight(20);
    }

    /**
     * Style data row
     */
    private function styleDataRow($sheet, $row)
    {
        $borderColor = $row % 2 === 0 ? 'F9FAFB' : 'FFFFFF';

        for ($col = 0; $col < 10; $col++) {
            $column = chr(65 + $col);
            $sheet->getStyle("{$column}{$row}")->applyFromArray([
                'font' => ['size' => 10, 'color' => ['rgb' => '1F2937']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $borderColor]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
                'border' => [
                    'bottom' => ['style' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']],
                ],
            ]);
        }
        $sheet->getRowDimension($row)->setRowHeight(18);
    }
}
