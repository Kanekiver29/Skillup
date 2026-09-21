<script>
document.addEventListener('DOMContentLoaded', function () {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const animated = document.querySelectorAll('[data-auth-animate]');

    if (!reduced && animated.length) {
        animated.forEach((el, i) => {
            el.style.animationDelay = (i * 60) + 'ms';
            requestAnimationFrame(() => el.classList.add('is-visible'));
        });
    } else {
        animated.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
    }

    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        const targetId = btn.getAttribute('data-toggle-password');
        const input = document.getElementById(targetId);
        if (!input) return;

        btn.addEventListener('click', function () {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            const icon = btn.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-eye', !show);
                icon.classList.toggle('fa-eye-slash', show);
            }
            const sr = btn.querySelector('.sr-only');
            if (sr) sr.textContent = show ? 'Hide password' : 'Show password';
        });
    });

    document.querySelectorAll('form[data-auth-submit]').forEach(function (form) {
        form.addEventListener('submit', function () {
            const btn = form.querySelector('[type="submit"]');
            if (!btn || btn.disabled) return;
            btn.disabled = true;
            const label = btn.querySelector('.auth-btn-label');
            const loading = btn.querySelector('.auth-btn-loading');
            if (label) label.classList.add('hidden');
            if (loading) loading.classList.remove('hidden');
        });
    });
});
</script>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\auth\partials\polish-scripts.blade.php ENDPATH**/ ?>