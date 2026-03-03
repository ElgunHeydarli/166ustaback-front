@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta') . ' — ' . __('nav.portfolio'))

@section('content')

<section class="all-portfolio-container p-lr">

    {{-- Banner --}}
    <div class="banner">
        <h1 class="banner-title">{{ __('nav.portfolio') }}</h1>
        <img src="{{ asset('frontend/images/headBanner.png') }}" alt="">
    </div>

    {{-- Portfolio grid --}}
    <div class="all-portfolio">
        @forelse($items as $item)
        <a href="{{ route('portfolio.show', [$locale, $item->getTranslation('slug', $locale) ?: $item->getTranslation('slug', 'az')]) }}" class="portfolio-card">
            <div class="card-image">
                @if($item->cover_image)
                    <img src="{{ Storage::url($item->cover_image) }}" alt="{{ $item->getTranslation('title', $locale) }}">
                @else
                    <img src="{{ asset('frontend/images/portfolio1.jpg') }}" alt="">
                @endif
            </div>
            <div class="card-body">
                <h2 class="portfolio-title">{{ $item->getTranslation('title', $locale) }}</h2>
                <div class="description">
                    <p>{{ strip_tags($item->getTranslation('short_description', $locale)) }}</p>
                </div>
                <div class="more">
                    <img src="{{ asset('frontend/icons/arrowRightBlack.svg') }}" alt="">
                </div>
            </div>
        </a>
        @empty
        <p style="grid-column:1/-1;text-align:center;padding:40px 0;color:#999;">{{ __('general.no_portfolio') }}</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($items->hasPages())
    <div class="pagination">
        @if($items->onFirstPage())
            <span class="pagination-item disabled">&lsaquo;</span>
        @else
            <a href="{{ $items->previousPageUrl() }}" class="pagination-item">&lsaquo;</a>
        @endif

        @foreach($items->getUrlRange(1, $items->lastPage()) as $page => $url)
            @if($page == $items->currentPage())
                <a href="{{ $url }}" class="pagination-item active">{{ $page }}</a>
            @else
                <a href="{{ $url }}" class="pagination-item">{{ $page }}</a>
            @endif
        @endforeach

        @if($items->hasMorePages())
            <a href="{{ $items->nextPageUrl() }}" class="pagination-item">&rsaquo;</a>
        @else
            <span class="pagination-item disabled">&rsaquo;</span>
        @endif
    </div>
    @endif

</section>

@endsection

@push('head_links')
@if($items->previousPageUrl())
<link rel="prev" href="{{ $items->previousPageUrl() }}">
@endif
@if($items->nextPageUrl())
<link rel="next" href="{{ $items->nextPageUrl() }}">
@endif
@endpush
