

<?php $__env->startSection('content'); ?>
<div class="px-6 py-6">
	<div class="flex items-center justify-between mb-6">
		<div>
			<h1 class="text-2xl font-bold text-slate-900">Staff Management</h1>
			<p class="text-sm text-slate-500">Manage platform staff, transfer roles and demote when necessary.</p>
		</div>
		<div class="flex items-center gap-3">
			<a href="<?php echo e(route('admin.staff.create')); ?>" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded shadow hover:bg-emerald-500">Create Staff</a>
			<a href="<?php echo e(route('admin.staff.register')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-500">Register Account</a>
		</div>
	</div>

	<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
		<div class="p-4 bg-white rounded shadow">
			<p class="text-xs text-gray-500 uppercase">Total Staff</p>
			<p class="text-2xl font-semibold"><?php echo e(number_format($totalStaff ?? 0)); ?></p>
		</div>

		<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $staffByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
			<div class="p-4 bg-white rounded shadow">
				<p class="text-xs text-gray-500 uppercase"><?php echo e($info['label']); ?></p>
				<p class="text-xl font-semibold"><?php echo e(number_format($info['count'] ?? 0)); ?></p>
			</div>
		<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
	</div>

	<div class="mb-4 bg-white p-4 rounded shadow">
		<form method="GET" action="<?php echo e(route('admin.staff.index')); ?>" class="flex flex-col md:flex-row md:items-center md:gap-4">
			<div class="flex-1">
				<label class="sr-only">Filter by staff type</label>
				<select name="staff_type" class="w-full md:w-64 border rounded px-3 py-2">
					<option value="">All Staff Types</option>
					<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $staffTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
						<option value="<?php echo e($key); ?>" <?php echo e(request('staff_type') == $key ? 'selected' : ''); ?>><?php echo e($type['label']); ?></option>
					<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
				</select>
			</div>
			<div class="mt-3 md:mt-0">
				<button type="submit" class="px-4 py-2 bg-slate-700 text-white rounded">Filter</button>
				<a href="<?php echo e(route('admin.staff.index')); ?>" class="ml-2 px-4 py-2 border rounded">Reset</a>
			</div>
		</form>
	</div>

	<div class="bg-white rounded shadow overflow-hidden">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
					<th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">
				<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
				<tr>
					<td class="px-6 py-4 whitespace-nowrap">
						<div class="flex items-center">
							<div class="h-10 w-10 mr-3 rounded-full bg-gray-100 overflow-hidden">
								<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile_image): ?>
									<img src="<?php echo e($user->profile_image); ?>" alt="<?php echo e($user->name); ?>" class="h-full w-full object-cover"/>
								<?php else: ?>
									<div class="flex items-center justify-center h-full text-gray-400"><?php echo e(strtoupper(substr($user->name,0,1))); ?></div>
								<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
							</div>
							<div>
								<div class="text-sm font-medium text-gray-900"><?php echo e($user->name); ?></div>
								<div class="text-xs text-gray-500">ID: <?php echo e($user->id); ?></div>
							</div>
						</div>
					</td>
					<td class="px-6 py-4 text-sm text-gray-700"><?php echo e($user->email); ?></td>
					<td class="px-6 py-4 text-sm text-gray-700"><?php echo e($staffTypes[$user->staff_type]['label'] ?? '—'); ?></td>
					<td class="px-6 py-4 text-sm text-gray-500"><?php echo e($user->created_at->format('Y-m-d')); ?></td>
					<td class="px-6 py-4 text-right text-sm font-medium">
						<a href="<?php echo e(route('admin.staff.transfer', $user)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Transfer</a>
						<form action="<?php echo e(route('admin.staff.demote', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Demote this staff member to student?');">
							<?php echo csrf_field(); ?>
							<?php echo method_field('DELETE'); ?>
							<button type="submit" class="text-red-600 hover:text-red-900">Demote</button>
						</form>
					</td>
				</tr>
				<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
				<tr>
					<td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No staff found.</td>
				</tr>
				<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
			</tbody>
		</table>
	</div>

	<div class="mt-4"><?php echo e($staff->links()); ?></div>

	<div class="mt-8">
		<h3 class="text-lg font-semibold mb-2">Recent Staff Additions</h3>
		<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
			<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $recentStaff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
				<div class="p-3 bg-white rounded shadow">
					<div class="font-medium"><?php echo e($s->name); ?></div>
					<div class="text-xs text-gray-500"><?php echo e($s->email); ?></div>
				</div>
			<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\users\index.blade.php ENDPATH**/ ?>