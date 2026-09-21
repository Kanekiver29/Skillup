@extends('sias.teacher.layout.layout')
@section('title', 'Assessment')
@section('page_title', 'Assessment')
@section('content')
<div class="page-card"><div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap"><div><h2>Assessment</h2><p>Create/manage assessments, competency status, results, and history.</p></div><a class="btn" href="{{ route('sias.teacher.grades.index') }}">Record results</a></div><div class="portal-grid">@forelse($assessments as $assessment)<article class="portal-card"><h3>{{ $assessment->title }}</h3><p>{{ $assessment->module?->course?->title ?? '—' }}</p><p>Passing score: {{ $assessment->passing_score }} · {{ $assessment->is_published ? 'Published' : 'Draft' }}</p></article>@empty<div class="portal-card"><p>No assessments created yet. Create them through your program modules.</p></div>@endforelse</div></div>
@endsection