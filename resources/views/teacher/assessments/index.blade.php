@extends('teacher.layouts.master')
@section('title', 'Assessment')
@section('page_title', 'Assessment')
@section('content')
<div class="portal-page"><div class="portal-heading"><div><h2>Assessment</h2><p>Create and manage assessments, record results, and review competency status.</p></div><a class="portal-button" href="{{ route('teacher.grades.index') }}">Record results</a></div><div class="portal-grid">@forelse($assessments as $assessment)<article class="portal-card"><h3>{{ $assessment->title }}</h3><p>{{ $assessment->module?->course?->title ?? '—' }}</p><p>Passing score: {{ $assessment->passing_score ?? 'Not set' }}</p><a class="portal-link" href="{{ route('teacher.quizzes.index') }}">View assessment history</a></article>@empty<div class="portal-card"><p>No assessments created yet.</p><a class="portal-button" href="{{ route('teacher.quizzes.create') }}">Create assessment</a></div>@endforelse</div></div>
@endsection