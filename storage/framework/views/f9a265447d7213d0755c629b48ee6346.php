

<?php $__env->startSection('title', 'Subject Management'); ?>
<?php $__env->startSection('page_title', 'Subjects'); ?>
<?php $__env->startSection('subtitle', 'Manage subjects and assign teachers'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <h2 style="margin: 0; font-size: 1.5rem;">All Subjects</h2>
        <a href="<?php echo e(route('sias.admin.subject.add')); ?>" class="btn" style="padding: 0.7rem 1.2rem; font-size: 0.9rem;">
            <i class="fa-solid fa-plus" style="margin-right: 6px;"></i> Add Subject
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjects->isEmpty()): ?>
        <p style="color: var(--text-muted); text-align: center; padding: 2rem 1rem;">No subjects found. <a href="<?php echo e(route('sias.admin.subject.add')); ?>" style="color: var(--accent); text-decoration: none; font-weight: 600;">Create one</a>.</p>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--card-border); background: var(--block-bg);">
                        <th style="text-align: left; padding: 12px 16px; font-weight: 600; color: var(--text-muted);">Subject Title</th>
                        <th style="text-align: left; padding: 12px 16px; font-weight: 600; color: var(--text-muted);">Course</th>
                        <th style="text-align: left; padding: 12px 16px; font-weight: 600; color: var(--text-muted);">Assigned Teacher</th>
                        <th style="text-align: center; padding: 12px 16px; font-weight: 600; color: var(--text-muted); width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr style="border-bottom: 1px solid var(--card-border); transition: background 0.2s ease;">
                            <td style="padding: 14px 16px;">
                                <strong style="color: var(--text);"><?php echo e($subject->title); ?></strong>
                            </td>
                            <td style="padding: 14px 16px; color: var(--text-muted);">
                                <?php echo e($subject->course->title ?? 'N/A'); ?>

                            </td>
                            <td style="padding: 14px 16px;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->teacher): ?>
                                    <span style="display: inline-block; padding: 6px 12px; background: rgba(224, 176, 84, 0.15); border-radius: 8px; color: var(--accent-strong); font-weight: 500; font-size: 0.9rem;">
                                        <?php echo e($subject->teacher->name); ?>

                                    </span>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-style: italic; font-size: 0.9rem;">Unassigned</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td style="padding: 14px 16px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="<?php echo e(route('sias.admin.subject.edit', $subject->id)); ?>" 
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: var(--block-bg); color: var(--accent-strong); text-decoration: none; transition: all 0.2s ease;"
                                       title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('sias.admin.subject.delete', $subject->id)); ?>" style="display: inline; margin: 0;"
                                          onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                style="width: 32px; height: 32px; border-radius: 8px; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease;"
                                                title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjects->hasPages()): ?>
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                <?php echo e($subjects->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<style>
    table tr:hover {
        background: var(--block-bg);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        font: inherit;
        font-weight: 500;
        border: none;
        cursor: pointer;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%);
        color: #241a04;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(201, 151, 59, .25);
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(201, 151, 59, .35);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\subject\index.blade.php ENDPATH**/ ?>