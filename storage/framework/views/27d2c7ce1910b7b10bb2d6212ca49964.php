

<?php $__env->startSection('title', $course->title . ' - SkillUp'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* ===================================================================
       SKILLUP // COURSE — TRANSMISSION THEME v2
       Signature element: the "uplink" — a live telemetry readout in the
       hero (progress-coded packet stream) plus circuit-trace dividers
       that visually thread every section together, echoing the idea
       that a course page is a single continuous broadcast.
    =================================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    .su-course {
        --c-void: #05060d;
        --c-surface: #0b0e1a;
        --c-surface-2: #10152a;
        --c-glass: rgba(255,255,255,0.045);
        --c-glass-border: rgba(255,255,255,0.09);
        --c-primary: #7c5cff;
        --c-secondary: #00e5ff;
        --c-accent: #ff3d9a;
        --c-gold: #ffcf4d;
        --c-text: #e9edfb;
        --c-muted: #8b93ad;
        --c-muted-2: #5c6382;
        --font-display: 'Orbitron', 'Space Grotesk', sans-serif;
        --font-body: 'Inter', -apple-system, sans-serif;
        --font-mono: 'JetBrains Mono', 'Courier New', monospace;
        color: var(--c-text);
        background: var(--c-void);
        font-family: var(--font-body);
        position: relative;
        isolation: isolate;
    }
    .su-course * { box-sizing: border-box; }
    .su-heading { font-family: var(--font-display); font-weight: 700; letter-spacing: 0.01em; }
    .su-gradient-text {
        background: linear-gradient(100deg, #ffffff 0%, var(--c-secondary) 45%, var(--c-primary) 75%, var(--c-accent) 100%);
        -webkit-background-clip: text; background-clip: text; color: transparent;
        background-size: 200% auto;
        animation: su-text-sheen 6s linear infinite;
    }
    @keyframes su-text-sheen { to { background-position: 200% center; } }

    .su-eyebrow {
        font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.3em; text-transform: uppercase;
        color: var(--c-secondary); display: inline-flex; align-items: center; gap: 0.6em;
    }
    .su-eyebrow::before {
        content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--c-secondary);
        box-shadow: 0 0 10px 2px var(--c-secondary); animation: su-blink 1.8s ease-in-out infinite;
        flex-shrink: 0;
    }
    @keyframes su-blink { 0%,100% { opacity: 1; } 50% { opacity: 0.25; } }

    .su-reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s cubic-bezier(.16,1,.3,1); }
    .su-reveal.is-visible { opacity: 1; transform: translateY(0); }
    .su-reveal-delay-1 { transition-delay: 0.08s; }
    .su-reveal-delay-2 { transition-delay: 0.16s; }
    .su-reveal-delay-3 { transition-delay: 0.24s; }
    .su-reveal-delay-4 { transition-delay: 0.32s; }

    /* ---------- ambient cursor glow ---------- */
    .su-cursor-glow {
        position: fixed; width: 480px; height: 480px; border-radius: 50%; pointer-events: none;
        background: radial-gradient(circle, rgba(124,92,255,0.14), transparent 70%);
        transform: translate(-50%, -50%); z-index: 1; opacity: 0; transition: opacity 0.4s ease;
        will-change: transform;
    }

    /* ---------- hero ---------- */
    .su-course-hero {
        position: relative; overflow: hidden;
        padding: 4.5rem 1.5rem 4rem;
        background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(124,92,255,0.22), transparent 70%), var(--c-void);
        border-bottom: 1px solid var(--c-glass-border);
    }
    .su-hero-grid {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(0,229,255,0.08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0,229,255,0.08) 1px, transparent 1px);
        background-size: 52px 52px;
        -webkit-mask-image: linear-gradient(180deg, rgba(0,0,0,0.85) 0%, transparent 85%);
        mask-image: linear-gradient(180deg, rgba(0,0,0,0.85) 0%, transparent 85%);
        transform: perspective(600px) rotateX(58deg) scale(1.6);
        transform-origin: center top;
        animation: su-grid-drift 14s linear infinite;
        z-index: 0;
    }
    @keyframes su-grid-drift { from { background-position: 0 0, 0 0; } to { background-position: 0 52px, 52px 0; } }

    .su-hero-orb { position: absolute; border-radius: 50%; filter: blur(60px); z-index: 0; opacity: 0.55; animation: su-orb-float 16s ease-in-out infinite; }
    .su-hero-orb-a { width: 340px; height: 340px; top: -120px; left: -80px; background: radial-gradient(circle, var(--c-primary), transparent 70%); animation-delay: 0s; }
    .su-hero-orb-b { width: 260px; height: 260px; bottom: -100px; right: 4%; background: radial-gradient(circle, var(--c-secondary), transparent 70%); animation-delay: -6s; animation-duration: 19s; }
    .su-hero-orb-c { width: 180px; height: 180px; top: 30%; right: 22%; background: radial-gradient(circle, var(--c-accent), transparent 70%); animation-delay: -3s; animation-duration: 13s; opacity: 0.35; }
    @keyframes su-orb-float { 0%, 100% { transform: translate(0,0) scale(1); } 33% { transform: translate(18px,-14px) scale(1.06); } 66% { transform: translate(-14px,10px) scale(0.96); } }

    .su-scanline { position: absolute; inset: 0; z-index: 1; pointer-events: none; opacity: 0.5;
        background: repeating-linear-gradient(180deg, rgba(255,255,255,0.02) 0px, rgba(255,255,255,0.02) 1px, transparent 2px, transparent 4px); }

    .su-course-hero > .su-hero-inner { position: relative; z-index: 2; }

    .su-badge {
        font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.08em; text-transform: uppercase;
        display: inline-flex; align-items: center; gap: 0.4em; padding: 0.35rem 0.9rem; border-radius: 999px;
        background: rgba(0,229,255,0.1); border: 1px solid rgba(0,229,255,0.3); color: var(--c-secondary);
        transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    }
    .su-badge:hover { transform: translateY(-2px); box-shadow: 0 8px 20px -10px rgba(0,229,255,0.6); border-color: var(--c-secondary); }
    .su-badge.su-badge-alt { background: rgba(255,61,154,0.1); border-color: rgba(255,61,154,0.3); color: var(--c-accent); }
    .su-badge.su-badge-alt:hover { box-shadow: 0 8px 20px -10px rgba(255,61,154,0.6); border-color: var(--c-accent); }

    .su-course-title { font-size: clamp(2rem, 4.5vw, 3.1rem); line-height: 1.1; margin: 1.1rem 0 0.9rem; }
    .su-course-desc { color: var(--c-muted); font-size: 1.05rem; max-width: 42rem; line-height: 1.7; margin-bottom: 1.75rem; }

    .su-meta-row { display: flex; flex-wrap: wrap; gap: 1.5rem; font-size: 0.9rem; color: var(--c-muted); }
    .su-meta-row i { color: var(--c-secondary); margin-right: 0.4rem; }

    /* telemetry readout — signature detail */
    .su-telemetry {
        font-family: var(--font-mono); font-size: 0.72rem; color: var(--c-muted-2); letter-spacing: 0.05em;
        display: flex; align-items: center; gap: 0.5rem; margin-top: 1.4rem; overflow: hidden;
        border-top: 1px dashed var(--c-glass-border); padding-top: 0.85rem;
    }
    .su-telemetry .su-tele-tag { color: var(--c-secondary); flex-shrink: 0; }
    .su-telemetry .su-tele-bar { position: relative; flex: 1; height: 3px; background: rgba(255,255,255,0.08); border-radius: 999px; overflow: hidden; min-width: 60px; }
    .su-telemetry .su-tele-bar::after {
        content: ''; position: absolute; inset: 0; width: 40%; border-radius: 999px;
        background: linear-gradient(90deg, transparent, var(--c-secondary), transparent);
        animation: su-tele-sweep 2.4s linear infinite;
    }
    @keyframes su-tele-sweep { 0% { transform: translateX(-100%); } 100% { transform: translateX(350%); } }

    .su-btn {
        position: relative; display: inline-flex; align-items: center; gap: 0.5rem; overflow: hidden;
        font-family: var(--font-mono); font-size: 0.85rem; letter-spacing: 0.02em;
        padding: 0.7rem 1.3rem; border-radius: 10px; text-decoration: none; cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        border: 1px solid transparent;
    }
    .su-btn-solid { background: linear-gradient(100deg, var(--c-primary), var(--c-secondary)); color: #05060d; font-weight: 600; box-shadow: 0 14px 34px -16px rgba(0,229,255,0.5); }
    .su-btn-solid:hover { transform: translateY(-2px); box-shadow: 0 18px 40px -14px rgba(0,229,255,0.65); }
    .su-btn-outline { border-color: var(--c-glass-border); color: var(--c-text); background: var(--c-glass); }
    .su-btn-outline:hover { border-color: var(--c-secondary); color: var(--c-secondary); transform: translateY(-2px); }
    .su-btn-green { background: linear-gradient(100deg, #00d98b, #00e5ff); color: #05060d; font-weight: 600; }
    .su-btn-green:hover { transform: translateY(-2px); box-shadow: 0 16px 32px -16px rgba(0,217,139,0.55); }

    /* ripple */
    .su-ripple { position: absolute; border-radius: 50%; pointer-events: none; background: rgba(255,255,255,0.55); transform: scale(0); animation: su-ripple-anim 0.6s ease-out; }
    @keyframes su-ripple-anim { to { transform: scale(3.2); opacity: 0; } }

    /* instructor card */
    .su-instructor-card {
        background: var(--c-glass); border: 1px solid var(--c-glass-border); border-radius: 18px;
        padding: 2rem; text-align: center; backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
        position: relative; transition: border-color 0.3s ease, transform 0.3s ease;
    }
    .su-instructor-card:hover { border-color: rgba(0,229,255,0.32); transform: translateY(-3px); }
    .su-avatar-orb-wrap { position: relative; width: 96px; height: 96px; margin: 0 auto 1.1rem; }
    .su-avatar-orbit { position: absolute; inset: 0; border-radius: 50%; border: 1px dashed rgba(0,229,255,0.35); animation: su-spin 9s linear infinite; }
    .su-avatar-orbit::after { content: ''; position: absolute; top: -3px; left: calc(50% - 3px); width: 6px; height: 6px; border-radius: 50%; background: var(--c-secondary); box-shadow: 0 0 8px 2px var(--c-secondary); }
    @keyframes su-spin { to { transform: rotate(360deg); } }
    .su-avatar-orb {
        position: absolute; inset: 6px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--c-void);
        background: linear-gradient(135deg, var(--c-secondary), var(--c-primary));
        box-shadow: 0 0 0 1px var(--c-glass-border);
    }
    .su-avatar-orb::after {
        content: ''; position: absolute; inset: -7px; border-radius: 50%;
        border: 1px solid rgba(0,229,255,0.3); animation: su-pulse-ring 2.6s ease-out infinite;
    }
    @keyframes su-pulse-ring { 0% { transform: scale(0.9); opacity: 0.8; } 100% { transform: scale(1.45); opacity: 0; } }
    .su-instructor-card h3 { font-family: var(--font-display); font-size: 1.15rem; margin-bottom: 0.25rem; }
    .su-instructor-card p { color: var(--c-muted); font-size: 0.88rem; }
    .su-instructor-tag { display: inline-block; margin-top: 0.85rem; font-family: var(--font-mono); font-size: 0.64rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-secondary); border: 1px solid rgba(0,229,255,0.25); border-radius: 999px; padding: 0.25rem 0.7rem; }

    /* ---------- circuit divider (signature thread between sections) ---------- */
    .su-circuit-divider { position: relative; height: 2px; margin: 0 auto; max-width: 72rem; background: linear-gradient(90deg, transparent, var(--c-glass-border) 15%, var(--c-glass-border) 85%, transparent); }
    .su-circuit-divider .su-node { position: absolute; top: 50%; width: 7px; height: 7px; border-radius: 50%; background: var(--c-secondary); transform: translate(-50%, -50%); box-shadow: 0 0 10px 2px rgba(0,229,255,0.6); }

    /* ---------- stats strip ---------- */
    .su-stats-strip { background: linear-gradient(180deg, var(--c-surface), var(--c-void)); border-bottom: 1px solid var(--c-glass-border); padding: 2.75rem 1.5rem; }
    .su-stat-card {
        background: var(--c-glass); border: 1px solid var(--c-glass-border); border-radius: 14px; padding: 1.3rem 1.4rem;
        transition: border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease; position: relative; overflow: hidden;
    }
    .su-stat-card::before { content: ''; position: absolute; inset: 0; background: linear-gradient(120deg, transparent 40%, rgba(0,229,255,0.09) 50%, transparent 60%); transform: translateX(-120%); transition: transform 0.7s ease; }
    .su-stat-card:hover::before { transform: translateX(120%); }
    .su-stat-card:hover { transform: translateY(-3px); border-color: rgba(0,229,255,0.3); box-shadow: 0 20px 40px -28px rgba(0,229,255,0.55); }
    .su-stat-num { font-family: var(--font-display); font-size: 1.6rem; color: var(--c-secondary); display: flex; align-items: center; gap: 0.5rem; }
    .su-stat-label { font-family: var(--font-mono); font-size: 0.72rem; letter-spacing: 0.08em; text-transform: uppercase; color: var(--c-text); margin-top: 0.5rem; }
    .su-stat-sub { font-size: 0.78rem; color: var(--c-muted-2); margin-top: 0.3rem; }

    /* ---------- section titles ---------- */
    .su-section-eyebrow { font-family: var(--font-mono); font-size: 0.66rem; letter-spacing: 0.25em; text-transform: uppercase; color: var(--c-muted-2); margin-bottom: 0.6rem; display: block; }
    .su-section-title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); color: var(--c-text); margin-bottom: 1.4rem; }
    .su-body-copy { color: var(--c-muted); line-height: 1.8; }

    /* learning outcomes */
    .su-outcome { display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; border-radius: 12px; transition: background 0.3s ease, transform 0.3s ease; }
    .su-outcome:hover { background: var(--c-glass); transform: translateX(4px); }
    .su-outcome i { color: var(--c-secondary); font-size: 1.2rem; margin-top: 0.2rem; filter: drop-shadow(0 0 6px rgba(0,229,255,0.5)); }
    .su-outcome h4 { font-weight: 600; color: var(--c-text); margin-bottom: 0.2rem; }
    .su-outcome p { color: var(--c-muted); font-size: 0.9rem; }

    /* module / topic cards */
    .su-module-card {
        background: var(--c-glass); border: 1px solid var(--c-glass-border); border-radius: 20px; overflow: hidden;
        transition: transform 0.4s cubic-bezier(.16,1,.3,1), border-color 0.4s ease, box-shadow 0.4s ease;
        position: relative;
    }
    .su-module-card::before, .su-module-card::after,
    .su-module-corner-tl, .su-module-corner-br { content: ''; }
    .su-module-corner-tl, .su-module-corner-br {
        position: absolute; width: 18px; height: 18px; border: 2px solid var(--c-secondary); opacity: 0; transition: opacity 0.35s ease; z-index: 3; pointer-events: none;
    }
    .su-module-corner-tl { top: 10px; left: 10px; border-right: none; border-bottom: none; }
    .su-module-corner-br { bottom: 10px; right: 10px; border-left: none; border-top: none; }
    .su-module-card:hover .su-module-corner-tl,
    .su-module-card:hover .su-module-corner-br { opacity: 0.9; }
    .su-module-card:hover { transform: translateY(-5px); border-color: rgba(0,229,255,0.35); box-shadow: 0 22px 50px -24px rgba(0,229,255,0.3); }
    .su-module-index { position: absolute; top: 12px; left: 12px; z-index: 3; font-family: var(--font-mono); font-size: 0.66rem; letter-spacing: 0.06em; color: var(--c-secondary); background: rgba(5,6,13,0.65); border: 1px solid rgba(0,229,255,0.3); border-radius: 999px; padding: 0.2rem 0.6rem; backdrop-filter: blur(6px); }
    .su-module-thumb { position: relative; height: 11rem; background: var(--c-surface-2); overflow: hidden; }
    .su-module-thumb img { width: 100%; height: 100%; object-fit: cover; object-position: center; transition: transform 0.6s cubic-bezier(.16,1,.3,1); }
    .su-module-card:hover .su-module-thumb img { transform: scale(1.07); }
    .su-module-thumb-empty { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: rgba(0,229,255,0.4); font-size: 2.4rem; background: radial-gradient(circle at 30% 30%, rgba(124,92,255,0.18), transparent 65%); }
    .su-module-body { padding: 1.6rem; }
    .su-module-body h3 { font-family: var(--font-display); font-size: 1.05rem; color: var(--c-text); }
    .su-lesson-count { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--c-secondary); flex-shrink: 0; }
    .su-module-desc { color: var(--c-muted); font-size: 0.88rem; line-height: 1.6; margin: 0.9rem 0 1.2rem; }
    .su-resource-pill { font-family: var(--font-mono); font-size: 0.68rem; letter-spacing: 0.04em; color: var(--c-muted); background: rgba(255,255,255,0.05); border: 1px solid var(--c-glass-border); border-radius: 999px; padding: 0.5rem 0.9rem; }

    .su-empty-state { background: var(--c-glass); border: 1px dashed var(--c-glass-border); border-radius: 20px; padding: 3rem; text-align: center; color: var(--c-muted); }
    .su-empty-state i { color: var(--c-muted-2); }

    /* ---------- sidebar / enrollment ---------- */
    .su-side-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
        border: 1px solid var(--c-glass-border); border-radius: 22px; padding: 2rem;
        backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 30px 80px -46px rgba(124,92,255,0.4);
        position: relative; overflow: hidden;
        transition: border-color 0.4s ease, box-shadow 0.4s ease;
    }
    .su-side-card:hover { border-color: rgba(124,92,255,0.4); box-shadow: 0 34px 90px -40px rgba(124,92,255,0.55); }
    .su-side-card::before {
        content: ''; position: absolute; inset: -1px; border-radius: 22px; padding: 1px;
        background: conic-gradient(from 0deg, transparent, rgba(0,229,255,0.5), transparent 30%);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor; mask-composite: exclude;
        animation: su-spin 6s linear infinite; opacity: 0.5; pointer-events: none;
    }
    .su-side-thumb { border-radius: 14px; overflow: hidden; height: 12rem; margin-bottom: 1.5rem; position: relative; }
    .su-side-thumb img { width: 100%; height: 100%; object-fit: cover; object-position: center; }
    .su-side-thumb-empty {
        height: 12rem; border-radius: 14px; margin-bottom: 1.5rem;
        background: linear-gradient(135deg, rgba(124,92,255,0.35), rgba(255,61,154,0.35));
        display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.5); font-size: 3.5rem;
    }
    .su-status-panel { border-radius: 14px; padding: 1.1rem 1.3rem; margin-bottom: 1.5rem; border: 1px solid; position: relative; }
    .su-status-panel.su-status-ok { background: rgba(0,217,139,0.08); border-color: rgba(0,217,139,0.3); color: #4be8b8; }
    .su-status-panel.su-status-info { background: rgba(0,229,255,0.07); border-color: rgba(0,229,255,0.28); color: var(--c-secondary); }
    .su-status-panel.su-status-gold { background: rgba(255,207,77,0.08); border-color: rgba(255,207,77,0.32); color: #ffcf4d; }
    .su-status-panel.su-status-neutral { background: var(--c-glass); border-color: var(--c-glass-border); color: var(--c-text); }
    .su-progress-track { width: 100%; height: 8px; background: rgba(255,255,255,0.08); border-radius: 999px; overflow: hidden; margin-top: 0.7rem; position: relative; }
    .su-progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--c-secondary), #00d98b); box-shadow: 0 0 10px rgba(0,229,255,0.5); position: relative; width: 0%; transition: width 1.1s cubic-bezier(.16,1,.3,1); }
    .su-progress-fill::after { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.55), transparent); width: 30%; animation: su-tele-sweep 1.8s linear infinite; }

    .su-detail-row { display: flex; align-items: center; justify-content: space-between; padding: 0.9rem 0; border-bottom: 1px solid var(--c-glass-border); font-size: 0.9rem; }
    .su-detail-row:last-child { border-bottom: none; }
    .su-detail-row span:first-child { color: var(--c-muted); }
    .su-detail-row span:last-child, .su-detail-row .val { color: var(--c-text); font-weight: 600; }

    .su-share-row { display: flex; gap: 0.75rem; margin-top: 1rem; }
    .su-share-btn { flex: 1; text-align: center; padding: 0.75rem; border-radius: 10px; color: #fff; transition: transform 0.25s ease, box-shadow 0.25s ease; border: 1px solid var(--c-glass-border); }
    .su-share-btn:hover { transform: translateY(-3px); }
    .su-share-fb { background: rgba(24,119,242,0.18); color: #6fa8ff; }
    .su-share-tw { background: rgba(0,229,255,0.12); color: var(--c-secondary); }
    .su-share-li { background: rgba(255,61,154,0.14); color: var(--c-accent); }

    /* modal */
    .su-modal-overlay { position: fixed; inset: 0; background: rgba(2,3,8,0.75); backdrop-filter: blur(6px); z-index: 60; opacity: 0; transition: opacity 0.25s ease; }
    .su-modal-overlay.su-modal-show { opacity: 1; }
    .su-modal-panel {
        background: var(--c-surface); border: 1px solid var(--c-glass-border); border-radius: 20px;
        max-width: 32rem; width: 100%; padding: 2rem;
        box-shadow: 0 40px 100px -30px rgba(0,229,255,0.35);
        transform: scale(0.94) translateY(10px); opacity: 0; transition: transform 0.3s cubic-bezier(.16,1,.3,1), opacity 0.3s ease;
    }
    .su-modal-overlay.su-modal-show .su-modal-panel { transform: scale(1) translateY(0); opacity: 1; }
    .su-modal-panel h3 { font-family: var(--font-display); font-size: 1.3rem; margin-bottom: 0.5rem; }
    .su-modal-panel p { color: var(--c-muted); font-size: 0.9rem; }
    .su-modal-list { font-size: 0.88rem; color: var(--c-muted); margin: 1rem 0; }
    .su-modal-list li { margin-bottom: 0.4rem; }
    .su-modal-list strong { color: var(--c-text); }
    .su-btn-cancel { background: rgba(255,255,255,0.06); border: 1px solid var(--c-glass-border); color: var(--c-muted); border-radius: 10px; padding: 0.7rem 1rem; transition: border-color 0.3s ease, color 0.3s ease; }
    .su-btn-cancel:hover { border-color: var(--c-muted); color: var(--c-text); }

    /* focus visibility */
    .su-course a:focus-visible, .su-course button:focus-visible {
        outline: 2px solid var(--c-secondary); outline-offset: 3px; border-radius: 8px;
    }

    @media (prefers-reduced-motion: reduce) {
        .su-course *, .su-course *::before, .su-course *::after {
            animation-duration: 0.001ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.001ms !important;
        }
        .su-cursor-glow { display: none; }
    }
</style>

<div class="su-course">

    <div class="su-cursor-glow" id="su-cursor-glow"></div>

    
    <div class="su-course-hero">
        <div class="su-hero-orb su-hero-orb-a"></div>
        <div class="su-hero-orb su-hero-orb-b"></div>
        <div class="su-hero-orb su-hero-orb-c"></div>
        <div class="su-hero-grid"></div>
        <div class="su-scanline"></div>
        <div class="su-hero-inner max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                <!-- Course Info -->
                <div class="md:col-span-2 su-reveal">
                    <div class="mb-4 flex flex-wrap gap-3">
                        <span class="su-badge"><?php echo e($course->category); ?></span>
                        <span class="su-badge su-badge-alt"><?php echo e($course->level); ?></span>
                    </div>
                    <span class="su-eyebrow">Course Transmission</span>
                    <h1 class="su-course-title su-heading su-gradient-text"><?php echo e($course->title); ?></h1>
                    <p class="su-course-desc"><?php echo e($course->short_description); ?></p>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="su-meta-row">
                            <div><i class="fas fa-star" style="color:#ffcf4d;"></i><span class="font-semibold"><?php echo e(number_format($course->rating, 1)); ?>/5.0</span></div>
                            <div><i class="fas fa-users"></i><span><?php echo e(number_format($course->students_count)); ?> students</span></div>
                            <div><i class="fas fa-clock"></i><span><?php echo e($course->duration_hours); ?> hours</span></div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="#course-topics" class="su-btn su-btn-solid su-magnetic"><i class="fas fa-th-list"></i>Explore topics</a>
                            <a href="#course-curriculum" class="su-btn su-btn-outline su-magnetic"><i class="fas fa-book-open"></i>Show all materials</a>
                        </div>
                    </div>

                    <div class="su-telemetry">
                        <span class="su-tele-tag">UPLINK</span>
                        <span class="su-tele-bar"></span>
                        <span><?php echo e($course->modules->count()); ?> modules · <?php echo e($course->lessons->count()); ?> lessons queued</span>
                    </div>
                </div>

                <!-- Instructor Card -->
                <div class="su-instructor-card su-reveal su-reveal-delay-1">
                    <div class="su-avatar-orb-wrap">
                        <div class="su-avatar-orbit"></div>
                        <div class="su-avatar-orb"><i class="fas fa-user"></i></div>
                    </div>
                    <h3 class="su-heading"><?php echo e($course->instructor_name); ?></h3>
                    <p><?php echo e($course->instructor_title); ?></p>
                    <span class="su-instructor-tag">Lead Transmitter</span>
                </div>
            </div>
        </div>
    </div>

    <div class="su-circuit-divider"><span class="su-node" style="left:20%;"></span><span class="su-node" style="left:50%;"></span><span class="su-node" style="left:80%;"></span></div>

    
    <div class="su-stats-strip">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-5">
                <div class="su-stat-card su-reveal">
                    <div class="su-stat-num"><span class="su-count-up" data-target="<?php echo e($course->modules->count()); ?>">0</span></div>
                    <p class="su-stat-label">Modules</p>
                    <p class="su-stat-sub">Gain insight into a topic and learn the fundamentals.</p>
                </div>

                <div class="su-stat-card su-reveal su-reveal-delay-1">
                    <div class="su-stat-num"><?php echo e(number_format($course->rating, 1)); ?> <i class="fas fa-star" style="color:#ffcf4d; font-size:1rem;"></i></div>
                    <p class="su-stat-label">Rating</p>
                    <p class="su-stat-sub"><?php echo e(number_format($course->students_count)); ?> reviews</p>
                </div>

                <div class="su-stat-card su-reveal su-reveal-delay-2">
                    <div class="su-stat-num capitalize" style="font-size:1.15rem;"><?php echo e($course->level); ?></div>
                    <p class="su-stat-label">Level</p>
                    <p class="su-stat-sub">No prior experience required</p>
                </div>

                <div class="su-stat-card su-reveal su-reveal-delay-3">
                    <div class="su-stat-num"><span class="su-count-up" data-target="<?php echo e($course->duration_hours); ?>">0</span>h</div>
                    <p class="su-stat-label">Flexible Schedule</p>
                    <p class="su-stat-sub">Learn at your own pace</p>
                </div>

                <div class="su-stat-card su-reveal su-reveal-delay-4">
                    <div class="su-stat-num"><span class="su-count-up" data-target="<?php echo e(ceil($course->rating * 10)); ?>">0</span>% <i class="fas fa-thumbs-up" style="color: var(--c-secondary); font-size:1rem;"></i></div>
                    <p class="su-stat-label">Satisfaction</p>
                    <p class="su-stat-sub">Most learners liked this course</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Course Details -->
            <div class="lg:col-span-2">
                <!-- About Section -->
                <section class="mb-14 su-reveal">
                    <span class="su-section-eyebrow">// 01 — Briefing</span>
                    <h2 class="su-section-title">About This Course</h2>
                    <p class="su-body-copy whitespace-pre-line"><?php echo e($course->description); ?></p>
                </section>

                <!-- Learning Outcomes -->
                <section class="mb-14 su-reveal">
                    <span class="su-section-eyebrow">// 02 — Payload</span>
                    <h2 class="su-section-title">What You'll Learn</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="su-outcome">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Build Responsive Websites</h4>
                                <p>Create beautiful, mobile-first websites that work on all devices</p>
                            </div>
                        </div>
                        <div class="su-outcome">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Master Web Standards</h4>
                                <p>Learn HTML5, CSS3, and JavaScript best practices</p>
                            </div>
                        </div>
                        <div class="su-outcome">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Real-World Projects</h4>
                                <p>Build portfolio-ready projects used in production</p>
                            </div>
                        </div>
                        <div class="su-outcome">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <h4>Industry-Ready Skills</h4>
                                <p>Gain the skills top companies want in junior developers</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Course Topics -->
                <section id="course-topics" class="mb-12">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3 su-reveal">
                        <div>
                            <span class="su-section-eyebrow">// 03 — Modules</span>
                            <h2 class="su-section-title" style="margin-bottom:0.25rem;">Course Topics</h2>
                            <p class="su-body-copy" style="font-size:0.88rem;">Explore each module and its learning material.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="#course-curriculum" class="su-btn su-btn-solid su-magnetic"><i class="fas fa-book-open"></i>View all materials</a>
                            <?php if(auth()->check() && auth()->user()->hasStaffAccess()): ?>
                                <a href="<?php echo e(route('admin.modules.create', ['course_id' => $course->id])); ?>" class="su-btn su-btn-green su-magnetic"><i class="fas fa-plus"></i>Add Topic</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <?php $__empty_1 = true; $__currentLoopData = $course->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="su-module-card su-reveal">
                                <span class="su-module-index">MOD // <?php echo e(str_pad($loop->iteration, 2, '0', STR_PAD_LEFT)); ?></span>
                                <span class="su-module-corner-tl"></span>
                                <span class="su-module-corner-br"></span>
                                <div class="su-module-thumb">
                                    <?php
                                        $topicImage = null;
                                        if (!empty($course->image_url)) {
                                            $topicImage = asset($course->image_url);
                                        } else {
                                            $imageLesson = $module->lessons->first(function ($lesson) {
                                                return $lesson->content && preg_match('/\.(jpe?g|png|gif|webp)$/i', $lesson->content);
                                            });
                                            $topicImage = $imageLesson ? asset($imageLesson->content) : null;
                                        }
                                    ?>
                                    <?php if($topicImage): ?>
                                        <img src="<?php echo e($topicImage); ?>" alt="<?php echo e($module->title); ?> topic image">
                                    <?php else: ?>
                                        <div class="su-module-thumb-empty"><i class="fas fa-folder-open"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="su-module-body">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3><?php echo e($module->title); ?></h3>
                                        <span class="su-lesson-count"><?php echo e($module->lessons->count()); ?> lessons</span>
                                    </div>
                                    <p class="su-module-desc"><?php echo e(\Illuminate\Support\Str::limit($module->description ?? 'Learn the key concepts and examples for this topic.', 120)); ?></p>
                                    <div class="flex flex-wrap gap-3 items-center">
                                        <a href="<?php echo e(route('modules.show', [$course->slug, $module->slug])); ?>" class="su-btn su-btn-solid su-magnetic"><i class="fas fa-eye"></i>Open Topic</a>
                                        <?php if($module->quizzes->count() > 0): ?>
                                            <?php $quiz = $module->quizzes->first(); ?>
                                            <a href="<?php echo e(route('quizzes.start', [$course->slug, $module->slug, $quiz->slug])); ?>" class="su-btn su-btn-green su-magnetic"><i class="fas fa-clipboard-list"></i>Take Quiz</a>
                                        <?php endif; ?>
                                        <span class="su-resource-pill"><?php echo e($module->lessons->count()); ?> resources</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="su-empty-state" style="grid-column: 1 / -1;">
                                <i class="fas fa-book text-4xl mb-4"></i>
                                <p>No course topics found yet.</p>
                                <?php if(auth()->check() && auth()->user()->hasStaffAccess()): ?>
                                    <a href="<?php echo e(route('admin.modules.create', ['course_id' => $course->id])); ?>" class="su-btn su-btn-green mt-4 su-magnetic"><i class="fas fa-plus"></i>Add first topic</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>

            <!-- Right Column - Enrollment Card -->
            <div>
                <div class="su-side-card sticky top-24 su-reveal">
                    
                    <?php if(!empty($course->image_url)): ?>
                        <div class="su-side-thumb">
                            <img src="<?php echo e(asset($course->image_url)); ?>" alt="<?php echo e($course->title); ?> preview">
                        </div>
                    <?php else: ?>
                        <div class="su-side-thumb-empty"><i class="fas fa-image"></i></div>
                    <?php endif; ?>

                    
                    <?php if($isEnrolled): ?>
                        <div class="su-status-panel su-status-ok">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span class="font-semibold">You're enrolled</span>
                            </div>
                        </div>

                        <?php if($enrollment): ?>
                            <div class="su-status-panel su-status-info">
                                <div class="flex items-center justify-between text-sm font-semibold mb-1">
                                    <span>Course Progress</span>
                                    <span><?php echo e($enrollment->progress); ?>%</span>
                                </div>
                                <div class="su-progress-track">
                                    <div class="su-progress-fill su-progress-fill-anim" data-progress="<?php echo e($enrollment->progress); ?>"></div>
                                </div>
                            </div>

                            <?php if($enrollment->completed): ?>
                                <div class="su-status-panel su-status-gold">
                                    <div class="flex items-center gap-2 font-semibold mb-2">
                                        <i class="fas fa-certificate"></i>
                                        <span>Certificate Ready</span>
                                    </div>
                                    <p style="color: var(--c-muted);">
                                        Your certificate and course completion badge are unlocked automatically. Print your certificate or view it anytime.
                                    </p>
                                    <a href="<?php echo e(route('certificates.show', $course->slug)); ?>" class="su-btn su-btn-solid w-full justify-center mt-4 su-magnetic">
                                        <i class="fas fa-print"></i>View & Print Certificate
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="su-status-panel su-status-neutral">
                                    <p class="font-semibold">Earn your certificate</p>
                                    <p style="color: var(--c-muted); margin-top: 0.5rem;">Complete all published modules and passing quizzes to unlock your course certificate and completion badge automatically.</p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                    
                    <?php else: ?>
                        <div class="mb-2">
                            <button id="btn-enroll-open" type="button" aria-haspopup="dialog" aria-expanded="false" class="su-btn su-btn-solid w-full justify-center su-magnetic" style="padding-top:0.9rem; padding-bottom:0.9rem; font-size:0.95rem;">
                                <i class="fas fa-arrow-right"></i>Enroll Free
                            </button>
                        </div>

                        <!-- Enroll Confirmation Modal -->
                        <div id="enroll-modal" class="su-modal-overlay hidden items-center justify-center" role="dialog" aria-modal="true" aria-labelledby="enroll-modal-title">
                            <div class="su-modal-panel" role="document">
                                <h3 id="enroll-modal-title">Confirm enrollment</h3>
                                <p>You're about to enroll in <strong style="color: var(--c-text);"><?php echo e($course->title); ?></strong>.</p>
                                <ul class="su-modal-list">
                                    <li><strong>Modules:</strong> <?php echo e($course->modules->count()); ?></li>
                                    <li><strong>Estimated duration:</strong> <?php echo e($course->duration_hours); ?> hours</li>
                                </ul>
                                <div class="flex gap-3">
                                    <form id="enrollForm" action="<?php echo e(route('courses.enroll', $course->slug)); ?>" method="POST" class="flex-1" aria-labelledby="enroll-modal-title">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="su-btn su-btn-green w-full justify-center su-magnetic">
                                            <i class="fas fa-check"></i> Confirm Enroll
                                        </button>
                                    </form>
                                    <button id="enroll-cancel" type="button" class="su-btn-cancel" style="width: 10rem;">Cancel</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <div class="mt-2">
                        <div class="su-detail-row"><span>Duration</span><span class="val"><?php echo e($course->duration_hours); ?> hours</span></div>
                        <div class="su-detail-row"><span>Level</span><span class="val"><?php echo e($course->level); ?></span></div>
                        <div class="su-detail-row"><span>Lessons</span><span class="val"><?php echo e($course->lessons->count()); ?></span></div>
                        <div class="su-detail-row">
                            <span>Rating</span>
                            <span class="val"><i class="fas fa-star" style="color:#ffcf4d;"></i> <?php echo e(number_format($course->rating, 1)); ?>/5</span>
                        </div>
                    </div>

                    
                    <div class="mt-6 pt-6" style="border-top: 1px solid var(--c-glass-border);">
                        <h4 class="font-semibold mb-3" style="color: var(--c-text);">Share This Course</h4>
                        <div class="su-share-row">
                            <a href="#" class="su-share-btn su-share-fb"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="su-share-btn su-share-tw"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="su-share-btn su-share-li"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        /* ---- scroll reveal ---- */
        var els = document.querySelectorAll('.su-reveal');
        if (!('IntersectionObserver' in window) || !els.length) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
        } else {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
            els.forEach(function (el) { io.observe(el); });
        }

        var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* ---- ambient cursor glow (desktop only) ---- */
        var glow = document.getElementById('su-cursor-glow');
        var courseRoot = document.querySelector('.su-course');
        if (glow && courseRoot && !reduceMotion && window.matchMedia('(hover: hover)').matches) {
            courseRoot.addEventListener('mousemove', function (e) {
                glow.style.opacity = '1';
                glow.style.transform = 'translate(' + e.clientX + 'px,' + e.clientY + 'px) translate(-50%,-50%)';
            });
            courseRoot.addEventListener('mouseleave', function () { glow.style.opacity = '0'; });
        }

        /* ---- animated count-up stats ---- */
        var counters = document.querySelectorAll('.su-count-up');
        if (counters.length) {
            var counterIO = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    var el = entry.target;
                    var target = parseFloat(el.getAttribute('data-target')) || 0;
                    if (reduceMotion) { el.textContent = target; counterIO.unobserve(el); return; }
                    var start = 0;
                    var duration = 1100;
                    var startTime = null;
                    function step(ts) {
                        if (!startTime) startTime = ts;
                        var progress = Math.min((ts - startTime) / duration, 1);
                        var eased = 1 - Math.pow(1 - progress, 3);
                        el.textContent = Math.round(start + (target - start) * eased);
                        if (progress < 1) requestAnimationFrame(step);
                        else el.textContent = target;
                    }
                    requestAnimationFrame(step);
                    counterIO.unobserve(el);
                });
            }, { threshold: 0.4 });
            counters.forEach(function (c) { counterIO.observe(c); });
        }

        /* ---- animated progress bar fill ---- */
        var fill = document.querySelector('.su-progress-fill-anim');
        if (fill) {
            var pct = fill.getAttribute('data-progress') || '0';
            var fillIO = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        requestAnimationFrame(function () { fill.style.width = pct + '%'; });
                        fillIO.unobserve(fill);
                    }
                });
            }, { threshold: 0.3 });
            fillIO.observe(fill);
        }

        /* ---- magnetic buttons ---- */
        if (!reduceMotion && window.matchMedia('(hover: hover)').matches) {
            document.querySelectorAll('.su-magnetic').forEach(function (btn) {
                btn.addEventListener('mousemove', function (e) {
                    var r = btn.getBoundingClientRect();
                    var x = e.clientX - r.left - r.width / 2;
                    var y = e.clientY - r.top - r.height / 2;
                    btn.style.transform = 'translate(' + (x * 0.18) + 'px,' + (y * 0.28 - 2) + 'px)';
                });
                btn.addEventListener('mouseleave', function () { btn.style.transform = ''; });
            });
        }

        /* ---- button ripple on click ---- */
        document.querySelectorAll('.su-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                var r = btn.getBoundingClientRect();
                var ripple = document.createElement('span');
                var size = Math.max(r.width, r.height);
                ripple.className = 'su-ripple';
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (e.clientX - r.left - size / 2) + 'px';
                ripple.style.top = (e.clientY - r.top - size / 2) + 'px';
                btn.appendChild(ripple);
                setTimeout(function () { ripple.remove(); }, 650);
            });
        });
    })();
</script>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('btn-enroll-open');
    const modal = document.getElementById('enroll-modal');
    const cancel = document.getElementById('enroll-cancel');

    if (!openBtn || !modal) return;

    let previousActive = null;
    function openModal() {
        previousActive = document.activeElement;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(function () { modal.classList.add('su-modal-show'); });
        openBtn.setAttribute('aria-expanded','true');
        // focus the confirm button for accessibility
        setTimeout(() => modal.querySelector('button[type="submit"]')?.focus(), 20);
    }

    function closeModal() {
        modal.classList.remove('su-modal-show');
        openBtn.setAttribute('aria-expanded','false');
        if (previousActive && typeof previousActive.focus === 'function') previousActive.focus();
        setTimeout(function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 250);
    }

    openBtn.addEventListener('click', openModal);
    cancel?.addEventListener('click', closeModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && modal.classList.contains('su-modal-show')) closeModal(); });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/courses/show.blade.php ENDPATH**/ ?>