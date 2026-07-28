@extends('layout.app')

@section('title', 'Create Staff Account - Admin')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <h2 class="text-2xl font-semibold mb-6">Create Staff Account</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.staff.register.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Full name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border rounded p-2">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border rounded p-2">
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" required class="w-full border rounded p-2">
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Staff Type</label>
            <select name="staff_type" required class="w-full border rounded p-2">
                @foreach(
                    \App\Models\User::STAFF_TYPES as $key => $meta
                )
                    <option value="{{ $key }}">{{ $meta['label'] }}</option>
                @endforeach
            </select>
            @error('staff_type') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Create Staff</button>
            <a href="{{ route('admin.staff.index') }}" class="ml-3 text-sm">Back to staff list</a>
        </div>
    </form>
</div>
@endsection
