@extends('layout.app')

@section('title', 'Learning Paths - SkillUp')

@section('content')

    {{-- ===================== HERO ===================== --}}
    <section class="pt-32 pb-20 px-4 gradient-primary text-white">
        <div class="max-w-6xl mx-auto text-center">
            <!-- Breadcrumb -->
            <nav class="text-purple-200 text-sm mb-6">
                <a href="/" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Learning Paths</span>
            </nav>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in">
                Your Roadmap to<br class="hidden md:block"> Career Success
            </h1>
            <p class="text-lg md:text-xl text-purple-100 mb-10 max-w-2xl mx-auto animate-fade-in">
                Choose a structured learning path tailored to your goals. Each path is curated by industry experts
                to take you from beginner to job-ready.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition">
                        Start Learning Free <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endguest
                @auth
                    <a href="{{ route('courses.index') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition">
                        Browse All Courses <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endauth
                <a href="#paths-grid" class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                    Explore Paths
                </a>
            </div>

            <!-- Quick Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
                <div class="bg-white/10 rounded-xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-bold">37+</div>
                    <p class="text-purple-200 text-sm mt-1">Learning Paths</p>
                </div>
                <div class="bg-white/10 rounded-xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-bold">500+</div>
                    <p class="text-purple-200 text-sm mt-1">Curated Courses</p>
                </div>
                <div class="bg-white/10 rounded-xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-bold">10K+</div>
                    <p class="text-purple-200 text-sm mt-1">Active Learners</p>
                </div>
                <div class="bg-white/10 rounded-xl p-5 backdrop-blur-sm">
                    <div class="text-3xl font-bold">92%</div>
                    <p class="text-purple-200 text-sm mt-1">Job Placement</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== HOW IT WORKS ===================== --}}
    <section class="py-16 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-3">How Learning Paths Work</h2>
            <p class="text-center text-gray-500 mb-12 max-w-xl mx-auto">A proven, step-by-step system to take you from beginner to career-ready professional.</p>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
                <!-- Connector line (desktop) -->
                <div class="hidden md:block absolute top-10 left-1/8 right-1/8 h-0.5 bg-purple-200" style="left:12.5%; right:12.5%;"></div>

                <!-- Step 1 -->
                <div class="text-center relative">
                    <div class="w-20 h-20 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg z-10 relative">
                        <i class="fas fa-compass text-white text-2xl"></i>
                    </div>
                    <span class="inline-block bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full mb-2">Step 1</span>
                    <h3 class="font-bold text-gray-800 mb-2">Choose a Path</h3>
                    <p class="text-gray-500 text-sm">Browse paths aligned with your career goals and interests.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center relative">
                    <div class="w-20 h-20 bg-gradient-to-brfrom-pink-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg z-10 relative">
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    </div>
                    <span class="inline-block bg-pink-100 text-pink-700 text-xs font-bold px-3 py-1 rounded-full mb-2">Step 2</span>
                    <h3 class="font-bold text-gray-800 mb-2">Learn at Your Pace</h3>
                    <p class="text-gray-500 text-sm">Work through structured modules with video, exercises, and quizzes.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center relative">
                    <div class="w-20 h-20 bg-gradient-to-brfrom-indigo-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg z-10 relative">
                        <i class="fas fa-project-diagram text-white text-2xl"></i>
                    </div>
                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full mb-2">Step 3</span>
                    <h3 class="font-bold text-gray-800 mb-2">Build Real Projects</h3>
                    <p class="text-gray-500 text-sm">Apply your skills with hands-on projects you can add to your portfolio.</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center relative">
                    <div class="w-20 h-20 bg-gradient-to-brfrom-green-500 to-teal-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg z-10 relative">
                        <i class="fas fa-certificate text-white text-2xl"></i>
                    </div>
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full mb-2">Step 4</span>
                    <h3 class="font-bold text-gray-800 mb-2">Earn Your Certificate</h3>
                    <p class="text-gray-500 text-sm">Complete the path and receive a verified certificate of achievement.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== FILTERS ===================== --}}
    <section id="paths-grid" class="py-10 px-4 bg-gray-50 border-b border-gray-200">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search -->
                <div class="relative w-full md:w-80">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input
                        type="text"
                        id="path-search"
                        placeholder="Search learning paths..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white"
                    >
                </div>

                <!-- Category Filters -->
                <div class="flex flex-wrap gap-2 justify-center md:justify-end">
                    <button class="filter-btn active px-4 py-2 rounded-full text-sm font-medium bg-purple-600 text-white transition" data-filter="all">
                        All Paths
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="tech">
                        <i class="fas fa-code mr-1"></i> Tech
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="business">
                        <i class="fas fa-briefcase mr-1"></i> Business
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="design">
                        <i class="fas fa-paint-brush mr-1"></i> Design
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="data">
                        <i class="fas fa-chart-bar mr-1"></i> Data & AI
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== FEATURED PATHS ===================== --}}
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Featured Paths</h2>
                    <p class="text-gray-500 text-sm mt-1">Most popular paths chosen by our learners</p>
                </div>
                <span class="hidden md:inline-flex items-center text-purple-600 text-sm font-semibold">
                    <i class="fas fa-fire text-orange-500 mr-2"></i> Trending this month
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Featured Path 1: Full-Stack Web Dev -->
                <div class="path-card bg-white rounded-2xl shadow-lg overflow-hidden card-hover flex flex-col" data-category="tech" data-name="full-stack web development">
                    <div class="h-3 bg-gradient-to-r from-purple-500 to-indigo-500"></div>
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-16 h-16 bg-gradient-to-brfrom-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-md">
                                <i class="fas fa-laptop-code text-white text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <span class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full">
                                    <i class="fas fa-fire mr-1"></i> Most Popular
                                </span>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Full-Stack Web Development</h3>
                        <p class="text-gray-600 mb-5 flex-1">Master HTML, CSS, JavaScript, React, Node.js, and databases. Build production-ready web applications from scratch.</p>

                        <div class="flex flex-wrap gap-2 mb-5">
                            <span class="bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1 rounded-full">HTML & CSS</span>
                            <span class="bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1 rounded-full">JavaScript</span>
                            <span class="bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1 rounded-full">React</span>
                            <span class="bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1 rounded-full">Node.js</span>
                            <span class="bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1 rounded-full">+5 more</span>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-6 py-4 border-t border-b border-gray-100">
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-900">12</p>
                                <p class="text-xs text-gray-500">Courses</p>
                            </div>
                            <div class="text-center border-l border-r border-gray-100">
                                <p class="text-xl font-bold text-gray-900">6 mo</p>
                                <p class="text-xs text-gray-500">Duration</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-900">4.9 <i class="fas fa-star text-yellow-400 text-sm"></i></p>
                                <p class="text-xs text-gray-500">Rating</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span class="text-sm text-gray-600">Beginner Friendly</span>
                            </div>
                            @guest
                                <a href="{{ route('register') }}" class="gradient-primary text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition shadow">
                                    Get Started <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            @endguest
                            @auth
                                <a href="{{ route('courses.index') }}" class="gradient-primary text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition shadow">
                                    Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Featured Path 2: Data Science & AI -->
                <div class="path-card bg-white rounded-2xl shadow-lg overflow-hidden card-hover flex flex-col" data-category="data" data-name="data science and artificial intelligence">
                    <div class="h-3 bg-gradient-to-r from-blue-500 to-teal-500"></div>
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-16 h-16 bg-gradient-to-brfrom-blue-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-md">
                                <i class="fas fa-brain text-white text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                                    <i class="fas fa-bolt mr-1"></i> High Demand
                                </span>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Data Science & AI</h3>
                        <p class="text-gray-600 mb-5 flex-1">Learn Python, machine learning, data visualization, and AI fundamentals. Launch a career in one of the fastest-growing fields.</p>

                        <div class="flex flex-wrap gap-2 mb-5">
                            <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">Python</span>
                            <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">Machine Learning</span>
                            <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">TensorFlow</span>
                            <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">SQL</span>
                            <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1 rounded-full">+4 more</span>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-6 py-4 border-t border-b border-gray-100">
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-900">10</p>
                                <p class="text-xs text-gray-500">Courses</p>
                            </div>
                            <div class="text-center border-l border-r border-gray-100">
                                <p class="text-xl font-bold text-gray-900">8 mo</p>
                                <p class="text-xs text-gray-500">Duration</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-900">4.8 <i class="fas fa-star text-yellow-400 text-sm"></i></p>
                                <p class="text-xs text-gray-500">Rating</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                <span class="text-sm text-gray-600">Intermediate</span>
                            </div>
                            @guest
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-teal-600 text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition shadow">
                                    Get Started <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            @endguest
                            @auth
                                <a href="{{ route('courses.index') }}" class="bg-gradient-to-r from-blue-600 to-teal-600 text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition shadow">
                                    Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===================== ALL PATHS GRID ===================== --}}
    <section class="py-16 px-4 bg-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">All Learning Paths</h2>
            <p class="text-gray-500 mb-10">Find the right path and start your journey today.</p>

            <div id="paths-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Path: UI/UX Design -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="design" data-name="ui ux design user interface experience">
                    <div class="h-2 bg-gradient-to-r from-pink-500 to-rose-500"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-pink-500 to-rose-500 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-paint-brush text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">UI/UX Design</h3>
                                <span class="text-xs font-medium text-pink-600 bg-pink-50 px-2 py-0.5 rounded-full">Design</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Learn Figma, design principles, wireframing, and create stunning user interfaces that people love.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Figma</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Wireframing</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Prototyping</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-pink-400"></i> 8 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-pink-400"></i> 4 months</span>
                            <span><i class="fas fa-signal mr-1 text-pink-400"></i> Beginner</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-pink-600 hover:bg-pink-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-pink-600 hover:bg-pink-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Digital Marketing -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="business" data-name="digital marketing seo social media">
                    <div class="h-2 bg-gradient-to-r from-orange-500 to-yellow-500"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-orange-500 to-yellow-500 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-bullhorn text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Digital Marketing</h3>
                                <span class="text-xs font-medium text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">Business</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Master SEO, social media marketing, content strategy, and paid ads to grow any business online.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">SEO</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Google Ads</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Analytics</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-orange-400"></i> 7 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-orange-400"></i> 3 months</span>
                            <span><i class="fas fa-signal mr-1 text-orange-400"></i> Beginner</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Cybersecurity -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="tech" data-name="cybersecurity ethical hacking network security">
                    <div class="h-2 bg-gradient-to-r from-red-600 to-rose-700"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-red-600 to-rose-700 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-shield-halved text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Cybersecurity</h3>
                                <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded-full">Tech</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Protect systems and networks. Learn ethical hacking, penetration testing, and security best practices.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Networking</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Linux</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Pen Testing</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-red-400"></i> 9 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-red-400"></i> 5 months</span>
                            <span><i class="fas fa-signal mr-1 text-red-400"></i> Intermediate</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Cloud Computing -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="tech" data-name="cloud computing aws devops infrastructure">
                    <div class="h-2 bg-gradient-to-r from-sky-500 to-cyan-500"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-sky-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-cloud text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Cloud Computing</h3>
                                <span class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full">Tech</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Get certified in AWS, Azure, or GCP. Learn DevOps, containerization (Docker & Kubernetes), and CI/CD pipelines.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">AWS</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Docker</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Kubernetes</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-sky-400"></i> 8 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-sky-400"></i> 6 months</span>
                            <span><i class="fas fa-signal mr-1 text-sky-400"></i> Intermediate</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-sky-500 hover:bg-sky-600 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-sky-500 hover:bg-sky-600 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Mobile Development -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="tech" data-name="mobile app development ios android flutter react native">
                    <div class="h-2 bg-gradient-to-r from-violet-500 to-purple-600"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-violet-500 to-purple-600 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-mobile-screen-button text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Mobile Development</h3>
                                <span class="text-xs font-medium text-violet-600 bg-violet-50 px-2 py-0.5 rounded-full">Tech</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Build iOS and Android apps using Flutter or React Native. Ship your first app to the App Store or Google Play.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Flutter</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">React Native</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Dart</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-violet-400"></i> 7 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-violet-400"></i> 5 months</span>
                            <span><i class="fas fa-signal mr-1 text-violet-400"></i> Intermediate</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-violet-600 hover:bg-violet-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-violet-600 hover:bg-violet-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Business Analytics -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="business" data-name="business analytics finance entrepreneurship management">
                    <div class="h-2 bg-gradient-to-r from-emerald-500 to-green-600"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Business Analytics</h3>
                                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Business</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Use data to drive smarter business decisions. Excel, Power BI, and advanced analytics for non-technical professionals.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Excel</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Power BI</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">SQL</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-emerald-400"></i> 6 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-emerald-400"></i> 3 months</span>
                            <span><i class="fas fa-signal mr-1 text-emerald-400"></i> Beginner</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Graphic Design -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="design" data-name="graphic design branding illustration adobe">
                    <div class="h-2 bg-gradient-to-r from-fuchsia-500 to-pink-500"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-fuchsia-500 to-pink-500 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-wand-magic-sparkles text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Graphic Design</h3>
                                <span class="text-xs font-medium text-fuchsia-600 bg-fuchsia-50 px-2 py-0.5 rounded-full">Design</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Create stunning visuals and brand identities. Master Adobe tools, typography, and color theory for professional design.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Photoshop</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Illustrator</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Typography</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-fuchsia-400"></i> 7 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-fuchsia-400"></i> 4 months</span>
                            <span><i class="fas fa-signal mr-1 text-fuchsia-400"></i> Beginner</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-fuchsia-600 hover:bg-fuchsia-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-fuchsia-600 hover:bg-fuchsia-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Machine Learning Engineering -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="data" data-name="machine learning engineering deep learning nlp computer vision">
                    <div class="h-2 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-indigo-500 to-blue-500 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-microchip text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">ML Engineering</h3>
                                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">Data & AI</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Go beyond theory â€” learn to deploy ML models, build ML pipelines, and engineer large-scale AI systems.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">PyTorch</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">MLOps</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">NLP</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-indigo-400"></i> 11 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-indigo-400"></i> 9 months</span>
                            <span><i class="fas fa-signal mr-1 text-indigo-400"></i> Advanced</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Path: Entrepreneurship -->
                <div class="path-card bg-white rounded-xl border border-gray-200 shadow-sm card-hover overflow-hidden" data-category="business" data-name="entrepreneurship startup leadership management product">
                    <div class="h-2 bg-gradient-to-r from-amber-500 to-orange-500"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-brfrom-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-smflex-shrink-0">
                                <i class="fas fa-rocket text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Entrepreneurship</h3>
                                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Business</span>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm mb-4">Turn your ideas into a thriving business. From validation and pitching to scaling and fundraising.</p>
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Lean Startup</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Pitching</span>
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">Finance</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-5">
                            <span><i class="fas fa-book mr-1 text-amber-400"></i> 6 Courses</span>
                            <span><i class="fas fa-clock mr-1 text-amber-400"></i> 3 months</span>
                            <span><i class="fas fa-signal mr-1 text-amber-400"></i> Beginner</span>
                        </div>
                        @guest
                            <a href="{{ route('register') }}" class="block w-full text-center bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Start Path <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('courses.index') }}" class="block w-full text-center bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                                Enroll Now <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        @endauth
                    </div>
                </div>

            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden py-16 text-center">
                <i class="fas fa-search text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No paths found</h3>
                <p class="text-gray-500">Try a different search term or filter.</p>
            </div>
        </div>
    </section>

    {{-- ===================== TESTIMONIALS ===================== --}}
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-3">What Our Learners Say</h2>
            <p class="text-center text-gray-500 mb-12 max-w-xl mx-auto">Real stories from students who transformed their careers with SkillUp</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 card-hover">
                    <div class="flex items-center gap-1 mb-4 text-yellow-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 mb-5 text-sm leading-relaxed">"I completed the Full-Stack Web Development path in 5 months and landed my first dev job within 3 weeks of finishing. The structured curriculum was a game-changer."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-brfrom-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm">JM</div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">James M.</p>
                            <p class="text-xs text-gray-500">Junior Developer @ TechCorp</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 card-hover">
                    <div class="flex items-center gap-1 mb-4 text-yellow-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 mb-5 text-sm leading-relaxed">"The UI/UX Design path gave me not just skills, but a portfolio that I'm proud of. I went from zero to getting freelance clients in just 4 months. Highly recommend!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-brfrom-pink-500 to-rose-500 rounded-full flex items-center justify-center text-white font-bold text-sm">SC</div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Sofia C.</p>
                            <p class="text-xs text-gray-500">Freelance UX Designer</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 card-hover">
                    <div class="flex items-center gap-1 mb-4 text-yellow-400">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-600 mb-5 text-sm leading-relaxed">"Data Science & AI was the most comprehensive course I've ever taken. The quizzes and projects kept me on track and the mentors were incredibly supportive."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-brfrom-blue-500 to-teal-500 rounded-full flex items-center justify-center text-white font-bold text-sm">AR</div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Amir R.</p>
                            <p class="text-xs text-gray-500">Data Analyst @ FinTech Inc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== CTA SECTION ===================== --}}
    <section class="py-20 px-4 gradient-primary text-white">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-block bg-white/10 rounded-full px-4 py-2 text-sm font-medium mb-6 backdrop-blur-sm">
                <i class="fas fa-rocket mr-2"></i> Start Your Journey Today
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">
                Ready to Build Your<br class="hidden md:block"> Dream Career?
            </h2>
            <p class="text-lg text-purple-100 mb-10 max-w-2xl mx-auto">
                Join over 10,000 learners who are already on their path to career success. Your first course is free â€” no credit card required.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-purple-700 px-10 py-4 rounded-xl font-bold text-lg hover:bg-purple-50 transition shadow-lg">
                        Create Free Account <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white/60 px-10 py-4 rounded-xl font-semibold text-lg hover:bg-white/10 transition">
                        Sign In
                    </a>
                @endguest
                @auth
                    <a href="{{ route('courses.index') }}" class="bg-white text-purple-700 px-10 py-4 rounded-xl font-bold text-lg hover:bg-purple-50 transition shadow-lg">
                        Browse All Courses <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endauth
            </div>
            <p class="text-purple-200 text-sm mt-6">
                <i class="fas fa-check-circle mr-2"></i>No credit card required
                <span class="mx-4">Â·</span>
                <i class="fas fa-check-circle mr-2"></i>Cancel anytime
                <span class="mx-4">Â·</span>
                <i class="fas fa-check-circle mr-2"></i>Lifetime access
            </p>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // ---- Filter & Search ----
    const filterBtns = document.querySelectorAll('.filter-btn');
    const pathCards  = document.querySelectorAll('.path-card');
    const searchInput = document.getElementById('path-search');
    const noResults   = document.getElementById('no-results');

    let activeFilter = 'all';
    let searchTerm   = '';

    function applyFilters() {
        let visible = 0;
        pathCards.forEach(card => {
            const category = card.dataset.category;
            const name     = card.dataset.name || '';
            const matchCat = activeFilter === 'all' || category === activeFilter;
            const matchSearch = searchTerm === '' || name.includes(searchTerm);
            if (matchCat && matchSearch) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });
        noResults.classList.toggle('hidden', visible > 0);
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-purple-600', 'text-white');
                b.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-600');
            });
            btn.classList.add('active', 'bg-purple-600', 'text-white');
            btn.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-600');
            activeFilter = btn.dataset.filter;
            applyFilters();
        });
    });

    searchInput.addEventListener('input', () => {
        searchTerm = searchInput.value.toLowerCase().trim();
        applyFilters();
    });
</script>
@endpush
