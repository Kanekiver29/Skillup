@extends('layout.app')

@section('title', $quiz->title . ' - Attempt')
@section('content')
<div style="max-width:860px;margin:0 auto;padding:2rem 1.25rem;color:#17233f;">
    @if($quiz->is_trivia && $quiz->question_time_limit_seconds)
        <div id="trivia-timer" style="background:#fff3cd;color:#854d0e;padding:.75rem 1rem;border-radius:8px;text-align:center;font-weight:800;margin-bottom:1rem;">Time remaining: {{ $quiz->question_time_limit_seconds }} seconds</div>
    @endif
    <form id="quiz-attempt-form" method="POST" action="{{ route('quizzes.submit', [$course->slug, $module->slug, $quiz->slug]) }}" style="background:#fff;border:1px solid #dfe7f5;border-radius:16px;padding:2rem;box-shadow:0 12px 30px rgba(25,48,92,.08);">
        @csrf
        <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">
        <h1 style="margin:0 0 1.5rem;color:#0b1730;font-size:2rem;font-weight:800;">{{ $quiz->title }}</h1>
        @foreach($questions as $index => $question)
            <fieldset style="border:0;border-top:1px solid #e8eef7;padding:1.25rem 0;margin:0;">
                <legend style="font-weight:800;font-size:1.05rem;margin-bottom:.8rem;">{{ $index + 1 }}. {{ $question->question_text }} <small style="color:#64748b;">({{ $question->points }} pt)</small></legend>
                @if($question->type === 'short_answer')
                    <input type="text" name="responses[{{ $question->id }}]" required style="width:100%;padding:.75rem;border:1px solid #cbd7e9;border-radius:8px;">
                @else
                    @foreach($question->answers as $answer)
                        <label style="display:block;padding:.7rem;border:1px solid #e1e8f3;border-radius:8px;margin:.4rem 0;cursor:pointer;"><input type="radio" name="responses[{{ $question->id }}]" value="{{ $answer->id }}" required> {{ $answer->answer_text }}</label>
                    @endforeach
                @endif
            </fieldset>
        @endforeach
        <button type="submit" style="border:0;background:#315bd6;color:#fff;padding:.8rem 1.2rem;border-radius:8px;font-weight:800;cursor:pointer;">Submit Quiz</button>
    </form>
</div>
@if($quiz->is_trivia && $quiz->question_time_limit_seconds)
<script>
    (() => { let seconds = {{ $quiz->question_time_limit_seconds }}; const timer = document.getElementById('trivia-timer'); const form = document.getElementById('quiz-attempt-form'); const interval = setInterval(() => { seconds -= 1; timer.textContent = `Time remaining: ${seconds} seconds`; if (seconds <= 0) { clearInterval(interval); form.noValidate = true; form.submit(); } }, 1000); })();
</script>
@endif
@endsection
