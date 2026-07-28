@extends('staff.layouts.masters')
@section('title','Users')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
    .amc {
        --amc-void: #090c12;
        --amc-panel: #10141d;
        --amc-panel-soft: #131826;
        --amc-line: #212739;
        --amc-line-bright: #384260;
        --amc-cyan: #5eead4;
        --amc-violet: #8b7cf6;
        --amc-text: #e8ebf4;
        --amc-muted: #838da3;
        --amc-success: #34d399;
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

    /* ambient backdrop */
    .amc::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: -2;
        background:
            radial-gradient(circle at 12% -10%, rgba(139,124,246,0.16), transparent 42%),
            radial-gradient(circle at 100% 10%, rgba(94,234,212,0.10), transparent 40%);
    }
    .amc::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: -1;
        background-image:
            linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
        background-size: 34px 34px;
        mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, black 30%, transparent 75%);
    }

    .amc-eyebrow {
        font-family: var(--amc-font-mono);
        font-size: 11px;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--amc-cyan);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .amc-eyebrow .dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: var(--amc-cyan);
        box-shadow: 0 0 0 3px rgba(94,234,212,0.15);
        animation: amc-pulse 2.2s ease-in-out infinite;
    }

    .amc-title {
        font-family: var(--amc-font-display);
        font-weight: 700;
        font-size: 30px;
        letter-spacing: -0.01em;
        background: linear-gradient(120deg, #ffffff 10%, var(--amc-cyan) 60%, var(--amc-violet) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin: 2px 0 4px;
    }
    .amc-subtitle { color: var(--amc-muted); font-size: 13.5px; }

    /* buttons */
    .amc-btn {
        font-family: var(--amc-font-body);
        font-weight: 600;
        font-size: 13.5px;
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px;
        border-radius: 9px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease, background .16s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .amc-btn:focus-visible { outline: 2px solid var(--amc-cyan); outline-offset: 2px; }
    .amc-btn--primary {
        color: #06120f;
        background: linear-gradient(135deg, var(--amc-cyan), #7ef0d8);
        box-shadow: 0 0 0 0 rgba(94,234,212,0.0), 0 4px 18px -6px rgba(94,234,212,0.55);
    }
    .amc-btn--primary:hover { transform: translateY(-1px); box-shadow: 0 6px 22px -6px rgba(94,234,212,0.75); }
    .amc-btn--ghost {
        color: var(--amc-text);
        background: rgba(255,255,255,0.02);
        border-color: var(--amc-line-bright);
    }
    .amc-btn--ghost:hover { border-color: var(--amc-violet); background: rgba(139,124,246,0.08); transform: translateY(-1px); }

    /* filter bar */
    .amc-filterbar {
        display: flex; gap: 10px; flex-wrap: wrap;
        background: var(--amc-panel-soft);
        border: 1px solid var(--amc-line);
        border-radius: 12px;
        padding: 12px;
        margin: 22px 0 20px;
    }
    .amc-input-wrap { position: relative; flex: 1; min-width: 220px; }
    .amc-input-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); opacity: .55; }
    .amc-input, .amc-select {
        width: 100%;
        font-family: var(--amc-font-mono);
        font-size: 13px;
        background: var(--amc-void);
        border: 1px solid var(--amc-line);
        color: var(--amc-text);
        border-radius: 8px;
        padding: 10px 12px 10px 34px;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .amc-select { padding-left: 12px; min-width: 160px; }
    .amc-input::placeholder { color: #5a6377; }
    .amc-input:focus, .amc-select:focus {
        outline: none; border-color: var(--amc-cyan);
        box-shadow: 0 0 0 3px rgba(94,234,212,0.12);
    }

    /* console / table panel */
    .amc-console {
        position: relative;
        background: linear-gradient(180deg, var(--amc-panel), var(--amc-panel-soft));
        border: 1px solid var(--amc-line);
        border-radius: 14px;
        overflow: hidden;
    }
    .amc-console .corner { position: absolute; width: 16px; height: 16px; border: 2px solid var(--amc-cyan); opacity: .6; }
    .amc-console .corner.tl { top: -1px; left: -1px; border-right: none; border-bottom: none; border-top-left-radius: 12px; }
    .amc-console .corner.tr { top: -1px; right: -1px; border-left: none; border-bottom: none; border-top-right-radius: 12px; }
    .amc-console .corner.bl { bottom: -1px; left: -1px; border-right: none; border-top: none; border-bottom-left-radius: 12px; }
    .amc-console .corner.br { bottom: -1px; right: -1px; border-left: none; border-top: none; border-bottom-right-radius: 12px; }

    .amc-scanline {
        position: absolute; left: 0; right: 0; height: 60px; top: -60px;
        background: linear-gradient(180deg, rgba(94,234,212,0.10), transparent);
        animation: amc-scan 3.4s ease-in-out infinite;
        pointer-events: none;
    }

    table.amc-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .amc-table thead th {
        font-family: var(--amc-font-mono);
        font-size: 10.5px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--amc-muted);
        text-align: left;
        padding: 13px 16px;
        border-bottom: 1px solid var(--amc-line);
        background: rgba(255,255,255,0.015);
    }
    .amc-table tbody tr { border-bottom: 1px solid var(--amc-line); transition: background .15s ease; }
    .amc-table tbody tr:last-child { border-bottom: none; }
    .amc-table tbody tr:hover { background: rgba(94,234,212,0.035); }
    .amc-table td { padding: 12px 16px; vertical-align: middle; }

    .amc-user { display: flex; align-items: center; gap: 10px; }
    .amc-avatar {
        width: 32px; height: 32px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-family: var(--amc-font-display); font-weight: 600; font-size: 12px;
        color: #06120f;
        flex-shrink: 0;
    }
    .amc-name { font-weight: 600; color: var(--amc-text); }
    .amc-email { font-family: var(--amc-font-mono); font-size: 12.5px; color: var(--amc-muted); }

    .amc-badge {
        font-family: var(--amc-font-mono);
        font-size: 11px;
        padding: 4px 9px;
        border-radius: 6px;
        border: 1px solid var(--amc-line-bright);
        color: var(--amc-text);
        background: rgba(139,124,246,0.08);
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .amc-status { display: inline-flex; align-items: center; gap: 7px; font-size: 12.5px; font-weight: 500; }
    .amc-status .amc-status-dot { width: 7px; height: 7px; border-radius: 50%; }
    .amc-status--active .amc-status-dot { background: var(--amc-success); box-shadow: 0 0 0 3px rgba(52,211,153,0.16); animation: amc-pulse 2.2s ease-in-out infinite; }
    .amc-status--active { color: var(--amc-success); }
    .amc-status--inactive .amc-status-dot { background: var(--amc-danger); box-shadow: 0 0 0 3px rgba(251,113,133,0.14); }
    .amc-status--inactive { color: var(--amc-danger); }

    .amc-actions { display: flex; align-items: center; gap: 4px; }
    .amc-icon-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 7px;
        border: 1px solid transparent;
        background: transparent; color: var(--amc-muted);
        cursor: pointer; transition: all .15s ease;
    }
    .amc-icon-btn:hover { color: var(--amc-cyan); border-color: var(--amc-line-bright); background: rgba(94,234,212,0.06); transform: translateY(-1px); }
    .amc-icon-btn.danger:hover { color: var(--amc-danger); background: rgba(251,113,133,0.08); }

    .amc-empty { text-align: center; padding: 64px 24px; color: var(--amc-muted); }
    .amc-empty svg { margin: 0 auto 14px; opacity: .5; }
    .amc-empty h3 { font-family: var(--amc-font-display); color: var(--amc-text); font-size: 16px; margin-bottom: 4px; }

    .amc-pagination { margin-top: 18px; font-family: var(--amc-font-mono); font-size: 12.5px; }
    .amc-pagination nav { display: flex; justify-content: center; }
    .amc-pagination :is(a, span) {
        color: var(--amc-muted) !important;
        background: var(--amc-panel-soft) !important;
        border-color: var(--amc-line) !important;
    }
    .amc-pagination a:hover { color: var(--amc-cyan) !important; border-color: var(--amc-cyan) !important; }

    @keyframes amc-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .45; }
    }
    @keyframes amc-scan {
        0% { top: -60px; opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }

    @media (prefers-reduced-motion: reduce) {
        .amc-scanline, .amc-eyebrow .dot, .amc-status--active .amc-status-dot { animation: none; }
        .amc-btn, .amc-icon-btn, .amc-table tbody tr { transition: none; }
    }

    @media (max-width: 720px) {
        .amc-table thead { display: none; }
        .amc-table, .amc-table tbody, .amc-table tr, .amc-table td { display: block; width: 100%; }
        .amc-table tr { padding: 12px 4px; }
        .amc-table td { padding: 6px 12px; }
        .amc-actions { margin-top: 6px; }
    }
</style>

<div class="amc">
    <div class="flex items-start justify-between flex-wrap gap-4">
        <div>
            <div class="amc-eyebrow"><span class="dot"></span> Access Control / User Directory</div>
            <h1 class="amc-title">Users</h1>
            <p class="amc-subtitle">Manage staff accounts, roles, and access across the platform.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('staff.users.create') }}" class="amc-btn amc-btn--primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                Add user
            </a>
            <a href="{{ route('staff.settings.index') }}" class="amc-btn amc-btn--ghost">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                Settings
            </a>
        </div>
    </div>

    <form method="GET" class="amc-filterbar">
        <div class="amc-input-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <input name="q" value="{{ $q ?? '' }}" placeholder="Search by name or email..." class="amc-input">
        </div>
        <select name="role" class="amc-select">
            <option value="">All roles</option>
            @foreach($roles as $key => $label)
                <option value="{{ $key }}" {{ (isset($role) && $role == $key) ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button class="amc-btn amc-btn--ghost" type="submit">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16l-6 8v6l-4 2v-8L4 4z"/></svg>
            Filter
        </button>
    </form>

    <div class="amc-console">
        <div class="corner tl"></div><div class="corner tr"></div>
        <div class="corner bl"></div><div class="corner br"></div>
        <div class="amc-scanline"></div>

        @if($users->count() === 0)
            <div class="amc-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <h3>No users found</h3>
                <p>Try adjusting your search or filters.</p>
            </div>
        @else
            <table class="amc-table">
                <thead>
                    <tr>
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    @php
                        $hue = crc32($u->name) % 360;
                        $initials = collect(explode(' ', trim($u->name)))->map(fn($p) => mb_substr($p, 0, 1))->take(2)->implode('');
                        $isActive = !(isset($u->is_active) && !$u->is_active);
                    @endphp
                    <tr>
                        <td class="p-3">
                            <div class="amc-user">
                                <div class="amc-avatar" style="background: linear-gradient(135deg, hsl({{ $hue }},75%,68%), hsl({{ ($hue + 50) % 360 }},75%,60%));">{{ strtoupper($initials) }}</div>
                                <span class="amc-name">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td class="p-3"><span class="amc-email">{{ $u->email }}</span></td>
                        <td class="p-3"><span class="amc-badge">{{ ucfirst($u->role) }}</span></td>
                        <td class="p-3">
                            @if($isActive)
                                <span class="amc-status amc-status--active"><span class="amc-status-dot"></span>Active</span>
                            @else
                                <span class="amc-status amc-status--inactive"><span class="amc-status-dot"></span>Inactive</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="amc-actions">
                                <a href="{{ route('staff.users.edit', $u) }}" class="amc-icon-btn" title="Edit user">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('staff.users.reset-password', $u) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="amc-icon-btn" title="Reset password" onclick="return confirm('Reset password for {{ $u->name }}?')">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
                                    </button>
                                </form>
                                <form action="{{ route('staff.users.toggle-status', $u) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="amc-icon-btn danger" title="Toggle status" onclick="return confirm('Toggle status for {{ $u->name }}?')">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="amc-pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection