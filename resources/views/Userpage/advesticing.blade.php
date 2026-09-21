@extends('layout.app')

@section('title', 'Advertising - SkillUp')

@section('content')
    <section class="pt-32 pb-20 bg-slate-950 text-slate-100">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm uppercase tracking-[0.28em] text-cyan-300 mb-4">Advertising</p>
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Advertising & Partnership Opportunities</h1>
            <p class="text-lg text-slate-300 max-w-3xl mx-auto leading-relaxed">Learn how organizations can partner with SkillUp to reach learners, support career development initiatives, and amplify educational outcomes.</p>
        </div>
    </section>

    <section class="py-20 bg-slate-100 text-slate-900">
        <div class="max-w-6xl mx-auto px-4 grid gap-10 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4">Brand reach</h2>
                <p class="text-slate-600 leading-relaxed">Connect with a growing community of learners and future professionals across the Philippines.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4">Sponsored content</h2>
                <p class="text-slate-600 leading-relaxed">Explore campaign opportunities that help learners discover relevant courses and career pathways.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4">Partner programs</h2>
                <p class="text-slate-600 leading-relaxed">Learn about collaboration models for employers, training providers, and community partners.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4">Get in touch</h2>
                <p class="text-slate-600 leading-relaxed">Contact our team to discuss advertising, sponsorships, or joint learner initiatives.</p>
            </div>
        </div>
    </section>
@endsection
