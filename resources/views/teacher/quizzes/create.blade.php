@extends('teacher.layouts.master')

@section('title', 'Create Quiz')
@section('page_title', 'Create Quiz')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1.25rem 3rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:2rem; font-weight:800; margin:0; color:#0b1730;">📝 Create Quiz</h1>
            <p style="margin-top:0.45rem; color:#64768f;">Add a new quiz to a course module.</p>
        </div>
        <a href="{{ route('teacher.quizzes.index') }}" style="display:inline-flex; align-items:center; gap:0.5rem; background:#f1f5fd; color:#0b1730; padding:0.7rem 1rem; border-radius:0.8rem; font-weight:700; border:1px solid #e4eaf7;">← Back to Quizzes</a>
    </div>

    @if($errors->any())
        <div style="background: rgba(220, 38, 38, 0.08); border:1px solid rgba(220,38,38,0.25); color:#b91c1c; padding:1rem 1.2rem; border-radius:0.8rem; margin-bottom:1rem;">
            <strong>Please fix the following:</strong>
            <ul style="margin:0.5rem 0 0 1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacher.quizzes.store') }}" method="POST" style="background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14); padding:1.5rem;">
        @csrf

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.25rem;">
            <div>
                <label for="title" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Quiz Title</label>
                <input id="title" name="title" type="text" required value="{{ old('title') }}" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
            </div>

            <div>
                <label for="passing_score" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Passing Score (%)</label>
                <input id="passing_score" name="passing_score" type="number" min="0" max="100" value="{{ old('passing_score', 70) }}" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.25rem; margin-top:1.25rem;">
            <div>
                <label for="course_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Course</label>
                <select id="course_id" name="course_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
                    <option value="">Select a course</option>
                    @foreach($courses ?? [] as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="module_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Module</label>
                <select id="module_id" name="module_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
                    <option value="">Select a module</option>
                    @foreach($modules ?? [] as $module)
                        <option value="{{ $module->id }}" {{ old('module_id', request('module_id')) == $module->id ? 'selected' : '' }}>{{ $module->title }} @if($module->course) — {{ $module->course->title }} @endif</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="subject_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Subject</label>
                <select id="subject_id" name="subject_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
                    <option value="">Select a subject</option>
                    @foreach($subjects ?? [] as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', request('subject_id')) == $subject->id ? 'selected' : '' }}>{{ $subject->title }} @if($subject->course) — {{ $subject->course->title }} @endif</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="major_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Major</label>
                <select id="major_id" name="major_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;"><option value="">Select a major</option>@foreach($majors ?? [] as $major)<option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>@endforeach</select>
            </div>
        </div>

        <div style="margin-top:1.25rem;">
            <label for="description" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Description</label>
            <textarea id="description" name="description" rows="4" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730; resize:vertical;">{{ old('description') }}</textarea>
        </div>

        <fieldset style="margin-top:1.25rem; border:1px solid #e4eaf7; border-radius:.8rem; padding:1rem;">
            <legend style="font-weight:800; color:#0b1730; padding:0 .4rem;">Trivia settings</legend>
            <label style="display:flex; gap:.5rem; align-items:center; font-weight:700; color:#0b1730;">
                <input type="checkbox" name="is_trivia" value="1" {{ old('is_trivia', request('is_trivia')) ? 'checked' : '' }}> Make this a trivia game
            </label>
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-top:1rem;">
                <div><label for="difficulty" style="display:block; font-weight:700; margin-bottom:.4rem;">Difficulty</label><select id="difficulty" name="difficulty" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"><option value="">Select difficulty</option><option value="easy" {{ old('difficulty') === 'easy' ? 'selected' : '' }}>Easy</option><option value="medium" {{ old('difficulty') === 'medium' ? 'selected' : '' }}>Medium</option><option value="hard" {{ old('difficulty') === 'hard' ? 'selected' : '' }}>Hard</option></select></div>
                <div><label for="question_count" style="display:block; font-weight:700; margin-bottom:.4rem;">Number of questions</label><input id="question_count" name="question_count" type="number" min="1" max="100" value="{{ old('question_count') }}" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
                <div><label for="question_time_limit_seconds" style="display:block; font-weight:700; margin-bottom:.4rem;">Seconds per question</label><input id="question_time_limit_seconds" name="question_time_limit_seconds" type="number" min="5" max="3600" value="{{ old('question_time_limit_seconds') }}" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
                <div><label for="scheduled_at" style="display:block; font-weight:700; margin-bottom:.4rem;">Schedule</label><input id="scheduled_at" name="scheduled_at" type="datetime-local" value="{{ old('scheduled_at') }}" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
            </div>
        </fieldset>

        <div style="margin-top:1.25rem; display:flex; justify-content:flex-end; gap:0.75rem; flex-wrap:wrap;">
            <a href="{{ route('teacher.quizzes.index') }}" style="padding:0.8rem 1.25rem; border-radius:0.8rem; background:#f1f5fd; color:#0b1730; border:1px solid #e4eaf7; font-weight:700;">Cancel</a>
            <button type="submit" name="is_published" value="0" style="padding:0.8rem 1.4rem; border:0; border-radius:0.8rem; background:#64748b; color:#fff; font-weight:800; cursor:pointer;">Save Draft</button>
            <button type="submit" name="is_published" value="1" style="padding:0.8rem 1.4rem; border:0; border-radius:0.8rem; background:linear-gradient(135deg,#3358e0,#5b7cf0); color:#fff; font-weight:800; cursor:pointer;">Publish</button>
        </div>
    </form>
</div>
@endsection
