

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'color' => 'indigo',
    'icon' => null,
    'variant' => 'default',
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
    'color' => 'indigo',
    'icon' => null,
    'variant' => 'default',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colorMap = [
        'indigo'  => 'bg-indigo-50 text-indigo-700',
        'purple'  => 'bg-purple-100 text-purple-700',
        'blue'    => 'bg-blue-100 text-blue-700',
        'green'   => 'bg-green-100 text-green-700',
        'red'     => 'bg-red-100 text-red-700',
        'yellow'  => 'bg-yellow-100 text-yellow-700',
        'gray'    => 'bg-gray-100 text-gray-600',
        'pink'    => 'bg-pink-100 text-pink-700',
    ];

    $solidColorMap = [
        'indigo'  => 'bg-indigo-600 text-white',
        'purple'  => 'bg-purple-600 text-white',
        'blue'    => 'bg-blue-600 text-white',
        'green'   => 'bg-green-600 text-white',
        'red'     => 'bg-red-600 text-white',
        'yellow'  => 'bg-yellow-500 text-white',
        'gray'    => 'bg-gray-500 text-white',
    ];

    $dotColors = [
        'green'  => 'bg-green-500',
        'red'    => 'bg-red-500',
        'yellow' => 'bg-yellow-500',
        'blue'   => 'bg-blue-500',
        'gray'   => 'bg-gray-400',
    ];

    $base = 'inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold';

    $classes = match($variant) {
        'count' => $base . ' ' . ($solidColorMap[$color] ?? $solidColorMap['indigo']),
        default => $base . ' ' . ($colorMap[$color] ?? $colorMap['indigo']),
    };
?>

<span <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($variant === 'dot'): ?>
        <span class="w-2 h-2 rounded-full <?php echo e($dotColors[$color] ?? $dotColors['gray']); ?>"></span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($icon): ?>
        <i class="<?php echo e($icon); ?> text-[10px]"></i>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo e($slot); ?>

</span>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\components\ui\badge.blade.php ENDPATH**/ ?>