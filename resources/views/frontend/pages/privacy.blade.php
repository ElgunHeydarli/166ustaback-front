@extends('frontend.layouts.app')

@section('title', __('footer.privacy'))

@section('content')

<section class="privacy-policy-container p-lr">

    {{-- Breadcrumb --}}
    <div class="breadCrumb">
        <a href="{{ route('home', $locale) }}" class="breadCrumb-item">{{ __('nav.home') }}</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightOrange2.svg') }}" alt="">
        </div>
        <p class="breadCrumb-item active">{{ __('footer.privacy') }}</p>
    </div>

    <h1 class="page-title">{{ __('footer.privacy') }}</h1>

    <div class="privacy-policy-description">
        @if($page && $page->getTranslation('content', $locale))
            {!! $page->getTranslation('content', $locale) !!}
        @else
            <p>{{ __('general.preparing') }}</p>
        @endif
    </div>

</section>

@endsection
