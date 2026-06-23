<?php include 'header.php'; ?>


<section class="page-hero">
    <div class="page-hero__media">
        <img src="/imgs/a-1.webp" alt="Alpine Swiss Tents" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">Accommodation</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            Alpine Swiss Tents
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            Premium canvas tents with mountain views and every comfort.
        </p>
        <a href="/enquire/" class="header__button header__button--one mt-4" data-animate="fade-up" data-delay="0.3">
            Book This Stay
            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </a>
    </div>
</section>



<section class="accom-detail-overview section_padding">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-7">
                <div class="section__subtitle" data-animate="fade-up">
                    <span>Overview</span>
                    <div class="subtitle_line">
                        <div class="line"></div>
                        <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                        <div class="line"></div>
                    </div>
                </div>
                <h2 class="section__title my-3" data-animate="split-title">
                    Luxury Under Canvas, <br>Above The Clouds
                </h2>
                <p class="accom-detail-overview__desc" data-animate="fade-up" data-delay="0.1">
                    Our 8 Alpine Swiss Tents are crafted from high-quality weatherproof canvas on metal
                    frames — combining the romance of tent living with the comfort of a well-appointed
                    hotel room. Perched in a pine clearing with views of the Gangotri range, each tent
                    is a private retreat of its own.
                </p>
            </div>

            <div class="col-lg-5">
                <div class="accom-detail-overview__stats" data-stagger>
                    <div class="accom-detail-overview__stat">
                        <span class="accom-detail-overview__stat-val">8</span>
                        <span class="accom-detail-overview__stat-label">Total Units</span>
                    </div>
                    <div class="accom-detail-overview__stat">
                        <span class="accom-detail-overview__stat-val">12×12</span>
                        <span class="accom-detail-overview__stat-label">Sq. ft. Size</span>
                    </div>
                    <div class="accom-detail-overview__stat">
                        <span class="accom-detail-overview__stat-val">2–3</span>
                        <span class="accom-detail-overview__stat-label">Guests Per Tent</span>
                    </div>
                    <div class="accom-detail-overview__stat">
                        <span class="accom-detail-overview__stat-val">7,500</span>
                        <span class="accom-detail-overview__stat-label">Feet Altitude</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="accom-gallery section_padding pt-0">
    <div class="container">
        <div class="accom-gallery__grid" data-animate="fade-up">

            <!-- main large image -->
            <a class="accom-gallery__main" href="/imgs/a-1.webp" data-fancybox="accom-gallery"
                data-caption="Alpine Swiss Tent — Interior View">
                <img src="/imgs/a-1.webp" alt="Alpine Swiss Tent Interior">
                <div class="accom-gallery__zoom">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </a>

            <a class="accom-gallery__thumb" href="/imgs/a-2.webp" data-fancybox="accom-gallery"
                data-caption="Swiss Tent — Bedroom">
                <img src="/imgs/a-2.webp" alt="">
                <div class="accom-gallery__zoom">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </a>

            <a class="accom-gallery__thumb" href="/imgs/a-3.webp" data-fancybox="accom-gallery"
                data-caption="Swiss Tent — Bathroom">
                <img src="/imgs/a-3.webp" alt="">
                <div class="accom-gallery__zoom">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </a>

            <a class="accom-gallery__thumb" href="/imgs/ab-1.webp" data-fancybox="accom-gallery"
                data-caption="Swiss Tent — View from entrance">
                <img src="/imgs/ab-1.webp" alt="">
                <div class="accom-gallery__zoom">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                </div>
            </a>

            <!-- last thumb — "View All" triggers first image, rest follow via gallery group -->
            <a class="accom-gallery__thumb accom-gallery__thumb--more" href="/imgs/g-1.webp"
                data-fancybox="accom-gallery" data-caption="Mountain View">
                <img src="/imgs/g-1.webp" alt="">
                <div class="accom-gallery__more-label">View All</div>
            </a>

        </div>
    </div>
</section>



<section class="accom-features section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>Inside Your Tent</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon">
                        <img src="/imgs/Vector.svg" alt="">
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-3" data-animate="split-title">Room Features & Amenities</h2>
        </div>

        <div class="row g-4" data-stagger>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/1375/1375681.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Attached Bath</h5>
                    <p class="accom-feature__desc">Well-tiled toilet & bath with 3' corner walls.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://static.thenounproject.com/png/199290-200.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Wall-to-Wall Carpet</h5>
                    <p class="accom-feature__desc">Warm underfoot comfort throughout the tent.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/752/752967.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Tea / Coffee Maker</h5>
                    <p class="accom-feature__desc">In-tent tea & coffee maker for morning rituals.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/93/93158.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Free WiFi</h5>
                    <p class="accom-feature__desc">Complimentary high-speed wireless internet.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/6570/6570897.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Charging Point</h5>
                    <p class="accom-feature__desc">Mobile charging facility inside the tent.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/1824/1824506.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Fresh Linen Daily</h5>
                    <p class="accom-feature__desc">Pillows, blankets and fresh towels provided.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/2564/2564031.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Herbal Toiletries</h5>
                    <p class="accom-feature__desc">Premium in-tent herbal toiletries per guest.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-feature">
                    <div class="accom-feature__icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/1651/1651876.png" alt="">
                    </div>
                    <h5 class="accom-feature__title">Mineral Water</h5>
                    <p class="accom-feature__desc">Complimentary bottle per night from the resort.</p>
                </div>
            </div>
        </div>

    </div>
</section>


<section class="accom-inclusions section_padding">
    <div class="container">
        <div class="accom-inclusions__inner">

            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-animate="fade-right">
                    <img src="/imgs/g-img-1.png" alt="Inclusions" class="accom-inclusions__img">
                </div>
                <div class="col-lg-6">
                    <div class="section__subtitle" data-animate="fade-up">
                        <span>What's Included</span>
                        <div class="subtitle_line">
                            <div class="line"></div>
                            <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                            <div class="line"></div>
                        </div>
                    </div>
                    <h2 class="section__title mb-4" data-animate="split-title">Everything You Need</h2>

                    <div class="accom-inclusions__list" data-stagger>
                        <div class="accom-inclusions__item accom-inclusions__item--yes">
                            <span>Breakfast & Dinner (MAP basis)</span>
                        </div>
                        <div class="accom-inclusions__item accom-inclusions__item--yes">
                            <span>Welcome drink on arrival</span>
                        </div>
                        <div class="accom-inclusions__item accom-inclusions__item--yes">
                            <span>Complimentary mineral water daily</span>
                        </div>
                        <div class="accom-inclusions__item accom-inclusions__item--yes">
                            <span>Herbal in-tent toiletries per guest</span>
                        </div>
                        <div class="accom-inclusions__item accom-inclusions__item--yes">
                            <span>Daily housekeeping</span>
                        </div>
                        <div class="accom-inclusions__item accom-inclusions__item--yes">
                            <span>Access to all resort common areas</span>
                        </div>
                        <div class="accom-inclusions__item accom-inclusions__item--no">
                            <span>Lunch (available at extra cost)</span>
                        </div>
                        <div class="accom-inclusions__item accom-inclusions__item--no">
                            <span>Adventure activities (bookable separately)</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="accom-tariff section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>Pricing</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-3" data-animate="split-title">Capacity & Tariff</h2>
            <p class="mt-2" style="font-size:.85rem; color:var(--text-color);" data-animate="fade-up" data-delay="0.1">
                All rates are per night, per unit. Inclusive of MAP (breakfast & dinner).
            </p>
        </div>

        <div class="accom-tariff__table-wrap" data-animate="fade-up" data-delay="0.1">
            <table class="accom-tariff__table">
                <thead>
                    <tr>
                        <th>Occupancy</th>
                        <th>Weekday</th>
                        <th>Weekend / Holiday</th>
                        <th>Extra Person</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Single</td>
                        <td>₹4,500</td>
                        <td>₹5,500</td>
                        <td>—</td>
                    </tr>
                    <tr>
                        <td>Double</td>
                        <td>₹6,500</td>
                        <td>₹7,500</td>
                        <td>₹1,800</td>
                    </tr>
                    <tr>
                        <td>Triple</td>
                        <td>₹8,500</td>
                        <td>₹9,500</td>
                        <td>—</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="accom-tariff__note" data-animate="fade-up" data-delay="0.15">
            * Rates are indicative. Final pricing shared at time of booking confirmation.
            Contact us for group, corporate, or long-stay rates.
        </p>

    </div>
</section>


<section class="accom-policies section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>Good To Know</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-2" data-animate="split-title">Policies & House Rules</h2>
        </div>

        <div class="row g-4" data-stagger>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-policy">
                    <div class="accom-policy__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                            <path d="M12 8v4l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h5 class="accom-policy__title">Check-in / Out</h5>
                    <p class="accom-policy__desc">Check-in from 12:00 PM<br>Check-out by 11:00 AM</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-policy">
                    <div class="accom-policy__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor"
                                stroke-width="1.5" />
                            <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.5" />
                            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor"
                                stroke-width="1.5" />
                        </svg>
                    </div>
                    <h5 class="accom-policy__title">Children</h5>
                    <p class="accom-policy__desc">Children above 5 years charged as extra adult.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-policy">
                    <div class="accom-policy__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M3 3h18v18H3zM9 9h6M9 12h6M9 15h4" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <h5 class="accom-policy__title">Cancellation</h5>
                    <p class="accom-policy__desc">Free cancellation up to 7 days prior. See full policy.</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="accom-policy">
                    <div class="accom-policy__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                            <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <h5 class="accom-policy__title">House Rules</h5>
                    <p class="accom-policy__desc">No smoking inside tents. Bonfire only in designated areas.</p>
                </div>
            </div>
        </div>

    </div>
</section>


<section class="accom-other section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>Explore More</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-2" data-animate="split-title">Other Ways To Stay</h2>
        </div>

        <div class="row g-4" data-stagger>
            <div class="col-lg-6">
                <a href="/accommodation/detail" class="accom-other__card">
                    <div class="accom-other__media">
                        <img src="/imgs/a-1.webp" alt="Mountain Cottages">
                        <div class="accom-other__overlay"></div>
                    </div>
                    <div class="accom-other__content">
                        <span class="accom-other__tag">Signature Stay</span>
                        <h4 class="accom-other__title">Alpine Mountain Cottages</h4>
                        <span class="accom-other__link">
                            View Details
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <a href="/accommodation/detail" class="accom-other__card">
                    <div class="accom-other__media">
                        <img src="/imgs/a-3.webp" alt="Adventure Dome Tents">
                        <div class="accom-other__overlay"></div>
                    </div>
                    <div class="accom-other__content">
                        <span class="accom-other__tag">Adventure Stay</span>
                        <h4 class="accom-other__title">Adventure Dome & Camping Tents</h4>
                        <span class="accom-other__link">
                            View Details
                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
        </div>

    </div>
</section>


<!-- ════════════════════════════════
     8. CTA
════════════════════════════════ -->
<section class="retreat-cta section_padding">
    <div class="container">
        <div class="retreat-cta__inner" data-animate="fade-up">
            <div class="retreat-cta__line"></div>
            <h2 class="retreat-cta__heading">Ready To Wake Up In The Mountains?</h2>
            <p class="retreat-cta__sub">
                Availability is limited. <br>
                Reach out and we'll plan your perfect stay.
            </p>
            <a href="/enquire/" class="header__button header__button--one mt-4">
                Enquire & Book
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>