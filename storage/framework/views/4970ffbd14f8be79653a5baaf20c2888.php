


<?php $__env->startSection('title', 'Users Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
  <!-- Header -->
  <header class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-3xl font-semibold">Users Management</h1>
      <p class="text-sm text-gray-600">View and manage all user accounts</p>
    </div>
    <div>
      <span class="text-sm text-gray-700">Signed in as <strong><?php echo e(auth()->user()->name); ?></strong> (Admin)</span>
    </div>
  </header>

  <!-- Stats Section -->
  <section class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Total Users</div>
      <div class="text-3xl font-bold text-blue-600"><?php echo e($userCount); ?></div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Admin Users</div>
      <div class="text-3xl font-bold text-purple-600">
        <?php
          $adminCount = $users->where('is_admin', true)->count();
        ?>
        <?php echo e($adminCount); ?>

      </div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Regular Users</div>
      <div class="text-3xl font-bold text-green-600"><?php echo e($userCount - $adminCount); ?></div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">New This Month</div>
      <div class="text-3xl font-bold text-orange-600">
        <?php
          $thisMonth = $users->filter(function($u) {
            return $u->created_at->isCurrentMonth();
          })->count();
        ?>
        <?php echo e($thisMonth); ?>

      </div>
    </div>
    <div class="p-4 bg-white shadow rounded">
      <div class="text-sm text-gray-500 mb-1">Archived</div>
      <div class="text-3xl font-bold text-red-600">
        <?php
          $archivedCount = \App\Models\User::onlyTrashed()->count();
        ?>
        <?php echo e($archivedCount); ?>

      </div>
    </div>
  </section>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
    <div class="mb-4 p-4 bg-blue-100 text-blue-700 rounded">
      <?php echo e(session('info')); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <!-- Users Table -->
  <div class="bg-white shadow rounded overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Username</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Role</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Joined</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr class="border-b hover:bg-gray-50 transition <?php echo e($user->trashed() ? 'bg-red-50 opacity-75' : ''); ?>">
              <td class="px-6 py-4 text-sm font-medium">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile_image): ?>
                  <div class="flex items-center gap-2">
                    <img src="<?php echo e(asset('uploads/profiles/' . $user->profile_image)); ?>" 
                         alt="<?php echo e($user->name); ?>" 
                         class="w-8 h-8 rounded-full object-cover <?php echo e($user->trashed() ? 'grayscale' : ''); ?>">
                    <span><?php echo e($user->name); ?></span>
                  </div>
                <?php else: ?>
                  <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center <?php echo e($user->trashed() ? 'grayscale' : ''); ?>">
                      <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                      </svg>
                    </div>
                    <span><?php echo e($user->name); ?></span>
                  </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->email); ?></td>
              <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->username); ?></td>
              <td class="px-6 py-4 text-sm">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_admin): ?>
                  <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs rounded-full font-semibold">
                    Admin
                  </span>
                <?php else: ?>
                  <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                    User
                  </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
              <td class="px-6 py-4 text-sm">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->trashed()): ?>
                  <span class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-full font-semibold flex items-center gap-1 w-fit">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Archived
                  </span>
                  <div class="text-xs text-gray-500 mt-1">
                    <?php echo e($user->deleted_at->format('M d, Y')); ?>

                  </div>
                <?php else: ?>
                  <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                    Active
                  </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($user->created_at->format('M d, Y')); ?></td>
              <td class="px-6 py-4 text-right text-sm space-x-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$user->trashed()): ?>
                  
                  <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
                     class="text-blue-600 hover:text-blue-800 font-semibold text-xs py-1 px-2 rounded hover:bg-blue-50 inline-block">
                    Edit
                  </a>
                  
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_admin && auth()->user()->id !== $user->id): ?>
                    <form action="<?php echo e(route('admin.remove-admin', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Remove admin privileges?');">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="text-yellow-600 hover:text-yellow-800 font-semibold text-xs py-1 px-2 rounded hover:bg-yellow-50">
                        Remove Admin
                      </button>
                    </form>
                  <?php elseif(!$user->is_admin && auth()->user()->id !== $user->id): ?>
                    <form action="<?php echo e(route('admin.make-admin', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Make this user admin?');">
                      <?php echo csrf_field(); ?>
                      <button type="submit" class="text-green-600 hover:text-green-800 font-semibold text-xs py-1 px-2 rounded hover:bg-green-50">
                        Make Admin
                      </button>
                    </form>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->id !== $user->id): ?>
                    <form action="<?php echo e(route('admin.users.archive', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Archive this user? They will be hidden from normal views but can be restored later.');">
                      <?php echo csrf_field(); ?>
                      <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs py-1 px-2 rounded hover:bg-red-50 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        Archive
                      </button>
                    </form>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                  
                  <form action="<?php echo e(route('admin.users.restore', $user)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-green-600 hover:text-green-800 font-semibold text-xs py-1 px-2 rounded hover:bg-green-50 flex items-center gap-1">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                      </svg>
                      Restore
                    </button>
                  </form>

                  <form action="<?php echo e(route('admin.users.force-delete', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('PERMANENTLY delete this user? This action cannot be undone.');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs py-1 px-2 rounded hover:bg-red-50 flex items-center gap-1">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      Delete
                    </button>
                  </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </td>
            </tr>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
              <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                No users found.
              </td>
            </tr>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($users->hasPages()): ?>
    <div class="mt-4">
      <?php echo e($users->links()); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  <!-- View Toggle & Quick Links -->
  <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="p-4 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 transition">
      <h3 class="font-semibold text-blue-800 mb-1">Admin Dashboard</h3>
      <p class="text-sm text-blue-700">View platform statistics</p>
    </a>
    <a href="<?php echo e(route('admin.admins')); ?>" class="p-4 bg-purple-50 border border-purple-200 rounded hover:bg-purple-100 transition">
      <h3 class="font-semibold text-purple-800 mb-1">Admin Accounts</h3>
      <p class="text-sm text-purple-700">Manage admin users</p>
    </a>
    <a href="<?php echo e(route('admin.users.index', ['view' => 'archived'])); ?>" class="p-4 bg-red-50 border border-red-200 rounded hover:bg-red-100 transition">
      <h3 class="font-semibold text-red-800 mb-1">View Archived</h3>
      <p class="text-sm text-red-700">See archived users</p>
    </a>
    <a href="<?php echo e(route('userpage.dashboard')); ?>" class="p-4 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100 transition">
      <h3 class="font-semibold text-gray-800 mb-1">My Dashboard</h3>
      <p class="text-sm text-gray-700">View your profile</p>
    </a>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\users-dashboard.blade.php ENDPATH**/ ?>