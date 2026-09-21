

<?php $__env->startSection('title', 'Edit Quiz'); ?>
<?php $__env->startSection('page_title', 'Edit Quiz'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1.25rem 3rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:2rem; font-weight:800; margin:0; color:#0b1730;">✏️ Edit Quiz</h1>
            <p style="margin-top:0.45rem; color:#64768f;">Update quiz settings and details.</p>
        </div>
        <a href="<?php echo e(route('teacher.quizzes.index')); ?>" style="display:inline-flex; align-items:center; gap:0.5rem; background:#f1f5fd; color:#0b1730; padding:0.7rem 1rem; border-radius:0.8rem; font-weight:700; border:1px solid #e4eaf7;">← Back to Quizzes</a>
    </div>

    <form action="<?php echo e(route('teacher.quizzes.update', $quiz->id)); ?>" method="POST" style="background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14); padding:1.5rem;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:1.25rem;">
            <div>
                <label for="title" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Quiz Title</label>
                <input id="title" name="title" type="text" required value="<?php echo e(old('title', $quiz->title)); ?>" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
            </div>

            <div>
                <label for="passing_score" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Passing Score (%)</label>
                <input id="passing_score" name="passing_score" type="number" min="0" max="100" value="<?php echo e(old('passing_score', $quiz->passing_score ?? 70)); ?>" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
            </div>
        </div>

        <div style="margin-top:1.25rem;">
            <label for="description" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Description</label>
            <textarea id="description" name="description" rows="4" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730; resize:vertical;"><?php echo e(old('description', $quiz->description)); ?></textarea>
        </div>

        <fieldset style="margin-top:1.25rem; border:1px solid #e4eaf7; border-radius:.8rem; padding:1rem;">
            <legend style="font-weight:800; color:#0b1730; padding:0 .4rem;">Trivia settings</legend>
            <label style="display:flex; gap:.5rem; align-items:center; font-weight:700; color:#0b1730;"><input type="checkbox" name="is_trivia" value="1" <?php echo e(old('is_trivia', $quiz->is_trivia) ? 'checked' : ''); ?>> Make this a trivia game</label>
            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-top:1rem;">
                <div><label for="difficulty" style="display:block; font-weight:700; margin-bottom:.4rem;">Difficulty</label><select id="difficulty" name="difficulty" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"><option value="">Select difficulty</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['easy','medium','hard']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($level); ?>" <?php echo e(old('difficulty', $quiz->difficulty) === $level ? 'selected' : ''); ?>><?php echo e(ucfirst($level)); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>
                <div><label for="question_count" style="display:block; font-weight:700; margin-bottom:.4rem;">Number of questions</label><input id="question_count" name="question_count" type="number" min="1" max="100" value="<?php echo e(old('question_count', $quiz->question_count)); ?>" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
                <div><label for="question_time_limit_seconds" style="display:block; font-weight:700; margin-bottom:.4rem;">Seconds per question</label><input id="question_time_limit_seconds" name="question_time_limit_seconds" type="number" min="5" max="3600" value="<?php echo e(old('question_time_limit_seconds', $quiz->question_time_limit_seconds)); ?>" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
                <div><label for="scheduled_at" style="display:block; font-weight:700; margin-bottom:.4rem;">Schedule</label><input id="scheduled_at" name="scheduled_at" type="datetime-local" value="<?php echo e(old('scheduled_at', optional($quiz->scheduled_at)->format('Y-m-d\\TH:i'))); ?>" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"></div>
            </div>
        </fieldset>

        <div style="margin-top:1.25rem;">
            <label for="subject_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Subject</label>
            <select id="subject_id" name="subject_id" style="width:100%; padding:0.85rem 1rem; border:1px solid #dfe7f5; border-radius:0.8rem; background:#fbfcff; color:#0b1730;">
                <option value="">Select a subject</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $subjects ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($subject->id); ?>" <?php echo e(old('subject_id', $quiz->subject_id) == $subject->id ? 'selected' : ''); ?>><?php echo e($subject->title); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($subject->course): ?> — <?php echo e($subject->course->title); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
        <div style="margin-top:1.25rem;"><label for="major_id" style="display:block; font-weight:700; margin-bottom:0.5rem; color:#0b1730;">Major</label><select id="major_id" name="major_id" style="width:100%; padding:.85rem 1rem; border:1px solid #dfe7f5; border-radius:.8rem; background:#fbfcff; color:#0b1730;"><option value="">Select a major</option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $majors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $major): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($major->id); ?>" <?php echo e(old('major_id', $quiz->major_id) == $major->id ? 'selected' : ''); ?>><?php echo e($major->name); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select></div>

        <div style="margin-top:1.25rem; display:flex; justify-content:flex-end; gap:0.75rem; flex-wrap:wrap;">
            <a href="<?php echo e(route('teacher.quizzes.index')); ?>" style="padding:0.8rem 1.25rem; border-radius:0.8rem; background:#f1f5fd; color:#0b1730; border:1px solid #e4eaf7; font-weight:700;">Cancel</a>
            <button type="submit" name="is_published" value="0" style="padding:0.8rem 1.4rem; border:0; border-radius:0.8rem; background:#64748b; color:#fff; font-weight:800; cursor:pointer;">Save Draft</button>
            <button type="submit" name="is_published" value="1" style="padding:0.8rem 1.4rem; border:0; border-radius:0.8rem; background:linear-gradient(135deg,#3358e0,#5b7cf0); color:#fff; font-weight:800; cursor:pointer; box-shadow:0 10px 24px rgba(51,88,224,0.24);">Publish</button>
        </div>
    </form>

    <section style="margin-top:1.5rem; background:#fff; border:1px solid #e4eaf7; border-radius:1.25rem; box-shadow:0 1px 2px rgba(9,20,51,0.04),0 10px 30px -12px rgba(9,20,51,0.14); padding:1.5rem;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1.25rem;">
            <div>
                <h2 style="font-size:1.35rem; font-weight:800; margin:0; color:#0b1730;">Questionnaire</h2>
                <p style="margin:.35rem 0 0; color:#64768f;">Add questions, answer choices, correct answers, and explanations.</p>
            </div>
            <strong style="color:#315bd6;"><?php echo e($quiz->questions->count()); ?> question(s)</strong>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quiz->questions->isNotEmpty()): ?>
            <div style="display:grid; gap:.75rem; margin-bottom:1.5rem;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div style="border:1px solid #e4eaf7; border-radius:.8rem; padding:1rem; background:#fbfcff;">
                        <div style="display:flex; justify-content:space-between; gap:1rem;">
                            <strong><?php echo e($loop->iteration); ?>. <?php echo e($question->question_text); ?></strong>
                            <span style="color:#64768f; white-space:nowrap;"><?php echo e(str_replace('_', ' ', ucfirst($question->type))); ?> · <?php echo e($question->points); ?> pt</span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($question->answers->isNotEmpty()): ?>
                            <div style="margin-top:.65rem; display:grid; gap:.25rem; color:#52627c;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <span><?php echo e($answer->is_correct ? '✓' : '○'); ?> <?php echo e($answer->answer_text); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($question->explanation): ?><p style="margin:.65rem 0 0; color:#718198; font-size:.88rem;">Explanation: <?php echo e($question->explanation); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="<?php echo e(route('teacher.quizzes.questions.store', $quiz->id)); ?>" id="question-form">
            <?php echo csrf_field(); ?>
            <div style="display:grid; grid-template-columns:2fr 1fr 1fr; gap:1rem;">
                <div>
                    <label for="question_text" style="display:block; font-weight:700; margin-bottom:.45rem;">Question</label>
                    <textarea id="question_text" name="question_text" rows="3" required style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;"><?php echo e(old('question_text')); ?></textarea>
                </div>
                <div>
                    <label for="type" style="display:block; font-weight:700; margin-bottom:.45rem;">Question type</label>
                    <select id="type" name="type" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;">
                        <option value="multiple_choice">Multiple choice</option>
                        <option value="true_false">True / False</option>
                        <option value="short_answer">Short answer</option>
                    </select>
                </div>
                <div>
                    <label for="points" style="display:block; font-weight:700; margin-bottom:.45rem;">Points</label>
                    <input id="points" name="points" type="number" min="1" max="100" value="<?php echo e(old('points', 1)); ?>" required style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;">
                </div>
            </div>

            <div id="answers-panel" style="margin-top:1rem;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:.5rem;">
                    <label style="font-weight:700;">Answer choices</label>
                    <button type="button" id="add-answer" style="border:0; background:#edf2ff; color:#315bd6; padding:.45rem .7rem; border-radius:.5rem; font-weight:700; cursor:pointer;">+ Add choice</button>
                </div>
                <div id="answer-list"></div>
                <small style="color:#718198;">Select the radio button beside the correct answer.</small>
            </div>

            <div style="margin-top:1rem;">
                <label for="explanation" style="display:block; font-weight:700; margin-bottom:.45rem;">Explanation (optional)</label>
                <textarea id="explanation" name="explanation" rows="2" style="width:100%; padding:.75rem; border:1px solid #dfe7f5; border-radius:.7rem;" placeholder="Explain why the answer is correct."><?php echo e(old('explanation')); ?></textarea>
            </div>
            <button type="submit" style="margin-top:1rem; border:0; border-radius:.7rem; background:#315bd6; color:#fff; padding:.75rem 1.15rem; font-weight:800; cursor:pointer;">Add Question</button>
        </form>
    </section>
</div>

<script>
    const typeField = document.getElementById('type');
    const answerList = document.getElementById('answer-list');
    const answersPanel = document.getElementById('answers-panel');
    const addAnswerButton = document.getElementById('add-answer');

    function renderAnswers() {
        const type = typeField.value;
        answersPanel.style.display = type === 'short_answer' ? 'none' : 'block';
        answerList.innerHTML = '';
        const labels = type === 'true_false' ? ['True', 'False'] : ['', ''];
        labels.forEach((value, index) => addAnswer(value, index, type === 'true_false'));
    }

    function addAnswer(value = '', index = answerList.children.length, locked = false) {
        const row = document.createElement('div');
        row.style.cssText = 'display:flex; gap:.5rem; align-items:center; margin-bottom:.5rem;';
        row.innerHTML = `<input type="radio" name="correct_answer" value="${index}" ${index === 0 ? 'checked' : ''}>
            <input type="text" name="answers[${index}][text]" value="${value}" ${locked ? 'readonly' : 'required'} placeholder="Answer ${index + 1}" style="flex:1; padding:.7rem; border:1px solid #dfe7f5; border-radius:.6rem;">
            ${locked ? '' : '<button type="button" style="border:0; background:#fff1f2; color:#be123c; padding:.55rem; border-radius:.5rem; cursor:pointer;">Remove</button>'}`;
        const remove = row.querySelector('button');
        if (remove) remove.onclick = () => { row.remove(); [...answerList.children].forEach((item, position) => { item.querySelector('input[type=radio]').value = position; item.querySelector('input[type=text]').name = `answers[${position}][text]`; }); };
        answerList.appendChild(row);
    }

    typeField.addEventListener('change', renderAnswers);
    addAnswerButton.addEventListener('click', () => { if (answerList.children.length < 6) addAnswer(); });
    renderAnswers();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\teacher\quizzes\edit.blade.php ENDPATH**/ ?>