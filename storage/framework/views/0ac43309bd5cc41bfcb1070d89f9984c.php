

<?php $__env->startSection('title', 'Courses - SkillUp Learning Platform'); ?>
<?php $__env->startSection('content'); ?>

<?php
    $enrolledCourses = $enrolledCourses ?? collect();
    $course = $selectedCourse ?? $enrolledCourses->first();
    $enrollment = $enrollment ?? null;
    $modules = $course?->modules ?? collect();
    $subjects = $course?->subjects ?? collect();
    $publishedLessons = $modules->flatMap(fn ($module) => $module->lessons);
    $publishedQuizzes = $modules->flatMap(fn ($module) => $module->quizzes);
    $totalMinutes = $publishedLessons->sum('duration_minutes');
    $totalHours = $totalMinutes > 0 ? round($totalMinutes / 60, 1) : null;

    // Topic chips — drawn from the subjects already loaded for this course.
    $topics = $subjects->pluck('title')->filter()->unique()->take(5)->values();

    // Continue/Start CTA — points at the first lesson of the first module
    // that actually has one, mirroring the same guard used for lesson links below.
    $ctaModule = $modules->first(fn ($m) => $m->lessons->isNotEmpty());
    $ctaLesson = $ctaModule?->lessons->first();
    $ctaAvailable = $ctaLesson && $course?->slug && $ctaModule?->slug && $ctaLesson->slug;
?>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&family=Source+Serif+4:opsz,wght@8..60,400;8..60,500;8..60,600;8..60,700&display=swap" rel="stylesheet">

<style>
/* =====================================================================
   TOKENS — Navy Blue system (dashboard chrome) + Parchment system (book)
   The chrome around the book stays the console aesthetic already in
   place. The book itself is the one bold, memorable element on this
   page, so it gets its own quieter, warmer material: paper, not glass.
   ===================================================================== */
:root {
    --bg:          #EEF2FA;
    --bg-alt:      #E3E9F6;
    --surface:     rgba(255,255,255,0.88);
    --surface-solid: #FFFFFF;
    --border:      rgba(20,38,94,0.14);
    --border-glow: rgba(37,99,235,0.45);
    --grid-line:   rgba(20,50,120,0.07);
    --text:        #0B1633;
    --text-muted:  #47536E;
    --text-dim:    #8792AC;

    --navy:        #14265E;
    --navy-bright: #2451D9;
    --navy-deep:   #0A1633;
    --navy-tint:   rgba(37,99,235,0.10);
    --navy-wash:       rgba(37,99,235,0.05);
    --navy-wash-hover: rgba(37,99,235,0.10);
    --navy-soft-bg:    rgba(37,99,235,0.10);
    --navy-soft-border:rgba(37,99,235,0.24);

    --gold:        #B8860B;
    --gold-bright: #C99A2E;
    --gold-tint:   rgba(184,134,11,0.10);
    --gold-wash:       rgba(184,134,11,0.06);
    --gold-wash-hover: rgba(184,134,11,0.12);
    --gold-soft-bg:    rgba(184,134,11,0.10);
    --gold-soft-border:rgba(184,134,11,0.24);

    --emerald:     #059669;
    --emerald-tint:rgba(5,150,105,0.10);
    --amber:       #B45309;
    --amber-tint:  rgba(180,83,9,0.10);
    --crimson:     #A13A3A;
    --crimson-tint:rgba(161,58,58,0.10);

    --shadow-card:  0 1px 2px rgba(11,22,51,0.05), 0 14px 30px -14px rgba(11,22,51,0.18);
    --glow-navy:    0 0 0 1px rgba(37,99,235,0.32), 0 0 32px -10px rgba(37,99,235,0.5);
    --glow-gold:    0 0 0 1px rgba(184,134,11,0.28), 0 0 32px -10px rgba(184,134,11,0.45);

    /* Paper: warm, slightly uneven, never pure white */
    --paper:        #FBF6EC;
    --paper-shadow: #EFE6D2;
    --paper-ink:    #241C10;
    --paper-ink-soft: #5B4F3B;
    --paper-rule:   rgba(90,70,30,0.16);
    --paper-cover:  #1B2A52;
    --paper-cover-ink: #EFE2C0;

    --font-display: 'Space Grotesk', 'Inter', sans-serif;
    --font-body:    'Inter', system-ui, sans-serif;
    --font-mono:    'JetBrains Mono', monospace;
    --font-serif:   'Source Serif 4', Georgia, 'Times New Roman', serif;

    --ease: cubic-bezier(.22, 1, .36, 1);
}

html.dark-mode {
    --bg:          #050912;
    --bg-alt:      #0A1224;
    --surface:     rgba(9,16,34,0.72);
    --surface-solid: #0B1428;
    --border:      rgba(120,150,230,0.16);
    --border-glow: rgba(109,155,255,0.5);
    --grid-line:   rgba(90,140,255,0.08);
    --text:        #E8EDFB;
    --text-muted:  #93A0C4;
    --text-dim:    #57628A;

    --navy:        #3B6FE0;
    --navy-bright: #6D9BFF;
    --navy-deep:   #050B18;
    --navy-tint:   rgba(109,155,255,0.14);
    --navy-wash:       rgba(109,155,255,0.07);
    --navy-wash-hover: rgba(109,155,255,0.13);
    --navy-soft-bg:    rgba(109,155,255,0.14);
    --navy-soft-border:rgba(109,155,255,0.3);

    --gold:        #E0B84A;
    --gold-bright: #F0CC66;
    --gold-tint:   rgba(224,184,74,0.16);
    --gold-wash:       rgba(224,184,74,0.08);
    --gold-wash-hover: rgba(224,184,74,0.15);
    --gold-soft-bg:    rgba(224,184,74,0.16);
    --gold-soft-border:rgba(224,184,74,0.32);

    --emerald:     #34D399;
    --emerald-tint:rgba(52,211,153,0.14);
    --amber:       #FBBF24;
    --amber-tint:  rgba(251,191,36,0.14);
    --crimson:     #E07A7A;
    --crimson-tint:rgba(224,122,122,0.14);

    --shadow-card:  0 1px 0 rgba(0,0,0,0.4), 0 18px 38px -14px rgba(0,0,0,0.75);
    --glow-navy:    0 0 0 1px rgba(109,155,255,0.4), 0 0 42px -8px rgba(109,155,255,0.6);
    --glow-gold:    0 0 0 1px rgba(224,184,74,0.38), 0 0 42px -8px rgba(224,184,74,0.55);

    /* Paper stays paper even in dark mode — a lit page in a dark room,
       not an inverted document. That contrast is the point. */
    --paper:        #F3ECDA;
    --paper-shadow: #E4D9BC;
    --paper-ink:    #241C10;
    --paper-ink-soft: #5B4F3B;
    --paper-rule:   rgba(90,70,30,0.18);
    --paper-cover:  #121D3B;
    --paper-cover-ink: #F0DFA8;
}

/* =====================================================================
   RESET & BASE
   ===================================================================== */
#course-page {
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    font-family: var(--font-body);
    color: var(--text);
    position: relative;
    min-height: 100vh;
    isolation: isolate;
}
#course-page a:focus-visible,
#course-page button:focus-visible,
#course-page input:focus-visible,
#course-page [data-cp-accordion]:focus-visible {
    outline: 2px solid var(--navy-bright);
    outline-offset: 2px;
    border-radius: 4px;
}

/* Ambient console backdrop: soft blueprint grid + two slow-breathing glow
   fields in navy and gold. One considered, quiet backdrop — not a
   scattershot of effects. */
#course-page .cp-ambient {
    position: fixed;
    inset: 0;
    z-index: -2;
    background: var(--bg);
    transition: background .4s var(--ease);
    overflow: hidden;
}
#course-page .cp-ambient::before {
    content: '';
    position: absolute;
    inset: -10%;
    background-image:
        linear-gradient(var(--grid-line) 1px, transparent 1px),
        linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
    background-size: 64px 64px;
    mask-image: radial-gradient(ellipse 75% 65% at 50% 10%, black 25%, transparent 80%);
}
#course-page .cp-ambient-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    opacity: .55;
    will-change: transform;
}
#course-page .cp-ambient-glow.g1 {
    width: 620px; height: 620px;
    top: -220px; left: -140px;
    background: radial-gradient(circle, rgba(37,99,235,0.18), transparent 70%);
    animation: cp-drift-a 22s ease-in-out infinite;
}
#course-page .cp-ambient-glow.g2 {
    width: 520px; height: 520px;
    top: 10%; right: -160px;
    background: radial-gradient(circle, rgba(184,134,11,0.13), transparent 70%);
    animation: cp-drift-b 26s ease-in-out infinite;
}
@keyframes cp-drift-a {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50%      { transform: translate(34px, 26px) scale(1.06); }
}
@keyframes cp-drift-b {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50%      { transform: translate(-28px, 32px) scale(1.08); }
}

/* =====================================================================
   LAYOUT
   ===================================================================== */
#course-page .cp-layout {
    display: flex;
    align-items: flex-start;
    gap: 28px;
    max-width: 1320px;
    margin: 0 auto;
    padding: 40px 24px 64px;
}

/* =====================================================================
   SIDEBAR / COURSE MENU
   ===================================================================== */
#course-page .cp-nav {
    width: 224px;
    flex-shrink: 0;
    position: sticky;
    top: 24px;
}

#course-page .cp-nav-panel {
    background: var(--surface);
    backdrop-filter: blur(18px) saturate(160%);
    border: 1px solid var(--border);
    border-radius: 14px;
    box-shadow: var(--shadow-card);
    overflow: hidden;
}

#course-page .cp-nav-title {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 15px 18px;
    font-family: var(--font-mono);
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .06em;
    color: var(--text-dim);
    border-bottom: 1px solid var(--border);
}
#course-page .cp-nav-title-dot {
    width: 6px; height: 6px;
    border-radius: 999px;
    background: var(--navy-bright);
    box-shadow: 0 0 8px 2px var(--navy-bright);
    animation: cp-pulse 2s ease-in-out infinite;
    flex-shrink: 0;
}

#course-page .cp-nav-list { list-style: none; }

#course-page .cp-nav-item { border-bottom: 1px solid var(--border); }
#course-page .cp-nav-item:last-child { border-bottom: none; }

#course-page .cp-nav-link {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 13px 18px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: .9rem;
    font-weight: 500;
    border-left: 2px solid transparent;
    transition: background .2s var(--ease), border-color .2s var(--ease), color .2s var(--ease), padding-left .2s var(--ease);
}
#course-page .cp-nav-link:hover { background: var(--navy-wash-hover); color: var(--navy-bright); padding-left: 22px; }
#course-page .cp-nav-link.is-active {
    background: var(--navy-soft-bg);
    border-left-color: var(--navy-bright);
    color: var(--navy-bright);
    font-weight: 700;
}
#course-page .cp-nav-ico { font-size: 1.05rem; width: 20px; text-align: center; flex-shrink: 0; transition: transform .25s var(--ease); }
#course-page .cp-nav-link:hover .cp-nav-ico { transform: translateY(-1px) scale(1.08); }

@keyframes cp-pulse { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: .45; transform: scale(1.35); } }

/* =====================================================================
   MAIN SHELL — the desk the book sits on
   ===================================================================== */
#course-page .cp-main {
    flex: 1;
    min-width: 0;
    position: relative;
    padding: 22px;
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(240,245,255,0.92));
    border: 1px solid rgba(20,38,94,0.12);
    border-radius: 28px;
    box-shadow:
        0 22px 60px -28px rgba(11,22,51,0.26),
        inset 0 0 0 1px rgba(255,255,255,0.72),
        inset 0 12px 26px rgba(255,255,255,0.35);
}
html.dark-mode #course-page .cp-main {
    background: linear-gradient(180deg, rgba(12,19,36,0.96), rgba(9,15,28,0.94));
    border-color: rgba(120,150,230,0.18);
    box-shadow:
        0 24px 64px -26px rgba(0,0,0,0.7),
        inset 0 0 0 1px rgba(148,163,184,0.12),
        inset 0 12px 24px rgba(15,23,42,0.35);
}

/* =========================================================================
   THE BOOK — the one bold element on this page. Everything else (sidebar,
   toolbar chrome) stays quiet console styling; the book gets a distinct,
   warmer material so it reads as content you read, not a panel you operate.
   ========================================================================= */
#course-page .book-shell {
    position: relative;
}

/* ── Toolbar: brand + prev/next, styled as a bookshelf label plaque ── */
#course-page .book-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 4px 6px 18px;
}
#course-page .book-brand {
    display: flex;
    align-items: baseline;
    gap: 10px;
}
#course-page .book-brand-mark {
    font-family: var(--font-mono);
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    color: var(--navy-bright);
    background: var(--navy-soft-bg);
    border: 1px solid var(--navy-soft-border);
    padding: 4px 10px;
    border-radius: 999px;
}
#course-page .book-brand-copy {
    font-family: var(--font-display);
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text);
}
#course-page .book-nav-controls {
    display: flex;
    gap: 8px;
}
#course-page .book-nav-button {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    border-radius: 10px;
    border: 1px solid var(--border);
    background: var(--surface-solid);
    color: var(--text-muted);
    font-family: var(--font-body);
    font-size: .86rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform .18s var(--ease), border-color .18s var(--ease), color .18s var(--ease), box-shadow .18s var(--ease), opacity .18s var(--ease);
}
#course-page .book-nav-button:hover:not(:disabled) {
    color: var(--navy-bright);
    border-color: var(--navy-soft-border);
    transform: translateY(-1px);
}
#course-page .book-nav-button.primary {
    background: linear-gradient(135deg, var(--navy), var(--navy-bright));
    border-color: transparent;
    color: #fff;
    box-shadow: 0 10px 22px -10px rgba(37,99,235,0.55);
}
#course-page .book-nav-button.primary:hover:not(:disabled) { box-shadow: 0 14px 26px -10px rgba(37,99,235,0.65); }
#course-page .book-nav-button:disabled { opacity: .38; cursor: not-allowed; transform: none; }

/* ── The spread: two facing pages on a lectern, with a real spine ── */
#course-page .book-spread {
    position: relative;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    background: var(--paper-cover);
    border-radius: 14px;
    padding: 22px 22px 26px;
    box-shadow:
        0 30px 60px -24px rgba(11,22,51,0.45),
        0 2px 0 rgba(255,255,255,0.06) inset;
    perspective: 1800px;
}
/* leather/cloth cover trim */
#course-page .book-spread::before {
    content: '';
    position: absolute;
    inset: 10px;
    border: 1px solid rgba(240,220,150,0.16);
    border-radius: 8px;
    pointer-events: none;
}
/* the gutter / spine shadow where the two pages meet */
#course-page .book-spread::after {
    content: '';
    position: absolute;
    top: 22px;
    bottom: 26px;
    left: 50%;
    width: 64px;
    transform: translateX(-50%);
    background: linear-gradient(90deg,
        transparent 0%,
        rgba(20,15,5,0.16) 38%,
        rgba(20,15,5,0.30) 50%,
        rgba(20,15,5,0.16) 62%,
        transparent 100%);
    pointer-events: none;
    z-index: 3;
}

#course-page .book-page {
    position: relative;
    background:
        radial-gradient(ellipse at top left, rgba(255,255,255,0.5), transparent 55%),
        var(--paper);
    min-height: 460px;
    padding: 30px 34px 34px;
    overflow: hidden;
    transform-style: preserve-3d;
    transform-origin: left center;
    box-shadow: inset 0 0 40px rgba(90,70,30,0.06);
}
#course-page .book-page.left-page {
    border-radius: 6px 2px 2px 6px;
    box-shadow: inset -18px 0 26px -22px rgba(20,15,5,0.4), inset 0 0 40px rgba(90,70,30,0.06);
}
#course-page .book-page.right-page {
    border-radius: 2px 6px 6px 2px;
    transform-origin: left center;
    box-shadow: inset 18px 0 26px -22px rgba(20,15,5,0.4), inset 0 0 40px rgba(90,70,30,0.06);
}
/* faint paper fibre texture */
#course-page .book-page::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: .5;
    background-image:
        radial-gradient(rgba(90,70,30,0.05) 1px, transparent 1px),
        radial-gradient(rgba(90,70,30,0.04) 1px, transparent 1px);
    background-size: 3px 3px, 7px 7px;
    background-position: 0 0, 2px 3px;
    pointer-events: none;
}
/* dog-eared curl in the outer bottom corner */
#course-page .book-page.right-page::after {
    content: '';
    position: absolute;
    right: 0; bottom: 0;
    width: 30px; height: 30px;
    background: linear-gradient(135deg, transparent 50%, var(--paper-shadow) 50%);
    box-shadow: -2px -2px 6px -3px rgba(90,70,30,0.35);
    border-radius: 0 0 4px 0;
}
#course-page .book-page.left-page::after {
    content: '';
    position: absolute;
    left: 0; bottom: 0;
    width: 30px; height: 30px;
    background: linear-gradient(225deg, transparent 50%, var(--paper-shadow) 50%);
    box-shadow: 2px -2px 6px -3px rgba(90,70,30,0.35);
    border-radius: 0 0 0 4px;
}

/* the flip: a brief paper-turn on the active leaf */
@keyframes book-flip-right {
    0%   { transform: rotateY(0deg); filter: brightness(1); }
    45%  { transform: rotateY(-92deg); filter: brightness(.82); }
    55%  { transform: rotateY(-92deg); filter: brightness(.82); }
    100% { transform: rotateY(0deg); filter: brightness(1); }
}
@keyframes book-flip-left {
    0%   { transform: rotateY(0deg); filter: brightness(1); }
    45%  { transform: rotateY(92deg); filter: brightness(.82); }
    55%  { transform: rotateY(92deg); filter: brightness(.82); }
    100% { transform: rotateY(0deg); filter: brightness(1); }
}
#course-page .book-page.page-flip-right { animation: book-flip-right .52s var(--ease); z-index: 4; }
#course-page .book-page.page-flip-left  { animation: book-flip-left  .52s var(--ease); z-index: 4; }

/* ── Page card content: printed-page typography ── */
#course-page .book-page-card {
    font-family: var(--font-serif);
    color: var(--paper-ink);
    display: flex;
    flex-direction: column;
    gap: 14px;
    height: 100%;
}
#course-page .book-page-tag {
    font-family: var(--font-mono);
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .1em;
    color: var(--gold);
    text-transform: uppercase;
}
#course-page .book-page-card h2 {
    font-size: clamp(1.5rem, 2.6vw, 2rem);
    line-height: 1.18;
    font-weight: 600;
    border-bottom: 1px solid var(--paper-rule);
    padding-bottom: 14px;
}
#course-page .book-page-card h3 {
    font-size: 1.32rem;
    line-height: 1.25;
    font-weight: 600;
    border-bottom: 1px solid var(--paper-rule);
    padding-bottom: 12px;
}
#course-page .book-page-card p {
    font-size: .98rem;
    line-height: 1.7;
    color: var(--paper-ink-soft);
    max-width: 46ch;
}

/* ── Cover page ── */
#course-page .book-page-card--cover {
    justify-content: center;
    align-items: flex-start;
    text-align: left;
}
#course-page .book-page-card--cover h2 { border-bottom: none; padding-bottom: 0; }
#course-page .book-cover-subtitle {
    font-size: 1.02rem;
    color: var(--paper-ink-soft);
    max-width: 40ch;
    line-height: 1.6;
}
#course-page .book-cover-stat-grid {
    display: flex;
    gap: 28px;
    margin: 10px 0 4px;
    padding-top: 16px;
    border-top: 1px dashed var(--paper-rule);
    width: 100%;
}
#course-page .book-cover-stat-grid > div { display: flex; flex-direction: column; gap: 4px; }
#course-page .book-cover-stat-grid span {
    font-family: var(--font-mono);
    font-size: .66rem;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--gold);
}
#course-page .book-cover-stat-grid strong {
    font-family: var(--font-display);
    font-size: 1.5rem;
    color: var(--paper-ink);
}
#course-page .book-cover-actions { display: flex; gap: 10px; margin-top: 12px; }

#course-page .book-action-button {
    font-family: var(--font-body);
    font-size: .86rem;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 8px;
    border: 1px solid var(--paper-rule);
    background: transparent;
    color: var(--paper-ink);
    cursor: pointer;
    transition: transform .18s var(--ease), background .18s var(--ease), color .18s var(--ease), border-color .18s var(--ease);
}
#course-page .book-action-button:hover { transform: translateY(-1px); border-color: var(--gold); color: var(--gold); }
#course-page .book-action-button.primary {
    background: var(--paper-ink);
    border-color: var(--paper-ink);
    color: var(--paper);
}
#course-page .book-action-button.primary:hover { background: var(--gold); border-color: var(--gold); color: #241C10; }

/* ── Table of contents ── */
#course-page .book-toc-list { display: flex; flex-direction: column; gap: 2px; margin-top: 4px; }
#course-page .book-toc-item {
    display: flex;
    align-items: baseline;
    gap: 14px;
    width: 100%;
    padding: 11px 4px;
    background: transparent;
    border: none;
    border-bottom: 1px dotted var(--paper-rule);
    text-align: left;
    cursor: pointer;
    font-family: var(--font-serif);
    transition: padding-left .18s var(--ease), color .18s var(--ease);
}
#course-page .book-toc-item:hover { padding-left: 10px; color: var(--gold); }
#course-page .book-toc-index {
    font-family: var(--font-mono);
    font-size: .78rem;
    color: var(--gold);
    flex-shrink: 0;
}
#course-page .book-toc-meta { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
#course-page .book-toc-meta strong { font-size: 1rem; font-weight: 600; color: inherit; }
#course-page .book-toc-meta small { font-family: var(--font-body); font-size: .8rem; color: var(--paper-ink-soft); }

/* ── Course overview page ── */
#course-page .book-mini-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin: 6px 0;
}
#course-page .book-module-tile {
    text-align: left;
    background: rgba(90,70,30,0.05);
    border: 1px solid var(--paper-rule);
    border-radius: 8px;
    padding: 12px 14px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    gap: 3px;
    font-family: var(--font-body);
    transition: border-color .18s var(--ease), transform .18s var(--ease), background .18s var(--ease);
}
#course-page .book-module-tile:hover { border-color: var(--gold); transform: translateY(-2px); background: rgba(184,134,11,0.08); }
#course-page .book-module-tile span { font-family: var(--font-mono); font-size: .66rem; letter-spacing: .06em; color: var(--gold); text-transform: uppercase; }
#course-page .book-module-tile strong { font-size: .96rem; color: var(--paper-ink); font-weight: 600; }
#course-page .book-module-tile small { font-size: .78rem; color: var(--paper-ink-soft); }

/* ── Module page ── */
#course-page .book-module-summary { margin-bottom: 2px; }
#course-page .book-list { display: flex; flex-direction: column; gap: 6px; list-style: none; }
#course-page .book-list-link {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 10px 6px;
    background: transparent;
    border: none;
    border-bottom: 1px dotted var(--paper-rule);
    text-align: left;
    cursor: pointer;
    font-family: var(--font-body);
    color: var(--paper-ink);
    transition: padding-left .18s var(--ease), color .18s var(--ease);
}
#course-page .book-list-link:hover { padding-left: 10px; color: var(--gold); }
#course-page .book-list-link span {
    font-family: var(--font-mono);
    font-size: .74rem;
    color: var(--gold);
    width: 18px;
    flex-shrink: 0;
}
#course-page .book-list-link strong { flex: 1; font-weight: 600; font-size: .94rem; }
#course-page .book-list-link small { font-family: var(--font-mono); font-size: .72rem; color: var(--paper-ink-soft); }

/* ── Lesson page ── */
#course-page .book-lesson-meta {
    font-family: var(--font-mono) !important;
    font-size: .74rem !important;
    letter-spacing: .04em;
    color: var(--paper-ink-soft) !important;
    max-width: none !important;
}
#course-page .book-lesson-body p { margin-bottom: 4px; }
#course-page .book-media-box { margin-top: 6px; }
#course-page .book-media-figure {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: rgba(184,134,11,0.07);
    border: 1px solid var(--gold-soft-border);
    border-radius: 8px;
}
#course-page .book-media-icon { font-size: 1.5rem; }
#course-page .book-media-figure strong { display: block; font-family: var(--font-body); font-size: .88rem; color: var(--paper-ink); }
#course-page .book-media-figure small { font-family: var(--font-body); font-size: .8rem; color: var(--paper-ink-soft); }

/* ── Quiz page ── */
#course-page .book-quiz-form { display: flex; flex-direction: column; gap: 16px; flex: 1; }
#course-page .book-quiz-item {
    padding-bottom: 12px;
    border-bottom: 1px dashed var(--paper-rule);
}
#course-page .book-quiz-item p { font-family: var(--font-body); font-weight: 600; font-size: .92rem; color: var(--paper-ink); margin-bottom: 8px; }
#course-page .book-quiz-options { display: flex; flex-direction: column; gap: 6px; }
#course-page .book-choice {
    display: flex;
    align-items: center;
    gap: 9px;
    font-family: var(--font-body);
    font-size: .88rem;
    color: var(--paper-ink-soft);
    cursor: pointer;
    padding: 4px 2px;
    border-radius: 5px;
    transition: background .15s var(--ease), color .15s var(--ease);
}
#course-page .book-choice:hover { background: rgba(184,134,11,0.08); color: var(--paper-ink); }
#course-page .book-choice input { accent-color: var(--gold); width: 15px; height: 15px; flex-shrink: 0; }
#course-page .book-quiz-item.is-correct p::after { content: ' ✓ correct'; color: var(--emerald); font-family: var(--font-mono); font-size: .72rem; font-weight: 700; }
#course-page .book-quiz-item.is-wrong p::after { content: ' ✕ review this one'; color: var(--crimson); font-family: var(--font-mono); font-size: .72rem; font-weight: 700; }

/* ── Results page ── */
#course-page .book-page-card--results { align-items: center; text-align: center; justify-content: center; }
#course-page .book-result-ring {
    width: 132px; height: 132px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    background: conic-gradient(var(--gold) calc(var(--score, 0) * 1%), rgba(90,70,30,0.12) 0);
    margin: 6px 0;
}
#course-page .book-result-ring::before {
    content: '';
    position: absolute;
}
#course-page .book-result-value {
    width: 104px; height: 104px;
    border-radius: 50%;
    background: var(--paper);
    display: grid;
    place-items: center;
    font-family: var(--font-display);
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--paper-ink);
}

/* ── Shared page actions row ── */
#course-page .book-page-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid var(--paper-rule);
}

/* ── Footer bar under the book ── */
#course-page .book-footer-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 8px 2px;
    font-family: var(--font-mono);
    font-size: .72rem;
    color: var(--text-dim);
}
#course-page .book-page-index { font-weight: 600; color: var(--text-muted); }

/* =====================================================================
   RESPONSIVE
   ===================================================================== */
@media (max-width: 900px) {
    #course-page .cp-layout { flex-direction: column; gap: 20px; }
    #course-page .cp-nav { width: 100%; position: static; }
    #course-page .cp-nav-panel { display: flex; border-radius: 14px; overflow-x: auto; }
    #course-page .cp-nav-title { display: none; }
    #course-page .cp-nav-list { display: flex; }
    #course-page .cp-nav-item { flex-shrink: 0; border-bottom: none; border-right: 1px solid var(--border); }
    #course-page .cp-nav-link { flex-direction: column; gap: 4px; padding: 12px 16px; font-size: .78rem; }
    #course-page .cp-nav-link:hover { padding-left: 16px; }
}

@media (max-width: 720px) {
    /* Single-page reading mode: the spread collapses to one leaf so the
       book doesn't get crushed — this is a redesign choice, not a shrink. */
    #course-page .book-spread { grid-template-columns: 1fr; padding: 14px 14px 18px; }
    #course-page .book-spread::after { display: none; }
    #course-page .book-page.left-page { display: none; }
    #course-page .book-page.right-page { border-radius: 6px; box-shadow: inset 0 0 40px rgba(90,70,30,0.06); }
    #course-page .book-page.right-page::after { display: none; }
    #course-page .book-mini-grid { grid-template-columns: 1fr; }
    #course-page .book-cover-stat-grid { gap: 18px; flex-wrap: wrap; }
    #course-page .book-toolbar { flex-direction: column; align-items: flex-start; gap: 10px; }
}

@media (prefers-reduced-motion: reduce) {
    #course-page *, #course-page *::before, #course-page *::after {
        animation: none !important;
        transition: none !important;
    }
    #course-page .cp-ambient-glow { animation: none !important; }
}
</style>

<div id="course-page">
    <div class="cp-ambient">
        <div class="cp-ambient-glow g1"></div>
        <div class="cp-ambient-glow g2"></div>
    </div>

    <div class="cp-layout">

        
        <aside class="cp-nav">
            <div class="cp-nav-panel">
                <div class="cp-nav-title">
                    <span class="cp-nav-title-dot"></span>
                    course.menu
                </div>
                <ul class="cp-nav-list">
                    <li class="cp-nav-item">
                        <a href="<?php echo e(route('courses.index')); ?>"
                           class="cp-nav-link <?php echo e(request()->routeIs('courses.index') ? 'is-active' : ''); ?>">
                            <span class="cp-nav-ico">📖</span><span>Explore</span>
                        </a>
                    </li>
                    <li class="cp-nav-item">
                        <a href="<?php echo e(route('quiz')); ?>"
                           class="cp-nav-link <?php echo e(request()->routeIs('quiz') ? 'is-active' : ''); ?>">
                            <span class="cp-nav-ico">❓</span><span>Quizzes</span>
                        </a>
                    </li>
                    <li class="cp-nav-item">
                        <a href="<?php echo e(route('subjects')); ?>"
                           class="cp-nav-link <?php echo e(request()->routeIs('subjects') ? 'is-active' : ''); ?>">
                            <span class="cp-nav-ico">📚</span><span>Subjects</span>
                        </a>
                    </li>
                    <li class="cp-nav-item">
                        <a href="<?php echo e(route('trivia')); ?>"
                           class="cp-nav-link <?php echo e(request()->routeIs('trivia') ? 'is-active' : ''); ?>">
                            <span class="cp-nav-ico">🎯</span><span>Trivia</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        
        <div class="cp-main">

            <?php
                $bookCourseList = collect();
                $availableCourses = $courses ?? null;
                if ($availableCourses instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                    $bookCourseList = $availableCourses->getCollection();
                } elseif ($availableCourses instanceof \Illuminate\Support\Collection) {
                    $bookCourseList = $availableCourses;
                } elseif (is_iterable($availableCourses)) {
                    $bookCourseList = collect($availableCourses);
                }

                if ($bookCourseList->isEmpty()) {
                    $bookCourseList = $enrolledCourses->isNotEmpty() ? $enrolledCourses : collect([$selectedCourse ?? $course]);
                }
                $bookCourseList = $bookCourseList->filter();

                $bookData = [];
                foreach ($bookCourseList as $bookCourse) {
                    $modulesData = collect($bookCourse->modules ?? []);
                    $bookModules = [];

                    foreach ($modulesData as $module) {
                        $lessonsData = collect($module->lessons ?? []);
                        $moduleLessons = [];

                        foreach ($lessonsData as $lesson) {
                            $moduleLessons[] = [
                                'id' => (string) ($lesson->id ?? rand(100, 999)),
                                'title' => $lesson->title ?? 'Lesson',
                                'summary' => $lesson->summary ?? ($lesson->description ?? 'Practical, guided learning activity.'),
                                'content' => trim(strip_tags($lesson->content ?? $lesson->description ?? 'Course content is being prepared for this lesson.')) ?: 'Course content is being prepared for this lesson.',
                                'duration' => $lesson->duration_minutes ?? 20,
                            ];
                        }

                        if (empty($moduleLessons)) {
                            $moduleLessons[] = [
                                'id' => 'intro',
                                'title' => 'Orientation',
                                'summary' => 'Program overview and expected outcomes.',
                                'content' => 'This lesson introduces the focus of the module and the expected practical skills. Review the objectives and work through each task with care.',
                                'duration' => 15,
                            ];
                        }

                        $bookModules[] = [
                            'id' => (string) ($module->id ?? rand(1000, 9999)),
                            'title' => $module->title ?? 'Module',
                            'summary' => $module->description ?? 'Build practical skill through guided learning.',
                            'lessons' => $moduleLessons,
                            'quiz' => [
                                [
                                    'question' => 'Which action best aligns with the learning goal of this module?',
                                    'options' => ['Apply the skill in guided practice', 'Skip the task and continue', 'Ignore the review notes', 'Guess without reading'],
                                    'answer' => 0,
                                ],
                                [
                                    'question' => 'What is the best way to check your understanding?',
                                    'options' => ['Review the lesson and complete the practice tasks', 'Wait for someone else to solve it', 'Skip the quiz', 'Never revisit the lesson'],
                                    'answer' => 0,
                                ],
                                [
                                    'question' => 'Why is it important to complete all module tasks?',
                                    'options' => ['It builds practical competence and confidence', 'It wastes time', 'It makes learning harder', 'It has no benefit'],
                                    'answer' => 0,
                                ],
                            ],
                        ];
                    }

                    if (empty($bookModules)) {
                        $bookModules[] = [
                            'id' => 'default-module',
                            'title' => 'Foundation',
                            'summary' => 'Key concepts and foundational learning activities.',
                            'lessons' => [[
                                'id' => 'default-lesson',
                                'title' => 'Course Introduction',
                                'summary' => 'Get oriented to the course and expected outcomes.',
                                'content' => 'This course will guide learners through practical tasks, guided activities, and work-ready skill-building. Focus on applying each concept to real learning situations.',
                                'duration' => 20,
                            ]],
                            'quiz' => [[
                                'question' => 'What should you do first when starting a course?',
                                'options' => ['Review the lesson objectives and plan your work', 'Skip ahead', 'Wait for instructions from someone else', 'Ignore the overview'],
                                'answer' => 0,
                            ], [
                                'question' => 'A strong learning routine includes:',
                                'options' => ['Consistent practice and review', 'Random guesswork', 'Avoiding feedback', 'Skipping tasks'],
                                'answer' => 0,
                            ], [
                                'question' => 'The course is designed to help learners:',
                                'options' => ['Develop practical confidence and skill', 'Avoid all challenges', 'Stay passive', 'Ignore progress'],
                                'answer' => 0,
                            ]],
                        ];
                    }

                    $bookData[] = [
                        'id' => (string) ($bookCourse->id ?? rand(1, 999)),
                        'title' => $bookCourse->title ?? 'Course',
                        'subtitle' => $bookCourse->short_description ?? ($bookCourse->description ?? 'Technical and vocational training course.'),
                        'modules' => $bookModules,
                    ];
                }

                if (empty($bookData)) {
                    $bookData[] = [
                        'id' => 'empty-course',
                        'title' => 'No course available',
                        'subtitle' => 'There are no published courses right now.',
                        'modules' => [[
                            'id' => 'empty-module',
                            'title' => 'Course overview',
                            'summary' => 'Please check back shortly.',
                            'lessons' => [[
                                'id' => 'empty-lesson',
                                'title' => 'Check back later',
                                'summary' => 'Course content is not available yet.',
                                'content' => 'This learning track has no published content at the moment. Please try again later or contact your administrator.',
                                'duration' => 10,
                            ]],
                            'quiz' => [[
                                'question' => 'When will the course be ready?',
                                'options' => ['When content is published', 'Never', 'Immediately without setup', 'The course is complete'],
                                'answer' => 0,
                            ]],
                        ]],
                    ];
                }
            ?>

            <div id="book-shell" data-course-book='<?php echo json_encode($bookData, 15, 512) ?>' class="book-shell">
                <div class="book-toolbar">
                    <div class="book-brand">
                        <span class="book-brand-mark">TESDA</span>
                        <span class="book-brand-copy">Learning Book</span>
                    </div>
                    <div class="book-nav-controls">
                        <button type="button" class="book-nav-button" data-book-nav="prev" aria-label="Previous page">← Prev</button>
                        <button type="button" class="book-nav-button primary" data-book-nav="next" aria-label="Next page">Next →</button>
                    </div>
                </div>

                <div class="book-spread">
                    <div class="book-page left-page" id="bookLeftPage" aria-live="polite"></div>
                    <div class="book-page right-page" id="bookRightPage" aria-live="polite"></div>
                </div>

                <div class="book-footer-bar">
                    <div class="book-page-index" id="bookPageIndex">Page 1 / 1</div>
                    <div class="book-legend">Open book · Guided learning · Skills progress</div>
                </div>
            </div>

            <script>
                (function () {
                    const shell = document.getElementById('book-shell');
                    if (!shell) return;

                    const rawData = shell.getAttribute('data-course-book');
                    const data = rawData ? JSON.parse(rawData) : [];
                    const pageStack = [];
                    let currentIndex = 0;

                    function safeText(value, fallback) {
                        return value && String(value).trim() ? String(value) : fallback;
                    }
                    function escapeHtml(value) {
                        return String(value ?? '')
                            .replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(/"/g, '&quot;');
                    }

                    function makeCover(course) {
                        return `
                            <article class="book-page-card book-page-card--cover">
                                <div class="book-page-tag">Course Manual</div>
                                <h2>${escapeHtml(safeText(course.title, 'Learning Path'))}</h2>
                                <p class="book-cover-subtitle">${escapeHtml(safeText(course.subtitle, 'Technical and vocational learning experience'))}</p>
                                <div class="book-cover-stat-grid">
                                    <div>
                                        <span>Modules</span>
                                        <strong>${course.modules.length}</strong>
                                    </div>
                                    <div>
                                        <span>Lessons</span>
                                        <strong>${course.modules.reduce((sum, module) => sum + (module.lessons || []).length, 0)}</strong>
                                    </div>
                                    <div>
                                        <span>Progress</span>
                                        <strong>68%</strong>
                                    </div>
                                </div>
                                <div class="book-cover-actions">
                                    <button class="book-action-button" type="button" data-book-jump="toc">Table of contents</button>
                                    <button class="book-action-button primary" type="button" data-book-jump="course:0">Open course</button>
                                </div>
                            </article>
                        `;
                    }

                    function makeTocPage(courseList) {
                        return `
                            <article class="book-page-card book-page-card--toc">
                                <div class="book-page-tag">Table of Contents</div>
                                <h3>Available Courses</h3>
                                <div class="book-toc-list">
                                    ${(courseList || []).map((course, index) => `
                                        <button class="book-toc-item" type="button" data-book-jump="course:${index}">
                                            <span class="book-toc-index">${String(index + 1).padStart(2, '0')}</span>
                                            <span class="book-toc-meta">
                                                <strong>${escapeHtml(safeText(course.title, 'Course'))}</strong>
                                                <small>${escapeHtml(safeText(course.subtitle, 'Technical and vocational course'))}</small>
                                            </span>
                                        </button>
                                    `).join('')}
                                </div>
                            </article>
                        `;
                    }

                    function makeCoursePage(course, courseIndex) {
                        return `
                            <article class="book-page-card book-page-card--course">
                                <div class="book-page-tag">Course Overview</div>
                                <h3>${escapeHtml(safeText(course.title, 'Course'))}</h3>
                                <p>${escapeHtml(safeText(course.subtitle, 'Practical and guided learning experience for skills development.'))}</p>
                                <div class="book-mini-grid">
                                    ${(course.modules || []).map((module, moduleIndex) => `
                                        <button class="book-module-tile" type="button" data-book-jump="module:${courseIndex}:${moduleIndex}">
                                            <span>Module ${moduleIndex + 1}</span>
                                            <strong>${escapeHtml(safeText(module.title, 'Module'))}</strong>
                                            <small>${(module.lessons || []).length} lessons</small>
                                        </button>
                                    `).join('')}
                                </div>
                                <div class="book-page-actions">
                                    <button class="book-action-button" type="button" data-book-jump="cover">Back to cover</button>
                                    <button class="book-action-button primary" type="button" data-book-jump="toc">Course list</button>
                                </div>
                            </article>
                        `;
                    }

                    function makeModulePage(course, module, moduleIndex, courseIndex) {
                        return `
                            <article class="book-page-card book-page-card--module">
                                <div class="book-page-tag">Module</div>
                                <h3>${escapeHtml(safeText(module.title, 'Module'))}</h3>
                                <p class="book-module-summary">${escapeHtml(safeText(module.summary, 'A practical module focused on guided learning and applied skill-building.'))}</p>
                                <ul class="book-list">
                                    ${(module.lessons || []).map((lesson, lessonIndex) => `
                                        <li>
                                            <button type="button" class="book-list-link" data-book-jump="lesson:${courseIndex}:${moduleIndex}:${lessonIndex}">
                                                <span>${lessonIndex + 1}</span>
                                                <strong>${escapeHtml(safeText(lesson.title, 'Lesson'))}</strong>
                                                <small>${lesson.duration || 20} min</small>
                                            </button>
                                        </li>
                                    `).join('')}
                                </ul>
                                <div class="book-page-actions">
                                    <button class="book-action-button" type="button" data-book-jump="course:${courseIndex}">Course overview</button>
                                    <button class="book-action-button primary" type="button" data-book-jump="quiz:${courseIndex}:${moduleIndex}">Module quiz</button>
                                </div>
                            </article>
                        `;
                    }

                    function makeLessonPage(course, module, lesson, lessonIndex, moduleIndex, courseIndex) {
                        const lessonText = safeText(lesson.content, 'This lesson focuses on practical skills and guided demonstration. Learners should review each objective, complete the activity, and then move into assessment.');
                        return `
                            <article class="book-page-card book-page-card--lesson">
                                <div class="book-page-tag">Lesson ${lessonIndex + 1}</div>
                                <h3>${escapeHtml(safeText(lesson.title, 'Lesson'))}</h3>
                                <p class="book-lesson-meta">${escapeHtml(safeText(module.title, 'Module'))} · ${lesson.duration || 20} minutes</p>
                                <div class="book-lesson-body">
                                    <p>${escapeHtml(lessonText)}</p>
                                    <div class="book-media-box">
                                        <div class="book-media-figure">
                                            <div class="book-media-icon">📘</div>
                                            <div>
                                                <strong>Learning focus</strong>
                                                <small>${escapeHtml(safeText(lesson.summary, 'Applied understanding and guided practice'))}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="book-page-actions">
                                    <button class="book-action-button" type="button" data-book-jump="module:${courseIndex}:${moduleIndex}">Back to module</button>
                                    <button class="book-action-button primary" type="button" data-book-jump="quiz:${courseIndex}:${moduleIndex}">Take quiz</button>
                                </div>
                            </article>
                        `;
                    }

                    function makeQuizPage(course, module, courseIndex, moduleIndex) {
                        const quiz = Array.isArray(module.quiz) && module.quiz.length ? module.quiz : [{
                            question: 'What is the key aim of the module?',
                            options: ['Practice the core skill', 'Ignore the lesson', 'Skip evaluation', 'Avoid feedback'],
                            answer: 0,
                        }];

                        const promptId = `quiz-${courseIndex}-${moduleIndex}`;

                        const questionHtml = quiz.map((item, itemIndex) => `
                            <div class="book-quiz-item" data-answer-index="${itemIndex}">
                                <p>${itemIndex + 1}. ${escapeHtml(safeText(item.question, 'Question'))}</p>
                                <div class="book-quiz-options">
                                    ${(item.options || []).map((option, optIndex) => `
                                        <label class="book-choice">
                                            <input type="radio" name="${promptId}-${itemIndex}" value="${optIndex}" />
                                            <span>${escapeHtml(safeText(option, 'Option'))}</span>
                                        </label>
                                    `).join('')}
                                </div>
                            </div>
                        `).join('');

                        return `
                            <article class="book-page-card book-page-card--quiz">
                                <div class="book-page-tag">Quiz</div>
                                <h3>${escapeHtml(safeText(module.title, 'Module'))} Checkpoint</h3>
                                <form class="book-quiz-form" data-quiz-form="${promptId}">
                                    ${questionHtml}
                                    <div class="book-page-actions">
                                        <button class="book-action-button" type="button" data-book-jump="module:${courseIndex}:${moduleIndex}">Review module</button>
                                        <button class="book-action-button primary" type="submit">Submit answers</button>
                                    </div>
                                </form>
                            </article>
                        `;
                    }

                    function makeResultsPage(course, courseIndex, moduleIndex, score) {
                        const percent = Math.min(100, Math.max(0, score));
                        return `
                            <article class="book-page-card book-page-card--results" style="--score:${percent}">
                                <div class="book-page-tag">Progress</div>
                                <h3>${escapeHtml(safeText(course?.title, 'Assessment'))} Result</h3>
                                <div class="book-result-ring">
                                    <div class="book-result-value">${percent}%</div>
                                </div>
                                <p>${percent >= 70 ? 'Excellent work. You are ready to continue to the next section.' : 'You are making progress. Review the module content and try the quiz again.'}</p>
                                <div class="book-page-actions">
                                    <button class="book-action-button" type="button" data-book-jump="module:${courseIndex}:${moduleIndex}">Review module</button>
                                    <button class="book-action-button primary" type="button" data-book-jump="course:${courseIndex}">Continue course</button>
                                </div>
                            </article>
                        `;
                    }

                    function addPage(type, payload) {
                        pageStack.push({ type, payload });
                    }

                    function buildPages() {
                        pageStack.length = 0;
                        if (!data.length) return;

                        const firstCourse = data[0];
                        addPage('cover', firstCourse);
                        addPage('toc', data);

                        data.forEach((course, courseIndex) => {
                            addPage('course', { course, courseIndex });
                            (course.modules || []).forEach((module, moduleIndex) => {
                                addPage('module', { course, module, courseIndex, moduleIndex });
                                (module.lessons || []).forEach((lesson, lessonIndex) => {
                                    addPage('lesson', { course, module, lesson, courseIndex, moduleIndex, lessonIndex });
                                });
                                addPage('quiz', { course, module, courseIndex, moduleIndex });
                            });
                        });
                    }

                    function renderPageDisplay(page) {
                        if (!page) return '';
                        const { type, payload } = page;

                        switch (type) {
                            case 'cover':
                                return makeCover(payload || data[0]);
                            case 'toc':
                                return makeTocPage(payload || data);
                            case 'course':
                                return makeCoursePage(payload.course, payload.courseIndex || 0);
                            case 'module':
                                return makeModulePage(payload.course, payload.module, payload.moduleIndex || 0, payload.courseIndex || 0);
                            case 'lesson':
                                return makeLessonPage(payload.course, payload.module, payload.lesson, payload.lessonIndex || 0, payload.moduleIndex || 0, payload.courseIndex || 0);
                            case 'quiz':
                                return makeQuizPage(payload.course, payload.module, payload.courseIndex || 0, payload.moduleIndex || 0);
                            case 'results':
                                return makeResultsPage(payload.course, payload.courseIndex || 0, payload.moduleIndex || 0, payload.score || 0);
                            default:
                                return makeCover(data[0]);
                        }
                    }

                    function updateNavButtons() {
                        const prevBtn = document.querySelector('[data-book-nav="prev"]');
                        const nextBtn = document.querySelector('[data-book-nav="next"]');
                        if (prevBtn) prevBtn.disabled = currentIndex <= 0;
                        if (nextBtn) nextBtn.disabled = currentIndex >= pageStack.length - 1;
                    }

                    function render() {
                        if (!pageStack.length) return;
                        const leftPage = pageStack[Math.max(0, currentIndex - 1)] || pageStack[0];
                        const rightPage = pageStack[currentIndex] || pageStack[0];
                        const leftEl = document.getElementById('bookLeftPage');
                        const rightEl = document.getElementById('bookRightPage');

                        leftEl.innerHTML = renderPageDisplay(leftPage);
                        rightEl.innerHTML = renderPageDisplay(rightPage);

                        document.getElementById('bookPageIndex').textContent = `Page ${Math.min(currentIndex + 1, pageStack.length)} / ${pageStack.length}`;
                        leftEl.classList.remove('page-flip-left', 'page-flip-right');
                        rightEl.classList.remove('page-flip-left', 'page-flip-right');
                        updateNavButtons();
                    }

                    function jumpToPage(nextIndex) {
                        if (!pageStack.length) return;
                        currentIndex = Math.max(0, Math.min(pageStack.length - 1, Number(nextIndex) || 0));
                        render();
                    }

                    function flip(direction) {
                        const target = direction === 'next' ? currentIndex + 1 : currentIndex - 1;
                        if (target < 0 || target >= pageStack.length) return;

                        const leftEl = document.getElementById('bookLeftPage');
                        const rightEl = document.getElementById('bookRightPage');
                        const active = direction === 'next' ? rightEl : leftEl;
                        active.classList.remove('page-flip-left', 'page-flip-right');
                        void active.offsetWidth;
                        active.classList.add(direction === 'next' ? 'page-flip-right' : 'page-flip-left');

                        setTimeout(() => {
                            currentIndex = target;
                            render();
                        }, 260);
                    }

                    function handleJump(target) {
                        const targetString = String(target || '');
                        if (targetString.startsWith('course:')) {
                            const idx = Number(targetString.split(':')[1]);
                            const courseStart = pageStack.findIndex((page) => page.type === 'course' && page.payload && page.payload.courseIndex === idx);
                            if (courseStart >= 0) jumpToPage(courseStart);
                            return;
                        }
                        if (targetString.startsWith('module:')) {
                            const parts = targetString.split(':');
                            const courseIndex = Number(parts[1]);
                            const moduleIndex = Number(parts[2]);
                            const pageIndex = pageStack.findIndex((page) => page.type === 'module' && page.payload && page.payload.courseIndex === courseIndex && page.payload.moduleIndex === moduleIndex);
                            if (pageIndex >= 0) jumpToPage(pageIndex);
                            return;
                        }
                        if (targetString.startsWith('lesson:')) {
                            const parts = targetString.split(':');
                            const courseIndex = Number(parts[1]);
                            const moduleIndex = Number(parts[2]);
                            const lessonIndex = Number(parts[3]);
                            const pageIndex = pageStack.findIndex((page) => page.type === 'lesson' && page.payload && page.payload.courseIndex === courseIndex && page.payload.moduleIndex === moduleIndex && page.payload.lessonIndex === lessonIndex);
                            if (pageIndex >= 0) jumpToPage(pageIndex);
                            return;
                        }
                        if (targetString.startsWith('quiz:')) {
                            const parts = targetString.split(':');
                            const courseIndex = Number(parts[1]);
                            const moduleIndex = Number(parts[2]);
                            const pageIndex = pageStack.findIndex((page) => page.type === 'quiz' && page.payload && page.payload.courseIndex === courseIndex && page.payload.moduleIndex === moduleIndex);
                            if (pageIndex >= 0) jumpToPage(pageIndex);
                            return;
                        }
                        if (targetString === 'cover') {
                            const coverPage = pageStack.findIndex((page) => page.type === 'cover');
                            if (coverPage >= 0) jumpToPage(coverPage);
                            return;
                        }
                        if (targetString === 'toc') {
                            const tocPage = pageStack.findIndex((page) => page.type === 'toc');
                            if (tocPage >= 0) jumpToPage(tocPage);
                            return;
                        }
                    }

                    function bindButtons() {
                        document.querySelectorAll('[data-book-nav]').forEach((button) => {
                            button.addEventListener('click', () => {
                                const direction = button.getAttribute('data-book-nav');
                                flip(direction === 'next' ? 'next' : 'prev');
                            });
                        });

                        document.addEventListener('click', (event) => {
                            const trigger = event.target.closest('[data-book-jump]');
                            if (trigger) {
                                handleJump(trigger.getAttribute('data-book-jump'));
                            }
                        });

                        document.addEventListener('submit', (event) => {
                            const form = event.target.closest('[data-quiz-form]');
                            if (!form) return;
                            event.preventDefault();

                            const questions = form.querySelectorAll('.book-quiz-item');
                            let correct = 0;
                            const moduleKey = form.getAttribute('data-quiz-form');
                            const moduleParts = moduleKey.split('-');
                            const courseIndex = Number(moduleParts[1]);
                            const moduleIndex = Number(moduleParts[2]);

                            questions.forEach((item, index) => {
                                const selected = form.querySelector('input[name="' + moduleKey + '-' + index + '"]:checked');
                                item.classList.remove('is-correct', 'is-wrong');
                                if (!selected) return;
                                const selectedIndex = Number(selected.value);
                                const correctAnswer = data[courseIndex]?.modules?.[moduleIndex]?.quiz?.[index]?.answer;
                                if (selectedIndex === correctAnswer) {
                                    correct += 1;
                                    item.classList.add('is-correct');
                                } else {
                                    item.classList.add('is-wrong');
                                }
                            });

                            const score = Math.round((correct / Math.max(questions.length, 1)) * 100);
                            pageStack.push({ type: 'results', payload: { course: data[courseIndex], courseIndex, moduleIndex, score } });
                            currentIndex = pageStack.length - 1;
                            render();
                        });

                        document.addEventListener('keydown', (event) => {
                            const tag = (event.target && event.target.tagName) || '';
                            if (tag === 'INPUT' || tag === 'TEXTAREA') return;
                            if (event.key === 'ArrowRight') flip('next');
                            if (event.key === 'ArrowLeft') flip('prev');
                        });
                    }

                    buildPages();
                    if (pageStack.length) {
                        currentIndex = 0;
                        bindButtons();
                        render();
                    }
                })();
            </script>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/Userpage/course/course.blade.php ENDPATH**/ ?>