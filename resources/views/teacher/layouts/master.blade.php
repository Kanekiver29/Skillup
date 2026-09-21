<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trainer Portal') | SkillUp</title>

    <link rel="icon" href="{{ asset('image/hello.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,500;6..72,600;6..72,700&family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
    <style>
        /* ══ TOKENS ═══════════════════════════════════════════════
           TESDA identity: royal blue (structure), gold (the trainer's
           mark — bookmark ribbon, focus, highlights), red (used only
           for the flag-stripe and destructive actions).
           Type: Newsreader for headings (classroom/print warmth),
           Public Sans for interface text (clear, government-grade). */
        :root {
            --blue-950: #061a48;
            --blue-900: #0a2461;
            --blue-800: #0e2f7d;
            --blue-700: #143b9a;
            --blue-500: #3a63c8;
            --blue-100: #dbe5fa;
            --blue-50:  #eef3fc;

            --gold:      #f2b705;
            --gold-deep: #b98500;
            --gold-soft: rgba(242, 183, 5, 0.16);
            --red:       #c8102e;

            --page:    #f2f5fa;
            --surface: #ffffff;
            --line:    #dde4f0;
            --line-soft: #eaeff8;
            --ink:     #14203f;
            --ink-2:   #38466a;
            --muted:   #5f6b85;

            --sidebar-w: 278px;
            --topbar-h:  70px;
            --r-sm: 6px;
            --r-md: 10px;
            --r-lg: 14px;

            --shadow-card: 0 1px 2px rgba(10, 36, 97, 0.05), 0 6px 18px -10px rgba(10, 36, 97, 0.16);
            --ease: cubic-bezier(0.22, 1, 0.36, 1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Public Sans', 'Segoe UI', Arial, sans-serif;
            background: var(--page);
            color: var(--ink);
            min-height: 100vh;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        button { font: inherit; }
        h1, h2, h3 { font-family: 'Newsreader', Georgia, serif; }
        ::selection { background: var(--gold-soft); }
        :focus-visible { outline: 2px solid var(--gold); outline-offset: 2px; border-radius: 4px; }

        /* flag stripe — blue / red / gold, pinned to the very top */
        body::before {
            content: '';
            position: fixed; top: 0; left: 0; right: 0; height: 4px; z-index: 60;
            background: linear-gradient(90deg, var(--blue-700) 0 60%, var(--red) 60% 80%, var(--gold) 80% 100%);
        }

        .skip-link {
            position: fixed; top: -60px; left: 1rem; z-index: 100;
            background: var(--blue-950); color: #fff;
            padding: .7rem 1.1rem; border-radius: var(--r-sm);
            font-weight: 600; font-size: .85rem; transition: top .2s;
        }
        .skip-link:focus { top: 1rem; }

        @keyframes pageIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
        @keyframes dotPulse {
            0% { box-shadow: 0 0 0 0 rgba(34,197,94,.5); }
            70%, 100% { box-shadow: 0 0 0 7px rgba(34,197,94,0); }
        }

        .app-shell { display: flex; min-height: 100vh; }

        /* ══ SIDEBAR ═════════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--blue-900);
            color: #fff;
            display: flex; flex-direction: column;
            padding: 4px .85rem 1rem;
            position: sticky; top: 0; height: 100vh; z-index: 20;
            overflow: hidden;
            /* faint ruled-notebook lines: the only texture */
            background-image: repeating-linear-gradient(to bottom, transparent 0 31px, rgba(255,255,255,.035) 31px 32px);
        }

        .brand {
            display: flex; align-items: center; gap: .85rem;
            padding: 1.3rem .5rem 1.15rem;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .brand-logo-wrap {
            width: 50px; height: 50px; flex-shrink: 0;
            display: grid; place-items: center;
            background: #fff; border-radius: 50%;
            box-shadow: 0 0 0 3px var(--gold);
        }
        .brand-logo { width: 34px; height: 34px; object-fit: contain; }
        .brand-text strong {
            display: block; font-family: 'Newsreader', Georgia, serif;
            font-size: 1.2rem; font-weight: 700; line-height: 1.15;
        }
        .brand-text span { display: block; margin-top: .2rem; font-size: .74rem; color: rgba(255,255,255,.62); }

        .nav-links {
            flex: 1; overflow-y: auto; position: relative;
            display: flex; flex-direction: column; gap: 2px;
            padding: .4rem 0 .5rem;
            scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.16) transparent;
        }
        .nav-section-label {
            font-family: 'Newsreader', Georgia, serif; font-style: italic;
            font-size: .88rem; color: var(--gold);
            padding: 1rem .8rem .3rem; position: relative; z-index: 1;
        }

        /* one shared highlight that glides to the hovered / active link */
        .nav-indicator {
            position: absolute; left: 0; right: 0; height: 40px;
            border-radius: var(--r-md);
            background: rgba(255,255,255,.09);
            opacity: 0; pointer-events: none; z-index: 0;
            transition: top .32s var(--ease), height .32s var(--ease), opacity .2s;
        }

        .nav-link {
            display: flex; align-items: center; gap: .75rem;
            padding: .58rem .8rem;
            border-radius: var(--r-md);
            color: rgba(255,255,255,.74);
            font-size: .875rem; font-weight: 500;
            position: relative; z-index: 1;
            transition: color .2s;
        }
        .nav-link:hover, .nav-link:focus-visible { color: #fff; }
        .nav-link.active { color: #fff; font-weight: 600; }

        /* gold bookmark ribbon on the active page */
        .nav-link.active::after {
            content: ''; position: absolute; right: 12px; top: -2px;
            width: 12px; height: 15px; background: var(--gold);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 72%, 0 100%);
        }
        .nav-link.active .nav-icon { background: var(--gold); color: var(--blue-950); }

        .nav-icon {
            width: 30px; height: 30px; border-radius: var(--r-sm);
            background: rgba(255,255,255,.08);
            display: grid; place-items: center; flex-shrink: 0;
            transition: background .2s, color .2s;
        }
        .icon { width: 17px; height: 17px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; display: block; }
        .nav-link-label { flex: 1; }

        .sidebar-footer { padding-top: .9rem; border-top: 1px solid rgba(255,255,255,.12); }
        .signout-btn {
            width: 100%; display: flex; align-items: center; justify-content: center; gap: .55rem;
            padding: .68rem 1rem; border-radius: var(--r-md);
            border: 1px solid rgba(255,255,255,.22); background: transparent;
            color: rgba(255,255,255,.88); font-weight: 600; font-size: .85rem; cursor: pointer;
            transition: background .2s, border-color .2s, color .2s;
        }
        .signout-btn:hover { background: rgba(200,16,46,.22); border-color: rgba(255,140,150,.5); color: #ffd5da; }
        .signout-btn .icon { width: 15px; height: 15px; }

        /* ══ MAIN + TOPBAR ═══════════════════════════════════════ */
        .main-panel { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        .topbar {
            height: var(--topbar-h); padding: 4px 1.7rem 0;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--line);
            position: sticky; top: 0; z-index: 15;
        }
        .topbar-left { display: flex; align-items: center; gap: .9rem; min-width: 0; }

        .mobile-toggle {
            display: none; width: 40px; height: 40px; flex-shrink: 0;
            align-items: center; justify-content: center;
            border: 1px solid var(--line); border-radius: var(--r-md);
            background: var(--blue-50); color: var(--blue-800); cursor: pointer;
        }
        .mobile-toggle:hover { background: var(--blue-100); }
        .mobile-toggle .icon { width: 19px; height: 19px; }

        .topbar-title { min-width: 0; }
        .topbar-title small { display: block; color: var(--muted); font-size: .78rem; font-weight: 500; }
        .topbar-title h1 {
            font-size: 1.4rem; font-weight: 600; color: var(--blue-950);
            letter-spacing: -.01em; line-height: 1.2;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .topbar-user {
            display: inline-flex; align-items: center; gap: .65rem; flex-shrink: 0;
            padding: .3rem .95rem .3rem .3rem; border-radius: 999px;
            background: var(--blue-50); border: 1px solid var(--line);
            font-size: .85rem; font-weight: 600; color: var(--blue-900);
        }
        .topbar-user-text { display: grid; line-height: 1.2; }
        .topbar-user-text small { font-weight: 500; font-size: .7rem; color: var(--muted); }
        .topbar-user-name { max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        .avatar-wrap { position: relative; }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--blue-800); color: var(--gold);
            display: grid; place-items: center;
            font-family: 'Newsreader', Georgia, serif; font-size: 1.05rem; font-weight: 700;
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px var(--gold);
        }
        .avatar-dot {
            position: absolute; bottom: 0; right: 0; width: 9px; height: 9px;
            border-radius: 50%; background: #22c55e; border: 2px solid #fff;
            animation: dotPulse 2.4s ease-out infinite;
        }

        /* ══ CONTENT ═════════════════════════════════════════════ */
        .page-content {
            padding: 1.7rem; display: flex; flex-direction: column; gap: 1.1rem;
            max-width: 1400px; width: 100%; margin: 0 auto;
            animation: pageIn .45s var(--ease) both;
        }

        .alert {
            display: flex; align-items: center; gap: .7rem;
            padding: .85rem 1.1rem; border-radius: var(--r-md);
            background: #fff9e3; border: 1px solid #f0d879; border-left: 4px solid var(--gold);
            color: #5c4300; font-weight: 600; font-size: .88rem;
        }
        .alert-icon {
            width: 24px; height: 24px; border-radius: 50%; flex-shrink: 0;
            background: var(--gold); color: var(--blue-950); display: grid; place-items: center;
        }
        .alert-icon .icon { width: 13px; height: 13px; stroke-width: 2.6; }

        .card {
            background: var(--surface); border: 1px solid var(--line);
            border-radius: var(--r-lg); box-shadow: var(--shadow-card); padding: 1.3rem;
            transition: border-color .2s;
        }
        .card:hover { border-color: var(--blue-100); }

        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(132px, 1fr)); gap: .75rem; }
        .action-button {
            padding: .8rem 1rem; border: 1px solid var(--line); border-radius: var(--r-md);
            background: var(--surface); color: var(--blue-900);
            font-weight: 600; font-size: .875rem; cursor: pointer;
            transition: background .2s, border-color .2s, color .2s;
        }
        .action-button:hover { background: var(--blue-50); border-color: var(--blue-700); color: var(--blue-700); }

        .overlay {
            display: none; position: fixed; inset: 0; z-index: 10;
            background: rgba(6,26,72,.55); opacity: 0; pointer-events: none; transition: opacity .25s;
        }
        .overlay.visible { opacity: 1; pointer-events: auto; }

        /* ══ PORTAL COMPONENTS (used by child pages) ═════════════ */
        .portal-page { display: grid; gap: 1.25rem; }
        .portal-heading { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .portal-heading h2 { color: var(--blue-950); font-size: 1.55rem; font-weight: 600; letter-spacing: -.01em; }
        .portal-heading p { margin-top: .3rem; color: var(--muted); font-size: .9rem; }
        .portal-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
        .portal-card {
            padding: 1.15rem 1.2rem; background: var(--surface);
            border: 1px solid var(--line); border-top: 3px solid var(--blue-700);
            border-radius: var(--r-lg); box-shadow: var(--shadow-card);
        }
        .portal-card h3 { margin-bottom: .4rem; color: var(--blue-950); font-size: 1.1rem; font-weight: 600; }
        .portal-card p, .portal-card span, .portal-card small { color: var(--muted); font-size: .85rem; line-height: 1.6; }
        .portal-card strong { display: block; color: var(--blue-900); font-family: 'Newsreader', Georgia, serif; font-size: 2rem; font-weight: 700; line-height: 1.2; }
        .portal-link, .portal-button {
            display: inline-flex; margin-top: .8rem; padding: .55rem .9rem;
            border-radius: var(--r-sm); background: var(--blue-800); color: #fff;
            font-size: .82rem; font-weight: 600; transition: background .2s;
        }
        .portal-link:hover, .portal-button:hover { background: var(--blue-700); }
        .portal-table-wrap { overflow-x: auto; background: var(--surface); border: 1px solid var(--line); border-radius: var(--r-lg); box-shadow: var(--shadow-card); }
        .portal-table { width: 100%; min-width: 680px; border-collapse: collapse; }
        .portal-table th, .portal-table td { padding: .85rem 1rem; text-align: left; border-bottom: 1px solid var(--line-soft); font-size: .86rem; }
        .portal-table th { color: var(--blue-900); background: var(--blue-50); font-weight: 600; border-bottom: 2px solid var(--blue-100); }
        .portal-table td { color: var(--ink-2); }
        .portal-table tbody tr:hover td { background: #fafcff; }

        /* ══ RESPONSIVE + MOTION ═════════════════════════════════ */
        @media (max-width: 960px) {
            .sidebar { position: fixed; left: 0; top: 0; transform: translateX(-100%); transition: transform .32s var(--ease); }
            .sidebar.open { transform: none; }
            .mobile-toggle { display: inline-flex; }
            .overlay { display: block; }
        }
        @media (max-width: 640px) {
            .topbar-user-text { display: none; }
            .topbar-user { padding: .3rem; }
            .topbar { padding-left: 1rem; padding-right: 1rem; }
            .topbar-title h1 { font-size: 1.2rem; }
        }
        @media (max-width: 480px) { .page-content { padding: 1rem; } }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; scroll-behavior: auto !important; }
        }
    </style>
</head>
<body>

<a href="#main-content" class="skip-link">Skip to content</a>

{{-- ─── ICON SPRITE ─── --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <defs>
        <symbol id="icon-dashboard" viewBox="0 0 24 24"><rect x="3" y="3" width="7.5" height="7.5" rx="1.6"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="1.6"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="1.6"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.6"/></symbol>
        <symbol id="icon-courses" viewBox="0 0 24 24"><path d="M2 9l10-5 10 5-10 5z"/><path d="M6 11.5V16c0 1.4 2.7 3 6 3s6-1.6 6-3v-4.5"/><line x1="22" y1="9" x2="22" y2="14"/></symbol>
        <symbol id="icon-subject" viewBox="0 0 24 24"><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/></symbol>
        <symbol id="icon-modules" viewBox="0 0 24 24"><line x1="4" y1="6.5" x2="20" y2="6.5"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17.5" x2="14" y2="17.5"/></symbol>
        <symbol id="icon-quiz" viewBox="0 0 24 24"><rect x="5" y="3.5" width="14" height="17.5" rx="2"/><path d="M9 3.5V2h6v1.5"/><path d="M8.8 12.4l2.2 2.2 4-4.4"/></symbol>
        <symbol id="icon-students" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.1"/><path d="M3.3 20c0-3.4 2.6-6 5.7-6s5.7 2.6 5.7 6"/><circle cx="17.3" cy="9" r="2.3"/><path d="M15.6 14.2c2.6.3 4.7 2.6 4.7 5.8"/></symbol>
        <symbol id="icon-calendar" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="3" x2="8" y2="7"/><line x1="16" y1="3" x2="16" y2="7"/></symbol>
        <symbol id="icon-check" viewBox="0 0 24 24"><polyline points="5,13 10,18 19,7"/></symbol>
        <symbol id="icon-award" viewBox="0 0 24 24"><circle cx="12" cy="9" r="5.5"/><path d="M9 13.8L8 21.5l4-2 4 2-1-7.7"/></symbol>
        <symbol id="icon-progress" viewBox="0 0 24 24"><polyline points="4,17 9.5,10.5 13.5,14 20,6.2"/><polyline points="14.5,6.2 20,6.2 20,12"/></symbol>
        <symbol id="icon-report" viewBox="0 0 24 24"><path d="M7 3h7l4 4v14H7z"/><path d="M14 3v4h4"/><line x1="9.5" y1="13" x2="15.5" y2="13"/><line x1="9.5" y1="17" x2="15.5" y2="17"/></symbol>
        <symbol id="icon-announce" viewBox="0 0 24 24"><path d="M4 10v4h3l7 4V6L7 10z"/><path d="M17.5 9a4 4 0 0 1 0 6"/></symbol>
        <symbol id="icon-profile" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></symbol>
        <symbol id="icon-signout" viewBox="0 0 24 24"><path d="M9 4H6.5A2.5 2.5 0 0 0 4 6.5v11A2.5 2.5 0 0 0 6.5 20H9"/><polyline points="14,15.5 18.5,11 14,6.5"/><line x1="18.3" y1="11" x2="9" y2="11"/></symbol>
        <symbol id="icon-menu" viewBox="0 0 24 24"><line x1="3.5" y1="7" x2="20.5" y2="7"/><line x1="3.5" y1="12" x2="20.5" y2="12"/><line x1="3.5" y1="17" x2="20.5" y2="17"/></symbol>
    </defs>
</svg>

@php
    // [label, route name, active pattern, icon]
    $navGroups = [
        'Main' => [
            ['Dashboard',            'teacher.dashboard',        'teacher.dashboard',     'dashboard'],
            ['My Training Programs', 'teacher.courses.index',    'teacher.courses*',      'courses'],
            ['Subjects',             'teacher.subjects.index',   'teacher.subjects*',     'subject'],
            ['Competency / Modules', 'teacher.modules.index',    'teacher.modules*',      'modules'],
        ],
        'Training operations' => [
            ['My Classes / Batches', 'teacher.classes.index',       'teacher.classes*',    'students'],
            ['Training Schedule',    'teacher.schedule.index',      'teacher.schedule*',   'calendar'],
            ['Attendance',           'teacher.attendance.overview', 'teacher.attendance*', 'check'],
        ],
        'Learning & assessment' => [
            ['Learning Materials', 'teacher.materials.index',   'teacher.materials*',   'subject'],
            ['Assessment',         'teacher.assessments.index', 'teacher.assessments*', 'quiz'],
        ],
        'Trainees & reports' => [
            ['Trainees',         'teacher.students.index',      'teacher.students*',      'students'],
            ['Trainee Progress', 'teacher.progress.index',      'teacher.progress*',      'progress'],
            ['Student Grades',   'teacher.grades.index',        'teacher.grades*',        'award'],
            ['Reports',          'teacher.reports.index',       'teacher.reports*',       'report'],
            ['Announcements',    'teacher.announcements.index', 'teacher.announcements*', 'announce'],
        ],
        'Account' => [
            ['Trainer Profile',  'teacher.profile.edit',  'teacher.profile*', 'profile'],
            ['Account Settings', 'teacher.account.index', 'teacher.account*', 'profile'],
        ],
    ];
    $userName = auth()->user()->name ?? 'Instructor';
@endphp

<div class="app-shell">

    {{-- ─── SIDEBAR ─── --}}
    <aside class="sidebar" id="sidebar" aria-label="Trainer navigation">
        <div class="brand">
            <div class="brand-logo-wrap">
                <img src="{{ asset('image/hello.png') }}" alt="SkillUp Logo" class="brand-logo">
            </div>
            <div class="brand-text">
                <strong>SkillUp Trainer</strong>
                <span>TESDA Learning Portal</span>
            </div>
        </div>

        <nav class="nav-links" id="navLinks">
            <div class="nav-indicator" id="navIndicator"></div>

            @foreach($navGroups as $group => $items)
                <div class="nav-section-label">{{ $group }}</div>
                @foreach($items as [$label, $routeName, $pattern, $icon])
                    @php $isActive = request()->routeIs($pattern); @endphp
                    <a class="nav-link {{ $isActive ? 'active' : '' }}"
                       href="{{ route($routeName) }}"
                       @if($isActive) aria-current="page" @endif>
                        <span class="nav-icon"><svg class="icon"><use href="#icon-{{ $icon }}"/></svg></span>
                        <span class="nav-link-label">{{ $label }}</span>
                    </a>
                @endforeach
            @endforeach
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('teacher.logout') }}">
                @csrf
                <button type="submit" class="signout-btn">
                    <svg class="icon"><use href="#icon-signout"/></svg>
                    <span>Sign out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="overlay" id="sidebarOverlay"></div>

    {{-- ─── MAIN PANEL ─── --}}
    <div class="main-panel">
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" id="mobileToggle" type="button" aria-label="Toggle navigation" aria-controls="sidebar" aria-expanded="false">
                    <svg class="icon"><use href="#icon-menu"/></svg>
                </button>
                <div class="topbar-title">
                    <small id="topbarGreeting">Trainer workspace</small>
                    <h1>@yield('page_title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="topbar-user" title="{{ $userName }}">
                <div class="avatar-wrap">
                    <div class="avatar">{{ strtoupper(substr($userName, 0, 1)) }}</div>
                    <span class="avatar-dot" aria-hidden="true"></span>
                </div>
                <div class="topbar-user-text">
                    <span class="topbar-user-name">{{ $userName }}</span>
                    <small>TESDA Trainer</small>
                </div>
            </div>
        </header>

        <main class="page-content" id="main-content">
            @if(session('success'))
                <div class="alert" role="alert">
                    <div class="alert-icon"><svg class="icon"><use href="#icon-check"/></svg></div>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    (function () {
        const sidebar   = document.getElementById('sidebar');
        const overlay   = document.getElementById('sidebarOverlay');
        const toggle    = document.getElementById('mobileToggle');
        const navLinks  = document.getElementById('navLinks');
        const indicator = document.getElementById('navIndicator');

        const setOpen = open => {
            sidebar.classList.toggle('open', open);
            overlay.classList.toggle('visible', open);
            toggle.setAttribute('aria-expanded', String(open));
        };
        toggle.addEventListener('click', () => setOpen(!sidebar.classList.contains('open')));
        overlay.addEventListener('click', () => setOpen(false));
        document.addEventListener('keydown', e => e.key === 'Escape' && setOpen(false));

        /* shared highlight glides to hovered/focused link, rests on the active one */
        const active = navLinks.querySelector('.nav-link.active');
        const moveTo = el => {
            if (!el) { indicator.style.opacity = '0'; return; }
            indicator.style.top = el.offsetTop + 'px';
            indicator.style.height = el.offsetHeight + 'px';
            indicator.style.opacity = '1';
        };
        if (active) {
            indicator.style.transition = 'none';
            moveTo(active);
            requestAnimationFrame(() => { indicator.style.transition = ''; });
            active.scrollIntoView({ block: 'nearest' });
        }
        navLinks.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('mouseenter', () => moveTo(link));
            link.addEventListener('focus', () => moveTo(link));
        });
        navLinks.addEventListener('mouseleave', () => moveTo(active));

        /* time-based greeting */
        const h = new Date().getHours();
        document.getElementById('topbarGreeting').textContent =
            h < 12 ? 'Good morning' : h < 18 ? 'Good afternoon' : 'Good evening';
    })();
</script>
@stack('scripts')
</body>
</html>