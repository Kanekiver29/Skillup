@extends('staff.layouts.masters')

@section('title','Edit Course')

@section('content')
<div class="container py-8">
    <h1 class="text-2xl font-bold mb-4">Edit Course</h1>

    <form method="POST" action="{{ route('staff.courses.update', $course->id) }}">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block font-semibold">Title</label>
                <input name="title" value="{{ $course->title }}" class="border p-2 w-full" required>
            </div>
            <div>
                <label class="block font-semibold">Short description</label>
                <input name="short_description" value="{{ $course->short_description }}" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold">Description</label>
                <textarea name="description" class="border p-2 w-full">{{ $course->description }}</textarea>
            </div>
            <div>
                <label class="block font-semibold">Category</label>
                <input name="category" value="{{ $course->category }}" class="border p-2 w-full" required>
            </div>
            <div>
                <label class="block font-semibold">Level</label>
                <select name="level" class="border p-2 w-full">
                    <option {{ $course->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                    <option {{ $course->level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option {{ $course->level == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold">Duration (hours)</label>
                <input name="duration_hours" type="number" step="0.1" value="{{ $course->duration_hours }}" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold">Instructor name</label>
                <input name="instructor_name" value="{{ $course->instructor_name }}" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold">Instructor title</label>
                <input name="instructor_title" value="{{ $course->instructor_title }}" class="border p-2 w-full">
            </div>
            <div>
                <label class="block font-semibold">Image URL</label>
                <input name="image_url" value="{{ $course->image_url }}" class="border p-2 w-full">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1" id="published" {{ $course->is_published ? 'checked' : '' }}>
                <label for="published" class="text-sm">Publish immediately</label>
            </div>
        </div>
        <div>
            <button class="px-4 py-2 bg-blue-600 text-white">Save</button>
        </div>
    </form>
</div>
@endsection
