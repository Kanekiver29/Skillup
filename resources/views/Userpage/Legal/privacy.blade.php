@extends('layout.app')

@section('title', 'Privacy Policy - SkillUp')

@section('content')
	<!-- Hero Section -->
	<section class="pt-32 pb-20 px-4 gradient-primary text-white">
		<div class="max-w-4xl mx-auto text-center">
			<h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fade-in">
				Privacy Policy
			</h1>
			<p class="text-lg md:text-xl text-purple-100 max-w-2xl mx-auto animate-fade-in">
				Learn how SkillUp collects, uses, stores, and protects your information.
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
				<li><a href="#information-we-collect" class="hover:text-purple-800 hover:underline">Information We Collect</a></li>
				<li><a href="#how-we-use" class="hover:text-purple-800 hover:underline">How We Use Your Information</a></li>
				<li><a href="#sharing" class="hover:text-purple-800 hover:underline">How We Share Information</a></li>
				<li><a href="#cookies" class="hover:text-purple-800 hover:underline">Cookies and Tracking</a></li>
				<li><a href="#security" class="hover:text-purple-800 hover:underline">Data Security</a></li>
				<li><a href="#retention" class="hover:text-purple-800 hover:underline">Data Retention</a></li>
				<li><a href="#your-rights" class="hover:text-purple-800 hover:underline">Your Privacy Rights</a></li>
				<li><a href="#children" class="hover:text-purple-800 hover:underline">Children's Privacy</a></li>
				<li><a href="#international" class="hover:text-purple-800 hover:underline">International Transfers</a></li>
				<li><a href="#changes" class="hover:text-purple-800 hover:underline">Changes to This Policy</a></li>
				<li><a href="#contact" class="hover:text-purple-800 hover:underline">Contact Us</a></li>
			</ol>
		</div>
	</section>

	<!-- Privacy Content -->
	<section class="py-16 px-4">
		<div class="max-w-4xl mx-auto space-y-14">

			<div id="information-we-collect" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">1</span>
					<h2 class="text-2xl font-bold text-gray-800">Information We Collect</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-4">
					<p>
						We collect information that helps us provide, improve, and secure the SkillUp platform. This includes information you provide directly and data collected automatically during use.
					</p>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<div class="bg-purple-50 border border-purple-100 rounded-lg p-5">
							<h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-user text-purple-600 mr-2"></i>Information You Provide</h3>
							<ul class="space-y-2 text-sm">
								<li>Full name, username, and email address</li>
								<li>Account credentials and profile details</li>
								<li>Course activity, quiz responses, and submissions</li>
								<li>Support messages and feedback</li>
							</ul>
						</div>
						<div class="bg-blue-50 border border-blue-100 rounded-lg p-5">
							<h3 class="font-semibold text-gray-800 mb-2"><i class="fas fa-chart-line text-blue-600 mr-2"></i>Information Collected Automatically</h3>
							<ul class="space-y-2 text-sm">
								<li>Device and browser type</li>
								<li>IP address and approximate location</li>
								<li>Pages visited and session duration</li>
								<li>Error logs and performance diagnostics</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div id="how-we-use" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">2</span>
					<h2 class="text-2xl font-bold text-gray-800">How We Use Your Information</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>We process personal data only when needed to operate our services and deliver learning outcomes.</p>
					<ul class="space-y-2">
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Create and manage your account</span></li>
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Track course enrollments and progress</span></li>
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Personalize recommendations and learning paths</span></li>
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Respond to support requests and security incidents</span></li>
						<li class="flex items-start"><i class="fas fa-check text-green-500 mr-2 mt-1 shrink-0"></i><span>Comply with legal and regulatory obligations</span></li>
					</ul>
				</div>
			</div>

			<div id="sharing" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">3</span>
					<h2 class="text-2xl font-bold text-gray-800">How We Share Information</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>We do not sell your personal information. We may share limited data under the following circumstances:</p>
					<div class="space-y-3">
						<div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
							<strong class="text-gray-800">Service providers:</strong> Vendors who help with hosting, analytics, customer support, and security.
						</div>
						<div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
							<strong class="text-gray-800">Legal compliance:</strong> If required by law, subpoena, or valid government request.
						</div>
						<div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
							<strong class="text-gray-800">Business changes:</strong> During a merger, acquisition, or asset transfer, subject to confidentiality protections.
						</div>
					</div>
				</div>
			</div>

			<div id="cookies" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">4</span>
					<h2 class="text-2xl font-bold text-gray-800">Cookies and Tracking Technologies</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						SkillUp uses cookies and similar technologies to keep you signed in, remember preferences, and understand platform usage.
					</p>
					<p>
						You can manage cookies in your browser settings. Disabling some cookies may affect site functionality and learning experience.
					</p>
					<p>
						For details, review our <a href="{{ route('cookie-policy') }}" class="text-purple-600 hover:underline font-medium">Cookie Policy</a>.
					</p>
				</div>
			</div>

			<div id="security" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">5</span>
					<h2 class="text-2xl font-bold text-gray-800">Data Security</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<div class="bg-yellow-50 border border-yellow-200 rounded-lg p-5 text-sm">
						<i class="fas fa-shield-alt text-yellow-600 mr-2"></i>
						We implement technical and organizational safeguards designed to protect your data against unauthorized access, loss, misuse, or alteration.
					</div>
					<p>
						Although we apply strong security controls, no online service is 100% secure. We recommend using strong passwords and keeping your login details private.
					</p>
				</div>
			</div>

			<div id="retention" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">6</span>
					<h2 class="text-2xl font-bold text-gray-800">Data Retention</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						We keep personal information only for as long as necessary to provide services, maintain records, resolve disputes, and comply with legal obligations.
					</p>
					<p>
						If you request account deletion, we will remove or anonymize your data unless retention is required by law or for legitimate security and fraud-prevention purposes.
					</p>
				</div>
			</div>

			<div id="your-rights" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">7</span>
					<h2 class="text-2xl font-bold text-gray-800">Your Privacy Rights</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>Depending on your location, you may have rights to:</p>
					<ul class="space-y-2">
						<li class="flex items-start"><i class="fas fa-angle-right text-purple-600 mr-2 mt-1 shrink-0"></i><span>Access the personal data we hold about you</span></li>
						<li class="flex items-start"><i class="fas fa-angle-right text-purple-600 mr-2 mt-1 shrink-0"></i><span>Correct inaccurate or incomplete information</span></li>
						<li class="flex items-start"><i class="fas fa-angle-right text-purple-600 mr-2 mt-1 shrink-0"></i><span>Request deletion of personal data</span></li>
						<li class="flex items-start"><i class="fas fa-angle-right text-purple-600 mr-2 mt-1 shrink-0"></i><span>Object to or restrict certain processing activities</span></li>
						<li class="flex items-start"><i class="fas fa-angle-right text-purple-600 mr-2 mt-1 shrink-0"></i><span>Request a copy of your data in portable format</span></li>
					</ul>
					<p>
						To exercise these rights, contact us at <a href="mailto:privacy@skillup.com" class="text-purple-600 hover:underline">privacy@skillup.com</a>.
					</p>
				</div>
			</div>

			<div id="children" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">8</span>
					<h2 class="text-2xl font-bold text-gray-800">Children's Privacy</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						SkillUp is not intended for children under 13 without parental consent. We do not knowingly collect personal information from children under applicable minimum age thresholds.
					</p>
					<p>
						If you believe a child has submitted personal data without proper consent, please contact us so we can investigate and take action.
					</p>
				</div>
			</div>

			<div id="international" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">9</span>
					<h2 class="text-2xl font-bold text-gray-800">International Data Transfers</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						Your information may be processed in countries outside your own. When this happens, we apply appropriate safeguards to ensure your personal data remains protected.
					</p>
				</div>
			</div>

			<div id="changes" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">10</span>
					<h2 class="text-2xl font-bold text-gray-800">Changes to This Privacy Policy</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>
						We may update this policy periodically to reflect legal, technical, or business changes. We will post updates on this page and revise the "Last updated" date.
					</p>
					<p>
						Significant changes may also be communicated by email or in-app notice where required.
					</p>
				</div>
			</div>

			<div id="contact" class="scroll-mt-24">
				<div class="flex items-center mb-4">
					<span class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold mr-4 shrink-0">11</span>
					<h2 class="text-2xl font-bold text-gray-800">Contact Us</h2>
				</div>
				<div class="pl-14 text-gray-700 leading-relaxed space-y-3">
					<p>If you have questions or requests related to privacy, contact us:</p>
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
