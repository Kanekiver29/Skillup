@extends('staff.layouts.masters')

@section('title', 'Edit Module - ' . $module->title)

@section('content')
<div class="container py-8">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-cyan-700">
                <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
                Module editor
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Module</h1>
            <p class="mt-1 text-sm text-slate-500">Editing: <span class="font-semibold text-slate-700">{{ $module->title }}</span></p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('staff.modules.index', ['course_id' => $module->course_id]) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                Back to Modules
            </a>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('staff.modules.update', $module) }}" method="POST">
            @csrf
            @method('PUT')
            @include('Admin.modules.form')

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                    <i class="fas fa-save mr-2"></i>
                    Update Module
                </button>
                <a href="{{ route('staff.modules.index', ['course_id' => $module->course_id]) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <div class="mt-8 max-w-2xl rounded-2xl border border-amber-200 bg-amber-50 p-6">
        <h3 class="text-lg font-semibold text-amber-800">Archive Module</h3>
        <p class="mt-2 text-sm text-amber-700">Archiving this module will hide it from students. You can restore it later from the module list.</p>
        <form action="{{ route('staff.modules.destroy', $module) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to archive this module?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-700">
                <i class="fas fa-archive mr-2"></i>
                Archive Module
            </button>
        </form>
    </div>

    <div class="mt-4 max-w-2xl rounded-2xl border border-red-200 bg-red-50 p-6">
        <h3 class="text-lg font-semibold text-red-800">Danger Zone</h3>
        <p class="mt-2 text-sm text-red-700">Permanently deleting this module will remove all quizzes, questions, and student attempts. This action cannot be undone.</p>
        <form action="{{ route('staff.modules.destroy', $module) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure? This will PERMANENTLY delete this module and all its data. This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                <i class="fas fa-trash mr-2"></i>
                Delete Permanently
            </button>
        </form>
    </div>
</div>
@endsection
