

<?php $__env->startSection('title', 'Lessons'); ?>
<?php $__env->startSection('page_title', 'Lessons'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .lessons-page { max-width: 1200px; margin: 0 auto; padding: 2rem 1.25rem 3rem; color: #17233f; }
    .lessons-heading { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .lessons-heading h1 { margin: 0; color: #0b1730; font-size: 2rem; font-weight: 800; }
    .lessons-heading p { margin: .35rem 0 0; color: #64748b; }
    .new-lesson { background: #315bd6; color: #fff; border-radius: 8px; padding: .75rem 1rem; text-decoration: none; font-weight: 800; }
    .lessons-card { overflow: hidden; background: #fff; border: 1px solid #dfe7f5; border-radius: 14px; box-shadow: 0 12px 30px rgba(25, 48, 92, .08); }
    .lessons-table { width: 100%; border-collapse: collapse; }
    .lessons-table th { background: #f5f8fd; color: #52627c; font-size: .75rem; letter-spacing: .05em; text-align: left; text-transform: uppercase; padding: 1rem 1.25rem; }
    .lessons-table td { border-top: 1px solid #e8eef7; padding: 1rem 1.25rem; vertical-align: middle; }
    .lesson-title { color: #0b1730; font-weight: 800; }
    .lesson-course { color: #718198; font-size: .8rem; margin-top: .25rem; }
    .status, .media-tag { display: inline-block; border-radius: 999px; padding: .3rem .6rem; font-size: .75rem; font-weight: 800; }
    .published { background: #dcfce7; color: #15803d; }
    .draft { background: #fef3c7; color: #a16207; }
    .media-tag { margin: .15rem; background: #eef4ff; color: #315bd6; }
    .lesson-links { display: flex; justify-content: flex-end; gap: .75rem; flex-wrap: wrap; }
    .lesson-links a, .lesson-links button { color: #315bd6; background: none; border: 0; padding: 0; font: inherit; font-weight: 700; text-decoration: none; cursor: pointer; }
    .lesson-links .danger { color: #dc2626; }
    .empty-lessons { padding: 3rem 1rem; text-align: center; color: #64748b; }
    .empty-lessons a { color: #315bd6; font-weight: 700; }
    @media (max-width: 720px) { .lessons-table th:nth-child(2), .lessons-table td:nth-child(2) { display: none; } .lessons-table th, .lessons-table td { padding: .8rem .65rem; } .lesson-links { justify-content: flex-start; } }
</style>

<div class="lessons-page">
    <div class="lessons-heading">
        <div>
            <h1>Lessons</h1>
            <p>Manage course lessons and learning materials.</p>
        </div>
        <a href="<?php echo e(route('teacher.lessons.create')); ?>" class="new-lesson">+ New Lesson</a>
    </div>

    <div class="lessons-card">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loop->first): ?>
                <table class="lessons-table"><thead><tr><th>Lesson</th><th>Module / Course</th><th>Content</th><th>Status</th><th>Actions</th></tr></thead><tbody>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <tr>
                <td><div class="lesson-title"><?php echo e($lesson->title); ?></div><div class="lesson-course"><?php echo e($lesson->duration_minutes ?: 0); ?> minutes</div></td>
                <td><?php echo e($lesson->module?->title ?: 'Unassigned'); ?><div class="lesson-course"><?php echo e($lesson->module?->course?->title ?: 'No course'); ?></div></td>
                <td>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->content): ?><span class="media-tag">Text</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->image_url): ?><span class="media-tag">Image</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->video_url): ?><span class="media-tag">Video</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->material_url): ?><span class="media-tag">File</span><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td><span class="status <?php echo e($lesson->is_published ? 'published' : 'draft'); ?>"><?php echo e($lesson->is_published ? 'Published' : 'Draft'); ?></span></td>
                <td><div class="lesson-links">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lesson->slug && $lesson->module?->course?->slug && $lesson->module?->slug): ?><a href="<?php echo e(route('lessons.show', [$lesson->module->course->slug, $lesson->module->slug, $lesson->slug])); ?>" target="_blank">Student View</a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <a href="<?php echo e(route('teacher.lessons.edit', $lesson->id)); ?>">Edit</a>
                    <form method="POST" action="<?php echo e(route('teacher.lessons.destroy', $lesson->id)); ?>" onsubmit="return confirm('Delete this lesson?');"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="danger" type="submit">Delete</button></form>
                </div></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loop->last): ?></tbody></table><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="empty-lessons"><strong>No lessons found yet.</strong><br><a href="<?php echo e(route('teacher.lessons.create')); ?>">Create the first lesson</a></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\lesson\index.blade.php ENDPATH**/ ?>