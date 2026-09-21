@extends('sias.teacher.layout.layout')

@section('title', 'Teacher Dashboard')
@section('page_title', 'Teacher Dashboard')

@section('content')
<style>
    /* ===== DASHBOARD FOUNDATION ===== */
    .db-grid { display: grid; gap: 20px; }

    /* ===== WELCOME BANNER ===== */
    .db-banner {
        position: relative;
        background: linear-gradient(135deg, var(--nav-bg-top) 0%, var(--nav-bg-bottom) 60%, var(--brass) 100%);
        color: #fff;
        padding: 32px 34px;
        border-radius: 16px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 24px;
        align-items: center;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(11,18,32,.18);
    }
    .db-banner::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(216,188,133,.12);
    }
    .db-banner::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 30%;
        width: 140px; height: 140px;
        border-radius: 50%;
        background: rgba(216,188,133,.08);
    }
    .db-banner-left { position: relative; z-index: 1; }
    .db-banner-left h2 {
        margin: 0 0 6px;
        font-family: var(--font-display);
        font-size: 1.7rem;
        font-weight: 600;
    }
    .db-banner-left p { margin: 0; opacity: .85; font-size: .92rem; }
    .db-banner-left .greeting-sub {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 14px;
        flex-wrap: wrap;
    }
    .db-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(255,255,255,.15);
        backdrop-filter: blur(6px);
        padding: 5px 14px;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .03em;
    }
    .db-badge i { font-size: .72rem; }

    .db-clock { position: relative; z-index: 1; text-align: right; }
    .db-clock .time {
        font-size: 2.8rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        line-height: 1;
        letter-spacing: 2px;
    }
    .db-clock .date { font-size: .85rem; opacity: .8; margin-top: 6px; }

    /* ===== STATS ROW ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(195px, 1fr));
        gap: 16px;
    }
    .s-card {
        position: relative;
        background: var(--card-bg);
        border-radius: 14px;
        padding: 22px 20px;
        box-shadow: var(--shadow-soft);
        border: 1px solid var(--border);
        overflow: hidden;
        transition: transform .25s var(--ease), box-shadow .25s var(--ease), border-color .25s var(--ease);
    }
    .s-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow);
        border-color: var(--brass-light);
    }
    .s-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
        border-radius: 14px 0 0 14px;
    }
    .s-card.c-blue::before   { background: linear-gradient(180deg, #667eea, #764ba2); }
    .s-card.c-green::before  { background: linear-gradient(180deg, #10b981, #059669); }
    .s-card.c-amber::before  { background: linear-gradient(180deg, #f59e0b, #d97706); }
    .s-card.c-purple::before { background: linear-gradient(180deg, #8b5cf6, #7c3aed); }
    .s-card.c-rose::before   { background: linear-gradient(180deg, #f43f5e, #e11d48); }
    .s-card.c-brass::before  { background: linear-gradient(180deg, var(--brass), var(--brass-light)); }

    .s-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .s-card-icon {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        color: #fff;
    }
    .s-card.c-blue   .s-card-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
    .s-card.c-green  .s-card-icon { background: linear-gradient(135deg, #10b981, #059669); }
    .s-card.c-amber  .s-card-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .s-card.c-purple .s-card-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .s-card.c-rose   .s-card-icon { background: linear-gradient(135deg, #f43f5e, #e11d48); }
    .s-card.c-brass  .s-card-icon { background: linear-gradient(135deg, var(--brass), var(--brass-light)); }

    .s-card-change {
        font-size: .72rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
    }
    .s-card-change.up   { background: #d1fae5; color: #065f46; }
    .s-card-change.down { background: #fee2e2; color: #991b1b; }
    .s-card-change.flat { background: #f3f4f6; color: #6b7280; }
    .s-card .s-number {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.1;
    }
    .s-card .s-label { font-size: .82rem; color: #7C8AA0; margin-top: 2px; }
    .s-card .s-sub { font-size: .73rem; color: #a1a1aa; margin-top: 6px; }

    /* ===== SECTION HEADERS ===== */
    .sec-head {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--ink);
        font-family: var(--font-display);
        margin: 8px 0 14px;
    }
    .sec-head i { color: var(--brass); font-size: .9rem; }
    .sec-head .sec-count {
        margin-left: auto;
        font-family: var(--font-body);
        font-size: .75rem;
        font-weight: 600;
        background: rgba(176,141,87,.1);
        color: var(--brass);
        padding: 3px 10px;
        border-radius: 999px;
    }

    /* ===== TWO-COLUMN LAYOUT ===== */
    .db-two-col {
        display: grid;
        grid-template-columns: 5fr 3fr;
        gap: 20px;
    }

    /* ===== PANEL (reusable card) ===== */
    .db-panel {
        background: var(--card-bg);
        border-radius: 14px;
        box-shadow: var(--shadow-soft);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .db-panel-head {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .db-panel-head h3 {
        margin: 0;
        font-family: var(--font-display);
        font-size: .98rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .db-panel-head h3 i { color: var(--brass); font-size: .85rem; }
    .db-panel-head .view-all {
        font-size: .78rem;
        color: var(--brass);
        text-decoration: none;
        font-weight: 600;
        transition: color .2s;
    }
    .db-panel-head .view-all:hover { color: var(--ink); }
    .db-panel-body { padding: 0; }
    .db-panel-body.padded { padding: 20px; }

    /* ===== TODAY'S SCHEDULE ===== */
    .sched-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid rgba(0,0,0,.04);
        transition: background .2s;
    }
    .sched-item:last-child { border-bottom: none; }
    .sched-item:hover { background: rgba(176,141,87,.03); }
    .sched-time {
        min-width: 60px;
        text-align: center;
        font-size: .78rem;
        font-weight: 700;
        color: var(--brass);
        line-height: 1.3;
    }
    .sched-time small { display: block; font-weight: 500; color: #a1a1aa; font-size: .7rem; }
    .sched-divider {
        width: 3px;
        height: 36px;
        border-radius: 3px;
        background: linear-gradient(180deg, var(--brass), var(--brass-light));
        flex-shrink: 0;
    }
    .sched-details { flex: 1; }
    .sched-name { font-weight: 600; font-size: .88rem; color: var(--ink); }
    .sched-meta { font-size: .76rem; color: #7C8AA0; margin-top: 2px; }
    .sched-meta i { margin-right: 3px; }

    /* ===== QUICK ACTIONS ===== */
    .qa-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 10px;
    }
    .qa-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 18px 10px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: .82rem;
        color: var(--ink);
        background: var(--paper);
        border: 1px solid var(--border);
        transition: all .25s var(--ease);
    }
    .qa-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-soft);
        border-color: var(--brass-light);
        color: var(--brass);
    }
    .qa-btn i {
        font-size: 1.3rem;
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(176,141,87,.08);
        color: var(--brass);
        transition: background .25s, color .25s;
    }
    .qa-btn:hover i { background: var(--brass); color: #fff; }

    /* ===== STUDENT LIST ===== */
    .st-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid rgba(0,0,0,.04);
        transition: background .2s;
    }
    .st-item:last-child { border-bottom: none; }
    .st-item:hover { background: rgba(176,141,87,.03); }
    .st-avatar {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        font-size: .82rem;
        color: #fff;
        flex-shrink: 0;
    }
    .st-info { flex: 1; min-width: 0; }
    .st-name { font-weight: 600; font-size: .88rem; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .st-course { font-size: .75rem; color: #7C8AA0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .st-progress {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: .78rem; font-weight: 700;
        padding: 4px 12px;
        border-radius: 999px;
        flex-shrink: 0;
    }
    .st-progress.high   { background: #d1fae5; color: #065f46; }
    .st-progress.medium { background: #fef3c7; color: #92400e; }
    .st-progress.low    { background: #fee2e2; color: #991b1b; }

    /* ===== ENROLLMENT TREND CHART ===== */
    .trend-chart {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        height: 120px;
        padding: 0 4px;
    }
    .trend-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }
    .trend-bar {
        width: 100%;
        border-radius: 6px 6px 2px 2px;
        background: linear-gradient(180deg, var(--brass), var(--brass-light));
        min-height: 4px;
        transition: height .5s var(--ease);
        position: relative;
    }
    .trend-bar:hover { opacity: .85; }
    .trend-bar .trend-tooltip {
        display: none;
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        background: var(--ink);
        color: #fff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
        z-index: 5;
    }
    .trend-bar:hover .trend-tooltip { display: block; }
    .trend-label { font-size: .68rem; color: #7C8AA0; font-weight: 600; }
    .trend-count { font-size: .7rem; color: var(--ink); font-weight: 700; }

    /* ===== COURSE PERFORMANCE TABLE ===== */
    .cp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .84rem;
    }
    .cp-table th {
        text-align: left;
        padding: 10px 16px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #7C8AA0;
        border-bottom: 2px solid var(--border);
    }
    .cp-table td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0,0,0,.04);
        color: var(--ink);
    }
    .cp-table tbody tr:hover { background: rgba(176,141,87,.03); }
    .cp-table .cp-title { font-weight: 600; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .cp-status {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
    }
    .cp-status.published { background: #d1fae5; color: #065f46; }
    .cp-status.draft     { background: #fef3c7; color: #92400e; }
    .cp-mini-bar {
        width: 60px; height: 6px;
        background: #e5e7eb;
        border-radius: 6px;
        overflow: hidden;
        display: inline-block;
        vertical-align: middle;
        margin-right: 6px;
    }
    .cp-mini-fill {
        height: 100%;
        border-radius: 6px;
        background: linear-gradient(90deg, var(--brass), var(--brass-light));
    }

    /* ===== ACTIVITY FEED ===== */
    .act-item {
        display: flex;
        gap: 12px;
        padding: 14px 20px;
        border-bottom: 1px solid rgba(0,0,0,.04);
        transition: background .2s;
    }
    .act-item:last-child { border-bottom: none; }
    .act-item:hover { background: rgba(176,141,87,.03); }
    .act-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: .85rem;
        background: rgba(176,141,87,.08);
        color: var(--brass);
    }
    .act-body { flex: 1; min-width: 0; }
    .act-title { font-weight: 600; font-size: .86rem; color: var(--ink); }
    .act-desc { font-size: .76rem; color: #7C8AA0; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .act-time { font-size: .7rem; color: #bbb; margin-top: 3px; }

    /* ===== ALERT / ATTENTION ===== */
    .att-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
        border-bottom: 1px solid rgba(0,0,0,.04);
    }
    .att-item:last-child { border-bottom: none; }
    .att-dot { width: 8px; height: 8px; border-radius: 50%; background: #f43f5e; flex-shrink: 0; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: .4; } }
    .att-info { flex: 1; min-width: 0; }
    .att-name { font-weight: 600; font-size: .84rem; color: var(--ink); }
    .att-sub { font-size: .73rem; color: #7C8AA0; }

    /* ===== EMPTY STATE ===== */
    .db-empty {
        text-align: center;
        padding: 30px 20px;
        color: #a1a1aa;
    }
    .db-empty i { font-size: 2rem; margin-bottom: 8px; display: block; opacity: .5; }
    .db-empty p { margin: 0; font-size: .85rem; }

    /* ===== PROGRESS RING ===== */
    .progress-ring-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .ring-label { font-size: .85rem; }
    .ring-label strong { display: block; font-size: 1.1rem; color: var(--ink); }

    /* ===== DARK MODE ===== */
    .dark-mode .db-banner { box-shadow: 0 16px 40px rgba(0,0,0,.35); }
    .dark-mode .s-card { background: #101A2C; border-color: #1C2A44; }
    .dark-mode .s-card .s-number { color: #E4E8F0; }
    .dark-mode .s-card:hover { border-color: var(--brass); box-shadow: none; }
    .dark-mode .db-panel { background: #101A2C; border-color: #1C2A44; }
    .dark-mode .db-panel-head { border-color: #1C2A44; }
    .dark-mode .db-panel-head h3 { color: #E4E8F0; }
    .dark-mode .sec-head { color: #E4E8F0; }
    .dark-mode .qa-btn { background: #0E1728; border-color: #1C2A44; color: #E4E8F0; }
    .dark-mode .qa-btn:hover { border-color: var(--brass); }
    .dark-mode .st-name, .dark-mode .sched-name, .dark-mode .act-title, .dark-mode .att-name { color: #E4E8F0; }
    .dark-mode .cp-table th { color: #7C8AA0; border-color: #1C2A44; }
    .dark-mode .cp-table td { color: #E4E8F0; border-color: #1C2A44; }
    .dark-mode .cp-table tbody tr:hover { background: rgba(216,188,133,.04); }
    .dark-mode .cp-mini-bar { background: #1C2A44; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 960px) {
        .db-two-col { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .db-banner { grid-template-columns: 1fr; text-align: center; }
        .db-clock { text-align: center; }
        .db-clock .time { font-size: 2rem; }
        .stats-row { grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); }
        .qa-grid { grid-template-columns: repeat(2, 1fr); }
        .cp-table { font-size: .78rem; }
        .cp-table th, .cp-table td { padding: 8px 10px; }
    }
</style>

<div class="db-grid">

    {{-- ===== WELCOME BANNER ===== --}}
    <div class="db-banner">
        <div class="db-banner-left">
            <h2>Welcome back, {{ $user->name }}! 👋</h2>
            <p>Here's your teaching overview for today, <strong>{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</strong></p>
            <div class="greeting-sub">
                <span class="db-badge"><i class="fa-solid fa-book-open"></i> {{ $totalCourses }} Courses</span>
                <span class="db-badge"><i class="fa-solid fa-users"></i> {{ $totalTrainees }} Trainees</span>
                @if($weekScheduleCount > 0)
                    <span class="db-badge"><i class="fa-solid fa-calendar"></i> {{ $weekScheduleCount }} Classes/Week</span>
                @endif
                @if($totalSubjects > 0)
                    <span class="db-badge"><i class="fa-solid fa-layer-group"></i> {{ $totalSubjects }} Subjects</span>
                @endif
            </div>
        </div>
        <div class="db-clock">
            <div class="time" id="clock">--:--:--</div>
            <div class="date" id="date">Loading...</div>
        </div>
    </div>

    {{-- ===== STATS ROW ===== --}}
    <div class="stats-row">
        <div class="s-card c-blue">
            <div class="s-card-top">
                <div class="s-card-icon"><i class="fa-solid fa-book-open"></i></div>
                <span class="s-card-change {{ $activeCourses > 0 ? 'up' : 'flat' }}">
                    {{ $activeCourses }} active
                </span>
            </div>
            <div class="s-number">{{ $totalCourses }}</div>
            <div class="s-label">Total Courses</div>
            <div class="s-sub">{{ $draftCourses }} draft · {{ $activeCourses }} published</div>
        </div>

        <div class="s-card c-green">
            <div class="s-card-top">
                <div class="s-card-icon"><i class="fa-solid fa-users"></i></div>
                <span class="s-card-change {{ $enrollmentsThisWeek > 0 ? 'up' : 'flat' }}">
                    @if($enrollmentsThisWeek > 0) +{{ $enrollmentsThisWeek }} this week @else — @endif
                </span>
            </div>
            <div class="s-number">{{ $totalTrainees }}</div>
            <div class="s-label">Total Trainees</div>
            <div class="s-sub">{{ $totalEnrollments }} total enrollments</div>
        </div>

        <div class="s-card c-amber">
            <div class="s-card-top">
                <div class="s-card-icon"><i class="fa-solid fa-star"></i></div>
                <span class="s-card-change flat">of 5.0</span>
            </div>
            <div class="s-number">{{ $averageRating }}</div>
            <div class="s-label">Average Rating</div>
            <div class="s-sub">Based on {{ $totalEnrollments }} enrollments</div>
        </div>

        <div class="s-card c-purple">
            <div class="s-card-top">
                <div class="s-card-icon"><i class="fa-solid fa-chart-line"></i></div>
                <span class="s-card-change {{ $enrollmentChange > 0 ? 'up' : ($enrollmentChange < 0 ? 'down' : 'flat') }}">
                    @if($enrollmentChange > 0) ▲ {{ $enrollmentChange }}% @elseif($enrollmentChange < 0) ▼ {{ abs($enrollmentChange) }}% @else — @endif
                </span>
            </div>
            <div class="s-number">{{ $completionRate }}%</div>
            <div class="s-label">Completion Rate</div>
            <div class="s-sub">{{ $completedEnrollments }} of {{ $totalEnrollments }} completed</div>
        </div>

        <div class="s-card c-brass">
            <div class="s-card-top">
                <div class="s-card-icon"><i class="fa-solid fa-signal"></i></div>
                <span class="s-card-change flat">avg</span>
            </div>
            <div class="s-number">{{ $averageProgress }}%</div>
            <div class="s-label">Avg Student Progress</div>
            <div class="s-sub">Across all courses</div>
        </div>

        <div class="s-card c-blue">
            <div class="s-card-top"><div class="s-card-icon"><i class="fa-solid fa-calendar-check"></i></div><span class="s-card-change up">active</span></div>
            <div class="s-number">{{ $activeTrainingSessions }}</div>
            <div class="s-label">Active Training Sessions</div>
            <div class="s-sub">Scheduled classes</div>
        </div>

        <div class="s-card c-green">
            <div class="s-card-top"><div class="s-card-icon"><i class="fa-solid fa-clipboard-check"></i></div><span class="s-card-change flat">published</span></div>
            <div class="s-number">{{ $upcomingAssessments }}</div>
            <div class="s-label">Upcoming Assessments</div>
            <div class="s-sub">Available for trainees</div>
        </div>

        <div class="s-card c-amber">
            <div class="s-card-top"><div class="s-card-icon"><i class="fa-solid fa-user-check"></i></div><span class="s-card-change flat">today</span></div>
            <div class="s-number">{{ $attendanceSummary['present'] }}</div>
            <div class="s-label">Present Today</div>
            <div class="s-sub">{{ $attendanceSummary['late'] }} late · {{ $attendanceSummary['absent'] }} absent</div>
        </div>
    </div>

    {{-- ===== QUICK ACTIONS ===== --}}
    <div class="sec-head"><i class="fa-solid fa-bolt"></i> Quick Actions</div>
    <div class="qa-grid">
        <a href="{{ route('sias.teacher.profile') }}" class="qa-btn">
            <i class="fa-solid fa-user"></i> My Profile
        </a>
        <a href="{{ route('sias.teacher.profile.create-course') }}" class="qa-btn">
            <i class="fa-solid fa-plus"></i> New Course
        </a>
        <a href="{{ route('sias.teacher.subjects') }}" class="qa-btn">
            <i class="fa-solid fa-book"></i> My Subjects
        </a>
        <a href="{{ route('sias.teacher.grades.index') }}" class="qa-btn">
            <i class="fa-solid fa-clipboard-list"></i> Gradebook
        </a>
        <a href="{{ route('sias.teacher.grade-entry') }}" class="qa-btn">
            <i class="fa-solid fa-pen-to-square"></i> Grade Entry
        </a>
        <a href="{{ route('sias.teacher.programs') }}" class="qa-btn"><i class="fa-solid fa-graduation-cap"></i> Training Programs</a>
        <a href="{{ route('sias.teacher.attendance') }}" class="qa-btn"><i class="fa-solid fa-calendar-check"></i> Attendance</a>
        <a href="{{ route('sias.teacher.reports') }}" class="qa-btn"><i class="fa-solid fa-chart-column"></i> Reports</a>
        <a href="{{ route('sias.teacher.schedule') }}" class="qa-btn">
            <i class="fa-solid fa-calendar-days"></i> Schedule
        </a>
        <a href="{{ route('sias.teacher.account') }}" class="qa-btn">
            <i class="fa-solid fa-gear"></i> Account
        </a>
        <a href="{{ route('sias.teacher.monitoring-class') }}" class="qa-btn">
            <i class="fa-solid fa-chart-bar"></i> Monitoring
        </a>
    </div>

    {{-- ===== TWO-COLUMN LAYOUT ===== --}}
    <div class="db-two-col">

        {{-- LEFT COLUMN --}}
        <div class="db-grid">

            {{-- Today's Schedule --}}
            <div class="db-panel">
                <div class="db-panel-head">
                    <h3><i class="fa-solid fa-calendar-day"></i> Today's Schedule — {{ $todayName }}</h3>
                    <a href="{{ route('sias.teacher.schedule') }}" class="view-all">View All →</a>
                </div>
                <div class="db-panel-body">
                    @if($todaySchedules->count() > 0)
                        @foreach($todaySchedules as $sched)
                            <div class="sched-item">
                                <div class="sched-time">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $sched->start_time)->format('g:i A') }}
                                    <small>{{ $sched->getDurationMinutes() }} min</small>
                                </div>
                                <div class="sched-divider"></div>
                                <div class="sched-details">
                                    <div class="sched-name">{{ $sched->subject_name }}</div>
                                    <div class="sched-meta">
                                        @if($sched->room_number)
                                            <i class="fa-solid fa-door-open"></i> {{ $sched->room_number }}
                                        @endif
                                        @if($sched->building)
                                            · <i class="fa-solid fa-building"></i> {{ $sched->building }}
                                        @endif
                                        @if($sched->student_count)
                                            · <i class="fa-solid fa-users"></i> {{ $sched->student_count }} students
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="db-empty">
                            <i class="fa-solid fa-calendar-xmark"></i>
                            <p>No classes scheduled for today</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Course Performance --}}
            @if(count($coursePerformance) > 0)
            <div class="db-panel">
                <div class="db-panel-head">
                    <h3><i class="fa-solid fa-ranking-star"></i> Course Performance</h3>
                    <a href="{{ route('sias.teacher.profile') }}" class="view-all">All Courses →</a>
                </div>
                <div class="db-panel-body" style="overflow-x:auto;">
                    <table class="cp-table">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Students</th>
                                <th>Avg Progress</th>
                                <th>Completed</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coursePerformance as $cp)
                            <tr>
                                <td class="cp-title" title="{{ $cp['title'] }}">{{ Str::limit($cp['title'], 30) }}</td>
                                <td>{{ $cp['students'] }}</td>
                                <td>
                                    <span class="cp-mini-bar"><span class="cp-mini-fill" style="width:{{ $cp['avg_progress'] }}%"></span></span>
                                    {{ $cp['avg_progress'] }}%
                                </td>
                                <td>{{ $cp['completed'] }}</td>
                                <td>
                                    <span class="cp-status {{ $cp['is_published'] ? 'published' : 'draft' }}">
                                        <i class="fa-solid fa-circle" style="font-size:.45rem;"></i>
                                        {{ $cp['is_published'] ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Students in Progress --}}
            <div class="db-panel">
                <div class="db-panel-head">
                    <h3><i class="fa-solid fa-users-gear"></i> Students in Progress</h3>
                    <span class="view-all">{{ $studentsInProgress->count() }} active</span>
                </div>
                <div class="db-panel-body">
                    @if($studentsInProgress->count() > 0)
                        @php $avatarColors = ['#667eea','#10b981','#f59e0b','#8b5cf6','#f43f5e','#06b6d4','#ec4899','#14b8a6']; @endphp
                        @foreach($studentsInProgress->take(6) as $idx => $enrollment)
                            <div class="st-item">
                                <div class="st-avatar" style="background:{{ $avatarColors[$idx % count($avatarColors)] }}">
                                    {{ strtoupper(substr($enrollment->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div class="st-info">
                                    <div class="st-name">{{ $enrollment->user->name ?? 'Unknown' }}</div>
                                    <div class="st-course">{{ Str::limit($enrollment->course->title ?? '', 45) }}</div>
                                </div>
                                <span class="st-progress {{ ($enrollment->progress ?? 0) >= 70 ? 'high' : (($enrollment->progress ?? 0) >= 40 ? 'medium' : 'low') }}">
                                    {{ $enrollment->progress ?? 0 }}%
                                </span>
                            </div>
                        @endforeach
                        @if($studentsInProgress->count() > 6)
                            <div style="text-align:center;padding:10px;font-size:.78rem;color:#7C8AA0;">
                                +{{ $studentsInProgress->count() - 6 }} more students
                            </div>
                        @endif
                    @else
                        <div class="db-empty">
                            <i class="fa-solid fa-user-graduate"></i>
                            <p>No students in progress yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div class="db-grid">

            {{-- Enrollment Trend --}}
            <div class="db-panel">
                <div class="db-panel-head">
                    <h3><i class="fa-solid fa-chart-area"></i> Enrollment Trend</h3>
                    <span class="view-all">Last 7 days</span>
                </div>
                <div class="db-panel-body padded">
                    @php
                        $maxTrend = max(array_column($enrollmentTrend, 'count'));
                        if ($maxTrend == 0) $maxTrend = 1;
                    @endphp
                    <div class="trend-chart">
                        @foreach($enrollmentTrend as $t)
                            <div class="trend-col">
                                <div class="trend-count">{{ $t['count'] }}</div>
                                <div class="trend-bar" style="height:{{ max(($t['count'] / $maxTrend) * 90, 4) }}px;">
                                    <span class="trend-tooltip">{{ $t['date'] }}: {{ $t['count'] }} enrollment{{ $t['count'] != 1 ? 's' : '' }}</span>
                                </div>
                                <span class="trend-label">{{ $t['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top:14px;display:flex;justify-content:space-between;font-size:.76rem;color:#7C8AA0;">
                        <span>This month: <strong style="color:var(--ink);">{{ $thisMonthEnrollments }}</strong></span>
                        <span class="{{ $enrollmentChange >= 0 ? 'up' : 'down' }}" style="font-weight:700;color:{{ $enrollmentChange >= 0 ? '#10b981' : '#f43f5e' }}">
                            {{ $enrollmentChange >= 0 ? '▲' : '▼' }} {{ abs($enrollmentChange) }}% vs last month
                        </span>
                    </div>
                </div>
            </div>

            {{-- Courses by Level --}}
            <div class="db-panel">
                <div class="db-panel-head">
                    <h3><i class="fa-solid fa-layer-group"></i> Courses by Level</h3>
                </div>
                <div class="db-panel-body padded">
                    @if($coursesByLevel->count() > 0)
                        @foreach(['Beginner' => ['icon' => 'fa-seedling', 'color' => '#10b981'], 'Intermediate' => ['icon' => 'fa-user', 'color' => '#f59e0b'], 'Advanced' => ['icon' => 'fa-rocket', 'color' => '#8b5cf6']] as $level => $meta)
                            @if(isset($coursesByLevel[$level]))
                                <div style="margin-bottom:14px;">
                                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                                        <span style="font-size:.84rem;font-weight:600;display:flex;align-items:center;gap:6px;color:var(--ink);">
                                            <i class="fa-solid {{ $meta['icon'] }}" style="color:{{ $meta['color'] }};font-size:.8rem;"></i> {{ $level }}
                                        </span>
                                        <span style="font-size:.82rem;font-weight:700;color:{{ $meta['color'] }}">{{ $coursesByLevel[$level] }}</span>
                                    </div>
                                    <div style="height:7px;background:#e5e7eb;border-radius:6px;overflow:hidden;">
                                        <div style="height:100%;width:{{ $totalCourses > 0 ? ($coursesByLevel[$level] / $totalCourses) * 100 : 0 }}%;background:{{ $meta['color'] }};border-radius:6px;transition:width .5s var(--ease);"></div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="db-empty">
                            <i class="fa-solid fa-layer-group"></i>
                            <p>No courses yet</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Students Needing Attention --}}
            <div class="db-panel">
                <div class="db-panel-head">
                    <h3><i class="fa-solid fa-triangle-exclamation"></i> Needs Attention</h3>
                    <span class="view-all" style="color:#f43f5e;">{{ $studentsNeedingAttention->count() }} students</span>
                </div>
                <div class="db-panel-body">
                    @if($studentsNeedingAttention->count() > 0)
                        @foreach($studentsNeedingAttention as $att)
                            <div class="att-item">
                                <div class="att-dot"></div>
                                <div class="att-info">
                                    <div class="att-name">{{ $att->user->name ?? 'Unknown' }}</div>
                                    <div class="att-sub">{{ Str::limit($att->course->title ?? '', 35) }} · {{ $att->progress ?? 0 }}% progress</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="db-empty">
                            <i class="fa-solid fa-circle-check" style="color:#10b981;"></i>
                            <p>All students are on track!</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Enrollments --}}
            <div class="db-panel">
                <div class="db-panel-head">
                    <h3><i class="fa-solid fa-clock-rotate-left"></i> Recent Enrollments</h3>
                </div>
                <div class="db-panel-body">
                    @if($recentEnrollments->count() > 0)
                        @foreach($recentEnrollments->take(5) as $enrollment)
                            <div class="act-item">
                                <div class="act-icon">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>
                                <div class="act-body">
                                    <div class="act-title">{{ $enrollment->user->name ?? 'Unknown' }}</div>
                                    <div class="act-desc">Enrolled in {{ Str::limit($enrollment->course->title ?? '', 40) }}</div>
                                    <div class="act-time">{{ $enrollment->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="db-empty">
                            <i class="fa-solid fa-inbox"></i>
                            <p>No recent enrollments</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Stats Summary --}}
            <div class="db-panel" style="background:linear-gradient(135deg, var(--nav-bg-top) 0%, var(--nav-bg-bottom) 100%);border:none;">
                <div class="db-panel-body padded" style="color:#fff;">
                    <h3 style="margin:0 0 14px;font-family:var(--font-display);font-size:1rem;color:#fff;display:flex;align-items:center;gap:8px;">
                        <i class="fa-solid fa-chart-pie" style="color:var(--brass-light);"></i> Summary
                    </h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:.84rem;">
                        <div style="background:rgba(255,255,255,.08);padding:12px;border-radius:10px;">
                            <div style="font-size:1.3rem;font-weight:700;">{{ $activeCourses }}</div>
                            <div style="opacity:.7;font-size:.76rem;">Published Courses</div>
                        </div>
                        <div style="background:rgba(255,255,255,.08);padding:12px;border-radius:10px;">
                            <div style="font-size:1.3rem;font-weight:700;">{{ $completedEnrollments }}</div>
                            <div style="opacity:.7;font-size:.76rem;">Completions</div>
                        </div>
                        <div style="background:rgba(255,255,255,.08);padding:12px;border-radius:10px;">
                            <div style="font-size:1.3rem;font-weight:700;">{{ $totalEnrollments }}</div>
                            <div style="opacity:.7;font-size:.76rem;">Total Enrollments</div>
                        </div>
                        <div style="background:rgba(255,255,255,.08);padding:12px;border-radius:10px;">
                            <div style="font-size:1.3rem;font-weight:700;">{{ $totalSubjects }}</div>
                            <div style="opacity:.7;font-size:.76rem;">Subjects Assigned</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
(function() {
    // ===== LIVE CLOCK =====
    function updateClock() {
        var now = new Date();
        var h = String(now.getHours()).padStart(2, '0');
        var m = String(now.getMinutes()).padStart(2, '0');
        var s = String(now.getSeconds()).padStart(2, '0');
        var el = document.getElementById('clock');
        if (el) el.textContent = h + ':' + m + ':' + s;

        var opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        var dateEl = document.getElementById('date');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('en-US', opts);
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ===== ANIMATE STAT NUMBERS =====
    document.querySelectorAll('.s-number').forEach(function(el) {
        var text = el.textContent.trim();
        var suffix = '';
        var num = parseFloat(text);

        if (text.indexOf('%') !== -1) suffix = '%';
        if (isNaN(num)) return;

        var duration = 1200;
        var start = performance.now();
        var startVal = 0;

        function animate(ts) {
            var elapsed = ts - start;
            var progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = startVal + (num - startVal) * eased;

            if (Number.isInteger(num)) {
                el.textContent = Math.round(current) + suffix;
            } else {
                el.textContent = current.toFixed(1) + suffix;
            }

            if (progress < 1) requestAnimationFrame(animate);
        }
        requestAnimationFrame(animate);
    });

    // ===== AUTO-REFRESH DASHBOARD DATA =====
    setInterval(function() {
        fetch('{{ route("sias.teacher.dashboard.data") }}')
            .then(function(r) { return r.json(); })
            .catch(function() { /* silent */ });
    }, 60000);
})();
</script>
@endpush
