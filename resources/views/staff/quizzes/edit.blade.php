@extends('staff.layouts.masters')

@section('title', 'Edit Quiz')

@push('styles')
<style>
    * { --transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1); }
    
    /* ════════════════════════════════════════════════════════════════
       ANIMATIONS
    ════════════════════════════════════════════════════════════════ */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(24px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes glowPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.4); }
        50% { box-shadow: 0 0 0 12px rgba(14, 165, 233, 0); }
    }

    @keyframes floatIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes shimmer {
        0%, 100% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    @keyframes successCheck {
        0% { transform: scale(0) rotate(-45deg); }
        100% { transform: scale(1) rotate(0); }
    }

    @keyframes fieldFocus {
        0% { transform: translateY(-2px); }
        100% { transform: translateY(0); }
    }

    /* ════════════════════════════════════════════════════════════════
       CONTAINER & LAYOUT
    ════════════════════════════════════════════════════════════════ */
    .quiz-container {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f7ff 0%, #f5f3ff 50%, #eff6ff 100%);
        padding: 3rem 1rem;
    }

    .quiz-container::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(14, 165, 233, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(168, 85, 247, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    .quiz-content-wrapper {
        position: relative;
        z-index: 1;
        max-width: 56rem;
        margin: 0 auto;
    }

    /* ════════════════════════════════════════════════════════════════
       HEADER SECTION
    ════════════════════════════════════════════════════════════════ */
    .quiz-page-header {
        animation: fadeSlideUp 0.6s ease-out both;
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(14, 165, 233, 0.15);
        border-radius: 2rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(14, 165, 233, 0.08), 0 0 1px rgba(14, 165, 233, 0.1);
        position: relative;
        overflow: hidden;
    }

    .quiz-page-header::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(100px, -100px);
    }

    .quiz-page-header::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-80px, 80px);
    }

    .quiz-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        justify-content: space-between;
    }

    @media (min-width: 640px) {
        .quiz-header-content {
            flex-direction: row;
            align-items: center;
        }
    }

    .quiz-header-info {
        flex: 1;
    }

    .quiz-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #0ea5e9;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0.05) 100%);
        padding: 0.5rem 1rem;
        border-radius: 999px;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(14, 165, 233, 0.2);
        animation: slideDown 0.5s ease-out;
    }

    .quiz-pill::before {
        content: '';
        width: 6px;
        height: 6px;
        background: #0ea5e9;
        border-radius: 50%;
        animation: glowPulse 2s ease-in-out infinite;
    }

    .quiz-page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .quiz-page-header p {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .quiz-header-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        animation: slideDown 0.6s ease-out;
    }

    /* ════════════════════════════════════════════════════════════════
       ALERT STYLES
    ════════════════════════════════════════════════════════════════ */
    .quiz-alert {
        animation: slideDown 0.4s ease-out both;
        background: linear-gradient(135deg, rgba(254, 242, 242, 0.98) 0%, rgba(254, 226, 226, 0.95) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 1.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.1);
    }

    .quiz-alert-icon {
        display: flex;
        height: 2.75rem;
        width: 2.75rem;
        align-items: center;
        justify-content: center;
        border-radius: 1.25rem;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: #dc2626;
        font-size: 1.25rem;
        flex-shrink: 0;
        animation: slideDown 0.5s ease-out;
    }

    .quiz-alert-list {
        list-style: none;
        padding: 0;
        margin: 0.75rem 0 0 0;
    }

    .quiz-alert-list li {
        padding: 0.4rem 0;
        font-size: 0.85rem;
        color: #7f1d1d;
        animation: fadeIn 0.4s ease-out forwards;
    }

    .quiz-alert-list li:nth-child(1) { animation-delay: 0.1s; }
    .quiz-alert-list li:nth-child(2) { animation-delay: 0.2s; }
    .quiz-alert-list li:nth-child(3) { animation-delay: 0.3s; }

    /* ════════════════════════════════════════════════════════════════
       FORM CARD
    ════════════════════════════════════════════════════════════════ */
    .quiz-form-card {
        animation: fadeSlideUp 0.7s ease-out both;
        animation-delay: 0.1s;
        background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(255,255,255,0.95) 100%);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(14, 165, 233, 0.1);
        border-radius: 2rem;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(14, 165, 233, 0.1), 0 0 1px rgba(14, 165, 233, 0.1);
        position: relative;
        overflow: hidden;
    }

    .quiz-form-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(30px, -30px); }
    }

    .quiz-form-content {
        position: relative;
        z-index: 1;
    }

    /* ════════════════════════════════════════════════════════════════
       FORM FIELDS
    ════════════════════════════════════════════════════════════════ */
    .quiz-field {
        margin-bottom: 2rem;
        opacity: 0;
        animation: fadeSlideUp 0.5s ease-out forwards;
    }

    .quiz-field-group {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .quiz-field-group {
            grid-template-columns: 1fr 1fr;
        }
    }

    .quiz-label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
        transition: var(--transition);
        letter-spacing: 0.02em;
    }

    .quiz-label-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0.05) 100%);
        color: #0ea5e9;
        font-size: 0.75rem;
    }

    .quiz-field:focus-within .quiz-label {
        color: #0ea5e9;
        transform: translateX(2px);
    }

    .quiz-input,
    .quiz-select,
    .quiz-textarea {
        width: 100%;
        padding: 1rem 1.25rem;
        border-radius: 1.25rem;
        border: 2px solid #e2e8f0;
        background: linear-gradient(135deg, rgba(255,255,255,0.5) 0%, rgba(248,250,252,0.5) 100%);
        color: #1e293b;
        font-size: 0.95rem;
        font-family: inherit;
        transition: var(--transition);
        position: relative;
        z-index: 2;
    }

    .quiz-input::placeholder,
    .quiz-select::placeholder,
    .quiz-textarea::placeholder {
        color: #cbd5e1;
    }

    .quiz-input:hover,
    .quiz-select:hover,
    .quiz-textarea:hover {
        border-color: #bae6fd;
        background: linear-gradient(135deg, rgba(255,255,255,0.7) 0%, rgba(248,250,252,0.7) 100%);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.08);
    }

    .quiz-input:focus,
    .quiz-select:focus,
    .quiz-textarea:focus {
        outline: none;
        border-color: #0ea5e9;
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.9) 100%);
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15), 0 8px 24px rgba(14, 165, 233, 0.12);
        animation: fieldFocus 0.3s ease-out;
    }

    .quiz-input.has-error,
    .quiz-select.has-error,
    .quiz-textarea.has-error {
        border-color: #f87171;
        background: linear-gradient(135deg, rgba(254, 242, 242, 0.5) 0%, rgba(254, 226, 226, 0.5) 100%);
    }

    .quiz-input.has-error:focus,
    .quiz-select.has-error:focus,
    .quiz-textarea.has-error:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15), 0 8px 24px rgba(239, 68, 68, 0.1);
    }

    .quiz-textarea {
        min-height: 120px;
        resize: vertical;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ════════════════════════════════════════════════════════════════
       FIELD ERRORS
    ════════════════════════════════════════════════════════════════ */
    .quiz-error {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: #dc2626;
        opacity: 0;
        animation: fadeIn 0.3s ease-out forwards;
        animation-delay: 0.1s;
    }

    .quiz-error::before {
        content: '!';
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.2);
        font-size: 0.65rem;
        font-weight: 700;
    }

    /* ════════════════════════════════════════════════════════════════
       BUTTONS
    ════════════════════════════════════════════════════════════════ */
    .quiz-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
        padding: 0.95rem 1.75rem;
        border-radius: 1.25rem;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        text-decoration: none;
    }

    .quiz-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s ease-out, height 0.6s ease-out;
        z-index: 0;
    }

    .quiz-btn:active::before {
        width: 300px;
        height: 300px;
    }

    .quiz-btn > * {
        position: relative;
        z-index: 1;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3), 0 0 1px rgba(14, 165, 233, 0.5);
        border: 1px solid rgba(14, 165, 233, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(14, 165, 233, 0.4), 0 0 20px rgba(14, 165, 233, 0.2);
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    }

    .btn-primary:focus {
        outline: 2px solid #0ea5e9;
        outline-offset: 2px;
    }

    .btn-secondary {
        background: linear-gradient(135deg, rgba(226, 232, 240, 0.8) 0%, rgba(203, 213, 225, 0.8) 100%);
        color: #1e293b;
        border: 1px solid rgba(14, 165, 233, 0.15);
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, rgba(226, 232, 240, 0.9) 0%, rgba(203, 213, 225, 0.9) 100%);
        border-color: rgba(14, 165, 233, 0.25);
        box-shadow: 0 8px 24px rgba(14, 165, 233, 0.1);
    }

    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        padding: 0;
        border-radius: 0.75rem;
    }

    /* ════════════════════════════════════════════════════════════════
       FORM ACTIONS
    ════════════════════════════════════════════════════════════════ */
    .quiz-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(14, 165, 233, 0.1);
        animation: fadeIn 0.6s ease-out forwards;
        animation-delay: 0.5s;
    }

    /* ════════════════════════════════════════════════════════════════
       RESPONSIVE
    ════════════════════════════════════════════════════════════════ */
    @media (max-width: 640px) {
        .quiz-page-header {
            padding: 1.5rem;
        }

        .quiz-form-card {
            padding: 1.5rem;
        }

        .quiz-page-header h1 {
            font-size: 1.5rem;
        }

        .quiz-btn {
            width: 100%;
        }

        .quiz-actions {
            flex-direction: column;
        }

        .quiz-header-buttons {
            width: 100%;
        }

        .quiz-header-buttons .quiz-btn {
            width: 100%;
        }
    }

    /* ════════════════════════════════════════════════════════════════
       ANIMATIONS STAGGER
    ════════════════════════════════════════════════════════════════ */
    .quiz-field:nth-child(1) { animation-delay: 0.15s; }
    .quiz-field:nth-child(2) { animation-delay: 0.2s; }
    .quiz-field:nth-child(3) { animation-delay: 0.25s; }
    .quiz-field:nth-child(4) { animation-delay: 0.3s; }
    .quiz-field:nth-child(5) { animation-delay: 0.35s; }
    .quiz-field:nth-child(6) { animation-delay: 0.4s; }
</style>
@endpush

@section('content')
    <div class="quiz-container">
        <div class="quiz-content-wrapper">
            <!-- HEADER -->
            <div class="quiz-page-header">
                <div class="quiz-header-content">
                    <div class="quiz-header-info">
                        <div class="quiz-pill">
                            <i class="fas fa-pen-to-square"></i>
                            Quiz Management System
                        </div>
                        <h1>Edit Quiz Details</h1>
                        <p>Refine your quiz configuration, set scoring criteria, and manage time limits before publishing to learners.</p>
                    </div>
                    <div class="quiz-header-buttons">
                        <a href="{{ route('staff.quizzes.questionnaire', $quiz) }}" class="quiz-btn btn-primary" title="Edit quiz questions and answers">
                            <i class="fas fa-list-check" aria-hidden="true"></i>
                            <span>Questions</span>
                        </a>
                        <a href="{{ route('staff.quizzes.list') }}" class="quiz-btn btn-secondary" title="Return to quiz list">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ALERTS -->
            @if ($errors->any())
                <div class="quiz-alert">
                    <div class="flex items-start gap-3">
                        <div class="quiz-alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-rose-900">Validation Failed</p>
                            <p class="text-sm text-rose-700 mt-1">Please review and correct the highlighted fields below.</p>
                            <ul class="quiz-alert-list">
                                @foreach ($errors->all() as $error)
                                    <li><span class="inline-block mr-2">→</span>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- FORM CARD -->
            <div class="quiz-form-card">
                <div class="quiz-form-content">
                    <form method="POST" action="{{ route('staff.quizzes.update', $quiz) }}" novalidate id="quiz-edit-form">
                        @csrf
                        @method('PUT')

                        <!-- COURSE & MODULE ROW -->
                        <div class="quiz-field-group">
                            <div class="quiz-field">
                                <label class="quiz-label">
                                    <span class="quiz-label-icon">
                                        <i class="fas fa-book"></i>
                                    </span>
                                    Course
                                </label>
                                <select name="course_id" required class="quiz-select {{ $errors->has('course_id') ? 'has-error' : '' }}" aria-label="Select course">
                                    <option value="">Select a course...</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', optional($quiz->module)->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="quiz-error">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="quiz-field">
                                <label class="quiz-label">
                                    <span class="quiz-label-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </span>
                                    Module
                                </label>
                                <select name="module_id" required class="quiz-select {{ $errors->has('module_id') ? 'has-error' : '' }}" aria-label="Select module">
                                    <option value="">Select a module...</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" {{ old('module_id', $quiz->module_id) == $module->id ? 'selected' : '' }}>
                                            {{ $module->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('module_id')
                                    <div class="quiz-error">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- TITLE FIELD -->
                        <div class="quiz-field">
                            <label class="quiz-label">
                                <span class="quiz-label-icon">
                                    <i class="fas fa-heading"></i>
                                </span>
                                Quiz Title
                            </label>
                            <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required class="quiz-input {{ $errors->has('title') ? 'has-error' : '' }}" placeholder="e.g. Advanced Module Assessment" aria-label="Quiz title">
                            @error('title')
                                <div class="quiz-error">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- DESCRIPTION FIELD -->
                        <div class="quiz-field">
                            <label class="quiz-label">
                                <span class="quiz-label-icon">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                Description
                            </label>
                            <textarea name="description" class="quiz-textarea {{ $errors->has('description') ? 'has-error' : '' }}" placeholder="Provide clear instructions and context for learners..." aria-label="Quiz description">{{ old('description', $quiz->description) }}</textarea>
                            <p class="text-xs text-slate-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                This helps learners understand what to expect
                            </p>
                            @error('description')
                                <div class="quiz-error">
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- SCORING & TIME ROW -->
                        <div class="quiz-field-group">
                            <div class="quiz-field">
                                <label class="quiz-label">
                                    <span class="quiz-label-icon">
                                        <i class="fas fa-percent"></i>
                                    </span>
                                    Passing Score
                                </label>
                                <div class="relative">
                                    <input type="number" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" min="0" max="100" required class="quiz-input {{ $errors->has('passing_score') ? 'has-error' : '' }}" placeholder="70" aria-label="Passing score percentage">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-semibold pointer-events-none">%</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">
                                    Minimum percentage needed to pass
                                </p>
                                @error('passing_score')
                                    <div class="quiz-error">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="quiz-field">
                                <label class="quiz-label">
                                    <span class="quiz-label-icon">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    Time Limit
                                </label>
                                <div class="relative">
                                    <input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}" min="0" class="quiz-input {{ $errors->has('time_limit_minutes') ? 'has-error' : '' }}" placeholder="Leave empty for no limit" aria-label="Time limit in minutes">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-semibold pointer-events-none">min</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">
                                    Leave blank for unlimited time
                                </p>
                                @error('time_limit_minutes')
                                    <div class="quiz-error">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- ACTIONS -->
                        <div class="quiz-actions">
                            <button type="submit" class="quiz-btn btn-primary" id="submit-btn">
                                <i class="fas fa-check-circle" aria-hidden="true"></i>
                                <span>Save Changes</span>
                            </button>
                            <a href="{{ route('staff.quizzes.list') }}" class="quiz-btn btn-secondary">
                                <i class="fas fa-times" aria-hidden="true"></i>
                                <span>Cancel</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';

    // ═══════════════════════════════════════════════════════════════════════
    // FORM STATE TRACKING & INTERACTIONS
    // ═══════════════════════════════════════════════════════════════════════
    const form = document.getElementById('quiz-edit-form');
    const submitBtn = document.getElementById('submit-btn');
    const inputs = form.querySelectorAll('input, select, textarea');
    let formDirty = false;
    let isSubmitting = false;

    // Track form changes
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            formDirty = true;
            enhanceFieldAnimation(input);
        });

        input.addEventListener('change', () => {
            formDirty = true;
            enhanceFieldAnimation(input);
        });

        input.addEventListener('focus', (e) => {
            const field = e.target.closest('.quiz-field');
            if (field) {
                field.style.transform = 'scale(1.01)';
            }
        });

        input.addEventListener('blur', (e) => {
            const field = e.target.closest('.quiz-field');
            if (field) {
                field.style.transform = 'scale(1)';
            }
        });
    });

    // ═══════════════════════════════════════════════════════════════════════
    // FIELD ENHANCEMENT ANIMATIONS
    // ═══════════════════════════════════════════════════════════════════════
    function enhanceFieldAnimation(element) {
        const field = element.closest('.quiz-field');
        if (!field) return;

        const label = field.querySelector('.quiz-label');
        if (label && element.value.trim()) {
            label.style.transform = 'translateY(-2px)';
            label.style.color = '#0ea5e9';
        } else if (label) {
            label.style.transform = 'translateY(0)';
            label.style.color = '';
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // FORM SUBMISSION WITH VISUAL FEEDBACK
    // ═══════════════════════════════════════════════════════════════════════
    form.addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return;
        }

        isSubmitting = true;
        
        // Disable submit button
        submitBtn.disabled = true;
        const originalHTML = submitBtn.innerHTML;
        
        // Add loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Saving...</span>';
        submitBtn.style.opacity = '0.8';
        
        // Disable all inputs
        inputs.forEach(input => input.disabled = true);

        // Simulate additional processing (safety timeout)
        const timeout = setTimeout(() => {
            form.submit();
        }, 300);

        // On error, restore state
        window.addEventListener('error', () => {
            clearTimeout(timeout);
            isSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
            submitBtn.style.opacity = '1';
            inputs.forEach(input => input.disabled = false);
        });
    });

    // ═══════════════════════════════════════════════════════════════════════
    // PASSING SCORE SYNC (if range input exists)
    // ═══════════════════════════════════════════════════════════════════════
    const passingScoreInput = form.querySelector('input[name="passing_score"]');
    if (passingScoreInput) {
        passingScoreInput.addEventListener('input', function() {
            const value = Math.min(100, Math.max(0, parseInt(this.value) || 0));
            this.value = value;
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // INITIAL FIELD SETUP
    // ═══════════════════════════════════════════════════════════════════════
    inputs.forEach(input => {
        enhanceFieldAnimation(input);
    });

    // ═══════════════════════════════════════════════════════════════════════
    // KEYBOARD SHORTCUTS
    // ═══════════════════════════════════════════════════════════════════════
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            if (!isSubmitting && formDirty) {
                form.submit();
            }
        }

        // Escape to cancel
        if (e.key === 'Escape' && formDirty) {
            if (confirm('Discard unsaved changes?')) {
                window.history.back();
            }
        }
    });

    // ═══════════════════════════════════════════════════════════════════════
    // UNSAVED CHANGES WARNING
    // ═══════════════════════════════════════════════════════════════════════
    window.addEventListener('beforeunload', function(e) {
        if (formDirty && !isSubmitting) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // ═══════════════════════════════════════════════════════════════════════
    // SMOOTH FIELD INTERACTIONS & TOOLTIPS
    // ═══════════════════════════════════════════════════════════════════════
    const fields = form.querySelectorAll('.quiz-field');
    fields.forEach((field, index) => {
        const input = field.querySelector('input, select, textarea');
        
        // Add hover effect
        field.addEventListener('mouseenter', function() {
            if (document.activeElement !== input) {
                this.style.transform = 'translateY(-2px)';
                this.style.opacity = '1';
            }
        });

        field.addEventListener('mouseleave', function() {
            if (document.activeElement !== input) {
                this.style.transform = 'translateY(0)';
            }
        });

        // Character counter for textarea
        if (input && input.tagName === 'TEXTAREA') {
            const maxLength = input.getAttribute('maxlength') || '5000';
            
            input.addEventListener('input', function() {
                const length = this.value.length;
                const percent = (length / maxLength) * 100;
                
                // Change color if near limit
                if (percent > 90) {
                    this.style.borderColor = '#fbbf24';
                } else if (percent > 100) {
                    this.style.borderColor = '#f87171';
                } else {
                    this.style.borderColor = '';
                }
            });
        }
    });

    // ═══════════════════════════════════════════════════════════════════════
    // FORM VALIDATION ENHANCEMENT
    // ═══════════════════════════════════════════════════════════════════════
    function validateField(field) {
        const input = field.querySelector('input, select, textarea');
        if (!input) return true;

        let isValid = true;
        const value = input.value.trim();

        // Required field check
        if (input.hasAttribute('required') && !value) {
            isValid = false;
            input.classList.add('has-error');
        } else {
            input.classList.remove('has-error');
        }

        // Number validation
        if (input.type === 'number') {
            const num = parseInt(value);
            const min = input.min ? parseInt(input.min) : -Infinity;
            const max = input.max ? parseInt(input.max) : Infinity;
            
            if (!isNaN(num) && (num < min || num > max)) {
                isValid = false;
                input.classList.add('has-error');
            }
        }

        return isValid;
    }

    // Validate on blur
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            const field = this.closest('.quiz-field');
            if (field) {
                validateField(field);
            }
        });
    });

    // ═══════════════════════════════════════════════════════════════════════
    // ACCESSIBILITY ENHANCEMENTS
    // ═══════════════════════════════════════════════════════════════════════
    
    // Add ARIA attributes for better accessibility
    form.setAttribute('novalidate', 'novalidate');
    
    // Focus management for error alerts
    const errorAlert = document.querySelector('.quiz-alert');
    if (errorAlert) {
        errorAlert.setAttribute('role', 'alert');
        errorAlert.setAttribute('tabindex', '-1');
        // Scroll to first error
        const firstError = form.querySelector('.has-error');
        if (firstError) {
            setTimeout(() => {
                firstError.focus();
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 200);
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // THROTTLE FUNCTION FOR PERFORMANCE
    // ═══════════════════════════════════════════════════════════════════════
    function throttle(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Apply throttling to input handlers
    const throttledEnhance = throttle(function(element) {
        enhanceFieldAnimation(element);
    }, 100);

    console.log('✓ Quiz edit form enhanced with futuristic interactions');
})();
</script>
@endpush
