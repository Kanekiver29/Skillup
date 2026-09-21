@extends('teacher.layouts.master')

@section('title', 'Add New Subject')
@section('page_title', 'Create Subject')

@section('content')
<style>
    .form-container {
        max-width: 860px;
        margin: 0 auto;
    }
    .form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .form-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--navy-950);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .btn-back {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--navy-800);
        font-weight: 700;
        padding: 0.6rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
        transition: all 0.2s var(--ease);
    }
    .btn-back:hover {
        background: var(--navy-50);
        color: var(--navy-950);
        border-color: var(--navy-200);
    }

    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        box-shadow: var(--shadow-card);
    }
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
    }
    .form-group {
        margin-bottom: 1.4rem;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--navy-950);
        margin-bottom: 0.45rem;
    }
    .form-group label span.req {
        color: var(--danger);
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface-2);
        color: var(--text);
        font-family: inherit;
        font-size: 0.92rem;
        transition: all 0.2s var(--ease);
    }
    .form-control:focus {
        border-color: var(--accent-2);
        box-shadow: 0 0 0 3.5px var(--accent-muted);
        outline: none;
        background: #fff;
    }
    .form-hint {
        font-size: 0.78rem;
        color: var(--muted);
        margin-top: 0.35rem;
    }

    .connection-box {
        background: linear-gradient(135deg, rgba(51, 88, 224, 0.05) 0%, rgba(56, 217, 217, 0.08) 100%);
        border: 1px solid var(--navy-100);
        border-radius: var(--radius-lg);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }
    .connection-box svg {
        color: var(--accent);
        width: 24px;
        height: 24px;
        flex-shrink: 0;
        margin-top: 0.2rem;
    }
    .connection-box h4 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--navy-950);
        margin-bottom: 0.2rem;
    }
    .connection-box p {
        font-size: 0.84rem;
        color: var(--text-2);
        line-height: 1.45;
    }

    .switch-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    .switch-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: var(--accent);
        cursor: pointer;
    }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
        border-top: 1px solid var(--border-soft);
        padding-top: 1.5rem;
        margin-top: 1rem;
    }
    .btn-submit {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.8rem 1.6rem;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 18px var(--accent-glow);
        transition: all 0.25s var(--ease);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px var(--accent-glow);
    }
</style>

<div class="form-container">
    <div class="form-header">
        <div>
            <h1>📖 Add New Subject</h1>
            <p style="color:var(--muted); font-size:0.9rem; margin-top:0.25rem;">Create a new subject entry and map it to a course in the student portal.</p>
        </div>
        <a href="{{ route('teacher.subjects.index') }}" class="btn-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to List
        </a>
    </div>

    @if($errors->any())
        <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #b91c1c; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <strong style="display:block; margin-bottom:0.4rem;">Please correct the errors below:</strong>
            <ul style="padding-left: 1.2rem; font-size: 0.88rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <div class="connection-box">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            <div>
                <h4>Automatic Student Userpage Synchronization</h4>
                <p>When you select a <strong>Connected Course</strong> below, students viewing <a href="{{ route('subjects') }}" target="_blank" style="color:var(--accent); text-decoration:underline;">Userpage/course/subject</a> will immediately see this subject along with lesson counts, progress tracking, and links to quizzes.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('teacher.subjects.store') }}">
            @csrf

            <div class="grid-2">
                <div class="form-group">
                    <label for="title">Subject Title <span class="req">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="e.g., Web Development & API Integration" required>
                    <div class="form-hint">Official title of the subject displayed to students.</div>
                </div>

                <div class="form-group">
                    <label for="subject_code">Subject Code</label>
                    <input type="text" id="subject_code" name="subject_code" value="{{ old('subject_code') }}" class="form-control" placeholder="e.g., CS101, IT204">
                    <div class="form-hint">Unique academic identifier (optional).</div>
                </div>

                <div class="form-group">
                    <label for="subject_type">Subject Type</label>
                    <select id="subject_type" name="subject_type" class="form-control">
                        <option value="">-- Select Type --</option>
                        @foreach(['Core', 'Elective', 'Laboratory', 'Practical', 'Seminar', 'Workshop', 'Online'] as $type)
                            <option value="{{ $type }}" {{ old('subject_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <div class="form-hint">Classifies how this subject is taught.</div>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="course_id">Connected Course <span class="req">*</span></label>
                    <select id="course_id" name="course_id" class="form-control">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->title }} ({{ $c->lessons()->count() }} Lessons)
                            </option>
                        @endforeach
                    </select>
                    <div class="form-hint">Required so modules, materials, and quizzes appear to enrolled students.</div>
                </div>

                <div class="grid-2" style="margin-bottom:0;">
                    <div class="form-group">
                        <label for="units">Units</label>
                        <input type="number" id="units" name="units" value="{{ old('units', 3) }}" min="1" max="20" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="hours">Total Hours</label>
                        <input type="number" id="hours" name="hours" value="{{ old('hours', 54) }}" min="1" max="500" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Subject Description</label>
                <textarea id="description" name="description" rows="4" class="form-control" placeholder="Describe the topics, objectives, and competencies covered in this subject...">{{ old('description') }}</textarea>
                <div class="form-hint">Overview text shown on the subject directory cards.</div>
            </div>

            <div class="form-group">
                <label>Status</label>
                <div class="switch-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                    <label for="is_active" style="margin:0; font-weight:600; cursor:pointer;">
                        Active & Visible in Student Course Directory
                    </label>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('teacher.subjects.index') }}" class="btn-back">Cancel</a>
                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Save & Publish Subject
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
