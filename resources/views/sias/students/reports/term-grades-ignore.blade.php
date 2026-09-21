@extends('sias.students.layout.master')

@section('title', 'Term Grades (Ignore)')
@section('page_title', 'Term Grades (Ignore)')

@section('content')
<section id="term-grades-ignore" class="section-block">
    <h3>Term Grades (Ignore Curriculum)</h3>

    @if(empty($courseGrades))
        <p>No grade records available.</p>
    @else
        <ul class="list-disc list-inside text-slate-700">
            @foreach($courseGrades as $courseId => $grade)
                @php $course = $enrollments->firstWhere('course_id', $courseId)->course; @endphp
                <li>{{ $course->title ?? 'Course' }}: {{ $grade }}%</li>
            @endforeach
        </ul>
    @endif
</section>
@endsection
