@section('title', 'Experiences | Whispering Pines')
@section('description', '')
@include('header')

<!-- Hero — already have -->
<section class="page-hero">
    <div class="page-hero__media">
        <img src="/imgs/banner.png" alt="Experiences" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">Experiences</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            Every Season Brings <br> A Different Magic
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            From summer trails to winter snowfall — there is always a reason to return.
        </p>
    </div>
</section>


<section class="exp-intro section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="section__subtitle " data-animate="fade-up">
                    <span>Why Come Here</span>
                    <div class="subtitle_line justify-content-center">
                        <div class="line"></div>
                        <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                        <div class="line"></div>
                    </div>
                </div>
                <h2 class="section__title" data-animate="split-title">
                    Life At 7,500 Feet Is Never Ordinary
                </h2>
                <p class="exp-intro__para" data-animate="fade-up" data-delay="0.1">
                    Whispering Pines sits at the crossroads of adventure and stillness. Surrounded
                    by dense pine and oak forests, with the Gangotri range as your backdrop, every
                    day here unfolds differently — depending on the season, the weather, and how
                    deeply you choose to immerse yourself.
                </p>
                <p class="exp-intro__para" data-animate="fade-up" data-delay="0.15">
                    Summer brings lush green trails, cool mountain air and the sound of birds at
                    dawn. Winter wraps the forest in snow and silence, turning evenings into
                    bonfire rituals. And all year round, the stars above Kanatal remain among
                    the clearest in the country — a sky most city dwellers have never truly seen.
                </p>
                <p class="exp-intro__para" data-animate="fade-up" data-delay="0.2">
                    Whatever you come seeking — adventure, rest, or simply a change of pace —
                    the mountains will meet you exactly where you are.
                </p>
            </div>
        </div>
    </div>
</section>


<!-- ════════════════════════════════
     3. EXPERIENCES LISTING
════════════════════════════════ -->
<section class="exp-listing section_padding pt-0">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>What Awaits You</span>
                <div class="subtitle_line justify-content-center">
                        <div class="line"></div>
                        <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                        <div class="line"></div>
                    </div>
            </div>
            <h2 class="section__title my-3" data-animate="split-title">Explore All Experiences</h2>
        </div>

        <div class="row g-4" data-stagger>

            <!-- Summer -->
            <div class="col-lg-6">
                <a href="/experiences/detail" class="exp-card">
                    <div class="exp-card__media">
                        <img src="/imgs/a-1.webp" alt="Summer at Whispering Pines" class="exp-card__img">
                        <div class="exp-card__overlay"></div>
                        <span class="exp-card__season-tag exp-card__season-tag--summer">Summer</span>
                    </div>
                    <div class="exp-card__content">
                        <div class="exp-card__meta">
                            <span class="exp-card__month">Apr — Jun</span>
                            <span class="exp-card__dot"></span>
                            <span class="exp-card__temp">12°c — 22°c</span>
                        </div>
                        <h3 class="exp-card__title">Summer at Whispering Pines</h3>
                        <p class="exp-card__desc">
                            Lush green trails, crisp mountain air, blooming rhododendrons
                            and long warm evenings under a canopy of stars. Summer here
                            is an escape from the plains in its truest form.
                        </p>
                        <div class="exp-card__highlights">
                            <span>Forest Treks</span>
                            <span>Nature Walks</span>
                            <span>Campfire Nights</span>
                            <span>Bird Watching</span>
                        </div>
                        <div class="exp-card__link">
                            Explore Summer
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Winter -->
            <div class="col-lg-6">
                <a href="/experiences/detail" class="exp-card">
                    <div class="exp-card__media">
                        <img src="/imgs/a-2.webp" alt="Winter at Whispering Pines" class="exp-card__img">
                        <div class="exp-card__overlay"></div>
                        <span class="exp-card__season-tag exp-card__season-tag--winter">Winter</span>
                    </div>
                    <div class="exp-card__content">
                        <div class="exp-card__meta">
                            <span class="exp-card__month">Nov — Feb</span>
                            <span class="exp-card__dot"></span>
                            <span class="exp-card__temp">−2°c — 10°c</span>
                        </div>
                        <h3 class="exp-card__title">Winter at Whispering Pines</h3>
                        <p class="exp-card__desc">
                            Snow-covered pine forests, steaming cups of kahwa by the fire,
                            and the kind of silence only a Himalayan winter can offer.
                            Wake up to white mornings and end evenings in warmth.
                        </p>
                        <div class="exp-card__highlights">
                            <span>Snowfall Walks</span>
                            <span>Bonfire Evenings</span>
                            <span>Snow Trekking</span>
                            <span>Hot Springs</span>
                        </div>
                        <div class="exp-card__link">
                            Explore Winter
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Round the Year -->
            <div class="col-lg-6">
                <a href="/experiences/detail" class="exp-card">
                    <div class="exp-card__media">
                        <img src="/imgs/a-3.webp" alt="Round the Year" class="exp-card__img">
                        <div class="exp-card__overlay"></div>
                        <span class="exp-card__season-tag exp-card__season-tag--all">All Year</span>
                    </div>
                    <div class="exp-card__content">
                        <div class="exp-card__meta">
                            <span class="exp-card__month">Jan — Dec</span>
                            <span class="exp-card__dot"></span>
                            <span class="exp-card__temp">Year Round</span>
                        </div>
                        <h3 class="exp-card__title">Round the Year at Whispering Pines</h3>
                        <p class="exp-card__desc">
                            Adventure doesn't follow a calendar. Rappelling, river crossing,
                            rock climbing and team challenges are available every season —
                            for groups, families and solo adventurers alike.
                        </p>
                        <div class="exp-card__highlights">
                            <span>Rappelling</span>
                            <span>Rock Climbing</span>
                            <span>River Crossing</span>
                            <span>Team Activities</span>
                        </div>
                        <div class="exp-card__link">
                            Explore Adventures
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Star Gazing -->
            <div class="col-lg-6">
                <a href="/experiences/detail" class="exp-card">
                    <div class="exp-card__media">
                        <img src="/imgs/about-img-1.png" alt="Star Gazing" class="exp-card__img">
                        <div class="exp-card__overlay"></div>
                        <span class="exp-card__season-tag exp-card__season-tag--night">Nights</span>
                    </div>
                    <div class="exp-card__content">
                        <div class="exp-card__meta">
                            <span class="exp-card__month">Best: Oct — Mar</span>
                            <span class="exp-card__dot"></span>
                            <span class="exp-card__temp">Clear Skies</span>
                        </div>
                        <h3 class="exp-card__title">Star Gazing at Kanatal</h3>
                        <p class="exp-card__desc">
                            At 7,500 feet with minimal light pollution, Kanatal offers one of
                            India's clearest night skies. Guided astronomy sessions, telescope
                            viewing and open-air stargazing on the forest deck.
                        </p>
                        <div class="exp-card__highlights">
                            <span>Telescope Viewing</span>
                            <span>Guided Sessions</span>
                            <span>Milky Way</span>
                            <span>Constellation Maps</span>
                        </div>
                        <div class="exp-card__link">
                            Explore Star Gazing
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>


<!-- ════════════════════════════════
     5. EDITORIAL GALLERY
════════════════════════════════ -->
<section class="exp-gallery section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>In The Moment</span>
                <div class="subtitle_line justify-content-center">
                        <div class="line"></div>
                        <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                        <div class="line"></div>
                    </div>
            </div>
            <h2 class="section__title my-3" data-animate="split-title">Captured By Our Guests</h2>
            <p class="exp-gallery__sub" data-animate="fade-up" data-delay="0.1">
                Real moments, real people, real Himalayas.
            </p>
        </div>

        <!-- Editorial masonry layout -->
        <div class="exp-gallery__grid" data-animate="fade-up" data-delay="0.1">

            <!-- Row 1: tall left + 2 stacked right -->
            <a href="/imgs/g-1.webp"
               data-fancybox="exp-gallery"
               data-caption="Morning light through the pine forest"
               class="exp-gallery__item exp-gallery__item--tall">
                <img src="/imgs/g-1.webp" alt="">
                <div class="exp-gallery__item-overlay">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </a>

            <a href="/imgs/g-2.webp"
               data-fancybox="exp-gallery"
               data-caption="Trek to Kodia jungle"
               class="exp-gallery__item">
                <img src="/imgs/g-2.webp" alt="">
                <div class="exp-gallery__item-overlay">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </a>

            <a href="/imgs/g-3.webp"
               data-fancybox="exp-gallery"
               data-caption="Snowfall at Whispering Pines"
               class="exp-gallery__item">
                <img src="/imgs/g-4.webp" alt="">
                <div class="exp-gallery__item-overlay">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </a>

            <!-- Row 2: wide left + portrait right -->
            <a href="/imgs/g-5.webp"
               data-fancybox="exp-gallery"
               data-caption="Bonfire evenings"
               class="exp-gallery__item exp-gallery__item--wide">
                <img src="/imgs/g-5.webp" alt="">
                <div class="exp-gallery__item-overlay">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </a>

            <a href="/imgs/g-1.webp"
               data-fancybox="exp-gallery"
               data-caption="Star gazing on the deck"
               class="exp-gallery__item exp-gallery__item--tall-sm">
                <img src="/imgs/g-1.webp" alt="">
                <div class="exp-gallery__item-overlay">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </a>

            <a href="/imgs/g-2.webp"
               data-fancybox="exp-gallery"
               data-caption="Adventure activities"
               class="exp-gallery__item">
                <img src="/imgs/g-2.webp" alt="">
                <div class="exp-gallery__item-overlay">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </a>

            <a href="/imgs/g-3.webp"
               data-fancybox="exp-gallery"
               data-caption="The forest in morning mist"
               class="exp-gallery__item">
                <img src="/imgs/g-3.webp" alt="">
                <div class="exp-gallery__item-overlay">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
            </a>

        </div>
    </div>
</section>


<!-- CTA — reuse retreat-cta from other pages -->
<section class="retreat-cta section_padding">
    <div class="container">
        <div class="retreat-cta__inner" data-animate="fade-up">
            <div class="retreat-cta__line"></div>
            <h2 class="retreat-cta__heading">Which Season Calls To You?</h2>
            <p class="retreat-cta__sub">
                Every visit is different. <br>
                Let us help you pick the perfect time to come.
            </p>
            <a href="/enquire/" class="header__button header__button--one mt-4">
                Plan Your Experience
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@include('footer')