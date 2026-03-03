@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta') . ' — Haqqımızda')
@section('meta_description', \App\Models\Setting::get('meta_description', ''))

@section('content')

{{-- Banner --}}
<section class="about-container p-lr">
    <div class="banner">
        <h1 class="banner-title">Haqqımızda</h1>
        <img src="{{ asset('frontend/images/headBanner.png') }}" alt="">
    </div>
</section>

{{-- Home About --}}
@if($about)
<section class="home-about p-lr">
    <div class="home-about-images">
        <div class="image-large">
            @if($about->image1)
                <img src="{{ Storage::url($about->image1) }}" alt="">
            @else
                <img src="{{ asset('frontend/images/homeAboutLarge.png') }}" alt="">
            @endif
        </div>
        <div class="image-small">
            @if($about->image2)
                <img src="{{ Storage::url($about->image2) }}" alt="">
            @else
                <img src="{{ asset('frontend/images/homeAboutSmall.png') }}" alt="">
            @endif
        </div>
    </div>
    <div class="home-about-content">
        <h2 class="small-title">Haqqımızda</h2>
        @if($about->getTranslation('title', $locale))
        <h3 class="section-title">{{ $about->getTranslation('title', $locale) }}</h3>
        @endif
        @if($about->getTranslation('content', $locale))
        <div class="description">
            {!! $about->getTranslation('content', $locale) !!}
        </div>
        @endif
    </div>
</section>
@endif

{{-- Partners --}}
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

{{-- Why Us --}}
@if($whyUs)
@php
    $whyUsItems = collect($whyUs->items ?? [])->filter(fn($item) =>
        !empty($item['title'][$locale] ?? $item['title']['az'] ?? null)
    )->values();
@endphp
@if($whyUsItems->isNotEmpty())
<section class="why-us-wrapper">
    <div class="why-us">
        <div class="why-us-container p-lr">
            @if($whyUs->getTranslation('title', $locale))
            <h2 class="section-title">{{ $whyUs->getTranslation('title', $locale) }}</h2>
            @endif
            @if($whyUs->getTranslation('subtitle', $locale))
            <div class="sub-title">
                <p>{{ $whyUs->getTranslation('subtitle', $locale) }}</p>
            </div>
            @endif

            {{-- Desktop version --}}
            <div class="why-us-main">
                <div class="line-indicator">
                    <div class="line-track">
                        <div class="line-dot"></div>
                    </div>
                </div>
                <div class="swiper why-us-content-slide">
                    <div class="swiper-wrapper">
                        @foreach($whyUsItems as $item)
                        <div class="swiper-slide content-item">
                            <div class="content-inner">
                                <h3 class="content-title">{{ $item['title'][$locale] ?? $item['title']['az'] ?? '' }}</h3>
                                <div class="description">
                                    {!! $item['description'][$locale] ?? $item['description']['az'] ?? '' !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="why-us-images">
                    <div thumbsSlider="" class="swiper why-us-images-slide">
                        <div class="swiper-wrapper">
                            @foreach($whyUsItems as $item)
                            <div class="swiper-slide why-us-image-item">
                                @if(!empty($item['image']))
                                    <img src="{{ Storage::url($item['image']) }}" alt="">
                                @else
                                    <img src="{{ asset('frontend/images/whyUs1.png') }}" alt="">
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile version --}}
            <div class="mobile-why-us-slide swiper">
                <div class="swiper-wrapper">
                    @foreach($whyUsItems as $item)
                    <div class="mobile-why-us-item swiper-slide">
                        <div class="item-image">
                            @if(!empty($item['image']))
                                <img src="{{ Storage::url($item['image']) }}" alt="">
                            @else
                                <img src="{{ asset('frontend/images/whyUs1.png') }}" alt="">
                            @endif
                        </div>
                        <h3 class="item-title">{{ $item['title'][$locale] ?? $item['title']['az'] ?? '' }}</h3>
                        <div class="description">
                            {!! $item['description'][$locale] ?? $item['description']['az'] ?? '' !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endif

{{-- Testimonials --}}
@if($testimonials->isNotEmpty())
<section class="review-container p-lr">
    <div class="review-head">
        <div class="head-left">
            <h2 class="small-title">Rəylər</h2>
            <h3 class="section-title">Bizə Güvənənlərin Rəyləri</h3>
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
                    <p>{{ $testimonial->getTranslation('review_text', $locale) }}</p>
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
