@extends('sias.students.layout.master')

@section('title', 'Final Grades (Ignore)')
@section('page_title', 'Final Grades (Ignore)')

@section('content')
<section id="final-grades-ignore" class="section-block">
    <h3>Final Grades (Ignore Curriculum)</h3>

    @if(empty($courseGrades))
        <p>No final grades available.</p>
    @else
        <div><strong>Final GWA:</strong> {{ $gwaMatch !== null ? $gwaMatch . '%' : 'N/A' }}</div>
    @endif
</section>
@endsection
