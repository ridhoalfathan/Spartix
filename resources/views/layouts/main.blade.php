<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RAYA-E - Sistem Persediaan Elektronik')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
            --secondary-gradient: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --primary-color: #2563EB;
            --primary-dark: #1e40af;
            --sidebar-width: 280px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 50%, #dbeafe 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
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
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: #ffffff;
            box-shadow: 4px 0 30px rgba(37, 99, 235, 0.08);
            border-right: 1px solid rgba(37, 99, 235, 0.1);
            overflow: hidden;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            padding-bottom: 1rem;
        }
        
        .sidebar-content::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-content::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #2563EB, #1e40af);
            border-radius: 10px;
        }
        
        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #1e40af, #1e3a8a);
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            background: var(--primary-gradient);
            position: relative;
            overflow: hidden;
            min-height: 100px;
        }
        
        .sidebar-header::before,
        .sidebar-header::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header::before {
            top: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            animation: float 6s ease-in-out infinite;
        }
        
        .sidebar-header::after {
            bottom: -40px;
            left: -20px;
            width: 120px;
            height: 120px;
            animation: float 8s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 16px;
            color: white;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: 900;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }
        
        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .logo-icon img {
            width: 250%;
            height: 250%;
            object-fit: contain;
            position: relative;
            z-index: 1;
        }
        
        .logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .logo-text-main {
            font-size: 1.75rem;
            font-weight: 900;
            letter-spacing: -1px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            line-height: 1;
        }
        
        .logo-text-sub {
            font-size: 0.7rem;
            font-weight: 600;
            opacity: 0.9;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        .sidebar-section {
            padding: 0 1.25rem;
            margin-bottom: 1rem;
            width: 100%;
        }
        
        .sidebar-section-title {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1.5px;
            padding: 0.4rem 1rem;
            margin-bottom: 0.4rem;
            margin-top: 0.5rem;
            line-height: 1;
            white-space: nowrap;
            position: relative;
        }
        
        .sidebar-section-title::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 25px;
            height: 2px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.7rem 1rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 0.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 600;
            font-size: 0.875rem;
            position: relative;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .nav-link:hover {
            transform: translateX(5px);
            color: var(--primary-color);
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08) 0%, rgba(30, 64, 175, 0.08) 100%);
        }
        
        .nav-link:hover::before {
            opacity: 1;
        }
        
        .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            transform: translateX(5px);
            border-color: transparent;
        }
        
        .nav-link.active::before {
            opacity: 1;
            background: white;
        }
        
        .nav-link i {
            font-size: 1.1rem;
            width: 22px;
            min-width: 22px;
            text-align: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        
        .nav-link:hover i,
        .nav-link.active i {
            transform: scale(1.1) rotate(-5deg);
        }
        
        .nav-link span {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 2.5rem;
            width: calc(100% - var(--sidebar-width));
            position: relative;
            z-index: 1;
        }
        
        .main-content * {
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        .main-content table {
            table-layout: auto;
            width: 100%;
        }
        
        .main-content .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .alert {
            border-radius: 14px;
            border: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
                width: 100%;
            }
            
            .mobile-toggle {
                display: flex !important;
            }
        }
        
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.4);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .mobile-toggle:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.5);
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* Logout button special styling */
        .nav-link-logout {
            margin-top: 0.25rem;
            border: 2px solid rgba(239, 68, 68, 0.2);
        }
        
        .nav-link-logout:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
            border-color: rgba(239, 68, 68, 0.4);
            color: #ef4444;
        }
        
        /* Section Akun - tetap di bawah */
        .sidebar-section-akun {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        /* ══════════════════════════════════════════
           GLOBAL DESIGN SYSTEM
        ══════════════════════════════════════════ */

        /* ── PAGE HEADER ── */
        .page-header { background:#fff; padding:1.75rem 2rem; border-radius:16px; margin-bottom:2rem; box-shadow:0 4px 20px rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.1); display:flex; justify-content:space-between; align-items:center; }
        .page-title { font-size:1.75rem; font-weight:800; color:#1e3a8a; display:flex; align-items:center; gap:12px; margin:0; letter-spacing:-.5px; }
        .page-title i { color:#2563EB; font-size:2rem; }

        /* ── CARDS ── */
        .card-box { background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.1); margin-bottom:2rem; }
        .card-box-body { padding:1.75rem; }
        .filter-card { background:#fff; padding:1.75rem; border-radius:16px; margin-bottom:2rem; box-shadow:0 4px 20px rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.1); }

        /* ── TABLE ── */
        .table-card { background:#fff; border-radius:16px; box-shadow:0 4px 20px rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.1); overflow:hidden; margin-bottom:2rem; }
        .table { margin:0; width:100%; }
        .table > thead,
        .table > thead > tr > th,
        table.table thead,
        table.table thead tr th {
            background: linear-gradient(135deg,#2563EB 0%,#1e40af 100%) !important;
            color: white !important;
            border: none !important;
            border-color: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-color: white !important;
            --bs-table-border-color: transparent !important;
        }
        .table thead th { padding:1.25rem 1rem; font-weight:800; text-transform:uppercase; font-size:.8rem; letter-spacing:.5px; }
        .table thead tr { background: linear-gradient(135deg,#2563EB 0%,#1e40af 100%) !important; }
        .table tbody td { padding:1.1rem 1rem; vertical-align:middle; border-bottom:1px solid #f1f5f9; color:#1e3a8a; font-weight:500; }
        .table tbody tr:last-child td { border-bottom:none; }
        .table tbody tr:hover { background:rgba(37,99,235,.04); }

        /* ── BUTTONS ── */
        .btn-primary { background:linear-gradient(135deg,#2563EB 0%,#1e40af 100%); color:white; padding:.75rem 1.5rem; border-radius:10px; border:none; font-weight:700; display:inline-flex; align-items:center; gap:8px; transition:all .3s; box-shadow:0 4px 12px rgba(37,99,235,.25); text-decoration:none; cursor:pointer; font-family:inherit; font-size:.9rem; }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(37,99,235,.35); background:linear-gradient(135deg,#1e40af 0%,#1e3a8a 100%); color:white; }
        .btn-secondary { background:#f1f5f9; color:#475569; padding:.75rem 1.5rem; border-radius:10px; border:2px solid #e2e8f0; font-weight:700; display:inline-flex; align-items:center; gap:8px; transition:all .3s; text-decoration:none; cursor:pointer; font-family:inherit; font-size:.9rem; }
        .btn-secondary:hover { background:#e2e8f0; color:#1e3a8a; transform:translateY(-2px); }
        .btn-danger-outline { background:transparent; color:#dc2626; padding:.75rem 1.5rem; border-radius:10px; border:2px solid #fecaca; font-weight:700; display:inline-flex; align-items:center; gap:8px; transition:all .3s; text-decoration:none; cursor:pointer; font-family:inherit; font-size:.9rem; }
        .btn-danger-outline:hover { background:#fef2f2; border-color:#ef4444; transform:translateY(-2px); }

        /* ── ACTION BUTTONS (table) ── */
        .btn-action { padding:.45rem .75rem; border-radius:8px; border:none; font-weight:700; font-size:.82rem; transition:all .25s; display:inline-flex; align-items:center; gap:5px; text-decoration:none; cursor:pointer; }
        .btn-action-view { background:#dbeafe; color:#1d4ed8; }
        .btn-action-view:hover { background:#bfdbfe; color:#1e40af; transform:translateY(-2px); }
        .btn-action-edit { background:#fef3c7; color:#b45309; }
        .btn-action-edit:hover { background:#fde68a; color:#92400e; transform:translateY(-2px); }
        .btn-action-delete { background:#fee2e2; color:#b91c1c; }
        .btn-action-delete:hover { background:#fecaca; color:#991b1b; transform:translateY(-2px); }

        /* ── BADGES ── */
        .badge { padding:.4rem .875rem; border-radius:8px; font-weight:700; font-size:.78rem; display:inline-flex; align-items:center; gap:5px; }
        .badge-success { background:rgba(16,185,129,.12); color:#059669; border:1.5px solid rgba(16,185,129,.25); }
        .badge-warning { background:rgba(245,158,11,.12); color:#d97706; border:1.5px solid rgba(245,158,11,.25); }
        .badge-danger { background:rgba(239,68,68,.12); color:#dc2626; border:1.5px solid rgba(239,68,68,.25); }
        .badge-info { background:rgba(37,99,235,.12); color:#1d4ed8; border:1.5px solid rgba(37,99,235,.2); }
        .badge-secondary { background:#f1f5f9; color:#475569; border:1.5px solid #e2e8f0; }

        /* ── FORM ── */
        .form-label { font-weight:700; color:#1e3a8a; font-size:.8rem; margin-bottom:.5rem; display:block; text-transform:uppercase; letter-spacing:.5px; }
        .form-control, .form-select { border:2px solid #e2e8f0; border-radius:10px; padding:.75rem 1rem; font-size:.9rem; transition:all .3s; width:100%; font-weight:500; font-family:inherit; color:#1e3a8a; background:white; }
        .form-control:focus, .form-select:focus { border-color:#2563EB; box-shadow:0 0 0 4px rgba(37,99,235,.1); outline:none; }
        .form-control:hover:not(:focus), .form-select:hover:not(:focus) { border-color:#cbd5e1; }
        .form-control.is-invalid { border-color:#ef4444; }
        .invalid-feedback { color:#ef4444; font-size:.82rem; font-weight:600; margin-top:.35rem; }
        .form-group { margin-bottom:1.25rem; }
        .form-section { background:#f8fafc; border-radius:12px; padding:1.5rem; margin-bottom:1.5rem; border:1px solid #e2e8f0; }
        .form-section-title { font-size:1rem; font-weight:800; color:#1e3a8a; margin-bottom:1.25rem; display:flex; align-items:center; gap:8px; }
        .form-section-title i { color:#2563EB; }

        /* ── EMPTY STATE ── */
        .empty-state { text-align:center; padding:4rem 2rem; color:#64748b; }
        .empty-state i { font-size:3.5rem; color:#2563EB; margin-bottom:1rem; opacity:.25; display:block; }
        .empty-state h4 { color:#1e3a8a; font-weight:800; margin-bottom:.5rem; }
        .empty-state p { margin:0; font-size:.9rem; }

        /* ── ALERTS (in-page) ── */
        .alert-box { display:flex; align-items:center; gap:10px; padding:1rem 1.25rem; border-radius:12px; font-size:.875rem; font-weight:600; margin-bottom:1.5rem; }
        .alert-box-success { background:#f0fdf4; color:#15803d; border:1.5px solid #bbf7d0; }
        .alert-box-danger { background:#fef2f2; color:#b91c1c; border:1.5px solid #fecaca; }
        .alert-box i { font-size:1.1rem; flex-shrink:0; }

        /* ── FILTER BUTTONS ── */
        .btn-filter { background:linear-gradient(135deg,#2563EB 0%,#1e40af 100%); color:white; padding:.75rem 1.5rem; border-radius:10px; border:none; font-weight:700; transition:all .3s; display:inline-flex; align-items:center; gap:6px; cursor:pointer; box-shadow:0 4px 12px rgba(37,99,235,.25); font-family:inherit; }
        .btn-filter:hover { background:linear-gradient(135deg,#1e40af 0%,#1e3a8a 100%); transform:translateY(-2px); box-shadow:0 6px 16px rgba(37,99,235,.35); color:white; }
        .btn-reset { background:#94a3b8; color:white; padding:.75rem 1.5rem; border-radius:10px; border:none; font-weight:700; transition:all .3s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-family:inherit; }
        .btn-reset:hover { background:#64748b; transform:translateY(-2px); color:white; }

        /* ── PAGINATION ── */
        .pagination-wrap { margin-top:1.5rem; display:flex; justify-content:center; }

        /* ── BADGE CATEGORY ── */
        .badge-category { padding:.4rem .875rem; border-radius:8px; font-weight:700; font-size:.75rem; background:rgba(37,99,235,.12); color:#1e40af; border:1.5px solid rgba(37,99,235,.2); display:inline-block; }

        /* ── FILTER ROW ── */
        .filter-row { display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:1rem; align-items:end; }
        @media (max-width:768px) { .filter-row { grid-template-columns:1fr; } .page-header { flex-direction:column; gap:1rem; align-items:stretch; } }
    </style>
    
    @yield('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="/dashboard" class="sidebar-logo">
                <div class="logo-icon">
                    <img src="{{ asset('logo.png') }}" alt="RAYA-E Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span style="display:none;">R</span>
                </div>
                <div class="logo-text">
                    <div class="logo-text-main">RAYA-E</div>
                    <div class="logo-text-sub">Inventory</div>
                </div>
            </a>
        </div>
        
        <div class="sidebar-content">
            <!-- Menu Utama -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">📊 Menu Utama</div>
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            @if(auth()->user()->role === 'admin')
            <!-- Master Akuntansi - DIPINDAHKAN KE SINI -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">🧾 Master Akuntansi</div>
                <a href="/akun" class="nav-link {{ request()->is('akun*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Akun</span>
                </a>
            </div>
            
            <!-- Master Barang -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">📦 Master Barang</div>
                <a href="/barang" class="nav-link {{ request()->is('barang') || request()->is('barang/create') || request()->is('barang/*/edit') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Data Barang</span>
                </a>
                <a href="/serial-numbers" class="nav-link {{ request()->is('serial-numbers*') ? 'active' : '' }}">
                    <i class="bi bi-upc-scan"></i>
                    <span>Serial Number</span>
                </a>
            </div>
            
            <!-- Transaksi -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">💰 Transaksi</div>
                <a href="/barang-masuk" class="nav-link {{ request()->is('barang-masuk*') ? 'active' : '' }}">
                    <i class="bi bi-cart-plus-fill"></i>
                    <span>Pembelian Barang</span>
                </a>
                <a href="/barang-keluar" class="nav-link {{ request()->is('barang-keluar*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i>
                    <span>Penjualan Barang</span>
                </a>
            </div>
            @endif
            
            <!-- Laporan -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">📈 Laporan</div>
                <a href="/laporan/stok" class="nav-link {{ request()->is('laporan/stok') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data-fill"></i>
                    <span>Laporan Stok</span>
                </a>
                <a href="/laporan/kartu-stok" class="nav-link {{ request()->is('laporan/kartu-stok*') ? 'active' : '' }}">
                    <i class="bi bi-card-list"></i>
                    <span>Kartu Stok</span>
                </a>
                <a href="/laporan/penjualan" class="nav-link {{ request()->is('laporan/penjualan*') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Laporan Penjualan</span>
                </a>
                <a href="/laporan/jurnal-umum" class="nav-link {{ request()->is('laporan/jurnal-umum*') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    <span>Jurnal Umum</span>
                </a>
                <a href="/laporan/buku-besar" class="nav-link {{ request()->is('laporan/buku-besar*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Buku Besar</span>
                </a>
            </div>
            
            <!-- Akun -->
            <div class="sidebar-section sidebar-section-akun">
                <div class="sidebar-section-title">👤 Akun</div>
                <a href="/profile" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Saya</span>
                </a>
                <form action="/logout" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link nav-link-logout w-100 border-0 bg-transparent text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <button class="mobile-toggle" id="mobileToggle">
        <i class="bi bi-list fs-3"></i>
    </button>
    
    <div class="main-content">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        }
        
        if (mobileToggle) {
            mobileToggle.addEventListener('click', toggleSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }
        
        if (window.innerWidth <= 768) {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            });
        }
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>