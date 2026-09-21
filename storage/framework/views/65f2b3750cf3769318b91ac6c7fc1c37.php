

<?php $__env->startSection('title', 'Grade Certificate'); ?>
<?php $__env->startSection('page_title', 'Grade Certificate'); ?>

<?php $__env->startSection('content'); ?>
<div class="print-shell">
    <div class="print-actions">
        <button type="button" class="btn-black" onclick="window.print()">Print</button>
        <a href="<?php echo e(route('sias.student.registration')); ?>" class="btn-white">Back</a>
    </div>

    <div class="doc-box certificate-box">
        <div class="certificate-head">
            <div class="school-mark">SIAS</div>
            <div>
                <h2>Grade Certificate</h2>
                <p>Official academic grade summary</p>
            </div>
        </div>

        <div class="student-name"><?php echo e(auth()->user()->name); ?></div>
        <p class="cert-copy">for the program</p>
        <div class="program-name"><?php echo e($course?->title ?? 'Not selected'); ?></div>

        <table class="mini-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($gradeRows)): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $gradeRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($row['subject']); ?></td>
                            <td><?php echo e($row['grade']); ?></td>
                            <td><?php echo e($row['remarks']); ?></td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php else: ?>
                    <tr><td colspan="3">No grade records available.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>

        <div class="average-box">Average Grade: <strong><?php echo e($averageGrade ?? 0); ?></strong></div>

        <div class="signature-row">
            <div>
                <div class="line"></div>
                <small>Registrar</small>
            </div>
            <div>
                <div class="line"></div>
                <small>Dean</small>
            </div>
        </div>
    </div>
</div>

<style>
    body { background:#f8fafc; }
    .print-shell { max-width: 900px; margin: 0 auto; }
    .print-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-bottom:1rem; }
    .doc-box { background:#fff; border:1px solid #e2e8f0; border-radius:22px; box-shadow:0 18px 40px rgba(15,23,42,.05); padding:2.25rem; }
    .certificate-box { text-align:center; }
    .certificate-head { display:flex; justify-content:center; align-items:center; gap:1rem; margin-bottom:1rem; }
    .school-mark { width:72px; height:72px; border-radius:50%; background:#0f172a; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; }
    .certificate-head h2 { margin:0; font-size:2rem; color:#0f172a; }
    .certificate-head p { margin:.2rem 0 0; color:#64748b; }
    .student-name { font-size:2rem; font-weight:800; color:#0f172a; margin-top:1rem; }
    .cert-copy { color:#334155; font-size:1.05rem; margin:.5rem 0; }
    .program-name { font-size:1.4rem; font-weight:700; color:#0f172a; margin:1rem 0; }
    .mini-table { width:100%; border-collapse:collapse; margin:1rem auto 1.5rem; max-width:540px; }
    .mini-table th, .mini-table td { border:1px solid #e2e8f0; padding:.8rem .9rem; text-align:left; }
    .mini-table th { background:#f8fafc; }
    .average-box { font-size:1.1rem; margin-bottom:1rem; color:#0f172a; }
    .average-box strong { font-size:1.3rem; }
    .signature-row { display:grid; grid-template-columns:repeat(2, 1fr); gap:1.5rem; margin-top:2rem; max-width:420px; margin-left:auto; margin-right:auto; }
    .line { border-bottom:1px solid #0f172a; min-height:34px; }
    .signature-row small { display:block; margin-top:.6rem; color:#64748b; }
    @media print {
        .print-actions { display:none; }
        body { background:#fff; }
        .page-card { box-shadow:none; border:none; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\registration\certificate_grade.blade.php ENDPATH**/ ?>