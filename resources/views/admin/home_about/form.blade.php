@extends('admin.layouts.app')
@section('title', 'Əsas Səhifə — Haqqımızda')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-people me-2" style="color:#ff6b35"></i>Əsas Səhifə — Haqqımızda</h1>
</div>

<form method="POST" action="{{ route('admin.home-about.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="section-title">Məzmun</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#ab-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#ab-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#ab-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="ab-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Başlıq ({{ $lbl }})</label>
                            <input type="text" name="title[{{ $lang }}]" class="form-control"
                                   value="{{ old('title.'.$lang, $about->getTranslation('title', $lang, false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Məzmun / Açıqlama ({{ $lbl }})</label>
                            <textarea name="content[{{ $lang }}]" class="form-control ckeditor" rows="6">{{ old('content.'.$lang, $about->getTranslation('content', $lang, false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Düymə Mətni ({{ $lbl }})</label>
                            <input type="text" name="button_text[{{ $lang }}]" class="form-control"
                                   value="{{ old('button_text.'.$lang, $about->getTranslation('button_text', $lang, false)) }}"
                                   placeholder="Ətraflı">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mb-3 mt-2">
                    <label class="form-label">Düymə Linki</label>
                    <input type="text" name="button_url" class="form-control"
                           value="{{ old('button_url', $about->button_url) }}"
                           placeholder="/az/haqqimizda">
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Böyük Şəkil (Sol)</div>
                @if($about->image1)
                    <img src="{{ Storage::url($about->image1) }}" class="w-100 rounded mb-2" style="max-height:140px;object-fit:cover;">
                @endif
                <input type="file" name="image1" class="form-control" accept="image/*">
                <div class="form-text">Tövsiyə: 600×500 px</div>
            </div>
            <div class="form-card mb-4">
                <div class="section-title">Kiçik Şəkil (Sağ alt)</div>
                @if($about->image2)
                    <img src="{{ Storage::url($about->image2) }}" class="w-100 rounded mb-2" style="max-height:140px;object-fit:cover;">
                @endif
                <input type="file" name="image2" class="form-control" accept="image/*">
                <div class="form-text">Tövsiyə: 400×350 px</div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>Yadda Saxla
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
