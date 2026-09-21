@extends('layout.Admin.system')

@section('title', 'New News Post')

@section('content')
<div class="mx-auto max-w-6xl px-4 pb-16 pt-10 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('admin.news.index') }}" class="text-sm font-semibold text-cyan-300 hover:text-cyan-200">← Back to news</a>
        <h1 class="mt-3 text-3xl font-black text-white">New post</h1>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="rounded-[28px] border border-slate-700/80 bg-slate-900/60 p-6 sm:p-8">
        @csrf

        @include('admin.news._form')

        <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-800 pt-6">
            <a href="{{ route('admin.news.index') }}" class="rounded-xl px-5 py-3 text-sm font-semibold text-slate-400 transition hover:text-white">Cancel</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
                Publish post
            </button>
        </div>
    </form>
</div>
@endsection
