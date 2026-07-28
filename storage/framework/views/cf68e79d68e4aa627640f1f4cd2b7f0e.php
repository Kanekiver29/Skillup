<style>
:root{
    --primary-600: #0284c7;
    --primary-500: #0ea5e9;
    --muted-700: #475569;
    --accent-1: rgba(14,165,233,0.16);
    --dur-fast: 0.32s;
    --dur-medium: 0.48s;
}

/* Buttons & Pills */
.pill, .quiz-pill { display:inline-flex; align-items:center; gap:0.5rem; padding:0.4rem 0.75rem; border-radius:999px; background:rgba(14,165,233,0.08); color:#04263a; font-weight:700; }
.button-primary, .quiz-button, .submit-button { display:inline-flex; align-items:center; gap:0.6rem; padding:0.6rem 1rem; border-radius:0.9rem; background:linear-gradient(135deg,var(--primary-600),var(--primary-500)); color:#fff; font-weight:700; box-shadow:0 10px 30px -18px rgba(14,165,233,0.5); border:none; }
.button-primary:disabled, .quiz-button:disabled, .submit-button:disabled { opacity:.68; cursor:not-allowed; }
.quiz-spinner { width:18px; height:18px; display:inline-block; }

/* Form elements */
.field-input, .field-select, .field-textarea, .search-input { width:100%; padding:0.75rem 1rem; border-radius:0.75rem; border:1px solid rgba(148,163,184,0.12); background:#fff; }
.field-input:focus, .field-select:focus, .field-textarea:focus, .search-input:focus { outline: 2px solid rgba(2,132,199,0.12); box-shadow:0 8px 20px -12px rgba(14,165,233,0.08); }
.field-error { color:#dc2626; margin-top:0.45rem; font-size:0.95rem; }

/* Progress */
.quiz-progress-rail { height:6px; background:linear-gradient(90deg,#e6f6ff,var(--accent-1)); border-radius:999px; overflow:hidden; margin-bottom:1rem; }
.quiz-progress-fill { width:0%; height:100%; background:linear-gradient(90deg,var(--primary-600),var(--primary-500)); transition:width 420ms cubic-bezier(.2,.9,.3,1); }

/* Badges */
.score-badge, .badge { display:inline-flex; gap:0.4rem; align-items:center; padding:0.35rem 0.65rem; border-radius:999px; font-weight:700; }
.badge.good{ background:#ecfdf5; color:#087f5b; }
.badge.warn{ background:#fffbeb; color:#b45309; }
.badge.bad{ background:#fff1f2; color:#be123c; }

/* Utilities */
:focus{ outline:2px solid rgba(2,132,199,0.18); outline-offset:2px; }
.sr-only{ position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0; }

/* Layout helpers used across list & create */
.container-small, .create-layout { max-width:1120px; margin:0 auto; padding:1.25rem; }
.grid-two { display:grid; grid-template-columns:1.4fr 0.6fr; gap:1rem; }
.card, .quiz-form-card, .quiz-info-panel { background:#fff; border-radius:1rem; border:1px solid rgba(148,163,184,0.06); padding:1rem; box-shadow:0 18px 60px -40px rgba(2,6,23,0.04); }

.quiz-stat-grid { display:grid; gap:1rem; grid-template-columns:repeat(3,minmax(0,1fr)); }
.quiz-stat-block { background: linear-gradient(90deg, #ffffff, #f8fbff); border:1px solid rgba(148,163,184,0.12); border-radius:1.5rem; padding:1rem 1.2rem; box-shadow:0 16px 40px -28px rgba(15,23,42,0.1); }
.quiz-stat-label { display:block; font-size:0.75rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#64748b; margin-bottom:0.65rem; }
.quiz-stat-value { font-size:2.1rem; font-weight:800; color:#0f172a; }
.quiz-tip-list { display:grid; gap:0.9rem; margin-top:1rem; }
.quiz-tip-item { display:grid; grid-template-columns:auto 1fr; gap:0.9rem; align-items:flex-start; background:#f8fafc; border:1px solid rgba(148,163,184,0.12); border-radius:1.35rem; padding:1rem 1rem 1rem 1.1rem; }
.quiz-tip-item::before { content:''; width:0.65rem; height:0.65rem; border-radius:999px; background:#0284c7; margin-top:0.75rem; }
.quiz-tip-item p { margin:0; color:#475569; font-size:0.95rem; line-height:1.75; }

@media (max-width:900px){ .grid-two, .form-grid { grid-template-columns:1fr !important; } .actions-cell{ text-align:left; } .submit-group { flex-direction:column; align-items:stretch; } .submit-button, .cancel-button { width:100%; } }

@keyframes spin { to { transform: rotate(360deg); } }
@keyframes pulseScale { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.04); } }
@keyframes progressGrow { from { width: 0%; } to { width: 100%; } }

/* Small animations */
@keyframes fadeSlideUp { from{opacity:0; transform:translateY(18px);} to{opacity:1; transform:translateY(0);} }
@keyframes fadeUp { from{opacity:0; transform:translateY(8px);} to{opacity:1; transform:none;} }
@keyframes scaleIn { from{transform:scale(.98);opacity:0} to{transform:none;opacity:1} }
.pulse{ animation:scaleIn 420ms ease both; }

.quiz-page-header,
.quiz-stats-card,
.quiz-card,
.quiz-empty-state,
.quiz-alert {
    opacity:0;
    animation:fadeSlideUp 0.48s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.quiz-page-header { position:relative; background: linear-gradient(135deg, rgba(2,132,199,0.08), rgba(14,165,233,0.04)); border-radius:1.25rem; padding:1.25rem; border:1px solid rgba(14,165,233,0.06); }
.quiz-page-header::after { content:''; position:absolute; right:1.25rem; top:0.9rem; width:96px; height:96px; border-radius:50%; background:var(--accent-1); filter:blur(18px); opacity:0.9; pointer-events:none; }

.quiz-card { background: linear-gradient(180deg,#ffffff,#fbfdff); border-radius:1.5rem; border:1px solid rgba(148,163,184,0.07); box-shadow:0 18px 60px -40px rgba(2,6,23,0.06); }

.quiz-stats-card .quiz-stat-value { font-size:1.9rem; font-weight:800; color:#0f172a; }
.quiz-stats-card .rounded-3xl { border-radius:1rem; }

.quiz-table { width:100%; border-collapse:separate; border-spacing:0 0.9rem; }
.quiz-table thead th { padding:1rem 1.4rem; text-align:left; font-size:0.72rem; letter-spacing:0.16em; text-transform:uppercase; font-weight:700; color:#475569; background:rgba(248,250,252,0.96); border-bottom:1px solid rgba(148,163,184,0.12); }
.quiz-table thead th:last-child { text-align:right; }
.quiz-row {
    opacity:0;
    animation: fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
    transition: transform var(--dur-fast), box-shadow var(--dur-fast), opacity var(--dur-fast);
}
.quiz-row td { background: rgba(255,255,255,0.92); border-radius:1.5rem; border:1px solid rgba(148,163,184,0.08); padding:1.3rem 1.35rem; vertical-align:middle; backdrop-filter: blur(6px); }
.quiz-row:nth-child(odd) td { background: rgba(248,250,252,0.94); }
.quiz-row:hover td { transform: translateY(-4px); box-shadow: 0 24px 70px -30px rgba(2,6,23,0.12); }

.quiz-icon-tile { width:48px; height:48px; border-radius:14px; display:inline-flex; align-items:center; justify-content:center; background:linear-gradient(135deg, rgba(14,165,233,0.12), rgba(56,189,248,0.06)); color:var(--primary-600); box-shadow: inset 0 0 0 1px rgba(14,165,233,0.14); transition: transform 0.25s ease, box-shadow 0.25s ease; }
.quiz-row:hover .quiz-icon-tile { transform: translateY(-2px) scale(1.03); box-shadow: inset 0 0 0 1px rgba(14,165,233,0.18); }

.quiz-highlight { display:inline-block; padding:0.08rem 0.28rem; border-radius:0.45rem; background:rgba(14,165,233,0.14); color:#0f172a; }
.pill-pulse { animation:pulseScale 0.8s ease both; }
.pulse-cta-once { animation:pulseScale 1.4s ease-out both; }
.quiz-spin { animation:spin 0.75s linear infinite; }
.quiz-alert-progress { display:block; width:0%; height:6px; margin-top:1rem; border-radius:999px; background:linear-gradient(90deg, rgba(14,165,233,0.95), rgba(56,189,248,0.75)); animation:progressGrow 5s linear forwards; }
.quiz-empty-state { animation: fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) both; }

.quiz-pill, .pill { font-size:0.83rem; padding:0.65rem 1rem; border-radius:999px; border:1px solid rgba(14,165,233,0.15); background:rgba(14,165,233,0.08); color:#0f172a; }
.quiz-pill.secondary, .pill.secondary { background:rgba(148,163,184,0.12); border-color:rgba(148,163,184,0.16); color:#475569; }
.quiz-search-input, .search-input { width:100%; padding:0.9rem 1rem 0.9rem 3rem; border-radius:1.25rem; border:1px solid rgba(148,163,184,0.16); background:#fff; box-shadow: inset 0 1px 2px rgba(15,23,42,0.05); transition:box-shadow 0.22s ease, border-color 0.22s ease, transform 0.22s ease; }
.quiz-search-input:focus, .search-input:focus { outline:none; border-color:rgba(14,165,233,0.55); box-shadow:0 0 0 5px rgba(14,165,233,0.12); transform:translateY(-1px); }
.quiz-search-input::placeholder { color:#94a3b8; }
.quiz-search-clear { position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); display:none; align-items:center; justify-content:center; width:1.8rem; height:1.8rem; border-radius:999px; background:rgba(148,163,184,0.08); color:#64748b; border:none; cursor:pointer; transition:background-color 0.2s ease, color 0.2s ease, transform 0.2s ease; }
.quiz-search-clear:hover { background:rgba(148,163,184,0.16); color:#334155; transform:scale(1.05); }
.quiz-search-clear.is-visible { display:inline-flex; }

.quiz-badge { padding:0.35rem 0.6rem; border-radius:999px; font-weight:700; font-size:0.82rem; }
.quiz-badge.good{ background:#ecfdf5; color:#047857; }
.quiz-badge.warn{ background:#fffbeb; color:#92400e; }
.quiz-badge.bad{ background:#fff1f2; color:#9f1239; }

.quiz-actions a, .quiz-actions button { text-decoration:none; }
.quiz-action {
    display:inline-flex;
    align-items:center;
    gap:0.4rem;
    padding:0.55rem 0.85rem;
    border-radius:0.95rem;
    background:rgba(248,250,252,0.95);
    color:#475569;
    transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
    border:1px solid rgba(148,163,184,0.15);
}
.quiz-action:hover,
.quiz-action:focus-visible {
    transform: translateY(-1px);
    background:rgba(255,255,255,0.98);
    box-shadow:0 12px 28px -18px rgba(15,23,42,0.16);
}
.quiz-action.primary {
    background:linear-gradient(135deg, var(--primary-600), var(--primary-500));
    color:#fff;
    border-color:transparent;
    box-shadow:0 12px 32px -18px rgba(2,132,199,0.45);
}
.quiz-action.secondary {
    background:#f8fafc;
    color:#0f172a;
    border-color:rgba(148,163,184,0.18);
}
.quiz-modal-overlay {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
}
.quiz-modal-box {
    border-radius: 1.75rem;
    box-shadow: 0 32px 90px rgba(15, 23, 42, 0.18);
    transition: transform 0.25s ease, opacity 0.25s ease;
}
.quiz-modal-box:focus-within {
    outline: 2px solid rgba(2,132,199,0.2);
    outline-offset: 4px;
}

@media (max-width:640px) {
    .quiz-page-header::after { display:none; }
    .quiz-stats-card .quiz-stat-value { font-size:1.5rem; }
}

</style><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/quizzes/_styles.blade.php ENDPATH**/ ?>