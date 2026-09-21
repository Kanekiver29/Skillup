@extends('staff.layouts.masters')
@section('title', 'Daily Reports')

@push('styles')
<style>
    /* ─── Design Tokens ──────────────────────────────────────────────── */
    :root {
        --ink:      var(--text);
        --ink-soft: var(--muted);
        --ink-faint: var(--muted);
        --canvas:   var(--body-bg);
        --white:    var(--surface);
        --accent:   #2563eb;        /* electric blue — authority/data */
        --accent-lt:#dbeafe;
        --success:  #059669;
        --success-lt:#d1fae5;
        --danger:   #dc2626;
        --danger-lt:#fee2e2;
        --warn:     #d97706;
        --warn-lt:  #fef3c7;
        --border:   #e2e8f0;
        --radius:   12px;
        --radius-sm:8px;
        --shadow:   0 1px 3px rgba(15,25,35,.06), 0 4px 16px rgba(15,25,35,.06);
        --shadow-lg:0 8px 32px rgba(15,25,35,.12);
        --transition:220ms cubic-bezier(.4,0,.2,1);
    }

    /* ─── Base ───────────────────────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; }

    .dr-wrapper {
        font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        background: var(--canvas);
        min-height: 100vh;
        padding: 32px 24px 64px;
        color: var(--ink);
    }

    /* ─── Page Header ────────────────────────────────────────────────── */
    .dr-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 32px;
        animation: fadeSlideDown .4s ease both;
    }
    .dr-header__eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 6px;
    }
    .dr-header h1 {
        font-size: clamp(22px,3vw,30px);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -.02em;
        margin: 0 0 6px;
    }
    .dr-header p {
        font-size: 13px;
        color: var(--ink-soft);
        margin: 0;
    }
    .dr-header__actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-shrink: 0;
    }
    .dr-date-badge {
        font-size: 12px;
        font-weight: 600;
        color: var(--ink-soft);
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 6px 14px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .dr-date-badge svg { flex-shrink: 0; }

    /* ─── Buttons ────────────────────────────────────────────────────── */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 999px;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        white-space: nowrap;
    }
    .btn--primary {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 2px 8px rgba(37,99,235,.35);
    }
    .btn--primary:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 16px rgba(37,99,235,.4);
        transform: translateY(-1px);
    }
    .btn--primary:active { transform: translateY(0); }
    .btn--ghost {
        background: var(--white);
        color: var(--ink);
        border: 1px solid var(--border);
    }
    .btn--ghost:hover {
        background: var(--canvas);
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    /* ─── Stat Cards (top row) ───────────────────────────────────────── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: var(--white);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        padding: 20px 22px;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        animation: fadeSlideUp .5s ease both;
    }
    .stat-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }
    .stat-card__accent-bar {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: var(--radius) var(--radius) 0 0;
    }
    .stat-card__icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px;
        font-size: 18px;
    }
    .stat-card__label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--ink-faint);
        margin-bottom: 4px;
    }
    .stat-card__value {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -.04em;
        line-height: 1;
        color: var(--ink);
    }
    .stat-card__sub {
        font-size: 11px;
        color: var(--ink-faint);
        margin-top: 4px;
    }

    /* Color variants */
    .stat-card--blue  .stat-card__accent-bar { background: var(--accent); }
    .stat-card--blue  .stat-card__icon { background: var(--accent-lt); color: var(--accent); }
    .stat-card--green .stat-card__accent-bar { background: var(--success); }
    .stat-card--green .stat-card__icon { background: var(--success-lt); color: var(--success); }
    .stat-card--red   .stat-card__accent-bar { background: var(--danger); }
    .stat-card--red   .stat-card__icon { background: var(--danger-lt); color: var(--danger); }
    .stat-card--warn  .stat-card__accent-bar { background: var(--warn); }
    .stat-card--warn  .stat-card__icon { background: var(--warn-lt); color: var(--warn); }

    /* stagger delay */
    .stat-grid .stat-card:nth-child(1) { animation-delay:.05s }
    .stat-grid .stat-card:nth-child(2) { animation-delay:.10s }
    .stat-grid .stat-card:nth-child(3) { animation-delay:.15s }
    .stat-grid .stat-card:nth-child(4) { animation-delay:.20s }
    .stat-grid .stat-card:nth-child(5) { animation-delay:.25s }
    .stat-grid .stat-card:nth-child(6) { animation-delay:.30s }

    /* ─── Section Card ───────────────────────────────────────────────── */
    .section-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: var(--transition);
        animation: fadeSlideUp .5s ease both;
    }
    .section-card:hover { box-shadow: var(--shadow-lg); }
    .section-card__head {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }
    .section-card__head-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .section-card__title {
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.01em;
    }
    .section-card__body { padding: 18px 20px; }

    /* ─── Data Rows ──────────────────────────────────────────────────── */
    .data-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }
    .data-row:last-child { border-bottom: none; padding-bottom: 0; }
    .data-row__label { color: var(--ink-soft); }
    .data-row__value {
        font-weight: 700;
        color: var(--ink);
        background: var(--canvas);
        border-radius: 6px;
        padding: 2px 10px;
        font-size: 13px;
    }

    /* ─── List Items ─────────────────────────────────────────────────── */
    .dr-list {
        list-style: none;
        padding: 0; margin: 0;
    }
    .dr-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: var(--ink-soft);
        animation: fadeSlideUp .4s ease both;
    }
    .dr-list li:last-child { border-bottom: none; }
    .dr-list__dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        margin-top: 5px;
        flex-shrink: 0;
    }

    /* ─── Empty State ────────────────────────────────────────────────── */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 28px 16px;
        text-align: center;
        color: var(--ink-faint);
        font-size: 13px;
        gap: 8px;
    }
    .empty-state svg { opacity: .4; }

    /* ─── Pass/Fail Bar ──────────────────────────────────────────────── */
    .pass-fail-bar {
        margin-top: 12px;
    }
    .pass-fail-bar__track {
        height: 8px;
        border-radius: 99px;
        background: var(--danger-lt);
        overflow: hidden;
        margin-bottom: 6px;
    }
    .pass-fail-bar__fill {
        height: 100%;
        background: linear-gradient(90deg, var(--success), #34d399);
        border-radius: 99px;
        transition: width 1s cubic-bezier(.4,0,.2,1);
    }
    .pass-fail-labels {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        font-weight: 600;
    }
    .pass-fail-labels .pass { color: var(--success); }
    .pass-fail-labels .fail { color: var(--danger); }

    /* ─── Cert Progress ──────────────────────────────────────────────── */
    .cert-progress {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }
    .cert-block {
        flex: 1;
        border-radius: 8px;
        padding: 10px 12px;
        text-align: center;
    }
    .cert-block__num {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -.03em;
    }
    .cert-block__label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        margin-top: 2px;
    }
    .cert-block--processed { background: var(--accent-lt); color: var(--accent); }
    .cert-block--released  { background: var(--success-lt); color: var(--success); }
    .cert-block--pending   { background: var(--warn-lt);   color: var(--warn); }

    /* ─── Two / Three column grids ───────────────────────────────────── */
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
    }
    .grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    /* ─── Accomplishments / Recommendations ──────────────────────────── */
    .ach-list { display: flex; flex-direction: column; gap: 8px; margin-top: 4px; }
    .ach-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: var(--canvas);
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        font-size: 13px;
        border-left: 3px solid transparent;
        animation: fadeSlideUp .5s ease both;
    }
    .ach-item--green { border-left-color: var(--success); }
    .ach-item--blue  { border-left-color: var(--accent); }
    .ach-item__icon { font-size: 15px; flex-shrink: 0; line-height: 1.5; }

    /* ─── Summary Footer ─────────────────────────────────────────────── */
    .summary-footer {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 16px;
    }

    /* ─── Loading Skeleton (shown 0.3s then removed by JS) ──────────── */
    @keyframes shimmer {
        0%   { background-position: -400px 0 }
        100% { background-position: 400px 0 }
    }

    /* ─── Keyframe Animations ────────────────────────────────────────── */
    @keyframes fadeSlideDown {
        from { opacity: 0; transform: translateY(-14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes countUp {
        from { opacity: 0; transform: scale(.8); }
        to   { opacity: 1; transform: scale(1); }
    }

    /* ─── Section stagger delays ─────────────────────────────────────── */
    .delay-1 { animation-delay: .05s }
    .delay-2 { animation-delay: .10s }
    .delay-3 { animation-delay: .15s }
    .delay-4 { animation-delay: .20s }
    .delay-5 { animation-delay: .25s }
    .delay-6 { animation-delay: .30s }

    /* ─── Divider labels ─────────────────────────────────────────────── */
    .section-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--ink-faint);
        margin-bottom: 10px;
        padding-left: 2px;
    }

    /* ─── Issue badge ────────────────────────────────────────────────── */
    .issue-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: var(--danger-lt);
        border-left: 3px solid var(--danger);
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        font-size: 13px;
        color: #7f1d1d;
        animation: fadeSlideUp .5s ease both;
    }

    /* ─── Refresh spinner ────────────────────────────────────────────── */
    .btn--primary.loading .btn-icon { animation: spin .7s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ─── Print ──────────────────────────────────────────────────────── */
    @media print {
        .dr-header__actions { display: none; }
        .section-card, .stat-card { break-inside: avoid; box-shadow: none; }
    }

    /* ─── Reduced Motion ─────────────────────────────────────────────── */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation-duration: .01ms !important; transition-duration: .01ms !important; }
    }

    /* ─── Spacing helpers ────────────────────────────────────────────── */
    .mt-4  { margin-top: 16px; }
    .mt-6  { margin-top: 24px; }
    .space-y > * + * { margin-top: 16px; }
</style>
@endpush

@section('content')
@php
    $passed      = $daily['assessment_results']->passed ?? 0;
    $failed      = $daily['assessment_results']->failed ?? 0;
    $totalAssessed = $passed + $failed;
    $passRate    = $totalAssessed > 0 ? round(($passed / $totalAssessed) * 100) : 0;
    $today       = now()->format('l, F j, Y');
@endphp

<div class="dr-wrapper">

    {{-- ── PAGE HEADER ─────────────────────────────────────────────── --}}
    <div class="dr-header">
        <div>
            <div class="dr-header__eyebrow">Operations Dashboard</div>
            <h1>Daily Summary Report</h1>
            <p>Trainees · Training · Assessment · Certificates · Trainers · Admin · Issues</p>
        </div>
        <div class="dr-header__actions">
            <div class="dr-date-badge">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $today }}
            </div>
            <a href="{{ route('staff.reports.daily') }}"
               class="btn btn--primary"
               onclick="this.classList.add('loading')"
               title="Refresh report">
                <svg class="btn-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                Refresh
            </a>
            <button class="btn btn--ghost" onclick="window.print()" title="Print report">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Print
            </button>
        </div>
    </div>

    {{-- ── TOP STAT CARDS ───────────────────────────────────────────── --}}
    <div class="stat-grid">
        <div class="stat-card stat-card--blue">
            <div class="stat-card__accent-bar"></div>
            <div class="stat-card__icon">👥</div>
            <div class="stat-card__label">Trainees Present</div>
            <div class="stat-card__value" data-count="{{ $daily['present'] ?? 0 }}">{{ $daily['present'] ?? 0 }}</div>
            <div class="stat-card__sub">Attending today</div>
        </div>
        <div class="stat-card stat-card--red">
            <div class="stat-card__accent-bar"></div>
            <div class="stat-card__icon">🚫</div>
            <div class="stat-card__label">Trainees Absent</div>
            <div class="stat-card__value" data-count="{{ $daily['absent'] ?? 0 }}">{{ $daily['absent'] ?? 0 }}</div>
            <div class="stat-card__sub">Not in attendance</div>
        </div>
        <div class="stat-card stat-card--green">
            <div class="stat-card__accent-bar"></div>
            <div class="stat-card__icon">✅</div>
            <div class="stat-card__label">New Registrations</div>
            <div class="stat-card__value" data-count="{{ $daily['new_registrations'] ?? 0 }}">{{ $daily['new_registrations'] ?? 0 }}</div>
            <div class="stat-card__sub">Enrolled today</div>
        </div>
        <div class="stat-card stat-card--blue">
            <div class="stat-card__accent-bar"></div>
            <div class="stat-card__icon">📚</div>
            <div class="stat-card__label">Classes Conducted</div>
            <div class="stat-card__value" data-count="{{ $daily['classes_conducted'] ?? 0 }}">{{ $daily['classes_conducted'] ?? 0 }}</div>
            <div class="stat-card__sub">Sessions today</div>
        </div>
        <div class="stat-card stat-card--warn">
            <div class="stat-card__accent-bar"></div>
            <div class="stat-card__icon">⏱️</div>
            <div class="stat-card__label">Training Hours</div>
            <div class="stat-card__value">{{ round($daily['training_hours'] ?? 0, 1) }}<span style="font-size:14px;font-weight:600;color:var(--ink-faint)">h</span></div>
            <div class="stat-card__sub">Completed today</div>
        </div>
        <div class="stat-card stat-card--green">
            <div class="stat-card__accent-bar"></div>
            <div class="stat-card__icon">🏋️</div>
            <div class="stat-card__label">Practical Activities</div>
            <div class="stat-card__value" data-count="{{ $daily['practical_completed'] ?? 0 }}">{{ $daily['practical_completed'] ?? 0 }}</div>
            <div class="stat-card__sub">Completed today</div>
        </div>
    </div>

    {{-- ── TRAINEE CONCERNS ─────────────────────────────────────────── --}}
    @if(!empty($daily['concerns']) && count($daily['concerns']))
    <div class="section-card delay-1" style="margin-bottom:16px;">
        <div class="section-card__head">
            <div class="section-card__head-icon" style="background:#fee2e2;color:#dc2626;">⚠️</div>
            <div class="section-card__title">Trainee Concerns</div>
            <span style="margin-left:auto;font-size:11px;font-weight:700;background:#fee2e2;color:#dc2626;border-radius:999px;padding:2px 10px;">
                {{ count($daily['concerns']) }}
            </span>
        </div>
        <div class="section-card__body">
            <ul class="dr-list">
                @foreach($daily['concerns'] as $c)
                    <li>
                        <span class="dr-list__dot" style="background:#dc2626;"></span>
                        <span>{{ is_object($c) ? ($c->issue ?? json_encode($c)) : $c }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- ── TRAINING & ASSESSMENT ────────────────────────────────────── --}}
    <div class="section-label">Training &amp; Assessment</div>
    <div class="grid-2" style="margin-bottom:16px;">

        {{-- Training Activities --}}
        <div class="section-card delay-2">
            <div class="section-card__head">
                <div class="section-card__head-icon" style="background:var(--accent-lt);color:var(--accent);">📖</div>
                <div class="section-card__title">Training Activities</div>
            </div>
            <div class="section-card__body">
                <div class="data-row">
                    <span class="data-row__label">Classes conducted</span>
                    <span class="data-row__value">{{ $daily['classes_conducted'] ?? 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-row__label">Training hours</span>
                    <span class="data-row__value">{{ round($daily['training_hours'] ?? 0, 2) }}h</span>
                </div>
                <div class="data-row">
                    <span class="data-row__label">Practical activities</span>
                    <span class="data-row__value">{{ $daily['practical_completed'] ?? 0 }}</span>
                </div>

                @php $modules = $daily['modules_discussed'] ?? collect(); @endphp
                @if(count($modules))
                    <div style="margin-top:14px;">
                        <div style="font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:8px;">Modules / Topics</div>
                        <ul class="dr-list">
                            @foreach($modules as $m)
                                <li>
                                    <span class="dr-list__dot" style="background:var(--accent);"></span>
                                    <span>{{ is_object($m) ? ($m->module ?? json_encode($m)) : (is_array($m) ? json_encode($m) : $m) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="empty-state" style="padding:16px 0 0;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                        No modules recorded today
                    </div>
                @endif
            </div>
        </div>

        {{-- Assessment Activities --}}
        <div class="section-card delay-3">
            <div class="section-card__head">
                <div class="section-card__head-icon" style="background:var(--success-lt);color:var(--success);">📝</div>
                <div class="section-card__title">Assessment Activities</div>
            </div>
            <div class="section-card__body">
                <div class="data-row">
                    <span class="data-row__label">Assessments conducted</span>
                    <span class="data-row__value">{{ $daily['assessments_conducted'] ?? 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-row__label">Trainees assessed</span>
                    <span class="data-row__value">{{ $daily['trainees_assessed'] ?? 0 }}</span>
                </div>

                <div class="pass-fail-bar">
                    <div style="font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:8px;">Pass / Fail Rate</div>
                    <div class="pass-fail-bar__track">
                        <div class="pass-fail-bar__fill" style="width:{{ $passRate }}%" data-width="{{ $passRate }}"></div>
                    </div>
                    <div class="pass-fail-labels">
                        <span class="pass">✓ Passed: {{ $passed }}  ({{ $passRate }}%)</span>
                        <span class="fail">✗ Failed: {{ $failed }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── CERTIFICATES · TRAINERS · ADMIN ─────────────────────────── --}}
    <div class="section-label">Operations</div>
    <div class="grid-3" style="margin-bottom:16px;">

        {{-- Certificates --}}
        <div class="section-card delay-3">
            <div class="section-card__head">
                <div class="section-card__head-icon" style="background:var(--warn-lt);color:var(--warn);">🎓</div>
                <div class="section-card__title">Certificate Activities</div>
            </div>
            <div class="section-card__body">
                <div class="cert-progress">
                    <div class="cert-block cert-block--processed">
                        <div class="cert-block__num">{{ $daily['certificates_processed'] ?? 0 }}</div>
                        <div class="cert-block__label">Processed</div>
                    </div>
                    <div class="cert-block cert-block--released">
                        <div class="cert-block__num">{{ $daily['certificates_released'] ?? 0 }}</div>
                        <div class="cert-block__label">Released</div>
                    </div>
                    <div class="cert-block cert-block--pending">
                        <div class="cert-block__num">{{ $daily['certificates_pending'] ?? 0 }}</div>
                        <div class="cert-block__label">Pending</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Trainer Activities --}}
        <div class="section-card delay-4">
            <div class="section-card__head">
                <div class="section-card__head-icon" style="background:#ede9fe;color:#7c3aed;">🧑‍🏫</div>
                <div class="section-card__title">Trainer Activities</div>
            </div>
            <div class="section-card__body">
                <div class="data-row">
                    <span class="data-row__label">Trainers present</span>
                    <span class="data-row__value">{{ $daily['trainers_present'] ?? 0 }}</span>
                </div>

                @php $schedules = $daily['trainer_schedules'] ?? collect(); @endphp
                @if(count($schedules))
                    <div style="margin-top:12px;">
                        <div style="font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:8px;">Schedules / Notes</div>
                        <ul class="dr-list">
                            @foreach($schedules as $s)
                                <li>
                                    <span class="dr-list__dot" style="background:#7c3aed;"></span>
                                    <span>{{ is_object($s) ? ($s->summary ?? json_encode($s)) : (is_array($s) ? json_encode($s) : $s) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="empty-state" style="padding:14px 0 0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        No schedules recorded
                    </div>
                @endif
            </div>
        </div>

        {{-- Administrative --}}
        <div class="section-card delay-5">
            <div class="section-card__head">
                <div class="section-card__head-icon" style="background:#f0fdf4;color:var(--success);">🗂️</div>
                <div class="section-card__title">Administrative Tasks</div>
            </div>
            <div class="section-card__body">
                <div class="data-row">
                    <span class="data-row__label">Documents processed</span>
                    <span class="data-row__value">{{ $daily['documents_processed'] ?? 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-row__label">Reports submitted</span>
                    <span class="data-row__value">{{ $daily['reports_submitted'] ?? 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-row__label">Meetings attended</span>
                    <span class="data-row__value">{{ $daily['meetings_attended'] ?? 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-row__label">Inventory updates</span>
                    <span class="data-row__value">{{ $daily['inventory_updates'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── ISSUES & CONCERNS ────────────────────────────────────────── --}}
    <div class="section-label">Issues &amp; Concerns</div>
    <div class="section-card delay-5" style="margin-bottom:16px;">
        <div class="section-card__head">
            <div class="section-card__head-icon" style="background:var(--danger-lt);color:var(--danger);">🚨</div>
            <div class="section-card__title">Issues &amp; Concerns</div>
            @if(!empty($daily['issues']) && count($daily['issues']))
                <span style="margin-left:auto;font-size:11px;font-weight:700;background:var(--danger-lt);color:var(--danger);border-radius:999px;padding:2px 10px;">
                    {{ count($daily['issues']) }} issue{{ count($daily['issues']) !== 1 ? 's' : '' }}
                </span>
            @else
                <span style="margin-left:auto;font-size:11px;font-weight:700;background:var(--success-lt);color:var(--success);border-radius:999px;padding:2px 10px;">
                    All clear
                </span>
            @endif
        </div>
        <div class="section-card__body">
            @if(!empty($daily['issues']) && count($daily['issues']))
                <div class="space-y">
                    @foreach($daily['issues'] as $i)
                        <div class="issue-item">
                            <span style="flex-shrink:0;margin-top:1px;">⚠️</span>
                            <span>{{ is_object($i) ? ($i->issue ?? json_encode($i)) : $i }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    No issues recorded today. Great work!
                </div>
            @endif
        </div>
    </div>

    {{-- ── DAILY SUMMARY FOOTER ─────────────────────────────────────── --}}
    <div class="section-label">End-of-Day Summary</div>
    <div class="section-card delay-6">
        <div class="section-card__head">
            <div class="section-card__head-icon" style="background:var(--accent-lt);color:var(--accent);">📊</div>
            <div class="section-card__title">Daily Summary</div>
        </div>
        <div class="section-card__body">

            {{-- Quick totals --}}
            <div style="display:flex;gap:24px;flex-wrap:wrap;padding-bottom:16px;margin-bottom:16px;border-bottom:1px solid var(--border);">
                <div>
                    <div style="font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-faint);">Total Present</div>
                    <div style="font-size:26px;font-weight:800;letter-spacing:-.04em;">{{ $daily['total_present'] ?? 0 }}</div>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-faint);">Total Activities</div>
                    <div style="font-size:26px;font-weight:800;letter-spacing:-.04em;">{{ $daily['total_activities'] ?? 0 }}</div>
                </div>
            </div>

            <div class="summary-footer">
                {{-- Accomplishments --}}
                <div>
                    <div style="font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:10px;">✅ Accomplishments</div>
                    @if(!empty($daily['accomplishments']) && count($daily['accomplishments']))
                        <div class="ach-list">
                            @foreach($daily['accomplishments'] as $a)
                                <div class="ach-item ach-item--green">
                                    <span class="ach-item__icon">🏆</span>
                                    <span>{{ $a }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state" style="padding:12px 0;">No accomplishments recorded.</div>
                    @endif
                </div>

                {{-- Recommendations --}}
                <div>
                    <div style="font-size:11px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--ink-faint);margin-bottom:10px;">💡 Recommendations</div>
                    @if(!empty($daily['recommendations']) && count($daily['recommendations']))
                        <div class="ach-list">
                            @foreach($daily['recommendations'] as $r)
                                <div class="ach-item ach-item--blue">
                                    <span class="ach-item__icon">💡</span>
                                    <span>{{ $r }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state" style="padding:12px 0;">No recommendations recorded.</div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div><!-- /.dr-wrapper -->
@endsection

@push('scripts')
<script>
(function () {
    /* ── Animated counter ─────────────────────────────────────────── */
    function animateCounter(el) {
        const target = parseInt(el.dataset.count, 10);
        if (isNaN(target) || target === 0) return;
        const duration = 900;
        const startTime = performance.now();
        const tick = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // ease-out quad
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target);
            if (progress < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
    }

    /* ── Pass/fail bar animate ────────────────────────────────────── */
    function animateBars() {
        document.querySelectorAll('.pass-fail-bar__fill[data-width]').forEach(bar => {
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = bar.dataset.width + '%';
            }, 200);
        });
    }

    /* ── Intersection Observer (animate on scroll / first view) ──── */
    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            if (el.dataset.count !== undefined) animateCounter(el);
            if (el.classList.contains('pass-fail-bar__fill')) {
                el.style.width = '0';
                setTimeout(() => { el.style.width = el.dataset.width + '%'; }, 150);
            }
            io.unobserve(el);
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('[data-count]').forEach(el => io.observe(el));
    document.querySelectorAll('.pass-fail-bar__fill[data-width]').forEach(el => io.observe(el));

    /* ── Refresh button loading state ─────────────────────────────── */
    document.querySelectorAll('a.btn--primary').forEach(btn => {
        btn.addEventListener('click', () => btn.classList.add('loading'));
    });
})();
</script>
@endpush