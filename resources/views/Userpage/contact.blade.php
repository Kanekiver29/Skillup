@extends('layout.app')

@section('title', 'Contact Us - SkillUp Support')

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 gradient-primary text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fade-in">
                Let's Stay Connected
            </h1>
            <p class="text-lg md:text-xl text-purple-100 max-w-2xl mx-auto animate-fade-in">
                Have questions about SkillUp? We're here to help you succeed in your learning journey.
                Reach out to our support team anytime.
            </p>
        </div>
    </section>

    <!-- Quick Contact Methods -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Email Support -->
                <div class="bg-white p-8 rounded-lg shadow-md text-center card-hover">
                    <div class="text-5xl mb-4 text-purple-600">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Email Support</h3>
                    <p class="text-gray-600 mb-4">Get in touch with our support team</p>
                    <a href="mailto:support@skillup.com" class="text-purple-600 font-semibold hover:text-purple-700">
                        support@skillup.com
                    </a>
                    <p class="text-sm text-gray-500 mt-3">We respond within 24 hours</p>
                </div>

                <!-- Phone Support -->
                <div class="bg-white p-8 rounded-lg shadow-md text-center card-hover">
                    <div class="text-5xl mb-4 text-pink-600">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Phone Support</h3>
                    <p class="text-gray-600 mb-4">Call us directly</p>
                    <a href="tel:+1234567890" class="text-pink-600 font-semibold hover:text-pink-700">
                        +1 (234) 567-890
                    </a>
                    <p class="text-sm text-gray-500 mt-3">Mon-Fri, 9AM - 6PM EST</p>
                </div>

                <!-- Live Chat -->
                <div class="bg-white p-8 rounded-lg shadow-md text-center card-hover">
                    <div class="text-5xl mb-4 text-blue-600">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Live Chat</h3>
                    <p class="text-gray-600 mb-4">Chat with our team instantly</p>
                    <button class="text-blue-600 font-semibold hover:text-blue-700">
                        Open Chat
                    </button>
                    <p class="text-sm text-gray-500 mt-3">Available 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-20 px-4">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Send Us a Message</h2>
                <p class="text-gray-600">Fill out the form below and we'll get back to you as soon as possible</p>
            </div>

            <form class="bg-white p-8 rounded-lg shadow-lg" method="POST" action="#">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name *
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-200" 
                            placeholder="Your full name"
                        >
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address *
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-200" 
                            placeholder="your@email.com"
                        >
                    </div>
                </div>

                <!-- Subject Field -->
                <div class="mb-6">
                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                        Subject *
                    </label>
                    <select 
                        id="subject" 
                        name="subject" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-200"
                    >
                        <option value="">Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="courses">Course Questions</option>
                        <option value="mentorship">Mentorship Program</option>
                        <option value="partnership">Partnership Opportunities</option>
                        <option value="bug">Report a Bug</option>
                        <option value="feedback">Feedback & Suggestions</option>
                    </select>
                </div>

                <!-- Message Field -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                        Message *
                    </label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="6" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-200" 
                        placeholder="Tell us more about your inquiry..."
                    ></textarea>
                </div>

                <!-- Phone Field (Optional) -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        Phone Number (Optional)
                    </label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600 focus:ring-2 focus:ring-purple-200" 
                        placeholder="+63 951 340 1097"
                    >
                </div>

                <!-- Checkbox -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="subscribe" 
                            class="w-4 h-4 text-purple-600 rounded focus:ring-purple-600"
                        >
                        <span class="ml-2 text-sm text-gray-600">Subscribe to our newsletter for updates and tips</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transition duration-300"
                >
                    Send Message <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>
    </section>

    <!-- Office Locations -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Our Locations</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Location 1 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">
                        <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>
                        Aparri, Cagayan
                    </h3>
                    <p class="text-gray-600 mb-2">#33 Mendoza St.</p>
                    <p class="text-gray-600 mb-2">Macanaya, Aparri, Cagayan</p>
                    <p class="text-gray-600 mb-4">Philippines</p>
                    <p class="text-sm text-purple-600 font-semibold">info@skillup.com</p>
                </div>

                <!-- Location 2 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">
                        <i class="fas fa-map-marker-alt text-pink-600 mr-2"></i>
                        London
                    </h3>
                    <p class="text-gray-600 mb-2">456 Innovation Avenue</p>
                    <p class="text-gray-600 mb-2">London, E1 6AN</p>
                    <p class="text-gray-600 mb-4">United Kingdom</p>
                    <p class="text-sm text-pink-600 font-semibold">uk@skillup.com</p>
                </div>

                <!-- Location 3 -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">
                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                        Singapore
                    </h3>
                    <p class="text-gray-600 mb-2">789 Future Hub</p>
                    <p class="text-gray-600 mb-2">Singapore, 068814</p>
                    <p class="text-gray-600 mb-4">Singapore</p>
                    <p class="text-sm text-blue-600 font-semibold">asia@skillup.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 px-4">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Before You Contact Us</h2>
            
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>How do I reset my password?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Click the "Forgot Password" link on the login page, enter your email, and follow the instructions sent to your inbox. You'll be able to set a new password within 15 minutes.</p>
                </details>

                <!-- FAQ Item 2 -->
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>Can I get a refund?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Since SkillUp offers free access to all learning paths, there are no refunds to process. However, if you've been charged incorrectly, please contact our billing support team immediately.</p>
                </details>

                <!-- FAQ Item 3 -->
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>How do I contact my mentor?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Once you're enrolled in the mentorship program, you can message your mentor directly through the Messages section in your dashboard. Most mentors respond within 48 hours.</p>
                </details>

                <!-- FAQ Item 4 -->
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>How can I become a mentor?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">We'd love to have you! Fill out our mentor application form through your profile settings. We look for professionals with at least 3 years of industry experience and a passion for helping others.</p>
                </details>

                <!-- FAQ Item 5 -->
                <details class="bg-white p-6 rounded-lg shadow cursor-pointer group">
                    <summary class="font-bold text-lg text-gray-800 flex justify-between items-center">
                        <span>Is my data secure on SkillUp?</span>
                        <i class="fas fa-chevron-down text-purple-600 group-open:rotate-180 transition"></i>
                    </summary>
                    <p class="text-gray-600 mt-4">Yes! We use industry-standard encryption, regular security audits, and comply with GDPR and CCPA regulations. Your data is never shared with third parties without your consent.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- Support Response Times -->
    <section class="py-20 px-4 bg-gradient-to-r from-purple-50 to-pink-50">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Response Times</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Priority Support -->
                <div class="bg-white p-8 rounded-lg shadow-md border-l-4 border-purple-600">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Urgent Issues
                    </h3>
                    <p class="text-gray-600 mb-4">Account access, security concerns, or system errors</p>
                    <p class="text-2xl font-bold text-purple-600">2-4 hours</p>
                    <p class="text-sm text-gray-500 mt-2">Priority support response</p>
                </div>

                <!-- General Support -->
                <div class="bg-white p-8 rounded-lg shadow-md border-l-4 border-pink-600">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">
                        <i class="fas fa-envelope text-pink-600 mr-2"></i>
                        General Inquiries
                    </h3>
                    <p class="text-gray-600 mb-4">Course questions, feature requests, feedback</p>
                    <p class="text-2xl font-bold text-pink-600">24 hours</p>
                    <p class="text-sm text-gray-500 mt-2">Standard support response</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 px-4 gradient-secondary text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg text-pink-100 mb-8">Join our community and transform your career with SkillUp</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="/courses" class="bg-white text-pink-600 px-8 py-3 rounded-lg font-bold hover:bg-pink-50 transition">
                        Explore Courses <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endauth
                @guest
                    <a href="/register" class="bg-white text-pink-600 px-8 py-3 rounded-lg font-bold hover:bg-pink-50 transition">
                        Sign Up Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @endguest
                <a href="/" class="border-2 border-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-pink-600 transition">
                    Back to Home
                </a>
            </div>
        </div>
    </section>
@endsection