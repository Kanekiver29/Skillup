@extends('layout.app')

@section('title', $course->title . ' - SkillUp')

@section('content')
    <!-- Course Header -->
    <div class="pt-6 gradient-primary text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                <!-- Course Info -->
                <div class="md:col-span-2">
                    <div class="mb-4">
                        <span class="inline-block bg-purple-400 px-3 py-1 rounded-full text-sm font-semibold">{{ $course->category }}</span>
                        <span class="inline-block ml-3 bg-purple-400 px-3 py-1 rounded-full text-sm font-semibold">{{ $course->level }}</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $course->title }}</h1>
                    <p class="text-lg text-purple-100 mb-6">{{ $course->short_description }}</p>
                    <div class="flex items-center space-x-6 text-sm">
                        <div>
                            <i class="fas fa-star text-yellow-300 mr-2"></i>
                            <span class="font-semibold">{{ number_format($course->rating, 1) }}/5.0</span>
                        </div>
                        <div>
                            <i class="fas fa-users text-purple-200 mr-2"></i>
                            <span>{{ number_format($course->students_count) }} students</span>
                        </div>
                        <div>
                            <i class="fas fa-clock text-purple-200 mr-2"></i>
                            <span>{{ $course->duration_hours }} hours</span>
                        </div>
                    </div>
                </div>

                <!-- Instructor Card -->
                <div class="bg-white bg-opacity-10 rounded-lg p-6 backdrop-blur-sm">
                    <div class="text-center">
                        <div class="w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold">{{ $course->instructor_name }}</h3>
                        <p class="text-purple-100 text-sm">{{ $course->instructor_title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Course Details -->
            <div class="lg:col-span-2">
                <!-- About Section -->
                <section class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">About This Course</h2>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $course->description }}</p>
                </section>

                <!-- Learning Outcomes -->
                <section class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">What You'll Learn</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Build Responsive Websites</h4>
                                <p class="text-gray-600 text-sm">Create beautiful, mobile-first websites that work on all devices</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Master Web Standards</h4>
                                <p class="text-gray-600 text-sm">Learn HTML5, CSS3, and JavaScript best practices</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Real-World Projects</h4>
                                <p class="text-gray-600 text-sm">Build portfolio-ready projects used in production</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500 text-xl mt-1"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Industry-Ready Skills</h4>
                                <p class="text-gray-600 text-sm">Gain the skills top companies want in junior developers</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Course Curriculum -->
                <section>
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Course Curriculum</h2>
                    <div class="space-y-4">
                        @forelse($course->lessons as $lesson)
                            <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <i class="fas fa-play-circle text-purple-600"></i>
                                            <h4 class="font-semibold text-gray-800">{{ $lesson->title }}</h4>
                                        </div>
                                        <p class="text-gray-600 text-sm ml-7">{{ $lesson->description }}</p>
                                    </div>
                                    <span class="text-sm text-gray-500 font-medium">{{ $lesson->duration_minutes }} mins</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600">No lessons available yet.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Right Column - Enrollment Card -->
            <div>
                <div class="bg-white rounded-lg shadow-lg p-8 sticky top-24">
                    {{-- Course Preview Image --}}
                    <div class="mb-6 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg h-48 flex items-center justify-center">
                        <i class="fas fa-image text-white text-6xl opacity-30"></i>
                    </div>

                    {{-- Enrollment Status --}}
                    @if($isEnrolled)
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center space-x-2 text-green-700">
                                <i class="fas fa-check-circle"></i>
                                <span class="font-semibold">You're enrolled</span>
                            </div>
                        </div>

                        {{-- Enroll Button (if not enrolled) --}}
                    @else
                        <form action="{{ route('courses.enroll', $course->slug) }}" method="POST" class="mb-6">
                            @csrf
                            <button type="submit" class="w-full gradient-primary text-white font-bold py-3 rounded-lg hover:shadow-lg transition transform hover:scale-105">
                                <i class="fas fa-arrow-right mr-2"></i>Enroll Now
                            </button>
                        </form>
                    @endif

                    {{-- Course Details --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-4 border-b">
                            <span class="text-gray-600">Duration</span>
                            <span class="font-semibold text-gray-800">{{ $course->duration_hours }} hours</span>
                        </div>
                        <div class="flex items-center justify-between pb-4 border-b">
                            <span class="text-gray-600">Level</span>
                            <span class="font-semibold text-gray-800">{{ $course->level }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-4 border-b">
                            <span class="text-gray-600">Lessons</span>
                            <span class="font-semibold text-gray-800">{{ $course->lessons->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Rating</span>
                            <div>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="font-semibold text-gray-800 ml-1">{{ number_format($course->rating, 1) }}/5</span>
                            </div>
                        </div>
                    </div>

                    {{-- Share Course --}}
                    <div class="mt-8 pt-8 border-t">
                        <h4 class="font-semibold text-gray-800 mb-4">Share This Course</h4>
                        <div class="flex space-x-3">
                            <a href="#" class="flex-1 bg-blue-500 text-white p-3 rounded text-center hover:bg-blue-600 transition">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="flex-1 bg-blue-400 text-white p-3 rounded text-center hover:bg-blue-500 transition">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="flex-1 bg-red-500 text-white p-3 rounded text-center hover:bg-red-600 transition">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

