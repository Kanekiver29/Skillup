@extends('sias.teacher.layout.layout')
@section('title', 'Trainee Progress')
@section('page_title', 'Trainee Progress')
@section('content')
<div class="page-card"><h2>Trainee Progress</h2><p>Module completion, competency progress, assessment results, and overall training progress.</p><div style="overflow:auto"><table class="portal-table"><thead><tr><th>Trainee</th><th>Program</th><th>Module progress</th><th>Grade</th><th>Training status</th></tr></thead><tbody>@forelse($enrollments as $enrollment)<tr><td>{{ $enrollment->user?->name ?? '—' }}</td><td>{{ $enrollment->course?->title ?? '—' }}</td><td>{{ $enrollment->progress ?? 0 }}%</td><td>{{ $enrollment->final_grade ?? 'Pending' }}</td><td>{{ $enrollment->completed ? 'Completed' : ucfirst($enrollment->status ?? 'Active') }}</td></tr>@empty<tr><td colspan="5">No progress data available.</td></tr>@endforelse</tbody></table></div></div>
@endsection