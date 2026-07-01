@section('title', optional($legalPage)->meta_title ?? 'Privacy Policy | Whispering Pines')
@section('description', optional($legalPage)->meta_description ?? '')
@section('keywords', optional($legalPage)->meta_keyword ?? '')
@include('header')

<section class="section_padding policy_section">
    <div class="container">
        <div class="policy_content">
            @if ($legalPage)
                <h2>{{ $legalPage->title }}</h2>
                {!! htmlspecialchars_decode($legalPage->description ?? '') !!}
            @else
                <h2>Privacy Policy</h2>
                <p>Content is not available at the moment.</p>
            @endif
        </div>
    </div>
</section>

@include('footer')
