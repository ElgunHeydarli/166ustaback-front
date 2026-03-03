<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — 166 Usta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --sidebar-width:260px; --sidebar-bg:#1a1d23; --accent:#ff6b35; --header-h:60px; }
        body { background:#f0f2f5; font-family:"Segoe UI",sans-serif; }
        .sidebar { position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-width);background:var(--sidebar-bg);overflow-y:auto;z-index:1000; }
        .sidebar-brand { display:flex;align-items:center;padding:20px;border-bottom:1px solid rgba(255,255,255,.08);text-decoration:none; }
        .sidebar-brand span { color:#fff;font-size:1.2rem;font-weight:700; }
        .sidebar-brand em { color:var(--accent);font-style:normal; }
        .nav-section { padding:16px 20px 6px;font-size:.7rem;text-transform:uppercase;letter-spacing:1px;color:#555;font-weight:600; }
        .nav-link-item { display:flex;align-items:center;gap:10px;padding:10px 20px;color:#adb5bd;text-decoration:none;transition:.2s;font-size:.88rem; }
        .nav-link-item:hover,.nav-link-item.active { color:#fff;background:rgba(255,107,53,.15);border-left:3px solid var(--accent); }
        .nav-link-item i { font-size:1rem;width:20px;text-align:center; }
        .main-header { position:fixed;top:0;left:var(--sidebar-width);right:0;height:var(--header-h);background:#fff;z-index:999;display:flex;align-items:center;padding:0 24px;box-shadow:0 1px 4px rgba(0,0,0,.08); }
        .main-content { margin-left:var(--sidebar-width);padding-top:calc(var(--header-h) + 24px);padding-bottom:40px; }
        .content-wrapper { padding:0 24px; }
        .stat-card { background:#fff;border-radius:12px;padding:20px 24px;box-shadow:0 1px 4px rgba(0,0,0,.06);display:flex;align-items:center;gap:16px;transition:.2s;height:100%; }
        .stat-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.1);transform:translateY(-2px); }
        .stat-icon { width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0; }
        .stat-val { font-size:1.8rem;font-weight:700;line-height:1; }
        .stat-lbl { font-size:.8rem;color:#888;margin-top:2px; }
        .admin-table { background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.06); }
        .admin-table thead th { background:#f8f9fa;font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;color:#666;border-bottom:2px solid #e9ecef;padding:12px 16px;white-space:nowrap; }
        .admin-table td { padding:12px 16px;vertical-align:middle; }
        .form-card { background:#fff;border-radius:12px;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,.06); }
        .form-label { font-size:.85rem;font-weight:600;color:#444; }
        .section-title { font-size:.7rem;text-transform:uppercase;letter-spacing:1px;color:#999;font-weight:700;padding:8px 0;margin-bottom:12px;border-bottom:2px solid rgba(255,107,53,.15); }
        .badge-active { background:#d1fae5;color:#065f46;padding:4px 10px;border-radius:20px;font-size:.75rem;display:inline-block; }
        .badge-inactive { background:#fee2e2;color:#991b1b;padding:4px 10px;border-radius:20px;font-size:.75rem;display:inline-block; }
        .page-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:24px; }
        .page-header h1 { font-size:1.4rem;font-weight:700;margin:0; }
        .img-thumb { width:48px;height:48px;object-fit:cover;border-radius:8px; }
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
        <span><em>166</em> Usta Admin</span>
    </a>
    <nav>
        <div class="nav-section">Əsas</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <div class="nav-section">Kontent</div>
        <a href="{{ route('admin.sliders.index') }}" class="nav-link-item {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Sliderlər
        </a>
        <a href="{{ route('admin.home-about.edit') }}" class="nav-link-item {{ request()->routeIs('admin.home-about*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Əsas Səhifə Haqqımızda
        </a>
        <a href="{{ route('admin.home-why-us.edit') }}" class="nav-link-item {{ request()->routeIs('admin.home-why-us*') ? 'active' : '' }}">
            <i class="bi bi-patch-check"></i> Haqqımızda — Niyə Biz
        </a>
        <a href="{{ route('admin.home-cta.edit') }}" class="nav-link-item {{ request()->routeIs('admin.home-cta*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Əsas Səhifə CTA
        </a>
        <a href="{{ route('admin.services.index') }}" class="nav-link-item {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
            <i class="bi bi-tools"></i> Xidmətlər
        </a>
        <a href="{{ route('admin.portfolio.index') }}" class="nav-link-item {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}">
            <i class="bi bi-collection"></i> Portfolio
        </a>
        <a href="{{ route('admin.blog.index') }}" class="nav-link-item {{ request()->routeIs('admin.blog.index') || request()->routeIs('admin.blog.create') || request()->routeIs('admin.blog.edit') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Bloq
        </a>
        <a href="{{ route('admin.blog-tags.index') }}" class="nav-link-item {{ request()->routeIs('admin.blog-tags*') ? 'active' : '' }}" style="padding-left:2.2rem;font-size:.85rem;">
            <i class="bi bi-tags"></i> Bloq Tagları
        </a>
        <a href="{{ route('admin.boxes.index') }}" class="nav-link-item {{ request()->routeIs('admin.boxes*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Qutular
        </a>
        <a href="{{ route('admin.campaigns.index') }}" class="nav-link-item {{ request()->routeIs('admin.campaigns*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Kampaniyalar
        </a>
        <a href="{{ route('admin.partners.index') }}" class="nav-link-item {{ request()->routeIs('admin.partners*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Tərəfdaşlar
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="nav-link-item {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
            <i class="bi bi-chat-quote"></i> Rəylər
        </a>
        <a href="{{ route('admin.social-links.index') }}" class="nav-link-item {{ request()->routeIs('admin.social-links*') ? 'active' : '' }}">
            <i class="bi bi-share"></i> Sosial Linklər
        </a>
        <div class="nav-section">Mesajlar</div>
        <a href="{{ route('admin.messages.index') }}" class="nav-link-item {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Mesajlar
            @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
            @if($unread > 0)
                <span class="badge bg-danger ms-auto">{{ $unread }}</span>
            @endif
        </a>
        <div class="nav-section">Sistem</div>
        <a href="{{ route('admin.privacy.edit') }}" class="nav-link-item {{ request()->routeIs('admin.privacy*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Məxfilik Siyasəti
        </a>
        <a href="{{ route('admin.settings.index') }}" class="nav-link-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Parametrlər
        </a>
    </nav>
</aside>
<header class="main-header">
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-muted small"><i class="bi bi-person-circle me-1"></i>{{ auth('admin')->user()->name }}</span>
        <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Çıxış
            </button>
        </form>
    </div>
</header>
<main class="main-content">
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
document.querySelectorAll('.ckeditor').forEach(function(textarea) {
    ClassicEditor.create(textarea, {
        toolbar: ['heading','|','bold','italic','underline','|','bulletedList','numberedList','|','link','blockQuote','|','undo','redo'],
        language: 'az'
    }).then(function(editor) {
        var form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                textarea.value = editor.getData();
            });
        }
    }).catch(console.error);
});
</script>
@stack('scripts')
</body>
</html>
