<?php $__env->startSection('title', 'My Courses'); ?>
<?php $__env->startSection('page_title', 'Course Directory'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .crs-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .crs-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--navy-950);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .btn-create {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.75rem 1.4rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 18px var(--accent-glow);
        transition: all 0.25s var(--ease);
    }
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px var(--accent-glow);
        color: #fff;
    }

    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }
    .course-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s var(--ease);
    }
    .course-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-card-hover);
        border-color: var(--navy-200);
    }
    .crs-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .level-badge {
        font-size: 0.72rem;
        font-weight: 800;
        background: var(--navy-50);
        color: var(--navy-800);
        padding: 0.2rem 0.6rem;
        border-radius: var(--radius-sm);
        text-transform: uppercase;
    }
    .status-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 99px;
    }
    .status-badge.published {
        background: rgba(34, 197, 94, 0.12);
        color: #16a34a;
    }
    .status-badge.draft {
        background: rgba(234, 179, 8, 0.12);
        color: #ca8a04;
    }
    .crs-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--navy-950);
        margin-bottom: 0.4rem;
        line-height: 1.35;
    }
    .crs-desc {
        font-size: 0.88rem;
        color: var(--muted);
        line-height: 1.5;
        margin-bottom: 1.25rem;
    }
    .crs-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.82rem;
        color: var(--text-2);
        border-top: 1px solid var(--border-soft);
        padding-top: 0.85rem;
        margin-bottom: 1.25rem;
    }
    .crs-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .action-btn {
        flex: 1;
        padding: 0.55rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.82rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.2s var(--ease);
    }
    .btn-edit {
        background: var(--navy-50);
        color: var(--navy-800);
        border: 1px solid var(--navy-100);
    }
    .btn-edit:hover {
        background: var(--accent);
        color: #fff;
    }
    .btn-modules {
        background: var(--accent);
        color: #fff;
    }
    .btn-modules:hover {
        background: var(--navy-600);
    }
    .empty-card {
        background: var(--surface);
        border: 2px dashed var(--border);
        border-radius: var(--radius-xl);
        padding: 4rem 2rem;
        text-align: center;
        grid-column: 1 / -1;
    }
</style>

<div class="crs-header">
    <div>
        <h1>🎓 My Courses</h1>
        <p style="color:var(--muted); font-size:0.92rem; margin-top:0.25rem;">Create, manage, and publish your course curriculum for students.</p>
    </div>
    <a href="<?php echo e(route('teacher.courses.create')); ?>" class="btn-create">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Create New Course
    </a>
</div>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #15803d; padding: 0.9rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<div class="course-grid">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="course-card">
            <div>
                <div class="crs-top">
                    <span class="level-badge"><?php echo e($course->level ?: 'Beginner'); ?></span>
                    <span class="status-badge <?php echo e($course->is_published ? 'published' : 'draft'); ?>">
                        <?php echo e($course->is_published ? 'Published' : 'Draft'); ?>

                    </span>
                </div>
                <h3 class="crs-title"><?php echo e($course->title); ?></h3>
                <p class="crs-desc"><?php echo e(Str::limit($course->short_description ?: $course->description, 100)); ?></p>

                <div class="crs-meta">
                    <div>📂 <?php echo e($course->modules()->count()); ?> Modules</div>
                    <div>📖 <?php echo e($course->lessons()->count()); ?> Lessons</div>
                    <div>⏱️ <?php echo e($course->duration_hours ?: 0); ?> hrs</div>
                </div>
            </div>

            <div class="crs-actions">
                <a href="<?php echo e(route('teacher.modules.index', ['course_id' => $course->id])); ?>" class="action-btn btn-modules">
                    📂 Modules
                </a>
                <a href="<?php echo e(route('teacher.courses.edit', $course->id)); ?>" class="action-btn btn-edit">
                    ✏️ Edit
                </a>
            </div>
        </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <div class="empty-card">
            <div style="font-size:3rem; margin-bottom:1rem;">🎓</div>
            <h3 style="font-size:1.3rem; font-weight:700; color:var(--navy-950); margin-bottom:0.5rem;">No Courses Found</h3>
            <p style="color:var(--muted); max-width:460px; margin:0 auto 1.5rem;">Create your first course to begin adding modules, subjects, and lessons.</p>
            <a href="<?php echo e(route('teacher.courses.create')); ?>" class="btn-create">
                + Create Your First Course
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\courses\index.blade.php ENDPATH**/ ?>