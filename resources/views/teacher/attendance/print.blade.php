<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance History | SkillUp</title>
    <style>
        @page { size: A4 landscape; margin: 14mm; }
        :root { color-scheme: light; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #14203f; font: 12px/1.45 Arial, sans-serif; }
        .print-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .print-toolbar button, .print-toolbar a { padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff; color: #143b9a; cursor: pointer; text-decoration: none; }
        .brand { color: #0a2461; font-size: 20px; font-weight: 700; }
        .brand small { display: block; margin-top: 2px; color: #64748b; font-size: 11px; font-weight: 400; }
        h1 { margin: 0 0 4px; color: #061a48; font-size: 22px; }
        .meta { margin: 0 0 16px; color: #52617d; }
        .summary { display: grid; grid-template-columns: repeat(6, 1fr); gap: 8px; margin-bottom: 18px; }
        .summary-item { padding: 8px 10px; border: 1px solid #dbe3ef; }
        .summary-item span { display: block; color: #64748b; font-size: 9px; font-weight: 700; text-transform: uppercase; }
        .summary-item strong { display: block; margin-top: 2px; color: #0a2461; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 7px 8px; border: 1px solid #cbd5e1; text-align: left; vertical-align: top; }
        th { background: #eef3fc; color: #0a2461; font-size: 10px; text-transform: uppercase; }
        .status { font-weight: 700; }
        .status-present { color: #166534; }
        .status-late { color: #92400e; }
        .status-absent { color: #991b1b; }
        .status-excused { color: #3730a3; }
        .empty { padding: 24px; color: #64748b; text-align: center; }
        footer { display: flex; justify-content: space-between; margin-top: 14px; color: #64748b; font-size: 10px; }
        @media print { .print-toolbar { display: none; } }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <div class="brand">SkillUp<small>Attendance report</small></div>
        <div><button type="button" onclick="window.print()">Print</button> <a href="{{ route('teacher.attendance.records', request()->query()) }}">Back to history</a></div>
    </div>

    <h1>Attendance History</h1>
    <p class="meta">
        @if($from || $to) Period: {{ $from ?: 'Beginning' }} to {{ $to ?: 'Present' }} · @endif
        @if($status) Status: {{ ucfirst($status) }} · @endif
        Printed {{ now()->format('d M Y g:i A') }}
    </p>

    <div class="summary">
        @foreach(['total' => 'Records', 'present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused', 'rate' => 'Attendance'] as $key => $label)
            <div class="summary-item"><span>{{ $label }}</span><strong>{{ $summary[$key] }}{{ $key === 'rate' ? '%' : '' }}</strong></div>
        @endforeach
    </div>

    <table>
        <thead><tr><th>Date</th><th>Trainee</th><th>Program</th><th>Status</th><th>Time in</th><th>Time out</th><th>Notes</th></tr></thead>
        <tbody>
            @forelse($records as $record)
                <tr>
                    <td>{{ $record->attendance_date?->format('d M Y') ?? '—' }}</td>
                    <td>{{ $record->student?->name ?? $record->enrollment?->user?->name ?? 'Unknown trainee' }}</td>
                    <td>{{ $record->course?->title ?? '—' }}</td>
                    <td class="status status-{{ $record->status }}">{{ ucfirst($record->status) }}</td>
                    <td>{{ $record->time_in?->format('g:i A') ?? '—' }}</td>
                    <td>{{ $record->time_out?->format('g:i A') ?? '—' }}</td>
                    <td>{{ $record->notes ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">No attendance records found for the selected filters.</td></tr>
            @endforelse
        </tbody>
    </table>
    <footer><span>Generated from the teacher portal</span><span>{{ $records->count() }} record(s)</span></footer>
</body>
</html>
