@extends('sias.students.layout.master')

@section('title', 'Enrollment')
@section('page_title', 'Enrollment')

@section('content')
<style>
    /* ===== Tokens ===== */
    .enrollment-page, .enrollment-login {
        --ink:#0f172a; --sub:#475569; --muted:#64748b;
        --line:#e2e8f0; --bg-soft:#f8fafc;
        --accent:#fcd34d; --accent-bg:#fffbeb; --accent-ink:#7c2d12;
        --ease:cubic-bezier(.22,1,.36,1);
    }

    /* ===== One-shot entrance animations only (cheap: opacity + transform) ===== */
    @keyframes fadeUp   { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
    @keyframes fadeIn   { from { opacity:0; } to { opacity:1; } }
    @keyframes popIn    { from { opacity:0; transform:scale(.92); } to { opacity:1; transform:scale(1); } }

    .anim-in { opacity:0; animation:fadeUp .45s var(--ease) forwards; }
    .anim-in.row { animation:fadeIn .3s ease forwards; } /* rows fade only — cheapest, no transform reflow */

    /* ===== Login ===== */
    .enrollment-login { display:grid; gap:1.25rem; max-width:560px; margin:0 auto; }
    .enrollment-login h2 { margin:0; font-size:2rem; color:var(--ink); }
    .enrollment-login p { margin:0; color:var(--sub); line-height:1.6; }
    .enrollment-login form {
        display:grid; gap:1rem; margin-top:1rem; padding:1.5rem;
        border:1px solid var(--line); border-radius:20px; background:#fff;
        box-shadow:0 16px 36px rgba(15,23,42,.07);
    }
    .enrollment-login label { display:grid; gap:.4rem; }
    .enrollment-login label span { font-size:.8rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--ink); }
    .enrollment-login .input-group { position:relative; }
    .enrollment-login input {
        width:100%; padding:.9rem 1.1rem; border:1px solid #cbd5e1; border-radius:14px;
        background:var(--bg-soft); color:var(--ink); font-size:.98rem;
        transition:border-color .15s ease, background .15s ease;
    }
    .enrollment-login input:focus { outline:none; border-color:var(--ink); background:#fff; box-shadow:0 0 0 3px rgba(15,23,42,.06); }
    .enrollment-login .toggle-password {
        position:absolute; top:50%; right:.9rem; transform:translateY(-50%);
        border:none; background:none; color:var(--muted); cursor:pointer; font-size:1rem;
        transition:color .15s ease;
    }
    .enrollment-login .toggle-password:hover { color:var(--ink); }
    .enrollment-login .toggle-password.flip { animation:popIn .2s ease; }
    .enrollment-login .form-actions { display:flex; gap:.75rem; flex-wrap:wrap; justify-content:flex-end; }

    /* ===== Dashboard ===== */
    .enrollment-grid { display:grid; gap:1rem; }
    .enrollment-header { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; }
    .enrollment-summary { min-width:280px; flex:1; display:grid; gap:.6rem; }
    .enrollment-summary span { color:var(--sub); font-size:.95rem; }
    .enrollment-summary strong { color:var(--ink); }
    .enrollment-actions { display:flex; gap:.75rem; flex-wrap:wrap; }

    .enrollment-panel { display:grid; grid-template-columns:minmax(260px,1fr) minmax(360px,1.5fr); gap:1rem; }
    .enrollment-card {
        border-radius:16px; padding:1rem; background:#fff; border:1px solid var(--line);
        transition: border-color .15s ease;
    }
    .enrollment-card:hover { border-color:#cbd5e1; }
    .enrollment-card.validated { background:var(--accent-bg); border-color:var(--accent); }

    .card-title { margin:0; font-size:1.05rem; display:flex; align-items:center; gap:.4rem; flex-wrap:wrap; }
    .card-meta { margin:.3rem 0 0; color:var(--muted); font-size:.9rem; }
    .card-meta.validated { color:var(--accent-ink); }
    .tag-validated { color:#dc2626; font-weight:700; font-size:.82rem; letter-spacing:.02em; }

    .subject-actions { display:flex; gap:.5rem; flex-wrap:wrap; }
    .subject-actions .btn-black, .subject-actions .btn-white { min-width:88px; }

    .enrollment-table { width:100%; border-collapse:collapse; margin-top:.65rem; }
    .enrollment-table th, .enrollment-table td { padding:.75rem .5rem; font-size:.93rem; border-bottom:1px solid var(--line); text-align:left; }
    .enrollment-table th { color:#334155; font-weight:700; font-size:.82rem; }
    .enrollment-table tbody tr:last-child td { border-bottom:none; }
    .enrollment-table tbody tr { transition:background .12s ease; }
    .enrollment-table tbody tr:hover { background:rgba(15,23,42,.025); }
    .enrollment-card.validated .enrollment-table tbody tr:hover { background:rgba(252,211,77,.15); }

    .table-scroll { overflow-x:auto; }
    .section-footer { margin-top:1rem; text-align:right; }

    .pill-select {
        padding:.65rem .95rem; border-radius:999px; border:1px solid #d1d5db;
        background:#fff; color:var(--ink); cursor:pointer;
    }
    .pill-select:focus { outline:none; border-color:var(--ink); box-shadow:0 0 0 3px rgba(15,23,42,.06); }

    /* ===== Buttons — hover/active only, no idle motion ===== */
    .btn-black, .btn-white { transition: transform .12s ease, box-shadow .12s ease; }
    .btn-black:hover { transform:translateY(-1px); box-shadow:0 6px 16px -8px rgba(15,23,42,.5); }
    .btn-white:hover { transform:translateY(-1px); box-shadow:0 4px 12px -8px rgba(15,23,42,.25); }
    .btn-black:active, .btn-white:active { transform:translateY(0); }

    @media (max-width: 900px) {
        .enrollment-panel { grid-template-columns:1fr !important; }
    }
    @media (prefers-reduced-motion: reduce) {
        .enrollment-page *, .enrollment-login * { animation:none !important; transition:none !important; }
    }
</style>

<div class="page-card enrollment-page" style="max-width:100%;">
    @guest
        <div class="enrollment-login anim-in">
            <div>
                <h2>Student Enrollment / Login</h2>
                <p>Use your <strong>Student ID</strong> as username. The default password is <strong>0000</strong>.</p>
            </div>

            <form method="POST" action="{{ route('sias.student.enrollment') }}">
                @csrf
                <label>
                    <span>Student ID</span>
                    <input name="student_id" required class="form-input" placeholder="e.g. 20260001" autocomplete="username">
                </label>

                <label>
                    <span>Password</span>
                    <div class="input-group">
                        <input id="enrollmentPassword" name="password" type="password" value="0000" class="form-input" placeholder="0000" autocomplete="current-password">
                        <button type="button" id="passwordToggle" class="toggle-password" aria-label="Show password" aria-pressed="false">👁️</button>
                    </div>
                </label>

                <div class="form-actions">
                    <button type="submit" class="btn-black">Proceed</button>
                    <a href="{{ url('/') }}" class="btn-white">Back</a>
                </div>
            </form>
        </div>
    @else
        @php
            $enrollments = auth()->user()->enrollments()->with('course')->get();
            $preEnlisted = $enrollments->where('status', 'pending')->values();
            $validated = $enrollments->where('status', 'active')->values();
            $programCourse = $enrollments->first()?->course;
            $yearLevel = $enrollments->first()?->year_level ?? '4';
            // Safely resolve course fields that may be relationship objects
            $programCourseTitle = $programCourse ? (is_object($programCourse->title ?? null) ? ($programCourse->title->name ?? 'N/A') : ($programCourse->title ?? null)) : null;
            $programCourseCategory = $programCourse ? (is_object($programCourse->category ?? null) ? ($programCourse->category->name ?? 'BSIT Curriculum 2018') : ($programCourse->category ?? null)) : null;
        @endphp

        <div class="enrollment-grid">
            <div class="enrollment-header anim-in">
                <div class="enrollment-summary">
                    <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
                        <strong>Period</strong>
                        <select class="pill-select" aria-label="Enrollment period">
                            <option>First Semester SY 2026-2027 (26-1)</option>
                            <option>Second Semester SY 2026-2027 (26-2)</option>
                        </select>
                    </div>
                    <span><strong>Course:</strong> {{ $programCourseTitle ?? 'Bachelor of Science in Information Technology' }}</span>
                    <span>Curriculum: {{ $programCourseCategory ?? 'BSIT Curriculum 2018' }}, Year: {{ $yearLevel }}, Graduating: No, Finished: No</span>
                </div>

                <div class="enrollment-actions">
                    <button class="btn-black" type="button">Enrollment Data</button>
                    <button class="btn-white" type="button">Delete</button>
                </div>
            </div>

            <div class="enrollment-panel">
                <section class="enrollment-card anim-in" style="animation-delay:.05s;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;">
                        <div>
                            <h3 class="card-title">Pre-Enlisted Subjects</h3>
                            <p class="card-meta">Pending selection before validation.</p>
                        </div>
                        <div class="subject-actions">
                            <button class="btn-black" type="button">Auto</button>
                            <button class="btn-white" type="button">Select</button>
                            <button class="btn-white" type="button">Add</button>
                        </div>
                    </div>
                    <div class="table-scroll">
                        <table class="enrollment-table">
                            <thead>
                                <tr><th>Code</th><th>Description</th><th>Remark</th></tr>
                            </thead>
                            <tbody>
                                @forelse($preEnlisted as $enrollment)
                                    <tr class="anim-in row" style="animation-delay:{{ 0.05 + (min($loop->index, 8) * 0.03) }}s;">
                                        <td>{{ $enrollment->course?->slug ?? $enrollment->course?->id ?? '—' }}</td>
                                        <td>{{ Str::limit($enrollment->course?->title ?? 'Course name', 40) }}</td>
                                        <td style="color:var(--sub);">Pending</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" style="padding:1.1rem 0;color:var(--muted);">No pre-enlisted subjects yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="enrollment-card validated anim-in" style="animation-delay:.1s;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;">
                        <div>
                            <h3 class="card-title">Enrolled Subjects <span class="tag-validated">VALIDATED</span></h3>
                            <p class="card-meta validated">Verified and approved subjects.</p>
                        </div>
                        <div class="subject-actions">
                            <button class="btn-white" type="button">Delete</button>
                            <button class="btn-white" type="button">Delete All</button>
                        </div>
                    </div>
                    <div class="table-scroll">
                        <table class="enrollment-table">
                            <thead>
                                <tr><th>Code</th><th>Subject</th><th>Description</th><th>Units</th><th>TF</th><th>Lec</th><th>Lab</th><th>Schedule</th></tr>
                            </thead>
                            <tbody>
                                @forelse($validated as $enrollment)
                                    <tr class="anim-in row" style="animation-delay:{{ 0.05 + (min($loop->index, 8) * 0.03) }}s;">
                                        <td>{{ $enrollment->course?->slug ?? $enrollment->course?->id ?? '—' }}</td>
                                        <td>{{ $enrollment->course?->title ?? 'Course title' }}</td>
                                        <td style="color:var(--accent-ink);">{{ Str::limit($enrollment->course?->short_description ?? $enrollment->course?->description ?? '—', 60) }}</td>
                                        <td>3.0</td><td>3.0</td><td>2.0</td><td>1.0</td>
                                        <td style="color:var(--sub);">TBA</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" style="padding:1.1rem 0;color:var(--accent-ink);">No validated enrolled subjects available yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <div class="section-footer anim-in" style="animation-delay:.15s;">
                <button class="btn-black" type="button">Assess</button>
            </div>
        </div>
    @endguest
</div>

@guest
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggle = document.getElementById('passwordToggle');
            var input = document.getElementById('enrollmentPassword');
            if (!toggle || !input) return;
            toggle.addEventListener('click', function () {
                var type = input.type === 'password' ? 'text' : 'password';
                input.type = type;
                this.textContent = type === 'password' ? '👁️' : '🙈';
                this.setAttribute('aria-label', type === 'password' ? 'Show password' : 'Hide password');
                this.setAttribute('aria-pressed', String(type !== 'password'));
                this.classList.remove('flip');
                void this.offsetWidth;
                this.classList.add('flip');
            });
        });
    </script>
@endguest
@endsection