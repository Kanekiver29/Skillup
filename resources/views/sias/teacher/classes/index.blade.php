@extends('sias.teacher.layout.layout')
@section('title', 'My Classes / Batches')
@section('page_title', 'My Classes / Batches')
@section('content')
<div class="page-card">
    <h2>My Classes / Batches</h2>
    <p>View trainees per batch, training status, and batch schedule.</p>

    <div class="portal-grid">
        @forelse($batches as $name => $rows)
            @php
                $course = $rows->first()->course;
                $totalTrainees = $rows->count();
                $activeCount = $rows->filter(fn ($row) => ($row->status ?? 'active') !== 'completed')->count();
                $completedCount = $rows->filter(fn ($row) => ($row->status ?? 'active') === 'completed')->count();
                $avgProgress = round($rows->avg('progress') ?? 0, 1);
                $schedule = $rows->first()->training_schedule ?? 'Schedule not assigned';
            @endphp

            <article class="portal-card">
                <h3>{{ $name }}</h3>
                <p><strong>Program:</strong> {{ $course?->title ?? 'Program not assigned' }}</p>
                <p><strong>Trainees:</strong> {{ $totalTrainees }}</p>
                <p><strong>Active:</strong> {{ $activeCount }} &nbsp;•&nbsp; <strong>Completed:</strong> {{ $completedCount }}</p>
                <p><strong>Average progress:</strong> {{ $avgProgress }}%</p>
                <p><strong>Schedule:</strong> {{ $schedule }}</p>
                <div style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <a class="btn" href="{{ route('sias.teacher.trainees', ['batch' => $name]) }}">View trainees</a>
                </div>
            </article>
        @empty
            <div class="portal-card">
                <p>No batches have been assigned.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection