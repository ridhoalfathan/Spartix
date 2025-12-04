<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Spartix' : 'Dashboard - Spartix' }}</title>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Boxicons --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        * { text-decoration: none; }
        
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(110deg,#314d59,#0d2730);
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            padding: 20px;
            color: white;
            overflow-y: auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo img {
            width: 70px;
            filter: drop-shadow(2px 2px 5px black);
        }

        .logo h3 {
            margin: 10px 0 0 0;
        }

        .menu-title {
            font-size: 20px;
            margin-top: 15px;
            opacity: 0.6;
            margin-left: 10px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 8px;
            margin: 5px 0;
            cursor: pointer;
            transition: 0.2s;
            color: white;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(255,255,255,0.2);
        }

        .menu-item i {
            font-size: 18px;
        }

        /* MAIN CONTENT */
        .content {
            flex-grow: 1;
            padding: 20px;
            color: white;
            overflow-y: auto;
        }

        .topbar {
            width: 100%;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .topbar h3 {
            margin: 0;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-box img {
            width: 35px;
            border-radius: 50%;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            border-left: 4px solid #2ecc71;
            color: #2ecc71;
        }

        .alert-danger {
            background: rgba(231, 76, 60, 0.2);
            border-left: 4px solid #e74c3c;
            color: #e74c3c;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

    </style>
</head>

<body>

    <body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('spartix.png') }}" alt="logo">
            <h3>SPARTIX</h3>
        </div>

        <div class="menu-title">Menu</div>
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class='bx bxs-dashboard'></i> Dashboard
        </a>

        <a href="{{ route('karyawan.index') }}" class="menu-item {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
            <i class='bx bxs-user-detail'></i> Karyawan
        </a>

        <a href="{{ route('product.index') }}" class="menu-item {{ request()->routeIs('product.*') ? 'active' : '' }}">
            <i class='bx bxs-box'></i> Product
        </a>


        <div class="menu-title">Financial</div>
        <a href="#" class="menu-item"><i class='bx bxs-cart-add'></i> Pembelian</a>
        <a href="#" class="menu-item"><i class='bx bx-list-check'></i> Pesanan</a>
        <a href="#" class="menu-item"><i class='bx bxs-cog'></i> Produksi</a>
        <a href="#" class="menu-item"><i class='bx bx-credit-card'></i> Transaksi</a>
        <a href="#" class="menu-item"><i class='bx bxs-wallet'></i> Salary Report</a>

        <div class="menu-title">Laporan</div>
        <a href="#" class="menu-item"><i class='bx bxs-file'></i> Jurnal Umum</a>
        <a href="#" class="menu-item"><i class='bx bx-book-open'></i> Buku Besar</a>

        <a href="#" class="menu-item"><i class='bx bx-cog'></i> Settings</a>
    </div>


    {{-- Content Area --}}
    <div class="content">

        {{-- Top Bar --}}
        <div class="topbar">
            <h3>@yield('page-title', 'Dashboard')</h3>
            <div class="user-box">
                <img src="https://i.pravatar.cc/40" alt="">
                <span>{{ Auth::user()->name ?? 'User' }}</span>
            </div>
        </div>

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


</body>
</html>