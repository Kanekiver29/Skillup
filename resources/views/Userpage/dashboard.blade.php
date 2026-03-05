@extends('layout.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container mx-auto p-6">
  <!-- Header -->
  <header class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-3xl font-semibold">My Dashboard</h1>
      <p class="text-sm text-gray-600">Welcome back, {{ $user->name }}</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('userpage.profile-edit') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Edit Profile
      </a>
    </div>
  </header>

  @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
      {{ session('success') }}
    </div>
  @endif

  <!-- Stats Section -->
  <section class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Completed Courses</div>
      <div class="text-3xl font-bold text-blue-600">{{ $completedCourses }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">In Progress</div>
      <div class="text-3xl font-bold text-orange-600">{{ $inProgressCourses }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Total Hours</div>
      <div class="text-3xl font-bold text-green-600">{{ $totalHours }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Badges Earned</div>
      <div class="text-3xl font-bold text-purple-600">{{ $badges }}</div>
    </div>
  </section>

  <!-- Profile Section -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- User Profile Card -->
    <div class="lg:col-span-1 bg-white shadow rounded p-6">
      <h2 class="text-xl font-semibold mb-4">Profile</h2>
      
      @if($user->profile_image)
        <div class="mb-4 text-center">
          <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}" 
               alt="{{ $user->name }}" 
               class="w-32 h-32 rounded-full mx-auto object-cover">
        </div>
      @else
        <div class="mb-4 text-center">
          <div class="w-32 h-32 rounded-full mx-auto bg-gray-200 flex items-center justify-center">
            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      @endif

      <div class="space-y-3 text-sm">
        <div>
          <span class="text-gray-600 font-medium">Name:</span>
          <p class="text-gray-800">{{ $user->name }}</p>
        </div>
        <div>
          <span class="text-gray-600 font-medium">Email:</span>
          <p class="text-gray-800">{{ $user->email }}</p>
        </div>
        <div>
          <span class="text-gray-600 font-medium">Username:</span>
          <p class="text-gray-800">{{ $user->username }}</p>
        </div>
        @if($user->bio)
          <div>
            <span class="text-gray-600 font-medium">Bio:</span>
            <p class="text-gray-800">{{ $user->bio }}</p>
          </div>
        @endif
        @if($user->location)
          <div>
            <span class="text-gray-600 font-medium">Location:</span>
            <p class="text-gray-800">{{ $user->location }}</p>
          </div>
        @endif
        <div>
          <span class="text-gray-600 font-medium">Joined:</span>
          <p class="text-gray-800">{{ $user->created_at->format('M d, Y') }}</p>
        </div>
      </div>

      <div class="mt-4 pt-4 border-t">
        <a href="{{ route('userpage.profile') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
          View Full Profile →
        </a>
      </div>
    </div>

    <!-- Enrolled Courses -->
    <div class="lg:col-span-2 bg-white shadow rounded p-6">
      <h2 class="text-xl font-semibold mb-4">Your Courses</h2>
      
      @if($enrollments->count() > 0)
        <div class="space-y-3">
          @foreach($enrollments as $enrollment)
            <div class="flex items-start justify-between p-4 bg-gray-50 rounded border border-gray-200">
              <div class="flex-1">
                <h3 class="font-semibold text-gray-800">{{ $enrollment->course->course_title }}</h3>
                <p class="text-sm text-gray-600">{{ Str::limit($enrollment->course->description, 100) }}</p>
                <div class="mt-2 flex gap-4 text-xs text-gray-500">
                  <span>Progress: <span class="font-semibold text-gray-700">{{ $enrollment->progress ?? 0 }}%</span></span>
                  <span>Status: <span class="font-semibold text-gray-700">{{ ucfirst($enrollment->status ?? 'not started') }}</span></span>
                </div>
              </div>
              <div class="ml-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                  <span class="text-sm font-bold text-blue-600">{{ $enrollment->progress ?? 0 }}%</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-4 pt-4 border-t">
          <a href="{{ route('courses.my-learning') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
            View All Courses →
          </a>
        </div>
      @else
        <div class="text-center py-8 text-gray-500">
          <p class="mb-3">You haven't enrolled in any courses yet.</p>
          <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
            Browse Courses
          </a>
        </div>
      @endif
    </div>
  </div>

  <!-- Skills Section (if available) -->
  @if($user->skills && count($user->skills) > 0)
    <div class="bg-white shadow rounded p-6 mb-6">
      <h2 class="text-xl font-semibold mb-4">Skills</h2>
      <div class="flex flex-wrap gap-2">
        @foreach($user->skills as $skill)
          <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
            {{ $skill }}
          </span>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Quick Links -->
  <div class="bg-white shadow rounded p-6">
    <h2 class="text-xl font-semibold mb-4">Quick Links</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <a href="{{ route('courses.index') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
        <h3 class="font-semibold mb-1">Browse Courses</h3>
        <p class="text-sm text-gray-600">Explore new learning paths</p>
      </a>
      <a href="{{ route('courses.my-learning') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
        <h3 class="font-semibold mb-1">My Learning</h3>
        <p class="text-sm text-gray-600">Continue your courses</p>
      </a>
      <a href="{{ route('userpage.profile-edit') }}" class="p-4 border border-gray-200 rounded hover:bg-gray-50 transition">
        <h3 class="font-semibold mb-1">Edit Profile</h3>
        <p class="text-sm text-gray-600">Update your information</p>
      </a>
    </div>
  </div>
</div>
@endsection
