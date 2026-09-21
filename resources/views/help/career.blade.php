@extends('layout.app')

@section('title', 'Career Help - SkillUp Help Center')

@section('content')
    <div class="container py-12 px-4">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-3xl font-bold mb-4">Career Help</h1>
            <p class="text-slate-600 mb-8">Need assistance with career planning, job-ready courses, or skill development? This page explains how SkillUp supports your career journey.</p>

            <section class="mb-10">
                <h2 class="text-2xl font-semibold mb-3">Finding the right career path</h2>
                <p class="text-slate-600 leading-relaxed">Use SkillUp course recommendations and career guidance resources to explore job roles, industry-aligned skills, and the next steps toward your goals.</p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-semibold mb-3">Building job-ready skills</h2>
                <p class="text-slate-600 leading-relaxed">Focus on practical course pathways that help you gain experience, certificates, and confidence for internship or entry-level roles.</p>
            </section>

            <section class="mb-10">
                <h2 class="text-2xl font-semibold mb-3">Using SkillUp support</h2>
                <p class="text-slate-600 leading-relaxed">Contact our team if you need help choosing courses, understanding assessment requirements, or preparing for the next step in your career.</p>
            </section>

            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-8 shadow-sm">
                <h3 class="text-xl font-semibold mb-3">Still have questions?</h3>
                <p class="text-slate-600 leading-relaxed">Visit the <a href="{{ route('help.index') }}" class="text-cyan-600 hover:underline">Help Center</a> or <a href="{{ route('contact') }}" class="text-cyan-600 hover:underline">contact support</a> for personalized assistance.</p>
            </div>
        </div>
    </div>
@endsection
