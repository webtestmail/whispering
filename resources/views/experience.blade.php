@section('title', $page->meta_title ?? 'Experiences | Whispering Pines')
@section('description', $page->meta_description ?? '')

@section('keywords', $page->meta_keyword ?? '')

@include('header')



@php

$why_come_here = $sections['why_come_here'] ?? null;

$listingIntro = $sections['listing_intro'] ?? null;

$expGallery = $sections['exp_gallery'] ?? null;

$expCta = $sections['exp_cta'] ?? null;

$field = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? $section->{$key} : $default;

$html = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? htmlspecialchars_decode($section->{$key}) : $default;

$heroImage = ($page && $page->page_image) ? asset($page->page_image) : asset('/imgs/banner.png');



$defaultGalleryItems = [

    ['src' => '/imgs/g-1.webp', 'caption' => 'Morning light through the pine forest', 'layout' => 'tall'],

    ['src' => '/imgs/g-2.webp', 'caption' => 'Trek to Kodia jungle', 'layout' => 'default'],

    ['src' => '/imgs/g-3.webp', 'caption' => 'Snowfall at Whispering Pines', 'layout' => 'default'],

    ['src' => '/imgs/g-5.webp', 'caption' => 'Bonfire evenings', 'layout' => 'wide'],

    ['src' => '/imgs/g-1.webp', 'caption' => 'Star gazing on the deck', 'layout' => 'tall-sm'],

    ['src' => '/imgs/g-2.webp', 'caption' => 'Adventure activities', 'layout' => 'default'],

    ['src' => '/imgs/g-3.webp', 'caption' => 'The forest in morning mist', 'layout' => 'default'],

];

$galleryItems = ($expGallery && $expGallery->pagesubsections->isNotEmpty())

    ? $expGallery->pagesubsections->map(fn($item) => [

        'src' => $item->section_image ? asset($item->section_image) : asset('/imgs/g-1.webp'),

        'caption' => $item->section_headline ?: '',

        'layout' => $item->section_subheading ?: 'default',

    ])

    : collect($defaultGalleryItems)->map(fn($item) => [

        'src' => asset($item['src']),

        'caption' => $item['caption'],

        'layout' => $item['layout'],

    ]);

@endphp



<section class="page-hero">

    <div class="page-hero__media">

        <img src="{{ $heroImage }}" alt="Experiences" class="page-hero__img">

        <div class="page-hero__overlay"></div>

    </div>

    <div class="page-hero__content">

        <div class="section__subtitle" data-animate="fade-up">

            <span class="text-white">{{ $page?->page_name ?? 'Experiences' }}</span>

        </div>

        <h1 class="page-hero__title" data-animate="split-title">

            {{ $page?->breadcrumb_headline_headline ?? 'Every Season Tells A Different Story' }}

        </h1>

        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">

            {!! $page ? htmlspecialchars_decode($page->breadcrumb_description ?? '') : '' !!}

        </p>

    </div>

</section>



@if($why_come_here)

<section class="exp-intro section_padding">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8 text-center">

                <div class="section__subtitle " data-animate="fade-up">

                    <span>{{ $why_come_here->section_title }}</span>

                    <div class="subtitle_line justify-content-center">

                        <div class="line"></div>

                        <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>

                        <div class="line"></div>

                    </div>

                </div>

                <h2 class="section__title" data-animate="split-title">

                    {{ $why_come_here->section_headline }}

                </h2>

                {!! htmlspecialchars_decode($why_come_here->description) !!}

            </div>

        </div>

    </div>

</section>

@endif



<section class="exp-listing section_padding pt-0">

    <div class="container">

        <div class="text-center mb-5">

            <div class="section__subtitle justify-content-center" data-animate="fade-up">

                <span>{{ $field($listingIntro, 'section_title', 'What Awaits You') }}</span>

                <div class="subtitle_line justify-content-center">

                    <div class="line"></div>

                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>

                    <div class="line"></div>

                </div>

            </div>

            <h2 class="section__title my-3" data-animate="split-title">{{ $field($listingIntro, 'section_headline', 'Explore All Experiences') }}</h2>

        </div>



        <div class="row g-4" data-stagger>

            @forelse($experiences as $item)

            <div class="col-lg-6">

                <a href="{{ route('experience.detail', $item->slug) }}" class="exp-card">

                    <div class="exp-card__media">

                        <img src="{{ $item->listing_image ? asset($item->listing_image) : asset('/imgs/a-1.webp') }}" alt="{{ $item->title }}" class="exp-card__img">

                        <div class="exp-card__overlay"></div>

                        @if($item->season_tag)

                        <span class="exp-card__season-tag exp-card__season-tag--{{ $item->season_style ?: 'all' }}">{{ $item->season_tag }}</span>

                        @endif

                    </div>

                    <div class="exp-card__content">

                        <div class="exp-card__meta">

                            @if($item->months)<span class="exp-card__month">{{ $item->months }}</span>@endif

                            @if($item->months && $item->temperature)<span class="exp-card__dot"></span>@endif

                            @if($item->temperature)<span class="exp-card__temp">{{ $item->temperature }}</span>@endif

                        </div>

                        <h3 class="exp-card__title">{{ $item->title }}</h3>

                        <p class="exp-card__desc">{!! htmlspecialchars_decode($item->listing_description) !!}</p>

                        @if(!empty($item->highlights))

                        <div class="exp-card__highlights">

                            @foreach($item->highlights as $highlight)

                            <span>{{ $highlight }}</span>

                            @endforeach

                        </div>

                        @endif

                        <div class="exp-card__link">

                            {{ $item->link_text ?: 'Explore' }}

                            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">

                                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>

                            </svg>

                        </div>

                    </div>

                </a>

            </div>

            @empty

            <div class="col-12 text-center"><p>No experiences available at the moment.</p></div>

            @endforelse

        </div>

    </div>

</section>



<section class="exp-gallery section_padding">

    <div class="container">

        <div class="text-center mb-5">

            <div class="section__subtitle justify-content-center" data-animate="fade-up">

                <span>{{ $field($expGallery, 'section_title', 'In The Moment') }}</span>

                <div class="subtitle_line justify-content-center">

                    <div class="line"></div>

                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>

                    <div class="line"></div>

                </div>

            </div>

            <h2 class="section__title my-3" data-animate="split-title">{{ $field($expGallery, 'section_headline', 'Captured By Our Guests') }}</h2>

            <p class="exp-gallery__sub" data-animate="fade-up" data-delay="0.1">

                {{ $field($expGallery, 'description', 'Real moments, real people, real Himalayas.') }}

            </p>

        </div>



        <div class="exp-gallery__grid" data-animate="fade-up" data-delay="0.1">

            @foreach($galleryItems as $item)

            @php

                $layoutClass = match($item['layout']) {

                    'tall' => 'exp-gallery__item--tall',

                    'wide' => 'exp-gallery__item--wide',

                    'tall-sm' => 'exp-gallery__item--tall-sm',

                    default => '',

                };

            @endphp

            <a href="{{ $item['src'] }}"

               data-fancybox="exp-gallery"

               data-caption="{{ $item['caption'] }}"

               class="exp-gallery__item {{ $layoutClass }}">

                <img src="{{ $item['src'] }}" alt="">

                <div class="exp-gallery__item-overlay">

                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">

                        <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5"/>

                        <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>

                    </svg>

                </div>

            </a>

            @endforeach

        </div>

    </div>

</section>



<section class="retreat-cta section_padding">

    <div class="container">

        <div class="retreat-cta__inner" data-animate="fade-up">

            <div class="retreat-cta__line"></div>

            <h2 class="retreat-cta__heading">{{ $field($expCta, 'section_headline', 'Which Season Calls To You?') }}</h2>

            <p class="retreat-cta__sub">

                {!! $html($expCta, 'description', 'Every visit is different. <br>Let us help you pick the perfect time to come.') !!}

            </p>

            <a href="{{ ($expCta && $expCta->button_link) ? $expCta->button_link : route('enquire') }}" class="header__button header__button--one mt-4">

                {{ $field($expCta, 'button_name', 'Plan Your Experience') }}

                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">

                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>

                </svg>

            </a>

        </div>

    </div>

</section>



@include('footer')

