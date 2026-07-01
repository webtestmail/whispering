@section('title', $page->meta_title ?? 'Dining | Whispering Pines')
@section('description', $page->meta_description ?? '')
@section('keywords', $page->meta_keyword ?? '')

@include('header')

@php
    $diningIntro = $sections['dining_intro'] ?? null;
    $signatureDining = $sections['signature_dining'] ?? null;
    $cuisineSection = $sections['cuisine_section'] ?? null;
    $foodGallery = $sections['food_gallery'] ?? null;

    $field = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? $section->{$key} : $default;
    $html = fn($section, string $key, $default) => ($section && filled($section->{$key})) ? htmlspecialchars_decode($section->{$key}) : $default;
    $pageHtml = fn(string $key, string $default) => ($page && filled($page->{$key})) ? htmlspecialchars_decode($page->{$key}) : $default;

    $heroImage = ($page && $page->page_image) ? asset($page->page_image) : asset('/imgs/banner.png');

    $defaultIntroFeatures = [
        ['title' => 'Multi Cuisine', 'desc' => 'Indian, Continental & local favourites.'],
        ['title' => 'Fresh Ingredients', 'desc' => 'Locally sourced whenever possible.'],
        ['title' => 'Scenic Dining', 'desc' => 'Meals served with breathtaking views.'],
    ];

    $defaultSignatureItems = [
        ['title' => 'Breakfast With The Mountains', 'desc' => 'Begin your day with fresh flavours and panoramic views.', 'image' => 'https://img.magnific.com/free-photo/beetroot-salad-with-walnut-mayonnaise_114579-2214.jpg?t=st=1781326675~exp=1781330275~hmac=989a9edc9f74aadd5dd3bfdfe565cac39612f0c98b931787790169e76dd4629e&w=2000'],
        ['title' => 'Traditional Garhwali Cuisine', 'desc' => 'Discover authentic regional flavours and local recipes.', 'image' => 'https://img.magnific.com/free-photo/classic-tomato-spaghetti-garnished-with-grated-parmesan-fresh-basil_140725-236.jpg?t=st=1781326707~exp=1781330307~hmac=416f24e48232dad5b0eb57e2972a1f897a3b6bebc7fcbb7b2bafd66cc3e65181&w=1480'],
        ['title' => 'Evening Tea & Conversations', 'desc' => 'Relax with warm refreshments as the sun sets.', 'image' => 'https://img.magnific.com/free-photo/cheese-plate-with-honey-table_140725-698.jpg?t=st=1781326728~exp=1781330328~hmac=286a92ba67d2f5a4eef2a74e4f0dd57d6035b88d8814c94fc27f050ba9485ef0&w=2000'],
    ];

    $defaultCuisines = ['Indian', 'Continental', 'Chinese', 'Local Cuisine'];

    $defaultGalleryImages = [
        'https://img.magnific.com/free-photo/front-view-male-pepper-fried-chicken-sauce-stand-with-spices-table_140725-9062.jpg?t=st=1781326592~exp=1781330192~hmac=5bc275b5c162ccc388457a0fcdfc0d534a0bf6cccc0b105fc72adaeaa681a279&w=2000',
        'https://img.magnific.com/free-photo/classic-tomato-spaghetti-garnished-with-grated-parmesan-fresh-basil_140725-236.jpg?t=st=1781326707~exp=1781330307~hmac=416f24e48232dad5b0eb57e2972a1f897a3b6bebc7fcbb7b2bafd66cc3e65181&w=1480',
        'https://img.magnific.com/free-photo/beetroot-salad-with-walnut-mayonnaise_114579-2214.jpg?t=st=1781326675~exp=1781330275~hmac=989a9edc9f74aadd5dd3bfdfe565cac39612f0c98b931787790169e76dd4629e&w=2000',
        'https://img.magnific.com/free-photo/cheese-plate-with-honey-table_140725-698.jpg?t=st=1781326728~exp=1781330328~hmac=286a92ba67d2f5a4eef2a74e4f0dd57d6035b88d8814c94fc27f050ba9485ef0&w=2000',
    ];

    $introImage = ($diningIntro && $diningIntro->section_image)
        ? asset($diningIntro->section_image)
        : 'https://img.magnific.com/free-photo/front-view-male-pepper-fried-chicken-sauce-stand-with-spices-table_140725-9062.jpg?t=st=1781326592~exp=1781330192~hmac=5bc275b5c162ccc388457a0fcdfc0d534a0bf6cccc0b105fc72adaeaa681a279&w=2000';
@endphp

<section class="page-hero">
    <div class="page-hero__media">
        <img src="{{ $heroImage }}" alt="Dining" class="page-hero__img">
        <div class="page-hero__overlay"></div>
    </div>
    <div class="page-hero__content">
        <div class="section__subtitle" data-animate="fade-up">
            <span class="text-white">{{ $field($page, 'breadcrumb_headline', '') }}</span>
        </div>
        <h1 class="page-hero__title" data-animate="split-title">
            {!! $pageHtml('breadcrumb_description', '') !!}
        </h1>
        <p class="page-hero__sub" data-animate="fade-up" data-delay="0.2">
            {!! $pageHtml('description', '') !!}
        </p>
    </div>
</section>

<section class="dining_intro section_padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="dining_intro_img">
                    <img src="{{ $introImage }}" alt="">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="section__subtitle">
                    <span>{{ $field($diningIntro, 'section_title', '') }}</span>
                </div>

                <h2 class="section__title">
                    {{ $field($diningIntro, 'section_headline', '') }}
                </h2>

                <p>{!! $html($diningIntro, 'description', '') !!}</p>

                <div class="dining_features">
                    @if($diningIntro && $diningIntro->pagesubsections->isNotEmpty())
                        @foreach($diningIntro->pagesubsections as $feature)
                        <div class="dining_feature">
                            <h4>{{ $feature->section_headline }}</h4>
                            <p>{!! htmlspecialchars_decode($feature->description) !!}</p>
                        </div>
                        @endforeach
                    @else
                        @foreach($defaultIntroFeatures as $feature)
                        <div class="dining_feature">
                            <h4>{{ $feature['title'] }}</h4>
                            <p>{{ $feature['desc'] }}</p>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="signature_dining section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle">
                <span>{{ $field($signatureDining, 'section_title', 'Highlights') }}</span>
            </div>

            <h2 class="section__title">
                {{ $field($signatureDining, 'section_headline', 'Signature Dining Moments') }}
            </h2>
        </div>

        <div class="row g-4">
            @if($signatureDining && $signatureDining->pagesubsections->isNotEmpty())
                @foreach($signatureDining->pagesubsections as $item)
                <div class="col-lg-4">
                    <div class="signature_card">
                        <img src="{{ $item->section_image ? asset($item->section_image) : asset('/imgs/banner.png') }}" alt="">
                        <div class="signature_content">
                            <h4>{{ $item->section_headline }}</h4>
                            <p>{!! htmlspecialchars_decode($item->description) !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @foreach($defaultSignatureItems as $item)
                <div class="col-lg-4">
                    <div class="signature_card">
                        <img src="{{ $item['image'] }}" alt="">
                        <div class="signature_content">
                            <h4>{{ $item['title'] }}</h4>
                            <p>{{ $item['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="cuisine_section section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle">
                <span>{{ $field($cuisineSection, 'section_title', 'What We Serve') }}</span>
            </div>

            <h2 class="section__title">
                {{ $field($cuisineSection, 'section_headline', 'Something For Every Taste') }}
            </h2>
        </div>

        <div class="row g-4">
            @if($cuisineSection && $cuisineSection->pagesubsections->isNotEmpty())
                @foreach($cuisineSection->pagesubsections as $item)
                <div class="col-lg-3 col-md-6">
                    <div class="cuisine_card">
                        <h4>{{ $item->section_headline }}</h4>
                    </div>
                </div>
                @endforeach
            @else
                @foreach($defaultCuisines as $name)
                <div class="col-lg-3 col-md-6">
                    <div class="cuisine_card">
                        <h4>{{ $name }}</h4>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="food_gallery section_padding">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section__subtitle">
                <span>{{ $field($foodGallery, 'section_title', 'Gallery') }}</span>
            </div>

            <h2 class="section__title">
                {{ $field($foodGallery, 'section_headline', 'A Taste Of Whispering Pines') }}
            </h2>
        </div>

        <div class="row g-4">
            @if($foodGallery && $foodGallery->pagesubsections->isNotEmpty())
                @foreach($foodGallery->pagesubsections as $item)
                <div class="col-lg-3 col-6">
                    <img src="{{ $item->section_image ? asset($item->section_image) : asset('/imgs/banner.png') }}" class="gallery_food_img" alt="">
                </div>
                @endforeach
            @elseif($foodGallery && !empty($foodGallery->more_images))
                @foreach(json_decode($foodGallery->more_images, true) ?? [] as $image)
                <div class="col-lg-3 col-6">
                    <img src="{{ asset($image) }}" class="gallery_food_img" alt="">
                </div>
                @endforeach
            @else
                @foreach($defaultGalleryImages as $image)
                <div class="col-lg-3 col-6">
                    <img src="{{ $image }}" class="gallery_food_img" alt="">
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@include('footer')
