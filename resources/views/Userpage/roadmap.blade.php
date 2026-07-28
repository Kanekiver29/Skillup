@extends('layout.app')

@section('title', 'My Learning Roadmap - SkillUp')

@push('head')
<style>
    :root {
        --roadmap-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --roadmap-navy: #0a2540;
        --roadmap-blue: #003a8f;
    }

    [data-animate] {
        opacity: 0;
        transform: translateY(20px);
        filter: blur(3px);
        will-change: transform, opacity, filter;
    }

    .animate-ready {
        animation: roadmapFadeUp 0.75s var(--roadmap-ease) forwards;
    }

    .delay-75  { animation-delay: 75ms; }
    .delay-100 { animation-delay: 100ms; }
    .delay-150 { animation-delay: 150ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-250 { animation-delay: 250ms; }
    .delay-300 { animation-delay: 300ms; }

    @keyframes roadmapFadeUp {
        0%   { opacity: 0; transform: translateY(20px) scale(0.99); filter: blur(4px); }
        100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    @keyframes roadmapProgress {
        from { width: 0; }
    }

    @keyframes roadmapPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(0, 58, 143, 0.35); }
        50%      { box-shadow: 0 0 0 8px rgba(0, 58, 143, 0); }
    }

    .roadmap-hero {
        background: linear-gradient(145deg, #061829 0%, var(--roadmap-navy) 45%, var(--roadmap-blue) 100%);
    }

    .roadmap-hover-lift {
        transition: transform 280ms var(--roadmap-ease), box-shadow 280ms var(--roadmap-ease), border-color 280ms var(--roadmap-ease);
    }

    .roadmap-hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
    }

    .roadmap-progress-bar {
        animation: roadmapProgress 1.2s var(--roadmap-ease) forwards;
    }

    .roadmap-filter-btn {
        transition: background 0.25s ease, color 0.25s ease, transform 0.2s var(--roadmap-ease), box-shadow 0.25s ease;
    }

    .roadmap-filter-btn.active {
        background: linear-gradient(135deg, var(--roadmap-blue), var(--roadmap-navy));
        color: #fff;
        box-shadow: 0 8px 24px rgba(0, 58, 143, 0.3);
    }

    .roadmap-filter-btn:not(.active):hover {
        transform: translateY(-1px);
        background: #f1f5f9;
    }

    .roadmap-timeline-item {
        transition: opacity 0.35s ease, transform 0.35s var(--roadmap-ease), max-height 0.4s ease;
    }

    .roadmap-timeline-item.is-hidden {
        opacity: 0;
        transform: translateX(-8px);
        max-height: 0;
        overflow: hidden;
        margin: 0 !important;
        padding: 0 !important;
        pointer-events: none;
    }

    .roadmap-next-card {
        animation: roadmapPulse 2.5s ease-in-out infinite;
    }

    .roadmap-column-card {
        max-height: 28rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #f1f5f9;
    }

    @media (prefers-reduced-motion: reduce) {
        [data-animate], .roadmap-progress-bar, .roadmap-next-card {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50/80">
    {{-- Hero --}}
    <section class="roadmap-hero pt-28 pb-12 px-4 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(96,165,250,0.15),transparent_55%)]"></div>
        <div class="max-w-6xl mx-auto relative z-10">
            <a href="{{ route('userpage.dashboard') }}" data-animate class="inline-flex items-center gap-2 text-slate-300 hover:text-white text-sm mb-6 transition-colors">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>

            <div data-animate class="delay-75 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-semibold mb-3">
                        <i class="fas fa-route text-sky-200"></i> Learning Path
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight">My Learning Roadmap</h1>
                    <p class="text-slate-300 mt-2 max-w-xl">Track your journey, filter by status, and pick up right where you left off.</p>
                </div>
                @if($enrollments->count() > 0)
                    <div class="text-left lg:text-right">
                        <p class="text-sm text-slate-400">Average Progress</p>
                        <p class="text-4xl font-bold text-sky-200">
                            <span id="roadmap-progress-counter" data-target="{{ $averageProgress }}">0</span>%
                        </p>
                        <p class="text-xs text-slate-400 mt-1">{{ $totalCompleted }} of {{ $totalEnrolled }} courses completed</p>
                    </div>
                @endif
            </div>

            @if($enrollments->count() > 0)
                <div data-animate class="delay-150 mt-8">
                    <div class="flex justify-between text-xs text-slate-400 mb-2">
                        <span>Overall learning progress</span>
                        <span id="roadmap-progress-label">{{ $averageProgress }}%</span>
                    </div>
                    <div class="h-3 bg-white/10 rounded-full overflow-hidden border border-white/10">
                        <div id="roadmap-main-progress" class="roadmap-progress-bar h-full rounded-full bg-gradient-to-r from-sky-400 to-blue-300" style="width: 0" data-width="{{ $averageProgress }}"></div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 py-10 -mt-4 relative z-20">
        @if($enrollments->count() > 0)

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div data-animate class="delay-100 roadmap-hover-lift bg-white rounded-2xl shadow-md border border-gray-100 p-5 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-green-100 flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-green-600" data-counter data-target="{{ $totalCompleted }}">0</p>
                    <p class="text-sm text-gray-500 mt-1">Completed</p>
                </div>
                <div data-animate class="delay-150 roadmap-hover-lift bg-white rounded-2xl shadow-md border border-gray-100 p-5 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-spinner text-orange-600 text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-orange-600" data-counter data-target="{{ $inProgressCourses->count() }}">0</p>
                    <p class="text-sm text-gray-500 mt-1">In Progress</p>
                </div>
                <div data-animate class="delay-200 roadmap-hover-lift bg-white rounded-2xl shadow-md border border-gray-100 p-5 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-book-open text-[#003a8f] text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-[#003a8f]" data-counter data-target="{{ $totalEnrolled }}">0</p>
                    <p class="text-sm text-gray-500 mt-1">Total Enrolled</p>
                </div>
            </div>

            {{-- Continue next --}}
            @if($nextEnrollment)
                <div data-animate class="delay-200 roadmap-next-card mb-8 rounded-2xl border border-blue-200 bg-gradient-to-r from-blue-50 to-slate-50 p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-[#003a8f] text-white flex items-center justify-center shrink-0 shadow-lg">
                                <i class="fas fa-play"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#003a8f]">Continue Next</p>
                                <h2 class="text-lg font-bold text-gray-800 mt-0.5">{{ $nextEnrollment->course->course_title }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ $nextEnrollment->progress }}% complete</p>
                            </div>
                        </div>
                        <a href="{{ route('courses.show', $nextEnrollment->course->slug) }}" class="inline-flex items-center justify-center gap-2 bg-[#003a8f] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#0a2540] transition shadow-md shrink-0">
                            Resume Course <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                    <div class="mt-4 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="roadmap-progress-bar h-full rounded-full bg-gradient-to-r from-[#003a8f] to-sky-500" style="width: 0" data-width="{{ $nextEnrollment->progress }}"></div>
                    </div>
                </div>
            @endif

            {{-- Filter toolbar --}}
            <div data-animate class="delay-250 flex flex-wrap items-center gap-2 mb-6">
                <span class="text-sm font-semibold text-gray-600 mr-2">Filter timeline:</span>
                <button type="button" class="roadmap-filter-btn active text-sm font-semibold px-4 py-2 rounded-full border border-gray-200" data-filter="all">All</button>
                <button type="button" class="roadmap-filter-btn text-sm font-semibold px-4 py-2 rounded-full border border-gray-200 text-gray-600" data-filter="completed">Completed</button>
                <button type="button" class="roadmap-filter-btn text-sm font-semibold px-4 py-2 rounded-full border border-gray-200 text-gray-600" data-filter="in-progress">In Progress</button>
                <button type="button" class="roadmap-filter-btn text-sm font-semibold px-4 py-2 rounded-full border border-gray-200 text-gray-600" data-filter="not-started">Not Started</button>
            </div>

            {{-- Three columns --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                {{-- Completed --}}
                <div data-animate class="delay-100">
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-green-50/50">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-gray-800">Completed</h2>
                                <p class="text-xs text-gray-500">{{ $completedCourses->count() }} courses</p>
                            </div>
                        </div>
                        <div class="roadmap-column-card p-4 space-y-3 flex-1">
                            @forelse($completedCourses as $enrollment)
                                <div class="roadmap-course-card p-3 bg-green-50 border border-green-100 rounded-xl roadmap-hover-lift" data-search="{{ strtolower($enrollment->course->course_title) }}">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $enrollment->course->course_title }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : 'Completed' }}
                                            </p>
                                            <a href="{{ route('certificates.show', $enrollment->course->slug) }}" class="text-xs text-green-700 font-semibold hover:underline mt-2 inline-flex items-center gap-1">
                                                View Certificate <i class="fas fa-arrow-right text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-6">No completed courses yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- In Progress --}}
                <div data-animate class="delay-150">
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-orange-50/50">
                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-spinner text-orange-600"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-gray-800">In Progress</h2>
                                <p class="text-xs text-gray-500">{{ $inProgressCourses->count() }} courses</p>
                            </div>
                        </div>
                        <div class="roadmap-column-card p-4 space-y-3 flex-1">
                            @forelse($inProgressCourses as $enrollment)
                                <div class="roadmap-course-card p-3 bg-orange-50 border border-orange-100 rounded-xl roadmap-hover-lift" data-search="{{ strtolower($enrollment->course->course_title) }}">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-play text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $enrollment->course->course_title }}</h3>
                                            <div class="mt-2">
                                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                                    <span>Progress</span>
                                                    <span>{{ $enrollment->progress }}%</span>
                                                </div>
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="roadmap-progress-bar h-full rounded-full bg-orange-500" style="width: 0" data-width="{{ $enrollment->progress }}"></div>
                                                </div>
                                            </div>
                                            <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="text-xs text-orange-700 font-semibold hover:underline mt-2 inline-flex items-center gap-1">
                                                Continue <i class="fas fa-arrow-right text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-6">No courses in progress.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Not Started --}}
                <div data-animate class="delay-200">
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-slate-50">
                            <div class="w-10 h-10 bg-slate-200 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-slate-600"></i>
                            </div>
                            <div>
                                <h2 class="font-bold text-gray-800">Not Started</h2>
                                <p class="text-xs text-gray-500">{{ $notStartedCourses->count() }} courses</p>
                            </div>
                        </div>
                        <div class="roadmap-column-card p-4 space-y-3 flex-1">
                            @forelse($notStartedCourses as $enrollment)
                                <div class="roadmap-course-card p-3 bg-slate-50 border border-slate-200 rounded-xl roadmap-hover-lift" data-search="{{ strtolower($enrollment->course->course_title) }}">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 bg-slate-400 rounded-lg flex items-center justify-center shrink-0">
                                            <i class="fas fa-book text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $enrollment->course->course_title }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">{{ $enrollment->course->modules_count ?? 0 }} modules</p>
                                            <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="text-xs text-[#003a8f] font-semibold hover:underline mt-2 inline-flex items-center gap-1">
                                                Start Learning <i class="fas fa-arrow-right text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-6">All enrolled courses started!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search --}}
            <div data-animate class="delay-200 mb-6">
                <div class="relative max-w-md">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="search" id="roadmap-search" placeholder="Search your courses..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-white shadow-sm focus:outline-none focus:border-[#003a8f] focus:ring-4 focus:ring-blue-100 text-sm">
                </div>
            </div>

            {{-- Timeline --}}
            <div data-animate class="delay-250 bg-white rounded-2xl shadow-md border border-gray-100 p-6 md:p-8 mb-10">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-stream text-[#003a8f]"></i> Learning Journey Timeline
                </h2>

                <div class="relative pl-2 md:pl-4">
                    <div class="absolute left-4 md:left-6 top-2 bottom-2 w-0.5 bg-gradient-to-b from-green-400 via-orange-400 to-slate-300 rounded-full"></div>

                    <div id="roadmap-timeline" class="space-y-5">
                        @foreach($enrollments as $enrollment)
                            @php
                                $status = $enrollment->completed ? 'completed' : ($enrollment->progress > 0 ? 'in-progress' : 'not-started');
                            @endphp
                            <div class="roadmap-timeline-item relative pl-12 md:pl-14" data-status="{{ $status }}" data-search="{{ strtolower($enrollment->course->course_title) }}">
                                <div class="absolute left-0 top-1 w-8 h-8 md:w-9 md:h-9 rounded-full flex items-center justify-center shadow-md z-10
                                    {{ $status === 'completed' ? 'bg-green-500' : ($status === 'in-progress' ? 'bg-orange-500' : 'bg-slate-300') }}">
                                    @if($status === 'completed')
                                        <i class="fas fa-check text-white text-xs"></i>
                                    @elseif($status === 'in-progress')
                                        <i class="fas fa-play text-white text-xs"></i>
                                    @else
                                        <i class="fas fa-circle text-white text-[8px]"></i>
                                    @endif
                                </div>

                                <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="block roadmap-hover-lift">
                                    <div class="bg-slate-50 rounded-xl p-4 md:p-5 border border-gray-100 hover:border-blue-200">
                                        <div class="flex flex-wrap items-start justify-between gap-3">
                                            <div>
                                                <h3 class="font-bold text-gray-800">{{ $enrollment->course->course_title }}</h3>
                                                <p class="text-sm text-gray-500 mt-0.5">{{ $enrollment->course->category ?? 'Uncategorized' }}</p>
                                                <p class="text-xs text-gray-400 mt-1">Enrolled {{ $enrollment->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $status === 'completed' ? 'bg-green-100 text-green-700' : ($status === 'in-progress' ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-600') }}">
                                                {{ $status === 'completed' ? 'Completed' : ($status === 'in-progress' ? $enrollment->progress . '%' : 'Not Started') }}
                                            </span>
                                        </div>

                                        @if($status === 'in-progress')
                                            <div class="mt-4 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="roadmap-progress-bar h-full rounded-full bg-gradient-to-r from-[#003a8f] to-sky-500" style="width: 0" data-width="{{ $enrollment->progress }}"></div>
                                            </div>
                                        @endif

                                        <div class="mt-3 flex flex-wrap gap-4 text-xs text-gray-500">
                                            <span><i class="fas fa-layer-group mr-1"></i>{{ $enrollment->course->modules_count ?? 0 }} modules</span>
                                            @if($enrollment->course->duration_hours ?? null)
                                                <span><i class="fas fa-clock mr-1"></i>{{ $enrollment->course->duration_hours }} hours</span>
                                            @endif
                                            @if($enrollment->course->level ?? null)
                                                <span><i class="fas fa-signal mr-1"></i>{{ $enrollment->course->level }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <p id="roadmap-timeline-empty" class="hidden text-center text-gray-500 py-8 text-sm">No courses match this filter.</p>
                </div>
            </div>

            @if(count($userSkills) > 0)
                <div data-animate class="delay-200 bg-white rounded-2xl shadow-md border border-gray-100 p-6 md:p-8 mb-10">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Skills Development</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($userSkills as $skill)
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-slate-100 to-blue-50 border border-blue-100 rounded-full text-sm font-medium text-gray-700 roadmap-hover-lift">
                                <i class="fas fa-star text-amber-400 text-xs"></i>{{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($coursesByCategory && $coursesByCategory->count() > 0)
                <div data-animate class="delay-250 bg-white rounded-2xl shadow-md border border-gray-100 p-6 md:p-8 mb-10">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Explore More Courses</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($coursesByCategory as $category => $courses)
                            <a href="{{ route('courses.index') }}?category={{ urlencode($category) }}" class="roadmap-hover-lift block border border-gray-100 rounded-xl p-4 hover:border-blue-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl gradient-primary flex items-center justify-center shrink-0">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $category ?: 'General' }}</h3>
                                        <p class="text-xs text-gray-500">{{ $courses->count() }} courses</p>
                                    </div>
                                </div>
                                <p class="text-sm text-[#003a8f] font-semibold mt-3">Browse &rarr;</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        @else
            {{-- Empty state --}}
            <div data-animate class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 md:p-16 text-center max-w-2xl mx-auto">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-route text-[#003a8f] text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Start Your Learning Journey</h2>
                <p class="text-gray-500 mb-8 leading-relaxed">You haven't enrolled in any courses yet. Browse our catalog to build your personalized roadmap.</p>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 gradient-primary text-white font-bold px-8 py-4 rounded-xl shadow-lg hover:opacity-95 transition">
                    <i class="fas fa-compass"></i> Browse Courses
                </a>
            </div>
        @endif

        {{-- Quick actions --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 pb-12">
            <a href="{{ route('courses.index') }}" data-animate class="delay-100 roadmap-hover-lift bg-white rounded-2xl shadow-md border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-search text-[#003a8f] text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Find New Courses</h3>
                    <p class="text-sm text-gray-500">Explore our catalog</p>
                </div>
            </a>
            <a href="{{ route('courses.my-learning') }}" data-animate class="delay-150 roadmap-hover-lift bg-white rounded-2xl shadow-md border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-book-reader text-orange-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">My Learning</h3>
                    <p class="text-sm text-gray-500">Continue learning</p>
                </div>
            </a>
            <a href="{{ route('userpage.profile-edit') }}" data-animate class="delay-200 roadmap-hover-lift bg-white rounded-2xl shadow-md border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-user-cog text-[#003a8f] text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Update Profile</h3>
                    <p class="text-sm text-gray-500">Add your skills</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Scroll animations
    const animateEls = document.querySelectorAll('[data-animate]');
    if (!reduced) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-ready');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        animateEls.forEach(el => observer.observe(el));
    } else {
        animateEls.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
            el.style.filter = 'none';
        });
    }

    // Animate progress bars
    function animateProgressBars() {
        document.querySelectorAll('.roadmap-progress-bar[data-width]').forEach(bar => {
            const width = bar.dataset.width || '0';
            requestAnimationFrame(() => {
                bar.style.width = width + '%';
            });
        });
    }

    setTimeout(animateProgressBars, reduced ? 0 : 400);

    // Counter animation
    function animateCounter(el, target, duration = 900) {
        if (reduced) {
            el.textContent = target;
            return;
        }
        const start = performance.now();
        const from = 0;
        function tick(now) {
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.round(from + (target - from) * eased);
            if (p < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    document.querySelectorAll('[data-counter]').forEach(el => {
        animateCounter(el, parseInt(el.dataset.target, 10) || 0);
    });

    const mainCounter = document.getElementById('roadmap-progress-counter');
    if (mainCounter) {
        animateCounter(mainCounter, parseInt(mainCounter.dataset.target, 10) || 0, 1100);
    }

    // Timeline filters
    const filterBtns = document.querySelectorAll('.roadmap-filter-btn');
    const timelineItems = document.querySelectorAll('.roadmap-timeline-item');
    const timelineEmpty = document.getElementById('roadmap-timeline-empty');

    function applyTimelineFilter(filter) {
        let visible = 0;
        timelineItems.forEach(item => {
            const status = item.dataset.status;
            const show = filter === 'all' || status === filter;
            item.classList.toggle('is-hidden', !show);
            if (show) visible++;
        });
        if (timelineEmpty) {
            timelineEmpty.classList.toggle('hidden', visible > 0);
        }
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => {
                b.classList.remove('active');
                b.classList.add('text-gray-600');
            });
            btn.classList.add('active');
            btn.classList.remove('text-gray-600');
            applyTimelineFilter(btn.dataset.filter);
        });
    });

    // Search courses in columns + timeline
    const searchInput = document.getElementById('roadmap-search');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            document.querySelectorAll('[data-search]').forEach(el => {
                const match = !q || (el.dataset.search || '').includes(q);
                if (el.classList.contains('roadmap-timeline-item')) {
                    const status = el.dataset.status;
                    const activeBtn = document.querySelector('.roadmap-filter-btn.active');
                    const filter = activeBtn ? activeBtn.dataset.filter : 'all';
                    const passFilter = filter === 'all' || status === filter;
                    el.classList.toggle('is-hidden', !(match && passFilter));
                } else {
                    el.style.display = match ? '' : 'none';
                }
            });
        });
    }
});
</script>
@endpush
