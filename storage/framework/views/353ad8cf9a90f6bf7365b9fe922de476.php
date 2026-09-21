

<?php $__env->startSection('title', $portal === 'sias-admin' ? 'SIAS Administrator Login' : 'Course Login'); ?>

<?php $__env->startSection('auth-content'); ?>
<div class="min-h-screen flex items-center justify-center bg-slate-100 px-4 py-10">
    <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl ring-1 ring-slate-200">
        <div class="mb-8 text-center">
            <img src="<?php echo e(asset('image/logo new.jpg')); ?>" alt="SkillUp" class="mx-auto mb-4 h-16 w-16 rounded-xl object-cover">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-cyan-700"><?php echo e($portal === 'sias-admin' ? 'SIAS Administration' : 'SkillUp Courses'); ?></p>
            <h1 class="mt-2 text-2xl font-bold text-slate-900"><?php echo e($portal === 'sias-admin' ? 'Administrator sign in' : 'Course sign in'); ?></h1>
            <p class="mt-2 text-sm text-slate-500">Use your existing account. One account works across both portals.</p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="mb-5 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700" role="alert">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <p><?php echo e($error); ?></p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="<?php echo e($portal === 'sias-admin' ? route('sias.admin.login.submit') : route('course.login.submit')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>
            <div>
                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email address</label>
                <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" class="w-full rounded-lg border border-slate-300 px-3 py-3 text-slate-900 outline-none transition focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-lg border border-slate-300 px-3 py-3 text-slate-900 outline-none transition focus:border-cyan-600 focus:ring-4 focus:ring-cyan-100">
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-cyan-700 focus:ring-cyan-600">
                Remember this account
            </label>
            <button type="submit" class="w-full rounded-lg bg-cyan-700 px-4 py-3 font-semibold text-white transition hover:bg-cyan-800 focus:outline-none focus:ring-4 focus:ring-cyan-200">
                Sign in to <?php echo e($portal === 'sias-admin' ? 'SIAS Admin' : 'Courses'); ?>

            </button>
        </form>

        <div class="mt-6 flex justify-between text-sm">
            <a href="<?php echo e($portal === 'sias-admin' ? route('course.login') : route('sias.admin.login')); ?>" class="font-semibold text-cyan-700 hover:text-cyan-900">
                <?php echo e($portal === 'sias-admin' ? 'Course login' : 'SIAS admin login'); ?>

            </a>
            <a href="<?php echo e(route('login')); ?>" class="text-slate-500 hover:text-slate-800">Other login</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\auth\portal-login.blade.php ENDPATH**/ ?>