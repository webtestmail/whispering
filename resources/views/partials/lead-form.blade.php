@php
    $formType = $formType ?? 'contact';
    $showCaptcha = ($formType === 'contact') && config('services.recaptcha.site_key');
@endphp
<div class="contact-form" id="contactForm" data-lead-form data-form-type="{{ $formType }}">

    <div class="row g-3">
        <div class="col-sm-6">
            <div class="contact-form__field">
                <label class="contact-form__label" for="cf-name">Full Name</label>
                <input type="text" id="cf-name" name="name" class="contact-form__input" placeholder="Your name" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="contact-form__field">
                <label class="contact-form__label" for="cf-email">Email Address</label>
                <input type="email" id="cf-email" name="email" class="contact-form__input" placeholder="you@example.com" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="contact-form__field">
                <label class="contact-form__label" for="cf-phone">Phone Number</label>
                <input type="tel" id="cf-phone" name="phone" class="contact-form__input" placeholder="+91 00000 00000">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="contact-form__field">
                <label class="contact-form__label" for="cf-guests">No. of Guests</label>
                <select id="cf-guests" name="guests" class="contact-form__input contact-form__select">
                    <option value="" disabled selected>Select</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3–4</option>
                    <option>5+</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="contact-form__field">
                <label class="contact-form__label" for="cf-checkin">Check-in Date</label>
                <input type="date" id="cf-checkin" name="checkin" class="contact-form__input">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="contact-form__field">
                <label class="contact-form__label" for="cf-checkout">Check-out Date</label>
                <input type="date" id="cf-checkout" name="checkout" class="contact-form__input">
            </div>
        </div>
        <div class="col-12">
            <div class="contact-form__field">
                <label class="contact-form__label" for="cf-message">Your Message</label>
                <textarea id="cf-message" name="message" class="contact-form__input contact-form__textarea" rows="5" placeholder="Tell us about your stay, special requests, or any questions…"></textarea>
            </div>
        </div>
        @if($showCaptcha)
        <div class="col-12">
            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
        </div>
        @endif
        <div class="col-12">
            <button type="button" class="btn-primary-custom w-100" data-lead-submit>
                {{ $formType === 'booking' ? 'Send Enquiry' : 'Send Message' }}
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
            <div class="contact-form__success" data-lead-success style="display:none;">
                ✓ Your message has been sent. We'll be in touch soon.
            </div>
            <div class="contact-form__error text-danger mt-2" data-lead-error style="display:none;"></div>
        </div>
    </div>

</div>
