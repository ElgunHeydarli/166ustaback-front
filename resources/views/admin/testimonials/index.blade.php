@extends('admin.layouts.app')
@section('title', 'Rəylər')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-chat-quote me-2" style="color:#ff6b35"></i>Müştəri Rəyləri</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Rəy
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Foto</th><th>Ad</th><th>Mövqe</th><th>Xidmət</th><th>Reytinq</th><th>Status</th><th>Əməliyyat</th></tr></thead>
            <tbody>
                @forelse($testimonials as $t)
                <tr>
                    <td class="text-muted small">{{ $t->id }}</td>
                    <td>
                        @if($t->photo)
                            <img src="{{ Storage::url($t->photo) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                        @else
                            <div style="width:40px;height:40px;border-radius:50%;background:#f0f0f0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-person text-muted"></i></div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $t->customer_name }}</td>
                    <td class="text-muted small">{{ $t->getTranslation('position', 'az', false) ?: '—' }}</td>
                    <td>{{ $t->service?->getTranslation('title', 'az') ?? '—' }}</td>
                    <td>
                        @for($i=1; $i<=5; $i++)
                            <i class="bi bi-star{{ $i <= $t->rating ? '-fill' : '' }}" style="color:#f59e0b;font-size:.75rem;"></i>
                        @endfor
                    </td>
                    <td>
                        @if($t->is_active)<span class="badge-active">Aktiv</span>
                        @else<span class="badge-inactive">Gizli</span>@endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('Silmek?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hele rey yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($testimonials->hasPages())<div class="p-3">{{ $testimonials->links() }}</div>@endif
</div>
@endsection
