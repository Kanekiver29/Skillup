

<?php $__env->startSection('title', 'Features - SkillUp'); ?>

<?php $__env->startSection('content'); ?>

    
    <section class="pt-32 pb-20 px-4 gradient-primary text-white">
        <div class="max-w-6xl mx-auto text-center">
            <!-- Breadcrumb -->
            <nav class="text-purple-200 text-sm mb-6">
                <a href="/" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Features</span>
            </nav>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in">
                Everything You Need to<br class="hidden md:block"> Succeed
            </h1>
            <p class="text-lg md:text-xl text-purple-100 mb-10 max-w-2xl mx-auto animate-fade-in">
                SkillUp brings together personalized learning, expert mentorship, and real-world opportunities — all in one powerful platform.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('register')); ?>" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition">
                        Get Started Free <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('courses.index')); ?>" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition">
                        Browse Courses <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="#features-grid" class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                    Explore Features
                </a>
            </div>

            <!-- Quick Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
                <div class="bg-white/10 rounded-lg p-4">
                    <div class="text-3xl font-bold">10K+</div>
                    <p class="text-purple-200 text-sm mt-1">Active Learners</p>
                </div>
                <div class="bg-white/10 rounded-lg p-4">
                    <div class="text-3xl font-bold">37+</div>
                    <p class="text-purple-200 text-sm mt-1">Learning Paths</p>
                </div>
                <div class="bg-white/10 rounded-lg p-4">
                    <div class="text-3xl font-bold">500+</div>
                    <p class="text-purple-200 text-sm mt-1">Expert Mentors</p>
                </div>
                <div class="bg-white/10 rounded-lg p-4">
                    <div class="text-3xl font-bold">4.8★</div>
                    <p class="text-purple-200 text-sm mt-1">Average Rating</p>
                </div>
            </div>
        </div>
    </section>

    
    <section id="features-grid" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <span class="inline-block bg-purple-100 text-purple-700 text-sm font-semibold px-4 py-1 rounded-full mb-4">
                    Platform Features
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                    Powerful Tools to Accelerate Your Growth
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Every feature is designed with one goal in mind — helping you reach your career potential faster and smarter.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Personalized Learning Paths -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-brain text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Personalized Learning Paths</h3>
                    <p class="text-gray-600 leading-relaxed">
                        AI-driven paths tailored to your career goals, current skill level, and preferred learning pace. No one-size-fits-all here.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Skill gap analysis</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Adaptive course recommendations</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Custom milestones & goals</li>
                    </ul>
                </div>

                <!-- Expert Mentorship -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-user-tie text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Expert Mentorship</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Connect 1-on-1 with industry professionals who provide real guidance, constructive feedback, and career advice.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Live session scheduling</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Direct messaging</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Structured mentorship programs</li>
                    </ul>
                </div>

                <!-- Job & Internship Matching -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-briefcase text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Job & Internship Matching</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Discover curated job and internship listings that align with your skills, completed courses, and career aspirations.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Skills-based matching</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Partner employer network</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>One-click applications</li>
                    </ul>
                </div>

                <!-- Credentials & Badges -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-certificate text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Earn Credentials & Badges</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Build a portfolio of verified digital badges and certificates you can share on LinkedIn, your portfolio, or with employers.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Verifiable certificates</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Shareable digital badges</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>LinkedIn integration</li>
                    </ul>
                </div>

                <!-- Progress Tracking -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-chart-line text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Progress Tracking & Analytics</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Visualize your learning journey with detailed dashboards showing streaks, completion rates, and skill mastery levels.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Real-time progress dashboard</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Weekly learning streaks</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Performance insights</li>
                    </ul>
                </div>

                <!-- Interactive Quizzes -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-clipboard-check text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Interactive Quizzes & Modules</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Reinforce your knowledge with hands-on quizzes, assessments, and bite-sized modules built into every course.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Auto-graded assessments</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Instant feedback</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Retake & improve</li>
                    </ul>
                </div>

                <!-- Community -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-users text-red-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Peer Community & Collaboration</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Learn alongside thousands of ambitious peers. Join study groups, forums, and collaborative projects.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Discussion forums</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Study group matching</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Peer code/project reviews</li>
                    </ul>
                </div>

                <!-- Mobile Access -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-mobile-alt text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Learn Anywhere, Any Device</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Fully responsive on desktop, tablet, and mobile. Pick up right where you left off — at home or on the go.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Offline lesson downloads</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Cross-device sync</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>iOS & Android ready</li>
                    </ul>
                </div>

                <!-- Career Roadmap -->
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center mb-5">
                        <i class="fas fa-map-signs text-teal-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Visual Career Roadmaps</h3>
                    <p class="text-gray-600 leading-relaxed">
                        See exactly where you are and where you're heading. Our interactive roadmaps chart your path from beginner to job-ready.
                    </p>
                    <ul class="mt-4 space-y-2 text-sm text-gray-500">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Step-by-step career timelines</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Milestone celebrations</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Exportable roadmap PDF</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <span class="inline-block bg-pink-100 text-pink-700 text-sm font-semibold px-4 py-1 rounded-full mb-4">
                    Deep Dives
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Features That Make the Difference</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">A closer look at how our core features help you build skills faster and land better opportunities.</p>
            </div>

            <!-- Spotlight 1 — Personalized Learning -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <span class="inline-block bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4">Learning Paths</span>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Your Learning, Your Rules</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        No two learners are the same. SkillUp's adaptive engine builds a curriculum around you — evaluating your current skills, understanding your goals, and dynamically reordering content so you always learn the right thing at the right moment.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-sliders-h text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Adaptive Difficulty</h4>
                                <p class="text-sm text-gray-500">Content adjusts in real-time based on your quiz scores and engagement.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-bullseye text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Goal-Oriented Planning</h4>
                                <p class="text-sm text-gray-500">Set your target role and we map every course to get you there.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-redo text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Spaced Repetition Reviews</h4>
                                <p class="text-sm text-gray-500">Smart review reminders keep knowledge fresh and reduce forgetting.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-brfrom-purple-100 to-indigo-100 rounded-2xl p-10 text-center shadow-inner">
                    <i class="fas fa-brain text-purple-400 text-8xl mb-6 block"></i>
                    <div class="bg-white rounded-xl p-6 shadow-md">
                        <p class="text-sm text-gray-500 mb-3">Your personalized path</p>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-centerflex-shrink-0">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                                <div class="flex-1 bg-green-100 rounded-full h-3"></div>
                                <span class="text-xs text-green-600 font-semibold">Done</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-centerflex-shrink-0">
                                    <i class="fas fa-play text-white text-xs"></i>
                                </div>
                                <div class="flex-1 bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="bg-purple-500 h-3 rounded-full" style="width:65%"></div>
                                </div>
                                <span class="text-xs text-purple-600 font-semibold">65%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-centerflex-shrink-0">
                                    <i class="fas fa-lock text-gray-400 text-xs"></i>
                                </div>
                                <div class="flex-1 bg-gray-100 rounded-full h-3"></div>
                                <span class="text-xs text-gray-400 font-semibold">Upcoming</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spotlight 2 — Mentorship (reversed) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div class="order-2 lg:order-1 bg-gradient-to-brfrom-pink-100 to-rose-100 rounded-2xl p-10 text-center shadow-inner">
                    <i class="fas fa-user-tie text-pink-400 text-8xl mb-6 block"></i>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-star text-pink-500"></i>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">4.9 / 5 Rating</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-video text-purple-500"></i>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">Live Sessions</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-comments text-blue-500"></i>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">Async Chat</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-check-double text-green-500"></i>
                            </div>
                            <p class="text-xs font-semibold text-gray-700">Code Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <span class="inline-block bg-pink-100 text-pink-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4">Mentorship</span>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Real Humans, Real Guidance</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Our mentors are carefully vetted industry professionals — engineers, designers, data scientists, and business leaders. They're here to guide you through challenges, review your work, and open doors with their networks.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-calendar-check text-pink-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Flexible Scheduling</h4>
                                <p class="text-sm text-gray-500">Book sessions when it suits you — mornings, evenings, or weekends.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-code text-pink-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Project & Portfolio Reviews</h4>
                                <p class="text-sm text-gray-500">Get direct feedback on your projects to stand out to employers.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-handshake text-pink-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Industry Connections</h4>
                                <p class="text-sm text-gray-500">Leverage your mentor's professional network for introductions.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spotlight 3 — Progress & Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4">Analytics</span>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Know Exactly Where You Stand</h3>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Data-driven insights show you what's working, what needs more attention, and how you compare to your personal bests. Stay motivated with streaks, badges, and weekly reports delivered straight to your dashboard.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-fire text-orange-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Daily Learning Streaks</h4>
                                <p class="text-sm text-gray-500">Build consistent habits with visual streak tracking and reminders.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-chart-bar text-orange-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Weekly Performance Reports</h4>
                                <p class="text-sm text-gray-500">Automated summaries of hours studied, topics mastered, and quiz scores.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-centerflex-shrink-0">
                                <i class="fas fa-trophy text-orange-500"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Leaderboards & Challenges</h4>
                                <p class="text-sm text-gray-500">Compete with peers in friendly weekly learning challenges.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-brfrom-orange-100 to-yellow-100 rounded-2xl p-10 shadow-inner">
                    <div class="bg-white rounded-xl p-6 shadow-md mb-4">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-700">Weekly Progress</span>
                            <span class="text-xs text-orange-500 font-bold">+12% this week</span>
                        </div>
                        <div class="flex items-end gap-2 h-20">
                            <div class="flex-1 bg-purple-200 rounded-t" style="height:40%"></div>
                            <div class="flex-1 bg-purple-300 rounded-t" style="height:60%"></div>
                            <div class="flex-1 bg-purple-400 rounded-t" style="height:50%"></div>
                            <div class="flex-1 bg-purple-500 rounded-t" style="height:80%"></div>
                            <div class="flex-1 bg-purple-600 rounded-t" style="height:70%"></div>
                            <div class="flex-1 gradient-primary rounded-t" style="height:100%"></div>
                            <div class="flex-1 bg-purple-300 rounded-t" style="height:45%"></div>
                        </div>
                        <div class="flex justify-between mt-1 text-xs text-gray-400">
                            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                            <div class="text-2xl font-bold text-purple-600">27</div>
                            <p class="text-xs text-gray-500 mt-1">Day Streak</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                            <div class="text-2xl font-bold text-green-600">12</div>
                            <p class="text-xs text-gray-500 mt-1">Badges</p>
                        </div>
                        <div class="bg-white rounded-xl p-4 shadow-sm text-center">
                            <div class="text-2xl font-bold text-orange-600">94%</div>
                            <p class="text-xs text-gray-500 mt-1">Quiz Avg.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <span class="inline-block bg-indigo-100 text-indigo-700 text-sm font-semibold px-4 py-1 rounded-full mb-4">
                    How It Works
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">From Sign Up to Career Ready</h2>
                <p class="text-gray-600 max-w-xl mx-auto">Four simple steps to kick-start your learning journey on SkillUp.</p>
            </div>

            <div class="relative">
                <!-- Connector line (desktop) -->
                <div class="hidden lg:block absolute top-14 left-1/8 right-1/8 h-0.5 bg-purple-200" style="left:12.5%;right:12.5%"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center relative">
                        <div class="w-28 h-28 gradient-primary rounded-full flex items-center justify-center mx-auto mb-6 relative z-10 shadow-xl">
                            <i class="fas fa-user-plus text-white text-3xl"></i>
                        </div>
                        <div class="absolute top-2 right-2 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold z-20">1</div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Create Your Account</h3>
                        <p class="text-gray-600 text-sm">Sign up free in under a minute. No credit card required.</p>
                    </div>
                    <div class="text-center relative">
                        <div class="w-28 h-28 bg-gradient-to-brfrom-pink-500 to-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10 shadow-xl">
                            <i class="fas fa-tasks text-white text-3xl"></i>
                        </div>
                        <div class="absolute top-2 right-2 w-8 h-8 bg-pink-600 text-white rounded-full flex items-center justify-center text-sm font-bold z-20">2</div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Set Your Goals</h3>
                        <p class="text-gray-600 text-sm">Tell us your dream role and current skills for a personalized plan.</p>
                    </div>
                    <div class="text-center relative">
                        <div class="w-28 h-28 bg-gradient-to-brfrom-blue-500 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10 shadow-xl">
                            <i class="fas fa-laptop-code text-white text-3xl"></i>
                        </div>
                        <div class="absolute top-2 right-2 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold z-20">3</div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Learn & Practice</h3>
                        <p class="text-gray-600 text-sm">Work through courses, quizzes, and projects at your own pace.</p>
                    </div>
                    <div class="text-center relative">
                        <div class="w-28 h-28 bg-gradient-to-brfrom-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10 shadow-xl">
                            <i class="fas fa-rocket text-white text-3xl"></i>
                        </div>
                        <div class="absolute top-2 right-2 w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold z-20">4</div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Launch Your Career</h3>
                        <p class="text-gray-600 text-sm">Earn certificates, meet mentors, and land your dream opportunity.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-14">
                <span class="inline-block bg-green-100 text-green-700 text-sm font-semibold px-4 py-1 rounded-full mb-4">
                    Plans
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Free vs Premium</h2>
                <p class="text-gray-600 max-w-xl mx-auto">Start free and upgrade when you're ready to unlock your full potential.</p>
            </div>

            <div class="overflow-hidden rounded-2xl shadow-xl border border-gray-200">
                <div class="grid grid-cols-3 bg-gray-100 font-semibold text-sm">
                    <div class="px-6 py-4 text-gray-700">Feature</div>
                    <div class="px-6 py-4 text-center text-gray-700">Free</div>
                    <div class="px-6 py-4 text-center gradient-primary text-white rounded-tr-2xl">Premium</div>
                </div>

                <?php
                $rows = [
                    ['Access to 10+ free courses',        true,  true],
                    ['Personalized learning path',        false, true],
                    ['Unlimited course library',          false, true],
                    ['Interactive quizzes & assessments', true,  true],
                    ['Progress tracking dashboard',       true,  true],
                    ['Expert mentor sessions',            false, true],
                    ['Verified certificates',             false, true],
                    ['Job & internship matching',         false, true],
                    ['Community forums & study groups',   true,  true],
                    ['Offline access',                    false, true],
                    ['Weekly analytics reports',          false, true],
                    ['Priority support',                  false, true],
                ];
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="grid grid-cols-3 <?php echo e($i % 2 === 0 ? 'bg-white' : 'bg-gray-50'); ?> text-sm border-t border-gray-200">
                    <div class="px-6 py-4 text-gray-700"><?php echo e($row[0]); ?></div>
                    <div class="px-6 py-4 text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row[1]): ?>
                            <i class="fas fa-check-circle text-green-500 text-lg"></i>
                        <?php else: ?>
                            <i class="fas fa-times-circle text-gray-300 text-lg"></i>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="px-6 py-4 text-center bg-purple-50">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row[2]): ?>
                            <i class="fas fa-check-circle text-purple-600 text-lg"></i>
                        <?php else: ?>
                            <i class="fas fa-times-circle text-gray-300 text-lg"></i>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                <div class="grid grid-cols-3 border-t border-gray-200">
                    <div class="px-6 py-6"></div>
                    <div class="px-6 py-6 text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('register')); ?>" class="inline-block border-2 border-purple-600 text-purple-600 px-5 py-2 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition text-sm">
                                Sign Up Free
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                            <span class="text-green-600 font-semibold text-sm"><i class="fas fa-check-circle mr-1"></i>Active</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="px-6 py-6 text-center bg-purple-50">
                        <a href="<?php echo e(route('pricing')); ?>" class="inline-block gradient-primary text-white px-5 py-2 rounded-lg font-semibold hover:opacity-90 transition text-sm">
                            Upgrade Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-14">
                <span class="inline-block bg-yellow-100 text-yellow-700 text-sm font-semibold px-4 py-1 rounded-full mb-4">
                    Testimonials
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Learners Love SkillUp</h2>
                <p class="text-gray-600 max-w-xl mx-auto">Real stories from real learners who transformed their careers with SkillUp.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 italic mb-6">"The personalized path feature is a game changer. It knew exactly what I needed to learn next and I went from zero to landing a front-end developer internship in 4 months!"</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 gradient-primary rounded-full flex items-center justify-centerflex-shrink-0">
                            <span class="text-white font-bold text-lg">A</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Alex Rivera</p>
                            <p class="text-sm text-gray-500">Front-End Developer Intern</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-gray-600 italic mb-6">"Having a mentor who reviewed my projects and connected me with their network made all the difference. I got my first data analyst role two months after completing my path."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-brfrom-pink-500 to-rose-500 rounded-full flex items-center justify-centerflex-shrink-0">
                            <span class="text-white font-bold text-lg">S</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Sofia Chen</p>
                            <p class="text-sm text-gray-500">Junior Data Analyst</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white p-8 rounded-xl shadow-md border border-gray-100">
                    <div class="flex text-yellow-400 mb-4">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="text-gray-600 italic mb-6">"The progress analytics kept me accountable. Seeing my streak climb every day and my quiz averages improve week over week pushed me to stay consistent."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-brfrom-blue-500 to-indigo-500 rounded-full flex items-center justify-centerflex-shrink-0">
                            <span class="text-white font-bold text-lg">M</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Marcus Johnson</p>
                            <p class="text-sm text-gray-500">UX Designer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-24 px-4 gradient-primary text-white text-center">
        <div class="max-w-3xl mx-auto">
            <i class="fas fa-rocket text-5xl mb-6 block opacity-80"></i>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Launch Your Career?</h2>
            <p class="text-purple-100 text-lg mb-10 max-w-xl mx-auto">
                Join over 10,000 learners already using SkillUp to build skills, earn credentials, and land their dream roles.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('register')); ?>" class="bg-white text-purple-600 px-10 py-4 rounded-xl font-bold text-lg hover:bg-purple-50 transition shadow-lg">
                        Get Started Free <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="border-2 border-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-purple-600 transition">
                        Log In
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('courses.index')); ?>" class="bg-white text-purple-600 px-10 py-4 rounded-xl font-bold text-lg hover:bg-purple-50 transition shadow-lg">
                        Browse All Courses <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="<?php echo e(route('userpage.dashboard')); ?>" class="border-2 border-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-purple-600 transition">
                        Go to Dashboard
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <p class="text-purple-200 text-sm mt-6">No credit card required &bull; Cancel anytime &bull; Free plan always available</p>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\Product\features.blade.php ENDPATH**/ ?>