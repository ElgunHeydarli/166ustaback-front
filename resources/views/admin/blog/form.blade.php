@extends('admin.layouts.app')
@section('title', $post->exists ? 'Bloq Yazısını Düzəlt' : 'Yeni Bloq Yazısı')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-journal-text me-2" style="color:#ff6b35"></i>{{ $post->exists ? 'Bloq Yazısını Düzəlt' : 'Yeni Bloq Yazısı' }}</h1>
    <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $post->exists ? route('admin.blog.update', $post) : route('admin.blog.store') }}" enctype="multipart/form-data">
    @csrf
    @if($post->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <div class="section-title">Əsas Məlumat</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#blog-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#blog-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#blog-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="blog-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Başlıq ({{ $lbl }}) @if($lang==='az')<span class="text-danger">*</span>@endif</label>
                            <input type="text" name="title[{{ $lang }}]" class="form-control title-input" data-lang="{{ $lang }}"
                                   value="{{ old('title.'.$lang, $post->getTranslation('title',$lang,false)) }}" {{ $lang==='az'?'required':'' }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug ({{ $lbl }})</label>
                            <input type="text" name="slug[{{ $lang }}]" class="form-control font-monospace slug-input" data-lang="{{ $lang }}"
                                   value="{{ old('slug.'.$lang, $post->getTranslation('slug',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Qısa Xülasə ({{ $lbl }})</label>
                            <textarea name="excerpt[{{ $lang }}]" class="form-control" rows="2">{{ old('excerpt.'.$lang, $post->getTranslation('excerpt',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ətraflı Məzmun ({{ $lbl }})</label>
                            <textarea name="content[{{ $lang }}]" class="form-control ckeditor" rows="10">{{ old('content.'.$lang, $post->getTranslation('content',$lang,false)) }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mb-3 mt-2">
                    <label class="form-label">Yayımlanma Tarixi</label>
                    <input type="datetime-local" name="published_at" class="form-control"
                           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                </div>
            </div>
            <div class="form-card">
                <div class="section-title"><i class="bi bi-search me-1"></i>SEO</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#blog-seo-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#blog-seo-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#blog-seo-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="blog-seo-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Meta Başlıq ({{ $lbl }})</label>
                            <input type="text" name="meta_title[{{ $lang }}]" class="form-control" maxlength="60"
                                   value="{{ old('meta_title.'.$lang, $post->getTranslation('meta_title',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Təsvir ({{ $lbl }})</label>
                            <textarea name="meta_description[{{ $lang }}]" class="form-control" rows="2" maxlength="160">{{ old('meta_description.'.$lang, $post->getTranslation('meta_description',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Açar Sözlər ({{ $lbl }})</label>
                            <input type="text" name="meta_keywords[{{ $lang }}]" class="form-control"
                                   value="{{ old('meta_keywords.'.$lang, $post->getTranslation('meta_keywords',$lang,false)) }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <label class="form-label">OG Şəkil</label>
                    @if($post->og_image)<div class="mb-2"><img src="{{ Storage::url($post->og_image) }}" style="height:60px;border-radius:6px;"></div>@endif
                    <input type="file" name="og_image" class="form-control" accept="image/*">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Parametrlər</div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $post->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
            </div>
            <div class="form-card mb-4">
                <div class="section-title">Kapak Şəkil</div>
                @if($post->cover_image)<img src="{{ Storage::url($post->cover_image) }}" class="w-100 rounded mb-2" style="max-height:140px;object-fit:cover;">@endif
                <input type="file" name="cover_image" class="form-control" accept="image/*">
            </div>
            @if($tags->isNotEmpty())
            <div class="form-card mb-4">
                <div class="section-title"><i class="bi bi-tags me-1"></i>Taglar</div>
                @php $selectedTags = old('tags', $post->exists ? $post->tags->pluck('id')->toArray() : []) @endphp
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:4px;">
                    @foreach($tags as $tag)
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;background:#f8f8f8;padding:6px 12px;border-radius:20px;border:1px solid {{ in_array($tag->id, (array)$selectedTags) ? '#ff6b35' : '#eee' }};">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                               {{ in_array($tag->id, (array)$selectedTags) ? 'checked' : '' }}
                               style="accent-color:#ff6b35;">
                        <span style="font-size:.85rem;">{{ $tag->name }}</span>
                    </label>
                    @endforeach
                </div>
                <div class="mt-2">
                    <a href="{{ route('admin.blog-tags.create') }}" target="_blank" style="font-size:.8rem;color:#ff6b35;">
                        <i class="bi bi-plus-circle me-1"></i>Yeni tag əlavə et
                    </a>
                </div>
            </div>
            @endif
            <div class="mt-3 d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $post->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
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
