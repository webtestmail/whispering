@section('title', $event->meta_title ?? ($event->title . ' | Whispering Pines'))
@section('description', $event->meta_description ?? '')
@section('keywords', $event->meta_keyword ?? '')

@include('header')

@php
$intro = $sections['event_intro'] ?? null;
$stats = $sections['event_stats'] ?? null;
$highlights = $sections['event_highlights'] ?? null;
$experiences = $sections['event_experiences'] ?? null;
$cta = $sections['event_cta'] ?? null;
$decode = fn($section, string $field) => $section && filled($section->{$field}) ? htmlspecialchars_decode($section->{$field}) : '';
$heroImage = $event->hero_image ? asset($event->hero_image) : asset('/imgs/banner.png');
$introImage = ($intro && $intro->section_image) ? asset($intro->section_image) : ($event->listing_image ? asset($event->listing_image) : asset('/imgs/banner.png'));
@endphp

<section class="page-hero">
    <div class="page-hero__media">
        <img src="{{ $heroImage }}" alt="{{ $event->title }}" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">{{ $event->hero_subtitle ?: 'Events & Groups' }}</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            {{ $event->title }}
        </h1>
        @if($event->hero_description)
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            {!! $decode($event, 'hero_description') !!}
        </p>
        @endif
    </div>
</section>

@if($intro)
<section class="event_intro section_padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="event_intro_img">
                    <img src="{{ $introImage }}" alt="{{ $event->title }}">
                </div>
            </div>
            <div class="col-lg-6">
                @if($intro->section_subtitle)
                <div class="section__subtitle">
                    <span>{{ $intro->section_subtitle }}</span>
                </div>
                @endif
                @if($intro->section_headline)
                <h2 class="section__title">{{ $intro->section_headline }}</h2>
                @endif
                @foreach(($intro->subsections ?? collect()) as $paragraph)
                <p>{!! $decode($paragraph, 'description') !!}</p>
                @endforeach
                @if($stats && ($stats->subsections ?? collect())->isNotEmpty())
                <div class="event_stats">
                    @foreach($stats->subsections as $stat)
                    <div class="event_stat">
                        <strong>{{ $stat->section_headline }}</strong>
                        <span>{{ $stat->section_subheading }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@if($highlights && (($highlights->subsections ?? collect())->isNotEmpty() || $highlights->section_headline))
<section class="event_highlights section_padding">
    <div class="container">
        <div class="text-center mb-5">
            @if($highlights->section_subtitle)
            <div class="section__subtitle">
                <span>{{ $highlights->section_subtitle }}</span>
            </div>
            @endif
            @if($highlights->section_headline)
            <h2 class="section__title">{{ $highlights->section_headline }}</h2>
            @endif
        </div>
        <div class="row g-4">
            @foreach(($highlights->subsections ?? collect()) as $item)
            <div class="col-lg-3 col-md-6">
                <div class="highlight_card">
                    <h4>{{ $item->section_headline }}</h4>
                    <p>{{ $decode($item, 'description') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($experiences && (($experiences->subsections ?? collect())->isNotEmpty() || $experiences->section_headline))
<section class="event_experiences section_padding">
    <div class="container">
        <div class="text-center mb-5">
            @if($experiences->section_subtitle)
            <div class="section__subtitle">
                <span>{{ $experiences->section_subtitle }}</span>
            </div>
            @endif
            @if($experiences->section_headline)
            <h2 class="section__title">{{ $experiences->section_headline }}</h2>
            @endif
        </div>
        <div class="row g-4">
            @foreach(($experiences->subsections ?? collect()) as $item)
            <div class="col-lg-4">
                <div class="experience_card">
                    @if($item->section_image)
                    <img src="{{ asset($item->section_image) }}" alt="{{ $item->section_headline }}">
                    @else
                    <img src="{{ asset('/imgs/banner.png') }}" alt="{{ $item->section_headline }}">
                    @endif
                    <div class="experience_content">
                        <h4>{{ $item->section_headline }}</h4>
                        <p>{!! $decode($item, 'description') !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


@include('footer')
