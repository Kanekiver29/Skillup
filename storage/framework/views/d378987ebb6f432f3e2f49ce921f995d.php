

<?php $__env->startSection('title', 'Company Contact - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
	<section class="pt-32 pb-20 px-4 gradient-primary text-white relative overflow-hidden">
		<div class="absolute -top-16 -left-10 w-56 h-56 rounded-full bg-white/10 blur-3xl"></div>
		<div class="absolute -bottom-16 -right-8 w-64 h-64 rounded-full bg-pink-200/20 blur-3xl"></div>

		<div class="max-w-6xl mx-auto relative">
			<nav class="text-sm text-purple-100 mb-6" aria-label="Breadcrumb">
				<ol class="flex flex-wrap items-center gap-2">
					<li><a href="/" class="hover:text-white transition">Home</a></li>
					<li><i class="fas fa-angle-right text-xs"></i></li>
					<li><a href="<?php echo e(route('company.aboutus')); ?>" class="hover:text-white transition">Company</a></li>
					<li><i class="fas fa-angle-right text-xs"></i></li>
					<li><span class="text-white font-medium">Contact</span></li>
				</ol>
			</nav>

			<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-center">
				<div class="lg:col-span-3">
					<p class="uppercase tracking-[0.2em] text-sm text-purple-100 mb-4">Company Contact</p>
					<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 animate-fade-in">Talk To The SkillUp Team</h1>
					<p class="text-lg md:text-xl text-purple-100 leading-relaxed max-w-2xl">
						Questions about partnerships, press, careers, or platform collaboration? Reach out and we will direct your message to the right team.
					</p>
				</div>

				<div class="lg:col-span-2 bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-6">
					<p class="text-sm uppercase tracking-wider text-purple-100 mb-3">Response Commitments</p>
					<div class="space-y-3">
						<div class="bg-white/10 rounded-lg p-4 flex items-center justify-between">
							<span class="text-sm">General inquiries</span>
							<span class="font-bold">24h</span>
						</div>
						<div class="bg-white/10 rounded-lg p-4 flex items-center justify-between">
							<span class="text-sm">Partnership requests</span>
							<span class="font-bold">48h</span>
						</div>
						<div class="bg-white/10 rounded-lg p-4 flex items-center justify-between">
							<span class="text-sm">Urgent support</span>
							<span class="font-bold">Same day</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="py-16 px-4 bg-white">
		<div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
			<article class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center card-hover">
				<i class="fas fa-envelope text-3xl text-purple-600 mb-4"></i>
				<h2 class="text-xl font-bold text-gray-800 mb-2">Email</h2>
				<p class="text-gray-600 text-sm mb-3">For partnerships and business inquiries</p>
				<a href="mailto:hello@skillup.com" class="font-semibold text-purple-600 hover:text-purple-700">hello@skillup.com</a>
			</article>

			<article class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center card-hover">
				<i class="fas fa-phone text-3xl text-pink-600 mb-4"></i>
				<h2 class="text-xl font-bold text-gray-800 mb-2">Phone</h2>
				<p class="text-gray-600 text-sm mb-3">Mon-Fri, 9:00 AM to 6:00 PM</p>
				<a href="tel:+639513401097" class="font-semibold text-pink-600 hover:text-pink-700">+63 951 340 1097</a>
			</article>

			<article class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center card-hover">
				<i class="fas fa-comments text-3xl text-blue-600 mb-4"></i>
				<h2 class="text-xl font-bold text-gray-800 mb-2">Live Chat</h2>
				<p class="text-gray-600 text-sm mb-3">Best for account and technical help</p>
				<button type="button" class="font-semibold text-blue-600 hover:text-blue-700">Start Chat</button>
			</article>
		</div>
	</section>

	<section class="py-16 px-4 bg-gray-50">
		<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
			<div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-7 md:p-8">
				<h2 class="text-3xl font-bold text-gray-800 mb-2">Send A Message</h2>
				<p class="text-gray-600 mb-7">Share details and we will route your message to the right department.</p>

				<form action="#" method="POST" class="space-y-5" aria-label="Company contact form">
					<?php echo csrf_field(); ?>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
						<div>
							<label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
							<input id="full_name" name="full_name" type="text" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Your full name">
						</div>
						<div>
							<label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
							<input id="email" name="email" type="email" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="name@example.com">
						</div>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
						<div>
							<label for="department" class="block text-sm font-semibold text-gray-700 mb-2">Department *</label>
							<select id="department" name="department" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500">
								<option value="">Select department</option>
								<option value="support">Support</option>
								<option value="partnerships">Partnerships</option>
								<option value="careers">Careers</option>
								<option value="press">Press</option>
							</select>
						</div>
						<div>
							<label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
							<input id="subject" name="subject" type="text" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="How can we help?">
						</div>
					</div>

					<div>
						<label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
						<textarea id="message" name="message" rows="6" maxlength="1200" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Tell us about your request"></textarea>
						<div class="text-xs text-gray-500 mt-2 text-right"><span id="message-count">0</span>/1200</div>
					</div>

					<div class="flex items-start gap-3">
						<input id="consent" name="consent" type="checkbox" required class="mt-1 w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
						<label for="consent" class="text-sm text-gray-600">I agree to the processing of my information in line with SkillUp privacy practices.</label>
					</div>

					<button type="submit" class="w-full md:w-auto gradient-secondary text-white font-semibold px-8 py-3 rounded-lg hover:opacity-90 transition">Send Message</button>
				</form>
			</div>

			<aside class="space-y-6">
				<div class="bg-white border border-gray-200 rounded-2xl p-6">
					<h3 class="text-xl font-bold text-gray-800 mb-4">Office Hours</h3>
					<ul class="space-y-2 text-sm text-gray-600">
						<li class="flex justify-between"><span>Monday - Friday</span><span>09:00 - 18:00</span></li>
						<li class="flex justify-between"><span>Saturday</span><span>10:00 - 14:00</span></li>
						<li class="flex justify-between"><span>Sunday</span><span>Closed</span></li>
					</ul>
				</div>

				<div class="bg-white border border-gray-200 rounded-2xl p-6">
					<h3 class="text-xl font-bold text-gray-800 mb-3">Main Office</h3>
					<p class="text-sm text-gray-600 leading-relaxed">
						33 Mendoza Street, Macanaya,<br>
						Aparri, Cagayan, Philippines
					</p>
					<a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm text-purple-600 font-semibold mt-4 hover:text-purple-700">
						Open in Maps <i class="fas fa-arrow-up-right-from-square ml-2 text-xs"></i>
					</a>
				</div>

				<div class="bg-linear-to-br from-indigo-50 to-pink-50 border border-indigo-100 rounded-2xl p-6">
					<h3 class="text-xl font-bold text-gray-800 mb-3">Need Learner Help?</h3>
					<p class="text-sm text-gray-600 mb-4">For account or course support, our learner help center can assist faster.</p>
					<a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700">Open Support Contact <i class="fas fa-arrow-right ml-2 text-xs"></i></a>
				</div>
			</aside>
		</div>
	</section>

	<section class="py-16 px-4 bg-white">
		<div class="max-w-4xl mx-auto">
			<h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Frequently Asked Questions</h2>
			<div class="space-y-3">
				<details class="bg-gray-50 border border-gray-200 rounded-lg p-5" open>
					<summary class="font-semibold text-gray-800 cursor-pointer">Where should I send partnership proposals?</summary>
					<p class="text-sm text-gray-600 mt-2">Use the contact form and choose Partnerships as the department to ensure direct routing.</p>
				</details>
				<details class="bg-gray-50 border border-gray-200 rounded-lg p-5">
					<summary class="font-semibold text-gray-800 cursor-pointer">Can I apply for a role through this page?</summary>
					<p class="text-sm text-gray-600 mt-2">Yes. Select Careers in the department field and include your portfolio or resume link.</p>
				</details>
				<details class="bg-gray-50 border border-gray-200 rounded-lg p-5">
					<summary class="font-semibold text-gray-800 cursor-pointer">Do you offer media interviews?</summary>
					<p class="text-sm text-gray-600 mt-2">Yes. Select Press and share your topic, publication, and preferred schedule.</p>
				</details>
			</div>
		</div>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const messageField = document.getElementById('message');
			const messageCount = document.getElementById('message-count');

			if (messageField && messageCount) {
				messageField.addEventListener('input', function () {
					messageCount.textContent = this.value.length.toString();
				});
			}
		});
	</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\Company\contact.blade.php ENDPATH**/ ?>