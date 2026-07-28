@extends('teacher.layouts.master')

@section('title', 'Student Overview')
@section('page_title', 'Student Overview')

@section('content')
<div class="card" style="max-width: 1000px; margin: 0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <div>
            <h2 style="margin:0 0 .35rem; font-size:1.4rem;">{{ $enrollment->user->name ?? 'Student' }}</h2>
            <p style="margin:0; color:var(--muted);">
                {{ $enrollment->course->title ?? 'Course' }} · {{ $enrollment->status ?? 'Active' }}
            </p>
        </div>
        <a href="{{ route('teacher.students.index') }}" class="btn btn-outline" style="text-decoration:none;">Back to students</a>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:1rem; margin-bottom:1.5rem;">
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Progress</div>
            <div style="font-size:1.7rem; font-weight:700;">{{ (int) ($enrollment->progress ?? 0) }}%</div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Status</div>
            <div style="font-size:1.1rem; font-weight:700;">{{ $enrollment->status ?? 'Active' }}</div>
        </div>
        <div class="card" style="padding:1rem; margin:0;">
            <div style="font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--muted); margin-bottom:.35rem;">Email</div>
            <div style="font-size:1rem; font-weight:600;">{{ $enrollment->user->email ?? '—' }}</div>
        </div>
    </div>

    <div class="card" style="padding:1rem; margin:0;">
        <h3 style="margin-top:0;">Learning snapshot</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">A simple teacher overview for this learner’s current enrollment.</p>
        <ul style="margin:0; padding-left:1.1rem; line-height:1.8;">
            <li>Course: {{ $enrollment->course->title ?? 'Course' }}</li>
            <li>Student: {{ $enrollment->user->name ?? 'Student' }}</li>
            <li>Current progress: {{ (int) ($enrollment->progress ?? 0) }}%</li>
            <li>Enrollment status: {{ $enrollment->status ?? 'Active' }}</li>
        </ul>
    </div>
</div>
@endsection
