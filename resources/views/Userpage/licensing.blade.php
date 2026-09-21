@extends('layout.app')

@section('title', 'Licensing - SkillUp')

@section('content')
    <section class="pt-32 pb-20 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900 text-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm uppercase tracking-[0.28em] text-cyan-300 mb-4">Licensing</p>
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Licensing & Content Use</h1>
            <p class="text-lg text-slate-300 max-w-3xl mx-auto leading-relaxed">Understand SkillUp licensing terms for course content, partnerships, and safe platform use.</p>
        </div>
    </section>

    <section class="py-20 bg-slate-100 text-slate-900">
        <div class="max-w-6xl mx-auto px-4 grid gap-10 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4">Content licensing</h2>
                <p class="text-slate-600 leading-relaxed">Review how SkillUp manages content rights, contributor agreements, and permitted reuse.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4">Partner agreements</h2>
                <p class="text-slate-600 leading-relaxed">Explore licensing options available to employers, trainers, and community collaborators.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4">Usage rights</h2>
                <p class="text-slate-600 leading-relaxed">Learn what is allowed and how to properly cite or share SkillUp materials.</p>
            </div>
        </div>
    </section>
@endsection
