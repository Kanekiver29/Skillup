import './bootstrap';

// Responsive navigation: toggles mobile menu, highlights active links
document.addEventListener('DOMContentLoaded', () => {
	const navToggle = document.getElementById('nav-toggle');
	const mobileNav = document.getElementById('mobile-nav');
	const navOpenIcon = document.getElementById('nav-open-icon');
	const navCloseIcon = document.getElementById('nav-close-icon');
	const primaryNav = document.getElementById('primary-nav');

	function closeMobileNav() {
		if (!mobileNav) return;
		mobileNav.classList.add('hidden');
		if (navOpenIcon) navOpenIcon.classList.remove('hidden');
		if (navCloseIcon) navCloseIcon.classList.add('hidden');
	}

	function openMobileNav() {
		if (!mobileNav) return;
		mobileNav.classList.remove('hidden');
		if (navOpenIcon) navOpenIcon.classList.add('hidden');
		if (navCloseIcon) navCloseIcon.classList.remove('hidden');
	}

	if (navToggle) {
		navToggle.addEventListener('click', (e) => {
			e.stopPropagation();
			if (!mobileNav) return;
			if (mobileNav.classList.contains('hidden')) openMobileNav(); else closeMobileNav();
		});
	}

	// Close when clicking outside
	document.addEventListener('click', (e) => {
		if (!mobileNav || !navToggle) return;
		if (mobileNav.classList.contains('hidden')) return;
		const target = e.target;
		if (!mobileNav.contains(target) && !navToggle.contains(target)) closeMobileNav();
	});

	// Close on Escape
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') closeMobileNav();
	});

	// Hide mobile nav on resize to desktop widths
	const mdBreakpoint = 768;
	window.addEventListener('resize', () => {
		if (window.innerWidth >= mdBreakpoint) closeMobileNav();
	});

	// Active link highlighting for primary and mobile navs
	function highlightActiveLinks() {
		const links = [];
		if (primaryNav) links.push(...primaryNav.querySelectorAll('a'));
		if (mobileNav) links.push(...mobileNav.querySelectorAll('a'));

		const currentPath = window.location.pathname.replace(/\/$/, '') || '/';

		links.forEach(a => {
			try {
				const url = new URL(a.href, window.location.origin);
				const path = url.pathname.replace(/\/$/, '') || '/';
				if (path === currentPath) {
					a.classList.add('text-purple-600', 'font-semibold');
				} else {
					a.classList.remove('text-purple-600', 'font-semibold');
				}
			} catch (err) {
				// ignore invalid URLs
			}
		});
	}

	highlightActiveLinks();
});
