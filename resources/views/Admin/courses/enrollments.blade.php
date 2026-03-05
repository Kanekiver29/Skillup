@extends('layout.Admin.system')

@section('title', 'Enrollments for ' . $course->title)

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-6">Enrollments - {{ $course->title }}</h1>

    <div class="bg-white shadow rounded">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Completed</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Enrolled On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $e)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium">{{ $e->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $e->user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $e->progress ?? 0 }}%</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $e->completed ? 'Yes' : 'No' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $e->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No enrollments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $enrollments->links() }}
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.courses.index') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to Courses</a>
    </div>
</div>
@endsection