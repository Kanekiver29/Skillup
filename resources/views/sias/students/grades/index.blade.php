@extends('sias.students.layout.master')

@section('title', 'My Grades')
@section('page_title', 'My Grades')

@section('content')
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .grd-page { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
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
    .grd-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-top:1rem; }
    .grd-stat { background:#fff; border:1px solid var(--line); border-radius:14px; padding:1.25rem; text-align:center; }
    .grd-stat .label { font-size:.75rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); }
    .grd-stat .value { font-size:2rem; font-weight:800; color:var(--ink); line-height:1.2; margin-top:.4rem; }
    .grd-stat .value.pass { color:var(--pass); }
    .grd-stat .value.accent { color:var(--accent); }

    /* ── Section headers ─────────────────────────────── */
    .grd-section-title { font-size:.85rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase;
        color:var(--ink); margin:2rem 0 .75rem; display:flex; align-items:center; gap:.5rem; }
    .grd-section-title::after { content:''; flex:1; height:1px; background:var(--line); }

    /* ── Card & Table ────────────────────────────────── */
    .grd-card { background:#fff; border:1px solid var(--line); border-radius:14px; overflow:hidden; }
    .grd-table { width:100%; border-collapse:collapse; text-align:left; }
    .grd-table th { padding:.85rem 1.1rem; font-size:.75rem; font-weight:700; letter-spacing:.06em;
        text-transform:uppercase; color:var(--muted); background:#f8fafc; border-bottom:1px solid var(--line); }
    .grd-table td { padding:1rem 1.1rem; border-bottom:1px solid var(--line); vertical-align:middle; font-size:.9rem; }
    .grd-table tbody tr:last-child td { border-bottom:none; }
    .grd-table tbody tr:hover { background:#f8fafc; }
    
    .grd-table .subject-col { font-weight:600; color:var(--ink); }
    .grd-table .code-col { font-size:.8rem; color:var(--sub); margin-top:.2rem; }
    
    .badge { display:inline-flex; align-items:center; padding:.22rem .6rem; border-radius:999px; font-size:.72rem; font-weight:700; }
    .badge.pass { background:#dcfce7; color:#15803d; }
    .badge.fail { background:#fee2e2; color:#b91c1c; }
    .badge.inc { background:#fef3c7; color:#b45309; }
    
    .grade-val { font-weight:800; font-size:1.05rem; }
    .grade-val.pass { color:var(--pass); }
    .grade-val.fail { color:var(--fail); }

    /* ── Print styles ────────────────────────────────── */
    @media print {
        .no-print, .page-header-actions, .nav-panel, nav, .btn-print, aside, header { display:none !important; }
        .page-card { box-shadow:none !important; border:none !important; padding:0 !important; }
        .grd-card, .grd-stat { border:1px solid #ccc !important; break-inside:avoid; }
        body { background:#fff !important; }
        .print-header { display:block !important; margin-bottom:1.5rem !important; }
    }
    .print-header { display:none; }
</style>

<div class="grd-page" style="display:grid;gap:1.2rem;">

    {{-- ── Print header (only visible when printing) ── --}}
    <div class="print-header" style="border-bottom:2px solid #0f172a;padding-bottom:.75rem;">
        <strong style="font-size:1.1rem;">{{ $user->name ?? 'Student' }}</strong> &mdash;
        Grade Report &mdash; Printed {{ now()->format('F d, Y') }}
    </div>

    {{-- ── Top bar ── --}}
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;" class="no-print anim" style="animation-delay:.02s;">
        <p style="color:var(--sub);margin:0;font-size:.95rem;">
            View your official grades and academic performance for the current term.
        </p>
        <button class="btn-print" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Print / Save PDF
        </button>
    </div>

    {{-- ── Summary Stats ── --}}
    <div class="grd-stats anim" style="animation-delay:.06s;">
        <div class="grd-stat">
            <div class="label">General Weighted Average</div>
            <div class="value {{ $gwa >= 75 ? 'pass' : 'fail' }}">
                {{ $gwa !== null ? number_format($gwa, 2) : '—' }}
            </div>
        </div>
        <div class="grd-stat">
            <div class="label">Total Units</div>
            <div class="value accent">{{ $totalUnits > 0 ? $totalUnits : '—' }}</div>
        </div>
        <div class="grd-stat">
            <div class="label">Earned Units</div>
            <div class="value">{{ $totalEarnedUnits > 0 ? $totalEarnedUnits : '—' }}</div>
        </div>
    </div>

    {{-- ── Grades Table ── --}}
    <div class="anim" style="animation-delay:.1s;">
        <div class="grd-section-title">Enrolled Subjects</div>
        
        <div class="grd-card" style="overflow-x:auto;">
            @if($enrollments->count())
                <table class="grd-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Instructor</th>
                            <th>Units</th>
                            <th>Final Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $row)
                        <tr>
                            <td>
                                <div class="subject-col">{{ $row['course_title'] }}</div>
                                <div class="code-col">{{ strtoupper($row['course_code']) }}</div>
                            </td>
                            <td style="color:var(--sub);">{{ $row['instructor'] }}</td>
                            <td>{{ number_format($row['units'], 1) }}</td>
                            <td>
                                @if(is_numeric($row['final_grade']))
                                    <span class="grade-val {{ $row['final_grade'] >= 75 ? 'pass' : 'fail' }}">
                                        {{ $row['final_grade'] }}
                                    </span>
                                @else
                                    <span class="grade-val" style="color:var(--muted);">
                                        {{ $row['final_grade'] ?: '—' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($row['remark']) {
                                        'Passed' => 'pass',
                                        'Failed' => 'fail',
                                        default => 'inc'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $row['remark'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding:3rem 1rem; text-align:center; color:var(--muted); font-size:.95rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:45px; height:45px; margin:0 auto 1rem; opacity:.3; display:block;">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    No academic records available for the current term.
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
