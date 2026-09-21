

<?php $__env->startSection('title', 'Grade Sheet'); ?>
<?php $__env->startSection('page_title', 'Grade Sheet'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .grade-sheet-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1.25rem 3rem;
    }

    .grade-sheet-grid {
        background: #fff;
        border: 1px solid #e4eaf7;
        border-radius: 1rem;
        overflow: auto;
        box-shadow: 0 12px 30px -24px rgba(9,20,51,.24);
    }

    .grade-form-shell {
        background: #edf3fb;
        border: 1px solid #dfe7f5;
        border-radius: 1rem;
        padding: 1rem 1rem 0.9rem;
        margin-bottom: 1.25rem;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.9);
    }

    .grade-form-title {
        margin: 0 0 1rem;
        color: #0b1730;
        font-size: 1.15rem;
        font-weight: 800;
    }

    .grade-form-row {
        display: grid;
        grid-template-columns: repeat(6, minmax(120px, 1fr));
        gap: 0.75rem;
        align-items: end;
    }

    .grade-form-field {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .grade-form-field label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #4a5b7a;
        letter-spacing: 0.02em;
    }

    .grade-form-field input,
    .grade-form-field select {
        width: 100%;
        min-height: 46px;
        padding: 0.7rem 0.8rem;
        border: 1px solid #dfe7f5;
        border-radius: 0.75rem;
        background: rgba(255,255,255,0.8);
        color: #0b1730;
        font-size: 0.95rem;
        outline: none;
    }

    .grade-form-field input:focus,
    .grade-form-field select:focus {
        border-color: #315bd6;
        box-shadow: 0 0 0 3px rgba(49, 91, 214, 0.12);
    }

    .grade-action-btn {
        min-height: 46px;
        border: none;
        border-radius: 0.8rem;
        background: linear-gradient(180deg, #2d63f1 0%, #1f56d8 100%);
        color: #fff;
        font-weight: 800;
        font-size: 1.04rem;
        cursor: pointer;
        box-shadow: 0 10px 18px -12px rgba(35, 77, 197, 0.8);
    }

    .grade-sheet-table {
        width: 100%;
        min-width: 1100px;
        border-collapse: separate;
        border-spacing: 0;
        table-layout: fixed;
        background: #fff;
    }

    .grade-sheet-table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: linear-gradient(180deg, #edf3ff 0%, #e9f0fe 100%);
        color: #0b1730;
        text-align: left;
        padding: .8rem .9rem;
        font-size: .76rem;
        letter-spacing: .06em;
        text-transform: uppercase;
        border-bottom: 1px solid #dfe7f5;
    }

    .grade-sheet-table tbody td {
        padding: .75rem .9rem;
        border-bottom: 1px solid #eef2fb;
        vertical-align: top;
        background: #fff;
    }

    .grade-sheet-table tbody tr:nth-child(even) td {
        background: #fbfcff;
    }

    .grade-sheet-table tbody tr:hover td {
        background: #f4f8ff;
    }

    .grade-sheet-table .cell-input {
        width: 100%;
        min-width: 0;
        padding: .64rem .7rem;
        border: 1px solid #dfe7f5;
        border-radius: .6rem;
        background: #ffffff;
        color: #0b1730;
        font-size: .92rem;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .grade-sheet-table .cell-input:focus {
        border-color: #315bd6;
        box-shadow: 0 0 0 3px rgba(49, 91, 214, 0.12);
        outline: none;
    }

    .grade-sheet-table .cell-input--small {
        width: 90px;
    }

    .grade-sheet-table .grade-percent {
        font-weight: 800;
        color: #315bd6;
    }

    .grade-sheet-table .grade-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .35rem .6rem;
        border-radius: 999px;
        background: #edf2ff;
        color: #182c63;
        font-size: .72rem;
        font-weight: 700;
        text-transform: capitalize;
    }
</style>
<div class="grade-sheet-wrap" style="max-width:1280px;margin:0 auto;padding:2rem 1.25rem 3rem;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        <div>
            <h1 style="font-size:2rem;font-weight:800;margin:0;color:#0b1730;">Grade Sheet</h1>
            <p style="margin-top:.45rem;color:#64768f;">Add and edit teacher grade entries in one spreadsheet-style table.</p>
        </div>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
            <button type="button" onclick="document.getElementById('grade-add-form').scrollIntoView({ behavior: 'smooth', block: 'start' });" style="padding:.75rem 1rem;border:0;border-radius:.8rem;background:#315bd6;color:#fff;font-weight:800;cursor:pointer;">+ Add</button>
            <a href="<?php echo e(route('teacher.grades.print')); ?>" target="_blank" rel="noopener" style="padding:.75rem 1rem;border-radius:.8rem;background:#0f766e;color:#fff;font-weight:700;">Print Grades</a>
            <a href="<?php echo e(route('teacher.grades.reports')); ?>" style="padding:.75rem 1rem;border-radius:.8rem;background:#edf2ff;color:#182c63;font-weight:700;">View Reports</a>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:.85rem;margin-bottom:1.5rem;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
            ['Students', $stats['students']],
            ['Records', $stats['attempts']],
            ['Average', $stats['average'].'%'],
            ['Pass rate', $stats['pass_rate'].'%'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="background:#fff;border:1px solid #e4eaf7;border-radius:1rem;padding:1rem;box-shadow:0 12px 30px -20px rgba(9,20,51,.24);">
                <small style="display:block;color:#64768f;font-weight:700;letter-spacing:.06em;text-transform:uppercase;"><?php echo e($stat[0]); ?></small>
                <strong style="display:block;margin-top:.45rem;font-size:1.6rem;color:#0b1730;"><?php echo e($stat[1]); ?></strong>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <div id="grade-add-form" class="grade-form-shell">
        <h2 class="grade-form-title">Add Grade</h2>
        <form method="POST" action="<?php echo e(route('teacher.grades.store')); ?>" class="grade-form-row">
            <?php echo csrf_field(); ?>
            <div class="grade-form-field">
                <label for="student_id">Student</label>
                <select id="student_id" name="student_id" required>
                    <option value="">Select student</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($enrollment->user_id); ?>"><?php echo e($enrollment->user?->name); ?> · <?php echo e($enrollment->course?->title); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div class="grade-form-field">
                <label for="course_id">Course</label>
                <select id="course_id" name="course_id" required>
                    <option value="">Select course</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($course->id); ?>"><?php echo e($course->title); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div class="grade-form-field">
                <label for="assessment_type">Assessment</label>
                <select id="assessment_type" name="assessment_type" required>
                    <option value="activity">Activity</option>
                    <option value="assignment">Assignment</option>
                    <option value="exam" selected>Exam</option>
                    <option value="module">Module</option>
                </select>
            </div>

            <div class="grade-form-field">
                <label for="grade_title">Assessment title</label>
                <input id="grade_title" name="title" required placeholder="Assessment title">
            </div>

            <div class="grade-form-field">
                <label for="grade_score">Score</label>
                <input id="grade_score" name="score" required type="number" min="0" step="0.01" placeholder="Score">
            </div>

            <div class="grade-form-field">
                <label for="grade_max">Max</label>
                <input id="grade_max" name="max_score" required type="number" min="0.01" step="0.01" value="100" placeholder="Max">
            </div>

            <div class="grade-form-field">
                <label for="grade_remarks">Remarks</label>
                <input id="grade_remarks" name="remarks" placeholder="Remarks">
            </div>

            <button type="submit" class="grade-action-btn">Save grade</button>
        </form>
    </div>

    <div class="grade-sheet-grid">
        <table class="grade-sheet-table">
            <thead>
                <tr>
                    <th style="width:20%;">Student</th>
                    <th style="width:16%;">Course</th>
                    <th style="width:18%;">Assessment</th>
                    <th style="width:10%;">Score</th>
                    <th style="width:10%;">Max</th>
                    <th style="width:12%;">Percentage</th>
                    <th style="width:18%;">Remarks</th>
                    <th style="width:12%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $manualGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td style="font-weight:700;color:#0b1730;"><?php echo e($grade->student?->name ?? 'Student'); ?></td>
                        <td style="color:#33415c;"><?php echo e($grade->course?->title ?? '—'); ?></td>
                        <td style="color:#33415c;">
                            <div style="font-weight:800;"><?php echo e($grade->title); ?></div>
                            <div class="grade-badge" style="margin-top:.35rem;"><?php echo e(ucfirst($grade->assessment_type)); ?></div>
                        </td>
                        <td>
                            <form method="POST" action="<?php echo e(route('teacher.grades.update', $grade)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input name="score" type="number" min="0" step="0.01" value="<?php echo e($grade->score); ?>" required class="cell-input cell-input--small">
                        </td>
                        <td>
                                <input name="max_score" type="number" min="0.01" step="0.01" value="<?php echo e($grade->max_score); ?>" required class="cell-input cell-input--small">
                        </td>
                        <td class="grade-percent">
                                <?php echo e(number_format($grade->percentage, 1)); ?>%
                        </td>
                        <td>
                                <input name="remarks" value="<?php echo e($grade->remarks); ?>" placeholder="Remark" class="cell-input">
                        </td>
                        <td>
                                <button type="submit" style="padding:.65rem .85rem;border:0;border-radius:.6rem;background:#1f2937;color:#fff;font-weight:700;cursor:pointer;">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="8" style="padding:1.6rem;text-align:center;color:#64768f;">No manual grade records yet. Use the form above to create your first entry.</td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $hasGrade = $manualGrades->contains(fn($grade) => $grade->student_id == $enrollment->user_id && $grade->course_id == $enrollment->course_id);
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $hasGrade): ?>
                        <tr>
                            <td style="font-weight:700;color:#0b1730;"><?php echo e($enrollment->user?->name ?? 'Student'); ?></td>
                            <td style="color:#33415c;"><?php echo e($enrollment->course?->title ?? '—'); ?></td>
                            <td>
                                <form method="POST" action="<?php echo e(route('teacher.grades.store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="student_id" value="<?php echo e($enrollment->user_id); ?>">
                                    <input type="hidden" name="course_id" value="<?php echo e($enrollment->course_id); ?>">
                                    <select name="assessment_type" class="cell-input" style="margin-bottom:.5rem;">
                                        <option value="activity">Activity</option>
                                        <option value="assignment">Assignment</option>
                                        <option value="exam" selected>Exam</option>
                                        <option value="module">Module</option>
                                    </select>
                                    <input name="title" placeholder="Assessment title" required class="cell-input">
                            </td>
                            <td>
                                    <input name="score" type="number" min="0" step="0.01" value="0" required class="cell-input cell-input--small">
                            </td>
                            <td>
                                    <input name="max_score" type="number" min="0.01" step="0.01" value="100" required class="cell-input cell-input--small">
                            </td>
                            <td class="grade-percent">0.0%</td>
                            <td>
                                    <input name="remarks" placeholder="Remarks" class="cell-input">
                            </td>
                            <td>
                                    <button type="submit" style="padding:.65rem .8rem;border:0;border-radius:.6rem;background:#315bd6;color:#fff;font-weight:700;cursor:pointer;">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('teacher.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/teacher/grades/index.blade.php ENDPATH**/ ?>