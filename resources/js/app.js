document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('.nav-toggle');
    const mobileMenu = document.querySelector('.nav-links');

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.toggle('open');
            menuButton.setAttribute('aria-expanded', String(isOpen));
        });
    }


    const revealTargets = document.querySelectorAll('.section-heading, .card, .about-card, .feature-card, .logo-panel, .event-carousel, .upload-preview');
    revealTargets.forEach((element) => element.classList.add('reveal-on-scroll'));
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    revealTargets.forEach((element) => revealObserver.observe(element));

    const sections = Array.from(document.querySelectorAll('main section[id], footer[id]'));
    const navItems = Array.from(document.querySelectorAll('.nav-links a[href^="#"]'));
    const activeNavObserver = new IntersectionObserver((entries) => {
        const visible = entries.filter((entry) => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
        if (!visible) return;
        navItems.forEach((link) => link.classList.toggle('active', link.getAttribute('href') === `#${visible.target.id}`));
    }, { rootMargin: '-30% 0px -55% 0px', threshold: [0.01, 0.25, 0.5] });
    sections.forEach((section) => activeNavObserver.observe(section));

    const carousel = document.querySelector('[data-event-carousel]');
    if (!carousel) return;

    const track = carousel.querySelector('[data-event-track]');
    const previous = carousel.querySelector('[data-carousel-previous]');
    const next = carousel.querySelector('[data-carousel-next]');
    const dotsContainer = document.querySelector('[data-carousel-dots]');
    let currentIndex = 0;
    let autoPlayTimer;

    const getSlides = () => Array.from(track.querySelectorAll('.event-slide'));

    const renderDots = () => {
        dotsContainer.innerHTML = '';
        getSlides().forEach((_, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', `Show event ${index + 1}`);
            dot.addEventListener('click', () => showSlide(index));
            dotsContainer.appendChild(dot);
        });
    };

    const showSlide = (index) => {
        const slides = getSlides();
        if (!slides.length) return;
        currentIndex = (index + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => slide.classList.toggle('active', slideIndex === currentIndex));
        Array.from(dotsContainer.children).forEach((dot, dotIndex) => dot.classList.toggle('active', dotIndex === currentIndex));
    };

    const restartAutoPlay = () => {
        window.clearInterval(autoPlayTimer);
        autoPlayTimer = window.setInterval(() => showSlide(currentIndex + 1), 6500);
    };

    carousel.addEventListener('mouseenter', () => window.clearInterval(autoPlayTimer));
    carousel.addEventListener('mouseleave', restartAutoPlay);
    carousel.addEventListener('focusin', () => window.clearInterval(autoPlayTimer));
    carousel.addEventListener('focusout', restartAutoPlay);

    previous?.addEventListener('click', () => { showSlide(currentIndex - 1); restartAutoPlay(); });
    next?.addEventListener('click', () => { showSlide(currentIndex + 1); restartAutoPlay(); });

    const storageKey = 'rhmi-local-event-images';
    const readLocalEvents = () => {
        try { return JSON.parse(localStorage.getItem(storageKey) || '[]'); }
        catch { return []; }
    };

    const appendLocalEvent = (event) => {
        const article = document.createElement('article');
        article.className = 'event-slide';
        article.dataset.localEvent = 'true';
        const image = document.createElement('img');
        image.src = event.image;
        image.alt = event.title;
        const caption = document.createElement('div');
        caption.className = 'event-caption';
        const title = document.createElement('strong');
        title.textContent = event.title;
        const description = document.createElement('span');
        description.textContent = event.description || 'Church event update';
        caption.append(title, description);
        article.append(image, caption);
        track.appendChild(article);
    };

    readLocalEvents().forEach(appendLocalEvent);
    renderDots();
    showSlide(0);
    restartAutoPlay();

    const params = new URLSearchParams(window.location.search);
    const adminPanel = document.querySelector('[data-local-admin-panel]');
    if (params.get('admin-preview') === '1' && adminPanel) adminPanel.hidden = false;

    const uploadForm = document.querySelector('[data-event-upload-form]');
    uploadForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(uploadForm);
        const file = formData.get('image');
        if (!(file instanceof File) || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = () => {
            const localEvent = {
                title: String(formData.get('title') || 'Church event'),
                description: String(formData.get('description') || ''),
                image: String(reader.result),
            };
            const items = readLocalEvents();
            items.push(localEvent);
            try { localStorage.setItem(storageKey, JSON.stringify(items)); }
            catch { alert('The image is too large for local preview storage. Please choose a smaller image.'); return; }
            appendLocalEvent(localEvent);
            renderDots();
            showSlide(getSlides().length - 1);
            uploadForm.reset();
            restartAutoPlay();
        };
        reader.readAsDataURL(file);
    });

    document.querySelector('[data-clear-local-events]')?.addEventListener('click', () => {
        localStorage.removeItem(storageKey);
        track.querySelectorAll('[data-local-event]').forEach((slide) => slide.remove());
        currentIndex = 0;
        renderDots();
        showSlide(0);
        restartAutoPlay();
    });
});
