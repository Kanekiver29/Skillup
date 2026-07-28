

<?php $__env->startSection('title', 'Lessons'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Support both a plain Collection and a paginator without breaking either.
    $lessonItems  = method_exists($lessons, 'getCollection') ? $lessons->getCollection() : $lessons;
    $totalLessons = method_exists($lessons, 'total') ? $lessons->total() : $lessons->count();
    $courseCount  = $lessonItems->pluck('course.title')->filter()->unique()->count();
    $moduleCount  = $lessonItems->pluck('module.title')->filter()->unique()->count();
    $lastUpdated  = $lessonItems->max('updated_at');

    $badgePalette = [
        'border-cyan-500/25 bg-cyan-500/10 text-cyan-300',
        'border-violet-500/25 bg-violet-500/10 text-violet-300',
        'border-emerald-500/25 bg-emerald-500/10 text-emerald-300',
        'border-amber-500/25 bg-amber-500/10 text-amber-300',
        'border-rose-500/25 bg-rose-500/10 text-rose-300',
        'border-sky-500/25 bg-sky-500/10 text-sky-300',
    ];
    $colorFor = function ($seed) use ($badgePalette) {
        if (!$seed) return $badgePalette[0];
        return $badgePalette[crc32($seed) % count($badgePalette)];
    };
    $initialsFor = function ($seed) {
        if (!$seed) return '--';
        $words = preg_split('/\s+/', trim($seed));
        $letters = strtoupper(($words[0][0] ?? '') . ($words[1][0] ?? ''));
        return $letters ?: strtoupper(substr($seed, 0, 2));
    };
?>

<style>
    @keyframes ll-fade-up {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .ll-row-in { animation: ll-fade-up 0.4s cubic-bezier(0.16,1,0.3,1) both; }

    @keyframes ll-pulse-glow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34,211,238,0.25); }
        50%      { box-shadow: 0 0 0 6px rgba(34,211,238,0); }
    }
    .ll-glow-dot { animation: ll-pulse-glow 2.2s ease-in-out infinite; }

    .ll-orb {
        position: absolute;
        border-radius: 9999px;
        filter: blur(90px);
        pointer-events: none;
        opacity: 0.35;
    }

    .ll-sort-btn i { transition: transform 0.2s ease, opacity 0.2s ease; opacity: 0.35; }
    .ll-sort-btn.asc i, .ll-sort-btn.desc i { opacity: 1; color: #22d3ee; }
    .ll-sort-btn.desc i { transform: rotate(180deg); }

    @media (prefers-reduced-motion: reduce) {
        .ll-row-in, .ll-glow-dot { animation: none !important; }
    }
</style>

<div class="relative min-h-screen overflow-hidden bg-slate-950 py-8 px-4 sm:px-6 lg:px-8">
    
    <div class="ll-orb -top-24 -left-24 h-72 w-72 bg-cyan-500" aria-hidden="true"></div>
    <div class="ll-orb -bottom-32 -right-16 h-80 w-80 bg-violet-500" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-7xl">
        <div class="mb-8 rounded-3xl border border-slate-700/70 bg-slate-900/90 p-6 shadow-xl shadow-slate-950/30 backdrop-blur-xl">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="min-w-0">
                    <p class="flex items-center gap-2 text-sm uppercase tracking-[0.35em] text-cyan-400">
                        <span class="ll-glow-dot inline-block h-1.5 w-1.5 rounded-full bg-cyan-400"></span>
                        Staff lessons
                    </p>
                    <h1 class="mt-3 text-4xl font-semibold text-white">Manage your lesson library</h1>
                    <p class="mt-3 max-w-2xl text-sm text-slate-400">Create, update, and track all lesson assets assigned to your course modules.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="<?php echo e(route('staff.lessons.create')); ?>" class="inline-flex items-center gap-2 rounded-2xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-cyan-500/20 transition hover:-translate-y-0.5 hover:bg-cyan-400 hover:shadow-cyan-500/30">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        New lesson
                    </a>
                    <a href="<?php echo e(route('staff.lessons.archived')); ?>" class="inline-flex items-center gap-2 rounded-2xl border border-slate-700 bg-slate-800 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:-translate-y-0.5 hover:border-cyan-400 hover:text-white">
                        <i class="fas fa-box-archive" aria-hidden="true"></i>
                        Archived lessons
                    </a>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 flex items-center gap-3 rounded-3xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-100 shadow-sm" role="alert">
                <i class="fas fa-circle-check" aria-hidden="true"></i>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 flex items-center gap-3 rounded-3xl border border-rose-500/20 bg-rose-500/10 p-4 text-sm text-rose-100 shadow-sm" role="alert">
                <i class="fas fa-triangle-exclamation" aria-hidden="true"></i>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-3xl border border-slate-700/70 bg-slate-900/90 p-5 shadow-lg shadow-slate-950/20">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-500/10 text-cyan-300">
                    <i class="fas fa-book-open" aria-hidden="true"></i>
                </div>
                <p class="mt-4 text-3xl font-semibold text-white"><?php echo e($totalLessons); ?></p>
                <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-500">Total lessons</p>
            </div>
            <div class="rounded-3xl border border-slate-700/70 bg-slate-900/90 p-5 shadow-lg shadow-slate-950/20">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-500/10 text-violet-300">
                    <i class="fas fa-layer-group" aria-hidden="true"></i>
                </div>
                <p class="mt-4 text-3xl font-semibold text-white"><?php echo e($courseCount); ?></p>
                <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-500">Courses covered</p>
            </div>
            <div class="rounded-3xl border border-slate-700/70 bg-slate-900/90 p-5 shadow-lg shadow-slate-950/20">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-300">
                    <i class="fas fa-diagram-project" aria-hidden="true"></i>
                </div>
                <p class="mt-4 text-3xl font-semibold text-white"><?php echo e($moduleCount); ?></p>
                <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-500">Modules covered</p>
            </div>
            <div class="rounded-3xl border border-slate-700/70 bg-slate-900/90 p-5 shadow-lg shadow-slate-950/20">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-300">
                    <i class="fas fa-clock-rotate-left" aria-hidden="true"></i>
                </div>
                <p class="mt-4 text-xl font-semibold text-white"><?php echo e($lastUpdated ? $lastUpdated->diffForHumans() : 'No activity yet'); ?></p>
                <p class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-500">Last updated</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-[28px] border border-slate-700 bg-slate-900/90 shadow-xl shadow-slate-950/20">
            <div class="border-b border-slate-700/70 bg-slate-950/60 px-6 py-5 backdrop-blur-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-100">Active lessons</h2>
                        <p class="mt-1 text-sm text-slate-500">All lessons that are currently available for staff management.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full border border-slate-700 bg-slate-900/70 px-4 py-2 text-sm font-semibold text-slate-300">
                        <?php echo e($totalLessons); ?> lessons
                    </span>
                </div>

                <?php if(!$lessonItems->isEmpty()): ?>
                    <div class="mt-4 relative">
                        <i class="fas fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-500" aria-hidden="true"></i>
                        <input
                            type="text"
                            id="lesson-search"
                            placeholder="Search by lesson, course, or module…"
                            class="w-full rounded-2xl border border-slate-700 bg-slate-900/80 py-3 pl-11 pr-11 text-sm text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20"
                            autocomplete="off"
                        >
                        <button
                            type="button"
                            id="lesson-search-clear"
                            class="absolute right-3 top-1/2 hidden -translate-y-1/2 text-slate-500 transition hover:text-slate-200"
                            aria-label="Clear search"
                        >
                            <i class="fas fa-circle-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($lessonItems->isEmpty()): ?>
                <div class="px-6 py-16 text-center text-slate-400">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-500/10 text-cyan-300">
                        <i class="fas fa-book-open text-xl" aria-hidden="true"></i>
                    </div>
                    <p class="text-xl font-semibold text-slate-100">No lessons created yet</p>
                    <p class="mt-3 max-w-2xl mx-auto text-sm text-slate-500">Use the button below to add your first lesson and attach it to a module.</p>
                    <a href="<?php echo e(route('staff.lessons.create')); ?>" class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-cyan-500/20 transition hover:bg-cyan-400">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        Create your first lesson
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-300" id="lessons-table">
                        <thead class="border-b border-slate-700/70 bg-slate-950/80 text-slate-400">
                            <tr>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">
                                    <button type="button" class="ll-sort-btn flex items-center gap-2" data-sort-key="title">
                                        Lesson <i class="fas fa-arrow-up text-[10px]" aria-hidden="true"></i>
                                    </button>
                                </th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">
                                    <button type="button" class="ll-sort-btn flex items-center gap-2" data-sort-key="course">
                                        Course <i class="fas fa-arrow-up text-[10px]" aria-hidden="true"></i>
                                    </button>
                                </th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">
                                    <button type="button" class="ll-sort-btn flex items-center gap-2" data-sort-key="module">
                                        Module <i class="fas fa-arrow-up text-[10px]" aria-hidden="true"></i>
                                    </button>
                                </th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">
                                    <button type="button" class="ll-sort-btn flex items-center gap-2" data-sort-key="order">
                                        Order <i class="fas fa-arrow-up text-[10px]" aria-hidden="true"></i>
                                    </button>
                                </th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em]">
                                    <button type="button" class="ll-sort-btn flex items-center gap-2" data-sort-key="updated">
                                        Updated <i class="fas fa-arrow-up text-[10px]" aria-hidden="true"></i>
                                    </button>
                                </th>
                                <th class="px-6 py-4 font-semibold uppercase tracking-[0.2em] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-900/80" id="lessons-tbody">
                            <?php $__currentLoopData = $lessonItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $courseTitle = $lesson->course?->title;
                                    $moduleTitle = $lesson->module?->title;
                                ?>
                                <tr
                                    class="ll-row-in hover:bg-slate-950/80 transition-colors duration-150"
                                    style="animation-delay: <?php echo e(min($loop->index, 12) * 40); ?>ms"
                                    data-title="<?php echo e(strtolower($lesson->title)); ?>"
                                    data-course="<?php echo e(strtolower($courseTitle ?? '')); ?>"
                                    data-module="<?php echo e(strtolower($moduleTitle ?? '')); ?>"
                                    data-order="<?php echo e((int) $lesson->order); ?>"
                                    data-updated="<?php echo e($lesson->updated_at->timestamp); ?>"
                                >
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 shrink-0 rounded-2xl bg-cyan-500/10 text-cyan-300 flex items-center justify-center">
                                                <i class="fas fa-book-open" aria-hidden="true"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-semibold text-white"><?php echo e($lesson->title); ?></p>
                                                <p class="text-xs text-slate-500 truncate"><?php echo e(Str::limit($lesson->description ?: 'No description provided.', 60)); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($courseTitle): ?>
                                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold <?php echo e($colorFor($courseTitle)); ?>">
                                                <span class="flex h-4 w-4 items-center justify-center rounded-full bg-white/10 text-[9px]"><?php echo e($initialsFor($courseTitle)); ?></span>
                                                <?php echo e($courseTitle); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-slate-500">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($moduleTitle): ?>
                                            <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold <?php echo e($colorFor($moduleTitle)); ?>">
                                                <?php echo e($moduleTitle); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-slate-500">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-full border border-slate-700 bg-slate-950/60 px-2 text-xs font-semibold text-slate-200">
                                            <?php echo e($lesson->order); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-300" title="<?php echo e($lesson->updated_at->format('M d, Y \a\t g:i A')); ?>">
                                        <?php echo e($lesson->updated_at->format('M d, Y')); ?>

                                        <span class="block text-xs text-slate-500"><?php echo e($lesson->updated_at->diffForHumans()); ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="<?php echo e(route('staff.lessons.edit', $lesson)); ?>" class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-950/80 px-4 py-2 text-xs font-semibold text-slate-100 transition hover:border-cyan-400 hover:text-cyan-300">
                                                <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                                Edit
                                            </a>
                                            <?php if(Route::has('staff.lessons.archive')): ?>
                                                <form action="<?php echo e(route('staff.lessons.archive', $lesson)); ?>" method="POST" onsubmit="return confirm('Archive this lesson? You can restore it later from Archived lessons.');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-950/80 px-4 py-2 text-xs font-semibold text-slate-300 transition hover:border-rose-400 hover:text-rose-300">
                                                        <i class="fas fa-box-archive" aria-hidden="true"></i>
                                                        Archive
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr id="lessons-no-results" class="hidden">
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <i class="fas fa-filter-circle-xmark mr-2" aria-hidden="true"></i>
                                    No lessons match your search.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?php if(method_exists($lessons, 'links')): ?>
                    <div class="border-t border-slate-800 px-6 py-5">
                        <?php echo e($lessons->links()); ?>

                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    var searchInput = document.getElementById('lesson-search');
    var clearBtn    = document.getElementById('lesson-search-clear');
    var tbody       = document.getElementById('lessons-tbody');
    var noResults   = document.getElementById('lessons-no-results');
    if (!tbody) return;

    var rows = Array.prototype.slice.call(tbody.querySelectorAll('tr')).filter(function (r) {
        return r.id !== 'lessons-no-results';
    });

    /* ── Search filter ─────────────────────────────────── */
    function applyFilter() {
        if (!searchInput) return;
        var q = searchInput.value.trim().toLowerCase();
        var visibleCount = 0;

        rows.forEach(function (row) {
            var haystack = (row.dataset.title || '') + ' ' + (row.dataset.course || '') + ' ' + (row.dataset.module || '');
            var match = !q || haystack.indexOf(q) !== -1;
            row.classList.toggle('hidden', !match);
            if (match) visibleCount++;
        });

        if (noResults) noResults.classList.toggle('hidden', visibleCount !== 0);
        if (clearBtn) clearBtn.classList.toggle('hidden', !q);
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            applyFilter();
            searchInput.focus();
        });
    }

    /* ── Column sorting ────────────────────────────────── */
    var sortState = { key: null, dir: 1 };

    document.querySelectorAll('.ll-sort-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var key = btn.dataset.sortKey;
            sortState.dir = (sortState.key === key) ? sortState.dir * -1 : 1;
            sortState.key = key;

            document.querySelectorAll('.ll-sort-btn').forEach(function (b) {
                b.classList.remove('asc', 'desc');
            });
            btn.classList.add(sortState.dir === 1 ? 'asc' : 'desc');

            var sorted = rows.slice().sort(function (a, b) {
                var av, bv;
                if (key === 'order' || key === 'updated') {
                    av = parseFloat(a.dataset[key]) || 0;
                    bv = parseFloat(b.dataset[key]) || 0;
                    return (av - bv) * sortState.dir;
                }
                av = a.dataset[key] || '';
                bv = b.dataset[key] || '';
                return av.localeCompare(bv) * sortState.dir;
            });

            sorted.forEach(function (row) { tbody.appendChild(row); });
            if (noResults) tbody.appendChild(noResults);
        });
    });

    applyFilter();
})();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/lessons/list.blade.php ENDPATH**/ ?>