@extends('layout.Admin.system')

@section('title', $major->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8">
        <a href="{{ route('admin.majors.index') }}" class="text-blue-600 hover:text-blue-900 text-sm mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Back to Majors
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $major->name }}</h1>
                <p class="mt-1 text-gray-600">
                    <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">{{ $major->code }}</span>
                    @if($major->department)
                        <span class="ml-2">{{ $major->department }}</span>
                    @endif
                </p>
            </div>
            <a href="{{ route('admin.majors.edit', $major) }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
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

    <div class="grid grid-cols-3 gap-6 mb-8">
        <!-- Info Cards -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-600 mb-1">Status</div>
            <div class="text-2xl font-bold text-gray-900">
                @if($major->is_active)
                    <span class="text-green-600">Active</span>
                @else
                    <span class="text-gray-400">Inactive</span>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-600 mb-1">Courses</div>
            <div class="text-2xl font-bold text-gray-900">{{ $major->courses->count() }}</div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-600 mb-1">Enrolled Students</div>
            <div class="text-2xl font-bold text-gray-900">{{ $major->students->count() }}</div>
        </div>
    </div>

    @if($major->description)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
            <p class="text-gray-700">{{ $major->description }}</p>
        </div>
    @endif

    <!-- Courses Section -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="border-b p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Courses in this Major</h2>
            <p class="text-sm text-gray-600">Assign courses to this major and set which is the primary/designated course</p>
        </div>

        @if($major->courses->isNotEmpty())
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Course</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Code</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Primary</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($major->courses as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $course->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($course->description, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $course->code ?? '—' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($course->is_primary)
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                        <i class="fas fa-star mr-1"></i>Primary
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('admin.majors.set-primary', [$major, $course]) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-500 hover:text-blue-600 transition text-xs">
                                            <i class="fas fa-star-o mr-1"></i>Set Primary
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($course->is_published)
                                    <span class="text-green-600 text-xs font-semibold">Published</span>
                                @else
                                    <span class="text-gray-400 text-xs font-semibold">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.majors.remove-course', [$major, $course]) }}" class="inline" onsubmit="return confirm('Remove this course from the major?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                        <i class="fas fa-unlink mr-1"></i>Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-book text-3xl mb-2 block opacity-50"></i>
                No courses assigned to this major yet.
            </div>
        @endif

        <!-- Assign Course Form -->
        <div class="border-t p-6 bg-gray-50">
            <h3 class="font-semibold text-gray-900 mb-4">Assign a Course</h3>
            <form method="POST" action="{{ route('admin.majors.assign-course', $major) }}" class="flex gap-3 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Course</label>
                    <select name="course_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Choose a course...</option>
                        @foreach($major->getAvailableCourses() as $course)
                            <option value="{{ $course->id }}">
                                {{ $course->title }} @if($course->code)({{ $course->code }})@endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_primary" value="1" class="w-4 h-4 text-blue-600 rounded">
                        <span class="ml-2 text-sm text-gray-700">Make Primary</span>
                    </label>
                </div>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i>Assign
                </button>
            </form>
        </div>
    </div>

    <!-- Students Section -->
    @if($major->students->isNotEmpty())
        <div class="bg-white rounded-lg shadow">
            <div class="border-b p-6">
                <h2 class="text-xl font-bold text-gray-900">Students in this Major ({{ $major->students->count() }})</h2>
            </div>

            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Current Course</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($major->students as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $student->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $student->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($student->assigned_course_id)
                                    {{ $student->assignedCourse->title ?? '—' }}
                                @else
                                    <span class="text-gray-400">Not assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $student->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
