<?php $__env->startSection('title', 'Edit Subject: ' . $subject->title); ?>
<?php $__env->startSection('page_title', 'Edit Subject'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .form-container {
        max-width: 860px;
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

    .info-bar {
        background: var(--navy-50);
        border: 1px solid var(--navy-100);
        border-radius: var(--radius-lg);
        padding: 1rem 1.25rem;
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .info-meta {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        font-size: 0.85rem;
        color: var(--text-2);
    }
    .info-meta strong {
        color: var(--navy-950);
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

    .switch-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    .switch-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: var(--accent);
        cursor: pointer;
    }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-top: 1px solid var(--border-soft);
        padding-top: 1.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
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
</style>

<div class="form-container">
    <div class="form-header">
        <div>
            <h1>✏️ Edit Subject</h1>
            <p style="color:var(--muted); font-size:0.9rem; margin-top:0.25rem;">Update subject details, academic units, and course connection.</p>
        </div>
        <a href="<?php echo e(route('teacher.subjects.index')); ?>" class="btn-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to List
        </a>
    </div>

    
    <div class="info-bar">
        <div class="info-meta">
            <div>Subject ID: <strong>#<?php echo e($subject->id); ?></strong></div>
            <div>Code: <strong><?php echo e($subject->subject_code ?: 'SUBJ-'.$subject->id); ?></strong></div>
            <div>Teacher: <strong><?php echo e($subject->teacher?->name ?: auth()->user()->name); ?></strong></div>
        </div>
        <a href="<?php echo e(route('teacher.subjects.lesson', $subject->id)); ?>" style="color:var(--accent); font-weight:700; font-size:0.88rem; display:inline-flex; align-items:center; gap:0.4rem;">
            📖 Manage Lessons →
        </a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.25); color: #b91c1c; padding: 1rem 1.25rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
            <strong style="display:block; margin-bottom:0.4rem;">Please correct the errors below:</strong>
            <ul style="padding-left: 1.2rem; font-size: 0.88rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="form-card">
        <form method="POST" action="<?php echo e(route('teacher.subjects.update', $subject->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid-2">
                <div class="form-group">
                    <label for="title">Subject Title <span class="req">*</span></label>
                    <input type="text" id="title" name="title" value="<?php echo e(old('title', $subject->title)); ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="subject_code">Subject Code</label>
                    <input type="text" id="subject_code" name="subject_code" value="<?php echo e(old('subject_code', $subject->subject_code)); ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="subject_type">Subject Type</label>
                    <select id="subject_type" name="subject_type" class="form-control">
                        <option value="">-- Select Type --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Core', 'Elective', 'Laboratory', 'Practical', 'Seminar', 'Workshop', 'Online']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($type); ?>" <?php echo e(old('subject_type', $subject->subject_type) === $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="course_id">Connected Course <span class="req">*</span></label>
                    <select id="course_id" name="course_id" class="form-control">
                        <option value="">-- Select Course --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($c->id); ?>" <?php echo e(old('course_id', $subject->course_id) == $c->id ? 'selected' : ''); ?>>
                                <?php echo e($c->title); ?> (<?php echo e($c->lessons()->count()); ?> Lessons)
                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <div class="form-hint">Modules, materials, and quizzes use this course connection.</div>
                </div>

                <div class="grid-2" style="margin-bottom:0;">
                    <div class="form-group">
                        <label for="units">Units</label>
                        <input type="number" id="units" name="units" value="<?php echo e(old('units', $subject->units ?: 3)); ?>" min="1" max="20" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="hours">Total Hours</label>
                        <input type="number" id="hours" name="hours" value="<?php echo e(old('hours', $subject->hours ?: 54)); ?>" min="1" max="500" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Subject Description</label>
                <textarea id="description" name="description" rows="4" class="form-control"><?php echo e(old('description', $subject->description)); ?></textarea>
            </div>

            <div class="form-group">
                <label>Status</label>
                <div class="switch-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', $subject->is_active) ? 'checked' : ''); ?>>
                    <label for="is_active" style="margin:0; font-weight:600; cursor:pointer;">
                        Active & Visible in Student Course Directory
                    </label>
                </div>
            </div>

            <div class="form-footer">
                <a href="<?php echo e(route('subjects')); ?>" target="_blank" style="color:var(--muted); font-size:0.88rem; font-weight:600; display:inline-flex; align-items:center; gap:0.4rem;">
                    👁️ Preview Student View
                </a>
                <div style="display:flex; align-items:center; gap:1rem;">
                    <a href="<?php echo e(route('teacher.subjects.index')); ?>" class="btn-back">Cancel</a>
                    <button type="submit" class="btn-submit">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Update Subject
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\SUBJECT\edit.blade.php ENDPATH**/ ?>