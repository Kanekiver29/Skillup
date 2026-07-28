@extends('layout.app')

@section('title', 'My Learning - SkillUp')

@section('content')

<style>
    /* ===== Futuristic Design System ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes floatOrb {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(20px, -30px) scale(1.08); }
    }
    @keyframes shimmer {
        0%   { background-position: -300px 0; }
        100% { background-position: 300px 0; }
    }
    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(129, 90, 240, 0.35); }
        50%      { box-shadow: 0 0 0 10px rgba(129, 90, 240, 0); }
    }
    @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    @keyframes barFill {
        from { width: 0%; }
    }
    @keyframes badgePop {
        0%   { opacity: 0; transform: scale(0.6) translateY(10px); }
        60%  { transform: scale(1.05) translateY(-2px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes spinSlow {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }

    .ml-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(120deg, #4c1d95, #6d28d9, #4338ca, #7c3aed);
        background-size: 300% 300%;
        animation: gradientShift 14s ease infinite;
    }
    .ml-hero::before,
    .ml-hero::after {
        content: '';
        position: absolute;
        border-radius: 9999px;
        filter: blur(60px);
        opacity: 0.35;
        pointer-events: none;
        animation: floatOrb 10s ease-in-out infinite;
    }
    .ml-hero::before {
        width: 260px; height: 260px;
        background: #a78bfa;
        top: -60px; left: 10%;
    }
    .ml-hero::after {
        width: 220px; height: 220px;
        background: #38bdf8;
        bottom: -70px; right: 12%;
        animation-delay: 3s;
    }
    .ml-hero-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 36px 36px;
        mask-image: radial-gradient(ellipse at top, black 40%, transparent 80%);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        transition: transform 0.35s cubic-bezier(.2,.8,.2,1), box-shadow 0.35s ease, border-color 0.35s ease;
    }
    .glass-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -12px rgba(109, 40, 217, 0.25);
        border-color: rgba(167, 139, 250, 0.6);
    }

    .fade-up {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .progress-shimmer {
        position: relative;
        overflow: hidden;
    }
    .progress-shimmer::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.55), transparent);
        background-size: 300px 100%;
        animation: shimmer 2.2s infinite;
    }

    .progress-fill {
        animation: barFill 1.1s cubic-bezier(.16,1,.3,1) forwards;
    }

    .badge-chip {
        animation: badgePop 0.5s ease forwards;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .badge-chip:hover {
        transform: translateY(-3px) rotate(-1deg);
        box-shadow: 0 10px 20px -8px rgba(251, 191, 36, 0.5);
    }

    .stat-card {
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: -40%; left: -40%;
        width: 60%; height: 200%;
        background: linear-gradient(120deg, transparent, rgba(124, 58, 237, 0.08), transparent);
        transform: rotate(20deg);
        transition: transform 0.6s ease;
    }
    .stat-card:hover::before {
        transform: rotate(20deg) translateX(120%);
    }

    .icon-orbit {
        transition: transform 0.4s ease;
    }
    .glass-card:hover .icon-orbit {
        transform: rotate(12deg) scale(1.1);
    }

    .level-ring {
        animation: pulseGlow 2.6s ease-in-out infinite;
    }

    .cta-button {
        position: relative;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .cta-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -8px rgba(124, 58, 237, 0.45);
    }
    .cta-button::after {
        content: '';
        position: absolute;
        top: 0; left: -75%;
        width: 50%; height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
        transform: skewX(-20deg);
        transition: left 0.6s ease;
    }
    .cta-button:hover::after {
        left: 125%;
    }

    .empty-orb {
        animation: spinSlow 18s linear infinite;
    }

    @media (prefers-reduced-motion: reduce) {
        .ml-hero, .ml-hero::before, .ml-hero::after, .fade-up, .progress-shimmer::after,
        .progress-fill, .badge-chip, .level-ring, .empty-orb, .icon-orbit {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div class="pt-10 pb-16 ml-hero text-white relative">
    <div class="ml-hero-grid"></div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 fade-up">
            <div>
                <p class="text-sm text-purple-100/90 mb-2 tracking-wide uppercase flex items-center gap-2">
                    <i class="fas fa-chevron-right text-[10px]" aria-hidden="true"></i>
                    Dashboard / My Learning
                </p>
                <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">My Learning</h1>
                <p class="text-purple-100/90 mt-3 max-w-md">Track your progress, level up, and unlock new achievements as you master new skills.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="cta-button inline-flex items-center justify-center bg-white text-purple-700 px-5 py-3 rounded-xl font-semibold shadow-lg hover:bg-purple-50">
                <i class="fas fa-plus mr-2" aria-hidden="true"></i>
                Browse More Courses
            </a>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 -mt-8 relative z-10">
    @php
        $user = auth()->user();
        $xp = $user->xp ?? 0;
        $level = $user->level ?? 1;
        $levelProgress = $user->level_progress_percent ?? 0;
        $earnedBadges = $user ? $user->badges()->with('badge')->get() : collect();
    @endphp

    <!-- XP & Achievements -->
    <section class="glass-card rounded-2xl shadow-xl p-6 mb-8 fade-up" style="animation-delay: .05s" aria-label="XP and Achievements">
        <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
            <div class="flex items-center gap-4">
                <div class="level-ring w-14 h-14 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                    {{ $level }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Your Progress</h2>
                    <p class="text-sm text-gray-600">Level {{ $level }} &middot; <span class="font-semibold text-purple-700">{{ $xp }} XP</span></p>
                </div>
            </div>
            <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full">
                Next level in <span class="font-semibold text-gray-700">{{ $user->xp_to_next_level ?? 0 }} XP</span>
            </div>
        </div>

        <div class="w-full bg-gray-200/70 rounded-full h-3 mb-6 overflow-hidden" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $levelProgress }}">
            <div class="progress-fill progress-shimmer h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-fuchsia-500 rounded-full" style="width: {{ $levelProgress }}%"></div>
        </div>

        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
            <i class="fas fa-trophy text-amber-400"></i> Achievements
        </h3>
        <div class="flex items-center gap-3 flex-wrap">
            @foreach($earnedBadges as $i => $userBadge)
                @php $b = $userBadge->badge; @endphp
                <div class="badge-chip flex items-center gap-2 bg-gradient-to-br from-amber-50 to-white border border-amber-200 rounded-xl px-3 py-2 text-sm shadow-sm" style="animation-delay: {{ $i * 0.08 }}s">
                    <i class="{{ $b->icon ?? 'fas fa-award' }} text-amber-400 text-lg"></i>
                    <div class="text-left">
                        <div class="font-semibold text-gray-800">{{ $b->name }}</div>
                        <div class="text-xs text-gray-500">Earned {{ $userBadge->earned_at?->format('M d, Y') }}</div>
                    </div>
                </div>
            @endforeach

            @if($earnedBadges->isEmpty())
                <div class="text-sm text-gray-500 italic">No badges yet — complete lessons and quizzes to unlock achievements.</div>
            @endif
        </div>
    </section>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-green-200 bg-green-50 text-green-800 fade-up flex items-center gap-2" role="status">
            <i class="fas fa-circle-check text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    @php
        $totalCourses = $enrollments->count();
        $completedCourses = $enrollments->where('completed', true)->count();
        $inProgressCourses = $enrollments->where('completed', false)->where('progress', '>', 0)->count();
        $notStartedCourses = $enrollments->where('progress', 0)->count();
        $avgProgress = $totalCourses > 0 ? (int) round($enrollments->avg('progress')) : 0;
    @endphp

    @if($totalCourses > 0)
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8" aria-label="Learning summary">
            <article class="stat-card glass-card rounded-2xl shadow-sm p-5 fade-up" style="animation-delay: .1s">
                <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-layer-group text-indigo-500"></i> Enrolled</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalCourses }}</p>
            </article>
            <article class="stat-card glass-card rounded-2xl shadow-sm p-5 fade-up" style="animation-delay: .16s">
                <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-bolt text-blue-500"></i> In Progress</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $inProgressCourses }}</p>
            </article>
            <article class="stat-card glass-card rounded-2xl shadow-sm p-5 fade-up" style="animation-delay: .22s">
                <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-circle-check text-green-500"></i> Completed</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $completedCourses }}</p>
            </article>
            <article class="stat-card glass-card rounded-2xl shadow-sm p-5 fade-up" style="animation-delay: .28s">
                <p class="text-sm text-gray-500 flex items-center gap-2"><i class="fas fa-chart-line text-purple-500"></i> Average Progress</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $avgProgress }}%</p>
            </article>
        </section>

        <!-- Learning Components Guide -->
        <section class="glass-card rounded-2xl shadow-sm p-6 mb-8 fade-up" style="animation-delay: .3s" aria-label="Learning components guide">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                Understanding Your Learning Journey
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Lessons -->
                <div class="glass-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                    <div class="flex items-center mb-3">
                        <div class="icon-orbit w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center mr-3 shadow-md">
                            <i class="fas fa-book-open text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-blue-900">Lessons</h3>
                    </div>
                    <p class="text-sm text-blue-800 leading-relaxed">
                        Structured learning content that builds your knowledge step by step. Each lesson contains detailed explanations, examples, and practical exercises to help you master new concepts.
                    </p>
                </div>

                <!-- Quizzes -->
                <div class="glass-card bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                    <div class="flex items-center mb-3">
                        <div class="icon-orbit w-10 h-10 rounded-lg bg-green-600 flex items-center justify-center mr-3 shadow-md">
                            <i class="fas fa-question-circle text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-green-900">Quizzes</h3>
                    </div>
                    <p class="text-sm text-green-800 leading-relaxed">
                        Interactive assessments that test your understanding of the material. Quizzes help reinforce learning and provide immediate feedback on your progress and knowledge retention.
                    </p>
                </div>

                <!-- Videos -->
                <div class="glass-card bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                    <div class="flex items-center mb-3">
                        <div class="icon-orbit w-10 h-10 rounded-lg bg-purple-600 flex items-center justify-center mr-3 shadow-md">
                            <i class="fas fa-play-circle text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-purple-900">Videos</h3>
                    </div>
                    <p class="text-sm text-purple-800 leading-relaxed">
                        Engaging video content that brings concepts to life through demonstrations, tutorials, and expert explanations. Videos make complex topics easier to understand and remember.
                    </p>
                </div>
            </div>
        </section>

        <section aria-label="Enrolled courses">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($enrollments as $i => $enrollment)
                    @php
                        $course = $enrollment->course;
                        $progress = max(0, min(100, (int) $enrollment->progress));
                    @endphp

                    @if($course)
                        <article class="glass-card rounded-2xl shadow-sm overflow-hidden fade-up" style="animation-delay: {{ 0.32 + ($i * 0.06) }}s">
                            <div
                                class="h-40 bg-cover bg-center gradient-primary flex items-center justify-center relative overflow-hidden"
                                @if($course->image_url) style="background-image: url('{{ asset($course->image_url) }}');" @endif
                            >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/25 to-transparent"></div>
                                @if(!$course->image_url)
                                    <i class="fas fa-book-open text-white text-5xl opacity-30 relative z-10" aria-hidden="true"></i>
                                @endif
                            </div>

                            <div class="p-5">
                                <div class="flex items-center justify-between gap-3 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                        {{ $course->category }}
                                    </span>
                                    @if($enrollment->completed)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            <i class="fas fa-circle-check text-[10px]"></i> Completed
                                        </span>
                                    @elseif($progress > 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            <i class="fas fa-bolt text-[10px]"></i> In Progress
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            <i class="fas fa-hourglass-start text-[10px]"></i> Not Started
                                        </span>
                                    @endif
                                </div>

                                <h2 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $course->title }}</h2>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $course->short_description }}</p>

                                <div class="mb-2 flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Progress</span>
                                    <span class="font-semibold text-gray-800">{{ $progress }}%</span>
                                </div>
                                <div class="w-full h-2.5 bg-gray-200/70 rounded-full overflow-hidden" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progress }}" aria-label="{{ $course->title }} progress">
                                    <div class="progress-fill progress-shimmer h-full {{ $enrollment->completed ? 'bg-gradient-to-r from-green-400 to-emerald-500' : 'bg-gradient-to-r from-indigo-500 to-purple-600' }}" style="width: {{ $progress }}%;"></div>
                                </div>

                                <div class="mt-5 flex items-center justify-between text-sm text-gray-500">
                                    <span><i class="fas fa-clock mr-1" aria-hidden="true"></i>{{ $course->duration_hours }}h</span>
                                    @if($enrollment->completed_at)
                                        <span title="Completed date">{{ $enrollment->completed_at->format('M d, Y') }}</span>
                                    @elseif($progress === 0)
                                        <span>Start today</span>
                                    @else
                                        <span>Keep going</span>
                                    @endif
                                </div>

                                @php
                                    $firstModule = $course->modules->first();
                                @endphp
                                @if($enrollment->completed)
                                    <a href="{{ route('certificates.show', $course->slug) }}" class="cta-button mt-5 inline-flex w-full items-center justify-center px-4 py-2.5 rounded-xl font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 shadow-md">
                                        <i class="fas fa-certificate mr-2" aria-hidden="true"></i> View Certificate
                                    </a>
                                @else
                                    <a href="{{ $firstModule ? route('modules.show', [$course->slug, $firstModule->slug]) : route('courses.show', $course->slug) }}" class="cta-button mt-5 inline-flex w-full items-center justify-center px-4 py-2.5 rounded-xl font-semibold text-white gradient-primary shadow-md">
                                        {{ $progress > 0 ? 'Continue Learning' : 'Start Course' }}
                                        <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        </section>
    @else
        <section class="glass-card rounded-2xl shadow-sm p-8 md:p-12 text-center fade-up relative overflow-hidden">
            <div class="empty-orb absolute -top-10 -right-10 w-40 h-40 rounded-full bg-gradient-to-br from-purple-200 to-indigo-200 opacity-40 blur-2xl"></div>
            <div class="mx-auto w-16 h-16 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center mb-4 relative z-10 shadow-inner">
                <i class="fas fa-graduation-cap text-2xl" aria-hidden="true"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2 relative z-10">No courses yet</h2>
            <p class="text-gray-600 max-w-xl mx-auto mb-6 relative z-10">
                You have not enrolled in any course. Explore available courses and start building your learning journey.
            </p>
            <a href="{{ route('courses.index') }}" class="cta-button inline-flex items-center justify-center gradient-primary text-white px-6 py-3 rounded-xl font-semibold shadow-lg relative z-10">
                Explore Courses
                <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i>
            </a>
        </section>
    @endif
</div>
@endsection