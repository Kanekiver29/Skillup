@extends('layout.app')

@section('title', 'Promote User to Staff - Admin')

@section('content')
<div class="max-w-3xl mx-auto py-12">
    <h2 class="text-2xl font-semibold mb-6">Promote User to Staff</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Select existing user</label>
            <select name="user_id" required class="w-full border rounded p-2">
                <option value="">-- choose a user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} — {{ $u->email }}</option>
                @endforeach
            </select>
            @error('user_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Staff Type</label>
            <select name="staff_type" required class="w-full border rounded p-2">
                @foreach($staffTypes as $key => $meta)
                    <option value="{{ $key }}">{{ $meta['label'] }}</option>
                @endforeach
            </select>
            @error('staff_type') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Promote to Staff</button>
            <a href="{{ route('admin.staff.index') }}" class="ml-3 text-sm">Back to staff list</a>
        </div>
    </form>
</div>
@endsection
