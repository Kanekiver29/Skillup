@extends('layout.app')

@section('title', 'Pricing - SkillUp')

@push('head')
<style>
	/* Billing toggle */
	.toggle-pill {
		position: relative;
		display: inline-flex;
		background: #e9d5ff;
		border-radius: 9999px;
		padding: 4px;
	}
	.toggle-pill button {
		position: relative;
		z-index: 1;
		padding: 6px 20px;
		border-radius: 9999px;
		font-size: 0.875rem;
		font-weight: 600;
		transition: color 0.3s;
		border: none;
		background: transparent;
		cursor: pointer;
		color: #7c3aed;
	}
	.toggle-pill button.active {
		background: #7c3aed;
		color: #fff;
		box-shadow: 0 2px 8px rgba(124,58,237,0.3);
	}
	/* Pricing card highlight */
	.plan-popular {
		transform: scale(1.04);
		box-shadow: 0 25px 50px rgba(102,126,234,0.25);
	}
	@media (max-width: 768px) {
		.plan-popular { transform: scale(1); }
	}
	/* FAQ accordion */
	.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease; }
	.faq-item.open .faq-answer { max-height: 300px; }
	.faq-item.open .faq-icon { transform: rotate(45deg); }
	.faq-icon { transition: transform 0.3s; display: inline-block; }
	/* Feature table check / dash */
	.check { color: #7c3aed; }
	.dash  { color: #d1d5db; }
</style>
@endpush

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="pt-32 pb-20 px-4 gradient-primary text-white">
	<div class="max-w-4xl mx-auto text-center">
		<!-- Breadcrumb -->
		<nav class="text-purple-200 text-sm mb-6">
			<a href="/" class="hover:text-white transition">Home</a>
			<span class="mx-2">/</span>
			<span class="text-white">Pricing</span>
		</nav>

		<h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in">
			Simple, Transparent Pricing
		</h1>
		<p class="text-lg md:text-xl text-purple-100 mb-10 max-w-2xl mx-auto animate-fade-in">
			Choose the plan that fits your learning journey. Upgrade or cancel at any time — no hidden fees, ever.
		</p>

		<!-- Billing toggle -->
		<div class="flex items-center justify-center gap-4 mb-4">
			<div class="toggle-pill" id="billing-toggle">
				<button id="btn-monthly" class="active" onclick="setBilling('monthly')">Monthly</button>
				<button id="btn-annual"  onclick="setBilling('annual')">Annual</button>
			</div>
			<span class="bg-green-400 text-green-900 text-xs font-bold px-2 py-1 rounded-full">Save 25%</span>
		</div>
	</div>
</section>

{{-- ===================== PRICING CARDS ===================== --}}
<section class="py-16 px-4 bg-gray-50">
	<div class="max-w-6xl mx-auto">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">

			{{-- FREE --}}
			<div class="bg-white rounded-2xl shadow-md p-8 card-hover flex flex-col">
				<div class="mb-6">
					<div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
						<i class="fas fa-seedling text-purple-600 text-xl"></i>
					</div>
					<h3 class="text-xl font-bold text-gray-800 mb-1">Free</h3>
					<p class="text-gray-500 text-sm">Perfect for exploring SkillUp.</p>
				</div>

				<div class="mb-8">
					<span class="text-5xl font-extrabold text-gray-900">$0</span>
					<span class="text-gray-500 ml-1">/ forever</span>
				</div>

				<ul class="space-y-3 text-sm text-gray-600 mb-8 flex-1">
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Access to 5 free courses</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Basic progress tracking</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Community forum access</li>
					<li class="flex items-center gap-2 text-gray-400"><i class="fas fa-times-circle"></i> Certificates of completion</li>
					<li class="flex items-center gap-2 text-gray-400"><i class="fas fa-times-circle"></i> Priority support</li>
					<li class="flex items-center gap-2 text-gray-400"><i class="fas fa-times-circle"></i> Mentor sessions</li>
				</ul>

				@guest
					<a href="{{ route('register') }}"
					   class="block text-center border-2 border-purple-600 text-purple-600 font-semibold rounded-lg py-3 hover:bg-purple-50 transition">
						Get Started Free
					</a>
				@endguest
				@auth
					<a href="{{ route('courses.index') }}"
					   class="block text-center border-2 border-purple-600 text-purple-600 font-semibold rounded-lg py-3 hover:bg-purple-50 transition">
						Browse Courses
					</a>
				@endauth
			</div>

			{{-- PRO (popular) --}}
			<div class="plan-popular bg-white rounded-2xl p-8 flex flex-col relative">
				<!-- Popular badge -->
				<div class="absolute -top-4 left-1/2 -translate-x-1/2">
					<span class="gradient-primary text-white text-xs font-bold px-4 py-1 rounded-full shadow-md">Most Popular</span>
				</div>

				<div class="mb-6">
					<div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-4">
						<i class="fas fa-bolt text-white text-xl"></i>
					</div>
					<h3 class="text-xl font-bold text-gray-800 mb-1">Pro</h3>
					<p class="text-gray-500 text-sm">For committed learners ready to level up.</p>
				</div>

				<div class="mb-8">
					<span class="text-5xl font-extrabold text-gray-900 price-pro">$15</span>
					<span class="text-gray-500 ml-1 billing-period">/ month</span>
					<p class="text-green-600 text-sm mt-1 annual-note hidden">Billed $135/year — save $45!</p>
				</div>

				<ul class="space-y-3 text-sm text-gray-600 mb-8 flex-1">
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Unlimited course access</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Advanced progress tracking</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Community forum access</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Certificates of completion</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-purple-500"></i> Priority support</li>
					<li class="flex items-center gap-2 text-gray-400"><i class="fas fa-times-circle"></i> Mentor sessions</li>
				</ul>

				<a href="{{ route('register') }}"
				   class="block text-center gradient-primary text-white font-semibold rounded-lg py-3 hover:opacity-90 transition shadow-md">
					Start Pro Plan <i class="fas fa-arrow-right ml-1"></i>
				</a>
			</div>

			{{-- TEAM --}}
			<div class="bg-white rounded-2xl shadow-md p-8 card-hover flex flex-col">
				<div class="mb-6">
					<div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
						<i class="fas fa-users text-indigo-600 text-xl"></i>
					</div>
					<h3 class="text-xl font-bold text-gray-800 mb-1">Team</h3>
					<p class="text-gray-500 text-sm">For organizations scaling their teams.</p>
				</div>

				<div class="mb-8">
					<span class="text-5xl font-extrabold text-gray-900 price-team">$39</span>
					<span class="text-gray-500 ml-1 billing-period">/ month</span>
					<p class="text-gray-400 text-xs mt-1">Per user · minimum 5 seats</p>
					<p class="text-green-600 text-sm mt-1 annual-note hidden">Billed annually — save 25%!</p>
				</div>

				<ul class="space-y-3 text-sm text-gray-600 mb-8 flex-1">
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> Everything in Pro</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> Team dashboard & analytics</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> Dedicated account manager</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> Custom learning paths</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> Priority support</li>
					<li class="flex items-center gap-2"><i class="fas fa-check-circle text-indigo-500"></i> Monthly mentor sessions</li>
				</ul>

				<a href="{{ route('contact') }}"
				   class="block text-center border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg py-3 hover:bg-indigo-50 transition">
					Contact Sales
				</a>
			</div>

		</div><!-- /grid -->
	</div>
</section>

{{-- ===================== FEATURE COMPARISON TABLE ===================== --}}
<section class="py-16 px-4 bg-white">
	<div class="max-w-5xl mx-auto">
		<div class="text-center mb-12">
			<h2 class="text-3xl font-bold text-gray-900 mb-3">Compare Plans</h2>
			<p class="text-gray-500">See exactly what's included in each plan.</p>
		</div>

		<div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
			<table class="w-full text-sm">
				<thead>
					<tr class="gradient-primary text-white">
						<th class="text-left py-4 px-6 font-semibold w-1/2">Feature</th>
						<th class="py-4 px-4 font-semibold text-center">Free</th>
						<th class="py-4 px-4 font-semibold text-center">Pro</th>
						<th class="py-4 px-4 font-semibold text-center">Team</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-100">
					@php
						$features = [
							['Course access',              '5 courses',  'Unlimited', 'Unlimited'],
							['Progress tracking',          'Basic',      'Advanced',  'Advanced + Team'],
							['Certificates of completion', false,        true,        true],
							['Community forum',            true,         true,        true],
							['Priority support',           false,        true,        true],
							['Mentor sessions',            false,        false,       'Monthly'],
							['Team analytics dashboard',   false,        false,       true],
							['Custom learning paths',      false,        false,       true],
							['Dedicated account manager',  false,        false,       true],
							['API access',                 false,        false,       true],
						];
					@endphp

					@foreach ($features as $i => $row)
					<tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
						<td class="py-3 px-6 font-medium text-gray-700">{{ $row[0] }}</td>
						@foreach (array_slice($row, 1) as $val)
						<td class="py-3 px-4 text-center">
							@if ($val === true)
								<i class="fas fa-check-circle check text-lg"></i>
							@elseif ($val === false)
								<i class="fas fa-minus dash text-lg"></i>
							@else
								<span class="text-gray-700">{{ $val }}</span>
							@endif
						</td>
						@endforeach
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>

{{-- ===================== SOCIAL PROOF ===================== --}}
<section class="py-16 px-4 bg-gray-50">
	<div class="max-w-6xl mx-auto">
		<div class="text-center mb-12">
			<h2 class="text-3xl font-bold text-gray-900 mb-3">Loved by learners worldwide</h2>
			<p class="text-gray-500">Join thousands of students already levelling up with SkillUp.</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
			@php
				$testimonials = [
					['name' => 'Sarah K.', 'plan' => 'Pro', 'avatar' => 'S', 'quote' => 'Upgrading to Pro was the best investment in my career. The certificates helped me land a new role in just 3 months!'],
					['name' => 'Marcus T.', 'plan' => 'Team', 'avatar' => 'M', 'quote' => 'The Team plan gave our whole engineering department a structured learning path. The analytics dashboard is a game-changer.'],
					['name' => 'Priya R.', 'plan' => 'Free → Pro', 'avatar' => 'P', 'quote' => 'Started on the free plan to test it out, upgraded the same week. The course quality is outstanding — worth every penny.'],
				];
			@endphp

			@foreach ($testimonials as $t)
			<div class="bg-white rounded-2xl shadow-sm p-6 card-hover">
				<div class="flex items-center gap-3 mb-4">
					<div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center text-white font-bold">
						{{ $t['avatar'] }}
					</div>
					<div>
						<p class="font-semibold text-gray-800 text-sm">{{ $t['name'] }}</p>
						<span class="text-xs text-purple-600 font-medium">{{ $t['plan'] }} Plan</span>
					</div>
				</div>
				<div class="text-yellow-400 text-sm mb-3">
					<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
				</div>
				<p class="text-gray-600 text-sm leading-relaxed">"{{ $t['quote'] }}"</p>
			</div>
			@endforeach
		</div>
	</div>
</section>

{{-- ===================== FAQ ===================== --}}
<section class="py-16 px-4 bg-white">
	<div class="max-w-3xl mx-auto">
		<div class="text-center mb-12">
			<h2 class="text-3xl font-bold text-gray-900 mb-3">Frequently Asked Questions</h2>
			<p class="text-gray-500">Everything you need to know about our pricing.</p>
		</div>

		<div class="space-y-3" id="faq-list">
			@php
				$faqs = [
					['q' => 'Can I cancel my subscription at any time?',
					 'a' => 'Yes — you can cancel your Pro or Team subscription at any time from your account settings. You will retain access until the end of your current billing period.'],
					['q' => 'Is there a free trial for the Pro plan?',
					 'a' => 'We do not currently offer a trial, but our Free plan lets you explore SkillUp with no time limit. You can upgrade whenever you are ready.'],
					['q' => 'What payment methods are accepted?',
					 'a' => 'We accept all major credit and debit cards (Visa, Mastercard, AmEx). Team plans can also be invoiced annually.'],
					['q' => 'How does annual billing work?',
					 'a' => 'When you select Annual billing you are charged a single payment for 12 months upfront at a 25% discount compared to the monthly rate.'],
					['q' => 'Do you offer student or non-profit discounts?',
					 'a' => 'Yes! We offer a 50% discount for verified students and registered non-profit organisations. Contact our support team with proof of eligibility.'],
					['q' => 'Can I switch between plans?',
					 'a' => 'Absolutely. You can upgrade or downgrade at any time. Upgrades take effect immediately; downgrades apply at the start of the next billing cycle.'],
				];
			@endphp

			@foreach ($faqs as $faq)
			<div class="faq-item border border-gray-200 rounded-xl overflow-hidden">
				<button
					onclick="toggleFaq(this)"
					class="w-full flex justify-between items-center px-6 py-4 text-left bg-white hover:bg-gray-50 transition">
					<span class="font-semibold text-gray-800 text-sm">{{ $faq['q'] }}</span>
					<span class="faq-icon ml-4 flex-shrink-0text-purple-600 text-lg font-bold">+</span>
				</button>
				<div class="faq-answer px-6 bg-gray-50">
					<p class="text-gray-600 text-sm py-4 leading-relaxed">{{ $faq['a'] }}</p>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>

{{-- ===================== CTA ===================== --}}
<section class="py-20 px-4 gradient-primary text-white text-center">
	<div class="max-w-3xl mx-auto">
		<i class="fas fa-rocket text-white text-4xl mb-6 opacity-80"></i>
		<h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to start learning?</h2>
		<p class="text-purple-100 text-lg mb-10 max-w-xl mx-auto">
			Join over 10,000 learners already growing their skills with SkillUp. Your first 5 courses are completely free.
		</p>
		<div class="flex flex-col sm:flex-row gap-4 justify-center">
			@guest
				<a href="{{ route('register') }}"
				   class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition shadow-md">
					Create Free Account <i class="fas fa-arrow-right ml-2"></i>
				</a>
				<a href="{{ route('courses.index') }}"
				   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition">
					Browse Courses
				</a>
			@endguest
			@auth
				<a href="{{ route('courses.index') }}"
				   class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition shadow-md">
					Browse Courses <i class="fas fa-arrow-right ml-2"></i>
				</a>
			@endauth
		</div>
	</div>
</section>

@endsection

@push('scripts')
<script>
	/* ---- Billing toggle ---- */
	const prices = { monthly: { pro: '$15', team: '$39' }, annual: { pro: '$11', team: '$29' } };

	function setBilling(mode) {
		document.getElementById('btn-monthly').classList.toggle('active', mode === 'monthly');
		document.getElementById('btn-annual').classList.toggle('active', mode === 'annual');

		document.querySelectorAll('.price-pro').forEach(el => el.textContent = prices[mode].pro);
		document.querySelectorAll('.price-team').forEach(el => el.textContent = prices[mode].team);
		document.querySelectorAll('.billing-period').forEach(el => el.textContent = mode === 'annual' ? '/ month*' : '/ month');
		document.querySelectorAll('.annual-note').forEach(el => el.classList.toggle('hidden', mode === 'monthly'));
	}

	/* ---- FAQ accordion ---- */
	function toggleFaq(btn) {
		const item = btn.closest('.faq-item');
		const isOpen = item.classList.contains('open');
		// Close all
		document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
		if (!isOpen) item.classList.add('open');
	}
</script>
@endpush
