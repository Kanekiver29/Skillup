@extends('teacher.layouts.master')

@section('title', 'Quiz details')
@section('page_title', 'Quiz details')

@section('content')
    <section class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <div>
                <h3 style="margin:0;">{{ $quiz->title }}</h3>
                <p style="margin:0.75rem 0 0; color:var(--muted);">Quiz details and settings.</p>
            </div>
            <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                <a href="{{ route('teacher.quizzes.edit', $quiz) }}" class="btn-primary">Edit quiz</a>
                <a href="{{ route('teacher.quizzes.index') }}" class="btn-secondary">Back to quizzes</a>
            </div>
        </div>

        <div style="display:grid; gap:1rem;">
            <div>
                <strong>Description</strong>
                <p style="margin:0.5rem 0 0;">{{ $quiz->description ?? 'No description provided.' }}</p>
            </div>
            <div>
                <strong>Module</strong>
                <p style="margin:0.5rem 0 0;">{{ optional($quiz->module)->title ?? 'Not assigned' }}</p>
            </div>
            <div>
                <strong>Course</strong>
                <p style="margin:0.5rem 0 0;">{{ optional(optional($quiz->module)->course)->title ?? 'Not assigned' }}</p>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:0.9rem;">
                <div>
                    <strong>Passing score</strong>
                    <p style="margin:0.5rem 0 0;">{{ $quiz->passing_score ?? 0 }}%</p>
                </div>
                <div>
                    <strong>Time limit</strong>
                    <p style="margin:0.5rem 0 0;">{{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes . ' minutes' : 'None' }}</p>
                </div>
                <div>
                    <strong>Published</strong>
                    <p style="margin:0.5rem 0 0;">{{ $quiz->is_published ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
