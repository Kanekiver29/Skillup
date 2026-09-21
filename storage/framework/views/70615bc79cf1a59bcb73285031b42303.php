

<?php $__env->startSection('title', 'Edit Subject'); ?>
<?php $__env->startSection('page_title', 'Edit Subject'); ?>
<?php $__env->startSection('subtitle', 'Update subject details and assign teacher'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card" style="max-width: 700px; margin: 0 auto;">
    <form method="POST" action="<?php echo e(route('sias.admin.subject.update', $subject->id)); ?>" style="display: grid; gap: 1.5rem;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text);">
                Subject Title <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" name="title" required
                   style="width: 100%; padding: 12px 14px; border: 1px solid var(--card-border); border-radius: 10px; background: var(--card-bg); color: var(--text); font-family: inherit; font-size: 1rem; transition: border 0.2s ease;"
                   placeholder="e.g., Mathematics 101" value="<?php echo e(old('title', $subject->title)); ?>">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span style="color: #ef4444; font-size: 0.9rem; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text);">
                Course <span style="color: #ef4444;">*</span>
            </label>
            <select name="course_id" required
                    style="width: 100%; padding: 12px 14px; border: 1px solid var(--card-border); border-radius: 10px; background: var(--card-bg); color: var(--text); font-family: inherit; font-size: 1rem; cursor: pointer; transition: border 0.2s ease;">
                <option value="">-- Select a Course --</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id', $subject->course_id) == $course->id ? 'selected' : ''); ?>>
                        <?php echo e($course->title); ?>

                    </option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span style="color: #ef4444; font-size: 0.9rem; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text);">
                Assign Teacher <span style="color: var(--text-muted); font-weight: 400; font-size: 0.9rem;">(Optional)</span>
            </label>
            <select name="teacher_id"
                    style="width: 100%; padding: 12px 14px; border: 1px solid var(--card-border); border-radius: 10px; background: var(--card-bg); color: var(--text); font-family: inherit; font-size: 1rem; cursor: pointer; transition: border 0.2s ease;">
                <option value="">-- No Teacher (Unassigned) --</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\User::where('role', 'teacher')->orWhere('is_admin', true)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($user->id); ?>" <?php echo e(old('teacher_id', $subject->teacher_id) == $user->id ? 'selected' : ''); ?>>
                        <?php echo e($user->name); ?> (<?php echo e($user->role); ?>)
                    </option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['teacher_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span style="color: #ef4444; font-size: 0.9rem; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div style="background: var(--block-bg); padding: 14px 16px; border-radius: 10px; border-left: 3px solid var(--accent-strong);">
            <p style="margin: 0; color: var(--text-muted); font-size: 0.9rem;">
                <strong style="color: var(--text);">Current Assignment:</strong>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->teacher): ?>
                    <span style="display: inline-block; margin-top: 6px; padding: 6px 12px; background: rgba(224, 176, 84, 0.15); border-radius: 8px; color: var(--accent-strong); font-weight: 500;">
                        <?php echo e($subject->teacher->name); ?>

                    </span>
                <?php else: ?>
                    <span style="color: var(--text-muted); font-style: italic;">No teacher assigned</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </p>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 1rem;">
            <button type="submit" class="btn" style="flex: 1; padding: 12px 24px;">
                <i class="fa-solid fa-check" style="margin-right: 6px;"></i> Save Changes
            </button>
            <a href="<?php echo e(route('sias.admin.subject')); ?>" class="btn-secondary" style="flex: 1; padding: 12px 24px; text-align: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
    input:focus, select:focus {
        outline: none;
        border-color: var(--accent-strong);
        box-shadow: 0 0 0 3px rgba(224, 176, 84, 0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font: inherit;
        font-weight: 500;
        border: 1px solid var(--card-border);
        cursor: pointer;
        border-radius: 12px;
        background: var(--block-bg);
        color: var(--text);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background: var(--card-bg);
        border-color: var(--accent-strong);
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\subject\edit.blade.php ENDPATH**/ ?>