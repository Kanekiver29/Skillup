

<?php $__env->startSection('title', 'Final Grades (Ignore)'); ?>
<?php $__env->startSection('page_title', 'Final Grades (Ignore)'); ?>

<?php $__env->startSection('content'); ?>
<section id="final-grades-ignore" class="section-block">
    <h3>Final Grades (Ignore Curriculum)</h3>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($courseGrades)): ?>
        <p>No final grades available.</p>
    <?php else: ?>
        <div><strong>Final GWA:</strong> <?php echo e($gwaMatch !== null ? $gwaMatch . '%' : 'N/A'); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\final-grades-ignore.blade.php ENDPATH**/ ?>