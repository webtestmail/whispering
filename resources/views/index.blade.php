@include('header') 

<section class="hero">
    <div class="hero_image">
        <img src="{{ asset('imgs/banner.png') }}" alt="Hero Image" class="hero__poster" id="heroPoster">
        <video src="{{ asset('imgs/header-video.mp4') }}" id="heroVideo" autoplay muted loop playsinline></video>
    </div>
    <div class="hero__inner">
        <div class="container">
            <h1 class="hero__title">Timeless Escapes In The Lap Of The Himalayas</h1>
            <div class="header_buttons justify-content-center mt-4">
                <a class="header__button header__button--one" href="{{ route('accommodation') }}">
                    Kanatal 22°c
                    <svg width="23" height="16" viewBox="0 0 23 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M4 6.79245C3.99983 6.37614 4.09024 5.96388 4.26607 5.57923C4.4419 5.19458 4.6997 4.84508 5.02474 4.5507C5.34978 4.25633 5.73568 4.02285 6.1604 3.86361C6.58512 3.70436 7.04032 3.62248 7.5 3.62264C8.18933 3.62264 8.82267 3.8086 9.35333 4.1117C9.44882 4.16318 9.53197 4.23145 9.5979 4.31247C9.66382 4.39349 9.71119 4.48564 9.73721 4.58348C9.76323 4.68133 9.76737 4.7829 9.7494 4.88222C9.73143 4.98154 9.69171 5.0766 9.63258 5.16181C9.57344 5.24703 9.49608 5.32066 9.40505 5.37839C9.31402 5.43613 9.21117 5.47679 9.10253 5.49798C8.99389 5.51918 8.88167 5.52048 8.77247 5.50181C8.66327 5.48314 8.5593 5.44488 8.46667 5.38928C8.17786 5.22233 7.84262 5.13313 7.5 5.13208C7.09219 5.1296 6.69522 5.25096 6.37251 5.47679C6.0498 5.70262 5.81997 6.01989 5.71972 6.3779C5.61947 6.73592 5.6546 7.11403 5.81948 7.45184C5.98437 7.78966 6.2695 8.06768 6.62933 8.24151C6.82312 8.33791 6.96668 8.50008 7.02845 8.69234C7.09021 8.8846 7.06511 9.09121 6.95867 9.26672C6.85223 9.44222 6.67317 9.57224 6.46087 9.62818C6.24858 9.68411 6.02045 9.66138 5.82667 9.56498C5.2752 9.29415 4.81452 8.89372 4.49307 8.40583C4.17162 7.91793 4.00129 7.3606 4 6.79245Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.67333 7.72226C6.75203 6.29076 7.43541 4.94145 8.58203 3.95357C9.72866 2.96569 11.2508 2.41487 12.8333 2.41509C14.1119 2.41616 15.3584 2.77807 16.3993 3.45049C17.4402 4.12292 18.2239 5.07242 18.6413 6.16694C19.8723 6.39999 20.9772 7.00935 21.7708 7.89278C22.5645 8.77622 22.9985 9.87998 23 11.0189C23 11.673 22.8577 12.3207 22.5813 12.9251C22.3049 13.5294 21.8998 14.0785 21.3891 14.5411C20.8784 15.0036 20.2721 15.3705 19.6048 15.6208C18.9375 15.8712 18.2223 16 17.5 16H8.83333C7.55145 16 6.32208 15.5388 5.41565 14.7179C4.50922 13.897 4 12.7836 4 11.6226C4 9.90551 5.09467 8.43713 6.67333 7.72226ZM8.33333 7.98792L8.336 8.00241V8.00966L8.34533 8.06883C8.34933 8.0966 8.35333 8.13404 8.356 8.17751C8.36483 8.34039 8.31518 8.50148 8.21447 8.63666C8.11376 8.77184 7.96741 8.87384 7.79733 8.9274C7.17673 9.12009 6.63795 9.48329 6.25604 9.9664C5.87413 10.4495 5.6681 11.0285 5.66667 11.6226C5.66667 12.3833 6.0003 13.1127 6.59416 13.6506C7.18803 14.1884 7.99348 14.4906 8.83333 14.4906H17.5C18.5167 14.4906 19.4917 14.1248 20.2106 13.4737C20.9295 12.8227 21.3333 11.9396 21.3333 11.0189C21.3307 10.1644 20.9788 9.34101 20.3456 8.70755C19.7124 8.07407 18.8426 7.67534 17.904 7.58823C17.7341 7.57173 17.5739 7.50831 17.4451 7.40657C17.3163 7.30484 17.2251 7.1697 17.184 7.01947C16.9236 6.05329 16.2813 5.20704 15.3785 4.64084C14.4757 4.07463 13.3751 3.82775 12.2848 3.94689C11.1946 4.06604 10.1904 4.54295 9.46225 5.2874C8.73408 6.03184 8.33244 6.99339 8.33333 7.98792Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 6.79245C0 6.37585 0.373333 6.03774 0.833333 6.03774H2.16667C2.38768 6.03774 2.59964 6.11725 2.75592 6.25879C2.9122 6.40032 3 6.59229 3 6.79245C3 6.99262 2.9122 7.18458 2.75592 7.32612C2.59964 7.46766 2.38768 7.54717 2.16667 7.54717H0.833333C0.61232 7.54717 0.400358 7.46766 0.244078 7.32612C0.0877974 7.18458 0 6.99262 0 6.79245ZM7.5 0C7.96 0 8.33333 0.338113 8.33333 0.754717V1.96226C8.33333 2.16243 8.24554 2.35439 8.08926 2.49593C7.93298 2.63747 7.72101 2.71698 7.5 2.71698C7.27899 2.71698 7.06702 2.63747 6.91074 2.49593C6.75446 2.35439 6.66667 2.16243 6.66667 1.96226V0.754717C6.66667 0.338113 7.04 0 7.5 0ZM2.196 1.98883C2.27338 1.91873 2.36526 1.86312 2.46638 1.82518C2.5675 1.78724 2.67588 1.76771 2.78533 1.76771C2.89479 1.76771 3.00317 1.78724 3.10429 1.82518C3.20541 1.86312 3.29728 1.91873 3.37467 1.98883L4.31867 2.84377C4.39606 2.91386 4.45745 2.99708 4.49933 3.08865C4.54122 3.18023 4.56278 3.27839 4.56278 3.37751C4.56278 3.47663 4.54122 3.57479 4.49933 3.66637C4.45745 3.75794 4.39606 3.84115 4.31867 3.91125C4.24127 3.98134 4.1494 4.03694 4.04828 4.07487C3.94716 4.1128 3.83878 4.13233 3.72933 4.13233C3.61988 4.13233 3.51151 4.1128 3.41039 4.07487C3.30927 4.03694 3.21739 3.98134 3.14 3.91125L2.196 3.0563C2.11859 2.98622 2.05719 2.90301 2.0153 2.81143C1.97341 2.71985 1.95184 2.62169 1.95184 2.52257C1.95184 2.42344 1.97341 2.32528 2.0153 2.2337C2.05719 2.14212 2.11859 2.05891 2.196 1.98883Z"
                            fill="white" />
                    </svg>
                </a>
                <a class="header__button header__button--two">
                    book now
                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 6.00001L1 6.00001L13 6.00001ZM13 6.00001L8.45455 11L13 6.00001ZM13 6.00001L8.45455 1.00001L13 6.00001Z"
                            fill="white" />
                        <path d="M13 6.00001L1 6.00001M8.45455 1.00001L13 6.00001L8.45455 11" stroke="white"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="aboutSecttion section_padding">
    <div class="container">
        <div class="row">
            <div class="col-6" data-animate="fade-up">
                <div class="aboutSection_images">
                    <div class="aboutSection_image aboutSection_image--one" data-animate="fade-up">
                        <img src="/imgs/about-img-1.png" alt="About Image 1" class="section_image">
                    </div>
                    <div class="aboutSection_image aboutSection_image--two" data-animate="fade-up">
                        <img src="/imgs/about-img-2.png" alt="About Image 2" class="section_image">
                    </div>
                </div>
            </div>

            <div class="col-6" data-animate="fade-up">
                <div class="section__subtitle" data-animate="fade-up">
                    <span>About Us</span>
                    <div class="subtitle_line">
                        <div class="line"></div>
                        <div class="line_icon">
                            <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.8262 4.96751C4.53119 4.90658 4.15096 4.78628 3.76089 4.55193C4.0854 4.50819 4.37713 4.34102 4.59894 4.16916C4.74972 4.05355 4.70929 3.73015 4.53993 3.69577C4.26678 3.63953 3.91058 3.52548 3.54892 3.29582C3.83082 3.26301 4.08431 3.11771 4.27661 2.97085C4.40445 2.87243 4.37058 2.59902 4.22744 2.56933C3.97067 2.51621 3.62759 2.40216 3.28778 2.16313C3.54127 2.15219 3.77072 2.02408 3.94117 1.89441C4.04497 1.81473 4.01766 1.59288 3.90075 1.56944C3.68659 1.52413 3.39814 1.42883 3.11406 1.2226C3.31619 1.21635 3.49975 1.1148 3.63415 1.01013C3.68113 0.974192 3.69861 0.891388 3.67348 0.824208C3.65928 0.785149 3.63305 0.760152 3.60246 0.753903C3.32493 0.696097 2.88679 0.528927 2.57102 0.0430416C2.53496 -0.01164 2.47378 -0.0147646 2.43553 0.0367923C2.43444 0.0383546 2.43226 0.0414793 2.43116 0.0430416C2.1143 0.527365 1.67725 0.696097 1.39973 0.753903C1.34728 0.764839 1.31122 0.833582 1.31887 0.908574C1.32324 0.952319 1.34182 0.989815 1.36804 1.01013C1.50352 1.1148 1.68599 1.21635 1.88813 1.2226C1.60405 1.42883 1.31559 1.52413 1.10144 1.56944C1.03479 1.58194 0.988898 1.67099 0.997639 1.76629C1.0031 1.82098 1.02605 1.86941 1.06101 1.89597C1.23037 2.02564 1.45982 2.15375 1.7144 2.16469C1.3735 2.40373 1.03042 2.51778 0.774743 2.5709C0.631609 2.60058 0.597738 2.87399 0.724482 2.97241C0.916784 3.11927 1.17027 3.26457 1.45217 3.29738C1.09051 3.52548 0.734316 3.63953 0.461159 3.69734C0.291802 3.73327 0.251375 4.05511 0.402158 4.17072C0.623961 4.34102 0.914599 4.50819 1.23911 4.55193C0.849042 4.78628 0.468808 4.90658 0.173799 4.96751C-0.0195962 5.00813 -0.0654865 5.37528 0.107148 5.50808C0.66548 5.93772 1.61169 6.35018 2.5 5.26436C3.3894 6.35018 4.33452 5.93772 4.89285 5.50808C5.06549 5.37684 5.0196 5.00813 4.8262 4.96751Z"
                                    fill="#C47B2A" />
                                <path
                                    d="M3.91386 7.5313H2.94907L2.8704 5.77524C2.73928 5.67681 2.61473 5.5612 2.5 5.4284C2.38527 5.5612 2.26072 5.67837 2.1296 5.77524L2.05093 7.5313H1.08614C0.995454 7.5313 0.922248 7.63598 0.922248 7.76565C0.922248 7.89532 0.995454 8 1.08614 8H3.91277C4.00345 8 4.07666 7.89532 4.07666 7.76565C4.07666 7.63598 4.00345 7.5313 3.91386 7.5313Z"
                                    fill="#C47B2A" />
                            </svg>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
                <h2 class="section__title" data-animate="fade-up">Where The Himalayas Whisper Peace</h2>

                <div class="about_content" data-animate="fade-up">
                    <p>
                        Whispering Pines, set in the heart of the Indian Himalayas and surrounded by dense Pine, Cedar,
                        Oak
                        and Rhododendron forests, with a magical dash of Wild Iris and other wild flowers, seems to
                        straight
                        out of a poem by Keats or some romantic classic.
                        Stunning view of snow capped Himalayas, captivating valleys and heart filling peace embraces you
                        here.
                    </p>
                </div>

                <a class="header__button header__button--one" data-animate="fade-up">
                    book now
                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 6.00001L1 6.00001L13 6.00001ZM13 6.00001L8.45455 11L13 6.00001ZM13 6.00001L8.45455 1.00001L13 6.00001Z"
                            fill="white" />
                        <path d="M13 6.00001L1 6.00001M8.45455 1.00001L13 6.00001L8.45455 11" stroke="white"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>

                <div class="aboutSection_Usp" data-stagger>
                    <div class="aboutSection_UspItem">
                        <img src="/imgs/icon-1.png" alt="USP Icon 1" class="usp_icon">
                        <div class="usp_text">
                            <div class="usp_counter">10+</div>
                            <span>Years of Experience</span>
                        </div>
                    </div>
                    <div class="aboutSection_UspItem">
                        <img src="/imgs/icon-2.png" alt="USP Icon 2" class="usp_icon">
                        <div class="usp_text">
                            <div class="usp_counter">300+</div>
                            <span>Customer Support</span>
                        </div>
                    </div>
                    <div class="aboutSection_UspItem">
                        <img src="/imgs/icon-3.png" alt="USP Icon 3" class="usp_icon">
                        <div class="usp_text">
                            <div class="usp_counter">45k+</div>
                            <span>Easy Booking & Cancellation</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="serviceSection bgOverlaySection section_padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-animate="fade-up">
                <div class="section__subtitle">
                    <span>Our Services</span>
                    <div class="subtitle_line">
                        <div class="line"></div>
                        <div class="line_icon">
                            <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.8262 4.96751C4.53119 4.90658 4.15096 4.78628 3.76089 4.55193C4.0854 4.50819 4.37713 4.34102 4.59894 4.16916C4.74972 4.05355 4.70929 3.73015 4.53993 3.69577C4.26678 3.63953 3.91058 3.52548 3.54892 3.29582C3.83082 3.26301 4.08431 3.11771 4.27661 2.97085C4.40445 2.87243 4.37058 2.59902 4.22744 2.56933C3.97067 2.51621 3.62759 2.40216 3.28778 2.16313C3.54127 2.15219 3.77072 2.02408 3.94117 1.89441C4.04497 1.81473 4.01766 1.59288 3.90075 1.56944C3.68659 1.52413 3.39814 1.42883 3.11406 1.2226C3.31619 1.21635 3.49975 1.1148 3.63415 1.01013C3.68113 0.974192 3.69861 0.891388 3.67348 0.824208C3.65928 0.785149 3.63305 0.760152 3.60246 0.753903C3.32493 0.696097 2.88679 0.528927 2.57102 0.0430416C2.53496 -0.01164 2.47378 -0.0147646 2.43553 0.0367923C2.43444 0.0383546 2.43226 0.0414793 2.43116 0.0430416C2.1143 0.527365 1.67725 0.696097 1.39973 0.753903C1.34728 0.764839 1.31122 0.833582 1.31887 0.908574C1.32324 0.952319 1.34182 0.989815 1.36804 1.01013C1.50352 1.1148 1.68599 1.21635 1.88813 1.2226C1.60405 1.42883 1.31559 1.52413 1.10144 1.56944C1.03479 1.58194 0.988898 1.67099 0.997639 1.76629C1.0031 1.82098 1.02605 1.86941 1.06101 1.89597C1.23037 2.02564 1.45982 2.15375 1.7144 2.16469C1.3735 2.40373 1.03042 2.51778 0.774743 2.5709C0.631609 2.60058 0.597738 2.87399 0.724482 2.97241C0.916784 3.11927 1.17027 3.26457 1.45217 3.29738C1.09051 3.52548 0.734316 3.63953 0.461159 3.69734C0.291802 3.73327 0.251375 4.05511 0.402158 4.17072C0.623961 4.34102 0.914599 4.50819 1.23911 4.55193C0.849042 4.78628 0.468808 4.90658 0.173799 4.96751C-0.0195962 5.00813 -0.0654865 5.37528 0.107148 5.50808C0.66548 5.93772 1.61169 6.35018 2.5 5.26436C3.3894 6.35018 4.33452 5.93772 4.89285 5.50808C5.06549 5.37684 5.0196 5.00813 4.8262 4.96751Z"
                                    fill="#C47B2A" />
                                <path
                                    d="M3.91386 7.5313H2.94907L2.8704 5.77524C2.73928 5.67681 2.61473 5.5612 2.5 5.4284C2.38527 5.5612 2.26072 5.67837 2.1296 5.77524L2.05093 7.5313H1.08614C0.995454 7.5313 0.922248 7.63598 0.922248 7.76565C0.922248 7.89532 0.995454 8 1.08614 8H3.91277C4.00345 8 4.07666 7.89532 4.07666 7.76565C4.07666 7.63598 4.00345 7.5313 3.91386 7.5313Z"
                                    fill="#C47B2A" />
                            </svg>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
                <h3 class="section__title text-white">What You Can Do Here!</h3>
            </div>
            <div class="col-lg-4 text-end" data-animate="fade-up">
                <a class="header__button header__button--one">
                    View All
                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 6.00001L1 6.00001L13 6.00001ZM13 6.00001L8.45455 11L13 6.00001ZM13 6.00001L8.45455 1.00001L13 6.00001Z"
                            fill="white" />
                        <path d="M13 6.00001L1 6.00001M8.45455 1.00001L13 6.00001L8.45455 11" stroke="white"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="row mt-5" data-stagger>
            <div class="col-lg-6">
                <div class="service-card">
                    <div class="service-card__media">
                        <img src="/imgs/ser-1.png" alt="Adventure Sports" class="service-card__img">
                        <div class="service-card__overlay"></div>
                        <div class="service-card__content">
                            <h3 class="service-card__title">Adventure Sports</h3>
                            <p class="service-card__desc">
                                Experience thrilling outdoor activities filled with excitement and adrenaline.
                            </p>
                            <a href="#" class="service-card__link">
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="service-card service-card--small">
                            <div class="service-card__media">
                                <img src="/imgs/ser-2.png" alt="Adventure Sports" class="service-card__img">
                                <div class="service-card__overlay"></div>
                                <div class="service-card__content">
                                    <h3 class="service-card__title">Accommodation</h3>
                                    <p class="service-card__desc">
                                        Comfortable stays with scenic views.
                                    </p>
                                    <a href="#" class="service-card__link">
                                        Read more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="service-card service-card--small">
                            <div class="service-card__media">
                                <img src="/imgs/ser-3.png" alt="Adventure Sports" class="service-card__img">
                                <div class="service-card__overlay"></div>
                                <div class="service-card__content">
                                    <h3 class="service-card__title">Dining</h3>
                                    <p class="service-card__desc">
                                        Comfortable stays with scenic views. 
                                    </p>
                                    <a href="#" class="service-card__link">
                                        Read more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="service-card service-card--bottom">
                            <div class="service-card__media">
                                <img src="/imgs/ser-4.png" alt="Adventure Sports" class="service-card__img">
                                <div class="service-card__overlay"></div>
                                <div class="service-card__content">
                                    <h3 class="service-card__title">Things to Do</h3>
                                    <p class="service-card__desc">
                                       Discover unforgettable adventures and fun activities for every traveler.
                                    </p>
                                    <a href="#" class="service-card__link">
                                        Read more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="gallerySection section_padding">
    <div class="container">
        <div class="text-center" data-animate="fade-up">
            <div class="section__subtitle">
                <span>Gallery</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.8262 4.96751C4.53119 4.90658 4.15096 4.78628 3.76089 4.55193C4.0854 4.50819 4.37713 4.34102 4.59894 4.16916C4.74972 4.05355 4.70929 3.73015 4.53993 3.69577C4.26678 3.63953 3.91058 3.52548 3.54892 3.29582C3.83082 3.26301 4.08431 3.11771 4.27661 2.97085C4.40445 2.87243 4.37058 2.59902 4.22744 2.56933C3.97067 2.51621 3.62759 2.40216 3.28778 2.16313C3.54127 2.15219 3.77072 2.02408 3.94117 1.89441C4.04497 1.81473 4.01766 1.59288 3.90075 1.56944C3.68659 1.52413 3.39814 1.42883 3.11406 1.2226C3.31619 1.21635 3.49975 1.1148 3.63415 1.01013C3.68113 0.974192 3.69861 0.891388 3.67348 0.824208C3.65928 0.785149 3.63305 0.760152 3.60246 0.753903C3.32493 0.696097 2.88679 0.528927 2.57102 0.0430416C2.53496 -0.01164 2.47378 -0.0147646 2.43553 0.0367923C2.43444 0.0383546 2.43226 0.0414793 2.43116 0.0430416C2.1143 0.527365 1.67725 0.696097 1.39973 0.753903C1.34728 0.764839 1.31122 0.833582 1.31887 0.908574C1.32324 0.952319 1.34182 0.989815 1.36804 1.01013C1.50352 1.1148 1.68599 1.21635 1.88813 1.2226C1.60405 1.42883 1.31559 1.52413 1.10144 1.56944C1.03479 1.58194 0.988898 1.67099 0.997639 1.76629C1.0031 1.82098 1.02605 1.86941 1.06101 1.89597C1.23037 2.02564 1.45982 2.15375 1.7144 2.16469C1.3735 2.40373 1.03042 2.51778 0.774743 2.5709C0.631609 2.60058 0.597738 2.87399 0.724482 2.97241C0.916784 3.11927 1.17027 3.26457 1.45217 3.29738C1.09051 3.52548 0.734316 3.63953 0.461159 3.69734C0.291802 3.73327 0.251375 4.05511 0.402158 4.17072C0.623961 4.34102 0.914599 4.50819 1.23911 4.55193C0.849042 4.78628 0.468808 4.90658 0.173799 4.96751C-0.0195962 5.00813 -0.0654865 5.37528 0.107148 5.50808C0.66548 5.93772 1.61169 6.35018 2.5 5.26436C3.3894 6.35018 4.33452 5.93772 4.89285 5.50808C5.06549 5.37684 5.0196 5.00813 4.8262 4.96751Z"
                                fill="#C47B2A" />
                            <path
                                d="M3.91386 7.5313H2.94907L2.8704 5.77524C2.73928 5.67681 2.61473 5.5612 2.5 5.4284C2.38527 5.5612 2.26072 5.67837 2.1296 5.77524L2.05093 7.5313H1.08614C0.995454 7.5313 0.922248 7.63598 0.922248 7.76565C0.922248 7.89532 0.995454 8 1.08614 8H3.91277C4.00345 8 4.07666 7.89532 4.07666 7.76565C4.07666 7.63598 4.00345 7.5313 3.91386 7.5313Z"
                                fill="#C47B2A" />
                        </svg>
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h3 class="section__title">Discover Whispering Pines</h3>
        </div>
    </div>
    <div class="container-fluid p-0" data-animate="fade-up">
        <div class="accommodation-slider-wrapper mt-5">
            <div class="swiper accommodation-slider">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <div class="gallery-item__media">
                                <img src="/imgs/g-img-1.png" alt="One Bedroom Cottage" class="gallery-item__img">
                                <div class="gallery-item__overlay"></div>
                            </div>
                            <div class="gallery-item__content">
                                <h3 class="gallery-item__title">One Bedroom Cottage</h3>
                                <p class="gallery-item__desc">Tucked into a quiet pine glade, our hand-crafted
                                    one-bedroom
                                    cottage offers panoramic views of the snow-capped peaks right from your pillow.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <div class="gallery-item__media">
                                <img src="/imgs/g-img-2.png" alt="Two Bedroom Cottage" class="gallery-item__img">
                                <div class="gallery-item__overlay"></div>
                            </div>
                            <div class="gallery-item__content">
                                <h3 class="gallery-item__title">Two Bedroom Cottage</h3>
                                <p class="gallery-item__desc">Tucked into a quiet pine glade, our hand-crafted
                                    one-bedroom
                                    cottage offers panoramic views of the snow-capped peaks right from your pillow.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <div class="gallery-item__media">
                                <img src="/imgs/g-img-3.png" alt="Suite" class="gallery-item__img">
                                <div class="gallery-item__overlay"></div>
                            </div>
                            <div class="gallery-item__content">
                                <h3 class="gallery-item__title">The Pine Suite</h3>
                                <p class="gallery-item__desc">Tucked into a quiet pine glade, our hand-crafted
                                    one-bedroom
                                    cottage offers panoramic views of the snow-capped peaks right from your pillow.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <div class="gallery-item__media">
                                <img src="/imgs/g-img-1.png" alt="One Bedroom Cottage" class="gallery-item__img">
                                <div class="gallery-item__overlay"></div>
                            </div>
                            <div class="gallery-item__content">
                                <h3 class="gallery-item__title">One Bedroom Cottage</h3>
                                <p class="gallery-item__desc">Tucked into a quiet pine glade, our hand-crafted
                                    one-bedroom
                                    cottage offers panoramic views of the snow-capped peaks right from your pillow.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <div class="gallery-item__media">
                                <img src="/imgs/g-img-2.png" alt="Two Bedroom Cottage" class="gallery-item__img">
                                <div class="gallery-item__overlay"></div>
                            </div>
                            <div class="gallery-item__content">
                                <h3 class="gallery-item__title">Two Bedroom Cottage</h3>
                                <p class="gallery-item__desc">Tucked into a quiet pine glade, our hand-crafted
                                    one-bedroom
                                    cottage offers panoramic views of the snow-capped peaks right from your pillow.</p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <div class="gallery-item__media">
                                <img src="/imgs/g-img-3.png" alt="Suite" class="gallery-item__img">
                                <div class="gallery-item__overlay"></div>
                            </div>
                            <div class="gallery-item__content">
                                <h3 class="gallery-item__title">The Pine Suite</h3>
                                <p class="gallery-item__desc">Tucked into a quiet pine glade, our hand-crafted
                                    one-bedroom
                                    cottage offers panoramic views of the snow-capped peaks right from your pillow.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </div>
</section>

<section class="testimonialSection section_padding">
    <div class="container">

        <div class="text-center" data-animate="fade-up">
            <div class="section__subtitle">
                <span>Testimonials</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon">
                        <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.8262 4.96751C4.53119 4.90658 4.15096 4.78628 3.76089 4.55193C4.0854 4.50819 4.37713 4.34102 4.59894 4.16916C4.74972 4.05355 4.70929 3.73015 4.53993 3.69577C4.26678 3.63953 3.91058 3.52548 3.54892 3.29582C3.83082 3.26301 4.08431 3.11771 4.27661 2.97085C4.40445 2.87243 4.37058 2.59902 4.22744 2.56933C3.97067 2.51621 3.62759 2.40216 3.28778 2.16313C3.54127 2.15219 3.77072 2.02408 3.94117 1.89441C4.04497 1.81473 4.01766 1.59288 3.90075 1.56944C3.68659 1.52413 3.39814 1.42883 3.11406 1.2226C3.31619 1.21635 3.49975 1.1148 3.63415 1.01013C3.68113 0.974192 3.69861 0.891388 3.67348 0.824208C3.65928 0.785149 3.63305 0.760152 3.60246 0.753903C3.32493 0.696097 2.88679 0.528927 2.57102 0.0430416C2.53496 -0.01164 2.47378 -0.0147646 2.43553 0.0367923C2.43444 0.0383546 2.43226 0.0414793 2.43116 0.0430416C2.1143 0.527365 1.67725 0.696097 1.39973 0.753903C1.34728 0.764839 1.31122 0.833582 1.31887 0.908574C1.32324 0.952319 1.34182 0.989815 1.36804 1.01013C1.50352 1.1148 1.68599 1.21635 1.88813 1.2226C1.60405 1.42883 1.31559 1.52413 1.10144 1.56944C1.03479 1.58194 0.988898 1.67099 0.997639 1.76629C1.0031 1.82098 1.02605 1.86941 1.06101 1.89597C1.23037 2.02564 1.45982 2.15375 1.7144 2.16469C1.3735 2.40373 1.03042 2.51778 0.774743 2.5709C0.631609 2.60058 0.597738 2.87399 0.724482 2.97241C0.916784 3.11927 1.17027 3.26457 1.45217 3.29738C1.09051 3.52548 0.734316 3.63953 0.461159 3.69734C0.291802 3.73327 0.251375 4.05511 0.402158 4.17072C0.623961 4.34102 0.914599 4.50819 1.23911 4.55193C0.849042 4.78628 0.468808 4.90658 0.173799 4.96751C-0.0195962 5.00813 -0.0654865 5.37528 0.107148 5.50808C0.66548 5.93772 1.61169 6.35018 2.5 5.26436C3.3894 6.35018 4.33452 5.93772 4.89285 5.50808C5.06549 5.37684 5.0196 5.00813 4.8262 4.96751Z"
                                fill="#C47B2A" />
                            <path
                                d="M3.91386 7.5313H2.94907L2.8704 5.77524C2.73928 5.67681 2.61473 5.5612 2.5 5.4284C2.38527 5.5612 2.26072 5.67837 2.1296 5.77524L2.05093 7.5313H1.08614C0.995454 7.5313 0.922248 7.63598 0.922248 7.76565C0.922248 7.89532 0.995454 8 1.08614 8H3.91277C4.00345 8 4.07666 7.89532 4.07666 7.76565C4.07666 7.63598 4.00345 7.5313 3.91386 7.5313Z"
                                fill="#C47B2A" />
                        </svg>
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h3 class="section__title"> Our Guests Speak -Real Stories </h3>
        </div>

        <div class="testimonials__wrapper mt-5" data-animate="fade-up">

            <!-- LEFT: video thumbnail -->
            <div class="testimonials__video">
                <div class="testimonials__video-thumb" data-bs-toggle="modal" data-bs-target="#videoModal"
                    data-video-src="https://www.youtube.com/embed/VIDEO_ID_2?autoplay=1&rel=0">
                    <img src="/imgs/testimonial-video-img.png" alt="Testimonial Video" class="testimonials__video-img">
                    <button class="testimonials__play-btn" aria-label="Play video">
                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none">
                            <path d="M2 2L18 11L2 20V2Z" fill="#000" stroke="#000" stroke-width="2"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- CENTER: Swiper slider -->
            <div class="testimonials__content">
                <div class="swiper testimonials-swiper">
                    <div class="swiper-wrapper">

                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <p class="testimonials__body">
                                Long weekends were always tough for us. Having covered almost everything nearby Delhi,
                                we were out of ideas on what next?...till we discovered this place! It is beautiful,
                                accessible and with the amazing facilities and activities, you never get bored of this
                                place.
                            </p>
                            <div class="testimonials__author">
                                <div class="testimonials__author-avatar  ">
                                    <img src="/imgs/test-icon.png" alt="Sukhman Dhillon">
                                </div>
                                <div class="testimonials__author-info">
                                    <span class="testimonials__author-name">Sukhman Dhillon</span>
                                    <span class="testimonials__author-location">New Delhi</span>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide">
                            <p class="testimonials__body">
                                The cottage was beyond our expectations. Waking up to snow-capped peaks every morning
                                was surreal. The staff was incredibly warm and the food was delicious. Will definitely 
                                return next winter season.
                            </p>
                            <div class="testimonials__author">
                                <div class="testimonials__author-avatar">
                                    <img src="/imgs/test-icon.png" alt="Rohit Mehra">
                                </div>
                                <div class="testimonials__author-info">
                                    <span class="testimonials__author-name">Rohit Mehra</span>
                                    <span class="testimonials__author-location">Mumbai</span>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide">
                            <p class="testimonials__body">
                                Perfect getaway from the city chaos. The pine forest walks, bonfire nights and
                                stargazing were highlights of our trip. Kanatal is truly a hidden gem and this
                                property made it even more special.
                            </p>
                            <div class="testimonials__author">
                                <div class="testimonials__author-avatar">
                                    <img src="/imgs/test-icon.png" alt="Priya Sharma">
                                </div>
                                <div class="testimonials__author-info">
                                    <span class="testimonials__author-name">Priya Sharma</span>
                                    <span class="testimonials__author-location">Bangalore</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Nav inside slider -->
                    <div class="testimonials__nav">
                        <button class="testimonials__nav-btn testimonials__nav-btn--prev">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="testimonials__nav-btn testimonials__nav-btn--next">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6 3L11 8L6 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- RIGHT: scenic image -->
            <div class="testimonials__image">
                <img src="/imgs/testimonial-img.png" alt="Kanatal scenery" class="testimonials__scene-img">
            </div>

        </div>

    </div>
</section>

<!-- ── VIDEO MODAL ── -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content testimonials__modal-content">
            <button type="button" class="testimonials__modal-close" data-bs-dismiss="modal" aria-label="Close">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M1 1L17 17M17 1L1 17" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
            <div class="testimonials__modal-video">
                <!-- src is empty on purpose — JS fills it on open, clears on close -->
                <iframe id="testimonialIframe" src="" title="Testimonial Video" frameborder="0"
                    allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>

<section class="contactSection section_padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-animate="fade-up">
                <div class="contactSection_left">
                    <div class="section__subtitle text-white">
                        <span class="text-white">Contact Us</span>
                        <div class="subtitle_line">  
                            <div class="line bg-white"></div>
                            <div class="line_icon">
                                <svg width="5" height="8" viewBox="0 0 5 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.8262 4.96751C4.53119 4.90658 4.15096 4.78628 3.76089 4.55193C4.0854 4.50819 4.37713 4.34102 4.59894 4.16916C4.74972 4.05355 4.70929 3.73015 4.53993 3.69577C4.26678 3.63953 3.91058 3.52548 3.54892 3.29582C3.83082 3.26301 4.08431 3.11771 4.27661 2.97085C4.40445 2.87243 4.37058 2.59902 4.22744 2.56933C3.97067 2.51621 3.62759 2.40216 3.28778 2.16313C3.54127 2.15219 3.77072 2.02408 3.94117 1.89441C4.04497 1.81473 4.01766 1.59288 3.90075 1.56944C3.68659 1.52413 3.39814 1.42883 3.11406 1.2226C3.31619 1.21635 3.49975 1.1148 3.63415 1.01013C3.68113 0.974192 3.69861 0.891388 3.67348 0.824208C3.65928 0.785149 3.63305 0.760152 3.60246 0.753903C3.32493 0.696097 2.88679 0.528927 2.57102 0.0430416C2.53496 -0.01164 2.47378 -0.0147646 2.43553 0.0367923C2.43444 0.0383546 2.43226 0.0414793 2.43116 0.0430416C2.1143 0.527365 1.67725 0.696097 1.39973 0.753903C1.34728 0.764839 1.31122 0.833582 1.31887 0.908574C1.32324 0.952319 1.34182 0.989815 1.36804 1.01013C1.50352 1.1148 1.68599 1.21635 1.88813 1.2226C1.60405 1.42883 1.31559 1.52413 1.10144 1.56944C1.03479 1.58194 0.988898 1.67099 0.997639 1.76629C1.0031 1.82098 1.02605 1.86941 1.06101 1.89597C1.23037 2.02564 1.45982 2.15375 1.7144 2.16469C1.3735 2.40373 1.03042 2.51778 0.774743 2.5709C0.631609 2.60058 0.597738 2.87399 0.724482 2.97241C0.916784 3.11927 1.17027 3.26457 1.45217 3.29738C1.09051 3.52548 0.734316 3.63953 0.461159 3.69734C0.291802 3.73327 0.251375 4.05511 0.402158 4.17072C0.623961 4.34102 0.914599 4.50819 1.23911 4.55193C0.849042 4.78628 0.468808 4.90658 0.173799 4.96751C-0.0195962 5.00813 -0.0654865 5.37528 0.107148 5.50808C0.66548 5.93772 1.61169 6.35018 2.5 5.26436C3.3894 6.35018 4.33452 5.93772 4.89285 5.50808C5.06549 5.37684 5.0196 5.00813 4.8262 4.96751Z"
                                        fill="#fff" />
                                    <path
                                        d="M3.91386 7.5313H2.94907L2.8704 5.77524C2.73928 5.67681 2.61473 5.5612 2.5 5.4284C2.38527 5.5612 2.26072 5.67837 2.1296 5.77524L2.05093 7.5313H1.08614C0.995454 7.5313 0.922248 7.63598 0.922248 7.76565C0.922248 7.89532 0.995454 8 1.08614 8H3.91277C4.00345 8 4.07666 7.89532 4.07666 7.76565C4.07666 7.63598 4.00345 7.5313 3.91386 7.5313Z"
                                        fill="#fff" />
                                </svg>
                            </div>
                            <div class="line bg-white"></div>
                        </div>
                    </div>
                    <h3 class="section__title contactSection_title"> Adventure Is Just One Message Away </h3>
                    <p class="contactSection_desc">
                        Whether you’re looking for adventure, peace, or a refreshing escape into nature, we’re here to
                        help you plan the perfect mountain getaway filled with unforgettable experiences and
                        breathtaking views.
                    </p>
                    <a class="header__button header__button--one">
                        Enquire Now
                        <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13 6.00001L1 6.00001L13 6.00001ZM13 6.00001L8.45455 11L13 6.00001ZM13 6.00001L8.45455 1.00001L13 6.00001Z"
                                fill="white" />
                            <path d="M13 6.00001L1 6.00001M8.45455 1.00001L13 6.00001L8.45455 11" stroke="white"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-animate="fade-up">
                <div class="contactSection_right">
                    <div class="contact-video-card" data-bs-toggle="modal" data-bs-target="#contactVideoModal"
                        data-video-src="https://www.youtube.com/embed/VIDEO_ID_1?autoplay=1&rel=0">
                        <div class="contact-video-card__media">
                            <img src="/imgs/contact-img.png" alt="Adventure Video" class="contact-video-card__img">
                            <div class="contact-video-card__overlay"></div>
                            <button class="contact-video-card__play" aria-label="Play Video">
                                <svg width="20" height="24" viewBox="0 0 20 24" fill="none">
                                    <path d="M2 2L18 12L2 22V2Z" fill="white" stroke="white" stroke-width="1.5"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="clientSection section_padding">
    <div class="container">
        <div class="clientSection__wrapper">
            <div class="row align-items-center">
                <div class="col-lg-3" data-animate="fade-up">
                    <h2 class="section__title clientSection_title"> Our Esteemed
                        Clients </h2>
                </div>
                <div class="col-lg-1"><div class="divider"></div></div>
                <div class="col-lg-8" data-animate="fade-up">
                    <div class="client-logos ps-lg-5">
                        <div class="swiper client-logos-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-1.png" alt="Client Logo 1">
                                </div>
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-2.png" alt="Client Logo 2">
                                </div>
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-3.png" alt="Client Logo 3">
                                </div>
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-4.png" alt="Client Logo 4">
                                </div>
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-1.png" alt="Client Logo 1">
                                </div>
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-2.png" alt="Client Logo 2">
                                </div>
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-3.png" alt="Client Logo 3">
                                </div>
                                <div class="swiper-slide client-logo"><img src="/imgs/cl-4.png" alt="Client Logo 4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="contactVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content contact-video-modal__content">
            <button type="button" class="contact-video-modal__close" data-bs-dismiss="modal" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M1 1L15 15M15 1L1 15" stroke="white" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>
            <div class="contact-video-modal__body">
                <iframe id="contactIframe" src="" title="Adventure Video" frameborder="0"
                    allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>


<script>
    const video = document.getElementById('heroVideo');
    const poster = document.getElementById('heroPoster');

    video.addEventListener('canplaythrough', () => {
        video.classList.add('is-playing');
        poster.style.opacity = '0';
    });
</script>

<script>
    const videoModal = document.getElementById('videoModal');
    const videoIframe = document.getElementById('videoIframe');

    videoModal.addEventListener('show.bs.modal', (e) => {
        // e.relatedTarget = the element that triggered the modal
        const trigger = e.relatedTarget;
        const src = trigger?.dataset?.videoSrc || '';
        videoIframe.src = src;
    });

    videoModal.addEventListener('hide.bs.modal', () => {
        videoIframe.src = '';
    });
</script>

@include('footer') 