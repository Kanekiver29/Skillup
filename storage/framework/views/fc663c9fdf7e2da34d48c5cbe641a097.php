
--}}

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'info',
    'icon' => null,
    'dismissible' => false,
    'errors' => null,
]));

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

foreach (array_filter(([
    'type' => 'info',
    'icon' => null,
    'dismissible' => false,
    'errors' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $styles = [
        'success' => ['bg' => 'bg-green-50 border-green-200', 'text' => 'text-green-700', 'icon' => 'fas fa-check-circle'],
        'error'   => ['bg' => 'bg-red-50 border-red-200',     'text' => 'text-red-700',   'icon' => 'fas fa-times-circle'],
        'warning' => ['bg' => 'bg-yellow-50 border-yellow-200','text' => 'text-yellow-700','icon' => 'fas fa-exclamation-triangle'],
        'info'    => ['bg' => 'bg-blue-50 border-blue-200',    'text' => 'text-blue-700',  'icon' => 'fas fa-info-circle'],
        'errors'  => ['bg' => 'bg-red-50 border-red-200',      'text' => 'text-red-700',   'icon' => 'fas fa-exclamation-circle'],
    ];

    $style = $styles[$type] ?? $styles['info'];
    $iconClass = $icon ?? $style['icon'];
?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'errors' && $errors && $errors->any()): ?>
    <div <?php echo e($attributes->merge(['class' => 'mb-6 p-4 border rounded-lg ' . $style['bg']])); ?>>
        <p class="font-semibold text-red-800 mb-2">
            <i class="<?php echo e($iconClass); ?> mr-1"></i>Please fix the following errors:
        </p>
        <ul class="text-red-700 text-sm space-y-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <li>&bull; <?php echo e($error); ?></li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </ul>
    </div>


<?php elseif($type !== 'errors'): ?>
    <div
        <?php echo e($attributes->merge(['class' => 'mb-6 p-4 border rounded-lg flex items-start gap-3 ' . $style['bg']])); ?>

        <?php if($dismissible): ?> x-data="{ show: true }" x-show="show" x-transition <?php endif; ?>
    >
        <i class="<?php echo e($iconClass); ?> mt-0.5 <?php echo e($style['text']); ?>"></i>
        <div class="flex-1 <?php echo e($style['text']); ?>"><?php echo e($slot); ?></div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dismissible): ?>
            <button @click="show = false" class="<?php echo e($style['text']); ?> hover:opacity-70 transition">
                <i class="fas fa-times"></i>
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\components\ui\alert.blade.php ENDPATH**/ ?>