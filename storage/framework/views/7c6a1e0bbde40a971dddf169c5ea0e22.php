

<?php $__env->startSection('title', 'Enrollment Form'); ?>
<?php $__env->startSection('page_title', 'Enrollment Form'); ?>

<?php $__env->startSection('content'); ?>
<div class="print-shell">
    <div class="print-actions">
        <button type="button" class="btn-black" onclick="window.print()">Print</button>
        <a href="<?php echo e(route('sias.student.registration')); ?>" class="btn-white">Back</a>
    </div>

    <div class="doc-box">
        <div class="doc-header">
            <div class="doc-brand-wrap">
                <img src="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" alt="SkillUp Logo" class="doc-logo" />
                <div>
                    <div class="school-name">ARRI POLYTECHNIC INSTITUTE</div>
                    <div class="school-subtitle">Official Registration Record</div>
                </div>
            </div>
            <div class="doc-badge">Form 01</div>
        </div>

        <div class="student-meta">
            <div><span>Student Name</span><strong><?php echo e(auth()->user()->name); ?></strong></div>
            <div><span>Student ID</span><strong><?php echo e(auth()->user()->student_id ?? 'N/A'); ?></strong></div>
            <div><span>Program</span><strong><?php echo e($course?->title ?? 'Not selected'); ?></strong></div>
            <div><span>Semester</span><strong>1st Semester 2026-2027</strong></div>
        </div>

        <table class="doc-table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Subjects</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo e($course?->title ?? 'No course selected'); ?></td>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjects->count()): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div><?php echo e($subject->title); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php else: ?>
                            <span>No subjects selected</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td>Pending / Confirmed</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-row">
            <div>
                <div class="line"></div>
                <small>Registrar</small>
            </div>
            <div>
                <div class="line"></div>
                <small>CEO of TESDA</small>
            </div>
        </div>
    </div>
</div>

<style>
    body { background:#f8fafc; }
    .print-shell { max-width: 980px; margin: 0 auto; }
    .print-actions { display:flex; gap:.75rem; justify-content:flex-end; margin-bottom:1rem; }
    .doc-box {
        background:#fff; border:1px solid #e2e8f0; border-radius:20px; box-shadow:0 18px 40px rgba(15,23,42,.05); padding:2rem;
        width: 100%;
        min-height: 100%;
    }
    .doc-header { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:2px solid #e2e8f0; padding-bottom:1rem; margin-bottom:1.5rem; }
    .doc-brand-wrap { display:flex; align-items:center; gap:1rem; }
    .doc-logo { width: 90px; height: 90px; object-fit: contain; }
    .school-name { font-size:1.6rem; font-weight:800; color:#0f172a; }
    .school-subtitle { color:#64748b; font-size:.95rem; }
    .doc-badge { background:#0f172a; color:#fff; padding:.5rem .9rem; border-radius:999px; font-weight:700; }
    .student-meta { display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:1rem; margin-bottom:1.5rem; }
    .student-meta div { background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:.9rem 1rem; }
    .student-meta span { display:block; color:#64748b; font-size:.78rem; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.25rem; }
    .doc-table { width:100%; border-collapse:collapse; margin-top:1rem; }
    .doc-table th, .doc-table td { border:1px solid #e2e8f0; padding:.9rem 1rem; text-align:left; vertical-align:top; }
    .doc-table th { background:#f8fafc; color:#0f172a; }
    .signature-row { display:grid; grid-template-columns:repeat(2, 1fr); gap:1rem; margin-top:2rem; max-width: 680px; margin-left:auto; margin-right:auto; }
    .line { border-bottom:1px solid #0f172a; min-height:40px; }
    .signature-row small { display:block; margin-top:.6rem; color:#64748b; text-align:center; }
    @media print {
        @page { size: A4 portrait; margin: 12mm; }
        .print-actions { display:none; }
        body { background:#fff; }
        .page-card { box-shadow:none; border:none; }
        .doc-box { border:none; border-radius:0; box-shadow:none; padding:0; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\registration\enrollment_form.blade.php ENDPATH**/ ?>