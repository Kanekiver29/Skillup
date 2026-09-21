<?php echo $__env->make('sias.students.reports.sections._styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="rs">
    
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Class Offerings</h2>
            <p>Courses available in the current enrollment period.</p>
        </div>
        <span class="rs-badge info"><?php echo e(isset($enrollments) ? $enrollments->count() : 0); ?> Courses</span>
    </div>

    
    <div class="rs-meta-row rs-anim" style="animation-delay:.08s;">
        <div class="rs-meta-item">
            <div class="label">Student</div>
            <div class="val"><?php echo e($user->student_id ?? $user->id); ?></div>
        </div>
        <div class="rs-meta-item">
            <div class="label">Name</div>
            <div class="val"><?php echo e($user->name); ?></div>
        </div>
        <div class="rs-meta-item">
            <div class="label">Period</div>
            <div class="val"><?php echo e(session('current_period') ?? '2025-2'); ?></div>
        </div>
    </div>

    
    <div class="rs-table-wrap rs-anim" style="animation-delay:.12s;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($enrollments) && $enrollments->isNotEmpty()): ?>
            <table class="rs-table">
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Description</th>
                        <th>Units</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $course = optional($enrollment)->course;
                            $units = $course->units ?? $course->credit ?? 3.0;
                        ?>
                        <tr>
                            <td class="bold"><?php echo e($course->code ?? $course->slug ?? 'TBD'); ?></td>
                            <td><?php echo e($course->title ?? 'Untitled Course'); ?></td>
                            <td><?php echo e(number_format($units, 1)); ?></td>
                            <td><?php echo e($enrollment->section ?? '—'); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="rs-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <p>No class offerings available for this period.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\sections\class-offerings.blade.php ENDPATH**/ ?>