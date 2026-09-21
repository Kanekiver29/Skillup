

<?php $__env->startSection('title', isset($course) ? 'Edit Course' : 'Create Course'); ?>
<?php $__env->startSection('page_title', isset($course) ? 'Edit Course' : 'Create New Course'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: #333;
        font-size: 15px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: inherit;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .help-text {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }

    .error {
        color: #ff6b6b;
        font-size: 12px;
        margin-top: 5px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .header-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }

    .header-section h2 {
        margin: 0 0 10px 0;
        color: #333;
    }

    .header-section p {
        margin: 0;
        color: #999;
        font-size: 14px;
    }
</style>

<div class="form-container">
    <div class="header-section">
        <h2><?php echo e(isset($course) ? 'Edit Course' : 'Create New Course'); ?></h2>
        <p><?php echo e(isset($course) ? 'Update your course details below.' : 'Fill in the details to create a new course.'); ?></p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(isset($course) ? route('sias.teacher.profile.update-course', $course) : route('sias.teacher.profile.store-course')); ?>">
        <?php echo csrf_field(); ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($course)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Basic Information -->
        <h3 style="color: #333; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
            <i class="fas fa-info-circle"></i> Basic Information
        </h3>

        <div class="form-group">
            <label for="title">Course Title *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="<?php echo e($course->title ?? old('title')); ?>" 
                required 
                placeholder="Enter course title">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea 
                id="short_description" 
                name="short_description" 
                placeholder="Brief course summary (shown in listings)"><?php echo e($course->short_description ?? old('short_description')); ?></textarea>
            <div class="help-text">Shown in course listings and previews</div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="description">Full Description</label>
            <textarea 
                id="description" 
                name="description" 
                placeholder="Detailed course description"><?php echo e($course->description ?? old('description')); ?></textarea>
            <div class="help-text">Shown on the course details page</div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Course Details -->
        <h3 style="color: #333; margin-bottom: 20px; margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
            <i class="fas fa-cog"></i> Course Details
        </h3>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Category</label>
                <input 
                    type="text" 
                    id="category" 
                    name="category" 
                    value="<?php echo e($course->category ?? old('category')); ?>" 
                    placeholder="e.g., Web Development">
                <div class="help-text">Subject or topic area</div>
            </div>

            <div class="form-group">
                <label for="level">Level *</label>
                <select id="level" name="level" required>
                    <option value="">-- Select Level --</option>
                    <option value="Beginner" <?php echo e((isset($course) && $course->level === 'Beginner') || old('level') === 'Beginner' ? 'selected' : ''); ?>>
                        Beginner
                    </option>
                    <option value="Intermediate" <?php echo e((isset($course) && $course->level === 'Intermediate') || old('level') === 'Intermediate' ? 'selected' : ''); ?>>
                        Intermediate
                    </option>
                    <option value="Advanced" <?php echo e((isset($course) && $course->level === 'Advanced') || old('level') === 'Advanced' ? 'selected' : ''); ?>>
                        Advanced
                    </option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="duration_hours">Duration (hours)</label>
                <input 
                    type="number" 
                    id="duration_hours" 
                    name="duration_hours" 
                    value="<?php echo e($course->duration_hours ?? old('duration_hours')); ?>" 
                    min="0" 
                    placeholder="e.g., 40">
            </div>

            <div class="form-group">
                <label for="image_url">Course Image URL</label>
                <input 
                    type="url" 
                    id="image_url" 
                    name="image_url" 
                    value="<?php echo e($course->image_url ?? old('image_url')); ?>" 
                    placeholder="https://example.com/image.jpg">
                <div class="help-text">Full URL to course thumbnail image</div>
            </div>
        </div>

        <!-- Publish Status -->
        <h3 style="color: #333; margin-bottom: 20px; margin-top: 30px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
            <i class="fas fa-share"></i> Publishing
        </h3>

        <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
            <input 
                type="checkbox" 
                id="is_published" 
                name="is_published" 
                value="1" 
                <?php echo e((isset($course) && $course->is_published) || old('is_published') ? 'checked' : ''); ?>

                style="width: auto; cursor: pointer;">
            <label for="is_published" style="margin: 0; cursor: pointer;">
                Publish this course immediately
            </label>
            <div class="help-text" style="margin-left: 30px;">
                Uncheck to save as draft
            </div>
        </div>

        <!-- Form Actions -->
        <div class="btn-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> <?php echo e(isset($course) ? 'Update Course' : 'Create Course'); ?>

            </button>
            <a href="<?php echo e(route('sias.teacher.profile')); ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.teacher.layout.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\teacher\profile\create-course.blade.php ENDPATH**/ ?>