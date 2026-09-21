@extends('sias.students.layout.master')

@section('title', 'GWA (Ignore)')
@section('page_title', 'GWA (Ignore)')

@section('content')
<section id="gwa-ignore" class="section-block">
    <h3>General Weighted Average (Ignore Curriculum)</h3>

    @if(empty($courseGrades))
        <p>No grade records available yet.</p>
    @else
        <div class="space-y-2">
            <div><strong>GWA:</strong> {{ $gwaMatch !== null ? $gwaMatch . '%' : 'No grades yet' }}</div>
            <ul class="list-disc list-inside text-sm text-slate-700">
                @foreach($courseGrades as $courseId => $grade)
                    @php $course = $enrollments->firstWhere('course_id', $courseId)->course; @endphp
                    <li>{{ $course->title ?? 'Course #' . $courseId }}: {{ $grade }}%</li>
                @endforeach
            </ul>
        </div>
    @endif
</section>
@endsection
