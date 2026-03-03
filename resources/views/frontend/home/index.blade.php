@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta'))
@section('meta_description', \App\Models\Setting::get('meta_description', ''))
@section('meta_keywords', \App\Models\Setting::get('meta_keywords', ''))

@push('styles')
<style>
.hero-swiper { position: relative; }
.hero-swiper .swiper-slide { height: auto; }
.hero-pagination { bottom: 20px !important; }
.hero-pagination .swiper-pagination-bullet { background: #fff; opacity: 0.6; width: 10px; height: 10px; }
.hero-pagination .swiper-pagination-bullet-active { background: #ff6b35; opacity: 1; }
.hero-prev, .hero-next {
    color: #fff !important;
    background: rgba(0,0,0,0.3);
    border-radius: 50%;
    width: 44px !important;
    height: 44px !important;
}
.hero-prev::after, .hero-next::after { font-size: 16px !important; font-weight: 700; }
.hero-prev:hover, .hero-next:hover { background: #ff6b35; }
</style>
@endpush

@section('content')

{{-- HERO SLIDER --}}
<section class="home-hero p-lr">
    @if($sliders->isNotEmpty())
    <div class="hero-swiper swiper">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
            <div class="swiper-slide">
                <div class="home-hero-main">
                    @if($slider->image)
                        <img src="{{ Storage::url($slider->image) }}"
                             alt="{{ $slider->getTranslation('title', $locale) }}"
                             class="hero-image">
                    @else
                        <img src="{{ asset('frontend/images/homeHero.png') }}" alt="" class="hero-image">
                    @endif
                    <div class="home-hero-content">
                        <h1 class="hero-title">{!! $slider->getTranslation('title', $locale) !!}</h1>
                        @if($slider->getTranslation('subtitle', $locale))
                        <p class="hero-subtitle">{{ $slider->getTranslation('subtitle', $locale) }}</p>
                        @endif
                        <a href="{{ $slider->button_url ?: route('contact', $locale) }}" class="hero-link">
                            <p>{{ $slider->getTranslation('button_text', $locale) ?: __('general.order_now') }}</p>
                            <img src="{{ asset('frontend/icons/hammer.svg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($sliders->count() > 1)
        <div class="swiper-pagination hero-pagination"></div>
        <div class="swiper-button-prev hero-prev"></div>
        <div class="swiper-button-next hero-next"></div>
        @endif
    </div>
    @else
    <div class="home-hero-main">
        <img src="{{ asset('frontend/images/homeHero.png') }}" alt="" class="hero-image">
        <div class="home-hero-content">
            <h1 class="hero-title">{!! __('general.home_hero_fallback') !!}</h1>
            <a href="{{ route('contact', $locale) }}" class="hero-link">
                <p>{{ __('general.order_now') }}</p>
                <img src="{{ asset('frontend/icons/hammer.svg') }}" alt="">
            </a>
        </div>
    </div>
    @endif
</section>

{{-- HAQQIMIZDA --}}
<section class="home-about p-lr">
    <div class="home-about-images">
        <div class="image-large">
            @if($homeAbout && $homeAbout->image1)
                <img src="{{ Storage::url($homeAbout->image1) }}" alt="{{ $homeAbout->getTranslation('title', $locale) }}">
            @else
                <img src="{{ asset('frontend/images/homeAboutLarge.png') }}" alt="">
            @endif
        </div>
        <div class="image-small">
            @if($homeAbout && $homeAbout->image2)
                <img src="{{ Storage::url($homeAbout->image2) }}" alt="">
            @else
                <img src="{{ asset('frontend/images/homeAboutSmall.png') }}" alt="">
            @endif
        </div>
    </div>
    <div class="home-about-content">
        <h2 class="small-title">{{ __('nav.about') }}</h2>
        @if($homeAbout && $homeAbout->getTranslation('title', $locale))
            <h3 class="section-title">{{ $homeAbout->getTranslation('title', $locale) }}</h3>
        @endif
        @if($homeAbout && $homeAbout->getTranslation('content', $locale))
        <div class="description">
            {!! $homeAbout->getTranslation('content', $locale) !!}
        </div>
        @endif
        @php
            $aboutBtnText = $homeAbout ? $homeAbout->getTranslation('button_text', $locale) : '';
            $aboutBtnUrl  = ($homeAbout && $homeAbout->button_url) ? $homeAbout->button_url : route('about', $locale);
        @endphp
        <a href="{{ $aboutBtnUrl }}" class="more">
            <p>{{ $aboutBtnText ?: __('general.details') }}</p>
            <img src="{{ asset('frontend/icons/hammer.svg') }}" alt="">
        </a>
    </div>
</section>

{{-- TƏRƏFDAŞlar --}}
@if($partners->isNotEmpty())
<section class="parnters-container p-lr">
    <div class="partners-slide swiper">
        <div class="swiper-wrapper">
            @foreach($partners as $partner)
            <div class="partner-item swiper-slide">
                @if($partner->url)
                <a href="{{ $partner->url }}" target="_blank">
                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}">
                </a>
                @else
                <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}">
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- XİDMƏTLƏR --}}
@if($services->isNotEmpty())
<section class="home-services">
    <div class="home-services-container p-lr">
        <div class="home-services-head">
            <div class="head-left">
                <h2 class="small-title">{{ __('nav.services') }}</h2>
                <h3 class="section-title">{{ __('general.home_services_title') }}</h3>
            </div>
            <a href="{{ route('services.index', $locale) }}" class="more">
                {{ __('general.view_all') }}
                <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
            </a>
        </div>
        <div class="home-services-cards">
            @foreach($services as $service)
            <a href="{{ route('services.show', [$locale, $service->getTranslation('slug', $locale)]) }}" class="service-card">
                @if($service->icon)
                <div class="icon">
                    <img src="{{ Storage::url($service->icon) }}" alt="{{ $service->getTranslation('title', $locale) }}">
                </div>
                @endif
                <h2 class="service-name">{{ $service->getTranslation('title', $locale) }}</h2>
                <div class="description">
                    <p>{{ strip_tags($service->getTranslation('short_description', $locale)) }}</p>
                </div>
                <div class="more">
                    <p>{{ __('general.details') }}</p>
                    <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- BLOQ --}}
@if($blogs->isNotEmpty())
<section class="home-blog p-lr">
    <div class="home-blog-head">
        <div class="head-left">
            <h2 class="small-title">{{ __('nav.blog') }}</h2>
            <h3 class="section-title">{{ __('general.home_blog_title') }}</h3>
        </div>
        <a href="{{ route('blog.index', $locale) }}" class="more">
            {{ __('general.view_all') }}
            <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
        </a>
    </div>
    <div class="home-blog-slide swiper">
        <div class="swiper-wrapper">
            @foreach($blogs as $post)
            <a href="{{ route('blog.show', [$locale, $post->getTranslation('slug', $locale)]) }}" class="blog-card swiper-slide">
                <div class="card-image">
                    @if($post->cover_image)
                        <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->getTranslation('title', $locale) }}">
                    @else
                        <img src="{{ asset('frontend/images/blogCard1.png') }}" alt="">
                    @endif
                </div>
                <div class="card-body">
                    <h2 class="blog-name">{{ $post->getTranslation('title', $locale) }}</h2>
                    <div class="description">
                        <p>{{ $post->getTranslation('excerpt', $locale) }}</p>
                    </div>
                    <div class="card-body-bottom">
                        <div class="more">
                            <p>{{ __('general.details') }}</p>
                            <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
                        </div>
                        <p class="share-date">{{ $post->published_at?->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- PORTFOLİO --}}
@if($portfolio->isNotEmpty())
<section class="home-portfolio p-lr">
    <div class="home-portfolio-head">
        <div class="head-left">
            <h2 class="small-title">{{ __('nav.portfolio') }}</h2>
            <h3 class="section-title">{{ __('general.home_portfolio_title') }}</h3>
        </div>
        <a href="{{ route('portfolio.index', $locale) }}" class="more">
            {{ __('general.view_all') }}
            <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
        </a>
    </div>
    <div class="home-portfolio-items">
        @foreach($portfolio as $item)
        <div class="home-portfolio-item">
            @if($item->image)
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->getTranslation('title', $locale) }}" class="portfolio-image">
            @else
                <img src="{{ asset('frontend/images/homePortfolio1.png') }}" alt="" class="portfolio-image">
            @endif
            <button class="portfolioItemBtn" type="button">
                <img src="{{ asset('frontend/icons/plus.svg') }}" alt="">
            </button>
            <div class="item-content">
                <h2 class="portfolio-title">{{ $item->getTranslation('title', $locale) }}</h2>
                <div class="description">
                    <p>{{ $item->getTranslation('short_description', $locale) }}</p>
                </div>
                <a href="{{ route('portfolio.show', [$locale, $item->getTranslation('slug', $locale)]) }}" class="more">
                    <p>{{ __('general.details') }}</p>
                    <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- SİFARİŞ CTA --}}
@php
    $ctaTitle   = $homeCta ? $homeCta->getTranslation('title', $locale) : '';
    $ctaDesc    = $homeCta ? $homeCta->getTranslation('description', $locale) : '';
    $ctaBtnText = $homeCta ? $homeCta->getTranslation('button_text', $locale) : '';
    $ctaBtnUrl  = ($homeCta && $homeCta->button_url) ? $homeCta->button_url : route('contact', $locale);
@endphp
<section class="home-order-container p-lr">
    <div class="home-order">
        <div class="home-order-content">
            <h2 class="section-title">{{ $ctaTitle ?: __('general.home_cta_fallback') }}</h2>
            @if($ctaDesc)
            <div class="description">
                <p>{{ $ctaDesc }}</p>
            </div>
            @endif
            <a href="{{ $ctaBtnUrl }}" class="more">
                <p>{{ $ctaBtnText ?: __('general.order_now') }}</p>
                <img src="{{ asset('frontend/icons/hammer.svg') }}" alt="">
            </a>
        </div>
        <div class="home-order-image">
            @if($homeCta && $homeCta->image)
                <img src="{{ Storage::url($homeCta->image) }}" class="order-image" alt="">
            @else
                <img src="{{ asset('frontend/images/homeOrder.svg') }}" class="order-image" alt="">
            @endif
            <div class="glassBall"></div>
        </div>
    </div>
</section>

{{-- RƏYLƏr --}}
@if($testimonials->isNotEmpty())
<section class="review-container p-lr">
    <div class="review-head">
        <div class="head-left">
            <h2 class="small-title">{{ __('general.reviews') }}</h2>
            <h3 class="section-title">{{ __('general.reviews_subtitle') }}</h3>
        </div>
    </div>
    <div class="review-slide swiper">
        <div class="swiper-wrapper">
            @foreach($testimonials as $testimonial)
            <div class="review-item swiper-slide">
                <div class="review-item-head">
                    <div class="review-image">
                        @if($testimonial->photo)
                            <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->customer_name }}">
                        @else
                            <img src="{{ asset('frontend/images/reviewImg1.png') }}" alt="">
                        @endif
                    </div>
                    <div class="review-info">
                        <h2 class="owner-name">{{ $testimonial->customer_name }}</h2>
                        <p class="owner-position">{{ $testimonial->getTranslation('position', $locale) }}</p>
                    </div>
                </div>
                <div class="description">
                    <p>"{{ $testimonial->getTranslation('review_text', $locale) }}"</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
// Hero Slider
@if($sliders->count() > 1)
new Swiper('.hero-swiper', {
    slidesPerView: 1,
    loop: true,
    speed: 800,
    autoplay: { delay: 5000, disableOnInteraction: false },
    pagination: { el: '.hero-pagination', clickable: true },
    navigation: { nextEl: '.hero-next', prevEl: '.hero-prev' },
});
@endif

// Partnyorlar
@if($partners->isNotEmpty())
new Swiper('.partners-slide', {
    slidesPerView: 2,
    spaceBetween: 16,
    loop: {{ $partners->count() > 4 ? 'true' : 'false' }},
    speed: 600,
    autoplay: { delay: 2500, disableOnInteraction: false },
    breakpoints: {
        576: { slidesPerView: 3 },
        768: { slidesPerView: 4 },
        992: { slidesPerView: 5 },
        1200: { slidesPerView: 6 },
    },
});
@endif

// Blog
@if($blogs->count() > 1)
new Swiper('.home-blog-slide', {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: {{ $blogs->count() > 2 ? 'true' : 'false' }},
    speed: 600,
    autoplay: { delay: 4000, disableOnInteraction: false },
    breakpoints: {
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
    },
});
@endif

// Rəylər
@if($testimonials->count() > 1)
new Swiper('.review-slide', {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: {{ $testimonials->count() > 2 ? 'true' : 'false' }},
    speed: 600,
    autoplay: { delay: 4500, disableOnInteraction: false },
    navigation: { nextEl: '.review-slide .swiper-button-next', prevEl: '.review-slide .swiper-button-prev' },
    breakpoints: {
        768: { slidesPerView: 2 },
        1200: { slidesPerView: 3 },
    },
});
@endif
</script>
@endpush
