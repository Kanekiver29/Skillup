@extends('sias.students.layout.master')

@section('title', __('sias.student_settings'))
@section('page_title', __('sias.student_settings'))

@section('content')
<style>
    .student-settings-page { animation: student-settings-in .6s var(--ease, cubic-bezier(.22,1,.36,1)) both; }
    .student-settings-hero { position:relative; overflow:hidden; display:flex; justify-content:space-between; align-items:flex-end; gap:1rem; padding:1.5rem; border:1px solid var(--card-border, #e2e7f3); border-radius:18px; background:linear-gradient(135deg, var(--card-bg, #fff), var(--block-bg, #f6f8fd)); box-shadow:var(--card-shadow, 0 18px 40px rgba(16,27,46,.08)); }
    .student-settings-hero::after { content:''; position:absolute; width:170px; height:170px; right:-55px; top:-85px; border:1px solid rgba(201,151,59,.35); border-radius:50%; box-shadow:0 0 0 18px rgba(201,151,59,.06), 0 0 0 38px rgba(201,151,59,.035); pointer-events:none; }
    .student-settings-hero h2 { position:relative; z-index:1; margin:0 0 .4rem; }
    .student-settings-hero p { position:relative; z-index:1; max-width:620px; margin:0; color:var(--text-muted, #56667e); }
    .student-settings-kicker { position:relative; z-index:1; margin:0 0 .4rem; color:var(--accent, #c9973b); font-size:.7rem; font-weight:800; letter-spacing:.16em; text-transform:uppercase; }
    .student-settings-form { display:grid; gap:1rem; margin-top:1rem; }
    .student-settings-section { padding:1.25rem; border:1px solid var(--card-border, #e2e7f3); border-radius:16px; background:var(--card-bg, #fff); box-shadow:var(--card-shadow, 0 12px 30px rgba(16,27,46,.07)); animation:student-settings-in .55s var(--ease, ease) both; transition:transform .25s var(--ease, ease), border-color .25s ease, box-shadow .25s ease; }
    .student-settings-section:nth-child(2) { animation-delay:.08s; }
    .student-settings-section:nth-child(3) { animation-delay:.16s; }
    .student-settings-section:hover { transform:translateY(-2px); border-color:rgba(201,151,59,.42); box-shadow:0 22px 44px rgba(16,27,46,.11); }
    .student-settings-section h3 { display:flex; align-items:center; gap:.55rem; padding-bottom:.8rem; margin:0 0 1rem; border-bottom:1px solid var(--divider, #e4e9f3); font-family:var(--font-display, Georgia, serif); font-size:1.15rem; }
    .student-settings-section h3 i { color:var(--accent, #c9973b); font-size:.9rem; }
    .student-settings-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:1rem; }
    .student-settings-field { display:grid; gap:.4rem; color:var(--text-muted, #56667e); font-size:.78rem; font-weight:700; }
    .student-settings-field input, .student-settings-field select { width:100%; min-height:42px; padding:.65rem .75rem; border:1px solid var(--block-border, #e2e7f3); border-radius:9px; background:var(--toggle-bg, #fff); color:var(--text, #0d1829); font:inherit; font-weight:500; outline:0; transition:border-color .2s ease, box-shadow .2s ease, transform .2s ease; }
    .student-settings-field input:focus, .student-settings-field select:focus { border-color:var(--focus-ring, #3a54a3); box-shadow:0 0 0 4px rgba(58,84,163,.14); transform:translateY(-1px); }
    .student-settings-toggle { display:flex; align-items:center; justify-content:space-between; gap:.75rem; min-height:42px; padding:.65rem .75rem; border:1px solid var(--block-border, #e2e7f3); border-radius:9px; color:var(--text, #0d1829); font-size:.8rem; font-weight:600; cursor:pointer; transition:background .2s ease, border-color .2s ease; }
    .student-settings-toggle:hover { border-color:var(--accent, #c9973b); background:var(--block-bg, #f6f8fd); }
    .student-settings-toggle input { width:1.05rem; height:1.05rem; accent-color:var(--accent, #c9973b); }
    .dark-mode .student-settings-hero { background:linear-gradient(135deg, #17233b, #101a2d); }
    .dark-mode .student-settings-section { background:#16233d; border-color:#30425f; }
    .dark-mode .student-settings-section h3 { border-color:#30425f; color:#f4f6fd; }
    .dark-mode .student-settings-hero p, .dark-mode .student-settings-field { color:#b9c4d8; }
    .dark-mode .student-settings-field input, .dark-mode .student-settings-field select, .dark-mode .student-settings-toggle { background:#0f192c; border-color:#3a4d6d; color:#f4f6fd; }
    .dark-mode .student-settings-toggle:hover { background:#1c2c49; }
    .student-settings-alert { padding:.85rem 1rem; border-radius:12px; animation:student-settings-in .4s ease both; }
    .student-settings-actions { display:flex; justify-content:flex-end; padding-top:.2rem; animation:student-settings-in .55s .22s var(--ease, ease) both; }
    @keyframes student-settings-in { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
    @media (max-width:700px) { .student-settings-hero { align-items:flex-start; flex-direction:column; } .student-settings-grid { grid-template-columns:1fr; } }
    @media (prefers-reduced-motion:reduce) { .student-settings-page, .student-settings-section, .student-settings-actions, .student-settings-alert { animation:none; } .student-settings-section, .student-settings-field input, .student-settings-field select { transition:none; } }
</style>
@php
    $account = $settings['account'] ?? [];
    $appearance = $settings['appearance'] ?? [];
    $notifications = $settings['notifications'] ?? [];
    $privacy = $settings['privacy'] ?? [];
    $activeLanguage = app()->getLocale() === 'tl' ? 'Filipino' : 'English';
@endphp

<div class="page-card student-settings-page">
    <div class="student-settings-hero">
        <div>
            <p class="student-settings-kicker">{{ __('sias.student_workspace') }}</p>
            <h2>{{ __('sias.student_settings') }}</h2>
            <p>{{ __('sias.manage_account_language_preferences') }}</p>
        </div>
        <a class="btn" href="{{ route('sias.student.account.password') }}">
            <i class="fa-solid fa-lock"></i> {{ __('sias.change_password_page') }}
        </a>
    </div>

    @if (session('success'))
        <div class="student-settings-alert section-block" role="status" style="margin-top:1rem;color:#17653a;">{{ session('success') }}</div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="student-settings-alert section-block" role="alert" style="margin-top:1rem;color:#9b2c2c;">
            <strong>{{ __('sias.please_correct') }}</strong>
            <ul style="margin:.5rem 0 0 1.2rem;">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('sias.student.settings.update') }}" class="student-settings-form">
        @csrf
        <div class="student-settings-section">
            <h3><i class="fa-solid fa-user"></i> {{ __('sias.account') }}</h3>
            <div class="student-settings-grid">
                <label class="student-settings-field">{{ __('sias.name') }}<input type="text" name="name" value="{{ old('name', $user->name) }}" required></label>
                <label class="student-settings-field">{{ __('sias.email') }}<input type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
                <label class="student-settings-field">{{ __('sias.phone') }}<input type="tel" name="account[phone]" value="{{ old('account.phone', $account['phone'] ?? '') }}"></label>
                <label class="student-settings-field">{{ __('sias.language') }}<select name="account[language]">
                    @foreach (['English', 'Filipino'] as $language)
                        <option value="{{ $language }}" @selected(old('account.language', $account['language'] ?? $activeLanguage) === $language)>{{ $language === 'Filipino' ? __('sias.filipino') : __('sias.english') }}</option>
                    @endforeach
                </select></label>
            </div>
        </div>

        <div class="student-settings-section">
            <h3><i class="fa-solid fa-sliders"></i> {{ __('sias.appearance_and_notifications') }}</h3>
            <div class="student-settings-grid">
                <label class="student-settings-field">{{ __('sias.theme') }}<select id="student_appearance_theme" name="appearance[theme]">
                    @foreach (['light' => __('sias.light'), 'dark' => __('sias.dark'), 'system' => __('sias.system')] as $value => $label)
                        <option value="{{ $value }}" @selected(old('appearance.theme', $appearance['theme'] ?? 'light') === $value)>{{ $label }}</option>
                    @endforeach
                </select></label>
                <label class="student-settings-field">{{ __('sias.font_size') }}<select id="student_appearance_font_size" name="appearance[font_size]">
                    @foreach (['small' => __('sias.small'), 'medium' => __('sias.medium'), 'large' => __('sias.large')] as $value => $label)
                        <option value="{{ $value }}" @selected(old('appearance.font_size', $appearance['font_size'] ?? 'medium') === $value)>{{ $label }}</option>
                    @endforeach
                </select></label>
                <label class="student-settings-toggle"><input type="checkbox" name="appearance[reduced_motion]" value="1" @checked(old('appearance.reduced_motion', $appearance['reduced_motion'] ?? false))> {{ __('sias.reduce_animations') }}</label>
                <label class="student-settings-toggle"><input type="checkbox" name="notifications[email]" value="1" @checked(old('notifications.email', $notifications['email'] ?? true))> {{ __('sias.email_notifications') }}</label>
                <label class="student-settings-toggle"><input type="checkbox" name="notifications[push]" value="1" @checked(old('notifications.push', $notifications['push'] ?? true))> {{ __('sias.push_notifications') }}</label>
                <label class="student-settings-toggle"><input type="checkbox" name="notifications[weekly_digest]" value="1" @checked(old('notifications.weekly_digest', $notifications['weekly_digest'] ?? false))> {{ __('sias.weekly_digest') }}</label>
                <p style="grid-column:1 / -1;margin:0;color:var(--text-muted);font-size:.76rem;">Weekly digest pauses immediate email alerts; in-app notifications remain available.</p>
            </div>
        </div>

        <div class="student-settings-section">
            <h3><i class="fa-solid fa-shield-halved"></i> {{ __('sias.privacy') }}</h3>
            <div class="student-settings-grid">
                <label class="student-settings-field">{{ __('sias.profile_visibility') }}<select name="privacy[profile_visibility]">
                    @foreach (['public' => __('sias.public'), 'students_only' => __('sias.students_only'), 'private' => __('sias.private')] as $value => $label)
                        <option value="{{ $value }}" @selected(old('privacy.profile_visibility', $privacy['profile_visibility'] ?? 'public') === $value)>{{ $label }}</option>
                    @endforeach
                </select></label>
                <label class="student-settings-toggle"><input type="checkbox" name="privacy[show_contact]" value="1" @checked(old('privacy.show_contact', $privacy['show_contact'] ?? false))> {{ __('sias.show_contact') }}</label>
            </div>
        </div>

        <div class="student-settings-actions">
            <button type="submit" class="btn"><i class="fa-solid fa-floppy-disk"></i> {{ __('sias.save_settings') }}</button>
        </div>
    </form>
</div>
<script>
    (function () {
        var theme = document.getElementById('student_appearance_theme');
        var fontSize = document.getElementById('student_appearance_font_size');
        if (theme && typeof window.siasApplyTheme === 'function') {
            theme.addEventListener('change', function () { window.siasApplyTheme(theme.value, true); });
        }
        if (fontSize && typeof window.siasApplyFontSize === 'function') {
            fontSize.addEventListener('change', function () { window.siasApplyFontSize(fontSize.value, true); });
        }
    })();
</script>
@endsection
