@extends('layout.User.app')

@section('title', 'My Badges - SkillUp')

@section('content')
<div class="space-y-8">

    {{-- Page Header --}}
    <div class="gradient-primary rounded-2xl p-8 text-white shadow-lg">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold flex items-center gap-3">
                    <i class="fas fa-award text-yellow-300"></i> My Badges
                </h1>
                <p class="mt-2 text-purple-100">Earn badges by completing modules and acing quizzes!</p>
            </div>
            <div class="flex gap-4">
                <div class="bg-white/15 rounded-xl px-5 py-3 text-center backdrop-blur-sm">
                    <p class="text-2xl font-bold">{{ $totalEarned }}</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Total Earned</p>
                </div>
                <div class="bg-white/15 rounded-xl px-5 py-3 text-center backdrop-blur-sm">
                    <p class="text-2xl font-bold">{{ $moduleBadges->count() }}</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Modules</p>
                </div>
                <div class="bg-white/15 rounded-xl px-5 py-3 text-center backdrop-blur-sm">
                    <p class="text-2xl font-bold">{{ $quizBadges->count() }}</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Quizzes</p>
                </div>
                <div class="bg-white/15 rounded-xl px-5 py-3 text-center backdrop-blur-sm">
                    <p class="text-2xl font-bold">{{ $courseBadges->count() }}</p>
                    <p class="text-xs text-purple-200 uppercase tracking-wider">Courses</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Badge Categories --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Module Completion Badge Info --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-green-500 card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-puzzle-piece text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Module Completion</h3>
                    <p class="text-xs text-gray-500">Pass all quizzes in a module</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Complete every quiz in a module to earn this badge.</p>
            <div class="mt-3 text-sm font-medium text-green-600">
                <i class="fas fa-check-circle mr-1"></i> {{ $moduleBadges->count() }} earned
            </div>
        </div>

        {{-- Quiz Perfect Score Badge Info --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-yellow-500 card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Quiz Master</h3>
                    <p class="text-xs text-gray-500">Score 100% on a quiz</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Achieve a perfect score on any quiz to earn this badge.</p>
            <div class="mt-3 text-sm font-medium text-yellow-600">
                <i class="fas fa-check-circle mr-1"></i> {{ $quizBadges->count() }} earned
            </div>
        </div>

        {{-- Course Completion Badge Info --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-purple-500 card-hover">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Course Completion</h3>
                    <p class="text-xs text-gray-500">Complete all modules in a course</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Finish every module in a course to earn this badge.</p>
            <div class="mt-3 text-sm font-medium text-purple-600">
                <i class="fas fa-check-circle mr-1"></i> {{ $courseBadges->count() }} earned
            </div>
        </div>
    </div>

    {{-- Earned Badges Grid --}}
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-trophy text-yellow-500 mr-2"></i> Earned Badges
        </h2>

        @if($badgeData->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-award text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-600 mb-2">No Badges Yet</h3>
                <p class="text-gray-500 mb-4">Start completing modules and quizzes to earn your first badge!</p>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 gradient-primary text-white rounded-lg hover:opacity-90 transition">
                    <i class="fas fa-book-open mr-2"></i> Browse Courses
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($badgeData as $item)
                    @php
                        $badge = $item['badge'];
                        $ub = $item['user_badge'];
                        $context = $item['context'];

                        // Set styling based on badge type
                        $typeStyles = [
                            'module_completion' => [
                                'gradient' => 'from-green-400 to-emerald-600',
                                'bg' => 'bg-green-50',
                                'text' => 'text-green-700',
                                'border' => 'border-green-200',
                                'ring' => 'ring-green-300',
                                'label' => 'Module Complete',
                            ],
                            'quiz_perfect' => [
                                'gradient' => 'from-yellow-400 to-orange-500',
                                'bg' => 'bg-yellow-50',
                                'text' => 'text-yellow-700',
                                'border' => 'border-yellow-200',
                                'ring' => 'ring-yellow-300',
                                'label' => 'Quiz Master',
                            ],
                            'course_completion' => [
                                'gradient' => 'from-purple-400 to-indigo-600',
                                'bg' => 'bg-purple-50',
                                'text' => 'text-purple-700',
                                'border' => 'border-purple-200',
                                'ring' => 'ring-purple-300',
                                'label' => 'Course Complete',
                            ],
                        ];
                        $style = $typeStyles[$badge->type] ?? $typeStyles['module_completion'];
                    @endphp

                    <div class="bg-white rounded-xl shadow-md overflow-hidden card-hover border {{ $style['border'] }}">
                        {{-- Badge Icon Header --}}
                        <div class="bg-gradient-to-r' {{ $style['gradient'] }} p-6 text-center relative">
                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto ring-4 {{ $style['ring'] }} backdrop-blur-sm">
                                <i class="fas {{ $badge->icon }} text-white text-3xl"></i>
                            </div>
                            {{-- Sparkle decoration --}}
                            <div class="absolute top-3 right-4 text-white/40">
                                <i class="fas fa-sparkles text-lg"></i>
                            </div>
                            <div class="absolute bottom-3 left-4 text-white/30">
                                <i class="fas fa-star text-sm"></i>
                            </div>
                        </div>

                        {{-- Badge Details --}}
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-bold text-gray-800">{{ $badge->name }}</h3>
                                <span class="text-xs px-2 py-1 rounded-full {{ $style['bg'] }} {{ $style['text'] }} font-medium">
                                    {{ $style['label'] }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">{{ $badge->description }}</p>

                            @if($context)
                                <div class="flex items-center text-xs text-gray-500 bg-gray-50 rounded-lg px-3 py-2 mb-3">
                                    <i class="fas fa-bookmark mr-2 text-gray-400"></i>
                                    <span class="truncate">{{ $context }}</span>
                                </div>
                            @endif

                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <div class="flex items-center text-xs text-gray-400">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ $ub->earned_at ? $ub->earned_at->format('M d, Y') : 'Recently' }}
                                </div>
                                <div class="flex items-center text-xs font-medium {{ $style['text'] }}">
                                    <i class="fas fa-check-circle mr-1"></i> Earned
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Available Badges (unearned) --}}
    @php
        $earnedBadgeIds = $badgeData->pluck('badge.id')->unique();
        $unearnedBadges = $allBadges->reject(fn($b) => $earnedBadgeIds->contains($b->id));
    @endphp

    @if($unearnedBadges->isNotEmpty())
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-lock text-gray-400 mr-2"></i> Badges to Unlock
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($unearnedBadges as $badge)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 opacity-60 card-hover">
                        {{-- Locked Badge Header --}}
                        <div class="bg-gradient-to-rfrom-gray-300 to-gray-400 p-6 text-center relative">
                            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto ring-4 ring-gray-300 backdrop-blur-sm">
                                <i class="fas fa-lock text-white text-2xl"></i>
                            </div>
                        </div>

                        {{-- Badge Details --}}
                        <div class="p-5">
                            <h3 class="font-bold text-gray-600 mb-1">{{ $badge->name }}</h3>
                            <p class="text-sm text-gray-500 mb-3">{{ $badge->description }}</p>
                            <div class="flex items-center text-xs text-gray-400">
                                <i class="fas fa-info-circle mr-1"></i>
                                @if($badge->type === 'module_completion')
                                    Complete all quizzes in a module to unlock
                                @elseif($badge->type === 'quiz_perfect')
                                    Score 100% on a quiz to unlock
                                @elseif($badge->type === 'course_completion')
                                    Complete all modules in a course to unlock
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection