@extends('frontend.layouts.app')

@section('title', $item->getTranslation('meta_title', $locale) ?: $item->getTranslation('title', $locale))
@section('meta_description', $item->getTranslation('meta_description', $locale))
@section('meta_keywords', $item->getTranslation('meta_keywords', $locale))
@if($item->cover_image)
@section('og_image'){{ \Illuminate\Support\Facades\Storage::url($item->cover_image) }}@endsection
@endif

@section('content')

<section class="portfolio-detail-container p-lr">

    {{-- Breadcrumb --}}
    <div class="breadCrumb">
        <a href="{{ route('home', $locale) }}" class="breadCrumb-item">Ana səhifə</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightGrey.svg') }}" alt="">
        </div>
        <a href="{{ route('portfolio.index', $locale) }}" class="breadCrumb-item">Portfolio</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightOrange2.svg') }}" alt="">
        </div>
        <p class="breadCrumb-item active">{{ $item->getTranslation('title', $locale) }}</p>
    </div>

    {{-- Head --}}
    <div class="portfolio-detail-head">
        <h1 class="page-title">{{ $item->getTranslation('title', $locale) }}</h1>
        <div class="header-right">
            <div class="create-date">
                <div class="icon">
                    <img src="{{ asset('frontend/icons/calendarOrange.svg') }}" alt="">
                </div>
                <p>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</p>
            </div>
            <div class="share">
                <button class="share-btn" type="button">
                    <img src="{{ asset('frontend/icons/shareOrange.svg') }}" alt="">
                    <p>Paylaş</p>
                </button>
                <div class="shareList">
                    <button class="shareItem copyUrl" onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Link kopyalandı!'))">
                        <img src="{{ asset('frontend/icons/pin_colored.svg') }}" alt="">
                        Linki kopyala
                    </button>
                    @php $shareUrl = urlencode(request()->url()); @endphp
                    <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank" class="shareItem">
                        <img src="{{ asset('frontend/icons/wp_colored.svg') }}" alt="">
                        WhatsApp
                    </a>
                    <a href="https://t.me/share/url?url={{ $shareUrl }}" target="_blank" class="shareItem">
                        <img src="{{ asset('frontend/icons/tg_colored.svg') }}" alt="">
                        Telegram
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" class="shareItem">
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

    {{-- Cover image + short info --}}
    <div class="portfolio-detail-image">
        @if($item->cover_image)
            <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->getTranslation('title', $locale) }}">
        @else
            <img src="{{ asset('frontend/images/portfolio1.jpg') }}" alt="{{ $item->getTranslation('title', $locale) }}">
        @endif
        <div class="short-info-box">
            @if($item->client)
            <div class="short-info-item">
                <span>Müştəri:</span>
                <p>{{ $item->client }}</p>
            </div>
            @endif
            @if($item->duration)
            <div class="short-info-item">
                <span>Müddət:</span>
                <p>{{ $item->duration }}</p>
            </div>
            @endif
            @if($item->service)
            <div class="short-info-item">
                <span>Kateqoriya:</span>
                <p>{{ $item->service->getTranslation('title', $locale) }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Description --}}
    @if($item->getTranslation('content', $locale))
    <div class="portfolio-detail-description">
        <h2 class="description-title">Ümumi məlumat</h2>
        <div class="description">
            {!! $item->getTranslation('content', $locale) !!}
        </div>
    </div>
    @endif

    {{-- Gallery --}}
    @php $gallery = $item->gallery ?? []; @endphp
    @if(count($gallery) > 0)
    <div class="portfolio-gallery">
        @foreach(array_slice($gallery, 0, 4) as $index => $img)
        <a href="{{ Storage::url($img) }}" class="portfolio-gallery-item">
            <img src="{{ Storage::url($img) }}" alt="">
            @if($index === 3 && count($gallery) > 4)
            <div class="view-all">
                <p>Hamısına bax</p>
                <img src="{{ asset('frontend/icons/rightWhite.svg') }}" alt="">
            </div>
            @endif
        </a>
        @endforeach
    </div>

    {{-- Hidden fancybox gallery links --}}
    <div class="hidden-images">
        @foreach($gallery as $img)
        <a href="{{ Storage::url($img) }}" data-fancybox="gallery"></a>
        @endforeach
    </div>
    @endif

</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css">
<script>
Fancybox.bind("[data-fancybox='gallery']", {
    Thumbs: { autoStart: true },
});

document.querySelectorAll('.portfolio-gallery-item').forEach(function(el, index) {
    el.addEventListener('click', function(e) {
        e.preventDefault();
        var hiddenLinks = document.querySelectorAll(".hidden-images [data-fancybox='gallery']");
        if (hiddenLinks[index]) hiddenLinks[index].click();
    });
});
</script>
@endpush

@push('schema')
@php
    $_portfolioLD = [
        '@context'    => 'https://schema.org',
        '@type'       => 'CreativeWork',
        'name'        => $item->getTranslation('title', $locale),
        'description' => Str::limit(strip_tags($item->getTranslation('short_description', $locale) ?? ''), 160),
        'url'         => url()->current(),
        'inLanguage'  => $locale,
        'dateCreated' => $item->created_at->toIso8601String(),
    ];
    if ($item->cover_image) $_portfolioLD['image']  = ['@type' => 'ImageObject', 'url' => \Illuminate\Support\Facades\Storage::url($item->cover_image)];
    if ($item->client)      $_portfolioLD['author'] = ['@type' => 'Organization', 'name' => $item->client];
    $_breadcrumbLD = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Ana səhifə', 'item' => url($locale)],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Portfolio',  'item' => route('portfolio.index', $locale)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $item->getTranslation('title', $locale), 'item' => url()->current()],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($_portfolioLD,  JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($_breadcrumbLD, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
