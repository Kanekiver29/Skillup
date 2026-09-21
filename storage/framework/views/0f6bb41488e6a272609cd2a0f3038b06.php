

<?php $__env->startSection('title', 'Create Quiz'); ?>
<?php $__env->startSection('page_title', 'Create Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1.25rem 3rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:2rem; font-weight:800; margin:0; color:#0b1730;">📝 Create Quiz</h1>
            <p style="margin-top:0.45rem; color:#64768f;">Add a new quiz to a course module.</p>
        </div>
        <a href="<?php echo e(route('teacher.quizzes.index')); ?>" style="display:inline-flex; align-items:center; gap:0.5rem; background:#f1f5fd; color:#0b1730; padding:0.7rem 1rem; border-radius:0.8rem; font-weight:700; border:1px solid #e4eaf7;">← Back to Quizzes</a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
        <div style="background: rgba(220, 38, 38, 0.08); border:1px solid rgba(220,38,38,0.25); color:#b91c1c; padding:1rem 1.2rem; border-radius:0.8rem; margin-bottom:1rem;">
            <strong>Please fix the following:</strong>
            <ul style="margin:0.5rem 0 0 1.2rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <li><?php echo e($error); ?></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </ul>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form action="<?php echo e(route('teacher.quizzes.store')); ?>" method="POST" style="background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14); padding:1.5rem;">
        <?php echo csrf_field(); ?>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.25rem;">
            <div>
                <label for="title" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Quiz Title</label>
                <input id="title" name="title" type="text" required value="<?php echo e(old('title')); ?>" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
            </div>

            <div>
                <label for="passing_score" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Passing Score (%)</label>
                <input id="passing_score" name="passing_score" type="number" min="0" max="100" value="<?php echo e(old('passing_score', 70)); ?>" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.25rem; margin-top:1.25rem;">
            <div>
                <label for="course_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Course</label>
                <select id="course_id" name="course_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
                    <option value="">Select a course</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>><?php echo e($course->title); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div>
                <label for="module_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Module</label>
                <select id="module_id" name="module_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
                    <option value="">Select a module</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $modules ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($module->id); ?>" <?php echo e(old('module_id', request('module_id')) == $module->id ? 'selected' : ''); ?>><?php echo e($module->title); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($module->course): ?> — <?php echo e($module->course->title); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div>
                <label for="subject_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Subject</label>
                <select id="subject_id" name="subject_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
                    <option value="">Select a subject</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($subject->id); ?>" <?php echo e(old('subject_id', request('subject_id')) == $subject->id ? 'selected' : ''); ?>><?php echo e($subject->title); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->course): ?> — <?php echo e($subject->course->title); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
            <div>
                <label for="major_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Major</label>
                <select id="major_id" name="major_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;"><option value="">Select a major</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $majors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $major): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($major->id); ?>" <?php echo e(old('major_id') == $major->id ? 'selected' : ''); ?>><?php echo e($major->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select>
            </div>
        </div>

        <div style="margin-top:1.25rem;">
            <label for="description" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Description</label>
            <textarea id="description" name="description" rows="4" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730; resize:vertical;"><?php echo e(old('description')); ?></textarea>
        </div>

        <fieldset style="margin-top:1.25rem; border:1px solid #e4eaf7; border-radius:.8rem; padding:1rem;">
            <legend style="font-weight:800; color:#0b1730; padding:0 .4rem;">Trivia settings</legend>
            <label style="display:flex; gap:.5rem; align-items:center; font-weight:700; color:#0b1730;">
                <input type="checkbox" name="is_trivia" value="1" <?php echo e(old('is_trivia', request('is_trivia')) ? 'checked' : ''); ?>> Make this a trivia game
            </label>
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-top:1rem;">
                <div><label for="difficulty" style="display:block; font-weight:700; margin-bottom:.4rem;">Difficulty</label><select id="difficulty" name="difficulty" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"><option value="">Select difficulty</option><option value="easy" <?php echo e(old('difficulty') === 'easy' ? 'selected' : ''); ?>>Easy</option><option value="medium" <?php echo e(old('difficulty') === 'medium' ? 'selected' : ''); ?>>Medium</option><option value="hard" <?php echo e(old('difficulty') === 'hard' ? 'selected' : ''); ?>>Hard</option></select></div>
                <div><label for="question_count" style="display:block; font-weight:700; margin-bottom:.4rem;">Number of questions</label><input id="question_count" name="question_count" type="number" min="1" max="100" value="<?php echo e(old('question_count')); ?>" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
                <div><label for="question_time_limit_seconds" style="display:block; font-weight:700; margin-bottom:.4rem;">Seconds per question</label><input id="question_time_limit_seconds" name="question_time_limit_seconds" type="number" min="5" max="3600" value="<?php echo e(old('question_time_limit_seconds')); ?>" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
                <div><label for="scheduled_at" style="display:block; font-weight:700; margin-bottom:.4rem;">Schedule</label><input id="scheduled_at" name="scheduled_at" type="datetime-local" value="<?php echo e(old('scheduled_at')); ?>" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
            </div>
        </fieldset>

        <div style="margin-top:1.25rem; display:flex; justify-content:flex-end; gap:0.75rem; flex-wrap:wrap;">
            <a href="<?php echo e(route('teacher.quizzes.index')); ?>" style="padding:0.8rem 1.25rem; border-radius:0.8rem; background:#f1f5fd; color:#0b1730; border:1px solid #e4eaf7; font-weight:700;">Cancel</a>
            <button type="submit" name="is_published" value="0" style="padding:0.8rem 1.4rem; border:0; border-radius:0.8rem; background:#64748b; color:#fff; font-weight:800; cursor:pointer;">Save Draft</button>
            <button type="submit" name="is_published" value="1" style="padding:0.8rem 1.4rem; border:0; border-radius:0.8rem; background:linear-gradient(135deg,#3358e0,#5b7cf0); color:#fff; font-weight:800; cursor:pointer;">Publish</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\quizzes\create.blade.php ENDPATH**/ ?>