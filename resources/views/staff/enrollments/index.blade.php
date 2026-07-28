@extends('staff.layouts.masters')
@section('title', 'Enrollment Management')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ============================================================
   Enrollment Management — staff.layouts.masters child view
   Futuristic console / HUD theme
   ============================================================ */
:root {
    --em-void:         #090c12;
    --em-panel:        #10141d;
    --em-panel-soft:   #131826;

    --em-accent:       #5eead4;
    --em-accent-dark:  #34d3bd;
    --em-accent-light: rgba(94,234,212,.12);
    --em-violet:       #8b7cf6;
    --em-violet-light: rgba(139,124,246,.12);

    --em-success:      #34d399;
    --em-success-bg:   rgba(52,211,153,.12);
    --em-warning:      #fbbf24;
    --em-warning-bg:   rgba(251,191,36,.12);
    --em-danger:       #fb7185;
    --em-danger-bg:    rgba(251,113,133,.12);

    --em-gray-50:      #12161f;
    --em-gray-100:     #171c28;
    --em-gray-200:     #212739;
    --em-gray-400:     #838da3;
    --em-gray-600:     #aab2c4;
    --em-gray-900:     #e8ebf4;

    --em-radius:       12px;
    --em-radius-sm:    8px;
    --em-shadow:       0 1px 2px rgba(0,0,0,.35);
    --em-shadow-md:    0 10px 30px rgba(0,0,0,.55);

    --em-font:         'Inter', system-ui, sans-serif;
    --em-font-display: 'Space Grotesk', sans-serif;
    --em-font-mono:    'JetBrains Mono', monospace;
}

/* Page wrapper */
.em-page {
    font-family: var(--em-font);
    color: var(--em-gray-900);
    max-width: 1300px;
    background: var(--em-void);
    border-radius: 18px;
    padding: 28px;
    position: relative;
    isolation: isolate;
    overflow: hidden;
}
.em-page::before {
    content: '';
    position: absolute; inset: 0; z-index: -2;
    background:
        radial-gradient(circle at 10% -10%, rgba(139,124,246,.16), transparent 42%),
        radial-gradient(circle at 100% 8%, rgba(94,234,212,.10), transparent 40%);
}
.em-page::after {
    content: '';
    position: absolute; inset: 0; z-index: -1;
    background-image:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size: 34px 34px;
    mask-image: radial-gradient(ellipse 80% 55% at 50% 0%, black 25%, transparent 72%);
}

/* ── Page header ── */
.em-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}
.em-header__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--em-font-mono);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--em-accent);
    margin-bottom: 6px;
}
.em-header__eyebrow-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--em-accent);
    box-shadow: 0 0 0 3px var(--em-accent-light);
    animation: em-pulse 2.2s ease-in-out infinite;
}
.em-header__title {
    font-family: var(--em-font-display);
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -.4px;
    line-height: 1.2;
    background: linear-gradient(120deg, #ffffff 10%, var(--em-accent) 60%, var(--em-violet) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.em-header__subtitle {
    margin-top: 8px;
    font-size: 13.5px;
    color: var(--em-gray-400);
    max-width: 560px;
    line-height: 1.6;
}
.em-header__actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

/* ── Buttons ── */
.em-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 16px;
    border-radius: var(--em-radius-sm);
    font-size: 13.5px;
    font-weight: 600;
    font-family: var(--em-font);
    cursor: pointer;
    border: 1px solid transparent;
    text-decoration: none;
    transition: transform .15s ease, background .15s ease, box-shadow .15s ease, border-color .15s ease;
    white-space: nowrap;
}
.em-btn--primary {
    background: linear-gradient(135deg, var(--em-accent), #7ef0d8);
    color: #06120f;
    box-shadow: 0 4px 18px -6px rgba(94,234,212,.55);
}
.em-btn--primary:hover { transform: translateY(-1px); box-shadow: 0 6px 22px -6px rgba(94,234,212,.75); }
.em-btn--outline {
    background: rgba(255,255,255,.02);
    color: var(--em-gray-600);
    border: 1px solid var(--em-gray-200);
}
.em-btn--outline:hover { background: var(--em-violet-light); border-color: var(--em-violet); color: var(--em-gray-900); transform: translateY(-1px); }
.em-btn--danger {
    background: var(--em-danger-bg);
    color: var(--em-danger);
    border: 1px solid rgba(251,113,133,.35);
}
.em-btn--danger:hover { background: rgba(251,113,133,.2); transform: translateY(-1px); }
.em-btn--sm { padding: 6px 11px; font-size: 12px; }
.em-btn svg { flex-shrink: 0; }
.em-btn:focus-visible { outline: 2px solid var(--em-accent); outline-offset: 2px; }

/* ── Stat cards ── */
.em-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 28px;
}
.em-stat {
    background: linear-gradient(180deg, var(--em-panel), var(--em-panel-soft));
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius);
    padding: 20px 20px 18px;
    box-shadow: var(--em-shadow);
    position: relative;
    overflow: hidden;
    transition: border-color .2s ease, transform .2s ease;
}
.em-stat:hover { transform: translateY(-2px); border-color: var(--em-gray-400); }
.em-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background-size: 200% 100%;
    animation: em-sheen 4s linear infinite;
}
.em-stat--indigo::before  { background: linear-gradient(90deg, var(--em-accent), var(--em-violet), var(--em-accent)); }
.em-stat--green::before   { background: linear-gradient(90deg, var(--em-success), #6ee7b7, var(--em-success)); }
.em-stat--amber::before   { background: linear-gradient(90deg, var(--em-warning), #fde68a, var(--em-warning)); }
.em-stat--red::before     { background: linear-gradient(90deg, var(--em-danger), #fca5a5, var(--em-danger)); }
.em-stat__icon {
    width: 36px; height: 36px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px;
}
.em-stat--indigo .em-stat__icon { background: var(--em-accent-light); color: var(--em-accent); }
.em-stat--green  .em-stat__icon { background: var(--em-success-bg);   color: var(--em-success); }
.em-stat--amber  .em-stat__icon { background: var(--em-warning-bg);   color: var(--em-warning); }
.em-stat--red    .em-stat__icon { background: var(--em-danger-bg);    color: var(--em-danger); }
.em-stat__value {
    font-family: var(--em-font-display);
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -.6px;
    line-height: 1;
    color: var(--em-gray-900);
}
.em-stat__label {
    font-size: 12px;
    color: var(--em-gray-400);
    margin-top: 5px;
    font-weight: 500;
}
.em-stat__change {
    margin-top: 10px;
    font-family: var(--em-font-mono);
    font-size: 11.5px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
}
.em-stat__change--up   { color: var(--em-success); }
.em-stat__change--down { color: var(--em-danger); }

/* ── Purpose banner ── */
.em-purpose {
    background: linear-gradient(135deg, rgba(139,124,246,.08) 0%, rgba(94,234,212,.06) 100%);
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius);
    padding: 18px 22px;
    margin-bottom: 28px;
    display: flex;
    gap: 16px;
    align-items: flex-start;
}
.em-purpose__icon {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, var(--em-accent), var(--em-violet));
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: #06120f;
}
.em-purpose__label {
    font-family: var(--em-font-mono);
    font-size: 10.5px;
    font-weight: 500;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--em-accent);
    margin-bottom: 4px;
}
.em-purpose__text {
    font-size: 13.5px;
    color: var(--em-gray-600);
    line-height: 1.65;
}
.em-purpose__features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}
.em-purpose__tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 500;
    color: var(--em-accent);
    background: var(--em-panel);
    border: 1px solid var(--em-gray-200);
    border-radius: 99px;
    padding: 4px 11px;
    transition: border-color .15s ease;
}
.em-purpose__tag:hover { border-color: var(--em-accent); }

/* ── Filter / search bar ── */
.em-toolbar {
    background: var(--em-panel-soft);
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius);
    padding: 14px 16px;
    margin-bottom: 16px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
    box-shadow: var(--em-shadow);
}
.em-search {
    position: relative;
    flex: 1;
    min-width: 200px;
}
.em-search__icon {
    position: absolute;
    left: 11px; top: 50%;
    transform: translateY(-50%);
    color: var(--em-gray-400);
    pointer-events: none;
}
.em-search__input {
    width: 100%;
    padding: 9px 12px 9px 36px;
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius-sm);
    font-size: 13.5px;
    font-family: var(--em-font-mono);
    color: var(--em-gray-900);
    background: var(--em-void);
    outline: none;
    transition: border-color .15s, background .15s, box-shadow .15s;
}
.em-search__input::placeholder { color: #5a6377; }
.em-search__input:focus {
    border-color: var(--em-accent);
    background: #0b0f17;
    box-shadow: 0 0 0 3px var(--em-accent-light);
}
.em-select {
    padding: 9px 32px 9px 12px;
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius-sm);
    font-size: 13px;
    font-family: var(--em-font);
    color: var(--em-gray-600);
    background: var(--em-void);
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23838da3' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    transition: border-color .15s;
}
.em-select:focus { border-color: var(--em-accent); }
.em-toolbar__count {
    font-family: var(--em-font-mono);
    font-size: 12.5px;
    color: var(--em-gray-400);
    white-space: nowrap;
    margin-left: auto;
}

/* ── Table card ── */
.em-card {
    position: relative;
    background: linear-gradient(180deg, var(--em-panel), var(--em-panel-soft));
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius);
    box-shadow: var(--em-shadow);
    overflow: hidden;
    margin-bottom: 24px;
}
.em-card .em-corner { position: absolute; width: 16px; height: 16px; border: 2px solid var(--em-accent); opacity: .55; z-index: 2; pointer-events: none; }
.em-card .em-corner.tl { top: -1px; left: -1px; border-right: none; border-bottom: none; border-top-left-radius: 10px; }
.em-card .em-corner.tr { top: -1px; right: -1px; border-left: none; border-bottom: none; border-top-right-radius: 10px; }
.em-card .em-corner.bl { bottom: -1px; left: -1px; border-right: none; border-top: none; border-bottom-left-radius: 10px; }
.em-card .em-corner.br { bottom: -1px; right: -1px; border-left: none; border-top: none; border-bottom-right-radius: 10px; }

.em-table-wrap { overflow-x: auto; }
.em-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13.5px;
}
.em-table thead {
    background: rgba(255,255,255,.015);
    border-bottom: 1px solid var(--em-gray-200);
}
.em-table th {
    padding: 12px 16px;
    text-align: left;
    font-family: var(--em-font-mono);
    font-size: 10.5px;
    font-weight: 500;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--em-gray-400);
    white-space: nowrap;
}
.em-table th.sortable { cursor: pointer; user-select: none; transition: color .15s; }
.em-table th.sortable:hover { color: var(--em-accent); }
.em-table td {
    padding: 13px 16px;
    color: var(--em-gray-600);
    border-bottom: 1px solid var(--em-gray-100);
    vertical-align: middle;
}
.em-table tbody tr { transition: background .15s ease; }
.em-table tbody tr:last-child td { border-bottom: none; }
.em-table tbody tr:hover { background: rgba(94,234,212,.035); }

/* Student cell */
.em-student {
    display: flex;
    align-items: center;
    gap: 10px;
}
.em-student__avatar {
    width: 32px; height: 32px;
    border-radius: 9px;
    font-family: var(--em-font-display);
    font-size: 12px;
    font-weight: 700;
    color: #06120f;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.em-student__name {
    font-weight: 600;
    color: var(--em-gray-900);
    font-size: 13.5px;
}
.em-student__id {
    font-family: var(--em-font-mono);
    font-size: 11.5px;
    color: var(--em-gray-400);
}

/* Status badges */
.em-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 99px;
    font-family: var(--em-font-mono);
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .04em;
    white-space: nowrap;
}
.em-badge__dot {
    width: 5px; height: 5px;
    border-radius: 50%;
}
.em-badge--active   { background: var(--em-success-bg); color: var(--em-success); }
.em-badge--active .em-badge__dot { background: var(--em-success); box-shadow: 0 0 0 3px rgba(52,211,153,.16); animation: em-pulse 2.2s ease-in-out infinite; }
.em-badge--pending  { background: var(--em-warning-bg); color: var(--em-warning); }
.em-badge--pending .em-badge__dot { background: var(--em-warning); }
.em-badge--dropped  { background: var(--em-danger-bg);  color: var(--em-danger); }
.em-badge--dropped .em-badge__dot { background: var(--em-danger); }
.em-badge--complete { background: var(--em-accent-light); color: var(--em-accent); }
.em-badge--complete .em-badge__dot { background: var(--em-accent); }

/* Row actions */
.em-actions { display: flex; gap: 6px; align-items: center; }

/* Checkboxes */
.em-table input[type="checkbox"] {
    width: 15px; height: 15px;
    accent-color: var(--em-accent);
    cursor: pointer;
}

/* Pagination */
.em-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 13px 16px;
    border-top: 1px solid var(--em-gray-100);
    flex-wrap: wrap;
    gap: 10px;
}
.em-pagination__info { font-family: var(--em-font-mono); font-size: 12.5px; color: var(--em-gray-400); }
.em-pagination__pages { display: flex; gap: 4px; }
.em-page-btn {
    width: 32px; height: 32px;
    border-radius: var(--em-radius-sm);
    border: 1px solid var(--em-gray-200);
    background: var(--em-void);
    color: var(--em-gray-600);
    font-family: var(--em-font-mono);
    font-size: 13px;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .13s, border-color .13s, transform .13s;
    text-decoration: none;
}
.em-page-btn:hover { background: var(--em-accent-light); border-color: var(--em-accent); transform: translateY(-1px); }
.em-page-btn.is-active {
    background: linear-gradient(135deg, var(--em-accent), #7ef0d8);
    border-color: var(--em-accent);
    color: #06120f;
    font-weight: 700;
}

/* ── Enroll modal ── */
.em-modal-backdrop {
    position: fixed; inset: 0;
    background: rgba(5,8,14,.72);
    backdrop-filter: blur(3px);
    z-index: 200;
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
    opacity: 0;
    transition: opacity .18s ease;
}
.em-modal-backdrop[hidden] { display: none !important; }
.em-modal-backdrop.is-open { opacity: 1; }

.em-modal {
    background: linear-gradient(180deg, var(--em-panel), var(--em-panel-soft));
    border: 1px solid var(--em-gray-200);
    border-radius: 16px;
    width: 100%;
    max-width: 520px;
    box-shadow: var(--em-shadow-md), 0 0 40px -12px rgba(94,234,212,.25);
    overflow: hidden;
    transform: scale(.96) translateY(6px);
    transition: transform .18s ease;
}
.em-modal-backdrop.is-open .em-modal { transform: scale(1) translateY(0); }

.em-modal__header {
    padding: 22px 24px 18px;
    border-bottom: 1px solid var(--em-gray-100);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.em-modal__title {
    font-family: var(--em-font-display);
    font-size: 17px;
    font-weight: 700;
    color: var(--em-gray-900);
}
.em-modal__subtitle {
    font-size: 12.5px;
    color: var(--em-gray-400);
    margin-top: 3px;
}
.em-modal__close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--em-gray-400);
    padding: 6px;
    border-radius: 6px;
    line-height: 0;
    transition: color .13s, background .13s;
    flex-shrink: 0;
}
.em-modal__close:hover {
    color: var(--em-gray-900);
    background: var(--em-gray-100);
}
.em-modal__body { padding: 22px 24px; }
.em-modal__footer {
    padding: 16px 24px;
    border-top: 1px solid var(--em-gray-100);
    display: flex; gap: 10px; justify-content: flex-end;
}

/* Form fields inside modal */
.em-field { margin-bottom: 18px; }
.em-field:last-child { margin-bottom: 0; }
.em-label {
    display: block;
    font-family: var(--em-font-mono);
    font-size: 11.5px;
    font-weight: 500;
    letter-spacing: .04em;
    text-transform: uppercase;
    color: var(--em-gray-400);
    margin-bottom: 7px;
}
.em-label span { color: var(--em-danger); margin-left: 2px; }
.em-input, .em-field select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--em-gray-200);
    border-radius: var(--em-radius-sm);
    font-size: 13.5px;
    font-family: var(--em-font);
    color: var(--em-gray-900);
    background: var(--em-void);
    outline: none;
    transition: border-color .15s, box-shadow .15s, background .15s;
    box-sizing: border-box;
}
.em-input:focus, .em-field select:focus {
    border-color: var(--em-accent);
    background: #0b0f17;
    box-shadow: 0 0 0 3px var(--em-accent-light);
}
.em-field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.em-input-hint {
    font-size: 11.5px;
    color: var(--em-gray-400);
    margin-top: 5px;
}

/* ── Flash message ── */
.em-flash {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 16px;
    border-radius: var(--em-radius);
    margin-bottom: 20px;
    font-size: 13.5px;
    font-weight: 500;
}
.em-flash--success { background: var(--em-success-bg); color: var(--em-success); border: 1px solid rgba(52,211,153,.35); }
.em-flash--error   { background: var(--em-danger-bg);  color: var(--em-danger);  border: 1px solid rgba(251,113,133,.35); }

@keyframes em-pulse { 0%, 100% { opacity: 1; } 50% { opacity: .45; } }
@keyframes em-sheen { 0% { background-position: 0% 0; } 100% { background-position: 200% 0; } }

/* ── Responsive ── */
@media (max-width: 1024px) {
    .em-stats { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .em-stats { grid-template-columns: 1fr 1fr; gap: 10px; }
    .em-header { flex-direction: column; }
    .em-field-row { grid-template-columns: 1fr; }
    .em-toolbar { flex-direction: column; align-items: stretch; }
    .em-toolbar__count { margin-left: 0; }
    .em-modal { border-radius: 12px; }
}
@media (max-width: 420px) {
    .em-stats { grid-template-columns: 1fr; }
}
@media (prefers-reduced-motion: reduce) {
    .em-btn, .em-input, .em-search__input, .em-page-btn, .em-stat,
    .em-modal-backdrop, .em-modal, .em-header__eyebrow-dot, .em-badge__dot,
    .em-stat::before { transition: none; animation: none; }
}
</style>
@endpush

@section('content')
<div class="em-page">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="em-flash em-flash--success" role="alert">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 9l2.5 2.5 4-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="em-flash em-flash--error" role="alert">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="8" stroke="currentColor" stroke-width="1.5"/><path d="M9 5.5v4M9 12h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Page header ── --}}
    <div class="em-header">
        <div class="em-header__left">
            <div class="em-header__eyebrow">
                <span class="em-header__eyebrow-dot"></span>
                Staff Portal / Access Control
            </div>
            <h1 class="em-header__title">Enrollment Management</h1>
            <p class="em-header__subtitle">
                Register and manage student enrollments across courses and programs.
                Track records, assign courses, and keep student information accurate and up to date.
            </p>
        </div>
        <div class="em-header__actions">
            <a href="{{ route('staff.enrollments.export') }}" class="em-btn em-btn--outline">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M7.5 2v8M4 7l3.5 3.5L11 7M2 13h11"/></svg>
                Export
            </a>
            <button type="button" class="em-btn em-btn--primary" id="openEnrollBtn">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M7.5 2v11M2 7.5h11"/></svg>
                Enroll Student
            </button>
        </div>
    </div>

    {{-- ── Stat cards ── --}}
    <div class="em-stats">
        <div class="em-stat em-stat--indigo">
            <div class="em-stat__icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <circle cx="9" cy="6" r="3"/><path d="M2 16c0-3.314 3.134-6 7-6s7 2.686 7 6"/>
                </svg>
            </div>
            <div class="em-stat__value" data-count-to="{{ $stats['total'] ?? '1,248' }}">{{ $stats['total'] ?? '1,248' }}</div>
            <div class="em-stat__label">Total Enrollments</div>
            <div class="em-stat__change em-stat__change--up">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 10V2M2 6l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                12% this month
            </div>
        </div>
        <div class="em-stat em-stat--green">
            <div class="em-stat__icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <circle cx="9" cy="9" r="7"/><path d="M5.5 9l2.5 2.5 4.5-5"/>
                </svg>
            </div>
            <div class="em-stat__value" data-count-to="{{ $stats['active'] ?? '984' }}">{{ $stats['active'] ?? '984' }}</div>
            <div class="em-stat__label">Active</div>
            <div class="em-stat__change em-stat__change--up">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 10V2M2 6l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                8% this month
            </div>
        </div>
        <div class="em-stat em-stat--amber">
            <div class="em-stat__icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <circle cx="9" cy="9" r="7"/><path d="M9 5.5v4M9 12.5h.01"/>
                </svg>
            </div>
            <div class="em-stat__value" data-count-to="{{ $stats['pending'] ?? '183' }}">{{ $stats['pending'] ?? '183' }}</div>
            <div class="em-stat__label">Pending Approval</div>
            <div class="em-stat__change em-stat__change--down">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 2v8M2 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                3% this month
            </div>
        </div>
        <div class="em-stat em-stat--red">
            <div class="em-stat__icon">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                    <circle cx="9" cy="9" r="7"/><path d="M6 6l6 6M12 6l-6 6"/>
                </svg>
            </div>
            <div class="em-stat__value" data-count-to="{{ $stats['dropped'] ?? '81' }}">{{ $stats['dropped'] ?? '81' }}</div>
            <div class="em-stat__label">Dropped / Withdrawn</div>
            <div class="em-stat__change em-stat__change--up">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M6 10V2M2 6l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                2% this month
            </div>
        </div>
    </div>

    {{-- ── Purpose banner ── --}}
    <div class="em-purpose" role="note">
        <div class="em-purpose__icon">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 2L2 6l8 4 8-4-8-4zM2 10l8 4 8-4M2 14l8 4 8-4"/>
            </svg>
        </div>
        <div>
            <div class="em-purpose__label">Purpose</div>
            <div class="em-purpose__text">
                Facilitates the registration and enrollment of students into courses or programs.
                It helps track enrollment records, manage course assignments, and maintain accurate
                student information across the institution.
            </div>
            <div class="em-purpose__features">
                <span class="em-purpose__tag">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><circle cx="5.5" cy="5.5" r="4.5" stroke="currentColor" stroke-width="1.2"/><path d="M3.5 5.5l1.5 1.5 3-3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    Student Registration
                </span>
                <span class="em-purpose__tag">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><circle cx="5.5" cy="5.5" r="4.5" stroke="currentColor" stroke-width="1.2"/><path d="M3.5 5.5l1.5 1.5 3-3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    Course Assignment
                </span>
                <span class="em-purpose__tag">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><circle cx="5.5" cy="5.5" r="4.5" stroke="currentColor" stroke-width="1.2"/><path d="M3.5 5.5l1.5 1.5 3-3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    Record Tracking
                </span>
                <span class="em-purpose__tag">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><circle cx="5.5" cy="5.5" r="4.5" stroke="currentColor" stroke-width="1.2"/><path d="M3.5 5.5l1.5 1.5 3-3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    Status Management
                </span>
                <span class="em-purpose__tag">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><circle cx="5.5" cy="5.5" r="4.5" stroke="currentColor" stroke-width="1.2"/><path d="M3.5 5.5l1.5 1.5 3-3" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                    Data Export
                </span>
            </div>
        </div>
    </div>

    {{-- ── Toolbar ── --}}
    <form method="GET" action="{{ route('staff.enrollments.index') }}" class="em-toolbar">
        <div class="em-search">
            <svg class="em-search__icon" width="15" height="15" viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <circle cx="6.5" cy="6.5" r="4.5"/><path d="M10.5 10.5l3 3"/>
            </svg>
            <input
                type="text"
                name="search"
                class="em-search__input"
                placeholder="Search by name, ID, or course…"
                value="{{ request('search') }}"
                aria-label="Search enrollments"
            >
        </div>

        <select name="status" class="em-select" onchange="this.form.submit()" aria-label="Filter by status">
            <option value="">All Statuses</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
            <option value="dropped"  {{ request('status') === 'dropped'  ? 'selected' : '' }}>Dropped</option>
            <option value="complete" {{ request('status') === 'complete' ? 'selected' : '' }}>Completed</option>
        </select>

        <select name="course" class="em-select" onchange="this.form.submit()" aria-label="Filter by course">
            <option value="">All Courses</option>
            @foreach($courses ?? [] as $course)
                <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>

        <select name="year_level" class="em-select" onchange="this.form.submit()" aria-label="Filter by year level">
            <option value="">All Year Levels</option>
            <option value="1" {{ request('year_level') == '1' ? 'selected' : '' }}>Year 1</option>
            <option value="2" {{ request('year_level') == '2' ? 'selected' : '' }}>Year 2</option>
            <option value="3" {{ request('year_level') == '3' ? 'selected' : '' }}>Year 3</option>
            <option value="4" {{ request('year_level') == '4' ? 'selected' : '' }}>Year 4</option>
        </select>

        @if(request()->hasAny(['search','status','course','year_level']))
            <a href="{{ route('staff.enrollments.index') }}" class="em-btn em-btn--outline em-btn--sm">
                Clear filters
            </a>
        @endif

        <span class="em-toolbar__count">
            {{ $enrollments->total() ?? 0 }} record{{ ($enrollments->total() ?? 0) !== 1 ? 's' : '' }}
        </span>
    </form>

    {{-- ── Enrollments table ── --}}
    <div class="em-card">
        <div class="em-corner tl"></div><div class="em-corner tr"></div>
        <div class="em-corner bl"></div><div class="em-corner br"></div>
        <div class="em-table-wrap">
            <table class="em-table" aria-label="Enrollments">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" aria-label="Select all">
                        </th>
                        <th class="sortable">Student</th>
                        <th class="sortable">Student ID</th>
                        <th class="sortable">Course / Program</th>
                        <th>Year Level</th>
                        <th class="sortable">Date Enrolled</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments ?? [] as $enrollment)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected[]" value="{{ $enrollment->id }}" aria-label="Select {{ $enrollment->student->name }}">
                        </td>
                        <td>
                            <div class="em-student">
                                <div class="em-student__avatar" style="background: hsl({{ crc32($enrollment->student->name ?? '') % 360 }}, 72%, 62%)">
                                    {{ strtoupper(substr($enrollment->student->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="em-student__name">{{ $enrollment->student->name ?? '—' }}</div>
                                    <div class="em-student__id">{{ $enrollment->student->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-family: var(--em-font-mono); font-weight:600;color:var(--em-gray-900)">
                            {{ $enrollment->student->student_id ?? '—' }}
                        </td>
                        <td>
                            <div style="font-weight:500;color:var(--em-gray-900)">{{ $enrollment->course->name ?? '—' }}</div>
                            <div style="font-family: var(--em-font-mono); font-size:11.5px;color:var(--em-gray-400)">{{ $enrollment->course->code ?? '' }}</div>
                        </td>
                        <td>Year {{ $enrollment->year_level ?? '—' }}</td>
                        <td style="font-family: var(--em-font-mono); white-space:nowrap">
                            {{ $enrollment->enrolled_at ? \Carbon\Carbon::parse($enrollment->enrolled_at)->format('M d, Y') : '—' }}
                        </td>
                        <td>
                            @php $s = $enrollment->status ?? 'active'; @endphp
                            <span class="em-badge em-badge--{{ $s }}">
                                <span class="em-badge__dot"></span>
                                {{ ucfirst($s) }}
                            </span>
                        </td>
                        <td>
                            <div class="em-actions">
                                <a href="{{ route('staff.enrollments.show', $enrollment->id) }}"
                                   class="em-btn em-btn--outline em-btn--sm" title="View">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><ellipse cx="6.5" cy="6.5" rx="4.5" ry="3"/><circle cx="6.5" cy="6.5" r="1.2" fill="currentColor" stroke="none"/></svg>
                                    View
                                </a>
                                <a href="{{ route('staff.enrollments.edit', $enrollment->id) }}"
                                   class="em-btn em-btn--outline em-btn--sm" title="Edit">
                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9.5 2.5l1 1-7 7H2.5v-1l7-7z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('staff.enrollments.destroy', $enrollment->id) }}"
                                      onsubmit="return confirm('Remove this enrollment? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="em-btn em-btn--danger em-btn--sm" title="Remove">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3.5h9M5 3.5V2h3v1.5M5.5 6v3.5M7.5 6v3.5M3 3.5l.5 7h6l.5-7"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:56px 16px;color:var(--em-gray-400)">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" style="margin:0 auto 14px;display:block;opacity:.5"><circle cx="20" cy="20" r="18" stroke="currentColor" stroke-width="1.5"/><path d="M13 20h14M20 13v14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            <div style="font-family: var(--em-font-display); font-weight:600;color:var(--em-gray-900);margin-bottom:4px">No enrollments found</div>
                            <div style="font-size:13px">Try adjusting your filters or enroll a new student.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($enrollments) && $enrollments->hasPages())
        <div class="em-pagination">
            <span class="em-pagination__info">
                Showing {{ $enrollments->firstItem() }}–{{ $enrollments->lastItem() }} of {{ $enrollments->total() }}
            </span>
            <div class="em-pagination__pages">
                {{-- Previous --}}
                @if($enrollments->onFirstPage())
                    <button type="button" class="em-page-btn" disabled style="opacity:.4">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M8.5 10.5l-3-3.5 3-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                    </button>
                @else
                    <a href="{{ $enrollments->previousPageUrl() }}" class="em-page-btn">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M8.5 10.5l-3-3.5 3-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach($enrollments->getUrlRange(max(1, $enrollments->currentPage()-2), min($enrollments->lastPage(), $enrollments->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="em-page-btn {{ $page == $enrollments->currentPage() ? 'is-active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                {{-- Next --}}
                @if($enrollments->hasMorePages())
                    <a href="{{ $enrollments->nextPageUrl() }}" class="em-page-btn">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5.5 3.5l3 3.5-3 3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                    </a>
                @else
                    <button type="button" class="em-page-btn" disabled style="opacity:.4">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5.5 3.5l3 3.5-3 3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                    </button>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- ============================================================
         ENROLL STUDENT MODAL
         ============================================================ --}}
    <div id="enrollModal"
         class="em-modal-backdrop"
         hidden
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalTitle">

        <div class="em-modal" role="document">
            <div class="em-modal__header">
                <div>
                    <div class="em-modal__title" id="modalTitle">Enroll a Student</div>
                    <div class="em-modal__subtitle">Fill in the details to register a new enrollment.</div>
                </div>
                {{-- X CLOSE BUTTON --}}
                <button type="button"
                        class="em-modal__close"
                        id="closeEnrollBtn"
                        aria-label="Close dialog">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M4 4l10 10M14 4L4 14"/>
                    </svg>
                </button>
            </div>

            <form id="enrollForm" method="POST" action="{{ route('staff.enrollments.store') }}">
                @csrf
                <div class="em-modal__body">

                    <div class="em-field-row">
                        <div class="em-field">
                            <label class="em-label" for="student_id">Student <span>*</span></label>
                            <select id="student_id" name="student_id" class="em-input" required>
                                <option value="">Select student…</option>
                                @foreach($students ?? [] as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="em-field">
                            <label class="em-label" for="course_id">Course / Program <span>*</span></label>
                            <select id="course_id" name="course_id" class="em-input" required>
                                <option value="">Select course…</option>
                                @foreach($courses ?? [] as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="em-field-row">
                        <div class="em-field">
                            <label class="em-label" for="year_level">Year Level <span>*</span></label>
                            <select id="year_level" name="year_level" class="em-input" required>
                                <option value="">Select…</option>
                                <option value="1">Year 1</option>
                                <option value="2">Year 2</option>
                                <option value="3">Year 3</option>
                                <option value="4">Year 4</option>
                            </select>
                        </div>
                        <div class="em-field">
                            <label class="em-label" for="section">Section</label>
                            <input type="text" id="section" name="section" class="em-input" placeholder="e.g. A, B, Morning">
                        </div>
                    </div>

                    <div class="em-field-row">
                        <div class="em-field">
                            <label class="em-label" for="enrolled_at">Enrollment Date <span>*</span></label>
                            <input type="date" id="enrolled_at" name="enrolled_at" class="em-input"
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="em-field">
                            <label class="em-label" for="status">Status <span>*</span></label>
                            <select id="status" name="status" class="em-input" required>
                                <option value="active">Active</option>
                                <option value="pending">Pending Approval</option>
                            </select>
                        </div>
                    </div>

                    <div class="em-field">
                        <label class="em-label" for="notes">Notes</label>
                        <input type="text" id="notes" name="notes" class="em-input" placeholder="Any additional information…">
                        <div class="em-input-hint">Optional — visible only to staff.</div>
                    </div>

                </div>
                <div class="em-modal__footer">
                    {{-- CANCEL BUTTON --}}
                    <button type="button" class="em-btn em-btn--outline" id="cancelEnrollBtn">
                        Cancel
                    </button>
                    <button type="submit" class="em-btn em-btn--primary">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M7 1v12M1 7h12"/></svg>
                        Save Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>{{-- /.em-page --}}
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── Element references ── */
    var modal      = document.getElementById('enrollModal');
    var openBtn    = document.getElementById('openEnrollBtn');
    var closeBtn   = document.getElementById('closeEnrollBtn');   // X button
    var cancelBtn  = document.getElementById('cancelEnrollBtn');  // Cancel button
    var form       = document.getElementById('enrollForm');
    var selectAll  = document.getElementById('selectAll');

    /* ── Select-all checkbox ── */
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('input[name="selected[]"]').forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
        });
    }

    /* ── Dirty-state tracking ──
       We compare a serialised snapshot of the form taken right after
       open/reset to whatever the form looks like now.              */
    var cleanSnapshot = '';

    function snapshot() {
        if (!form) return '';
        var pairs = [];
        Array.from(new FormData(form).entries()).forEach(function (pair) {
            pairs.push(pair[0] + '=' + pair[1]);
        });
        return pairs.join('&');
    }

    function isDirty() {
        return snapshot() !== cleanSnapshot;
    }

    /* ── Open ── */
    function openModal() {
        if (!modal) return;

        // Reset first so snapshot captures the blank state
        if (form) {
            form.reset();
            // Restore today's date which reset() wipes
            var dateInput = form.querySelector('#enrolled_at');
            if (dateInput) {
                var today = new Date();
                var yyyy  = today.getFullYear();
                var mm    = String(today.getMonth() + 1).padStart(2, '0');
                var dd    = String(today.getDate()).padStart(2, '0');
                dateInput.value = yyyy + '-' + mm + '-' + dd;
            }
        }

        cleanSnapshot = snapshot();  // record the "empty" state

        modal.removeAttribute('hidden');
        document.body.style.overflow = 'hidden'; // prevent background scroll

        // Trigger the enter transition on the next frame
        requestAnimationFrame(function () {
            modal.classList.add('is-open');
        });

        // Focus the first interactive field inside the modal
        var firstField = modal.querySelector('select, input[type="text"], input[type="date"]');
        if (firstField) { firstField.focus(); }
    }

    /* ── Close ──
       force = true  → close immediately, no dirty-check (used by X button)
       force = false → ask if the user has made changes (used by Cancel & backdrop)
    */
    function closeModal(force) {
        if (!modal) return;

        if (!force && isDirty()) {
            if (!window.confirm('You have unsaved changes. Discard and close?')) {
                return; // user chose to stay
            }
        }

        modal.classList.remove('is-open');

        var finish = function () {
            modal.setAttribute('hidden', '');
            document.body.style.overflow = ''; // restore scroll
            if (form) { form.reset(); }
            cleanSnapshot = '';
            if (openBtn) { openBtn.focus(); }
        };

        if (prefersReducedMotion) {
            finish();
        } else {
            setTimeout(finish, 180); // matches the CSS transition duration
        }
    }

    /* ── Wire up buttons ── */

    // "Enroll Student" → open
    if (openBtn) {
        openBtn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal();
        });
    }

    // X button → close immediately (no dirty-check — user deliberately dismissed)
    if (closeBtn) {
        closeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            closeModal(true);  // force = true
        });
    }

    // Cancel button → close with dirty-check
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function (e) {
            e.preventDefault();
            closeModal(false); // force = false
        });
    }

    // Click on the dark backdrop (outside the white card) → close with dirty-check
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {       // only the backdrop itself, not children
                closeModal(false);
            }
        });
    }

    // Escape key → close with dirty-check
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && !modal.hasAttribute('hidden')) {
            closeModal(false);
        }
    });

    // When the form is actually submitted, clear dirty state so the
    // beforeunload / any future check doesn't interfere
    if (form) {
        form.addEventListener('submit', function () {
            cleanSnapshot = snapshot(); // mark current state as "clean"
        });
    }

    /* ── Stat count-up animation (purely decorative, doesn't touch data) ── */
    if (!prefersReducedMotion) {
        document.querySelectorAll('.em-stat__value[data-count-to]').forEach(function (el) {
            var target = el.getAttribute('data-count-to');
            var numeric = parseInt(target.replace(/[^0-9]/g, ''), 10);
            if (isNaN(numeric)) return;

            var duration = 900;
            var startTime = null;

            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                var current = Math.round(numeric * eased);
                el.textContent = current.toLocaleString();
                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.textContent = target; // restore exact original formatting
                }
            }
            el.textContent = '0';
            requestAnimationFrame(step);
        });
    }

})();
</script>
@endpush