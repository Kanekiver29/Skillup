@extends('layout.app')

@section('title', 'All Courses - SkillUp')

@section('content')
    <!-- Header -->
    <div class="pt-8 pb-12 gradient-primary text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Explore Our Courses</h1>
            <p class="text-lg text-purple-100">Choose from {{ number_format($courses->total()) }} career-focused courses designed to launch your future</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="GET" action="{{ route('courses.index') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="w-full md:w-64">
                <input type="text" name="search" placeholder="Search courses..." value="{{ request('search') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <select name="level" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <option value="all">All Levels</option>
                    <option value="Beginner" {{ request('level') === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="Intermediate" {{ request('level') === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="Advanced" {{ request('level') === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                @if(request('search') || (request('level') && request('level') !== 'all') || (request('category') && request('category') !== 'all'))
                    <a href="{{ route('courses.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Courses Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <a href="{{ route('courses.show', $course->slug) }}" class="course-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Course Image -->
                    <div class="h-36 gradient-primary flex items-center justify-center overflow-hidden bg-cover bg-center"
                         @if($course->image_url) style="background-image: url('{{ asset($course->image_url) }}')" @endif>
                        @if(!$course->image_url)
                            <i class="fas fa-laptop-code text-white text-6xl opacity-30"></i>
                        @endif
                    </div>

                    <!-- Course Content -->
                    <div class="p-6">
                        <div class="mb-3">
                            <span class="inline-block bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-semibold">{{ $course->category }}</span>
                            <span class="inline-block ml-2 bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">{{ $course->level }}</span>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $course->short_description }}</p>

                        <!-- Instructor -->
                        <div class="flex items-center space-x-2 mb-4 pb-4 border-b">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white text-xs font-bold">{{ substr($course->instructor_name, 0, 1) }}</div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ substr($course->instructor_name, 0, 15) }}</p>
                                <p class="text-xs text-gray-600">{{ substr($course->instructor_title, 0, 20) }}</p>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-600">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span>{{ number_format($course->rating, 1) }}</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-users"></i>
                                <span>{{ number_format($course->students_count) }}</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-clock"></i>
                                <span>{{ $course->duration_hours }}h</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 text-lg">No courses found matching your criteria.</p>
                    <a href="{{ route('courses.index') }}" class="text-purple-600 hover:text-purple-700 mt-2 inline-block">View all courses</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
            <div class="mt-12">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
@endsection
