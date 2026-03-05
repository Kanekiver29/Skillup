@extends('layout.Admin.system')

@section('title', 'Admin Accounts')

@section('content')
<div class="container mx-auto p-6">
  <header class="mb-6">
    <h1 class="text-3xl font-semibold">Admin Accounts</h1>
    <p class="text-sm text-gray-600">Manage administrator users</p>
  </header>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
      {{ session('error') }}
    </div>
  @endif

  <div class="bg-white shadow rounded">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Joined</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($admins as $admin)
            <tr class="border-b hover:bg-gray-50">
              <td class="px-6 py-4 text-sm font-medium">{{ $admin->name }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ $admin->email }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ $admin->created_at->format('M d, Y') }}</td>
              <td class="px-6 py-4 text-right text-sm">
                @if($admin->id !== auth()->id())
                  <form action="{{ route('admin.remove-admin', $admin) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold" onclick="return confirm('Remove admin privileges?')">
                      Remove Admin
                    </button>
                  </form>
                @else
                  <span class="text-gray-400 text-xs">Current User</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="px-6 py-4 text-center text-gray-500">No admin accounts found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-6">
    <a href="{{ route('admin.users') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      View All Users
    </a>
    <a href="{{ route('admin.dashboard') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 ml-2">
      Back to Dashboard
    </a>
  </div>
</div>
@endsection
