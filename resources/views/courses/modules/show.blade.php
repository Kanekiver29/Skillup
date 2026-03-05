@extends('layout.app')

@section('title', $module->title . ' - ' . $course->title . ' - SkillUp')

@section('content')
    <!-- Module Header -->
    <div class="pt-6 gradient-primary text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-4">
                <a href="{{ route('courses.show', $course->slug) }}" class="text-purple-100 hover:text-white flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to {{ $course->title }}
                </a>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $module->title }}</h1>
            <p class="text-lg text-purple-100 mb-6">{{ $module->description }}</p>
            <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm max-w-md">
                <div class="flex items-center justify-between">
                    <span class="font-semibold">Module Progress</span>
                    <span class="text-2xl font-bold">{{ $userProgress }}%</span>
                </div>
                <div class="w-full bg-white bg-opacity-20 rounded-full h-2 mt-4">
                    <div class="bg-green-400 h-2 rounded-full transition-all duration-300" style="width: {{ $userProgress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Module Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Module Description -->
                <section class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Module Overview</h2>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        <p>{{ $module->description }}</p>
                    </div>
                </section>

                <!-- Quizzes Section -->
                <section>
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Quizzes</h2>
                    @if($quizzes->count() > 0)
                        <div class="space-y-4">
                            @foreach($quizzes as $quiz)
                                @php
                                    $bestScore = $quiz->getUserBestScore(auth()->id());
                                    $hasUserPassed = $quiz->hasUserPassed(auth()->id());
                                    $attemptCount = $quiz->getUserAttemptCount(auth()->id());
                                    $canRetry = $quiz->canUserRetry(auth()->id());
                                @endphp
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">{{ $quiz->title }}</h3>
                                            <p class="text-gray-600 text-sm mt-2">{{ $quiz->description }}</p>
                                        </div>
                                        <div class="text-right">
                                            @if($hasUserPassed)
                                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-check-circle mr-1"></i>Passed
                                                </span>
                                            @elseif($attemptCount > 0)
                                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-times-circle mr-1"></i>Need Improvement
                                                </span>
                                            @else
                                                <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-play-circle mr-1"></i>Not Started
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Quiz Stats -->
                                    <div class="grid grid-cols-3 gap-4 mb-6">
                                        <div class="bg-gray-50 rounded p-3">
                                            <div class="text-sm text-gray-600">Best Score</div>
                                            <div class="text-2xl font-bold text-gray-800">{{ $bestScore }}%</div>
                                        </div>
                                        <div class="bg-gray-50 rounded p-3">
                                            <div class="text-sm text-gray-600">Attempts</div>
                                            <div class="text-2xl font-bold text-gray-800">{{ $attemptCount }}/{{ $quiz->attempt_limit }}</div>
                                        </div>
                                        <div class="bg-gray-50 rounded p-3">
                                            <div class="text-sm text-gray-600">Pass Score</div>
                                            <div class="text-2xl font-bold text-gray-800">{{ $quiz->passing_score }}%</div>
                                        </div>
                                    </div>

                                    <!-- Quiz Info -->
                                    <div class="flex flex-wrap gap-4 mb-6 text-sm text-gray-600">
                                        <div>
                                            <i class="fas fa-list mr-2"></i>
                                            <span>{{ $quiz->questions()->count() }} Questions</span>
                                        </div>
                                        @if($quiz->time_limit_minutes)
                                            <div>
                                                <i class="fas fa-clock mr-2"></i>
                                                <span>{{ $quiz->time_limit_minutes }} mins</span>
                                            </div>
                                        @endif
                                        <div>
                                            <i class="fas fa-repeat mr-2"></i>
                                            <span>{{ $quiz->attempt_limit }} attempts allowed</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-4">
                                        @if($canRetry || $attemptCount === 0)
                                            <a href="{{ route('quizzes.start', [$course->slug, $module->slug, $quiz->slug]) }}" 
                                               class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-lg px-6 py-3 hover:shadow-lg transition-all text-center">
                                                {{ $attemptCount > 0 ? 'Retry Quiz' : 'Start Quiz' }}
                                            </a>
                                        @else
                                            <button disabled class="flex-1 bg-gray-300 text-gray-600 font-semibold rounded-lg px-6 py-3 cursor-not-allowed text-center">
                                                Max Attempts Reached
                                            </button>
                                        @endif

                                        <a href="{{ route('quizzes.show', [$course->slug, $module->slug, $quiz->slug]) }}" 
                                           class="flex-1 bg-gray-100 text-gray-800 font-semibold rounded-lg px-6 py-3 hover:bg-gray-200 transition-all text-center">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600">No quizzes available for this module yet.</p>
                        </div>
                    @endif
                </section>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Module Info Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Module Information</h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <span class="text-gray-600">Course</span>
                            <p class="font-semibold text-gray-800">{{ $course->title }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Total Quizzes</span>
                            <p class="font-semibold text-gray-800">{{ $quizzes->count() }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Questions</span>
                            <p class="font-semibold text-gray-800">
                                {{ $quizzes->sum(function($q) { return $q->questions()->count(); }) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg shadow-lg p-6 text-white">
                    <h3 class="text-lg font-bold mb-4">Your Progress</h3>
                    <div class="text-center">
                        <div class="text-5xl font-bold mb-2">{{ $userProgress }}%</div>
                        <p class="text-purple-100 text-sm mb-4">Complete</p>
                        <div class="w-full bg-white bg-opacity-20 rounded-full h-2">
                            <div class="bg-white h-2 rounded-full transition-all duration-300" style="width: {{ $userProgress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
