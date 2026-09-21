@extends('staff.layouts.masters')

@section('title', 'Edit Schedule')

@section('content')
<div class="container max-w-4xl py-8">
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Edit Schedule</h1>

    @if($errors->any())
        <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-red-700">Please correct the highlighted fields.</div>
    @endif

    <form method="POST" action="{{ route('staff.schedule.update', $schedule) }}" class="rounded border border-slate-200 bg-white p-6 shadow-sm">
        @method('PUT')
        @include('staff.schedule._form', ['submitLabel' => 'Save changes'])
    </form>

    <form method="POST" action="{{ route('staff.schedule.destroy', $schedule) }}" class="mt-4" onsubmit="return confirm('Delete this schedule?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded border border-red-300 px-4 py-2 font-semibold text-red-700 hover:bg-red-50">Delete schedule</button>
    </form>
</div>
@endsection
