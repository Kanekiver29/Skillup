@extends('layout.app')

@section('title', 'Login - SkillUp')

@section('content')
    <!-- Login Container -->
    <div class="min-h-screen flex items-center justify-center pt-20 pb-10">
        <div class="w-full max-w-md animate-fade-in">
            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="gradient-primary p-8 text-center">
                    <div class="inline-block mb-4">
                        <i class="fas fa-sign-in-alt text-white text-4xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
                    <p class="text-purple-100">Login to your SkillUp account</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

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
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
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
                            @error('password')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="remember" 
                                name="remember" 
                                class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                            >
                            <label for="remember" class="ml-2 text-sm text-gray-600">
                                Remember me
                            </label>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="submit" 
                            class="w-full gradient-primary text-white font-bold py-3 rounded-lg hover:shadow-lg transition transform hover:scale-105 duration-200"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </button>

                        <!-- Forgot Password Link -->
                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
                        </div>
                    </div>

                    <!-- Sign Up Link -->
                    <a 
                        href="/register" 
                        class="block w-full text-center border-2 border-purple-600 text-purple-600 font-bold py-3 rounded-lg hover:bg-purple-50 transition"
                    >
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </a>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600">
                    By logging in, you agree to our <a href="#" class="text-purple-600 hover:underline">Terms of Service</a>
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

