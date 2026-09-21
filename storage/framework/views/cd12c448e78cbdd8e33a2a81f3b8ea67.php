

<?php $__env->startSection('title', 'Archived User - ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
	<div class="bg-white border-b border-gray-200 mb-8">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
			<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
				<div>
					<h1 class="text-3xl font-bold text-gray-900">Archived User Details</h1>
					<p class="text-gray-600 mt-1">Viewing archived account and course enrollment history.</p>
				</div>
				<a href="<?php echo e(route('admin.archive')); ?>" class="text-sm font-medium text-blue-600 hover:text-blue-800">
					&larr; Back to Archive
				</a>
			</div>
		</div>
	</div>

	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
			<div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
				<?php echo e(session('success')); ?>

			</div>
		<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

		<!-- User Info Card -->
		<section class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 mb-8">
			<h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div>
					<p class="text-sm text-gray-500">Full Name</p>
					<p class="text-base font-medium text-gray-900"><?php echo e($user->name); ?></p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Email</p>
					<p class="text-base font-medium text-gray-900"><?php echo e($user->email); ?></p>
				</div>
				<div>
					<p class="text-sm text-gray-500">LRN</p>
					<p class="text-base font-medium text-gray-900"><?php echo e($user->lrn ?? 'N/A'); ?></p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Role</p>
					<p class="text-base font-medium text-gray-900"><?php echo e($user->is_admin ? 'Admin' : 'Student'); ?></p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Account Created</p>
					<p class="text-base font-medium text-gray-900"><?php echo e($user->created_at->format('M d, Y h:i A')); ?></p>
				</div>
				<div>
					<p class="text-sm text-gray-500">Archived At</p>
					<p class="text-base font-medium text-red-600"><?php echo e(optional($user->deleted_at)->format('M d, Y h:i A') ?? 'Unknown'); ?></p>
				</div>
			</div>

			<!-- Actions -->
			<div class="mt-6 flex flex-wrap gap-3">
				<form action="<?php echo e(route('admin.users.restore', $user->id)); ?>" method="POST">
					<?php echo csrf_field(); ?>
					<button type="submit" class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
						Restore Account
					</button>
				</form>
				<form action="<?php echo e(route('admin.users.force-delete', $user->id)); ?>" method="POST" onsubmit="return confirm('Permanently delete this user and all their data? This action cannot be undone.');">
					<?php echo csrf_field(); ?>
					<?php echo method_field('DELETE'); ?>
					<button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
						Delete Permanently
					</button>
				</form>
			</div>
		</section>

		<!-- Course Enrollment History -->
		<section class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
			<div class="px-5 py-4 border-b border-gray-200">
				<h2 class="text-lg font-semibold text-gray-900">Course Enrollment History</h2>
				<p class="text-sm text-gray-500 mt-1">All courses this user was enrolled in before archiving.</p>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Course</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Progress</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Status</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Enrolled At</th>
							<th class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-gray-600 uppercase">Completed At</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-100 bg-white">
						<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
							<tr class="hover:bg-gray-50">
								<td class="px-5 py-4">
									<div class="font-medium text-gray-900">
										<?php echo e($enrollment->course->title ?? $enrollment->course->course_title ?? 'Deleted Course'); ?>

									</div>
									<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollment->course): ?>
										<div class="text-xs text-gray-500"><?php echo e(Str::limit($enrollment->course->description, 60)); ?></div>
									<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
								</td>
								<td class="px-5 py-4">
									<div class="flex items-center gap-2">
										<div class="w-24 bg-gray-200 rounded-full h-2">
											<div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e($enrollment->progress ?? 0); ?>%"></div>
										</div>
										<span class="text-sm text-gray-700"><?php echo e($enrollment->progress ?? 0); ?>%</span>
									</div>
								</td>
								<td class="px-5 py-4 text-sm">
									<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollment->completed): ?>
										<span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded font-semibold">Completed</span>
									<?php else: ?>
										<span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded font-semibold">In Progress</span>
									<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
								</td>
								<td class="px-5 py-4 text-sm text-gray-700">
									<?php echo e($enrollment->created_at->format('M d, Y')); ?>

								</td>
								<td class="px-5 py-4 text-sm text-gray-700">
									<?php echo e($enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : '—'); ?>

								</td>
							</tr>
						<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
							<tr>
								<td colspan="5" class="px-5 py-12 text-center text-sm text-gray-500">
									This user had no course enrollments.
								</td>
							</tr>
						<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
					</tbody>
				</table>
			</div>

			<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($enrollments->count() > 0): ?>
				<div class="px-5 py-4 border-t border-gray-200 bg-gray-50">
					<div class="flex flex-wrap gap-4 text-sm text-gray-600">
						<span><strong>Total Courses:</strong> <?php echo e($enrollments->count()); ?></span>
						<span><strong>Completed:</strong> <?php echo e($enrollments->where('completed', true)->count()); ?></span>
						<span><strong>In Progress:</strong> <?php echo e($enrollments->where('completed', false)->count()); ?></span>
					</div>
				</div>
			<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
		</section>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\users\archived-detail.blade.php ENDPATH**/ ?>