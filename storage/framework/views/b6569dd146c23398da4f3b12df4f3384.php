

<?php $__env->startSection('title', 'Add Training Schedule'); ?>
<?php $__env->startSection('page_title', 'Add Training Schedule'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card">
	<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem;">
		<div>
			<h2>Add Training Schedule</h2>
			<p style="margin:.35rem 0 0;color:#64748b;">Set a class time, room, and subject for your trainees.</p>
		</div>
		<a href="<?php echo e(route('sias.teacher.schedule')); ?>" class="btn" style="background:#eef2ff;color:#1d4ed8;">Back to Schedule</a>
	</div>

	<form method="POST" action="<?php echo e(route('sias.teacher.schedule.store')); ?>" style="display:grid;gap:1rem;max-width:760px;">
		<?php echo csrf_field(); ?>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Program
				<select name="course_id">
					<option value="">Select program</option>
					<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
						<option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
					<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
				</select>
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				Subject / Activity
				<input type="text" name="subject_name" value="<?php echo e(old('subject_name')); ?>" required>
			</label>
		</div>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Day
				<select name="day_of_week" required>
					<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
						<option value="<?php echo e($day); ?>" <?php echo e(old('day_of_week') === $day ? 'selected' : ''); ?>><?php echo e($day); ?></option>
					<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
				</select>
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				Trainee count
				<input type="number" name="student_count" min="0" value="<?php echo e(old('student_count', 0)); ?>">
			</label>
		</div>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Start time
				<input type="time" name="start_time" value="<?php echo e(old('start_time')); ?>" required>
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				End time
				<input type="time" name="end_time" value="<?php echo e(old('end_time')); ?>" required>
			</label>
		</div>

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
			<label style="display:grid;gap:.45rem;font-weight:700;">
				Building
				<input type="text" name="building" value="<?php echo e(old('building')); ?>" placeholder="Main Building">
			</label>

			<label style="display:grid;gap:.45rem;font-weight:700;">
				Room
				<input type="text" name="room_number" value="<?php echo e(old('room_number')); ?>" placeholder="20">
			</label>
		</div>

		<label style="display:grid;gap:.45rem;font-weight:700;">
			Notes
			<textarea name="notes" rows="3" style="resize:vertical;"><?php echo e(old('notes')); ?></textarea>
		</label>

		<div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
			<a href="<?php echo e(route('sias.teacher.schedule')); ?>" class="btn" style="background:#f1f5f9;color:#0f172a;">Cancel</a>
			<button class="btn" type="submit">Save schedule</button>
		</div>
	</form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\schedule\create.blade.php ENDPATH**/ ?>