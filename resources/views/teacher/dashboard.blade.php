@extends('teacher.layouts.master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

{{-- ===================== STYLES ===================== --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap');

    :root {
        --bg:         #0d0f14;
        --surface:    #13161e;
        --surface-2:  #1b1f2b;
        --border:     rgba(255,255,255,0.07);
        --gold:       #c9a96e;
        --gold-light: #e8c98a;
        --text:       #e8e4dc;
        --muted:      #6b7280;
        --accent:     #3d5aff;
        --accent-dim: rgba(61,90,255,0.15);
        --radius:     14px;
        --radius-lg:  22px;
        --ease-out:   cubic-bezier(0.22, 1, 0.36, 1);
        --shadow:     0 24px 64px rgba(0,0,0,0.45);
    }

    /* ── Base ── */
    .dash-wrap {
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding: 2rem 0;
        position: relative;
    }

    /* ── Ambient orbs ── */
    .dash-wrap::before,
    .dash-wrap::after {
        content: '';
        position: fixed;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
        filter: blur(120px);
        opacity: 0.18;
        animation: orbDrift 12s ease-in-out infinite alternate;
    }
    .dash-wrap::before {
        width: 600px; height: 600px;
        background: radial-gradient(circle, #3d5aff 0%, transparent 70%);
        top: -120px; left: -200px;
    }
    .dash-wrap::after {
        width: 500px; height: 500px;
        background: radial-gradient(circle, var(--gold) 0%, transparent 70%);
        bottom: 0; right: -150px;
        animation-delay: -6s;
        opacity: 0.12;
    }
    @keyframes orbDrift {
        from { transform: translate(0, 0) scale(1); }
        to   { transform: translate(40px, 30px) scale(1.08); }
    }

    /* ── Entrance keyframes ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position:  200% center; }
    }
    @keyframes countUp {
        from { opacity: 0; transform: translateY(12px) scale(0.9); }
        to   { opacity: 1; transform: translateY(0)  scale(1); }
    }
    @keyframes lineGrow {
        from { transform: scaleX(0); }
        to   { transform: scaleX(1); }
    }
    @keyframes pulse-ring {
        0%   { box-shadow: 0 0 0 0 rgba(201,169,110,0.35); }
        70%  { box-shadow: 0 0 0 12px rgba(201,169,110,0); }
        100% { box-shadow: 0 0 0 0 rgba(201,169,110,0); }
    }
    @keyframes tickerScroll {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* ── z-index layer ── */
    .hero-card, .stats-grid, .quick-actions, .activity-row {
        position: relative;
        z-index: 1;
    }

    /* ══════════════════════════════════════
       HERO
    ══════════════════════════════════════ */
    .hero-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 3rem 3rem 3rem;
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 2rem;
        overflow: hidden;
        position: relative;
        animation: fadeUp .7s var(--ease-out) both;
    }

    /* decorative corner lines */
    .hero-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: var(--radius-lg);
        background: linear-gradient(135deg, rgba(201,169,110,0.08) 0%, transparent 55%);
        pointer-events: none;
    }
    .hero-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 180px; height: 1px;
        background: linear-gradient(90deg, var(--gold), transparent);
        transform-origin: left center;
        animation: lineGrow 1s var(--ease-out) .4s both;
    }

    .hero-eyebrow {
        font-family: 'DM Sans', sans-serif;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: .75rem;
        display: flex;
        align-items: center;
        gap: .5rem;
        animation: fadeIn .5s ease .3s both;
    }
    .hero-eyebrow::before {
        content: '';
        display: inline-block;
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--gold);
        animation: pulse-ring 2s infinite;
    }

    .hero-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 700;
        line-height: 1.2;
        margin: 0 0 .75rem;
        background: linear-gradient(100deg, var(--text) 30%, var(--gold-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: fadeUp .6s var(--ease-out) .2s both;
    }

    .hero-card p {
        font-size: .95rem;
        font-weight: 300;
        color: var(--muted);
        max-width: 460px;
        margin: 0;
        line-height: 1.7;
        animation: fadeUp .6s var(--ease-out) .35s both;
    }

    .hero-actions {
        display: flex;
        flex-direction: column;
        gap: .75rem;
        animation: fadeUp .7s var(--ease-out) .5s both;
    }

    /* ── Buttons ── */
    .btn-primary, .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
        padding: .75rem 1.6rem;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        font-weight: 500;
        letter-spacing: .02em;
        text-decoration: none;
        white-space: nowrap;
        transition: transform .2s var(--ease-out), box-shadow .2s ease, background .2s ease;
        position: relative;
        overflow: hidden;
    }
    .btn-primary::before, .btn-secondary::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.12) 50%, transparent 100%);
        background-size: 200% 100%;
        opacity: 0;
        transition: opacity .3s;
    }
    .btn-primary:hover::before, .btn-secondary:hover::before {
        opacity: 1;
        animation: shimmer .7s ease forwards;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--gold) 0%, #a87d45 100%);
        color: #0d0f14;
        box-shadow: 0 4px 20px rgba(201,169,110,0.3);
    }
    .btn-primary:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 32px rgba(201,169,110,0.45);
    }
    .btn-primary:active { transform: translateY(0) scale(.98); }

    .btn-secondary {
        background: var(--surface-2);
        color: var(--text);
        border: 1px solid var(--border);
    }
    .btn-secondary:hover {
        transform: translateY(-2px) scale(1.02);
        border-color: rgba(255,255,255,0.18);
        box-shadow: 0 6px 24px rgba(0,0,0,0.3);
    }
    .btn-secondary:active { transform: translateY(0) scale(.98); }

    /* ── Arrow icon ── */
    .btn-icon {
        display: inline-block;
        transition: transform .2s ease;
    }
    .btn-primary:hover .btn-icon,
    .btn-secondary:hover .btn-icon {
        transform: translateX(3px);
    }

    /* ══════════════════════════════════════
       STATS GRID
    ══════════════════════════════════════ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }

    .stat-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem 2rem;
        position: relative;
        overflow: hidden;
        transition: transform .25s var(--ease-out), border-color .25s ease, box-shadow .25s ease;
        cursor: default;
    }
    .stat-box:nth-child(1) { animation: fadeUp .6s var(--ease-out) .15s both; }
    .stat-box:nth-child(2) { animation: fadeUp .6s var(--ease-out) .28s both; }
    .stat-box:nth-child(3) { animation: fadeUp .6s var(--ease-out) .41s both; }

    .stat-box::before {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--gold), transparent);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .35s var(--ease-out);
    }
    .stat-box:hover::before { transform: scaleX(1); }

    .stat-box:hover {
        transform: translateY(-4px);
        border-color: rgba(201,169,110,0.25);
        box-shadow: 0 16px 40px rgba(0,0,0,0.35);
    }

    .stat-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: var(--accent-dim);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1rem;
    }
    .stat-box:nth-child(1) .stat-icon { background: rgba(201,169,110,0.12); }
    .stat-box:nth-child(2) .stat-icon { background: rgba(61,90,255,0.15); }
    .stat-box:nth-child(3) .stat-icon { background: rgba(34,197,94,0.12); }

    .stat-box h3 {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        font-weight: 700;
        margin: 0 0 .3rem;
        line-height: 1;
        animation: countUp .5s var(--ease-out) .6s both;
        background: linear-gradient(135deg, var(--text), var(--gold-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-box p {
        font-size: .8rem;
        font-weight: 400;
        color: var(--muted);
        margin: 0;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .stat-trend {
        position: absolute;
        top: 1.5rem; right: 1.5rem;
        font-size: .72rem;
        font-weight: 500;
        padding: .25rem .6rem;
        border-radius: 100px;
    }
    .trend-up   { background: rgba(34,197,94,0.12); color: #4ade80; }
    .trend-down { background: rgba(239,68,68,0.12); color: #f87171; }
    .trend-flat { background: rgba(107,114,128,0.15); color: var(--muted); }

    /* ══════════════════════════════════════
       BOTTOM ROW — Quick actions + Activity
    ══════════════════════════════════════ */
    .activity-row {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 1.25rem;
        animation: fadeUp .7s var(--ease-out) .55s both;
    }

    /* ── Panel base ── */
    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        transition: border-color .25s ease;
    }
    .panel:hover { border-color: rgba(255,255,255,0.12); }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .panel-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 600;
        margin: 0;
        color: var(--text);
    }
    .panel-badge {
        font-size: .7rem;
        font-weight: 500;
        color: var(--muted);
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    /* ── Quick actions list ── */
    .action-list {
        list-style: none;
        margin: 0; padding: 0;
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }
    .action-item {
        animation: fadeUp .4s var(--ease-out) both;
    }
    .action-item:nth-child(1) { animation-delay: .65s; }
    .action-item:nth-child(2) { animation-delay: .75s; }
    .action-item:nth-child(3) { animation-delay: .85s; }
    .action-item:nth-child(4) { animation-delay: .95s; }

    .action-link {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .8rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        color: var(--text);
        font-size: .88rem;
        font-weight: 400;
        transition: background .2s ease, transform .2s var(--ease-out), color .2s;
        position: relative;
        overflow: hidden;
    }
    .action-link::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(201,169,110,0.08), transparent);
        opacity: 0;
        transition: opacity .2s;
    }
    .action-link:hover {
        background: var(--surface-2);
        transform: translateX(4px);
        color: var(--gold-light);
    }
    .action-link:hover::before { opacity: 1; }

    .action-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
        transition: transform .2s var(--ease-out);
    }
    .action-link:hover .action-icon { transform: scale(1.15); }

    .action-icon.blue  { background: rgba(61,90,255,0.15); }
    .action-icon.gold  { background: rgba(201,169,110,0.12); }
    .action-icon.green { background: rgba(34,197,94,0.1); }
    .action-icon.rose  { background: rgba(251,113,133,0.1); }

    .action-label { flex: 1; }
    .action-arrow {
        color: var(--muted);
        font-size: .75rem;
        transition: color .2s, transform .2s ease;
    }
    .action-link:hover .action-arrow {
        color: var(--gold);
        transform: translateX(3px);
    }

    /* ── Activity feed ── */
    .activity-feed {
        list-style: none;
        margin: 0; padding: 0;
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: .9rem 0;
        border-bottom: 1px solid var(--border);
        position: relative;
        animation: fadeUp .4s var(--ease-out) both;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-item:nth-child(1) { animation-delay: .6s; }
    .activity-item:nth-child(2) { animation-delay: .72s; }
    .activity-item:nth-child(3) { animation-delay: .84s; }
    .activity-item:nth-child(4) { animation-delay: .96s; }

    .activity-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: var(--surface-2);
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem;
        font-weight: 600;
        flex-shrink: 0;
        color: var(--gold);
        border: 1px solid var(--border);
        transition: transform .2s ease;
    }
    .activity-item:hover .activity-avatar { transform: scale(1.08); }

    .activity-body { flex: 1; min-width: 0; }
    .activity-text {
        font-size: .85rem;
        color: var(--text);
        line-height: 1.5;
        margin: 0 0 .2rem;
    }
    .activity-text strong { color: var(--gold-light); font-weight: 500; }
    .activity-time {
        font-size: .72rem;
        color: var(--muted);
        margin: 0;
    }

    .activity-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--gold);
        flex-shrink: 0;
        margin-top: .45rem;
        opacity: .5;
    }
    .activity-item.unread .activity-dot { opacity: 1; }

    /* ══════════════════════════════════════
       TICKER
    ══════════════════════════════════════ */
    .ticker-wrap {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: .6rem 0;
        overflow: hidden;
        animation: fadeIn .8s ease .9s both;
    }
    .ticker-track {
        display: flex;
        width: max-content;
        animation: tickerScroll 28s linear infinite;
    }
    .ticker-track:hover { animation-play-state: paused; }
    .ticker-inner {
        display: flex;
        gap: 0;
    }
    .ticker-item {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: 0 2rem;
        font-size: .75rem;
        color: var(--muted);
        white-space: nowrap;
        border-right: 1px solid var(--border);
    }
    .ticker-item:last-child { border-right: none; }
    .ticker-dot {
        width: 5px; height: 5px;
        border-radius: 50%;
        background: var(--gold);
        opacity: .6;
    }

    /* ══════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════ */
    @media (max-width: 900px) {
        .hero-card    { grid-template-columns: 1fr; }
        .hero-actions { flex-direction: row; flex-wrap: wrap; }
        .stats-grid   { grid-template-columns: repeat(2, 1fr); }
        .activity-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 550px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- ===================== MARKUP ===================== --}}
<div class="dash-wrap">

    {{-- ── TICKER ── --}}
    <div class="ticker-wrap" aria-hidden="true">
        <div class="ticker-track">
            {{-- duplicated for seamless loop --}}
            @foreach ([0,1] as $_)
            <div class="ticker-inner">
                <span class="ticker-item"><span class="ticker-dot"></span> 3 assignments due this week</span>
                <span class="ticker-item"><span class="ticker-dot"></span> Module 4 — Introduction to Algorithms added</span>
                <span class="ticker-item"><span class="ticker-dot"></span> New enrolment: Maria Santos joined Web Dev 101</span>
                <span class="ticker-item"><span class="ticker-dot"></span> Average quiz score this month: 78%</span>
                <span class="ticker-item"><span class="ticker-dot"></span> 2 student messages awaiting reply</span>
                <span class="ticker-item"><span class="ticker-dot"></span> Next live session: Friday 10:00 AM</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── HERO ── --}}
    <section class="hero-card" aria-label="Welcome hero">
        <div>
            <p class="hero-eyebrow">Instructor workspace</p>
            <h2>Welcome back, {{ auth()->user()->name ?? 'Instructor' }}</h2>
            <p>Manage your courses, modules, and student progress from one polished workspace.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('teacher.courses.index') }}" class="btn-primary">
                Manage courses <span class="btn-icon">→</span>
            </a>
            <a href="{{ route('teacher.modules.index') }}" class="btn-secondary">
                View modules <span class="btn-icon">→</span>
            </a>
        </div>
    </section>

    {{-- ── STATS ── --}}
    <section class="stats-grid" aria-label="Key statistics">

        <div class="stat-box">
            <div class="stat-icon">📚</div>
            <span class="stat-trend trend-up">↑ 2</span>
            <h3>12</h3>
            <p>Active courses</p>
        </div>

        <div class="stat-box">
            <div class="stat-icon">📈</div>
            <span class="stat-trend trend-up">↑ 6%</span>
            <h3>84%</h3>
            <p>Avg. completion</p>
        </div>

        <div class="stat-box">
            <div class="stat-icon">🎓</div>
            <span class="stat-trend trend-up">↑ 5</span>
            <h3>24</h3>
            <p>Enrolled students</p>
        </div>

    </section>

    {{-- ── BOTTOM ROW ── --}}
    <div class="activity-row">

        {{-- Quick actions --}}
        <div class="panel" aria-label="Quick actions">
            <div class="panel-header">
                <h3 class="panel-title">Quick actions</h3>
                <span class="panel-badge">Shortcuts</span>
            </div>
            <ul class="action-list">
                <li class="action-item">
                    <a href="{{ route('teacher.courses.index') }}" class="action-link">
                        <span class="action-icon blue">🗂️</span>
                        <span class="action-label">Browse all courses</span>
                        <span class="action-arrow">›</span>
                    </a>
                </li>
                <li class="action-item">
                    <a href="{{ route('teacher.modules.index') }}" class="action-link">
                        <span class="action-icon gold">🧩</span>
                        <span class="action-label">Manage modules</span>
                        <span class="action-arrow">›</span>
                    </a>
                </li>
                <li class="action-item">
                    <a href="#" class="action-link">
                        <span class="action-icon green">✅</span>
                        <span class="action-label">Track progress</span>
                        <span class="action-arrow">›</span>
                    </a>
                </li>
                <li class="action-item">
                    <a href="#" class="action-link">
                        <span class="action-icon rose">📅</span>
                        <span class="action-label">Schedule sessions</span>
                        <span class="action-arrow">›</span>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Activity feed --}}
        <div class="panel" aria-label="Recent activity">
            <div class="panel-header">
                <h3 class="panel-title">Recent activity</h3>
                <span class="panel-badge">Last 24 h</span>
            </div>
            <ul class="activity-feed">
                <li class="activity-item unread">
                    <span class="activity-avatar">MS</span>
                    <div class="activity-body">
                        <p class="activity-text"><strong>Maria Santos</strong> submitted Assignment 3 in Web Dev 101</p>
                        <p class="activity-time">12 minutes ago</p>
                    </div>
                    <span class="activity-dot"></span>
                </li>
                <li class="activity-item unread">
                    <span class="activity-avatar">JL</span>
                    <div class="activity-body">
                        <p class="activity-text"><strong>Juan Luna</strong> completed Module 2 — CSS Fundamentals</p>
                        <p class="activity-time">1 hour ago</p>
                    </div>
                    <span class="activity-dot"></span>
                </li>
                <li class="activity-item">
                    <span class="activity-avatar">RC</span>
                    <div class="activity-body">
                        <p class="activity-text"><strong>Rosa Cruz</strong> asked a question in the discussion board</p>
                        <p class="activity-time">3 hours ago</p>
                    </div>
                    <span class="activity-dot"></span>
                </li>
                <li class="activity-item">
                    <span class="activity-avatar">AP</span>
                    <div class="activity-body">
                        <p class="activity-text"><strong>A. Perez</strong> enrolled in Introduction to Algorithms</p>
                        <p class="activity-time">Yesterday, 5:44 PM</p>
                    </div>
                    <span class="activity-dot"></span>
                </li>
            </ul>
        </div>

    </div>

</div>

@endsection