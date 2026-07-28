

<?php $__env->startSection('title', 'Image Resources'); ?>

<?php $__env->startSection('content'); ?>
<div class="ir-page">
    <header class="ir-header">
        <div class="ir-header-left">
            <span class="ir-icon-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
            <div>
                <h1 class="ir-title">Image Resources</h1>
                <p class="ir-subtitle">Attach or replace module images in one place.</p>
            </div>
        </div>
        <span class="ir-pill">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            <?php echo e($modules->count()); ?> <?php echo e(Str::plural('module', $modules->count())); ?>

        </span>
    </header>

    <?php if(session('success')): ?>
        <div class="ir-toast">
            <span class="ir-toast-check">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <div class="ir-card ir-form-card">
        <div class="ir-form-glow"></div>
        <form action="<?php echo e(route('staff.images.store')); ?>" method="POST" enctype="multipart/form-data" id="image_form" class="ir-form-grid">
            <?php echo csrf_field(); ?>
            <div class="ir-form-fields">
                <div class="ir-field">
                    <label class="ir-label" for="module_id">Module</label>
                    <div class="ir-select-wrap">
                        <select name="module_id" id="module_id" class="ir-select" required>
                            <option value="">Select a module</option>
                            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($module->id); ?>"><?php echo e($module->course->title ?? 'Course'); ?> · <?php echo e($module->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <svg class="ir-select-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <div class="ir-field">
                    <label class="ir-label" for="image_file">Upload Image File</label>

                    <label for="image_file" id="drop_zone" class="ir-dropzone">
                        <div id="placeholder_state" class="ir-placeholder-state">
                            <span class="ir-dropzone-icon-wrap">
                                <svg class="ir-dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span class="ir-dropzone-text">Click to choose or drag an image here</span>
                            <span class="ir-dropzone-hint">PNG, JPG, GIF or WEBP up to your server limit</span>
                        </div>

                        <div id="preview_state" class="ir-preview-state">
                            <img id="preview_img" src="" alt="Selected image preview" class="ir-preview-img">
                            <span id="file_name_display" class="ir-preview-filename"></span>
                            <span class="ir-preview-hint">Click or drag to replace</span>
                        </div>

                        <input type="file" name="image_file" id="image_file" accept="image/*" class="ir-hidden-input">
                        <span class="ir-dropzone-sheen"></span>
                    </label>
                </div>
            </div>

            <div class="ir-info-panel">
                <div>
                    <h2 class="ir-info-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        How it works
                    </h2>
                    <ul class="ir-info-list">
                        <li><span class="ir-dot"></span>Choose a module and upload a new image.</li>
                        <li><span class="ir-dot"></span>The image will be used as the module resource visual.</li>
                        <li><span class="ir-dot"></span>You can remove it at any time.</li>
                    </ul>
                </div>
                <button type="submit" id="submit_btn" class="ir-btn-primary">
                    <svg id="submit_spinner" class="ir-spinner ir-hidden" viewBox="0 0 24 24" fill="none">
                        <circle class="ir-spinner-track" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="ir-spinner-head" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span id="submit_label">Save Image</span>
                </button>
            </div>
        </form>
    </div>

    <div class="ir-card ir-table-card">
        <table class="ir-table">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Current Image</th>
                    <th class="ir-th-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="ir-row" style="animation-delay: <?php echo e(150 + ($loop->index * 40)); ?>ms;">
                        <td class="ir-td-module"><?php echo e($module->course->title ?? 'Course'); ?> · <?php echo e($module->title); ?></td>
                        <td>
                            <?php if($module->image_url): ?>
                                <a href="<?php echo e($module->image_url); ?>" target="_blank" rel="noopener" class="ir-thumb-link">
                                    <img src="<?php echo e($module->image_url); ?>" alt="<?php echo e($module->title); ?> thumbnail" class="ir-thumb-img">
                                    <span class="ir-badge-link">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                        Open image
                                    </span>
                                </a>
                            <?php else: ?>
                                <span class="ir-badge-empty">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                    No image attached
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="ir-td-actions">
                            <a href="<?php echo e(route('staff.images.edit', $module)); ?>" class="ir-link-edit">Edit</a>
                            <form action="<?php echo e(route('staff.images.destroy', $module)); ?>" method="POST" onsubmit="return confirm('Remove this image resource?');" class="ir-inline-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="ir-link-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="ir-empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>No modules available yet.</span>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
:root {
    --ir-primary: #0284c7;
    --ir-primary-dark: #0369a1;
    --ir-primary-light: #e0f2fe;
    --ir-accent: #4f46e5;
    --ir-ink: #1e293b;
    --ir-muted: #64748b;
    --ir-muted-light: #94a3b8;
    --ir-border: #e2e8f0;
    --ir-surface: #ffffff;
    --ir-surface-soft: #f8fafc;
    --ir-danger: #e11d48;
    --ir-success-bg: #d1fae5;
    --ir-success-text: #065f46;
    --ir-success-solid: #10b981;
    --ir-radius-md: 0.75rem;
    --ir-shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.06);
    --ir-shadow-md: 0 10px 25px -8px rgba(15, 23, 42, 0.15);
}

.ir-page { max-width: 72rem; margin: 0 auto; padding: 1.5rem; color: var(--ir-ink); font-family: inherit; }

/* Header */
.ir-header { display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem; animation: irFadeInDown 0.4s ease-out both; }
.ir-header-left { display: flex; align-items: center; gap: 0.75rem; }
.ir-icon-badge {
    width: 2.75rem; height: 2.75rem; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    border-radius: 0.9rem; color: #fff;
    background: linear-gradient(135deg, var(--ir-primary), var(--ir-accent));
    box-shadow: var(--ir-shadow-md);
}
.ir-icon-badge svg { width: 1.5rem; height: 1.5rem; display: block; }
.ir-title { font-size: 1.875rem; font-weight: 700; letter-spacing: -0.02em; margin: 0; color: var(--ir-ink); }
.ir-subtitle { font-size: 0.875rem; color: var(--ir-muted-light); margin: 0.15rem 0 0; }
.ir-pill {
    display: inline-flex; align-items: center; gap: 0.4rem; width: fit-content;
    padding: 0.35rem 0.85rem; border-radius: 999px; background: var(--ir-surface-soft);
    color: var(--ir-muted); font-size: 0.75rem; font-weight: 600;
}
.ir-pill svg { width: 0.875rem; height: 0.875rem; }
@media (min-width: 768px) { .ir-header { flex-direction: row; align-items: center; justify-content: space-between; } }

/* Toast */
.ir-toast {
    display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem; padding: 1rem;
    border-radius: var(--ir-radius-md); background: var(--ir-success-bg); color: var(--ir-success-text);
    font-size: 0.875rem; box-shadow: var(--ir-shadow-sm); animation: irToastIn 0.35s ease-out both;
}
.ir-toast-check {
    width: 1.5rem; height: 1.5rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    border-radius: 999px; background: var(--ir-success-solid); color: #fff;
    animation: irPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
.ir-toast-check svg { width: 0.875rem; height: 0.875rem; }

/* Cards */
.ir-card { background: var(--ir-surface); border: 1px solid var(--ir-border); border-radius: 1.25rem; box-shadow: var(--ir-shadow-sm); transition: box-shadow 0.3s ease; }
.ir-card:hover { box-shadow: var(--ir-shadow-md); }
.ir-form-card { position: relative; overflow: hidden; padding: 1.75rem; margin-bottom: 2rem; animation: irFadeInUp 0.45s ease-out both; }
.ir-form-glow {
    position: absolute; top: -60%; right: -20%; width: 20rem; height: 20rem;
    background: radial-gradient(circle, rgba(79, 70, 229, 0.08), transparent 70%); pointer-events: none;
}
.ir-form-grid { position: relative; display: grid; gap: 1.75rem; grid-template-columns: 1fr; }
@media (min-width: 768px) { .ir-form-grid { grid-template-columns: 1.1fr 0.9fr; } }
.ir-form-fields { display: flex; flex-direction: column; gap: 1.1rem; }

.ir-field { display: flex; flex-direction: column; }
.ir-label { font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem; }

.ir-select-wrap { position: relative; }
.ir-select {
    width: 100%; appearance: none; border: 1px solid var(--ir-border); border-radius: 0.6rem;
    background: #fff; padding: 0.65rem 0.85rem; font-size: 0.875rem; color: var(--ir-ink);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.ir-select:focus { outline: none; border-color: var(--ir-primary); box-shadow: 0 0 0 4px var(--ir-primary-light); }
.ir-select-caret { position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); width: 1rem; height: 1rem; color: var(--ir-muted-light); pointer-events: none; }

.ir-dropzone {
    position: relative; display: flex; min-height: 9rem; flex-direction: column; align-items: center; justify-content: center;
    overflow: hidden; text-align: center; padding: 1.5rem 1rem;
    border: 2px dashed var(--ir-border); border-radius: var(--ir-radius-md); background: var(--ir-surface-soft);
    cursor: pointer; transition: border-color 0.3s ease, background-color 0.3s ease;
}
.ir-dropzone:hover, .ir-dropzone.ir-drag-active { border-color: var(--ir-primary); background: var(--ir-primary-light); }

.ir-placeholder-state { display: flex; flex-direction: column; align-items: center; transition: opacity 0.3s ease; }
.ir-dropzone-icon-wrap {
    width: 2.5rem; height: 2.5rem; flex-shrink: 0; display: flex; align-items: center; justify-content: center;
    border-radius: 999px; background: #fff; box-shadow: var(--ir-shadow-sm); margin-bottom: 0.6rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.ir-dropzone:hover .ir-dropzone-icon-wrap { transform: scale(1.08); box-shadow: var(--ir-shadow-md); }
.ir-dropzone-icon { width: 1.25rem; height: 1.25rem; color: var(--ir-muted-light); transition: color 0.3s ease; }
.ir-dropzone:hover .ir-dropzone-icon { color: var(--ir-primary); }
.ir-dropzone-text { font-size: 0.875rem; font-weight: 600; color: var(--ir-muted); transition: color 0.3s ease; }
.ir-dropzone:hover .ir-dropzone-text { color: var(--ir-primary-dark); }
.ir-dropzone-hint { display: block; margin-top: 0.25rem; font-size: 0.75rem; color: var(--ir-muted-light); }

.ir-preview-state { display: none; flex-direction: column; align-items: center; gap: 0.4rem; animation: irPop 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) both; }
.ir-preview-state.ir-visible { display: flex; }
.ir-preview-img { width: 5rem; height: 5rem; border-radius: 0.6rem; border: 1px solid var(--ir-border); object-fit: cover; box-shadow: var(--ir-shadow-sm); }
.ir-preview-filename { max-width: 14rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.875rem; font-weight: 600; color: var(--ir-muted); }
.ir-preview-hint { font-size: 0.75rem; color: var(--ir-primary); }

.ir-dropzone-sheen {
    position: absolute; inset: 0; pointer-events: none; transform: translateX(-100%);
    background: linear-gradient(90deg, transparent, rgba(2, 132, 199, 0.12), transparent);
    transition: transform 0.7s ease;
}
.ir-dropzone:hover .ir-dropzone-sheen { transform: translateX(100%); }
.ir-hidden-input { display: none; }

.ir-info-panel {
    display: flex; flex-direction: column; justify-content: space-between; border-radius: var(--ir-radius-md);
    background: linear-gradient(160deg, var(--ir-surface-soft), #f1f5f9); padding: 1.4rem; font-size: 0.875rem; color: var(--ir-muted);
}
.ir-info-title { display: flex; align-items: center; gap: 0.5rem; font-weight: 700; color: #1e293b; margin: 0 0 0.85rem; }
.ir-info-title svg { width: 1rem; height: 1rem; color: var(--ir-primary); }
.ir-info-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.65rem; }
.ir-info-list li { display: flex; align-items: flex-start; gap: 0.5rem; }
.ir-dot { width: 0.4rem; height: 0.4rem; border-radius: 999px; background: var(--ir-accent); margin-top: 0.4rem; flex-shrink: 0; }

.ir-btn-primary {
    margin-top: 1.4rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
    border: none; border-radius: 0.7rem; background: var(--ir-primary); color: #fff; font-weight: 700;
    font-size: 0.9rem; padding: 0.7rem 1.1rem; cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
}
.ir-btn-primary:hover { background: var(--ir-primary-dark); box-shadow: var(--ir-shadow-md); transform: translateY(-2px); }
.ir-btn-primary:active { transform: scale(0.97); }
.ir-btn-primary:disabled { opacity: 0.8; cursor: not-allowed; }

.ir-spinner { width: 1rem; height: 1rem; animation: irSpin 0.8s linear infinite; }
.ir-spinner-track { opacity: 0.25; }
.ir-spinner-head { opacity: 0.85; }
.ir-hidden { display: none; }

/* Table */
.ir-table-card { overflow-x: auto; animation: irFadeInUp 0.45s ease-out 0.12s both; }
.ir-table { width: 100%; border-collapse: collapse; }
.ir-table thead { background: var(--ir-surface-soft); }
.ir-table th {
    text-align: left; padding: 0.85rem 1.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: var(--ir-muted); border-bottom: 1px solid var(--ir-border);
}
.ir-th-right { text-align: right; }
.ir-table td { padding: 1rem 1.5rem; font-size: 0.875rem; border-bottom: 1px solid var(--ir-border); }
.ir-row { animation: irFadeInUp 0.45s ease-out both; transition: background-color 0.15s ease; }
.ir-row:hover { background: var(--ir-surface-soft); }
.ir-row:last-child td { border-bottom: none; }
.ir-td-module { font-weight: 600; color: #334155; }
.ir-td-actions { text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 0.85rem; }
.ir-inline-form { display: inline-flex; }

.ir-thumb-link { display: flex; align-items: center; gap: 0.75rem; text-decoration: none; }
.ir-thumb-img {
    width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; border: 1px solid var(--ir-border);
    object-fit: cover; box-shadow: var(--ir-shadow-sm); transition: transform 0.2s ease;
}
.ir-thumb-link:hover .ir-thumb-img { transform: scale(1.08); }
.ir-badge-link {
    display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.3rem 0.75rem; border-radius: 999px;
    background: var(--ir-primary-light); color: var(--ir-primary-dark); font-weight: 500;
    transition: background-color 0.15s ease, color 0.15s ease;
}
.ir-thumb-link:hover .ir-badge-link { background: #bae6fd; }
.ir-badge-link svg { width: 0.875rem; height: 0.875rem; }
.ir-badge-empty { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--ir-muted-light); }
.ir-badge-empty svg { width: 0.875rem; height: 0.875rem; }

.ir-link-edit { font-weight: 700; color: var(--ir-primary); text-decoration: none; transition: color 0.15s ease; }
.ir-link-edit:hover { color: var(--ir-primary-dark); }
.ir-link-remove { font-weight: 700; color: var(--ir-danger); background: none; border: none; cursor: pointer; padding: 0; font-size: 0.875rem; transition: color 0.15s ease; }
.ir-link-remove:hover { color: #9f1239; }

.ir-empty-state { text-align: center; padding: 3rem 1.5rem; color: var(--ir-muted-light); display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
.ir-empty-state svg { width: 2rem; height: 2rem; }
.ir-empty-state span { font-size: 0.875rem; }

/* Animations */
@keyframes irFadeInDown { from { opacity: 0; transform: translateY(-12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes irFadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
@keyframes irToastIn { from { opacity: 0; transform: translateY(-8px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
@keyframes irPop { 0% { transform: scale(0); opacity: 0; } 70% { transform: scale(1.1); opacity: 1; } 100% { transform: scale(1); } }
@keyframes irSpin { to { transform: rotate(360deg); } }
</style>

<script>
    (function () {
        var input = document.getElementById('image_file');
        var dropZone = document.getElementById('drop_zone');
        var placeholderState = document.getElementById('placeholder_state');
        var previewState = document.getElementById('preview_state');
        var previewImg = document.getElementById('preview_img');
        var fileNameDisplay = document.getElementById('file_name_display');
        var form = document.getElementById('image_form');
        var submitBtn = document.getElementById('submit_btn');
        var submitSpinner = document.getElementById('submit_spinner');
        var submitLabel = document.getElementById('submit_label');

        if (!input || !dropZone) return;

        function showPreview(file) {
            if (!file) return;

            var reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                fileNameDisplay.textContent = file.name;
                placeholderState.style.display = 'none';
                previewState.classList.add('ir-visible');
            };
            reader.readAsDataURL(file);
        }

        input.addEventListener('change', function () {
            showPreview(input.files && input.files[0]);
        });

        ['dragenter', 'dragover'].forEach(function (evt) {
            dropZone.addEventListener(evt, function (e) {
                e.preventDefault();
                dropZone.classList.add('ir-drag-active');
            });
        });
        ['dragleave', 'drop'].forEach(function (evt) {
            dropZone.addEventListener(evt, function (e) {
                e.preventDefault();
                dropZone.classList.remove('ir-drag-active');
            });
        });
        dropZone.addEventListener('drop', function (e) {
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                showPreview(e.dataTransfer.files[0]);
            }
        });

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                if (submitSpinner) submitSpinner.classList.remove('ir-hidden');
                if (submitLabel) submitLabel.textContent = 'Saving…';
            });
        }
    })();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/staff/images/image.blade.php ENDPATH**/ ?>