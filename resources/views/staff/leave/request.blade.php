@extends('staff.layouts.masters')

@section('title','Request Leave')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-4">Request Leave</h1>

    <form method="POST" action="{{ route('staff.leave.submit') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold">From</label>
            <input type="date" name="from" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">To</label>
            <input type="date" name="to" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Reason</label>
            <textarea name="reason" class="border p-2 w-full" required></textarea>
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-600 text-white">Submit Request</button>
        </div>
    </form>

    <hr class="my-6">
    <h2 class="text-lg font-semibold mb-3">Submitted Requests (session)</h2>
    @php $requests = session('staff_leave_requests', []); @endphp
    @if(count($requests))
        <ul class="space-y-2">
            @foreach($requests as $r)
                <li class="p-3 bg-white border rounded">{{ $r['from'] }} → {{ $r['to'] }} — {{ $r['reason'] }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-slate-500">No requests submitted.</p>
    @endif
</div>
@endsection
