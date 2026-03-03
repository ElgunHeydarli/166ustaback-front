<!doctype html>
<html lang="az">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>500 — Server xətası | 166 Usta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
        }
        .error-code {
            font-size: clamp(80px, 20vw, 160px);
            font-weight: 800;
            color: #ff6b35;
            line-height: 1;
            letter-spacing: -4px;
        }
        .error-title {
            font-size: clamp(20px, 4vw, 32px);
            font-weight: 700;
            color: #1a1a1a;
            margin: 16px 0 12px;
        }
        .error-desc {
            font-size: 16px;
            color: #666;
            max-width: 440px;
            line-height: 1.6;
            margin: 0 auto 36px;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #ff6b35;
            color: #fff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: background 0.2s;
        }
        .btn-home:hover { background: #e55a24; }
        .decoration {
            font-size: 80px;
            margin-bottom: 8px;
            line-height: 1;
        }
    </style>
</head>
<body>
    <div class="decoration">⚙️</div>
    <div class="error-code">500</div>
    <h1 class="error-title">Server xətası</h1>
    <p class="error-desc">
        Texniki problem baş verdi. Komandamız bu barədə məlumatlandırılıb. Bir az sonra yenidən cəhd edin.
    </p>
    <a href="/az" class="btn-home">
        ← Ana səhifəyə qayıt
    </a>
</body>
</html>
