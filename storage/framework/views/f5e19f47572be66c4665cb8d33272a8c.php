<?php $__env->startSection('title', 'Enrollment Management'); ?>
<?php $__env->startSection('page_title', 'Enrollment Management'); ?>
<?php $__env->startSection('subtitle', 'Review, approve, and monitor student enrollment records.'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
    <div class="admin-actions" style="margin-top:0; margin-bottom:1.25rem;">
        <a href="<?php echo e(route('sias.admin.enrollment.add')); ?>" class="btn-black"><i class="fa-solid fa-plus"></i> Add Student Enrollment</a>
        <a href="<?php echo e(route('sias.admin.enrollments')); ?>" class="btn-white"><i class="fa-solid fa-arrows-rotate"></i> Refresh</a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div style="padding:.75rem 1rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#16a34a;border-radius:8px;margin-bottom:1rem;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="admin-grid">
        <div class="admin-panel">
            <h3>Total Enrollments</h3>
            <p style="font-size:2rem; font-weight:800; margin:0; color:var(--accent);"><?php echo e($totalCount ?? 0); ?></p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);">Active course records.</p>
        </div>
        <div class="admin-panel">
            <h3>Pending</h3>
            <p style="font-size:2rem; font-weight:800; margin:0; color:#f59e0b;"><?php echo e($pendingCount ?? 0); ?></p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);">Awaiting validation.</p>
        </div>
        <div class="admin-panel">
            <h3>Approved</h3>
            <p style="font-size:2rem; font-weight:800; margin:0; color:#22c55e;"><?php echo e($approvedCount ?? 0); ?></p>
            <p style="margin:.4rem 0 0; color:var(--text-muted);">Validated student records.</p>
        </div>
    </div>

    <div class="admin-panel" style="margin-top:1.5rem;">
        <h3>Enrollment Records</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; margin-top:1rem;">
                <thead>
                    <tr style="border-bottom:1px solid var(--card-border);">
                        <th style="padding:.85rem .75rem; text-align:left;">Student</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Course</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Subject</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Year / Semester</th>
                        <th style="padding:.85rem .75rem; text-align:left;">Status</th>
                        <th style="padding:.85rem .75rem; text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr style="border-bottom:1px solid var(--card-border);">
                            <td style="padding:.85rem .75rem;">
                                <div style="font-weight:600;"><?php echo e($enrollment->user->name ?? 'Unknown Student'); ?></div>
                                <div style="font-size:.85rem;color:var(--text-muted);"><?php echo e($enrollment->user->email ?? ''); ?></div>
                            </td>
                            <td style="padding:.85rem .75rem;"><?php echo e($enrollment->course->title ?? $enrollment->course->code ?? 'N/A'); ?></td>
                            <td style="padding:.85rem .75rem;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollment->subject): ?>
                                    <span style="font-weight:600;"><?php echo e($enrollment->subject->subject_code ?? $enrollment->subject->code ?? ''); ?></span> - <?php echo e($enrollment->subject->title); ?>

                                <?php else: ?>
                                    <span style="color:var(--text-muted);">(All Subjects)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td style="padding:.85rem .75rem;"><?php echo e($enrollment->year_level ?? 'N/A'); ?> <?php echo e($enrollment->semester ? '· ' . $enrollment->semester : ''); ?></td>
                            <td style="padding:.85rem .75rem;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(strtolower($enrollment->status) === 'approved' || $enrollment->completed): ?>
                                    <span style="color:#16a34a;font-weight:700;padding:.2rem .6rem;background:rgba(22,163,74,.1);border-radius:6px;font-size:.85rem;">Approved</span>
                                <?php elseif(strtolower($enrollment->status) === 'pending'): ?>
                                    <span style="color:#d97706;font-weight:700;padding:.2rem .6rem;background:rgba(217,119,6,.1);border-radius:6px;font-size:.85rem;">Pending</span>
                                <?php else: ?>
                                    <span style="color:#dc2626;font-weight:700;padding:.2rem .6rem;background:rgba(220,38,38,.1);border-radius:6px;font-size:.85rem;"><?php echo e(ucfirst($enrollment->status ?? 'Active')); ?></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td style="padding:.85rem .75rem;text-align:right;">
                                <a href="<?php echo e(route('sias.admin.enrollment.edit', $enrollment->id)); ?>" class="btn-white" style="padding:.4rem .7rem; font-size:.85rem;margin-right:.3rem;">Edit</a>
                                <form method="POST" action="<?php echo e(route('sias.admin.enrollment.delete', $enrollment->id)); ?>" style="display:inline;" onsubmit="return confirm('Delete this enrollment record?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" style="padding:.4rem .7rem; font-size:.85rem;background:rgba(239,68,68,.1);color:#dc2626;border:none;border-radius:6px;cursor:pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" style="padding:1.25rem .75rem; color:var(--text-muted); text-align:center;">
                                No enrollment data available yet.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($enrollments) && method_exists($enrollments, 'links')): ?>
            <div style="margin-top:1rem;">
                <?php echo e($enrollments->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\enrollments\index.blade.php ENDPATH**/ ?>