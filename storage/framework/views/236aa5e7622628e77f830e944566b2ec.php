<?php $__env->startSection('title', 'Edit Student'); ?>
<?php $__env->startSection('page_title', 'Edit Student'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
  <div style="margin-bottom:1.5rem;">
    <h2 style="margin:0;font-size:1.5rem;">Edit Student Profile</h2>
    <p style="margin:.25rem 0 0;color:var(--text-muted);">Update personal information for <?php echo e($user->name); ?></p>
  </div>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
    <div style="padding:.75rem 1rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#dc2626;border-radius:8px;margin-bottom:1rem;">
      <ul style="margin:0;padding-left:1.25rem;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
          <li><?php echo e($error); ?></li>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
      </ul>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <form method="POST" action="<?php echo e(route('sias.admin.students.update', $user->id)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div style="display:grid;gap:1rem;max-width:560px">
      <label style="display:grid;gap:.35rem;font-weight:600;">
        Student ID (LRN)
        <input name="student_id" required class="form-input" value="<?php echo e(old('student_id', $user->lrn)); ?>">
      </label>

      <label style="display:grid;gap:.35rem;font-weight:600;">
        Full Name
        <input name="name" required class="form-input" value="<?php echo e(old('name', $user->name)); ?>">
      </label>

      <label style="display:grid;gap:.35rem;font-weight:600;">
        Email Address
        <input name="email" type="email" required class="form-input" value="<?php echo e(old('email', $user->email)); ?>">
      </label>

      <label style="display:grid;gap:.35rem;font-weight:600;">
        Age
        <input name="age" type="number" min="1" max="120" class="form-input" value="<?php echo e(old('age', $user->age)); ?>">
      </label>

      <div style="display:flex;gap:.75rem;margin-top:1rem;">
        <button type="submit" style="padding:.75rem 1.5rem;background:#1d4ed8;color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer;">Update Student</button>
        <a href="<?php echo e(route('sias.admin.students.index')); ?>" style="padding:.75rem 1.5rem;background:var(--block-bg);border:1px solid var(--block-border);color:var(--text);border-radius:8px;text-decoration:none;font-weight:600;">Cancel</a>
      </div>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\students\edit.blade.php ENDPATH**/ ?>