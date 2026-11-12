@extends('layouts.app')

@section('title', config('app.name') . ' | ' . __('Beauty meets confidence.'))
@section('main_class', 'landing-main')

@section('content')

{{-- Hero. Photos go in public/images/landing/ (see the file names in the instructions). --}}
<section class="hero">
    <div class="container hero-inner">
        <div class="hero-copy">
            <h1>{{ __('Beauty meets') }} <em>{{ __('confidence.') }}</em></h1>
            <p class="hero-lead">{{ __('Where personal style meets professional care. Discover hair experiences designed to bring out the best in you.') }}</p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('catalog.index') }}" class="btn btn-blush">{{ __('Explore our services') }}</a>
                <a href="{{ route('booking.create') }}" class="btn btn-outline-light">{{ __('Book an appointment') }}</a>
            </div>
        </div>

        <div class="hero-portraits">
            <figure class="arch arch--a">
                @if ($photos['hero_woman'])
                    <img src="{{ $photos['hero_woman'] }}" alt="">
                @endif
            </figure>
            <figure class="arch arch--b">
                @if ($photos['hero_man'])
                    <img src="{{ $photos['hero_man'] }}" alt="">
                @endif
            </figure>
        </div>
    </div>
</section>

{{-- About --}}
<section class="section" id="about">
    <div class="container about-grid">
        <div>
            <h2 class="section-title">{{ __('More than a') }} <em>{{ __('hairstyle.') }}</em></h2>
            <p class="mb-4">{{ __("It's an expression of who you are. At Nahbi's Hair, we believe great hair is more than appearance. It's about confidence, individuality and feeling your best. Discover a space where style, care and creativity come together.") }}</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">{{ __('See our styles') }}</a>
        </div>
        <div class="about-photo">
            @if ($photos['about'])
                <img src="{{ $photos['about'] }}" alt="" loading="lazy">
            @endif
        </div>
    </div>
</section>

{{-- Services --}}
<section class="section section-pale">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ __('Find your') }} <em>{{ __('signature style.') }}</em></h2>
            <p class="section-lead">{{ __('From everyday braids to bold custom looks, find the style that fits you.') }}</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <a class="service-tile" href="{{ route('catalog.index', ['filter' => 'female']) }}">
                    <div class="photo">
                        @if ($photos['women'])<img src="{{ $photos['women'] }}" alt="" loading="lazy">@endif
                    </div>
                    <div class="body">
                        <h3>{{ __("Women's braids") }}</h3>
                        <p>{{ __('Knotless, boho, cornrows and more.') }}</p>
                        <span class="more">{{ __('View styles') }} &rarr;</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a class="service-tile" href="{{ route('catalog.index', ['filter' => 'male']) }}">
                    <div class="photo">
                        @if ($photos['men'])<img src="{{ $photos['men'] }}" alt="" loading="lazy">@endif
                    </div>
                    <div class="body">
                        <h3>{{ __("Men's braids") }}</h3>
                        <p>{{ __('Clean, sharp styles for men.') }}</p>
                        <span class="more">{{ __('View styles') }} &rarr;</span>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a class="service-tile" href="{{ route('booking.create') }}">
                    <div class="photo">
                        @if ($photos['custom'])<img src="{{ $photos['custom'] }}" alt="" loading="lazy">@endif
                    </div>
                    <div class="body">
                        <h3>{{ __('Custom style') }}</h3>
                        <p>{{ __('Send a photo or describe it. We will call you to agree on the price.') }}</p>
                        <span class="more">{{ __('Request a custom style') }} &rarr;</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Final call to action (also the Contact anchor) --}}
<section class="cta" id="contact">
    <div class="container">
        <h2 class="cta-title">{{ __('Your next look starts here.') }}</h2>
        <p>{{ __('Give yourself the experience you deserve. Let us help you discover a style that feels like you.') }}</p>
        <a href="{{ route('booking.create') }}" class="btn btn-blush btn-lg">{{ __('Book your appointment') }}</a>

        @if (config('salon.whatsapp'))
            <p class="mt-4 mb-0">
                <a class="cta-link" href="https://wa.me/{{ preg_replace('/\D/', '', config('salon.whatsapp')) }}" target="_blank" rel="noopener">{{ __('Questions? Message us on WhatsApp') }}</a>
            </p>
        @endif
    </div>
</section>

@endsection