
<?php $__env->startSection('title', 'Trainees'); ?>
<?php $__env->startSection('page_title', 'Trainees'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-card">
    <h2>Trainee List</h2>
    <p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($batch): ?>
            Showing trainees for batch: <strong><?php echo e($batch); ?></strong>.
        <?php else: ?>
            Enrollment information, training progress, and trainee status.
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </p>

    <div class="portal-grid" style="margin-bottom: 1rem;">
        <div class="portal-card">
            <strong><?php echo e($enrollments->count()); ?></strong>
            <span>Trainees</span>
        </div>
        <div class="portal-card">
            <strong><?php echo e($enrollments->filter(fn ($row) => ($row->status ?? 'active') === 'completed')->count()); ?></strong>
            <span>Completed</span>
        </div>
        <div class="portal-card">
            <strong><?php echo e($enrollments->filter(fn ($row) => ($row->status ?? 'active') !== 'completed')->count()); ?></strong>
            <span>Active</span>
        </div>
        <div class="portal-card">
            <strong><?php echo e(round($enrollments->avg('progress') ?? 0, 1)); ?>%</strong>
            <span>Average Progress</span>
        </div>
    </div>

    <div style="overflow:auto">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Trainee</th>
                    <th>Program</th>
                    <th>Batch</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td>
                            <strong><?php echo e($enrollment->user?->name ?? '—'); ?></strong><br>
                            <small><?php echo e($enrollment->user?->lrn ?? $enrollment->user?->email ?? 'No identifier available'); ?></small>
                        </td>
                        <td><?php echo e($enrollment->course?->title ?? '—'); ?></td>
                        <td><?php echo e($enrollment->batch_class ?? 'Unassigned'); ?></td>
                        <td><?php echo e($enrollment->training_schedule ?? 'Not assigned'); ?></td>
                        <td>
                            <span><?php echo e(ucfirst($enrollment->status ?? 'active')); ?></span>
                        </td>
                        <td><?php echo e($enrollment->progress ?? 0); ?>%</td>
                        <td><?php echo e($enrollment->final_grade ?? 'Pending'); ?></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="7">No trainees enrolled in your programs.</td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\trainees\index.blade.php ENDPATH**/ ?>