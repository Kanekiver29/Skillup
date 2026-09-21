<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Certificate - {{ $user->name }}</title>
    <style>
        :root { color-scheme: light; font-family: Arial, sans-serif; color: #111827; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #e5e7eb; }
        .print-actions { display: flex; justify-content: center; gap: .75rem; padding: 1rem; }
        .print-actions button, .print-actions a { border: 0; border-radius: 6px; padding: .7rem 1rem; font: inherit; text-decoration: none; cursor: pointer; background: #0f766e; color: #fff; }
        .print-actions a { background: #475569; }
        .sheet { width: min(210mm, calc(100% - 2rem)); min-height: 297mm; margin: 0 auto 2rem; padding: 22mm 18mm; background: #fff; }
        header { text-align: center; border-bottom: 2px solid #0f766e; padding-bottom: 1rem; }
        header h1 { margin: 0; color: #115e59; font-size: 1.8rem; text-transform: uppercase; }
        header p { margin: .35rem 0 0; color: #475569; }
        .student { margin: 2rem 0 1.5rem; text-align: center; }
        .student h2 { margin: 0; font-size: 1.8rem; }
        .student p { margin: .35rem 0; color: #475569; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
        th, td { border: 1px solid #cbd5e1; padding: .7rem; text-align: left; }
        th { background: #e6fffb; color: #115e59; }
        .average { margin-top: 1rem; text-align: right; font-size: 1.1rem; }
        .signatures { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-top: 5rem; }
        .signature { padding-top: 2rem; border-top: 1px solid #334155; text-align: center; }
        @media print { @page { size: A4; margin: 0; } body { background: #fff; } .print-actions { display: none; } .sheet { width: 210mm; min-height: 297mm; margin: 0; } }
    </style>
</head>
<body>
    <div class="print-actions">
        <button type="button" onclick="window.print()">Print Certificate</button>
        <a href="{{ route('sias.admin.students.show', $user->id) }}">Back to Student</a>
    </div>
    <main class="sheet">
        <header>
            <h1>Certificate of Grades</h1>
            <p>SIAS Student Academic Information System</p>
            <p>Issued: {{ now()->format('F d, Y') }}</p>
        </header>
        <div class="student">
            <p>Official grade record for</p>
            <h2>{{ $user->name }}</h2>
            <p>Student ID: {{ $user->lrn ?? $user->id }}</p>
        </div>
        <table>
            <thead><tr><th>Program</th><th>Subject</th><th>Final Grade</th><th>Remarks</th></tr></thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td>{{ $enrollment->course?->title ?? '—' }}</td>
                        <td>{{ $enrollment->subject?->title ?? '—' }}</td>
                        <td>{{ is_numeric($enrollment->final_grade) ? number_format($enrollment->final_grade, 2) : 'No grade' }}</td>
                        <td>{{ is_numeric($enrollment->final_grade) ? ($enrollment->final_grade >= 75 ? 'Passed' : 'Failed') : 'Pending' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">No grade records available.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="average">Average Grade: <strong>{{ $averageGrade !== null ? number_format($averageGrade, 2) : 'N/A' }}</strong></div>
        <div class="signatures"><div class="signature">Registrar</div><div class="signature">Authorized Administrator</div></div>
    </main>
</body>
</html>