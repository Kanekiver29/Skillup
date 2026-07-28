

<?php $__env->startSection('title', 'All Courses - SkillUp'); ?>

<?php $__env->startPush('head'); ?>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    /* ============================================================
       DESIGN TOKENS — "Signal" system: dark HUD / constellation UI
       ============================================================ */
    :root {
        --ease-expo: cubic-bezier(0.16, 1, 0.3, 1);
        --ease-back: cubic-bezier(0.34, 1.56, 0.64, 1);
        --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);

        /* Core surfaces */
        --void: #04050b;
        --deep: #070b16;
        --panel: #0d1220;
        --panel-2: #10162a;
        --panel-border: rgba(140, 170, 255, 0.14);
        --panel-border-strong: rgba(140, 170, 255, 0.32);

        /* Signal accents */
        --cyan: #00e6f6;
        --cyan-soft: #7df3ff;
        --violet: #8b7bff;
        --magenta: #ff3ec4;
        --amber: #ffb648;
        --green: #29ffb0;

        --text-primary: #eef2ff;
        --text-secondary: #a7b0d6;
        --text-muted: #616b93;

        --font-display: 'Space Grotesk', sans-serif;
        --font-body: 'Inter', sans-serif;
        --font-mono: 'JetBrains Mono', monospace;

        --card-shadow: 0 1px 0 rgba(255,255,255,0.03) inset, 0 12px 30px -14px rgba(0,0,0,0.6);
        --card-shadow-hover: 0 1px 0 rgba(255,255,255,0.05) inset, 0 30px 70px -20px rgba(0,0,0,0.75), 0 0 0 1px var(--panel-border-strong);
    }

    @property --angle {
        syntax: '<angle>';
        inherits: false;
        initial-value: 0deg;
    }

    * { box-sizing: border-box; }

    body {
        font-family: var(--font-body);
        background: var(--void);
        color: var(--text-primary);
    }

    .courses-page {
        min-height: 100vh;
        background:
            radial-gradient(ellipse 60% 40% at 15% 0%, rgba(139,123,255,0.10) 0%, transparent 60%),
            radial-gradient(ellipse 50% 40% at 85% 8%, rgba(0,230,246,0.08) 0%, transparent 55%),
            var(--void);
    }

    /* Faint global scanline texture for the whole page */
    .courses-page::before {
        content: '';
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 1;
        background: repeating-linear-gradient(0deg, rgba(255,255,255,0.012) 0px, rgba(255,255,255,0.012) 1px, transparent 1px, transparent 3px);
        opacity: 0.5;
    }

    /* ===== HUD CORNER BRACKETS (shared) ===== */
    .hud-corner {
        position: absolute;
        width: 16px; height: 16px;
        border: 1.5px solid var(--cyan-soft);
        opacity: 0;
        transition: opacity 0.35s var(--ease-expo), width 0.35s var(--ease-expo), height 0.35s var(--ease-expo);
        z-index: 5;
        pointer-events: none;
    }
    .hud-corner.tl { top: 10px; left: 10px; border-right: none; border-bottom: none; border-radius: 4px 0 0 0; }
    .hud-corner.tr { top: 10px; right: 10px; border-left: none; border-bottom: none; border-radius: 0 4px 0 0; }
    .hud-corner.bl { bottom: 10px; left: 10px; border-right: none; border-top: none; border-radius: 0 0 0 4px; }
    .hud-corner.br { bottom: 10px; right: 10px; border-left: none; border-top: none; border-radius: 0 0 4px 0; }

    /* ===== HERO ===== */
    .courses-hero {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        background:
            radial-gradient(ellipse 70% 55% at 105% -10%, rgba(0,230,246,0.14) 0%, transparent 55%),
            radial-gradient(ellipse 55% 50% at -5% 105%, rgba(139,123,255,0.16) 0%, transparent 55%),
            radial-gradient(ellipse 45% 40% at 50% 100%, rgba(255,62,196,0.08) 0%, transparent 60%),
            linear-gradient(160deg, var(--void) 0%, var(--deep) 45%, #0a0f22 75%, #0c1330 100%);
        color: #fff;
        padding: 6rem 0 7rem;
        border-bottom: 1px solid var(--panel-border);
    }

    #hero-canvas {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        opacity: 0.85;
    }

    .hero-grid-overlay {
        position: absolute;
        inset: 0;
        z-index: 0;
        background-image:
            linear-gradient(rgba(140,170,255,0.045) 1px, transparent 1px),
            linear-gradient(90deg, rgba(140,170,255,0.045) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(ellipse 80% 70% at 50% 30%, #000 0%, transparent 75%);
        animation: gridDrift 26s linear infinite;
    }

    @keyframes gridDrift {
        0% { background-position: 0 0; }
        100% { background-position: 48px 48px; }
    }

    .hero-scanbeam {
        position: absolute;
        left: 0; right: 0;
        height: 140px;
        top: -20%;
        z-index: 1;
        background: linear-gradient(180deg, transparent 0%, rgba(0,230,246,0.07) 45%, transparent 100%);
        animation: scanFall 7s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes scanFall {
        0% { transform: translateY(0); }
        100% { transform: translateY(720px); }
    }

    .hero-inner {
        position: relative;
        z-index: 2;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1.5rem;
        text-align: center;
    }

    .hero-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-family: var(--font-mono);
        font-size: 0.72rem;
        letter-spacing: 0.04em;
        color: rgba(167,176,214,0.7);
        margin-bottom: 1.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .hero-breadcrumb a { color: rgba(167,176,214,0.7); text-decoration: none; transition: color 0.2s; }
    .hero-breadcrumb a:hover { color: var(--cyan-soft); }
    .hero-breadcrumb .sep { opacity: 0.35; color: var(--cyan); }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: rgba(0,230,246,0.06);
        border: 1px solid rgba(0,230,246,0.28);
        backdrop-filter: blur(16px);
        color: var(--cyan-soft);
        font-family: var(--font-mono);
        font-size: 0.7rem;
        font-weight: 500;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        padding: 0.5rem 1.2rem;
        border-radius: 9999px;
        transition: all 0.3s var(--ease-expo);
    }

    .hero-badge:hover {
        background: rgba(0,230,246,0.12);
        border-color: rgba(0,230,246,0.5);
        transform: translateY(-2px);
    }

    .hero-badge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--green);
        box-shadow: 0 0 10px var(--green);
        animation: pulseDot 2s ease-in-out infinite;
    }

    @keyframes pulseDot {
        0%, 100% { box-shadow: 0 0 6px var(--green); opacity: 1; }
        50% { box-shadow: 0 0 16px var(--green); opacity: 0.6; }
    }

    .hero-status-line {
        margin-top: 0.9rem;
        font-family: var(--font-mono);
        font-size: 0.68rem;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    .hero-status-line .live-count { color: var(--cyan-soft); font-weight: 600; }

    .hero-title {
        position: relative;
        font-family: var(--font-display);
        font-size: clamp(2.6rem, 6.4vw, 4.6rem);
        font-weight: 700;
        line-height: 1.04;
        color: #fff;
        letter-spacing: -0.02em;
        margin: 1.5rem 0 1.25rem;
    }

    .hero-title .gradient-word {
        position: relative;
        display: inline-block;
        background: linear-gradient(120deg, var(--cyan-soft) 0%, #fff 45%, var(--violet) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        background-size: 200% 100%;
        animation: hueTravel 6s ease-in-out infinite;
    }

    @keyframes hueTravel {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Chromatic-aberration glitch flicker, plays once on load, respects reduced motion */
    .hero-title .gradient-word::before,
    .hero-title .gradient-word::after {
        content: attr(data-text);
        position: absolute;
        left: 0; top: 0;
        width: 100%;
        background: none;
        -webkit-text-fill-color: initial;
        color: var(--cyan);
        opacity: 0;
        clip-path: inset(0 0 0 0);
    }
    .hero-title .gradient-word::before { color: var(--magenta); animation: glitchOnce 1.4s var(--ease-expo) 0.5s 1; }
    .hero-title .gradient-word::after { color: var(--cyan); animation: glitchOnce2 1.4s var(--ease-expo) 0.5s 1; }

    @keyframes glitchOnce {
        0% { opacity: 0; transform: translate(0,0); }
        6% { opacity: 0.7; transform: translate(-3px,1px); clip-path: inset(10% 0 60% 0); }
        12% { opacity: 0.6; transform: translate(2px,-1px); clip-path: inset(60% 0 5% 0); }
        18% { opacity: 0; transform: translate(0,0); }
        100% { opacity: 0; }
    }
    @keyframes glitchOnce2 {
        0% { opacity: 0; transform: translate(0,0); }
        7% { opacity: 0.6; transform: translate(3px,-1px); clip-path: inset(70% 0 5% 0); }
        13% { opacity: 0.5; transform: translate(-2px,1px); clip-path: inset(5% 0 70% 0); }
        19% { opacity: 0; transform: translate(0,0); }
        100% { opacity: 0; }
    }

    .hero-subtitle {
        font-size: 1.05rem;
        color: var(--text-secondary);
        max-width: 540px;
        margin: 0 auto 2.5rem;
        line-height: 1.7;
        font-weight: 300;
    }

    .hero-subtitle strong {
        color: var(--cyan-soft);
        font-weight: 600;
        font-family: var(--font-mono);
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 2.5rem;
    }

    .hero-stat {
        position: relative;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--panel-border);
        backdrop-filter: blur(16px);
        border-radius: 14px;
        padding: 1rem 1.7rem;
        min-width: 118px;
        text-align: center;
        transition: all 0.35s var(--ease-expo);
        cursor: default;
        overflow: hidden;
    }

    .hero-stat::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(0,230,246,0.08), transparent 60%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .hero-stat:hover {
        border-color: var(--panel-border-strong);
        transform: translateY(-4px);
        box-shadow: 0 16px 36px rgba(0,0,0,0.35);
    }
    .hero-stat:hover::before { opacity: 1; }

    .hero-stat .val {
        display: block;
        font-family: var(--font-mono);
        font-size: 1.7rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        margin-bottom: 0.35rem;
    }

    .hero-stat .lbl {
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: var(--cyan-soft);
    }

    .hero-ctas {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.75rem;
    }

    .btn-hero-ghost {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--panel-border);
        backdrop-filter: blur(12px);
        color: #fff;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s var(--ease-expo);
    }

    .btn-hero-ghost:hover {
        background: rgba(255,255,255,0.07);
        border-color: var(--panel-border-strong);
        transform: translateY(-2px);
    }

    .btn-hero-solid {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        background: linear-gradient(135deg, var(--cyan) 0%, var(--violet) 100%);
        color: #04050b;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.3s var(--ease-expo);
        box-shadow: 0 4px 24px rgba(0,230,246,0.25);
        overflow: hidden;
    }

    .btn-hero-solid::before {
        content: '';
        position: absolute; top: 0; left: -60%;
        width: 40%; height: 100%;
        background: linear-gradient(100deg, transparent, rgba(255,255,255,0.5), transparent);
        transform: skewX(-20deg);
        transition: left 0.6s var(--ease-expo);
    }

    .btn-hero-solid:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 34px rgba(0,230,246,0.4);
    }
    .btn-hero-solid:hover::before { left: 140%; }

    /* ===== FLOATING FILTER BAR ===== */
    .filter-section {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1.5rem;
        position: relative;
        z-index: 30;
        margin-top: -2.75rem;
    }

    .filter-bar {
        position: relative;
        background: rgba(13, 18, 32, 0.85);
        backdrop-filter: blur(22px) saturate(1.4);
        border: 1px solid var(--panel-border);
        border-radius: 18px;
        padding: 1.5rem 1.75rem;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.04) inset,
            0 24px 60px rgba(0,0,0,0.45);
        transition: box-shadow 0.4s var(--ease-expo), transform 0.4s var(--ease-expo), border-color 0.4s;
    }

    .filter-bar.is-stuck {
        border-color: var(--panel-border-strong);
        box-shadow:
            0 1px 0 rgba(255,255,255,0.06) inset,
            0 30px 70px rgba(0,0,0,0.55);
        transform: translateY(-1px);
    }

    .filter-row { display: flex; flex-wrap: wrap; gap: 0.9rem; align-items: flex-end; }
    .filter-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .filter-group.flex-1 { flex: 1; min-width: 200px; }

    .filter-label {
        font-family: var(--font-mono);
        font-size: 0.62rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: var(--text-muted);
        display: block;
    }

    .filter-input {
        width: 100%;
        padding: 0.7rem 1rem 0.7rem 2.75rem;
        border: 1.5px solid var(--panel-border);
        border-radius: 10px;
        font-family: var(--font-body);
        font-size: 0.875rem;
        color: var(--text-primary);
        background: rgba(255,255,255,0.02);
        transition: all 0.2s var(--ease-smooth);
        outline: none;
    }

    .filter-input::placeholder { color: var(--text-muted); }

    .filter-input:focus {
        border-color: var(--cyan);
        background: rgba(0,230,246,0.04);
        box-shadow: 0 0 0 4px rgba(0,230,246,0.12);
    }

    .filter-input-wrap { position: relative; }

    .filter-input-icon {
        position: absolute;
        left: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.8rem;
        pointer-events: none;
        transition: color 0.2s;
    }

    .filter-input:focus ~ .filter-input-icon,
    .filter-input-wrap:focus-within .filter-input-icon { color: var(--cyan-soft); }

    .filter-select {
        padding: 0.7rem 2.25rem 0.7rem 0.9rem;
        border: 1.5px solid var(--panel-border);
        border-radius: 10px;
        font-family: var(--font-body);
        font-size: 0.875rem;
        color: var(--text-primary);
        background: rgba(255,255,255,0.02) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%237df3ff' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 0.85rem center;
        appearance: none;
        min-width: 150px;
        transition: all 0.2s var(--ease-smooth);
        outline: none;
    }

    .filter-select option { background: var(--panel); color: var(--text-primary); }

    .filter-select:focus {
        border-color: var(--cyan);
        background-color: rgba(0,230,246,0.04);
        box-shadow: 0 0 0 4px rgba(0,230,246,0.12);
    }

    .btn-apply {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        background: linear-gradient(135deg, var(--cyan) 0%, var(--violet) 100%);
        color: #04050b;
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.75rem 1.6rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.25s var(--ease-expo);
        box-shadow: 0 4px 20px rgba(0,230,246,0.28);
        white-space: nowrap;
        overflow: hidden;
    }

    .btn-apply::before {
        content: '';
        position: absolute; top: 0; left: -60%; width: 40%; height: 100%;
        background: linear-gradient(100deg, transparent, rgba(255,255,255,0.55), transparent);
        transform: skewX(-20deg);
        transition: left 0.55s var(--ease-expo);
    }

    .btn-apply:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,230,246,0.42); }
    .btn-apply:hover::before { left: 140%; }
    .btn-apply:active { transform: translateY(0); }

    .btn-clear {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: transparent;
        color: var(--text-secondary);
        font-family: var(--font-body);
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.7rem 1.15rem;
        border-radius: 10px;
        border: 1.5px solid var(--panel-border);
        text-decoration: none;
        transition: all 0.2s var(--ease-smooth);
        white-space: nowrap;
    }

    .btn-clear:hover {
        background: rgba(255,255,255,0.04);
        border-color: var(--panel-border-strong);
        color: var(--text-primary);
    }

    .chips-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        padding-top: 1.15rem;
        margin-top: 1.15rem;
        border-top: 1px solid var(--panel-border);
        align-items: center;
    }

    .chips-label {
        font-family: var(--font-mono);
        font-size: 0.6rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        color: var(--text-muted);
        margin-right: 0.25rem;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.42rem 0.95rem;
        border-radius: 9999px;
        border: 1.5px solid var(--panel-border);
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-secondary);
        text-decoration: none;
        background: rgba(255,255,255,0.02);
        transition: all 0.22s var(--ease-expo);
    }

    .chip:hover:not(.chip-active) {
        border-color: rgba(0,230,246,0.45);
        color: var(--cyan-soft);
        transform: translateY(-2px);
        background: rgba(0,230,246,0.06);
    }

    .chip-active {
        background: linear-gradient(135deg, var(--cyan) 0%, var(--violet) 100%) !important;
        color: #04050b !important;
        border-color: transparent !important;
        box-shadow: 0 6px 20px rgba(0,230,246,0.32);
        font-weight: 700;
        transform: translateY(-1px);
    }

    /* ===== RESULTS SECTION ===== */
    .results-section {
        position: relative;
        z-index: 2;
        max-width: 1100px;
        margin: 0 auto;
        padding: 2.75rem 1.5rem 4.5rem;
    }

    .results-bar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2.25rem;
        padding: 1rem 1.3rem;
        background: var(--panel);
        border-radius: 12px;
        border: 1px solid var(--panel-border);
        border-left: 3px solid var(--cyan);
        box-shadow: var(--card-shadow);
    }

    .results-count {
        font-family: var(--font-mono);
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-weight: 400;
        margin: 0;
    }

    .results-count strong {
        color: var(--cyan-soft);
        font-weight: 700;
    }

    .results-hint {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    /* ===== COURSE GRID ===== */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.75rem;
        perspective: 1600px;
    }

    /* ===== COURSE CARD ===== */
    .course-card {
        position: relative;
        background: linear-gradient(180deg, var(--panel) 0%, var(--panel-2) 100%);
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid var(--panel-border);
        box-shadow: var(--card-shadow);
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: transform 0.5s var(--ease-expo), box-shadow 0.5s var(--ease-expo), border-color 0.4s ease;
        will-change: transform;
        transform-style: preserve-3d;
    }

    /* Rotating aurora border, revealed on hover */
    .course-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        padding: 1.5px;
        background: conic-gradient(from var(--angle, 0deg), transparent 0%, var(--cyan) 12%, transparent 28%, var(--violet) 50%, transparent 68%, var(--magenta) 86%, transparent 100%);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 1;
        pointer-events: none;
        animation: rotateGlow 3.5s linear infinite paused;
    }

    @keyframes rotateGlow { to { --angle: 360deg; } }

    .course-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .course-card:hover::before {
        opacity: 1;
        animation-play-state: running;
    }

    /* Pointer-follow glare */
    .course-card::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        opacity: 0;
        background: radial-gradient(280px circle at var(--mx, 50%) var(--my, 50%), rgba(0,230,246,0.10), transparent 60%);
        transition: opacity 0.3s ease;
    }

    .course-card:hover::after { opacity: 1; }

    /* Card image */
    .card-img-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: linear-gradient(135deg, #131a30, #1a2340);
        flex-shrink: 0;
        z-index: 0;
    }

    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        filter: saturate(0.9) brightness(0.92);
        transition: transform 0.7s var(--ease-expo), filter 0.5s ease;
    }

    .course-card:hover .card-img {
        transform: scale(1.08);
        filter: saturate(1.05) brightness(1);
    }

    .card-img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(circle at 30% 20%, rgba(0,230,246,0.14), transparent 55%),
            linear-gradient(135deg, #10162a, #171f3a);
        color: var(--cyan-soft);
        font-size: 2.5rem;
    }

    .card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(4,5,11,0.92) 0%, rgba(4,5,11,0.35) 45%, transparent 72%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 1.25rem;
    }

    .course-card:hover .card-overlay { opacity: 1; }

    .card-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--cyan), var(--violet));
        color: #04050b;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.65rem 1.4rem;
        border-radius: 10px;
        box-shadow: 0 8px 26px rgba(0,230,246,0.35);
        transform: translateY(12px);
        opacity: 0;
        transition: transform 0.4s var(--ease-expo) 0.05s, opacity 0.35s ease 0.05s;
    }

    .course-card:hover .card-cta { transform: translateY(0); opacity: 1; }
    .card-cta i { transition: transform 0.25s var(--ease-back); }
    .course-card:hover .card-cta i { transform: translateX(3px); }

    /* Badges */
    .card-badge-level {
        position: absolute;
        top: 12px; left: 12px;
        background: rgba(4,5,11,0.7);
        border: 1px solid rgba(0,230,246,0.4);
        backdrop-filter: blur(8px);
        color: var(--cyan-soft);
        font-family: var(--font-mono);
        font-size: 0.62rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.32rem 0.7rem;
        border-radius: 6px;
        z-index: 3;
    }

    .card-badge-cert {
        position: absolute;
        top: 12px; right: 12px;
        background: rgba(139,123,255,0.16);
        border: 1px solid rgba(139,123,255,0.45);
        backdrop-filter: blur(8px);
        color: #d9d3ff;
        font-size: 0.62rem;
        font-weight: 600;
        padding: 0.32rem 0.65rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        z-index: 3;
    }

    .card-badge-popular {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--amber), #d9822b);
        color: #201200;
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 0.28rem 0.85rem;
        border-radius: 9999px;
        box-shadow: 0 4px 16px rgba(255,182,72,0.45);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        white-space: nowrap;
        z-index: 3;
    }

    /* Card body */
    .card-body {
        padding: 1.4rem 1.4rem 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
        position: relative;
        z-index: 3;
    }

    .card-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.8rem;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .card-category {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: rgba(0,230,246,0.08);
        color: var(--cyan-soft);
        font-size: 0.66rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 0.32rem 0.7rem;
        border-radius: 6px;
        border: 1px solid rgba(0,230,246,0.2);
    }

    .card-duration {
        font-family: var(--font-mono);
        font-size: 0.74rem;
        font-weight: 500;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .card-duration i { color: var(--violet); }

    .card-title {
        font-family: var(--font-display);
        font-size: 1.08rem;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1.35;
        margin: 0 0 0.55rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.25s ease;
    }

    .course-card:hover .card-title { color: var(--cyan-soft); }

    .card-desc {
        font-size: 0.83rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0 0 1.15rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-weight: 300;
        flex: 1;
    }

    /* Stats pills — HUD readouts */
    .card-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-bottom: 1.1rem;
    }

    .stat-pill {
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--panel-border);
        border-radius: 10px;
        padding: 0.6rem 0.5rem;
        text-align: center;
        transition: all 0.25s var(--ease-expo);
    }

    .course-card:hover .stat-pill {
        background: rgba(0,230,246,0.05);
        border-color: rgba(0,230,246,0.22);
        transform: translateY(-2px);
    }

    .stat-val {
        display: block;
        font-family: var(--font-mono);
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--cyan-soft);
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-val.rating { color: var(--amber); }

    .stat-key {
        font-size: 0.58rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--text-muted);
    }

    /* Instructor row */
    .card-instructor {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-bottom: 1.15rem;
    }

    .instructor-avatar {
        width: 30px; height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a2340, #232e52);
        border: 1.5px solid rgba(0,230,246,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.65rem;
        color: var(--cyan-soft);
    }

    .instructor-name {
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-muted);
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    /* Card footer */
    .card-footer {
        display: flex;
        gap: 0.6rem;
        padding-top: 1.05rem;
        border-top: 1px solid var(--panel-border);
    }

    .btn-card-details {
        flex: 1;
        text-align: center;
        padding: 0.62rem;
        border-radius: 10px;
        border: 1.5px solid var(--panel-border);
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--text-secondary);
        background: transparent;
        transition: all 0.2s ease;
    }

    .course-card:hover .btn-card-details {
        border-color: rgba(0,230,246,0.4);
        color: var(--cyan-soft);
        background: rgba(0,230,246,0.04);
    }

    .btn-card-enroll {
        flex: 1;
        text-align: center;
        padding: 0.62rem;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--cyan), var(--violet));
        font-size: 0.82rem;
        font-weight: 700;
        font-family: var(--font-display);
        color: #04050b;
        transition: all 0.25s var(--ease-expo);
        box-shadow: 0 3px 14px rgba(0,230,246,0.28);
    }

    .course-card:hover .btn-card-enroll {
        box-shadow: 0 8px 24px rgba(0,230,246,0.42);
    }

    /* Progress ribbon — segmented HUD bar */
    .card-progress-track {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 4px;
        background: rgba(255,255,255,0.04);
        z-index: 4;
    }

    .card-progress {
        height: 100%;
        background: repeating-linear-gradient(90deg, var(--cyan) 0px, var(--cyan) 6px, var(--violet) 6px, var(--violet) 10px);
        box-shadow: 0 0 8px rgba(0,230,246,0.6);
        transition: width 0.6s var(--ease-expo);
    }

    /* HUD corner brackets on card, shown on hover */
    .course-card .hud-corner { border-color: var(--cyan-soft); }
    .course-card:hover .hud-corner { opacity: 0.9; }
    .course-card:hover .hud-corner.tl,
    .course-card:hover .hud-corner.tr { width: 22px; height: 22px; }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        grid-column: 1 / -1;
        position: relative;
        background: radial-gradient(ellipse 60% 60% at 50% 30%, rgba(0,230,246,0.05), transparent 65%), var(--panel);
        border: 1.5px dashed var(--panel-border-strong);
        border-radius: 22px;
        padding: 4.5rem 2rem;
        text-align: center;
        overflow: hidden;
    }

    .empty-radar {
        width: 84px; height: 84px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(0,230,246,0.12), transparent 70%);
        border: 1.5px solid rgba(0,230,246,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--cyan-soft);
        font-size: 1.8rem;
        position: relative;
    }

    .empty-radar::before {
        content: '';
        position: absolute; inset: -1.5px;
        border-radius: 50%;
        border: 1.5px solid transparent;
        border-top-color: var(--cyan);
        animation: radarSpin 1.8s linear infinite;
    }

    @keyframes radarSpin { to { transform: rotate(360deg); } }

    .empty-state h2 {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 0.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        max-width: 380px;
        margin: 0 auto 2rem;
        line-height: 1.65;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrap { margin-top: 3.25rem; display: flex; justify-content: center; }

    .pagination-inner {
        background: var(--panel);
        border: 1px solid var(--panel-border);
        border-radius: 14px;
        padding: 0.75rem 1rem;
        box-shadow: var(--card-shadow);
        color: var(--text-secondary);
    }

    .pagination-inner :is(a, span) { color: var(--text-secondary) !important; }
    .pagination-inner .page-item.active .page-link,
    .pagination-inner .active span {
        background: linear-gradient(135deg, var(--cyan), var(--violet)) !important;
        color: #04050b !important;
        border-color: transparent !important;
    }
    .pagination-inner a:hover { color: var(--cyan-soft) !important; }

    /* ===== SCROLL-REVEAL ===== */
    [data-reveal] {
        opacity: 0;
        transform: translateY(24px);
        filter: blur(4px);
        transition: opacity 0.75s var(--ease-expo), transform 0.75s var(--ease-expo), filter 0.75s ease;
    }
    [data-reveal].is-visible { opacity: 1; transform: translateY(0); filter: blur(0); }
    [data-reveal-delay="1"] { transition-delay: 80ms; }
    [data-reveal-delay="2"] { transition-delay: 160ms; }
    [data-reveal-delay="3"] { transition-delay: 240ms; }
    [data-reveal-delay="4"] { transition-delay: 320ms; }
    [data-reveal-delay="5"] { transition-delay: 400ms; }

    .hero-reveal { animation: heroFadeUp 0.9s var(--ease-expo) both; }
    .hero-reveal-1 { animation-delay: 0.1s; }
    .hero-reveal-2 { animation-delay: 0.2s; }
    .hero-reveal-3 { animation-delay: 0.3s; }
    .hero-reveal-4 { animation-delay: 0.42s; }
    .hero-reveal-5 { animation-delay: 0.54s; }
    .hero-reveal-6 { animation-delay: 0.66s; }

    @keyframes heroFadeUp {
        from { opacity: 0; transform: translateY(30px) scale(0.97); filter: blur(6px); }
        to   { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    /* ===== TOAST ===== */
    .courses-toast {
        position: fixed;
        bottom: 1.5rem; right: 1.5rem;
        z-index: 9999;
        background: linear-gradient(135deg, var(--panel-2), var(--panel));
        border: 1px solid rgba(0,230,246,0.35);
        color: var(--text-primary);
        padding: 0.9rem 1.25rem;
        border-radius: 14px;
        font-size: 0.85rem;
        font-weight: 500;
        box-shadow: 0 12px 40px rgba(0,0,0,0.5), 0 0 0 1px rgba(0,230,246,0.08);
        display: flex;
        align-items: center;
        gap: 0.6rem;
        transform: translateY(100px) scale(0.9);
        opacity: 0;
        transition: all 0.4s var(--ease-back);
        pointer-events: none;
    }
    .courses-toast.show { transform: translateY(0) scale(1); opacity: 1; }
    .courses-toast i { color: var(--green); }

    /* ===== SCROLL TO TOP ===== */
    .scroll-top-btn {
        position: fixed;
        bottom: 1.5rem; right: 1.5rem;
        width: 46px; height: 46px;
        background: linear-gradient(135deg, var(--cyan), var(--violet));
        color: #04050b;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        box-shadow: 0 8px 26px rgba(0,230,246,0.4);
        z-index: 999;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.35s var(--ease-expo);
        pointer-events: none;
    }
    .scroll-top-btn.visible { opacity: 1; transform: translateY(0); pointer-events: auto; }
    .scroll-top-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,230,246,0.5); }

    /* ===== REDUCED MOTION ===== */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        [data-reveal] { opacity: 1 !important; transform: none !important; filter: none !important; }
        .hero-reveal { animation: none !important; opacity: 1 !important; }
        .course-card:hover { transform: none !important; }
        .course-card::before, .course-card::after { display: none !important; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .courses-hero { padding: 4.5rem 0 5.5rem; }
        .hero-title { font-size: 2.2rem; }
        .filter-row { flex-direction: column; }
        .courses-grid { grid-template-columns: 1fr; }
        .hero-status-line { flex-wrap: wrap; }
    }

    @media (hover: none) {
        .course-card::after { display: none; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $hasFilters = request('search') || (request('level') && request('level') !== 'all') || (request('category') && request('category') !== 'all');
    $activeCategory = request('category', 'all');
    $categoryCount = $categories->filter()->count();
?>

<div class="courses-page">

    
    <section class="courses-hero">
        <canvas id="hero-canvas"></canvas>
        <div class="hero-grid-overlay"></div>
        <div class="hero-scanbeam"></div>

        <div class="hero-inner">
            
            <nav class="hero-breadcrumb hero-reveal hero-reveal-1" aria-label="Breadcrumb">
                <a href="/"><i class="fas fa-home text-xs"></i> Home</a>
                <span class="sep">/</span>
                <span style="color: rgba(255,255,255,0.85); font-weight: 600;">All Courses</span>
            </nav>

            
            <div class="hero-reveal hero-reveal-2">
                <span class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Career-focused learning paths
                </span>
                <div class="hero-status-line">
                    <span>SYSTEM // CATALOG_SYNCED</span>
                    <span>·</span>
                    <span><span class="live-count"><?php echo e(number_format($courses->total())); ?></span> courses indexed</span>
                </div>
            </div>

            
            <h1 class="hero-title hero-reveal hero-reveal-3">
                Explore Our<br>
                <span class="gradient-word" data-text="Courses">Courses</span>
            </h1>

            
            <p class="hero-subtitle hero-reveal hero-reveal-4">
                Choose from <strong><?php echo e(number_format($courses->total())); ?></strong> expert-crafted courses
                designed to launch your career to the next level.
            </p>

            
            <div class="hero-stats hero-reveal hero-reveal-5">
                <div class="hero-stat">
                    <span class="val" data-count="<?php echo e($courses->total()); ?>"><?php echo e(number_format($courses->total())); ?></span>
                    <span class="lbl">Courses</span>
                </div>
                <div class="hero-stat">
                    <span class="val" data-count="<?php echo e($categoryCount); ?>"><?php echo e($categoryCount); ?></span>
                    <span class="lbl">Categories</span>
                </div>
                <div class="hero-stat">
                    <span class="val"><i class="fas fa-certificate" style="color: var(--cyan-soft);"></i></span>
                    <span class="lbl">Certificates</span>
                </div>
                <div class="hero-stat">
                    <span class="val"><i class="fas fa-users" style="color: var(--cyan-soft);"></i></span>
                    <span class="lbl">Community</span>
                </div>
            </div>

            
            <div class="hero-ctas hero-reveal hero-reveal-6">
                <a href="<?php echo e(route('courses.my-learning')); ?>" class="btn-hero-ghost">
                    <i class="fas fa-book-reader"></i> My Learning
                </a>
                <a href="<?php echo e(route('userpage.roadmap')); ?>" class="btn-hero-solid">
                    <i class="fas fa-route"></i> My Roadmap
                </a>
            </div>
        </div>
    </section>

    
    <div class="filter-section" style="position: relative; z-index: 30;">
        <div id="filter-bar" class="filter-bar" data-reveal>
            <form method="GET" action="<?php echo e(route('courses.index')); ?>" id="filter-form">
                <div class="filter-row">
                    
                    <div class="filter-group flex-1">
                        <label class="filter-label" for="inp-search">
                            <i class="fas fa-search" style="margin-right: 0.3rem;"></i> Search
                        </label>
                        <div class="filter-input-wrap">
                            <i class="fas fa-search filter-input-icon"></i>
                            <input
                                id="inp-search"
                                type="search"
                                name="search"
                                placeholder="Title, skill, or keyword..."
                                value="<?php echo e(request('search')); ?>"
                                class="filter-input"
                                autocomplete="off"
                            >
                        </div>
                    </div>

                    
                    <div class="filter-group">
                        <label class="filter-label" for="inp-level">
                            <i class="fas fa-signal" style="margin-right: 0.3rem;"></i> Level
                        </label>
                        <select id="inp-level" name="level" class="filter-select">
                            <option value="all">All Levels</option>
                            <option value="Beginner"     <?php echo e(request('level') === 'Beginner'     ? 'selected' : ''); ?>>Beginner</option>
                            <option value="Intermediate" <?php echo e(request('level') === 'Intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                            <option value="Advanced"     <?php echo e(request('level') === 'Advanced'     ? 'selected' : ''); ?>>Advanced</option>
                        </select>
                    </div>

                    
                    <div class="filter-group">
                        <label class="filter-label" for="inp-category">
                            <i class="fas fa-folder" style="margin-right: 0.3rem;"></i> Category
                        </label>
                        <select id="inp-category" name="category" class="filter-select" style="min-width: 165px;">
                            <option value="all">All Categories</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($cat): ?>
                                    <option value="<?php echo e($cat); ?>" <?php echo e(request('category') === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="filter-group">
                        <label class="filter-label" style="visibility: hidden;">.</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <button type="submit" class="btn-apply">
                                <i class="fas fa-filter"></i> Apply
                            </button>
                            <?php if($hasFilters): ?>
                                <a href="<?php echo e(route('courses.index')); ?>" class="btn-clear">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <?php if($categoryCount > 0): ?>
                <div class="chips-row">
                    <span class="chips-label">Quick filter:</span>
                    <a href="<?php echo e(route('courses.index', array_merge(request()->except('category', 'page'), ['category' => 'all']))); ?>"
                       class="chip <?php echo e($activeCategory === 'all' || !$activeCategory ? 'chip-active' : ''); ?>">
                        <i class="fas fa-th-large" style="font-size: 0.6rem;"></i> All
                    </a>
                    <?php $__currentLoopData = $categories->filter(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('courses.index', array_merge(request()->except('category', 'page'), ['category' => $cat]))); ?>"
                           class="chip <?php echo e(request('category') === $cat ? 'chip-active' : ''); ?>">
                            <?php echo e($cat); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    
    <div class="results-section">

        
        <div class="results-bar" data-reveal>
            <p class="results-count">
                Showing <strong><?php echo e($courses->count()); ?></strong> of
                <strong><?php echo e(number_format($courses->total())); ?></strong> courses
                <?php if($hasFilters): ?>
                    <span style="color: var(--cyan-soft); font-weight: 700;"> · filtered</span>
                <?php endif; ?>
            </p>
            <?php if($hasFilters): ?>
                <div class="results-hint">
                    <i class="fas fa-lightbulb" style="color: var(--amber);"></i>
                    Clear filters to see full catalog
                </div>
            <?php endif; ?>
        </div>

        
        <div id="courses-grid" class="courses-grid">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isPopular = ($course->rating ?? 0) >= 4.5 || ($course->students_count ?? 0) >= 100;
                    $delay = min(($index % 6) * 80, 400);
                    $progress = $course->progress ?? 0;
                ?>

                <a
                    href="<?php echo e(route('courses.show', $course->slug)); ?>"
                    class="course-card"
                    data-reveal
                    data-reveal-delay="<?php echo e(min($index % 6 + 1, 5)); ?>"
                    style="animation-delay: <?php echo e($delay); ?>ms"
                >
                    <span class="hud-corner tl"></span>
                    <span class="hud-corner tr"></span>
                    <span class="hud-corner bl"></span>
                    <span class="hud-corner br"></span>

                    
                    <div class="card-img-wrap">
                        <?php if($course->image_url): ?>
                            <img
                                src="<?php echo e(asset($course->image_url)); ?>"
                                alt="<?php echo e($course->title); ?>"
                                class="card-img"
                                loading="lazy"
                                decoding="async"
                            >
                        <?php else: ?>
                            <div class="card-img-placeholder">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                        <?php endif; ?>

                        
                        <div class="card-overlay">
                            <span class="card-cta">
                                View Course <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>

                        
                        <span class="card-badge-level"><?php echo e($course->level ?? 'Beginner'); ?></span>
                        <span class="card-badge-cert">
                            <i class="fas fa-certificate" style="font-size: 0.58rem;"></i> Certificate
                        </span>
                        <?php if($isPopular): ?>
                            <span class="card-badge-popular">
                                <i class="fas fa-fire" style="font-size: 0.58rem;"></i> Popular
                            </span>
                        <?php endif; ?>
                    </div>

                    
                    <div class="card-body">
                        <div class="card-meta">
                            <span class="card-category">
                                <i class="fas fa-tag" style="font-size: 0.55rem;"></i>
                                <?php echo e($course->category ?? 'General'); ?>

                            </span>
                            <span class="card-duration">
                                <i class="fas fa-clock"></i> <?php echo e($course->duration_hours ?? 0); ?>h
                            </span>
                        </div>

                        <h3 class="card-title"><?php echo e($course->title); ?></h3>
                        <p class="card-desc"><?php echo e($course->short_description); ?></p>

                        
                        <div class="card-stats">
                            <div class="stat-pill">
                                <span class="stat-val"><?php echo e($course->likes_count ?? $course->getLikesCount()); ?></span>
                                <span class="stat-key">Likes</span>
                            </div>
                            <div class="stat-pill">
                                <span class="stat-val"><?php echo e(number_format($course->students_count ?? 0)); ?></span>
                                <span class="stat-key">Learners</span>
                            </div>
                            <div class="stat-pill">
                                <span class="stat-val rating">
                                    <?php echo e(number_format($course->rating ?? 0, 1)); ?><i class="fas fa-star" style="font-size: 0.6rem; margin-left: 2px;"></i>
                                </span>
                                <span class="stat-key">Rating</span>
                            </div>
                        </div>

                        
                        <div class="card-instructor">
                            <div class="instructor-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <span class="instructor-name">
                                <?php echo e(\Illuminate\Support\Str::limit($course->instructor_name ?? 'SkillUp Trainer', 30)); ?>

                            </span>
                        </div>

                        
                        <div class="card-footer">
                            <span class="btn-card-details">Details</span>
                            <span class="btn-card-enroll">Enroll Now</span>
                        </div>
                    </div>

                    
                    <?php if($progress > 0): ?>
                        <div class="card-progress-track">
                            <div class="card-progress" style="width: <?php echo e($progress); ?>%;"></div>
                        </div>
                    <?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state" data-reveal>
                    <div class="empty-radar">
                        <i class="fas fa-satellite-dish"></i>
                    </div>
                    <h2>No signal — no courses found</h2>
                    <p>Try adjusting your search or filters to discover more learning opportunities.</p>
                    <a href="<?php echo e(route('courses.index')); ?>" class="btn-apply" style="display: inline-flex; text-decoration: none;">
                        <i class="fas fa-redo"></i> Browse All Courses
                    </a>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($courses->hasPages()): ?>
            <div class="pagination-wrap" data-reveal>
                <div class="pagination-inner">
                    <?php echo e($courses->withQueryString()->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<button class="scroll-top-btn" id="scrollTopBtn" aria-label="Scroll to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-arrow-up"></i>
</button>


<div class="courses-toast" id="coursesToast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Filters applied</span>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    /* ── Helpers ── */
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => [...root.querySelectorAll(sel)];
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── Scroll-reveal ── */
    if (!reduced) {
        const revealEls = $$('[data-reveal]');
        const revealObs = new IntersectionObserver((entries, obs) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.06, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(el => revealObs.observe(el));
        setTimeout(() => revealEls.forEach(el => el.classList.add('is-visible')), 1800);
    } else {
        $$('[data-reveal]').forEach(el => el.classList.add('is-visible'));
    }

    /* ── Filter bar sticky shadow ── */
    const filterBar = $('#filter-bar');
    if (filterBar) {
        const onScroll = () => {
            const rect = filterBar.getBoundingClientRect();
            filterBar.classList.toggle('is-stuck', rect.top <= 80 && window.scrollY > 100);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    /* ── Sync category chip → select ── */
    $$('.chip').forEach(chip => {
        chip.addEventListener('click', () => {
            const url = new URL(chip.href);
            const cat = url.searchParams.get('category') || 'all';
            const sel = $('#inp-category');
            if (sel) sel.value = cat;
        });
    });

    /* ── ESC clears search ── */
    const searchEl = $('#inp-search');
    if (searchEl) {
        searchEl.addEventListener('keydown', e => {
            if (e.key === 'Escape') { searchEl.value = ''; searchEl.focus(); }
        });
    }

    /* ── Toast notification ── */
    const toast = $('#coursesToast');
    const toastMsg = $('#toastMsg');
    function showToast(msg = 'Done!', duration = 2800) {
        if (!toast) return;
        toastMsg.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), duration);
    }

    const filterForm = $('#filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', () => showToast('Applying filters…'));
    }

    /* ── Scroll-to-top button ── */
    const scrollBtn = $('#scrollTopBtn');
    if (scrollBtn) {
        window.addEventListener('scroll', () => {
            scrollBtn.classList.toggle('visible', window.scrollY > 500);
        }, { passive: true });
    }

    /* ── Constellation network canvas (hero signature) ── */
    if (!reduced) {
        const canvas = $('#hero-canvas');
        const hero   = canvas?.closest('.courses-hero');
        if (canvas && hero) {
            const ctx = canvas.getContext('2d');
            let W, H, nodes, dpr = Math.min(window.devicePixelRatio || 1, 2);

            const resize = () => {
                W = hero.offsetWidth;
                H = hero.offsetHeight;
                canvas.width = W * dpr;
                canvas.height = H * dpr;
                canvas.style.width = W + 'px';
                canvas.style.height = H + 'px';
                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            };

            const rand = (a, b) => a + Math.random() * (b - a);

            const mkNode = () => ({
                x: Math.random() * W,
                y: Math.random() * H,
                vx: rand(-0.16, 0.16),
                vy: rand(-0.16, 0.16),
                r: rand(1, 2.2),
            });

            const init = () => {
                const count = Math.min(60, Math.floor((W * H) / 16000));
                nodes = Array.from({ length: Math.max(24, count) }, mkNode);
            };

            const LINK_DIST = 130;
            let raf;
            const draw = () => {
                ctx.clearRect(0, 0, W, H);

                nodes.forEach(n => {
                    n.x += n.vx;
                    n.y += n.vy;
                    if (n.x < 0 || n.x > W) n.vx *= -1;
                    if (n.y < 0 || n.y > H) n.vy *= -1;
                });

                for (let i = 0; i < nodes.length; i++) {
                    for (let j = i + 1; j < nodes.length; j++) {
                        const a = nodes[i], b = nodes[j];
                        const dx = a.x - b.x, dy = a.y - b.y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < LINK_DIST) {
                            const alpha = (1 - dist / LINK_DIST) * 0.35;
                            ctx.strokeStyle = `rgba(125, 211, 252, ${alpha})`;
                            ctx.lineWidth = 1;
                            ctx.beginPath();
                            ctx.moveTo(a.x, a.y);
                            ctx.lineTo(b.x, b.y);
                            ctx.stroke();
                        }
                    }
                }

                nodes.forEach(n => {
                    ctx.beginPath();
                    ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(125, 211, 252, 0.75)';
                    ctx.shadowColor = 'rgba(0, 230, 246, 0.7)';
                    ctx.shadowBlur = 6;
                    ctx.fill();
                    ctx.shadowBlur = 0;
                });

                raf = requestAnimationFrame(draw);
            };

            const obs = new IntersectionObserver(entries => {
                if (entries[0].isIntersecting) { if (!raf) draw(); }
                else { cancelAnimationFrame(raf); raf = null; }
            });
            obs.observe(hero);

            resize();
            init();
            draw();
            window.addEventListener('resize', () => { resize(); init(); });
        }
    }

    /* ── Number count-up for hero stats ── */
    if (!reduced) {
        $$('[data-count]').forEach(el => {
            const target = parseInt(el.dataset.count, 10);
            if (!target) return;
            let start = 0;
            const step = Math.ceil(target / 48);
            const timer = setInterval(() => {
                start = Math.min(start + step, target);
                el.textContent = start.toLocaleString();
                if (start >= target) clearInterval(timer);
            }, 18);
        });
    }

    /* ── Card entrance stagger ── */
    if (!reduced) {
        $$('.course-card[data-reveal]').forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(28px) scale(0.96)';
            card.style.filter = 'blur(4px)';
            card.style.transition = `opacity 0.65s cubic-bezier(0.16,1,0.3,1) ${i % 6 * 80}ms,
                                     transform 0.65s cubic-bezier(0.16,1,0.3,1) ${i % 6 * 80}ms,
                                     filter 0.65s ease ${i % 6 * 80}ms,
                                     box-shadow 0.5s cubic-bezier(0.16,1,0.3,1),
                                     border-color 0.4s ease`;
        });

        const cardObs = new IntersectionObserver((entries, obs) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.style.opacity = '1';
                    e.target.style.transform = '';
                    e.target.style.filter = '';
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.05 });

        $$('.course-card[data-reveal]').forEach(card => cardObs.observe(card));
    }

    /* ── Card 3D tilt + pointer glare (desktop, fine pointer only) ── */
    const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    if (!reduced && canHover) {
        $$('.course-card').forEach(card => {
            let rafId = null;
            let targetRX = 0, targetRY = 0, curRX = 0, curRY = 0;

            const onMove = (e) => {
                const rect = card.getBoundingClientRect();
                const px = (e.clientX - rect.left) / rect.width;
                const py = (e.clientY - rect.top) / rect.height;

                card.style.setProperty('--mx', `${px * 100}%`);
                card.style.setProperty('--my', `${py * 100}%`);

                targetRY = (px - 0.5) * 8;
                targetRX = (0.5 - py) * 8;

                if (!rafId) rafId = requestAnimationFrame(tick);
            };

            const tick = () => {
                curRX += (targetRX - curRX) * 0.15;
                curRY += (targetRY - curRY) * 0.15;
                card.style.transform = `translateY(-8px) scale(1.012) rotateX(${curRX}deg) rotateY(${curRY}deg)`;

                if (Math.abs(targetRX - curRX) > 0.05 || Math.abs(targetRY - curRY) > 0.05) {
                    rafId = requestAnimationFrame(tick);
                } else {
                    rafId = null;
                }
            };

            const onLeave = () => {
                targetRX = 0; targetRY = 0;
                if (!rafId) rafId = requestAnimationFrame(tick);
                card.style.transform = '';
            };

            card.addEventListener('mousemove', onMove);
            card.addEventListener('mouseleave', onLeave);
        });
    }

})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/courses/index.blade.php ENDPATH**/ ?>