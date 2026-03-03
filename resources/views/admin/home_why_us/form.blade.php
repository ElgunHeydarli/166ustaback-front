@extends('admin.layouts.app')
@section('title', 'Haqqımızda — Niyə Biz')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-patch-check me-2" style="color:#ff6b35"></i>Haqqımızda — "Niyə Biz" Bölməsi</h1>
</div>

<form method="POST" action="{{ route('admin.home-why-us.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Section Title & Subtitle --}}
    <div class="form-card mb-4">
        <div class="section-title">Bölmə Başlığı</div>
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#wu-head-az">🇦🇿 AZ</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#wu-head-en">🇬🇧 EN</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#wu-head-ru">🇷🇺 RU</a></li>
        </ul>
        <div class="tab-content">
            @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
            <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="wu-head-{{ $lang }}">
                <div class="mb-3">
                    <label class="form-label">Başlıq ({{ $lbl }})</label>
                    <input type="text" name="title[{{ $lang }}]" class="form-control"
                           value="{{ old('title.'.$lang, $whyUs->getTranslation('title', $lang, false)) }}"
                           placeholder="Niyə 166 Usta Xidmətini Seçməlisiniz?">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alt Başlıq / Kənar Mətn ({{ $lbl }})</label>
                    <textarea name="subtitle[{{ $lang }}]" class="form-control" rows="2">{{ old('subtitle.'.$lang, $whyUs->getTranslation('subtitle', $lang, false)) }}</textarea>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Items --}}
    @php $existingItems = $whyUs->items ?? []; @endphp
    @for($i = 0; $i < 4; $i++)
    @php $item = $existingItems[$i] ?? []; @endphp
    <div class="form-card mb-4">
        <div class="section-title">{{ $i + 1 }}. Üstünlük</div>
        <div class="row g-3">
            <div class="col-lg-3">
                @if(!empty($item['image']))
                    <img src="{{ Storage::url($item['image']) }}" class="w-100 rounded mb-2" style="max-height:120px;object-fit:cover;">
                @endif
                <input type="file" name="item_img[{{ $i }}]" class="form-control" accept="image/*">
                <div class="form-text">Şəkil (tövsiyə: 500×400 px)</div>
            </div>
            <div class="col-lg-9">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#wu-item{{ $i }}-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#wu-item{{ $i }}-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#wu-item{{ $i }}-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="wu-item{{ $i }}-{{ $lang }}">
                        <div class="mb-2">
                            <label class="form-label">Başlıq ({{ $lbl }})</label>
                            <input type="text" name="item_title[{{ $i }}][{{ $lang }}]" class="form-control"
                                   value="{{ old("item_title.{$i}.{$lang}", $item['title'][$lang] ?? '') }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Açıqlama ({{ $lbl }})</label>
                            <textarea name="item_desc[{{ $i }}][{{ $lang }}]" class="form-control ckeditor" rows="4">{{ old("item_desc.{$i}.{$lang}", $item['description'][$lang] ?? '') }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endfor

    <button type="submit" class="btn px-5" style="background:#ff6b35;color:#fff;padding:12px 32px;font-weight:600;border-radius:8px;">
        <i class="bi bi-check-lg me-2"></i>Yadda Saxla
    </button>
</form>
@endsection
