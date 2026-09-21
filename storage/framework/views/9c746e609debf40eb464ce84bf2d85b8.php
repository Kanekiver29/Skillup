
<?php $__env->startSection('title', 'My Classes / Batches'); ?>
<?php $__env->startSection('page_title', 'My Classes / Batches'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-card">
    <h2>My Classes / Batches</h2>
    <p>View trainees per batch, training status, and batch schedule.</p>

    <div class="portal-grid">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                $course = $rows->first()->course;
                $totalTrainees = $rows->count();
                $activeCount = $rows->filter(fn ($row) => ($row->status ?? 'active') !== 'completed')->count();
                $completedCount = $rows->filter(fn ($row) => ($row->status ?? 'active') === 'completed')->count();
                $avgProgress = round($rows->avg('progress') ?? 0, 1);
                $schedule = $rows->first()->training_schedule ?? 'Schedule not assigned';
            ?>

            <article class="portal-card">
                <h3><?php echo e($name); ?></h3>
                <p><strong>Program:</strong> <?php echo e($course?->title ?? 'Program not assigned'); ?></p>
                <p><strong>Trainees:</strong> <?php echo e($totalTrainees); ?></p>
                <p><strong>Active:</strong> <?php echo e($activeCount); ?> &nbsp;•&nbsp; <strong>Completed:</strong> <?php echo e($completedCount); ?></p>
                <p><strong>Average progress:</strong> <?php echo e($avgProgress); ?>%</p>
                <p><strong>Schedule:</strong> <?php echo e($schedule); ?></p>
                <div style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <a class="btn" href="<?php echo e(route('sias.teacher.trainees', ['batch' => $name])); ?>">View trainees</a>
                </div>
            </article>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="portal-card">
                <p>No batches have been assigned.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\classes\index.blade.php ENDPATH**/ ?>