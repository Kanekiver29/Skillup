<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grades - SkillUp</title>
    <style>
        :root { color-scheme: light; font-family: Arial, sans-serif; color: #172033; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #e8edf5; }
        .print-actions { display: flex; justify-content: center; gap: .75rem; padding: 1rem; }
        .print-actions button, .print-actions a { border: 0; border-radius: 6px; padding: .7rem 1rem; font: inherit; text-decoration: none; cursor: pointer; background: #2458d6; color: #fff; }
        .print-actions a { background: #475569; }
        .sheet { width: min(210mm, calc(100% - 2rem)); min-height: 297mm; margin: 0 auto 2rem; padding: 14mm; background: #fff; }
        .header { display: flex; justify-content: space-between; gap: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #2458d6; }
        .brand { display: flex; gap: .85rem; align-items: center; }
        .brand-logo { width: 62px; height: 62px; object-fit: contain; }
        h1 { margin: 0; font-size: 1.45rem; text-transform: uppercase; letter-spacing: .04em; }
        .header p { margin: .25rem 0 0; color: #64748b; font-size: .82rem; }
        .printed { color: #64748b; font-size: .75rem; text-align: right; }
        .student-section { margin-top: 1.5rem; page-break-inside: avoid; }
        .student-heading { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; padding: .65rem .75rem; background: #edf3ff; border-left: 4px solid #2458d6; }
        .student-heading h2 { margin: 0; font-size: 1rem; }
        .student-heading p { margin: .25rem 0 0; color: #64748b; font-size: .78rem; }
        .average { color: #173b96; font-weight: 800; white-space: nowrap; }
        table { width: 100%; margin-top: .65rem; border-collapse: collapse; font-size: .76rem; }
        th { padding: .5rem .45rem; background: #f4f7fb; color: #475569; text-align: left; font-size: .68rem; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: .55rem .45rem; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
        .score { white-space: nowrap; font-weight: 700; }
        .percent { color: #173b96; font-weight: 800; }
        .empty { margin-top: 2rem; padding: 2rem; border: 1px dashed #94a3b8; color: #64748b; text-align: center; }
        .footer { margin-top: 2.5rem; padding-top: 1rem; border-top: 1px solid #cbd5e1; display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; font-size: .78rem; color: #475569; }
        .signature { padding-top: 2rem; border-top: 1px solid #334155; text-align: center; }
        @media (max-width: 650px) { .sheet { width: calc(100% - 1rem); padding: 1rem; } .header, .student-heading { display: block; } .printed { margin-top: .75rem; text-align: left; } }
        @media print {
            @page { size: A4 portrait; margin: 10mm; }
            body { background: #fff; }
            .print-actions { display: none; }
            .sheet { width: 210mm; min-height: 297mm; margin: 0; padding: 8mm; }
            .student-section + .student-section { break-before: page; }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Print grades</button>
        <a href="{{ route('teacher.grades.index') }}">Back to grades</a>
    </div>

    <main class="sheet">
        <header class="header">
            <div class="brand">
                <img class="brand-logo" src="{{ asset('image/logo_oif_skillup_1_-removebg-preview.png') }}" alt="SkillUp logo">
                <div>
                    <h1>Student Grade Report</h1>
                    <p>SkillUp Training Management System</p>
                    <p>{{ $studentId ? 'Individual student record' : 'Teacher grade records' }}</p>
                </div>
            </div>
            <div class="printed">Printed: {{ now()->format('F d, Y h:i A') }}</div>
        </header>

        @forelse($students as $summary)
            <section class="student-section">
                <div class="student-heading">
                    <div>
                        <h2>{{ $summary['student']?->name ?? 'Student' }}</h2>
                        <p>{{ $summary['courses']->implode(', ') ?: 'No course listed' }}</p>
                    </div>
                    <div class="average">Average: {{ $summary['average'] !== null ? number_format($summary['average'], 1) . '%' : '—' }}</div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Assessment</th>
                            <th>Type</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($summary['records'] as $record)
                            <tr>
                                <td>{{ $record['course'] }}</td>
                                <td>{{ $record['title'] }}</td>
                                <td>{{ $record['type'] }}</td>
                                <td class="score">{{ $record['score'] !== null ? number_format($record['score'], 2) . ' / ' . number_format($record['max_score'], 2) : '—' }}</td>
                                <td class="percent">{{ number_format($record['percentage'], 1) }}%</td>
                                <td>{{ $record['remarks'] ?: '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6">No grade records for this student.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        @empty
            <div class="empty">No student grade records are available to print.</div>
        @endforelse

        <footer class="footer">
            <div class="signature">Teacher signature</div>
            <div class="signature">School administrator</div>
        </footer>
    </main>
</body>
</html>
