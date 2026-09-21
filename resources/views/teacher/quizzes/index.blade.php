@extends('teacher.layouts.master')

@section('title', 'Quiz Manager')
@section('page_title', 'Quiz Manager')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1.25rem 3rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom: 1.5rem; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:2rem; font-weight:800; margin:0; color:#0b1730;">❓ Quiz Manager</h1>
            <p style="margin-top:0.45rem; color:#64768f;">Create, review, and manage quizzes for your modules.</p>
        </div>
        <div style="display:flex; gap:.6rem; flex-wrap:wrap;">
            <a href="{{ route('teacher.quizzes.trivia') }}" style="display:inline-flex; align-items:center; gap:0.5rem; background:#e8fff3; color:#15803d; padding:0.8rem 1.2rem; border-radius:0.8rem; font-weight:700; border:1px solid #b9f2d0;">Trivia by Module</a>
            <a href="{{ route('teacher.quizzes.create') }}" style="display:inline-flex; align-items:center; gap:0.5rem; background:linear-gradient(135deg,#3358e0,#5b7cf0); color:#fff; padding:0.8rem 1.2rem; border-radius:0.8rem; font-weight:700; box-shadow:0 8px 24px rgba(51,88,224,0.22);">+ Create Quiz</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); color:#15803d; padding:0.9rem 1.1rem; border-radius:0.8rem; margin-bottom:1rem; font-weight:600;">
            {{ session('success') }}
        </div>
    @endif

    @if($quizzes->isEmpty())
        <div style="background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; padding:2.5rem 1.5rem; text-align:center; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14);">
            <div style="font-size:3rem; margin-bottom: 1rem;">🧪</div>
            <h3 style="margin:0 0 0.5rem; font-size:1.4rem; color:#0b1730;">No quizzes yet</h3>
            <p style="margin:0; color:#64768f;">Create your first quiz to assess student understanding.</p>
        </div>
    @else
        <div style="background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; overflow:hidden; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14);">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#f1f5fd; text-align:left; color:#0b1730;">
                        <th style="padding:1rem 1.2rem; font-weight:700;">Title</th>
                        <th style="padding:1rem 1.2rem; font-weight:700;">Course</th>
                        <th style="padding:1rem 1.2rem; font-weight:700;">Module</th>
                        <th style="padding:1rem 1.2rem; font-weight:700;">Subject</th>
                        <th style="padding:1rem 1.2rem; font-weight:700;">Questions</th>
                        <th style="padding:1rem 1.2rem; font-weight:700;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr style="border-top:1px solid #eef2fb;">
                            <td style="padding:1rem 1.2rem; font-weight:700; color:#0b1730;">{{ $quiz->title }}</td>
                            <td style="padding:1rem 1.2rem; color:#33415c;">{{ $quiz->module?->course?->title ?? '—' }}</td>
                            <td style="padding:1rem 1.2rem; color:#33415c;">{{ $quiz->module?->title ?? '—' }}</td>
                            <td style="padding:1rem 1.2rem; color:#33415c;">{{ $quiz->subject?->title ?? '—' }}</td>
                            <td style="padding:1rem 1.2rem; color:#33415c;">{{ $quiz->questions_count ?? $quiz->questions()->count() }}</td>
                            <td style="padding:1rem 1.2rem; display:flex; gap:0.5rem; flex-wrap:wrap;">
                                @if($quiz->is_published && $quiz->slug && $quiz->module?->course?->slug && $quiz->module?->slug)
                                    <a href="{{ route('quizzes.show', [$quiz->module->course->slug, $quiz->module->slug, $quiz->slug]) }}" target="_blank" style="padding:0.5rem 0.8rem; border-radius:0.65rem; background:#e8fff3; color:#15803d; font-weight:600;">Student View</a>
                                @endif
                                <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" style="padding:0.5rem 0.8rem; border-radius:0.65rem; background:#edf2ff; color:#182c63; font-weight:600;">View</a>
                                <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" style="padding:0.5rem 0.8rem; border-radius:0.65rem; background:#eef9ff; color:#0f172a; font-weight:600;">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
