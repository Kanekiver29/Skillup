

<?php $__env->startSection('title', 'Subjects'); ?>
<?php $__env->startSection('page_title', 'Subject Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="padding:1.5rem;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;">
        <div>
            <h2 style="margin:0;font-size:2rem;letter-spacing:-.02em;" data-i18n="all_subjects">All Subjects</h2>
            <p style="margin:.5rem 0 0;color:var(--text-muted);" data-i18n="manage_subjects_course_offerings">Manage subjects and course offerings</p>
        </div>
        <a href="<?php echo e(route('sias.admin.subject.add')); ?>" style="display:inline-flex;align-items:center;gap:.6rem;padding:.85rem 1.2rem;background:#1d4ed8;color:#fff;border-radius:14px;text-decoration:none;font-weight:700;transition:all .2s ease;"><i class="fa-solid fa-plus"></i> <span data-i18n="new_subject">New Subject</span></a>
    </div>

    <div style="display:grid;gap:1rem;margin-bottom:2rem;">
        <input type="text" id="subjectSearch" placeholder="" data-i18n-placeholder="search_subjects_by_name_code" style="width:100%;padding:.75rem 1rem;border:1px solid var(--block-border);border-radius:10px;background:var(--card-bg);color:var(--text);font-size:.95rem;" />
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid var(--divider);">
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;" data-i18n="subject_code">Subject Code</th>
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;" data-i18n="subject_name">Subject Name</th>
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;" data-i18n="course">Course</th>
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;" data-i18n="units">Units</th>
                    <th style="text-align:left;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;" data-i18n="year_level">Year Level</th>
                    <th style="text-align:center;padding:1rem;font-weight:700;color:var(--text-muted);font-size:.85rem;text-transform:uppercase;letter-spacing:.05em;" data-i18n="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr style="border-bottom:1px solid var(--block-border);transition:background .2s ease;">
                        <td style="padding:1rem;font-weight:600;"><?php echo e($subject->code); ?></td>
                        <td style="padding:1rem;"><strong><?php echo e($subject->title); ?></strong></td>
                        <td style="padding:1rem;color:var(--text-muted);"><?php echo e($subject->course->title ?? 'N/A'); ?></td>
                        <td style="padding:1rem;"><span style="display:inline-block;background:rgba(29,78,216,.1);color:#1d4ed8;padding:.35rem .75rem;border-radius:6px;font-size:.85rem;font-weight:600;"><?php echo e($subject->units ?? 3); ?></span></td>
                        <td style="padding:1rem;color:var(--text-muted);">Year <?php echo e($subject->year_level ?? 1); ?></td>
                        <td style="padding:1rem;text-align:center;">
                            <div style="display:flex;gap:.5rem;justify-content:center;">
                                <a href="<?php echo e(route('sias.admin.subject.edit', $subject->id)); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;background:rgba(29,78,216,.1);color:#1d4ed8;text-decoration:none;transition:all .2s ease;font-size:.85rem;" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                <form method="POST" action="<?php echo e(route('sias.admin.subject.delete', $subject->id)); ?>" style="display:inline;" onsubmit="return confirm('Delete this subject?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;background:rgba(220,38,38,.1);color:#dc2626;border:none;cursor:pointer;transition:all .2s ease;font-size:.85rem;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="6" style="padding:2rem;text-align:center;color:var(--text-muted);">
                            <i class="fa-solid fa-inbox" style="font-size:2rem;margin-bottom:.5rem;display:block;opacity:.5;"></i>
                            <span data-i18n="no_subjects_found">No subjects found</span>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('subjectSearch').addEventListener('keyup', function(e) {
        const filter = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\admin\course\subject\subject.blade.php ENDPATH**/ ?>