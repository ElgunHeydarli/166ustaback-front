@extends('admin.layouts.app')
@section('title', 'Sliderlər')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-images me-2" style="color:#ff6b35"></i>Sliderlər</h1>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Slider
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Şəkil</th><th>Başlıq</th><th>Alt Başlıq</th><th>Düymə</th><th>Status</th><th>Sıra</th><th>Əməliyyat</th></tr></thead>
            <tbody>
                @forelse($sliders as $slider)
                <tr>
                    <td class="text-muted small">{{ $slider->id }}</td>
                    <td><img src="{{ Storage::url($slider->image) }}" style="height:48px;width:80px;object-fit:cover;border-radius:6px;"></td>
                    <td class="fw-semibold">{{ $slider->title ?? '—' }}</td>
                    <td class="text-muted small">{{ Str::limit(strip_tags($slider->subtitle), 40) ?? '—' }}</td>
                    <td class="small">{{ $slider->button_text ?? '—' }}</td>
                    <td>
                        @if($slider->is_active)<span class="badge-active">Aktiv</span>
                        @else<span class="badge-inactive">Gizli</span>@endif
                    </td>
                    <td class="text-center">{{ $slider->order }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" onsubmit="return confirm('Silmek?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hele slider yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
