@extends('layout.Admin.system')

@section('title', 'Reports – SkillUp Admin')

@push('head')
<style>
    /* ══════════════════════════════════════════
       REPORTS PAGE — dark theme, matches the
       admin shell's tokens end to end.
    ══════════════════════════════════════════ */
    .rp-page { animation: cp-rise .45s cubic-bezier(.16,1,.3,1) both; }
    @keyframes cp-rise { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

    /* Header */
    .rp-header-wrap {
        background: var(--bg-surface);
        border-bottom: 1px solid var(--border-mid);
        margin: -30px -30px 28px;
        padding: 26px 30px;
    }
    .rp-header-inner {
        max-width: 1400px; margin: 0 auto;
        display: flex; align-items: flex-start; justify-content: space-between;
        gap: 20px; flex-wrap: wrap;
    }
    .rp-header-left { display: flex; align-items: flex-start; gap: 16px; }
    .rp-icon-badge {
        width: 46px; height: 46px; border-radius: var(--radius-sm);
        background: var(--accent-soft); border: 1px solid rgba(79,140,255,.22);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 2px;
    }
    .rp-icon-badge i { font-size: 19px; color: var(--accent); }
    .rp-breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-size: 11.5px; color: var(--text-muted); margin-bottom: 4px;
    }
    .rp-breadcrumb a { color: var(--text-muted); text-decoration: none; transition: color .15s; }
    .rp-breadcrumb a:hover { color: var(--accent); }
    .rp-breadcrumb .current { color: var(--text-secondary); font-weight: 600; }
    .rp-title {
        font-family: 'Syne', sans-serif; font-weight: 800; font-size: 27px;
        letter-spacing: -.4px; color: var(--text-primary); line-height: 1.15;
    }
    .rp-subtitle { font-size: 13px; color: var(--text-muted); margin-top: 4px; }

    .rp-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }
    .rp-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 99px;
        font-size: 12.5px; font-weight: 600; text-decoration: none; border: 1px solid transparent;
        cursor: pointer; font-family: 'Outfit', sans-serif;
        transition: transform .18s cubic-bezier(.34,1.56,.64,1), box-shadow .2s, filter .2s;
        white-space: nowrap;
    }
    .rp-btn:hover { transform: translateY(-2px); filter: brightness(1.07); }
    .rp-btn:active { transform: translateY(0); }
    .rp-btn-blue {
        background: linear-gradient(135deg, var(--accent-dark), var(--accent)); color: #fff;
        border-color: rgba(79,140,255,.4); box-shadow: 0 6px 18px rgba(79,140,255,.22);
    }
    .rp-btn-green {
        background: linear-gradient(135deg, #1fae82, var(--success)); color: #05261d;
        border-color: rgba(47,214,167,.4); box-shadow: 0 6px 18px rgba(47,214,167,.2);
    }
    .rp-btn-dark {
        background: var(--bg-input); color: var(--text-secondary);
        border-color: var(--border-strong); box-shadow: 0 6px 16px rgba(0,0,0,.3);
    }
    .rp-btn-dark:hover { color: var(--text-primary); background: var(--bg-card-hover); }

    /* Generic card */
    .rp-card {
        background: var(--bg-card); border: 1px solid var(--border-mid);
        border-radius: var(--radius); box-shadow: var(--shadow-drop), inset 0 1px 0 rgba(255,255,255,.03);
    }
    .rp-card-head {
        padding: 18px 22px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
    }
    .rp-card-title {
        font-size: 14.5px; font-weight: 700; color: var(--text-primary);
        display: flex; align-items: center; gap: 8px;
    }
    .rp-card-sub { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }
    .rp-link { font-size: 12px; font-weight: 600; color: var(--accent); text-decoration: none; transition: color .15s; }
    .rp-link:hover { color: #cfe1ff; }

    /* Stat cards */
    .rp-stats-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 26px;
    }
    @media (max-width: 1024px) { .rp-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px)  { .rp-stats-grid { grid-template-columns: 1fr; } }

    .rp-stat-card {
        padding: 20px; opacity: 0; animation: cp-row-in .4s cubic-bezier(.16,1,.3,1) forwards;
        transition: border-color .2s, transform .2s, box-shadow .2s;
    }
    .rp-stat-card:hover { transform: translateY(-2px); border-color: var(--border-strong); }
    .rp-stat-card:nth-child(1){animation-delay:.02s}
    .rp-stat-card:nth-child(2){animation-delay:.08s}
    .rp-stat-card:nth-child(3){animation-delay:.14s}
    .rp-stat-card:nth-child(4){animation-delay:.20s}
    @keyframes cp-row-in { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

    .rp-stat-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .rp-stat-label { font-size: 10.5px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: var(--text-muted); }
    .rp-stat-icon { width: 34px; height: 34px; border-radius: var(--radius-xs); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .rp-stat-icon i { font-size: 14px; }
    .rp-stat-icon.blue   { background: var(--accent-soft); }
    .rp-stat-icon.blue i { color: var(--accent); }
    .rp-stat-icon.violet   { background: rgba(155,140,247,.14); }
    .rp-stat-icon.violet i { color: var(--accent-2); }
    .rp-stat-icon.gold   { background: var(--gold-soft); }
    .rp-stat-icon.gold i { color: var(--gold); }
    .rp-stat-icon.green   { background: rgba(47,214,167,.14); }
    .rp-stat-icon.green i { color: var(--success); }

    .rp-stat-value { font-size: 30px; font-weight: 800; color: var(--text-primary); font-family: 'Syne', sans-serif; letter-spacing: -.5px; }
    .rp-stat-meta { font-size: 11.5px; color: var(--text-subtle); margin-top: 8px; }
    .rp-stat-positive { font-size: 11.5px; color: var(--success); font-weight: 600; margin-top: 4px; }

    .rp-progress-track { width: 100%; height: 6px; border-radius: 99px; background: rgba(255,255,255,.07); margin-top: 12px; overflow: hidden; }
    .rp-progress-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--success), #7ef0cf); transition: width .6s cubic-bezier(.16,1,.3,1); }

    /* Charts */
    .rp-charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; margin-bottom: 26px; }
    @media (max-width: 1024px) { .rp-charts-grid { grid-template-columns: 1fr; } }
    .rp-chart-body { padding: 18px 20px; }
    .rp-legend { display: flex; align-items: center; gap: 14px; font-size: 11.5px; color: var(--text-muted); flex-wrap: wrap; }
    .rp-legend span.dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; margin-right: 5px; }
    .rp-donut-legend { display: flex; align-items: center; gap: 20px; font-size: 12px; color: var(--text-secondary); margin-top: 10px; flex-wrap: wrap; justify-content: center; }

    /* Tables (shared) */
    .rp-table-wrap { overflow-x: auto; }
    .rp-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .rp-thead th {
        text-align: left; padding: 12px 20px; background: var(--bg-surface);
        border-bottom: 1px solid var(--border-mid); font-size: 10px; font-weight: 700;
        letter-spacing: .7px; text-transform: uppercase; color: var(--text-muted); white-space: nowrap;
    }
    .rp-thead th.rp-th-right { text-align: right; }
    .rp-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s ease; }
    .rp-table tbody tr:last-child { border-bottom: none; }
    .rp-table tbody tr:hover { background: var(--bg-card-hover); }
    .rp-table td { padding: 13px 20px; vertical-align: middle; }
    .rp-td-right { text-align: right; }

    .rp-cell-strong { font-weight: 600; color: var(--text-primary); }
    .rp-cell { color: var(--text-secondary); }
    .rp-cell-meta { color: var(--text-subtle); font-size: 11.5px; }
    .rp-rank { color: var(--text-subtle); font-weight: 700; }

    .rp-pill-done {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600;
        background: rgba(47,214,167,.14); color: var(--success); border: 1px solid rgba(47,214,167,.25);
    }
    .rp-progress-text { font-size: 12px; font-weight: 700; color: var(--text-secondary); }
    .rp-pill-count {
        display: inline-flex; align-items: center; padding: 3px 11px; border-radius: 99px;
        font-size: 11.5px; font-weight: 700; background: var(--accent-soft); color: var(--accent);
        border: 1px solid rgba(79,140,255,.22);
    }
    .rp-empty-row { text-align: center; padding: 32px 20px; color: var(--text-subtle); font-size: 13px; }

    /* Live monitor */
    .rp-live-status { display: flex; align-items: center; gap: 7px; font-size: 11.5px; font-weight: 700; color: var(--success); text-transform: uppercase; letter-spacing: .6px; }
    .rp-live-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--success); animation: pulse-dot 2.2s ease infinite; }
    .rp-live-meta { text-align: right; font-size: 11.5px; color: var(--text-muted); line-height: 1.5; }
    .rp-live-meta span { color: var(--text-secondary); font-weight: 600; }

    .rp-bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    @media (max-width: 900px) { .rp-bottom-grid { grid-template-columns: 1fr; } }

    @media print {
        .topbar, .sidebar, footer, .rp-actions, .sidebar-toggle-btn, .rp-icon-badge { display: none !important; }
        .main-content, .main-content.collapsed { margin-left: 0 !important; padding-top: 0 !important; }
        body { background: #fff !important; }
        .content-inner { padding: 0 !important; }
        .rp-header-wrap { background: #fff !important; margin: 0 0 18px !important; border-bottom: 1px solid #ddd !important; }
        .rp-title, .rp-stat-value, .rp-card-title, .rp-cell-strong { color: #111 !important; -webkit-text-fill-color: #111 !important; }
        .rp-card, .rp-stat-card { box-shadow: none !important; border: 1px solid #ddd !important; background: #fff !important; }
    }

    @media (prefers-reduced-motion: reduce) {
        .rp-page, .rp-stat-card { animation: none !important; opacity: 1 !important; }
        .rp-live-dot { animation: none !important; }
    }
</style>
@endpush

@section('content')
<div class="rp-page">

    {{-- ── Page Header ────────────────────────────────────────────────────── --}}
    <div class="rp-header-wrap">
        <div class="rp-header-inner">
            <div class="rp-header-left">
                <div class="rp-icon-badge"><i class="fas fa-chart-bar"></i></div>
                <div>
                    <nav class="rp-breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <i class="fas fa-chevron-right" style="font-size:9px;"></i>
                        <span class="current">Reports</span>
                    </nav>
                    <h1 class="rp-title">Platform Reports</h1>
                    <p class="rp-subtitle">Analytics snapshot as of {{ now()->format('F d, Y') }}</p>
                </div>
            </div>
            <div class="rp-actions">
                <a href="{{ route('admin.reports.export') }}" target="_blank" class="rp-btn rp-btn-blue">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>
                <a href="{{ route('admin.excel.export-enrollment') }}" target="_blank" class="rp-btn rp-btn-green">
                    <i class="fas fa-file-excel"></i> Download Excel
                </a>
                <button id="print-report-button" class="rp-btn rp-btn-dark">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
        </div>
    </div>

    {{-- ── Summary Stat Cards ─────────────────────────────────────────── --}}
    <section class="rp-stats-grid">

        <div class="rp-card rp-stat-card">
            <div class="rp-stat-head">
                <p class="rp-stat-label">Total Users</p>
                <div class="rp-stat-icon blue"><i class="fas fa-users"></i></div>
            </div>
            <p class="rp-stat-value">{{ number_format($totalUsers) }}</p>
            <p class="rp-stat-meta">
                {{ $totalAdmins }} admin{{ $totalAdmins !== 1 ? 's' : '' }} &bull;
                {{ number_format($totalStudents) }} student{{ $totalStudents !== 1 ? 's' : '' }}
            </p>
            <p class="rp-stat-positive">+{{ $newUsersThisMonth }} new this month</p>
        </div>

        <div class="rp-card rp-stat-card">
            <div class="rp-stat-head">
                <p class="rp-stat-label">Courses</p>
                <div class="rp-stat-icon violet"><i class="fas fa-book-open"></i></div>
            </div>
            <p class="rp-stat-value">{{ number_format($totalCourses) }}</p>
            <p class="rp-stat-meta">
                {{ number_format($publishedCourses) }} published &bull;
                {{ number_format($totalCourses - $publishedCourses) }} draft
            </p>
        </div>

        <div class="rp-card rp-stat-card">
            <div class="rp-stat-head">
                <p class="rp-stat-label">Enrollments</p>
                <div class="rp-stat-icon gold"><i class="fas fa-user-graduate"></i></div>
            </div>
            <p class="rp-stat-value">{{ number_format($totalEnrollments) }}</p>
            <p class="rp-stat-meta">{{ number_format($completedEnrollments) }} completed</p>
        </div>

        <div class="rp-card rp-stat-card">
            <div class="rp-stat-head">
                <p class="rp-stat-label">Avg. Progress</p>
                <div class="rp-stat-icon green"><i class="fas fa-chart-line"></i></div>
            </div>
            <p class="rp-stat-value">{{ $avgProgress }}%</p>
            <div class="rp-progress-track"><div class="rp-progress-fill" style="width: {{ min($avgProgress, 100) }}%"></div></div>
        </div>

    </section>

    {{-- ── Charts Row ─────────────────────────────────────────────────── --}}
    <section class="rp-charts-grid">

        <div class="rp-card">
            <div class="rp-card-head">
                <div>
                    <h2 class="rp-card-title">Monthly Trends</h2>
                    <p class="rp-card-sub">Signups, enrollments &amp; completions – last 12 months</p>
                </div>
                <div class="rp-legend">
                    <span><span class="dot" style="background:var(--accent)"></span>Signups</span>
                    <span><span class="dot" style="background:var(--accent-2)"></span>Enrollments</span>
                    <span><span class="dot" style="background:var(--success)"></span>Completions</span>
                </div>
            </div>
            <div class="rp-chart-body">
                <div id="trends-chart" style="height:256px;"></div>
            </div>
        </div>

        <div class="rp-card">
            <div class="rp-card-head">
                <div>
                    <h2 class="rp-card-title">Enrollment Status</h2>
                    <p class="rp-card-sub">Completed vs. in progress</p>
                </div>
            </div>
            <div class="rp-chart-body" style="display:flex;flex-direction:column;align-items:center;">
                <div id="donut-chart" style="width:100%;"></div>
                <div class="rp-donut-legend">
                    <span><span class="dot" style="background:var(--success)"></span>Completed ({{ number_format($completedEnrollments) }})</span>
                    <span><span class="dot" style="background:var(--accent)"></span>In Progress ({{ number_format($totalEnrollments - $completedEnrollments) }})</span>
                </div>
            </div>
        </div>

    </section>

    {{-- ── Live Monitoring ───────────────────────────────────────────────── --}}
    <section style="margin-bottom:26px;">
        <div class="rp-card">
            <div class="rp-card-head">
                <div>
                    <h2 class="rp-card-title"><span class="rp-live-dot"></span> Live Enrollment Monitor</h2>
                    <p class="rp-card-sub">Real-time enrollment feed with refresh every 15 seconds.</p>
                </div>
                <div class="rp-live-meta">
                    <div>Last refresh: <span id="live-refresh-time">just now</span></div>
                    <div>Total rows: <span id="live-row-count">{{ $recentEnrollments->count() }}</span></div>
                </div>
            </div>
            <div class="rp-table-wrap">
                <table class="rp-table">
                    <thead class="rp-thead">
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Progress</th>
                            <th class="rp-th-right">Updated</th>
                        </tr>
                    </thead>
                    <tbody id="live-enrollments-body">
                        @foreach($recentEnrollments as $enrollment)
                            <tr>
                                <td>
                                    <p class="rp-cell-strong truncate max-w-[180px]">{{ $enrollment->user->name ?? '—' }}</p>
                                    <p class="rp-cell-meta">{{ $enrollment->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="rp-cell truncate max-w-[180px]">{{ $enrollment->course->title ?? 'Deleted Course' }}</td>
                                <td>
                                    @if($enrollment->completed)
                                        <span class="rp-pill-done"><i class="fas fa-check" style="font-size:9px;"></i> Done</span>
                                    @else
                                        <span class="rp-progress-text">{{ $enrollment->progress ?? 0 }}%</span>
                                    @endif
                                </td>
                                <td class="rp-td-right rp-cell-meta">{{ $enrollment->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- ── Tables Row ──────────────────────────────────────────────────── --}}
    <section class="rp-bottom-grid">

        {{-- Top Courses --}}
        <div class="rp-card">
            <div class="rp-card-head">
                <h2 class="rp-card-title"><i class="fas fa-trophy" style="color:var(--gold);"></i> Top Courses</h2>
                <a href="{{ route('admin.courses.index') }}" class="rp-link">View all</a>
            </div>
            <div class="rp-table-wrap">
                <table class="rp-table">
                    <thead class="rp-thead">
                        <tr>
                            <th>#</th>
                            <th>Course</th>
                            <th class="rp-th-right">Enrollments</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCourses as $i => $course)
                            <tr>
                                <td class="rp-rank">{{ $i + 1 }}</td>
                                <td>
                                    <p class="rp-cell-strong truncate max-w-xs">{{ $course->title }}</p>
                                    @if($course->category)
                                        <p class="rp-cell-meta">{{ $course->category }}</p>
                                    @endif
                                </td>
                                <td class="rp-td-right"><span class="rp-pill-count">{{ number_format($course->enrollments_count) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="rp-empty-row">No courses yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Enrollments --}}
        <div class="rp-card">
            <div class="rp-card-head">
                <h2 class="rp-card-title"><i class="fas fa-clock" style="color:var(--accent);"></i> Recent Enrollments</h2>
                <a href="{{ route('admin.enrollments.index') }}" class="rp-link">View all</a>
            </div>
            <div class="rp-table-wrap">
                <table class="rp-table">
                    <thead class="rp-thead">
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th class="rp-th-right">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentEnrollments as $enrollment)
                            <tr>
                                <td>
                                    <p class="rp-cell-strong truncate max-w-[130px]">{{ $enrollment->user->name ?? '—' }}</p>
                                    <p class="rp-cell-meta">{{ $enrollment->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="rp-cell truncate max-w-[130px]">{{ $enrollment->course->title ?? 'Deleted Course' }}</td>
                                <td class="rp-td-right">
                                    @if($enrollment->completed)
                                        <span class="rp-pill-done"><i class="fas fa-check" style="font-size:9px;"></i> Done</span>
                                    @else
                                        <span class="rp-progress-text">{{ $enrollment->progress ?? 0 }}%</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="rp-empty-row">No enrollments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

{{-- ── ApexCharts ────────────────────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Area chart: monthly trends ──────────────────────────────────────────
    new ApexCharts(document.querySelector('#trends-chart'), {
        chart: {
            type: 'area',
            height: 256,
            fontFamily: 'inherit',
            toolbar: { show: false },
            zoom: { enabled: false },
            background: 'transparent',
        },
        theme: { mode: 'dark' },
        series: [
            { name: 'New Signups',   data: @json($monthlySignups) },
            { name: 'Enrollments',   data: @json($monthlyEnrollments) },
            { name: 'Completions',   data: @json($monthlyCompletions) },
        ],
        xaxis: {
            categories: @json($chartLabels),
            labels: { style: { fontSize: '11px', colors: '#93a3bd' } },
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            min: 0,
            labels: {
                style: { fontSize: '11px', colors: '#93a3bd' },
                formatter: v => Math.floor(v),
            },
        },
        colors: ['#4f8cff', '#9b8cf7', '#2fd6a7'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02, stops: [0, 90, 100] },
        },
        stroke: { curve: 'smooth', width: 2.5 },
        dataLabels: { enabled: false },
        grid: {
            borderColor: 'rgba(255,255,255,0.07)',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } },
        },
        legend: { show: false },
        tooltip: {
            theme: 'dark',
            y: { formatter: v => v + (v === 1 ? ' record' : ' records') },
        },
    }).render();

    // ── Donut chart: enrollment status ─────────────────────────────────────
    const completed  = @json($completedEnrollments);
    const inProgress = @json($totalEnrollments - $completedEnrollments);
    new ApexCharts(document.querySelector('#donut-chart'), {
        chart: { type: 'donut', height: 220, fontFamily: 'inherit', background: 'transparent' },
        theme: { mode: 'dark' },
        series: [completed, inProgress],
        labels: ['Completed', 'In Progress'],
        colors: ['#2fd6a7', '#4f8cff'],
        legend: { show: false },
        dataLabels: { enabled: false },
        stroke: { show: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '68%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            color: '#93a3bd',
                            fontSize: '13px',
                            formatter: () => completed + inProgress,
                        },
                        value: { color: '#f6f8fc' },
                    },
                },
            },
        },
        tooltip: { theme: 'dark' },
    }).render();

    const liveApiUrl = '{{ route('admin.reports.liveData') }}';
    const liveBody = document.querySelector('#live-enrollments-body');
    const liveCount = document.querySelector('#live-row-count');
    const liveTime = document.querySelector('#live-refresh-time');
    const printButton = document.getElementById('print-report-button');

    async function refreshLiveEnrollments() {
        if (!liveBody || !liveCount || !liveTime) {
            return;
        }

        try {
            const response = await fetch(liveApiUrl, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                throw new Error('Live data request failed');
            }

            const payload = await response.json();
            if (!payload.success || !Array.isArray(payload.data)) {
                throw new Error('Invalid live data response');
            }

            liveBody.innerHTML = payload.data.slice(0, 12).map(item => `
                <tr>
                    <td>
                        <p class="rp-cell-strong truncate max-w-[180px]">${item.name}</p>
                        <p class="rp-cell-meta">${item.enrolledDate}</p>
                    </td>
                    <td class="rp-cell truncate max-w-[180px]">${item.course}</td>
                    <td>
                        ${item.status === 'Completed' || item.status === 'Done' || item.progress >= 100 ?
                            `<span class="rp-pill-done"><i class="fas fa-check" style="font-size:9px;"></i> Done</span>` :
                            `<span class="rp-progress-text">${item.progress}%</span>`
                        }
                    </td>
                    <td class="rp-td-right rp-cell-meta">${item.lastUpdated}</td>
                </tr>
            `).join('');

            liveCount.textContent = payload.count;
            liveTime.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        } catch (error) {
            console.error('Live enrollment update failed:', error);
        }
    }

    if (printButton) {
        printButton.addEventListener('click', function () {
            window.print();
        });
    }

    refreshLiveEnrollments();
    setInterval(refreshLiveEnrollments, 15000);
});
</script>
@endsection