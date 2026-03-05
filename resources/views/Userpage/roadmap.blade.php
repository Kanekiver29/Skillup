@extends('layout.app')

@section('title', 'My Learning Roadmap')

@section('content')
<div class="container mx-auto p-6">
    @if($enrollments->count() > 0)
    <!-- Header -->
    <header class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">My Learning Roadmap</h1>
                <p class="text-sm text-gray-600 mt-1">Track your learning journey and see your progress</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Overall Progress</p>
                <div class="flex items-center justify-end gap-2">
                    <span class="text-3xl font-bold text-purple-600">{{ $overallProgress }}%</span>
                </div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mt-4 bg-gray-200 rounded-full h-4 overflow-hidden">
            <div class="gradient-primary h-full rounded-full transition-all duration-500" style="width: {{ $overallProgress }}%"></div>
        </div>
        
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ $totalCompleted }}</div>
                <div class="text-sm text-gray-500">Completed</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-orange-600">{{ $inProgressCourses->count() }}</div>
                <div class="text-sm text-gray-500">In Progress</div>
            </div>
            <div class="bg-white shadow rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $totalEnrolled }}</div>
                <div class="text-sm text-gray-500">Total Enrolled</div>
            </div>
        </div>
    </header>

    <!-- Main Roadmap Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Completed Courses -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg p-6 mb-4">
                <div class="flex items-center gap-6 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Completed</h2>
                </div>
                
                @if($completedCourses->count() > 0)
                    <div class="space-y-3">
                        @foreach($completedCourses as $enrollment)
                            <div class="p-3 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800 text-sm">{{ $enrollment->course->course_title }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : 'Completed' }}
                                        </p>
                                        <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="text-xs text-green-600 hover:text-green-800 mt-2 inline-block">
                                            View Certificate →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No completed courses yet. Start learning!</p>
                @endif
            </div>
        </div>

        <!-- In Progress Courses -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-spinner text-orange-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">In Progress</h2>
                </div>
                
                @if($inProgressCourses->count() > 0)
                    <div class="space-y-3">
                        @foreach($inProgressCourses as $enrollment)
                            <div class="p-3 bg-orange-50 border border-orange-200 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-play text-white text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800 text-sm">{{ $enrollment->course->course_title }}</h3>
                                        <div class="mt-2">
                                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                                <span>Progress</span>
                                                <span>{{ $enrollment->progress }}%</span>
                                            </div>
                                            <div class="bg-gray-200 rounded-full h-2">
                                                <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                                            </div>
                                        </div>
                                        <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="text-xs text-orange-600 hover:text-orange-800 mt-2 inline-block">
                                            Continue Learning →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No courses in progress. Enroll in a course!</p>
                @endif
            </div>
        </div>

        <!-- Not Started Courses -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-gray-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Not Started</h2>
                </div>
                
                @if($notStartedCourses->count() > 0)
                    <div class="space-y-3">
                        @foreach($notStartedCourses as $enrollment)
                            <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <i class="fas fa-book text-white text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800 text-sm">{{ $enrollment->course->course_title }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $enrollment->course->modules_count ?? 0 }} modules
                                        </p>
                                        <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="text-xs text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                            Start Learning →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">All enrolled courses started!</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Learning Path Timeline -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Learning Journey Timeline</h2>
        
        <div class="relative pl-4 lg:pl-12 overflow-x-hidden">
            <!-- Timeline Line -->
            <!-- on small screens shift the line a bit so it doesn't overlap the viewport
                 start below the first dot to allow for padding -->
            <div class="absolute lg:left-4 left-2 top-4 bottom-0 w-0.5 bg-gradient-to-b from-green-500 via-orange-500 to-gray-300"></div>
            
            <!-- Timeline Items -->
            <div class="space-y-6">
                @foreach($enrollments as $enrollment)
                    <div class="relative lg:pl-12 pl-10">
                        <!-- Timeline Dot -->
                        <div class="absolute left-0 top-1 w-8 h-8 rounded-full flex items-center justify-center 
                            {{ $enrollment->completed ? 'bg-green-500' : ($enrollment->progress > 0 ? 'bg-orange-500' : 'bg-gray-300') }}">
                            @if($enrollment->completed)
                                <i class="fas fa-check text-white text-xs"></i>
                            @elseif($enrollment->progress > 0)
                                <i class="fas fa-play text-white text-xs"></i>
                            @else
                                <i class="fas fa-circle text-white text-xs"></i>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="block">
                            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $enrollment->course->course_title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $enrollment->course->category ?? 'Uncategorized' }}</p>
                                        <p class="text-xs text-gray-400 mt-1">Enrolled {{ $enrollment->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        {{ $enrollment->completed ? 'bg-green-100 text-green-700' : ($enrollment->progress > 0 ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700') }}">
                                        {{ $enrollment->completed ? 'Completed' : ($enrollment->progress > 0 ? $enrollment->progress . '%' : 'Not Started') }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($enrollment->progress > 0 && !$enrollment->completed)
                                <div class="mt-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="gradient-primary h-2 rounded-full transition-all" style="width: {{ $enrollment->progress }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-3 flex items-center gap-4 text-xs text-gray-500">
                                <span><i class="fas fa-layer-group mr-1"></i> {{ $enrollment->course->modules_count ?? 0 }} modules</span>
                                <span><i class="fas fa-clock mr-1"></i> {{ $enrollment->course->duration_hours ?? 0 }} hours</span>
                                <span><i class="fas fa-signal mr-1"></i> {{ $enrollment->course->level }}</span>
                            </div>
                            <div class="mt-2 text-right">
                                <span class="text-xs font-medium text-purple-600 hover:text-purple-800">View course details →</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Skills Development -->
    @if($userSkills && count($userSkills) > 0)
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Skills Development</h2>
        <div class="flex flex-wrap gap-3">
            @foreach($userSkills as $skill)
                <div class="px-4 py-2 bg-gradient-to-r from-purple-100 to-indigo-100 rounded-full flex items-center gap-2">
                    <i class="fas fa-star text-yellow-500 text-xs"></i>
                    <span class="text-sm font-medium text-gray-700">{{ $skill }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Course Categories -->
    @if($coursesByCategory && $coursesByCategory->count() > 0)
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Explore More Courses</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($coursesByCategory as $category => $courses)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-purple-300 transition cursor-pointer">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-folder text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">{{ $category }}</h3>
                            <p class="text-xs text-gray-500">{{ $courses->count() }} courses</p>
                        </div>
                    </div>
                    <a href="{{ route('courses.index') }}?category={{ urlencode($category) }}" class="text-sm text-purple-600 hover:text-purple-800">
                        Browse {{ $category }} →
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="bg-white shadow rounded-lg p-12 text-center">
        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-route text-purple-600 text-3xl"></i>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Start Your Learning Journey</h2>
        <p class="text-gray-500 mb-6">You haven't enrolled in any courses yet. Browse our catalog to begin your learning path!</p>
        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 gradient-primary text-white font-medium rounded-lg hover:opacity-90 transition">
            <i class="fas fa-compass mr-2"></i>
            Browse Courses
        </a>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('courses.index') }}" class="p-4 bg-white shadow rounded-lg hover:shadow-lg transition flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-search text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-medium text-gray-800">Find New Courses</h3>
                <p class="text-sm text-gray-500">Explore our catalog</p>
            </div>
        </a>
        
        <a href="{{ route('courses.my-learning') }}" class="p-4 bg-white shadow rounded-lg hover:shadow-lg transition flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book-reader text-orange-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-medium text-gray-800">My Learning</h3>
                <p class="text-sm text-gray-500">Continue learning</p>
            </div>
        </a>
        
        <a href="{{ route('userpage.profile-edit') }}" class="p-4 bg-white shadow rounded-lg hover:shadow-lg transition flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-cog text-purple-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-medium text-gray-800">Update Profile</h3>
                <p class="text-sm text-gray-500">Add your skills</p>
            </div>
        </a>
    </div>
</div>
@endsection
