@extends('layout.app')

@section('title', 'Notifications - SkillUp')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
    :root {
        --notify-ease: cubic-bezier(0.22, 1, 0.36, 1);
        --notify-void: #050b16;
        --notify-navy-deep: #061829;
        --notify-navy: #0a2540;
        --notify-blue: #003a8f;
        --notify-cyan: #00e0ff;
        --notify-violet: #8b7bff;
        --notify-emerald: #34e8b0;
        --notify-rose: #f43f5e;
        --font-display: 'Space Grotesk', 'Inter', sans-serif;
        --font-mono: 'JetBrains Mono', ui-monospace, monospace;
    }

    .notify-mono { font-family: var(--font-mono); letter-spacing: 0.03em; }
    .notify-display { font-family: var(--font-display); }

    .notify-hero {
        background:
            radial-gradient(ellipse 70% 60% at 100% 0%, rgba(0, 224, 255, 0.16), transparent 55%),
            radial-gradient(ellipse 60% 50% at 0% 100%, rgba(139, 123, 255, 0.14), transparent 55%),
            linear-gradient(145deg, var(--notify-navy-deep) 0%, var(--notify-navy) 45%, var(--notify-blue) 100%) !important;
        color: #fff;
        position: relative;
        overflow: hidden;
        isolation: isolate;
        border: 1px solid rgba(0, 224, 255, 0.16);
    }

    /* Console grid + scanline, confined to the hero panel */
    .notify-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(0, 224, 255, 0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 224, 255, 0.06) 1px, transparent 1px);
        background-size: 38px 38px;
        mask-image: radial-gradient(ellipse 90% 100% at 100% 0%, black 10%, transparent 75%);
        pointer-events: none;
        z-index: 0;
    }

    .notify-hero-shine {
        position: absolute;
        inset: 0;
        background: linear-gradient(105deg, transparent 35%, rgba(255, 255, 255, 0.08) 50%, transparent 65%);
        background-size: 220% 100%;
        animation: notifyShine 5s linear infinite;
        pointer-events: none;
        z-index: 0;
    }

    @keyframes notifyShine {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .notify-scan {
        position: absolute;
        left: 0; right: 0;
        height: 90px;
        background: linear-gradient(180deg, transparent, rgba(0, 224, 255, 0.10), transparent);
        pointer-events: none;
        z-index: 0;
        animation: notifyScanSweep 6s linear infinite;
    }

    @keyframes notifyScanSweep {
        0%   { top: -100px; opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }

    #notifyNetCanvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: 0.5;
        pointer-events: none;
    }

    /* HUD corner brackets on the hero console */
    .notify-hud-corner {
        position: absolute;
        width: 20px;
        height: 20px;
        border-color: var(--notify-cyan);
        opacity: 0.55;
        pointer-events: none;
        z-index: 2;
        animation: notifyHudPulse 3.4s ease-in-out infinite;
    }
    .notify-hud-corner.tl { top: 10px; left: 10px; border-top: 2px solid; border-left: 2px solid; border-top-left-radius: 0.75rem; }
    .notify-hud-corner.tr { top: 10px; right: 10px; border-top: 2px solid; border-right: 2px solid; border-top-right-radius: 0.75rem; animation-delay: .5s; }
    .notify-hud-corner.bl { bottom: 10px; left: 10px; border-bottom: 2px solid; border-left: 2px solid; border-bottom-left-radius: 0.75rem; animation-delay: 1s; }
    .notify-hud-corner.br { bottom: 10px; right: 10px; border-bottom: 2px solid; border-right: 2px solid; border-bottom-right-radius: 0.75rem; animation-delay: 1.5s; }

    @keyframes notifyHudPulse {
        0%, 100% { opacity: 0.3; }
        50%      { opacity: 0.85; }
    }

    .notify-hero-inner { position: relative; z-index: 3; }

    .notify-hero h1 {
        font-family: var(--font-display);
        color: #fff !important;
        text-shadow: 0 2px 24px rgba(0, 0, 0, 0.3);
    }

    .notify-hero-lead { color: #cbd5e1 !important; }

    .notify-hero-tag {
        color: var(--notify-cyan) !important;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .notify-hero-tag .notify-live-cursor::after {
        content: '_';
        animation: notifyBlink 1s step-end infinite;
    }

    @keyframes notifyBlink { 50% { opacity: 0; } }

    .notify-glass {
        background: rgba(255, 255, 255, 0.10) !important;
        border: 1px solid rgba(0, 224, 255, 0.22) !important;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        transition: transform 0.35s var(--notify-ease), background 0.35s ease, box-shadow 0.35s ease;
        position: relative;
        overflow: hidden;
    }

    .notify-glass::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--notify-cyan), var(--notify-violet));
        opacity: 0.7;
    }

    .notify-glass:hover {
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.16) !important;
        box-shadow: 0 16px 36px rgba(0, 224, 255, 0.14);
    }

    .notify-glass .notify-stat-val {
        color: #fff !important;
        font-weight: 700;
        font-family: var(--font-mono);
    }
    .notify-glass .notify-stat-lbl { color: #a7e8ff !important; }

    .notify-row {
        transition: background 0.25s ease, transform 0.3s var(--notify-ease), border-left-color 0.3s ease;
        border-left: 3px solid transparent;
        position: relative;
    }

    .notify-row:hover {
        background: linear-gradient(90deg, rgba(0, 224, 255, 0.05), transparent 60%);
        transform: translateX(4px);
        border-left-color: var(--notify-cyan);
    }

    .notify-row-unread {
        background: linear-gradient(90deg, rgba(0, 58, 143, 0.045), transparent);
        border-left-color: #0ea5e9;
    }

    .notify-avatar { position: relative; transition: transform 0.35s var(--notify-ease); }

    .notify-avatar::before {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 0.9rem;
        background: conic-gradient(from 0deg, var(--notify-cyan), var(--notify-violet) 45%, transparent 60%, var(--notify-cyan));
        opacity: 0;
        filter: blur(4px);
        transition: opacity 0.3s ease;
        animation: notifySpin 4.5s linear infinite;
        z-index: -1;
    }

    @keyframes notifySpin { to { transform: rotate(360deg); } }

    .notify-row:hover .notify-avatar { transform: scale(1.06); }
    .notify-row:hover .notify-avatar::before { opacity: 0.75; }

    .notify-unread-dot { animation: notifyPulse 2s ease-in-out infinite; }

    @keyframes notifyPulse {
        0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.5); }
        50% { opacity: 0.85; box-shadow: 0 0 0 6px rgba(244, 63, 94, 0); }
    }

    .notify-cta {
        transition: transform 0.25s var(--notify-ease), box-shadow 0.25s ease, background 0.25s ease;
        font-family: var(--font-mono);
    }

    .notify-row:hover .notify-cta {
        transform: translateX(4px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.25);
    }

    .notify-back-link {
        color: #bae6fd !important;
        transition: color 0.2s ease, transform 0.25s var(--notify-ease);
    }

    .notify-back-link:hover { color: #fff !important; }

    .notify-live-badge {
        font-family: var(--font-mono);
        letter-spacing: 0.18em;
    }

    .notify-live-badge .chat-live-dot {
        animation: notifyLiveDot 1.8s ease-in-out infinite;
    }

    @keyframes notifyLiveDot {
        0%, 100% { box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.5); }
        50% { box-shadow: 0 0 0 5px rgba(14, 165, 233, 0); }
    }

    .notify-empty {
        background:
            radial-gradient(ellipse 60% 60% at 50% 0%, rgba(0, 224, 255, 0.06), transparent 60%),
            linear-gradient(145deg, #f8fafc, #eff6ff);
        position: relative;
        overflow: hidden;
    }

    .notify-radar {
        position: relative;
        width: 5rem;
        height: 5rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f1f5f9, #e0f2fe);
        color: #64748b;
        box-shadow: inset 0 0 0 1px rgba(0, 224, 255, 0.25);
    }

    .notify-radar::before {
        content: '';
        position: absolute;
        inset: -10px;
        border-radius: 1.2rem;
        border: 1px solid rgba(0, 224, 255, 0.3);
        animation: notifyRadarPing 2.6s ease-out infinite;
    }

    @keyframes notifyRadarPing {
        0%   { transform: scale(0.8); opacity: 0.8; }
        100% { transform: scale(1.4); opacity: 0; }
    }

    [data-page-animate] { opacity: 1; transform: none; filter: none; }

    html.page-animate-enabled [data-page-animate]:not(.is-visible) {
        opacity: 0;
        transform: translateY(20px);
        filter: blur(3px);
    }

    html.page-animate-enabled [data-page-animate].is-visible {
        animation: notifyFadeUp 0.8s var(--notify-ease) forwards;
    }

    .page-delay-1 { animation-delay: 80ms; }
    .page-delay-2 { animation-delay: 140ms; }
    .page-delay-3 { animation-delay: 200ms; }

    @keyframes notifyFadeUp {
        from { opacity: 0; transform: translateY(20px) scale(0.99); filter: blur(4px); }
        to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    @media (prefers-reduced-motion: reduce) {
        .notify-hero-shine,
        .notify-scan,
        .notify-hud-corner,
        .notify-unread-dot,
        .notify-avatar::before,
        .notify-live-badge .chat-live-dot,
        .notify-radar::before,
        [data-page-animate] {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
        }
        .notify-row:hover,
        .notify-glass:hover { transform: none; }
        #notifyNetCanvas { display: none; }
    }
</style>
@endpush

@section('content')
<div class="chat-shell py-6 md:py-10">
    <div class="mx-auto max-w-5xl space-y-6">
        {{-- Hero --}}
        <section
            class="notify-hero rounded-[2rem] px-5 py-6 shadow-xl sm:px-8 sm:py-8"
            style="background: linear-gradient(145deg, #061829 0%, #0a2540 45%, #003a8f 100%);"
        >
            <canvas id="notifyNetCanvas" aria-hidden="true"></canvas>
            <div class="notify-hero-shine" aria-hidden="true"></div>
            <div class="notify-scan" aria-hidden="true"></div>
            <div class="notify-hud-corner tl"></div>
            <div class="notify-hud-corner tr"></div>
            <div class="notify-hud-corner bl"></div>
            <div class="notify-hud-corner br"></div>

            <div class="notify-hero-inner flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <a href="{{ route('chats.index') }}" class="notify-back-link inline-flex items-center gap-2 text-sm font-medium mb-4 group">
                        <i class="fas fa-arrow-left text-xs transition-transform group-hover:-translate-x-1"></i>
                        Back to inbox
                    </a>

                    <p data-page-animate class="notify-hero-tag notify-mono text-xs font-semibold uppercase tracking-[0.35em]">
                        <i class="fas fa-bell"></i> <span class="notify-live-cursor">NOTIFICATIONS::FEED</span>
                    </p>
                    <h1 data-page-animate class="notify-display page-delay-1 mt-3 text-3xl font-black tracking-tight sm:text-4xl">
                        Your recent message alerts
                    </h1>
                    <p data-page-animate class="page-delay-2 notify-hero-lead mt-3 max-w-xl text-sm leading-6 sm:text-base">
                        Review the latest unread chat notifications and jump straight into the conversation.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:min-w-80">
                    <div data-page-animate class="page-delay-2 notify-glass rounded-2xl px-4 py-4">
                        <p class="notify-stat-lbl notify-mono text-xs uppercase tracking-[0.2em]">Unread items</p>
                        <p class="notify-stat-val mt-2 text-3xl tabular-nums" data-countup="{{ $totalUnread }}">{{ $totalUnread }}</p>
                    </div>
                    <div data-page-animate class="page-delay-3 notify-glass rounded-2xl px-4 py-4">
                        <p class="notify-stat-lbl notify-mono text-xs uppercase tracking-[0.2em]">Recent alerts</p>
                        <p class="notify-stat-val mt-2 text-3xl tabular-nums" data-countup="{{ count($recentMessages) }}">{{ count($recentMessages) }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Quick actions --}}
        <div data-page-animate class="page-delay-2 flex flex-wrap gap-3">
            <a href="{{ route('chats.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-sky-200 hover:text-sky-700 min-h-0">
                <i class="fas fa-comments text-sky-500"></i> All conversations
            </a>
            @if($totalUnread > 0)
                <span class="inline-flex items-center gap-2 rounded-full bg-rose-50 border border-rose-100 px-4 py-2.5 text-sm font-semibold text-rose-700">
                    <span class="notify-unread-dot h-2 w-2 rounded-full bg-rose-500"></span>
                    {{ $totalUnread }} unread across your threads
                </span>
            @else
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 border border-emerald-100 px-4 py-2.5 text-sm font-semibold text-emerald-700">
                    <i class="fas fa-check-circle"></i> All caught up
                </span>
            @endif
        </div>

        {{-- List --}}
        <section data-page-animate class="page-delay-3 chat-panel overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.08)]">
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="notify-display text-lg font-bold text-slate-900">Unread notifications</h2>
                        <p class="text-sm text-slate-500">Tap an alert to open the conversation and reply.</p>
                    </div>
                    @if(count($recentMessages))
                        <span class="notify-live-badge inline-flex items-center gap-2 self-start rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase text-slate-500">
                            <span class="chat-live-dot h-2 w-2 rounded-full bg-sky-500"></span>
                            Live updates
                        </span>
                    @endif
                </div>
            </div>

            @if (count($recentMessages))
                <div class="divide-y divide-slate-100">
                    @foreach ($recentMessages as $index => $message)
                        <a
                            href="{{ route('chats.show', $message['conversation_id']) }}"
                            class="notify-row notify-row-unread group block px-5 py-5 sm:px-6"
                            data-page-animate
                            style="animation-delay: {{ min($index * 70, 350) }}ms"
                        >
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div class="flex min-w-0 items-start gap-4">
                                    <div class="notify-avatar relative shrink-0">
                                        <div class="chat-avatar-lg bg-slate-900 text-white ring-2 ring-sky-100">
                                            {{ strtoupper(substr($message['sender'], 0, 1)) }}
                                        </div>
                                        <span class="notify-unread-dot absolute -top-0.5 -right-0.5 h-3 w-3 rounded-full bg-rose-500 ring-2 ring-white" aria-hidden="true"></span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-base font-bold text-slate-900 transition group-hover:text-sky-700 sm:text-lg">
                                                {{ $message['sender'] }}
                                            </h3>
                                            <span class="notify-mono inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">
                                                {{ $message['time'] }}
                                            </span>
                                        </div>

                                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 line-clamp-2">
                                            {{ $message['body'] }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex shrink-0 items-center sm:flex-col sm:items-end sm:pt-1">
                                    <span class="notify-cta inline-flex items-center gap-2 rounded-full bg-sky-100 px-4 py-2 text-xs font-bold uppercase tracking-[0.15em] text-sky-800">
                                        View chat
                                        <i class="fas fa-arrow-right text-[0.65rem] transition-transform group-hover:translate-x-1"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div data-page-animate class="notify-empty px-6 py-16 text-center">
                    <div class="notify-radar mx-auto">
                        <i class="fas fa-bell-slash text-3xl"></i>
                    </div>
                    <p class="notify-mono mt-5 text-xs uppercase tracking-[0.3em] text-sky-600/70">All clear</p>
                    <h2 class="notify-display mt-2 text-2xl font-black tracking-tight text-slate-900">No new notifications</h2>
                    <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-slate-500 sm:text-base">
                        You're all caught up. Check back later for new messages from your support team.
                    </p>
                    <a href="{{ route('chats.index') }}" class="chat-send-btn mt-8 inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold text-white shadow-lg min-h-0" style="background: linear-gradient(135deg, #003a8f, #0a2540);">
                        <i class="fas fa-inbox text-xs"></i>
                        Open inbox
                    </a>
                </div>
            @endif
        </section>
    </div>
</div>

@include('partials.page-animate')
@endsection

@push('scripts')
<script>
(function () {
  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!prefersReducedMotion) {
    document.querySelectorAll('[data-countup]').forEach(function (el) {
      var target = parseInt(el.getAttribute('data-countup'), 10) || 0;
      var start = 0;
      var duration = 750;
      var startTime = null;
      function step(ts) {
        if (!startTime) startTime = ts;
        var p = Math.min((ts - startTime) / duration, 1);
        el.textContent = Math.round(start + (target - start) * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    });

    requestAnimationFrame(function () {
      document.querySelectorAll('.notify-hero [data-page-animate]').forEach(function (el, i) {
        setTimeout(function () { el.classList.add('is-visible'); }, 60 + i * 70);
      });
    });
  } else {
    document.querySelectorAll('[data-countup]').forEach(function (el) {
      el.textContent = el.getAttribute('data-countup');
    });
  }

  initNotifyNetwork();

  function initNotifyNetwork() {
    var canvas = document.getElementById('notifyNetCanvas');
    if (!canvas) return;
    var hero = canvas.closest('.notify-hero');
    var ctx = canvas.getContext('2d');
    var width, height, nodes;
    var LINK_DIST = 120;

    function resize() {
      width = canvas.width = hero.offsetWidth;
      height = canvas.height = hero.offsetHeight;
      var count = Math.min(34, Math.floor((width * height) / 14000));
      nodes = Array.from({ length: count }, function () {
        return {
          x: Math.random() * width,
          y: Math.random() * height,
          vx: (Math.random() - 0.5) * 0.22,
          vy: (Math.random() - 0.5) * 0.22
        };
      });
    }

    function draw() {
      ctx.clearRect(0, 0, width, height);
      for (var i = 0; i < nodes.length; i++) {
        var n = nodes[i];
        n.x += n.vx;
        n.y += n.vy;
        if (n.x < 0 || n.x > width) n.vx *= -1;
        if (n.y < 0 || n.y > height) n.vy *= -1;
      }
      for (var a = 0; a < nodes.length; a++) {
        for (var b = a + 1; b < nodes.length; b++) {
          var dx = nodes[a].x - nodes[b].x, dy = nodes[a].y - nodes[b].y;
          var dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < LINK_DIST) {
            ctx.strokeStyle = 'rgba(0, 224, 255, ' + (0.16 * (1 - dist / LINK_DIST)) + ')';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(nodes[a].x, nodes[a].y);
            ctx.lineTo(nodes[b].x, nodes[b].y);
            ctx.stroke();
          }
        }
      }
      for (var j = 0; j < nodes.length; j++) {
        ctx.fillStyle = 'rgba(139, 123, 255, 0.6)';
        ctx.beginPath();
        ctx.arc(nodes[j].x, nodes[j].y, 1.5, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    resize();
    window.addEventListener('resize', resize);

    if (prefersReducedMotion) {
      draw();
      return;
    }

    (function loop() {
      draw();
      requestAnimationFrame(loop);
    })();
  }
})();
</script>
@endpush