@section('title', $accommodation->meta_title ?? ($accommodation->title . ' | Whispering Pines'))
@section('description', $accommodation->meta_description ?? '')
@section('keywords', $accommodation->meta_keyword ?? '')

@extends('layouts.MainLayouts')
@section('content')
@php
    /*
     * CMS section keys (default_section_name):
     * overview | gallery | features | inclusions | tariff | policies | other_stays | accom_cta
     *
     * Subsection field guide:
     * - overview stats: section_headline = value, section_subheading = label
     * - gallery: section_image, section_headline = caption, section_subheading = main|thumb|more
     * - features: section_image = icon, section_headline = title, description = text
     * - inclusions: section_headline = text, section_subheading = yes|no
     * - tariff rows: section_headline = occupancy, section_subtitle = weekday, section_subheading = weekend, description = extra person
     * - policies: section_headline = title, description = text
     * - other_stays: section_image, section_subheading = tag, section_headline = title, button_link = url
     */
    $getSection = fn(string $key) => $sections[$key] ?? null;
    $field = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? $section->{$key} : $default;
    $html = fn($section, string $key, string $default) => ($section && filled($section->{$key})) ? htmlspecialchars_decode($section->{$key}) : $default;
    $moreImages = fn($section) => ($section && !empty($section->more_images)) ? (json_decode($section->more_images, true) ?? []) : [];

    $overview = $getSection('overview');
    $gallery = $getSection('gallery');
    $features = $getSection('features');
    $inclusions = $getSection('inclusions');
    $tariff = $getSection('tariff');
    $policies = $getSection('policies');
    $otherStays = $getSection('other_stays');
    $accomCta = $getSection('accom_cta');

    $heroImage = $accommodation->hero_image ? asset($accommodation->hero_image) : asset('/imgs/a-1.webp');

    $defaultOverviewStats = [
        ['val' => '8', 'label' => 'Total Units'],
        ['val' => '12×12', 'label' => 'Sq. ft. Size'],
        ['val' => '2–3', 'label' => 'Guests Per Tent'],
        ['val' => '7,500', 'label' => 'Feet Altitude'],
    ];

    $defaultGalleryItems = [
        ['src' => '/imgs/a-1.webp', 'caption' => 'Alpine Swiss Tent — Interior View', 'type' => 'main'],
        ['src' => '/imgs/a-2.webp', 'caption' => 'Swiss Tent — Bedroom', 'type' => 'thumb'],
        ['src' => '/imgs/a-3.webp', 'caption' => 'Swiss Tent — Bathroom', 'type' => 'thumb'],
        ['src' => '/imgs/ab-1.webp', 'caption' => 'Swiss Tent — View from entrance', 'type' => 'thumb'],
        ['src' => '/imgs/g-1.webp', 'caption' => 'Mountain View', 'type' => 'more'],
    ];

    $defaultFeatures = [
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/1375/1375681.png', 'title' => 'Attached Bath', 'desc' => 'Well-tiled toilet & bath with 3\' corner walls.'],
        ['icon' => 'https://static.thenounproject.com/png/199290-200.png', 'title' => 'Wall-to-Wall Carpet', 'desc' => 'Warm underfoot comfort throughout the tent.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/752/752967.png', 'title' => 'Tea / Coffee Maker', 'desc' => 'In-tent tea & coffee maker for morning rituals.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/93/93158.png', 'title' => 'Free WiFi', 'desc' => 'Complimentary high-speed wireless internet.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/6570/6570897.png', 'title' => 'Charging Point', 'desc' => 'Mobile charging facility inside the tent.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/1824/1824506.png', 'title' => 'Fresh Linen Daily', 'desc' => 'Pillows, blankets and fresh towels provided.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/2564/2564031.png', 'title' => 'Herbal Toiletries', 'desc' => 'Premium in-tent herbal toiletries per guest.'],
        ['icon' => 'https://cdn-icons-png.flaticon.com/512/1651/1651876.png', 'title' => 'Mineral Water', 'desc' => 'Complimentary bottle per night from the resort.'],
    ];

    $defaultInclusions = [
        ['text' => 'Breakfast & Dinner (MAP basis)', 'type' => 'yes'],
        ['text' => 'Welcome drink on arrival', 'type' => 'yes'],
        ['text' => 'Complimentary mineral water daily', 'type' => 'yes'],
        ['text' => 'Herbal in-tent toiletries per guest', 'type' => 'yes'],
        ['text' => 'Daily housekeeping', 'type' => 'yes'],
        ['text' => 'Access to all resort common areas', 'type' => 'yes'],
        ['text' => 'Lunch (available at extra cost)', 'type' => 'no'],
        ['text' => 'Adventure activities (bookable separately)', 'type' => 'no'],
    ];

    $defaultTariffRows = [
        ['occupancy' => 'Single', 'weekday' => '₹4,500', 'weekend' => '₹5,500', 'extra' => '—'],
        ['occupancy' => 'Double', 'weekday' => '₹6,500', 'weekend' => '₹7,500', 'extra' => '₹1,800'],
        ['occupancy' => 'Triple', 'weekday' => '₹8,500', 'weekend' => '₹9,500', 'extra' => '—'],
    ];

    $defaultPolicies = [
        ['title' => 'Check-in / Out', 'desc' => 'Check-in from 12:00 PM<br>Check-out by 11:00 AM'],
        ['title' => 'Children', 'desc' => 'Children above 5 years charged as extra adult.'],
        ['title' => 'Cancellation', 'desc' => 'Free cancellation up to 7 days prior. See full policy.'],
        ['title' => 'House Rules', 'desc' => 'No smoking inside tents. Bonfire only in designated areas.'],
    ];

    $defaultOtherStays = [
        ['slug' => 'alpine-mountain-cottages', 'src' => '/imgs/a-1.webp', 'tag' => 'Signature Stay', 'title' => 'Alpine Mountain Cottages'],
        ['slug' => 'adventure-dome-camping-tents', 'src' => '/imgs/a-3.webp', 'tag' => 'Adventure Stay', 'title' => 'Adventure Dome & Camping Tents'],
    ];
@endphp

<section class="page-hero">
    <div class="page-hero__media">
        <img src="{{ $heroImage }}" alt="{{ $accommodation->title }}" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">{{ $accommodation->hero_subtitle ?: 'Accommodation' }}</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            {{ $accommodation->title }}
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            {!! htmlspecialchars_decode($accommodation->hero_description) ?: 'Premium canvas tents with mountain views and every comfort.' !!}
        </p>
        <a href="{{ $accommodation->button_link ?: route('enquire') }}" class="header__button header__button--one mt-4" data-animate="fade-up" data-delay="0.3">
            {{ $accommodation->button_name ?: 'Book This Stay' }}
            <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </a>
    </div>
</section>



<section class="accom-detail-overview section_padding">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-7">
                <div class="section__subtitle" data-animate="fade-up">
                    <span>{{ $field($overview, 'section_title', 'Overview') }}</span>
                    <div class="subtitle_line">
                        <div class="line"></div>
                        <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                        <div class="line"></div>
                    </div>
                </div>
                <h2 class="section__title my-3" data-animate="split-title">
                    {!! $html($overview, 'section_headline', 'Luxury Under Canvas, <br>Above The Clouds') !!}
                </h2>
                <p class="accom-detail-overview__desc" data-animate="fade-up" data-delay="0.1">
                    {!! $html($overview, 'description', 'Our 8 Alpine Swiss Tents are crafted from high-quality weatherproof canvas on metal
                    frames — combining the romance of tent living with the comfort of a well-appointed
                    hotel room. Perched in a pine clearing with views of the Gangotri range, each tent
                    is a private retreat of its own.') !!}
                </p>
            </div>

            <div class="col-lg-5">
                <div class="accom-detail-overview__stats" data-stagger>
                    @if($overview && $overview->subsections->count() > 0)
                        @foreach($overview->subsections as $stat)
                        <div class="accom-detail-overview__stat">
                            <span class="accom-detail-overview__stat-val">{{ $stat->section_headline }}</span>
                            <span class="accom-detail-overview__stat-label">{{ $stat->section_subheading }}</span>
                        </div>
                        @endforeach
                    @else
                        @foreach($defaultOverviewStats as $stat)
                        <div class="accom-detail-overview__stat">
                            <span class="accom-detail-overview__stat-val">{{ $stat['val'] }}</span>
                            <span class="accom-detail-overview__stat-label">{{ $stat['label'] }}</span>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>


<section class="accom-gallery section_padding pt-0">
    <div class="container">
        <div class="accom-gallery__grid" data-animate="fade-up">

            @if($gallery && $gallery->subsections->count() > 0)
                @foreach($gallery->subsections as $item)
                @php
                    $type = strtolower($item->section_subheading ?? 'thumb');
                    $itemClass = 'accom-gallery__thumb';
                    if ($type === 'main') {
                        $itemClass = 'accom-gallery__main';
                    } elseif ($type === 'more') {
                        $itemClass = 'accom-gallery__thumb accom-gallery__thumb--more';
                    }
                @endphp
                <a class="{{ $itemClass }}" href="{{ asset($item->section_image) }}" data-fancybox="accom-gallery"
                    data-caption="{{ $item->section_headline }}">
                    <img src="{{ asset($item->section_image) }}" alt="{{ $item->section_headline }}">
                    @if($type === 'more')
                    <div class="accom-gallery__more-label">View All</div>
                    @else
                    <div class="accom-gallery__zoom">
                        <svg width="{{ $type === 'main' ? '20' : '18' }}" height="{{ $type === 'main' ? '20' : '18' }}" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                            <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    @endif
                </a>
                @endforeach
            @elseif($gallery && ($gallery->section_image || count($moreImages($gallery)) > 0))
                @php
                    $galleryMain = $gallery->section_image ? asset($gallery->section_image) : asset($defaultGalleryItems[0]['src']);
                    $galleryThumbs = count($moreImages($gallery)) > 0 ? $moreImages($gallery) : array_column(array_slice($defaultGalleryItems, 1), 'src');
                @endphp
                <a class="accom-gallery__main" href="{{ $galleryMain }}" data-fancybox="accom-gallery" data-caption="{{ $field($gallery, 'section_headline', $defaultGalleryItems[0]['caption']) }}">
                    <img src="{{ $galleryMain }}" alt="{{ $field($gallery, 'section_headline', 'Gallery') }}">
                    <div class="accom-gallery__zoom">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                            <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                </a>
                @foreach($galleryThumbs as $index => $thumb)
                @php
                    $isLast = $loop->last;
                    $thumbSrc = str_starts_with($thumb, 'http') ? $thumb : asset($thumb);
                @endphp
                <a class="accom-gallery__thumb{{ $isLast ? ' accom-gallery__thumb--more' : '' }}" href="{{ $thumbSrc }}" data-fancybox="accom-gallery"
                    data-caption="{{ $defaultGalleryItems[$index + 1]['caption'] ?? '' }}">
                    <img src="{{ $thumbSrc }}" alt="">
                    @if($isLast)
                    <div class="accom-gallery__more-label">View All</div>
                    @else
                    <div class="accom-gallery__zoom">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                            <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    @endif
                </a>
                @endforeach
            @else
                @foreach($defaultGalleryItems as $item)
                @php
                    $itemClass = 'accom-gallery__thumb';
                    if ($item['type'] === 'main') {
                        $itemClass = 'accom-gallery__main';
                    } elseif ($item['type'] === 'more') {
                        $itemClass = 'accom-gallery__thumb accom-gallery__thumb--more';
                    }
                @endphp
                <a class="{{ $itemClass }}" href="{{ asset($item['src']) }}" data-fancybox="accom-gallery" data-caption="{{ $item['caption'] }}">
                    <img src="{{ asset($item['src']) }}" alt="{{ $item['caption'] }}">
                    @if($item['type'] === 'more')
                    <div class="accom-gallery__more-label">View All</div>
                    @else
                    <div class="accom-gallery__zoom">
                        <svg width="{{ $item['type'] === 'main' ? '20' : '18' }}" height="{{ $item['type'] === 'main' ? '20' : '18' }}" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2" />
                            <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    @endif
                </a>
                @endforeach
            @endif

        </div>
    </div>
</section>



<section class="accom-features section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($features, 'section_title', 'Inside Your Tent') }}</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon">
                        <img src="/imgs/Vector.svg" alt="">
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-3" data-animate="split-title">{{ $field($features, 'section_headline', 'Room Features & Amenities') }}</h2>
        </div>

        <div class="row g-4" data-stagger>
            @if($features && $features->subsections->count() > 0)
                @foreach($features->subsections as $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="accom-feature">
                        <div class="accom-feature__icon">
                            <img src="{{ $item->section_image ? asset($item->section_image) : ($defaultFeatures[$loop->index]['icon'] ?? '') }}" alt="">
                        </div>
                        <h5 class="accom-feature__title">{{ $item->section_headline }}</h5>
                        <p class="accom-feature__desc">{!! htmlspecialchars_decode($item->description) !!}</p>
                    </div>
                </div>
                @endforeach
            @else
                @foreach($defaultFeatures as $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="accom-feature">
                        <div class="accom-feature__icon">
                            <img src="{{ $item['icon'] }}" alt="">
                        </div>
                        <h5 class="accom-feature__title">{{ $item['title'] }}</h5>
                        <p class="accom-feature__desc">{{ $item['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</section>


<section class="accom-inclusions section_padding">
    <div class="container">
        <div class="accom-inclusions__inner">

            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-animate="fade-right">
                    <img src="{{ ($inclusions && $inclusions->section_image) ? asset($inclusions->section_image) : asset('/imgs/g-img-1.png') }}" alt="Inclusions" class="accom-inclusions__img">
                </div>
                <div class="col-lg-6">
                    <div class="section__subtitle" data-animate="fade-up">
                        <span>{{ $field($inclusions, 'section_title', 'What\'s Included') }}</span>
                        <div class="subtitle_line">
                            <div class="line"></div>
                            <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                            <div class="line"></div>
                        </div>
                    </div>
                    <h2 class="section__title mb-4" data-animate="split-title">{{ $field($inclusions, 'section_headline', 'Everything You Need') }}</h2>

                    <div class="accom-inclusions__list" data-stagger>
                        @if($inclusions && $inclusions->subsections->count() > 0)
                            @foreach($inclusions->subsections as $item)
                            @php $inclusionType = strtolower($item->section_subheading ?? 'yes') === 'no' ? 'no' : 'yes'; @endphp
                            <div class="accom-inclusions__item accom-inclusions__item--{{ $inclusionType }}">
                                <span>{{ $item->section_headline }}</span>
                            </div>
                            @endforeach
                        @else
                            @foreach($defaultInclusions as $item)
                            <div class="accom-inclusions__item accom-inclusions__item--{{ $item['type'] }}">
                                <span>{{ $item['text'] }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="accom-tariff section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($tariff, 'section_title', 'Pricing') }}</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-3" data-animate="split-title">{{ $field($tariff, 'section_headline', 'Capacity & Tariff') }}</h2>
            <p class="mt-2" style="font-size:.85rem; color:var(--text-color);" data-animate="fade-up" data-delay="0.1">
                {{ $field($tariff, 'description', 'All rates are per night, per unit. Inclusive of MAP (breakfast & dinner).') }}
            </p>
        </div>

        <div class="accom-tariff__table-wrap" data-animate="fade-up" data-delay="0.1">
            <table class="accom-tariff__table">
                <thead>
                    <tr>
                        <th>Occupancy</th>
                        <th>Weekday</th>
                        <th>Weekend / Holiday</th>
                        <th>Extra Person</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tariff && $tariff->subsections->count() > 0)
                        @foreach($tariff->subsections as $row)
                        <tr>
                            <td>{{ $row->section_headline }}</td>
                            <td>{{ $row->section_subtitle }}</td>
                            <td>{{ $row->section_subheading }}</td>
                            <td>{!! htmlspecialchars_decode($row->description) !!}</td>
                        </tr>
                        @endforeach
                    @else
                        @foreach($defaultTariffRows as $row)
                        <tr>
                            <td>{{ $row['occupancy'] }}</td>
                            <td>{{ $row['weekday'] }}</td>
                            <td>{{ $row['weekend'] }}</td>
                            <td>{{ $row['extra'] }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <p class="accom-tariff__note" data-animate="fade-up" data-delay="0.15">
            {{ $field($tariff, 'section_subtitle', '* Rates are indicative. Final pricing shared at time of booking confirmation. Contact us for group, corporate, or long-stay rates.') }}
        </p>

    </div>
</section>


<section class="accom-policies section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($policies, 'section_title', 'Good To Know') }}</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-2" data-animate="split-title">{{ $field($policies, 'section_headline', 'Policies & House Rules') }}</h2>
        </div>

        <div class="row g-4" data-stagger>
            @if($policies && $policies->subsections->count() > 0)
                @foreach($policies->subsections as $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="accom-policy">
                        <div class="accom-policy__icon">
                            @if($item->section_image)
                            <img src="{{ asset($item->section_image) }}" alt="" width="24" height="24">
                            @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            @endif
                        </div>
                        <h5 class="accom-policy__title">{{ $item->section_headline }}</h5>
                        <p class="accom-policy__desc">{!! htmlspecialchars_decode($item->description) !!}</p>
                    </div>
                </div>
                @endforeach
            @else
                @foreach($defaultPolicies as $index => $item)
                <div class="col-lg-3 col-sm-6">
                    <div class="accom-policy">
                        <div class="accom-policy__icon">
                            @if($index === 0)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                <path d="M12 8v4l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            @elseif($index === 1)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.5" />
                                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.5" />
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.5" />
                            </svg>
                            @elseif($index === 2)
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M3 3h18v18H3zM9 9h6M9 12h6M9 15h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                <path d="M12 8v4M12 16h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            @endif
                        </div>
                        <h5 class="accom-policy__title">{{ $item['title'] }}</h5>
                        <p class="accom-policy__desc">{!! $item['desc'] !!}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</section>


<section class="accom-other section_padding">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section__subtitle justify-content-center" data-animate="fade-up">
                <span>{{ $field($otherStays, 'section_title', 'Explore More') }}</span>
                <div class="subtitle_line justify-content-center">
                    <div class="line"></div>
                    <div class="line_icon"><img src="/imgs/Vector.svg" alt=""></div>
                    <div class="line"></div>
                </div>
            </div>
            <h2 class="section__title my-2" data-animate="split-title">{{ $field($otherStays, 'section_headline', 'Other Ways To Stay') }}</h2>
        </div>

        <div class="row g-4" data-stagger>
            @if($otherStays && $otherStays->subsections->count() > 0)
                @foreach($otherStays->subsections as $item)
                <div class="col-lg-6">
                    <a href="{{ $item->button_link ?: '#' }}" class="accom-other__card">
                        <div class="accom-other__media">
                            <img src="{{ $item->section_image ? asset($item->section_image) : asset('/imgs/a-1.webp') }}" alt="{{ $item->section_headline }}">
                            <div class="accom-other__overlay"></div>
                        </div>
                        <div class="accom-other__content">
                            <span class="accom-other__tag">{{ $item->section_subheading }}</span>
                            <h4 class="accom-other__title">{{ $item->section_headline }}</h4>
                            <span class="accom-other__link">
                                View Details
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
                @endforeach
            @elseif($otherAccommodations->count() > 0)
                @foreach($otherAccommodations as $item)
                <div class="col-lg-6">
                    <a href="{{ route('accommodation.detail', $item->slug) }}" class="accom-other__card">
                        <div class="accom-other__media">
                            <img src="{{ $item->listing_image ? asset($item->listing_image) : asset('/imgs/a-1.webp') }}" alt="{{ $item->title }}">
                            <div class="accom-other__overlay"></div>
                        </div>
                        <div class="accom-other__content">
                            @if($item->tag)<span class="accom-other__tag">{{ $item->tag }}</span>@endif
                            <h4 class="accom-other__title">{{ $item->title }}</h4>
                            <span class="accom-other__link">
                                View Details
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
                @endforeach
            @else
                @foreach($defaultOtherStays as $item)
                <div class="col-lg-6">
                    <a href="{{ route('accommodation.detail', $item['slug']) }}" class="accom-other__card">
                        <div class="accom-other__media">
                            <img src="{{ asset($item['src']) }}" alt="{{ $item['title'] }}">
                            <div class="accom-other__overlay"></div>
                        </div>
                        <div class="accom-other__content">
                            <span class="accom-other__tag">{{ $item['tag'] }}</span>
                            <h4 class="accom-other__title">{{ $item['title'] }}</h4>
                            <span class="accom-other__link">
                                View Details
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</section>


<!-- ════════════════════════════════
     8. CTA
════════════════════════════════ -->
<section class="retreat-cta section_padding">
    <div class="container">
        <div class="retreat-cta__inner" data-animate="fade-up">
            <div class="retreat-cta__line"></div>
            <h2 class="retreat-cta__heading">{{ $field($accomCta, 'section_headline', 'Ready To Wake Up In The Mountains?') }}</h2>
            <p class="retreat-cta__sub">
                {!! $html($accomCta, 'description', 'Availability is limited. <br>
                Reach out and we\'ll plan your perfect stay.') !!}
            </p>
            <a href="{{ $field($accomCta, 'button_link', route('enquire')) }}" class="header__button header__button--one mt-4">
                {{ $field($accomCta, 'button_name', 'Enquire & Book') }}
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>

@endsection
