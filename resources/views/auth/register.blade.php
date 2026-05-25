<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - RAYA-E</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 50%, #dbeafe 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(37, 99, 235, 0.15);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        /* LEFT SIDE */
        .left {
            flex: 1;
            background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 60px 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left::before,
        .left::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .left::before {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        .left::after {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .logo-circle {
            width: 130px;
            height: 130px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
            border: 5px solid rgba(255, 255, 255, 0.2);
        }

        .logo-circle::after {
            content: '';
            position: absolute;
            inset: -8px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
            border-radius: 50%;
            z-index: -1;
        }

        .logo-circle img {
            width: 250%;
            height: 250%;
            object-fit: contain;
        }

        .logo-text {
            font-size: 3rem;
            font-weight: 900;
            color: #2563EB;
            letter-spacing: -2px;
        }

        .left h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 12px;
            text-align: center;
            position: relative;
            z-index: 1;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .left p {
            font-size: 0.95rem;
            opacity: 0.95;
            text-align: center;
            line-height: 1.7;
            max-width: 320px;
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        /* RIGHT SIDE */
        .right {
            flex: 1.2;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            margin-bottom: 8px;
            font-weight: 900;
            color: #1e3a8a;
            font-size: 2rem;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 30px;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.2rem;
            z-index: 1;
        }

        input {
            width: 100%;
            padding: 0.95rem 1rem 0.95rem 3.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            font-size: 0.9rem;
            outline: none;
            color: #1e3a8a;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        input::placeholder {
            color: #94a3b8;
            font-size: 0.875rem;
        }

        input:focus {
            border-color: #2563EB;
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        input:hover {
            border-color: #cbd5e1;
        }

        input[name="access_code"] {
            letter-spacing: 4px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn {
            width: 100%;
            margin-top: 18px;
            padding: 1rem;
            background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            color: white;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        }

        .btn:active {
            transform: translateY(0);
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 22px;
            font-size: 0.875rem;
        }

        .links a {
            color: #2563EB;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }

        .links a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .error {
            margin-bottom: 18px;
            padding: 1rem 1.25rem;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 12px;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
            animation: shake 0.5s ease;
        }

        .error i {
            font-size: 1.25rem;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .welcome-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .code-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 2px solid #93c5fd;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            margin-bottom: 18px;
            display: flex;
            align-items: start;
            gap: 10px;
            font-size: 0.8rem;
            color: #1e40af;
            font-weight: 600;
            line-height: 1.5;
        }

        .code-info i {
            font-size: 1.1rem;
            margin-top: 2px;
            flex-shrink: 0;
            color: #2563EB;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left {
                padding: 40px 30px;
            }

            .right {
                padding: 40px 30px;
            }

            .logo-circle {
                width: 100px;
                height: 100px;
            }

            .logo-text {
                font-size: 2.5rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .left h3 {
                font-size: 1.5rem;
            }

            .subtitle {
                margin-bottom: 25px;
            }

            .input-group {
                margin-bottom: 16px;
            }

            input {
                padding: 0.9rem 1rem 0.9rem 3rem;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="left">
        <div class="welcome-badge">DAFTAR BARU</div>
        <div class="logo-circle">
            <img src="{{ asset('logo.png') }}" alt="RAYA-E Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <span class="logo-text" style="display:none;">R</span>
        </div>
        <h3>Bergabung dengan RAYA-E!</h3>
        <p>Buat akun baru dan mulai kelola inventori elektronik Anda dengan mudah dan efisien</p>
    </div>

    <div class="right">
        <h2>Buat Akun Baru</h2>
        <p class="subtitle">Isi data diri dan kode akses untuk mendaftar</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if($errors->any())
                <div class="error">
                    <i class='bi bi-exclamation-circle-fill'></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div class="code-info">
                <i class='bi bi-shield-lock-fill'></i>
                <span><strong>Kode akses diperlukan!</strong> Gunakan kode akses valid dari admin untuk registrasi.</span>
            </div>

            <div class="input-group">
                <i class='bi bi-person-fill'></i>
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="input-group">
                <i class='bi bi-envelope-fill'></i>
                <input type="email" name="email" placeholder="Alamat Email" value="{{ old('email') }}" required>
            </div>

            <div class="input-group">
                <i class='bi bi-lock-fill'></i>
                <input type="password" name="password" placeholder="Password (min. 8 karakter)" required>
            </div>

            <div class="input-group">
                <i class='bi bi-lock-fill'></i>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            </div>

            <div class="input-group">
                <i class='bi bi-key-fill'></i>
                <input type="password" name="access_code" placeholder="Masukkan Kode Akses" value="{{ old('access_code') }}" required>
            </div>

            <button type="submit" class="btn">
                <i class="bi bi-person-plus-fill" style="margin-right: 8px;"></i>Daftar Sekarang
            </button>

            <div class="links">
                <a href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right" style="margin-right: 4px;"></i>Sudah Punya Akun? Login
                </a>
                <a href="#">
                    <i class="bi bi-question-circle" style="margin-right: 4px;"></i>Butuh Bantuan?
                </a>
            </div>
        </form>
    </div>

</div>

<script>
    // Auto uppercase access code (still works with password type)
    document.querySelector('input[name="access_code"]').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });
</script>

</body>
</html>