import './bootstrap';
import './echo';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
	// Header nav is initialized inline in layout.app (works without Vite build).
	if (window.__skillupHeaderNavInit) {
		return;
	}

	const siteHeader = document.getElementById('site-header');
	const navToggle = document.getElementById('nav-toggle');
	const mobileNav = document.getElementById('mobile-nav');
	const navOpenIcon = document.getElementById('nav-open-icon');
	const navCloseIcon = document.getElementById('nav-close-icon');
	const primaryNav = document.getElementById('primary-nav');
	const userMenuToggle = document.getElementById('user-menu-toggle');
	const userMenu = document.getElementById('user-menu');
	const headerUserWrap = document.getElementById('header-user-wrap');

	window.__skillupHeaderNavInit = true;

	function onScroll() {
		if (!siteHeader) return;
		siteHeader.classList.toggle('is-scrolled', window.scrollY > 12);
	}
	onScroll();
	window.addEventListener('scroll', onScroll, { passive: true });

	function closeMobileNav() {
		if (!mobileNav) return;
		mobileNav.classList.remove('is-open');
		if (navToggle) {
			navToggle.classList.remove('is-active');
			navToggle.setAttribute('aria-expanded', 'false');
			navToggle.setAttribute('aria-label', 'Open menu');
		}
		if (navOpenIcon) navOpenIcon.classList.remove('hidden');
		if (navCloseIcon) navCloseIcon.classList.add('hidden');
		document.body.classList.remove('overflow-hidden');
	}

	function openMobileNav() {
		if (!mobileNav) return;
		closeUserMenu();
		mobileNav.classList.add('is-open');
		if (navToggle) {
			navToggle.classList.add('is-active');
			navToggle.setAttribute('aria-expanded', 'true');
			navToggle.setAttribute('aria-label', 'Close menu');
		}
		if (navOpenIcon) navOpenIcon.classList.add('hidden');
		if (navCloseIcon) navCloseIcon.classList.remove('hidden');
		document.body.classList.add('overflow-hidden');
	}

	if (navToggle && mobileNav) {
		navToggle.addEventListener('click', (e) => {
			e.preventDefault();
			e.stopPropagation();
			if (mobileNav.classList.contains('is-open')) closeMobileNav();
			else openMobileNav();
		});
	}

	function closeUserMenu() {
		if (userMenu) userMenu.classList.remove('is-open');
		if (headerUserWrap) headerUserWrap.classList.remove('is-open');
		if (userMenuToggle) userMenuToggle.setAttribute('aria-expanded', 'false');
	}

	function openUserMenu() {
		if (!userMenu) return;
		closeMobileNav();
		userMenu.classList.add('is-open');
		if (headerUserWrap) headerUserWrap.classList.add('is-open');
		if (userMenuToggle) userMenuToggle.setAttribute('aria-expanded', 'true');
	}

	function toggleUserMenu() {
		if (!userMenu) return;
		if (userMenu.classList.contains('is-open')) closeUserMenu();
		else openUserMenu();
	}

	if (userMenuToggle && userMenu) {
		userMenuToggle.addEventListener('click', (e) => {
			e.preventDefault();
			e.stopPropagation();
			toggleUserMenu();
		});

		userMenu.querySelectorAll('a').forEach((link) => {
			link.addEventListener('click', () => closeUserMenu());
		});
	}

	document.addEventListener('click', (e) => {
		const target = e.target;
		if (mobileNav && mobileNav.classList.contains('is-open')) {
			if (navToggle && !mobileNav.contains(target) && !navToggle.contains(target)) {
				closeMobileNav();
			}
		}
		if (userMenu && userMenu.classList.contains('is-open')) {
			if (userMenuToggle && !userMenuToggle.contains(target) && !userMenu.contains(target)) {
				closeUserMenu();
			}
		}
	});

	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') {
			closeMobileNav();
			closeUserMenu();
		}
	});

	window.addEventListener('resize', () => {
		if (window.innerWidth >= 1024) closeMobileNav();
	});

	if (mobileNav) {
		mobileNav.querySelectorAll('a').forEach((link) => {
			link.addEventListener('click', () => closeMobileNav());
		});
	}

	function highlightActiveLinks() {
		const links = [];
		if (primaryNav) links.push(...primaryNav.querySelectorAll('a'));
		if (mobileNav) links.push(...mobileNav.querySelectorAll('a.mobile-nav-link'));
		const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
		links.forEach((a) => {
			try {
				const url = new URL(a.href, window.location.origin);
				const path = url.pathname.replace(/\/$/, '') || '/';
				a.classList.toggle('active', path === currentPath);
			} catch {
				// ignore invalid URLs
			}
		});
	}

	highlightActiveLinks();
});
