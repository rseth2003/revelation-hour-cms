import './theme.js';
document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('.nav-toggle');
    const mobileMenu = document.querySelector('.nav-links');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.toggle('open');
            menuButton.setAttribute('aria-expanded', String(isOpen));
        });

        mobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
                menuButton.setAttribute('aria-expanded', 'false');
            });
        });
    }

    const revealTargets = document.querySelectorAll(
        '.section-heading, .card, .about-card, .experience-card, .feature-card, .event-carousel, .sermon-media, .upload-preview, .involvement-grid article, .giving-inner, .newsletter-inner'
    );

    revealTargets.forEach((element) => element.classList.add('reveal-on-scroll'));

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        revealTargets.forEach((element) => revealObserver.observe(element));
    } else {
        revealTargets.forEach((element) => element.classList.add('is-visible'));
    }

    const sections = Array.from(document.querySelectorAll('main section[id], footer[id]'));
    const navItems = Array.from(document.querySelectorAll('.nav-links a[href^="#"]'));

    if ('IntersectionObserver' in window) {
        const activeNavObserver = new IntersectionObserver((entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (!visible) return;

            navItems.forEach((link) => {
                link.classList.toggle('active', link.getAttribute('href') === `#${visible.target.id}`);
            });
        }, { rootMargin: '-30% 0px -55% 0px', threshold: [0.01, 0.25, 0.5] });

        sections.forEach((section) => activeNavObserver.observe(section));
    }

    const carousel = document.querySelector('[data-event-carousel]');
    if (!carousel) return;

    const track = carousel.querySelector('[data-event-track]');
    const previous = carousel.querySelector('[data-carousel-previous]');
    const next = carousel.querySelector('[data-carousel-next]');
    const dotsContainer = document.querySelector('[data-carousel-dots]');
    const slides = Array.from(track.querySelectorAll('.event-slide'));

    let currentIndex = 0;
    let timer;

    const showSlide = (index) => {
        if (!slides.length) return;

        currentIndex = (index + slides.length) % slides.length;
        slides.forEach((slide, i) => slide.classList.toggle('active', i === currentIndex));

        if (dotsContainer) {
            Array.from(dotsContainer.children).forEach((dot, i) => {
                dot.classList.toggle('active', i === currentIndex);
            });
        }
    };

    if (dotsContainer) {
        slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', `Show event ${index + 1}`);
            dot.addEventListener('click', () => {
                showSlide(index);
                restart();
            });
            dotsContainer.appendChild(dot);
        });
    }

    const restart = () => {
        window.clearInterval(timer);
        if (slides.length > 1) {
            timer = window.setInterval(() => showSlide(currentIndex + 1), 6500);
        }
    };

    previous?.addEventListener('click', () => { showSlide(currentIndex - 1); restart(); });
    next?.addEventListener('click', () => { showSlide(currentIndex + 1); restart(); });

    carousel.addEventListener('mouseenter', () => window.clearInterval(timer));
    carousel.addEventListener('mouseleave', restart);
    carousel.addEventListener('focusin', () => window.clearInterval(timer));
    carousel.addEventListener('focusout', restart);

    showSlide(0);
    restart();
});

document.addEventListener('DOMContentLoaded', () => {
    const hero = document.querySelector('[data-home-hero]');

    if (!hero) {
        return;
    }

    const slides = Array.from(hero.querySelectorAll('.home-hero-slide'));
    const previous = hero.querySelector('[data-home-hero-previous]');
    const next = hero.querySelector('[data-home-hero-next]');
    const dotsContainer = hero.querySelector('[data-home-hero-dots]');
    const progress = hero.querySelector('[data-home-hero-progress]');

    if (slides.length < 2) {
        previous?.remove();
        next?.remove();
        dotsContainer?.remove();
        return;
    }

    const interval = 7000;
    let current = 0;
    let timer = null;
    let touchStartX = 0;

    const dots = slides.map((_, index) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'home-hero-dot';
        dot.setAttribute('aria-label', `Open slide ${index + 1}`);
        dot.addEventListener('click', () => show(index, true));
        dotsContainer.appendChild(dot);
        return dot;
    });

    function restartProgress() {
        if (!progress) return;
        progress.classList.remove('is-running');
        void progress.offsetWidth;
        progress.classList.add('is-running');
    }

    function show(index, restartTimer = false) {
        slides[current].classList.remove('is-active');
        dots[current].classList.remove('is-active');

        current = (index + slides.length) % slides.length;

        slides[current].classList.add('is-active');
        dots[current].classList.add('is-active');

        restartProgress();

        if (restartTimer) {
            start();
        }
    }

    function start() {
        window.clearInterval(timer);
        timer = window.setInterval(() => show(current + 1), interval);
        restartProgress();
    }

    function stop() {
        window.clearInterval(timer);
        progress?.classList.remove('is-running');
    }

    previous?.addEventListener('click', () => show(current - 1, true));
    next?.addEventListener('click', () => show(current + 1, true));

    hero.addEventListener('mouseenter', stop);
    hero.addEventListener('mouseleave', start);
    hero.addEventListener('focusin', stop);
    hero.addEventListener('focusout', start);

    hero.addEventListener('touchstart', event => {
        touchStartX = event.changedTouches[0].screenX;
    }, { passive: true });

    hero.addEventListener('touchend', event => {
        const difference = event.changedTouches[0].screenX - touchStartX;

        if (Math.abs(difference) > 45) {
            show(difference > 0 ? current - 1 : current + 1, true);
        }
    }, { passive: true });

    dots[0].classList.add('is-active');
    start();
});

document.addEventListener('DOMContentLoaded', () => {
    const grid = document.querySelector('[data-gallery-grid]');
    const lightbox = document.querySelector('[data-gallery-lightbox]');

    if (!grid || !lightbox) return;

    const buttons = Array.from(grid.querySelectorAll('[data-gallery-image]'));
    const image = lightbox.querySelector('[data-gallery-lightbox-image]');
    const caption = lightbox.querySelector('[data-gallery-lightbox-caption]');
    const close = lightbox.querySelector('.gallery-lightbox-close');
    const previous = lightbox.querySelector('.gallery-lightbox-arrow.previous');
    const next = lightbox.querySelector('.gallery-lightbox-arrow.next');
    let current = 0;

    function show(index) {
        current = (index + buttons.length) % buttons.length;
        const button = buttons[current];
        image.src = button.dataset.galleryImage;
        image.alt = button.dataset.galleryCaption || 'Gallery image';
        caption.textContent = button.dataset.galleryCaption || '';
        lightbox.hidden = false;
        document.body.style.overflow = 'hidden';
    }

    function hide() {
        lightbox.hidden = true;
        document.body.style.overflow = '';
    }

    buttons.forEach((button, index) => button.addEventListener('click', () => show(index)));
    close.addEventListener('click', hide);
    previous.addEventListener('click', () => show(current - 1));
    next.addEventListener('click', () => show(current + 1));

    lightbox.addEventListener('click', event => {
        if (event.target === lightbox) hide();
    });

    document.addEventListener('keydown', event => {
        if (lightbox.hidden) return;
        if (event.key === 'Escape') hide();
        if (event.key === 'ArrowLeft') show(current - 1);
        if (event.key === 'ArrowRight') show(current + 1);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const toast = document.querySelector('[data-rhmi-toast]');
    if (!toast) return;

    const closeButton = toast.querySelector('[data-rhmi-toast-close]');
    let timer = null;

    const closeToast = () => {
        window.clearTimeout(timer);
        toast.classList.add('is-leaving');
        window.setTimeout(() => toast.remove(), 300);
    };

    closeButton?.addEventListener('click', closeToast);
    timer = window.setTimeout(closeToast, 7000);
});

// RHMI Livestream v1.2.0
document.addEventListener('DOMContentLoaded',()=>{document.querySelectorAll('[data-countdown]').forEach(el=>{const target=new Date(el.dataset.countdown).getTime();const tick=()=>{const diff=Math.max(0,target-Date.now());const d=Math.floor(diff/86400000),h=Math.floor(diff%86400000/3600000),m=Math.floor(diff%3600000/60000),s=Math.floor(diff%60000/1000);el.querySelector('[data-days]').textContent=String(d).padStart(2,'0');el.querySelector('[data-hours]').textContent=String(h).padStart(2,'0');el.querySelector('[data-minutes]').textContent=String(m).padStart(2,'0');el.querySelector('[data-seconds]').textContent=String(s).padStart(2,'0')};tick();setInterval(tick,1000)})});
