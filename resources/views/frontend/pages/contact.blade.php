@extends('frontend.layouts.app')

@section('title', \App\Models\Setting::get('meta_title', '166 Usta') . ' — Əlaqə')
@section('meta_description', \App\Models\Setting::get('meta_description', ''))

@section('content')

<section class="contact-container p-lr">
    <div class="banner">
        <h1 class="banner-title">Əlaqə</h1>
        <img src="{{ asset('frontend/images/headBanner.png') }}" alt="">
    </div>

    <div class="contact-main-box">
        <h2 class="box-title">Müraciət et, biz əlaqə saxlayaq!</h2>

        <div class="contact-main">
            {{-- Form --}}
            <form class="contact-form" method="POST" action="{{ route('contact.post', $locale) }}">
                @csrf

                @if(session('success'))
                <div style="background:#d4edda;color:#155724;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.95rem;">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.95rem;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <input type="text" name="name" placeholder="Ad və Soyad"
                    value="{{ old('name') }}" required>

                <input type="text" name="phone" placeholder="Əlaqə nömrəsi"
                    value="{{ old('phone') }}" required>

                <select name="service_id">
                    <option value="">Xidməti seçin</option>
                    @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->getTranslation('title', $locale) }}
                    </option>
                    @endforeach
                </select>

                <textarea name="message" placeholder="Sifarişlə bağlı məlumat">{{ old('message') }}</textarea>

                <button class="submitContact" type="submit">Göndər</button>
            </form>

            {{-- Contact Info --}}
            @php
                $phone   = \App\Models\Setting::get('phone', '');
                $email   = \App\Models\Setting::get('email', '');
                $address = \App\Models\Setting::get('address', '');
                $wp      = \App\Models\Setting::get('whatsapp', $phone);
            @endphp
            <div class="contac-info">
                @if($address)
                <div class="contact-info-item">
                    <div class="icon">
                        <img src="{{ asset('frontend/icons/locationOrange.svg') }}" alt="">
                    </div>
                    <div class="item-body">
                        <span>Baş ofis</span>
                        <p>{{ $address }}</p>
                    </div>
                </div>
                @endif

                @if($email)
                <div class="contact-info-item">
                    <div class="icon">
                        <img src="{{ asset('frontend/icons/mailOrange.svg') }}" alt="">
                    </div>
                    <div class="item-body">
                        <span>E-poçt</span>
                        <a href="mailto:{{ $email }}">{{ $email }}</a>
                    </div>
                </div>
                @endif

                @if($phone)
                <div class="contact-info-item">
                    <div class="icon">
                        <img src="{{ asset('frontend/icons/phoneOrange.svg') }}" alt="">
                    </div>
                    <div class="item-body">
                        <span>Əlaqə nömrəsi</span>
                        <a href="tel:{{ $phone }}">{{ $phone }}</a>
                    </div>
                </div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wp) }}" target="_blank" class="wp">
                    <img src="{{ asset('frontend/icons/wp.svg') }}" alt="">
                    <p>Whatsapp ilə yazın</p>
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Map --}}
    @php $mapEmbed = \App\Models\Setting::get('map_embed', ''); @endphp
    @if($mapEmbed)
    <div class="map">
        {!! $mapEmbed !!}
    </div>
    @endif

</section>

@endsection
