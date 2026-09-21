

<?php $__env->startSection('title', 'Religious Background'); ?>
<?php $__env->startSection('page_title', 'Religious Background'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-card" style="padding:1.5rem;">
    <h2 style="margin:0 0 1rem;">Religious Background</h2>
    <p style="margin:0 0 1.5rem;color:var(--text-muted);">Provide your religious or spiritual affiliation for school records.</p>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:12px;margin-bottom:1.5rem;color:#16a34a;">
            <i class="fa-solid fa-check-circle" style="font-size:1.2rem;"></i>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form method="POST" action="<?php echo e(route('sias.student.profile.religious_background.update')); ?>" class="section-card" style="display:grid;gap:1.5rem;max-width:860px;">
        <?php echo csrf_field(); ?>
        
        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-heart" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Religious Affiliation</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Religion
                        <input name="religion" class="form-input" placeholder="e.g. Roman Catholic">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Church / Sect
                        <input name="church" class="form-input" placeholder="e.g. St. Mary's Parish">
                    </label>
                </div>
            </div>
        </details>

        <details class="form-section-toggle" open>
            <summary style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;background:var(--block-bg);border:1px solid var(--block-border);border-radius:14px;cursor:pointer;user-select:none;transition:all .2s var(--ease);font-weight:600;font-size:1rem;margin:0;">
                <i class="fa-solid fa-calendar-days" style="color:var(--accent-strong);font-size:1.2rem;"></i>
                <span>Important Dates</span>
                <i class="fa-solid fa-chevron-down" style="margin-left:auto;font-size:.85rem;transition:transform .3s var(--ease-spring);color:var(--text-muted);"></i>
            </summary>
            <div style="padding:1.5rem;display:grid;gap:1rem;animation:slideDown .3s var(--ease) forwards;">
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                    <label style="display:grid;gap:.35rem;">
                        Baptism Date
                        <input name="baptism_date" type="date" class="form-input">
                    </label>
                    <label style="display:grid;gap:.35rem;">
                        Communion Date
                        <input name="communion_date" type="date" class="form-input">
                    </label>
                </div>
            </div>
        </details>

        <div style="display:flex;justify-content:flex-end;gap:.75rem;flex-wrap:wrap;">
            <a href="<?php echo e(route('sias.student.profile')); ?>" class="btn-white">Back</a>
            <button type="submit" class="btn-black">Save</button>
        </div>
    </form>
</div>

<style>
    .form-section-toggle {
        list-style: none;
    }
    .form-section-toggle summary {
        list-style: none;
        outline: none;
    }
    .form-section-toggle summary::-webkit-details-marker {
        display: none;
    }
    .form-section-toggle[open] summary {
        background: var(--block-bg-hover) !important;
        border-color: var(--accent-strong) !important;
    }
    .form-section-toggle[open] summary i:last-child {
        transform: rotate(180deg);
    }
    .form-section-toggle summary:hover {
        background: var(--block-bg-hover) !important;
        border-color: var(--accent-strong) !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\profile\religious_background.blade.php ENDPATH**/ ?>