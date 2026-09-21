

<?php $__env->startSection('title', 'SkillUp AI Chatbot - Career & Learning Assistant'); ?>

<?php $__env->startPush('head'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
    :root {
        --ai-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --void: #050b16;
        --navy-deep: #0a1f3d;
        --navy: #0f2847;
        --ai-navy: #0a2540;
        --ai-blue: #003a8f;
        --cyan: #00e0ff;
        --violet: #8b7bff;
        --amber: #ffb020;
        --emerald: #34e8b0;
        --ink: #0f172a;
        --font-display: 'Space Grotesk', 'Inter', sans-serif;
        --font-body: 'Inter', sans-serif;
        --font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    .ai-page {
        min-height: calc(100vh - 5rem);
        background:
            radial-gradient(ellipse 60% 50% at 20% 0%, rgba(0, 224, 255, 0.10), transparent 60%),
            radial-gradient(ellipse 60% 50% at 100% 100%, rgba(139, 123, 255, 0.12), transparent 60%),
            linear-gradient(160deg, var(--void) 0%, var(--navy-deep) 45%, #0d1b2f 75%, var(--void) 100%);
        position: relative;
        overflow: hidden;
        padding: 1.5rem 1rem 2rem;
        font-family: var(--font-body);
        isolation: isolate;
    }

    /* Structural grid + scanline: the futuristic "console" backdrop */
    .ai-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(0, 224, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 224, 255, 0.05) 1px, transparent 1px);
        background-size: 42px 42px;
        mask-image: radial-gradient(ellipse 80% 70% at 50% 20%, black 15%, transparent 75%);
        pointer-events: none;
        z-index: 0;
    }

    .ai-scanline {
        position: absolute;
        left: 0;
        right: 0;
        height: 120px;
        background: linear-gradient(180deg, transparent, rgba(0, 224, 255, 0.06), transparent);
        pointer-events: none;
        z-index: 1;
        animation: aiScanSweep 9s linear infinite;
    }

    @keyframes aiScanSweep {
        0%   { top: -140px; opacity: 0; }
        8%   { opacity: 1; }
        92%  { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }

    #networkCanvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: 0.55;
    }

    #draggableChatWindow {
        position: absolute;
        top: 5.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: min(100%, 760px);
        height: calc(100vh - 7rem);
        min-height: 520px;
        max-height: calc(100vh - 5rem);
        display: flex;
        flex-direction: column;
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 1.75rem;
        border: 1px solid rgba(0, 224, 255, 0.18);
        box-shadow:
            0 0 0 1px rgba(0, 224, 255, 0.06),
            0 32px 64px rgba(0, 0, 0, 0.45),
            0 0 90px rgba(0, 224, 255, 0.10);
        overflow: hidden;
        animation: aiWindowEnter 0.7s var(--ai-ease) forwards;
        z-index: 10;
    }

    @keyframes aiWindowEnter {
        from { opacity: 0; transform: translateX(-50%) translateY(24px) scale(0.97); }
        to   { opacity: 1; transform: translateX(-50%) translateY(0) scale(1); }
    }

    /* HUD corner brackets — the signature framing detail */
    .hud-corner {
        position: absolute;
        width: 22px;
        height: 22px;
        border-color: var(--cyan);
        opacity: 0.65;
        pointer-events: none;
        z-index: 15;
        animation: aiHudPulse 3.2s ease-in-out infinite;
    }
    .hud-corner.tl { top: -1px; left: -1px; border-top: 2px solid; border-left: 2px solid; border-top-left-radius: 1.75rem; }
    .hud-corner.tr { top: -1px; right: -1px; border-top: 2px solid; border-right: 2px solid; border-top-right-radius: 1.75rem; animation-delay: .4s; }
    .hud-corner.bl { bottom: -1px; left: -1px; border-bottom: 2px solid; border-left: 2px solid; border-bottom-left-radius: 1.75rem; animation-delay: .8s; }
    .hud-corner.br { bottom: -1px; right: -1px; border-bottom: 2px solid; border-right: 2px solid; border-bottom-right-radius: 1.75rem; animation-delay: 1.2s; }

    @keyframes aiHudPulse {
        0%, 100% { opacity: 0.4; }
        50%      { opacity: 0.9; }
    }

    #dragHandle {
        background: linear-gradient(135deg, var(--ai-navy) 0%, var(--ai-blue) 100%);
        border-bottom: 1px solid rgba(0, 224, 255, 0.15);
        cursor: grab;
        touch-action: none;
        position: relative;
        overflow: hidden;
    }

    #dragHandle::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 40%, rgba(0, 224, 255, 0.10) 50%, transparent 60%);
        animation: aiShine 4s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes aiShine {
        0%, 100% { transform: translateX(-100%); }
        50%      { transform: translateX(100%); }
    }

    #dragHandle.cursor-grabbing { cursor: grabbing; }

    .ai-avatar-wrap { position: relative; }

    .ai-avatar-wrap::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 1.1rem;
        background: conic-gradient(from 0deg, var(--cyan), var(--violet) 40%, transparent 55%, var(--cyan));
        filter: blur(5px);
        opacity: 0.65;
        animation: aiSpin 5s linear infinite;
        z-index: -1;
    }

    @keyframes aiSpin { to { transform: rotate(360deg); } }

    .ai-avatar {
        animation: aiAvatarFloat 3s ease-in-out infinite;
        box-shadow: 0 8px 24px rgba(0, 58, 143, 0.4);
    }

    @keyframes aiAvatarFloat {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-3px); }
    }

    h1, .ai-display {
        font-family: var(--font-display);
        letter-spacing: 0.01em;
    }

    .ai-mono {
        font-family: var(--font-mono);
        letter-spacing: 0.02em;
    }

    .ai-status-line {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--emerald);
    }

    .ai-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--emerald);
        box-shadow: 0 0 0 0 rgba(52, 232, 176, 0.6);
        animation: aiStatusPulse 2s ease-in-out infinite;
    }

    @keyframes aiStatusPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(52, 232, 176, 0.55); }
        50%      { box-shadow: 0 0 0 6px rgba(52, 232, 176, 0); }
    }

    .ai-status-cursor::after {
        content: '_';
        animation: aiBlink 1s step-end infinite;
    }

    @keyframes aiBlink { 50% { opacity: 0; } }

    #chatMessages {
        scroll-behavior: smooth;
        background:
            radial-gradient(ellipse at top, rgba(0, 58, 143, 0.05), transparent 55%),
            linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .ai-quick-card {
        position: relative;
        transition: transform 0.3s var(--ai-ease), box-shadow 0.3s var(--ai-ease), border-color 0.25s ease;
        animation: aiCardIn 0.5s var(--ai-ease) backwards;
        overflow: hidden;
    }

    .ai-quick-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--cyan), var(--violet));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.35s var(--ai-ease);
    }

    .ai-quick-card:hover::before { transform: scaleX(1); }

    .ai-quick-card:nth-child(1) { animation-delay: 0.1s; }
    .ai-quick-card:nth-child(2) { animation-delay: 0.15s; }
    .ai-quick-card:nth-child(3) { animation-delay: 0.2s; }
    .ai-quick-card:nth-child(4) { animation-delay: 0.25s; }
    .ai-quick-card:nth-child(5) { animation-delay: 0.3s; }

    @keyframes aiCardIn {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .ai-quick-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 16px 36px rgba(0, 58, 143, 0.14), 0 0 0 1px rgba(0, 224, 255, 0.25);
    }

    .ai-chip {
        transition: transform 0.22s var(--ai-ease), box-shadow 0.22s ease, background 0.22s ease;
    }

    .ai-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 58, 143, 0.25);
    }

    .ai-chip:active { transform: scale(0.97); }

    .message-animate {
        animation: aiMessageIn 0.4s var(--ai-ease) forwards;
    }

    @keyframes aiMessageIn {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .user-group .message-animate { animation-name: aiMessageInUser; }

    @keyframes aiMessageInUser {
        from { opacity: 0; transform: translateX(12px) translateY(8px); }
        to   { opacity: 1; transform: translateX(0) translateY(0); }
    }

    .ai-group .message-animate { animation-name: aiMessageInBot; }

    @keyframes aiMessageInBot {
        from { opacity: 0; transform: translateX(-12px) translateY(8px); }
        to   { opacity: 1; transform: translateX(0) translateY(0); }
    }

    .message-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        max-width: 100%;
    }

    .user-group { align-items: flex-end; }
    .ai-group { align-items: flex-start; }

    .message-bubble {
        max-width: min(88%, 36rem);
        line-height: 1.65;
        word-break: break-word;
        position: relative;
    }

    .user-bubble {
        border-radius: 1.25rem 1.25rem 0.35rem 1.25rem;
        background: linear-gradient(135deg, var(--ai-blue) 0%, #1e40af 100%);
        color: #f8fafc;
        box-shadow: 0 10px 28px rgba(0, 58, 143, 0.28), 0 0 0 1px rgba(0, 224, 255, 0.12);
        padding: 0.75rem 1.15rem;
    }

    .ai-bubble {
        border-radius: 1.25rem 1.25rem 1.25rem 0.35rem;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(6px);
        color: var(--ink);
        border: 1px solid rgba(148, 163, 184, 0.25);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        padding: 0.75rem 1.15rem 0.75rem 1.3rem;
    }

    .ai-bubble::before {
        content: '';
        position: absolute;
        left: 0; top: 0.35rem; bottom: 0.35rem;
        width: 3px;
        border-radius: 3px;
        background: linear-gradient(180deg, var(--cyan), var(--violet));
        opacity: 0.7;
    }

    .ai-msg-avatar {
        position: relative;
        box-shadow: 0 0 0 3px rgba(0, 224, 255, 0.10);
    }

    .ai-input-wrap {
        transition: box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .ai-input-wrap:focus-within {
        border-color: var(--cyan);
        box-shadow: 0 0 0 4px rgba(0, 224, 255, 0.14);
    }

    .ai-send-btn {
        background: linear-gradient(135deg, var(--ai-blue), var(--ai-navy));
        transition: transform 0.2s var(--ai-ease), box-shadow 0.2s ease, filter 0.2s ease;
    }

    .ai-send-btn:hover:not(:disabled) {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 12px 28px rgba(0, 224, 255, 0.30);
        filter: brightness(1.05);
    }

    .ai-send-btn:disabled { opacity: 0.6; cursor: not-allowed; }

    /* Redesigned "processing" indicator */
    .ai-processing-bar {
        position: relative;
        width: 100%;
        height: 2px;
        background: rgba(0, 58, 143, 0.12);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .ai-processing-bar::after {
        content: '';
        position: absolute;
        top: 0; left: -30%;
        width: 30%;
        height: 100%;
        background: linear-gradient(90deg, transparent, var(--cyan), transparent);
        animation: aiProcessingSlide 1.1s ease-in-out infinite;
    }

    @keyframes aiProcessingSlide {
        0%   { left: -30%; }
        100% { left: 100%; }
    }

    .ai-typing-dot {
        animation: aiTypingBounce 1.2s ease-in-out infinite;
    }

    .ai-typing-dot:nth-child(2) { animation-delay: 0.15s; }
    .ai-typing-dot:nth-child(3) { animation-delay: 0.3s; }

    @keyframes aiTypingBounce {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
        30% { transform: translateY(-6px); opacity: 1; }
    }

    @media (max-width: 768px) {
        #draggableChatWindow {
            position: relative;
            top: 0;
            left: 0;
            transform: none;
            width: 100%;
            height: calc(100vh - 6rem);
            min-height: auto;
            max-height: none;
            animation: aiWindowEnterMobile 0.6s var(--ai-ease) forwards;
        }

        @keyframes aiWindowEnterMobile {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        #dragHandle { cursor: default; }
        #dragHandle::after { display: none; }
        .hud-corner { width: 16px; height: 16px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .ai-avatar, .ai-avatar-wrap::before, .ai-status-dot, .ai-quick-card,
        #draggableChatWindow, #dragHandle::after, .ai-scanline, .hud-corner,
        .ai-processing-bar::after, .ai-status-cursor::after {
            animation: none !important;
        }
        .message-animate { animation: none !important; opacity: 1 !important; transform: none !important; }
        #networkCanvas { display: none; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $user = auth()->user();
    $profile = $user->profile ?? null;
    $profileComplete = $profile?->interest && $profile?->skill_level;
?>

<div class="ai-page">
    <canvas id="networkCanvas" aria-hidden="true"></canvas>
    <div class="ai-scanline" aria-hidden="true"></div>

    <div id="draggableChatWindow">
        <div class="hud-corner tl"></div>
        <div class="hud-corner tr"></div>
        <div class="hud-corner bl"></div>
        <div class="hud-corner br"></div>

        
        <div id="dragHandle" class="px-4 sm:px-6 py-4 flex items-center justify-between gap-3 relative z-10">
            <div class="flex items-center gap-3 min-w-0">
                <div class="ai-avatar-wrap ai-avatar w-12 h-12 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center shrink-0 overflow-hidden p-1.5">
                    <img src="<?php echo e(asset('image/logo_oif_skillup_1_-removebg-preview.png')); ?>" alt="" class="h-full w-full object-contain">
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <h1 class="ai-display text-lg font-bold text-white truncate">SKILL.UP AI</h1>
                    </div>
                    <p class="ai-mono text-[11px] ai-status-line ai-status-cursor">
                        <span class="ai-status-dot shrink-0"></span> AI::ONLINE
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profileComplete): ?>
                    <span class="ai-mono hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-500/15 border border-emerald-400/30 text-emerald-200 text-[10px] font-semibold uppercase tracking-wider">
                        <i class="fas fa-check-circle text-[10px]"></i> Ready · <?php echo e($profile->skill_level); ?>

                    </span>
                <?php else: ?>
                    <span class="ai-mono hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-500/15 border border-amber-400/30 text-amber-100 text-[10px] font-semibold uppercase tracking-wider">
                        <i class="fas fa-circle-exclamation text-[10px]"></i> Setup Needed
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <span class="hidden md:inline ai-mono text-[10px] text-cyan-200/50 uppercase tracking-widest">Drag</span>
                <a href="<?php echo e(route('home')); ?>" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white/10 text-white/80 hover:bg-white/20 hover:text-white transition" aria-label="Close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        
        <div class="flex-1 overflow-y-auto px-4 sm:px-6 py-6 space-y-4" id="chatMessages">
            <div class="message-group ai-group message-animate mb-2" data-sender="ai" id="welcome-message">
                <div class="flex gap-3 items-start">
                    <div class="ai-msg-avatar w-9 h-9 rounded-xlbg-gradient-to-br from-[#003a8f] to-[#0a2540] flex-shrink-0 flex items-center justify-center shadow-md">
                        <i class="fas fa-robot text-white text-sm"></i>
                    </div>
                    <div class="message-bubble ai-bubble">
                        <p class="text-sm leading-relaxed">Hello! I'm <strong>SKILL.UP AI</strong>, your TESDA-aligned learning assistant. Ask about careers, courses, skills, or training paths — or tap a quick action below.</p>
                    </div>
                </div>
            </div>

            <div id="quick-actions-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4 max-w-2xl">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$profileComplete): ?>
                    <button type="button" onclick="sendQuickMessage('I\'m interested in information technology and I\'m a beginner')" class="ai-quick-card p-4 rounded-2xl border-2 border-blue-200/80 bg-gradient-to-br from-blue-50 to-white text-left">
                        <i class="fas fa-laptop-code text-[#003a8f] text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">I.T Career Path</strong>
                        <span class="text-xs text-gray-500">Beginner-friendly tech track</span>
                    </button>
                    <button type="button" onclick="sendQuickMessage('I\'m interested in healthcare and I have some experience')" class="ai-quick-card p-4 rounded-2xl border-2 border-rose-200/80 bg-gradient-to-br from-rose-50 to-white text-left">
                        <i class="fas fa-stethoscope text-rose-600 text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">Healthcare</strong>
                        <span class="text-xs text-gray-500">Medical & care careers</span>
                    </button>
                    <button type="button" onclick="sendQuickMessage('I\'m interested in construction and I\'m experienced')" class="ai-quick-card p-4 rounded-2xl border-2 border-amber-200/80 bg-gradient-to-br from-amber-50 to-white text-left">
                        <i class="fas fa-hammer text-amber-600 text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">Construction</strong>
                        <span class="text-xs text-gray-500">Build trade skills</span>
                    </button>
                    <button type="button" onclick="sendQuickMessage('Tell me about all TESDA career options')" class="ai-quick-card p-4 rounded-2xl border-2 border-violet-200/80 bg-gradient-to-br from-violet-50 to-white text-left">
                        <i class="fas fa-compass text-violet-600 text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">Explore Options</strong>
                        <span class="text-xs text-gray-500">All TESDA career paths</span>
                    </button>
                <?php else: ?>
                    <button type="button" onclick="sendQuickMessage('What courses should I take next?')" class="ai-quick-card p-4 rounded-2xl border-2 border-blue-200/80 bg-gradient-to-br from-blue-50 to-white text-left">
                        <i class="fas fa-graduation-cap text-[#003a8f] text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">Next Steps</strong>
                        <span class="text-xs text-gray-500"><?php echo e($profile->interest); ?> · <?php echo e($profile->skill_level); ?></span>
                    </button>
                    <button type="button" onclick="sendQuickMessage('How long will it take to complete my certification?')" class="ai-quick-card p-4 rounded-2xl border-2 border-emerald-200/80 bg-gradient-to-br from-emerald-50 to-white text-left">
                        <i class="fas fa-clock text-emerald-600 text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">Training Duration</strong>
                        <span class="text-xs text-gray-500">Certification timeline</span>
                    </button>
                    <button type="button" onclick="sendQuickMessage('Where are the nearest TESDA training centers?')" class="ai-quick-card p-4 rounded-2xl border-2 border-orange-200/80 bg-gradient-to-br from-orange-50 to-white text-left">
                        <i class="fas fa-map-marker-alt text-orange-600 text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">TESDA Centers</strong>
                        <span class="text-xs text-gray-500">Find nearby training</span>
                    </button>
                    <button type="button" onclick="sendQuickMessage('What are the job prospects after my training?')" class="ai-quick-card p-4 rounded-2xl border-2 border-violet-200/80 bg-gradient-to-br from-violet-50 to-white text-left">
                        <i class="fas fa-briefcase text-violet-600 text-lg mb-2 block"></i>
                        <strong class="text-sm text-gray-800 block">Job Prospects</strong>
                        <span class="text-xs text-gray-500">Career outcomes</span>
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="border-t border-slate-200/80 bg-white/80 backdrop-blur-sm px-4 sm:px-6 py-3">
            <p class="ai-mono text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Quick replies</p>
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="sendQuickMessage('Find courses')" class="ai-chip px-4 py-2 rounded-full bg-[#003a8f] text-white text-xs font-semibold">Find courses</button>
                <button type="button" onclick="sendQuickMessage('Career advice')" class="ai-chip px-4 py-2 rounded-full bg-slate-700 text-white text-xs font-semibold">Career advice</button>
                <button type="button" onclick="sendQuickMessage('TESDA centers')" class="ai-chip px-4 py-2 rounded-full bg-sky-500 text-white text-xs font-semibold">TESDA centers</button>
                <button type="button" onclick="sendQuickMessage('Study tips')" class="ai-chip px-4 py-2 rounded-full border border-slate-200 bg-slate-50 text-slate-700 text-xs font-semibold">Study tips</button>
            </div>
        </div>

        
        <div class="border-t border-slate-200 bg-white px-4 sm:px-6 py-4">
            <form id="messageForm" class="flex gap-2 sm:gap-3 items-end">
                <?php echo csrf_field(); ?>
                <div class="ai-input-wrap flex-1 flex items-center rounded-2xl border border-slate-200 bg-slate-50 min-w-0">
                    <input
                        type="text"
                        id="messageInput"
                        name="message"
                        placeholder="Ask about careers, courses, or skills..."
                        class="flex-1 min-w-0 bg-transparent px-4 py-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none"
                        required
                        autocomplete="off"
                    >
                </div>
                <button type="submit" id="sendBtn" class="ai-send-btn shrink-0 w-12 h-12 sm:w-auto sm:px-6 sm:py-3.5 rounded-2xl text-white font-semibold flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-sm"></i>
                    <span class="hidden sm:inline text-sm">Send</span>
                </button>
            </form>
            <p class="ai-mono text-[10px] text-slate-400 mt-2 text-center">POWERED BY SKILLUP AI · TESDA-ALIGNED GUIDANCE</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatMessages = document.getElementById('chatMessages');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const dragWindow = document.getElementById('draggableChatWindow');
    const dragHandle = document.getElementById('dragHandle');
    const quickActionsGrid = document.getElementById('quick-actions-grid');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let isDragging = false;
    let dragOffsetX = 0;
    let dragOffsetY = 0;

    // Drag window (desktop)
    if (dragHandle && window.matchMedia('(min-width: 769px)').matches) {
        dragHandle.addEventListener('pointerdown', (event) => {
            if (event.target.closest('a, button')) return;
            isDragging = true;
            dragHandle.setPointerCapture(event.pointerId);
            dragHandle.classList.add('cursor-grabbing');
            const rect = dragWindow.getBoundingClientRect();
            dragOffsetX = event.clientX - rect.left;
            dragOffsetY = event.clientY - rect.top;
        });

        window.addEventListener('pointermove', (event) => {
            if (!isDragging) return;
            event.preventDefault();
            const maxX = window.innerWidth - dragWindow.offsetWidth;
            const maxY = window.innerHeight - dragWindow.offsetHeight;
            let left = Math.min(Math.max(event.clientX - dragOffsetX, 8), maxX - 8);
            let top = Math.min(Math.max(event.clientY - dragOffsetY, 72), maxY - 8);
            dragWindow.style.left = `${left}px`;
            dragWindow.style.top = `${top}px`;
            dragWindow.style.transform = 'none';
        });

        const endDrag = () => {
            if (isDragging) {
                isDragging = false;
                dragHandle.classList.remove('cursor-grabbing');
            }
        };
        window.addEventListener('pointerup', endDrag);
        window.addEventListener('pointercancel', endDrag);
    }

    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        hideQuickActions();
        addUserMessage(message);
        messageInput.value = '';
        setSending(true);
        showLoadingIndicator();
        detectAndSaveProfile(message);

        try {
            const response = await fetch('<?php echo e(route("ai-chatbot.send-message")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            removeLoadingIndicator();

            if (data.success && data.aiResponse) {
                addAIMessage(data.aiResponse);
            } else {
                addAIMessage(data.error || 'The AI assistant is temporarily unavailable. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            removeLoadingIndicator();
            addAIMessage('Connection error. Please check your network and try again.');
        } finally {
            setSending(false);
        }
    });

    function setSending(active) {
        sendBtn.disabled = active;
        messageInput.disabled = active;
    }

    function hideQuickActions() {
        if (quickActionsGrid && !quickActionsGrid.dataset.hidden) {
            quickActionsGrid.style.transition = 'opacity 0.35s ease, transform 0.35s ease, max-height 0.4s ease';
            quickActionsGrid.style.opacity = '0';
            quickActionsGrid.style.transform = 'translateY(-8px)';
            quickActionsGrid.style.maxHeight = '0';
            quickActionsGrid.style.overflow = 'hidden';
            quickActionsGrid.style.marginBottom = '0';
            quickActionsGrid.dataset.hidden = '1';
            setTimeout(() => { quickActionsGrid.style.display = 'none'; }, 400);
        }
    }

    function addUserMessage(text) { appendMessageGroup('user', text); }
    function addAIMessage(text) { appendMessageGroup('ai', text); }

    function appendMessageGroup(sender, text) {
        const groups = Array.from(chatMessages.querySelectorAll('.message-group[data-sender]'));
        const lastGroup = groups[groups.length - 1];
        const sameSenderGroup = lastGroup && lastGroup.dataset.sender === sender && lastGroup.id !== 'welcome-message';

        let groupDiv;
        if (sameSenderGroup && sender === 'user') {
            groupDiv = lastGroup;
        } else {
            groupDiv = document.createElement('div');
            groupDiv.className = `message-group ${sender === 'user' ? 'user-group' : 'ai-group'} message-animate mb-3`;
            groupDiv.dataset.sender = sender;
            chatMessages.appendChild(groupDiv);
        }

        const bubble = document.createElement('div');
        bubble.className = `message-bubble ${sender === 'user' ? 'user-bubble' : 'ai-bubble'}`;
        bubble.innerHTML = `<p class="text-sm leading-relaxed whitespace-pre-line">${escapeHtml(text)}</p>`;

        if (sender === 'ai') {
            const aiRow = document.createElement('div');
            aiRow.className = 'flex gap-3 items-start';
            aiRow.innerHTML = `
                <div class="ai-msg-avatar w-9 h-9 rounded-xl bg-gradient-to-br from-[#003a8f] to-[#0a2540] flex-shrink-0 flex items-center justify-center shadow-sm">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
            `;
            aiRow.appendChild(bubble);
            groupDiv.appendChild(aiRow);
        } else {
            groupDiv.appendChild(bubble);
        }

        scrollToBottom();
    }

    function showLoadingIndicator() {
        removeLoadingIndicator();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = 'loadingIndicator';
        loadingDiv.className = 'flex justify-start mb-3 message-animate';
        loadingDiv.innerHTML = `
            <div class="flex gap-3 items-start w-full">
                <div class="ai-msg-avatar w-9 h-9 rounded-xl bg-gradient-to-br from-[#003a8f] to-[#0a2540] flex-shrink-0 flex items-center justify-center">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div class="ai-bubble px-5 py-4 rounded-2xl bg-white border border-slate-200 shadow-sm min-w-[200px]">
                    <div class="flex items-center gap-1.5 mb-1">
                        <span class="ai-typing-dot w-2 h-2 rounded-full bg-[#003a8f]"></span>
                        <span class="ai-typing-dot w-2 h-2 rounded-full bg-[#003a8f]"></span>
                        <span class="ai-typing-dot w-2 h-2 rounded-full bg-[#003a8f]"></span>
                    </div>
                    <p class="ai-mono text-[10px] uppercase tracking-wider text-slate-500">Processing</p>
                    <div class="ai-processing-bar"></div>
                </div>
            </div>
        `;
        chatMessages.appendChild(loadingDiv);
        scrollToBottom();
    }

    function removeLoadingIndicator() {
        document.getElementById('loadingIndicator')?.remove();
    }

    window.sendQuickMessage = function(message) {
        messageInput.value = message;
        messageForm.requestSubmit();
    };

    function scrollToBottom() {
        requestAnimationFrame(() => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function detectAndSaveProfile(message) {
        const lowerMessage = message.toLowerCase();
        const interestMap = {
            'information technology': ['technology', 'it', 'programming', 'tech', 'coding', 'software'],
            'Healthcare': ['healthcare', 'health', 'medical', 'nursing', 'hospital'],
            'Construction': ['construction', 'building', 'carpenter', 'architect'],
            'Automotive': ['automotive', 'car', 'mechanic', 'vehicle'],
            'Tourism': ['tourism', 'travel', 'hotel', 'hospitality'],
            'Agriculture': ['agriculture', 'farming', 'farm', 'crop']
        };
        const skillLevelMap = {
            'Beginner': ['beginner', 'start', 'new', 'learning', 'no experience'],
            'Intermediate': ['intermediate', 'some experience', 'familiar'],
            'Experienced': ['experienced', 'professional', 'expert', 'advanced']
        };
        let detectedInterest = null;
        let detectedSkillLevel = null;
        for (const [interest, keywords] of Object.entries(interestMap)) {
            if (keywords.some(k => lowerMessage.includes(k))) { detectedInterest = interest; break; }
        }
        for (const [level, keywords] of Object.entries(skillLevelMap)) {
            if (keywords.some(k => lowerMessage.includes(k))) { detectedSkillLevel = level; break; }
        }
        if (detectedInterest || detectedSkillLevel) saveProfile(detectedInterest, detectedSkillLevel);
    }

    function saveProfile(interest, skillLevel) {
        fetch('/api/profile/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
            body: JSON.stringify({ interest, skill_level: skillLevel })
        }).catch(() => {});
    }

    messageInput.focus();

    // Ambient neural-network background — signature visual for the AI page
    initNetworkCanvas();

    function initNetworkCanvas() {
        const canvas = document.getElementById('networkCanvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const page = document.querySelector('.ai-page');
        let width, height, nodes;
        const LINK_DIST = 150;
        const NODE_COUNT_BASE = 60;

        function resize() {
            width = canvas.width = page.offsetWidth;
            height = canvas.height = page.offsetHeight;
            const count = Math.min(NODE_COUNT_BASE, Math.floor((width * height) / 16000));
            nodes = Array.from({ length: count }, () => ({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.25,
                vy: (Math.random() - 0.5) * 0.25
            }));
        }

        function step() {
            ctx.clearRect(0, 0, width, height);
            for (const n of nodes) {
                n.x += n.vx;
                n.y += n.vy;
                if (n.x < 0 || n.x > width) n.vx *= -1;
                if (n.y < 0 || n.y > height) n.vy *= -1;
            }
            for (let i = 0; i < nodes.length; i++) {
                for (let j = i + 1; j < nodes.length; j++) {
                    const a = nodes[i], b = nodes[j];
                    const dx = a.x - b.x, dy = a.y - b.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < LINK_DIST) {
                        ctx.strokeStyle = `rgba(0, 224, 255, ${0.14 * (1 - dist / LINK_DIST)})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(a.x, a.y);
                        ctx.lineTo(b.x, b.y);
                        ctx.stroke();
                    }
                }
            }
            for (const n of nodes) {
                ctx.fillStyle = 'rgba(139, 123, 255, 0.55)';
                ctx.beginPath();
                ctx.arc(n.x, n.y, 1.6, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        resize();
        window.addEventListener('resize', resize);

        if (prefersReducedMotion) {
            step();
            return;
        }

        function loop() {
            step();
            requestAnimationFrame(loop);
        }
        loop();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\ai-chatbot\index.blade.php ENDPATH**/ ?>