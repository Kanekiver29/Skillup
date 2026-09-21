<?php
    $modules = [
        'audit-logs' => ['title' => 'Audit Logs', 'purpose' => 'Review important actions performed by users for security, accountability, and troubleshooting.', 'items' => ['Recent activity', 'User filters', 'Export audit report']],
        'grades' => ['title' => 'Grades', 'purpose' => 'Manage grade records and review academic performance across students, subjects, and terms.', 'items' => ['Grade records', 'Term filters', 'Assessment summary']],
        'attendance' => ['title' => 'Attendance', 'purpose' => 'Monitor attendance records by class, subject, student, and academic period.', 'items' => ['Attendance overview', 'Class filters', 'Absence report']],
        'announcements' => ['title' => 'Announcements', 'purpose' => 'Publish important school announcements for teachers, students, and staff.', 'items' => ['Published announcements', 'Drafts', 'Create announcement']],
        'schedules' => ['title' => 'Schedules', 'purpose' => 'Coordinate classes, subjects, teachers, rooms, and teaching loads in one place.', 'items' => ['Class schedule', 'Teaching load', 'Subject schedule']],
    ];
    $current = $modules[$module] ?? [
        'title' => str($module)->replace('-', ' ')->title(),
        'purpose' => 'Manage this SIAS administration area and review its related records.',
        'items' => ['Overview', 'Records', 'Reports'],
    ];
?>



<?php $__env->startSection('title', $current['title'] . ' | SIAS Admin'); ?>
<?php $__env->startSection('page_title', $current['title']); ?>
<?php $__env->startSection('subtitle', $current['purpose']); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $current['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <section class="admin-panel" style="--i: <?php echo e($index); ?>;">
            <p style="margin:0 0 .5rem; color:var(--text-muted); font-size:.78rem; text-transform:uppercase; letter-spacing:.08em;">SIAS Admin</p>
            <h3 style="margin:0 0 .65rem;"><?php echo e($item); ?></h3>
            <p style="margin:0; color:var(--text-muted);">This workspace is ready for <?php echo e(strtolower($item)); ?> management.</p>
        </section>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>

<section class="admin-card" style="margin-top:1rem;">
    <h3 style="margin-top:0;"><?php echo e($current['title']); ?> workspace</h3>
    <p style="margin-bottom:0; color:var(--text-muted);"><?php echo e($current['purpose']); ?></p>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\modules\index.blade.php ENDPATH**/ ?>