<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIAS Student')</title>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel ="icon" href="{{ asset('image/logo_oif_skillup_1_-removebg-preview.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap">

    <!-- Apply theme before paint — no FOTS (flash of the-wrong-scheme) -->
    <script>
        (function () {
            var configured = @json(data_get(auth()->user()?->settings, 'appearance.theme'));
            var configuredFontSize = @json(data_get(auth()->user()?->settings, 'appearance.font_size'));
            var saved = localStorage.getItem('sias-theme');
            var savedFontSize = localStorage.getItem('sias-font-size');
            var theme = configured || saved || 'system';
            var fontSize = ['small', 'medium', 'large'].includes(configuredFontSize)
                ? configuredFontSize
                : (['small', 'medium', 'large'].includes(savedFontSize) ? savedFontSize : 'medium');
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.dataset.theme = theme;
            document.documentElement.dataset.fontSize = fontSize;
            document.documentElement.classList.toggle('dark-mode', theme === 'dark' || (theme === 'system' && prefersDark));
        })();
    </script>

    <style>
        /* ════════════════════════════════════════
           DESIGN TOKENS
        ════════════════════════════════════════ */
        :root {
            font-size: 16px;
            /* Easing library */
            --ease:        cubic-bezier(.22, 1, .36, 1);
            --ease-spring: cubic-bezier(.34, 1.56, .64, 1);
            --ease-out:    cubic-bezier(.16, 1, .3, 1);
            --ease-bounce: cubic-bezier(.68, -.55, .265, 1.55);
            --ease-smooth: cubic-bezier(.4, 0, .2, 1);

            /* Light palette */
            --bg:               #f0f3fb;
            --bg-glow-1:        rgba(201,151,59,.10);
            --bg-glow-2:        rgba(58,84,163,.09);
            --bg-glow-3:        rgba(99,179,237,.06);
            --text:             #0d1829;
            --text-muted:       #56667e;
            --text-faint:       #94a3b8;

            /* Sidebar */
            --nav-bg-start:     #080e1e;
            --nav-bg-end:       #111c38;
            --nav-text:         #98a6c2;
            --nav-text-strong:  #f4f6fd;
            --nav-active-bg:    rgba(224,176,84,.16);
            --nav-hover-bg:     rgba(255,255,255,.055);
            --nav-group-label:  #64729a;
            --nav-border:       rgba(148,163,184,.14);

            /* Accent — warm gold */
            --accent:           #c9973b;
            --accent-strong:    #e0b054;
            --accent-vivid:     #f0c96c;
            --accent-contrast:  #2c2103;
            --accent-glow:      rgba(224,176,84,.35);

            /* Surfaces */
            --card-bg:          #ffffff;
            --card-border:      rgba(16,27,46,.055);
            --card-shadow:      0 32px 64px -20px rgba(16,27,46,.14), 0 2px 6px rgba(16,27,46,.05);
            --block-bg:         #f6f8fd;
            --block-bg-hover:   #ffffff;
            --block-border:     #e2e7f3;
            --divider:          #e4e9f3;

            /* Controls */
            --toggle-bg:        #ffffff;
            --toggle-border:    #e2e7f3;
            --focus-ring:       #3a54a3;
            --scrollbar:        #c8d2e8;

            /* Chips */
            --chip-bg:          rgba(37,99,235,.08);
            --chip-text:        #1d4ed8;

            /* Logo */
            --logo-shadow:      0 6px 18px rgba(0,0,0,.1);

            /* Transitions */
            --t-theme:          .4s var(--ease);
        }

        html[data-font-size="small"] { font-size: 14px; }
        html[data-font-size="medium"] { font-size: 16px; }
        html[data-font-size="large"] { font-size: 18px; }

        html.dark-mode {
            --bg:               #060910;
            --bg-glow-1:        rgba(224,176,84,.07);
            --bg-glow-2:        rgba(63,90,168,.12);
            --bg-glow-3:        rgba(56,189,248,.05);
            --text:             #e5eaf5;
            --text-muted:       #8a97b6;
            --text-faint:       #4a5578;

            --nav-bg-start:     #040710;
            --nav-bg-end:       #0c1428;
            --nav-text:         #8f9ec0;
            --nav-text-strong:  #f6f8fc;
            --nav-active-bg:    rgba(224,176,84,.18);
            --nav-hover-bg:     rgba(255,255,255,.045);
            --nav-group-label:  #58668e;
            --nav-border:       rgba(148,163,184,.12);

            --accent:           #e0b054;
            --accent-strong:    #efc06a;
            --accent-vivid:     #f8d690;
            --accent-contrast:  #1e1502;
            --accent-glow:      rgba(224,176,84,.4);

            --card-bg:          #0c1526;
            --card-border:      rgba(255,255,255,.055);
            --card-shadow:      0 32px 64px -20px rgba(0,0,0,.65), 0 2px 8px rgba(0,0,0,.3);
            --block-bg:         #0e192e;
            --block-bg-hover:   #111f3a;
            --block-border:     #1a2b48;
            --divider:          #1a2b48;

            --toggle-bg:        #0c1526;
            --toggle-border:    #1a2b48;
            --focus-ring:       #e0b054;
            --scrollbar:        #1f3155;

            --chip-bg:          rgba(224,176,84,.13);
            --chip-text:        #f0c476;
            --logo-shadow:      0 8px 28px rgba(0,0,0,.45);
        }

        /* ════════════════════════════════════════
           RESET & BASE
        ════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html {
            scrollbar-color: var(--scrollbar) transparent;
            scroll-behavior: smooth;
        }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: var(--scrollbar);
            border-radius: 20px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent); }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background:
                radial-gradient(70% 52% at 92% -10%, var(--bg-glow-1), transparent 72%),
                radial-gradient(60% 45% at -8% 108%, var(--bg-glow-2), transparent 72%),
                radial-gradient(40% 35% at 50% 110%, var(--bg-glow-3), transparent 70%),
                var(--bg);
            transition: background-color var(--t-theme), color var(--t-theme);
            min-height: 100vh;
        }

        :focus-visible {
            outline: 2px solid var(--focus-ring);
            outline-offset: 3px;
            border-radius: 6px;
        }

        /* ════════════════════════════════════════
           LAYOUT SHELL
        ════════════════════════════════════════ */
        .layout-shell {
            display: grid;
            min-height: 100vh;
            grid-template-columns: 300px 1fr;
            position: relative;
            z-index: 1;
            transition: grid-template-columns .35s var(--ease);
        }

        /* ── Sidebar collapsed state ───────────── */
        .layout-shell.sidebar-collapsed {
            grid-template-columns: 0px 1fr;
        }

        .layout-shell.sidebar-collapsed .nav-panel {
            transform: translateX(-100%);
            pointer-events: none;
            visibility: hidden;
        }

        /* ── Sidebar Toggle Button ─────────────── */
        #sidebarToggle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid var(--toggle-border);
            background: var(--toggle-bg);
            color: var(--text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: transform .28s var(--ease-spring), box-shadow .28s var(--ease),
                        background .28s var(--ease), border-color .28s var(--ease);
            flex-shrink: 0;
        }
        #sidebarToggle:hover {
            transform: scale(1.12);
            box-shadow: 0 8px 22px var(--accent-glow);
            border-color: var(--accent);
        }
        #sidebarToggle:active { transform: scale(.92); }
        #sidebarToggle .toggle-bars {
            display: flex;
            flex-direction: column;
            gap: 4.5px;
            pointer-events: none;
        }
        #sidebarToggle .toggle-bars span {
            display: block;
            height: 2px;
            border-radius: 2px;
            background: currentColor;
            transition: width .25s var(--ease), transform .25s var(--ease), opacity .2s var(--ease);
        }
        #sidebarToggle .toggle-bars span:nth-child(1) { width: 18px; }
        #sidebarToggle .toggle-bars span:nth-child(2) { width: 14px; }
        #sidebarToggle .toggle-bars span:nth-child(3) { width: 18px; }

        .sidebar-collapsed #sidebarToggle .toggle-bars span:nth-child(1) { width: 18px; transform: translateY(6.5px) rotate(45deg); }
        .sidebar-collapsed #sidebarToggle .toggle-bars span:nth-child(2) { opacity: 0; width: 0; }
        .sidebar-collapsed #sidebarToggle .toggle-bars span:nth-child(3) { width: 18px; transform: translateY(-6.5px) rotate(-45deg); }

        /* ════════════════════════════════════════
           SIDEBAR
        ════════════════════════════════════════ */
        .nav-panel {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
            padding: 0;
            display: flex;
            flex-direction: column;
            background: linear-gradient(175deg, var(--nav-bg-start) 0%, var(--nav-bg-end) 100%);
            color: var(--nav-text);
            border-right: 1px solid var(--nav-border);
            transition: background var(--t-theme), transform .35s var(--ease), visibility .35s;
            animation: slideInLeft .55s var(--ease) both;

            /* Subtle noise texture overlay */
            isolation: isolate;
        }

        /* Animated aurora accent behind sidebar */
        .nav-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 200px 160px at 50% -40px, rgba(224,176,84,.12), transparent 70%),
                radial-gradient(ellipse 150px 200px at 110% 70%, rgba(58,84,163,.10), transparent 70%);
            pointer-events: none;
            z-index: 0;
            animation: auroraShift 8s ease-in-out infinite alternate;
        }

        .nav-panel::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 120px;
            background: linear-gradient(to top, rgba(0,0,0,.25), transparent);
            pointer-events: none;
            z-index: 0;
        }

        .nav-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 20px 14px 18px;
        }

        /* — Brand — */
        .brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            margin-bottom: 1.1rem;
            padding: 2px 4px 0;
            animation: fadeSlideDown .6s var(--ease) both;
            animation-delay: .08s;
        }

        .brand-logos {
            display: flex;
            gap: .35rem;
            align-items: center;
        }

        .brand-logo {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            overflow: hidden;
            background: rgba(255,255,255,.08);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--logo-shadow), 0 0 0 1px rgba(255,255,255,.1);
            transition: transform .35s var(--ease-spring), box-shadow .35s var(--ease);
            animation: scaleInPop .55s var(--ease-spring) both;
        }
        .brand-logo:nth-child(1) { animation-delay: .12s; }
        .brand-logo:nth-child(2) { animation-delay: .18s; }
        .brand-logo:nth-child(3) { animation-delay: .24s; }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .brand-logo:hover {
            transform: translateY(-4px) scale(1.12) rotate(-3deg);
            box-shadow: 0 14px 32px var(--accent-glow), 0 0 0 1px rgba(255,255,255,.15);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            gap: .05rem;
            animation: fadeIn .6s var(--ease) .2s both;
        }

        .brand-mark {
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-weight: 700;
            font-size: 1rem;
            color: var(--accent-strong);
            letter-spacing: -.01em;
            line-height: 1.1;
        }

        .brand-sub {
            font-size: .6rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--nav-group-label);
        }

        /* — Nav title — */
        .nav-title {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.15rem;
            letter-spacing: -.01em;
            color: var(--nav-text-strong);
            margin-bottom: 1rem;
            padding: 0 4px;
            animation: fadeSlideDown .55s var(--ease) .22s both;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .nav-title-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, rgba(224,176,84,.4), transparent);
            animation: growLine .7s var(--ease) .35s both;
            transform-origin: left;
        }

        /* — Scroll area — */
        .nav-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 2px 0 4px;
            margin: 0 -4px;
            scrollbar-width: thin;
        }
        .nav-scroll::-webkit-scrollbar { width: 3px; }
        .nav-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 4px; }

        /* — Rail indicator — */
        .nav-rail {
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 40px;
            border-radius: 0 4px 4px 0;
            background: linear-gradient(180deg, var(--accent-vivid), var(--accent));
            box-shadow: 0 0 12px var(--accent-glow);
            opacity: 0;
            transition: transform .3s var(--ease-spring), height .3s var(--ease), opacity .2s var(--ease);
            pointer-events: none;
        }

        /* — Nav links — */
        .nav-scroll nav {
            position: relative;
            padding: 0 4px;
        }

        .nav-scroll nav a {
            position: relative;
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .15rem;
            color: var(--nav-text);
            text-decoration: none;
            padding: .72rem .85rem;
            border-radius: 12px;
            font-size: .9rem;
            font-weight: 500;
            transition:
                background .22s var(--ease),
                color .22s var(--ease),
                padding-left .22s var(--ease),
                transform .22s var(--ease-spring),
                box-shadow .22s var(--ease);
            animation: fadeSlideRight .4s var(--ease) both;
            animation-delay: calc(var(--i, 0) * .04s);
            will-change: transform;
        }

        .nav-scroll nav a i {
            width: 18px;
            text-align: center;
            font-size: .9rem;
            flex-shrink: 0;
            transition: color .22s var(--ease), transform .3s var(--ease-spring);
        }

        .nav-scroll nav a .nav-label { flex: 1; }

        .nav-scroll nav a .nav-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: .6rem;
            font-weight: 700;
            background: var(--accent-glow);
            color: var(--accent-vivid);
            padding: .15rem .4rem;
            border-radius: 100px;
            letter-spacing: .04em;
            opacity: 0;
            transform: scale(.8);
            transition: opacity .2s var(--ease), transform .2s var(--ease-spring);
        }

        .nav-scroll nav a:hover .nav-badge,
        .nav-scroll nav a.active .nav-badge { opacity: 1; transform: scale(1); }

        .nav-scroll nav a.active,
        .nav-scroll nav a:hover,
        .nav-scroll nav a:focus-visible {
            background: var(--nav-hover-bg);
            color: var(--nav-text-strong);
            padding-left: 1.05rem;
        }

        .nav-scroll nav a.active {
            background: var(--nav-active-bg);
            box-shadow: inset 3px 0 0 var(--accent-strong);
            font-weight: 600;
        }

        .nav-scroll nav a.active i { color: var(--accent-strong); }

        .nav-scroll nav a:hover i {
            color: var(--accent-strong);
            transform: scale(1.15) rotate(-5deg);
        }

        .nav-scroll nav a:active { transform: scale(.97); }

        /* — Collapsible groups — */
        .nav-collapse {
            margin-bottom: .1rem;
            animation: fadeSlideRight .4s var(--ease) both;
            animation-delay: calc(var(--i, 0) * .04s);
            border-radius: 12px;
            overflow: hidden;
        }

        .nav-collapse > summary {
            list-style: none;
            display: flex;
            align-items: center;
            gap: .65rem;
            cursor: pointer;
            padding: .68rem .85rem;
            border-radius: 12px;
            font-size: .88rem;
            font-weight: 500;
            color: var(--nav-text);
            transition:
                background .22s var(--ease),
                color .22s var(--ease),
                padding-left .22s var(--ease);
            user-select: none;
        }

        .nav-collapse > summary::-webkit-details-marker { display: none; }

        .nav-collapse > summary i.lead {
            width: 18px;
            text-align: center;
            font-size: .85rem;
            flex-shrink: 0;
            transition: color .22s var(--ease), transform .3s var(--ease-spring);
        }

        .nav-collapse > summary .chev {
            margin-left: auto;
            font-size: .68rem;
            color: var(--nav-group-label);
            transition: transform .32s var(--ease-spring), color .22s var(--ease);
        }

        .nav-collapse > summary:hover,
        .nav-collapse > summary:focus-visible {
            background: var(--nav-hover-bg);
            color: var(--nav-text-strong);
            padding-left: 1.05rem;
        }

        .nav-collapse > summary:hover i.lead { color: var(--accent-strong); transform: scale(1.12); }

        .nav-collapse[open] > summary { color: var(--nav-text-strong); }
        .nav-collapse[open] > summary .chev { transform: rotate(90deg); color: var(--accent-strong); }
        .nav-collapse[open] > summary i.lead { color: var(--accent-strong); }

        /* Subitems */
        .nav-subitems {
            display: flex;
            flex-direction: column;
            gap: .06rem;
            padding: .2rem 0 .35rem .75rem;
            border-left: 1px solid rgba(255,255,255,.08);
            margin: .06rem 0 .1rem .9rem;
        }

        .nav-subitems a {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .46rem .65rem;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 500;
            color: var(--nav-text);
            text-decoration: none;
            transition:
                background .2s var(--ease),
                color .2s var(--ease),
                padding-left .2s var(--ease),
                transform .2s var(--ease-spring);
        }

        .nav-subitems a i { font-size: .72rem; flex-shrink: 0; transition: color .2s var(--ease), transform .2s var(--ease-spring); }

        .nav-subitems a:hover,
        .nav-subitems a:focus-visible {
            background: var(--nav-hover-bg);
            color: var(--nav-text-strong);
            padding-left: .85rem;
        }

        .nav-subitems a:hover i { color: var(--accent-strong); transform: scale(1.15); }

        .nav-subitems a.active {
            background: var(--nav-active-bg);
            color: var(--nav-text-strong);
            font-weight: 600;
        }

        .nav-subitems a.active i { color: var(--accent-strong); }

        /* — User card at bottom — */
        .nav-foot {
            padding-top: 12px;
            border-top: 1px solid rgba(255,255,255,.07);
        }

        /* Profile pill */
        .user-pill {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .6rem .75rem;
            border-radius: 12px;
            margin-bottom: .5rem;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.06);
            transition: background .2s var(--ease);
        }

        .user-pill:hover { background: rgba(255,255,255,.07); }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent) 0%, #3a54a3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 0 0 2px var(--accent-glow);
            animation: avatarPulse 3s ease-in-out 1s infinite;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: .8rem; font-weight: 600; color: var(--nav-text-strong); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: .68rem; color: var(--nav-group-label); font-weight: 500; letter-spacing: .04em; }

        .btn-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            background: rgba(255,255,255,.02);
            border: 1px solid rgba(203,213,225,.15);
            color: var(--nav-text);
            padding: .72rem 0;
            cursor: pointer;
            border-radius: 11px;
            font-family: inherit;
            font-size: .87rem;
            font-weight: 500;
            transition: all .22s var(--ease);
            position: relative;
            overflow: hidden;
        }

        .btn-logout::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(239,68,68,.15), rgba(220,38,38,.08));
            opacity: 0;
            transition: opacity .22s var(--ease);
            border-radius: inherit;
        }

        .btn-logout:hover::before { opacity: 1; }
        .btn-logout:hover { color: #fca5a5; border-color: rgba(239,68,68,.3); }
        .btn-logout:hover i { transform: translateX(3px); }
        .btn-logout i { transition: transform .22s var(--ease-spring); }
        .btn-logout:active { transform: scale(.97); }

        /* ════════════════════════════════════════
           MAIN CONTENT
        ════════════════════════════════════════ */
        .content-panel {
            padding: 28px 32px;
            min-width: 0;
            overflow: hidden;
        }

        /* Animated gradient orbs in main area */
        .content-panel::before {
            content: '';
            position: fixed;
            top: -120px;
            right: -80px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--bg-glow-1), transparent 70%);
            pointer-events: none;
            z-index: 0;
            animation: orbFloat 10s ease-in-out infinite;
        }

        .page-card {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 22px;
            padding: 28px;
            box-shadow: var(--card-shadow);
            transition: box-shadow var(--t-theme), border-color var(--t-theme), background-color var(--t-theme);
            animation: cardRise .55s var(--ease) .05s both;
        }

        /* ════════════════════════════════════════
           PAGE HEADER
        ════════════════════════════════════════ */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 24px;
            padding-bottom: 18px;
            position: relative;
            animation: fadeIn .5s var(--ease) .1s both;
        }

        .page-header::after {
            content: '';
            position: absolute;
            left: 0; bottom: 0;
            height: 1px;
            width: 100%;
            background: var(--divider);
        }

        .page-header::before {
            content: '';
            position: absolute;
            left: 0; bottom: -1px;
            height: 2px;
            width: 56px;
            background: linear-gradient(90deg, var(--accent-vivid), var(--accent), transparent);
            border-radius: 2px;
            animation: growLine .8s var(--ease) .3s both;
            z-index: 1;
            box-shadow: 0 0 10px var(--accent-glow);
        }

        .page-header-title h2 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 2rem;
            letter-spacing: -.025em;
            line-height: 1.1;
            animation: slideInDown .5s var(--ease) .1s both;
        }

        .page-header-meta {
            display: flex;
            align-items: center;
            gap: .55rem;
            margin-top: .45rem;
            font-size: .83rem;
            color: var(--text-muted);
            flex-wrap: wrap;
            animation: fadeIn .5s var(--ease) .16s both;
        }

        .page-header-meta .welcome strong { color: var(--text); font-weight: 700; }

        .meta-dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--text-faint);
            flex-shrink: 0;
        }

        .version-chip {
            display: inline-flex;
            align-items: center;
            gap: .28rem;
            background: var(--chip-bg);
            color: var(--chip-text);
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .04em;
            padding: .22rem .6rem;
            border-radius: 100px;
            cursor: default;
            transition: transform .3s var(--ease-spring), box-shadow .3s var(--ease);
            animation: fadeIn .5s var(--ease) .2s both;
        }
        .version-chip:hover { transform: scale(1.08); box-shadow: 0 4px 12px var(--chip-bg); }

        /* — Header actions — */
        .page-header-actions {
            display: flex;
            align-items: center;
            gap: .6rem;
            flex-shrink: 0;
            animation: slideInRight .5s var(--ease) .18s both;
        }

        /* Language switcher */
        .lang-switcher {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 5px;
            border-radius: 999px;
            background: rgba(148,163,184,.07);
            border: 1px solid var(--toggle-border);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.3);
            backdrop-filter: blur(8px);
        }

        .lang-btn {
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 8px 11px;
            border-radius: 999px;
            cursor: pointer;
            transition: background .22s var(--ease), color .22s var(--ease), box-shadow .22s var(--ease), transform .22s var(--ease-spring);
        }

        .lang-btn:hover { color: var(--text); transform: scale(1.04); }

        .lang-btn.active {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            box-shadow: 0 6px 18px rgba(37,99,235,.25);
            transform: scale(1.02);
        }

        /* Theme toggle */
        #themeToggle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid var(--toggle-border);
            background: var(--toggle-bg);
            color: var(--text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform .28s var(--ease-spring), box-shadow .28s var(--ease), background .28s var(--ease), border-color .28s var(--ease);
        }

        #themeToggle:hover {
            transform: rotate(-14deg) scale(1.12);
            box-shadow: 0 8px 22px var(--accent-glow);
            border-color: var(--accent);
        }

        #themeToggle:active { transform: scale(.92); }
        #themeToggle.spin .icon { animation: spinPop .45s var(--ease-spring); }

        #themeToggle .icon {
            display: block;
            transition: transform .3s var(--ease-spring);
            line-height: 1;
        }

        /* ════════════════════════════════════════
           GENERIC COMPONENTS
        ════════════════════════════════════════ */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: .82rem 1.25rem;
            font-weight: 700;
            font-size: .9rem;
            text-decoration: none;
            transition: transform .22s var(--ease), box-shadow .22s var(--ease), filter .22s var(--ease);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover, .btn-primary:focus-visible {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(29,78,216,.28);
            filter: brightness(1.05);
        }

        .btn-primary:active { transform: translateY(0); }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            background: var(--card-bg);
            color: var(--text);
            border: 1px solid var(--block-border);
            border-radius: 12px;
            padding: .82rem 1.25rem;
            font-weight: 600;
            font-size: .9rem;
            text-decoration: none;
            transition: transform .22s var(--ease), box-shadow .22s var(--ease), border-color .22s var(--ease);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-secondary:hover, .btn-secondary:focus-visible {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(15,23,42,.09);
            border-color: #a3bffa;
        }

        .btn-secondary:active { transform: translateY(0); }

        /* Ripple effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            background: rgba(255,255,255,.45);
            pointer-events: none;
            animation: rippleOut .6s var(--ease-out);
        }
        .btn-secondary .ripple { background: rgba(37,99,235,.12); }
        .btn-logout .ripple { background: rgba(239,68,68,.12); }

        /* Form inputs */
        .form-input {
            width: 100%;
            min-height: 48px;
            border: 1px solid var(--block-border);
            border-radius: 12px;
            padding: .92rem 1rem;
            background: var(--card-bg);
            color: var(--text);
            font: inherit;
            font-size: .93rem;
            transition: border-color .22s var(--ease), box-shadow .22s var(--ease), transform .22s var(--ease);
        }
        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3.5px rgba(37,99,235,.13);
            outline: none;
            transform: translateY(-1px);
        }

        /* Dashboard grid */
        .dashboard-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            margin-top: 18px;
        }

        .dashboard-card {
            background: var(--block-bg);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid var(--block-border);
            border-left: 3px solid transparent;
            transition:
                transform .28s var(--ease-spring),
                border-color .28s var(--ease),
                background-color .28s var(--ease),
                box-shadow .28s var(--ease);
            animation: fadeSlideUp .45s var(--ease) both;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 60%, rgba(224,176,84,.04) 100%);
            pointer-events: none;
            opacity: 0;
            transition: opacity .3s var(--ease);
        }

        .dashboard-card:hover::after { opacity: 1; }

        .dashboard-card:nth-child(1) { animation-delay: .08s; }
        .dashboard-card:nth-child(2) { animation-delay: .13s; }
        .dashboard-card:nth-child(3) { animation-delay: .18s; }
        .dashboard-card:nth-child(4) { animation-delay: .23s; }
        .dashboard-card:nth-child(5) { animation-delay: .28s; }
        .dashboard-card:nth-child(6) { animation-delay: .33s; }

        .dashboard-card:hover {
            transform: translateY(-6px) scale(1.02);
            border-left-color: var(--accent);
            background: var(--block-bg-hover);
            box-shadow: 0 18px 40px rgba(15,23,42,.12);
        }

        .dashboard-card:active { transform: translateY(-2px) scale(1.005); }

        .dashboard-card strong {
            display: block;
            margin-bottom: .5rem;
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: .66rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        /* Section card */
        .section-card {
            background: var(--card-bg);
            border: 1px solid var(--block-border);
            border-radius: 22px;
            padding: 1.4rem;
            box-shadow: 0 18px 45px rgba(15,23,42,.07);
            transition: transform .3s var(--ease-spring), box-shadow .3s var(--ease), border-color .3s var(--ease);
            animation: fadeSlideUp .45s var(--ease) both;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 28px 65px rgba(15,23,42,.13);
            border-color: rgba(37,99,235,.15);
        }

        /* ════════════════════════════════════════
           KEYFRAMES
        ════════════════════════════════════════ */
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeSlideRight {
            from { opacity: 0; transform: translateX(-12px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-28px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(16px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes growLine {
            from { width: 0; opacity: 0; }
            to   { width: 100%; opacity: 1; }
        }

        @keyframes cardRise {
            from { opacity: 0; transform: translateY(22px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes scaleInPop {
            from { opacity: 0; transform: scale(.3) rotate(-20deg); }
            to   { opacity: 1; transform: scale(1) rotate(0deg); }
        }

        @keyframes spinPop {
            0%   { transform: rotate(0deg) scale(1); }
            45%  { transform: rotate(195deg) scale(1.4); opacity: .5; }
            100% { transform: rotate(360deg) scale(1); opacity: 1; }
        }

        @keyframes rippleOut {
            to { transform: scale(2.8); opacity: 0; }
        }

        @keyframes auroraShift {
            0%   { opacity: .7; transform: translate(0, 0) scale(1); }
            50%  { opacity: 1;  transform: translate(8px, -6px) scale(1.04); }
            100% { opacity: .8; transform: translate(-4px, 4px) scale(.97); }
        }

        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%      { transform: translate(-20px, 20px) scale(1.04); }
            66%      { transform: translate(14px, -14px) scale(.97); }
        }

        @keyframes avatarPulse {
            0%, 100% { box-shadow: 0 0 0 2px var(--accent-glow); }
            50%      { box-shadow: 0 0 0 5px transparent; }
        }

        /* Native view transitions */
        @view-transition { navigation: auto; }

        /* ════════════════════════════════════════
           RESPONSIVE
        ════════════════════════════════════════ */
        @media (max-width: 900px) {
            .layout-shell {
                grid-template-columns: 1fr;
            }

            .nav-panel {
                position: sticky;
                top: 0;
                height: auto;
                z-index: 30;
                animation: fadeSlideDown .4s var(--ease) both;
            }

            .nav-inner {
                padding: 12px 10px 6px;
            }

            .brand { margin-bottom: .5rem; }
            .brand-logo { width: 28px; height: 28px; }

            .nav-title { font-size: 1rem; margin-bottom: .6rem; }
            .nav-title-line { display: none; }

            .nav-scroll {
                display: flex;
                gap: .3rem;
                overflow-x: auto;
                overflow-y: visible;
                padding-bottom: 8px;
                scrollbar-width: none;
            }
            .nav-scroll::-webkit-scrollbar { display: none; }

            .nav-scroll nav {
                display: flex;
                gap: .25rem;
                white-space: nowrap;
            }

            .nav-scroll nav a {
                margin-bottom: 0;
                padding: .5rem .8rem;
                font-size: .8rem;
                white-space: nowrap;
                animation: none;
            }

            .nav-collapse > summary {
                white-space: nowrap;
                padding: .5rem .8rem;
                font-size: .8rem;
            }

            .nav-subitems {
                flex-direction: row;
                border-left: none;
                margin-left: 0;
                padding-left: 0;
                gap: .18rem;
            }

            .nav-subitems a {
                white-space: nowrap;
                padding: .44rem .65rem;
                font-size: .78rem;
            }

            .nav-rail, .nav-foot { display: none; }

            .content-panel { padding: 16px 14px; }
            .page-card { padding: 16px; border-radius: 16px; }
            .page-header-title h2 { font-size: 1.5rem; }
            .page-header { flex-wrap: wrap; }
        }

        /* ════════════════════════════════════════
           REDUCED MOTION
        ════════════════════════════════════════ */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .001ms !important;
            }
            ::view-transition-group(*),
            ::view-transition-old(*),
            ::view-transition-new(*) {
                animation: none !important;
            }
        }

        @media (prefers-color-scheme: dark) { body { color-scheme: dark; } }
    </style>
</head>
<body>
<div class="layout-shell">

    <!-- ════════ SIDEBAR ════════ -->
    <aside class="nav-panel" role="navigation" aria-label="Main navigation">
        <div class="nav-inner">

            <!-- Brand -->
            <div class="brand">
                <div class="brand-logos">
                    <div class="brand-logo" title="SIAS">
                        <img src="{{ asset('image/logo new.jpg') }}" alt="SIAS Logo" width="32" height="32" loading="eager" decoding="async">
                    </div>
                    <div class="brand-logo" title="Institution">
                        <img src="{{ asset('image/hello.png') }}" alt="Institution Logo" width="32" height="32" loading="lazy" decoding="async">
                    </div>
                    <div class="brand-logo" title="Bagong Pilipinas">
                        <img src="{{ asset('image/bagong-pilipinas-logo-png_seeklogo-534301.png') }}" alt="Bagong Pilipinas" width="32" height="32" loading="lazy" decoding="async">
                    </div>
                </div>
                <div class="brand-text">
                    <span class="brand-mark">SIAS</span>
                    <span class="brand-sub">Student Portal</span>
                </div>
            </div>

            <!-- Nav title -->
            <div class="nav-title">
                <span data-i18n="navigation">{{ __('sias.navigation') }}</span>
                <span class="nav-title-line" aria-hidden="true"></span>
            </div>

            <!-- Scrollable nav -->
            <div class="nav-scroll">
                <nav>
                    <div class="nav-rail" aria-hidden="true"></div>

                    <a style="--i:1"
                       href="{{ route('sias.student.dashboard') }}"
                       class="{{ request()->routeIs('sias.student.dashboard') ? 'active' : '' }}"
                       aria-current="{{ request()->routeIs('sias.student.dashboard') ? 'page' : 'false' }}">
                        <i class="fa-solid fa-gauge" aria-hidden="true"></i>
                        <span class="nav-label" data-i18n="dashboard">Dashboard</span>
                    </a>

                    <!-- Records group -->
                    <details class="nav-collapse"
                             {{ request()->routeIs('sias.student.profile','sias.student.enrollment','sias.student.subjects','sias.student.schedule') ? 'open' : '' }}
                             style="--i:2">
                        <summary>
                            <i class="fa-solid fa-folder-open lead" aria-hidden="true"></i>
                            <span data-i18n="records">Records</span>
                            <i class="fa-solid fa-chevron-right chev" aria-hidden="true"></i>
                        </summary>
                        <div class="nav-subitems">
                            <a href="{{ route('sias.student.profile') }}"
                               class="{{ request()->routeIs('sias.student.profile') ? 'active' : '' }}">
                                <i class="fa-solid fa-user" aria-hidden="true"></i>
                                <span data-i18n="profile">Profile</span>
                            </a>
                            <a href="{{ route('sias.student.enrollment') }}"
                               class="{{ request()->routeIs('sias.student.enrollment') ? 'active' : '' }}">
                                <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                <span data-i18n="pre_enlistment">Pre-enlistment</span>
                            </a>
                            <a href="{{ route('sias.student.enrollment') }}"
                               class="{{ request()->routeIs('sias.student.enrollment') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                                <span data-i18n="enrollment">Enrollment</span>
                            </a>
                            <a href="{{ route('sias.student.subjects') }}"
                               class="{{ request()->routeIs('sias.student.subjects') ? 'active' : '' }}">
                                <i class="fa-solid fa-book" aria-hidden="true"></i>
                                <span data-i18n="subjects">Subjects</span>
                            </a>
                            <a href="{{ route('sias.student.schedule') }}"
                               class="{{ request()->routeIs('sias.student.schedule') ? 'active' : '' }}">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                                <span data-i18n="schedule">Schedule</span>
                            </a>
                        </div>
                    </details>

                    <!-- Academics group -->
                    <details class="nav-collapse"
                             {{ request()->routeIs('sias.student.assessment','sias.student.grades','sias.student.attendance','sias.student.teacher_evaluation') ? 'open' : '' }}
                             style="--i:3">
                        <summary>
                            <i class="fa-solid fa-book-open lead" aria-hidden="true"></i>
                            <span data-i18n="academics">Academics</span>
                            <i class="fa-solid fa-chevron-right chev" aria-hidden="true"></i>
                        </summary>
                        <div class="nav-subitems">
                            <a href="{{ route('sias.student.assessment') }}"
                               class="{{ request()->routeIs('sias.student.assessment') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-circle-check" aria-hidden="true"></i>
                                <span data-i18n="assessment">Assessment</span>
                            </a>
                            <a href="{{ route('sias.student.grades') }}"
                               class="{{ request()->routeIs('sias.student.grades') ? 'active' : '' }}">
                                <i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>
                                <span data-i18n="grades">Grades</span>
                            </a>
                            <a href="{{ route('sias.student.attendance') }}"
                               class="{{ request()->routeIs('sias.student.attendance') ? 'active' : '' }}">
                                <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i>
                                <span data-i18n="attendance">Attendance</span>
                            </a>
                            <a href="{{ route('sias.student.teacher_evaluation') }}"
                               class="{{ request()->routeIs('sias.student.teacher_evaluation') ? 'active' : '' }}">
                                <i class="fa-solid fa-chalkboard-user" aria-hidden="true"></i>
                                <span data-i18n="evaluation">Evaluation</span>
                            </a>
                        </div>
                    </details>

                    <!-- Reports group -->
                    <details class="nav-collapse"
                             data-report-nav
                             {{ request()->routeIs('sias.student.reports.*') ? 'open' : '' }}
                             style="--i:4">
                        <summary>
                            <i class="fa-solid fa-chart-simple lead" aria-hidden="true"></i>
                            <span data-i18n="reports">Reports</span>
                            <i class="fa-solid fa-chevron-right chev" aria-hidden="true"></i>
                        </summary>
                        <div class="nav-subitems">
                            <a href="{{ route('sias.student.reports.class-offerings') }}"
                               class="report-subitem {{ request()->routeIs('sias.student.reports.class-offerings') ? 'active' : '' }}"
                               data-report-section="class-offerings">
                                <i class="fa-solid fa-school" aria-hidden="true"></i>
                                <span data-i18n="class_offerings">Class Offerings</span>
                            </a>
                            <a href="{{ route('sias.student.reports.enrolled-subjects') }}"
                               class="report-subitem {{ request()->routeIs('sias.student.reports.enrolled-subjects') ? 'active' : '' }}"
                               data-report-section="enrolled-subjects">
                                <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                                <span data-i18n="subjects_report">Subjects</span>
                            </a>
                            <a href="{{ route('sias.student.reports.final-grades-match') }}"
                               class="report-subitem {{ request()->routeIs('sias.student.reports.final-grades-match') ? 'active' : '' }}"
                               data-report-section="final-grades-match">
                                <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>
                                <span data-i18n="final_grades">Final Grades</span>
                            </a>
                            <a href="{{ route('sias.student.reports.gwa-match') }}"
                               class="report-subitem {{ request()->routeIs('sias.student.reports.gwa-match') ? 'active' : '' }}"
                               data-report-section="gwa-match">
                                <i class="fa-solid fa-percent" aria-hidden="true"></i>
                                <span data-i18n="gwa">GWA</span>
                            </a>
                            <a href="{{ route('sias.student.reports.term-grades-match') }}"
                               class="report-subitem {{ request()->routeIs('sias.student.reports.term-grades-match') ? 'active' : '' }}"
                               data-report-section="term-grades-match">
                                <i class="fa-solid fa-list-ol" aria-hidden="true"></i>
                                <span data-i18n="term_grades">Term Grades</span>
                            </a>
                        </div>
                    </details>

                    <a href="{{ route('sias.student.announcements') }}"
                       class="{{ request()->routeIs('sias.student.announcements') ? 'active' : '' }}">
                        <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
                        <span class="nav-label">Announcements</span>
                    </a>
                    <a href="{{ route('sias.student.notifications') }}"
                       class="{{ request()->routeIs('sias.student.notifications') ? 'active' : '' }}">
                        <i class="fa-solid fa-bell" aria-hidden="true"></i>
                        <span class="nav-label">Notifications</span>
                    </a>

                    <!-- Account & Security -->
                    <details class="nav-collapse"
                             {{ request()->routeIs('sias.student.account.*') ? 'open' : '' }}
                             style="--i:5">
                        <summary>
                            <i class="fa-solid fa-shield-halved lead" aria-hidden="true"></i>
                            <span data-i18n="account_security">Account &amp; Security</span>
                            <i class="fa-solid fa-chevron-right chev" aria-hidden="true"></i>
                        </summary>
                        <div class="nav-subitems">
                            <a href="{{ route('sias.student.settings') }}"
                               class="{{ request()->routeIs('sias.student.settings') ? 'active' : '' }}">
                                <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                                <span data-i18n="settings">{{ __('sias.settings') }}</span>
                            </a>
                            <a href="{{ route('sias.student.account.password') }}"
                               class="{{ request()->routeIs('sias.student.account.password') ? 'active' : '' }}">
                                <i class="fa-solid fa-key" aria-hidden="true"></i>
                                <span data-i18n="password">Password</span>
                            </a>
                            <a href="{{ route('sias.student.account.mfa') }}"
                               class="{{ request()->routeIs('sias.student.account.mfa') ? 'active' : '' }}">
                                <i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i>
                                <span data-i18n="mfa">MFA</span>
                            </a>
                        </div>
                    </details>

                    <a style="--i:6"
                       href="{{ route('sias.student.help') }}"
                       class="{{ request()->routeIs('sias.student.help') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                        <span class="nav-label" data-i18n="help">{{ __('sias.help') }}</span>
                    </a>
                </nav>
            </div>

            <!-- Footer: user + logout -->
            <div class="nav-foot">
                <div class="user-pill" aria-label="Logged in as {{ Auth::user()->name ?? 'Student' }}">
                    <div class="user-avatar" aria-hidden="true">
                        {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name ?? 'Student' }}</div>
                        <div class="user-role">Student</div>
                    </div>
                    <i class="fa-solid fa-circle fa-xs" style="color:rgba(74,222,128,.7);font-size:.42rem;flex-shrink:0;" title="Online" aria-label="Online"></i>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                        <span data-i18n="sign_out">{{ __('sias.sign_out') }}</span>
                    </button>
                </form>
            </div>

        </div><!-- /.nav-inner -->
    </aside>

    <!-- ════════ MAIN ════════ -->
    <main class="content-panel" id="main-content" tabindex="-1">
        <div class="page-card">

            <div class="page-header">
                <div class="page-header-title">
                    <h2>@yield('page_title', 'Student Portal')</h2>
                    <div class="page-header-meta">
                        <span class="welcome">
                            <span data-i18n="welcome">{{ __('sias.welcome') }}</span>,
                            <strong>{{ Auth::user()->name ?? 'Student' }}</strong>
                        </span>
                        <span class="meta-dot" aria-hidden="true"></span>
                        <span class="version-chip" title="System version">
                            <i class="fa-solid fa-code-branch" aria-hidden="true"></i>
                            v{{ config('sias.version', '3.7.8.7') }}
                        </span>
                    </div>
                </div>

                <div class="page-header-actions">
                    <!-- Sidebar Toggle -->
                    <button id="sidebarToggle"
                            type="button"
                            aria-label="Toggle sidebar navigation"
                            aria-expanded="true"
                            title="Toggle Sidebar">
                        <div class="toggle-bars" aria-hidden="true">
                            <span></span><span></span><span></span>
                        </div>
                    </button>

                    <!-- Language Switcher -->
                    <div class="lang-switcher" role="group" aria-label="{{ __('sias.language') }}">
                        @foreach(['en' => 'EN', 'tl' => 'TL'] as $code => $label)
                            <form method="GET" action="{{ route('language.switch', $code) }}" style="margin:0;display:inline-flex;">
                                <button type="submit"
                                        class="lang-btn {{ app()->getLocale() === $code ? 'active' : '' }}"
                                        aria-pressed="{{ app()->getLocale() === $code ? 'true' : 'false' }}"
                                        aria-label="Switch to {{ $label }}">{{ $label }}</button>
                            </form>
                        @endforeach
                    </div>

                    <!-- Theme Toggle -->
                    <button id="themeToggle"
                            type="button"
                            aria-label="Toggle light/dark theme"
                            aria-pressed="false">
                        <span class="icon" aria-hidden="true">🌙</span>
                    </button>
                </div>
            </div>

            @yield('content')

        </div><!-- /.page-card -->
    </main>

</div><!-- /.layout-shell -->

<script>
/* ════════════════════════════════════════
   THEME TOGGLE
   ════════════════════════════════════════ */
(function () {
    'use strict';
    var btn  = document.getElementById('themeToggle');
    var html = document.documentElement;
    var systemTheme = window.matchMedia('(prefers-color-scheme: dark)');

    window.siasApplyTheme = function (theme, persist) {
        var isDark = theme === 'dark' || (theme === 'system' && systemTheme.matches);
        html.classList.toggle('dark-mode', isDark);
        html.dataset.theme = theme;
        if (persist) {
            if (theme === 'system') localStorage.removeItem('sias-theme');
            else localStorage.setItem('sias-theme', theme);
        }
        if (btn) reflect(isDark);
    };

    window.siasApplyFontSize = function (fontSize, persist) {
        if (!['small', 'medium', 'large'].includes(fontSize)) fontSize = 'medium';
        html.dataset.fontSize = fontSize;
        if (persist) localStorage.setItem('sias-font-size', fontSize);
    };

    systemTheme.addEventListener('change', function () {
        if (html.dataset.theme === 'system') window.siasApplyTheme('system', false);
    });

    if (!btn) return;
    var icon = btn.querySelector('.icon');

    function reflect(isDark) {
        icon.textContent = isDark ? '☀️' : '🌙';
        btn.setAttribute('aria-pressed', String(isDark));
    }

    window.siasApplyTheme(html.dataset.theme || 'system', false);

    btn.addEventListener('click', function () {
        var isDark = !html.classList.contains('dark-mode');
        window.siasApplyTheme(isDark ? 'dark' : 'light', true);
        btn.classList.remove('spin');
        void btn.offsetWidth; // force reflow to restart animation
        btn.classList.add('spin');
    });
}());

/* ════════════════════════════════════════
   SIDEBAR TOGGLE
   ════════════════════════════════════════ */
(function () {
    'use strict';
    var shell = document.querySelector('.layout-shell');
    var btn   = document.getElementById('sidebarToggle');
    if (!shell || !btn) return;

    var KEY = 'sias-sidebar-collapsed';

    function applyState(collapsed) {
        shell.classList.toggle('sidebar-collapsed', collapsed);
        btn.setAttribute('aria-expanded', String(!collapsed));
        btn.setAttribute('title', collapsed ? 'Open Sidebar' : 'Close Sidebar');
    }

    // Restore persisted state
    var saved = localStorage.getItem(KEY);
    if (saved === 'true') applyState(true);

    btn.addEventListener('click', function () {
        var isCollapsed = shell.classList.contains('sidebar-collapsed');
        applyState(!isCollapsed);
        localStorage.setItem(KEY, String(!isCollapsed));
    });
}());

/* ════════════════════════════════════════
   NAV RAIL INDICATOR
   ════════════════════════════════════════ */
(function () {
    'use strict';
    var nav    = document.querySelector('.nav-scroll nav');
    var rail   = document.querySelector('.nav-rail');
    if (!nav || !rail) return;

    var links  = Array.prototype.slice.call(nav.querySelectorAll(':scope > a'));
    var active = nav.querySelector(':scope > a.active') || links[0];
    var raf    = null;

    function isMobile() { return window.matchMedia('(max-width: 900px)').matches; }

    function moveRail(link) {
        if (!link) { rail.style.opacity = '0'; return; }
        rail.style.opacity = '1';
        if (isMobile()) {
            rail.style.transform = 'translateX(' + link.offsetLeft + 'px)';
            rail.style.width     = link.offsetWidth + 'px';
            rail.style.height    = '3px';
        } else {
            rail.style.transform = 'translateY(' + link.offsetTop + 'px)';
            rail.style.height    = link.offsetHeight + 'px';
            rail.style.width     = '';
        }
    }

    function queue(link) {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(function () { moveRail(link); });
    }

    links.forEach(function (link) {
        link.addEventListener('mouseenter', function () { queue(link); }, { passive: true });
        link.addEventListener('focus',      function () { queue(link); }, { passive: true });
    });
    nav.addEventListener('mouseleave', function () { queue(active); }, { passive: true });
    window.addEventListener('resize',  function () { queue(active); }, { passive: true });

    queue(active);
    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(function () { queue(active); });
    } else {
        setTimeout(function () { queue(active); }, 180);
    }
}());

/* ════════════════════════════════════════
   DEFERRED NON-CRITICAL SETUP
   ════════════════════════════════════════ */
var deferIdle = window.requestIdleCallback || function (fn) { setTimeout(fn, 1); };

deferIdle(function () {
    /* Report nav hash-based active section */
    var reportNav   = document.querySelector('[data-report-nav]');
    var reportLinks = Array.prototype.slice.call(document.querySelectorAll('.report-subitem'));

    if (reportNav && reportLinks.length) {
        function updateReportNav(hash) {
            var key = hash ? hash.replace('#', '') : '';
            reportLinks.forEach(function (link) {
                link.classList.toggle('active', link.getAttribute('data-report-section') === key);
            });
            if (key) reportNav.setAttribute('open', '');
        }
        updateReportNav(window.location.hash);
        window.addEventListener('hashchange', function () {
            updateReportNav(window.location.hash);
        }, { passive: true });
    }

    /* Press-ripple feedback */
    var rippleTargets = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-logout');
    Array.prototype.forEach.call(rippleTargets, function (el) {
        el.addEventListener('click', function (e) {
            var rect = el.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);
            var span = document.createElement('span');
            span.className = 'ripple';
            span.style.cssText = [
                'width:' + size + 'px',
                'height:' + size + 'px',
                'left:' + (e.clientX - rect.left - size / 2) + 'px',
                'top:' + (e.clientY - rect.top  - size / 2) + 'px'
            ].join(';');
            el.appendChild(span);
            span.addEventListener('animationend', function () { span.remove(); }, { once: true });
        });
    });
});

/* ════════════════════════════════════════
   SMOOTH ACCORDION WITH WEB ANIMATIONS API
   ════════════════════════════════════════ */
(function () {
    'use strict';
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var DURATION = reducedMotion ? 0 : 230;
    var EASING   = 'cubic-bezier(.22, 1, .36, 1)';

    function Accordion(el) {
        this.el        = el;
        this.summary   = el.querySelector(':scope > summary');
        this.content   = el.querySelector(':scope > .nav-subitems');
        this.animation = null;
        this.closing   = false;
        this.opening   = false;
        if (!this.summary || !this.content) return;
        this.summary.addEventListener('click', this._onClick.bind(this));
    }

    Accordion.prototype._onClick = function (e) {
        e.preventDefault();
        this.el.style.overflow = 'hidden';
        if (this.closing || !this.el.open) { this._open(); }
        else if (this.opening || this.el.open) { this._close(); }
    };

    Accordion.prototype._open = function () {
        this.el.style.height = this.el.offsetHeight + 'px';
        this.el.open = true;
        requestAnimationFrame(this._expand.bind(this));
    };

    Accordion.prototype._expand = function () {
        this.opening = true;
        var start = this.el.offsetHeight;
        var end   = this.summary.offsetHeight + this.content.offsetHeight;
        if (this.animation) this.animation.cancel();
        this.animation = this.el.animate(
            { height: [start + 'px', end + 'px'] },
            { duration: DURATION, easing: EASING }
        );
        this.animation.onfinish  = this._finish.bind(this, true);
        this.animation.oncancel  = function () { this.opening = false; }.bind(this);
    };

    Accordion.prototype._close = function () {
        this.closing = true;
        var start = this.el.offsetHeight;
        var end   = this.summary.offsetHeight;
        if (this.animation) this.animation.cancel();
        this.animation = this.el.animate(
            { height: [start + 'px', end + 'px'] },
            { duration: DURATION, easing: EASING }
        );
        this.animation.onfinish  = this._finish.bind(this, false);
        this.animation.oncancel  = function () { this.closing = false; }.bind(this);
    };

    Accordion.prototype._finish = function (open) {
        this.el.open   = open;
        this.animation = null;
        this.closing   = false;
        this.opening   = false;
        this.el.style.height   = '';
        this.el.style.overflow = '';
    };

    Array.prototype.forEach.call(
        document.querySelectorAll('.nav-collapse'),
        function (el) { new Accordion(el); }
    );
}());
</script>
<script>
    (function () {
        var translations = @json(__('sias'));
        var english = @json(__('sias', [], 'en'));
        document.querySelectorAll('[data-i18n]').forEach(function (element) {
            var key = element.getAttribute('data-i18n');
            if (translations[key]) element.textContent = translations[key];
        });
        if (document.documentElement.lang !== 'en') {
            var phraseMap = {};
            Object.keys(english).forEach(function (key) {
                if (translations[key] && english[key] !== translations[key]) phraseMap[english[key]] = translations[key];
            });
            var walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
            var node;
            while (node = walker.nextNode()) {
                var parent = node.parentElement;
                if (!parent || ['SCRIPT', 'STYLE', 'INPUT', 'TEXTAREA', 'SELECT', 'OPTION'].includes(parent.tagName)) continue;
                var text = node.nodeValue.trim();
                if (text && phraseMap[text]) node.nodeValue = node.nodeValue.replace(text, phraseMap[text]);
            }
        }
    }());
</script>
</body>
</html>