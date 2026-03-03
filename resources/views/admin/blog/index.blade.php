@extends('admin.layouts.app')
@section('title', 'Bloq')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-journal-text me-2" style="color:#ff6b35"></i>Bloq Yazıları</h1>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Yazı
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>#</th><th>Şəkil</th><th>Başlıq</th><th>Slug</th>
                <th>Status</th><th>Tarix</th><th>Əməliyyat</th>
            </tr></thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td class="text-muted small">{{ $post->id }}</td>
                    <td>
                        @if($post->cover_image)
                            <img src="{{ Storage::url($post->cover_image) }}" class="img-thumb">
                        @else
                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $post->getTranslation('title', 'az') }}</td>
                    <td><code class="small">{{ $post->getTranslation('slug', 'az') }}</code></td>
                    <td>
                        @if($post->is_active)<span class="badge-active">Aktiv</span>
                        @else<span class="badge-inactive">Gizli</span>@endif
                    </td>
                    <td class="text-muted small">{{ $post->published_at?->format('d.m.Y') ?? $post->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Silmek istediginize eminsiniz?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hele yazi yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
    <div class="p-3">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
