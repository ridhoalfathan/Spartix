<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SPARTIX</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 950px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .left {
            flex: 1;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 40px;
            color: white;
        }

        .left img {
            width: 200px;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
        }

        .left h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }

        .left p {
            font-size: 14px;
            opacity: 0.9;
            text-align: center;
            line-height: 1.6;
        }

        .right {
            flex: 1.2;
            padding: 50px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            margin-bottom: 10px;
            font-weight: 600;
            color: #1e293b;
            font-size: 28px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 20px;
        }

        input {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            background: #f8fafc;
            font-size: 14px;
            outline: none;
            color: #1e293b;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
        }

        input:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        input::placeholder {
            color: #94a3b8;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
            padding: 14px;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        }

        .links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #64748b;
        }

        .links a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .links a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .error {
            margin-top: 15px;
            padding: 12px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            color: #991b1b;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error i {
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left {
                padding: 30px 20px;
            }

            .left img {
                width: 150px;
            }

            .left h3 {
                font-size: 20px;
            }

            .right {
                padding: 40px 30px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="left">
        <img src="{{ asset('spartix.png') }}" alt="SPARTIX Logo">
        <h3>Bergabung dengan SPARTIX</h3>
        <p>Daftarkan akun Anda dan mulai kelola bisnis dengan lebih mudah dan efisien</p>
    </div>

    
    <div class="right">
        <h2>Buat Akun Baru</h2>
        <p class="subtitle">Isi formulir di bawah untuk membuat akun</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group">
                <i class='bx bx-user'></i>
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="input-group">
                <i class='bx bx-envelope'></i>
                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            </div>

            <div class="input-group">
                <i class='bx bx-lock-alt'></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="input-group">
                <i class='bx bx-lock-alt'></i>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            </div>

            @if($errors->any())
                <div class="error">
                    <i class='bx bx-error-circle'></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <button type="submit" class="btn">Daftar Sekarang</button>

            <div class="links">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>