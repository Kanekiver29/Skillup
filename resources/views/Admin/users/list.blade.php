@extends('layout.Admin.system')

@section('title', 'User Management')

@section('content')
<div class="container mx-auto p-6">
  <header class="mb-6">
    <h1 class="text-3xl font-semibold">User Management</h1>
    <p class="text-sm text-gray-600">Manage all users in the system</p>
  </header>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="bg-white shadow rounded">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Joined</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr class="border-b hover:bg-gray-50">
              <td class="px-6 py-4 text-sm font-medium">{{ $user->name }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
              <td class="px-6 py-4 text-sm">
                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">Regular User</span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
              <td class="px-6 py-4 text-right text-sm space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                  Edit
                </a>
                <form action="{{ route('admin.make-admin', $user) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="text-green-600 hover:text-green-800 text-xs font-semibold">
                    Make Admin
                  </button>
                </form>
                <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will delete the user account.');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-4 text-center text-gray-500">No regular users found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">
    {{ $users->links() }}
  </div>

  <div class="mt-6">
    <a href="{{ route('admin.admins') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      View Admin Accounts
    </a>
    <a href="{{ route('admin.dashboard') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 ml-2">
      Back to Dashboard
    </a>
  </div>
</div>
@endsection
