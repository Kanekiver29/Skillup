@extends('layout.app')

@section('title', 'Quiz Results - ' . $quiz->title . ' - SkillUp')

@section('content')
    <!-- Results Header -->
    <div class="pt-6 gradient-primary text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-4">
                <a href="{{ route('quizzes.show', [$course->slug, $module->slug, $quiz->slug]) }}" class="text-purple-100 hover:text-white flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Quiz
                </a>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Quiz Results</h1>
            <p class="text-lg text-purple-100">{{ $quiz->title }} - Attempt #{{ $attempt->attempt_number }}</p>
        </div>
    </div>

    <!-- Results Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Score Card -->
        <div class="mb-12">
            <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <!-- Score Display -->
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 text-white p-12 flex flex-col items-center justify-center">
                        <div class="text-6xl font-bold mb-4">{{ $attempt->score_percentage }}%</div>
                        <div class="text-2xl font-semibold">
                            @if($attempt->passed)
                                <span class="flex items-center">
                                    <i class="fas fa-check-circle mr-3"></i>
                                    Passed!
                                </span>
                            @else
                                <span class="flex items-center">
                                    <i class="fas fa-times-circle mr-3"></i>
                                    Not Passed
                                </span>
                            @endif
                        </div>
                        <p class="text-purple-100 text-sm mt-4">Passing Score: {{ $quiz->passing_score }}%</p>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gray-50 p-12 flex flex-col justify-center border-l border-gray-200">
                        <div class="mb-8">
                            <p class="text-gray-600 text-sm font-semibold mb-2">Correct Answers</p>
                            <p class="text-4xl font-bold text-green-600">{{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Time Spent</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $attempt->getFormattedTimeSpent() }}</p>
                        </div>
                    </div>

                    <!-- Attempt Info -->
                    <div class="bg-gray-50 p-12 flex flex-col justify-center border-l border-gray-200">
                        <div class="mb-8">
                            <p class="text-gray-600 text-sm font-semibold mb-2">Attempt Number</p>
                            <p class="text-4xl font-bold text-purple-600">{{ $attempt->attempt_number }}/{{ $quiz->attempt_limit }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Completed At</p>
                            <p class="text-lg font-bold text-gray-800">{{ $attempt->completed_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Review -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Detailed Review</h2>
            <div class="space-y-6">
                @foreach($responses as $index => $response)
                    @php
                        $question = $response->question;
                        $answer = $response->answer;
                        $isCorrect = $response->is_correct;
                    @endphp
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-l-4 {{ $isCorrect ? 'border-green-500' : 'border-red-500' }}">
                        <div class="p-6">
                            <!-- Question -->
                            <div class="mb-4">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-lg font-bold text-gray-800">
                                        Question {{ $index + 1 }}
                                    </h3>
                                    @if($isCorrect)
                                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fas fa-check-circle mr-2"></i>Correct
                                        </span>
                                    @else
                                        <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fas fa-times-circle mr-2"></i>Incorrect
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-700 text-lg">{{ $question->question_text }}</p>
                            </div>

                            <!-- User's Answer and Correct Answer -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- User's Answer -->
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-3">Your Answer</h4>
                                    @if($question->type === 'short_answer')
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                            <p class="text-gray-700">{{ $response->answer_text ?? 'No answer provided' }}</p>
                                            <p class="text-sm text-blue-600 mt-2">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                Pending instructor review
                                            </p>
                                        </div>
                                    @else
                                        <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4">
                                            <p class="text-gray-800 font-semibold">{{ $answer?->answer_text ?? 'No answer selected' }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Correct Answer (show if enabled) -->
                                @if($showCorrectAnswers && !$isCorrect)
                                    <div>
                                        <h4 class="font-semibold text-gray-800 mb-3">Correct Answer</h4>
                                        @php
                                            $correctAnswer = $question->getCorrectAnswer();
                                        @endphp
                                        @if($correctAnswer)
                                            <div class="bg-green-50 border-2 border-green-300 rounded-lg p-4">
                                                <p class="text-gray-800 font-semibold">{{ $correctAnswer->answer_text }}</p>
                                            </div>
                                        @else
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                                <p class="text-gray-600">Answer unavailable</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Explanation (if available) -->
                            @if($question->explanation && $showCorrectAnswers)
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                                    <h4 class="font-semibold text-yellow-900 mb-2">
                                        <i class="fas fa-lightbulb mr-2"></i>Explanation
                                    </h4>
                                    <p class="text-yellow-800 text-sm">{{ $question->explanation }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @if($attempt->passed)
                <a href="{{ route('modules.show', [$course->slug, $module->slug]) }}" 
                   class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg px-6 py-4 text-center transition-all">
                    <i class="fas fa-arrow-right mr-2"></i>Continue to Next
                </a>
            @else
                @php
                    $canRetry = $attempt->quiz->canUserRetry(auth()->id());
                @endphp
                @if($canRetry)
                    <a href="{{ route('quizzes.start', [$course->slug, $module->slug, $quiz->slug]) }}" 
                       class="bg-purple-500 hover:bg-purple-600 text-white font-bold rounded-lg px-6 py-4 text-center transition-all">
                        <i class="fas fa-redo mr-2"></i>Retry Quiz
                    </a>
                @endif
            @endif

            <a href="{{ route('quizzes.show', [$course->slug, $module->slug, $quiz->slug]) }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg px-6 py-4 text-center transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Back to Quiz
            </a>

            <a href="{{ route('modules.show', [$course->slug, $module->slug]) }}" 
               class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-lg px-6 py-4 text-center transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Back to Module
            </a>
        </div>

        <!-- Performance Summary -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Performance Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Score Breakdown</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Questions Answered</span>
                            <span class="font-semibold">{{ $attempt->total_questions }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Correct Answers</span>
                            <span class="font-semibold text-green-600">{{ $attempt->correct_answers }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Incorrect Answers</span>
                            <span class="font-semibold text-red-600">{{ $attempt->total_questions - $attempt->correct_answers }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                            <span class="text-gray-800 font-semibold">Accuracy Rate</span>
                            <span class="text-lg font-bold">{{ $attempt->score_percentage }}%</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 mb-4">Quiz Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Passing Score</span>
                            <span class="font-semibold">{{ $quiz->passing_score }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Time Limit</span>
                            <span class="font-semibold">
                                @if($quiz->time_limit_minutes)
                                    {{ $quiz->time_limit_minutes }} min
                                @else
                                    Unlimited
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status</span>
                            <span class="font-semibold">
                                @if($attempt->passed)
                                    <span class="text-green-600">✓ Passed</span>
                                @else
                                    <span class="text-red-600">✗ Not Passed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
