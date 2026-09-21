<div class="py-2" role="menuitem">
    <a href="<?php echo e(route('userpage.profile')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80 transition-colors">
        <i class="fas fa-user-circle text-cyan-300 w-4 text-center" aria-hidden="true"></i>
        <span>My Profile</span>
    </a>
    <a href="<?php echo e(route('courses.my-learning')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80 transition-colors">
        <i class="fas fa-book-open text-cyan-300 w-4 text-center" aria-hidden="true"></i>
        <span>My Learning</span>
    </a>
    <a href="<?php echo e(route('grades')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80 transition-colors">
        <i class="fas fa-chart-line text-cyan-300 w-4 text-center" aria-hidden="true"></i>
        <span>Grades</span>
    </a>
    <a href="<?php echo e(route('certificates.index')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80 transition-colors">
        <i class="fas fa-award text-cyan-300 w-4 text-center" aria-hidden="true"></i>
        <span>Certificates</span>
    </a>
    <a href="<?php echo e(route('user.settings')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80 transition-colors">
        <i class="fas fa-sliders-h text-cyan-300 w-4 text-center" aria-hidden="true"></i>
        <span>Settings</span>
    </a>
    <a href="<?php echo e(route('help.index')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-200 hover:bg-slate-800/80 transition-colors">
        <i class="fas fa-circle-question text-cyan-300 w-4 text-center" aria-hidden="true"></i>
        <span>Help &amp; Support</span>
    </a>
    <div class="border-t border-slate-700/80 mt-2 pt-2">
        <form action="<?php echo e(route('logout')); ?>" method="POST" class="px-2">
            <?php echo csrf_field(); ?>
            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-red-400 hover:bg-red-950/40 hover:text-red-300 transition-colors">
                <i class="fas fa-right-from-bracket w-4 text-center" aria-hidden="true"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\components\navigation\profile-dropdown.blade.php ENDPATH**/ ?>