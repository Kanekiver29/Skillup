<?php $__env->startPush('head'); ?>
<style>
/* Fonts, color tokens, and base reset are declared once in auth.layouts.master */
body{ line-height:1.6; }

/* ---------- Ambient background ---------- */
.auth-wrapper{
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
    padding:2.5rem 1.25rem;
    overflow:hidden;
    background:
        radial-gradient(circle at 12% 15%, rgba(11,42,107,.08), transparent 42%),
        radial-gradient(circle at 88% 85%, rgba(240,174,0,.11), transparent 42%),
        var(--mist);
}

/* subtle drifting mesh blobs */
.blob{position:absolute;border-radius:50%;filter:blur(70px);opacity:.28;pointer-events:none;animation:float 16s ease-in-out infinite}
.blob-1{width:360px;height:360px;background:var(--navy);top:-120px;left:-130px}
.blob-2{width:300px;height:300px;background:var(--gold);bottom:-120px;right:-100px;animation-delay:3.5s}
.blob-3{width:220px;height:220px;background:var(--flag-red);top:40%;right:6%;animation-delay:7s;opacity:.12}
@keyframes float{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(20px,-24px) scale(1.07)}}

/* faint grain for a premium print-like texture */
.auth-wrapper::after{
    content:'';position:absolute;inset:0;pointer-events:none;opacity:.035;mix-blend-mode:overlay;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='2' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
}

.auth-container{width:100%;max-width:432px;position:relative;z-index:1}

.auth-card{
    background:#fff;
    border-radius:22px;
    box-shadow:0 1px 2px rgba(11,27,69,.06),0 30px 60px rgba(11,27,69,.16);
    overflow:hidden;
    opacity:1;
    transform:translateY(0) scale(1);
    transition:opacity .7s cubic-bezier(.16,1,.3,1), transform .7s cubic-bezier(.16,1,.3,1);
}
.auth-card.animate-in{opacity:1;transform:translateY(0) scale(1)}

.stagger{opacity:1;transform:translateY(0);transition:opacity .5s cubic-bezier(.16,1,.3,1), transform .5s cubic-bezier(.16,1,.3,1)}
.auth-card.loaded .stagger{opacity:1;transform:translateY(0)}
.auth-card.loaded .stagger:nth-of-type(1){transition-delay:.10s}
.auth-card.loaded .stagger:nth-of-type(2){transition-delay:.17s}
.auth-card.loaded .stagger:nth-of-type(3){transition-delay:.24s}
.auth-card.loaded .stagger:nth-of-type(4){transition-delay:.31s}
.auth-card.loaded .stagger:nth-of-type(5){transition-delay:.38s}
.auth-card.loaded .stagger:nth-of-type(6){transition-delay:.45s}

/* ---------- Crest band (signature element) ---------- */
.crest-band{
    background:linear-gradient(160deg,var(--navy) 0%,var(--navy-deep) 100%);
    padding:1.85rem 2rem 1.5rem;
    text-align:center;
    position:relative;
}
.crest-band::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(circle at 50% -20%, rgba(255,255,255,.14), transparent 60%);
    pointer-events:none;
}
.logo-row{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:0;position:relative}
.crest-logo{
    width:50px;height:50px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.16);
    overflow:hidden;
    opacity:0;
    animation:popIn .6s cubic-bezier(.16,1,.3,1) forwards;
    transition:transform .3s ease, box-shadow .3s ease;
}
.crest-logo:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(0,0,0,.25)}
.crest-logo img{width:100%;height:100%;object-fit:contain;padding:6px;display:block}
.crest-logo.brand{
    width:60px;height:60px;border-radius:14px;
    background:#fff;border:none;
    box-shadow:0 6px 18px rgba(0,0,0,.24);
    position:relative;
}
.crest-logo.brand::after{
    content:'';position:absolute;inset:-3px;border-radius:16px;
    background:conic-gradient(from 0deg, var(--gold), transparent 30%, transparent 70%, var(--gold));
    opacity:0;transition:opacity .3s ease;z-index:-1;animation:spinRing 5s linear infinite paused;
}
.crest-logo.brand:hover::after{opacity:.6;animation-play-state:running}
@keyframes spinRing{to{transform:rotate(360deg)}}
.crest-logo.brand img{padding:0;object-fit:cover}
.logo-row .crest-logo:nth-child(1){animation-delay:.08s}
.logo-row .crest-logo:nth-child(2){animation-delay:.18s}
.logo-row .crest-logo:nth-child(3){animation-delay:.28s}
@keyframes popIn{0%{transform:scale(.4) rotate(-8deg);opacity:0}55%{transform:scale(1.08) rotate(2deg);opacity:1}80%{transform:scale(.97) rotate(-1deg)}100%{transform:scale(1) rotate(0);opacity:1}}

/* three-color rule referencing the affiliated flag, kept as a restrained hairline */
.flag-rule{display:flex;height:3px;width:100%;position:absolute;left:0;bottom:0;transform:scaleX(0);transform-origin:left;animation:growRule .8s cubic-bezier(.16,1,.3,1) .5s forwards}
@keyframes growRule{to{transform:scaleX(1)}}
.flag-rule span{flex:1}
.flag-rule .b{background:var(--navy)}
.flag-rule .w{background:#fff}
.flag-rule .r{background:var(--flag-red)}

.auth-header{text-align:center;padding:2rem 2rem 0.4rem}
.auth-header h1{margin:0;font-family:'Fraunces',serif;font-size:1.7rem;font-weight:600;color:var(--ink);letter-spacing:-.01em}
.auth-header p{margin:.45rem 0 0;font-size:.94rem;color:var(--slate)}

.auth-body{padding:1.45rem 2rem 2rem}
.auth-field{margin-bottom:1.3rem}

.role-label{display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#9AA3B8;margin-bottom:.7rem}

/* ---------- Sliding role selector ---------- */
.role-group{
    position:relative;
    display:grid;grid-template-columns:repeat(4,1fr);gap:6px;
    background:var(--mist);
    border-radius:12px;
    padding:4px;
}
.role-indicator{
    position:absolute;top:4px;left:4px;height:calc(100% - 8px);
    background:linear-gradient(135deg,var(--navy) 0%,var(--navy-deep) 100%);
    border-radius:9px;
    box-shadow:0 4px 12px rgba(11,42,107,.30);
    transition:transform .38s cubic-bezier(.16,1,.3,1), width .38s cubic-bezier(.16,1,.3,1);
    z-index:0;
    pointer-events:none;
}
.role-btn{
    position:relative;z-index:1;
    padding:.65rem .25rem;border:0;background:transparent;border-radius:9px;
    cursor:pointer;font-size:11.5px;font-weight:600;color:var(--slate);
    transition:color .25s ease,transform .15s ease;
    text-align:center;
}
.role-btn:hover:not(.active){color:var(--navy);transform:translateY(-1px)}
.role-btn:focus-visible{outline:2px solid var(--navy);outline-offset:2px;border-radius:9px}
.role-btn:active{transform:translateY(0) scale(.96)}
.role-btn.active{color:#fff}
.role-btn.active span::after{content:'';display:block;width:14px;height:2px;background:var(--gold);margin:4px auto 0;border-radius:2px;animation:widenDash .3s ease}
@keyframes widenDash{from{width:0}to{width:14px}}
.role-btn i{display:block;font-size:17px;margin-bottom:4px;transition:transform .3s cubic-bezier(.34,1.56,.64,1)}
.role-btn.active i{transform:scale(1.12) translateY(-1px)}
.role-btn span{display:block}

.auth-input-label{display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#9AA3B8;margin-bottom:.55rem;transition:color .2s ease}
.auth-field:focus-within .auth-input-label{color:var(--navy)}

.auth-input-wrap{position:relative}
.auth-input-wrap::after{
    content:'';position:absolute;left:0;bottom:-1px;height:2px;width:0;
    background:linear-gradient(90deg,var(--navy),var(--gold));
    transition:width .35s cubic-bezier(.16,1,.3,1);
    border-radius:2px;
}
.auth-input{
    width:100%;padding:.85rem .95rem;border:1.5px solid var(--line);border-radius:10px;
    font-size:.95rem;font-family:inherit;color:var(--ink);background:#fff;outline:none;
    transition:border-color .25s ease,box-shadow .25s ease,background .25s ease,transform .15s ease;
}
.auth-input[id="identifier"]{font-family:'IBM Plex Mono','Inter',monospace;letter-spacing:.02em}
.auth-input::placeholder{color:#C7CDDB;font-family:'Inter',sans-serif;letter-spacing:normal}
.auth-input:hover{border-color:#C7CDDB}
.auth-input:focus{border-color:var(--navy);box-shadow:0 0 0 4px rgba(11,42,107,.12);background:#fff}
.auth-input:focus + .pw-toggle{color:var(--navy)}
.auth-field:focus-within .auth-input-wrap::after{width:100%}
.auth-input.error{border-color:var(--danger);box-shadow:0 0 0 3px rgba(220,38,38,.10);animation:shake .4s cubic-bezier(.36,.07,.19,.97)}
.auth-input.valid{border-color:var(--success)}
.auth-input:-webkit-autofill,
.auth-input:-webkit-autofill:hover,
.auth-input:-webkit-autofill:focus{
    -webkit-text-fill-color:var(--ink);
    box-shadow:0 0 0 1000px #fff inset;
    transition:background-color 9999s ease-in-out 0s;
}
@keyframes shake{10%,90%{transform:translateX(-1px)}20%,80%{transform:translateX(2px)}30%,50%,70%{transform:translateX(-5px)}40%,60%{transform:translateX(5px)}}

.pw-toggle{position:absolute;right:.85rem;top:50%;transform:translateY(-50%);background:none;border:0;color:#9AA3B8;cursor:pointer;font-size:18px;padding:4px 6px;transition:color .2s ease,transform .15s ease}
.pw-toggle:hover{color:var(--navy)}
.pw-toggle:focus-visible{outline:2px solid var(--navy);outline-offset:2px;border-radius:6px}
.pw-toggle:active{transform:translateY(-50%) scale(.88)}

.caps-hint{font-size:.8rem;color:#B9740A;display:flex;align-items:center;gap:4px;opacity:0;max-height:0;overflow:hidden;transition:opacity .25s ease,max-height .25s ease,margin-top .25s ease}
.caps-hint.show{opacity:1;max-height:1.5rem;margin-top:.4rem}

.auth-error{display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--danger);margin-top:.45rem;animation:slideDown .3s cubic-bezier(.16,1,.3,1)}
.password-requirement{margin:.4rem 0 0;color:var(--slate);font-size:.75rem}

.auth-check-row{display:flex;align-items:center;justify-content:space-between;margin:1.4rem 0}
.remember-label{display:flex;align-items:center;gap:.6rem;font-size:.9rem;color:var(--slate);cursor:pointer;user-select:none}
.toggle{width:40px;height:24px;background:#D6DAE6;border-radius:12px;position:relative;cursor:pointer;transition:background .25s ease;flex-shrink:0}
.toggle.checked{background:var(--navy)}
.toggle::after{content:'';position:absolute;top:2px;left:2px;width:20px;height:20px;background:#fff;border-radius:50%;transition:transform .3s cubic-bezier(.34,1.56,.64,1);box-shadow:0 2px 4px rgba(0,0,0,.15)}
.toggle.checked::after{transform:translateX(16px)}
.forgot-link{font-size:.9rem;font-weight:600;color:var(--navy);text-decoration:none;position:relative}
.forgot-link::after{content:'';position:absolute;left:0;bottom:-2px;width:0;height:1.5px;background:var(--navy);transition:width .25s ease}
.forgot-link:hover::after{width:100%}
.forgot-link:focus-visible,.toggle:focus-visible{outline:2px solid var(--navy);outline-offset:2px}

/* ---------- Premium submit button ---------- */
.auth-submit{
    width:100%;padding:.95rem;border:0;
    background:linear-gradient(135deg,var(--navy) 0%,var(--navy-deep) 100%);
    background-size:160% 160%;
    color:#fff;font-size:.95rem;font-weight:700;border-radius:10px;cursor:pointer;
    transition:transform .22s cubic-bezier(.16,1,.3,1),box-shadow .22s ease,background-position .5s ease;
    box-shadow:0 4px 14px rgba(11,42,107,.28);position:relative;overflow:hidden;
    border-bottom:2px solid var(--gold);
    isolation:isolate;
}
.auth-submit::before{
    content:'';position:absolute;top:0;left:-60%;width:40%;height:100%;
    background:linear-gradient(120deg, transparent, rgba(255,255,255,.35), transparent);
    transform:skewX(-20deg);
    transition:left .6s ease;
    z-index:1;
}
.auth-submit:hover:not(:disabled)::before{left:130%}
.auth-submit:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 12px 26px rgba(11,42,107,.38);background-position:100% 50%}
.auth-submit:active:not(:disabled){transform:translateY(0)}
.auth-submit:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
.auth-submit:disabled{opacity:.65;cursor:not-allowed}
.btn-text{display:flex;align-items:center;justify-content:center;gap:.6rem;position:relative;z-index:2;transition:transform .2s ease}
.auth-submit:hover:not(:disabled) .btn-text i{transform:translateX(3px)}
.btn-text i{transition:transform .25s ease}
.btn-load{display:none;align-items:center;justify-content:center;gap:.6rem;position:relative;z-index:2}
.btn-load.show{display:flex}
.spinner{display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

.auth-divider{display:flex;align-items:center;gap:.8rem;margin:1.5rem 0;color:#9AA3B8;font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:.07em}
.auth-divider::before,.auth-divider::after{content:'';flex:1;height:1px;background:var(--line)}

.sias-btn{
    display:flex;align-items:center;justify-content:center;gap:.6rem;width:100%;padding:.85rem;
    border:1.5px solid var(--line);background:#fff;border-radius:10px;color:var(--slate);font-size:.94rem;font-weight:600;
    cursor:pointer;text-decoration:none;transition:border-color .25s ease,color .25s ease,background .25s ease,transform .18s cubic-bezier(.16,1,.3,1),box-shadow .25s ease;
}
.sias-btn:hover{border-color:var(--navy);color:var(--navy);background:#EEF2FC;transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,42,107,.12)}
.sias-btn:active{transform:translateY(0)}
.sias-btn:focus-visible{outline:2px solid var(--navy);outline-offset:2px}
.sias-sub{text-align:center;font-size:.78rem;color:#9AA3B8;margin:.6rem 0 0}

.trust-row{display:flex;flex-wrap:wrap;gap:1rem;justify-content:center;margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--line);font-size:.78rem;color:#9AA3B8}
.trust-item{display:flex;align-items:center;gap:.4rem;transition:color .2s ease}
.trust-item:hover{color:var(--navy)}
.trust-item i{color:var(--navy);font-size:13px}

.auth-footer{padding:1.1rem 2rem;text-align:center;font-size:.8rem;color:#9AA3B8;border-top:1px solid #F0F2F8}
.auth-footer a{color:var(--navy);text-decoration:none;font-weight:600;transition:color .2s ease}
.auth-footer a:hover{color:var(--navy-deep);text-decoration:underline}

.back-link{
    display:inline-flex;align-items:center;gap:.4rem;margin-top:1.5rem;padding:.6rem 1rem;border-radius:8px;
    background:none;border:1px solid var(--line);color:var(--slate);font-size:.9rem;font-weight:600;cursor:pointer;
    text-decoration:none;transition:border-color .25s ease,color .25s ease,background .25s ease,transform .2s cubic-bezier(.16,1,.3,1);
    opacity:0;animation:fadeIn .6s ease .7s forwards;
}
.back-link:hover{border-color:var(--navy);color:var(--navy);background:#EEF2FC;transform:translateX(-3px)}
.back-link:focus-visible{outline:2px solid var(--navy);outline-offset:2px}
@keyframes fadeIn{to{opacity:1}}

.alert{padding:.85rem 1rem;border-radius:10px;font-size:.9rem;margin-bottom:1.2rem;display:flex;align-items:flex-start;gap:.6rem;animation:slideDown .4s cubic-bezier(.16,1,.3,1) forwards}
.alert.hidden{display:none}
@keyframes slideDown{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}
.alert-success{background:#DFF6EB;color:#0B6B44;border:1px solid #B7EAD2}
.alert-error{background:#FDECEC;color:#9A1B2A;border:1px solid #F7C9CE}
.alert i{flex-shrink:0;margin-top:2px;animation:pulseIcon 1.6s ease-in-out infinite}
@keyframes pulseIcon{0%,100%{transform:scale(1)}50%{transform:scale(1.15)}}

@media(max-width:480px){
    .auth-card{border-radius:18px}
    .crest-band{padding:1.5rem 1.25rem 1.25rem}
    .auth-header{padding:1.6rem 1.5rem .3rem}
    .auth-body{padding:1.2rem 1.5rem 1.5rem}
    .role-btn{font-size:10.5px;padding:.6rem .15rem}
    .auth-input,.auth-submit,.sias-btn{font-size:16px}
    .back-link{margin-left:auto;margin-right:auto}
}

@media (prefers-reduced-motion: reduce){
    *{animation-duration:.01ms !important;animation-iteration-count:1 !important;transition-duration:.01ms !important;}
    .auth-card,.stagger,.back-link{opacity:1 !important;transform:none !important}
}
</style>
<?php $__env->stopPush(); ?>

<div class="auth-wrapper">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="auth-container">
        <div class="auth-card" id="authCard">

            <div class="crest-band">
                <div class="logo-row">
                    <div class="crest-logo">
                        <img src="<?php echo e(asset('image/bagong-pilipinas-logo-png_seeklogo-534301.png')); ?>" alt="Bagong Pilipinas">
                    </div>
                    <div class="crest-logo brand">
                        <img src="<?php echo e(asset('image/logo%20new.jpg')); ?>" alt="SkillUp Logo">
                    </div>
                    <div class="crest-logo">
                        <img src="<?php echo e(asset('image/hello.png')); ?>" alt="Institution Logo">
                    </div>
                </div>
                <div class="flag-rule"><span class="b"></span><span class="w"></span><span class="r"></span></div>
            </div>

            <div class="auth-header stagger">
                <h1>Welcome back</h1>
                <p>Continue your learning journey</p>
            </div>

            <div class="auth-body">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="alert alert-success stagger" role="status">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$errors->has('identifier') && !$errors->has('email') && !$errors->has('password') && !$errors->has('login_as')): ?>
                        <div class="alert alert-error stagger" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Please check your details and try again.</span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form wire:submit="login" novalidate>

                    <!-- Role Selection -->
                    <div class="auth-field stagger">
                        <label class="role-label" id="roleLabel">Sign in as</label>
                        <div class="role-group" role="radiogroup" aria-labelledby="roleLabel" id="roleGroup">
                            <div class="role-indicator" id="roleIndicator"></div>
                            <button type="button" role="radio" aria-checked="<?php echo e($login_as === 'student' ? 'true' : 'false'); ?>" class="role-btn <?php echo e($login_as === 'student' ? 'active' : ''); ?>" wire:click="$set('login_as', 'student')">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Student</span>
                            </button>
                            <button type="button" role="radio" aria-checked="<?php echo e($login_as === 'teacher' ? 'true' : 'false'); ?>" class="role-btn <?php echo e($login_as === 'teacher' ? 'active' : ''); ?>" wire:click="$set('login_as', 'teacher')">
                                <i class="fas fa-chalkboard-user"></i>
                                <span>Instructor</span>
                            </button>
                            <button type="button" role="radio" aria-checked="<?php echo e($login_as === 'staff' ? 'true' : 'false'); ?>" class="role-btn <?php echo e($login_as === 'staff' ? 'active' : ''); ?>" wire:click="$set('login_as', 'staff')">
                                <i class="fas fa-user-tie"></i>
                                <span>Staff</span>
                            </button>
                            <button type="button" role="radio" aria-checked="<?php echo e($login_as === 'admin' ? 'true' : 'false'); ?>" class="role-btn <?php echo e($login_as === 'admin' ? 'active' : ''); ?>" wire:click="$set('login_as', 'admin')">
                                <i class="fas fa-shield-alt"></i>
                                <span>Admin</span>
                            </button>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['login_as'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Email / Student ID Field -->
                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="identifier">
                            <?php echo e($login_as === 'student' ? 'Student ID' : 'Email address'); ?>

                        </label>
                        <div class="auth-input-wrap">
                            <input
                                type="<?php echo e($login_as === 'student' ? 'text' : 'email'); ?>"
                                id="identifier"
                                wire:model="identifier"
                                class="auth-input <?php echo e($errors->has('identifier') || $errors->has('email') ? 'error' : ''); ?>"
                                placeholder="<?php echo e($login_as === 'student' ? 'Enter your Student ID' : 'name@example.com'); ?>"
                                autocomplete="<?php echo e($login_as === 'student' ? 'username' : 'email'); ?>"
                                required
                            >
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['identifier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Password Field -->
                    <div class="auth-field stagger">
                        <label class="auth-input-label" for="password">Password</label>
                        <div class="auth-input-wrap">
                            <input
                                type="password"
                                id="password"
                                wire:model="password"
                                class="auth-input <?php echo e($errors->has('password') ? 'error' : ''); ?>"
                                placeholder="••••••••"
                                autocomplete="current-password"
                                minlength="6"
                                aria-describedby="passwordRequirement"
                                required
                            >
                            <button type="button" class="pw-toggle" id="pwToggle" aria-label="Show password" aria-pressed="false">
                                <i class="fas fa-eye" id="pwIcon"></i>
                            </button>
                        </div>
                        <div class="caps-hint" id="capsHint" role="status">
                            <i class="fas fa-arrow-turn-up"></i>Caps Lock is on
                        </div>
                        <p class="password-requirement" id="passwordRequirement">Use at least 6 characters.</p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="auth-error"><i class="fas fa-exclamation-circle"></i><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="auth-check-row stagger">
                        <label class="remember-label">
                            <div class="toggle <?php echo e($remember ? 'checked' : ''); ?>" role="switch" aria-checked="<?php echo e($remember ? 'true' : 'false'); ?>" tabindex="0" wire:click="$toggle('remember')" wire:keydown.enter="$toggle('remember')" wire:keydown.space.prevent="$toggle('remember')">
                                <input type="checkbox" wire:model="remember" id="remember" style="display:none">
                            </div>
                            <span>Keep me signed in</span>
                        </label>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">Forgot?</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="auth-submit stagger" wire:loading.attr="disabled" wire:target="login">
                        <span class="btn-text" wire:loading.remove wire:target="login">
                            <span>Sign in</span>
                            <i class="fas fa-arrow-right-to-bracket"></i>
                        </span>
                        <span class="btn-load" wire:loading.class="show" wire:target="login">
                            <span class="spinner"></span>
                            <span>Signing in…</span>
                        </span>
                    </button>
                </form>

                <!-- Divider -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('sias.login.admin')): ?>
                <div class="auth-divider">Other access</div>

                <!-- NAVIS Login -->
                <a href="<?php echo e(route('sias.login.admin')); ?>" class="sias-btn">
                    <i class="fas fa-door-open"></i>
                    <span>NAVIS Login</span>
                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <p class="sias-sub">TESDA Academic &amp; Vocational Information System.</p>

                <!-- Trust Row -->
                <div class="trust-row">
                    <div class="trust-item">
                        <i class="fas fa-lock"></i>
                        <span>Encrypted</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-user-shield"></i>
                        <span>Role-based</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-bolt"></i>
                        <span>Instant</span>
                    </div>
                </div>
            </div>

            <div class="auth-footer">
                By signing in, you agree to our
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('terms')): ?>
                    <a href="<?php echo e(route('terms')); ?>">Terms</a>
                <?php else: ?>
                    <a href="/terms">Terms</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                and
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Route::has('privacy')): ?>
                    <a href="<?php echo e(route('privacy')); ?>">Privacy Policy</a>
                <?php else: ?>
                    <a href="/privacy">Privacy Policy</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <a href="<?php echo e(url('/')); ?>" class="back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Back to home</span>
        </a>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const pwToggle = document.getElementById('pwToggle');
        const pwIcon = document.getElementById('pwIcon');
        const capsHint = document.getElementById('capsHint');
        const authCard = document.getElementById('authCard');
        const roleGroup = document.getElementById('roleGroup');
        const roleIndicator = document.getElementById('roleIndicator');
        const roleButtons = document.querySelectorAll('.role-btn');

        // Card entrance animation (optional - card is now visible by default)
        if (authCard) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => authCard.classList.add('loaded'));
            });
        }

        // Sliding indicator behind the active role button
        function moveIndicator(btn, animate = true) {
            if (!btn || !roleIndicator || !roleGroup) return;
            const groupRect = roleGroup.getBoundingClientRect();
            const btnRect = btn.getBoundingClientRect();
            const offsetX = btnRect.left - groupRect.left - 4; // account for group padding
            if (!animate) roleIndicator.style.transition = 'none';
            roleIndicator.style.width = btnRect.width + 'px';
            roleIndicator.style.transform = `translateX(${offsetX}px)`;
            if (!animate) {
                requestAnimationFrame(() => { roleIndicator.style.transition = ''; });
            }
        }

        const initialActive = document.querySelector('.role-btn.active') || roleButtons[0];
        // wait one frame so layout is measured after fonts/icons settle
        requestAnimationFrame(() => moveIndicator(initialActive, false));
        window.addEventListener('resize', () => {
            const active = document.querySelector('.role-btn.active');
            moveIndicator(active, false);
        });

        // Password visibility toggle
        if (pwToggle && passwordInput) {
            pwToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                pwIcon.classList.toggle('fa-eye', !isPassword);
                pwIcon.classList.toggle('fa-eye-slash', isPassword);
                pwToggle.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
                pwToggle.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            });
        }

        // Caps Lock detection
        const checkCaps = (e) => {
            if (typeof e.getModifierState === 'function' && capsHint) {
                capsHint.classList.toggle('show', e.getModifierState('CapsLock'));
            }
        };

        if (passwordInput) {
            passwordInput.addEventListener('keyup', checkCaps);
            passwordInput.addEventListener('keydown', checkCaps);
            passwordInput.addEventListener('blur', () => {
                if (capsHint) capsHint.classList.remove('show');
            });
        }

        // Role button interactions
        roleButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                roleButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                btn.setAttribute('aria-checked', 'true');
                roleButtons.forEach(b => {
                    if (b !== btn) b.setAttribute('aria-checked', 'false');
                });
                moveIndicator(btn, true);
            });
        });

        // Form submission feedback
        const form = document.querySelector('form[wire\\:submit="login"]');
        if (form) {
            form.addEventListener('submit', () => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                }
            });
        }

        // Listen for Livewire finish event to re-enable button
        if (window.Livewire) {
            window.Livewire.on('finish', () => {
                const submitBtn = form?.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = false;
                }
            });
        }
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\skillupv2\resources\views/auth/login.blade.php ENDPATH**/ ?>