<?php $__env->startSection('title', 'Edit Student Enrollment'); ?>
<?php $__env->startSection('page_title', 'Edit Student Enrollment'); ?>
<?php $__env->startSection('subtitle', 'Update the selected enrollment details.'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-card">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div style="padding:.75rem 1rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#dc2626;border-radius:8px;margin-bottom:1rem;">
            <ul style="margin:0;padding-left:1.25rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('sias.admin.enrollment.update', $enrollment->id)); ?>" style="display:grid; gap:1.25rem;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-grid">
            <div class="field-group">
                <label for="student">Student</label>
                <select id="student" name="student_id" required>
                    <option value="">Select student</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($student->id); ?>" <?php echo e(old('student_id', $enrollment->user_id) == $student->id ? 'selected' : ''); ?>>
                            <?php echo e($student->name); ?> (<?php echo e($student->lrn ?? $student->email); ?>)
                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div class="field-group">
                <label for="course">Course</label>
                <select id="course" name="course_id" required>
                    <option value="">Select course</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id', $enrollment->course_id) == $course->id ? 'selected' : ''); ?>>
                            <?php echo e($course->code ? $course->code . ' - ' : ''); ?><?php echo e($course->title); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div class="field-group">
                <label for="subject">Subject (Optional)</label>
                <select id="subject" name="subject_id">
                    <option value="">Select subject (all / none)</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($subject->id); ?>" <?php echo e(old('subject_id', $enrollment->subject_id) == $subject->id ? 'selected' : ''); ?>>
                            <?php echo e($subject->subject_code ?? $subject->code ?? ''); ?> - <?php echo e($subject->title); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div class="field-group">
                <label for="year_level">Year Level</label>
                <select id="year_level" name="year_level" required>
                    <option value="1st Year" <?php echo e(old('year_level', $enrollment->year_level) == '1st Year' ? 'selected' : ''); ?>>1st Year</option>
                    <option value="2nd Year" <?php echo e(old('year_level', $enrollment->year_level) == '2nd Year' ? 'selected' : ''); ?>>2nd Year</option>
                    <option value="3rd Year" <?php echo e(old('year_level', $enrollment->year_level) == '3rd Year' ? 'selected' : ''); ?>>3rd Year</option>
                    <option value="4th Year" <?php echo e(old('year_level', $enrollment->year_level) == '4th Year' ? 'selected' : ''); ?>>4th Year</option>
                </select>
            </div>

            <div class="field-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" required>
                    <option value="1st Semester" <?php echo e(old('semester', $enrollment->semester) == '1st Semester' ? 'selected' : ''); ?>>1st Semester</option>
                    <option value="2nd Semester" <?php echo e(old('semester', $enrollment->semester) == '2nd Semester' ? 'selected' : ''); ?>>2nd Semester</option>
                    <option value="Summer" <?php echo e(old('semester', $enrollment->semester) == 'Summer' ? 'selected' : ''); ?>>Summer</option>
                </select>
            </div>

            <div class="field-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="pending" <?php echo e(old('status', $enrollment->status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e(old('status', $enrollment->status) == 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="dropped" <?php echo e(old('status', $enrollment->status) == 'dropped' ? 'selected' : ''); ?>>Dropped</option>
                </select>
            </div>
        </div>

        <div class="admin-actions" style="margin-top:0;">
            <button type="submit" class="btn-black">Update Enrollment</button>
            <a href="<?php echo e(route('sias.admin.enrollments')); ?>" class="btn-white">Cancel</a>
        </div>
    </form>
</div>

<style>
    .form-grid {
        display:grid;
        grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));
        gap:1rem;
    }
    .field-group {
        display:grid;
        gap:.5rem;
    }
    .field-group label {
        font-weight:700;
        color:var(--text);
    }
    .field-group select,
    .field-group input {
        width:100%;
        padding:.8rem .9rem;
        border-radius:12px;
        border:1px solid var(--card-border);
        background:var(--card-bg);
        color:var(--text);
        font:inherit;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\enrollment\edit.blade.php ENDPATH**/ ?>