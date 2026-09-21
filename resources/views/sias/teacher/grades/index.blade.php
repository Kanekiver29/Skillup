@extends('sias.teacher.layout.layout')

@section('title', 'Teacher Grades')
@section('page_title', 'Gradebook')

@section('content')
<div class="page-card">
    <h2>Gradebook</h2>
    <p>Manage student grades and assessment status.</p>
    <p><a href="{{ route('sias.teacher.grades.index') }}" class="btn">Open grade entry</a></p>
</div>
@endsection
