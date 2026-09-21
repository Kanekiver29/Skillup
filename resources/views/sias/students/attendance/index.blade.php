@extends('sias.students.layout.master')

@section('title', 'Attendance Tracking')
@section('page_title', 'Attendance Tracking')

@section('content')
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .att-page { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --pass:#16a34a; --fail:#dc2626; --warn:#d97706;
               --accent:#3b82f6; --ease:cubic-bezier(.22,1,.36,1); }

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

    /* ── Stats bar ───────────────────────────────────── */
    .att-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-top:1rem; }
    .att-stat { background:#fff; border:1px solid var(--line); border-radius:14px; padding:1.25rem; text-align:center; }
    .att-stat .label { font-size:.75rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); }
    .att-stat .value { font-size:2.2rem; font-weight:800; color:var(--ink); line-height:1.2; margin-top:.4rem; }
    .att-stat .value.pass { color:var(--pass); }
    .att-stat .value.warn { color:var(--warn); }
    .att-stat .value.fail { color:var(--fail); }

    /* ── Section headers ─────────────────────────────── */
    .att-section-title { font-size:.85rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
        color:var(--ink); margin:2rem 0 .75rem; display:flex; align-items:center; gap:.5rem; }
    .att-section-title::after { content:''; flex:1; height:1px; background:var(--line); }

    /* ── Progress Bar ────────────────────────────────── */
    .prog-wrap { display:flex; align-items:center; gap:.6rem; min-width:140px; }
    .prog-bar { flex:1; height:6px; border-radius:99px; background:#e2e8f0; overflow:hidden; }
    .prog-fill { height:100%; border-radius:99px; transition:width .4s var(--ease); }
    .prog-fill.pass { background:var(--pass); }
    .prog-fill.warn { background:var(--warn); }
    .prog-fill.fail { background:var(--fail); }
    .prog-pct { font-size:.82rem; font-weight:700; min-width:42px; text-align:right; }
    .prog-pct.pass { color:var(--pass); }
    .prog-pct.warn { color:var(--warn); }
    .prog-pct.fail { color:var(--fail); }

    /* ── Card & Table ────────────────────────────────── */
    .att-card { background:#fff; border:1px solid var(--line); border-radius:14px; overflow:hidden; }
    .att-table { width:100%; border-collapse:collapse; text-align:left; }
    .att-table th { padding:.85rem 1.1rem; font-size:.75rem; font-weight:700; letter-spacing:.06em;
        text-transform:uppercase; color:var(--muted); background:#f8fafc; border-bottom:1px solid var(--line); }
    .att-table td { padding:1.1rem; border-bottom:1px solid var(--line); vertical-align:middle; font-size:.9rem; }
    .att-table tbody tr:last-child td { border-bottom:none; }
    .att-table tbody tr:hover { background:#f8fafc; }
    
    .att-table .subject-col { font-weight:600; color:var(--ink); font-size:.95rem; }
    .att-table .code-col { font-size:.8rem; color:var(--sub); margin-top:.2rem; }
    
    .badge { display:inline-flex; align-items:center; padding:.22rem .6rem; border-radius:999px; font-size:.72rem; font-weight:700; }
    .badge.gray { background:#f1f5f9; color:#475569; }
    .badge.green { background:#dcfce7; color:#15803d; }
    .badge.red { background:#fee2e2; color:#b91c1c; }

    /* ── Empty state ─────────────────────────────────── */
    .att-empty { padding:3.5rem 1rem; text-align:center; color:var(--muted); font-size:.95rem; background:#fff; border:1px dashed var(--line); border-radius:14px; }
    .att-empty svg { width:45px; height:45px; margin:0 auto 1rem; opacity:.3; display:block; }

    /* ── Print styles ────────────────────────────────── */
    @media print {
        .no-print, .page-header-actions, .nav-panel, nav, .btn-print, aside, header { display:none !important; }
        .page-card { box-shadow:none !important; border:none !important; padding:0 !important; }
        .att-card, .att-stat { border:1px solid #ccc !important; break-inside:avoid; }
        body { background:#fff !important; }
        .print-header { display:block !important; margin-bottom:1.5rem !important; }
    }
    .print-header { display:none; }
</style>

<div class="att-page" style="display:grid;gap:1.2rem;">

    {{-- ── Print header (only visible when printing) ── --}}
    <div class="print-header" style="border-bottom:2px solid #0f172a;padding-bottom:.75rem;">
        <strong style="font-size:1.1rem;">{{ $user->name ?? 'Student' }}</strong> &mdash;
        Attendance Report &mdash; Printed {{ now()->format('F d, Y') }}
    </div>

    {{-- ── Top bar ── --}}
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;" class="no-print anim" style="animation-delay:.02s;">
        <p style="color:var(--sub);margin:0;font-size:.95rem;">
            Track your class attendance and overall presence rate.
        </p>
        <button class="btn-print" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print / Save PDF
        </button>
    </div>

    @if(!$hasAttendanceTable)
        <div class="att-empty anim" style="animation-delay:.06s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            Attendance tracking module is currently not installed or activated.
        </div>
    @else
        {{-- ── Summary Stats ── --}}
        <div class="att-stats anim" style="animation-delay:.06s;">
            <div class="att-stat">
                <div class="label">Overall Attendance</div>
                @php
                    $rateClass = '';
                    if ($overallRate !== null) {
                        if ($overallRate >= 90) $rateClass = 'pass';
                        elseif ($overallRate >= 75) $rateClass = 'warn';
                        else $rateClass = 'fail';
                    }
                @endphp
                <div class="value {{ $rateClass }}">
                    {{ $overallRate !== null ? $overallRate . '%' : '—' }}
                </div>
            </div>
            <div class="att-stat">
                <div class="label">Total Classes</div>
                <div class="value" style="color:var(--accent);">{{ $overallTotal }}</div>
            </div>
            <div class="att-stat">
                <div class="label">Classes Attended</div>
                <div class="value">{{ $overallPresent }}</div>
            </div>
        </div>

        {{-- ── Attendance Table ── --}}
        <div class="anim" style="animation-delay:.1s;">
            <div class="att-section-title">Subject Attendance Breakdown</div>
            
            <div class="att-card" style="overflow-x:auto;">
                @if($attendanceData->count())
                    <table class="att-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Instructor</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>
                                <th style="width:25%;">Attendance Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceData as $row)
                            <tr>
                                <td>
                                    <div class="subject-col">{{ $row['course_title'] }}</div>
                                    <div class="code-col">{{ strtoupper($row['course_code']) }}</div>
                                </td>
                                <td style="color:var(--sub);">{{ $row['instructor'] }}</td>
                                <td><span class="badge {{ $row['present'] > 0 ? 'green' : 'gray' }}">{{ $row['present'] }}</span></td>
                                <td><span class="badge {{ $row['absent'] > 0 ? 'red' : 'gray' }}">{{ $row['absent'] }}</span></td>
                                <td><span class="badge {{ $row['late'] > 0 ? 'warn' : 'gray' }}">{{ $row['late'] }}</span></td>
                                <td>
                                    @if($row['total'] > 0)
                                        @php
                                            $rc = $row['rate'] >= 90 ? 'pass' : ($row['rate'] >= 75 ? 'warn' : 'fail');
                                        @endphp
                                        <div class="prog-wrap">
                                            <div class="prog-bar">
                                                <div class="prog-fill {{ $rc }}" style="width:{{ $row['rate'] }}%"></div>
                                            </div>
                                            <span class="prog-pct {{ $rc }}">{{ $row['rate'] }}%</span>
                                        </div>
                                    @else
                                        <span style="color:var(--muted);font-size:.85rem;">No classes yet</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="padding:3rem 1rem; text-align:center; color:var(--muted); font-size:.95rem;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:45px; height:45px; margin:0 auto 1rem; opacity:.3; display:block;">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                        </svg>
                        No attendance records available for your enrolled subjects.
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection
