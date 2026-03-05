@extends('layout.app')

@section('title', 'SkillUp - Personalized Web Learning for Youth Career Development')

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 gradient-primary text-white">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in">
                Launch Your Career with Confidence
            </h1>
            <p class="text-lg md:text-xl text-purple-100 mb-8 max-w-2xl mx-auto animate-fade-in">
                SkillUp is your personalized learning portal designed to help youth discover their strengths,
                develop in-demand skills, and connect with mentors and opportunities for real-world experience.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                @auth
                    {{-- Profile button moved to dashboard navigation/menu --}}
                    <a href="/courses" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition">
                        Continue Learning <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endauth
                @guest
                    <a href="/register" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition">
                        Get Started Free <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endguest
                <a href="#features" class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                    Learn More
                </a>
            </div>
            <div class="flex justify-center gap-8 text-sm text-purple-100">
                <div><i class="fas fa-users mr-2"></i>10K+ Users</div>
                <div><i class="fas fa-trophy mr-2"></i>37+ Paths</div>
                <div><i class="fas fa-star mr-2"></i>4.8★ Rating</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-4 text-gray-800">Powerful Features to Accelerate Your Growth</h2>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Everything you need to learn, grow, and succeed in your chosen career path</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card-hover bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl mb-4 text-purple-600"><i class="fas fa-brain"></i></div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Personalized Learning Paths</h3>
                    <p class="text-gray-600">You choose learning paths tailored to your career goals, learning style, and pace</p>
                </div>

                <!-- Feature 2 -->
                <div class="card-hover bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl mb-4 text-pink-600"><i class="fas fa-user-tie"></i></div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Expert Mentorship</h3>
                    <p class="text-gray-600">Connect with industry professionals for guidance, feedback, and career advice</p>
                </div>

                <!-- Feature 3 -->
                <div class="card-hover bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl mb-4 text-blue-600"><i class="fas fa-briefcase"></i></div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Job & Internship Matching</h3>
                    <p class="text-gray-600">Discover opportunities that align with your skills and career aspirations</p>
                </div>

                <!-- Feature 4 -->
                <div class="card-hover bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl mb-4 text-green-600"><i class="fas fa-certificate"></i></div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Earn Credentials & Badges</h3>
                    <p class="text-gray-600">Build a portfolio of verified skills and shareable achievements</p>
                </div>

                <!-- Feature 5 -->
                <div class="card-hover bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl mb-4 text-orange-600"><i class="fas fa-chart-line"></i></div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Progress Tracking & Analytics</h3>
                    <p class="text-gray-600">Visualize your growth with detailed insights and performance metrics</p>
                </div>

                <!-- Feature 6 -->
                <div class="card-hover bg-white p-6 rounded-lg shadow">
                    <div class="text-4xl mb-4 text-indigo-600"><i class="fas fa-users"></i></div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Community & Collaboration</h3>
                    <p class="text-gray-600">Connect with peers, share knowledge, and grow together</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20 px-4 bg-gradient-to-r from-purple-50 to-pink-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">How SkillUp Works</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-purple-600 text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Discover Your Path</h3>
                    <p class="text-gray-600 text-sm">Take assessments and set your career goal</p>
                </div>

                <div class="text-center">
                    <div class="bg-pink-600 text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Learn & Practice</h3>
                    <p class="text-gray-600 text-sm">Engage with curated courses and micro-learning tasks</p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-600 text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Get Guidance</h3>
                    <p class="text-gray-600 text-sm">Receive feedback from mentors and peer community</p>
                </div>

                <div class="text-center">
                    <div class="bg-green-600 text-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Secure Opportunities</h3>
                    <p class="text-gray-600 text-sm">Apply to matched jobs and internships</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    <section id="testimonials" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-4 text-gray-800">Success Stories</h2>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Real stories from youth who transformed their careers with SkillUp</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-lg shadow card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-600 rounded-full mr-4 flex items-center justify-center text-white font-bold">AJ</div>
                        <div>
                            <p class="font-semibold text-gray-800">Christian John L. Agustin</p>
                            <p class="text-sm text-gray-600">Full Stack Developer</p>
                        </div>
                    </div>
                    <p class="text-yellow-400 mb-3"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                    <p class="text-gray-700">"SkillUp gave me the roadmap I needed. In 3 months, I went from confused about my career to landing my dream internship at a tech company."</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-lg shadow card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-pink-600 rounded-full mr-4 flex items-center justify-center text-white font-bold">SP</div>
                        <div>
                            <p class="font-semibold text-gray-800">Sarah Patel</p>
                            <p class="text-sm text-gray-600">Research Analyst</p>
                        </div>
                    </div>
                    <p class="text-yellow-400 mb-3"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                    <p class="text-gray-700">"The mentorship aspect is incredible. My mentor helped me build a portfolio that got me noticed by recruiters."</p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-lg shadow card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-full mr-4 flex items-center justify-center text-white font-bold">MR</div>
                        <div>
                            <p class="font-semibold text-gray-800">Marcus Rodriguez</p>
                            <p class="text-sm text-gray-600">Research Analyst</p>
                        </div>
                    </div>
                    <p class="text-yellow-400 mb-3"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></p>
                    <p class="text-gray-700">"The personalized learning paths saved me countless hours. I learned what I actually needed instead of drowning in content."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 gradient-secondary text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Transform Your Career?</h2>
            <p class="text-lg text-pink-100 mb-8">Join thousands of youth building their future with SkillUp today</p>
            <a href="/register" class="bg-white text-pink-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-pink-50 transition inline-block">
                Start Your Free Journey Now
            </a>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 px-4">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <!-- FAQ items -->
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>How much does SkillUp cost?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">SkillUp offers are all free tier with access to basic learning paths.</p>
                </details>
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>Do I need prior experience to join?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Not at all! SkillUp is designed for beginners. We have beginner-friendly paths for all career interests, from tech to creative industries.</p>
                </details>
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>Who are the mentors on SkillUp?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Our mentors are experienced professionals from various industries, all vetted and trained to provide quality guidance to our learners.</p>
                </details>
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>Can employers see my achievements on SkillUp?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Yes! You can create a professional profile and share your achievements, credentials, and portfolio with employers and recruiters.</p>
                </details>
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>How do I get started?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Simply sign up with your email, complete a brief career interest assessment, and we'll recommend personalized learning paths perfect for you!</p>
                </details>
            </div>
        </div>
    </section>
@endsection