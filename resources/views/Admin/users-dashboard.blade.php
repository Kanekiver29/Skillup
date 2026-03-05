{{--
    Legacy admin users dashboard. Admins are now redirected to the main
    admin dashboard. This view is kept only for backward compatibility or
    reference and is not linked from the navigation.
--}}
@extends('layout.Admin.system')

@section('title', 'Users Dashboard')

@section('content')
<div class="container mx-auto p-6">
  <!-- Header -->
  <header class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-3xl font-semibold">Users Management</h1>
      <p class="text-sm text-gray-600">View and manage all user accounts</p>
    </div>
    <div>
      <span class="text-sm text-gray-700">Signed in as <strong>{{ auth()->user()->name }}</strong> (Admin)</span>
    </div>
  </header>

  <!-- Stats Section -->
  <section class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Total Users</div>
      <div class="text-3xl font-bold text-blue-600">{{ $userCount }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Admin Users</div>
      <div class="text-3xl font-bold text-purple-600">
        @php
          $adminCount = $users->where('is_admin', true)->count();
        @endphp
        {{ $adminCount }}
      </div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Regular Users</div>
      <div class="text-3xl font-bold text-green-600">{{ $userCount - $adminCount }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">New This Month</div>
      <div class="text-3xl font-bold text-orange-600">
        @php
          $thisMonth = $users->filter(function($u) {
            return $u->created_at->isCurrentMonth();
          })->count();
        @endphp
        {{ $thisMonth }}
      </div>
    </div>
  </section>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
      {{ session('success') }}
    </div>
  @endif

  <!-- Users Table -->
  <div class="bg-white shadow rounded overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Username</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Role</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Joined</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="px-6 py-4 text-sm font-medium">
                @if($user->profile_image)
                  <div class="flex items-center gap-2">
                    <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}" 
                         alt="{{ $user->name }}" 
                         class="w-8 h-8 rounded-full object-cover">
                    <span>{{ $user->name }}</span>
                  </div>
                @else
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                      <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                      </svg>
                    </div>
                    <span>{{ $user->name }}</span>
                  </div>
                @endif
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ $user->username }}</td>
              <td class="px-6 py-4 text-sm">
                @if($user->is_admin)
                  <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs rounded-full font-semibold">
                    Admin
                  </span>
                @else
                  <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                    User
                  </span>
                @endif
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
              <td class="px-6 py-4 text-right text-sm space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="text-blue-600 hover:text-blue-800 font-semibold text-xs py-1 px-2 rounded hover:bg-blue-50 inline-block">
                  Edit
                </a>
                
                @if($user->is_admin && auth()->user()->id !== $user->id)
                  <form action="{{ route('admin.remove-admin', $user) }}" method="POST" class="inline" onsubmit="return confirm('Remove admin privileges?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-semibold text-xs py-1 px-2 rounded hover:bg-yellow-50">
                      Remove Admin
                    </button>
                  </form>
                @elseif(!$user->is_admin && auth()->user()->id !== $user->id)
                  <form action="{{ route('admin.make-admin', $user) }}" method="POST" class="inline" onsubmit="return confirm('Make this user admin?');">
                    @csrf
                    <button type="submit" class="text-green-600 hover:text-green-800 font-semibold text-xs py-1 px-2 rounded hover:bg-green-50">
                      Make Admin
                    </button>
                  </form>
                @endif

                @if(auth()->user()->id !== $user->id)
                  <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will delete the user account.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs py-1 px-2 rounded hover:bg-red-50">
                      Delete
                    </button>
                  </form>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                No users found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  @if($users->hasPages())
    <div class="mt-4">
      {{ $users->links() }}
    </div>
  @endif

  <!-- Quick Links -->
  <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('admin.dashboard') }}" class="p-4 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 transition">
      <h3 class="font-semibold text-blue-800 mb-1">Admin Dashboard</h3>
      <p class="text-sm text-blue-700">View platform statistics</p>
    </a>
    <a href="{{ route('admin.admins') }}" class="p-4 bg-purple-50 border border-purple-200 rounded hover:bg-purple-100 transition">
      <h3 class="font-semibold text-purple-800 mb-1">Admin Accounts</h3>
      <p class="text-sm text-purple-700">Manage admin users</p>
    </a>
    <a href="{{ route('userpage.dashboard') }}" class="p-4 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100 transition">
      <h3 class="font-semibold text-gray-800 mb-1">My Dashboard</h3>
      <p class="text-sm text-gray-700">View your profile</p>
    </a>
  </div>
</div>
@endsection
