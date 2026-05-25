@extends('layouts.main')

@section('title', 'Dashboard - RAYA-E')

@section('styles')
<style>
    /* Override body background to match sidebar design */
    body {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 50%, #dbeafe 100%) !important;
    }
    
    body::before {
        background: 
            radial-gradient(circle at 20% 50%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%) !important;
    }
    
    .main-content {
        background: transparent !important;
    }
    
    /* Top Header */
    .top-header {
        background: #ffffff;
        padding: 1.75rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
    }
    
    .top-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e3a8a;
        margin: 0;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .top-header h1 i {
        color: #2563EB;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
        transition: all 0.3s ease;
    }
    
    .user-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
    }
    
    .user-avatar {
        width: 38px;
        height: 38px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563EB;
        font-weight: 800;
        font-size: 1rem;
    }
    
    /* Welcome Section */
    .welcome-section {
        background: #ffffff;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2563EB 0%, #0ea5e9 100%);
    }
    
    .welcome-title {
        font-size: 2rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #2563EB 0%, #1e3a8a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -1px;
    }
    
    .welcome-subtitle {
        font-size: 1rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }
    
    .welcome-subtitle i {
        color: #2563EB;
    }
    
    /* Stats Cards Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: #ffffff;
        padding: 1.75rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .stat-card.blue::before { background: linear-gradient(90deg, #2563EB 0%, #0ea5e9 100%); }
    .stat-card.green::before { background: linear-gradient(90deg, #10b981 0%, #059669 100%); }
    .stat-card.orange::before { background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%); }
    .stat-card.red::before { background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%); }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(37, 99, 235, 0.15);
    }
    
    .stat-card:hover::before {
        transform: scaleX(1);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: white;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon.blue { background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%); }
    .stat-icon.green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-icon.orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-icon.red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    
    .stat-label {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 900;
        color: #1e3a8a;
        letter-spacing: -1px;
        margin-bottom: 0.5rem;
    }
    
    .stat-change {
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .stat-change.up { color: #10b981; }
    .stat-change.down { color: #ef4444; }
    .stat-change.info { color: #2563EB; }
    
    /* Middle Stats Row */
    .middle-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    /* Bottom Cards */
    .bottom-cards {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    
    .report-card, .stock-card {
        background: #ffffff;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        transition: all 0.3s ease;
    }
    
    .report-card:hover, .stock-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(37, 99, 235, 0.12);
    }
    
    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e3a8a;
        letter-spacing: -0.5px;
    }
    
    .card-title i {
        color: #2563EB;
        font-size: 1.5rem;
    }
    
    .view-all {
        color: #2563EB;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .view-all:hover {
        background: rgba(37, 99, 235, 0.1);
        border-color: rgba(37, 99, 235, 0.2);
        color: #1e40af;
        transform: translateX(4px);
    }
    
    /* Chart Container */
    .chart-container {
        height: 320px;
        background: #ffffff;
        border-radius: 14px;
        padding: 1.5rem;
        position: relative;
    }
    
    .chart-wrapper {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .chart-stats {
        display: flex;
        justify-content: space-around;
        padding: 1rem 0;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 1rem;
    }
    
    .chart-stat-item {
        text-align: center;
    }
    
    .chart-stat-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }
    
    .chart-stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e3a8a;
    }
    
    .chart-bars {
        flex: 1;
        display: flex;
        align-items: flex-end;
        gap: 0.75rem;
        padding: 0 0.5rem;
    }
    
    .chart-bar-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    
    .chart-bar-container {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        position: relative;
    }
    
    .chart-bar {
        width: 100%;
        background: linear-gradient(180deg, #2563EB 0%, #1e40af 100%);
        border-radius: 8px 8px 0 0;
        position: relative;
        transition: all 0.3s ease;
        box-shadow: 0 -4px 12px rgba(37, 99, 235, 0.2);
    }
    
    .chart-bar:hover {
        background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%);
        box-shadow: 0 -6px 16px rgba(37, 99, 235, 0.3);
    }
    
    .chart-bar-value {
        position: absolute;
        top: -28px;
        left: 50%;
        transform: translateX(-50%);
        background: #1e3a8a;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }
    
    .chart-bar-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-align: center;
        margin-top: 0.5rem;
    }
    
    /* Stock Table */
    .stock-table-header {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        color: white;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.8rem;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stock-item {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1rem;
        padding: 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        align-items: center;
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .stock-item:hover {
        background: rgba(37, 99, 235, 0.05);
        border-color: transparent;
    }
    
    .stock-item:last-child {
        border-bottom: none;
    }
    
    .stock-name {
        color: #1e3a8a;
        font-weight: 700;
        font-size: 0.95rem;
    }
    
    .stock-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.875rem;
    }
    
    .stock-badge.danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
        color: #dc2626;
        border: 2px solid rgba(239, 68, 68, 0.3);
    }
    
    .stock-badge.warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
        color: #d97706;
        border: 2px solid rgba(245, 158, 11, 0.3);
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #10b981;
        margin-bottom: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .middle-stats {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .bottom-cards {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .stats-row, .middle-stats {
            grid-template-columns: 1fr;
        }
        
        .top-header {
            flex-direction: column;
            gap: 1rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .stat-value {
            font-size: 1.75rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Top Header -->
<div class="top-header">
    <h1><i class="bi bi-grid-fill"></i> Dashboard </h1>
    <div class="user-info">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <span>{{ auth()->user()->name }}</span>
    </div>
</div>

<!-- Welcome Section -->
<div class="welcome-section">
    <h2 class="welcome-title">Selamat Datang Kembali! 👋</h2>
    <p class="welcome-subtitle">
        <i class="bi bi-calendar-check"></i>
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} • {{ auth()->user()->name }}
    </p>
</div>

<!-- Boks Peringatan Stok Rendah -->
@if(($stokRendah + $stokHabis) > 0)
<div class="alert-low-stock animate__animated animate__fadeIn" style="background: linear-gradient(135deg, #fff5f5 0%, #fee2e2 100%); border-left: 6px solid #ef4444; padding: 1.5rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.08), 0 4px 6px -4px rgba(239, 68, 68, 0.08); border-top: 1px solid rgba(239, 68, 68, 0.1); border-right: 1px solid rgba(239, 68, 68, 0.1); border-bottom: 1px solid rgba(239, 68, 68, 0.1); display: flex; justify-content: space-between; align-items: center; gap: 1.5rem;">
    <div style="display: flex; align-items: flex-start; gap: 1.25rem; flex: 1;">
        <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 0.85rem; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3); flex-shrink: 0; width: 52px; height: 52px;">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div style="flex: 1;">
            <h4 style="color: #991b1b; font-weight: 850; margin: 0 0 0.5rem 0; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; letter-spacing: -0.5px;">
                PERINGATAN: STOK KRITIS / RENDAH!
                <span class="badge" style="background: #ef4444; color: white; font-size: 0.75rem; padding: 0.3rem 0.65rem; font-weight: 800; border-radius: 8px; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);">{{ $stokRendah + $stokHabis }} Barang</span>
            </h4>
            <p style="color: #7f1d1d; margin: 0 0 1rem 0; font-size: 0.95rem; font-weight: 600; line-height: 1.5;">
                Beberapa barang berikut telah berada di bawah batas stok minimum atau habis. Segera lakukan pemesanan ulang (restock) ke supplier untuk menjaga kelancaran operasional toko!
            </p>
            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                @foreach($barangStokRendah as $barang)
                    <div style="background: #ffffff; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.5rem 1rem; border-radius: 10px; display: flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02); transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                        <span style="font-weight: 700; color: #1e3a8a; font-size: 0.85rem;">{{ $barang->nama_barang }}</span>
                        <span class="badge" style="background: {{ $barang->stok <= 0 ? 'linear-gradient(135deg, #fecaca 0%, #fca5a5 100%)' : 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)' }}; color: {{ $barang->stok <= 0 ? '#991b1b' : '#92400e' }}; font-size: 0.75rem; padding: 0.25rem 0.6rem; font-weight: 800; border-radius: 6px; border: 1px solid {{ $barang->stok <= 0 ? 'rgba(239, 68, 68, 0.2)' : 'rgba(245, 158, 11, 0.2)' }};">
                            {{ $barang->stok <= 0 ? 'HABIS' : 'Sisa: ' . $barang->stok . ' Unit' }}
                        </span>
                    </div>
                @endforeach
                @if(($stokRendah + $stokHabis) > 5)
                    <div style="background: rgba(239, 68, 68, 0.05); border: 1px dashed rgba(239, 68, 68, 0.4); padding: 0.5rem 1rem; border-radius: 10px; display: flex; align-items: center;">
                        <span style="font-weight: 700; color: #b91c1c; font-size: 0.85rem;">+{{ ($stokRendah + $stokHabis) - 5 }} barang lainnya</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div style="flex-shrink: 0;">
        <a href="{{ route('laporan.stok') }}?status=rendah" class="btn btn-danger" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); text-decoration: none; color: white; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(239, 68, 68, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3)';">
            <i class="bi bi-arrow-right-circle-fill"></i> Kelola & Restock
        </a>
    </div>
</div>
@endif

<!-- Stats Cards Row 1 -->
<div class="stats-row">
    <div class="stat-card blue">
        <div class="stat-icon blue">
            <i class="bi bi-box-seam-fill"></i>
        </div>
        <div class="stat-label">Total Barang</div>
        <div class="stat-value">{{ number_format($totalBarang, 0, ',', '.') }}</div>
        <div class="stat-change info">
            <i class="bi bi-boxes"></i> Unit Tersedia
        </div>
    </div>
    
    <div class="stat-card green">
        <div class="stat-icon green">
            <i class="bi bi-cart-plus-fill"></i>
        </div>
        <div class="stat-label">Pembelian</div>
        <div class="stat-value">{{ number_format($barangMasukBulanIni, 0, ',', '.') }}</div>
        <div class="stat-change up">
            <i class="bi bi-arrow-up-circle-fill"></i> Bulan Ini
        </div>
    </div>
    
    <div class="stat-card orange">
        <div class="stat-icon orange">
            <i class="bi bi-cash-coin"></i>
        </div>
        <div class="stat-label">Penjualan</div>
        <div class="stat-value">{{ number_format($barangKeluarBulanIni, 0, ',', '.') }}</div>
        <div class="stat-change down">
            <i class="bi bi-arrow-down-circle-fill"></i> Bulan Ini
        </div>
    </div>
    
    <div class="stat-card red">
        <div class="stat-icon red">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="stat-label">Stok Rendah</div>
        <div class="stat-value">{{ number_format($stokRendah, 0, ',', '.') }}</div>
        <div class="stat-change down">
            <i class="bi bi-exclamation-octagon-fill"></i> Perhatian!
        </div>
    </div>
</div>

<!-- Stats Cards Row 2 -->
<div class="middle-stats">
    <div class="stat-card blue">
        <div class="stat-icon blue">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div class="stat-label">Total Penjualan</div>
        <div class="stat-value">Rp {{ number_format($totalPenjualanBulanIni, 0, ',', '.') }}</div>
        <div class="stat-change up">
            <i class="bi bi-graph-up"></i> Bulan Ini
        </div>
    </div>
    
    <div class="stat-card green">
        <div class="stat-icon green">
            <i class="bi bi-trophy-fill"></i>
        </div>
        <div class="stat-label">Total Laba</div>
        <div class="stat-value">Rp {{ number_format($totalLabaBulanIni, 0, ',', '.') }}</div>
        <div class="stat-change up">
            <i class="bi bi-graph-up-arrow"></i> Profit
        </div>
    </div>
    
    <div class="stat-card red">
        <div class="stat-icon red">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <div class="stat-label">Stok Habis</div>
        <div class="stat-value">{{ number_format($stokHabis, 0, ',', '.') }}</div>
        <div class="stat-change down">
            <i class="bi bi-exclamation-diamond-fill"></i> Restock!
        </div>
    </div>
</div>

<!-- Bottom Cards -->
<div class="bottom-cards">
    <!-- Report Penjualan -->
    <div class="report-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-graph-up-arrow"></i>
                Penjualan per Kategori Barang
            </h3>
            <a href="{{ route('laporan.penjualan') }}" class="view-all">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="chart-container">
            <div class="chart-wrapper">
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <div class="chart-stat-label">Total Transaksi</div>
                        <div class="chart-stat-value">
                            {{ \App\Models\BarangKeluar::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() }}
                        </div>
                    </div>
                    <div class="chart-stat-item">
                        <div class="chart-stat-label">Total Penjualan</div>
                        <div class="chart-stat-value">
                            Rp {{ number_format(\App\Models\BarangKeluar::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('harga_jual'), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="chart-stat-item">
                        <div class="chart-stat-label">Bulan</div>
                        <div class="chart-stat-value" style="font-size: 1rem; color: #2563EB;">
                            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('MMMM YYYY') }}
                        </div>
                    </div>
                </div>
                
                <div class="chart-bars">
                    @php
                        // Get all unique kategori from barang table
                        $allKategori = \App\Models\Barang::distinct()->pluck('kategori')->toArray();
                        
                        // Group penjualan bulan ini by kategori
                        $penjualanBulanIni = \App\Models\BarangKeluar::with('barang')
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->get()
                            ->groupBy('barang.kategori')
                            ->map(function($items) {
                                return [
                                    'jumlah' => $items->count(),
                                    'total' => $items->sum('harga_jual')
                                ];
                            });
                        
                        $maxJumlah = $penjualanBulanIni->max('jumlah') ?: 1;
                    @endphp
                    
                    @forelse($allKategori as $kategori)
                        @php
                            $data = $penjualanBulanIni[$kategori] ?? ['jumlah' => 0, 'total' => 0];
                            $percentage = $maxJumlah > 0 ? ($data['jumlah'] / $maxJumlah) * 100 : 0;
                            $percentage = max($percentage, 5); // Minimum 5% untuk visibility
                        @endphp
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar-container">
                                <div class="chart-bar" style="height: {{ $percentage }}%; {{ $data['jumlah'] == 0 ? 'opacity: 0.3;' : '' }}">
                                    <div class="chart-bar-value">{{ $data['jumlah'] }} Unit</div>
                                </div>
                            </div>
                            <div class="chart-bar-label">{{ strtoupper($kategori) }}</div>
                        </div>
                    @empty
                        <div style="width: 100%; text-align: center; color: #64748b; padding: 2rem;">
                            <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                            <p style="margin: 0; font-weight: 600;">Belum ada kategori barang</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stock Rendah -->
    <div class="stock-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Stok Rendah
            </h3>
            <a href="{{ route('laporan.stok') }}" class="view-all">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        @if($barangStokRendah->count() > 0)
            <div class="stock-table-header">
                <div>PRODUK</div>
                <div>STOK</div>
            </div>
            
            @foreach($barangStokRendah as $barang)
            <div class="stock-item">
                <div>
                    <div class="stock-name">{{ $barang->nama_barang }}</div>
                    <small style="color: #64748b; font-weight: 600;">{{ $barang->kategori }} • {{ $barang->merk }}</small>
                </div>
                <div>
                    <span class="stock-badge {{ $barang->stok == 0 ? 'danger' : 'warning' }}">
                        {{ $barang->stok }} Unit
                    </span>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="bi bi-check-circle-fill"></i>
                <p><strong style="color: #1e3a8a;">Semua Stok Aman!</strong></p>
                <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">Tidak ada barang dengan stok rendah</p>
            </div>
        @endif
    </div>
</div>
@endsection