@extends('teacher.layouts.master')
@section('title', 'Assessment Details')
@section('page_title', 'Assessment Details')
@section('content')
<div class="portal-page"><div class="portal-card"><h2>{{ $assessment->title }}</h2><p>{{ $assessment->description ?? 'No description available.' }}</p><p>Passing score: {{ $assessment->passing_score ?? 'Not set' }}</p><a class="portal-button" href="{{ route('teacher.assessments.index') }}">Back to assessments</a></div></div>
@endsection