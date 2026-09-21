@extends('teacher.layouts.master')
@section('title', 'Edit Assessment')
@section('page_title', 'Edit Assessment')
@section('content')
<div class="portal-page"><div class="portal-card"><h2>Edit {{ $assessment->title }}</h2><p>Use the assessment builder to update questions, timing, and passing requirements.</p><a class="portal-button" href="{{ route('teacher.quizzes.edit', $assessment->id) }}">Open editor</a></div></div>
@endsection