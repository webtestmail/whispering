@section('title', 'Blog | Whispering Pines')
@section('description', '')
@include('header')

<!-- Blog Detail page  -->

<section class="page-hero">
    <div class="page-hero__media">
        <img src="/imgs/banner.png" alt="The Retreat" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">Blog</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            Crafted For Those Seeking <br> Silence Beyond The Mountains
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            A retreat born from the timeless beauty of the Himalayas.
        </p>
    </div>
</section>

<section class="blog_detail section_padding">
    <div class="container">

        <div class="row g-5">

            <!-- Content -->

            <div class="col-lg-8">

                <article class="blog_content">

                    <div class="blog_meta">
                        <span>June 15, 2026</span>
                        <span>5 Min Read</span>
                        <span>Travel Guide</span>
                    </div>

<!--Heading -->
                    <h2>
                        Discover Hidden Trails Around The Himalayas
                    </h2>

<!--Short desc/ Blurb / Excerpt -->
                    <p>
                        Nestled among the towering peaks and whispering forests,
                        the Himalayas offer countless hidden trails waiting to be explored.
                        Whether you're seeking solitude, adventure, or breathtaking views,
                        these paths reveal the true beauty of the mountains.
                    </p>

<!--IMg -->
                    <img src="/imgs/a-1.webp" alt="">

<!--Now full content -->
                    <h3>
                        Why Travelers Love These Trails
                    </h3>

                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."


                        Unlike crowded tourist routes, these hidden paths allow visitors
                        to connect deeply with nature. Along the way you'll encounter
                        pristine forests, traditional villages, and panoramic viewpoints.
                    </p>

                    <blockquote>
                        "The mountains are not just a destination—they are an experience
                        that stays with you long after the journey ends."
                    </blockquote>

                    <h3>
                        Best Time To Visit
                    </h3>

                    <p>
                        Spring and autumn offer ideal weather conditions, clear skies,
                        and comfortable temperatures for trekking and sightseeing.
                    </p>

                    <p>
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."


                    </p>

                    <p>
                        During your stay at Whispering Pines, our team can guide you
                        towards some of the most rewarding trails and scenic experiences
                        around the region.
                    </p>

                </article>


            </div>

            <!-- Sidebar -->

            <div class="col-lg-4">

                <div class="blog_sidebar">

                    <!-- Recent Posts -->

                    <div class="sidebar_widget">

                        <h4>Recent Articles</h4>

                        <div class="recent_post">

                            <img src="/imgs/a-2.webp" alt="">

                            <div>
                                <h6>
                                    Forest Walks Around The Retreat
                                </h6>
                                <span>June 2026</span>
                            </div>

                        </div>

                        <div class="recent_post">

                            <img src="/imgs/a-1.webp" alt="">

                            <div>
                                <h6>
                                    Top Things To Do In The Hills
                                </h6>
                                <span>May 2026</span>
                            </div>

                        </div>

                        <div class="recent_post">

                            <img src="/imgs/a-3.webp" alt="">

                            <div>
                                <h6>
                                    Local Food Experiences
                                </h6>
                                <span>May 2026</span>
                            </div>

                        </div>

                    </div>

                    <!-- Promo -->

                    <div class="promo_card">

                        <span>Whispering Pines</span>

                        <h3>
                            Escape Into The Mountains
                        </h3>

                        <p>
                            Discover breathtaking views, cozy stays,
                            and unforgettable experiences.
                        </p>

                        <a href="#" class="header__button header__button--one">
                            Book Your Stay
                        </a>

                    </div>

                    <!-- Contact -->

                    <div class="sidebar_widget">

                        <h4>Need Assistance?</h4>

                        <p>
                            Our team is happy to help plan your perfect mountain retreat.
                        </p>

                        <a href="#" class="header__button header__button--two">
                            Contact Us
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>





@include('footer')