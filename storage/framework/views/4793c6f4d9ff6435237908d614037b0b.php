<?php echo $__env->make('sias.students.reports.sections._styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $passCount = 0; $totalUnits = 0;
    foreach($enrollments as $e) {
        $fg = optional($e)->final_grade ?? optional(optional($e)->course)->final_grade ?? null;
        if (is_numeric($fg) && $fg >= 75) $passCount++;
        $totalUnits += optional(optional($e)->course)->units ?? 3;
    }
?>

<div class="rs">
    
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Final Grades <span style="font-size:.8em;font-weight:600;color:var(--muted);">(Match Curriculum)</span></h2>
            <p>Final grades computed using the matched curriculum grading rules.</p>
        </div>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <span class="rs-badge pass"><?php echo e($passCount); ?> Passed</span>
            <span class="rs-badge fail"><?php echo e($enrollments->count() - $passCount); ?> Incomplete</span>
        </div>
    </div>

    <div class="rs-grid">
        
        <div class="rs-table-wrap rs-anim" style="animation-delay:.1s;">
            <table class="rs-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Subject</th>
                        <th>Instructor</th>
                        <th>Final Grade</th>
                        <th>Equiv Grade</th>
                        <th>Units</th>
                        <th>Remark</th>
                        <th>Curr Eval</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $course = optional($enrollment)->course;
                            $finalGrade = optional($enrollment)->final_grade ?? optional($course)->final_grade ?? 'INC';
                            $equivGrade = is_numeric($finalGrade) ? $finalGrade : 'INC';
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
                            <td><?php echo e($equivGrade); ?></td>
                            <td><?php echo e(number_format($units, 1)); ?></td>
                            <td><span class="rs-badge <?php echo e($remark === 'Passed' ? 'pass' : 'fail'); ?>"><?php echo e($remark); ?></span></td>
                            <td><span class="rs-badge <?php echo e($remark === 'Passed' ? 'pass' : 'inc'); ?>"><?php echo e($remark); ?></span></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="8"><div class="rs-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><p>No grade records available yet.</p></div></td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="rs-sidebar rs-anim" style="animation-delay:.14s;">
            <div class="rs-sidebar-card">
                <div class="label">GWA (Match)</div>
                <?php
                    $gwa = isset($gwaMatch) ? $gwaMatch : (isset($gwa) ? $gwa : null);
                    $gwaClass = $gwa >= 75 ? 'pass' : ($gwa !== null ? 'fail' : '');
                ?>
                <div class="big-val <?php echo e($gwaClass); ?>"><?php echo e($gwa !== null ? number_format($gwa, 4) : '—'); ?></div>
                <p style="font-size:.8rem;color:var(--muted);margin:.5rem 0 0;">Weighted average (match)</p>
            </div>
            <div class="rs-sidebar-card">
                <div class="label">Summary</div>
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
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\sections\final-grades-match.blade.php ENDPATH**/ ?>