@extends('staff.layouts.masters')

@section('title', 'Competency Status')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @media (prefers-reduced-motion: no-preference) {
        .cs-animate-in {
            animation: fadeInUp .45s cubic-bezier(.16,.8,.32,1) both;
        }
        .cs-animate-fade {
            animation: fadeIn .5s ease both;
        }
        .cs-progress-bar {
            transition: width .8s cubic-bezier(.16,.8,.32,1);
        }
        .cs-row {
            animation: fadeInUp .35s cubic-bezier(.16,.8,.32,1) both;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .cs-progress-bar { transition: none; }
    }
</style>

<div class="container py-8">
    <div class="cs-animate-in flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Competency Status</h1>
            <p class="mt-1 text-slate-500">Review training modules and their assessment coverage.</p>
        </div>
        <a
            href="{{ route('staff.modules.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow-sm transition-all duration-200 hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-[.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" aria-hidden="true">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Add module
        </a>
    </div>

    @php
        // Some collections (e.g. LengthAwarePaginator) only hold the current page's items,
        // so sum()/filter() below reflect just that page unless the controller passes
        // pre-aggregated totals ($totalAssessments / $uncoveredCount) computed over all modules.
        $isPaginated = method_exists($modules, 'total');
        $totalModules = $isPaginated ? $modules->total() : $modules->count();

        $pageAssessments = $modules->sum(fn ($module) => $module->quizzes_count ?? 0);
        $pageUncovered = $modules->filter(fn ($module) => ($module->quizzes_count ?? 0) === 0)->count();

        $statsAreScoped = $isPaginated && !isset($totalAssessments) && !isset($uncoveredCount);
        $totalAssessments = $totalAssessments ?? $pageAssessments;
        $uncoveredCount = $uncoveredCount ?? $pageUncovered;

        $coveragePercent = $totalModules > 0
            ? (int) round((($totalModules - $uncoveredCount) / $totalModules) * 100)
            : 0;
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-2">
        <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 hover:shadow-md" style="animation-delay: 60ms">
            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Modules</div>
            <div class="mt-1 text-2xl font-bold text-slate-900 tabular-nums">{{ $totalModules }}</div>
        </div>
        <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 hover:shadow-md" style="animation-delay: 110ms">
            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Assessments linked</div>
            <div class="mt-1 text-2xl font-bold text-slate-900 tabular-nums">{{ $totalAssessments }}</div>
        </div>
        <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 hover:shadow-md" style="animation-delay: 160ms">
            <div class="flex items-center justify-between">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Coverage</div>
                <div class="text-xs font-semibold {{ $uncoveredCount > 0 ? 'text-amber-600' : 'text-emerald-600' }}">{{ $coveragePercent }}%</div>
            </div>
            <div class="mt-2 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden" role="progressbar" aria-valuenow="{{ $coveragePercent }}" aria-valuemin="0" aria-valuemax="100" aria-label="Percentage of modules with at least one assessment">
                <div class="cs-progress-bar h-1.5 rounded-full {{ $uncoveredCount > 0 ? 'bg-amber-500' : 'bg-emerald-500' }}" style="width: {{ $coveragePercent }}%"></div>
            </div>
            <div class="mt-1.5 text-xs text-slate-500">{{ $uncoveredCount }} {{ Str::plural('module', $uncoveredCount) }} without an assessment</div>
        </div>
    </div>

    @if($statsAreScoped)
        <p class="cs-animate-fade text-xs text-slate-400 mb-4">Assessment and coverage figures reflect the modules shown on this page.</p>
    @else
        <div class="mb-4"></div>
    @endif

    <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg shadow-sm overflow-hidden" style="animation-delay: 200ms">
        <div class="flex items-center justify-between gap-4 p-4 border-b border-slate-200">
            <div class="font-semibold text-slate-900">Modules</div>
            <div class="text-sm text-slate-500">{{ $totalModules }} total</div>
        </div>

        @if($modules->isEmpty())
            <div class="cs-animate-fade flex flex-col items-center gap-2 p-10 text-center text-slate-500">
                <svg class="w-10 h-10 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="16" rx="2" />
                    <path d="M3 9h18M8 2v4M16 2v4" />
                </svg>
                <div class="font-semibold text-slate-900">No modules yet</div>
                <p class="max-w-sm text-sm">Add a module to start organizing courses and tracking assessment coverage.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <caption class="sr-only">List of training modules with course, order, and assessment coverage</caption>
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th scope="col" class="p-4 font-semibold text-slate-600">Module</th>
                            <th scope="col" class="p-4 font-semibold text-slate-600">Course</th>
                            <th scope="col" class="p-4 font-semibold text-slate-600 text-right">Order</th>
                            <th scope="col" class="p-4 font-semibold text-slate-600">Assessments</th>
                            <th scope="col" class="p-4 font-semibold text-slate-600">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($modules as $module)
                            <tr
                                class="cs-row hover:bg-slate-50 transition-colors duration-150"
                                style="animation-delay: {{ min($loop->index, 10) * 35 }}ms"
                            >
                                <td class="p-4 font-medium text-slate-900 max-w-xs truncate" title="{{ $module->title }}">
                                    {{ $module->title }}
                                </td>
                                <td class="p-4 text-slate-600">
                                    @if($module->course)
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15Z" />
                                            </svg>
                                            <span class="truncate">{{ $module->course->title }}</span>
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic">Unassigned</span>
                                    @endif
                                </td>
                                <td class="p-4 text-slate-600 text-right tabular-nums">{{ $module->order ?? 0 }}</td>
                                <td class="p-4">
                                    @if(($module->quizzes_count ?? 0) > 0)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 transition-colors duration-150">
                                            {{ $module->quizzes_count }} {{ Str::plural('assessment', $module->quizzes_count) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 text-xs font-semibold px-2.5 py-1 transition-colors duration-150">
                                            No coverage
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right">
                                    <a
                                        class="text-blue-600 font-medium hover:text-blue-800 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 rounded transition-colors duration-150"
                                        href="{{ route('staff.modules.edit', $module) }}"
                                    >
                                        Edit<span class="sr-only"> {{ $module->title }}</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-200">{{ $modules->links() }}</div>
        @endif
    </div>
</div>
@endsection