@extends('layouts.main')

@section('page-title', 'Dashboard')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    .dashboard-container {
        max-width: 100%;
        padding: 0;
    }

    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-header h2 {
        margin: 0;
        font-size: clamp(24px, 4vw, 32px);
        font-weight: 700;
        color: white;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .dashboard-header p {
        margin: 8px 0 0 0;
        opacity: 0.8;
        font-size: 15px;
        color: rgba(255, 255, 255, 0.9);
    }

    /* Stats Cards - Blue Theme */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        padding: 24px;
        color: #1e3a8a;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #2563eb, #1e40af);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.2);
        background: rgba(255, 255, 255, 1);
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .stat-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        color: white;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .stat-card-title {
        font-size: 14px;
        color: #64748b;
        margin: 0 0 8px 0;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .stat-card-value {
        font-size: clamp(28px, 5vw, 36px);
        font-weight: 700;
        margin: 0;
        line-height: 1.1;
        color: #1e3a8a;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 30px;
    }

    @media (min-width: 1200px) {
        .content-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    .chart-card, .table-card {
        background: rgba(255, 255, 255, 0.95);
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 2px solid rgba(37, 99, 235, 0.15);
    }

    .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-header i {
        font-size: 26px;
        color: #2563eb;
    }

    .card-header h3 {
        margin: 0;
        font-size: 19px;
        font-weight: 600;
        color: #1e3a8a;
    }

    .view-all-link {
        color: #2563eb;
        text-decoration: none;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
        font-weight: 500;
    }

    .view-all-link:hover {
        color: #1e40af;
        gap: 8px;
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: #1e3a8a;
        font-size: 14px;
    }

    table thead {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    }

    table th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: white;
        border: none;
    }

    table td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
        color: #334155;
    }

    table tbody tr {
        transition: all 0.2s;
        background: white;
    }

    table tbody tr:hover {
        background: rgba(37, 99, 235, 0.05);
    }

    table td strong {
        color: #2563eb;
        font-weight: 600;
    }

    .stock-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.3px;
        display: inline-block;
    }

    .stock-high { 
        background: rgba(34, 197, 94, 0.15); 
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .stock-low { 
        background: rgba(239, 68, 68, 0.15); 
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.3px;
        display: inline-block;
    }

    .badge-admin { 
        background: rgba(37, 99, 235, 0.15); 
        color: #2563eb;
        border: 1px solid rgba(37, 99, 235, 0.3);
    }
    
    .badge-produksi { 
        background: rgba(168, 85, 247, 0.15); 
        color: #9333ea;
        border: 1px solid rgba(168, 85, 247, 0.3);
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        width: 100%;
        max-height: 400px;
    }

    .empty-state {
        text-align: center;
        color: #64748b;
        padding: 40px 20px;
        font-size: 14px;
    }

    .empty-state i {
        font-size: 48px;
        opacity: 0.3;
        margin-bottom: 10px;
        display: block;
        color: #2563eb;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
        }

        .stat-card {
            padding: 18px;
        }

        .stat-card-icon {
            width: 44px;
            height: 44px;
            font-size: 22px;
        }

        .chart-card, .table-card {
            padding: 20px;
        }

        .card-header h3 {
            font-size: 17px;
        }

        table {
            font-size: 13px;
        }

        table th, table td {
            padding: 12px 14px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .stat-card-title {
            font-size: 12px;
        }

        .stat-card-value {
            font-size: 22px;
        }
    }

    /* Smooth Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card, .chart-card, .table-card {
        animation: fadeInUp 0.5s ease-out backwards;
    }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }
    .chart-card { animation-delay: 0.25s; }
    .table-card { animation-delay: 0.3s; }
</style>

<div class="dashboard-container">

    <!-- Header -->
    <div class="dashboard-header">
        <h2>Dashboard Overview</h2>
        <p>Selamat datang kembali, {{ Auth::user()->name ?? 'User' }}! 👋</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class='bx bx-dollar-circle'></i>
                </div>
            </div>
            <p class="stat-card-title">Total Penjualan</p>
            <h3 class="stat-card-value">{{ $stats['total_penjualan'] }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class='bx bx-cart'></i>
                </div>
            </div>
            <p class="stat-card-title">Total Order</p>
            <h3 class="stat-card-value">{{ number_format($stats['total_order']) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class='bx bx-user'></i>
                </div>
            </div>
            <p class="stat-card-title">Total Karyawan</p>
            <h3 class="stat-card-value">{{ number_format($stats['total_karyawan']) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon">
                    <i class='bx bx-box'></i>
                </div>
            </div>
            <p class="stat-card-title">Jenis Produk</p>
            <h3 class="stat-card-value">{{ number_format($stats['total_products']) }}</h3>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Sales Chart -->
        <div class="chart-card">
            <div class="card-header">
                <div class="card-header-left">
                    <i class='bx bx-line-chart'></i>
                    <h3>Report Penjualan</h3>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="table-card">
            <div class="card-header">
                <div class="card-header-left">
                    <i class='bx bx-error'></i>
                    <h3>Stock Rendah</h3>
                </div>
                <a href="{{ route('product.index') }}" class="view-all-link">
                    Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="table-wrapper">
                @if($lowStockProducts->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                        <tr>
                            <td><strong>{{ $product->product_name }}</strong></td>
                            <td>
                                <span class="stock-badge stock-low">{{ number_format($product->stock) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <i class='bx bx-check-circle'></i>
                    <p>Semua produk stock aman ✓</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="table-card" style="margin-top: 20px;">
        <div class="card-header">
            <div class="card-header-left">
                <i class='bx bx-trending-up'></i>
                <h3>Top Products</h3>
            </div>
            <a href="{{ route('product.index') }}" class="view-all-link">
                Lihat Semua <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
        <div class="table-wrapper">
            @if($topProducts->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $key => $product)
                    <tr>
                        <td><strong>{{ $key + 1 }}</strong></td>
                        <td>{{ $product->product_name }}</td>
                        <td><strong>{{ number_format($product->stock) }}</strong></td>
                        <td>
                            @if($product->stock >= 500)
                                <span class="stock-badge stock-high">Aman</span>
                            @else
                                <span class="stock-badge stock-low">Rendah</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class='bx bx-package'></i>
                <p>Belum ada data produk</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Karyawan -->
    <div class="table-card" style="margin-top: 20px;">
        <div class="card-header">
            <div class="card-header-left">
                <i class='bx bx-user-plus'></i>
                <h3>Karyawan Terbaru</h3>
            </div>
            <a href="{{ route('karyawan.index') }}" class="view-all-link">
                Lihat Semua <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
        <div class="table-wrapper">
            @if($recentKaryawan->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentKaryawan as $karyawan)
                    <tr>
                        <td><strong>{{ $karyawan->id_karyawan }}</strong></td>
                        <td>{{ $karyawan->nama_karyawan }}</td>
                        <td><span class="badge badge-{{ strtolower($karyawan->jabatan) }}">{{ $karyawan->jabatan }}</span></td>
                        <td>{{ $karyawan->kategori }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class='bx bx-user'></i>
                <p>Belum ada data karyawan</p>
            </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('salesChart');

// Gradient for chart - Blue Theme
const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(37, 99, 235, 0.3)');
gradient.addColorStop(1, 'rgba(37, 99, 235, 0.01)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($salesData['labels']) !!},
        datasets: [{
            label: "Total Pesanan",
            tension: 0.4,
            data: {!! json_encode($salesData['data']) !!},
            borderColor: "#2563eb",
            backgroundColor: gradient,
            borderWidth: 3,
            fill: true,
            pointBackgroundColor: "#2563eb",
            pointBorderColor: "#fff",
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "#1e40af",
            pointHoverBorderWidth: 3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: { 
                display: true,
                position: 'top',
                align: 'end',
                labels: { 
                    color: "#1e3a8a",
                    font: {
                        size: 13,
                        family: 'Poppins',
                        weight: '500'
                    },
                    padding: 15,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(30, 58, 138, 0.95)',
                padding: 15,
                cornerRadius: 10,
                titleFont: {
                    size: 14,
                    family: 'Poppins',
                    weight: '600'
                },
                bodyFont: {
                    size: 13,
                    family: 'Poppins'
                },
                callbacks: {
                    label: function(context) {
                        return 'Total Pesanan: ' + context.parsed.y + ' pesanan';
                    }
                }
            }
        },
        scales: {
            x: { 
                ticks: { 
                    color: "#64748b",
                    font: {
                        size: 12,
                        family: 'Poppins'
                    }
                },
                grid: {
                    color: 'rgba(37, 99, 235, 0.1)',
                    drawBorder: false
                }
            },
            y: { 
                ticks: { 
                    color: "#64748b",
                    font: {
                        size: 12,
                        family: 'Poppins'
                    },
                    callback: function(value) {
                        return value;
                    }
                },
                grid: {
                    color: 'rgba(37, 99, 235, 0.1)',
                    drawBorder: false
                }
            }
        }
    }
});
</script>

@endsection