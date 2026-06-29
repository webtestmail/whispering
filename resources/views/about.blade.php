@section('title', 'About Us | Whispering Pines')
@section('description', '')
@include('header')

<!-- Contact Page  page  -->

<section class="page-hero">
    <div class="page-hero__media">
        <img src="/imgs/banner.png" alt="Contact Whispering Pines" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">Reach Out</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            Let The Mountains <br> Call You Home
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            Every journey to Whispering Pines begins with a conversation.
        </p>
    </div>
</section>

<!-- ========================================
     ABOUT US PAGE — 3 Sections
     (No header / footer / banner)
     ======================================== -->

<!-- SECTION 1 — WHO WE ARE -->
<section class="about-who py-5">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-5" data-animate="fade-up">
                <div class="about-who__media">
                    <img src="/imgs/ab-1.webp" alt="Whispering Pines Retreat" class="about-who__img">
                    <div class="about-who__badge">
                        <span class="about-who__badge-year">Est.</span>
                        <strong class="about-who__badge-num">2015</strong>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-animate="fade-up" data-delay="0.1">
                <div class="section__subtitle"><span>Who We Are</span></div>
                <h2 class="section__title">A Retreat Born From <br>The Silence of Dhanaulti</h2>
                <p class="about-who__text">
                    Whispering Pines sits at 7,500 feet in the Garhwal Himalayas — a handcrafted retreat built not as a hotel, but as a place to exhale. Founded by Rajiv Tyagi in 2015, it began as a simple longing: to offer guests something the noise of modern life rarely allows — stillness.
                </p>
                <p class="about-who__text">
                    Tucked inside dense pine forests above Dhanaulti, every cottage, every meal, and every experience here has been shaped by the belief that true luxury is silence, space, and slowness.
                </p>
                <div class="about-who__stats">
                    <div class="about-who__stat">
                        <strong class="about-who__stat-num">7,500<span>ft</span></strong>
                        <span class="about-who__stat-label">Altitude</span>
                    </div>
                    <div class="about-who__stat-divider"></div>
                    <div class="about-who__stat">
                        <strong class="about-who__stat-num">10+</strong>
                        <span class="about-who__stat-label">Acres of Forest</span>
                    </div>
                    <div class="about-who__stat-divider"></div>
                    <div class="about-who__stat">
                        <strong class="about-who__stat-num">9</strong>
                        <span class="about-who__stat-label">Cottages</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION 2 — MISSION & VISION -->
<section class="about-mv py-5">
    <div class="container">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center" data-animate="fade-up">
                <div class="section__subtitle"><span>What Drives Us</span></div>
                <h2 class="section__title">Mission & Vision</h2>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-md-6" data-animate="fade-up" data-delay="0">
                <div class="about-mv__card about-mv__card--mission">
                    <div class="about-mv__card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                            <line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/>
                            <line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/>
                        </svg>
                    </div>
                    <h4 class="about-mv__card-heading">Our Mission</h4>
                    <p class="about-mv__card-text">
                        To preserve a corner of the Himalayas where guests can arrive exhausted and leave restored — offering curated stillness, nourishing food, and an environment that asks nothing of you except to be present.
                    </p>
                </div>
            </div>

            <div class="col-md-6" data-animate="fade-up" data-delay="0.1">
                <div class="about-mv__card about-mv__card--vision">
                    <div class="about-mv__card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <h4 class="about-mv__card-heading">Our Vision</h4>
                    <p class="about-mv__card-text">
                        A world where slow travel is the default — where people choose depth over distance, and where the mountains remain wild, quiet, and available to those who seek them with reverence.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION 3 — HOW WE WORK -->
<section class="about-how py-5">
    <div class="container">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center" data-animate="fade-up">
                <div class="section__subtitle"><span>How We Work</span></div>
                <h2 class="section__title">Four Convictions We <br>Never Compromise On</h2>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-sm-6 col-lg-3" data-animate="fade-up" data-delay="0">
                <div class="about-how__item">
                    <div class="about-how__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <h5 class="about-how__heading">Authenticity</h5>
                    <p class="about-how__text">Real experiences, real people, real Himalayas. Nothing here is staged or manufactured for appearance.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3" data-animate="fade-up" data-delay="0.08">
                <div class="about-how__item">
                    <div class="about-how__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 8C8 10 5.9 16.17 3.82 19.34a1 1 0 0 0 1.36 1.39C7.06 19.5 9.37 17 12 17c5 0 9-3 9-9 0-1-1-2-2-2-1 0-2 1-2 2z"/>
                        </svg>
                    </div>
                    <h5 class="about-how__heading">Nature First</h5>
                    <p class="about-how__text">Every design decision defers to the forest. We build around the land, not on top of it.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3" data-animate="fade-up" data-delay="0.16">
                <div class="about-how__item">
                    <div class="about-how__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <h5 class="about-how__heading">Thoughtful Comfort</h5>
                    <p class="about-how__text">Warm meals, bonfire evenings, private sit-outs. Comfort complete — nothing excessive, nothing missing.</p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3" data-animate="fade-up" data-delay="0.24">
                <div class="about-how__item">
                    <div class="about-how__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                    <h5 class="about-how__heading">Sustainable Living</h5>
                    <p class="about-how__text">Low impact, high awareness. Locally sourced, waste-conscious, and deeply rooted in Pahadi community.</p>
                </div>
            </div>

        </div>
    </div>
</section>






@include('footer')