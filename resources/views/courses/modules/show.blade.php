@extends('layout.app')

@section('title', $module->title . ' - ' . $course->title . ' - SkillUp')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        /* ---- Signature token system: "Deep Signal" ---- */
        --mod-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --mod-ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);

        --mod-void: #030711;
        --mod-navy: #071524;
        --mod-deep: #0a1a30;
        --mod-blue: #003a8f;
        --mod-cyan: #22d3ee;
        --mod-cyan-hot: #5eead4;
        --mod-violet: #8b5cf6;
        --mod-magenta: #ff4fa3;
        --mod-amber: #ffb020;

        --mod-text: #eaf1fb;
        --mod-text-dim: #93a3be;

        --mod-surface: rgba(255,255,255,0.9);
        --mod-border: rgba(148, 163, 184, 0.2);
        --mod-border-glow: rgba(34, 211, 238, 0.4);

        --font-display: 'Space Grotesk', 'Inter', system-ui, sans-serif;
        --font-body: 'Inter', system-ui, sans-serif;
    }

    html { scroll-behavior: smooth; }

    body { font-family: var(--font-body); }

    .font-display { font-family: var(--font-display); letter-spacing: -0.01em; }

    /* ============ Reveal system ============ */
    [data-animate] {
        opacity: 0;
        transform: translateY(18px);
        filter: blur(3px);
        will-change: transform, opacity, filter;
    }

    .animate-ready { animation: modFadeUp 0.75s var(--mod-ease) forwards; }
    .delay-75  { animation-delay: 75ms; }
    .delay-100 { animation-delay: 100ms; }
    .delay-150 { animation-delay: 150ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-250 { animation-delay: 250ms; }
    .delay-300 { animation-delay: 300ms; }

    @keyframes modFadeUp {
        0%   { opacity: 0; transform: translateY(20px) scale(0.985); filter: blur(4px); }
        100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    @keyframes modProgress {
        from { width: 0; }
    }

    @keyframes modHighlight {
        0%, 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
        50%      { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
    }

    @keyframes modFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

    @keyframes modGlow {
        0%, 100% { opacity: 0.7; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.06); }
    }

    /* ============ Signature: circuit / signal hero backdrop ============ */
    @keyframes modDrift {
        0%   { transform: translate(0, 0); }
        50%  { transform: translate(-14px, 10px); }
        100% { transform: translate(0, 0); }
    }

    @keyframes modScan {
        0%   { transform: translateY(-100%); opacity: 0; }
        8%   { opacity: 0.55; }
        92%  { opacity: 0.55; }
        100% { transform: translateY(100%); opacity: 0; }
    }

    @keyframes modPulseDot {
        0%, 100% { opacity: 0.35; transform: scale(0.85); }
        50%      { opacity: 1; transform: scale(1.15); }
    }

    @keyframes modOrbitSpin {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    @keyframes modOrbitSpinReverse {
        from { transform: rotate(360deg); }
        to   { transform: rotate(0deg); }
    }

    @keyframes modRingReveal {
        from { stroke-dashoffset: var(--ring-circumference); }
    }

    @keyframes modBorderSweep {
        to { --angle: 360deg; }
    }

    @property --angle {
        syntax: '<angle>';
        initial-value: 0deg;
        inherits: false;
    }

    @keyframes modShimmerText {
        0%   { background-position: 200% center; }
        100% { background-position: -200% center; }
    }

    /* ============ Signature: constellation network (new) ============ */
    @keyframes modTwinkle {
        0%, 100% { opacity: 0.25; }
        50% { opacity: 1; }
    }

    @keyframes modLinkFlow {
        to { stroke-dashoffset: -240; }
    }

    @keyframes modNodePulse {
        0% { r: 2.4; opacity: 0.9; }
        70% { r: 9; opacity: 0; }
        100% { r: 9; opacity: 0; }
    }

    /* ============ Reading progress + scroll-to-top (new) ============ */
    @keyframes modBarShimmer {
        0% { background-position: -120px 0; }
        100% { background-position: 120px 0; }
    }

    #mod-read-progress {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: 3px;
        z-index: 60;
        background: transparent;
        pointer-events: none;
    }
    #mod-read-progress-fill {
        height: 100%;
        width: 0%;
        background: linear-gradient(90deg, var(--mod-cyan), var(--mod-violet) 55%, var(--mod-cyan-hot));
        background-size: 200% 100%;
        box-shadow: 0 0 12px rgba(34, 211, 238, 0.6);
        transition: width 120ms linear;
    }

    #mod-scroll-top {
        position: fixed;
        right: 1.25rem;
        bottom: 1.25rem;
        width: 46px;
        height: 46px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--mod-blue), var(--mod-navy));
        color: #fff;
        box-shadow: 0 10px 30px rgba(0, 58, 143, 0.35);
        border: 1px solid rgba(255,255,255,0.14);
        opacity: 0;
        transform: translateY(12px) scale(0.9);
        pointer-events: none;
        transition: opacity 260ms var(--mod-ease), transform 260ms var(--mod-ease-spring);
        z-index: 55;
        cursor: pointer;
    }
    #mod-scroll-top.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }
    #mod-scroll-top:hover { filter: brightness(1.12); }

    .mod-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(720px circle at 12% 0%, rgba(34, 211, 238, 0.22), transparent 55%),
            radial-gradient(640px circle at 100% 0%, rgba(139, 92, 246, 0.22), transparent 55%),
            linear-gradient(135deg, #071524 0%, #0d2742 45%, var(--mod-blue) 100%);
    }

    .mod-hero::before,
    .mod-hero::after {
        content: '';
        position: absolute;
        inset: auto;
        border-radius: 9999px;
        filter: blur(42px);
        pointer-events: none;
        animation: modFloat 8s ease-in-out infinite;
    }

    .mod-hero::before {
        width: 280px; height: 280px;
        top: -80px; right: -60px;
        background: rgba(34, 211, 238, 0.22);
    }

    .mod-hero::after {
        width: 340px; height: 340px;
        bottom: -120px; left: -90px;
        background: rgba(139, 92, 246, 0.2);
        animation-delay: -4s;
    }

    /* circuit grid layer */
    .mod-circuit {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.35;
        background-image:
            linear-gradient(rgba(94, 234, 212, 0.09) 1px, transparent 1px),
            linear-gradient(90deg, rgba(94, 234, 212, 0.09) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: radial-gradient(ellipse 90% 70% at 50% 20%, black 40%, transparent 85%);
        animation: modDrift 14s ease-in-out infinite;
    }

    /* constellation network layer */
    .mod-constellation {
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.9;
        mix-blend-mode: screen;
    }
    .mod-constellation .mod-link {
        stroke: rgba(94, 234, 212, 0.35);
        stroke-width: 1;
        stroke-dasharray: 4 6;
        animation: modLinkFlow 6s linear infinite;
    }
    .mod-constellation .mod-node {
        fill: var(--mod-cyan-hot);
        animation: modTwinkle 3.2s ease-in-out infinite;
    }

    /* scanline sweep */
    .mod-scanline {
        position: absolute;
        inset: 0;
        pointer-events: none;
        overflow: hidden;
    }
    .mod-scanline::before {
        content: '';
        position: absolute;
        left: 0; right: 0;
        height: 140px;
        top: 0;
        background: linear-gradient(180deg, transparent, rgba(34,211,238,0.09), transparent);
        animation: modScan 7s linear infinite;
    }

    /* floating signal particles */
    .mod-particle {
        position: absolute;
        border-radius: 9999px;
        background: rgba(94, 234, 212, 0.6);
        box-shadow: 0 0 10px 2px rgba(94, 234, 212, 0.5);
        pointer-events: none;
        animation: modFloat 6s ease-in-out infinite;
    }

    .mod-pulse-dot {
        animation: modPulseDot 1.8s ease-in-out infinite;
    }

    .mod-future-panel {
        background: linear-gradient(145deg, rgba(255,255,255,0.14), rgba(255,255,255,0.07));
        border: 1px solid rgba(255,255,255,0.16);
        box-shadow: 0 24px 80px rgba(2, 6, 23, 0.28);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        position: relative;
    }

    .mod-future-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        padding: 1px;
        background: linear-gradient(135deg, rgba(94,234,212,0.5), rgba(139,92,246,0.15) 40%, transparent 70%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    .mod-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.5rem 0.8rem;
        border-radius: 9999px;
        border: 1px solid rgba(255,255,255,0.16);
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.9);
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
        transition: border-color 220ms ease, background 220ms ease, transform 220ms var(--mod-ease);
    }
    .mod-chip:hover {
        border-color: rgba(94, 234, 212, 0.4);
        background: rgba(255,255,255,0.12);
        transform: translateY(-1px);
    }

    .mod-glass-card {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        transition: transform 260ms var(--mod-ease), border-color 260ms var(--mod-ease), background 260ms var(--mod-ease);
    }

    .mod-glass-card:hover {
        transform: translateY(-3px);
        border-color: rgba(94, 234, 212, 0.35);
        background: rgba(255,255,255,0.11);
    }

    /* headline shimmer sweep, plays once */
    .mod-title-shimmer {
        background: linear-gradient(100deg, #fff 30%, #a7f3ec 45%, #fff 60%);
        background-size: 220% auto;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: modShimmerText 2.6s ease-in-out 0.4s 1;
    }

    /* ============ Orbital progress ring (signature element) ============ */
    .mod-orbit-wrap {
        position: relative;
        width: 108px;
        height: 108px;
        flex-shrink: 0;
    }

    .mod-orbit-ring-outer {
        position: absolute;
        inset: -8px;
        border-radius: 9999px;
        border: 1px dashed rgba(94, 234, 212, 0.3);
        animation: modOrbitSpin 18s linear infinite;
    }

    .mod-orbit-ring-outer::before {
        content: '';
        position: absolute;
        top: -3px;
        left: 50%;
        width: 6px;
        height: 6px;
        border-radius: 9999px;
        background: var(--mod-cyan-hot);
        box-shadow: 0 0 8px 2px rgba(94, 234, 212, 0.8);
        transform: translateX(-50%);
    }

    .mod-orbit-ring-inner {
        position: absolute;
        inset: 8px;
        border-radius: 9999px;
        border: 1px dotted rgba(139, 92, 246, 0.35);
        animation: modOrbitSpinReverse 24s linear infinite;
    }

    .mod-orbit-progress {
        transform: rotate(-90deg);
        filter: drop-shadow(0 0 6px rgba(34, 211, 238, 0.55));
    }

    .mod-orbit-progress circle.mod-ring-fill {
        transition: stroke-dashoffset 1.2s var(--mod-ease);
    }

    .mod-orbit-center {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    /* ============ Hover-lift with animated gradient border ============ */
    .mod-hover-lift {
        position: relative;
        overflow: hidden;
        transition: transform 280ms var(--mod-ease), box-shadow 280ms var(--mod-ease), border-color 280ms var(--mod-ease);
        transform-style: preserve-3d;
        will-change: transform;
    }

    .mod-hover-lift:hover {
        box-shadow: 0 28px 54px rgba(15, 23, 42, 0.16);
        border-color: transparent;
    }

    .mod-hover-lift::after {
        content: '';
        position: absolute;
        top: -35%; left: -50%;
        width: 40%; height: 180%;
        background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,0.28) 45%, transparent 100%);
        transform: rotate(18deg);
        opacity: 0;
        transition: opacity 280ms ease;
        pointer-events: none;
    }

    .mod-hover-lift:hover::after {
        opacity: 1;
        animation: modGlow 900ms ease-in-out;
    }

    /* conic gradient border glow that sweeps on hover */
    .mod-border-glow {
        position: relative;
    }
    .mod-border-glow::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        padding: 1.5px;
        background: conic-gradient(from var(--angle), var(--mod-cyan) 0%, var(--mod-violet) 30%, transparent 55%, var(--mod-cyan) 100%);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 320ms ease;
        pointer-events: none;
        z-index: 2;
    }
    .mod-border-glow:hover::before {
        opacity: 1;
        animation: modBorderSweep 2.4s linear infinite;
    }

    /* HUD corner brackets for media panels (new) */
    .mod-hud-corners { position: relative; }
    .mod-hud-corners::before,
    .mod-hud-corners::after {
        content: '';
        position: absolute;
        width: 16px; height: 16px;
        border-color: rgba(94, 234, 212, 0.55);
        pointer-events: none;
        opacity: 0;
        transition: opacity 260ms ease;
    }
    .mod-hud-corners::before {
        top: 10px; left: 10px;
        border-top: 2px solid; border-left: 2px solid;
        border-top-left-radius: 4px;
    }
    .mod-hud-corners::after {
        bottom: 10px; right: 10px;
        border-bottom: 2px solid; border-right: 2px solid;
        border-bottom-right-radius: 4px;
    }
    .mod-hud-corners:hover::before,
    .mod-hud-corners:hover::after { opacity: 1; }

    .mod-progress-fill {
        animation: modProgress 1.1s var(--mod-ease) forwards;
    }

    /* ============ Filter toolbar with sliding indicator (new) ============ */
    .mod-filter-track {
        position: relative;
        display: inline-flex;
        gap: 0.5rem;
        padding: 4px;
        border-radius: 9999px;
        background: rgba(15, 23, 42, 0.04);
        border: 1px solid rgba(15, 23, 42, 0.06);
    }

    .mod-filter-btn {
        transition: color 0.25s var(--mod-ease);
        position: relative;
        z-index: 2;
        background: transparent;
    }

    .mod-filter-btn.active {
        color: #fff;
    }

    .mod-filter-btn:not(.active):hover {
        color: var(--mod-blue);
    }

    #mod-filter-indicator {
        position: absolute;
        top: 4px;
        left: 4px;
        height: calc(100% - 8px);
        width: 0;
        border-radius: 9999px;
        background: linear-gradient(135deg, var(--mod-blue), var(--mod-navy));
        box-shadow: 0 8px 22px rgba(0, 58, 143, 0.24);
        transition: transform 340ms var(--mod-ease-spring), width 340ms var(--mod-ease-spring);
        z-index: 1;
    }

    /* button sheen sweep */
    .mod-sheen {
        position: relative;
        overflow: hidden;
    }
    .mod-sheen::before {
        content: '';
        position: absolute;
        top: 0; left: -75%;
        width: 50%; height: 100%;
        background: linear-gradient(115deg, transparent, rgba(255,255,255,0.5), transparent);
        transform: skewX(-20deg);
        transition: left 650ms ease;
    }
    .mod-sheen:hover::before { left: 125%; }

    .lesson-card.is-hidden,
    .quiz-card.is-hidden {
        display: none !important;
    }

    .lesson-card.is-highlighted {
        animation: modHighlight 1.2s ease-in-out 2;
        border-color: #60a5fa !important;
    }

    .mod-sidebar-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(248,250,252,0.96));
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    }

    .mod-sidebar-link {
        transition: background 0.2s ease, padding-left 0.25s var(--mod-ease), color 0.2s ease, transform 0.2s ease;
    }

    .mod-sidebar-link:hover {
        background: rgba(0, 58, 143, 0.08);
        padding-left: 1rem;
        transform: translateX(2px);
    }

    .mod-sidebar-link.is-current {
        background: linear-gradient(90deg, rgba(0, 58, 143, 0.12), transparent);
        border-left: 3px solid var(--mod-blue);
        color: var(--mod-blue);
        font-weight: 600;
        position: relative;
    }

    .mod-sidebar-link.is-current .mod-current-dot {
        animation: modPulseDot 1.6s ease-in-out infinite;
    }

    .mod-section-shell {
        border: 1px solid rgba(15, 23, 42, 0.06);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.05);
    }

    /* animated divider under section headers (new) */
    .mod-section-divider {
        position: relative;
        height: 2px;
        border-radius: 9999px;
        background: linear-gradient(90deg, rgba(0,58,143,0.18), rgba(148,163,184,0.08) 60%, transparent);
        overflow: hidden;
        margin-top: 0.5rem;
    }
    .mod-section-divider::after {
        content: '';
        position: absolute;
        top: 0; left: -30%;
        width: 30%; height: 100%;
        background: linear-gradient(90deg, transparent, var(--mod-cyan), transparent);
        animation: modDividerSweep 3.4s ease-in-out infinite;
    }
    @keyframes modDividerSweep {
        0%   { left: -30%; }
        60%  { left: 110%; }
        100% { left: 110%; }
    }

    /* quiz mini radial score ring (new) */
    .mod-mini-ring { transform: rotate(-90deg); }
    .mod-mini-ring circle.mod-mini-ring-fill {
        transition: stroke-dashoffset 900ms var(--mod-ease);
    }

    /* refined empty states (new) */
    .mod-empty-state {
        position: relative;
        overflow: hidden;
    }
    .mod-empty-state .mod-empty-orbit {
        width: 64px; height: 64px;
        border-radius: 9999px;
        border: 1px dashed rgba(0, 58, 143, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        animation: modOrbitSpin 12s linear infinite;
    }

    /* custom scrollbars for nav panels */
    .mod-scroll::-webkit-scrollbar { width: 6px; }
    .mod-scroll::-webkit-scrollbar-track { background: transparent; }
    .mod-scroll::-webkit-scrollbar-thumb {
        background: rgba(0, 58, 143, 0.25);
        border-radius: 9999px;
    }
    .mod-scroll::-webkit-scrollbar-thumb:hover { background: rgba(0, 58, 143, 0.4); }

    /* focus states for accessibility */
    a:focus-visible,
    button:focus-visible,
    input:focus-visible {
        outline: 2px solid var(--mod-cyan);
        outline-offset: 2px;
        border-radius: 6px;
    }

    /* custom cursor glow (desktop, fine pointer only) */
    #mod-cursor-glow {
        position: fixed;
        top: 0; left: 0;
        width: 260px; height: 260px;
        border-radius: 9999px;
        background: radial-gradient(circle, rgba(34,211,238,0.10), transparent 70%);
        pointer-events: none;
        transform: translate(-50%, -50%);
        z-index: 5;
        opacity: 0;
        transition: opacity 400ms ease;
        will-change: transform;
    }

    /* ============ Attachment cards row (fixed alignment) ============ */
    .mod-attachments-grid {
        display: grid;
        gap: 1.25rem;
        grid-template-columns: 1fr;
    }
    @media (min-width: 640px) {
        .mod-attachments-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .mod-attachment-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .mod-attachment-card .mod-attachment-body {
        flex: 1;
    }

    /* ============ Session timer + complete button (new) ============ */
    .mod-timer-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 0.9rem;
        border-radius: 9999px;
        border: 1px solid rgba(255,255,255,0.16);
        background: rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.92);
        font-size: 0.82rem;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
        backdrop-filter: blur(10px);
    }
    .mod-timer-chip .mod-timer-dot {
        width: 7px; height: 7px;
        border-radius: 9999px;
        background: var(--mod-cyan-hot);
        animation: modPulseDot 1.6s ease-in-out infinite;
    }
    .mod-timer-chip.is-paused .mod-timer-dot {
        animation: none;
        background: rgba(255,255,255,0.35);
    }

    .mod-complete-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        justify-content: center;
        padding: 0.85rem 1rem;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: transform 220ms var(--mod-ease), box-shadow 220ms var(--mod-ease), background 220ms ease;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        box-shadow: 0 14px 30px rgba(16, 185, 129, 0.28);
        text-decoration: none;
    }
    .mod-complete-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 18px 38px rgba(16, 185, 129, 0.36);
    }
    .mod-complete-btn:disabled {
        background: rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.6);
        box-shadow: none;
        cursor: default;
    }
    .mod-complete-btn.is-loading {
        opacity: 0.75;
        pointer-events: none;
    }

    @media (prefers-reduced-motion: reduce) {
        [data-animate], .mod-progress-fill, .mod-hover-lift::after, .lesson-card.is-highlighted,
        .mod-circuit, .mod-scanline::before, .mod-particle, .mod-orbit-ring-outer, .mod-orbit-ring-inner,
        .mod-title-shimmer, .mod-border-glow::before, .mod-pulse-dot, .mod-constellation .mod-link,
        .mod-constellation .mod-node, .mod-section-divider::after, .mod-empty-orbit, .mod-timer-chip .mod-timer-dot {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
        .mod-title-shimmer { color: #fff; background: none; -webkit-background-clip: initial; }
        #mod-cursor-glow { display: none !important; }
        #mod-filter-indicator { transition: none !important; }
    }

    @media (max-width: 768px) {
        #mod-cursor-glow { display: none; }
        #mod-scroll-top { right: 1rem; bottom: 1rem; width: 42px; height: 42px; }
    }
</style>
@endpush

@section('content')
    {{-- Reading progress bar --}}
    <div id="mod-read-progress" aria-hidden="true"><div id="mod-read-progress-fill"></div></div>

    {{-- Custom cursor glow (desktop only, toggled via JS) --}}
    <div id="mod-cursor-glow" aria-hidden="true"></div>

    {{-- Hero --}}
    <section class="mod-hero text-white relative overflow-hidden">
        <div class="mod-circuit"></div>
        <svg class="mod-constellation" viewBox="0 0 900 420" preserveAspectRatio="none" aria-hidden="true">
            <line class="mod-link" x1="80" y1="60" x2="240" y2="140"></line>
            <line class="mod-link" x1="240" y1="140" x2="180" y2="260"></line>
            <line class="mod-link" x1="240" y1="140" x2="420" y2="90"></line>
            <line class="mod-link" x1="420" y1="90" x2="620" y2="150"></line>
            <line class="mod-link" x1="620" y1="150" x2="780" y2="70"></line>
            <line class="mod-link" x1="620" y1="150" x2="700" y2="290"></line>
            <line class="mod-link" x1="180" y1="260" x2="360" y2="330"></line>
            <line class="mod-link" x1="360" y1="330" x2="560" y2="310"></line>
            <circle class="mod-node" cx="80" cy="60" r="2.6" style="animation-delay:0s"></circle>
            <circle class="mod-node" cx="240" cy="140" r="3.2" style="animation-delay:0.4s"></circle>
            <circle class="mod-node" cx="180" cy="260" r="2.4" style="animation-delay:0.9s"></circle>
            <circle class="mod-node" cx="420" cy="90" r="2.8" style="animation-delay:1.3s"></circle>
            <circle class="mod-node" cx="620" cy="150" r="3.4" style="animation-delay:0.2s"></circle>
            <circle class="mod-node" cx="780" cy="70" r="2.4" style="animation-delay:1.7s"></circle>
            <circle class="mod-node" cx="700" cy="290" r="2.6" style="animation-delay:2.1s"></circle>
            <circle class="mod-node" cx="360" cy="330" r="2.8" style="animation-delay:1.1s"></circle>
            <circle class="mod-node" cx="560" cy="310" r="2.4" style="animation-delay:0.6s"></circle>
        </svg>
        <div class="mod-scanline"></div>
        <div class="mod-particle" style="width:5px;height:5px;top:18%;left:22%;animation-delay:0s;"></div>
        <div class="mod-particle" style="width:3px;height:3px;top:62%;left:8%;animation-delay:1.4s;"></div>
        <div class="mod-particle" style="width:4px;height:4px;top:32%;left:78%;animation-delay:2.6s;"></div>
        <div class="mod-particle" style="width:3px;height:3px;top:75%;left:88%;animation-delay:0.8s;"></div>

        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(96,165,250,0.12),transparent_58%)]"></div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14 relative z-10">
            <div data-animate class="flex flex-wrap items-center justify-between gap-3 mb-6">
                <a href="{{ route('courses.show', $course->slug) }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white text-sm transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to {{ $course->title }}</span>
                </a>
                <div class="hidden sm:flex items-center gap-2 text-[11px] uppercase tracking-[0.28em] text-slate-400">
                    <span>{{ $course->title }}</span>
                    <i class="fas fa-chevron-right text-[9px] text-slate-600"></i>
                    <span class="text-slate-300">{{ $module->title }}</span>
                </div>
            </div>

            <div data-animate class="delay-75 grid gap-8 xl:grid-cols-[1.2fr_0.8fr] xl:items-start">
                <div class="space-y-6">
                    <div class="flex flex-wrap gap-2">
                        <span class="mod-chip"><span class="w-1.5 h-1.5 rounded-full bg-cyan-300 mod-pulse-dot"></span> Future-ready learning</span>
                        <span class="mod-chip"><i class="fas fa-layer-group text-sky-200"></i> Module</span>
                        <span class="mod-chip"><i class="fas fa-bolt text-amber-300"></i> Interactive path</span>
                    </div>

                    <div>
                        <h1 class="font-display mod-title-shimmer text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight leading-tight">{{ $module->title }}</h1>
                        @if($module->description)
                            <p class="text-slate-300 mt-4 max-w-2xl leading-relaxed text-base md:text-lg">{{ $module->description }}</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="#section-lessons" class="mod-sheen inline-flex items-center gap-2 rounded-full bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-lg shadow-slate-950/15 hover:shadow-xl transition">
                            <i class="fas fa-book-open"></i> Explore lessons
                        </a>
                        <a href="#section-quizzes" class="mod-sheen inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/15 transition">
                            <i class="fas fa-clipboard-check"></i> View quizzes
                        </a>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="mod-glass-card rounded-2xl p-4">
                            <p class="font-display text-2xl font-bold text-white">{{ $lessons->count() }}</p>
                            <p class="text-sm text-slate-300">Learning assets</p>
                        </div>
                        <div class="mod-glass-card rounded-2xl p-4">
                            <p class="font-display text-2xl font-bold text-white">{{ $quizzes->count() }}</p>
                            <p class="text-sm text-slate-300">Knowledge checks</p>
                        </div>
                        <div class="mod-glass-card rounded-2xl p-4">
                            <p class="font-display text-2xl font-bold text-emerald-300">{{ $passedQuizzes }}</p>
                            <p class="text-sm text-slate-300">Completed</p>
                        </div>
                    </div>
                </div>

                <div class="mod-future-panel rounded-3xl p-5 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-200">Learning momentum</p>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Progress snapshot</p>
                        </div>
                        {{-- Automatic session timer chip (replaces the static "Live" badge) --}}
                        <div class="flex items-center gap-2">
                            <span class="mod-timer-chip" id="mod-session-timer" aria-label="Time spent on this module">
                                <span class="mod-timer-dot"></span>
                                <span id="mod-timer-display">00:00</span>
                            </span>
                        </div>
                    </div>

                    {{-- Signature element: orbital progress ring --}}
                    <div class="mt-6 flex items-center gap-5">
                        @php
                            $radius = 44;
                            $circumference = round(2 * pi() * $radius, 2);
                        @endphp
                        <div class="mod-orbit-wrap">
                            <div class="mod-orbit-ring-outer"></div>
                            <div class="mod-orbit-ring-inner"></div>
                            <svg class="mod-orbit-progress" width="108" height="108" viewBox="0 0 108 108">
                                <circle cx="54" cy="54" r="{{ $radius }}" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="6"></circle>
                                <circle
                                    id="mod-ring-fill"
                                    class="mod-ring-fill"
                                    cx="54" cy="54" r="{{ $radius }}"
                                    fill="none"
                                    stroke="url(#mod-ring-gradient)"
                                    stroke-width="6"
                                    stroke-linecap="round"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $circumference }}"
                                    data-circumference="{{ $circumference }}"
                                    data-target="{{ $userProgress }}"
                                    style="--ring-circumference: {{ $circumference }}px;"
                                ></circle>
                                <defs>
                                    <linearGradient id="mod-ring-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#22d3ee"></stop>
                                        <stop offset="55%" stop-color="#38bdf8"></stop>
                                        <stop offset="100%" stop-color="#34d399"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="mod-orbit-center">
                                <span class="font-display text-xl font-bold text-white"><span id="mod-progress-counter" data-target="{{ $userProgress }}">0</span>%</span>
                            </div>
                        </div>
                        <div class="flex-1 space-y-2">
                            <p class="text-sm text-slate-300">Module completion</p>
                            <p class="text-xs text-slate-400 leading-relaxed">Tracked in real time as lessons and quizzes are completed.</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-3">
                        <div class="rounded-2xl border border-white/10 bg-white/8 p-3 mod-glass-card">
                            <div class="flex items-center justify-between text-sm text-slate-200">
                                <span>Next best step</span>
                                <i class="fas fa-arrow-right text-sky-300"></i>
                            </div>
                            <p class="mt-1 text-sm text-slate-400">Continue with the next lesson or challenge when you are ready.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/8 p-3 mod-glass-card">
                            <div class="flex items-center justify-between text-sm text-slate-200">
                                <span>Study rhythm</span>
                                <i class="fas fa-clock text-violet-300"></i>
                            </div>
                            <p class="mt-1 text-sm text-slate-400">Short structured sessions make this module easier to finish.</p>
                        </div>
                    </div>

                    {{-- Mark module as complete --}}
                    <div class="mt-4">
                        @auth
                            @php
                                $isModuleCompleted = $userProgress >= 100;
                            @endphp
                            <button
                                type="button"
                                id="mod-complete-btn"
                                class="mod-complete-btn"
                                data-complete-url="{{ route('modules.markComplete', [$course->slug, $module->slug]) }}"
                                {{ $isModuleCompleted ? 'disabled' : '' }}
                            >
                                <i class="fas {{ $isModuleCompleted ? 'fa-circle-check' : 'fa-flag-checkered' }}"></i>
                                <span id="mod-complete-btn-label">{{ $isModuleCompleted ? 'Module Completed' : 'Mark Module as Complete' }}</span>
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="mod-complete-btn" style="background: rgba(255,255,255,0.1); box-shadow:none;">
                                <i class="fas fa-sign-in-alt"></i> Log in to track completion
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            @if(!empty($course->image_url))
                <div data-animate class="delay-150 mt-8 overflow-hidden rounded-3xl border border-white/15 shadow-2xl shadow-slate-950/20">
                    <img src="{{ asset($course->image_url) }}" alt="{{ $course->title }}" class="w-full h-48 md:h-64 object-cover">
                </div>
            @endif

            @if($module->definition || $module->example)
                <div data-animate class="delay-200 grid gap-4 md:grid-cols-2 mt-8">
                    @if($module->definition)
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm shadow-lg shadow-slate-950/10 mod-glass-card">
                            <h2 class="text-sm font-bold uppercase tracking-[0.28em] text-sky-200 mb-2">Definition</h2>
                            <p class="text-slate-200 text-sm leading-relaxed">{!! nl2br(e($module->definition)) !!}</p>
                        </div>
                    @endif
                    @if($module->example)
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm shadow-lg shadow-slate-950/10 mod-glass-card">
                            <h2 class="text-sm font-bold uppercase tracking-[0.28em] text-sky-200 mb-2">Practical Example</h2>
                            <p class="text-slate-200 text-sm leading-relaxed">{!! nl2br(e($module->example)) !!}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>

    {{-- Main content --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            {{-- Main column --}}
            <div class="lg:col-span-2 space-y-10">
                @php
                    $moduleVideoUrl = null;
                    $moduleImageUrl = null;
                    $modulePptUrl = null;
                    $modulePdfUrl = null;

                    if (!empty($module->video_url)) {
                        $moduleVideoUrl = str_starts_with($module->video_url, 'http') ? $module->video_url : asset($module->video_url);
                    }
                    if (!empty($module->image_url)) {
                        $moduleImageUrl = str_starts_with($module->image_url, 'http') ? $module->image_url : asset($module->image_url);
                    }
                    if (!empty($module->ppt_url)) {
                        $modulePptUrl = str_starts_with($module->ppt_url, 'http') ? $module->ppt_url : asset($module->ppt_url);
                    }
                    if (!empty($module->thumbnail)) {
                        $modulePdfUrl = str_starts_with($module->thumbnail, 'http') ? $module->thumbnail : asset($module->thumbnail);
                    }
                    if (empty($modulePdfUrl) && !empty($module->word_url)) {
                        $modulePdfUrl = str_starts_with($module->word_url, 'http') ? $module->word_url : asset($module->word_url);
                    }
                @endphp

                {{-- Attachment cards: aligned in a clean, even grid instead of stacked full-width --}}
                @if($moduleVideoUrl || $moduleImageUrl || $modulePptUrl || $modulePdfUrl)
                    <div class="mod-attachments-grid" data-animate>
                        @if($moduleVideoUrl)
                            <section class="mod-attachment-card mod-border-glow mod-hud-corners rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="mod-attachment-body">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600">
                                            <i class="fas fa-video"></i>
                                        </div>
                                        <div>
                                            <h2 class="font-display text-lg font-bold text-gray-800">Module Video</h2>
                                            <p class="text-sm text-gray-500">This video is attached to the module.</p>
                                        </div>
                                    </div>
                                    <video controls class="w-full rounded-xl border border-gray-100 bg-black" preload="metadata">
                                        <source src="{{ $moduleVideoUrl }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <a href="{{ $moduleVideoUrl }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center text-sm font-semibold text-[#003a8f] hover:underline">
                                    <i class="fas fa-external-link-alt mr-2"></i>Open video in a new tab
                                </a>
                            </section>
                        @endif

                        @if($moduleImageUrl)
                            <section class="mod-attachment-card mod-border-glow mod-hud-corners rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="mod-attachment-body">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <div>
                                            <h2 class="font-display text-lg font-bold text-gray-800">Module Image</h2>
                                            <p class="text-sm text-gray-500">This image is attached to the module.</p>
                                        </div>
                                    </div>
                                    <img src="{{ $moduleImageUrl }}" alt="Module image" class="w-full rounded-xl border border-gray-100 object-cover h-52">
                                </div>
                            </section>
                        @endif

                        @if($modulePptUrl)
                            <section class="mod-attachment-card mod-border-glow mod-hud-corners rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="mod-attachment-body">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                            <i class="fas fa-file-powerpoint"></i>
                                        </div>
                                        <div>
                                            <h2 class="font-display text-lg font-bold text-gray-800">Module Presentation</h2>
                                            <p class="text-sm text-gray-500">Open the attached PPT file.</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ $modulePptUrl }}" target="_blank" rel="noopener" class="mod-sheen inline-flex items-center rounded-lg bg-[#003a8f] px-4 py-2 text-sm font-semibold text-white hover:bg-[#002d6b] self-start">
                                    <i class="fas fa-download mr-2"></i>Open presentation
                                </a>
                            </section>
                        @endif

                        @if($modulePdfUrl)
                            <section class="mod-attachment-card mod-border-glow mod-hud-corners rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                                <div class="mod-attachment-body">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <h2 class="font-display text-lg font-bold text-gray-800">Module PDF</h2>
                                            <p class="text-sm text-gray-500">Open the attached document.</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ $modulePdfUrl }}" target="_blank" rel="noopener" class="mod-sheen inline-flex items-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700 self-start">
                                    <i class="fas fa-download mr-2"></i>Open document
                                </a>
                            </section>
                        @endif
                    </div>
                @endif

                {{-- Toolbar --}}
                <div data-animate class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="mod-filter-track" id="mod-filter-track">
                        <div id="mod-filter-indicator"></div>
                        <button type="button" class="mod-filter-btn active text-sm font-semibold px-4 py-2 rounded-full" data-filter="all" aria-pressed="true">All</button>
                        <button type="button" class="mod-filter-btn text-sm font-semibold px-4 py-2 rounded-full text-gray-600" data-filter="lesson" aria-pressed="false">Lessons</button>
                        <button type="button" class="mod-filter-btn text-sm font-semibold px-4 py-2 rounded-full text-gray-600" data-filter="quiz" aria-pressed="false">Quizzes</button>
                        <button type="button" class="mod-filter-btn text-sm font-semibold px-4 py-2 rounded-full text-gray-600" data-filter="presentation" aria-pressed="false">Presentations</button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" id="btn-find-ppt" class="mod-sheen inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 text-[#003a8f] text-sm font-semibold hover:bg-blue-100 transition">
                            <i class="fas fa-search"></i> Find PPT
                        </button>
                        @if(auth()->check() && auth()->user()->hasStaffAccess())
                            <button type="button" onclick="document.getElementById('add-lesson-modal')?.classList.remove('hidden')" class="mod-sheen inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-50 text-green-700 text-sm font-semibold hover:bg-green-100 transition">
                                <i class="fas fa-plus"></i> Add Lesson
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Lessons --}}
                <section id="section-lessons">
                    <div data-animate class="delay-100 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-sky-100 to-blue-200 flex items-center justify-center shadow-sm">
                                <i class="fas fa-book-open text-[#003a8f]"></i>
                            </div>
                            <div>
                                <h2 class="font-display text-xl font-bold text-gray-800">Module Materials</h2>
                                <p class="text-sm text-gray-500">{{ $lessons->count() }} lessons &middot; videos, docs &amp; presentations</p>
                            </div>
                        </div>
                        <div class="mod-section-divider"></div>
                    </div>

                    @if($lessons->count() > 0)
                        {{-- FIX: added sm:grid-cols-2 so lesson & PPT cards align in a clean, even 2-column grid
                             instead of stacking full-width. Cards match height via items-stretch + flex on article. --}}
                        <div class="grid gap-6 sm:grid-cols-2 items-stretch" id="lessons-grid">
                            @foreach($lessons as $index => $lesson)
                                @php
                                    $hasVideo = !empty($lesson->video_url);
                                    $hasPresentation = $lesson->isPresentation();
                                    $hasImage = $lesson->isImage();
                                    $hasDocument = $lesson->isDocument();
                                    $contentLabel = $lesson->resourceLabel();
                                    $resourceUrl = $lesson->resourceUrl();
                                    $typeSlug = strtolower(str_replace(' ', '-', $contentLabel));
                                @endphp

                                <article
                                    class="lesson-card mod-hover-lift mod-border-glow js-tilt bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm flex flex-col h-full"
                                    data-animate
                                    data-card-type="lesson"
                                    data-lesson-type="{{ $typeSlug }}"
                                    data-search="{{ strtolower($lesson->title) }}"
                                    style="animation-delay: {{ min($index * 60, 300) }}ms"
                                >
                                    <div class="relative h-48 sm:h-52 bg-slate-100 overflow-hidden group shrink-0">
                                        @if($hasImage && $resourceUrl)
                                            <img src="{{ $resourceUrl }}" alt="{{ $lesson->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        @elseif($hasVideo)
                                            <div class="h-full w-full flex items-center justify-center bg-linear-to-br from-[#003a8f] via-[#0f4db1] to-slate-700 text-white">
                                                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform">
                                                    <i class="fas fa-play text-2xl ml-1"></i>
                                                </div>
                                            </div>
                                        @elseif($hasPresentation)
                                            <div class="h-full w-full flex flex-col items-center justify-center bg-linear-to-br from-amber-50 to-orange-100 text-amber-700">
                                                <i class="fas fa-file-powerpoint text-5xl mb-2 opacity-80"></i>
                                                <span class="text-sm font-semibold">Presentation</span>
                                            </div>
                                        @elseif($hasDocument)
                                            <div class="h-full w-full flex flex-col items-center justify-center bg-linear-to-br from-slate-100 to-slate-200 text-slate-600">
                                                <i class="fas fa-file-alt text-5xl mb-2 opacity-70"></i>
                                                <span class="text-sm font-semibold">Document</span>
                                            </div>
                                        @else
                                            <div class="h-full w-full flex flex-col items-center justify-center text-slate-400 bg-linear-to-br from-slate-50 to-slate-100">
                                                <i class="fas fa-file-lines text-4xl mb-2"></i>
                                                <span class="text-sm">Text lesson</span>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-linear-to-t from-slate-950/20 via-transparent to-transparent"></div>
                                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-linear-to-t from-slate-950/45 via-transparent to-transparent"></div>
                                        <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-[0.24em] px-2.5 py-1 rounded-full bg-white/90 text-[#003a8f] shadow-sm">{{ $contentLabel }}</span>
                                        <span class="absolute bottom-3 right-3 w-8 h-8 rounded-full bg-white/90 text-[#003a8f] flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0 transition-all duration-300 shadow-sm">
                                            <i class="fas fa-arrow-up-right-from-square"></i>
                                        </span>
                                    </div>

                                    <div class="p-5 sm:p-6 flex flex-col flex-1">
                                        <div class="flex items-center justify-between gap-2 mb-3">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600">
                                                <i class="fas fa-clock"></i>{{ $lesson->duration_minutes ? $lesson->duration_minutes . ' min' : 'Flexible' }}
                                            </span>
                                            <span class="text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Lesson</span>
                                        </div>
                                        <h3 class="font-display text-lg font-bold text-slate-900 mb-2">{{ $lesson->title }}</h3>
                                        <p class="text-sm text-slate-600 mb-5 line-clamp-2">{{ $lesson->description ?? 'Open this lesson to access the full learning material.' }}</p>

                                        <div class="flex flex-wrap gap-2 mt-auto">
                                            @if($hasVideo && $resourceUrl)
                                                <a href="{{ $resourceUrl }}" target="_blank" rel="noopener" class="mod-sheen inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#003a8f] text-white text-sm font-semibold hover:bg-[#0a2540] transition shadow-sm">
                                                    <i class="fas fa-play"></i> Watch
                                                </a>
                                            @endif
                                            @if(($hasPresentation || $hasDocument || $hasImage) && $resourceUrl)
                                                <a href="{{ $resourceUrl }}" target="_blank" rel="noopener" class="mod-sheen inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 text-slate-800 text-sm font-semibold hover:bg-slate-200 transition">
                                                    <i class="fas fa-external-link-alt"></i> Open
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div data-animate class="mod-empty-state rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                            <div class="mod-empty-orbit">
                                <i class="fas fa-folder-open text-2xl text-slate-300"></i>
                            </div>
                            <p class="font-semibold text-slate-800 mb-1">No lesson materials yet</p>
                            <p class="text-sm text-slate-500">Videos, images, and documents will appear here when added.</p>
                        </div>
                    @endif
                </section>

                {{-- Quizzes --}}
                <section id="section-quizzes">
                    <div data-animate class="delay-100 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-linear-to-br from-violet-100 to-fuchsia-200 flex items-center justify-center shadow-sm">
                                <i class="fas fa-clipboard-check text-violet-600"></i>
                            </div>
                            <div>
                                <h2 class="font-display text-xl font-bold text-gray-800">Quizzes</h2>
                                <p class="text-sm text-gray-500">Test your knowledge &middot; {{ $quizzes->count() }} available</p>
                            </div>
                        </div>
                        <div class="mod-section-divider"></div>
                    </div>

                    @if($quizzes->count() > 0)
                        <div class="grid gap-4 sm:grid-cols-2 items-stretch" id="quizzes-grid">
                            @foreach($quizzes as $index => $quiz)
                                @php
                                    $bestScore = auth()->check() ? $quiz->getUserBestScore(auth()->id()) : 0;
                                    $hasUserPassed = auth()->check() && $quiz->hasUserPassed(auth()->id());
                                    $attemptCount = auth()->check() ? $quiz->getUserAttemptCount(auth()->id()) : 0;
                                    $canRetry = auth()->check() && $quiz->canUserRetry(auth()->id());
                                    $miniRadius = 15.5;
                                    $miniCircumference = round(2 * pi() * $miniRadius, 2);
                                    $miniOffset = round($miniCircumference - (min(100, max(0, $bestScore)) / 100) * $miniCircumference, 2);
                                @endphp
                                <article
                                    class="quiz-card mod-hover-lift mod-border-glow js-tilt rounded-2xl border overflow-hidden shadow-sm flex flex-col h-full {{ $hasUserPassed ? 'border-green-200 bg-green-50/30' : 'border-gray-100 bg-white' }}"
                                    data-animate
                                    data-card-type="quiz"
                                    data-search="{{ strtolower($quiz->title) }}"
                                    style="animation-delay: {{ min($index * 60, 300) }}ms"
                                >
                                    <div class="p-5 sm:p-6 flex flex-col flex-1">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-100 text-violet-700">
                                                        <i class="fas fa-clipboard-check"></i>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-display text-lg font-bold text-gray-800">{{ $quiz->title }}</h3>
                                                        <p class="text-[11px] uppercase tracking-[0.24em] text-slate-400">Assessment</p>
                                                    </div>
                                                </div>
                                                @if($quiz->description)
                                                    <p class="text-gray-600 text-sm mt-1">{{ $quiz->description }}</p>
                                                @endif
                                            </div>
                                            @if($hasUserPassed)
                                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold shrink-0">
                                                    <i class="fas fa-check-circle"></i> Passed
                                                </span>
                                            @elseif($attemptCount > 0)
                                                <span class="inline-flex items-center gap-1.5 bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-xs font-bold shrink-0">
                                                    <i class="fas fa-redo"></i> Retry
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold shrink-0">
                                                    <i class="fas fa-circle-play"></i> New
                                                </span>
                                            @endif
                                        </div>

                                        <div class="grid grid-cols-3 gap-3 mb-4">
                                            <div class="rounded-xl bg-white/80 border border-gray-100 p-3 text-center">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-500 mb-1">Best</p>
                                                <div class="relative w-11 h-11 mx-auto">
                                                    <svg class="mod-mini-ring" width="44" height="44" viewBox="0 0 44 44">
                                                        <circle cx="22" cy="22" r="{{ $miniRadius }}" fill="none" stroke="#e2e8f0" stroke-width="4"></circle>
                                                        <circle class="mod-mini-ring-fill" cx="22" cy="22" r="{{ $miniRadius }}" fill="none" stroke="{{ $hasUserPassed ? '#22c55e' : '#003a8f' }}" stroke-width="4" stroke-linecap="round" stroke-dasharray="{{ $miniCircumference }}" stroke-dashoffset="{{ $miniOffset }}"></circle>
                                                    </svg>
                                                    <span class="absolute inset-0 flex items-center justify-center font-display text-[11px] font-bold text-gray-800">{{ $bestScore }}%</span>
                                                </div>
                                            </div>
                                            <div class="rounded-xl bg-white/80 border border-gray-100 p-3 text-center">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-500">Tries</p>
                                                <p class="font-display text-xl font-bold text-gray-800">{{ $attemptCount }}/{{ $quiz->attempt_limit }}</p>
                                            </div>
                                            <div class="rounded-xl bg-white/80 border border-gray-100 p-3 text-center">
                                                <p class="text-[10px] uppercase tracking-wider text-gray-500">Pass</p>
                                                <p class="font-display text-xl font-bold text-gray-800">{{ $quiz->passing_score }}%</p>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap gap-3 text-xs text-gray-500 mb-4">
                                            <span><i class="fas fa-list mr-1"></i>{{ $quiz->questions()->count() }} questions</span>
                                            @if($quiz->time_limit_minutes)
                                                <span><i class="fas fa-clock mr-1"></i>{{ $quiz->time_limit_minutes }} min</span>
                                            @endif
                                        </div>

                                        <div class="flex flex-col sm:flex-row gap-2 mt-auto">
                                            @if($canRetry || $attemptCount === 0)
                                                <a href="{{ route('quizzes.start', [$course->slug, $module->slug, $quiz->slug]) }}" class="mod-sheen flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-linear-to-r from-[#003a8f] to-[#1e4976] text-white text-sm font-bold hover:shadow-lg transition text-center">
                                                    {{ $attemptCount > 0 ? 'Retry Quiz' : 'Start Quiz' }}
                                                    <i class="fas fa-arrow-right text-xs"></i>
                                                </a>
                                            @else
                                                <button type="button" disabled class="flex-1 px-4 py-3 rounded-xl bg-gray-200 text-gray-500 text-sm font-semibold cursor-not-allowed">
                                                    Max attempts reached
                                                </button>
                                            @endif
                                            <a href="{{ route('quizzes.show', [$course->slug, $module->slug, $quiz->slug]) }}" class="mod-sheen flex-1 inline-flex items-center justify-center px-4 py-3 rounded-xl bg-slate-100 text-slate-800 text-sm font-semibold hover:bg-slate-200 transition text-center">
                                                Details
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div data-animate class="mod-empty-state rounded-2xl border border-gray-100 bg-slate-50 p-8 text-center">
                            <div class="mod-empty-orbit">
                                <i class="fas fa-clipboard text-xl text-slate-300"></i>
                            </div>
                            <p class="text-gray-600 text-sm">No quizzes for this module yet.</p>
                        </div>
                    @endif
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
                <div data-animate class="delay-150 sticky top-24 space-y-6">
                    {{-- Module outline --}}
                    <div class="mod-sidebar-card rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-slate-50">
                            <h3 class="font-display font-bold text-gray-800 text-sm">Module Outline</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $totalItems }} items in order</p>
                        </div>
                        <nav class="mod-scroll p-2 max-h-80 overflow-y-auto">
                            @forelse($orderedItems as $item)
                                @if($item->type === 'lesson')
                                    <a href="#section-lessons" class="mod-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600">
                                        <span class="w-7 h-7 rounded-lg bg-blue-50 text-[#003a8f] flex items-center justify-center text-xs shrink-0"><i class="fas fa-play"></i></span>
                                        <span class="truncate">{{ $item->title }}</span>
                                    </a>
                                @else
                                    <a href="#section-quizzes" class="mod-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600">
                                        <span class="w-7 h-7 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center text-xs shrink-0"><i class="fas fa-clipboard-check"></i></span>
                                        <span class="truncate">{{ $item->title }}</span>
                                    </a>
                                @endif
                            @empty
                                <p class="px-3 py-4 text-xs text-gray-500">No content yet.</p>
                            @endforelse
                        </nav>
                    </div>

                    {{-- Course modules --}}
                    <div class="mod-sidebar-card rounded-2xl border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-slate-50">
                            <h3 class="font-display font-bold text-gray-800 text-sm">Course Topics</h3>
                        </div>
                        <nav class="mod-scroll p-2 max-h-64 overflow-y-auto">
                            @foreach($course->modules as $courseModule)
                                <a
                                    href="{{ route('modules.show', [$course->slug, $courseModule->slug]) }}"
                                    class="mod-sidebar-link flex items-center justify-between gap-2 px-3 py-2.5 rounded-xl text-sm {{ $courseModule->id === $module->id ? 'is-current' : 'text-gray-600' }}"
                                >
                                    <span class="truncate">{{ $courseModule->title }}</span>
                                    @if($courseModule->id === $module->id)
                                        <i class="fas fa-circle text-[6px] text-[#003a8f] shrink-0 mod-current-dot"></i>
                                    @endif
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    {{-- Quick search --}}
                    <div class="mod-sidebar-card rounded-2xl border border-gray-100 p-4">
                        <label for="mod-content-search" class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2 block">Search content</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="search" id="mod-content-search" placeholder="Lesson or quiz..." class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#003a8f] focus:ring-4 focus:ring-blue-100">
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    {{-- Scroll to top --}}
    <button type="button" id="mod-scroll-top" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const fine = window.matchMedia('(pointer: fine)').matches;

    // Scroll reveal
    const animateEls = document.querySelectorAll('[data-animate]');
    if (!reduced) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-ready');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.06, rootMargin: '0px 0px -30px 0px' });
        animateEls.forEach(el => observer.observe(el));
    } else {
        animateEls.forEach(el => { el.style.opacity = '1'; el.style.transform = 'none'; el.style.filter = 'none'; });
    }

    // Progress counter (numeric)
    const counter = document.getElementById('mod-progress-counter');
    if (counter) {
        const target = parseInt(counter.dataset.target, 10) || 0;
        if (reduced) { counter.textContent = target; }
        else {
            const start = performance.now();
            const tick = (now) => {
                const p = Math.min((now - start) / 1200, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                counter.textContent = Math.round(target * eased);
                if (p < 1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
        }
    }

    // Orbital progress ring fill
    const ringFill = document.getElementById('mod-ring-fill');
    if (ringFill) {
        const circumference = parseFloat(ringFill.dataset.circumference) || 0;
        const target = Math.max(0, Math.min(100, parseFloat(ringFill.dataset.target) || 0));
        const offset = circumference - (target / 100) * circumference;
        // Force reflow before transition so it animates from full to target
        requestAnimationFrame(() => {
            setTimeout(() => { ringFill.style.strokeDashoffset = offset; }, reduced ? 0 : 150);
        });
    }

    // Reading progress bar
    const readFill = document.getElementById('mod-read-progress-fill');
    if (readFill) {
        const updateReadProgress = () => {
            const doc = document.documentElement;
            const scrollable = doc.scrollHeight - doc.clientHeight;
            const pct = scrollable > 0 ? Math.min(100, Math.max(0, (window.scrollY / scrollable) * 100)) : 0;
            readFill.style.width = pct + '%';
        };
        updateReadProgress();
        window.addEventListener('scroll', updateReadProgress, { passive: true });
        window.addEventListener('resize', updateReadProgress);
    }

    // Scroll to top button
    const scrollTopBtn = document.getElementById('mod-scroll-top');
    if (scrollTopBtn) {
        const toggleScrollTop = () => {
            scrollTopBtn.classList.toggle('is-visible', window.scrollY > 480);
        };
        toggleScrollTop();
        window.addEventListener('scroll', toggleScrollTop, { passive: true });
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: reduced ? 'auto' : 'smooth' });
        });
    }

    // Content filters
    const filterBtns = document.querySelectorAll('.mod-filter-btn');
    const filterTrack = document.getElementById('mod-filter-track');
    const filterIndicator = document.getElementById('mod-filter-indicator');
    const lessonCards = document.querySelectorAll('.lesson-card');
    const quizCards = document.querySelectorAll('.quiz-card');

    function applyFilter(filter) {
        lessonCards.forEach(card => {
            const type = card.dataset.lessonType || '';
            const show = filter === 'all' || filter === 'lesson'
                || (filter === 'presentation' && type === 'presentation');
            card.classList.toggle('is-hidden', !show);
        });
        quizCards.forEach(card => {
            const show = filter === 'all' || filter === 'quiz';
            card.classList.toggle('is-hidden', !show);
        });
        document.getElementById('section-lessons')?.classList.toggle('hidden', filter === 'quiz');
        document.getElementById('section-quizzes')?.classList.toggle('hidden', filter === 'lesson' || filter === 'presentation');
    }

    function moveIndicator(btn) {
        if (!filterIndicator || !filterTrack || !btn) return;
        const trackRect = filterTrack.getBoundingClientRect();
        const btnRect = btn.getBoundingClientRect();
        const left = btnRect.left - trackRect.left;
        filterIndicator.style.width = btnRect.width + 'px';
        filterIndicator.style.transform = `translateX(${left - 4}px)`;
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => { b.classList.remove('active'); b.classList.add('text-gray-600'); b.setAttribute('aria-pressed', 'false'); });
            btn.classList.add('active');
            btn.classList.remove('text-gray-600');
            btn.setAttribute('aria-pressed', 'true');
            applyFilter(btn.dataset.filter);
            moveIndicator(btn);
        });
    });

    const activeFilterBtn = document.querySelector('.mod-filter-btn.active');
    if (activeFilterBtn) {
        requestAnimationFrame(() => moveIndicator(activeFilterBtn));
        window.addEventListener('resize', () => moveIndicator(document.querySelector('.mod-filter-btn.active')));
    }

    // Search
    const searchInput = document.getElementById('mod-content-search');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            [...lessonCards, ...quizCards].forEach(card => {
                const match = !q || (card.dataset.search || '').includes(q);
                card.classList.toggle('is-hidden', !match);
            });
        });
    }

    // Find presentation
    document.getElementById('btn-find-ppt')?.addEventListener('click', findPresentation);

    function findPresentation() {
        const cards = document.querySelectorAll('.lesson-card[data-lesson-type="presentation"]:not(.is-hidden)');
        if (!cards.length) {
            const msg = 'No presentation lesson found in this module.';
            if (window.Swal) Swal.fire({ icon: 'warning', title: 'Not found', text: msg });
            else alert(msg);
            return;
        }
        const first = cards[0];
        first.classList.add('is-highlighted');
        first.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => first.classList.remove('is-highlighted'), 4000);
        if (window.Swal) {
            Swal.fire({ icon: 'success', title: 'Found!', text: 'Presentation highlighted below.', timer: 2000, showConfirmButton: false });
        }
    }

    // 3D tilt effect on cards (desktop, fine pointer only)
    if (!reduced && fine) {
        document.querySelectorAll('.js-tilt').forEach(card => {
            let frame = null;
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const rotX = ((y / rect.height) - 0.5) * -6;
                const rotY = ((x / rect.width) - 0.5) * 6;
                if (frame) cancelAnimationFrame(frame);
                frame = requestAnimationFrame(() => {
                    card.style.transform = `perspective(900px) rotateX(${rotX}deg) rotateY(${rotY}deg) translateY(-4px)`;
                });
            });
            card.addEventListener('mouseleave', () => {
                if (frame) cancelAnimationFrame(frame);
                card.style.transform = '';
            });
        });

        // Cursor glow follow
        const glow = document.getElementById('mod-cursor-glow');
        if (glow) {
            let gx = 0, gy = 0, tx = 0, ty = 0;
            const move = () => {
                gx += (tx - gx) * 0.15;
                gy += (ty - gy) * 0.15;
                glow.style.transform = `translate(${gx}px, ${gy}px) translate(-50%, -50%)`;
                requestAnimationFrame(move);
            };
            window.addEventListener('mousemove', (e) => {
                tx = e.clientX; ty = e.clientY;
                glow.style.opacity = '1';
            });
            window.addEventListener('mouseleave', () => { glow.style.opacity = '0'; });
            requestAnimationFrame(move);
        }
    }

    // ============ Automatic session timer + heartbeat (new) ============
    @auth
    (function () {
        const timerDisplay = document.getElementById('mod-timer-display');
        const timerChip = document.getElementById('mod-session-timer');
        const trackUrl = "{{ route('modules.trackTime', [$course->slug, $module->slug]) }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        let seconds = 0;
        let paused = document.hidden;
        let heartbeatAccum = 0;
        const HEARTBEAT_INTERVAL = 30; // seconds between server pings

        function formatTime(total) {
            const m = Math.floor(total / 60).toString().padStart(2, '0');
            const s = (total % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        }

        function sendHeartbeat(secondsSpent) {
            if (!csrfToken || secondsSpent <= 0) return;
            fetch(trackUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ seconds: secondsSpent }),
                keepalive: true, // lets the request survive page unload
            }).catch(() => {/* fail silently, don't disrupt UX */});
        }

        const tick = setInterval(() => {
            if (paused) return;
            seconds += 1;
            heartbeatAccum += 1;
            if (timerDisplay) timerDisplay.textContent = formatTime(seconds);

            if (heartbeatAccum >= HEARTBEAT_INTERVAL) {
                sendHeartbeat(heartbeatAccum);
                heartbeatAccum = 0;
            }
        }, 1000);

        // Pause the timer when the tab isn't visible (accurate time-on-task)
        document.addEventListener('visibilitychange', () => {
            paused = document.hidden;
            timerChip?.classList.toggle('is-paused', paused);
        });

        // Flush any remaining time when the user leaves
        window.addEventListener('beforeunload', () => {
            if (heartbeatAccum > 0) sendHeartbeat(heartbeatAccum);
        });
    })();

    // Mark as Complete button
    const completeBtn = document.getElementById('mod-complete-btn');
    if (completeBtn) {
        completeBtn.addEventListener('click', () => {
            const url = completeBtn.dataset.completeUrl;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            completeBtn.classList.add('is-loading');
            completeBtn.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
            .then(res => {
                if (!res.ok) throw new Error('Request failed');
                return res.json();
            })
            .then(() => {
                completeBtn.innerHTML = '<i class="fas fa-circle-check"></i> Module Completed';
                if (window.Swal) {
                    Swal.fire({ icon: 'success', title: 'Nice work!', text: 'Module marked as complete.', timer: 2200, showConfirmButton: false });
                }
                const ring = document.getElementById('mod-ring-fill');
                if (ring) {
                    ring.style.strokeDashoffset = 0;
                }
                const counter = document.getElementById('mod-progress-counter');
                if (counter) counter.textContent = '100';
            })
            .catch(() => {
                completeBtn.classList.remove('is-loading');
                completeBtn.disabled = false;
                if (window.Swal) {
                    Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Could not mark module complete. Please try again.' });
                } else {
                    alert('Could not mark module complete. Please try again.');
                }
            });
        });
    }
    @endauth

    // Echo notifications
    @if(auth()->check())
        const userId = {{ auth()->id() }};
        if (window.Echo) {
            try {
                Echo.private(`App.Models.User.${userId}`)
                    .notification((payload) => {
                        const title = payload.lesson_title || 'New content available';
                        const url = payload.url || null;
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'info',
                                title: 'New material added',
                                text: title,
                                showCancelButton: true,
                                confirmButtonText: 'View',
                                cancelButtonText: 'Later',
                                confirmButtonColor: '#003a8f'
                            }).then((res) => { if (res.isConfirmed && url) window.location.href = url; });
                        } else if (url && confirm('New material: ' + title + '\n\nOpen module?')) {
                            window.location.href = url;
                        }
                    });
            } catch (e) {
                console.warn('Echo not configured', e);
            }
        }
    @endif
});
</script>
@endpush