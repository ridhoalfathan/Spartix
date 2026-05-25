<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — RAYA-E Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
        }

        /* ── LEFT PANEL ─────────────────────────────── */
        .panel-left {
            width: 480px;
            flex-shrink: 0;
            background: linear-gradient(160deg, #1e3a8a 0%, #1e40af 40%, #2563eb 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px;
            position: relative;
            overflow: hidden;
        }

        /* grid pattern overlay */
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* glow blob */
        .panel-left::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96,165,250,.25) 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
            pointer-events: none;
        }

        .brand {
            position: relative;
            z-index: 1;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 48px;
        }

        .brand-icon {
            width: 72px;
            height: 72px;
            background: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0,0,0,.2);
            overflow: hidden;
            flex-shrink: 0;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .brand-icon-fallback {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e40af;
        }

        .brand-name {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-tagline {
            font-size: 0.7rem;
            color: rgba(255,255,255,.6);
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .panel-headline {
            position: relative;
            z-index: 1;
        }

        .panel-headline h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 16px;
        }

        .panel-headline p {
            font-size: 0.95rem;
            color: rgba(255,255,255,.7);
            line-height: 1.7;
            font-weight: 400;
            max-width: 340px;
        }

        .feature-list {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,.85);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .feature-item i {
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,.12);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            border: 1px solid rgba(255,255,255,.1);
        }

        .panel-footer {
            position: relative;
            z-index: 1;
            font-size: 0.75rem;
            color: rgba(255,255,255,.4);
            font-weight: 500;
        }

        /* ── RIGHT PANEL ─────────────────────────────── */
        .panel-right {
            flex: 1;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            margin-bottom: 36px;
        }

        .login-header .badge-admin {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 5px 12px;
            border-radius: 20px;
            margin-bottom: 16px;
            border: 1px solid #bfdbfe;
        }

        .login-header h2 {
            font-size: 1.875rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 400;
        }

        /* Alert */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert i { font-size: 1rem; flex-shrink: 0; }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: white;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            font-weight: 500;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-wrap input::placeholder { color: #cbd5e1; font-weight: 400; }

        .input-wrap input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        .input-wrap input:hover:not(:focus) { border-color: #cbd5e1; }

        /* toggle password */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 1rem;
            padding: 0;
            line-height: 1;
        }

        .toggle-pw:hover { color: #64748b; }

        /* Submit */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all .25s;
            box-shadow: 0 4px 14px rgba(37,99,235,.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37,99,235,.4);
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
        }

        .btn-login:active { transform: translateY(0); }

        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .login-footer a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer a:hover { text-decoration: underline; }

        /* Divider */
        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 24px 0;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .panel-left { display: none; }
            body { background: #f8fafc; }
            .panel-right { padding: 32px 24px; }
        }
    </style>
</head>
<body>

{{-- LEFT PANEL --}}
<div class="panel-left">
    <div class="brand">
        <div class="brand-logo">
            <div class="brand-icon">
                <img src="{{ asset('Logo.png') }}" alt="Logo"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <span class="brand-icon-fallback" style="display:none;">R</span>
            </div>
            <div>
                <div class="brand-name">RAYA-E</div>
                <div class="brand-tagline">Admin Panel</div>
            </div>
        </div>

        <div class="panel-headline">
            <h1>Sistem Manajemen Inventori & Akuntansi</h1>
            <p>Platform terpadu untuk mengelola stok barang elektronik, transaksi penjualan, dan laporan keuangan secara real-time.</p>
        </div>
    </div>

    <div class="feature-list">
        <div class="feature-item">
            <i class="bi bi-boxes"></i>
            Manajemen stok dengan metode FIFO
        </div>
        <div class="feature-item">
            <i class="bi bi-receipt-cutoff"></i>
            Pencatatan transaksi & serial number
        </div>
        <div class="feature-item">
            <i class="bi bi-journal-text"></i>
            Jurnal umum & buku besar otomatis
        </div>
        <div class="feature-item">
            <i class="bi bi-bar-chart-line"></i>
            Laporan inventori & akuntansi lengkap
        </div>
    </div>

    <div class="panel-footer">
        &copy; {{ date('Y') }} RAYA-E &mdash; Sistem Manajemen Toko Elektronik
    </div>
</div>

{{-- RIGHT PANEL --}}
<div class="panel-right">
    <div class="login-box">

        <div class="login-header">
            <div class="badge-admin">
                <i class="bi bi-shield-lock-fill"></i>
                Akses Admin
            </div>
            <h2>Masuk ke Sistem</h2>
            <p>Masukkan kredensial akun Anda untuk melanjutkan</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="form-group">
                <label>Alamat Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email"
                           placeholder="nama@email.com"
                           value="{{ old('email') }}"
                           required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="passwordInput"
                           placeholder="Masukkan password"
                           required>
                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk
            </button>
        </form>

        <div class="divider"></div>

        <div class="login-footer">
            Butuh bantuan? Hubungi administrator sistem.
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>

</body>
</html>
