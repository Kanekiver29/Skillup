@extends('teacher.layouts.master')

@section('title', 'Create Lesson')
@section('page_title', 'Create Lesson')
@section('content')
<style>
    .lesson-form-page { max-width: 980px; margin: 0 auto; padding: 2rem 1.25rem 3rem; color: #17233f; }
    .lesson-form-heading { margin-bottom: 1.5rem; }
    .lesson-form-heading h1 { margin: 0; font-size: 2rem; font-weight: 800; color: #0b1730; }
    .lesson-form-heading p { margin: .45rem 0 0; color: #64748b; }
    .lesson-form-card { background: #fff; border: 1px solid #dfe7f5; border-radius: 14px; padding: 1.5rem; box-shadow: 0 12px 30px rgba(25, 48, 92, .08); }
    .lesson-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.15rem; }
    .lesson-field { display: flex; flex-direction: column; gap: .4rem; }
    .lesson-field.full { grid-column: 1 / -1; }
    .lesson-field label { font-weight: 700; font-size: .9rem; color: #243452; }
    .lesson-field input, .lesson-field select, .lesson-field textarea { width: 100%; box-sizing: border-box; border: 1px solid #cbd7e9; border-radius: 8px; padding: .75rem .85rem; background: #fbfdff; color: #17233f; font: inherit; }
    .lesson-field input:focus, .lesson-field select:focus, .lesson-field textarea:focus { outline: 2px solid #8db4ff; border-color: #4677db; }
    .lesson-field small { color: #718198; font-size: .78rem; }
    .lesson-error { background: #fff1f2; border: 1px solid #fecdd3; color: #be123c; border-radius: 8px; padding: .9rem 1rem; margin-bottom: 1.25rem; }
    .lesson-error ul { margin: .5rem 0 0 1.25rem; }
    .lesson-actions { display: flex; justify-content: flex-end; gap: .75rem; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #e8eef7; }
    .lesson-button { border: 0; border-radius: 8px; padding: .75rem 1.2rem; font-weight: 800; text-decoration: none; cursor: pointer; }
    .lesson-button.cancel { background: #f1f5fb; color: #334155; border: 1px solid #d7e0ed; }
    .lesson-button.save { background: #315bd6; color: #fff; }
    @media (max-width: 680px) { .lesson-form-grid { grid-template-columns: 1fr; } .lesson-field.full { grid-column: auto; } .lesson-form-card { padding: 1rem; } }
</style>
<div class="lesson-form-page">
    <div class="lesson-form-heading">
        <h1>Create Lesson</h1>
        <p>Add complete learning content for your students.</p>
    </div>

    @if($errors->any())
        <div class="lesson-error">
            <strong>Please correct the following:</strong>
            <ul>
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    @php($selectedModuleId = old('module_id', $module?->id))
    <form action="{{ route('teacher.lessons.store') }}" method="POST" enctype="multipart/form-data" class="lesson-form-card">
        @csrf
        <div class="lesson-form-grid">
            <div class="lesson-field full">
                <label for="title">Lesson title</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" placeholder="e.g. Introduction to Algebra" required>
            </div>

            <div class="lesson-field full">
                <label for="module_id">Module</label>
                <select id="module_id" name="module_id" required>
                    <option value="">Select module</option>
                    @foreach($modules as $availableModule)
                        <option value="{{ $availableModule->id }}" {{ $selectedModuleId == $availableModule->id ? 'selected' : '' }}>{{ $availableModule->title }} @if($availableModule->course) - {{ $availableModule->course->title }} @endif</option>
                    @endforeach
                </select>
                <small>Choose the module where students will find this lesson.</small>
            </div>

            <div class="lesson-field full">
                <label for="description">Short description</label>
                <textarea id="description" name="description" rows="3" placeholder="Summarize what students will learn.">{{ old('description') }}</textarea>
            </div>

            <div class="lesson-field full">
                <label for="content">Lesson content</label>
                <textarea id="content" name="content" rows="8" placeholder="Write the lesson text, instructions, or notes here.">{{ old('content') }}</textarea>
            </div>

            <div class="lesson-field">
                <label for="duration_minutes">Duration (minutes)</label>
                <input id="duration_minutes" name="duration_minutes" type="number" min="0" value="{{ old('duration_minutes', 30) }}">
            </div>

            <div class="lesson-field">
                <label for="image">Lesson image</label>
                <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                <small>JPG, PNG, GIF, WEBP, or SVG. Maximum 10 MB.</small>
            </div>

            <div class="lesson-field">
                <label for="video">Video file</label>
                <input id="video" name="video" type="file" accept="video/mp4,video/quicktime">
                <small>MP4 or MOV. Maximum 50 MB.</small>
            </div>

            <div class="lesson-field">
                <label for="material">Downloadable material</label>
                <input id="material" name="material" type="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip">
                <small>PDF, Word, PowerPoint, or ZIP. Maximum 20 MB.</small>
            </div>
        </div>

        <div class="lesson-actions">
            <a href="{{ route('teacher.lessons.index') }}" class="lesson-button cancel">Cancel</a>
            <button type="submit" class="lesson-button save">Save Lesson</button>
        </div>
    </form>
</div>
@endsection
