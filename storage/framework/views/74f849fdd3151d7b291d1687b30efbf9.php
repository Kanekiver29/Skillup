

<?php $__env->startSection('title', 'About SkillUp - Personalized Web Learning for Youth Career Development'); ?>

<?php $__env->startPush('head'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
<style>
    html { scroll-behavior: smooth; }

    :root {
        --about-ease:        cubic-bezier(0.22, 1, 0.36, 1);
        --about-ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
        --about-void:        #03060d;
        --about-navy-deep:   #050f1f;
        --about-navy:        #0a2540;
        --about-navy-mid:    #003a8f;
        --about-navy-light:  #1e4976;
        --about-sky:         #93c5fd;
        --about-gold:        #fdb913;
        --about-red:         #c1121f;
        --about-cyan:        #2fd8ff;
        --about-cyan-soft:   #a9edff;
        --about-cyan-dim:    #0ea5c7;
        --about-line:        rgba(47,216,255,0.16);
        --font-mono:         'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
        --font-display:      'Space Grotesk', ui-sans-serif, system-ui, sans-serif;
    }

    :focus-visible {
        outline: 3px solid rgba(47,216,255,0.85);
        outline-offset: 3px;
    }

    .font-hud {
        font-family: var(--font-mono);
        letter-spacing: 0.08em;
    }
    .font-display {
        font-family: var(--font-display);
        letter-spacing: -0.01em;
    }

    /* ══════════════════════════════════════
       SCROLL PROGRESS
    ══════════════════════════════════════ */
    .about-scroll-progress {
        position: fixed;
        top: 0; left: 0;
        height: 3px;
        width: 0%;
        background: linear-gradient(90deg, var(--about-cyan), var(--about-gold), var(--about-red));
        background-size: 200% 100%;
        animation: progressShimmer 3s linear infinite;
        z-index: 60;
        transition: width 80ms linear;
        box-shadow: 0 0 14px rgba(47,216,255,0.65);
    }
    @keyframes progressShimmer {
        0%   { background-position: 0% center; }
        100% { background-position: 200% center; }
    }

    /* ══════════════════════════════════════
       SCROLL ANIMATIONS
    ══════════════════════════════════════ */
    [data-animate] {
        opacity: 0;
        transform: translateY(32px);
        filter: blur(6px);
        will-change: transform, opacity, filter;
    }
    .animate-ready {
        animation: aboutFadeUp 0.85s var(--about-ease) forwards;
    }
    .delay-75  { animation-delay: 75ms; }
    .delay-100 { animation-delay: 100ms; }
    .delay-125 { animation-delay: 125ms; }
    .delay-150 { animation-delay: 150ms; }
    .delay-175 { animation-delay: 175ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-225 { animation-delay: 225ms; }
    .delay-250 { animation-delay: 250ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-350 { animation-delay: 350ms; }
    .delay-375 { animation-delay: 375ms; }
    .delay-400 { animation-delay: 400ms; }
    .delay-450 { animation-delay: 450ms; }
    .delay-500 { animation-delay: 500ms; }
    .delay-600 { animation-delay: 600ms; }

    @keyframes aboutFadeUp {
        0%   { opacity: 0; transform: translateY(32px) scale(0.97); filter: blur(6px); }
        100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    /* ══════════════════════════════════════
       HERO SECTION
    ══════════════════════════════════════ */
    .about-hero {
        background: radial-gradient(ellipse 160% 90% at 50% -12%, #06141f 0%, #081a33 18%, #0a2643 40%, #02060d 100%);
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        opacity: 0.05;
        mix-blend-mode: screen;
        pointer-events: none;
    }

    .about-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 15%, rgba(47,216,255,0.12), transparent 18%),
                    radial-gradient(circle at 80% 30%, rgba(253,185,19,0.08), transparent 16%);
        pointer-events: none;
    }

    /* Cursor-follow spotlight */
    .hero-spotlight {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0;
        transition: opacity 500ms var(--about-ease);
        background: radial-gradient(420px circle at var(--sx,50%) var(--sy,20%), rgba(47,216,255,0.12), transparent 60%);
    }
    .hero-spotlight.is-active { opacity: 1; }

    /* Circuit trace overlay */
    .hero-circuit {
        position: absolute; inset: 0;
        opacity: 0.55;
        pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cg fill='none' stroke='%232fd8ff' stroke-width='1' opacity='0.24'%3E%3Cpath d='M0 40 H60 V90 H140 V40 H200'/%3E%3Cpath d='M0 150 H50 V120 H120 V170 H200'/%3E%3Ccircle cx='60' cy='40' r='3' fill='%232fd8ff' stroke='none'/%3E%3Ccircle cx='140' cy='90' r='3' fill='%232fd8ff' stroke='none'/%3E%3Ccircle cx='50' cy='150' r='3' fill='%23fdb913' stroke='none'/%3E%3Ccircle cx='120' cy='170' r='3' fill='%23fdb913' stroke='none'/%3E%3C/g%3E%3C/svg%3E");
        background-size: 260px 260px;
    }

    /* Ambient radar sweep */
    .hero-radar {
        position: absolute;
        top: 50%; left: 50%;
        width: 1400px; height: 1400px;
        transform: translate(-50%,-50%);
        border-radius: 50%;
        background: conic-gradient(from 0deg, transparent 0%, rgba(47,216,255,0.08) 8%, transparent 16%);
        animation: radarSpin 10s linear infinite;
        pointer-events: none;
    }
    @keyframes radarSpin { to { transform: translate(-50%,-50%) rotate(360deg); } }

    /* Animated star field */
    .hero-stars {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }
    .hero-star {
        position: absolute;
        background: #fff;
        border-radius: 50%;
        animation: starTwinkle var(--dur,2s) ease-in-out infinite var(--delay,0s);
    }
    @keyframes starTwinkle {
        0%,100% { opacity:0.1; transform:scale(0.8); }
        50%      { opacity:0.8; transform:scale(1.3); }
    }

    /* Shooting star */
    .hero-shooting-star {
        position: absolute;
        top: 12%;
        left: -10%;
        width: 3px; height: 3px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 0 1px rgba(255,255,255,0.1);
        opacity: 0;
        animation: shootingStar 7s linear infinite;
        animation-delay: 2.5s;
        pointer-events: none;
    }
    .hero-shooting-star::before {
        content: '';
        position: absolute;
        top: 50%; right: 0;
        width: 90px; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.85));
        transform: translateY(-50%);
    }
    @keyframes shootingStar {
        0%   { opacity: 0; transform: translate(0,0); }
        3%   { opacity: 1; }
        14%  { opacity: 0; transform: translate(60vw, 22vh); }
        100% { opacity: 0; transform: translate(60vw, 22vh); }
    }

    /* Aurora orbs */
    .about-blob {
        position: absolute;
        border-radius: 9999px;
        filter: blur(48px);
        opacity: 0.35;
        animation: aboutBlob 14s ease-in-out infinite;
        pointer-events: none;
    }
    .about-blob-1 { width:26rem; height:26rem; background:rgba(0,58,143,0.55);  top:-6rem;  left:-6rem; }
    .about-blob-2 { width:28rem; height:28rem; background:rgba(47,216,255,0.16); top:4rem;  right:-8rem; animation-delay:2s; }
    .about-blob-3 { width:18rem; height:18rem; background:rgba(253,185,19,0.2); bottom:-4rem; left:20%; animation-delay:4s; }
    .about-blob-4 { width:14rem; height:14rem; background:rgba(193,18,31,0.16); top:40%; left:50%; animation-delay:6s; }

    @keyframes aboutBlob {
        0%,100% { transform: translate(0,0) scale(1); }
        33%      { transform: translate(16px,-18px) scale(1.07); }
        66%      { transform: translate(-10px,12px) scale(0.95); }
    }

    #hero-blobs {
        transition: transform 60ms linear;
        will-change: transform;
    }

    .about-hero-shine {
        position: absolute; inset: 0;
        background: linear-gradient(105deg, transparent 35%, rgba(47,216,255,0.07) 50%, transparent 65%);
        background-size: 200% 100%;
        animation: aboutShimmer 5s linear infinite;
        pointer-events: none;
    }
    @keyframes aboutShimmer {
        0%   { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .hero-grid {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
        background-size: 72px 72px;
        pointer-events: none;
    }

    .hero-constellation {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }
    .hero-constellation-line {
        position: absolute;
        height: 2px;
        background: rgba(47,216,255,0.18);
        filter: blur(0.6px);
        transform-origin: left center;
    }
    .hero-constellation-point {
        position: absolute;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.95);
        box-shadow: 0 0 12px rgba(47,216,255,0.45);
        animation: pulseGlow 4.2s ease-in-out infinite;
    }
    .hero-constellation-point:nth-child(1) { top: 14%; left: 12%; }
    .hero-constellation-point:nth-child(2) { top: 26%; left: 70%; }
    .hero-constellation-point:nth-child(3) { top: 52%; left: 18%; }
    .hero-constellation-point:nth-child(4) { top: 38%; left: 86%; }
    .hero-constellation-point:nth-child(5) { top: 68%; left: 56%; }

    @keyframes pulseGlow {
        0%,100% { opacity: 0.8; transform: scale(1); }
        50%      { opacity: 1; transform: scale(1.18); }
    }

    .hero-callout {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        background: rgba(47,216,255,0.08);
        border: 1px solid rgba(47,216,255,0.22);
        color: #d9f6ff;
        font-family: var(--font-mono);
        font-size: 0.8rem;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        border-radius: 999px;
        padding: 0.7rem 1rem;
        box-shadow: 0 0 18px rgba(47,216,255,0.1);
    }
    .hero-callout i {
        color: rgba(253,185,19,0.9);
    }

    /* ── Hero mini stat panels (single source of truth) ── */
    .hero-mini-stat {
        position: relative;
        border: 1px solid rgba(47,216,255,0.2);
        background: rgba(255,255,255,0.06);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.02), 0 18px 50px rgba(0,0,0,0.18);
        overflow: hidden;
    }
    .hero-mini-stat::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(47,216,255,0.18), transparent 32%);
        pointer-events: none;
    }
    .hero-mini-stat .mini-label {
        font-family: var(--font-mono);
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(179,224,255,0.82);
    }

    .hero-scroll-cue {
        position: absolute;
        left: 50%;
        bottom: 26px;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        color: rgba(169,237,255,0.65);
        font-size: 0.7rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        font-weight: 600;
        opacity: 0;
        transition: opacity 500ms var(--about-ease);
        pointer-events: none;
        z-index: 5;
    }
    .hero-scroll-cue.is-visible { opacity: 1; }
    .hero-scroll-cue i {
        animation: scrollCueBounce 1.8s ease-in-out infinite;
        font-size: 0.85rem;
    }
    @keyframes scrollCueBounce {
        0%,100% { transform: translateY(0);  opacity: 0.5; }
        50%      { transform: translateY(6px); opacity: 1;   }
    }

    /* ══════════════════════════════════════
       HUD BADGE / EYEBROW
    ══════════════════════════════════════ */
    .hud-badge {
        font-family: var(--font-mono);
        letter-spacing: 0.14em;
    }
    .hud-dot {
        position: relative;
        display: inline-flex;
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--about-cyan);
        box-shadow: 0 0 8px 2px rgba(47,216,255,0.8);
        animation: hudBlink 1.6s ease-in-out infinite;
    }
    @keyframes hudBlink { 0%,100% { opacity:1; } 50% { opacity:0.35; } }

    /* ══════════════════════════════════════
       HUD CUT-CORNER PANEL
    ══════════════════════════════════════ */
    .hud-panel {
        clip-path: polygon(14px 0, 100% 0, 100% calc(100% - 14px), calc(100% - 14px) 100%, 0 100%, 0 14px);
    }

    /* ══════════════════════════════════════
       HUD CORNER RETICLE (signature hover device)
    ══════════════════════════════════════ */
    .hud-corners { position: relative; }
    .hud-corners::before,
    .hud-corners::after {
        content: '';
        position: absolute;
        width: 16px; height: 16px;
        opacity: 0;
        transition: opacity 300ms var(--about-ease), transform 300ms var(--about-ease);
        pointer-events: none;
        z-index: 2;
    }
    .hud-corners::before {
        top: 8px; left: 8px;
        border-top: 2px solid var(--about-cyan);
        border-left: 2px solid var(--about-cyan);
        transform: translate(4px,4px);
    }
    .hud-corners::after {
        bottom: 8px; right: 8px;
        border-bottom: 2px solid var(--about-cyan);
        border-right: 2px solid var(--about-cyan);
        transform: translate(-4px,-4px);
    }
    .hud-corners:hover::before,
    .hud-corners:hover::after {
        opacity: 1;
        transform: translate(0,0);
    }

    /* ══════════════════════════════════════
       LOGO DISPLAY — CENTER COLUMN
    ══════════════════════════════════════ */
    .logo-display-wrap {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 200ms var(--about-ease);
        will-change: transform;
    }

    .logo-orbit {
        position: absolute;
        border-radius: 50%;
        border: 1px dashed rgba(47,216,255,0.28);
        animation: orbitSpin var(--ods, 20s) linear infinite var(--odir, normal);
        pointer-events: none;
    }
    @keyframes orbitSpin { to { transform: rotate(360deg); } }

    .orbit-dot {
        position: absolute;
        width: 8px; height: 8px;
        border-radius: 50%;
        top: -4px; left: calc(50% - 4px);
        box-shadow: 0 0 8px currentColor;
    }

    .logo-glow-ring {
        position: absolute;
        border-radius: 50%;
        animation: glowPulse 4s ease-in-out infinite;
        pointer-events: none;
    }
    @keyframes glowPulse {
        0%,100% { opacity:0.35; transform:scale(0.92); }
        50%      { opacity:0.75; transform:scale(1.05); }
    }

    /* Radar sweep behind logo */
    .logo-radar-sweep {
        position: absolute;
        inset: -34px;
        border-radius: 50%;
        background: conic-gradient(from 0deg, transparent 0%, rgba(47,216,255,0.25) 10%, transparent 22%);
        animation: radarSpin 4.5s linear infinite;
        pointer-events: none;
    }

    .logo-pulse-ring {
        position: absolute;
        border-radius: 50%;
        border: 2px solid rgba(47,216,255,0.35);
        animation: pulseExpand 3.5s ease-out infinite;
        pointer-events: none;
    }
    .logo-pulse-ring:nth-child(3) { animation-delay: 1.2s; border-color: rgba(253,185,19,0.32); }
    .logo-pulse-ring:nth-child(4) { animation-delay: 2.4s; border-color: rgba(193,18,31,0.22); }
    @keyframes pulseExpand {
        0%   { opacity:0.8; transform:scale(0.85); }
        70%  { opacity:0; transform:scale(1.35); }
        100% { opacity:0; transform:scale(1.35); }
    }

    /* Telemetry readouts near logo */
    .logo-telemetry {
        position: absolute;
        font-family: var(--font-mono);
        font-size: 10px;
        letter-spacing: 0.1em;
        color: var(--about-cyan-dim);
        white-space: nowrap;
        opacity: 0.85;
    }

    .about-logo-float {
        animation: logoFloat 5s ease-in-out infinite;
        filter: drop-shadow(0 24px 48px rgba(0,58,143,0.5)) drop-shadow(0 8px 20px rgba(0,0,0,0.3));
        transition: filter 0.4s ease;
    }
    .about-logo-float:hover {
        filter: drop-shadow(0 32px 64px rgba(0,58,143,0.7)) drop-shadow(0 0 40px rgba(47,216,255,0.5));
        animation-play-state: paused;
    }
    @keyframes logoFloat {
        0%,100% { transform: translateY(0) rotate(0deg) scale(1); }
        25%      { transform: translateY(-14px) rotate(0.8deg) scale(1.01); }
        75%      { transform: translateY(-7px) rotate(-0.5deg) scale(1.005); }
    }

    .logo-sparkle {
        position: absolute;
        pointer-events: none;
        animation: sparklePop var(--sd,3s) ease-in-out infinite var(--sdel,0s);
    }
    @keyframes sparklePop {
        0%,100% { opacity:0; transform:scale(0.3) rotate(0deg); }
        20%      { opacity:1; transform:scale(1.2) rotate(25deg); }
        40%      { opacity:0.6; transform:scale(0.8) rotate(10deg); }
        60%      { opacity:0; transform:scale(0.2) rotate(0deg); }
    }

    /* ══════════════════════════════════════
       GLASS CARD
    ══════════════════════════════════════ */
    .about-glass {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    /* ══════════════════════════════════════
       HOVER LIFT
    ══════════════════════════════════════ */
    .about-hover-lift {
        transition: transform 320ms var(--about-ease), box-shadow 320ms var(--about-ease), border-color 320ms var(--about-ease);
    }
    .about-hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 28px 60px rgba(10,37,64,0.16), 0 0 0 1px rgba(47,216,255,0.12);
    }

    /* Hexagon icon wrap */
    .about-icon-wrap.hex-icon {
        clip-path: polygon(25% 3%, 75% 3%, 100% 50%, 75% 97%, 25% 97%, 0% 50%);
        transition: transform 300ms var(--about-ease), filter 300ms var(--about-ease);
    }
    .about-value-card:hover .about-icon-wrap.hex-icon,
    .about-apart-card:hover .about-icon-wrap.hex-icon,
    .about-mentor-card:hover .about-icon-wrap.hex-icon {
        transform: translateY(-6px) scale(1.12) rotate(-3deg);
        filter: drop-shadow(0 12px 22px rgba(47,216,255,0.45));
    }

    /* Value card numbered badge */
    .value-num-badge {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        font-family: var(--font-mono);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        color: rgba(0,58,143,0.28);
        transition: color 300ms var(--about-ease), transform 300ms var(--about-ease);
    }
    .about-value-card:hover .value-num-badge {
        color: rgba(47,216,255,0.55);
        transform: translateY(-2px);
    }

    /* ══════════════════════════════════════
       3D TILT CARDS + CURSOR GLARE
    ══════════════════════════════════════ */
    .tilt-card {
        transform-style: preserve-3d;
        will-change: transform;
        transition: transform 220ms var(--about-ease), box-shadow 320ms var(--about-ease), border-color 320ms var(--about-ease);
    }
    .card-glare {
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        background: radial-gradient(circle at var(--mx, 50%) var(--my, 50%), rgba(47,216,255,0.16), transparent 55%);
        opacity: 0;
        transition: opacity 320ms var(--about-ease);
        z-index: 1;
    }
    .tilt-card:hover .card-glare { opacity: 1; }
    .about-apart-card,
    .about-link-card,
    .about-mentor-card,
    .about-value-card {
        position: relative;
        overflow: hidden;
    }

    /* ══════════════════════════════════════
       MISSION CARDS
    ══════════════════════════════════════ */
    .about-mission-card {
        transition: border-color 320ms var(--about-ease), box-shadow 320ms var(--about-ease);
        position: relative; overflow: hidden;
    }
    .about-mission-card::after {
        content: '';
        position: absolute; top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(47,216,255,0.05), transparent);
        transition: left 600ms var(--about-ease);
    }
    .about-mission-card:hover::after { left: 120%; }
    .about-mission-card:hover {
        border-color: #93c5fd;
        box-shadow: 0 24px 56px rgba(0,58,143,0.14), 0 0 0 1px rgba(47,216,255,0.1);
    }

    /* ══════════════════════════════════════
       STEP LINE
    ══════════════════════════════════════ */
    .about-step-connector {
        position: relative;
        background: linear-gradient(90deg,
            var(--about-navy-mid), var(--about-cyan),
            var(--about-gold), var(--about-red),
            var(--about-navy-mid));
        background-size: 200% 100%;
        animation: aboutShimmer 4s linear infinite;
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 1.4s var(--about-ease);
        overflow: visible;
    }
    .about-step-connector.is-drawn { transform: scaleX(1); }

    .data-flow-dot {
        position: absolute;
        top: 50%; left: 0;
        width: 10px; height: 10px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 12px 4px rgba(47,216,255,0.9);
        transform: translate(-50%,-50%);
        animation: dataFlow 3.2s linear infinite;
    }
    @keyframes dataFlow {
        0%   { left: 0%; opacity: 0; }
        8%   { opacity: 1; }
        92%  { opacity: 1; }
        100% { left: 100%; opacity: 0; }
    }

    .about-step-circle {
        transition: transform 340ms var(--about-ease), box-shadow 340ms var(--about-ease);
        clip-path: polygon(25% 3%, 75% 3%, 100% 50%, 75% 97%, 25% 97%, 0% 50%);
    }
    .about-step:hover .about-step-circle {
        transform: scale(1.12) rotate(-4deg);
        filter: drop-shadow(0 14px 28px rgba(47,216,255,0.45));
    }

    .about-timeline-dot {
        width: 12px; height: 12px;
        border-radius: 50%;
        background: var(--about-cyan);
        box-shadow: 0 0 0 4px rgba(47,216,255,0.2);
        margin: 0 auto 0.75rem;
        opacity: 0; transform: scale(0);
        transition: opacity 400ms var(--about-ease), transform 400ms var(--about-ease);
    }
    .about-step.is-visible .about-timeline-dot {
        opacity: 1; transform: scale(1);
    }

    /* ══════════════════════════════════════
       STAT CARDS — DARK HUD READOUTS
    ══════════════════════════════════════ */
    .about-stat-card {
        position: relative; overflow: hidden;
        background: linear-gradient(160deg, var(--about-navy-deep), var(--about-void));
        border: 1px solid rgba(47,216,255,0.16) !important;
    }
    .about-stat-card::before {
        content: '';
        position: absolute; top:0; left:0; right:0; height:3px;
        background: linear-gradient(90deg, var(--about-cyan), var(--about-gold));
        transform: scaleX(0); transform-origin: left;
        transition: transform 500ms var(--about-ease);
    }
    .about-stat-card:hover::before { transform: scaleX(1); }
    .about-stat-card::after {
        content: '';
        position: absolute; inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cg fill='none' stroke='%232fd8ff' stroke-width='1' opacity='0.12'%3E%3Cpath d='M0 30 H20 V10 H60'/%3E%3C/g%3E%3C/svg%3E");
        background-size: 60px 60px;
        pointer-events: none;
    }
    .about-stat-gradient {
        font-family: var(--font-mono);
        background: linear-gradient(135deg, var(--about-cyan-soft), var(--about-cyan));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-shadow: 0 0 24px rgba(47,216,255,0.35);
    }
    .about-stat-label { color: #eaf3ff; }
    .about-stat-sub { color: #7d93b8; }

    /* ══════════════════════════════════════
       MENTOR CARDS
    ══════════════════════════════════════ */
    .about-mentor-avatar {
        width: 64px; height: 64px;
        border-radius: 9999px;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
        position: relative;
        flex-shrink: 0;
        box-shadow: 0 10px 24px rgba(0,58,143,0.3);
    }
    .about-mentor-avatar::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 9999px;
        border: 1.5px dashed rgba(47,216,255,0.4);
        animation: orbitSpin 12s linear infinite;
    }
    .about-mentor-status {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-family: var(--font-mono);
        font-size: 0.68rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #16a34a;
    }
    .about-mentor-status span {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 6px 1px rgba(34,197,94,0.7);
        animation: hudBlink 2s ease-in-out infinite;
    }

    /* ══════════════════════════════════════
       MILESTONES / MISSION LOG
    ══════════════════════════════════════ */
    .milestone-rail {
        position: relative;
        padding-left: 2.5rem;
    }
    .milestone-rail::before {
        content: '';
        position: absolute;
        left: 9px; top: 6px; bottom: 6px;
        width: 2px;
        background: linear-gradient(180deg, var(--about-cyan), rgba(47,216,255,0.08));
    }
    .milestone-item {
        position: relative;
        padding-bottom: 2.75rem;
    }
    .milestone-item:last-child { padding-bottom: 0; }
    .milestone-node {
        position: absolute;
        left: -2.5rem;
        top: 0.15rem;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: var(--about-navy-deep);
        border: 2px solid var(--about-cyan);
        box-shadow: 0 0 0 4px rgba(47,216,255,0.12);
        display: flex; align-items: center; justify-content: center;
    }
    .milestone-node span {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--about-cyan);
        box-shadow: 0 0 8px 2px rgba(47,216,255,0.8);
    }
    .milestone-tag {
        font-family: var(--font-mono);
        font-size: 0.7rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--about-cyan-soft);
    }

    /* ══════════════════════════════════════
       FAQ ACCORDION
    ══════════════════════════════════════ */
    .faq-item {
        border: 1px solid rgba(15,23,42,0.08);
        border-radius: 1rem;
        background: #fff;
        overflow: hidden;
        transition: border-color 280ms var(--about-ease), box-shadow 280ms var(--about-ease);
    }
    .faq-item.is-open,
    .faq-item:hover {
        border-color: rgba(47,216,255,0.35);
        box-shadow: 0 14px 32px rgba(10,37,64,0.08);
    }
    .faq-trigger {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        text-align: left;
        background: transparent;
        cursor: pointer;
    }
    .faq-icon {
        flex-shrink: 0;
        width: 28px; height: 28px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #eef4ff;
        color: var(--about-navy-mid);
        transition: transform 320ms var(--about-ease), background 320ms var(--about-ease), color 320ms var(--about-ease);
    }
    .faq-item.is-open .faq-icon {
        transform: rotate(135deg);
        background: var(--about-navy-mid);
        color: #fff;
    }
    .faq-panel {
        max-height: 0;
        overflow: hidden;
        transition: max-height 420ms var(--about-ease);
    }
    .faq-panel-inner {
        padding: 0 1.5rem 1.5rem;
        color: #475569;
        font-size: 0.925rem;
        line-height: 1.6;
    }

    /* ══════════════════════════════════════
       CTA SECTION
    ══════════════════════════════════════ */
    .about-cta {
        background: radial-gradient(ellipse 120% 90% at 50% 110%, #0d2c56 0%, var(--about-navy-deep) 45%, var(--about-void) 100%);
        position: relative; overflow: hidden;
    }
    .about-cta-shimmer {
        background: linear-gradient(90deg, transparent, rgba(47,216,255,0.22), transparent);
        background-size: 200% 100%;
        animation: aboutShimmer 3.5s linear infinite;
    }

    /* ══════════════════════════════════════
       BUTTONS
    ══════════════════════════════════════ */
    .btn-about {
        transition: transform 220ms var(--about-ease), box-shadow 220ms var(--about-ease), filter 220ms var(--about-ease);
    }
    .btn-about:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 18px 44px rgba(47,216,255,0.3);
        filter: saturate(1.06);
    }
    .btn-about:active { transform: translateY(0) scale(0.99); }

    /* ══════════════════════════════════════
       MARQUEE — TERMINAL TICKER
    ══════════════════════════════════════ */
    @keyframes aboutMarquee {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .about-marquee-wrap {
        overflow: hidden;
        mask-image: linear-gradient(90deg, transparent, black 8%, black 92%, transparent);
    }
    .about-marquee-track {
        display: flex; width: max-content;
        animation: aboutMarquee 28s linear infinite;
    }
    .about-marquee-track:hover { animation-play-state: paused; }
    .about-marquee-item {
        flex-shrink: 0;
        padding: 0 1.25rem;
        font-family: var(--font-mono);
        font-size: 0.8rem; font-weight: 600;
        letter-spacing: 0.04em;
        color: var(--about-cyan-soft);
        white-space: nowrap;
        transition: color 200ms var(--about-ease);
    }
    .about-marquee-item:hover { color: var(--about-gold); }

    /* ══════════════════════════════════════
       QUOTE / LINK CARDS
    ══════════════════════════════════════ */
    .about-quote-card { border-left: 4px solid var(--about-cyan-dim); }

    .about-link-card {
        transition: transform 280ms var(--about-ease), box-shadow 280ms var(--about-ease), border-color 280ms var(--about-ease);
    }
    .about-link-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 48px rgba(0,58,143,0.15);
        border-color: #93c5fd;
    }
    .about-link-card:hover i.fa-arrow-right { transform: translateX(4px); }
    .about-link-card i.fa-arrow-right { transition: transform 280ms var(--about-ease); }

    /* ══════════════════════════════════════
       PILL NAV
    ══════════════════════════════════════ */
    .about-pill-nav a {
        position: relative;
        transition: color 200ms ease, background 200ms ease, transform 200ms var(--about-ease);
    }
    .about-pill-nav a::after {
        content: '';
        position: absolute; left:50%; bottom:-2px;
        width:0; height:2px;
        background: var(--about-cyan); border-radius:2px;
        transform: translateX(-50%);
        transition: width 250ms var(--about-ease);
        box-shadow: 0 0 8px rgba(47,216,255,0.7);
    }
    .about-pill-nav a:hover { background: rgba(255,255,255,0.12); transform: translateY(-2px); }
    .about-pill-nav a:hover::after { width:60%; }
    .about-pill-nav a.is-active {
        background: rgba(255,255,255,0.16);
        color: #fff;
    }
    .about-pill-nav a.is-active::after { width:60%; }

    /* ══════════════════════════════════════
       BADGE (single source of truth — used on light sections)
    ══════════════════════════════════════ */
    .about-badge {
        background: linear-gradient(135deg, #e8eef8, #f0f4fa);
        border: 1px solid #d1d9e2;
        color: var(--about-navy);
        box-shadow: 0 10px 30px rgba(0,21,44,0.06);
    }

    .stat-number { display: inline-block; }

    /* ══════════════════════════════════════
       BACK TO TOP — HEX
    ══════════════════════════════════════ */
    .about-back-to-top {
        position: fixed;
        right: 22px;
        bottom: 22px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--about-navy-mid), var(--about-navy));
        color: #fff;
        border: 1px solid rgba(47,216,255,0.4);
        clip-path: polygon(25% 3%, 75% 3%, 100% 50%, 75% 97%, 25% 97%, 0% 50%);
        opacity: 0;
        transform: translateY(16px) scale(0.85);
        pointer-events: none;
        transition: opacity 320ms var(--about-ease), transform 320ms var(--about-ease), filter 320ms var(--about-ease);
        z-index: 55;
        cursor: pointer;
        filter: drop-shadow(0 10px 22px rgba(10,37,64,0.4));
    }
    .about-back-to-top.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }
    .about-back-to-top:hover {
        filter: drop-shadow(0 12px 26px rgba(47,216,255,0.55));
        transform: translateY(-4px) scale(1.05);
    }
    .about-back-to-top:focus-visible {
        outline-offset: 4px;
    }

    /* ══════════════════════════════════════
       REDUCED MOTION
    ══════════════════════════════════════ */
    @media (prefers-reduced-motion: reduce) {
        html { scroll-behavior: auto; }
        .about-scroll-progress { display:none; }
        [data-animate], .about-blob, .about-logo-float,
        .logo-orbit, .logo-glow-ring, .logo-pulse-ring, .logo-radar-sweep,
        .logo-sparkle, .about-hero-shine, .about-step-connector,
        .about-cta-shimmer, .about-marquee-track, .hero-star,
        .hero-scroll-cue i, .hero-radar, .hud-dot, .data-flow-dot,
        .hero-shooting-star, .about-mentor-avatar::after, .about-mentor-status span {
            opacity:1 !important;
            transform:none !important;
            filter:none !important;
            animation:none !important;
        }
        .about-step-connector { transform: scaleX(1) !important; }
        .about-hover-lift:hover, .btn-about:hover, .tilt-card:hover { transform: none; }
        .hero-scroll-cue { display: none; }
        .about-hero::before { display: none; }
        .data-flow-dot { display: none; }
        .hero-spotlight { display: none; }
        .faq-panel { transition: none; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="about-scroll-progress" id="about-scroll-progress" aria-hidden="true"></div>

    
    <section id="about-hero" class="about-hero pt-32 pb-28 px-4 text-white">

        <div class="hero-radar" aria-hidden="true"></div>
        <div class="hero-stars" id="hero-stars" aria-hidden="true"></div>
        <div class="hero-shooting-star" aria-hidden="true"></div>
        <div class="hero-circuit" aria-hidden="true"></div>
        <div class="hero-grid" aria-hidden="true"></div>
        <div class="hero-spotlight" id="hero-spotlight" aria-hidden="true"></div>
        <div class="hero-constellation" aria-hidden="true">
            <span class="hero-constellation-point"></span>
            <span class="hero-constellation-point"></span>
            <span class="hero-constellation-point"></span>
            <span class="hero-constellation-point"></span>
            <span class="hero-constellation-point"></span>
            <span class="hero-constellation-line" style="top: 16%; left: 14%; width: 20%; transform: rotate(18deg);"></span>
            <span class="hero-constellation-line" style="top: 28%; left: 72%; width: 23%; transform: rotate(-24deg);"></span>
            <span class="hero-constellation-line" style="top: 54%; left: 20%; width: 28%; transform: rotate(6deg);"></span>
            <span class="hero-constellation-line" style="top: 40%; left: 88%; width: 18%; transform: rotate(134deg);"></span>
            <span class="hero-constellation-line" style="top: 70%; left: 58%; width: 22%; transform: rotate(-12deg);"></span>
        </div>

        <div class="absolute inset-0 overflow-hidden pointer-events-none" id="hero-blobs" aria-hidden="true">
            <div class="about-blob about-blob-1"></div>
            <div class="about-blob about-blob-2"></div>
            <div class="about-blob about-blob-3"></div>
            <div class="about-blob about-blob-4"></div>
        </div>
        <div class="about-hero-shine" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(47,216,255,0.1),transparent_55%)]" aria-hidden="true"></div>

        <div class="max-w-6xl mx-auto text-center relative z-10">
            <nav data-animate class="text-slate-300 text-sm mb-8" aria-label="Breadcrumb">
                <a href="<?php echo e(url('/')); ?>" class="hover:text-white transition-colors underline underline-offset-2">Home</a>
                <span class="mx-2 opacity-50" aria-hidden="true">/</span>
                <span class="text-white font-medium" aria-current="page">About</span>
            </nav>

            <span data-animate class="delay-75 hud-badge inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full bg-white/10 border border-cyan-300/25 text-xs font-semibold backdrop-blur-md mb-6 shadow-lg uppercase">
                <span class="hud-dot" aria-hidden="true"></span>
                OIF · SkillUp — system online
            </span>

            <h1 data-animate class="delay-100 font-display text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight tracking-tight">
                About <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 via-sky-100 to-white" style="filter: drop-shadow(0 0 22px rgba(47,216,255,0.35));">SkillUp</span>
            </h1>

            <p data-animate class="delay-150 text-xl md:text-2xl text-slate-200 mb-4 max-w-3xl mx-auto leading-snug font-medium">
                Personalized web learning for youth career development
            </p>
            <p data-animate class="delay-200 text-slate-300/90 max-w-4xl mx-auto text-lg leading-relaxed">
                We believe every young person deserves to discover their potential, develop in-demand skills,
                and build a fulfilling career — with technology, mentorship, and real opportunities.
            </p>
            <div data-animate class="delay-225 hero-callout mt-8 mx-auto max-w-[26rem] justify-center">
                <i class="fas fa-location-arrow"></i>
                <span>Launch your future through a skill galaxy built for the next generation.</span>
            </div>

            <nav data-animate class="delay-250 about-pill-nav font-display mt-10 flex flex-wrap justify-center gap-2 text-sm" aria-label="About section navigation">
                <a href="#mission-vision" class="px-4 py-2 rounded-full border border-white/25 text-slate-200">Mission</a>
                <a href="#values"         class="px-4 py-2 rounded-full border border-white/25 text-slate-200">Values</a>
                <a href="#mentors"        class="px-4 py-2 rounded-full border border-white/25 text-slate-200">Mentors</a>
                <a href="#impact"         class="px-4 py-2 rounded-full border border-white/25 text-slate-200">Impact</a>
                <a href="#journey"        class="px-4 py-2 rounded-full border border-white/25 text-slate-200">How it works</a>
                <a href="#faq"            class="px-4 py-2 rounded-full border border-white/25 text-slate-200">FAQ</a>
            </nav>

            <div data-animate class="delay-300 mt-10 flex flex-wrap justify-center gap-4">
                <a href="#mission-vision" class="btn-about font-display inline-flex items-center justify-center bg-white text-[#0a2540] px-8 py-3.5 rounded-xl font-bold shadow-xl">
                    Our story <i class="fas fa-arrow-down ml-2 text-sm opacity-70"></i>
                </a>
                <a href="<?php echo e(route('courses.index')); ?>" class="btn-about font-display inline-flex items-center justify-center border-2 border-white/80 px-8 py-3.5 rounded-xl font-bold hover:bg-white hover:text-[#0a2540] transition-colors">
                    Explore courses <i class="fas fa-book-open ml-2 text-sm opacity-80"></i>
                </a>
            </div>

            
            <div data-animate class="delay-400 mt-14 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto">
                <?php $__currentLoopData = [
                    ['50+', 'Career paths'],
                    ['AI',  'Personalized'],
                    ['Mentors', 'Industry guides'],
                    ['Certs', 'Skill proof'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="hero-mini-stat hud-panel about-hover-lift rounded-3xl px-5 py-5">
                        <div class="flex items-center gap-2 mb-3 text-cyan-100/90">
                            <span class="w-2 h-2 rounded-full bg-cyan-200 shadow-[0_0_18px_rgba(47,216,255,0.35)]"></span>
                            <span class="text-xs uppercase tracking-[0.22em] font-semibold">Nova signal</span>
                        </div>
                        <p class="font-display text-2xl font-bold"><?php echo e($s[0]); ?></p>
                        <p class="mini-label text-[11px] uppercase text-cyan-100/70 mt-2"><?php echo e($s[1]); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="hero-scroll-cue" id="hero-scroll-cue" aria-hidden="true">
            <span class="font-hud">Scroll</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    
    <section class="py-5 border-y border-cyan-500/10" style="background: var(--about-void);" aria-label="Focus areas">
        <div class="about-marquee-wrap max-w-full">
            <div class="about-marquee-track">
                <?php
                    $tags = ['Web Development','Digital Marketing','Healthcare','Tourism','Entrepreneurship','Data Science','Renewable Energy','Maritime','Soft Skills','Career Roadmaps','AI Tutor','Certificates','Mentorship','Internships'];
                ?>
                <?php $__currentLoopData = array_merge($tags,$tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="about-marquee-item">[ <?php echo e($tag); ?> ]</span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section id="mission-vision" class="py-24 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span data-animate class="about-badge font-hud inline-block text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase">
                    Who we are
                </span>
                <h2 data-animate class="delay-100 font-display text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Mission, vision &amp; commitment
                </h2>
                <p data-animate class="delay-150 text-gray-600 max-w-2xl mx-auto">
                    TESDA sets direction, promulgates relevant standards, and implements programs geared towards quality-assured and inclusive technical education, skills development, and certification.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-6 items-stretch mb-16">

                
                <div data-animate class="delay-100 about-mission-card hud-corners about-glass about-hover-lift rounded-2xl shadow-md border border-slate-200/80 p-8 h-full">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-5 about-icon-wrap hex-icon">
                        <i class="fas fa-bullseye text-[#003a8f] text-xl"></i>
                    </div>
                    <h3 class="font-display text-2xl font-bold text-gray-800 mb-4">Our mission</h3>
                    <p class="text-gray-700 leading-relaxed mb-4 text-sm">
                        TESDA sets direction, promulgates relevant standards, and implements programs geared towards quality-assured and inclusive technical education, skills development, and certification.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-sm">
                        We support a learning ecosystem that builds demonstrated competence, strengthens institutional integrity, and empowers individuals with the skills needed for the Filipino workforce.
                    </p>
                </div>

                
                <div data-animate class="delay-200 flex flex-col items-center justify-center py-6 lg:py-0">
                    <h2 class="font-display text-center text-[#0a2540] font-bold text-2xl md:text-3xl">SkillUp</h2>
                    <p class="text-center text-gray-500 text-sm md:text-base mt-1.5 mb-10">Personalized learning for<br>career success</p>

                    <div class="logo-display-wrap" id="logo-display-wrap" style="width:280px; height:280px;">

                        <div class="logo-radar-sweep" aria-hidden="true"></div>
                        <div class="logo-glow-ring" style="inset:-30px; background:radial-gradient(circle, rgba(47,216,255,0.16) 0%, transparent 70%);"></div>

                        <div class="logo-pulse-ring" style="inset:-20px;"></div>
                        <div class="logo-pulse-ring" style="inset:-30px;"></div>
                        <div class="logo-pulse-ring" style="inset:-40px;"></div>

                        <div class="logo-orbit" style="inset:-45px; --ods:18s;">
                            <div class="orbit-dot bg-[#2fd8ff] text-[#2fd8ff]"></div>
                        </div>

                        <div class="logo-orbit" style="inset:-65px; --ods:28s; --odir:reverse; border-color:rgba(253,185,19,0.22);">
                            <div class="orbit-dot bg-[#fdb913] text-[#fdb913]" style="top:-4px;left:calc(50% - 4px);"></div>
                            <div class="orbit-dot bg-[#c1121f] text-[#c1121f]" style="bottom:-4px;top:auto;left:calc(50% - 4px);"></div>
                        </div>

                        <div class="logo-orbit" style="inset:-85px; --ods:38s; border-color:rgba(47,216,255,0.14);">
                            <div class="orbit-dot bg-white/60" style="width:5px;height:5px;top:-2.5px;left:calc(50%-2.5px);"></div>
                        </div>

                        <span class="logo-telemetry hidden lg:block" style="top:-8px; left:-96px;" aria-hidden="true">TRAJ · CAREER LAUNCH</span>
                        <span class="logo-telemetry hidden lg:block" style="bottom:-6px; right:-104px;" aria-hidden="true">STATUS · READY</span>

                        <svg class="logo-sparkle" style="width:18px;height:18px;top:10px;right:25px;--sd:2.8s;--sdel:0s;" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                            <path d="M9 0L10.5 7L17.5 7L12 11.5L14 18L9 14L4 18L6 11.5L0.5 7L7.5 7Z" fill="#fdb913"/>
                        </svg>
                        <svg class="logo-sparkle" style="width:12px;height:12px;top:40px;left:20px;--sd:3.5s;--sdel:0.8s;" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M7 0L7.9 5.5L13.3 5.5L9 8.8L10.4 14L7 10.8L3.6 14L5 8.8L0.7 5.5L6.1 5.5Z" fill="#2fd8ff"/>
                        </svg>
                        <svg class="logo-sparkle" style="width:10px;height:10px;bottom:30px;right:30px;--sd:4s;--sdel:1.6s;" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M7 0L7.9 5.5L13.3 5.5L9 8.8L10.4 14L7 10.8L3.6 14L5 8.8L0.7 5.5L6.1 5.5Z" fill="#003a8f"/>
                        </svg>
                        <svg class="logo-sparkle" style="width:8px;height:8px;bottom:50px;left:35px;--sd:3.2s;--sdel:2.2s;" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                            <path d="M7 0L7.9 5.5L13.3 5.5L9 8.8L10.4 14L7 10.8L3.6 14L5 8.8L0.7 5.5L6.1 5.5Z" fill="#fdb913"/>
                        </svg>

                        <img
                            src="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>"
                            alt="SkillUp — TESDA rocket logo"
                            loading="lazy"
                            decoding="async"
                            class="about-logo-float relative z-10 max-w-full object-contain"
                            style="width:220px; height:220px;"
                        >
                    </div>

                    <p data-animate class="delay-350 mt-8 text-center text-sm text-gray-500 max-w-xs leading-relaxed">
                        A program of <strong class="text-[#003a8f]">OIF</strong> — opening doors for the next generation of professionals.
                    </p>

                    
                    <div data-animate class="delay-375 mt-6 flex items-center justify-center gap-6 flex-wrap">
                        <img
                            src="<?php echo e(asset('image/logo%20new.jpg')); ?>"
                            alt="Partner logo"
                            loading="lazy"
                            decoding="async"
                            class="h-12 w-auto object-contain opacity-90"
                        >
                        <img
                            src="<?php echo e(asset('image/hello.png')); ?>"
                            alt="Partner logo"
                            loading="lazy"
                            decoding="async"
                            class="h-12 w-auto object-contain opacity-90"
                        >
                        <img
                            src="<?php echo e(asset('image/bagong-pilipinas-logo-png_seeklogo-534301.png')); ?>"
                            alt="Bagong Pilipinas logo"
                            loading="lazy"
                            decoding="async"
                            class="h-12 w-auto object-contain opacity-90"
                        >
                    </div>

                    <div class="mt-5 flex gap-1 justify-center" aria-hidden="true">
                        <div class="w-12 h-1.5 rounded-full bg-[#003a8f]"></div>
                        <div class="w-12 h-1.5 rounded-full bg-[#c1121f]"></div>
                        <div class="w-8 h-1.5 rounded-full bg-[#fdb913]"></div>
                    </div>
                </div>

                
                <div data-animate class="delay-300 about-mission-card hud-corners about-glass about-hover-lift rounded-2xl shadow-md border border-slate-200/80 p-8 h-full">
                    <div class="w-12 h-12 bg-sky-50 rounded-xl flex items-center justify-center mb-5 about-icon-wrap hex-icon">
                        <i class="fas fa-eye text-[#1e4976] text-xl"></i>
                    </div>
                    <h3 class="font-display text-2xl font-bold text-gray-800 mb-4">Our vision</h3>
                    <p class="text-gray-700 leading-relaxed text-sm mb-6">
                        Leader in the technical education and skills development of the Filipino workforce.
                    </p>
                </div>
            </div>

            
            <div data-animate class="delay-150 hud-corners rounded-3xl p-8 lg:p-12 border border-[#003a8f]/15 bg-gradient-to-r from-slate-50 via-blue-50/40 to-slate-50 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-[#2fd8ff]/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4" aria-hidden="true"></div>
                <div class="grid gap-10 lg:grid-cols-[280px_1fr] items-start relative">
                    <div class="space-y-6">
                        <div class="w-24 h-24 hud-panel flex items-center justify-center shadow-lg about-hover-lift rounded-3xl" style="background: linear-gradient(135deg, #003a8f, #0a2540);">
                            <i class="fas fa-shield-alt text-white text-3xl"></i>
                        </div>
                        <div class="space-y-3">
                            <h3 class="font-display text-3xl lg:text-4xl font-bold text-gray-900">Values Statements</h3>
                            <p class="text-gray-700 text-base leading-relaxed tracking-tight">
                                We believe in demonstrated competence, institutional integrity, personal commitment, a culture of innovativeness, and a deep sense of nationalism.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-6">
                        <div class="rounded-3xl bg-white/95 p-6 border border-slate-200 shadow-sm">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-display text-xl font-bold text-gray-900">Quality Policy</h4>
                                    <p class="text-sm text-slate-500 mt-1">Our promise to customers and stakeholders.</p>
                                </div>
                                <div class="w-12 h-12 rounded-3xl bg-[#003a8f] grid place-items-center text-white shadow-md">
                                    <i class="fas fa-award"></i>
                                </div>
                            </div>
                            <p class="mt-5 text-gray-700 leading-relaxed">
                                "We measure our worth by the satisfaction of the customers we serve."
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 p-6 border border-slate-200 shadow-sm">
                            <p class="text-gray-700 leading-relaxed">
                                To achieve this, we commit to comply with applicable requirements and continually improve our systems and processes.
                            </p>
                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <?php $__currentLoopData = [
                                    'Strategic decisions',
                                    'Effectiveness',
                                    'Responsiveness',
                                    'Value-added performance',
                                    'Integrity',
                                    'Citizen focus',
                                    'Efficiency',
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start gap-3">
                                        <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-[#003a8f] text-white text-xs font-semibold">✓</span>
                                        <span class="text-sm text-gray-700 leading-relaxed"><?php echo e($policy); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-16 px-4 bg-slate-50/90">
        <div class="max-w-4xl mx-auto">
            <div data-animate class="about-glass about-quote-card about-hover-lift rounded-2xl p-8 md:p-10 shadow-md border border-white/90">
                <div class="flex gap-1 text-amber-400 mb-4 text-sm">
                    <?php for($i=0;$i<5;$i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                </div>
                <blockquote class="text-lg md:text-xl text-gray-700 leading-relaxed font-medium italic">
                    "SkillUp helped me find a clear path from school to a real job. The courses felt personal, and the roadmap kept me on track every week."
                </blockquote>
                <footer class="mt-6 flex items-center gap-4">
                    <div class="font-display w-12 h-12 rounded-full bg-gradient-to-br from-[#003a8f] to-[#0a2540] flex items-center justify-center text-white font-bold text-sm">JL</div>
                    <div>
                        <p class="font-semibold text-gray-800">Learner community</p>
                        <p class="text-sm text-gray-500 font-hud">[ verified · career development track ]</p>
                    </div>
                </footer>
            </div>
        </div>
    </section>

    
    <section id="values" class="py-24 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span data-animate class="about-badge font-hud inline-block text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase">What we stand for</span>
                <h2 data-animate class="delay-100 font-display text-3xl md:text-4xl font-bold text-gray-800">Our core values</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                    $values = [
                        ['icon'=>'fa-heart',          'bg'=>'bg-blue-50',    'text'=>'text-[#003a8f]',   'title'=>'Empowerment',  'desc'=>'We believe in empowering youth to take control of their own career destiny through knowledge, skills, and confidence.'],
                        ['icon'=>'fa-hands-helping',  'bg'=>'bg-sky-50',     'text'=>'text-[#1e4976]',   'title'=>'Inclusivity',  'desc'=>"Everyone deserves access to quality career education. We're committed to removing barriers and serving diverse communities."],
                        ['icon'=>'fa-lightbulb',      'bg'=>'bg-amber-50',   'text'=>'text-amber-600',   'title'=>'Innovation',   'desc'=>'We continuously evolve our platform with the latest technology and educational best practices to deliver cutting-edge learning.'],
                        ['icon'=>'fa-handshake',      'bg'=>'bg-emerald-50', 'text'=>'text-emerald-700', 'title'=>'Integrity',    'desc'=>'We operate with transparency and honesty, always putting your best interests at the center of everything we do.'],
                        ['icon'=>'fa-chart-line',     'bg'=>'bg-red-50',     'text'=>'text-[#c1121f]',   'title'=>'Excellence',   'desc'=>"We're committed to delivering exceptional quality in everything—from content to mentorship to career placements."],
                        ['icon'=>'fa-users',          'bg'=>'bg-slate-100',  'text'=>'text-[#0a2540]',   'title'=>'Community',    'desc'=>'We foster a supportive ecosystem where learners, mentors, and employers collaborate and grow together.'],
                    ];
                    $vd = ['delay-100','delay-150','delay-200','delay-100','delay-150','delay-200'];
                ?>

                <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-animate class="<?php echo e($vd[$i]); ?> about-value-card hud-corners about-glass about-hover-lift p-8 rounded-2xl shadow-md border border-slate-200/70 group relative">
                        <span class="value-num-badge" aria-hidden="true"><?php echo e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                        <div class="about-icon-wrap hex-icon w-14 h-14 <?php echo e($v['bg']); ?> flex items-center justify-center mb-5">
                            <i class="fas <?php echo e($v['icon']); ?> <?php echo e($v['text']); ?> text-2xl"></i>
                        </div>
                        <h3 class="font-display text-xl font-bold mb-3 text-gray-800"><?php echo e($v['title']); ?></h3>
                        <p class="text-gray-600 leading-relaxed text-sm"><?php echo e($v['desc']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="py-24 px-4 bg-gradient-to-b from-slate-50 to-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span data-animate class="about-badge font-hud inline-block text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase">Our edge</span>
                <h2 data-animate class="delay-100 font-display text-3xl md:text-4xl font-bold text-gray-800">What sets SkillUp apart</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php
                    $apart = [
                        ['icon'=>'fa-robot',         'bg'=>'bg-blue-50',    'text'=>'text-[#003a8f]',   'title'=>'AI-powered personalization',  'desc'=>'Advanced algorithms analyze your learning style, pace, and goals to recommend the perfect learning path—no cookie-cutter approach.'],
                        ['icon'=>'fa-user-graduate',  'bg'=>'bg-sky-50',     'text'=>'text-[#1e4976]',   'title'=>'Expert mentorship',            'desc'=>'Learn from industry professionals who provide personalized guidance, feedback, and career advice beyond what courses alone can offer.'],
                        ['icon'=>'fa-briefcase',      'bg'=>'bg-amber-50',   'text'=>'text-amber-600',   'title'=>'Employment focused',           'desc'=>'Every learning path is designed with employment outcomes in mind. We connect you with internships and opportunities that match your skills.'],
                        ['icon'=>'fa-globe',          'bg'=>'bg-emerald-50', 'text'=>'text-emerald-700', 'title'=>'Global community',             'desc'=>'Join youth on similar career journeys, share experiences, and build your professional network across regions.'],
                    ];
                    $ad = ['delay-100','delay-200','delay-100','delay-200'];
                ?>
                <?php $__currentLoopData = $apart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-animate class="<?php echo e($ad[$i]); ?> about-apart-card hud-corners about-glass about-hover-lift p-8 rounded-2xl shadow-md border border-slate-200/70 group">
                        <div class="flex items-start gap-5">
                            <div class="about-icon-wrap hex-icon w-14 h-14 <?php echo e($item['bg']); ?> flex items-center justify-center shrink-0">
                                <i class="fas <?php echo e($item['icon']); ?> <?php echo e($item['text']); ?> text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-display text-xl font-bold mb-2 text-gray-800"><?php echo e($item['title']); ?></h3>
                                <p class="text-gray-600 leading-relaxed text-sm"><?php echo e($item['desc']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section id="mentors" class="py-24 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span data-animate class="about-badge font-hud inline-block text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase">Your guides</span>
                <h2 data-animate class="delay-100 font-display text-3xl md:text-4xl font-bold text-gray-800">Meet the mentor network</h2>
                <p data-animate class="delay-150 text-gray-600 max-w-2xl mx-auto mt-4">
                    Real professionals, not just recorded lessons. Mentors join live sessions, review your work, and help you plan the next step.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                    $mentors = [
                        ['initials'=>'MR', 'grad'=>'from-[#003a8f] to-[#0a2540]', 'name'=>'Software & Web Development', 'role'=>'Full-stack engineering track', 'desc'=>'Guides learners through real project builds, code reviews, and interview preparation.'],
                        ['initials'=>'DM', 'grad'=>'from-[#0ea5c7] to-[#003a8f]', 'name'=>'Digital Marketing', 'role'=>'Growth & content track', 'desc'=>'Coaches campaign strategy, analytics, and portfolio-ready case studies.'],
                        ['initials'=>'HC', 'grad'=>'from-[#c1121f] to-[#7a0d15]', 'name'=>'Healthcare Support', 'role'=>'Allied health track', 'desc'=>'Shares clinical-adjacent skills, certification prep, and workplace readiness tips.'],
                    ];
                    $md = ['delay-100','delay-200','delay-300'];
                ?>
                <?php $__currentLoopData = $mentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-animate class="<?php echo e($md[$i]); ?> about-mentor-card hud-corners about-glass about-hover-lift p-7 rounded-2xl shadow-md border border-slate-200/70">
                        <div class="flex items-center gap-4 mb-5">
                            <div class="about-mentor-avatar bg-gradient-to-br <?php echo e($m['grad']); ?>"><?php echo e($m['initials']); ?></div>
                            <div>
                                <h3 class="font-display font-bold text-gray-800 leading-tight"><?php echo e($m['name']); ?></h3>
                                <p class="text-xs text-gray-500 mt-0.5"><?php echo e($m['role']); ?></p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed mb-4"><?php echo e($m['desc']); ?></p>
                        <span class="about-mentor-status"><span aria-hidden="true"></span> Available for mentorship</span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section id="impact" class="py-24 px-4 bg-gradient-to-b from-slate-50 to-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span data-animate class="font-hud inline-block bg-amber-50 text-amber-900 text-xs font-semibold px-4 py-1.5 rounded-full mb-4 border border-amber-100 uppercase">By the numbers</span>
                <h2 data-animate class="delay-100 font-display text-3xl md:text-4xl font-bold text-gray-800">Our impact</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php
                    $stats = [
                        ['value'=>10000, 'suffix'=>'+',  'label'=>'Active learners',   'sub'=>'Youth pursuing career goals',   'display'=>'10K+'],
                        ['value'=>500,   'suffix'=>'+',  'label'=>'Learning paths',    'sub'=>'Diverse career options',        'display'=>'500+'],
                        ['value'=>2000,  'suffix'=>'+',  'label'=>'Placements',        'sub'=>'Jobs & internships secured',    'display'=>'2K+'],
                        ['value'=>4.8,   'suffix'=>'★',  'label'=>'User rating',       'sub'=>'Satisfaction & trust',         'display'=>'4.8★', 'decimal'=>true],
                    ];
                    $sd = ['delay-100','delay-150','delay-200','delay-250'];
                ?>
                <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-animate class="<?php echo e($sd[$i]); ?> about-stat-card hud-corners about-hover-lift p-6 md:p-8 rounded-2xl shadow-md text-center">
                        <p class="font-display text-3xl md:text-4xl font-bold about-stat-gradient mb-2 stat-number relative z-10"
                           data-count="<?php echo e($stat['value']); ?>"
                           data-suffix="<?php echo e($stat['suffix']); ?>"
                           <?php if(!empty($stat['decimal'])): ?> data-decimal="1" <?php endif; ?>>
                            <?php echo e($stat['display']); ?>

                        </p>
                        <p class="about-stat-label font-semibold text-sm md:text-base relative z-10"><?php echo e($stat['label']); ?></p>
                        <p class="about-stat-sub text-xs mt-1 relative z-10 font-hud"><?php echo e($stat['sub']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="mt-20 grid lg:grid-cols-[280px_1fr] gap-10 items-start">
                <div data-animate>
                    <span class="about-badge font-hud inline-block text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase">Mission log</span>
                    <h3 class="font-display text-2xl md:text-3xl font-bold text-gray-800 mb-3">How SkillUp got here</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">A short flight log of the milestones that shaped the platform learners use today.</p>
                </div>
                <div data-animate class="delay-100 milestone-rail">
                    <?php
                        $milestones = [
                            ['tag'=>'Phase 01', 'title'=>'Program founded under OIF', 'desc'=>'SkillUp launched as a TESDA-aligned initiative to connect youth with career-ready skills training.'],
                            ['tag'=>'Phase 02', 'title'=>'First learning paths published', 'desc'=>'Web development, digital marketing, and healthcare support tracks opened to early learners.'],
                            ['tag'=>'Phase 03', 'title'=>'AI-guided roadmaps introduced', 'desc'=>'Personalized recommendations began matching learners to paths based on goals and pace.'],
                            ['tag'=>'Phase 04', 'title'=>'Mentor network & placements', 'desc'=>'Industry mentors joined the platform, and learners began securing internships and jobs.'],
                        ];
                    ?>
                    <?php $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="milestone-item">
                            <div class="milestone-node" aria-hidden="true"><span></span></div>
                            <p class="milestone-tag mb-1"><?php echo e($ms['tag']); ?></p>
                            <h4 class="font-display font-bold text-gray-800 mb-1.5"><?php echo e($ms['title']); ?></h4>
                            <p class="text-gray-600 text-sm leading-relaxed max-w-xl"><?php echo e($ms['desc']); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>

    
    <section id="journey" class="py-24 px-4 bg-gradient-to-b from-slate-50 via-blue-50/30 to-slate-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span data-animate class="about-badge font-hud inline-block text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase">Your journey</span>
                <h2 data-animate class="delay-100 font-display text-3xl md:text-4xl font-bold text-gray-800">How SkillUp helps you</h2>
            </div>

            <div class="hidden md:block relative mb-8 px-4">
                <div data-animate class="delay-150 about-step-connector h-1.5 max-w-4xl mx-auto opacity-90" id="about-step-line">
                    <div class="data-flow-dot" aria-hidden="true"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <?php
                    $steps = [
                        ['num'=>'1','bg'=>'bg-[#003a8f]','title'=>'Assessment',      'desc'=>'Understand your strengths, interests, and career goals'],
                        ['num'=>'2','bg'=>'bg-[#1e4976]','title'=>'Personalization', 'desc'=>'AI-powered recommendations tailored to your profile'],
                        ['num'=>'3','bg'=>'bg-[#0a2540]','title'=>'Learning',        'desc'=>'Interactive courses, mentorship, and real-world projects'],
                        ['num'=>'4','bg'=>'bg-[#c1121f]','title'=>'Opportunity',     'desc'=>'Internships and jobs aligned with your journey'],
                    ];
                    $stepDel = ['delay-100','delay-200','delay-300','delay-400'];
                ?>
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-animate class="<?php echo e($stepDel[$i]); ?> about-step text-center group">
                        <div class="about-timeline-dot hidden md:block" aria-hidden="true"></div>
                        <div class="about-step-circle <?php echo e($step['bg']); ?> text-white w-20 h-20 flex items-center justify-center mx-auto mb-5 text-3xl font-bold shadow-lg font-display">
                            <?php echo e($step['num']); ?>

                        </div>
                        <h3 class="font-display font-bold text-lg mb-2 text-gray-800"><?php echo e($step['title']); ?></h3>
                        <p class="text-gray-600 text-sm leading-relaxed"><?php echo e($step['desc']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section id="faq" class="py-24 px-4 bg-white">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-14">
                <span data-animate class="about-badge font-hud inline-block text-xs font-semibold px-4 py-1.5 rounded-full mb-4 uppercase">Questions</span>
                <h2 data-animate class="delay-100 font-display text-3xl md:text-4xl font-bold text-gray-800">Frequently asked questions</h2>
            </div>

            <div class="space-y-4" id="faq-list">
                <?php
                    $faqs = [
                        ['q'=>'Is SkillUp free to join?', 'a'=>'Yes. Creating a learner account and starting your first assessment is free. Some advanced tracks and certifications may have additional requirements, which are always shown clearly before you enroll.'],
                        ['q'=>'How does the AI personalize my learning path?', 'a'=>'After your initial assessment, SkillUp matches your interests, current skill level, and available time to a recommended sequence of courses, mentors, and projects — then adjusts as you progress.'],
                        ['q'=>'Do I get a certificate after finishing a course?', 'a'=>'Completed courses and skill milestones are recorded on your profile, giving you shareable proof of what you have learned and completed.'],
                        ['q'=>'Can I talk to a real mentor?', 'a'=>'Yes. Every track connects to mentors from that industry who review your work, answer questions, and help you plan next steps toward internships or jobs.'],
                        ['q'=>'What if I am not sure which career path to choose?', 'a'=>'Start with the assessment step. It is designed for exploration, and you can revisit or change your path at any time as your interests become clearer.'],
                    ];
                ?>
                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div data-animate class="<?php echo e($i % 2 == 0 ? 'delay-100' : 'delay-200'); ?> faq-item" data-faq>
                        <button type="button" class="faq-trigger" aria-expanded="false" aria-controls="faq-panel-<?php echo e($i); ?>">
                            <span class="font-display font-semibold text-gray-800 text-base md:text-lg"><?php echo e($faq['q']); ?></span>
                            <span class="faq-icon" aria-hidden="true"><i class="fas fa-plus text-xs"></i></span>
                        </button>
                        <div class="faq-panel" id="faq-panel-<?php echo e($i); ?>" role="region">
                            <div class="faq-panel-inner"><?php echo e($faq['a']); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="py-20 px-4 bg-slate-50/90">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 data-animate class="font-display text-2xl md:text-3xl font-bold text-gray-800">Continue exploring</h2>
                <p data-animate class="delay-100 text-gray-600 mt-2">Tools built to support every stage of your career journey</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <a data-animate href="<?php echo e(route('courses.index')); ?>" class="delay-100 about-link-card hud-corners about-glass block p-6 rounded-2xl border border-slate-200/80 shadow-sm group">
                    <i class="fas fa-book-open text-2xl text-[#003a8f] mb-3"></i>
                    <h3 class="font-display font-bold text-gray-800 mb-1">Courses</h3>
                    <p class="text-sm text-gray-600 mb-3">Browse skill-building programs</p>
                    <span class="text-sm font-semibold text-[#003a8f]">View catalog <i class="fas fa-arrow-right ml-1"></i></span>
                </a>
                <?php if(auth()->guard()->check()): ?>
                    <a data-animate href="<?php echo e(route('userpage.roadmap')); ?>" class="delay-200 about-link-card hud-corners about-glass block p-6 rounded-2xl border border-slate-200/80 shadow-sm group">
                        <i class="fas fa-route text-2xl text-[#003a8f] mb-3"></i>
                        <h3 class="font-display font-bold text-gray-800 mb-1">Your roadmap</h3>
                        <p class="text-sm text-gray-600 mb-3">Track progress toward your goals</p>
                        <span class="text-sm font-semibold text-[#003a8f]">Open roadmap <i class="fas fa-arrow-right ml-1"></i></span>
                    </a>
                    <a data-animate href="<?php echo e(route('ai-chatbot.index')); ?>" class="delay-300 about-link-card hud-corners about-glass block p-6 rounded-2xl border border-slate-200/80 shadow-sm group">
                        <i class="fas fa-robot text-2xl text-[#003a8f] mb-3"></i>
                        <h3 class="font-display font-bold text-gray-800 mb-1">AI tutor</h3>
                        <p class="text-sm text-gray-600 mb-3">Get personalized career guidance</p>
                        <span class="text-sm font-semibold text-[#003a8f]">Chat now <i class="fas fa-arrow-right ml-1"></i></span>
                    </a>
                <?php else: ?>
                    <a data-animate href="<?php echo e(route('register')); ?>" class="delay-200 about-link-card hud-corners about-glass block p-6 rounded-2xl border border-slate-200/80 shadow-sm group">
                        <i class="fas fa-user-plus text-2xl text-[#003a8f] mb-3"></i>
                        <h3 class="font-display font-bold text-gray-800 mb-1">Join free</h3>
                        <p class="text-sm text-gray-600 mb-3">Create your learner account</p>
                        <span class="text-sm font-semibold text-[#003a8f]">Sign up <i class="fas fa-arrow-right ml-1"></i></span>
                    </a>
                    <a data-animate href="<?php echo e(route('contact')); ?>" class="delay-300 about-link-card hud-corners about-glass block p-6 rounded-2xl border border-slate-200/80 shadow-sm group">
                        <i class="fas fa-envelope text-2xl text-[#003a8f] mb-3"></i>
                        <h3 class="font-display font-bold text-gray-800 mb-1">Contact us</h3>
                        <p class="text-sm text-gray-600 mb-3">Questions? We're here to help</p>
                        <span class="text-sm font-semibold text-[#003a8f]">Get in touch <i class="fas fa-arrow-right ml-1"></i></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    
    <section class="py-20 px-4 about-cta text-white">
        <div class="about-cta-shimmer absolute inset-0 pointer-events-none opacity-40" aria-hidden="true"></div>

        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="about-blob" style="width:20rem;height:20rem;background:rgba(47,216,255,0.22);top:-5rem;right:5%;animation-delay:0s;"></div>
            <div class="about-blob" style="width:16rem;height:16rem;background:rgba(193,18,31,0.22);bottom:-4rem;left:5%;animation-delay:2s;"></div>
            <div class="absolute top-12 left-8 w-28 h-28 rounded-full border border-cyan-300/20 blur-xl opacity-60"></div>
        </div>

        <div data-animate class="max-w-4xl mx-auto text-center relative z-10">
            <div class="w-16 h-16 mx-auto mb-6 hud-panel flex items-center justify-center shadow-xl" style="background:rgba(255,255,255,0.12); border:1px solid rgba(47,216,255,0.35);">
                <i class="fas fa-rocket text-white text-2xl"></i>
            </div>
            <h2 class="font-display text-3xl md:text-4xl font-bold mb-4">Ready to ignite your career orbit?</h2>
            <p class="text-lg text-slate-200 mb-8 max-w-xl mx-auto leading-relaxed">
                Begin a guided mission through future-ready skills, mentorship, and opportunities designed for your success.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('userpage.dashboard')); ?>" class="btn-about font-display inline-flex items-center justify-center bg-white text-[#0a2540] px-10 py-4 rounded-xl font-bold text-lg shadow-xl">
                        Go to your dashboard <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('register')); ?>" class="btn-about font-display inline-flex items-center justify-center bg-white text-[#0a2540] px-10 py-4 rounded-xl font-bold text-lg shadow-xl">
                        Get started free <i class="fas fa-rocket ml-2"></i>
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="btn-about font-display inline-flex items-center justify-center border-2 border-white/80 px-10 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-[#0a2540] transition-colors">
                        Sign in
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const supportsIO = 'IntersectionObserver' in window;
    const fine = window.matchMedia('(pointer: fine)').matches;

    /* ── Star field ── */
    if (!reduced) {
        const starsEl = document.getElementById('hero-stars');
        if (starsEl) {
            const totalStars = 78;
            const frag = document.createDocumentFragment();
            for (let i = 0; i < totalStars; i++) {
                const s = document.createElement('div');
                s.className = 'hero-star';
                const size = 0.8 + Math.random() * 3.2;
                s.style.cssText = [
                    `width:${size}px`, `height:${size}px`,
                    `top:${Math.random() * 100}%`,
                    `left:${Math.random() * 100}%`,
                    `--dur:${1.3 + Math.random() * 3.2}s`,
                    `--delay:${Math.random() * 3.2}s`
                ].join(';');
                if (Math.random() > 0.92) {
                    s.style.boxShadow = '0 0 14px rgba(255,255,255,0.9)';
                }
                frag.appendChild(s);
            }
            starsEl.appendChild(frag);
        }
    }

    /* ── Cursor-follow hero spotlight ── */
    const heroSection = document.getElementById('about-hero');
    const spotlight = document.getElementById('hero-spotlight');
    if (!reduced && fine && heroSection && spotlight) {
        heroSection.addEventListener('mousemove', (e) => {
            const r = heroSection.getBoundingClientRect();
            const x = ((e.clientX - r.left) / r.width) * 100;
            const y = ((e.clientY - r.top) / r.height) * 100;
            spotlight.style.setProperty('--sx', x + '%');
            spotlight.style.setProperty('--sy', y + '%');
            spotlight.classList.add('is-active');
        });
        heroSection.addEventListener('mouseleave', () => spotlight.classList.remove('is-active'));
    }

    /* ── Scroll progress + hero parallax + scroll cue ── */
    const prog = document.getElementById('about-scroll-progress');
    const heroBlobs = document.getElementById('hero-blobs');
    const scrollCue = document.getElementById('hero-scroll-cue');

    if (scrollCue && !reduced) {
        setTimeout(() => scrollCue.classList.add('is-visible'), 1400);
    }

    if (prog && !reduced) {
        let ticking = false;
        const update = () => {
            const scrollY = window.scrollY;
            const h = document.documentElement.scrollHeight - window.innerHeight;
            prog.style.width = h > 0 ? (scrollY / h * 100) + '%' : '0%';

            if (heroBlobs && heroSection) {
                const heroH = heroSection.offsetHeight;
                if (scrollY < heroH) {
                    heroBlobs.style.transform = `translate3d(0, ${scrollY * 0.16}px, 0)`;
                }
            }
            if (scrollCue) {
                scrollCue.classList.toggle('is-visible', scrollY < 80);
            }
            ticking = false;
        };
        window.addEventListener('scroll', () => {
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
        }, { passive: true });
        update();
    }

    /* ── Magnetic buttons ── */
    if (!reduced && fine) {
        document.querySelectorAll('.btn-about').forEach(btn => {
            btn.addEventListener('mousemove', (e) => {
                const r = btn.getBoundingClientRect();
                const mx = e.clientX - r.left - r.width / 2;
                const my = e.clientY - r.top - r.height / 2;
                btn.style.transform = `translate(${mx * 0.18}px, ${my * 0.35}px)`;
            });
            btn.addEventListener('mouseleave', () => { btn.style.transform = ''; });
        });
    }

    /* ── Logo parallax tilt (mouse-follow) ── */
    if (!reduced && fine) {
        const logoWrap = document.getElementById('logo-display-wrap');
        if (logoWrap) {
            logoWrap.addEventListener('mousemove', (e) => {
                const r = logoWrap.getBoundingClientRect();
                const px = (e.clientX - r.left) / r.width - 0.5;
                const py = (e.clientY - r.top) / r.height - 0.5;
                logoWrap.style.transform = `rotateX(${(-py * 10).toFixed(2)}deg) rotateY(${(px * 10).toFixed(2)}deg)`;
            });
            logoWrap.addEventListener('mouseleave', () => { logoWrap.style.transform = ''; });
        }
    }

    /* ── 3D tilt cards + cursor glare ── */
    if (!reduced && fine) {
        const glareHosts = document.querySelectorAll('.about-mission-card, .about-apart-card, .about-stat-card, .about-link-card, .about-mentor-card, .about-value-card');
        glareHosts.forEach(card => {
            const glare = document.createElement('div');
            glare.className = 'card-glare';
            card.appendChild(glare);
        });

        const tiltEls = document.querySelectorAll('.about-mission-card, .about-value-card, .about-apart-card, .about-stat-card, .about-link-card, .about-mentor-card');
        tiltEls.forEach(card => {
            card.classList.add('tilt-card');
            card.addEventListener('mousemove', (e) => {
                const r = card.getBoundingClientRect();
                const px = (e.clientX - r.left) / r.width;
                const py = (e.clientY - r.top) / r.height;
                const rotateY = (px - 0.5) * 7;
                const rotateX = (0.5 - py) * 7;
                card.style.transform = `perspective(900px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-4px)`;
                card.style.setProperty('--mx', (px * 100) + '%');
                card.style.setProperty('--my', (py * 100) + '%');
            });
            card.addEventListener('mouseleave', () => { card.style.transform = ''; });
        });
    }

    /* ── Active pill nav highlighting ── */
    const pillLinks = document.querySelectorAll('.about-pill-nav a[href^="#"]');
    if (pillLinks.length && supportsIO) {
        const sectionMap = new Map();
        pillLinks.forEach(link => {
            const id = link.getAttribute('href').slice(1);
            const sec = document.getElementById(id);
            if (sec) sectionMap.set(sec, link);
        });
        if (sectionMap.size) {
            const navObs = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const link = sectionMap.get(entry.target);
                    if (!link || !entry.isIntersecting) return;
                    pillLinks.forEach(l => l.classList.remove('is-active'));
                    link.classList.add('is-active');
                });
            }, { threshold: 0.3, rootMargin: '-15% 0px -55% 0px' });
            sectionMap.forEach((link, sec) => navObs.observe(sec));
        }
    }

    /* ── FAQ accordion ── */
    document.querySelectorAll('[data-faq]').forEach(item => {
        const trigger = item.querySelector('.faq-trigger');
        const panel = item.querySelector('.faq-panel');
        if (!trigger || !panel) return;

        trigger.addEventListener('click', () => {
            const isOpen = item.classList.contains('is-open');

            document.querySelectorAll('[data-faq].is-open').forEach(openItem => {
                if (openItem !== item) {
                    openItem.classList.remove('is-open');
                    openItem.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
                    openItem.querySelector('.faq-panel').style.maxHeight = null;
                }
            });

            if (isOpen) {
                item.classList.remove('is-open');
                trigger.setAttribute('aria-expanded', 'false');
                panel.style.maxHeight = null;
            } else {
                item.classList.add('is-open');
                trigger.setAttribute('aria-expanded', 'true');
                panel.style.maxHeight = panel.scrollHeight + 'px';
            }
        });
    });

    /* ── Back to top ── */
    const backToTop = document.createElement('button');
    backToTop.type = 'button';
    backToTop.className = 'about-back-to-top';
    backToTop.setAttribute('aria-label', 'Back to top');
    backToTop.innerHTML = '<i class="fas fa-arrow-up" aria-hidden="true"></i>';
    document.body.appendChild(backToTop);
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: reduced ? 'auto' : 'smooth' });
    });
    let btTicking = false;
    const toggleBackToTop = () => {
        backToTop.classList.toggle('is-visible', window.scrollY > window.innerHeight * 0.8);
        btTicking = false;
    };
    window.addEventListener('scroll', () => {
        if (!btTicking) { btTicking = true; requestAnimationFrame(toggleBackToTop); }
    }, { passive: true });
    toggleBackToTop();

    /* ── Scroll-triggered animations ── */
    const items = document.querySelectorAll('[data-animate]');

    if (reduced) {
        items.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
            el.style.filter = 'none';
        });
        document.getElementById('about-step-line')?.classList.add('is-drawn');
        document.querySelectorAll('.about-step').forEach(s => s.classList.add('is-visible'));
        return;
    }

    const observer = supportsIO ? new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-ready');
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }) : null;

    if (observer) {
        items.forEach(el => observer.observe(el));
    } else {
        items.forEach(el => el.classList.add('animate-ready'));
    }

    /* Hero items fire immediately with stagger */
    const hero = document.getElementById('about-hero');
    if (hero) {
        hero.querySelectorAll('[data-animate]').forEach((el, i) => {
            setTimeout(() => {
                if (!el.classList.contains('animate-ready')) {
                    el.classList.add('animate-ready');
                    if (observer) observer.unobserve(el);
                }
            }, 60 + i * 55);
        });
    }

    /* ── Step line draw ── */
    const stepLine = document.getElementById('about-step-line');
    if (stepLine) {
        const lineObs = supportsIO ? new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    stepLine.classList.add('is-drawn');
                    document.querySelectorAll('.about-step').forEach((s, i) => {
                        setTimeout(() => s.classList.add('is-visible'), 120 + i * 120);
                    });
                    lineObs.disconnect();
                }
            });
        }, { threshold: 0.3 }) : null;

        if (lineObs) lineObs.observe(stepLine);
        else {
            stepLine.classList.add('is-drawn');
            document.querySelectorAll('.about-step').forEach((s, i) => {
                setTimeout(() => s.classList.add('is-visible'), 120 + i * 120);
            });
        }
    }

    /* ── Animated counters ── */
    const formatCount = (val, suffix) => {
        if (suffix === '★') return val.toFixed(1) + suffix;
        if (val >= 1000) return (val / 1000).toFixed(0) + 'K' + suffix;
        return Math.round(val) + suffix;
    };

    if (supportsIO) {
        const counterObs = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const end = parseFloat(el.dataset.count);
                const suffix = el.dataset.suffix || '';
                const isDecimal = el.dataset.decimal === '1';
                const duration = 1600;
                const startTime = performance.now();

                const tick = (now) => {
                    const t = Math.min((now - startTime) / duration, 1);
                    const eased = 1 - Math.pow(1 - t, 3);
                    el.textContent = formatCount(isDecimal ? eased * end : Math.floor(eased * end), suffix);
                    if (t < 1) requestAnimationFrame(tick);
                    else el.textContent = formatCount(end, suffix);
                };
                requestAnimationFrame(tick);
                obs.unobserve(el);
            });
        }, { threshold: 0.4 });

        document.querySelectorAll('[data-count]').forEach(el => counterObs.observe(el));
    } else {
        document.querySelectorAll('[data-count]').forEach(el => {
            const end = parseFloat(el.dataset.count);
            el.textContent = formatCount(end, el.dataset.suffix || '');
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/Userpage/about.blade.php ENDPATH**/ ?>