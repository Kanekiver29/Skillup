<?php $__env->startSection('title', isset($course) ? 'Edit Course' : 'Create Course'); ?>
<?php $__env->startSection('page_title', isset($course) ? 'Edit Course' : 'New Course'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .form-container {
        max-width: 840px;
        margin: 0 auto;
    }
    .form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .form-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--navy-950);
    }
    .btn-back {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--navy-800);
        font-weight: 700;
        padding: 0.6rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
    }
    .form-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        box-shadow: var(--shadow-card);
    }
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.25rem;
    }
    .form-group {
        margin-bottom: 1.4rem;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--navy-950);
        margin-bottom: 0.45rem;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface-2);
        color: var(--text);
        font-family: inherit;
        font-size: 0.92rem;
    }
    .form-control:focus {
        border-color: var(--accent-2);
        outline: none;
        background: #fff;
    }
    .btn-submit {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.8rem 1.6rem;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
    }
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 1rem;
        border-top: 1px solid var(--border-soft);
        padding-top: 1.5rem;
        margin-top: 1.5rem;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <div>
            <h1>🎓 <?php echo e(isset($course) ? 'Edit Course' : 'Create New Course'); ?></h1>
            <p style="color:var(--muted); font-size:0.9rem; margin-top:0.25rem;">Fill out course details to publish to the student platform.</p>
        </div>
        <a href="<?php echo e(route('teacher.courses.index')); ?>" class="btn-back">← Back to Courses</a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #b91c1c; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <ul>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="form-card">
        <form method="POST" action="<?php echo e(isset($course) ? route('teacher.courses.update', $course->id) : route('teacher.courses.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($course)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="form-group">
                <label for="title">Course Title <span style="color:var(--danger)">*</span></label>
                <input type="text" id="title" name="title" value="<?php echo e(old('title', $course->title ?? '')); ?>" class="form-control" placeholder="e.g., Full-Stack Web Development Bootcamp" required>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" value="<?php echo e(old('category', $course->category ?? 'Information Technology')); ?>" class="form-control" placeholder="e.g., Web Development, IT">
                </div>

                <div class="form-group">
                    <label for="level">Skill Level</label>
                    <select id="level" name="level" class="form-control">
                        <option value="Beginner" <?php echo e(old('level', $course->level ?? '') == 'Beginner' ? 'selected' : ''); ?>>Beginner</option>
                        <option value="Intermediate" <?php echo e(old('level', $course->level ?? '') == 'Intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                        <option value="Advanced" <?php echo e(old('level', $course->level ?? '') == 'Advanced' ? 'selected' : ''); ?>>Advanced</option>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="duration_hours">Estimated Duration (Hours)</label>
                    <input type="number" id="duration_hours" name="duration_hours" value="<?php echo e(old('duration_hours', $course->duration_hours ?? 40)); ?>" min="0" class="form-control">
                </div>

                <div class="form-group">
                    <label for="is_published">Publishing Status</label>
                    <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.6rem;">
                        <input type="checkbox" id="is_published" name="is_published" value="1" <?php echo e(old('is_published', $course->is_published ?? true) ? 'checked' : ''); ?> style="width:18px; height:18px; accent-color:var(--accent);">
                        <label for="is_published" style="margin:0; font-weight:600; cursor:pointer;">Publish Course Immediately</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="short_description">Short Summary</label>
                <input type="text" id="short_description" name="short_description" value="<?php echo e(old('short_description', $course->short_description ?? '')); ?>" class="form-control" placeholder="Brief 1-2 sentence overview for course cards...">
            </div>

            <div class="form-group">
                <label for="description">Full Description</label>
                <textarea id="description" name="description" rows="5" class="form-control" placeholder="Detailed syllabus, course objectives, and requirements..."><?php echo e(old('description', $course->description ?? '')); ?></textarea>
            </div>

            <div class="form-footer">
                <a href="<?php echo e(route('teacher.courses.index')); ?>" class="btn-back">Cancel</a>
                <button type="submit" class="btn-submit">
                    <?php echo e(isset($course) ? 'Update Course' : 'Save & Create Course'); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\courses\create.blade.php ENDPATH**/ ?>