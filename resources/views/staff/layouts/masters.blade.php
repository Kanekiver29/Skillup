<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Staff Portal') — SkillUp</title>

    <link rel ="icon" href="{{ asset('image/logo_oif_skillup_1_-removebg-preview.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js (lightweight UI reactivity) + Font Awesome (icons) - CDN fallback for development -->
    <script src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @stack('styles')

    <style>
        /* ══════════════════════════════════════════════
           TOKENS — "Aurora Grid" futuristic system
           display: Space Grotesk / body: Inter / data: JetBrains Mono
        ══════════════════════════════════════════════ */
        :root {
            --sb-w:          264px;
            --sb-col:         68px;
            --topbar-h:       64px;
            --scan-h:          3px;

            /* Sidebar palette — deep space navy w/ cyan+violet signal */
            --sb-bg-top:     #0a1330;
            --sb-bg-mid:     #071026;
            --sb-bg-bot:     #020617;
            --sb-border:     rgba(148,197,255,.10);
            --sb-accent:     #2563eb;
            --sb-accent-s:   #38bdf8;
            --sb-accent-2:   #8b5cf6;
            --sb-accent-bg:  rgba(56,189,248,.16);
            --sb-accent-glow:rgba(56,189,248,.38);
            --sb-text:       #eaf1ff;
            --sb-muted:      rgba(207,222,255,.46);
            --sb-hover:      rgba(148,197,255,.08);
            --sb-active-txt: #7dd3fc;
            --sb-danger:     #fb7185;
            --sb-danger-bg:  rgba(251,113,133,.14);
            --sb-online:     #34d399;

            /* App */
            --body-bg:       #eef3fc;
            --surface:       #ffffff;
            --border:        #dbe5f7;
            --text:          #0b1526;
            --muted:         #5a6f92;
            --grid-line:     rgba(37,99,235,.05);

            /* Footer */
            --footer-bg:     #020617;
            --footer-text:   #7488ad;

            --radius:        0.85rem;
            --radius-sm:     0.55rem;
            --ease:          cubic-bezier(.4,0,.2,1);
            --ease-out:      cubic-bezier(.16,1,.3,1);
            --t:             .2s;

            --font-display:  'Space Grotesk', 'Inter', sans-serif;
            --font-body:     'Inter', system-ui, sans-serif;
            --font-mono:     'JetBrains Mono', ui-monospace, monospace;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: var(--font-body);
            background: var(--body-bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        /* Faint engineering-grid backdrop across the whole app */
        body {
            background-image:
                linear-gradient(var(--grid-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
            background-size: 34px 34px;
        }

        a { text-decoration: none; color: inherit; }

        ::selection { background: rgba(56,189,248,.28); color: var(--text); }

        /* Global scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c3d3ee; border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: #a9c0e8; }

        /* ══════════════════════════════════════════════
           KEYFRAMES
        ══════════════════════════════════════════════ */
        @keyframes slideInLeft {
            from { opacity:0; transform:translateX(-22px); }
            to   { opacity:1; transform:translateX(0); }
        }
        @keyframes slideInDown {
            from { opacity:0; transform:translateY(-14px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes rocketFloat {
            0%,100% { transform: translateY(0) scale(1); }
            50%      { transform: translateY(-5px) scale(1.04); }
        }
        @keyframes glowPulse {
            0%,100% { box-shadow: 0 0 0 0   var(--sb-accent-glow); }
            50%      { box-shadow: 0 0 24px 7px var(--sb-accent-glow); }
        }
        @keyframes spinRing {
            to { transform:rotate(360deg); }
        }
        @keyframes spinRingRev {
            to { transform:rotate(-360deg); }
        }
        @keyframes shimmerSweep {
            0%   { background-position: -700px 0; }
            100% { background-position:  700px 0; }
        }
        @keyframes dotPop {
            0%,100% { transform:scale(1);   }
            50%      { transform:scale(1.45); }
        }
        @keyframes flashIn {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes navIn {
            from { opacity:0; transform:translateX(-14px); }
            to   { opacity:1; transform:translateX(0); }
        }
        @keyframes scanSweep {
            0%   { transform:translateX(-100%); }
            100% { transform:translateX(100%); }
        }
        @keyframes gridDrift {
            0%   { background-position: 0 0; }
            100% { background-position: 68px 68px; }
        }
        @keyframes statusPulse {
            0%,100% { box-shadow:0 0 0 0 rgba(52,211,153,.55); }
            50%      { box-shadow:0 0 0 5px rgba(52,211,153,0); }
        }
        @keyframes borderFlow {
            0%   { background-position: 0% 0; }
            100% { background-position: 200% 0; }
        }

        /* ══════════════════════════════════════════════
           HUD SCANLINE — top-of-viewport signature element
        ══════════════════════════════════════════════ */
        .hud-scan {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--scan-h);
            z-index: 100;
            background: linear-gradient(90deg, transparent, var(--sb-accent-s), var(--sb-accent-2), transparent);
            background-size: 60% 100%;
            opacity: .85;
            animation: borderFlow 5.5s linear infinite;
            pointer-events: none;
        }

        /* ══════════════════════════════════════════════
           SHELL
        ══════════════════════════════════════════════ */
        .app-shell { display:flex; min-height:100vh; }

        /* ══════════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════════ */
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sb-w);
            background: linear-gradient(168deg, var(--sb-bg-top) 0%, var(--sb-bg-mid) 55%, var(--sb-bg-bot) 100%);
            border-right: 1px solid var(--sb-border);
            display: flex;
            flex-direction: column;
            z-index: 50;
            overflow: hidden;
            transition: width var(--t) var(--ease), transform var(--t) var(--ease);
            animation: slideInLeft .5s var(--ease-out) both;
            box-shadow: 24px 0 60px rgba(2,6,23,.35);
        }

        /* Circuit dot-grid backdrop, slowly drifting */
        .sidebar::before {
            content:'';
            position:absolute; inset:-40px;
            background-image: radial-gradient(rgba(148,197,255,.16) 1px, transparent 1px);
            background-size: 22px 22px;
            animation: gridDrift 14s linear infinite;
            opacity:.5;
            pointer-events:none;
        }

        /* Bottom radial glow */
        .sidebar::after {
            content:'';
            position:absolute;
            bottom:-90px; left:50%;
            transform:translateX(-50%);
            width:240px; height:240px;
            border-radius:50%;
            background:radial-gradient(circle, rgba(56,189,248,.24) 0%, transparent 70%);
            pointer-events:none;
        }

        /* Vertical accent seam on the border */
        .sidebar { position:fixed; }
        .sidebar > * { position:relative; z-index:1; }

        /* Collapsed */
        .sidebar.is-collapsed { width: var(--sb-col); }

        .sidebar.is-collapsed .sb-label,
        .sidebar.is-collapsed .sb-brand-name,
        .sidebar.is-collapsed .sb-brand-sub,
        .sidebar.is-collapsed .sb-section-title,
        .sidebar.is-collapsed .sb-user-info,
        .sidebar.is-collapsed .sb-badge {
            opacity:0; pointer-events:none;
            width:0; overflow:hidden;
        }
        .sidebar.is-collapsed .sb-nav-item { justify-content:center; padding:10px 0; }
        .sidebar.is-collapsed .sb-icon { margin:0; }
        .sidebar.is-collapsed .sb-brand { justify-content:center; padding:18px 0 16px; }
        .sidebar.is-collapsed .sb-logo-wrap { margin:0; }
        .sidebar.is-collapsed .sb-user { justify-content:center; }

        /* ── BRAND ────────────────────────────────── */
        .sb-brand {
            display:flex;
            align-items:center;
            flex-direction:column;
            gap:.5rem;
            padding:1.4rem .9rem 1rem;
            border-bottom:1px solid var(--sb-border);
            text-decoration:none;
            flex-shrink:0;
            position:relative;
            z-index:1;
        }

        .sb-logo-wrap {
            position:relative;
            width:64px; height:64px;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0;
        }

        /* Spinning dashed ring */
        .sb-logo-wrap::before {
            content:'';
            position:absolute; inset:-8px;
            border-radius:50%;
            border:1.5px dashed rgba(125,211,252,.28);
            animation:spinRing 18s linear infinite;
        }
        /* Second, counter-rotating hairline ring — HUD radar feel */
        .sb-logo-wrap .sb-ring2 {
            position:absolute; inset:-14px;
            border-radius:50%;
            border:1px solid rgba(139,92,246,.20);
            border-top-color: rgba(139,92,246,.65);
            animation: spinRingRev 9s linear infinite;
            pointer-events:none;
        }
        /* Glow ring */
        .sb-logo-wrap::after {
            content:'';
            position:absolute; inset:-3px;
            border-radius:50%;
            background:radial-gradient(circle, rgba(56,189,248,.30) 0%, transparent 70%);
            animation:glowPulse 3.2s ease infinite;
        }

        .sb-logo {
            width:56px; height:56px;
            border-radius:16px;
            object-fit:contain;
            filter:drop-shadow(0 4px 18px rgba(56,189,248,.55));
            animation:rocketFloat 3.8s ease-in-out infinite;
            position:relative; z-index:1;
        }

        .sb-brand-name {
            font-family: var(--font-display);
            font-size:1.02rem;
            font-weight:700;
            color:var(--sb-text);
            letter-spacing:-.01em;
            white-space:nowrap;
            transition:opacity var(--t), width var(--t);
            text-align:center;
        }
        .sb-brand-sub {
            display:flex;
            align-items:center;
            gap:.35rem;
            font-family: var(--font-mono);
            font-size:.63rem;
            font-weight:600;
            letter-spacing:.14em;
            text-transform:uppercase;
            color:var(--sb-muted);
            white-space:nowrap;
            transition:opacity var(--t), width var(--t);
        }
        .sb-brand-sub .sb-dot {
            width:6px; height:6px;
            border-radius:50%;
            background:var(--sb-online);
            box-shadow:0 0 0 0 rgba(52,211,153,.55);
            animation: statusPulse 2.2s ease infinite;
            flex-shrink:0;
        }

        /* Collapse toggle */
        .sb-toggle {
            position:absolute;
            top:22px; right:-13px;
            width:26px; height:26px;
            background:var(--sb-bg-top);
            border:1px solid var(--sb-border);
            border-radius:50%;
            cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            color:var(--sb-muted);
            z-index:10;
            transition:color var(--t), background var(--t), transform var(--t), box-shadow var(--t);
        }
        .sb-toggle:hover { color:var(--sb-text); background:var(--sb-hover); box-shadow:0 0 0 3px var(--sb-accent-bg); }
        .sb-toggle svg { transition:transform var(--t) var(--ease); }
        .sidebar.is-collapsed .sb-toggle svg { transform:rotate(180deg); }

        /* ── NAV SCROLL ───────────────────────────── */
        .sb-nav-scroll {
            flex:1;
            overflow-y:auto; overflow-x:hidden;
            padding:.75rem .7rem;
            scrollbar-width:thin;
            scrollbar-color:var(--sb-border) transparent;
            position:relative; z-index:1;
        }
        .sb-nav-scroll::-webkit-scrollbar { width:4px; }
        .sb-nav-scroll::-webkit-scrollbar-thumb { background:var(--sb-border); border-radius:4px; }

        /* Section label */
        .sb-section-title {
            font-family: var(--font-mono);
            font-size:.62rem;
            font-weight:600;
            letter-spacing:.14em;
            text-transform:uppercase;
            color:var(--sb-muted);
            padding:.9rem .55rem .32rem;
            white-space:nowrap;
            transition:opacity var(--t);
        }
        .sb-section-title::before { content:'// '; color:rgba(125,211,252,.45); }

        /* Nav items — staggered entrance */
        .sb-nav-item {
            display:flex;
            align-items:center;
            gap:.7rem;
            padding:.68rem .8rem;
            border-radius:var(--radius-sm);
            color:rgba(226,235,255,.62);
            font-size:.84rem;
            font-weight:600;
            white-space:nowrap;
            cursor:pointer;
            border:none;
            background:none;
            font-family: var(--font-body);
            width:100%;
            text-align:left;
            position:relative;
            overflow:hidden;
            transition:color var(--t) var(--ease), background var(--t) var(--ease), transform var(--t) var(--ease);

            opacity:0;
            animation:navIn .38s var(--ease-out) both;
        }

        /* Stagger delays */
        .sb-nav-item:nth-of-type(1)  { animation-delay:.06s; }
        .sb-nav-item:nth-of-type(2)  { animation-delay:.09s; }
        .sb-nav-item:nth-of-type(3)  { animation-delay:.12s; }
        .sb-nav-item:nth-of-type(4)  { animation-delay:.15s; }
        .sb-nav-item:nth-of-type(5)  { animation-delay:.18s; }
        .sb-nav-item:nth-of-type(6)  { animation-delay:.21s; }
        .sb-nav-item:nth-of-type(7)  { animation-delay:.24s; }
        .sb-nav-item:nth-of-type(8)  { animation-delay:.27s; }
        .sb-nav-item:nth-of-type(9)  { animation-delay:.30s; }
        .sb-nav-item:nth-of-type(10) { animation-delay:.33s; }

        .sb-nav-item::before {
            content:'';
            position:absolute; inset:0;
            border-radius:inherit;
            background:transparent;
            transition:background var(--t);
        }

        .sb-nav-item:hover::before  { background:var(--sb-hover); }
        .sb-nav-item.is-active::before {
            background:var(--sb-accent-bg);
            box-shadow: inset 0 0 0 1px rgba(125,211,252,.22);
        }

        .sb-nav-item:hover,
        .sb-nav-item:focus-visible {
            color:var(--sb-text);
            transform:translateX(4px);
            outline:none;
        }
        .sb-nav-item.is-active {
            color:var(--sb-active-txt);
            transform:translateX(4px);
        }

        /* Active left bar — neon glow */
        .sb-nav-item.is-active::after {
            content:'';
            position:absolute;
            left:0; top:20%; height:60%;
            width:3px;
            border-radius:0 3px 3px 0;
            background:var(--sb-accent-s);
            box-shadow: 0 0 10px 1px var(--sb-accent-glow);
        }

        /* Icon chip */
        .sb-icon-wrap {
            width:30px; height:30px;
            border-radius:8px;
            background:rgba(148,197,255,.08);
            display:grid; place-items:center;
            flex-shrink:0;
            transition:background var(--t), transform var(--t), box-shadow var(--t);
        }
        .sb-nav-item:hover .sb-icon-wrap {
            background:rgba(56,189,248,.22);
            transform:scale(1.08) rotate(-3deg);
        }
        .sb-nav-item.is-active .sb-icon-wrap {
            background:rgba(56,189,248,.30);
            transform:scale(1.08) rotate(-3deg);
            box-shadow: 0 0 12px rgba(56,189,248,.35);
        }
        .sb-icon {
            width:16px; height:16px;
            flex-shrink:0;
            transition:color var(--t);
        }
        .sb-nav-item.is-active .sb-icon { color:var(--sb-accent-s); }

        /* Label */
        .sb-label { flex:1; transition:opacity var(--t), width var(--t); }

        /* Badge */
        .sb-badge {
            font-family: var(--font-mono);
            font-size:.65rem; font-weight:700;
            padding:2px 7px;
            border-radius:99px;
            background:var(--sb-accent);
            color:#fff;
            transition:opacity var(--t);
        }

        /* Danger */
        .sb-nav-item.is-danger { color:var(--sb-danger); }
        .sb-nav-item.is-danger:hover::before { background:var(--sb-danger-bg); }
        .sb-nav-item.is-danger:hover { color:var(--sb-danger); transform:translateX(3px); }
        .sb-nav-item.is-danger:hover .sb-icon-wrap { background:var(--sb-danger-bg); box-shadow:0 0 12px rgba(251,113,133,.30); }

        /* Divider */
        .sb-divider { height:1px; background:linear-gradient(90deg, transparent, var(--sb-border), transparent); margin:.7rem .3rem; }

        /* ── USER CARD ────────────────────────────── */
        .sb-user {
            padding:.95rem 1rem;
            border-top:1px solid var(--sb-border);
            display:flex; align-items:center; gap:.65rem;
            flex-shrink:0;
            position:relative; z-index:1;
        }
        .sb-avatar {
            width:36px; height:36px;
            border-radius:50%;
            background:linear-gradient(135deg, var(--sb-accent-s), var(--sb-accent-2));
            color:#fff;
            font-family: var(--font-display);
            font-size:.82rem; font-weight:700;
            display:grid; place-items:center;
            flex-shrink:0;
            position:relative;
            box-shadow: 0 0 0 3px rgba(56,189,248,.14);
        }
        /* Online dot */
        .sb-avatar::after {
            content:'';
            position:absolute; bottom:0; right:0;
            width:9px; height:9px;
            border-radius:50%;
            background:var(--sb-online);
            border:2px solid var(--sb-bg-bot);
            animation:dotPop 2.5s ease infinite;
        }
        .sb-user-info { overflow:hidden; transition:opacity var(--t), width var(--t); }
        .sb-user-name { font-family: var(--font-display); font-size:.82rem; font-weight:700; color:var(--sb-text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .sb-user-role { font-family: var(--font-mono); font-size:.66rem; letter-spacing:.06em; color:var(--sb-muted); text-transform:uppercase; }

        /* ══════════════════════════════════════════════
           MAIN
        ══════════════════════════════════════════════ */
        .app-main {
            margin-left:var(--sb-w);
            display:flex; flex-direction:column;
            min-height:100vh; flex:1;
            transition:margin-left var(--t) var(--ease);
        }
        .app-main.sidebar-collapsed { margin-left:var(--sb-col); }

        /* ── TOPBAR ───────────────────────────────── */
        .topbar {
            position:sticky; top:0; z-index:40;
            height:var(--topbar-h);
            background:rgba(255,255,255,.82);
            backdrop-filter:blur(16px) saturate(140%);
            -webkit-backdrop-filter:blur(16px) saturate(140%);
            border-bottom:1px solid var(--border);
            box-shadow:0 4px 26px rgba(10,30,70,.07);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 1.6rem;
            flex-shrink:0;
            animation:slideInDown .45s var(--ease-out) both;
            position:relative;
        }
        /* animated hairline under topbar */
        .topbar::after {
            content:'';
            position:absolute; left:0; right:0; bottom:-1px; height:1px;
            background: linear-gradient(90deg, transparent, rgba(37,99,235,.45), rgba(139,92,246,.35), transparent);
            background-size: 50% 100%;
            animation: borderFlow 6s linear infinite;
        }

        .topbar__left { display:flex; align-items:center; gap:.9rem; }

        .topbar__mobile-toggle {
            display:none;
            background:none; border:1px solid var(--border);
            border-radius:var(--radius-sm);
            width:38px; height:38px;
            cursor:pointer; color:var(--muted);
            align-items:center; justify-content:center;
            transition:background var(--t), border-color var(--t);
        }
        .topbar__mobile-toggle:hover { background:#e8f0fe; border-color:#93b4ef; }

        /* Topbar logo */
        .topbar-brand { display:flex; align-items:center; gap:.75rem; }
        .topbar-logo {
            width:32px; height:32px;
            object-fit:contain;
            animation:rocketFloat 3.8s ease-in-out infinite;
            filter:drop-shadow(0 2px 6px rgba(37,99,235,.32));
        }
        .topbar-divider { width:1px; height:26px; background:var(--border); }

        .topbar__breadcrumb { display:flex; align-items:center; gap:.5rem; font-size:.88rem; color:var(--muted); }
        .topbar__breadcrumb strong { color:var(--text); font-weight:700; font-family: var(--font-display); letter-spacing:-.01em; }

        .topbar__right { display:flex; align-items:center; gap:.7rem; }

        /* Live status pill */
        .topbar__status {
            display:flex; align-items:center; gap:.4rem;
            font-family: var(--font-mono);
            font-size:.68rem; font-weight:600;
            letter-spacing:.06em;
            color:#0e7a4f;
            background:#e9fbf2;
            border:1px solid #bdf0d6;
            padding:.32rem .65rem .32rem .55rem;
            border-radius:99px;
        }
        .topbar__status .sb-dot {
            width:6px; height:6px; border-radius:50%;
            background:var(--sb-online);
            animation: statusPulse 2.2s ease infinite;
        }

        .topbar__time {
            font-family: var(--font-mono);
            font-size:.75rem; font-weight:600;
            color:var(--muted);
            background:#f0f5ff;
            border:1px solid var(--border);
            padding:.34rem .75rem;
            border-radius:99px;
            letter-spacing:.03em;
        }

        .topbar__notify {
            position:relative;
            background:none; border:1px solid var(--border);
            border-radius:var(--radius-sm);
            width:38px; height:38px;
            cursor:pointer; color:var(--muted);
            display:flex; align-items:center; justify-content:center;
            transition:background var(--t), border-color var(--t), color var(--t), box-shadow var(--t);
        }
        .topbar__notify:hover { background:#e8f0fe; border-color:#93b4ef; color:#2563eb; box-shadow:0 0 0 4px rgba(37,99,235,.10); }

        .topbar__notify-dot {
            position:absolute; top:7px; right:7px;
            width:7px; height:7px;
            background:var(--sb-accent-s); border-radius:50%;
            border:2px solid #fff;
            animation:dotPop 2.2s ease infinite;
        }

        /* User chip in topbar */
        .topbar__user {
            display:inline-flex; align-items:center; gap:.6rem;
            padding:.35rem .85rem .35rem .4rem;
            border-radius:99px;
            background:#f0f5ff; border:1px solid var(--border);
            color:#1a3a82; font-weight:600; font-size:.82rem;
            transition:background var(--t), border-color var(--t), box-shadow var(--t);
        }
        .topbar__user:hover { background:#ddeaff; border-color:#93b4ef; box-shadow:0 0 0 4px rgba(56,189,248,.10); }
        .topbar__avatar {
            width:30px; height:30px; border-radius:50%;
            background:linear-gradient(135deg, var(--sb-accent-s), var(--sb-accent-2));
            color:#fff; font-family: var(--font-display); font-size:.78rem; font-weight:700;
            display:grid; place-items:center;
        }

        /* ── PAGE CONTENT ─────────────────────────── */
        .app-content {
            flex:1;
            padding:1.7rem 1.85rem 0;
            animation:fadeUp .5s .12s var(--ease-out) both;
            position:relative;
        }

        /* ── FLASH MESSAGES ───────────────────────── */
        .flash {
            display:flex; align-items:center; gap:.7rem;
            padding:.85rem 1.05rem;
            border-radius:var(--radius);
            font-size:.875rem; font-weight:600;
            margin-bottom:1rem;
            animation:flashIn .35s var(--ease-out) both;
            cursor:pointer;
            backdrop-filter: blur(6px);
        }
        .flash-icon {
            width:22px; height:22px; border-radius:50%;
            display:grid; place-items:center;
            font-size:.72rem; font-weight:800;
            flex-shrink:0;
        }
        .flash-success { background:#eff8ef; border:1px solid #bbf7d0; color:#166534; }
        .flash-success .flash-icon { background:#22c55e; color:#fff; }
        .flash-error   { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
        .flash-error .flash-icon   { background:#ef4444; color:#fff; }
        .flash-warning { background:#fffbeb; border:1px solid #fde68a; color:#92400e; }
        .flash-warning .flash-icon { background:#f59e0b; color:#fff; }

        /* ── ERROR LIST ───────────────────────────── */
        .error-list {
            background:#fffbeb; border:1px solid #fde68a;
            border-radius:var(--radius);
            padding:.9rem 1.05rem;
            font-size:.875rem; color:#92400e;
            margin-bottom:1rem;
            animation:flashIn .35s var(--ease-out) both;
        }
        .error-list strong { font-weight:700; font-family: var(--font-display); }
        .error-list ul { margin:.5rem 0 0 1.1rem; }
        .error-list li { margin-top:.25rem; }

        /* ── FOOTER ───────────────────────────────── */
        .app-footer {
            background:var(--footer-bg);
            border-top:1px solid rgba(148,197,255,.08);
            margin-top:2.6rem;
            padding:1.3rem 1.85rem;
            display:flex; align-items:center;
            justify-content:space-between;
            flex-wrap:wrap; gap:.75rem;
            position:relative;
            overflow:hidden;
        }
        .app-footer::before {
            content:'';
            position:absolute; inset:0;
            background-image: radial-gradient(rgba(148,197,255,.08) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity:.5;
            pointer-events:none;
        }

        .footer__brand { display:flex; align-items:center; gap:.65rem; position:relative; z-index:1; }

        .footer__logo-img {
            width:26px; height:26px;
            object-fit:contain;
            filter:brightness(0) invert(1) opacity(.6);
            transition: filter var(--t);
        }
        .footer__brand:hover .footer__logo-img { filter:brightness(0) invert(1) opacity(.9); }

        .footer__copy { font-size:.76rem; color:var(--footer-text); }

        .footer__links { display:flex; gap:1.2rem; list-style:none; position:relative; z-index:1; }
        .footer__links a {
            font-size:.76rem; color:var(--footer-text);
            transition:color var(--t);
        }
        .footer__links a:hover { color:#e8eef8; }

        .footer__meta { font-family: var(--font-mono); font-size:.7rem; color:#4c628c; position:relative; z-index:1; }
        .footer__meta strong { color:var(--footer-text); }

        /* ── OVERLAY ──────────────────────────────── */
        .sb-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(2,6,23,.6);
            z-index:40;
            backdrop-filter:blur(2px);
            opacity:0; transition:opacity var(--t);
        }
        .sb-overlay.is-visible { display:block; opacity:1; }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width:960px) {
            .sidebar {
                transform:translateX(-100%);
                width:var(--sb-w) !important;
                animation:none;
            }
            .sidebar.mobile-open { transform:translateX(0); }
            .app-main { margin-left:0 !important; }
            .topbar__mobile-toggle { display:inline-flex; }
            .sb-toggle { display:none; }
            .app-footer { flex-direction:column; align-items:flex-start; gap:1rem; }
            .topbar__status { display:none; }
        }

        @media (max-width:480px) {
            .app-content { padding:1rem 1rem 0; }
            .topbar { padding:0 1rem; }
            .topbar__time { display:none; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration:.01ms !important;
                transition-duration:.01ms !important;
            }
        }
    </style>
</head>

<body>

{{-- HUD boot scanline — the page's signature ambient element --}}
<div class="hud-scan" aria-hidden="true"></div>

<div class="app-shell" x-data="staffLayout()">

    {{-- Mobile overlay --}}
    <div class="sb-overlay"
         :class="{ 'is-visible': mobileOpen }"
         @click="mobileOpen = false"></div>

    {{-- ══════════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════════ --}}
    <aside class="sidebar"
           :class="{ 'is-collapsed': collapsed, 'mobile-open': mobileOpen }"
           aria-label="Staff navigation">

        {{-- Collapse toggle (desktop) --}}
        <button class="sb-toggle"
                @click="collapsed = !collapsed"
                :aria-label="collapsed ? 'Expand sidebar' : 'Collapse sidebar'">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                <path d="M7 2L3 6l4 4" stroke="currentColor" stroke-width="1.8"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        {{-- Brand --}}
        <div class="sb-brand">
            <div class="sb-logo-wrap">
                <span class="sb-ring2" aria-hidden="true"></span>
                <img src="{{ asset('image/logo oif skillup(1).png') }}"
                     alt="SkillUp Logo"
                     class="sb-logo" />
            </div>
            <span class="sb-brand-name">SkillUp</span>
            <span class="sb-brand-sub"><span class="sb-dot" aria-hidden="true"></span>Staff Portal</span>
        </div>

        {{-- Nav --}}
        <nav class="sb-nav-scroll" aria-label="Sidebar menu">

            <div class="sb-section-title">Main</div>

            <a href="{{ route('staff.dashboard') }}"
               class="sb-nav-item {{ request()->routeIs('staff.dashboard') ? 'is-active' : '' }}"
               title="Dashboard">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="1" width="7" height="7" rx="1.5"/>
                        <rect x="10" y="1" width="7" height="7" rx="1.5"/>
                        <rect x="1" y="10" width="7" height="7" rx="1.5"/>
                        <rect x="10" y="10" width="7" height="7" rx="1.5"/>
                    </svg>
                </span>
                <span class="sb-label">Dashboard</span>
            </a>

            <div class="sb-section-title">Management</div>

            <a href="{{ route('staff.users.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.users.*') ? 'is-active' : '' }}"
               title="User Management">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="6" r="3"/>
                        <path d="M2 16c0-3.314 3.134-6 7-6s7 2.686 7 6"/>
                    </svg>
                </span>
                <span class="sb-label">User Management</span>
            </a>

            <a href="{{ route('staff.enrollments.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.enrollments.*') ? 'is-active' : '' }}"
               title="Enrollment Management">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 4h12M3 8h8M3 12h5"/>
                        <circle cx="14" cy="13" r="3"/>
                        <path d="M13 13l.8.8 1.7-1.6" stroke-width="1.3"/>
                    </svg>
                </span>
                <span class="sb-label">Enrollment</span>
            </a>

            <a href="{{ route('staff.courses.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.courses.*') ? 'is-active' : '' }}"
               title="Course Records">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h5.5v12H2zM10.5 3H16v12h-5.5z"/>
                        <path d="M7.5 6.5H10.5M7.5 9.5H10.5"/>
                    </svg>
                </span>
                <span class="sb-label">Course Records</span>
            </a>

            <a href="{{ route('staff.modules.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.modules.*') ? 'is-active' : '' }}"
               title="Module Management">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="12" height="4" rx="1.2"/>
                        <rect x="3" y="10" width="12" height="4" rx="1.2"/>
                    </svg>
                </span>
                <span class="sb-label">Modules</span>
            </a>

            <a href="{{ route('staff.lessons.list') }}"
               class="sb-nav-item {{ request()->routeIs('staff.lessons.list') ? 'is-active' : '' }}"
               title="Lessons">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h10v10H4z"/>
                        <path d="M7 7h4M7 10h4"/>
                    </svg>
                </span>
                <span class="sb-label">Lessons</span>
            </a>

            <a href="{{ route('staff.quizzes.list') }}"
               class="sb-nav-item {{ request()->routeIs('staff.quizzes.list') ? 'is-active' : '' }}"
               title="Quizzes">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 3h10v12H4z"/>
                        <path d="M6 7h6M6 10h3"/>
                        <path d="M7 14l2-2 2 2"/>
                    </svg>
                </span>
                <span class="sb-label">Quizzes</span>
            </a>

            <div class="sb-section-title">Resources</div>

            <a href="{{ route('staff.videos.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.videos.*') ? 'is-active' : '' }}"
               title="Video Resources">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="14" height="10" rx="2"/>
                        <path d="M7 7l4 2-4 2z"/>
                    </svg>
                </span>
                <span class="sb-label">Videos</span>
            </a>

            <a href="{{ route('staff.images.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.images.*') ? 'is-active' : '' }}"
               title="Image Resources">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="14" height="12" rx="2"/>
                        <path d="M4 13l3-3 2 2 3-4 2 3"/>
                    </svg>
                </span>
                <span class="sb-label">Images</span>
            </a>

            <a href="{{ route('staff.powerpoints.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.powerpoints.*') ? 'is-active' : '' }}"
               title="PowerPoint Resources">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 2h6l4 4v10H4z"/>
                        <path d="M10 2v4h4"/>
                        <path d="M6 10h4"/>
                        <path d="M6 13h3"/>
                    </svg>
                </span>
                <span class="sb-label">PowerPoint</span>
            </a>

            <div class="sb-section-title">Reports</div>

            <a href="{{ route('staff.reports.daily') }}"
               class="sb-nav-item {{ request()->routeIs('staff.reports.daily*') ? 'is-active' : '' }}"
               title="Daily Reports">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="14" height="13" rx="1.5"/>
                        <path d="M5 2v2M13 2v2M2 8h14"/>
                        <path d="M5.5 12l2 2 5-4" stroke-width="1.3"/>
                    </svg>
                </span>
                <span class="sb-label">Daily Reports</span>
            </a>

            <a href="{{ route('staff.reports.staff') }}"
               class="sb-nav-item {{ request()->routeIs('staff.reports.staff*') ? 'is-active' : '' }}"
               title="Staff Reports">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 14l3-5 3 3 3-6 3 4 2-3"/>
                        <path d="M2 2v12h14" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="sb-label">Staff Reports</span>
            </a>

            <div class="sb-section-title">System</div>

            <a href="{{ route('staff.settings.index') }}"
               class="sb-nav-item {{ request()->routeIs('staff.settings.*') ? 'is-active' : '' }}"
               title="System Settings">
                <span class="sb-icon-wrap">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="9" r="2.5"/>
                        <path d="M9 2v1.5M9 14.5V16M2 9h1.5M14.5 9H16
                                 M3.93 3.93l1.06 1.06M13.01 13.01l1.06 1.06
                                 M3.93 14.07l1.06-1.06M13.01 4.99l1.06-1.06"/>
                    </svg>
                </span>
                <span class="sb-label">Settings</span>
            </a>

            <div class="sb-divider"></div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-nav-item is-danger" title="Sign Out">
                    <span class="sb-icon-wrap" style="background:rgba(251,113,133,.14);">
                        <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                             stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 3H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h4"/>
                            <path d="M12 13l4-4-4-4M16 9H7"/>
                        </svg>
                    </span>
                    <span class="sb-label">Sign Out</span>
                </button>
            </form>

        </nav>

        {{-- User card --}}
        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="sb-user-info">
                <div class="sb-user-name">{{ Auth::user()->name }}</div>
                <div class="sb-user-role">Staff Member</div>
            </div>
        </div>

    </aside>

    {{-- ══════════════════════════════════════════
         MAIN
    ══════════════════════════════════════════ --}}
    <div class="app-main" :class="{ 'sidebar-collapsed': collapsed }">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar__left">
                <button class="topbar__mobile-toggle"
                        @click="mobileOpen = !mobileOpen"
                        aria-label="Open navigation">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M2 4.5h14M2 9h14M2 13.5h14"
                              stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="topbar-brand">
                    <img src="{{ asset('image/logo oif skillup(1).png') }}"
                         alt="SkillUp" class="topbar-logo" />
                    <div class="topbar-divider"></div>
                    <div class="topbar__breadcrumb">
                        @hasSection('breadcrumb')
                            @yield('breadcrumb')
                        @else
                            <strong>@yield('title', 'Dashboard')</strong>
                        @endif
                    </div>
                </div>
            </div>

            <div class="topbar__right">
                <span class="topbar__status"><span class="sb-dot" aria-hidden="true"></span>Online</span>
                <span class="topbar__time" id="js-clock"></span>

                <button class="topbar__notify" aria-label="Notifications">
                    <svg width="16" height="16" viewBox="0 0 18 18" fill="none"
                         stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                        <path d="M9 2a5.5 5.5 0 0 1 5.5 5.5c0 3 1 4 1.5 4.5H2c.5-.5 1.5-1.5 1.5-4.5A5.5 5.5 0 0 1 9 2z"/>
                        <path d="M7.5 15a1.5 1.5 0 0 0 3 0"/>
                    </svg>
                    <span class="topbar__notify-dot"></span>
                </button>

                <div class="topbar__user">
                    <div class="topbar__avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="app-content" id="main-content">

            @if(session('success'))
                <div class="flash flash-success js-flash" role="status">
                    <div class="flash-icon">✓</div>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flash flash-error js-flash" role="alert">
                    <div class="flash-icon">✕</div>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="error-list">
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="app-footer" role="contentinfo">
            <div class="footer__brand">
                <img src="{{ asset('image/logo oif skillup(1).png') }}"
                     alt="SkillUp" class="footer__logo-img" />
                <span class="footer__copy">&copy; {{ date('Y') }} SkillUp. All rights reserved.</span>
            </div>

            <ul class="footer__links">
                <li><a href="{{ route('help.index') }}">Help Center</a></li>
                <li><a href="{{ route('privacy') }}">Privacy</a></li>
                <li><a href="{{ route('terms') }}">Terms</a></li>
            </ul>

            <span class="footer__meta">
                Logged in as <strong>{{ Auth::user()->name }}</strong>
                &nbsp;·&nbsp;
                <span id="js-date"></span>
            </span>
        </footer>

    </div>{{-- /.app-main --}}

</div>{{-- /.app-shell --}}

<script>
    /* ── Alpine component ── */
    document.addEventListener('alpine:init', () => {
        Alpine.data('staffLayout', () => ({
            collapsed: localStorage.getItem('sb_collapsed') === 'true',
            mobileOpen: false,
            init() {
                this.$watch('collapsed', v => localStorage.setItem('sb_collapsed', v));
                /* Close mobile sidebar on Escape */
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') this.mobileOpen = false;
                });
            }
        }));
    });

    /* ── Live clock ── */
    (function clock() {
        const elTime = document.getElementById('js-clock');
        const elDate = document.getElementById('js-date');
        function tick() {
            const now = new Date();
            if (elTime) elTime.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            if (elDate) elDate.textContent = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
        }
        tick();
        setInterval(tick, 1000);
    })();

    /* ── Flash auto-dismiss ── */
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.js-flash').forEach(f => {
            const dismiss = () => {
                f.style.transition = 'opacity .22s ease, transform .22s ease';
                f.style.opacity = '0';
                f.style.transform = 'translateY(-6px)';
                setTimeout(() => f.remove(), 240);
            };
            setTimeout(dismiss, 5000);
            f.addEventListener('click', dismiss);
        });
    });
</script>

@stack('scripts')
</body>
</html>