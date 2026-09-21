

<?php $__env->startSection('title', 'Blog - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
	<section class="pt-32 pb-20 px-4 gradient-primary text-white relative overflow-hidden">
		<div class="absolute -top-10 -left-10 w-52 h-52 rounded-full bg-white/10 blur-2xl"></div>
		<div class="absolute -bottom-16 -right-10 w-64 h-64 rounded-full bg-pink-200/20 blur-2xl"></div>
		<div class="max-w-6xl mx-auto relative">
			<nav class="text-sm text-purple-100 mb-6" aria-label="Breadcrumb">
				<ol class="flex flex-wrap items-center gap-2">
					<li><a href="/" class="hover:text-white transition">Home</a></li>
					<li><i class="fas fa-angle-right text-xs"></i></li>
					<li><span class="text-white font-medium">Blog</span></li>
				</ol>
			</nav>

			<div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-center">
				<div class="lg:col-span-3">
					<p class="uppercase tracking-[0.2em] text-sm text-purple-100 mb-4">SkillUp Insights</p>
					<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 animate-fade-in">
						Stories, Strategies, and Career Advice
					</h1>
					<p class="text-lg md:text-xl text-purple-100 leading-relaxed max-w-2xl">
						Explore practical learning guides, student success stories, and actionable tips to help you grow faster and stay career-ready.
					</p>
				</div>

				<div class="lg:col-span-2 bg-white/10 backdrop-blur border border-white/20 rounded-2xl p-6">
					<p class="text-sm uppercase tracking-wider text-purple-100 mb-2">This Month</p>
					<p class="text-3xl font-bold mb-1">12 New Articles</p>
					<p class="text-purple-100 text-sm mb-5">Fresh guides from mentors, instructors, and hiring experts.</p>
					<div class="grid grid-cols-3 gap-3 text-center">
						<div class="bg-white/10 rounded-lg p-3">
							<p class="text-xl font-bold">4</p>
							<p class="text-xs text-purple-100">Career</p>
						</div>
						<div class="bg-white/10 rounded-lg p-3">
							<p class="text-xl font-bold">5</p>
							<p class="text-xs text-purple-100">Learning</p>
						</div>
						<div class="bg-white/10 rounded-lg p-3">
							<p class="text-xl font-bold">3</p>
							<p class="text-xs text-purple-100">Stories</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="py-16 px-4 bg-white">
		<div class="max-w-6xl mx-auto">
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				<article class="lg:col-span-2 bg-gray-50 border border-gray-200 rounded-2xl overflow-hidden card-hover">
					<img src="<?php echo e(asset('images/blog/blog-featured.svg')); ?>" alt="How to Build a Career-Ready Portfolio" class="w-full h-64 md:h-80 object-cover">
					<div class="p-7 md:p-8">
						<div class="flex flex-wrap items-center gap-3 mb-4">
							<span class="text-xs font-semibold uppercase tracking-wider bg-purple-100 text-purple-700 px-3 py-1 rounded-full">Featured</span>
							<span class="text-sm text-gray-500"><i class="far fa-clock mr-1"></i> 8 min read</span>
							<span class="text-sm text-gray-500"><i class="far fa-calendar mr-1"></i> March 14, 2026</span>
						</div>
						<h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">How to Build a Career-Ready Portfolio While Studying</h2>
						<p class="text-gray-600 leading-relaxed mb-6">
							Learn a simple 30-day framework to turn assignments into portfolio projects, write better case studies, and present your skills with confidence.
						</p>
						<a href="#" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-700 transition">
							Read full article <i class="fas fa-arrow-right ml-2 text-sm"></i>
						</a>
					</div>
				</article>

				<aside class="space-y-6">
					<div class="bg-gray-50 border border-gray-200 rounded-2xl p-6">
						<h3 class="text-xl font-bold text-gray-800 mb-4">Popular Topics</h3>
						<ul class="space-y-3 text-sm">
							<li><a href="#" class="flex justify-between text-gray-700 hover:text-purple-600"><span>Career Planning</span><span>22</span></a></li>
							<li><a href="#" class="flex justify-between text-gray-700 hover:text-purple-600"><span>Learning Habits</span><span>17</span></a></li>
							<li><a href="#" class="flex justify-between text-gray-700 hover:text-purple-600"><span>Project Ideas</span><span>14</span></a></li>
							<li><a href="#" class="flex justify-between text-gray-700 hover:text-purple-600"><span>Interview Prep</span><span>9</span></a></li>
						</ul>
					</div>

					<div class="bg-linear-to-br from-pink-50 to-purple-50 border border-pink-100 rounded-2xl p-6">
						<h3 class="text-xl font-bold text-gray-800 mb-3">Weekly Newsletter</h3>
						<p class="text-gray-600 text-sm mb-4">Get 1 practical article every Friday. No spam, just useful insights.</p>
						<form class="space-y-3" action="#" method="GET">
							<label for="newsletter_email" class="sr-only">Email address</label>
							<input id="newsletter_email" name="email" type="email" class="w-full border border-pink-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:outline-none" placeholder="Your email address">
							<button type="submit" class="w-full gradient-secondary text-white font-semibold py-2.5 rounded-lg hover:opacity-90 transition">Subscribe</button>
						</form>
					</div>
				</aside>
			</div>
		</div>
	</section>

	<section class="pb-16 px-4 bg-white">
		<div class="max-w-6xl mx-auto">
			<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
				<h2 class="text-3xl font-bold text-gray-800">Latest Articles</h2>
				<div class="flex flex-wrap gap-2" id="blog-filters" aria-label="Blog categories">
					<button class="blog-filter-btn px-4 py-2 rounded-full bg-purple-600 text-white text-sm font-medium" data-filter="all" type="button">All</button>
					<button class="blog-filter-btn px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="career" type="button">Career</button>
					<button class="blog-filter-btn px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="learning" type="button">Learning</button>
					<button class="blog-filter-btn px-4 py-2 rounded-full bg-gray-100 text-gray-700 text-sm font-medium" data-filter="stories" type="button">Stories</button>
				</div>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="blog-grid">
				<article class="blog-card bg-gray-50 border border-gray-200 rounded-xl overflow-hidden card-hover" data-category="career">
					<img src="<?php echo e(asset('images/blog/blog-resume.svg')); ?>" alt="5 Resume Upgrades Recruiters Notice" class="w-full h-40 object-cover">
					<div class="p-5">
						<p class="text-xs text-blue-600 uppercase tracking-wider font-semibold mb-2">Career</p>
						<h3 class="text-lg font-bold text-gray-800 mb-2">5 Resume Upgrades Recruiters Notice Instantly</h3>
						<p class="text-sm text-gray-600 mb-4">Simple edits to your resume that improve clarity, relevance, and interview response rates.</p>
						<a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Read More</a>
					</div>
				</article>

				<article class="blog-card bg-gray-50 border border-gray-200 rounded-xl overflow-hidden card-hover" data-category="learning">
					<img src="<?php echo e(asset('images/blog/blog-study.svg')); ?>" alt="A 45-Minute Study Sprint" class="w-full h-40 object-cover">
					<div class="p-5">
						<p class="text-xs text-emerald-600 uppercase tracking-wider font-semibold mb-2">Learning</p>
						<h3 class="text-lg font-bold text-gray-800 mb-2">A 45-Minute Study Sprint That Actually Works</h3>
						<p class="text-sm text-gray-600 mb-4">Use focus blocks, active recall, and review checkpoints to improve retention.</p>
						<a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Read More</a>
					</div>
				</article>

				<article class="blog-card bg-gray-50 border border-gray-200 rounded-xl overflow-hidden card-hover" data-category="stories">
					<img src="<?php echo e(asset('images/blog/blog-story.svg')); ?>" alt="From Beginner to Intern: Maria's Journey" class="w-full h-40 object-cover">
					<div class="p-5">
						<p class="text-xs text-pink-600 uppercase tracking-wider font-semibold mb-2">Stories</p>
						<h3 class="text-lg font-bold text-gray-800 mb-2">From Beginner to Intern: Maria's 6-Month Journey</h3>
						<p class="text-sm text-gray-600 mb-4">How consistent practice and mentor feedback helped Maria land her first role.</p>
						<a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Read More</a>
					</div>
				</article>

				<article class="blog-card bg-gray-50 border border-gray-200 rounded-xl overflow-hidden card-hover" data-category="learning">
					<img src="<?php echo e(asset('images/blog/blog-questions.svg')); ?>" alt="How to Ask Better Questions" class="w-full h-40 object-cover">
					<div class="p-5">
						<p class="text-xs text-amber-600 uppercase tracking-wider font-semibold mb-2">Learning</p>
						<h3 class="text-lg font-bold text-gray-800 mb-2">How to Ask Better Questions When You Are Stuck</h3>
						<p class="text-sm text-gray-600 mb-4">A framework for getting clearer help from peers, mentors, and online communities.</p>
						<a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Read More</a>
					</div>
				</article>

				<article class="blog-card bg-gray-50 border border-gray-200 rounded-xl overflow-hidden card-hover" data-category="career">
					<img src="<?php echo e(asset('images/blog/blog-portfolio.svg')); ?>" alt="Portfolio Interview Questions" class="w-full h-40 object-cover">
					<div class="p-5">
						<p class="text-xs text-violet-600 uppercase tracking-wider font-semibold mb-2">Career</p>
						<h3 class="text-lg font-bold text-gray-800 mb-2">Portfolio Interview Questions and Smart Answer Patterns</h3>
						<p class="text-sm text-gray-600 mb-4">Prepare concise, impactful responses that show both process and outcomes.</p>
						<a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Read More</a>
					</div>
				</article>

				<article class="blog-card bg-gray-50 border border-gray-200 rounded-xl overflow-hidden card-hover" data-category="stories">
					<img src="<?php echo e(asset('images/blog/blog-teamwork.svg')); ?>" alt="Team Learning Circles" class="w-full h-40 object-cover">
					<div class="p-5">
						<p class="text-xs text-cyan-600 uppercase tracking-wider font-semibold mb-2">Stories</p>
						<h3 class="text-lg font-bold text-gray-800 mb-2">Team Learning Circles: What Happened After 8 Weeks</h3>
						<p class="text-sm text-gray-600 mb-4">A student-led experiment that improved accountability and weekly progress.</p>
						<a href="#" class="text-sm font-semibold text-purple-600 hover:text-purple-700">Read More</a>
					</div>
				</article>
			</div>
		</div>
	</section>

	<section class="py-16 px-4 gradient-secondary text-white">
		<div class="max-w-4xl mx-auto text-center">
			<h2 class="text-3xl md:text-4xl font-bold mb-4">Want More Learning Insights?</h2>
			<p class="text-pink-100 text-lg mb-8">
				Browse our course catalog and turn these blog strategies into hands-on progress today.
			</p>
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				<a href="/courses" class="bg-white text-pink-600 px-8 py-3 rounded-lg font-semibold hover:bg-pink-50 transition">Explore Courses</a>
				<a href="/contact" class="border border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-pink-600 transition">Talk to Our Team</a>
			</div>
		</div>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const filterButtons = document.querySelectorAll('.blog-filter-btn');
			const cards = document.querySelectorAll('.blog-card');

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
						const match = selected === 'all' || card.dataset.category === selected;
						card.style.display = match ? 'block' : 'none';
					});
				});
			});
		});
	</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\Company\blog.blade.php ENDPATH**/ ?>