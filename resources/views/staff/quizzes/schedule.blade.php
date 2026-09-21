@extends('staff.layouts.masters')

@section('title', 'Assessment Schedule')

@section('content')
<style>
    .assessment-page { max-width: 1280px; margin: 0 auto; padding: .4rem 0 2rem; }

    .assessment-header { display:flex; align-items:flex-end; justify-content:space-between; gap:1rem; margin-bottom:1.5rem; }
    .assessment-kicker { color:#2563eb; font:600 .7rem/1 var(--font-mono); letter-spacing:.14em; text-transform:uppercase; margin-bottom:.6rem; }
    .assessment-title { color:#0b1526; font:700 clamp(1.65rem, 3vw, 2.35rem)/1.1 var(--font-display); margin:0; }
    .assessment-subtitle { color:#5a6f92; font-size:.9rem; margin:.55rem 0 0; }

    .assessment-action { display:inline-flex; align-items:center; gap:.45rem; background:#2563eb; border:1px solid #2563eb; border-radius:.55rem; color:#fff; font-size:.82rem; font-weight:700; padding:.7rem 1rem; white-space:nowrap; transition:background .2s, transform .2s; text-decoration:none; }
    .assessment-action:hover { background:#1d4ed8; transform:translateY(-1px); }
    .assessment-action:focus-visible { outline:2px solid #93c5fd; outline-offset:2px; }
    .assessment-action svg { flex-shrink:0; }

    .assessment-stats { display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:.85rem; margin-bottom:1rem; }
    .assessment-stat { background:rgba(255,255,255,.86); border:1px solid #dbe5f7; border-radius:.75rem; padding:1rem 1.1rem; box-shadow:0 6px 20px rgba(30,64,175,.06); }
    .assessment-stat-label { color:#5a6f92; font-size:.72rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase; }
    .assessment-stat-value { color:#0b1526; font:700 1.5rem/1.1 var(--font-display); margin-top:.35rem; }

    .assessment-panel { background:rgba(255,255,255,.92); border:1px solid #dbe5f7; border-radius:.85rem; box-shadow:0 12px 30px rgba(30,64,175,.08); overflow:hidden; }
    .assessment-panel-head { align-items:center; display:flex; justify-content:space-between; gap:1rem; padding:1rem 1.2rem; border-bottom:1px solid #e5edf9; }
    .assessment-panel-title { color:#0b1526; font:700 1rem var(--font-display); }
    .assessment-panel-note { color:#6b7f9f; font-size:.78rem; }

    .assessment-table-wrap { overflow-x:auto; -webkit-overflow-scrolling:touch; }
    .assessment-table { border-collapse:collapse; min-width:720px; table-layout:fixed; width:100%; }
    .assessment-table th:nth-child(1), .assessment-table td:nth-child(1) { width:21%; }
    .assessment-table th:nth-child(2), .assessment-table td:nth-child(2) { width:24%; }
    .assessment-table th:nth-child(3), .assessment-table td:nth-child(3) { width:25%; }
    .assessment-table th:nth-child(4), .assessment-table td:nth-child(4) { width:17%; }
    .assessment-table th:nth-child(5), .assessment-table td:nth-child(5) { width:13%; }
    .assessment-table th { background:#f5f8fe; color:#5a6f92; font-size:.68rem; font-weight:800; letter-spacing:.08em; padding:.8rem 1.2rem; text-align:left; text-transform:uppercase; white-space:nowrap; }
    .assessment-table td { border-top:1px solid #e8eef8; color:#263957; font-size:.84rem; overflow-wrap:anywhere; padding:1rem 1.2rem; vertical-align:middle; }
    .assessment-table tbody tr { transition:background .18s; }
    .assessment-table tbody tr:hover { background:#f8fbff; }

    .assessment-name { color:#0b1526; font-weight:700; display:block; max-width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .assessment-muted { color:#6b7f9f; }
    .assessment-unscheduled { color:#9a6500; font-style:italic; }

    .assessment-badge { border-radius:999px; display:inline-flex; align-items:center; font-size:.7rem; font-weight:800; padding:.3rem .6rem; white-space:nowrap; }
    .assessment-badge--published { background:#e9fbf2; color:#087443; }
    .assessment-badge--draft { background:#fff7df; color:#9a6500; }

    .assessment-empty { align-items:center; color:#6b7f9f; display:flex; flex-direction:column; gap:.6rem; padding:3rem 1.2rem; text-align:center; }
    .assessment-empty svg { color:#c3d3ee; }
    .assessment-empty-title { color:#0b1526; font-weight:700; font-size:.95rem; }
    .assessment-empty-subtitle { font-size:.82rem; max-width:26rem; }

    @media (max-width: 900px) {
        .assessment-stats { grid-template-columns:repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 700px) {
        .assessment-header { align-items:flex-start; flex-direction:column; }
        .assessment-action { justify-content:center; width:100%; }
    }

    @media (max-width: 480px) {
        .assessment-stats { grid-template-columns:1fr; }
    }
</style>

<div class="assessment-page">
    <div class="assessment-header">
        <div>
            <div class="assessment-kicker">Assessment monitoring</div>
            <h1 class="assessment-title">Assessment Schedule</h1>
            <p class="assessment-subtitle">Review upcoming and unscheduled assessments.</p>
        </div>
        <a href="{{ route('staff.quizzes.create') }}" class="assessment-action">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" aria-hidden="true">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Create assessment
        </a>
    </div>

    @php
        $totalCount = $quizzes->count();
        $scheduledCount = $quizzes->filter(fn ($quiz) => $quiz->scheduled_at)->count();
        $publishedCount = $quizzes->where('is_published', true)->count();
        $draftCount = $totalCount - $publishedCount;
    @endphp

    <div class="assessment-stats">
        <div class="assessment-stat">
            <div class="assessment-stat-label">Active assessments</div>
            <div class="assessment-stat-value">{{ $totalCount }}</div>
        </div>
        <div class="assessment-stat">
            <div class="assessment-stat-label">Scheduled</div>
            <div class="assessment-stat-value">{{ $scheduledCount }}</div>
        </div>
        <div class="assessment-stat">
            <div class="assessment-stat-label">Published</div>
            <div class="assessment-stat-value">{{ $publishedCount }}</div>
        </div>
        <div class="assessment-stat">
            <div class="assessment-stat-label">Draft</div>
            <div class="assessment-stat-value">{{ $draftCount }}</div>
        </div>
    </div>

    <section class="assessment-panel" aria-labelledby="assessment-panel-heading">
        <div class="assessment-panel-head">
            <div class="assessment-panel-title" id="assessment-panel-heading">Active assessments</div>
            <div class="assessment-panel-note">{{ $totalCount }} total</div>
        </div>

        @if($quizzes->isEmpty())
            <div class="assessment-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="16" rx="2" />
                    <path d="M3 9h18M8 2v4M16 2v4" />
                </svg>
                <div class="assessment-empty-title">No assessments yet</div>
                <div class="assessment-empty-subtitle">Once you create an assessment, it will show up here with its schedule and publish status.</div>
            </div>
        @else
            <div class="assessment-table-wrap">
                <table class="assessment-table">
                    <caption class="sr-only">List of active assessments with course, schedule, passing score, and status</caption>
                    <thead>
                        <tr>
                            <th scope="col">Assessment</th>
                            <th scope="col">Course / subject</th>
                            <th scope="col">Scheduled for</th>
                            <th scope="col">Passing score</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                            <tr>
                                <td>
                                    <span class="assessment-name" title="{{ $quiz->title }}">{{ $quiz->title }}</span>
                                </td>
                                <td class="assessment-muted">
                                    {{ $quiz->module?->course?->title ?? $quiz->subject?->title ?? 'Unassigned' }}
                                </td>
                                <td>
                                    @if($quiz->scheduled_at)
                                        {{ $quiz->scheduled_at->format('M j, Y g:i A') }}
                                    @else
                                        <span class="assessment-unscheduled">Not scheduled</span>
                                    @endif
                                </td>
                                <td>{{ $quiz->passing_score !== null ? $quiz->passing_score . '%' : '—' }}</td>
                                <td>
                                    <span class="assessment-badge {{ $quiz->is_published ? 'assessment-badge--published' : 'assessment-badge--draft' }}">
                                        {{ $quiz->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
@endsection