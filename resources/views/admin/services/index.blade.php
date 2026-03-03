@extends('admin.layouts.app')
@section('title', 'Xidmətlər')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-tools me-2" style="color:#ff6b35"></i>Xidmətlər</h1>
    <a href="{{ route('admin.services.create') }}" class="btn btn-sm" style="background:#ff6b35;color:#fff;border-radius:8px;">
        <i class="bi bi-plus-lg me-1"></i>Yeni Xidmət
    </a>
</div>

<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Şəkil</th>
                    <th>Başlıq</th>
                    <th>Slug</th>
                    <th>Menyu</th>
                    <th>Status</th>
                    <th>Sıra</th>
                    <th>Əməliyyat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td class="text-muted small">{{ $service->id }}</td>
                    <td>
                        @if($service->image)
                            <img src="{{ Storage::url($service->image) }}" class="img-thumb" alt="">
                        @else
                            <div class="img-thumb bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $service->getTranslation('title', 'az') }}</td>
                    <td><code class="small">{{ $service->getTranslation('slug', 'az') }}</code></td>
                    <td>
                        @if($service->show_in_menu)
                            <span class="badge-active">Bəli</span>
                        @else
                            <span class="badge-inactive">Xeyr</span>
                        @endif
                    </td>
                    <td>
                        @if($service->is_active)
                            <span class="badge-active">Aktiv</span>
                        @else
                            <span class="badge-inactive">Gizli</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $service->order }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                  onsubmit="return confirm('Silmək istədiyinizə əminsiniz?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>Hələ xidmət yoxdur.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
