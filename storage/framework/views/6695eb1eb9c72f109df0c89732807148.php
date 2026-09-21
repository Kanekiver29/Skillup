<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SIAS Teacher'); ?></title>
    <link rel ="icon" href="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" type="image/x-icon">
    <!-- Set theme + sidebar state BEFORE paint to avoid flash-of-wrong-state -->
    <script>
        (function () {
            var configuredTheme = <?php echo json_encode(data_get(auth()->user()?->settings, 'appearance.theme'), 512) ?>;
            var savedTheme = localStorage.getItem('sias-theme');
            var theme = configuredTheme || savedTheme || 'system';
            var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            var isDark = theme === 'dark' || (theme === 'system' && prefersDark);
            document.documentElement.classList.toggle('dark-mode', isDark);
            document.documentElement.dataset.theme = theme;

            var savedSidebar = localStorage.getItem('sias-sidebar');
            if (savedSidebar === 'collapsed') document.documentElement.classList.add('sidebar-collapsed');
        })();
    </script>

    <!-- Preconnects speed up font + icon fetches -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Only the weights actually used, to keep load light -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600;700&display=swap">

    <style>
        :root {
            /* ---- Academic seal: deep navy, brushed brass, warm ivory ---- */
            --ink: #16213A;
            --paper: #FAF8F2;
            --nav-bg-top: #0B1220;
            --nav-bg-bottom: #16233D;
            --nav-text: #A9B4C9;
            --brass: #B08D57;
            --brass-light: #D8BC85;
            --border: #E8E2D3;
            --card-bg: #FFFFFF;
            --shadow: 0 20px 46px rgba(11,18,32,.08);
            --shadow-soft: 0 10px 22px rgba(11,18,32,.06);
            --shadow-inner: inset 0 2px 8px rgba(0,0,0,.06);
            --ease: cubic-bezier(.22,1,.36,1);
            --ease-smooth: cubic-bezier(.4, 0, .2, 1);
            --font-display: 'Fraunces', Georgia, serif;
            --font-body: 'Inter', system-ui, sans-serif;

            --sidebar-w: 260px;
            --sidebar-w-collapsed: 84px;
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            font-family: var(--font-body);
            background: var(--paper);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Custom scrollbar for main content area */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--paper);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--brass) 0%, var(--brass-light) 100%);
            border-radius: 10px;
            transition: background .3s var(--ease-smooth);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--brass-light) 0%, var(--brass) 100%);
            box-shadow: 0 0 10px rgba(176,141,87,.25);
        }

        .dark-mode::-webkit-scrollbar-track { background: #0B1220; }
        .dark-mode::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #D8BC85 0%, #B08D57 100%); }

        /* Firefox scrollbar */
        * {
            scrollbar-color: var(--brass) var(--paper);
            scrollbar-width: thin;
        }

        .dark-mode {
            scrollbar-color: var(--brass) #0B1220;
        }

        /* Slim brass rule pinned to the very top — a quiet premium signal */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--brass) 0%, var(--brass-light) 50%, var(--brass) 100%);
            z-index: 60;
            box-shadow: 0 2px 12px rgba(176,141,87,.15);
        }

        .layout-shell {
            display: grid;
            min-height: 100vh;
            grid-template-columns: var(--sidebar-w) 1fr;
            transition: grid-template-columns .35s var(--ease-smooth);
        }

        html.sidebar-collapsed .layout-shell {
            grid-template-columns: var(--sidebar-w-collapsed) 1fr;
        }

        /* ---------- Sidebar ---------- */
        .nav-panel {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 28px 22px;
            background: linear-gradient(180deg, var(--nav-bg-top) 0%, var(--nav-bg-bottom) 100%);
            color: var(--nav-text);
            display: flex;
            flex-direction: column;
            animation: slideInLeft .6s var(--ease) both;
            overflow: hidden;
            transition: padding .35s var(--ease-smooth);
            z-index: 50;
            box-shadow: 2px 0 12px rgba(0,0,0,.12);
        }

        .nav-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(216,188,133,.05), transparent 70%);
            pointer-events: none;
            z-index: 1;
        }

        html.sidebar-collapsed .nav-panel { 
            padding: 28px 14px;
        }

        /* Scrollable nav area with custom scrollbar */
        .nav-panel nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 6px;
            scroll-behavior: smooth;
        }

        .nav-panel nav::-webkit-scrollbar {
            width: 6px;
        }

        .nav-panel nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .nav-panel nav::-webkit-scrollbar-thumb {
            background: rgba(216,188,133,.25);
            border-radius: 3px;
            transition: background .2s var(--ease-smooth);
        }

        .nav-panel nav::-webkit-scrollbar-thumb:hover {
            background: rgba(216,188,133,.45);
        }

        .nav-panel nav {
            scrollbar-color: rgba(216,188,133,.25) transparent;
        }

        /* Signature: a hand-drawn seal that traces itself in once, on load */
        .brand-mark {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
            min-height: 40px;
            position: relative;
            z-index: 2;
            animation: fadeSlideUp .6s var(--ease-smooth) both;
        }

        .seal { 
            width: 40px; 
            height: 40px; 
            flex: none;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,.15));
        }

        .seal circle, .seal path {
            fill: none;
            stroke: var(--brass-light);
            stroke-width: 1.6;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 220;
            stroke-dashoffset: 220;
            animation: drawSeal 1.2s var(--ease-smooth) .2s forwards;
        }

        .seal .seal-letter {
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: drawSeal .8s var(--ease-smooth) .8s forwards;
        }

        .brand-copy {
            line-height: 1.15;
            white-space: nowrap;
            opacity: 1;
            max-width: 200px;
            transition: opacity .3s var(--ease-smooth), max-width .35s var(--ease-smooth), margin .35s var(--ease-smooth);
            position: relative;
            z-index: 2;
        }

        html.sidebar-collapsed .brand-copy {
            opacity: 0;
            max-width: 0;
            margin: 0;
            pointer-events: none;
        }

        .brand-copy .eyebrow {
            display: block;
            font-size: .68rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--brass-light);
            margin-bottom: 2px;
            opacity: 0;
            animation: fadeIn .5s var(--ease-smooth) .6s forwards;
        }

        .brand-copy h1 {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 1.32rem;
            margin: 0;
            color: #fff;
            letter-spacing: -.01em;
            opacity: 0;
            animation: fadeSlideUp .6s var(--ease-smooth) .4s forwards;
        }

        .nav-panel nav {
            position: relative;
            z-index: 2;
        }

        .nav-panel nav a {
            position: relative;
            display: flex;
            align-items: center;
            gap: .7rem;
            margin-bottom: 0.4rem;
            color: var(--nav-text);
            text-decoration: none;
            font-size: .92rem;
            font-weight: 500;
            padding: 0.78rem 0.9rem 0.78rem 1.1rem;
            border-radius: 10px;
            transition: background .25s var(--ease-smooth), color .25s var(--ease-smooth), padding-left .25s var(--ease-smooth), box-shadow .25s var(--ease-smooth);
            opacity: 0;
            animation: fadeSlideUp .5s var(--ease-smooth) both;
            white-space: nowrap;
            overflow: hidden;
            will-change: background, color;
        }

        html.sidebar-collapsed .nav-panel nav a {
            padding-left: .9rem;
            justify-content: center;
            gap: 0;
        }

        .nav-panel nav a span:not(.nav-tooltip) {
            transition: opacity .2s var(--ease-smooth), max-width .3s var(--ease-smooth), margin .3s var(--ease-smooth);
            max-width: 180px;
            opacity: 1;
        }

        html.sidebar-collapsed .nav-panel nav a span:not(.nav-tooltip) {
            opacity: 0;
            max-width: 0;
            margin: 0;
        }

        /* Brass indicator bar that grows in from the left edge */
        .nav-panel nav a::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            width: 3px; height: 0;
            background: linear-gradient(180deg, var(--brass) 0%, var(--brass-light) 100%);
            border-radius: 0 3px 3px 0;
            transform: translateY(-50%);
            transition: height .3s var(--ease-smooth);
            box-shadow: 0 0 8px rgba(216,188,133,.3);
        }

        .nav-panel nav a:nth-child(1) { animation-delay: .50s; }
        .nav-panel nav a:nth-child(2) { animation-delay: .55s; }
        .nav-panel nav a:nth-child(3) { animation-delay: .60s; }
        .nav-panel nav a:nth-child(4) { animation-delay: .65s; }
        .nav-panel nav a:nth-child(5) { animation-delay: .70s; }
        .nav-panel nav a:nth-child(6) { animation-delay: .75s; }
        .nav-panel nav a:nth-child(7) { animation-delay: .80s; }
        .nav-panel nav a:nth-child(8) { animation-delay: .85s; }
        .nav-panel nav a:nth-child(9) { animation-delay: .90s; }
        .nav-panel nav a:nth-child(10) { animation-delay: .95s; }
        .nav-panel nav a:nth-child(11) { animation-delay: 1.0s; }
        .nav-panel nav a:nth-child(12) { animation-delay: 1.05s; }
        .nav-panel nav a:nth-child(13) { animation-delay: 1.10s; }
        .nav-panel nav a:nth-child(14) { animation-delay: 1.15s; }

        .nav-panel nav a:hover {
            background: rgba(216,188,133,.14);
            color: #fff;
            padding-left: 1.3rem;
            box-shadow: inset 0 0 12px rgba(216,188,133,.08);
        }

        html.sidebar-collapsed .nav-panel nav a:hover { 
            padding-left: .9rem;
        }

        .nav-panel nav a:hover::before { 
            height: 70%;
            box-shadow: 0 0 12px rgba(216,188,133,.5);
        }

        .nav-panel nav a.active {
            background: rgba(216,188,133,.18);
            color: #fff;
            font-weight: 600;
            box-shadow: inset 0 0 16px rgba(216,188,133,.12);
        }

        .nav-panel nav a.active::before { 
            height: 70%;
            box-shadow: 0 0 16px rgba(216,188,133,.6);
        }

        .nav-panel nav a i { 
            width: 18px; 
            text-align: center; 
            color: var(--brass-light); 
            font-size: .9rem; 
            flex: none;
            transition: transform .3s var(--ease-smooth);
        }

        .nav-panel nav a:hover i {
            transform: translateX(2px);
        }

        /* Tooltip shown only while collapsed, on hover */
        .nav-tooltip {
            position: absolute;
            left: calc(100% + 14px);
            top: 50%;
            transform: translateY(-50%) translateX(-6px) scale(.9);
            background: var(--ink);
            color: #fff;
            font-size: .78rem;
            font-weight: 600;
            padding: .5rem .8rem;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity .2s var(--ease-smooth), transform .2s var(--ease-smooth);
            box-shadow: 0 8px 20px rgba(0,0,0,.25), var(--shadow-soft);
            z-index: 70;
            backdrop-filter: blur(4px);
        }

        .nav-tooltip::before {
            content: '';
            position: absolute;
            left: -5px; top: 50%;
            width: 10px; height: 10px;
            background: var(--ink);
            transform: translateY(-50%) rotate(45deg);
        }

        html.sidebar-collapsed .nav-panel nav a:hover .nav-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) translateX(0) scale(1);
        }

        .nav-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(169,180,201,.2) 50%, transparent 100%);
            margin: 12px 0 18px;
            position: relative;
            z-index: 2;
            animation: fadeIn .5s var(--ease-smooth) .95s forwards;
            opacity: 0;
        }

        /* Collapse toggle, pinned to the sidebar's edge */
        .sidebar-toggle {
            position: absolute;
            top: 34px;
            right: -14px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid var(--border);
            background: linear-gradient(135deg, #fff 0%, #f9f7f2 100%);
            color: var(--ink);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(176,141,87,.18);
            z-index: 65;
            transition: box-shadow .25s var(--ease-smooth), transform .35s var(--ease-smooth), background .25s var(--ease-smooth), border-color .25s var(--ease-smooth);
            font-size: .85rem;
            will-change: transform;
        }

        .sidebar-toggle:hover { 
            box-shadow: 0 12px 28px rgba(176,141,87,.32);
            background: linear-gradient(135deg, #fff 0%, #fffbf7 100%);
            border-color: var(--brass);
            transform: translateX(2px);
            color: var(--brass);
        }

        .sidebar-toggle:active {
            transform: translateX(2px) scale(.95);
        }

        .sidebar-toggle i { 
            transition: transform .4s var(--ease-smooth);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        html.sidebar-collapsed .sidebar-toggle i { 
            transform: rotate(180deg);
        }

        /* Mobile off-canvas trigger, hidden on desktop */
        .sidebar-open-trigger {
            display: none;
        }

        /* Backdrop for mobile off-canvas sidebar */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(11,18,32,.45);
            z-index: 55;
            opacity: 0;
            transition: opacity .3s var(--ease-smooth);
            backdrop-filter: blur(2px);
        }

        /* ---------- Main content ---------- */
        .content-panel { 
            padding: 32px 36px; 
            min-width: 0;
            overflow-y: auto;
            background: var(--paper);
        }

        .content-panel::-webkit-scrollbar {
            width: 10px;
        }

        .content-panel::-webkit-scrollbar-track {
            background: var(--paper);
        }

        .content-panel::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--brass) 0%, var(--brass-light) 100%);
            border-radius: 10px;
        }

        .content-panel::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, var(--brass-light) 0%, var(--brass) 100%);
        }

        .page-card {
            position: relative;
            background: var(--card-bg);
            border-radius: 18px;
            padding: 26px;
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeSlideUp .6s var(--ease-smooth) .25s both;
        }

        .page-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(216,188,133,.03), transparent 70%);
            pointer-events: none;
        }

        /* Hairline brass edge across the top of every content card */
        .page-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--brass) 0%, var(--brass-light) 50%, var(--brass) 100%);
            box-shadow: 0 2px 8px rgba(176,141,87,.2);
        }

        .dashboard-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin-top: 18px;
        }

        .dashboard-card, .section-block {
            background: var(--paper);
            border-radius: 14px;
            padding: 18px;
            border: 1.5px solid var(--border);
            transition: transform .3s var(--ease-smooth), box-shadow .3s var(--ease-smooth), border-color .3s var(--ease-smooth), background .3s var(--ease-smooth);
            animation: fadeSlideUp .6s var(--ease-smooth) both;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::before, .section-block::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(216,188,133,.05), transparent 70%);
            pointer-events: none;
            opacity: 0;
            transition: opacity .3s var(--ease-smooth);
        }

        .dashboard-card:hover, .section-block:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(176,141,87,.12);
            border-color: var(--brass-light);
            background: #FEFDFB;
        }

        .dashboard-card:hover::before, .section-block:hover::before {
            opacity: 1;
        }

        .dashboard-card strong { 
            display: block; 
            margin-bottom: 0.6rem; 
            font-family: var(--font-display);
            font-size: 1.05rem;
        }

        .section-block strong { 
            display: block; 
            margin-bottom: 0.45rem; 
            font-family: var(--font-display);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 28px;
            animation: fadeSlideUp .6s var(--ease-smooth) both;
            flex-wrap: wrap;
        }

        .page-header h2 {
            margin: 0;
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 2.2rem;
            letter-spacing: -.015em;
            display: flex;
            align-items: center;
            gap: .7rem;
            color: var(--ink);
        }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            font-family: var(--font-body);
            font-size: .92rem;
            font-weight: 600;
            padding: .75rem 1.5rem;
            border-radius: 10px;
            border: 2px solid var(--ink);
            cursor: pointer;
            text-decoration: none;
            transition: background .2s var(--ease-smooth), color .2s var(--ease-smooth), transform .15s var(--ease-smooth), box-shadow .2s var(--ease-smooth), border-color .2s var(--ease-smooth);
            position: relative;
            overflow: hidden;
            will-change: transform;
        }

        .btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(255,255,255,.3), transparent 70%);
            opacity: 0;
            transition: opacity .3s var(--ease-smooth);
        }

        .btn:hover::before {
            opacity: 1;
        }

        .btn:active { 
            transform: translateY(1px) scale(.98);
        }

        .btn-black {
            background: var(--ink);
            color: #fff;
        }

        .btn-black:hover {
            background: var(--brass);
            border-color: var(--brass);
            color: #fff;
            box-shadow: 0 8px 20px rgba(176,141,87,.35);
        }

        .btn-white {
            background: #fff;
            color: var(--ink);
        }

        .btn-white:hover {
            background: var(--ink);
            color: #fff;
        }

        /* Logout button, styled for the dark sidebar */
        .btn-logout {
            width: 100%;
            justify-content: center;
            background: transparent;
            color: var(--nav-text);
            border: 1.5px solid rgba(169,180,201,.32);
            white-space: nowrap;
            overflow: hidden;
            position: relative;
            z-index: 2;
            transition: background .25s var(--ease-smooth), color .25s var(--ease-smooth), border-color .25s var(--ease-smooth), box-shadow .25s var(--ease-smooth);
        }

        .btn-logout:hover {
            background: var(--brass);
            color: #fff;
            border-color: var(--brass);
            box-shadow: 0 8px 16px rgba(176,141,87,.25);
        }

        .btn-logout span:not(.nav-tooltip) {
            transition: opacity .2s var(--ease-smooth), max-width .3s var(--ease-smooth), margin .3s var(--ease-smooth);
            max-width: 140px;
            opacity: 1;
        }

        html.sidebar-collapsed .btn-logout span:not(.nav-tooltip) {
            opacity: 0;
            max-width: 0;
            margin: 0;
        }

        /* ---------- Language pill ---------- */
        .lang-pill {
            display: inline-flex; 
            align-items: center; 
            gap: 4px;
            padding: 5px; 
            border-radius: 999px;
            background: rgba(176,141,87,.08);
            border: 1.5px solid var(--border);
            transition: background .2s var(--ease-smooth), border-color .2s var(--ease-smooth);
            box-shadow: var(--shadow-soft);
        }

        .lang-btn {
            border: none; 
            font-size: 11px; 
            font-weight: 700;
            letter-spacing: .08em; 
            text-transform: uppercase;
            padding: 8px 14px; 
            border-radius: 999px; 
            cursor: pointer;
            transition: background .2s var(--ease-smooth), color .2s var(--ease-smooth), box-shadow .2s var(--ease-smooth), transform .15s var(--ease-smooth);
            position: relative;
            overflow: hidden;
        }

        .lang-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle, rgba(255,255,255,.2), transparent 70%);
            opacity: 0;
            transition: opacity .2s var(--ease-smooth);
        }

        .lang-btn:active {
            transform: scale(.95);
        }

        .lang-btn.is-active {
            background: linear-gradient(135deg, var(--brass) 0%, var(--brass-light) 100%);
            color: #fff;
            box-shadow: 0 8px 18px rgba(176,141,87,.32);
        }

        .lang-btn:not(.is-active) { 
            background: transparent; 
            color: #7C8AA0;
            transition: color .2s var(--ease-smooth);
        }

        .lang-btn:not(.is-active):hover { 
            color: var(--ink);
        }

        /* Theme toggle + mobile sidebar trigger share this circular-icon style */
        #themeToggle, .sidebar-open-trigger {
            width: 44px; 
            height: 44px; 
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: linear-gradient(135deg, #fff 0%, #f9f7f2 100%);
            color: var(--ink);
            display: inline-flex; 
            align-items: center; 
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-soft);
            transition: box-shadow .2s var(--ease-smooth), transform .15s var(--ease-smooth), background .2s var(--ease-smooth), border-color .2s var(--ease-smooth);
            font-size: 1.2rem;
            will-change: transform;
        }

        #themeToggle:hover, .sidebar-open-trigger:hover { 
            box-shadow: 0 10px 24px rgba(176,141,87,.25);
            background: linear-gradient(135deg, #fff 0%, #fffbf7 100%);
            border-color: var(--brass);
            transform: translateY(-2px);
        }

        #themeToggle:active, .sidebar-open-trigger:active {
            transform: translateY(0px) scale(.95);
        }

        #themeToggle.spin { 
            animation: toggleSpin .6s var(--ease-smooth);
        }

        /* ---------- Animations ---------- */
        @keyframes fadeIn { 
            from { opacity: 0; } 
            to { opacity: 1; } 
        }

        @keyframes fadeSlideUp { 
            from { 
                opacity: 0; 
                transform: translateY(16px); 
            } 
            to { 
                opacity: 1; 
                transform: translateY(0); 
            } 
        }

        @keyframes slideInLeft { 
            from { 
                opacity: 0; 
                transform: translateX(-20px); 
            } 
            to { 
                opacity: 1; 
                transform: translateX(0); 
            } 
        }

        @keyframes drawSeal { 
            to { stroke-dashoffset: 0; } 
        }

        @keyframes toggleSpin { 
            0% { 
                transform: rotate(0deg) scale(.8);
                opacity: 0;
            }
            50% {
                transform: rotate(180deg) scale(1.05);
            }
            100% { 
                transform: rotate(360deg) scale(1);
                opacity: 1;
            } 
        }

        /* ---------- Dark mode ---------- */
        .dark-mode body { 
            background: #0B1220; 
            color: #E4E8F0; 
        }

        .dark-mode body::before { 
            opacity: .9;
            box-shadow: 0 4px 16px rgba(216,188,133,.2);
        }

        .dark-mode .content-panel { 
            background: #0B1220;
        }

        .dark-mode .nav-panel {
            box-shadow: 2px 0 16px rgba(0,0,0,.25);
        }

        .dark-mode .page-card { 
            background: #101A2C; 
            box-shadow: 0 20px 46px rgba(0,0,0,.3);
            border: 1px solid #1C2A44;
        }

        .dark-mode .dashboard-card, 
        .dark-mode .section-block { 
            background: #0E1728; 
            border-color: #1C2A44; 
            color: #E4E8F0; 
        }

        .dark-mode .dashboard-card:hover, 
        .dark-mode .section-block:hover { 
            background: #121F35;
            border-color: var(--brass); 
            box-shadow: 0 16px 32px rgba(176,141,87,.15);
        }

        .dark-mode .page-header h2 { 
            color: #F3EFE3; 
        }

        .dark-mode .lang-pill { 
            background: rgba(216,188,133,.08); 
            border-color: #1C2A44;
        }

        .dark-mode .lang-btn:not(.is-active) { 
            color: #7C8AA0;
        }

        .dark-mode .lang-btn:not(.is-active):hover { 
            color: #E4E8F0; 
        }

        .dark-mode #themeToggle, 
        .dark-mode .sidebar-open-trigger { 
            background: linear-gradient(135deg, #101A2C 0%, #0E1728 100%);
            color: #E4E8F0; 
            border-color: #1C2A44;
            box-shadow: 0 10px 22px rgba(0,0,0,.2);
        }

        .dark-mode #themeToggle:hover, 
        .dark-mode .sidebar-open-trigger:hover {
            box-shadow: 0 12px 28px rgba(176,141,87,.2);
        }

        .dark-mode .sidebar-toggle { 
            background: linear-gradient(135deg, #101A2C 0%, #0E1728 100%);
            color: #E4E8F0; 
            border-color: #1C2A44;
            box-shadow: 0 6px 18px rgba(0,0,0,.2);
        }

        .dark-mode .sidebar-toggle:hover {
            box-shadow: 0 12px 28px rgba(176,141,87,.2);
        }

        .dark-mode .nav-tooltip { 
            background: #1C2A44;
            border: 1px solid rgba(216,188,133,.15);
        }

        .dark-mode .nav-tooltip::before { 
            background: #1C2A44;
        }

        /* ---------- Responsive: sidebar becomes an off-canvas drawer ---------- */
        @media (max-width: 880px) {
            .layout-shell { grid-template-columns: 1fr; }
            html.sidebar-collapsed .layout-shell { grid-template-columns: 1fr; }

            .sidebar-toggle { display: none; }

            .sidebar-open-trigger { display: inline-flex; }

            .nav-panel {
                position: fixed;
                top: 0; 
                left: 0; 
                bottom: 0;
                width: min(280px, 82vw);
                z-index: 56;
                height: auto;
                max-height: 100vh;
                transform: translateX(-100%);
                transition: transform .35s var(--ease-smooth);
                box-shadow: 4px 0 40px rgba(0,0,0,.35);
                border-radius: 0;
            }

            html.sidebar-open .nav-panel { 
                transform: translateX(0); 
            }

            html.sidebar-open .sidebar-backdrop { 
                display: block; 
                opacity: 1; 
            }

            html.sidebar-collapsed .nav-panel { 
                padding: 28px 22px; 
            }

            html.sidebar-collapsed .brand-copy,
            html.sidebar-collapsed .nav-panel nav a span:not(.nav-tooltip),
            html.sidebar-collapsed .btn-logout span:not(.nav-tooltip) {
                opacity: 1; 
                max-width: 200px; 
                margin: 0;
            }

            html.sidebar-collapsed .nav-panel nav a { 
                justify-content: flex-start; 
                padding-left: 1.1rem; 
                gap: .7rem; 
            }

            .content-panel { 
                padding: 24px 18px;
            }

            .page-card {
                border-radius: 14px;
                padding: 20px;
            }

            .page-header {
                margin-bottom: 20px;
            }

            .page-header h2 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 640px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h2 {
                font-size: 1.5rem;
                width: 100%;
            }

            .content-panel { 
                padding: 16px 12px;
            }

            .page-card {
                padding: 16px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .001ms !important;
            }
            .seal circle, .seal path, .seal .seal-letter { stroke-dashoffset: 0 !important; }
        }

        /* Portal grid and table styles */
        .portal-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
            gap: 16px; 
            margin-top: 20px; 
        }

        .portal-card { 
            background: var(--card-bg); 
            border: 1.5px solid var(--border); 
            border-radius: 14px; 
            padding: 18px; 
            box-shadow: var(--shadow-soft);
            transition: transform .3s var(--ease-smooth), box-shadow .3s var(--ease-smooth), border-color .3s var(--ease-smooth);
        }

        .portal-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow);
            border-color: var(--brass);
        }

        .portal-card h3 { 
            margin: 0 0 8px; 
            color: var(--ink); 
            font-size: 1rem; 
            font-weight: 600;
        }

        .portal-card p, .portal-card span, .portal-card small { 
            color: #64748b; 
            line-height: 1.6; 
        }

        .portal-card strong { 
            display: block; 
            color: var(--ink); 
            font-size: 1.6rem;
            margin-top: 8px;
        }

        .portal-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 18px;
        }

        .portal-table th, .portal-table td { 
            padding: 12px; 
            border-bottom: 1px solid #e5e7eb; 
            text-align: left; 
            white-space: nowrap; 
        }

        .portal-table th { 
            color: #64748b; 
            background: #f8fafc; 
            font-size: .75rem; 
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: .05em;
        }

        .portal-table td { 
            color: #334155; 
        }

        .portal-table select, 
        .portal-table input, 
        .page-card input[type=date] { 
            padding: 9px; 
            border: 1.5px solid #cbd5e1; 
            border-radius: 8px; 
            background: #fff;
            transition: border-color .2s var(--ease-smooth), box-shadow .2s var(--ease-smooth);
            font-family: var(--font-body);
        }

        .portal-table select:focus, 
        .portal-table input:focus, 
        .page-card input[type=date]:focus {
            outline: none;
            border-color: var(--brass);
            box-shadow: 0 0 0 3px rgba(176,141,87,.1);
        }
    </style>
</head>
<body>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="layout-shell">
    <aside class="nav-panel" id="navPanel">
        <button class="sidebar-toggle" id="sidebarToggle" type="button" aria-label="Collapse sidebar" aria-expanded="true">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <div class="brand-mark">
            <img class="seal" src="<?php echo e(asset('image/hello.png')); ?>" alt="SkillUp logo">
            <div class="brand-copy">
                <span class="eyebrow"><?php echo e(__('sias.faculty_access')); ?></span>
                <h1><span data-i18n="teacher_portal">SIAS Teacher</span></h1>
            </div>
        </div>
        <nav>
            <a href="<?php echo e(url('/sias/teacher/dashboard')); ?>" class="<?php echo e(request()->is('sias/teacher/dashboard') ? 'active' : ''); ?>">
                <i class="fa-solid fa-gauge"></i> <span data-i18n="dashboard">Dashboard</span>
                <span class="nav-tooltip" data-i18n="dashboard">Dashboard</span>
            </a>
            <a href="<?php echo e(route('sias.teacher.programs')); ?>" class="<?php echo e(request()->is('sias/teacher/programs*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-graduation-cap"></i> <span><?php echo e(__('sias.my_training_programs')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.my_training_programs')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.classes')); ?>" class="<?php echo e(request()->is('sias/teacher/classes*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-users-rectangle"></i> <span><?php echo e(__('sias.my_classes_batches')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.my_classes_batches')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.trainees')); ?>" class="<?php echo e(request()->is('sias/teacher/trainees*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-user-group"></i> <span><?php echo e(__('sias.trainees')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.trainees')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.schedule')); ?>" class="<?php echo e(request()->is('sias/teacher/schedule*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-calendar-days"></i> <span><?php echo e(__('sias.training_schedule')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.training_schedule')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.attendance')); ?>" class="<?php echo e(request()->is('sias/teacher/attendance*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-calendar-check"></i> <span><?php echo e(__('sias.attendance')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.attendance')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.competency')); ?>" class="<?php echo e(request()->is('sias/teacher/competency*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-layer-group"></i> <span><?php echo e(__('sias.competency_modules')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.competency_modules')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.assessments')); ?>" class="<?php echo e(request()->is('sias/teacher/assessments*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-clipboard-check"></i> <span><?php echo e(__('sias.assessment')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.assessment')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.materials')); ?>" class="<?php echo e(request()->is('sias/teacher/materials*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-folder-open"></i> <span><?php echo e(__('sias.learning_materials')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.learning_materials')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.progress')); ?>" class="<?php echo e(request()->is('sias/teacher/progress*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-chart-line"></i> <span><?php echo e(__('sias.trainee_progress')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.trainee_progress')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.reports')); ?>" class="<?php echo e(request()->is('sias/teacher/reports*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-chart-column"></i> <span><?php echo e(__('sias.reports')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.reports')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.announcements')); ?>" class="<?php echo e(request()->is('sias/teacher/announcements*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-bullhorn"></i> <span><?php echo e(__('sias.announcements')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.announcements')); ?></span>
            </a>
            <a href="<?php echo e(url('/sias/teacher/profile')); ?>" class="<?php echo e(request()->is('sias/teacher/profile') ? 'active' : ''); ?>">
                <i class="fa-solid fa-user"></i> <span><?php echo e(__('sias.trainer_profile')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.trainer_profile')); ?></span>
            </a>
            <a href="<?php echo e(route('sias.teacher.settings')); ?>" class="<?php echo e(request()->is('sias/teacher/settings*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-gear"></i> <span><?php echo e(__('sias.teacher_settings')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.teacher_settings')); ?></span>
            </a>
        </nav>
        <div class="nav-divider"></div>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span><?php echo e(__('sias.sign_out')); ?></span>
                <span class="nav-tooltip"><?php echo e(__('sias.sign_out')); ?></span>
            </button>
        </form>
    </aside>
    <main class="content-panel">
        <div class="page-header">
            <h2>
                <button class="sidebar-open-trigger" id="sidebarOpenTrigger" type="button" aria-label="Open sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <?php echo $__env->yieldContent('page_title', 'Teacher'); ?>
            </h2>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <div class="lang-pill">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['en' => 'EN', 'tl' => 'TL']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <form method="GET" action="<?php echo e(route('language.switch', $code)); ?>" style="margin:0;display:inline-flex;">
                            <button type="submit" class="lang-btn <?php echo e(app()->getLocale() === $code ? 'is-active' : ''); ?>"><?php echo e($label); ?></button>
                        </form>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php if (! empty(trim($__env->yieldContent('header_actions')))): ?>
                    <?php echo $__env->yieldContent('header_actions'); ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button id="themeToggle" type="button" aria-label="Toggle theme" aria-pressed="false">
                    <span class="icon">🌙</span>
                </button>
            </div>
        </div>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
<script>
    (function(){
        var html = document.documentElement;
        var systemTheme = window.matchMedia('(prefers-color-scheme: dark)');

        window.siasApplyTheme = function(theme, persist) {
            var isDark = theme === 'dark' || (theme === 'system' && systemTheme.matches);
            html.classList.toggle('dark-mode', isDark);
            html.dataset.theme = theme;
            if (persist) {
                if (theme === 'system') localStorage.removeItem('sias-theme');
                else localStorage.setItem('sias-theme', theme);
            }
            var themeBtn = document.getElementById('themeToggle');
            if (themeBtn) {
                var icon = themeBtn.querySelector('.icon');
                if (icon) icon.textContent = isDark ? '☀️' : '🌙';
                themeBtn.setAttribute('aria-pressed', String(isDark));
            }
        };

        systemTheme.addEventListener('change', function() {
            if (html.dataset.theme === 'system') window.siasApplyTheme('system', false);
        });

        var themeBtn = document.getElementById('themeToggle');
        if (themeBtn) {
            var icon = themeBtn.querySelector('.icon');

            function reflectTheme(isDark){
                icon.textContent = isDark ? '☀️' : '🌙';
                themeBtn.setAttribute('aria-pressed', String(isDark));
            }

            window.siasApplyTheme(html.dataset.theme || 'system', false);

            themeBtn.addEventListener('click', function(){
                var isDark = !html.classList.contains('dark-mode');
                window.siasApplyTheme(isDark ? 'dark' : 'light', true);

                themeBtn.classList.remove('spin'); 
                void themeBtn.offsetWidth; 
                themeBtn.classList.add('spin');
            });
        }
    })();

    (function(){
        var html = document.documentElement;
        var collapseBtn = document.getElementById('sidebarToggle');
        var openTrigger = document.getElementById('sidebarOpenTrigger');
        var backdrop = document.getElementById('sidebarBackdrop');
        var navPanel = document.getElementById('navPanel');
        var mq = window.matchMedia('(max-width: 880px)');

        function isMobile(){ return mq.matches; }

        // Desktop: permanent collapse/expand, persisted across visits.
        function reflectCollapsed(isCollapsed){
            if (!collapseBtn) return;
            collapseBtn.setAttribute('aria-expanded', String(!isCollapsed));
            collapseBtn.setAttribute('aria-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
        }
        reflectCollapsed(html.classList.contains('sidebar-collapsed'));

        if (collapseBtn) {
            collapseBtn.addEventListener('click', function(){
                if (isMobile()) {
                    return;
                }
                var isCollapsed = !html.classList.contains('sidebar-collapsed');
                html.classList.toggle('sidebar-collapsed', isCollapsed);
                localStorage.setItem('sias-sidebar', isCollapsed ? 'collapsed' : 'expanded');
                reflectCollapsed(isCollapsed);
            });
        }

        // Mobile: off-canvas drawer, opened/closed per-interaction (not persisted).
        function openMobileSidebar(){
            html.classList.add('sidebar-open');
            if (openTrigger) openTrigger.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }
        function closeMobileSidebar(){
            html.classList.remove('sidebar-open');
            if (openTrigger) openTrigger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        if (openTrigger) {
            openTrigger.addEventListener('click', function(){
                if (html.classList.contains('sidebar-open')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            });
        }
        if (backdrop) backdrop.addEventListener('click', closeMobileSidebar);

        // Close the drawer after navigating (nav links live inside the same panel).
        if (navPanel) {
            navPanel.querySelectorAll('nav a').forEach(function(link){
                link.addEventListener('click', function(){
                    if (isMobile()) closeMobileSidebar();
                });
            });
        }

        // Escape key closes the mobile drawer.
        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape' && html.classList.contains('sidebar-open')) closeMobileSidebar();
        });

        // If the viewport crosses the breakpoint while the drawer is open, reset state.
        mq.addEventListener('change', function(){
            closeMobileSidebar();
        });
    })();
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\layout\layout.blade.php ENDPATH**/ ?>