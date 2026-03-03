@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-grid-1x2 me-2 text-warning"></i>Dashboard</h1>
    <span class="text-muted small">{{ now()->format('d.m.Y, H:i') }}</span>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    @php
    $cards = [
        ['label'=>'Xidmətlər',     'val'=>$stats['services'],        'icon'=>'bi-tools',        'color'=>'#fff3e0','ic'=>'#ff6b35'],
        ['label'=>'Portfolio',     'val'=>$stats['portfolio'],       'icon'=>'bi-collection',   'color'=>'#e3f2fd','ic'=>'#1976d2'],
        ['label'=>'Bloq',          'val'=>$stats['blogs'],           'icon'=>'bi-journal-text', 'color'=>'#e8f5e9','ic'=>'#2e7d32'],
        ['label'=>'Qutular',       'val'=>$stats['boxes'],           'icon'=>'bi-box-seam',     'color'=>'#fce4ec','ic'=>'#c62828'],
        ['label'=>'Kampaniyalar',  'val'=>$stats['campaigns'],       'icon'=>'bi-megaphone',    'color'=>'#f3e5f5','ic'=>'#6a1b9a'],
        ['label'=>'Tərəfdaşlar',   'val'=>$stats['partners'],        'icon'=>'bi-building',     'color'=>'#e0f7fa','ic'=>'#00838f'],
        ['label'=>'Rəylər',        'val'=>$stats['testimonials'],    'icon'=>'bi-chat-quote',   'color'=>'#fff8e1','ic'=>'#f9a825'],
        ['label'=>'Yeni Mesajlar', 'val'=>$stats['unread_messages'], 'icon'=>'bi-envelope-fill','color'=>'#fbe9e7','ic'=>'#d84315'],
    ];
    @endphp
    @foreach($cards as $c)
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:{{ $c['color'] }}">
                <i class="bi {{ $c['icon'] }}" style="color:{{ $c['ic'] }}"></i>
            </div>
            <div>
                <div class="stat-val">{{ $c['val'] }}</div>
                <div class="stat-lbl">{{ $c['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Son mesajlar --}}
<div class="form-card">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-envelope me-2 text-danger"></i>Son Mesajlar</h6>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">Hamısı</a>
    </div>
    @if($latest_messages->isEmpty())
        <p class="text-muted text-center py-3">Hələ mesaj yoxdur.</p>
    @else
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th class="small text-muted fw-semibold">Ad</th>
                <th class="small text-muted fw-semibold">Telefon</th>
                <th class="small text-muted fw-semibold">Xidmət</th>
                <th class="small text-muted fw-semibold">Tarix</th>
                <th></th>
            </tr></thead>
            <tbody>
                @foreach($latest_messages as $msg)
                <tr>
                    <td>
                        @if(!$msg->is_read)
                            <span class="badge bg-danger me-1">Yeni</span>
                        @endif
                        {{ $msg->name }}
                    </td>
                    <td>{{ $msg->phone }}</td>
                    <td>{{ $msg->service?->title ?? '—' }}</td>
                    <td class="text-muted small">{{ $msg->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
