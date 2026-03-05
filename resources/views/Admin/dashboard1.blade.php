{{--
    Legacy dashboard view. The new consolidated admin dashboard is located at
    resources/views/Admin/dashboard.blade.php.
    This file is retained for reference but no longer used by routes.
--}}
@extends('layout.Admin.system')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
  <!-- Header Section -->
  <div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
          <p class="text-gray-600 mt-1">Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span></p>
        </div>
        <div class="flex items-center space-x-4">
          <div class="text-right">
            <p class="text-sm text-gray-600">Last updated</p>
            <p class="text-sm font-semibold text-gray-900">{{ now()->format('M d, Y - h:i A') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(auth()->user()->is_admin)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      
      <!-- Stats Cards Grid -->
      <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-sm font-medium text-gray-600">Total Users</h3>
              <div class="p-2 bg-blue-100 rounded-lg">
                <i class="fas fa-users text-blue-600"></i>
              </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $userCount ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-2">Active user accounts</p>
          </div>
        </div>

        <!-- Active Courses Card -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-sm font-medium text-gray-600">Active Courses</h3>
              <div class="p-2 bg-purple-100 rounded-lg">
                <i class="fas fa-book text-purple-600"></i>
              </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $activePaths ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-2">Courses available</p>
          </div>
        </div>

        <!-- Achievements Card -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-sm font-medium text-gray-600">Achievements</h3>
              <div class="p-2 bg-yellow-100 rounded-lg">
                <i class="fas fa-trophy text-yellow-600"></i>
              </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $badges ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-2">Total badges issued</p>
          </div>
        </div>

        <!-- Learning Hours Card -->
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-sm font-medium text-gray-600">Learning Hours</h3>
              <div class="p-2 bg-green-100 rounded-lg">
                <i class="fas fa-clock text-green-600"></i>
              </div>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $hours ?? 0 }}</div>
            <p class="text-xs text-gray-500 mt-2">Total platform usage</p>
          </div>
        </div>
      </section>

      <!-- Main Content Grid -->
      <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Engagement Chart Section -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100">
          <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Engagement Overview</h2>
            <p class="text-sm text-gray-600 mt-1">Platform activity and user engagement trends</p>
          </div>
          <div class="p-6">
            <div class="h-64 bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg flex items-center justify-center border border-gray-100">
              <div class="text-center">
                <i class="fas fa-chart-line text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Chart integration coming soon</p>
                <p class="text-xs text-gray-400 mt-2">Add Chart.js or ApexCharts for analytics</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Signups Sidebar -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
          <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 flex items-center">
              <i class="fas fa-user-check text-purple-600 mr-2"></i>
              Recent Signups
            </h3>
          </div>
          <div class="divide-y divide-gray-100">
            @forelse($recentUsers ?? [] as $user)
              <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center space-x-3">
                  @if($user->profile_image)
                    <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}" 
                         alt="{{ $user->name }}" 
                         class="w-8 h-8 rounded-full object-cover">
                  @else
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-purple-400 flex items-center justify-center text-white text-xs font-bold">
                      {{ substr($user->name, 0, 1) }}
                    </div>
                  @endif
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                  </div>
                </div>
              </div>
            @empty
              <div class="p-4 text-center">
                <p class="text-sm text-gray-500">No recent signups</p>
              </div>
            @endforelse
          </div>
        </div>
      </section>

      <!-- Quick Actions Section -->
      <section class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
          <i class="fas fa-lightning-bolt text-yellow-500 mr-2"></i>
          Quick Actions
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <a href="{{ route('admin.admins') }}" 
             class="group p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-semibold text-gray-900">Admin Accounts</h4>
              <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-600 transition-colors"></i>
            </div>
            <p class="text-sm text-gray-600">View and manage admin users</p>
          </a>

          <a href="{{ route('admin.users') }}" 
             class="group p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition-all">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-semibold text-gray-900">Manage Users</h4>
              <i class="fas fa-arrow-right text-gray-400 group-hover:text-green-600 transition-colors"></i>
            </div>
            <p class="text-sm text-gray-600">Edit or delete user accounts</p>
          </a>

          <a href="/admin/reports" 
             class="group p-4 border border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-semibold text-gray-900">Export Report</h4>
              <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-600 transition-colors"></i>
            </div>
            <p class="text-sm text-gray-600">Generate platform analytics</p>
          </a>
        </div>
      </section>

      <!-- System Stats Footer -->
      <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm text-white p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-blue-100 text-sm">Admin Users</p>
              <p class="text-3xl font-bold mt-2">
                @php
                  $adminCount = isset($users) ? $users->where('is_admin', true)->count() : 0;
                @endphp
                {{ $adminCount }}
              </p>
            </div>
            <i class="fas fa-shield-alt text-4xl text-blue-300"></i>
          </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm text-white p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-100 text-sm">Regular Users</p>
              <p class="text-3xl font-bold mt-2">
                @php
                  $regularCount = isset($users) ? $users->where('is_admin', false)->count() : 0;
                @endphp
                {{ $regularCount }}
              </p>
            </div>
            <i class="fas fa-user-circle text-4xl text-green-300"></i>
          </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm text-white p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-purple-100 text-sm">Platform Status</p>
              <p class="text-3xl font-bold mt-2">Live</p>
            </div>
            <i class="fas fa-server text-4xl text-purple-300"></i>
          </div>
        </div>
      </section>
    </div>

  @else
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="p-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
        <div class="flex items-center">
          <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl mr-4"></i>
          <div>
            <h3 class="font-semibold text-yellow-800">Access Denied</h3>
            <p class="text-yellow-700 text-sm mt-1">You do not have admin access to this page. Please contact a system administrator.</p>
          </div>
        </div>
      </div>
    </div>
  @endif

</div>
@endsection