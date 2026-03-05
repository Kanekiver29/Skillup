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
        .gradient-secondary { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .card-hover { transition: transform 0.3s, box-shadow 0.3s; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
        .animate-fade-in { animation: fadeIn 1s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50">
    <nav class="fixed w-full bg-white shadow-sm z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2 flex-shrink-0 w-auto">
                    <i class="fas fa-rocket text-purple-600 text-2xl"></i>
                    <a href="/" class="font-bold text-xl text-gray-800">SkillUp</a>
                </div>

                <!-- Desktop Navigation -->
                <!-- use flex-1 and justify-center so links stay centered between logo and auth section -->
                <div class="hidden md:flex flex-1 justify-center" id="primary-nav">
                    <div class="flex items-center space-x-8">
                        <a href="/" class="text-gray-600 hover:text-purple-600 text-sm">Home</a>
                        <a href="/about" class="text-gray-600 hover:text-purple-600 text-sm">About</a>
                        <a href="/courses" class="text-gray-600 hover:text-purple-600 text-sm">Courses</a>
                        <a href="/contact" class="text-gray-600 hover:text-purple-600 text-sm">Contact</a>
                    </div>
                </div>

                <!-- Auth Section -->
                <div class="flex items-center space-x-3 flex-shrink-0 w-auto">
                    @auth
                        <a href="/dashboard" class="hidden sm:inline text-gray-600 hover:text-purple-600 text-sm">Dashboard</a>
                        <span class="hidden lg:inline text-gray-600 text-sm">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-purple-600 text-sm">Logout</button>
                        </form>
                    @endauth
                    @guest
                        <a href="/login" class="text-gray-600 hover:text-purple-600 text-sm">Login</a>
                        <a href="/register" class="gradient-primary px-3 py-2 rounded text-white text-sm">Sign Up</a>
                    @endguest
                </div>

                <!-- Mobile Menu Toggle -->
                <button id="nav-toggle" class="md:hidden text-gray-600 hover:text-purple-600 ml-2">
                    <i id="nav-open-icon" class="fas fa-bars text-xl"></i>
                    <i id="nav-close-icon" class="fas fa-times text-xl hidden"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile menu (hidden by default) -->
    <div id="mobile-nav" class="md:hidden hidden bg-white border-b shadow-sm">
        <div class="px-4 pt-4 pb-4 space-y-2">
            <a href="/" class="block text-gray-700 py-2">Home</a>
            <a href="/about" class="block text-gray-700 py-2">About</a>
            <a href="/courses" class="block text-gray-700 py-2">Courses</a>
            <a href="/contact" class="block text-gray-700 py-2">Contact</a>
            @auth
                <a href="/dashboard" class="block text-gray-700 py-2">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left text-gray-700 py-2">Logout</button>
                </form>
            @endauth
            @guest
                <a href="/login" class="block text-gray-700 py-2">Login</a>
                <a href="/register" class="block text-gray-700 py-2">Sign Up</a>
            @endguest
        </div>
    </div>

    <main class="pt-20">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-gray-300 py-12 px-4 mt-12">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="font-bold text-white mb-4">SkillUp</h4>
                    <p class="text-sm">Empowering youth through personalized learning for career success.</p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Product</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white">Features</a></li>
                        <li><a href="#" class="hover:text-white">Learning Paths</a></li>
                        <li><a href="#" class="hover:text-white">Mentors</a></li>
                        <li><a href="#" class="hover:text-white">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Company</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Legal</h4>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                        <li><a href="#" class="hover:text-white">Terms</a></li>
                        <li><a href="#" class="hover:text-white">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm">&copy; 2026 SkillUp. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-x"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
