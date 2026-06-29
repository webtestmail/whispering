@extends('layouts.MainLayouts')

@section('title', 'Enquire & Book | Whispering Pines')
@section('description', 'Send a booking enquiry to Whispering Pines Himalayan Retreat.')
@section('content')
<section class="page-hero">
    <div class="page-hero__media">
        <img src="/imgs/banner.png" alt="Book Whispering Pines" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">Plan Your Stay</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            Enquire &amp; Book <br> Your Escape
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            Share your travel dates and preferences — our team will respond within one working day.
        </p>
    </div>
</section>

<section class="contact-reach py-5">
    <div class="container">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center">
                <div class="section__subtitle" data-animate="fade-up">
                    <span>Booking Enquiry</span>
                </div>
                <h2 class="section__title" data-animate="fade-up">Tell Us About Your Visit</h2>
                <p class="section__desc" data-animate="fade-up">
                    No online payment required — submit your details and we'll confirm availability by email or phone.
                </p>
            </div>
        </div>

        <div class="row g-5 align-items-start justify-content-center">
            <div class="col-lg-8" data-animate="fade-up" data-delay="0">
                <div class="contact-form-wrap">
                    @include('partials.lead-form', ['formType' => 'booking'])
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-cta">
    <div class="contact-cta__bg">
        <img src="/imgs/banner.png" alt="Himalayan view" class="contact-cta__img">
        <div class="contact-cta__overlay"></div>
    </div>
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <p class="contact-cta__eyebrow">Prefer To Talk?</p>
                <h2 class="contact-cta__heading">Our Reservations Team Is Here To Help.</h2>
                <p class="contact-cta__sub">Call +91 70429 62780 or email sales@whisperingpines.in</p>
                <a href="{{ route('contact') }}" class="btn-primary-custom btn-primary-custom--light mt-4">
                    Contact Us
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
