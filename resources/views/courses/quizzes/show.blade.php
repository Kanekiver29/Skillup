@extends('layout.app')

@section('title', $quiz->title . ' - Quiz')
@section('content')
<div style="max-width:860px;margin:0 auto;padding:2rem 1.25rem;color:#17233f;">
    <div style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        <p style="color:#64748b;margin:0 0 .5rem;">{{ $course->title }} / {{ $module->title }}</p>
        <h1 style="margin:0;color:#0b1730;font-size:2rem;font-weight:800;">{{ $quiz->title }}</h1>
        <p style="color:#52627c;line-height:1.7;margin:1rem 0 1.5rem;">{{ $quiz->description ?: 'Test your understanding of this module.' }}</p>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;color:#52627c;margin-bottom:1.5rem;">
            <span>{{ $quiz->questions()->count() }} questions</span>
            <span>Passing score: {{ $quiz->passing_score }}%</span>
            @if($quiz->time_limit_minutes)<span>{{ $quiz->time_limit_minutes }} minutes</span>@endif
            <span>Attempts: {{ $attemptCount }} / {{ $quiz->attempt_limit }}</span>
        </div>
        @if(session('error'))<div style="color:#b91c1c;background:#fff1f2;padding:.8rem;border-radius:8px;margin-bottom:1rem;">{{ session('error') }}</div>@endif
        @if($canRetry)
            <a href="{{ route('quizzes.start', [$course->slug, $module->slug, $quiz->slug]) }}" style="display:inline-block;background:#315bd6;color:#fff;padding:.8rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:800;">Start Quiz</a>
        @else
            <strong style="color:#b91c1c;">Attempt limit reached.</strong>
        @endif
    </div>
</div>
@endsection
