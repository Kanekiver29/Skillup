<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="chats-notifications" content="{{ route('chats.notifications') }}">
    @endauth
    <title>@yield('title', 'SkillUp')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel ="icon" href="{{ asset('image/logo_oif_skillup_1_-removebg-preview.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #0046ff;
            --primary-light: #3b7dff;
            --dark-navy: #060c1a;
            --void: #020509;
            --accent-red: #ff2f52;
            --accent-gold: #fdb913;
            --accent-cyan: #00e6ff;
            --accent-cyan-dim: rgba(0, 230, 255, 0.28);
            --accent-violet: #7c5cff;
            --light-bg: #f4f6f9;
            --text-dark: #1f2937;
            --hud-line: rgba(0, 230, 255, 0.22);
            --header-ease: cubic-bezier(0.22, 1, 0.36, 1);
            --footer-ease: cubic-bezier(0.22, 1, 0.36, 1);
            --elastic-ease: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        html { scroll-behavior: smooth; }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }

        body { font-family: 'Inter', system-ui, sans-serif; position: relative; }
        .font-display { font-family: 'Sora', 'Inter', system-ui, sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', ui-monospace, monospace; }

        ::selection { background: rgba(0, 230, 255, 0.35); color: #04121f; }

        /* Global slim scrollbar, futuristic cyan */
        html { scrollbar-width: thin; scrollbar-color: rgba(0,70,255,0.55) rgba(244,246,249,0.4); }
        ::-webkit-scrollbar { width: 10px; height: 10px; }
        ::-webkit-scrollbar-track { background: rgba(148,163,184,0.12); }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--accent-cyan), var(--primary));
            border-radius: 9999px;
            border: 2px solid rgba(244,246,249,0.6);
        }
        ::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #7bf3ff, var(--primary-light)); }

        .gradient-primary { background: linear-gradient(135deg, var(--primary) 0%, var(--dark-navy) 100%); }
        .gradient-secondary { background: linear-gradient(135deg, var(--accent-red) 0%, var(--dark-navy) 100%); }
        .bg-light-background { background-color: var(--light-bg); }
        .text-dark { color: var(--text-dark); }
        .card-hover { transition: transform 0.35s var(--header-ease), box-shadow 0.35s var(--header-ease); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .animate-fade-in { animation: fadeIn 1s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }

        /* Reusable futuristic surface utilities available to child pages */
        .glass-panel {
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 70, 255, 0.10);
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
        }
        .glass-panel-dark {
            background: rgba(6, 12, 26, 0.72);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 230, 255, 0.14);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.35);
        }
        .neon-outline {
            position: relative;
            border: 1px solid rgba(0, 230, 255, 0.35);
            box-shadow: 0 0 0 1px rgba(0,230,255,0.08) inset, 0 0 24px rgba(0,230,255,0.12);
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        [tabindex]:focus-visible {
            outline: 2px solid var(--accent-cyan);
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* ══════════════════════════════════════
           PAGE LOAD PROGRESS BAR
        ══════════════════════════════════════ */
        #page-progress {
            position: fixed;
            top: 0; left: 0;
            height: 2.5px;
            width: 0%;
            z-index: 100;
            background: linear-gradient(90deg, var(--accent-cyan), var(--primary-light), var(--accent-gold));
            box-shadow: 0 0 12px rgba(0,230,255,0.8), 0 0 4px rgba(0,230,255,0.9);
            transition: width 0.4s var(--header-ease), opacity 0.5s ease 0.2s;
        }
        #page-progress.is-done { opacity: 0; }

        /* ══════════════════════════════════════
           AMBIENT CURSOR SPOTLIGHT (desktop only)
        ══════════════════════════════════════ */
        #cursor-glow {
            position: fixed;
            top: 0; left: 0;
            width: 480px; height: 480px;
            margin-left: -240px; margin-top: -240px;
            border-radius: 9999px;
            background: radial-gradient(circle, rgba(0,230,255,0.05) 0%, rgba(0,70,255,0.03) 40%, transparent 70%);
            pointer-events: none;
            z-index: 1;
            opacity: 0;
            transition: opacity 0.6s ease;
            will-change: transform;
        }
        #cursor-glow.is-active { opacity: 1; }
        @media (max-width: 1023px), (hover: none) {
            #cursor-glow { display: none; }
        }
        @media (prefers-reduced-motion: reduce) {
            #cursor-glow { display: none; }
        }

        /* ══════════════════════════════════════
           HUD GRID / CIRCUIT SURFACES (shared)
        ══════════════════════════════════════ */
        .hud-grid {
            background-image:
                linear-gradient(var(--hud-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--hud-line) 1px, transparent 1px);
            background-size: 34px 34px;
            -webkit-mask-image: linear-gradient(180deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.15) 75%, transparent 100%);
            mask-image: linear-gradient(180deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.15) 75%, transparent 100%);
            opacity: 0.35;
        }

        .hud-corner {
            position: absolute;
            width: 9px;
            height: 9px;
            border: 1.5px solid var(--accent-cyan);
            opacity: 0.55;
            transition: opacity 0.3s ease, border-color 0.3s ease;
        }
        .hud-corner.tl { top: -4px; left: -4px; border-right: none; border-bottom: none; }
        .hud-corner.tr { top: -4px; right: -4px; border-left: none; border-bottom: none; }
        .hud-corner.bl { bottom: -4px; left: -4px; border-right: none; border-top: none; }
        .hud-corner.br { bottom: -4px; right: -4px; border-left: none; border-top: none; }

        .hud-eyebrow {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 10px;
            letter-spacing: 0.28em;
            text-transform: uppercase;
        }
        .hud-eyebrow::before { content: '['; margin-right: 5px; opacity: 0.6; }
        .hud-eyebrow::after  { content: ']'; margin-left: 5px; opacity: 0.6; }

        /* ══════════════════════════════════════
           STATUS TICKER STRIP (top of header)
        ══════════════════════════════════════ */
        .status-strip {
            background: linear-gradient(90deg, rgba(0,58,143,0.55), rgba(2,5,9,0.75) 45%, rgba(0,58,143,0.55));
            border-bottom: 1px solid rgba(0,230,255,0.12);
            overflow: hidden;
            height: 28px;
            position: relative;
        }
        .status-strip::before,
        .status-strip::after {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            width: 40px;
            z-index: 2;
            pointer-events: none;
        }
        .status-strip::before { left: 0; background: linear-gradient(90deg, rgba(3,8,18,0.95), transparent); }
        .status-strip::after  { right: 0; background: linear-gradient(270deg, rgba(3,8,18,0.95), transparent); }
        .status-track {
            display: flex;
            align-items: center;
            gap: 2.75rem;
            white-space: nowrap;
            width: max-content;
            animation: statusScroll 26s linear infinite;
            padding-left: 1rem;
        }
        .status-strip:hover .status-track { animation-play-state: paused; }
        @keyframes statusScroll {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        .status-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 10.5px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(203,213,225,0.75);
        }
        .status-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--accent-cyan);
            box-shadow: 0 0 6px rgba(0,230,255,0.9);
            flex-shrink: 0;
            animation: subDotPulse 2.4s ease-in-out infinite;
        }
        .status-item.gold .status-dot { background: var(--accent-gold); box-shadow: 0 0 6px rgba(253,185,19,0.9); }
        .status-item.red .status-dot { background: var(--accent-red); box-shadow: 0 0 6px rgba(255,47,82,0.9); }

        /* ══════════════════════════════════════
           LOGO & BRAND ANIMATIONS
        ══════════════════════════════════════ */

        /* Outer spinning conic ring — activates on hover */
        .logo-ring {
            position: absolute;
            inset: -7px;
            border-radius: 50%;
            border: 1.5px solid transparent;
            background: conic-gradient(
                from 0deg,
                rgba(0,230,255,0.9)   0%,
                rgba(253,185,19,0.55) 30%,
                rgba(193,18,31,0.5)   55%,
                rgba(0,58,143,0.65)   80%,
                rgba(0,230,255,0.9)   100%
            ) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            opacity: 0;
            animation: logoRingSpin 3s linear infinite paused;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }
        @keyframes logoRingSpin { to { transform: rotate(360deg); } }

        /* Targeting reticle ticks around the icon */
        .logo-reticle {
            position: absolute;
            inset: -11px;
            border-radius: 50%;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .logo-reticle span {
            position: absolute;
            background: var(--accent-cyan);
            box-shadow: 0 0 6px rgba(0,230,255,0.9);
        }
        .logo-reticle span:nth-child(1) { top: 0; left: 50%; width: 1.5px; height: 5px; transform: translateX(-50%); }
        .logo-reticle span:nth-child(2) { bottom: 0; left: 50%; width: 1.5px; height: 5px; transform: translateX(-50%); }
        .logo-reticle span:nth-child(3) { left: 0; top: 50%; height: 1.5px; width: 5px; transform: translateY(-50%); }
        .logo-reticle span:nth-child(4) { right: 0; top: 50%; height: 1.5px; width: 5px; transform: translateY(-50%); }
        .header-brand:hover .logo-reticle { opacity: 1; animation: logoRingSpin 6s linear infinite; }

        /* Main icon box */
        .header-brand-icon {
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.13) 0%, rgba(255,255,255,0.04) 100%);
            border: 1px solid rgba(0,230,255,0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: transform 0.5s var(--header-ease), box-shadow 0.5s ease, background 0.4s ease;
            animation: rocketFloat 3.5s ease-in-out infinite;
            box-shadow: 0 4px 24px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.08), 0 0 0 rgba(0,230,255,0);
        }

        /* Shimmer sweep across icon box */
        .header-brand-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(130deg, transparent 30%, rgba(0,230,255,0.18) 50%, transparent 70%);
            transform: translateX(-100%);
            pointer-events: none;
        }

        @keyframes rocketFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            30%       { transform: translateY(-4px) rotate(-2deg); }
            60%       { transform: translateY(-2px) rotate(1deg); }
        }

        /* Hover states */
        .header-brand:hover .logo-ring {
            opacity: 1;
            animation-play-state: running;
        }
        .header-brand:hover .header-brand-icon {
            animation: none;
            transform: translateY(-3px) rotate(-8deg) scale(1.08);
            box-shadow: 0 14px 40px rgba(0,230,255,0.4), 0 4px 16px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.15);
            background: linear-gradient(135deg, rgba(255,255,255,0.22) 0%, rgba(0,58,143,0.28) 100%);
        }
        .header-brand:hover .header-brand-icon::before {
            animation: iconShimmer 0.65s ease forwards;
        }
        @keyframes iconShimmer {
            from { transform: translateX(-100%); }
            to   { transform: translateX(160%); }
        }

        /* Gold sparkle star badge */
        .logo-sparkle {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 14px;
            height: 14px;
            pointer-events: none;
            animation: sparklePop 3s ease-in-out infinite;
            z-index: 2;
        }
        @keyframes sparklePop {
            0%, 100% { opacity: 0; transform: scale(0.4) rotate(0deg); }
            15%       { opacity: 1; transform: scale(1.3) rotate(22deg); }
            35%       { opacity: 0.7; transform: scale(0.9) rotate(10deg); }
            50%       { opacity: 0; transform: scale(0.3) rotate(0deg); }
        }

        /* Rocket exhaust flame */
        .rocket-flame {
            animation: flameFlicker 0.16s ease-in-out infinite alternate;
            transform-origin: 50% 85%;
        }
        @keyframes flameFlicker {
            from { transform: scaleY(1) scaleX(1); opacity: 1; }
            to   { transform: scaleY(0.72) scaleX(0.82); opacity: 0.65; }
        }

        /* Wordmark */
        .logo-wordmark-primary {
            font-family: 'Sora', 'Inter', system-ui, sans-serif;
            font-size: 19px;
            font-weight: 800;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            color: #ffffff;
            line-height: 1;
            position: relative;
            overflow: hidden;
            text-shadow: 0 0 40px rgba(0,230,255,0.35);
        }
        /* Gold shimmer pass */
        .logo-wordmark-primary::after {
            content: 'SkillUp';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(0,230,255,0.95) 38%,
                rgba(200,245,255,1)  50%,
                rgba(0,230,255,0.95) 62%,
                transparent 100%);
            background-size: 260% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: wordmarkShimmer 4s ease-in-out infinite;
            pointer-events: none;
        }
        @keyframes wordmarkShimmer {
            0%, 65%  { background-position: 200% center; opacity: 0; }
            35%       { background-position: -60% center; opacity: 1; }
            50%       { background-position: -120% center; opacity: 0; }
        }

        .logo-wordmark-sub {
            font-size: 9px;
            letter-spacing: 0.34em;
            text-transform: uppercase;
            color: rgba(148,163,184,0.75);
            font-weight: 500;
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .logo-sub-dot {
            display: inline-block;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--accent-cyan);
            box-shadow: 0 0 5px rgba(0,230,255,0.9);
            animation: subDotPulse 3.5s ease-in-out infinite;
            flex-shrink: 0;
        }
        @keyframes subDotPulse {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50%       { opacity: 1; transform: scale(1.7); }
        }

        /* Particle trails (JS-spawned) */
        .logo-particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0;
            pointer-events: none;
            animation: particleDrift var(--pdur, 2.2s) ease-in infinite var(--pdel, 0s);
        }
        @keyframes particleDrift {
            0%   { opacity: 0; transform: translate(0,0) scale(0); }
            20%  { opacity: 0.9; }
            100% { opacity: 0; transform: translate(var(--px,12px), var(--py,-12px)) scale(0.15); }
        }

        /* ══════════════════════════════════════
           HEADER / NAV
        ══════════════════════════════════════ */

        .site-header {
            background: rgba(6, 12, 26, 0.86);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid rgba(0, 230, 255, 0.14);
            transition: background 0.4s var(--header-ease), box-shadow 0.4s var(--header-ease), border-color 0.4s var(--header-ease);
            animation: headerEnter 0.7s var(--header-ease) forwards;
            position: relative;
            isolation: isolate;
        }
        @keyframes headerEnter {
            from { opacity: 0; transform: translateY(-100%); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .site-header.is-scrolled {
            background: rgba(3, 8, 18, 0.97);
            border-color: rgba(0, 230, 255, 0.28);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3), 0 1px 0 rgba(0,230,255,0.15);
        }
        .site-header.is-scrolled .status-strip {
            height: 0;
            border-bottom-width: 0;
        }
        .status-strip { transition: height 0.35s var(--header-ease), border-color 0.35s ease; }

        /* HUD grid backdrop inside header */
        .site-header .header-hud-grid {
            position: absolute;
            inset: 0;
            z-index: -1;
            pointer-events: none;
        }

        /* Animated gradient hairline + scan sweep along header bottom */
        .header-scanline {
            position: absolute;
            left: 0; right: 0; bottom: -1px;
            height: 1px;
            overflow: hidden;
            pointer-events: none;
        }
        .header-scanline::before {
            content: '';
            position: absolute;
            top: 0; bottom: 0;
            width: 40%;
            background: linear-gradient(90deg, transparent, rgba(0,230,255,0.9), rgba(253,185,19,0.6), transparent);
            animation: scanSweep 5.5s linear infinite;
        }
        @keyframes scanSweep {
            0%   { left: -40%; }
            100% { left: 100%; }
        }

        .site-header-bar {
            height: 5rem;
            transition: height 0.35s var(--header-ease);
        }
        .site-header.is-scrolled .site-header-bar {
            height: 4.25rem;
        }

        .nav-link {
            position: relative;
            padding-bottom: 0.25rem;
            color: rgba(226, 232, 240, 0.85);
            transition: color 0.25s ease, transform 0.25s var(--header-ease);
        }
        .nav-link::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -0.35rem;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-gold));
            border-radius: 2px;
            box-shadow: 0 0 8px rgba(0,230,255,0.7);
            transform: translateX(-50%);
            transition: width 0.35s var(--header-ease);
        }
        .nav-link:hover { color: #fff; transform: translateY(-1px); }
        .nav-link:hover::after,
        .nav-link.active::after { width: 100%; }
        .nav-link.active { color: #fff; }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 50%;
            top: -0.85rem;
            width: 4px; height: 4px;
            transform: translateX(-50%);
            border-radius: 50%;
            background: var(--accent-cyan);
            box-shadow: 0 0 8px rgba(0,230,255,0.9);
        }

        .header-search {
            position: relative;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        .header-search:focus-within {
            border-color: rgba(0, 230, 255, 0.55);
            background: rgba(2, 8, 18, 0.6);
            box-shadow: 0 0 0 3px rgba(0, 230, 255, 0.14), 0 0 18px rgba(0,230,255,0.15);
        }
        .header-search:focus-within .header-search-icon {
            color: var(--accent-cyan);
            transform: scale(1.1);
        }
        .header-search-icon {
            transition: color 0.25s ease, transform 0.25s var(--header-ease);
        }
        .header-search kbd {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 10px;
            color: rgba(148,163,184,0.7);
            border: 1px solid rgba(148,163,184,0.3);
            border-radius: 5px;
            padding: 1px 6px;
            line-height: 1.5;
            background: rgba(255,255,255,0.03);
        }

        .header-action-btn {
            transition: transform 0.22s var(--header-ease), background 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        }
        .header-action-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2), 0 0 0 1px rgba(0,230,255,0.25); }
        .header-action-btn:active { transform: translateY(0) scale(0.98); }

        .header-login-btn {
            background: linear-gradient(135deg, #003a8f 0%, #0a2540 100%);
            border: 1px solid rgba(0, 230, 255, 0.28);
        }
        .header-login-btn:hover {
            background: linear-gradient(135deg, #1e4976 0%, #003a8f 100%);
            border-color: rgba(0, 230, 255, 0.5);
        }
        .header-signup-btn {
            background: #fff;
            color: #0a2540;
            position: relative;
            overflow: hidden;
        }
        .header-signup-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(0,230,255,0.35) 50%, transparent 70%);
            transform: translateX(-120%);
            transition: transform 0.6s ease;
        }
        .header-signup-btn:hover::before { transform: translateX(120%); }
        .header-signup-btn:hover { background: #fff; color: #003a8f; }

        /* Ripple micro-interaction for CTA buttons */
        .btn-ripple { position: relative; overflow: hidden; }
        .btn-ripple .ripple-circle {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            background: rgba(0,230,255,0.45);
            pointer-events: none;
            animation: rippleGrow 0.65s ease-out forwards;
        }
        @keyframes rippleGrow {
            to { transform: scale(2.6); opacity: 0; }
        }

        .header-menu-chevron { transition: transform 0.3s var(--header-ease); }
        .header-user-menu.is-open .header-menu-chevron { transform: rotate(180deg); }

        .header-dropdown {
            z-index: 80;
            transform-origin: top right;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(-8px) scale(0.97);
            transition: opacity 0.25s var(--header-ease), transform 0.25s var(--header-ease), visibility 0.25s;
        }
        .header-dropdown.is-open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .header-user-menu.is-open { z-index: 70; }
        .header-dropdown a,
        .header-dropdown button {
            transition: background 0.2s ease, padding-left 0.2s var(--header-ease);
        }
        .header-dropdown a:hover,
        .header-dropdown button:hover { padding-left: 1.35rem; }

        .header-nav-toggle {
            transition: transform 0.3s var(--header-ease), background 0.25s ease;
        }
        .header-nav-toggle:hover { transform: scale(1.05); background: rgba(0,230,255,0.08); }
        .header-nav-toggle.is-active { transform: rotate(90deg); }

        .mobile-nav-panel {
            position: relative;
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.45s var(--header-ease), opacity 0.35s ease;
        }
        .mobile-nav-panel.is-open { max-height: 85vh; opacity: 1; overflow-y: auto; }

        .mobile-nav-link {
            opacity: 0;
            transform: translateX(-16px);
            transition: opacity 0.35s var(--header-ease), transform 0.35s var(--header-ease), background 0.25s ease, border-color 0.25s ease;
        }
        .mobile-nav-panel.is-open .mobile-nav-link { opacity: 1; transform: translateX(0); }
        .mobile-nav-panel.is-open .mobile-nav-link:nth-child(1) { transition-delay: 50ms; }
        .mobile-nav-panel.is-open .mobile-nav-link:nth-child(2) { transition-delay: 100ms; }
        .mobile-nav-panel.is-open .mobile-nav-link:nth-child(3) { transition-delay: 150ms; }
        .mobile-nav-panel.is-open .mobile-nav-link:nth-child(4) { transition-delay: 200ms; }
        .mobile-nav-panel.is-open .mobile-nav-link:nth-child(5) { transition-delay: 250ms; }
        .mobile-nav-panel.is-open .mobile-nav-link:nth-child(6) { transition-delay: 300ms; }
        .mobile-nav-panel.is-open .mobile-nav-link:nth-child(7) { transition-delay: 350ms; }
        .mobile-nav-link.active {
            border-color: rgba(0, 230, 255, 0.5);
            background: rgba(0, 58, 143, 0.35);
            color: #fff;
        }
        .mobile-nav-link:active { transform: translateX(0) scale(0.98); }

        /* ══════════════════════════════════════
           BACK TO TOP BUTTON
        ══════════════════════════════════════ */
        #back-to-top {
            position: fixed;
            bottom: 6.25rem;
            right: 1.5rem;
            z-index: 45;
            width: 3rem; height: 3rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(6,12,26,0.9);
            color: #fff;
            border: 1px solid rgba(0,230,255,0.35);
            box-shadow: 0 10px 28px rgba(0,0,0,0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(12px) scale(0.9);
            transition: opacity 0.3s var(--header-ease), transform 0.3s var(--header-ease), visibility 0.3s, border-color 0.25s ease, box-shadow 0.25s ease;
        }
        #back-to-top.is-visible { opacity: 1; visibility: visible; transform: translateY(0) scale(1); }
        #back-to-top:hover { border-color: rgba(0,230,255,0.7); box-shadow: 0 10px 28px rgba(0,230,255,0.28); transform: translateY(-3px) scale(1.04); }
        #back-to-top i { animation: backToTopBob 2.2s ease-in-out infinite; }
        @keyframes backToTopBob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-3px); } }

        /* ══════════════════════════════════════
           TOAST NOTIFICATIONS
        ══════════════════════════════════════ */
        #toast-stack {
            position: fixed;
            top: 5.5rem;
            right: 1.25rem;
            z-index: 90;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            pointer-events: none;
            max-width: min(22rem, calc(100vw - 2rem));
        }
        .skillup-toast {
            pointer-events: auto;
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            padding: 0.85rem 1rem;
            border-radius: 14px;
            background: rgba(6,12,26,0.94);
            border: 1px solid rgba(0,230,255,0.25);
            box-shadow: 0 14px 34px rgba(0,0,0,0.35);
            color: #e2e8f0;
            font-size: 0.83rem;
            transform: translateX(120%);
            opacity: 0;
            animation: toastIn 0.45s var(--elastic-ease) forwards;
        }
        .skillup-toast.is-leaving { animation: toastOut 0.35s var(--header-ease) forwards; }
        @keyframes toastIn { to { transform: translateX(0); opacity: 1; } }
        @keyframes toastOut { to { transform: translateX(120%); opacity: 0; } }
        .skillup-toast .toast-icon { flex-shrink: 0; width: 1.5rem; height: 1.5rem; border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; }
        .skillup-toast.success .toast-icon { background: rgba(0,230,255,0.18); color: var(--accent-cyan); }
        .skillup-toast.error .toast-icon { background: rgba(255,47,82,0.18); color: var(--accent-red); }
        .skillup-toast.info .toast-icon { background: rgba(253,185,19,0.18); color: var(--accent-gold); }

        /* ══════════════════════════════════════
           FOOTER
        ══════════════════════════════════════ */

        .site-footer {
            background: linear-gradient(180deg, #0c2038 0%, #060c1a 45%, #020509 100%);
            position: relative;
        }
        .footer-glow {
            background:
                radial-gradient(ellipse 80% 50% at 20% 0%, rgba(0,230,255,0.10), transparent 50%),
                radial-gradient(ellipse 60% 40% at 80% 20%, rgba(253,185,19,0.09), transparent 45%),
                radial-gradient(ellipse 50% 30% at 50% 100%, rgba(0,70,255,0.16), transparent 40%);
        }
        .footer-circuit {
            position: absolute;
            inset: 0;
            opacity: 0.5;
            pointer-events: none;
        }
        .footer-blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(48px);
            opacity: 0.2;
            pointer-events: none;
            animation: footerBlob 14s ease-in-out infinite;
        }
        @keyframes footerBlob {
            0%, 100% { transform: translate(0,0) scale(1); }
            50%       { transform: translate(12px,-16px) scale(1.08); }
        }

        [data-footer-animate] {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.7s var(--footer-ease), transform 0.7s var(--footer-ease);
        }
        [data-footer-animate].footer-visible { opacity: 1; transform: translateY(0); }
        [data-footer-animate].footer-delay-1 { transition-delay: 80ms; }
        [data-footer-animate].footer-delay-2 { transition-delay: 160ms; }
        [data-footer-animate].footer-delay-3 { transition-delay: 240ms; }
        [data-footer-animate].footer-delay-4 { transition-delay: 320ms; }

        .footer-logo-icon {
            position: relative;
            transition: transform 400ms var(--footer-ease), box-shadow 400ms var(--footer-ease);
            animation: rocketFloat 4s ease-in-out infinite;
        }
        .footer-brand:hover .footer-logo-icon {
            transform: rotate(-8deg) scale(1.08);
            box-shadow: 0 8px 24px rgba(0,230,255,0.35);
        }

        .footer-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .footer-eyebrow .eyebrow-rule {
            width: 1.25rem; height: 1px;
            background: linear-gradient(90deg, var(--accent-cyan), transparent);
        }

        .footer-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: color 220ms ease, transform 220ms var(--footer-ease);
        }
        .footer-link::before {
            content: '';
            position: absolute;
            left: 0; bottom: -2px;
            width: 0; height: 1.5px;
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-gold));
            box-shadow: 0 0 6px rgba(0,230,255,0.7);
            transition: width 280ms var(--footer-ease);
        }
        .footer-link:hover { color: #fff; transform: translateX(4px); }
        .footer-link:hover::before { width: 100%; }

        .footer-social {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem; height: 2.5rem;
            border-radius: 9999px;
            border: 1px solid rgba(148,163,184,0.25);
            background: rgba(2,8,18,0.55);
            transition: transform 240ms var(--footer-ease), background 240ms ease, border-color 240ms ease, color 240ms ease, box-shadow 240ms ease;
        }
        .footer-social:hover {
            transform: translateY(-4px) scale(1.08);
            background: rgba(0,70,255,0.4);
            border-color: rgba(0,230,255,0.55);
            color: #fff;
            box-shadow: 0 10px 28px rgba(0,230,255,0.3);
        }

        .footer-stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }
        .footer-stat-num {
            font-family: 'Sora', 'Inter', system-ui, sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: #fff;
            line-height: 1;
            text-shadow: 0 0 24px rgba(0,230,255,0.3);
        }
        .footer-stat-label {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 9.5px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(148,163,184,0.7);
        }

        .footer-tesda-text {
            background: linear-gradient(90deg, #fff 0%, var(--accent-cyan) 30%, var(--accent-gold) 55%, var(--accent-red) 78%, #fff 100%);
            background-size: 220% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: footerTesdaShimmer 6s linear infinite;
        }
        @keyframes footerTesdaShimmer {
            0%   { background-position: 0% center; }
            100% { background-position: 220% center; }
        }

        .footer-divider {
            position: relative;
            overflow: hidden;
        }
        .footer-divider::before {
            content: '';
            position: absolute;
            top: -1px; left: 0;
            width: 100%; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,230,255,0.7), transparent);
            background-size: 50% 100%;
            animation: dividerSweep 7s linear infinite;
        }
        @keyframes dividerSweep {
            0%   { background-position: -100% 0; }
            100% { background-position: 200% 0; }
        }

        .footer-currency-menu {
            transform-origin: top left;
            transition: opacity 200ms ease, transform 200ms var(--footer-ease);
        }
        .footer-currency-menu:not(.hidden) {
            animation: footerMenuIn 220ms var(--footer-ease) forwards;
        }
        @keyframes footerMenuIn {
            from { opacity: 0; transform: translateY(-6px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Footer partner/agency logo strip */
        .footer-agency-logos {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 2.5rem;
        }
        .footer-agency-logo {
            height: 4rem;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 14px rgba(0,0,0,0.3));
            transition: transform 240ms var(--footer-ease), filter 240ms ease;
        }
        .footer-agency-logo:hover {
            transform: translateY(-3px) scale(1.05);
            filter: drop-shadow(0 8px 20px rgba(0,230,255,0.35));
        }

        /* ══════════════════════════════════════
           KNOWLEDGE CHAT WIDGET
        ══════════════════════════════════════ */
        .chat-bubble-pulse {
            animation: chatPulse 2.6s ease-in-out infinite;
        }
        @keyframes chatPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(0,230,255,0.4); }
            50%       { box-shadow: 0 0 0 12px rgba(0,230,255,0); }
        }
        .chat-bubble-radar {
            position: absolute;
            inset: -3px;
            border-radius: 9999px;
            border: 1.5px solid rgba(0,230,255,0.5);
            animation: radarSpin 2.4s linear infinite;
            pointer-events: none;
        }
        .chat-bubble-radar::before {
            content: '';
            position: absolute;
            top: -1.5px; left: 50%;
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--accent-cyan);
            box-shadow: 0 0 8px 2px rgba(0,230,255,0.8);
            transform: translateX(-50%);
        }
        @keyframes radarSpin { to { transform: rotate(360deg); } }

        #knowledgeChatModal .relative.w-full { animation: modalPop 0.35s var(--elastic-ease); }
        @keyframes modalPop { from { opacity: 0; transform: translateY(18px) scale(0.96); } to { opacity: 1; transform: translateY(0) scale(1); } }

        .typing-dots { display: inline-flex; align-items: center; gap: 4px; padding: 2px 0; }
        .typing-dots span {
            width: 6px; height: 6px; border-radius: 50%;
            background: rgba(59,130,246,0.65);
            animation: typingBounce 1.1s ease-in-out infinite;
        }
        .typing-dots span:nth-child(2) { animation-delay: 0.15s; }
        .typing-dots span:nth-child(3) { animation-delay: 0.3s; }
        @keyframes typingBounce { 0%, 60%, 100% { transform: translateY(0); opacity: 0.5; } 30% { transform: translateY(-5px); opacity: 1; } }

        /* ══════════════════════════════════════
           REDUCED MOTION
        ══════════════════════════════════════ */
        @media (prefers-reduced-motion: reduce) {
            .site-header,
            .header-brand-icon,
            .mobile-nav-link,
            .logo-ring,
            .logo-reticle,
            .logo-sparkle,
            .logo-particle,
            .rocket-flame,
            .logo-wordmark-primary::after,
            .logo-sub-dot,
            [data-footer-animate],
            .footer-logo-icon,
            .footer-tesda-text,
            .footer-blob,
            .footer-divider::before,
            .header-scanline::before,
            .chat-bubble-pulse,
            .chat-bubble-radar,
            .header-signup-btn::before,
            .status-track,
            .status-dot,
            #back-to-top i,
            #knowledgeChatModal .relative.w-full,
            .typing-dots span,
            .footer-agency-logo {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .nav-link:hover,
            .header-action-btn:hover,
            .footer-link:hover,
            .footer-social:hover { transform: none; }
        }
    </style>
    @stack('head')
</head>
<body class="bg-light-background text-dark">

    {{-- Page-load progress bar --}}
    <div id="page-progress" aria-hidden="true"></div>

    {{-- Ambient cursor spotlight --}}
    <div id="cursor-glow" aria-hidden="true"></div>

    <header id="site-header" class="site-header fixed w-full z-50 text-slate-100">
        <div class="header-hud-grid hud-grid" aria-hidden="true"></div>

        {{-- Scrolling status strip --}}
        <div class="status-strip" aria-hidden="true">
            <div class="status-track">
                <span class="status-item"><span class="status-dot"></span>TESDA-ALIGNED CURRICULUM</span>
                <span class="status-item gold"><span class="status-dot"></span>LIVE MENTOR SUPPORT</span>
                <span class="status-item"><span class="status-dot"></span>SKILL PATHS UPDATED WEEKLY</span>
                <span class="status-item red"><span class="status-dot"></span>FREE STARTER COURSES</span>
                <span class="status-item"><span class="status-dot"></span>CAREER-READY CREDENTIALS</span>
                <span class="status-item gold"><span class="status-dot"></span>BUILT FOR FILIPINO YOUTH</span>
                <span class="status-item"><span class="status-dot"></span>TESDA-ALIGNED CURRICULUM</span>
                <span class="status-item gold"><span class="status-dot"></span>LIVE MENTOR SUPPORT</span>
                <span class="status-item"><span class="status-dot"></span>SKILL PATHS UPDATED WEEKLY</span>
                <span class="status-item red"><span class="status-dot"></span>FREE STARTER COURSES</span>
                <span class="status-item"><span class="status-dot"></span>CAREER-READY CREDENTIALS</span>
                <span class="status-item gold"><span class="status-dot"></span>BUILT FOR FILIPINO YOUTH</span>
            </div>
        </div>

        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Main navigation">
            <div class="site-header-bar flex items-center justify-between gap-4 lg:gap-6">

                {{-- ══ BRAND / LOGO ══ --}}
                <a href="/" class="header-brand inline-flex items-center gap-3 sm:gap-4 text-white shrink-0" aria-label="SkillUp Home">

                    {{-- Icon wrap --}}
                    <span class="relative inline-block" style="width:52px;height:52px;flex-shrink:0;">

                        {{-- Targeting reticle ticks (hover only) --}}
                        <span class="logo-reticle" aria-hidden="true">
                            <span></span><span></span><span></span><span></span>
                        </span>

                        {{-- Spinning conic ring (hover only) --}}
                        <span class="logo-ring" aria-hidden="true"></span>

                        {{-- Main icon box --}}
                        <span class="header-brand-icon" id="logo-icon-box" aria-hidden="true">

                            {{-- Particle container --}}
                            <span id="logo-particles" class="absolute inset-0 overflow-hidden pointer-events-none" style="border-radius:16px;" aria-hidden="true"></span>

                            {{-- Custom rocket SVG --}}
                            <svg viewBox="0 0 26 26" fill="none" class="relative z-10" style="width:26px;height:26px;filter:drop-shadow(0 1px 4px rgba(0,0,0,0.45));" aria-hidden="true">
                                <g class="rocket-flame">
                                    <ellipse cx="13" cy="22.5" rx="3.8" ry="3.2" fill="rgba(0,230,255,0.9)"/>
                                    <ellipse cx="13" cy="23"   rx="2.2" ry="2.0" fill="rgba(253,185,19,0.85)"/>
                                </g>
                                <path d="M13 3C9 3 7 8 7 13L7 18C7 18 9.5 19.5 13 19.5C16.5 19.5 19 18 19 18L19 13C19 8 17 3 13 3Z" fill="white" opacity="0.95"/>
                                <circle cx="13" cy="11" r="2.5" fill="rgba(0,58,143,0.75)" stroke="rgba(0,230,255,0.55)" stroke-width="0.5"/>
                                <circle cx="13" cy="11" r="1"   fill="rgba(120,215,255,0.95)"/>
                                <circle cx="13.4" cy="10.5" r="0.4" fill="rgba(255,255,255,0.7)"/>
                                <path d="M7 16L4 19L7 18.5Z"   fill="rgba(193,18,31,0.85)"/>
                                <path d="M19 16L22 19L19 18.5Z" fill="rgba(193,18,31,0.85)"/>
                                <path d="M13 3C11 3 10 5 10 7L13 5L16 7C16 5 15 3 13 3Z" fill="rgba(253,185,19,0.98)"/>
                            </svg>
                        </span>

                        {{-- Gold sparkle star --}}
                        <svg class="logo-sparkle" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M7 0L7.9 5.5L13.3 5.5L9 8.8L10.4 14L7 10.8L3.6 14L5 8.8L0.7 5.5L6.1 5.5Z" fill="#00e6ff"/>
                        </svg>
                    </span>

                    {{-- Wordmark --}}
                    <div class="hidden sm:flex flex-col gap-0.5">
                        <span class="logo-wordmark-primary">SkillUp</span>
                        <span class="logo-wordmark-sub">
                            Learning Portal
                            <span class="logo-sub-dot"></span>
                            PH
                        </span>
                    </div>
                </a>

                {{-- Desktop nav --}}
                <div class="hidden lg:flex flex-1 justify-center">
                    <div id="primary-nav" class="font-display flex items-center gap-10 xl:gap-12 text-sm font-semibold uppercase tracking-[0.12em]">
                        <a href="/" class="nav-link">Home</a>
                        <a href="{{ route('about') }}" class="nav-link">About</a>
                        <a href="{{ route('courses.index') }}" class="nav-link">Courses</a>
                        <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                    </div>
                </div>

                {{-- Desktop actions --}}
                <div class="hidden lg:flex items-center gap-2.5 shrink-0">
                    <form action="{{ route('courses.index') }}" method="GET" class="header-search relative flex items-center rounded-full border border-slate-600/60 bg-slate-950/30 px-3 py-2 w-[14rem] xl:w-[20rem]">
                        <i class="header-search-icon fas fa-search text-slate-400 text-sm"></i>
                        <input
                            type="search"
                            name="search"
                            placeholder="Search courses..."
                            class="ml-2.5 w-full bg-transparent text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none"
                        />
                        <kbd class="hidden xl:inline-block">/</kbd>
                    </form>
                    @auth
                        <a href="{{ route('notifications.index') }}" class="header-action-btn relative inline-flex h-11 w-11 items-center justify-center rounded-full bg-slate-900/90 text-slate-100 border border-slate-700/50" aria-label="Notifications">
                            <i class="fas fa-bell"></i>
                            <span id="header-unread-badge" class="hidden absolute -top-1 -right-1 inline-flex items-center justify-center h-5 min-w-[1.25rem] px-1.5 rounded-full bg-rose-500 text-white text-xs font-bold">0</span>
                        </a>
                        <div id="header-user-wrap" class="relative header-user-menu">
                            <button
                                id="user-menu-toggle"
                                type="button"
                                class="header-action-btn inline-flex items-center gap-2 rounded-full bg-slate-900/90 border border-slate-700/50 px-4 py-2.5 text-sm font-semibold text-white focus:outline-none"
                                aria-haspopup="true"
                                aria-expanded="false"
                                aria-controls="user-menu"
                            >
                                <i class="fas fa-user-circle text-slate-300" aria-hidden="true"></i>
                                <span class="hidden xl:inline">Menu</span>
                                <i class="fas fa-chevron-down text-xs text-slate-400 header-menu-chevron" aria-hidden="true"></i>
                            </button>
                            <div id="user-menu" role="menu" class="header-dropdown absolute right-0 top-full mt-2 min-w-[13rem] overflow-hidden rounded-2xl border border-slate-700/80 bg-[#0c2d4a] shadow-2xl shadow-black/40">
                                <a href="{{ route('userpage.profile') }}" class="block px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80"><i class="fas fa-user mr-2 text-cyan-300"></i>Profile</a>
                                <a href="{{ route('chats.index') }}" class="block px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80"><i class="fas fa-comments mr-2 text-cyan-300"></i>Messages</a>
                                <a href="{{ route('contact') }}" class="block px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80"><i class="fas fa-envelope mr-2 text-cyan-300"></i>Contact</a>
                                <div class="border-t border-slate-700/80">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-400 hover:bg-red-950/40 hover:text-red-300">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="/login"    class="header-action-btn header-login-btn btn-ripple inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-semibold text-white">Login</a>
                        <a href="/register" class="header-action-btn header-signup-btn btn-ripple inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-bold shadow-md">Sign Up</a>
                    @endauth
                </div>

                {{-- Mobile toggle --}}
                <button id="nav-toggle" type="button" class="header-nav-toggle lg:hidden inline-flex h-11 w-11 items-center justify-center rounded-xl text-slate-100 border border-slate-700/50" aria-label="Open menu" aria-expanded="false">
                    <i id="nav-open-icon"  class="fas fa-bars text-lg"></i>
                    <i id="nav-close-icon" class="fas fa-times text-lg hidden"></i>
                </button>
            </div>
        </nav>

        {{-- Mobile menu --}}
        <div id="mobile-nav" class="mobile-nav-panel lg:hidden bg-[#050e1c]/98 backdrop-blur-xl border-t border-cyan-400/10 shadow-2xl shadow-black/30">
            <div class="hud-grid absolute inset-0 pointer-events-none" aria-hidden="true"></div>
            <div class="relative px-4 py-4 border-b border-slate-800/80">
                <form action="{{ route('courses.index') }}" method="GET" class="header-search flex items-center gap-3 rounded-2xl border border-slate-700/60 bg-slate-950/40 px-4 py-3">
                    <i class="header-search-icon fas fa-search text-slate-400"></i>
                    <input
                        type="search"
                        name="search"
                        placeholder="Search courses..."
                        class="w-full bg-transparent text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none"
                    />
                </form>
            </div>
            <div class="relative px-4 py-5 space-y-2.5">
                <a href="/"                           class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80">Home</a>
                <a href="{{ route('about') }}"         class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80">About</a>
                <a href="{{ route('courses.index') }}" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80">Courses</a>
                <a href="{{ route('contact') }}"       class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80">Contact</a>
                @auth
                    <a href="{{ route('chats.index') }}"        class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80"><i class="fas fa-comments mr-2 text-cyan-300"></i>Messages</a>
                    <a href="{{ route('notifications.index') }}" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80"><i class="fas fa-bell mr-2 text-cyan-300"></i>Notifications</a>
                    <form action="{{ route('logout') }}" method="POST" class="mobile-nav-link block pt-1">
                        @csrf
                        <button type="submit" class="header-action-btn w-full rounded-2xl bg-red-600/90 px-4 py-3.5 text-sm font-semibold text-white hover:bg-red-600 border border-red-500/30">Logout</button>
                    </form>
                @else
                    <a href="/login"    class="mobile-nav-link block rounded-2xl border border-slate-700/80 bg-slate-900/60 px-4 py-3.5 text-sm font-semibold text-slate-100 text-center">Login</a>
                    <a href="/register" class="mobile-nav-link header-signup-btn btn-ripple block rounded-2xl px-4 py-3.5 text-sm font-bold text-center shadow-md">Sign Up Free</a>
                @endauth
            </div>
        </div>

        {{-- Animated scanline sweep along the header's bottom edge --}}
        <span class="header-scanline" aria-hidden="true"></span>
    </header>


    <main class="pt-[6.75rem] lg:pt-[7.25rem]">
        @yield('content')
    </main>


    <footer id="site-footer" class="site-footer relative text-slate-200 pt-20 pb-12 px-4 mt-16 overflow-hidden border-t border-cyan-400/10">
        <div class="footer-glow absolute inset-0 pointer-events-none" aria-hidden="true"></div>
        <svg class="footer-circuit" viewBox="0 0 1200 500" preserveAspectRatio="none" aria-hidden="true">
            <defs>
                <pattern id="circuitPattern" width="120" height="120" patternUnits="userSpaceOnUse">
                    <path d="M0 60H45M75 60H120M60 0V45M60 75V120" stroke="rgba(0,230,255,0.10)" stroke-width="1"/>
                    <circle cx="60" cy="60" r="3" fill="rgba(0,230,255,0.16)"/>
                    <circle cx="0" cy="60" r="2" fill="rgba(253,185,19,0.14)"/>
                    <circle cx="120" cy="60" r="2" fill="rgba(253,185,19,0.14)"/>
                </pattern>
            </defs>
            <rect width="1200" height="500" fill="url(#circuitPattern)"/>
        </svg>
        <div class="footer-blob w-72 h-72 bg-cyan-500/25 -top-20 -left-16" aria-hidden="true"></div>
        <div class="footer-blob w-80 h-80 bg-blue-600/20 top-1/3 -right-20" style="animation-delay:2s;" aria-hidden="true"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-10 mb-14">

                {{-- Brand --}}
                <div data-footer-animate class="space-y-5 sm:col-span-2 lg:col-span-1">
                    <a href="/" class="footer-brand inline-flex items-center gap-3 group">
                        <span class="footer-logo-icon inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#003a8f]/50 to-[#00e6ff]/20 border border-cyan-400/20 text-white text-lg shadow-lg overflow-hidden relative">
                            <svg viewBox="0 0 26 26" fill="none" style="width:22px;height:22px;filter:drop-shadow(0 1px 3px rgba(0,0,0,0.4));position:relative;z-index:1;" aria-hidden="true">
                                <g class="rocket-flame">
                                    <ellipse cx="13" cy="22.5" rx="3.5" ry="3"   fill="rgba(0,230,255,0.9)"/>
                                    <ellipse cx="13" cy="23"   rx="2"   ry="1.8" fill="rgba(253,185,19,0.85)"/>
                                </g>
                                <path d="M13 3C9 3 7 8 7 13L7 18C7 18 9.5 19.5 13 19.5C16.5 19.5 19 18 19 18L19 13C19 8 17 3 13 3Z" fill="white" opacity="0.95"/>
                                <circle cx="13" cy="11" r="2.5" fill="rgba(0,58,143,0.75)" stroke="rgba(0,230,255,0.55)" stroke-width="0.5"/>
                                <circle cx="13" cy="11" r="1"   fill="rgba(120,215,255,0.95)"/>
                                <path d="M7 16L4 19L7 18.5Z"   fill="rgba(193,18,31,0.85)"/>
                                <path d="M19 16L22 19L19 18.5Z" fill="rgba(193,18,31,0.85)"/>
                                <path d="M13 3C11 3 10 5 10 7L13 5L16 7C16 5 15 3 13 3Z" fill="rgba(253,185,19,0.98)"/>
                            </svg>
                        </span>
                        <div>
                            <p class="font-display text-xl font-bold text-white group-hover:text-cyan-200 transition-colors">SkillUp</p>
                            <p class="text-sm text-slate-400">Youth learning for modern careers</p>
                        </div>
                    </a>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-xs">
                        Personalized paths, mentoring, credential growth, and real opportunity support — all in one platform.
                    </p>
                    <div class="footer-stats pt-1 max-w-xs">
                        <div>
                            <p class="footer-stat-num" data-counter data-target="120">0</p>
                            <p class="footer-stat-label">Courses</p>
                        </div>
                        <div>
                            <p class="footer-stat-num" data-counter data-target="35000">0</p>
                            <p class="footer-stat-label">Learners</p>
                        </div>
                        <div>
                            <p class="footer-stat-num" data-counter data-target="98">0</p>
                            <p class="footer-stat-label">% Satisfied</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="#"                      class="footer-social" aria-label="Facebook"><i class="fab fa-facebook-f text-sm"></i></a>
                        <a href="#"                      class="footer-social" aria-label="Instagram"><i class="fab fa-instagram text-sm"></i></a>
                        <a href="#"                      class="footer-social" aria-label="LinkedIn"><i class="fab fa-linkedin-in text-sm"></i></a>
                        <a href="{{ route('contact') }}" class="footer-social" aria-label="Contact us"><i class="fas fa-envelope text-sm"></i></a>
                    </div>
                </div>

                {{-- Learn --}}
                <div data-footer-animate class="footer-delay-1">
                    <h4 class="footer-eyebrow font-display font-semibold text-white uppercase tracking-[0.18em] mb-5 text-xs">
                        <span class="eyebrow-rule"></span>Learn
                    </h4>
                    <ul class="space-y-3.5 text-sm text-slate-400">
                        <li><a href="{{ url('/#features') }}"    class="footer-link">Features</a></li>
                        <li><a href="{{ url('/#how-it-works') }}" class="footer-link">How It Works</a></li>
                        <li><a href="{{ route('courses.index') }}" class="footer-link">Courses</a></li>
                        <li><a href="{{ route('contact') }}#faq"  class="footer-link">FAQ</a></li>
                    </ul>
                </div>

                {{-- Company --}}
                <div data-footer-animate class="footer-delay-2">
                    <h4 class="footer-eyebrow font-display font-semibold text-white uppercase tracking-[0.18em] mb-5 text-xs">
                        <span class="eyebrow-rule"></span>Company
                    </h4>
                    <ul class="space-y-3.5 text-sm text-slate-400">
                        <li><a href="{{ route('about') }}"              class="footer-link">About Us</a></li>
                        <li><a href="{{ route('contact') }}"            class="footer-link">Contact</a></li>
                        <li><a href="/Userpage/Company/careers"         class="footer-link">Careers</a></li>
                        <li><a href="/Userpage/Company/blog"            class="footer-link">Blog</a></li>
                    </ul>
                </div>

                {{-- Support --}}
                <div data-footer-animate class="footer-delay-3">
                    <h4 class="footer-eyebrow font-display font-semibold text-white uppercase tracking-[0.18em] mb-5 text-xs">
                        <span class="eyebrow-rule"></span>Support
                    </h4>
                    <ul class="space-y-3.5 text-sm text-slate-400">
                        <li><a href="/Userpage/Legal/privacy"    class="footer-link">Privacy Policy</a></li>
                        <li><a href="/Userpage/Legal/terms"      class="footer-link">Terms &amp; Conditions</a></li>
                        <li><a href="/Userpage/Legal/cookiepolicy" class="footer-link">Cookie Policy</a></li>
                        <li><a href="{{ route('contact') }}"     class="footer-link">Help Center</a></li>
                    </ul>
                </div>
            </div>

            <div data-footer-animate class="footer-delay-4 footer-divider border-t border-slate-700/60 pt-8 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="relative inline-flex items-center">
                        <button id="currency-toggle" type="button" class="inline-flex items-center gap-2 rounded-full border border-slate-600/80 bg-slate-900/80 px-4 py-2.5 text-sm font-semibold text-slate-200 hover:bg-slate-800 hover:border-cyan-400/40 transition focus:outline-none">
                            <i class="fas fa-coins text-amber-400 text-xs"></i>
                            <span id="currency-label">PHl</span>
                            <i class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200" id="currency-chevron"></i>
                        </button>
                        <div id="currency-menu" class="footer-currency-menu absolute left-0 top-full mt-2 hidden min-w-[10rem] overflow-hidden rounded-2xl border border-slate-700 bg-[#0c2d4a] shadow-xl shadow-black/40 z-20">
                            @foreach (['EUR','USD','GBP','PHP','JPY','AUD','CAD'] as $currency)
                                <button type="button" class="w-full text-left px-4 py-2.5 text-sm text-slate-200 hover:bg-cyan-600/20 hover:text-white transition" data-currency="{{ $currency }}">{{ $currency }}</button>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-xs text-slate-500">Prices shown in selected currency (display only)</p>
                </div>
                <p class="text-sm text-slate-500 md:text-right">
                    Made with <i class="fas fa-heart text-red-500/80 mx-0.5 animate-pulse"></i> for Filipino youth
                </p>
            </div>

            <div data-footer-animate class="footer-delay-4 footer-divider border-t border-slate-700/60 mt-8 pt-8 text-center">
                <p class="text-slate-500 text-sm">© {{ date('Y') }} SkillUp. All rights reserved.</p>
            </div>

            <div data-footer-animate class="mt-12 text-center">
                <p class="footer-tesda-text font-display text-3xl sm:text-4xl md:text-5xl font-black tracking-[0.2em] sm:tracking-[0.25em] uppercase select-none">
                    SKILLUP × TESDA
                </p>
                <div class="footer-agency-logos mx-auto mt-6">
                    <img src="{{ asset('image\logo new.jpg') }}" alt="APARRI Polytechnic Institute logo" class="footer-agency-logo" loading="lazy" />
                    <img src="{{ asset('image/hello.png') }}" alt="Partner logo" class="footer-agency-logo" loading="lazy" />
                    <img src="{{ asset('image/bagong-pilipinas-logo-png_seeklogo-534301.png') }}" alt="Bagong Pilipinas logo" class="footer-agency-logo" loading="lazy" />
                </div>
                <p class="text-slate-500 text-xs mt-3 tracking-widest uppercase font-mono">// Technical Education and Skills Development Authority</p>
            </div>
        </div>
    </footer>




    {{-- ══ TOAST STACK ══ --}}
    <div id="toast-stack" aria-live="polite" aria-atomic="true"></div>

    {{-- ══ KNOWLEDGE CHAT BUBBLE ══ --}}
    <div id="knowledgeChatBubble" title="SKILL.UP BOT" class="chat-bubble-pulse fixed bottom-6 right-6 z-50 flex h-16 w-16 items-center justify-center rounded-full bg-blue-600 text-white shadow-[0_22px_50px_-20px_rgba(0,230,255,0.9)] shadow-slate-900/30 cursor-pointer ring-4 ring-white transition-transform duration-200 hover:scale-105 hover:bg-blue-700 overflow-hidden">
        <span class="chat-bubble-radar" aria-hidden="true"></span>
        <img src="{{ asset('image/logo_oif_skillup_1_-removebg-preview.png') }}" alt="SKILL.UP BOT logo" class="relative h-11 w-11 object-cover" />
    </div>

    <div id="knowledgeChatModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 p-4">
        <div class="relative w-full max-w-2xl overflow-hidden rounded-[28px] bg-white text-slate-900 shadow-2xl sm:max-h-[calc(100vh-2rem)]">
            <div class="relative flex flex-col gap-4 border-b border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between overflow-hidden">
                <div class="hud-grid absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true"></div>
                <div class="relative flex items-center gap-3">
                    <span class="relative flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-sm">
                        <i class="fas fa-robot"></i>
                        <span class="absolute -top-1 -right-1 h-2.5 w-2.5 rounded-full bg-cyan-400 ring-2 ring-white animate-pulse"></span>
                    </span>
                    <div>
                        <h2 class="font-display text-lg font-semibold">SKILL.UP BOT</h2>
                        <p class="text-sm text-slate-500 font-mono">Welcome to SKILL-UP A.I</p>
                    </div>
                </div>
                <button id="closeKnowledgeChat" class="relative inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition" aria-label="Close chat">×</button>
            </div>
            <div class="p-5">
                <div id="knowledgeChatMessages" class="flex h-[340px] flex-col gap-3 overflow-y-auto rounded-[28px] border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700"></div>
            </div>
            <div class="sticky bottom-0 border-t border-slate-200 bg-white px-5 py-4">
                <form id="knowledgeChatForm" class="flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input id="knowledgeChatInput" type="text" placeholder="Ask about knowledge, courses, or skills..." class="flex-1 rounded-full border border-slate-200 bg-slate-100 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/30" required>
                    <button type="submit" class="inline-flex h-12 items-center justify-center rounded-full bg-blue-600 px-6 text-sm font-semibold text-white transition hover:bg-blue-700">
                        <i class="fas fa-paper-plane mr-2"></i>Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        #knowledgeChatBubble { touch-action: manipulation; }
        #knowledgeChatBubble:hover { transform: translateY(-2px) scale(1.05); }
        #knowledgeChatModal.show { display: flex !important; }
        #knowledgeChatMessages { scrollbar-width: thin; scrollbar-color: rgba(59,130,246,0.7) rgba(226,232,240,0.8); }
        #knowledgeChatMessages::-webkit-scrollbar { width: 10px; }
        #knowledgeChatMessages::-webkit-scrollbar-track { background: rgba(226,232,240,0.6); border-radius: 9999px; }
        #knowledgeChatMessages::-webkit-scrollbar-thumb { background: rgba(59,130,246,0.75); border-radius: 9999px; border: 2px solid rgba(226,232,240,0.6); }
        #knowledgeChatMessages::-webkit-scrollbar-thumb:hover { background: rgba(37,99,235,0.85); }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* ══════════════════════════════════════
           PAGE LOAD PROGRESS BAR
        ══════════════════════════════════════ */
        (function initPageProgress() {
            const bar = document.getElementById('page-progress');
            if (!bar) return;
            requestAnimationFrame(() => { bar.style.width = '70%'; });
            window.addEventListener('load', () => {
                bar.style.width = '100%';
                setTimeout(() => bar.classList.add('is-done'), 250);
            });
            // Safety net in case 'load' already fired
            if (document.readyState === 'complete') {
                bar.style.width = '100%';
                setTimeout(() => bar.classList.add('is-done'), 250);
            }
        })();

        /* ══════════════════════════════════════
           AMBIENT CURSOR SPOTLIGHT
        ══════════════════════════════════════ */
        (function initCursorGlow() {
            const glow = document.getElementById('cursor-glow');
            if (!glow || reducedMotion) return;
            let raf = null, tx = 0, ty = 0;
            window.addEventListener('pointermove', (e) => {
                if (e.pointerType !== 'mouse') return;
                tx = e.clientX; ty = e.clientY;
                glow.classList.add('is-active');
                if (raf) return;
                raf = requestAnimationFrame(() => {
                    glow.style.transform = `translate(${tx}px, ${ty}px)`;
                    raf = null;
                });
            });
            document.addEventListener('mouseleave', () => glow.classList.remove('is-active'));
        })();

        /* ══════════════════════════════════════
           LOGO — particle spawner
        ══════════════════════════════════════ */
        (function spawnLogoParticles() {
            const container = document.getElementById('logo-particles');
            if (!container) return;
            if (reducedMotion) return;

            const colors = [
                'rgba(0,230,255,0.9)',
                'rgba(253,185,19,0.8)',
                'rgba(193,18,31,0.7)',
                'rgba(255,255,255,0.65)'
            ];
            for (let i = 0; i < 10; i++) {
                const p = document.createElement('span');
                const angle = (i / 10) * 360;
                const rad   = angle * Math.PI / 180;
                const dist  = 13 + Math.random() * 12;
                const size  = 1.5 + Math.random() * 2.5;
                p.className = 'logo-particle';
                p.style.cssText = [
                    `width:${size}px`,
                    `height:${size}px`,
                    `background:${colors[i % colors.length]}`,
                    `top:calc(50% - ${size / 2}px)`,
                    `left:calc(50% - ${size / 2}px)`,
                    `--px:${(Math.cos(rad) * dist).toFixed(1)}px`,
                    `--py:${(Math.sin(rad) * dist).toFixed(1)}px`,
                    `--pdur:${(1.8 + Math.random() * 1.6).toFixed(2)}s`,
                    `--pdel:${(i * 0.28).toFixed(2)}s`
                ].join(';');
                container.appendChild(p);
            }
        })();

        /* ══════════════════════════════════════
           BUTTON RIPPLE MICRO-INTERACTION
        ══════════════════════════════════════ */
        (function initRipples() {
            if (reducedMotion) return;
            document.querySelectorAll('.btn-ripple').forEach((btn) => {
                btn.addEventListener('click', function (e) {
                    const rect = this.getBoundingClientRect();
                    const circle = document.createElement('span');
                    const size = Math.max(rect.width, rect.height);
                    circle.className = 'ripple-circle';
                    circle.style.width = circle.style.height = `${size}px`;
                    circle.style.left = `${e.clientX - rect.left - size / 2}px`;
                    circle.style.top = `${e.clientY - rect.top - size / 2}px`;
                    this.appendChild(circle);
                    setTimeout(() => circle.remove(), 650);
                });
            });
        })();

        /* ══════════════════════════════════════
           HEADER — scroll, mobile nav, user menu
        ══════════════════════════════════════ */
        (function initSkillupHeaderNav() {
            if (window.__skillupHeaderNavInit) return;
            window.__skillupHeaderNavInit = true;

            const siteHeader     = document.getElementById('site-header');
            const navToggle      = document.getElementById('nav-toggle');
            const mobileNav      = document.getElementById('mobile-nav');
            const navOpenIcon    = document.getElementById('nav-open-icon');
            const navCloseIcon   = document.getElementById('nav-close-icon');
            const primaryNav     = document.getElementById('primary-nav');
            const userMenuToggle = document.getElementById('user-menu-toggle');
            const userMenu       = document.getElementById('user-menu');
            const headerUserWrap = document.getElementById('header-user-wrap');
            const backToTop      = document.getElementById('back-to-top');

            function onHeaderScroll() {
                if (!siteHeader) return;
                const scrolled = window.scrollY > 12;
                siteHeader.classList.toggle('is-scrolled', scrolled);
                if (backToTop) backToTop.classList.toggle('is-visible', window.scrollY > 480);
            }
            onHeaderScroll();
            window.addEventListener('scroll', onHeaderScroll, { passive: true });

            if (backToTop) {
                backToTop.addEventListener('click', () => {
                    window.scrollTo({ top: 0, behavior: reducedMotion ? 'auto' : 'smooth' });
                });
            }

            function closeMobileNav() {
                if (!mobileNav) return;
                mobileNav.classList.remove('is-open');
                if (navToggle) {
                    navToggle.classList.remove('is-active');
                    navToggle.setAttribute('aria-expanded', 'false');
                    navToggle.setAttribute('aria-label', 'Open menu');
                }
                if (navOpenIcon)  navOpenIcon.classList.remove('hidden');
                if (navCloseIcon) navCloseIcon.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function openMobileNav() {
                if (!mobileNav) return;
                closeUserMenu();
                mobileNav.classList.add('is-open');
                if (navToggle) {
                    navToggle.classList.add('is-active');
                    navToggle.setAttribute('aria-expanded', 'true');
                    navToggle.setAttribute('aria-label', 'Close menu');
                }
                if (navOpenIcon)  navOpenIcon.classList.add('hidden');
                if (navCloseIcon) navCloseIcon.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            if (navToggle && mobileNav) {
                navToggle.addEventListener('click', (e) => {
                    e.preventDefault(); e.stopPropagation();
                    mobileNav.classList.contains('is-open') ? closeMobileNav() : openMobileNav();
                });
            }

            function closeUserMenu() {
                if (userMenu)       userMenu.classList.remove('is-open');
                if (headerUserWrap) headerUserWrap.classList.remove('is-open');
                if (userMenuToggle) userMenuToggle.setAttribute('aria-expanded', 'false');
            }
            function openUserMenu() {
                if (!userMenu) return;
                closeMobileNav();
                userMenu.classList.add('is-open');
                if (headerUserWrap) headerUserWrap.classList.add('is-open');
                if (userMenuToggle) userMenuToggle.setAttribute('aria-expanded', 'true');
            }

            if (userMenuToggle && userMenu) {
                userMenuToggle.addEventListener('click', (e) => {
                    e.preventDefault(); e.stopPropagation();
                    userMenu.classList.contains('is-open') ? closeUserMenu() : openUserMenu();
                });
                userMenu.querySelectorAll('a').forEach(link => link.addEventListener('click', closeUserMenu));
            }

            document.addEventListener('click', (e) => {
                if (mobileNav && mobileNav.classList.contains('is-open') && navToggle && !mobileNav.contains(e.target) && !navToggle.contains(e.target)) closeMobileNav();
                if (userMenu  && userMenu.classList.contains('is-open')  && userMenuToggle && !userMenuToggle.contains(e.target) && !userMenu.contains(e.target)) closeUserMenu();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') { closeMobileNav(); closeUserMenu(); }
                // Slash focuses search, unless typing in a field already
                if (e.key === '/' && document.activeElement && !['INPUT','TEXTAREA'].includes(document.activeElement.tagName)) {
                    const search = document.querySelector('.header-search input[type="search"]');
                    if (search) { e.preventDefault(); search.focus(); }
                }
            });
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) closeMobileNav();
            });
            if (mobileNav) {
                mobileNav.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMobileNav));
            }

            function highlightActiveLinks() {
                const links = [];
                if (primaryNav) links.push(...primaryNav.querySelectorAll('a'));
                if (mobileNav)  links.push(...mobileNav.querySelectorAll('a.mobile-nav-link'));
                const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
                links.forEach((a) => {
                    try {
                        const path = new URL(a.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
                        a.classList.toggle('active', path === currentPath);
                    } catch (_) {}
                });
            }
            highlightActiveLinks();
        })();

        /* ══════════════════════════════════════
           TOAST NOTIFICATIONS — global helper
        ══════════════════════════════════════ */
        (function initToasts() {
            const stack = document.getElementById('toast-stack');
            if (!stack) return;
            const icons = { success: 'fa-circle-check', error: 'fa-triangle-exclamation', info: 'fa-circle-info' };

            window.SkillUpToast = {
                show(message, type = 'info', duration = 4200) {
                    const el = document.createElement('div');
                    el.className = `skillup-toast ${type}`;
                    el.innerHTML = `
                        <span class="toast-icon"><i class="fas ${icons[type] || icons.info}"></i></span>
                        <span class="flex-1">${message}</span>
                    `;
                    stack.appendChild(el);
                    setTimeout(() => {
                        el.classList.add('is-leaving');
                        setTimeout(() => el.remove(), 400);
                    }, duration);
                }
            };
        })();

        /* ══════════════════════════════════════
           KNOWLEDGE CHAT
        ══════════════════════════════════════ */
        const bubble   = document.getElementById('knowledgeChatBubble');
        const modal    = document.getElementById('knowledgeChatModal');
        const closeBtn = document.getElementById('closeKnowledgeChat');
        const form     = document.getElementById('knowledgeChatForm');
        const input    = document.getElementById('knowledgeChatInput');
        const messages = document.getElementById('knowledgeChatMessages');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('show');
            bubble.classList.remove('chat-bubble-pulse');
            if (messages.children.length === 0) {
                addBotMessage('Hello! I am SKILL.UP BOT, your learning assistant. Ask me about courses, skills, study plans, or professional development guidance.');
            }
            input.focus();
        }
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('show');
        }
        function addUserMessage(text) {
            const b = document.createElement('div');
            b.className = 'self-end rounded-3xl bg-blue-600 px-4 py-3 text-sm text-white shadow-sm max-w-[85%]';
            b.textContent = text;
            messages.appendChild(b);
            messages.scrollTop = messages.scrollHeight;
        }
        function addBotMessage(text) {
            const b = document.createElement('div');
            b.className = 'self-start rounded-3xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-sm max-w-[85%]';
            b.textContent = text;
            messages.appendChild(b);
            messages.scrollTop = messages.scrollHeight;
        }
        function addTypingIndicator() {
            const b = document.createElement('div');
            b.className = 'self-start rounded-3xl bg-slate-100 px-4 py-3 shadow-sm max-w-[85%]';
            b.innerHTML = '<span class="typing-dots"><span></span><span></span><span></span></span>';
            messages.appendChild(b);
            messages.scrollTop = messages.scrollHeight;
            return b;
        }
        function sendKnowledgePrompt(text) {
            input.value = text;
            form.requestSubmit();
        }

        bubble.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('show')) closeModal();
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const value = input.value.trim();
            if (!value) return;
            addUserMessage(value);
            input.value = '';
            const typingBubble = addTypingIndicator();
            const token = form.querySelector('input[name="_token"]').value;
            try {
                const response = await fetch('{{ route("ai-chatbot.guest-send-message") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ message: value }),
                });
                const data = await response.json();
                typingBubble.classList.remove('bg-slate-100');
                typingBubble.className = 'self-start rounded-3xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-sm max-w-[85%]';
                if (data.success && data.aiResponse) {
                    typingBubble.textContent = data.aiResponse;
                } else {
                    typingBubble.textContent = data.error || 'The AI assistant is temporarily unavailable. Please try again later.';
                }
                messages.scrollTop = messages.scrollHeight;
            } catch (err) {
                console.error('Knowledge chat error:', err);
                typingBubble.className = 'self-start rounded-3xl bg-slate-100 px-4 py-3 text-sm text-slate-700 shadow-sm max-w-[85%]';
                typingBubble.textContent = 'The AI assistant is temporarily unavailable. Please try again later.';
                messages.scrollTop = messages.scrollHeight;
            }
        });

        window.sendKnowledgePrompt = sendKnowledgePrompt;

        /* ══════════════════════════════════════
           FOOTER — currency picker
        ══════════════════════════════════════ */
        const currencyToggle  = document.getElementById('currency-toggle');
        const currencyMenu    = document.getElementById('currency-menu');
        const currencyLabel   = document.getElementById('currency-label');
        const currencyChevron = document.getElementById('currency-chevron');

        if (currencyToggle && currencyMenu && currencyLabel) {
            currencyToggle.addEventListener('click', () => {
                const isOpen = currencyMenu.classList.toggle('hidden') === false;
                if (currencyChevron) currencyChevron.style.transform = isOpen ? 'rotate(180deg)' : '';
            });
            currencyMenu.querySelectorAll('button[data-currency]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    currencyLabel.textContent = btn.dataset.currency;
                    currencyMenu.classList.add('hidden');
                    if (currencyChevron) currencyChevron.style.transform = '';
                });
            });
            document.addEventListener('click', (e) => {
                if (!currencyToggle.contains(e.target) && !currencyMenu.contains(e.target)) {
                    currencyMenu.classList.add('hidden');
                    if (currencyChevron) currencyChevron.style.transform = '';
                }
            });
        }

        /* ══════════════════════════════════════
           FOOTER — scroll-in animations + counters
        ══════════════════════════════════════ */
        const footerItems = document.querySelectorAll('[data-footer-animate]');
        const counters     = document.querySelectorAll('[data-counter]');

        function animateCounter(el) {
            const target = parseInt(el.dataset.target, 10) || 0;
            if (reducedMotion) { el.textContent = target.toLocaleString(); return; }
            const duration = 1400;
            const start = performance.now();
            function tick(now) {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(target * eased).toLocaleString();
                if (progress < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        }

        if ((footerItems.length || counters.length) && !reducedMotion) {
            const obs = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('footer-visible');
                        if (entry.target.hasAttribute('data-counter')) animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
            footerItems.forEach(el => obs.observe(el));
            counters.forEach(el => obs.observe(el));
        } else {
            footerItems.forEach(el => el.classList.add('footer-visible'));
            counters.forEach(el => animateCounter(el));
        }

        /* ══════════════════════════════════════
           CHAT NOTIFICATIONS — badge + beep + desktop
        ══════════════════════════════════════ */
        (function initChatNotifications() {
            try {
                const meta = document.querySelector('meta[name="chats-notifications"]');
                if (!meta || typeof window.Notification === 'undefined') return;

                const url         = meta.getAttribute('content');
                const badge       = document.getElementById('header-unread-badge');
                let lastSeenIds   = new Set();
                let lastUnread    = 0;

                function playBeep() {
                    try {
                        const Ctx = window.AudioContext || window.webkitAudioContext;
                        if (!Ctx) return;
                        const ctx = new Ctx();
                        const o = ctx.createOscillator();
                        const g = ctx.createGain();
                        o.type = 'sine';
                        o.frequency.value = 880;
                        g.gain.value = 0.03;
                        o.connect(g);
                        g.connect(ctx.destination);
                        o.start();
                        o.stop(ctx.currentTime + 0.12);
                        setTimeout(() => { try { ctx.close(); } catch (_) {} }, 500);
                    } catch (_) {}
                }

                async function requestPermissionIfNeeded() {
                    if (Notification.permission === 'default') {
                        try { await Notification.requestPermission(); } catch (_) {}
                    }
                }

                function updateBadge(count) {
                    if (!badge) return;
                    const n = parseInt(count || 0, 10);
                    if (n > 0) {
                        badge.textContent = n > 99 ? '99+' : String(n);
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }

                async function fetchAndNotify() {
                    try {
                        const res  = await fetch(url, { method: 'GET', credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
                        if (!res.ok) return;
                        const data = await res.json();
                        const unread   = parseInt(data.unread || 0, 10);
                        const msgs     = Array.isArray(data.messages) ? data.messages : [];
                        const curIds   = new Set(msgs.map(m => m.id));
                        const newMsgs  = msgs.filter(m => !lastSeenIds.has(m.id));

                        updateBadge(unread);

                        if ((unread > lastUnread) || newMsgs.length > 0) playBeep();

                        if (newMsgs.length > 0) {
                            await requestPermissionIfNeeded();
                            if (Notification.permission === 'granted') {
                                [...newMsgs].reverse().forEach(m => {
                                    try {
                                        const notif = new Notification(m.sender || 'New message', {
                                            body: m.body || 'You have a new message',
                                            tag: 'chat-' + m.conversation_id,
                                            renotify: true,
                                        });
                                        notif.onclick = function (ev) {
                                            ev.preventDefault();
                                            window.focus();
                                            window.location.href = '/chats/' + m.conversation_id;
                                            this.close();
                                        };
                                    } catch (_) {}
                                });
                            }
                        }

                        lastSeenIds = curIds;
                        lastUnread  = unread;
                    } catch (err) {
                        console.debug('chat notifications poll error', err);
                    }
                }

                fetchAndNotify();
                setInterval(fetchAndNotify, 10000);
            } catch (err) {
                console.debug('initChatNotifications failed', err);
            }
        })();

    }); // end DOMContentLoaded
    </script>

    @stack('scripts')
</body>
</html>