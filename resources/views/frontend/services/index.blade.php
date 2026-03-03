@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta') . ' — ' . __('nav.services'))
@section('meta_description', \App\Models\Setting::get('meta_description', ''))

@section('content')

<section class="all-service-container p-lr">
    <div class="banner">
        <h1 class="banner-title">{{ __('nav.services') }}</h1>
        <img src="{{ asset('frontend/images/headBanner.png') }}" alt="">
    </div>

    @if($services->isNotEmpty())
    <div class="all-services">
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
                <p>Ətraflı</p>
                <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div style="text-align:center;padding:80px 0;color:#999;">
        <p style="font-size:1.1rem;">Hələ xidmət yoxdur.</p>
    </div>
    @endif
</section>

@endsection
