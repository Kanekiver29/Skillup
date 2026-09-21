<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo $__env->yieldContent('title', 'Staff Portal'); ?> — SkillUp</title>

    <link rel="icon" href="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script>
        (() => {
            const STORAGE_KEY = 'skillup-staff-theme';
            const root = document.documentElement;
            const mediaQuery = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

            function getStoredTheme() {
                try {
                    return localStorage.getItem(STORAGE_KEY) || 'system';
                } catch (error) {
                    return 'system';
                }
            }

            function setTheme(choice) {
                const resolvedTheme = choice === 'system'
                    ? (mediaQuery && mediaQuery.matches ? 'dark' : 'light')
                    : choice;

                root.dataset.staffTheme = resolvedTheme;
                root.dataset.staffThemeChoice = choice;
                root.style.colorScheme = resolvedTheme;

                document.querySelectorAll('[data-theme-option]').forEach((button) => {
                    const isSelected = button.dataset.themeOption === choice;
                    button.classList.toggle('is-selected', isSelected);
                    button.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
                });

                try {
                    localStorage.setItem(STORAGE_KEY, choice);
                } catch (error) {
                    // Ignore storage errors to avoid blocking the page.
                }
            }

            const applyTheme = () => setTheme(getStoredTheme());
            applyTheme();

            if (mediaQuery && mediaQuery.addEventListener) {
                mediaQuery.addEventListener('change', applyTheme);
            } else if (mediaQuery && mediaQuery.addListener) {
                mediaQuery.addListener(applyTheme);
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-theme-option]').forEach((button) => {
                    button.addEventListener('click', () => setTheme(button.dataset.themeOption));
                });
                setTheme(getStoredTheme());
            });
        })();
    </script>
    <!-- Alpine.js (UI reactivity) + Font Awesome (icon fallback for other pages) -->
    <script src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        /* ══════════════════════════════════════════════
           TOKENS — "Ledger" premium editorial system
           display: Fraunces / body: Inter / data: JetBrains Mono
        ══════════════════════════════════════════════ */
        :root {
            --sb-w:          272px;
            --sb-col:         76px;
            --topbar-h:       68px;

            /* Sidebar — ink, always dark, regardless of site theme */
            --sb-bg-top:     #15171d;
            --sb-bg-bot:     #0b0c10;
            --sb-border:     rgba(237,231,218,.08);
            --sb-text:       #ede7da;
            --sb-muted:      rgba(237,231,218,.52);
            --sb-hover:      rgba(237,231,218,.05);
            --sb-active-bg:  rgba(201,162,39,.11);
            --sb-accent:     #c9a227;
            --sb-danger:     #c98a7a;
            --sb-danger-bg:  rgba(201,138,122,.12);
            --sb-online:     #7fae8e;

            /* App surface */
            --bg:            #f6f3ec;
            --surface:       #ffffff;
            --surface-raised:#fbf9f4;
            --border:        #e6dfd0;
            --text:          #221e18;
            --muted:         #7c7566;
            --accent:        #a9782e;
            --accent-soft:   rgba(169,120,46,.12);

            --topbar-bg:      rgba(246,243,236,.86);
            --topbar-border:  var(--border);
            --topbar-control: #ffffff;
            --topbar-control-hover: #f1ece0;

            --flash-success-bg: #f0f4ee; --flash-success-border: #cfdec8; --flash-success-text: #3f6b4e;
            --flash-error-bg:   #f7eeec; --flash-error-border: #e3c8c1; --flash-error-text: #8b3a3a;
            --flash-warning-bg: #faf3e3; --flash-warning-border: #e9d6a8; --flash-warning-text: #8a6414;

            --footer-bg:     #0b0c10;
            --footer-text:   #8a8677;

            --radius:        10px;
            --radius-sm:     7px;
            --ease:          cubic-bezier(.4,0,.2,1);
            --ease-out:      cubic-bezier(.16,1,.3,1);
            --t:             .18s;

            --font-display:  'Fraunces', Georgia, serif;
            --font-body:     'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --font-mono:     'JetBrains Mono', ui-monospace, monospace;
        }

        html[data-staff-theme="dark"] {
            --bg:            #15171d;
            --surface:       #1b1e25;
            --surface-raised:#21242c;
            --border:        #2b2e37;
            --text:          #ede7da;
            --muted:         #a39b8b;
            --accent:        #d3af3f;
            --accent-soft:   rgba(211,175,63,.14);

            --topbar-bg:      rgba(21,23,29,.88);
            --topbar-control: #21242c;
            --topbar-control-hover: #282c35;

            --flash-success-bg: rgba(63,107,78,.16);  --flash-success-border: rgba(127,174,142,.32); --flash-success-text: #cfe3d5;
            --flash-error-bg:   rgba(139,58,58,.18);  --flash-error-border: rgba(201,138,122,.34);  --flash-error-text: #edcfc9;
            --flash-warning-bg: rgba(138,100,20,.20); --flash-warning-border: rgba(211,175,63,.32); --flash-warning-text: #f0dfae;

            --footer-text:   #857f70;
            color-scheme: dark;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }

        h1, h2, h3, h4, h5, h6,
        .sb-brand-name,
        .topbar__breadcrumb strong,
        .footer__copy strong {
            font-family: var(--font-display);
        }

        button, input, select, textarea { font: inherit; }

        button, [type="button"], [type="submit"], [type="reset"] {
            transition: background var(--t) var(--ease), border-color var(--t) var(--ease), color var(--t) var(--ease), box-shadow var(--t) var(--ease);
        }

        input, select, textarea {
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
        }
        input::placeholder, textarea::placeholder { color: var(--muted); opacity: 1; }

        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }
        ::selection { background: var(--accent-soft); color: var(--text); }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--muted); }

        /* ══════════════════════════════════════════════
           KEYFRAMES — used sparingly, one job each
        ══════════════════════════════════════════════ */
        @keyframes fadeUp { from { opacity:0; transform:translateY(10px);} to { opacity:1; transform:translateY(0);} }
        @keyframes flashIn { from { opacity:0; transform:translateY(-6px);} to { opacity:1; transform:translateY(0);} }
        @keyframes softPulse { 0%,100% { opacity:.55; } 50% { opacity:1; } }

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
            height: 100dvh;
            background: linear-gradient(185deg, var(--sb-bg-top) 0%, var(--sb-bg-bot) 100%);
            border-right: 1px solid var(--sb-border);
            display: flex;
            flex-direction: column;
            z-index: 50;
            overflow: hidden;
            transition: width var(--t) var(--ease), transform var(--t) var(--ease);
            will-change: width, transform;
        }

        .sidebar.is-collapsed { width: var(--sb-col); }

        .sidebar.is-collapsed .sb-label,
        .sidebar.is-collapsed .sb-brand-name,
        .sidebar.is-collapsed .sb-brand-sub,
        .sidebar.is-collapsed .sb-section-title,
        .sidebar.is-collapsed .sb-user-info {
            opacity:0; pointer-events:none;
            width:0; overflow:hidden;
        }
        .sidebar.is-collapsed .sb-nav-item { justify-content:center; padding:.62rem 0; }
        .sidebar.is-collapsed .sb-brand { justify-content:center; padding:1.5rem 0 1.1rem; }
        .sidebar.is-collapsed .sb-user { justify-content:center; }

        /* ── BRAND ────────────────────────────────── */
        .sb-brand {
            display:flex;
            align-items:center;
            flex-direction:column;
            gap:.6rem;
            padding:1.6rem 1rem 1.2rem;
            border-bottom:1px solid var(--sb-border);
            flex-shrink:0;
        }

        .sb-logo-wrap {
            width:52px; height:52px;
            display:flex; align-items:center; justify-content:center;
            border:1px solid rgba(237,231,218,.14);
            border-radius:12px;
            background: rgba(237,231,218,.03);
            flex-shrink:0;
        }
        .sb-logo { width:32px; height:32px; object-fit:contain; }

        .sb-brand-name {
            font-size:1.18rem;
            font-weight:600;
            color:var(--sb-text);
            letter-spacing:-.01em;
            white-space:nowrap;
            transition:opacity var(--t), width var(--t);
        }
        .sb-brand-sub {
            display:flex;
            align-items:center;
            gap:.4rem;
            font-size:.72rem;
            font-weight:500;
            letter-spacing:.03em;
            color:var(--sb-muted);
            white-space:nowrap;
            transition:opacity var(--t), width var(--t);
        }
        .sb-brand-sub .sb-dot {
            width:5px; height:5px;
            border-radius:50%;
            background:var(--sb-online);
            animation: softPulse 2.4s ease infinite;
            flex-shrink:0;
        }

        /* Collapse toggle */
        .sb-toggle {
            position:absolute;
            top:26px; right:-12px;
            width:24px; height:24px;
            background:var(--sb-bg-top);
            border:1px solid var(--sb-border);
            border-radius:50%;
            cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            color:var(--sb-muted);
            z-index:10;
            transition:color var(--t), border-color var(--t);
        }
        .sb-toggle:hover { color:var(--sb-text); border-color:rgba(237,231,218,.24); }
        .sb-toggle svg { transition:transform var(--t) var(--ease); }
        .sidebar.is-collapsed .sb-toggle svg { transform:rotate(180deg); }

        /* ── NAV SCROLL ───────────────────────────── */
        .sb-nav-scroll {
            flex:1;
            min-height:0;
            overflow-y:auto; overflow-x:hidden;
            padding:.6rem .75rem 1.25rem;
            scrollbar-width:thin;
            scrollbar-color:rgba(237,231,218,.18) transparent;
            scrollbar-gutter:stable;
            overscroll-behavior:contain;
            -webkit-overflow-scrolling:touch;
        }
        .sb-nav-scroll::-webkit-scrollbar { width:4px; }
        .sb-nav-scroll::-webkit-scrollbar-track { background:transparent; }
        .sb-nav-scroll::-webkit-scrollbar-thumb { background:rgba(237,231,218,.16); border-radius:999px; }

        .sb-section-title {
            font-size:.7rem;
            font-weight:600;
            color:var(--sb-muted);
            padding:1rem .55rem .35rem;
            white-space:nowrap;
            transition:opacity var(--t);
        }

        .sb-nav-item {
            display:flex;
            align-items:center;
            gap:.75rem;
            padding:.6rem .75rem;
            border-radius:var(--radius-sm);
            color:rgba(237,231,218,.75);
            font-size:.86rem;
            font-weight:500;
            white-space:nowrap;
            cursor:pointer;
            border:1px solid transparent;
            border-left:2px solid transparent;
            background:transparent;
            font-family: var(--font-body);
            width:100%;
            text-align:left;
            position:relative;
            transition:color var(--t) var(--ease), background var(--t) var(--ease), border-color var(--t) var(--ease);
        }

        .sb-nav-item:hover,
        .sb-nav-item:focus-visible {
            color:var(--sb-text);
            background:var(--sb-hover);
            outline:none;
        }
        .sb-nav-item.is-active {
            color:var(--sb-text);
            background:var(--sb-active-bg);
            border-left-color:var(--sb-accent);
        }

        .sb-icon { width:17px; height:17px; flex-shrink:0; opacity:.9; }
        .sb-nav-item.is-active .sb-icon { color:var(--sb-accent); opacity:1; }

        .sb-label { flex:1; transition:opacity var(--t), width var(--t); }

        .sb-nav-item.is-danger { color:var(--sb-danger); }
        .sb-nav-item.is-danger:hover { background:var(--sb-danger-bg); color:var(--sb-danger); }

        .sb-divider { height:1px; background:var(--sb-border); margin:.75rem .3rem; }

        /* ── USER CARD ────────────────────────────── */
        .sb-user {
            padding:1rem 1.1rem;
            border-top:1px solid var(--sb-border);
            display:flex; align-items:center; gap:.7rem;
            flex-shrink:0;
        }
        .sb-avatar {
            width:34px; height:34px;
            border-radius:50%;
            background:var(--sb-bg-bot);
            border:1px solid rgba(237,231,218,.18);
            color:var(--sb-accent);
            font-family: var(--font-display);
            font-size:.85rem; font-weight:600;
            display:grid; place-items:center;
            flex-shrink:0;
        }
        .sb-user-info { overflow:hidden; transition:opacity var(--t), width var(--t); }
        .sb-user-name { font-size:.83rem; font-weight:600; color:var(--sb-text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .sb-user-role { font-size:.71rem; color:var(--sb-muted); }

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
            background:var(--topbar-bg);
            backdrop-filter:blur(14px) saturate(140%);
            -webkit-backdrop-filter:blur(14px) saturate(140%);
            border-bottom:1px solid var(--topbar-border);
            display:flex; align-items:center; justify-content:space-between;
            padding:0 1.7rem;
            flex-shrink:0;
        }

        .topbar__left { display:flex; align-items:center; gap:1rem; }

        .topbar__mobile-toggle {
            display:none;
            background:var(--topbar-control); border:1px solid var(--border);
            border-radius:var(--radius-sm);
            width:36px; height:36px;
            cursor:pointer; color:var(--muted);
            align-items:center; justify-content:center;
        }
        .topbar__mobile-toggle:hover { background:var(--topbar-control-hover); color:var(--text); }

        .topbar__breadcrumb { display:flex; align-items:center; gap:.5rem; font-size:.92rem; color:var(--muted); }
        .topbar__breadcrumb strong { color:var(--text); font-weight:600; font-size:1.05rem; }

        .topbar__right { display:flex; align-items:center; gap:.65rem; }

        .topbar__theme {
            display:flex;
            align-items:center;
            padding:2px;
            border-radius:999px;
            background:var(--topbar-control);
            border:1px solid var(--border);
        }
        .topbar__theme-btn {
            border:none;
            background:transparent;
            color:var(--muted);
            border-radius:999px;
            padding:.36rem .68rem;
            font-size:.74rem;
            font-weight:600;
            line-height:1;
            cursor:pointer;
            transition:background var(--t), color var(--t);
        }
        .topbar__theme-btn:hover, .topbar__theme-btn:focus-visible { color:var(--text); outline:none; }
        .topbar__theme-btn.is-selected { background:var(--accent); color:#fff; }

        .topbar__status {
            display:flex; align-items:center; gap:.4rem;
            font-family: var(--font-mono);
            font-size:.68rem; font-weight:600;
            color:var(--flash-success-text);
            background:var(--flash-success-bg);
            border:1px solid var(--flash-success-border);
            padding:.32rem .65rem .32rem .55rem;
            border-radius:99px;
        }
        .topbar__status .sb-dot { width:5px; height:5px; border-radius:50%; background:currentColor; animation: softPulse 2.4s ease infinite; }

        .topbar__time {
            font-family: var(--font-mono);
            font-size:.76rem; font-weight:500;
            color:var(--muted);
            padding:.34rem .3rem;
        }

        .topbar__notify {
            position:relative;
            background:var(--topbar-control); border:1px solid var(--border);
            border-radius:var(--radius-sm);
            width:36px; height:36px;
            cursor:pointer; color:var(--muted);
            display:flex; align-items:center; justify-content:center;
        }
        .topbar__notify:hover { background:var(--topbar-control-hover); color:var(--text); }
        .topbar__notify-dot {
            position:absolute; top:7px; right:7px;
            width:6px; height:6px;
            background:var(--accent); border-radius:50%;
            border:2px solid var(--topbar-bg);
        }

        .topbar__user {
            display:inline-flex; align-items:center; gap:.6rem;
            padding:.32rem .85rem .32rem .32rem;
            border-radius:99px;
            background:var(--topbar-control); border:1px solid var(--border);
            color:var(--text); font-weight:600; font-size:.83rem;
        }
        .topbar__avatar {
            width:28px; height:28px; border-radius:50%;
            background:var(--surface-raised);
            border:1px solid var(--border);
            color:var(--accent);
            font-family: var(--font-display); font-size:.78rem; font-weight:600;
            display:grid; place-items:center;
        }

        /* ── PAGE CONTENT ─────────────────────────── */
        .app-content {
            flex:1;
            padding:1.9rem 2rem 0;
            animation:fadeUp .4s var(--ease-out) both;
        }

        /* ── FLASH MESSAGES ───────────────────────── */
        .flash {
            display:flex; align-items:center; gap:.7rem;
            padding:.85rem 1.05rem;
            border-radius:var(--radius);
            font-size:.875rem; font-weight:500;
            margin-bottom:1rem;
            animation:flashIn .3s var(--ease-out) both;
            cursor:pointer;
        }
        .flash-icon {
            width:20px; height:20px; border-radius:50%;
            display:grid; place-items:center;
            font-size:.68rem; font-weight:700;
            flex-shrink:0;
            color:#fff;
        }
        .flash-success { background:var(--flash-success-bg); border:1px solid var(--flash-success-border); color:var(--flash-success-text); }
        .flash-success .flash-icon { background:#3f6b4e; }
        .flash-error   { background:var(--flash-error-bg); border:1px solid var(--flash-error-border); color:var(--flash-error-text); }
        .flash-error .flash-icon   { background:#8b3a3a; }
        .flash-warning { background:var(--flash-warning-bg); border:1px solid var(--flash-warning-border); color:var(--flash-warning-text); }
        .flash-warning .flash-icon { background:#a9782e; }

        /* ── ERROR LIST ───────────────────────────── */
        .error-list {
            background:var(--flash-warning-bg); border:1px solid var(--flash-warning-border);
            border-radius:var(--radius);
            padding:.9rem 1.05rem;
            font-size:.875rem; color:var(--flash-warning-text);
            margin-bottom:1rem;
            animation:flashIn .3s var(--ease-out) both;
        }
        .error-list strong { font-weight:600; }
        .error-list ul { margin:.5rem 0 0 1.1rem; }
        .error-list li { margin-top:.25rem; }

        /* ── FOOTER ───────────────────────────────── */
        .app-footer {
            background:var(--footer-bg);
            margin-top:2.8rem;
            padding:1.4rem 2rem;
            display:flex; align-items:center;
            justify-content:space-between;
            flex-wrap:wrap; gap:.75rem;
        }

        .footer__brand { display:flex; align-items:center; gap:.65rem; }
        .footer__logo-img { width:22px; height:22px; object-fit:contain; filter:brightness(0) invert(1) opacity(.5); }
        .footer__copy { font-size:.78rem; color:var(--footer-text); }

        .footer__links { display:flex; gap:1.3rem; list-style:none; }
        .footer__links a { font-size:.78rem; color:var(--footer-text); transition:color var(--t); }
        .footer__links a:hover { color:#ede7da; }

        .footer__meta { font-family: var(--font-mono); font-size:.7rem; color:#5c584c; }
        .footer__meta strong { color:var(--footer-text); font-family: var(--font-mono); font-weight:600; }

        /* ── OVERLAY ──────────────────────────────── */
        .sb-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(11,12,16,.55);
            z-index:40;
            opacity:0; transition:opacity var(--t);
        }
        .sb-overlay.is-visible { display:block; opacity:1; }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width:960px) {
            .sidebar { transform:translateX(-100%); width:var(--sb-w) !important; }
            .sidebar.mobile-open { transform:translateX(0); }
            .app-main { margin-left:0 !important; }
            .topbar__mobile-toggle { display:inline-flex; }
            .sb-toggle { display:none; }
            .app-footer { flex-direction:column; align-items:flex-start; gap:1rem; }
            .topbar__status { display:none; }
        }

        @media (max-width:480px) {
            .app-content { padding:1.1rem 1.1rem 0; }
            .topbar { padding:0 1.1rem; }
            .topbar__time { display:none; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration:.01ms !important; transition-duration:.01ms !important; }
        }
    </style>
</head>

<body>

<div class="app-shell" x-data="staffLayout()">

    
    <div class="sb-overlay"
         :class="{ 'is-visible': mobileOpen }"
         @click="mobileOpen = false"></div>

    
    <aside class="sidebar"
           :class="{ 'is-collapsed': collapsed, 'mobile-open': mobileOpen }"
           aria-label="Staff navigation">

        
        <button class="sb-toggle"
                @click="collapsed = !collapsed"
                :aria-label="collapsed ? 'Expand sidebar' : 'Collapse sidebar'">
            <svg width="11" height="11" viewBox="0 0 12 12" fill="none">
                <path d="M7 2L3 6l4 4" stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        
        <div class="sb-brand">
            <div class="sb-logo-wrap">
                <img src="<?php echo e(asset('image/logo oif skillup(1).png')); ?>"
                     alt="SkillUp Logo"
                     class="sb-logo" />
            </div>
            <span class="sb-brand-name">SkillUp</span>
            <span class="sb-brand-sub"><span class="sb-dot" aria-hidden="true"></span>Staff Portal</span>
        </div>

        
        <nav class="sb-nav-scroll" aria-label="Sidebar menu">

            <div class="sb-section-title">Main</div>

            <a href="<?php echo e(route('staff.dashboard')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.dashboard') ? 'is-active' : ''); ?>"
               title="Dashboard">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="1" width="7" height="7" rx="1.5"/>
                    <rect x="10" y="1" width="7" height="7" rx="1.5"/>
                    <rect x="1" y="10" width="7" height="7" rx="1.5"/>
                    <rect x="10" y="10" width="7" height="7" rx="1.5"/>
                </svg>
                <span class="sb-label">Dashboard</span>
            </a>

            <div class="sb-section-title">Trainee management</div>

            <a href="<?php echo e(route('staff.users.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.users.*') ? 'is-active' : ''); ?>"
               title="Trainee List">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="6" r="3"/>
                    <path d="M2 16c0-3.314 3.134-6 7-6s7 2.686 7 6"/>
                </svg>
                <span class="sb-label">Trainee List</span>
            </a>

            <a href="<?php echo e(route('staff.enrollments.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.enrollments.*') ? 'is-active' : ''); ?>"
               title="Registration and Enrollment">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 4h12M3 8h8M3 12h5"/>
                    <circle cx="14" cy="13" r="3"/>
                    <path d="M13 13l.8.8 1.7-1.6" stroke-width="1.2"/>
                </svg>
                <span class="sb-label">Registration / Enrollment</span>
            </a>

            <div class="sb-section-title">Training program management</div>

            <a href="<?php echo e(route('staff.courses.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.courses.*') ? 'is-active' : ''); ?>"
               title="Programs and Qualifications">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h5.5v12H2zM10.5 3H16v12h-5.5z"/>
                    <path d="M7.5 6.5H10.5M7.5 9.5H10.5"/>
                </svg>
                <span class="sb-label">Programs / Qualifications</span>
            </a>

            <a href="<?php echo e(route('staff.modules.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.modules.*') ? 'is-active' : ''); ?>"
               title="Competencies">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 4h12M3 9h12M3 14h12"/>
                    <circle cx="6" cy="4" r="1" fill="currentColor"/>
                    <circle cx="10" cy="9" r="1" fill="currentColor"/>
                    <circle cx="14" cy="14" r="1" fill="currentColor"/>
                </svg>
                <span class="sb-label">Competencies</span>
            </a>

            <a href="<?php echo e(route('staff.subjects.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.subjects.*') ? 'is-active' : ''); ?>"
               title="Subjects">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2H6a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2z"/>
                    <path d="M7 6h4M7 10h4M7 14h4"/>
                </svg>
                <span class="sb-label">Subjects</span>
            </a>

            <div class="sb-section-title">Trainer management</div>

            <a href="<?php echo e(route('staff.teacher-subjects.index')); ?>" class="sb-nav-item <?php echo e(request()->routeIs('staff.teacher-subjects.*') ? 'is-active' : ''); ?>" title="Trainer Assignment">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 4h12M3 9h8M3 14h6"/><path d="M13 11v5M10.5 13.5h5"/>
                </svg>
                <span class="sb-label">Trainer Assignment</span>
            </a>
            <a href="<?php echo e(route('staff.schedule.index')); ?>" class="sb-nav-item <?php echo e(request()->routeIs('staff.schedule.*') ? 'is-active' : ''); ?>" title="Trainer Schedule">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="3" width="14" height="13" rx="1.5"/><path d="M5 2v3M13 2v3M2 7h14M5 10h3M5 13h5"/>
                </svg>
                <span class="sb-label">Trainer Schedule</span>
            </a>

            <div class="sb-section-title">Attendance & assessment</div>

            <a href="<?php echo e(route('staff.attendance.index')); ?>" class="sb-nav-item <?php echo e(request()->routeIs('staff.attendance.*') ? 'is-active' : ''); ?>" title="Daily Attendance">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="3" width="14" height="13" rx="1.5"/><path d="M5 2v3M13 2v3M2 7h14M5 11l2 2 5-4"/>
                </svg>
                <span class="sb-label">Daily Attendance</span>
            </a>

            <a href="<?php echo e(route('staff.assessments.schedule')); ?>" class="sb-nav-item <?php echo e(request()->routeIs('staff.assessments.schedule') ? 'is-active' : ''); ?>" title="Assessment Schedule">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="3" width="14" height="13" rx="1.5"/><path d="M5 2v3M13 2v3M2 7h14M5 10h7M5 13h4"/>
                </svg>
                <span class="sb-label">Assessment Schedule</span>
            </a>

            <a href="<?php echo e(route('staff.assessments.results')); ?>" class="sb-nav-item <?php echo e(request()->routeIs('staff.assessments.results') ? 'is-active' : ''); ?>" title="Assessment Results">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 3h12v12H3zM6 7h6M6 10h4M6 13h2"/>
                </svg>
                <span class="sb-label">Assessment Results</span>
            </a>

            <div class="sb-section-title">Documents & updates</div>

            <a href="<?php echo e(route('staff.syllabi.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.syllabi.*') ? 'is-active' : ''); ?>"
               title="Syllabus">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 4h12v9H3zM5 7h8M5 10h5"/>
                </svg>
                <span class="sb-label">Syllabus</span>
            </a>

            <a href="<?php echo e(route('staff.news.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.news.*') ? 'is-active' : ''); ?>"
               title="News & Alerts">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 4h14v9H8l-4 3V4z"/>
                    <path d="M6 7h6M6 10h4"/>
                </svg>
                <span class="sb-label">News & Alerts</span>
            </a>

            <div class="sb-section-title">Reports</div>

            <a href="<?php echo e(route('staff.reports.daily')); ?>" class="sb-nav-item <?php echo e(request()->routeIs('staff.reports.daily') ? 'is-active' : ''); ?>" title="Trainee Reports">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 15V3h12v12M6 12V8M9 12V5M12 12V9"/>
                </svg>
                <span class="sb-label">Trainee Reports</span>
            </a>
            <a href="<?php echo e(route('staff.reports.staff')); ?>" class="sb-nav-item <?php echo e(request()->routeIs('staff.reports.staff') ? 'is-active' : ''); ?>" title="Training Reports">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M2 14l3-5 3 3 3-6 3 4 2-3M2 2v12h14"/>
                </svg>
                <span class="sb-label">Training Reports</span>
            </a>

            <div class="sb-section-title">System</div>

            <a href="<?php echo e(route('staff.settings.index')); ?>"
               class="sb-nav-item <?php echo e(request()->routeIs('staff.settings.*') ? 'is-active' : ''); ?>"
               title="System Settings">
                <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="9" r="2.5"/>
                    <path d="M9 2v1.5M9 14.5V16M2 9h1.5M14.5 9H16
                             M3.93 3.93l1.06 1.06M13.01 13.01l1.06 1.06
                             M3.93 14.07l1.06-1.06M13.01 4.99l1.06-1.06"/>
                </svg>
                <span class="sb-label">Settings</span>
            </a>

            <div class="sb-divider"></div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="sb-nav-item is-danger" title="Sign Out">
                    <svg class="sb-icon" viewBox="0 0 18 18" fill="none" stroke="currentColor"
                         stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 3H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h4"/>
                        <path d="M12 13l4-4-4-4M16 9H7"/>
                    </svg>
                    <span class="sb-label">Sign Out</span>
                </button>
            </form>

        </nav>

        
        <div class="sb-user">
            <div class="sb-avatar"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></div>
            <div class="sb-user-info">
                <div class="sb-user-name"><?php echo e(Auth::user()->name); ?></div>
                <div class="sb-user-role">Staff Member</div>
            </div>
        </div>

    </aside>

    
    <div class="app-main" :class="{ 'sidebar-collapsed': collapsed }">

        
        <header class="topbar">
            <div class="topbar__left">
                <button class="topbar__mobile-toggle"
                        @click="mobileOpen = !mobileOpen"
                        aria-label="Open navigation">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M2 4.5h14M2 9h14M2 13.5h14"
                              stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="topbar__breadcrumb">
                    <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                        <?php echo $__env->yieldContent('breadcrumb'); ?>
                    <?php else: ?>
                        <strong><?php echo $__env->yieldContent('title', 'Dashboard'); ?></strong>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="topbar__right">
                <div class="topbar__theme" role="group" aria-label="Theme mode selector">
                    <button type="button" class="topbar__theme-btn" data-theme-option="light" aria-label="Switch to light mode" aria-pressed="false">Light</button>
                    <button type="button" class="topbar__theme-btn" data-theme-option="dark" aria-label="Switch to dark mode" aria-pressed="false">Dark</button>
                    <button type="button" class="topbar__theme-btn" data-theme-option="system" aria-label="Switch to system theme" aria-pressed="false">System</button>
                </div>

                <span class="topbar__status"><span class="sb-dot" aria-hidden="true"></span>Online</span>
                <span class="topbar__time" id="js-clock"></span>

                <button class="topbar__notify" aria-label="Notifications">
                    <svg width="16" height="16" viewBox="0 0 18 18" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                        <path d="M9 2a5.5 5.5 0 0 1 5.5 5.5c0 3 1 4 1.5 4.5H2c.5-.5 1.5-1.5 1.5-4.5A5.5 5.5 0 0 1 9 2z"/>
                        <path d="M7.5 15a1.5 1.5 0 0 0 3 0"/>
                    </svg>
                    <span class="topbar__notify-dot"></span>
                </button>

                <div class="topbar__user">
                    <div class="topbar__avatar"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></div>
                    <span><?php echo e(Auth::user()->name); ?></span>
                </div>
            </div>
        </header>

        
        <main class="app-content" id="main-content">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="flash flash-success js-flash" role="status">
                    <div class="flash-icon">✓</div>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="flash flash-error js-flash" role="alert">
                    <div class="flash-icon">✕</div>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="error-list">
                    <strong>Please fix the following:</strong>
                    <ul>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li><?php echo e($err); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>

        
        <footer class="app-footer" role="contentinfo">
            <div class="footer__brand">
                <img src="<?php echo e(asset('image/logo oif skillup(1).png')); ?>"
                     alt="SkillUp" class="footer__logo-img" />
                <span class="footer__copy">&copy; <?php echo e(date('Y')); ?> SkillUp. All rights reserved.</span>
            </div>

            <ul class="footer__links">
                <li><a href="<?php echo e(route('help.index')); ?>">Help Center</a></li>
                <li><a href="<?php echo e(route('privacy')); ?>">Privacy</a></li>
                <li><a href="<?php echo e(route('terms')); ?>">Terms</a></li>
            </ul>

            <span class="footer__meta">
                Logged in as <strong><?php echo e(Auth::user()->name); ?></strong>
                &nbsp;·&nbsp;
                <span id="js-date"></span>
            </span>
        </footer>

    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('staffLayout', () => ({
            collapsed: localStorage.getItem('sb_collapsed') === 'true',
            mobileOpen: false,
            init() {
                this.$watch('collapsed', v => localStorage.setItem('sb_collapsed', v));
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') this.mobileOpen = false;
                });
            }
        }));
    });

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

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.js-flash').forEach(f => {
            const dismiss = () => {
                f.style.transition = 'opacity .2s ease, transform .2s ease';
                f.style.opacity = '0';
                f.style.transform = 'translateY(-6px)';
                setTimeout(() => f.remove(), 220);
            };
            setTimeout(dismiss, 5000);
            f.addEventListener('click', dismiss);
        });
    });
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\layouts\masters.blade.php ENDPATH**/ ?>