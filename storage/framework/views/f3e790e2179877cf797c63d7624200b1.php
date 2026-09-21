

<?php $__env->startSection('title', 'Course and Subject Registration'); ?>
<?php $__env->startSection('page_title', 'Course & Subject Registration'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="max-width:1200px; margin:0 auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        <div>
            <h3 style="margin:0; font-size:1.6rem;">Student course and subject registration</h3>
            <p style="margin:.4rem 0 0; color:#64748b;">Select your program and add subjects for enrollment, assessment, and certification.</p>
        </div>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <a href="<?php echo e(route('sias.student.registration.enrollment_form')); ?>" class="btn-black">Print Enrollment Form</a>
            <a href="<?php echo e(route('sias.student.registration.assessment_form')); ?>" class="btn-white">Print Assessment Form</a>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="alert-box success"><?php echo e(session('success')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div class="alert-box error"><?php echo e(session('error')); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px,1fr)); gap:1.25rem; margin-top:1rem;">
        <div class="info-panel">
            <h4>Register Course</h4>
            <form method="POST" action="<?php echo e(route('sias.student.registration.course')); ?>">
                <?php echo csrf_field(); ?>
                <label style="display:block; margin-bottom:.75rem; font-weight:600; color:#0f172a;">Course</label>
                <select name="course_id" required style="width:100%; padding:.85rem 1rem; border-radius:12px; border:1px solid #cbd5e1; background:#fff; margin-bottom:1rem;">
                    <option value="">Select a course</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($courseItem->id); ?>" <?php echo e(($course ?? null)?->id == $courseItem->id ? 'selected' : ''); ?>>
                            <?php echo e($courseItem->title); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <button type="submit" class="btn-black">Add Course</button>
            </form>
        </div>

        <div class="info-panel">
            <h4>Register Subjects</h4>
            <form method="POST" action="<?php echo e(route('sias.student.registration.subjects')); ?>">
                <?php echo csrf_field(); ?>
                <div style="display:grid; gap:.75rem; max-height:280px; overflow:auto; border:1px solid #e2e8f0; border-radius:12px; padding:1rem; background:#f8fafc;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $allSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <label style="display:flex; align-items:center; gap:.75rem; color:#0f172a;">
                            <input type="checkbox" name="subject_ids[]" value="<?php echo e($subjectItem->id); ?>" <?php echo e(collect($subjects)->contains('id', $subjectItem->id) ? 'checked' : ''); ?>>
                            <span><?php echo e($subjectItem->title); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjectItem->teacher): ?> <small style="color:#64748b;">— <?php echo e($subjectItem->teacher->name); ?></small> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></span>
                        </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <p style="margin:0; color:#64748b;">No subjects available yet.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div style="margin-top:1rem;">
                    <button type="submit" class="btn-black">Add Subjects</button>
                </div>
            </form>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px,1fr)); gap:1.25rem; margin-top:1.75rem;">
        <div class="info-panel">
            <h4>Selected Course</h4>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course): ?>
                <div class="summary-box">
                    <strong><?php echo e($course->title); ?></strong>
                    <p><?php echo e($course->category ?? 'Course category'); ?></p>
                    <small>Teacher: <?php echo e($course->instructor?->name ?? $course->instructor_name ?? 'Assigned course teacher'); ?></small>
                    <small><?php echo e($course->description ?? 'No description available.'); ?></small>
                </div>
            <?php else: ?>
                <p class="muted-text">No course selected yet.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="info-panel">
            <h4>Selected Subjects</h4>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjects->count()): ?>
                <ul style="margin:0; padding-left:1.25rem; display:grid; gap:.5rem; color:#0f172a;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($subject->title); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            <?php else: ?>
                <p class="muted-text">No subjects selected yet.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div style="display:flex; gap:.75rem; flex-wrap:wrap; margin-top:1.75rem;">
        <a href="<?php echo e(route('sias.student.registration.enrollment_certificate')); ?>" class="btn-black">Certificate of Enrollment</a>
        <a href="<?php echo e(route('sias.student.registration.assessment_certificate')); ?>" class="btn-white">Assessment Certificate</a>
        <a href="<?php echo e(route('sias.student.registration.grade_certificate')); ?>" class="btn-white">Grade Certificate</a>
        <form method="POST" action="<?php echo e(route('sias.student.registration.reset')); ?>" style="margin:0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-white">Reset</button>
        </form>
    </div>
</div>

<style>
    .alert-box {
        border-radius: 14px;
        padding: 0.9rem 1rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .alert-box.success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #a7f3d0;
    }
    .alert-box.error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .info-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 1.2rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
    }
    .info-panel h4 {
        margin: 0 0 1rem;
        font-size: 1.1rem;
        color: #0f172a;
    }
    .summary-box {
        display: grid;
        gap: .35rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1rem;
    }
    .summary-box strong {
        font-size: 1.08rem;
    }
    .summary-box p,
    .summary-box small,
    .muted-text {
        margin: 0;
        color: #64748b;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\registration\index.blade.php ENDPATH**/ ?>