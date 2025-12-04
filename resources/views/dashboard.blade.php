@extends('layouts.main')

@section('page-title', 'Dashboard')

@section('content')

<style>
    * {
        box-sizing: border-box;
    }

    .dashboard-container {
        max-width: 100%;
        padding: 0 10px 30px 10px;
        overflow-x: hidden;
    }

    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-header h2 {
        margin: 0;
        font-size: clamp(22px, 4vw, 28px);
        font-weight: 600;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .dashboard-header p {
        margin: 5px 0 0 0;
        opacity: 0.7;
        font-size: 14px;
    }

    /* Stats Cards - Responsive Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 20px;
        color: white;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 48px rgba(102, 126, 234, 0.3);
        border-color: rgba(102, 126, 234, 0.4);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        background: rgba(255,255,255,0.1);
    }

    .stat-card-icon.purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-card-icon.blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .stat-card-icon.green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .stat-card-icon.orange { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
    .stat-card-icon.pink { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }

    .stat-card-title {
        font-size: 13px;
        opacity: 0.8;
        margin: 0;
        font-weight: 500;
    }

    .stat-card-value {
        font-size: clamp(24px, 5vw, 32px);
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 25px;
    }

    @media (min-width: 1200px) {
        .content-grid {
            grid-template-columns: 2fr 1fr;
        }
    }

    .chart-card, .table-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(20px);
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.1);
        overflow: hidden;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid rgba(255,255,255,0.1);
    }

    .card-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-header i {
        font-size: 24px;
        color: #667eea;
    }

    .card-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .view-all-link {
        color: #667eea;
        text-decoration: none;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: 0.3s;
    }

    .view-all-link:hover {
        color: #764ba2;
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: white;
        font-size: 14px;
        min-width: 500px;
    }

    table thead {
        background: rgba(255,255,255,0.08);
    }

    table th {
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
        border-bottom: 2px solid rgba(102, 126, 234, 0.3);
    }

    table td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    table tbody tr {
        transition: all 0.2s;
    }

    table tbody tr:hover {
        background: rgba(102, 126, 234, 0.15);
    }

    table td strong {
        color: #667eea;
        font-weight: 600;
    }

    .stock-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .stock-high { background: rgba(67, 233, 123, 0.2); color: #43e97b; }
    .stock-low { background: rgba(255, 107, 107, 0.2); color: #ff6b6b; }

    .badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    .badge-admin { background: rgba(102, 126, 234, 0.2); color: #667eea; }
    .badge-produksi { background: rgba(240, 147, 251, 0.2); color: #f093fb; }

    /* Chart Container */
    .chart-container {
        position: relative;
        width: 100%;
        max-height: 400px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 0 5px 20px 5px;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-card-icon {
            width: 40px;
            height: 40px;
            font-size: 20px;
        }

        .chart-card, .table-card {
            padding: 15px;
        }

        .card-header h3 {
            font-size: 16px;
        }

        table {
            font-size: 13px;
        }

        table th, table td {
            padding: 10px 12px;
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
            font-size: 20px;
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
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    .chart-card { animation-delay: 0.6s; }
    .table-card { animation-delay: 0.7s; }
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
                <div class="stat-card-icon purple">
                    <i class='bx bx-dollar-circle'></i>
                </div>
            </div>
            <p class="stat-card-title">Total Penjualan</p>
            <h3 class="stat-card-value">{{ $stats['total_penjualan'] }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon blue">
                    <i class='bx bx-package'></i>
                </div>
            </div>
            <p class="stat-card-title">Total Stock</p>
            <h3 class="stat-card-value">{{ number_format($stats['stock_products']) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon green">
                    <i class='bx bx-cart'></i>
                </div>
            </div>
            <p class="stat-card-title">Total Order</p>
            <h3 class="stat-card-value">{{ number_format($stats['total_order']) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon orange">
                    <i class='bx bx-user'></i>
                </div>
            </div>
            <p class="stat-card-title">Total Karyawan</p>
            <h3 class="stat-card-value">{{ number_format($stats['total_karyawan']) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-card-header">
                <div class="stat-card-icon pink">
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
                <p style="text-align: center; opacity: 0.6; padding: 20px;">Semua produk stock aman ✓</p>
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
            <p style="text-align: center; opacity: 0.6; padding: 20px;">Belum ada data produk</p>
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
            <p style="text-align: center; opacity: 0.6; padding: 20px;">Belum ada data karyawan</p>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('salesChart');

// Gradient for chart
const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, 'rgba(102, 126, 234, 0.4)');
gradient.addColorStop(1, 'rgba(102, 126, 234, 0.01)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($salesData['labels']) !!},
        datasets: [{
            label: "Penjualan (dalam ribuan)",
            tension: 0.4,
            data: {!! json_encode($salesData['data']) !!},
            borderColor: "#667eea",
            backgroundColor: gradient,
            borderWidth: 3,
            fill: true,
            pointBackgroundColor: "#667eea",
            pointBorderColor: "#fff",
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "#764ba2",
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
                    color: "white",
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
                backgroundColor: 'rgba(0,0,0,0.85)',
                padding: 15,
                cornerRadius: 8,
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
                        return 'Penjualan: Rp ' + context.parsed.y.toLocaleString('id-ID') + 'K';
                    }
                }
            }
        },
        scales: {
            x: { 
                ticks: { 
                    color: "rgba(255,255,255,0.8)",
                    font: {
                        size: 12,
                        family: 'Poppins'
                    }
                },
                grid: {
                    color: 'rgba(255,255,255,0.05)',
                    drawBorder: false
                }
            },
            y: { 
                ticks: { 
                    color: "rgba(255,255,255,0.8)",
                    font: {
                        size: 12,
                        family: 'Poppins'
                    },
                    callback: function(value) {
                        return value + 'K';
                    }
                },
                grid: {
                    color: 'rgba(255,255,255,0.08)',
                    drawBorder: false
                }
            }
        }
    }
});
</script>

@endsection