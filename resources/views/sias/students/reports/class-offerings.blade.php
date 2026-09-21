@extends('sias.students.layout.master')

@section('title', 'Class Offerings')
@section('page_title', 'Class Offerings')

@section('content')
<section id="class-offerings" class="section-block">
    <h3>Class Offerings</h3>

    @if(isset($enrollments) && $enrollments->isNotEmpty())
        <ul class="list-disc list-inside text-slate-700">
            @foreach($enrollments as $enrollment)
                @php $course = optional($enrollment)->course; @endphp
                <li>
                    <strong>{{ $course->title ?? 'Untitled Course' }}</strong>
                    @if(!empty($enrollment->section))
                        — Section {{ $enrollment->section }}
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No class offerings available yet.</p>
    @endif
</section>
@endsection
