<?php $__env->startSection('title', 'News & Announcements Management'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ══════════════════════════════════
   AURORA DARK TOKENS
══════════════════════════════════ */
:root {
    --n-accent:        #22E2FF;
    --n-accent-rgb:    34, 226, 255;
    --n-purple:        #8B6BFF;
    --n-purple-rgb:    139, 107, 255;
    --n-success:       #3DFFB0;
    --n-success-bg:    rgba(61,255,176,.13);
    --n-warning:       #FFB84D;
    --n-warning-bg:    rgba(255,184,77,.13);
    --n-danger:        #FF5D6C;
    --n-danger-bg:     rgba(255,93,108,.13);
    --n-bg:            var(--body-bg);
    --n-card:          var(--surface);
    --n-card2:         var(--topbar-control-bg);
    --n-border:        var(--border);
    --n-border-act:    rgba(34,226,255,.35);
    --n-text:          var(--text);
    --n-muted:         var(--muted);
    --n-muted2:        var(--muted);
    --n-radius:        14px;
    --n-radius-sm:     8px;
    --n-shadow:        0 8px 32px -8px rgba(0,0,0,.18);
    --n-ease:          cubic-bezier(.4,0,.2,1);
    --n-font:          'Inter', system-ui, sans-serif;
    --n-display:       'Space Grotesk', sans-serif;
    --n-mono:          'JetBrains Mono', monospace;
}

html[data-staff-theme="dark"] .np-wrap {
    --n-bg:            #080D1A;
    --n-card:          rgba(14,20,38,.82);
    --n-card2:         rgba(20,28,52,.70);
    --n-border:        rgba(148,197,255,.10);
    --n-border-act:    rgba(34,226,255,.35);
    --n-text:          #E7ECF9;
    --n-muted:         #8B94B3;
    --n-muted2:        #5C6584;
}

/* ─── Page wrapper ─── */
.np-wrap {
    font-family: var(--n-font);
    color: var(--n-text);
    background: var(--n-bg);
    max-width: 1380px;
    margin: 0 auto;
    padding: 28px 28px 48px;
}

/* ─── Page header ─── */
.np-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.np-header__title {
    font-family: var(--n-display);
    font-size: 1.55rem;
    font-weight: 800;
    color: var(--n-text);
    letter-spacing: -.02em;
    line-height: 1.2;
}
.np-header__sub {
    font-size: .83rem;
    color: var(--n-muted);
    margin-top: 4px;
}

/* ─── Stats row ─── */
.np-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
@media (max-width: 860px) { .np-stats { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 460px) { .np-stats { grid-template-columns: 1fr; } }

.np-stat {
    background: var(--n-card);
    border: 1px solid var(--n-border);
    border-radius: var(--n-radius);
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: border-color .2s, box-shadow .2s;
}
.np-stat:hover { border-color: var(--n-border-act); box-shadow: 0 0 0 1px var(--n-border-act); }
.np-stat__icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: grid; place-items: center;
    flex-shrink: 0;
    font-size: 1rem;
}
.np-stat__icon--cyan  { background: rgba(34,226,255,.14); color: var(--n-accent); }
.np-stat__icon--purple{ background: rgba(139,107,255,.14); color: var(--n-purple); }
.np-stat__icon--red   { background: var(--n-danger-bg); color: var(--n-danger); }
.np-stat__icon--green { background: var(--n-success-bg); color: var(--n-success); }
.np-stat__val { font-family: var(--n-mono); font-size: 1.45rem; font-weight: 700; color: var(--n-text); line-height: 1; }
.np-stat__lbl { font-size: .72rem; color: var(--n-muted); margin-top: 2px; }

/* ─── Filter / search bar ─── */
.np-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}
.np-search {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--n-card);
    border: 1px solid var(--n-border);
    border-radius: var(--n-radius-sm);
    padding: 8px 14px;
    flex: 1;
    min-width: 200px;
    transition: border-color .2s, box-shadow .2s;
}
.np-search:focus-within { border-color: var(--n-border-act); box-shadow: 0 0 0 3px rgba(34,226,255,.12); }
.np-search i { color: var(--n-muted2); font-size: .85rem; }
.np-search input {
    background: none; border: none; outline: none;
    color: var(--n-text); font-size: .84rem; font-family: var(--n-font);
    width: 100%;
}
.np-search input::placeholder { color: var(--n-muted2); }

.np-filter {
    background: var(--n-card);
    border: 1px solid var(--n-border);
    border-radius: var(--n-radius-sm);
    padding: 8px 12px;
    color: var(--n-text);
    font-size: .84rem;
    font-family: var(--n-font);
    outline: none;
    cursor: pointer;
    transition: border-color .2s;
}
.np-filter:focus { border-color: var(--n-border-act); }

/* ─── Primary Button ─── */
.np-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    border-radius: var(--n-radius-sm);
    font-size: .84rem;
    font-weight: 600;
    font-family: var(--n-font);
    cursor: pointer;
    border: none;
    transition: all .2s var(--n-ease);
    white-space: nowrap;
    text-decoration: none;
}
.np-btn--primary {
    background: linear-gradient(110deg, var(--n-accent), var(--n-purple));
    color: #06101C;
    box-shadow: 0 6px 20px -6px rgba(34,226,255,.50);
}
.np-btn--primary:hover { filter: brightness(1.1); transform: translateY(-2px); box-shadow: 0 10px 28px -6px rgba(34,226,255,.60); }
.np-btn--ghost {
    background: rgba(255,255,255,.06);
    color: var(--n-text);
    border: 1px solid var(--n-border);
}
.np-btn--ghost:hover { background: rgba(255,255,255,.10); border-color: rgba(148,197,255,.25); }
.np-btn--danger-ghost {
    background: var(--n-danger-bg);
    color: var(--n-danger);
    border: 1px solid rgba(255,93,108,.25);
}
.np-btn--danger-ghost:hover { background: rgba(255,93,108,.22); box-shadow: 0 0 0 3px rgba(255,93,108,.12); }
.np-btn--sm { padding: 6px 12px; font-size: .78rem; }

/* ─── Table card ─── */
.np-table-card {
    background: var(--n-card);
    border: 1px solid var(--n-border);
    border-radius: var(--n-radius);
    overflow: hidden;
    box-shadow: var(--n-shadow);
}
.np-table {
    width: 100%;
    border-collapse: collapse;
}
.np-table thead { background: rgba(255,255,255,.03); }
.np-table th {
    text-align: left;
    padding: 13px 16px;
    font-size: .72rem;
    font-family: var(--n-mono);
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--n-muted);
    border-bottom: 1px solid var(--n-border);
    white-space: nowrap;
}
.np-table td {
    padding: 15px 16px;
    border-bottom: 1px solid rgba(148,197,255,.05);
    color: var(--n-muted);
    font-size: .84rem;
    vertical-align: middle;
}
.np-table tr:last-child td { border-bottom: none; }
.np-table tbody tr { transition: background .15s; }
.np-table tbody tr:hover td { background: rgba(34,226,255,.04); }

/* ─── Title cell ─── */
.np-title-cell { display: flex; flex-direction: column; gap: 3px; }
.np-title-main { font-weight: 700; color: var(--n-text); font-size: .88rem; max-width: 340px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.np-title-preview { font-size: .74rem; color: var(--n-muted2); max-width: 340px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ─── Badges ─── */
.np-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 99px;
    font-size: .72rem; font-weight: 700;
    letter-spacing: .04em; text-transform: uppercase;
    white-space: nowrap;
}
.np-badge i { font-size: .62rem; }
.badge--alert    { background: var(--n-danger-bg);  color: var(--n-danger);  border: 1px solid rgba(255,93,108,.22); }
.badge--academic { background: rgba(34,226,255,.12); color: var(--n-accent); border: 1px solid rgba(34,226,255,.22); }
.badge--event    { background: rgba(139,107,255,.12);color: var(--n-purple); border: 1px solid rgba(139,107,255,.22); }
.badge--update   { background: rgba(255,255,255,.07);color: #C7CEE2;         border: 1px solid rgba(255,255,255,.10); }
.badge--featured { background: rgba(255,184,77,.12); color: var(--n-warning); border: 1px solid rgba(255,184,77,.22); }

/* ─── Audience pill ─── */
.np-audience {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(148,197,255,.12);
    border-radius: 6px;
    padding: 3px 9px;
    font-size: .75rem; color: var(--n-muted);
}
.np-audience i { font-size: .65rem; color: var(--n-accent); }

/* ─── Views chip ─── */
.np-views {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: var(--n-mono); font-size: .78rem;
    color: var(--n-muted);
}
.np-views i { font-size: .65rem; color: var(--n-muted2); }

/* ─── Action buttons ─── */
.np-actions { display: flex; align-items: center; gap: 6px; }
.np-act-btn {
    width: 32px; height: 32px;
    border-radius: var(--n-radius-sm);
    border: 1px solid var(--n-border);
    background: rgba(255,255,255,.05);
    color: var(--n-muted);
    cursor: pointer;
    display: grid; place-items: center;
    font-size: .78rem;
    transition: all .18s var(--n-ease);
}
.np-act-btn:hover { background: rgba(34,226,255,.12); color: var(--n-accent); border-color: rgba(34,226,255,.30); box-shadow: 0 0 0 3px rgba(34,226,255,.08); }
.np-act-btn.del:hover { background: var(--n-danger-bg); color: var(--n-danger); border-color: rgba(255,93,108,.30); box-shadow: 0 0 0 3px rgba(255,93,108,.08); }

/* ─── Empty state ─── */
.np-empty {
    text-align: center;
    padding: 60px 20px;
}
.np-empty-icon {
    width: 72px; height: 72px;
    border-radius: 18px;
    background: rgba(34,226,255,.08);
    border: 1px solid rgba(34,226,255,.16);
    display: grid; place-items: center;
    margin: 0 auto 18px;
    font-size: 1.8rem;
    color: var(--n-accent);
}
.np-empty h3 { font-family: var(--n-display); font-size: 1.1rem; font-weight: 700; color: var(--n-text); margin-bottom: 6px; }
.np-empty p  { font-size: .84rem; color: var(--n-muted); max-width: 320px; margin: 0 auto 20px; }

/* ─── Flash ─── */
.np-flash {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 16px;
    border-radius: var(--n-radius-sm);
    font-size: .875rem; font-weight: 600;
    margin-bottom: 20px;
    animation: npFlashIn .3s ease both;
}
@keyframes npFlashIn { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:none; } }
.np-flash--success { background: var(--n-success-bg); border: 1px solid rgba(61,255,176,.28); color: var(--n-success); }
.np-flash--error   { background: var(--n-danger-bg); border: 1px solid rgba(255,93,108,.28); color: var(--n-danger); }
.np-flash i { font-size: 1rem; flex-shrink: 0; }
.np-flash__close { margin-left: auto; background: none; border: none; color: inherit; cursor: pointer; opacity: .6; font-size: .9rem; }
.np-flash__close:hover { opacity: 1; }

/* ══════════════════════════════════
   MODAL
══════════════════════════════════ */
.np-overlay {
    position: fixed; inset: 0;
    background: rgba(6,10,22,.75);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 900;
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
    animation: npOverlayIn .22s ease both;
}
@keyframes npOverlayIn { from { opacity:0; } to { opacity:1; } }

.np-modal {
    background: var(--n-card2);
    border: 1px solid var(--n-border);
    border-radius: var(--n-radius);
    width: 100%; max-width: 640px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 24px 80px rgba(0,0,0,.70);
    animation: npModalIn .28s cubic-bezier(.16,1,.3,1) both;
    scrollbar-width: thin;
    scrollbar-color: var(--n-border) transparent;
}
.np-modal::-webkit-scrollbar { width: 5px; }
.np-modal::-webkit-scrollbar-thumb { background: var(--n-border); border-radius: 5px; }
@keyframes npModalIn { from { opacity:0; transform:translateY(20px) scale(.97); } to { opacity:1; transform:none; } }

.np-modal__head {
    display: flex; align-items: center; gap: 12px;
    padding: 22px 24px 16px;
    border-bottom: 1px solid var(--n-border);
    position: sticky; top: 0;
    background: var(--n-card2);
    z-index: 1;
}
.np-modal__icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    background: rgba(34,226,255,.12);
    border: 1px solid rgba(34,226,255,.20);
    display: grid; place-items: center;
    color: var(--n-accent); font-size: 1rem;
    flex-shrink: 0;
}
.np-modal__icon--edit { background: rgba(139,107,255,.12); border-color: rgba(139,107,255,.20); color: var(--n-purple); }
.np-modal__title { font-family: var(--n-display); font-size: 1.1rem; font-weight: 800; color: var(--n-text); }
.np-modal__sub   { font-size: .78rem; color: var(--n-muted); margin-top: 2px; }
.np-modal__close {
    margin-left: auto;
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(255,255,255,.06);
    border: 1px solid var(--n-border);
    color: var(--n-muted);
    cursor: pointer;
    display: grid; place-items: center;
    transition: all .18s;
    flex-shrink: 0;
}
.np-modal__close:hover { background: var(--n-danger-bg); color: var(--n-danger); border-color: rgba(255,93,108,.30); }

.np-modal__body { padding: 22px 24px; }

/* ─── Form fields ─── */
.np-field { margin-bottom: 18px; }
.np-field:last-child { margin-bottom: 0; }
.np-label {
    display: block;
    margin-bottom: 7px;
    font-size: .78rem;
    font-weight: 600;
    color: var(--n-muted);
    letter-spacing: .04em;
    text-transform: uppercase;
}
.np-label span { color: var(--n-danger); margin-left: 2px; }
.np-input, .np-select, .np-textarea {
    width: 100%;
    background: var(--n-bg);
    border: 1px solid var(--n-border);
    border-radius: var(--n-radius-sm);
    padding: 10px 13px;
    color: var(--n-text);
    font-size: .875rem;
    font-family: var(--n-font);
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    -webkit-appearance: none;
}
.np-input:focus, .np-select:focus, .np-textarea:focus {
    border-color: var(--n-border-act);
    box-shadow: 0 0 0 3px rgba(34,226,255,.12);
}
.np-input::placeholder, .np-textarea::placeholder { color: var(--n-muted2); }
.np-select { cursor: pointer; }
.np-select option { background: var(--n-card2); }
.np-textarea { resize: vertical; min-height: 120px; line-height: 1.6; }

.np-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media (max-width: 520px) { .np-grid-2 { grid-template-columns: 1fr; } }

/* ─── File upload ─── */
.np-upload {
    position: relative;
    display: flex; align-items: center; gap: 10px;
    background: #080D1A;
    border: 1px dashed rgba(34,226,255,.25);
    border-radius: var(--n-radius-sm);
    padding: 12px 14px;
    cursor: pointer;
    transition: border-color .2s, background .2s;
}
.np-upload:hover { border-color: var(--n-border-act); background: rgba(34,226,255,.04); }
.np-upload input[type="file"] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.np-upload i { color: var(--n-accent); font-size: .95rem; flex-shrink: 0; }
.np-upload__text { font-size: .82rem; color: var(--n-muted); }
.np-upload__text strong { color: var(--n-accent); }

/* ─── Current image preview ─── */
.np-img-preview {
    display: flex; align-items: center; gap: 10px;
    background: var(--n-card2);
    border: 1px solid var(--n-border);
    border-radius: var(--n-radius-sm);
    padding: 8px 12px;
    margin-bottom: 8px;
}
.np-img-preview img {
    width: 48px; height: 36px;
    border-radius: 6px; object-fit: cover;
    border: 1px solid var(--n-border);
}
.np-img-preview span { font-size: .78rem; color: var(--n-muted); }

/* ─── Modal footer ─── */
.np-modal__foot {
    display: flex; gap: 10px; justify-content: flex-end;
    padding: 16px 24px 22px;
    border-top: 1px solid var(--n-border);
}

/* ─── Category colour hint ─── */
.np-category-hint { font-size: .72rem; margin-top: 5px; color: var(--n-muted2); }
.hint--alert   { color: var(--n-danger); }
.hint--academic{ color: var(--n-accent); }
.hint--event   { color: var(--n-purple); }
.hint--update  { color: var(--n-muted); }

/* ─── Delete confirm ─── */
.del-modal__body { padding: 28px 24px 20px; text-align: center; }
.del-modal__body i { font-size: 2.5rem; color: var(--n-danger); margin-bottom: 12px; }
.del-modal__body h3 { font-family: var(--n-display); font-size: 1.1rem; font-weight: 800; color: var(--n-text); margin-bottom: 8px; }
.del-modal__body p { font-size: .85rem; color: var(--n-muted); max-width: 300px; margin: 0 auto; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="np-wrap" x-data="newsManager()" x-init="init()">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="np-flash np-flash--success" x-data x-init="setTimeout(() => $el.remove(), 4500)">
        <i class="fas fa-check-circle"></i>
        <span><?php echo e(session('success')); ?></span>
        <button class="np-flash__close" @click="$el.closest('.np-flash').remove()"><i class="fas fa-times"></i></button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
    <div class="np-flash np-flash--error" x-data x-init="setTimeout(() => $el.remove(), 5000)">
        <i class="fas fa-exclamation-circle"></i>
        <span><?php echo e(session('error')); ?></span>
        <button class="np-flash__close" @click="$el.closest('.np-flash').remove()"><i class="fas fa-times"></i></button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
    <div class="np-flash np-flash--error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?php echo e($errors->first()); ?></span>
        <button class="np-flash__close" @click="$el.closest('.np-flash').remove()"><i class="fas fa-times"></i></button>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="np-header">
        <div>
            <div class="np-header__title">
                <i class="fas fa-newspaper" style="color: var(--n-accent); font-size:1.2rem; margin-right:8px;"></i>
                Announcements & News
            </div>
            <div class="np-header__sub">Create, manage, and broadcast announcements to the student portal.</div>
        </div>
        <button class="np-btn np-btn--primary" @click="openCreate()">
            <i class="fas fa-plus"></i> New Announcement
        </button>
    </div>

    
    <div class="np-stats">
        <div class="np-stat">
            <div class="np-stat__icon np-stat__icon--cyan"><i class="fas fa-newspaper"></i></div>
            <div>
                <div class="np-stat__val"><?php echo e($news->count()); ?></div>
                <div class="np-stat__lbl">Total Posts</div>
            </div>
        </div>
        <div class="np-stat">
            <div class="np-stat__icon np-stat__icon--red"><i class="fas fa-bell"></i></div>
            <div>
                <div class="np-stat__val"><?php echo e($news->where('category','alert')->count()); ?></div>
                <div class="np-stat__lbl">Urgent Alerts</div>
            </div>
        </div>
        <div class="np-stat">
            <div class="np-stat__icon np-stat__icon--purple"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <div class="np-stat__val"><?php echo e($news->where('category','event')->count()); ?></div>
                <div class="np-stat__lbl">Events</div>
            </div>
        </div>
        <div class="np-stat">
            <div class="np-stat__icon np-stat__icon--green"><i class="fas fa-eye"></i></div>
            <div>
                <div class="np-stat__val"><?php echo e(number_format($news->sum('view_count'))); ?></div>
                <div class="np-stat__lbl">Total Views</div>
            </div>
        </div>
    </div>

    
    <div class="np-toolbar">
        <div class="np-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search announcements…" x-model="search" @input="filterNews()">
        </div>
        <select class="np-filter" x-model="filterCategory" @change="filterNews()">
            <option value="">All Categories</option>
            <option value="update">General Update</option>
            <option value="academic">Academic</option>
            <option value="event">Event</option>
            <option value="alert">Urgent Alert</option>
        </select>
        <select class="np-filter" x-model="filterAudience" @change="filterNews()">
            <option value="">All Audiences</option>
            <option value="all">All Students</option>
            <option value="year_1">1st Year</option>
            <option value="year_2">2nd Year</option>
            <option value="dept_it">IT Department</option>
        </select>
    </div>

    
    <div class="np-table-card">
        <table class="np-table">
            <thead>
                <tr>
                    <th>Announcement</th>
                    <th>Category</th>
                    <th>Audience</th>
                    <th>Date Posted</th>
                    <th>Views</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody id="news-tbody">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr class="np-row"
                    data-title="<?php echo e(strtolower($item->title)); ?>"
                    data-category="<?php echo e($item->category); ?>"
                    data-audience="<?php echo e($item->target_audience ?? 'all'); ?>">
                    <td>
                        <div class="np-title-cell">
                            <span class="np-title-main" title="<?php echo e($item->title); ?>"><?php echo e($item->title); ?></span>
                            <span class="np-title-preview"><?php echo e(Str::limit(strip_tags($item->content), 70)); ?></span>
                        </div>
                    </td>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->category === 'alert'): ?>
                            <span class="np-badge badge--alert"><i class="fas fa-exclamation-triangle"></i> Urgent Alert</span>
                        <?php elseif($item->category === 'academic'): ?>
                            <span class="np-badge badge--academic"><i class="fas fa-graduation-cap"></i> Academic</span>
                        <?php elseif($item->category === 'event'): ?>
                            <span class="np-badge badge--event"><i class="fas fa-calendar-star"></i> Event</span>
                        <?php else: ?>
                            <span class="np-badge badge--update"><i class="fas fa-info-circle"></i> Update</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->is_featured): ?>
                            <span class="np-badge badge--featured" style="margin-left:4px;"><i class="fas fa-star"></i> Featured</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td>
                        <span class="np-audience">
                            <i class="fas fa-users"></i>
                            <?php echo e(str_replace('_', ' ', ucfirst($item->target_audience ?? 'All'))); ?>

                        </span>
                    </td>
                    <td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->published_at): ?>
                            <span style="color:var(--n-text); font-size:.82rem;"><?php echo e($item->published_at->format('M d, Y')); ?></span>
                            <span style="display:block; font-size:.72rem; color:var(--n-muted2);"><?php echo e($item->published_at->format('h:i A')); ?></span>
                        <?php else: ?>
                            <span style="color:var(--n-muted2); font-size:.8rem;">Draft</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>
                    <td>
                        <span class="np-views"><i class="fas fa-eye"></i><?php echo e(number_format($item->view_count ?? 0)); ?></span>
                    </td>
                    <td>
                        <div class="np-actions" style="justify-content:flex-end;">
                            
                            <button class="np-act-btn" title="Edit"
                                    @click="openEdit(<?php echo e(json_encode([
                                        'id'              => $item->id,
                                        'title'           => $item->title,
                                        'category'        => $item->category,
                                        'target_audience' => $item->target_audience ?? 'all',
                                        'content'         => $item->content,
                                        'featured_image'  => $item->featured_image,
                                        'is_featured'     => $item->is_featured,
                                    ])); ?>)">
                                <i class="fas fa-pen"></i>
                            </button>
                            
                            <button class="np-act-btn del" title="Delete"
                                    @click="openDelete(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->title)); ?>')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="6">
                        <div class="np-empty">
                            <div class="np-empty-icon"><i class="fas fa-newspaper"></i></div>
                            <h3>No Announcements Yet</h3>
                            <p>Create your first announcement to broadcast information to students.</p>
                            <button class="np-btn np-btn--primary" @click="openCreate()">
                                <i class="fas fa-plus"></i> Create Announcement
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div id="no-results" style="display:none; text-align:center; padding:40px; color:var(--n-muted);">
        <i class="fas fa-search" style="font-size:1.5rem; opacity:.4; display:block; margin-bottom:10px;"></i>
        No announcements match your filters.
    </div>

    
    <template x-teleport="body">
        <div class="np-overlay" x-show="showModal" x-cloak
             x-transition:enter="npFadeIn"
             @keydown.escape.window="showModal = false"
             @click.self="showModal = false">

            <div class="np-modal" @click.stop>

                
                <div class="np-modal__head">
                    <div class="np-modal__icon" :class="isEdit ? 'np-modal__icon--edit' : ''">
                        <i :class="isEdit ? 'fas fa-pen' : 'fas fa-plus'"></i>
                    </div>
                    <div>
                        <div class="np-modal__title" x-text="isEdit ? 'Edit Announcement' : 'New Announcement'"></div>
                        <div class="np-modal__sub" x-text="isEdit ? 'Update announcement details below.' : 'Fill in the details and publish to students.'"></div>
                    </div>
                    <button class="np-modal__close" @click="showModal = false" title="Close"><i class="fas fa-times"></i></button>
                </div>

                
                <form id="news-form" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm()">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <input type="hidden" name="news_id"  id="form-news-id">

                    <div class="np-modal__body">

                        
                        <div class="np-field">
                            <label class="np-label">Title <span>*</span></label>
                            <input type="text" name="title" id="field-title"
                                   class="np-input"
                                   placeholder="e.g., System Maintenance Schedule"
                                   x-model="form.title" required>
                        </div>

                        
                        <div class="np-grid-2">
                            <div class="np-field">
                                <label class="np-label">Category <span>*</span></label>
                                <select name="category" class="np-select" x-model="form.category" required>
                                    <option value="update">General Update</option>
                                    <option value="academic">Academic</option>
                                    <option value="event">Event</option>
                                    <option value="alert">🚨 Urgent Alert</option>
                                </select>
                                <div class="np-category-hint"
                                     :class="'hint--' + form.category"
                                     x-text="categoryHint(form.category)"></div>
                            </div>
                            <div class="np-field">
                                <label class="np-label">Target Audience</label>
                                <select name="audience" class="np-select" x-model="form.audience">
                                    <option value="all">📢 All Students</option>
                                    <option value="year_1">1st Year Students</option>
                                    <option value="year_2">2nd Year Students</option>
                                    <option value="dept_it">IT Department</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="np-field">
                            <label class="np-label">Message Content <span>*</span></label>
                            <textarea name="content" class="np-textarea"
                                      placeholder="Type the full announcement details here…"
                                      x-model="form.content" required></textarea>
                        </div>

                        
                        <div class="np-field">
                            <label class="np-label">Attach Image <span style="color:var(--n-muted2); font-weight:400;">(optional)</span></label>

                            
                            <template x-if="isEdit && form.featured_image">
                                <div class="np-img-preview">
                                    <img :src="'/storage/' + form.featured_image" alt="Current image">
                                    <span>Current image — upload a new one to replace it.</span>
                                </div>
                            </template>

                            <label class="np-upload">
                                <input type="file" name="media" id="field-media" accept="image/*"
                                       @change="handleFileChange($event)">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="np-upload__text">
                                    <template x-if="!fileLabel">
                                        <span>Drag & drop or <strong>click to browse</strong> — max 5 MB</span>
                                    </template>
                                    <template x-if="fileLabel">
                                        <span>📎 <strong x-text="fileLabel"></strong></span>
                                    </template>
                                </div>
                            </label>
                        </div>

                        
                        <div class="np-field" style="display:flex; align-items:center; gap:10px;">
                            <input type="checkbox" name="is_featured" id="field-featured"
                                   :checked="form.is_featured"
                                   @change="form.is_featured = $event.target.checked"
                                   style="accent-color: var(--n-accent); width:16px; height:16px; cursor:pointer;">
                            <label for="field-featured" class="np-label" style="margin:0; text-transform:none; font-size:.84rem; cursor:pointer;">
                                Pin as <strong style="color:var(--n-warning);">Featured</strong> announcement
                            </label>
                        </div>

                    </div>

                    
                    <div class="np-modal__foot">
                        <button type="button" class="np-btn np-btn--ghost" @click="showModal = false">Cancel</button>
                        <button type="submit" class="np-btn np-btn--primary" :disabled="submitting">
                            <template x-if="submitting">
                                <i class="fas fa-spinner fa-spin"></i>
                            </template>
                            <template x-if="!submitting">
                                <i :class="isEdit ? 'fas fa-save' : 'fas fa-paper-plane'"></i>
                            </template>
                            <span x-text="submitting ? 'Saving…' : (isEdit ? 'Save Changes' : 'Publish Now')"></span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </template>

    
    <template x-teleport="body">
        <div class="np-overlay" x-show="showDelete" x-cloak
             @keydown.escape.window="showDelete = false"
             @click.self="showDelete = false">

            <div class="np-modal" style="max-width:440px;" @click.stop>
                <div class="np-modal__head">
                    <div class="np-modal__icon" style="background:var(--n-danger-bg); border-color:rgba(255,93,108,.25); color:var(--n-danger);">
                        <i class="fas fa-trash"></i>
                    </div>
                    <div>
                        <div class="np-modal__title">Delete Announcement</div>
                        <div class="np-modal__sub">This action cannot be undone.</div>
                    </div>
                    <button class="np-modal__close" @click="showDelete = false"><i class="fas fa-times"></i></button>
                </div>
                <div class="del-modal__body">
                    <p style="color:var(--n-muted); font-size:.88rem; margin-bottom:4px;">You are about to permanently delete:</p>
                    <p style="color:#fff; font-weight:700; font-size:.92rem; margin:8px 0 20px;" x-text='"\"" + deleteTitle + "\""'></p>
                </div>
                <div class="np-modal__foot">
                    <button class="np-btn np-btn--ghost" @click="showDelete = false">Cancel</button>
                    <form :action="'/staff/news/' + deleteId" method="POST" @submit="showDelete = false">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="np-btn np-btn--danger-ghost">
                            <i class="fas fa-trash"></i> Yes, Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function newsManager() {
    return {
        /* ── UI state ── */
        showModal:  false,
        showDelete: false,
        isEdit:     false,
        submitting: false,
        fileLabel:  '',

        /* ── Filter state ── */
        search:         '',
        filterCategory: '',
        filterAudience: '',

        /* ── Delete state ── */
        deleteId:    null,
        deleteTitle: '',

        /* ── Form data ── */
        form: {
            id:             null,
            title:          '',
            category:       'update',
            audience:       'all',
            content:        '',
            featured_image: null,
            is_featured:    false,
        },

        /* ── Init ── */
        init() {
            // Re-open modal with errors if validation failed
            <?php if($errors->any() && old('_method')): ?>
                this.showModal = true;
                this.isEdit = '<?php echo e(old("_method")); ?>' === 'PUT';
                this.form = {
                    id:          <?php echo e(old('news_id', 'null')); ?>,
                    title:       '<?php echo e(old("title")); ?>',
                    category:    '<?php echo e(old("category", "update")); ?>',
                    audience:    '<?php echo e(old("audience", "all")); ?>',
                    content:     `<?php echo e(old("content")); ?>`,
                    featured_image: null,
                    is_featured: <?php echo e(old("is_featured") ? 'true' : 'false'); ?>,
                };
            <?php endif; ?>
        },

        /* ── Open create ── */
        openCreate() {
            this.isEdit     = false;
            this.submitting = false;
            this.fileLabel  = '';
            this.form = { id: null, title: '', category: 'update', audience: 'all', content: '', featured_image: null, is_featured: false };
            this.showModal  = true;
        },

        /* ── Open edit ── */
        openEdit(item) {
            this.isEdit     = true;
            this.submitting = false;
            this.fileLabel  = '';
            this.form = {
                id:             item.id,
                title:          item.title,
                category:       item.category,
                audience:       item.target_audience || 'all',
                content:        item.content,
                featured_image: item.featured_image,
                is_featured:    item.is_featured || false,
            };
            this.showModal = true;
        },

        /* ── Open delete ── */
        openDelete(id, title) {
            this.deleteId    = id;
            this.deleteTitle = title;
            this.showDelete  = true;
        },

        /* ── File change ── */
        handleFileChange(e) {
            const file = e.target.files[0];
            this.fileLabel = file ? file.name : '';
        },

        /* ── Category hint ── */
        categoryHint(cat) {
            const hints = {
                update:   'Standard informational post.',
                academic: 'Academics, grades, or curriculum.',
                event:    'School events, activities, or gatherings.',
                alert:    '⚠ Push notification sent to all students.',
            };
            return hints[cat] || '';
        },

        /* ── Submit form ── */
        submitForm() {
            this.submitting = true;

            const form    = document.getElementById('news-form');
            const formData = new FormData(form);

            // Set _method and news_id hidden fields
            document.getElementById('form-method').value  = this.isEdit ? 'PUT' : 'POST';
            document.getElementById('form-news-id').value = this.form.id || '';

            // Rebuild FormData with correct hidden values
            const fd = new FormData(form);
            if (this.isEdit) {
                fd.set('_method', 'PUT');
            }

            const url = this.isEdit
                ? '/staff/news/' + this.form.id
                : '/staff/news';

            fetch(url, {
                method: 'POST',
                body:   fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
            .then(r => {
                // Laravel redirects → follow to final URL
                if (r.redirected) {
                    window.location.href = r.url;
                } else if (r.ok) {
                    window.location.reload();
                } else {
                    r.text().then(text => {
                        // Try to extract first validation error from HTML response
                        const parser   = new DOMParser();
                        const doc      = parser.parseFromString(text, 'text/html');
                        const errEl    = doc.querySelector('.np-flash--error');
                        const msgEl    = doc.querySelector('[data-val-error]');
                        alert('Server error. Please check inputs and try again.');
                        this.submitting = false;
                    });
                }
            })
            .catch(() => {
                // Fallback: plain form submit
                form.action = this.isEdit ? '/staff/news/' + this.form.id : '/staff/news';
                document.getElementById('form-method').value = this.isEdit ? 'PUT' : 'POST';
                form.submit();
            });
        },

        /* ── Client-side filter ── */
        filterNews() {
            const rows     = document.querySelectorAll('.np-row');
            const q        = this.search.toLowerCase();
            const cat      = this.filterCategory;
            const aud      = this.filterAudience;
            let   visible  = 0;

            rows.forEach(row => {
                const title    = row.dataset.title || '';
                const rowCat   = row.dataset.category || '';
                const rowAud   = row.dataset.audience || '';

                const matchQ   = !q   || title.includes(q);
                const matchCat = !cat || rowCat === cat;
                const matchAud = !aud || rowAud === aud;

                if (matchQ && matchCat && matchAud) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('no-results').style.display = visible === 0 && rows.length > 0 ? 'block' : 'none';
        },
    };
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.masters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\staff\news\index.blade.php ENDPATH**/ ?>