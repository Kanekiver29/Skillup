@extends('layout.app')

@section('title', 'Developer - SkillUp')

@section('content')
    <section class="pt-32 pb-20 bg-slate-950 text-slate-100">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto">
                <p class="text-sm uppercase tracking-[0.3em] text-cyan-300 mb-4">Developer</p>
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Developer Resources</h1>
                <p class="text-lg text-slate-300 leading-relaxed">Discover the technical building blocks, integration guides, and platform insights for SkillUp development partners and contributors.</p>
            </div>

            <div class="mt-16 grid gap-6 lg:grid-cols-3">
                <article class="rounded-3xl border border-slate-800 bg-slate-900/90 p-8 shadow-xl shadow-slate-950/20">
                    <h2 class="text-2xl font-semibold mb-4">API & Integrations</h2>
                    <p class="text-slate-400 leading-relaxed">Learn how SkillUp connects data, course content, and user workflows across the platform.</p>
                </article>
                <article class="rounded-3xl border border-slate-800 bg-slate-900/90 p-8 shadow-xl shadow-slate-950/20">
                    <h2 class="text-2xl font-semibold mb-4">Design System</h2>
                    <p class="text-slate-400 leading-relaxed">Access reusable UI patterns, utility styles, and interaction guidelines used across the SkillUp experience.</p>
                </article>
                <article class="rounded-3xl border border-slate-800 bg-slate-900/90 p-8 shadow-xl shadow-slate-950/20">
                    <h2 class="text-2xl font-semibold mb-4">Deployment</h2>
                    <p class="text-slate-400 leading-relaxed">Review the recommended environment setup, versioning strategy, and deployment notes for the SkillUp platform.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="py-20 bg-slate-100 text-slate-900">
        <div class="max-w-5xl mx-auto px-4">
            <div class="grid gap-12 lg:grid-cols-2 items-start">
                <div>
                    <h2 class="text-3xl font-bold mb-4">Get started with SkillUp development</h2>
                    <p class="text-slate-600 leading-relaxed">Whether you are building a new integration, extending a course experience, or improving platform performance, this page is your starting point.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h3 class="text-xl font-semibold mb-4">Next steps</h3>
                    <ul class="space-y-3 text-slate-600">
                        <li>Review the platform architecture and deployment requirements.</li>
                        <li>Contact our engineering team for integration support.</li>
                        <li>Follow secure development and data handling practices.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
