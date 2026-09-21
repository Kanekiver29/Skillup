<?php
    $publicItems = [
        ['label' => 'Home', 'route' => route('home'), 'active' => 'home'],
        ['label' => 'About', 'route' => route('about'), 'active' => 'about'],
        ['label' => 'Courses', 'route' => route('courses.index'), 'active' => 'courses.*'],
        ['label' => 'News', 'route' => route('news'), 'active' => 'news*'],
        ['label' => 'Contact', 'route' => route('contact'), 'active' => 'contact'],
    ];

    $studentItems = [
        ['label' => 'Home', 'route' => route('home'), 'active' => 'home'],
        ['label' => 'Courses', 'route' => route('courses.index'), 'active' => 'courses.*'],
        ['label' => 'My Learning', 'route' => route('courses.my-learning'), 'active' => 'courses.my-learning'],
        ['label' => 'Grades', 'route' => route('grades'), 'active' => 'grades'],
        ['label' => 'News', 'route' => route('news'), 'active' => 'news*'],
    ];
?>

<header id="site-header" class="site-header fixed inset-x-0 top-0 z-50 text-slate-100">
    <div class="header-hud-grid hud-grid" aria-hidden="true"></div>

    <div class="status-strip" aria-hidden="true">
        <div class="status-track">
            <span class="status-item"><span class="status-dot"></span>TESDA-ALIGNED CURRICULUM</span>
            <span class="status-item gold"><span class="status-dot"></span>LIVE MENTOR SUPPORT</span>
            <span class="status-item"><span class="status-dot"></span>SKILL PATHS UPDATED WEEKLY</span>
            <span class="status-item red"><span class="status-dot"></span>FREE STARTER COURSES</span>
            <span class="status-item"><span class="status-dot"></span>CAREER-READY CREDENTIALS</span>
            <span class="status-item gold"><span class="status-dot"></span>BUILT FOR FILIPINO YOUTH</span>
            <span class="status-item"><span class="status-dot"></span>TESDA-ALIGNED CURRICULUM</span>
            <span class="status-item gold"><span class="status-dot"></span>LIVE MENTOR SUPPORT</span>
            <span class="status-item"><span class="status-dot"></span>SKILL PATHS UPDATED WEEKLY</span>
            <span class="status-item red"><span class="status-dot"></span>FREE STARTER COURSES</span>
            <span class="status-item"><span class="status-dot"></span>CAREER-READY CREDENTIALS</span>
            <span class="status-item gold"><span class="status-dot"></span>BUILT FOR FILIPINO YOUTH</span>
        </div>
    </div>

    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Main navigation">
        <div class="site-header-bar flex items-center justify-between gap-4 lg:gap-6">
            <a href="<?php echo e(route('home')); ?>" class="header-brand inline-flex items-center gap-3 sm:gap-4 text-white shrink-0" aria-label="SkillUp Home">
                <span class="relative inline-block" style="width:52px;height:52px;flex-shrink:0;">
                    <span class="logo-reticle" aria-hidden="true">
                        <span></span><span></span><span></span><span></span>
                    </span>
                    <span class="logo-ring" aria-hidden="true"></span>
                    <span class="header-brand-icon" id="logo-icon-box" aria-hidden="true">
                        <span id="logo-particles" class="absolute inset-0 overflow-hidden pointer-events-none" style="border-radius:16px;" aria-hidden="true"></span>
                        <svg viewBox="0 0 26 26" fill="none" class="relative z-10" style="width:26px;height:26px;filter:drop-shadow(0 1px 4px rgba(0,0,0,0.45));" aria-hidden="true">
                            <g class="rocket-flame">
                                <ellipse cx="13" cy="22.5" rx="3.8" ry="3.2" fill="rgba(0,230,255,0.9)"/>
                                <ellipse cx="13" cy="23" rx="2.2" ry="2.0" fill="rgba(253,185,19,0.85)"/>
                            </g>
                            <path d="M13 3C9 3 7 8 7 13L7 18C7 18 9.5 19.5 13 19.5C16.5 19.5 19 18 19 18L19 13C19 8 17 3 13 3Z" fill="white" opacity="0.95"/>
                            <circle cx="13" cy="11" r="2.5" fill="rgba(0,58,143,0.75)" stroke="rgba(0,230,255,0.55)" stroke-width="0.5"/>
                            <circle cx="13" cy="11" r="1" fill="rgba(120,215,255,0.95)"/>
                            <circle cx="13.4" cy="10.5" r="0.4" fill="rgba(255,255,255,0.7)"/>
                            <path d="M7 16L4 19L7 18.5Z" fill="rgba(193,18,31,0.85)"/>
                            <path d="M19 16L22 19L19 18.5Z" fill="rgba(193,18,31,0.85)"/>
                            <path d="M13 3C11 3 10 5 10 7L13 5L16 7C16 5 15 3 13 3Z" fill="rgba(253,185,19,0.98)"/>
                        </svg>
                    </span>
                    <svg class="logo-sparkle" viewBox="0 0 14 14" fill="none" aria-hidden="true">
                        <path d="M7 0L7.9 5.5L13.3 5.5L9 8.8L10.4 14L7 10.8L3.6 14L5 8.8L0.7 5.5L6.1 5.5Z" fill="#00e6ff"/>
                    </svg>
                </span>

                <div class="hidden sm:flex flex-col gap-0.5">
                    <span class="logo-wordmark-primary">SkillUp</span>
                    <span class="logo-wordmark-sub">Learning Portal <span class="logo-sub-dot"></span> PH</span>
                </div>
            </a>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                <div class="hidden lg:flex flex-1 justify-center">
                    <div id="primary-nav" class="font-display flex items-center gap-8 xl:gap-10 text-[11px] font-semibold uppercase tracking-[0.14em]">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $publicItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $isActive = request()->routeIs($item['active']);
                            ?>
                            <a href="<?php echo e($item['route']); ?>" class="nav-link <?php echo e($isActive ? 'active' : ''); ?>" title="<?php echo e($item['label']); ?>">
                                <?php echo e($item['label']); ?>

                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <div class="hidden lg:flex items-center gap-2.5 shrink-0">
                    <form action="<?php echo e(route('courses.index')); ?>" method="GET" class="header-search relative flex items-center rounded-full border border-slate-600/60 bg-slate-950/30 px-3 py-2 w-[14rem] xl:w-[20rem]" aria-label="Search courses">
                        <i class="header-search-icon fas fa-search text-slate-400 text-sm" aria-hidden="true"></i>
                        <input type="search" name="search" placeholder="Search Courses" class="ml-2.5 w-full bg-transparent text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none" aria-label="Search courses"/>
                    </form>
                    <a href="<?php echo e(route('login')); ?>" class="header-action-btn header-login-btn btn-ripple inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-semibold text-white">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="header-action-btn header-signup-btn btn-ripple inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-bold shadow-md">Sign Up</a>
                </div>
            <?php else: ?>
                <div class="hidden lg:flex flex-1 justify-center">
                    <div id="primary-nav" class="font-display flex items-center gap-8 xl:gap-10 text-[11px] font-semibold uppercase tracking-[0.14em]">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $studentItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $isActive = request()->routeIs($item['active']);
                            ?>
                            <a href="<?php echo e($item['route']); ?>" class="nav-link <?php echo e($isActive ? 'active' : ''); ?>" title="<?php echo e($item['label']); ?>">
                                <?php echo e($item['label']); ?>

                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <div class="hidden lg:flex items-center gap-2.5 shrink-0">
                    <form action="<?php echo e(route('courses.index')); ?>" method="GET" class="header-search relative flex items-center rounded-full border border-slate-600/60 bg-slate-950/30 px-3 py-2 w-[14rem] xl:w-[18rem]" aria-label="Search courses">
                        <i class="header-search-icon fas fa-search text-slate-400 text-sm" aria-hidden="true"></i>
                        <input type="search" name="search" placeholder="Search" class="ml-2.5 w-full bg-transparent text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none" aria-label="Search"/>
                    </form>
                    <a href="<?php echo e(route('notifications.index')); ?>" class="header-action-btn relative inline-flex h-11 w-11 items-center justify-center rounded-full bg-slate-900/90 text-slate-100 border border-slate-700/50" aria-label="Notifications">
                        <i class="fas fa-bell" aria-hidden="true"></i>
                        <span id="header-unread-badge" class="hidden absolute -top-1 -right-1 inline-flex items-center justify-center h-5 min-w-[1.25rem] px-1.5 rounded-full bg-rose-500 text-white text-xs font-bold">0</span>
                    </a>

                    <div id="header-user-wrap" class="relative header-user-menu">
                        <button
                            id="user-menu-toggle"
                            type="button"
                            class="header-action-btn inline-flex items-center gap-2 rounded-full bg-slate-900/90 border border-slate-700/50 px-4 py-2.5 text-sm font-semibold text-white focus:outline-none"
                            aria-haspopup="true"
                            aria-expanded="false"
                            aria-controls="user-menu"
                        >
                            <i class="fas fa-user-circle text-slate-300" aria-hidden="true"></i>
                            <span class="hidden xl:inline">Student Profile</span>
                            <i class="fas fa-chevron-down text-xs text-slate-400 header-menu-chevron" aria-hidden="true"></i>
                        </button>

                        <div id="user-menu" class="header-dropdown absolute right-0 top-full mt-2 min-w-[13rem] overflow-hidden rounded-2xl border border-slate-700/80 bg-[#0c2d4a] shadow-2xl shadow-black/40" role="menu" aria-label="Student profile menu">
                            <?php if (isset($component)) { $__componentOriginal42eaf3f6278d8222cdb4fe0aefac001c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal42eaf3f6278d8222cdb4fe0aefac001c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation.profile-dropdown','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation.profile-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42eaf3f6278d8222cdb4fe0aefac001c)): ?>
<?php $attributes = $__attributesOriginal42eaf3f6278d8222cdb4fe0aefac001c; ?>
<?php unset($__attributesOriginal42eaf3f6278d8222cdb4fe0aefac001c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42eaf3f6278d8222cdb4fe0aefac001c)): ?>
<?php $component = $__componentOriginal42eaf3f6278d8222cdb4fe0aefac001c; ?>
<?php unset($__componentOriginal42eaf3f6278d8222cdb4fe0aefac001c); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </nav>

    <span class="header-scanline" aria-hidden="true"></span>
</header>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/components/navigation/desktop.blade.php ENDPATH**/ ?>