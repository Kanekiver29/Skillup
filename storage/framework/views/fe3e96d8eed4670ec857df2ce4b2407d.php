<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['open' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['open' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div
    x-show="<?php echo e($open ? 'true' : 'false'); ?>"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0"
    class="fixed inset-x-0 bottom-[5.2rem] z-50 mx-auto w-[92%] max-w-md rounded-[28px] border border-slate-700/80 bg-[#091827]/95 p-3 shadow-2xl shadow-black/50 backdrop-blur-xl"
    role="dialog"
    aria-modal="true"
    aria-label="More menu"
>
    <div class="mb-3 flex items-center justify-between border-b border-slate-700/80 px-2 pb-3">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-cyan-300">More</p>
        <button type="button" x-on:click="openMore = false" class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-700 bg-slate-900/80 text-slate-300" aria-label="Close more menu">
            <i class="fas fa-xmark text-sm" aria-hidden="true"></i>
        </button>
    </div>

    <div class="space-y-1">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\components\navigation\mobile-menu.blade.php ENDPATH**/ ?>