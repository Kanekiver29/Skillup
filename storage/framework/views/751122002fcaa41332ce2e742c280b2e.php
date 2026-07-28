

<?php $__env->startSection('title', 'Settings - SkillUp Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <div class="bg-white border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">Settings</span>
                </nav>
            </div>
            <div class="p-2 bg-cyan-100 rounded-md">
                <i class="fas fa-cog text-cyan-600"></i>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <?php if(session('success')): ?>
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-5 py-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg px-5 py-4">
                <div class="flex items-center gap-2 mb-2 font-semibold">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    Please fix the following errors:
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div x-data="{ tab: 'general' }" class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="flex overflow-x-auto border-b border-gray-200">
                    <button @click="tab = 'general'" :class="tab === 'general' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium">General</button>
                    <button @click="tab = 'email'" :class="tab === 'email' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium">Email</button>
                    <button @click="tab = 'security'" :class="tab === 'security' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium">Security</button>
                    <button @click="tab = 'system'" :class="tab === 'system' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium">System</button>
                    <button @click="tab = 'maintenance'" :class="tab === 'maintenance' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-3 text-sm font-medium">Maintenance</button>
                </div>
            </div>

            
            <div x-show="tab === 'general'" x-transition>
                <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" class="ajax-settings-form" id="generalSettingsForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="section" value="general">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6 space-y-4">
                            <h2 class="text-lg font-semibold">Application Identity</h2>
                            <div class="space-y-4">
                                <div>
                                    <label for="app_name" class="block text-sm font-medium text-gray-700">Application Name</label>
                                    <input id="app_name" name="app_name" value="<?php echo e(old('app_name', $settings['app_name'])); ?>" required maxlength="100" class="w-full rounded-lg border border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500">
                                </div>
                                <div>
                                    <label for="app_url" class="block text-sm font-medium text-gray-700">Application URL</label>
                                    <input id="app_url" name="app_url" type="url" value="<?php echo e(old('app_url', $settings['app_url'])); ?>" required maxlength="255" class="w-full rounded-lg border border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500">
                                </div>
                                <div>
                                    <label for="session_lifetime" class="block text-sm font-medium text-gray-700">Session Lifetime (minutes)</label>
                                    <input id="session_lifetime" name="session_lifetime" type="number" value="<?php echo e(old('session_lifetime', $settings['session_lifetime'])); ?>" required min="1" max="10080" class="w-full rounded-lg border border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500">
                                    <p class="text-xs text-gray-500 mt-1">Max 10080 minutes (7 days).</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                                <h3 class="text-sm font-semibold text-gray-700">Environment Info</h3>
                                <dl class="mt-3 text-sm space-y-3">
                                    <div class="flex justify-between"><dt class="text-gray-500">Environment</dt><dd class="font-medium"><?php echo e(ucfirst($settings['app_env'])); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Debug</dt><dd class="font-medium"><?php echo e($settings['app_debug'] ? 'ON' : 'OFF'); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Cache Driver</dt><dd class="font-medium"><?php echo e(ucfirst($settings['cache_driver'])); ?></dd></div>
                                    <div class="flex justify-between"><dt class="text-gray-500">Session Driver</dt><dd class="font-medium"><?php echo e(ucfirst($settings['session_driver'])); ?></dd></div>
                                </dl>
                            </div>
                            <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 text-sm text-cyan-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Changes are written to <code>.env</code> and config cache is cleared.
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg text-sm">Save General Settings</button>
                    </div>
                </form>
            </div>

            
            <div x-show="tab === 'email'" x-transition>
                <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" class="ajax-settings-form" id="emailSettingsForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="section" value="email">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 space-y-4">
                        <h2 class="text-lg font-semibold">Email Configuration</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Mail Driver</label>
                                <input type="text" value="<?php echo e(ucfirst($settings['mail_mailer'])); ?>" disabled class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2 text-sm cursor-not-allowed">
                            </div>
                            <div>
                                <label for="mail_from_address" class="block text-sm font-medium text-gray-700">From Address</label>
                                <input id="mail_from_address" name="mail_from_address" type="email" value="<?php echo e(old('mail_from_address', $settings['mail_from_address'])); ?>" required class="w-full rounded-lg border border-gray-200 px-4 py-2 text-sm">
                            </div>
                            <div>
                                <label for="mail_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                                <input id="mail_from_name" name="mail_from_name" value="<?php echo e(old('mail_from_name', $settings['mail_from_name'])); ?>" required class="w-full rounded-lg border border-gray-200 px-4 py-2 text-sm">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg text-sm">Save Email Settings</button>
                        </div>
                    </div>
                </form>
            </div>

            
            <div x-show="tab === 'security'" x-transition>
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold">Security Overview</h2>
                    <p class="text-sm text-gray-500 mt-2">Read-only security details for the installation.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                        <div class="p-4 rounded-lg border <?php echo e($settings['app_debug'] ? 'border-red-200 bg-red-50' : 'border-green-200 bg-green-50'); ?>">
                            <div class="flex items-center gap-3 mb-2"><i class="fas <?php echo e($settings['app_debug'] ? 'fa-exclamation-triangle text-red-500' : 'fa-check-circle text-green-500'); ?>"></i><span class="font-semibold">Debug Mode</span></div>
                            <p class="text-sm"><?php echo e($settings['app_debug'] ? 'Debug is ON — disable in production.' : 'Debug is OFF.'); ?></p>
                        </div>
                        <div class="p-4 rounded-lg border <?php echo e($settings['app_env'] === 'production' ? 'border-green-200 bg-green-50' : 'border-yellow-200 bg-yellow-50'); ?>">
                            <div class="flex items-center gap-3 mb-2"><i class="fas <?php echo e($settings['app_env'] === 'production' ? 'fa-check-circle text-green-500' : 'fa-info-circle text-yellow-500'); ?>"></i><span class="font-semibold">Environment</span></div>
                            <p class="text-sm">Running in <strong><?php echo e(ucfirst($settings['app_env'])); ?></strong> mode.</p>
                        </div>
                        <div class="p-4 rounded-lg border <?php echo e(str_starts_with($settings['app_url'], 'https') ? 'border-green-200 bg-green-50' : 'border-yellow-200 bg-yellow-50'); ?>">
                            <div class="flex items-center gap-3 mb-2"><i class="fas <?php echo e(str_starts_with($settings['app_url'], 'https') ? 'fa-lock text-green-500' : 'fa-lock-open text-yellow-500'); ?>"></i><span class="font-semibold">HTTPS</span></div>
                            <p class="text-sm"><?php echo e(str_starts_with($settings['app_url'], 'https') ? 'HTTPS is enabled.' : 'HTTPS not detected.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div x-show="tab === 'system'" x-transition>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold">PHP Environment</h2>
                        <dl class="mt-4 text-sm space-y-3">
                            <div class="flex justify-between"><dt class="text-gray-500">PHP Version</dt><dd class="font-medium"><?php echo e(PHP_VERSION); ?></dd></div>
                            <div class="flex justify-between"><dt class="text-gray-500">Laravel Version</dt><dd class="font-medium"><?php echo e(app()->version()); ?></dd></div>
                            <div class="flex justify-between"><dt class="text-gray-500">Server OS</dt><dd class="font-medium"><?php echo e(PHP_OS); ?></dd></div>
                            <div class="flex justify-between"><dt class="text-gray-500">Memory Limit</dt><dd class="font-medium"><?php echo e(ini_get('memory_limit')); ?></dd></div>
                        </dl>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold">Cache Management</h2>
                        <p class="text-sm text-gray-500 mt-2">Clear Laravel caches after deployments.</p>
                        <div class="mt-4 space-y-3">
                            <form action="<?php echo e(route('admin.settings.cache.clear')); ?>" method="POST" class="ajax-action-form" data-action-type="config"><?php echo csrf_field(); ?><input type="hidden" name="type" value="config"><button type="submit" class="w-full text-left px-4 py-3 rounded-lg border bg-gray-50">Config Cache <span class="text-xs text-gray-400 float-right">php artisan config:clear</span></button></form>
                            <form action="<?php echo e(route('admin.settings.cache.clear')); ?>" method="POST" class="ajax-action-form" data-action-type="route"><?php echo csrf_field(); ?><input type="hidden" name="type" value="route"><button type="submit" class="w-full text-left px-4 py-3 rounded-lg border bg-gray-50">Route Cache <span class="text-xs text-gray-400 float-right">php artisan route:clear</span></button></form>
                            <form action="<?php echo e(route('admin.settings.cache.clear')); ?>" method="POST" class="ajax-action-form" data-action-type="view"><?php echo csrf_field(); ?><input type="hidden" name="type" value="view"><button type="submit" class="w-full text-left px-4 py-3 rounded-lg border bg-gray-50">View Cache <span class="text-xs text-gray-400 float-right">php artisan view:clear</span></button></form>
                            <form action="<?php echo e(route('admin.settings.cache.clear')); ?>" method="POST" class="ajax-action-form" data-action-type="all"><?php echo csrf_field(); ?><input type="hidden" name="type" value="all"><button type="submit" onclick="return confirm('Clear ALL caches?')" class="w-full text-left px-4 py-3 rounded-lg border bg-red-50 text-red-700">Clear All <span class="text-xs float-right">config + route + view</span></button></form>
                        </div>
                    </div>
                </div>
            </div>

            
            <div x-show="tab === 'maintenance'" x-transition>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold">Maintenance Mode</h2>
                        <p class="text-sm text-gray-500 mt-2">Take the application offline for updates.</p>
                        <form action="<?php echo e(route('admin.settings.maintenance')); ?>" method="POST" class="mt-4 ajax-action-form" data-action-type="maintenance"><?php echo csrf_field(); ?><button type="submit" onclick="return confirm('<?php echo e(app()->isDownForMaintenance() ? 'Bring application online?' : 'Enable maintenance mode?'); ?>')" class="w-full px-4 py-3 rounded-lg <?php echo e(app()->isDownForMaintenance() ? 'bg-green-600 text-white' : 'bg-red-600 text-white'); ?>"><?php echo e(app()->isDownForMaintenance() ? 'Disable Maintenance Mode' : 'Enable Maintenance Mode'); ?></button></form>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5">
                            <h3 class="font-semibold text-yellow-800">Before Enabling</h3>
                            <ul class="text-sm text-yellow-700 list-disc list-inside mt-2">
                                <li>Public visitors will see a 503 page.</li>
                                <li>Logged-in admins are not affected.</li>
                                <li>Queued jobs continue to run.</li>
                            </ul>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-5">
                            <h3 class="font-semibold text-blue-800">Server Details</h3>
                            <dl class="mt-2 text-sm">
                                <div class="flex justify-between"><dt>Server Time</dt><dd><?php echo e(now()->format('d M Y, H:i:s')); ?> UTC</dd></div>
                                <div class="flex justify-between"><dt>App Timezone</dt><dd><?php echo e(config('app.timezone')); ?></dd></div>
                                <div class="flex justify-between"><dt>PHP Version</dt><dd><?php echo e(PHP_VERSION); ?></dd></div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const meta = document.querySelector('meta[name="csrf-token"]');
    const csrf = meta ? meta.getAttribute('content') : '';

    function clearErrors(form) {
        form.querySelectorAll('.field-error').forEach(el => el.remove());
    }

    function showErrors(form, errors) {
        for (const key in errors) {
            const field = form.querySelector('[name="' + key + '"]');
            const msgs = errors[key];
            if (field) {
                const wrap = document.createElement('p');
                wrap.className = 'field-error text-red-700 text-sm mt-1';
                wrap.textContent = msgs.join(' ');
                field.insertAdjacentElement('afterend', wrap);
            }
        }
    }

    function showSuccess(message) {
        const container = document.querySelector('.max-w-7xl');
        const existing = document.querySelector('.ajax-success-banner');
        if (existing) existing.remove();
        const el = document.createElement('div');
        el.className = 'ajax-success-banner mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-5 py-3';
        el.innerHTML = '<i class="fas fa-check-circle text-green-500"></i><span>' + (message || 'Saved successfully.') + '</span>';
        if (container && container.parentNode) container.parentNode.insertBefore(el, container);
        setTimeout(() => el.remove(), 4500);
    }

    async function submitFormAJAX(form) {
        clearErrors(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        const formData = new FormData(form);
        const methodInput = form.querySelector('input[name="_method"]');
        const method = methodInput ? methodInput.value.toUpperCase() : (form.method || 'POST').toUpperCase();

        try {
            const res = await fetch(form.action, {
                method: method === 'GET' ? 'GET' : 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (submitBtn) submitBtn.disabled = false;

            if (res.status === 422) {
                const data = await res.json().catch(() => null);
                if (data && data.errors) showErrors(form, data.errors);
                return { ok: false };
            }

            if (res.ok) {
                let data = null;
                try { data = await res.json(); } catch (e) { /* ignore */ }
                showSuccess((data && data.message) ? data.message : 'Saved successfully.');
                return { ok: true, data };
            }

            return { ok: false };
        } catch (err) {
            if (submitBtn) submitBtn.disabled = false;
            console.error(err);
            return { ok: false };
        }
    }

    document.querySelectorAll('.ajax-settings-form').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            submitFormAJAX(form);
        });
    });

    document.querySelectorAll('.ajax-action-form').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            submitFormAJAX(form);
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/Admin/settings.blade.php ENDPATH**/ ?>