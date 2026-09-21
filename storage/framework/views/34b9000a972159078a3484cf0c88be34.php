

<?php $__env->startSection('title', isset($module) ? 'Edit Module' : 'Create Module'); ?>
<?php $__env->startSection('page_title', isset($module) ? 'Edit Module' : 'New Module'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .form-container {
        max-width: 820px;
        margin: 0 auto;
    }
    .form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .form-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--navy-950);
    }
    .btn-back {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--navy-800);
        font-weight: 700;
        padding: 0.6rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
    }
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        box-shadow: var(--shadow-card);
    }
    .form-group {
        margin-bottom: 1.4rem;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--navy-950);
        margin-bottom: 0.45rem;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface-2);
        color: var(--text);
        font-family: inherit;
        font-size: 0.92rem;
    }
    .form-control:focus {
        border-color: var(--accent-2);
        outline: none;
        background: #fff;
    }
    .btn-submit {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.8rem 1.6rem;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
    }
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
        border-top: 1px solid var(--border-soft);
        padding-top: 1.5rem;
        margin-top: 1.5rem;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <div>
            <h1>📂 <?php echo e(isset($module) ? 'Edit Module' : 'Create New Module'); ?></h1>
            <p style="color:var(--muted); font-size:0.9rem; margin-top:0.25rem;">Define curriculum modules to organize lessons and assessments.</p>
        </div>
        <a href="<?php echo e(route('teacher.modules.index')); ?>" class="btn-back">← Back to Modules</a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #b91c1c; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <ul>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="form-card">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($courses ?? collect())->isEmpty()): ?>
            <div style="background: rgba(234, 179, 8, 0.08); border: 1px solid rgba(234, 179, 8, 0.3); color: #92400e; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
                <strong>No courses assigned yet.</strong>
                <p style="margin: 0.5rem 0 0;">Create a course first in the teacher courses section before adding a module.</p>
                <div style="margin-top: 0.85rem;">
                    <a href="<?php echo e(route('teacher.courses.create')); ?>" class="btn-back">Create Course</a>
                </div>
            </div>
        <?php else: ?>
            <form method="POST" action="<?php echo e(isset($module) ? route('teacher.modules.update', $module->id) : route('teacher.modules.store')); ?>">
                <?php echo csrf_field(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($module)): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="form-group">
                    <label for="course_id">Associated Course <span style="color:var(--danger)">*</span></label>
                    <select id="course_id" name="course_id" class="form-control" required>
                        <option value="">-- Select Course --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($c->id); ?>" <?php echo e(old('course_id', $module->course_id ?? request('course_id')) == $c->id ? 'selected' : ''); ?>>
                                <?php echo e($c->title); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">Module Title <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="title" name="title" value="<?php echo e(old('title', $module->title ?? '')); ?>" class="form-control" placeholder="e.g., Module 1: Introduction to Web Development" required>
                </div>

                <div class="form-group">
                    <label for="description">Module Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control" placeholder="Module goals and summary..."><?php echo e(old('description', $module->description ?? '')); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="order">Display Order</label>
                    <input type="number" id="order" name="order" value="<?php echo e(old('order', $module->order ?? 1)); ?>" min="1" class="form-control">
                </div>

                <div class="form-footer">
                    <a href="<?php echo e(route('teacher.modules.index')); ?>" class="btn-back">Cancel</a>
                    <button type="submit" class="btn-submit">
                        <?php echo e(isset($module) ? 'Update Module' : 'Save & Publish Module'); ?>

                    </button>
                </div>
            </form>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\modules\create.blade.php ENDPATH**/ ?>