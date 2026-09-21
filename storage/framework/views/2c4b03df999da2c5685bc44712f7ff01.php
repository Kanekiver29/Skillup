

<?php $__env->startSection('title', 'Grade Reports'); ?>
<?php $__env->startSection('page_title', 'Grade Reports'); ?>

<?php $__env->startSection('content'); ?>
<style>
    @media print {
        .no-print { display: none !important; }
        body { background: #fff; }
        .portal-page, .portal-content, main { background: #fff !important; }
    }
</style>
<div style="max-width:1100px;margin:0 auto;padding:2rem 1.25rem 3rem;">
    <div class="no-print" style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        <div>
            <h1 style="font-size:2rem;font-weight:800;margin:0;color:#0b1730;">Quiz Performance Reports</h1>
            <p style="margin-top:.45rem;color:#64768f;">Automatic summaries for every quiz with completed attempts.</p>
        </div>
        <div style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;">
            <a href="<?php echo e(route('teacher.grades.index')); ?>" style="padding:.75rem 1rem;border-radius:.7rem;background:#edf2ff;color:#182c63;font-weight:700;">Back to Gradebook</a>
            <button type="button" onclick="window.print()" style="padding:.75rem 1rem;border-radius:.7rem;background:#0b1730;color:#fff;font-weight:700;border:none;cursor:pointer;">Print Summary</button>
        </div>
    </div>
    <div style="background:#fff;border:1px solid #e4eaf7;border-radius:1rem;overflow:auto;box-shadow:0 8px 24px -16px rgba(9,20,51,.2);">
        <table style="width:100%;min-width:680px;border-collapse:collapse;"><thead><tr style="background:#f1f5fd;text-align:left;color:#0b1730;"><th style="padding:1rem;">Quiz</th><th style="padding:1rem;">Students</th><th style="padding:1rem;">Attempts</th><th style="padding:1rem;">Average score</th><th style="padding:1rem;">Pass rate</th></tr></thead><tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $quizReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><tr style="border-top:1px solid #eef2fb;"><td style="padding:1rem;font-weight:700;color:#0b1730;"><?php echo e($report->title); ?></td><td style="padding:1rem;color:#33415c;"><?php echo e($report->students); ?></td><td style="padding:1rem;color:#33415c;"><?php echo e($report->attempts); ?></td><td style="padding:1rem;font-weight:800;color:#315bd6;"><?php echo e($report->average_score); ?>%</td><td style="padding:1rem;font-weight:800;color:#15803d;"><?php echo e($report->pass_rate); ?>%</td></tr><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?><tr><td colspan="5" style="padding:3rem;text-align:center;color:#64768f;">No quiz data is available yet.</td></tr><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody></table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\grades\reports.blade.php ENDPATH**/ ?>