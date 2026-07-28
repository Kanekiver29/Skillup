@extends('layout.app')

@section('title', 'Mentors - SkillUp')

@section('content')

<style>
	@keyframes fadeInUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
	@keyframes floatOrb{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(24px,-30px) scale(1.08)}}
	@keyframes gradientShift{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
	@keyframes shimmerSweep{0%{transform:translateX(-130%) skewX(-18deg)}100%{transform:translateX(230%) skewX(-18deg)}}
	@keyframes pulseDot{0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,.45)}50%{box-shadow:0 0 0 6px rgba(34,197,94,0)}}
	@keyframes pulseDotAmber{0%,100%{box-shadow:0 0 0 0 rgba(217,119,6,.4)}50%{box-shadow:0 0 0 6px rgba(217,119,6,0)}}
	@keyframes countUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
	@keyframes spinSlow{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
	@keyframes quoteFloat{0%,100%{transform:translateY(0) rotate(-4deg)}50%{transform:translateY(-4px) rotate(-4deg)}}

	.mh-hero{position:relative;overflow:hidden;background:linear-gradient(120deg,#4c1d95,#6d28d9,#4338ca,#7c3aed);background-size:300% 300%;animation:gradientShift 16s ease infinite}
	.mh-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.06) 1px,transparent 1px);background-size:38px 38px;mask-image:radial-gradient(ellipse at top,black 40%,transparent 80%)}
	.mh-orb{position:absolute;border-radius:9999px;filter:blur(50px);pointer-events:none;animation:floatOrb 11s ease-in-out infinite}

	.fade-up{opacity:0;animation:fadeInUp .65s ease forwards}

	.stat-glass{background:rgba(255,255,255,.12);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.22);transition:transform .3s ease,background .3s ease,box-shadow .3s ease}
	.stat-glass:hover{transform:translateY(-4px);background:rgba(255,255,255,.18);box-shadow:0 16px 30px -14px rgba(0,0,0,.35)}
	.stat-num{animation:countUp .7s ease both}

	.filter-btn{transition:transform .2s ease,box-shadow .2s ease}
	.filter-btn:hover{transform:translateY(-2px)}
	.filter-btn.active{box-shadow:0 10px 24px -10px rgba(124,58,237,.55)}

	.mentor-card{position:relative;transition:transform .35s cubic-bezier(.2,.8,.2,1),box-shadow .35s ease,border-color .35s ease}
	.mentor-card:hover{transform:translateY(-8px);box-shadow:0 26px 46px -18px rgba(88,28,135,.28);border-color:rgba(167,139,250,.55)}
	.mentor-shine{position:absolute;top:0;left:0;width:45%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.5),transparent);opacity:0;pointer-events:none;z-index:2}
	.mentor-card:hover .mentor-shine{opacity:1;animation:shimmerSweep 1s ease}
	.mentor-avatar{transition:transform .35s ease}
	.mentor-card:hover .mentor-avatar{transform:scale(1.06) rotate(-2deg)}
	.status-dot{width:7px;height:7px;border-radius:9999px;display:inline-block;margin-right:5px}
	.status-dot.avail{background:#22c55e;animation:pulseDot 2.2s ease-in-out infinite}
	.status-dot.limited{background:#d97706;animation:pulseDotAmber 2.2s ease-in-out infinite}

	.book-btn{position:relative;overflow:hidden;transition:transform .2s ease,box-shadow .2s ease}
	.book-btn:hover{transform:translateY(-2px);box-shadow:0 12px 22px -10px rgba(124,58,237,.5)}
	.book-btn::after{content:'';position:absolute;top:0;left:-75%;width:50%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.45),transparent);transform:skewX(-20deg);transition:left .6s ease}
	.book-btn:hover::after{left:125%}

	.step-card,.testi-card{transition:transform .3s cubic-bezier(.2,.8,.2,1),box-shadow .3s ease,border-color .3s ease}
	.step-card:hover,.testi-card:hover{transform:translateY(-6px);box-shadow:0 20px 36px -18px rgba(88,28,135,.22);border-color:rgba(167,139,250,.5)}
	.step-icon{transition:transform .35s ease}
	.step-card:hover .step-icon{transform:rotate(8deg) scale(1.08)}

	.quote-mark{position:absolute;top:14px;right:18px;font-size:44px;color:rgba(124,58,237,.12);font-family:Georgia,serif;line-height:1;animation:quoteFloat 4s ease-in-out infinite}

	.cta-hero{position:relative;overflow:hidden;background:linear-gradient(120deg,#4c1d95,#6d28d9,#4338ca,#7c3aed);background-size:300% 300%;animation:gradientShift 16s ease infinite}

	.cta-btn{position:relative;overflow:hidden;transition:transform .2s ease,box-shadow .2s ease}
	.cta-btn:hover{transform:translateY(-2px);box-shadow:0 14px 26px -12px rgba(0,0,0,.35)}
	.cta-btn::after{content:'';position:absolute;top:0;left:-75%;width:50%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.4),transparent);transform:skewX(-20deg);transition:left .6s ease}
	.cta-btn:hover::after{left:125%}

	.search-glow{transition:box-shadow .25s ease,border-color .25s ease}
	.search-glow:focus{box-shadow:0 0 0 4px rgba(124,58,237,.15)}

	.empty-orb{animation:spinSlow 18s linear infinite}

	@media (prefers-reduced-motion: reduce){
		.mh-hero,.mh-orb,.fade-up,.stat-num,.mentor-shine,.status-dot,.book-btn,.cta-hero,.cta-btn,.step-icon,.quote-mark,.empty-orb{animation:none!important;transition:none!important}
	}
</style>

	{{-- ===================== HERO ===================== --}}
	<section class="pt-32 pb-20 px-4 mh-hero text-white relative overflow-hidden">
		<div class="mh-hero-grid"></div>
		<div class="mh-orb w-72 h-72 bg-white/15 -top-20 -left-20"></div>
		<div class="mh-orb w-72 h-72 bg-pink-300/25 -bottom-24 -right-12" style="animation-delay:3s"></div>

		<div class="max-w-6xl mx-auto text-center relative z-10">
			<nav class="text-purple-200 text-sm mb-6 fade-up">
				<a href="/" class="hover:text-white transition">Home</a>
				<span class="mx-2">/</span>
				<span class="text-white">Mentors</span>
			</nav>

			<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 fade-up" style="animation-delay:.05s">
				Learn From Mentors<br class="hidden md:block"> Who Build Real Products
			</h1>
			<p class="text-lg md:text-xl text-purple-100 mb-10 max-w-3xl mx-auto fade-up" style="animation-delay:.1s">
				Book 1-on-1 sessions, get portfolio feedback, and receive practical career guidance from professionals in engineering,
				design, product, data, and growth.
			</p>

			<div class="flex flex-col sm:flex-row gap-4 justify-center fade-up" style="animation-delay:.16s">
				<a href="#mentor-grid" class="cta-btn bg-white text-purple-700 px-8 py-3 rounded-xl font-semibold shadow-lg hover:bg-purple-50 transition">
					Find Your Mentor <i class="fas fa-arrow-right ml-2"></i>
				</a>
				@guest
					<a href="{{ route('register') }}" class="cta-btn border-2 border-white px-8 py-3 rounded-xl font-semibold hover:bg-white hover:text-purple-700 transition">
						Join SkillUp
					</a>
				@endguest
				@auth
					<a href="{{ route('courses.index') }}" class="cta-btn border-2 border-white px-8 py-3 rounded-xl font-semibold hover:bg-white hover:text-purple-700 transition">
						Continue Learning
					</a>
				@endauth
			</div>

			<div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-5 max-w-4xl mx-auto fade-up" style="animation-delay:.22s">
				<div class="stat-glass rounded-2xl p-5">
					<p class="text-3xl font-bold stat-num">500+</p>
					<p class="text-purple-100 text-sm mt-1">Active Mentors</p>
				</div>
				<div class="stat-glass rounded-2xl p-5">
					<p class="text-3xl font-bold stat-num" style="animation-delay:.05s">4.9★</p>
					<p class="text-purple-100 text-sm mt-1">Average Session Rating</p>
				</div>
				<div class="stat-glass rounded-2xl p-5">
					<p class="text-3xl font-bold stat-num" style="animation-delay:.1s">24h</p>
					<p class="text-purple-100 text-sm mt-1">Typical Response Time</p>
				</div>
				<div class="stat-glass rounded-2xl p-5">
					<p class="text-3xl font-bold stat-num" style="animation-delay:.15s">10K+</p>
					<p class="text-purple-100 text-sm mt-1">Mentorship Sessions</p>
				</div>
			</div>
		</div>
	</section>

	{{-- ===================== FILTERS ===================== --}}
	<section id="mentor-grid" class="py-10 px-4 bg-white border-b border-gray-200">
		<div class="max-w-6xl mx-auto">
			<div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">
				<div class="relative w-full lg:w-80">
					<i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
					<input
						id="mentor-search"
						type="text"
						placeholder="Search by name, role, or skill..."
						class="search-glow w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
					>
				</div>

				<div class="flex flex-wrap gap-2 justify-start lg:justify-end">
					<button class="mentor-filter-btn filter-btn active px-4 py-2 rounded-full text-sm font-medium bg-purple-600 text-white transition" data-filter="all">All</button>
					<button class="mentor-filter-btn filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="engineering">
						<i class="fas fa-code mr-1"></i> Engineering
					</button>
					<button class="mentor-filter-btn filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="design">
						<i class="fas fa-pen-ruler mr-1"></i> Design
					</button>
					<button class="mentor-filter-btn filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="product">
						<i class="fas fa-lightbulb mr-1"></i> Product
					</button>
					<button class="mentor-filter-btn filter-btn px-4 py-2 rounded-full text-sm font-medium bg-white border border-gray-300 text-gray-600 hover:border-purple-400 hover:text-purple-600 transition" data-filter="data">
						<i class="fas fa-chart-line mr-1"></i> Data & AI
					</button>
				</div>
			</div>
		</div>
	</section>

	{{-- ===================== MENTOR CARDS ===================== --}}
	<section class="py-16 px-4 bg-gray-50">
		<div class="max-w-6xl mx-auto">
			<div class="flex items-center justify-between mb-8 fade-up">
				<div>
					<h2 class="text-2xl md:text-3xl font-bold text-gray-900">Featured Mentors</h2>
					<p class="text-gray-500 text-sm mt-1">Curated mentors with proven industry impact</p>
				</div>
				<span id="mentor-count" class="text-sm font-semibold text-purple-700 bg-purple-100 px-3 py-1 rounded-full">8 mentors</span>
			</div>

			<div id="mentor-cards" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.05s" data-category="engineering" data-name="Ari Santos Senior Frontend Engineer React TypeScript">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-indigo-500 to-violet-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold">AS</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Ari Santos</h3>
						<p class="text-sm text-gray-500 mb-3">Senior Frontend Engineer at PixelForge</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full">React</span>
							<span class="text-xs bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full">TypeScript</span>
							<span class="text-xs bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full">Frontend Architecture</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 4.9</span>
							<span><i class="fas fa-clock mr-1"></i> 45 mins</span>
							<span class="text-green-600 font-medium"><span class="status-dot avail"></span>Available</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>

				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.1s" data-category="data" data-name="Mia Kim Machine Learning Engineer Python NLP">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-sky-500 to-cyan-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-sky-100 flex items-center justify-center text-sky-700 text-2xl font-bold">MK</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Mia Kim</h3>
						<p class="text-sm text-gray-500 mb-3">Machine Learning Engineer at NovaAI</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-sky-50 text-sky-700 px-2.5 py-1 rounded-full">Python</span>
							<span class="text-xs bg-sky-50 text-sky-700 px-2.5 py-1 rounded-full">NLP</span>
							<span class="text-xs bg-sky-50 text-sky-700 px-2.5 py-1 rounded-full">Model Deployment</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 5.0</span>
							<span><i class="fas fa-clock mr-1"></i> 60 mins</span>
							<span class="text-green-600 font-medium"><span class="status-dot avail"></span>Available</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>

				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.15s" data-category="product" data-name="Jules Rivera Product Manager Strategy Roadmapping">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-fuchsia-500 to-rose-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-fuchsia-100 flex items-center justify-center text-fuchsia-700 text-2xl font-bold">JR</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Jules Rivera</h3>
						<p class="text-sm text-gray-500 mb-3">Product Manager at Orbit Labs</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-fuchsia-50 text-fuchsia-700 px-2.5 py-1 rounded-full">Roadmaps</span>
							<span class="text-xs bg-fuchsia-50 text-fuchsia-700 px-2.5 py-1 rounded-full">PRDs</span>
							<span class="text-xs bg-fuchsia-50 text-fuchsia-700 px-2.5 py-1 rounded-full">Stakeholder Management</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 4.8</span>
							<span><i class="fas fa-clock mr-1"></i> 30 mins</span>
							<span class="text-yellow-600 font-medium"><span class="status-dot limited"></span>Limited</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>

				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.2s" data-category="design" data-name="Lena Torres Senior UX Designer Figma Research">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-emerald-500 to-teal-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700 text-2xl font-bold">LT</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Lena Torres</h3>
						<p class="text-sm text-gray-500 mb-3">Senior UX Designer at Prism Digital</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Figma</span>
							<span class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">User Research</span>
							<span class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">Design Systems</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 4.9</span>
							<span><i class="fas fa-clock mr-1"></i> 45 mins</span>
							<span class="text-green-600 font-medium"><span class="status-dot avail"></span>Available</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>

				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.25s" data-category="engineering" data-name="Noah Valdez Backend Engineer Laravel APIs">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-purple-500 to-indigo-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-purple-100 flex items-center justify-center text-purple-700 text-2xl font-bold">NV</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Noah Valdez</h3>
						<p class="text-sm text-gray-500 mb-3">Backend Engineer at CoreLoop</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">Laravel</span>
							<span class="text-xs bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">REST APIs</span>
							<span class="text-xs bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full">MySQL</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 4.7</span>
							<span><i class="fas fa-clock mr-1"></i> 60 mins</span>
							<span class="text-green-600 font-medium"><span class="status-dot avail"></span>Available</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>

				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.3s" data-category="design" data-name="Sofia Malik Motion Designer Brand and Visual Storytelling">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-amber-500 to-orange-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-amber-100 flex items-center justify-center text-amber-700 text-2xl font-bold">SM</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Sofia Malik</h3>
						<p class="text-sm text-gray-500 mb-3">Motion Designer at FrameCraft</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full">After Effects</span>
							<span class="text-xs bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full">Brand Motion</span>
							<span class="text-xs bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full">Portfolio Critique</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 4.9</span>
							<span><i class="fas fa-clock mr-1"></i> 30 mins</span>
							<span class="text-yellow-600 font-medium"><span class="status-dot limited"></span>Limited</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>

				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.35s" data-category="product" data-name="Ethan Park Growth Product Lead Experimentation Analytics">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-cyan-500 to-blue-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-cyan-100 flex items-center justify-center text-cyan-700 text-2xl font-bold">EP</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Ethan Park</h3>
						<p class="text-sm text-gray-500 mb-3">Growth Product Lead at Northstar</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-cyan-50 text-cyan-700 px-2.5 py-1 rounded-full">A/B Testing</span>
							<span class="text-xs bg-cyan-50 text-cyan-700 px-2.5 py-1 rounded-full">North Star Metrics</span>
							<span class="text-xs bg-cyan-50 text-cyan-700 px-2.5 py-1 rounded-full">Retention</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 4.8</span>
							<span><i class="fas fa-clock mr-1"></i> 45 mins</span>
							<span class="text-green-600 font-medium"><span class="status-dot avail"></span>Available</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>

				<article class="mentor-card card-hover bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden fade-up" style="animation-delay:.4s" data-category="data" data-name="Priya Nair Data Analyst SQL Tableau Storytelling">
					<div class="mentor-shine"></div>
					<div class="h-24 bg-linear-to-r from-teal-500 to-lime-600"></div>
					<div class="px-6 pb-6 -mt-10">
						<div class="mentor-avatar w-20 h-20 rounded-2xl bg-white p-1 shadow-md mb-4">
							<div class="w-full h-full rounded-xl bg-teal-100 flex items-center justify-center text-teal-700 text-2xl font-bold">PN</div>
						</div>
						<h3 class="text-lg font-bold text-gray-900">Priya Nair</h3>
						<p class="text-sm text-gray-500 mb-3">Data Analyst at Helios Insights</p>
						<div class="flex flex-wrap gap-2 mb-4">
							<span class="text-xs bg-teal-50 text-teal-700 px-2.5 py-1 rounded-full">SQL</span>
							<span class="text-xs bg-teal-50 text-teal-700 px-2.5 py-1 rounded-full">Tableau</span>
							<span class="text-xs bg-teal-50 text-teal-700 px-2.5 py-1 rounded-full">Data Storytelling</span>
						</div>
						<div class="flex items-center justify-between text-sm text-gray-600 mb-5">
							<span><i class="fas fa-star text-yellow-400 mr-1"></i> 4.9</span>
							<span><i class="fas fa-clock mr-1"></i> 30 mins</span>
							<span class="text-green-600 font-medium"><span class="status-dot avail"></span>Available</span>
						</div>
						<a href="#" class="book-btn block text-center gradient-primary text-white py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition">Book Session</a>
					</div>
				</article>
			</div>

			<div id="mentor-empty" class="hidden mt-8 text-center text-gray-500 relative py-6">
				<div class="empty-orb w-16 h-16 mx-auto mb-3 rounded-full border-2 border-dashed border-purple-200 flex items-center justify-center text-purple-400">
					<i class="fas fa-user-slash"></i>
				</div>
				<p>No mentors match your search. Try another skill or category.</p>
			</div>
		</div>
	</section>

	{{-- ===================== HOW MENTORSHIP WORKS ===================== --}}
	<section class="py-20 px-4 bg-white">
		<div class="max-w-6xl mx-auto">
			<div class="text-center mb-12 fade-up">
				<span class="inline-block bg-purple-100 text-purple-700 text-sm font-semibold px-4 py-1 rounded-full mb-4">Mentorship Flow</span>
				<h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How Mentorship Works on SkillUp</h2>
				<p class="text-gray-600 max-w-2xl mx-auto">A simple system designed to help you move from confusion to clarity in every session.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="step-card bg-gray-50 border border-gray-100 rounded-2xl p-7 fade-up" style="animation-delay:.05s">
					<div class="step-icon w-14 h-14 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl mb-5">
						<i class="fas fa-user-check"></i>
					</div>
					<h3 class="text-xl font-bold text-gray-900 mb-3">1. Pick the Right Mentor</h3>
					<p class="text-gray-600">Filter mentors by domain and goals. Review strengths, ratings, and session focus before booking.</p>
				</div>

				<div class="step-card bg-gray-50 border border-gray-100 rounded-2xl p-7 fade-up" style="animation-delay:.1s">
					<div class="step-icon w-14 h-14 rounded-xl bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center text-2xl mb-5">
						<i class="fas fa-calendar-check"></i>
					</div>
					<h3 class="text-xl font-bold text-gray-900 mb-3">2. Book and Prepare</h3>
					<p class="text-gray-600">Choose a session slot, share your challenge, and upload your work so the mentor can prepare targeted feedback.</p>
				</div>

				<div class="step-card bg-gray-50 border border-gray-100 rounded-2xl p-7 fade-up" style="animation-delay:.15s">
					<div class="step-icon w-14 h-14 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-5">
						<i class="fas fa-rocket"></i>
					</div>
					<h3 class="text-xl font-bold text-gray-900 mb-3">3. Execute with Confidence</h3>
					<p class="text-gray-600">Leave each session with an actionable plan, resource list, and clear next milestone for your roadmap.</p>
				</div>
			</div>
		</div>
	</section>

	{{-- ===================== TESTIMONIALS ===================== --}}
	<section class="py-20 px-4 bg-gray-50">
		<div class="max-w-6xl mx-auto">
			<div class="text-center mb-12 fade-up">
				<h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Learner Success Stories</h2>
				<p class="text-gray-600 max-w-2xl mx-auto">Real outcomes from mentorship sessions focused on practical growth.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<figure class="testi-card relative bg-white border border-gray-100 rounded-2xl p-7 shadow-sm fade-up" style="animation-delay:.05s">
					<span class="quote-mark">&rdquo;</span>
					<div class="text-yellow-400 mb-4">
						<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
					</div>
					<blockquote class="text-gray-600 leading-relaxed mb-5">
						"My mentor helped me transform a messy portfolio into a focused case-study flow. I got two interview calls in the same week."
					</blockquote>
					<figcaption class="text-sm text-gray-500"><span class="font-semibold text-gray-800">Rina, UI/UX Learner</span> • Design Track</figcaption>
				</figure>

				<figure class="testi-card relative bg-white border border-gray-100 rounded-2xl p-7 shadow-sm fade-up" style="animation-delay:.1s">
					<span class="quote-mark">&rdquo;</span>
					<div class="text-yellow-400 mb-4">
						<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
					</div>
					<blockquote class="text-gray-600 leading-relaxed mb-5">
						"One backend review session saved me weeks. I fixed API architecture issues and my capstone passed technical assessment."
					</blockquote>
					<figcaption class="text-sm text-gray-500"><span class="font-semibold text-gray-800">Ken, Full-Stack Learner</span> • Engineering Track</figcaption>
				</figure>

				<figure class="testi-card relative bg-white border border-gray-100 rounded-2xl p-7 shadow-sm fade-up" style="animation-delay:.15s">
					<span class="quote-mark">&rdquo;</span>
					<div class="text-yellow-400 mb-4">
						<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
					</div>
					<blockquote class="text-gray-600 leading-relaxed mb-5">
						"I used mentor feedback to build better dashboards and finally explain insights clearly to non-technical stakeholders."
					</blockquote>
					<figcaption class="text-sm text-gray-500"><span class="font-semibold text-gray-800">Aya, Data Learner</span> • Data & AI Track</figcaption>
				</figure>
			</div>
		</div>
	</section>

	{{-- ===================== CTA ===================== --}}
	<section class="py-20 px-4 cta-hero text-white text-center relative overflow-hidden">
		<div class="mh-orb w-64 h-64 bg-white/10 -top-16 left-10"></div>
		<div class="mh-orb w-64 h-64 bg-indigo-300/20 -bottom-16 right-10" style="animation-delay:2.5s"></div>
		<div class="max-w-3xl mx-auto relative z-10 fade-up">
			<h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Accelerate Your Growth?</h2>
			<p class="text-purple-100 text-lg mb-8">Meet a mentor who can help you ship better projects, make smarter career decisions, and stay accountable every week.</p>
			<div class="flex flex-col sm:flex-row gap-4 justify-center">
				<a href="#mentor-grid" class="cta-btn bg-white text-purple-700 px-8 py-3 rounded-xl font-semibold shadow-lg hover:bg-purple-50 transition">
					Browse Mentors
				</a>
				@guest
					<a href="{{ route('register') }}" class="cta-btn border-2 border-white px-8 py-3 rounded-xl font-semibold hover:bg-white hover:text-purple-700 transition">
						Create Free Account
					</a>
				@endguest
				@auth
					<a href="{{ route('userpage.dashboard') }}" class="cta-btn border-2 border-white px-8 py-3 rounded-xl font-semibold hover:bg-white hover:text-purple-700 transition">
						Go to Dashboard
					</a>
				@endauth
			</div>
		</div>
	</section>

@endsection

@push('scripts')
<script>
	(function () {
		const filterButtons = document.querySelectorAll('.mentor-filter-btn');
		const mentorCards = document.querySelectorAll('.mentor-card');
		const mentorSearch = document.getElementById('mentor-search');
		const mentorCount = document.getElementById('mentor-count');
		const mentorEmpty = document.getElementById('mentor-empty');

		let activeCategory = 'all';

		const applyFilters = () => {
			const query = (mentorSearch?.value || '').toLowerCase().trim();
			let visibleCount = 0;

			mentorCards.forEach((card) => {
				const category = card.dataset.category || '';
				const searchable = (card.dataset.name || '').toLowerCase();

				const categoryMatch = activeCategory === 'all' || category === activeCategory;
				const searchMatch = searchable.includes(query);
				const show = categoryMatch && searchMatch;

				card.classList.toggle('hidden', !show);
				if (show) {
					visibleCount += 1;
				}
			});

			mentorCount.textContent = `${visibleCount} mentor${visibleCount === 1 ? '' : 's'}`;
			mentorEmpty.classList.toggle('hidden', visibleCount !== 0);
		};

		filterButtons.forEach((button) => {
			button.addEventListener('click', () => {
				filterButtons.forEach((btn) => {
					btn.classList.remove('active', 'bg-purple-600', 'text-white');
					btn.classList.add('bg-white', 'border', 'border-gray-300', 'text-gray-600');
				});

				button.classList.add('active', 'bg-purple-600', 'text-white');
				button.classList.remove('bg-white', 'border', 'border-gray-300', 'text-gray-600');

				activeCategory = button.dataset.filter || 'all';
				applyFilters();
			});
		});

		mentorSearch?.addEventListener('input', applyFilters);
		applyFilters();
	})();
</script>
@endpush