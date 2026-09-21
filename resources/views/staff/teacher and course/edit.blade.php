@extends('staff.layouts.masters')

@section('title', 'Edit Assignment')

@section('content')
<style>
    .tsa-wrap {
        --bg: #eef3fc;
        --surface: #ffffff;
        --raised: #edf4ff;
        --border: rgba(148,163,184,0.38);
        --border-h: rgba(34,211,238,0.4);
        --accent: #6366F1;
        --cyan: #22D3EE;
        --emerald: #34D399;
        --amber: #FBBF24;
        --rose: #FB7185;
        --text: #0b1526;
        --text-dim: #5a6f92;
        --text-xs: #4B5563;
        color: var(--text);
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        min-height: 100%;
        position: relative;
        overflow: hidden;
        padding: 2rem;
        border-radius: 12px;
        background: var(--bg);
    }

    html[data-staff-theme="dark"] .tsa-wrap {
        --bg: #080D18;
        --surface: #0D1424;
        --raised: #111827;
        --border: rgba(99,102,241,0.18);
        --text: #E2E8F0;
        --text-dim: #7C8AA5;
    }
    
    .tsa-ambient-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.15;
        pointer-events: none;
        z-index: 0;
    }
    .tsa-orb-1 { width: 400px; height: 400px; top: -100px; left: -100px; background: var(--accent); }
    .tsa-orb-2 { width: 500px; height: 500px; bottom: -200px; right: -100px; background: var(--cyan); opacity: 0.1; }
    
    .tsa-header-content {
        position: relative;
        z-index: 10;
        margin-bottom: 2rem;
    }
    
    .tsa-back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-dim);
        text-decoration: none;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
        transition: all 0.2s ease;
    }
    .tsa-back-link:hover {
        color: var(--cyan);
        transform: translateX(-4px);
    }

    .tsa-heading {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.025em;
        margin: 0 0 0.5rem 0;
        background: linear-gradient(135deg, var(--text) 0%, var(--cyan) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: tsa-title-glow 3s ease-in-out infinite alternate;
    }
    @keyframes tsa-title-glow {
        0% { text-shadow: 0 0 20px rgba(34,211,238,0.1); }
        100% { text-shadow: 0 0 30px rgba(34,211,238,0.3); }
    }
    .tsa-subtitle {
        color: var(--text-dim);
        margin: 0;
        font-size: 1rem;
    }
    
    /* Alerts */
    .tsa-alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        position: relative;
        border-left: 4px solid transparent;
        z-index: 10;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .tsa-alert-error {
        background: rgba(251, 113, 133, 0.1);
        border-color: var(--rose);
        color: #ff9fb0;
    }
    .tsa-alert-close {
        background: transparent;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: 1.25rem;
        line-height: 1;
        opacity: 0.7;
    }
    .tsa-alert-close:hover { opacity: 1; }
    
    .tsa-validation-errors {
        background: rgba(251, 113, 133, 0.1);
        border: 1px solid rgba(251, 113, 133, 0.3);
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        position: relative;
        z-index: 10;
    }
    .tsa-validation-errors h4 {
        color: var(--rose);
        margin: 0 0 0.75rem 0;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .tsa-validation-errors ul {
        margin: 0;
        padding-left: 1.5rem;
        color: #ff9fb0;
        font-size: 0.875rem;
    }
    .tsa-validation-errors li { margin-bottom: 0.25rem; }

    /* Cards */
    .tsa-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        z-index: 10;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
    }
    .tsa-card-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .tsa-subject-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .tsa-subject-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }
    .tsa-subject-code {
        font-family: 'Courier New', Courier, monospace;
        color: var(--accent);
        font-size: 0.875rem;
        font-weight: 600;
        background: rgba(99,102,241,0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        margin-right: 0.5rem;
    }
    .tsa-course-badge {
        background: rgba(34,211,238,0.1);
        color: var(--cyan);
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        border: 1px solid rgba(34,211,238,0.2);
    }
    .tsa-subject-meta {
        display: flex;
        gap: 1.5rem;
        color: var(--text-dim);
        font-size: 0.875rem;
    }
    .tsa-meta-item { display: flex; align-items: center; gap: 0.5rem; }
    .tsa-meta-item svg { width: 16px; height: 16px; color: var(--text-dim); }
    
    .tsa-current-teacher {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .tsa-teacher-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--raised);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
    }
    .tsa-current-teacher-info span { display: block; }
    .tsa-current-teacher-name { color: var(--text); font-weight: 600; font-size: 0.875rem; }
    .tsa-current-teacher-email { color: var(--text-dim); font-size: 0.75rem; }

    /* Form */
    .tsa-form-card { max-width: 640px; }
    .tsa-form-group { margin-bottom: 1.5rem; }
    .tsa-label {
        display: block;
        color: var(--text);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .tsa-required { color: var(--rose); margin-left: 0.25rem; }
    
    .tsa-select {
        width: 100%;
        background: var(--raised);
        border: 1px solid var(--border);
        color: var(--text);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%237C8AA5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
    }
    .tsa-select:focus {
        outline: none;
        border-color: var(--cyan);
        box-shadow: 0 0 0 2px rgba(34,211,238,0.2);
    }
    
    .tsa-form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .tsa-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
    }
    .tsa-btn-primary {
        background: linear-gradient(135deg, var(--accent) 0%, var(--cyan) 100%);
        color: #fff;
    }
    .tsa-btn-primary:hover {
        box-shadow: 0 0 15px rgba(34,211,238,0.4);
        transform: translateY(-1px);
    }
    .tsa-btn-secondary {
        background: var(--raised);
        color: var(--text);
        border: 1px solid var(--border);
    }
    .tsa-btn-secondary:hover {
        background: rgba(255,255,255,0.05);
        color: var(--text);
    }
    
    /* Danger Zone */
    .tsa-danger-card {
        max-width: 640px;
        border-color: rgba(251, 113, 133, 0.3);
    }
    .tsa-danger-header {
        color: var(--rose);
        font-size: 1.125rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .tsa-danger-text {
        color: var(--text-dim);
        font-size: 0.875rem;
        margin: 0 0 1.5rem 0;
    }
    .tsa-btn-danger {
        background: rgba(251, 113, 133, 0.1);
        color: var(--rose);
        border: 1px solid rgba(251, 113, 133, 0.3);
    }
    .tsa-btn-danger:hover {
        background: var(--rose);
        color: #fff;
        box-shadow: 0 0 15px rgba(251, 113, 133, 0.4);
    }
</style>

<div class="tsa-wrap">
    <div class="tsa-ambient-orb tsa-orb-1"></div>
    <div class="tsa-ambient-orb tsa-orb-2"></div>
    
    <div class="tsa-header-content">
        <a href="{{ route('staff.teacher-subjects.index') }}" class="tsa-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Assignments
        </a>
        <h1 class="tsa-heading">Edit Teacher Assignment</h1>
        <p class="tsa-subtitle">Update the teacher assigned to this subject.</p>
    </div>

    @if(session('error'))
        <div class="tsa-alert tsa-alert-error">
            <span>{{ session('error') }}</span>
            <button type="button" class="tsa-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="tsa-validation-errors">
            <h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Please fix the following errors:
            </h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Subject Info Card -->
    <div class="tsa-card">
        <div class="tsa-card-info">
            <div class="tsa-subject-head">
                <div>
                    <h2 class="tsa-subject-title">
                        <span class="tsa-subject-code">{{ $subject->subject_code }}</span>
                        {{ $subject->title }}
                    </h2>
                </div>
                @if($subject->course)
                <div class="tsa-course-badge">
                    {{ $subject->course->title }}
                </div>
                @endif
            </div>
            
            <div class="tsa-subject-meta">
                <div class="tsa-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    {{ $subject->units }} Units
                </div>
                <div class="tsa-meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $subject->hours }} Hours
                </div>
            </div>

            @if($subject->teacher)
            <div class="tsa-current-teacher">
                <div class="tsa-teacher-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="tsa-current-teacher-info">
                    <span class="tsa-current-teacher-name">Currently assigned: {{ $subject->teacher->name }}</span>
                    <span class="tsa-current-teacher-email">{{ $subject->teacher->email }}</span>
                </div>
            </div>
            @else
            <div class="tsa-current-teacher">
                <div class="tsa-teacher-avatar" style="color: var(--text-dim)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="tsa-current-teacher-info">
                    <span class="tsa-current-teacher-name" style="color: var(--text-dim)">No teacher currently assigned.</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="tsa-card tsa-form-card">
        <form action="{{ route('staff.teacher-subjects.update', $subject) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="tsa-form-group">
                <label for="course_id" class="tsa-label">Class / Course</label>
                <select name="course_id" id="course_id" class="tsa-select">
                    <option value="">&mdash; Select a Class / Course &mdash;</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $subject->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="tsa-form-group">
                <label for="teacher_id" class="tsa-label">Assigned Teacher <span class="tsa-required">*</span></label>
                <select name="teacher_id" id="teacher_id" class="tsa-select" required>
                    <option value="">&mdash; Select a Teacher &mdash;</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }} ({{ $teacher->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="tsa-form-actions">
                <button type="submit" class="tsa-btn tsa-btn-primary">Update Assignment</button>
                <a href="{{ route('staff.teacher-subjects.index') }}" class="tsa-btn tsa-btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Danger Zone Card -->
    @if($subject->teacher_id)
    <div class="tsa-card tsa-danger-card">
        <h3 class="tsa-danger-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Danger Zone
        </h3>
        <p class="tsa-danger-text">
            Unassigning the teacher will remove their access to this subject immediately. You can reassign a teacher later if needed.
        </p>
        <form action="{{ route('staff.teacher-subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('Are you sure you want to unassign this teacher?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="tsa-btn tsa-btn-danger">Unassign Teacher</button>
        </form>
    </div>
    @endif
</div>
@endsection
