

<?php $__env->startSection('title', 'Student Change Password'); ?>
<?php $__env->startSection('page_title', 'Change Password'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="max-width:720px">
    <h2>Change Password</h2>
    <p>Update your student account password to keep your account secure.</p>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="section-block" style="border-left:4px solid #16a34a;background:#ecfdf5;color:#166534;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="section-block" style="border-left:4px solid #dc2626;background:#fee2e2;color:#991b1b;">
            <ul style="margin:0;padding-left:1.25rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('account.password.update')); ?>" style="display:grid;gap:1rem;margin-top:1rem">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.85rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#0f172a;">Current Password</span>
            <input type="password" name="current_password" required class="form-input" autocomplete="current-password">
        </label>

        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.85rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#0f172a;">New Password</span>
            <input type="password" name="password" required class="form-input" autocomplete="new-password">
        </label>

        <label style="display:grid;gap:.35rem;">
            <span style="font-size:.85rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#0f172a;">Confirm New Password</span>
            <input type="password" name="password_confirmation" required class="form-input" autocomplete="new-password">
        </label>

        <button type="submit" class="btn-black">Save New Password</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\account\password.blade.php ENDPATH**/ ?>