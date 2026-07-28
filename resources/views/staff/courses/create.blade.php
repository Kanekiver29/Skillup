@extends('staff.layouts.masters')

@section('title','Create Course')

@section('content')
<style>
    :root{
        --ccx-bg:#0b0e14;
        --ccx-surface:#131926;
        --ccx-surface-2:#1a2231;
        --ccx-border:#232d40;
        --ccx-border-soft:#1c2434;
        --ccx-cyan:#00e5ff;
        --ccx-violet:#7c5cfc;
        --ccx-text:#e7edf5;
        --ccx-muted:#889ab0;
        --ccx-success:#00f5a0;
        --ccx-error:#ff5c7c;
        --ccx-grad:linear-gradient(135deg,var(--ccx-cyan),var(--ccx-violet));
    }

    /* ---------------------------------------------------
       MODAL SHELL (this is what was missing before)
    --------------------------------------------------- */
    .ccx-modal-overlay{
        position:fixed;
        inset:0;
        z-index:1000;
        display:none;
        align-items:flex-start;
        justify-content:center;
        padding:4vh 1.25rem;
        overflow-y:auto;
        background:rgba(6,9,15,.72);
        backdrop-filter:blur(6px);
        -webkit-backdrop-filter:blur(6px);
    }
    .ccx-modal-overlay.is-open{display:flex;}
    body.ccx-modal-lock{overflow:hidden;}

    .ccx-page{
        font-family:'Inter',system-ui,sans-serif;
        color:var(--ccx-text);
        background:
            radial-gradient(circle at 15% 0%, rgba(124,92,252,.12), transparent 45%),
            radial-gradient(circle at 85% 20%, rgba(0,229,255,.10), transparent 40%),
            var(--ccx-bg);
        border-radius:18px;
        padding:2rem 2rem 2.25rem;
        width:100%;
        max-width:1040px;
        margin:auto;
        box-shadow:0 30px 80px -20px rgba(0,0,0,.65), 0 0 0 1px rgba(0,229,255,.06);
        position:relative;
        max-height:92vh;
        display:flex;
        flex-direction:column;
    }
    .ccx-page *{box-sizing:border-box;}

    .ccx-modal-close{
        position:absolute;
        top:1.1rem;
        right:1.1rem;
        width:34px;height:34px;
        border-radius:9px;
        border:1px solid var(--ccx-border);
        background:rgba(255,255,255,.03);
        color:var(--ccx-muted);
        font-size:1.1rem;
        line-height:1;
        cursor:pointer;
        display:flex;
        align-items:center;
        justify-content:center;
        transition:color .15s ease, border-color .15s ease, background .15s ease;
        z-index:2;
    }
    .ccx-modal-close:hover{color:var(--ccx-text);border-color:#37455e;background:rgba(255,255,255,.06);}

    .ccx-scroll-body{
        overflow-y:auto;
        padding-right:.35rem;
        margin-right:-.35rem;
    }
    .ccx-scroll-body::-webkit-scrollbar{width:8px;}
    .ccx-scroll-body::-webkit-scrollbar-thumb{background:var(--ccx-border);border-radius:99px;}
    .ccx-scroll-body::-webkit-scrollbar-track{background:transparent;}

    /* ---------------------------------------------------
       ORIGINAL STYLES
    --------------------------------------------------- */
    .ccx-eyebrow{
        font-family:'JetBrains Mono',monospace;
        letter-spacing:.18em;
        font-size:.72rem;
        color:var(--ccx-cyan);
        margin:0 0 .6rem;
        text-transform:uppercase;
    }
    .ccx-header{padding-right:2.5rem;}
    .ccx-header h1{
        font-family:'Space Grotesk','Inter',sans-serif;
        font-size:1.9rem;
        font-weight:700;
        margin:0 0 .5rem;
        background:var(--ccx-grad);
        -webkit-background-clip:text;
        background-clip:text;
        color:transparent;
        display:inline-block;
    }
    .ccx-sub{color:var(--ccx-muted);margin:0 0 1.5rem;max-width:60ch;line-height:1.5;}

    .ccx-alert{
        border-radius:12px;
        padding:.9rem 1.1rem;
        margin-bottom:1.5rem;
        font-size:.92rem;
        border:1px solid;
        line-height:1.5;
    }
    .ccx-alert--success{background:rgba(0,245,160,.08);border-color:rgba(0,245,160,.35);color:var(--ccx-success);}
    .ccx-alert--error{background:rgba(255,92,124,.08);border-color:rgba(255,92,124,.35);color:var(--ccx-error);}
    .ccx-alert--error ul{margin:.4rem 0 0 1.1rem;padding:0;}

    .ccx-grid{
        display:grid;
        grid-template-columns:1.6fr 1fr;
        gap:1.75rem;
        align-items:start;
    }
    @media (max-width:820px){
        .ccx-grid{grid-template-columns:1fr;}
    }

    .ccx-card{
        background:linear-gradient(180deg,var(--ccx-surface),var(--ccx-surface-2));
        border:1px solid var(--ccx-border);
        border-radius:16px;
        padding:1.5rem 1.5rem 1.25rem;
        margin-bottom:1.25rem;
        position:relative;
        overflow:hidden;
    }
    .ccx-card::before{
        content:"";
        position:absolute;
        inset:0 0 auto 0;
        height:2px;
        background:var(--ccx-grad);
        opacity:.7;
    }
    .ccx-tag{
        font-family:'JetBrains Mono',monospace;
        font-size:.68rem;
        letter-spacing:.16em;
        text-transform:uppercase;
        color:var(--ccx-muted);
        margin:0 0 1.1rem;
        display:flex;
        align-items:center;
        gap:.5rem;
    }
    .ccx-tag::before{
        content:"";
        width:6px;height:6px;border-radius:50%;
        background:var(--ccx-cyan);
        box-shadow:0 0 8px var(--ccx-cyan);
    }

    .ccx-field{margin-bottom:1.1rem;}
    .ccx-field:last-child{margin-bottom:0;}
    .ccx-field label{
        display:block;
        font-size:.85rem;
        font-weight:600;
        margin-bottom:.4rem;
        color:var(--ccx-text);
    }
    .ccx-field .req{color:var(--ccx-cyan);}
    .ccx-field .opt{
        font-family:'JetBrains Mono',monospace;
        font-size:.68rem;
        color:var(--ccx-muted);
        font-weight:400;
        margin-left:.4rem;
        text-transform:uppercase;
        letter-spacing:.08em;
    }

    .ccx-input, .ccx-select, .ccx-textarea{
        width:100%;
        background:rgba(255,255,255,.03);
        border:1px solid var(--ccx-border-soft);
        color:var(--ccx-text);
        border-radius:10px;
        padding:.7rem .85rem;
        font-size:.92rem;
        font-family:inherit;
        transition:border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .ccx-input::placeholder, .ccx-textarea::placeholder{color:#5a6b82;}
    .ccx-input:hover, .ccx-select:hover, .ccx-textarea:hover{border-color:#2e3a52;}
    .ccx-input:focus, .ccx-select:focus, .ccx-textarea:focus{
        outline:none;
        border-color:var(--ccx-cyan);
        box-shadow:0 0 0 3px rgba(0,229,255,.15);
        background:rgba(255,255,255,.045);
    }
    .ccx-textarea{min-height:110px;resize:vertical;}
    .ccx-select{appearance:none;background-image:linear-gradient(45deg,transparent 50%,var(--ccx-muted) 50%),linear-gradient(135deg,var(--ccx-muted) 50%,transparent 50%);background-position:calc(100% - 18px) calc(1.1em),calc(100% - 13px) calc(1.1em);background-size:5px 5px,5px 5px;background-repeat:no-repeat;}

    .ccx-field-foot{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:.35rem;
        min-height:1rem;
    }
    .ccx-count{
        font-family:'JetBrains Mono',monospace;
        font-size:.7rem;
        color:var(--ccx-muted);
    }
    .ccx-error{
        font-size:.76rem;
        color:var(--ccx-error);
    }

    .was-validated .ccx-input:invalid,
    .was-validated .ccx-select:invalid,
    .was-validated .ccx-textarea:invalid{
        border-color:var(--ccx-error);
        box-shadow:0 0 0 3px rgba(255,92,124,.15);
    }

    .ccx-checkrow{
        display:flex;
        align-items:center;
        gap:.65rem;
        background:rgba(255,255,255,.02);
        border:1px solid var(--ccx-border-soft);
        border-radius:10px;
        padding:.85rem 1rem;
    }
    .ccx-checkrow input{
        width:19px;height:19px;
        accent-color:var(--ccx-cyan);
        cursor:pointer;
    }
    .ccx-checkrow label{margin:0;font-size:.88rem;cursor:pointer;}
    .ccx-checkrow .ccx-hint{color:var(--ccx-muted);font-size:.78rem;display:block;margin-top:.1rem;}

    .ccx-actions{
        display:flex;
        gap:.85rem;
        margin-top:.5rem;
        position:sticky;
        bottom:0;
        background:linear-gradient(0deg, var(--ccx-bg) 60%, transparent);
        padding-top:.75rem;
    }
    .ccx-btn{
        font-family:inherit;
        font-weight:600;
        font-size:.9rem;
        border-radius:10px;
        padding:.75rem 1.5rem;
        border:1px solid transparent;
        cursor:pointer;
        transition:transform .12s ease, box-shadow .15s ease, opacity .15s ease;
        display:inline-flex;
        align-items:center;
        gap:.5rem;
    }
    .ccx-btn:active{transform:translateY(1px);}
    .ccx-btn-primary{
        background:var(--ccx-grad);
        color:#06090f;
        box-shadow:0 8px 24px -8px rgba(0,229,255,.45);
    }
    .ccx-btn-primary:hover{box-shadow:0 10px 28px -6px rgba(124,92,252,.55);}
    .ccx-btn-primary:disabled{opacity:.6;cursor:not-allowed;transform:none;}
    .ccx-btn-ghost{
        background:transparent;
        border-color:var(--ccx-border);
        color:var(--ccx-muted);
    }
    .ccx-btn-ghost:hover{color:var(--ccx-text);border-color:#37455e;}

    .ccx-spinner{
        width:14px;height:14px;
        border-radius:50%;
        border:2px solid rgba(6,9,15,.35);
        border-top-color:#06090f;
        animation:ccx-spin .7s linear infinite;
        display:none;
    }
    @keyframes ccx-spin{to{transform:rotate(360deg);}}

    /* preview panel */
    .ccx-preview{position:sticky;top:0;}
    .ccx-meter{
        background:linear-gradient(180deg,var(--ccx-surface),var(--ccx-surface-2));
        border:1px solid var(--ccx-border);
        border-radius:16px;
        padding:1.25rem 1.4rem;
        margin-bottom:1.25rem;
    }
    .ccx-meter-top{
        display:flex;
        justify-content:space-between;
        align-items:baseline;
        margin-bottom:.6rem;
    }
    .ccx-meter-label{
        font-family:'JetBrains Mono',monospace;
        font-size:.68rem;
        letter-spacing:.14em;
        text-transform:uppercase;
        color:var(--ccx-muted);
    }
    .ccx-meter-pct{
        font-family:'Space Grotesk',sans-serif;
        font-weight:700;
        font-size:1.05rem;
        color:var(--ccx-cyan);
    }
    .ccx-meter-track{
        height:7px;
        border-radius:99px;
        background:rgba(255,255,255,.06);
        overflow:hidden;
    }
    .ccx-meter-fill{
        height:100%;
        width:0%;
        border-radius:99px;
        background:var(--ccx-grad);
        transition:width .35s ease;
    }

    .ccx-holo{
        border-radius:18px;
        border:1px solid var(--ccx-border);
        background:linear-gradient(180deg,var(--ccx-surface),#0e1420);
        overflow:hidden;
        position:relative;
        box-shadow:0 0 0 1px rgba(0,229,255,.05), 0 20px 45px -20px rgba(0,0,0,.6);
    }
    .ccx-holo::after{
        content:"";
        position:absolute;inset:0;
        pointer-events:none;
        background:repeating-linear-gradient(0deg, rgba(255,255,255,.025) 0px, rgba(255,255,255,.025) 1px, transparent 1px, transparent 3px);
        animation:ccx-scan 6s linear infinite;
        opacity:.5;
    }
    @keyframes ccx-scan{
        0%{transform:translateY(0);}
        100%{transform:translateY(30px);}
    }
    .ccx-holo-media{
        height:140px;
        background:var(--ccx-bg);
        display:flex;
        align-items:center;
        justify-content:center;
        border-bottom:1px solid var(--ccx-border);
        position:relative;
    }
    .ccx-holo-media img{width:100%;height:100%;object-fit:cover;display:none;}
    .ccx-holo-media .ccx-placeholder{
        color:var(--ccx-muted);
        font-family:'JetBrains Mono',monospace;
        font-size:.7rem;
        letter-spacing:.1em;
        text-align:center;
    }
    .ccx-holo-body{padding:1.1rem 1.2rem 1.3rem;position:relative;z-index:1;}
    .ccx-holo-badges{display:flex;gap:.4rem;flex-wrap:wrap;margin-bottom:.6rem;}
    .ccx-badge{
        font-family:'JetBrains Mono',monospace;
        font-size:.65rem;
        letter-spacing:.05em;
        text-transform:uppercase;
        padding:.2rem .55rem;
        border-radius:99px;
        border:1px solid var(--ccx-border-soft);
        color:var(--ccx-muted);
    }
    .ccx-badge--live{color:var(--ccx-cyan);border-color:rgba(0,229,255,.35);}
    .ccx-holo-title{
        font-family:'Space Grotesk',sans-serif;
        font-size:1.15rem;
        font-weight:700;
        margin:0 0 .35rem;
        line-height:1.3;
        word-break:break-word;
    }
    .ccx-holo-desc{
        font-size:.82rem;
        color:var(--ccx-muted);
        line-height:1.5;
        margin:0 0 .8rem;
        word-break:break-word;
    }
    .ccx-holo-meta{
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-top:1px dashed var(--ccx-border);
        padding-top:.7rem;
        font-size:.78rem;
    }
    .ccx-holo-instructor{color:var(--ccx-text);font-weight:600;}
    .ccx-holo-instructor small{display:block;color:var(--ccx-muted);font-weight:400;}
    .ccx-holo-duration{
        font-family:'JetBrains Mono',monospace;
        color:var(--ccx-cyan);
    }

    @media (prefers-reduced-motion: reduce){
        .ccx-holo::after{animation:none;}
        .ccx-spinner{animation:none;}
    }
</style>

{{-- Trigger button lives on the list page normally; kept here too so this file works standalone --}}
<button type="button" class="ccx-btn ccx-btn-primary" data-course-modal-open style="margin-bottom:1rem;">
    + Add New Course
</button>

<div class="ccx-modal-overlay" id="createCourseModal" data-course-modal-root aria-hidden="true">
    <div class="ccx-page" role="dialog" aria-modal="true" aria-labelledby="ccxModalTitle">
        <button type="button" class="ccx-modal-close" data-course-modal-close aria-label="Close">&times;</button>

        <div class="ccx-scroll-body">
            <div class="ccx-header">
                <p class="ccx-eyebrow">Staff / Courses / New</p>
                <h1 id="ccxModalTitle">Create Course</h1>
                <p class="ccx-sub">Fill in the details below. The panel on the right mirrors your course in real time before you publish it.</p>
            </div>

            @if(session('success'))
                <div class="ccx-alert ccx-alert--success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="ccx-alert ccx-alert--error">
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="ccx-grid">
                <form method="POST" action="{{ route('staff.courses.store') }}" class="ccx-form" id="courseForm" novalidate>
                    @csrf

                    <section class="ccx-card">
                        <p class="ccx-tag">Basics</p>

                        <div class="ccx-field">
                            <label for="title">Title <span class="req">*</span></label>
                            <input id="title" name="title" class="ccx-input" maxlength="150"
                                   value="{{ old('title') }}" placeholder="e.g. Advanced React Patterns" required data-track data-count>
                            <div class="ccx-field-foot">
                                <span class="ccx-count" data-count-display="title">0/150</span>
                                @error('title')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="ccx-field">
                            <label for="short_description">Short description <span class="opt">optional</span></label>
                            <input id="short_description" name="short_description" class="ccx-input" maxlength="200"
                                   value="{{ old('short_description') }}" placeholder="One line that sells the course" data-track data-count>
                            <div class="ccx-field-foot">
                                <span class="ccx-count" data-count-display="short_description">0/200</span>
                                @error('short_description')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="ccx-field">
                            <label for="description">Description <span class="opt">optional</span></label>
                            <textarea id="description" name="description" class="ccx-textarea"
                                      placeholder="What will students learn? Structure, outcomes, prerequisites..." data-track>{{ old('description') }}</textarea>
                            <div class="ccx-field-foot">
                                @error('description')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </section>

                    <section class="ccx-card">
                        <p class="ccx-tag">Media &amp; Classification</p>

                        <div class="ccx-field">
                            <label for="image_url">Image URL <span class="opt">optional</span></label>
                            <input id="image_url" name="image_url" type="url" class="ccx-input"
                                   value="{{ old('image_url') }}" placeholder="https://..." data-track>
                            <div class="ccx-field-foot">
                                @error('image_url')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="ccx-field">
                            <label for="category">Category <span class="req">*</span></label>
                            <input id="category" name="category" class="ccx-input" list="category-suggestions"
                                   value="{{ old('category') }}" placeholder="e.g. Web Development" required data-track>
                            <datalist id="category-suggestions">
                                <option value="Web Development">
                                <option value="Data Science">
                                <option value="Design">
                                <option value="Business">
                                <option value="Mobile Development">
                                <option value="Cloud &amp; DevOps">
                                <option value="Cybersecurity">
                            </datalist>
                            <div class="ccx-field-foot">
                                @error('category')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="ccx-field">
                            <label for="level">Level</label>
                            <select id="level" name="level" class="ccx-select" data-track>
                                @php $levels = ['Beginner','Intermediate','Advanced']; @endphp
                                @foreach($levels as $lvl)
                                    <option value="{{ $lvl }}" @selected(old('level', 'Beginner') == $lvl)>{{ $lvl }}</option>
                                @endforeach
                            </select>
                            <div class="ccx-field-foot">
                                @error('level')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="ccx-field">
                            <label for="duration_hours">Duration (hours) <span class="opt">optional</span></label>
                            <input id="duration_hours" name="duration_hours" type="number" step="0.1" min="0" max="1000"
                                   class="ccx-input" value="{{ old('duration_hours') }}" placeholder="e.g. 6.5" data-track>
                            <div class="ccx-field-foot">
                                @error('duration_hours')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </section>

                    <section class="ccx-card">
                        <p class="ccx-tag">Instructor</p>

                        <div class="ccx-field">
                            <label for="instructor_name">Instructor name <span class="opt">optional</span></label>
                            <input id="instructor_name" name="instructor_name" class="ccx-input"
                                   value="{{ old('instructor_name') }}" placeholder="e.g. Dana Alvarez" data-track>
                            <div class="ccx-field-foot">
                                @error('instructor_name')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="ccx-field">
                            <label for="instructor_title">Instructor title <span class="opt">optional</span></label>
                            <input id="instructor_title" name="instructor_title" class="ccx-input"
                                   value="{{ old('instructor_title') }}" placeholder="e.g. Senior Frontend Engineer" data-track>
                            <div class="ccx-field-foot">
                                @error('instructor_title')<span class="ccx-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </section>

                    <section class="ccx-card">
                        <p class="ccx-tag">Publishing</p>
                        <div class="ccx-checkrow">
                            <input type="checkbox" name="is_published" value="1" id="published" @checked(old('is_published'))>
                            <div>
                                <label for="published">Publish immediately</label>
                                <span class="ccx-hint">Leave unchecked to save this course as a draft.</span>
                            </div>
                        </div>
                    </section>

                    <div class="ccx-actions">
                        <button type="button" class="ccx-btn ccx-btn-ghost" data-course-modal-close>Cancel</button>
                        <button type="submit" class="ccx-btn ccx-btn-primary" id="submitBtn">
                            <span class="ccx-spinner" id="submitSpinner"></span>
                            <span id="submitLabel">Create course</span>
                        </button>
                    </div>
                </form>

                <aside class="ccx-preview">
                    <div class="ccx-meter">
                        <div class="ccx-meter-top">
                            <span class="ccx-meter-label">Course integrity</span>
                            <span class="ccx-meter-pct" id="meterPct">0%</span>
                        </div>
                        <div class="ccx-meter-track">
                            <div class="ccx-meter-fill" id="meterFill"></div>
                        </div>
                    </div>

                    <div class="ccx-holo">
                        <div class="ccx-holo-media" id="previewMediaWrap">
                            <img id="previewImage" alt="Course preview">
                            <span class="ccx-placeholder" id="previewPlaceholder">No image yet<br>add an image URL</span>
                        </div>
                        <div class="ccx-holo-body">
                            <div class="ccx-holo-badges">
                                <span class="ccx-badge" id="previewCategory">Category</span>
                                <span class="ccx-badge" id="previewLevel">Beginner</span>
                                <span class="ccx-badge ccx-badge--live">Live preview</span>
                            </div>
                            <h3 class="ccx-holo-title" id="previewTitle">Untitled course</h3>
                            <p class="ccx-holo-desc" id="previewDesc">Your short description will appear here.</p>
                            <div class="ccx-holo-meta">
                                <div class="ccx-holo-instructor" id="previewInstructor">
                                    Instructor TBD
                                    <small id="previewInstructorTitle"></small>
                                </div>
                                <div class="ccx-holo-duration" id="previewDuration">-- hrs</div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    var overlay = document.getElementById('createCourseModal');
    var form = document.getElementById('courseForm');
    var lastFocused = null;

    function openModal(){
        lastFocused = document.activeElement;
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.classList.add('ccx-modal-lock');
        var firstInput = document.getElementById('title');
        if(firstInput) firstInput.focus();
    }
    function closeModal(){
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('ccx-modal-lock');
        if(lastFocused) lastFocused.focus();
    }

    // open triggers: any element with data-course-modal-open (put this attribute
    // on the "Add New Course" button in the courses list page)
    document.querySelectorAll('[data-course-modal-open]').forEach(function(btn){
        btn.addEventListener('click', openModal);
    });

    // close triggers: X button, Cancel button, clicking the backdrop, Escape key
    document.querySelectorAll('[data-course-modal-close]').forEach(function(btn){
        btn.addEventListener('click', closeModal);
    });
    overlay.addEventListener('click', function(e){
        if(e.target === overlay) closeModal();
    });
    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape' && overlay.classList.contains('is-open')) closeModal();
    });

    // if the page rendered with validation errors (server round-trip after a
    // failed submit), auto-open the modal so the user sees their errors
    var hasServerErrors = {{ $errors->any() ? 'true' : 'false' }};
    if(hasServerErrors) openModal();

    // expose a small API in case other scripts need to open/close it too
    window.CourseModal = { open: openModal, close: closeModal };

    // character counters
    document.querySelectorAll('[data-count]').forEach(function(field){
        var counter = document.querySelector('[data-count-display="' + field.id + '"]');
        if(!counter) return;
        var max = field.getAttribute('maxlength') || 0;
        function update(){ counter.textContent = field.value.length + '/' + max; }
        field.addEventListener('input', update);
        update();
    });

    // live preview + integrity meter
    var trackedIds = ['title','short_description','description','image_url','category','level','duration_hours','instructor_name','instructor_title'];
    var previewTitle = document.getElementById('previewTitle');
    var previewDesc = document.getElementById('previewDesc');
    var previewCategory = document.getElementById('previewCategory');
    var previewLevel = document.getElementById('previewLevel');
    var previewInstructor = document.getElementById('previewInstructor');
    var previewInstructorTitle = document.getElementById('previewInstructorTitle');
    var previewDuration = document.getElementById('previewDuration');
    var previewImage = document.getElementById('previewImage');
    var previewPlaceholder = document.getElementById('previewPlaceholder');
    var meterFill = document.getElementById('meterFill');
    var meterPct = document.getElementById('meterPct');

    function val(id){
        var el = document.getElementById(id);
        return el ? el.value.trim() : '';
    }

    function renderPreview(){
        previewTitle.textContent = val('title') || 'Untitled course';
        previewDesc.textContent = val('short_description') || val('description') || 'Your short description will appear here.';
        previewCategory.textContent = val('category') || 'Category';
        previewLevel.textContent = val('level') || 'Beginner';

        var iName = val('instructor_name');
        var iTitle = val('instructor_title');
        previewInstructor.childNodes[0].nodeValue = iName || 'Instructor TBD';
        previewInstructorTitle.textContent = iTitle;

        var dur = val('duration_hours');
        previewDuration.textContent = dur ? (dur + ' hrs') : '-- hrs';

        var img = val('image_url');
        if(img){
            previewImage.src = img;
            previewImage.onload = function(){
                previewImage.style.display = 'block';
                previewPlaceholder.style.display = 'none';
            };
            previewImage.onerror = function(){
                previewImage.style.display = 'none';
                previewPlaceholder.style.display = 'block';
                previewPlaceholder.innerHTML = 'Image failed to load<br>check the URL';
            };
        } else {
            previewImage.style.display = 'none';
            previewImage.removeAttribute('src');
            previewPlaceholder.style.display = 'block';
            previewPlaceholder.innerHTML = 'No image yet<br>add an image URL';
        }

        var filled = trackedIds.filter(function(id){ return val(id).length > 0; }).length;
        var pct = Math.round((filled / trackedIds.length) * 100);
        meterFill.style.width = pct + '%';
        meterPct.textContent = pct + '%';
    }

    trackedIds.forEach(function(id){
        var el = document.getElementById(id);
        if(el){ el.addEventListener('input', renderPreview); el.addEventListener('change', renderPreview); }
    });
    renderPreview();

    // submit state + validation styling
    var submitBtn = document.getElementById('submitBtn');
    var submitSpinner = document.getElementById('submitSpinner');
    var submitLabel = document.getElementById('submitLabel');

    form.addEventListener('submit', function(e){
        if(!form.checkValidity()){
            form.classList.add('was-validated');
            return;
        }
        submitBtn.disabled = true;
        submitSpinner.style.display = 'inline-block';
        submitLabel.textContent = 'Creating course...';
    });
})();
</script>
@endsection