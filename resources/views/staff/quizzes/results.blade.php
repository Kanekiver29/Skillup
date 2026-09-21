@extends('staff.layouts.masters')

@section('title', 'Assessment Results')

@section('content')
@php
    $resultsCollection = $results instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator
        ? collect($results->items())
        : collect($results);

    $attempts = $resultsCollection->count();
    $passedCount = $resultsCollection->filter(fn ($result) => (bool) $result->passed)->count();
    $averageScore = $attempts
        ? round($resultsCollection->avg(fn ($result) => (float) ($result->score_percentage ?? 0)), 1)
        : 0;
    $passRate = $attempts ? round(($passedCount / $attempts) * 100, 1) : 0;
@endphp

<div class="results-page py-8">
    <div class="container">

        {{-- ================= OVERVIEW HEADER ================= --}}
        <div class="overview-panel reveal mb-8 rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-[0_20px_45px_-25px_rgba(15,23,42,0.45)] backdrop-blur-sm" style="--reveal-delay: 0ms;">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="mb-3 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-blue-700">
                        <span class="h-2 w-2 rounded-full bg-blue-600 animate-pulse"></span>
                        Staff Portal · Assessment Systems
                    </p>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Assessment Results</h1>
                    <p class="mt-2 max-w-xl text-sm text-slate-500">
                        Review completed assessment attempts and outcomes across the learner roster.
                    </p>
                </div>

                <div class="flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-500 shadow-sm">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.9)]"></span>
                    Synced just now
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="stat-card reveal border border-slate-200 bg-slate-50/60 p-4 shadow-sm" style="--reveal-delay: 120ms;">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600">
                        <i class="fas fa-clipboard-list text-lg"></i>
                    </div>
                    <div class="text-3xl font-bold text-slate-900 stat-number" data-count="{{ $attempts }}">0</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Attempts</div>
                </div>

                <div class="stat-card reveal border border-emerald-200 bg-emerald-50/70 p-4 shadow-sm" style="--reveal-delay: 180ms;">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div class="text-3xl font-bold text-emerald-700 stat-number" data-count="{{ $passedCount }}">0</div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700/80">Passed</div>
                </div>

                <div class="stat-card reveal border border-violet-200 bg-violet-50/70 p-4 shadow-sm" style="--reveal-delay: 240ms;">
                    <div class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-600">
                        <i class="fas fa-chart-line text-lg"></i>
                    </div>
                    <div class="text-3xl font-bold text-violet-700">
                        <span class="stat-number" data-count="{{ $averageScore }}" data-decimals="1">0</span>%
                    </div>
                    <div class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-violet-700/80">Avg score</div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="results-card reveal overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-[0_18px_45px_-25px_rgba(15,23,42,0.45)]" style="--reveal-delay: 260ms;">

            @if($results->isEmpty())
                <div class="empty-state flex flex-col items-center justify-center gap-4 p-14 text-center">
                    <svg class="empty-illustration h-24 w-24" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="100" cy="100" r="90" fill="#eef2ff" />
                        <rect x="60" y="55" width="80" height="100" rx="10" fill="#c7d2fe" />
                        <rect x="72" y="72" width="56" height="8" rx="4" fill="#6366f1" />
                        <rect x="72" y="90" width="56" height="8" rx="4" fill="#a5b4fc" />
                        <rect x="72" y="108" width="36" height="8" rx="4" fill="#a5b4fc" />
                        <circle cx="140" cy="140" r="22" fill="#4f46e5" />
                        <path d="M131 140l6 6 12-12" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                    </svg>
                    <p class="text-lg font-semibold text-slate-700">No assessment results are available.</p>
                    <p class="text-sm text-slate-500">Once trainees complete an assessment, their results will appear here.</p>
                </div>
            @else
                {{-- toolbar --}}
                <div class="flex flex-col gap-3 border-b border-slate-100 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="relative w-full sm:max-w-xs">
                        <i class="fas fa-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input
                            type="text"
                            id="resultSearch"
                            placeholder="Search this page (trainee or assessment)"
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-9 pr-3 text-sm text-slate-700 outline-none transition-colors duration-200 focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        />
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <span class="hidden sm:inline">Filters apply to the current page only</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="sticky top-0 z-10 bg-slate-50/90 backdrop-blur">
                            <tr>
                                <th scope="col" class="p-4 font-semibold text-slate-700">Trainee</th>
                                <th scope="col" class="p-4 font-semibold text-slate-700">Assessment</th>
                                <th scope="col" class="p-4 font-semibold text-slate-700">Score</th>
                                <th scope="col" class="p-4 font-semibold text-slate-700">Result</th>
                                <th scope="col" class="p-4 font-semibold text-slate-700">Completed</th>
                            </tr>
                        </thead>
                        <tbody id="resultsBody">
                            @foreach($results as $result)
                                @php
                                    $scorePct = (float) ($result->score_percentage ?? 0);
                                    $scoreColor = $scorePct >= 75 ? 'emerald' : ($scorePct >= 50 ? 'amber' : 'rose');
                                    $traineeName = $result->user?->name ?? 'Unknown trainee';
                                    $traineeEmail = $result->user?->email ?? 'No email provided';
                                    $assessmentTitle = $result->quiz?->title ?? 'Deleted assessment';
                                @endphp
                                <tr
                                    class="result-row border-b border-slate-100 transition-all duration-300 last:border-b-0 hover:bg-slate-50/80 hover:shadow-[inset_0_0_0_1px_rgba(148,163,184,0.25)]"
                                    style="animation-delay: {{ $loop->index * 60 }}ms;"
                                    data-search="{{ Str::lower($traineeName . ' ' . $traineeEmail . ' ' . $assessmentTitle) }}"
                                >
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar-badge flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 text-sm font-semibold text-white shadow-sm transition-transform duration-300">
                                                {{ Str::upper(Str::substr($traineeName, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-800">{{ $traineeName }}</div>
                                                <div class="text-xs text-slate-500">{{ $traineeEmail }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium text-slate-700">{{ $assessmentTitle }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-col gap-1.5">
                                            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-2.5 py-1.5 font-semibold text-slate-700">
                                                <span class="h-2 w-2 rounded-full bg-{{ $scoreColor }}-500"></span>
                                                {{ number_format($scorePct, 1) }}%
                                            </div>
                                            <div class="score-track h-1.5 w-24 overflow-hidden rounded-full bg-slate-100">
                                                <div class="score-fill h-full rounded-full bg-{{ $scoreColor }}-500" data-width="{{ min(100, max(0, $scorePct)) }}" style="width: 0%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <span class="status-pill inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $result->passed ? 'bg-emerald-100 text-emerald-700 ring-1 ring-inset ring-emerald-200' : 'bg-rose-100 text-rose-700 ring-1 ring-inset ring-rose-200' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $result->passed ? 'bg-emerald-500 status-dot-pass' : 'bg-rose-500' }}"></span>
                                            {{ $result->passed ? 'Passed' : 'Not passed' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-slate-600">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex h-2.5 w-2.5 shrink-0 rounded-full bg-sky-500 shadow-[0_0_10px_rgba(14,165,233,0.8)]"></span>
                                            <div>
                                                <div>{{ $result->completed_at?->format('M j, Y g:i A') ?? 'In progress' }}</div>
                                                @if($result->completed_at)
                                                    <div class="text-xs text-slate-400">{{ $result->completed_at->diffForHumans() }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <p id="noMatches" class="hidden p-8 text-center text-sm text-slate-400">
                        No rows on this page match your search.
                    </p>
                </div>

                @if(method_exists($results, 'links'))
                    <div class="border-t border-slate-200 bg-slate-50/60 p-4">
                        <div class="flex items-center justify-between gap-3 text-sm text-slate-500">
                            <span>Showing {{ $results->count() }} of {{ $results->total() }} attempts</span>
                            <div class="rounded-full border border-slate-200 bg-white px-3 py-1.5 shadow-sm">
                                {{ $passRate }}% pass rate
                            </div>
                        </div>
                        <div class="mt-4">{{ $results->links() }}</div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<style>
    /* ---------- Keyframes ---------- */
    @keyframes revealUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes resultFadeUp {
        from { opacity: 0; transform: translateY(12px) scale(0.985); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes floatBlob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%      { transform: translate(15px, -10px) scale(1.08); }
    }

    @keyframes dotPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.45); }
        50%      { box-shadow: 0 0 0 5px rgba(16, 185, 129, 0); }
    }

    /* ---------- Header / stats card styling ---------- */
    .overview-panel { position: relative; isolation: isolate; }

    .stat-card {
        border-radius: 1.25rem;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px -18px rgba(15, 23, 42, 0.5);
    }

    /* ---------- Reveal / rows ---------- */
    .reveal {
        opacity: 0;
        animation: revealUp 0.55s ease-out forwards;
        animation-delay: var(--reveal-delay, 0ms);
    }

    .result-row {
        opacity: 0;
        animation: resultFadeUp 0.45s ease-out forwards;
    }
    .result-row:hover td { transform: translateY(-1px); }
    .result-row:hover .avatar-badge { transform: scale(1.08) rotate(-2deg); }

    .score-fill { transition: width 0.9s cubic-bezier(0.22, 1, 0.36, 1); }

    .status-dot-pass { animation: dotPulse 1.8s ease-in-out infinite; }

    .empty-illustration { animation: floatBlob 5s ease-in-out infinite; }

    /* Respect users who prefer reduced motion */
    @media (prefers-reduced-motion: reduce) {
        .reveal, .result-row, .blob, .ring-fill, .score-fill,
        .avatar-badge, .status-dot-pass, .empty-illustration {
            animation: none !important;
            transition: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
    }
</style>

<script>
    (function () {
        var root = document.currentScript.closest('.results-page');
        if (!root) return;

        /* Animated count-up numbers */
        var counters = root.querySelectorAll('.stat-number');
        counters.forEach(function (el) {
            var target = parseFloat(el.getAttribute('data-count')) || 0;
            var decimals = parseInt(el.getAttribute('data-decimals') || '0', 10);
            var duration = 900;
            var start = null;

            function step(timestamp) {
                if (!start) start = timestamp;
                var progress = Math.min((timestamp - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                var value = target * eased;
                el.textContent = decimals > 0 ? value.toFixed(decimals) : Math.round(value);
                if (progress < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        });

        /* Animated score bars, staggered */
        var fills = root.querySelectorAll('.score-fill');
        fills.forEach(function (el, index) {
            var width = el.getAttribute('data-width') || 0;
            setTimeout(function () {
                el.style.width = width + '%';
            }, 300 + index * 60);
        });

        /* Client-side search across the currently rendered page */
        var searchInput = root.querySelector('#resultSearch');
        var rows = root.querySelectorAll('.result-row');
        var noMatches = root.querySelector('#noMatches');

        if (searchInput && rows.length) {
            searchInput.addEventListener('input', function () {
                var query = searchInput.value.trim().toLowerCase();
                var visibleCount = 0;

                rows.forEach(function (row) {
                    var haystack = row.getAttribute('data-search') || '';
                    var matches = haystack.indexOf(query) !== -1;
                    row.style.display = matches ? '' : 'none';
                    if (matches) visibleCount++;
                });

                if (noMatches) {
                    noMatches.classList.toggle('hidden', visibleCount !== 0 || query === '');
                }
            });
        }
    })();
</script>
@endsection