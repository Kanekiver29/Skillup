{{-- ────────────────────────────────────────────
    Shared styles for ALL report section partials.
    Include once in show.blade.php via @include.
──────────────────────────────────────────────── --}}
<style>
    /* ── Report Section Common Styles ─────────────────── */
    .rs { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
          --bg:#f8fafc; --accent:#3b82f6; --success:#16a34a; --danger:#dc2626;
          --ease:cubic-bezier(.22,1,.36,1); }

    @keyframes rsFadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .rs-anim { opacity:0; animation:rsFadeUp .4s var(--ease) forwards; }

    /* ── Section Inner Header ─────────────────────────── */
    .rs-inner-header { padding:1.5rem 1.75rem; border-bottom:1px solid var(--line); display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
    .rs-inner-header h2 { margin:0 0 .25rem; font-size:1.2rem; font-weight:800; color:var(--ink); }
    .rs-inner-header p { margin:0; font-size:.88rem; color:var(--sub); }

    /* ── Meta Row (Student, Period, Status) ───────────── */
    .rs-meta-row { padding:1.25rem 1.75rem; background:var(--bg); border-bottom:1px solid var(--line); display:flex; flex-wrap:wrap; gap:2rem; }
    .rs-meta-item .label { font-size:.7rem; text-transform:uppercase; letter-spacing:.1em; font-weight:700; color:var(--muted); margin-bottom:.3rem; }
    .rs-meta-item .val { font-size:.95rem; font-weight:700; color:var(--ink); }
    .rs-meta-item .val.blue { color:var(--accent); }

    /* ── Table ────────────────────────────────────────── */
    .rs-table-wrap { overflow-x:auto; }
    .rs-table { width:100%; border-collapse:collapse; font-size:.88rem; text-align:left; }
    .rs-table thead { background:var(--bg); }
    .rs-table thead th { padding:.8rem 1.1rem; font-size:.72rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--muted); border-bottom:1px solid var(--line); }
    .rs-table tbody td { padding:.95rem 1.1rem; border-bottom:1px solid var(--line); color:var(--sub); vertical-align:middle; }
    .rs-table tbody tr:last-child td { border-bottom:none; }
    .rs-table tbody tr { transition:background .1s ease; }
    .rs-table tbody tr:hover { background:#f8fafc; }
    .rs-table .bold { font-weight:700; color:var(--ink); }

    /* ── Badge ────────────────────────────────────────── */
    .rs-badge { display:inline-flex; align-items:center; padding:.2rem .6rem; border-radius:999px; font-size:.7rem; font-weight:700; }
    .rs-badge.pass { background:#dcfce7; color:#15803d; }
    .rs-badge.fail { background:#fee2e2; color:#b91c1c; }
    .rs-badge.inc  { background:#fef3c7; color:#92400e; }
    .rs-badge.info { background:#eff6ff; color:#1e40af; }

    /* ── GWA Sidebar ──────────────────────────────────── */
    .rs-sidebar { padding:1.5rem; background:var(--bg); border-left:1px solid var(--line); min-width:230px; }
    .rs-sidebar-card { background:#fff; border:1px solid var(--line); border-radius:12px; padding:1.25rem; margin-bottom:1rem; }
    .rs-sidebar-card .label { font-size:.7rem; text-transform:uppercase; letter-spacing:.12em; font-weight:700; color:var(--muted); margin-bottom:.6rem; }
    .rs-sidebar-card .big-val { font-size:2.5rem; font-weight:800; color:var(--ink); line-height:1; }
    .rs-sidebar-card .big-val.pass { color:var(--success); }
    .rs-sidebar-card .big-val.fail { color:var(--danger); }
    .rs-sidebar-card dl { font-size:.85rem; display:grid; gap:.5rem; margin:0; }
    .rs-sidebar-card dl .row { display:flex; justify-content:space-between; align-items:center; padding:.35rem 0; border-bottom:1px solid var(--bg); }
    .rs-sidebar-card dl .row:last-child { border-bottom:none; }
    .rs-sidebar-card dl dt { font-weight:600; color:var(--ink); }
    .rs-sidebar-card dl dd { margin:0; color:var(--sub); font-weight:700; }

    /* ── Empty state ──────────────────────────────────── */
    .rs-empty { padding:3.5rem 1rem; text-align:center; color:var(--muted); }
    .rs-empty svg { width:46px; height:46px; margin:0 auto .75rem; opacity:.25; display:block; }
    .rs-empty p { margin:0; font-size:.9rem; }

    /* ── Main+Sidebar layout ──────────────────────────── */
    .rs-grid { display:grid; grid-template-columns:1fr 260px; }
    @media (max-width:860px) { .rs-grid { grid-template-columns:1fr; } .rs-sidebar { border-left:none; border-top:1px solid var(--line); } }
</style>
