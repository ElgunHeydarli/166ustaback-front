@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta') . ' — ' . __('nav.boxes'))
@section('meta_description', \App\Models\Setting::get('meta_description', ''))

@section('content')

<section class="boxes-container p-lr">
    <div class="banner">
        <h1 class="banner-title">{{ __('nav.boxes') }}</h1>
        <img src="{{ asset('frontend/images/headBanner.png') }}" alt="">
    </div>

    @if($boxes->isNotEmpty())
    <div class="all-boxes">
        @foreach($boxes as $box)
        <a href="{{ route('boxes.show', [$locale, $box->getTranslation('slug', $locale)]) }}" class="box-card">
            <div class="card-image">
                @if($box->cover_image)
                    <img src="{{ Storage::url($box->cover_image) }}" alt="{{ $box->getTranslation('title', $locale) }}">
                @else
                    <img src="{{ asset('frontend/images/box1.png') }}" alt="">
                @endif
            </div>
            <div class="card-body">
                @if($box->getTranslation('category', $locale))
                <h2 class="box-category">{{ $box->getTranslation('category', $locale) }}</h2>
                @endif
                <h3 class="box-name">{{ $box->getTranslation('title', $locale) }}</h3>
                @if($box->price)
                <p class="box-price">{{ number_format($box->price, 0) }} ₼</p>
                @endif
                <span class="more">{{ __('general.details') }}</span>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div style="text-align:center;padding:80px 0;color:#999;">
        <p style="font-size:1.1rem;">{{ __('general.no_boxes') }}</p>
    </div>
    @endif
</section>

@endsection
