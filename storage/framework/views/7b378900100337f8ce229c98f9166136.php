

<?php $__env->startSection('title', 'Schedule Management'); ?>
<?php $__env->startSection('page_title', 'Schedule Management'); ?>
<?php $__env->startSection('subtitle', 'Manage training sessions, rooms, teachers, and course assignments'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex;justify-content:flex-end;margin-bottom:1rem;">
    <a href="<?php echo e(route('admin.schedules.create')); ?>" class="btn" style="padding:12px 20px;">+ Add Schedule</a>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div style="margin-bottom:1rem;padding:12px 16px;border:1px solid #a7f3d0;border-radius:10px;background:#ecfdf5;color:#166534;"><?php echo e(session('success')); ?></div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div class="admin-card" style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;min-width:900px;">
        <thead>
            <tr style="border-bottom:1px solid var(--card-border);text-align:left;">
                <th style="padding:12px 10px;">Day / Time</th>
                <th style="padding:12px 10px;">Course</th>
                <th style="padding:12px 10px;">Subject</th>
                <th style="padding:12px 10px;">Teacher</th>
                <th style="padding:12px 10px;">Venue</th>
                <th style="padding:12px 10px;">Status</th>
                <th style="padding:12px 10px;text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr style="border-bottom:1px solid var(--card-border);">
                    <td style="padding:14px 10px;white-space:nowrap;">
                        <strong><?php echo e($schedule->day_of_week); ?></strong><br>
                        <span style="color:var(--text-muted);font-size:.85rem;"><?php echo e(substr($schedule->start_time, 0, 5)); ?> - <?php echo e(substr($schedule->end_time, 0, 5)); ?></span>
                    </td>
                    <td style="padding:14px 10px;"><?php echo e($schedule->course?->title ?? 'No course'); ?></td>
                    <td style="padding:14px 10px;"><?php echo e($schedule->subject_name); ?></td>
                    <td style="padding:14px 10px;"><?php echo e($schedule->teacher?->name ?? 'Unassigned'); ?></td>
                    <td style="padding:14px 10px;"><?php echo e($schedule->building ?: '—'); ?><?php echo e($schedule->room_number ? ' · Room ' . $schedule->room_number : ''); ?></td>
                    <td style="padding:14px 10px;">
                        <span style="display:inline-block;padding:4px 9px;border-radius:999px;background:<?php echo e($schedule->is_active ? '#dcfce7' : '#f1f5f9'); ?>;color:<?php echo e($schedule->is_active ? '#166534' : '#64748b'); ?>;font-size:.78rem;font-weight:700;"><?php echo e($schedule->is_active ? 'Active' : 'Inactive'); ?></span>
                    </td>
                    <td style="padding:14px 10px;text-align:right;white-space:nowrap;">
                        <a href="<?php echo e(route('admin.schedules.edit', $schedule)); ?>" class="btn-secondary" style="padding:7px 11px;">Edit</a>
                        <form method="POST" action="<?php echo e(route('admin.schedules.destroy', $schedule)); ?>" style="display:inline;" onsubmit="return confirm('Delete this schedule?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-secondary" style="padding:7px 11px;color:#b42318;">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr><td colspan="7" style="padding:2.5rem;text-align:center;color:var(--text-muted);">No schedules have been created yet.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($schedules->hasPages()): ?>
        <div style="margin-top:1rem;"><?php echo e($schedules->links()); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\schedules\index.blade.php ENDPATH**/ ?>