@extends('auth.layouts.master')

@section('title', 'Create Student Account')

@section('auth-content')
<div class="auth-wrapper">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="auth-container">
        <div class="auth-card" id="authCard">
            <div class="crest-band">
                <div class="logo-row">
                    <div class="crest-logo">
                        <img src="{{ asset('image/bagong-pilipinas-logo-png_seeklogo-534301.png') }}" alt="Bagong Pilipinas">
                    </div>
                    <div class="crest-logo brand">
                        <img src="{{ asset('image/logo%20new.jpg') }}" alt="SkillUp Logo">
                    </div>
                    <div class="crest-logo">
                        <img src="{{ asset('image/hello.png') }}" alt="Institution Logo">
                    </div>
                </div>
                <div class="flag-rule"><span class="b"></span><span class="w"></span><span class="r"></span></div>
            </div>

            <div class="auth-header stagger">
                <h1>Create student account</h1>
                <p>Choose your major and start learning</p>
            </div>

            <div class="auth-body">
                @if ($errors->any())
                    <div class="alert alert-error stagger" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Please fix the fields below and try again.</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="name">Full name</label>
                        <div class="auth-input-wrap">
                            <input id="name" name="name" type="text" value="{{ old('name') }}" class="auth-input @error('name') error @enderror" placeholder="Juan Dela Cruz" autocomplete="name" required>
                        </div>
                        @error('name')
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="email">Email address</label>
                        <div class="auth-input-wrap">
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="auth-input @error('email') error @enderror" placeholder="name@example.com" autocomplete="email" required>
                        </div>
                        @error('email')
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="age">Age</label>
                        <div class="auth-input-wrap">
                            <input id="age" name="age" type="number" min="1" max="120" value="{{ old('age') }}" class="auth-input @error('age') error @enderror" placeholder="18" required>
                        </div>
                        @error('age')
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="birthday">Birthday</label>
                        <div class="auth-input-wrap">
                            <input id="birthday" name="birthday" type="date" value="{{ old('birthday') }}" class="auth-input @error('birthday') error @enderror" required>
                        </div>
                        @error('birthday')
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="address">Address</label>
                        <div class="auth-input-wrap">
                            <input id="address" name="address" type="text" value="{{ old('address') }}" class="auth-input @error('address') error @enderror" placeholder="Your home address" required>
                        </div>
                        @error('address')
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="major_id">Choose your major</label>
                        <div class="auth-input-wrap">
                            <select id="major_id" name="major_id" class="auth-input @error('major_id') error @enderror" required>
                                <option value="">Select a major or program</option>
                                @foreach($majors as $major)
                                    <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                        {{ $major->name }}
                                        @if($major->code)
                                            ({{ $major->code }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('major_id')
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="password">Password</label>
                        <div class="auth-input-wrap">
                            <input id="password" name="password" type="password" class="auth-input @error('password') error @enderror" placeholder="Create a password" autocomplete="new-password" required>
                            <button type="button" class="pw-toggle" data-target="password" aria-label="Show password" aria-pressed="false">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="password-requirement">Use at least 8 characters.</p>
                        @error('password')
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="password_confirmation">Confirm password</label>
                        <div class="auth-input-wrap">
                            <input id="password_confirmation" name="password_confirmation" type="password" class="auth-input @error('password') error @enderror" placeholder="Re-enter password" autocomplete="new-password" required>
                            <button type="button" class="pw-toggle" data-target="password_confirmation" aria-label="Show password" aria-pressed="false">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="auth-check-row stagger" style="margin-top:0.5rem;">
                        <label class="remember-label" style="align-items:flex-start;">
                            <input id="terms" name="terms" type="checkbox" value="1" {{ old('terms') ? 'checked' : '' }} required>
                            <span>I agree to the terms and privacy policy.</span>
                        </label>
                    </div>
                    @error('terms')
                        <p class="auth-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror

                    <button type="submit" class="auth-submit stagger">
                        <span class="btn-text">
                            <span>Create account</span>
                            <i class="fas fa-arrow-right-to-bracket"></i>
                        </span>
                    </button>
                </form>

                <div class="auth-divider">Already registered</div>
                <a href="{{ route('login') }}" class="sias-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Sign in</span>
                </a>
            </div>

            <div class="auth-footer">
                By creating an account, you agree to our
                <a href="/terms">Terms</a>
                and
                <a href="/privacy">Privacy Policy</a>
            </div>
        </div>

        <a href="{{ url('/') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Back to home</span>
        </a>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.pw-toggle').forEach((button) => {
        button.addEventListener('click', function () {
            const target = document.getElementById(this.dataset.target);
            const isPassword = target.type === 'password';
            target.type = isPassword ? 'text' : 'password';
            this.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            this.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
        });
    });
</script>
@endpush
@endsection

<style>
body { line-height: 1.6; }
.auth-wrapper { position: relative; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 2.5rem 1.25rem; overflow: hidden; background: radial-gradient(circle at 12% 15%, rgba(11,42,107,.08), transparent 42%), radial-gradient(circle at 88% 85%, rgba(240,174,0,.11), transparent 42%), var(--mist); }
.blob { position: absolute; border-radius: 50%; filter: blur(70px); opacity: .28; pointer-events: none; animation: float 16s ease-in-out infinite; }
.blob-1 { width: 360px; height: 360px; background: var(--navy); top: -120px; left: -130px; }
.blob-2 { width: 300px; height: 300px; background: var(--gold); bottom: -120px; right: -100px; animation-delay: 3.5s; }
.blob-3 { width: 220px; height: 220px; background: var(--flag-red); top: 40%; right: 6%; animation-delay: 7s; opacity: .12; }
@keyframes float { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(20px,-24px) scale(1.07); } }
.auth-wrapper::after { content: ''; position: absolute; inset: 0; pointer-events: none; opacity: .035; mix-blend-mode: overlay; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }
.auth-container { width: 100%; max-width: 500px; position: relative; z-index: 1; }
.auth-card { background: #fff; border-radius: 22px; box-shadow: 0 1px 2px rgba(11,27,69,.06),0 30px 60px rgba(11,27,69,.16); overflow: hidden; }
.crest-band { background: linear-gradient(160deg, var(--navy) 0%, var(--navy-deep) 100%); padding: 1.85rem 2rem 1.5rem; text-align: center; position: relative; }
.logo-row { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 0; position: relative; }
.crest-logo { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.16); overflow: hidden; }
.crest-logo.brand { width: 60px; height: 60px; border-radius: 14px; background: #fff; border: none; box-shadow: 0 6px 18px rgba(0,0,0,.24); }
.crest-logo img { width: 100%; height: 100%; object-fit: contain; display: block; }
.flag-rule { display: flex; height: 3px; width: 100%; position: absolute; left: 0; bottom: 0; }
.flag-rule span { flex: 1; }
.flag-rule .b { background: var(--navy); }
.flag-rule .w { background: #fff; }
.flag-rule .r { background: var(--flag-red); }
.auth-header { text-align: center; padding: 2rem 2rem 0.4rem; }
.auth-header h1 { margin: 0; font-family: 'Fraunces', serif; font-size: 1.7rem; font-weight: 600; color: var(--ink); letter-spacing: -0.01em; }
.auth-header p { margin: .45rem 0 0; font-size: .94rem; color: var(--slate); }
.auth-body { padding: 1.45rem 2rem 2rem; }
.auth-field { margin-bottom: 1.3rem; }
.auth-input-label { display: block; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #9AA3B8; margin-bottom: .55rem; }
.auth-input-wrap { position: relative; }
.auth-input-wrap::after { content: ''; position: absolute; left: 0; bottom: -1px; height: 2px; width: 0; background: linear-gradient(90deg, var(--navy), var(--gold)); transition: width .35s; border-radius: 2px; }
.auth-field:focus-within .auth-input-wrap::after { width: 100%; }
.auth-input { width: 100%; padding: .85rem .95rem; border: 1.5px solid var(--line); border-radius: 10px; font-size: .95rem; color: var(--ink); background: #fff; outline: none; transition: border-color .25s ease, box-shadow .25s ease; }
.auth-input:hover { border-color: #C7CDDB; }
.auth-input:focus { border-color: var(--navy); box-shadow: 0 0 0 4px rgba(11,42,107,.12); }
.auth-input.error { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(220,38,38,.10); }
.auth-error { display: flex; align-items: center; gap: .4rem; font-size: .8rem; color: var(--danger); margin-top: .45rem; }
.password-requirement { margin: .4rem 0 0; color: var(--slate); font-size: .75rem; }
.pw-toggle { position: absolute; right: .85rem; top: 50%; transform: translateY(-50%); background: none; border: 0; color: #9AA3B8; cursor: pointer; font-size: 18px; padding: 4px 6px; }
.auth-check-row { display: flex; align-items: center; justify-content: space-between; margin: 1.4rem 0; }
.remember-label { display: flex; align-items: center; gap: .6rem; font-size: .9rem; color: var(--slate); cursor: pointer; user-select: none; }
.auth-submit { width: 100%; padding: .95rem; border: 0; background: linear-gradient(135deg, var(--navy) 0%, var(--navy-deep) 100%); color: #fff; font-size: .95rem; font-weight: 700; border-radius: 10px; cursor: pointer; box-shadow: 0 4px 14px rgba(11,42,107,.28); }
.auth-submit:hover { transform: translateY(-2px); }
.btn-text { display: flex; align-items: center; justify-content: center; gap: .6rem; }
.auth-divider { display: flex; align-items: center; gap: .8rem; margin: 1.5rem 0; color: #9AA3B8; font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; }
.auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: var(--line); }
.sias-btn { display: flex; align-items: center; justify-content: center; gap: .6rem; width: 100%; padding: .85rem; border: 1.5px solid var(--line); background: #fff; border-radius: 10px; color: var(--slate); font-size: .94rem; font-weight: 600; text-decoration: none; }
.back-link { display: inline-flex; align-items: center; gap: .4rem; margin-top: 1.5rem; padding: .6rem 1rem; border-radius: 8px; background: none; border: 1px solid var(--line); color: var(--slate); font-size: .9rem; font-weight: 600; text-decoration: none; }
.auth-footer { padding: 1.1rem 2rem; text-align: center; font-size: .8rem; color: #9AA3B8; border-top: 1px solid #F0F2F8; }
.auth-footer a { color: var(--navy); text-decoration: none; }
.alert { padding: .85rem 1rem; border-radius: 10px; font-size: .9rem; margin-bottom: 1.2rem; display: flex; align-items: flex-start; gap: .6rem; }
.alert-error { background: #FDECEC; color: #9A1B2A; border: 1px solid #F7C9CE; }
@media (max-width: 480px) { .auth-card { border-radius: 18px; } .crest-band { padding: 1.5rem 1.25rem 1.25rem; } .auth-header { padding: 1.6rem 1.5rem .3rem; } .auth-body { padding: 1.2rem 1.5rem 1.5rem; } }
</style>
