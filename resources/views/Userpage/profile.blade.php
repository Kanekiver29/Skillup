@extends('layout.app')

@section('title', 'My Profile - SkillUp')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --profile-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --profile-navy: #0a2540;
        --profile-navy-deep: #061829;
        --profile-blue: #003a8f;

        /* Futuristic "Learner ID" token system */
        --fx-void: #030712;
        --fx-abyss: #060b1a;
        --fx-panel: #0d1428;
        --fx-panel-light: #121b38;
        --fx-line: rgba(126, 176, 255, 0.14);
        --fx-line-soft: rgba(126, 176, 255, 0.07);
        --fx-cyan: #22d3ee;
        --fx-cyan-soft: #7dd8f0;
        --fx-violet: #8b7bff;
        --fx-violet-soft: #c4b5fd;
        --fx-indigo: #6366f1;
        --fx-amber: #fbbf24;
        --fx-rose: #fb7185;
        --fx-emerald: #34d399;
        --fx-text: #e9edfb;
        --fx-text-body: #a8b3d1;
        --fx-text-dim: #6c7797;
        --fx-font-display: 'Space Grotesk', 'Inter', system-ui, sans-serif;
        --fx-font-body: 'Inter', system-ui, sans-serif;
        --fx-font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    /* ============ BASE / AMBIENT FIELD ============ */
    .profile-page {
        position: relative;
        background: var(--fx-void);
        font-family: var(--fx-font-body);
        isolation: isolate;
    }

    .profile-page::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -2;
        background:
            radial-gradient(ellipse 55% 45% at 12% 0%, rgba(34, 211, 238, 0.10), transparent 60%),
            radial-gradient(ellipse 50% 40% at 88% 20%, rgba(139, 123, 255, 0.10), transparent 55%),
            radial-gradient(ellipse 60% 50% at 50% 100%, rgba(34, 211, 238, 0.05), transparent 60%),
            var(--fx-void);
    }

    .profile-page::after {
        content: '';
        position: fixed;
        inset: 0;
        z-index: -1;
        background-image:
            linear-gradient(var(--fx-line-soft) 1px, transparent 1px),
            linear-gradient(90deg, var(--fx-line-soft) 1px, transparent 1px);
        background-size: 56px 56px;
        mask-image: radial-gradient(ellipse 75% 65% at 50% 0%, #000 0%, transparent 75%);
        -webkit-mask-image: radial-gradient(ellipse 75% 65% at 50% 0%, #000 0%, transparent 75%);
        animation: profileDrift 40s linear infinite;
        pointer-events: none;
    }

    @keyframes profileDrift {
        0% { background-position: 0 0, 0 0; }
        100% { background-position: 56px 56px, 56px 56px; }
    }

    .profile-page h1,
    .profile-page h2,
    .profile-page h3 {
        font-family: var(--fx-font-display);
        letter-spacing: -0.01em;
    }

    .profile-mono {
        font-family: var(--fx-font-mono);
        letter-spacing: 0.06em;
    }

    .profile-text-strong { color: var(--fx-text) !important; }
    .profile-text-body { color: var(--fx-text-body) !important; }
    .profile-text-dim { color: var(--fx-text-dim) !important; }
    .profile-link { color: var(--fx-cyan-soft) !important; text-decoration: none; }
    .profile-link:hover { color: #ffffff !important; }
    .profile-border { border-color: var(--fx-line) !important; }

    /* ============ HERO ============ */
    .profile-hero {
        background:
            radial-gradient(ellipse 80% 60% at 100% 0%, rgba(56, 189, 248, 0.35), transparent 50%),
            radial-gradient(ellipse 50% 40% at 0% 100%, rgba(139, 123, 255, 0.22), transparent 45%),
            linear-gradient(145deg, var(--profile-navy-deep) 0%, var(--profile-navy) 42%, var(--profile-blue) 100%) !important;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        isolation: isolate;
        border-bottom: 1px solid rgba(125, 211, 252, 0.18);
    }

    .profile-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 35%, rgba(255, 255, 255, 0.09) 50%, transparent 65%);
        background-size: 220% 100%;
        animation: profileShine 5s linear infinite;
        pointer-events: none;
        z-index: 0;
    }

    @keyframes profileShine {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* HUD scan sweep */
    .profile-hero-scan {
        position: absolute;
        left: 0; right: 0; top: 0;
        height: 140px;
        background: linear-gradient(180deg, rgba(125, 211, 252, 0.35), transparent);
        animation: profileScan 6s var(--profile-ease) infinite;
        pointer-events: none;
        z-index: 0;
        mix-blend-mode: screen;
    }

    @keyframes profileScan {
        0% { transform: translateY(-140px); opacity: 0; }
        15% { opacity: 0.6; }
        55% { opacity: 0.15; }
        100% { transform: translateY(560px); opacity: 0; }
    }

    /* HUD corner brackets */
    .profile-hud-corner {
        position: absolute;
        width: 22px;
        height: 22px;
        border: 2px solid rgba(125, 211, 252, 0.4);
        z-index: 1;
        pointer-events: none;
    }
    .profile-hud-tl { top: 14px; left: 14px; border-right: none; border-bottom: none; }
    .profile-hud-tr { top: 14px; right: 14px; border-left: none; border-bottom: none; }
    .profile-hud-bl { bottom: 14px; left: 14px; border-right: none; border-top: none; }
    .profile-hud-br { bottom: 14px; right: 14px; border-left: none; border-top: none; }

    .profile-hero-inner { position: relative; z-index: 2; }

    .profile-hero h1 {
        color: #ffffff !important;
        text-shadow: 0 2px 24px rgba(0, 0, 0, 0.35);
    }

    .profile-hero .profile-subtitle {
        color: #cdeafd !important;
        font-family: var(--fx-font-mono);
        font-size: 0.95rem;
        letter-spacing: 0.04em;
    }

    .profile-hero .profile-back-link {
        color: #bae6fd !important;
        font-family: var(--fx-font-mono);
        font-size: 0.8rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .profile-hero .profile-back-link:hover {
        color: #ffffff !important;
    }

    .profile-hero .profile-badge-pill {
        color: #f0f9ff !important;
        background: rgba(255, 255, 255, 0.14) !important;
        border: 1px solid rgba(255, 255, 255, 0.28) !important;
    }

    .profile-hero .profile-label-tag {
        color: #7dd3fc !important;
    }

    .profile-stat-glass {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.22) !important;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        transition: transform 0.35s var(--profile-ease), background 0.35s ease, box-shadow 0.35s ease;
        position: relative;
        overflow: hidden;
    }

    .profile-stat-glass::before {
        content: '';
        position: absolute;
        top: 0; left: 12%; right: 12%;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--fx-cyan), var(--fx-violet), transparent);
        opacity: 0.85;
    }

    .profile-stat-glass:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.13) !important;
        box-shadow: 0 14px 40px rgba(34, 211, 238, 0.18);
    }

    .profile-stat-glass .profile-stat-value {
        color: #ffffff !important;
        font-family: var(--fx-font-mono);
        font-weight: 700;
        text-shadow: 0 0 18px rgba(125, 211, 252, 0.45);
    }

    .profile-stat-glass .profile-stat-label {
        color: #cdeafd !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.68rem;
        letter-spacing: 0.08em;
    }

    /* Avatar + orbit ring signature */
    .profile-avatar-wrap {
        position: relative;
        width: 9rem;
        height: 9rem;
    }

    .profile-avatar-ring {
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.28), 0 20px 50px rgba(0, 0, 0, 0.4), 0 0 40px rgba(34, 211, 238, 0.25);
        transition: transform 0.45s var(--profile-ease);
        position: relative;
        z-index: 2;
    }

    .profile-avatar-ring:hover { transform: scale(1.04); }

    .profile-orbit {
        position: absolute;
        inset: -14px;
        border-radius: 9999px;
        border: 1.5px dashed rgba(125, 211, 252, 0.55);
        animation: profileOrbitSpin 14s linear infinite;
        z-index: 1;
    }

    .profile-orbit::after {
        content: '';
        position: absolute;
        top: -4px;
        left: calc(50% - 4px);
        width: 8px;
        height: 8px;
        border-radius: 9999px;
        background: var(--fx-cyan);
        box-shadow: 0 0 10px 3px rgba(34, 211, 238, 0.8);
    }

    .profile-orbit-outer {
        position: absolute;
        inset: -26px;
        border-radius: 9999px;
        border: 1px solid rgba(139, 123, 255, 0.3);
        animation: profileOrbitSpin 22s linear infinite reverse;
        z-index: 0;
    }

    @keyframes profileOrbitSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* ============ SECTION CARDS (glass) ============ */
    .profile-section-card {
        background: linear-gradient(180deg, rgba(18, 27, 56, 0.75), rgba(10, 16, 34, 0.75));
        border: 1px solid var(--fx-line);
        border-radius: 1.25rem;
        box-shadow: 0 4px 28px rgba(0, 0, 0, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        transition: transform 0.35s var(--profile-ease), box-shadow 0.35s var(--profile-ease), border-color 0.35s ease;
        position: relative;
        overflow: hidden;
    }

    .profile-section-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(125, 211, 252, 0.5), rgba(139, 123, 255, 0.4), transparent);
        opacity: 0.6;
        transition: opacity 0.35s ease;
    }

    .profile-section-card:hover {
        box-shadow: 0 18px 50px rgba(34, 211, 238, 0.1);
        border-color: rgba(125, 211, 252, 0.28);
    }

    .profile-section-card:hover::before { opacity: 1; }

    /* soft-tinted sidebar cards (mentor / streak) keep an accent tint over glass */
    .profile-tint-indigo {
        background: linear-gradient(160deg, rgba(99, 102, 241, 0.14), rgba(10, 16, 34, 0.75));
        border: 1px solid rgba(99, 102, 241, 0.28);
    }
    .profile-tint-amber {
        background: linear-gradient(160deg, rgba(251, 191, 36, 0.14), rgba(10, 16, 34, 0.75));
        border: 1px solid rgba(251, 191, 36, 0.28);
    }

    /* Icon chips */
    .profile-icon-chip {
        width: 2.5rem; height: 2.5rem;
        border-radius: 0.85rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .chip-cyan    { background: rgba(34, 211, 238, 0.14);  color: var(--fx-cyan-soft); box-shadow: 0 0 18px rgba(34, 211, 238, 0.22); }
    .chip-indigo  { background: rgba(99, 102, 241, 0.16);  color: #a5b4fc;             box-shadow: 0 0 18px rgba(99, 102, 241, 0.24); }
    .chip-violet  { background: rgba(139, 123, 255, 0.16); color: var(--fx-violet-soft); box-shadow: 0 0 18px rgba(139, 123, 255, 0.24); }
    .chip-amber   { background: rgba(251, 191, 36, 0.16);  color: var(--fx-amber);     box-shadow: 0 0 18px rgba(251, 191, 36, 0.2); }
    .chip-emerald { background: rgba(52, 211, 153, 0.16);  color: var(--fx-emerald);   box-shadow: 0 0 18px rgba(52, 211, 153, 0.2); }
    .chip-rose    { background: rgba(251, 113, 133, 0.16); color: var(--fx-rose);      box-shadow: 0 0 18px rgba(251, 113, 133, 0.2); }

    /* Course rows / list items */
    .profile-course-row {
        background: rgba(255, 255, 255, 0.025);
        border: 1px solid var(--fx-line);
        transition: transform 0.3s var(--profile-ease), box-shadow 0.3s ease, border-color 0.3s ease, background 0.3s ease;
    }

    .profile-course-row:hover {
        transform: translateX(5px);
        box-shadow: 0 12px 28px rgba(34, 211, 238, 0.12);
        border-color: rgba(125, 211, 252, 0.4) !important;
        background: rgba(255, 255, 255, 0.045);
    }

    .profile-progress-track {
        background: rgba(255, 255, 255, 0.07);
        overflow: hidden;
    }

    .profile-progress-fill {
        transition: width 1s var(--profile-ease);
        background: linear-gradient(90deg, var(--fx-cyan), var(--fx-violet));
        box-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        position: relative;
    }

    .profile-progress-fill::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(105deg, transparent 35%, rgba(255,255,255,0.55) 50%, transparent 65%);
        background-size: 220% 100%;
        animation: profileShine 2.6s linear infinite;
    }

    .profile-percent-chip {
        background: rgba(34, 211, 238, 0.1);
        border: 1px solid rgba(34, 211, 238, 0.3);
        color: var(--fx-cyan-soft);
        font-family: var(--fx-font-mono);
    }

    /* Skill chips */
    .profile-skill-chip {
        background: linear-gradient(150deg, rgba(34, 211, 238, 0.1), rgba(139, 123, 255, 0.1));
        border: 1px solid rgba(139, 123, 255, 0.28);
        transition: transform 0.25s var(--profile-ease), box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .profile-skill-chip:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(139, 123, 255, 0.22);
        border-color: rgba(139, 123, 255, 0.55);
    }

    /* Badge tiles (sidebar showcase) */
    .profile-badge-tile { transition: transform 0.3s var(--profile-ease), filter 0.3s ease; }
    .profile-badge-tile:hover { transform: scale(1.12) rotate(-3deg); filter: drop-shadow(0 0 10px rgba(251, 191, 36, 0.55)); }

    /* Buttons */
    .profile-btn-primary {
        background: linear-gradient(135deg, var(--fx-cyan), var(--fx-violet));
        color: #04121c;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(34, 211, 238, 0.25);
        transition: transform 0.3s var(--profile-ease), box-shadow 0.3s ease;
    }
    .profile-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(34, 211, 238, 0.35); }

    .profile-btn-ghost {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--fx-line);
        color: var(--fx-text-body);
        transition: all 0.3s var(--profile-ease);
    }
    .profile-btn-ghost:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(125, 211, 252, 0.4);
        color: var(--fx-text);
    }

    .profile-btn-amber {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #241800;
        font-weight: 700;
        box-shadow: 0 8px 22px rgba(251, 191, 36, 0.25);
        transition: transform 0.3s var(--profile-ease), box-shadow 0.3s ease;
    }
    .profile-btn-amber:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(251, 191, 36, 0.35); }

    .profile-icon-link {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--fx-line);
        color: var(--fx-text-body);
        transition: all 0.3s var(--profile-ease);
    }
    .profile-icon-link:hover {
        border-color: rgba(125, 211, 252, 0.5);
        color: #ffffff;
        box-shadow: 0 0 16px rgba(34, 211, 238, 0.25);
    }

    /* Portfolio thumbnails */
    .profile-thumb {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(135deg, rgba(34, 211, 238, 0.25), rgba(139, 123, 255, 0.25)),
            linear-gradient(180deg, var(--fx-panel-light), var(--fx-panel));
    }
    .profile-thumb::before {
        content: '';
        position: absolute; inset: 0;
        background-image: linear-gradient(var(--fx-line-soft) 1px, transparent 1px), linear-gradient(90deg, var(--fx-line-soft) 1px, transparent 1px);
        background-size: 18px 18px;
        opacity: 0.6;
    }
    .profile-tag-chip {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--fx-line);
        color: var(--fx-text-body);
    }

    /* Timeline (recent activity) */
    .profile-timeline-item { position: relative; padding-left: 1.1rem; }
    .profile-timeline-item::before {
        content: '';
        position: absolute; left: 0; top: 0.35rem;
        width: 8px; height: 8px; border-radius: 9999px;
        background: var(--fx-cyan);
        box-shadow: 0 0 8px 2px rgba(34, 211, 238, 0.6);
    }
    .profile-timeline-item::after {
        content: '';
        position: absolute; left: 3px; top: 1rem; bottom: -0.75rem;
        width: 1px;
        background: var(--fx-line);
    }
    .profile-timeline-item:last-child::after { display: none; }

    /* Streak number glow */
    .profile-streak-value {
        font-family: var(--fx-font-mono);
        color: #fde68a;
        text-shadow: 0 0 24px rgba(251, 191, 36, 0.55);
    }
    .profile-streak-flame { display: inline-block; animation: profileFlicker 2.4s ease-in-out infinite; }
    @keyframes profileFlicker {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.12); opacity: 0.85; }
    }

    /* Toast */
    .profile-toast { animation: profileToastIn 0.55s var(--profile-ease) forwards; }

    @keyframes profileToastIn {
        from { opacity: 0; transform: translateY(-12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes profileHeroIn {
        from { opacity: 0; transform: translateY(28px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .profile-hero-enter {
        animation: profileHeroIn 0.85s var(--profile-ease) forwards;
    }

    .profile-hero-enter-delay-1 { animation-delay: 0.1s; opacity: 0; }
    .profile-hero-enter-delay-2 { animation-delay: 0.2s; opacity: 0; }
    .profile-hero-enter-delay-3 { animation-delay: 0.3s; opacity: 0; }
    .profile-hero-enter-delay-4 { animation-delay: 0.42s; opacity: 0; }
    .profile-hero-enter-delay-5 { animation-delay: 0.54s; opacity: 0; }

    [data-page-animate] { opacity: 1; transform: none; filter: none; }

    html.page-animate-enabled [data-page-animate]:not(.is-visible) {
        opacity: 0;
        transform: translateY(22px);
        filter: blur(3px);
    }

    html.page-animate-enabled [data-page-animate].is-visible {
        animation: profileSectionIn 0.8s var(--profile-ease) forwards;
    }

    .page-delay-1 { animation-delay: 80ms; }
    .page-delay-2 { animation-delay: 140ms; }
    .page-delay-3 { animation-delay: 200ms; }
    .page-delay-4 { animation-delay: 260ms; }
    .page-delay-5 { animation-delay: 320ms; }

    @keyframes profileSectionIn {
        from { opacity: 0; transform: translateY(22px) scale(0.99); filter: blur(4px); }
        to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    @media (prefers-reduced-motion: reduce) {
        .profile-hero::before,
        .profile-hero-scan,
        .profile-hero-enter,
        .profile-toast,
        .profile-orbit,
        .profile-orbit-outer,
        .profile-progress-fill::after,
        .profile-streak-flame,
        .profile-page::after,
        [data-page-animate] {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-page min-h-screen">
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-4 pt-4">
            <div class="profile-toast rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 flex items-center gap-3 shadow-sm backdrop-blur">
                <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
                <p class="text-sm text-emerald-200 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Hero (inline gradient fallback — Vite build may be absent) -->
    <header
        class="profile-hero pt-8 pb-24 md:pb-28 px-4"
        style="background: linear-gradient(145deg, #061829 0%, #0a2540 42%, #003a8f 100%);"
    >
        <span class="profile-hud-corner profile-hud-tl"></span>
        <span class="profile-hud-corner profile-hud-tr"></span>
        <span class="profile-hud-corner profile-hud-bl"></span>
        <span class="profile-hud-corner profile-hud-br"></span>
        <div class="profile-hero-scan"></div>

        <div class="max-w-6xl mx-auto profile-hero-inner">
            <a href="{{ route('courses.index') }}" class="profile-back-link profile-hero-enter inline-flex items-center gap-2 mb-6 transition group font-medium">
                <i class="fas fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                Back to Learning
            </a>

            <div class="profile-hero-enter profile-hero-enter-delay-1 flex flex-col md:flex-row items-start md:items-end gap-6 mb-10">
                <div class="profile-avatar-wrap shrink-0">
                    <div class="profile-orbit-outer"></div>
                    <div class="profile-orbit"></div>
                    <div class="profile-avatar-ring w-32 h-32 md:w-36 md:h-36 bg-white rounded-full border-4 border-white/40 flex items-center justify-center overflow-hidden relative">
                        @if($user->profile_image)
                            <img src="{{ asset('uploads/profiles/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-5xl font-black" style="color: #003a8f;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <a href="{{ route('userpage.profile-edit') }}" class="absolute bottom-0 right-0 flex h-11 w-11 items-center justify-center rounded-full text-white shadow-lg transition hover:scale-110 z-10" style="background: #0284c7; min-height: 0; box-shadow: 0 0 18px rgba(2,132,199,0.6);" aria-label="Edit photo">
                        <i class="fas fa-camera"></i>
                    </a>
                </div>

                <div class="flex-1 min-w-0">
                    <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider mb-2 profile-badge-pill px-3 py-1 rounded-full profile-mono">
                        <span class="w-2 h-2 rounded-full bg-emerald-400" style="box-shadow: 0 0 8px #34d399;"></span>
                        Learner ID // Active
                    </span>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-2">{{ $user->name }}</h1>
                    <p class="profile-subtitle text-xl font-medium mb-4">{{ $user->location ?? 'Career in Progress' }}</p>
                    <div class="flex flex-wrap gap-3">
                        @if($user->location)
                            <span class="profile-badge-pill inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm">
                                <i class="fas fa-map-marker-alt profile-label-tag"></i> {{ $user->location }}
                            </span>
                        @endif
                        <span class="profile-badge-pill inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm">
                            <i class="fas fa-calendar profile-label-tag"></i> Joined {{ $user->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('userpage.profile-edit') }}" class="profile-btn-primary shrink-0 inline-flex items-center gap-2 px-6 py-3 font-bold rounded-xl" style="min-height: 0;">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:gap-4">
                @php
                    $heroStats = [
                        ['value' => count($user->skills ?? []), 'label' => 'Skills'],
                        ['value' => $completedCourses, 'label' => 'Completed'],
                        ['value' => $user->enrollments()->count(), 'label' => 'Enrollments'],
                        ['value' => $inProgress ?? 0, 'label' => 'In Progress'],
                        ['value' => $avgProgress ?? 0, 'label' => 'Avg. Progress', 'suffix' => '%', 'wide' => true],
                    ];
                @endphp
                @foreach($heroStats as $i => $stat)
                    <div class="profile-hero-enter profile-hero-enter-delay-{{ min($i + 2, 5) }} profile-stat-glass p-4 md:p-5 rounded-2xl text-center {{ !empty($stat['wide']) ? 'col-span-2 md:col-span-1' : '' }}">
                        <div
                            class="profile-stat-value text-2xl md:text-3xl tabular-nums"
                            data-countup="{{ $stat['value'] }}"
                            @if(!empty($stat['suffix'])) data-countup-suffix="{{ $stat['suffix'] }}" @endif
                        >{{ $stat['value'] }}{{ $stat['suffix'] ?? '' }}</div>
                        <p class="profile-stat-label text-xs md:text-sm mt-1.5">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </header>

    <!-- Main -->
    <div class="max-w-6xl mx-auto px-4 -mt-10 relative z-10 pb-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <section data-page-animate class="profile-section-card p-6 md:p-8">
                    <h2 class="text-xl font-bold profile-text-strong mb-4 flex items-center gap-3">
                        <span class="profile-icon-chip chip-cyan"><i class="fas fa-user"></i></span>
                        About Me
                    </h2>
                    @if($user->bio)
                        <p class="profile-text-body leading-relaxed mb-4">{{ $user->bio }}</p>
                    @else
                        <p class="profile-text-dim italic">No bio yet. <a href="{{ route('userpage.profile-edit') }}" class="profile-link font-semibold hover:underline">Add one</a></p>
                    @endif
                    <div class="flex gap-2">
                        @if($user->github_url)
                            <a href="{{ $user->github_url }}" target="_blank" rel="noopener" class="profile-icon-link flex h-11 w-11 items-center justify-center rounded-xl min-h-0">
                                <i class="fab fa-github text-lg"></i>
                            </a>
                        @endif
                        @if($user->portfolio_url)
                            <a href="{{ $user->portfolio_url }}" target="_blank" rel="noopener" class="profile-icon-link flex h-11 w-11 items-center justify-center rounded-xl min-h-0">
                                <i class="fas fa-globe text-lg"></i>
                            </a>
                        @endif
                    </div>
                </section>

                <section data-page-animate class="page-delay-1 profile-section-card p-6 md:p-8">
                    <h2 class="text-xl font-bold profile-text-strong mb-4 flex items-center gap-3">
                        <span class="profile-icon-chip chip-indigo"><i class="fas fa-book-open"></i></span>
                        Your Courses
                    </h2>

                    @if($enrollments->count())
                        <div class="space-y-3" id="courses-list">
                            @foreach($enrollments as $enrollment)
                                <div id="enroll-{{ $enrollment->id }}" class="profile-course-row rounded-xl p-4 flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold profile-text-strong">{{ $enrollment->course->course_title }}</h3>
                                        <p class="text-sm profile-text-dim mt-1">{{ Str::limit($enrollment->course->description, 100) }}</p>
                                        <div class="mt-3 flex flex-wrap gap-4 text-xs profile-text-dim">
                                            <span>Progress: <strong class="profile-text-strong progress-text">{{ $enrollment->progress ?? 0 }}%</strong></span>
                                            <span>Status: <strong class="profile-text-strong status-text">{{ $enrollment->completed ? 'Completed' : 'In Progress' }}</strong></span>
                                        </div>
                                        <div class="profile-progress-track w-full rounded-full h-2 mt-3">
                                            <div class="profile-progress-fill h-2 rounded-full progress-bar" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                    <div class="profile-percent-chip shrink-0 w-12 h-12 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-bold progress-text">{{ $enrollment->progress ?? 0 }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-3 profile-text-dim text-xs flex items-center gap-2 profile-mono">
                            <span class="chat-live-dot w-1.5 h-1.5 rounded-full bg-emerald-400 inline-block" style="box-shadow: 0 0 6px #34d399;"></span>
                            Progress updates every 30 seconds
                        </p>
                    @else
                        <p class="profile-text-dim italic">You haven't enrolled in any courses yet. <a href="{{ route('courses.index') }}" class="profile-link font-semibold hover:underline">Browse courses</a></p>
                    @endif
                </section>

                <section data-page-animate class="page-delay-2 profile-section-card p-6 md:p-8">
                    <div class="flex items-center justify-between mb-4 gap-4">
                        <h2 class="text-xl font-bold profile-text-strong flex items-center gap-3">
                            <span class="profile-icon-chip chip-amber"><i class="fas fa-certificate"></i></span>
                            My Certificates
                        </h2>
                        <a href="{{ route('certificates.index') }}" class="profile-link hover:text-white text-sm font-semibold whitespace-nowrap">View All</a>
                    </div>

                    @if($completedCertificates->count())
                        <div class="space-y-3">
                            @foreach($completedCertificates as $enrollment)
                                <div class="profile-course-row rounded-xl p-4">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <div>
                                            <p class="text-sm profile-text-dim profile-mono">Completed {{ $enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : 'Recently' }}</p>
                                            <h3 class="text-lg font-semibold profile-text-strong mt-1">{{ $enrollment->course->course_title }}</h3>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('certificates.show', $enrollment->course->slug) }}" class="profile-btn-amber inline-flex items-center px-4 py-2 rounded-lg text-sm min-h-0">
                                                <i class="fas fa-eye mr-2"></i>View
                                            </a>
                                            <button type="button" onclick="window.open('{{ route('certificates.show', $enrollment->course->slug) }}?print=1', '_blank')" class="profile-btn-primary inline-flex items-center px-4 py-2 rounded-lg text-sm min-h-0">
                                                <i class="fas fa-file-download mr-2"></i>PDF
                                            </button>
                                            <a href="{{ route('courses.show', $enrollment->course->slug) }}" class="profile-btn-ghost inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold min-h-0">
                                                <i class="fas fa-book-open mr-2"></i>Course
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="profile-text-dim italic">No completed certificates yet. Finish a course to unlock downloadable certificates.</p>
                    @endif
                </section>

                <section data-page-animate class="page-delay-3 profile-section-card p-6 md:p-8">
                    <div class="flex items-center justify-between mb-4 gap-4">
                        <h2 class="text-xl font-bold profile-text-strong flex items-center gap-3">
                            <span class="profile-icon-chip chip-rose"><i class="fas fa-award"></i></span>
                            Earned Badges
                        </h2>
                        <a href="{{ route('badges.index') }}" class="profile-link hover:text-white text-sm font-semibold">View All</a>
                    </div>

                    @if($earnedBadges->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($earnedBadges as $userBadge)
                                <div class="profile-course-row rounded-xl p-4 group">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="profile-icon-chip chip-cyan text-xl transition group-hover:scale-110" style="width:3rem;height:3rem;">
                                            <i class="fas {{ $userBadge->badge->icon }}"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold profile-text-strong">{{ $userBadge->badge->name }}</h3>
                                            <p class="text-xs uppercase profile-text-dim profile-mono">Earned {{ $userBadge->earned_at ? $userBadge->earned_at->format('M d, Y') : 'Recently' }}</p>
                                        </div>
                                    </div>
                                    <p class="profile-text-body text-sm">{{ $userBadge->badge->description }}</p>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        <button type="button" onclick="copyBadgeDetails({{ json_encode($userBadge->badge->name) }}, {{ json_encode($userBadge->badge->description) }})" class="profile-btn-primary inline-flex items-center px-3 py-2 rounded-lg text-xs min-h-0">
                                            <i class="fas fa-copy mr-2"></i>Copy Info
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="profile-text-dim italic">No badges earned yet. Complete quizzes and courses to earn badges here.</p>
                    @endif
                </section>

                <section data-page-animate class="page-delay-4 profile-section-card p-6 md:p-8">
                    <h2 class="text-xl font-bold profile-text-strong mb-4 flex items-center gap-3">
                        <span class="profile-icon-chip chip-violet"><i class="fas fa-star"></i></span>
                        Skills &amp; Expertise
                    </h2>
                    @if($user->skills && count($user->skills) > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($user->skills as $skill)
                                <div class="profile-skill-chip p-3 rounded-xl text-center cursor-default">
                                    <p class="font-semibold profile-text-strong text-sm">{{ $skill }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="profile-text-dim italic">No skills added yet. <a href="{{ route('userpage.profile-edit') }}" class="profile-link font-semibold hover:underline">Add your skills</a></p>
                    @endif
                </section>

                <section data-page-animate class="page-delay-5 profile-section-card p-6 md:p-8">
                    <h2 class="text-xl font-bold profile-text-strong mb-4 flex items-center gap-3">
                        <span class="profile-icon-chip chip-emerald"><i class="fas fa-briefcase"></i></span>
                        Portfolio Projects
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="profile-course-row rounded-xl overflow-hidden">
                            <div class="profile-thumb h-32 flex items-center justify-center relative">
                                <i class="fas fa-code text-white text-4xl opacity-30 relative z-10"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold profile-text-strong mb-1">E-Learning Platform</h3>
                                <p class="text-sm profile-text-dim mb-3">Full-stack web application using React and Node.js</p>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="profile-tag-chip px-2 py-1 rounded-lg text-xs font-medium">React</span>
                                    <span class="profile-tag-chip px-2 py-1 rounded-lg text-xs font-medium">Node.js</span>
                                </div>
                            </div>
                        </div>
                        <div class="profile-course-row rounded-xl overflow-hidden">
                            <div class="profile-thumb h-32 flex items-center justify-center relative">
                                <i class="fas fa-palette text-white text-4xl opacity-30 relative z-10"></i>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold profile-text-strong mb-1">Portfolio Website</h3>
                                <p class="text-sm profile-text-dim mb-3">Responsive personal portfolio with modern design</p>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="profile-tag-chip px-2 py-1 rounded-lg text-xs font-medium">Tailwind</span>
                                    <span class="profile-tag-chip px-2 py-1 rounded-lg text-xs font-medium">Figma</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="profile-btn-ghost mt-4 w-full py-3 rounded-xl min-h-0" style="border-style: dashed;">
                        <i class="fas fa-plus mr-2"></i> Add Project
                    </button>
                </section>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <section data-page-animate class="page-delay-2 profile-section-card p-6">
                    <h2 class="text-lg font-bold profile-text-strong mb-4 flex items-center gap-2">
                        <i class="fas fa-award" style="color: var(--fx-amber);"></i> Badge Showcase
                    </h2>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['🏃' => 'Quick Learner', '👣' => 'First Steps', '💻' => 'Code Master', '🤝' => 'Team Player', '🔥' => '30-Day Streak', '⭐' => 'Rising Star'] as $emoji => $label)
                            <div class="profile-badge-tile text-center cursor-default" title="{{ $label }}">
                                <div class="text-3xl mb-1">{{ $emoji }}</div>
                                <p class="text-[10px] font-semibold profile-text-dim leading-tight">{{ $label }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section data-page-animate class="page-delay-3 profile-tint-indigo rounded-2xl p-6">
                    <h2 class="text-lg font-bold profile-text-strong mb-4 flex items-center gap-2">
                        <i class="fas fa-user-tie" style="color: var(--fx-indigo);"></i> My Mentor
                    </h2>
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 rounded-full mx-auto mb-3 flex items-center justify-center text-white text-xl font-bold" style="background: linear-gradient(135deg, var(--fx-indigo), var(--fx-violet)); box-shadow: 0 0 20px rgba(99,102,241,0.45);">SK</div>
                        <h3 class="font-semibold profile-text-strong">Sarah Kim</h3>
                        <p class="text-sm profile-text-body">Senior Product Designer</p>
                    </div>
                    <a href="{{ route('mentors') }}" class="profile-btn-primary w-full inline-flex items-center justify-center py-2.5 rounded-xl text-sm min-h-0">
                        <i class="fas fa-calendar mr-2"></i> Schedule Session
                    </a>
                </section>

                <section data-page-animate class="page-delay-4 profile-tint-amber rounded-2xl p-6">
                    <h2 class="text-lg font-bold profile-text-strong mb-4 flex items-center gap-2">
                        <span class="profile-streak-flame"><i class="fas fa-fire" style="color: var(--fx-amber);"></i></span> Learning Streak
                    </h2>
                    <div class="text-center">
                        <div class="profile-streak-value text-5xl font-black mb-1 tabular-nums" data-countup="27">27</div>
                        <p class="profile-text-body text-sm">Days in a Row</p>
                        <p class="text-sm profile-text-dim mt-3">Keep it up! You're making amazing progress.</p>
                    </div>
                </section>

                <section data-page-animate class="page-delay-5 profile-section-card p-6">
                    <h2 class="text-lg font-bold profile-text-strong mb-4 flex items-center gap-2">
                        <i class="fas fa-bullseye" style="color: var(--fx-rose);"></i> Goals
                    </h2>
                    <div class="space-y-3">
                        <div class="p-3 rounded-xl transition hover:shadow-md" style="background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.25);">
                            <p class="font-semibold profile-text-strong text-sm">Complete Full Stack Path</p>
                            <p class="text-xs profile-text-dim mt-1">68% complete</p>
                        </div>
                        <div class="p-3 rounded-xl transition hover:shadow-md" style="background: rgba(34,211,238,0.08); border: 1px solid rgba(34,211,238,0.25);">
                            <p class="font-semibold profile-text-strong text-sm">Build 5 Portfolio Projects</p>
                            <p class="text-xs profile-text-dim mt-1">2 of 5 completed</p>
                        </div>
                        <div class="p-3 rounded-xl transition hover:shadow-md" style="background: rgba(139,123,255,0.08); border: 1px solid rgba(139,123,255,0.25);">
                            <p class="font-semibold profile-text-strong text-sm">Land First Tech Job</p>
                            <p class="text-xs profile-text-dim mt-1">In progress</p>
                        </div>
                    </div>
                </section>

                <section data-page-animate class="profile-section-card p-6">
                    <h2 class="text-lg font-bold profile-text-strong mb-4">Recent Activity</h2>
                    <div class="space-y-4 text-sm">
                        @foreach([
                            ['action' => 'Completed', 'detail' => 'JavaScript Basics', 'time' => '2 days ago'],
                            ['action' => 'Earned', 'detail' => 'Code Master Badge', 'time' => '5 days ago'],
                            ['action' => 'Started', 'detail' => 'React Advanced Course', 'time' => '1 week ago'],
                        ] as $activity)
                            <div class="profile-timeline-item pb-1">
                                <p class="profile-text-body"><strong class="profile-text-strong">{{ $activity['action'] }}:</strong> {{ $activity['detail'] }}</p>
                                <p class="profile-text-dim text-xs mt-0.5 profile-mono">{{ $activity['time'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@include('partials.page-animate')

@push('scripts')
<script>
    function refreshCourseStats() {
        fetch("{{ route('userpage.enrollments.stats') }}")
            .then(r => r.json())
            .then(data => {
                data.forEach(en => {
                    const container = document.getElementById('enroll-' + en.id);
                    if (!container) return;
                    container.querySelectorAll('.progress-text').forEach(el => el.textContent = (en.progress ?? 0) + '%');
                    const statusEl = container.querySelector('.status-text');
                    if (statusEl) statusEl.textContent = en.completed ? 'Completed' : 'In Progress';
                    const bar = container.querySelector('.progress-bar');
                    if (bar) bar.style.width = (en.progress ?? 0) + '%';
                });
            })
            .catch(console.error);
    }

    setInterval(refreshCourseStats, 30000);

    function copyBadgeDetails(name, description) {
        const badgeText = name + ' - ' + description;
        if (!navigator.clipboard) {
            window.prompt('Copy badge details:', badgeText);
            return;
        }
        navigator.clipboard.writeText(badgeText)
            .then(() => alert('Badge details copied to clipboard!'))
            .catch(() => window.prompt('Copy badge details:', badgeText));
    }

    (function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        document.querySelectorAll('[data-countup]').forEach(function (el) {
            var target = parseInt(el.getAttribute('data-countup'), 10);
            if (isNaN(target)) return;
            var suffix = el.getAttribute('data-countup-suffix') || '';
            var start = 0;
            var duration = 900;
            var startTime = null;
            function step(ts) {
                if (!startTime) startTime = ts;
                var p = Math.min((ts - startTime) / duration, 1);
                el.textContent = Math.round(start + (target - start) * (1 - Math.pow(1 - p, 3))) + suffix;
                if (p < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        });
    })();
</script>
@endpush
@endsection