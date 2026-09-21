@extends('layout.app')

@section('title', 'My Learning - SkillUp')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-blue-600 font-semibold">Learning space</p>
            <h1 class="mt-2 text-3xl font-bold text-gray-900">My Learning</h1>
            <p class="mt-2 text-gray-600">Continue your enrolled courses and track your progress.</p>
        </div>
        <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 font-semibold text-white transition hover:bg-blue-700">
            <i class="fas fa-book-open mr-2"></i> Browse courses
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800" role="status">{{ session('success') }}</div>
    @endif

    @if($enrollments->isEmpty())
        <section class="rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-900">No enrolled courses yet</h2>
            <p class="mt-2 text-gray-600">Browse the course catalog to start your learning journey.</p>
            <a href="{{ route('courses.index') }}" class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">
                Browse courses <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </section>
    @else
        @php
            $completed = $enrollments->where('completed', true)->count();
            $inProgress = $enrollments->where('completed', false)->where('progress', '>', 0)->count();
            $averageProgress = round($enrollments->avg('progress') ?? 0);
        @endphp

        <div class="mb-6 grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">Enrolled courses</p><strong class="mt-1 block text-2xl text-gray-900">{{ $enrollments->count() }}</strong></div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">In progress</p><strong class="mt-1 block text-2xl text-gray-900">{{ $inProgress }}</strong></div>
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">Average progress</p><strong class="mt-1 block text-2xl text-gray-900">{{ $averageProgress }}%</strong></div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            @foreach($enrollments as $enrollment)
                @php
                    $course = $enrollment->course;
                    $progress = max(0, min(100, (int) ($enrollment->progress ?? 0)));
                @endphp
                <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">{{ $course?->title ?? $course?->course_title ?? 'Untitled course' }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ ucfirst($enrollment->status ?? 'enrolled') }}</p>
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">{{ $progress }}%</span>
                    </div>
                    <div class="mt-5 h-2 overflow-hidden rounded-full bg-gray-100" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-full rounded-full bg-blue-600" style="width:{{ $progress }}%"></div>
                    </div>
                    <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                        <span class="text-sm text-gray-500">{{ $enrollment->completed ? 'Completed' : 'Keep learning' }}</span>
                        @if($course?->slug)
                            <a href="{{ route('courses.show', $course->slug) }}" class="font-semibold text-blue-600 hover:text-blue-800">Open course <i class="fas fa-arrow-right ml-1"></i></a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
