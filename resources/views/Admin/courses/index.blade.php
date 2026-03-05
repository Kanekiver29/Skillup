@extends('layout.Admin.system')

@section('title', 'Courses Management')

@section('content')
<div class="container mx-auto p-6">
    <header class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-semibold">Courses</h1>
        <a href="{{ route('admin.courses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> New Course
        </a>
    </header>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Published</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $c)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">{{ $c->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $c->category }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $c->level }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($c->is_published)
                                    <span class="text-green-600 font-semibold">Yes</span>
                                @else
                                    <span class="text-red-600 font-semibold">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('admin.courses.enrollments', $c) }}" class="text-indigo-600 hover:text-indigo-800 text-xs mr-2">Enrollments</a>
                                <a href="{{ route('admin.courses.edit', $c) }}" class="text-blue-600 hover:text-blue-800 text-xs mr-2">Edit</a>
                                <form action="{{ route('admin.courses.destroy', $c) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs" onclick="return confirm('Delete this course?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No courses created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $courses->links() }}
    </div>
</div>
@endsection
