

<?php $__env->startSection('title', 'Create User'); ?>
<?php $__env->startSection('page_title', 'Create User'); ?>
<?php $__env->startSection('subtitle', 'Create a new user account and assign the proper role.'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .user-form-card {
    max-width: 860px;
    margin: 0 auto;
    padding: 28px;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 18px;
    box-shadow: var(--card-shadow);
  }

  .user-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 16px;
  }

  .user-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .user-field.full {
    grid-column: 1 / -1;
  }

  .user-field label {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text);
  }

  .user-field label .req {
    color: var(--danger);
  }

  .user-input,
  .user-select {
    width: 100%;
    min-height: 44px;
    padding: 0.7rem 0.8rem;
    border-radius: 10px;
    border: 1px solid var(--card-border);
    background: var(--bg);
    color: var(--text);
    font: inherit;
  }

  .user-input:focus,
  .user-select:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-glow);
  }

  .user-help {
    font-size: 0.78rem;
    color: var(--text-muted);
  }

  .user-errors {
    margin-bottom: 20px;
    padding: 14px 18px;
    border-radius: 12px;
    border: 1px solid rgba(239, 68, 68, 0.28);
    background: rgba(239, 68, 68, 0.08);
    color: var(--danger);
  }

  .user-errors ul {
    margin: 8px 0 0 18px;
    padding: 0;
  }

  .user-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--card-border);
  }

  @media (max-width: 720px) {
    .user-form-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="user-form-card">
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
    <div class="user-errors">
      <strong>Please fix the following errors:</strong>
      <ul>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
          <li><?php echo e($error); ?></li>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
      </ul>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <form method="POST" action="<?php echo e(route('sias.admin.users.store')); ?>" id="user-create-form">
    <?php echo csrf_field(); ?>

    <div class="user-form-grid">
      <div class="user-field full">
        <label for="name">Full name <span class="req">*</span></label>
        <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" class="user-input" required>
      </div>

      <div class="user-field">
        <label for="email">Email address <span class="req">*</span></label>
        <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" class="user-input" required>
      </div>

      <div class="user-field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?php echo e(old('username')); ?>" class="user-input" placeholder="Optional; auto-generated if left blank">
      </div>

      <div class="user-field">
        <label for="role">Role <span class="req">*</span></label>
        <select id="role" name="role" class="user-select" required>
          <option value="">Select a role</option>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['student', 'staff', 'teacher', 'admin', 'sias_admin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <option value="<?php echo e($role); ?>" <?php if(old('role') === $role): echo 'selected'; endif; ?>><?php echo e(ucfirst(str_replace('_', ' ', $role))); ?></option>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </select>
      </div>

      <div class="user-field">
        <label for="department">Department</label>
        <input id="department" name="department" type="text" value="<?php echo e(old('department')); ?>" class="user-input" placeholder="e.g. Academic, IT, Admin">
      </div>

      <div class="user-field">
        <label for="staff_type">Staff type</label>
        <select id="staff_type" name="staff_type" class="user-select">
          <option value="">Not applicable</option>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['teacher', 'instructor', 'moderator', 'content_manager', 'support']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <option value="<?php echo e($staffType); ?>" <?php if(old('staff_type') === $staffType): echo 'selected'; endif; ?>><?php echo e(ucfirst(str_replace('_', ' ', $staffType))); ?></option>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </select>
      </div>

      <div class="user-field">
        <label for="password">Password <span class="req">*</span></label>
        <input id="password" name="password" type="password" class="user-input" required minlength="8" autocomplete="new-password">
      </div>

      <div class="user-field">
        <label for="password_confirmation">Confirm password <span class="req">*</span></label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="user-input" required minlength="8" autocomplete="new-password">
      </div>

      <div class="user-field full">
        <label>
          <input type="checkbox" name="is_admin" value="1" <?php if(old('is_admin')): echo 'checked'; endif; ?>>
          Mark as admin access
        </label>
        <small class="user-help">This is useful for custom admin accounts, although role selection already grants admin privileges for the admin roles.</small>
      </div>
    </div>

    <div class="user-actions">
      <a href="<?php echo e(route('sias.admin.users')); ?>" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">Create user</button>
    </div>
  </form>
</div>

<script>
  const createForm = document.getElementById('user-create-form');
  const nameInput = document.getElementById('name');
  const usernameInput = document.getElementById('username');

  if (createForm && nameInput && usernameInput) {
    const syncUsername = () => {
      if (!usernameInput.value.trim()) {
        const seed = nameInput.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '');
        usernameInput.value = seed || '';
      }
    };

    nameInput.addEventListener('input', syncUsername);
    syncUsername();
  }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\users\create.blade.php ENDPATH**/ ?>