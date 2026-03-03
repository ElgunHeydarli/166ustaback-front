@extends('admin.layouts.app')
@section('title', 'Qutular')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-box-seam me-2" style="color:#ff6b35"></i>Qutular (Boxes)</h1>
    <a href="{{ route('admin.boxes.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Qutu
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Şəkil</th><th>Başlıq</th><th>Kateqoriya</th><th>Qiymət</th><th>Status</th><th>Əməliyyat</th></tr></thead>
            <tbody>
                @forelse($boxes as $box)
                <tr>
                    <td class="text-muted small">{{ $box->id }}</td>
                    <td>
                        @if($box->cover_image)
                            <img src="{{ Storage::url($box->cover_image) }}" class="img-thumb">
                        @else
                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $box->title }}</td>
                    <td>{{ $box->category ?? '—' }}</td>
                    <td>{{ $box->price ? number_format($box->price, 2) . ' ₼' : '—' }}</td>
                    <td>
                        @if($box->is_active)<span class="badge-active">Aktiv</span>
                        @else<span class="badge-inactive">Gizli</span>@endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.boxes.edit', $box) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.boxes.destroy', $box) }}" onsubmit="return confirm('Silmek?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hele qutu yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($boxes->hasPages())<div class="p-3">{{ $boxes->links() }}</div>@endif
</div>
@endsection
