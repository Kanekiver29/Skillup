@extends('teacher.layouts.master')

@section('title', 'Trivia Games by Module')
@section('page_title', 'Trivia Games by Module')

@section('content')
<div style="max-width:1200px;margin:0 auto;padding:2rem 1.25rem 3rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        <div>
            <h1 style="font-size:2rem;font-weight:800;margin:0;color:#0b1730;">Trivia Games by Module</h1>
            <p style="margin:.45rem 0 0;color:#64768f;">Create and manage the trivia challenges attached to each module.</p>
        </div>
        <div style="display:flex;gap:.6rem;flex-wrap:wrap;">
            <a href="{{ route('teacher.quizzes.index') }}" style="padding:.7rem 1rem;border-radius:.8rem;background:#f1f5fd;color:#0b1730;border:1px solid #e4eaf7;font-weight:700;">Back to Quizzes</a>
            <a href="{{ route('teacher.quizzes.create', ['is_trivia' => 1]) }}" style="padding:.7rem 1rem;border-radius:.8rem;background:#15803d;color:#fff;font-weight:700;">+ New Trivia Game</a>
        </div>
    </div>

    @if($modules->isEmpty())
        <div style="background:#fff;border:1px solid #e4eaf7;border-radius:1.25rem;padding:3rem 1.5rem;text-align:center;box-shadow:0 10px 30px -12px rgba(9,20,51,.14);">
            <h2 style="margin:0 0 .5rem;color:#0b1730;">No trivia games yet</h2>
            <p style="margin:0 0 1.25rem;color:#64768f;">Create a trivia game and assign it to one of your course modules.</p>
            <a href="{{ route('teacher.quizzes.create', ['is_trivia' => 1]) }}" style="display:inline-flex;padding:.75rem 1.1rem;border-radius:.75rem;background:#3358e0;color:#fff;font-weight:800;">Create Trivia Game</a>
        </div>
    @else
        <div style="display:grid;gap:1rem;">
            @foreach($modules as $module)
                <section style="background:#fff;border:1px solid #e4eaf7;border-radius:1.1rem;padding:1.25rem;box-shadow:0 10px 30px -12px rgba(9,20,51,.12);">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
                        <div>
                            <p style="margin:0 0 .25rem;color:#64768f;font-size:.8rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;">{{ $module->course?->title ?? 'Course' }}</p>
                            <h2 style="margin:0;color:#0b1730;font-size:1.25rem;font-weight:800;">{{ $module->title }}</h2>
                        </div>
                        <a href="{{ route('teacher.quizzes.create', ['module_id' => $module->id, 'is_trivia' => 1]) }}" style="padding:.6rem .9rem;border-radius:.7rem;background:#e8fff3;color:#15803d;border:1px solid #b9f2d0;font-weight:700;">+ Add to Module</a>
                    </div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:.75rem;">
                        @foreach($module->quizzes as $quiz)
                            <article style="border:1px solid #e4eaf7;border-left:4px solid #f26b5e;border-radius:.8rem;padding:1rem;background:#fbfcff;">
                                <div style="display:flex;justify-content:space-between;gap:.75rem;align-items:flex-start;">
                                    <h3 style="margin:0;color:#0b1730;font-size:1rem;">{{ $quiz->title }}</h3>
                                    <span style="font-size:.72rem;font-weight:800;color:{{ $quiz->is_published ? '#15803d' : '#b45309' }};">{{ $quiz->is_published ? 'Published' : 'Draft' }}</span>
                                </div>
                                <p style="margin:.65rem 0;color:#64768f;font-size:.85rem;">{{ $quiz->questions_count }} questions · {{ ucfirst($quiz->difficulty ?: 'Mixed') }}</p>
                                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" style="padding:.45rem .7rem;border-radius:.6rem;background:#edf2ff;color:#182c63;font-size:.82rem;font-weight:700;">Edit</a>
                                    <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" style="padding:.45rem .7rem;border-radius:.6rem;background:#f1f5fd;color:#33415c;font-size:.82rem;font-weight:700;">Results</a>
                                    @if($quiz->is_published && $quiz->slug && $module->course?->slug && $module->slug)
                                        <a href="{{ route('quizzes.start', [$module->course->slug, $module->slug, $quiz->slug]) }}" target="_blank" style="padding:.45rem .7rem;border-radius:.6rem;background:#e8fff3;color:#15803d;font-size:.82rem;font-weight:700;">Preview</a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    @endif
</div>
@endsection
