@extends('admin.layouts.app')
@section('title', 'Bloq Tagları')
@section('content')
<div class="page-header">
    <h1><i class="bi bi-tags me-2" style="color:#ff6b35"></i>Bloq Tagları</h1>
    <a href="{{ route('admin.blog-tags.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Tag
    </a>
</div>
<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>#</th><th>Ad</th><th>Slug</th><th>Yazı sayı</th><th>Əməliyyat</th>
            </tr></thead>
            <tbody>
                @forelse($tags as $tag)
                <tr>
                    <td class="text-muted small">{{ $tag->id }}</td>
                    <td class="fw-semibold">{{ $tag->name }}</td>
                    <td><code class="small">{{ $tag->slug }}</code></td>
                    <td><span class="badge bg-secondary">{{ $tag->posts_count }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.blog-tags.edit', $tag) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.blog-tags.destroy', $tag) }}" onsubmit="return confirm('Silmek istediginize eminsiniz?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Hələ tag yoxdur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tags->hasPages())
    <div class="p-3">{{ $tags->links() }}</div>
    @endif
</div>
@endsection
