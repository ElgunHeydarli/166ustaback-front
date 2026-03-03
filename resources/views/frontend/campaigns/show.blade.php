@extends('frontend.layouts.app')

@section('title', $campaign->getTranslation('meta_title', $locale) ?: $campaign->getTranslation('title', $locale))
@section('meta_description', $campaign->getTranslation('meta_description', $locale))
@section('meta_keywords', $campaign->getTranslation('meta_keywords', $locale))
@if($campaign->cover_image)
@section('og_image'){{ \Illuminate\Support\Facades\Storage::url($campaign->cover_image) }}@endsection
@endif

@section('content')

<section class="special-campaing-detail-container p-lr">

    {{-- Breadcrumb --}}
    <div class="breadCrumb">
        <a href="{{ route('home', $locale) }}" class="breadCrumb-item">{{ __('nav.home') }}</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightGrey.svg') }}" alt="">
        </div>
        <a href="{{ route('campaigns.index', $locale) }}" class="breadCrumb-item">{{ __('nav.campaigns') }}</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightOrange2.svg') }}" alt="">
        </div>
        <p class="breadCrumb-item active">{{ $campaign->getTranslation('title', $locale) }}</p>
    </div>

    {{-- Head --}}
    <div class="special-campaing-detail-head">
        <h1 class="page-title">{{ $campaign->getTranslation('title', $locale) }}</h1>
        <div class="header-right">
            @php $date = $campaign->starts_at ?? $campaign->created_at; @endphp
            @if($date)
            <div class="create-date">
                <div class="icon">
                    <img src="{{ asset('frontend/icons/calendarOrange.svg') }}" alt="">
                </div>
                <p>{{ $date->translatedFormat('d F Y') }}</p>
            </div>
            @endif
            <div class="share">
                <button class="share-btn" type="button">
                    <img src="{{ asset('frontend/icons/shareOrange.svg') }}" alt="">
                    <p>{{ __('general.share') }}</p>
                </button>
                <div class="shareList">
                    <button class="shareItem copyUrl">
                        <img src="{{ asset('frontend/icons/pin_colored.svg') }}" alt="">
                        {{ __('general.copy_link') }}
                    </button>
                    <a href="https://wa.me/?text={{ urlencode(request()->url()) }}" target="_blank" class="shareItem">
                        <img src="{{ asset('frontend/icons/wp_colored.svg') }}" alt="">
                        WhatsApp
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}" target="_blank" class="shareItem">
                        <img src="{{ asset('frontend/icons/tg_colored.svg') }}" alt="">
                        Telegram
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="shareItem">
                        <img src="{{ asset('frontend/icons/fb_colored.svg') }}" alt="">
                        Facebook
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" class="shareItem">
                        <img src="{{ asset('frontend/icons/insta_colored.svg') }}" alt="">
                        Instagram
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cover Image --}}
    @if($campaign->cover_image)
    <div class="special-campaing-image">
        <img src="{{ Storage::url($campaign->cover_image) }}" alt="{{ $campaign->getTranslation('title', $locale) }}">
    </div>
    @endif

    {{-- Description --}}
    @if($campaign->getTranslation('content', $locale))
    <div class="special-campaing-detail-description">
        <h2 class="description-title">{{ __('general.general_info') }}</h2>
        <div class="description">
            {!! $campaign->getTranslation('content', $locale) !!}
        </div>
    </div>
    @endif

</section>

@push('scripts')
<script>
document.querySelector('.copyUrl')?.addEventListener('click', function() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        alert('{{ __('general.link_copied') }}');
    });
});
</script>
@endpush

@endsection

@push('schema')
@php
    $_campaignLD = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Offer',
        'name'        => $campaign->getTranslation('title', $locale),
        'description' => Str::limit(strip_tags($campaign->getTranslation('short_description', $locale) ?? ''), 160),
        'url'         => url()->current(),
        'inLanguage'  => $locale,
        'seller'      => ['@type' => 'Organization', 'name' => \App\Models\Setting::get('site_name', '166 Usta'), 'url' => url($locale)],
    ];
    if ($campaign->cover_image) $_campaignLD['image'] = ['@type' => 'ImageObject', 'url' => \Illuminate\Support\Facades\Storage::url($campaign->cover_image)];
    $_breadcrumbLD = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => __('nav.home'),      'item' => url($locale)],
            ['@type' => 'ListItem', 'position' => 2, 'name' => __('nav.campaigns'), 'item' => route('campaigns.index', $locale)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $campaign->getTranslation('title', $locale), 'item' => url()->current()],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($_campaignLD,   JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($_breadcrumbLD, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
