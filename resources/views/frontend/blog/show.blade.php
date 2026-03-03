@extends('frontend.layouts.app')

@section('title', $post->getTranslation('meta_title', $locale) ?: $post->getTranslation('title', $locale))
@section('meta_description', $post->getTranslation('meta_description', $locale))
@section('meta_keywords', $post->getTranslation('meta_keywords', $locale))
@section('og_type', 'article')
@if($post->cover_image)
@section('og_image'){{ \Illuminate\Support\Facades\Storage::url($post->cover_image) }}@endsection
@endif

@push('og_extras')
<meta property="article:published_time" content="{{ ($post->published_at ?? $post->created_at)->toIso8601String() }}">
<meta property="article:modified_time"  content="{{ $post->updated_at->toIso8601String() }}">
@endpush

@section('content')

<section class="blog-detail-container p-lr">

    <div class="breadCrumb">
        <a href="{{ route('home', $locale) }}" class="breadCrumb-item">{{ __('nav.home') }}</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightGrey.svg') }}" alt="">
        </div>
        <a href="{{ route('blog.index', $locale) }}" class="breadCrumb-item">{{ __('nav.blog') }}</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightOrange2.svg') }}" alt="">
        </div>
        <p class="breadCrumb-item active">{{ Str::limit($post->getTranslation('title', $locale), 60) }}</p>
    </div>

    <div class="blog-detail">

        {{-- Əsas Məzmun --}}
        <div class="blog-detail-main">
            @if($post->cover_image)
            <div class="blog-image">
                <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->getTranslation('title', $locale) }}">
            </div>
            @endif

            <p class="share-date">{{ $post->published_at?->translatedFormat('d F Y') ?? $post->created_at->translatedFormat('d F Y') }}</p>

            <h1 class="blog-title">{{ $post->getTranslation('title', $locale) }}</h1>

            <div class="blog-text">
                {!! $post->getTranslation('content', $locale) !!}
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="blog-detail-aside">

            {{-- Axtarış --}}
            <div class="blog-search">
                <h2 class="blog-search-title">{{ __('general.search') }}</h2>
                <form action="{{ route('blog.index', $locale) }}" method="GET" class="blog-search-form">
                    <input type="text" name="search" placeholder="{{ __('general.search_placeholder') }}">
                    <button class="searchBlogBtn" type="submit">
                        <img src="{{ asset('frontend/icons/searchOrange.svg') }}" alt="">
                    </button>
                </form>
            </div>

            {{-- Ən son bloqlar --}}
            @if($recentPosts->isNotEmpty())
            <div class="last-blog">
                <h2 class="last-blog-title">{{ __('general.recent_posts') }}</h2>
                <div class="last-blog-items">
                    @foreach($recentPosts as $recent)
                    <a href="{{ route('blog.show', [$locale, $recent->getTranslation('slug', $locale)]) }}" class="blog-item">
                        <div class="item-image">
                            @if($recent->cover_image)
                                <img src="{{ Storage::url($recent->cover_image) }}" alt="{{ $recent->getTranslation('title', $locale) }}">
                            @else
                                <img src="{{ asset('frontend/images/blogCard1.png') }}" alt="">
                            @endif
                        </div>
                        <div class="item-body">
                            <p class="blog-share">{{ $recent->published_at?->translatedFormat('d F Y') ?? $recent->created_at->translatedFormat('d F Y') }}</p>
                            <h3 class="blog-title">{{ Str::limit($recent->getTranslation('title', $locale), 50) }}</h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Taglar --}}
            @if($post->tags->isNotEmpty())
            <div class="blog-tags">
                <h2 class="blog-tags-title">{{ __('general.tags') }}</h2>
                <div class="blog-tags-items">
                    @foreach($post->tags as $tag)
                    <a href="{{ route('blog.index', $locale) }}?tag={{ $tag->slug }}" class="tag-item">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
            @endif

        </aside>

    </div>

</section>

@push('styles')
<style>
.blog-text h1,.blog-text h2,.blog-text h3 { font-weight:700; margin:28px 0 14px; color:#1a1a1a; }
.blog-text h2 { font-size:1.4rem; }
.blog-text h3 { font-size:1.2rem; }
.blog-text p { margin-bottom:16px; }
.blog-text ul,.blog-text ol { padding-left:24px; margin-bottom:16px; }
.blog-text li { margin-bottom:6px; }
.blog-text img { max-width:100%; border-radius:8px; margin:16px 0; }
.blog-text a { color:#ff6b35; }
.blog-text blockquote { border-left:3px solid #ff6b35; padding:12px 20px; background:#f8f8f8; margin:20px 0; border-radius:0 8px 8px 0; }
</style>
@endpush

@endsection

@push('schema')
@php
    $_articleLD = [
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => $post->getTranslation('title', $locale),
        'description'   => Str::limit(strip_tags($post->getTranslation('excerpt', $locale) ?: $post->getTranslation('content', $locale)), 160),
        'datePublished' => ($post->published_at ?? $post->created_at)->toIso8601String(),
        'dateModified'  => $post->updated_at->toIso8601String(),
        'url'           => url()->current(),
        'inLanguage'    => $locale,
        'publisher'     => ['@type' => 'Organization', 'name' => \App\Models\Setting::get('site_name', '166 Usta'), 'url' => url('/az')],
    ];
    if ($post->cover_image) $_articleLD['image'] = ['@type' => 'ImageObject', 'url' => \Illuminate\Support\Facades\Storage::url($post->cover_image)];
    $_breadcrumbLD = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => __('nav.home'), 'item' => url($locale)],
            ['@type' => 'ListItem', 'position' => 2, 'name' => __('nav.blog'),  'item' => route('blog.index', $locale)],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post->getTranslation('title', $locale), 'item' => url()->current()],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($_articleLD,   JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($_breadcrumbLD, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endpush
