
<?php $__env->startSection('title', 'Staff Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ============================================================
   Staff Dashboard — futuristic neon-glass system
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap');

:root {
    --db-accent:        #22E2FF;
    --db-accent-light:  rgba(34,226,255,.12);
    --db-accent-dark:   #8B6BFF;
    --db-accent-mid:    #6FD9FF;
    --db-success:       #3DFFB0;
    --db-success-bg:    rgba(61,255,176,.12);
    --db-warning:       #FFB84D;
    --db-warning-bg:    rgba(255,184,77,.12);
    --db-danger:        #FF5D6C;
    --db-danger-bg:     rgba(255,93,108,.12);
    --db-rose:          #FF5EC4;
    --db-rose-bg:       rgba(255,94,196,.12);
    --db-gray-50:       #0C111F;
    --db-gray-100:      #141B2E;
    --db-gray-200:      #202A44;
    --db-gray-300:      #2B3554;
    --db-gray-400:      #5C6584;
    --db-gray-500:      #8B94B3;
    --db-gray-600:      #AAB2CC;
    --db-gray-700:      #C7CEE2;
    --db-gray-900:      #E7ECF9;
    --db-bg-deep:       #0A0E1A;
    --db-card-bg:       rgba(15,21,36,.72);
    --db-radius:        14px;
    --db-radius-sm:     8px;
    --db-radius-lg:     22px;
    --db-shadow:        0 4px 20px -6px rgba(0,0,0,.45);
    --db-shadow-md:     0 16px 44px -12px rgba(34,226,255,.18), 0 6px 20px -4px rgba(0,0,0,.5);
    --db-font:          'Inter', system-ui, -apple-system, sans-serif;
    --db-font-display:  'Space Grotesk', sans-serif;
    --db-font-mono:     'JetBrains Mono', monospace;
}

/* ── Keyframes ── */
@keyframes db-fade-up   { from { opacity:0; transform:translateY(12px) scale(.98);} to { opacity:1; transform:translateY(0) scale(1);} }
@keyframes db-fade      { from { opacity:0; } to { opacity:1; } }
@keyframes db-pulse-ring {
    0%   { box-shadow: 0 0 0 0 rgba(61,255,176,.55); }
    70%  { box-shadow: 0 0 0 8px rgba(61,255,176,0); }
    100% { box-shadow: 0 0 0 0 rgba(61,255,176,0); }
}
@keyframes db-progress  { from { width: 0; } }
@keyframes db-spin      { to { transform:rotate(360deg); } }
@keyframes db-float     { 0%,100%{ transform:translate(0,0) scale(1);} 50%{ transform:translate(24px,-20px) scale(1.08);} }
@keyframes db-scan-line { 0%{ top:-140px;} 100%{ top:110%;} }
@keyframes db-shimmer   { 0%{ transform:translateX(-100%);} 100%{ transform:translateX(100%);} }
@keyframes db-ring-spin { to { transform:rotate(360deg); } }

.db-animate      { animation: db-fade-up .5s cubic-bezier(.4,0,.2,1) both; }
.db-row-fade     { animation: db-fade .3s ease-out both; }
.db-live-dot     { animation: db-pulse-ring 2s ease-out infinite; }
.db-spin         { animation: db-spin .8s linear infinite; }

@media (prefers-reduced-motion: reduce) {
    .db-animate, .db-row-fade, .db-live-dot, .db-spin { animation: none !important; transition: none !important; }
    .db-page::before, .db-page::after, .db-banner::before, .db-banner::after,
    .db-stat__icon::before, .db-attendance__fill::after { animation: none !important; }
}

/* ── Page shell + ambience ── */
.db-page {
    position: relative;
    isolation: isolate;
    font-family: var(--db-font);
    color: var(--db-gray-900);
    max-width: 1340px;
    margin: 0 auto;
    background:
        radial-gradient(700px circle at 6% -12%, rgba(34,226,255,.12), transparent 60%),
        radial-gradient(700px circle at 96% 108%, rgba(139,107,255,.12), transparent 60%),
        var(--db-bg-deep);
    border-radius: var(--db-radius-lg);
    padding: 30px 30px 42px;
    box-shadow: 0 30px 80px -30px rgba(0,0,0,.65), 0 0 0 1px #1B2338;
    overflow: hidden;
}
.db-page::before {
    content: '';
    position: absolute; inset: 0; z-index: 0; pointer-events: none;
    background-image:
        linear-gradient(#182038 1px, transparent 1px),
        linear-gradient(90deg, #182038 1px, transparent 1px);
    background-size: 42px 42px;
    opacity: .22;
    mask-image: radial-gradient(ellipse 80% 55% at 50% 0%, #000 40%, transparent 92%);
}
.db-page::after {
    content: '';
    position: absolute; left: 0; right: 0; height: 140px; z-index: 0; pointer-events: none;
    background: linear-gradient(180deg, transparent, rgba(34,226,255,.05), transparent);
    animation: db-scan-line 9s linear infinite;
}
.db-page > * { position: relative; z-index: 1; }

/* ── Welcome banner ── */
.db-banner {
    background:
        linear-gradient(120deg, rgba(34,226,255,.14) 0%, rgba(139,107,255,.16) 100%),
        linear-gradient(180deg, rgba(255,255,255,.03), rgba(255,255,255,0));
    border: 1px solid rgba(34,226,255,.28);
    border-radius: var(--db-radius-lg);
    padding: 28px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(14px);
    box-shadow: 0 8px 30px -14px rgba(34,226,255,.3), inset 0 1px 0 rgba(255,255,255,.05);
}
.db-banner::before {
    content: '';
    position: absolute;
    top: -50px; right: -40px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(34,226,255,.3), transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    filter: blur(6px);
    animation: db-float 15s ease-in-out infinite;
}
.db-banner::after {
    content: '';
    position: absolute;
    bottom: -70px; right: 130px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(139,107,255,.24), transparent 70%);
    border-radius: 50%;
    pointer-events: none;
    filter: blur(6px);
    animation: db-float 15s ease-in-out infinite;
    animation-delay: -7.5s;
}
.db-banner__greeting {
    font-family: var(--db-font-mono);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--db-accent);
    margin-bottom: 6px;
}
.db-banner__name {
    font-family: var(--db-font-display);
    font-size: 23px;
    font-weight: 700;
    color: #fff;
    letter-spacing: -.3px;
    line-height: 1.2;
    text-shadow: 0 0 26px rgba(34,226,255,.25);
}
.db-banner__sub {
    margin-top: 6px;
    font-size: 13.5px;
    color: rgba(231,236,249,.7);
}
.db-banner__right {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}
.db-clock-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 14px;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 99px;
    font-size: 12.5px;
    font-weight: 500;
    color: #fff;
    backdrop-filter: blur(4px);
    transition: background .2s ease, border-color .2s ease;
}
.db-clock-badge.is-out {
    background: rgba(255,255,255,.04);
    border-color: rgba(255,255,255,.1);
    color: rgba(231,236,249,.6);
}
.db-clock-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--db-success);
    box-shadow: 0 0 8px 1px var(--db-success);
    flex-shrink: 0;
}
.db-clock-dot.is-out { background: rgba(231,236,249,.3); box-shadow: none; }
.db-banner__date {
    font-family: var(--db-font-mono);
    font-size: 12px;
    color: rgba(231,236,249,.55);
    white-space: nowrap;
}

/* ── Flash region ── */
.db-flash-region { margin-bottom: 18px; display: flex; flex-direction: column; gap: 8px; }
.db-flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--db-radius);
    font-size: 13.5px;
    font-weight: 500;
    animation: db-fade-up .35s ease-out;
    transition: opacity .25s ease, transform .25s ease;
    backdrop-filter: blur(8px);
}
.db-flash.is-leaving { opacity: 0; transform: translateY(-5px); }
.db-flash--success { background: var(--db-success-bg); color: #8FFBCD; border: 1px solid rgba(61,255,176,.35); }
.db-flash--error   { background: var(--db-danger-bg); color: #FFC2C9; border: 1px solid rgba(255,93,108,.35); }

/* ── Stat cards ── */
.db-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
.db-stat {
    background:
        linear-gradient(180deg, rgba(255,255,255,.035), rgba(255,255,255,0)),
        var(--db-card-bg);
    border: 1px solid var(--db-gray-200);
    border-radius: var(--db-radius);
    padding: 20px;
    box-shadow: var(--db-shadow);
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
    transition: transform .25s cubic-bezier(.4,0,.2,1), box-shadow .25s ease, border-color .25s ease;
}
.db-stat::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, var(--db-accent), var(--db-accent-dark));
    opacity: .35;
    transition: opacity .25s ease;
}
.db-stat:hover {
    transform: translateY(-4px);
    box-shadow: var(--db-shadow-md);
    border-color: rgba(34,226,255,.35);
}
.db-stat:hover::before { opacity: 1; }
.db-stat__top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 12px;
}
.db-stat__label {
    font-size: 12px;
    font-weight: 600;
    color: var(--db-gray-500);
    letter-spacing: .02em;
}
.db-stat__icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    position: relative;
}
.db-stat__icon::before {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 12px;
    background: conic-gradient(from 0deg, transparent, currentColor, transparent 65%);
    opacity: .3;
    animation: db-ring-spin 4.5s linear infinite;
}
.db-stat__icon svg { position: relative; z-index: 1; }
.db-stat__value {
    font-family: var(--db-font-mono);
    font-size: 28px;
    font-weight: 600;
    letter-spacing: -.4px;
    line-height: 1;
    color: var(--db-gray-900);
}
.db-stat__sub {
    font-size: 11.5px;
    color: var(--db-gray-400);
    margin-top: 6px;
}
.db-stat__bar {
    margin-top: 14px;
    height: 4px;
    background: var(--db-gray-100);
    border-radius: 99px;
    overflow: hidden;
}
.db-stat__bar-fill {
    height: 100%;
    border-radius: 99px;
    animation: db-progress .9s ease-out both;
    animation-delay: .3s;
    box-shadow: 0 0 8px 0 rgba(34,226,255,.45);
}
.db-stat__trend {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 11px;
    font-weight: 600;
    margin-top: 8px;
}
.db-stat__trend--up   { color: var(--db-success); }
.db-stat__trend--down { color: var(--db-danger); }

/* Icon colour helpers */
.db-icon--indigo { background: var(--db-accent-light); color: var(--db-accent); }
.db-icon--green  { background: var(--db-success-bg);   color: var(--db-success); }
.db-icon--amber  { background: var(--db-warning-bg);   color: var(--db-warning); }
.db-icon--rose   { background: var(--db-rose-bg);      color: var(--db-rose); }

/* ── Card ── */
.db-card {
    background: var(--db-card-bg);
    border: 1px solid var(--db-gray-200);
    border-radius: var(--db-radius);
    box-shadow: var(--db-shadow);
    overflow: hidden;
    backdrop-filter: blur(10px);
    transition: border-color .25s ease, box-shadow .25s ease;
}
.db-card:hover { border-color: rgba(34,226,255,.22); box-shadow: var(--db-shadow-md); }
.db-card__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px 14px;
    border-bottom: 1px solid var(--db-gray-100);
}
.db-card__title {
    font-family: var(--db-font-display);
    font-size: 15px;
    font-weight: 600;
    color: var(--db-gray-900);
}
.db-card__body { padding: 0; }
.db-card__footer {
    padding: 12px 20px;
    border-top: 1px solid var(--db-gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ── Link ── */
.db-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 13px;
    color: var(--db-accent);
    font-weight: 500;
    text-decoration: none;
    transition: opacity .15s ease;
}
.db-link:hover { opacity: .75; text-decoration: none; }

/* ── Buttons ── */
.db-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: var(--db-radius-sm);
    font-size: 13.5px;
    font-weight: 500;
    font-family: var(--db-font);
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: background .15s ease, transform .12s ease, box-shadow .15s ease, border-color .15s ease, filter .15s ease;
    white-space: nowrap;
    line-height: 1;
}
.db-btn:active { transform: scale(.97); }
.db-btn--primary {
    background: linear-gradient(100deg, var(--db-accent), var(--db-accent-dark));
    color: #06101C;
    font-weight: 700;
    box-shadow: 0 8px 22px -8px rgba(34,226,255,.55);
}
.db-btn--primary:hover { filter: brightness(1.07); box-shadow: 0 10px 28px -6px rgba(139,107,255,.6); transform: translateY(-1px); color: #06101C; }
.db-btn--secondary {
    background: rgba(255,255,255,.04);
    color: var(--db-gray-700);
    border: 1px solid var(--db-gray-200);
}
.db-btn--secondary:hover { background: rgba(34,226,255,.08); color: var(--db-gray-900); border-color: rgba(34,226,255,.3); text-decoration: none; }
.db-btn--danger {
    background: var(--db-danger-bg);
    color: var(--db-danger);
    border: 1px solid rgba(255,93,108,.32);
}
.db-btn--danger:hover { background: rgba(255,93,108,.18); text-decoration: none; }
.db-btn--ghost {
    background: transparent;
    color: var(--db-gray-500);
    padding: 6px 10px;
}
.db-btn--ghost:hover { background: rgba(255,255,255,.05); color: var(--db-gray-900); text-decoration: none; }
.db-btn--sm { padding: 5px 10px; font-size: 12px; }
.db-btn[disabled] { opacity: .5; pointer-events: none; }
.db-btn svg { flex-shrink: 0; }

/* ── Quick Actions ── */
.db-quick {
    background: var(--db-card-bg);
    border: 1px solid var(--db-gray-200);
    border-radius: var(--db-radius);
    padding: 20px;
    box-shadow: var(--db-shadow);
    margin-bottom: 24px;
    backdrop-filter: blur(10px);
}
.db-quick__title {
    font-family: var(--db-font-display);
    font-size: 15px;
    font-weight: 600;
    color: var(--db-gray-900);
    margin-bottom: 14px;
}
.db-quick__grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

/* ── Main layout ── */
.db-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
}
.db-sidebar { display: flex; flex-direction: column; gap: 20px; }

/* ── Tasks table ── */
.db-task-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
.db-task-table th {
    padding: 10px 16px;
    text-align: left;
    font-family: var(--db-font-mono);
    font-size: 10.5px;
    font-weight: 500;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: var(--db-gray-400);
    background: rgba(255,255,255,.02);
    border-bottom: 1px solid var(--db-gray-200);
}
.db-task-table td {
    padding: 13px 16px;
    border-bottom: 1px solid var(--db-gray-100);
    vertical-align: middle;
    color: var(--db-gray-600);
}
.db-task-table tbody tr:last-child td { border-bottom: none; }
.db-task-table tbody tr { transition: background .15s ease; }
.db-task-table tbody tr:hover { background: rgba(34,226,255,.05); }
.db-task-row.is-removing { opacity: 0; transform: translateX(8px); transition: opacity .25s ease, transform .25s ease; }

/* Task priority dot */
.db-priority { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; display: inline-block; }
.db-priority--high   { background: var(--db-danger);  box-shadow: 0 0 7px 1px rgba(255,93,108,.6); }
.db-priority--medium { background: var(--db-warning); box-shadow: 0 0 7px 1px rgba(255,184,77,.55); }
.db-priority--low    { background: var(--db-success); box-shadow: 0 0 7px 1px rgba(61,255,176,.55); }

/* Status badges */
.db-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 9px;
    border-radius: 99px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}
.db-badge--completed   { background: var(--db-success-bg); color: var(--db-success); }
.db-badge--in-progress { background: var(--db-accent-light); color: var(--db-accent); }
.db-badge--pending     { background: var(--db-warning-bg); color: var(--db-warning); }
.db-badge--overdue     { background: var(--db-danger-bg); color: var(--db-danger); }

/* Task filter tabs */
.db-tabs { display: flex; gap: 4px; }
.db-tab {
    padding: 5px 12px;
    border-radius: var(--db-radius-sm);
    font-size: 12.5px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    background: transparent;
    color: var(--db-gray-500);
    font-family: var(--db-font);
    transition: background .15s ease, color .15s ease;
}
.db-tab:hover { background: rgba(255,255,255,.05); color: var(--db-gray-900); }
.db-tab.is-active { background: var(--db-accent-light); color: var(--db-accent); font-weight: 600; box-shadow: inset 0 0 0 1px rgba(34,226,255,.3); }

/* ── Schedule timeline ── */
.db-timeline { padding: 4px 20px 16px; }
.db-timeline-item {
    display: flex;
    gap: 12px;
    padding: 10px 0;
    position: relative;
}
.db-timeline-item + .db-timeline-item { border-top: 1px solid var(--db-gray-100); }
.db-timeline-item.is-now .db-timeline__time { color: var(--db-accent); font-weight: 700; }
.db-timeline-item.is-now .db-timeline__dot { background: var(--db-accent); box-shadow: 0 0 9px 2px rgba(34,226,255,.6); }
.db-timeline__dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--db-gray-300);
    flex-shrink: 0;
    margin-top: 5px;
    transition: background .2s ease, box-shadow .2s ease;
}
.db-timeline__time {
    font-family: var(--db-font-mono);
    font-size: 11.5px;
    font-weight: 500;
    color: var(--db-gray-400);
    width: 58px;
    flex-shrink: 0;
    padding-top: 1px;
}
.db-timeline__event { font-size: 13px; color: var(--db-gray-700); font-weight: 500; }
.db-timeline__sub   { font-size: 11.5px; color: var(--db-gray-400); margin-top: 1px; }

/* ── Notifications ── */
.db-notif-list { padding: 0 0 8px; }
.db-notif {
    display: flex;
    gap: 12px;
    padding: 13px 20px;
    border-bottom: 1px solid var(--db-gray-100);
    transition: background .15s ease;
}
.db-notif:last-child { border-bottom: none; }
.db-notif:hover { background: rgba(255,255,255,.025); }
.db-notif__dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 5px;
    transition: opacity .3s ease;
}
.db-notif--info    .db-notif__dot { background: var(--db-accent);  box-shadow: 0 0 7px 1px rgba(34,226,255,.5); }
.db-notif--success .db-notif__dot { background: var(--db-success); box-shadow: 0 0 7px 1px rgba(61,255,176,.5); }
.db-notif--warning .db-notif__dot { background: var(--db-warning); box-shadow: 0 0 7px 1px rgba(255,184,77,.5); }
.db-notif--danger  .db-notif__dot { background: var(--db-danger);  box-shadow: 0 0 7px 1px rgba(255,93,108,.5); }
.db-notif__text { font-size: 13px; color: var(--db-gray-700); line-height: 1.5; }
.db-notif__time { font-size: 11.5px; color: var(--db-gray-400); margin-top: 2px; }
.db-notif-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px; height: 18px;
    background: var(--db-danger);
    color: #06101C;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 700;
    padding: 0 4px;
    box-shadow: 0 0 8px 0 rgba(255,93,108,.5);
}

/* ── Attendance widget ── */
.db-attendance {
    padding: 16px 20px;
}
.db-attendance__label {
    font-family: var(--db-font-mono);
    font-size: 10.5px;
    font-weight: 500;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--db-gray-400);
    margin-bottom: 10px;
}
.db-attendance__bar {
    height: 8px;
    background: var(--db-gray-100);
    border-radius: 99px;
    overflow: hidden;
    margin-bottom: 8px;
}
.db-attendance__fill {
    position: relative;
    height: 100%;
    background: linear-gradient(90deg, var(--db-accent) 0%, var(--db-accent-dark) 100%);
    border-radius: 99px;
    overflow: hidden;
    animation: db-progress .9s ease-out both;
    animation-delay: .5s;
    box-shadow: 0 0 10px 0 rgba(34,226,255,.4);
}
.db-attendance__fill::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.4), transparent);
    animation: db-shimmer 2.6s linear infinite;
}
.db-attendance__meta {
    display: flex;
    justify-content: space-between;
    font-family: var(--db-font-mono);
    font-size: 11.5px;
    color: var(--db-gray-500);
}
.db-attendance__val { font-weight: 700; color: var(--db-gray-900); }
.db-attendance__days {
    display: flex;
    gap: 4px;
    margin-top: 12px;
}
.db-att-day {
    flex: 1;
    height: 28px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
    font-weight: 600;
    color: var(--db-gray-400);
    background: rgba(255,255,255,.03);
    border: 1px solid var(--db-gray-100);
    transition: background .2s ease, color .2s ease;
}
.db-att-day--present { background: var(--db-accent-light); color: var(--db-accent); border-color: rgba(34,226,255,.25); }
.db-att-day--absent  { background: var(--db-danger-bg); color: var(--db-danger); border-color: rgba(255,93,108,.25); }
.db-att-day--today   { background: var(--db-accent); color: #06101C; border-color: transparent; box-shadow: 0 0 12px -2px rgba(34,226,255,.7); }

/* ── Responsive ── */
@media (max-width: 1100px) {
    .db-grid { grid-template-columns: 1fr; }
    .db-sidebar { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
}
@media (max-width: 900px) {
    .db-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .db-stats { grid-template-columns: 1fr 1fr; gap: 10px; }
    .db-sidebar { grid-template-columns: 1fr; }
    .db-banner { padding: 20px; }
    .db-page { padding: 18px 16px 30px; }
}
@media (max-width: 420px) {
    .db-stats { grid-template-columns: 1fr; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
/* ── Clock state ── */
$clockedIn      = session('staff_clocked_in', false);
$clockedInSince = session('staff_clock_since', null);

/* ── Greeting ── */
$hour     = now()->hour;
$greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
$userName = auth()->user()->name ?? 'Staff';

/* ── Stats ── */
$stats = $stats ?? [
    [
        'label'    => 'Tasks Due Today',
        'value'    => 8,
        'sub'      => '3 of 8 completed',
        'icon'     => 'tasks',
        'iconClass'=> 'db-icon--indigo',
        'progress' => 3/8,
        'barColor' => 'background:var(--db-accent)',
        'trend'    => '+2 from yesterday',
        'trendDir' => 'up',
    ],
    [
        'label'    => 'Pending Approvals',
        'value'    => 3,
        'sub'      => 'Needs your review',
        'icon'     => 'clock',
        'iconClass'=> 'db-icon--amber',
        'progress' => null,
        'trend'    => '1 urgent',
        'trendDir' => 'down',
    ],
    [
        'label'    => 'Unread Messages',
        'value'    => 5,
        'sub'      => '2 marked urgent',
        'icon'     => 'mail',
        'iconClass'=> 'db-icon--rose',
        'progress' => null,
        'trend'    => 'New since 9 AM',
        'trendDir' => 'down',
    ],
    [
        'label'    => 'Hours This Week',
        'value'    => '32.5',
        'sub'      => 'of 40 scheduled',
        'icon'     => 'chart',
        'iconClass'=> 'db-icon--green',
        'progress' => 32.5/40,
        'barColor' => 'background:var(--db-success)',
        'trend'    => '81% complete',
        'trendDir' => 'up',
    ],
];

/* ── Tasks ── */
$tasks = $tasks ?? session('staff_tasks', [
    ['title'=>'Restock inventory — Aisle 4',     'status'=>'In Progress','due'=>'Today, 2:00 PM',   'priority'=>'high'],
    ['title'=>'Submit weekly report',             'status'=>'Pending',    'due'=>'Today, 5:00 PM',   'priority'=>'high'],
    ['title'=>'Customer follow-up call',          'status'=>'Completed',  'due'=>'Yesterday',         'priority'=>'low'],
    ['title'=>'Update product listings',          'status'=>'Pending',    'due'=>'Tomorrow',           'priority'=>'medium'],
    ['title'=>'Train new hire on POS system',     'status'=>'In Progress','due'=>'Tomorrow, 10:00 AM','priority'=>'medium'],
    ['title'=>'Prepare Q3 inventory audit brief', 'status'=>'Pending',    'due'=>'Fri, 4:00 PM',     'priority'=>'low'],
]);

/* ── Schedule ── */
$schedule = $schedule ?? [
    ['time'=>'9:00 AM',  'event'=>'Shift starts',          'sub'=>'Floor assignment — Zone B'],
    ['time'=>'11:00 AM', 'event'=>'Inventory check',        'sub'=>'Aisle 3–6 with team'],
    ['time'=>'12:00 PM', 'event'=>'Team standup',           'sub'=>'Conference Room 2'],
    ['time'=>'1:00 PM',  'event'=>'Lunch break',            'sub'=>'30 minutes'],
    ['time'=>'3:30 PM',  'event'=>'1:1 with supervisor',    'sub'=>'Performance review prep'],
    ['time'=>'5:00 PM',  'event'=>'Shift ends',             'sub'=>'Handover to evening team'],
];

/* ── Notifications ── */
$notifications = $notifications ?? [
    ['text'=>'Your leave request was approved.',          'time'=>'1h ago',      'type'=>'success'],
    ['text'=>'New scheduling policy — effective Monday.', 'time'=>'3h ago',      'type'=>'warning'],
    ['text'=>'Manager commented on your weekly report.',  'time'=>'Yesterday',   'type'=>'info'],
    ['text'=>'Pending approval: 3 items need sign-off.',  'time'=>'Yesterday',   'type'=>'danger'],
    ['text'=>'System maintenance this Saturday 2–4 AM.',  'time'=>'2 days ago',  'type'=>'info'],
];

/* ── Attendance days (Mon–Fri this week) ── */
$attendanceDays = $attendanceDays ?? [
    ['label'=>'M','state'=>'present'],
    ['label'=>'T','state'=>'present'],
    ['label'=>'W','state'=>'present'],
    ['label'=>'T','state'=>'today'],
    ['label'=>'F','state'=>''],
];

/* ── Badge map ── */
$statusBadge = [
    'Completed'   => 'db-badge--completed',
    'In Progress' => 'db-badge--in-progress',
    'Pending'     => 'db-badge--pending',
    'Overdue'     => 'db-badge--overdue',
];

/* ── Inline SVG helper ── */
$icon = function(string $k): string {
    return match($k) {
        'tasks'    => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><rect x="5" y="3" width="11" height="15" rx="2"/><path d="M8 3v-.5A.5.5 0 0 1 8.5 2h3a.5.5 0 0 1 .5.5V3"/><path d="M8 10l1.5 1.5L13 8"/><path d="M8 14h4"/></svg>',
        'clock'    => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="18" height="18"><circle cx="10" cy="10" r="7.5"/><path d="M10 6.5V10l2.5 1.5"/></svg>',
        'mail'     => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="18" height="18"><rect x="3" y="5" width="14" height="11" rx="2"/><path d="M3.5 6.5l6.5 4.5 6.5-4.5"/></svg>',
        'chart'    => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="18" height="18"><path d="M3.5 16V11"/><path d="M8 16V5.5"/><path d="M12.5 16v-7"/><path d="M17 16v-4"/><path d="M3 16.5h14"/></svg>',
        'plus'     => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" width="16" height="16"><path d="M10 4v12M4 10h12"/></svg>',
        'calendar' => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="16" height="16"><rect x="3" y="4.5" width="14" height="13" rx="2"/><path d="M3 8.5h14"/><path d="M7 2.5v3M13 2.5v3"/></svg>',
        'chat'     => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="16" height="16"><path d="M3 5h14v9H8l-4 3V5z"/></svg>',
        'arrow'    => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="13" height="13"><path d="M3 8h10M9 4l4 4-4 4"/></svg>',
        'leave'    => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="16" height="16"><rect x="3" y="4.5" width="14" height="13" rx="2"/><path d="M3 8.5h14M7 2.5v3M13 2.5v3"/><path d="M7 12h6"/></svg>',
        'report'   => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="16" height="16"><rect x="4" y="2.5" width="12" height="16" rx="2"/><path d="M7 7h6M7 10h6M7 13h4"/></svg>',
        'up'       => '<svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" width="11" height="11"><path d="M6 9.5V2.5M2.5 6L6 2.5 9.5 6"/></svg>',
        'down'     => '<svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" width="11" height="11"><path d="M6 2.5v7M2.5 6L6 9.5 9.5 6"/></svg>',
        'check'    => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="14" height="14"><path d="M3 8l3.5 3.5 6-7"/></svg>',
        'x'        => '<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="14" height="14"><path d="M4 4l8 8M12 4l-8 8"/></svg>',
        'bell'     => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="16" height="16"><path d="M10 2.5a6 6 0 0 1 6 6v3.5l1.5 2H2.5L4 12V8.5a6 6 0 0 1 6-6z"/><path d="M8.5 17a1.5 1.5 0 0 0 3 0"/></svg>',
        'support'  => '<svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" width="16" height="16"><circle cx="10" cy="10" r="7.5"/><path d="M10 13v.5"/><path d="M10 7a2 2 0 0 1 2 2 2 2 0 0 1-1.5 1.94c-.5.12-.5.56-.5.56"/></svg>',
        default    => '',
    };
};

/* Current time for schedule highlight */
$nowMinutes = now()->hour * 60 + now()->minute;
$scheduleMinutes = function(string $t) {
    preg_match('/(\d+):(\d+)\s*(AM|PM)/i', $t, $m);
    if (!$m) return -1;
    $h = (int)$m[1]; $min = (int)$m[2]; $ap = strtoupper($m[3]);
    if ($ap === 'PM' && $h !== 12) $h += 12;
    if ($ap === 'AM' && $h === 12) $h = 0;
    return $h * 60 + $min;
};
?>

<div class="db-page">

    
    <?php if(session('success')): ?>
    <div class="db-flash db-flash--success db-animate" role="alert">
        <svg viewBox="0 0 18 18" fill="none" width="16" height="16"><circle cx="9" cy="9" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 9l2.5 2.5 4-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="db-flash db-flash--error db-animate" role="alert">
        <svg viewBox="0 0 18 18" fill="none" width="16" height="16"><circle cx="9" cy="9" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M9 5.5v4M9 12h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    
    <div id="db-flash-region" class="db-flash-region" aria-live="polite"></div>

    
    <div class="db-banner db-animate" style="animation-delay:0ms">
        <div>
            <div class="db-banner__greeting"><?php echo e($greeting); ?></div>
            <div class="db-banner__name"><?php echo e($userName); ?></div>
            <div class="db-banner__sub">Here's what's on your plate today. Stay focused.</div>
        </div>
        <div class="db-banner__right">
            <div id="db-clock-badge" class="db-clock-badge <?php echo e($clockedIn ? '' : 'is-out'); ?>">
                <span id="db-clock-dot" class="db-clock-dot <?php echo e($clockedIn ? 'db-live-dot' : 'is-out'); ?>"></span>
                <span id="db-clock-text">
                    <?php echo e($clockedIn ? ('Clocked in since '.($clockedInSince ?? now()->format('g:i A'))) : 'Not clocked in'); ?>

                </span>
            </div>
            <div class="db-banner__date"><?php echo e(now()->format('l, F j, Y')); ?></div>
        </div>
    </div>

    
    <div class="db-stats">
        <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="db-stat db-animate" style="animation-delay:<?php echo e(60 + $i*60); ?>ms">
            <div class="db-stat__top">
                <div class="db-stat__label"><?php echo e($stat['label']); ?></div>
                <div class="db-stat__icon <?php echo e($stat['iconClass']); ?>">
                    <?php echo $icon($stat['icon']); ?>

                </div>
            </div>
            <div class="db-stat__value"><?php echo e($stat['value']); ?></div>
            <div class="db-stat__sub"><?php echo e($stat['sub']); ?></div>
            <?php if($stat['progress'] ?? null): ?>
            <div class="db-stat__bar">
                <div class="db-stat__bar-fill" style="<?php echo e($stat['barColor'] ?? 'background:var(--db-accent)'); ?>;width:<?php echo e(round($stat['progress']*100)); ?>%"></div>
            </div>
            <?php endif; ?>
            <?php if($stat['trend'] ?? null): ?>
            <div class="db-stat__trend db-stat__trend--<?php echo e($stat['trendDir'] ?? 'up'); ?>">
                <?php echo $icon($stat['trendDir'] ?? 'up'); ?>

                <?php echo e($stat['trend']); ?>

            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="db-quick db-animate" style="animation-delay:300ms">
        <div class="db-quick__title">Quick Actions</div>
        <div class="db-quick__grid">

            
            <form method="POST" action="<?php echo e(route('staff.clock.toggle')); ?>" id="db-clock-form">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        id="db-clock-btn"
                        class="db-btn db-btn--primary"
                        aria-pressed="<?php echo e($clockedIn ? 'true' : 'false'); ?>">
                    <?php echo $icon('clock'); ?>

                    <span id="db-clock-label"><?php echo e($clockedIn ? 'Clock Out' : 'Clock In'); ?></span>
                    <span id="db-clock-spinner" class="db-spin" hidden>
                        <svg viewBox="0 0 16 16" fill="none" width="14" height="14"><circle cx="8" cy="8" r="6" stroke="rgba(6,16,28,.35)" stroke-width="2"/><path d="M8 2a6 6 0 0 1 6 6" stroke="#06101C" stroke-width="2" stroke-linecap="round"/></svg>
                    </span>
                </button>
            </form>

            <a href="<?php echo e(route('staff.tasks.create')); ?>" class="db-btn db-btn--secondary">
                <?php echo $icon('plus'); ?> New Task
            </a>
            <a href="<?php echo e(route('staff.leave.request')); ?>" class="db-btn db-btn--secondary">
                <?php echo $icon('leave'); ?> Request Leave
            </a>
            <a href="<?php echo e(route('staff.schedule.index')); ?>" class="db-btn db-btn--secondary">
                <?php echo $icon('calendar'); ?> Full Schedule
            </a>
            <a href="<?php echo e(route('staff.reports.index') ?? '#'); ?>" class="db-btn db-btn--secondary">
                <?php echo $icon('report'); ?> My Reports
            </a>
            <a href="<?php echo e(route('staff.support.index')); ?>" class="db-btn db-btn--secondary">
                <?php echo $icon('support'); ?> Contact Support
            </a>
        </div>
    </div>

    
    <div class="db-grid">

        
        <div class="db-card db-animate" style="animation-delay:340ms">
            <div class="db-card__header">
                <div style="display:flex;align-items:center;gap:10px">
                    <span class="db-card__title">My Tasks</span>
                    <span id="db-tasks-count"
                          style="background:var(--db-accent);color:#06101C;border-radius:99px;font-size:11px;font-weight:700;padding:2px 8px">
                        <?php echo e(count(array_filter($tasks, fn($t) => $t['status'] !== 'Completed'))); ?>

                    </span>
                </div>
                <div style="display:flex;align-items:center;gap:8px">
                    <div class="db-tabs" role="tablist">
                        <button class="db-tab is-active" data-filter="all" role="tab" aria-selected="true">All</button>
                        <button class="db-tab" data-filter="Pending" role="tab">Pending</button>
                        <button class="db-tab" data-filter="In Progress" role="tab">Active</button>
                        <button class="db-tab" data-filter="Completed" role="tab">Done</button>
                    </div>
                    <a href="#" class="db-link" style="font-size:13px">
                        View all <?php echo $icon('arrow'); ?>

                    </a>
                </div>
            </div>
            <div class="db-card__body">
                <table class="db-task-table" aria-label="My tasks">
                    <thead>
                        <tr>
                            <th style="width:28px"></th>
                            <th>Task</th>
                            <th style="width:110px">Status</th>
                            <th style="width:140px">Due</th>
                            <th style="width:60px;text-align:right">Priority</th>
                            <th style="width:40px"></th>
                        </tr>
                    </thead>
                    <tbody id="db-tasks-body">
                        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusKey = $task['status'] ?? 'Pending';
                            $badgeClass = $statusBadge[$statusKey] ?? 'db-badge--pending';
                            $priority = $task['priority'] ?? 'medium';
                        ?>
                        <tr class="db-task-row db-row-fade"
                            data-task-index="<?php echo e($i); ?>"
                            data-status="<?php echo e($statusKey); ?>"
                            style="animation-delay:<?php echo e(min($i,8)*30); ?>ms">
                            <td>
                                <input type="checkbox"
                                       aria-label="Mark complete: <?php echo e($task['title']); ?>"
                                       <?php echo e($statusKey === 'Completed' ? 'checked' : ''); ?>

                                       style="cursor:pointer;accent-color:var(--db-accent)"
                                       class="js-task-check"
                                       data-index="<?php echo e($i); ?>">
                            </td>
                            <td>
                                <span style="color:var(--db-gray-900);font-weight:500"><?php echo e($task['title']); ?></span>
                            </td>
                            <td>
                                <span class="db-badge <?php echo e($badgeClass); ?>"><?php echo e($statusKey); ?></span>
                            </td>
                            <td style="font-size:12.5px;white-space:nowrap"><?php echo e($task['due']); ?></td>
                            <td style="text-align:right">
                                <span class="db-priority db-priority--<?php echo e($priority); ?>" title="<?php echo e(ucfirst($priority)); ?> priority"></span>
                            </td>
                            <td style="text-align:right">
                                <button type="button"
                                        class="db-btn db-btn--ghost db-btn--sm js-dismiss-task"
                                        data-index="<?php echo e($i); ?>"
                                        aria-label="Dismiss task">
                                    <?php echo $icon('x'); ?>

                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr id="db-tasks-empty">
                            <td colspan="6" style="padding:40px;text-align:center;color:var(--db-gray-400);font-size:13.5px">
                                No tasks assigned right now.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="db-card__footer">
                <a href="<?php echo e(route('staff.tasks.index') ?? '#'); ?>" class="db-link">
                    View all tasks <?php echo $icon('arrow'); ?>

                </a>
            </div>
        </div>

        
        <div class="db-sidebar">

            
            <div class="db-card db-animate" style="animation-delay:380ms">
                <div class="db-card__header">
                    <span class="db-card__title">Today's Schedule</span>
                    <a href="<?php echo e(route('staff.schedule.index')); ?>" class="db-link">
                        Full view <?php echo $icon('arrow'); ?>

                    </a>
                </div>
                <div class="db-timeline">
                    <?php $__currentLoopData = $schedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $itemMin = $scheduleMinutes($item['time']);
                        $isNow   = $itemMin >= 0 && abs($itemMin - $nowMinutes) <= 60;
                    ?>
                    <div class="db-timeline-item <?php echo e($isNow ? 'is-now' : ''); ?>">
                        <span class="db-timeline__dot"></span>
                        <div style="flex:1">
                            <div class="db-timeline__time"><?php echo e($item['time']); ?></div>
                        </div>
                        <div style="flex:3">
                            <div class="db-timeline__event"><?php echo e($item['event']); ?></div>
                            <?php if(!empty($item['sub'])): ?>
                            <div class="db-timeline__sub"><?php echo e($item['sub']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="db-card db-animate" style="animation-delay:420ms">
                <div class="db-card__header">
                    <div style="display:flex;align-items:center;gap:8px">
                        <span class="db-card__title">Notifications</span>
                        <span class="db-notif-badge"><?php echo e(count($notifications)); ?></span>
                    </div>
                    <button type="button"
                            id="db-mark-all-read"
                            class="db-btn db-btn--ghost db-btn--sm"
                            style="font-size:12px">
                        Mark all read
                    </button>
                </div>
                <div class="db-notif-list" id="db-notif-list">
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="db-notif db-notif--<?php echo e($note['type'] ?? 'info'); ?>">
                        <span class="db-notif__dot"></span>
                        <div>
                            <div class="db-notif__text"><?php echo e($note['text']); ?></div>
                            <div class="db-notif__time"><?php echo e($note['time']); ?></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="db-card db-animate" style="animation-delay:460ms">
                <div class="db-card__header">
                    <span class="db-card__title">This Week</span>
                    <a href="<?php echo e(route('staff.attendance.index') ?? '#'); ?>" class="db-link">
                        Details <?php echo $icon('arrow'); ?>

                    </a>
                </div>
                <div class="db-attendance">
                    <div class="db-attendance__label">Hours logged</div>
                    <div class="db-attendance__bar">
                        <div class="db-attendance__fill" style="width:<?php echo e(round((32.5/40)*100)); ?>%"></div>
                    </div>
                    <div class="db-attendance__meta">
                        <span>0</span>
                        <span class="db-attendance__val">32.5 / 40 hrs</span>
                        <span>40</span>
                    </div>
                    <div class="db-attendance__days" style="margin-top:16px">
                        <?php $__currentLoopData = $attendanceDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="db-att-day db-att-day--<?php echo e($day['state']); ?>"><?php echo e($day['label']); ?></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div style="display:flex;gap:12px;margin-top:10px;font-size:11px;color:var(--db-gray-400)">
                        <span style="display:flex;align-items:center;gap:4px"><span style="width:8px;height:8px;border-radius:2px;background:var(--db-accent-light);display:inline-block"></span> Present</span>
                        <span style="display:flex;align-items:center;gap:4px"><span style="width:8px;height:8px;border-radius:2px;background:var(--db-accent);display:inline-block"></span> Today</span>
                        <span style="display:flex;align-items:center;gap:4px"><span style="width:8px;height:8px;border-radius:2px;background:var(--db-danger-bg);display:inline-block"></span> Absent</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    /* ── CSRF ── */
    var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

    /* ── Flash helper ── */
    var flashRegion = document.getElementById('db-flash-region');
    function showFlash(msg, type) {
        if (!flashRegion) return;
        var ok = type !== 'error';
        var el = document.createElement('div');
        el.className = 'db-flash db-flash--' + (ok ? 'success' : 'error');
        el.setAttribute('role','alert');
        el.innerHTML = ok
            ? '<svg viewBox="0 0 18 18" fill="none" width="16" height="16"><circle cx="9" cy="9" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 9l2.5 2.5 4-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>'
            : '<svg viewBox="0 0 18 18" fill="none" width="16" height="16"><circle cx="9" cy="9" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M9 5.5v4M9 12h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>';
        el.appendChild(document.createTextNode(' ' + msg));
        flashRegion.appendChild(el);
        while (flashRegion.children.length > 3) flashRegion.removeChild(flashRegion.firstElementChild);
        setTimeout(function () {
            el.classList.add('is-leaving');
            setTimeout(function () { el.parentNode && el.parentNode.removeChild(el); }, 250);
        }, 4000);
    }

    /* ── Clock toggle ── */
    var clockForm    = document.getElementById('db-clock-form');
    var clockBtn     = document.getElementById('db-clock-btn');
    var clockLabel   = document.getElementById('db-clock-label');
    var clockSpinner = document.getElementById('db-clock-spinner');
    var clockBadge   = document.getElementById('db-clock-badge');
    var clockDot     = document.getElementById('db-clock-dot');
    var clockText    = document.getElementById('db-clock-text');

    function setClockUI(isClockedIn) {
        if (clockLabel)  clockLabel.textContent = isClockedIn ? 'Clock Out' : 'Clock In';
        if (clockBtn)    clockBtn.setAttribute('aria-pressed', isClockedIn ? 'true' : 'false');

        if (clockBadge) {
            clockBadge.classList.toggle('is-out', !isClockedIn);
        }
        if (clockDot) {
            clockDot.classList.toggle('db-live-dot', isClockedIn);
            clockDot.classList.toggle('is-out', !isClockedIn);
        }
        if (clockText) {
            if (isClockedIn) {
                var now = new Date();
                clockText.textContent = 'Clocked in since ' + now.toLocaleTimeString([], {hour:'numeric',minute:'2-digit'});
            } else {
                clockText.textContent = 'Not clocked in';
            }
        }
    }

    if (clockForm) {
        clockForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (clockBtn)     clockBtn.disabled = true;
            if (clockSpinner) clockSpinner.removeAttribute('hidden');

            fetch('<?php echo e(route("staff.clock.toggle")); ?>', {
                method: 'POST',
                headers: { 'Accept':'application/json','X-CSRF-TOKEN':csrf,'Content-Type':'application/json' },
                body: JSON.stringify({})
            })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                var isClockedIn = d && d.clocked === 'in';
                setClockUI(isClockedIn);
                showFlash(d && d.message ? d.message : (isClockedIn ? 'Clocked in.' : 'Clocked out.'), 'success');
            })
            .catch(function () { showFlash('Failed to update clock. Please try again.', 'error'); })
            .finally(function () {
                if (clockBtn)     clockBtn.disabled = false;
                if (clockSpinner) clockSpinner.setAttribute('hidden','');
            });
        });
    }

    /* ── Task filter tabs ── */
    var tabs      = document.querySelectorAll('.db-tab');
    var taskRows  = document.querySelectorAll('.db-task-row');
    var emptyRow  = document.getElementById('db-tasks-empty');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('is-active'); t.setAttribute('aria-selected','false'); });
            tab.classList.add('is-active');
            tab.setAttribute('aria-selected','true');

            var filter = tab.getAttribute('data-filter');
            var visible = 0;
            taskRows.forEach(function (row) {
                var show = filter === 'all' || row.getAttribute('data-status') === filter;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            if (emptyRow) emptyRow.style.display = visible === 0 ? '' : 'none';
        });
    });

    /* ── Task dismiss ── */
    var EMPTY_HTML = '<tr id="db-tasks-empty"><td colspan="6" style="padding:40px;text-align:center;color:var(--db-gray-400);font-size:13.5px">No tasks assigned right now.</td></tr>';

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.js-dismiss-task');
        if (!btn) return;
        e.preventDefault();

        var idx = btn.getAttribute('data-index');
        var row = document.querySelector('[data-task-index="' + idx + '"]');
        var url = '/staff/tasks/' + idx + '/dismiss';

        fetch(url, {
            method: 'POST',
            headers: { 'Accept':'application/json','X-CSRF-TOKEN':csrf,'Content-Type':'application/json' },
            body: JSON.stringify({})
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d && d.status === 'ok') {
                if (row) {
                    row.classList.add('is-removing');
                    setTimeout(function () {
                        row.parentNode && row.parentNode.removeChild(row);
                        var body = document.getElementById('db-tasks-body');
                        if (body) {
                            var remaining = body.querySelectorAll('.db-task-row').length;
                            if (remaining === 0) body.innerHTML = EMPTY_HTML;
                        }
                        /* Update pending count badge */
                        updateTaskCount();
                    }, 280);
                }
                showFlash(d.message || 'Task dismissed.', 'success');
            } else {
                showFlash((d && d.message) || 'Could not dismiss task.', 'error');
            }
        })
        .catch(function () { showFlash('Network error. Please try again.', 'error'); });
    });

    /* ── Task checkbox (mark complete) ── */
    document.addEventListener('change', function (e) {
        var cb = e.target.closest('.js-task-check');
        if (!cb) return;

        var idx = cb.getAttribute('data-index');
        var row = document.querySelector('[data-task-index="' + idx + '"]');
        var checked = cb.checked;

        fetch('/staff/tasks/' + idx + '/status', {
            method: 'POST',
            headers: { 'Accept':'application/json','X-CSRF-TOKEN':csrf,'Content-Type':'application/json' },
            body: JSON.stringify({ status: checked ? 'Completed' : 'Pending' })
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d && d.status === 'ok') {
                if (row) {
                    row.setAttribute('data-status', checked ? 'Completed' : 'Pending');
                    var badge = row.querySelector('.db-badge');
                    if (badge) {
                        badge.className = 'db-badge ' + (checked ? 'db-badge--completed' : 'db-badge--pending');
                        badge.textContent = checked ? 'Completed' : 'Pending';
                    }
                }
                showFlash(checked ? 'Task marked complete.' : 'Task reopened.', 'success');
                updateTaskCount();
            } else {
                cb.checked = !checked; // revert
                showFlash((d && d.message) || 'Could not update task.', 'error');
            }
        })
        .catch(function () {
            cb.checked = !checked;
            showFlash('Network error. Please try again.', 'error');
        });
    });

    /* ── Task count badge ── */
    function updateTaskCount() {
        var countEl = document.getElementById('db-tasks-count');
        if (!countEl) return;
        var pending = document.querySelectorAll('.db-task-row:not([style*="display: none"]):not([data-status="Completed"])').length;
        countEl.textContent = pending;
    }

    /* ── Mark all notifications read ── */
    var markAllBtn  = document.getElementById('db-mark-all-read');
    var notifList   = document.getElementById('db-notif-list');
    if (markAllBtn && notifList) {
        markAllBtn.addEventListener('click', function () {
            var dots = notifList.querySelectorAll('.db-notif__dot');
            dots.forEach(function (d) { d.style.opacity = '.25'; });
            markAllBtn.disabled = true;
            markAllBtn.textContent = 'All read';

            fetch('/staff/notifications/read-all', {
                method: 'POST',
                headers: { 'Accept':'application/json','X-CSRF-TOKEN':csrf,'Content-Type':'application/json' },
                body: JSON.stringify({})
            }).catch(function () {}); /* silent fail — UI already updated */
        });
    }

    /* ── Live clock (updates every minute) ── */
    function updateLiveClock() {
        var text = document.getElementById('db-clock-text');
        if (!text || !text.textContent.includes('Clocked in')) return;
        /* The since-time is fixed; we just keep the badge visible */
    }
    setInterval(updateLiveClock, 60000);

})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/dashboard.blade.php ENDPATH**/ ?>