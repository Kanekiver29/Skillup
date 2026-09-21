

<?php $__env->startSection('title', 'Teacher Grades'); ?>
<?php $__env->startSection('page_title', 'Gradebook'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <div>
            <h2 style="margin:0;">Manage student grades</h2>
            <p style="margin:6px 0 0;">Add or update a final grade for each student enrolled in your course.</p>
        </div>
        <div class="section-block" style="margin:0;"><strong>Courses:</strong> <?php echo e($courses->count()); ?></div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="section-block" style="margin-top:16px; background:#ecfdf3; border-color:#a7f3d0; color:#065f46;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollments->isEmpty()): ?>
        <div class="section-block" style="margin-top:16px;">No students have been enrolled in your courses yet.</div>
    <?php else: ?>
        <div class="section-block" style="margin-top:16px; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; min-width:720px;">
                <thead>
                    <tr style="background:#f8fafc; text-align:left;">
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Student</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Course</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Status</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Current Grade</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;"><?php echo e($enrollment->user->name ?? 'Unnamed student'); ?></td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;"><?php echo e($enrollment->course->title ?? 'Course'); ?></td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;"><?php echo e($enrollment->status ?? 'Active'); ?></td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;"><?php echo e($enrollment->final_grade !== null ? $enrollment->final_grade : 'No grade yet'); ?></td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">
                                <form method="POST" action="<?php echo e(route('sias.teacher.grades.update', $enrollment)); ?>" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <input type="number" name="final_grade" min="0" max="100" step="0.1" value="<?php echo e(old('final_grade', $enrollment->final_grade)); ?>" placeholder="Enter grade" style="padding:8px 10px; border:1px solid #cbd5e1; border-radius:6px; min-width:120px;" />
                                    <button type="submit" class="btn" style="padding:8px 12px;">Save Grade</button>
                                </form>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\grades\grade.blade.php ENDPATH**/ ?>