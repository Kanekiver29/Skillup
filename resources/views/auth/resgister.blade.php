@extends('layout.app')

@section('title', 'Register - SkillUp')

@section('content')
    <!-- Register Container -->
    <div class="min-h-screen flex items-center justify-center pt-20 pb-10">
        <div class="w-full max-w-md animate-fade-in">
            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="gradient-primary p-8 text-center">
                    <div class="inline-block mb-4">
                        <i class="fas fa-user-plus text-white text-4xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Join SkillUp</h1>
                    <p class="text-purple-100">Create your account and start learning today</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Full Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-purple-600 mr-2"></i>Full Name
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                placeholder="John Doe"
                                required
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-purple-600 mr-2"></i>Email Address
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                placeholder="you@example.com"
                                required
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-purple-600 mr-2"></i>Password
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                placeholder="••••••••"
                                required
                            >
                            <p class="text-gray-600 text-xs mt-1">At least 8 characters with uppercase, lowercase, and numbers</p>
                            @error('password')
                                <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-purple-600 mr-2"></i>Confirm Password
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition"
                                placeholder="••••••••"
                                required
                            >
                            @error('password_confirmation')
                                <p class="text-red-500 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms & Conditions Checkbox -->
                        <div class="flex items-start">
                            <input 
                                type="checkbox" 
                                id="terms" 
                                name="terms" 
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 mt-1"
                                required
                            >
                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                I agree to the <a href="#" class="text-purple-600 hover:underline">Terms of Service</a> and <a href="#" class="text-purple-600 hover:underline">Privacy Policy</a>
                            </label>
                        </div>

                        <!-- Register Button -->
                        <button 
                            type="submit" 
                            class="w-full gradient-primary text-white font-bold py-3 rounded-lg hover:shadow-lg transition transform hover:scale-105 duration-200"
                        >
                            <i class="fas fa-user-plus mr-2"></i>Create Account
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <a 
                        href="/login" 
                        class="block w-full text-center border-2 border-purple-600 text-purple-600 font-bold py-3 rounded-lg hover:bg-purple-50 transition"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>Login Here
                    </a>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600">
                    Join thousands of youth developing their careers with SkillUp
                </div>
            </div>

            <!-- Back to Home Link -->
            <div class="text-center mt-6">
                <a href="/" class="text-gray-600 hover:text-purple-600 font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Background decoration -->
    <div class="fixed top-0 right-0 w-96 h-96 bg-gradient-to-br from-purple-100 to-purple-50 rounded-full blur-3xl opacity-30 -z-10"></div>
    <div class="fixed bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-purple-100 to-pink-50 rounded-full blur-3xl opacity-30 -z-10"></div>
@endsection
