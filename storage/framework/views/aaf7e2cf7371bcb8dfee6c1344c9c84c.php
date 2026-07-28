<?php $__env->startSection('title', 'Messages - SkillUp'); ?>

<?php $__env->startSection('content'); ?>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#eef0fb;--panel:#fff;--sidebar-w:340px;
  --accent:#7c5cff;--accent-2:#4f46e5;--accent-soft:#f1ecff;
  --accent-grad:linear-gradient(135deg,#7c3aed,#4f46e5);
  --tp:#0f0f1a;--ts:#6b6f8a;--border:#e6e7f5;
  --hover:#f4f3fc;--online:#22c55e;--badge:#ef4360;
  --hh:64px;--font:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;
}
html,body{height:100%;background:var(--bg);font-family:var(--font);-webkit-font-smoothing:antialiased}

@keyframes gradientShift{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
@keyframes floatOrb{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(24px,-26px) scale(1.08)}}
@keyframes fadeUp{from{opacity:0;transform:translateY(10px) scale(.98)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
@keyframes slideRight{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}
@keyframes bounce{0%,60%,100%{transform:translateY(0)}30%{transform:translateY(-5px)}}
@keyframes pulse{0%{transform:scale(1);opacity:.8}100%{transform:scale(1.7);opacity:0}}
@keyframes wave{0%,100%{transform:scaleY(1)}50%{transform:scaleY(1.8)}}
@keyframes glowPulse{0%,100%{box-shadow:0 0 0 0 rgba(124,92,255,.35)}50%{box-shadow:0 0 0 8px rgba(124,92,255,0)}}
@keyframes dotPulse{0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,.5)}50%{box-shadow:0 0 0 5px rgba(34,197,94,0)}}
@keyframes shimmerSweep{0%{transform:translateX(-120%) skewX(-18deg)}100%{transform:translateX(240%) skewX(-18deg)}}
@keyframes spinSlow{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}

/* Ambient page backdrop */
body::before,body::after{content:'';position:fixed;border-radius:9999px;filter:blur(90px);opacity:.28;pointer-events:none;z-index:0;animation:floatOrb 12s ease-in-out infinite}
body::before{width:340px;height:340px;background:#a78bfa;top:-80px;left:5%}
body::after{width:300px;height:300px;background:#60a5fa;bottom:-80px;right:6%;animation-delay:3s}

/* Shell */
.shell{position:relative;z-index:1;display:flex;height:92vh;max-width:1180px;margin:24px auto;background:rgba(255,255,255,.82);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,.7);border-radius:24px;box-shadow:0 30px 70px -30px rgba(76,29,149,.28),0 0 0 1px var(--border);overflow:hidden}

/* ─── SIDEBAR ─── */
.sidebar{width:var(--sidebar-w);flex-shrink:0;display:flex;flex-direction:column;border-right:1px solid var(--border);overflow:hidden;background:rgba(255,255,255,.5)}
.sb-head{height:var(--hh);padding:0 18px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.sb-title{font-size:24px;font-weight:800;background:var(--accent-grad);-webkit-background-clip:text;background-clip:text;color:transparent;letter-spacing:-.5px}
.sb-btns{display:flex;gap:6px}
.ib{width:38px;height:38px;border-radius:50%;background:var(--hover);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--tp);transition:background .18s,transform .18s;flex-shrink:0}
.ib:hover{background:var(--accent-soft);color:var(--accent-2);transform:translateY(-1px)}
.ib:active{transform:scale(.94)}
.ib svg{pointer-events:none}
.search-wrap{padding:6px 16px 4px;flex-shrink:0}
.search-box{display:flex;align-items:center;gap:8px;background:var(--hover);border-radius:50px;padding:9px 15px;border:1px solid transparent;transition:border-color .2s,box-shadow .2s}
.search-box:focus-within{border-color:rgba(124,92,255,.4);box-shadow:0 0 0 3px rgba(124,92,255,.12);background:#fff}
.search-box input{border:none;background:transparent;font-size:15px;color:var(--tp);outline:none;width:100%;font-family:var(--font)}
.search-box input::placeholder{color:var(--ts)}
.tab-row{display:flex;padding:8px 16px 4px;gap:4px;flex-shrink:0}
.tab{flex:1;padding:8px;text-align:center;font-size:13px;font-weight:700;color:var(--ts);border:none;background:none;cursor:pointer;border-radius:10px;transition:background .18s,color .18s;font-family:var(--font)}
.tab.active{color:#fff;background:var(--accent-grad);box-shadow:0 6px 16px -6px rgba(124,58,237,.5)}
.tab:hover:not(.active){background:var(--hover)}
.thread-list{flex:1;overflow-y:auto;padding:6px 8px}
.thread-list::-webkit-scrollbar{width:4px}
.thread-list::-webkit-scrollbar-thumb{background:#cfd0e6;border-radius:4px}

/* Thread item */
.thread-item{display:flex;align-items:center;gap:12px;padding:10px 10px;cursor:pointer;transition:background .16s,transform .16s;position:relative;user-select:none;border-radius:14px;margin-bottom:2px}
.thread-item:hover{background:var(--hover);transform:translateX(2px)}
.thread-item.active{background:linear-gradient(90deg,rgba(124,92,255,.12),rgba(79,70,229,.06))}
.thread-item.active::before{content:'';position:absolute;left:0;top:14%;bottom:14%;width:3px;border-radius:4px;background:var(--accent-grad)}
.thread-item.active .t-name{color:var(--accent-2)}
.av-wrap{position:relative;flex-shrink:0}
.av{width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:19px;font-weight:700;color:#fff;background:linear-gradient(135deg,#7c5cff,#4f46e5);user-select:none;flex-shrink:0;box-shadow:0 4px 14px -4px rgba(79,70,229,.45);transition:transform .2s}
.thread-item:hover .av{transform:scale(1.05)}
.av.green{background:linear-gradient(135deg,#31a24c,#1e7a38)}
.av.purple{background:linear-gradient(135deg,#7b5ea7,#5b3fa0)}
.av.orange{background:linear-gradient(135deg,#f7951d,#d4780a)}
.av.rose{background:linear-gradient(135deg,#e44d6b,#b5274b)}
.av.teal{background:linear-gradient(135deg,#17b5b5,#0d8a8a)}
.av.pink{background:linear-gradient(135deg,#f06292,#e91e63)}
.odot{position:absolute;bottom:2px;right:2px;width:13px;height:13px;background:var(--online);border-radius:50%;border:2.5px solid #fff;animation:dotPulse 2.2s ease-in-out infinite}
.t-info{flex:1;min-width:0}
.t-top{display:flex;align-items:center;justify-content:space-between;gap:6px}
.t-name{font-size:15px;font-weight:700;color:var(--tp);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.t-time{font-size:12px;color:var(--ts);flex-shrink:0;white-space:nowrap}
.t-time.u{color:var(--accent-2);font-weight:700}
.t-prev{display:flex;align-items:center;gap:6px;margin-top:2px}
.prev-txt{font-size:13px;color:var(--ts);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex:1}
.prev-txt.b{color:var(--tp);font-weight:600}
.ubadge{min-width:20px;height:20px;background:linear-gradient(135deg,#ef4360,#c81e46);color:#fff;font-size:11px;font-weight:800;border-radius:50px;display:flex;align-items:center;justify-content:center;padding:0 6px;flex-shrink:0;animation:glowPulse 2.4s ease-in-out infinite}

/* ─── CHAT MAIN ─── */
.chat-main{flex:1;display:flex;flex-direction:column;overflow:hidden;background:rgba(255,255,255,.55)}
.chat-header{height:var(--hh);display:flex;align-items:center;gap:12px;padding:0 16px;border-bottom:1px solid var(--border);flex-shrink:0;background:rgba(255,255,255,.6);backdrop-filter:blur(10px)}
.chat-header .av{width:42px;height:42px;font-size:16px}
.ch-info{flex:1}
.ch-name{font-size:15px;font-weight:800;color:var(--tp)}
.ch-status{font-size:12px;color:var(--online);font-weight:600;margin-top:1px;display:flex;align-items:center;gap:5px}
.ch-status::before{content:'';width:6px;height:6px;border-radius:50%;background:var(--online);animation:dotPulse 2.2s ease-in-out infinite}
.ch-actions{display:flex;gap:4px}
.ib.accent{color:var(--accent-2)}
.ib.accent:hover{background:var(--accent-soft)}

/* Messages */
.msgs{flex:1;overflow-y:auto;padding:20px 20px;display:flex;flex-direction:column;gap:4px;background:
  radial-gradient(circle at 15% 8%, rgba(124,92,255,.05), transparent 40%),
  radial-gradient(circle at 85% 92%, rgba(79,70,229,.05), transparent 40%)}
.msgs::-webkit-scrollbar{width:4px}
.msgs::-webkit-scrollbar-thumb{background:#cfd0e6;border-radius:4px}
.date-sep{text-align:center;color:var(--ts);font-size:12px;font-weight:700;margin:10px 0 8px;letter-spacing:.3px}
.br{display:flex;align-items:flex-end;gap:8px;max-width:74%;animation:fadeUp .28s cubic-bezier(.22,1,.36,1) both}
.br.mine{align-self:flex-end;flex-direction:row-reverse}
.br.theirs{align-self:flex-start}
.br .av-sm{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;flex-shrink:0}
.br.mine .av-sm{display:none}
.bub{padding:11px 15px;border-radius:19px;font-size:15px;line-height:1.5;word-break:break-word;position:relative;transition:transform .15s}
.bub:hover{transform:translateY(-1px)}
.bub.mine{background:var(--accent-grad);color:#fff;border-bottom-right-radius:4px;box-shadow:0 6px 16px -8px rgba(79,70,229,.55)}
.bub.theirs{background:#fff;color:var(--tp);border-bottom-left-radius:4px;box-shadow:0 2px 8px -4px rgba(15,15,26,.12);border:1px solid var(--border)}
.br.mine+.br.mine .bub.mine{border-top-right-radius:4px}
.br.theirs+.br.theirs .bub.theirs{border-top-left-radius:4px}
.reaction{position:absolute;bottom:-9px;right:5px;background:#fff;border-radius:50px;padding:1px 5px;font-size:12px;box-shadow:0 1px 4px rgba(0,0,0,.18);white-space:nowrap}

/* Typing */
.typing-row{display:flex;align-items:flex-end;gap:8px;align-self:flex-start;margin-top:4px}
.typing-bub{background:#fff;border:1px solid var(--border);border-radius:18px;border-bottom-left-radius:4px;padding:12px 16px;display:flex;gap:4px;align-items:center}
.dot{width:7px;height:7px;background:var(--accent);border-radius:50%;animation:bounce 1.2s infinite}
.dot:nth-child(2){animation-delay:.2s}.dot:nth-child(3){animation-delay:.4s}

/* Composer */
.composer{border-top:1px solid var(--border);padding:12px 16px;display:flex;align-items:center;gap:6px;flex-shrink:0;background:rgba(255,255,255,.6);position:relative}
.comp-wrap{flex:1;background:var(--hover);border-radius:50px;padding:11px 18px;display:flex;align-items:center;border:1px solid transparent;transition:border-color .2s,box-shadow .2s,background .2s}
.comp-wrap:focus-within{border-color:rgba(124,92,255,.4);box-shadow:0 0 0 3px rgba(124,92,255,.12);background:#fff}
.comp-input{border:none;background:transparent;font-size:15px;color:var(--tp);outline:none;width:100%;font-family:var(--font);resize:none;max-height:100px;overflow-y:auto;line-height:1.4}
.comp-input::placeholder{color:var(--ts)}
.send-btn{width:38px;height:38px;border-radius:50%;background:var(--accent-grad);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;transition:transform .15s,box-shadow .15s;flex-shrink:0;box-shadow:0 6px 16px -6px rgba(79,70,229,.55)}
.send-btn:hover{transform:scale(1.08) rotate(6deg);box-shadow:0 8px 22px -6px rgba(79,70,229,.65)}
.send-btn:active{transform:scale(.92)}

/* Empty chat */
.chat-empty{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:14px;color:var(--ts);padding:40px}
.ce-icon{width:84px;height:84px;background:var(--accent-soft);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:36px;position:relative;box-shadow:inset 0 0 0 1px rgba(124,92,255,.15)}
.ce-icon::before{content:'';position:absolute;inset:-10px;border-radius:50%;border:2px dashed rgba(124,92,255,.25);animation:spinSlow 16s linear infinite}
.chat-empty h2{font-size:21px;font-weight:800;color:var(--tp)}
.chat-empty p{font-size:14px;text-align:center;max-width:240px;line-height:1.55}

/* ─── CALL MODAL ─── */
.call-overlay{position:fixed;inset:0;background:rgba(10,8,25,.6);backdrop-filter:blur(8px);display:none;align-items:center;justify-content:center;z-index:1000;animation:fadeIn .25s}
.call-overlay.show{display:flex}
.call-modal{border-radius:28px;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,.5),0 0 0 1px rgba(124,92,255,.15);display:flex;flex-direction:column;animation:slideUp .32s cubic-bezier(.22,1,.36,1)}

/* Video call */
.vcall{width:520px;background:#0f0e24;position:relative}
.vcall-video{width:100%;height:320px;background:linear-gradient(160deg,#241a52 0%,#161233 60%,#0a0918 100%);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.vcall-video::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 50% 40%,rgba(124,92,255,.24) 0%,transparent 70%)}
.vcall-video::after{content:'';position:absolute;width:200%;height:200%;top:-50%;left:-50%;background:
  linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
  linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
  background-size:34px 34px;animation:spinSlow 60s linear infinite;opacity:.5}
.caller-avatar{width:90px;height:90px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:34px;font-weight:700;color:#fff;position:relative;z-index:1;box-shadow:0 0 0 3px rgba(255,255,255,.15),0 0 44px rgba(124,92,255,.5)}
.pulse-ring{position:absolute;width:110px;height:110px;border-radius:50%;border:2px solid rgba(124,92,255,.45);animation:pulse 1.8s ease-out infinite}
.pulse-ring:nth-child(2){animation-delay:.6s;border-color:rgba(124,92,255,.28)}
.self-thumb{position:absolute;bottom:12px;right:12px;width:100px;height:75px;background:linear-gradient(135deg,#382b74,#1c1740);border-radius:12px;border:2px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#fff;z-index:2;overflow:hidden}
.self-thumb::after{content:'You';position:absolute;bottom:4px;left:0;right:0;text-align:center;font-size:10px;color:rgba(255,255,255,.6);font-weight:500}
.vcall-info{padding:18px 20px 8px;text-align:center}
.vcall-name{font-size:20px;font-weight:800;color:#fff;letter-spacing:-.3px}
.vcall-state{font-size:13px;color:rgba(255,255,255,.55);margin-top:4px}
.vcall-timer{font-size:28px;font-weight:300;color:#fff;letter-spacing:2px;margin-top:8px;font-variant-numeric:tabular-nums;display:none}
.vcall-controls{display:flex;align-items:center;justify-content:center;gap:16px;padding:16px 20px 22px}
.cc{width:52px;height:52px;border-radius:50%;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:transform .15s,opacity .15s,box-shadow .15s;flex-shrink:0}
.cc:hover{transform:scale(1.08)}
.cc:active{transform:scale(.94)}
.cc.gray{background:rgba(255,255,255,.12);color:#fff}
.cc.gray:hover{background:rgba(255,255,255,.2)}
.cc.red{background:linear-gradient(135deg,#ef4360,#c81e46);color:#fff}
.cc.red:hover{box-shadow:0 8px 20px -6px rgba(239,67,96,.6)}
.cc.blue{background:var(--accent-grad);color:#fff}
.cc.blue:hover{box-shadow:0 8px 20px -6px rgba(124,92,255,.6)}
.cc.toggled{background:rgba(255,255,255,.9);color:#333}

/* Audio call */
.acall{width:340px;background:linear-gradient(160deg,#241a52 0%,#0c0a1e 100%);padding:32px 28px 24px;text-align:center;position:relative;overflow:hidden}
.acall::before{content:'';position:absolute;top:-60px;left:-60px;width:180px;height:180px;background:rgba(124,92,255,.25);border-radius:50%;filter:blur(50px);animation:floatOrb 8s ease-in-out infinite}
.acall-av{width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:30px;font-weight:700;color:#fff;margin:0 auto 16px;position:relative;z-index:1;box-shadow:0 0 0 4px rgba(255,255,255,.1),0 0 40px rgba(124,92,255,.4)}
.acall-name{font-size:22px;font-weight:800;color:#fff;letter-spacing:-.4px;position:relative;z-index:1}
.acall-state{font-size:13px;color:rgba(255,255,255,.5);margin-top:6px;position:relative;z-index:1}
.acall-timer{font-size:26px;font-weight:300;color:#fff;letter-spacing:2px;margin-top:10px;font-variant-numeric:tabular-nums;display:none;position:relative;z-index:1}
.sound-waves{display:flex;align-items:center;justify-content:center;gap:5px;height:36px;margin:16px 0;position:relative;z-index:1}
.wave{width:4px;border-radius:4px;background:linear-gradient(180deg,#a78bfa,#7c5cff);animation:wave 1s ease-in-out infinite}
.wave:nth-child(1){height:10px;animation-delay:0s}
.wave:nth-child(2){height:20px;animation-delay:.15s}
.wave:nth-child(3){height:30px;animation-delay:.3s}
.wave:nth-child(4){height:20px;animation-delay:.45s}
.wave:nth-child(5){height:10px;animation-delay:.6s}
.acall-controls{display:flex;align-items:center;justify-content:center;gap:20px;margin-top:20px;position:relative;z-index:1}

/* Emoji picker */
.emoji-picker{position:absolute;bottom:60px;left:10px;background:#fff;border-radius:16px;padding:10px;box-shadow:0 12px 34px rgba(76,29,149,.2);border:1px solid var(--border);display:none;flex-wrap:wrap;gap:4px;width:240px;z-index:50;animation:fadeUp .18s ease}
.emoji-picker.show{display:flex}
.ep-btn{font-size:22px;cursor:pointer;padding:4px;border-radius:8px;border:none;background:none;transition:transform .12s}
.ep-btn:hover{transform:scale(1.28)}

/* Notification toast */
.toast{position:fixed;top:20px;right:20px;background:rgba(15,14,32,.92);backdrop-filter:blur(10px);color:#fff;border-radius:16px;padding:12px 18px;font-size:14px;font-weight:600;z-index:2000;animation:slideRight .3s cubic-bezier(.22,1,.36,1);display:flex;align-items:center;gap:10px;box-shadow:0 14px 34px rgba(15,14,32,.35);border:1px solid rgba(124,92,255,.25)}

/* Responsive */
@media(max-width:640px){
  .shell{margin:0;height:100vh;border-radius:0}
  .sidebar{width:100%}.chat-main{display:none}
}
</style>

<!-- ══ TOAST ══ -->
<div id="toast" style="display:none" class="toast">
  <span id="toastIcon">📞</span>
  <span id="toastMsg">Calling…</span>
</div>

<!-- ══ VIDEO CALL MODAL ══ -->
<div class="call-overlay" id="vcallOverlay">
  <div class="call-modal vcall" id="vcallModal">
    <div class="vcall-video">
      <!-- pulse rings -->
      <div class="pulse-ring"></div>
      <div class="pulse-ring"></div>
      <div id="vcallAv" class="caller-avatar av green">M</div>
      <!-- self thumbnail -->
      <div class="self-thumb">😊</div>
    </div>
    <div class="vcall-info">
      <div class="vcall-name" id="vcallName">Maria Santos</div>
      <div class="vcall-state" id="vcallState">Connecting…</div>
      <div class="vcall-timer" id="vcallTimer">0:00</div>
    </div>
    <div class="vcall-controls">
      <button class="cc gray" id="vcMicBtn" title="Mute" onclick="toggleVC('mic')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14a3 3 0 0 0 3-3V5a3 3 0 0 0-6 0v6a3 3 0 0 0 3 3zm5-3a5 5 0 0 1-10 0H5a7 7 0 0 0 6 6.93V20H9v2h6v-2h-2v-2.07A7 7 0 0 0 19 11h-2z"/></svg>
      </button>
      <button class="cc gray" id="vcCamBtn" title="Camera off" onclick="toggleVC('cam')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-3.5l4 4v-11l-4 4z"/></svg>
      </button>
      <button class="cc red" title="End call" onclick="endCall('video')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02L6.62 10.79z"/></svg>
      </button>
      <button class="cc gray" id="vcSpkBtn" title="Speaker" onclick="toggleVC('spk')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3A4.5 4.5 0 0 0 14 7.97v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
      </button>
      <button class="cc blue" title="Flip" onclick="showToast('📷','Camera flipped')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6V3L8 7l4 4V8c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46A7.93 7.93 0 0 0 20 14c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 9.74A7.93 7.93 0 0 0 4 14c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/></svg>
      </button>
    </div>
  </div>
</div>

<!-- ══ AUDIO CALL MODAL ══ -->
<div class="call-overlay" id="acallOverlay">
  <div class="call-modal acall">
    <div class="acall-av av green" id="acallAv">M</div>
    <div class="acall-name" id="acallName">Maria Santos</div>
    <div class="acall-state" id="acallState">Calling…</div>
    <div class="acall-timer" id="acallTimer">0:00</div>
    <div class="sound-waves" id="soundWaves">
      <div class="wave"></div><div class="wave"></div><div class="wave"></div><div class="wave"></div><div class="wave"></div>
    </div>
    <div class="acall-controls">
      <button class="cc gray" id="acMicBtn" title="Mute" onclick="toggleAC('mic')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14a3 3 0 0 0 3-3V5a3 3 0 0 0-6 0v6a3 3 0 0 0 3 3zm5-3a5 5 0 0 1-10 0H5a7 7 0 0 0 6 6.93V20H9v2h6v-2h-2v-2.07A7 7 0 0 0 19 11h-2z"/></svg>
      </button>
      <button class="cc red" title="End call" onclick="endCall('audio')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02L6.62 10.79z"/></svg>
      </button>
      <button class="cc gray" id="acSpkBtn" title="Speaker" onclick="toggleAC('spk')">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3A4.5 4.5 0 0 0 14 7.97v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/></svg>
      </button>
    </div>
  </div>
</div>

<!-- ══ MAIN SHELL ══ -->
<div class="shell">

  <aside class="sidebar">
    <div class="sb-head">
      <span class="sb-title">Chats</span>
      <div class="sb-btns">
        <button class="ib" title="New message" onclick="showToast('✏️','New message')">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
        </button>
        <button class="ib" title="Options" onclick="showToast('⚙️','Options')">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
        </button>
      </div>
    </div>

    <div class="search-wrap">
      <div class="search-box">
        <svg width="15" height="15" fill="none" stroke="#6b6f8a" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" placeholder="Search your conversations" id="searchInput"/>
      </div>
    </div>

    <div class="thread-list" id="threadList">
      <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
          $participant = $conversation->getOtherParticipant(auth()->id());
          $latest = $conversation->latestMessage;
          $preview = $latest ? Str::limit($latest->body, 44) : 'No messages yet';
          $isActive = $selectedConversation && $selectedConversation->id === $conversation->id;
        ?>
        <a class="thread-item <?php echo e($isActive ? 'active' : ''); ?>" href="<?php echo e(route('chats.index', ['conversation' => $conversation->id])); ?>">
          <div class="av-wrap">
            <div class="av green" style="width:52px;height:52px;font-size:19px"><?php echo e(strtoupper(substr($participant?->name ?? 'S', 0, 1))); ?></div>
            <?php if($conversation->user_unread_count > 0): ?>
              <span class="odot"></span>
            <?php endif; ?>
          </div>
          <div class="t-info">
            <div class="t-top">
              <span class="t-name"><?php echo e($participant?->name ?? 'Support team'); ?></span>
              <span class="t-time <?php echo e($latest && $latest->created_at->isToday() ? '' : 'u'); ?>"><?php echo e($latest?->created_at?->format('H:i') ?? 'now'); ?></span>
            </div>
            <div class="t-prev">
              <span class="prev-txt <?php echo e($latest ? '' : 'b'); ?>"><?php echo e($preview); ?></span>
              <?php if($conversation->user_unread_count > 0): ?>
                <span class="ubadge"><?php echo e($conversation->user_unread_count); ?></span>
              <?php endif; ?>
            </div>
          </div>
        </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="p-4 text-sm text-slate-500">No conversations yet.</div>
      <?php endif; ?>
    </div>
  </aside>

  <main class="chat-main" id="chatMain">
    <?php if($selectedConversation && $otherParticipant): ?>
      <div class="chat-header" id="chatHeader">
        <div class="av-wrap">
          <div class="av green" id="headerAv" style="width:42px;height:42px;font-size:16px"><?php echo e(strtoupper(substr($otherParticipant->name, 0, 1))); ?></div>
          <span class="odot" id="headerDot" style="width:11px;height:11px;display:block"></span>
        </div>
        <div class="ch-info">
          <div class="ch-name" id="headerName"><?php echo e($otherParticipant->name); ?></div>
          <div class="ch-status" id="headerStatus">Active now</div>
        </div>
        <div class="ch-actions">
          <button class="ib accent" title="Audio call" onclick="startCall('audio')">
            <svg width="19" height="19" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02L6.62 10.79z"/></svg>
          </button>
          <button class="ib accent" title="Video call" onclick="startCall('video')">
            <svg width="19" height="19" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-3.5l4 4v-11l-4 4z"/></svg>
          </button>
        </div>
      </div>

      <div class="msgs" id="msgsArea">
        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="br <?php echo e($message->sender_id === auth()->id() ? 'mine' : 'theirs'); ?>">
            <?php if($message->sender_id !== auth()->id()): ?>
              <div class="av-sm av green"><?php echo e(strtoupper(substr($message->sender->name ?? 'S', 0, 1))); ?></div>
            <?php endif; ?>
            <div>
              <div class="bub <?php echo e($message->sender_id === auth()->id() ? 'mine' : 'theirs'); ?>"><?php echo e($message->body); ?></div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="chat-empty">
            <div class="ce-icon">💬</div>
            <h2>No messages yet</h2>
            <p>Send the first message to start this conversation.</p>
          </div>
        <?php endif; ?>
      </div>

      <div class="emoji-picker" id="emojiPicker">
        <button class="ep-btn" type="button" onclick="insertEmoji('😊')">😊</button>
        <button class="ep-btn" type="button" onclick="insertEmoji('😂')">😂</button>
        <button class="ep-btn" type="button" onclick="insertEmoji('❤️')">❤️</button>
        <button class="ep-btn" type="button" onclick="insertEmoji('👍')">👍</button>
        <button class="ep-btn" type="button" onclick="insertEmoji('🙏')">🙏</button>
      </div>

      <form class="composer" id="composerForm" action="<?php echo e(route('chats.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="conversation_id" value="<?php echo e($selectedConversation->id); ?>">
        <button class="ib accent" type="button" title="Attach" onclick="showToast('📎','Attach file')">
          <svg width="19" height="19" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 6v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5a2.5 2.5 0 0 1 5 0v10.5c0 .55-.45 1-1 1s-1-.45-1-1V6H10v9.5a2.5 2.5 0 0 0 5 0V5c0-2.21-1.79-4-4-4S7 2.79 7 5v12.5c0 3.04 2.46 5.5 5.5 5.5s5.5-2.46 5.5-5.5V6h-1.5z"/></svg>
        </button>
        <button class="ib accent" type="button" title="Emoji" id="emojiToggle">
          <svg width="19" height="19" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
        </button>

        <div class="comp-wrap">
          <textarea class="comp-input" id="compInput" rows="1" name="body" placeholder="Type a message"></textarea>
        </div>

        <button class="send-btn" id="sendBtn" type="submit">
          <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
      </form>
    <?php else: ?>
      <div class="chat-empty">
        <div class="ce-icon">💬</div>
        <h2>No conversation selected</h2>
        <p>Select a conversation from the inbox to start reading or replying.</p>
      </div>
    <?php endif; ?>
  </main>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const compInput = document.getElementById('compInput');
    const composerForm = document.getElementById('composerForm');
    const msgsArea = document.getElementById('msgsArea');
    const emojiPicker = document.getElementById('emojiPicker');
    const emojiToggle = document.getElementById('emojiToggle');

    if (msgsArea) {
      msgsArea.scrollTop = msgsArea.scrollHeight;
    }

    if (compInput) {
      compInput.addEventListener('input', function () {
        compInput.style.height = 'auto';
        compInput.style.height = Math.min(compInput.scrollHeight, 120) + 'px';
      });

      compInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          if (composerForm) {
            composerForm.requestSubmit();
          }
        }
      });
    }

    if (emojiToggle && emojiPicker) {
      emojiToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        emojiPicker.classList.toggle('show');
      });
      document.addEventListener('click', function () {
        emojiPicker.classList.remove('show');
      });
      emojiPicker.addEventListener('click', function (e) {
        e.stopPropagation();
      });
    }
  });

  function insertEmoji(em) {
    const compInput = document.getElementById('compInput');
    if (compInput) {
      compInput.value += em;
      compInput.focus();
    }
  }

  let callTimer = null;
  let callSeconds = 0;
  function startCall(type) {
    const overlay = type === 'video' ? document.getElementById('vcallOverlay') : document.getElementById('acallOverlay');
    const state = type === 'video' ? document.getElementById('vcallState') : document.getElementById('acallState');
    const timer = type === 'video' ? document.getElementById('vcallTimer') : document.getElementById('acallTimer');
    if (!overlay || !state || !timer) return;

    clearInterval(callTimer);
    callSeconds = 0;
    state.textContent = type === 'video' ? 'Connecting…' : 'Calling…';
    timer.style.display = 'none';
    overlay.classList.add('show');

    setTimeout(function () {
      state.textContent = type === 'video' ? 'Connected' : 'Connected';
      timer.style.display = 'block';
      startTimer(timer.id);
    }, 1800);
  }

  function endCall(type) {
    clearInterval(callTimer);
    const overlay = type === 'video' ? document.getElementById('vcallOverlay') : document.getElementById('acallOverlay');
    if (overlay) overlay.classList.remove('show');
  }

  function startTimer(elId) {
    callTimer = setInterval(function () {
      callSeconds++;
      const m = Math.floor(callSeconds / 60);
      const s = callSeconds % 60;
      const el = document.getElementById(elId);
      if (el) {
        el.textContent = m + ':' + (s < 10 ? '0' : '') + s;
      }
    }, 1000);
  }

  function toggleVC(kind) {
    const btn = kind === 'mic' ? document.getElementById('vcMicBtn') : kind === 'cam' ? document.getElementById('vcCamBtn') : document.getElementById('vcSpkBtn');
    if (btn) btn.classList.toggle('toggled');
  }

  function toggleAC(kind) {
    const btn = kind === 'mic' ? document.getElementById('acMicBtn') : document.getElementById('acSpkBtn');
    if (btn) btn.classList.toggle('toggled');
  }

  function showToast(icon, msg) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    document.getElementById('toastIcon').textContent = icon;
    document.getElementById('toastMsg').textContent = msg;
    toast.style.display = 'flex';
    clearTimeout(window.chatToastTimer);
    window.chatToastTimer = setTimeout(function () {
      toast.style.display = 'none';
    }, 2200);
  }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\skilluplastest\resources\views/chats/index.blade.php ENDPATH**/ ?>