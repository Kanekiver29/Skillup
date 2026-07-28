@extends('staff.layouts.masters')

@section('title','Schedule')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-4">Schedule</h1>

    @if(count($schedule))
        <ul class="space-y-3 bg-white p-4 border rounded">
            @foreach($schedule as $item)
                <li class="flex items-start gap-3">
                    <span class="w-24 text-sm text-slate-500">{{ $item['time'] }}</span>
                    <span class="text-sm">{{ $item['event'] }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-slate-500">No schedule available.</p>
    @endif
</div>
@endsection
