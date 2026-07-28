@extends('layout.app')

@section('title', 'Change Password')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Change Password</h1>

        @if(session('success'))
            <div class="mb-4 text-green-700">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('account.password.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold">Current password</label>
                <input type="password" name="current_password" class="border p-2 w-full" required>
                @error('current_password')<p class="text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold">New password</label>
                <input type="password" name="password" class="border p-2 w-full" required>
                @error('password')<p class="text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Confirm new password</label>
                <input type="password" name="password_confirmation" class="border p-2 w-full" required>
            </div>

            <div>
                <button class="px-4 py-2 bg-blue-600 text-white">Update password</button>
                <a href="{{ route('account.index') }}" class="ml-4 text-sm text-gray-600">Back to account</a>
            </div>
        </form>
    </div>
@endsection
