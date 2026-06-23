@extends('layouts.MainLayouts')
@section('title', 'Reset Password')
@section('robots', 'noindex, nofollow')
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
                            <form id="loginChangeForm">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="hidden" name="fld_id" value="<?=$user['id']?>">
                                    <div class="input-wrapper">
                                        <input type="password" id="password" name="password" placeholder="New password">
                                    </div>
                                    <span class="text-danger" id="password_error"></span>
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="input-wrapper">
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            placeholder="Confirm Password">
                                    </div>
                                    <span class="text-danger" id="confirm_password_error"></span>
                                </div>
                                <hr
                                    style="background: linear-gradient(90deg, rgba(138, 140, 228, 0) 0%, rgba(138, 140, 228, 0.5) 50%, rgba(138, 140, 228, 0) 100%); margin:1.5rem 0">
                                <div class="button-row mt-4">
                                    <div class="captcha-wrapper mt-3">
                                        <div class="g-recaptcha"
                                            data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                        </div>

                                        <span class="captcha-error text-danger"></span>
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
                                        </svg> Login</button>
                                </div>
                                <img id="loadingImage" src="{{ asset('images/new_svg.svg') }}"
                                    style="display:none; width:80px; margin-top:10px;" />
                            </form>
                            <div id="successMessage" style="display:none; text-align:center; margin-top:40px;">

                                <img src="{{ asset('images/image_newsletter.png') }}" alt="Success" width="80"
                                    style="margin-bottom:15px;">

                                <h3 class="text-white">Redirecting...</h3>
                                <!--<p class="text-white">redirecting...</p>-->

                            </div>
                            <div class="bottom-bar">
                                <div class="d-flex align-items-center gap-2">
                                    <svg class="svg-icon">
                                        <use href="{{ asset('images/icons/icons-sprite.svg') }}#icon-lock"></use>
                                    </svg><a href="{{ route('password.request') }}">Forgot your password?</a>
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
    $(document).ready(function () {
        // DEBUG: Check if jQuery is working
        // console.log("jQuery is loaded and ready.");
        let isSubmitting = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#loginChangeForm').validate({
        //     rules: {
        //         email: {
        //             required: true,
        //             email: true
        //         },
        //         password: {
        //             required: true,
        //             minlength: 6
        //         },
        //         password_confirmation: {
        //             required: true,
        //             equalTo: "#password"
        //         }
        //     },
        //     messages: {
        //         email: {
        //             required: "Email is required.",
        //             email: "Enter valid email"
        //         },
        //         password: {
        //             required: "Password is required.",
        //             minlength: "Minimum 6 characters required"
        //         },
        //         password_confirmation: {
        //             required: "Confirm password is required.",
        //             equalTo: "Passwords do not match"
        //         }
        //     },

        //     errorElement: 'span',
        //     errorClass: 'text-danger',

        //     errorPlacement: function (error, element) {
        //         let name = element.attr("name");
        //         $("#" + name + "_error").html(error);
        //     },

        //     highlight: function (element) {
        //         $(element).addClass('is-invalid');
        //     },

        //     unhighlight: function (element) {
        //         $(element).removeClass('is-invalid');
        //     },

        //     submitHandler: function (form) {

        //         if (isSubmitting) return;
        //         isSubmitting = true;

        //         let $form = $(form);
        //         let $submitBtn = $('.submit-btn');

        //         $('.text-danger').text('');
        //         $('#successMessage').hide();

        //         let captchaResponse = grecaptcha.getResponse();

        //         if (!captchaResponse) {
        //             $('#captcha_error').text('Please verify that you are not a robot.');
        //             isSubmitting = false;
        //             return;
        //         }

        //         $submitBtn.prop('disabled', true).text('Processing...');
        //         $('#loadingImage').show();

        //         let formData = $form.serializeArray();
        //         formData.push({
        //             name: 'g-recaptcha-response',
        //             value: captchaResponse
        //         });

        //         $.ajax({
        //             url: "{{ route('password.passwordchange') }}",
        //             type: "POST",
        //             data: formData,

        //             success: function (res) {

        //                 isSubmitting = false;

        //                 $('#loadingImage').hide();
        //                 $submitBtn.prop('disabled', false).text('Change Password');

        //                 $form[0].reset();
        //                 grecaptcha.reset();

        //                 $('#successMessage').fadeIn();
        //             },

        //             error: function (xhr) {

        //                 isSubmitting = false;

        //                 $('#loadingImage').hide();
        //                 $submitBtn.prop('disabled', false).text('Change Password');

        //                 grecaptcha.reset();

        //                 $('.text-danger').text('');

        //                 if (xhr.status === 422) {

        //                     let errors = xhr.responseJSON.errors;

        //                     $.each(errors, function (field, msg) {

        //                         if (field === 'captcha' || field === 'g-recaptcha-response') {
        //                             $('#captcha_error').text(msg[0]);
        //                         } else {
        //                             $('#' + field + '_error').text(msg[0]);
        //                         }

        //                     });

        //                 } else {
        //                     alert('Something went wrong');
        //                 }
        //             }
        //         });
        //     }
        // });

        // --- Form Validation ---
        $('#loginChangeForm').validate({
            // alert() was here - it MUST be removed
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    required: "Email is required.",
                    email: "Enter valid email"
                },
                password: {
                    required: "Password is required.",
                    minlength: "Minimum 6 characters required"
                },
                password_confirmation: {
                    required: "Confirm password is required.",
                    equalTo: "Passwords do not match"
                }
            },

            errorElement: 'span',
            errorClass: 'text-danger',

            errorPlacement: function (error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").html(error);
            },

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                // console.log("Form is valid! Proceeding with AJAX...");
                if (isSubmitting) return;
                isSubmitting = true;

                let $form = $(form);
                let $submitBtn = $('.submit-btn');
                let captchaBox = $form.find('.g-recaptcha');
                let captchaError = $form.find('.captcha-error');

                captchaError.text('');

                // âœ… get widget id
                let widgetId = captchaBox.attr('data-widget-id');

                if (typeof widgetId === 'undefined') {
                    captchaError.text('Captcha not loaded. Please refresh.');
                    isSubmitting = false;
                    return;
                }

                // âœ… ALWAYS get fresh token (just before submit)
                let captchaResponse = grecaptcha.getResponse(widgetId);

                if (!captchaResponse) {
                    captchaError.text('Please verify that you are not a robot.');
                    isSubmitting = false;
                    return;
                }

                $submitBtn.prop('disabled', true).text('Logging in...');
                $('#loadingImage').show();
                let formData = $form.serializeArray();
                formData.push({
                    name: 'g-recaptcha-response',
                    value: captchaResponse
                });
                $.ajax({
                    url: "{{ route('password.passwordchange') }}",
                    method: 'POST',
                    data: $.param(formData),
                    dataType: 'json',
                    success: function (response) {
                        isSubmitting = false;
                        if (response.success) {
                            $('#loadingImage').hide();
                            $('#successMessage').fadeIn();
                            $form[0].reset();
                            // Wait a moment so they can see the message before redirecting
                            // setTimeout(function() {
                            //       grecaptcha.reset(widgetId); 
                            //     window.location.href = response.redirect || '/my-dashboard';
                            // }, 1000);
                        } else {
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.error(response.message || 'Login failed.');
                            grecaptcha.reset(widgetId);
                        }
                    },
                    error: function (xhr) {
                        isSubmitting = false;
                        $submitBtn.prop('disabled', false).html('Login');
                        alertify.set('notifier', 'position', 'top-right');
                        grecaptcha.reset(widgetId);
                        let errorMsg = 'Login failed.';

                        if (xhr.status === 422) {
                            // Grab the first validation error message from Laravel
                            const errors = xhr.responseJSON.errors;
                            errorMsg = Object.values(errors)[0][0];
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        $('#loadingImage').hide();
                        alertify.error(errorMsg);
                    }
                });
                return false;
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const toggleBtn = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("passwordField");
        const iconUse = toggleBtn.querySelector("use");

        toggleBtn.addEventListener("click", function () {

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                iconUse.setAttribute("href", "images/icons/icons-sprite.svg#icon-eye-slash");
            } else {
                passwordInput.type = "password";
                iconUse.setAttribute("href", "images/icons/icons-sprite.svg#icon-eye");
            }

        });

    });
</script>
@endpush
@endsection

