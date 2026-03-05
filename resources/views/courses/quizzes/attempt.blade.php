@extends('layout.app')

@section('title', 'Quiz: ' . $quiz->title . ' - SkillUp')

@section('content')
    <!-- Quiz Header -->
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('quizzes.show', [$course->slug, $module->slug, $quiz->slug]) }}" class="text-purple-100 hover:text-white flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Exit Quiz
                </a>
                <div class="text-right">
                    @if($quiz->time_limit_minutes)
                        <div id="timer" class="text-3xl font-bold">{{ $quiz->time_limit_minutes }}:00</div>
                        <p class="text-purple-100 text-sm">Time Remaining</p>
                    @endif
                </div>
            </div>
            <h1 class="text-3xl font-bold">{{ $quiz->title }}</h1>
            <p class="text-purple-100 mt-2">Attempt #{{ $attempt->attempt_number }} of {{ $quiz->attempt_limit }}</p>
        </div>
    </div>

    <!-- Quiz Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form id="quizForm" action="{{ route('quizzes.submit', [$course->slug, $module->slug, $quiz->slug]) }}" method="POST">
            @csrf
            <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-gray-700">Progress</span>
                    <span class="text-sm font-semibold text-gray-700" id="progressText">1 of {{ $quiz->questions()->count() }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="progressBar" class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <!-- Questions Container -->
            <div id="questionsContainer" class="space-y-8">
                @foreach($questions as $index => $question)
                    <div class="question-item bg-white rounded-lg shadow-lg p-8 hidden" id="question-{{ $question->id }}" data-question-index="{{ $index }}">
                        <!-- Question Number and Text -->
                        <div class="mb-6">
                            <div class="flex items-start justify-between mb-4">
                                <h2 class="text-2xl font-bold text-gray-800">
                                    Question {{ $index + 1 }}
                                </h2>
                                <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ $question->points }} point{{ $question->points !== 1 ? 's' : '' }}
                                </span>
                            </div>
                            <p class="text-lg text-gray-700 mb-6">{{ $question->question_text }}</p>
                        </div>

                        <!-- Answer Options -->
                        <div class="space-y-4 mb-8">
                            @if($question->type === 'multiple_choice' || $question->type === 'true_false')
                                @foreach($question->answers()->get() as $answer)
                                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition-all" id="answer-label-{{ $answer->id }}">
                                        <input type="radio" 
                                               name="responses[{{ $question->id }}]" 
                                               value="{{ $answer->id }}" 
                                               class="mt-1 answer-radio"
                                               data-question-id="{{ $question->id }}"
                                               onchange="updateQuestionStatus({{ $question->id }})">
                                        <span class="ml-4 flex-1">
                                            <span class="text-gray-800">{{ $answer->answer_text }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            @elseif($question->type === 'short_answer')
                                <textarea name="responses[{{ $question->id }}]" 
                                          class="w-full border-2 border-gray-200 rounded-lg p-4 focus:border-purple-500 focus:outline-none"
                                          rows="4"
                                          placeholder="Enter your answer here..."
                                          onchange="updateQuestionStatus({{ $question->id }})"></textarea>
                            @endif
                        </div>

                        <!-- Explanation (if available, shown after answering) -->
                        @if($question->explanation)
                            <div id="explanation-{{ $question->id }}" class="bg-blue-50 border border-blue-200 rounded-lg p-4 hidden mt-4">
                                <h4 class="font-semibold text-blue-900 mb-2">
                                    <i class="fas fa-lightbulb mr-2"></i>Explanation
                                </h4>
                                <p class="text-blue-800 text-sm">{{ $question->explanation }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between">
                    <button type="button" id="prevBtn" onclick="previousQuestion()" class="bg-gray-300 text-gray-800 font-semibold rounded-lg px-6 py-3 hover:bg-gray-400 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-2"></i>Previous
                    </button>

                    <div class="text-center">
                        <div id="answeredCount" class="inline-block bg-gray-100 px-4 py-2 rounded-lg">
                            <span id="answeredNumber">0</span>/<span id="totalNumber">{{ $quiz->questions()->count() }}</span> Answered
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" id="nextBtn" onclick="nextQuestion()" class="bg-gray-300 text-gray-800 font-semibold rounded-lg px-6 py-3 hover:bg-gray-400 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            Next<i class="fas fa-chevron-right ml-2"></i>
                        </button>

                        <button type="button" id="submitBtn" onclick="submitQuiz(event)" class="hidden bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg px-6 py-3 hover:shadow-lg transition-all">
                            <i class="fas fa-check mr-2"></i>Submit Quiz
                        </button>
                    </div>
                </div>
            </div>

            <!-- Question Indicators -->
            <div class="mt-8 pt-24 mb-8 pb-20">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Question Review</h3>
                <div class="grid grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-2" id="questionIndicators">
                    @foreach($questions as $index => $question)
                        <button type="button" 
                                class="question-indicator w-10 h-10 rounded-lg border-2 border-gray-300 font-semibold text-sm transition-all hover:shadow-md"
                                onclick="goToQuestion({{ $index }})"
                                id="indicator-{{ $index }}"
                                data-question-index="{{ $index }}"
                                title="Question {{ $index + 1 }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>
            </div>
        </form>
    </div>

    <script>
        let currentQuestionIndex = 0;
        const totalQuestions = {{ $quiz->questions()->count() }};
        const timeLimit = {{ $quiz->time_limit_minutes ? $quiz->time_limit_minutes * 60 : 'null' }};
        const answeredQuestions = new Set();

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            showQuestion(0);
            initializeTimer();
            updateIndicators();
        });

        function showQuestion(index) {
            // Hide all questions
            document.querySelectorAll('.question-item').forEach(q => q.classList.add('hidden'));

            // Show current question
            const currentQ = document.getElementById(`question-${getQuestionIdByIndex(index)}`);
            if (currentQ) {
                currentQ.classList.remove('hidden');
            }

            currentQuestionIndex = index;
            updateNavigationButtons();
            updateProgressBar();
            updateProgressText();
        }

        function nextQuestion() {
            if (currentQuestionIndex < totalQuestions - 1) {
                showQuestion(currentQuestionIndex + 1);
                window.scrollTo(0, 0);
            }
        }

        function previousQuestion() {
            if (currentQuestionIndex > 0) {
                showQuestion(currentQuestionIndex - 1);
                window.scrollTo(0, 0);
            }
        }

        function goToQuestion(index) {
            showQuestion(index);
            window.scrollTo(0, 0);
        }

        function getQuestionIdByIndex(index) {
            const items = document.querySelectorAll('.question-item');
            return items[index]?.id.replace('question-', '');
        }

        function updateQuestionStatus(questionId) {
            answeredQuestions.add(questionId);
            updateIndicators();
            updateAnsweredCount();
        }

        function updateIndicators() {
            document.querySelectorAll('.question-indicator').forEach((btn, index) => {
                const questionId = getQuestionIdByIndex(index);
                const isAnswered = answeredQuestions.has(parseInt(questionId));

                btn.classList.remove('bg-purple-500', 'text-white', 'border-purple-500', 'bg-gray-100');

                if (index === currentQuestionIndex) {
                    btn.classList.add('bg-purple-500', 'text-white', 'border-purple-500');
                } else if (isAnswered) {
                    btn.classList.add('bg-green-100', 'border-green-500');
                } else {
                    btn.classList.add('bg-gray-100');
                }
            });
        }

        function updateNavigationButtons() {
            document.getElementById('prevBtn').disabled = currentQuestionIndex === 0;
            document.getElementById('nextBtn').classList.toggle('hidden', currentQuestionIndex === totalQuestions - 1);
            document.getElementById('submitBtn').classList.toggle('hidden', currentQuestionIndex !== totalQuestions - 1);
        }

        function updateProgressBar() {
            const percentage = ((currentQuestionIndex + 1) / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = percentage + '%';
        }

        function updateProgressText() {
            document.getElementById('progressText').textContent = (currentQuestionIndex + 1) + ' of ' + totalQuestions;
        }

        function updateAnsweredCount() {
            document.getElementById('answeredNumber').textContent = answeredQuestions.size;
        }

        function initializeTimer() {
            if (!timeLimit) return;

            let timeRemaining = timeLimit;
            const updateTimer = () => {
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                document.getElementById('timer').textContent = 
                    `${minutes}:${seconds.toString().padStart(2, '0')}`;

                // Change color if less than 5 minutes
                if (timeRemaining < 300) {
                    document.getElementById('timer').parentElement.classList.add('animate-pulse');
                }

                if (timeRemaining <= 0) {
                    submitQuiz();
                    return;
                }

                timeRemaining--;
            };

            updateTimer();
            setInterval(updateTimer, 1000);
        }

        function submitQuiz(event) {
            if (event) event.preventDefault();

            let allAnswered = true;
            for (let i = 0; i < totalQuestions; i++) {
                const questionId = getQuestionIdByIndex(i);
                if (!answeredQuestions.has(parseInt(questionId))) {
                    allAnswered = false;
                    break;
                }
            }

            if (!allAnswered) {
                if (!confirm('You have not answered all questions. Submit anyway?')) {
                    return;
                }
            }

            document.getElementById('quizForm').submit();
        }

        // Check if answer is selected when answer radio buttons change
        document.querySelectorAll('.answer-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const questionId = this.dataset.questionId;
                updateQuestionStatus(parseInt(questionId));
            });
        });
    </script>

    <style>
        .animate-pulse {
            animation: pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
    </style>
@endsection
