@extends('admin.layouts.app')
@section('title', $testimonial->exists ? 'Rəy Düzəlt' : 'Yeni Rəy')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-chat-quote me-2" style="color:#ff6b35"></i>{{ $testimonial->exists ? 'Rəy Düzəlt' : 'Yeni Rəy' }}</h1>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" enctype="multipart/form-data">
    @csrf
    @if($testimonial->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="mb-3">
                    <label class="form-label">Müştəri Adı <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $testimonial->customer_name) }}" required>
                </div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#test-az">🇦🇿 AZ</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#test-en">🇬🇧 EN</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#test-ru">🇷🇺 RU</a></li>
                </ul>
                <div class="tab-content">
                    @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
                    <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="test-{{ $lang }}">
                        <div class="mb-3">
                            <label class="form-label">Mövqe / Peşə ({{ $lbl }})</label>
                            <input type="text" name="position[{{ $lang }}]" class="form-control"
                                   value="{{ old('position.'.$lang, $testimonial->getTranslation('position',$lang,false)) }}" placeholder="Ev sahibəsi, Müdür...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rəy Mətni ({{ $lbl }}) @if($lang==='az')<span class="text-danger">*</span>@endif</label>
                            <textarea name="review_text[{{ $lang }}]" class="form-control" rows="4">{{ old('review_text.'.$lang, $testimonial->getTranslation('review_text',$lang,false)) }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mb-3 mt-2">
                    <label class="form-label">Xidmət</label>
                    <select name="service_id" class="form-select">
                        <option value="">— Seçin —</option>
                        @foreach($services as $id => $name)
                            <option value="{{ $id }}" {{ old('service_id', $testimonial->service_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Reytinq</label>
                    <select name="rating" class="form-select" style="max-width:150px;">
                        @for($i=5; $i>=1; $i--)
                            <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>{{ $i }} ulduz</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <div class="section-title">Parametrlər</div>
                <div class="mb-3">
                    <label class="form-label">Sıra</label>
                    <input type="number" name="order" class="form-control" min="0" value="{{ old('order', $testimonial->order ?? 0) }}">
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
            </div>
            <div class="form-card">
                <div class="section-title">Foto</div>
                @if($testimonial->photo)
                    <img src="{{ Storage::url($testimonial->photo) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;" class="mb-2">
                @endif
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $testimonial->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
