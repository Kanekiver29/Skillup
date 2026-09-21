@extends('teacher.layouts.master')
@section('title', 'Create Assessment')
@section('page_title', 'Create Assessment')
@section('content')
<div class="portal-page"><div class="portal-heading"><h2>Create Assessment</h2><p>Assessments are created inside a competency module.</p></div><div class="portal-card"><a class="portal-button" href="{{ route('teacher.quizzes.create') }}">Open assessment builder</a></div></div>
@endsection