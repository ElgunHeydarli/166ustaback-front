@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta') . ' — Bloq')
@section('meta_description', \App\Models\Setting::get('meta_description', ''))

@section('content')

<section class="all-blog-container p-lr">
    <div class="banner">
        <h1 class="banner-title">{{ __('nav.blog') }}</h1>
        <img src="{{ asset('frontend/images/headBanner.png') }}" alt="">
    </div>

    @if($blogs->isNotEmpty())
    <div class="all-blogs">
        @foreach($blogs as $post)
        <a href="{{ route('blog.show', [$locale, $post->getTranslation('slug', $locale)]) }}" class="blog-card">
            <div class="card-image">
                @if($post->cover_image)
                    <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->getTranslation('title', $locale) }}">
                @else
                    <img src="{{ asset('frontend/images/blogCard1.png') }}" alt="">
                @endif
            </div>
            <div class="card-body">
                <h2 class="blog-name">{{ $post->getTranslation('title', $locale) }}</h2>
                @if($post->getTranslation('excerpt', $locale))
                <div class="description">
                    <p>{{ Str::limit(strip_tags($post->getTranslation('excerpt', $locale)), 100) }}</p>
                </div>
                @endif
                <div class="card-body-bottom">
                    <div class="more">
                        <p>Ətraflı</p>
                        <img src="{{ asset('frontend/icons/arrowRightOrange.svg') }}" alt="">
                    </div>
                    <p class="share-date">{{ $post->published_at?->translatedFormat('d F Y') ?? $post->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    @if($blogs->hasPages())
    <div class="pagination">
        {{ $blogs->links('pagination::simple-bootstrap-5') }}
    </div>
    @endif

    @else
    <div style="text-align:center;padding:80px 0;color:#999;">
        @if($search)
        <p style="font-size:1.1rem;">"{{ $search }}" üzrə nəticə tapılmadı.</p>
        @else
        <p style="font-size:1.1rem;">Hələ bloq yazısı yoxdur.</p>
        @endif
    </div>
    @endif

</section>

@endsection

@push('head_links')
@if($blogs->previousPageUrl())
<link rel="prev" href="{{ $blogs->previousPageUrl() }}">
@endif
@if($blogs->nextPageUrl())
<link rel="next" href="{{ $blogs->nextPageUrl() }}">
@endif
@endpush
