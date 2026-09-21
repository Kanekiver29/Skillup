

<?php $__env->startSection('title', 'Course Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="cr-page" style="padding:24px;display:grid;gap:24px;">
    <div class="cr-card" style="padding:24px;display:grid;gap:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
            <div>
                <div class="cr-header__eyebrow">
                    <span class="cr-header__eyebrow-dot"></span>
                    Staff Portal
                </div>
                <h1 class="cr-header__title" style="margin:4px 0 0;"><?php echo e($course->title ?? 'Course Details'); ?></h1>
                <p class="cr-header__subtitle" style="margin-top:6px;">Review course information and manage publishing status.</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <a href="<?php echo e(route('staff.courses.edit', $course->id)); ?>" class="cr-btn cr-btn--outline">Edit</a>
                <a href="<?php echo e(route('staff.courses.index')); ?>" class="cr-btn cr-btn--primary">Back to Courses</a>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
            <div class="cr-card" style="padding:16px;background:#f8fafc;">
                <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Title</div>
                <div style="font-weight:700;font-size:16px;margin-top:6px;"><?php echo e($course->title ?? '—'); ?></div>
            </div>
            <div class="cr-card" style="padding:16px;background:#f8fafc;">
                <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Category</div>
                <div style="font-weight:700;font-size:16px;margin-top:6px;"><?php echo e($course->category ?? '—'); ?></div>
            </div>
            <div class="cr-card" style="padding:16px;background:#f8fafc;">
                <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Level</div>
                <div style="font-weight:700;font-size:16px;margin-top:6px;"><?php echo e($course->level ?? '—'); ?></div>
            </div>
            <div class="cr-card" style="padding:16px;background:#f8fafc;">
                <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Status</div>
                <div style="font-weight:700;font-size:16px;margin-top:6px;"><?php echo e($course->is_published ? 'Published' : 'Draft'); ?></div>
            </div>
        </div>

        <div class="cr-card" style="padding:16px;background:#fff;">
            <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Description</div>
            <div style="margin-top:8px;color:#334155;line-height:1.6;"><?php echo e($course->description ?? $course->short_description ?? 'No description provided.'); ?></div>
        </div>

        <div class="cr-card" style="padding:16px;background:#fff;">
            <div style="font-size:12px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;">Instructor</div>
            <div style="margin-top:8px;font-weight:600;"><?php echo e($course->instructor_name ?? '—'); ?></div>
            <div style="margin-top:4px;color:#64748b;"><?php echo e($course->instructor_title ?? ''); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\courses\show.blade.php ENDPATH**/ ?>