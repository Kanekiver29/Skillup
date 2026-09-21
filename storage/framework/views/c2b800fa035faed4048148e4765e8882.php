

<?php $__env->startSection('title', 'Careers - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
	<section class="pt-32 pb-20 px-4 gradient-primary text-white relative overflow-hidden">
		<div class="absolute -top-16 -left-10 w-56 h-56 rounded-full bg-white/10 blur-3xl"></div>
		<div class="absolute -bottom-12 -right-8 w-60 h-60 rounded-full bg-pink-200/20 blur-3xl"></div>

		<div class="max-w-6xl mx-auto relative">
			<nav class="text-sm text-purple-100 mb-6" aria-label="Breadcrumb">
				<ol class="flex flex-wrap items-center gap-2">
					<li><a href="/" class="hover:text-white transition">Home</a></li>
					<li><i class="fas fa-angle-right text-xs"></i></li>
					<li><a href="<?php echo e(route('company.aboutus')); ?>" class="hover:text-white transition">Company</a></li>
					<li><i class="fas fa-angle-right text-xs"></i></li>
					<li><span class="text-white font-medium">Careers</span></li>
				</ol>
			</nav>

			<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-center">
				<div class="lg:col-span-3">
					<p class="uppercase tracking-[0.2em] text-sm text-purple-100 mb-4">Join Our Team</p>
					<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 animate-fade-in">
						Build The Future Of Career Learning
					</h1>
					<p class="text-lg md:text-xl text-purple-100 leading-relaxed max-w-2xl">
						Help us design tools, courses, and experiences that move learners from curiosity to real career outcomes.
					</p>
				</div>

				<div class="lg:col-span-2 bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-6">
					<p class="text-sm uppercase tracking-wider text-purple-100 mb-2">Team Snapshot</p>
					<div class="grid grid-cols-2 gap-3 text-center">
						<div class="bg-white/10 rounded-lg p-4">
							<p class="text-2xl font-bold">48</p>
							<p class="text-xs text-purple-100">Team Members</p>
						</div>
						<div class="bg-white/10 rounded-lg p-4">
							<p class="text-2xl font-bold">7</p>
							<p class="text-xs text-purple-100">Open Roles</p>
						</div>
						<div class="bg-white/10 rounded-lg p-4">
							<p class="text-2xl font-bold">4.9/5</p>
							<p class="text-xs text-purple-100">Team Rating</p>
						</div>
						<div class="bg-white/10 rounded-lg p-4">
							<p class="text-2xl font-bold">Hybrid</p>
							<p class="text-xs text-purple-100">Work Model</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="py-16 px-4 bg-white">
		<div class="max-w-6xl mx-auto">
			<div class="text-center mb-12">
				<h2 class="text-3xl md:text-4xl font-bold text-gray-800">Why Work At SkillUp</h2>
				<p class="text-gray-600 mt-3 max-w-2xl mx-auto">We are mission-driven, learner-obsessed, and focused on building products that create measurable impact.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
				<article class="bg-gray-50 border border-gray-200 rounded-xl p-6 card-hover">
					<i class="fas fa-seedling text-3xl text-emerald-600 mb-4"></i>
					<h3 class="font-bold text-gray-800 text-xl mb-2">Growth Budget</h3>
					<p class="text-gray-600">Quarterly learning allowance for courses, books, conferences, and certifications.</p>
				</article>

				<article class="bg-gray-50 border border-gray-200 rounded-xl p-6 card-hover">
					<i class="fas fa-clock text-3xl text-indigo-600 mb-4"></i>
					<h3 class="font-bold text-gray-800 text-xl mb-2">Flexible Hours</h3>
					<p class="text-gray-600">Work schedules built around focus time, collaboration blocks, and deep work.</p>
				</article>

				<article class="bg-gray-50 border border-gray-200 rounded-xl p-6 card-hover">
					<i class="fas fa-heart text-3xl text-pink-600 mb-4"></i>
					<h3 class="font-bold text-gray-800 text-xl mb-2">Wellbeing First</h3>
					<p class="text-gray-600">Health support, paid wellness days, and team routines that prevent burnout.</p>
				</article>

				<article class="bg-gray-50 border border-gray-200 rounded-xl p-6 card-hover">
					<i class="fas fa-globe text-3xl text-blue-600 mb-4"></i>
					<h3 class="font-bold text-gray-800 text-xl mb-2">Impact At Scale</h3>
					<p class="text-gray-600">Ship features used by thousands of learners preparing for their careers.</p>
				</article>
			</div>
		</div>
	</section>

	<section class="py-16 px-4 bg-gray-50">
		<div class="max-w-6xl mx-auto">
			<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
				<h2 class="text-3xl font-bold text-gray-800">Open Positions</h2>
				<div class="flex flex-wrap gap-2" id="job-filters" aria-label="Job department filters">
					<button class="job-filter-btn px-4 py-2 rounded-full bg-purple-600 text-white text-sm font-medium" data-filter="all" type="button">All</button>
					<button class="job-filter-btn px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="product" type="button">Product</button>
					<button class="job-filter-btn px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="engineering" type="button">Engineering</button>
					<button class="job-filter-btn px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="operations" type="button">Operations</button>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="jobs-grid">
				<article class="job-card bg-white border border-gray-200 rounded-2xl p-6 card-hover" data-department="product">
					<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
						<h3 class="text-2xl font-bold text-gray-800">Product Designer</h3>
						<span class="text-xs font-semibold uppercase tracking-wider bg-purple-100 text-purple-700 px-3 py-1 rounded-full">Product</span>
					</div>
					<p class="text-gray-600 mb-5">Design intuitive, accessible learning experiences from discovery to polished UI delivery.</p>
					<ul class="space-y-2 text-sm text-gray-600 mb-6">
						<li><i class="fas fa-location-dot text-purple-500 mr-2"></i>Remote or Manila Hub</li>
						<li><i class="fas fa-briefcase text-purple-500 mr-2"></i>Full-time</li>
						<li><i class="fas fa-layer-group text-purple-500 mr-2"></i>Mid to Senior Level</li>
					</ul>
					<a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700 transition">Apply Now <i class="fas fa-arrow-right ml-2 text-sm"></i></a>
				</article>

				<article class="job-card bg-white border border-gray-200 rounded-2xl p-6 card-hover" data-department="engineering">
					<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
						<h3 class="text-2xl font-bold text-gray-800">Laravel Backend Engineer</h3>
						<span class="text-xs font-semibold uppercase tracking-wider bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">Engineering</span>
					</div>
					<p class="text-gray-600 mb-5">Build reliable APIs, data models, and scalable features for learning and assessment modules.</p>
					<ul class="space-y-2 text-sm text-gray-600 mb-6">
						<li><i class="fas fa-location-dot text-purple-500 mr-2"></i>Hybrid (3 days onsite)</li>
						<li><i class="fas fa-briefcase text-purple-500 mr-2"></i>Full-time</li>
						<li><i class="fas fa-layer-group text-purple-500 mr-2"></i>Mid Level</li>
					</ul>
					<a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700 transition">Apply Now <i class="fas fa-arrow-right ml-2 text-sm"></i></a>
				</article>

				<article class="job-card bg-white border border-gray-200 rounded-2xl p-6 card-hover" data-department="engineering">
					<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
						<h3 class="text-2xl font-bold text-gray-800">Frontend Engineer</h3>
						<span class="text-xs font-semibold uppercase tracking-wider bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full">Engineering</span>
					</div>
					<p class="text-gray-600 mb-5">Craft responsive interfaces and performance-first UX using modern CSS and JavaScript tooling.</p>
					<ul class="space-y-2 text-sm text-gray-600 mb-6">
						<li><i class="fas fa-location-dot text-purple-500 mr-2"></i>Remote-first</li>
						<li><i class="fas fa-briefcase text-purple-500 mr-2"></i>Full-time</li>
						<li><i class="fas fa-layer-group text-purple-500 mr-2"></i>Junior to Mid Level</li>
					</ul>
					<a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700 transition">Apply Now <i class="fas fa-arrow-right ml-2 text-sm"></i></a>
				</article>

				<article class="job-card bg-white border border-gray-200 rounded-2xl p-6 card-hover" data-department="operations">
					<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
						<h3 class="text-2xl font-bold text-gray-800">Learner Success Associate</h3>
						<span class="text-xs font-semibold uppercase tracking-wider bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full">Operations</span>
					</div>
					<p class="text-gray-600 mb-5">Support learners through onboarding, progress check-ins, and high-touch coaching interventions.</p>
					<ul class="space-y-2 text-sm text-gray-600 mb-6">
						<li><i class="fas fa-location-dot text-purple-500 mr-2"></i>Manila Hub</li>
						<li><i class="fas fa-briefcase text-purple-500 mr-2"></i>Full-time</li>
						<li><i class="fas fa-layer-group text-purple-500 mr-2"></i>Entry to Mid Level</li>
					</ul>
					<a href="<?php echo e(route('contact')); ?>" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700 transition">Apply Now <i class="fas fa-arrow-right ml-2 text-sm"></i></a>
				</article>
			</div>
		</div>
	</section>

	<section class="py-16 px-4 bg-white">
		<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
			<div class="bg-gray-50 border border-gray-200 rounded-2xl p-7">
				<h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-5">Hiring Process</h2>
				<div class="space-y-4 text-gray-700">
					<div class="bg-white border border-gray-200 rounded-xl p-4">
						<p class="font-semibold mb-1">1. Application Review</p>
						<p class="text-sm text-gray-600">We evaluate your skills, impact, and alignment with our mission.</p>
					</div>
					<div class="bg-white border border-gray-200 rounded-xl p-4">
						<p class="font-semibold mb-1">2. Intro Call</p>
						<p class="text-sm text-gray-600">A short conversation focused on goals, role fit, and expectations.</p>
					</div>
					<div class="bg-white border border-gray-200 rounded-xl p-4">
						<p class="font-semibold mb-1">3. Practical Assessment</p>
						<p class="text-sm text-gray-600">Role-based exercise designed to reflect real tasks and collaboration.</p>
					</div>
					<div class="bg-white border border-gray-200 rounded-xl p-4">
						<p class="font-semibold mb-1">4. Final Interview</p>
						<p class="text-sm text-gray-600">Team discussion plus a clear decision timeline and feedback.</p>
					</div>
				</div>
			</div>

			<div class="bg-linear-to-br from-indigo-50 to-pink-50 border border-indigo-100 rounded-2xl p-7">
				<h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-5">FAQ</h2>
				<div class="space-y-3" id="career-faq-list">
					<details class="bg-white border border-gray-200 rounded-lg p-4" open>
						<summary class="font-semibold text-gray-800 cursor-pointer">Do you support remote work?</summary>
						<p class="text-sm text-gray-600 mt-2">Yes. Most roles are remote-first or hybrid, depending on team collaboration needs.</p>
					</details>
					<details class="bg-white border border-gray-200 rounded-lg p-4">
						<summary class="font-semibold text-gray-800 cursor-pointer">Can students or fresh graduates apply?</summary>
						<p class="text-sm text-gray-600 mt-2">Absolutely. We have entry-level roles and internship pathways throughout the year.</p>
					</details>
					<details class="bg-white border border-gray-200 rounded-lg p-4">
						<summary class="font-semibold text-gray-800 cursor-pointer">How long does hiring usually take?</summary>
						<p class="text-sm text-gray-600 mt-2">Typically 2 to 3 weeks from application to offer, depending on role and scheduling.</p>
					</details>
				</div>
			</div>
		</div>
	</section>

	<section class="py-16 px-4 gradient-secondary text-white">
		<div class="max-w-4xl mx-auto text-center">
			<h2 class="text-3xl md:text-4xl font-bold mb-4">Ready To Build With Us?</h2>
			<p class="text-pink-100 text-lg mb-8">
				Send your resume or portfolio and tell us what problem at SkillUp you want to help solve.
			</p>
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				<a href="<?php echo e(route('contact')); ?>" class="bg-white text-pink-600 px-8 py-3 rounded-lg font-semibold hover:bg-pink-50 transition">Apply Through Contact Form</a>
				<a href="<?php echo e(route('company.blog')); ?>" class="border border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-pink-600 transition">Read Team Stories</a>
			</div>
		</div>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const filterButtons = document.querySelectorAll('.job-filter-btn');
			const cards = document.querySelectorAll('.job-card');

			filterButtons.forEach((button) => {
				button.addEventListener('click', function () {
					const selected = this.dataset.filter;

					filterButtons.forEach((btn) => {
						btn.classList.remove('bg-purple-600', 'text-white');
						btn.classList.add('bg-gray-100', 'text-gray-700');
					});

					this.classList.remove('bg-gray-100', 'text-gray-700');
					this.classList.add('bg-purple-600', 'text-white');

					cards.forEach((card) => {
						const match = selected === 'all' || card.dataset.department === selected;
						card.style.display = match ? 'block' : 'none';
					});
				});
			});
		});
	</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\Company\careers.blade.php ENDPATH**/ ?>