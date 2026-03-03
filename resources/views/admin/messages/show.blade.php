@extends('admin.layouts.app')
@section('title', 'Mesaj')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-envelope-open me-2" style="color:#ff6b35"></i>Mesaj Detalı</h1>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Geri
    </a>
</div>
<div class="row g-4">
    <div class="col-md-6">
        <div class="form-card">
            <div class="section-title">Göndərən Məlumatı</div>
            <table class="table table-borderless mb-0">
                <tr><th class="ps-0 text-muted small" style="width:140px">Ad Soyad</th><td class="fw-semibold">{{ $message->name }}</td></tr>
                <tr><th class="ps-0 text-muted small">Telefon</th><td><a href="tel:{{ $message->phone }}">{{ $message->phone }}</a></td></tr>
                <tr><th class="ps-0 text-muted small">Xidmət</th><td>{{ $message->service?->getTranslation('title', 'az') ?? '—' }}</td></tr>
                <tr><th class="ps-0 text-muted small">Tarix</th><td>{{ $message->created_at->format('d.m.Y H:i') }}</td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-card">
            <div class="section-title">Mesaj Mətni</div>
            <p class="mb-0">{{ $message->message ?: 'Mesaj yoxdur.' }}</p>
        </div>
    </div>
</div>
<div class="mt-3 d-flex gap-2">
    <a href="tel:{{ $message->phone }}" class="btn btn-success">
        <i class="bi bi-telephone me-1"></i>Zəng et
    </a>
    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Silmek?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i>Sil</button>
    </form>
</div>
@endsection
