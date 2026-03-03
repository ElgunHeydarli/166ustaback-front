@extends('admin.layouts.app')
@section('title', $partner->exists ? 'Tərəfdaş Düzəlt' : 'Yeni Tərəfdaş')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-building me-2" style="color:#ff6b35"></i>{{ $partner->exists ? 'Tərəfdaş Düzəlt' : 'Yeni Tərəfdaş' }}</h1>
    <a href="{{ route('admin.partners.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}" enctype="multipart/form-data">
    @csrf
    @if($partner->exists) @method('PUT') @endif
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="form-card">
                <div class="mb-3">
                    <label class="form-label">Logo <span class="text-danger">*</span></label>
                    @if($partner->exists && $partner->logo)
                        <div class="mb-2"><img src="{{ Storage::url($partner->logo) }}" style="height:60px;object-fit:contain;"></div>
                    @endif
                    <input type="file" name="logo" class="form-control" accept="image/*,.svg" {{ !$partner->exists ? 'required' : '' }}>
                    <div class="form-text">PNG, SVG tövsiyə olunur (şəffaf fon)</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sıra</label>
                    <input type="number" name="order" class="form-control" min="0" value="{{ old('order', $partner->order ?? 0) }}">
                </div>
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                           {{ old('is_active', $partner->is_active ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Aktiv</label>
                </div>
                <button type="submit" class="btn" style="background:#ff6b35;color:#fff;padding:10px 28px;font-weight:600;border-radius:8px;">
                    <i class="bi bi-check-lg me-2"></i>{{ $partner->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
