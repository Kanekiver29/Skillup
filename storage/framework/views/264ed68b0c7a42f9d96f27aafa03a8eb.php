<?php
    $bottomItems = [
        ['label' => 'Home', 'route' => route('home'), 'icon' => 'fas fa-house', 'active' => 'home'],
        ['label' => 'Courses', 'route' => route('courses.index'), 'icon' => 'fas fa-book-open', 'active' => 'courses.*'],
        ['label' => 'My Learning', 'route' => route('courses.my-learning'), 'icon' => 'fas fa-graduation-cap', 'active' => 'courses.my-learning'],
        ['label' => 'Notifications', 'route' => route('notifications.index'), 'icon' => 'fas fa-bell', 'active' => 'notifications.index'],
    ];
?>

<div x-data="{ openMore: false }" class="lg:hidden">
    <header class="fixed inset-x-0 top-0 z-40 border-b border-slate-800/80 bg-[#050e1c]/90 px-4 pb-3 pt-4 backdrop-blur-xl">
        <div class="flex items-center justify-between gap-3">
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 text-white" aria-label="SkillUp Home">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl border border-cyan-400/30 bg-slate-900/80 shadow-[0_0_18px_rgba(0,217,255,0.25)]">
                    <svg viewBox="0 0 26 26" fill="none" style="width:18px;height:18px" aria-hidden="true">
                        <g>
                            <ellipse cx="13" cy="22.5" rx="3.5" ry="3" fill="rgba(0,230,255,0.9)"/>
                            <ellipse cx="13" cy="23" rx="2" ry="1.8" fill="rgba(253,185,19,0.85)"/>
                        </g>
                        <path d="M13 3C9 3 7 8 7 13L7 18C7 18 9.5 19.5 13 19.5C16.5 19.5 19 18 19 18L19 13C19 8 17 3 13 3Z" fill="white" opacity="0.95"/>
                        <circle cx="13" cy="11" r="2.5" fill="rgba(0,58,143,0.75)" stroke="rgba(0,230,255,0.55)" stroke-width="0.5"/>
                        <circle cx="13" cy="11" r="1" fill="rgba(120,215,255,0.95)"/>
                    </svg>
                </span>
                <span class="text-sm font-black uppercase tracking-[0.18em] text-cyan-100">SkillUp</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="<?php echo e(auth()->check() ? route('notifications.index') : route('login')); ?>" class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-700/70 bg-slate-900/80 text-slate-100 shadow-sm" aria-label="Notifications">
                    <i class="fas fa-bell text-sm" aria-hidden="true"></i>
                </a>
                <a href="<?php echo e(auth()->check() ? route('userpage.profile') : route('login')); ?>" class="flex h-10 w-10 items-center justify-center rounded-full border border-cyan-400/40 bg-slate-900/80 text-cyan-200 shadow-[0_0_18px_rgba(0,217,255,0.2)]" aria-label="Profile">
                    <i class="fas fa-user text-sm" aria-hidden="true"></i>
                </a>
                <button id="nav-toggle" type="button" class="header-nav-toggle flex h-10 w-10 items-center justify-center rounded-full border border-slate-700/70 bg-slate-900/80 text-slate-100 shadow-sm" aria-label="Open menu" aria-expanded="false">
                    <i id="nav-open-icon" class="fas fa-bars text-sm" aria-hidden="true"></i>
                    <i id="nav-close-icon" class="fas fa-times text-sm hidden" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>

    <div id="mobile-nav" class="mobile-nav-panel fixed inset-x-0 top-[76px] bottom-0 z-30 bg-[#071625]/95 backdrop-blur-xl border-t border-cyan-400/10 shadow-2xl shadow-black/30 overflow-y-auto">
        <div class="hud-grid absolute inset-0 pointer-events-none" aria-hidden="true"></div>
        <div class="relative px-4 py-5 space-y-2.5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                    ['label' => 'Home', 'route' => route('home'), 'active' => 'home'],
                    ['label' => 'About', 'route' => route('about'), 'active' => 'about'],
                    ['label' => 'Courses', 'route' => route('courses.index'), 'active' => 'courses.*'],
                    ['label' => 'News', 'route' => route('news'), 'active' => 'news*'],
                    ['label' => 'Contact', 'route' => route('contact'), 'active' => 'contact'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <a href="<?php echo e($item['route']); ?>" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80 <?php echo e(request()->routeIs($item['active']) ? 'active' : ''); ?>"><?php echo e($item['label']); ?></a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <a href="<?php echo e(route('login')); ?>" class="mobile-nav-link block rounded-2xl border border-slate-700/80 bg-slate-900/60 px-4 py-3.5 text-sm font-semibold text-slate-100 text-center">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="mobile-nav-link header-signup-btn block rounded-2xl px-4 py-3.5 text-sm font-bold text-center shadow-md">Sign Up Free</a>
            <?php else: ?>
                <a href="<?php echo e(route('home')); ?>" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80 <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Home</a>
                <a href="<?php echo e(route('courses.index')); ?>" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80 <?php echo e(request()->routeIs('courses.*') ? 'active' : ''); ?>">Courses</a>
                <a href="<?php echo e(route('courses.my-learning')); ?>" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80 <?php echo e(request()->routeIs('courses.my-learning') ? 'active' : ''); ?>">My Learning</a>
                <a href="<?php echo e(route('grades')); ?>" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80 <?php echo e(request()->routeIs('grades') ? 'active' : ''); ?>">Grades</a>
                <a href="<?php echo e(route('news')); ?>" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80 <?php echo e(request()->routeIs('news*') ? 'active' : ''); ?>">News</a>
                <a href="<?php echo e(route('userpage.profile')); ?>" class="mobile-nav-link block rounded-2xl border border-slate-800/80 bg-slate-950/40 px-4 py-3.5 text-sm font-semibold text-slate-100 hover:bg-slate-900/80 <?php echo e(request()->routeIs('userpage.profile*') ? 'active' : ''); ?>">Student Profile</a>
                <div class="pt-2">
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="block">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="header-action-btn w-full rounded-2xl bg-red-600/90 px-4 py-3.5 text-sm font-semibold text-white hover:bg-red-600 border border-red-500/30">Logout</button>
                    </form>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <nav aria-label="Mobile navigation" class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-800/80 bg-[#071625]/95 px-3 pb-[calc(env(safe-area-inset-bottom)+0.9rem)] pt-2 backdrop-blur-xl shadow-[0_-12px_32px_rgba(2,6,23,0.7)]">
        <div class="grid grid-cols-5 gap-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $bottomItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $isActive = request()->routeIs($item['active']);
                ?>
                <a href="<?php echo e($item['route']); ?>" class="group flex flex-col items-center justify-center gap-1 rounded-2xl px-2 py-2.5 text-[10px] font-semibold uppercase tracking-[0.08em] transition-all duration-200 <?php echo e($isActive ? 'text-cyan-300 bg-cyan-500/10 shadow-[0_0_18px_rgba(0,217,255,0.18)]' : 'text-slate-400 hover:text-slate-200'); ?>" aria-current="<?php echo e($isActive ? 'page' : 'false'); ?>">
                    <i class="<?php echo e($item['icon']); ?> text-base <?php echo e($isActive ? 'text-cyan-300' : 'text-slate-400 group-hover:text-cyan-300'); ?>" aria-hidden="true"></i>
                    <span><?php echo e($item['label']); ?></span>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <button type="button" x-on:click="openMore = !openMore" x-bind:aria-expanded="openMore.toString()" x-bind:aria-label="openMore ? 'Close more menu' : 'Open more menu'" class="group flex flex-col items-center justify-center gap-1 rounded-2xl px-2 py-2.5 text-[10px] font-semibold uppercase tracking-[0.08em] transition-all duration-200 <?php echo e(request()->routeIs(['about', 'user.settings', 'help.index', 'grades', 'userpage.profile']) ? 'text-cyan-300 bg-cyan-500/10 shadow-[0_0_18px_rgba(0,217,255,0.18)]' : 'text-slate-400 hover:text-slate-200'); ?>" aria-label="Open more menu" aria-expanded="false">
                <i class="fas fa-ellipsis text-base <?php echo e(request()->routeIs(['about', 'user.settings', 'help.index', 'grades', 'userpage.profile']) ? 'text-cyan-300' : 'text-slate-400 group-hover:text-cyan-300'); ?>" aria-hidden="true"></i>
                <span>More</span>
            </button>
        </div>
    </nav>

    <div x-show="openMore" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-full opacity-0" class="fixed inset-x-0 bottom-[5.2rem] z-50 mx-auto w-[92%] max-w-md rounded-[28px] border border-slate-700/80 bg-[#091827]/95 p-3 shadow-2xl shadow-black/50 backdrop-blur-xl" role="dialog" aria-modal="true" aria-label="More menu">
        <div class="mb-3 flex items-center justify-between border-b border-slate-700/80 px-2 pb-3">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-cyan-300">More</p>
            <button type="button" x-on:click="openMore = false" class="flex h-8 w-8 items-center justify-center rounded-full border border-slate-700 bg-slate-900/80 text-slate-300" aria-label="Close more menu">
                <i class="fas fa-xmark text-sm" aria-hidden="true"></i>
            </button>
        </div>

        <div class="space-y-1">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('userpage.profile')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-user text-cyan-300 w-5"></i> Profile </a>
                <a href="<?php echo e(route('grades')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-chart-line text-cyan-300 w-5"></i> Grades </a>
                <a href="<?php echo e(route('certificates.index')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-award text-cyan-300 w-5"></i> Certificates </a>
                <a href="<?php echo e(route('news')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-newspaper text-cyan-300 w-5"></i> News </a>
                <a href="<?php echo e(route('about')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-circle-info text-cyan-300 w-5"></i> About SkillUp </a>
                <a href="<?php echo e(route('user.settings')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-gear text-cyan-300 w-5"></i> Settings </a>
                <a href="<?php echo e(route('help.index')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-circle-question text-cyan-300 w-5"></i> Help &amp; Support </a>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="pt-2">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-sm text-red-400 hover:bg-red-950/40"> <i class="fas fa-right-from-bracket w-5"></i> Logout </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-right-to-bracket text-cyan-300 w-5"></i> Login </a>
                <a href="<?php echo e(route('register')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-user-plus text-cyan-300 w-5"></i> Sign Up </a>
                <a href="<?php echo e(route('about')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-circle-info text-cyan-300 w-5"></i> About SkillUp </a>
                <a href="<?php echo e(route('news')); ?>" class="flex items-center gap-3 rounded-2xl px-3 py-3 text-sm text-slate-100 hover:bg-slate-800/80"> <i class="fas fa-newspaper text-cyan-300 w-5"></i> News </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/components/navigation/mobile.blade.php ENDPATH**/ ?>