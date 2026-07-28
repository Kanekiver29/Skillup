@extends('layout.Admin.system')

@section('title', 'Excel Reports – SkillUp Admin')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    {{-- ── Page Header ────────────────────────────────────────────────────── --}}
    <div class="bg-white border-b border-gray-200 mb-8 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <nav class="flex items-center text-xs text-gray-500 mb-1 gap-1">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span class="text-gray-700 font-medium">Excel Reports</span>
                    </nav>
                    <h1 class="text-3xl font-bold text-gray-900">Excel Reports</h1>
                    <p class="text-gray-500 mt-1 text-sm">Real-time data export with print-ready formatting</p>
                </div>
                <div class="p-3 bg-green-100 rounded-xl">
                    <i class="fas fa-file-excel text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- ── Real-time Stats ────────────────────────────────────────────── --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            {{-- Total Users --}}
            <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-5 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Users</p>
                    <i class="fas fa-users text-blue-500 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900 stat-total-users">{{ $stats['total_users'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Live count</p>
            </div>

            {{-- Total Courses --}}
            <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-5 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Total Courses</p>
                    <i class="fas fa-book text-purple-500 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900 stat-total-courses">{{ $stats['total_courses'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Live count</p>
            </div>

            {{-- Total Enrollments --}}
            <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-5 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Enrollments</p>
                    <i class="fas fa-graduation-cap text-yellow-500 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-gray-900 stat-total-enrollments">{{ $stats['total_enrollments'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Live count</p>
            </div>

            {{-- Last Updated --}}
            <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-5 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Last Updated</p>
                    <i class="fas fa-sync-alt text-green-500 text-lg animate-spin" id="sync-icon"></i>
                </div>
                <p class="text-sm font-mono text-gray-900" id="last-update">Just now</p>
                <p class="text-xs text-gray-400 mt-1">Auto-refresh every 30s</p>
            </div>
        </section>

        {{-- ── Export Options ────────────────────────────────────────────── --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Users Report --}}
            <div class="bg-white rounded-lg border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-blue-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-user text-blue-600"></i> User Report
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Name, Email, Age, Birthday & Address</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2 text-sm text-gray-600">
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Complete user information
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Course enrollment count
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Sorted by latest first
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Print-ready layout
                        </p>
                    </div>
                    <button onclick="window.location.href='{{ route('admin.excel.export-users') }}'"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Export Excel
                    </button>
                    <button onclick="printReport('users')"
                            class="w-full border border-blue-200 text-blue-600 py-2 rounded-lg font-medium hover:bg-blue-50 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-print"></i> Print Preview
                    </button>
                </div>
            </div>

            {{-- Users with Courses --}}
            <div class="bg-white rounded-lg border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all">
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 border-b border-purple-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-book-open text-purple-600"></i> Users & Courses
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">User details with enrolled courses</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2 text-sm text-gray-600">
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> User information
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Course enrollment details
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Progress percentage
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Landscape print format
                        </p>
                    </div>
                    <button onclick="window.location.href='{{ route('admin.excel.export-users-courses') }}'"
                            class="w-full bg-purple-600 text-white py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Export Excel
                    </button>
                    <button onclick="printReport('courses')"
                            class="w-full border border-purple-200 text-purple-600 py-2 rounded-lg font-medium hover:bg-purple-50 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-print"></i> Print Preview
                    </button>
                </div>
            </div>

            {{-- Enrollment Report --}}
            <div class="bg-white rounded-lg border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all">
                <div class="bg-gradient-to-r from-green-50 to-green-100 border-b border-green-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-green-600"></i> Enrollment Report
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Course enrollment statistics</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2 text-sm text-gray-600">
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Course statistics
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Student count per course
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Status overview
                        </p>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-check text-green-500"></i> Ready for analysis
                        </p>
                    </div>
                    <button onclick="window.location.href='{{ route('admin.excel.export-enrollment') }}'"
                            class="w-full bg-green-600 text-white py-2 rounded-lg font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Export Excel
                    </button>
                    <button onclick="printReport('enrollment')"
                            class="w-full border border-green-200 text-green-600 py-2 rounded-lg font-medium hover:bg-green-50 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-print"></i> Print Preview
                    </button>
                </div>
            </div>
        </section>

        {{-- ── Real-time Data Preview ────────────────────────────────────── --}}
        <section class="bg-white rounded-lg border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-list text-gray-600"></i> Live User Data Preview
                </h2>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class="fas fa-circle text-green-500 animate-pulse"></i>
                    <span id="live-status">Updating...</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">#</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Name</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Age</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Birthday</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Address</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Courses</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body" class="divide-y divide-gray-200">
                        {{-- Populated by JavaScript --}}
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 text-center text-xs text-gray-500">
                Showing latest 10 users • Auto-refreshing every 30 seconds
            </div>
        </section>
    </div>
</div>

{{-- ── Print Styles ────────────────────────────────────────────────── --}}
<style>
    @media print {
        body {
            background: white;
        }

        .no-print {
            display: none !important;
        }

        .print-container {
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }
    }

    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }
</style>

{{-- ── Real-time Monitoring Script ──────────────────────────────── --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initial load
    loadRealTimeData();

    // Refresh every 30 seconds
    setInterval(loadRealTimeData, 30000);

    // Keyboard shortcut for quick export (Ctrl+E)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            alert('Press the export button to download');
        }
    });
});

function loadRealTimeData() {
    const syncIcon = document.getElementById('sync-icon');
    syncIcon.style.animation = 'spin 1s linear infinite';

    fetch('{{ route("admin.excel.realtime-data") }}')
        .then(response => response.json())
        .then(data => {
            // Update stats
            document.querySelector('.stat-total-users').textContent = data.total_users;
            document.querySelector('.stat-total-courses').textContent = data.total_courses;
            document.querySelector('.stat-total-enrollments').textContent = data.total_enrollments;

            // Update table
            updateUserTable(data.users);

            // Update timestamp
            const now = new Date();
            document.getElementById('last-update').textContent = now.toLocaleTimeString();
            document.getElementById('live-status').textContent = 'Live';

            syncIcon.style.animation = 'none';
        })
        .catch(error => {
            console.error('Error loading real-time data:', error);
            document.getElementById('live-status').textContent = 'Error connecting';
            syncIcon.style.animation = 'none';
        });
}

function updateUserTable(users) {
    const tbody = document.getElementById('users-table-body');
    tbody.innerHTML = '';

    users.forEach((user, index) => {
        const birthday = user.birthday ? new Date(user.birthday).toLocaleDateString() : 'N/A';
        const row = `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-gray-500 font-medium">${index + 1}</td>
                <td class="px-6 py-4 font-medium text-gray-900">${user.name || 'N/A'}</td>
                <td class="px-6 py-4 text-gray-600">${user.email || 'N/A'}</td>
                <td class="px-6 py-4 text-gray-600">${user.age || 'N/A'}</td>
                <td class="px-6 py-4 text-gray-600">${birthday}</td>
                <td class="px-6 py-4 text-gray-600">${user.location || 'N/A'}</td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                        ${user.enrollments_count}
                    </span>
                </td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function printReport(reportType) {
    const reportTitle = {
        'users': 'User Report',
        'courses': 'Users & Courses Report',
        'enrollment': 'Enrollment Report'
    }[reportType];

    if (confirm(`Print ${reportTitle}?\n\nThis will open a print preview in your browser.`)) {
        window.print();
    }
}
</script>

@endsection
