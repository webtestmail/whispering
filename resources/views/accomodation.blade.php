@section('title', $page->meta_title ?? 'Accommodation | Whispering Pines')
@section('description', $page->meta_description ?? '')
@section('keywords', $page->meta_keyword ?? '')

@extends('layouts.MainLayouts')
@section('content')
@php
    $listingIntro = $sections['listing_intro'] ?? null;
    $field = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? $section->{$key} : $default;
    $html = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? htmlspecialchars_decode($section->{$key}) : $default;
    $pageHtml = fn(string $key, string $default) => ($page && filled($page->{$key})) ? htmlspecialchars_decode($page->{$key}) : $default;
    $heroImage = ($page && $page->page_image) ? asset($page->page_image) : asset('/imgs/banner.png');
@endphp

<section class="page-hero">
    <div class="page-hero__media">
        <img src="{{ $heroImage }}" alt="Accommodation" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">{{ ($page && $page->breadcrumb_headline) ? $page->breadcrumb_headline : 'Accomodation' }}</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">{!! $pageHtml('breadcrumb_description', 'Crafted For Those Seeking <br> Silence Beyond The Mountains') !!}</h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">{!! $pageHtml('description', 'A retreat born from the timeless beauty of the Himalayas.') !!}</p>
    </div>
</section>

<section class="accom section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($listingIntro, 'section_title', 'Where You\'ll Stay') }}</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title mb-3" data-animate="split-title">{{ $field($listingIntro, 'section_headline', 'Choose Your Retreat') }}</h2>
            <p class="accom__intro" data-animate="fade-up" data-delay="0.1">{!! $html($listingIntro, 'description', 'Whether you\'re chasing the angels or fleeing from demons, come to the mountains. You would agree with us that there can\'t be a greater bliss than to wake up to fresh peaks, dew drops on the leaves in the lush green fields? And then add a touch of rosy sunset, with the nights spent around a cozy bonfire!') !!}</p>
        </div>

        @forelse($accommodations as $item)
        <div class="accom-item{{ $item->reverse_layout ? ' accom-item--reverse' : '' }}" data-animate="fade-up">
            <div class="row align-items-center g-0{{ $item->reverse_layout ? ' flex-lg-row-reverse' : '' }}">
                <div class="col-lg-5">
                    <div class="accom-item__media{{ $item->reverse_layout ? '' : '' }}">
                        <img src="{{ $item->listing_image ? asset($item->listing_image) : asset('/imgs/a-1.webp') }}" alt="{{ $item->title }}" class="accom-item__img">
                        @if($item->badge)<div class="accom-item__badge">{{ $item->badge }}</div>@endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accom-item__content">
                        @if($item->tag)<span class="accom-item__tag">{{ $item->tag }}</span>@endif
                        <h3 class="accom-item__title">{{ $item->title }}</h3>
                        <div class="accom-item__divider"></div>
                        <p class="accom-item__desc">{!! htmlspecialchars_decode($item->listing_description) !!}</p>
                        @if(!empty($item->amenities))
                        <div class="accom-item__amenities">
                            @foreach($item->amenities as $amenity)
                            <div class="accom-item__amenity"><span>{{ $amenity['label'] ?? '' }}</span></div>
                            @endforeach
                        </div>
                        @endif
                        <div class="accom-item__footer">
                            @if($item->share_basis)<div class="accom-item__basis"><span>{{ $item->share_basis }}</span></div>@endif
                            <a href="{{ route('accommodation.detail', $item->slug) }}" class="header__button header__button--one">
                                Explore & Book
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none"><path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">No accommodations available at the moment.</p>
        @endforelse
    </div>
</section>
@endsection
