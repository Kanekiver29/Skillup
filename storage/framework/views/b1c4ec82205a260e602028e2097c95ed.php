<?php echo $__env->make('sias.students.reports.sections._styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
    $termLabel = $sectionMeta['term_label'] ?? 'Second Semester S.Y 2025-2026';
    $courses = $enrollments->map(function($enrollment) {
        $course = optional($enrollment)->course;
        $finalGrade = optional($enrollment)->final_grade ?? optional($course)->final_grade ?? 'INC';
        $average = optional($enrollment)->average_grade ?? optional($course)->average_grade ?? $finalGrade;
        $units = $course->units ?? $course->credit ?? 3.0;
        $instructorRaw = $course->instructor ?? $course->teacher ?? null;
        return [
            'code'       => $course->code ?? 'TBD',
            'title'      => $course->title ?? 'Untitled Subject',
            'instructor' => is_object($instructorRaw) && property_exists($instructorRaw, 'name') ? $instructorRaw->name : ($instructorRaw ?? 'TBA'),
            'average'    => $average,
            'finalGrade' => $finalGrade,
            'equivGrade' => is_numeric($finalGrade) ? $finalGrade : 'INC',
            'units'      => $units,
            'remark'     => is_numeric($finalGrade) && $finalGrade >= 75 ? 'Passed' : 'Incomplete',
            'currEval'   => is_numeric($finalGrade) && $finalGrade >= 75 ? 'Passed' : 'Incomplete',
        ];
    });
    $passCount = $courses->where('remark', 'Passed')->count();
    $numericGrades = $courses->filter(fn($r) => is_numeric($r['finalGrade']))->pluck('finalGrade');
    $totalUnits = $courses->sum('units');
    $displayGrade = isset($gwaIgnore) && $gwaIgnore !== null ? number_format($gwaIgnore, 4) : ($numericGrades->count() ? number_format($numericGrades->avg(), 4) : '—');
    $gwaClass = (isset($gwaIgnore) && $gwaIgnore !== null && $gwaIgnore >= 75) ? 'pass' : ((isset($gwaIgnore) && $gwaIgnore !== null) ? 'fail' : '');
?>

<div class="rs">
    
    <div class="rs-inner-header rs-anim" style="animation-delay:.05s;">
        <div>
            <h2>Term Grades <span style="font-size:.8em;font-weight:600;color:var(--muted);">(Ignore)</span></h2>
            <p><?php echo e($termLabel); ?> — shown without curriculum matching.</p>
        </div>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <span class="rs-badge pass"><?php echo e($passCount); ?> Passed</span>
            <span class="rs-badge fail"><?php echo e($courses->count() - $passCount); ?> Incomplete</span>
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
                        <th>Ave Grade</th>
                        <th>Final Grade</th>
                        <th>Units</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="bold"><?php echo e($row['code']); ?></td>
                            <td><?php echo e($row['title']); ?></td>
                            <td><?php echo e($row['instructor']); ?></td>
                            <td><?php echo e(is_numeric($row['average']) ? number_format($row['average'], 2) : $row['average']); ?></td>
                            <td class="bold"><?php echo e($row['finalGrade']); ?></td>
                            <td><?php echo e(number_format($row['units'], 1)); ?></td>
                            <td><span class="rs-badge <?php echo e($row['remark'] === 'Passed' ? 'pass' : 'fail'); ?>"><?php echo e($row['remark']); ?></span></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr><td colspan="7"><div class="rs-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><p>No term grade records available.</p></div></td></tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="rs-sidebar rs-anim" style="animation-delay:.14s;">
            <div class="rs-sidebar-card">
                <div class="label">GWA (Ignore)</div>
                <div class="big-val <?php echo e($gwaClass); ?>"><?php echo e($displayGrade); ?></div>
                <p style="font-size:.8rem;color:var(--muted);margin:.5rem 0 0;">Raw mode — no curriculum filter</p>
            </div>
            <div class="rs-sidebar-card">
                <div class="label">Term Summary</div>
                <dl>
                    <div class="row"><dt>Courses</dt><dd><?php echo e($courses->count()); ?></dd></div>
                    <div class="row"><dt>Passed</dt><dd><?php echo e($passCount); ?></dd></div>
                    <div class="row"><dt>Incomplete</dt><dd><?php echo e($courses->count() - $passCount); ?></dd></div>
                    <div class="row"><dt>Total units</dt><dd><?php echo e(number_format($totalUnits, 1)); ?></dd></div>
                </dl>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\sections\term-grades-ignore.blade.php ENDPATH**/ ?>