

<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('page_title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
    <section class="card">
        <h3 style="margin-top:0;">Teacher profile</h3>
        <p style="margin:0 0 1rem; color:var(--muted);">Update your public profile details and account information.</p>

        <form method="POST" action="<?php echo e(route('teacher.profile.update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div style="display:grid; gap:0.9rem;">
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Full name</label>
                    <input type="text" name="name" value="<?php echo e(old('name', $user->name ?? '')); ?>" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Bio</label>
                    <textarea name="bio" rows="4" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:0.8rem;"><?php echo e(old('bio', $user->bio ?? '')); ?></textarea>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.35rem; font-weight:600;">Profile image</label>
                    <input type="file" name="profile_image" style="width:100%; padding:0.6rem; border:1px solid var(--border); border-radius:0.8rem;">
                </div>
                <div style="display:flex; gap:0.8rem; flex-wrap:wrap;">
                    <button type="submit" class="btn-primary">Save profile</button>
                    <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/teacher/profile-edit.blade.php ENDPATH**/ ?>