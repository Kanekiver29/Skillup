<?php
    $reportMenuItems = [
        ['route' => 'sias.student.reports.class-offerings', 'title' => 'Class Offerings'],
        ['route' => 'sias.student.reports.enrolled-subjects', 'title' => 'Enrolled Subjects'],
        ['route' => 'sias.student.reports.final-grades-match', 'title' => 'Final Grades (Match)'],
        ['route' => 'sias.student.reports.final-grades-ignore', 'title' => 'Final Grades (Ignore)'],
        ['route' => 'sias.student.reports.gwa-match', 'title' => 'GWA (Match)'],
        ['route' => 'sias.student.reports.gwa-ignore', 'title' => 'GWA (Ignore)'],
        ['route' => 'sias.student.reports.term-grades-match', 'title' => 'Term Grades (Match)'],
        ['route' => 'sias.student.reports.term-grades-ignore', 'title' => 'Term Grades (Ignore)'],
    ];
?>

<aside class="col-span-1">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Reports Menu</h2>
        <nav class="space-y-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reportMenuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a href="<?php echo e(route($item['route'])); ?>" class="block rounded-xl px-4 py-3 text-sm font-medium transition ease-in-out <?php echo e(request()->routeIs($item['route']) ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50'); ?>">
                    <?php echo e($item['title']); ?>

                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </nav>
    </div>
</aside>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\sias\students\reports\_menu.blade.php ENDPATH**/ ?>