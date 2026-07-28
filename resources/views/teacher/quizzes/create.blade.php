@extends('teacher.layouts.master')

@section('title', 'Create Quiz')
@section('page_title', 'Create Quiz')

@section('content')

<style>
    /* ── Reset & Base ───────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .qc-wrap {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 2.5rem 1rem 4rem;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    /* ── Card ───────────────────────────────────── */
    .qc-card {
        width: 100%;
        max-width: 680px;
        background: #ffffff;
        border-radius: 1.5rem;
        box-shadow:
            0 0 0 1px rgba(99,102,241,.10),
            0 4px 6px -2px rgba(15,23,41,.06),
            0 20px 60px -10px rgba(99,102,241,.12);
        overflow: hidden;
        animation: cardRise 0.55s cubic-bezier(.22,.68,0,1.2) both;
    }

    @keyframes cardRise {
        from { opacity: 0; transform: translateY(32px) scale(.97); }
        to   { opacity: 1; transform: translateY(0)  scale(1);    }
    }

    /* ── Header Banner ──────────────────────────── */
    .qc-header {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 60%, #A855F7 100%);
        padding: 2rem 2rem 1.6rem;
        position: relative;
        overflow: hidden;
    }

    .qc-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        background-size: 60px 60px;
        animation: patternDrift 18s linear infinite;
    }

    @keyframes patternDrift {
        from { background-position: 0 0;   }
        to   { background-position: 60px 60px; }
    }

    .qc-header-icon {
        width: 3rem;
        height: 3rem;
        background: rgba(255,255,255,.18);
        border-radius: .9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        position: relative;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,.25);
        animation: iconPop .55s .25s cubic-bezier(.22,.68,0,1.35) both;
    }

    @keyframes iconPop {
        from { opacity: 0; transform: scale(.5); }
        to   { opacity: 1; transform: scale(1);  }
    }

    .qc-header-icon svg {
        width: 1.4rem;
        height: 1.4rem;
        color: #fff;
    }

    .qc-header h2 {
        font-size: 1.45rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: -.02em;
        position: relative;
    }

    .qc-header p {
        margin-top: .35rem;
        font-size: .875rem;
        color: rgba(255,255,255,.72);
        position: relative;
    }

    /* ── Step Dots ──────────────────────────────── */
    .qc-steps {
        display: flex;
        gap: .5rem;
        margin-top: 1.4rem;
        position: relative;
    }

    .qc-step-dot {
        height: 4px;
        border-radius: 2px;
        background: rgba(255,255,255,.25);
        flex: 1;
        transition: background .4s ease;
    }

    .qc-step-dot.active {
        background: #fff;
        box-shadow: 0 0 8px rgba(255,255,255,.6);
    }

    /* ── Form Body ──────────────────────────────── */
    .qc-body {
        padding: 2rem;
        display: grid;
        gap: 1.4rem;
    }

    /* ── Section Label ──────────────────────────── */
    .qc-section-label {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #6366F1;
        margin-bottom: -.4rem;
    }

    .qc-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, rgba(99,102,241,.25), transparent);
    }

    /* ── Field Groups ───────────────────────────── */
    .qc-field {
        display: flex;
        flex-direction: column;
        gap: .4rem;
        animation: fieldSlide .45s both;
    }

    .qc-field:nth-child(1)  { animation-delay: .07s; }
    .qc-field:nth-child(2)  { animation-delay: .12s; }
    .qc-field:nth-child(3)  { animation-delay: .17s; }
    .qc-field:nth-child(4)  { animation-delay: .22s; }
    .qc-field:nth-child(5)  { animation-delay: .27s; }
    .qc-field:nth-child(6)  { animation-delay: .32s; }
    .qc-field:nth-child(7)  { animation-delay: .37s; }
    .qc-field:nth-child(8)  { animation-delay: .42s; }

    @keyframes fieldSlide {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0);    }
    }

    /* ── Labels ─────────────────────────────────── */
    .qc-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .825rem;
        font-weight: 600;
        color: #1e293b;
        letter-spacing: -.01em;
    }

    .qc-label svg {
        width: .9rem;
        height: .9rem;
        color: #6366F1;
        flex-shrink: 0;
    }

    .qc-label .qc-required {
        color: #EF4444;
        font-size: .75rem;
        margin-left: auto;
        font-weight: 500;
    }

    /* ── Inputs / Select / Textarea ─────────────── */
    .qc-input,
    .qc-select,
    .qc-textarea {
        width: 100%;
        padding: .75rem 1rem;
        font-size: .9rem;
        font-family: inherit;
        color: #1e293b;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: .85rem;
        outline: none;
        transition:
            border-color .2s ease,
            background   .2s ease,
            box-shadow   .25s ease,
            transform    .15s ease;
        appearance: none;
        -webkit-appearance: none;
    }

    .qc-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236366F1' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .85rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }

    .qc-input:hover,
    .qc-select:hover,
    .qc-textarea:hover {
        border-color: #a5b4fc;
        background: #fff;
    }

    .qc-input:focus,
    .qc-select:focus,
    .qc-textarea:focus {
        border-color: #6366F1;
        background: #fff;
        box-shadow:
            0 0 0 3px rgba(99,102,241,.12),
            0 1px 4px rgba(99,102,241,.10);
        transform: translateY(-1px);
    }

    .qc-textarea {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    /* ── Two-column row ─────────────────────────── */
    .qc-row-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    /* ── Number input hint ──────────────────────── */
    .qc-hint {
        font-size: .75rem;
        color: #94a3b8;
        margin-top: .15rem;
    }

    /* ── Divider ────────────────────────────────── */
    .qc-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        margin: .2rem 0;
    }

    /* ── Actions ────────────────────────────────── */
    .qc-actions {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        align-items: center;
        padding-top: .25rem;
    }

    /* ── Primary Button ─────────────────────────── */
    .qc-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .75rem 1.6rem;
        font-size: .9rem;
        font-weight: 600;
        font-family: inherit;
        color: #fff;
        background: linear-gradient(135deg, #6366F1 0%, #7C3AED 100%);
        border: none;
        border-radius: .85rem;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition:
            transform .2s ease,
            box-shadow .2s ease;
        box-shadow: 0 4px 14px rgba(99,102,241,.38);
    }

    .qc-btn-primary::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.25), transparent);
        transform: skewX(-15deg);
        transition: left .5s ease;
    }

    .qc-btn-primary:hover::before { left: 160%; }

    .qc-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(99,102,241,.45);
    }

    .qc-btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(99,102,241,.35);
    }

    .qc-btn-primary svg {
        width: .95rem;
        height: .95rem;
        transition: transform .2s ease;
    }

    .qc-btn-primary:hover svg { transform: translateX(2px); }

    /* ── Secondary Button ───────────────────────── */
    .qc-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .75rem 1.4rem;
        font-size: .9rem;
        font-weight: 600;
        font-family: inherit;
        color: #64748b;
        background: #f1f5f9;
        border: 1.5px solid #e2e8f0;
        border-radius: .85rem;
        text-decoration: none;
        transition:
            background .2s ease,
            border-color .2s ease,
            color .2s ease,
            transform .2s ease;
    }

    .qc-btn-secondary:hover {
        background: #e8edf5;
        border-color: #cbd5e1;
        color: #475569;
        transform: translateY(-1px);
    }

    /* ── Error messages ─────────────────────────── */
    .qc-error {
        font-size: .78rem;
        color: #ef4444;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* ── Reduced motion ─────────────────────────── */
    @media (prefers-reduced-motion: reduce) {
        .qc-card,
        .qc-header-icon,
        .qc-field,
        .qc-header::before { animation: none !important; }
        .qc-input:focus,
        .qc-select:focus,
        .qc-textarea:focus { transform: none !important; }
        .qc-btn-primary:hover,
        .qc-btn-secondary:hover { transform: none !important; }
    }
</style>

<div class="qc-wrap">
    <div class="qc-card">

        {{-- ── Header ── --}}
        <div class="qc-header">
            <div class="qc-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                             a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19
                             a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2>Create a new quiz</h2>
            <p>Fill in the details below and assign the quiz to a module.</p>
            <div class="qc-steps" id="qcSteps">
                <div class="qc-step-dot active" data-step="0"></div>
                <div class="qc-step-dot" data-step="1"></div>
                <div class="qc-step-dot" data-step="2"></div>
            </div>
        </div>

        {{-- ── Form ── --}}
        <form method="POST" action="{{ route('teacher.quizzes.store') }}" id="qcForm"
              novalidate>
            @csrf

            <div class="qc-body">

                {{-- Section: Assignment --}}
                <div class="qc-section-label">Assignment</div>

                {{-- Course --}}
                <div class="qc-field">
                    <label class="qc-label" for="qc_course">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168
                                     5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477
                                     4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0
                                     3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5
                                     18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Course
                        <span class="qc-required">Required</span>
                    </label>
                    <select id="qc_course" name="course_id" required class="qc-select"
                            data-section="0">
                        <option value="">Select a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="qc-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7
                                         4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0
                                         00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Module --}}
                <div class="qc-field">
                    <label class="qc-label" for="qc_module">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2
                                     2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14
                                     0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0
                                     0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Module
                        <span class="qc-required">Required</span>
                    </label>
                    <select id="qc_module" name="module_id" required class="qc-select"
                            data-section="0">
                        <option value="">Select a module</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}"
                                {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                {{ $module->title }}
                                ({{ $module->course->title ?? 'No course' }})
                            </option>
                        @endforeach
                    </select>
                    @error('module_id')
                        <span class="qc-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7
                                         4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0
                                         00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="qc-divider"></div>
                {{-- Section: Details --}}
                <div class="qc-section-label">Quiz details</div>

                {{-- Title --}}
                <div class="qc-field">
                    <label class="qc-label" for="qc_title">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2
                                     0 002-2v-5m-1.414-9.414a2 2 0 112.828
                                     2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Quiz title
                        <span class="qc-required">Required</span>
                    </label>
                    <input type="text" id="qc_title" name="title"
                           value="{{ old('title') }}"
                           placeholder="e.g. Unit 3 Comprehension Check"
                           required
                           class="qc-input"
                           data-section="1">
                    @error('title')
                        <span class="qc-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7
                                         4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0
                                         00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="qc-field">
                    <label class="qc-label" for="qc_description">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4 6h16M4 12h12M4 18h8"/>
                        </svg>
                        Description
                    </label>
                    <textarea id="qc_description" name="description"
                              rows="4"
                              placeholder="Briefly describe what this quiz covers…"
                              class="qc-textarea"
                              data-section="1">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="qc-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7
                                         4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0
                                         00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="qc-divider"></div>
                {{-- Section: Settings --}}
                <div class="qc-section-label">Settings</div>

                {{-- Passing score + Time limit --}}
                <div class="qc-row-2">
                    <div class="qc-field">
                        <label class="qc-label" for="qc_passing">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2
                                         2v6a2 2 0 002 2h2a2 2 0 002-2zm0
                                         0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6
                                         0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2
                                         2 0 012-2h2a2 2 0 012 2v14a2 2 0
                                         01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Passing score
                        </label>
                        <input type="number" id="qc_passing" name="passing_score"
                               min="0" max="100"
                               value="{{ old('passing_score', 70) }}"
                               class="qc-input"
                               data-section="2">
                        <span class="qc-hint">Enter a value between 0 – 100%</span>
                        @error('passing_score')
                            <span class="qc-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="qc-field">
                        <label class="qc-label" for="qc_time">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Time limit
                        </label>
                        <input type="number" id="qc_time" name="time_limit_minutes"
                               min="0"
                               value="{{ old('time_limit_minutes') }}"
                               placeholder="No limit"
                               class="qc-input"
                               data-section="2">
                        <span class="qc-hint">Leave blank for unlimited time</span>
                        @error('time_limit_minutes')
                            <span class="qc-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="qc-actions">
                    <button type="submit" class="qc-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Create quiz
                    </button>
                    <a href="{{ route('teacher.quizzes.index') }}" class="qc-btn-secondary">
                        Cancel
                    </a>
                </div>

            </div>{{-- /qc-body --}}
        </form>

    </div>{{-- /qc-card --}}
</div>

<script>
(function () {
    'use strict';

    /* ── Progress dots: light up based on which section has input ── */
    const dots   = document.querySelectorAll('.qc-step-dot');
    const fields = document.querySelectorAll('[data-section]');

    function updateDots () {
        const filled = new Set();
        fields.forEach(function (el) {
            if (el.value && el.value.trim() !== '') {
                filled.add(Number(el.dataset.section));
            }
        });

        dots.forEach(function (dot, i) {
            if (filled.has(i)) {
                dot.classList.add('active');
            } else if (i === 0 && filled.size === 0) {
                dot.classList.add('active');      // first dot always on
            } else {
                dot.classList.remove('active');
            }
        });

        // always keep dot 0 lit
        dots[0].classList.add('active');
    }

    fields.forEach(function (el) {
        el.addEventListener('input',  updateDots);
        el.addEventListener('change', updateDots);
    });

    updateDots();

    /* ── Submit: button loading state ── */
    var form = document.getElementById('qcForm');
    form.addEventListener('submit', function () {
        var btn = form.querySelector('.qc-btn-primary');
        btn.disabled = true;
        btn.innerHTML =
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" ' +
            '     viewBox="0 0 24 24" fill="none" stroke="currentColor" ' +
            '     stroke-width="2.5" style="animation:spin .7s linear infinite">' +
            '  <path stroke-linecap="round" stroke-linejoin="round" ' +
            '        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 ' +
            '           0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 ' +
            '           2H15"/>' +
            '</svg>' +
            'Creating…';
    });
})();
</script>

<style>
    @keyframes spin {
        from { transform: rotate(0deg);   }
        to   { transform: rotate(360deg); }
    }
</style>

@endsection