@extends('admin.layouts.app')
@section('title', $item->exists ? 'Portfolio Düzəlt' : 'Yeni Portfolio')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-collection me-2" style="color:#ff6b35"></i>{{ $item->exists ? 'Portfolio Düzəlt' : 'Yeni Portfolio' }}</h1>
    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $item->exists ? route('admin.portfolio.update', $item) : route('admin.portfolio.store') }}" enctype="multipart/form-data">
    @csrf
    @if($item->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <div class="section-title">Əsas Məlumat</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#prt-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prt-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prt-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="prt-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Başlıq ({{ $lbl }}) @if($lang==='az')<span class="text-danger">*</span>@endif</label>
                            <input type="text" name="title[{{ $lang }}]" class="form-control title-input" data-lang="{{ $lang }}"
                                   value="{{ old('title.'.$lang, $item->getTranslation('title',$lang,false)) }}" {{ $lang==='az'?'required':'' }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug ({{ $lbl }})</label>
                            <input type="text" name="slug[{{ $lang }}]" class="form-control font-monospace slug-input" data-lang="{{ $lang }}"
                                   value="{{ old('slug.'.$lang, $item->getTranslation('slug',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Qısa Təsvir ({{ $lbl }})</label>
                            <textarea name="short_description[{{ $lang }}]" class="form-control ckeditor" rows="2">{{ old('short_description.'.$lang, $item->getTranslation('short_description',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ətraflı Məzmun ({{ $lbl }})</label>
                            <textarea name="content[{{ $lang }}]" class="form-control ckeditor" rows="8">{{ old('content.'.$lang, $item->getTranslation('content',$lang,false)) }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-card">
                <div class="section-title"><i class="bi bi-search me-1"></i>SEO</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#prt-seo-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prt-seo-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prt-seo-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="prt-seo-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Meta Başlıq ({{ $lbl }})</label>
                            <input type="text" name="meta_title[{{ $lang }}]" class="form-control" maxlength="60"
                                   value="{{ old('meta_title.'.$lang, $item->getTranslation('meta_title',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Təsvir ({{ $lbl }})</label>
                            <textarea name="meta_description[{{ $lang }}]" class="form-control" rows="2" maxlength="160">{{ old('meta_description.'.$lang, $item->getTranslation('meta_description',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Açar Sözlər ({{ $lbl }})</label>
                            <input type="text" name="meta_keywords[{{ $lang }}]" class="form-control"
                                   value="{{ old('meta_keywords.'.$lang, $item->getTranslation('meta_keywords',$lang,false)) }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <label class="form-label">OG Şəkil</label>
                    @if($item->og_image)<div class="mb-2"><img src="{{ Storage::url($item->og_image) }}" style="height:60px;border-radius:6px;"></div>@endif
                    <input type="file" name="og_image" class="form-control" accept="image/*">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Parametrlər</div>
                <div class="mb-3">
                    <label class="form-label">Xidmət kateqoriyası</label>
                    <select name="service_id" class="form-select">
                        <option value="">— Seçin —</option>
                        @foreach($services as $id => $name)
                            <option value="{{ $id }}" {{ old('service_id', $item->service_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Müştəri</label>
                    <input type="text" name="client" class="form-control" value="{{ old('client', $item->client) }}" placeholder="Müştəri adı">
                </div>
                <div class="mb-3">
                    <label class="form-label">Müddət</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration', $item->duration) }}" placeholder="məs: 3 gün">
                </div>
                <div class="mb-3">
                    <label class="form-label">Sıra</label>
                    <input type="number" name="order" class="form-control" min="0" value="{{ old('order', $item->order ?? 0) }}">
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
            </div>
            <div class="form-card mb-4">
                <div class="section-title">Kapak Şəkil</div>
                @if($item->cover_image)<img src="{{ Storage::url($item->cover_image) }}" class="w-100 rounded mb-2" style="max-height:140px;object-fit:cover;">@endif
                <input type="file" name="cover_image" class="form-control" accept="image/*">
            </div>
            <div class="form-card mb-4">
                <div class="section-title">Qalereya Şəkilləri</div>
                @if(!empty($item->gallery))
                <div class="row g-2 mb-3">
                    @foreach($item->gallery as $img)
                    <div class="col-4">
                        <div class="position-relative">
                            <img src="{{ Storage::url($img) }}" class="w-100 rounded" style="height:80px;object-fit:cover;">
                            <label class="position-absolute top-0 end-0 m-1 bg-white rounded px-1" title="Saxla">
                                <input type="checkbox" name="keep_gallery[]" value="{{ $img }}" checked>
                            </label>
                        </div>
                        <div class="form-text text-center">Çıxarmaq üçün işarəni götür</div>
                    </div>
                    @endforeach
                </div>
                @endif
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <div class="form-text">Bir neçə şəkil seçmək olar</div>
            </div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $item->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.title-input').forEach(function(titleInput) {
    var lang = titleInput.dataset.lang;
    titleInput.addEventListener('input', function() {
        var slugInput = document.querySelector('.slug-input[data-lang="' + lang + '"]');
        if (slugInput && !slugInput.dataset.manual) {
            slugInput.value = this.value.toLowerCase().replace(/\s+/g,'-').replace(/[^a-z0-9\-]/g,'').replace(/--+/g,'-').replace(/^-+|-+$/g,'');
        }
    });
});
document.querySelectorAll('.slug-input').forEach(function(s){ s.addEventListener('input',function(){ this.dataset.manual='1'; }); });
</script>
@endpush
