<?php echo $__env->make('sias.students.reports.sections._styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="rs">
    
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Enrolled Subjects</h2>
            <p>Full list of subjects enrolled this semester.</p>
        </div>
        <span class="rs-badge info"><?php echo e($enrollments->count()); ?> Subject(s)</span>
    </div>

    
    <div class="rs-meta-row rs-anim" style="animation-delay:.08s;">
        <div class="rs-meta-item">
            <div class="label">Student ID</div>
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
        <div class="rs-meta-item">
            <div class="label">Status</div>
            <div class="val blue">OFFICIALLY Enrolled</div>
        </div>
    </div>

    
    <div class="rs-table-wrap rs-anim" style="animation-delay:.12s;">
        <table class="rs-table">
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Room</th>
                    <th>Instructor</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $course = optional($enrollment)->course;
                        $units = $course->units ?? $course->credit ?? 3.0;
                        $schedule = $enrollment->schedule ?? $course->schedule ?? 'TBA';
                        $room = $course->room ?? '—';
                        $instructorRaw = $course->instructor ?? $course->teacher ?? null;
                        $instructor = is_object($instructorRaw) && property_exists($instructorRaw, 'name') ? $instructorRaw->name : ($instructorRaw ?? 'TBA');
                    ?>
                    <tr>
                        <td class="bold"><?php echo e($course->class_code ?? $course->code ?? 'TBD'); ?></td>
                        <td><?php echo e($course->code ?? '—'); ?></td>
                        <td class="bold"><?php echo e($course->title ?? 'Untitled Subject'); ?></td>
                        <td><?php echo e(number_format($units, 1)); ?></td>
                        <td><?php echo e($schedule); ?></td>
                        <td><?php echo e($room); ?></td>
                        <td><?php echo e($instructor); ?></td>
                        <td><?php echo e($enrollment->section ?? '—'); ?></td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="8">
                            <div class="rs-empty">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                <p>No enrolled subjects found.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\sections\enrolled-subjects.blade.php ENDPATH**/ ?>