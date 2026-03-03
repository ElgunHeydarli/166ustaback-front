@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta') . ' — Özəl kampaniyalar')
@section('meta_description', \App\Models\Setting::get('meta_description', ''))

@section('content')

<section class="all-special-campaing-container p-lr">
    <div class="banner">
        <h1 class="banner-title">Özəl kampaniyalar</h1>
        <img src="{{ asset('frontend/images/headBanner.png') }}" alt="">
    </div>

    @if($campaigns->isNotEmpty())
    <div class="all-special-campaing">
        @foreach($campaigns as $campaign)
        <a href="{{ route('campaigns.show', [$locale, $campaign->getTranslation('slug', $locale)]) }}" class="special-campaing-card">
            <div class="card-image">
                @if($campaign->cover_image)
                    <img src="{{ Storage::url($campaign->cover_image) }}" alt="{{ $campaign->getTranslation('title', $locale) }}">
                @else
                    <img src="{{ asset('frontend/images/special-campaing1.png') }}" alt="">
                @endif
            </div>
            <div class="card-body">
                <h2 class="special-campaing-name">{{ $campaign->getTranslation('title', $locale) }}</h2>
                <div class="card-body-bottom">
                    <div class="more">
                        <p>Ətraflı</p>
                        <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
                    </div>
                    @php $date = $campaign->starts_at ?? $campaign->created_at; @endphp
                    <p class="share-date">{{ $date ? $date->translatedFormat('d F Y') : '' }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div style="text-align:center;padding:80px 0;color:#999;">
        <p style="font-size:1.1rem;">Hələ kampaniya yoxdur.</p>
    </div>
    @endif
</section>

@endsection
