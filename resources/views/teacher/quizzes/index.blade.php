@extends('teacher.layouts.master')

@section('title', 'Quizzes')
@section('page_title', 'Quizzes')

@section('content')

{{-- ===================== STYLES ===================== --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap');

    :root {
        --bg:           #0d0f14;
        --surface:      #13161e;
        --surface-2:    #1b1f2b;
        --surface-3:    #222638;
        --border:       rgba(255,255,255,0.07);
        --border-hover: rgba(255,255,255,0.14);
        --gold:         #c9a96e;
        --gold-light:   #e8c98a;
        --gold-dim:     rgba(201,169,110,0.12);
        --text:         #e8e4dc;
        --muted:        #6b7280;
        --accent:       #3d5aff;
        --accent-dim:   rgba(61,90,255,0.15);
        --green:        #4ade80;
        --green-dim:    rgba(74,222,128,0.1);
        --red:          #f87171;
        --red-dim:      rgba(248,113,113,0.1);
        --radius:       14px;
        --radius-lg:    22px;
        --ease-out:     cubic-bezier(0.22, 1, 0.36, 1);
    }

    /* ── Keyframes ── */
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(22px); }
        to   { opacity:1; transform:translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity:0; }
        to   { opacity:1; }
    }
    @keyframes lineGrow {
        from { transform:scaleX(0); }
        to   { transform:scaleX(1); }
    }
    @keyframes rowReveal {
        from { opacity:0; transform:translateX(-10px); }
        to   { opacity:1; transform:translateX(0); }
    }
    @keyframes shimmer {
        0%   { background-position:-200% center; }
        100% { background-position: 200% center; }
    }
    @keyframes orbDrift {
        from { transform:translate(0,0) scale(1); }
        to   { transform:translate(30px,20px) scale(1.07); }
    }
    @keyframes badgePop {
        0%   { transform:scale(0.7); opacity:0; }
        60%  { transform:scale(1.1); }
        100% { transform:scale(1); opacity:1; }
    }
    @keyframes spin {
        to { transform:rotate(360deg); }
    }

    /* ── Wrap ── */
    .qz-wrap {
        font-family:'DM Sans', sans-serif;
        color:var(--text);
        display:flex;
        flex-direction:column;
        gap:1.5rem;
        padding:1.5rem 0;
        position:relative;
    }

    /* Ambient orbs */
    .qz-wrap::before,
    .qz-wrap::after {
        content:'';
        position:fixed;
        border-radius:50%;
        pointer-events:none;
        z-index:0;
        filter:blur(110px);
        animation:orbDrift 14s ease-in-out infinite alternate;
    }
    .qz-wrap::before {
        width:500px; height:500px;
        background:radial-gradient(circle,#3d5aff,transparent 70%);
        opacity:.13;
        top:-100px; left:-180px;
    }
    .qz-wrap::after {
        width:420px; height:420px;
        background:radial-gradient(circle,var(--gold),transparent 70%);
        opacity:.09;
        bottom:0; right:-120px;
        animation-delay:-7s;
    }

    /* ── Header card ── */
    .qz-header {
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:var(--radius-lg);
        padding:2.25rem 2.5rem;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1.5rem;
        position:relative;
        overflow:hidden;
        z-index:1;
        animation:fadeUp .6s var(--ease-out) both;
    }
    .qz-header::before {
        content:'';
        position:absolute;
        inset:0;
        border-radius:var(--radius-lg);
        background:linear-gradient(135deg,rgba(201,169,110,.07) 0%,transparent 55%);
        pointer-events:none;
    }
    .qz-header::after {
        content:'';
        position:absolute;
        top:0; left:0;
        width:160px; height:1px;
        background:linear-gradient(90deg,var(--gold),transparent);
        transform-origin:left center;
        animation:lineGrow 1s var(--ease-out) .3s both;
    }

    .qz-header-left {}
    .qz-eyebrow {
        font-size:.68rem;
        font-weight:500;
        letter-spacing:.18em;
        text-transform:uppercase;
        color:var(--gold);
        margin-bottom:.5rem;
        display:flex;
        align-items:center;
        gap:.45rem;
        animation:fadeIn .5s ease .2s both;
    }
    .qz-eyebrow-dot {
        width:5px; height:5px;
        border-radius:50%;
        background:var(--gold);
        display:inline-block;
    }
    .qz-header h2 {
        font-family:'Playfair Display', serif;
        font-size:clamp(1.4rem,2.5vw,1.9rem);
        font-weight:700;
        margin:0 0 .4rem;
        background:linear-gradient(100deg,var(--text) 30%,var(--gold-light) 100%);
        -webkit-background-clip:text;
        -webkit-text-fill-color:transparent;
        background-clip:text;
        animation:fadeUp .6s var(--ease-out) .15s both;
    }
    .qz-header p {
        font-size:.88rem;
        font-weight:300;
        color:var(--muted);
        margin:0;
        line-height:1.6;
        animation:fadeUp .5s var(--ease-out) .25s both;
    }

    /* ── Buttons ── */
    .btn-primary, .btn-secondary {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:.4rem;
        padding:.72rem 1.5rem;
        border-radius:10px;
        font-family:'DM Sans', sans-serif;
        font-size:.84rem;
        font-weight:500;
        letter-spacing:.02em;
        text-decoration:none;
        white-space:nowrap;
        transition:transform .2s var(--ease-out), box-shadow .2s ease, background .2s ease, border-color .2s;
        position:relative;
        overflow:hidden;
        cursor:pointer;
    }
    .btn-primary::before, .btn-secondary::before {
        content:'';
        position:absolute;
        inset:0;
        background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);
        background-size:200% 100%;
        opacity:0;
        transition:opacity .25s;
    }
    .btn-primary:hover::before, .btn-secondary:hover::before {
        opacity:1;
        animation:shimmer .6s ease forwards;
    }
    .btn-primary {
        background:linear-gradient(135deg,var(--gold),#a87d45);
        color:#0d0f14;
        box-shadow:0 4px 18px rgba(201,169,110,.28);
    }
    .btn-primary:hover {
        transform:translateY(-2px) scale(1.02);
        box-shadow:0 8px 28px rgba(201,169,110,.42);
    }
    .btn-primary:active { transform:translateY(0) scale(.98); }

    .btn-secondary {
        background:var(--surface-2);
        color:var(--text);
        border:1px solid var(--border);
    }
    .btn-secondary:hover {
        transform:translateY(-2px) scale(1.02);
        border-color:var(--border-hover);
        box-shadow:0 6px 20px rgba(0,0,0,.28);
    }
    .btn-secondary:active { transform:translateY(0) scale(.98); }

    .btn-sm {
        padding:.42rem .9rem !important;
        font-size:.78rem !important;
    }
    .btn-icon-r { transition:transform .2s ease; }
    .btn-primary:hover .btn-icon-r,
    .btn-secondary:hover .btn-icon-r { transform:translateX(3px); }

    /* ── Search + filter bar ── */
    .qz-toolbar {
        display:flex;
        gap:.75rem;
        align-items:center;
        flex-wrap:wrap;
        z-index:1;
        position:relative;
        animation:fadeUp .55s var(--ease-out) .3s both;
    }
    .qz-search-wrap {
        position:relative;
        flex:1;
        min-width:200px;
    }
    .qz-search-icon {
        position:absolute;
        left:.9rem;
        top:50%;
        transform:translateY(-50%);
        color:var(--muted);
        font-size:.85rem;
        pointer-events:none;
    }
    .qz-search {
        width:100%;
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:10px;
        padding:.68rem 1rem .68rem 2.4rem;
        font-family:'DM Sans', sans-serif;
        font-size:.85rem;
        color:var(--text);
        outline:none;
        transition:border-color .2s, box-shadow .2s;
        box-sizing:border-box;
    }
    .qz-search::placeholder { color:var(--muted); }
    .qz-search:focus {
        border-color:rgba(201,169,110,.4);
        box-shadow:0 0 0 3px rgba(201,169,110,.08);
    }

    .qz-filter {
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:10px;
        padding:.68rem 1rem;
        font-family:'DM Sans', sans-serif;
        font-size:.82rem;
        color:var(--text);
        outline:none;
        cursor:pointer;
        transition:border-color .2s;
        appearance:none;
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7280'/%3E%3C/svg%3E");
        background-repeat:no-repeat;
        background-position:right .85rem center;
        padding-right:2.2rem;
    }
    .qz-filter:focus { border-color:rgba(201,169,110,.4); }

    /* ── Stats pills ── */
    .qz-pills {
        display:flex;
        gap:.6rem;
        flex-wrap:wrap;
        z-index:1;
        position:relative;
        animation:fadeIn .5s ease .4s both;
    }
    .qz-pill {
        display:inline-flex;
        align-items:center;
        gap:.4rem;
        padding:.35rem .9rem;
        border-radius:100px;
        font-size:.74rem;
        font-weight:500;
        letter-spacing:.03em;
        border:1px solid var(--border);
        background:var(--surface);
        color:var(--muted);
        transition:border-color .2s, color .2s;
        animation:badgePop .4s var(--ease-out) both;
    }
    .qz-pill:nth-child(1) { animation-delay:.45s; }
    .qz-pill:nth-child(2) { animation-delay:.55s; }
    .qz-pill:nth-child(3) { animation-delay:.65s; }
    .qz-pill-dot {
        width:6px; height:6px;
        border-radius:50%;
        flex-shrink:0;
    }
    .pill-total  .qz-pill-dot { background:var(--gold); }
    .pill-pub    .qz-pill-dot { background:var(--green); }
    .pill-draft  .qz-pill-dot { background:var(--muted); }
    .pill-total  { color:var(--gold-light); border-color:rgba(201,169,110,.2); background:var(--gold-dim); }
    .pill-pub    { color:var(--green);      border-color:rgba(74,222,128,.2);  background:var(--green-dim); }

    /* ── Empty state ── */
    .qz-empty {
        background:var(--surface);
        border:1px dashed rgba(255,255,255,.12);
        border-radius:var(--radius);
        padding:3.5rem 2rem;
        text-align:center;
        color:var(--muted);
        font-size:.9rem;
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:1rem;
        z-index:1;
        position:relative;
        animation:fadeUp .6s var(--ease-out) .35s both;
    }
    .qz-empty-icon {
        font-size:2.8rem;
        opacity:.4;
        animation:fadeIn .5s ease .5s both;
    }
    .qz-empty h4 {
        font-family:'Playfair Display', serif;
        font-size:1.1rem;
        margin:0;
        color:var(--text);
        opacity:.6;
    }
    .qz-empty p { margin:0; font-size:.82rem; }

    /* ── Table panel ── */
    .qz-panel {
        background:var(--surface);
        border:1px solid var(--border);
        border-radius:var(--radius-lg);
        overflow:hidden;
        position:relative;
        z-index:1;
        animation:fadeUp .65s var(--ease-out) .35s both;
        transition:border-color .25s;
    }
    .qz-panel:hover { border-color:var(--border-hover); }

    /* ── Table ── */
    .qz-table {
        width:100%;
        border-collapse:collapse;
        font-size:.85rem;
    }
    .qz-table thead tr {
        background:var(--surface-2);
        border-bottom:1px solid var(--border);
    }
    .qz-table thead th {
        padding:.85rem 1.2rem;
        text-align:left;
        font-size:.7rem;
        font-weight:500;
        letter-spacing:.1em;
        text-transform:uppercase;
        color:var(--muted);
        white-space:nowrap;
        user-select:none;
        cursor:pointer;
        transition:color .2s;
        position:relative;
    }
    .qz-table thead th:hover { color:var(--gold-light); }
    .qz-table thead th.sorted { color:var(--gold); }
    .qz-table thead th.sorted::after {
        content:' ↑';
        font-size:.65rem;
    }

    /* row animations */
    .qz-table tbody tr {
        border-bottom:1px solid var(--border);
        transition:background .2s ease, transform .2s var(--ease-out);
        animation:rowReveal .4s var(--ease-out) both;
    }
    .qz-table tbody tr:last-child { border-bottom:none; }
    .qz-table tbody tr:hover {
        background:var(--surface-2);
    }

    @for ($i = 1; $i <= 20; $i++)
    .qz-table tbody tr:nth-child({{ $i }}) { animation-delay:{{ 0.38 + ($i - 1) * 0.055 }}s; }
    @endfor

    .qz-table td {
        padding:.9rem 1.2rem;
        color:var(--text);
        vertical-align:middle;
        white-space:nowrap;
    }

    /* Title cell */
    .qz-title-cell {
        display:flex;
        align-items:center;
        gap:.75rem;
    }
    .qz-title-icon {
        width:34px; height:34px;
        border-radius:8px;
        background:var(--gold-dim);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:.95rem;
        flex-shrink:0;
        transition:transform .2s var(--ease-out), background .2s;
    }
    .qz-table tbody tr:hover .qz-title-icon {
        background:rgba(201,169,110,.22);
        transform:scale(1.1) rotate(-4deg);
    }
    .qz-title-name {
        font-weight:500;
        color:var(--text);
        max-width:220px;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    /* Module / Course cell */
    .qz-meta-chip {
        display:inline-block;
        padding:.22rem .7rem;
        border-radius:100px;
        background:var(--surface-3);
        border:1px solid var(--border);
        font-size:.74rem;
        color:var(--muted);
        max-width:160px;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
        transition:border-color .2s, color .2s;
    }
    .qz-table tbody tr:hover .qz-meta-chip {
        border-color:rgba(255,255,255,.14);
        color:var(--text);
    }
    .qz-dash { color:var(--muted); opacity:.4; }

    /* Questions badge */
    .qz-q-badge {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:28px; height:24px;
        padding:0 .5rem;
        border-radius:6px;
        font-size:.75rem;
        font-weight:600;
        background:var(--accent-dim);
        color:#a0afff;
        border:1px solid rgba(61,90,255,.2);
        font-variant-numeric:tabular-nums;
    }

    /* Published badge */
    .qz-pub-badge {
        display:inline-flex;
        align-items:center;
        gap:.35rem;
        padding:.25rem .75rem;
        border-radius:100px;
        font-size:.72rem;
        font-weight:500;
    }
    .qz-pub-badge-dot {
        width:5px; height:5px;
        border-radius:50%;
        flex-shrink:0;
    }
    .qz-pub-yes {
        background:var(--green-dim);
        color:var(--green);
        border:1px solid rgba(74,222,128,.2);
    }
    .qz-pub-yes .qz-pub-badge-dot { background:var(--green); }
    .qz-pub-no {
        background:rgba(107,114,128,.1);
        color:var(--muted);
        border:1px solid rgba(107,114,128,.2);
    }
    .qz-pub-no .qz-pub-badge-dot { background:var(--muted); }

    /* Actions cell */
    .qz-actions-cell {
        display:flex;
        gap:.45rem;
        align-items:center;
    }

    /* ── Pagination ── */
    .qz-pagination {
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:1rem 1.5rem;
        border-top:1px solid var(--border);
        background:var(--surface-2);
        gap:1rem;
        flex-wrap:wrap;
    }
    .qz-pg-info {
        font-size:.76rem;
        color:var(--muted);
    }
    .qz-pg-links {
        display:flex;
        gap:.4rem;
    }
    .qz-pg-btn {
        width:30px; height:30px;
        border-radius:7px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:.78rem;
        font-weight:500;
        color:var(--muted);
        background:var(--surface);
        border:1px solid var(--border);
        text-decoration:none;
        transition:all .2s ease;
    }
    .qz-pg-btn:hover {
        background:var(--surface-3);
        color:var(--text);
        border-color:var(--border-hover);
    }
    .qz-pg-btn.active {
        background:var(--gold-dim);
        border-color:rgba(201,169,110,.3);
        color:var(--gold-light);
    }

    /* ── Responsive ── */
    @media (max-width:768px) {
        .qz-header {
            flex-direction:column;
            align-items:flex-start;
        }
        .qz-table td, .qz-table th { padding:.75rem .9rem; }
        .col-course { display:none; }
    }
    @media (max-width:560px) {
        .col-module { display:none; }
    }
</style>

{{-- ===================== MARKUP ===================== --}}
<div class="qz-wrap">

    {{-- ── HEADER ── --}}
    <div class="qz-header" aria-label="Quiz library header">
        <div class="qz-header-left">
            <p class="qz-eyebrow"><span class="qz-eyebrow-dot"></span> Instructor tools</p>
            <h2>Quiz library</h2>
            <p>Review and manage quizzes for your modules.</p>
        </div>
        <a href="{{ route('teacher.quizzes.create') }}" class="btn-primary" style="animation:fadeUp .6s var(--ease-out) .4s both; flex-shrink:0;">
            + Create quiz <span class="btn-icon-r">→</span>
        </a>
    </div>

    @php
        $total     = $quizzes->total()     ?? $quizzes->count();
        $published = $quizzes->filter(fn($q) => $q->is_published)->count();
        $drafts    = $total - $published;
    @endphp

    {{-- ── PILLS ── --}}
    <div class="qz-pills">
        <span class="qz-pill pill-total"><span class="qz-pill-dot"></span> {{ $total }} total</span>
        <span class="qz-pill pill-pub"><span class="qz-pill-dot"></span> {{ $published }} published</span>
        <span class="qz-pill"><span class="qz-pill-dot" style="background:var(--muted)"></span> {{ $drafts }} draft</span>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="qz-toolbar">
        <div class="qz-search-wrap">
            <span class="qz-search-icon">🔍</span>
            <input
                type="text"
                id="qz-search-input"
                class="qz-search"
                placeholder="Search quizzes by title, module, or course…"
                aria-label="Search quizzes"
            >
        </div>
        <select class="qz-filter" id="qz-pub-filter" aria-label="Filter by status">
            <option value="all">All statuses</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    @if($quizzes->isEmpty())
        {{-- ── EMPTY STATE ── --}}
        <div class="qz-empty">
            <div class="qz-empty-icon">📋</div>
            <h4>No quizzes yet</h4>
            <p>Create your first quiz to start assessing your students.</p>
            <a href="{{ route('teacher.quizzes.create') }}" class="btn-primary" style="margin-top:.5rem;">
                + Create quiz <span class="btn-icon-r">→</span>
            </a>
        </div>
    @else
        {{-- ── TABLE PANEL ── --}}
        <div class="qz-panel">
            <div style="overflow-x:auto;">
                <table class="qz-table" id="qz-table" aria-label="Quiz list">
                    <thead>
                        <tr>
                            <th class="col-title" data-col="title">Title</th>
                            <th class="col-module" data-col="module">Module</th>
                            <th class="col-course" data-col="course">Course</th>
                            <th class="col-questions" data-col="questions">Questions</th>
                            <th class="col-status" data-col="status">Status</th>
                            <th class="col-actions" style="cursor:default;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="qz-tbody">
                        @foreach($quizzes as $quiz)
                            <tr
                                data-title="{{ strtolower($quiz->title) }}"
                                data-module="{{ strtolower(optional($quiz->module)->title ?? '') }}"
                                data-course="{{ strtolower(optional(optional($quiz->module)->course)->title ?? '') }}"
                                data-status="{{ $quiz->is_published ? 'published' : 'draft' }}"
                            >
                                {{-- Title --}}
                                <td class="col-title">
                                    <div class="qz-title-cell">
                                        <div class="qz-title-icon">📝</div>
                                        <span class="qz-title-name" title="{{ $quiz->title }}">{{ $quiz->title }}</span>
                                    </div>
                                </td>

                                {{-- Module --}}
                                <td class="col-module">
                                    @if(optional($quiz->module)->title)
                                        <span class="qz-meta-chip" title="{{ $quiz->module->title }}">{{ $quiz->module->title }}</span>
                                    @else
                                        <span class="qz-dash">—</span>
                                    @endif
                                </td>

                                {{-- Course --}}
                                <td class="col-course">
                                    @if(optional(optional($quiz->module)->course)->title)
                                        <span class="qz-meta-chip" title="{{ $quiz->module->course->title }}">{{ $quiz->module->course->title }}</span>
                                    @else
                                        <span class="qz-dash">—</span>
                                    @endif
                                </td>

                                {{-- Questions --}}
                                <td class="col-questions">
                                    <span class="qz-q-badge">{{ $quiz->questions_count ?? 0 }}</span>
                                </td>

                                {{-- Status --}}
                                <td class="col-status">
                                    @if($quiz->is_published)
                                        <span class="qz-pub-badge qz-pub-yes">
                                            <span class="qz-pub-badge-dot"></span> Published
                                        </span>
                                    @else
                                        <span class="qz-pub-badge qz-pub-no">
                                            <span class="qz-pub-badge-dot"></span> Draft
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="col-actions">
                                    <div class="qz-actions-cell">
                                        <a href="{{ route('teacher.quizzes.show', $quiz) }}" class="btn-secondary btn-sm">View</a>
                                        <a href="{{ route('teacher.quizzes.edit', $quiz) }}" class="btn-primary btn-sm">Edit <span class="btn-icon-r">→</span></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($quizzes instanceof \Illuminate\Pagination\LengthAwarePaginator && $quizzes->hasPages())
                <div class="qz-pagination">
                    <span class="qz-pg-info">
                        Showing {{ $quizzes->firstItem() }}–{{ $quizzes->lastItem() }} of {{ $quizzes->total() }} quizzes
                    </span>
                    <div class="qz-pg-links">
                        {{-- Previous --}}
                        @if($quizzes->onFirstPage())
                            <span class="qz-pg-btn" style="opacity:.35; cursor:default;">‹</span>
                        @else
                            <a href="{{ $quizzes->previousPageUrl() }}" class="qz-pg-btn">‹</a>
                        @endif

                        {{-- Page numbers --}}
                        @foreach($quizzes->getUrlRange(1, $quizzes->lastPage()) as $page => $url)
                            <a href="{{ $url }}" class="qz-pg-btn {{ $page == $quizzes->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        @endforeach

                        {{-- Next --}}
                        @if($quizzes->hasMorePages())
                            <a href="{{ $quizzes->nextPageUrl() }}" class="qz-pg-btn">›</a>
                        @else
                            <span class="qz-pg-btn" style="opacity:.35; cursor:default;">›</span>
                        @endif
                    </div>
                </div>
            @endif

        </div>{{-- /qz-panel --}}

        {{-- No results (after client filter) --}}
        <div id="qz-no-results" style="display:none;" class="qz-empty">
            <div class="qz-empty-icon">🔍</div>
            <h4>No matching quizzes</h4>
            <p>Try a different search term or status filter.</p>
        </div>

    @endif

</div>{{-- /qz-wrap --}}

{{-- ===================== SCRIPTS ===================== --}}
<script>
(function () {
    const searchInput = document.getElementById('qz-search-input');
    const pubFilter   = document.getElementById('qz-pub-filter');
    const tbody       = document.getElementById('qz-tbody');
    const noResults   = document.getElementById('qz-no-results');
    if (!searchInput || !tbody) return;

    function filterTable() {
        const q      = searchInput.value.toLowerCase().trim();
        const status = pubFilter ? pubFilter.value : 'all';
        const rows   = tbody.querySelectorAll('tr');
        let visible  = 0;

        rows.forEach(row => {
            const title  = row.dataset.title   || '';
            const module = row.dataset.module  || '';
            const course = row.dataset.course  || '';
            const rStatus= row.dataset.status  || '';

            const matchQ = !q || title.includes(q) || module.includes(q) || course.includes(q);
            const matchS = status === 'all' || rStatus === status;

            if (matchQ && matchS) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResults) {
            noResults.style.display = visible === 0 ? 'flex' : 'none';
        }
    }

    searchInput.addEventListener('input', filterTable);
    if (pubFilter) pubFilter.addEventListener('change', filterTable);
})();
</script>

@endsection