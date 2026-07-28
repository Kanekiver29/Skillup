<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SkillUp - Dashboard'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        /* ── Tokens ──────────────────────────────────────────────── */
        :root {
            --navy:       #003a8f;
            --navy-dark:  #0a2540;
            --navy-deep:  #061828;
            --purple:     #5b4fcf;
            --purple-lt:  #ede9ff;
            --red:        #c1121f;
            --red-lt:     #fff1f2;
            --bg:         #f0f4fa;
            --card:       #ffffff;
            --border:     #e2eaf4;
            --text:       #1f2937;
            --muted:      #6b7280;
            --sidebar-w:  256px;
            --topbar-h:   64px;
            --radius:     10px;
            --shadow-sm:  0 1px 4px rgba(10,37,64,.06);
            --shadow-md:  0 6px 20px rgba(10,37,64,.11);
            --shadow-lg:  0 16px 40px rgba(10,37,64,.16);
            --trans:      .22s cubic-bezier(.4,0,.2,1);
        }

        /* ── Reset ───────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Inter', ui-sans-serif, sans-serif; color: var(--text); background: var(--bg); }
        a { text-decoration: none; color: inherit; }
        button { cursor: pointer; font-family: inherit; }

        /* ── Keyframes ───────────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-16px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes rocketBounce {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-4px); }
        }
        @keyframes pulseDot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(.85); }
        }
        @keyframes streakGlow {
            0%, 100% { box-shadow: 0 0 8px 0 rgba(251,146,60,.3); }
            50%       { box-shadow: 0 0 18px 4px rgba(251,146,60,.55); }
        }

        /* ── Topbar ──────────────────────────────────────────────── */
        .topbar {
            height: var(--topbar-h);
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 100;
            background: linear-gradient(110deg, var(--navy) 0%, var(--navy-dark) 60%, var(--navy-deep) 100%);
            display: flex; align-items: center;
            padding: 0 20px;
            box-shadow: var(--shadow-md);
            animation: slideDown .3s both;
        }

        /* Brand */
        .brand {
            display: flex; align-items: center; gap: 10px;
            flex-shrink: 0;
        }
        .brand-rocket {
            font-size: 22px; color: #fff;
            animation: rocketBounce 2.6s ease-in-out infinite;
            display: inline-block;
        }
        .brand-name {
            font-size: 17px; font-weight: 700; color: #fff; letter-spacing: .3px;
            transition: color var(--trans);
        }
        .brand-name:hover { color: rgba(255,255,255,.8); }

        /* Center nav */
        .top-nav {
            flex: 1;
            display: flex; justify-content: center; align-items: center; gap: 6px;
        }
        @media (max-width: 767px) { .top-nav { display: none; } }
        .top-nav a {
            color: rgba(255,255,255,.8);
            font-size: 13px; font-weight: 500;
            padding: 7px 14px;
            border-radius: 7px;
            transition: background var(--trans), color var(--trans);
        }
        .top-nav a:hover { background: rgba(255,255,255,.12); color: #fff; }

        /* Right actions */
        .top-actions {
            display: flex; align-items: center; gap: 6px;
            flex-shrink: 0;
        }
        .top-btn {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            border-radius: 8px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.85);
            font-size: 15px;
            transition: background var(--trans), color var(--trans), transform var(--trans);
            position: relative;
        }
        .top-btn:hover { background: rgba(255,255,255,.18); color: #fff; transform: translateY(-1px); }
        .top-btn:active { transform: scale(.96); }

        .notif-dot {
            position: absolute; top: 7px; right: 7px;
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--red);
            border: 1.5px solid var(--navy-dark);
            animation: pulseDot 2s ease-in-out infinite;
        }

        /* Hamburger */
        .hamburger {
            display: none;
            width: 36px; height: 36px;
            border-radius: 8px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff; font-size: 16px;
            align-items: center; justify-content: center;
            margin-left: 6px;
            transition: background var(--trans);
        }
        .hamburger:hover { background: rgba(255,255,255,.18); }
        @media (max-width: 767px) { .hamburger { display: flex; } }

        /* ── Mobile slide-over ───────────────────────────────────── */
        .mobile-overlay {
            display: none;
            position: fixed; inset: 0; z-index: 90;
        }
        .mobile-overlay.visible { display: block; }
        .mobile-backdrop {
            position: absolute; inset: 0;
            background: rgba(0,0,0,.45);
            opacity: 0;
            transition: opacity var(--trans);
        }
        .mobile-overlay.visible .mobile-backdrop { opacity: 1; }

        .mobile-panel {
            position: absolute; right: 0; top: 0; bottom: 0;
            width: 272px;
            background: var(--card);
            padding: 20px;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            transform: translateX(110%);
            transition: transform .28s cubic-bezier(.4,0,.2,1);
        }
        .mobile-overlay.visible .mobile-panel { transform: translateX(0); }

        .mobile-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }
        .mobile-close {
            width: 32px; height: 32px;
            border-radius: 7px;
            background: var(--bg); border: 0;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); font-size: 15px;
            transition: background var(--trans), color var(--trans);
        }
        .mobile-close:hover { background: var(--border); color: var(--text); }

        .mobile-user {
            display: flex; align-items: center; gap: 12px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 16px;
        }
        .mobile-avatar {
            width: 42px; height: 42px;
            border-radius: 10px;
            background: var(--purple-lt);
            display: flex; align-items: center; justify-content: center;
            color: var(--purple); font-size: 17px;
            flex-shrink: 0;
        }
        .mobile-user-name  { font-size: 13px; font-weight: 600; }
        .mobile-user-email { font-size: 11px; color: var(--muted); margin-top: 1px; }

        .mobile-nav { display: flex; flex-direction: column; gap: 2px; }
        .mobile-nav a, .mobile-nav button {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: var(--text);
            width: 100%; background: none; border: 0; text-align: left;
            transition: background var(--trans), color var(--trans);
        }
        .mobile-nav a:hover { background: var(--purple-lt); color: var(--purple); }
        .mobile-nav .mobile-logout { color: var(--red); }
        .mobile-nav .mobile-logout:hover { background: var(--red-lt); }
        .mobile-divider { height: 1px; background: var(--border); margin: 8px 0; }

        /* ── Sidebar ─────────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(175deg, #1e1060 0%, #0f2d6b 50%, var(--navy-dark) 100%);
            position: fixed;
            left: 0; top: var(--topbar-h); bottom: 0;
            display: flex; flex-direction: column;
            padding: 18px 12px;
            overflow-y: auto;
            z-index: 40;
            box-shadow: 3px 0 18px rgba(10,37,64,.15);
            animation: slideRight .3s both;
        }
        @media (max-width: 767px) { .sidebar { display: none; } }

        /* Streak widget */
        .streak-widget {
            background: rgba(255,255,255,.09);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
            animation: streakGlow 3s ease-in-out infinite;
        }
        .streak-label {
            font-size: 10px; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
            color: rgba(255,255,255,.55);
            margin-bottom: 8px;
        }
        .streak-value {
            display: flex; align-items: center; gap: 8px;
        }
        .streak-fire { font-size: 24px; }
        .streak-num  { font-size: 26px; font-weight: 700; color: #fff; line-height: 1; }
        .streak-unit { font-size: 12px; color: rgba(255,255,255,.6); }

        /* Sidebar nav section label */
        .sb-label {
            font-size: 10px; font-weight: 700;
            letter-spacing: 1.1px; text-transform: uppercase;
            color: rgba(255,255,255,.35);
            padding: 0 10px;
            margin: 14px 0 5px;
        }

        /* Sidebar links */
        .sb-nav { display: flex; flex-direction: column; gap: 2px; }
        .sb-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,.75);
            transition: background var(--trans), color var(--trans), transform var(--trans);
            position: relative;
        }
        .sb-link:hover {
            background: rgba(255,255,255,.10);
            color: #fff;
            transform: translateX(2px);
        }
        .sb-link.active {
            background: rgba(255,255,255,.15);
            color: #fff;
            font-weight: 600;
            box-shadow: inset 3px 0 0 #fff;
        }
        .sb-link.active:hover { transform: none; }
        .sb-icon { font-size: 14px; width: 20px; text-align: center; flex-shrink: 0; }
        .sb-badge {
            margin-left: auto;
            background: var(--red);
            color: #fff;
            font-size: 10px; font-weight: 700;
            padding: 2px 7px;
            border-radius: 99px;
            min-width: 20px; text-align: center;
        }

        /* Sidebar bottom */
        .sb-bottom {
            margin-top: auto;
            padding-top: 14px;
        }
        .sb-support {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.10);
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 12px;
        }
        .sb-support p  { font-size: 11px; color: rgba(255,255,255,.5); margin-bottom: 6px; }
        .sb-support a  { font-size: 13px; color: rgba(255,255,255,.8); transition: color var(--trans); }
        .sb-support a:hover { color: #fff; }

        .sb-logout {
            width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 14px;
            border-radius: 8px;
            background: rgba(193,18,31,.18);
            border: 1px solid rgba(193,18,31,.25);
            color: #fca5a5;
            font-size: 13px; font-weight: 600;
            transition: background var(--trans), color var(--trans), transform var(--trans);
        }
        .sb-logout:hover {
            background: rgba(193,18,31,.32);
            color: #fecaca;
            transform: translateY(-1px);
        }
        .sb-logout:active { transform: scale(.98); }

        /* ── Main content ─────────────────────────────────────────── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        @media (max-width: 767px) { .main-wrap { margin-left: 0; } }

        .main-content {
            flex: 1;
            padding: 28px 24px;
        }
        .main-inner {
            max-width: 1180px;
            margin: 0 auto;
            animation: fadeUp .35s .05s both;
        }

        /* ── Footer ──────────────────────────────────────────────── */
        .footer {
            background: var(--navy-deep);
            color: rgba(255,255,255,.55);
            padding: 28px 24px;
            font-size: 13px;
        }
        .footer-inner {
            max-width: 1180px; margin: 0 auto;
            display: flex; flex-wrap: wrap;
            align-items: center; justify-content: space-between;
            gap: 12px;
        }
        .footer-socials { display: flex; gap: 16px; }
        .footer-socials a {
            color: rgba(255,255,255,.45);
            font-size: 16px;
            transition: color var(--trans), transform var(--trans);
        }
        .footer-socials a:hover { color: #fff; transform: translateY(-2px); }

        /* ── Utility ─────────────────────────────────────────────── */
        .sr-only {
            position: absolute !important;
            height: 1px; width: 1px;
            overflow: hidden;
            clip: rect(1px,1px,1px,1px);
            white-space: nowrap;
        }
        .hidden { display: none !important; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body>

    
    <header class="topbar">
        <div class="brand">
            <span class="brand-rocket" aria-hidden="true"><i class="fas fa-rocket"></i></span>
            <a href="<?php echo e(route('userpage.dashboard')); ?>" class="brand-name">SkillUp</a>
        </div>

        <nav class="top-nav" aria-label="Primary">
            <a href="<?php echo e(url('/')); ?>">Home</a>
            <a href="<?php echo e(url('/about')); ?>">About</a>
            <a href="<?php echo e(route('courses.index')); ?>">Courses</a>
            <a href="<?php echo e(url('/contact')); ?>">Contact</a>
        </nav>

        <div class="top-actions">
            <a href="<?php echo e(route('notifications.index')); ?>" class="top-btn" aria-label="Notifications">
                <i class="fas fa-bell"></i>
                <span class="notif-dot" aria-hidden="true"></span>
            </a>
            <a href="<?php echo e(route('chats.index')); ?>" class="top-btn" aria-label="Messages">
                <i class="fas fa-comments"></i>
            </a>
            <a href="<?php echo e(route('userpage.profile')); ?>" class="top-btn" aria-label="Profile">
                <i class="fas fa-user-circle"></i>
            </a>

            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline" id="topbar-logout-form">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="top-btn" aria-label="Log out">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            <?php endif; ?>

            <button class="hamburger" id="hamburger" aria-label="Open navigation" aria-expanded="false" aria-controls="mobileOverlay">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    
    <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Navigation">
        <div class="mobile-backdrop" id="mobileBackdrop"></div>
        <nav class="mobile-panel">
            <div class="mobile-header">
                <div class="brand">
                    <span style="color:var(--purple);font-size:18px"><i class="fas fa-rocket"></i></span>
                    <span style="font-weight:700;font-size:15px">SkillUp</span>
                </div>
                <button class="mobile-close" id="mobileClose" aria-label="Close navigation">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <?php if(auth()->guard()->check()): ?>
                <div class="mobile-user">
                    <div class="mobile-avatar"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="mobile-user-name"><?php echo e(Auth::user()->name); ?></div>
                        <div class="mobile-user-email"><?php echo e(Auth::user()->email); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mobile-nav">
                <a href="<?php echo e(route('userpage.dashboard')); ?>"><i class="fas fa-th-large" style="width:18px;color:var(--purple)"></i> Dashboard</a>
                <a href="<?php echo e(route('userpage.profile')); ?>"><i class="fas fa-user-circle" style="width:18px;color:var(--purple)"></i> Profile</a>
                <a href="<?php echo e(route('courses.index')); ?>"><i class="fas fa-book-open" style="width:18px;color:var(--purple)"></i> Courses</a>
                <a href="<?php echo e(route('chats.index')); ?>"><i class="fas fa-comment-alt" style="width:18px;color:var(--purple)"></i> Messages</a>
                <a href="<?php echo e(route('notifications.index')); ?>"><i class="fas fa-bell" style="width:18px;color:var(--purple)"></i> Notifications</a>
                <div class="mobile-divider"></div>
                <?php if(auth()->guard()->check()): ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" id="mobile-logout-form">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="mobile-logout" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;font-size:13px;font-weight:500;color:var(--red);width:100%;background:none;border:0;text-align:left;cursor:pointer;transition:background var(--trans)">
                            <i class="fas fa-sign-out-alt" style="width:18px"></i> Log out
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </nav>
    </div>

    <div class="main-wrap">
        
        <aside class="sidebar" aria-label="Dashboard navigation">

            
            <div class="streak-widget">
                <div class="streak-label">Learning Streak</div>
                <div class="streak-value">
                    <span class="streak-fire">🔥</span>
                    <span class="streak-num">27</span>
                    <span class="streak-unit">days</span>
                </div>
            </div>

            <div class="sb-label">Learn</div>
            <nav class="sb-nav">
                <a href="<?php echo e(route('userpage.dashboard')); ?>"
                   class="sb-link <?php echo e(request()->routeIs('userpage.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-th-large sb-icon"></i> Dashboard
                </a>
                <a href="<?php echo e(route('courses.index')); ?>"
                   class="sb-link <?php echo e(request()->routeIs('courses.*') ? 'active' : ''); ?>">
                    <i class="fas fa-book-open sb-icon"></i> My Courses
                </a>
                <a href="#"
                   class="sb-link">
                    <i class="fas fa-graduation-cap sb-icon"></i> Enrollments
                </a>
                <a href="<?php echo e(route('badges.index')); ?>"
                   class="sb-link <?php echo e(request()->routeIs('badges.*') ? 'active' : ''); ?>">
                    <i class="fas fa-award sb-icon"></i> Badges
                </a>
                <a href="<?php echo e(route('certificates.index')); ?>"
                   class="sb-link <?php echo e(request()->routeIs('certificates.*') ? 'active' : ''); ?>">
                    <i class="fas fa-certificate sb-icon"></i> Certificates
                </a>
            </nav>

            <div class="sb-label">Account</div>
            <nav class="sb-nav">
                <a href="<?php echo e(route('userpage.profile')); ?>"
                   class="sb-link <?php echo e(request()->routeIs('userpage.profile*') ? 'active' : ''); ?>">
                    <i class="fas fa-user sb-icon"></i> My Profile
                </a>
                <a href="<?php echo e(route('chats.index')); ?>"
                   class="sb-link <?php echo e(request()->routeIs('chats.*') ? 'active' : ''); ?>">
                    <i class="fas fa-comment-alt sb-icon"></i> Messages
                    <span id="sidebar-unread-badge" class="sb-badge hidden" aria-live="polite"></span>
                </a>
                <a href="#" class="sb-link">
                    <i class="fas fa-cog sb-icon"></i> Settings
                </a>
            </nav>

            
            <div class="sb-bottom">
                <div class="sb-support">
                    <p>Need help?</p>
                    <a href="#"><i class="fas fa-question-circle" style="margin-right:5px"></i>Contact Support</a>
                </div>
                <?php if(auth()->guard()->check()): ?>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" id="sidebar-logout-form">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="sb-logout">
                            <i class="fas fa-sign-out-alt"></i> Log out
                        </button>
                    </form>
                <?php endif; ?>
            </div>

        </aside>

        
        <main class="main-content">
            <div class="main-inner">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

        
        <footer class="footer">
            <div class="footer-inner">
                <span>&copy; <?php echo e(date('Y')); ?> SkillUp. All rights reserved.</span>
                <div class="footer-socials">
                    <a href="https://x.com"         target="_blank" rel="noopener noreferrer" aria-label="X / Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://linkedin.com"   target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="https://instagram.com"  target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://facebook.com"   target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </footer>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
    (function () {
        'use strict';

        /* ── Mobile slide-over ──────────────────────────────────── */
        var hamburger   = document.getElementById('hamburger');
        var overlay     = document.getElementById('mobileOverlay');
        var backdrop    = document.getElementById('mobileBackdrop');
        var closeBtn    = document.getElementById('mobileClose');

        function openMobile() {
            overlay.classList.add('visible');
            overlay.setAttribute('aria-hidden', 'false');
            hamburger.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }
        function closeMobile() {
            overlay.classList.remove('visible');
            overlay.setAttribute('aria-hidden', 'true');
            hamburger.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        if (hamburger) hamburger.addEventListener('click', openMobile);
        if (closeBtn)  closeBtn.addEventListener('click', closeMobile);
        if (backdrop)  backdrop.addEventListener('click', closeMobile);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMobile();
        });

        /* ── Stagger sidebar links ──────────────────────────────── */
        document.querySelectorAll('.sb-link, .sb-logout').forEach(function (el, i) {
            el.style.animationDelay = (0.04 + i * 0.04) + 's';
            el.style.animation = 'slideRight .28s both';
        });

        /* ── Notification polling ───────────────────────────────── */
        function fetchNotifications() {
            <?php if(auth()->guard()->check()): ?>
            fetch('<?php echo e(route("chats.notifications")); ?>')
                .then(function (r) { return r.ok ? r.json() : Promise.reject(); })
                .then(function (data) {
                    var badge = document.getElementById('sidebar-unread-badge');
                    if (badge) {
                        if (data.unread > 0) {
                            badge.textContent = data.unread;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                })
                .catch(function () {});
            <?php endif; ?>
        }

        fetchNotifications();
        setInterval(fetchNotifications, 10000);

    })();
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/layout/User/app.blade.php ENDPATH**/ ?>