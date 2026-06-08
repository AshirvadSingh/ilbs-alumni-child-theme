/**
 * ILBS Alumni — Premium Frontend (GSAP + Swiper)
 */
(function () {
  'use strict';

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isTouch = window.matchMedia('(hover: none), (pointer: coarse)').matches;

  /* ── Scroll progress ───────────────────────────────────── */
  const progressBar = document.querySelector('.ilbs-scroll-progress');
  if (progressBar) {
    const updateProgress = () => {
      const scrollTop = window.scrollY;
      const docHeight = document.documentElement.scrollHeight - window.innerHeight;
      progressBar.style.width = docHeight > 0 ? `${(scrollTop / docHeight) * 100}%` : '0%';
    };
    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
  }

  /* ── Back to top ───────────────────────────────────────── */
  const backTop = document.querySelector('.ilbs-back-top');
  if (backTop) {
    window.addEventListener('scroll', () => {
      backTop.classList.toggle('is-visible', window.scrollY > 500);
    }, { passive: true });
    backTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: prefersReduced ? 'auto' : 'smooth' });
    });
  }

  /* ── Custom cursor ─────────────────────────────────────── */
  if (!isTouch && !prefersReduced) {
    const dot  = document.querySelector('.ilbs-cursor-dot');
    const ring = document.querySelector('.ilbs-cursor-ring');
    if (dot && ring) {
      document.body.classList.add('ilbs-cursor-active');
      let mx = 0, my = 0, rx = 0, ry = 0;

      document.addEventListener('mousemove', (e) => {
        mx = e.clientX;
        my = e.clientY;
        dot.style.opacity = '1';
        ring.style.opacity = '1';
        dot.style.left = `${mx}px`;
        dot.style.top  = `${my}px`;
      });

      const animateRing = () => {
        rx += (mx - rx) * 0.15;
        ry += (my - ry) * 0.15;
        ring.style.left = `${rx}px`;
        ring.style.top  = `${ry}px`;
        requestAnimationFrame(animateRing);
      };
      animateRing();

      const hoverTargets = 'a, button, .ilbs-btn, .ilbs-card, .ilbs-video-card, .ilbs-year-pill, input, select, textarea, [role="button"]';
      document.addEventListener('mouseover', (e) => {
        if (e.target.closest(hoverTargets)) ring.classList.add('is-hover');
      });
      document.addEventListener('mouseout', (e) => {
        if (e.target.closest(hoverTargets)) ring.classList.remove('is-hover');
      });
    }
  }

  /* ── Sticky header ─────────────────────────────────────── */
  const siteHeader = document.querySelector('.ilbs-site-header');
  if (siteHeader) {
    window.addEventListener('scroll', () => {
      siteHeader.classList.toggle('scrolled', window.scrollY > 16);
    }, { passive: true });
  }

  /* ── Mobile hamburger ──────────────────────────────────── */
  const hamburger = document.querySelector('.ilbs-hamburger');
  const navCollapse = document.getElementById('ilbsMainNav');
  if (hamburger && navCollapse) {
    hamburger.addEventListener('click', () => {
      const isOpen = navCollapse.classList.toggle('show');
      hamburger.classList.toggle('is-active', isOpen);
      hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
    navCollapse.querySelectorAll('.nav-link').forEach((link) => {
      link.addEventListener('click', () => {
        if (window.innerWidth < 1200) {
          navCollapse.classList.remove('show');
          hamburger.classList.remove('is-active');
        }
      });
    });
  }

  /* ── Search overlay ────────────────────────────────────── */
  const overlay = document.querySelector('[data-search-overlay]');
  const searchInput = document.querySelector('#siteSearch, .search-field, input[type="search"]');

  document.querySelectorAll('[data-search-open]').forEach((btn) => {
    btn.addEventListener('click', () => {
      overlay?.classList.add('is-open');
      setTimeout(() => searchInput?.focus(), 80);
    });
  });

  document.querySelectorAll('[data-search-close]').forEach((btn) => {
    btn.addEventListener('click', () => overlay?.classList.remove('is-open'));
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') overlay?.classList.remove('is-open');
  });

  /* ── Mega menu mobile ──────────────────────────────────── */
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.has-mega')) {
      document.querySelectorAll('.mega-menu.show').forEach((m) => m.classList.remove('show'));
    }
  });

  document.querySelectorAll('.has-mega > .nav-link').forEach((link) => {
    link.addEventListener('click', (e) => {
      if (window.innerWidth < 1200) {
        const menu = link.nextElementSibling;
        if (menu) {
          e.preventDefault();
          menu.classList.toggle('show');
        }
      }
    });
  });

  /* ── GSAP animations ───────────────────────────────────── */
  if (window.gsap && !prefersReduced) {
    if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);

    /* Hero quick cards float */
    gsap.from('.ilbs-ref-quick-card', {
      opacity: 0, y: 40, stagger: 0.1, duration: 0.9, delay: 0.4, ease: 'power3.out',
    });

    /* Section titles line reveal */
    gsap.utils.toArray('.ilbs-ref-title').forEach((title) => {
      gsap.from(title, {
        scrollTrigger: { trigger: title, start: 'top 90%' },
        opacity: 0, y: 24, duration: 0.8, ease: 'power3.out',
      });
    });

    /* Search page hero SVG */
    gsap.from('.ilbs-search-hero__svg--rings', {
      opacity: 0,
      scale: 0.85,
      rotation: -12,
      duration: 1.2,
      ease: 'power3.out',
    });

    gsap.from('.ilbs-search-form__wrap', {
      opacity: 0,
      y: 24,
      duration: 0.8,
      delay: 0.2,
      ease: 'power3.out',
    });

    /* Section reveals */
    gsap.utils.toArray('[data-reveal]').forEach((el) => {
      gsap.from(el, {
        scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' },
        opacity: 0,
        y: 48,
        duration: 0.9,
        ease: 'power3.out',
      });
    });

    gsap.utils.toArray('[data-reveal-stagger]').forEach((container) => {
      const items = container.querySelectorAll('[data-reveal-item]');
      if (!items.length) return;
      gsap.from(items, {
        scrollTrigger: { trigger: container, start: 'top 85%' },
        opacity: 0,
        y: 36,
        stagger: 0.1,
        duration: 0.75,
        ease: 'power3.out',
      });
    });


    /* Premium alternating timeline reveal */
    const timeline = document.querySelector('.timeline-section .timeline-list');
    if (timeline) {
      gsap.utils.toArray('.timeline-section .timeline-item').forEach((item, index) => {
        const card = item.querySelector('.timeline-card');
        const node = item.querySelector('.timeline-node');
        if (card) {
          gsap.from(card, {
            scrollTrigger: { trigger: item, start: 'top 82%' },
            opacity: 0,
            x: window.innerWidth > 991 ? (index % 2 === 0 ? -54 : 54) : 24,
            y: 18,
            duration: 0.85,
            ease: 'power3.out',
          });
        }
        if (node) {
          gsap.from(node, {
            scrollTrigger: { trigger: item, start: 'top 84%' },
            opacity: 0,
            scale: 0.72,
            duration: 0.65,
            ease: 'back.out(1.4)',
          });
        }
      });
    }

    /* Awards year pills */
    gsap.from('.ilbs-year-pill', {
      scrollTrigger: { trigger: '.ilbs-year-pills', start: 'top 90%' },
      opacity: 0,
      x: -16,
      stagger: 0.06,
      duration: 0.5,
      ease: 'power2.out',
    });

    /* Footer reveal */
    const footer = document.querySelector('.ilbs-footer, .footer');
    if (footer) {
      gsap.from(footer, {
        scrollTrigger: { trigger: footer, start: 'top 95%' },
        opacity: 0,
        y: 40,
        duration: 0.8,
        ease: 'power3.out',
      });
    }

    /* Counter animation */
    document.querySelectorAll('[data-counter]').forEach((node) => {
      const target = Number(node.dataset.counter || 0);
      ScrollTrigger.create({
        trigger: node,
        start: 'top 85%',
        once: true,
        onEnter: () => {
          gsap.to({ val: 0 }, {
            val: target,
            duration: 1.8,
            ease: 'power2.out',
            onUpdate() {
              node.textContent = Math.round(this.targets()[0].val);
            },
          });
        },
      });
    });
  } else {
    /* Fallback counters without GSAP */
    document.querySelectorAll('[data-counter]').forEach((node) => {
      const target = Number(node.dataset.counter || 0);
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          let current = 0;
          const step = Math.max(1, Math.ceil(target / 60));
          const timer = setInterval(() => {
            current += step;
            if (current >= target) {
              node.textContent = target;
              clearInterval(timer);
            } else {
              node.textContent = current;
            }
          }, 20);
          observer.unobserve(node);
        });
      }, { threshold: 0.3 });
      observer.observe(node);
    });
  }

  /* ── Swiper: banner ────────────────────────────────────── */
  if (window.Swiper && document.querySelector('.banner-swiper')) {
    const animateBannerSlide = () => {
      if (!window.gsap) return;
      const activeCopy = document.querySelector('.swiper-slide-active [data-hero-copy], .swiper-slide-active .banner-copy');
      if (activeCopy) {
        gsap.fromTo(activeCopy.children, { opacity: 0, y: 32 }, {
          opacity: 1, y: 0, stagger: 0.1, duration: 0.85, ease: 'power3.out',
        });
      }
    };

    new Swiper('.banner-swiper', {
      loop: true,
      speed: 900,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      autoplay: { delay: 5200, disableOnInteraction: false },
      pagination: { el: '.banner-pagination', clickable: true },
      navigation: { nextEl: '.banner-next', prevEl: '.banner-prev' },
      keyboard: { enabled: true },
      on: {
        init: animateBannerSlide,
        slideChangeTransitionEnd: animateBannerSlide,
      },
    });
  }

  /* ── Swiper: events ────────────────────────────────────── */
  if (window.Swiper && document.querySelector('.event-swiper')) {
    new Swiper('.event-swiper', {
      slidesPerView: 1,
      spaceBetween: 20,
      pagination: { el: '.event-swiper .swiper-pagination', clickable: true },
      breakpoints: {
        768: { slidesPerView: 2 },
        1200: { slidesPerView: 3 },
      },
    });
  }

  /* ── Swiper: testimonials ──────────────────────────────── */
  if (window.Swiper && document.querySelector('.testimonial-swiper')) {
    new Swiper('.testimonial-swiper', {
      slidesPerView: 1,
      spaceBetween: 24,
      autoplay: { delay: 6000, disableOnInteraction: false },
      pagination: { el: '.testimonial-pagination', clickable: true },
      breakpoints: {
        768: { slidesPerView: 2 },
        1200: { slidesPerView: 3 },
      },
    });
  }

  /* ── Homepage awards year filter ─────────────────────── */
  const homeYearBtns = document.querySelectorAll('[data-home-award-year]');
  const homeAwardWraps = document.querySelectorAll('[data-award-year-wrap]');
  const homeYearHeading = document.getElementById('homeAwardYearHeading');

  if (homeYearBtns.length && homeAwardWraps.length) {
    homeYearBtns.forEach((btn) => {
      btn.addEventListener('click', () => {
        const year = btn.dataset.homeAwardYear;
        homeYearBtns.forEach((b) => b.classList.toggle('is-active', b === btn));
        homeAwardWraps.forEach((wrap) => {
          wrap.classList.toggle('is-hidden', wrap.dataset.awardYearWrap !== year);
        });
        if (homeYearHeading) {
          homeYearHeading.innerHTML = `<span>${year}</span> Awards & Publications`;
        }
        if (window.gsap) {
          gsap.from('#homeAwardsGrid .ilbs-ref-award-wrap:not(.is-hidden) .ilbs-award-card', {
            opacity: 0, y: 20, stagger: 0.06, duration: 0.5, ease: 'power2.out',
          });
        }
      });
    });
  }

  const homeAwardSearch = document.getElementById('homeAwardSearch');
  if (homeAwardSearch) {
    homeAwardSearch.addEventListener('input', () => {
      const q = homeAwardSearch.value.trim().toLowerCase();
      document.querySelectorAll('#homeAwardsGrid [data-award-card]').forEach((card) => {
        const wrap = card.closest('[data-award-year-wrap]');
        if (wrap?.classList.contains('is-hidden')) return;
        const hay = (card.dataset.search || '').toLowerCase();
        card.style.display = !q || hay.includes(q) ? '' : 'none';
      });
    });
  }

  /* ── Swiper: video slider ──────────────────────────────── */
  if (window.Swiper && document.querySelector('.video-swiper')) {
    new Swiper('.video-swiper', {
      slidesPerView: 1.15,
      spaceBetween: 20,
      centeredSlides: false,
      grabCursor: true,
      pagination: { el: '.video-swiper-pagination', clickable: true },
      navigation: {
        nextEl: '.video-swiper-next',
        prevEl: '.video-swiper-prev',
      },
      breakpoints: {
        640: { slidesPerView: 1.5 },
        992: { slidesPerView: 2.2 },
        1280: { slidesPerView: 3 },
      },
    });
  }

  /* ── Video lightbox ────────────────────────────────────── */
  const lightbox = document.getElementById('ilbsVideoLightbox');
  const lightboxFrame = document.getElementById('ilbsVideoLightboxFrame');
  const lightboxClose = document.getElementById('ilbsVideoLightboxClose');

  function openVideoLightbox(embed) {
    if (!lightbox || !lightboxFrame || !embed) return;
    lightboxFrame.src = embed;
    lightbox.classList.add('is-open');
    lightbox.setAttribute('aria-hidden', 'false');
  }

  function closeVideoLightbox() {
    if (!lightbox || !lightboxFrame) return;
    lightbox.classList.remove('is-open');
    lightbox.setAttribute('aria-hidden', 'true');
    lightboxFrame.src = '';
  }

  document.querySelectorAll('[data-video-embed]').forEach((el) => {
    el.addEventListener('click', () => {
      openVideoLightbox(el.dataset.videoEmbed);
    });
    el.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        openVideoLightbox(el.dataset.videoEmbed);
      }
    });
  });

  lightboxClose?.addEventListener('click', closeVideoLightbox);
  lightbox?.addEventListener('click', (e) => {
    if (e.target === lightbox) closeVideoLightbox();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeVideoLightbox();
  });

  /* ── Awards archive live search ────────────────────────── */
  const awardSearch = document.getElementById('ilbsAwardSearch');
  if (awardSearch) {
    awardSearch.addEventListener('input', () => {
      const q = awardSearch.value.trim().toLowerCase();
      document.querySelectorAll('[data-award-card]').forEach((card) => {
        const haystack = (card.dataset.search || '').toLowerCase();
        card.classList.toggle('is-hidden', q.length > 0 && !haystack.includes(q));
      });
    });
  }

  /* ── Magnetic buttons ──────────────────────────────────── */
  if (!isTouch && !prefersReduced) {
    document.querySelectorAll('[data-magnetic]').forEach((btn) => {
      btn.addEventListener('mousemove', (e) => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        btn.style.transform = `translate(${x * 0.12}px, ${y * 0.12}px)`;
      });
      btn.addEventListener('mouseleave', () => {
        btn.style.transform = '';
      });
    });
  }

  /* ── Smooth anchor links ───────────────────────────────── */
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      const id = anchor.getAttribute('href');
      if (!id || id === '#') return;
      const target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      const offset = siteHeader ? siteHeader.offsetHeight + 16 : 0;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: prefersReduced ? 'auto' : 'smooth' });
    });
  });

  /* ── Photo gallery lightbox ──────────────────────────── */
  const photoLightbox = document.getElementById('ilbsPhotoLightbox');
  const photoLightboxImg = photoLightbox?.querySelector('.ilbs-photo-lightbox__img');
  const photoClose = photoLightbox?.querySelector('.ilbs-photo-lightbox__close');
  const photoPrev = photoLightbox?.querySelector('.ilbs-photo-lightbox__prev');
  const photoNext = photoLightbox?.querySelector('.ilbs-photo-lightbox__next');
  let photoUrls = [];
  let photoIndex = 0;

  function collectPhotoUrls() {
    photoUrls = Array.from(document.querySelectorAll('[data-gallery-lightbox]'))
      .map((el) => el.dataset.galleryLightbox)
      .filter(Boolean);
  }

  function openPhotoLightbox(url) {
    if (!photoLightbox || !photoLightboxImg || !url) return;
    collectPhotoUrls();
    photoIndex = Math.max(0, photoUrls.indexOf(url));
    photoLightboxImg.src = url;
    photoLightbox.classList.add('is-open');
    photoLightbox.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closePhotoLightbox() {
    if (!photoLightbox || !photoLightboxImg) return;
    photoLightbox.classList.remove('is-open');
    photoLightbox.setAttribute('aria-hidden', 'true');
    photoLightboxImg.src = '';
    document.body.style.overflow = '';
  }

  function showPhotoAt(index) {
    if (!photoUrls.length) return;
    photoIndex = (index + photoUrls.length) % photoUrls.length;
    if (photoLightboxImg) photoLightboxImg.src = photoUrls[photoIndex];
  }

  document.querySelectorAll('[data-gallery-lightbox]').forEach((el) => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      openPhotoLightbox(el.dataset.galleryLightbox);
    });
  });

  photoClose?.addEventListener('click', closePhotoLightbox);
  photoPrev?.addEventListener('click', () => showPhotoAt(photoIndex - 1));
  photoNext?.addEventListener('click', () => showPhotoAt(photoIndex + 1));

  photoLightbox?.addEventListener('click', (e) => {
    if (e.target === photoLightbox) closePhotoLightbox();
  });

  document.addEventListener('keydown', (e) => {
    if (!photoLightbox?.classList.contains('is-open')) return;
    if (e.key === 'Escape') closePhotoLightbox();
    if (e.key === 'ArrowLeft') showPhotoAt(photoIndex - 1);
    if (e.key === 'ArrowRight') showPhotoAt(photoIndex + 1);
  });

  /* ── Gallery preview lightbox ────────────────────────── */
  document.querySelectorAll('.gallery-preview .gallery-tile img').forEach((img) => {
    img.style.cursor = 'zoom-in';
    img.addEventListener('click', () => {
      const dialog = document.createElement('dialog');
      dialog.style.cssText = 'background:rgba(15,23,42,.94);border:0;padding:0;max-width:100vw;max-height:100vh;width:100vw;height:100vh;display:grid;place-items:center;';
      dialog.innerHTML = `
        <button type="button" aria-label="Close" style="position:fixed;top:20px;right:20px;background:#fff;border:0;color:#111;width:44px;height:44px;border-radius:50%;font-size:1.2rem;cursor:pointer;">✕</button>
        <img src="${img.src}" alt="" style="max-width:90vw;max-height:90vh;object-fit:contain;border-radius:16px;">
      `;
      document.body.appendChild(dialog);
      dialog.showModal();
      dialog.querySelector('button')?.addEventListener('click', () => dialog.close());
      dialog.addEventListener('click', (e) => { if (e.target === dialog) dialog.close(); });
      dialog.addEventListener('close', () => dialog.remove());
    });
  });

})();
