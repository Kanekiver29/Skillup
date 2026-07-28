@extends('staff.layouts.masters')

@section('title','New Task')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-4">Create Task</h1>

    <form method="POST" action="{{ route('staff.tasks.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold">Title</label>
            <input name="title" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Due</label>
            <input name="due" class="border p-2 w-full" placeholder="e.g. Today, 5:00 PM">
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-600 text-white">Create Task</button>
        </div>
    </form>

    <hr class="my-6">

    <h2 class="text-lg font-semibold mb-3">My Tasks (session)</h2>
    @php $tasks = session('staff_tasks', []); @endphp
    @if(count($tasks))
        <ul class="space-y-2">
            @foreach($tasks as $t)
                <li class="p-3 bg-white border rounded">{{ $t['title'] }} <span class="text-sm text-slate-500">— {{ $t['due'] ?? '' }}</span></li>
            @endforeach
        </ul>
    @else
        <p class="text-slate-500">No tasks yet.</p>
    @endif
</div>
@endsection
