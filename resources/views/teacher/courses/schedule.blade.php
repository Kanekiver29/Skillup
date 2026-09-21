@extends('teacher.layouts.master')
@section('title', 'Program Schedule')
@section('page_title', 'Program Schedule')
@section('content')
<div class="portal-page"><div class="portal-heading"><div><h2>{{ $course->title }}</h2><p>Training duration, schedule, and practical session planning.</p></div><a class="portal-button" href="{{ route('teacher.schedule.index') }}">View all schedules</a></div><div class="portal-grid"><div class="portal-card"><strong>{{ $course->duration_hours ?? 0 }}</strong><span>Training hours</span></div><div class="portal-card"><strong>{{ $course->delivery_mode ?? 'Flexible' }}</strong><span>Delivery mode</span></div><div class="portal-card"><strong>{{ $course->level ?? '—' }}</strong><span>Program level</span></div></div></div>
@endsection