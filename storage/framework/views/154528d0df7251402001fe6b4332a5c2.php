

<?php $__env->startSection('title', 'Course Records'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ============================================================
   Course Records — staff portal
   Design: futuristic glass / neon-indigo, dense data table
   ============================================================ */
:root {
    --cr-bg:            var(--body-bg);
    --cr-surface:       var(--surface);
    --cr-surface-solid: var(--surface);
    --cr-surface-alt:   var(--topbar-control-bg);
    --cr-border:        var(--border);
    --cr-border-strong: rgba(129, 140, 248, 0.45);

    --cr-accent:        #818CF8;
    --cr-accent-2:      #22D3EE;
    --cr-accent-3:      #A78BFA;
    --cr-accent-dark:   #4338CA;
    --cr-accent-light:  rgba(129, 140, 248, 0.12);

    --cr-success:       #34D399;
    --cr-success-bg:    rgba(52, 211, 153, 0.10);
    --cr-warning:       #FBBF24;
    --cr-warning-bg:    rgba(251, 191, 36, 0.10);
    --cr-danger:        #FB7185;
    --cr-danger-bg:     rgba(251, 113, 133, 0.10);

    --cr-text:          var(--text);
    --cr-text-dim:      var(--muted);
    --cr-text-faint:    var(--muted);

    --cr-radius:        14px;
    --cr-radius-sm:     10px;
    --cr-radius-lg:     18px;
    --cr-shadow:        0 1px 0 rgba(255,255,255,0.04) inset, 0 12px 30px -14px rgba(0,0,0,0.18);
    --cr-shadow-md:     0 30px 70px -30px rgba(0,0,0,0.22);
    --cr-font:          'Inter', system-ui, -apple-system, sans-serif;
}

html[data-staff-theme="dark"] .cr-page {
    --cr-bg:            #05070f;
    --cr-surface:       rgba(16, 21, 38, 0.62);
    --cr-surface-solid: #0c1120;
    --cr-surface-alt:   rgba(255,255,255,0.03);
    --cr-border:        rgba(129, 140, 248, 0.16);
    --cr-border-strong: rgba(129, 140, 248, 0.45);
    --cr-text:          #EAF0FF;
    --cr-text-dim:      #93A0C3;
    --cr-text-faint:    #5B6788;
    --cr-shadow:        0 1px 0 rgba(255,255,255,0.04) inset, 0 12px 30px -14px rgba(0,0,0,0.55);
    --cr-shadow-md:     0 30px 70px -30px rgba(0,0,0,0.7);
}

/* ── Keyframes ── */
@keyframes cr-fade-up   { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
@keyframes cr-fade      { from { opacity: 0; } to { opacity: 1; } }
@keyframes cr-grid-drift{ 0% { transform: translate(0,0); } 100% { transform: translate(-44px,-44px); } }
@keyframes cr-orb-float { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(18px,-26px) scale(1.07); } }
@keyframes cr-shimmer   { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
@keyframes cr-blink     { 0%,100% { opacity: 1; } 50% { opacity: .25; } }
@keyframes cr-spin      { to { transform: rotate(360deg); } }
@keyframes cr-pop       { 0% { transform: scale(.9); opacity:0; } 100% { transform: scale(1); opacity:1; } }
@keyframes cr-pulse-ring{ 0% { box-shadow: 0 0 0 0 rgba(52,211,153,.45);} 100% { box-shadow: 0 0 0 8px rgba(52,211,153,0);} }

.cr-animate      { animation: cr-fade-up .5s ease-out both; }
.cr-animate-fast { animation: cr-fade-up .3s ease-out both; }
.cr-row-fade      { animation: cr-fade .35s ease-out both; }

@media (prefers-reduced-motion: reduce) {
    .cr-animate, .cr-animate-fast, .cr-row-fade, .cr-stat__icon, .cr-header__eyebrow-dot { animation: none !important; }
}

/* ── Page shell + ambient background ── */
.cr-page {
    position: relative;
    isolation: isolate;
    font-family: var(--cr-font);
    color: var(--cr-text);
    max-width: 1300px;
    margin: 0 auto;
    padding-bottom: 8px;
}
.cr-bg {
    position: absolute;
    inset: -48px -24px;
    z-index: -1;
    overflow: hidden;
    border-radius: 28px;
    background:
        radial-gradient(620px circle at 12% 0%,  rgba(129,140,248,0.16), transparent 60%),
        radial-gradient(520px circle at 90% 15%, rgba(34,211,238,0.10), transparent 60%),
        radial-gradient(700px circle at 50% 100%,rgba(167,139,250,0.09), transparent 60%),
        var(--cr-bg);
}
.cr-bg::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(129,140,248,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(129,140,248,0.05) 1px, transparent 1px);
    background-size: 44px 44px;
    mask-image: radial-gradient(ellipse 85% 55% at 50% 10%, black 35%, transparent 90%);
    animation: cr-grid-drift 24s linear infinite;
}
.cr-orb {
    position: absolute;
    width: 240px; height: 240px;
    border-radius: 50%;
    filter: blur(74px);
    opacity: .32;
    animation: cr-orb-float 13s ease-in-out infinite;
}
.cr-orb--1 { background: var(--cr-accent);   top: -50px; left: 4%;   }
.cr-orb--2 { background: var(--cr-accent-2); top: 20%;   right: 6%;  animation-delay: -5s; }
.cr-orb--3 { background: var(--cr-accent-3); bottom: -60px; left: 40%; animation-delay: -9s; }

/* ── Header ── */
.cr-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}
.cr-header__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--cr-accent-2);
    margin-bottom: 8px;
}
.cr-header__eyebrow-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--cr-accent-2);
    box-shadow: 0 0 10px 2px rgba(34,211,238,.7);
    display: inline-block;
    animation: cr-blink 1.8s ease-in-out infinite;
}
.cr-header__title {
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -.5px;
    line-height: 1.2;
    color: var(--cr-text);
    text-shadow: none;
}
.cr-header__subtitle {
    margin-top: 6px;
    font-size: 13.5px;
    color: var(--cr-text-dim);
    line-height: 1.6;
    max-width: 560px;
}
.cr-header__actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

/* ── Buttons ── */
.cr-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 16px;
    border-radius: var(--cr-radius-sm);
    font-size: 13.5px;
    font-weight: 600;
    font-family: var(--cr-font);
    cursor: pointer;
    border: 1px solid transparent;
    text-decoration: none;
    transition: transform .15s ease, background .15s ease, box-shadow .15s ease, border-color .15s ease, color .15s ease;
    white-space: nowrap;
    line-height: 1;
}
.cr-btn:hover { transform: translateY(-1px); text-decoration: none; }
.cr-btn:active { transform: translateY(0); }
.cr-btn--primary {
    background: linear-gradient(135deg, var(--cr-accent), var(--cr-accent-3));
    color: #060814;
    box-shadow: 0 8px 22px -8px rgba(129,140,248,.55);
}
.cr-btn--primary:hover { box-shadow: 0 12px 30px -8px rgba(129,140,248,.7); color: #060814; }
.cr-btn--outline {
    background: rgba(255,255,255,0.03);
    color: var(--cr-text-dim);
    border-color: var(--cr-border);
    box-shadow: var(--cr-shadow);
}
.cr-btn--outline:hover { color: var(--cr-text); border-color: var(--cr-border-strong); background: rgba(255,255,255,0.06); }
.cr-btn--danger {
    background: var(--cr-danger-bg);
    color: var(--cr-danger);
    border-color: rgba(251,113,133,.35);
}
.cr-btn--danger:hover { background: rgba(251,113,133,.18); border-color: rgba(251,113,133,.55); }
.cr-btn--ghost {
    background: transparent;
    color: var(--cr-accent);
    border: none;
    padding: 6px 10px;
    font-size: 13px;
}
.cr-btn--ghost:hover { background: var(--cr-accent-light); }
.cr-btn--sm { padding: 6px 11px; font-size: 12px; }
.cr-btn svg { flex-shrink: 0; }
.cr-btn[disabled] { opacity: .55; cursor: not-allowed; transform: none !important; box-shadow: none !important; }
.cr-btn__spinner {
    width: 12px; height: 12px;
    border-radius: 50%;
    border: 2px solid rgba(6,8,20,.35);
    border-top-color: #060814;
    animation: cr-spin .7s linear infinite;
    display: none;
    flex-shrink: 0;
}
.cr-btn.is-loading .cr-btn__spinner { display: inline-block; }

/* ── Stats row ── */
.cr-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}
.cr-stat {
    position: relative;
    background: rgba(255,255,255,0.78);
    border: 1px solid rgba(148, 163, 184, 0.32);
    border-radius: var(--cr-radius);
    padding: 20px 20px 18px;
    box-shadow: 0 14px 30px -24px rgba(15,23,42,0.45);
    backdrop-filter: blur(16px) saturate(140%);
    -webkit-backdrop-filter: blur(16px) saturate(140%);
    overflow: hidden;
    transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
}
.cr-stat:hover { border-color: var(--cr-border-strong); box-shadow: 0 16px 34px -18px rgba(0,0,0,.6); }
.cr-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background-size: 200% 100%;
    animation: cr-shimmer 5s linear infinite;
}
.cr-stat--indigo::before { background: linear-gradient(90deg, transparent, var(--cr-accent), var(--cr-accent-2), transparent); }
.cr-stat--green::before  { background: linear-gradient(90deg, transparent, var(--cr-success), #6ee7b7, transparent); }
.cr-stat--amber::before  { background: linear-gradient(90deg, transparent, var(--cr-warning), #fde68a, transparent); }
.cr-stat__icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
}
.cr-stat:hover .cr-stat__icon { transform: rotate(-8deg) scale(1.08); }
.cr-stat--indigo .cr-stat__icon { background: var(--cr-accent-light); color: var(--cr-accent); box-shadow: 0 0 18px -6px rgba(129,140,248,.6); }
.cr-stat--green  .cr-stat__icon { background: var(--cr-success-bg);   color: var(--cr-success); box-shadow: 0 0 18px -6px rgba(52,211,153,.6); }
.cr-stat--amber  .cr-stat__icon { background: var(--cr-warning-bg);   color: var(--cr-warning); box-shadow: 0 0 18px -6px rgba(251,191,36,.6); }
.cr-stat__value {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -.7px;
    line-height: 1;
    color: var(--cr-text);
    font-variant-numeric: tabular-nums;
}
.cr-stat__label {
    font-size: 12px;
    color: var(--cr-text-faint);
    margin-top: 5px;
    font-weight: 600;
    letter-spacing: .02em;
}

/* ── Toolbar ── */
.cr-toolbar {
    background: rgba(255,255,255,0.76);
    border: 1px solid rgba(148, 163, 184, 0.32);
    border-radius: var(--cr-radius);
    padding: 14px 16px;
    margin-bottom: 16px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
    box-shadow: 0 14px 32px -26px rgba(15,23,42,0.4);
    backdrop-filter: blur(16px) saturate(140%);
    -webkit-backdrop-filter: blur(16px) saturate(140%);
}
.cr-search { position: relative; flex: 1; min-width: 200px; }
.cr-search__icon {
    position: absolute; left: 11px; top: 50%;
    transform: translateY(-50%);
    color: var(--cr-text-faint);
    pointer-events: none;
    transition: color .15s ease;
}
.cr-search:focus-within .cr-search__icon { color: var(--cr-accent-2); }
.cr-search__input {
    width: 100%;
    padding: 9px 12px 9px 36px;
    border: 1px solid var(--cr-border);
    border-radius: var(--cr-radius-sm);
    font-size: 13.5px;
    font-family: var(--cr-font);
    color: var(--cr-text);
    background: rgba(6,9,20,.55);
    outline: none;
    transition: border-color .15s, background .15s, box-shadow .15s;
    box-sizing: border-box;
}
.cr-search__input::placeholder { color: var(--cr-text-faint); }
.cr-search__input:focus {
    border-color: var(--cr-accent-2);
    background: rgba(6,9,20,.85);
    box-shadow: 0 0 0 3px rgba(34,211,238,.14), 0 0 18px -6px rgba(34,211,238,.4);
}
.cr-search__spinner {
    position: absolute; right: 11px; top: 50%;
    transform: translateY(-50%);
    width: 13px; height: 13px;
    border-radius: 50%;
    border: 2px solid rgba(147,160,195,.25);
    border-top-color: var(--cr-accent-2);
    animation: cr-spin .6s linear infinite;
    opacity: 0;
    transition: opacity .15s ease;
    pointer-events: none;
}
.cr-search__spinner.is-active { opacity: 1; }

.cr-select {
    padding: 9px 32px 9px 12px;
    border: 1px solid var(--cr-border);
    border-radius: var(--cr-radius-sm);
    font-size: 13px;
    font-family: var(--cr-font);
    color: var(--cr-text-dim);
    background-color: rgba(6,9,20,.55);
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2393A0C3' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    transition: border-color .15s, box-shadow .15s;
}
.cr-select:focus { border-color: var(--cr-accent-2); box-shadow: 0 0 0 3px rgba(34,211,238,.14); }
.cr-toolbar__count { font-size: 12.5px; color: var(--cr-text-faint); white-space: nowrap; margin-left: auto; }

/* ── Table card ── */
.cr-card {
    position: relative;
    background: var(--cr-surface);
    border: 1px solid var(--cr-border);
    border-radius: var(--cr-radius);
    box-shadow: var(--cr-shadow-md);
    overflow: hidden;
    margin-bottom: 24px;
    backdrop-filter: blur(16px) saturate(140%);
    -webkit-backdrop-filter: blur(16px) saturate(140%);
}
.cr-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--cr-accent), var(--cr-accent-2), var(--cr-accent-3), transparent);
    background-size: 200% 100%;
    animation: cr-shimmer 6s linear infinite;
    z-index: 1;
}
.cr-table-wrap { overflow-x: auto; }
.cr-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.cr-table thead { background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--cr-border); }
.cr-table th {
    padding: 12px 16px;
    text-align: left;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--cr-text-faint);
    white-space: nowrap;
}
.cr-table th.sortable { cursor: pointer; user-select: none; transition: color .15s ease; }
.cr-table th.sortable:hover { color: var(--cr-accent-2); }
.cr-table td {
    padding: 13px 16px;
    color: var(--cr-text-dim);
    border-bottom: 1px solid rgba(255,255,255,0.04);
    vertical-align: middle;
}
.cr-table tbody tr:last-child td { border-bottom: none; }
.cr-table tbody tr { transition: background-color .15s ease; position: relative; }
.cr-table tbody tr:hover { background-color: rgba(129,140,248,0.06); }
.cr-table tbody tr:hover td:first-child::before {
    content: '';
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, var(--cr-accent), var(--cr-accent-2));
}

/* Checkbox */
input[type="checkbox"] {
    accent-color: var(--cr-accent);
    width: 15px; height: 15px;
    cursor: pointer;
}

/* Course cell */
.cr-course-cell { display: flex; align-items: center; gap: 10px; }
.cr-course-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 4px 14px -4px rgba(0,0,0,.5);
    transition: transform .2s ease;
}
.cr-table tbody tr:hover .cr-course-icon { transform: scale(1.06); }
.cr-course-title { font-weight: 600; color: var(--cr-text); }
.cr-course-code { font-size: 11.5px; color: var(--cr-text-faint); margin-top: 1px; }

/* Instructor chip */
.cr-instructor { display: inline-flex; align-items: center; gap: 6px; }
.cr-instructor__avatar {
    width: 22px; height: 22px;
    border-radius: 50%;
    background: var(--cr-accent-light);
    color: var(--cr-accent);
    font-size: 10px;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* Status badge */
.cr-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 700;
    white-space: nowrap;
    border: 1px solid transparent;
}
.cr-badge__dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.cr-badge--active   { background: var(--cr-success-bg); color: var(--cr-success); border-color: rgba(52,211,153,.3); box-shadow: 0 0 12px -5px rgba(52,211,153,.6); }
.cr-badge--inactive { background: rgba(255,255,255,0.04); color: var(--cr-text-faint); border-color: rgba(255,255,255,.08); }
.cr-badge--draft    { background: var(--cr-warning-bg); color: var(--cr-warning); border-color: rgba(251,191,36,.3); box-shadow: 0 0 12px -5px rgba(251,191,36,.6); }
/* Motion encodes meaning: live courses pulse, drafts blink softly, inactive stays still */
.cr-badge--active .cr-badge__dot { animation: cr-pulse-ring 1.8s ease-out infinite; }
.cr-badge--draft .cr-badge__dot  { animation: cr-blink 1.6s ease-in-out infinite; }

/* Row actions */
.cr-actions { display: flex; gap: 6px; align-items: center; justify-content: flex-end; }
.cr-edit-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: var(--cr-accent-2);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: var(--cr-radius-sm);
    transition: background .15s ease;
}
.cr-edit-link:hover { background: rgba(34,211,238,.12); text-decoration: none; color: var(--cr-accent-2); }
.cr-edit-link svg { transition: transform .15s ease; }
.cr-edit-link:hover svg { transform: translate(1px,-1px); }

/* ── Pagination ── */
.cr-pagination {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 16px;
    border-top: 1px solid var(--cr-border);
    flex-wrap: wrap; gap: 10px;
}
.cr-pagination__info { font-size: 12.5px; color: var(--cr-text-faint); }
.cr-pagination__pages { display: flex; gap: 4px; }
.cr-page-btn {
    width: 32px; height: 32px;
    border-radius: var(--cr-radius-sm);
    border: 1px solid var(--cr-border);
    background: rgba(255,255,255,0.02);
    color: var(--cr-text-dim);
    font-size: 13px;
    font-family: var(--cr-font);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.cr-page-btn:hover { background: rgba(129,140,248,.1); border-color: var(--cr-border-strong); color: var(--cr-text); text-decoration: none; }
.cr-page-btn.is-active {
    background: linear-gradient(135deg, var(--cr-accent), var(--cr-accent-3));
    border-color: transparent;
    color: #060814;
    font-weight: 700;
    box-shadow: 0 4px 16px -4px rgba(129,140,248,.6);
    animation: cr-page-glow 2.6s ease-in-out infinite;
}
.cr-page-btn[disabled] { opacity: .35; cursor: not-allowed; pointer-events: none; }

/* ── Flash messages ── */
.cr-flash {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 16px;
    border-radius: var(--cr-radius);
    margin-bottom: 20px;
    font-size: 13.5px;
    font-weight: 500;
    border: 1px solid transparent;
}
.cr-flash--success { background: var(--cr-success-bg); color: #a7f3d0; border-color: rgba(52,211,153,.3); }
.cr-flash--error   { background: var(--cr-danger-bg);  color: #fecdd3; border-color: rgba(251,113,133,.3); }

/* ── Empty state ── */
.cr-empty {
    text-align: center;
    padding: 60px 20px;
    background: var(--cr-surface);
    border: 1px dashed var(--cr-border-strong);
    border-radius: var(--cr-radius);
    backdrop-filter: blur(16px);
}
.cr-empty__icon {
    width: 54px; height: 54px;
    background: var(--cr-accent-light);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    color: var(--cr-accent);
    box-shadow: 0 0 24px -8px rgba(129,140,248,.6);
    animation: cr-float-soft 3.4s ease-in-out infinite;
}
.cr-empty__title { font-size: 15px; font-weight: 700; color: var(--cr-text); margin-bottom: 6px; }
.cr-empty__text  { font-size: 13.5px; color: var(--cr-text-faint); margin-bottom: 20px; }

/* ── Modal ── */
.cr-modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(4,6,14,.65);
    backdrop-filter: blur(6px);
    z-index: 200;
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
    opacity: 0;
    transition: opacity .22s ease;
}
.cr-modal-backdrop[hidden] { display: none !important; }
.cr-modal-backdrop.is-open { opacity: 1; }
.cr-modal, .cr-confirm {
    transform: scale(.94) translateY(10px);
    opacity: 0;
    transition: transform .28s cubic-bezier(.34,1.56,.64,1), opacity .22s ease;
}
.cr-modal-backdrop.is-open .cr-modal,
.cr-modal-backdrop.is-open .cr-confirm { transform: scale(1) translateY(0); opacity: 1; }

.cr-modal {
    background: var(--cr-surface-solid);
    border: 1px solid var(--cr-border-strong);
    border-radius: var(--cr-radius-lg);
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--cr-shadow-md);
    color: var(--cr-text);
}
.cr-modal__header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid var(--cr-border);
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    position: sticky; top: 0;
    background: var(--cr-surface-solid);
    z-index: 1;
    overflow: hidden;
}
.cr-modal__header::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--cr-accent), var(--cr-accent-2), var(--cr-accent-3), transparent);
    background-size: 200% 100%;
    animation: cr-shimmer 6s linear infinite;
}
.cr-modal__title { font-size: 16px; font-weight: 700; color: var(--cr-text); }
.cr-modal__subtitle { font-size: 12.5px; color: var(--cr-text-faint); margin-top: 2px; }
.cr-modal__close {
    background: none; border: none; cursor: pointer;
    color: var(--cr-text-faint); padding: 6px;
    border-radius: 8px; line-height: 0;
    transition: color .15s ease, background .15s ease, transform .15s ease;
    flex-shrink: 0;
}
.cr-modal__close:hover { color: var(--cr-text); background: rgba(255,255,255,.06); transform: rotate(90deg); }
.cr-modal__body { padding: 22px 24px; }
.cr-modal__footer {
    padding: 16px 24px;
    border-top: 1px solid var(--cr-border);
    display: flex; gap: 10px; justify-content: flex-end;
    position: sticky; bottom: 0;
    background: var(--cr-surface-solid);
    z-index: 1;
}

/* ── Form fields ── */
.cr-field { margin-bottom: 18px; animation: cr-fade-up .35s ease both; }
.cr-field:last-child { margin-bottom: 0; }
.cr-modal__body > .cr-field:nth-of-type(1) { animation-delay: 0ms; }
.cr-modal__body > .cr-field:nth-of-type(2) { animation-delay: 60ms; }
.cr-modal__body > .cr-field:nth-of-type(3) { animation-delay: 120ms; }
.cr-modal__body > .cr-field-row { animation: cr-fade-up .35s ease both; }
.cr-modal__body > .cr-field-row:nth-of-type(1) { animation-delay: 30ms; }
.cr-modal__body > .cr-field-row:nth-of-type(2) { animation-delay: 90ms; }
.cr-label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--cr-text);
    margin-bottom: 6px;
    letter-spacing: .01em;
}
.cr-label span { color: var(--cr-danger); margin-left: 2px; }
.cr-input, .cr-field select, .cr-field textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--cr-border);
    border-radius: var(--cr-radius-sm);
    font-size: 13.5px;
    font-family: var(--cr-font);
    color: var(--cr-text);
    background: rgba(6,9,20,.55);
    outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
    box-sizing: border-box;
}
.cr-input::placeholder, .cr-field textarea::placeholder { color: var(--cr-text-faint); }
.cr-input:focus, .cr-field select:focus, .cr-field textarea:focus {
    border-color: var(--cr-accent-2);
    background: rgba(6,9,20,.85);
    box-shadow: 0 0 0 3px rgba(34,211,238,.14), 0 0 18px -6px rgba(34,211,238,.35);
}
.cr-field textarea { resize: vertical; min-height: 80px; }
.cr-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.cr-input-hint { font-size: 11.5px; color: var(--cr-text-faint); margin-top: 4px; }
.cr-char-count { font-size: 11px; color: var(--cr-text-faint); margin-top: 4px; text-align: right; }
.cr-char-count.is-near-limit { color: var(--cr-warning); }

/* ── Delete confirm modal ── */
.cr-confirm {
    background: var(--cr-surface-solid);
    border: 1px solid var(--cr-border-strong);
    border-radius: var(--cr-radius-lg);
    width: 100%;
    max-width: 400px;
    box-shadow: var(--cr-shadow-md);
    overflow: hidden;
    color: var(--cr-text);
}
.cr-confirm__icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    background: var(--cr-danger-bg);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
    color: var(--cr-danger);
    box-shadow: 0 0 24px -8px rgba(251,113,133,.6);
}
.cr-confirm__body { padding: 28px 24px 20px; text-align: center; }
.cr-confirm__title { font-size: 16px; font-weight: 700; color: var(--cr-text); margin-bottom: 8px; }
.cr-confirm__text  { font-size: 13.5px; color: var(--cr-text-dim); line-height: 1.6; }
.cr-confirm__footer { padding: 16px 24px; border-top: 1px solid var(--cr-border); display: flex; gap: 10px; justify-content: flex-end; }

/* ── Toast (lightweight, for JS feedback) ── */
.cr-toast-stack {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 400;
}
.cr-toast {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--cr-radius-sm);
    background: var(--cr-surface-solid);
    border: 1px solid var(--cr-border-strong);
    color: var(--cr-text);
    font-size: 13px;
    font-weight: 500;
    box-shadow: var(--cr-shadow-md);
    animation: cr-pop .25s ease both;
    max-width: 320px;
}
.cr-toast--success { border-color: rgba(52,211,153,.4); }
.cr-toast--success .cr-toast__dot { background: var(--cr-success); box-shadow: 0 0 10px 2px rgba(52,211,153,.6); }
.cr-toast__dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

/* ============================================================
   FUTURISTIC ENHANCEMENTS — HUD details, ambient motion, micro-interactions
   ============================================================ */

/* Ambient radar-style scanline sweeping through the page background */
.cr-scanline {
    position: absolute;
    left: 0; right: 0; top: 0;
    height: 140px;
    background: linear-gradient(180deg, transparent, rgba(34,211,238,0.05) 45%, rgba(129,140,248,0.07) 55%, transparent);
    mix-blend-mode: screen;
    animation: cr-scan-sweep 9s ease-in-out infinite;
    pointer-events: none;
}
@keyframes cr-scan-sweep {
    0%   { transform: translateY(-160px); opacity: 0; }
    8%   { opacity: 1; }
    50%  { opacity: .8; }
    92%  { opacity: 0; }
    100% { transform: translateY(760px); opacity: 0; }
}

/* Twinkling particle field */
.cr-particles { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }
.cr-particle {
    position: absolute;
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--cr-accent-2);
    box-shadow: 0 0 6px 1px rgba(34,211,238,.8);
    animation: cr-particle-twinkle 4.5s ease-in-out infinite;
}
@keyframes cr-particle-twinkle {
    0%, 100% { opacity: 0; transform: scale(.6); }
    50%      { opacity: .85; transform: scale(1); }
}

/* HUD corner brackets — appear on hover of cards/panels */
.cr-hud { position: relative; }
.cr-corner {
    position: absolute;
    width: 12px; height: 12px;
    border: 0 solid var(--cr-accent-2);
    opacity: 0;
    transition: opacity .25s ease, width .25s ease, height .25s ease;
    pointer-events: none;
    z-index: 2;
}
.cr-hud:hover .cr-corner { opacity: .85; width: 16px; height: 16px; }
.cr-corner--tl { top: -1px; left: -1px; border-top-width: 2px; border-left-width: 2px; border-top-left-radius: 7px; }
.cr-corner--tr { top: -1px; right: -1px; border-top-width: 2px; border-right-width: 2px; border-top-right-radius: 7px; }
.cr-corner--bl { bottom: -1px; left: -1px; border-bottom-width: 2px; border-left-width: 2px; border-bottom-left-radius: 7px; }
.cr-corner--br { bottom: -1px; right: -1px; border-bottom-width: 2px; border-right-width: 2px; border-bottom-right-radius: 7px; }

/* Live sync chip in header */
.cr-sync-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    color: var(--cr-text-faint);
    padding: 6px 11px;
    border: 1px solid var(--cr-border);
    border-radius: 99px;
    background: rgba(255,255,255,0.02);
    letter-spacing: .02em;
}
.cr-sync-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--cr-success);
    box-shadow: 0 0 8px 1px rgba(52,211,153,.7);
    animation: cr-pulse-ring 1.8s ease-out infinite;
    flex-shrink: 0;
}

/* Slow living sheen across the heading gradient */
.cr-header__title {
    background-size: 200% auto;
    animation: cr-text-sheen 6s ease-in-out infinite;
}
@keyframes cr-text-sheen {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Sortable header underline sweep */
.cr-table th.sortable { position: relative; }
.cr-table th.sortable::after {
    content: '';
    position: absolute;
    left: 16px; right: 16px; bottom: 6px;
    height: 1px;
    background: var(--cr-accent-2);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .2s ease;
}
.cr-table th.sortable:hover::after { transform: scaleX(1); }

/* Row hover sheen sweep */
.cr-table tbody tr {
    background-image: linear-gradient(100deg, transparent 40%, rgba(129,140,248,0.07) 50%, transparent 60%);
    background-size: 250% 100%;
    background-position: 100% 0;
    transition: background-position .5s ease, background-color .15s ease;
}
.cr-table tbody tr:hover { background-position: 0 0; }

/* Button ripple on click */
.cr-btn { position: relative; overflow: hidden; }
.cr-ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.5);
    transform: scale(0);
    animation: cr-ripple-anim .6s ease-out;
    pointer-events: none;
}
@keyframes cr-ripple-anim {
    to { transform: scale(3); opacity: 0; }
}

/* Stat card tilt (JS-driven) */
.cr-stat { transform-style: preserve-3d; will-change: transform; }

/* Empty state gentle float */
@keyframes cr-float-soft {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-6px); }
}

/* Pagination active glow pulse */
@keyframes cr-page-glow {
    0%, 100% { box-shadow: 0 4px 16px -4px rgba(129,140,248,.6); }
    50%      { box-shadow: 0 4px 22px -2px rgba(129,140,248,.85); }
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .cr-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .cr-header__actions {
        width: 100%;
        justify-content: flex-start;
    }

    .cr-header__subtitle {
        max-width: 100%;
    }
}

@media (max-width: 900px) {
    .cr-stats { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 760px) {
    .cr-stats { grid-template-columns: 1fr 1fr; }
    .cr-toolbar { flex-direction: column; align-items: stretch; }
    .cr-search { min-width: 100%; }
    .cr-toolbar__count { margin-left: 0; }
}

@media (max-width: 520px) {
    .cr-header__title {
        font-size: 32px;
    }

    .cr-stats {
        grid-template-columns: 1fr;
    }

    .cr-header__actions {
        flex-wrap: wrap;
    }
}

@media (prefers-reduced-motion: reduce) {
    .cr-scanline, .cr-particle, .cr-header__title, .cr-sync-dot,
    .cr-table tbody tr, .cr-empty__icon, .cr-page-btn.is-active,
    .cr-modal__header::before, .cr-badge--active .cr-badge__dot,
    .cr-badge--draft .cr-badge__dot, .cr-stat__icon, .cr-stat:hover .cr-stat__icon {
        animation: none !important;
    }
    .cr-corner { transition: none; }
}
@media (hover: none) {
    .cr-hud:hover .cr-corner { opacity: 0; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    /* ── Safe count helper ── */
    $courseCount = method_exists($courses, 'total') ? $courses->total() : $courses->count();

    /* ── Stat helpers (guard missing properties) ── */
    $activeCourses   = isset($stats['active'])       ? $stats['active']       : ($courses->where('status','active')->count() ?? 0);
    $instructorCount = isset($stats['instructors'])  ? $stats['instructors'] : 0;

    /* ── Colour palette for course icons (hue from title hash) ── */
    $iconColors = [
        '#6366F1','#8B5CF6','#06B6D4','#10B981',
        '#F59E0B','#EF4444','#EC4899','#3B82F6',
    ];

    /* ── Safe route helper for optional routes (avoids RouteNotFoundException) ── */
    $exportUrl = \Illuminate\Support\Facades\Route::has('staff.courses.export')
        ? route('staff.courses.export')
        : null;
?>

<div class="cr-page">
    <div class="cr-bg">
        <span class="cr-orb cr-orb--1"></span>
        <span class="cr-orb cr-orb--2"></span>
        <span class="cr-orb cr-orb--3"></span>
        <span class="cr-scanline"></span>
        <div class="cr-particles">
            <span class="cr-particle" style="top:12%; left:18%; animation-delay:0s;"></span>
            <span class="cr-particle" style="top:28%; left:72%; animation-delay:.8s;"></span>
            <span class="cr-particle" style="top:55%; left:34%; animation-delay:1.6s;"></span>
            <span class="cr-particle" style="top:68%; left:88%; animation-delay:2.4s;"></span>
            <span class="cr-particle" style="top:40%; left:52%; animation-delay:3.2s;"></span>
            <span class="cr-particle" style="top:80%; left:12%; animation-delay:1.2s;"></span>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="cr-flash cr-flash--success cr-animate" role="alert">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8" stroke="#34D399" stroke-width="1.5"/><path d="M5.5 9l2.5 2.5 4-5" stroke="#34D399" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="cr-flash cr-flash--error cr-animate" role="alert">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8" stroke="#FB7185" stroke-width="1.5"/><path d="M9 5.5v4M9 12h.01" stroke="#FB7185" stroke-width="1.5" stroke-linecap="round"/></svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="cr-header cr-animate">
        <div>
            <div class="cr-header__eyebrow">
                <span class="cr-header__eyebrow-dot"></span>
                Staff Portal · Course Systems
            </div>
            <h1 class="cr-header__title">Course Records</h1>
            <p class="cr-header__subtitle">
                Manage all courses and programs offered by the institution.
                Add, edit, or archive courses and keep instructor assignments current.
            </p>
        </div>
        <div class="cr-header__actions">
            <div class="cr-sync-chip" title="Data is current as of this page load">
                <span class="cr-sync-dot"></span>
                Synced <span id="crSyncTime">just now</span>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($exportUrl): ?>
                <a href="<?php echo e($exportUrl); ?>" class="cr-btn cr-btn--outline">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M7.5 2v8M4 7l3.5 3.5L11 7M2 13h11"/></svg>
                    Export
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <button type="button" class="cr-btn cr-btn--primary" id="openCourseBtn">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M7.5 2v11M2 7.5h11"/></svg>
                Add Course
            </button>
        </div>
    </div>

    
    <div class="cr-stats cr-animate" style="animation-delay:60ms">
        <div class="cr-stat cr-stat--indigo cr-hud">
            <span class="cr-corner cr-corner--tl"></span>
            <span class="cr-corner cr-corner--tr"></span>
            <span class="cr-corner cr-corner--bl"></span>
            <span class="cr-corner cr-corner--br"></span>
            <div class="cr-stat__icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <rect x="3" y="2" width="12" height="15" rx="2"/><path d="M6 6h6M6 9h6M6 12h4"/>
                </svg>
            </div>
            <div class="cr-stat__value" data-count-to="<?php echo e((int) $courseCount); ?>">0</div>
            <div class="cr-stat__label">Total Courses</div>
        </div>
        <div class="cr-stat cr-stat--green cr-hud">
            <span class="cr-corner cr-corner--tl"></span>
            <span class="cr-corner cr-corner--tr"></span>
            <span class="cr-corner cr-corner--bl"></span>
            <span class="cr-corner cr-corner--br"></span>
            <div class="cr-stat__icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <circle cx="9" cy="9" r="7"/><path d="M5.5 9l2.5 2.5 4.5-5"/>
                </svg>
            </div>
            <div class="cr-stat__value" data-count-to="<?php echo e((int) $activeCourses); ?>">0</div>
            <div class="cr-stat__label">Active Courses</div>
        </div>
        <div class="cr-stat cr-stat--amber cr-hud">
            <span class="cr-corner cr-corner--tl"></span>
            <span class="cr-corner cr-corner--tr"></span>
            <span class="cr-corner cr-corner--bl"></span>
            <span class="cr-corner cr-corner--br"></span>
            <div class="cr-stat__icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <circle cx="9" cy="6" r="3"/><path d="M2 16c0-3.314 3.134-6 7-6s7 2.686 7 6"/>
                </svg>
            </div>
            <div class="cr-stat__value" data-count-to="<?php echo e((int) $instructorCount); ?>">0</div>
            <div class="cr-stat__label">Instructors</div>
        </div>
    </div>

    
    <form method="GET" action="<?php echo e(route('staff.courses.index')); ?>" class="cr-toolbar cr-animate cr-hud" style="animation-delay:90ms" id="crFilterForm">
        <span class="cr-corner cr-corner--tl"></span>
        <span class="cr-corner cr-corner--tr"></span>
        <span class="cr-corner cr-corner--bl"></span>
        <span class="cr-corner cr-corner--br"></span>
        <div class="cr-search">
            <svg class="cr-search__icon" width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <circle cx="6.5" cy="6.5" r="4.5"/><path d="M10.5 10.5l3 3"/>
            </svg>
            <input
                type="text"
                name="search"
                class="cr-search__input"
                placeholder="Search by title, code, or instructor…"
                value="<?php echo e(request('search')); ?>"
                aria-label="Search courses"
                autocomplete="off"
            >
            <span class="cr-search__spinner" id="crSearchSpinner"></span>
        </div>

        <select name="status" class="cr-select" onchange="this.form.submit()" aria-label="Filter by status">
            <option value="">All Statuses</option>
            <option value="active"   <?php echo e(request('status') === 'active'   ? 'selected' : ''); ?>>Active</option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            <option value="draft"    <?php echo e(request('status') === 'draft'    ? 'selected' : ''); ?>>Draft</option>
        </select>

        <select name="sort" class="cr-select" onchange="this.form.submit()" aria-label="Sort by">
            <option value="newest" <?php echo e(request('sort','newest') === 'newest' ? 'selected' : ''); ?>>Newest first</option>
            <option value="oldest" <?php echo e(request('sort') === 'oldest' ? 'selected' : ''); ?>>Oldest first</option>
            <option value="title"  <?php echo e(request('sort') === 'title'  ? 'selected' : ''); ?>>Title A–Z</option>
        </select>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search','status','sort'])): ?>
            <a href="<?php echo e(route('staff.courses.index')); ?>" class="cr-btn cr-btn--outline cr-btn--sm">
                Clear
            </a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <span class="cr-toolbar__count">
            <?php echo e($courseCount); ?> <?php echo e($courseCount === 1 ? 'course' : 'courses'); ?>

        </span>
    </form>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($courses->count()): ?>
        <div class="cr-card cr-animate cr-hud" style="animation-delay:110ms">
            <span class="cr-corner cr-corner--tl"></span>
            <span class="cr-corner cr-corner--tr"></span>
            <span class="cr-corner cr-corner--bl"></span>
            <span class="cr-corner cr-corner--br"></span>
            <div class="cr-table-wrap">
                <table class="cr-table" aria-label="Course records">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="crSelectAll" aria-label="Select all courses" style="cursor:pointer">
                            </th>
                            <th class="sortable">Course</th>
                            <th class="sortable">Instructor</th>
                            <th>Units / Hours</th>
                            <th class="sortable">Created</th>
                            <th>Status</th>
                            <th style="text-align:right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            /* ── Safe field resolution ── */
                            $title = $course->course_title ?? $course->title ?? null;
                            if (is_object($title) && method_exists($title,'__toString')) $title = (string)$title;
                            elseif (is_array($title)) $title = json_encode($title);
                            elseif (!is_scalar($title) || trim((string)$title) === '') $title = 'Untitled';
                            $title = e($title);

                            $code = $course->course_code ?? $course->code ?? null;
                            $code = (is_scalar($code) && trim((string)$code) !== '') ? e($code) : null;

                            $instructor = $course->instructor ?? $course->instructor_name ?? $course->instructor_title ?? null;
                            if (is_object($instructor) && method_exists($instructor,'__toString')) $instructor = (string)$instructor;
                            elseif (is_array($instructor)) $instructor = null;
                            $instructor = (is_scalar($instructor) && trim((string)$instructor) !== '') ? e($instructor) : null;

                            $units = $course->units ?? $course->credit_units ?? $course->hours ?? null;
                            $units = (is_scalar($units) && trim((string)$units) !== '') ? e($units) : '—';

                            $createdAt = $course->created_at ?? null;
                            if ($createdAt instanceof \DateTimeInterface) {
                                $createdFormatted = $createdAt->format('M d, Y');
                            } elseif (is_string($createdAt) && trim($createdAt) !== '') {
                                $createdFormatted = \Carbon\Carbon::parse($createdAt)->format('M d, Y');
                            } else {
                                $createdFormatted = '—';
                            }

                            $status = $course->status ?? 'active';
                            if (!in_array($status, ['active','inactive','draft'])) $status = 'active';

                            /* Icon colour deterministic from title */
                            $iconColor = $iconColors[abs(crc32($title)) % count($iconColors)];
                            $initials  = strtoupper(substr(strip_tags($title), 0, 2));

                            /* Instructor initials */
                            $instrInitial = $instructor ? strtoupper(substr($instructor, 0, 1)) : '?';
                        ?>
                        <tr class="cr-row-fade" style="animation-delay:<?php echo e(min($loop->index, 14) * 35); ?>ms">
                            <td>
                                <input type="checkbox" name="selected[]" value="<?php echo e($course->id); ?>" aria-label="Select <?php echo e($title); ?>">
                            </td>
                            <td>
                                <div class="cr-course-cell">
                                    <div class="cr-course-icon" style="background:<?php echo e($iconColor); ?>">
                                        <?php echo e($initials); ?>

                                    </div>
                                    <div>
                                        <div class="cr-course-title"><?php echo e($title); ?></div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($code): ?>
                                        <div class="cr-course-code"><?php echo e($code); ?></div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($instructor): ?>
                                <div class="cr-instructor">
                                    <div class="cr-instructor__avatar"><?php echo e($instrInitial); ?></div>
                                    <?php echo e($instructor); ?>

                                </div>
                                <?php else: ?>
                                <span style="color:var(--cr-text-faint)">—</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td style="color:var(--cr-text);font-weight:500"><?php echo e($units); ?></td>
                            <td style="white-space:nowrap;color:var(--cr-text-dim)"><?php echo e($createdFormatted); ?></td>
                            <td>
                                <span class="cr-badge cr-badge--<?php echo e($status); ?>">
                                    <span class="cr-badge__dot"></span>
                                    <?php echo e(ucfirst($status)); ?>

                                </span>
                            </td>
                            <td>
                                <div class="cr-actions">
                                    <a href="<?php echo e(route('staff.courses.show', $course->id)); ?>"
                                       class="cr-btn cr-btn--outline cr-btn--sm" title="View course">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><ellipse cx="6.5" cy="6.5" rx="4.5" ry="3"/><circle cx="6.5" cy="6.5" r="1.2" fill="currentColor" stroke="none"/></svg>
                                        View
                                    </a>
                                    <a href="<?php echo e(route('staff.courses.edit', $course->id)); ?>"
                                       class="cr-edit-link" aria-label="Edit <?php echo e($title); ?>">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9.5 2.5l1 1-7 7H2.5v-1l7-7z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="<?php echo e(route('staff.courses.destroy', $course->id)); ?>"
                                          onsubmit="return confirmDelete(event, '<?php echo e(addslashes($title)); ?>')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="cr-btn cr-btn--danger cr-btn--sm" title="Delete course">
                                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3.5h9M5 3.5V2h3v1.5M5.5 6v3.5M7.5 6v3.5M3 3.5l.5 7h6l.5-7"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($courses, 'hasPages') && $courses->hasPages()): ?>
            <div class="cr-pagination">
                <span class="cr-pagination__info">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($courses,'firstItem')): ?>
                        Showing <?php echo e($courses->firstItem()); ?>–<?php echo e($courses->lastItem()); ?> of <?php echo e($courses->total()); ?>

                    <?php else: ?>
                        Page <?php echo e($courses->currentPage()); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
                <div class="cr-pagination__pages">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($courses->onFirstPage()): ?>
                        <button type="button" class="cr-page-btn" disabled aria-label="Previous page">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M8.5 10.5l-3-3.5 3-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                        </button>
                    <?php else: ?>
                        <a href="<?php echo e($courses->previousPageUrl()); ?>" class="cr-page-btn" aria-label="Previous page">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M8.5 10.5l-3-3.5 3-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(method_exists($courses,'getUrlRange')): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses->getUrlRange(max(1,$courses->currentPage()-2), min($courses->lastPage(),$courses->currentPage()+2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <a href="<?php echo e($url); ?>" class="cr-page-btn <?php echo e($page == $courses->currentPage() ? 'is-active' : ''); ?>" aria-label="Page <?php echo e($page); ?>" <?php echo e($page == $courses->currentPage() ? 'aria-current=page' : ''); ?>>
                                <?php echo e($page); ?>

                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($courses->hasMorePages()): ?>
                        <a href="<?php echo e($courses->nextPageUrl()); ?>" class="cr-page-btn" aria-label="Next page">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5.5 3.5l3 3.5-3 3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                        </a>
                    <?php else: ?>
                        <button type="button" class="cr-page-btn" disabled aria-label="Next page">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5.5 3.5l3 3.5-3 3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

    <?php else: ?>
        
        <div class="cr-empty cr-animate cr-hud" style="animation-delay:110ms">
            <span class="cr-corner cr-corner--tl"></span>
            <span class="cr-corner cr-corner--tr"></span>
            <span class="cr-corner cr-corner--bl"></span>
            <span class="cr-corner cr-corner--br"></span>
            <div class="cr-empty__icon">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="4" y="3" width="18" height="21" rx="2"/><path d="M9 9h8M9 13h8M9 17h5"/>
                </svg>
            </div>
            <div class="cr-empty__title">No courses found</div>
            <div class="cr-empty__text">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search','status'])): ?>
                    No courses match your current filters. Try adjusting your search.
                <?php else: ?>
                    No courses have been added yet. Get started by adding your first course.
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search','status'])): ?>
                <a href="<?php echo e(route('staff.courses.index')); ?>" class="cr-btn cr-btn--outline">Clear filters</a>
            <?php else: ?>
                <button type="button" class="cr-btn cr-btn--primary" id="openCourseBtnEmpty">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M7 1v12M1 7h12"/></svg>
                    Add First Course
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div id="courseModal"
         class="cr-modal-backdrop"
         hidden
         role="dialog"
         aria-modal="true"
         aria-labelledby="courseModalTitle">

        <div class="cr-modal" role="document">
            <div class="cr-modal__header">
                <div>
                    <div class="cr-modal__title" id="courseModalTitle">Add New Course</div>
                    <div class="cr-modal__subtitle">Enter the course details below to create a new record.</div>
                </div>
                <button type="button" class="cr-modal__close" id="closeCourseBtn" aria-label="Close dialog">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M4 4l10 10M14 4L4 14"/>
                    </svg>
                </button>
            </div>

            <form id="courseForm" method="POST" action="<?php echo e(route('staff.courses.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="cr-modal__body">

                    <div class="cr-field">
                        <label class="cr-label" for="course_title">Course Title <span>*</span></label>
                        <input type="text" id="course_title" name="course_title" class="cr-input"
                               placeholder="e.g. Introduction to Computer Science"
                               maxlength="255" required>
                    </div>

                    <div class="cr-field-row">
                        <div class="cr-field">
                            <label class="cr-label" for="course_code">Course Code</label>
                            <input type="text" id="course_code" name="course_code" class="cr-input"
                                   placeholder="e.g. CS101" maxlength="20">
                            <div class="cr-input-hint">Short identifier used in schedules.</div>
                        </div>
                        <div class="cr-field">
                            <label class="cr-label" for="units">Units / Credit Hours</label>
                            <input type="number" id="units" name="units" class="cr-input"
                                   placeholder="e.g. 3" min="0" max="12" step="0.5">
                        </div>
                    </div>

                    <div class="cr-field">
                        <label class="cr-label" for="instructor">Instructor</label>
                        <input type="text" id="instructor" name="instructor" class="cr-input"
                               placeholder="e.g. Dr. Maria Santos" maxlength="255">
                    </div>

                    <div class="cr-field-row">
                        <div class="cr-field">
                            <label class="cr-label" for="department">Department</label>
                            <input type="text" id="department" name="department" class="cr-input"
                                   placeholder="e.g. College of Engineering" maxlength="255">
                        </div>
                        <div class="cr-field">
                            <label class="cr-label" for="status_field">Status <span>*</span></label>
                            <select id="status_field" name="status" class="cr-input" required>
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="cr-field">
                        <label class="cr-label" for="description">Description</label>
                        <textarea id="description" name="description" class="cr-input"
                                  placeholder="Brief overview of the course content and objectives…"
                                  maxlength="1000"></textarea>
                        <div class="cr-char-count" id="descCharCount">0 / 1,000</div>
                    </div>

                    <input type="hidden" name="title" value="">
                    <input type="hidden" name="category" value="">
                    <input type="hidden" name="duration_hours" value="">
                    <input type="hidden" name="instructor_name" value="">
                    <input type="hidden" name="is_published" value="0">

                </div>
                <div class="cr-modal__footer">
                    <button type="button" class="cr-btn cr-btn--outline" id="cancelCourseBtn">
                        Cancel
                    </button>
                    <button type="submit" class="cr-btn cr-btn--primary" id="saveCourseBtn">
                        <span class="cr-btn__spinner"></span>
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M7 1v12M1 7h12"/></svg>
                        <span>Save Course</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <div id="deleteModal"
         class="cr-modal-backdrop"
         hidden
         role="dialog"
         aria-modal="true"
         aria-labelledby="deleteModalTitle">
        <div class="cr-confirm">
            <div class="cr-confirm__body">
                <div class="cr-confirm__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/>
                    </svg>
                </div>
                <div class="cr-confirm__title" id="deleteModalTitle">Delete course?</div>
                <p class="cr-confirm__text" id="deleteModalText">
                    This will permanently remove this course and cannot be undone.
                </p>
            </div>
            <div class="cr-confirm__footer">
                <button type="button" class="cr-btn cr-btn--outline" id="cancelDeleteBtn">Keep course</button>
                <button type="button" class="cr-btn cr-btn--danger" id="confirmDeleteBtn">
                    <span class="cr-btn__spinner"></span>
                    <span>Yes, delete</span>
                </button>
            </div>
        </div>
    </div>

    
    <div class="cr-toast-stack" id="crToastStack" aria-live="polite"></div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ═══════════════════════════════════════════
       ANIMATED STAT COUNTERS
    ═══════════════════════════════════════════ */
    function animateCount(el) {
        var target = parseInt(el.getAttribute('data-count-to'), 10) || 0;
        var duration = 900;
        var start = null;

        function step(ts) {
            if (start === null) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3); // ease-out-cubic
            el.textContent = Math.round(eased * target).toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.textContent = target.toLocaleString();
            }
        }
        window.requestAnimationFrame(step);
    }

    document.querySelectorAll('[data-count-to]').forEach(function (el, i) {
        setTimeout(function () { animateCount(el); }, 120 + i * 90);
    });

    /* ═══════════════════════════════════════════
       TOASTS
    ═══════════════════════════════════════════ */
    var toastStack = document.getElementById('crToastStack');
    function showToast(message, type) {
        if (!toastStack) return;
        var toast = document.createElement('div');
        toast.className = 'cr-toast cr-toast--' + (type || 'success');
        toast.innerHTML = '<span class="cr-toast__dot"></span><span>' + message + '</span>';
        toastStack.appendChild(toast);
        setTimeout(function () {
            toast.style.transition = 'opacity .25s ease, transform .25s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(12px)';
            setTimeout(function () { toast.remove(); }, 260);
        }, 3200);
    }

    /* ═══════════════════════════════════════════
       SELECT ALL (with indeterminate state)
    ═══════════════════════════════════════════ */
    var selectAll = document.getElementById('crSelectAll');
    var rowCheckboxes = document.querySelectorAll('input[name="selected[]"]');

    function syncSelectAllState() {
        if (!selectAll || !rowCheckboxes.length) return;
        var checkedCount = 0;
        rowCheckboxes.forEach(function (cb) { if (cb.checked) checkedCount++; });
        selectAll.checked = checkedCount === rowCheckboxes.length;
        selectAll.indeterminate = checkedCount > 0 && checkedCount < rowCheckboxes.length;
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            rowCheckboxes.forEach(function (cb) { cb.checked = selectAll.checked; });
            selectAll.indeterminate = false;
        });
    }
    rowCheckboxes.forEach(function (cb) {
        cb.addEventListener('change', syncSelectAllState);
    });

    /* ═══════════════════════════════════════════
       MODAL UTILITIES (animated open/close)
    ═══════════════════════════════════════════ */
    function showModal(modal) {
        if (!modal) return;
        modal.removeAttribute('hidden');
        document.body.style.overflow = 'hidden';
        // force reflow so the transition triggers
        void modal.offsetWidth;
        requestAnimationFrame(function () { modal.classList.add('is-open'); });
    }

    function hideModal(modal) {
        if (!modal) return;
        modal.classList.remove('is-open');
        var done = false;
        function finish() {
            if (done) return;
            done = true;
            modal.setAttribute('hidden', '');
            document.body.style.overflow = '';
            modal.removeEventListener('transitionend', finish);
        }
        modal.addEventListener('transitionend', finish);
        setTimeout(finish, 320); // fallback in case transitionend doesn't fire
    }

    function bindBackdropClose(modal, onClose) {
        if (!modal) return;
        modal.addEventListener('click', function (e) {
            if (e.target === modal) { onClose(); }
        });
    }

    /* ═══════════════════════════════════════════
       ADD COURSE MODAL
    ═══════════════════════════════════════════ */
    var courseModal     = document.getElementById('courseModal');
    var openCourseBtn   = document.getElementById('openCourseBtn');
    var openCourseBtnE  = document.getElementById('openCourseBtnEmpty');
    var closeCourseBtn  = document.getElementById('closeCourseBtn');
    var cancelCourseBtn = document.getElementById('cancelCourseBtn');
    var courseForm      = document.getElementById('courseForm');
    var saveCourseBtn   = document.getElementById('saveCourseBtn');
    var descriptionEl   = document.getElementById('description');
    var descCharCount   = document.getElementById('descCharCount');

    var courseCleanSnap = '';

    function snapCourse() {
        if (!courseForm) return '';
        return Array.from(new FormData(courseForm).entries())
            .map(function (p) { return p[0] + '=' + p[1]; }).join('&');
    }

    function isCourseFormDirty() {
        return snapCourse() !== courseCleanSnap;
    }

    function openCourseModal() {
        if (!courseModal) return;
        if (courseForm) { courseForm.reset(); }
        if (descCharCount) { descCharCount.textContent = '0 / 1,000'; descCharCount.classList.remove('is-near-limit'); }
        courseCleanSnap = snapCourse();
        showModal(courseModal);
        setTimeout(function () {
            var firstInput = courseModal.querySelector('input, select, textarea');
            if (firstInput) { firstInput.focus(); }
        }, 50);
    }

    function closeCourseModal(force) {
        if (!courseModal) return;
        if (!force && isCourseFormDirty()) {
            if (!window.confirm('You have unsaved changes. Discard and close?')) return;
        }
        hideModal(courseModal);
        if (courseForm) { courseForm.reset(); }
        courseCleanSnap = '';
        if (openCourseBtn) { openCourseBtn.focus(); }
    }

    if (openCourseBtn)  { openCourseBtn.addEventListener('click',  function(e){ e.preventDefault(); openCourseModal(); }); }
    if (openCourseBtnE) { openCourseBtnE.addEventListener('click', function(e){ e.preventDefault(); openCourseModal(); }); }

    if (closeCourseBtn) {
        closeCourseBtn.addEventListener('click', function (e) {
            e.preventDefault();
            closeCourseModal(true);
        });
    }

    if (cancelCourseBtn) {
        cancelCourseBtn.addEventListener('click', function (e) {
            e.preventDefault();
            closeCourseModal(false);
        });
    }

    bindBackdropClose(courseModal, function () { closeCourseModal(false); });

    if (descriptionEl && descCharCount) {
        descriptionEl.addEventListener('input', function () {
            var len = descriptionEl.value.length;
            descCharCount.textContent = len.toLocaleString() + ' / 1,000';
            descCharCount.classList.toggle('is-near-limit', len > 900);
        });
    }

    if (courseForm) {
        courseForm.addEventListener('submit', function () {
            courseCleanSnap = snapCourse();
            if (saveCourseBtn) {
                saveCourseBtn.classList.add('is-loading');
                saveCourseBtn.setAttribute('disabled', 'disabled');
            }
        });
    }

    /* ═══════════════════════════════════════════
       DELETE CONFIRMATION MODAL
    ═══════════════════════════════════════════ */
    var deleteModal      = document.getElementById('deleteModal');
    var cancelDeleteBtn  = document.getElementById('cancelDeleteBtn');
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    var deleteModalText  = document.getElementById('deleteModalText');
    var pendingDeleteForm = null;

    window.confirmDelete = function (event, courseTitle) {
        event.preventDefault();
        pendingDeleteForm = event.target;

        if (deleteModalText) {
            deleteModalText.textContent =
                'This will permanently remove "' + courseTitle + '" and all related data. This cannot be undone.';
        }

        showModal(deleteModal);
        setTimeout(function () {
            if (cancelDeleteBtn) { cancelDeleteBtn.focus(); }
        }, 50);
        return false;
    };

    function closeDeleteModal() {
        hideModal(deleteModal);
        pendingDeleteForm = null;
        if (confirmDeleteBtn) {
            confirmDeleteBtn.classList.remove('is-loading');
            confirmDeleteBtn.removeAttribute('disabled');
        }
    }

    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', function () {
            closeDeleteModal();
        });
    }

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            if (pendingDeleteForm) {
                confirmDeleteBtn.classList.add('is-loading');
                confirmDeleteBtn.setAttribute('disabled', 'disabled');
                pendingDeleteForm.submit();
            }
        });
    }

    bindBackdropClose(deleteModal, closeDeleteModal);

    /* ═══════════════════════════════════════════
       ESCAPE KEY — closes whichever modal is open
    ═══════════════════════════════════════════ */
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;

        if (deleteModal && !deleteModal.hasAttribute('hidden')) {
            closeDeleteModal();
            return;
        }
        if (courseModal && !courseModal.hasAttribute('hidden')) {
            closeCourseModal(false);
        }
    });

    /* ═══════════════════════════════════════════
       SEARCH — debounced auto-submit with spinner
    ═══════════════════════════════════════════ */
    var searchInput = document.querySelector('.cr-search__input');
    var searchSpinner = document.getElementById('crSearchSpinner');
    if (searchInput) {
        var debounceTimer;
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            if (searchSpinner) { searchSpinner.classList.add('is-active'); }
            debounceTimer = setTimeout(function () {
                var form = searchInput.closest('form');
                if (form) { form.submit(); }
            }, 500);
        });
        /* Enter key submits immediately and cancels the pending debounce */
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                clearTimeout(debounceTimer);
            }
        });
    }

    /* ═══════════════════════════════════════════
       BUTTON RIPPLE — quick tactile click feedback
    ═══════════════════════════════════════════ */
    if (!prefersReducedMotion) {
        document.querySelectorAll('.cr-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                var rect = btn.getBoundingClientRect();
                var size = Math.max(rect.width, rect.height);
                var ripple = document.createElement('span');
                ripple.className = 'cr-ripple';
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
                ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
                btn.appendChild(ripple);
                setTimeout(function () { ripple.remove(); }, 650);
            });
        });
    }

    /* ═══════════════════════════════════════════
       STAT CARD TILT — subtle HUD-style parallax on pointer devices
    ═══════════════════════════════════════════ */
    if (!prefersReducedMotion && window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        document.querySelectorAll('.cr-stat').forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var x = (e.clientX - rect.left) / rect.width - 0.5;
                var y = (e.clientY - rect.top) / rect.height - 0.5;
                card.style.transform = 'perspective(700px) rotateX(' + (-y * 6) + 'deg) rotateY(' + (x * 6) + 'deg) translateY(-3px)';
            });
            card.addEventListener('mouseleave', function () {
                card.style.transform = '';
            });
        });
    }

    /* ═══════════════════════════════════════════
       LIVE SYNC CHIP — relative "synced X ago" label
    ═══════════════════════════════════════════ */
    var syncTimeEl = document.getElementById('crSyncTime');
    if (syncTimeEl) {
        var syncedAt = Date.now();
        function updateSyncLabel() {
            var secs = Math.round((Date.now() - syncedAt) / 1000);
            var label = secs < 5 ? 'just now' : secs < 60 ? secs + 's ago' : Math.round(secs / 60) + 'm ago';
            syncTimeEl.textContent = label;
        }
        updateSyncLabel();
        setInterval(updateSyncLabel, 5000);
    }

})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\courses\index.blade.php ENDPATH**/ ?>