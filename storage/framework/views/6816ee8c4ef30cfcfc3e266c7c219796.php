<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SkillUp Admin'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel ="icon" href="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Syne:wght@600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="/css/admin.css">
    <meta name="admin-chats-notifications" content="<?php echo e(route('admin.chats.notifications')); ?>">

    <script>
        (function () {
            if (localStorage.getItem('skillup_admin_theme') === 'light') {
                document.documentElement.classList.add('light-mode');
            }
        })();
    </script>

    <style>
        /* ══════════════════════════════════════════
           TOKENS
           Palette: deep graphite base · electric-blue
           primary · violet secondary · warm gold as the
           single "achievement" signature accent (ties to
           the SkillUp / leveling-up identity).
        ══════════════════════════════════════════ */
        :root {
            --bg-base:           #070a10;
            --bg-surface:        #0b0f18;
            --bg-card:           #10141d;
            --bg-card-hover:     #161b27;
            --bg-input:          #0e1219;

            --border:            rgba(255,255,255,0.05);
            --border-mid:        rgba(255,255,255,0.09);
            --border-strong:     rgba(255,255,255,0.14);

            --accent:            #4f8cff;   /* electric blue — primary interactive */
            --accent-2:          #9b8cf7;   /* soft violet — gradient partner */
            --accent-soft:       rgba(79,140,255,0.10);
            --accent-glow:       rgba(79,140,255,0.22);
            --accent-dark:       #3a6fd6;

            --gold:              #f2b134;   /* signature accent — used sparingly */
            --gold-soft:         rgba(242,177,52,0.14);
            --gold-glow:         rgba(242,177,52,0.25);

            --cyan:              #4fe1ff;   /* tertiary HUD accent — data/telemetry only */

            --danger:            #f2617c;
            --success:           #2fd6a7;
            --warning:           #f2b134;

            --text-primary:      #f6f8fc;
            --text-secondary:    #dbe4f2;
            --text-muted:        #93a3bd;
            --text-subtle:       #62748f;

            --sidebar-w:         272px;
            --sidebar-collapsed: 64px;
            --topbar-h:          64px;
            --radius:            14px;
            --radius-sm:         9px;
            --radius-xs:         6px;

            --sidebar-bg:        #090c14;
            --sidebar-border:    rgba(255,255,255,0.05);

            --sb-track:          #090c14;
            --sb-thumb:          rgba(79,140,255,0.16);
            --sb-thumb-hover:    rgba(79,140,255,0.32);
            --sb-w:              4px;

            --shadow-glow:       0 0 32px rgba(79,140,255,0.14);
            --shadow-drop:       0 22px 60px rgba(0,0,0,0.55);
            --shadow-elev-1:     0 1px 0 rgba(255,255,255,0.03) inset, 0 8px 24px rgba(0,0,0,.35);
            --shadow-elev-2:     0 1px 0 rgba(255,255,255,0.04) inset, 0 16px 44px rgba(0,0,0,.45);

            /* Sidebar transition speed */
            --sb-transition:     0.32s cubic-bezier(.4,0,.2,1);
            --ease-spring:       cubic-bezier(.34,1.56,.64,1);
            --ease-out:          cubic-bezier(.16,1,.3,1);
        }

        html.light-mode {
            --bg-base:           #eef3f8;
            --bg-surface:        #f8fafc;
            --bg-card:           #ffffff;
            --bg-card-hover:     #f1f5f9;
            --bg-input:          #ffffff;

            --border:            rgba(15,23,42,0.08);
            --border-mid:        rgba(15,23,42,0.14);
            --border-strong:     rgba(15,23,42,0.2);

            --accent:            #2563eb;
            --accent-2:          #6d5ce7;
            --accent-soft:       rgba(37,99,235,0.10);
            --accent-glow:       rgba(37,99,235,0.18);
            --accent-dark:       #1d4ed8;

            --gold:              #b7791f;
            --gold-soft:         rgba(183,121,31,0.12);
            --gold-glow:         rgba(183,121,31,0.2);

            --text-primary:      #172033;
            --text-secondary:    #334155;
            --text-muted:        #64748b;
            --text-subtle:       #94a3b8;

            --sidebar-bg:        #ffffff;
            --sidebar-border:    rgba(15,23,42,0.1);
            --sb-track:          #f1f5f9;
            --sb-thumb:          rgba(37,99,235,0.2);
            --sb-thumb-hover:    rgba(37,99,235,0.36);

            --shadow-glow:       0 0 32px rgba(37,99,235,0.12);
            --shadow-drop:       0 22px 60px rgba(15,23,42,0.16);
            --shadow-elev-1:     0 1px 0 rgba(255,255,255,0.8) inset, 0 8px 24px rgba(15,23,42,.08);
            --shadow-elev-2:     0 1px 0 rgba(255,255,255,0.9) inset, 0 16px 44px rgba(15,23,42,.12);
        }

        html.light-mode body::before { opacity: .18; }
        html.light-mode body::after { background: radial-gradient(circle, rgba(37,99,235,0.08) 0%, rgba(183,121,31,0.04) 45%, transparent 72%); }
        html.light-mode .hud-grid { background-image: linear-gradient(rgba(37,99,235,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(37,99,235,0.05) 1px, transparent 1px); }
        html.light-mode .topbar { background: rgba(248,250,252,0.9); box-shadow: 0 4px 32px rgba(15,23,42,0.1); }
        html.light-mode .nav-section { background: rgba(15,23,42,.025); border-color: rgba(15,23,42,.07); box-shadow: inset 0 1px 0 rgba(255,255,255,.8); }
        html.light-mode .nav-link:hover, html.light-mode .sidebar-footer a:hover { background: rgba(37,99,235,.07); }
        html.light-mode .nav-link::before { background: linear-gradient(90deg, transparent 0%, rgba(37,99,235,.08) 50%, transparent 100%); }
        html.light-mode .sidebar-fade-mask { background: linear-gradient(to top, var(--sidebar-bg) 40%, transparent); }
        html.light-mode #fx-canvas { opacity: .28; }
        html.light-mode .topbar-btn, html.light-mode .user-chip { box-shadow: 0 2px 8px rgba(15,23,42,.05); }

        .theme-toggle i { transition: transform .35s var(--ease-spring); }
        .theme-toggle:hover i { transform: rotate(18deg) scale(1.08); }

        /* ══════════════════════════════════════════
           BASE
        ══════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        html, body {
            background: var(--bg-base);
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            min-height: 100vh;
        }

        /* Subtle noise grain */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0; opacity: .5;
        }

        /* Ambient corner glow — quiet, not a spotlight */
        body::after {
            content: '';
            position: fixed; top: -10%; right: -8%;
            width: 46vw; height: 46vw; max-width: 620px; max-height: 620px;
            background: radial-gradient(circle, rgba(79,140,255,0.07) 0%, rgba(242,177,52,0.03) 45%, transparent 72%);
            pointer-events: none; z-index: 0; filter: blur(10px);
        }

        /* Faint HUD grid — reinforces the "console" identity without competing for attention */
        .hud-grid {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(79,140,255,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79,140,255,0.035) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: radial-gradient(ellipse 80% 60% at 70% 0%, black 0%, transparent 72%);
            -webkit-mask-image: radial-gradient(ellipse 80% 60% at 70% 0%, black 0%, transparent 72%);
            opacity: .55;
        }

        /* Global thin scrollbar */
        ::-webkit-scrollbar          { width: 3px; height: 3px; }
        ::-webkit-scrollbar-track    { background: transparent; }
        ::-webkit-scrollbar-thumb    { background: var(--text-subtle); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        /* Keyboard accessibility */
        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
            border-radius: 4px;
        }

        /* ══════════════════════════════════════════
           AMBIENT FX LAYER — particle network, cursor
           spotlight, HUD scanline, boot progress bar.
           One coherent "living console" signature that
           ties the whole chrome together.
        ══════════════════════════════════════════ */
        #fx-canvas {
            position: fixed; inset: 0;
            z-index: 0; pointer-events: none;
            opacity: .6;
        }
        .hud-spotlight {
            position: fixed; inset: 0;
            z-index: 0; pointer-events: none;
            background: radial-gradient(420px circle at var(--sx, 50%) var(--sy, 30%), rgba(79,140,255,0.07), transparent 70%);
        }
        #hud-scanline {
            position: fixed; inset: 0;
            z-index: 0; pointer-events: none;
            overflow: hidden;
        }
        #hud-scanline::before {
            content: '';
            position: absolute; left: 0; right: 0; top: -140px; height: 140px;
            background: linear-gradient(to bottom, transparent, rgba(79,140,255,0.05), transparent);
            animation: scanline-sweep 9s linear infinite;
        }
        @keyframes scanline-sweep {
            0%   { top: -140px; }
            100% { top: 100%; }
        }
        #route-progress {
            position: fixed; top: 0; left: 0; height: 2px; width: 0%;
            background: linear-gradient(90deg, var(--accent), var(--gold), var(--accent-2));
            box-shadow: 0 0 10px rgba(79,140,255,.6);
            z-index: 999;
            transition: width .4s cubic-bezier(.4,0,.2,1), opacity .3s ease .15s;
        }
        #route-progress.done { opacity: 0; }

        /* Toast stack — lightweight, reusable via window.SkillUp.toast() */
        #toast-stack {
            position: fixed; bottom: 22px; right: 22px;
            display: flex; flex-direction: column-reverse; gap: 10px;
            z-index: 1000; pointer-events: none;
        }
        .toast {
            display: flex; align-items: center; gap: 10px;
            min-width: 240px; max-width: 340px;
            padding: 12px 14px; border-radius: var(--radius-sm);
            background: var(--bg-card); border: 1px solid var(--border-strong);
            box-shadow: var(--shadow-drop);
            font-size: 12.5px; font-weight: 500; color: var(--text-secondary);
            pointer-events: auto;
            animation: toast-in .35s var(--ease-spring) both;
        }
        .toast.leaving { animation: toast-out .28s var(--ease-out) both; }
        .toast i { font-size: 13px; flex-shrink: 0; }
        .toast.success i { color: var(--success); }
        .toast.error   i { color: var(--danger); }
        .toast.info    i { color: var(--accent); }
        @keyframes toast-in  { from{opacity:0;transform:translateX(24px) scale(.95)} to{opacity:1;transform:translateX(0) scale(1)} }
        @keyframes toast-out { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(24px)} }

        /* Ripple utility — applied to interactive chrome elements via JS */
        .ripple-host { position: relative; overflow: hidden; }
        .ripple {
            position: absolute; border-radius: 50%;
            background: radial-gradient(circle, rgba(79,140,255,.45) 0%, rgba(79,140,255,0) 70%);
            transform: scale(0); pointer-events: none;
            animation: ripple-out .6s ease-out forwards;
        }
        @keyframes ripple-out { to { transform: scale(2.6); opacity: 0; } }

        /* ══════════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════════ */
        .topbar {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--topbar-h);
            background: rgba(7,10,16,0.88);
            backdrop-filter: blur(28px) saturate(160%);
            -webkit-backdrop-filter: blur(28px) saturate(160%);
            border-bottom: 1px solid var(--border-mid);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 26px;
            z-index: 300;
            box-shadow: 0 4px 32px rgba(0,0,0,0.4);
        }
        .topbar::after {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent 0%, var(--accent) 28%, var(--gold) 52%, var(--accent-2) 76%, transparent 100%);
            animation: shimmer-line 6s ease-in-out infinite;
            background-size: 200% 100%;
        }
        @keyframes shimmer-line { 0%,100%{opacity:.35; background-position: 0% 0;} 50%{opacity:.9; background-position: 100% 0;} }

        /* Brand */
        .topbar-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; flex-shrink: 0;
        }
        .brand-logo-wrap {
            position: relative; width: 40px; height: 40px; flex-shrink: 0;
        }
        .brand-logo-wrap img {
            width: 100%; height: 100%; object-fit: contain;
            position: relative; z-index: 2;
            filter: drop-shadow(0 0 8px rgba(79,140,255,0.45));
            transition: filter .3s ease, transform .35s var(--ease-spring);
        }
        .topbar-brand:hover .brand-logo-wrap img {
            filter: drop-shadow(0 0 18px rgba(242,177,52,0.75));
            transform: scale(1.1) rotate(-4deg);
        }
        .brand-logo-wrap::before {
            content: ''; position: absolute; inset: -6px; border-radius: 14px;
            background: radial-gradient(circle, var(--accent-glow) 0%, var(--gold-glow) 55%, transparent 75%);
            animation: logo-halo 3.2s ease-in-out infinite; z-index: 0;
        }
        @keyframes logo-halo { 0%,100%{opacity:.4;transform:scale(1)} 50%{opacity:.85;transform:scale(1.16)} }
        /* Orbiting telemetry dot — signature gamified "in orbit / leveling" motif */
        .brand-logo-wrap::after {
            content: ''; position: absolute; inset: -9px;
            border-radius: 50%; border: 1px dashed rgba(79,140,255,.22);
            animation: orbit-spin 7s linear infinite; z-index: 1;
        }
        @keyframes orbit-spin { to { transform: rotate(360deg); } }

        .brand-text { display: flex; flex-direction: column; }
        .brand-name {
            font-family: 'Syne', sans-serif;
            font-size: 17px; font-weight: 800;
            letter-spacing: -0.5px; line-height: 1.1;
            background: linear-gradient(100deg, var(--text-primary) 20%, var(--accent) 55%, var(--gold) 80%, var(--text-primary) 105%);
            background-size: 220% 100%;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            animation: brand-shift 7s ease-in-out infinite;
        }
        @keyframes brand-shift { 0%,100%{background-position:0% 50%} 50%{background-position:100% 50%} }
        .brand-sub {
            font-size: 9px; font-weight: 600; color: var(--text-muted);
            letter-spacing: .9px; text-transform: uppercase;
            display: flex; align-items: center; gap: 5px;
        }
        .brand-sub::before {
            content: ''; width: 4px; height: 4px; border-radius: 50%;
            background: var(--success); box-shadow: 0 0 6px var(--success);
            animation: pulse-dot 2.4s ease infinite;
        }

        /* Breadcrumb */
        .topbar-center { flex: 1; display: flex; align-items: center; justify-content: center; }
        .topbar-breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; font-weight: 500; color: var(--text-muted);
            padding: 6px 14px; border-radius: 99px;
            background: var(--bg-input); border: 1px solid var(--border);
        }
        .topbar-breadcrumb .bc-page { color: var(--text-secondary); font-weight: 600; }
        .topbar-breadcrumb i { font-size: 9px; }
        .topbar-breadcrumb i.fa-house { color: var(--accent); }

        /* Actions */
        .topbar-actions { display: flex; align-items: center; gap: 6px; }

        /* HUD live clock */
        .topbar-clock {
            display: flex; align-items: center; gap: 8px;
            padding: 7px 12px; border-radius: var(--radius-sm);
            background: var(--bg-input); border: 1px solid var(--border-mid);
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 12px; font-weight: 500; color: var(--text-secondary);
            letter-spacing: .5px; flex-shrink: 0;
        }
        .topbar-clock i { color: var(--accent); font-size: 11px; animation: clock-blip 2.4s ease infinite; }
        @keyframes clock-blip { 0%,100%{opacity:.5} 50%{opacity:1} }
        /* Signal-strength bars — reinforces "live console" telemetry feel */
        .signal-bars { display: flex; align-items: flex-end; gap: 2px; height: 11px; margin-left: 1px; }
        .signal-bars span {
            width: 3px; background: var(--accent); border-radius: 1px; opacity: .35;
            animation: signal-bounce 2.6s ease-in-out infinite;
        }
        .signal-bars span:nth-child(1) { height: 4px; animation-delay: 0s; }
        .signal-bars span:nth-child(2) { height: 7px; animation-delay: .2s; }
        .signal-bars span:nth-child(3) { height: 11px; animation-delay: .4s; }
        @keyframes signal-bounce { 0%,100%{opacity:.35} 50%{opacity:1} }

        .search-wrap { position: relative; display: flex; align-items: center; }
        .search-wrap input {
            background: var(--bg-input); border: 1px solid var(--border-mid);
            color: var(--text-primary); padding: 8px 54px 8px 14px;
            border-radius: var(--radius-sm); font-family: 'Outfit', sans-serif;
            font-size: 13px; width: 200px; outline: none;
            transition: border-color .25s, box-shadow .25s, width .35s cubic-bezier(.4,0,.2,1);
        }
        .search-wrap input::placeholder { color: var(--text-muted); }
        .search-wrap input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft), var(--shadow-glow);
            width: 265px;
        }
        .search-wrap input:focus + .search-kbd { opacity: 0; }
        .search-wrap i.fa-magnifying-glass { position: absolute; right: 12px; color: var(--text-muted); font-size: 11.5px; pointer-events: none; transition: opacity .2s; }
        .search-wrap input:not(:placeholder-shown) ~ i.fa-magnifying-glass,
        .search-wrap input:focus ~ i.fa-magnifying-glass { opacity: 0; }
        .search-kbd {
            position: absolute; right: 10px; display: flex; gap: 3px;
            font-family: 'JetBrains Mono', monospace; font-size: 9.5px; font-weight: 600;
            color: var(--text-subtle); pointer-events: none; transition: opacity .2s;
        }
        .search-kbd kbd {
            background: var(--bg-card); border: 1px solid var(--border-strong);
            border-radius: 4px; padding: 1.5px 5px;
        }

        .topbar-btn {
            width: 37px; height: 37px; border-radius: var(--radius-sm);
            background: var(--bg-input); border: 1px solid var(--border-mid);
            color: var(--text-muted); display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative; text-decoration: none; font-size: 13px;
            transition: color .2s, background .2s, border-color .2s, transform .15s, box-shadow .2s;
        }
        .topbar-btn:hover {
            color: var(--accent); background: var(--bg-card-hover);
            border-color: rgba(79,140,255,.28); transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(79,140,255,.12);
        }
        .topbar-btn:active { transform: translateY(0) scale(.94); }
        .topbar-btn .badge {
            position: absolute; top: -5px; right: -5px;
            min-width: 17px; height: 17px; background: var(--danger); border-radius: 99px;
            font-size: 9px; font-weight: 700; color: #fff;
            display: flex; align-items: center; justify-content: center;
            padding: 0 4px; border: 2px solid var(--bg-base);
            animation: badge-pop .35s var(--ease-spring) both;
        }
        @keyframes badge-pop { from{transform:scale(0)} to{transform:scale(1)} }

        /* Periodic notification bell ring */
        .topbar-btn.bell-ring i { animation: bell-shake 4.5s ease infinite; }
        @keyframes bell-shake {
            0%, 92%, 100% { transform: rotate(0deg); }
            93% { transform: rotate(-14deg); }
            94% { transform: rotate(11deg); }
            95% { transform: rotate(-8deg); }
            96% { transform: rotate(5deg); }
            97% { transform: rotate(0deg); }
        }

        .user-chip {
            display: flex; align-items: center; gap: 10px;
            padding: 5px 12px 5px 5px; border-radius: var(--radius);
            background: var(--bg-input); border: 1px solid var(--border-mid);
            cursor: pointer; transition: background .2s, border-color .2s, box-shadow .2s;
        }
        .user-chip:hover { background: var(--bg-card-hover); border-color: rgba(79,140,255,.32); box-shadow: 0 4px 20px rgba(79,140,255,.09); }
        .user-avatar-wrap { position: relative; width: 33px; height: 33px; flex-shrink: 0; }
        .user-avatar {
            width: 29px; height: 29px; border-radius: 8px;
            position: absolute; top: 2px; left: 2px;
            background: linear-gradient(135deg, var(--accent-dark), var(--accent-2));
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; color: #fff; z-index: 1;
        }
        /* XP / level ring — small nod to the platform's "leveling up" identity,
           without over-explaining it in copy */
        .user-avatar-ring {
            position: absolute; inset: 0; z-index: 0;
            transform: rotate(-90deg);
        }
        .user-avatar-ring circle {
            fill: none; stroke-width: 2;
        }
        .user-avatar-ring .track { stroke: rgba(255,255,255,.08); }
        .user-avatar-ring .fill  {
            stroke: var(--gold);
            stroke-linecap: round;
            stroke-dasharray: 92;
            stroke-dashoffset: 22;
            filter: drop-shadow(0 0 3px rgba(242,177,52,.7));
        }
        .user-name { font-size: 13px; font-weight: 600; color: var(--text-primary); line-height: 1.2; }
        .user-role { font-size: 10px; color: var(--text-muted); line-height: 1; display: flex; align-items: center; gap: 4px; }
        .user-role i { font-size: 8px; color: var(--gold); }
        .user-chevron {
            font-size: 9px; color: var(--text-muted); margin-left: 2px;
            transition: transform .25s var(--ease-spring);
        }
        .user-chevron.rotated { transform: rotate(180deg); }

        /* Dropdown */
        .dropdown {
            position: absolute; top: calc(100% + 10px); right: 0;
            min-width: 226px; background: var(--bg-card);
            border: 1px solid var(--border-strong); border-radius: var(--radius);
            padding: 6px; z-index: 400;
            box-shadow: var(--shadow-drop), 0 0 0 1px rgba(79,140,255,.05);
            animation: drop-in .18s var(--ease-out) both;
            transform-origin: top right;
        }
        .dropdown::before {
            content: '';
            position: absolute; top: 0; left: 12px; right: 12px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), var(--gold), transparent);
            opacity: .5;
        }
        @keyframes drop-in { from{opacity:0;transform:scale(.93) translateY(-8px)} to{opacity:1;transform:scale(1) translateY(0)} }
        .dropdown-header { padding: 10px 12px 9px; border-bottom: 1px solid var(--border); margin-bottom: 4px; }
        .dropdown-header .dh-name  { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .dropdown-header .dh-email { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
        .dropdown a, .dropdown button {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px; border-radius: var(--radius-xs);
            font-size: 13px; font-family: 'Outfit', sans-serif;
            color: var(--text-secondary); text-decoration: none; background: none; border: none;
            width: 100%; cursor: pointer;
            transition: background .15s, color .15s, padding-left .18s;
            animation: item-in .3s var(--ease-out) both;
        }
        .dropdown a:nth-of-type(1) { animation-delay: .02s; }
        .dropdown a:nth-of-type(2) { animation-delay: .05s; }
        .dropdown a:nth-of-type(3) { animation-delay: .08s; }
        @keyframes item-in { from{opacity:0;transform:translateX(6px)} to{opacity:1;transform:translateX(0)} }
        .dropdown a:hover { background: var(--bg-card-hover); color: var(--text-primary); padding-left: 14px; }
        .dropdown a i, .dropdown button i { color: var(--accent); width: 14px; font-size: 12px; flex-shrink: 0; }
        .dropdown .logout-btn { color: var(--danger); }
        .dropdown .logout-btn i { color: var(--danger); }
        .dropdown .logout-btn:hover { background: rgba(242,97,124,.09); padding-left: 14px; }
        .dropdown-divider { height: 1px; background: var(--border); margin: 4px 2px; }

        /* ══════════════════════════════════════════
           SIDEBAR WRAPPER (outer shell — fixed)
        ══════════════════════════════════════════ */
        .sidebar {
            position: fixed;
            left: 0; top: var(--topbar-h); bottom: 0;
            width: var(--sidebar-w);
            z-index: 200;
            transition: width var(--sb-transition);
            overflow: hidden;
        }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }

        /* ── Inner wrapper: fills sidebar, flex column ── */
        .sidebar-wrapper {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            box-shadow: 2px 0 40px rgba(79,140,255,0.045);
            width: var(--sidebar-w);
            transition: width var(--sb-transition);
        }
        .sidebar.collapsed .sidebar-wrapper { width: var(--sidebar-collapsed); }

        /* ── Toggle button ── */
        .sidebar-toggle-btn {
            position: absolute;
            top: 18px;
            right: -14px;
            width: 28px; height: 28px;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg-card);
            border: 1px solid var(--border-strong);
            border-radius: 50%;
            color: var(--text-secondary);
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 4px 16px rgba(0,0,0,.4);
            transition: background .2s, border-color .2s, color .2s, transform .35s var(--ease-spring);
        }
        .sidebar-toggle-btn::before {
            content: ''; position: absolute; inset: -4px; border-radius: 50%;
            border: 1px solid rgba(79,140,255,0);
            transition: border-color .3s ease, transform .4s ease;
        }
        .sidebar-toggle-btn:hover::before { border-color: rgba(79,140,255,.35); transform: scale(1.14) rotate(90deg); }
        .sidebar-toggle-btn:hover {
            background: rgba(79,140,255,.15);
            border-color: rgba(79,140,255,.38);
            color: var(--accent);
        }
        .sidebar-toggle-btn i {
            font-size: 11px; line-height: 1;
            transition: transform .35s var(--ease-spring);
        }
        .sidebar.collapsed .sidebar-toggle-btn i { transform: rotate(180deg); }

        /* ── Scrollable nav area ── */
        .sidebar-scroll {
            flex: 1 1 0; min-height: 0;
            overflow-y: auto; overflow-x: hidden;
            padding: 16px 0 8px;
            display: flex; flex-direction: column; gap: 5px;
            scrollbar-width: thin;
            scrollbar-color: var(--sb-thumb) var(--sb-track);
        }
        .sidebar-scroll::-webkit-scrollbar        { width: var(--sb-w); }
        .sidebar-scroll::-webkit-scrollbar-track  { background: var(--sb-track); border-radius: 99px; }
        .sidebar-scroll::-webkit-scrollbar-thumb  { background: transparent; border-radius: 99px; }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb       { background: var(--sb-thumb); }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb:hover { background: var(--sb-thumb-hover); }

        /* ── Collapse: hide text labels, badges, section labels ── */
        .sidebar.collapsed .nav-link-text,
        .sidebar.collapsed .nav-badge,
        .sidebar.collapsed .nav-section-label,
        .sidebar.collapsed .status-label,
        .sidebar.collapsed .sidebar-footer a span,
        .sidebar.collapsed .scroll-more,
        .sidebar.collapsed .logout-footer-btn span {
            opacity: 0;
            width: 0; overflow: hidden;
            transition: opacity .2s, width .2s;
            pointer-events: none;
        }

        .sidebar.collapsed .nav-section { border-radius: var(--radius-xs); }
        .sidebar.collapsed .nav-link    { padding-left: 0; justify-content: center; }
        .sidebar.collapsed .nav-link i  { margin: 0; width: auto; }
        .sidebar.collapsed .nav-group   { padding: 4px; }
        .sidebar.collapsed .sidebar-status { justify-content: center; padding: 8px 6px; }
        .sidebar.collapsed .nav-section-label { padding: 6px; border: none; }
        .sidebar.collapsed .logout-footer-btn { padding: 9px; min-width: 0; }
        .sidebar.collapsed .sidebar-footer a   { justify-content: center; }
        .sidebar.collapsed .sidebar-footer a i { margin: 0; }

        /* Tooltip on collapsed icon links */
        .nav-link { position: relative; }
        .sidebar.collapsed .nav-link::after { display: none; }
        .sidebar.collapsed .nav-link[data-tip]:hover::before {
            content: attr(data-tip);
            position: absolute; left: calc(100% + 10px); top: 50%;
            transform: translateY(-50%);
            background: var(--bg-card); border: 1px solid var(--border-strong);
            border-radius: var(--radius-xs);
            padding: 5px 10px; font-size: 12px; font-weight: 500;
            color: var(--text-primary); white-space: nowrap;
            box-shadow: var(--shadow-drop);
            pointer-events: none; z-index: 500;
            animation: tooltip-in .15s ease both;
        }
        @keyframes tooltip-in { from{opacity:0;transform:translateY(-50%) translateX(-4px)} to{opacity:1;transform:translateY(-50%) translateX(0)} }

        /* ── Status pill ── */
        .sidebar-status {
            display: flex; align-items: center; gap: 8px;
            margin: 0 10px 2px; padding: 8px 12px;
            background: var(--accent-soft); border: 1px solid rgba(79,140,255,.12);
            border-radius: var(--radius-sm); flex-shrink: 0;
            overflow: hidden; transition: padding var(--sb-transition);
        }
        .status-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--success); flex-shrink: 0;
            animation: pulse-dot 2.4s ease infinite;
        }
        @keyframes pulse-dot { 0%,100%{box-shadow:0 0 0 0 rgba(47,214,167,.6)} 50%{box-shadow:0 0 0 5px rgba(47,214,167,0)} }
        .status-label {
            font-size: 10px; font-weight: 600; color: var(--accent);
            text-transform: uppercase; letter-spacing: .7px;
            white-space: nowrap; overflow: hidden;
            transition: opacity .2s, max-width var(--sb-transition);
            max-width: 200px;
        }
        .sidebar.collapsed .status-label { max-width: 0; opacity: 0; }

        /* ── Nav section card ── */
        .nav-section {
            margin: 0 10px;
            background: rgba(255,255,255,.018);
            border: 1px solid rgba(255,255,255,.04);
            border-radius: var(--radius); overflow: hidden;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.04);
            flex-shrink: 0;
            animation: section-in .4s var(--ease-out) both;
            transition: margin var(--sb-transition), border-radius var(--sb-transition), border-color .25s;
        }
        .nav-section:hover { border-color: rgba(79,140,255,.09); }
        .sidebar.collapsed .nav-section { margin: 0 6px; }

        .nav-section:nth-child(2) { animation-delay:.06s }
        .nav-section:nth-child(3) { animation-delay:.12s }
        .nav-section:nth-child(4) { animation-delay:.18s }
        .nav-section:nth-child(5) { animation-delay:.24s }
        @keyframes section-in { from{opacity:0;transform:translateX(-14px)} to{opacity:1;transform:translateX(0)} }

        .nav-section-label {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 13px 7px; font-size: 9px; font-weight: 700;
            color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.2px;
            border-bottom: 1px solid rgba(255,255,255,.04);
            user-select: none; overflow: hidden; white-space: nowrap;
            transition: padding var(--sb-transition), opacity .2s;
        }
        .nav-section-label i { font-size: 8px; color: var(--text-subtle); flex-shrink: 0; }
        .sidebar.collapsed .nav-section-label {
            justify-content: center; padding: 7px 4px;
            border-bottom-color: transparent;
        }
        .nav-section-label .label-text {
            overflow: hidden; max-width: 200px;
            transition: max-width var(--sb-transition), opacity .2s;
        }
        .sidebar.collapsed .nav-section-label .label-text { max-width: 0; opacity: 0; }

        .nav-group { padding: 5px 6px 6px; display: flex; flex-direction: column; gap: 1px; }

        /* ── Nav link ── */
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 8.5px 10px; border-radius: var(--radius-xs);
            text-decoration: none; color: var(--text-secondary);
            font-size: 13px; font-weight: 500;
            transition: color .18s, background .18s, padding-left .2s, padding .18s, gap var(--sb-transition), justify-content var(--sb-transition);
            position: relative; overflow: hidden;
        }
        .nav-link i {
            width: 16px; font-size: 12.5px; flex-shrink: 0;
            color: var(--text-muted);
            transition: color .18s, transform .25s var(--ease-spring), filter .25s ease;
        }
        /* Shimmer sweep */
        .nav-link::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(79,140,255,.07) 50%, transparent 100%);
            transform: translateX(-100%); transition: transform .38s ease; pointer-events: none;
        }
        .nav-link:hover::before { transform: translateX(100%); }
        .nav-link:hover { color: var(--text-primary); background: rgba(255,255,255,.05); padding-left: 13px; }
        .nav-link:hover i { color: var(--accent); transform: scale(1.16); }
        .sidebar.collapsed .nav-link:hover { padding-left: 10px; }

        .nav-link.active {
            color: var(--accent); background: rgba(79,140,255,.10); padding-left: 13px;
            box-shadow: inset 0 0 0 1px rgba(79,140,255,.12);
        }
        .nav-link.active i { color: var(--accent); filter: drop-shadow(0 0 6px rgba(79,140,255,.65)); }
        /* Active bar — the signature gold-tipped indicator */
        .nav-link.active::after {
            content: ''; position: absolute; left: 0; top: 6px; bottom: 6px;
            width: 3px; background: linear-gradient(to bottom, var(--accent), var(--gold));
            border-radius: 0 3px 3px 0;
            box-shadow: 0 0 10px rgba(242,177,52,.35);
            transition: opacity .2s;
            animation: bar-glow 2.6s ease-in-out infinite;
        }
        @keyframes bar-glow { 0%,100%{box-shadow:0 0 10px rgba(242,177,52,.35)} 50%{box-shadow:0 0 16px rgba(242,177,52,.6)} }
        .sidebar.collapsed .nav-link.active { padding-left: 10px; box-shadow: none; }
        .sidebar.collapsed .nav-link.active::after { opacity: 0; }

        /* Text inside nav-link */
        .nav-link-text {
            overflow: hidden; max-width: 200px; white-space: nowrap;
            transition: max-width var(--sb-transition), opacity .2s;
        }
        .sidebar.collapsed .nav-link-text { max-width: 0; opacity: 0; }

        .nav-link .nav-badge {
            margin-left: auto; background: var(--danger); color: #fff;
            font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 99px;
            min-width: 20px; text-align: center;
            animation: badge-pop .35s var(--ease-spring) both;
            transition: opacity .2s, max-width var(--sb-transition);
            overflow: hidden; max-width: 40px;
        }
        .sidebar.collapsed .nav-link .nav-badge { max-width: 0; opacity: 0; }

        /* ── Sidebar footer ── */
        .sidebar-footer {
            padding: 10px 10px 14px; border-top: 1px solid var(--border);
            display: flex; flex-direction: column; gap: 3px;
            flex-shrink: 0; background: var(--sidebar-bg);
            transition: padding var(--sb-transition);
        }
        .sidebar.collapsed .sidebar-footer { padding: 10px 6px 14px; align-items: center; }

        /* Scroll-more bouncing dots */
        .scroll-more {
            display: flex; align-items: center; justify-content: center; gap: 4px;
            padding: 4px 0 6px; opacity: 0; transition: opacity .3s;
            overflow: hidden;
        }
        .scroll-more span {
            width: 3px; height: 3px; border-radius: 50%; background: var(--text-subtle);
            animation: dot-bounce 1.3s ease infinite;
        }
        .scroll-more span:nth-child(2) { animation-delay:.15s }
        .scroll-more span:nth-child(3) { animation-delay:.30s }
        @keyframes dot-bounce { 0%,100%{transform:translateY(0);opacity:.4} 50%{transform:translateY(-3px);opacity:1} }
        .scroll-more.visible { opacity: 1; }

        .sidebar-footer a {
            display: flex; align-items: center; gap: 10px;
            padding: 7px 10px; border-radius: var(--radius-xs);
            font-size: 13px; color: var(--text-muted); text-decoration: none;
            transition: color .15s, background .15s, padding-left .18s, justify-content var(--sb-transition);
            overflow: hidden; white-space: nowrap;
        }
        .sidebar-footer a:hover { color: var(--text-primary); background: rgba(255,255,255,.04); padding-left: 13px; }
        .sidebar-footer a i { width: 14px; font-size: 12px; flex-shrink: 0; }
        .sidebar.collapsed .sidebar-footer a { justify-content: center; padding-left: 7px; }
        .sidebar.collapsed .sidebar-footer a:hover { padding-left: 7px; }
        .sidebar-footer-link-text {
            overflow: hidden; max-width: 180px; white-space: nowrap;
            transition: max-width var(--sb-transition), opacity .2s;
        }
        .sidebar.collapsed .sidebar-footer-link-text { max-width: 0; opacity: 0; }

        .logout-footer-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 9px; margin-top: 4px;
            border-radius: var(--radius-sm);
            border: 1px solid rgba(242,97,124,.16);
            background: rgba(242,97,124,.055);
            color: var(--danger); font-size: 13px; font-weight: 600;
            font-family: 'Outfit', sans-serif; cursor: pointer;
            transition: background .18s, border-color .18s, transform .18s, box-shadow .18s, padding var(--sb-transition);
            overflow: hidden; white-space: nowrap;
        }
        .logout-footer-btn:hover {
            background: rgba(242,97,124,.13); border-color: rgba(242,97,124,.32);
            transform: translateY(-1px); box-shadow: 0 4px 18px rgba(242,97,124,.16);
        }
        .logout-footer-btn:active { transform: translateY(0) scale(.98); }
        .logout-btn-text {
            overflow: hidden; max-width: 120px; white-space: nowrap;
            transition: max-width var(--sb-transition), opacity .2s;
        }
        .sidebar.collapsed .logout-btn-text { max-width: 0; opacity: 0; }
        .sidebar.collapsed .logout-footer-btn { padding: 9px 0; }

        /* ── Bottom fade mask ── */
        .sidebar-fade-mask {
            position: absolute; bottom: 0; left: 0; right: 0; height: 56px;
            background: linear-gradient(to top, var(--sidebar-bg) 40%, transparent);
            pointer-events: none; z-index: 1; flex-shrink: 0;
        }

        /* Mobile scrim behind an opened sidebar */
        .sidebar-scrim {
            position: fixed; inset: 0; z-index: 190;
            background: rgba(3,5,9,.6); backdrop-filter: blur(2px);
            opacity: 0; pointer-events: none; transition: opacity .25s ease;
        }
        .sidebar-scrim.visible { opacity: 1; pointer-events: auto; }

        /* ══════════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════════ */
        .main-content {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            display: flex; flex-direction: column;
            position: relative; z-index: 1;
            transition: margin-left var(--sb-transition);
        }
        .main-content.collapsed { margin-left: var(--sidebar-collapsed); }

        .content-inner {
            flex: 1; padding: 30px 30px 24px;
            max-width: 1400px; width: 100%;
            position: relative;
            animation: page-in .45s var(--ease-out) both;
        }
        @keyframes page-in { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }

        /* HUD corner framing on the content area */
        .hud-corner {
            position: absolute; width: 18px; height: 18px;
            border: 2px solid var(--accent); opacity: 0;
            pointer-events: none;
            animation: hud-corner-in .6s var(--ease-out) .3s forwards, corner-pulse 4s ease-in-out 1s infinite;
        }
        .hud-corner.tl { top: 6px;  left: 6px;  border-right: none; border-bottom: none; border-radius: 4px 0 0 0; }
        .hud-corner.tr { top: 6px;  right: 6px; border-left: none;  border-bottom: none; border-radius: 0 4px 0 0; }
        .hud-corner.bl { bottom: 6px; left: 6px;  border-right: none; border-top: none; border-radius: 0 0 0 4px; }
        .hud-corner.br { bottom: 6px; right: 6px; border-left: none;  border-top: none; border-radius: 0 0 4px 0; }
        @keyframes hud-corner-in { from{opacity:0} to{opacity:.22} }
        @keyframes corner-pulse { 0%,100%{opacity:.22} 50%{opacity:.4} }

        /* Footer */
        footer {
            margin-left: var(--sidebar-w);
            background: var(--bg-surface); border-top: 1px solid var(--border);
            padding: 14px 30px; position: relative; z-index: 1;
            transition: margin-left var(--sb-transition);
        }
        footer.collapsed { margin-left: var(--sidebar-collapsed); }
        .footer-inner { max-width: 1400px; display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .footer-copy { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 8px; }
        .footer-copy .footer-build {
            font-family: 'JetBrains Mono', monospace; font-size: 10px;
            color: var(--text-subtle); padding: 2px 7px; border: 1px solid var(--border-mid);
            border-radius: 99px;
        }
        .footer-links { display: flex; gap: 18px; }
        .footer-links a {
            font-size: 12px; color: var(--text-muted); text-decoration: none;
            display: flex; align-items: center; gap: 5px; transition: color .15s;
        }
        .footer-links a:hover { color: var(--accent); }

        /* Utility */
        .sr-only { position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0; }
        [x-cloak] { display:none !important; }

        /* ══════════════════════════════════════════
           RESPONSIVE — sidebar becomes an overlay drawer
        ══════════════════════════════════════════ */
        @media (max-width: 900px) {
            .search-wrap { display: none; }
            .topbar-clock { display: none; }
            .topbar { padding: 0 16px; }

            .sidebar { transform: translateX(-100%); transition: transform var(--sb-transition); width: var(--sidebar-w) !important; }
            .sidebar.mobile-open { transform: translateX(0); box-shadow: var(--shadow-drop); }
            .sidebar.collapsed { width: var(--sidebar-w); }
            .sidebar .sidebar-wrapper { width: var(--sidebar-w) !important; }
            .sidebar-toggle-btn { display: none; }

            .main-content, .main-content.collapsed { margin-left: 0; }
            footer, footer.collapsed { margin-left: 0; }

            .content-inner { padding: 20px 16px 18px; }
            .topbar-breadcrumb { display: none; }
        }

        @media (max-width: 560px) {
            .brand-sub { display: none; }
            .user-name, .user-role { display: none; }
            .user-chevron { display: none; }
            .user-chip { padding: 5px; }
        }

        /* Respect reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.001ms !important;
                scroll-behavior: auto !important;
            }
            #fx-canvas, .hud-spotlight, #hud-scanline, .hud-grid { display: none !important; }
            .hud-corner { opacity: .22; }
        }
    </style>
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body>

<!-- ══════════════════ AMBIENT FX LAYER ══════════════════ -->
<div id="route-progress" aria-hidden="true"></div>
<div class="hud-grid" aria-hidden="true"></div>
<canvas id="fx-canvas" aria-hidden="true"></canvas>
<div class="hud-spotlight" id="hudSpotlight" aria-hidden="true"></div>
<div id="hud-scanline" aria-hidden="true"></div>
<div id="toast-stack" aria-live="polite"></div>
<div class="sidebar-scrim" id="sidebarScrim" aria-hidden="true"></div>

<!-- ══════════════════ TOPBAR ══════════════════ -->
<header class="topbar" role="banner">

    <!-- Mobile menu trigger -->
    <button class="topbar-btn ripple-host" id="mobileMenuBtn" type="button" aria-label="Open menu"
            style="display:none; margin-right:6px;">
        <i class="fas fa-bars"></i>
    </button>

    <a href="<?php echo e(route('admin.dashboard')); ?>" class="topbar-brand" aria-label="SkillUp Admin Home">
        <div class="brand-logo-wrap">
            <img src="<?php echo e(asset('image/logo oif skillup(1).png')); ?>" alt="SkillUp Logo">
        </div>
        <div class="brand-text">
            <div class="brand-name">SkillUp</div>
            <div class="brand-sub">Admin Console</div>
        </div>
    </a>

    <div class="topbar-center">
        <div class="topbar-breadcrumb">
            <i class="fas fa-house" aria-hidden="true"></i>
            <i class="fas fa-chevron-right"></i>
            <span class="bc-page"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></span>
        </div>
    </div>

    <div class="topbar-actions">

        <div class="topbar-clock" aria-label="Current time">
            <i class="fas fa-satellite-dish" aria-hidden="true"></i>
            <span id="clockText">--:--:--</span>
            <div class="signal-bars" aria-hidden="true"><span></span><span></span><span></span></div>
        </div>

        <div class="search-wrap">
            <input type="text" id="globalSearchInput" placeholder="Search users, courses…" aria-label="Global search">
            <i class="fas fa-magnifying-glass"></i>
            <div class="search-kbd" aria-hidden="true"><kbd>⌘</kbd><kbd>K</kbd></div>
        </div>

        <button class="topbar-btn theme-toggle ripple-host" id="themeToggle" type="button"
                aria-label="Switch to light mode" title="Switch to light mode">
            <i class="fas fa-sun" aria-hidden="true"></i>
        </button>

        <!-- Notifications -->
        <div style="position:relative;" x-data="{ open: false }">
            <button class="topbar-btn ripple-host" id="notifBellBtn" @click="open = !open" :aria-expanded="open.toString()" aria-label="Notifications">
                <i class="fas fa-bell"></i>
                <span class="badge" aria-label="5 unread">5</span>
            </button>
            <div class="dropdown" x-show="open" @click.away="open = false" x-cloak role="menu">
                <div class="dropdown-header">
                    <div class="dh-name">Notifications</div>
                    <div class="dh-email">5 unread messages</div>
                </div>
                <a href="#" role="menuitem"><i class="fas fa-user-plus"></i> New user registered <span style="font-size:11px;color:var(--text-muted);margin-left:auto;">2m</span></a>
                <a href="#" role="menuitem"><i class="fas fa-graduation-cap"></i> Enrollment updated <span style="font-size:11px;color:var(--text-muted);margin-left:auto;">15m</span></a>
                <a href="#" role="menuitem"><i class="fas fa-chart-line"></i> Report generated <span style="font-size:11px;color:var(--text-muted);margin-left:auto;">1h</span></a>
                <div class="dropdown-divider"></div>
                <a href="#" role="menuitem" style="justify-content:center;color:var(--accent);font-size:12px;font-weight:600;">View all notifications</a>
            </div>
        </div>

        <!-- User Menu -->
        <div style="position:relative;" x-data="{ open: false }">
            <div class="user-chip ripple-host" @click="open = !open" role="button" tabindex="0"
                 @keydown.enter="open = !open" @keydown.space.prevent="open = !open">
                <div class="user-avatar-wrap">
                    <svg class="user-avatar-ring" viewBox="0 0 33 33" aria-hidden="true">
                        <circle class="track" cx="16.5" cy="16.5" r="14.6"></circle>
                        <circle class="fill" cx="16.5" cy="16.5" r="14.6"></circle>
                    </svg>
                    <div class="user-avatar"><i class="fas fa-user-shield"></i></div>
                </div>
                <div>
                    <div class="user-name"><?php echo e(Auth::check() ? Auth::user()->name : 'Admin'); ?></div>
                    <div class="user-role"><i class="fas fa-star"></i> Super Admin</div>
                </div>
                <i class="fas fa-chevron-down user-chevron" :class="open ? 'rotated' : ''"></i>
            </div>
            <div class="dropdown" x-show="open" @click.away="open = false" x-cloak role="menu">
                <div class="dropdown-header">
                    <div class="dh-name"><?php echo e(Auth::check() ? Auth::user()->name : 'Admin'); ?></div>
                    <div class="dh-email"><?php echo e(Auth::check() ? Auth::user()->email : 'admin@skillup.com'); ?></div>
                </div>
                <a href="#" role="menuitem"><i class="fas fa-circle-user"></i> My Profile</a>
                <a href="#" role="menuitem"><i class="fas fa-gear"></i> Settings</a>
                <a href="#" role="menuitem"><i class="fas fa-shield-halved"></i> Security</a>
                <div class="dropdown-divider"></div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin:0;padding:0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="logout-btn" role="menuitem">
                        <i class="fas fa-right-from-bracket"></i> Sign out
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>


<!-- ══════════════════ SIDEBAR (outer shell) ══════════════════ -->
<aside class="sidebar" id="sidebar" aria-label="Main navigation">

    <!-- ── Inner wrapper: bg, border, flex column ── -->
    <div class="sidebar-wrapper" id="sidebarWrapper">

        <!-- Toggle button (peeks out of right edge) -->
        <button class="sidebar-toggle-btn" id="sidebarToggle" type="button"
                aria-label="Toggle sidebar" aria-expanded="true" aria-controls="sidebarScroll">
            <i class="fas fa-chevron-left" aria-hidden="true"></i>
        </button>

        <!-- Scrollable nav area -->
        <div class="sidebar-scroll" id="sidebarScroll">

            <div class="sidebar-status" aria-label="System status">
                <div class="status-dot" aria-hidden="true"></div>
                <span class="status-label">All systems operational</span>
            </div>

            <!-- MAIN -->
            <div class="nav-section" role="navigation" aria-label="Main">
                <div class="nav-section-label">
                    <i class="fas fa-circle-dot" aria-hidden="true"></i>
                    <span class="label-text">Main</span>
                </div>
                <div class="nav-group">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
                       data-tip="Dashboard"
                       <?php if(request()->routeIs('admin.dashboard')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-table-columns" aria-hidden="true"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>"
                       data-tip="User Management"
                       <?php if(request()->routeIs('admin.users*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-users" aria-hidden="true"></i>
                        <span class="nav-link-text">User Management</span>
                    </a>
                    <a href="<?php echo e(route('admin.admins')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.admins*') ? 'active' : ''); ?>"
                       data-tip="Admin Accounts"
                       <?php if(request()->routeIs('admin.admins*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-user-shield" aria-hidden="true"></i>
                        <span class="nav-link-text">Admin Accounts</span>
                    </a>
                    <a href="<?php echo e(route('admin.staff.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.staff*') ? 'active' : ''); ?>"
                       data-tip="Staff Management"
                       <?php if(request()->routeIs('admin.staff*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-id-badge" aria-hidden="true"></i>
                        <span class="nav-link-text">Staff Management</span>
                    </a>
                    <a href="<?php echo e(route('admin.teachers.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.teachers*') ? 'active' : ''); ?>"
                       data-tip="Teacher Management"
                       <?php if(request()->routeIs('admin.teachers*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
                        <span class="nav-link-text">Teacher Management</span>
                    </a>
                    <a href="<?php echo e(route('admin.reports')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.reports') ? 'active' : ''); ?>"
                       data-tip="Reports"
                       <?php if(request()->routeIs('admin.reports')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-chart-bar" aria-hidden="true"></i>
                        <span class="nav-link-text">Reports</span>
                    </a>
                </div>
            </div>

            <!-- LEARNING -->
            <div class="nav-section" role="navigation" aria-label="Learning">
                <div class="nav-section-label">
                    <i class="fas fa-circle-dot" aria-hidden="true"></i>
                    <span class="label-text">Learning</span>
                </div>
                <div class="nav-group">
                    <a href="<?php echo e(route('admin.courses.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.courses*') ? 'active' : ''); ?>"
                       data-tip="Courses"
                       <?php if(request()->routeIs('admin.courses*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-book-open" aria-hidden="true"></i>
                        <span class="nav-link-text">Courses</span>
                    </a>
                    <a href="<?php echo e(route('admin.enrollments.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.enrollments*') ? 'active' : ''); ?>"
                       data-tip="Enrollments"
                       <?php if(request()->routeIs('admin.enrollments*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        <span class="nav-link-text">Enrollments</span>
                    </a>
                    <a href="<?php echo e(route('admin.modules.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.modules*') ? 'active' : ''); ?>"
                       data-tip="Modules"
                       <?php if(request()->routeIs('admin.modules*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-cubes" aria-hidden="true"></i>
                        <span class="nav-link-text">Modules</span>
                    </a>
                </div>
            </div>

            <!-- COMMUNICATION -->
            <div class="nav-section" role="navigation" aria-label="Communication">
                <div class="nav-section-label">
                    <i class="fas fa-circle-dot" aria-hidden="true"></i>
                    <span class="label-text">Communication</span>
                </div>
                <div class="nav-group">
                    <a href="<?php echo e(route('admin.chats.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.chats*') ? 'active' : ''); ?>"
                       data-tip="Messenger"
                       <?php if(request()->routeIs('admin.chats*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-comments" aria-hidden="true"></i>
                        <span class="nav-link-text">Messenger</span>
                        <span id="admin-unread-badge" class="nav-badge" style="display:none;" aria-label="Unread messages">0</span>
                    </a>
                </div>
            </div>

            <!-- MANAGEMENT -->
            <div class="nav-section" role="navigation" aria-label="Management">
                <div class="nav-section-label">
                    <i class="fas fa-circle-dot" aria-hidden="true"></i>
                    <span class="label-text">Management</span>
                </div>
                <div class="nav-group">
                    <a href="<?php echo e(route('admin.excel.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.excel*') ? 'active' : ''); ?>"
                       data-tip="Excel Reports"
                       <?php if(request()->routeIs('admin.excel*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-file-excel" aria-hidden="true"></i>
                        <span class="nav-link-text">Excel Reports</span>
                    </a>
                    <a href="<?php echo e(route('admin.archive')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.archive') ? 'active' : ''); ?>"
                       data-tip="Archive"
                       <?php if(request()->routeIs('admin.archive')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-box-archive" aria-hidden="true"></i>
                        <span class="nav-link-text">Archive</span>
                    </a>
                    <a href="<?php echo e(route('admin.news.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.news*') ? 'active' : ''); ?>"
                       data-tip="News"
                       <?php if(request()->routeIs('admin.news*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-newspaper" aria-hidden="true"></i>
                        <span class="nav-link-text">News</span>
                    </a>
                    <a href="<?php echo e(route('admin.backup.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.backup*') ? 'active' : ''); ?>"
                       data-tip="Backup & Recovery"
                       <?php if(request()->routeIs('admin.backup*')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-shield-halved" aria-hidden="true"></i>
                        <span class="nav-link-text">Backup</span>
                    </a>
                    <a href="<?php echo e(route('admin.settings')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.settings') ? 'active' : ''); ?>"
                       data-tip="Settings"
                       <?php if(request()->routeIs('admin.settings')): ?> aria-current="page" <?php endif; ?>>
                        <i class="fas fa-sliders" aria-hidden="true"></i>
                        <span class="nav-link-text">Settings</span>
                    </a>
                </div>
            </div>

            <div style="height:10px;flex-shrink:0;"></div>
        </div><!-- /sidebar-scroll -->

        <!-- Bottom fade mask -->
        <div class="sidebar-fade-mask" aria-hidden="true"></div>

        <!-- Footer -->
        <div class="sidebar-footer">
            <div class="scroll-more" id="scrollMore" aria-hidden="true">
                <span></span><span></span><span></span>
            </div>
            <a href="#" data-tip="Documentation">
                <i class="fas fa-circle-question" aria-hidden="true"></i>
                <span class="sidebar-footer-link-text">Documentation</span>
            </a>
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin:0;padding:0;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-footer-btn ripple-host">
                    <i class="fas fa-right-from-bracket" aria-hidden="true"></i>
                    <span class="logout-btn-text">Sign out</span>
                </button>
            </form>
        </div>

    </div><!-- /sidebar-wrapper -->
</aside>


<!-- ══════════════════ MAIN CONTENT ══════════════════ -->
<div class="main-content" id="mainContent">
    <div class="content-inner">
        <span class="hud-corner tl" aria-hidden="true"></span>
        <span class="hud-corner tr" aria-hidden="true"></span>
        <span class="hud-corner bl" aria-hidden="true"></span>
        <span class="hud-corner br" aria-hidden="true"></span>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>


<!-- ══════════════════ FOOTER ══════════════════ -->
<footer id="siteFooter" role="contentinfo">
    <div class="footer-inner">
        <span class="footer-copy">
            &copy; <?php echo e(date('Y')); ?> SkillUp. All rights reserved.
            <span class="footer-build">v2.1</span>
        </span>
        <div class="footer-links">
            <a href="#"><i class="fas fa-circle-question" aria-hidden="true"></i> Help</a>
            <a href="#"><i class="fas fa-shield-halved" aria-hidden="true"></i> Privacy</a>
            <a href="#"><i class="fas fa-file-lines" aria-hidden="true"></i> Terms</a>
        </div>
    </div>
</footer>


<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/admin.js" defer></script>

<script>
(function () {
    var STORAGE_KEY = 'skillup_sidebar_collapsed';

    var sidebar     = document.getElementById('sidebar');
    var toggle      = document.getElementById('sidebarToggle');
    var mainContent = document.getElementById('mainContent');
    var footer      = document.getElementById('siteFooter');
    var scroll      = document.getElementById('sidebarScroll');
    var more        = document.getElementById('scrollMore');
    var mobileBtn   = document.getElementById('mobileMenuBtn');
    var scrim       = document.getElementById('sidebarScrim');
    var themeToggle = document.getElementById('themeToggle');

    function updateThemeToggle() {
        if (!themeToggle) return;
        var isLight = document.documentElement.classList.contains('light-mode');
        var icon = themeToggle.querySelector('i');
        var label = isLight ? 'Switch to dark mode' : 'Switch to light mode';
        if (icon) icon.className = isLight ? 'fas fa-moon' : 'fas fa-sun';
        themeToggle.setAttribute('aria-label', label);
        themeToggle.setAttribute('title', label);
    }

    updateThemeToggle();
    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            var isLight = document.documentElement.classList.toggle('light-mode');
            localStorage.setItem('skillup_admin_theme', isLight ? 'light' : 'dark');
            updateThemeToggle();
        });
    }

    /* ── Restore persisted state (desktop only) ── */
    if (localStorage.getItem(STORAGE_KEY) === '1' && window.innerWidth > 900) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('collapsed');
        footer.classList.add('collapsed');
        toggle.setAttribute('aria-expanded', 'false');
    }

    /* ── Desktop collapse toggle ── */
    if (toggle) {
        toggle.addEventListener('click', function () {
            var isCollapsed = sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed', isCollapsed);
            footer.classList.toggle('collapsed', isCollapsed);
            toggle.setAttribute('aria-expanded', (!isCollapsed).toString());
            localStorage.setItem(STORAGE_KEY, isCollapsed ? '1' : '0');
        });
    }

    /* ── Mobile drawer toggle ── */
    function setMobileMenuVisibility() {
        if (mobileBtn) mobileBtn.style.display = window.innerWidth <= 900 ? 'flex' : 'none';
    }
    setMobileMenuVisibility();
    window.addEventListener('resize', setMobileMenuVisibility);

    function openMobileSidebar() {
        sidebar.classList.add('mobile-open');
        scrim.classList.add('visible');
    }
    function closeMobileSidebar() {
        sidebar.classList.remove('mobile-open');
        scrim.classList.remove('visible');
    }
    if (mobileBtn) mobileBtn.addEventListener('click', openMobileSidebar);
    if (scrim) scrim.addEventListener('click', closeMobileSidebar);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMobileSidebar();
    });

    /* ── Scroll indicator dots ── */
    if (scroll && more) {
        function updateDots() {
            var canScroll = scroll.scrollHeight > scroll.clientHeight + 4;
            var atBottom  = scroll.scrollTop + scroll.clientHeight >= scroll.scrollHeight - 8;
            more.classList.toggle('visible', canScroll && !atBottom);
        }
        scroll.addEventListener('scroll', updateDots, { passive: true });
        window.addEventListener('resize', updateDots);
        requestAnimationFrame(updateDots);
    }

    /* ── Cmd/Ctrl+K focuses global search ── */
    var searchInput = document.getElementById('globalSearchInput');
    document.addEventListener('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (searchInput) searchInput.focus();
        }
    });

    /* ── Ripple effect for chrome buttons ── */
    document.querySelectorAll('.ripple-host').forEach(function (el) {
        el.addEventListener('click', function (e) {
            var rect = el.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height) * 1.4;
            var ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top  = (e.clientY - rect.top  - size / 2) + 'px';
            el.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 650);
        });
    });

    /* ── Lightweight toast helper: window.SkillUp.toast('Saved', 'success') ── */
    window.SkillUp = window.SkillUp || {};
    window.SkillUp.toast = function (message, type) {
        type = type || 'info';
        var icons = { success: 'fa-circle-check', error: 'fa-circle-exclamation', info: 'fa-circle-info' };
        var stack = document.getElementById('toast-stack');
        if (!stack) return;
        var el = document.createElement('div');
        el.className = 'toast ' + type;
        el.innerHTML = '<i class="fas ' + (icons[type] || icons.info) + '"></i><span>' + message + '</span>';
        stack.appendChild(el);
        setTimeout(function () {
            el.classList.add('leaving');
            setTimeout(function () { el.remove(); }, 300);
        }, 3800);
    };
})();
</script>

<script>
(function () {
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var fine = window.matchMedia('(pointer: fine)').matches;

    /* ── Route boot progress bar ── */
    var prog = document.getElementById('route-progress');
    if (prog) {
        var finish = function () {
            prog.style.width = '100%';
            setTimeout(function () { prog.classList.add('done'); }, 250);
        };
        requestAnimationFrame(function () { prog.style.width = '78%'; });
        if (document.readyState === 'complete') {
            finish();
        } else {
            window.addEventListener('load', finish);
        }
    }

    /* ── Live HUD clock ── */
    var clockText = document.getElementById('clockText');
    if (clockText) {
        var pad = function (n) { return n < 10 ? '0' + n : '' + n; };
        var tick = function () {
            var now = new Date();
            clockText.textContent = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
        };
        tick();
        setInterval(tick, 1000);
    }

    /* ── Notification bell — subtle periodic ring ── */
    var bellBtn = document.getElementById('notifBellBtn');
    if (bellBtn && !reduced) {
        bellBtn.classList.add('bell-ring');
    }

    /* ── Ambient cursor spotlight ── */
    if (!reduced && fine) {
        var spot = document.getElementById('hudSpotlight');
        if (spot) {
            var spotRaf = false;
            document.addEventListener('mousemove', function (e) {
                if (spotRaf) return;
                spotRaf = true;
                requestAnimationFrame(function () {
                    spot.style.setProperty('--sx', e.clientX + 'px');
                    spot.style.setProperty('--sy', e.clientY + 'px');
                    spotRaf = false;
                });
            }, { passive: true });
        }
    }

    /* ── Ambient particle network ── */
    if (!reduced) {
        var canvas = document.getElementById('fx-canvas');
        if (canvas && canvas.getContext) {
            var ctx = canvas.getContext('2d');
            var w, h, nodes = [];
            var NODE_COUNT = 32;
            var MAX_DIST = 140;
            var running = true;

            function resize() {
                w = canvas.width = window.innerWidth;
                h = canvas.height = window.innerHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            for (var i = 0; i < NODE_COUNT; i++) {
                nodes.push({
                    x: Math.random() * w,
                    y: Math.random() * h,
                    vx: (Math.random() - 0.5) * 0.25,
                    vy: (Math.random() - 0.5) * 0.25
                });
            }

            document.addEventListener('visibilitychange', function () {
                running = document.visibilityState === 'visible';
                if (running) requestAnimationFrame(draw);
            });

            function draw() {
                if (!running) return;
                ctx.clearRect(0, 0, w, h);

                for (var i = 0; i < nodes.length; i++) {
                    var n = nodes[i];
                    n.x += n.vx; n.y += n.vy;
                    if (n.x < 0 || n.x > w) n.vx *= -1;
                    if (n.y < 0 || n.y > h) n.vy *= -1;
                    ctx.beginPath();
                    ctx.arc(n.x, n.y, 1.4, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(79,140,255,0.45)';
                    ctx.fill();
                }

                for (var i = 0; i < nodes.length; i++) {
                    for (var j = i + 1; j < nodes.length; j++) {
                        var dx = nodes[i].x - nodes[j].x;
                        var dy = nodes[i].y - nodes[j].y;
                        var dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < MAX_DIST) {
                            ctx.beginPath();
                            ctx.moveTo(nodes[i].x, nodes[i].y);
                            ctx.lineTo(nodes[j].x, nodes[j].y);
                            ctx.strokeStyle = 'rgba(79,140,255,' + (0.12 * (1 - dist / MAX_DIST)) + ')';
                            ctx.lineWidth = 1;
                            ctx.stroke();
                        }
                    }
                }

                requestAnimationFrame(draw);
            }
            requestAnimationFrame(draw);
        }
    }
})();
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\layout\Admin\system.blade.php ENDPATH**/ ?>