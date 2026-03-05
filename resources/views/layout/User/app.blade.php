<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkillUp - User Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .gradient-secondary { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .card-hover { transition: transform 0.3s, box-shadow 0.3s; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(0,0,0,0.12); }
        .sidebar-link { transition: all 0.3s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,0.15); transform: translateX(4px); }
        .sidebar-link.active { background: rgba(255,255,255,0.2); border-left: 4px solid white; }
        .animate-fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #a78bfa; }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full gradient-primary z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-6">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <i class="fas fa-rocket text-white text-2xl"></i>
                    <a href="{{ route('dashboard') }}" class="font-bold text-xl text-white">SkillUp</a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-white/80 hover:text-white transition">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ route('courses.index') }}" class="text-white/80 hover:text-white transition">
                        <i class="fas fa-book mr-1"></i> Courses
                    </a>
                </div>

                <!-- User Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative text-white/80 hover:text-white transition">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-white transition">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden"
                             x-transition:enter="transition ease-out duration-100">
                            <a href="{{ route('userpage.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50">
                                <i class="fas fa-user-circle mr-2 text-purple-600"></i> My Profile
                            </a>
                            <a href="{{ route('userpage.profile-edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50">
                                <i class="fas fa-cog mr-2 text-purple-600"></i> Settings
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Button -->
    <div class="md:hidden fixed top-16 left-0 w-full gradient-primary z-40 px-4 py-3">
        <div class="flex space-x-4 overflow-x-auto">
            <a href="{{ route('dashboard') }}" class="text-white/80 hover:text-white whitespace-nowrap">
                <i class="fas fa-home mr-1"></i> Home
            </a>
            <a href="{{ route('courses.index') }}" class="text-white/80 hover:text-white whitespace-nowrap">
                <i class="fas fa-book mr-1"></i> Courses
            </a>
            <a href="{{ route('userpage.profile') }}" class="text-white/80 hover:text-white whitespace-nowrap">
                <i class="fas fa-user mr-1"></i> Profile
            </a>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="flex pt-16 min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden md:flex flex-col w-64 bg-gradient-to-b from-purple-700 to-indigo-800 min-h-screen fixed left-0 top-16 bottom-0">
            <div class="flex-1 py-6">
                <!-- Quick Stats -->
                <div class="px-4 mb-6">
                    <div class="bg-white/10 rounded-lg p-4">
                        <p class="text-purple-200 text-xs uppercase tracking-wider mb-2">Learning Streak</p>
                        <div class="flex items-center">
                            <i class="fas fa-fire text-orange-400 text-2xl mr-2"></i>
                            <span class="text-2xl font-bold text-white">27</span>
                            <span class="text-purple-200 text-sm ml-1">days</span>
                        </div>
                    </div>
                </div>

                <!-- Menu Items -->
                <nav class="px-2 space-y-1">
                    <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large w-6"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('courses.index') }}" class="sidebar-link flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                        <i class="fas fa-book-open w-6"></i>
                        <span>My Courses</span>
                    </a>
                    
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-white rounded-lg">
                        <i class="fas fa-graduation-cap w-6"></i>
                        <span>Enrollments</span>
                    </a>
                    
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-white rounded-lg">
                        <i class="fas fa-certificate w-6"></i>
                        <span>Certificates</span>
                    </a>
                    
                    <a href="{{ route('userpage.profile') }}" class="sidebar-link flex items-center px-4 py-3 text-white rounded-lg {{ request()->routeIs('userpage.profile*') ? 'active' : '' }}">
                        <i class="fas fa-user w-6"></i>
                        <span>My Profile</span>
                    </a>
                    
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-white rounded-lg">
                        <i class="fas fa-comment-alt w-6"></i>
                        <span>Messages</span>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">5</span>
                    </a>
                    
                    <a href="#" class="sidebar-link flex items-center px-4 py-3 text-white rounded-lg">
                        <i class="fas fa-cog w-6"></i>
                        <span>Settings</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Section -->
            <div class="p-4 border-t border-white/10">
                <div class="bg-white/10 rounded-lg p-4 mb-4">
                    <p class="text-purple-200 text-xs mb-2">Need Help?</p>
                    <a href="#" class="text-white text-sm hover:text-purple-200 transition">
                        <i class="fas fa-question-circle mr-1"></i> Contact Support
                    </a>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-200 rounded-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-64 p-6">
            <div class="max-w-6xl mx-auto animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="md:ml-64 bg-gray-800 text-gray-300 py-8 px-6 mt-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm">&copy; 2026 SkillUp. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-x"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>

                    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
