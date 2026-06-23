@extends('layouts.MainLayouts')
@section('title', 'Login')
@section('content')

<section class="login-page ">
    <div class="split-container">
        <!-- LEFT VIDEO SIDE -->
        <div class="left-side">
            <video autoplay muted loop>
                <source src="./images/banner-video.mp4" type="video/mp4">
            </video>
            <div class="left-overlay"></div>
        </div>
        <!-- RIGHT IMAGE SIDE -->
        <div class="right-side"></div>
    </div>
    <!-- LOGIN CARD -->
    <div class="mid-card">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="left-content">
                        <h1>Login</h1>
                        <p class="login-para">
                            Members of ESMA enjoy access to a library of information and business opportunities, as well
                            a
                            network of manufacturers and exclusive member news.
                        </p>
                        <p>
                            Use the login form to view your account or visit our How to Join page to learn how you can
                            become an ESMA member.
                        </p>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="login-card">
                        <div class="login-card-inner">
                            <div id="successmsg"></div>
                            <div id="forgetDefaultState">
                                <form id="forgotPasswordForm" method="POST" action="javascript:void(0);">

                                    <h3 class="forget-text heading-26 mb-2">Password Reset</h3>
                                    <p class="forget-para">Enter your username or email address, and you will receive instructions for changing your password in your inbox.</p>

                                    @csrf
                                    <div class="form-group">
                                        <label class=""> Username or Email </label>
                                        <input type="text" name="email" id="email" placeholder="yourlogin@domain.com">
                                        <span id="email_error_email" style="color:red"></span>
                                    </div>

                                    <hr
                                        style="background: linear-gradient(90deg, rgba(138, 140, 228, 0) 0%, rgba(138, 140, 228, 0.5) 50%, rgba(138, 140, 228, 0) 100%); margin:1.5rem 0">
                                    <div class="button-row mt-3">
                                        <div class="captcha-wrapper">
                                            <div class="g-recaptcha"
                                                data-sitekey="{{ config('services.recaptcha.site_key') }}"
                                                data-form="forgotPasswordForm" data-callback="captchaSuccess"
                                                data-expired-callback="captchaExpired">
                                            </div>

                                            <span id="captcha_error" class="text-danger"></span>
                                        </div>
                                        <!--<a href="#" class="btn-style-5 btn">-->
                                        <!--    <svg class="svg-icon">-->
                                        <!--        <use href="images/icons/icons-sprite.svg#icon-captcha"></use>-->
                                        <!--    </svg> Click to verify</a>-->
                                        <button type="submit" class="btn-style-4 btn submit-btn">
                                            <svg class="svg-icon">
                                                <use
                                                    href="{{ asset('images/icons/icons-sprite.svg') }}#icon-arrow-right-box">
                                                </use>
                                            </svg> Request Password Reset </button>
                                    </div>
                                    <img id="loadingImage" src="{{ asset('images/new_svg.svg') }}"
                                        style="display:none; width:80px; margin-top:10px;" />
                                </form>
                                
                            </div>
                            <div id="forgetloaderState" style="display: none; text-align: center; padding: 30px 0;">
                                <svg class="login-loader" width="157" height="157" viewBox="0 0 157 157" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_f_236_29730)">
                                        <circle cx="77.9868" cy="80.5973" r="59.7826"
                                            transform="rotate(89.9328 77.9868 80.5973)"
                                            stroke="url(#paint0_linear_236_29730)" stroke-width="4" />
                                    </g>
                                    <g filter="url(#filter1_f_236_29730)" style="mix-blend-mode:overlay">
                                        <circle cx="77.9868" cy="80.5973" r="59.7826"
                                            transform="rotate(89.9328 77.9868 80.5973)"
                                            stroke="url(#paint1_linear_236_29730)" stroke-width="11" />
                                    </g>
                                    <g filter="url(#filter2_f_236_29730)">
                                        <circle cx="78.4228" cy="78.4236" r="55.8696"
                                            transform="rotate(51.9935 78.4228 78.4236)"
                                            stroke="url(#paint2_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="4" />
                                    </g>
                                    <g filter="url(#filter3_f_236_29730)" style="mix-blend-mode:overlay">
                                        <circle cx="78.4228" cy="78.4236" r="55.8696"
                                            transform="rotate(51.9935 78.4228 78.4236)"
                                            stroke="url(#paint3_linear_236_29730)" stroke-width="11" />
                                    </g>
                                    <g filter="url(#filter4_f_236_29730)">
                                        <circle cx="54.1304" cy="54.1304" r="54.1304"
                                            transform="matrix(1 0 0 -1 26.4648 132.989)"
                                            stroke="url(#paint4_linear_236_29730)" stroke-width="4" />
                                    </g>
                                    <g filter="url(#filter5_f_236_29730)" style="mix-blend-mode:overlay">
                                        <circle cx="54.1304" cy="54.1304" r="54.1304"
                                            transform="matrix(1 0 0 -1 26.4648 132.989)"
                                            stroke="url(#paint5_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="11" />
                                    </g>
                                    <g filter="url(#filter6_f_236_29730)">
                                        <circle cx="81.0304" cy="82.3365" r="53.2609"
                                            stroke="url(#paint6_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="4" />
                                    </g>
                                    <g filter="url(#filter7_f_236_29730)" style="mix-blend-mode:overlay">
                                        <circle cx="81.0304" cy="82.3365" r="53.2609"
                                            stroke="url(#paint7_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="11" />
                                    </g>
                                    <g filter="url(#filter8_f_236_29730)">
                                        <circle cx="77.9868" cy="81.4672" r="55.8696"
                                            stroke="url(#paint8_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="4" />
                                    </g>
                                    <g filter="url(#filter9_f_236_29730)" style="mix-blend-mode:overlay">
                                        <circle cx="77.9868" cy="81.4672" r="55.8696"
                                            stroke="url(#paint9_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="11" />
                                    </g>
                                    <g filter="url(#filter10_f_236_29730)">
                                        <circle cx="76.9" cy="81.6846" r="59.1304"
                                            stroke="url(#paint10_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="4" />
                                    </g>
                                    <g filter="url(#filter11_f_236_29730)" style="mix-blend-mode:overlay">
                                        <circle cx="76.9" cy="81.6846" r="59.1304"
                                            stroke="url(#paint11_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="11" />
                                    </g>
                                    <g filter="url(#filter12_f_236_29730)">
                                        <circle cx="78.4214" cy="79.728" r="51.9565"
                                            stroke="url(#paint12_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="4" />
                                    </g>
                                    <g filter="url(#filter13_f_236_29730)" style="mix-blend-mode:overlay">
                                        <circle cx="78.4214" cy="79.728" r="51.9565"
                                            stroke="url(#paint13_linear_236_29730)" stroke-opacity="0.8"
                                            stroke-width="11" />
                                    </g>
                                    <defs>
                                        <filter id="filter0_f_236_29730" x="13.2031" y="15.8149" width="129.566"
                                            height="129.565" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter1_f_236_29730" x="9.70312" y="12.3149" width="136.566"
                                            height="136.565" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter2_f_236_29730" x="17.5508" y="17.5513" width="121.742"
                                            height="121.745" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter3_f_236_29730" x="14.0508" y="14.0513" width="128.746"
                                            height="128.745" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter4_f_236_29730" x="21.4648" y="19.728" width="118.262"
                                            height="118.261" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter5_f_236_29730" x="17.9648" y="16.228" width="125.262"
                                            height="125.261" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter6_f_236_29730" x="22.7695" y="24.0757" width="116.523"
                                            height="116.522" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter7_f_236_29730" x="19.2695" y="20.5757" width="123.523"
                                            height="123.522" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter8_f_236_29730" x="17.1172" y="20.5977" width="121.738"
                                            height="121.739" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter9_f_236_29730" x="13.6172" y="17.0977" width="128.738"
                                            height="128.739" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter10_f_236_29730" x="12.7695" y="17.5542" width="128.262"
                                            height="128.261" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter11_f_236_29730" x="9.26953" y="14.0542" width="135.262"
                                            height="135.261" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter12_f_236_29730" x="21.4648" y="22.7715" width="113.914"
                                            height="113.913" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <filter id="filter13_f_236_29730" x="17.9648" y="19.2715" width="120.914"
                                            height="120.913" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix"
                                                result="shape" />
                                            <feGaussianBlur stdDeviation="1.5"
                                                result="effect1_foregroundBlur_236_29730" />
                                        </filter>
                                        <linearGradient id="paint0_linear_236_29730" x1="24.2472" y1="115.776"
                                            x2="26.3379" y2="33.0153" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_236_29730" x1="35.6505" y1="124.562"
                                            x2="26.2701" y2="50.706" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#8A8CE4" />
                                            <stop offset="1" stop-color="#8A8CE4" stop-opacity="0.56" />
                                        </linearGradient>
                                        <linearGradient id="paint2_linear_236_29730" x1="38.8575" y1="119.511"
                                            x2="30.0912" y2="50.4889" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-color="#262761" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint3_linear_236_29730" x1="38.8575" y1="119.511"
                                            x2="30.0912" y2="50.4889" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#8A8CE4" />
                                            <stop offset="1" stop-color="#8A8CE4" stop-opacity="0.56" />
                                        </linearGradient>
                                        <linearGradient id="paint4_linear_236_29730" x1="5.47167" y1="85.9834"
                                            x2="70.7409" y2="26.9675" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint5_linear_236_29730" x1="15.7968" y1="93.9384"
                                            x2="7.30331" y2="27.0652" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#37387F" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint6_linear_236_29730" x1="43.3126" y1="121.505"
                                            x2="37.9042" y2="50.6388" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint7_linear_236_29730" x1="43.3126" y1="121.505"
                                            x2="34.9555" y2="55.7061" gradientUnits="userSpaceOnUse">
                                            <stop offset="0.6875" stop-color="#262761" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint8_linear_236_29730" x1="38.4215" y1="122.554"
                                            x2="29.6551" y2="53.5324" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-color="#262761" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint9_linear_236_29730" x1="38.4215" y1="122.554"
                                            x2="29.6551" y2="53.5324" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#8A8CE4" />
                                            <stop offset="1" stop-color="#FFF7E6" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint10_linear_236_29730" x1="35.0255" y1="125.17"
                                            x2="85.8731" y2="65.8091" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint11_linear_236_29730" x1="35.0255" y1="125.17"
                                            x2="25.7474" y2="52.1194" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#8A8CE4" />
                                            <stop offset="1" stop-color="#FFF7E6" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint12_linear_236_29730" x1="41.6272" y1="117.937"
                                            x2="26.4648" y2="56.7601" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint13_linear_236_29730" x1="41.6272" y1="117.937"
                                            x2="33.4749" y2="53.7497" gradientUnits="userSpaceOnUse">
                                            <stop offset="0.144231" stop-color="#37387F" />
                                            <stop offset="1" stop-color="#FF0000" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            {{-- STATE 3: Success --}}
                            <div id="forgetSuccessState" style="display: none; text-align: center; padding: 30px 0;">
                                <img src="{{ asset('images/green-redirect-img.svg') }}" alt="Success" width="80"
                                    style="margin-bottom:15px; display:block; margin-left:auto; margin-right:auto;">
                                <h3 class="text-success">Reset Link Send Successully</h3>
                            </div>
                            {{-- STATE 4: Error --}}
                            <div id="forgetErrorState" style="display: none; text-align: center; padding: 30px 0;">
                                <img src="{{ asset('images/incorrect-data.png') }}" alt="Error" width="80"
                                    style="margin-bottom:15px; display:block; margin-left:auto; margin-right:auto;">
                                <h3 class="text-error text-danger"></h3>

                            </div>
                        </div>
                        {{-- Always visible --}}
                        <div class="bottom-bar">
                            <div class="d-flex align-items-center gap-2">
                                <svg class="svg-icon">
                                    <use href="{{ asset('images/icons/icons-sprite.svg') }}#icon-arrow-right-box"></use>
                                </svg>
                                <a href="{{ route('login') }}" class="text-white">Back to Login</a>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <svg class="svg-icon">
                                    <use href="{{ asset('images/icons/icons-sprite.svg') }}#icon-user-plus"></use>
                                </svg> Not a member? <a href="{{ route('membership') }}#howtojoin">Learn How To Join</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@push('page-js')

<script>

    let captchaMap = {};

    function initCaptcha() {

        if (typeof grecaptcha === 'undefined') {
            console.error("reCAPTCHA not loaded yet");
            return;
        }

        $('.g-recaptcha').each(function () {

            let el = this;
            let formId = $(el).attr('data-form'); // ✅ safer than .data()

            if (!formId) {
                // console.error("Missing data-form on captcha element");
                return;
            }

            let widgetId = grecaptcha.render(el, {
                sitekey: $(el).attr('data-sitekey'),

                callback: function () {
                    $('#' + formId).find('.captcha-error').text('');
                    $('#loginErrorState').hide();
                },

                'expired-callback': function () {
                    $('#loginErrorState').show()
                        .find('.text-error')
                        .html('Captcha expired. Please verify again.');
                }
            });

            captchaMap[formId] = widgetId;
        });

        // console.log("captchaMap initialized:", captchaMap);
    }


</script>

<script>
    $(document).ready(function () {

        let isSubmitting = false;

        function showforgetDefault() {
            $('#forgetDefaultState').show();
            $('#forgetloaderState').hide();
            $('#forgetSuccessState').hide();
            $('#forgetErrorState').hide();
        }

        function showforgetLoader() {
            $('#forgetDefaultState').hide();
            $('#forgetloaderState').show();
            $('#forgetSuccessState').hide();
            $('#forgetErrorState').hide();
        }

        function showforgetSuccess() {
            $('#forgetDefaultState').hide();
            $('#forgetloaderState').hide();
            $('#forgetErrorState').hide();
            $('#forgetSuccessState').fadeIn(400);
        }

        function showforgetError(msg) {
            $('#forgetDefaultState').hide();
            $('#forgetloaderState').hide();
            $('#forgetSuccessState').hide();

            $('#forgetErrorState')
                .fadeIn(200)
                .find('.text-error')
                .html(msg);

            // ✅ auto hide after 1 second
            setTimeout(function () {
                $('#forgetErrorState').fadeOut(200, function () {
                    showforgetDefault(); // back to form
                });
            }, 1000);
        }

        const fieldLabels = {
            email: 'Email',
        };

        $('#forgotPasswordForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Email is required",
                    email: "Enter valid email"
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',

            invalidHandler: function (event, validator) {

                let firstError = validator.errorList[0];
                if (!firstError) return;

                let field = $(firstError.element);
                let name = field.attr('name');
                let label = fieldLabels[name] || name;

                showforgetLoader();

                setTimeout(() => {

                    showforgetError(label + ': ' + firstError.message);

                    $('html, body').animate({
                        scrollTop: field.offset().top - 120
                    }, 400);

                    field.focus();

                }, 1200);
            },


            submitHandler: function (form) {

                if (isSubmitting) return;
                isSubmitting = true;

                let $form = $(form);
                let $submitBtn = $('.submit-btn');
                let widgetId = captchaMap[$form.attr('id')];
                let captcha = grecaptcha.getResponse(widgetId);

                if (!captcha) {

                    showforgetLoader();

                    setTimeout(() => {
                        showforgetError('Please verify captcha');
                    }, 1200);

                    isSubmitting = false;
                    return false;

                }
                $submitBtn.prop('disabled', true).text('Sending...');
                showforgetLoader();
                // $('#showforgetLoader').show();

                let formData = $form.serializeArray();
                formData.push({
                    name: 'g-recaptcha-response',
                    value: captcha
                });

                $('#successmsg').html('');
                $(document).find('#email_error_email').text('');

                $.ajax({
                    url: "{{ route('password.email') }}",
                    type: 'POST',
                    data: formData,

                    success: function (res) {

                        isSubmitting = false;

                        setTimeout(function () {

                            showforgetSuccess(); // show success

                            // ✅ auto hide after 3 seconds
                            setTimeout(function () {
                                showforgetDefault(); // back to form
                            }, 3000);

                        }, 1500);

                        $submitBtn.prop('disabled', false).text('Send Reset Link');
                        // $('#successmsg').html('<div class="alert alert-success">'+res.message+'</div>')

                        // clear errors
                        $form.find('.error').text('');
                        $form[0].reset();

                        grecaptcha.reset(widgetId);

                        // show success UI
                        $('#successMessage').fadeIn();

                    },

                    error: function (xhr) {

                        isSubmitting = false;
                        $submitBtn.prop('disabled', false).text('Send Reset Link');
                        grecaptcha.reset(widgetId);

                        let msg = 'Something went wrong'; // ✅ define first

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            let field = Object.keys(xhr.responseJSON.errors)[0];
                            msg = xhr.responseJSON.errors[field][0];
                        } else if (xhr.responseJSON?.message) {
                            msg = xhr.responseJSON.message;
                        }

                        showforgetError(msg); // ✅ now works
                    }
                });
            }
        });

    });
</script>

@endpush
@endsection

