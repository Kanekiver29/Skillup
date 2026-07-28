@extends('staff.layouts.masters')

@section('title', 'Image Resources')

@section('content')
<div class="container mx-auto p-6">
    <header class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-semibold">Image Resources</h1>
            <p class="text-sm text-slate-400">Attach or replace module images in one place.</p>
        </div>
    </header>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-100 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('staff.images.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-6 md:grid-cols-[1.1fr_0.9fr]">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="module_id">Module</label>
                    <select name="module_id" id="module_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                        <option value="">Select a module</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->course->title ?? 'Course' }} · {{ $module->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="image_url">Image URL</label>
                    <input type="url" name="image_url" id="image_url" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="https://example.com/image.png">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700" for="image_file">Upload Image File</label>
                    <input type="file" name="image_file" id="image_file" accept="image/*" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 p-4 text-sm text-slate-600">
                <h2 class="mb-2 font-semibold text-slate-800">How it works</h2>
                <ul class="list-disc space-y-2 pl-5">
                    <li>Choose a module and add a hosted image URL or upload a new image.</li>
                    <li>The image will be used as the module resource visual.</li>
                    <li>You can remove it at any time.</li>
                </ul>
                <button type="submit" class="mt-4 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Save Image</button>
            </div>
        </form>
    </div>

    <div class="mt-8 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Module</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Current Image</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($modules as $module)
                    <tr>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $module->course->title ?? 'Course' }} · {{ $module->title }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            @if($module->image_url)
                                <a href="{{ $module->image_url }}" target="_blank" rel="noopener" class="text-sky-600 hover:text-sky-800">Open image</a>
                            @else
                                <span class="text-slate-400">No image attached</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('staff.images.destroy', $module) }}" method="POST" onsubmit="return confirm('Remove this image resource?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-8 text-center text-sm text-slate-500">No modules available yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
