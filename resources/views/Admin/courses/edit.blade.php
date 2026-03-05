@extends('layout.Admin.system')

@section('title', 'Edit Course')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-6">Edit Course: {{ $course->title }}</h1>

    <form action="{{ route('admin.courses.update', $course) }}" method="POST">
        @csrf
        @method('PUT')
        @include('Admin.courses.form')

        <div class="mt-6">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save Changes</button>
            <a href="{{ route('admin.courses.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection