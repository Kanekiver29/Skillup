@extends('teacher.layouts.master')

@section('title', 'Student Progress')
@section('page_title', 'Student Progress')

@section('content')
<style>
    .progress-page { display:grid; gap:1.25rem; }
    .progress-summary { display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:1rem; }
    .progress-card, .progress-table-card { background:#fff; border:1px solid #e4eaf7; border-radius:1rem; box-shadow:0 10px 30px rgba(9,20,51,.08); }
    .progress-card { padding:1.1rem 1.2rem; }
    .progress-card span { display:block; color:#64768f; font-size:.78rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
    .progress-card strong { display:block; margin-top:.35rem; color:#0b1730; font-size:1.7rem; }
    .progress-table-card { overflow:hidden; }
    .progress-table-header { padding:1.2rem 1.25rem; border-bottom:1px solid #eef2fb; }
    .progress-table-header h2 { margin:0; color:#0b1730; font-size:1.1rem; }
    .progress-table-header p { margin:.3rem 0 0; color:#64768f; font-size:.85rem; }
    .progress-table-wrap { overflow-x:auto; }
    .progress-table { width:100%; min-width:980px; border-collapse:collapse; }
    .progress-table th, .progress-table td { padding:.9rem 1.25rem; text-align:left; border-bottom:1px solid #eef2fb; }
    .progress-table th { color:#64768f; font-size:.72rem; text-transform:uppercase; letter-spacing:.05em; background:#fbfcff; }
    .progress-table td { color:#33415c; font-size:.88rem; }
    .progress-table td strong { color:#0b1730; }
    .progress-meter { display:flex; align-items:center; gap:.65rem; min-width:150px; }
    .progress-track { flex:1; height:8px; overflow:hidden; border-radius:999px; background:#e4eaf7; }
    .progress-fill { height:100%; border-radius:inherit; background:#3358e0; }
    .progress-value { min-width:42px; color:#0b1730; font-weight:700; }
    .progress-status { display:inline-block; padding:.3rem .55rem; border-radius:999px; background:#eef2ff; color:#3730a3; font-size:.75rem; font-weight:700; }
    .progress-activity { color:#64768f; font-size:.8rem; line-height:1.45; }
    .progress-activity strong { display:block; color:#33415c; font-size:.84rem; }
    .progress-link { color:#3358e0; font-weight:700; text-decoration:none; }
    .progress-link:hover { text-decoration:underline; }
    .progress-empty { padding:2rem 1.25rem; color:#64768f; text-align:center; }
    @media (max-width:800px) { .progress-summary { grid-template-columns:repeat(2, minmax(0, 1fr)); } }
    @media (max-width:480px) { .progress-summary { grid-template-columns:1fr; } }
</style>

<div class="progress-page">
    <div class="progress-summary">
        <div class="progress-card"><span>Students</span><strong>{{ $summary['students'] }}</strong></div>
        <div class="progress-card"><span>Courses</span><strong>{{ $summary['courses'] }}</strong></div>
        <div class="progress-card"><span>Average Progress</span><strong>{{ $summary['average'] }}%</strong></div>
        <div class="progress-card"><span>Completed</span><strong>{{ $summary['completed'] }}</strong></div>
    </div>

    <section class="progress-table-card">
        <div class="progress-table-header">
            <h2>Enrolled Student Progress</h2>
            <p>Monitor progress across the courses assigned to you.</p>
        </div>
        @if($enrollments->isNotEmpty())
            <div class="progress-table-wrap">
                <table class="progress-table">
                    <thead>
                        <tr><th>Student</th><th>Course</th><th>Subject</th><th>Progress</th><th>Lessons</th><th>Activity</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            @php($progress = $enrollment->monitoring_progress)
                            <tr>
                                <td><a class="progress-link" href="{{ route('teacher.students.show', $enrollment->id) }}">{{ $enrollment->user?->name ?? 'Unknown student' }}</a></td>
                                <td>{{ $enrollment->course?->title ?? '—' }}</td>
                                <td>{{ $enrollment->subject?->title ?? 'All subjects' }}</td>
                                <td>
                                    <div class="progress-meter">
                                        <div class="progress-track"><div class="progress-fill" style="width:{{ $progress }}%"></div></div>
                                        <span class="progress-value">{{ $progress }}%</span>
                                    </div>
                                </td>
                                <td>{{ $enrollment->completed_lessons }}/{{ $enrollment->total_lessons }}<br><small>{{ $enrollment->quiz_attempts }} quiz attempts</small></td>
                                <td class="progress-activity">
                                    @if($enrollment->last_activity)
                                        <strong>{{ $enrollment->last_activity->diffForHumans() }}</strong>
                                        {{ $enrollment->last_activity->format('M j, Y g:i A') }}
                                    @else
                                        No activity recorded
                                    @endif
                                </td>
                                <td><span class="progress-status">{{ $progress >= 100 ? 'Completed' : ucfirst($enrollment->status ?? 'In progress') }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="progress-empty">No students are enrolled in your courses yet.</div>
        @endif
    </section>
</div>
@endsection