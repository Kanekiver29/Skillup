@extends('auth.layouts.master')

@section('title', 'Sign In — SkillUp')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ══════════════════════════════════════════════════════════════════
   TOKENS — inherits the SkillUp HUD system (navy / cyan / gold / red)
══════════════════════════════════════════════════════════════════ */
:root {
    --navy:        #003a8f;
    --navy-light:  #1a5fd4;
    --navy-dark:   #0a2540;
    --navy-deep:   #061828;
    --void:        #020509;
    --cyan:        #00e6ff;
    --cyan-dim:    rgba(0,230,255,.16);
    --gold:        #fdb913;
    --red:         #ff2f52;
    --red-dark:    #c1121f;
    --green:       #23e0a0;
    --ink:         #e7edf7;
    --muted:       #93a4bd;
    --faint:       #5b6c85;
    --glass:       rgba(9,17,34,.66);
    --glass-solid: rgba(8,16,32,.92);
    --hairline:    rgba(0,230,255,.16);
    --radius-lg:   22px;
    --radius-md:   13px;
    --ease:        cubic-bezier(.22,1,.36,1);
    --ease-elastic:cubic-bezier(.34,1.56,.64,1);
}

*, *::before, *::after { box-sizing: border-box; }

.auth-scope {
    font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
    color: var(--ink);
}
.auth-scope .font-display { font-family: 'Sora','Inter',system-ui,sans-serif; }
.auth-scope .font-mono    { font-family: 'JetBrains Mono', ui-monospace, monospace; }
.auth-scope a { text-decoration: none; color: inherit; }
.auth-scope button { cursor: pointer; font-family: inherit; }

/* ══════════════════════════════════════════════════════════════════
   PAGE SHELL + AMBIENT BACKGROUND
══════════════════════════════════════════════════════════════════ */
.auth-shell {
    position: relative;
    min-height: calc(100vh - 6.75rem);
    margin: -6.75rem 0 0;
    padding-top: 6.75rem;
    overflow: hidden;
    background:
        radial-gradient(ellipse 70% 55% at 18% 8%,  rgba(0,58,143,.55), transparent 55%),
        radial-gradient(ellipse 60% 50% at 88% 18%, rgba(0,230,255,.10), transparent 50%),
        radial-gradient(ellipse 55% 45% at 50% 100%,rgba(253,185,19,.08), transparent 45%),
        linear-gradient(160deg, #050c1c 0%, #030814 55%, #010306 100%);
}
@media (min-width: 1024px) {
    .auth-shell { margin-top: -7.25rem; padding-top: 7.25rem; }
}

.auth-hud-grid {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(0,230,255,.10) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,230,255,.10) 1px, transparent 1px);
    background-size: 42px 42px;
    -webkit-mask-image: radial-gradient(ellipse 80% 70% at 50% 30%, #000 10%, transparent 75%);
            mask-image: radial-gradient(ellipse 80% 70% at 50% 30%, #000 10%, transparent 75%);
    animation: gridDrift 34s linear infinite;
    pointer-events: none;
}
@keyframes gridDrift {
    from { background-position: 0 0, 0 0; }
    to   { background-position: 84px 0, 0 84px; }
}

.auth-blob { position: absolute; border-radius: 50%; filter: blur(90px); pointer-events: none; }
.auth-blob-1 { width: 480px; height: 480px; background: radial-gradient(circle, rgba(0,230,255,.28), transparent 70%); top: -140px; left: -120px; animation: blobDrift1 16s ease-in-out infinite; }
.auth-blob-2 { width: 440px; height: 440px; background: radial-gradient(circle, rgba(253,185,19,.20), transparent 70%); bottom: -160px; right: -100px; animation: blobDrift2 20s ease-in-out infinite; }
.auth-blob-3 { width: 320px; height: 320px; background: radial-gradient(circle, rgba(255,47,82,.16), transparent 70%); bottom: 10%; left: 42%; animation: blobDrift3 24s ease-in-out infinite; }
@keyframes blobDrift1 { 0%,100%{transform:translate(0,0) scale(1);} 33%{transform:translate(40px,-24px) scale(1.08);} 66%{transform:translate(-22px,26px) scale(.94);} }
@keyframes blobDrift2 { 0%,100%{transform:translate(0,0) scale(1);} 40%{transform:translate(-36px,22px) scale(1.1);} 70%{transform:translate(24px,-30px) scale(.92);} }
@keyframes blobDrift3 { 0%,100%{transform:translate(0,0) scale(1);} 50%{transform:translate(20px,-20px) scale(1.06);} }

.auth-scanline { position: absolute; left: 0; right: 0; top: 0; height: 1px; overflow: hidden; pointer-events: none; z-index: 3; }
.auth-scanline::before {
    content: ''; position: absolute; top: 0; bottom: 0; width: 34%;
    background: linear-gradient(90deg, transparent, rgba(0,230,255,.9), rgba(253,185,19,.55), transparent);
    animation: authScanSweep 6.5s linear infinite;
}
@keyframes authScanSweep { 0% { left: -34%; } 100% { left: 100%; } }

/* Drifting ambient particles across the whole shell */
.auth-particle-field { position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 1; }
.auth-drift-particle {
    position: absolute; border-radius: 50%;
    background: radial-gradient(circle, rgba(0,230,255,.9), rgba(0,230,255,0) 70%);
    opacity: 0;
    animation: authParticleRise var(--pdur,9s) linear infinite var(--pdel,0s);
}
@keyframes authParticleRise {
    0%   { opacity: 0; transform: translateY(0) scale(.6); }
    10%  { opacity: .8; }
    90%  { opacity: .3; }
    100% { opacity: 0; transform: translateY(-160px) scale(1.1); }
}

/* ══════════════════════════════════════════════════════════════════
   LAYOUT — split terminal: brand console (left) + login card (right)
══════════════════════════════════════════════════════════════════ */
.auth-layout {
    position: relative; z-index: 2;
    max-width: 1180px;
    margin: 0 auto;
    padding: 2.5rem 1.25rem 4rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 2.5rem;
    align-items: center;
    min-height: calc(100vh - 6.75rem);
}
@media (min-width: 1024px) {
    .auth-layout { grid-template-columns: 1.05fr .95fr; gap: 3rem; padding: 3rem 2rem 4rem; }
}

/* ── Left console panel ─────────────────────────────────────────── */
.auth-console {
    display: none;
    position: relative;
    padding: 2.75rem 2.5rem;
    border-radius: var(--radius-lg);
    border: 1px solid var(--hairline);
    background: linear-gradient(160deg, rgba(0,58,143,.16), rgba(2,5,9,.4));
    overflow: hidden;
    animation: consoleIn .7s var(--ease) both;
}
@media (min-width: 1024px) { .auth-console { display: block; } }
@keyframes consoleIn { from { opacity: 0; transform: translateX(-24px); } to { opacity: 1; transform: translateX(0); } }

.auth-console::before {
    content: '';
    position: absolute; inset: 0;
    background-image: linear-gradient(rgba(0,230,255,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(0,230,255,.06) 1px, transparent 1px);
    background-size: 28px 28px;
    -webkit-mask-image: linear-gradient(180deg, #000 0%, transparent 90%);
            mask-image: linear-gradient(180deg, #000 0%, transparent 90%);
    pointer-events: none;
}

.console-eyebrow {
    display: inline-flex; align-items: center; gap: .5rem;
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px; letter-spacing: .26em; text-transform: uppercase;
    color: var(--cyan); margin-bottom: 1.5rem;
}
.console-eyebrow .dot { width: 6px; height: 6px; border-radius: 50%; background: var(--cyan); box-shadow: 0 0 8px rgba(0,230,255,.9); animation: dotPulse 2.2s ease-in-out infinite; }
@keyframes dotPulse { 0%,100%{opacity:.4; transform:scale(1);} 50%{opacity:1; transform:scale(1.6);} }

.console-headline {
    font-family: 'Sora', sans-serif; font-weight: 800;
    font-size: clamp(1.9rem, 2.6vw, 2.5rem);
    line-height: 1.14; letter-spacing: -.01em; color: #fff;
    margin-bottom: 1rem;
}
.console-headline .accent {
    background: linear-gradient(90deg, var(--cyan), #7dd8ff 45%, var(--gold));
    -webkit-background-clip: text; background-clip: text; color: transparent;
}
.console-sub { font-size: .95rem; color: var(--muted); line-height: 1.65; max-width: 34rem; margin-bottom: 2.25rem; }

/* live stat readout */
.console-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 2.25rem; }
.console-stat { padding: 1rem .9rem; border-radius: var(--radius-md); border: 1px solid var(--hairline); background: rgba(2,8,18,.55); }
.console-stat-num { font-family: 'Sora',sans-serif; font-weight: 800; font-size: 1.5rem; color: #fff; text-shadow: 0 0 20px rgba(0,230,255,.3); }
.console-stat-label { font-family: 'JetBrains Mono',monospace; font-size: 9.5px; letter-spacing: .1em; text-transform: uppercase; color: var(--faint); margin-top: .2rem; }

/* status feed — mimics a boot / system log */
.console-feed { border-top: 1px solid var(--hairline); padding-top: 1.25rem; display: flex; flex-direction: column; gap: .65rem; }
.console-feed-row { display: flex; align-items: center; gap: .65rem; font-family: 'JetBrains Mono',monospace; font-size: 12px; color: var(--muted); opacity: 0; animation: feedIn .5s var(--ease) forwards; }
.console-feed-row .status-led { width: 7px; height: 7px; border-radius: 50%; background: var(--green); box-shadow: 0 0 7px rgba(35,224,160,.85); flex-shrink: 0; }
.console-feed-row:nth-child(1) { animation-delay: .5s; }
.console-feed-row:nth-child(2) { animation-delay: .68s; }
.console-feed-row:nth-child(3) { animation-delay: .86s; }
.console-feed-row:nth-child(4) { animation-delay: 1.04s; }
@keyframes feedIn { from { opacity: 0; transform: translateX(-8px);} to { opacity: 1; transform: translateX(0);} }

/* orbiting mark, bottom-right of console */
.console-orbit { position: absolute; right: -30px; bottom: -30px; width: 190px; height: 190px; opacity: .5; pointer-events: none; }
.console-orbit-ring { fill: none; stroke: var(--cyan); stroke-opacity: .35; stroke-dasharray: 2 10; animation: orbitSpin 22s linear infinite; transform-origin: 50% 50%; }
.console-orbit-ring.alt { stroke: var(--gold); stroke-opacity: .3; stroke-dasharray: 1 7; animation-duration: 32s; animation-direction: reverse; }
@keyframes orbitSpin { to { transform: rotate(360deg); } }

/* ── Right card ──────────────────────────────────────────────────── */
.auth-card-wrap { width: 100%; max-width: 440px; margin: 0 auto; animation: cardIn .6s var(--ease) both .1s; }
@keyframes cardIn { from { opacity: 0; transform: translateY(26px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }

.auth-card {
    position: relative;
    border-radius: var(--radius-lg);
    background: var(--glass);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--hairline);
    box-shadow: 0 30px 80px rgba(0,0,0,.55), 0 0 0 1px rgba(0,230,255,.04) inset;
    overflow: hidden;
}

/* animated conic border glow, revealed on focus-within */
.auth-card::after {
    content: '';
    position: absolute; inset: -1px; border-radius: inherit;
    padding: 1px;
    background: conic-gradient(from 0deg, var(--cyan), var(--gold) 30%, var(--red) 55%, var(--navy-light) 80%, var(--cyan) 100%);
    -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor; mask-composite: exclude;
    opacity: 0; transition: opacity .4s ease; animation: authRingSpin 5s linear infinite paused;
    pointer-events: none;
}
.auth-card:focus-within::after { opacity: .55; animation-play-state: running; }
@keyframes authRingSpin { to { transform: rotate(360deg); } }

/* corner brackets — HUD signature */
.auth-hud-corner { position: absolute; width: 16px; height: 16px; border: 1.5px solid rgba(0,230,255,.5); opacity: .8; z-index: 2; pointer-events: none; }
.auth-hud-corner.tl { top: 12px; left: 12px; border-right: none; border-bottom: none; }
.auth-hud-corner.tr { top: 12px; right: 12px; border-left: none; border-bottom: none; }
.auth-hud-corner.bl { bottom: 12px; left: 12px; border-right: none; border-top: none; }
.auth-hud-corner.br { bottom: 12px; right: 12px; border-left: none; border-top: none; }

/* ── Terminal top bar ────────────────────────────────────────────── */
.auth-topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: .85rem 1.25rem;
    border-bottom: 1px solid var(--hairline);
    background: rgba(2,8,18,.5);
    font-family: 'JetBrains Mono', monospace;
    font-size: 10.5px; letter-spacing: .14em; text-transform: uppercase; color: var(--faint);
}
.auth-topbar-dots { display: flex; gap: 6px; }
.auth-topbar-dots span { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
.auth-topbar-dots span:nth-child(1) { background: var(--red); }
.auth-topbar-dots span:nth-child(2) { background: var(--gold); }
.auth-topbar-dots span:nth-child(3) { background: var(--green); }
.auth-topbar-label { display: flex; align-items: center; gap: .4rem; color: var(--cyan); }
.auth-topbar-label .blink { animation: blinkCursor 1.1s step-end infinite; }
@keyframes blinkCursor { 0%,49% { opacity: 1; } 50%,100% { opacity: 0; } }

/* ── Header (logo + heading) ────────────────────────────────────── */
.auth-header { padding: 2rem 2rem .5rem; text-align: center; position: relative; }

.auth-logo-ring {
    position: relative;
    width: 74px; height: 74px; margin: 0 auto 1.1rem;
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, rgba(0,230,255,.14), rgba(0,58,143,.22));
    border: 1px solid rgba(0,230,255,.3);
    box-shadow: 0 10px 30px rgba(0,58,143,.35);
    animation: logoIn .6s .15s var(--ease-elastic) both;
}
@keyframes logoIn { from { opacity: 0; transform: scale(.6) rotate(-10deg); } to { opacity: 1; transform: scale(1) rotate(0); } }
.auth-logo-ring img { width: 46px; height: 46px; object-fit: contain; position: relative; z-index: 2; filter: drop-shadow(0 2px 6px rgba(0,0,0,.4)); }
.auth-logo-spin-ring {
    position: absolute; inset: -8px; border-radius: 50%;
    border: 1.5px solid transparent;
    background: conic-gradient(from 0deg, rgba(0,230,255,.9), rgba(253,185,19,.5) 35%, transparent 60%, rgba(0,230,255,.9) 100%) border-box;
    -webkit-mask: linear-gradient(#000 0 0) padding-box, linear-gradient(#000 0 0);
    -webkit-mask-composite: xor; mask-composite: exclude;
    animation: authRingSpin 4.5s linear infinite;
}

.auth-header h1 {
    font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1.5rem;
    color: #fff; letter-spacing: -.02em;
    animation: fieldIn .45s .3s var(--ease) both;
}
.auth-header p { font-size: 13px; color: var(--muted); margin-top: .35rem; animation: fieldIn .45s .36s var(--ease) both; }

/* ── Body ────────────────────────────────────────────────────────── */
.auth-body { padding: 1.5rem 2rem 0; position: relative; }

@keyframes fieldIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
[data-auth-animate] { opacity: 0; animation: fieldIn .4s var(--ease) forwards; }

/* ── Alerts ──────────────────────────────────────────────────────── */
.auth-alert { display: flex; align-items: flex-start; gap: .6rem; padding: .75rem .9rem; border-radius: 11px; font-size: 13px; font-weight: 500; margin-bottom: 1.1rem; line-height: 1.45; border: 1px solid; }
.auth-alert--success { background: rgba(35,224,160,.1); color: #6ff5cd; border-color: rgba(35,224,160,.3); }
.auth-alert--error   { background: rgba(255,47,82,.1);  color: #ff9caa; border-color: rgba(255,47,82,.32); }

/* ── Role selector — sliding segmented control ──────────────────── */
.role-select-label { font-family: 'JetBrains Mono',monospace; font-size: 10.5px; letter-spacing: .2em; text-transform: uppercase; color: var(--faint); margin-bottom: .6rem; display: block; }
.role-select {
    position: relative;
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 4px; padding: 4px;
    border-radius: 13px;
    border: 1px solid var(--hairline);
    background: rgba(2,8,18,.55);
}
.role-select-indicator {
    position: absolute; top: 4px; left: 4px;
    height: calc(100% - 8px);
    border-radius: 9px;
    background: linear-gradient(135deg, var(--navy-light), var(--navy));
    box-shadow: 0 4px 16px rgba(0,58,143,.45), 0 0 0 1px rgba(0,230,255,.35) inset;
    transition: transform .32s var(--ease), width .32s var(--ease);
    z-index: 0;
}
.auth-role-btn {
    position: relative; z-index: 1;
    display: flex; flex-direction: column; align-items: center; gap: .3rem;
    padding: .55rem .3rem;
    border: 0; background: transparent;
    color: var(--muted); font-size: 10.5px; font-weight: 600; letter-spacing: .02em;
    border-radius: 9px;
    transition: color .25s ease;
}
.auth-role-btn i { font-size: 13px; opacity: .75; transition: opacity .25s ease; }
.auth-role-btn:hover { color: #cfe4ff; }
.auth-role-btn.is-active { color: #fff; }
.auth-role-btn.is-active i { opacity: 1; }

/* ── Fields ──────────────────────────────────────────────────────── */
.auth-field { margin-bottom: 1.15rem; }
.auth-field label {
    display: flex; align-items: center; gap: .4rem;
    font-family: 'JetBrains Mono', monospace;
    font-size: 10.5px; font-weight: 600; letter-spacing: .16em; text-transform: uppercase;
    color: var(--faint); margin-bottom: .55rem;
}
.auth-field label i { color: var(--cyan); font-size: 11px; }

.auth-input-wrap { position: relative; }
.auth-input {
    width: 100%;
    padding: .8rem .95rem;
    border: 1.5px solid var(--hairline);
    border-radius: var(--radius-md);
    font-size: 14px; font-family: 'Inter', sans-serif;
    color: #fff;
    background: rgba(2,8,18,.55);
    outline: none;
    transition: border-color .22s ease, box-shadow .22s ease, background .22s ease;
}
.auth-input::placeholder { color: #4a5c76; }
.auth-input:focus { border-color: var(--cyan); background: rgba(2,10,22,.85); box-shadow: 0 0 0 3px rgba(0,230,255,.12), 0 0 18px rgba(0,230,255,.08); }
.auth-input.is-error { border-color: var(--red); box-shadow: 0 0 0 3px rgba(255,47,82,.12); }
.auth-input.is-valid { border-color: rgba(35,224,160,.55); }

.auth-input-wrap .auth-input { padding-right: 2.6rem; }
.auth-input-status {
    position: absolute; right: .85rem; top: 50%; transform: translateY(-50%);
    font-size: 13px; pointer-events: none; opacity: 0; transition: opacity .2s ease, color .2s ease;
}
.auth-input-status.show { opacity: 1; }
.auth-input-status.ok  { color: var(--green); }
.auth-input-status.bad { color: var(--red); }

.auth-pw-toggle {
    position: absolute; right: .7rem; top: 50%; transform: translateY(-50%);
    background: none; border: 0; color: var(--faint); font-size: 14px; padding: 4px;
    transition: color .22s ease, transform .22s ease;
}
.auth-pw-toggle:hover { color: var(--cyan); }
.auth-pw-toggle:active { transform: translateY(-50%) scale(.9); }

.auth-error { display: flex; align-items: center; gap: .35rem; font-size: 11.5px; color: #ff9caa; margin-top: .4rem; font-weight: 500; }
.auth-hint  { display: flex; align-items: center; gap: .35rem; font-size: 11.5px; color: var(--gold); margin-top: .4rem; font-weight: 500; opacity: 0; max-height: 0; overflow: hidden; transition: opacity .2s ease, max-height .25s ease, margin .2s ease; }
.auth-hint.show { opacity: 1; max-height: 2rem; margin-top: .4rem; }

/* ── Remember toggle (custom switch, functional) ────────────────── */
.auth-remember-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.4rem; }
.auth-remember-label { display: flex; align-items: center; gap: .55rem; font-size: 12.5px; color: var(--muted); cursor: pointer; user-select: none; }
.auth-switch { position: relative; width: 38px; height: 21px; flex-shrink: 0; }
.auth-switch input { position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; z-index: 2; }
.auth-switch-track {
    position: absolute; inset: 0; border-radius: 999px;
    background: rgba(255,255,255,.08); border: 1px solid var(--hairline);
    transition: background .25s ease, border-color .25s ease;
}
.auth-switch-thumb {
    position: absolute; top: 2px; left: 2px; width: 15px; height: 15px; border-radius: 50%;
    background: var(--muted);
    transition: transform .28s var(--ease-elastic), background .25s ease;
}
.auth-switch input:checked ~ .auth-switch-track { background: rgba(0,230,255,.18); border-color: rgba(0,230,255,.5); }
.auth-switch input:checked ~ .auth-switch-thumb { transform: translateX(17px); background: var(--cyan); box-shadow: 0 0 8px rgba(0,230,255,.8); }
.auth-switch input:focus-visible ~ .auth-switch-track { outline: 2px solid var(--cyan); outline-offset: 2px; }

/* ── Submit button ───────────────────────────────────────────────── */
.auth-btn-primary {
    position: relative; overflow: hidden;
    width: 100%; padding: .9rem; border: 0; border-radius: var(--radius-md);
    font-size: 14px; font-weight: 700; color: #04121f;
    background: linear-gradient(110deg, var(--cyan) 0%, #7dd8ff 45%, var(--gold) 100%);
    background-size: 220% auto;
    box-shadow: 0 10px 28px rgba(0,230,255,.25);
    transition: transform .22s var(--ease), box-shadow .22s var(--ease), background-position .5s ease;
}
.auth-btn-primary:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 14px 34px rgba(0,230,255,.35); background-position: right center; }
.auth-btn-primary:active:not(:disabled) { transform: translateY(0) scale(.98); }
.auth-btn-primary:disabled { opacity: .8; cursor: progress; }
.auth-btn-primary:focus-visible { outline: 3px solid rgba(0,230,255,.5); outline-offset: 2px; }
.auth-btn-label, .auth-btn-loading { display: flex; align-items: center; justify-content: center; gap: .5rem; }
.auth-hidden { display: none !important; }
.auth-btn-ripple { position: absolute; border-radius: 50%; transform: scale(0); background: rgba(4,18,31,.28); pointer-events: none; animation: authRipple .6s ease-out forwards; }
@keyframes authRipple { to { transform: scale(2.6); opacity: 0; } }

/* ── Divider / secondary actions ─────────────────────────────────── */
.auth-divider { display: flex; align-items: center; gap: .8rem; margin: 1.5rem 0 1.1rem; color: var(--faint); font-size: 11px; font-family: 'JetBrains Mono',monospace; letter-spacing: .1em; text-transform: uppercase; }
.auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: var(--hairline); }

.auth-btn-outline {
    display: flex; align-items: center; justify-content: center; gap: .55rem;
    width: 100%; padding: .85rem; border-radius: var(--radius-md);
    border: 1.5px solid var(--hairline);
    font-size: 14px; font-weight: 600; color: #cfe4ff;
    background: rgba(2,8,18,.4);
    transition: border-color .22s ease, background .22s ease, transform .22s ease, box-shadow .22s ease;
}
.auth-btn-outline:hover { border-color: rgba(0,230,255,.55); background: rgba(0,230,255,.08); transform: translateY(-2px); box-shadow: 0 10px 26px rgba(0,0,0,.3); }
.auth-btn-outline:active { transform: translateY(0) scale(.98); }

/* ── Trust chips ─────────────────────────────────────────────────── */
.auth-trust { display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: .6rem; margin: 1.5rem 0 0; padding: 1.1rem 0; border-top: 1px solid var(--hairline); }
.auth-trust span { display: inline-flex; align-items: center; gap: .4rem; font-size: 10.5px; letter-spacing: .04em; color: var(--faint); font-weight: 600; padding: .35rem .65rem; border-radius: 999px; border: 1px solid var(--hairline); background: rgba(2,8,18,.4); }
.auth-trust i { color: var(--cyan); font-size: 10px; }

/* ── Footer bar ──────────────────────────────────────────────────── */
.auth-footer-bar { padding: 1rem 2rem; background: rgba(2,8,18,.6); border-top: 1px solid var(--hairline); font-size: 11px; color: var(--faint); text-align: center; line-height: 1.6; }
.auth-footer-bar a { color: var(--cyan); font-weight: 600; transition: color .2s ease; }
.auth-footer-bar a:hover { color: #fff; }

/* ── Back link ───────────────────────────────────────────────────── */
.auth-back { display: inline-flex; align-items: center; gap: .5rem; font-size: 13px; font-weight: 600; color: var(--muted); margin-top: 1.3rem; padding: .5rem .9rem; border-radius: 999px; transition: background .2s ease, color .2s ease, transform .2s ease; }
.auth-back:hover { background: rgba(0,230,255,.08); color: #fff; transform: translateX(-2px); }

.auth-forgot { display: block; text-align: center; margin-top: 1rem; font-size: 12.5px; font-weight: 600; color: var(--gold); transition: color .2s ease; }
.auth-forgot:hover { color: #ffd166; }

/* ── Progress sweep shown while submitting ──────────────────────── */
.auth-submit-sweep { position: absolute; left: 0; top: 0; height: 2px; width: 0%; background: linear-gradient(90deg, var(--cyan), var(--gold)); box-shadow: 0 0 10px rgba(0,230,255,.8); transition: width 1.1s ease; z-index: 5; }

/* ── Responsive ──────────────────────────────────────────────────── */
@media (max-width: 480px) {
    .auth-header { padding: 1.6rem 1.3rem .4rem; }
    .auth-body   { padding: 1.2rem 1.3rem 0; }
    .auth-footer-bar { padding: .9rem 1.3rem; }
    .role-select { grid-template-columns: repeat(2,1fr); grid-auto-rows: 1fr; }
    .role-select-indicator { display: none; }
    .auth-role-btn.is-active { background: linear-gradient(135deg, var(--navy-light), var(--navy)); box-shadow: 0 4px 16px rgba(0,58,143,.45); }
}

/* ── Reduced motion ──────────────────────────────────────────────── */
@media (prefers-reduced-motion: reduce) {
    .auth-shell *, .auth-shell *::before, .auth-shell *::after {
        animation-duration: .01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: .01ms !important;
    }
    [data-auth-animate] { opacity: 1 !important; }
}
</style>
@endpush

@section('auth-content')
<div class="auth-scope auth-shell">

    {{-- ambient background layers --}}
    <div class="auth-hud-grid" aria-hidden="true"></div>
    <div class="auth-blob auth-blob-1" aria-hidden="true"></div>
    <div class="auth-blob auth-blob-2" aria-hidden="true"></div>
    <div class="auth-blob auth-blob-3" aria-hidden="true"></div>
    <div class="auth-scanline" aria-hidden="true"></div>
    <div class="auth-particle-field" id="authParticleField" aria-hidden="true"></div>

    <div class="auth-layout">

        {{-- ══ LEFT — brand console ══ --}}
        <aside class="auth-console">
            <span class="console-eyebrow"><span class="dot"></span>SkillUp // Access Console</span>

            <h2 class="console-headline">Your next skill starts<br><span class="accent">with one sign-in.</span></h2>
            <p class="console-sub">Personalized learning paths, live mentor support, and TESDA-aligned credentials — all waiting on the other side of this terminal.</p>

            <div class="console-stats">
                <div class="console-stat">
                    <div class="console-stat-num" data-console-counter data-target="120">0</div>
                    <div class="console-stat-label">Courses</div>
                </div>
                <div class="console-stat">
                    <div class="console-stat-num" data-console-counter data-target="35000">0</div>
                    <div class="console-stat-label">Learners</div>
                </div>
                <div class="console-stat">
                    <div class="console-stat-num" data-console-counter data-target="98">0</div>
                    <div class="console-stat-label">% Satisfied</div>
                </div>
            </div>

            <div class="console-feed font-mono">
                <div class="console-feed-row"><span class="status-led"></span>tesda_curriculum ..... synced</div>
                <div class="console-feed-row"><span class="status-led"></span>mentor_network ....... online</div>
                <div class="console-feed-row"><span class="status-led"></span>credential_engine ..... ready</div>
                <div class="console-feed-row"><span class="status-led"></span>auth_gateway .......... secure</div>
            </div>

            <svg class="console-orbit" viewBox="0 0 190 190" aria-hidden="true">
                <circle class="console-orbit-ring" cx="95" cy="95" r="78" stroke-width="1.5"/>
                <circle class="console-orbit-ring alt" cx="95" cy="95" r="58" stroke-width="1.5"/>
            </svg>
        </aside>

        {{-- ══ RIGHT — login card ══ --}}
        <div class="auth-card-wrap">
            <div class="auth-card" id="authCard">

                <span class="auth-hud-corner tl"></span>
                <span class="auth-hud-corner tr"></span>
                <span class="auth-hud-corner bl"></span>
                <span class="auth-hud-corner br"></span>

                <div class="auth-submit-sweep" id="authSubmitSweep"></div>

                {{-- top status bar --}}
                <div class="auth-topbar">
                    <span class="auth-topbar-dots"><span></span><span></span><span></span></span>
                    <span class="auth-topbar-label">SKILLUP // AUTH.SYS<span class="blink">_</span></span>
                </div>

                {{-- header --}}
                <header class="auth-header">
                    <div class="auth-logo-ring">
                        <span class="auth-logo-spin-ring" aria-hidden="true"></span>
                        <img src="{{ asset('image/logo_oif_skillup_1_-removebg-preview.png') }}" alt="SkillUp logo">
                    </div>
                    <h1>Welcome back</h1>
                    <p>Sign in to continue your learning journey</p>
                </header>

                {{-- body --}}
                <div class="auth-body">

                    @if (session('success'))
                        <div class="auth-alert auth-alert--success" role="status" data-auth-animate>
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any() && !$errors->has('email') && !$errors->has('password') && !$errors->has('login_as'))
                        <div class="auth-alert auth-alert--error" role="alert" data-auth-animate>
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Please check your details and try again.</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                        @csrf

                        {{-- Role selector --}}
                        <div class="auth-field" data-auth-animate>
                            <span class="role-select-label">Sign in as</span>
                            <div class="role-select" id="roleSelect" role="group" aria-label="Account type">
                                <span class="role-select-indicator" id="roleIndicator" aria-hidden="true"></span>
                                <button type="button" data-role="admin"
                                    class="auth-role-btn {{ old('login_as', 'student') === 'admin' ? 'is-active' : '' }}"
                                    aria-pressed="{{ old('login_as', 'student') === 'admin' ? 'true' : 'false' }}">
                                    <i class="fas fa-shield-alt"></i>Admin
                                </button>
                                <button type="button" data-role="staff"
                                    class="auth-role-btn {{ old('login_as', 'student') === 'staff' ? 'is-active' : '' }}"
                                    aria-pressed="{{ old('login_as', 'student') === 'staff' ? 'true' : 'false' }}">
                                    <i class="fas fa-user-shield"></i>Staff
                                </button>
                                <button type="button" data-role="teacher"
                                    class="auth-role-btn {{ old('login_as', 'student') === 'teacher' ? 'is-active' : '' }}"
                                    aria-pressed="{{ old('login_as', 'student') === 'teacher' ? 'true' : 'false' }}">
                                    <i class="fas fa-chalkboard-teacher"></i>Instructor
                                </button>
                                <button type="button" data-role="student"
                                    class="auth-role-btn {{ old('login_as', 'student') === 'student' ? 'is-active' : '' }}"
                                    aria-pressed="{{ old('login_as', 'student') === 'student' ? 'true' : 'false' }}">
                                    <i class="fas fa-graduation-cap"></i>Student
                                </button>
                            </div>
                            <input type="hidden" name="login_as" id="login-as" value="{{ old('login_as', 'student') }}">
                            @error('login_as')
                                <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="auth-field" data-auth-animate>
                            <label for="email"><i class="fas fa-envelope"></i>Email address</label>
                            <div class="auth-input-wrap">
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="auth-input {{ $errors->has('email') ? 'is-error' : '' }}"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    required
                                >
                                <i class="fas auth-input-status" id="emailStatus"></i>
                            </div>
                            @error('email')
                                <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="auth-field" data-auth-animate>
                            <label for="password"><i class="fas fa-lock"></i>Password</label>
                            <div class="auth-input-wrap">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="auth-input {{ $errors->has('password') ? 'is-error' : '' }}"
                                    placeholder="••••••••"
                                    autocomplete="current-password"
                                    required
                                >
                                <button type="button" class="auth-pw-toggle" id="pwToggle" aria-label="Show password" aria-controls="password">
                                    <i class="fas fa-eye" id="pwToggleIcon"></i>
                                </button>
                            </div>
                            <p class="auth-hint" id="capsLockHint"><i class="fas fa-arrow-turn-up"></i>Caps Lock is on</p>
                            @error('password')
                                <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember + forgot --}}
                        <div class="auth-remember-row" data-auth-animate>
                            <label class="auth-remember-label" for="remember">
                                <span class="auth-switch">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="auth-switch-track"></span>
                                    <span class="auth-switch-thumb"></span>
                                </span>
                                Keep me signed in
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-forgot" style="margin:0;">Forgot?</a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <div data-auth-animate>
                            <button type="submit" class="auth-btn-primary" id="submitBtn">
                                <span class="auth-btn-label" id="btnLabel">
                                    <i class="fas fa-arrow-right-to-bracket"></i> Sign in
                                </span>
                                <span class="auth-btn-loading auth-hidden" id="btnLoading">
                                    <i class="fas fa-circle-notch fa-spin"></i> Authenticating…
                                </span>
                            </button>
                        </div>

                    </form>

                    {{-- Divider & register --}}
                    <div class="auth-divider" data-auth-animate><span>New to SkillUp?</span></div>

                    <a href="{{ route('register') }}" class="auth-btn-outline" data-auth-animate>
                        <i class="fas fa-user-plus"></i> Create an account
                    </a>

                    {{-- Trust chips --}}
                    <div class="auth-trust" data-auth-animate>
                        <span><i class="fas fa-lock"></i>Encrypted login</span>
                        <span><i class="fas fa-user-shield"></i>Role-based access</span>
                        <span><i class="fas fa-bolt"></i>Instant session</span>
                    </div>

                </div>{{-- end .auth-body --}}

                {{-- Footer bar --}}
                <div class="auth-footer-bar">
                    By signing in you agree to our
                    <a href="{{ route('terms') }}">Terms</a> and
                    <a href="{{ route('privacy') }}">Privacy Policy</a>.
                </div>

            </div>{{-- end .auth-card --}}

            <p style="text-align:center">
                <a href="{{ url('/') }}" class="auth-back">
                    <i class="fas fa-arrow-left"></i> Back to home
                </a>
            </p>
        </div>{{-- end .auth-card-wrap --}}

    </div>{{-- end .auth-layout --}}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ══════════════════════════════════════
       STAGGER FIELD ANIMATIONS
    ══════════════════════════════════════ */
    document.querySelectorAll('[data-auth-animate]').forEach(function (el, i) {
        el.style.animationDelay = (0.42 + i * 0.07) + 's';
    });

    /* ══════════════════════════════════════
       AMBIENT DRIFTING PARTICLES
    ══════════════════════════════════════ */
    (function spawnAuthParticles() {
        var field = document.getElementById('authParticleField');
        if (!field || reducedMotion) return;
        var count = window.innerWidth < 768 ? 10 : 22;
        for (var i = 0; i < count; i++) {
            var p = document.createElement('span');
            var size = 1.5 + Math.random() * 2.5;
            p.className = 'auth-drift-particle';
            p.style.cssText = [
                'width:' + size + 'px',
                'height:' + size + 'px',
                'left:' + (Math.random() * 100) + '%',
                'top:' + (30 + Math.random() * 65) + '%',
                '--pdur:' + (7 + Math.random() * 9).toFixed(2) + 's',
                '--pdel:' + (Math.random() * 8).toFixed(2) + 's'
            ].join(';');
            field.appendChild(p);
        }
    })();

    /* ══════════════════════════════════════
       CONSOLE STAT COUNTERS (left panel)
    ══════════════════════════════════════ */
    (function animateConsoleCounters() {
        var counters = document.querySelectorAll('[data-console-counter]');
        if (!counters.length) return;

        function run(el) {
            var target = parseInt(el.dataset.target, 10) || 0;
            if (reducedMotion) { el.textContent = target.toLocaleString(); return; }
            var duration = 1300, start = performance.now();
            function tick(now) {
                var progress = Math.min((now - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(target * eased).toLocaleString();
                if (progress < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        }
        counters.forEach(function (el) {
            setTimeout(function () { run(el); }, 500);
        });
    })();

    /* ══════════════════════════════════════
       ROLE SELECTOR — sliding indicator
    ══════════════════════════════════════ */
    var loginAsInput = document.getElementById('login-as');
    var roleSelect   = document.getElementById('roleSelect');
    var roleIndicator= document.getElementById('roleIndicator');
    var roleButtons  = document.querySelectorAll('.auth-role-btn[data-role]');

    function moveIndicatorTo(btn) {
        if (!roleIndicator || !roleSelect || !btn) return;
        var wrapRect = roleSelect.getBoundingClientRect();
        var btnRect  = btn.getBoundingClientRect();
        var x = btnRect.left - wrapRect.left - 4; // account for padding
        roleIndicator.style.width = btnRect.width + 'px';
        roleIndicator.style.transform = 'translateX(' + x + 'px)';
    }

    function setActiveRole(role, opts) {
        opts = opts || {};
        if (!loginAsInput) return;
        loginAsInput.value = role;
        var activeBtn = null;
        roleButtons.forEach(function (btn) {
            var active = btn.dataset.role === role;
            btn.classList.toggle('is-active', active);
            btn.setAttribute('aria-pressed', String(active));
            if (active) activeBtn = btn;
        });
        moveIndicatorTo(activeBtn);
        if (opts.announce && window.SkillUpToast) {
            var labels = { admin: 'Admin', staff: 'Staff', teacher: 'Instructor', student: 'Student' };
            window.SkillUpToast.show('Signing in as ' + (labels[role] || role), 'info', 2200);
        }
    }

    if (loginAsInput) {
        // wait a tick so layout/fonts settle before measuring positions
        window.requestAnimationFrame(function () {
            setActiveRole(loginAsInput.value || 'student');
        });
    }

    roleButtons.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            setActiveRole(this.dataset.role, { announce: true });
        });
    });

    window.addEventListener('resize', function () {
        var current = roleSelect ? roleSelect.querySelector('.auth-role-btn.is-active') : null;
        moveIndicatorTo(current);
    });

    /* ══════════════════════════════════════
       PASSWORD VISIBILITY TOGGLE
    ══════════════════════════════════════ */
    var pwInput  = document.getElementById('password');
    var pwToggle = document.getElementById('pwToggle');
    var pwIcon   = document.getElementById('pwToggleIcon');

    if (pwToggle && pwInput && pwIcon) {
        pwToggle.addEventListener('click', function () {
            var isHidden = pwInput.type === 'password';
            pwInput.type = isHidden ? 'text' : 'password';
            pwIcon.classList.toggle('fa-eye', !isHidden);
            pwIcon.classList.toggle('fa-eye-slash', isHidden);
            pwToggle.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        });
    }

    /* ══════════════════════════════════════
       CAPS LOCK DETECTION
    ══════════════════════════════════════ */
    var capsHint = document.getElementById('capsLockHint');
    if (pwInput && capsHint) {
        var checkCaps = function (e) {
            if (typeof e.getModifierState !== 'function') return;
            var isCaps = e.getModifierState('CapsLock');
            capsHint.classList.toggle('show', isCaps);
        };
        pwInput.addEventListener('keyup', checkCaps);
        pwInput.addEventListener('keydown', checkCaps);
        pwInput.addEventListener('blur', function () { capsHint.classList.remove('show'); });
    }

    /* ══════════════════════════════════════
       LIVE EMAIL FORMAT INDICATOR
    ══════════════════════════════════════ */
    var emailInput  = document.getElementById('email');
    var emailStatus = document.getElementById('emailStatus');
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function updateEmailStatus() {
        if (!emailInput || !emailStatus) return;
        var val = emailInput.value.trim();
        emailStatus.classList.remove('show', 'ok', 'bad');
        emailInput.classList.remove('is-valid');
        if (!val) return;
        if (emailPattern.test(val)) {
            emailStatus.classList.add('show', 'ok', 'fa-check-circle');
            emailStatus.classList.remove('fa-triangle-exclamation');
            emailInput.classList.add('is-valid');
        } else {
            emailStatus.classList.add('show', 'bad', 'fa-triangle-exclamation');
            emailStatus.classList.remove('fa-check-circle');
        }
    }
    if (emailInput) {
        emailInput.addEventListener('input', updateEmailStatus);
        emailInput.addEventListener('blur', updateEmailStatus);
        if (emailInput.value) updateEmailStatus();
    }

    /* ══════════════════════════════════════
       CLEAR SERVER ERROR STATE ON INPUT
    ══════════════════════════════════════ */
    document.querySelectorAll('.auth-input').forEach(function (input) {
        input.addEventListener('input', function () {
            this.classList.remove('is-error');
        });
    });

    /* ══════════════════════════════════════
       SUBMIT — loading state + progress sweep
    ══════════════════════════════════════ */
    var form        = document.getElementById('loginForm');
    var btnLabel    = document.getElementById('btnLabel');
    var btnLoading  = document.getElementById('btnLoading');
    var submitBtn   = document.getElementById('submitBtn');
    var submitSweep = document.getElementById('authSubmitSweep');

    if (form && btnLabel && btnLoading && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            btnLabel.classList.add('auth-hidden');
            btnLoading.classList.remove('auth-hidden');
            if (submitSweep) {
                requestAnimationFrame(function () { submitSweep.style.width = '100%'; });
            }
        });
    }

    /* Ripple on primary + outline buttons */
    document.querySelectorAll('.auth-btn-primary, .auth-btn-outline').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (reducedMotion) return;
            var rect = this.getBoundingClientRect();
            var circle = document.createElement('span');
            var size = Math.max(rect.width, rect.height);
            circle.className = 'auth-btn-ripple';
            circle.style.width = circle.style.height = size + 'px';
            circle.style.left = (e.clientX - rect.left - size / 2) + 'px';
            circle.style.top  = (e.clientY - rect.top  - size / 2) + 'px';
            this.style.position = this.style.position || 'relative';
            this.appendChild(circle);
            setTimeout(function () { circle.remove(); }, 650);
        });
    });

});
</script>
@endpush