@extends('layout.Admin.system')

@section('title', 'Edit User')

@section('content')
<div class="container mx-auto p-6 max-w-2xl">
  <header class="mb-6">
    <h1 class="text-3xl font-semibold">Edit User</h1>
    <p class="text-sm text-gray-600">Update user information</p>
  </header>

  @if($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="bg-white shadow rounded p-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Full Name -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
        <input 
          type="text" 
          id="name" 
          name="name" 
          value="{{ old('name', $user->name) }}" 
          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
          required
        >
        @error('name')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          value="{{ old('email', $user->email) }}" 
          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
          required
        >
        @error('email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Username -->
      <div class="mb-6">
        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input 
          type="text" 
          id="username" 
          name="username" 
          value="{{ old('username', $user->username) }}" 
          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror"
          required
        >
        @error('username')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Action Buttons -->
      <div class="flex gap-3">
        <button 
          type="submit" 
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium"
        >
          Save Changes
        </button>
        <a 
          href="{{ route('admin.users') }}" 
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 font-medium"
        >
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
