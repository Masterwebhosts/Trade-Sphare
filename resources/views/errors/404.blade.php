@php
    $user = auth()->user();

    $redirectUrl = match($user?->role) {
        'admin' => url('/admin/dashboard'),
        'publisher' => url('/publisher'),
        'advertiser' => url('/advertiser'),
        default => url('/'),
    };
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>404 - الصفحة غير موجودة | Trade Sphare</title>
    <link rel="icon" href="{{ asset('icons/favicon.ico') }}">
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; width: 100%; min-height: 100%; }
        body { font-family: Arial, Tahoma, sans-serif; background: #fff; color: #111827; }
        .error-page {
            min-height: 100vh; width: 100%; display: flex; align-items: center; justify-content: center;
            padding: 40px 20px; position: relative; overflow: hidden;
            background: linear-gradient(180deg, #fff 0%, #f8fafc 100%);
        }
        .background-shape {
            position: absolute; width: 420px; height: 420px; border-radius: 50%;
            background: rgba(37, 99, 235, .045); top: -220px; right: -150px; pointer-events: none;
        }
        .background-shape-bottom {
            position: absolute; width: 350px; height: 350px; border-radius: 50%;
            background: rgba(79, 70, 229, .04); bottom: -190px; left: -140px; pointer-events: none;
        }
        .error-content { position: relative; z-index: 2; width: 100%; max-width: 650px; text-align: center; }
        .logo {
            display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: #111827;
            font-size: 22px; font-weight: 800; margin-bottom: 40px;
        }
        .logo-icon {
            width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;
            border-radius: 11px; background: #2563eb; color: #fff; font-size: 16px; font-weight: 800;
        }
        .error-number {
            margin: 0; font-size: clamp(100px, 18vw, 180px); line-height: .85; font-weight: 900;
            letter-spacing: -8px; color: #2563eb;
        }
        h1 { margin: 35px 0 15px; font-size: clamp(28px, 4vw, 38px); font-weight: 800; color: #111827; }
        .main-text { max-width: 560px; margin: 0 auto; color: #64748b; font-size: 16px; line-height: 1.9; }
        .brand-text { max-width: 560px; margin: 12px auto 0; color: #64748b; font-size: 14px; line-height: 1.8; }
        .brand-text strong { color: #2563eb; }
        .actions { display: flex; justify-content: center; align-items: center; gap: 12px; margin-top: 30px; flex-wrap: wrap; }
        .button {
            display: inline-flex; align-items: center; justify-content: center; min-width: 190px; height: 48px;
            padding: 0 22px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 700;
            transition: background .2s ease, transform .2s ease;
        }
        .button-primary { background: #2563eb; color: #fff; }
        .button-primary:hover { background: #1d4ed8; transform: translateY(-1px); }
        .button-secondary { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }
        .button-secondary:hover { background: #e2e8f0; transform: translateY(-1px); }
        .redirect { margin-top: 22px; color: #94a3b8; font-size: 13px; }
        #seconds { color: #2563eb; font-weight: 700; }
        .footer { margin-top: 35px; color: #94a3b8; font-size: 12px; }
        @media (max-width: 600px) {
            .error-page { padding: 30px 18px; }
            .logo { margin-bottom: 30px; font-size: 20px; }
            .error-number { font-size: 110px; letter-spacing: -5px; }
            h1 { margin-top: 28px; font-size: 27px; }
            .main-text { font-size: 15px; }
            .actions { flex-direction: column; width: 100%; }
            .button { width: 100%; max-width: 320px; }
            .background-shape { width: 250px; height: 250px; top: -130px; right: -100px; }
            .background-shape-bottom { width: 220px; height: 220px; bottom: -120px; left: -100px; }
        }
    </style>
</head>
<body>
<div class="error-page">
    <div class="background-shape"></div>
    <div class="background-shape-bottom"></div>
    <main class="error-content">
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-icon">TS</span>
            Trade Sphare
        </a>
        <div class="error-number">404</div>
        <h1>الصفحة غير موجودة</h1>
        <p class="main-text">
            عذرًا، الصفحة التي تبحث عنها غير موجودة أو ربما تم نقلها إلى عنوان آخر.
        </p>
        <p class="brand-text">
            <strong>Trade Sphare</strong>
            منصة إعلانية متكاملة تساعد الشركات والأفراد على إدارة الحملات والوصول إلى الجمهور المناسب.
        </p>
        <div class="actions">
            <a href="{{ $redirectUrl }}" class="button button-primary">العودة إلى Trade Sphare</a>
            <a href="javascript:history.back()" class="button button-secondary">العودة للصفحة السابقة</a>
        </div>
        <div class="redirect">
            سيتم تحويلك تلقائيًا خلال <span id="seconds">8</span> ثوانٍ
        </div>
        <div class="footer">© {{ date('Y') }} Trade Sphare — جميع الحقوق محفوظة</div>
    </main>
</div>
<script>
    let seconds = 8;
    const counter = document.getElementById('seconds');
    const redirectUrl = @json($redirectUrl);
    const timer = setInterval(function () {
        seconds--;
        counter.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = redirectUrl;
        }
    }, 1000);
</script>
</body>
</html>
