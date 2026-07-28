@extends('staff.layouts.masters')

@section('title', 'Edit Module - ' . $module->title)

@section('content')
<div class="container mx-auto p-6">
    <header class="mb-6">
        <h1 class="text-3xl font-semibold">Edit Module</h1>
        <p class="text-sm text-slate-500">Editing: <span class="font-medium">{{ $module->title }}</span></p>
    </header>

    <div class="rounded-lg bg-white p-6 shadow">
        <form action="{{ route('staff.modules.update', $module) }}" method="POST">
            @csrf
            @method('PUT')
            @include('Admin.modules.form')

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-2 text-white transition hover:bg-indigo-700">
                    Save Module
                </button>
                <a href="{{ route('staff.modules.index', ['course_id' => $module->course_id]) }}" class="rounded-lg bg-slate-200 px-6 py-2 text-slate-700 transition hover:bg-slate-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
