@extends('admin.layouts.app')
@section('title', 'Kampaniyalar')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-megaphone me-2" style="color:#ff6b35"></i>Xüsusi Kampaniyalar</h1>
    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Kampaniya
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Şəkil</th><th>Başlıq</th><th>Başlama</th><th>Bitmə</th><th>Status</th><th>Əməliyyat</th></tr></thead>
            <tbody>
                @forelse($campaigns as $c)
                <tr>
                    <td class="text-muted small">{{ $c->id }}</td>
                    <td>
                        @if($c->cover_image)
                            <img src="{{ Storage::url($c->cover_image) }}" class="img-thumb">
                        @else
                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $c->title }}</td>
                    <td class="text-muted small">{{ $c->starts_at?->format('d.m.Y') ?? '—' }}</td>
                    <td class="text-muted small">{{ $c->ends_at?->format('d.m.Y') ?? '—' }}</td>
                    <td>
                        @if($c->is_active)<span class="badge-active">Aktiv</span>
                        @else<span class="badge-inactive">Gizli</span>@endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.campaigns.edit', $c) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.campaigns.destroy', $c) }}" onsubmit="return confirm('Silmek?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hele kampaniya yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($campaigns->hasPages())<div class="p-3">{{ $campaigns->links() }}</div>@endif
</div>
@endsection
