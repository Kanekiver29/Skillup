@extends('layout.app')

@section('title', 'My Profile - SkillUp')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Profile Header Banner -->
    <div class="gradient-primary text-white pt-16 pb-20 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Back Button -->
            <a href="/courses" class="inline-flex items-center text-purple-100 hover:text-white mb-6 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Learning
            </a>

                <!-- Profile Hero -->
            <div class="flex flex-col md:flex-row items-start md:items-end gap-6 mb-8">
                <!-- Avatar -->
                <div class="relative">
                    <div class="w-32 h-32 bg-white rounded-full border-4 border-purple-300 flex items-center justify-center text-5xl font-bold text-purple-600 shadow-lg">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <button class="absolute bottom-0 right-0 bg-pink-600 hover:bg-pink-700 text-white p-3 rounded-full shadow-lg transition">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>

                <!-- Basic Info -->
                <div class="flex-1">
                    <h1 class="text-4xl md:text-5xl font-bold mb-2">{{ $user->name }}</h1>
                    <p class="text-xl text-purple-100 mb-4">{{ $user->location ?? 'Career in Progress' }}</p>
                    <div class="flex flex-wrap gap-4">
                        @if($user->location)
                            <div class="bg-purple-500 bg-opacity-30 px-4 py-2 rounded-full">
                                <i class="fas fa-map-marker-alt mr-2"></i> {{ $user->location }}
                            </div>
                        @endif
                        <div class="bg-purple-500 bg-opacity-30 px-4 py-2 rounded-full">
                            <i class="fas fa-calendar mr-2"></i> Joined {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>

                <!-- Edit Button -->
                <a href="{{ route('userpage.profile-edit') }}" class="px-6 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition inline-block">
                    <i class="fas fa-edit mr-2"></i> Edit Profile
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white bg-opacity-10 backdrop-blur p-4 rounded-lg">
                    <div class="text-3xl font-bold">{{ count($user->skills ?? []) }}</div>
                    <p class="text-purple-100 text-sm">Skills</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur p-4 rounded-lg">
                    <div class="text-3xl font-bold">{{ $completedCourses }}</div>
                    <p class="text-purple-100 text-sm">Courses Completed</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur p-4 rounded-lg">
                    <div class="text-3xl font-bold">{{ $user->enrollments()->count() }}</div>
                    <p class="text-purple-100 text-sm">Total Enrollments</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur p-4 rounded-lg">
                    <div class="text-3xl font-bold">{{ auth()->user()->id === $user->id ? 'You' : 'Member' }}</div>
                    <p class="text-purple-100 text-sm">Status</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About Section -->
                <section class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user text-purple-600 mr-3"></i> About Me
                    </h2>
                    @if($user->bio)
                        <p class="text-gray-700 leading-relaxed mb-4">
                            {{ $user->bio }}
                        </p>
                    @else
                        <p class="text-gray-500 italic">No bio yet. <a href="{{ route('userpage.profile-edit') }}" class="text-purple-600 hover:text-purple-700">Add one</a></p>
                    @endif
                    <div class="flex gap-3">
                        @if($user->github_url)
                            <a href="{{ $user->github_url }}" target="_blank" class="text-gray-600 hover:text-purple-600 transition p-2">
                                <i class="fab fa-github text-xl"></i>
                            </a>
                        @endif
                        @if($user->portfolio_url)
                            <a href="{{ $user->portfolio_url }}" target="_blank" class="text-gray-600 hover:text-purple-600 transition p-2">
                                <i class="fas fa-globe text-xl"></i>
                            </a>
                        @endif
                    </div>
                </section>

                <!-- Current Learning Paths -->
                <section class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-map text-blue-600 mr-3"></i> Active Learning Paths
                    </h2>
                    <div class="space-y-4">
                        <!-- Path 1 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="font-semibold text-gray-800">Full Stack Web Development</h3>
                                    <p class="text-sm text-gray-600">Frontend + Backend + Databases</p>
                                </div>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">In Progress</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full" style="width: 68%"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">17 of 25 Courses Completed</p>
                        </div>

                        <!-- Path 2 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="font-semibold text-gray-800">UI/UX Design Fundamentals</h3>
                                    <p class="text-sm text-gray-600">Design Principles & Tools</p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">In Progress</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-gradient-to-r from-yellow-400 to-pink-500 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">9 of 20 Courses Completed</p>
                        </div>

                        <!-- Path 3 -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="font-semibold text-gray-800">Data Science Essentials</h3>
                                    <p class="text-sm text-gray-600">Python, Analytics & Visualization</p>
                                </div>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">15 of 15 Courses Completed</p>
                        </div>
                    </div>
                </section>

                <!-- Skills Section -->
                <section class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-star text-orange-500 mr-3"></i> Skills & Expertise
                    </h2>
                    @if($user->skills && count($user->skills) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @forelse($user->skills as $skill)
                                <div class="bg-gradient-to-br from-purple-100 to-purple-50 border border-purple-200 p-3 rounded-lg text-center hover:shadow-md transition cursor-pointer">
                                    <p class="font-semibold text-gray-800 text-sm">{{ $skill }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 italic col-span-full">No skills added yet. <a href="{{ route('userpage.profile-edit') }}" class="text-purple-600 hover:text-purple-700">Add skills</a></p>
                            @endforelse
                        </div>
                    @else
                        <p class="text-gray-500 italic">No skills added yet. <a href="{{ route('userpage.profile-edit') }}" class="text-purple-600 hover:text-purple-700">Add your skills</a></p>
                    @endif
                </section>

                <!-- Portfolio Section -->
                <section class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-briefcase text-green-600 mr-3"></i> Portfolio Projects
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Project 1 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 h-32 flex items-center justify-center">
                                <i class="fas fa-code text-white text-4xl opacity-20"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-1">E-Learning Platform</h3>
                                <p class="text-sm text-gray-600 mb-3">Full-stack web application using React and Node.js</p>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">React</span>
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Node.js</span>
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">MongoDB</span>
                                </div>
                                <div class="flex gap-2">
                                    <button class="flex-1 py-2 bg-purple-100 text-purple-600 rounded text-sm font-semibold hover:bg-purple-200 transition">
                                        View Project
                                    </button>
                                    <button class="flex-1 py-2 border border-gray-300 text-gray-600 rounded text-sm font-semibold hover:bg-gray-50 transition">
                                        GitHub
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Project 2 -->
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                            <div class="bg-gradient-to-br from-pink-400 to-pink-600 h-32 flex items-center justify-center">
                                <i class="fas fa-palette text-white text-4xl opacity-20"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-1">Portfolio Website</h3>
                                <p class="text-sm text-gray-600 mb-3">Responsive personal portfolio with modern design</p>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">React</span>
                                    <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">Tailwind</span>
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">Figma</span>
                                </div>
                                <div class="flex gap-2">
                                    <button class="flex-1 py-2 bg-pink-100 text-pink-600 rounded text-sm font-semibold hover:bg-pink-200 transition">
                                        View Project
                                    </button>
                                    <button class="flex-1 py-2 border border-gray-300 text-gray-600 rounded text-sm font-semibold hover:bg-gray-50 transition">
                                        GitHub
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="mt-4 w-full py-3 border-2 border-purple-600 text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
                        <i class="fas fa-plus mr-2"></i> Add Project
                    </button>
                </section>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Badges Section -->
                <section class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-award text-yellow-500 mr-2"></i> Badges
                    </h2>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="text-center hover:scale-110 transition cursor-pointer" title="Quick Learner">
                            <div class="text-4xl mb-2">🏃</div>
                            <p class="text-xs font-semibold text-gray-600">Quick Learner</p>
                        </div>
                        <div class="text-center hover:scale-110 transition cursor-pointer" title="First Steps">
                            <div class="text-4xl mb-2">👣</div>
                            <p class="text-xs font-semibold text-gray-600">First Steps</p>
                        </div>
                        <div class="text-center hover:scale-110 transition cursor-pointer" title="Code Master">
                            <div class="text-4xl mb-2">💻</div>
                            <p class="text-xs font-semibold text-gray-600">Code Master</p>
                        </div>
                        <div class="text-center hover:scale-110 transition cursor-pointer" title="Collaboration">
                            <div class="text-4xl mb-2">🤝</div>
                            <p class="text-xs font-semibold text-gray-600">Team Player</p>
                        </div>
                        <div class="text-center hover:scale-110 transition cursor-pointer" title="30-Day Streak">
                            <div class="text-4xl mb-2">🔥</div>
                            <p class="text-xs font-semibold text-gray-600">30-Day Streak</p>
                        </div>
                        <div class="text-center hover:scale-110 transition cursor-pointer" title="Rising Star">
                            <div class="text-4xl mb-2">⭐</div>
                            <p class="text-xs font-semibold text-gray-600">Rising Star</p>
                        </div>
                    </div>
                </section>

                <!-- Mentorship -->
                <section class="bg-gradient-to-br from-indigo-50 to-blue-50 border border-indigo-200 p-6 rounded-lg">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-tie text-indigo-600 mr-2"></i> My Mentor
                    </h2>
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-indigo-600 rounded-full mx-auto mb-3 flex items-center justify-center text-white text-2xl font-bold">
                            SK
                        </div>
                        <h3 class="font-semibold text-gray-800">Sarah Kim</h3>
                        <p class="text-sm text-gray-600">Senior Product Designer</p>
                        <p class="text-xs text-gray-500 mt-1">Meta Design</p>
                    </div>
                    <button class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-semibold">
                        <i class="fas fa-calendar mr-2"></i> Schedule Session
                    </button>
                </section>

                <!-- Learning Streak -->
                <section class="bg-gradient-to-br from-orange-50 to-red-50 border border-orange-200 p-6 rounded-lg">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-fire text-orange-500 mr-2"></i> Learning Streak
                    </h2>
                    <div class="text-center mb-4">
                        <div class="text-5xl font-bold text-orange-500 mb-2">27</div>
                        <p class="text-gray-600">Days in a Row</p>
                    </div>
                    <p class="text-sm text-gray-600 text-center">Keep it up! You're making amazing progress.</p>
                </section>

                <!-- Goals -->
                <section class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-target text-red-500 mr-2"></i> Goals
                    </h2>
                    <div class="space-y-3">
                        <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">Complete Full Stack Path</p>
                                    <p class="text-xs text-gray-600 mt-1">68% complete</p>
                                </div>
                                <i class="fas fa-check text-green-500"></i>
                            </div>
                        </div>
                        <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">Build 5 Portfolio Projects</p>
                                    <p class="text-xs text-gray-600 mt-1">2 of 5 completed</p>
                                </div>
                                <i class="fas fa-circle-notch text-blue-500"></i>
                            </div>
                        </div>
                        <div class="p-3 bg-purple-50 border border-purple-200 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">Land First Tech Job</p>
                                    <p class="text-xs text-gray-600 mt-1">In progress</p>
                                </div>
                                <i class="fas fa-circle-notch text-purple-500"></i>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Recent Activity -->
                <section class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="space-y-3 text-sm">
                        <div class="pb-3 border-b border-gray-100">
                            <p class="text-gray-700"><strong>Completed:</strong> JavaScript Basics</p>
                            <p class="text-gray-500 text-xs">2 days ago</p>
                        </div>
                        <div class="pb-3 border-b border-gray-100">
                            <p class="text-gray-700"><strong>Earned:</strong> Code Master Badge</p>
                            <p class="text-gray-500 text-xs">5 days ago</p>
                        </div>
                        <div class="pb-3 border-b border-gray-100">
                            <p class="text-gray-700"><strong>Started:</strong> React Advanced Course</p>
                            <p class="text-gray-500 text-xs">1 week ago</p>
                        </div>
                        <div class="pb-3">
                            <p class="text-gray-700"><strong>Connected with:</strong> Sarah Kim (Mentor)</p>
                            <p class="text-gray-500 text-xs">2 weeks ago</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
