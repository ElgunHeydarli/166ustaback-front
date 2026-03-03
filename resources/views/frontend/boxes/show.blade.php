@extends('frontend.layouts.app')

@section('title', $box->getTranslation('meta_title', $locale) ?: $box->getTranslation('title', $locale))
@section('meta_description', $box->getTranslation('meta_description', $locale))
@section('meta_keywords', $box->getTranslation('meta_keywords', $locale))
@if($box->cover_image)
@section('og_image'){{ \Illuminate\Support\Facades\Storage::url($box->cover_image) }}@endsection
@endif

@section('content')

<section class="box-detail-container p-lr">

    {{-- Breadcrumb --}}
    <div class="breadCrumb">
        <a href="{{ route('home', $locale) }}" class="breadCrumb-item">Ana səhifə</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightGrey.svg') }}" alt="">
        </div>
        <a href="{{ route('boxes.index', $locale) }}" class="breadCrumb-item">Qutular</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightOrange2.svg') }}" alt="">
        </div>
        <p class="breadCrumb-item active">{{ $box->getTranslation('title', $locale) }}</p>
    </div>

    {{-- Main Detail --}}
    <div class="box-detail-main">
        <div class="box-image">
            @if($box->cover_image)
                <img src="{{ Storage::url($box->cover_image) }}" alt="{{ $box->getTranslation('title', $locale) }}">
            @else
                <img src="{{ asset('frontend/images/box1.png') }}" alt="">
            @endif
        </div>
        <div class="detail-right">
            <div class="box-info">
                @if($box->getTranslation('category', $locale))
                <h2 class="box-category">{{ $box->getTranslation('category', $locale) }}</h2>
                @endif
                <h3 class="box-name">{{ $box->getTranslation('title', $locale) }}</h3>
                @if($box->getTranslation('short_description', $locale))
                <div class="box-notification">
                    <p>{{ strip_tags($box->getTranslation('short_description', $locale)) }}</p>
                </div>
                @endif
            </div>
            @if($box->price)
            <div class="price-box">
                <div class="price-box-left">
                    <span>Qiymət</span>
                    <p class="price">{{ number_format($box->price, 0) }} ₼</p>
                </div>
                <div class="counter">
                    <button class="decrease" type="button">
                        <img src="{{ asset('frontend/icons/minus.svg') }}" alt="">
                    </button>
                    <p class="counter-value">1</p>
                    <button class="increase" type="button">
                        <img src="{{ asset('frontend/icons/plus2.svg') }}" alt="">
                    </button>
                </div>
            </div>
            @endif
            @php
                $phone = \App\Models\Setting::get('phone', '');
                $wp = \App\Models\Setting::get('whatsapp', $phone);
            @endphp
            @if($phone)
            <div class="detail-contact">
                <a href="tel:{{ $phone }}" class="call">
                    <p>Əlaqə saxla</p>
                    <img src="{{ asset('frontend/icons/phoneWhite.svg') }}" alt="">
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wp) }}" target="_blank" class="wp">
                    <img src="{{ asset('frontend/icons/wp.svg') }}" alt="">
                    <p>Whatsapp ilə sifariş</p>
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Description --}}
    @if($box->getTranslation('content', $locale))
    <div class="box-detail-description">
        <h2 class="description-title">Ümumi məlumat</h2>
        <div class="description">
            {!! $box->getTranslation('content', $locale) !!}
        </div>
    </div>
    @endif

</section>

@endsection

@push('schema')
@php
    $_boxLD = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $box->getTranslation('title', $locale),
        'description' => Str::limit(strip_tags($box->getTranslation('short_description', $locale) ?? ''), 160),
        'url'         => url()->current(),
        'brand'       => ['@type' => 'Brand', 'name' => \App\Models\Setting::get('site_name', '166 Usta')],
    ];
    if ($box->cover_image) $_boxLD['image'] = ['@type' => 'ImageObject', 'url' => \Illuminate\Support\Facades\Storage::url($box->cover_image)];
    if ($box->price) $_boxLD['offers'] = ['@type' => 'Offer', 'price' => (string)$box->price, 'priceCurrency' => 'AZN', 'availability' => 'https://schema.org/InStock'];
    $_breadcrumbLD = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Ana səhifə', 'item' => url($locale)],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Qutular',    'item' => route('boxes.index', $locale)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $box->getTranslation('title', $locale), 'item' => url()->current()],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($_boxLD,        JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($_breadcrumbLD, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
