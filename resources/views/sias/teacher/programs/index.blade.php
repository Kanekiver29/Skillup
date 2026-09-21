@extends('sias.teacher.layout.layout')
@section('title', 'My Training Programs')
@section('page_title', 'My Training Programs')
@section('content')
<div class="page-card"><div style="display:flex;justify-content:space-between;gap:1rem;align-items:center;flex-wrap:wrap"><div><h2>Assigned TESDA Programs</h2><p>Manage programs, training duration, sessions, and program details.</p></div><a class="btn" href="{{ route('sias.teacher.profile.create-course') }}">Add program</a></div><div class="portal-grid">@forelse($courses as $course)<article class="portal-card"><h3>{{ $course->title }}</h3><p>{{ $course->qualification_name ?? $course->category ?? 'TESDA training program' }}</p><p>{{ $course->duration_hours ?? 0 }} training hours · {{ $course->enrollments_count }} trainees</p><a class="btn" href="{{ route('sias.teacher.profile.edit-course', $course) }}">Manage program</a></article>@empty<div class="portal-card"><p>No assigned programs yet.</p></div>@endforelse</div></div>
@endsection