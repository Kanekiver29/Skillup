// Minimal JS helpers for Staff dashboard
window.staffHelpers = {
    qs: (sel) => document.querySelector(sel),
    qsa: (sel) => Array.from(document.querySelectorAll(sel)),
    navTo: (url) => { window.location = url },
}

// small DOM ready helper
document.addEventListener('DOMContentLoaded', function(){
    // collapse mobile nav etc. placeholder
});
