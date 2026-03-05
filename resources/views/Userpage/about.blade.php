@extends('layout.app')

@section('title', 'About SkillUp - Personalized Web Learning for Youth Career Development')

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 gradient-primary text-white">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in">
                About SkillUp
            </h1>
            <p class="text-lg md:text-xl text-purple-100 mb-8 max-w-2xl mx-auto animate-fade-in">
                Personalized Web Learning for Youth Career Development
            </p>
            <p class="text-purple-200 max-w-3xl mx-auto text-lg leading-relaxed">
                We believe every young person deserves the opportunity to discover their potential, develop in-demand skills, and build a fulfilling career.
            </p>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="mission" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div>
                    <h2 class="text-4xl font-bold mb-6 text-gray-800">Our Mission</h2>
                    <p class="text-lg text-gray-700 mb-4 leading-relaxed">
                        At SkillUp, our mission is to bridge the critical gap between traditional education and the modern job market. We empower youth to take control of their career development with personalized.
                    </p>
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        We combine intelligent technology with human mentorship to create transformative learning experiences that develop both technical and soft skills while connecting learners with real-world opportunities.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-4 mt-1 text-xl"></i>
                            <span class="text-gray-700"><strong>Personalize</strong> - Learning tailored to your unique goals and learning style</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-4 mt-1 text-xl"></i>
                            <span class="text-gray-700"><strong>Develop</strong> - In-demand skills across multiple industries</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-4 mt-1 text-xl"></i>
                            <span class="text-gray-700"><strong>Connect</strong> - Direct access to mentors and career opportunities</span>
                        </li>
                    </ul>
                </div>
                <!-- Visual -->
                <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg p-8 text-center">
                    <i class="fas fa-bullseye text-6xl text-purple-600 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Commitment</h3>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        We are committed to making quality career education accessible to every young person, regardless of their background or current circumstances. Your success is our success.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Section -->
    <section id="vision" class="py-20 px-4 bg-gradient-to-r from-purple-50 to-pink-50">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Visual -->
                <div class="bg-white rounded-lg p-8 text-center order-2 lg:order-1">
                    <i class="fas fa-telescope text-6xl text-pink-600 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Vision</h3>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        A world where every young person has equitable access to career guidance, quality education, and meaningful opportunities to build the life they want to live.
                    </p>
                </div>
                <!-- Content -->
                <div class="order-1 lg:order-2">
                    <h2 class="text-4xl font-bold mb-6 text-gray-800">Our Vision for the Future</h2>
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        We envision a global community where career development is personalized, accessible, and transformative. Where youth don't just find jobs, but build careers they're passionate about.
                    </p>
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg border-l-4 border-purple-600">
                            <h4 class="font-bold text-gray-800 mb-2">Inclusive Growth</h4>
                            <p class="text-gray-600">Making quality career education available to students from all backgrounds</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border-l-4 border-pink-600">
                            <h4 class="font-bold text-gray-800 mb-2">Technology-Enabled Learning</h4>
                            <p class="text-gray-600">Harnessing the and data to create personalized, effective learning experiences</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border-l-4 border-blue-600">
                            <h4 class="font-bold text-gray-800 mb-2">Human Connection</h4>
                            <p class="text-gray-600">Mentorship and community that inspire and guide at every step</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section id="values" class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="card-hover bg-white p-8 rounded-lg shadow">
                    <div class="text-5xl text-purple-600 mb-4"><i class="fas fa-heart"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Empowerment</h3>
                    <p class="text-gray-600">We believe in empowering youth to take control of their own career destiny through knowledge, skills, and confidence.</p>
                </div>

                <!-- Value 2 -->
                <div class="card-hover bg-white p-8 rounded-lg shadow">
                    <div class="text-5xl text-pink-600 mb-4"><i class="fas fa-hands-helping"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Inclusivity</h3>
                    <p class="text-gray-600">Everyone deserves access to quality career education. We're committed to removing barriers and serving diverse communities.</p>
                </div>

                <!-- Value 3 -->
                <div class="card-hover bg-white p-8 rounded-lg shadow">
                    <div class="text-5xl text-blue-600 mb-4"><i class="fas fa-lightbulb"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Innovation</h3>
                    <p class="text-gray-600">We continuously evolve our platform with the latest technology and educational best practices to deliver cutting-edge learning.</p>
                </div>

                <!-- Value 4 -->
                <div class="card-hover bg-white p-8 rounded-lg shadow">
                    <div class="text-5xl text-green-600 mb-4"><i class="fas fa-handshake"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Integrity</h3>
                    <p class="text-gray-600">We operate with transparency and honesty, always putting your best interests at the center of everything we do.</p>
                </div>

                <!-- Value 5 -->
                <div class="card-hover bg-white p-8 rounded-lg shadow">
                    <div class="text-5xl text-orange-600 mb-4"><i class="fas fa-chart-line"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Excellence</h3>
                    <p class="text-gray-600">We're committed to delivering exceptional quality in everything—from content to mentorship to career placements.</p>
                </div>

                <!-- Value 6 -->
                <div class="card-hover bg-white p-8 rounded-lg shadow">
                    <div class="text-5xl text-indigo-600 mb-4"><i class="fas fa-users"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Community</h3>
                    <p class="text-gray-600">We foster a supportive ecosystem where learners, mentors, and employers collaborate and grow together.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What Sets Us Apart -->
    <section class="py-20 px-4 bg-gradient-to-r from-purple-50 to-pink-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">What Sets SkillUp Apart</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-lg shadow">
                    <div class="flex items-start">
                        <i class="fas fa-robot text-4xl text-purple-600 mr-4 mt-2"></i>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Social Skill Personalization</h3>
                            <p class="text-gray-600">Advanced algorithms analyze your learning style, pace, and goals to recommend the perfect learning path for you—no cookie-cutter approach.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-lg shadow">
                    <div class="flex items-start">
                        <i class="fas fa-user-graduate text-4xl text-pink-600 mr-4 mt-2"></i>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Expert Mentorship</h3>
                            <p class="text-gray-600">Learn directly from industry professionals who provide personalized guidance, feedback, and career advice beyond what courses can offer.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-lg shadow">
                    <div class="flex items-start">
                        <i class="fas fa-briefcase text-4xl text-blue-600 mr-4 mt-2"></i>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Employment Focused</h3>
                            <p class="text-gray-600">Every learning path is designed with employment outcomes in mind. We connect you with real internships and job opportunities that match your skills.</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-lg shadow">
                    <div class="flex items-start">
                        <i class="fas fa-globe text-4xl text-green-600 mr-4 mt-2"></i>
                        <div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Global Community</h3>
                            <p class="text-gray-600">Join thousands of youth from around the world on similar career journeys, share experiences, and build your professional network.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact by Numbers -->
    <section class="py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">Our Impact</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow text-center card-hover">
                    <p class="text-4xl font-bold gradient-primary bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">10K+</p>
                    <p class="text-gray-800 font-semibold">Active Learners</p>
                    <p class="text-gray-600 text-sm">Youth pursuing their career goals</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center card-hover">
                    <p class="text-4xl font-bold gradient-primary bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">500+</p>
                    <p class="text-gray-800 font-semibold">Learning Paths</p>
                    <p class="text-gray-600 text-sm">Diverse career options</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center card-hover">
                    <p class="text-4xl font-bold gradient-primary bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">2K+</p>
                    <p class="text-gray-800 font-semibold">Placements</p>
                    <p class="text-gray-600 text-sm">Jobs & internships secured</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow text-center card-hover">
                    <p class="text-4xl font-bold gradient-primary bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">4.8★</p>
                    <p class="text-gray-800 font-semibold">User Rating</p>
                    <p class="text-gray-600 text-sm">Satisfaction & trust</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 px-4 bg-gradient-to-r from-purple-50 to-pink-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">How SkillUp Helps You</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="bg-purple-600 text-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 text-3xl font-bold">1</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Assessment</h3>
                    <p class="text-gray-600">Take a career assessment to understand your strengths, interests, and goals</p>
                </div>
                <div class="text-center">
                    <div class="bg-pink-600 text-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 text-3xl font-bold">2</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Personalization</h3>
                    <p class="text-gray-600">Receive AI-powered recommendations tailored to your unique profile</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-600 text-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 text-3xl font-bold">3</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Learning</h3>
                    <p class="text-gray-600">Learn through interactive courses, mentorship, and real-world projects</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-600 text-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 text-3xl font-bold">4</div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800">Opportunity</h3>
                    <p class="text-gray-600">Secure internships, jobs, and opportunities aligned with your journey</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 px-4 gradient-secondary text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Take the Next Step?</h2>
            <p class="text-lg text-pink-100 mb-8">Start exploring personalized learning paths tailored just for you</p>
            <a href="/dashboard" class="bg-white text-pink-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-pink-50 transition inline-block">
                Go to Your Dashboard <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>
@endsection
