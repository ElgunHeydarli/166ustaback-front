@extends('admin.layouts.app')
@section('title', 'Parametrlər')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-gear me-2" style="color:#ff6b35"></i>Sayt Parametrləri</h1>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="accordion" id="settingsAccordion">

        {{-- 1. Sayt Parametrləri --}}
        <div class="accordion-item border-0 form-card mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral">
                    <i class="bi bi-globe me-2" style="color:#ff6b35"></i>Sayt Parametrləri
                </button>
            </h2>
            <div id="collapseGeneral" class="accordion-collapse collapse show" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <ul class="nav nav-tabs mb-3">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#st-az">🇦🇿 AZ</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#st-en">🇬🇧 EN</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#st-ru">🇷🇺 RU</a></li>
                            </ul>
                            <div class="tab-content mb-3">
                                @php $siteNames = \App\Models\Setting::getTranslations('site_name'); $taglines = \App\Models\Setting::getTranslations('site_tagline'); @endphp
                                @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                                <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="st-{{ $lang }}">
                                    <div class="mb-3">
                                        <label class="form-label">Sayt Adı ({{ $lbl }}) @if($lang==='az')<span class="text-danger">*</span>@endif</label>
                                        <input type="text" name="site_name[{{ $lang }}]" class="form-control"
                                               value="{{ old('site_name.'.$lang, $siteNames[$lang] ?? '') }}" {{ $lang==='az'?'required':'' }}>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Slogan ({{ $lbl }})</label>
                                        <input type="text" name="site_tagline[{{ $lang }}]" class="form-control"
                                               value="{{ old('site_tagline.'.$lang, $taglines[$lang] ?? '') }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Logo</label>
                                @if(!empty($settings['site_logo']))
                                    <div class="mb-2"><img src="{{ Storage::url($settings['site_logo']) }}" style="height:50px;"></div>
                                @endif
                                <input type="file" name="site_logo" class="form-control" accept="image/*,.svg">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Favicon</label>
                                @if(!empty($settings['site_favicon']))
                                    <div class="mb-2"><img src="{{ Storage::url($settings['site_favicon']) }}" style="height:32px;"></div>
                                @endif
                                <input type="file" name="site_favicon" class="form-control" accept="image/*,.ico">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Əlaqə Məlumatları --}}
        <div class="accordion-item border-0 form-card mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact">
                    <i class="bi bi-telephone me-2" style="color:#ff6b35"></i>Əlaqə Məlumatları
                </button>
            </h2>
            <div id="collapseContact" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Telefon <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telefon 2</label>
                            <input type="text" name="phone2" class="form-control" value="{{ $settings['phone2'] ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">İş Saatları</label>
                            <input type="text" name="working_hours" class="form-control" value="{{ $settings['working_hours'] ?? '' }}" placeholder="B.E - C: 09:00 - 18:00">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">WhatsApp Nömrəsi</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="+994501234567">
                            <div class="form-text">Beynəlxalq formatda (+ işarəsi ilə)</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ünvan</label>
                            <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Google Maps Embed Kodu</label>
                            <textarea name="map_embed" class="form-control font-monospace" rows="3" placeholder='&lt;iframe src="https://www.google.com/maps/embed?..." ...&gt;&lt;/iframe&gt;'>{{ $settings['map_embed'] ?? '' }}</textarea>
                            <div class="form-text">Google Maps → Paylaş → Xəritəni yerləştir → HTML kodunu yapışdırın</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. SEO --}}
        <div class="accordion-item border-0 form-card mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeo">
                    <i class="bi bi-search me-2" style="color:#ff6b35"></i>SEO (Default)
                </button>
            </h2>
            <div id="collapseSeo" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#seo-az">🇦🇿 AZ</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seo-en">🇬🇧 EN</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seo-ru">🇷🇺 RU</a></li>
                    </ul>
                    <div class="tab-content mb-3">
                        @php
                            $metaTitles = \App\Models\Setting::getTranslations('meta_title');
                            $metaDescs  = \App\Models\Setting::getTranslations('meta_description');
                            $metaKws    = \App\Models\Setting::getTranslations('meta_keywords');
                        @endphp
                        @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                        <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="seo-{{ $lang }}">
                            <div class="mb-3">
                                <label class="form-label">Meta Başlıq ({{ $lbl }})</label>
                                <input type="text" name="meta_title[{{ $lang }}]" class="form-control" maxlength="60"
                                       value="{{ old('meta_title.'.$lang, $metaTitles[$lang] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Təsvir ({{ $lbl }})</label>
                                <textarea name="meta_description[{{ $lang }}]" class="form-control" rows="2" maxlength="160">{{ old('meta_description.'.$lang, $metaDescs[$lang] ?? '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Açar Sözlər ({{ $lbl }})</label>
                                <input type="text" name="meta_keywords[{{ $lang }}]" class="form-control"
                                       value="{{ old('meta_keywords.'.$lang, $metaKws[$lang] ?? '') }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Default OG Şəkil</label>
                        @if(!empty($settings['og_image']))
                            <div class="mb-2"><img src="{{ Storage::url($settings['og_image']) }}" style="height:60px;border-radius:6px;"></div>
                        @endif
                        <input type="file" name="og_image" class="form-control" accept="image/*">
                        <div class="form-text">Tövsiyə: 1200×630 px</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Google & Analitika --}}
        <div class="accordion-item border-0 form-card mb-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGoogle">
                    <i class="bi bi-bar-chart me-2" style="color:#ff6b35"></i>Google & Analitika
                </button>
            </h2>
            <div id="collapseGoogle" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Google Analytics ID</label>
                            <input type="text" name="google_analytics" class="form-control font-monospace"
                                   value="{{ $settings['google_analytics'] ?? '' }}" placeholder="G-XXXXXXXXXX">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Google Tag Manager ID</label>
                            <input type="text" name="google_tag_manager" class="form-control font-monospace"
                                   value="{{ $settings['google_tag_manager'] ?? '' }}" placeholder="GTM-XXXXXXX">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Google Verifikasiya</label>
                            <input type="text" name="google_verification" class="form-control font-monospace"
                                   value="{{ $settings['google_verification'] ?? '' }}" placeholder="meta content dəyəri">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Robots.txt Məzmunu</label>
                            <textarea name="robots_txt" class="form-control font-monospace" rows="4">{{ $settings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /admin/" }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /accordion --}}

    <div class="mt-3">
        <button type="submit" class="btn px-5" style="background:#ff6b35;color:#fff;padding:12px 32px;font-weight:600;border-radius:8px;">
            <i class="bi bi-check-lg me-2"></i>Yadda Saxla
        </button>
    </div>
</form>
@endsection
