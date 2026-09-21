@extends('staff.layouts.masters')

@section('title', 'Subjects Management')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════
   SUBJECTS INDEX — Ultra-polished console UI
   Self-contained: no Tailwind dark: variants needed.
   ═══════════════════════════════════════════════════════ */

/* ---------- CSS custom properties ---------- */
.syl-wrap {
    --bg:       var(--body-bg);
    --surface:  var(--surface);
    --raised:   var(--topbar-control-bg);
    --border:   var(--border);
    --border-h: rgba(34,211,238,0.4);
    --accent:   #6366F1;
    --cyan:     #22D3EE;
    --emerald:  #34D399;
    --amber:    #FBBF24;
    --rose:     #FB7185;
    --text:     var(--text);
    --text-dim: var(--muted);
    --text-xs:  var(--muted);
    color: var(--text);
}

html[data-staff-theme="dark"] .syl-wrap {
    --bg:       #080D18;
    --surface:  #0D1424;
    --raised:   #111827;
    --border:   rgba(99,102,241,0.18);
    --border-h: rgba(34,211,238,0.4);
    --text:     #E2E8F0;
    --text-dim: #7C8AA5;
    --text-xs:  #4B5563;
}

/* ---------- Ambient orbs ---------- */
.syl-orb {
    position: fixed; pointer-events: none; z-index: 0;
    border-radius: 50%; filter: blur(80px);
    animation: orb-drift 18s ease-in-out infinite alternate;
}
.syl-orb-1 {
    width: 420px; height: 420px; top: -120px; right: -80px;
    background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 70%);
    animation-delay: 0s;
}
.syl-orb-2 {
    width: 300px; height: 300px; bottom: -60px; left: -60px;
    background: radial-gradient(circle, rgba(34,211,238,0.12) 0%, transparent 70%);
    animation-delay: -7s;
}
@keyframes orb-drift {
    from { transform: translate(0, 0) scale(1); }
    to   { transform: translate(30px, 20px) scale(1.06); }
}

/* ---------- Page header ---------- */
.syl-page-header {
    position: relative; z-index: 2;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.5rem;
}
.syl-heading {
    font-size: 1.65rem; font-weight: 800; letter-spacing: -0.02em;
    background: linear-gradient(100deg, #fff 10%, var(--cyan) 50%, var(--accent) 90%);
    -webkit-background-clip: text; background-clip: text; color: transparent;
    animation: hue-shift 8s ease-in-out infinite;
}
@keyframes hue-shift {
    0%,100% { filter: hue-rotate(0deg) brightness(1); }
    50%      { filter: hue-rotate(15deg) brightness(1.15); }
}
.syl-sub { font-size: 0.8rem; color: var(--text-dim); margin-top: 2px; }

/* ---------- New button ---------- */
.syl-new-btn {
    position: relative; overflow: hidden;
    display: inline-flex; align-items: center; gap: 6px;
    padding: 0.55rem 1.2rem;
    background: linear-gradient(135deg, var(--accent) 0%, var(--cyan) 100%);
    color: #fff; font-size: 0.8rem; font-weight: 700;
    border-radius: 10px; border: none; cursor: pointer; text-decoration: none;
    transition: transform 0.18s ease, box-shadow 0.22s ease, filter 0.22s ease;
    box-shadow: 0 0 0 1px rgba(99,102,241,0.4) inset;
}
.syl-new-btn::after {
    content: ''; position: absolute;
    top: -50%; left: -60%; width: 40%; height: 200%;
    background: rgba(255,255,255,0.18); transform: skewX(-20deg);
    animation: btn-sheen 3.5s ease-in-out infinite;
}
@keyframes btn-sheen {
    0%   { left: -60%; }
    50%,100% { left: 130%; }
}
.syl-new-btn:hover {
    transform: translateY(-2px);
    filter: brightness(1.12);
    box-shadow: 0 0 28px rgba(34,211,238,0.5), 0 4px 18px rgba(99,102,241,0.35);
}
.syl-new-btn:active { transform: translateY(0); }

/* ---------- Stats strip ---------- */
.syl-stats {
    display: flex; gap: 1rem; margin-bottom: 1.25rem; position: relative; z-index: 2;
}
.syl-stat-card {
    flex: 1; background: var(--surface);
    border: 1px solid var(--border); border-radius: 12px;
    padding: 0.75rem 1rem;
    display: flex; align-items: center; gap: 0.75rem;
    opacity: 0; transform: translateY(8px);
    animation: stat-in 0.4s cubic-bezier(.22,.61,.36,1) forwards;
}
.syl-stat-card:nth-child(1) { animation-delay: 0ms; }
.syl-stat-card:nth-child(2) { animation-delay: 60ms; }
.syl-stat-card:nth-child(3) { animation-delay: 120ms; }
@keyframes stat-in { to { opacity:1; transform:translateY(0); } }
.syl-stat-icon {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.syl-stat-val { font-size: 1.25rem; font-weight: 800; line-height: 1; }
.syl-stat-lbl { font-size: 0.68rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-dim); }

/* ---------- Alert ---------- */
.syl-alert {
    position: relative; z-index: 2;
    display: flex; align-items: center; gap: 10px;
    padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem;
    background: rgba(52,211,153,0.07);
    border: 1px solid rgba(52,211,153,0.3);
    box-shadow: 0 0 24px rgba(52,211,153,0.07);
    animation: alert-in 0.28s cubic-bezier(.22,.61,.36,1);
    color: #6EE7B7;
}
@keyframes alert-in {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.syl-alert-dismiss {
    margin-left: auto; background: none; border: none; cursor: pointer;
    color: #6EE7B7; opacity: 0.6; transition: opacity 0.15s;
    display: flex; align-items: center;
}
.syl-alert-dismiss:hover { opacity: 1; }

/* ---------- Console panel ---------- */
.syl-panel {
    position: relative; z-index: 2;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px; overflow: hidden;
    box-shadow:
        0 0 0 1px rgba(99,102,241,0.05),
        0 1px 0 0 rgba(255,255,255,0.04) inset,
        0 32px 80px -24px rgba(2,6,23,0.8);
}

/* animated dot-grid backdrop */
.syl-dotgrid {
    position: absolute; inset: 0; pointer-events: none; z-index: 0;
    background-image: radial-gradient(circle, rgba(99,102,241,0.12) 1px, transparent 1px);
    background-size: 28px 28px;
    mask-image: radial-gradient(ellipse 85% 65% at 50% 0%, black 20%, transparent 80%);
    animation: dotgrid-drift 20s linear infinite;
}
@keyframes dotgrid-drift {
    from { background-position: 0 0; }
    to   { background-position: 28px 28px; }
}

/* top-edge glow bar */
.syl-topglow {
    position: absolute; top: 0; left: 0; right: 0; height: 1px; z-index: 1;
    background: linear-gradient(90deg, transparent 5%, var(--accent) 40%, var(--cyan) 60%, transparent 95%);
    opacity: 0.6;
}

/* scan-line */
.syl-scanline {
    position: absolute; top: 0; left: -35%; width: 35%; height: 2px; z-index: 2;
    background: linear-gradient(90deg, transparent, var(--cyan), transparent);
    animation: scan 3.6s ease-in-out infinite;
    filter: drop-shadow(0 0 8px var(--cyan));
}
@keyframes scan { 0% { left: -35%; } 100% { left: 110%; } }

.syl-panel-content { position: relative; z-index: 3; }

/* panel toolbar */
.syl-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0.85rem 1.25rem;
    border-bottom: 1px solid var(--border);
}
.syl-toolbar-left { display: flex; align-items: center; gap: 0.5rem; }
.syl-dot { width: 7px; height: 7px; border-radius: 50%; }
.syl-dot-r { background: #FF5F57; }
.syl-dot-y { background: #FEBC2E; }
.syl-dot-g { background: #28C840; }
.syl-toolbar-title { font-size: 0.72rem; font-family: monospace; color: var(--text-dim); letter-spacing: 0.08em; margin-left: 0.5rem; }
.syl-live-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.65rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
    padding: 0.18rem 0.6rem; border-radius: 999px;
    background: rgba(52,211,153,0.1); color: var(--emerald);
    border: 1px solid rgba(52,211,153,0.25);
}
.syl-live-dot {
    width: 5px; height: 5px; border-radius: 50%; background: var(--emerald);
    box-shadow: 0 0 6px rgba(52,211,153,0.9);
    animation: live-blink 1.6s ease-in-out infinite;
}
@keyframes live-blink { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

/* ---------- Table ---------- */
table.syl-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.syl-table thead tr {
    background: linear-gradient(90deg, rgba(99,102,241,0.06), rgba(34,211,238,0.04));
}
.syl-table th {
    padding: 0.65rem 1.1rem; text-align: left;
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.09em; text-transform: uppercase;
    color: var(--text-dim); border-bottom: 1px solid var(--border);
}
.syl-table th:last-child { text-align: center; }

.syl-row {
    opacity: 0; transform: translateX(-6px);
    animation: row-in 0.3s cubic-bezier(.22,.61,.36,1) forwards;
    animation-delay: calc(var(--i,0) * 35ms);
    border-left: 2px solid transparent;
    transition: background 0.18s ease, border-color 0.18s ease;
}
@keyframes row-in { to { opacity:1; transform:translateX(0); } }
.syl-row:hover {
    background: rgba(99,102,241,0.06);
    border-left-color: var(--cyan);
}
.syl-table td {
    padding: 0.8rem 1.1rem;
    border-bottom: 1px solid rgba(99,102,241,0.07);
    vertical-align: middle;
}
.syl-row:last-child td { border-bottom: none; }

/* course pill */
.syl-course-pill {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(99,102,241,0.1);
    border: 1px solid rgba(99,102,241,0.2);
    padding: 0.2rem 0.65rem; border-radius: 999px;
    font-size: 0.72rem; font-weight: 600; color: #A5B4FC;
}

/* status badges */
.syl-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 0.22rem 0.7rem; border-radius: 999px;
    font-size: 0.7rem; font-weight: 700; letter-spacing: 0.04em;
}
.syl-badge-live {
    background: rgba(52,211,153,0.1); color: #6EE7B7;
    border: 1px solid rgba(52,211,153,0.25);
}
.syl-badge-draft {
    background: rgba(100,116,139,0.12); color: #94A3B8;
    border: 1px solid rgba(100,116,139,0.2);
}
.syl-status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.syl-badge-live .syl-status-dot {
    background: var(--emerald);
    box-shadow: 0 0 7px rgba(52,211,153,0.9);
    animation: pulse-dot 1.8s ease-in-out infinite;
}
.syl-badge-draft .syl-status-dot { background: #64748B; }
@keyframes pulse-dot {
    0%,100% { box-shadow: 0 0 4px rgba(52,211,153,0.8); }
    50%     { box-shadow: 0 0 10px rgba(52,211,153,1); }
}

/* date range */
.syl-date { font-size: 0.78rem; color: #94A3B8; white-space: nowrap; }
.syl-date-arrow { color: var(--cyan); margin: 0 4px; }

/* action buttons */
.syl-act {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 8px; border: none;
    cursor: pointer; background: transparent;
    transition: background 0.16s ease, transform 0.14s ease, box-shadow 0.16s ease;
    position: relative;
}
.syl-act:hover { transform: translateY(-1px); }
.syl-act:active { transform: translateY(0) scale(0.95); }
.syl-act-edit   { color: #818CF8; }
.syl-act-edit:hover   { background: rgba(99,102,241,0.14); box-shadow: 0 0 12px rgba(99,102,241,0.2); }
.syl-act-pub    { color: #34D399; }
.syl-act-pub:hover    { background: rgba(52,211,153,0.12); box-shadow: 0 0 12px rgba(52,211,153,0.2); }
.syl-act-unpub  { color: #FBBF24; }
.syl-act-unpub:hover  { background: rgba(251,191,36,0.12); box-shadow: 0 0 12px rgba(251,191,36,0.2); }
.syl-act-del    { color: #FB7185; }
.syl-act-del:hover    { background: rgba(251,113,133,0.12); box-shadow: 0 0 12px rgba(251,113,133,0.2); }

/* tooltip */
[data-tip] { position: relative; }
[data-tip]::before {
    content: attr(data-tip);
    position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%) scale(0.9);
    background: #1E293B; color: #E2E8F0;
    font-size: 0.65rem; font-weight: 600; white-space: nowrap;
    padding: 0.25rem 0.5rem; border-radius: 5px; pointer-events: none;
    opacity: 0; transition: opacity 0.15s ease, transform 0.15s ease;
    border: 1px solid rgba(255,255,255,0.08);
}
[data-tip]:hover::before { opacity: 1; transform: translateX(-50%) scale(1); }

/* empty state */
.syl-empty { padding: 4rem 1rem; text-align: center; }
.syl-empty-icon {
    display: inline-flex; align-items: center; justify-content: center;
    width: 64px; height: 64px; border-radius: 16px; margin: 0 auto 1rem;
    background: rgba(34,211,238,0.07); border: 1px solid rgba(34,211,238,0.15);
    color: var(--cyan);
    animation: empty-breathe 3s ease-in-out infinite;
}
@keyframes empty-breathe {
    0%,100% { box-shadow: 0 0 0 0 rgba(34,211,238,0); }
    50%     { box-shadow: 0 0 20px 4px rgba(34,211,238,0.12); }
}

/* ---------- Pagination override ---------- */
.syl-wrap nav { margin-top: 1.25rem; }
.syl-wrap nav .pagination, .syl-wrap nav [role="navigation"] { display: flex; gap: 4px; justify-content: center; }
.syl-wrap nav a, .syl-wrap nav span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 32px; padding: 0 0.5rem;
    background: rgba(13,20,36,0.9); border: 1px solid var(--border);
    border-radius: 8px; font-size: 0.78rem; color: var(--text-dim);
    transition: background 0.15s, border-color 0.15s, color 0.15s;
    text-decoration: none;
}
.syl-wrap nav a:hover { background: rgba(99,102,241,0.14); border-color: var(--accent); color: var(--text); }
.syl-wrap nav [aria-current="page"] span,
.syl-wrap nav span.font-bold {
    background: linear-gradient(135deg, var(--accent), var(--cyan));
    border-color: transparent; color: #fff;
}

/* ---------- Reduced motion ---------- */
@media (prefers-reduced-motion: reduce) {
    .syl-orb, .syl-scanline, .syl-heading, .syl-stat-card,
    .syl-row, .syl-badge-live .syl-status-dot, .syl-empty-icon,
    .syl-live-dot, .syl-new-btn::after {
        animation: none !important; opacity: 1 !important; transform: none !important;
    }
}
</style>

<div class="syl-wrap" style="position:relative; min-height:100vh; padding: 1.5rem 1.5rem 3rem;">

    <!-- Ambient orbs -->
    <div class="syl-orb syl-orb-1"></div>
    <div class="syl-orb syl-orb-2"></div>

    <!-- Page header -->
    <div class="syl-page-header">
        <div>
            <h1 class="syl-heading">Subjects Management</h1>
            <p class="syl-sub">Create and maintain course subjects in one place.</p>
        </div>
        <a href="{{ route('staff.subjects.create') }}" class="syl-new-btn">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            New Subject
        </a>
    </div>

    <!-- Stats strip -->
    @php
        $total     = $subjects->count();
        $active    = $subjects->where('is_active', true)->count();
        $inactive  = $subjects->where('is_active', false)->count();
    @endphp
    <div class="syl-stats">
        <div class="syl-stat-card">
            <div class="syl-stat-icon" style="background:rgba(99,102,241,0.12); color:#818CF8;">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <div class="syl-stat-val" style="color:#818CF8;">{{ $total }}</div>
                <div class="syl-stat-lbl">Total</div>
            </div>
        </div>
        <div class="syl-stat-card">
            <div class="syl-stat-icon" style="background:rgba(52,211,153,0.1); color:#34D399;">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div>
                <div class="syl-stat-val" style="color:#34D399;">{{ $active }}</div>
                <div class="syl-stat-lbl">Active</div>
            </div>
        </div>
        <div class="syl-stat-card">
            <div class="syl-stat-icon" style="background:rgba(100,116,139,0.12); color:#94A3B8;">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <div class="syl-stat-val" style="color:#94A3B8;">{{ $inactive }}</div>
                <div class="syl-stat-lbl">Archived</div>
            </div>
        </div>
    </div>

    <!-- Success alert -->
    @if(session('success'))
        <div class="syl-alert" data-alert>
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm flex-1">{{ session('success') }}</span>
            <button class="syl-alert-dismiss" data-alert-dismiss aria-label="Dismiss">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="syl-alert" data-alert style="background: rgba(251,113,133,0.07); border-color: rgba(251,113,133,0.3); color: #FB7185; box-shadow: 0 0 24px rgba(251,113,133,0.07);">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span class="text-sm flex-1">{{ session('error') }}</span>
            <button class="syl-alert-dismiss" data-alert-dismiss aria-label="Dismiss" style="color: #FB7185;">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Console panel -->
    <div class="syl-panel">
        <div class="syl-dotgrid"></div>
        <div class="syl-topglow"></div>
        <div class="syl-scanline"></div>

        <div class="syl-panel-content">

            <!-- Panel toolbar (macOS-style dots) -->
            <div class="syl-toolbar">
                <div class="syl-toolbar-left">
                    <span class="syl-dot syl-dot-r"></span>
                    <span class="syl-dot syl-dot-y"></span>
                    <span class="syl-dot syl-dot-g"></span>
                    <span class="syl-toolbar-title">subjects.index — {{ $total }} {{ Str::plural('record', $total) }}</span>
                </div>
                <span class="syl-live-badge">
                    <span class="syl-live-dot"></span>
                    Live
                </span>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;">
                <table class="syl-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Subject Name</th>
                            <th>Units/Hours</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th style="text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr class="syl-row" style="--i:{{ $loop->index }};">
                                <td>
                                    <span style="font-family: monospace; color:#A5B4FC;">{{ $subject->subject_code ?? '—' }}</span>
                                </td>
                                <td>
                                    <div style="color:#CBD5E1; font-weight:500;">{{ $subject->title }}</div>
                                    @if($subject->description)
                                    <div style="font-size: 0.72rem; color: var(--text-dim); max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $subject->description }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="syl-date">
                                        {{ $subject->units ?? 0 }} Units <span class="syl-date-arrow">•</span> {{ $subject->hours ?? 0 }} Hours
                                    </span>
                                </td>
                                <td>
                                    <span class="syl-course-pill">
                                        {{ $subject->course->title ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    @if($subject->is_active)
                                        <span class="syl-badge syl-badge-live">
                                            <span class="syl-status-dot"></span> Active
                                        </span>
                                    @else
                                        <span class="syl-badge syl-badge-draft">
                                            <span class="syl-status-dot"></span> Archived
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex; align-items:center; justify-content:center; gap:4px;">

                                        <a href="{{ route('staff.subjects.edit', $subject) }}"
                                           class="syl-act syl-act-edit" data-tip="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        <form action="{{ route('staff.subjects.destroy', $subject) }}"
                                              method="POST" style="display:inline;"
                                              onsubmit="return confirm('Permanently delete this subject?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="syl-act syl-act-del" data-tip="Delete">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="syl-empty">
                                    <div class="syl-empty-icon">
                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p style="font-weight:600; color:#94A3B8; margin-bottom:4px;">No subjects yet</p>
                                    <p style="font-size:0.78rem; color:#4B5563;">Get started by creating your first subject.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div><!-- /panel-content -->
    </div><!-- /panel -->

</div>

<script>
(function () {
    /* dismiss alert */
    var dismiss = document.querySelector('[data-alert-dismiss]');
    var alert   = document.querySelector('[data-alert]');
    if (dismiss && alert) {
        dismiss.addEventListener('click', function () {
            alert.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-6px)';
            setTimeout(function () { alert.style.display = 'none'; }, 200);
        });
        /* auto-dismiss after 5 s */
        setTimeout(function () {
            if (!alert.parentNode) return;
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function () { alert.style.display = 'none'; }, 500);
        }, 5000);
    }
})();
</script>
@endsection