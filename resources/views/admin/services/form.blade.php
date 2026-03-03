@extends('admin.layouts.app')
@section('title', $service->exists ? 'Xidməti Düzəlt' : 'Yeni Xidmət')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-tools me-2" style="color:#ff6b35"></i>{{ $service->exists ? 'Xidməti Düzəlt' : 'Yeni Xidmət' }}</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" enctype="multipart/form-data">
    @csrf
    @if($service->exists) @method('PUT') @endif

    <div class="row g-4">
        {{-- SOL SUTUN --}}
        <div class="col-lg-8">

            {{-- Əsas Məlumat --}}
            <div class="form-card mb-4">
                <div class="section-title">Əsas Məlumat</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#svc-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#svc-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#svc-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="svc-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Başlıq ({{ $lbl }}) @if($lang==='az')<span class="text-danger">*</span>@endif</label>
                            <input type="text" name="title[{{ $lang }}]" class="form-control title-input" data-lang="{{ $lang }}"
                                   value="{{ old('title.'.$lang, $service->getTranslation('title',$lang,false)) }}" {{ $lang==='az'?'required':'' }}>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug ({{ $lbl }})</label>
                            <input type="text" name="slug[{{ $lang }}]" class="form-control font-monospace slug-input" data-lang="{{ $lang }}"
                                   value="{{ old('slug.'.$lang, $service->getTranslation('slug',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Qısa Təsvir ({{ $lbl }})</label>
                            <textarea name="short_description[{{ $lang }}]" class="form-control ckeditor" rows="3">{{ old('short_description.'.$lang, $service->getTranslation('short_description',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ətraflı Məzmun ({{ $lbl }})</label>
                            <textarea name="content[{{ $lang }}]" class="form-control ckeditor" rows="8">{{ old('content.'.$lang, $service->getTranslation('content',$lang,false)) }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Üstünlüklər --}}
            <div class="form-card mb-4">
                <div class="section-title"><i class="bi bi-check2-circle me-1"></i>Üstünlüklər (4 maddə)</div>
                <small class="text-muted d-block mb-3">Saytda saat, pul kisəsi, palet, medal ikonları ilə göstərilir</small>
                @php
                    $advIcons = ['bi-clock', 'bi-wallet2', 'bi-layers', 'bi-award'];
                    $advLabels = ['1. Üstünlük', '2. Üstünlük', '3. Üstünlük', '4. Üstünlük'];
                    $existingAdv = $service->advantages ?? [];
                @endphp
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#adv-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#adv-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#adv-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="adv-{{ $lang }}">
                        @for($i = 0; $i < 4; $i++)
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <i class="bi {{ $advIcons[$i] }} text-muted" style="font-size:1.2rem;width:24px;"></i>
                            <input type="text" name="adv[{{ $lang }}][{{ $i }}]" class="form-control"
                                   placeholder="{{ $advLabels[$i] }}"
                                   value="{{ old("adv.{$lang}.{$i}", $existingAdv[$lang][$i] ?? '') }}">
                        </div>
                        @endfor
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Addımlar --}}
            <div class="form-card mb-4">
                <div class="section-title"><i class="bi bi-list-ol me-1"></i>Addımlar (3 mərhələ)</div>
                @php $existingSteps = $service->steps ?? [[], [], []]; @endphp

                {{-- Steps section title --}}
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#stitle-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#stitle-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#stitle-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content mb-4">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="stitle-{{ $lang }}">
                        <div class="mb-2">
                            <label class="form-label small">Bölmə Başlığı ({{ $lbl }})</label>
                            <input type="text" name="steps_title[{{ $lang }}]" class="form-control"
                                   placeholder="məs: Xidmət 3 Mərhələdə"
                                   value="{{ old('steps_title.'.$lang, $service->getTranslation('steps_title',$lang,false)) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Bölmə Alt Başlığı ({{ $lbl }})</label>
                            <textarea name="steps_subtitle[{{ $lang }}]" class="form-control" rows="2"
                                      placeholder="Qısa açıqlama">{{ old('steps_subtitle.'.$lang, $service->getTranslation('steps_subtitle',$lang,false)) }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- 3 steps --}}
                @for($s = 0; $s < 3; $s++)
                <div class="border rounded p-3 mb-3">
                    <div class="fw-semibold mb-2" style="color:#ff6b35;">{{ $s+1 }}. Mərhələ</div>
                    <div class="mb-2">
                        <label class="form-label small">Şəkil</label>
                        @if(!empty($existingSteps[$s]['image']))
                            <div class="mb-1"><img src="{{ Storage::url($existingSteps[$s]['image']) }}" style="height:60px;border-radius:6px;object-fit:cover;"></div>
                        @endif
                        <input type="file" name="step_img[{{ $s }}]" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <ul class="nav nav-tabs mb-2" style="font-size:.8rem;">
                        <li class="nav-item"><a class="nav-link py-1 active" data-bs-toggle="tab" href="#step{{ $s }}-az">🇦🇿 AZ</a></li>
                        <li class="nav-item"><a class="nav-link py-1" data-bs-toggle="tab" href="#step{{ $s }}-en">🇬🇧 EN</a></li>
                        <li class="nav-item"><a class="nav-link py-1" data-bs-toggle="tab" href="#step{{ $s }}-ru">🇷🇺 RU</a></li>
                    </ul>
                    <div class="tab-content">
                        @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                        <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="step{{ $s }}-{{ $lang }}">
                            <input type="text" name="step[{{ $s }}][title][{{ $lang }}]" class="form-control form-control-sm mb-2"
                                   placeholder="Başlıq ({{ $lbl }})"
                                   value="{{ old("step.{$s}.title.{$lang}", $existingSteps[$s]['title'][$lang] ?? '') }}">
                            <textarea name="step[{{ $s }}][description][{{ $lang }}]" class="form-control ckeditor" rows="4"
                                      placeholder="Açıqlama ({{ $lbl }})">{{ old("step.{$s}.description.{$lang}", $existingSteps[$s]['description'][$lang] ?? '') }}</textarea>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endfor
            </div>

            {{-- SEO --}}
            <div class="form-card">
                <div class="section-title"><i class="bi bi-search me-1"></i>SEO</div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#svc-seo-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#svc-seo-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#svc-seo-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="svc-seo-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Meta Başlıq ({{ $lbl }})</label>
                            <input type="text" name="meta_title[{{ $lang }}]" class="form-control" maxlength="60"
                                   value="{{ old('meta_title.'.$lang, $service->getTranslation('meta_title',$lang,false)) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Təsvir ({{ $lbl }})</label>
                            <textarea name="meta_description[{{ $lang }}]" class="form-control" rows="2" maxlength="160">{{ old('meta_description.'.$lang, $service->getTranslation('meta_description',$lang,false)) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Açar Sözlər ({{ $lbl }})</label>
                            <input type="text" name="meta_keywords[{{ $lang }}]" class="form-control"
                                   value="{{ old('meta_keywords.'.$lang, $service->getTranslation('meta_keywords',$lang,false)) }}">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <label class="form-label">OG Şəkil</label>
                    @if($service->og_image)<div class="mb-2"><img src="{{ Storage::url($service->og_image) }}" style="height:60px;border-radius:6px;"></div>@endif
                    <input type="file" name="og_image" class="form-control" accept="image/*">
                </div>
            </div>
        </div>

        {{-- SAĞ SUTUN --}}
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Parametrlər</div>
                <div class="mb-3">
                    <label class="form-label">İkon (SVG/PNG)</label>
                    @if($service->icon)
                        <div class="mb-2 p-2 bg-dark rounded d-inline-block">
                            <img src="{{ Storage::url($service->icon) }}" style="height:40px;width:40px;object-fit:contain;">
                        </div>
                    @endif
                    <input type="file" name="icon" class="form-control" accept="image/*,.svg">
                </div>
                <div class="mb-3">
                    <label class="form-label">Sıra</label>
                    <input type="number" name="order" class="form-control" min="0" value="{{ old('order', $service->order ?? 0) }}">
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="show_in_menu" id="showMenu" value="1"
                           {{ old('show_in_menu', $service->show_in_menu ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="showMenu">Menyuda göstər</label>
                </div>
            </div>

            {{-- Ana şəkil --}}
            <div class="form-card mb-4">
                <div class="section-title">Əsas Şəkil (Hero)</div>
                @if($service->image)<img src="{{ Storage::url($service->image) }}" class="w-100 rounded mb-2" style="max-height:140px;object-fit:cover;">@endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            {{-- Qalereya --}}
            <div class="form-card mb-4">
                <div class="section-title">Qalereya Şəkilləri</div>
                @if(!empty($service->images))
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @foreach($service->images as $img)
                    <div style="position:relative;">
                        <img src="{{ Storage::url($img) }}" style="height:60px;width:60px;object-fit:cover;border-radius:6px;">
                        <input type="hidden" name="keep_images[]" value="{{ $img }}">
                    </div>
                    @endforeach
                </div>
                @endif
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <div class="form-text">Bir neçə şəkil seçə bilərsiniz</div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $service->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
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
