

<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
  <header class="mb-6">
    <h1 class="text-3xl font-semibold">User Management</h1>
    <p class="text-sm text-gray-600">Manage all users in the system</p>
  </header>

  <?php if(session('success')): ?>
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <div class="glass-table overflow-x-auto">
  <table class="w-full glass-table">
    <thead class="bg-gray-100 border-b">
      <tr class="glass-card">
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Joined</th>
        <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr class="border-b hover:bg-gray-50">
          <td class="px-6 py-4 text-sm font-medium"><?php echo e($user->name); ?></td>
          <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->email); ?></td>
          <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">Regular User</span></td>
          <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->created_at->format('M d, Y')); ?></td>
          <td class="px-6 py-4 text-right text-sm space-x-2">
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="glass-button text-xs font-semibold">Edit</a>
            <form action="<?php echo e(route('admin.make-admin', $user)); ?>" method="POST" class="inline">
              <?php echo csrf_field(); ?>
              <button type="submit" class="glass-button text-xs font-semibold bg-green-600 hover:bg-green-700">Make Admin</button>
            </form>
            <form action="<?php echo e(route('admin.users.delete', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will archive the user account. You can restore it later from the Archive Center.');">
              <?php echo csrf_field(); ?>
              <?php echo method_field('DELETE'); ?>
              <button type="submit" class="glass-button text-xs font-semibold bg-red-600 hover:bg-red-700">Archive</button>
            </form>
          </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No regular users found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

  <div class="mt-4">
    <?php echo e($users->links()); ?>

  </div>

  <div class="mt-6">
    <a href="<?php echo e(route('admin.admins')); ?>" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      View Admin Accounts
    </a>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 ml-2">
      Back to Dashboard
    </a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/Admin/users/list.blade.php ENDPATH**/ ?>