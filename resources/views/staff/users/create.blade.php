@extends('staff.layouts.masters')
@section('title','Add User')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
    .amc {
        --amc-void: var(--body-bg);
        --amc-panel: var(--surface);
        --amc-panel-soft: var(--topbar-control-bg);
        --amc-line: var(--border);
        --amc-line-bright: rgba(129,140,248,0.45);
        --amc-cyan: #5eead4;
        --amc-violet: #8b7cf6;
        --amc-text: var(--text);
        --amc-muted: var(--muted);
        --amc-success: #34d399;
        --amc-warning: #fbbf24;
        --amc-danger: #fb7185;
        --amc-font-display: 'Space Grotesk', sans-serif;
        --amc-font-body: 'Inter', sans-serif;
        --amc-font-mono: 'JetBrains Mono', monospace;

        background: var(--amc-void);
        color: var(--amc-text);
        font-family: var(--amc-font-body);
        border-radius: 16px;
        padding: 28px;
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }

    .amc::before {
        content: '';
        position: absolute; inset: 0; z-index: -2;
        background:
            radial-gradient(circle at 12% -10%, rgba(139,124,246,0.16), transparent 42%),
            radial-gradient(circle at 100% 10%, rgba(94,234,212,0.10), transparent 40%);
    }
    .amc::after {
        content: '';
        position: absolute; inset: 0; z-index: -1;
        background-image:
            linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
        background-size: 34px 34px;
        mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 30%, transparent 75%);
    }

    .amc-back {
        display: inline-flex; align-items: center; gap: 6px;
        font-family: var(--amc-font-mono); font-size: 12px;
        color: var(--amc-muted); text-decoration: none;
        margin-bottom: 14px; transition: color .15s ease, gap .15s ease;
    }
    .amc-back:hover { color: var(--amc-cyan); gap: 9px; }

    .amc-eyebrow {
        font-family: var(--amc-font-mono);
        font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase;
        color: var(--amc-cyan);
        display: flex; align-items: center; gap: 8px;
    }
    .amc-eyebrow .dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--amc-cyan);
        box-shadow: 0 0 0 3px rgba(94,234,212,0.15);
        animation: amc-pulse 2.2s ease-in-out infinite;
    }

    .amc-header { display: flex; align-items: center; gap: 16px; margin: 2px 0 26px; flex-wrap: wrap; }
    .amc-avatar-lg {
        width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--amc-font-display); font-weight: 600; font-size: 18px; color: #06120f;
        background: linear-gradient(135deg, #5c6478, #3c4256);
        box-shadow: 0 8px 24px -8px rgba(94,234,212,0.25);
        transition: background .3s ease;
    }
    .amc-title {
        font-family: var(--amc-font-display); font-weight: 700; font-size: 28px; letter-spacing: -0.01em;
        background: linear-gradient(120deg, #ffffff 10%, var(--amc-cyan) 60%, var(--amc-violet) 100%);
        -webkit-background-clip: text; background-clip: text; color: transparent;
        margin: 2px 0 2px;
    }
    .amc-subtitle { color: var(--amc-muted); font-size: 13px; font-family: var(--amc-font-mono); }

    .amc-panel {
        position: relative;
        background: linear-gradient(180deg, var(--amc-panel), var(--amc-panel-soft));
        border: 1px solid var(--amc-line);
        border-radius: 14px;
        padding: 26px;
    }
    .amc-panel .corner { position: absolute; width: 16px; height: 16px; border: 2px solid var(--amc-cyan); opacity: .6; }
    .amc-panel .corner.tl { top: -1px; left: -1px; border-right: none; border-bottom: none; border-top-left-radius: 12px; }
    .amc-panel .corner.tr { top: -1px; right: -1px; border-left: none; border-bottom: none; border-top-right-radius: 12px; }
    .amc-panel .corner.bl { bottom: -1px; left: -1px; border-right: none; border-top: none; border-bottom-left-radius: 12px; }
    .amc-panel .corner.br { bottom: -1px; right: -1px; border-left: none; border-top: none; border-bottom-right-radius: 12px; }

    .amc-section-label {
        font-family: var(--amc-font-mono); font-size: 10.5px; letter-spacing: 0.14em; text-transform: uppercase;
        color: var(--amc-muted);
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 18px;
    }
    .amc-section-label::after { content: ''; flex: 1; height: 1px; background: var(--amc-line); }

    .amc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 20px; }
    @media (max-width: 720px) { .amc-grid { grid-template-columns: 1fr; } }

    .amc-field { display: flex; flex-direction: column; gap: 7px; }
    .amc-label {
        font-family: var(--amc-font-mono); font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase;
        color: var(--amc-muted);
        display: flex; align-items: center; gap: 6px;
    }
    .amc-label svg { opacity: .7; }

    .amc-input-shell { position: relative; }
    .amc-input, .amc-select {
        width: 100%;
        font-family: var(--amc-font-body); font-size: 13.5px;
        background: var(--amc-void);
        border: 1px solid var(--amc-line);
        color: var(--amc-text);
        border-radius: 9px;
        padding: 11px 13px;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
        appearance: none;
    }
    .amc-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23838da3' stroke-width='2.4'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 13px center;
        padding-right: 34px;
    }
    .amc-input[type="password"] { padding-right: 40px; }
    .amc-input:hover, .amc-select:hover { border-color: var(--amc-line-bright); }
    .amc-input:focus, .amc-select:focus {
        outline: none; border-color: var(--amc-cyan); background: var(--surface);
        box-shadow: 0 0 0 3px rgba(94,234,212,0.12);
    }
    .amc-input.has-error, .amc-select.has-error { border-color: var(--amc-danger); }
    .amc-input.has-error:focus, .amc-select.has-error:focus { box-shadow: 0 0 0 3px rgba(251,113,133,0.14); }

    .amc-error {
        font-family: var(--amc-font-mono); font-size: 11.5px; color: var(--amc-danger);
        display: flex; align-items: center; gap: 5px;
    }

    .amc-toggle-visibility {
        position: absolute; right: 4px; top: 50%; transform: translateY(-50%);
        width: 30px; height: 30px; border-radius: 7px; border: none;
        background: transparent; color: var(--amc-muted); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: color .15s ease, background .15s ease;
    }
    .amc-toggle-visibility:hover { color: var(--amc-cyan); background: rgba(94,234,212,0.08); }

    /* password strength */
    .amc-strength { margin-top: 8px; }
    .amc-strength-track {
        height: 4px; border-radius: 3px; background: var(--amc-line); overflow: hidden;
        display: flex; gap: 3px;
    }
    .amc-strength-seg {
        flex: 1; background: var(--amc-line); border-radius: 2px; transition: background .25s ease;
    }
    .amc-strength-label {
        font-family: var(--amc-font-mono); font-size: 10.5px; margin-top: 5px; color: var(--amc-muted);
        transition: color .2s ease;
    }

    .amc-actions {
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;
        margin-top: 26px; padding-top: 20px; border-top: 1px solid var(--amc-line);
    }
    .amc-actions-left { display: flex; gap: 10px; flex-wrap: wrap; }

    .amc-btn {
        font-family: var(--amc-font-body); font-weight: 600; font-size: 13.5px;
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 18px; border-radius: 9px; border: 1px solid transparent;
        cursor: pointer; transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease, background .16s ease;
        text-decoration: none; white-space: nowrap;
    }
    .amc-btn:focus-visible { outline: 2px solid var(--amc-cyan); outline-offset: 2px; }
    .amc-btn--primary {
        color: #06120f;
        background: linear-gradient(135deg, var(--amc-cyan), #7ef0d8);
        box-shadow: 0 4px 18px -6px rgba(94,234,212,0.55);
    }
    .amc-btn--primary:hover { transform: translateY(-1px); box-shadow: 0 6px 22px -6px rgba(94,234,212,0.75); }
    .amc-btn--primary:disabled { opacity: .7; cursor: default; transform: none; }
    .amc-btn--ghost {
        color: var(--amc-text); background: rgba(255,255,255,0.02); border-color: var(--amc-line-bright);
    }
    .amc-btn--ghost:hover { border-color: var(--amc-violet); background: rgba(139,124,246,0.08); transform: translateY(-1px); }

    html[data-staff-theme="dark"] .amc {
        --amc-void: #090c12;
        --amc-panel: #10141d;
        --amc-panel-soft: #131826;
        --amc-line: #212739;
        --amc-line-bright: #384260;
        --amc-text: #e8ebf4;
        --amc-muted: #838da3;
    }

    .amc-spinner {
        width: 13px; height: 13px; border-radius: 50%;
        border: 2px solid rgba(6,18,15,0.25); border-top-color: #06120f;
        animation: amc-spin .7s linear infinite; display: none;
    }
    .amc-btn--primary.is-loading .amc-spinner { display: inline-block; }
    .amc-btn--primary.is-loading .amc-btn-label { opacity: .85; }

    @keyframes amc-pulse { 0%, 100% { opacity: 1; } 50% { opacity: .45; } }
    @keyframes amc-spin { to { transform: rotate(360deg); } }

    @media (prefers-reduced-motion: reduce) {
        .amc-eyebrow .dot, .amc-spinner { animation: none; }
        .amc-btn, .amc-back, .amc-input, .amc-select, .amc-avatar-lg, .amc-strength-seg { transition: none; }
    }
</style>

<div class="amc">
    <a href="{{ route('staff.users.index') }}" class="amc-back">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Back to users
    </a>

    <div class="amc-header">
        <div class="amc-avatar-lg" id="amc-avatar-preview">?</div>
        <div>
            <div class="amc-eyebrow"><span class="dot"></span> Access Control / New Record</div>
            <h1 class="amc-title">Add user</h1>
            <p class="amc-subtitle">Create a staff account and set its initial access.</p>
        </div>
    </div>

    <form action="{{ route('staff.users.store') }}" method="POST" id="amc-create-form" class="amc-panel">
        <div class="corner tl"></div><div class="corner tr"></div>
        <div class="corner bl"></div><div class="corner br"></div>
        @csrf

        <div class="amc-section-label">Identity</div>
        <div class="amc-grid" style="margin-bottom: 26px;">
            <div class="amc-field">
                <label class="amc-label" for="name">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Full name
                </label>
                <input id="name" name="name" value="{{ old('name') }}" class="amc-input @error('name') has-error @enderror" autocomplete="off">
                @error('name')<span class="amc-error"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
            </div>
            <div class="amc-field">
                <label class="amc-label" for="email">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg>
                    Email
                </label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="amc-input @error('email') has-error @enderror" autocomplete="off">
                @error('email')<span class="amc-error"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
            </div>
            <div class="amc-field">
                <label class="amc-label" for="username">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M4 20V10l8-6 8 6v10"/><path d="M9 20v-6h6v6"/></svg>
                    Username
                </label>
                <input id="username" name="username" value="{{ old('username') }}" class="amc-input @error('username') has-error @enderror" autocomplete="off">
                @error('username')<span class="amc-error"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
            </div>
            <div class="amc-field">
                <label class="amc-label" for="department">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M3 21h18M6 21V7l6-4 6 4v14M9 9h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                    Department
                </label>
                <input id="department" name="department" value="{{ old('department') }}" class="amc-input @error('department') has-error @enderror" autocomplete="off">
                @error('department')<span class="amc-error"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="amc-section-label">Access &amp; assignment</div>
        <div class="amc-grid" style="margin-bottom: 26px;">
            <div class="amc-field">
                <label class="amc-label" for="role">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 2 3 7v6c0 5 4 9 9 9s9-4 9-9V7l-9-5z"/></svg>
                    Role
                </label>
                <select id="role" name="role" class="amc-select @error('role') has-error @enderror">
                    @foreach($roles as $r)
                        <option value="{{ $r }}" {{ old('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
                @error('role')<span class="amc-error"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
            </div>
            <div class="amc-field">
                <label class="amc-label" for="assigned_course_id">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Assign course <span style="text-transform:none;color:var(--amc-muted);font-family:var(--amc-font-body);">(optional)</span>
                </label>
                <select id="assigned_course_id" name="assigned_course_id" class="amc-select @error('assigned_course_id') has-error @enderror">
                    <option value="">-- none --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ (int) old('assigned_course_id') === $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                    @endforeach
                </select>
                @error('assigned_course_id')<span class="amc-error"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="amc-section-label">Security</div>
        <div class="amc-grid">
            <div class="amc-field">
                <label class="amc-label" for="password">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Password
                </label>
                <div class="amc-input-shell">
                    <input id="password" name="password" type="password" class="amc-input @error('password') has-error @enderror" autocomplete="new-password">
                    <button type="button" class="amc-toggle-visibility" data-target="password" aria-label="Show password">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')<span class="amc-error"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                <div class="amc-strength">
                    <div class="amc-strength-track">
                        <div class="amc-strength-seg" data-seg="0"></div>
                        <div class="amc-strength-seg" data-seg="1"></div>
                        <div class="amc-strength-seg" data-seg="2"></div>
                        <div class="amc-strength-seg" data-seg="3"></div>
                    </div>
                    <div class="amc-strength-label" id="amc-strength-label">Enter a password</div>
                </div>
            </div>
            <div class="amc-field">
                <label class="amc-label" for="password_confirmation">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M9 12l2 2 4-4"/><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Confirm password
                </label>
                <div class="amc-input-shell">
                    <input id="password_confirmation" name="password_confirmation" type="password" class="amc-input" autocomplete="new-password">
                    <button type="button" class="amc-toggle-visibility" data-target="password_confirmation" aria-label="Show password">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                <div class="amc-hint" id="amc-match-hint" style="font-size:11.5px;color:var(--amc-muted);margin-top:8px;">Must match the password above</div>
            </div>
        </div>

        <div class="amc-actions">
            <div class="amc-actions-left">
                <button type="submit" class="amc-btn amc-btn--primary" id="amc-save-btn">
                    <span class="amc-spinner"></span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                    <span class="amc-btn-label">Create user</span>
                </button>
                <a href="{{ route('staff.users.index') }}" class="amc-btn amc-btn--ghost">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script>
    (function () {
        // live avatar preview, derived the same way as the index/edit pages (hash -> hue)
        var nameInput = document.getElementById('name');
        var avatar = document.getElementById('amc-avatar-preview');

        function hashHue(str) {
            var hash = 0;
            for (var i = 0; i < str.length; i++) {
                hash = (hash * 31 + str.charCodeAt(i)) >>> 0;
            }
            return hash % 360;
        }

        function updateAvatar() {
            var val = nameInput.value.trim();
            if (!val) {
                avatar.textContent = '?';
                avatar.style.background = 'linear-gradient(135deg, #5c6478, #3c4256)';
                return;
            }
            var initials = val.split(/\s+/).map(function (p) { return p.charAt(0); }).slice(0, 2).join('').toUpperCase();
            var hue = hashHue(val);
            avatar.textContent = initials;
            avatar.style.background = 'linear-gradient(135deg, hsl(' + hue + ',75%,68%), hsl(' + ((hue + 50) % 360) + ',75%,60%))';
        }
        nameInput.addEventListener('input', updateAvatar);
        updateAvatar();

        // password strength meter (client-side hint only, does not block submission)
        var passwordInput = document.getElementById('password');
        var segs = document.querySelectorAll('.amc-strength-seg');
        var strengthLabel = document.getElementById('amc-strength-label');
        var colors = ['#fb7185', '#fb7185', '#fbbf24', '#34d399', '#5eead4'];
        var labels = ['Enter a password', 'Weak', 'Fair', 'Good', 'Strong'];

        function scorePassword(pw) {
            if (!pw) return 0;
            var score = 0;
            if (pw.length >= 8) score++;
            if (pw.length >= 12) score++;
            if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++;
            if (/[0-9]/.test(pw)) score++;
            if (/[^A-Za-z0-9]/.test(pw)) score++;
            return Math.min(score, 4);
        }

        function updateStrength() {
            var score = scorePassword(passwordInput.value);
            segs.forEach(function (seg, i) {
                seg.style.background = i < score ? colors[score] : 'var(--amc-line)';
            });
            strengthLabel.textContent = labels[score];
            strengthLabel.style.color = score === 0 ? 'var(--amc-muted)' : colors[score];
        }
        passwordInput.addEventListener('input', updateStrength);

        // confirm-password live match hint
        var confirmInput = document.getElementById('password_confirmation');
        var matchHint = document.getElementById('amc-match-hint');
        function updateMatch() {
            if (!confirmInput.value) {
                matchHint.textContent = 'Must match the password above';
                matchHint.style.color = 'var(--amc-muted)';
                return;
            }
            var matches = confirmInput.value === passwordInput.value;
            matchHint.textContent = matches ? 'Passwords match' : 'Passwords do not match';
            matchHint.style.color = matches ? 'var(--amc-success)' : 'var(--amc-danger)';
        }
        passwordInput.addEventListener('input', updateMatch);
        confirmInput.addEventListener('input', updateMatch);

        // show/hide password toggles
        document.querySelectorAll('.amc-toggle-visibility').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = document.getElementById(btn.getAttribute('data-target'));
                target.type = target.type === 'password' ? 'text' : 'password';
            });
        });

        // loading state on submit
        document.getElementById('amc-create-form').addEventListener('submit', function () {
            var saveBtn = document.getElementById('amc-save-btn');
            saveBtn.classList.add('is-loading');
            saveBtn.disabled = true;
        });
    })();
</script>
@endsection