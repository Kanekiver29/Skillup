@extends('staff.layouts.masters')

@section('title', 'Assign Teacher')

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
        font-family: 'Inter', system-ui, sans-serif;
        min-height: 100vh;
        background-color: var(--bg);
        position: relative;
        overflow: hidden;
        padding: 2rem;
    }

    html[data-staff-theme="dark"] .tsa-wrap {
        --bg: #080D18;
        --surface: #0D1424;
        --raised: #111827;
        --border: rgba(99,102,241,0.18);
        --text: #E2E8F0;
        --text-dim: #7C8AA5;
    }

    .tsa-wrap * {
        box-sizing: border-box;
    }

    .tsa-wrap::before, .tsa-wrap::after {
        content: '';
        position: fixed;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        filter: blur(120px);
        z-index: 0;
        pointer-events: none;
        opacity: 0.15;
    }

    .tsa-wrap::before {
        top: -200px;
        left: -100px;
        background: var(--accent);
    }

    .tsa-wrap::after {
        bottom: -200px;
        right: -100px;
        background: var(--cyan);
    }

    .tsa-container {
        position: relative;
        z-index: 1;
        max-width: 640px;
        margin: 0 auto;
    }

    .tsa-back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-dim);
        text-decoration: none;
        font-size: 0.875rem;
        margin-bottom: 2rem;
        transition: color 0.2s ease;
    }

    .tsa-back-link:hover {
        color: var(--text);
    }

    .tsa-header {
        margin-bottom: 2rem;
    }

    .tsa-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        background: linear-gradient(135deg, var(--text) 0%, #A5B4FC 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: tsaFadeIn 0.8s ease-out;
    }

    .tsa-subtitle {
        color: var(--text-dim);
        margin: 0;
        font-size: 0.95rem;
    }

    .tsa-card {
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .tsa-form-group {
        margin-bottom: 1.5rem;
    }

    .tsa-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--text);
    }

    .tsa-label.required::after {
        content: '*';
        color: var(--rose);
        margin-left: 0.25rem;
    }

    .tsa-select {
        width: 100%;
        background-color: var(--raised);
        border: 1px solid var(--border);
        color: var(--text);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%237C8AA5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.2rem;
    }

    .tsa-select:focus {
        outline: none;
        border-color: var(--cyan);
        box-shadow: 0 0 0 3px rgba(34,211,238,0.1);
    }

    .tsa-select.is-invalid {
        border-color: var(--rose);
    }

    .tsa-select.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(251,113,133,0.1);
    }

    .tsa-select option, .tsa-select optgroup {
        background-color: var(--raised);
        color: var(--text);
    }

    .tsa-error-msg {
        color: var(--rose);
        font-size: 0.8rem;
        margin-top: 0.5rem;
        display: block;
    }

    .tsa-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .tsa-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
    }

    .tsa-btn-submit {
        background: linear-gradient(135deg, var(--accent) 0%, var(--cyan) 100%);
        color: white;
        flex: 1;
        position: relative;
        overflow: hidden;
    }

    .tsa-btn-submit::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .tsa-btn-submit:hover {
        box-shadow: 0 4px 15px rgba(99,102,241,0.4);
    }

    .tsa-btn-submit:hover::after {
        left: 100%;
    }

    .tsa-btn-cancel {
        background-color: transparent;
        color: var(--text-dim);
        border: 1px solid var(--border);
    }

    .tsa-btn-cancel:hover {
        background-color: var(--raised);
        color: var(--text);
    }

    .tsa-alert {
        background-color: rgba(251,113,133,0.1);
        border: 1px solid rgba(251,113,133,0.2);
        color: var(--rose);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .tsa-alert-icon {
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .tsa-alert-content {
        flex: 1;
    }
    
    .tsa-alert-list {
        margin: 0.5rem 0 0 0;
        padding-left: 1.5rem;
        font-size: 0.875rem;
    }

    @keyframes tsaFadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="tsa-wrap">
    <div class="tsa-container">
        <a href="{{ route('staff.teacher-subjects.index') }}" class="tsa-back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Assignments
        </a>

        <div class="tsa-header">
            <h1 class="tsa-title">Assign Teacher to Subject</h1>
            <p class="tsa-subtitle">Select a subject and assign a teacher.</p>
        </div>

        @if($errors->any())
            <div class="tsa-alert">
                <div class="tsa-alert-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                </div>
                <div class="tsa-alert-content">
                    <strong>Please fix the following errors:</strong>
                    <ul class="tsa-alert-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="tsa-card">
            <form action="{{ route('staff.teacher-subjects.store') }}" method="POST">
                @csrf
                
                <div class="tsa-form-group">
                    <label class="tsa-label" for="course_id">Class / Course</label>
                    <select name="course_id" id="course_id" class="tsa-select @error('course_id') is-invalid @enderror">
                        <option value="">— Select a Class / Course —</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="tsa-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="tsa-form-group">
                    <label class="tsa-label required" for="subject_id">Subject</label>
                    <select name="subject_id" id="subject_id" class="tsa-select @error('subject_id') is-invalid @enderror" required>
                        <option value="">— Select a Subject —</option>

                        @foreach($subjects->groupBy('course_id') as $courseId => $courseSubjects)
                            @php
                                $course = $courses->firstWhere('id', $courseId);
                                $courseName = $course ? $course->title : 'Other Subjects';
                            @endphp
                            <optgroup data-course-id="{{ $courseId }}" label="{{ $courseName }}">
                                @foreach($courseSubjects as $subject)
                                    <option value="{{ $subject->id }}" data-course-id="{{ $courseId }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->subject_code }} — {{ $subject->title }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <span class="tsa-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="tsa-form-group">
                    <label class="tsa-label required" for="teacher_id">Teacher</label>
                    <select name="teacher_id" id="teacher_id" class="tsa-select @error('teacher_id') is-invalid @enderror" required>
                        <option value="">— Select a Teacher —</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }} ({{ $teacher->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <span class="tsa-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="tsa-actions">
                    <a href="{{ route('staff.teacher-subjects.index') }}" class="tsa-btn tsa-btn-cancel">Cancel</a>
                    <button type="submit" class="tsa-btn tsa-btn-submit">Assign Teacher</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const courseSelect = document.getElementById('course_id');
    const subjectSelect = document.getElementById('subject_id');

    if (courseSelect && subjectSelect) {
      const filterSubjects = () => {
        const selectedCourse = courseSelect.value;
        const options = Array.from(subjectSelect.querySelectorAll('option[data-course-id]'));

        subjectSelect.querySelectorAll('optgroup').forEach((group) => {
          const show = !selectedCourse || group.dataset.courseId === selectedCourse;
          group.hidden = !show;
        });

        let firstMatch = null;
        options.forEach((option) => {
          const matches = !selectedCourse || option.dataset.courseId === selectedCourse;
          option.hidden = !matches;
          if (matches && !firstMatch) firstMatch = option;
        });

        if (!selectedCourse) {
          subjectSelect.value = '{{ old('subject_id') ?: '' }}';
          return;
        }

        if (!subjectSelect.value || !subjectSelect.value.trim()) {
          if (firstMatch) {
            subjectSelect.value = firstMatch.value;
          }
        }
      };

      courseSelect.addEventListener('change', filterSubjects);
      filterSubjects();
    }
  });
</script>
@endsection
