    @section('title', $page->meta_title ?? '')
    @section('description', $page->meta_description ?? '')
    @section('keywords', $page->meta_keyword ?? '')

@extends('layouts.MainLayouts')
@section('content')
@php
  
    $getSection = fn(string $key) => $sections[$key] ?? null;
    $field = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? $section->{$key} : $default;
    $html = fn($section, string $key, string $default) => ($section && filled($section->{$key})) ? htmlspecialchars_decode($section->{$key}) : $default;
    $moreImages = fn($section) => ($section && !empty($section->more_images)) ? (json_decode($section->more_images, true) ?? []) : [];

    $brandStory = $getSection('brand_story');
    $founder = $getSection('founder');
    $journey = $getSection('journey');
    $difference = $getSection('difference');
    $cinematicVideo = $getSection('cinematic_video');
    $storyGallery = $getSection('story_gallery');
    $values = $getSection('values');
    $retreatCta = $getSection('retreat_cta');

    $brandStoryImages = $moreImages($brandStory);
    $galleryImages = $moreImages($storyGallery);

    $defaultJourneySteps = [
        ['title' => 'Arrive', 'desc' => 'Pine-scented air greets you as you wind up the mountain road.'],
        ['title' => 'Settle In', 'desc' => 'Your cottage, warm and unhurried, invites you to simply breathe.'],
        ['title' => 'Explore', 'desc' => 'Trek forest trails, stargaze at midnight, feel the Himalayan pulse.'],
        ['title' => 'Reconnect', 'desc' => 'Shared meals, bonfire evenings, stories under a canopy of stars.'],
        ['title' => 'Depart Renewed', 'desc' => 'You leave lighter. The mountains keep a part of you.'],
    ];

    $defaultDifferenceItems = [
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/290/290208.png', 'title' => 'Mountain Serenity', 'desc' => '7,500 feet of undisturbed Himalayan quiet, away from tourist crowds.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/256/181/181297.png', 'title' => 'Thoughtful Hospitality', 'desc' => 'Every detail considered — from fire-warmed rooms to hand-picked menus.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/3504/3504016.png', 'title' => 'Curated Experiences', 'desc' => 'Star gazing, forest trails, adventure — nothing generic, everything intentional.'],
        ['icon' => 'https://static.thenounproject.com/png/2720580-200.png', 'title' => 'Sustainable Living', 'desc' => 'Built with the forest, not against it. Low impact, high awareness.'],
    ];

    $defaultGalleryImages = ['/imgs/g-1.webp', '/imgs/g-2.webp', '/imgs/g-3.webp', '/imgs/g-4.webp', '/imgs/g-5.webp', '/imgs/g-2.webp', '/imgs/g-3.webp', '/imgs/g-4.webp', '/imgs/g-5.webp'];

    $defaultValueItems = [
        ['icon' => '/imgs/c1.png', 'title' => 'Authenticity', 'desc' => 'Real experiences, real people, real Himalayas.'],
        ['icon' => '/imgs/c2.png', 'title' => 'Nature', 'desc' => 'Every design decision respects the forest first.'],
        ['icon' => '/imgs/c3.png', 'title' => 'Comfort', 'desc' => 'Warmth without excess. Simple, considered, complete.'],
        ['icon' => '/imgs/c4.png', 'title' => 'Connection', 'desc' => 'With nature, with each other, with yourself.'],
    ];
@endphp
@if($page->page_image)
<section class="page-hero">
    <div class="page-hero__media">
        <img src="{{ asset($page->page_image) }}" alt="The Retreat" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">{{ $page->breadcrumb_headline ?? '' }}</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            {!! html_entity_decode($page->breadcrumb_description) ?? '' !!}
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            {!! html_entity_decode($page->description) ?? '' !!}
        </p>
    </div>
</section>
@endif

<section class="brand-story section_padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-animate="fade-right">
                <div class="brand-story__images">
                    <div class="brand-story__img-main">
                        <img src="{{ ($brandStory && $brandStory->section_image) ? asset($brandStory->section_image) : asset('/imgs/ab-1.webp') }}" alt="Whispering Pines Story">
                    </div>
                    <div class="brand-story__img-accent">
                        <img src="{{ !empty($brandStoryImages[0]) ? asset($brandStoryImages[0]) : asset('/imgs/about-img-1.png') }}" alt="The forest">
                    </div>
                    <div class="brand-story__year-tag">
                        <span>Est.</span>
                        <strong>{{ $field($brandStory, 'section_subheading', '2015') }}</strong>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5">

                <div class="section__subtitle" data-animate="fade-up">
                    <span>{{ $field($brandStory, 'section_title', '') }}</span>
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

                <h2 class="section__title my-3" data-animate="split-title">
                    {!! $html($brandStory, 'section_headline', '') !!}
                </h2>

                <div class="brand-story__text" data-animate="fade-up" data-delay="0.1">
                    {!! $html($brandStory, 'description', '') !!}
                </div>

                <!-- pull quote -->
                <blockquote class="brand-story__quote" data-animate="fade-up" data-delay="0.3">
                     {!! $html($brandStory, 'section_subtitle', '') !!}
                </blockquote>
            </div>

        </div>
    </div>
</section>


<section class="founder section_padding bgOverlaySection">
    <div class="container">
        <div class="founder__inner" data-animate="fade-up">
            <div class="founder__img-wrap">
                <img src="{{ ($founder && $founder->section_image) ? asset($founder->section_image) : 'https://img.magnific.com/premium-vector/default-avatar-profile-icon-social-media-user-image-gray-avatar-icon-blank-profile-silhouette-vector-illustration_561158-3396.jpg?semt=ais_hybrid&w=740&q=80' }}"
                    alt="{{ $field($founder, 'section_headline', 'Founder') }}" class="founder__img">
                <div class="founder__img-ring"></div>
            </div>
            <p class="founder__philosophy">
                {!! $html($founder, 'description', '') !!}
            </p>
            <div class="founder__divider"></div>
            <span class="founder__name">{{ $field($founder, 'section_title', '') }}</span>
            <span class="founder__title">{{ $field($founder, 'section_headline', '') }}</span>
        </div>
    </div>
</section>

<section class="journey section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($journey, 'section_title', 'The Journey') }}</span>
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
            <h2 class="section__title" data-animate="split-title">{{ $field($journey, 'section_headline', 'Your Experience Unfolds') }}</h2>
        </div>

        <div class="journey__timeline" data-stagger>
            @if($journey && $journey->pagesubsections->count() > 0)
                @foreach($journey->pagesubsections as $step)
                <div class="journey__step">
                    <div class="journey__step-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="journey__step-line"></div>
                    <div class="journey__step-content">
                        <h4 class="journey__step-title">{{ $step->section_headline }}</h4>
                        <p>{!! htmlspecialchars_decode($step->description) !!}</p>
                    </div>
                </div>
                @endforeach
            @else
             
            @endif
        </div>
    </div>
</section>


<section class="difference section_padding">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-4">
                <div class="section__subtitle" data-animate="fade-up">
                    <span>{{ $field($difference, 'section_title', 'Why Us') }}</span>
                    <div class="subtitle_line">
                        <div class="line"></div>
                        <div class="line_icon">
                            <div class="line_icon">
                                <svg width="5" height="8" viewBox="0 0 5 8" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.8262 4.96751C4.53119 4.90658 4.15096 4.78628 3.76089 4.55193C4.0854 4.50819 4.37713 4.34102 4.59894 4.16916C4.74972 4.05355 4.70929 3.73015 4.53993 3.69577C4.26678 3.63953 3.91058 3.52548 3.54892 3.29582C3.83082 3.26301 4.08431 3.11771 4.27661 2.97085C4.40445 2.87243 4.37058 2.59902 4.22744 2.56933C3.97067 2.51621 3.62759 2.40216 3.28778 2.16313C3.54127 2.15219 3.77072 2.02408 3.94117 1.89441C4.04497 1.81473 4.01766 1.59288 3.90075 1.56944C3.68659 1.52413 3.39814 1.42883 3.11406 1.2226C3.31619 1.21635 3.49975 1.1148 3.63415 1.01013C3.68113 0.974192 3.69861 0.891388 3.67348 0.824208C3.65928 0.785149 3.63305 0.760152 3.60246 0.753903C3.32493 0.696097 2.88679 0.528927 2.57102 0.0430416C2.53496 -0.01164 2.47378 -0.0147646 2.43553 0.0367923C2.43444 0.0383546 2.43226 0.0414793 2.43116 0.0430416C2.1143 0.527365 1.67725 0.696097 1.39973 0.753903C1.34728 0.764839 1.31122 0.833582 1.31887 0.908574C1.32324 0.952319 1.34182 0.989815 1.36804 1.01013C1.50352 1.1148 1.68599 1.21635 1.88813 1.2226C1.60405 1.42883 1.31559 1.52413 1.10144 1.56944C1.03479 1.58194 0.988898 1.67099 0.997639 1.76629C1.0031 1.82098 1.02605 1.86941 1.06101 1.89597C1.23037 2.02564 1.45982 2.15375 1.7144 2.16469C1.3735 2.40373 1.03042 2.51778 0.774743 2.5709C0.631609 2.60058 0.597738 2.87399 0.724482 2.97241C0.916784 3.11927 1.17027 3.26457 1.45217 3.29738C1.09051 3.52548 0.734316 3.63953 0.461159 3.69734C0.291802 3.73327 0.251375 4.05511 0.402158 4.17072C0.623961 4.34102 0.914599 4.50819 1.23911 4.55193C0.849042 4.78628 0.468808 4.90658 0.173799 4.96751C-0.0195962 5.00813 -0.0654865 5.37528 0.107148 5.50808C0.66548 5.93772 1.61169 6.35018 2.5 5.26436C3.3894 6.35018 4.33452 5.93772 4.89285 5.50808C5.06549 5.37684 5.0196 5.00813 4.8262 4.96751Z"
                                        fill="#C47B2A" />
                                    <path
                                        d="M3.91386 7.5313H2.94907L2.8704 5.77524C2.73928 5.67681 2.61473 5.5612 2.5 5.4284C2.38527 5.5612 2.26072 5.67837 2.1296 5.77524L2.05093 7.5313H1.08614C0.995454 7.5313 0.922248 7.63598 0.922248 7.76565C0.922248 7.89532 0.995454 8 1.08614 8H3.91277C4.00345 8 4.07666 7.89532 4.07666 7.76565C4.07666 7.63598 4.00345 7.5313 3.91386 7.5313Z"
                                        fill="#C47B2A" />
                                </svg>
                            </div>
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
                <h2 class="section__title my-3" data-animate="split-title">
                    {{ $field($difference, 'section_headline', 'What Sets Whispering Pines Apart') }}
                </h2>
                <p class="mt-3" data-animate="fade-up" data-delay="0.1">
                    {!! $html($difference, 'description', '') !!}
                </p>
            </div>

            <div class="col-lg-8">
                <div class="row g-4" data-stagger>
                    @if($difference && $difference->pagesubsections->count() > 0)
                        @foreach($difference->pagesubsections as $item)
                        <div class="col-sm-6">
                            <div class="difference__item">
                                <div class="difference__icon">
                                    <img src="{{ $item->section_image ? asset($item->section_image) : ($defaultDifferenceItems[$loop->index]['icon'] ?? '') }}" alt="">
                                </div>
                                <h4 class="difference__title">{{ $item->section_headline }}</h4>
                                <p class="difference__desc">{!! htmlspecialchars_decode($item->description) !!}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach($defaultDifferenceItems as $item)
                      
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>


@php
    $videoSrc = ($cinematicVideo && $cinematicVideo->video_link)
        ? $cinematicVideo->video_link . (str_contains($cinematicVideo->video_link, '?') ? '&' : '?') . 'autoplay=1&rel=0'
        : 'https://www.youtube.com/embed/YOUR_ID?autoplay=1&rel=0';
@endphp
<section class="cinematic-video section_padding">
    <div class="container">
        <div class="cinematic-video__card" data-bs-toggle="modal" data-bs-target="#videoModal"
            data-video-src="{{ $videoSrc }}" data-animate="scale-up">
            <img src="{{ ($cinematicVideo && $cinematicVideo->section_image) ? asset($cinematicVideo->section_image) : asset('/imgs/banner.png') }}" alt="{{ $field($cinematicVideo, 'section_headline', 'Experience Whispering Pines') }}" class="cinematic-video__img">
            <div class="cinematic-video__overlay"></div>
            <div class="cinematic-video__content">
                <button class="cinematic-video__play">
                    <svg width="22" height="26" viewBox="0 0 22 26" fill="none">
                        <path d="M2 2L20 13L2 24V2Z" fill="white" stroke="white" stroke-width="1.5"
                            stroke-linejoin="round" />
                    </svg>
                </button>
                <h3 class="cinematic-video__heading">{{ $field($cinematicVideo, 'section_title', 'Experience Whispering Pines') }}</h3>
                <span class="cinematic-video__label">{{ $field($cinematicVideo, 'section_headline', 'Watch the film') }}</span>
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


<section class="story-gallery section_padding bgOverlaySection">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($storyGallery, 'section_title', 'In Frame') }}</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon">
                        <!-- SVG -->
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title text-white my-3" data-animate="split-title">{{ $field($storyGallery, 'section_headline', 'Moments From The Mountains') }}</h2>
        </div>

        <div class="story-gallery__grid mt-4" data-animate="fade-up" data-delay="0.1">
            @if(count($galleryImages) > 0)
                @foreach($galleryImages as $image)
                <div class="story-gallery__item">
                    <img src="{{ asset($image) }}" alt="">
                </div>
                @endforeach
            @else
                @foreach($defaultGalleryImages as $image)
                <div class="story-gallery__item">
                    <img src="{{ asset($image) }}" alt="">
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- 
<section class="reflection section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>Testimonials</span>
                <div class="subtitle_line">
                    <div class="line"></div>
                    <div class="line_icon">
                        
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title" data-animate="split-title">Voices From The Valley</h2>
        </div>

        <div class="swiper reflection-swiper" data-animate="fade-up" data-delay="0.1">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="reflection__slide">
                        <span class="reflection__mark">"</span>
                        <p class="reflection__quote">
                            The cottage was beyond our expectations. Waking up to snow-capped peaks
                            every morning was surreal. We will return every single year.
                        </p>
                        <div class="reflection__author">
                            <img src="/imgs/guest-1.jpg" alt="Rohit Mehra" class="reflection__avatar">
                            <div>
                                <span class="reflection__name">Rohit Mehra</span>
                                <span class="reflection__location">Mumbai</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="reflection__slide">
                        <span class="reflection__mark">"</span>
                        <p class="reflection__quote">
                            Peaceful, pristine, and perfectly curated. Whispering Pines
                            restored something in us that city life had quietly taken away.
                        </p>
                        <div class="reflection__author">
                            <img src="/imgs/guest-2.jpg" alt="Priya Sharma" class="reflection__avatar">
                            <div>
                                <span class="reflection__name">Priya Sharma</span>
                                <span class="reflection__location">Bangalore</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reflection__nav">
                <button class="reflection__btn reflection__btn--prev">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
                <button class="reflection__btn reflection__btn--next">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 3L11 8L6 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
 -->

<!-- ════════════════════════════════
     9. CORE VALUES
════════════════════════════════ -->
<section class="values section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($values, 'section_title', 'What We Stand For') }}</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon">
                        <!-- SVG -->
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title" data-animate="split-title">{{ $field($values, 'section_headline', 'Our Four Convictions') }}</h2>
        </div>

        <div class="row g-4 justify-content-center" data-stagger>
            @if($values && $values->pagesubsections->count() > 0)
                @foreach($values->pagesubsections as $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="values__item">
                        <div class="values__icon">
                            <img src="{{ $item->section_image ? asset($item->section_image) : asset($defaultValueItems[$loop->index]['icon'] ?? '/imgs/c1.png') }}" alt="">
                        </div>
                        <h4 class="values__title">{{ $item->section_headline }}</h4>
                        <p class="values__desc">{!! htmlspecialchars_decode($item->description) !!}</p>
                    </div>
                </div>
                @endforeach
            @else
                @foreach($defaultValueItems as $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="values__item">
                        <div class="values__icon">
                            <img src="{{ asset($item['icon']) }}" alt="">
                        </div>
                        <h4 class="values__title">{{ $item['title'] }}</h4>
                        <p class="values__desc">{{ $item['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


<!-- ════════════════════════════════
     10. FINAL CTA
════════════════════════════════ -->
<section class="retreat-cta section_padding">
    <div class="container">
        <div class="retreat-cta__inner" data-animate="fade-up">
            <div class="retreat-cta__line"></div>
            <h2 class="retreat-cta__heading">{{ $field($retreatCta, 'section_headline', 'Your Himalayan Story Awaits') }}</h2>
            <p class="retreat-cta__sub">
                {!! $html($retreatCta, 'description', 'Every season brings a different silence. <br>
                When will yours begin?') !!}
            </p>
            <a href="{{ ($retreatCta && $retreatCta->button_link) ? $retreatCta->button_link : route('enquire') }}" class="header__button header__button--one mt-4">
                {{ $field($retreatCta, 'button_name', 'Plan Your Escape') }}
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>


<!-- VIDEO MODAL (shared) -->
<!-- your existing #videoModal markup -->


@endsection

<script>
    const videoModal = document.getElementById('videoModal');
    const videoIframe = document.getElementById('testimonialIframe');

    if (videoModal && videoIframe) {
        videoModal.addEventListener('show.bs.modal', (e) => {
            const trigger = e.relatedTarget;
            const src = trigger?.dataset?.videoSrc || '';
            videoIframe.src = src;
        });

        videoModal.addEventListener('hide.bs.modal', () => {
            videoIframe.src = '';
        });
    }
</script>