@extends('layout.Admin.system')

@section('title', $item->title ?? 'View News')

@section('content')
<div class="mx-auto max-w-6xl px-4 pb-16 pt-10 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('admin.news.index') }}" class="text-sm font-semibold text-cyan-300 hover:text-cyan-200">← Back to news</a>
        <h1 class="mt-3 text-3xl font-black text-white">{{ $item->title }}</h1>
        <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-400">
            <span class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-cyan-200">
                {{ ucfirst($item->category) }}
            </span>
            <span>{{ optional($item->published_at ?? $item->created_at)->format('M d, Y') }}</span>
            @if ($item->is_featured)
                <span class="text-emerald-400">Featured</span>
            @endif
        </div>
    </div>

    @if ($item->featured_image)
        <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-700/80">
            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="h-auto w-full object-cover" />
        </div>
    @endif

    @if ($item->video_file)
        <div class="mb-6 overflow-hidden rounded-[28px] border border-slate-700/80">
            <video class="h-auto w-full" controls>
                <source src="{{ asset('storage/' . $item->video_file) }}">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif

    <div class="prose prose-slate max-w-none text-base leading-8 text-slate-300">
        {!! nl2br(e($item->content)) !!}
    </div>

    <div class="mt-10 flex items-center gap-4 border-t border-slate-800 pt-6">
        <a href="{{ route('admin.news.edit', $item->id) }}" class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400">
            Edit post
        </a>
        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete “{{ $item->title }}”? This can’t be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-xl px-5 py-3 text-sm font-semibold text-rose-400 hover:text-rose-300">
                Delete this post
            </button>
        </form>
    </div>
</div>
@endsection
