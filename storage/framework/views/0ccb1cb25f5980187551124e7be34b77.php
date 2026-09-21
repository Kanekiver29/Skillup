

<?php $__env->startSection('title', 'Teacher Subjects'); ?>
<?php $__env->startSection('page_title', 'My Subjects'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card">
    <h2 data-i18n="teacher_subjects">Teacher Subjects</h2>
    <p data-i18n="manage_subjects_teach">Manage the subjects you are assigned to teach and update student grades directly here.</p>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="section-block" style="margin-bottom:16px; background:#ecfdf3; border-color:#a7f3d0; color:#065f46;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="dashboard-grid">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="section-block">
                <strong><?php echo e($course->title); ?></strong>
                <p style="margin:6px 0 0;" data-i18n="students_enrolled">Students enrolled</p>: <?php echo e($course->enrollments_count); ?>

            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="section-block" data-i18n="no_subjects_assigned">No subjects are assigned to you yet.</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollments->isNotEmpty()): ?>
        <div class="section-block" style="margin-top:16px; overflow-x:auto;">
            <h3 style="margin-top:0;" data-i18n="grade_students">Grade students</h3>
            <table style="width:100%; border-collapse:collapse; min-width:720px;">
                <thead>
                    <tr style="background:#f8fafc; text-align:left;">
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="student">Student</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="course_title">Course</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="current_grade">Current Grade</th>
                        <th style="padding:10px 12px; border-bottom:1px solid #e2e8f0;" data-i18n="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;"><?php echo e($enrollment->user->name ?? __('sias.unnamed_student')); ?></td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;"><?php echo e($enrollment->course->title ?? __('sias.course_title')); ?></td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;"><?php echo e($enrollment->final_grade !== null ? $enrollment->final_grade : __('sias.no_grade_yet')); ?></td>
                            <td style="padding:10px 12px; border-bottom:1px solid #f1f5f9;">
                                <form method="POST" action="<?php echo e(route('sias.teacher.grades.update', $enrollment)); ?>" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <input type="number" name="final_grade" min="0" max="100" step="0.1" value="<?php echo e(old('final_grade', $enrollment->final_grade)); ?>" placeholder="<?php echo e(__('sias.enter_grade')); ?>" style="padding:8px 10px; border:1px solid #cbd5e1; border-radius:6px; min-width:120px;" />
                                    <button type="submit" class="btn" data-i18n="save_grade">Save Grade</button>
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

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\subjects\index.blade.php ENDPATH**/ ?>