<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            width: 100%;
        }

        /* Header */
        header {
            padding: 20px 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
        }

        .btn-primary {
            background: white;
            color: #667eea;
            border: 2px solid white;
        }

        .btn-primary:hover {
            background: rgba(255,255,255,0.9);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        /* Main Content */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .hero {
            text-align: center;
            max-width: 800px;
        }

        .hero h1 {
            font-size: 56px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-large {
            padding: 16px 40px;
            font-size: 16px;
            font-weight: 600;
        }

        /* Features */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 80px;
        }

        .feature-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .feature-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .feature-card p {
            font-size: 14px;
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            padding: 30px 0;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.2);
        }

        footer p {
            opacity: 0.8;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .nav-links {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">{{ config('app.name', 'Laravel') }}</div>
                
                @if (Route::has('login'))
                    <nav class="nav-links">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="hero">
                <h1>Selamat Datang di Sistem Manajemen</h1>
                <p>Platform terpadu untuk mengelola produk, pembelian, karyawan, dan laporan bisnis Anda dengan mudah dan efisien.</p>
                
                <div class="hero-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-large">Buka Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-large">Mulai Sekarang</a>
                        <a href="{{ route('login') }}" class="btn btn-outline btn-large">Masuk</a>
                    @endauth
                </div>

                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon">📦</div>
                        <h3>Manajemen Produk</h3>
                        <p>Kelola inventori produk dengan mudah, lacak stok, dan pantau status produk secara real-time.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">🛒</div>
                        <h3>Pembelian</h3>
                        <p>Catat dan monitor semua transaksi pembelian dari supplier dengan sistem yang terorganisir.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">👥</div>
                        <h3>Data Karyawan</h3>
                        <p>Kelola informasi karyawan, absensi, dan gaji dengan sistem yang terintegrasi.</p>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Laporan Lengkap</h3>
                        <p>Dapatkan insight bisnis dengan laporan keuangan dan operasional yang komprehensif.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>