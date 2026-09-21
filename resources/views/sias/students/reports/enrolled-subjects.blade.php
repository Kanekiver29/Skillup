@extends('sias.students.layout.master')

@section('title', 'Enrolled Subjects')
@section('page_title', 'Enrolled Subjects')

@section('content')
<section id="enrolled-subjects" class="section-block">
    <h3>Enrolled Subjects</h3>

    @if(isset($enrollments) && $enrollments->isNotEmpty())
        <ul class="list-disc list-inside text-slate-700">
            @foreach($enrollments as $enrollment)
                @php $course = optional($enrollment)->course; @endphp
                <li>{{ $course->title ?? 'Untitled Subject' }}@if(!empty($course->code)) ({{ $course->code }})@endif</li>
            @endforeach
        </ul>
    @else
        <p>You are not currently enrolled in any subjects.</p>
    @endif
</section>
@endsection
