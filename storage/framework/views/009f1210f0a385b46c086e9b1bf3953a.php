

<?php $__env->startSection('title', 'Students'); ?>
<?php $__env->startSection('page_title', 'Students'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ── Reset / tokens ───────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; }

    :root {
        --brand-blue:   #2563eb;
        --brand-indigo: #4f46e5;
        --brand-green:  #16a34a;
        --brand-amber:  #d97706;
        --brand-rose:   #e11d48;
        --bg-page:      #f8fafc;
        --radius-card:  18px;
        --shadow-sm:    0 2px 8px rgba(15,23,42,.05);
        --shadow-md:    0 10px 28px rgba(15,23,42,.08);
        --shadow-lg:    0 18px 40px rgba(15,23,42,.13);
        --dur-fast:     .18s;
        --dur-base:     .38s;
        --dur-slow:     .7s;
        --ease-out:     cubic-bezier(.22,1,.36,1);
        --ease-spring:  cubic-bezier(.34,1.56,.64,1);
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
            scroll-behavior: auto !important;
        }
    }

    /* ── Keyframes ─────────────────────────────────────────────── */
    @keyframes fadeUp        { from { opacity:0; transform:translateY(18px); }  to { opacity:1; transform:translateY(0); } }
    @keyframes fadeIn        { from { opacity:0; }                               to { opacity:1; } }
    @keyframes scaleIn       { from { opacity:0; transform:scale(.92); }         to { opacity:1; transform:scale(1); } }
    @keyframes progressFill  { from { width:0 !important; }                      to { width:var(--pw); } }
    @keyframes shimmer       { 0%   { transform:translateX(-150%); }             100% { transform:translateX(150%); } }
    @keyframes pulseRing     {
        0%   { box-shadow:0 0 0 0 rgba(37,99,235,.35); }
        70%  { box-shadow:0 0 0 8px rgba(37,99,235,0); }
        100% { box-shadow:0 0 0 0 rgba(37,99,235,0); }
    }
    @keyframes slideDown     { from { opacity:0; transform:translateY(-8px); }   to { opacity:1; transform:translateY(0); } }
    @keyframes numberTick    {
        0%   { opacity:0; transform:translateY(10px) scale(.9); }
        60%  { transform:translateY(-2px) scale(1.04); }
        100% { opacity:1; transform:translateY(0) scale(1); }
    }
    @keyframes badgePop      {
        0%   { opacity:0; transform:scale(.7); }
        75%  { transform:scale(1.08); }
        100% { opacity:1; transform:scale(1); }
    }
    @keyframes floatDot {
        0%, 100% { transform:translateY(0); }
        50%       { transform:translateY(-4px); }
    }
    @keyframes tooltipFade   { from { opacity:0; transform:translate(-50%,4px); } to { opacity:1; transform:translate(-50%,0); } }
    @keyframes cardPress     { 0% { transform:scale(1); } 50% { transform:scale(.985); } 100% { transform:scale(1); } }

    /* ── Page shell ────────────────────────────────────────────── */
    .sp {
        position: relative;
        padding: .2rem 0 3rem;
        animation: fadeIn .3s ease both;
        min-height: 60vh;
    }

    .sp::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 260px;
        background:
            radial-gradient(circle at 0% 0%,   rgba(79,70,229,.09) 0%, transparent 55%),
            radial-gradient(circle at 100% 0%,  rgba(37,99,235,.07) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    /* ── Toolbar ────────────────────────────────────────────────── */
    .sp-toolbar {
        position: relative;
        z-index: 10;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .75rem;
        margin-bottom: 1.1rem;
        padding: 1rem 1.2rem;
        background: rgba(255,255,255,.96);
        border: 1px solid rgba(226,232,240,.9);
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        backdrop-filter: blur(12px);
        animation: fadeUp var(--dur-base) var(--ease-out) both;
    }

    .sp-toolbar__left { flex: 1; min-width: 0; }

    .sp-toolbar__title {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -.02em;
        line-height: 1.25;
    }

    .sp-toolbar__sub {
        margin: .3rem 0 0;
        font-size: .85rem;
        color: #64748b;
        line-height: 1.55;
    }

    .sp-toolbar__right {
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }

    /* Search box */
    .sp-search { position: relative; }

    .sp-search__icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        transition: color var(--dur-fast);
    }

    .sp-search__input {
        padding: 8px 34px 8px 34px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: .84rem;
        color: #1e293b;
        background: #f8fafc;
        outline: none;
        width: 210px;
        transition: border-color var(--dur-fast), box-shadow var(--dur-fast), background var(--dur-fast), width .25s var(--ease-out);
    }

    .sp-search__input:focus {
        border-color: var(--brand-blue);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        width: 250px;
    }

    .sp-search__input:focus + .sp-search__icon,
    .sp-search:focus-within .sp-search__icon { color: var(--brand-blue); }

    .sp-search__clear {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border: none;
        background: #e2e8f0;
        color: #64748b;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background var(--dur-fast), color var(--dur-fast);
        padding: 0;
    }
    .sp-search__clear:hover { background: #cbd5e1; color: #1e293b; }
    .sp-search.has-value .sp-search__clear { display: inline-flex; }

    /* Filter pills */
    .sp-filters { display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; }

    .sp-filter-btn {
        padding: 6px 13px;
        border: 1.5px solid #e2e8f0;
        border-radius: 999px;
        font-size: .79rem;
        font-weight: 700;
        color: #64748b;
        background: #f8fafc;
        cursor: pointer;
        transition: color var(--dur-fast), background var(--dur-fast), border-color var(--dur-fast), transform var(--dur-fast), box-shadow var(--dur-fast);
        letter-spacing: .02em;
        white-space: nowrap;
    }

    .sp-filter-btn:hover { border-color: #c7d2fe; color: var(--brand-indigo); background: #eef2ff; }
    .sp-filter-btn:active { transform: scale(.96); }

    .sp-filter-btn.is-active {
        background: var(--brand-indigo);
        border-color: var(--brand-indigo);
        color: #fff;
        box-shadow: 0 3px 10px rgba(79,70,229,.3);
    }

    /* Sort select */
    .sp-sort {
        padding: 7px 28px 7px 11px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 600;
        color: #475569;
        background: #f8fafc url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' fill='none'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%2394a3b8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 9px center;
        appearance: none;
        cursor: pointer;
        outline: none;
        transition: border-color var(--dur-fast), box-shadow var(--dur-fast);
    }

    .sp-sort:focus {
        border-color: var(--brand-blue);
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        background-color: #fff;
    }

    /* Count badge */
    .sp-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 800;
        background: linear-gradient(135deg, #eff6ff, #eef2ff);
        color: var(--brand-indigo);
        border: 1px solid #c7d2fe;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.8);
        animation: badgePop .5s .15s var(--ease-spring) both;
        white-space: nowrap;
        transition: transform var(--dur-fast), box-shadow var(--dur-fast);
    }

    .sp-count:hover { transform: scale(1.04); box-shadow: 0 4px 12px rgba(79,70,229,.2), inset 0 1px 0 rgba(255,255,255,.8); }

    /* ── Stat strip ─────────────────────────────────────────────── */
    .sp-summary {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 10px;
        margin-bottom: 1.1rem;
    }

    .sp-stat {
        background: rgba(255,255,255,.97);
        border: 1px solid rgba(226,232,240,.95);
        border-radius: 16px;
        padding: .9rem 1rem;
        opacity: 0;
        animation: fadeUp .4s var(--ease-out) both;
        box-shadow: var(--shadow-sm);
        transition: transform var(--dur-fast), box-shadow var(--dur-fast), border-color var(--dur-fast);
        cursor: default;
        position: relative;
        overflow: hidden;
    }

    .sp-stat::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, transparent 60%, rgba(255,255,255,.5));
        pointer-events: none;
    }

    .sp-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: #c7d2fe; }
    .sp-stat:active { transform: translateY(-1px) scale(.99); }

    .sp-stat[data-clickable="true"] { cursor: pointer; }
    .sp-stat[data-clickable="true"]:focus-visible { outline: 2px solid var(--brand-indigo); outline-offset: 2px; }

    .sp-stat__icon {
        font-size: 1.1rem;
        margin-bottom: .35rem;
        line-height: 1;
        display: inline-block;
        animation: floatDot 3s ease-in-out infinite;
    }

    .sp-stat:nth-child(1) .sp-stat__icon { animation-delay: 0s; }
    .sp-stat:nth-child(2) .sp-stat__icon { animation-delay: .4s; }
    .sp-stat:nth-child(3) .sp-stat__icon { animation-delay: .8s; }
    .sp-stat:nth-child(4) .sp-stat__icon { animation-delay: 1.2s; }
    .sp-stat:nth-child(5) .sp-stat__icon { animation-delay: 1.6s; }
    .sp-stat:nth-child(6) .sp-stat__icon { animation-delay: 2s; }

    .sp-stat__label {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: #94a3b8;
        margin-bottom: .35rem;
    }

    .sp-stat__value {
        font-size: 1.55rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1;
        animation: numberTick .55s var(--ease-out) both;
        font-variant-numeric: tabular-nums;
    }

    .sp-stat__sub { font-size: .68rem; color: #94a3b8; margin-top: .25rem; font-weight: 600; }

    .clr-green  { color: var(--brand-green)  !important; }
    .clr-blue   { color: var(--brand-blue)   !important; }
    .clr-amber  { color: var(--brand-amber)  !important; }
    .clr-rose   { color: var(--brand-rose)   !important; }
    .clr-indigo { color: var(--brand-indigo) !important; }

    /* ── View toggle ────────────────────────────────────────────── */
    .sp-view-toggle {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .9rem;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .sp-results-label { font-size: .8rem; font-weight: 600; color: #64748b; }
    .sp-results-label strong { color: #1e293b; font-variant-numeric: tabular-nums; }

    .sp-toggle-group {
        display: flex;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 3px;
        gap: 3px;
    }

    .sp-toggle-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 7px;
        font-size: .8rem;
        cursor: pointer;
        background: transparent;
        color: #94a3b8;
        transition: background var(--dur-fast), color var(--dur-fast), box-shadow var(--dur-fast);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .sp-toggle-btn.is-active { background: #fff; color: #1e293b; box-shadow: var(--shadow-sm); }

    /* ── Card grid / list ───────────────────────────────────────── */
    .sp-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        gap: 14px;
    }

    .sp-grid.list-view { grid-template-columns: 1fr; }

    /* ── Student card ────────────────────────────────────────────── */
    .s-card {
        background: rgba(255,255,255,.98);
        border: 1.5px solid rgba(226,232,240,.9);
        border-radius: var(--radius-card);
        padding: 1.05rem 1.1rem 1.1rem;
        opacity: 0;
        animation: fadeUp .45s var(--ease-out) both;
        transition: border-color var(--dur-fast), transform .22s var(--ease-out), box-shadow .22s var(--ease-out);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        cursor: default;
    }

    .s-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto 0;
        height: 3.5px;
        background: var(--card-bar, #e2e8f0);
        border-radius: var(--radius-card) var(--radius-card) 0 0;
    }

    .s-card::after {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 60%;
        height: 100%;
        background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.55) 50%, transparent 70%);
        transform: translateX(-150%);
        transition: transform .65s var(--ease-out);
        pointer-events: none;
    }

    .s-card:hover::after { transform: translateX(220%); }
    .s-card:hover { border-color: #cbd5e1; transform: translateY(-5px); box-shadow: var(--shadow-lg); }

    .s-card.ac-green  { --card-bar: linear-gradient(90deg, #22c55e, #4ade80); }
    .s-card.ac-blue   { --card-bar: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .s-card.ac-amber  { --card-bar: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .s-card.ac-rose   { --card-bar: linear-gradient(90deg, #f43f5e, #fb7185); }
    .s-card.ac-indigo { --card-bar: linear-gradient(90deg, #6366f1, #818cf8); }

    .list-view .s-card { padding: .75rem 1.1rem; border-radius: 14px; }
    .list-view .s-card-inner {
        display: grid;
        grid-template-columns: auto 1fr auto auto auto;
        align-items: center;
        gap: 1rem;
    }
    .list-view .s-card__body   { display: none; }
    .list-view .s-card__footer { margin-top: 0; padding-top: 0; border-top: none; }
    .list-view .s-card__top    { margin-bottom: 0; }
    .list-view .s-divider      { display: none; }
    .list-view .s-meta         { margin-bottom: 0; }
    .list-view .s-progress__row,
    .list-view .s-progress__track { margin-bottom: 0; }

    /* ── Avatar ──────────────────────────────────────────────────── */
    .s-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        flex-shrink: 0;
        letter-spacing: .02em;
        position: relative;
        transition: transform var(--dur-fast);
    }

    .s-card:hover .s-avatar { transform: scale(1.08); }

    .s-avatar__badge {
        position: absolute;
        bottom: 1px; right: 1px;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .s-avatar__badge.online  { background: #22c55e; animation: pulseRing 2s infinite; }
    .s-avatar__badge.offline { background: #cbd5e1; }
    .s-avatar__badge.away    { background: #f59e0b; }

    .av-0 { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #5b21b6; box-shadow: inset 0 1px 2px rgba(255,255,255,.9), 0 0 0 1.5px rgba(167,139,250,.25); }
    .av-1 { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; box-shadow: inset 0 1px 2px rgba(255,255,255,.9), 0 0 0 1.5px rgba(74,222,128,.25); }
    .av-2 { background: linear-gradient(135deg, #ffedd5, #fed7aa); color: #9a3412; box-shadow: inset 0 1px 2px rgba(255,255,255,.9), 0 0 0 1.5px rgba(251,146,60,.25); }
    .av-3 { background: linear-gradient(135deg, #fce7f3, #fbcfe8); color: #9d174d; box-shadow: inset 0 1px 2px rgba(255,255,255,.9), 0 0 0 1.5px rgba(244,114,182,.25); }
    .av-4 { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1d4ed8; box-shadow: inset 0 1px 2px rgba(255,255,255,.9), 0 0 0 1.5px rgba(96,165,250,.25); }

    /* ── Card sections ───────────────────────────────────────────── */
    .s-card__top { display: flex; align-items: center; gap: 11px; margin-bottom: 11px; }
    .s-card__identity { min-width: 0; flex: 1; }

    .s-card__name {
        font-size: .94rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .s-card__email {
        font-size: .74rem;
        color: #94a3b8;
        margin-top: 1px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .s-card__course {
        font-size: .78rem;
        color: #64748b;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .s-divider { border: none; border-top: 1px solid rgba(226,232,240,.85); margin: 0 0 10px; }

    .s-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .s-meta__label { font-size: .7rem; color: #94a3b8; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; }

    .s-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .71rem;
        font-weight: 700;
        padding: 3.5px 9px;
        border-radius: 999px;
        letter-spacing: .025em;
        transition: transform var(--dur-fast);
    }
    .s-pill:hover { transform: scale(1.05); }
    .s-pill__dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

    .pill-active    { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .pill-pending   { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .pill-inactive  { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }
    .pill-dropped   { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
    .pill-completed { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #047857; border: 1px solid #a7f3d0; }

    /* ── Progress bar ────────────────────────────────────────────── */
    .s-progress__row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
    .s-progress__lbl { font-size: .71rem; color: #64748b; font-weight: 600; }
    .s-progress__val { font-size: .72rem; font-weight: 800; color: #0f172a; font-variant-numeric: tabular-nums; }

    .s-progress__track {
        height: 7px;
        background: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        margin-bottom: .75rem;
        position: relative;
    }

    .s-progress__bar {
        height: 100%;
        border-radius: 999px;
        width: var(--pw);
        animation: progressFill 1s var(--ease-out) both;
        animation-delay: var(--pd);
        position: relative;
        overflow: hidden;
    }

    .s-progress__bar::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.5), transparent);
        animation: shimmer 2s ease-in-out infinite;
    }

    .bar-high { background: linear-gradient(90deg, #22c55e, #4ade80); }
    .bar-mid  { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .bar-low  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .bar-zero { background: #e2e8f0; }

    /* ── Micro-stats row ─────────────────────────────────────────── */
    .s-card__body { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: .75rem; }

    .s-micro {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        padding: 7px 9px;
        transition: background var(--dur-fast);
    }
    .s-micro:hover { background: #f0f9ff; }
    .s-micro__label { font-size: .65rem; color: #94a3b8; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; margin-bottom: 2px; }
    .s-micro__val { font-size: .88rem; font-weight: 800; color: #1e293b; }

    /* ── Footer ──────────────────────────────────────────────────── */
    .s-card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 6px;
        padding-top: 8px;
        border-top: 1px solid rgba(226,232,240,.7);
    }

    .s-card__date { display: flex; align-items: center; gap: 5px; font-size: .72rem; color: #94a3b8; font-weight: 600; white-space: nowrap; }

    .s-card__actions {
        display: flex;
        align-items: center;
        gap: 5px;
        opacity: 0;
        transform: translateX(6px);
        transition: opacity var(--dur-fast), transform var(--dur-fast);
    }
    .s-card:hover .s-card__actions,
    .s-card:focus-within .s-card__actions { opacity: 1; transform: translateX(0); }

    .s-action-btn {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #64748b;
        transition: background var(--dur-fast), border-color var(--dur-fast), color var(--dur-fast), transform var(--dur-fast);
        text-decoration: none;
        position: relative;
    }
    .s-action-btn:hover { background: #eff6ff; border-color: #bfdbfe; color: var(--brand-blue); transform: scale(1.12); }
    .s-action-btn:active { transform: scale(1); animation: cardPress .18s var(--ease-out); }
    .s-action-btn:focus-visible { outline: 2px solid var(--brand-blue); outline-offset: 2px; }

    .s-action-btn[data-tip]::after {
        content: attr(data-tip);
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translate(-50%, 4px);
        background: #0f172a;
        color: #fff;
        font-size: .68rem;
        font-weight: 600;
        padding: 3px 7px;
        border-radius: 5px;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: opacity .15s, transform .15s;
    }
    .s-action-btn[data-tip]:hover::after,
    .s-action-btn[data-tip]:focus-visible::after {
        opacity: 1;
        transform: translate(-50%, 0);
    }

    /* ── Empty state ─────────────────────────────────────────────── */
    .sp-empty {
        position: relative;
        z-index: 1;
        background: rgba(255,255,255,.98);
        border: 1.5px dashed rgba(148,163,184,.4);
        border-radius: 22px;
        padding: 4rem 2rem;
        text-align: center;
        animation: scaleIn .45s var(--ease-out) both;
        box-shadow: var(--shadow-sm);
    }

    .sp-empty__icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, #eff6ff, #eef2ff);
        border: 1px solid #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 1.1rem;
        animation: floatDot 3s ease-in-out infinite;
    }

    .sp-empty h3 { margin: 0 0 .5rem; font-size: 1.05rem; font-weight: 800; color: #111827; }
    .sp-empty p { margin: 0 auto; font-size: .9rem; color: #64748b; max-width: 340px; line-height: 1.65; }

    /* ── No-results state ─────────────────────────────────────────── */
    .sp-no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
        animation: fadeIn .3s ease both;
    }
    .sp-no-results__icon { font-size: 2.2rem; margin-bottom: .75rem; display: block; }
    .sp-no-results p { font-size: .9rem; font-weight: 600; margin: 0 0 .75rem; }
    .sp-no-results__reset {
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: var(--brand-indigo);
        font-size: .8rem;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 999px;
        cursor: pointer;
        transition: background var(--dur-fast), border-color var(--dur-fast);
    }
    .sp-no-results__reset:hover { background: #eef2ff; border-color: #c7d2fe; }

    /* ── Responsive ───────────────────────────────────────────────── */
    @media (max-width: 640px) {
        .sp-toolbar__right { width: 100%; }
        .sp-search__input  { width: 100%; }
        .sp-search__input:focus { width: 100%; }
        .sp-search         { flex: 1; width: 100%; }
        .sp-grid           { grid-template-columns: 1fr; }
        .sp-summary        { grid-template-columns: repeat(2, 1fr); }
        .sp-sort           { display: none; }
        .list-view .s-card-inner {
            grid-template-columns: auto 1fr;
            row-gap: 8px;
        }
        .list-view .s-card__footer { grid-column: 1 / -1; }
    }

    /* ── Editorial dashboard treatment ─────────────────────────── */
    .sp {
        --ink: #172033;
        --coral: #f27a5b;
        --mint: #54c7ad;
        max-width: 1480px;
        margin: 0 auto;
        padding: .75rem clamp(.5rem, 2vw, 1.5rem) 4rem;
    }

    .sp::before {
        height: 360px;
        background: linear-gradient(120deg, rgba(23,32,51,.98) 0%, rgba(38,54,83,.96) 58%, rgba(52,79,103,.9) 100%);
        border-radius: 0 0 34px 34px;
        box-shadow: 0 18px 50px rgba(23,32,51,.18);
    }

    .sp::after {
        content: '';
        position: absolute;
        top: 0;
        right: 5%;
        width: 280px;
        height: 280px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 50%;
        box-shadow: 0 0 0 36px rgba(255,255,255,.025), 0 0 0 72px rgba(255,255,255,.02);
        pointer-events: none;
    }

    .sp-toolbar {
        min-height: 188px;
        margin: 0 -1px 1.1rem;
        padding: 1.8rem clamp(1rem, 3vw, 2.2rem);
        background: transparent;
        border: 0;
        border-radius: 0;
        box-shadow: none;
        backdrop-filter: none;
        color: #fff;
    }

    .sp-toolbar__left { align-self: flex-start; padding-top: .2rem; }
    .sp-toolbar__left::before {
        content: 'TEACHING OVERVIEW';
        display: block;
        margin-bottom: .7rem;
        color: #7ee0c8;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .16em;
    }
    .sp-toolbar__title { color: #fff; font-size: clamp(1.65rem, 3vw, 2.35rem); letter-spacing: -.045em; }
    .sp-toolbar__sub { color: rgba(255,255,255,.68); max-width: 430px; }
    .sp-toolbar__right { align-self: flex-end; }

    .sp-search__input,
    .sp-sort { border-color: rgba(255,255,255,.18); background-color: rgba(255,255,255,.1); color: #fff; }
    .sp-search__input::placeholder { color: rgba(255,255,255,.58); }
    .sp-search__icon { color: rgba(255,255,255,.64); }
    .sp-search__input:focus,
    .sp-sort:focus { background-color: rgba(255,255,255,.16); border-color: #7ee0c8; box-shadow: 0 0 0 3px rgba(126,224,200,.18); }
    .sp-sort { color: #fff; }
    .sp-sort option { color: #172033; background: #fff; }
    .sp-count { color: #172033; background: #f7c978; border-color: #f7c978; box-shadow: 0 8px 20px rgba(247,201,120,.22); }

    .sp-summary { gap: 12px; margin-top: -1px; }
    .sp-stat { min-height: 126px; padding: 1rem 1.1rem; border-color: rgba(226,232,240,.8); border-radius: 14px; box-shadow: 0 12px 24px rgba(23,32,51,.08); }
    .sp-stat:nth-child(1) { border-top: 3px solid var(--coral); }
    .sp-stat:nth-child(2) { border-top: 3px solid var(--mint); }
    .sp-stat:nth-child(3) { border-top: 3px solid #f7c978; }
    .sp-stat:nth-child(4) { border-top: 3px solid #6d91e8; }
    .sp-stat:nth-child(5) { border-top: 3px solid #9b83db; }
    .sp-stat:nth-child(6) { border-top: 3px solid var(--mint); }
    .sp-view-toggle { padding: .25rem .15rem; }
    .sp-filter-btn.is-active { background: var(--ink); border-color: var(--ink); box-shadow: 0 5px 14px rgba(23,32,51,.24); }
    .sp-filter-btn:hover { color: var(--ink); border-color: #9ab1c9; background: #eef5f4; }
    .sp-toggle-group { background: #e8eef3; }
    .sp-grid { gap: 16px; }
    .s-card { border-color: #e3e9ee; border-radius: 14px; box-shadow: 0 10px 24px rgba(23,32,51,.07); }
    .s-card:hover { border-color: #a9c7c7; box-shadow: 0 18px 34px rgba(23,32,51,.13); }
    .s-card::before { height: 4px; }
    .s-card__name { color: var(--ink); }
    .s-progress__track { background: #edf2f4; }

    @media (max-width: 640px) {
        .sp { padding-left: 0; padding-right: 0; }
        .sp::before { border-radius: 0 0 24px 24px; }
        .sp-toolbar { margin-left: 0; margin-right: 0; padding-top: 1.35rem; min-height: 255px; }
        .sp-toolbar__right { align-self: stretch; }
        .sp-summary { padding: 0 .1rem; }
    }

    /* ── Scrollbar polish ─────────────────────────────────────────── */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php
    use Illuminate\Support\Str;
    use Illuminate\Support\Carbon;

    /* ── Metrics ────────────────────────────────────────────── */
    $enrollments = $enrollments ?? collect();

    $normalizedEnrollments = $enrollments->map(function ($enrollment) {
        $progress  = max(0, min(100, (int) ($enrollment->progress ?? 0)));
        $rawStatus = ucfirst(strtolower((string) ($enrollment->status ?? '')));

        $validStatuses = ['Active', 'Pending', 'Inactive', 'Dropped', 'Completed'];
        if (in_array($rawStatus, $validStatuses, true)) {
            $status = $rawStatus;
        } elseif (!empty($enrollment->completed) || $progress >= 100) {
            $status = 'Completed';
        } else {
            $status = $progress > 0 ? 'Active' : 'Pending';
        }

        if ($progress >= 100 && $status !== 'Dropped' && $status !== 'Inactive') {
            $status = 'Completed';
        }

        $enrollment->status   = $status;
        $enrollment->progress = $progress;

        return $enrollment;
    });

    $total     = $normalizedEnrollments->count();
    $active    = $normalizedEnrollments->where('status', 'Active')->count();
    $pending   = $normalizedEnrollments->where('status', 'Pending')->count();
    $inactive  = $normalizedEnrollments->where('status', 'Inactive')->count();
    $dropped   = $normalizedEnrollments->where('status', 'Dropped')->count();
    $completed = $normalizedEnrollments->where('status', 'Completed')->count();

    $avgProg  = $total > 0 ? (int) round($normalizedEnrollments->avg(fn ($e) => (int) ($e->progress ?? 0))) : 0;
    $highProg = $total > 0 ? $normalizedEnrollments->filter(fn ($e) => (int) ($e->progress ?? 0) >= 75)->count() : 0;

    $courseCount = $normalizedEnrollments->filter(fn ($e) => isset($e->course_id))->unique('course_id')->count();
?>

<div class="sp" id="studentsPage">

    
    <div class="sp-toolbar">
        <div class="sp-toolbar__left">
            <h2 class="sp-toolbar__title">Enrolled students</h2>
            <p class="sp-toolbar__sub">Review learners across your courses and track engagement at a glance.</p>
        </div>

        <div class="sp-toolbar__right">
            
            <div class="sp-search" id="searchWrap">
                <svg class="sp-search__icon" width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                    <circle cx="7" cy="7" r="4.5" stroke="currentColor" stroke-width="1.6"/>
                    <path d="M10.5 10.5L14 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                <input
                    class="sp-search__input"
                    id="studentSearch"
                    type="search"
                    placeholder="Search students… ( / )"
                    autocomplete="off"
                    aria-label="Search students"
                >
                <button type="button" class="sp-search__clear" id="searchClear" aria-label="Clear search" title="Clear search">
                    <svg width="10" height="10" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M2 2l12 12M14 2L2 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            
            <select class="sp-sort" id="studentSort" aria-label="Sort students">
                <option value="name-asc">Name A–Z</option>
                <option value="name-desc">Name Z–A</option>
                <option value="prog-desc">Progress ↓</option>
                <option value="prog-asc">Progress ↑</option>
                <option value="newest">Newest first</option>
                <option value="oldest">Oldest first</option>
            </select>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total): ?>
                <span class="sp-count" id="visibleCount">
                    👤&nbsp;<span id="visibleNum"><?php echo e($total); ?></span>&nbsp;<?php echo e(Str::plural('student', $total)); ?>

                </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total): ?>

        
        <div class="sp-summary" role="list" aria-label="Student summary">

            <div class="sp-stat" style="animation-delay:.05s" role="listitem">
                <span class="sp-stat__icon" aria-hidden="true">👥</span>
                <div class="sp-stat__label">Total</div>
                <div class="sp-stat__value"><?php echo e($total); ?></div>
                <div class="sp-stat__sub"><?php echo e($courseCount); ?> <?php echo e(Str::plural('course', $courseCount)); ?></div>
            </div>

            <div class="sp-stat" data-clickable="true" tabindex="0" role="button" data-filter-target="active" style="animation-delay:.1s">
                <span class="sp-stat__icon" aria-hidden="true">✅</span>
                <div class="sp-stat__label">Active</div>
                <div class="sp-stat__value clr-green"><?php echo e($active); ?></div>
                <div class="sp-stat__sub"><?php echo e($total > 0 ? round($active / $total * 100) : 0); ?>% of total</div>
            </div>

            <div class="sp-stat" data-clickable="true" tabindex="0" role="button" data-filter-target="pending" style="animation-delay:.15s">
                <span class="sp-stat__icon" aria-hidden="true">⏳</span>
                <div class="sp-stat__label">Pending</div>
                <div class="sp-stat__value clr-amber"><?php echo e($pending); ?></div>
                <div class="sp-stat__sub">Awaiting approval</div>
            </div>

            <div class="sp-stat" style="animation-delay:.2s" role="listitem">
                <span class="sp-stat__icon" aria-hidden="true">📈</span>
                <div class="sp-stat__label">Avg progress</div>
                <div class="sp-stat__value clr-blue"><?php echo e($avgProg); ?>%</div>
                <div class="sp-stat__sub">Across all courses</div>
            </div>

            <div class="sp-stat" style="animation-delay:.25s" role="listitem">
                <span class="sp-stat__icon" aria-hidden="true">🏆</span>
                <div class="sp-stat__label">≥75% done</div>
                <div class="sp-stat__value clr-indigo"><?php echo e($highProg); ?></div>
                <div class="sp-stat__sub">High performers</div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completed > 0): ?>
                <div class="sp-stat" data-clickable="true" tabindex="0" role="button" data-filter-target="completed" style="animation-delay:.3s">
                    <span class="sp-stat__icon" aria-hidden="true">🎓</span>
                    <div class="sp-stat__label">Completed</div>
                    <div class="sp-stat__value clr-green"><?php echo e($completed); ?></div>
                    <div class="sp-stat__sub">100% progress</div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>

        
        <div class="sp-view-toggle">
            <div class="sp-filters" role="group" aria-label="Filter by status">
                <button type="button" class="sp-filter-btn is-active" data-filter="all">All</button>
                <button type="button" class="sp-filter-btn" data-filter="active">Active</button>
                <button type="button" class="sp-filter-btn" data-filter="pending">Pending</button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completed > 0): ?>
                    <button type="button" class="sp-filter-btn" data-filter="completed">Completed</button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inactive > 0): ?>
                    <button type="button" class="sp-filter-btn" data-filter="inactive">Inactive</button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dropped > 0): ?>
                    <button type="button" class="sp-filter-btn" data-filter="dropped">Dropped</button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div style="display:flex;align-items:center;gap:.8rem;">
                <span class="sp-results-label">
                    Showing <strong id="filterCount"><?php echo e($total); ?></strong> of <?php echo e($total); ?>

                </span>
                <div class="sp-toggle-group" role="group" aria-label="View mode">
                    <button type="button" class="sp-toggle-btn is-active" id="gridViewBtn" aria-pressed="true" title="Grid view">
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                            <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor"/>
                            <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                            <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor"/>
                        </svg>
                        Grid
                    </button>
                    <button type="button" class="sp-toggle-btn" id="listViewBtn" aria-pressed="false" title="List view">
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M1 4h14M1 8h14M1 12h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                        List
                    </button>
                </div>
            </div>
        </div>

        
        <div class="sp-grid" id="studentGrid" role="list">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $normalizedEnrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $name   = $enrollment->user->name  ?? 'Student';
                    $email  = $enrollment->user->email ?? '';
                    $course = $enrollment->course->title ?? 'Course';

                    $status = $enrollment->status; // already normalized above
                    $progress = $enrollment->progress;

                    $lessons      = (int) ($enrollment->completed_lessons ?? 0);
                    $totalLessons = (int) ($enrollment->total_lessons ?? 0);
                    $grade        = $enrollment->final_grade ?? null;

                    $joined = ($enrollment->created_at ?? null) instanceof \Illuminate\Support\Carbon
                        ? $enrollment->created_at->format('M j, Y')
                        : null;

                    $lastActivity = $enrollment->last_activity_at ?? null;
                    $updatedAt    = $enrollment->updated_at ?? null;

                    $parts = preg_split('/\s+/', trim($name)) ?: [];
                    $initials = strtoupper(
                        (isset($parts[0]) ? substr($parts[0], 0, 1) : '') .
                        (isset($parts[1]) ? substr($parts[1], 0, 1) : '')
                    );
                    $initials = $initials !== '' ? $initials : '·';

                    $av        = 'av-' . ($i % 5);
                    $cardDelay = min($i * 55, 900) . 'ms';
                    $barDelay  = (min($i * 55, 900) + 250) . 'ms';

                    [$accentClass, $barClass] = match (true) {
                        $progress >= 75 => ['ac-green',  'bar-high'],
                        $progress >= 40 => ['ac-blue',   'bar-mid'],
                        $progress > 0   => ['ac-amber',  'bar-low'],
                        default         => ['ac-indigo', 'bar-zero'],
                    };

                    $statusLower = strtolower($status);
                    $pillClass = match ($statusLower) {
                        'active'    => 'pill-active',
                        'pending'   => 'pill-pending',
                        'completed' => 'pill-completed',
                        'dropped'   => 'pill-dropped',
                        default     => 'pill-inactive',
                    };

                    $hoursSince = $lastActivity ? $lastActivity->diffInHours(now()) : null;
                    $onlineCls  = $hoursSince === null ? 'offline' : ($hoursSince <= 6 ? 'online' : ($hoursSince <= 72 ? 'away' : 'offline'));

                    $hasProfileRoute = \Illuminate\Support\Facades\Route::has('teacher.students.show');
                    $joinedTimestamp = ($enrollment->created_at ?? null) instanceof \Illuminate\Support\Carbon
                        ? $enrollment->created_at->timestamp
                        : 0;
                ?>

                <article
                    class="s-card <?php echo e($accentClass); ?>"
                    style="animation-delay: <?php echo e($cardDelay); ?>"
                    role="listitem"
                    aria-label="<?php echo e($name); ?>, <?php echo e($progress); ?>% progress, <?php echo e($status); ?>"
                    data-name="<?php echo e(Str::lower($name)); ?>"
                    data-course="<?php echo e(Str::lower($course)); ?>"
                    data-status="<?php echo e($statusLower); ?>"
                    data-progress="<?php echo e($progress); ?>"
                    data-joined="<?php echo e($joinedTimestamp); ?>"
                >
                    <div class="s-card-inner">
                        
                        <div class="s-card__top">
                            <div class="s-avatar <?php echo e($av); ?>" aria-hidden="true">
                                <?php echo e($initials); ?>

                                <span class="s-avatar__badge <?php echo e($onlineCls); ?>" title="<?php echo e(ucfirst($onlineCls)); ?>"></span>
                            </div>
                            <div class="s-card__identity">
                                <div class="s-card__name" title="<?php echo e($name); ?>"><?php echo e($name); ?></div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($email): ?>
                                    <div class="s-card__email" title="<?php echo e($email); ?>"><?php echo e($email); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="s-card__course" title="<?php echo e($course); ?>">
                                    <svg width="10" height="10" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                        <path d="M8 2L2 5l6 3 6-3-6-3zM2 9l6 3 6-3M2 13l6 3 6-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <?php echo e($course); ?>

                                </div>
                            </div>
                        </div>

                        <hr class="s-divider">

                        
                        <div class="s-meta">
                            <span class="s-meta__label">Status</span>
                            <span class="s-pill <?php echo e($pillClass); ?>">
                                <span class="s-pill__dot" aria-hidden="true"></span>
                                <?php echo e($status); ?>

                            </span>
                        </div>

                        
                        <div class="s-card__body">
                            <div class="s-micro">
                                <div class="s-micro__label">Lessons</div>
                                <div class="s-micro__val">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalLessons > 0): ?>
                                        <?php echo e($lessons); ?>/<?php echo e($totalLessons); ?>

                                    <?php else: ?>
                                        —
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                            <div class="s-micro">
                                <div class="s-micro__label">Grade</div>
                                <div class="s-micro__val"><?php echo e($grade ?? '—'); ?></div>
                            </div>
                        </div>

                        
                        <div class="s-progress__row">
                            <span class="s-progress__lbl">Course progress</span>
                            <span class="s-progress__val"><?php echo e($progress); ?>%</span>
                        </div>
                        <div
                            class="s-progress__track"
                            role="progressbar"
                            aria-valuenow="<?php echo e($progress); ?>"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-label="<?php echo e($name); ?>: <?php echo e($progress); ?>% complete"
                        >
                            <div class="s-progress__bar <?php echo e($barClass); ?>" style="--pw:<?php echo e($progress); ?>%; --pd:<?php echo e($barDelay); ?>"></div>
                        </div>

                        
                        <div class="s-card__footer">
                            <span class="s-card__date">
                                <svg width="11" height="11" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <rect x="2" y="3" width="12" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M5 1v3M11 1v3M2 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($joined): ?> Joined <?php echo e($joined); ?> <?php else: ?> No date <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasProfileRoute): ?>
                                <div class="s-card__actions">
                                    <a href="<?php echo e(route('teacher.students.show', $enrollment->id)); ?>" class="s-action-btn" data-tip="View profile" aria-label="View <?php echo e($name); ?>'s profile">
                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none">
                                            <circle cx="8" cy="6" r="3" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M2.5 13.5c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </a>
                                    <a href="<?php echo e(route('teacher.students.show', $enrollment->id)); ?>" class="s-action-btn" data-tip="Message" aria-label="Open <?php echo e($name); ?>'s profile to message">
                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none">
                                            <path d="M2 2.5h12a1 1 0 0 1 1 1V10a1 1 0 0 1-1 1H9l-3 2.5V11H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    <a href="<?php echo e(route('teacher.students.show', $enrollment->id)); ?>" class="s-action-btn" data-tip="Progress" aria-label="See <?php echo e($name); ?>'s progress detail">
                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none">
                                            <path d="M2 12L5.5 7 9 9.5 13 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            
            <div class="sp-no-results" id="noResults" style="display:none;" role="status" aria-live="polite">
                <span class="sp-no-results__icon" aria-hidden="true">🔍</span>
                <p>No students match your search or filter.</p>
                <button type="button" class="sp-no-results__reset" id="resetFilters">Reset filters</button>
            </div>

        </div>

    <?php else: ?>

        
        <div class="sp-empty" role="status" aria-live="polite">
            <div class="sp-empty__icon" aria-hidden="true">👤</div>
            <h3>No students yet</h3>
            <p>Enrollments will appear here as learners join your courses. Share your course link to get started!</p>
        </div>

    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    'use strict';

    const grid = document.getElementById('studentGrid');
    if (!grid) return; // no students on this page

    const searchEl    = document.getElementById('studentSearch');
    const searchWrap  = document.getElementById('searchWrap');
    const searchClear = document.getElementById('searchClear');
    const sortEl      = document.getElementById('studentSort');
    const filterBtns  = Array.from(document.querySelectorAll('.sp-filter-btn'));
    const gridBtn     = document.getElementById('gridViewBtn');
    const listBtn     = document.getElementById('listViewBtn');
    const countEl     = document.getElementById('visibleNum');
    const filterCnt   = document.getElementById('filterCount');
    const noResults   = document.getElementById('noResults');
    const resetBtn    = document.getElementById('resetFilters');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const cards = () => Array.from(grid.querySelectorAll('.s-card'));

    let activeFilter = 'all';
    let searchQuery  = '';

    function debounce(fn, ms) {
        let t;
        return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), ms); };
    }

    function setActiveFilterButton(filter) {
        filterBtns.forEach(b => {
            const on = b.dataset.filter === filter;
            b.classList.toggle('is-active', on);
            b.setAttribute('aria-pressed', String(on));
        });
    }

    function applyFilters() {
        const q = searchQuery.trim().toLowerCase();
        let shown = 0;

        cards().forEach((card, idx) => {
            const name     = card.dataset.name     || '';
            const course   = card.dataset.course   || '';
            const status   = card.dataset.status   || '';
            const progress = Number(card.dataset.progress || 0);

            const matchFilter = activeFilter === 'all'
                || (activeFilter === 'completed' ? (status === 'completed' || progress >= 100) : status === activeFilter);
            const matchSearch = !q || name.includes(q) || course.includes(q);
            const visible = matchFilter && matchSearch;

            if (visible) {
                card.style.display = '';
                if (!reduceMotion) {
                    card.style.animationName = 'none';
                    requestAnimationFrame(() => {
                        card.style.animationDelay = Math.min(idx * 35, 500) + 'ms';
                        card.style.animationName = '';
                    });
                }
                shown++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noResults) noResults.style.display = shown === 0 ? 'block' : 'none';
        if (countEl)   countEl.textContent = shown;
        if (filterCnt) filterCnt.textContent = shown;
    }

    function applySort(value) {
        const items = cards();
        items.sort((a, b) => {
            switch (value) {
                case 'name-asc':  return a.dataset.name.localeCompare(b.dataset.name);
                case 'name-desc': return b.dataset.name.localeCompare(a.dataset.name);
                case 'prog-desc': return Number(b.dataset.progress) - Number(a.dataset.progress);
                case 'prog-asc':  return Number(a.dataset.progress) - Number(b.dataset.progress);
                case 'newest':    return Number(b.dataset.joined) - Number(a.dataset.joined);
                case 'oldest':    return Number(a.dataset.joined) - Number(b.dataset.joined);
                default:          return 0;
            }
        });
        const frag = document.createDocumentFragment();
        items.forEach(card => frag.appendChild(card));
        grid.appendChild(frag);
        applyFilters();
    }

    function setView(mode) {
        const isList = mode === 'list';
        grid.classList.toggle('list-view', isList);
        if (gridBtn) { gridBtn.classList.toggle('is-active', !isList); gridBtn.setAttribute('aria-pressed', String(!isList)); }
        if (listBtn) { listBtn.classList.toggle('is-active', isList); listBtn.setAttribute('aria-pressed', String(isList)); }
        try { localStorage.setItem('sp-view-mode', mode); } catch (e) {}
    }

    function updateSearchUI() {
        if (searchWrap) searchWrap.classList.toggle('has-value', searchQuery.length > 0);
    }

    // Filter buttons
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            activeFilter = btn.dataset.filter;
            setActiveFilterButton(activeFilter);
            applyFilters();
        });
    });

    // Search input
    if (searchEl) {
        const handleInput = debounce(value => {
            searchQuery = value;
            applyFilters();
        }, 180);

        searchEl.addEventListener('input', e => {
            updateSearchUI();
            handleInput(e.target.value);
        });
    }

    if (searchClear) {
        searchClear.addEventListener('click', () => {
            if (!searchEl) return;
            searchEl.value = '';
            searchQuery = '';
            updateSearchUI();
            applyFilters();
            searchEl.focus();
        });
    }

    // Sort select
    if (sortEl) sortEl.addEventListener('change', e => applySort(e.target.value));

    // View toggle
    if (gridBtn) gridBtn.addEventListener('click', () => setView('grid'));
    if (listBtn) listBtn.addEventListener('click', () => setView('list'));
    try {
        const savedView = localStorage.getItem('sp-view-mode');
        if (savedView === 'list') setView('list');
    } catch (e) {}

    // Reset filters
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            activeFilter = 'all';
            searchQuery = '';
            if (searchEl) searchEl.value = '';
            updateSearchUI();
            setActiveFilterButton('all');
            applyFilters();
        });
    }

    // Keyboard shortcuts: "/" focuses search, Escape clears it
    document.addEventListener('keydown', e => {
        const tag = document.activeElement && document.activeElement.tagName;
        const typing = tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT';

        if (e.key === '/' && !typing) {
            e.preventDefault();
            if (searchEl) searchEl.focus();
        }
        if (e.key === 'Escape' && document.activeElement === searchEl) {
            searchEl.value = '';
            searchQuery = '';
            updateSearchUI();
            applyFilters();
            searchEl.blur();
        }
    });

    // Clickable stat cards drive the filter pills
    document.querySelectorAll('.sp-stat[data-filter-target]').forEach(stat => {
        const target = stat.dataset.filterTarget;
        const activate = () => {
            const match = document.querySelector(`.sp-filter-btn[data-filter="${target}"]`);
            if (match) match.click();
        };
        stat.addEventListener('click', activate);
        stat.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); activate(); }
        });
    });

    // Re-trigger progress bar fill animation as cards enter the viewport
    if ('IntersectionObserver' in window && !reduceMotion) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target.querySelector('.s-progress__bar');
                    if (bar) {
                        bar.style.animationName = 'none';
                        requestAnimationFrame(() => { bar.style.animationName = ''; });
                    }
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.25 });

        cards().forEach(card => obs.observe(card));
    }

    // Initial render
    applyFilters();
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/teacher/students/index.blade.php ENDPATH**/ ?>