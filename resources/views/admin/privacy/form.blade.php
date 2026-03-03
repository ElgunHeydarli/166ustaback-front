@extends('admin.layouts.app')
@section('title', 'Məxfilik Siyasəti')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-shield-lock me-2" style="color:#ff6b35"></i>Məxfilik Siyasəti</h1>
</div>

<form method="POST" action="{{ route('admin.privacy.update') }}">
    @csrf
    @method('PUT')

    <div class="form-card mb-4">
        <div class="section-title">Məzmun</div>
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#prv-az">🇦🇿 AZ</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prv-en">🇬🇧 EN</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#prv-ru">🇷🇺 RU</a></li>
        </ul>
        <div class="tab-content">
            @foreach(['az'=>'AZ','en'=>'EN','ru'=>'RU'] as $lang=>$lbl)
            <div class="tab-pane fade {{ $lang==='az'?'show active':'' }}" id="prv-{{ $lang }}">
                <div class="mb-3">
                    <label class="form-label">Məzmun ({{ $lbl }})</label>
                    <textarea name="content[{{ $lang }}]" class="form-control ckeditor" rows="20">{{ old('content.'.$lang, $page->getTranslation('content', $lang, false)) }}</textarea>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn px-5" style="background:#ff6b35;color:#fff;padding:12px 32px;font-weight:600;border-radius:8px;">
        <i class="bi bi-check-lg me-2"></i>Yadda Saxla
    </button>
</form>
@endsection
