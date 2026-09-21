

<?php $__env->startSection('title', 'Edit Schedule'); ?>
<?php $__env->startSection('page_title', 'Edit Schedule'); ?>
<?php $__env->startSection('subtitle', 'Update the training session details'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card" style="max-width:760px;margin:0 auto;">
    <form method="POST" action="<?php echo e(route('admin.schedules.update', $schedule)); ?>" style="display:grid;gap:1.25rem;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Course
                <select name="course_id" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                    <option value="">No course selected</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id', $schedule->course_id) == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:#ef4444;font-size:.85rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Teacher <span style="color:#ef4444;">*</span>
                <select name="teacher_id" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                    <option value="">Select teacher</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($teacher->id); ?>" <?php echo e(old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : ''); ?>><?php echo e($teacher->name); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['teacher_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:#ef4444;font-size:.85rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Subject / Activity <span style="color:#ef4444;">*</span>
                <input type="text" name="subject_name" value="<?php echo e(old('subject_name', $schedule->subject_name)); ?>" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['subject_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:#ef4444;font-size:.85rem;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Day <span style="color:#ef4444;">*</span>
                <select name="day_of_week" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($day); ?>" <?php echo e(old('day_of_week', $schedule->day_of_week) === $day ? 'selected' : ''); ?>><?php echo e($day); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Start time <span style="color:#ef4444;">*</span>
                <input type="time" name="start_time" value="<?php echo e(old('start_time', substr($schedule->start_time, 0, 5))); ?>" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">End time <span style="color:#ef4444;">*</span>
                <input type="time" name="end_time" value="<?php echo e(old('end_time', substr($schedule->end_time, 0, 5))); ?>" required style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Building
                <input type="text" name="building" value="<?php echo e(old('building', $schedule->building)); ?>" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Room
                <input type="text" name="room_number" value="<?php echo e(old('room_number', $schedule->room_number)); ?>" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Trainee count
                <input type="number" name="student_count" min="0" value="<?php echo e(old('student_count', $schedule->student_count)); ?>" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;">
            </label>
            <label style="display:flex;align-items:center;gap:.55rem;align-self:end;padding-bottom:12px;font-weight:600;color:var(--text);">
                <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $schedule->is_active) ? 'checked' : ''); ?>> Active schedule
            </label>
        </div>

        <label style="display:grid;gap:.45rem;font-weight:600;color:var(--text);">Notes
            <textarea name="notes" rows="3" style="padding:12px 14px;border:1px solid var(--card-border);border-radius:10px;background:var(--card-bg);color:var(--text);font:inherit;resize:vertical;"><?php echo e(old('notes', $schedule->notes)); ?></textarea>
        </label>

        <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
            <a href="<?php echo e(route('admin.schedules.index')); ?>" class="btn-secondary" style="padding:12px 24px;">Cancel</a>
            <button type="submit" class="btn" style="padding:12px 24px;">Update Schedule</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\schedules\edit.blade.php ENDPATH**/ ?>