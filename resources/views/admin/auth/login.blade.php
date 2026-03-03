<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş — 166 Usta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: linear-gradient(135deg, #1a1d23 0%, #2d3748 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: "Segoe UI", sans-serif; }
        .login-card { background: #fff; border-radius: 16px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,.3); }
        .login-logo { text-align: center; margin-bottom: 32px; }
        .login-logo h1 { font-size: 2rem; font-weight: 800; color: #1a1d23; }
        .login-logo h1 em { color: #ff6b35; font-style: normal; }
        .login-logo p { color: #888; font-size: .9rem; margin: 4px 0 0; }
        .form-control:focus { border-color: #ff6b35; box-shadow: 0 0 0 .2rem rgba(255,107,53,.15); }
        .btn-login { background: #ff6b35; border: none; color: #fff; padding: 12px; font-weight: 600; border-radius: 8px; transition: .2s; }
        .btn-login:hover { background: #e55a26; color: #fff; }
        .input-group-text { background: #f8f9fa; border-color: #dee2e6; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <h1><em>166</em> Usta</h1>
            <p>Admin Paneli</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 mb-3 rounded-3">
                <i class="bi bi-x-circle-fill me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="admin@166usta.az" autofocus required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold small">Şifrə</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <div class="mb-4 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Xatırla məni</label>
                </div>
            </div>
            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Daxil ol
            </button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
