

<?php $__env->startSection('title', 'Module Editor'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .me-shell {
        max-width: 1280px;
        margin: 0 auto;
        padding: 32px 20px 48px;
    }

    .me-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .me-panel {
        border: 1px solid rgba(148, 163, 184, 0.45);
        border-radius: 1rem;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    }

    .me-grid {
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        gap: 24px;
    }

    .me-sidebar {
        padding: 18px;
    }

    .me-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 16px;
    }

    .me-item {
        display: block;
        width: 100%;
        text-align: left;
        border-radius: 0.85rem;
        border: 1px solid transparent;
        background: rgba(248, 250, 252, 0.9);
        padding: 12px 14px;
        transition: all 0.2s ease;
    }

    .me-item:hover {
        border-color: rgba(59, 130, 246, 0.35);
        background: rgba(239, 246, 255, 0.9);
    }

    .me-item.active {
        border-color: rgba(37, 99, 235, 0.55);
        background: rgba(219, 234, 254, 0.9);
    }

    .me-content {
        padding: 24px;
    }

    .me-hero {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 16px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.45);
        margin-bottom: 20px;
    }

    .me-metadata {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 16px;
        margin-top: 22px;
        margin-bottom: 20px;
    }

    .me-meta-card {
        border: 1px solid rgba(148, 163, 184, 0.45);
        border-radius: 0.85rem;
        background: rgba(248, 250, 252, 0.75);
        padding: 14px;
    }

    .me-section {
        margin-top: 22px;
    }

    .me-section h3 {
        margin-bottom: 10px;
    }

    .me-body {
        border: 1px solid rgba(148, 163, 184, 0.45);
        border-radius: 0.85rem;
        background: rgba(248, 250, 252, 0.55);
        padding: 16px;
        line-height: 1.7;
    }

    @media (max-width: 768px) {
        .me-shell {
            padding-left: 16px;
            padding-right: 16px;
        }

        .me-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php
    $selectedCourse = $module->course?->title ?? 'Unassigned';
    $moduleSummary = $module->description ?: 'No description provided yet.';
    $definition = $module->definition ?: 'No definition has been added for this module.';
    $example = $module->example ?: 'No example has been added yet.';
?>

<div class="me-shell">
    <div class="me-header">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-cyan-200 bg-cyan-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-cyan-700">
                <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
                Module editor
            </div>
            <h1 class="text-3xl font-bold text-slate-900"><?php echo e($module->title); ?></h1>
            <p class="mt-1 text-sm text-slate-500">Review and update this module from the staff workspace.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('staff.modules.edit', $module)); ?>" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                Open edit form
            </a>
            <a href="<?php echo e(route('staff.modules.index')); ?>" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
                Back to modules
            </a>
        </div>
    </div>

    <div class="me-grid">
        <aside class="me-panel me-sidebar">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-[0.12em] text-slate-500">Modules</h2>
                <span class="rounded-full bg-slate-100 px-2 py-1 text-[10px] font-semibold text-slate-600"><?php echo e($modules->count()); ?></span>
            </div>

            <div class="me-list">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a
                        href="<?php echo e(route('staff.modules.editor', $item)); ?>"
                        class="me-item <?php echo e($item->id === $module->id ? 'active' : ''); ?>"
                    >
                        <div class="text-sm font-semibold text-slate-800"><?php echo e($item->title); ?></div>
                        <div class="mt-1 text-xs text-slate-500"><?php echo e($item->course?->title ?? 'Unassigned course'); ?></div>
                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </aside>

        <main class="me-panel me-content">
            <div class="me-hero">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">Module</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($module->title); ?></h2>
                </div>

                <div class="flex items-center gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->published): ?>
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Published</span>
                    <?php else: ?>
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Draft</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="me-metadata">
                <div class="me-meta-card">
                    <div class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Course</div>
                    <div class="mt-2 text-sm font-semibold text-slate-800"><?php echo e($selectedCourse); ?></div>
                </div>

                <div class="me-meta-card">
                    <div class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Order</div>
                    <div class="mt-2 text-sm font-semibold text-slate-800"><?php echo e($module->order ?? 0); ?></div>
                </div>

                <div class="me-meta-card">
                    <div class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Quizzes</div>
                    <div class="mt-2 text-sm font-semibold text-slate-800"><?php echo e($module->quizzes_count ?? 0); ?></div>
                </div>
            </div>

            <div class="me-section">
                <h3 class="text-sm font-semibold uppercase tracking-[0.12em] text-slate-500">Description</h3>
                <div class="me-body text-sm text-slate-700"><?php echo e($moduleSummary); ?></div>
            </div>

            <div class="me-section">
                <h3 class="text-sm font-semibold uppercase tracking-[0.12em] text-slate-500">Definition</h3>
                <div class="me-body text-sm text-slate-700"><?php echo e($definition); ?></div>
            </div>

            <div class="me-section">
                <h3 class="text-sm font-semibold uppercase tracking-[0.12em] text-slate-500">Example</h3>
                <div class="me-body text-sm text-slate-700"><?php echo e($example); ?></div>
            </div>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\modules\editor.blade.php ENDPATH**/ ?>