@extends('layout.app')

@section('title', $quiz->title . ' - Results')
@section('content')
<div style="max-width:860px;margin:0 auto;padding:2rem 1.25rem;color:#17233f;">
    <div style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        <p style="color:#64748b;margin:0 0 .5rem;">{{ $course->title }} / {{ $module->title }}</p>
        <h1 style="margin:0;color:#0b1730;font-size:2rem;font-weight:800;">{{ $quiz->title }} Results</h1>
        <div style="font-size:3rem;font-weight:800;color:#315bd6;margin:1rem 0;">{{ $attempt->score_percentage }}%</div>
        <p>{{ $attempt->passed ? 'Passed' : 'Keep practicing' }} · {{ $attempt->correct_answers }} correct answers</p>
        <a href="{{ route('quizzes.show', [$course->slug, $module->slug, $quiz->slug]) }}" style="display:inline-block;margin-top:1rem;background:#315bd6;color:#fff;padding:.8rem 1.2rem;border-radius:8px;text-decoration:none;font-weight:800;">Back to Quiz</a>
    </div>

    <div style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;margin-top:1.25rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        <h2 style="margin:0 0 1rem;color:#0b1730;font-size:1.35rem;font-weight:800;">Answer review</h2>
        @forelse($responses as $response)
            <div style="padding:1rem 0;border-top:1px solid #e8eef7;">
                <strong style="color:#0b1730;">{{ $response->question?->question_text }}</strong>
                <p style="margin:.45rem 0 0;color:{{ $response->is_correct ? '#15803d' : '#b91c1c' }};font-weight:700;">
                    {{ $response->is_correct ? 'Correct' : 'Incorrect' }}: {{ $response->answer?->answer_text ?? $response->answer_text ?? 'No answer' }}
                </p>
                @if(!$response->is_correct)
                    <p style="margin:.25rem 0 0;color:#64768f;">Correct answer: {{ $response->question?->getCorrectAnswer()?->answer_text ?? 'Not available' }}</p>
                @endif
                @if($response->question?->explanation)
                    <p style="margin:.25rem 0 0;color:#64768f;">{{ $response->question->explanation }}</p>
                @endif
            </div>
        @empty
            <p style="color:#64768f;">No answer details are available for this attempt.</p>
        @endforelse
    </div>
</div>
@endsection
