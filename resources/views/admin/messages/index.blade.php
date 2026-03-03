@extends('admin.layouts.app')
@section('title', 'Mesajlar')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-envelope me-2" style="color:#ff6b35"></i>Əlaqə Mesajları</h1>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>#</th><th>Ad</th><th>Telefon</th><th>Xidmət</th><th>Mesaj</th><th>Status</th><th>Tarix</th><th>Əməliyyat</th>
            </tr></thead>
            <tbody>
                @forelse($messages as $msg)
                <tr class="{{ !$msg->is_read ? 'table-warning' : '' }}">
                    <td class="text-muted small">{{ $msg->id }}</td>
                    <td class="fw-semibold">{{ $msg->name }}</td>
                    <td>{{ $msg->phone }}</td>
                    <td>{{ $msg->service?->getTranslation('title', 'az') ?? '—' }}</td>
                    <td class="text-muted small">{{ Str::limit($msg->message, 50) }}</td>
                    <td>
                        @if(!$msg->is_read)<span class="badge-inactive">Yeni</span>
                        @else<span class="badge-active">Oxundu</span>@endif
                    </td>
                    <td class="text-muted small">{{ $msg->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" onsubmit="return confirm('Silmek?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hele mesaj yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
    <div class="p-3">{{ $messages->links() }}</div>
    @endif
</div>
@endsection
