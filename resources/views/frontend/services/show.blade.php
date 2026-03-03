@extends('frontend.layouts.app')

@section('title', $service->getTranslation('meta_title', $locale) ?: $service->getTranslation('title', $locale))
@section('meta_description', $service->getTranslation('meta_description', $locale))
@section('meta_keywords', $service->getTranslation('meta_keywords', $locale))
@php $_svcImg = ($service->images && count($service->images) > 0) ? $service->images[0] : $service->image; @endphp
@if($_svcImg)
@section('og_image'){{ \Illuminate\Support\Facades\Storage::url($_svcImg) }}@endsection
@endif

@section('content')

<section class="service-detail-container p-lr">

    {{-- Breadcrumb --}}
    <div class="breadCrumb">
        <a href="{{ route('home', $locale) }}" class="breadCrumb-item">{{ __('nav.home') }}</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightGrey.svg') }}" alt="">
        </div>
        <a href="{{ route('services.index', $locale) }}" class="breadCrumb-item">{{ __('nav.services') }}</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightOrange2.svg') }}" alt="">
        </div>
        <p class="breadCrumb-item active">{{ $service->getTranslation('title', $locale) }}</p>
    </div>

    {{-- Hero --}}
    <div class="service-detail-hero">
        @php $images = $service->images ?? []; @endphp

        <div class="service-detail-image-slide swiper">
            <div class="swiper-wrapper">
                @if(!empty($images))
                    @foreach($images as $img)
                    <div class="swiper-slide detail-image">
                        <img src="{{ Storage::url($img) }}" alt="{{ $service->getTranslation('title', $locale) }}">
                    </div>
                    @endforeach
                @elseif($service->image)
                    <div class="swiper-slide detail-image">
                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->getTranslation('title', $locale) }}">
                    </div>
                @else
                    <div class="swiper-slide detail-image">
                        <img src="{{ asset('frontend/images/service-detail1.png') }}" alt="">
                    </div>
                @endif
            </div>
            @if(count($images) > 1)
            <div class="swiper-pagination"></div>
            @endif
        </div>

        <div class="hero-content">
            <h1 class="hero-title">{{ $service->getTranslation('title', $locale) }}</h1>
            <div class="hero-links">
                <a href="{{ route('contact', $locale) }}" class="order-link">
                    <p>{{ __('general.order_now') }}</p>
                    <img src="{{ asset('frontend/icons/hammer.svg') }}" alt="">
                </a>
                @php $phone = \App\Models\Setting::get('phone', ''); @endphp
                @if($phone)
                <a href="tel:{{ $phone }}" class="contact-link">
                    <p>{{ __('general.contact_link') }}</p>
                    <img src="{{ asset('frontend/icons/phoneWhite.svg') }}" alt="">
                </a>
                @php $wp = \App\Models\Setting::get('whatsapp', $phone); @endphp
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wp) }}" target="_blank" class="wp">
                    <img src="{{ asset('frontend/icons/wp.svg') }}" alt="">
                    <p>{{ __('general.whatsapp') }}</p>
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Üstünlüklər --}}
    @php
        $advantages = $service->getAdvantages($locale);
        $advIcons = ['clockOrange.svg', 'walletOrange.svg', 'palletOrange.svg', 'medalOrange.svg'];
        $advantages = array_filter($advantages);
    @endphp
    @if(!empty($advantages))
    <div class="service-advantages">
        @foreach($advantages as $i => $adv)
        <div class="advantage-item">
            <div class="icon">
                <img src="{{ asset('frontend/icons/' . ($advIcons[$i] ?? 'clockOrange.svg')) }}" alt="">
            </div>
            <div class="item-text">
                <p>{{ $adv }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Məzmun --}}
    @if($service->getTranslation('content', $locale))
    <div class="service-detail-description">
        @if($service->getTranslation('short_description', $locale))
        <div class="description-title">
            {!! $service->getTranslation('short_description', $locale) !!}
        </div>
        @endif
        <div class="description">
            {!! $service->getTranslation('content', $locale) !!}
        </div>
    </div>
    @endif

</section>

{{-- Addımlar --}}
@php $steps = $service->getSteps(); @endphp
@if(!empty($steps) && $service->getTranslation('steps_title', $locale))
<section class="service-step">
    <div class="service-step-container p-lr">
        <h2 class="section-title">{{ $service->getTranslation('steps_title', $locale) }}</h2>
        @if($service->getTranslation('steps_subtitle', $locale))
        <div class="sub-title">
            <p>{{ $service->getTranslation('steps_subtitle', $locale) }}</p>
        </div>
        @endif
        <div class="service-steps">
            @foreach($steps as $i => $step)
            <div class="step-item">
                <span class="step-count">{{ $i + 1 }}.</span>
                @if(!empty($step['image']))
                <div class="step-image">
                    <img src="{{ Storage::url($step['image']) }}" alt="">
                </div>
                @endif
                <div class="step-body">
                    <h3 class="step-title">{{ $step['title'][$locale] ?? $step['title']['az'] ?? '' }}</h3>
                    <div class="description">
                        {!! $step['description'][$locale] ?? $step['description']['az'] ?? '' !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
@if(!empty($images) && count($images) > 1)
<script>
new Swiper('.service-detail-image-slide', {
    slidesPerView: 1,
    loop: true,
    speed: 600,
    autoplay: { delay: 4000, disableOnInteraction: false },
    pagination: { el: '.service-detail-image-slide .swiper-pagination', clickable: true },
});
</script>
@endif
@endpush

@endsection

@push('schema')
@php
    $_serviceLD = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => $service->getTranslation('title', $locale),
        'description' => Str::limit(strip_tags($service->getTranslation('short_description', $locale) ?? ''), 160),
        'provider'    => ['@type' => 'LocalBusiness', 'name' => \App\Models\Setting::get('site_name', '166 Usta'), 'url' => url($locale)],
        'url'         => url()->current(),
        'inLanguage'  => $locale,
    ];
    if ($service->cover_image) $_serviceLD['image'] = ['@type' => 'ImageObject', 'url' => \Illuminate\Support\Facades\Storage::url($service->cover_image)];
    $_breadcrumbLD = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => __('nav.home'),     'item' => url($locale)],
            ['@type' => 'ListItem', 'position' => 2, 'name' => __('nav.services'),'item' => route('services.index', $locale)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $service->getTranslation('title', $locale), 'item' => url()->current()],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($_serviceLD,    JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($_breadcrumbLD, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
