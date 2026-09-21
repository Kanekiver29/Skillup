@extends('sias.teacher.layout.layout')
@section('title', 'Trainees')
@section('page_title', 'Trainees')
@section('content')
<div class="page-card">
    <h2>Trainee List</h2>
    <p>
        @if($batch)
            Showing trainees for batch: <strong>{{ $batch }}</strong>.
        @else
            Enrollment information, training progress, and trainee status.
        @endif
    </p>

    <div class="portal-grid" style="margin-bottom: 1rem;">
        <div class="portal-card">
            <strong>{{ $enrollments->count() }}</strong>
            <span>Trainees</span>
        </div>
        <div class="portal-card">
            <strong>{{ $enrollments->filter(fn ($row) => ($row->status ?? 'active') === 'completed')->count() }}</strong>
            <span>Completed</span>
        </div>
        <div class="portal-card">
            <strong>{{ $enrollments->filter(fn ($row) => ($row->status ?? 'active') !== 'completed')->count() }}</strong>
            <span>Active</span>
        </div>
        <div class="portal-card">
            <strong>{{ round($enrollments->avg('progress') ?? 0, 1) }}%</strong>
            <span>Average Progress</span>
        </div>
    </div>

    <div style="overflow:auto">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Trainee</th>
                    <th>Program</th>
                    <th>Batch</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td>
                            <strong>{{ $enrollment->user?->name ?? '—' }}</strong><br>
                            <small>{{ $enrollment->user?->lrn ?? $enrollment->user?->email ?? 'No identifier available' }}</small>
                        </td>
                        <td>{{ $enrollment->course?->title ?? '—' }}</td>
                        <td>{{ $enrollment->batch_class ?? 'Unassigned' }}</td>
                        <td>{{ $enrollment->training_schedule ?? 'Not assigned' }}</td>
                        <td>
                            <span>{{ ucfirst($enrollment->status ?? 'active') }}</span>
                        </td>
                        <td>{{ $enrollment->progress ?? 0 }}%</td>
                        <td>{{ $enrollment->final_grade ?? 'Pending' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No trainees enrolled in your programs.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection