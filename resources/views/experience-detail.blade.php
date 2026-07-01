@section('title', $experience->meta_title ?? ($experience->title . ' | Whispering Pines'))
@section('description', $experience->meta_description ?? '')
@include('header')

@php
    $getSection = fn(string $key) => $sections[$key] ?? null;
    $field = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? $section->{$key} : $default;
    $html = fn($section, string $key, string $default) => ($section && filled($section->{$key})) ? htmlspecialchars_decode($section->{$key}) : $default;

    $editorial = $getSection('editorial');
    $expect = $getSection('what_to_expect');
    $activities = $getSection('activities');
    $timeline = $getSection('day_timeline');
    $bestMonths = $getSection('best_months');
    $gallery = $getSection('gallery');
    $booking = $getSection('booking_sidebar');
    $expCta = $getSection('exp_cta');

    $heroImage = $experience->hero_image ? asset($experience->hero_image) : asset('/imgs/banner.png');
    $gallerySlug = \Illuminate\Support\Str::slug($experience->slug) . '-gallery';

    $monthBarClass = fn(?string $status) => match($status) {
        'peak' => 'exp-months__bar--active exp-months__bar--peak',
        'active' => 'exp-months__bar--active',
        'partial' => 'exp-months__bar--partial',
        default => '',
    };

    $galleryLayoutClass = fn(?string $layout) => match($layout) {
        'tall' => 'exp-gallery__item--tall',
        'wide' => 'exp-gallery__item--wide',
        'tall-sm' => 'exp-gallery__item--tall-sm',
        default => '',
    };
@endphp

<section class="page-hero">
    <div class="page-hero__media">
        <img src="{{ $heroImage }}" alt="{{ $experience->title }}" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">{{ $experience->hero_subtitle ?: 'Experiences' }}</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            {{ $experience->title }}
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            {!! htmlspecialchars_decode($experience->hero_description) !!}
        </p>
    </div>
</section>

<div class="exp-detail-layout section_padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                @if($editorial && ($editorial->section_headline || $editorial->subsections->isNotEmpty()))
                <div class="exp-editorial mb-5">
                    <div class="row g-4 align-items-start">
                        @if($editorial->section_headline)
                        <div class="col-md-5">
                            <blockquote class="exp-editorial__quote" data-animate="fade-right">
                                "{{ $editorial->section_headline }}"
                            </blockquote>
                        </div>
                        @endif
                        @if($editorial->subsections->isNotEmpty())
                        <div class="col-md-{{ $editorial->section_headline ? '7' : '12' }}">
                            @foreach($editorial->subsections as $i => $para)
                            <p class="exp-editorial__para" data-animate="fade-up" @if($i > 0) data-delay="{{ number_format($i * 0.05, 2) }}" @endif>
                                {!! htmlspecialchars_decode($para->description) !!}
                            </p>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($expect && ($expect->section_headline || $expect->subsections->isNotEmpty()))
                <div class="exp-expect mb-5" data-animate="fade-up">
                    <h3 class="exp-expect__heading">{{ $field($expect, 'section_headline', 'What To Expect') }}</h3>
                    <div class="exp-expect__grid">
                        @foreach($expect->subsections as $item)
                        <div class="exp-expect__item">
                            <div class="exp-expect__icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                            </div>
                            <div>
                                <span class="exp-expect__label">{{ $item->section_subheading }}</span>
                                <span class="exp-expect__val">{{ $item->section_headline }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($activities && ($activities->section_headline || $activities->subsections->isNotEmpty()))
                <div class="exp-activities mb-5">
                    <h3 class="exp-activities__heading" data-animate="fade-up">{{ $activities->section_headline }}</h3>
                    @if($activities->section_subtitle)
                    <p class="exp-activities__sub" data-animate="fade-up" data-delay="0.05">{{ $activities->section_subtitle }}</p>
                    @endif
                    <div class="row g-3 mt-2" data-stagger>
                        @foreach($activities->subsections as $item)
                        <div class="col-sm-6">
                            <div class="exp-act-card">
                                @if($item->section_image)
                                <div class="exp-act-card__img">
                                    <img src="{{ asset($item->section_image) }}" alt="{{ $item->section_headline }}">
                                </div>
                                @endif
                                <div class="exp-act-card__body">
                                    <h5 class="exp-act-card__title">{{ $item->section_headline }}</h5>
                                    <p class="exp-act-card__desc">{!! htmlspecialchars_decode($item->description) !!}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($timeline && ($timeline->section_headline || $timeline->subsections->isNotEmpty()))
                <div class="exp-day mb-5">
                    <h3 class="exp-day__heading" data-animate="fade-up">{{ $timeline->section_headline }}</h3>
                    @if($timeline->section_subtitle)
                    <p class="exp-day__sub" data-animate="fade-up" data-delay="0.05">{{ $timeline->section_subtitle }}</p>
                    @endif
                    <div class="exp-day__timeline" data-stagger>
                        @foreach($timeline->subsections as $item)
                        <div class="exp-day__item">
                            <div class="exp-day__time-col">
                                <span class="exp-day__time">{{ $item->section_subtitle }}</span>
                                <div class="exp-day__time-line"></div>
                            </div>
                            <div class="exp-day__content">
                                <h5 class="exp-day__title">{{ $item->section_headline }}</h5>
                                <p class="exp-day__desc">{!! htmlspecialchars_decode($item->description) !!}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($bestMonths && ($bestMonths->section_headline || $bestMonths->subsections->isNotEmpty()))
                <div class="exp-months mb-5" data-animate="fade-up">
                    <h3 class="exp-months__heading">{{ $field($bestMonths, 'section_headline', 'Best Time To Visit') }}</h3>
                    <div class="exp-months__strip">
                        @foreach($bestMonths->subsections as $month)
                        <div class="exp-months__month">
                            <span class="exp-months__label">{{ $month->section_subheading }}</span>
                            <div class="exp-months__bar {{ $monthBarClass($month->section_subtitle) }}"></div>
                        </div>
                        @endforeach
                    </div>
                    <div class="exp-months__legend">
                        <span class="exp-months__legend-item exp-months__legend-item--peak">Peak Season</span>
                        <span class="exp-months__legend-item exp-months__legend-item--active">Good</span>
                        <span class="exp-months__legend-item exp-months__legend-item--partial">Shoulder</span>
                        <span class="exp-months__legend-item exp-months__legend-item--off">Off Season</span>
                    </div>
                </div>
                @endif

                @if($gallery && ($gallery->section_headline || $gallery->subsections->isNotEmpty()))
                <div class="exp-gallery-inline mb-2">
                    <h3 class="exp-activities__heading" data-animate="fade-up">{{ $gallery->section_headline }}</h3>
                    @if($gallery->section_subtitle)
                    <p class="exp-activities__sub mb-4" data-animate="fade-up" data-delay="0.05">{{ $gallery->section_subtitle }}</p>
                    @endif
                    <div class="exp-gallery__grid" data-animate="fade-up" data-delay="0.1">
                        @foreach($gallery->subsections as $item)
                        @if($item->section_image)
                        <a href="{{ asset($item->section_image) }}"
                           data-fancybox="{{ $gallerySlug }}"
                           data-caption="{{ $item->section_headline }}"
                           class="exp-gallery__item {{ $galleryLayoutClass($item->section_subheading) }}">
                            <img src="{{ asset($item->section_image) }}" alt="">
                            <div class="exp-gallery__item-overlay">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                    <circle cx="11" cy="11" r="8" stroke="white" stroke-width="1.5" />
                                    <path d="M21 21l-4.35-4.35M11 8v6M8 11h6" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </div>
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="exp-book-wrap">
                    <div class="exp-book" id="expBookForm" data-lead-form data-form-type="booking">
                        <div class="exp-book__header">
                            <span class="exp-book__tag">{{ $field($booking, 'section_subheading', $experience->season_tag ?: 'Experience') }}</span>
                            <h4 class="exp-book__title">{{ $field($booking, 'section_headline', 'Plan Your Visit') }}</h4>
                            <p class="exp-book__sub">{!! $html($booking, 'description', 'Share your details and we\'ll get back within 24 hours.') !!}</p>
                        </div>
                        <div class="exp-book__body">
                            <div class="exp-book__field">
                                <label class="exp-book__label">Full Name</label>
                                <input type="text" name="name" class="exp-book__input" placeholder="Your name" required>
                            </div>
                            <div class="exp-book__field">
                                <label class="exp-book__label">Phone Number</label>
                                <input type="tel" name="phone" class="exp-book__input" placeholder="+91 00000 00000">
                            </div>
                            <div class="exp-book__field">
                                <label class="exp-book__label">Email Address</label>
                                <input type="email" name="email" class="exp-book__input" placeholder="you@email.com" required>
                            </div>
                            <div class="exp-book__field">
                                <label class="exp-book__label">Check-in Date</label>
                                <input type="date" name="checkin" class="exp-book__input">
                            </div>
                            <div class="exp-book__row">
                                <div class="exp-book__field">
                                    <label class="exp-book__label">Adults</label>
                                    <select name="guests" class="exp-book__input">
                                        <option>1</option><option>2</option><option>3</option><option>4</option><option>5+</option>
                                    </select>
                                </div>
                                <div class="exp-book__field">
                                    <label class="exp-book__label">Nights</label>
                                    <select name="nights" class="exp-book__input">
                                        <option>1</option><option>2</option><option>3</option><option>4</option><option>5+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="exp-book__field">
                                <label class="exp-book__label">Message (optional)</label>
                                <textarea name="message" class="exp-book__input exp-book__textarea" placeholder="Any specific requests or questions..."></textarea>
                            </div>
                            <button type="button" class="exp-book__submit" data-lead-submit>
                                Send Enquiry
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <p class="exp-book__note" data-lead-success style="display:none;color:#2d6a4f;">✓ Enquiry sent. We'll be in touch soon.</p>
                            <p class="exp-book__note text-danger" data-lead-error style="display:none;"></p>
                            <p class="exp-book__note">We respond within 24 hours. No spam, ever.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($expCta)
<section class="retreat-cta section_padding">
    <div class="container">
        <div class="retreat-cta__inner" data-animate="fade-up">
            <div class="retreat-cta__line"></div>
            <h2 class="retreat-cta__heading">{{ $field($expCta, 'section_headline', 'Plan Your Experience') }}</h2>
            <p class="retreat-cta__sub">{!! $html($expCta, 'description', '') !!}</p>
            <a href="{{ $expCta->button_link ?: route('enquire') }}" class="header__button header__button--one mt-4">
                {{ $field($expCta, 'button_name', 'Enquire Now') }}
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                    <path d="M13 6L1 6M8.45 1L13 6L8.45 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

@include('footer')
