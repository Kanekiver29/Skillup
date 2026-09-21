@extends('staff.layouts.masters')

@section('title', 'Create Assessment')

@section('content')
<div style="max-width: 960px; margin: 0 auto; padding: 1rem 0 2rem;">
    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; margin-bottom:1.25rem; flex-wrap:wrap;">
        <div>
            <div style="font-size:0.72rem; letter-spacing:0.14em; text-transform:uppercase; font-weight:700; color:#2563eb; margin-bottom:0.5rem;">Staff portal</div>
            <h1 style="margin:0; font-size:2rem; font-weight:800; color:#0b1526;">Create Assessment</h1>
            <p style="margin:0.5rem 0 0; color:#5a6f92;">Add a new assessment and then define the questionnaire.</p>
        </div>
        <a href="{{ route('staff.quizzes.list') }}" style="display:inline-flex; align-items:center; justify-content:center; padding:0.7rem 1rem; border-radius:0.75rem; background:#eef2ff; color:#1e3a8a; font-weight:600; text-decoration:none; border:1px solid #dfe7ff;">Back to list</a>
    </div>

    <div style="background:#fff; border:1px solid #e5edf9; border-radius:1rem; padding:1.5rem; box-shadow:0 12px 30px rgba(30,64,175,0.06);">
        <form action="{{ route('staff.quizzes.store') }}" method="POST">
            @csrf

            <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:1.25rem;">
                <div style="grid-column:1 / -1;">
                    <label for="title" style="display:block; margin-bottom:0.45rem; font-weight:600; color:#0b1526;">Assessment Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required
                           style="width:100%; padding:0.8rem 0.9rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;" />
                </div>

                <div style="grid-column:1 / -1;">
                    <label for="description" style="display:block; margin-bottom:0.45rem; font-weight:600; color:#0b1526;">Description</label>
                    <textarea id="description" name="description" rows="4" style="width:100%; padding:0.8rem 0.9rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a; resize:vertical;">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="module_id" style="display:block; margin-bottom:0.45rem; font-weight:600; color:#0b1526;">Module</label>
                    <select id="module_id" name="module_id" style="width:100%; padding:0.8rem 0.9rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;">
                        <option value="">Select a module</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                {{ $module->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="course_id" style="display:block; margin-bottom:0.45rem; font-weight:600; color:#0b1526;">Course</label>
                    <select id="course_id" name="course_id" style="width:100%; padding:0.8rem 0.9rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;">
                        <option value="">Select a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="passing_score" style="display:block; margin-bottom:0.45rem; font-weight:600; color:#0b1526;">Passing Score (%)</label>
                    <input id="passing_score" name="passing_score" type="number" min="0" max="100" value="{{ old('passing_score', 60) }}"
                           style="width:100%; padding:0.8rem 0.9rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;" />
                </div>

                <div>
                    <label for="time_limit_minutes" style="display:block; margin-bottom:0.45rem; font-weight:600; color:#0b1526;">Time Limit (Minutes)</label>
                    <input id="time_limit_minutes" name="time_limit_minutes" type="number" min="0" value="{{ old('time_limit_minutes', 30) }}"
                           style="width:100%; padding:0.8rem 0.9rem; border:1px solid #d9e2f5; border-radius:0.7rem; background:#f8fbff; color:#0f172a;" />
                </div>
            </div>

            <div style="margin-top:1.5rem; display:flex; gap:0.75rem; justify-content:flex-end; flex-wrap:wrap;">
                <a href="{{ route('staff.quizzes.list') }}" style="padding:0.8rem 1.1rem; border-radius:0.75rem; background:#f8fafc; border:1px solid #dfe7f3; color:#334155; text-decoration:none; font-weight:600;">Cancel</a>
                <button type="submit" style="padding:0.8rem 1.25rem; border-radius:0.75rem; border:none; background:linear-gradient(135deg,#2563eb,#4f46e5); color:#fff; font-weight:700; cursor:pointer;">
                    Create Assessment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
