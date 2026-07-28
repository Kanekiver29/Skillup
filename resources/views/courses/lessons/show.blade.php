@extends('layout.Admin.system')

@section('title', $lesson->title . ' - ' . $module->title . ' - ' . $course->title)

@push('head')
    <style>
        :root {
            --mod-navy: #0a2540;
            --mod-sky: #00b4d8;
        }
        .lesson-content {
            animation: fadeIn 0.6s var(--mod-ease) forwards;
            opacity: 0;
            transform: translateY(12px);
        }
        @keyframes fadeIn {
            to { opacity:1; transform:none; }
        }
    </style>
@endpush

@section('content')
    <section class="max-w-6xl mx-auto p-4 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Player + Content -->
            <div class="lg:col-span-2 bg-white/5 backdrop-blur-md rounded-xl p-6 shadow">
                <div class="flex items-start justify-between mb-4">
                    <h1 class="text-2xl font-bold text-sky-600">{{ $lesson->title }}</h1>
                    <div class="flex items-center gap-3">
                        <form id="completeForm" method="POST" action="{{ route('lessons.complete', [$course->slug, $module->slug, $lesson->slug]) }}">
                            @csrf
                            @if($lessonEnrollment && $lessonEnrollment->completed)
                                <button type="button" disabled class="px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow">Completed</button>
                            @else
                                <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition">Mark as Completed</button>
                            @endif
                        </form>
                        <button id="download-txt" type="button" class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Download .txt</button>
                    </div>
                </div>

                @if($lesson->description)
                    <p class="text-gray-700 mb-4">{{ $lesson->description }}</p>
                @endif

                @php
                    $hasVideo = !empty($lesson->video_url);
                    $hasPresentation = $lesson->isPresentation();
                    $hasDocument = $lesson->isDocument();
                    $hasImage = $lesson->isImage();
                    $resourceUrl = $lesson->resourceUrl();
                    $label = $lesson->resourceLabel();
                    $lessonsList = $module->lessons()->where('is_published', true)->orderBy('order')->get();
                    // Precompute a simple array for use in JavaScript to avoid Blade/PHP parsing issues
                    $lessonsJs = $lessonsList->map(function($x) use ($course, $module) {
                        return [
                            'slug' => $x->slug,
                            'url' => route('lessons.show', [$course->slug, $module->slug, $x->slug])
                        ];
                    })->values()->toArray();
                @endphp

                <div id="player-area" class="w-full bg-black rounded overflow-hidden mb-4" style="min-height:320px;">
                    @if($hasVideo)
                        @php
                            $src = $lesson->video_url;
                            // Ensure enablejsapi is present for YouTube embeds
                            if (str_contains($src, 'youtube') && !str_contains($src, 'enablejsapi')) {
                                $sep = str_contains($src, '?') ? '&' : '?';
                                $src .= $sep . 'enablejsapi=1&rel=0';
                            }
                        @endphp
                        @if(str_contains($lesson->video_url, '.mp4'))
                            <video id="lesson-video" class="w-full h-auto" controls playsinline>
                                <source src="{{ $lesson->video_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <div style="position:relative;padding-top:56.25%;">
                                <iframe id="lesson-iframe" class="absolute inset-0 w-full h-full" src="{{ $src }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @endif
                    @elseif($hasPresentation)
                        <iframe class="w-full h-[560px] rounded" src="{{ $resourceUrl }}" frameborder="0"></iframe>
                    @elseif($hasDocument || $hasImage)
                        <div class="p-4">
                            @if($hasImage)
                                <img src="{{ $resourceUrl }}" alt="{{ $lesson->title }}" class="max-w-full h-auto rounded shadow"/>
                            @else
                                <a href="{{ $resourceUrl }}" target="_blank" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700 transition">Open {{ $label }}</a>
                            @endif
                        </div>
                    @else
                        <div class="p-4 text-gray-600">No media attached to this lesson.</div>
                    @endif
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500">
                    <div>
                        <a id="prev-lesson" href="#" class="inline-flex items-center px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 transition">
                            <i class="fas fa-chevron-left mr-2"></i>Previous
                        </a>
                    </div>
                    <div>
                        <span>Progress: {{ $userProgress ?? 0 }}%</span>
                    </div>
                    <div>
                        <a id="next-lesson" href="#" class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700 transition">Next<i class="fas fa-chevron-right ml-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right: Playlist -->
            <aside class="bg-white/5 rounded-xl p-4 shadow">
                <h4 class="font-semibold mb-3">Module Playlist</h4>
                <div class="space-y-2 max-h-[60vh] overflow-y-auto">
                    @foreach($lessonsList as $l)
                        @php $completed = $l->isCompletedBy(auth()->id() ?? 0); @endphp
                        <a href="{{ route('lessons.show', [$course->slug, $module->slug, $l->slug]) }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-white/10 transition {{ $l->id === $lesson->id ? 'bg-white/10 border-l-4 border-sky-500' : '' }}">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 flex items-center justify-center rounded bg-white/5 text-sm">{{ $l->order ?? '-' }}</span>
                                <div class="truncate text-sm">{{ $l->title }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($completed)
                                    <i class="fas fa-check-circle text-green-400"></i>
                                @endif
                                @if($l->id === $lesson->id)
                                    <span class="text-xs text-sky-300">Now</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const lessons = Array.from(@json($lessonsJs));
    const currentSlug = '{{ $lesson->slug }}';
    const idx = lessons.findIndex(l => l.slug === currentSlug);
    const prev = document.getElementById('prev-lesson');
    const next = document.getElementById('next-lesson');

    if (idx > 0) {
        prev.href = lessons[idx - 1].url;
    } else {
        prev.removeAttribute('href'); prev.classList.add('opacity-50','cursor-not-allowed');
    }
    if (idx < lessons.length - 1) {
        next.href = lessons[idx + 1].url;
    } else {
        next.removeAttribute('href'); next.classList.add('opacity-50','cursor-not-allowed');
    }

    // Download lesson as .txt (description + content)
    document.getElementById('download-txt')?.addEventListener('click', () => {
        const title = `{{ addslashes($lesson->title) }}`;
        const desc = `{{ addslashes($lesson->description ?? '') }}`;
        const text = `${title}\n\n${desc}`;
        const blob = new Blob([text], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = `${title.replace(/[^a-z0-9\-]/gi,'_')}.txt`; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    });

    // Autoplay next for HTML5 video
    const video = document.getElementById('lesson-video');
    if (video) {
        video.addEventListener('ended', () => { if (idx < lessons.length - 1) window.location = lessons[idx + 1].url; });
    }

    // YouTube embed API handling
    const iframe = document.getElementById('lesson-iframe');
    if (iframe && iframe.src.includes('youtube')) {
        // load API if not present
        if (!window.YT) {
            const tag = document.createElement('script'); tag.src = 'https://www.youtube.com/iframe_api'; document.head.appendChild(tag);
        }
        window.onYouTubeIframeAPIReady = function() {
            try {
                const player = new YT.Player('lesson-iframe', {
                    events: {
                        'onStateChange': function(e) {
                            if (e.data === YT.PlayerState.ENDED) {
                                if (idx < lessons.length - 1) window.location = lessons[idx + 1].url;
                            }
                        }
                    }
                });
            } catch (err) { console.warn('YT player init failed', err); }
        };
    }
});
</script>
@endpush
@endsection
