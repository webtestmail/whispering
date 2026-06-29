@section('title', 'Accommodation | Whispering Pines')
@section('description', '')
@include('header')

<!-- Accomodation listing page  -->

<section class="page-hero">
    <div class="page-hero__media">
        <img src="/imgs/banner.png" alt="The Retreat" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">Accomodation</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            Crafted For Those Seeking <br> Silence Beyond The Mountains
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            A retreat born from the timeless beauty of the Himalayas.
        </p>
    </div>
</section>


<section class="accom section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>Where You'll Stay</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon">
                        <div class="line_icon">
                            <img src="/imgs/Vector.svg" alt="">
                        </div>
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title mb-3" data-animate="split-title">Choose Your Retreat</h2>
            <p class="accom__intro" data-animate="fade-up" data-delay="0.1">
                Whether you’re chasing the angels or fleeing from demons, come to the mountains. You would agree with us
                that there can’t be a greater bliss than to wake up to fresh peaks, dew drops on the leaves in the lush
                green fields? And then add a touch of rosy sunset, with the nights spent around a cozy bonfire!

            </p>
        </div>

        <!-- ── ITEM 1: Alpine Swiss Tents ── -->
        <div class="accom-item" data-animate="fade-up">
            <div class="row align-items-center g-0">

                <div class="col-lg-5">
                    <div class="accom-item__media">
                        <img src="/imgs/a-1.webp" alt="Alpine Swiss Tents" class="accom-item__img">
                        <div class="accom-item__badge">8 Units</div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="accom-item__content">
                        <span class="accom-item__tag">Premium Stay</span>
                        <h3 class="accom-item__title">Alpine Swiss Tents</h3>
                        <div class="accom-item__divider"></div>
                        <p class="accom-item__desc">
                            12' x 12' Swiss Tents with metal frame made of high-quality weatherproof canvas.
                            Each tent features an attached toilet & bath, wall-to-wall carpet, double bed with
                            mattress, fresh linen, pillows, blankets, lighting and a mobile charging point.
                            Tea/coffee maker and premium herbal toiletries included.
                        </p>

                        <!-- amenities -->
                        <div class="accom-item__amenities">
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                                <span>Attached Bath</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                <span>Free Wifi</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                <span>Tea / Coffee</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="2" width="20" height="20" rx="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M7 12h10M12 7v10" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                                <span>Charging Point</span>
                            </div>
                        </div>

                        <div class="accom-item__footer">
                            <div class="accom-item__basis">
                                <span>Twin / Triple Share Basis</span>
                            </div>
                            <a href="/accommodation/detail" class="header__button header__button--one">
                                Explore & Book
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- ── ITEM 2: Adventure Dome & Camping ── -->
        <div class="accom-item accom-item--reverse" data-animate="fade-up">
            <div class="row align-items-center g-0 flex-lg-row-reverse">

                <div class="col-lg-5">
                    <div class="accom-item__media">
                        <img src="/imgs/a-2.webp" alt="Adventure Dome Tents" class="accom-item__img">
                        <div class="accom-item__badge">50–60 Capacity</div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="accom-item__content">
                        <span class="accom-item__tag">Adventure Stay</span>
                        <h3 class="accom-item__title">Adventure Dome & Camping Tents</h3>
                        <div class="accom-item__divider"></div>
                        <p class="accom-item__desc">
                            Made from imported nylon, these tents provide the closest interaction with
                            the outdoors — ideal for adrenaline-loving travellers. Ground bedding with
                            sleeping bags and karymats, shared modern toilet and bath facilities.
                            Closest you'll get to sleeping under Himalayan stars.
                        </p>

                        <div class="accom-item__amenities">
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M3 20L9 8l4 6 3-4 5 10H3z" stroke="currentColor" stroke-width="1.5"
                                        stroke-linejoin="round" />
                                </svg>
                                <span>Ground Bedding</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                <span>Free Wifi</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                                <span>Shared Bath</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M12 8v4l3 3" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                                <span>Sleeping Bags</span>
                            </div>
                        </div>

                        <div class="accom-item__footer">
                            <div class="accom-item__basis">
                                <span>Twin / Quad Share Basis</span>
                            </div>
                            <a href="/accommodation/detail" class="header__button header__button--one">
                                Explore & Book
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- ── ITEM 3: Mountain Cottages ── -->
        <div class="accom-item" data-animate="fade-up">
            <div class="row align-items-center g-0">

                <div class="col-lg-5">
                    <div class="accom-item__media accom-item__media--multi">
                        <img src="/imgs/a-3.webp" alt="Mountain Cottage" class="accom-item__img">
                        <div class="accom-item__badge">2 Cottages</div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="accom-item__content">
                        <span class="accom-item__tag">Signature Stay</span>
                        <h3 class="accom-item__title">Alpine Mountain Cottages</h3>
                        <div class="accom-item__divider"></div>
                        <p class="accom-item__desc">
                            Valley-facing independent cottage rooms with a private sit-out. Retro Himalayan
                            exteriors with attached washroom featuring running cold and hot water. Room
                            interiors include a double bed with mattress, fresh linen, pillows, blankets,
                            fresh towels, lighting, charging point and LCD TV with FTA DTH connection.
                        </p>

                        <div class="accom-item__amenities">
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                                <span>Attached Bath</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                                <span>LCD TV</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0M12 20h.01"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                <span>Free Wifi</span>
                            </div>
                            <div class="accom-item__amenity">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M9 22V12h6v10" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                                <span>Private Sit-out</span>
                            </div>
                        </div>

                        <div class="accom-item__footer">
                            <div class="accom-item__basis">
                                <span>Double / Twin Share Basis</span>
                            </div>
                            <a href="/accommodation/detail" class="header__button header__button--one">
                                Explore & Book
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>



@include('footer')