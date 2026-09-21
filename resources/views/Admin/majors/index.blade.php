@extends('layout.Admin.system')

@section('title', 'Majors/Programs')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Majors & Programs</h1>
            <p class="mt-2 text-gray-600">Manage academic majors/programs and assign courses</p>
        </div>
        <a href="{{ route('admin.majors.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Add Major
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <h3 class="font-semibold text-red-900 mb-2">Errors</h3>
            <ul class="list-disc list-inside text-sm text-red-800">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 text-green-800">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Major</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Code</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Department</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Courses</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Students</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($majors as $major)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $major->name }}</div>
                            @if($major->description)
                                <div class="text-sm text-gray-500 truncate">{{ $major->description }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $major->code }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $major->department ?? '—' }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">{{ $major->courses_count }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">{{ $major->students_count }}</td>
                        <td class="px-6 py-4">
                            @if($major->is_active)
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Active</span>
                            @else
                                <span class="inline-block px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.majors.show', $major) }}" class="text-blue-600 hover:text-blue-900 mr-3 text-sm font-medium">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <a href="{{ route('admin.majors.edit', $major) }}" class="text-orange-600 hover:text-orange-900 mr-3 text-sm font-medium">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            @if($major->students_count === 0)
                                <form method="POST" action="{{ route('admin.majors.destroy', $major) }}" class="inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2 block opacity-50"></i>
                            No majors found. Create one to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($majors->hasPages())
        <div class="mt-6">
            {{ $majors->links() }}
        </div>
    @endif
</div>
@endsection
