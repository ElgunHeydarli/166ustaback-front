@extends('admin.layouts.app')
@section('title', 'Sosial Linklər')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-share me-2" style="color:#ff6b35"></i>Sosial Linklər</h1>
    <a href="{{ route('admin.social-links.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Link
    </a>
</div>

<div class="form-card">
    @if($links->isEmpty())
        <p class="text-muted text-center py-4">Hələ heç bir sosial link əlavə edilməyib.</p>
    @else
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th style="width:50px">Sıra</th>
                <th style="width:60px">İkon</th>
                <th>Ad</th>
                <th>Link</th>
                <th style="width:80px">Status</th>
                <th style="width:100px"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($links as $link)
            <tr>
                <td>{{ $link->order }}</td>
                <td>
                    @if($link->icon)
                        <img src="{{ Storage::url($link->icon) }}" style="width:36px;height:36px;object-fit:contain;">
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $link->name }}</td>
                <td>
                    <a href="{{ $link->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width:250px;">
                        {{ $link->url }}
                    </a>
                </td>
                <td>
                    <span class="badge {{ $link->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $link->is_active ? 'Aktiv' : 'Deaktiv' }}
                    </span>
                </td>
                <td class="text-end">
                    <a href="{{ route('admin.social-links.edit', $link) }}" class="btn btn-sm btn-outline-secondary me-1">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.social-links.destroy', $link) }}" class="d-inline"
                          onsubmit="return confirm('Silmək istədiyinizdən əminsiniz?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
