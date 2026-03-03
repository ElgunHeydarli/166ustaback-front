@extends('admin.layouts.app')
@section('title', $link->exists ? 'Link Düzəlt' : 'Yeni Sosial Link')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-share me-2" style="color:#ff6b35"></i>{{ $link->exists ? 'Link Düzəlt' : 'Yeni Sosial Link' }}</h1>
    <a href="{{ route('admin.social-links.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Geri
    </a>
</div>

<form method="POST"
      action="{{ $link->exists ? route('admin.social-links.update', $link) : route('admin.social-links.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if($link->exists) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="mb-3">
                    <label class="form-label">Ad <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $link->name) }}"
                           placeholder="Facebook, Instagram, WhatsApp..."
                           required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Link <span class="text-danger">*</span></label>
                    <input type="text" name="url" class="form-control"
                           value="{{ old('url', $link->url) }}"
                           placeholder="https://... və ya tel: nömrəsi"
                           required>
                    <div class="form-text">WhatsApp üçün: <code>https://wa.me/994501234567</code></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">İkon / Şəkil</label>
                    @if($link->icon)
                        <div class="mb-2">
                            <img src="{{ Storage::url($link->icon) }}" style="width:48px;height:48px;object-fit:contain;border:1px solid #eee;border-radius:8px;padding:4px;">
                        </div>
                    @endif
                    <input type="file" name="icon" class="form-control" accept="image/*,.svg">
                    <div class="form-text">SVG, PNG, JPG — şəffaf fon tövsiyə edilir</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-card">
                <div class="section-title">Parametrlər</div>
                <div class="mb-3">
                    <label class="form-label">Sıra</label>
                    <input type="number" name="order" class="form-control" min="0"
                           value="{{ old('order', $link->order ?? 0) }}">
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $link->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
            </div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $link->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
