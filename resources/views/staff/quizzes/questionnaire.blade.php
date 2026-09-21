@extends('staff.layouts.masters')

@section('title', 'Assessment Questionnaire')

@section('content')
<div style="max-width: 1100px; margin: 0 auto; padding: 1rem 0 2rem;">
    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; margin-bottom:1.25rem; flex-wrap:wrap;">
        <div>
            <div style="font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; font-weight:700; color:#2563eb; margin-bottom:0.5rem;">Assessment builder</div>
            <h1 style="margin:0; font-size:2rem; font-weight:800; color:#0b1526;">{{ $quiz->title }}</h1>
            <p style="margin:0.5rem 0 0; color:#5a6f92;">Manage the questions and correct answers for this assessment.</p>
        </div>
        <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
            <a href="{{ route('staff.quizzes.list') }}" style="display:inline-flex; align-items:center; justify-content:center; padding:0.7rem 1rem; border-radius:0.75rem; background:#eef2ff; color:#1e3a8a; font-weight:600; text-decoration:none; border:1px solid #dfe7ff;">Back to list</a>
            <a href="{{ route('staff.quizzes.edit', $quiz) }}" style="display:inline-flex; align-items:center; justify-content:center; padding:0.7rem 1rem; border-radius:0.75rem; background:#f8fafc; color:#0f172a; font-weight:600; text-decoration:none; border:1px solid #dfe7f3;">Edit details</a>
        </div>
    </div>

    <div style="background:#fff; border:1px solid #e5edf9; border-radius:1rem; padding:1.5rem; box-shadow:0 12px 30px rgba(30,64,175,0.06);">
        <form action="{{ route('staff.quizzes.questionnaire.store', $quiz) }}" method="POST">
            @csrf

            <div style="display:grid; gap:1.25rem;">
                <div style="padding:1rem 1.1rem; border:1px solid #e2e8f0; border-radius:0.8rem; background:#f8fafc;">
                    <div style="font-size:0.8rem; font-weight:700; letter-spacing:0.08em; color:#475569; text-transform:uppercase; margin-bottom:0.4rem;">Quiz Summary</div>
                    <div style="display:flex; gap:1rem; flex-wrap:wrap; color:#0f172a; font-size:0.95rem;">
                        <span><strong>Passing score:</strong> {{ $quiz->passing_score ?? 0 }}%</span>
                        <span><strong>Time limit:</strong> {{ $quiz->time_limit_minutes ?? 0 }} min</span>
                        <span><strong>Module:</strong> {{ $quiz->module?->title ?? 'Unassigned' }}</span>
                    </div>
                </div>

                <div style="border:1px dashed #cbd5e1; border-radius:0.8rem; padding:1.25rem; background:#fff;">
                    <div style="font-weight:700; color:#0f172a; margin-bottom:0.6rem;">Question 1</div>
                    <textarea name="questions[0][question_text]" rows="3" placeholder="Enter your first question here..." style="width:100%; padding:0.8rem 0.9rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a; resize:vertical;">{{ old('questions.0.question_text') }}</textarea>
                    <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:0.75rem; margin-top:0.85rem;">
                        <input type="text" name="questions[0][answers][0][answer_text]" value="{{ old('questions.0.answers.0.answer_text') }}" placeholder="Answer 1" style="padding:0.75rem 0.8rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;" />
                        <input type="text" name="questions[0][answers][1][answer_text]" value="{{ old('questions.0.answers.1.answer_text') }}" placeholder="Answer 2" style="padding:0.75rem 0.8rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;" />
                        <input type="text" name="questions[0][answers][2][answer_text]" value="{{ old('questions.0.answers.2.answer_text') }}" placeholder="Answer 3" style="padding:0.75rem 0.8rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;" />
                        <input type="text" name="questions[0][answers][3][answer_text]" value="{{ old('questions.0.answers.3.answer_text') }}" placeholder="Answer 4" style="padding:0.75rem 0.8rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;" />
                    </div>
                    <div style="margin-top:0.75rem;">
                        <label for="questions_0_correct" style="display:block; margin-bottom:0.35rem; font-weight:600; color:#0b1526;">Correct answer index</label>
                        <select id="questions_0_correct" name="questions[0][correct]" style="padding:0.7rem 0.8rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;">
                            <option value="">Select correct answer</option>
                            @for ($i = 0; $i < 4; $i++)
                                <option value="{{ $i }}" {{ old('questions.0.correct') == (string) $i ? 'selected' : '' }}>Answer {{ $i + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div style="margin-top:1.5rem; display:flex; gap:0.75rem; justify-content:flex-end; flex-wrap:wrap;">
                <a href="{{ route('staff.quizzes.list') }}" style="padding:0.8rem 1.1rem; border-radius:0.75rem; background:#f8fafc; border:1px solid #dfe7f3; color:#334155; text-decoration:none; font-weight:600;">Cancel</a>
                <button type="submit" style="padding:0.8rem 1.25rem; border-radius:0.75rem; border:none; background:linear-gradient(135deg,#2563eb,#4f46e5); color:#fff; font-weight:700; cursor:pointer;">
                    Save Questionnaire
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
