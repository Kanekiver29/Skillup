@extends('staff.layouts.masters')

@section('title','Schedule')

@section('content')
<div class="container py-8">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Schedule</h1>
            <p class="mt-1 text-sm text-slate-500">Manage active trainer classes, rooms, and times.</p>
        </div>
        <a href="{{ route('staff.schedule.create') }}" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Add schedule</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
    @endif

    @if(count($schedule))
        <div class="overflow-x-auto rounded border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full text-left text-sm">
            <thead class="border-b bg-slate-50 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Day and time</th>
                    <th class="px-4 py-3">Class</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @foreach($schedule as $item)
                <tr>
                    <td class="whitespace-nowrap px-4 py-3 text-slate-500">{{ $item['time'] }}</td>
                    <td class="px-4 py-3 font-medium text-slate-900">{{ $item['event'] }}</td>
                    <td class="px-4 py-3 text-right">
                        @if(isset($item['id']))
                            <a href="{{ route('staff.schedule.edit', $item['id']) }}" class="font-semibold text-blue-600 hover:text-blue-800">Edit</a>
                        @else
                            <span class="text-slate-400">Demo data</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    @else
        <div class="rounded border border-dashed border-slate-300 bg-white p-10 text-center">
            <p class="text-slate-500">No active schedules yet.</p>
            <a href="{{ route('staff.schedule.create') }}" class="mt-3 inline-block font-semibold text-blue-600 hover:text-blue-800">Create the first schedule</a>
        </div>
    @endif
</div>
@endsection
