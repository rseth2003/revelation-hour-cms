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
