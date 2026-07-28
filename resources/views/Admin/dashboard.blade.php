@extends('layout.Admin.system')

@section('title', 'Admin Dashboard - SkillUp')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<style>
    [x-cloak] { display: none; }

    /* ============ Glass surfaces (previously referenced but undefined) ============ */
    .glass-card {
        background: linear-gradient(160deg, rgba(31, 41, 55, 0.9), rgba(17, 24, 39, 0.9));
        backdrop-filter: blur(6px);
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .glass-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 40px -20px rgba(6, 182, 212, 0.35);
    }
    .glass-button {
        display: block;
        border-radius: 0.65rem;
        background: rgba(55, 65, 81, 0.5);
        border: 1px solid rgba(75, 85, 99, 0.6);
        transition: transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .glass-button:hover {
        background: rgba(75, 85, 99, 0.75);
        border-color: rgba(34, 211, 238, 0.4);
        transform: translateX(3px);
        box-shadow: 0 10px 24px -14px rgba(34, 211, 238, 0.4);
    }

    /* ============ Entrance animations ============ */
    @keyframes adminFadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes adminFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes adminPulseDot {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.55); }
        70% { box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
    }
    @keyframes adminPulseDotError {
        0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.55); }
        70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
    }
    @keyframes adminFlash {
        0% { color: #22d3ee; transform: scale(1.08); }
        100% { color: inherit; transform: scale(1); }
    }

    [data-admin-animate] { animation: adminFadeInUp 0.5s ease-out both; }
    .admin-stagger { opacity: 0; animation: adminFadeInUp 0.5s ease-out both; }
    .admin-stagger:nth-child(1) { animation-delay: 0.05s; }
    .admin-stagger:nth-child(2) { animation-delay: 0.1s; }
    .admin-stagger:nth-child(3) { animation-delay: 0.15s; }
    .admin-stagger:nth-child(4) { animation-delay: 0.2s; }

    .admin-live-dot { animation: adminPulseDot 1.8s ease-out infinite; }
    .admin-live-dot.is-error { background-color: #ef4444 !important; animation: adminPulseDotError 1.8s ease-out infinite; }

    .live-counter.is-flashing { animation: adminFlash 0.6s ease-out; }

    .admin-search-input {
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .admin-search-input:focus {
        outline: none;
        border-color: #22d3ee;
        box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.18);
    }

    .admin-row-hidden { display: none !important; }

    .admin-empty-search {
        animation: adminFadeIn 0.3s ease-out both;
    }

    .admin-period-btn { transition: background-color 0.2s ease, color 0.2s ease, transform 0.15s ease; }
    .admin-period-btn:active { transform: scale(0.94); }

    /* Mobile Responsive Design */
    @media (max-width: 640px) {
        .text-4xl {
            font-size: 1.875rem !important;
            line-height: 2.25rem !important;
        }
        
        .text-3xl {
            font-size: 1.5rem !important;
            line-height: 2rem !important;
        }
        
        .px-4 {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        .grid {
            gap: 0.75rem !important;
        }
        
        .border-b {
            padding-bottom: 1rem !important;
            margin-bottom: 1rem !important;
        }
        
        .flex.items-center.justify-between {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem !important;
        }
        
        .text-right {
            text-align: left !important;
            width: 100% !important;
        }
        
        .min-h-screen {
            min-height: auto !important;
        }
        
        /* Chart responsive height on mobile */
        .h-80 {
            height: 200px !important;
        }
        
        .h-48 {
            height: 150px !important;
        }
        
        /* Card padding adjustments */
        .rounded-xl.p-6 {
            padding: 1rem !important;
        }
        
        /* Stat card grid - single column on mobile */
        .grid.grid-cols-1.md\:grid-cols-4 {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }
        
        .grid.grid-cols-1.lg\:grid-cols-3 {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }
        
        .grid.grid-cols-1.md\:grid-cols-3 {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }
        
        /* Space adjustments */
        .space-y-4 > * + * {
            margin-top: 0.5rem !important;
        }
        
        .space-y-6 > * + * {
            margin-top: 1rem !important;
        }
        
        /* Font size adjustments */
        .text-xl {
            font-size: 1.125rem !important;
        }
        
        .text-sm {
            font-size: 0.875rem !important;
        }
        
        /* Button and link adjustments */
        .block.p-3 {
            padding: 0.75rem !important;
        }
    }
    
    /* Tablet Responsive Design */
    @media (min-width: 641px) and (max-width: 1024px) {
        .px-4.sm\:px-6.lg\:px-8 {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
        
        .text-4xl {
            font-size: 2rem !important;
        }
        
        .h-80 {
            height: 250px !important;
        }
        
        /* Adjust grid columns for tablet */
        .lg\:col-span-2 {
            grid-column: 1 / -1 !important;
        }
        
        .lg\:col-span-3 {
            grid-template-columns: 1fr !important;
        }
        
        /* Stat cards in 2 columns on tablet */
        .grid.grid-cols-1.md\:grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
        
        .grid.grid-cols-1.md\:grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
    }
    
    /* Desktop and Large Screens */
    @media (min-width: 1025px) {
        .h-80 {
            height: 320px !important;
        }
        
        .h-48 {
            height: 192px !important;
        }
        
        /* Ensure proper max-width on desktop */
        .max-w-7xl {
            max-width: 80rem !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    }
    
    /* General responsive improvements */
    @media (max-width: 768px) {
        /* Hide non-essential elements on mobile */
        .hidden-mobile {
            display: none !important;
        }
        
        /* Full width cards */
        .rounded-xl {
            border-radius: 0.5rem !important;
        }
    }
    
    /* Scrollable table on mobile */
    @media (max-width: 640px) {
        .divide-y.divide-gray-700 {
            overflow-x: auto !important;
        }
        
        .w-10.h-10 {
            width: 2rem !important;
            height: 2rem !important;
        }
        
        .truncate {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }
    }
    
    /* Responsive spacing utilities */
    @media (max-width: 640px) {
        .gap-6 {
            gap: 1rem !important;
        }
        
        .gap-4 {
            gap: 0.75rem !important;
        }
        
        .gap-3 {
            gap: 0.5rem !important;
        }
    }
    
    /* Live status badge responsive */
    @media (max-width: 640px) {
        .inline-flex.items-center.gap-2 {
            font-size: 0.75rem !important;
            padding: 0.5rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-900" x-data="dashboardData()" x-init="init()" x-cloak>

    <!-- Header Section with Welcome & Quick Stats -->
    <div data-admin-animate class="border-b border-gray-700 pb-6 mb-8 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/5 via-transparent to-blue-500/5 pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 relative">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-2">
                <div>
                    <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-cyan-400/90 mb-2">
                        <i class="fas fa-shield-halved"></i> Admin control center
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">Dashboard</h1>
                    <p class="text-gray-400 text-sm sm:text-base">Welcome back, <span class="text-cyan-400 font-semibold">{{ auth()->user()->name }}</span></p>
                </div>
                <div class="text-left sm:text-right">
                    <div class="inline-flex items-center gap-2 bg-gray-800/80 backdrop-blur px-3 sm:px-4 py-2 rounded-xl border border-gray-700/80 shadow-lg transition hover:border-cyan-500/30">
                        <div class="h-2 w-2 bg-green-500 rounded-full admin-live-dot" :class="{ 'is-error': liveStatus === 'error' }"></div>
                        <span class="text-xs sm:text-sm text-gray-300" x-text="liveStatus === 'error' ? 'Reconnecting…' : 'Live dashboard'"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Last updated <span class="font-semibold text-cyan-400/90" x-text="lastUpdatedText">just now</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8 sm:pb-12">
        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
            <!-- Main Activity Chart (2/3 width) -->
            <div class="admin-stagger lg:col-span-2 bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-6">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Activity Overview</h2>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1" id="chart-period-text">Daily enrollment metrics (last 7 days)</p>
                    </div>
                    <div class="flex gap-2 sm:gap-3">
                        <button type="button" @click="changePeriod('daily')" :class="period === 'daily' ? 'bg-cyan-600 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300'" class="admin-period-btn px-2 sm:px-3 py-1 text-xs rounded-lg transition">Day</button>
                        <button type="button" @click="changePeriod('weekly')" :class="period === 'weekly' ? 'bg-cyan-600 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300'" class="admin-period-btn px-2 sm:px-3 py-1 text-xs rounded-lg transition">Week</button>
                        <button type="button" @click="changePeriod('monthly')" :class="period === 'monthly' ? 'bg-cyan-600 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300'" class="admin-period-btn px-2 sm:px-3 py-1 text-xs rounded-lg transition">Month</button>
                        <button type="button" @click="changePeriod('yearly')" :class="period === 'yearly' ? 'bg-cyan-600 text-white' : 'bg-gray-700 hover:bg-gray-600 text-gray-300'" class="admin-period-btn px-2 sm:px-3 py-1 text-xs rounded-lg transition">Year</button>
                    </div>
                </div>
                <div class="h-48 sm:h-80">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <!-- Donut Chart (1/3 width) -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Active Students</h2>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">Distribution overview</p>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block h-2 w-2 rounded-full bg-green-500 admin-live-dot" :class="{ 'is-error': liveStatus === 'error' }"></span>
                        <span class="text-xs text-gray-400 ml-2">Live</span>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center h-48 sm:h-80">
                    <canvas id="donutChart" class="max-h-full"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-between text-xs sm:text-sm">
                        <span class="text-gray-400 flex items-center"><span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>Series 1</span>
                        <span class="text-white font-semibold live-counter">58</span>
                    </div>
                    <div class="flex items-center justify-between text-xs sm:text-sm">
                        <span class="text-gray-400 flex items-center"><span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>Series 2</span>
                        <span class="text-white font-semibold live-counter">42</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Charts Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
            <!-- Students by Level -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-bold text-white mb-6">Students by Level</h3>
                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs sm:text-sm text-gray-400">Undergraduate</span>
                            <span class="text-xs sm:text-sm font-semibold text-white">42%</span>
                        </div>
                        <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-700" style="width: 42%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs sm:text-sm text-gray-400">Masters</span>
                            <span class="text-xs sm:text-sm font-semibold text-white">35%</span>
                        </div>
                        <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 transition-all duration-700" style="width: 35%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs sm:text-sm text-gray-400">Doctoral</span>
                            <span class="text-xs sm:text-sm font-semibold text-white">15%</span>
                        </div>
                        <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-pink-500 to-pink-600 transition-all duration-700" style="width: 15%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs sm:text-sm text-gray-400">Post-Bac</span>
                            <span class="text-xs sm:text-sm font-semibold text-white">8%</span>
                        </div>
                        <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-500 to-green-600 transition-all duration-700" style="width: 8%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students by College -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-bold text-white mb-6">Students by College</h3>
                <div class="h-48 sm:h-80">
                    <canvas id="collegeChart"></canvas>
                </div>
            </div>

            <!-- Active Enrollment Stats -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-bold text-white mb-6">Active Engagement</h3>
                <div class="space-y-4 sm:space-y-6">
                    <div>
                        <p class="text-gray-400 text-xs sm:text-sm mb-2">Daily (Avg)</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white live-counter" id="sum-daily">1.08K</p>
                        <p class="text-xs text-green-400 mt-1">↑ 1.03%</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs sm:text-sm mb-2">Weekly (Avg)</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white live-counter" id="sum-weekly">3.20K</p>
                        <p class="text-xs text-red-400 mt-1">↓ 1.63%</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs sm:text-sm mb-2">Monthly (Avg)</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white live-counter" id="sum-monthly">8.18K</p>
                        <p class="text-xs text-green-400 mt-1">↑ 4.33%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
            <!-- Total Users Card -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6 hover:border-cyan-600 transition glass-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs sm:text-sm font-medium text-gray-400">Total Users</h3>
                    <div class="p-2 sm:p-3 bg-blue-600 rounded-lg">
                        <i class="fas fa-users text-white text-sm sm:text-lg"></i>
                    </div>
                </div>
                <div class="text-2xl sm:text-3xl font-bold text-white live-counter" id="counter-total" data-count-target="{{ (int) $userCount }}">{{ $userCount }}</div>
                <p class="text-xs text-gray-500 mt-2">Active user accounts</p>
                @if(isset($newSignupsToday))
                    <p class="text-xs text-gray-500 mt-1">New today: <span class="font-semibold text-green-400">+{{ $newSignupsToday }}</span></p>
                @endif
            </div>

            <!-- Active Courses Card -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6 hover:border-cyan-600 transition glass-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs sm:text-sm font-medium text-gray-400">Active Courses</h3>
                    <div class="p-2 sm:p-3 bg-purple-600 rounded-lg">
                        <i class="fas fa-book text-white text-sm sm:text-lg"></i>
                    </div>
                </div>
                <div class="text-2xl sm:text-3xl font-bold text-white live-counter" id="counter-courses" data-count-target="{{ (int) $activeCourses }}">{{ $activeCourses }}</div>
                <p class="text-xs text-gray-500 mt-2">Courses available</p>
            </div>

            <!-- Total Enrollments Card -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6 hover:border-cyan-600 transition glass-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs sm:text-sm font-medium text-gray-400">Enrollments</h3>
                    <div class="p-2 sm:p-3 bg-yellow-600 rounded-lg">
                        <i class="fas fa-user-graduate text-white text-sm sm:text-lg"></i>
                    </div>
                </div>
                <div class="text-2xl sm:text-3xl font-bold text-white live-counter" id="counter-enrolled" data-count-target="{{ (int) $enrollmentCount }}">{{ $enrollmentCount }}</div>
                <p class="text-xs text-gray-500 mt-2">Total course enrollments</p>
            </div>

            <!-- Achievements Card -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6 hover:border-cyan-600 transition glass-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs sm:text-sm font-medium text-gray-400">Achievements</h3>
                    <div class="p-2 sm:p-3 bg-pink-600 rounded-lg">
                        <i class="fas fa-trophy text-white text-sm sm:text-lg"></i>
                    </div>
                </div>
                <div class="text-2xl sm:text-3xl font-bold text-white live-counter" id="counter-badges" data-count-target="{{ (int) $badges }}">{{ $badges }}</div>
                <p class="text-xs text-gray-500 mt-2">Total badges issued</p>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Recent Signups -->
            <div class="admin-stagger lg:col-span-2 bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <h3 class="text-base sm:text-lg font-bold text-white flex items-center">
                            <i class="fas fa-user-check text-cyan-400 mr-3"></i>
                            Recent Signups
                        </h3>
                        <div class="relative">
                            <input type="text" id="signup-search" placeholder="Search name or email…"
                                   class="admin-search-input w-full sm:w-56 bg-gray-900/70 border border-gray-700 rounded-lg pl-8 pr-3 py-1.5 text-xs sm:text-sm text-gray-200 placeholder-gray-500">
                            <i class="fas fa-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-700" id="signup-list">
                    @forelse($recentUsers as $user)
                        <div class="p-3 sm:p-4 hover:bg-gray-700/50 transition-colors" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                            <div class="flex items-center space-x-2 sm:space-x-4">
                                @if($user->profile_image)
                                    <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}"
                                         alt="{{ $user->name }}"
                                         class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border border-gray-600 flex-shrink-0">
                                @else
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-400 flex items-center justify-center text-white text-xs sm:text-sm font-bold border border-gray-600 flex-shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs sm:text-sm font-medium text-white truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            No recent signups
                        </div>
                    @endforelse
                    <div id="signup-no-results" class="admin-empty-search hidden p-4 text-center text-gray-500 text-sm">
                        No signups match your search.
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-stagger bg-gray-800 rounded-lg sm:rounded-xl border border-gray-700 p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-bold text-white mb-4 flex items-center">
                    <i class="fas fa-lightning-bolt text-yellow-400 mr-2"></i>
                    Quick Actions
                </h3>
                <div class="space-y-2 sm:space-y-3">
                    <a href="{{ route('admin.users.index') }}"
                       class="glass-button p-2 sm:p-3 text-xs sm:text-sm text-gray-200 font-medium">
                        <i class="fas fa-users mr-2 text-blue-400"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.courses.index') }}"
                       class="glass-button p-2 sm:p-3 text-xs sm:text-sm text-gray-200 font-medium">
                        <i class="fas fa-book mr-2 text-purple-400"></i>Manage Courses
                    </a>
                    <a href="{{ route('admin.enrollments.index') }}"
                       class="glass-button p-2 sm:p-3 text-xs sm:text-sm text-gray-200 font-medium">
                        <i class="fas fa-user-graduate mr-2 text-yellow-400"></i>View Enrollments
                    </a>
                    <a href="{{ route('admin.staff.index') }}"
                       class="glass-button p-2 sm:p-3 text-xs sm:text-sm text-gray-200 font-medium">
                        <i class="fas fa-user-tie mr-2 text-pink-400"></i>Staff Admin
                    </a>
                </div>

                <div class="mt-5 pt-5 border-t border-gray-700">
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">System status</h4>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400">Realtime sync</span>
                        <span class="inline-flex items-center gap-1.5 font-semibold"
                              :class="liveStatus === 'error' ? 'text-red-400' : 'text-green-400'">
                            <span class="h-1.5 w-1.5 rounded-full admin-live-dot" :class="{ 'is-error': liveStatus === 'error' }"></span>
                            <span x-text="liveStatus === 'error' ? 'Degraded' : 'Operational'"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Initialization Script with Real-time Updates -->
<script>
function dashboardData() {
    return {
        period: 'daily',
        livePolling: null,
        pollInterval: 10000, // 10 seconds
        liveStatus: 'connected',
        lastUpdatedText: 'just now',
        activityChart: null,
        donutChart: null,
        collegeChart: null,
        chartData: {
            daily: { labels: @json($dailyLabels ?? []), data: @json($dailyData ?? []) },
            weekly: { labels: @json($weeklyLabels ?? []), data: @json($weeklyData ?? []) },
            monthly: { labels: @json($monthlyLabels ?? []), data: @json($monthlyData ?? []) },
            yearly: { labels: @json($yearlyLabels ?? []), data: @json($yearlyData ?? []) }
        },
        periodTexts: {
            daily: 'Daily enrollment metrics (last 7 days)',
            weekly: 'Weekly enrollment metrics (last 4 weeks)',
            monthly: 'Monthly enrollment metrics (last 6 months)',
            yearly: 'Yearly enrollment metrics (last 4 years)'
        },
        
        init() {
            this.initCharts();
            this.animateCounters();
            this.startLivePolling();
            this.initSignupSearch();
            this.tickRelativeTime();
        },

        animateCounters() {
            document.querySelectorAll('[data-count-target]').forEach((el) => {
                const target = parseInt(el.getAttribute('data-count-target'), 10);
                if (isNaN(target)) return;

                const duration = 900;
                const start = performance.now();

                const step = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(eased * target).toLocaleString();
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        el.textContent = target.toLocaleString();
                    }
                };

                requestAnimationFrame(step);
            });
        },

        initSignupSearch() {
            const input = document.getElementById('signup-search');
            const list = document.getElementById('signup-list');
            const noResults = document.getElementById('signup-no-results');
            if (!input || !list) return;

            input.addEventListener('input', () => {
                const query = input.value.trim().toLowerCase();
                const rows = list.querySelectorAll('[data-search]');
                let visibleCount = 0;

                rows.forEach((row) => {
                    const matches = !query || row.getAttribute('data-search').includes(query);
                    row.classList.toggle('admin-row-hidden', !matches);
                    if (matches) visibleCount += 1;
                });

                if (noResults) {
                    noResults.classList.toggle('hidden', visibleCount !== 0 || rows.length === 0);
                }
            });
        },

        tickRelativeTime() {
            let secondsAgo = 0;
            setInterval(() => {
                secondsAgo += 1;
                if (secondsAgo < 60) {
                    this.lastUpdatedText = secondsAgo <= 2 ? 'just now' : `${secondsAgo}s ago`;
                } else {
                    this.lastUpdatedText = `${Math.floor(secondsAgo / 60)}m ago`;
                }
            }, 1000);

            // Reset the relative clock whenever fresh data actually arrives
            this._resetClock = () => { secondsAgo = 0; };
        },

        initActivityChart() {
            const activityCtx = document.getElementById('activityChart');
            if (!activityCtx) return null;
            
            const currentData = this.chartData[this.period];
            return new Chart(activityCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: currentData.labels,
                    datasets: [{
                        label: 'Enrollments',
                        data: currentData.data,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 700, easing: 'easeOutQuart' },
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.1)', drawBorder: false },
                            ticks: { color: '#9CA3AF' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9CA3AF' }
                        }
                    }
                }
            });
        },
        
        initCharts() {
            this.activityChart = this.initActivityChart();
            this.donutChart = this.initDonutChart();
            this.collegeChart = this.initCollegeChart();
        },

        changePeriod(newPeriod) {
            this.period = newPeriod;
            this.updateChart(newPeriod);
            
            // Update subtitle
            const subtitle = document.getElementById('chart-period-text');
            if (subtitle) {
                subtitle.textContent = this.periodTexts[newPeriod] || 'Enrollment metrics';
            }
        },
        
        updateChart(period) {
            if (!this.activityChart || !this.chartData[period]) return;
            
            const newData = this.chartData[period];
            this.activityChart.data.labels = newData.labels;
            this.activityChart.data.datasets[0].data = newData.data;
            this.activityChart.update();
        },
        
        initDonutChart() {
            const donutCtx = document.getElementById('donutChart');
            if (!donutCtx) return null;
            
            return new Chart(donutCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Inactive'],
                    datasets: [{
                        data: [58, 42],
                        backgroundColor: ['rgba(59, 130, 246, 0.8)', 'rgba(168, 85, 247, 0.8)'],
                        borderColor: ['rgba(59, 130, 246, 1)', 'rgba(168, 85, 247, 1)'],
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { animateRotate: true, duration: 800 },
                    plugins: { legend: { display: false } }
                }
            });
        },
        
        initCollegeChart() {
            const collegeCtx = document.getElementById('collegeChart');
            if (!collegeCtx) return null;

            return new Chart(collegeCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($collegeLabels ?? ['Business', 'Sciences', 'Arts', 'Architecture']) !!},
                    datasets: [{
                        data: {!! json_encode($collegeData ?? [120, 150, 90, 110]) !!},
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(168, 85, 247, 0.8)',
                            'rgba(236, 72, 153, 0.8)',
                            'rgba(34, 197, 94, 0.8)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(168, 85, 247, 1)',
                            'rgba(236, 72, 153, 1)',
                            'rgba(34, 197, 94, 1)'
                        ],
                        borderWidth: 2,
                        hoverOffset: 12,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { animateRotate: true, duration: 800 },
                    layout: {
                        padding: { top: 10, bottom: 10, left: 6, right: 6 }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            align: 'center',
                            labels: {
                                color: '#D1D5DB',
                                padding: 14,
                                boxWidth: 14,
                                font: { size: 12 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const value = context.parsed;
                                    return `${context.label}: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            });
        },
        
        startLivePolling() {
            this.fetchLiveData();
            this.livePolling = setInterval(() => this.fetchLiveData(), this.pollInterval);
        },

        flashCounter(el) {
            if (!el) return;
            el.classList.remove('is-flashing');
            // force reflow so the animation can restart
            void el.offsetWidth;
            el.classList.add('is-flashing');
        },
        
        fetchLiveData() {
            fetch(@json(route('admin.dashboard.liveData')), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(r => r.json())
            .then(json => {
                this.liveStatus = 'connected';
                if (this._resetClock) this._resetClock();

                // Update counters
                const counterTotal = document.getElementById('counter-total');
                const counterEnrolled = document.getElementById('counter-enrolled');
                const counterCourses = document.getElementById('counter-courses');
                const counterBadges = document.getElementById('counter-badges');

                const applyIfChanged = (el, newValue) => {
                    if (!el || newValue === undefined || newValue === null) return;
                    const formatted = String(newValue);
                    if (el.textContent.replace(/,/g, '') !== formatted.replace(/,/g, '')) {
                        el.textContent = formatted;
                        this.flashCounter(el);
                    }
                };

                applyIfChanged(counterTotal, json.counters?.totalStudents ?? json.counters?.total);
                applyIfChanged(counterEnrolled, json.counters?.enrolledToday ?? json.counters?.enrolled);
                applyIfChanged(counterCourses, json.counters?.activeCourses ?? json.counters?.courses);
                applyIfChanged(counterBadges, json.counters?.badges);
                
                // Update summary numbers
                const sum = (arr) => Array.isArray(arr) ? arr.reduce((a, b) => a + b, 0) : 0;
                const sumDaily = document.getElementById('sum-daily');
                const sumWeekly = document.getElementById('sum-weekly');
                const sumMonthly = document.getElementById('sum-monthly');
                
                if (sumDaily && json.chart?.daily?.data) applyIfChanged(sumDaily, sum(json.chart.daily.data));
                if (sumWeekly && json.chart?.weekly?.data) applyIfChanged(sumWeekly, sum(json.chart.weekly.data));
                if (sumMonthly && json.chart?.monthly?.data) applyIfChanged(sumMonthly, sum(json.chart.monthly.data));

                if (this.collegeChart && json.chart?.college?.labels && json.chart?.college?.data) {
                    this.collegeChart.data.labels = json.chart.college.labels;
                    this.collegeChart.data.datasets[0].data = json.chart.college.data;
                    this.collegeChart.update();
                }
            })
            .catch(err => {
                this.liveStatus = 'error';
                console.warn('Live poll failed:', err);
            });
        },
        
        destroy() {
            if (this.livePolling) clearInterval(this.livePolling);
        }
    }
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    document.querySelectorAll('[x-data]').forEach(el => {
        if (el.__alpine) el.__alpine.destroy?.();
    });
});
</script>

@endsection