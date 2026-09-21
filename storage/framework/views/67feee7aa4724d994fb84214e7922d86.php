

<?php $__env->startSection('title', $course->title); ?>
<?php $__env->startSection('page_title', 'Course Details'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .course-detail { max-width: 1100px; margin: 0 auto; color: #101a33; }
    .course-detail-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem; }
    .course-detail-header h1 { margin: 0; font-size: clamp(1.6rem, 3vw, 2.35rem); line-height: 1.1; }
    .course-detail-header p { margin: .55rem 0 0; color: #71809b; line-height: 1.6; }
    .course-detail-actions { display: flex; gap: .55rem; flex-wrap: wrap; }
    .course-detail-actions a { display: inline-flex; align-items: center; gap: .4rem; padding: .65rem .85rem; border-radius: .55rem; font-size: .78rem; font-weight: 800; }
    .course-detail-actions .primary { background: #2f5be7; color: #fff; }
    .course-detail-actions .secondary { border: 1px solid #e5eaf5; color: #52627e; background: #fff; }
    .course-detail-grid { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(240px, .8fr); gap: .9rem; }
    .course-detail-panel { background: #fff; border: 1px solid #e5eaf5; border-radius: .85rem; padding: 1.15rem; box-shadow: 0 8px 22px rgba(25, 46, 94, .04); }
    .course-detail-panel h2 { margin: 0 0 .85rem; font-size: .95rem; }
    .course-detail-panel p { color: #52627e; line-height: 1.7; white-space: pre-line; }
    .course-meta { display: grid; grid-template-columns: repeat(2, 1fr); gap: .6rem; }
    .course-meta div { background: #f8faff; border-radius: .6rem; padding: .7rem; }
    .course-meta strong { display: block; font-size: 1.05rem; }
    .course-meta span { color: #71809b; font-size: .7rem; }
    .module-list { list-style: none; padding: 0; margin: 0; display: grid; gap: .55rem; }
    .module-list li { display: flex; align-items: center; justify-content: space-between; gap: 1rem; border-bottom: 1px solid #f0f2f8; padding: .55rem 0; }
    .module-list li:last-child { border-bottom: 0; }
    .module-list strong { font-size: .8rem; }
    .module-list span { color: #71809b; font-size: .7rem; white-space: nowrap; }
    .empty-detail { color: #71809b; font-size: .82rem; }
    @media (max-width: 720px) { .course-detail-header, .course-detail-grid { display: block; } .course-detail-actions { margin-top: 1rem; } .course-detail-panel + .course-detail-panel { margin-top: .9rem; } }
</style>

<div class="course-detail">
    <div class="course-detail-header">
        <div>
            <h1><?php echo e($course->title); ?></h1>
            <p><?php echo e($course->short_description ?: 'Course program details and curriculum.'); ?></p>
        </div>
        <div class="course-detail-actions">
            <a class="secondary" href="<?php echo e(route('teacher.courses.index')); ?>">Back to courses</a>
            <a class="primary" href="<?php echo e(route('teacher.courses.edit', $course)); ?>">Edit course</a>
        </div>
    </div>

    <div class="course-detail-grid">
        <div class="course-detail-panel">
            <h2>About this program</h2>
            <p><?php echo e($course->description ?: $course->short_description ?: 'No description provided.'); ?></p>

            <h2 style="margin-top: 1.35rem;">Modules</h2>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->modules->isNotEmpty()): ?>
                <ul class="module-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $course->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li>
                            <strong><?php echo e($module->title ?? $module->name ?? 'Untitled module'); ?></strong>
                            <span><?php echo e($module->lessons->count()); ?> <?php echo e(\Illuminate\Support\Str::plural('lesson', $module->lessons->count())); ?></span>
                        </li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            <?php else: ?>
                <p class="empty-detail">No modules have been added yet.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <aside class="course-detail-panel">
            <h2>Program overview</h2>
            <div class="course-meta">
                <div><strong><?php echo e($course->modules->count()); ?></strong><span>Modules</span></div>
                <div><strong><?php echo e($course->modules->sum(fn ($module) => $module->lessons->count())); ?></strong><span>Lessons</span></div>
                <div><strong><?php echo e($course->duration_hours ?: 0); ?></strong><span>Hours</span></div>
                <div><strong><?php echo e($course->level ?: 'Beginner'); ?></strong><span>Level</span></div>
            </div>
            <p style="margin-bottom: 0;">Status: <strong><?php echo e($course->is_published ? 'Published' : 'Draft'); ?></strong></p>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\courses\show.blade.php ENDPATH**/ ?>