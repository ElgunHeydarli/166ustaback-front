@extends('admin.layouts.app')
@section('title', 'Əsas Səhifə — Sifariş CTA')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-megaphone me-2" style="color:#ff6b35"></i>Əsas Səhifə — Sifariş CTA Bölməsi</h1>
</div>

<form method="POST" action="{{ route('admin.home-cta.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="section-title">Məzmun</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#cta-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cta-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cta-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="cta-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Başlıq ({{ $lbl }})</label>
                            <input type="text" name="title[{{ $lang }}]" class="form-control"
                                   value="{{ old('title.'.$lang, $cta->getTranslation('title', $lang, false)) }}"
                                   placeholder="Bir Kliklə Peşəkar Usta Sifariş Edin!">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alt Mətn ({{ $lbl }})</label>
                            <textarea name="description[{{ $lang }}]" class="form-control" rows="3"
                                      placeholder="Ev və ofisiniz üçün texniki problemlərin sürətli həlli.">{{ old('description.'.$lang, $cta->getTranslation('description', $lang, false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Düymə Mətni ({{ $lbl }})</label>
                            <input type="text" name="button_text[{{ $lang }}]" class="form-control"
                                   value="{{ old('button_text.'.$lang, $cta->getTranslation('button_text', $lang, false)) }}"
                                   placeholder="Sifariş Et">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mb-3 mt-2">
                    <label class="form-label">Düymə Linki</label>
                    <input type="text" name="button_url" class="form-control"
                           value="{{ old('button_url', $cta->button_url) }}"
                           placeholder="/az/elaqe">
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Şəkil (Sağ tərəf)</div>
                @if($cta->image)
                    <img src="{{ Storage::url($cta->image) }}" class="w-100 rounded mb-2" style="max-height:160px;object-fit:contain;background:#f5f5f5;">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*,.svg">
                <div class="form-text">PNG, SVG və ya WebP. Tövsiyə: şəffaf fon</div>
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
