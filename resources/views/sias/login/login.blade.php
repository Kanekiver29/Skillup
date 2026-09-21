@extends('sias.login.layouts.master')

@section('title', 'SIAS Login')

@section('auth-content')
<div class="sias-shell">
    <div class="sias-card" id="siasCard">

        <div class="sias-crest-row">
            <span class="sias-crest">
                <img src="{{ asset('image/bagong-pilipinas-logo-png_seeklogo-534301.png') }}" alt="Bagong Pilipinas" width="34" height="34" loading="eager" decoding="async">
            </span>
            <span class="sias-crest sias-crest--lg">
                <img src="{{ asset('image/logo new.jpg') }}" alt="SkillUp logo" width="42" height="42" loading="eager" decoding="async">
            </span>
            <span class="sias-crest">
                <img src="{{ asset('image/hello.png') }}" alt="TESDA partner logo" width="34" height="34" loading="eager" decoding="async">
            </span>
        </div>

        <div class="sias-hair"></div>

        <div class="sias-head">
            <h1 class="sias-title">NAVIS Access Portal</h1>
               <p class="sias-sub">TESDA Academic & Vocational Information System.</p>
            <p class="sias-sub">Sign in with your TESDA‑backed credentials.</p>
        </div>

        @if (session('success'))
            <div class="sias-alert sias-alert--ok" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="sias-alert sias-alert--bad" role="alert" id="siasErrorAlert">
                <strong>There was a problem with your submission.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sias.login.submit') }}" novalidate id="siasLoginForm">
            @csrf

            <div class="sias-group">
                <label id="roleGroupLabel">Login as</label>
                <div class="sias-roles" role="tablist" aria-labelledby="roleGroupLabel">
                    <span class="sias-roles__pill" id="roleIndicator" aria-hidden="true"></span>
                    <button type="button" class="sias-role {{ old('login_as', $defaultRole ?? 'student') === 'student' ? 'is-active' : '' }}" data-role="student" role="tab" aria-selected="{{ old('login_as', $defaultRole ?? 'student') === 'student' ? 'true' : 'false' }}">Student</button>
                    <button type="button" class="sias-role {{ old('login_as', $defaultRole ?? 'student') === 'teacher' ? 'is-active' : '' }}" data-role="teacher" role="tab" aria-selected="{{ old('login_as', $defaultRole ?? 'student') === 'teacher' ? 'true' : 'false' }}">Teacher</button>
                    <button type="button" class="sias-role {{ old('login_as', $defaultRole ?? 'student') === 'admin' ? 'is-active' : '' }}" data-role="admin" role="tab" aria-selected="{{ old('login_as', $defaultRole ?? 'student') === 'admin' ? 'true' : 'false' }}">Admin</button>
                </div>
                <input type="hidden" name="login_as" id="login_as" value="{{ old('login_as', $defaultRole ?? 'student') }}">
            </div>

            <div class="sias-group">
                <label for="email" id="loginFieldLabel">Student ID</label>
                <input
                    id="email"
                    name="{{ old('login_as', $defaultRole ?? 'student') === 'student' ? 'student_id' : 'email' }}"
                    type="{{ old('login_as', $defaultRole ?? 'student') === 'student' ? 'text' : 'email' }}"
                    class="sias-input"
                    value="{{ old('student_id', old('email')) }}"
                    placeholder="{{ old('login_as', $defaultRole ?? 'student') === 'student' ? 'Enter your Student ID' : 'you@example.com' }}"
                    required
                    autocomplete="{{ old('login_as', $defaultRole ?? 'student') === 'student' ? 'username' : 'email' }}"
                >
            </div>

            <div class="sias-group">
                <label for="password">Password</label>
                <div class="sias-pass-wrap">
                    <input id="password" name="password" type="password" class="sias-input" placeholder="Enter your password" required autocomplete="current-password">
                    <button type="button" class="sias-eye" id="togglePass" aria-label="Show password" aria-pressed="false">
                        <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="sias-submit" id="siasSubmit">
                <span class="sias-submit__label">Sign in as <span id="selectedRoleLabel">{{ ucfirst(old('login_as', $defaultRole ?? 'student')) }}</span></span>
                <span class="sias-spinner" aria-hidden="true"></span>
            </button>
        </form>

        <div class="sias-foot">
            <span>Need help? Contact your institution.</span>
            <a href="{{ route('login') }}">Refresh</a>
        </div>

    </div>
</div>

<style>
    :root{
        --navy: #0b3d74;
        --navy-deep: #072d57;
        --gold: #f2b134;
        --bg: #eef1f6;
        --ink: #101828;
        --muted: #6b7686;
        --line: #e6e9f0;
        --danger: #c0152f;
        --danger-bg: #fdecee;
        --ok: #12805c;
        --ok-bg: #eafaf3;
        --radius: 16px;
        --ease: cubic-bezier(.2,.8,.2,1);
    }

    .sias-shell{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 32px 20px;
        background: linear-gradient(180deg, var(--navy-deep) 0%, var(--navy) 55%, var(--bg) 55%);
    }

    .sias-card{
        width: min(400px, 100%);
        background: #fff;
        border-radius: var(--radius);
        box-shadow: 0 20px 40px -18px rgba(7,45,87,.35);
        padding: 32px 30px 26px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        opacity: 0;
        transform: translateY(10px);
        animation: sias-in .38s var(--ease) forwards;
        contain: layout paint;
    }

    @keyframes sias-in{ to{ opacity: 1; transform: translateY(0); } }

    .sias-card > *{
        opacity: 0;
        transform: translateY(6px);
        animation: sias-in .4s var(--ease) forwards;
    }
    .sias-card > *:nth-child(1){ animation-delay: .08s; }
    .sias-card > *:nth-child(2){ animation-delay: .12s; }
    .sias-card > *:nth-child(3){ animation-delay: .15s; }
    .sias-card > *:nth-child(4){ animation-delay: .19s; }
    .sias-card > *:nth-child(5){ animation-delay: .23s; }
    .sias-card > *:nth-child(6){ animation-delay: .27s; }
    .sias-card > *:nth-child(7){ animation-delay: .31s; }

    .sias-crest-row{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
    }

    .sias-crest{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        padding: 4px;
        border-radius: 50%;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 0 0 1px var(--line);
        flex-shrink: 0;
    }
    .sias-crest--lg{ width: 42px; height: 42px; padding: 5px; }
    .sias-crest img{ width: 100%; height: 100%; object-fit: contain; }

    .sias-hair{
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    .sias-head{ text-align: center; display: flex; flex-direction: column; gap: 4px; }

    .sias-title{
        margin: 0;
        font-size: 21px;
        font-weight: 800;
        letter-spacing: -.01em;
        color: var(--ink);
    }

    .sias-sub{
        margin: 0;
        font-size: 13px;
        color: var(--muted);
    }

    .sias-alert{
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 12.5px;
        line-height: 1.5;
        border: 1px solid transparent;
    }
    .sias-alert--ok{ background: var(--ok-bg); border-color: #bfe9d2; color: var(--ok); }
    .sias-alert--bad{ background: var(--danger-bg); border-color: #f4c2ca; color: var(--danger); }
    .sias-alert--bad ul{ margin: 6px 0 0; padding-left: 16px; }

    #siasLoginForm{ display: flex; flex-direction: column; gap: 14px; }

    .sias-group{ display: flex; flex-direction: column; gap: 6px; }

    .sias-group > label{
        font-size: 11.5px;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: .02em;
        text-transform: uppercase;
        transition: color .15s ease;
    }
    .sias-group:focus-within > label{ color: var(--navy); }

    .sias-roles{
        position: relative;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        background: var(--bg);
        border-radius: 10px;
        padding: 3px;
        gap: 3px;
    }

    .sias-roles__pill{
        position: absolute;
        top: 3px;
        left: 3px;
        width: calc((100% - 6px) / 3);
        height: calc(100% - 6px);
        background: var(--navy);
        border-radius: 8px;
        transition: transform .25s var(--ease);
        z-index: 0;
        will-change: transform;
    }

    .sias-role{
        position: relative;
        z-index: 1;
        border: none;
        background: transparent;
        padding: 8px 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        border-radius: 8px;
        cursor: pointer;
        transition: color .2s ease;
    }
    .sias-role.is-active{ color: #fff; }
    .sias-role:focus-visible{ outline: 2px solid var(--gold); outline-offset: 2px; }
    .sias-role:hover:not(.is-active){ color: var(--navy); }

    .sias-input{
        width: 100%;
        box-sizing: border-box;
        padding: 10px 13px;
        border-radius: 9px;
        border: 1.5px solid var(--line);
        background: #fff;
        font-size: 14px;
        color: var(--ink);
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .sias-input::placeholder{ color: #a6b1c4; }
    .sias-input:focus{
        outline: none;
        border-color: var(--navy);
        box-shadow: 0 0 0 3px rgba(11,61,116,.12);
    }

    .sias-pass-wrap{ position: relative; }
    .sias-pass-wrap .sias-input{ padding-right: 40px; }
    .sias-eye{
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        color: var(--muted);
        cursor: pointer;
        padding: 6px;
        border-radius: 7px;
        display: flex;
        transition: color .15s ease, background .15s ease;
    }
    .sias-eye:hover{ color: var(--navy); background: var(--bg); }

    .sias-submit{
        position: relative;
        margin-top: 2px;
        border: none;
        border-radius: 10px;
        padding: 11px 16px;
        background: var(--navy);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: filter .15s ease, transform .1s ease;
    }
    .sias-submit:hover{ filter: brightness(1.08); }
    .sias-submit:active{ transform: translateY(1px); }
    .sias-submit:focus-visible{ outline: 2px solid var(--gold); outline-offset: 3px; }

    .sias-spinner{
        display: none;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,.35);
        border-top-color: #fff;
        animation: sias-spin .6s linear infinite;
    }
    @keyframes sias-spin{ to{ transform: rotate(360deg); } }

    .sias-submit.is-loading .sias-submit__label{ opacity: 0; }
    .sias-submit.is-loading .sias-spinner{ display: inline-block; }
    .sias-submit.is-loading{ pointer-events: none; }

    .sias-foot{
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: var(--muted);
        padding-top: 4px;
        border-top: 1px solid var(--line);
        margin-top: 4px;
    }
    .sias-foot a{ color: var(--navy); font-weight: 700; text-decoration: none; }
    .sias-foot a:hover{ text-decoration: underline; }

    @media (max-width: 420px){
        .sias-card{ padding: 26px 20px 22px; }
    }

    @media (prefers-reduced-motion: reduce){
        .sias-card, .sias-card > *, .sias-roles__pill, .sias-submit, .sias-spinner{
            animation: none !important;
            transition: none !important;
        }
        .sias-card, .sias-card > *{ opacity: 1; transform: none; }
    }
</style>
@endsection

@push('scripts')
<script>
    (function () {
        var buttons = document.querySelectorAll('.sias-role');
        var hiddenInput = document.getElementById('login_as');
        var label = document.getElementById('selectedRoleLabel');
        var loginLabel = document.getElementById('loginFieldLabel');
        var loginInput = document.getElementById('email');
        var indicator = document.getElementById('roleIndicator');
        var form = document.getElementById('siasLoginForm');
        var submitBtn = document.getElementById('siasSubmit');
        var togglePass = document.getElementById('togglePass');
        var passwordInput = document.getElementById('password');

        if (!buttons.length || !hiddenInput || !label || !loginLabel || !loginInput || !indicator) {
            return;
        }

        var roleIndex = { student: 0, teacher: 1, admin: 2 };

        function moveIndicator(role) {
            var i = roleIndex[role] || 0;
            indicator.style.transform = 'translateX(' + (i * 100) + '%)';
        }

        function updateField(role) {
            if (role === 'student') {
                loginInput.name = 'student_id';
                loginLabel.textContent = 'Student ID';
                loginInput.placeholder = 'Enter your Student ID';
                loginInput.type = 'text';
                loginInput.autocomplete = 'username';
            } else {
                loginInput.name = 'email';
                loginLabel.textContent = 'Email Address';
                loginInput.placeholder = 'you@example.com';
                loginInput.type = 'email';
                loginInput.autocomplete = 'email';
            }
        }

        function setRole(role) {
            hiddenInput.value = role;
            label.textContent = role.charAt(0).toUpperCase() + role.slice(1);
            buttons.forEach(function (btn) {
                var isActive = btn.dataset.role === role;
                btn.classList.toggle('is-active', isActive);
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
            updateField(role);
            moveIndicator(role);
        }

        buttons.forEach(function (button, idx) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                setRole(this.dataset.role);
            });
            button.addEventListener('keydown', function (event) {
                if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
                    event.preventDefault();
                    var dir = event.key === 'ArrowRight' ? 1 : -1;
                    var next = (idx + dir + buttons.length) % buttons.length;
                    buttons[next].focus();
                    setRole(buttons[next].dataset.role);
                }
            });
        });

        if (togglePass && passwordInput) {
            togglePass.addEventListener('click', function () {
                var isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                togglePass.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
                togglePass.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            });
        }

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                if (submitBtn.classList.contains('is-loading')) {
                    return;
                }
                submitBtn.classList.add('is-loading');
            });
        }

        var initialRole = hiddenInput.value || 'student';
        setRole(initialRole);
        indicator.style.transition = 'none';
        requestAnimationFrame(function () {
            indicator.style.transition = '';
        });
    })();
</script>
@endpush