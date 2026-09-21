@extends('teacher.layouts.master')
@section('title', 'Attendance')
@section('page_title', 'Attendance')
@section('content')
<style>
	.attendance-toolbar { display:flex; align-items:end; gap:1rem; flex-wrap:wrap; }
	.attendance-toolbar label, .attendance-search { display:grid; gap:.35rem; font-weight:700; color:var(--text-2); }
	.attendance-toolbar input, .attendance-toolbar select, .attendance-search input { min-height:2.45rem; padding:.55rem .7rem; border:1px solid var(--border-soft); border-radius:.55rem; background:#fff; }
	.attendance-search { flex:1; min-width:220px; }
	.attendance-search input { width:100%; }
	.attendance-actions { display:flex; gap:.55rem; flex-wrap:wrap; }
	.attendance-secondary { background:#eef3fc; color:var(--blue-800); }
	.attendance-summary { display:grid; grid-template-columns:repeat(6, minmax(100px, 1fr)); gap:.7rem; margin-bottom:1rem; }
	.attendance-stat { padding:.85rem 1rem; background:#fff; border:1px solid var(--line); border-radius:var(--r-md); }
	.attendance-stat span { display:block; color:var(--muted); font-size:.72rem; font-weight:800; text-transform:uppercase; letter-spacing:.05em; }
	.attendance-stat strong { display:block; margin-top:.25rem; color:var(--blue-950); font-size:1.45rem; }
	.attendance-table-row { transition:background .2s ease; }
	.attendance-table-row.is-present { background:#f0fdf7; }
	.attendance-statuses { display:flex; flex-wrap:wrap; gap:.35rem; }
	.attendance-status-option { position:relative; }
	.attendance-status-option input { position:absolute; opacity:0; pointer-events:none; }
	.attendance-status-option span { display:inline-flex; padding:.45rem .6rem; border:1px solid var(--line); border-radius:.5rem; background:#fff; color:var(--muted); font-size:.78rem; font-weight:700; cursor:pointer; }
	.attendance-status-option input:checked + span { border-color:var(--blue-700); background:var(--blue-700); color:#fff; }
	.attendance-time, .attendance-note { width:100%; min-width:7rem; padding:.55rem .65rem; border:1px solid var(--line); border-radius:.5rem; }
	.attendance-note { min-width:10rem; }
	.attendance-table td small { color:var(--muted); }
	@media (max-width: 700px) {
		.attendance-summary { grid-template-columns:repeat(2, 1fr); }
		.attendance-table-row td { display: block; border: 0; padding: .55rem .75rem; }
		.attendance-table-row td:first-child { padding-top: 1rem; }
		.attendance-table-row td:last-child { padding-bottom: 1rem; }
		.attendance-table-row td::before { content: attr(data-label); display: block; color: var(--muted); font-size: .7rem; font-weight: 800; margin-bottom: .25rem; text-transform: uppercase; letter-spacing: .06em; }
		.attendance-table-row td:first-child::before { display: none; }
		.attendance-table-row { display: block; border-bottom: 1px solid var(--border-soft); }
	}
</style>
<div class="portal-page">
	<div class="portal-heading"><div><h2>Daily Attendance</h2><p>Record present, absent, late, or excused status for each trainee.</p></div><div class="attendance-actions"><a class="portal-button attendance-secondary" href="{{ route('teacher.attendance.records', ['date' => $date]) }}">Attendance history</a><a class="portal-button" href="{{ route('teacher.attendance.export', request()->query()) }}">Export CSV</a></div></div>
	@if(session('success'))<div class="portal-card" style="color:#166534;background:#ecfdf5;">{{ session('success') }}</div>@endif
	@if(isset($errors) && $errors->any())<div class="portal-card" style="color:#991b1b;background:#fef2f2;">{{ $errors->first() }}</div>@endif
	<form method="POST" action="{{ route('teacher.attendance.store') }}">
		@csrf
		<div class="portal-card attendance-toolbar" style="margin-bottom:1rem;">
			<label>Attendance date<input type="date" name="attendance_date" value="{{ $date }}" required></label>
			<label>Program<select name="course_id" id="attendanceProgram"><option value="">All programs</option>@foreach($programs as $program)<option value="{{ $program->id }}" @selected((string) $courseId === (string) $program->id)>{{ $program->title }}</option>@endforeach</select></label>
			<label>Section<select name="section"><option value="">All sections</option>@foreach($sections as $option)<option value="{{ $option }}" @selected($section === $option)>{{ $option }}</option>@endforeach</select></label>
			<label class="attendance-search">Search trainee<input type="search" id="attendanceSearch" placeholder="Search trainee..."></label>
			<div class="attendance-actions"><button class="portal-button attendance-secondary" type="button" id="markAllPresent">Mark all present</button><button class="portal-button" type="submit">Save attendance</button></div>
		</div>
		<div class="attendance-summary"><div class="attendance-stat"><span>Total</span><strong id="attendanceTotal">{{ $summary['total'] }}</strong></div><div class="attendance-stat"><span>Present</span><strong id="attendancePresent">{{ $summary['present'] }}</strong></div><div class="attendance-stat"><span>Absent</span><strong id="attendanceAbsent">{{ $summary['absent'] }}</strong></div><div class="attendance-stat"><span>Late</span><strong id="attendanceLate">{{ $summary['late'] }}</strong></div><div class="attendance-stat"><span>Excused</span><strong id="attendanceExcused">{{ $summary['excused'] }}</strong></div><div class="attendance-stat"><span>Attendance</span><strong id="attendanceRate">{{ $summary['rate'] }}%</strong></div></div>
		<div class="portal-table-wrap attendance-checklist"><table class="portal-table"><thead><tr><th>Trainee</th><th>Program</th><th>Status</th><th>Time in</th><th>Time out</th><th>Notes</th></tr></thead><tbody id="attendanceRows">
		@forelse($enrollments as $enrollment)
			@php($record = $records->get($enrollment->id))
			@php($status = $record?->status ?? 'absent')
			<tr class="attendance-table-row {{ in_array($status, ['present', 'late'], true) ? 'is-present' : '' }}" data-name="{{ strtolower($enrollment->user?->name ?? '') }}"><td data-label="Trainee"><strong>{{ $enrollment->user?->name ?? '—' }}</strong></td><td data-label="Program">{{ $enrollment->course?->title ?? '—' }}</td><td data-label="Status"><div class="attendance-statuses">@foreach(['present' => 'Present', 'late' => 'Late', 'absent' => 'Absent', 'excused' => 'Excused'] as $value => $label)<label class="attendance-status-option"><input type="radio" name="attendance[{{ $enrollment->id }}]" value="{{ $value }}" @checked($status === $value)><span>{{ $label }}</span></label>@endforeach</div></td><td data-label="Time in"><input class="attendance-time" type="time" name="time_in[{{ $enrollment->id }}]" value="{{ $record?->time_in?->format('H:i') }}"></td><td data-label="Time out"><input class="attendance-time" type="time" name="time_out[{{ $enrollment->id }}]" value="{{ $record?->time_out?->format('H:i') }}"></td><td data-label="Notes"><input class="attendance-note" type="text" name="notes[{{ $enrollment->id }}]" value="{{ $record?->notes }}" placeholder="Reason or note"></td></tr>
		@empty
			<tr><td colspan="6">No trainees available for attendance.</td></tr>
		@endforelse
		</tbody></table></div>
	</form>
</div>
<script>
(() => {
	const rows = [...document.querySelectorAll('.attendance-table-row[data-name]')];
	const updateRow = row => {
		const selected = row.querySelector('input[name^="attendance["]:checked');
		row.classList.toggle('is-present', ['present', 'late'].includes(selected?.value));
	};
	const updateSummary = () => {
		const statuses = rows.map(row => row.querySelector('input[name^="attendance["]:checked')?.value).filter(Boolean);
		['present', 'absent', 'late', 'excused'].forEach(status => { document.getElementById(`attendance${status[0].toUpperCase()}${status.slice(1)}`).textContent = statuses.filter(value => value === status).length; });
		document.getElementById('attendanceRate').textContent = statuses.length ? `${Math.round(((statuses.filter(value => ['present', 'late'].includes(value)).length / statuses.length) * 1000)) / 10}%` : '0%';
	};
	document.querySelectorAll('input[name^="attendance["]').forEach(input => input.addEventListener('change', () => { updateRow(input.closest('tr')); updateSummary(); }));
	document.getElementById('markAllPresent')?.addEventListener('click', () => { rows.forEach(row => { const present = row.querySelector('input[value="present"]'); present.checked = true; updateRow(row); }); updateSummary(); });
	document.getElementById('attendanceSearch')?.addEventListener('input', event => { const query = event.target.value.toLowerCase().trim(); rows.forEach(row => { row.hidden = query && !row.dataset.name.includes(query); }); });
})();
</script>
@endsection