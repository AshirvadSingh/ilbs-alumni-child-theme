/**
 * ILBS Alumni — Main JavaScript
 * Handles: dark mode, search overlay, swiper sliders, AOS, counter animation
 */

(function () {
  'use strict';

  /* ============================================================
     DARK MODE TOGGLE
     ============================================================ */
  const root        = document.documentElement;
  const storedTheme = localStorage.getItem('ilbs-theme');
  if (storedTheme) root.setAttribute('data-bs-theme', storedTheme);

  const themeButton = document.querySelector('[data-theme-toggle]');
  if (themeButton) {
    // Sync icon on load
    const current = root.getAttribute('data-bs-theme') || 'light';
    themeButton.innerHTML = current === 'dark'
      ? '<i class="bi bi-sun"></i>'
      : '<i class="bi bi-moon-stars"></i>';

    themeButton.addEventListener('click', () => {
      const next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-bs-theme', next);
      localStorage.setItem('ilbs-theme', next);
      themeButton.innerHTML = next === 'dark'
        ? '<i class="bi bi-sun"></i>'
        : '<i class="bi bi-moon-stars"></i>';
    });
  }

  /* ============================================================
     SEARCH OVERLAY
     ============================================================ */
  const overlay     = document.querySelector('[data-search-overlay]');
  const searchInput = document.querySelector('#siteSearch');

  document.querySelectorAll('[data-search-open]').forEach(btn => {
    btn.addEventListener('click', () => {
      overlay?.classList.add('is-open');
      setTimeout(() => searchInput?.focus(), 80);
    });
  });

  document.querySelectorAll('[data-search-close]').forEach(btn => {
    btn.addEventListener('click', () => overlay?.classList.remove('is-open'));
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') overlay?.classList.remove('is-open');
  });

  /* ============================================================
     AOS INIT
     ============================================================ */
  if (window.AOS) {
    AOS.init({ duration: 700, once: true, offset: 80 });
  }

  /* ============================================================
     BANNER SWIPER
     ============================================================ */
  if (window.Swiper && document.querySelector('.banner-swiper')) {
    new Swiper('.banner-swiper', {
      loop: true,
      speed: 900,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      autoplay: { delay: 5200, disableOnInteraction: false },
      navigation: {
        nextEl: '.banner-next',
        prevEl: '.banner-prev',
      },
      keyboard: { enabled: true },
    });
  }

  /* ============================================================
     EVENT SWIPER
     ============================================================ */
  if (window.Swiper && document.querySelector('.event-swiper')) {
    new Swiper('.event-swiper', {
      slidesPerView: 1,
      spaceBetween: 18,
      pagination: { el: '.swiper-pagination', clickable: true },
      breakpoints: {
        768:  { slidesPerView: 2 },
        1200: { slidesPerView: 3 },
      },
    });
  }

  /* ============================================================
     COUNTER ANIMATION
     ============================================================ */
  const animateCounter = (node) => {
    const target = Number(node.dataset.counter || 0);
    const step   = Math.max(1, Math.ceil(target / 60));
    let current  = 0;
    const timer  = setInterval(() => {
      current += step;
      if (current >= target) {
        node.textContent = target;
        clearInterval(timer);
      } else {
        node.textContent = current;
      }
    }, 20);
  };

  // Intersection Observer for counters
  const counterNodes = document.querySelectorAll('[data-counter]');
  if (counterNodes.length) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });

    counterNodes.forEach(node => observer.observe(node));
  }

  /* ============================================================
     MEGA MENU — close on outside click (mobile / touch)
     ============================================================ */
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.has-mega')) {
      document.querySelectorAll('.mega-menu.show').forEach(m => m.classList.remove('show'));
    }
  });

  document.querySelectorAll('.has-mega > .nav-link').forEach(link => {
    link.addEventListener('click', (e) => {
      // Only intercept on mobile (collapsed nav)
      if (window.innerWidth < 1200) {
        const menu = link.nextElementSibling;
        if (menu) {
          e.preventDefault();
          menu.classList.toggle('show');
        }
      }
    });
  });

  /* ============================================================
     STICKY HEADER — add scrolled class for extra shadow
     ============================================================ */
  const siteHeader = document.querySelector('.ilbs-site-header');
  if (siteHeader) {
    window.addEventListener('scroll', () => {
      siteHeader.classList.toggle('scrolled', window.scrollY > 20);
    }, { passive: true });
  }

  /* ============================================================
     GALLERY LIGHTBOX (native dialog-based, no dependency)
     ============================================================ */
  // Simple lightbox for gallery tiles with images
  document.querySelectorAll('.gallery-preview .gallery-tile img').forEach(img => {
    img.style.cursor = 'zoom-in';
    img.addEventListener('click', () => {
      const dialog = document.createElement('dialog');
      dialog.style.cssText = 'background:rgba(0,0,0,.92);border:0;padding:0;max-width:100vw;max-height:100vh;width:100vw;height:100vh;display:grid;place-items:center;';
      dialog.innerHTML = `
        <button onclick="this.closest('dialog').close()" style="position:fixed;top:20px;right:20px;background:transparent;border:1px solid rgba(255,255,255,.3);color:#fff;width:40px;height:40px;border-radius:50%;font-size:1.2rem;cursor:pointer;">✕</button>
        <img src="${img.src}" style="max-width:90vw;max-height:90vh;object-fit:contain;border-radius:8px;">
      `;
      document.body.appendChild(dialog);
      dialog.showModal();
      dialog.addEventListener('click', (e) => { if (e.target === dialog) dialog.close(); });
      dialog.addEventListener('close', () => dialog.remove());
    });
  });

})();
