@extends('admin.layouts.app')
@section('title', $slider->exists ? 'Slider Düzəlt' : 'Yeni Slider')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-images me-2" style="color:#ff6b35"></i>{{ $slider->exists ? 'Slider Düzəlt' : 'Yeni Slider' }}</h1>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $slider->exists ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}" enctype="multipart/form-data">
    @csrf
    @if($slider->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="section-title">Slider Məlumatı</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#sld-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sld-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sld-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="sld-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Başlıq ({{ $lbl }})</label>
                            <input type="text" name="title[{{ $lang }}]" class="form-control"
                                   value="{{ old('title.'.$lang, $slider->getTranslation('title',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alt Başlıq / Açıqlama ({{ $lbl }})</label>
                            <textarea name="subtitle[{{ $lang }}]" class="form-control" rows="2">{{ old('subtitle.'.$lang, $slider->getTranslation('subtitle',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Düymə Mətni ({{ $lbl }})</label>
                            <input type="text" name="button_text[{{ $lang }}]" class="form-control"
                                   value="{{ old('button_text.'.$lang, $slider->getTranslation('button_text',$lang,false)) }}" placeholder="Ətraflı baxın">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mb-3 mt-2">
                    <label class="form-label">Düymə Linki</label>
                    <input type="text" name="button_url" class="form-control" value="{{ old('button_url', $slider->button_url) }}" placeholder="/az/xidmetler">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Parametrlər</div>
                <div class="mb-3">
                    <label class="form-label">Sıra</label>
                    <input type="number" name="order" class="form-control" min="0" value="{{ old('order', $slider->order ?? 0) }}">
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
            </div>
            <div class="form-card">
                <div class="section-title">Şəkil @if(!$slider->exists)<span class="text-danger">*</span>@endif</div>
                @if($slider->exists && $slider->image)
                    <img src="{{ Storage::url($slider->image) }}" class="w-100 rounded mb-2" style="max-height:120px;object-fit:cover;">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*" {{ !$slider->exists ? 'required' : '' }}>
                <div class="form-text">Tövsiyə: 1920×800 px</div>
            </div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $slider->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
