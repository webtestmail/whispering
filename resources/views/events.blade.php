@section('title', $page->meta_title ?? 'Events & Groups | Whispering Pines')
@section('description', $page->meta_description ?? '')
@section('keywords', $page->meta_keyword ?? '')

@include('header')

@php
$listingIntro = $sections['listing_intro'] ?? null;
$field = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? $section->{$key} : $default;
$html = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? htmlspecialchars_decode($section->{$key}) : $default;
$heroImage = ($page && $page->page_image) ? asset($page->page_image) : asset('/imgs/banner.png');
@endphp

<section class="page-hero">
    <div class="page-hero__media">
        <img src="{{ $heroImage }}" alt="Events & Groups" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">{{ $field($page, 'header_footer_name', 'Events & Groups') }}</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            {!! $field($page, 'breadcrumb_headline', 'Crafted For Those Seeking <br> Silence Beyond The Mountains') !!}
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            {{ $field($page, 'breadcrumb_description', 'A retreat born from the timeless beauty of the Himalayas.') }}
        </p>
    </div>
</section>

<section class="events_listing section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle">
                <span>{{ $field($listingIntro, 'section_title', 'Events & Groups') }}</span>
            </div>
            <h2 class="section__title">
                {{ $field($listingIntro, 'section_headline', 'Curated Experiences For Every Group') }}
            </h2>
            <p class="events_intro">
                {{ $html($listingIntro, 'description', 'Whether you\'re planning a corporate retreat, school camp, family celebration or wellness gathering, Whispering Pines offers the perfect mountain setting for memorable experiences.') }}
            </p>
        </div>

        <div class="row g-4">
            @forelse($events as $eventItem)
            <div class="col-lg-4 col-md-6">
                <div class="event_card">
                    <div class="event_card_img">
                        @if($eventItem->listing_image)
                        <img src="{{ asset($eventItem->listing_image) }}" alt="{{ $eventItem->title }}">
                        @else
                        <img src="{{ asset('/imgs/banner.png') }}" alt="{{ $eventItem->title }}">
                        @endif
                    </div>
                    <div class="event_card_content">
                        <h4>{{ $eventItem->title }}</h4>
                        <p>{!! htmlspecialchars_decode($eventItem->listing_description ?? '') !!}</p>
                        <a href="{{ route('event.detail', $eventItem->slug) }}" class="event_link">
                            {{ $eventItem->link_text ?: 'Explore More' }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No events available at the moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@include('footer')
