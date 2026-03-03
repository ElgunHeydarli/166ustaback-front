@extends('admin.layouts.app')
@section('title', $tag->exists ? 'Taqı Düzəlt' : 'Yeni Tag')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-tags me-2" style="color:#ff6b35"></i>{{ $tag->exists ? 'Taqı Düzəlt' : 'Yeni Tag' }}</h1>
    <a href="{{ route('admin.blog-tags.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Geri</a>
</div>
<form method="POST" action="{{ $tag->exists ? route('admin.blog-tags.update', $tag) : route('admin.blog-tags.store') }}">
    @csrf
    @if($tag->exists) @method('PUT') @endif
    <div class="form-card" style="max-width:500px;">
        <div class="mb-3">
            <label class="form-label">Tag adı <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $tag->name) }}" required>
            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn w-100" style="background:#ff6b35;color:#fff;padding:12px;font-weight:600;border-radius:8px;">
            <i class="bi bi-check-lg me-2"></i>{{ $tag->exists ? 'Yadda Saxla' : 'Əlavə Et' }}
        </button>
    </div>
</form>
@endsection
