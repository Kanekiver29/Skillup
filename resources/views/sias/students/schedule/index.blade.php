@extends('sias.students.layout.master')

@section('title', 'Class Schedule')
@section('page_title', 'Class Schedule')

@section('content')
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .sch-page { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --accent:#3b82f6; --ease:cubic-bezier(.22,1,.36,1); }

    /* ── Animations ─────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .anim { opacity:0; animation:fadeUp .4s var(--ease) forwards; }

    /* ── Print button ────────────────────────────────── */
    .btn-print {
        display:inline-flex; align-items:center; gap:.45rem;
        padding:.65rem 1.25rem; border-radius:999px;
        background:#0f172a; color:#fff; font-size:.88rem; font-weight:600;
        border:none; cursor:pointer;
        transition:background .15s ease, transform .12s ease, box-shadow .12s ease;
    }
    .btn-print:hover { background:#1e293b; transform:translateY(-1px); box-shadow:0 6px 16px -8px rgba(15,23,42,.5); }
    .btn-print:active { transform:translateY(0); }
    .btn-print svg { width:15px; height:15px; }

    /* ── Section headers ─────────────────────────────── */
    .sch-section-title { font-size:.85rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
        color:var(--ink); margin:1.8rem 0 .75rem; display:flex; align-items:center; gap:.5rem; }
    .sch-section-title::after { content:''; flex:1; height:1px; background:var(--line); }

    /* ── Schedule Card ───────────────────────────────── */
    .sch-card { background:#fff; border:1px solid var(--line); border-radius:14px; padding:1.25rem;
        transition:border-color .15s ease, box-shadow .15s ease; display:flex; gap:1.25rem; align-items:flex-start; margin-bottom:1rem; }
    .sch-card:hover { border-color:#cbd5e1; box-shadow:0 4px 12px -6px rgba(15,23,42,.05); }
    
    .sch-time { min-width:140px; text-align:right; border-right:2px solid var(--line); padding-right:1.25rem; }
    .sch-time .time { font-size:1.15rem; font-weight:800; color:var(--ink); line-height:1.2; }
    .sch-time .duration { font-size:.78rem; font-weight:600; color:var(--muted); margin-top:.25rem; text-transform:uppercase; letter-spacing:.05em; }
    
    .sch-details { flex:1; }
    .sch-details .subject { font-size:1.1rem; font-weight:700; color:var(--ink); margin-bottom:.35rem; line-height:1.3; }
    .sch-details .course { font-size:.85rem; font-weight:600; color:var(--accent); margin-bottom:.5rem; }
    
    .sch-meta { display:flex; flex-wrap:wrap; gap:1rem; margin-top:.75rem; font-size:.85rem; color:var(--sub); }
    .sch-meta-item { display:flex; align-items:center; gap:.35rem; }
    .sch-meta-item svg { width:14px; height:14px; opacity:.6; }

    /* ── Empty state ─────────────────────────────────── */
    .sch-empty { padding:3rem 1rem; text-align:center; color:var(--muted); font-size:.95rem; background:#fff; border:1px dashed var(--line); border-radius:14px; }
    .sch-empty svg { width:45px; height:45px; margin:0 auto 1rem; opacity:.3; display:block; }

    /* ── Print styles ────────────────────────────────── */
    @media print {
        .no-print, .page-header-actions, .nav-panel, nav, .btn-print, aside, header { display:none !important; }
        .page-card { box-shadow:none !important; border:none !important; padding:0 !important; }
        .sch-card { border:1px solid #ccc !important; break-inside:avoid; page-break-inside:avoid; box-shadow:none !important; margin-bottom:1rem !important; }
        .sch-page { gap:.5rem !important; }
        body { background:#fff !important; }
        .print-header { display:block !important; }
        .sch-time { min-width:110px; }
    }
    .print-header { display:none; }
</style>

<div class="sch-page" style="display:grid;gap:1.2rem;">

    {{-- ── Print header (only visible when printing) ── --}}
    <div class="print-header" style="border-bottom:2px solid #0f172a;padding-bottom:.75rem;margin-bottom:.5rem;">
        <strong style="font-size:1.1rem;">{{ $user->name ?? 'Student' }}</strong> &mdash;
        Class Schedule &mdash; Printed {{ now()->format('F d, Y') }}
    </div>

    {{-- ── Top bar ── --}}
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;" class="no-print anim" style="animation-delay:.02s;">
        <p style="color:var(--sub);margin:0;font-size:.95rem;">
            View your upcoming classes and timetable.
        </p>
        <button class="btn-print" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print / Save PDF
        </button>
    </div>

    @if(empty($orderedSchedules))
        <div class="sch-empty anim" style="animation-delay:.06s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            No active class schedules found for your enrolled courses.
        </div>
    @else
        @php $delay = 0.06; @endphp
        @foreach($orderedSchedules as $day => $schedules)
            <div class="anim" style="animation-delay:{{ $delay }}s;">
                <div class="sch-section-title">{{ $day }}</div>
                
                @foreach($schedules as $schedule)
                    @php
                        $start = \Carbon\Carbon::parse($schedule->start_time);
                        $end = \Carbon\Carbon::parse($schedule->end_time);
                        $duration = $start->diffInMinutes($end);
                    @endphp
                    <div class="sch-card">
                        <div class="sch-time">
                            <div class="time">{{ $start->format('g:i A') }}</div>
                            <div class="duration">to {{ $end->format('g:i A') }} ({{ $duration }}m)</div>
                        </div>
                        <div class="sch-details">
                            <div class="subject">{{ $schedule->subject_name ?: ($schedule->course->title ?? 'Untitled Class') }}</div>
                            <div class="course">{{ $schedule->course->title ?? '' }}</div>
                            
                            <div class="sch-meta">
                                @if($schedule->room_number)
                                <div class="sch-meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $schedule->room_number }}{{ $schedule->building ? ', ' . $schedule->building : '' }}
                                </div>
                                @endif
                                
                                @if($schedule->teacher)
                                <div class="sch-meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ $schedule->teacher->name }}
                                </div>
                                @endif
                            </div>
                            
                            @if($schedule->notes)
                            <div style="margin-top:.75rem; font-size:.8rem; color:var(--muted); font-style:italic;">
                                Note: {{ $schedule->notes }}
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @php $delay += 0.04; @endphp
        @endforeach
    @endif

</div>
@endsection
