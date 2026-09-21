<?php echo $__env->make('sias.students.reports.sections._styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $passCount = 0; $totalUnits = 0; $weightedSum = 0;
    foreach($enrollments as $e) {
        $fg = optional($e)->final_grade ?? optional(optional($e)->course)->final_grade ?? null;
        $u = optional(optional($e)->course)->units ?? 3;
        if (is_numeric($fg) && $fg >= 75) $passCount++;
        if (is_numeric($fg)) { $weightedSum += $fg * $u; $totalUnits += $u; }
    }
    $computedGwa = $totalUnits > 0 ? round($weightedSum / $totalUnits, 4) : null;
    $gwa = isset($gwaMatch) ? $gwaMatch : $computedGwa;
?>

<div class="rs">
    
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>General Weighted Average <span style="font-size:.8em;font-weight:600;color:var(--muted);">(Match)</span></h2>
            <p>Match Curriculum mode — weighted average using matched course grading rules.</p>
        </div>
        <span class="rs-badge <?php echo e($gwa !== null && $gwa >= 75 ? 'pass' : 'fail'); ?>">GWA: <?php echo e($gwa !== null ? number_format($gwa, 2) : '—'); ?></span>
    </div>

    <div class="rs-grid">
        
        <div class="rs-table-wrap rs-anim" style="animation-delay:.1s;">
            <table class="rs-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Instructor</th>
                        <th>Final Grade</th>
                        <th>Units</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $course = optional($enrollment)->course;
                            $finalGrade = optional($enrollment)->final_grade ?? optional($course)->final_grade ?? 'INC';
                            $units = $course->units ?? $course->credit ?? 3.0;
                            $remark = is_numeric($finalGrade) && $finalGrade >= 75 ? 'Passed' : 'Incomplete';
                            $instructorRaw = $course->instructor ?? $course->teacher ?? null;
                            $instructor = is_object($instructorRaw) && property_exists($instructorRaw, 'name') ? $instructorRaw->name : ($instructorRaw ?? 'TBA');
                        ?>
                        <tr>
                            <td class="bold"><?php echo e($course->code ?? 'TBD'); ?></td>
                            <td><?php echo e($course->title ?? 'Untitled Subject'); ?></td>
                            <td><?php echo e($instructor); ?></td>
                            <td class="bold"><?php echo e($finalGrade); ?></td>
                            <td><?php echo e(number_format($units, 1)); ?></td>
                            <td><span class="rs-badge <?php echo e($remark === 'Passed' ? 'pass' : 'fail'); ?>"><?php echo e($remark); ?></span></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="6"><div class="rs-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg><p>No grade records available yet.</p></div></td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="rs-sidebar rs-anim" style="animation-delay:.14s;">
            <div class="rs-sidebar-card">
                <div class="label">GWA Summary</div>
                <?php $gwaClass = ($gwa !== null && $gwa >= 75) ? 'pass' : ($gwa !== null ? 'fail' : ''); ?>
                <div class="big-val <?php echo e($gwaClass); ?>"><?php echo e($gwa !== null ? number_format($gwa, 4) : '—'); ?></div>
                <p style="font-size:.8rem;color:var(--muted);margin:.5rem 0 0;">Using matched curriculum rules</p>
            </div>
            <div class="rs-sidebar-card">
                <div class="label">Details</div>
                <dl>
                    <div class="row"><dt>Total courses</dt><dd><?php echo e($enrollments->count()); ?></dd></div>
                    <div class="row"><dt>Passed</dt><dd><?php echo e($passCount); ?></dd></div>
                    <div class="row"><dt>Incomplete</dt><dd><?php echo e($enrollments->count() - $passCount); ?></dd></div>
                    <div class="row"><dt>Total units</dt><dd><?php echo e(number_format($totalUnits, 1)); ?></dd></div>
                </dl>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\sections\gwa-match.blade.php ENDPATH**/ ?>