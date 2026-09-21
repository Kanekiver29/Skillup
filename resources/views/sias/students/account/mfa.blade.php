@extends('sias.students.layout.master')

@section('title', 'Multi-Factor Authentication')
@section('page_title', 'Multi-Factor Authentication')

@section('content')
<style>
    /* ── Tokens ─────────────────────────────────────── */
    .mfa-page { --ink:#0f172a; --sub:#475569; --muted:#64748b; --line:#e2e8f0;
               --bg:#f8fafc; --accent:#3b82f6; --success:#16a34a; --danger:#dc2626; 
               --ease:cubic-bezier(.22,1,.36,1); }

    /* ── Animations ─────────────────────────────────── */
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .anim { opacity:0; animation:fadeUp .4s var(--ease) forwards; }

    /* ── Header ─────────────────────────────────────── */
    .mfa-header { margin-bottom:2rem; }
    .mfa-header h2 { margin:0 0 .5rem; font-size:1.5rem; font-weight:800; color:var(--ink); letter-spacing:-0.02em; }
    .mfa-header p { margin:0; color:var(--sub); font-size:1rem; }

    /* ── Alerts ─────────────────────────────────────── */
    .alert { padding:1rem 1.25rem; border-radius:12px; font-size:.95rem; margin-bottom:1.5rem; display:flex; gap:.75rem; align-items:flex-start; }
    .alert svg { width:20px; height:20px; flex-shrink:0; margin-top:.1rem; }
    .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
    .alert-info { background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; }

    /* ── Status Banner ──────────────────────────────── */
    .status-banner { padding:1.5rem; border-radius:16px; border:1px solid var(--line); display:flex; align-items:center; gap:1.25rem; margin-bottom:2rem; background:#fff; }
    .status-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .status-icon svg { width:26px; height:26px; }
    
    .status-banner.enabled { border-color:#bbf7d0; background:#f0fdf4; }
    .status-banner.enabled .status-icon { background:#dcfce7; color:var(--success); }
    
    .status-banner.disabled { border-color:var(--line); background:#fff; }
    .status-banner.disabled .status-icon { background:#f1f5f9; color:var(--muted); }
    
    .status-content h3 { margin:0 0 .25rem; font-size:1.1rem; font-weight:700; color:var(--ink); }
    .status-content p { margin:0; font-size:.95rem; color:var(--sub); }

    /* ── Forms & Cards ──────────────────────────────── */
    .mfa-card { background:#fff; border:1px solid var(--line); border-radius:16px; padding:1.5rem; margin-bottom:1.5rem; box-shadow:0 4px 12px -8px rgba(15,23,42,0.05); }
    .mfa-card h4 { margin:0 0 .5rem; font-size:1.05rem; font-weight:700; color:var(--ink); }
    .mfa-card p { margin:0 0 1.5rem; font-size:.95rem; color:var(--sub); line-height:1.5; }
    
    /* ── Method Select ──────────────────────────────── */
    .method-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1rem; margin-bottom:1.5rem; }
    .method-lbl { position:relative; cursor:pointer; }
    .method-lbl input { position:absolute; opacity:0; width:0; height:0; }
    .method-box { border:1px solid var(--line); border-radius:12px; padding:1.25rem; display:flex; gap:1rem; align-items:center; transition:all .15s ease; background:#fff; }
    .method-box svg { width:24px; height:24px; color:var(--sub); transition:color .15s ease; }
    .method-info strong { display:block; font-size:.95rem; font-weight:700; color:var(--ink); margin-bottom:.15rem; }
    .method-info span { font-size:.8rem; color:var(--sub); }
    
    .method-lbl:hover .method-box { border-color:#cbd5e1; background:#f8fafc; }
    .method-lbl input:checked + .method-box { border-color:var(--ink); background:var(--ink); box-shadow:0 4px 12px -4px rgba(15,23,42,0.3); }
    .method-lbl input:checked + .method-box svg { color:#fff; }
    .method-lbl input:checked + .method-box .method-info strong, .method-lbl input:checked + .method-box .method-info span { color:#fff; }
    
    /* ── QR & Setup ─────────────────────────────────── */
    .setup-flow { border-top:1px solid var(--line); padding-top:1.5rem; display:none; }
    .setup-step { display:flex; gap:1.25rem; margin-bottom:1.5rem; align-items:flex-start; }
    .step-num { width:28px; height:28px; border-radius:50%; background:var(--ink); color:#fff; font-size:.85rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .step-content { flex:1; }
    .step-content strong { display:block; font-size:1rem; font-weight:700; color:var(--ink); margin-bottom:.35rem; }
    .step-content p { margin:0 0 1rem; font-size:.9rem; color:var(--sub); }
    
    .qr-placeholder { width:150px; height:150px; background:#fff; border:1px solid var(--line); border-radius:8px; display:flex; align-items:center; justify-content:center; padding:10px; margin-bottom:1rem; }
    
    .code-input { display:flex; gap:.5rem; }
    .code-input input { width:45px; height:50px; text-align:center; font-size:1.25rem; font-weight:700; font-family:monospace; border:1px solid var(--line); border-radius:8px; background:#f8fafc; transition:all .15s ease; color:var(--ink); }
    .code-input input:focus { outline:none; border-color:var(--accent); background:#fff; box-shadow:0 0 0 3px rgba(59,130,246,0.1); }
    
    /* ── Actions ────────────────────────────────────── */
    .mfa-actions { margin-top:2rem; }
    .btn { display:inline-flex; align-items:center; justify-content:center; gap:.5rem; padding:.75rem 1.5rem; border-radius:10px; font-size:.95rem; font-weight:600; cursor:pointer; transition:all .15s ease; border:1px solid transparent; text-decoration:none; }
    .btn-primary { background:var(--ink); color:#fff; }
    .btn-primary:hover { background:#1e293b; transform:translateY(-1px); box-shadow:0 4px 12px -4px rgba(15,23,42,.4); }
    .btn-danger { background:#fff; color:var(--danger); border-color:var(--danger); }
    .btn-danger:hover { background:var(--danger); color:#fff; }
</style>

<div class="mfa-page">
    <div class="mfa-header anim" style="animation-delay:.02s;">
        <h2>Multi-Factor Authentication</h2>
        <p>Enhance your student account security with an additional verification step.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success anim" style="animation-delay:.04s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info anim" style="animation-delay:.04s;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            {{ session('info') }}
        </div>
    @endif

    @if($mfaEnabled)
        <!-- ENABLED STATE -->
        <div class="status-banner enabled anim" style="animation-delay:.06s;">
            <div class="status-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
            </div>
            <div class="status-content">
                <h3>MFA is Enabled</h3>
                <p>Your account is highly secure. You will be required to verify your identity when logging in from unrecognised devices.</p>
            </div>
        </div>

        <div class="mfa-card anim" style="animation-delay:.08s;">
            <h4>Authentication Method</h4>
            <p>You are currently using <strong>{{ $mfaMethod === 'app' ? 'Authenticator App' : 'SMS / Text Message' }}</strong> to verify your identity.</p>
            
            <form method="POST" action="{{ route('sias.student.account.mfa.toggle') }}">
                @csrf
                <input type="hidden" name="action" value="disable">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to disable Multi-Factor Authentication? This will make your account less secure.');">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M21 12a9 9 0 1 1-9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M12 2v20M2 12h20"/></svg>
                    Disable MFA
                </button>
            </form>
        </div>
    @else
        <!-- DISABLED STATE -->
        <div class="status-banner disabled anim" style="animation-delay:.06s;">
            <div class="status-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div class="status-content">
                <h3>MFA is Not Configured</h3>
                <p>Your account is vulnerable. We highly recommend enabling multi-factor authentication to protect your student records.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('sias.student.account.mfa.toggle') }}" id="mfaSetupForm">
            @csrf
            <input type="hidden" name="action" value="enable">
            
            <div class="mfa-card anim" style="animation-delay:.08s;">
                <h4>Choose Setup Option</h4>
                <p>Select how you want to receive your verification codes.</p>
                
                <div class="method-grid">
                    <label class="method-lbl">
                        <input type="radio" name="method" value="app" checked onchange="toggleFlow('app')">
                        <div class="method-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                            <div class="method-info">
                                <strong>Authenticator App</strong>
                                <span>Google Auth, Authy, etc.</span>
                            </div>
                        </div>
                    </label>
                    <label class="method-lbl">
                        <input type="radio" name="method" value="sms" onchange="toggleFlow('sms')">
                        <div class="method-box">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            <div class="method-info">
                                <strong>SMS / Text Message</strong>
                                <span>Receive codes via phone</span>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- App Flow -->
                <div id="flow-app" class="setup-flow" style="display:block;">
                    <div class="setup-step">
                        <div class="step-num">1</div>
                        <div class="step-content">
                            <strong>Scan QR Code</strong>
                            <p>Open your authenticator app and scan this barcode.</p>
                            <div class="qr-placeholder">
                                <svg width="100" height="100" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h-3v2h3v-2zm-3 4h3v2h-3v-2zm-2-2h2v2h-2v-2zm-2 4h2v2h-2v-2zm2-2h2v2h-2v-2zm2 2h3v2h-3v-2zm3-6h2v2h-2v-2zm-5 4h2v2h-2v-2zm2-2h2v2h-2v-2z"/>
                                </svg>
                            </div>
                            <p style="font-size:.8rem;">Manual Entry Key: <code style="background:#f1f5f9;padding:.2rem .4rem;border-radius:4px;color:var(--ink);">ABCD EFGH IJKL MNOP</code></p>
                        </div>
                    </div>
                    
                    <div class="setup-step">
                        <div class="step-num">2</div>
                        <div class="step-content">
                            <strong>Verify Code</strong>
                            <p>Enter the 6-digit code generated by your app to verify setup.</p>
                            <div class="code-input">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SMS Flow -->
                <div id="flow-sms" class="setup-flow">
                    <div class="setup-step">
                        <div class="step-num">1</div>
                        <div class="step-content">
                            <strong>Verify Phone Number</strong>
                            <p>We will send a code to the phone number associated with your account: <strong style="display:inline;">+63 ••• ••• 4892</strong></p>
                            <button type="button" class="btn btn-primary" style="padding:.5rem 1rem;font-size:.85rem;" onclick="alert('Verification code sent to your phone!')">Send Code</button>
                        </div>
                    </div>
                    
                    <div class="setup-step">
                        <div class="step-num">2</div>
                        <div class="step-content">
                            <strong>Enter Code</strong>
                            <p>Enter the 6-digit code sent to your phone.</p>
                            <div class="code-input">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                                <input type="text" maxlength="1" onkeyup="focusNext(this, event)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mfa-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                        Enable MFA
                    </button>
                </div>
            </div>
        </form>
        
        <script>
            function toggleFlow(type) {
                document.getElementById('flow-app').style.display = type === 'app' ? 'block' : 'none';
                document.getElementById('flow-sms').style.display = type === 'sms' ? 'block' : 'none';
            }
            
            function focusNext(el, e) {
                if(e.key === "Backspace" && el.value === "") {
                    let prev = el.previousElementSibling;
                    if(prev) { prev.focus(); prev.value = ""; }
                } else if(el.value.length === 1) {
                    let next = el.nextElementSibling;
                    if(next) next.focus();
                }
            }
        </script>
    @endif
</div>
@endsection
