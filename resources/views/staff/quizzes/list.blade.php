@extends('staff.layouts.masters')

@section('title', 'Quizzes')

@push('styles')
    @include('staff.quizzes._styles')
    <style>
    /* Recreated list page specific overrides (concise and maintainable) */
    .quiz-page-header { padding:1.25rem; }
    .quiz-stats-card { padding:1rem; }
    .quiz-card { border-radius:1.5rem; overflow:hidden; }
    .quiz-table thead th { padding:0.9rem 1.5rem; }
    .quiz-row td { padding:1rem 1.25rem; }
    .quiz-actions a, .quiz-actions button { font-weight:700; }
    @media (max-width:900px) { .grid { grid-template-columns: 1fr !important; } }
    </style>
@endpush

@section('content')
    <div class="container mx-auto p-6">
        <div class="quiz-page-header mb-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="min-w-0">
                    <p class="text-sm uppercase tracking-[0.3em] text-sky-600">Staff quizzes</p>
                    <h1 class="mt-2 text-4xl font-extrabold leading-tight text-slate-900">Manage all quizzes</h1>
                    <p class="mt-3 max-w-2xl text-base text-slate-600">Create, update, and organize quizzes for your active course modules. Keep assessments consistent and easy to review from a single dashboard.</p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <span class="quiz-pill"><i class="fas fa-bolt text-sky-600" aria-hidden="true"></i> Fast quiz workflow</span>
                        <span class="quiz-pill secondary"><i class="fas fa-layer-group text-slate-500" aria-hidden="true"></i> Module-linked questions</span>
                        <span class="quiz-pill secondary"><i class="fas fa-check-circle text-emerald-600" aria-hidden="true"></i> Ready to assign</span>
                    </div>
                </div>

                <div class="quiz-actions flex-shrink-0">
                    <a href="{{ route('staff.quizzes.create') }}"
                       class="quiz-button is-primary inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow transition transform hover:-translate-y-0.5 hover:scale-[1.02] focus-visible:scale-[1.02]">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        Create quiz
                    </a>
                </div>
            </div>
        </div>

        <div class="grid gap-6 grid-two mb-6">
            <div class="quiz-stats-card card rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500">Quick stats</p>
                <div class="mt-5 quiz-stat-grid">
                    <div class="quiz-stat-block">
                        <span class="quiz-stat-label">Total quizzes</span>
                        <span class="quiz-stat-value" data-count-to="{{ $quizzes->count() }}">0</span>
                    </div>
                    <div class="quiz-stat-block">
                        <span class="quiz-stat-label">Modules covered</span>
                        <span class="quiz-stat-value" data-count-to="{{ $quizzes->pluck('module.title')->unique()->filter()->count() }}">0</span>
                    </div>
                    <div class="quiz-stat-block">
                        <span class="quiz-stat-label">Avg passing score</span>
                        <span class="quiz-stat-value" data-count-to="{{ round($quizzes->avg('passing_score') ?? 0) }}">0</span>
                    </div>
                </div>
            </div>
            <div class="card rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500">Tips</p>
                <ul class="quiz-tip-list">
                    <li class="quiz-tip-item">
                        <p>Link quizzes to the correct module to keep course flow smooth.</p>
                    </li>
                    <li class="quiz-tip-item">
                        <p>Use clear titles so staff and students can find quizzes quickly.</p>
                    </li>
                </ul>
            </div>
        </div>

        @if(session('success'))
            <div class="quiz-alert mb-4 rounded-3xl border border-emerald-100 bg-emerald-50 p-5 text-sm text-emerald-800 shadow-sm" id="quiz-success-alert" role="status">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                            <i class="fas fa-circle-check" aria-hidden="true"></i>
                        </span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="document.getElementById('quiz-success-alert').remove()" class="text-emerald-500 hover:text-emerald-700" aria-label="Dismiss notification">
                        <i class="fas fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
                <span class="quiz-alert-progress w-full"></span>
            </div>
        @endif

        <div class="quiz-card overflow-hidden rounded-[28px]">
            <div class="grid gap-4 border-b border-slate-200/70 bg-slate-50/90 p-5 backdrop-blur-sm sm:grid-cols-[minmax(0,1fr)_auto] sm:items-center">
                <div class="relative w-full max-w-xl">
                    <label for="quiz-search" class="sr-only">Search quizzes or modules</label>
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" aria-hidden="true"></i>
                    <input
                        type="text"
                        id="quiz-search"
                        placeholder="Search quizzes or modules... (press / to focus)"
                        class="quiz-search-input"
                        autocomplete="off"
                    >
                    <button type="button" id="quiz-search-clear" class="quiz-search-clear" aria-label="Clear search">
                        <i class="fas fa-circle-xmark" aria-hidden="true"></i>
                    </button>
                    <span id="quiz-search-status" class="sr-only" role="status" aria-live="polite"></span>
                </div>
                <div class="flex flex-wrap items-center justify-end gap-2">
                    <span id="quiz-total-pill" class="quiz-pill"><i class="fas fa-check-circle text-sky-600" aria-hidden="true"></i> {{ $quizzes->count() }} quizzes</span>
                    <span id="quiz-modules-pill" class="quiz-pill secondary"><i class="fas fa-layer-group text-slate-500" aria-hidden="true"></i> {{ $quizzes->pluck('module.title')->unique()->filter()->count() }} modules</span>
                    @if($archivedCount > 0)
                        <a href="{{ route('staff.quizzes.archived') }}" class="quiz-pill secondary" title="View archived quizzes">
                            <i class="fas fa-archive text-slate-500" aria-hidden="true"></i>
                            {{ $archivedCount }} archived
                        </a>
                    @endif
                </div>
            </div>

            <table class="quiz-table min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Quiz</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Module</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Passing</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Created</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200" id="quiz-table-body">
                    @forelse($quizzes as $quiz)
                        @php
                            $score = (float) $quiz->passing_score;
                            if ($score >= 75) {
                                $badgeClasses = 'bg-emerald-50 text-emerald-700';
                            } elseif ($score >= 50) {
                                $badgeClasses = 'bg-amber-50 text-amber-700';
                            } else {
                                $badgeClasses = 'bg-rose-50 text-rose-700';
                            }
                            $moduleTitle = optional($quiz->module)->title ?? 'Unassigned';
                        @endphp
                        <tr class="quiz-row"
                            style="animation-delay: {{ $loop->index * 0.05 }}s;"
                            data-search="{{ strtolower($quiz->title . ' ' . $moduleTitle) }}"
                            data-module="{{ $moduleTitle }}">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <span class="quiz-icon-tile flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-50 text-sky-600">
                                        <i class="fas fa-clipboard-question" aria-hidden="true"></i>
                                    </span>
                                    <div>
                                        <div class="quiz-title-text">{{ $quiz->title }}</div>
                                        <div class="quiz-desc-text text-xs text-slate-500">{{ Str::limit($quiz->description ?? 'No description', 55) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $moduleTitle }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <span class="quiz-badge inline-flex items-center rounded-full {{ $badgeClasses }} px-3 py-1 text-xs font-semibold">
                                    {{ $quiz->passing_score }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $quiz->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('staff.quizzes.questionnaire', $quiz) }}" class="quiz-action secondary font-semibold mr-3">
                                    <i class="fas fa-list-check mr-1" aria-hidden="true"></i>Questions
                                </a>
                                <a href="{{ route('staff.quizzes.edit', $quiz) }}" class="quiz-action secondary font-semibold mr-3">
                                    <i class="fas fa-pen-to-square mr-1" aria-hidden="true"></i>Edit
                                </a>
                                <form id="quiz-archive-form-{{ $quiz->id }}" action="{{ route('staff.quizzes.archive', $quiz) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="quiz-action secondary font-semibold mr-3 text-amber-600 hover:text-amber-800" title="Archive this quiz">
                                        <i class="fas fa-box-archive mr-1" aria-hidden="true"></i>Archive
                                    </button>
                                </form>
                                <button type="button"
                                        class="quiz-delete-trigger quiz-action font-semibold text-rose-600 hover:text-rose-800"
                                        data-quiz-id="{{ $quiz->id }}"
                                        data-quiz-title="{{ $quiz->title }}">
                                    <i class="fas fa-trash mr-1" aria-hidden="true"></i>Delete
                                </button>
                                <form id="quiz-delete-form-{{ $quiz->id }}" action="{{ route('staff.quizzes.destroy', $quiz) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="quiz-empty px-6 py-20 text-center text-sm text-slate-500">
                                <div class="quiz-empty-state mx-auto max-w-md overflow-hidden rounded-[28px] border border-dashed border-slate-200 bg-gradient-to-br from-slate-50 via-slate-100 to-white p-10 shadow-sm">
                                    <span class="quiz-empty-icon mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400 shadow-sm">
                                        <i class="fas fa-inbox text-2xl" aria-hidden="true"></i>
                                    </span>
                                    <p class="mb-4 text-base font-semibold text-slate-900">No quizzes created yet</p>
                                    <p class="mb-4 text-sm text-slate-600">Start by creating a quiz for your course modules to keep learners engaged.</p>
                                    <div class="mb-6 space-y-3 text-left text-sm text-slate-600">
                                        <p class="rounded-2xl bg-white/80 p-3">• Add quiz details and attach it to the right module.</p>
                                        <p class="rounded-2xl bg-white/80 p-3">• Use the Questions button to build your question bank quickly.</p>
                                    </div>
                                    <a href="{{ route('staff.quizzes.create') }}" class="quiz-button is-primary inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-sky-700">
                                        <i class="fas fa-plus" aria-hidden="true"></i>
                                        Create your first quiz
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <p id="quiz-no-results" class="hidden px-6 py-10 text-center text-sm text-slate-500">
                No quizzes match your search.
            </p>
        </div>
    </div>

    <div id="quiz-delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="quiz-modal-overlay absolute inset-0 bg-slate-900/50" data-modal-dismiss></div>
        <div class="quiz-modal-box relative w-full max-w-sm rounded-3xl bg-white p-6 shadow-2xl"
             role="dialog"
             aria-modal="true"
             aria-labelledby="quiz-delete-modal-title">
            <div class="flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                    <i class="fas fa-triangle-exclamation" aria-hidden="true"></i>
                </span>
                <div>
                    <h2 id="quiz-delete-modal-title" class="text-lg font-semibold text-slate-900">Delete quiz?</h2>
                    <p class="mt-2 text-sm text-slate-500">Are you sure you want to delete "<span id="quiz-delete-title" class="font-medium text-slate-700"></span>"? This cannot be undone.</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="quiz-delete-cancel-btn" class="quiz-action secondary rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600" data-modal-dismiss>Cancel</button>
                <button type="button" id="quiz-delete-confirm-btn" class="quiz-action primary rounded-2xl px-4 py-2 text-sm font-semibold text-white shadow">
                    <span id="quiz-delete-confirm-label">Delete</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var quizPendingDeleteId = null;
    var quizLastTriggerEl = null;
    var quizDeletePending = false;

    var modal = document.getElementById('quiz-delete-modal');
    var titleEl = document.getElementById('quiz-delete-title');
    var confirmBtn = document.getElementById('quiz-delete-confirm-btn');
    var confirmLabel = document.getElementById('quiz-delete-confirm-label');
    var cancelBtn = document.getElementById('quiz-delete-cancel-btn');

    function isModalOpen() {
        return !modal.classList.contains('hidden');
    }

    function getFocusable() {
        return modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    }

    function openQuizDeleteModal(quizId, quizTitle, triggerEl) {
        quizPendingDeleteId = quizId;
        quizLastTriggerEl = triggerEl || null;
        // textContent (not innerHTML) so the title can never be interpreted as markup
        titleEl.textContent = quizTitle;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        cancelBtn.focus();
    }

    function closeQuizDeleteModal() {
        quizPendingDeleteId = null;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        if (quizLastTriggerEl) {
            quizLastTriggerEl.focus();
            quizLastTriggerEl = null;
        }
    }

    // Delegate delete-trigger clicks; title/id come from data-* attributes
    // (Blade-escaped on render), never interpolated into inline JS.
    document.getElementById('quiz-table-body').addEventListener('click', function (e) {
        var trigger = e.target.closest('.quiz-delete-trigger');
        if (!trigger) return;
        openQuizDeleteModal(trigger.dataset.quizId, trigger.dataset.quizTitle, trigger);
    });

    modal.querySelectorAll('[data-modal-dismiss]').forEach(function (el) {
        el.addEventListener('click', closeQuizDeleteModal);
    });

    confirmBtn.addEventListener('click', function () {
        if (quizDeletePending || quizPendingDeleteId === null) return;
        var form = document.getElementById('quiz-delete-form-' + quizPendingDeleteId);
        if (!form) return;

        quizDeletePending = true;
        confirmBtn.disabled = true;
        confirmBtn.setAttribute('aria-disabled', 'true');
        confirmLabel.innerHTML = '<i class="fas fa-circle-notch quiz-spin" aria-hidden="true"></i><span class="sr-only">Deleting…</span>';
        form.submit();
    });

    document.addEventListener('keydown', function (e) {
        if (!isModalOpen()) return;

        if (e.key === 'Escape') {
            closeQuizDeleteModal();
            return;
        }

        // Basic focus trap while modal is open
        if (e.key === 'Tab') {
            var focusable = Array.prototype.slice.call(getFocusable());
            if (focusable.length === 0) return;
            var first = focusable[0];
            var last = focusable[focusable.length - 1];

            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    });

    // Animated stat counters (start when stats card becomes visible)
    function startStatCounters() {
        document.querySelectorAll('.quiz-stat-value').forEach(function (el) {
            var target = parseInt(el.getAttribute('data-count-to'), 10) || 0;
            if (target === 0) {
                el.textContent = '0';
                return;
            }
            var duration = 900;
            var start = performance.now();
            function tick(now) {
                var progress = Math.min((now - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(eased * target);
                if (progress < 1) requestAnimationFrame(tick);
                else el.textContent = target;
            }
            requestAnimationFrame(tick);
        });
    }

    var statsCard = document.querySelector('.quiz-stats-card');
    if (statsCard && 'IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    startStatCounters();
                    obs.disconnect();
                }
            });
        }, { threshold: 0.25 });
        obs.observe(statsCard);
    } else {
        // fallback
        startStatCounters();
    }

    // Auto-dismiss success alert
    var quizSuccessAlert = document.getElementById('quiz-success-alert');
    if (quizSuccessAlert) {
        setTimeout(function () {
            if (quizSuccessAlert && quizSuccessAlert.parentNode) {
                quizSuccessAlert.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                quizSuccessAlert.style.opacity = '0';
                quizSuccessAlert.style.transform = 'translateX(24px)';
                setTimeout(function () { quizSuccessAlert.remove(); }, 300);
            }
        }, 5000);
    }

    // Live search filter (debounced)
    var searchInput = document.getElementById('quiz-search');
    var searchClearBtn = document.getElementById('quiz-search-clear');
    var searchStatus = document.getElementById('quiz-search-status');
    var noResults = document.getElementById('quiz-no-results');
    var rows = document.querySelectorAll('#quiz-table-body .quiz-row');
    var totalPill = document.getElementById('quiz-total-pill');
    var modulesPill = document.getElementById('quiz-modules-pill');
    var debounceTimer = null;
    var lastAppliedTerm = null;

    // HTML-escape a string. Every character maps to its HTML entity;
    // forward slash is left as-is (it needs no HTML escaping — escaping
    // it as "\/" is a JSON convention, not an HTML one, and would corrupt
    // any title or description that contains a slash).
    function escapeHtml(unsafe) {
        return unsafe.replace(/[&<>"']/g, function (m) {
            return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m];
        });
    }

    function highlightMatches(text, term) {
        if (!term) return escapeHtml(text);
        var safeTerm = term.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
        var re = new RegExp('(' + safeTerm + ')', 'ig');
        return escapeHtml(text).replace(re, '<mark class="quiz-highlight">$1</mark>');
    }

    function filterQuizRows(query) {
        var term = (query || '').trim().toLowerCase();
        if (term === lastAppliedTerm) return;
        lastAppliedTerm = term;

        var visibleCount = 0;
        var visibleModules = new Set();

        rows.forEach(function (row) {
            var haystack = row.getAttribute('data-search') || '';
            var matches = term === '' ? true : haystack.indexOf(term) !== -1;
            row.classList.toggle('is-hidden', !matches);

            var titleDiv = row.querySelector('.quiz-title-text');
            var descDiv = row.querySelector('.quiz-desc-text');
            if (titleDiv) titleDiv.innerHTML = highlightMatches(titleDiv.textContent || '', term);
            if (descDiv) descDiv.innerHTML = highlightMatches(descDiv.textContent || '', term);

            if (matches) {
                visibleCount++;
                var moduleName = row.getAttribute('data-module');
                if (moduleName) visibleModules.add(moduleName);
            }
        });

        if (noResults) {
            noResults.classList.toggle('hidden', rows.length === 0 || visibleCount > 0);
        }

        if (searchStatus) {
            searchStatus.textContent = term === ''
                ? ''
                : visibleCount + ' ' + (visibleCount === 1 ? 'quiz' : 'quizzes') + ' found';
        }

        if (totalPill) {
            totalPill.innerHTML = '<i class="fas fa-check-circle text-sky-600" aria-hidden="true"></i> '
                + visibleCount + ' ' + (visibleCount === 1 ? 'quiz' : 'quizzes');
            pulseOnce(totalPill);
        }

        if (modulesPill) {
            modulesPill.innerHTML = '<i class="fas fa-layer-group text-slate-500" aria-hidden="true"></i> '
                + visibleModules.size + ' ' + (visibleModules.size === 1 ? 'module' : 'modules');
            pulseOnce(modulesPill);
        }

        if (searchClearBtn) {
            searchClearBtn.classList.toggle('is-visible', term !== '');
        }
    }

    function pulseOnce(el) {
        el.classList.remove('pill-pulse');
        void el.offsetWidth; // restart animation
        el.classList.add('pill-pulse');
        setTimeout(function () { el.classList.remove('pill-pulse'); }, 600);
    }

    function clearQuizSearch() {
        if (!searchInput) return;
        searchInput.value = '';
        filterQuizRows('');
        searchInput.focus();
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var value = this.value;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () { filterQuizRows(value); }, 150);
        });

        // Pressing Enter jumps to first visible quiz
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var first = document.querySelector('#quiz-table-body .quiz-row:not(.is-hidden)');
                if (first) {
                    first.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    var edit = first.querySelector('a.quiz-action[href]');
                    if (edit) edit.focus();
                }
            } else if (e.key === 'Escape' && this.value !== '') {
                // Clear the search first; only bubble up to close anything else
                // (e.g. the delete modal) if the field was already empty.
                e.stopPropagation();
                clearQuizSearch();
            }
        });

        if (searchClearBtn) {
            searchClearBtn.addEventListener('click', clearQuizSearch);
        }

        // Keyboard shortcut: press '/' to focus search, unless typing
        // elsewhere or the delete modal is open.
        document.addEventListener('keydown', function (e) {
            if (e.key !== '/' || isModalOpen()) return;
            var tag = document.activeElement.tagName.toLowerCase();
            if (tag === 'input' || tag === 'textarea') return;
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        });
    }

    // Subtle one-time pulse for empty-state CTA to draw attention
    var emptyCta = document.querySelector('.quiz-empty-state .quiz-button.is-primary');
    if (emptyCta) {
        setTimeout(function () {
            emptyCta.classList.add('pulse-cta-once');
            setTimeout(function () { emptyCta.classList.remove('pulse-cta-once'); }, 2400);
        }, 600);
    }
})();
</script>
@endpush