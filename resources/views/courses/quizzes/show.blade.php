@extends('layout.app')

@section('title', $quiz->title . ' - ' . $module->title . ' - SkillUp')

@section('content')
    <!-- Quiz Header -->
    <div class="pt-6 gradient-primary text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-4">
                <a href="{{ route('modules.show', [$course->slug, $module->slug]) }}" class="text-purple-100 hover:text-white flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to {{ $module->title }}
                </a>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $quiz->title }}</h1>
            <p class="text-lg text-purple-100">{{ $quiz->description }}</p>
        </div>
    </div>

    <!-- Quiz Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Quiz Overview -->
                <section class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Quiz Overview</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 mb-6">
                        <p>{{ $quiz->description ?? 'Test your knowledge on this module topic.' }}</p>
                    </div>

                    <!-- Quiz Statistics -->
                    @if($userAttempts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-8">
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Best Score</p>
                                        <p class="text-3xl font-bold text-green-600">{{ $bestScore }}%</p>
                                    </div>
                                    <i class="fas fa-star text-green-500 text-3xl opacity-20"></i>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Attempts Used</p>
                                        <p class="text-3xl font-bold text-blue-600">{{ $attemptCount }}/{{ $quiz->attempt_limit }}</p>
                                    </div>
                                    <i class="fas fa-edit text-blue-500 text-3xl opacity-20"></i>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Status</p>
                                        <p class="text-xl font-bold">
                                            @if($hasUserPassed)
                                                <span class="text-green-600">✓ Passed</span>
                                            @else
                                                <span class="text-red-600">Need Improvement</span>
                                            @endif
                                        </p>
                                    </div>
                                    <i class="fas fa-check-circle text-purple-500 text-3xl opacity-20"></i>
                                </div>
                            </div>
                        </div>
                    @endif
                </section>

                <!-- Attempt History -->
                @if($userAttempts->count() > 0)
                    <section class="bg-white rounded-lg shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Attempt History</h2>
                        <div class="space-y-4">
                            @foreach($userAttempts as $attempt)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Attempt #{{ $attempt->attempt_number }}</h4>
                                            <p class="text-sm text-gray-600">{{ $attempt->completed_at?->format('M d, Y H:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold 
                                                @if($attempt->passed) text-green-600 @else text-red-600 @endif">
                                                {{ $attempt->score_percentage }}%
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $attempt->correct_answers }}/{{ $attempt->total_questions }} correct</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 mt-4 text-sm">
                                        <span class="flex items-center text-gray-600">
                                            <i class="fas fa-clock mr-2"></i>
                                            {{ $attempt->getFormattedTimeSpent() }}
                                        </span>
                                        @if($attempt->passed)
                                            <span class="flex items-center text-green-600">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Passed ({{ $quiz->passing_score }}% required)
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('quizzes.results', [$course->slug, $module->slug, $quiz->slug, $attempt->id]) }}" 
                                           class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
                                            View Results <i class="fas fa-arrow-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Quiz Details -->
                <section class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Quiz Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 text-2xl text-purple-500">
                                <i class="fas fa-list"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Questions</h4>
                                <p class="text-gray-600">{{ $quiz->questions()->count() }} questions in this quiz</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 text-2xl text-purple-500">
                                <i class="fas fa-target"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Passing Score</h4>
                                <p class="text-gray-600">{{ $quiz->passing_score }}% required to pass</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 text-2xl text-purple-500">
                                <i class="fas fa-hourglass-end"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Time Limit</h4>
                                <p class="text-gray-600">
                                    @if($quiz->time_limit_minutes)
                                        {{ $quiz->time_limit_minutes }} minutes
                                    @else
                                        No time limit
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 text-2xl text-purple-500">
                                <i class="fas fa-redo"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Attempts</h4>
                                <p class="text-gray-600">{{ $quiz->attempt_limit }} attempts allowed</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Action Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6 sticky top-24">
                    @if($canRetry || $attemptCount === 0)
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ready to Start?</h3>
                        <p class="text-gray-600 text-sm mb-6">
                            @if($attemptCount === 0)
                                You haven't started this quiz yet. Click below to begin!
                            @else
                                You can still retry this quiz. {{ $quiz->attempt_limit - $attemptCount }} attempt(s) remaining.
                            @endif
                        </p>
                        <a href="{{ route('quizzes.start', [$course->slug, $module->slug, $quiz->slug]) }}" 
                           class="w-full block bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold rounded-lg px-6 py-3 text-center hover:shadow-lg transition-all">
                            {{ $attemptCount > 0 ? 'Retry Quiz' : 'Start Quiz' }}
                        </a>
                    @else
                        <div class="bg-red-50 rounded-lg p-6 text-center">
                            <i class="fas fa-lock text-3xl text-red-500 mb-3"></i>
                            <h3 class="text-lg font-bold text-red-600 mb-2">No Attempts Left</h3>
                            <p class="text-red-600 text-sm">You've used all {{ $quiz->attempt_limit }} attempts for this quiz.</p>
                            @if(!$hasUserPassed)
                                <p class="text-red-600 text-sm mt-2">Contact your instructor for more attempts.</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Info Card -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Tips
                    </h3>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li>✓ Review all material before starting</li>
                        <li>✓ Read each question carefully</li>
                        <li>✓ You can review your answers before submitting</li>
                        @if($quiz->show_correct_answers)
                            <li>✓ Correct answers will be shown after completion</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
