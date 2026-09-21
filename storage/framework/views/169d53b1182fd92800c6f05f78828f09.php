<?php $__env->startSection('title', ($newsItem->title ?? 'Announcement') . ' — SkillUp'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $category  = strtolower($newsItem->category ?? 'update');
    $isUrgent  = $category === 'alert' || $category === 'urgent';

    $colorName = 'cyan';
    $iconClass = 'fa-info-circle';
    $label     = 'Update';

    if ($isUrgent) {
        $colorName = 'red';
        $iconClass = 'fa-exclamation-triangle';
        $label     = 'Urgent Alert';
    } elseif ($category === 'event') {
        $colorName = 'violet';
        $iconClass = 'fa-calendar-alt';
        $label     = 'Event';
    } elseif ($category === 'academic') {
        $colorName = 'blue';
        $iconClass = 'fa-graduation-cap';
        $label     = 'Academic';
    }

    $colorMap = [
        'cyan'   => ['bg' => 'bg-cyan-500',   'text' => 'text-cyan-400',   'badge' => 'bg-cyan-500/10 text-cyan-300 border-cyan-500/20',   'bar' => 'bg-cyan-500'],
        'red'    => ['bg' => 'bg-red-500',    'text' => 'text-red-400',    'badge' => 'bg-red-500/10 text-red-300 border-red-500/20',       'bar' => 'bg-red-500'],
        'violet' => ['bg' => 'bg-violet-500', 'text' => 'text-violet-400', 'badge' => 'bg-violet-500/10 text-violet-300 border-violet-500/20','bar' => 'bg-violet-500'],
        'blue'   => ['bg' => 'bg-blue-500',   'text' => 'text-blue-400',   'badge' => 'bg-blue-500/10 text-blue-300 border-blue-500/20',     'bar' => 'bg-blue-500'],
    ];
    $colors = $colorMap[$colorName];
?>


<section class="pt-32 pb-16 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900 text-white relative overflow-hidden">
    
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-1/2 -right-1/4 w-[900px] h-[900px] rounded-full bg-gradient-to-b from-<?php echo e($colorName); ?>-500/8 to-transparent blur-3xl"></div>
        <div class="absolute -bottom-1/2 -left-1/4 w-[700px] h-[700px] rounded-full bg-gradient-to-t from-slate-800/30 to-transparent blur-3xl"></div>
    </div>

    <div class="max-w-3xl mx-auto px-4 relative z-10">

        
        <a href="<?php echo e(url()->previous() === url()->current() ? route('news.index') : url()->previous()); ?>"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Announcements
        </a>

        
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-sm font-semibold mb-5 <?php echo e($colors['badge']); ?>">
            <i class="fas <?php echo e($iconClass); ?> text-xs"></i>
            <?php echo e($label); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($newsItem->is_featured): ?>
                <span class="ml-1 px-1.5 py-0.5 rounded-full bg-yellow-500/15 text-yellow-300 border border-yellow-500/20 text-xs font-bold">⭐ Featured</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </span>

        
        <h1 class="text-3xl md:text-4xl font-extrabold leading-tight tracking-tight mb-5">
            <?php echo e($newsItem->title); ?>

        </h1>

        
        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400">
            <span class="flex items-center gap-1.5">
                <i class="fas fa-user-circle"></i>
                SkillUp Team
            </span>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($newsItem->published_at): ?>
            <span class="flex items-center gap-1.5">
                <i class="fas fa-clock"></i>
                <?php echo e($newsItem->published_at->format('F d, Y • h:i A')); ?>

                <span class="text-slate-600 ml-1">(<?php echo e($newsItem->published_at->diffForHumans()); ?>)</span>
            </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($newsItem->target_audience && $newsItem->target_audience !== 'all'): ?>
            <span class="flex items-center gap-1.5">
                <i class="fas fa-users"></i>
                <?php echo e(str_replace('_', ' ', ucfirst($newsItem->target_audience))); ?>

            </span>
            <?php else: ?>
            <span class="flex items-center gap-1.5">
                <i class="fas fa-globe"></i>
                All Students
            </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <span class="flex items-center gap-1.5">
                <i class="fas fa-eye"></i>
                <?php echo e(number_format($newsItem->view_count ?? 0)); ?> views
            </span>
        </div>

    </div>
</section>


<section class="py-14 bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isUrgent): ?>
        <div class="flex items-start gap-3 bg-red-50 border-l-4 border-red-500 rounded-xl p-5 mb-8 shadow-sm">
            <i class="fas fa-exclamation-triangle text-red-500 text-lg mt-0.5 flex-shrink-0"></i>
            <div>
                <p class="font-bold text-red-800 text-sm">This is an urgent alert.</p>
                <p class="text-red-700 text-sm mt-0.5">Please read carefully and take any required action immediately.</p>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($newsItem->featured_image): ?>
        <div class="relative rounded-2xl overflow-hidden mb-8 shadow-md border border-slate-200">
            <div class="absolute top-0 left-0 w-1 h-full <?php echo e($colors['bar']); ?>"></div>
            <img src="<?php echo e(asset('storage/' . $newsItem->featured_image)); ?>"
                 alt="<?php echo e($newsItem->title); ?>"
                 class="w-full object-cover max-h-[480px]">
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            
            <div class="h-1 w-full <?php echo e($colors['bar']); ?>"></div>
            <div class="p-8 sm:p-10">
                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-base">
                    <?php echo nl2br(e(strip_tags($newsItem->content))); ?>

                </div>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($newsItem->video_file)): ?>
        <div class="mt-8">
            <h2 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
                <i class="fas fa-play-circle <?php echo e($colors['text']); ?>"></i> Attached Video
            </h2>
            <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-black">
                <video controls class="w-full max-h-96 object-contain">
                    <source src="<?php echo e(asset('storage/' . $newsItem->video_file)); ?>">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="mt-10 flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-slate-200">
            <a href="<?php echo e(route('news.index')); ?>"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                All Announcements
            </a>
            <div class="flex items-center gap-3 text-sm text-slate-500">
                <span>Share:</span>
                <button onclick="navigator.clipboard.writeText(window.location.href).then(() => alert('Link copied!'))"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-200 hover:bg-slate-50 transition text-slate-600 hover:text-slate-900">
                    <i class="fas fa-link text-xs"></i> Copy link
                </button>
            </div>
        </div>

    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\news\show.blade.php ENDPATH**/ ?>