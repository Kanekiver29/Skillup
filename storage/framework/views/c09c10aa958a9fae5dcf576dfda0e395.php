

<?php $__env->startSection('title', __('sias.documents_requests')); ?>
<?php $__env->startSection('page_title', __('sias.documents_requests')); ?>

<?php $__env->startSection('content'); ?>
<style>
    .documents-page { display:grid; gap:1.25rem; }
    .documents-hero { display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; flex-wrap:wrap; }
    .documents-hero h2 { margin:0; font-size:clamp(1.5rem, 3vw, 2rem); }
    .documents-hero p { margin:.45rem 0 0; color:var(--text-muted); max-width:650px; line-height:1.6; }
    .documents-stats { display:flex; gap:.65rem; flex-wrap:wrap; }
    .document-stat { min-width:92px; padding:.7rem .85rem; border:1px solid var(--card-border); border-radius:12px; background:var(--block-bg); text-align:center; }
    .document-stat strong { display:block; font-size:1.25rem; color:var(--text); }
    .document-stat span { color:var(--text-muted); font-size:.72rem; text-transform:uppercase; letter-spacing:.06em; }
    .documents-layout { display:grid; grid-template-columns:minmax(280px, .8fr) minmax(0, 1.4fr); gap:1rem; align-items:start; }
    .documents-panel { min-width:0; padding:1.2rem; border:1px solid var(--card-border); border-radius:16px; background:var(--card-bg); box-shadow:var(--card-shadow); }
    .documents-panel h3 { margin:0; font-size:1.05rem; }
    .documents-panel > p { margin:.35rem 0 1rem; color:var(--text-muted); font-size:.9rem; line-height:1.5; }
    .document-form { display:grid; gap:.9rem; }
    .document-form label { display:grid; gap:.35rem; color:var(--text); font-size:.82rem; font-weight:700; }
    .document-form input, .document-form select, .document-form textarea { width:100%; border:1px solid var(--block-border); border-radius:10px; padding:.75rem .8rem; background:var(--block-bg); color:var(--text); font:inherit; font-size:.9rem; }
    .document-form textarea { min-height:125px; resize:vertical; }
    .document-form input:focus, .document-form select:focus, .document-form textarea:focus { outline:2px solid var(--focus-ring); outline-offset:2px; }
    .field-hint { color:var(--text-faint); font-size:.75rem; font-weight:400; }
    .form-error { color:#b91c1c; font-size:.78rem; font-weight:500; }
    .notice { padding:.8rem 1rem; border-radius:10px; background:rgba(34,197,94,.1); color:#166534; border:1px solid rgba(34,197,94,.25); }
    .request-toolbar { display:flex; justify-content:space-between; align-items:center; gap:.75rem; flex-wrap:wrap; margin-bottom:.75rem; }
    .request-toolbar input { width:min(260px, 100%); border:1px solid var(--block-border); border-radius:999px; padding:.6rem .85rem; background:var(--block-bg); color:var(--text); }
    .request-list { min-width:0; display:grid; gap:.7rem; }
    .request-item { min-width:0; max-width:100%; overflow:hidden; padding:1rem; border:1px solid var(--card-border); border-radius:12px; background:var(--block-bg); }
    .request-item[hidden] { display:none; }
    .request-head { display:flex; justify-content:space-between; gap:1rem; align-items:flex-start; min-width:0; }
    .request-head > div { min-width:0; }
    .request-title { margin:0; color:var(--text); font-size:.98rem; overflow-wrap:anywhere; }
    .request-subject, .request-details, .request-date { color:var(--text-muted); font-size:.84rem; overflow-wrap:anywhere; word-break:break-word; }
    .request-subject { margin:.25rem 0; }
    .request-details { margin:.7rem 0; white-space:pre-line; line-height:1.5; }
    .status { display:inline-flex; padding:.3rem .55rem; border-radius:999px; background:rgba(201,151,59,.14); color:var(--accent); font-size:.72rem; font-weight:700; white-space:nowrap; }
    .request-actions { display:flex; gap:.6rem; align-items:center; flex-wrap:wrap; }
    .request-actions a, .request-actions button { color:var(--accent); background:none; border:0; padding:0; cursor:pointer; font:inherit; font-size:.8rem; text-decoration:none; }
    .request-actions button { color:#b91c1c; }
    .empty-state { padding:2rem 1rem; text-align:center; color:var(--text-muted); border:1px dashed var(--block-border); border-radius:12px; }
    @media (max-width: 850px) { .documents-layout { grid-template-columns:1fr; } }
</style>

<div class="page-card documents-page">
    <div class="documents-hero">
        <div>
            <h2><?php echo e(__('sias.documents_requests')); ?></h2>
            <p><?php echo e(__('sias.submit_documents_requests')); ?></p>
        </div>
        <div class="documents-stats" aria-label="Request summary">
            <div class="document-stat"><strong><?php echo e($requests->whereIn('status', ['pending', 'processing'])->count()); ?></strong><span><?php echo e(__('sias.open')); ?></span></div>
            <div class="document-stat"><strong><?php echo e($requests->whereIn('status', ['ready', 'completed'])->count()); ?></strong><span><?php echo e(__('sias.ready')); ?></span></div>
            <div class="document-stat"><strong><?php echo e($requests->count()); ?></strong><span><?php echo e(__('sias.total')); ?></span></div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?><div class="notice" role="status"><?php echo e(session('success')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?><div class="notice" style="background:rgba(185,28,28,.08);color:#991b1b;border-color:rgba(185,28,28,.2);" role="alert">Please check the highlighted form fields and try again.</div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="documents-layout">
        <section class="documents-panel">
            <h3><?php echo e(__('sias.start_request')); ?></h3>
            <p><?php echo e(__('sias.submit_documents_requests')); ?></p>
            <form class="document-form" method="POST" action="<?php echo e(route('sias.student.documents.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <label><?php echo e(__('sias.request_type')); ?>

                    <select name="type" required><option value=""><?php echo e(__('sias.choose_request')); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $requestTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?><option value="<?php echo e($value); ?>" <?php if(old('type') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?></select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>
                <label><?php echo e(__('sias.subject_reference')); ?> <span class="field-hint"><?php echo e(__('sias.optional')); ?></span>
                    <input name="subject" value="<?php echo e(old('subject')); ?>" maxlength="120" placeholder="Example: Certificate for scholarship application">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>
                <label><?php echo e(__('sias.details')); ?>

                    <textarea name="details" required minlength="10" maxlength="2000" placeholder="Tell us what you need and when you need it."><?php echo e(old('details')); ?></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>
                <label><?php echo e(__('sias.supporting_file')); ?> <span class="field-hint">PDF, JPG, or PNG up to 5 MB</span>
                    <input type="file" name="attachment" accept=".pdf,.jpg,.jpeg,.png">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="form-error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </label>
                <button type="submit" class="btn-black"><?php echo e(__('sias.submit_request')); ?></button>
            </form>
        </section>

        <section class="documents-panel">
            <div class="request-toolbar"><div><h3><?php echo e(__('sias.request_history')); ?></h3><p style="margin:0;"><?php echo e(__('sias.track_latest_updates')); ?></p></div><input id="requestSearch" type="search" placeholder="<?php echo e(__('sias.search_requests')); ?>" aria-label="<?php echo e(__('sias.search_requests')); ?>"></div>
            <div class="request-list" id="requestList">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documentRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article class="request-item" data-search="<?php echo e(strtolower($documentRequest->typeLabel().' '.$documentRequest->subject.' '.$documentRequest->details.' '.$documentRequest->statusLabel())); ?>">
                        <div class="request-head"><div><h4 class="request-title"><?php echo e($documentRequest->typeLabel()); ?></h4><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documentRequest->subject): ?><p class="request-subject"><?php echo e($documentRequest->subject); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div><span class="status"><?php echo e($documentRequest->statusLabel()); ?></span></div>
                        <p class="request-details"><?php echo e($documentRequest->details); ?></p>
                        <div class="request-actions"><span class="request-date"><?php echo e(__('sias.submitted')); ?> <?php echo e($documentRequest->created_at->format('M j, Y g:i A')); ?></span><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documentRequest->attachment_path): ?><a href="<?php echo e(route('sias.student.documents.download', $documentRequest)); ?>"><?php echo e(__('sias.download_attachment')); ?></a><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documentRequest->status === 'pending'): ?><form method="POST" action="<?php echo e(route('sias.student.documents.destroy', $documentRequest)); ?>" onsubmit="return confirm('<?php echo e(__('sias.cancel')); ?> this request?');"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="submit"><?php echo e(__('sias.cancel')); ?></button></form><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documentRequest->staff_notes): ?><p class="request-details" style="border-top:1px solid var(--card-border);padding-top:.65rem;margin-bottom:0;"><strong>Staff note:</strong> <?php echo e($documentRequest->staff_notes); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?><div class="empty-state"><?php echo e(__('sias.no_requests')); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>
    </div>
</div>

<script>
    document.getElementById('requestSearch')?.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        document.querySelectorAll('#requestList .request-item').forEach(function (item) { item.hidden = query !== '' && !item.dataset.search.includes(query); });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('sias.students.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\documents\index.blade.php ENDPATH**/ ?>