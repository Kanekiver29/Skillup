@extends('staff.layouts.masters')

@section('title', 'Edit Image Resource')

@section('content')
<div class="container mx-auto p-6">
    <header class="mb-6">
        <h1 class="text-3xl font-semibold">Edit Image Resource</h1>
        <p class="mt-2 text-sm text-slate-400">Update the image attached to this module.</p>
    </header>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('staff.images.update', $module) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700" for="module_id">Module</label>
                <select name="module_id" id="module_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <option value="{{ $module->id }}">{{ $module->course->title ?? 'Course' }} · {{ $module->title }}</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700" for="image_url">Image URL</label>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $module->image_url) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="https://example.com/image.png">
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700" for="image_file">Upload Image File</label>
                <input type="file" name="image_file" id="image_file" accept="image/*" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 font-semibold text-white hover:bg-sky-700">Save Changes</button>
                <a href="{{ route('staff.images.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
