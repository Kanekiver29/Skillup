<script>
(function () {
    function revealAll() {
        document.querySelectorAll('[data-admin-animate]').forEach(function (el) {
            el.classList.add('admin-visible');
            el.style.opacity = '1';
            el.style.transform = 'none';
            el.style.filter = 'none';
        });
    }

    function initAdminAnimations() {
        const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        document.documentElement.classList.add('admin-animate-enabled');

        const items = document.querySelectorAll('[data-admin-animate]');

        if (!items.length) {
            return;
        }

        if (reduced || typeof IntersectionObserver === 'undefined') {
            revealAll();
            return;
        }

        const observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('admin-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05, rootMargin: '0px 0px -20px 0px' });

        items.forEach(function (el, i) {
            if (!el.classList.contains('admin-delay-1') &&
                !el.classList.contains('admin-delay-2') &&
                !el.classList.contains('admin-delay-3') &&
                !el.classList.contains('admin-delay-4') &&
                !el.classList.contains('admin-delay-5')) {
                el.style.animationDelay = (i * 45) + 'ms';
            }
            observer.observe(el);
        });

        // Above-the-fold: reveal immediately
        requestAnimationFrame(function () {
            items.forEach(function (el) {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    el.classList.add('admin-visible');
                    observer.unobserve(el);
                }
            });
        });

        // Safety net if observer never fires (e.g. scripts blocked late)
        setTimeout(function () {
            document.querySelectorAll('[data-admin-animate]:not(.admin-visible)').forEach(function (el) {
                el.classList.add('admin-visible');
            });
        }, 1500);
    }

    function initAdminCounters() {
        document.querySelectorAll('[data-admin-count]').forEach(function (el) {
            const end = parseInt(el.dataset.adminCount, 10);
            if (isNaN(end)) return;
            const suffix = el.dataset.adminSuffix || '';
            const duration = 1200;
            const startTime = performance.now();

            const run = function () {
                const tick = function (now) {
                    const t = Math.min((now - startTime) / duration, 1);
                    const eased = 1 - Math.pow(1 - t, 3);
                    el.textContent = Math.floor(eased * end) + suffix;
                    if (t < 1) {
                        requestAnimationFrame(tick);
                    } else {
                        el.textContent = end + suffix;
                    }
                };
                requestAnimationFrame(tick);
            };

            if (typeof IntersectionObserver === 'undefined') {
                run();
                return;
            }

            const countObs = new IntersectionObserver(function (entries, obs) {
                if (!entries[0].isIntersecting) return;
                run();
                obs.disconnect();
            }, { threshold: 0.2 });
            countObs.observe(el);
        });
    }

    function boot() {
        initAdminAnimations();
        initAdminCounters();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
</script>
<?php /**PATH C:\xampp\htdocs\skillupv2\resources\views\Admin\partials\polish-scripts.blade.php ENDPATH**/ ?>