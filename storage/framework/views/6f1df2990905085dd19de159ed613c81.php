

<?php $__env->startSection('title', 'Contact Us - SkillUp Support'); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* ===================================================================
       SKILLUP // CONTACT — FUTURISTIC TRANSMISSION THEME
       Tokens
    =================================================================== */
    .su-contact {
        --c-void: #05060d;
        --c-surface: #0b0e1a;
        --c-surface-2: #10152a;
        --c-glass: rgba(255,255,255,0.045);
        --c-glass-border: rgba(255,255,255,0.09);
        --c-primary: #7c5cff;      /* electric violet */
        --c-secondary: #00e5ff;    /* signal cyan */
        --c-accent: #ff3d9a;       /* transmission pink */
        --c-text: #e9edfb;
        --c-muted: #8b93ad;
        --c-muted-2: #5c6382;
        --font-display: 'Orbitron', 'Space Grotesk', sans-serif;
        --font-body: 'Inter', -apple-system, sans-serif;
        --font-mono: 'JetBrains Mono', 'Courier New', monospace;
        color: var(--c-text);
        background: var(--c-void);
        font-family: var(--font-body);
        position: relative;
        overflow-x: clip;
    }

    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    .su-contact * { box-sizing: border-box; }

    .su-eyebrow {
        font-family: var(--font-mono);
        font-size: 0.7rem;
        letter-spacing: 0.35em;
        text-transform: uppercase;
        color: var(--c-secondary);
        display: inline-flex;
        align-items: center;
        gap: 0.6em;
    }
    .su-eyebrow::before {
        content: '';
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--c-secondary);
        box-shadow: 0 0 10px 2px var(--c-secondary);
        animation: su-blink 1.8s ease-in-out infinite;
    }
    @keyframes su-blink { 0%,100% { opacity: 1; } 50% { opacity: 0.25; } }

    .su-heading {
        font-family: var(--font-display);
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .su-gradient-text {
        background: linear-gradient(100deg, #ffffff 0%, var(--c-secondary) 45%, var(--c-primary) 75%, var(--c-accent) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* ---------- section shells ---------- */
    .su-section { position: relative; padding: 6rem 1.5rem; }
    .su-section-alt { background: linear-gradient(180deg, var(--c-surface) 0%, var(--c-void) 100%); }
    .su-wrap { max-width: 72rem; margin: 0 auto; position: relative; z-index: 2; }
    .su-wrap-narrow { max-width: 40rem; margin: 0 auto; position: relative; z-index: 2; }

    /* ---------- reveal on scroll ---------- */
    .su-reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.8s ease, transform 0.8s cubic-bezier(.16,1,.3,1); }
    .su-reveal.is-visible { opacity: 1; transform: translateY(0); }
    .su-reveal-delay-1 { transition-delay: 0.1s; }
    .su-reveal-delay-2 { transition-delay: 0.2s; }
    .su-reveal-delay-3 { transition-delay: 0.3s; }

    /* ===================================================================
       HERO — grid horizon + drifting nodes
    =================================================================== */
    .su-hero {
        position: relative;
        min-height: 78vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 8rem 1.5rem 6rem;
        background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(124,92,255,0.22), transparent 70%), var(--c-void);
        overflow: hidden;
        isolation: isolate;
    }
    .su-hero-grid {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(0,229,255,0.09) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0,229,255,0.09) 1px, transparent 1px);
        background-size: 56px 56px;
        -webkit-mask-image: linear-gradient(180deg, rgba(0,0,0,0.9) 0%, transparent 78%);
        mask-image: linear-gradient(180deg, rgba(0,0,0,0.9) 0%, transparent 78%);
        transform: perspective(600px) rotateX(58deg) scale(1.6);
        transform-origin: center top;
        animation: su-grid-drift 14s linear infinite;
        z-index: 0;
    }
    @keyframes su-grid-drift { from { background-position: 0 0, 0 0; } to { background-position: 0 56px, 56px 0; } }

    .su-hero-node {
        position: absolute;
        width: 5px; height: 5px;
        border-radius: 50%;
        background: var(--c-secondary);
        box-shadow: 0 0 12px 3px rgba(0,229,255,0.7);
        animation: su-float 8s ease-in-out infinite;
        z-index: 1;
    }
    @keyframes su-float { 0%,100% { transform: translateY(0) translateX(0); opacity: 0.7; } 50% { transform: translateY(-24px) translateX(10px); opacity: 1; } }

    .su-hero-content { position: relative; z-index: 3; max-width: 50rem; }
    .su-hero-title {
        font-size: clamp(2.4rem, 6vw, 4.2rem);
        line-height: 1.05;
        margin: 1.5rem 0 1.25rem;
    }
    .su-hero-sub {
        font-size: clamp(1rem, 2vw, 1.15rem);
        color: var(--c-muted);
        max-width: 38rem;
        margin: 0 auto;
        line-height: 1.7;
    }
    .su-scroll-cue {
        margin-top: 3.5rem;
        display: inline-flex; flex-direction: column; align-items: center; gap: 0.5rem;
        font-family: var(--font-mono); font-size: 0.65rem; letter-spacing: 0.3em;
        color: var(--c-muted-2); text-transform: uppercase;
    }
    .su-scroll-cue span { width: 1px; height: 28px; background: linear-gradient(var(--c-secondary), transparent); animation: su-cue 1.6s ease-in-out infinite; }
    @keyframes su-cue { 0% { transform: scaleY(0.3); opacity: 0.3; } 50% { transform: scaleY(1); opacity: 1; } 100% { transform: scaleY(0.3); opacity: 0.3; } }

    /* ===================================================================
       SIGNATURE ELEMENT — transmission network (quick contact methods)
    =================================================================== */
    .su-network {
        position: relative;
        padding-top: 2rem;
    }
    .su-network-svg {
        position: absolute;
        top: -1.5rem; left: 0;
        width: 100%; height: 100%;
        z-index: 0;
        pointer-events: none;
        overflow: visible;
    }
    .su-network-path {
        fill: none;
        stroke: url(#su-line-gradient);
        stroke-width: 1.4;
        stroke-dasharray: 6 8;
        opacity: 0.5;
    }
    .su-network-pulse {
        fill: var(--c-secondary);
        filter: drop-shadow(0 0 6px var(--c-secondary));
        offset-rotate: 0deg;
    }

    .su-node-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem; position: relative; z-index: 2; }

    .su-card {
        position: relative;
        background: var(--c-glass);
        border: 1px solid var(--c-glass-border);
        border-radius: 18px;
        padding: 2.5rem 2rem;
        text-align: center;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        transition: transform 0.4s cubic-bezier(.16,1,.3,1), border-color 0.4s ease, box-shadow 0.4s ease;
        overflow: hidden;
    }
    .su-card::before {
        content: '';
        position: absolute; inset: -1px;
        border-radius: 18px;
        padding: 1px;
        background: conic-gradient(from var(--angle,0deg), transparent 0%, var(--c-secondary) 15%, transparent 30%);
        -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .su-card:hover { transform: translateY(-6px); border-color: rgba(0,229,255,0.35); box-shadow: 0 20px 50px -20px rgba(0,229,255,0.25); }
    .su-card:hover::before { opacity: 1; animation: su-rotate 2.4s linear infinite; }
    @keyframes su-rotate { to { --angle: 360deg; } }
    @property --angle { syntax: '<angle>'; inherits: false; initial-value: 0deg; }

    .su-icon-orb {
        width: 64px; height: 64px;
        margin: 0 auto 1.4rem;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        background: radial-gradient(circle at 35% 30%, rgba(255,255,255,0.15), transparent 60%), var(--c-surface-2);
        border: 1px solid var(--c-glass-border);
        position: relative;
        color: var(--c-secondary);
    }
    .su-icon-orb::after {
        content: '';
        position: absolute; inset: -6px;
        border-radius: 50%;
        border: 1px solid rgba(0,229,255,0.25);
        animation: su-pulse-ring 2.6s ease-out infinite;
    }
    @keyframes su-pulse-ring { 0% { transform: scale(0.85); opacity: 0.8; } 100% { transform: scale(1.5); opacity: 0; } }

    .su-card h3 { font-family: var(--font-display); font-size: 1.1rem; margin-bottom: 0.6rem; color: var(--c-text); }
    .su-card p.su-desc { color: var(--c-muted); font-size: 0.92rem; margin-bottom: 1rem; }
    .su-card a.su-link, .su-card button.su-link {
        font-family: var(--font-mono);
        color: var(--c-secondary);
        font-weight: 500;
        font-size: 0.95rem;
        background: none; border: none; cursor: pointer;
        position: relative;
        padding-bottom: 2px;
    }
    .su-card a.su-link::after, .su-card button.su-link::after {
        content: ''; position: absolute; left: 0; bottom: -2px; width: 0; height: 1px;
        background: var(--c-secondary); transition: width 0.3s ease;
    }
    .su-card a.su-link:hover::after, .su-card button.su-link:hover::after { width: 100%; }
    .su-card .su-meta { font-family: var(--font-mono); font-size: 0.72rem; color: var(--c-muted-2); margin-top: 0.9rem; letter-spacing: 0.03em; }

    /* ===================================================================
       FORM
    =================================================================== */
    .su-form-panel {
        background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
        border: 1px solid var(--c-glass-border);
        border-radius: 22px;
        padding: 2.75rem;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 30px 80px -40px rgba(124,92,255,0.35);
    }
    .su-field { margin-bottom: 1.6rem; }
    .su-field label {
        display: block; font-family: var(--font-mono); font-size: 0.72rem;
        letter-spacing: 0.12em; text-transform: uppercase; color: var(--c-muted);
        margin-bottom: 0.6rem;
    }
    .su-field label .req { color: var(--c-accent); }
    .su-input, .su-select, .su-textarea {
        width: 100%;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--c-glass-border);
        border-radius: 10px;
        padding: 0.8rem 1rem;
        color: var(--c-text);
        font-family: var(--font-body);
        font-size: 0.95rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .su-input::placeholder, .su-textarea::placeholder { color: var(--c-muted-2); }
    .su-input:focus, .su-select:focus, .su-textarea:focus {
        outline: none;
        border-color: var(--c-secondary);
        box-shadow: 0 0 0 3px rgba(0,229,255,0.15);
        background: rgba(0,229,255,0.03);
    }
    .su-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%238b93ad'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.9rem center; }
    .su-select option { background: var(--c-surface); color: var(--c-text); }
    .su-checkbox-row { display: flex; align-items: center; gap: 0.7rem; }
    .su-checkbox-row input { width: 16px; height: 16px; accent-color: var(--c-secondary); }
    .su-checkbox-row span { font-size: 0.88rem; color: var(--c-muted); }

    .su-submit {
        width: 100%;
        position: relative;
        background: linear-gradient(100deg, var(--c-primary), var(--c-secondary));
        color: #05060d;
        font-family: var(--font-display);
        font-weight: 700;
        letter-spacing: 0.03em;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 16px 40px -18px rgba(0,229,255,0.55);
    }
    .su-submit:hover { transform: translateY(-2px); box-shadow: 0 20px 50px -16px rgba(0,229,255,0.7); }
    .su-submit::before {
        content: '';
        position: absolute; top: 0; left: -60%;
        width: 40%; height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.55), transparent);
        transform: skewX(-20deg);
        animation: su-sheen 3.2s ease-in-out infinite;
    }
    @keyframes su-sheen { 0% { left: -60%; } 60%,100% { left: 130%; } }

    /* ===================================================================
       LOCATIONS
    =================================================================== */
    .su-loc-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.75rem; }
    .su-loc-card {
        background: var(--c-glass);
        border: 1px solid var(--c-glass-border);
        border-radius: 16px;
        padding: 2rem;
        transition: border-color 0.3s ease, transform 0.3s ease;
    }
    .su-loc-card:hover { transform: translateY(-4px); border-color: rgba(255,61,154,0.35); }
    .su-loc-card h3 { font-family: var(--font-display); font-size: 1.05rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.6rem; }
    .su-loc-card .su-pin { color: var(--c-accent); }
    .su-loc-card p { color: var(--c-muted); font-size: 0.9rem; margin-bottom: 0.35rem; }
    .su-loc-card .su-coord { font-family: var(--font-mono); font-size: 0.72rem; color: var(--c-muted-2); margin-top: 0.9rem; letter-spacing: 0.04em; }
    .su-loc-card .su-mail { font-family: var(--font-mono); font-size: 0.82rem; color: var(--c-secondary); margin-top: 0.6rem; display: inline-block; }

    /* ===================================================================
       FAQ
    =================================================================== */
    .su-faq { border: 1px solid var(--c-glass-border); background: var(--c-glass); border-radius: 14px; padding: 1.4rem 1.6rem; cursor: pointer; transition: border-color 0.3s ease; }
    .su-faq[open] { border-color: rgba(0,229,255,0.4); }
    .su-faq summary { list-style: none; font-family: var(--font-body); font-weight: 600; font-size: 1.02rem; display: flex; justify-content: space-between; align-items: center; }
    .su-faq summary::-webkit-details-marker { display: none; }
    .su-faq .su-chev { transition: transform 0.35s cubic-bezier(.16,1,.3,1); color: var(--c-secondary); flex-shrink: 0; margin-left: 1rem; }
    .su-faq[open] .su-chev { transform: rotate(180deg); }
    .su-faq p { color: var(--c-muted); margin-top: 0.9rem; line-height: 1.7; font-size: 0.94rem; }

    /* ===================================================================
       RESPONSE TIMES
    =================================================================== */
    .su-response-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.75rem; }
    .su-response-card { background: var(--c-glass); border: 1px solid var(--c-glass-border); border-left: 3px solid var(--c-line, var(--c-secondary)); border-radius: 14px; padding: 2rem; }
    .su-response-card h3 { font-family: var(--font-display); font-size: 1.05rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
    .su-response-card p.su-desc { color: var(--c-muted); font-size: 0.9rem; margin-bottom: 1.2rem; }
    .su-response-time { font-family: var(--font-display); font-size: 2rem; color: var(--c-secondary); }
    .su-response-bar { height: 4px; border-radius: 2px; background: rgba(255,255,255,0.08); margin-top: 1rem; overflow: hidden; }
    .su-response-bar span { display: block; height: 100%; background: linear-gradient(90deg, var(--c-primary), var(--c-secondary)); animation: su-fill 1.4s cubic-bezier(.16,1,.3,1) forwards; }
    @keyframes su-fill { from { width: 0%; } }

    /* ===================================================================
       CTA
    =================================================================== */
    .su-cta {
        position: relative;
        text-align: center;
        padding: 5rem 1.5rem;
        background: radial-gradient(ellipse 70% 100% at 50% 100%, rgba(255,61,154,0.18), transparent 70%), var(--c-void);
        border-top: 1px solid var(--c-glass-border);
    }
    .su-cta-btn {
        display: inline-flex; align-items: center; gap: 0.6rem;
        font-family: var(--font-display); font-weight: 700; letter-spacing: 0.02em;
        padding: 0.9rem 2.1rem; border-radius: 999px; text-decoration: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .su-cta-primary { background: linear-gradient(100deg, var(--c-primary), var(--c-accent)); color: #05060d; box-shadow: 0 16px 40px -16px rgba(255,61,154,0.5); }
    .su-cta-primary:hover { transform: translateY(-3px); box-shadow: 0 22px 50px -14px rgba(255,61,154,0.65); }
    .su-cta-ghost { border: 1px solid var(--c-glass-border); color: var(--c-text); }
    .su-cta-ghost:hover { border-color: var(--c-secondary); color: var(--c-secondary); }

    @media (prefers-reduced-motion: reduce) {
        .su-contact *, .su-contact *::before, .su-contact *::after {
            animation-duration: 0.001ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.001ms !important;
        }
    }
</style>

<div class="su-contact">

    
    <section class="su-hero">
        <div class="su-hero-grid"></div>
        <div class="su-hero-node" style="top:18%; left:12%; animation-delay:0s;"></div>
        <div class="su-hero-node" style="top:28%; left:82%; animation-delay:1.5s;"></div>
        <div class="su-hero-node" style="top:60%; left:20%; animation-delay:3s;"></div>
        <div class="su-hero-node" style="top:55%; left:75%; animation-delay:2s;"></div>
        <div class="su-hero-node" style="top:75%; left:48%; animation-delay:4s;"></div>

        <div class="su-hero-content">
            <span class="su-eyebrow">Channel Open // Support Online</span>
            <h1 class="su-hero-title su-heading">
                Let's Stay <span class="su-gradient-text">Connected</span>
            </h1>
            <p class="su-hero-sub">
                Questions about SkillUp route straight to a human. Whichever channel you pick,
                our team is listening and ready to help you keep moving.
            </p>
            <div class="su-scroll-cue"><span></span>Scroll</div>
        </div>
    </section>

    
    <section class="su-section">
        <div class="su-wrap">
            <div class="su-network">
                <svg class="su-network-svg" viewBox="0 0 1000 260" preserveAspectRatio="none" aria-hidden="true">
                    <defs>
                        <linearGradient id="su-line-gradient" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#7c5cff"/>
                            <stop offset="50%" stop-color="#00e5ff"/>
                            <stop offset="100%" stop-color="#ff3d9a"/>
                        </linearGradient>
                    </defs>
                    <path id="su-path-1" class="su-network-path" d="M 165 60 C 330 -40, 500 260, 500 130"/>
                    <path id="su-path-2" class="su-network-path" d="M 835 60 C 670 -40, 500 260, 500 130"/>
                    <circle class="su-network-pulse" r="3.2">
                        <animateMotion dur="4.5s" repeatCount="indefinite" rotate="auto">
                            <mpath href="#su-path-1"/>
                        </animateMotion>
                    </circle>
                    <circle class="su-network-pulse" r="3.2">
                        <animateMotion dur="4.5s" begin="1.5s" repeatCount="indefinite" rotate="auto">
                            <mpath href="#su-path-2"/>
                        </animateMotion>
                    </circle>
                </svg>

                <div class="su-node-grid">
                    <div class="su-card su-reveal">
                        <div class="su-icon-orb"><i class="fas fa-envelope"></i></div>
                        <h3>Email Support</h3>
                        <p class="su-desc">Send a message, get a real reply</p>
                        <a href="mailto:support@skillup.com" class="su-link">support@skillup.com</a>
                        <p class="su-meta">AVG. REPLY: 24H</p>
                    </div>

                    <div class="su-card su-reveal su-reveal-delay-1">
                        <div class="su-icon-orb"><i class="fas fa-phone"></i></div>
                        <h3>Phone Support</h3>
                        <p class="su-desc">Talk it through, live</p>
                        <a href="tel:+1234567890" class="su-link">+1 (234) 567-890</a>
                        <p class="su-meta">MON–FRI · 9AM–6PM EST</p>
                    </div>

                    <div class="su-card su-reveal su-reveal-delay-2">
                        <div class="su-icon-orb"><i class="fas fa-comment-dots"></i></div>
                        <h3>Live Chat</h3>
                        <p class="su-desc">Instant answers, no queue</p>
                        <button type="button" class="su-link">Open Chat</button>
                        <p class="su-meta">ONLINE 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="su-section su-section-alt">
        <div class="su-wrap-narrow">
            <div class="text-center mb-12 su-reveal">
                <span class="su-eyebrow">Direct Line</span>
                <h2 class="su-heading" style="font-size: clamp(1.7rem, 4vw, 2.4rem); margin-top: 1rem; margin-bottom: 0.75rem;">Send Us a Message</h2>
                <p style="color: var(--c-muted);">Fill in the details below — we'll get back to you as soon as possible.</p>
            </div>

            <form class="su-form-panel su-reveal su-reveal-delay-1" method="POST" action="#">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6">
                    <div class="su-field">
                        <label for="name">Full Name <span class="req">*</span></label>
                        <input type="text" id="name" name="name" required class="su-input" placeholder="Your full name">
                    </div>
                    <div class="su-field">
                        <label for="email">Email Address <span class="req">*</span></label>
                        <input type="email" id="email" name="email" required class="su-input" placeholder="your@email.com">
                    </div>
                </div>

                <div class="su-field">
                    <label for="subject">Subject <span class="req">*</span></label>
                    <select id="subject" name="subject" required class="su-select">
                        <option value="">Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="support">Technical Support</option>
                        <option value="courses">Course Questions</option>
                        <option value="mentorship">Mentorship Program</option>
                        <option value="partnership">Partnership Opportunities</option>
                        <option value="bug">Report a Bug</option>
                        <option value="feedback">Feedback & Suggestions</option>
                    </select>
                </div>

                <div class="su-field">
                    <label for="message">Message <span class="req">*</span></label>
                    <textarea id="message" name="message" rows="6" required class="su-textarea" placeholder="Tell us more about your inquiry..."></textarea>
                </div>

                <div class="su-field">
                    <label for="phone">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" class="su-input" placeholder="+63 951 340 1097">
                </div>

                <div class="su-field su-checkbox-row">
                    <input type="checkbox" id="subscribe" name="subscribe">
                    <label for="subscribe" style="margin:0; text-transform:none; letter-spacing:normal; font-family:var(--font-body); font-size:0.88rem; color:var(--c-muted);">Subscribe to our newsletter for updates and tips</label>
                </div>

                <button type="submit" class="su-submit">
                    Send Message <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </form>
        </div>
    </section>

    
    <section class="su-section">
        <div class="su-wrap">
            <div class="text-center mb-12 su-reveal">
                <span class="su-eyebrow">Ground Stations</span>
                <h2 class="su-heading" style="font-size: clamp(1.7rem, 4vw, 2.4rem); margin-top: 1rem;">Our Locations</h2>
            </div>

            <div class="su-loc-grid">
                <div class="su-loc-card su-reveal">
                    <h3><i class="fas fa-map-marker-alt su-pin"></i> Aparri, Cagayan</h3>
                    <p>#33 Mendoza St.</p>
                    <p>Macanaya, Aparri, Cagayan</p>
                    <p>Philippines</p>
                    <a href="mailto:info@skillup.com" class="su-mail">info@skillup.com</a>
                    <p class="su-coord">18.3623° N, 121.6417° E</p>
                </div>

                <div class="su-loc-card su-reveal su-reveal-delay-1">
                    <h3><i class="fas fa-map-marker-alt su-pin"></i> London</h3>
                    <p>456 Innovation Avenue</p>
                    <p>London, E1 6AN</p>
                    <p>United Kingdom</p>
                    <a href="mailto:uk@skillup.com" class="su-mail">uk@skillup.com</a>
                    <p class="su-coord">51.5074° N, 0.1278° W</p>
                </div>

                <div class="su-loc-card su-reveal su-reveal-delay-2">
                    <h3><i class="fas fa-map-marker-alt su-pin"></i> Singapore</h3>
                    <p>789 Future Hub</p>
                    <p>Singapore, 068814</p>
                    <p>Singapore</p>
                    <a href="mailto:asia@skillup.com" class="su-mail">asia@skillup.com</a>
                    <p class="su-coord">1.3521° N, 103.8198° E</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="su-section su-section-alt">
        <div class="su-wrap-narrow">
            <div class="text-center mb-12 su-reveal">
                <span class="su-eyebrow">Read First</span>
                <h2 class="su-heading" style="font-size: clamp(1.7rem, 4vw, 2.4rem); margin-top: 1rem;">Before You Contact Us</h2>
            </div>

            <div class="space-y-4">
                <details class="su-faq su-reveal">
                    <summary><span>How do I reset my password?</span><i class="fas fa-chevron-down su-chev"></i></summary>
                    <p>Click the "Forgot Password" link on the login page, enter your email, and follow the instructions sent to your inbox. You'll be able to set a new password within 15 minutes.</p>
                </details>

                <details class="su-faq su-reveal">
                    <summary><span>Can I get a refund?</span><i class="fas fa-chevron-down su-chev"></i></summary>
                    <p>Since SkillUp offers free access to all learning paths, there are no refunds to process. However, if you've been charged incorrectly, please contact our billing support team immediately.</p>
                </details>

                <details class="su-faq su-reveal">
                    <summary><span>How do I contact my mentor?</span><i class="fas fa-chevron-down su-chev"></i></summary>
                    <p>Once you're enrolled in the mentorship program, you can message your mentor directly through the Messages section in your dashboard. Most mentors respond within 48 hours.</p>
                </details>

                <details class="su-faq su-reveal">
                    <summary><span>How can I become a mentor?</span><i class="fas fa-chevron-down su-chev"></i></summary>
                    <p>We'd love to have you! Fill out our mentor application form through your profile settings. We look for professionals with at least 3 years of industry experience and a passion for helping others.</p>
                </details>

                <details class="su-faq su-reveal">
                    <summary><span>Is my data secure on SkillUp?</span><i class="fas fa-chevron-down su-chev"></i></summary>
                    <p>Yes! We use industry-standard encryption, regular security audits, and comply with GDPR and CCPA regulations. Your data is never shared with third parties without your consent.</p>
                </details>
            </div>
        </div>
    </section>

    
    <section class="su-section">
        <div class="su-wrap">
            <div class="text-center mb-12 su-reveal">
                <span class="su-eyebrow">Service Level</span>
                <h2 class="su-heading" style="font-size: clamp(1.7rem, 4vw, 2.4rem); margin-top: 1rem;">Response Times</h2>
            </div>

            <div class="su-response-grid">
                <div class="su-response-card su-reveal" style="--c-line: var(--c-accent);">
                    <h3><i class="fas fa-bolt" style="color:#ffcf4d;"></i> Urgent Issues</h3>
                    <p class="su-desc">Account access, security concerns, or system errors</p>
                    <div class="su-response-time">2–4 hrs</div>
                    <div class="su-response-bar"><span style="width: 90%;"></span></div>
                </div>

                <div class="su-response-card su-reveal su-reveal-delay-1" style="--c-line: var(--c-secondary);">
                    <h3><i class="fas fa-envelope" style="color: var(--c-secondary);"></i> General Inquiries</h3>
                    <p class="su-desc">Course questions, feature requests, feedback</p>
                    <div class="su-response-time">24 hrs</div>
                    <div class="su-response-bar"><span style="width: 55%;"></span></div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="su-cta">
        <div class="su-wrap-narrow su-reveal">
            <span class="su-eyebrow">Ready When You Are</span>
            <h2 class="su-heading" style="font-size: clamp(1.8rem, 4.5vw, 2.6rem); margin: 1.25rem 0 0.75rem;">Ready to Get Started?</h2>
            <p style="color: var(--c-muted); margin-bottom: 2.25rem;">Join our community and transform your career with SkillUp.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="/courses" class="su-cta-btn su-cta-primary">Explore Courses <i class="fas fa-arrow-right"></i></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <a href="/register" class="su-cta-btn su-cta-primary">Sign Up Now <i class="fas fa-arrow-right"></i></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="/" class="su-cta-btn su-cta-ghost">Back to Home</a>
            </div>
        </div>
    </section>

</div>

<script>
    (function () {
        var els = document.querySelectorAll('.su-reveal');
        if (!('IntersectionObserver' in window) || !els.length) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });
        els.forEach(function (el) { io.observe(el); });
    })();
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Userpage\contact.blade.php ENDPATH**/ ?>