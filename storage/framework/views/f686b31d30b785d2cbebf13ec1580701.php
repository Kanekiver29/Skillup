

<?php $__env->startSection('title', 'Course Reports'); ?>
<?php $__env->startSection('page_title', 'Department & Course Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="padding:1.5rem; display:grid; gap:1.5rem;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap;">
        <div>
            <h2 style="margin:0; font-size:2rem; letter-spacing:-.02em;">Department Report</h2>
            <p style="margin:.5rem 0 0; color:var(--text-muted); max-width:42rem;">
                Review each department, its active courses, and the related subject list in one place.
            </p>
        </div>
        <a href="<?php echo e(route('sias.admin.course')); ?>" class="btn" style="display:inline-flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-arrow-left"></i>
            Back to courses
        </a>
    </div>

    <div class="admin-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px,1fr));">
        <div class="admin-panel" style="--i:0;">
            <p style="margin:0 0 .3rem; color:var(--text-muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.08em;">Departments</p>
            <h3 style="margin:0; font-size:2rem;"><?php echo e($departments->count()); ?></h3>
        </div>
        <div class="admin-panel" style="--i:1;">
            <p style="margin:0 0 .3rem; color:var(--text-muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.08em;">Courses</p>
            <h3 style="margin:0; font-size:2rem;"><?php echo e($courses->count()); ?></h3>
        </div>
        <div class="admin-panel" style="--i:2;">
            <p style="margin:0 0 .3rem; color:var(--text-muted); font-size:.8rem; text-transform:uppercase; letter-spacing:.08em;">Subjects</p>
            <h3 style="margin:0; font-size:2rem;"><?php echo e($subjects->count()); ?></h3>
        </div>
    </div>

    <div style="display:grid; gap:1.25rem; grid-template-columns: minmax(260px, 320px) minmax(0, 1fr);">
        <aside class="admin-card" style="padding:1.25rem;">
            <h3 style="margin:0 0 1rem; font-size:1.1rem;">Department filters</h3>
            <div style="display:grid; gap:.65rem;">
                <a href="<?php echo e(route('sias.admin.reports')); ?>"
                   style="padding:.8rem .9rem; border-radius:10px; text-decoration:none; font-weight:600; color:<?php echo e($selectedDepartment === '' ? 'var(--accent-strong)' : 'var(--text)'); ?>; background:<?php echo e($selectedDepartment === '' ? 'rgba(29,78,216,.08)' : 'var(--card-bg)'); ?>; border:1px solid <?php echo e($selectedDepartment === '' ? 'rgba(29,78,216,.2)' : 'var(--border)'); ?>;">
                    All departments
                </a>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e(route('sias.admin.reports', ['department' => $department])); ?>"
                       style="padding:.8rem .9rem; border-radius:10px; text-decoration:none; font-weight:600; color:<?php echo e($selectedDepartment === $department ? 'var(--accent-strong)' : 'var(--text)'); ?>; background:<?php echo e($selectedDepartment === $department ? 'rgba(29,78,216,.08)' : 'var(--card-bg)'); ?>; border:1px solid <?php echo e($selectedDepartment === $department ? 'rgba(29,78,216,.2)' : 'var(--border)'); ?>;">
                        <?php echo e($department); ?>

                    </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </aside>

        <section class="admin-card" style="padding:1.25rem;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeCourse): ?>
                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
                    <div>
                        <p style="margin:0 0 .35rem; font-size:.75rem; text-transform:uppercase; letter-spacing:.08em; color:var(--text-muted);">Current course</p>
                        <h3 style="margin:0; font-size:1.5rem;"><?php echo e($activeCourse->title); ?></h3>
                        <p style="margin:.35rem 0 0; color:var(--text-muted);">
                            <?php echo e($activeCourse->department ?? $activeCourse->category ?? 'General'); ?> ·
                            <?php echo e($activeCourse->enrollments_count ?? 0); ?> enrolled students
                        </p>
                    </div>
                    <a href="<?php echo e(route('sias.admin.course.edit', $activeCourse->id)); ?>" class="btn btn-secondary" style="display:inline-flex;align-items:center;gap:.5rem;">
                        <i class="fa-solid fa-pen"></i>
                        Edit course
                    </a>
                </div>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:1rem; margin-bottom:1.25rem;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <a href="<?php echo e(route('sias.admin.reports', ['department' => $selectedDepartment ?: ($course->department ?? $course->category ?? 'General'), 'course_id' => $course->id])); ?>"
                           style="display:block; text-decoration:none; padding:1rem; border-radius:12px; border:1px solid <?php echo e($activeCourse->id === $course->id ? 'rgba(29,78,216,.3)' : 'var(--border)'); ?>; background:<?php echo e($activeCourse->id === $course->id ? 'rgba(29,78,216,.08)' : 'var(--card-bg)'); ?>; color:var(--text); transition:transform .2s ease;">
                            <p style="margin:0 0 .35rem; font-size:.75rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:.08em;"><?php echo e($course->department ?? $course->category ?? 'General'); ?></p>
                            <strong style="display:block; margin-bottom:.25rem; font-size:1rem;"><?php echo e($course->title); ?></strong>
                            <span style="color:var(--text-muted); font-size:.85rem;"><?php echo e($course->enrollments_count ?? 0); ?> students</span>
                        </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                <div style="border-top:1px solid var(--border); padding-top:1rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1rem;">
                        <h3 style="margin:0; font-size:1.1rem;">Subjects for this course</h3>
                        <a href="<?php echo e(route('sias.admin.subject.add')); ?>" class="btn" style="display:inline-flex;align-items:center;gap:.5rem;">
                            <i class="fa-solid fa-plus"></i>
                            Add subject
                        </a>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subjects->isEmpty()): ?>
                        <div style="padding:2rem 1rem; border:1px dashed var(--border); border-radius:12px; text-align:center; color:var(--text-muted);">
                            <i class="fa-solid fa-inbox" style="font-size:2rem; display:block; margin-bottom:.5rem; opacity:.5;"></i>
                            No subjects are linked to this course yet.
                        </div>
                    <?php else: ?>
                        <div style="display:grid; gap:.75rem;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; padding:.9rem 1rem; border:1px solid var(--border); border-radius:12px; background:rgba(148,163,184,.03);">
                                    <div>
                                        <div style="font-weight:700;"><?php echo e($subject->title); ?></div>
                                        <div style="font-size:.85rem; color:var(--text-muted); margin-top:.2rem;">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($subject->code)): ?>
                                                <?php echo e($subject->code); ?> ·
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php echo e($subject->teacher?->name ?? 'No assigned teacher'); ?>

                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:.5rem;">
                                        <a href="<?php echo e(route('sias.admin.subject.edit', $subject->id)); ?>" class="btn btn-secondary" style="padding:.6rem .9rem; font-size:.85rem;">
                                            Edit
                                        </a>
                                        <form method="POST" action="<?php echo e(route('sias.admin.subject.delete', $subject->id)); ?>" onsubmit="return confirm('Delete this subject?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-secondary" style="padding:.6rem .9rem; font-size:.85rem; border-color:rgba(239,68,68,.25); color:#dc2626;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php else: ?>
                <div style="padding:3rem 1rem; border:1px dashed var(--border); border-radius:12px; text-align:center; color:var(--text-muted);">
                    <i class="fa-solid fa-chart-simple" style="font-size:2.5rem; display:block; margin-bottom:.75rem; opacity:.6;"></i>
                    No course is available for this department yet.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </section>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\reports\index.blade.php ENDPATH**/ ?>