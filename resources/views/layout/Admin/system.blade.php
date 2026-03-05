<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - SkillUp')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Admin Theme Colors */
        .gradient-admin { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); }
        .gradient-admin-light { background: linear-gradient(135deg, #475569 0%, #64748b 100%); }
        
        /* Card Styles */
        .admin-card { transition: transform 0.3s, box-shadow 0.3s; }
        .admin-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        /* Sidebar Styles */
        .admin-sidebar-link { transition: all 0.2s ease; color: #07080b; border-left: 3px solid transparent; }
        .admin-sidebar-link:hover { color: #4b2828; border-left-color: #22d3ee; background: transparent; }
        .admin-sidebar-link.active { color: #22d3ee; border-left-color: #22d3ee; background: transparent; }
        
        /* Animations */
        .animate-fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(10px);} 
            to { opacity: 1; transform: translateY(0);} 
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
        
        /* Status indicators */
        .status-online { background-color: #22c55e; }
        .status-offline { background-color: #ef4444; }
        .status-away { background-color: #eab308; }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full gradient-admin z-50 shadow-lg">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-halved text-white text-xl"></i>
                    </div>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl text-white">SkillUp Admin</a>
                        <p class="text-xs text-gray-300">Management Console</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition text-sm">
                        <i class="fas fa-chart-line mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}" class="text-gray-300 hover:text-white transition text-sm">
                        <i class="fas fa-users mr-1"></i> Users
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white transition text-sm">
                        <i class="fas fa-book mr-1"></i> Courses
                    </a>
                </div>

                <!-- Right Side - Search & User Menu -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="bg-white/10 text-white placeholder-gray-400 px-4 py-2 rounded-lg text-sm w-64 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <i class="fas fa-search absolute right-3 top-2.5 text-gray-400"></i>
                    </div>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ notifyOpen: false }">
                        <button @click="notifyOpen = !notifyOpen" class="relative text-gray-300 hover:text-white transition">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">5</span>
                        </button>
                        <!-- Notifications Dropdown -->
                        <div x-show="notifyOpen" @click.away="notifyOpen = false" 
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl py-2 hidden z-50"
                             x-transition:enter="transition ease-out duration-200">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="font-semibold text-gray-700">Notifications</p>
                            </div>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                <p class="text-sm text-gray-700">New user registered</p>
                                <p class="text-xs text-gray-400">2 minutes ago</p>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                <p class="text-sm text-gray-700">Course enrollment updated</p>
                                <p class="text-xs text-gray-400">15 minutes ago</p>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                <p class="text-sm text-gray-700">System report generated</p>
                                <p class="text-xs text-gray-400">1 hour ago</p>
                            </a>
                        </div>
                    </div>

                    <!-- Admin User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-white transition">
                            <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-shield text-sm"></i>
                            </div>
                            <span class="hidden sm:inline">{{ Auth::check() ? Auth::user()->name : 'Admin' }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 hidden z-50"
                             x-transition:enter="transition ease-out duration-100">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="font-semibold text-gray-800">{{ Auth::check() ? Auth::user()->name : 'Admin' }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::check() ? Auth::user()->email : 'admin@skillup.com' }}</p>
                            </div>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-user-circle mr-2 text-cyan-600"></i> My Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-cog mr-2 text-cyan-600"></i> Settings
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-shield-alt mr-2 text-cyan-600"></i> Security
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

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden fixed top-16 left-0 w-full gradient-admin z-40 px-4 py-3 hidden">
        <div class="flex flex-col space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white py-2">
                <i class="fas fa-chart-line mr-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="text-gray-300 hover:text-white py-2">
                <i class="fas fa-users mr-2"></i> Users
            </a>
            <a href="{{ route('admin.courses.index') }}" class="text-gray-300 hover:text-white py-2">
                <i class="fas fa-book mr-2"></i> Courses
            </a>
            <a href="{{ route('admin.enrollments.index') }}" class="text-gray-300 hover:text-white py-2">
                <i class="fas fa-graduation-cap mr-2"></i> Enrollments
            </a>
            <a href="#" class="text-gray-300 hover:text-white py-2">
                <i class="fas fa-cog mr-2"></i> Settings
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 py-2">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="flex pt-16 min-h-screen">
        <!-- Sidebar -->
        <aside class="hidden md:flex flex-col w-64 bg-gradient-to-b from-slate-800 to-slate-900 min-h-screen fixed left-0 top-16 bottom-0">
            <div class="flex-1 py-6 overflow-y-auto">
                <!-- Quick Stats -->
                <div class="px-4 mb-6">
                    <div class="p-3 border-l-3 border-cyan-500">
                        <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">System Status</p>
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 rounded-full status-online"></div>
                            <span class="text-slate-300 text-sm">Online</span>
                        </div>
                    </div>
                </div>

                <!-- Main Menu -->
                <div class="px-4 mb-4">
                    <p class="text-slate-500 text-xs uppercase tracking-wider mb-2">Main Menu</p>
                </div>
                
                <nav class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-th-large w-5 mr-3"></i>
                            <span>Dashboard</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    
                    <a href="{{ route('admin.users') }}" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-users w-5 mr-3"></i>
                            <span>User Management</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    
                    <a href="{{ route('admin.admins') }}" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-user-shield w-5 mr-3"></i>
                            <span>Admin Accounts</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    
                    <a href="{{ route('admin.courses.index') }}" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-book-open w-5 mr-3"></i>
                            <span>Courses</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    
                    <a href="{{ route('admin.enrollments.index') }}" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm {{ request()->routeIs('admin.enrollments*') ? 'active' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-graduation-cap w-5 mr-3"></i>
                            <span>Enrollments</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                </nav>

                <!-- Management Section -->
                <div class="px-4 mb-4 mt-8">
                    <p class="text-slate-500 text-xs uppercase tracking-wider mb-3 font-semibold">Management</p>
                </div>
                
                <nav class="px-4 space-y-2">
                    <a href="{{ route('admin.reports') }}" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                        <span class="flex items-center">
                            <i class="fas fa-chart-bar w-5 mr-3"></i>
                            <span>Reports</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    
                    <a href="#" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-cog w-5 mr-3"></i>
                            <span>Settings</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    
                    <a href="#" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-database w-5 mr-3"></i>
                            <span>Database</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                    
                    <a href="#" class="admin-sidebar-link flex items-center justify-between px-3 py-2 text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-bug w-5 mr-3"></i>
                            <span>System Logs</span>
                        </span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </a>
                </nav>
            </div>

            <!-- Bottom Section -->
            <div class="p-4 border-t border-slate-700">
                <a href="#" class="flex items-center px-3 py-2 text-slate-300 hover:text-cyan-400 transition text-sm mb-3">
                    <i class="fas fa-question-circle w-5 mr-3"></i>
                    <span>Documentation</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 text-red-400 hover:text-red-300 transition text-sm border border-red-500/20 hover:border-red-500/40 rounded">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 md:ml-64 p-6">
            <div class="max-w-7xl mx-auto animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="md:ml-64 bg-slate-800 text-slate-400 py-6 px-6 mt-auto">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm">&copy; 2026 SkillUp Admin. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-slate-500 hover:text-white transition"><i class="fas fa-question-circle"></i> Help</a>
                    <a href="#" class="text-slate-500 hover:text-white transition"><i class="fas fa-shield-alt"></i> Privacy</a>
                    <a href="#" class="text-slate-500 hover:text-white transition"><i class="fas fa-file-alt"></i> Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    
    @stack('scripts')
</body>
</html>
