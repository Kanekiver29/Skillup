<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teacher Portal') | SkillUp</title>
    <link rel ="icon" href="{{ asset('image/logo_oif_skillup_1_-removebg-preview.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ─── TOKENS ──────────────────────────────────────────────── */
        :root {
            --navy-950:  #03091a;
            --navy-900:  #071228;
            --navy-800:  #0d1f45;
            --navy-700:  #142d63;
            --navy-600:  #1a3a82;
            --navy-500:  #2150a8;
            --navy-400:  #3a6ed4;
            --navy-200:  #93b4ef;
            --navy-100:  #c8d9f8;
            --navy-50:   #eef3fd;

            --tesda-blue:  #1a2dbf;
            --accent:      #2563eb;
            --accent-soft: #3b82f6;
            --accent-glow: rgba(37,99,235,0.22);
            --accent-muted:rgba(37,99,235,0.10);

            --surface:  #ffffff;
            --border:   #e0e9f8;
            --text:     #0b1a35;
            --muted:    #56708f;
            --white:    #ffffff;

            --sidebar-w:   272px;
            --topbar-h:    64px;
            --radius-lg:   0.9rem;
            --radius-xl:   1.2rem;
            --shadow-card:    0 2px 20px rgba(10,30,70,0.08);
            --shadow-sidebar: 20px 0 60px rgba(3,9,26,0.28);
            --ease: cubic-bezier(0.4,0,0.2,1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background: #f0f4fc;
            color: var(--text);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }

        /* ─── KEYFRAMES ───────────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0);    }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0);     }
        }
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-14px); }
            to   { opacity: 1; transform: translateY(0);     }
        }
        @keyframes rocketHover {
            0%, 100% { transform: translateY(0px) scale(1);   }
            50%       { transform: translateY(-5px) scale(1.04); }
        }
        @keyframes thruster {
            0%, 100% { opacity: 0.7; transform: scaleY(1);   }
            50%       { opacity: 1;   transform: scaleY(1.2); }
        }
        @keyframes glowPulse {
            0%, 100% { box-shadow: 0 0 0 0 var(--accent-glow); }
            50%       { box-shadow: 0 0 20px 6px var(--accent-glow); }
        }
        @keyframes sidebarShimmer {
            0%   { background-position: -600px 0; }
            100% { background-position: 600px 0;  }
        }
        @keyframes dotBounce {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40%            { transform: scale(1.2); opacity: 1;   }
        }
        @keyframes badgeSpin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* ─── SHELL ───────────────────────────────────────────────── */
        .app-shell { display: flex; min-height: 100vh; }

        /* ─── SIDEBAR ─────────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background:
                linear-gradient(168deg, var(--navy-700) 0%, var(--navy-950) 100%);
            color: var(--white);
            display: flex;
            flex-direction: column;
            padding: 0 0.8rem 1.2rem;
            box-shadow: var(--shadow-sidebar);
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 20;
            animation: slideInLeft 0.5s var(--ease) both;
            overflow: hidden;
        }

        /* Animated grain/shimmer overlay */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                105deg,
                transparent 30%,
                rgba(255,255,255,0.04) 50%,
                transparent 70%
            );
            background-size: 600px 100%;
            animation: sidebarShimmer 5s ease-in-out infinite;
            pointer-events: none;
        }

        /* Blue glow at bottom */
        .sidebar::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: 50%;
            transform: translateX(-50%);
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.35) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ─── BRAND / LOGO ────────────────────────────────────────── */
        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.4rem 0.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 0.5rem;
            position: relative;
            gap: 0.6rem;
        }

        .brand-logo-wrap {
            position: relative;
            width: 72px;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Spinning ring behind logo */
        .brand-logo-wrap::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px dashed rgba(255,255,255,0.18);
            animation: badgeSpin 18s linear infinite;
        }

        /* Glow ring */
        .brand-logo-wrap::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.3) 0%, transparent 70%);
            animation: glowPulse 3s ease infinite;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            object-fit: contain;
            animation: rocketHover 3.5s ease-in-out infinite;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 4px 16px rgba(37,99,235,0.5));
        }

        .brand-text {
            text-align: center;
        }

        .brand-text strong {
            display: block;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .brand-text span {
            color: rgba(255,255,255,0.5);
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* ─── NAV SECTION LABEL ───────────────────────────────────── */
        .nav-section-label {
            font-size: 0.63rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 0.85rem 0.6rem 0.3rem;
        }

        /* ─── NAV ─────────────────────────────────────────────────── */
        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 0.18rem;
            overflow-y: auto;
            flex: 1;
            scrollbar-width: none;
        }
        .nav-links::-webkit-scrollbar { display: none; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.68rem 0.8rem;
            color: rgba(255,255,255,0.7);
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s var(--ease);
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: slideInLeft 0.4s var(--ease) both;
        }

        .nav-link:nth-child(1)  { animation-delay: 0.08s; }
        .nav-link:nth-child(2)  { animation-delay: 0.12s; }
        .nav-link:nth-child(3)  { animation-delay: 0.15s; }
        .nav-link:nth-child(4)  { animation-delay: 0.18s; }
        .nav-link:nth-child(5)  { animation-delay: 0.21s; }
        .nav-link:nth-child(6)  { animation-delay: 0.24s; }
        .nav-link:nth-child(7)  { animation-delay: 0.27s; }
        .nav-link:nth-child(8)  { animation-delay: 0.30s; }
        .nav-link:nth-child(9)  { animation-delay: 0.33s; }
        .nav-link:nth-child(10) { animation-delay: 0.36s; }
        .nav-link:nth-child(11) { animation-delay: 0.39s; }

        .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: transparent;
            border-radius: inherit;
            transition: background 0.2s var(--ease);
        }
        .nav-link:hover::before  { background: rgba(255,255,255,0.08); }
        .nav-link.active::before { background: rgba(37,99,235,0.28); }

        .nav-link:hover  { color: var(--white); transform: translateX(4px); }
        .nav-link.active { color: var(--white); transform: translateX(4px); }

        /* Active bar */
        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0; top: 20%; height: 60%;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: var(--accent-soft);
        }

        .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: rgba(255,255,255,0.07);
            display: grid;
            place-items: center;
            font-size: 0.85rem;
            flex-shrink: 0;
            transition: background 0.2s var(--ease), transform 0.2s var(--ease);
        }
        .nav-link:hover .nav-icon,
        .nav-link.active .nav-icon {
            background: rgba(37,99,235,0.38);
            transform: scale(1.1) rotate(-2deg);
        }

        /* ─── SIDEBAR FOOTER ──────────────────────────────────────── */
        .sidebar-footer {
            margin-top: 0.5rem;
            padding-top: 0.9rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .signout-btn {
            width: 100%;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 0.75rem;
            padding: 0.72rem 1rem;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            background: rgba(255,255,255,0.05);
            color: rgba(255,255,255,0.78);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s var(--ease);
        }
        .signout-btn:hover {
            background: rgba(239,68,68,0.18);
            border-color: rgba(239,68,68,0.35);
            color: #fca5a5;
            transform: translateY(-1px);
        }

        /* ─── MAIN PANEL ──────────────────────────────────────────── */
        .main-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* ─── TOPBAR ──────────────────────────────────────────────── */
        .topbar {
            height: var(--topbar-h);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 20px rgba(10,30,70,0.06);
            position: sticky;
            top: 0;
            z-index: 15;
            animation: slideInDown 0.45s var(--ease) both;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .mobile-toggle {
            display: none;
            border: 1px solid var(--border);
            width: 40px;
            height: 40px;
            border-radius: 0.7rem;
            background: var(--navy-50);
            color: var(--navy-700);
            cursor: pointer;
            font-size: 1rem;
            align-items: center;
            justify-content: center;
            transition: all 0.2s var(--ease);
        }
        .mobile-toggle:hover {
            background: var(--navy-100);
            border-color: var(--navy-400);
        }

        /* Topbar breadcrumb + logo combo */
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .topbar-logo {
            width: 34px;
            height: 34px;
            object-fit: contain;
            animation: rocketHover 3.5s ease-in-out infinite;
            filter: drop-shadow(0 2px 6px rgba(37,99,235,0.3));
        }

        .topbar-divider {
            width: 1px;
            height: 28px;
            background: var(--border);
        }

        .topbar-title small {
            display: block;
            color: var(--muted);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .topbar-title h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--navy-950);
            letter-spacing: -0.02em;
        }

        /* ─── TOPBAR USER ─────────────────────────────────────────── */
        .topbar-user {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.4rem 0.85rem 0.4rem 0.4rem;
            border-radius: 999px;
            background: var(--navy-50);
            border: 1px solid var(--border);
            color: var(--navy-800);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: default;
            transition: all 0.2s var(--ease);
        }
        .topbar-user:hover {
            background: var(--navy-100);
            border-color: var(--navy-400);
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--navy-700));
            color: var(--white);
            display: grid;
            place-items: center;
            font-size: 0.82rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* Online dot */
        .avatar-wrap {
            position: relative;
        }
        .avatar-wrap::after {
            content: '';
            position: absolute;
            bottom: 1px; right: 1px;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #22c55e;
            border: 2px solid var(--navy-50);
        }

        /* ─── PAGE CONTENT ────────────────────────────────────────── */
        .page-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            animation: fadeUp 0.5s 0.15s var(--ease) both;
        }

        /* ─── ALERT ───────────────────────────────────────────────── */
        .alert {
            padding: 0.85rem 1.1rem;
            border-radius: var(--radius-lg);
            background: linear-gradient(90deg, #eff6ff, #dbeafe);
            color: #1e40af;
            border: 1px solid #bfdbfe;
            font-weight: 600;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            animation: fadeUp 0.35s var(--ease) both;
        }
        .alert-icon {
            width: 24px; height: 24px;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            display: grid; place-items: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        /* ─── CARD ────────────────────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-card);
            padding: 1.25rem;
            transition: box-shadow 0.2s var(--ease), transform 0.2s var(--ease);
        }
        .card:hover {
            box-shadow: 0 8px 32px rgba(10,30,70,0.12);
            transform: translateY(-1px);
        }

        /* ─── ACTION BUTTONS ──────────────────────────────────────── */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 0.75rem;
        }
        .action-button {
            padding: 0.85rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            background: var(--surface);
            color: var(--navy-950);
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s var(--ease);
        }
        .action-button:hover {
            background: var(--navy-50);
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.12);
        }

        /* ─── OVERLAY ─────────────────────────────────────────────── */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(3,9,26,0.55);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
            z-index: 10;
            backdrop-filter: blur(2px);
        }
        .overlay.visible { opacity: 1; pointer-events: auto; }

        /* ─── REDUCED MOTION ──────────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* ─── RESPONSIVE ──────────────────────────────────────────── */
        @media (max-width: 960px) {
            .sidebar {
                position: fixed;
                left: 0; top: 0;
                transform: translateX(-100%);
                transition: transform 0.3s var(--ease);
                height: 100vh;
                animation: none;
            }
            .sidebar.open { transform: translateX(0); }
            .mobile-toggle { display: inline-flex; }
            .overlay { display: block; }
        }

        @media (max-width: 480px) {
            .page-content { padding: 1rem; }
            .topbar { padding: 0 1rem; }
        }
    </style>
</head>
<body>
<div class="app-shell">

    {{-- ─── SIDEBAR ─────────────────────────────────────── --}}
    <aside class="sidebar" id="sidebar" aria-label="Teacher navigation">

        <div class="brand">
            <div class="brand-logo-wrap">
                <img
                    src="{{ asset('image/logo oif skillup(1).png') }}"
                    alt="SkillUp Logo"
                    class="brand-logo"
                >
            </div>
            <div class="brand-text">
                <strong>SkillUp Teacher</strong>
                <span>Learning Portal</span>
            </div>
        </div>

        <div class="nav-section-label">Main</div>

        <nav class="nav-links">
            <a class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"
               href="{{ route('teacher.dashboard') }}">
                <span class="nav-icon">◉</span> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('teacher.courses*') ? 'active' : '' }}"
               href="{{ route('teacher.courses.index') }}">
                <span class="nav-icon">▣</span> Courses
            </a>
            <a class="nav-link {{ request()->routeIs('teacher.modules*') ? 'active' : '' }}"
               href="{{ route('teacher.modules.index') }}">
                <span class="nav-icon">◫</span> Modules
            </a>

            <div class="nav-section-label">Content</div>

            <a class="nav-link {{ request()->routeIs('teacher.quizzes.create') ? 'active' : '' }}"
               href="{{ route('teacher.quizzes.create') }}">
                <span class="nav-icon">✚</span> Add Quiz
            </a>
            <a class="nav-link {{ request()->is('teacher/modules/upload-resource*') && request()->query('type') == 'word' ? 'active' : '' }}"
               href="{{ route('teacher.modules.upload-resource') }}?type=word">
                <span class="nav-icon">✎</span> Add Word
            </a>
            <a class="nav-link {{ request()->is('teacher/modules/upload-resource*') && request()->query('type') == 'video' ? 'active' : '' }}"
               href="{{ route('teacher.modules.upload-resource') }}?type=video">
                <span class="nav-icon">▶</span> Add Video
            </a>
            <a class="nav-link {{ request()->is('teacher/modules/upload-resource*') && request()->query('type') == 'image' ? 'active' : '' }}"
               href="{{ route('teacher.modules.upload-resource') }}?type=image">
                <span class="nav-icon">🖼</span> Add Image
            </a>
            <a class="nav-link {{ request()->is('teacher/modules/upload-resource*') && request()->query('type') == 'ppt' ? 'active' : '' }}"
               href="{{ route('teacher.modules.upload-resource') }}?type=ppt">
                <span class="nav-icon">📄</span> Add PPT
            </a>

            <div class="nav-section-label">People</div>

            <a class="nav-link {{ request()->routeIs('teacher.students*') ? 'active' : '' }}"
               href="{{ route('teacher.students.index') }}">
                <span class="nav-icon">◌</span> Students
            </a>
            <a class="nav-link {{ request()->routeIs('teacher.progress*') ? 'active' : '' }}"
               href="{{ route('teacher.progress.index') }}">
                <span class="nav-icon">◍</span> Progress
            </a>
            <a class="nav-link {{ request()->routeIs('teacher.profile*') ? 'active' : '' }}"
               href="{{ route('teacher.profile.edit') }}">
                <span class="nav-icon">◎</span> Profile
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('teacher.logout') }}">
                @csrf
                <button type="submit" class="signout-btn">
                    <span>⎋</span> Sign out
                </button>
            </form>
        </div>
    </aside>

    <div class="overlay" id="sidebarOverlay"></div>

    {{-- ─── MAIN PANEL ───────────────────────────────────── --}}
    <div class="main-panel">

        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" id="mobileToggle" type="button" aria-label="Toggle navigation">☰</button>

                <div class="topbar-brand">
                    <img
                        src="{{ asset('image/logo oif skillup(1).png') }}"
                        alt="SkillUp"
                        class="topbar-logo"
                    >
                    <div class="topbar-divider"></div>
                    <div class="topbar-title">
                        <small>Teacher workspace</small>
                        <h1>@yield('page_title', 'Dashboard')</h1>
                    </div>
                </div>
            </div>

            <div class="avatar-wrap">
                <div class="topbar-user">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'I', 0, 1)) }}</div>
                    <span>{{ auth()->user()->name ?? 'Instructor' }}</span>
                </div>
            </div>
        </header>

        <main class="page-content">
            @if(session('success'))
                <div class="alert" role="alert">
                    <div class="alert-icon">✓</div>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle  = document.getElementById('mobileToggle');

    const openSidebar  = () => { sidebar?.classList.add('open');    overlay?.classList.add('visible');    };
    const closeSidebar = () => { sidebar?.classList.remove('open'); overlay?.classList.remove('visible'); };

    toggle?.addEventListener('click', () =>
        sidebar?.classList.contains('open') ? closeSidebar() : openSidebar()
    );
    overlay?.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', e => e.key === 'Escape' && closeSidebar());
</script>
</body>
</html>