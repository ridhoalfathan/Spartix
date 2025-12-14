<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Spartix' : 'Dashboard - Spartix' }}</title>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        * { 
            text-decoration: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: #ffffff;
            padding: 25px 15px;
            color: #1e3a8a;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 5px;
        }

        .sidebar-content::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 30px;
            padding: 16px 22px;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            border-radius: 16px;
        }

        /* BULATAN LOGO */
        .logo-icon {
            width: 52px;
            height: 52px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* LOGO DI DALAM BULATAN */
        .logo-icon img {
            width: 80%;
            height: 80%;
            object-fit: contain;
        }

        /* TEKS LOGO */
        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: white;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .menu-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 25px 0 12px 12px;
            color: #64748b;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            border-radius: 12px;
            margin: 5px 0;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #475569;
            font-size: 14px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .menu-item:hover {
            background: #f1f5f9;
            color: #1e3a8a;
            transform: translateX(5px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .menu-item i {
            font-size: 20px;
            width: 24px;
            text-align: center;
        }

        /* Logout Section */
        .logout-section {
            padding-top: 15px;
            margin-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
            width: 100%;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
        }

        .logout-btn i {
            font-size: 20px;
        }

        /* MAIN CONTENT */
        .content {
            flex-grow: 1;
            padding: 25px;
            color: white;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            width: 100%;
            padding: 20px 28px;
            background: #ffffff;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .topbar h3 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .user-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(30, 58, 138, 0.3);
        }

        .user-box img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid white;
            object-fit: cover;
            background: white;
        }

        .user-box span {
            font-weight: 600;
            font-size: 14px;
            color: white;
        }

        /* Alert Messages */
        .alert {
            padding: 16px 22px;
            border-radius: 12px;
            margin-bottom: 20px;
            animation: slideIn 0.4s ease;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .alert::before {
            font-family: 'boxicons';
            font-size: 22px;
        }

        .alert-success {
            border-left: 4px solid #10b981;
            color: #047857;
        }

        .alert-success::before {
            content: '\eb7f';
            color: #10b981;
        }

        .alert-danger {
            border-left: 4px solid #ef4444;
            color: #dc2626;
        }

        .alert-danger::before {
            content: '\eb90';
            color: #ef4444;
        }

        @keyframes slideIn {
            from { 
                transform: translateY(-20px); 
                opacity: 0; 
            }
            to { 
                transform: translateY(0); 
                opacity: 1; 
            }
        }

        /* Content scrollable area */
        .content-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 10px;
        }

        .content-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .content-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .content-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .content-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

    </style>
</head>

<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-content">
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('spartix.png') }}" alt="logo">
                </div>
                <span class="logo-text">SPARTIX</span>
            </div>

            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class='bx bxs-dashboard'></i> <span>Dasbor</span>
            </a>

            <a href="{{ route('karyawan.index') }}" class="menu-item {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                <i class='bx bxs-user-detail'></i> <span>Karyawan</span>
            </a>

            <a href="{{ route('product.index') }}" class="menu-item {{ request()->routeIs('product.*') ? 'active' : '' }}">
                <i class='bx bxs-box'></i> <span>Produk</span>
            </a>

            <div class="menu-title">Keuangan</div>
            <a href="{{ route('pembelian.index') }}" class="menu-item {{ request()->routeIs('pembelian.*') ? 'active' : '' }}">
                <i class='bx bxs-cart-add'></i> <span>Pembelian</span>
            </a>
            <a href="{{ route('produksi.index') }}" class="menu-item {{ request()->routeIs('produksi.*') ? 'active' : '' }}">
                <i class='bx bxs-cog'></i> <span>Produksi</span>
            </a>
            <a href="{{ route('pesanan.index') }}" class="menu-item {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                <i class='bx bx-list-check'></i> <span>Pesanan</span>
            </a>
            <a href="{{ route('transaksi.index') }}" class="menu-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i class='bx bx-credit-card'></i> <span>Transaksi</span>
            </a>
            <a href="{{ route('salary-report.index') }}" class="menu-item {{ request()->routeIs('salary-report.*') ? 'active' : '' }}">
                <i class='bx bxs-wallet'></i> <span>Laporan Gaji</span>
            </a>

            <div class="menu-title">Laporan</div>
            <a href="{{ route('jurnal-umum.index') }}" class="menu-item {{ request()->routeIs('jurnal-umum.*') ? 'active' : '' }}">
                <i class='bx bxs-file'></i> <span>Jurnal Umum</span>
            </a>
            <a href="{{ route('buku-besar.index') }}" class="menu-item {{ request()->routeIs('buku-besar.*') ? 'active' : '' }}">
                <i class='bx bx-book-open'></i> <span>Buku Besar</span>
            </a>

            <div class="menu-title">Akun</div>
            <a href="{{ route('settings.index') }}" class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class='bx bx-cog'></i> <span>Pengaturan</span>
            </a>
        </div>

        {{-- Logout Section --}}
        <div class="logout-section">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class='bx bx-log-out'></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Content Area --}}
    <div class="content">

        {{-- Top Bar --}}
        <div class="topbar">
            <h3>@yield('page-title', 'Dashboard')</h3>
            <div class="user-box">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=1e3a8a&color=fff&bold=true" alt="User Avatar">
                <span>{{ Auth::user()->name ?? 'User' }}</span>
            </div>
        </div>

        {{-- Content Scrollable Area --}}
        <div class="content-scroll">
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Dynamic Page Content --}}
            @yield('content')
        </div>
    </div>

</body>
</html>