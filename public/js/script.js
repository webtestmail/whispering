
const header = document.querySelector('.header');

window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 50);
});


gsap.registerPlugin(ScrollTrigger);

/* ─────────────────────────────────────────
   1. HERO TITLE — char split (on page load)
───────────────────────────────────────── */
const heroTitle = document.querySelector('.hero__title');
if (heroTitle) {
    const split = new SplitType('.hero__title', { types: 'words, chars' });
    gsap.from(split.chars, {
        opacity: 0,
        y: 40,
        stagger: 0.03,
        duration: 0.8,
        ease: 'power3.out',
        delay: 0.3,
    });
}

//    2. REUSABLE CLASS-BASED SCROLL ANIMATIONS
//    Add these classes to any HTML element

// [data-animate="fade-up"]      — simple fade up (default, most used)
// [data-animate="fade-in"]      — opacity only
// [data-animate="fade-left"]    — slide from right
// [data-animate="fade-right"]   — slide from left
// [data-animate="scale-up"]     — scale from small
// [data-animate="split-title"]  — word split for headings

const animateElements = document.querySelectorAll('[data-animate]');

animateElements.forEach((el) => {
    const type = el.dataset.animate;
    const delay = parseFloat(el.dataset.delay || 0);
    const duration = parseFloat(el.dataset.duration || 0.75);
    const start = el.dataset.start || 'top 88%';

    const fromVars = {
        duration,
        delay,
        ease: 'power3.out',
        scrollTrigger: {
            trigger: el,
            start,
        },
    };

    switch (type) {
        case 'fade-up':
            Object.assign(fromVars, { opacity: 0, y: 50 });
            break;
        case 'fade-in':
            Object.assign(fromVars, { opacity: 0 });
            break;
        case 'fade-left':
            Object.assign(fromVars, { opacity: 0, x: 60 });
            break;
        case 'fade-right':
            Object.assign(fromVars, { opacity: 0, x: -60 });
            break;
        case 'scale-up':
            Object.assign(fromVars, { opacity: 0, scale: 0.88 });
            break;
        case 'split-title':
            // word-level split for section headings
            const split = new SplitType(el, { types: 'words' });
            gsap.from(split.words, {
                opacity: 0,
                y: 30,
                stagger: 0.08,
                duration,
                delay,
                ease: 'power3.out',
                scrollTrigger: { trigger: el, start },
            });
            return; // skip the generic gsap.from below
    }

    gsap.from(el, fromVars);
});


//    3. STAGGER CHILDREN
//    Add data-stagger to a parent — all direct
//    children animate in one by one

document.querySelectorAll('[data-stagger]').forEach((parent) => {
    const children = parent.children;
    const delay = parseFloat(parent.dataset.delay || 0);
    const start = parent.dataset.start || 'top 88%';

    gsap.from(children, {
        opacity: 0,
        y: 40,
        stagger: 0.12,
        duration: 0.7,
        delay,
        ease: 'power3.out',
        scrollTrigger: {
            trigger: parent,
            start,
        },
    });
});



const accommodationSlider = new Swiper('.accommodation-slider', {
    loop: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    // spaceBetween: 24,

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});


// ── Testimonials Swiper ──
const testimonialsSwiper = new Swiper('.testimonials-swiper', {
    loop: true,
    speed: 600,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    navigation: {
        nextEl: '.testimonials__nav-btn--next',
        prevEl: '.testimonials__nav-btn--prev',
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
});

new Swiper('.client-logos-swiper', {
    loop: true,
    slidesPerView: 4,
    // spaceBetween: 24,
    slidesPerGroup: 1,
    speed: 600,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    breakpoints: {
        0: { slidesPerView: 2, },
        768: { slidesPerView: 3, },
        992: { slidesPerView: 4, },
    }
});


new Swiper('.reflection-swiper', {
    loop: true,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    speed: 700,
    autoplay: { delay: 5000, disableOnInteraction: false },
    navigation: {
        nextEl: '.reflection__btn--next',
        prevEl: '.reflection__btn--prev',
    },
});



Fancybox.bind('[data-fancybox="accom-gallery"]', {
    Toolbar: {
        display: {
            left: ['infobar'],
            middle: [],
            right: ['slideshow', 'fullscreen', 'download', 'close'],
        },
    },
    Images: {
        zoom: true,
    },
    Carousel: {
        transition: 'fade',
    },
    // match your brand
    theme: {
        cssVars: {
            dark: {
                '--fancybox-bg': 'rgba(27, 58, 47, 0.97)',
                '--fancybox-color': '#fff',
                '--fancybox-accent-color': '#C47B2A',
            },
        },
    },
});