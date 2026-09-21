

<?php $__env->startSection('title', 'Competency Status'); ?>

<?php $__env->startSection('content'); ?>
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
            href="<?php echo e(route('staff.modules.create')); ?>"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white font-medium shadow-sm transition-all duration-200 hover:bg-blue-700 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-[.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" aria-hidden="true">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Add module
        </a>
    </div>

    <?php
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
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-2">
        <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 hover:shadow-md" style="animation-delay: 60ms">
            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Modules</div>
            <div class="mt-1 text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($totalModules); ?></div>
        </div>
        <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 hover:shadow-md" style="animation-delay: 110ms">
            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Assessments linked</div>
            <div class="mt-1 text-2xl font-bold text-slate-900 tabular-nums"><?php echo e($totalAssessments); ?></div>
        </div>
        <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg p-4 shadow-sm transition-shadow duration-200 hover:shadow-md" style="animation-delay: 160ms">
            <div class="flex items-center justify-between">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Coverage</div>
                <div class="text-xs font-semibold <?php echo e($uncoveredCount > 0 ? 'text-amber-600' : 'text-emerald-600'); ?>"><?php echo e($coveragePercent); ?>%</div>
            </div>
            <div class="mt-2 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden" role="progressbar" aria-valuenow="<?php echo e($coveragePercent); ?>" aria-valuemin="0" aria-valuemax="100" aria-label="Percentage of modules with at least one assessment">
                <div class="cs-progress-bar h-1.5 rounded-full <?php echo e($uncoveredCount > 0 ? 'bg-amber-500' : 'bg-emerald-500'); ?>" style="width: <?php echo e($coveragePercent); ?>%"></div>
            </div>
            <div class="mt-1.5 text-xs text-slate-500"><?php echo e($uncoveredCount); ?> <?php echo e(Str::plural('module', $uncoveredCount)); ?> without an assessment</div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statsAreScoped): ?>
        <p class="cs-animate-fade text-xs text-slate-400 mb-4">Assessment and coverage figures reflect the modules shown on this page.</p>
    <?php else: ?>
        <div class="mb-4"></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="cs-animate-in bg-white ring-1 ring-slate-200 rounded-lg shadow-sm overflow-hidden" style="animation-delay: 200ms">
        <div class="flex items-center justify-between gap-4 p-4 border-b border-slate-200">
            <div class="font-semibold text-slate-900">Modules</div>
            <div class="text-sm text-slate-500"><?php echo e($totalModules); ?> total</div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($modules->isEmpty()): ?>
            <div class="cs-animate-fade flex flex-col items-center gap-2 p-10 text-center text-slate-500">
                <svg class="w-10 h-10 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <rect x="3" y="4" width="18" height="16" rx="2" />
                    <path d="M3 9h18M8 2v4M16 2v4" />
                </svg>
                <div class="font-semibold text-slate-900">No modules yet</div>
                <p class="max-w-sm text-sm">Add a module to start organizing courses and tracking assessment coverage.</p>
            </div>
        <?php else: ?>
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
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr
                                class="cs-row hover:bg-slate-50 transition-colors duration-150"
                                style="animation-delay: <?php echo e(min($loop->index, 10) * 35); ?>ms"
                            >
                                <td class="p-4 font-medium text-slate-900 max-w-xs truncate" title="<?php echo e($module->title); ?>">
                                    <?php echo e($module->title); ?>

                                </td>
                                <td class="p-4 text-slate-600">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->course): ?>
                                        <span class="inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15Z" />
                                            </svg>
                                            <span class="truncate"><?php echo e($module->course->title); ?></span>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-slate-400 italic">Unassigned</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="p-4 text-slate-600 text-right tabular-nums"><?php echo e($module->order ?? 0); ?></td>
                                <td class="p-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($module->quizzes_count ?? 0) > 0): ?>
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold px-2.5 py-1 transition-colors duration-150">
                                            <?php echo e($module->quizzes_count); ?> <?php echo e(Str::plural('assessment', $module->quizzes_count)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-full bg-amber-50 text-amber-700 text-xs font-semibold px-2.5 py-1 transition-colors duration-150">
                                            No coverage
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="p-4 text-right">
                                    <a
                                        class="text-blue-600 font-medium hover:text-blue-800 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 rounded transition-colors duration-150"
                                        href="<?php echo e(route('staff.modules.edit', $module)); ?>"
                                    >
                                        Edit<span class="sr-only"> <?php echo e($module->title); ?></span>
                                    </a>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-200"><?php echo e($modules->links()); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\modules\index.blade.php ENDPATH**/ ?>