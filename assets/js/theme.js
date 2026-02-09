/**
 * Brasil GEO Portal - Theme JS
 * @version 1.1.0
 */
(function () {
  'use strict';

  // ── Header scroll effect ──
  var header = document.getElementById('site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }, { passive: true });
  }

  // ── Search overlay ──
  var searchToggle = document.getElementById('search-toggle');
  var searchOverlay = document.getElementById('search-overlay');
  var searchClose = document.getElementById('search-close');

  function openSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.add('active');
    if (searchToggle) searchToggle.setAttribute('aria-expanded', 'true');
    var input = searchOverlay.querySelector('.search-field');
    if (input) setTimeout(function () { input.focus(); }, 100);
  }

  function closeSearch() {
    if (!searchOverlay) return;
    searchOverlay.classList.remove('active');
    if (searchToggle) searchToggle.setAttribute('aria-expanded', 'false');
  }

  if (searchToggle) searchToggle.addEventListener('click', openSearch);
  if (searchClose) searchClose.addEventListener('click', closeSearch);

  if (searchOverlay) {
    searchOverlay.addEventListener('click', function (e) {
      if (e.target === searchOverlay) closeSearch();
    });
  }

  // ── Mobile navigation ──
  var mobileToggle = document.getElementById('mobile-toggle');
  var mobileNav = document.getElementById('mobile-nav');
  var mobileClose = document.getElementById('mobile-close');
  var mobileOverlay = document.getElementById('mobile-overlay');

  function openMobileNav() {
    if (mobileNav) mobileNav.classList.add('active');
    if (mobileOverlay) mobileOverlay.classList.add('active');
    if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileNav() {
    if (mobileNav) mobileNav.classList.remove('active');
    if (mobileOverlay) mobileOverlay.classList.remove('active');
    if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }

  if (mobileToggle) mobileToggle.addEventListener('click', openMobileNav);
  if (mobileClose) mobileClose.addEventListener('click', closeMobileNav);
  if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileNav);

  // ── Escape key handler ──
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      if (searchOverlay && searchOverlay.classList.contains('active')) closeSearch();
      if (mobileNav && mobileNav.classList.contains('active')) closeMobileNav();
    }
  });

  // ── Scroll animations (Intersection Observer) ──
  var animatedElements = document.querySelectorAll('.fade-in-up');
  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (animatedElements.length > 0 && 'IntersectionObserver' in window && !prefersReducedMotion) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
    );

    animatedElements.forEach(function (el) {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
      observer.observe(el);
    });
  }

  // ── Ticker duplication for seamless scroll ──
  var tickerItems = document.querySelector('.ticker-items');
  if (tickerItems && tickerItems.children.length > 0) {
    var clone = tickerItems.innerHTML;
    tickerItems.innerHTML = clone + clone;
  }

  // ── Smooth scroll for same-page anchors ──
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var href = this.getAttribute('href');
      if (!href || href === '#' || href.length < 2) return;
      try {
        var target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      } catch (err) {
        // Invalid selector, ignore
      }
    });
  });

})();
