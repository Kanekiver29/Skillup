

<?php $__env->startSection('title', 'Register - SkillUp'); ?>

<?php $__env->startPush('head'); ?>
<style>
/* ── Reset & Base ─────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.sr-only {
    position: absolute; width: 1px; height: 1px;
    padding: 0; margin: -1px; overflow: hidden;
    clip: rect(0,0,0,0); white-space: nowrap; border: 0;
}

/* ── Page Shell ──────────────────────────────────────── */
.rg-page {
    min-height: 100vh;
    background: #060c1a;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    position: relative;
    overflow: hidden;
    font-family: 'Inter', system-ui, sans-serif;
}

/* ── Animated Background ─────────────────────────────── */
.rg-canvas {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 0;
}

.rg-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(99,102,241,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(99,102,241,0.06) 1px, transparent 1px);
    background-size: 48px 48px;
    animation: rg-grid-drift 20s linear infinite;
}

@keyframes rg-grid-drift {
    0%   { background-position: 0 0; }
    100% { background-position: 48px 48px; }
}

.rg-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(72px);
    will-change: transform;
}

.rg-orb-1 {
    width: 520px; height: 520px;
    background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
    top: -10%; left: -10%;
    animation: rg-orb-a 18s ease-in-out infinite alternate;
}
.rg-orb-2 {
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(14,165,233,0.18) 0%, transparent 70%);
    bottom: -5%; right: -8%;
    animation: rg-orb-b 22s ease-in-out infinite alternate;
}
.rg-orb-3 {
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(168,85,247,0.15) 0%, transparent 70%);
    top: 50%; left: 55%;
    animation: rg-orb-c 16s ease-in-out infinite alternate;
}

@keyframes rg-orb-a {
    from { transform: translate(0, 0) scale(1); }
    to   { transform: translate(60px, 80px) scale(1.15); }
}
@keyframes rg-orb-b {
    from { transform: translate(0, 0) scale(1); }
    to   { transform: translate(-50px, -60px) scale(1.2); }
}
@keyframes rg-orb-c {
    from { transform: translate(0, 0) scale(1); }
    to   { transform: translate(30px, -40px) scale(0.9); }
}

/* Floating particles */
.rg-particles {
    position: absolute;
    inset: 0;
}
.rg-dot {
    position: absolute;
    width: 3px; height: 3px;
    border-radius: 50%;
    background: rgba(99,102,241,0.6);
    animation: rg-float var(--dur, 8s) var(--delay, 0s) ease-in-out infinite alternate;
}
@keyframes rg-float {
    from { transform: translateY(0) translateX(0); opacity: 0.3; }
    to   { transform: translateY(var(--ty,-20px)) translateX(var(--tx,10px)); opacity: 0.9; }
}

/* ── Card Wrap ───────────────────────────────────────── */
.rg-wrap {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 560px;
    animation: rg-wrap-in 0.7s cubic-bezier(0.16,1,0.3,1) both;
    perspective: 1200px;
}

@keyframes rg-wrap-in {
    from { opacity: 0; transform: translateY(28px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* ── Animated Gradient Frame ─────────────────────────── */
.rg-frame {
    position: relative;
    padding: 1.5px;
    border-radius: 26px;
    overflow: hidden;
    isolation: isolate;
}
.rg-frame::before {
    content: '';
    position: absolute;
    inset: -60%;
    background: conic-gradient(
        from 0deg,
        transparent 0deg,
        rgba(99,102,241,0.9) 40deg,
        transparent 90deg,
        transparent 210deg,
        rgba(14,165,233,0.85) 260deg,
        transparent 310deg,
        transparent 360deg
    );
    animation: rg-frame-spin 7s linear infinite;
    z-index: 0;
}
@keyframes rg-frame-spin { to { transform: rotate(360deg); } }

/* ── Card ────────────────────────────────────────────── */
.rg-card {
    position: relative;
    z-index: 1;
    background: rgba(10,14,26,0.82);
    backdrop-filter: blur(24px) saturate(1.4);
    -webkit-backdrop-filter: blur(24px) saturate(1.4);
    border: 1px solid rgba(255,255,255,0.10);
    border-radius: 24.5px;
    overflow: hidden;
    box-shadow:
        0 0 0 1px rgba(99,102,241,0.08),
        0 32px 80px rgba(0,0,0,0.5),
        inset 0 1px 0 rgba(255,255,255,0.08);
    transition: border-color 0.4s, transform 0.15s ease;
    will-change: transform;
}
.rg-card:focus-within {
    border-color: rgba(99,102,241,0.3);
}

/* ── Card Header ─────────────────────────────────────── */
.rg-head {
    padding: 2.5rem 2.5rem 2rem;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    position: relative;
}

.rg-logo-ring {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(14,165,233,0.2));
    border: 1.5px solid rgba(99,102,241,0.4);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
    position: relative;
    box-shadow: 0 0 0 8px rgba(99,102,241,0.05), 0 0 32px rgba(99,102,241,0.2);
    animation: rg-logo-pulse 3s ease-in-out infinite;
}
@keyframes rg-logo-pulse {
    0%, 100% { box-shadow: 0 0 0 8px rgba(99,102,241,0.05), 0 0 32px rgba(99,102,241,0.2); }
    50%       { box-shadow: 0 0 0 14px rgba(99,102,241,0.08), 0 0 48px rgba(99,102,241,0.3); }
}
.rg-logo-ring img {
    width: 48px; height: 48px;
    object-fit: contain;
    filter: drop-shadow(0 0 12px rgba(99,102,241,0.5));
}

.rg-head h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.025em;
    margin-bottom: 0.35rem;
    background: linear-gradient(135deg, #fff 40%, rgba(99,102,241,0.9));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.rg-head p {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.45);
    letter-spacing: 0.01em;
}

/* Progress bar (step tracker) */
.rg-progress {
    display: flex;
    gap: 4px;
    margin-top: 1.5rem;
    padding: 0 0.5rem;
}
.rg-prog-step {
    flex: 1;
    height: 3px;
    border-radius: 99px;
    background: rgba(255,255,255,0.1);
    transition: background 0.4s;
    position: relative;
    overflow: hidden;
}
.rg-prog-step.active {
    background: rgba(99,102,241,0.25);
}
.rg-prog-step.done {
    background: #6366f1;
}
.rg-prog-step.done::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: rg-shimmer 1.4s ease-in-out;
}
@keyframes rg-shimmer {
    from { transform: translateX(-100%); }
    to   { transform: translateX(100%); }
}

/* ── Card Body ───────────────────────────────────────── */
.rg-body {
    padding: 2rem 2.5rem 2.5rem;
}

/* ── Alert ───────────────────────────────────────────── */
.rg-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(239,68,68,0.12);
    border: 1px solid rgba(239,68,68,0.25);
    border-radius: 12px;
    padding: 0.875rem 1rem;
    margin-bottom: 1.5rem;
    color: #fca5a5;
    font-size: 0.875rem;
    animation: rg-alert-in 0.4s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes rg-alert-in {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.rg-alert i { font-size: 1rem; flex-shrink: 0; }

/* ── Field ───────────────────────────────────────────── */
.rg-field {
    margin-bottom: 1.25rem;
    animation: rg-field-in 0.5s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes rg-field-in {
    from { opacity: 0; transform: translateX(-12px); }
    to   { opacity: 1; transform: translateX(0); }
}

.rg-field:nth-child(1) { animation-delay: 0.05s; }
.rg-field:nth-child(2) { animation-delay: 0.10s; }
.rg-field:nth-child(3) { animation-delay: 0.15s; }
.rg-field:nth-child(4) { animation-delay: 0.20s; }
.rg-field:nth-child(5) { animation-delay: 0.25s; }
.rg-field:nth-child(6) { animation-delay: 0.30s; }
.rg-field:nth-child(7) { animation-delay: 0.35s; }

.rg-field label {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    font-size: 0.8125rem;
    font-weight: 600;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 0.5rem;
}
.rg-field label i {
    font-size: 0.9rem;
    color: #6366f1;
}
.rg-hint-icon {
    color: rgba(255,255,255,0.25) !important;
    font-size: 0.8rem !important;
    cursor: help;
    text-transform: none;
    letter-spacing: 0;
    transition: color 0.2s;
}
.rg-hint-icon:hover { color: rgba(255,255,255,0.6) !important; }

/* ── Input Wrapper ───────────────────────────────────── */
.rg-input-wrap {
    position: relative;
}

.rg-input {
    width: 100%;
    height: 48px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 0 1rem;
    color: #fff;
    font-size: 0.9375rem;
    font-family: inherit;
    outline: none;
    transition:
        border-color 0.25s,
        background 0.25s,
        box-shadow 0.25s;
    -webkit-appearance: none;
    appearance: none;
}
.rg-input::placeholder { color: rgba(255,255,255,0.22); }

.rg-input:hover {
    background: rgba(255,255,255,0.07);
    border-color: rgba(255,255,255,0.18);
}
.rg-input:focus {
    background: rgba(99,102,241,0.08);
    border-color: rgba(99,102,241,0.5);
    box-shadow: 0 0 0 4px rgba(99,102,241,0.12), inset 0 1px 0 rgba(255,255,255,0.05);
}

/* Valid state (green tick) */
.rg-input.is-valid {
    border-color: rgba(34,197,94,0.5);
}

/* Date input color fix */
.rg-input[type="date"] { color-scheme: dark; }

/* Number input: hide spinners */
.rg-input[type="number"]::-webkit-inner-spin-button,
.rg-input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; }

/* Password input with toggle */
.rg-input.has-toggle { padding-right: 3.25rem; }

/* ── Password Toggle ─────────────────────────────────── */
.rg-pw-btn {
    position: absolute;
    right: 0; top: 0;
    width: 48px; height: 48px;
    display: flex; align-items: center; justify-content: center;
    background: none;
    border: none;
    cursor: pointer;
    color: rgba(255,255,255,0.35);
    transition: color 0.2s, transform 0.15s;
    border-radius: 0 12px 12px 0;
}
.rg-pw-btn:hover  { color: rgba(255,255,255,0.7); transform: scale(1.1); }
.rg-pw-btn:active { transform: scale(0.9); }
.rg-pw-btn i { font-size: 1rem; pointer-events: none; }

/* ── 2-Column Grid ───────────────────────────────────── */
.rg-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
@media (max-width: 480px) {
    .rg-grid-2 { grid-template-columns: 1fr; }
}

/* ── Error ───────────────────────────────────────────── */
.rg-error {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #f87171;
    font-size: 0.8rem;
    margin-top: 0.4rem;
    animation: rg-alert-in 0.3s both;
}
.rg-error i { font-size: 0.8rem; flex-shrink: 0; }

/* ── Input State: invalid (server-side error) ─────────── */
.rg-field.has-error .rg-input {
    border-color: rgba(248,113,113,0.5);
    background: rgba(239,68,68,0.07);
}

/* ── Strength Bar ────────────────────────────────────── */
.rg-strength-track {
    height: 4px;
    border-radius: 99px;
    background: rgba(255,255,255,0.08);
    margin-top: 0.6rem;
    overflow: hidden;
}
.rg-strength-fill {
    height: 100%;
    border-radius: 99px;
    width: 0%;
    transition: width 0.4s cubic-bezier(0.34,1.56,0.64,1), background 0.4s;
}
.rg-strength-hint {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.38);
    margin-top: 0.35rem;
    transition: color 0.3s;
    min-height: 1.1em;
}

/* Requirements checklist */
.rg-req-list {
    list-style: none;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.35rem 0.75rem;
    margin-top: 0.65rem;
}
.rg-req-list li {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.74rem;
    color: rgba(255,255,255,0.32);
    transition: color 0.25s;
}
.rg-req-list li i {
    font-size: 0.62rem;
    color: rgba(255,255,255,0.18);
    transition: color 0.25s, transform 0.25s;
}
.rg-req-list li.met {
    color: rgba(255,255,255,0.75);
}
.rg-req-list li.met i {
    color: #22c55e;
    transform: scale(1.25);
}

/* Match hint */
.rg-match-hint {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.78rem;
    color: #f87171;
    margin-top: 0.4rem;
    transition: opacity 0.25s, transform 0.25s;
}
.rg-match-hint.hidden {
    opacity: 0;
    pointer-events: none;
    transform: translateY(-4px);
}
.rg-match-hint.match {
    color: #22c55e;
}
.rg-match-hint i { font-size: 0.78rem; }

/* ── Checkbox ────────────────────────────────────────── */
.rg-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 1.75rem;
    animation: rg-field-in 0.5s 0.38s cubic-bezier(0.16,1,0.3,1) both;
}

.rg-checkbox input[type="checkbox"] {
    -webkit-appearance: none;
    appearance: none;
    width: 20px; height: 20px;
    min-width: 20px;
    border: 1.5px solid rgba(255,255,255,0.2);
    border-radius: 6px;
    background: rgba(255,255,255,0.05);
    cursor: pointer;
    position: relative;
    transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
    margin-top: 1px;
}
.rg-checkbox input:checked {
    background: #6366f1;
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99,102,241,0.15);
}
.rg-checkbox input:checked::after {
    content: '';
    position: absolute;
    left: 5px; top: 2px;
    width: 6px; height: 10px;
    border: 2px solid #fff;
    border-top: none; border-left: none;
    transform: rotate(45deg);
}
.rg-checkbox input:focus-visible {
    outline: 2px solid rgba(99,102,241,0.6);
    outline-offset: 2px;
}
.rg-checkbox.shake {
    animation: rg-shake 0.4s ease;
}
@keyframes rg-shake {
    0%, 100% { transform: translateX(0); }
    20%      { transform: translateX(-6px); }
    40%      { transform: translateX(5px); }
    60%      { transform: translateX(-4px); }
    80%      { transform: translateX(3px); }
}

.rg-checkbox label {
    font-size: 0.875rem;
    color: rgba(255,255,255,0.5);
    cursor: pointer;
    line-height: 1.5;
}
.rg-checkbox label a {
    color: #818cf8;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
.rg-checkbox label a:hover { color: #a5b4fc; text-decoration: underline; }

/* ── Submit Button ───────────────────────────────────── */
.rg-btn {
    position: relative;
    width: 100%;
    height: 52px;
    border-radius: 14px;
    border: none;
    cursor: pointer;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.01em;
    overflow: hidden;
    transition: transform 0.18s, box-shadow 0.25s;
    animation: rg-field-in 0.5s 0.42s cubic-bezier(0.16,1,0.3,1) both;

    background: linear-gradient(135deg, #6366f1, #818cf8 50%, #6366f1);
    background-size: 200% 100%;
    color: #fff;
    box-shadow: 0 0 0 0 rgba(99,102,241,0), 0 4px 16px rgba(99,102,241,0.4);
}
.rg-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 0 4px rgba(99,102,241,0.15), 0 8px 28px rgba(99,102,241,0.5);
    background-position: 100% 0;
}
.rg-btn:active {
    transform: translateY(0) scale(0.98);
    box-shadow: 0 0 0 2px rgba(99,102,241,0.2), 0 2px 8px rgba(99,102,241,0.3);
}
.rg-btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

/* Ripple */
.rg-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.18) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s;
}
.rg-btn:hover::before { opacity: 1; }

.rg-btn-label,
.rg-btn-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: absolute;
    inset: 0;
    transition: opacity 0.25s, transform 0.25s;
}
.rg-btn-loading {
    opacity: 0;
    transform: translateY(8px);
}
.rg-btn.is-loading .rg-btn-label  { opacity: 0; transform: translateY(-8px); }
.rg-btn.is-loading .rg-btn-loading { opacity: 1; transform: translateY(0); }

@keyframes rg-spin { to { transform: rotate(360deg); } }
.rg-spin { animation: rg-spin 0.8s linear infinite; display: inline-block; }

/* ── Divider ─────────────────────────────────────────── */
.rg-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 1.75rem 0 1.25rem;
    animation: rg-field-in 0.5s 0.45s cubic-bezier(0.16,1,0.3,1) both;
}
.rg-divider::before,
.rg-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,0.08);
}
.rg-divider span {
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.3);
    white-space: nowrap;
}

/* ── Outline Button ──────────────────────────────────── */
.rg-btn-outline {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    height: 48px;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.04);
    color: rgba(255,255,255,0.65);
    font-family: inherit;
    font-size: 0.9375rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.15s;
    animation: rg-field-in 0.5s 0.48s cubic-bezier(0.16,1,0.3,1) both;
}
.rg-btn-outline:hover {
    background: rgba(255,255,255,0.08);
    border-color: rgba(255,255,255,0.2);
    color: #fff;
    transform: translateY(-1px);
}
.rg-btn-outline:active { transform: translateY(0) scale(0.98); }

/* ── Trust Badges ────────────────────────────────────── */
.rg-trust {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-top: 1.75rem;
    animation: rg-field-in 0.5s 0.52s cubic-bezier(0.16,1,0.3,1) both;
}
.rg-trust span {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.78rem;
    color: rgba(255,255,255,0.3);
}
.rg-trust span i { font-size: 0.85rem; color: #6366f1; }

/* ── Footer Bar ──────────────────────────────────────── */
.rg-footer-bar {
    background: rgba(255,255,255,0.03);
    border-top: 1px solid rgba(255,255,255,0.06);
    padding: 1rem 2.5rem;
    text-align: center;
    font-size: 0.8125rem;
    color: rgba(255,255,255,0.25);
}

/* ── Back Link ───────────────────────────────────────── */
.rg-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 1.25rem;
    font-size: 0.875rem;
    color: rgba(255,255,255,0.3);
    text-decoration: none;
    transition: color 0.2s, transform 0.2s;
}
.rg-back:hover { color: rgba(255,255,255,0.65); transform: translateX(-3px); }
.rg-back i { font-size: 0.85rem; }

/* ── Tooltip on age/birthday relation ────────────────── */
.rg-badge-autofill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.7rem;
    color: #818cf8;
    font-weight: 500;
    opacity: 0;
    transform: translateY(3px);
    transition: opacity 0.3s, transform 0.3s;
    margin-left: 4px;
}
.rg-badge-autofill.visible { opacity: 1; transform: translateY(0); }

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 580px) {
    .rg-head, .rg-body { padding-left: 1.5rem; padding-right: 1.5rem; }
    .rg-footer-bar { padding-left: 1.5rem; padding-right: 1.5rem; }
    .rg-head h1 { font-size: 1.5rem; }
    .rg-trust { gap: 1rem; }
    .rg-req-list { grid-template-columns: 1fr; }
}

/* ── Reduced motion ──────────────────────────────────── */
@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation-duration: 0.001ms !important; transition-duration: 0.001ms !important; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('auth-content'); ?>
<div class="rg-page" role="main">

    
    <div class="rg-canvas" aria-hidden="true">
        <div class="rg-grid"></div>
        <div class="rg-orb rg-orb-1"></div>
        <div class="rg-orb rg-orb-2"></div>
        <div class="rg-orb rg-orb-3"></div>
        <div class="rg-particles" id="rg-particles"></div>
    </div>

    <div class="rg-wrap">
        <div class="rg-frame">
            <div class="rg-card" id="rg-card">

                
                <header class="rg-head">
                    <div class="rg-logo-ring">
                        <img src="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" alt="SkillUp logo">
                    </div>
                    <h1>Join SkillUp</h1>
                    <p>Create your account and start learning today</p>

                    
                    <div class="rg-progress" role="progressbar" aria-label="Registration progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="3">
                        <div class="rg-prog-step active" id="prog-1"></div>
                        <div class="rg-prog-step" id="prog-2"></div>
                        <div class="rg-prog-step" id="prog-3"></div>
                    </div>
                </header>

                
                <div class="rg-body">

                    <?php if($errors->any()): ?>
                        <div class="rg-alert" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Please fix the highlighted fields below.</span>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('register')); ?>" id="rg-form" novalidate>
                        <?php echo csrf_field(); ?>

                        
                        <div class="rg-field <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <label for="name">
                                <i class="fas fa-user"></i>Full name
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="<?php echo e(old('name')); ?>"
                                class="rg-input"
                                placeholder="Juan Dela Cruz"
                                autocomplete="name"
                                aria-describedby="name-error"
                                required
                            >
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="rg-error" id="name-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="rg-field <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <label for="email">
                                <i class="fas fa-envelope"></i>Email address
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?php echo e(old('email')); ?>"
                                class="rg-input"
                                placeholder="you@example.com"
                                autocomplete="email"
                                aria-describedby="email-error"
                                required
                            >
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="rg-error" id="email-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="rg-grid-2">
                            <div class="rg-field <?php $__errorArgs = ['birthday'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <label for="birthday">
                                    <i class="fas fa-calendar-alt"></i>Birthday
                                    <i class="fas fa-circle-question rg-hint-icon" title="We use this to confirm eligibility for age-restricted courses."></i>
                                </label>
                                <input
                                    type="date"
                                    id="birthday"
                                    name="birthday"
                                    value="<?php echo e(old('birthday')); ?>"
                                    class="rg-input"
                                    max="<?php echo e(date('Y-m-d', strtotime('-1 day'))); ?>"
                                    autocomplete="bday"
                                    aria-describedby="birthday-error"
                                    required
                                >
                                <?php $__errorArgs = ['birthday'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="rg-error" id="birthday-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="rg-field <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <label for="age">
                                    <i class="fas fa-birthday-cake"></i>Age
                                    <span class="rg-badge-autofill" id="rg-autofill-badge">
                                        <i class="fas fa-magic"></i> auto-filled
                                    </span>
                                </label>
                                <input
                                    type="number"
                                    id="age"
                                    name="age"
                                    value="<?php echo e(old('age')); ?>"
                                    min="1"
                                    max="120"
                                    class="rg-input"
                                    placeholder="18"
                                    aria-describedby="age-error"
                                    required
                                >
                                <?php $__errorArgs = ['age'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="rg-error" id="age-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="rg-field <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <label for="address">
                                <i class="fas fa-map-marker-alt"></i>Address
                                <i class="fas fa-circle-question rg-hint-icon" title="Helps us recommend nearby workshops and events."></i>
                            </label>
                            <input
                                type="text"
                                id="address"
                                name="address"
                                value="<?php echo e(old('address')); ?>"
                                class="rg-input"
                                placeholder="City, Province"
                                autocomplete="street-address"
                                aria-describedby="address-error"
                                required
                            >
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="rg-error" id="address-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="rg-field <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <label for="password">
                                <i class="fas fa-lock"></i>Password
                            </label>
                            <div class="rg-input-wrap">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="rg-input has-toggle"
                                    placeholder="Create a strong password"
                                    autocomplete="new-password"
                                    minlength="8"
                                    aria-describedby="password-error"
                                    required
                                >
                                <button type="button" class="rg-pw-btn" data-toggle="password" aria-label="Show password">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="rg-strength-track" aria-hidden="true">
                                <div class="rg-strength-fill" id="rg-str-bar"></div>
                            </div>
                            <p class="rg-strength-hint" id="rg-str-label">Use 8+ characters with letters and numbers</p>
                            <ul class="rg-req-list" id="rg-req-list" aria-live="polite">
                                <li id="req-len"><i class="fas fa-circle"></i> At least 8 characters</li>
                                <li id="req-case"><i class="fas fa-circle"></i> Upper &amp; lowercase letters</li>
                                <li id="req-num"><i class="fas fa-circle"></i> At least one number</li>
                                <li id="req-sym"><i class="fas fa-circle"></i> One symbol (!@#$...)</li>
                            </ul>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="rg-error" id="password-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="rg-field <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <label for="password_confirmation">
                                <i class="fas fa-lock"></i>Confirm password
                            </label>
                            <div class="rg-input-wrap">
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="rg-input has-toggle"
                                    placeholder="Repeat your password"
                                    autocomplete="new-password"
                                    aria-describedby="password_confirmation-error"
                                    required
                                >
                                <button type="button" class="rg-pw-btn" data-toggle="password_confirmation" aria-label="Show confirm password">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                            <p class="rg-match-hint hidden" id="rg-match-hint" aria-live="polite">
                                <i class="fas fa-times-circle"></i> Passwords do not match
                            </p>
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="rg-error" id="password_confirmation-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="rg-checkbox" id="rg-terms-row">
                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                value="1"
                                <?php echo e(old('terms') ? 'checked' : ''); ?>

                                required
                            >
                            <label for="terms">
                                I agree to the
                                <a href="<?php echo e(route('terms')); ?>" target="_blank" rel="noopener">Terms of Service</a>
                                and
                                <a href="<?php echo e(route('privacy')); ?>" target="_blank" rel="noopener">Privacy Policy</a>
                            </label>
                            <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="rg-error" style="margin-left:0"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <button type="submit" class="rg-btn" id="rg-submit">
                            <span class="rg-btn-label">
                                <i class="fas fa-user-plus" aria-hidden="true"></i> Create account
                            </span>
                            <span class="rg-btn-loading" aria-hidden="true">
                                <i class="fas fa-circle-notch rg-spin"></i> Creating account…
                            </span>
                        </button>
                    </form>

                    
                    <div class="rg-divider"><span>Already have an account?</span></div>

                    <a href="<?php echo e(route('login')); ?>" class="rg-btn-outline">
                        <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Sign in instead
                    </a>

                    
                    <div class="rg-trust" aria-label="Platform highlights">
                        <span><i class="fas fa-graduation-cap" aria-hidden="true"></i> Free to join</span>
                        <span><i class="fas fa-book-open" aria-hidden="true"></i> 50+ courses</span>
                        <span><i class="fas fa-certificate" aria-hidden="true"></i> Earn certificates</span>
                    </div>
                </div>

                
                <div class="rg-footer-bar">
                    Join thousands of learners building skills with OIF SkillUp.
                </div>
            </div>
        </div>

        
        <p class="text-center" style="text-align:center">
            <a href="<?php echo e(url('/')); ?>" class="rg-back">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Back to home
            </a>
        </p>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    /* ── Element refs ──────────────────────────────────── */
    var form          = document.getElementById('rg-form');
    var submit        = document.getElementById('rg-submit');
    var pwdInput       = document.getElementById('password');
    var confirmInput   = document.getElementById('password_confirmation');
    var strBar         = document.getElementById('rg-str-bar');
    var strLabel       = document.getElementById('rg-str-label');
    var matchHint       = document.getElementById('rg-match-hint');
    var bdInput         = document.getElementById('birthday');
    var ageInput        = document.getElementById('age');
    var autofillBadge   = document.getElementById('rg-autofill-badge');
    var termsInput      = document.getElementById('terms');
    var termsRow        = document.getElementById('rg-terms-row');
    var prog1 = document.getElementById('prog-1');
    var prog2 = document.getElementById('prog-2');
    var prog3 = document.getElementById('prog-3');
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── Particles ─────────────────────────────────────── */
    var container = document.getElementById('rg-particles');
    if (container && !reduceMotion) {
        for (var i = 0; i < 24; i++) {
            var d = document.createElement('div');
            d.className = 'rg-dot';
            d.style.cssText =
                'left:' + (Math.random() * 100) + '%;' +
                'top:' + (Math.random() * 100) + '%;' +
                '--dur:' + (6 + Math.random() * 10) + 's;' +
                '--delay:-' + (Math.random() * 10) + 's;' +
                '--ty:' + (-15 - Math.random() * 25) + 'px;' +
                '--tx:' + ((Math.random() - 0.5) * 30) + 'px;' +
                'opacity:' + (0.2 + Math.random() * 0.5) + ';' +
                'width:' + (2 + Math.random() * 3) + 'px;' +
                'height:' + (2 + Math.random() * 3) + 'px;';
            container.appendChild(d);
        }
    }

    /* ── Password Toggle ───────────────────────────────── */
    document.querySelectorAll('.rg-pw-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id  = btn.dataset.toggle;
            var inp = document.getElementById(id);
            if (!inp) return;
            var isText = inp.type === 'text';
            inp.type = isText ? 'password' : 'text';
            var icon = btn.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye', isText);
                icon.classList.toggle('fa-eye-slash', !isText);
            }
            btn.setAttribute('aria-label', isText ? 'Show password' : 'Hide password');
        });
    });

    /* ── Password Strength + Requirements ──────────────── */
    function scorePassword(val) {
        if (!val) return 0;
        var s = 0;
        if (val.length >= 8)  s++;
        if (val.length >= 12) s++;
        if (/[a-z]/.test(val) && /[A-Z]/.test(val)) s++;
        if (/\d/.test(val)) s++;
        if (/[^a-zA-Z0-9]/.test(val)) s++;
        return Math.min(s, 4);
    }

    var strColors = ['#ef4444', '#f97316', '#eab308', '#6366f1', '#22c55e'];
    var strWidths = ['0%', '25%', '50%', '75%', '100%'];
    var strTexts  = [
        'Use 8+ characters with letters and numbers',
        'Weak — add more characters',
        'Fair — try mixing upper & lower case',
        'Good — almost there!',
        '✓ Strong password'
    ];

    function setReq(id, met) {
        var li = document.getElementById(id);
        if (!li) return;
        li.classList.toggle('met', met);
        var icon = li.querySelector('i');
        if (icon) { icon.className = met ? 'fas fa-check-circle' : 'fas fa-circle'; }
    }

    function updateRequirements() {
        var v = pwdInput ? pwdInput.value : '';
        setReq('req-len', v.length >= 8);
        setReq('req-case', /[a-z]/.test(v) && /[A-Z]/.test(v));
        setReq('req-num', /\d/.test(v));
        setReq('req-sym', /[^a-zA-Z0-9]/.test(v));
    }

    function updateStrength() {
        if (!pwdInput || !strBar || !strLabel) return;
        var score = scorePassword(pwdInput.value);
        strBar.style.width      = strWidths[score];
        strBar.style.background = pwdInput.value ? strColors[score] : 'transparent';
        strLabel.textContent    = strTexts[score];
        strLabel.style.color    = score >= 3 ? strColors[score] : '';
        pwdInput.classList.toggle('is-valid', pwdInput.value.length >= 8);
        updateRequirements();
        updateProgress();
    }

    /* ── Confirm Match ─────────────────────────────────── */
    function updateMatch() {
        if (!confirmInput || !matchHint) return;
        var hasValue = confirmInput.value.length > 0;
        var isMatch  = hasValue && pwdInput.value === confirmInput.value;
        var mismatch = hasValue && !isMatch;

        matchHint.classList.toggle('hidden', !hasValue);
        matchHint.classList.toggle('match', isMatch);
        matchHint.innerHTML = isMatch
            ? '<i class="fas fa-check-circle"></i> Passwords match'
            : '<i class="fas fa-times-circle"></i> Passwords do not match';

        confirmInput.classList.toggle('is-valid', isMatch);
        confirmInput.style.borderColor = mismatch ? 'rgba(248,113,113,0.5)' : '';
        confirmInput.style.boxShadow   = mismatch ? '0 0 0 4px rgba(239,68,68,0.12)' : '';
        updateProgress();
    }

    /* ── Birthday → Age sync ───────────────────────────── */
    function syncAge() {
        if (!bdInput || !ageInput || !bdInput.value) return;
        var born  = new Date(bdInput.value);
        var today = new Date();
        var yrs   = today.getFullYear() - born.getFullYear();
        var m     = today.getMonth() - born.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < born.getDate())) yrs--;
        if (yrs >= 1 && yrs <= 120) {
            ageInput.value = yrs;
            if (autofillBadge) {
                autofillBadge.classList.add('visible');
                setTimeout(function () { autofillBadge.classList.remove('visible'); }, 2500);
            }
        }
        updateProgress();
    }

    /* ── Progress tracker ──────────────────────────────── */
    function updateProgress() {
        var nameVal  = (document.getElementById('name')    || {}).value || '';
        var emailVal = (document.getElementById('email')   || {}).value || '';
        var addrVal  = (document.getElementById('address') || {}).value || '';
        var bdVal    = (bdInput  || {}).value || '';
        var ageVal   = (ageInput || {}).value || '';
        var pwdVal   = (pwdInput || {}).value || '';
        var cnfVal   = (confirmInput || {}).value || '';

        var s1 = nameVal && emailVal && addrVal;
        var s2 = s1 && bdVal && ageVal;
        var s3 = s2 && pwdVal && cnfVal && pwdVal === cnfVal;

        if (prog1) { prog1.className = 'rg-prog-step ' + (s1 ? 'done' : 'active'); }
        if (prog2) { prog2.className = 'rg-prog-step ' + (s3 ? 'done' : s2 ? 'done' : s1 ? 'active' : ''); }
        if (prog3) { prog3.className = 'rg-prog-step ' + (s3 ? 'done' : s2 ? 'active' : ''); }
    }

    /* ── Client-side submit gate (avoids a wasted round trip) ── */
    function showClientAlert(msg) {
        var alertBox = document.getElementById('rg-client-alert');
        if (!alertBox) {
            alertBox = document.createElement('div');
            alertBox.className = 'rg-alert';
            alertBox.id = 'rg-client-alert';
            alertBox.setAttribute('role', 'alert');
            alertBox.innerHTML = '<i class="fas fa-exclamation-circle"></i><span id="rg-client-alert-text"></span>';
            form.parentNode.insertBefore(alertBox, form);
        }
        var textEl = document.getElementById('rg-client-alert-text');
        if (textEl) { textEl.textContent = msg; }
        alertBox.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
    }

    if (form && submit) {
        form.addEventListener('submit', function (e) {
            var pwd = pwdInput ? pwdInput.value : '';
            var cnf = confirmInput ? confirmInput.value : '';

            if (pwd.length < 8) {
                e.preventDefault();
                showClientAlert('Password must be at least 8 characters.');
                if (pwdInput) pwdInput.focus();
                return;
            }
            if (pwd !== cnf) {
                e.preventDefault();
                showClientAlert('Passwords do not match — please re-check both fields.');
                if (confirmInput) confirmInput.focus();
                return;
            }
            if (termsInput && !termsInput.checked) {
                e.preventDefault();
                showClientAlert('Please accept the Terms of Service and Privacy Policy to continue.');
                if (termsRow) {
                    termsRow.classList.remove('shake');
                    void termsRow.offsetWidth; // restart animation
                    termsRow.classList.add('shake');
                }
                return;
            }

            submit.classList.add('is-loading');
            submit.disabled = true;
        });
    }

    /* ── Subtle 3D tilt on the card (desktop pointers only) ── */
    var card = document.getElementById('rg-card');
    if (card && !reduceMotion && window.matchMedia && window.matchMedia('(pointer: fine)').matches) {
        card.addEventListener('mousemove', function (e) {
            var rect = card.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            var cx = rect.width / 2, cy = rect.height / 2;
            var rotateX = ((y - cy) / cy) * -3.5;
            var rotateY = ((x - cx) / cx) * 3.5;
            card.style.transform = 'perspective(1200px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg)';
        });
        card.addEventListener('mouseleave', function () {
            card.style.transform = 'perspective(1200px) rotateX(0deg) rotateY(0deg)';
        });
    }

    /* ── Event bindings ────────────────────────────────── */
    if (pwdInput)     { pwdInput.addEventListener('input', function () { updateStrength(); updateMatch(); }); }
    if (confirmInput) { confirmInput.addEventListener('input', updateMatch); }
    if (bdInput)       { bdInput.addEventListener('change', syncAge); }

    var watchIds = ['name', 'email', 'address'];
    watchIds.forEach(function (id) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', updateProgress);
    });
    if (ageInput) { ageInput.addEventListener('input', updateProgress); }

    /* ── Init ──────────────────────────────────────────── */
    updateStrength();
    updateMatch();
    updateProgress();

})();
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/auth/resgister.blade.php ENDPATH**/ ?>