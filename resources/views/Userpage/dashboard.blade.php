@extends('layout.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container mx-auto p-6">
  {{-- Back Button --}}
  <div class="mb-4">
    <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
      <i class="fas fa-arrow-left mr-2"></i> Back
    </a>
  </div>

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
      <div class="text-sm text-black mb-1">Completed Courses</div>
      <div class="text-3xl font-bold text-black">{{ $completedCourses }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-black mb-1">In Progress</div>
      <div class="text-3xl font-bold text-black">{{ $inProgressCourses }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-black mb-1">Total Hours</div>
      <div class="text-3xl font-bold text-black">{{ $totalHours }}</div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-black mb-1">Badges Earned</div>
      <div class="text-3xl font-bold text-black">{{ $badges }}</div>
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
                <h3 class="font-semibold text-black">{{ $enrollment->course->course_title }}</h3>
                <p class="text-sm text-black">{{ Str::limit($enrollment->course->description, 100) }}</p>
                <div class="mt-2 flex gap-4 text-xs text-black">
                  <span>Progress: <span class="font-semibold text-black">{{ $enrollment->progress ?? 0 }}%</span></span>
                  <span>Status: <span class="font-semibold text-black">{{ ucfirst($enrollment->status ?? 'not started') }}</span></span>
                </div>
              </div>
              <div class="ml-4">
                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                  <span class="text-sm font-bold text-black">{{ $enrollment->progress ?? 0 }}%</span>
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

  <!-- Certificates and Badges Section -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Certificates Section -->
    <div class="bg-white shadow rounded p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold flex items-center gap-3">
          <i class="fas fa-certificate text-amber-500"></i>
          My Certificates
        </h2>
        <a href="{{ route('certificates.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
          View All
        </a>
      </div>

      @if($completedCertificates->count())
        <div class="space-y-4">
          @foreach($completedCertificates as $enrollment)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
              <div class="flex flex-col gap-2">
                <p class="text-sm text-gray-500">Completed {{ $enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : 'Recently' }}</p>
                <h3 class="text-lg font-semibold text-gray-800">{{ $enrollment->course->course_title }}</h3>
                <div class="flex flex-wrap gap-2 mt-2">
                  <a href="{{ route('certificates.show', $enrollment->course->slug) }}" class="inline-flex items-center px-3 py-1 bg-amber-500 text-white rounded text-sm font-semibold hover:bg-amber-600 transition">
                    <i class="fas fa-eye mr-1"></i>View
                  </a>
                  <button type="button" onclick="window.open('{{ route('certificates.show', $enrollment->course->slug) }}?print=1', '_blank')" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded text-sm font-semibold hover:bg-blue-700 transition">
                    <i class="fas fa-file-download mr-1"></i>Save PDF
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-gray-500 italic">No completed certificates yet. Finish a course to unlock downloadable certificates.</p>
      @endif
    </div>

    <!-- Earned Badges Section -->
    <div class="bg-white shadow rounded p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold flex items-center gap-3">
          <i class="fas fa-award text-yellow-500"></i>
          Earned Badges
        </h2>
        <a href="{{ route('badges.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
          View All
        </a>
      </div>

      @if($earnedBadges->count())
        <div class="grid grid-cols-1 gap-4">
          @foreach($earnedBadges as $userBadge)
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition group">
              <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-700 flex items-center justify-center text-lg">
                  <i class="fas {{ $userBadge->badge->icon }}"></i>
                </div>
                <div>
                  <h3 class="font-semibold text-gray-800">{{ $userBadge->badge->name }}</h3>
                  <p class="text-xs uppercase text-gray-500">Earned {{ $userBadge->earned_at ? $userBadge->earned_at->format('M d, Y') : 'Recently' }}</p>
                </div>
              </div>
              <p class="text-gray-600 text-sm">{{ $userBadge->badge->description }}</p>
              <div class="mt-3 flex flex-wrap gap-2">
                <button type="button" onclick="copyBadgeDetails({{ json_encode($userBadge->badge->name) }}, {{ json_encode($userBadge->badge->description) }})" class="inline-flex items-center px-2 py-1 bg-indigo-600 text-white rounded text-xs font-semibold hover:bg-indigo-700 transition">
                  <i class="fas fa-copy mr-1"></i>Copy Info
                </button>
                <button type="button" onclick="alert('This badge has been earned for your achievement in {{ addslashes($userBadge->badge->name) }}.')" class="inline-flex items-center px-2 py-1 border border-gray-300 text-gray-700 rounded text-xs font-semibold hover:bg-gray-50 transition">
                  <i class="fas fa-info-circle mr-1"></i>Details
                </button>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-gray-500 italic">No badges earned yet. Complete quizzes and courses to earn badges here.</p>
      @endif
    </div>
  </div>

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

<script>
    function copyBadgeDetails(name, description) {
        const badgeText = `${name} - ${description}`;
        if (!navigator.clipboard) {
            window.prompt('Copy badge details:', badgeText);
            return;
        }

        navigator.clipboard.writeText(badgeText)
            .then(() => {
                alert('Badge details copied to clipboard!');
            })
            .catch(() => {
                window.prompt('Copy badge details:', badgeText);
            });
    }
</script>

@endsection
