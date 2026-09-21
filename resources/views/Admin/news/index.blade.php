@extends('layout.Admin.system')

@section('title', 'Manage News')

@section('content')
<div class="mx-auto max-w-6xl px-4 pb-16 pt-10 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-300">SkillUp Admin</p>
            <h1 class="mt-2 text-3xl font-black text-white">News</h1>
        </div>
        <a
            href="{{ route('admin.news.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400"
        >
            + New post
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-300">
            {{ session('status') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-[28px] border border-slate-700/80 bg-slate-900/60">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-slate-800 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Published</th>
                    <th class="px-6 py-4">Featured</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($news as $item)
                    <tr class="transition hover:bg-slate-950/40">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-white">{{ $item->title }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-cyan-200">
                                {{ ucfirst($item->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-400">
                            {{ optional($item->published_at ?? $item->created_at)->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($item->featured)
                                <span class="text-emerald-400">Yes</span>
                            @else
                                <span class="text-slate-500">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.news.edit', $item->id) }}" class="text-sm font-semibold text-cyan-300 hover:text-cyan-200">Edit</a>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete “{{ $item->title }}”? This can’t be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold text-rose-400 hover:text-rose-300">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                            No news posts yet. <a href="{{ route('admin.news.create') }}" class="font-semibold text-cyan-300 hover:text-cyan-200">Create the first one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (method_exists($news, 'links'))
        <div class="mt-6">
            {{ $news->links() }}
        </div>
    @endif
</div>
@endsection
