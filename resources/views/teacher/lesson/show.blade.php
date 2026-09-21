@extends('teacher.layouts.master')

@section('title', $lesson->title ?? 'Lesson Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $lesson->title ?? 'Lesson Details' }}</h1>
            <p class="text-slate-500">{{ $lesson->module->title ?? 'Module' }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('teacher.lessons.edit', $lesson->id) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Edit</a>
            <a href="{{ route('teacher.lessons.index') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Back</a>
        </div>
    </div>

    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="prose max-w-none text-slate-700">
            @if($lesson->video_url)
                <div class="mb-6 overflow-hidden rounded-xl border border-slate-200">
                    <iframe src="{{ $lesson->video_url }}" class="aspect-video w-full" allowfullscreen></iframe>
                </div>
            @endif

            <div class="space-y-4">
                <p>{!! nl2br(e($lesson->content ?? 'No content available.')) !!}</p>
            </div>
        </div>
    </div>
</div>
@endsection
