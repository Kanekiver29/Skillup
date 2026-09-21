@extends('teacher.layouts.master')
@section('title', 'Attendance History')
@section('page_title', 'Attendance History')
@section('content')
<style>
    .history-toolbar { display:flex; align-items:end; gap:.8rem; flex-wrap:wrap; }
    .history-toolbar label { display:grid; gap:.3rem; color:var(--ink-2); font-size:.78rem; font-weight:700; }
    .history-toolbar input, .history-toolbar select { min-height:2.4rem; padding:.5rem .65rem; border:1px solid var(--line); border-radius:var(--r-sm); background:#fff; color:var(--ink); }
    .history-toolbar .history-search { flex:1; min-width:190px; }
    .history-toolbar .history-search input { width:100%; }
    .history-actions { display:flex; gap:.55rem; flex-wrap:wrap; }
    .history-secondary { background:var(--blue-50); color:var(--blue-800); }
    .history-summary { display:grid; grid-template-columns:repeat(6, minmax(90px, 1fr)); gap:.7rem; margin-bottom:1rem; }
    .history-stat { padding:.8rem 1rem; background:#fff; border:1px solid var(--line); border-radius:var(--r-md); }
    .history-stat span { display:block; color:var(--muted); font-size:.7rem; font-weight:800; letter-spacing:.05em; text-transform:uppercase; }
    .history-stat strong { display:block; margin-top:.2rem; color:var(--blue-950); font-size:1.35rem; }
    .status-pill { display:inline-flex; padding:.25rem .5rem; border-radius:999px; font-size:.72rem; font-weight:800; }
    .status-present { background:#dcfce7; color:#166534; }
    .status-late { background:#fef3c7; color:#92400e; }
    .status-absent { background:#fee2e2; color:#991b1b; }
    .status-excused { background:#e0e7ff; color:#3730a3; }
    .history-empty { padding:2.5rem 1rem; text-align:center; color:var(--muted); }
    .history-empty strong { display:block; margin-bottom:.35rem; color:var(--blue-950); font-family:'Newsreader', Georgia, serif; font-size:1.35rem; }
    @media (max-width:700px) { .history-summary { grid-template-columns:repeat(2, 1fr); } }
</style>
<div class="portal-page">
    <div class="portal-heading">
        <div><h2>Attendance History</h2><p>Review attendance records for trainees assigned to your programs.</p></div>
        <div class="history-actions">
            <a class="portal-button history-secondary" href="{{ route('teacher.attendance.index') }}">Record attendance</a>
            <a class="portal-button history-secondary" href="{{ route('teacher.attendance.print', request()->query()) }}" target="_blank" rel="noopener">Print</a>
            <a class="portal-button" href="{{ route('teacher.attendance.export', request()->query()) }}">Export CSV</a>
        </div>
    </div>

    <form method="GET" action="{{ route('teacher.attendance.records') }}" class="portal-card history-toolbar">
        <label class="history-search">Search trainee<input type="search" name="search" value="{{ $search }}" placeholder="Name"></label>
        <label>Program<select name="course_id"><option value="">All programs</option>@foreach($programs as $program)<option value="{{ $program->id }}" @selected((string) $courseId === (string) $program->id)>{{ $program->title }}</option>@endforeach</select></label>
        <label>Status<select name="status"><option value="">All statuses</option>@foreach(['present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused'] as $value => $label)<option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>@endforeach</select></label>
        <label>From<input type="date" name="from" value="{{ $from }}"></label>
        <label>To<input type="date" name="to" value="{{ $to }}"></label>
        <div class="history-actions"><button class="portal-button" type="submit">Apply filters</button><a class="portal-button history-secondary" href="{{ route('teacher.attendance.records') }}">Clear</a></div>
    </form>

    <div class="history-summary">
        @foreach(['total' => 'Records', 'present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused', 'rate' => 'Attendance'] as $key => $label)
            <div class="history-stat"><span>{{ $label }}</span><strong>{{ $summary[$key] }}{{ $key === 'rate' ? '%' : '' }}</strong></div>
        @endforeach
    </div>

    <div class="portal-table-wrap">
        <table class="portal-table">
            <thead><tr><th>Date</th><th>Trainee</th><th>Program</th><th>Status</th><th>Time in</th><th>Time out</th><th>Notes</th></tr></thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->attendance_date?->format('d M Y') ?? '—' }}</td>
                        <td><strong>{{ $record->student?->name ?? $record->enrollment?->user?->name ?? 'Unknown trainee' }}</strong></td>
                        <td>{{ $record->course?->title ?? '—' }}</td>
                        <td><span class="status-pill status-{{ $record->status }}">{{ ucfirst($record->status) }}</span></td>
                        <td>{{ $record->time_in?->format('g:i A') ?? '—' }}</td>
                        <td>{{ $record->time_out?->format('g:i A') ?? '—' }}</td>
                        <td>{{ $record->notes ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="history-empty"><strong>No attendance records found</strong>Try changing the filters or record attendance for an assigned trainee.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
