@extends('teacher.layouts.master')

@section('title', 'Edit Quiz')
@section('page_title', 'Edit Quiz')

@section('content')
    <section class="card">
        <h3 style="margin-top:0;">Edit quiz</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">Update the title and description for this quiz.</p>

        <form method="POST" action="{{ route('teacher.quizzes.update', $quiz) }}">
            @csrf
            @method('PUT')
            <div style="display:grid; gap:1rem;">
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Quiz title</label>
                    <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Description</label>
                    <textarea name="description" rows="4" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;">{{ old('description', $quiz->description) }}</textarea>
                </div>
                <div style="display:flex; gap:0.8rem; flex-wrap:wrap;">
                    <button type="submit" class="btn-primary">Save changes</button>
                    <a href="{{ route('teacher.quizzes.show', $quiz) }}" class="btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </section>
@endsection
