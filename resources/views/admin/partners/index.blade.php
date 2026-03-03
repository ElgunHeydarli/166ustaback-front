@extends('admin.layouts.app')
@section('title', 'Tərəfdaşlar')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-building me-2" style="color:#ff6b35"></i>Tərəfdaşlar</h1>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Tərəfdaş
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Logo</th><th>Status</th><th>Sıra</th><th>Əməliyyat</th></tr></thead>
            <tbody>
                @forelse($partners as $partner)
                <tr>
                    <td class="text-muted small">{{ $partner->id }}</td>
                    <td><img src="{{ Storage::url($partner->logo) }}" style="height:36px;max-width:100px;object-fit:contain;"></td>
                    <td>
                        @if($partner->is_active)<span class="badge-active">Aktiv</span>
                        @else<span class="badge-inactive">Gizli</span>@endif
                    </td>
                    <td class="text-center">{{ $partner->order }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('Silmek?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hələ tərəfdaş yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
