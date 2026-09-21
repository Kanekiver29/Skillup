

<?php $__env->startSection('title', 'Course Management'); ?>
<?php $__env->startSection('page_title', 'Course Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="padding:1.5rem;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <div>
            <h2 style="margin:0;font-size:2rem;letter-spacing:-.02em;" data-i18n="courses_subjects">Courses & Subjects</h2>
            <p style="margin:.5rem 0 0;color:var(--text-muted);max-width:44rem;" data-i18n="manage_courses_subjects">Manage all courses, programs, and their associated subjects here.</p>
        </div>
        <a href="<?php echo e(route('sias.admin.course.add')); ?>" style="display:inline-flex;align-items:center;gap:.6rem;padding:.85rem 1.2rem;background:#1d4ed8;color:#fff;border-radius:14px;text-decoration:none;font-weight:700;transition:all .2s ease;"><i class="fa-solid fa-plus"></i> <span data-i18n="add_course">Add Course</span></a>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:12px;margin-bottom:1.5rem;color:#16a34a;">
            <i class="fa-solid fa-check-circle" style="font-size:1.2rem;"></i>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:12px;margin-bottom:1.5rem;color:#dc2626;">
            <i class="fa-solid fa-exclamation-circle" style="font-size:1.2rem;"></i>
            <span><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div style="display:grid;gap:1.5rem;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div style="background:var(--block-bg);border:1px solid var(--block-border);border-radius:16px;padding:1.5rem;transition:all .2s ease;">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:1rem;flex-wrap:wrap;margin-bottom:1rem;">
                    <div>
                        <h3 style="margin:0 0 .35rem;font-size:1.25rem;font-weight:700;"><?php echo e($course->title); ?></h3>
                        <p style="margin:0 0 .5rem;color:var(--text-muted);font-size:.9rem;"><?php echo e($course->description); ?></p>
                        <div style="display:flex;gap:1rem;margin-top:.75rem;flex-wrap:wrap;">
                            <span style="display:inline-flex;align-items:center;gap:.4rem;font-size:.85rem;color:var(--text-muted);"><i class="fa-solid fa-code"></i> <?php echo e($course->code); ?></span>
                            <span style="display:inline-flex;align-items:center;gap:.4rem;font-size:.85rem;color:var(--text-muted);"><i class="fa-solid fa-building"></i> <?php echo e($course->department); ?></span>
                            <span style="display:inline-flex;align-items:center;gap:.4rem;font-size:.85rem;color:var(--text-muted);"><i class="fa-solid fa-book"></i> <?php echo e($course->subjects_count ?? 0); ?> Subjects</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:.5rem;">
                        <a href="<?php echo e(route('sias.admin.reports', ['department' => $course->department ?? $course->category ?? 'General', 'course_id' => $course->id])); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:10px;background:rgba(16,185,129,.12);color:#059669;text-decoration:none;transition:all .2s ease;" title="Course report"><i class="fa-solid fa-chart-column"></i></a>
                        <a href="<?php echo e(route('sias.admin.course.edit', $course->id)); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:10px;background:var(--block-bg-hover);color:#1d4ed8;text-decoration:none;transition:all .2s ease;" title="Edit"><i class="fa-solid fa-pen"></i></a>
                        <form method="POST" action="<?php echo e(route('sias.admin.course.delete', $course->id)); ?>" style="display:inline;" onsubmit="return confirm('Delete this course?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:10px;background:var(--block-bg-hover);color:#dc2626;border:none;cursor:pointer;transition:all .2s ease;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>

                <details class="form-section-toggle" style="list-style:none;margin-top:1rem;">
                    <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(29,78,216,.08);border:1px solid rgba(29,78,216,.2);border-radius:10px;cursor:pointer;user-select:none;transition:all .2s ease;font-weight:600;font-size:.95rem;margin:0;">
                        <i class="fa-solid fa-book-open" style="color:#1d4ed8;font-size:1rem;"></i>
                        <span>Manage Subjects (<?php echo e($course->subjects_count ?? 0); ?>)</span>
                        <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s ease;color:var(--text-muted);"></i>
                    </summary>
                    <div style="padding:1.5rem;border-top:1px solid var(--divider);animation:slideDown .3s ease forwards;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;gap:1rem;">
                            <h4 style="margin:0;font-weight:600;">Course Subjects</h4>
                            <a href="<?php echo e(route('sias.admin.subject.add', $course->id)); ?>" style="display:inline-flex;align-items:center;gap:.4rem;padding:.6rem .9rem;background:#1d4ed8;color:#fff;border-radius:8px;text-decoration:none;font-weight:600;font-size:.85rem;transition:all .2s ease;"><i class="fa-solid fa-plus"></i> Add Subject</a>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->subjects && $course->subjects->count() > 0): ?>
                            <div style="display:grid;gap:.5rem;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $course->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem 1rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:10px;gap:1rem;flex-wrap:wrap;">
                                        <div style="flex:1;min-width:200px;">
                                            <div style="font-weight:600;color:var(--text);"><?php echo e($subject->code); ?> - <?php echo e($subject->title); ?></div>
                                            <div style="font-size:.85rem;color:var(--text-muted);margin-top:.25rem;"><?php echo e($subject->units ?? 3); ?> Units</div>
                                        </div>
                                        <div style="display:flex;gap:.5rem;">
                                            <a href="<?php echo e(route('sias.admin.subject.edit', $subject->id)); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;background:rgba(29,78,216,.1);color:#1d4ed8;text-decoration:none;transition:all .2s ease;font-size:.85rem;" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                            <form method="POST" action="<?php echo e(route('sias.admin.subject.delete', $subject->id)); ?>" style="display:inline;" onsubmit="return confirm('Delete this subject?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;background:rgba(220,38,38,.1);color:#dc2626;border:none;cursor:pointer;transition:all .2s ease;font-size:.85rem;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div style="text-align:center;padding:2rem 1rem;color:var(--text-muted);">
                                <i class="fa-solid fa-inbox" style="font-size:2rem;margin-bottom:.5rem;display:block;opacity:.5;"></i>
                                <p style="margin:0;">No subjects added yet for this course</p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </details>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div style="text-align:center;padding:3rem 1rem;background:var(--block-bg);border:1px dashed var(--block-border);border-radius:16px;">
                <i class="fa-solid fa-inbox" style="font-size:3rem;margin-bottom:1rem;display:block;opacity:.5;color:var(--text-muted);"></i>
                <h3 style="margin:0 0 .5rem;color:var(--text-muted);">No Courses Yet</h3>
                <p style="margin:0 0 1.5rem;color:var(--text-muted);">Get started by creating your first course</p>
                <a href="<?php echo e(route('sias.admin.course.add')); ?>" style="display:inline-flex;align-items:center;gap:.6rem;padding:.85rem 1.2rem;background:#1d4ed8;color:#fff;border-radius:14px;text-decoration:none;font-weight:700;transition:all .2s ease;"><i class="fa-solid fa-plus"></i> Create Course</a>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
    .form-section-toggle summary::-webkit-details-marker { display: none; }
    .form-section-toggle[open] summary { background: rgba(29,78,216,.12) !important; border-color: rgba(29,78,216,.3) !important; }
    .form-section-toggle[open] summary i:last-child { transform: rotate(180deg); }
    .form-section-toggle summary:hover { background: rgba(29,78,216,.12) !important; }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\course\view.blade.php ENDPATH**/ ?>