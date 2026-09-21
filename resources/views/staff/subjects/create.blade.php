@extends('staff.layouts.masters')

@section('title', 'Create New Subject')

@section('content')
<style>
/* ═══════════════════════════════════════════════════════
   SUBJECTS CREATE — Ultra-polished console UI
   ═══════════════════════════════════════════════════════ */
.syl-wrap {
    --bg:      var(--body-bg);
    --surface: var(--surface);
    --border:  var(--border);
    --accent:  #6366F1;
    --cyan:    #22D3EE;
    --text:    var(--text);
    --dim:     var(--muted);
    color: var(--text);
}

html[data-staff-theme="dark"] .syl-wrap {
    --bg:      #080D18;
    --surface: #0D1424;
    --border:  rgba(99,102,241,0.18);
    --text:    #E2E8F0;
    --dim:     #7C8AA5;
}

/* ambient orbs */
.syl-orb { position:fixed; pointer-events:none; border-radius:50%; filter:blur(90px); animation:orb-f 20s ease-in-out infinite alternate; }
.syl-orb-a { width:400px; height:400px; top:-100px; right:-60px; background:radial-gradient(circle,rgba(99,102,241,0.16) 0%,transparent 70%); }
.syl-orb-b { width:280px; height:280px; bottom:-40px; left:-40px; background:radial-gradient(circle,rgba(34,211,238,0.10) 0%,transparent 70%); animation-delay:-9s; }
@keyframes orb-f { from{transform:translate(0,0) scale(1);} to{transform:translate(28px,18px) scale(1.07);} }

/* page header */
.syl-heading {
    font-size:1.55rem; font-weight:800; letter-spacing:-0.02em;
    background:linear-gradient(100deg,#fff 10%,var(--cyan) 50%,var(--accent) 90%);
    -webkit-background-clip:text; background-clip:text; color:transparent;
    animation:hue-s 8s ease-in-out infinite;
}
@keyframes hue-s { 0%,100%{filter:hue-rotate(0deg) brightness(1);} 50%{filter:hue-rotate(12deg) brightness(1.15);} }
.syl-sub { font-size:0.78rem; color:var(--dim); margin-top:2px; }

/* back link */
.syl-back {
    display:inline-flex; align-items:center; gap:6px;
    font-size:0.78rem; font-weight:600; color:var(--dim);
    background:rgba(99,102,241,0.07); border:1px solid rgba(99,102,241,0.2);
    padding:0.42rem 0.9rem; border-radius:8px;
    transition:color .15s, background .15s, border-color .15s, transform .15s;
    text-decoration:none;
}
.syl-back:hover { color:var(--text); background:rgba(99,102,241,0.14); border-color:rgba(99,102,241,0.45); transform:translateY(-1px); }

/* console panel */
.syl-panel {
    position:relative;
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:20px; overflow:hidden;
    box-shadow: 0 0 0 1px rgba(99,102,241,0.05),
                0 1px 0 0 rgba(255,255,255,0.04) inset,
                0 36px 90px -24px rgba(2,6,23,0.85);
}
.syl-dotgrid {
    position:absolute; inset:0; pointer-events:none; z-index:0;
    background-image:radial-gradient(circle, rgba(99,102,241,0.11) 1px, transparent 1px);
    background-size:28px 28px;
    mask-image:radial-gradient(ellipse 90% 55% at 50% 0%, black 15%, transparent 78%);
    animation:dot-d 20s linear infinite;
}
@keyframes dot-d { from{background-position:0 0;} to{background-position:28px 28px;} }
.syl-topglow {
    position:absolute; top:0; left:0; right:0; height:1px; z-index:1;
    background:linear-gradient(90deg, transparent 5%, var(--accent) 40%, var(--cyan) 60%, transparent 95%);
    opacity:0.55;
}
.syl-scanline {
    position:absolute; top:0; left:-35%; width:35%; height:2px; z-index:2;
    background:linear-gradient(90deg, transparent, var(--cyan), transparent);
    animation:scan 3.8s ease-in-out infinite;
    filter:drop-shadow(0 0 8px var(--cyan));
}
@keyframes scan { 0%{left:-35%;} 100%{left:110%;} }
.syl-panel-content { position:relative; z-index:3; padding:1.75rem; }

/* panel toolbar */
.syl-toolbar {
    display:flex; align-items:center; justify-content:space-between;
    padding:0.7rem 1.25rem;
    border-bottom:1px solid var(--border);
}
.syl-dot-r{background:#FF5F57;} .syl-dot-y{background:#FEBC2E;} .syl-dot-g{background:#28C840;}
.syl-macdot { width:7px; height:7px; border-radius:50%; display:inline-block; }
.syl-toolbar-title { font-size:0.7rem; font-family:monospace; color:var(--dim); letter-spacing:0.08em; margin-left:8px; }

/* section badge */
.syl-sec-badge {
    display:inline-flex; align-items:center; gap:5px;
    font-size:0.67rem; font-weight:700; letter-spacing:0.09em; text-transform:uppercase;
    padding:0.18rem 0.65rem; border-radius:999px;
    background:rgba(99,102,241,0.1); color:#A5B4FC;
    border:1px solid rgba(99,102,241,0.22);
}

/* divider */
.syl-divider {
    height:1px; margin:1.75rem 0;
    background:linear-gradient(90deg, transparent, rgba(99,102,241,0.22) 30%, rgba(34,211,238,0.18) 70%, transparent);
}

/* labels & inputs */
.syl-label {
    display:block; font-size:0.68rem; font-weight:700;
    letter-spacing:0.08em; text-transform:uppercase;
    color:var(--dim); margin-bottom:0.32rem;
}
.syl-input, .syl-select, .syl-textarea {
    width:100%;
    background:rgba(8,13,24,0.6);
    border:1px solid var(--border);
    border-radius:10px; padding:0.55rem 0.85rem;
    color:var(--text); font-size:0.875rem; outline:none;
    transition:border-color .18s ease, box-shadow .18s ease, background .18s ease;
}
.syl-input:focus, .syl-select:focus, .syl-textarea:focus {
    border-color:rgba(34,211,238,0.5);
    box-shadow:0 0 0 3px rgba(34,211,238,0.09), 0 0 14px rgba(34,211,238,0.1);
    background:rgba(8,13,24,0.9);
}
.syl-input::placeholder, .syl-textarea::placeholder { color:rgba(124,138,165,0.6); }
.syl-select option { background:#0D1424; color:var(--text); }

/* field entrance */
.syl-field {
    opacity:0; transform:translateY(10px);
    animation:fi 0.35s cubic-bezier(.22,.61,.36,1) forwards;
    animation-delay:calc(var(--fi,0)*55ms);
}
@keyframes fi { to{opacity:1;transform:translateY(0);} }

/* toggle */
.syl-toggle { display:flex; align-items:center; gap:8px; cursor:pointer; user-select:none; }
.syl-toggle input[type="checkbox"] { accent-color:var(--cyan); width:15px; height:15px; cursor:pointer; }
.syl-toggle-lbl { font-size:0.85rem; }

/* error alert */
.syl-err {
    background:rgba(239,68,68,0.07); border:1px solid rgba(239,68,68,0.3);
    box-shadow:0 0 18px rgba(239,68,68,0.05);
    border-radius:10px; padding:0.85rem 1rem; color:#FCA5A5;
    animation:err-in .28s cubic-bezier(.22,.61,.36,1); margin-bottom:1.25rem;
}
@keyframes err-in { from{opacity:0;transform:translateY(-6px);} to{opacity:1;transform:translateY(0);} }

/* buttons */
.syl-btn-primary {
    position:relative; overflow:hidden;
    display:inline-flex; align-items:center; justify-content:center; gap:7px;
    background:linear-gradient(135deg, var(--accent), var(--cyan));
    color:#fff; font-weight:700; font-size:0.9rem;
    border-radius:11px; border:none; cursor:pointer;
    padding:0.75rem 1.5rem; width:100%;
    transition:transform .18s ease, box-shadow .22s ease, filter .22s ease;
    box-shadow:0 0 0 1px rgba(99,102,241,0.3) inset;
}
.syl-btn-primary::after {
    content:''; position:absolute;
    top:-50%; left:-60%; width:38%; height:200%;
    background:rgba(255,255,255,0.15); transform:skewX(-20deg);
    animation:sheen 3.8s ease-in-out infinite;
}
@keyframes sheen { 0%{left:-60%;} 55%,100%{left:130%;} }
.syl-btn-primary:hover {
    transform:translateY(-2px); filter:brightness(1.12);
    box-shadow:0 0 28px rgba(34,211,238,0.5), 0 6px 20px rgba(99,102,241,0.35);
}
.syl-btn-primary:active { transform:translateY(0); }

@media (prefers-reduced-motion:reduce) {
    .syl-orb,.syl-scanline,.syl-heading,.syl-field,.syl-btn-primary::after {
        animation:none !important; opacity:1 !important; transform:none !important;
    }
}
</style>

<div class="syl-wrap" style="position:relative; min-height:100vh; padding:1.5rem 1.5rem 3rem;">
    <div class="syl-orb syl-orb-a"></div>
    <div class="syl-orb syl-orb-b"></div>

    <div style="max-width:760px; margin:0 auto; position:relative; z-index:2;">

        <!-- Header -->
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
            <div>
                <h1 class="syl-heading">Create New Subject</h1>
                <p class="syl-sub">Fill in the details for the new subject.</p>
            </div>
            <a href="{{ route('staff.subjects.index') }}" class="syl-back">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>

        <!-- Validation errors -->
        @if($errors->any())
            <div class="syl-err">
                <ul class="list-disc list-inside text-sm" style="line-height:1.8;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <!-- Panel -->
        <div class="syl-panel">
            <div class="syl-dotgrid"></div>
            <div class="syl-topglow"></div>
            <div class="syl-scanline"></div>

            <!-- mac toolbar -->
            <div class="syl-toolbar">
                <div style="display:flex; align-items:center;">
                    <span class="syl-macdot syl-dot-r" style="margin-right:5px;"></span>
                    <span class="syl-macdot syl-dot-y" style="margin-right:5px;"></span>
                    <span class="syl-macdot syl-dot-g"></span>
                    <span class="syl-toolbar-title">subjects.create</span>
                </div>
                <span style="font-size:0.68rem; color:rgba(34,211,238,0.7); font-family:monospace; letter-spacing:0.06em;">● NEW</span>
            </div>

            <div class="syl-panel-content">
                <form action="{{ route('staff.subjects.store') }}" method="POST" id="subject-form" novalidate>
                    @csrf

                    <!-- ── Basic Info ── -->
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:1.2rem;">
                        <span class="syl-sec-badge">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Subject Information
                        </span>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="responsive-grid">
                        <div class="syl-field" style="--fi:0;">
                            <label class="syl-label" for="subject_code">Subject Code</label>
                            <input type="text" name="subject_code" id="subject_code"
                                   value="{{ old('subject_code') }}" placeholder="e.g. CS101"
                                   class="syl-input" />
                        </div>
                        <div class="syl-field" style="--fi:1;">
                            <label class="syl-label" for="title">Subject Name</label>
                            <input type="text" name="title" id="title"
                                   value="{{ old('title') }}" placeholder="Enter subject name…"
                                   class="syl-input" required/>
                        </div>
                    </div>

                    <div class="syl-field" style="--fi:2; margin-top:1rem;">
                        <label class="syl-label" for="description">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  placeholder="Brief description of this subject…"
                                  class="syl-textarea">{{ old('description') }}</textarea>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:1rem; margin-top:1rem;" class="responsive-grid">
                        <div class="syl-field" style="--fi:3;">
                            <label class="syl-label" for="units">Units</label>
                            <input type="number" name="units" id="units"
                                   value="{{ old('units') }}" class="syl-input" min="0"/>
                        </div>
                        <div class="syl-field" style="--fi:4;">
                            <label class="syl-label" for="hours">Hours</label>
                            <input type="number" name="hours" id="hours"
                                   value="{{ old('hours') }}" class="syl-input" min="0"/>
                        </div>
                        <div class="syl-field" style="--fi:5;">
                            <label class="syl-label" for="course_id">Course</label>
                            <select name="course_id" id="course_id" class="syl-select" required>
                                <option value="" disabled selected>Select course…</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="syl-field" style="--fi:6; margin-top:1.1rem;">
                        <label class="syl-toggle">
                            <input type="checkbox" name="is_active" value="1" id="is_active"
                                   {{ old('is_active', true) ? 'checked' : '' }}/>
                            <span class="syl-toggle-lbl">Active</span>
                            <span style="font-size:0.72rem; color:var(--dim);">(uncheck to archive)</span>
                        </label>
                    </div>

                    <div class="syl-divider"></div>

                    <!-- Submit -->
                    <div class="syl-field" style="--fi:7;">
                        <button type="submit" class="syl-btn-primary">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save Subject
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 640px) {
    .responsive-grid { grid-template-columns: 1fr !important; }
}
</style>
@endsection
