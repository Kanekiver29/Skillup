@extends('layout.app')

@section('title', 'Account Settings')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Account Settings</h1>

        @if(session('success'))
            <div class="mb-4 text-green-700">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('account.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold">Full name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-2 w-full" required>
                @error('name')<p class="text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border p-2 w-full" required>
                @error('email')<p class="text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <button class="px-4 py-2 bg-blue-600 text-white">Save changes</button>
                <a href="{{ route('account.password.show') }}" class="ml-4 text-sm text-gray-600">Change password</a>
            </div>
        </form>
    </div>
@endsection
