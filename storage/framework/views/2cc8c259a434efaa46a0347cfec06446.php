<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale() === 'tl' ? 'tl' : 'en'); ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <meta id="themeColorMeta" name="theme-color" content="#eef1f6" />
  <meta id="colorSchemeMeta" name="color-scheme" content="light" />
  <title><?php echo $__env->yieldContent('title', 'SIAS — TESDA Administration'); ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="icon" href="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

  <script>
    // Resolve theme + sidebar state before first paint.
    (function () {
      var saved = localStorage.getItem('sias-theme');
      var dark = saved ? saved === 'dark' : matchMedia('(prefers-color-scheme: dark)').matches;
      if (dark) document.documentElement.classList.add('dark-mode');
      var meta = document.getElementById('themeColorMeta');
      if (meta) meta.setAttribute('content', dark ? '#070d17' : '#eef1f6');
      var scheme = document.getElementById('colorSchemeMeta');
      if (scheme) scheme.setAttribute('content', dark ? 'dark' : 'light');
      try {
        if (localStorage.getItem('sias-sidebar-collapsed') === '1') {
          document.documentElement.classList.add('sidebar-collapsed');
        }
      } catch (e) {}
    })();
  </script>

  <style>
    /* ============================================================
       SIAS · TESDA administration shell
       Palette is drawn from the agency's institutional blue and the
       national flag's gold. Gold is structural only — it marks the
       seam between navigation and work, and the item you are on.
       ============================================================ */
    :root {
      --ease: cubic-bezier(.2, .7, .3, 1);
      --dur-fast: .13s;
      --dur: .24s;

      --sidebar-w: 268px;
      --sidebar-w-collapsed: 76px;

      --font-display: 'Sora', system-ui, sans-serif;
      --font-body: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
      --font-mono: 'IBM Plex Mono', ui-monospace, Menlo, monospace;

      /* Light */
      --bg: #eef1f6;
      --surface: #ffffff;
      --surface-sunken: #f6f8fb;
      --text: #111d30;
      --text-muted: #5d6c85;
      --line: #dde3ed;
      --line-strong: #c8d2e1;

      --navy: #062647;
      --navy-2: #0a3663;
      --nav-text: #a8bad3;
      --nav-text-strong: #ffffff;

      --accent: #0d5296;
      --accent-soft: #e8effa;
      --accent-text: #ffffff;
      --gold: #e9b418;

      --danger: #c0392f;
      --success: #12703a;
      --warning: #b07907;

      --radius-sm: 8px;
      --radius: 12px;
      --radius-lg: 14px;

      --shadow-sm: 0 1px 2px rgba(6, 38, 71, .06);
      --shadow: 0 1px 3px rgba(6, 38, 71, .06), 0 10px 24px -18px rgba(6, 38, 71, .4);
      --shadow-lg: 0 2px 8px rgba(6, 38, 71, .07), 0 24px 48px -24px rgba(6, 38, 71, .45);
      --overlay: rgba(6, 20, 38, .48);
    }

    html.dark-mode {
      --bg: #070d17;
      --surface: #0f1725;
      --surface-sunken: #0b1320;
      --text: #e4eaf4;
      --text-muted: #91a2bd;
      --line: #1d2941;
      --line-strong: #2a3852;

      --navy: #040c18;
      --navy-2: #08172c;
      --nav-text: #90a3c0;
      --nav-text-strong: #ffffff;

      --accent: #4e9ae8;
      --accent-soft: #12243c;
      --accent-text: #05121f;
      --gold: #f0c343;

      --danger: #e8726a;
      --success: #3ec98a;
      --warning: #eab53f;

      --shadow-sm: 0 1px 2px rgba(0, 0, 0, .4);
      --shadow: 0 1px 3px rgba(0, 0, 0, .45), 0 12px 28px -20px rgba(0, 0, 0, .8);
      --shadow-lg: 0 2px 10px rgba(0, 0, 0, .5), 0 28px 56px -26px rgba(0, 0, 0, .85);
      --overlay: rgba(0, 0, 0, .6);
    }

    * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
    html { background: var(--bg); }

    body {
      margin: 0;
      font-family: var(--font-body);
      font-size: 15px;
      line-height: 1.55;
      color: var(--text);
      background: var(--bg);
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      transition: background var(--dur) var(--ease), color var(--dur) var(--ease);
    }

    :focus-visible {
      outline: 2px solid var(--accent);
      outline-offset: 2px;
      border-radius: 3px;
    }

    .skip-link {
      position: fixed;
      top: -56px; left: 14px;
      z-index: 300;
      background: var(--navy);
      color: #fff;
      font-size: .85rem;
      font-weight: 600;
      padding: .6rem 1rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      box-shadow: var(--shadow-lg);
      transition: top var(--dur) var(--ease);
    }
    .skip-link:focus { top: 14px; }

    /* Navigation progress — the only ambient motion in the shell. */
    #pageProgress {
      position: fixed;
      inset: 0 auto auto 0;
      height: 2px;
      width: 0;
      z-index: 100;
      background: var(--gold);
      opacity: 0;
      pointer-events: none;
      transition: width .4s var(--ease), opacity .2s linear .1s;
    }
    #pageProgress.running { opacity: 1; width: 72%; transition: width 2.4s var(--ease); }
    #pageProgress.done { opacity: 1; width: 100%; transition: width .2s var(--ease); }

    .admin-shell { display: flex; min-height: 100vh; min-height: 100dvh; }

    /* ---------------- Sidebar ---------------- */
    .admin-sidebar {
      width: var(--sidebar-w);
      flex-shrink: 0;
      position: sticky;
      top: 0;
      align-self: flex-start;
      height: 100vh;
      height: 100dvh;
      z-index: 5;
      display: flex;
      flex-direction: column;
      padding: 24px 16px 18px;
      color: var(--nav-text);
      background: linear-gradient(180deg, var(--navy), var(--navy-2));
      /* The gold seam: one structural line, no glow. */
      border-right: 1px solid rgba(255, 255, 255, .06);
      box-shadow: inset -3px 0 0 -1px var(--gold);
      transition: width var(--dur) var(--ease), transform var(--dur) var(--ease);
    }

    .sidebar-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 0 4px;
    }

    .sidebar-head h1 {
      display: flex;
      align-items: center;
      gap: 11px;
      margin: 0;
      font-family: var(--font-display);
      font-size: 1.04rem;
      font-weight: 600;
      letter-spacing: -.015em;
      color: var(--nav-text-strong);
      white-space: nowrap;
      overflow: hidden;
    }

    .mark {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px; height: 32px;
      flex-shrink: 0;
      border-radius: 9px;
      background: rgba(255, 255, 255, .07);
      border: 1px solid rgba(255, 255, 255, .12);
      color: var(--gold);
    }

    .head-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }

    .sidebar-icon-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 30px; height: 30px;
      flex-shrink: 0;
      border-radius: 7px;
      border: 1px solid rgba(255, 255, 255, .1);
      background: transparent;
      color: var(--nav-text);
      cursor: pointer;
      transition: background var(--dur-fast) var(--ease), color var(--dur-fast) var(--ease);
    }
    .sidebar-icon-btn:hover { background: rgba(255, 255, 255, .09); color: var(--nav-text-strong); }
    .sidebar-close { display: none; }
    .rail-toggle svg { transition: transform .3s var(--ease); }
    .rail-toggle.flipped svg { transform: rotate(180deg); }
    @media (max-width: 1024px) { .rail-toggle { display: none; } }

    .sidebar-brandline {
      margin: 14px 4px 18px;
      padding-bottom: 16px;
      border-bottom: 1px solid rgba(255, 255, 255, .08);
      font-size: .78rem;
      line-height: 1.45;
      color: var(--nav-text);
    }
    .sidebar-brandline b { color: #fff; font-weight: 600; }

    /* ---------------- Nav ---------------- */
    .admin-sidebar nav {
      flex: 1;
      min-height: 0;
      overflow-y: auto;
      overflow-x: hidden;
      padding-right: 4px;
      margin-right: -4px;
      overscroll-behavior: contain;
      scrollbar-width: thin;
      scrollbar-color: rgba(168, 186, 211, .3) transparent;
    }
    .admin-sidebar nav::-webkit-scrollbar { width: 5px; }
    .admin-sidebar nav::-webkit-scrollbar-track { background: transparent; }
    .admin-sidebar nav::-webkit-scrollbar-thumb { background: rgba(168, 186, 211, .28); border-radius: 99px; }

    .admin-sidebar nav a {
      position: relative;
      display: flex;
      align-items: center;
      padding: .56rem .8rem;
      border-radius: var(--radius-sm);
      color: var(--nav-text);
      font-size: .9rem;
      font-weight: 450;
      text-decoration: none;
      transition: background var(--dur-fast) var(--ease), color var(--dur-fast) var(--ease);
    }
    .admin-sidebar nav a + a { margin-top: 1px; }
    .admin-sidebar nav a:hover { background: rgba(255, 255, 255, .06); color: var(--nav-text-strong); }

    .admin-sidebar nav a.active {
      color: var(--nav-text-strong);
      font-weight: 600;
      background: rgba(255, 255, 255, .08);
    }
    .admin-sidebar nav a.active::before {
      content: '';
      position: absolute;
      left: 0; top: 50%;
      width: 3px; height: 16px;
      margin-top: -8px;
      border-radius: 0 3px 3px 0;
      background: var(--gold);
    }

    .nav-group-btn {
      all: unset;
      box-sizing: border-box;
      display: flex;
      align-items: center;
      gap: 11px;
      width: 100%;
      padding: .58rem .8rem;
      margin-top: 10px;
      border-radius: var(--radius-sm);
      cursor: pointer;
      color: var(--nav-text);
      font-family: var(--font-body);
      font-size: .82rem;
      font-weight: 600;
      letter-spacing: -.005em;
      transition: background var(--dur-fast) var(--ease), color var(--dur-fast) var(--ease);
    }
    .nav-group-btn:hover, .nav-group-btn.open { color: var(--nav-text-strong); background: rgba(255, 255, 255, .05); }
    .nav-group-btn .nav-group-icon { display: inline-flex; width: 16px; height: 16px; flex-shrink: 0; opacity: .8; }
    .nav-group-btn .nav-group-label { flex: 1; text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .nav-group-btn .nav-group-chevron { flex-shrink: 0; opacity: .7; transition: transform .28s var(--ease); }
    .nav-group-btn.open .nav-group-chevron { transform: rotate(90deg); }

    .nav-sub-wrap { display: grid; grid-template-rows: 0fr; transition: grid-template-rows .28s var(--ease); }
    .nav-sub-wrap.open { grid-template-rows: 1fr; }
    .nav-sub-wrap > .nav-sub-inner { overflow: hidden; min-height: 0; }

    /* Sub-items hang off a hairline, so nesting is legible without indentation noise. */
    .nav-sub { padding-left: 22px; margin-left: 14px; border-left: 1px solid rgba(255, 255, 255, .1); }
    .nav-sub a { font-size: .855rem; padding-top: .46rem; padding-bottom: .46rem; }
    .nav-sub a.active::before { left: -23px; }

    .nav-flat a .nav-item-icon { display: inline-flex; width: 16px; height: 16px; flex-shrink: 0; margin-right: 11px; opacity: .8; }
    .nav-flat { margin-top: 2px; }

    .sidebar-status {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 14px 0 12px;
      padding: 0 .8rem;
      font-size: .74rem;
      color: var(--nav-text);
      white-space: nowrap;
      overflow: hidden;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--success); flex-shrink: 0; }

    .sidebar-actions {
      display: flex;
      flex-direction: column;
      gap: .5rem;
      padding-top: 16px;
      border-top: 1px solid rgba(255, 255, 255, .08);
    }

    /* ---------------- Buttons ---------------- */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: .55rem;
      position: relative;
      width: 100%;
      padding: .68rem 1rem;
      border: 1px solid transparent;
      border-radius: var(--radius-sm);
      font: 600 .88rem/1 var(--font-body);
      text-decoration: none;
      cursor: pointer;
      background: var(--accent);
      color: var(--accent-text);
      transition: background var(--dur-fast) var(--ease), border-color var(--dur-fast) var(--ease), opacity var(--dur-fast) var(--ease);
      user-select: none;
    }
    .btn:hover { background: #0b4784; }
    html.dark-mode .btn:hover { background: #63a9ef; }
    .btn:active { transform: translateY(1px); }

    .btn-secondary {
      background: transparent;
      color: var(--nav-text);
      border-color: rgba(255, 255, 255, .16);
    }
    .btn-secondary:hover { background: rgba(255, 255, 255, .07); color: #fff; border-color: rgba(255, 255, 255, .28); }

    .btn.is-loading { cursor: progress; opacity: .7; pointer-events: none; }
    .btn.is-loading .btn-label, .btn.is-loading svg:not(.btn-spinner) { visibility: hidden; }
    .btn-spinner { position: absolute; width: 15px; height: 15px; display: none; }
    .btn.is-loading .btn-spinner { display: inline-block; animation: spin .7s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ---------------- Content ---------------- */
    .admin-content { flex: 1; min-width: 0; padding: 30px 36px 56px; }

    .admin-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 18px;
      flex-wrap: wrap;
      padding-bottom: 20px;
      margin-bottom: 28px;
      border-bottom: 1px solid var(--line);
    }

    .admin-header-title { display: flex; align-items: flex-start; gap: 12px; min-width: 0; }
    .admin-header h2 {
      margin: 0;
      font-family: var(--font-display);
      font-weight: 600;
      font-size: clamp(1.35rem, 2vw, 1.7rem);
      letter-spacing: -.028em;
      line-height: 1.2;
    }
    .admin-header p { margin: .35rem 0 0; color: var(--text-muted); font-size: .92rem; max-width: 62ch; }

    .admin-header-actions { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; justify-content: flex-end; }

    .tesda-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      height: 36px;
      padding: 0 13px;
      border-radius: var(--radius-sm);
      background: var(--surface);
      border: 1px solid var(--line);
      box-shadow: inset 2px 0 0 -0px var(--gold), var(--shadow-sm);
      color: var(--text);
      font-size: .78rem;
      font-weight: 600;
      white-space: nowrap;
    }

    .pill {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      height: 36px;
      padding: 0 12px;
      border-radius: var(--radius-sm);
      background: var(--surface);
      border: 1px solid var(--line);
      box-shadow: var(--shadow-sm);
      color: var(--text-muted);
      font-family: var(--font-mono);
      font-size: .76rem;
    }
    .topbar-clock { justify-content: center; font-variant-numeric: tabular-nums; }

    .icon-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px; height: 36px;
      padding: 0;
      flex-shrink: 0;
      border-radius: var(--radius-sm);
      background: var(--surface);
      border: 1px solid var(--line);
      box-shadow: var(--shadow-sm);
      color: var(--text);
      cursor: pointer;
      transition: border-color var(--dur-fast) var(--ease), background var(--dur-fast) var(--ease);
    }
    .icon-btn:hover { border-color: var(--line-strong); background: var(--surface-sunken); }

    .topbar-bell { position: relative; text-decoration: none; }
    .topbar-bell.has-unread { color: var(--accent); border-color: var(--line-strong); }
    .topbar-badge {
      position: absolute;
      top: -6px; right: -6px;
      min-width: 17px; height: 17px;
      padding: 0 5px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 99px;
      background: var(--danger);
      color: #fff;
      font-family: var(--font-mono);
      font-size: .62rem;
      box-shadow: 0 0 0 2px var(--bg);
    }
    .topbar-badge.hidden { display: none; }

    .lang-switch {
      display: inline-flex;
      align-items: center;
      height: 36px;
      padding: 3px;
      gap: 2px;
      border-radius: var(--radius-sm);
      background: var(--surface);
      border: 1px solid var(--line);
      box-shadow: var(--shadow-sm);
    }
    .lang-form { margin: 0; display: inline-flex; }
    .lang-option {
      border: none;
      background: transparent;
      color: var(--text-muted);
      font: 600 .74rem/1 var(--font-body);
      padding: 7px 10px;
      border-radius: 6px;
      cursor: pointer;
      transition: background var(--dur-fast) var(--ease), color var(--dur-fast) var(--ease);
    }
    .lang-option:hover { color: var(--text); }
    .lang-option.active { background: var(--accent-soft); color: var(--accent); }

    #themeToggle .icon { display: inline-flex; }

    #navToggle { display: none; }
    #navToggle .line { transition: transform var(--dur) var(--ease), opacity var(--dur) var(--ease); transform-origin: center; }
    #navToggle.open .line-top { transform: translateY(6px) rotate(45deg); }
    #navToggle.open .line-mid { opacity: 0; }
    #navToggle.open .line-bot { transform: translateY(-6px) rotate(-45deg); }

    .nav-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 40;
      background: var(--overlay);
      opacity: 0;
      transition: opacity var(--dur) var(--ease);
    }
    .nav-backdrop.open { display: block; opacity: 1; }

    /* ---------------- Cards ---------------- */
    .admin-card, .admin-panel {
      background: var(--surface);
      border: 1px solid var(--line);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-sm);
      transition: border-color var(--dur-fast) var(--ease), box-shadow var(--dur-fast) var(--ease);
    }
    .admin-card { padding: 26px; box-shadow: var(--shadow); }
    .admin-panel { padding: 20px; }
    .admin-panel h3 { margin: 0 0 .6rem; font-family: var(--font-display); font-size: 1rem; font-weight: 600; letter-spacing: -.015em; }
    .admin-panel:hover, .admin-card:hover { border-color: var(--line-strong); }
    .admin-grid { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); }

    .stat-number { font-family: var(--font-mono); font-variant-numeric: tabular-nums; }

    /* ---------------- Toasts ---------------- */
    .toast-stack {
      position: fixed;
      top: 16px; right: 16px;
      z-index: 200;
      display: flex;
      flex-direction: column;
      gap: 10px;
      max-width: min(360px, calc(100vw - 32px));
    }
    .toast {
      position: relative;
      display: flex;
      align-items: flex-start;
      gap: 11px;
      padding: 13px 34px 13px 14px;
      border-radius: var(--radius);
      background: var(--surface);
      border: 1px solid var(--line);
      border-left: 3px solid var(--accent);
      box-shadow: var(--shadow-lg);
      transform: translateX(110%);
      opacity: 0;
      transition: transform .32s var(--ease), opacity .24s var(--ease);
    }
    .toast.show { transform: translateX(0); opacity: 1; }
    .toast.hide { transform: translateX(110%); opacity: 0; }
    .toast-success { border-left-color: var(--success); }
    .toast-error { border-left-color: var(--danger); }
    .toast-warning { border-left-color: var(--warning); }
    .toast-icon { flex-shrink: 0; margin-top: 2px; display: inline-flex; }
    .toast-success .toast-icon { color: var(--success); }
    .toast-error .toast-icon { color: var(--danger); }
    .toast-warning .toast-icon { color: var(--warning); }
    .toast-info .toast-icon { color: var(--accent); }
    .toast-msg { font-size: .87rem; line-height: 1.45; }
    .toast-close {
      position: absolute;
      top: 9px; right: 9px;
      width: 20px; height: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: none;
      border-radius: 5px;
      background: transparent;
      color: var(--text-muted);
      cursor: pointer;
    }
    .toast-close:hover { background: var(--surface-sunken); color: var(--text); }

    /* ---------------- Page-load sequence (one orchestrated moment) ---------------- */
    @keyframes rise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
    .admin-sidebar { animation: rise .4s var(--ease) both; }
    .admin-header { animation: rise .4s var(--ease) .06s both; }
    #adminMain { animation: rise .4s var(--ease) .12s both; }

    /* ---------------- Responsive ---------------- */
    @media (max-width: 1280px) {
      :root { --sidebar-w: 244px; }
      .admin-content { padding: 26px 26px 48px; }
    }

    @media (max-width: 1024px) {
      #navToggle, .sidebar-close { display: inline-flex; }
      .admin-sidebar {
        position: fixed;
        inset: 0 auto 0 0;
        z-index: 50;
        width: min(300px, 84vw);
        transform: translateX(-100%);
        animation: none;
        padding-top: max(24px, env(safe-area-inset-top));
        padding-bottom: max(18px, env(safe-area-inset-bottom));
      }
      .admin-sidebar.open { transform: translateX(0); box-shadow: var(--shadow-lg); }
      .admin-sidebar.dragging { transition: none; }
      .admin-content { padding: 22px 20px 44px; }
    }

    @media (max-width: 560px) {
      .admin-content { padding: 18px 15px 40px; }
      .admin-header { flex-direction: column; align-items: stretch; }
      .admin-header-actions { justify-content: flex-start; }
      .topbar-clock { display: none; }
      .admin-card { padding: 20px; }
      .admin-grid { grid-template-columns: 1fr; }
      .toast-stack { left: 12px; right: 12px; max-width: none; }
    }

    @media (max-width: 400px) {
      .tesda-badge .badge-label { display: none; }
      .tesda-badge { padding: 0 11px; }
    }

    @media (max-height: 480px) and (orientation: landscape) {
      .admin-sidebar { padding-top: 14px; padding-bottom: 10px; }
      .sidebar-brandline { margin: 10px 4px 12px; padding-bottom: 10px; }
    }

    /* Collapsed desktop rail */
    @media (min-width: 1025px) {
      html.sidebar-collapsed .admin-sidebar { width: var(--sidebar-w-collapsed); padding-left: 12px; padding-right: 12px; }
      html.sidebar-collapsed .sidebar-head { justify-content: center; }
      html.sidebar-collapsed .h1-text,
      html.sidebar-collapsed .sidebar-brandline,
      html.sidebar-collapsed .nav-group-label,
      html.sidebar-collapsed .nav-group-chevron,
      html.sidebar-collapsed .nav-sub-wrap,
      html.sidebar-collapsed .sidebar-status span:not(.status-dot),
      html.sidebar-collapsed .btn-label,
      html.sidebar-collapsed .nav-flat a span:not(.nav-item-icon) { display: none; }
      html.sidebar-collapsed .nav-group-btn,
      html.sidebar-collapsed .nav-flat a,
      html.sidebar-collapsed .btn,
      html.sidebar-collapsed .sidebar-status { justify-content: center; gap: 0; padding-left: 0; padding-right: 0; }
      html.sidebar-collapsed .nav-flat a .nav-item-icon { margin-right: 0; }
    }

    /* ---------------- Scrollbar ---------------- */
    ::-webkit-scrollbar { width: 9px; height: 9px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--line-strong); border-radius: 99px; border: 2px solid transparent; background-clip: content-box; }
    html { scrollbar-color: var(--line-strong) transparent; scrollbar-width: thin; }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: .001ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: .001ms !important;
      }
    }
  </style>
</head>
<body>
  <a href="#adminMain" class="skip-link">Skip to content</a>
  <div id="pageProgress" aria-hidden="true"></div>
  <div id="toastStack" class="toast-stack" aria-live="polite" aria-atomic="true"></div>

  <div class="admin-shell">
    <div id="navBackdrop" class="nav-backdrop" tabindex="-1"></div>

    <aside id="adminSidebar" class="admin-sidebar" aria-label="Main navigation">
      <div class="sidebar-head">
        <h1>
          <span class="mark" aria-hidden="true">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 8 L12 3 L22 8 L12 13 Z"></path>
              <path d="M6 10.5V16c0 1.4 2.7 3 6 3s6-1.6 6-3v-5.5"></path>
            </svg>
          </span>
          <span class="h1-text">SIAS</span>
        </h1>
        <div class="head-actions">
          <button id="sidebarCollapseToggle" class="sidebar-icon-btn rail-toggle" type="button" aria-label="Collapse sidebar" aria-pressed="false" title="Collapse sidebar">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <polyline points="11 17 6 12 11 7"></polyline>
              <polyline points="18 17 13 12 18 7"></polyline>
            </svg>
          </button>
          <button id="sidebarClose" class="sidebar-icon-btn sidebar-close" type="button" aria-label="Close navigation">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>

      <p class="sidebar-brandline">
        Student information system for the <b>TESDA</b> technical–vocational program.
      </p>

      <nav id="adminNav">
        <?php
          $navIcons = [
            'home'        => '<path d="M4 11 L12 4 L20 11"></path><path d="M6 10 V20 H10 V15 H14 V20 H18 V10"></path>',
            'users'       => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
            'book'        => '<rect x="4" y="4" width="16" height="16" rx="1.5"></rect><line x1="12" y1="4" x2="12" y2="20"></line>',
            'chalkboard'  => '<rect x="3" y="4" width="18" height="12" rx="1.5"></rect><path d="M8 20h8"></path><path d="M12 16v4"></path>',
            'clipboard'   => '<rect x="6" y="4" width="12" height="17" rx="2"></rect><path d="M9 4V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1"></path><path d="M9 11h6"></path><path d="M9 15h6"></path>',
            'bookmark'    => '<path d="M6 3h12v18l-6-4-6 4Z"></path>',
            'layers'      => '<path d="M12 3 L3 8 L12 13 L21 8 Z"></path><path d="M3 13 L12 18 L21 13"></path>',
            'calendar'    => '<rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4"></path><path d="M8 2v4"></path><path d="M3 10h18"></path>',
            'chart'       => '<path d="M4 20V10"></path><path d="M11 20V4"></path><path d="M18 20v-7"></path><path d="M2 20h20"></path>',
            'megaphone'   => '<path d="M3 10 L15 5 L15 19 L3 14 Z"></path><path d="M9 15 L10.5 20 L7.5 20 Z"></path>',
            'file'        => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path><path d="M14 2v6h6"></path><path d="M9 13h6"></path><path d="M9 17h6"></path>',
            'settings'    => '<line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line>',
          ];

          $navGroups = [
            ['label' => null, 'items' => [
              ['route' => 'sias.admin.dashboard', 'active' => 'sias.admin.dashboard', 'label' => __('sias.dashboard'), 'icon' => 'home'],
            ]],
            ['label' => __('sias.user_management'), 'icon' => 'users', 'items' => [
              ['route' => 'sias.admin.users', 'active' => 'sias.admin.users', 'label' => __('sias.admins')],
            ]],
            ['label' => __('sias.student_management'), 'icon' => 'book', 'items' => [
              ['route' => 'sias.admin.students.create', 'active' => 'sias.admin.students.create', 'label' => __('sias.registration')],
              ['route' => 'sias.admin.students.index', 'active' => 'sias.admin.students*', 'label' => __('sias.student_records')],
              ['route' => 'sias.admin.students.profiles', 'active' => 'sias.admin.students.profiles', 'label' => __('sias.student_profiles')],
              ['route' => 'sias.admin.students.documents', 'active' => 'sias.admin.students.documents', 'label' => __('sias.documents')],
              ['route' => 'sias.admin.students.status', 'active' => 'sias.admin.students.status', 'label' => __('sias.student_status')],
            ]],
            ['label' => __('sias.teacher_management'), 'icon' => 'chalkboard', 'items' => [
              ['route' => 'sias.admin.teachers.create', 'active' => 'sias.admin.teachers.create', 'label' => __('sias.teacher_registration')],
              ['route' => 'sias.admin.teachers', 'active' => 'sias.admin.teachers*', 'label' => __('sias.teacher_profiles')],
            ]],
            ['label' => __('sias.enrollment'), 'icon' => 'clipboard', 'items' => [
              ['route' => 'sias.admin.enrollment.add', 'active' => 'sias.admin.enrollment.add', 'label' => __('sias.new_enrollment')],
              ['route' => 'sias.admin.enrollments', 'active' => 'sias.admin.enrollments*', 'label' => __('sias.enrollment_list')],
            ]],
            ['label' => __('sias.courses'), 'icon' => 'bookmark', 'items' => [
              ['route' => 'sias.admin.course.list', 'active' => 'sias.admin.course*', 'label' => __('sias.course_list')],
              ['route' => 'sias.admin.course.add', 'active' => 'sias.admin.course.add', 'label' => __('sias.add_course')],
            ]],
            ['label' => __('sias.subjects'), 'icon' => 'layers', 'items' => [
              ['route' => 'sias.admin.subject', 'active' => 'sias.admin.subject*', 'label' => __('sias.subject_list')],
              ['route' => 'sias.admin.subject.add', 'active' => 'sias.admin.subject.add', 'label' => __('sias.add_subject')],
            ]],
            ['label' => 'Schedules', 'icon' => 'calendar', 'items' => [
              ['route' => 'admin.schedules.index', 'active' => 'admin.schedules*', 'label' => 'Schedule management'],
            ]],
            ['label' => null, 'items' => [
              ['route' => 'sias.admin.reports', 'active' => 'sias.admin.reports', 'label' => __('sias.student_reports'), 'icon' => 'chart'],
            ]],
            ['label' => null, 'items' => [
              ['route' => 'sias.admin.announcements', 'active' => 'sias.admin.announcements', 'label' => __('sias.announcements'), 'icon' => 'megaphone'],
            ]],
            ['label' => null, 'items' => [
              ['route' => 'sias.admin.audit-logs', 'active' => 'sias.admin.audit-logs', 'label' => __('sias.audit_logs'), 'icon' => 'file'],
            ]],
            ['label' => __('sias.system_settings'), 'icon' => 'settings', 'items' => [
              ['route' => 'sias.admin.settings.section', 'active' => 'sias.admin.settings.section', 'section' => 'school-information', 'params' => ['section' => 'school-information'], 'label' => __('sias.settings_school_information')],
              ['route' => 'sias.admin.settings.section', 'active' => 'sias.admin.settings.section', 'section' => 'academic-settings', 'params' => ['section' => 'academic-settings'], 'label' => __('sias.settings_academic')],
              ['route' => 'sias.admin.settings.section', 'active' => 'sias.admin.settings.section', 'section' => 'grading-settings', 'params' => ['section' => 'grading-settings'], 'label' => __('sias.settings_grading')],
              ['route' => 'sias.admin.settings.section', 'active' => 'sias.admin.settings.section', 'section' => 'language', 'params' => ['section' => 'language'], 'label' => __('sias.settings_language')],
              ['route' => 'sias.admin.backup-restore', 'active' => 'sias.admin.backup-restore', 'label' => __('sias.backup_restore')],
              ['route' => 'sias.admin.settings.section', 'active' => 'sias.admin.settings.section', 'section' => 'maintenance', 'params' => ['section' => 'maintenance'], 'label' => __('sias.settings_maintenance')],
            ]],
          ];

          $isItemActive = function ($item) {
            return request()->routeIs($item['active']) && (!isset($item['section']) || request()->route('section') === $item['section']);
          };
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $navGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($group['label']): ?>
            <?php
              $groupHasActive = false;
              foreach ($group['items'] as $gi) {
                  if ($isItemActive($gi)) { $groupHasActive = true; break; }
              }
            ?>
            <button type="button"
                    class="nav-group-btn <?php echo e($groupHasActive ? 'open' : ''); ?>"
                    data-group-btn="<?php echo e($loop->index); ?>"
                    aria-expanded="<?php echo e($groupHasActive ? 'true' : 'false'); ?>"
                    aria-controls="navGroupPanel<?php echo e($loop->index); ?>"
                    title="<?php echo e($group['label']); ?>">
              <span class="nav-group-icon" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><?php echo $navIcons[$group['icon']] ?? ''; ?></svg>
              </span>
              <span class="nav-group-label"><?php echo e($group['label']); ?></span>
              <svg class="nav-group-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="9 6 15 12 9 18"></polyline>
              </svg>
            </button>
            <div class="nav-sub-wrap <?php echo e($groupHasActive ? 'open' : ''); ?>" id="navGroupPanel<?php echo e($loop->index); ?>" data-group-panel="<?php echo e($loop->index); ?>">
              <div class="nav-sub-inner">
                <div class="nav-sub">
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e(route($item['route'], $item['params'] ?? [])); ?>" class="<?php echo e($isItemActive($item) ? 'active' : ''); ?>">
                      <span><?php echo e($item['label']); ?></span>
                    </a>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
              </div>
            </div>
          <?php else: ?>
            <div class="nav-sub nav-flat" style="padding-left: 0; margin-left: 0; border-left: 0;">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a href="<?php echo e(route($item['route'], $item['params'] ?? [])); ?>"
                   class="<?php echo e($isItemActive($item) ? 'active' : ''); ?>"
                   title="<?php echo e($item['label']); ?>">
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item['icon'])): ?>
                    <span class="nav-item-icon" aria-hidden="true">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><?php echo $navIcons[$item['icon']] ?? ''; ?></svg>
                    </span>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  <span><?php echo e($item['label']); ?></span>
                </a>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
      </nav>

      <p class="sidebar-status" aria-hidden="true">
        <span class="status-dot"></span>
        <span>System online</span>
      </p>

      <div class="sidebar-actions">
        <a href="<?php echo e(route('sias.admin.students.index')); ?>" class="btn" title="View all students">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span class="btn-label">View students</span>
        </a>
        <a href="<?php echo e(route('sias.admin.students.create')); ?>" class="btn btn-secondary" title="Register a new student">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          <span class="btn-label">Register student</span>
        </a>

        <form method="POST" action="<?php echo e(route('logout')); ?>" style="width:100%;margin:0;" data-confirm-submit="Sign out of the admin panel?">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn btn-secondary" title="Sign out">
            <svg class="btn-spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
              <path d="M12 3a9 9 0 1 0 9 9"></path>
            </svg>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span class="btn-label">Sign out</span>
          </button>
        </form>
      </div>
    </aside>

    <main id="adminContent" class="admin-content">
      <header class="admin-header">
        <div class="admin-header-title">
          <button id="navToggle" class="icon-btn" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="adminSidebar">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <line class="line line-top" x1="3" y1="6" x2="21" y2="6"></line>
              <line class="line line-mid" x1="3" y1="12" x2="21" y2="12"></line>
              <line class="line line-bot" x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>

          <div>
            <h2><?php echo $__env->yieldContent('page_title', 'SIAS Admin'); ?></h2>
            <?php if (! empty(trim($__env->yieldContent('subtitle')))): ?>
              <p><?php echo $__env->yieldContent('subtitle'); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        </div>

        <div class="admin-header-actions">
          <div><?php echo $__env->yieldContent('header_actions'); ?></div>

          <span class="tesda-badge" title="Technical Education and Skills Development Authority">
            <span class="badge-label">TESDA Tech-Voc</span>
          </span>

          <div class="pill topbar-clock" aria-live="polite">
            <span id="adminClock">--:--:--</span>
          </div>

          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('notifications.index')); ?>" id="adminBell" class="icon-btn topbar-bell" aria-label="Notifications">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M6 8a6 6 0 0 1 12 0c0 4 1.5 5.5 2 6.5H4c.5-1 2-2.5 2-6.5Z"></path>
                <path d="M10 19a2 2 0 0 0 4 0"></path>
              </svg>
              <span id="adminNotificationBadge" class="topbar-badge hidden" aria-live="polite">0</span>
            </a>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

          <div class="lang-switch" role="group" aria-label="Language">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['en' => 'EN', 'tl' => 'TL']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
              <form method="GET" action="<?php echo e(route('language.switch', $code)); ?>" class="lang-form">
                <button type="submit"
                        class="lang-option <?php echo e(app()->getLocale() === $code ? 'active' : ''); ?>"
                        aria-pressed="<?php echo e(app()->getLocale() === $code ? 'true' : 'false'); ?>"><?php echo e($label); ?></button>
              </form>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
          </div>

          <button id="themeToggle" class="icon-btn" type="button" aria-label="Switch theme" aria-pressed="false">
            <span class="icon" aria-hidden="true"></span>
          </button>
        </div>
      </header>

      <div id="adminMain"><?php echo $__env->yieldContent('content'); ?></div>
    </main>
  </div>

  <script>
    window.__siasFlash = {
      success: <?php echo json_encode(session('success'), 15, 512) ?>,
      error:   <?php echo json_encode(session('error'), 15, 512) ?>,
      warning: <?php echo json_encode(session('warning'), 15, 512) ?>,
      info:    <?php echo json_encode(session('info'), 15, 512) ?>,
    };
  </script>

  <script>
    (function () {
      var reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;

      /* ---------- Navigation progress ---------- */
      var progress = document.getElementById('pageProgress');
      var startProgress = function () {
        if (!progress) return;
        progress.classList.remove('done', 'running');
        void progress.offsetWidth;
        progress.classList.add('running');
      };
      window.addEventListener('pageshow', function () {
        if (!progress) return;
        progress.classList.remove('running');
        progress.classList.add('done');
        setTimeout(function () { progress.classList.remove('done'); }, 280);
      });

      document.querySelectorAll('a[href]:not([href^="#"])').forEach(function (link) {
        link.addEventListener('click', function (e) {
          if (e.button === 0 && !e.metaKey && !e.ctrlKey && !e.shiftKey && !e.altKey && link.target !== '_blank') startProgress();
        });
      });

      document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
          if (form.hasAttribute('data-confirm-submit')) {
            var msg = form.getAttribute('data-confirm-submit') || 'Are you sure?';
            if (!confirm(msg)) { e.preventDefault(); return; }
          }
          startProgress();
          var btn = form.querySelector('button[type="submit"]');
          if (btn && !btn.classList.contains('is-loading')) {
            btn.classList.add('is-loading');
            setTimeout(function () { btn.classList.remove('is-loading'); }, 8000);
          }
        });
      });

      /* ---------- Theme ---------- */
      var SUN = '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"><circle cx="12" cy="12" r="4.2"></circle><path d="M12 2v2M12 20v2M2 12h2M20 12h2M4.9 4.9l1.5 1.5M17.6 17.6l1.5 1.5M19.1 4.9l-1.5 1.5M6.4 17.6l-1.5 1.5"></path></svg>';
      var MOON = '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.5A8.5 8.5 0 0 1 9.5 4a8.5 8.5 0 1 0 10.5 10.5Z"></path></svg>';

      var themeBtn = document.getElementById('themeToggle');
      if (themeBtn) {
        var iconEl = themeBtn.querySelector('.icon');
        var reflect = function (dark) {
          iconEl.innerHTML = dark ? SUN : MOON;
          themeBtn.setAttribute('aria-pressed', String(dark));
          themeBtn.setAttribute('aria-label', dark ? 'Switch to light theme' : 'Switch to dark theme');
        };
        reflect(document.documentElement.classList.contains('dark-mode'));

        var applyTheme = function (dark) {
          document.documentElement.classList.toggle('dark-mode', dark);
          try { localStorage.setItem('sias-theme', dark ? 'dark' : 'light'); } catch (e) {}
          reflect(dark);
          var m = document.getElementById('themeColorMeta');
          if (m) m.setAttribute('content', dark ? '#070d17' : '#eef1f6');
          var s = document.getElementById('colorSchemeMeta');
          if (s) s.setAttribute('content', dark ? 'dark' : 'light');
        };

        themeBtn.addEventListener('click', function () {
          var dark = !document.documentElement.classList.contains('dark-mode');
          if (!reduced && document.startViewTransition) {
            document.startViewTransition(function () { applyTheme(dark); });
          } else {
            applyTheme(dark);
          }
        });
      }

      /* ---------- Sidebar drawer ---------- */
      var navToggle = document.getElementById('navToggle');
      var closeBtn = document.getElementById('sidebarClose');
      var sidebar = document.getElementById('adminSidebar');
      var backdrop = document.getElementById('navBackdrop');
      var DRAWER = '(max-width: 1024px)';

      if (navToggle && sidebar && backdrop) {
        var lastFocused = null;

        var focusableIn = function (root) {
          return Array.prototype.slice.call(
            root.querySelectorAll('a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])')
          ).filter(function (el) { return el.offsetParent !== null; });
        };

        var trapFocus = function (e) {
          if (e.key !== 'Tab' || !sidebar.classList.contains('open')) return;
          var items = focusableIn(sidebar);
          if (!items.length) return;
          var first = items[0], last = items[items.length - 1];
          if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
          else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
        };

        var setOpen = function (open) {
          if (!matchMedia(DRAWER).matches) return;
          sidebar.classList.toggle('open', open);
          backdrop.classList.toggle('open', open);
          navToggle.classList.toggle('open', open);
          navToggle.setAttribute('aria-expanded', String(open));
          document.body.style.overflow = open ? 'hidden' : '';
          if (open) {
            lastFocused = document.activeElement;
            var items = focusableIn(sidebar);
            if (items.length) items[0].focus();
            document.addEventListener('keydown', trapFocus);
          } else {
            document.removeEventListener('keydown', trapFocus);
            if (lastFocused && lastFocused.focus) lastFocused.focus();
          }
        };

        navToggle.addEventListener('click', function () { setOpen(!sidebar.classList.contains('open')); });
        if (closeBtn) closeBtn.addEventListener('click', function () { setOpen(false); });
        backdrop.addEventListener('click', function () { setOpen(false); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
        sidebar.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', function () { setOpen(false); }); });

        var mq = window.matchMedia(DRAWER);
        var onMq = function (e) { if (!e.matches) setOpen(false); };
        if (mq.addEventListener) mq.addEventListener('change', onMq);
        else if (mq.addListener) mq.addListener(onMq);

        /* Edge-swipe to open, swipe left to close. */
        var startX = null, startY = null, mode = null, width = 0;
        var EDGE = 24, THRESHOLD = 60;

        document.addEventListener('touchstart', function (e) {
          if (!matchMedia(DRAWER).matches) return;
          var t = e.touches[0];
          var isOpen = sidebar.classList.contains('open');
          if (!isOpen && t.clientX > EDGE) return;
          startX = t.clientX; startY = t.clientY;
          mode = isOpen ? 'close' : 'open';
          width = sidebar.offsetWidth;
          if (isOpen) sidebar.classList.add('dragging');
        }, { passive: true });

        document.addEventListener('touchmove', function (e) {
          if (startX === null || !matchMedia(DRAWER).matches) return;
          var t = e.touches[0];
          var dx = t.clientX - startX, dy = t.clientY - startY;
          if (Math.abs(dy) > Math.abs(dx)) return;
          if (mode === 'open' && !sidebar.classList.contains('open')) {
            if (dx <= 4) return;
            sidebar.classList.add('dragging', 'open');
            backdrop.classList.add('open');
          }
          var translate = mode === 'open'
            ? Math.min(0, Math.max(-width, dx - width))
            : Math.min(0, Math.max(-width, dx));
          sidebar.style.transform = 'translateX(' + translate + 'px)';
        }, { passive: true });

        document.addEventListener('touchend', function (e) {
          if (startX === null) return;
          sidebar.classList.remove('dragging');
          sidebar.style.transform = '';
          var endX = (e.changedTouches && e.changedTouches[0]) ? e.changedTouches[0].clientX : startX;
          var dx = endX - startX;
          setOpen(mode === 'open' ? dx > THRESHOLD : dx > -THRESHOLD);
          startX = null; startY = null; mode = null;
        }, { passive: true });
      }

      /* ---------- Clock ---------- */
      var clockEl = document.getElementById('adminClock');
      if (clockEl) {
        var tick = function () {
          clockEl.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
        };
        tick();
        setInterval(tick, 1000);
      }

      /* ---------- Unread notifications ---------- */
      var badge = document.getElementById('adminNotificationBadge');
      var bell = document.getElementById('adminBell');
      if (badge && bell) {
        var notifUrl = <?php echo json_encode(route('chats.notifications'), 15, 512) ?>;
        var refresh = function () {
          var controller = ('AbortController' in window) ? new AbortController() : null;
          var timeout = controller ? setTimeout(function () { controller.abort(); }, 6000) : null;
          fetch(notifUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, signal: controller ? controller.signal : undefined })
            .then(function (r) { if (!r.ok) throw new Error('network'); return r.json(); })
            .then(function (data) {
              var count = Number(data && data.unread ? data.unread : 0);
              badge.textContent = count > 99 ? '99+' : String(count);
              badge.classList.toggle('hidden', count === 0);
              bell.classList.toggle('has-unread', count > 0);
              bell.setAttribute('aria-label', count > 0 ? count + ' unread notifications' : 'Notifications');
            })
            .catch(function () {
              badge.classList.add('hidden');
              bell.classList.remove('has-unread');
            })
            .finally(function () { if (timeout) clearTimeout(timeout); });
        };
        refresh();
        setInterval(function () { if (document.visibilityState === 'visible') refresh(); }, 15000);
        document.addEventListener('visibilitychange', function () { if (document.visibilityState === 'visible') refresh(); });
      }

      /* ---------- Counters ---------- */
      var counters = document.querySelectorAll('[data-count-to]');
      if (counters.length) {
        var animate = function (el) {
          var target = parseFloat(el.getAttribute('data-count-to')) || 0;
          var isInt = Number.isInteger(target);
          if (reduced) { el.textContent = isInt ? target.toLocaleString() : target.toFixed(1); return; }
          var start = performance.now();
          var step = function (now) {
            var t = Math.min(1, (now - start) / 850);
            var val = target * (1 - Math.pow(1 - t, 3));
            el.textContent = isInt ? Math.round(val).toLocaleString() : val.toFixed(1);
            if (t < 1) requestAnimationFrame(step);
          };
          requestAnimationFrame(step);
        };
        if ('IntersectionObserver' in window) {
          var cio = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (en) { if (en.isIntersecting) { animate(en.target); obs.unobserve(en.target); } });
          }, { threshold: 0.4 });
          counters.forEach(function (el) { cio.observe(el); });
        } else {
          counters.forEach(animate);
        }
      }

      /* ---------- Toasts ---------- */
      var stack = document.getElementById('toastStack');
      if (stack) {
        var ICONS = {
          success: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M8.5 12.3 11 15l4.5-5"></path></svg>',
          error:   '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="9"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>',
          warning: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>',
          info:    '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>'
        };

        window.showToast = function (message, type) {
          if (!message) return;
          type = ICONS[type] ? type : 'info';
          var toast = document.createElement('div');
          toast.className = 'toast toast-' + type;
          toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
          toast.innerHTML =
            '<span class="toast-icon">' + ICONS[type] + '</span>' +
            '<span class="toast-msg"></span>' +
            '<button class="toast-close" type="button" aria-label="Dismiss">' +
              '<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>' +
            '</button>';
          toast.querySelector('.toast-msg').textContent = message;
          stack.appendChild(toast);
          requestAnimationFrame(function () { requestAnimationFrame(function () { toast.classList.add('show'); }); });

          var dismiss = function () {
            toast.classList.remove('show');
            toast.classList.add('hide');
            toast.addEventListener('transitionend', function () { toast.remove(); }, { once: true });
          };
          toast.querySelector('.toast-close').addEventListener('click', dismiss);
          var timer = setTimeout(dismiss, 4500);
          toast.addEventListener('mouseenter', function () { clearTimeout(timer); });
          toast.addEventListener('mouseleave', function () { timer = setTimeout(dismiss, 1800); });
        };

        var flash = window.__siasFlash || {};
        ['success', 'error', 'warning', 'info'].forEach(function (t) { if (flash[t]) window.showToast(flash[t], t); });
      }
    })();
  </script>

  <script>
    /* ---------- Desktop rail collapse ---------- */
    (function () {
      var toggle = document.getElementById('sidebarCollapseToggle');
      if (!toggle) return;
      var sync = function () {
        var collapsed = document.documentElement.classList.contains('sidebar-collapsed');
        toggle.classList.toggle('flipped', collapsed);
        toggle.setAttribute('aria-pressed', String(collapsed));
        toggle.setAttribute('title', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
        toggle.setAttribute('aria-label', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
      };
      sync();
      toggle.addEventListener('click', function () {
        var collapsed = !document.documentElement.classList.contains('sidebar-collapsed');
        document.documentElement.classList.toggle('sidebar-collapsed', collapsed);
        try { localStorage.setItem('sias-sidebar-collapsed', collapsed ? '1' : '0'); } catch (e) {}
        sync();
      });
    })();
  </script>

  <script>
    /* ---------- Nav accordion with remembered state ---------- */
    (function () {
      var btns = document.querySelectorAll('.nav-group-btn');
      if (!btns.length) return;

      var KEY = 'sias-nav-open-groups';
      var saved = null;
      try { saved = JSON.parse(localStorage.getItem(KEY) || 'null'); } catch (e) { saved = null; }

      var apply = function (btn, panel, open, animate) {
        if (!animate) panel.style.transition = 'none';
        btn.classList.toggle('open', open);
        btn.setAttribute('aria-expanded', String(open));
        panel.classList.toggle('open', open);
        if (!animate) { void panel.offsetWidth; panel.style.transition = ''; }
      };

      btns.forEach(function (btn) {
        var idx = btn.getAttribute('data-group-btn');
        var panel = document.getElementById('navGroupPanel' + idx);
        if (!panel) return;

        // A saved state wins, except for the group holding the current page,
        // which the server already rendered open.
        if (saved && !btn.classList.contains('open')) {
          apply(btn, panel, saved.indexOf(idx) !== -1, false);
        }

        btn.addEventListener('click', function () {
          if (document.documentElement.classList.contains('sidebar-collapsed')) {
            document.documentElement.classList.remove('sidebar-collapsed');
            try { localStorage.setItem('sias-sidebar-collapsed', '0'); } catch (e) {}
            var rail = document.getElementById('sidebarCollapseToggle');
            if (rail) {
              rail.classList.remove('flipped');
              rail.setAttribute('aria-pressed', 'false');
              rail.setAttribute('title', 'Collapse sidebar');
            }
          }
          apply(btn, panel, !btn.classList.contains('open'), true);
          var openList = [];
          btns.forEach(function (b) { if (b.classList.contains('open')) openList.push(b.getAttribute('data-group-btn')); });
          try { localStorage.setItem(KEY, JSON.stringify(openList)); } catch (e) {}
        });
      });
    })();
  </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\layouts\master.blade.php ENDPATH**/ ?>