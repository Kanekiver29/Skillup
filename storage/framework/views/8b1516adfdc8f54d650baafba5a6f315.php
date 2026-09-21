<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'SkillUp'); ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body class="bg-gray-50">
    <!-- Mobile Header -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow z-50">
        <div class="max-w-3xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <i class="fas fa-rocket text-purple-600 text-xl rocket-animate"></i>
                <a href="/" class="font-semibold text-lg text-gray-800">SkillUp</a>
            </div>
            <div class="flex items-center space-x-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="/dashboard" class="text-gray-700 hover:text-gray-900 text-xs font-medium transition" title="Dashboard">Dashboard</a>
                    <a href="<?php echo e(route('chats.index')); ?>" class="relative text-gray-700 hover:text-gray-900 transition" aria-label="Messages" title="Messages">
                        <i class="fas fa-bell"></i>
                        <span id="mobile-notification-badge" class="hiddenabsolute -top-2 -right-2 bg-red-500 text-white text-xs font-semibold rounded-fullmin-w-[20px] h-5 px-1.5 flex items-center justify-center"></span>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="/courses" class="text-gray-700 hover:text-gray-900 text-xs font-medium transition" title="Courses">Courses</a>
                <button id="mobile-menu-toggle" aria-label="Open menu" class="text-gray-700 hover:text-gray-900 transition">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Simplified Mobile Nav (slide-over) -->
    <div id="mobile-slide" class="fixed inset-0 z-40 hidden">
        <div class="absolute inset-0 bg-black/30" id="mobile-slide-backdrop"></div>
        <nav class="absolute left-0 top-0 bottom-0 w-64 bg-white p-4 overflow-auto">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-rocket text-purple-600 text-xl rocket-animate"></i>
                    <a href="/" class="font-semibold text-gray-800">SkillUp</a>
                </div>
                <button id="mobile-slide-close" class="text-gray-700"><i class="fas fa-times"></i></button>
            </div>
            <ul class="space-y-1">
                <li><a href="/" class="block py-3 px-3 text-gray-700 hover:text-gray-900 font-medium transition rounded-lg hover:bg-gray-50">Home</a></li>
                <li><a href="/courses" class="block py-3 px-3 text-gray-700 hover:text-gray-900 font-medium transition rounded-lg hover:bg-gray-50">Courses</a></li>
                <li><a href="/about" class="block py-3 px-3 text-gray-700 hover:text-gray-900 font-medium transition rounded-lg hover:bg-gray-50">About</a></li>
                <li><a href="/contact" class="block py-3 px-3 text-gray-700 hover:text-gray-900 font-medium transition rounded-lg hover:bg-gray-50">Contact</a></li>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <li class="border-t border-gray-200 pt-2 mt-2">
                        <a href="/login" class="flex items-center py-3 px-3 text-gray-700 hover:text-gray-900 font-medium transition rounded-lg hover:bg-gray-50">
                            <i class="fas fa-sign-in-alt w-5 mr-3 text-purple-600"></i>Login
                        </a>
                    </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <li class="border-t border-gray-200 pt-2 mt-2">
                        <a href="/dashboard" class="flex items-center py-3 px-3 text-gray-700 hover:text-gray-900 font-medium transition rounded-lg hover:bg-gray-50">
                            <i class="fas fa-tachometer-alt w-5 mr-3 text-purple-600"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('chats.index')); ?>" class="flex items-center py-3 px-3 text-gray-700 hover:text-gray-900 font-medium transition rounded-lg hover:bg-gray-50">
                            <i class="fas fa-comment-alt w-5 mr-3 text-purple-600"></i>Messages
                            <span id="mobile-menu-notification-badge" class="hiddenml-auto bg-red-500 text-white text-xs font-semibold rounded-fullmin-w-[20px] h-5 px-1.5 flexitems-center justify-center"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/profile" class="flex items-center py-2 text-gray-700">
                            <i class="fas fa-user-circle w-5 mr-2 text-purple-600"></i>Profile
                        </a>
                    </li>
                    <li>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full flex items-center text-left py-2 text-gray-700">
                                <i class="fas fa-sign-out-alt w-5 mr-2 text-purple-600"></i>Logout
                            </button>
                        </form>
                    </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </nav>
    </div>

    <main class="pt-16 px-4">
        <div class="max-w-3xl mx-auto">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <footer class="mt-12 bg-gray-800 text-gray-300 py-6 px-4">
        <div class="max-w-3xl mx-auto text-center text-sm">
            &copy; 2026 SkillUp. All rights reserved.
        </div>
    </footer>

    <script>
        // Minimal mobile slide toggle (keeps behavior local to this layout)
        document.addEventListener('DOMContentLoaded', function(){
            const open = document.getElementById('mobile-menu-toggle');
            const close = document.getElementById('mobile-slide-close');
            const slide = document.getElementById('mobile-slide');
            const backdrop = document.getElementById('mobile-slide-backdrop');

            function show(){ if(slide) slide.classList.remove('hidden'); }
            function hide(){ if(slide) slide.classList.add('hidden'); }

            if(open) open.addEventListener('click', (e)=>{ e.preventDefault(); show(); });
            if(close) close.addEventListener('click', (e)=>{ e.preventDefault(); hide(); });
            if(backdrop) backdrop.addEventListener('click', hide);
            document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') hide(); });

            <?php if(auth()->guard()->check()): ?>
            function refreshMobileNotifications(){
                fetch('<?php echo e(route("chats.notifications")); ?>')
                    .then(r => r.json())
                    .then(data => {
                        const count = Number(data.unread || 0);
                        const badges = [
                            document.getElementById('mobile-notification-badge'),
                            document.getElementById('mobile-menu-notification-badge')
                        ];
                        badges.forEach((badge) => {
                            if(!badge) return;
                            if(count > 0){
                                badge.textContent = count;
                                badge.classList.remove('hidden');
                            } else {
                                badge.classList.add('hidden');
                            }
                        });
                    })
                    .catch(() => {});
            }

            refreshMobileNotifications();
            setInterval(refreshMobileNotifications, 10000);
            <?php endif; ?>
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\layout\User\mobile.blade.php ENDPATH**/ ?>