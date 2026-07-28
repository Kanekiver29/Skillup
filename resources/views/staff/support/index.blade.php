@extends('staff.layouts.masters')

@section('title','Contact Support')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-4">Contact Support</h1>

    <form method="POST" action="{{ route('staff.support.send') }}">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold">Subject</label>
            <input name="subject" class="border p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold">Message</label>
            <textarea name="message" class="border p-2 w-full" required></textarea>
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-600 text-white">Send</button>
        </div>
    </form>

    <hr class="my-6">
    <h2 class="text-lg font-semibold mb-3">Sent messages (session)</h2>
    @php $msgs = session('staff_support_messages', []); @endphp
    @if(count($msgs))
        <ul class="space-y-2">
            @foreach($msgs as $m)
                <li class="p-3 bg-white border rounded"><strong>{{ $m['subject'] }}</strong><div class="text-sm text-slate-500">{{ $m['message'] }}</div></li>
            @endforeach
        </ul>
    @else
        <p class="text-slate-500">No messages sent.</p>
    @endif
</div>
@endsection
