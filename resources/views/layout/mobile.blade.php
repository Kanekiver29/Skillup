<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkillUp')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: transform 0.25s, box-shadow 0.25s; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50">
    <!-- Mobile Header -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow z-50">
        <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fas fa-rocket text-purple-600 text-xl"></i>
                <a href="/" class="font-semibold text-lg text-gray-800">SkillUp</a>
            </div>
            <div class="flex items-center space-x-3">
                @auth
                    <a href="/dashboard" class="text-gray-700">Dashboard</a>
                @endauth
                <a href="/courses" class="text-gray-700">Courses</a>
                <button id="mobile-menu-toggle" aria-label="Open menu" aria-controls="mobile-slide" aria-expanded="false" class="text-gray-700 mobile-action">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Simplified Mobile Nav (slide-over) -->
    <div id="mobile-slide" class="fixed inset-0 z-40 hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-black/30 ms-backdrop" id="mobile-slide-backdrop" tabindex="-1"></div>
        <nav id="mobile-slide-panel" class="absolute left-0 top-0 bottom-0 w-64 bg-white p-4 overflow-auto ms-panel" role="navigation" aria-label="Mobile main navigation">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-rocket text-purple-600 text-xl"></i>
                    <a href="/" class="font-semibold text-gray-800">SkillUp</a>
                </div>
                <button id="mobile-slide-close" class="text-gray-700 mobile-action" aria-label="Close menu"><i class="fas fa-times" aria-hidden="true"></i></button>
            </div>
            <ul class="space-y-2" id="mobile-slide-links">
                <li><a href="/" class="block py-2 text-gray-700">Home</a></li>
                <li><a href="/courses" class="block py-2 text-gray-700">Courses</a></li>
                <li><a href="/about" class="block py-2 text-gray-700">About</a></li>
                <li><a href="/contact" class="block py-2 text-gray-700">Contact</a></li>
                @guest
                    <li><a href="/login" class="block py-2 text-gray-700">Login</a></li>
                    <li><a href="/register" class="block py-2 text-gray-700">Sign Up</a></li>
                @endguest
                @auth
                    <li><a href="/dashboard" class="block py-2 text-gray-700">Dashboard</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 text-gray-700">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </nav>
    </div>

    <main class="pt-16 px-4">
        <div class="max-w-3xl mx-auto">
            @yield('content')
        </div>
    </main>

    <footer class="mt-12 bg-gray-800 text-gray-300 py-6 px-4">
        <div class="max-w-3xl mx-auto text-center text-sm">
            &copy; 2026 SkillUp. All rights reserved.
        </div>
    </footer>

    <script>
        // Enhanced mobile slide toggle with ARIA and basic focus trap
        document.addEventListener('DOMContentLoaded', function(){
            const openBtn = document.getElementById('mobile-menu-toggle');
            const closeBtn = document.getElementById('mobile-slide-close');
            const container = document.getElementById('mobile-slide');
            const panel = document.getElementById('mobile-slide-panel');
            const backdrop = document.getElementById('mobile-slide-backdrop');
            const linksWrap = document.getElementById('mobile-slide-links');

            if(!container || !panel) return;

            const focusableSelector = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';

            function open(){
                container.classList.remove('hidden');
                container.classList.add('ms-open');
                container.setAttribute('aria-hidden','false');
                panel.setAttribute('aria-hidden','false');
                if(openBtn) openBtn.setAttribute('aria-expanded','true');
                // focus first link
                const first = panel.querySelector(focusableSelector);
                if(first) first.focus();
                document.body.style.overflow = 'hidden';
            }

            function close(){
                container.classList.add('hidden');
                container.classList.remove('ms-open');
                container.setAttribute('aria-hidden','true');
                panel.setAttribute('aria-hidden','true');
                if(openBtn) openBtn.setAttribute('aria-expanded','false');
                if(openBtn) openBtn.focus();
                document.body.style.overflow = '';
            }

            if(openBtn) openBtn.addEventListener('click', function(e){ e.preventDefault(); open(); });
            if(closeBtn) closeBtn.addEventListener('click', function(e){ e.preventDefault(); close(); });
            if(backdrop) backdrop.addEventListener('click', close);

            document.addEventListener('keydown', function(e){
                if(e.key === 'Escape') return close();
                if(e.key === 'Tab' && container.getAttribute('aria-hidden') === 'false'){
                    // basic focus trap
                    const focusable = Array.from(panel.querySelectorAll(focusableSelector)).filter(el => el.offsetParent !== null);
                    if(focusable.length === 0) return;
                    const first = focusable[0];
                    const last = focusable[focusable.length -1];
                    if(e.shiftKey && document.activeElement === first){ e.preventDefault(); last.focus(); }
                    else if(!e.shiftKey && document.activeElement === last){ e.preventDefault(); first.focus(); }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
