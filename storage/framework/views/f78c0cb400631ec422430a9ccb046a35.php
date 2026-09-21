

<?php $__env->startSection('title', 'My Profile - SkillUp Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">

    
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-cyan-600">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-700 font-medium">My Profile</span>
                </nav>
            </div>
            <div class="p-3 bg-cyan-100 rounded-lg">
                <i class="fas fa-user-circle text-cyan-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-5 py-4">
                <i class="fas fa-check-circle text-green-500 text-lg shrink-0"></i>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg px-5 py-4">
                <div class="flex items-center gap-2 mb-2 font-semibold">
                    <i class="fas fa-exclamation-circle text-red-500 shrink-0"></i>
                    Please fix the following errors:
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($error); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div x-data="{ activeTab: 'profile', showCurrentPassword: false, showNewPassword: false, showConfirmPassword: false }" class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="flex overflow-x-auto border-b border-gray-200">
                    <button @click="activeTab = 'profile'"
                            :class="activeTab === 'profile' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'"
                            class="px-6 py-4 text-sm font-medium whitespace-nowrap transition">
                        <i class="fas fa-user mr-2"></i> Profile
                    </button>
                    <button @click="activeTab = 'edit'"
                            :class="activeTab === 'edit' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'"
                            class="px-6 py-4 text-sm font-medium whitespace-nowrap transition">
                        <i class="fas fa-pen mr-2"></i> Edit Profile
                    </button>
                    <button @click="activeTab = 'password'"
                            :class="activeTab === 'password' ? 'border-b-2 border-cyan-500 text-cyan-600' : 'text-gray-500 hover:text-gray-700'"
                            class="px-6 py-4 text-sm font-medium whitespace-nowrap transition">
                        <i class="fas fa-lock mr-2"></i> Change Password
                    </button>
                </div>
            </div>

            
            <div x-show="activeTab === 'profile'" x-transition>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 text-center">
                        <div class="relative inline-block mb-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile_image): ?>
                                <img src="<?php echo e(asset('uploads/profiles/' . $user->profile_image)); ?>"
                                     alt="<?php echo e($user->name); ?>"
                                     class="w-28 h-28 rounded-full object-cover border-4 border-cyan-100 mx-auto">
                            <?php else: ?>
                                <div class="w-28 h-28 rounded-full bg-gradient-to-brfrom-cyan-500 to-blue-600 flex items-center justify-center mx-auto border-4 border-cyan-100">
                                    <span class="text-white text-3xl font-bold"><?php echo e(strtoupper(substr($user->name, 0, 2))); ?></span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900"><?php echo e($user->name); ?></h2>
                        <p class="text-sm text-gray-500 mt-1"><?php echo e($user->email); ?></p>

                        
                        <div class="mt-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->is_admin): ?>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-shield-alt"></i> Administrator
                                </span>
                            <?php elseif($user->isStaff()): ?>
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    <i class="fas fa-user-tie"></i> <?php echo e($user->staffTypeLabel()); ?>

                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->bio): ?>
                            <p class="text-sm text-gray-600 mt-4 leading-relaxed"><?php echo e($user->bio); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->location): ?>
                            <p class="text-sm text-gray-500 mt-3">
                                <i class="fas fa-map-marker-alt text-cyan-500 mr-1"></i> <?php echo e($user->location); ?>

                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->github_url || $user->linkedin_url || $user->twitter_url || $user->portfolio_url): ?>
                            <div class="flex items-center justify-center gap-3 mt-4 pt-4 border-t border-gray-100">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->github_url): ?>
                                    <a href="<?php echo e($user->github_url); ?>" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-800 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fab fa-github"></i>
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->linkedin_url): ?>
                                    <a href="<?php echo e($user->linkedin_url); ?>" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->twitter_url): ?>
                                    <a href="<?php echo e($user->twitter_url); ?>" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-sky-500 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->portfolio_url): ?>
                                    <a href="<?php echo e($user->portfolio_url); ?>" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-cyan-600 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="lg:col-span-2 space-y-6">

                        
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-id-card text-cyan-500 mr-2"></i> Account Information
                            </h3>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium"><?php echo e($user->name); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium"><?php echo e($user->email); ?></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Role</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium">
                                        <?php echo e($user->is_admin ? 'Administrator' : ($user->isStaff() ? $user->staffTypeLabel() : 'User')); ?>

                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Member Since</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium"><?php echo e($user->created_at->format('F j, Y')); ?></dd>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->lrn): ?>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">LRN</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium"><?php echo e($user->lrn); ?></dd>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Profile Visibility</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium <?php echo e($user->profile_public ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'); ?>">
                                            <i class="fas <?php echo e($user->profile_public ? 'fa-eye' : 'fa-eye-slash'); ?> text-xs"></i>
                                            <?php echo e($user->profile_public ? 'Public' : 'Private'); ?>

                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->skills && count($user->skills) > 0): ?>
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-tools text-cyan-500 mr-2"></i> Skills
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $user->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-cyan-50 text-cyan-700 border border-cyan-200">
                                        <?php echo e($skill); ?>

                                    </span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-bolt text-cyan-500 mr-2"></i> Quick Actions
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <button @click="activeTab = 'edit'"
                                        class="flex items-center gap-2 px-4 py-3 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 rounded-lg transition text-sm font-medium">
                                    <i class="fas fa-pen"></i> Edit Profile
                                </button>
                                <button @click="activeTab = 'password'"
                                        class="flex items-center gap-2 px-4 py-3 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition text-sm font-medium">
                                    <i class="fas fa-key"></i> Change Password
                                </button>
                                <a href="<?php echo e(route('admin.settings')); ?>"
                                   class="flex items-center gap-2 px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition text-sm font-medium">
                                    <i class="fas fa-cog"></i> System Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div x-show="activeTab === 'edit'" x-transition>
                <form action="<?php echo e(route('admin.profile.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Profile Photo</h3>
                            <div class="text-center" x-data="{ preview: null }">
                                <div class="mb-4">
                                    <template x-if="preview">
                                        <img :src="preview" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-cyan-100">
                                    </template>
                                    <template x-if="!preview">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->profile_image): ?>
                                            <img src="<?php echo e(asset('uploads/profiles/' . $user->profile_image)); ?>"
                                                 alt="<?php echo e($user->name); ?>"
                                                 class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-cyan-100">
                                        <?php else: ?>
                                            <div class="w-32 h-32 rounded-full bg-gradient-to-brfrom-cyan-500 to-blue-600 flex items-center justify-center mx-auto border-4 border-cyan-100">
                                                <span class="text-white text-4xl font-bold"><?php echo e(strtoupper(substr($user->name, 0, 2))); ?></span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </template>
                                </div>
                                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 rounded-lg transition text-sm font-medium">
                                    <i class="fas fa-camera"></i> Choose Photo
                                    <input type="file" name="profile_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="hidden"
                                           @change="if ($event.target.files[0]) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL($event.target.files[0]); }">
                                </label>
                                <p class="text-xs text-gray-400 mt-2">JPG, PNG, GIF or WebP. Max 2MB.</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Profile Details</h3>
                            <p class="text-sm text-gray-500 mb-6">Update your personal information.</p>

                            <div class="space-y-5">
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name"
                                           value="<?php echo e(old('name', $user->name)); ?>"
                                           class="w-full rounded-lg border border-gray-300px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           maxlength="255" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email"
                                           value="<?php echo e(old('email', $user->email)); ?>"
                                           class="w-full rounded-lg borderborder-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           maxlength="255" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div>
                                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                    <textarea id="bio" name="bio" rows="3"
                                              class="w-full rounded-lg border border-gray-300px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              maxlength="500" placeholder="Tell us about yourself..."><?php echo e(old('bio', $user->bio)); ?></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input type="text" id="location" name="location"
                                           value="<?php echo e(old('location', $user->location)); ?>"
                                           class="w-full rounded-lg border border-gray-300px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           maxlength="255" placeholder="City, Country">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div class="pt-2">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Social Links</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="github_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fab fa-github mr-1"></i> GitHub
                                            </label>
                                            <input type="url" id="github_url" name="github_url"
                                                   value="<?php echo e(old('github_url', $user->github_url)); ?>"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://github.com/username">
                                        </div>
                                        <div>
                                            <label for="linkedin_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fab fa-linkedin mr-1"></i> LinkedIn
                                            </label>
                                            <input type="url" id="linkedin_url" name="linkedin_url"
                                                   value="<?php echo e(old('linkedin_url', $user->linkedin_url)); ?>"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://linkedin.com/in/username">
                                        </div>
                                        <div>
                                            <label for="twitter_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fab fa-twitter mr-1"></i> Twitter
                                            </label>
                                            <input type="url" id="twitter_url" name="twitter_url"
                                                   value="<?php echo e(old('twitter_url', $user->twitter_url)); ?>"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://twitter.com/username">
                                        </div>
                                        <div>
                                            <label for="portfolio_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fas fa-globe mr-1"></i> Portfolio
                                            </label>
                                            <input type="url" id="portfolio_url" name="portfolio_url"
                                                   value="<?php echo e(old('portfolio_url', $user->portfolio_url)); ?>"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://yoursite.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="activeTab = 'profile'"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>

            
            <div x-show="activeTab === 'password'" x-transition>
                <form action="<?php echo e(route('admin.profile.password')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Change Password</h3>
                            <p class="text-sm text-gray-500 mb-6">Ensure your account uses a strong, unique password.</p>

                            <div class="space-y-5">
                                
                                <div class="relative">
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Password <span class="text-red-500">*</span>
                                    </label>
                                    <input :type="showCurrentPassword ? 'text' : 'password'" id="current_password" name="current_password"
                                           class="w-full rounded-lg borderborder-gray-300 px-4 py-2 text-sm pr-12 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           required>
                                    <button type="button" @click="showCurrentPassword = !showCurrentPassword"
                                            class="absolute right-3 top-10 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <i :class="showCurrentPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                        <span class="sr-only">Toggle password visibility</span>
                                    </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div class="relative">
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        New Password <span class="text-red-500">*</span>
                                    </label>
                                    <input :type="showNewPassword ? 'text' : 'password'" id="password" name="password"
                                           class="w-full rounded-lg borderborder-gray-300 px-4 py-2 text-sm pr-12 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           required>
                                    <button type="button" @click="showNewPassword = !showNewPassword"
                                            class="absolute right-3 top-10 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <i :class="showNewPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                        <span class="sr-only">Toggle password visibility</span>
                                    </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <p class="mt-1 text-xs text-gray-400">Minimum 8 characters with uppercase, lowercase, and numbers.</p>
                                </div>

                                
                                <div class="relative">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirm New Password <span class="text-red-500">*</span>
                                    </label>
                                    <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                                           class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm pr-12 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                           required>
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                            class="absolute right-3 top-10 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                        <span class="sr-only">Toggle password visibility</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        
                        <div class="space-y-4">
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-5">
                                <h4 class="text-sm font-semibold text-amber-800 mb-3">
                                    <i class="fas fa-shield-alt mr-1"></i> Password Tips
                                </h4>
                                <ul class="space-y-2 text-sm text-amber-700">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-amber-500 mt-0.5 shrink-0"></i>
                                        Use at least 8 characters
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-amber-500 mt-0.5 shrink-0"></i>
                                        Include uppercase and lowercase letters
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-amber-500 mt-0.5 shrink-0"></i>
                                        Add numbers and special characters
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-amber-500 mt-0.5 shrink-0"></i>
                                        Avoid using personal information
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-amber-500 mt-0.5 shrink-0"></i>
                                        Don't reuse passwords from other sites
                                    </li>
                                </ul>
                            </div>

                            <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 text-sm text-cyan-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                After changing your password, you'll remain logged in on this device.
                            </div>
                        </div>
                    </div>

                    
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" @click="activeTab = 'profile'"
                                class="px-6 py-2.5 rounded-lg text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="inline-flex items-center gap-2 bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                            <i class="fas fa-lock"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>

        </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.Admin.system', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\myprofile.blade.php ENDPATH**/ ?>