<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Teacher Portal') | SkillUp</title>
    <style>
        :root {
            --navy-950: #071833;
            --navy-900: #0c2550;
            --navy-800: #153d74;
            --navy-700: #1f4f95;
            --navy-50: #f4f8ff;
            --border: #dfe7f3;
            --text: #10233f;
            --muted: #64748b;
            --white: #ffffff;
            --shadow: 0 16px 40px rgba(7, 24, 51, 0.12);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #f8fbff 0%, var(--navy-50) 100%);
            color: var(--text);
        }

        a { text-decoration: none; }

        .app-shell { min-height: 100vh; display: flex; background: var(--navy-50); }

        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, var(--navy-900) 0%, var(--navy-950) 100%);
            color: var(--white);
            display: flex;
            flex-direction: column;
            padding: 1.2rem 0.95rem;
            box-shadow: 12px 0 30px rgba(7, 24, 51, 0.18);
            position: sticky;
            top: 0;
            height: 100vh;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.4rem 0.4rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
            margin-bottom: 1.1rem;
        }

        .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: rgba(255,255,255,0.16);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.04em;
        }

        .brand-text strong { display: block; font-size: 1rem; }
        .brand-text span { color: rgba(255,255,255,0.7); font-size: 0.8rem; }

        .nav-links { display: flex; flex-direction: column; gap: 0.35rem; margin-top: 0.4rem; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 0.9rem;
            color: rgba(255,255,255,0.84);
            border-radius: 0.9rem;
            transition: all 0.2s ease;
            font-weight: 600;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255,255,255,0.13);
            color: var(--white);
            transform: translateX(2px);
        }

        .sidebar-footer { margin-top: auto; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.12); }

        .signout-btn {
            width: 100%;
            border: 0;
            border-radius: 0.9rem;
            padding: 0.8rem 0.95rem;
            font-weight: 700;
            background: rgba(255,255,255,0.1);
            color: #fff;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .signout-btn:hover { background: rgba(255,255,255,0.2); }

        .main-panel { flex: 1; display: flex; flex-direction: column; min-width: 0; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.35rem;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 8px 24px rgba(7,24,51,0.04);
            position: sticky;
            top: 0;
            z-index: 15;
        }

        .topbar-left { display: flex; align-items: center; gap: 0.8rem; }

        .mobile-toggle {
            display: none;
            border: 0;
            width: 42px;
            height: 42px;
            border-radius: 0.8rem;
            background: var(--navy-50);
            color: var(--navy-800);
            cursor: pointer;
            font-size: 1rem;
        }

        .topbar-title small { display: block; color: var(--muted); font-size: 0.83rem; }
        .topbar-title h1 { margin: 0; font-size: 1.12rem; color: var(--navy-950); }

        .topbar-user {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.5rem 0.75rem;
            border-radius: 999px;
            background: var(--navy-50);
            color: var(--navy-800);
            font-weight: 600;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--navy-700), var(--navy-900));
            color: var(--white);
            display: grid;
            place-items: center;
            font-size: 0.9rem;
            font-weight: 700;
        }

        .page-content { padding: 1.35rem; display: flex; flex-direction: column; gap: 1rem; }

        .alert {
            padding: 0.85rem 1rem;
            border-radius: 0.9rem;
            background: #e3f2ff;
            color: var(--navy-800);
            border: 1px solid #c2dcff;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 1.1rem;
            box-shadow: var(--shadow);
            padding: 1.1rem;
        }

        .overlay { display: none; }

        @media (max-width: 920px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
                height: 100vh;
                width: 280px;
            }
            .sidebar.open { transform: translateX(0); }
            .mobile-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(7,24,51,0.45);
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.25s ease;
                z-index: 10;
            }
            .overlay.visible { opacity: 1; pointer-events: auto; }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <div class="brand-badge">SU</div>
                <div class="brand-text">
                    <strong>SkillUp Teacher</strong>
                    <span>Learning portal</span>
                </div>
            </div>

            <nav class="nav-links" aria-label="Teacher navigation">
                <a class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">◉ Dashboard</a>
                <a class="nav-link {{ request()->routeIs('teacher.courses*') ? 'active' : '' }}" href="{{ route('teacher.courses.index') }}">▣ Courses</a>
                <a class="nav-link {{ request()->routeIs('teacher.modules*') ? 'active' : '' }}" href="{{ route('teacher.modules.index') }}">◫ Modules</a>
                <a class="nav-link {{ request()->routeIs('teacher.students*') ? 'active' : '' }}" href="{{ route('teacher.students.index') }}">◌ Students</a>
                <a class="nav-link {{ request()->routeIs('teacher.progress*') ? 'active' : '' }}" href="{{ route('teacher.progress.index') }}">◍ Progress</a>
                <a class="nav-link {{ request()->routeIs('teacher.profile*') ? 'active' : '' }}" href="{{ route('teacher.profile.edit') }}">◎ Profile</a>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('teacher.logout') }}">
                    @csrf
                    <button type="submit" class="signout-btn">Sign out</button>
                </form>
            </div>
        </aside>

        <div class="overlay" id="sidebarOverlay"></div>

        <div class="main-panel">
            <header class="topbar">
                <div class="topbar-left">
                    <button class="mobile-toggle" id="mobileToggle" type="button" aria-label="Toggle navigation">☰</button>
                    <div class="topbar-title">
                        <small>Teacher workspace</small>
                        <h1>@yield('page_title', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="topbar-user">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'I', 0, 1)) }}</div>
                    <span>{{ auth()->user()->name ?? 'Instructor' }}</span>
                </div>
            </header>

            <main class="page-content">
                @if(session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('mobileToggle');

        const openSidebar = () => { sidebar?.classList.add('open'); overlay?.classList.add('visible'); };
        const closeSidebar = () => { sidebar?.classList.remove('open'); overlay?.classList.remove('visible'); };

        toggle?.addEventListener('click', () => sidebar?.classList.contains('open') ? closeSidebar() : openSidebar());
        overlay?.addEventListener('click', closeSidebar);
    </script>
</body>
</html>
