
<?php $__env->startSection('title', 'Account Settings'); ?>
<?php $__env->startSection('page_title', 'Account Settings'); ?>
<?php $__env->startSection('content'); ?>
<div class="portal-page">
    <div class="portal-heading"><div><h2>Trainer Account</h2><p>Manage trainer information, account settings, and password security.</p></div><a class="portal-button" href="<?php echo e(route('teacher.profile.edit')); ?>">Edit trainer information</a></div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?><div class="portal-card" style="color:#166534;background:#ecfdf5;"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="portal-grid">
        <div class="portal-card"><h3>Trainer information</h3><p><strong><?php echo e($user->name); ?></strong></p><p><?php echo e($user->email); ?></p><p><?php echo e($user->staff_type ?? 'Teacher'); ?></p></div>
        <div class="portal-card"><h3>Change password</h3><form method="POST" action="<?php echo e(route('teacher.account.password.update')); ?>" style="display:grid;gap:.7rem;"><?php echo csrf_field(); ?><input type="password" name="current_password" placeholder="Current password" required><input type="password" name="password" placeholder="New password" required><input type="password" name="password_confirmation" placeholder="Confirm new password" required><button class="portal-button" type="submit">Update password</button><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color:#b91c1c;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small style="color:#b91c1c;"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></form></div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/teacher/account/index.blade.php ENDPATH**/ ?>