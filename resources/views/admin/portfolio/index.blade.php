@extends('admin.layouts.app')
@section('title', 'Portfolio')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-collection me-2" style="color:#ff6b35"></i>Portfolio</h1>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Portfolio
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Şəkil</th><th>Başlıq</th><th>Xidmət</th><th>Status</th><th>Sıra</th><th>Əməliyyat</th></tr></thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td class="text-muted small">{{ $item->id }}</td>
                    <td>
                        @if($item->cover_image)
                            <img src="{{ Storage::url($item->cover_image) }}" class="img-thumb">
                        @else
                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $item->title }}</td>
                    <td>{{ $item->service?->title ?? '—' }}</td>
                    <td>
                        @if($item->is_active)<span class="badge-active">Aktiv</span>
                        @else<span class="badge-inactive">Gizli</span>@endif
                    </td>
                    <td class="text-center">{{ $item->order }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.portfolio.edit', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.portfolio.destroy', $item) }}" onsubmit="return confirm('Silmek?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hele portfolio yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($items->hasPages())<div class="p-3">{{ $items->links() }}</div>@endif
</div>
@endsection
