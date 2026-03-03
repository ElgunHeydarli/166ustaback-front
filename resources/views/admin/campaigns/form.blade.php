@extends('admin.layouts.app')
@section('title', $campaign->exists ? 'Kampaniya Düzəlt' : 'Yeni Kampaniya')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-megaphone me-2" style="color:#ff6b35"></i>{{ $campaign->exists ? 'Kampaniya Düzəlt' : 'Yeni Kampaniya' }}</h1>
    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $campaign->exists ? route('admin.campaigns.update', $campaign) : route('admin.campaigns.store') }}" enctype="multipart/form-data">
    @csrf
    @if($campaign->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <div class="section-title">Kampaniya Məlumatı</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#camp-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#camp-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#camp-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="camp-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Başlıq ({{ $lbl }}) @if($lang==='az')<span class="text-danger">*</span>@endif</label>
                            <input type="text" name="title[{{ $lang }}]" class="form-control title-input" data-lang="{{ $lang }}"
                                   value="{{ old('title.'.$lang, $campaign->getTranslation('title',$lang,false)) }}" {{ $lang==='az'?'required':'' }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug ({{ $lbl }})</label>
                            <input type="text" name="slug[{{ $lang }}]" class="form-control font-monospace slug-input" data-lang="{{ $lang }}"
                                   value="{{ old('slug.'.$lang, $campaign->getTranslation('slug',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Qısa Təsvir ({{ $lbl }})</label>
                            <textarea name="short_description[{{ $lang }}]" class="form-control ckeditor" rows="2">{{ old('short_description.'.$lang, $campaign->getTranslation('short_description',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ətraflı Məzmun ({{ $lbl }})</label>
                            <textarea name="content[{{ $lang }}]" class="form-control ckeditor" rows="8">{{ old('content.'.$lang, $campaign->getTranslation('content',$lang,false)) }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <label class="form-label">Başlama Tarixi</label>
                        <input type="date" name="starts_at" class="form-control" value="{{ old('starts_at', $campaign->starts_at?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Bitmə Tarixi</label>
                        <input type="date" name="ends_at" class="form-control" value="{{ old('ends_at', $campaign->ends_at?->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>
            <div class="form-card">
                <div class="section-title"><i class="bi bi-search me-1"></i>SEO</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#camp-seo-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#camp-seo-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#camp-seo-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="camp-seo-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Meta Başlıq ({{ $lbl }})</label>
                            <input type="text" name="meta_title[{{ $lang }}]" class="form-control" maxlength="60"
                                   value="{{ old('meta_title.'.$lang, $campaign->getTranslation('meta_title',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Təsvir ({{ $lbl }})</label>
                            <textarea name="meta_description[{{ $lang }}]" class="form-control" rows="2" maxlength="160">{{ old('meta_description.'.$lang, $campaign->getTranslation('meta_description',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Açar Sözlər ({{ $lbl }})</label>
                            <input type="text" name="meta_keywords[{{ $lang }}]" class="form-control"
                                   value="{{ old('meta_keywords.'.$lang, $campaign->getTranslation('meta_keywords',$lang,false)) }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <label class="form-label">OG Şəkil</label>
                    @if($campaign->og_image)<div class="mb-2"><img src="{{ Storage::url($campaign->og_image) }}" style="height:60px;border-radius:6px;"></div>@endif
                    <input type="file" name="og_image" class="form-control" accept="image/*">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Parametrlər</div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $campaign->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
            </div>
            <div class="form-card">
                <div class="section-title">Kapak Şəkil</div>
                @if($campaign->cover_image)<img src="{{ Storage::url($campaign->cover_image) }}" class="w-100 rounded mb-2" style="max-height:140px;object-fit:cover;">@endif
                <input type="file" name="cover_image" class="form-control" accept="image/*">
            </div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $campaign->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
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
