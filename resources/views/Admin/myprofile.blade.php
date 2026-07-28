@extends('layout.Admin.system')

@section('title', 'My Profile - SkillUp Admin')

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <nav class="text-sm text-gray-500 mt-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-cyan-600">Dashboard</a>
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

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-5 py-4">
                <i class="fas fa-check-circle text-green-500 text-lg shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-lg px-5 py-4">
                <div class="flex items-center gap-2 mb-2 font-semibold">
                    <i class="fas fa-exclamation-circle text-red-500 shrink-0"></i>
                    Please fix the following errors:
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tab Navigation --}}
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

            {{-- ─── Profile Overview Tab ─────────────────────────────── --}}
            <div x-show="activeTab === 'profile'" x-transition>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Profile Card --}}
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 text-center">
                        <div class="relative inline-block mb-4">
                            @if($user->profile_image)
                                <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}"
                                     alt="{{ $user->name }}"
                                     class="w-28 h-28 rounded-full object-cover border-4 border-cyan-100 mx-auto">
                            @else
                                <div class="w-28 h-28 rounded-full bg-gradient-to-brfrom-cyan-500 to-blue-600 flex items-center justify-center mx-auto border-4 border-cyan-100">
                                    <span class="text-white text-3xl font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>

                        {{-- Role Badge --}}
                        <div class="mt-3">
                            @if($user->is_admin)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <i class="fas fa-shield-alt"></i> Administrator
                                </span>
                            @elseif($user->isStaff())
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    <i class="fas fa-user-tie"></i> {{ $user->staffTypeLabel() }}
                                </span>
                            @endif
                        </div>

                        @if($user->bio)
                            <p class="text-sm text-gray-600 mt-4 leading-relaxed">{{ $user->bio }}</p>
                        @endif

                        @if($user->location)
                            <p class="text-sm text-gray-500 mt-3">
                                <i class="fas fa-map-marker-alt text-cyan-500 mr-1"></i> {{ $user->location }}
                            </p>
                        @endif

                        {{-- Social Links --}}
                        @if($user->github_url || $user->linkedin_url || $user->twitter_url || $user->portfolio_url)
                            <div class="flex items-center justify-center gap-3 mt-4 pt-4 border-t border-gray-100">
                                @if($user->github_url)
                                    <a href="{{ $user->github_url }}" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-800 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fab fa-github"></i>
                                    </a>
                                @endif
                                @if($user->linkedin_url)
                                    <a href="{{ $user->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                @endif
                                @if($user->twitter_url)
                                    <a href="{{ $user->twitter_url }}" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-sky-500 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                @if($user->portfolio_url)
                                    <a href="{{ $user->portfolio_url }}" target="_blank" rel="noopener noreferrer"
                                       class="w-9 h-9 rounded-full bg-gray-100 hover:bg-cyan-600 hover:text-white text-gray-600 flex items-center justify-center transition">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Account Details --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Account Info --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-id-card text-cyan-500 mr-2"></i> Account Information
                            </h3>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Role</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium">
                                        {{ $user->is_admin ? 'Administrator' : ($user->isStaff() ? $user->staffTypeLabel() : 'User') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Member Since</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $user->created_at->format('F j, Y') }}</dd>
                                </div>
                                @if($user->lrn)
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">LRN</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-medium">{{ $user->lrn }}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Profile Visibility</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium {{ $user->profile_public ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            <i class="fas {{ $user->profile_public ? 'fa-eye' : 'fa-eye-slash' }} text-xs"></i>
                                            {{ $user->profile_public ? 'Public' : 'Private' }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Skills --}}
                        @if($user->skills && count($user->skills) > 0)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-tools text-cyan-500 mr-2"></i> Skills
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->skills as $skill)
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-cyan-50 text-cyan-700 border border-cyan-200">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Quick Actions --}}
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
                                <a href="{{ route('admin.settings') }}"
                                   class="flex items-center gap-2 px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg transition text-sm font-medium">
                                    <i class="fas fa-cog"></i> System Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Edit Profile Tab ─────────────────────────────────── --}}
            <div x-show="activeTab === 'edit'" x-transition>
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {{-- Profile Image Upload --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Profile Photo</h3>
                            <div class="text-center" x-data="{ preview: null }">
                                <div class="mb-4">
                                    <template x-if="preview">
                                        <img :src="preview" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-cyan-100">
                                    </template>
                                    <template x-if="!preview">
                                        @if($user->profile_image)
                                            <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}"
                                                 alt="{{ $user->name }}"
                                                 class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-cyan-100">
                                        @else
                                            <div class="w-32 h-32 rounded-full bg-gradient-to-brfrom-cyan-500 to-blue-600 flex items-center justify-center mx-auto border-4 border-cyan-100">
                                                <span class="text-white text-4xl font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                        @endif
                                    </template>
                                </div>
                                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-cyan-50 hover:bg-cyan-100 text-cyan-700 rounded-lg transition text-sm font-medium">
                                    <i class="fas fa-camera"></i> Choose Photo
                                    <input type="file" name="profile_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="hidden"
                                           @change="if ($event.target.files[0]) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL($event.target.files[0]); }">
                                </label>
                                <p class="text-xs text-gray-400 mt-2">JPG, PNG, GIF or WebP. Max 2MB.</p>
                                @error('profile_image')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Profile Details --}}
                        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Profile Details</h3>
                            <p class="text-sm text-gray-500 mb-6">Update your personal information.</p>

                            <div class="space-y-5">
                                {{-- Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full rounded-lg border border-gray-300px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                           maxlength="255" required>
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full rounded-lg borderborder-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                           maxlength="255" required>
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Bio --}}
                                <div>
                                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                                    <textarea id="bio" name="bio" rows="3"
                                              class="w-full rounded-lg border border-gray-300px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('bio') border-red-500 @enderror"
                                              maxlength="500" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Location --}}
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                    <input type="text" id="location" name="location"
                                           value="{{ old('location', $user->location) }}"
                                           class="w-full rounded-lg border border-gray-300px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('location') border-red-500 @enderror"
                                           maxlength="255" placeholder="City, Country">
                                    @error('location')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Social Links --}}
                                <div class="pt-2">
                                    <p class="text-sm font-medium text-gray-700 mb-3">Social Links</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label for="github_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fab fa-github mr-1"></i> GitHub
                                            </label>
                                            <input type="url" id="github_url" name="github_url"
                                                   value="{{ old('github_url', $user->github_url) }}"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://github.com/username">
                                        </div>
                                        <div>
                                            <label for="linkedin_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fab fa-linkedin mr-1"></i> LinkedIn
                                            </label>
                                            <input type="url" id="linkedin_url" name="linkedin_url"
                                                   value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://linkedin.com/in/username">
                                        </div>
                                        <div>
                                            <label for="twitter_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fab fa-twitter mr-1"></i> Twitter
                                            </label>
                                            <input type="url" id="twitter_url" name="twitter_url"
                                                   value="{{ old('twitter_url', $user->twitter_url) }}"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://twitter.com/username">
                                        </div>
                                        <div>
                                            <label for="portfolio_url" class="block text-xs text-gray-500 mb-1">
                                                <i class="fas fa-globe mr-1"></i> Portfolio
                                            </label>
                                            <input type="url" id="portfolio_url" name="portfolio_url"
                                                   value="{{ old('portfolio_url', $user->portfolio_url) }}"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                                   placeholder="https://yoursite.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Save Button --}}
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

            {{-- ─── Change Password Tab ──────────────────────────────── --}}
            <div x-show="activeTab === 'password'" x-transition>
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">Change Password</h3>
                            <p class="text-sm text-gray-500 mb-6">Ensure your account uses a strong, unique password.</p>

                            <div class="space-y-5">
                                {{-- Current Password --}}
                                <div class="relative">
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Password <span class="text-red-500">*</span>
                                    </label>
                                    <input :type="showCurrentPassword ? 'text' : 'password'" id="current_password" name="current_password"
                                           class="w-full rounded-lg borderborder-gray-300 px-4 py-2 text-sm pr-12 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                                           required>
                                    <button type="button" @click="showCurrentPassword = !showCurrentPassword"
                                            class="absolute right-3 top-10 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <i :class="showCurrentPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                        <span class="sr-only">Toggle password visibility</span>
                                    </button>
                                    @error('current_password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- New Password --}}
                                <div class="relative">
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                        New Password <span class="text-red-500">*</span>
                                    </label>
                                    <input :type="showNewPassword ? 'text' : 'password'" id="password" name="password"
                                           class="w-full rounded-lg borderborder-gray-300 px-4 py-2 text-sm pr-12 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                           required>
                                    <button type="button" @click="showNewPassword = !showNewPassword"
                                            class="absolute right-3 top-10 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <i :class="showNewPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                        <span class="sr-only">Toggle password visibility</span>
                                    </button>
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-400">Minimum 8 characters with uppercase, lowercase, and numbers.</p>
                                </div>

                                {{-- Confirm Password --}}
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

                        {{-- Security Tips --}}
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

                    {{-- Save Button --}}
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


@endsection