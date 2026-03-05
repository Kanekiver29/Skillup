@extends('layout.Admin.system')

@section('title', 'Create Course')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-6">New Course</h1>

    <form action="{{ route('admin.courses.store') }}" method="POST">
        @csrf
        @include('Admin.courses.form')

        <div class="mt-6">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Course</button>
            <a href="{{ route('admin.courses.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection