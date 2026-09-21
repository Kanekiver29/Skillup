@extends('staff.layouts.masters')

@section('title', 'Add Schedule')

@section('content')
<div class="container max-w-4xl py-8">
    <h1 class="mb-6 text-2xl font-bold text-slate-900">Add Schedule</h1>

    @if($errors->any())
        <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-red-700">Please correct the highlighted fields.</div>
    @endif

    <form method="POST" action="{{ route('staff.schedule.store') }}" class="rounded border border-slate-200 bg-white p-6 shadow-sm">
        @include('staff.schedule._form', ['submitLabel' => 'Add schedule'])
    </form>
</div>
@endsection
