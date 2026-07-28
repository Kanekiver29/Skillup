@push('scripts')
<script>
(function () {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const els = document.querySelectorAll('[data-page-animate]');

    if (!els.length) return;

    if (prefersReduced) {
        els.forEach(function (el) { el.classList.add('is-visible'); });
        return;
    }

    document.documentElement.classList.add('page-animate-enabled');

    const reveal = function (el) {
        el.classList.add('is-visible');
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                reveal(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -48px 0px' });

    els.forEach(function (el) { observer.observe(el); });

    requestAnimationFrame(function () {
        els.forEach(function (el) {
            var rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight * 0.92) {
                reveal(el);
            }
        });
    });
})();
</script>
@endpush
