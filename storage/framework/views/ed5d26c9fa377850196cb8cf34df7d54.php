<?php $__env->startSection('title', 'SkillUp – A Personalized Learning Portal for Youth Career Development'); ?>

<?php $__env->startPush('head'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@500;600;700&family=Bricolage+Grotesque:opsz,wght@12..96,300;12..96,400;12..96,500;12..96,600;12..96,700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════════════ */
:root {
    /* Core palette */
    --ink:       #04111e;
    --ink-mid:   #0a2540;
    --navy:      #003a8f;
    --navy-lt:   #0f52c8;
    --sky:       #38bdf8;
    --sky-lt:    #bae6fd;
    --emerald:   #10b981;
    --amber:     #f59e0b;
    --white:     #ffffff;
    --off-white: #f4f7fb;
    --slate-100: #f1f5f9;
    --slate-200: #e2e8f0;
    --slate-400: #94a3b8;
    --slate-600: #475569;
    --slate-800: #1e293b;

    /* Futuristic / HUD accents */
    --void:      #030814;
    --plasma:    #00eaff;
    --plasma-2:  #7dd3fc;
    --holo:      #8b5cf6;
    --holo-lt:   #c4b5fd;
    --signal:    #00ffb2;
    --circuit:   rgba(56,189,248,0.16);
    --mono-font: 'Space Mono', 'SF Mono', ui-monospace, monospace;

    /* Easing */
    --expo:  cubic-bezier(0.16, 1, 0.3, 1);
    --back:  cubic-bezier(0.34, 1.56, 0.64, 1);
    --snap:  cubic-bezier(0.4, 0, 0.2, 1);

    /* Shadows */
    --shadow-sm:  0 1px 3px rgba(4,17,30,0.08), 0 1px 2px rgba(4,17,30,0.06);
    --shadow-md:  0 4px 16px rgba(4,17,30,0.10), 0 2px 6px rgba(4,17,30,0.07);
    --shadow-lg:  0 12px 40px rgba(4,17,30,0.13), 0 4px 12px rgba(4,17,30,0.08);
    --shadow-xl:  0 24px 64px rgba(4,17,30,0.16), 0 8px 24px rgba(0,58,143,0.12);
    --shadow-glow:0 0 40px rgba(56,189,248,0.22);
    --shadow-holo:0 0 32px rgba(139,92,246,0.22), 0 0 64px rgba(0,234,255,0.12);
}

/* ═══════════════════════════════════════════════════
   GLOBAL BASE
═══════════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

html { scroll-behavior: smooth; }

body {
    font-family: 'Bricolage Grotesque', sans-serif;
    background: var(--off-white);
    color: var(--ink);
    overflow-x: hidden;
}

.display-font { font-family: 'Clash Display', sans-serif; }
.mono-font { font-family: var(--mono-font); }

::selection { background: var(--plasma); color: var(--ink); }

:focus-visible {
    outline: 2px solid var(--plasma);
    outline-offset: 3px;
    border-radius: 4px;
}

/* ═══════════════════════════════════════════════════
   SCROLL PROGRESS
═══════════════════════════════════════════════════ */
#scroll-progress {
    position: fixed;
    top: 0; left: 0;
    height: 3px;
    width: 0%;
    background: linear-gradient(90deg, var(--navy), var(--sky), var(--holo), var(--emerald));
    background-size: 300% 100%;
    animation: progressHue 6s linear infinite;
    z-index: 200;
    border-radius: 0 2px 2px 0;
    box-shadow: 0 0 12px rgba(56,189,248,0.5);
    transition: width 0.1s linear;
}

@keyframes progressHue {
    to { background-position: -300% 0; }
}

/* ═══════════════════════════════════════════════════
   CURSOR DOT
═══════════════════════════════════════════════════ */
#cursor-dot {
    position: fixed;
    width: 10px; height: 10px;
    background: var(--sky);
    border-radius: 50%;
    pointer-events: none;
    z-index: 9998;
    transform: translate(-50%, -50%);
    transition: transform 0.12s ease, background 0.2s ease, opacity 0.2s ease;
    mix-blend-mode: screen;
    opacity: 0;
}

#cursor-ring {
    position: fixed;
    width: 36px; height: 36px;
    border: 1.5px solid rgba(56,189,248,0.55);
    border-radius: 50%;
    pointer-events: none;
    z-index: 9997;
    transform: translate(-50%, -50%);
    transition: transform 0.22s var(--expo), width 0.25s var(--expo), height 0.25s var(--expo), border-color 0.2s;
    opacity: 0;
}

#cursor-ring::before {
    content: '';
    position: absolute;
    inset: -8px;
    border: 1px solid rgba(139,92,246,0);
    border-radius: 50%;
    transition: border-color 0.2s ease;
}

body:hover #cursor-dot,
body:hover #cursor-ring { opacity: 1; }

/* Cursor trail canvas sits above content, below UI chrome */
#cursor-trail {
    position: fixed;
    inset: 0;
    z-index: 9996;
    pointer-events: none;
}

/* ═══════════════════════════════════════════════════
   SPLASH / ENTRANCE SCREEN
═══════════════════════════════════════════════════ */
#splash {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--void);
    overflow: hidden;
}

/* Noise grain */
#splash::before {
    content: '';
    position: absolute;
    inset: -200%;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
    background-size: 128px 128px;
    pointer-events: none;
    z-index: 0;
    opacity: 0.4;
}

.splash-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(56,189,248,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(56,189,248,0.06) 1px, transparent 1px);
    background-size: 72px 72px;
    animation: gridPan 16s linear infinite;
    z-index: 1;
}

@keyframes gridPan {
    to { background-position: 72px 72px; }
}

/* Radial orbs */
.splash-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    z-index: 1;
    pointer-events: none;
}

.splash-orb-1 {
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(0,58,143,0.45) 0%, transparent 70%);
    top: -200px; left: -200px;
    animation: orbDrift1 10s ease-in-out infinite alternate;
}

.splash-orb-2 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(56,189,248,0.15) 0%, transparent 70%);
    bottom: -150px; right: -150px;
    animation: orbDrift2 12s ease-in-out infinite alternate;
}

.splash-orb-3 {
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(139,92,246,0.16) 0%, transparent 70%);
    top: 45%; left: 15%;
    animation: orbDrift1 8s ease-in-out 2s infinite alternate-reverse;
}

@keyframes orbDrift1 {
    to { transform: translate(50px, 40px) scale(1.08); }
}
@keyframes orbDrift2 {
    to { transform: translate(-40px, -50px) scale(1.06); }
}

/* Pulsing rings */
.splash-ring {
    position: absolute;
    top: 50%; left: 50%;
    border: 1px solid rgba(56,189,248,0.15);
    border-radius: 50%;
    animation: ringPulse 3.6s ease-out infinite;
    z-index: 2;
}

@keyframes ringPulse {
    0%   { transform: translate(-50%, -50%) scale(0.3); opacity: 0.9; }
    100% { transform: translate(-50%, -50%) scale(2.8); opacity: 0; }
}

/* Scan lines */
.splash-scan {
    position: absolute;
    inset: 0;
    background: repeating-linear-gradient(
        0deg,
        transparent 0,
        transparent 3px,
        rgba(0,0,0,0.06) 3px,
        rgba(0,0,0,0.06) 4px
    );
    pointer-events: none;
    z-index: 2;
}

/* Roving HUD scan beam */
.splash-beam {
    position: absolute;
    left: 0; right: 0;
    height: 120px;
    background: linear-gradient(180deg, transparent, rgba(0,234,255,0.06), transparent);
    animation: beamSweep 3.2s ease-in-out infinite;
    z-index: 2;
    pointer-events: none;
}

@keyframes beamSweep {
    0%   { transform: translateY(-140px); }
    100% { transform: translateY(100vh); }
}

/* Corner brackets */
.splash-corner {
    position: absolute;
    width: 52px; height: 52px;
    z-index: 3;
    opacity: 0;
    animation: cornerIn 0.6s var(--expo) 0.2s forwards;
}

.splash-corner--tl { top: 28px; left: 28px; border-top: 2px solid rgba(56,189,248,0.4); border-left: 2px solid rgba(56,189,248,0.4); }
.splash-corner--tr { top: 28px; right: 28px; border-top: 2px solid rgba(56,189,248,0.4); border-right: 2px solid rgba(56,189,248,0.4); }
.splash-corner--bl { bottom: 28px; left: 28px; border-bottom: 2px solid rgba(56,189,248,0.4); border-left: 2px solid rgba(56,189,248,0.4); }
.splash-corner--br { bottom: 28px; right: 28px; border-bottom: 2px solid rgba(56,189,248,0.4); border-right: 2px solid rgba(56,189,248,0.4); }

@keyframes cornerIn {
    from { opacity: 0; transform: scale(1.4); }
    to   { opacity: 1; transform: scale(1); }
}

/* HUD telemetry readouts in the corners */
.splash-tele {
    position: absolute;
    font-family: var(--mono-font);
    font-size: 0.62rem;
    letter-spacing: 0.06em;
    color: rgba(125,211,252,0.45);
    z-index: 3;
    opacity: 0;
    animation: cornerIn 0.6s var(--expo) 0.45s forwards;
    line-height: 1.6;
    white-space: nowrap;
}

.splash-tele--tl { top: 40px; left: 92px; text-align: left; }
.splash-tele--br { bottom: 40px; right: 92px; text-align: right; }

/* Particles */
#splash-particles {
    position: absolute; inset: 0;
    pointer-events: none; z-index: 3;
}

.sp {
    position: absolute;
    border-radius: 50%;
    background: rgba(56,189,248,0.65);
    animation: spFloat linear infinite;
}

@keyframes spFloat {
    0%   { transform: translateY(0) scale(1); opacity: 0; }
    8%   { opacity: 0.8; }
    92%  { opacity: 0.4; }
    100% { transform: translateY(-105vh) scale(0.3); opacity: 0; }
}

/* Splash content */
.splash-content {
    position: relative;
    z-index: 10;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Logo mark */
.splash-logo {
    width: 92px; height: 92px;
    border-radius: 26px;
    background: linear-gradient(145deg, var(--navy) 0%, var(--ink-mid) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.75rem;
    position: relative;
    overflow: hidden;
    opacity: 0;
    transform: scale(0.5) rotate(-18deg);
    transition: opacity 0.8s var(--expo), transform 0.8s var(--expo);
    box-shadow:
        0 0 0 0 rgba(56,189,248,0),
        0 28px 72px rgba(0,58,143,0.6),
        inset 0 1px 0 rgba(255,255,255,0.14);
}

.splash-logo::after {
    content: '';
    position: absolute;
    inset: -50%;
    background: conic-gradient(from 0deg, transparent 55%, rgba(0,234,255,0.3) 75%, rgba(139,92,246,0.3) 88%, transparent 100%);
    animation: logoSpin 4s linear infinite;
}

@keyframes logoSpin {
    to { transform: rotate(360deg); }
}

.splash-logo.active {
    opacity: 1;
    transform: scale(1) rotate(0deg);
    animation: logoPulse 2.4s ease-in-out 0.8s infinite;
}

@keyframes logoPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(56,189,248,0.4), 0 28px 72px rgba(0,58,143,0.6), inset 0 1px 0 rgba(255,255,255,0.14); }
    50%       { box-shadow: 0 0 0 20px rgba(56,189,248,0), 0 28px 72px rgba(0,58,143,0.6), inset 0 1px 0 rgba(255,255,255,0.14); }
}

.splash-wordmark {
    font-family: 'Clash Display', sans-serif;
    font-size: clamp(3.5rem, 11vw, 6rem);
    font-weight: 700;
    color: var(--white);
    letter-spacing: -0.04em;
    line-height: 1;
    margin-bottom: 0.65rem;
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.75s var(--expo) 0.18s, transform 0.75s var(--expo) 0.18s;
    position: relative;
}

.splash-wordmark .accent {
    background: linear-gradient(135deg, var(--sky-lt) 0%, var(--plasma) 50%, var(--holo-lt) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.splash-wordmark.active { opacity: 1; transform: translateY(0); }

/* Glitch slices, triggered briefly on reveal via .glitching */
.splash-wordmark.glitching::before,
.splash-wordmark.glitching::after {
    content: 'Skill' attr(data-suffix);
    position: absolute;
    inset: 0;
    background: var(--void);
    overflow: hidden;
}

.splash-wordmark.glitching::before {
    color: var(--plasma);
    clip-path: inset(10% 0 65% 0);
    transform: translate(3px, -2px);
    animation: glitchShift 0.35s steps(2) 2;
}

.splash-wordmark.glitching::after {
    color: var(--holo-lt);
    clip-path: inset(60% 0 8% 0);
    transform: translate(-3px, 2px);
    animation: glitchShift 0.3s steps(2) 2 reverse;
}

@keyframes glitchShift {
    0%   { transform: translate(0,0); }
    50%  { transform: translate(-4px, 2px); }
    100% { transform: translate(3px, -2px); }
}

.splash-tagline {
    font-family: var(--mono-font);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    color: rgba(186,230,253,0.65);
    margin-bottom: 2.5rem;
    opacity: 0;
    transform: translateY(14px);
    transition: opacity 0.7s var(--expo) 0.32s, transform 0.7s var(--expo) 0.32s;
}

.splash-tagline.active { opacity: 1; transform: translateY(0); }

.splash-tagline .blink-cursor {
    display: inline-block;
    width: 7px;
    margin-left: 2px;
    color: var(--plasma);
    animation: blinkCursor 1s step-end infinite;
}

@keyframes blinkCursor {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0; }
}

/* Progress bar */
.splash-bar-wrap {
    width: min(280px, 65vw);
    height: 3px;
    background: rgba(255,255,255,0.07);
    border-radius: 3px;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.5s ease 0.45s;
    position: relative;
}

.splash-bar-wrap.active { opacity: 1; }

.splash-bar {
    position: absolute;
    inset: 0 auto 0 0;
    width: 0%;
    background: linear-gradient(90deg, var(--navy), var(--navy-lt), var(--plasma), var(--holo));
    background-size: 200% 100%;
    animation: barShimmer 1.4s linear infinite;
    border-radius: 3px;
    transition: width 1.6s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes barShimmer {
    to { background-position: -200% 0; }
}

.splash-status {
    font-family: var(--mono-font);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: rgba(186,230,253,0.38);
    margin-top: 1rem;
    opacity: 0;
    transition: opacity 0.5s ease 0.5s;
    min-height: 1.2em;
}

.splash-status.active { opacity: 1; }

.splash-status .pct {
    color: var(--plasma);
    opacity: 0.9;
}

.splash-dots {
    display: flex;
    gap: 6px;
    margin-top: 1.1rem;
    opacity: 0;
    transition: opacity 0.5s ease 0.52s;
}

.splash-dots.active { opacity: 1; }

.sd {
    width: 5px; height: 5px;
    border-radius: 50%;
    background: rgba(186,230,253,0.35);
    animation: dotBounce 1.4s ease-in-out infinite;
}
.sd:nth-child(2) { animation-delay: 0.18s; }
.sd:nth-child(3) { animation-delay: 0.36s; }

@keyframes dotBounce {
    0%, 80%, 100% { transform: scale(1);   background: rgba(186,230,253,0.3); }
    40%           { transform: scale(1.75); background: rgba(186,230,253,1); }
}

/* Splash exit */
#splash.leaving {
    animation: splashExit 1.05s cubic-bezier(0.76, 0, 0.24, 1) forwards;
}

@keyframes splashExit {
    0%   { clip-path: inset(0 0 0% 0); opacity: 1; }
    100% { clip-path: inset(0 0 100% 0); opacity: 0.2; }
}

/* ═══════════════════════════════════════════════════
   SCROLL-REVEAL SYSTEM
═══════════════════════════════════════════════════ */
[data-sr] {
    opacity: 0;
    transform: translateY(30px) scale(0.97);
    filter: blur(5px);
    transition:
        opacity   0.8s var(--expo),
        transform 0.8s var(--expo),
        filter    0.75s ease;
}

[data-sr].sr-left  { transform: translateX(-28px) scale(0.97); }
[data-sr].sr-right { transform: translateX(28px) scale(0.97); }
[data-sr].sr-scale { transform: scale(0.88); }

[data-sr].visible {
    opacity: 1;
    transform: none;
    filter: blur(0);
}

[data-sr-d="1"] { transition-delay: 80ms; }
[data-sr-d="2"] { transition-delay: 160ms; }
[data-sr-d="3"] { transition-delay: 240ms; }
[data-sr-d="4"] { transition-delay: 320ms; }
[data-sr-d="5"] { transition-delay: 400ms; }
[data-sr-d="6"] { transition-delay: 480ms; }

/* Hero items – immediate stagger */
.hero-sr { opacity: 0; animation: heroIn 0.9s var(--expo) both; }
.hero-sr-1 { animation-delay: 0.08s; }
.hero-sr-2 { animation-delay: 0.18s; }
.hero-sr-3 { animation-delay: 0.28s; }
.hero-sr-4 { animation-delay: 0.38s; }
.hero-sr-5 { animation-delay: 0.48s; }
.hero-sr-6 { animation-delay: 0.58s; }
.hero-sr-7 { animation-delay: 0.68s; }

@keyframes heroIn {
    from { opacity: 0; transform: translateY(32px) scale(0.96); filter: blur(7px); }
    to   { opacity: 1; transform: none; filter: blur(0); }
}

/* ═══════════════════════════════════════════════════
   HERO SECTION
═══════════════════════════════════════════════════ */
#hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    isolation: isolate;
    padding: 7.5rem 1.5rem 5rem;
}

.hero-bg-img {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: -4;
    transform-origin: center;
    animation: kenBurns 24s ease-in-out infinite alternate;
    will-change: transform;
    filter: saturate(1.05) contrast(1.03);
}

@keyframes kenBurns {
    from { transform: scale(1.04) translate(0, 0); }
    to   { transform: scale(1.12) translate(-1.5%, -1%); }
}

.hero-overlay-1 {
    position: absolute;
    inset: 0; z-index: -3;
    background: linear-gradient(165deg, rgba(3,8,20,0.82) 0%, rgba(10,37,64,0.68) 50%, rgba(3,8,20,0.94) 100%);
}

.hero-overlay-2 {
    position: absolute;
    inset: 0; z-index: -2;
    background:
        radial-gradient(ellipse 70% 55% at 20% 30%, rgba(0,58,143,0.32) 0%, transparent 60%),
        radial-gradient(ellipse 50% 40% at 80% 80%, rgba(0,234,255,0.12) 0%, transparent 55%),
        radial-gradient(ellipse 40% 35% at 90% 15%, rgba(139,92,246,0.14) 0%, transparent 55%);
    animation: heroGlow 7s ease-in-out infinite alternate;
}

@keyframes heroGlow {
    from { opacity: 0.6; }
    to   { opacity: 1; }
}

/* Circuit-line background layer */
.hero-circuits {
    position: absolute;
    inset: 0; z-index: -1;
    opacity: 0.5;
    pointer-events: none;
    mix-blend-mode: screen;
}

/* Hero shimmer sweep */
.hero-shimmer {
    position: absolute;
    inset: 0; z-index: 0;
    background: linear-gradient(108deg, transparent 32%, rgba(255,255,255,0.055) 50%, transparent 68%);
    background-size: 220% 100%;
    animation: shimmerSweep 6s ease-in-out infinite;
    pointer-events: none;
}

@keyframes shimmerSweep {
    0%, 100% { background-position: 200% 0; }
    50%       { background-position: -50% 0; }
}

/* Hero canvas (particles) */
#hero-canvas {
    position: absolute;
    inset: 0; z-index: 0;
    pointer-events: none;
}

/* HUD corner frame around the hero viewport */
.hero-hud {
    position: absolute;
    inset: 18px;
    z-index: 1;
    pointer-events: none;
    opacity: 0;
    animation: orbitFadeIn 1.2s var(--expo) 0.6s forwards;
}

.hero-hud .hud-corner {
    position: absolute;
    width: 34px; height: 34px;
    border: 1.5px solid rgba(0,234,255,0.35);
}
.hero-hud .hud-corner--tl { top: 0; left: 0; border-right: none; border-bottom: none; border-radius: 10px 0 0 0; }
.hero-hud .hud-corner--tr { top: 0; right: 0; border-left: none; border-bottom: none; border-radius: 0 10px 0 0; }
.hero-hud .hud-corner--bl { bottom: 0; left: 0; border-right: none; border-top: none; border-radius: 0 0 0 10px; }
.hero-hud .hud-corner--br { bottom: 0; right: 0; border-left: none; border-top: none; border-radius: 0 0 10px 0; }

.hero-hud .hud-readout {
    position: absolute;
    font-family: var(--mono-font);
    font-size: 0.62rem;
    letter-spacing: 0.08em;
    color: rgba(125,211,252,0.4);
    white-space: nowrap;
}
.hero-hud .hud-readout--tl { top: 10px; left: 46px; }
.hero-hud .hud-readout--br { bottom: 10px; right: 46px; text-align: right; }

.hero-inner {
    position: relative;
    z-index: 2;
    max-width: 1100px;
    margin: 0 auto;
    width: 100%;
    text-align: center;
    color: var(--white);
}

.institute-banner {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    gap: 1rem;
    background: rgba(0,0,0,0.24);
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(18px);
    padding: 0.95rem 1.1rem;
    border-radius: 24px;
    margin: 0 auto 1.4rem;
    max-width: 980px;
}

.institute-banner__logo {
    width: 64px;
    height: 64px;
    min-width: 64px;
    border-radius: 18px;
    overflow: hidden;
    background: rgba(255,255,255,0.08);
    display: grid;
    place-items: center;
}

.institute-banner__logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.institute-banner__text {
    text-align: center;
}

.institute-banner__title {
    font-family: 'Clash Display', sans-serif;
    font-size: 1.1rem;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    font-weight: 700;
    margin: 0;
    color: #ffffff;
}

.institute-banner__subtitle {
    margin: 0.25rem 0 0;
    font-size: 0.95rem;
    color: rgba(255,255,255,0.82);
    font-weight: 400;
}

/* Breadcrumb */
.hero-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: rgba(186,230,253,0.6);
    margin-bottom: 1.5rem;
    letter-spacing: 0.06em;
}

.hero-breadcrumb a { color: inherit; text-decoration: none; transition: color 0.2s; }
.hero-breadcrumb a:hover { color: var(--sky-lt); }
.hero-breadcrumb .sep { opacity: 0.35; }

/* Live pill badge */
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(14px);
    padding: 0.45rem 1.1rem;
    border-radius: 9999px;
    font-size: 0.775rem;
    font-weight: 600;
    color: var(--sky-lt);
    margin-bottom: 1.5rem;
    letter-spacing: 0.04em;
    position: relative;
    overflow: hidden;
}

.hero-badge::before {
    content: '';
    position: absolute;
    top: 0; left: -60%;
    width: 40%; height: 100%;
    background: linear-gradient(100deg, transparent, rgba(0,234,255,0.16), transparent);
    animation: badgeSheen 3.5s ease-in-out infinite;
}

@keyframes badgeSheen {
    0%   { left: -60%; }
    50%  { left: 130%; }
    100% { left: 130%; }
}

.badge-live {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--plasma);
    box-shadow: 0 0 0 0 rgba(0,234,255,0.7);
    animation: livePing 2s ease-in-out infinite;
    position: relative;
    z-index: 1;
}

@keyframes livePing {
    0%  { box-shadow: 0 0 0 0 rgba(0,234,255,0.7); }
    70% { box-shadow: 0 0 0 8px rgba(0,234,255,0); }
    100%{ box-shadow: 0 0 0 0 rgba(0,234,255,0); }
}

/* Hero title */
.hero-title {
    font-family: 'Clash Display', sans-serif;
    font-size: clamp(2.8rem, 7vw, 5.2rem);
    font-weight: 700;
    line-height: 1.04;
    letter-spacing: -0.03em;
    color: var(--white);
    text-shadow: 0 4px 40px rgba(0,0,0,0.4);
    margin: 0 0 1.5rem;
}

.hero-title .gradient-text {
    background: linear-gradient(130deg, var(--sky-lt) 0%, var(--plasma) 45%, var(--holo-lt) 80%, #fff 100%);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
    animation: gradientDrift 6s ease-in-out infinite;
}

@keyframes gradientDrift {
    0%, 100% { background-position: 0% 50%; }
    50%       { background-position: 100% 50%; }
}

/* Hero sub */
.hero-sub {
    font-size: 1.1rem;
    font-weight: 300;
    color: rgba(255,255,255,0.72);
    max-width: 560px;
    margin: 0 auto 2.25rem;
    line-height: 1.7;
}

.hero-sub strong { color: var(--white); font-weight: 600; }

/* Pill nav */
.hero-pill-nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 2.25rem;
}

.hero-pill-nav a {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1rem;
    border-radius: 9999px;
    border: 1px solid rgba(255,255,255,0.2);
    font-size: 0.8rem;
    font-weight: 600;
    color: rgba(255,255,255,0.78);
    text-decoration: none;
    backdrop-filter: blur(8px);
    background: rgba(255,255,255,0.07);
    transition: all 0.25s var(--expo);
}

.hero-pill-nav a:hover {
    background: rgba(255,255,255,0.16);
    border-color: rgba(0,234,255,0.5);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,234,255,0.16);
}

/* CTA buttons */
.hero-ctas {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: center;
    margin-bottom: 3rem;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--white);
    color: var(--ink-mid);
    font-family: 'Clash Display', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.875rem 2rem;
    border-radius: 14px;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2), 0 1px 2px rgba(255,255,255,0.2) inset;
    transition: all 0.3s var(--expo);
}

.btn-primary:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 16px 44px rgba(0,0,0,0.25), 0 0 0 3px rgba(0,234,255,0.25);
    background: #f0f9ff;
}

.btn-primary i { font-size: 0.85rem; transition: transform 0.25s var(--back); }
.btn-primary:hover i { transform: translateX(4px); }

.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.1);
    border: 1.5px solid rgba(255,255,255,0.28);
    color: var(--white);
    font-family: 'Clash Display', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.875rem 2rem;
    border-radius: 14px;
    text-decoration: none;
    backdrop-filter: blur(10px);
    transition: all 0.3s var(--expo);
}

.btn-ghost:hover {
    background: rgba(255,255,255,0.18);
    border-color: rgba(0,234,255,0.55);
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(0,0,0,0.2), 0 0 24px rgba(0,234,255,0.15);
}

/* Glass stat cards */
.hero-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    max-width: 720px;
    margin: 0 auto;
}

.glass-stat {
    background: rgba(255,255,255,0.09);
    border: 1px solid rgba(255,255,255,0.16);
    backdrop-filter: blur(16px);
    border-radius: 18px;
    padding: 1.25rem 1rem;
    text-align: center;
    transition: all 0.35s var(--expo);
    cursor: default;
    position: relative;
    overflow: hidden;
}

.glass-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0,234,255,0.4), transparent);
}

.glass-stat:hover {
    background: rgba(255,255,255,0.16);
    border-color: rgba(0,234,255,0.3);
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.22), var(--shadow-glow);
}

.glass-stat .sv {
    display: block;
    font-family: var(--mono-font);
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--white);
    line-height: 1;
    margin-bottom: 0.4rem;
    text-shadow: 0 0 18px rgba(0,234,255,0.35);
}

.glass-stat .sk {
    font-size: 0.68rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: var(--sky-lt);
}

/* Scroll hint */
.scroll-hint {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255,255,255,0.5);
    font-size: 0.75rem;
    text-align: center;
    animation: hintBounce 2.2s ease-in-out infinite;
    text-decoration: none;
    transition: color 0.2s;
}

.scroll-hint:hover { color: rgba(255,255,255,0.85); }

@keyframes hintBounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(8px); }
}

/* ═══════════════════════════════════════════════════
   MARQUEE STRIP
═══════════════════════════════════════════════════ */
.marquee-section {
    background: var(--white);
    border-top: 1px solid var(--slate-200);
    border-bottom: 1px solid var(--slate-200);
    padding: 1.1rem 0;
    overflow: hidden;
    position: relative;
}

.marquee-mask {
    mask-image: linear-gradient(90deg, transparent 0, black 10%, black 90%, transparent 100%);
    -webkit-mask-image: linear-gradient(90deg, transparent 0, black 10%, black 90%, transparent 100%);
}

.marquee-track {
    display: flex;
    width: max-content;
    gap: 0;
    animation: marqueeScroll 28s linear infinite;
}

.marquee-track:hover { animation-play-state: paused; }

@keyframes marqueeScroll {
    to { transform: translateX(-50%); }
}

.marquee-item {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0 1.75rem;
    font-family: var(--mono-font);
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--navy);
    white-space: nowrap;
    letter-spacing: 0.02em;
}

.marquee-dot {
    width: 5px; height: 5px;
    border-radius: 50%;
    background: var(--sky);
    opacity: 0.5;
    flex-shrink: 0;
}

/* ═══════════════════════════════════════════════════
   SECTION HEADERS
═══════════════════════════════════════════════════ */
.section-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: var(--mono-font);
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.16em;
    padding: 0.45rem 1rem;
    border-radius: 9999px;
    margin-bottom: 1.25rem;
}

.eyebrow-navy  { background: rgba(0,58,143,0.08); color: var(--navy); border: 1px solid rgba(0,58,143,0.14); }
.eyebrow-amber { background: rgba(245,158,11,0.1); color: #92400e; border: 1px solid rgba(245,158,11,0.2); }
.eyebrow-green { background: rgba(16,185,129,0.1); color: #065f46; border: 1px solid rgba(16,185,129,0.18); }

.section-title {
    font-family: 'Clash Display', sans-serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -0.025em;
    line-height: 1.1;
    margin: 0 0 1rem;
}

.section-sub {
    font-size: 1rem;
    font-weight: 300;
    color: var(--slate-600);
    max-width: 540px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ═══════════════════════════════════════════════════
   FEATURES SECTION
═══════════════════════════════════════════════════ */
#features {
    padding: 7rem 1.5rem;
    background: var(--white);
    position: relative;
    overflow: hidden;
}

/* Diagonal accent */
#features::before {
    content: '';
    position: absolute;
    top: -80px; right: -120px;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,234,255,0.08) 0%, transparent 70%);
    pointer-events: none;
}

#features::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -80px;
    width: 380px; height: 380px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(139,92,246,0.07) 0%, transparent 70%);
    pointer-events: none;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    max-width: 1100px;
    margin: 0 auto;
}

.feature-card {
    background: var(--white);
    border: 1px solid var(--slate-200);
    border-radius: 20px;
    padding: 2rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s var(--expo);
    box-shadow: var(--shadow-sm);
}

.feature-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,58,143,0.03) 0%, transparent 60%);
    border-radius: 20px;
    opacity: 0;
    transition: opacity 0.35s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl), var(--shadow-holo);
    border-color: rgba(0,234,255,0.35);
}

.feature-card:hover::before { opacity: 1; }

/* Shimmer on hover */
.feature-card::after {
    content: '';
    position: absolute;
    top: 0; left: -100%;
    width: 55%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0,234,255,0.07), transparent);
    transform: skewX(-18deg);
    transition: left 0.65s ease;
}

.feature-card:hover::after { left: 160%; }

.feature-icon {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 1.25rem;
    transition: transform 0.35s var(--back), box-shadow 0.35s ease;
    position: relative;
    z-index: 1;
}

.feature-card:hover .feature-icon {
    transform: translateY(-4px) scale(1.1);
}

.fi-blue   { background: rgba(0,58,143,0.09);  color: var(--navy);    box-shadow: 0 8px 20px rgba(0,58,143,0.14); }
.fi-sky    { background: rgba(56,189,248,0.1);  color: #0284c7;        box-shadow: 0 8px 20px rgba(56,189,248,0.16); }
.fi-indigo { background: rgba(99,102,241,0.1);  color: #4338ca;        box-shadow: 0 8px 20px rgba(99,102,241,0.14); }
.fi-green  { background: rgba(16,185,129,0.1);  color: #059669;        box-shadow: 0 8px 20px rgba(16,185,129,0.14); }
.fi-amber  { background: rgba(245,158,11,0.1);  color: #b45309;        box-shadow: 0 8px 20px rgba(245,158,11,0.14); }
.fi-slate  { background: rgba(100,116,139,0.09);color: var(--ink-mid); box-shadow: 0 8px 20px rgba(100,116,139,0.12); }

.feature-title {
    font-family: 'Clash Display', sans-serif;
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--ink);
    margin: 0 0 0.6rem;
    line-height: 1.2;
}

.feature-desc {
    font-size: 0.875rem;
    font-weight: 300;
    color: var(--slate-600);
    line-height: 1.65;
    margin: 0;
}

/* ═══════════════════════════════════════════════════
   HOW IT WORKS
═══════════════════════════════════════════════════ */
#how-it-works {
    padding: 7rem 1.5rem;
    background: linear-gradient(160deg, var(--slate-100) 0%, rgba(186,230,253,0.2) 40%, var(--slate-100) 100%);
    position: relative;
    overflow: hidden;
}

.how-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    max-width: 1100px;
    margin: 0 auto;
    position: relative;
}

/* Animated connector line */
.how-grid::before {
    content: '';
    position: absolute;
    top: 28px;
    left: calc(12.5% + 16px);
    right: calc(12.5% + 16px);
    height: 2px;
    background: linear-gradient(90deg, var(--navy), var(--plasma), var(--holo), var(--navy));
    background-size: 200% 100%;
    animation: connectorShimmer 3s linear infinite;
    transform-origin: left;
    transform: scaleX(0);
    transition: transform 1.4s var(--expo) 0.3s;
    z-index: 0;
    display: none;
}

@media (min-width: 768px) { .how-grid::before { display: block; } }

.how-grid.line-drawn::before { transform: scaleX(1); }

@keyframes connectorShimmer {
    to { background-position: -200% 0; }
}

.step-card {
    background: var(--white);
    border: 1px solid var(--slate-200);
    border-radius: 20px;
    padding: 1.75rem 1.5rem;
    text-align: center;
    position: relative;
    box-shadow: var(--shadow-sm);
    transition: all 0.4s var(--expo);
    z-index: 1;
}

.step-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
    border-color: rgba(0,58,143,0.2);
}

.step-tag {
    font-family: var(--mono-font);
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    color: var(--slate-400);
    text-transform: uppercase;
    margin-bottom: 0.9rem;
    display: block;
}

.step-num {
    width: 56px; height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Clash Display', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--white);
    margin: 0 auto 1.2rem;
    box-shadow: var(--shadow-md);
    transition: transform 0.35s var(--back), box-shadow 0.35s ease;
}

.step-card:hover .step-num {
    transform: scale(1.12) rotate(-4deg);
    box-shadow: var(--shadow-lg);
}

.sn-1 { background: linear-gradient(135deg, var(--navy), var(--navy-lt)); }
.sn-2 { background: linear-gradient(135deg, #1e4976, var(--navy)); }
.sn-3 { background: linear-gradient(135deg, var(--ink-mid), #1e4976); }
.sn-4 { background: linear-gradient(135deg, #059669, #10b981); }

/* Timeline dot */
.step-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    background: var(--navy);
    box-shadow: 0 0 0 4px rgba(0,58,143,0.18);
    margin: 0 auto 0.75rem;
    opacity: 0;
    transform: scale(0);
    transition: opacity 0.4s var(--expo), transform 0.4s var(--back);
    display: none;
}

@media (min-width: 768px) { .step-dot { display: block; } }

.step-card.dot-visible .step-dot {
    opacity: 1;
    transform: scale(1);
}

.step-title {
    font-family: 'Clash Display', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: var(--ink);
    margin: 0 0 0.5rem;
}

.step-desc {
    font-size: 0.82rem;
    font-weight: 300;
    color: var(--slate-600);
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 767px) {
    .how-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
    .how-grid { grid-template-columns: 1fr; }
}

/* ═══════════════════════════════════════════════════
   QUICK LINKS
═══════════════════════════════════════════════════ */
#explore {
    padding: 5rem 1.5rem;
    background: var(--white);
}

.explore-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    max-width: 900px;
    margin: 0 auto;
}

@media (max-width: 640px) { .explore-grid { grid-template-columns: 1fr; } }

.explore-card {
    display: block;
    text-decoration: none;
    background: var(--white);
    border: 1.5px solid var(--slate-200);
    border-radius: 18px;
    padding: 1.75rem 1.5rem;
    transition: all 0.35s var(--expo);
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.explore-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,58,143,0.04), transparent);
    opacity: 0;
    transition: opacity 0.3s;
    border-radius: 18px;
}

.explore-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-xl);
    border-color: rgba(0,234,255,0.45);
}

.explore-card:hover::after { opacity: 1; }

.explore-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: rgba(0,58,143,0.08);
    color: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    transition: transform 0.3s var(--back), background 0.3s ease;
}

.explore-card:hover .explore-icon {
    transform: scale(1.12) rotate(-3deg);
    background: rgba(0,58,143,0.14);
}

.explore-title {
    font-family: 'Clash Display', sans-serif;
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--ink);
    margin: 0 0 0.35rem;
}

.explore-desc {
    font-size: 0.8rem;
    color: var(--slate-400);
    margin: 0 0 1rem;
    font-weight: 300;
}

.explore-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--navy);
}

.explore-link i {
    font-size: 0.65rem;
    transition: transform 0.25s var(--back);
}

.explore-card:hover .explore-link i { transform: translateX(4px); }

/* ═══════════════════════════════════════════════════
   TESTIMONIALS
═══════════════════════════════════════════════════ */
#testimonials {
    padding: 7rem 1.5rem;
    background: var(--slate-100);
    position: relative;
    overflow: hidden;
}

#testimonials::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--navy), var(--plasma), var(--holo), transparent);
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    max-width: 1100px;
    margin: 0 auto;
}

@media (max-width: 900px) { .testimonials-grid { grid-template-columns: 1fr; max-width: 520px; } }

.testimonial-card {
    background: var(--white);
    border: 1px solid var(--slate-200);
    border-top: 3px solid;
    border-image: linear-gradient(90deg, var(--navy), var(--plasma)) 1;
    border-radius: 0 0 18px 18px;
    padding: 1.75rem;
    box-shadow: var(--shadow-sm);
    transition: all 0.4s var(--expo);
    display: flex;
    flex-direction: column;
}

.testimonial-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.testimonial-header {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 1.1rem;
}

.t-avatar {
    width: 46px; height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Clash Display', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--white);
    flex-shrink: 0;
    box-shadow: var(--shadow-md);
}

.ta-1 { background: linear-gradient(135deg, var(--navy), var(--navy-lt)); }
.ta-2 { background: linear-gradient(135deg, #1e4976, #0f52c8); }
.ta-3 { background: linear-gradient(135deg, var(--ink-mid), #1e4976); }

.t-name {
    font-family: 'Clash Display', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--ink);
    margin: 0 0 0.15rem;
}

.t-role {
    font-size: 0.75rem;
    color: var(--slate-400);
    font-weight: 400;
    margin: 0;
}

.t-stars {
    color: var(--amber);
    font-size: 0.75rem;
    margin-bottom: 0.85rem;
    letter-spacing: 0.08em;
}

.t-quote {
    font-size: 0.875rem;
    font-weight: 300;
    color: var(--slate-600);
    line-height: 1.7;
    font-style: italic;
    margin: 0;
    flex: 1;
}

/* ═══════════════════════════════════════════════════
   CTA BANNER
═══════════════════════════════════════════════════ */
#cta-banner {
    padding: 5.5rem 1.5rem;
    background: linear-gradient(150deg, var(--void) 0%, var(--ink-mid) 40%, var(--navy) 80%, #0f52c8 100%);
    color: var(--white);
    text-align: center;
    position: relative;
    overflow: hidden;
}

#cta-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(0,234,255,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,234,255,0.05) 1px, transparent 1px);
    background-size: 64px 64px;
    animation: gridPan 18s linear infinite;
}

.cta-orb-1 {
    position: absolute;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,234,255,0.12) 0%, transparent 70%);
    top: -160px; right: -100px;
    animation: orbDrift1 9s ease-in-out infinite alternate;
    filter: blur(40px);
}

.cta-orb-2 {
    position: absolute;
    width: 350px; height: 350px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 70%);
    bottom: -100px; left: -80px;
    animation: orbDrift2 11s ease-in-out infinite alternate;
    filter: blur(40px);
}

/* Shimmer sweep on CTA */
.cta-shimmer {
    position: absolute;
    inset: 0;
    background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,0.04) 50%, transparent 70%);
    background-size: 220% 100%;
    animation: shimmerSweep 5s ease-in-out infinite;
}

#cta-banner .cta-inner {
    position: relative;
    z-index: 2;
    max-width: 680px;
    margin: 0 auto;
}

#cta-banner .section-title { color: var(--white); }

#cta-banner .section-sub {
    color: rgba(255,255,255,0.65);
    margin-bottom: 2.25rem;
}

/* ═══════════════════════════════════════════════════
   FAQ
═══════════════════════════════════════════════════ */
#faq {
    padding: 7rem 1.5rem;
    background: var(--white);
}

.faq-list {
    max-width: 720px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
}

details.faq-item {
    background: var(--white);
    border: 1.5px solid var(--slate-200);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

details.faq-item[open] {
    border-color: rgba(0,234,255,0.45);
    box-shadow: var(--shadow-md), 0 0 0 3px rgba(0,234,255,0.08);
}

details.faq-item summary {
    list-style: none;
    cursor: pointer;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    user-select: none;
}

details.faq-item summary::-webkit-details-marker { display: none; }

.faq-index {
    font-family: var(--mono-font);
    font-size: 0.7rem;
    color: var(--slate-400);
    margin-right: 0.5rem;
}

.faq-q {
    font-family: 'Clash Display', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.3;
}

.faq-chevron {
    width: 28px; height: 28px;
    border-radius: 8px;
    background: rgba(0,58,143,0.07);
    color: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.75rem;
    transition: all 0.3s var(--expo);
}

details.faq-item[open] .faq-chevron {
    transform: rotate(180deg);
    background: var(--navy);
    color: var(--white);
}

.faq-a {
    padding: 0 1.5rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 300;
    color: var(--slate-600);
    line-height: 1.7;
    border-top: 1px solid var(--slate-100);
    padding-top: 1rem;
}

/* ═══════════════════════════════════════════════════
   SCROLL TO TOP
═══════════════════════════════════════════════════ */
#scroll-top {
    position: fixed;
    bottom: 1.75rem;
    right: 1.75rem;
    width: 44px; height: 44px;
    background: linear-gradient(135deg, var(--navy), var(--ink-mid));
    color: var(--white);
    border: none;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    cursor: pointer;
    z-index: 100;
    box-shadow: var(--shadow-lg);
    opacity: 0;
    transform: translateY(20px);
    pointer-events: none;
    transition: all 0.35s var(--expo);
}

#scroll-top.visible {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}

#scroll-top:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl), var(--shadow-glow);
}

#scroll-top svg {
    position: absolute;
    inset: 0;
    width: 44px; height: 44px;
    transform: rotate(-90deg);
    pointer-events: none;
}

#scroll-top svg circle {
    fill: none;
    stroke: url(#scrollTopGradient);
    stroke-width: 2;
    stroke-linecap: round;
    stroke-dasharray: 116;
    stroke-dashoffset: 116;
    transition: stroke-dashoffset 0.1s linear;
}

#scroll-top i { position: relative; z-index: 1; }

/* ═══════════════════════════════════════════════════
   FEATURE CARDS — INDEX BADGE + TILT + GRADIENT BORDER
═══════════════════════════════════════════════════ */
.feature-card {
    --mx: 50%;
    --my: 50%;
    transform-style: preserve-3d;
    will-change: transform;
    transition: box-shadow 0.4s var(--expo), border-color 0.4s var(--expo), transform 0.15s ease-out;
}

.feature-index {
    position: absolute;
    top: 1.5rem;
    right: 1.75rem;
    font-family: var(--mono-font);
    font-size: 0.68rem;
    font-weight: 700;
    color: var(--slate-400);
    letter-spacing: 0.03em;
    opacity: 0.6;
    z-index: 1;
    transition: opacity 0.35s ease, transform 0.35s var(--back), color 0.35s ease;
}

.feature-card:hover .feature-index {
    opacity: 1;
    color: var(--plasma-2);
    transform: translateY(-2px);
}

/* Radial spotlight that follows the cursor */
.feature-card .card-spotlight {
    position: absolute;
    inset: 0;
    z-index: 0;
    border-radius: 20px;
    opacity: 0;
    transition: opacity 0.4s ease;
    background: radial-gradient(340px circle at var(--mx) var(--my), rgba(0,234,255,0.14), transparent 60%);
    pointer-events: none;
}

.feature-card:hover .card-spotlight { opacity: 1; }

/* Animated gradient outline sweep */
.feature-card .card-edge {
    position: absolute;
    inset: 0;
    border-radius: 20px;
    padding: 1.5px;
    background: conic-gradient(from var(--edge-angle, 0deg), transparent 0 65%, var(--plasma) 80%, var(--holo) 90%, transparent 100%);
    -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.4s ease;
    animation: edgeSpin 3.4s linear infinite;
    animation-play-state: paused;
    pointer-events: none;
}

.feature-card:hover .card-edge {
    opacity: 1;
    animation-play-state: running;
}

@keyframes edgeSpin {
    to { --edge-angle: 360deg; }
}

@property --edge-angle {
    syntax: '<angle>';
    inherits: false;
    initial-value: 0deg;
}

.feature-card > * { position: relative; }

/* ═══════════════════════════════════════════════════
   MAGNETIC BUTTONS + RIPPLE
═══════════════════════════════════════════════════ */
.btn-primary, .btn-ghost {
    position: relative;
    overflow: hidden;
    will-change: transform;
}

.btn-ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(0,234,255,0.35);
    transform: scale(0);
    animation: rippleOut 0.65s var(--expo) forwards;
    pointer-events: none;
}

.btn-primary .btn-ripple { background: rgba(0,58,143,0.16); }

@keyframes rippleOut {
    to { transform: scale(1); opacity: 0; }
}

/* ═══════════════════════════════════════════════════
   HERO SIGNATURE — ORBITING SKILL PATHS
═══════════════════════════════════════════════════ */
.hero-orbit {
    position: absolute;
    top: 50%;
    right: -170px;
    width: 480px;
    height: 480px;
    margin-top: -240px;
    z-index: 0;
    pointer-events: none;
    opacity: 0;
    animation: orbitFadeIn 1.4s var(--expo) 1s forwards;
    display: none;
}

@media (min-width: 1600px) { .hero-orbit { display: block; } }

@keyframes orbitFadeIn {
    to { opacity: 1; }
}

.hero-orbit .orbit-ring {
    position: absolute;
    inset: 0;
    border: 1px solid rgba(186,230,253,0.14);
    border-radius: 50%;
}

.hero-orbit .orbit-ring--inner {
    inset: 70px;
    border-style: dashed;
    border-color: rgba(139,92,246,0.14);
}

.hero-orbit .orbit-spin {
    position: absolute;
    inset: 0;
    animation: orbitSpin 34s linear infinite;
}

.hero-orbit .orbit-spin--rev {
    animation-direction: reverse;
    animation-duration: 46s;
    inset: 70px;
}

@keyframes orbitSpin {
    to { transform: rotate(360deg); }
}

.orbit-node {
    position: absolute;
    width: 46px; height: 46px;
    border-radius: 13px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.16);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--plasma-2);
    font-size: 1rem;
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    animation: orbitCounterSpin 34s linear infinite;
}

.orbit-spin--rev .orbit-node { animation-duration: 46s; color: var(--holo-lt); }

@keyframes orbitCounterSpin {
    to { transform: rotate(-360deg); }
}

.orbit-node--1 { top: -23px; left: 50%; margin-left: -23px; }
.orbit-node--2 { top: 50%; right: -23px; margin-top: -23px; }
.orbit-node--3 { bottom: -23px; left: 50%; margin-left: -23px; }
.orbit-node--4 { top: 50%; left: -23px; margin-top: -23px; }

.orbit-node--5 { top: -21px; left: 50%; margin-left: -21px; width: 42px; height: 42px; }
.orbit-node--6 { bottom: -21px; left: 50%; margin-left: -21px; width: 42px; height: 42px; }

.hero-orbit .orbit-core {
    position: absolute;
    top: 50%; left: 50%;
    width: 10px; height: 10px;
    margin: -5px 0 0 -5px;
    border-radius: 50%;
    background: var(--plasma);
    box-shadow: 0 0 0 6px rgba(0,234,255,0.16), 0 0 24px rgba(0,234,255,0.7);
    animation: livePing 2.4s ease-in-out infinite;
}

/* ═══════════════════════════════════════════════════
   TESTIMONIAL QUOTE GLYPH
═══════════════════════════════════════════════════ */
.testimonial-card {
    position: relative;
}

.t-quote-mark {
    position: absolute;
    top: 0.9rem;
    right: 1.25rem;
    font-family: 'Clash Display', sans-serif;
    font-size: 2.75rem;
    font-weight: 700;
    color: rgba(0,58,143,0.07);
    line-height: 1;
    pointer-events: none;
    transition: color 0.4s ease, transform 0.4s var(--expo);
}

.testimonial-card:hover .t-quote-mark {
    color: rgba(0,234,255,0.18);
    transform: scale(1.08) rotate(-4deg);
}

/* ═══════════════════════════════════════════════════
   STEP ICON CHIP
═══════════════════════════════════════════════════ */
.step-icon-chip {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 28px; height: 28px;
    border-radius: 9px;
    background: var(--white);
    border: 1px solid var(--slate-200);
    color: var(--navy);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    box-shadow: var(--shadow-sm);
    transition: transform 0.35s var(--back), box-shadow 0.3s ease;
}

.step-card:hover .step-icon-chip {
    transform: scale(1.15) rotate(8deg);
    box-shadow: var(--shadow-md);
}

.step-num-wrap { position: relative; display: inline-block; }

/* ═══════════════════════════════════════════════════
   REDUCED MOTION
═══════════════════════════════════════════════════ */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }

    [data-sr], .hero-sr { opacity: 1 !important; transform: none !important; filter: none !important; }
    #cursor-dot, #cursor-ring { display: none; }
}

/* ═══════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════ */
@media (max-width: 768px) {
    #hero { padding: 6.5rem 1.25rem 4.5rem; }
    .hero-stats-row { grid-template-columns: 1fr 1fr 1fr; gap: 0.5rem; }
    .glass-stat { padding: 1rem 0.75rem; }
    .glass-stat .sv { font-size: 1.4rem; }
    .features-grid { grid-template-columns: 1fr; }
    .hero-title { font-size: 2.5rem; }
    .hero-hud { display: none; }
    .institute-banner {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 0.85rem 0.9rem;
    }
    .institute-banner__logo {
        width: 52px;
        height: 52px;
        min-width: 52px;
    }
    .institute-banner__title {
        font-size: 0.98rem;
    }
    .institute-banner__subtitle {
        font-size: 0.88rem;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div id="cursor-dot" aria-hidden="true"></div>
<div id="cursor-ring" aria-hidden="true"></div>
<canvas id="cursor-trail" aria-hidden="true"></canvas>


<div id="scroll-progress" aria-hidden="true"></div>


<div id="splash" aria-hidden="true" role="presentation">
    <div class="splash-grid"></div>
    <div class="splash-orb splash-orb-1"></div>
    <div class="splash-orb splash-orb-2"></div>
    <div class="splash-orb splash-orb-3"></div>
    <div class="splash-scan"></div>
    <div class="splash-beam"></div>

    
    <div class="splash-corner splash-corner--tl"></div>
    <div class="splash-corner splash-corner--tr"></div>
    <div class="splash-corner splash-corner--bl"></div>
    <div class="splash-corner splash-corner--br"></div>

    
    <div class="splash-tele splash-tele--tl">SYS// SKILLUP-OS<br>BUILD 2.4.0-ALPHA</div>
    <div class="splash-tele splash-tele--br">NODE// PH-APAT-01<br>LINK: SECURE</div>

    
    <div class="splash-ring" style="width:300px;height:300px;animation-delay:0s;animation-duration:3.6s;"></div>
    <div class="splash-ring" style="width:300px;height:300px;animation-delay:1.2s;animation-duration:3.6s;"></div>
    <div class="splash-ring" style="width:300px;height:300px;animation-delay:2.4s;animation-duration:3.6s;"></div>

    
    <div id="splash-particles"></div>

    
    <div class="splash-content">
        <div class="splash-logo" id="splash-logo">
            <i class="fas fa-bolt text-white" style="font-size:2.2rem;position:relative;z-index:2;"></i>
        </div>

        <div class="splash-wordmark" id="splash-wordmark" data-suffix="Up">
            Skill<span class="accent">Up</span>
        </div>

        <div class="splash-tagline" id="splash-tagline">
            Your Career &nbsp;·&nbsp; Your Future<span class="blink-cursor">_</span>
        </div>

        <div class="splash-bar-wrap" id="splash-bar-wrap">
            <div class="splash-bar" id="splash-bar"></div>
        </div>

        <div class="splash-status" id="splash-status">Initializing&hellip;</div>

        <div class="splash-dots" id="splash-dots">
            <div class="sd"></div>
            <div class="sd"></div>
            <div class="sd"></div>
        </div>
    </div>
</div>


<section id="hero">
    <img
        src="<?php echo e(asset('image/API.jpg')); ?>"
        alt="Aparri Polytechnic Institute"
        class="hero-bg-img"
        loading="eager"
        fetchpriority="high"
    >
    <div class="hero-overlay-1"></div>
    <div class="hero-overlay-2"></div>

    
    <svg class="hero-circuits" viewBox="0 0 1200 800" preserveAspectRatio="none" aria-hidden="true">
        <defs>
            <linearGradient id="circuitGrad" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#00eaff" stop-opacity="0.5"/>
                <stop offset="100%" stop-color="#8b5cf6" stop-opacity="0.35"/>
            </linearGradient>
        </defs>
        <g fill="none" stroke="url(#circuitGrad)" stroke-width="1">
            <path d="M0,120 H260 L300,160 H620"/>
            <path d="M0,420 H180 L220,460 H520 L560,420 H900"/>
            <path d="M1200,90 H940 L900,130 H700"/>
            <path d="M1200,560 H980 L940,600 H600 L560,640 H260"/>
            <path d="M300,160 V0"/>
            <path d="M700,130 V0"/>
            <path d="M560,640 V800"/>
            <path d="M900,420 V800"/>
        </g>
        <g fill="#00eaff" opacity="0.6">
            <circle cx="300" cy="160" r="3"/>
            <circle cx="620" cy="160" r="3"/>
            <circle cx="560" cy="420" r="3"/>
            <circle cx="700" cy="130" r="3"/>
            <circle cx="560" cy="640" r="3"/>
            <circle cx="900" cy="420" r="3"/>
        </g>
    </svg>

    <div class="hero-shimmer" aria-hidden="true"></div>
    <canvas id="hero-canvas" aria-hidden="true"></canvas>

    
    <div class="hero-hud" aria-hidden="true">
        <div class="hud-corner hud-corner--tl"></div>
        <div class="hud-corner hud-corner--tr"></div>
        <div class="hud-corner hud-corner--bl"></div>
        <div class="hud-corner hud-corner--br"></div>
        <div class="hud-readout hud-readout--tl">SKILLUP // CAREER OS<br>SESSION ACTIVE</div>
        <div class="hud-readout hud-readout--br" id="hud-clock">LAT 18.36°N // LNG 121.64°E</div>
    </div>

    
    <div class="hero-orbit" aria-hidden="true">
        <div class="orbit-ring"></div>
        <div class="orbit-ring orbit-ring--inner"></div>
        <div class="orbit-spin">
            <div class="orbit-node orbit-node--1"><i class="fas fa-code"></i></div>
            <div class="orbit-node orbit-node--2"><i class="fas fa-paintbrush"></i></div>
            <div class="orbit-node orbit-node--3"><i class="fas fa-chart-pie"></i></div>
            <div class="orbit-node orbit-node--4"><i class="fas fa-bullhorn"></i></div>
        </div>
        <div class="orbit-spin orbit-spin--rev">
            <div class="orbit-node orbit-node--5"><i class="fas fa-camera"></i></div>
            <div class="orbit-node orbit-node--6"><i class="fas fa-server"></i></div>
        </div>
        <div class="orbit-core"></div>
    </div>

    <div class="hero-inner">

       
        
        <nav class="hero-breadcrumb hero-sr hero-sr-1" aria-label="Site position">
            <a href="/"><i class="fas fa-home text-xs"></i> Home</a>
            <span class="sep">/</span>
            <span style="color:rgba(186,230,253,0.85);font-weight:600;">Welcome</span>
        </nav>

        
        <div class="hero-sr hero-sr-2" style="margin-bottom:1.5rem;">
            <span class="hero-badge">
                <span class="badge-live"></span>
                OIF SkillUp &nbsp;·&nbsp; Youth Career Development &nbsp;·&nbsp; TESDA-aligned
            </span>
        </div>
 <div class="institute-banner">
            <div class="institute-banner__logo">
                <img src="<?php echo e(asset('image/logo new.jpg')); ?>" alt="APARRI Polytechnic Institute logo">
            </div>
            <div class="institute-banner__text">
                <p class="institute-banner__title">APARRI POLYTECHNIC INSTITUTE</p>
                <p class="institute-banner__subtitle">The "Center of Technical Excellence"</p>
            </div>
            <div class="institute-banner__logo">
                <img src="<?php echo e(asset('image/hello.png')); ?>" alt="Right-side logo">
            </div>
        </div>

        
        <h1 class="hero-title hero-sr hero-sr-3">
            Launch your career<br>
            with <span class="gradient-text">confidence</span>
        </h1>

        
        <p class="hero-sub hero-sr hero-sr-4">
            SkillUp is your personalized learning portal — discover your strengths,
            build <strong>in-demand skills</strong>, and connect with mentors
            and real-world opportunities.
        </p>

        
        <nav class="hero-pill-nav hero-sr hero-sr-5" aria-label="Page sections">
            <a href="#features"><i class="fas fa-star" style="font-size:0.65rem;"></i> Features</a>
            <a href="#how-it-works"><i class="fas fa-route" style="font-size:0.65rem;"></i> How it works</a>
            <a href="#testimonials"><i class="fas fa-heart" style="font-size:0.65rem;"></i> Stories</a>
            <a href="#faq"><i class="fas fa-question-circle" style="font-size:0.65rem;"></i> FAQ</a>
        </nav>

        
        <div class="hero-ctas hero-sr hero-sr-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('courses.index')); ?>" class="btn-primary">
                    Continue learning <i class="fas fa-arrow-right"></i>
                </a>
                <a href="<?php echo e(route('userpage.dashboard')); ?>" class="btn-ghost">
                    <i class="fas fa-th-large" style="font-size:0.8rem;"></i> Dashboard
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('register')); ?>" class="btn-primary">
                    Get started free <i class="fas fa-arrow-right"></i>
                </a>
                <a href="<?php echo e(route('login')); ?>" class="btn-ghost">
                    <i class="fas fa-sign-in-alt" style="font-size:0.8rem;"></i> Sign in
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="hero-stats-row hero-sr hero-sr-7">
            <div class="glass-stat">
                <span class="sv" data-count="10000" data-suffix="+" data-format="k">10K+</span>
                <span class="sk"><i class="fas fa-users" style="margin-right:0.3rem;opacity:0.7;"></i>Learners</span>
            </div>
            <div class="glass-stat">
                <span class="sv" data-count="50" data-suffix="+">50+</span>
                <span class="sk"><i class="fas fa-route" style="margin-right:0.3rem;opacity:0.7;"></i>Career paths</span>
            </div>
            <div class="glass-stat">
                <span class="sv" data-count="4.8" data-suffix="★" data-decimal>4.8★</span>
                <span class="sk"><i class="fas fa-star" style="margin-right:0.3rem;opacity:0.7;"></i>Rating</span>
            </div>
        </div>
    </div>

    <a href="#features" class="scroll-hint" aria-label="Scroll to features">
        <div><i class="fas fa-chevron-down" style="font-size:1.1rem;"></i></div>
    </a>
</section>


<div class="marquee-section" aria-label="Platform highlights">
    <div class="marquee-mask">
        <div class="marquee-track" aria-hidden="true">
            <?php
                $tags = ['Personalized Paths','AI Tutor','Expert Mentors','Certificates','Career Roadmap','50+ Courses','TESDA-aligned','Free to Join','Progress Tracking','Job Matching','Community','Badges','Skill Assessments','Micro-learning'];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = array_merge($tags, $tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <span class="marquee-item">
                    <span class="marquee-dot"></span> <?php echo e($tag); ?>

                </span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</div>


<section id="features">
    <div style="max-width:1100px;margin:0 auto;text-align:center;margin-bottom:3.5rem;">
        <div data-sr data-sr-d="1">
            <span class="section-eyebrow eyebrow-navy">
                <i class="fas fa-bolt" style="font-size:0.65rem;"></i> Platform Features
            </span>
        </div>
        <h2 class="section-title" data-sr data-sr-d="2">Everything you need to grow</h2>
        <p class="section-sub" data-sr data-sr-d="3">Powerful tools designed for youth — from first skill to first job</p>
    </div>

    <div class="features-grid">
        <?php
            $features = [
                ['icon'=>'fa-brain',      'fi'=>'fi-blue',   'title'=>'Personalized Paths',       'desc'=>'AI-powered learning journeys tailored to your career goals, pace, and interests.'],
                ['icon'=>'fa-user-tie',   'fi'=>'fi-sky',    'title'=>'Expert Mentorship',         'desc'=>'Connect with verified industry professionals for guidance, feedback, and real-world insight.'],
                ['icon'=>'fa-briefcase',  'fi'=>'fi-indigo', 'title'=>'Job & Internship Matching', 'desc'=>'Discover opportunities perfectly aligned with your growing skillset and career aspirations.'],
                ['icon'=>'fa-certificate','fi'=>'fi-green',  'title'=>'Credentials & Badges',      'desc'=>'Build a portfolio of verified achievements you can proudly share with employers.'],
                ['icon'=>'fa-chart-line', 'fi'=>'fi-amber',  'title'=>'Progress Analytics',        'desc'=>'Visualize your learning journey with rich insights, streaks, and milestone tracking.'],
                ['icon'=>'fa-users',      'fi'=>'fi-slate',  'title'=>'Community & Collaboration', 'desc'=>'Connect with peers, share knowledge, and grow alongside a motivated learning community.'],
            ];
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="feature-card" data-sr data-sr-d="<?php echo e(min($i % 3 + 1, 5)); ?>" data-tilt>
                <div class="card-spotlight" aria-hidden="true"></div>
                <div class="card-edge" aria-hidden="true"></div>
                <span class="feature-index">MOD_<?php echo e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?></span>
                <div class="feature-icon <?php echo e($f['fi']); ?>">
                    <i class="fas <?php echo e($f['icon']); ?>"></i>
                </div>
                <h3 class="feature-title"><?php echo e($f['title']); ?></h3>
                <p class="feature-desc"><?php echo e($f['desc']); ?></p>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</section>


<section id="how-it-works">
    <div style="max-width:1100px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:3.5rem;">
            <div data-sr data-sr-d="1">
                <span class="section-eyebrow eyebrow-navy">
                    <i class="fas fa-compass" style="font-size:0.65rem;"></i> Simple Process
                </span>
            </div>
            <h2 class="section-title" data-sr data-sr-d="2">How SkillUp works</h2>
            <p class="section-sub" data-sr data-sr-d="3">Four clear steps from curiosity to career</p>
        </div>

        <div class="how-grid" id="how-grid">
            <?php
                $steps = [
                    ['n'=>'1','sn'=>'sn-1','tag'=>'STEP // 01','icon'=>'fa-magnifying-glass','title'=>'Discover Your Path',  'desc'=>'Take a quick assessment and define your career goal and learning style.'],
                    ['n'=>'2','sn'=>'sn-2','tag'=>'STEP // 02','icon'=>'fa-book-open',       'title'=>'Learn & Practice',    'desc'=>'Engage with curated courses, quizzes, and bite-sized micro-learning modules.'],
                    ['n'=>'3','sn'=>'sn-3','tag'=>'STEP // 03','icon'=>'fa-comments',        'title'=>'Get Guidance',        'desc'=>'Receive personalized feedback from expert mentors and your peer community.'],
                    ['n'=>'4','sn'=>'sn-4','tag'=>'STEP // 04','icon'=>'fa-briefcase',       'title'=>'Land Opportunities',  'desc'=>'Apply to matched jobs and internships and launch your real-world career.'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="step-card" data-sr data-sr-d="<?php echo e($i + 1); ?>" data-step>
                    <div class="step-dot"></div>
                    <span class="step-tag mono-font"><?php echo e($step['tag']); ?></span>
                    <div class="step-num-wrap">
                        <div class="step-num <?php echo e($step['sn']); ?>"><?php echo e($step['n']); ?></div>
                        <div class="step-icon-chip"><i class="fas <?php echo e($step['icon']); ?>"></i></div>
                    </div>
                    <h3 class="step-title"><?php echo e($step['title']); ?></h3>
                    <p class="step-desc"><?php echo e($step['desc']); ?></p>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>


<section id="explore">
    <div style="max-width:900px;margin:0 auto;text-align:center;margin-bottom:2.5rem;">
        <h2 class="section-title" data-sr style="font-size:clamp(1.5rem,3vw,2rem);">Where would you like to go?</h2>
    </div>

    <div class="explore-grid">
        <a href="<?php echo e(route('courses.index')); ?>" class="explore-card" data-sr data-sr-d="1">
            <div class="explore-icon"><i class="fas fa-book-open"></i></div>
            <div class="explore-title">Browse Courses</div>
            <div class="explore-desc">50+ skill-building programs</div>
            <span class="explore-link">View catalog <i class="fas fa-arrow-right"></i></span>
        </a>
        <a href="<?php echo e(route('about')); ?>" class="explore-card" data-sr data-sr-d="2">
            <div class="explore-icon"><i class="fas fa-info-circle"></i></div>
            <div class="explore-title">Our Mission</div>
            <div class="explore-desc">Why we built SkillUp</div>
            <span class="explore-link">About us <i class="fas fa-arrow-right"></i></span>
        </a>
        <a href="<?php echo e(route('contact')); ?>" class="explore-card" data-sr data-sr-d="3">
            <div class="explore-icon"><i class="fas fa-headset"></i></div>
            <div class="explore-title">Get Support</div>
            <div class="explore-desc">We're here to help</div>
            <span class="explore-link">Contact <i class="fas fa-arrow-right"></i></span>
        </a>
    </div>
</section>


<section id="testimonials">
    <div style="max-width:1100px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:3.5rem;">
            <div data-sr data-sr-d="1">
                <span class="section-eyebrow eyebrow-amber">
                    <i class="fas fa-star" style="font-size:0.65rem;"></i> Success Stories
                </span>
            </div>
            <h2 class="section-title" data-sr data-sr-d="2">Real results, real learners</h2>
            <p class="section-sub" data-sr data-sr-d="3">Youth who transformed their careers with SkillUp</p>
        </div>

        <div class="testimonials-grid">
            <?php
                $testimonials = [
                    ['init'=>'CA','ta'=>'ta-1','name'=>'Christian John L. Agustin','role'=>'Full Stack Developer','quote'=>'SkillUp gave me the roadmap I needed. In 3 months, I went from confused about my career to landing my dream internship at a tech company.'],
                    ['init'=>'SP','ta'=>'ta-2','name'=>'Sarah Patel','role'=>'Research Analyst','quote'=>'The mentorship aspect is incredible. My mentor helped me build a portfolio that got me noticed by multiple recruiters in my first week.'],
                    ['init'=>'MR','ta'=>'ta-3','name'=>'Marcus Rodriguez','role'=>'Product Analyst','quote'=>'Personalized learning paths saved me countless hours. I learned exactly what I needed instead of drowning in irrelevant content.'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <article class="testimonial-card" data-sr data-sr-d="<?php echo e($i + 1); ?>">
                    <span class="t-quote-mark" aria-hidden="true">&rdquo;</span>
                    <div class="testimonial-header">
                        <div class="t-avatar <?php echo e($t['ta']); ?>"><?php echo e($t['init']); ?></div>
                        <div>
                            <p class="t-name"><?php echo e($t['name']); ?></p>
                            <p class="t-role"><?php echo e($t['role']); ?></p>
                        </div>
                    </div>
                    <div class="t-stars" aria-label="5 out of 5 stars">
                        ★★★★★
                    </div>
                    <p class="t-quote">"<?php echo e($t['quote']); ?>"</p>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>


<section id="cta-banner">
    <div class="cta-orb-1"></div>
    <div class="cta-orb-2"></div>
    <div class="cta-shimmer" aria-hidden="true"></div>

    <div class="cta-inner" data-sr>
        <span class="section-eyebrow eyebrow-green" style="margin-bottom:1.5rem;">
            <i class="fas fa-rocket" style="font-size:0.65rem;"></i> Start Today
        </span>
        <h2 class="section-title">Ready to transform<br>your career?</h2>
        <p class="section-sub">
            Join thousands of youth building futures they're proud of — all with SkillUp.
        </p>

        <div style="margin-top:2rem;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('userpage.dashboard')); ?>" class="btn-primary">
                    Go to dashboard <i class="fas fa-arrow-right"></i>
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('register')); ?>" class="btn-primary">
                    Start your free journey <i class="fas fa-rocket"></i>
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<section id="faq">
    <div style="max-width:720px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:3rem;">
            <div data-sr data-sr-d="1">
                <span class="section-eyebrow eyebrow-navy">
                    <i class="fas fa-question-circle" style="font-size:0.65rem;"></i> FAQ
                </span>
            </div>
            <h2 class="section-title" data-sr data-sr-d="2">Frequently asked questions</h2>
        </div>

        <div class="faq-list">
            <?php
                $faqs = [
                    ['q'=>'How much does SkillUp cost?',                  'a'=>'SkillUp is completely free to use. Core learning paths, courses, mentorship matching, and community features are all available at no cost.'],
                    ['q'=>'Do I need prior experience to join?',           'a'=>'Not at all! SkillUp is designed for beginners. We have beginner-friendly paths for every career interest, from technology to creative industries.'],
                    ['q'=>'Who are the mentors on SkillUp?',               'a'=>'Our mentors are experienced professionals from diverse industries, all vetted and trained to provide quality, actionable guidance to our learners.'],
                    ['q'=>'Can employers see my achievements?',            'a'=>'Yes! You can create a professional profile and share your credentials, badges, and portfolio with employers and recruiters directly.'],
                    ['q'=>'How do I get started?',                         'a'=>'Simply sign up with your email, complete a brief career interest assessment, and we\'ll instantly recommend personalized learning paths tailored to you.'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <details class="faq-item" data-sr data-sr-d="<?php echo e(min($i + 1, 5)); ?>">
                    <summary>
                        <span><span class="faq-index mono-font"><?php echo e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?></span><span class="faq-q"><?php echo e($faq['q']); ?></span></span>
                        <span class="faq-chevron" aria-hidden="true">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <div class="faq-a"><?php echo e($faq['a']); ?></div>
                </details>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>


<button id="scroll-top" aria-label="Scroll to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg viewBox="0 0 44 44" aria-hidden="true">
        <defs>
            <linearGradient id="scrollTopGradient" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#00eaff"/>
                <stop offset="100%" stop-color="#8b5cf6"/>
            </linearGradient>
        </defs>
        <circle cx="22" cy="22" r="18.5"></circle>
    </svg>
    <i class="fas fa-arrow-up"></i>
</button>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
'use strict';

/* ════════════════════════════════════════
   SPLASH SCREEN CONTROLLER
════════════════════════════════════════ */
(function initSplash() {
    const DURATION = 2600; // ms
    const splash   = document.getElementById('splash');
    if (!splash) return;

    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) { splash.remove(); return; }

    document.body.style.overflow = 'hidden';

    /* Spawn particles */
    const container = document.getElementById('splash-particles');
    if (container) {
        for (let i = 0; i < 36; i++) {
            const el   = document.createElement('div');
            el.className = 'sp';
            const size = Math.random() * 3.5 + 1.5;
            Object.assign(el.style, {
                width:              `${size}px`,
                height:             `${size}px`,
                left:               `${Math.random() * 100}%`,
                bottom:             `${(Math.random() * -25) - 5}%`,
                animationDuration:  `${(Math.random() * 50 + 75).toFixed(2)}s`,
                animationDelay:     `${(Math.random() * 8).toFixed(2)}s`,
                opacity:            0,
            });
            container.appendChild(el);
        }
    }

    /* Status cycling */
    const statusEl  = document.getElementById('splash-status');
    const statuses  = [
        ['Initializing', 6],
        ['Loading your paths', 41],
        ['Calibrating mentors', 74],
        ['Almost ready', 96],
    ];
    let si = 0;
    const renderStatus = () => {
        if (!statusEl) return;
        const [label, pct] = statuses[si];
        statusEl.innerHTML = `${label}&hellip; <span class="pct">${pct}%</span>`;
    };
    renderStatus();
    const sTimer = setInterval(() => {
        si = (si + 1) % statuses.length;
        renderStatus();
    }, 650);

    /* Staggered reveal */
    const get = id => document.getElementById(id);

    setTimeout(() => get('splash-logo')?.classList.add('active'), 80);
    setTimeout(() => {
        const wm = get('splash-wordmark');
        wm?.classList.add('active');
        /* brief glitch flicker on reveal */
        if (wm) {
            wm.classList.add('glitching');
            setTimeout(() => wm.classList.remove('glitching'), 420);
        }
    }, 220);
    setTimeout(() => get('splash-tagline')?.classList.add('active'), 370);
    setTimeout(() => {
        get('splash-bar-wrap')?.classList.add('active');
        get('splash-status')?.classList.add('active');
        get('splash-dots')?.classList.add('active');

        const bar = get('splash-bar');
        if (bar) {
            const fill = ((DURATION - 490) * 0.74 / 1000).toFixed(2);
            bar.style.transition = `width ${fill}s cubic-bezier(0.4,0,0.2,1)`;
            requestAnimationFrame(() => { bar.style.width = '100%'; });
        }
    }, 490);

    /* Exit */
    setTimeout(() => {
        clearInterval(sTimer);
        if (statusEl) statusEl.innerHTML = 'Ready! <span class="pct">100%</span>';

        splash.classList.add('leaving');
        document.body.style.overflow = '';
        setTimeout(() => splash.remove(), 1100);
    }, DURATION);
})();


/* ════════════════════════════════════════
   CUSTOM CURSOR + LIGHT TRAIL
════════════════════════════════════════ */
(function initCursor() {
    const dot  = document.getElementById('cursor-dot');
    const ring = document.getElementById('cursor-ring');
    if (!dot || !ring) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if ('ontouchstart' in window) return;

    let mx = 0, my = 0, rx = 0, ry = 0, raf;

    document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; });

    const tick = () => {
        rx += (mx - rx) * 0.12;
        ry += (my - ry) * 0.12;

        dot.style.left  = mx + 'px';
        dot.style.top   = my + 'px';
        ring.style.left = rx + 'px';
        ring.style.top  = ry + 'px';
        raf = requestAnimationFrame(tick);
    };

    raf = requestAnimationFrame(tick);

    document.querySelectorAll('a, button, [role="button"], summary').forEach(el => {
        el.addEventListener('mouseenter', () => {
            ring.style.width  = '52px';
            ring.style.height = '52px';
            ring.style.borderColor = 'rgba(0,234,255,0.85)';
            dot.style.transform = 'translate(-50%,-50%) scale(2.5)';
            dot.style.background = 'rgba(0,234,255,0.4)';
        });
        el.addEventListener('mouseleave', () => {
            ring.style.width  = '36px';
            ring.style.height = '36px';
            ring.style.borderColor = 'rgba(56,189,248,0.55)';
            dot.style.transform = 'translate(-50%,-50%) scale(1)';
            dot.style.background = 'var(--sky)';
        });
    });

    /* Faint trailing particle canvas, confined to the hero for restraint */
    const canvas = document.getElementById('cursor-trail');
    const hero   = document.getElementById('hero');
    if (!canvas || !hero) return;
    const ctx = canvas.getContext('2d');
    let trail = [];

    const resize = () => { canvas.width = window.innerWidth; canvas.height = window.innerHeight; };
    resize();
    window.addEventListener('resize', resize, { passive: true });

    let active = false;
    hero.addEventListener('mouseenter', () => active = true);
    hero.addEventListener('mouseleave', () => active = false);

    document.addEventListener('mousemove', e => {
        if (!active) return;
        trail.push({ x: e.clientX, y: e.clientY, life: 1 });
        if (trail.length > 22) trail.shift();
    });

    const drawTrail = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        trail.forEach((p, i) => {
            p.life -= 0.045;
            if (p.life <= 0) return;
            ctx.beginPath();
            ctx.arc(p.x, p.y, 2.2 * p.life, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(0,234,255,${p.life * 0.35})`;
            ctx.fill();
        });
        trail = trail.filter(p => p.life > 0);
        requestAnimationFrame(drawTrail);
    };
    requestAnimationFrame(drawTrail);
})();


/* ════════════════════════════════════════
   SCROLL PROGRESS BAR
════════════════════════════════════════ */
(function initScrollProgress() {
    const bar = document.getElementById('scroll-progress');
    if (!bar) return;

    const update = () => {
        const total = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.width = total > 0 ? (window.scrollY / total * 100) + '%' : '0%';
    };

    window.addEventListener('scroll', update, { passive: true });
    update();
})();


/* ════════════════════════════════════════
   SCROLL-REVEAL
════════════════════════════════════════ */
(function initScrollReveal() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const els = document.querySelectorAll('[data-sr]');

    if (reduced) {
        els.forEach(el => el.classList.add('visible'));
        return;
    }

    const obs = new IntersectionObserver((entries, ob) => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            e.target.classList.add('visible');
            ob.unobserve(e.target);
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -44px 0px' });

    els.forEach(el => obs.observe(el));

    /* Safety fallback */
    setTimeout(() => els.forEach(el => el.classList.add('visible')), 2400);
})();


/* ════════════════════════════════════════
   HERO PARTICLE CANVAS
════════════════════════════════════════ */
(function initHeroCanvas() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const canvas  = document.getElementById('hero-canvas');
    const hero    = document.getElementById('hero');
    if (!canvas || !hero || reduced) return;

    const ctx = canvas.getContext('2d');
    let W, H, particles, raf;

    const resize = () => {
        W = canvas.width  = hero.offsetWidth;
        H = canvas.height = hero.offsetHeight;
    };

    const rnd = (a, b) => a + Math.random() * (b - a);

    const mkPart = () => ({
        x: Math.random() * W,
        y: Math.random() * H,
        r: rnd(0.7, 2.5),
        vx: rnd(-0.15, 0.15),
        vy: rnd(-0.3, -0.08),
        a: rnd(0.2, 0.6),
        life: 0,
        maxLife: rnd(150, 340),
        hue: Math.random() < 0.7 ? '186,230,253' : '196,181,253',
    });

    const init = () => { particles = Array.from({ length: 60 }, mkPart); };

    const draw = () => {
        ctx.clearRect(0, 0, W, H);
        particles.forEach((p, i) => {
            p.life++;
            p.x += p.vx;
            p.y += p.vy;
            if (p.life > p.maxLife || p.y < -8) particles[i] = mkPart();

            const fade = Math.min(p.life / 50, 1) * Math.min((p.maxLife - p.life) / 50, 1);
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.hue},${p.a * fade})`;
            ctx.fill();
        });
        raf = requestAnimationFrame(draw);
    };

    const visObs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) { if (!raf) draw(); }
        else { cancelAnimationFrame(raf); raf = null; }
    });
    visObs.observe(hero);

    resize(); init(); draw();
    window.addEventListener('resize', resize, { passive: true });
})();


/* ════════════════════════════════════════
   HUD CLOCK READOUT (hero corner)
════════════════════════════════════════ */
(function initHudClock() {
    const el = document.getElementById('hud-clock');
    if (!el) return;
    const base = 'LAT 18.36°N // LNG 121.64°E';
    const tick = () => {
        const t = new Date();
        const hh = String(t.getHours()).padStart(2, '0');
        const mm = String(t.getMinutes()).padStart(2, '0');
        const ss = String(t.getSeconds()).padStart(2, '0');
        el.innerHTML = `${base}<br>${hh}:${mm}:${ss} LOCAL`;
    };
    tick();
    setInterval(tick, 1000);
})();


/* ════════════════════════════════════════
   STAT COUNT-UP
════════════════════════════════════════ */
(function initCountUp() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) return;

    const obs = new IntersectionObserver((entries, ob) => {
        entries.forEach(e => {
            if (!e.isIntersecting) return;
            const el     = e.target;
            const target = parseFloat(el.dataset.count);
            const suffix = el.dataset.suffix || '';
            const isK    = el.dataset.format === 'k';
            const isDec  = 'decimal' in el.dataset;
            const dur    = 1500;
            const t0     = performance.now();

            const fmt = v => {
                if (isDec)   return v.toFixed(1) + suffix;
                if (isK && v >= 1000) return Math.round(v / 1000) + 'K' + suffix;
                return Math.round(v) + suffix;
            };

            const tick = now => {
                const prog = Math.min((now - t0) / dur, 1);
                const ease = 1 - Math.pow(1 - prog, 3);
                el.textContent = fmt(ease * target);
                if (prog < 1) requestAnimationFrame(tick);
                else el.textContent = fmt(target);
            };

            requestAnimationFrame(tick);
            ob.unobserve(el);
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-count]').forEach(el => obs.observe(el));
})();


/* ════════════════════════════════════════
   HOW-IT-WORKS CONNECTOR & DOTS
════════════════════════════════════════ */
(function initHowLine() {
    const grid = document.getElementById('how-grid');
    if (!grid) return;

    const obs = new IntersectionObserver(entries => {
        if (!entries[0].isIntersecting) return;

        grid.classList.add('line-drawn');

        grid.querySelectorAll('[data-step]').forEach((card, i) => {
            setTimeout(() => card.classList.add('dot-visible'), 120 + i * 120);
        });

        obs.disconnect();
    }, { threshold: 0.25 });

    obs.observe(grid);
})();


/* ════════════════════════════════════════
   SMOOTH ANCHOR SCROLL
════════════════════════════════════════ */
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const id = a.getAttribute('href');
        if (!id || id === '#') return;
        const target = document.querySelector(id);
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});


/* ════════════════════════════════════════
   SCROLL-TO-TOP BUTTON (+ progress ring)
════════════════════════════════════════ */
(function initScrollTop() {
    const btn    = document.getElementById('scroll-top');
    const circle = btn?.querySelector('circle');
    if (!btn) return;

    const CIRC = 116; // matches stroke-dasharray in CSS

    const update = () => {
        btn.classList.toggle('visible', window.scrollY > 600);
        if (!circle) return;
        const total = document.documentElement.scrollHeight - window.innerHeight;
        const pct   = total > 0 ? Math.min(window.scrollY / total, 1) : 0;
        circle.style.strokeDashoffset = (CIRC * (1 - pct)).toFixed(1);
    };

    window.addEventListener('scroll', update, { passive: true });
    update();
})();


/* ════════════════════════════════════════
   FEATURE CARD TILT + CURSOR SPOTLIGHT
════════════════════════════════════════ */
(function initFeatureTilt() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isTouch = 'ontouchstart' in window;
    if (reduced || isTouch) return;

    document.querySelectorAll('[data-tilt]').forEach(card => {
        let raf = null;

        const onMove = e => {
            const rect = card.getBoundingClientRect();
            const px = (e.clientX - rect.left) / rect.width;
            const py = (e.clientY - rect.top) / rect.height;

            if (raf) cancelAnimationFrame(raf);
            raf = requestAnimationFrame(() => {
                const rotX = (0.5 - py) * 6;
                const rotY = (px - 0.5) * 8;
                card.style.transform = `translateY(-8px) rotateX(${rotX}deg) rotateY(${rotY}deg)`;
                card.style.setProperty('--mx', `${px * 100}%`);
                card.style.setProperty('--my', `${py * 100}%`);
            });
        };

        const onLeave = () => {
            if (raf) cancelAnimationFrame(raf);
            card.style.transform = '';
        };

        card.addEventListener('mousemove', onMove);
        card.addEventListener('mouseleave', onLeave);
    });
})();


/* ════════════════════════════════════════
   MAGNETIC BUTTONS + CLICK RIPPLE
════════════════════════════════════════ */
(function initButtonInteractions() {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isTouch = 'ontouchstart' in window;
    const buttons = document.querySelectorAll('.btn-primary, .btn-ghost');

    buttons.forEach(btn => {
        if (!reduced && !isTouch) {
            let raf = null;

            const isPrimary = btn.classList.contains('btn-primary');
            const lift = isPrimary ? 'translateY(-3px) scale(1.02)' : 'translateY(-3px)';

            btn.addEventListener('mousemove', e => {
                const rect = btn.getBoundingClientRect();
                const mx = e.clientX - rect.left - rect.width / 2;
                const my = e.clientY - rect.top - rect.height / 2;

                if (raf) cancelAnimationFrame(raf);
                raf = requestAnimationFrame(() => {
                    btn.style.transform = `translate(${mx * 0.14}px, ${my * 0.24}px) ${lift}`;
                });
            });

            btn.addEventListener('mouseleave', () => {
                if (raf) cancelAnimationFrame(raf);
                btn.style.transform = '';
            });
        }

        btn.addEventListener('click', e => {
            const rect = btn.getBoundingClientRect();
            const ripple = document.createElement('span');
            const size = Math.max(rect.width, rect.height) * 1.6;

            ripple.className = 'btn-ripple';
            Object.assign(ripple.style, {
                width:  `${size}px`,
                height: `${size}px`,
                left:   `${(e.clientX - rect.left) - size / 2}px`,
                top:    `${(e.clientY - rect.top) - size / 2}px`,
            });

            btn.appendChild(ripple);
            ripple.addEventListener('animationend', () => ripple.remove());
        });
    });
})();

})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/home.blade.php ENDPATH**/ ?>