@extends('staff.layouts.masters')

@section('title', 'Create Lesson')

@section('content')
<div class="lf-page">

    {{-- ambient background layer --}}
    <div class="lf-bg" aria-hidden="true">
        <div class="lf-bg-grid"></div>
        <div class="lf-bg-orb lf-bg-orb--cyan"></div>
        <div class="lf-bg-orb lf-bg-orb--violet"></div>
        <div class="lf-bg-scan"></div>
    </div>

    <div class="lf-wrap">

        {{-- header --}}
        <div class="lf-header">
            <div class="lf-eyebrow">
                <span class="lf-eyebrow-dot"></span>
                STAFF&nbsp;/&nbsp;CONTENT&nbsp;PIPELINE
            </div>
            <h1 class="lf-title">Lesson <span>Forge</span></h1>
            <p class="lf-subtitle">Compose a new lesson and route it directly into its module. Every field below feeds the course build.</p>
        </div>

        @if ($errors->any())
            <div class="lf-alert">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div>
                    <strong>Transmission blocked</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="lf-shell">

            {{-- progress spine (desktop) --}}
            <aside class="lf-spine" aria-hidden="true">
                <div class="lf-spine-track"></div>
                <div class="lf-spine-progress" id="lfSpineProgress"></div>

                <div class="lf-node" data-node="1">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Course&nbsp;Link</span>
                </div>
                <div class="lf-node" data-node="2">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Lesson&nbsp;Details</span>
                </div>
                <div class="lf-node" data-node="3">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Content&nbsp;Payload</span>
                </div>
                <div class="lf-node" data-node="4">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Parameters</span>
                </div>
                <div class="lf-node lf-node--deploy" data-node="5">
                    <span class="lf-node-dot"><span class="lf-node-core"></span></span>
                    <span class="lf-node-label">Deploy</span>
                </div>
            </aside>

            {{-- mobile progress bar --}}
            <div class="lf-mobile-progress" aria-hidden="true">
                <div class="lf-mobile-progress-fill" id="lfMobileProgress"></div>
            </div>

            <form method="POST" action="{{ route('staff.lessons.store') }}" class="lf-panel" id="lfForm" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- SECTION 1 : COURSE + MODULE --}}
                <section class="lf-section" data-section="1" style="--d:0">
                    <div class="lf-section-head">
                        <span class="lf-section-index">01</span>
                        <div>
                            <h2>Course Link</h2>
                            <p>Attach this lesson to its parent course and module.</p>
                        </div>
                    </div>

                    <div class="lf-grid lf-grid--2">
                        <div class="lf-field">
                            <label class="lf-label" for="course_id">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                Course
                            </label>
                            <div class="lf-select-wrap">
                                <select id="course_id" name="course_id" class="lf-select" required>
                                    <option value="" disabled selected hidden>Select a course&hellip;</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                <svg class="lf-select-chevron" viewBox="0 0 24 24" fill="none"><path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>

                        <div class="lf-field">
                            <label class="lf-label" for="module_id">
                                <svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/><rect x="13" y="4" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/><rect x="4" y="13" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/><rect x="13" y="13" width="7" height="7" rx="1.4" stroke="currentColor" stroke-width="1.6"/></svg>
                                Module
                            </label>
                            <div class="lf-select-wrap">
                                <select id="module_id" name="module_id" class="lf-select" required>
                                    <option value="" disabled selected hidden>Select a module&hellip;</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->title }}</option>
                                    @endforeach
                                </select>
                                <svg class="lf-select-chevron" viewBox="0 0 24 24" fill="none"><path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- SECTION 2 : TITLE + DESCRIPTION --}}
                <section class="lf-section" data-section="2" style="--d:1">
                    <div class="lf-section-head">
                        <span class="lf-section-index">02</span>
                        <div>
                            <h2>Lesson Details</h2>
                            <p>The title and a short summary students will see first.</p>
                        </div>
                    </div>

                    <div class="lf-field">
                        <label class="lf-label" for="lesson_title">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h10M4 18h16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            Title
                        </label>
                        <input type="text" id="lesson_title" name="lesson_title" class="lf-input" placeholder="e.g. Introduction to Variables" required>
                        <span class="lf-underline"></span>
                    </div>

                    <div class="lf-field">
                        <div class="lf-label-row">
                            <label class="lf-label" for="lesson_description">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                                Description
                            </label>
                            <span class="lf-counter" data-counter-for="lesson_description">0 / 300</span>
                        </div>
                        <textarea id="lesson_description" name="lesson_description" maxlength="300" class="lf-input lf-textarea" placeholder="A one or two sentence overview of what this lesson covers&hellip;"></textarea>
                        <span class="lf-underline"></span>
                    </div>
                </section>

                {{-- SECTION 3 : CONTENT --}}
                <section class="lf-section" data-section="3" style="--d:2">
                    <div class="lf-section-head">
                        <span class="lf-section-index">03</span>
                        <div>
                            <h2>Content Payload</h2>
                            <p>The full lesson body, markdown, or a resource link.</p>
                        </div>
                    </div>

                    <div class="lf-field">
                        <div class="lf-label-row">
                            <label class="lf-label" for="lesson_content">
                                <svg viewBox="0 0 24 24" fill="none"><path d="m8 9-4 3 4 3M16 9l4 3-4 3M13 5l-2 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Content
                            </label>
                            <span class="lf-counter" data-counter-for="lesson_content">0 characters</span>
                        </div>
                        <textarea id="lesson_content" name="lesson_content" class="lf-input lf-textarea lf-textarea--code" placeholder="Full lesson content or resource URL (required by database)" required></textarea>
                        <span class="lf-underline"></span>
                        <p class="lf-hint">Tip &mdash; paste a video transcript, structured markdown, or a direct resource URL. This field is required by the database.</p>
                    </div>
                </section>

                {{-- SECTION 4 : METADATA --}}
                <section class="lf-section" data-section="4" style="--d:3">
                    <div class="lf-section-head">
                        <span class="lf-section-index">04</span>
                        <div>
                            <h2>Parameters</h2>
                            <p>Timing, ordering, and media reference for this lesson.</p>
                        </div>
                    </div>

                    <div class="lf-grid lf-grid--3">
                        <div class="lf-field">
                            <label class="lf-label" for="lesson_duration">
                                <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.6"/><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Duration&nbsp;<em>(min)</em>
                            </label>
                            <input type="number" id="lesson_duration" name="lesson_duration" class="lf-input lf-input--mono" min="0" placeholder="0">
                            <span class="lf-underline"></span>
                        </div>

                        <div class="lf-field">
                            <label class="lf-label" for="lesson_order">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M7 4v16m0-16 3.5 3.5M7 4 3.5 7.5M17 20V4m0 16-3.5-3.5M17 20l3.5-3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Order
                            </label>
                            <input type="number" id="lesson_order" name="lesson_order" class="lf-input lf-input--mono" min="0" placeholder="0">
                            <span class="lf-underline"></span>
                        </div>

                        <div class="lf-field">
                            <label class="lf-label" for="lesson_video_url">
                                <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="14" height="12" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m21 8-4 3 4 3V8Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                                Video&nbsp;URL
                            </label>
                            <input type="url" id="lesson_video_url" name="lesson_video_url" class="lf-input" placeholder="https://">
                            <span class="lf-underline"></span>
                        </div>
                    </div>

                    <div class="lf-field">
                        <label class="lf-label" for="lesson_image">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 13l2.5 3 3.5-4.5 4.5 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="9" r="1" fill="currentColor"/></svg>
                            Lesson Image
                        </label>
                        <input type="file" id="lesson_image" name="lesson_image" class="lf-input" accept="image/*">
                        <span class="lf-underline"></span>
                        <p class="lf-hint">Optional lesson cover image (JPEG, PNG, GIF, WEBP).</p>
                    </div>
                </section>

                {{-- SUBMIT --}}
                <div class="lf-submit-row" style="--d:4">
                    <p class="lf-submit-note">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4.5 8-11V5l-8-3-8 3v6c0 6.5 8 11 8 11Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        Saved lessons are attached to the selected module immediately.
                    </p>
                    <button type="submit" class="lf-submit" id="lfSubmit">
                        <span class="lf-submit-label">Deploy Lesson</span>
                        <svg class="lf-submit-arrow" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span class="lf-submit-spinner"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* ============ tokens ============ */
    .lf-page{
        --lf-bg-deep:#0a0e1a;
        --lf-bg-panel:#111827e6;
        --lf-bg-panel-solid:#0f1524;
        --lf-line:#26304a;
        --lf-cyan:#22e2ff;
        --lf-violet:#8b6bff;
        --lf-mint:#3dffb0;
        --lf-text:#e7ecf9;
        --lf-text-dim:#8b94b3;
        --lf-danger:#ff5d6c;
        --lf-radius:18px;
        position:relative;
        isolation:isolate;
        border-radius:28px;
        overflow:hidden;
        background:var(--lf-bg-deep);
        color:var(--lf-text);
        font-family:'Inter',system-ui,-apple-system,sans-serif;
        padding:1px;
        box-shadow:0 30px 80px -30px rgba(0,0,0,.6), 0 0 0 1px #1c2338;
    }
    .lf-page *{box-sizing:border-box;}
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    /* ============ background ambience ============ */
    .lf-bg{position:absolute;inset:0;z-index:0;overflow:hidden;}
    .lf-bg-grid{
        position:absolute;inset:-1px;
        background-image:
            linear-gradient(#182038 1px,transparent 1px),
            linear-gradient(90deg,#182038 1px,transparent 1px);
        background-size:42px 42px;
        opacity:.35;
        mask-image:radial-gradient(ellipse 80% 60% at 50% 0%, #000 40%, transparent 90%);
    }
    .lf-bg-orb{position:absolute;border-radius:50%;filter:blur(70px);opacity:.35;animation:lf-float 16s ease-in-out infinite;}
    .lf-bg-orb--cyan{width:420px;height:420px;background:var(--lf-cyan);top:-160px;left:-100px;}
    .lf-bg-orb--violet{width:460px;height:460px;background:var(--lf-violet);bottom:-200px;right:-120px;animation-delay:-8s;}
    @keyframes lf-float{
        0%,100%{transform:translate(0,0) scale(1);}
        50%{transform:translate(30px,-25px) scale(1.08);}
    }
    .lf-bg-scan{
        position:absolute;left:0;right:0;height:120px;
        background:linear-gradient(180deg,transparent, rgba(34,226,255,.06), transparent);
        animation:lf-scan 7s linear infinite;
    }
    @keyframes lf-scan{
        0%{top:-120px;}
        100%{top:110%;}
    }

    /* ============ layout ============ */
    .lf-wrap{position:relative;z-index:1;padding:44px 40px 56px;}
    @media (max-width:768px){ .lf-wrap{padding:28px 18px 40px;} }

    .lf-header{margin-bottom:34px;animation:lf-rise .6s ease both;}
    .lf-eyebrow{
        display:inline-flex;align-items:center;gap:8px;
        font-family:'JetBrains Mono',monospace;font-size:11px;letter-spacing:.16em;
        color:var(--lf-cyan);margin-bottom:14px;font-weight:500;
    }
    .lf-eyebrow-dot{width:6px;height:6px;border-radius:50%;background:var(--lf-cyan);box-shadow:0 0 10px 2px var(--lf-cyan);animation:lf-pulse 1.8s ease-in-out infinite;}
    @keyframes lf-pulse{0%,100%{opacity:1;}50%{opacity:.35;}}
    .lf-title{
        font-family:'Space Grotesk',sans-serif;font-weight:600;
        font-size:clamp(28px,4vw,40px);letter-spacing:-.01em;margin:0 0 10px;
    }
    .lf-title span{
        background:linear-gradient(100deg,var(--lf-cyan),var(--lf-violet));
        -webkit-background-clip:text;background-clip:text;color:transparent;
    }
    .lf-subtitle{color:var(--lf-text-dim);font-size:15px;max-width:520px;line-height:1.55;margin:0;}

    .lf-alert{
        display:flex;gap:12px;align-items:flex-start;
        background:rgba(255,93,108,.08);border:1px solid rgba(255,93,108,.35);
        color:#ffc2c9;padding:14px 16px;border-radius:14px;margin-bottom:26px;
        animation:lf-rise .4s ease both;
    }
    .lf-alert svg{width:20px;height:20px;flex-shrink:0;color:var(--lf-danger);margin-top:1px;}
    .lf-alert strong{display:block;color:#fff;font-size:14px;margin-bottom:4px;}
    .lf-alert ul{margin:0;padding-left:18px;font-size:13px;line-height:1.6;}

    .lf-shell{display:grid;grid-template-columns:200px 1fr;gap:36px;align-items:start;}
    @media (max-width:900px){ .lf-shell{grid-template-columns:1fr;} }

    /* ============ spine ============ */
    .lf-spine{position:sticky;top:24px;padding:8px 0 8px 4px;display:flex;flex-direction:column;gap:46px;}
    @media (max-width:900px){ .lf-spine{display:none;} }
    .lf-spine-track,.lf-spine-progress{
        position:absolute;left:15px;top:8px;bottom:8px;width:2px;border-radius:2px;
    }
    .lf-spine-track{background:var(--lf-line);}
    .lf-spine-progress{
        height:0%;background:linear-gradient(180deg,var(--lf-cyan),var(--lf-violet));
        box-shadow:0 0 12px 1px rgba(34,226,255,.6);
        transition:height .5s cubic-bezier(.4,0,.2,1);
    }
    .lf-node{display:flex;align-items:center;gap:14px;position:relative;z-index:1;}
    .lf-node-dot{
        width:32px;height:32px;border-radius:50%;flex-shrink:0;
        background:var(--lf-bg-panel-solid);border:2px solid var(--lf-line);
        display:flex;align-items:center;justify-content:center;
        transition:border-color .4s ease, box-shadow .4s ease;
    }
    .lf-node-core{width:8px;height:8px;border-radius:50%;background:var(--lf-line);transition:background .4s ease, box-shadow .4s ease, transform .4s ease;}
    .lf-node-label{font-size:12.5px;color:var(--lf-text-dim);font-weight:500;letter-spacing:.02em;transition:color .4s ease;}
    .lf-node.is-active .lf-node-dot{border-color:var(--lf-cyan);box-shadow:0 0 16px -2px rgba(34,226,255,.7);}
    .lf-node.is-active .lf-node-core{background:var(--lf-cyan);box-shadow:0 0 8px 1px var(--lf-cyan);transform:scale(1.15);}
    .lf-node.is-active .lf-node-label{color:var(--lf-text);}
    .lf-node--deploy.is-active .lf-node-dot{border-color:var(--lf-mint);box-shadow:0 0 16px -2px rgba(61,255,176,.7);}
    .lf-node--deploy.is-active .lf-node-core{background:var(--lf-mint);box-shadow:0 0 8px 1px var(--lf-mint);}

    .lf-mobile-progress{display:none;height:3px;border-radius:3px;background:var(--lf-line);margin-bottom:24px;overflow:hidden;}
    @media (max-width:900px){ .lf-mobile-progress{display:block;} }
    .lf-mobile-progress-fill{height:100%;width:0%;background:linear-gradient(90deg,var(--lf-cyan),var(--lf-violet));transition:width .5s cubic-bezier(.4,0,.2,1);}

    /* ============ panel & sections ============ */
    .lf-panel{
        background:linear-gradient(180deg,rgba(255,255,255,.03),rgba(255,255,255,0)),var(--lf-bg-panel);
        border:1px solid #1e2740;border-radius:var(--lf-radius);
        padding:36px 36px 30px;backdrop-filter:blur(14px);
        display:flex;flex-direction:column;gap:34px;
    }
    @media (max-width:640px){ .lf-panel{padding:24px 18px;} }

    .lf-section{animation:lf-rise .6s ease both;animation-delay:calc(var(--d) * .08s);}
    .lf-section + .lf-section{padding-top:30px;border-top:1px dashed #1e2740;}
    .lf-section-head{display:flex;gap:14px;align-items:flex-start;margin-bottom:20px;}
    .lf-section-index{
        font-family:'JetBrains Mono',monospace;font-size:12px;color:var(--lf-cyan);
        border:1px solid rgba(34,226,255,.35);border-radius:8px;padding:3px 7px;line-height:1;margin-top:3px;
    }
    .lf-section-head h2{font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:600;margin:0 0 4px;}
    .lf-section-head p{margin:0;font-size:13px;color:var(--lf-text-dim);}

    .lf-grid{display:grid;gap:20px;}
    .lf-grid--2{grid-template-columns:1fr 1fr;}
    .lf-grid--3{grid-template-columns:repeat(3,1fr);}
    @media (max-width:640px){ .lf-grid--2,.lf-grid--3{grid-template-columns:1fr;} }

    .lf-field{position:relative;display:flex;flex-direction:column;gap:8px;}
    .lf-label-row{display:flex;align-items:center;justify-content:space-between;}
    .lf-label{
        display:flex;align-items:center;gap:7px;font-size:12.5px;font-weight:600;
        letter-spacing:.03em;text-transform:uppercase;color:var(--lf-text-dim);
    }
    .lf-label svg{width:14px;height:14px;color:var(--lf-cyan);flex-shrink:0;}
    .lf-label em{font-style:normal;color:#5c6584;text-transform:none;font-weight:400;}
    .lf-counter{font-family:'JetBrains Mono',monospace;font-size:11px;color:#5c6584;}

    .lf-input,.lf-select{
        width:100%;background:#0c111f;border:1px solid #232c46;color:var(--lf-text);
        border-radius:10px;padding:11px 14px;font-size:14.5px;font-family:inherit;
        outline:none;transition:border-color .25s ease, box-shadow .25s ease, background .25s ease;
    }
    .lf-input::placeholder{color:#4a5273;}
    .lf-input--mono{font-family:'JetBrains Mono',monospace;}
    .lf-textarea{resize:vertical;min-height:88px;line-height:1.6;}
    .lf-textarea--code{min-height:150px;font-family:'JetBrains Mono',monospace;font-size:13px;}

    .lf-input:hover,.lf-select:hover{border-color:#33406a;}
    .lf-input:focus,.lf-select:focus{
        border-color:var(--lf-cyan);
        background:#0c111f;
        box-shadow:0 0 0 3px rgba(34,226,255,.14), 0 0 18px -4px rgba(34,226,255,.5);
    }
    .lf-underline{
        display:block;height:2px;border-radius:2px;background:linear-gradient(90deg,var(--lf-cyan),var(--lf-violet));
        transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.4,0,.2,1);margin-top:-6px;
    }
    .lf-field:focus-within .lf-underline{transform:scaleX(1);}

    .lf-field.lf-field--invalid .lf-input,
    .lf-field.lf-field--invalid .lf-select{
        border-color:var(--lf-danger);
        box-shadow:0 0 0 3px rgba(255,93,108,.14);
    }

    .lf-select-wrap{position:relative;}
    .lf-select{appearance:none;-webkit-appearance:none;cursor:pointer;padding-right:38px;}
    .lf-select-chevron{
        position:absolute;right:13px;top:50%;transform:translateY(-50%);
        width:16px;height:16px;color:var(--lf-text-dim);pointer-events:none;transition:transform .25s ease, color .25s ease;
    }
    .lf-select-wrap:focus-within .lf-select-chevron{transform:translateY(-50%) rotate(180deg);color:var(--lf-cyan);}
    .lf-select option{background:#0c111f;color:var(--lf-text);}

    .lf-hint{margin:2px 0 0;font-size:12px;color:#5c6584;line-height:1.5;}

    /* ============ submit ============ */
    .lf-submit-row{
        display:flex;align-items:center;justify-content:space-between;gap:20px;
        padding-top:26px;border-top:1px dashed #1e2740;
        animation:lf-rise .6s ease both;animation-delay:calc(var(--d) * .08s);
    }
    @media (max-width:640px){ .lf-submit-row{flex-direction:column-reverse;align-items:stretch;} }
    .lf-submit-note{display:flex;align-items:center;gap:8px;font-size:12.5px;color:var(--lf-text-dim);margin:0;}
    .lf-submit-note svg{width:15px;height:15px;color:var(--lf-mint);flex-shrink:0;}

    .lf-submit{
        position:relative;display:inline-flex;align-items:center;gap:10px;
        background:linear-gradient(100deg,var(--lf-cyan),var(--lf-violet));
        color:#06101c;font-weight:700;font-size:14.5px;letter-spacing:.01em;
        border:none;border-radius:12px;padding:13px 22px;cursor:pointer;
        box-shadow:0 8px 24px -8px rgba(34,226,255,.55);
        transition:transform .2s ease, box-shadow .2s ease, filter .2s ease;
        overflow:hidden;white-space:nowrap;
    }
    .lf-submit:hover{transform:translateY(-2px);box-shadow:0 12px 30px -8px rgba(139,107,255,.6);filter:brightness(1.05);}
    .lf-submit:active{transform:translateY(0);}
    .lf-submit-arrow{width:17px;height:17px;transition:transform .25s ease;}
    .lf-submit:hover .lf-submit-arrow{transform:translateX(4px);}
    .lf-submit-spinner{
        display:none;width:15px;height:15px;border-radius:50%;
        border:2px solid rgba(6,16,28,.35);border-top-color:#06101c;
        animation:lf-spin .7s linear infinite;
    }
    .lf-submit.is-loading .lf-submit-arrow{display:none;}
    .lf-submit.is-loading .lf-submit-spinner{display:inline-block;}
    @keyframes lf-spin{to{transform:rotate(360deg);}}

    @keyframes lf-rise{
        from{opacity:0;transform:translateY(14px);}
        to{opacity:1;transform:translateY(0);}
    }

    @media (prefers-reduced-motion:reduce){
        .lf-page *{animation-duration:.01ms !important;animation-iteration-count:1 !important;transition-duration:.01ms !important;}
    }
</style>

<script>
    (function(){
        const form = document.getElementById('lfForm');
        if(!form) return;

        const sections = Array.from(form.querySelectorAll('.lf-section'));
        const totalSteps = sections.length + 1; // +1 for the deploy node
        const spineProgress = document.getElementById('lfSpineProgress');
        const mobileProgress = document.getElementById('lfMobileProgress');
        const nodes = Array.from(document.querySelectorAll('.lf-node'));
        const submitBtn = document.getElementById('lfSubmit');

        function sectionIsFilled(section){
            const fields = Array.from(section.querySelectorAll('input[required], select[required], textarea[required], input:not([required]), select:not([required]), textarea:not([required])'));
            const required = fields.filter(f => f.hasAttribute('required'));
            const toCheck = required.length ? required : fields;
            if(!toCheck.length) return false;
            return toCheck.every(f => String(f.value || '').trim().length > 0);
        }

        function updateProgress(){
            let filled = 0;
            sections.forEach((section, i) => {
                const ok = sectionIsFilled(section);
                if(ok) filled++;
                const node = nodes[i];
                if(node) node.classList.toggle('is-active', ok);
            });

            const deployNode = nodes[nodes.length - 1];
            const allDone = filled === sections.length;
            if(deployNode) deployNode.classList.toggle('is-active', allDone);
            if(allDone) filled++;

            const pct = (filled / totalSteps) * 100;
            if(spineProgress) spineProgress.style.height = pct + '%';
            if(mobileProgress) mobileProgress.style.width = pct + '%';
        }

        form.addEventListener('input', updateProgress);
        form.addEventListener('change', updateProgress);
        updateProgress();

        // gentle inline validation styling (no alerts, just glow)
        Array.from(form.querySelectorAll('.lf-input, .lf-select')).forEach(function(field){
            field.addEventListener('invalid', function(){
                const wrap = field.closest('.lf-field');
                if(wrap) wrap.classList.add('lf-field--invalid');
            });
            field.addEventListener('input', function(){
                const wrap = field.closest('.lf-field');
                if(wrap && field.checkValidity()) wrap.classList.remove('lf-field--invalid');
            });
        });

        // live character counters
        Array.from(form.querySelectorAll('[data-counter-for]')).forEach(function(counterEl){
            const targetId = counterEl.getAttribute('data-counter-for');
            const target = document.getElementById(targetId);
            if(!target) return;
            const suffix = counterEl.textContent.includes('/') ? ('/' + counterEl.textContent.split('/')[1].trim()) : ' characters';
            const maxAttr = target.getAttribute('maxlength');
            function render(){
                counterEl.textContent = maxAttr ? (target.value.length + ' ' + suffix) : (target.value.length + suffix);
            }
            target.addEventListener('input', render);
            render();
        });

        // submit micro-interaction
        form.addEventListener('submit', function(){
            if(submitBtn) submitBtn.classList.add('is-loading');
        });
    })();
</script>
@endsection