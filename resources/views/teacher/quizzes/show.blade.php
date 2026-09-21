@extends('teacher.layouts.master')

@section('title', 'Quiz Details')
@section('page_title', 'Quiz Details')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1.25rem 3rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:2rem; font-weight:800; margin:0; color:#0b1730;">❓ {{ $quiz->title }}</h1>
            <p style="margin-top:0.45rem; color:#64768f;">{{ $quiz->module?->course?->title ?? 'Course' }} / {{ $quiz->module?->title ?? 'Module' }}</p>
        </div>
        <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" style="padding:0.7rem 1rem; border-radius:0.8rem; background:#edf2ff; color:#182c63; font-weight:700;">Edit</a>
            <a href="{{ route('teacher.quizzes.index') }}" style="padding:0.7rem 1rem; border-radius:0.8rem; background:#f1f5fd; color:#0b1730; border:1px solid #e4eaf7; font-weight:700;">Back</a>
        </div>
    </div>

    <div style="background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14); padding:1.5rem;">
        <p style="color:#33415c; line-height:1.7; margin:0;">
            {{ $quiz->description ?: 'No description provided for this quiz yet.' }}
        </p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-top:1.5rem;">
            <div style="background:#f1f5fd; border-radius:0.85rem; padding:1rem;">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:#64768f; font-weight:700;">Passing score</div>
                <div style="font-size:1.4rem; font-weight:800; color:#0b1730; margin-top:0.3rem;">{{ $quiz->passing_score ?? 70 }}%</div>
            </div>
            <div style="background:#f1f5fd; border-radius:0.85rem; padding:1rem;">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:#64768f; font-weight:700;">Questions</div>
                <div style="font-size:1.4rem; font-weight:800; color:#0b1730; margin-top:0.3rem;">{{ $quiz->questions()->count() }}</div>
            </div>
            <div style="background:#f1f5fd; border-radius:0.85rem; padding:1rem;">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:#64768f; font-weight:700;">Status</div>
                <div style="font-size:1.1rem; font-weight:800; color:#0b1730; margin-top:0.3rem;">{{ $quiz->is_published ? 'Published' : 'Draft' }}</div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:.75rem; margin-top:2rem;">
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Participants</small><strong style="display:block; font-size:1.5rem; color:#0b1730;">{{ $participationStats['participants'] }}</strong></div>
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Attempts</small><strong style="display:block; font-size:1.5rem; color:#0b1730;">{{ $participationStats['attempts'] }}</strong></div>
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Average score</small><strong style="display:block; font-size:1.5rem; color:#0b1730;">{{ $participationStats['average_score'] }}%</strong></div>
            <div style="background:#eef9ff; border-radius:.85rem; padding:1rem;"><small style="color:#64768f; font-weight:700;">Pass rate</small><strong style="display:block; font-size:1.5rem; color:#0b1730;">{{ $participationStats['pass_rate'] }}%</strong></div>
        </div>

        <h2 style="margin:2rem 0 .75rem; color:#0b1730;">Leaderboard</h2>
        @forelse($leaderboard as $attempt)
            <div style="display:grid; grid-template-columns:3rem 1fr auto auto; gap:.75rem; align-items:center; border-top:1px solid #e4eaf7; padding:.75rem 0; color:#33415c;"><strong style="color:#315bd6;">#{{ $attempt->leaderboard_rank }}</strong><span>{{ $attempt->user?->name ?? 'Student' }}</span><span>{{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</span><strong>{{ $attempt->score_percentage }}%</strong></div>
        @empty
            <p style="color:#64768f;">No completed attempts yet.</p>
        @endforelse

        <h2 style="margin:2rem 0 .75rem; color:#0b1730;">Student scores and answer review</h2>
        @forelse($attempts as $attempt)
            <details style="border-top:1px solid #e4eaf7; padding:.85rem 0;">
                <summary style="cursor:pointer; font-weight:800; color:#0b1730;">{{ $attempt->user?->name ?? 'Student' }} · {{ $attempt->score_percentage }}% · {{ $attempt->passed ? 'Passed' : 'Not passed' }}</summary>
                <div style="display:grid; gap:.5rem; margin-top:.75rem;">
                    @foreach($attempt->responses as $response)
                        <div style="padding:.7rem .85rem; border-radius:.6rem; background:{{ $response->is_correct ? '#ecfdf5' : '#fff1f2' }}; color:{{ $response->is_correct ? '#166534' : '#9f1239' }};">
                            <strong>{{ $response->question?->question_text }}</strong><br>
                            <span>{{ $response->is_correct ? 'Correct' : 'Incorrect' }}: {{ $response->answer?->answer_text ?? $response->answer_text ?? 'No answer' }}</span>
                            @if(!$response->is_correct)<br><span>Correct answer: {{ $response->question?->getCorrectAnswer()?->answer_text ?? 'Not available' }}</span>@endif
                        </div>
                    @endforeach
                </div>
            </details>
        @empty
            <p style="color:#64768f;">Answer reviews will appear after students complete the game.</p>
        @endforelse
    </div>
</div>
@endsection
