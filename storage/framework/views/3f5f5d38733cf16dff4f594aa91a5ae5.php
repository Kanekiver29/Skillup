

<?php $__env->startSection('title', 'Add Subject'); ?>
<?php $__env->startSection('page_title', 'Add New Subject'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="padding:1.5rem;">
    <div style="margin-bottom:2rem;">
        <h2 style="margin:0 0 .5rem;font-size:2rem;letter-spacing:-.02em;" data-i18n="create_new_subject">Create New Subject</h2>
        <p style="margin:0;color:var(--text-muted);" data-i18n="add_new_subject_curriculum">Add a new subject to the course curriculum</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div style="display:flex;align-items:flex-start;gap:.75rem;padding:1rem 1.25rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:12px;margin-bottom:1.5rem;color:#dc2626;">
            <i class="fa-solid fa-exclamation-circle" style="font-size:1.2rem;margin-top:.25rem;flex-shrink:0;"></i>
            <div>
                <strong data-i18n="error">Error</strong>
                <ul style="margin:.5rem 0 0;padding-left:1.5rem;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($error); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('sias.admin.subject.store')); ?>" class="section-card" style="display:grid;gap:1.5rem;max-width:800px;">
        <?php echo csrf_field(); ?>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-book" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span data-i18n="subject_information">Subject Information</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);">
                        <span data-i18n="select_course">Select Course</span> <span style="color:#dc2626;">*</span>
                    </label>
                    <select name="course_id" class="form-input" required>
                        <option value="" data-i18n="choose_course">Choose a course</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?> (<?php echo e($course->code); ?>)</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);">
                        <span data-i18n="subject_title">Subject Title</span> <span style="color:#dc2626;">*</span>
                    </label>
                    <input name="title" type="text" class="form-input" placeholder="" data-i18n-placeholder="e_g_introduction_programming" value="<?php echo e(old('title')); ?>" required>
                </div>

                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            <span data-i18n="subject_code">Subject Code</span> <span style="color:#dc2626;">*</span>
                        </label>
                        <input name="code" type="text" class="form-input" placeholder="" data-i18n-placeholder="e_g_cs101" value="<?php echo e(old('code')); ?>" required>
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            <span data-i18n="credit_units">Credit Units</span> <span style="color:#dc2626;">*</span>
                        </label>
                        <input name="units" type="number" class="form-input" placeholder="" data-i18n-placeholder="e_g_3" min="1" max="6" value="<?php echo e(old('units', 3)); ?>" required>
                    </div>
                </div>

                <div style="display:grid;gap:.35rem;">
                    <label style="font-weight:600;color:var(--text);" data-i18n="description">Description</label>
                    <textarea name="description" rows="4" class="form-input" placeholder="" data-i18n-placeholder="subject_description_objectives"><?php echo e(old('description')); ?></textarea>
                </div>
            </div>
        </details>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-graduation-cap" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Curriculum Details</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            Year Level <span style="color:#dc2626;">*</span>
                        </label>
                        <select name="year_level" class="form-input" required>
                            <option value="">Select Year</option>
                            <option value="1" <?php echo e(old('year_level') == 1 ? 'selected' : ''); ?>>1st Year</option>
                            <option value="2" <?php echo e(old('year_level') == 2 ? 'selected' : ''); ?>>2nd Year</option>
                            <option value="3" <?php echo e(old('year_level') == 3 ? 'selected' : ''); ?>>3rd Year</option>
                            <option value="4" <?php echo e(old('year_level') == 4 ? 'selected' : ''); ?>>4th Year</option>
                        </select>
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Semester</label>
                        <select name="semester" class="form-input">
                            <option value="">Select Semester</option>
                            <option value="1" <?php echo e(old('semester') == 1 ? 'selected' : ''); ?>>1st Semester</option>
                            <option value="2" <?php echo e(old('semester') == 2 ? 'selected' : ''); ?>>2nd Semester</option>
                            <option value="3" <?php echo e(old('semester') == 3 ? 'selected' : ''); ?>>Summer</option>
                        </select>
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Lecture Hours</label>
                        <input name="lecture_hours" type="number" class="form-input" placeholder="e.g. 3" min="0" value="<?php echo e(old('lecture_hours', 3)); ?>">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">Lab Hours</label>
                        <input name="lab_hours" type="number" class="form-input" placeholder="e.g. 2" min="0" value="<?php echo e(old('lab_hours', 0)); ?>">
                    </div>
                    <div style="display:grid;gap:.35rem;">
                        <label style="font-weight:600;color:var(--text);">
                            <input type="checkbox" name="is_required" value="1" <?php echo e(old('is_required') ? 'checked' : ''); ?> style="width:1rem;height:1rem;margin-right:.5rem;cursor:pointer;">
                            Required Subject
                        </label>
                    </div>
                </div>
            </div>
        </details>

        <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
            <a href="<?php echo e(route('sias.admin.subject')); ?>" class="btn-white">Cancel</a>
            <button type="submit" class="btn-black">Create Subject</button>
        </div>
    </form>
</div>

<style>
    .form-section-toggle { list-style: none; }
    .form-section-toggle summary { list-style: none; outline: none; }
    .form-section-toggle summary::-webkit-details-marker { display: none; }
    .form-section-toggle[open] summary { background: var(--block-bg-hover) !important; border-color: var(--accent-strong) !important; }
    .form-section-toggle[open] summary i:last-child { transform: rotate(180deg); }
    .form-section-toggle summary:hover { background: var(--block-bg-hover) !important; border-color: var(--accent-strong) !important; }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\course\subject\add.blade.php ENDPATH**/ ?>