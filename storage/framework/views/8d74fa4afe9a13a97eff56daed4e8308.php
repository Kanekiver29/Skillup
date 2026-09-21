<?php $__env->startSection('title', 'Upload Learning Resource'); ?>
<?php $__env->startSection('page_title', 'Upload Resource'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .upload-container {
        max-width: 840px;
        margin: 0 auto;
    }
    .page-header-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .page-header-box h1 {
        font-size: 1.65rem;
        font-weight: 800;
        color: var(--navy-950);
        display: flex;
        align-items: center;
        gap: 0.6rem;
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
        transition: all 0.2s var(--ease);
    }
    .btn-back:hover {
        background: var(--navy-50);
        color: var(--navy-950);
        border-color: var(--navy-200);
    }

    .type-switcher {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
    }
    .type-tab {
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-2);
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.6rem 1.1rem;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: all 0.2s var(--ease);
    }
    .type-tab.active {
        background: var(--navy-950);
        color: #fff;
        border-color: var(--navy-950);
        box-shadow: 0 4px 14px rgba(5, 7, 15, 0.2);
    }
    .type-tab:hover:not(.active) {
        background: var(--navy-50);
        color: var(--navy-950);
    }

    .upload-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 2.25rem;
        box-shadow: var(--shadow-card);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--navy-950);
        margin-bottom: 0.45rem;
    }
    .form-group label span.req {
        color: var(--danger);
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
        transition: all 0.2s var(--ease);
    }
    .form-control:focus {
        border-color: var(--accent-2);
        box-shadow: 0 0 0 3.5px var(--accent-muted);
        outline: none;
        background: #fff;
    }
    .form-hint {
        font-size: 0.78rem;
        color: var(--muted);
        margin-top: 0.35rem;
    }

    .file-dropzone {
        border: 2px dashed var(--navy-200);
        border-radius: var(--radius-lg);
        padding: 2.5rem 1.5rem;
        text-align: center;
        background: var(--surface-2);
        transition: all 0.25s var(--ease);
        cursor: pointer;
        position: relative;
    }
    .file-dropzone:hover {
        border-color: var(--accent);
        background: var(--navy-50);
    }
    .file-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .dropzone-icon {
        font-size: 2.8rem;
        margin-bottom: 0.75rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 100%);
        color: #fff;
        font-weight: 700;
        padding: 0.8rem 1.6rem;
        border-radius: var(--radius-md);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 18px var(--accent-glow);
        transition: all 0.25s var(--ease);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px var(--accent-glow);
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

<?php
    $type = $resourceType ?? request()->query('type', 'pdf');
    $typeLabels = [
        'pdf' => ['title' => 'PDF Document', 'icon' => '📄', 'accept' => '.pdf', 'hint' => 'Upload PDF materials (max 10MB)'],
        'video' => ['title' => 'Video Lecture', 'icon' => '🎥', 'accept' => 'video/mp4,video/quicktime,video/x-msvideo,video/x-matroska', 'hint' => 'Upload MP4 or MOV video (max 100MB)'],
        'word' => ['title' => 'Word Document', 'icon' => '📝', 'accept' => '.doc,.docx', 'hint' => 'Upload Microsoft Word document (max 20MB)'],
        'ppt' => ['title' => 'Presentation (PPT)', 'icon' => '📊', 'accept' => '.ppt,.pptx', 'hint' => 'Upload PowerPoint presentation (max 20MB)'],
        'image' => ['title' => 'Image Graphic', 'icon' => '🖼️', 'accept' => 'image/*', 'hint' => 'Upload PNG, JPG or SVG diagram (max 10MB)'],
    ];
    $currentType = $typeLabels[$type] ?? $typeLabels['pdf'];
?>

<div class="upload-container">
    <div class="page-header-box">
        <div>
            <h1><?php echo e($currentType['icon']); ?> Upload <?php echo e($currentType['title']); ?></h1>
            <p style="color:var(--muted); font-size:0.9rem; margin-top:0.25rem;">Attach course materials and media resources directly to your modules.</p>
        </div>
        <a href="<?php echo e(route('teacher.modules.index')); ?>" class="btn-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Modules
        </a>
    </div>

    
    <div class="type-switcher">
        <a href="<?php echo e(route('teacher.modules.upload-resource')); ?>?type=pdf" class="type-tab <?php echo e($type === 'pdf' ? 'active' : ''); ?>">📄 PDF Document</a>
        <a href="<?php echo e(route('teacher.modules.upload-resource')); ?>?type=video" class="type-tab <?php echo e($type === 'video' ? 'active' : ''); ?>">🎥 Video Lecture</a>
        <a href="<?php echo e(route('teacher.modules.upload-resource')); ?>?type=word" class="type-tab <?php echo e($type === 'word' ? 'active' : ''); ?>">📝 Word Document</a>
        <a href="<?php echo e(route('teacher.modules.upload-resource')); ?>?type=ppt" class="type-tab <?php echo e($type === 'ppt' ? 'active' : ''); ?>">📊 Presentation (PPT)</a>
        <a href="<?php echo e(route('teacher.modules.upload-resource')); ?>?type=image" class="type-tab <?php echo e($type === 'image' ? 'active' : ''); ?>">🖼️ Image Graphic</a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #15803d; padding: 0.9rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 0.6rem; font-weight: 600;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <?php echo e(session('success')); ?>

            </div>
            <button onclick="this.parentElement.remove()" style="background:none; border:none; color:currentColor; cursor:pointer; font-size:1.1rem;">&times;</button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #b91c1c; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <strong style="display:block; margin-bottom:0.4rem;">Please fix the errors below:</strong>
            <ul style="padding-left: 1.2rem; font-size: 0.88rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="upload-card">
        <form method="POST" action="<?php echo e(route('teacher.modules.upload-resource.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="resource_type" value="<?php echo e($type); ?>">

            <div class="form-group">
                <label for="course_id">Target Course</label>
                <select id="course_id" name="course_id" class="form-control" onchange="filterModulesByCourse(this.value)">
                    <option value="">-- Choose Course --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($c->id); ?>" <?php echo e(old('course_id', request('course_id')) == $c->id ? 'selected' : ''); ?>>
                            <?php echo e($c->title); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <div class="form-hint">Select the course this resource belongs to.</div>
            </div>

            <div class="form-group">
                <label for="module_id">Target Module <span class="req">*</span></label>
                <select id="module_id" name="module_id" class="form-control">
                    <option value="">-- Choose Module --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($m->id); ?>" data-course-id="<?php echo e($m->course_id); ?>" <?php echo e(old('module_id', request('module_id')) == $m->id ? 'selected' : ''); ?>>
                            <?php echo e($m->title); ?> (Course: <?php echo e($m->course?->title); ?>)
                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <div class="form-hint">Required: attaching to a module makes this resource available to its students.</div>
            </div>

            <div class="form-group">
                <label>Select File <span class="req">*</span></label>
                <div class="file-dropzone" onclick="document.getElementById('resource_file').click()">
                    <div class="dropzone-icon"><?php echo e($currentType['icon']); ?></div>
                    <div style="font-weight:700; font-size:1.05rem; color:var(--navy-950); margin-bottom:0.25rem;">
                        Click or drag file here to upload
                    </div>
                    <div style="font-size:0.84rem; color:var(--muted);" id="file-name-display">
                        <?php echo e($currentType['hint']); ?>

                    </div>
                    <input type="file" id="resource_file" name="resource_file" accept="<?php echo e($currentType['accept']); ?>" required onchange="showSelectedFile(this)">
                </div>
            </div>

            <div class="form-footer">
                <a href="<?php echo e(route('teacher.modules.index')); ?>" class="btn-back">Cancel</a>
                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Upload & Save Resource
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showSelectedFile(input) {
        const display = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            display.innerHTML = `<span style="color:var(--accent); font-weight:700;">Selected: ${file.name}</span> (${sizeMb} MB)`;
        }
    }

    function filterModulesByCourse(courseId) {
        const moduleSelect = document.getElementById('module_id');
        const options = moduleSelect.querySelectorAll('option');
        options.forEach(opt => {
            if (!opt.value) return;
            const cId = opt.getAttribute('data-course-id');
            if (!courseId || cId == courseId) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\SUBJECT\modules\upload-resource.blade.php ENDPATH**/ ?>