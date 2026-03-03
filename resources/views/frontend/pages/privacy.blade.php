@extends('frontend.layouts.app')

@section('title', 'Məxfilik siyasəti')

@section('content')

<section class="privacy-policy-container p-lr">

    {{-- Breadcrumb --}}
    <div class="breadCrumb">
        <a href="{{ route('home', $locale) }}" class="breadCrumb-item">Ana səhifə</a>
        <div class="icon">
            <img src="{{ asset('frontend/icons/arrowRightOrange2.svg') }}" alt="">
        </div>
        <p class="breadCrumb-item active">Məxfilik siyasəti</p>
    </div>

    <h1 class="page-title">Məxfilik siyasəti</h1>

    <div class="privacy-policy-description">
        @if($page && $page->getTranslation('content', $locale))
            {!! $page->getTranslation('content', $locale) !!}
        @else
            <p>Məlumat hazırlanır...</p>
        @endif
    </div>

</section>

@endsection
