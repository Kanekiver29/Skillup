@extends('layout.app')

@section('title', 'Cookie Policy - SkillUp')

@section('content')
	<!-- Hero Section -->
	<section class="pt-32 pb-20 px-4 gradient-primary text-white">
		<div class="max-w-4xl mx-auto text-center">
			<h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fade-in">
				Cookie Policy
			</h1>
			<p class="text-lg md:text-xl text-purple-100 max-w-2xl mx-auto animate-fade-in">
				Learn how SkillUp uses cookies and similar technologies to improve your learning experience.
			</p>
			<p class="text-purple-200 mt-4 text-sm">Last updated: March 17, 2026</p>
		</div>
	</section>

	<!-- Table of Contents -->
	<section class="py-10 px-4 bg-white border-b">
		<div class="max-w-4xl mx-auto">
			<h2 class="text-lg font-bold text-gray-700 mb-4">
				<i class="fas fa-list-ul text-purple-600 mr-2"></i> Table of Contents
			</h2>
			<ol class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-purple-600 list-decimal list-inside">
				<li><a href="#what-are-cookies" class="hover:text-purple-800 hover:underline">What Are Cookies?</a></li>
				<li><a href="#cookie-types" class="hover:text-purple-800 hover:underline">Types of Cookies We Use</a></li>
				<li><a href="#why-we-use" class="hover:text-purple-800 hover:underline">Why We Use Cookies</a></li>
				<li><a href="#third-party" class="hover:text-purple-800 hover:underline">Third-Party Cookies</a></li>
				<li><a href="#manage-cookies" class="hover:text-purple-800 hover:underline">How to Manage Cookies</a></li>
				<li><a href="#retention" class="hover:text-purple-800 hover:underline">Cookie Retention Periods</a></li>
				<li><a href="#do-not-track" class="hover:text-purple-800 hover:underline">Do Not Track Signals</a></li>
				<li><a href="#policy-updates" class="hover:text-purple-800 hover:underline">Updates to This Policy</a></li>
				<li><a href="#contact" class="hover:text-purple-800 hover:underline">Contact Us</a></li>
			</ol>
		</div>
	</section>

	<!-- Cookie Policy Content -->
	<section class="py-16 px-4">
		<div class="max-w-4xl mx-auto space-y-14">

			<div id="what-are-cookies" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">1</span>
					<h2 class="text-2xl font-bold text-gray-800">What Are Cookies?</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						Cookies are small text files stored on your browser or device when you visit a website. They help websites remember your actions and preferences over time.
					</p>
					<p>
						In this policy, "cookies" also refers to similar technologies such as local storage, pixels, and tags used for analytics and functionality.
					</p>
				</div>
			</div>

			<div id="cookie-types" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">2</span>
					<h2 class="text-2xl font-bold text-gray-800">Types of Cookies We Use</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-4">
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<div class="bg-green-50 border border-green-100 rounded-lg p-5">
							<h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-lock text-green-600 mr-2"></i>Strictly Necessary</h3>
							<p class="text-sm">Required for core features like login sessions, security checks, and page navigation.</p>
						</div>
						<div class="bg-blue-50 border border-blue-100 rounded-lg p-5">
							<h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-sliders-h text-blue-600 mr-2"></i>Preference Cookies</h3>
							<p class="text-sm">Remember settings such as language, interface preferences, and display options.</p>
						</div>
						<div class="bg-purple-50 border border-purple-100 rounded-lg p-5">
							<h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-chart-line text-purple-600 mr-2"></i>Analytics Cookies</h3>
							<p class="text-sm">Help us understand usage patterns so we can improve lessons, navigation, and performance.</p>
						</div>
						<div class="bg-orange-50 border border-orange-100 rounded-lg p-5">
							<h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-bullhorn text-orange-600 mr-2"></i>Functional and Campaign Cookies</h3>
							<p class="text-sm">Support helpful feature experiments and measure outreach campaign effectiveness.</p>
						</div>
					</div>
				</div>
			</div>

			<div id="why-we-use" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">3</span>
					<h2 class="text-2xl font-bold text-gray-800">Why We Use Cookies</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<ul class="space-y-2">
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Keep you signed in securely between pages</span></li>
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Save preferences to reduce repeated setup</span></li>
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Measure learning activity to improve course design</span></li>
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Detect suspicious behavior and prevent abuse</span></li>
					</ul>
				</div>
			</div>

			<div id="third-party" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">4</span>
					<h2 class="text-2xl font-bold text-gray-800">Third-Party Cookies</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						Some cookies are set by trusted third-party services integrated with SkillUp, such as analytics, content delivery, and security providers.
					</p>
					<p>
						These providers process data according to their own policies. We recommend reviewing their privacy and cookie practices.
					</p>
				</div>
			</div>

			<div id="manage-cookies" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">5</span>
					<h2 class="text-2xl font-bold text-gray-800">How to Manage Cookies</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						You can control and delete cookies from your browser settings. Most browsers allow you to block all cookies, only third-party cookies, or clear cookies when you close your browser.
					</p>
					<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 text-sm">
						<i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
						Blocking necessary cookies may prevent sign-in, enrollment tracking, and other core platform features from working properly.
					</div>
				</div>
			</div>

			<div id="retention" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">6</span>
					<h2 class="text-2xl font-bold text-gray-800">Cookie Retention Periods</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						Some cookies are session-based and expire when you close your browser. Others are persistent and remain for a defined period to remember your settings on future visits.
					</p>
					<p>
						Retention periods vary depending on the cookie purpose and legal requirements.
					</p>
				</div>
			</div>

			<div id="do-not-track" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">7</span>
					<h2 class="text-2xl font-bold text-gray-800">Do Not Track Signals</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						Some browsers support a "Do Not Track" (DNT) setting. Because there is no consistent industry standard for interpreting DNT signals, SkillUp may not respond uniformly to all DNT requests.
					</p>
				</div>
			</div>

			<div id="policy-updates" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">8</span>
					<h2 class="text-2xl font-bold text-gray-800">Updates to This Policy</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						We may update this Cookie Policy to reflect legal, technical, or operational changes. Any updates will be posted on this page with a revised "Last updated" date.
					</p>
				</div>
			</div>

			<div id="contact" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">9</span>
					<h2 class="text-2xl font-bold text-gray-800">Contact Us</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>If you have questions about our use of cookies, contact us:</p>
					<div class="bg-gray-50 border border-gray-200 rounded-lg p-6 space-y-3">
						<div class="flex items-center">
							<i class="fas fa-envelope text-purple-600 w-6"></i>
							<a href="mailto:privacy@skillup.com" class="text-purple-600 hover:underline ml-2">privacy@skillup.com</a>
						</div>
						<div class="flex items-center">
							<i class="fas fa-map-marker-alt text-purple-600 w-6"></i>
							<span class="ml-2">SkillUp, 123 Learning Lane, Tech City, TC 00000</span>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
@endsection
