@extends('layouts.main')

@section('page-title', 'Laporan Gaji')

@section('content')

<style>
    .container-salary {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(30, 58, 138, 0.1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-section {
        background: white;
        padding: 24px;
        border-radius: 16px;
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        align-items: end;
        flex-wrap: wrap;
        border: 1px solid rgba(30, 58, 138, 0.1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        font-size: 13px;
        color: #1e3a8a;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-group select,
    .filter-group input {
        padding: 12px 16px;
        border: 2px solid rgba(30, 58, 138, 0.2);
        border-radius: 10px;
        background: white;
        color: #1e293b;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: all 0.3s;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #2563eb;
        background: rgba(37, 99, 235, 0.02);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-group select option {
        background: white;
        color: #1e293b;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
        color: white;
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 2px solid rgba(30, 58, 138, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(30, 58, 138, 0.05);
        border-color: #1e3a8a;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
        border-radius: 8px;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table-card {
        background: white;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(30, 58, 138, 0.1);
    }

    .table-card h3 {
        font-size: 22px;
        margin: 0 0 20px 0;
        font-weight: 600;
        color: #1e3a8a;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    }

    table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    table th:first-child {
        border-top-left-radius: 10px;
    }

    table th:last-child {
        border-top-right-radius: 10px;
    }

    table td {
        padding: 16px;
        border-bottom: 1px solid rgba(30, 58, 138, 0.08);
        color: #334155;
        font-size: 14px;
    }

    table tbody tr {
        transition: all 0.2s;
        background: white;
    }

    table tbody tr:hover {
        background: rgba(30, 58, 138, 0.03);
        transform: scale(1.001);
    }

    .badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .badge-admin { 
        background: rgba(30, 58, 138, 0.15);
        color: #1e3a8a;
        border: 1px solid rgba(30, 58, 138, 0.3);
    }
    
    .badge-produksi { 
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .badge-packing { 
        background: rgba(236, 72, 153, 0.15);
        color: #db2777;
        border: 1px solid rgba(236, 72, 153, 0.3);
    }
    
    .badge-pengirim { 
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-finishing { 
        background: rgba(139, 92, 246, 0.15);
        color: #7c3aed;
        border: 1px solid rgba(139, 92, 246, 0.3);
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .badge-paid {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .badge-cancelled {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .price-tag {
        font-weight: 700;
        color: #1e3a8a;
        font-size: 15px;
    }

    .price-success {
        color: #059669;
        font-weight: 700;
        font-size: 16px;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 64px;
        opacity: 0.3;
        margin-bottom: 15px;
        display: block;
        color: #cbd5e1;
    }

    .empty-state h3 {
        font-size: 20px;
        margin: 15px 0 10px 0;
        color: #64748b;
    }

    .empty-state p {
        font-size: 14px;
        color: #94a3b8;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.15);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #059669;
    }

    .karyawan-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .karyawan-name {
        font-weight: 600;
        color: #1e3a8a;
    }

    .karyawan-id {
        font-size: 12px;
        color: #64748b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-salary {
            padding: 20px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-section {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            width: 100%;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            min-width: 1200px;
        }
    }
</style>

<div class="container-salary">
    <div class="page-header">
        <h2>Laporan Gaji</h2>
        <div class="header-actions">
            <a href="{{ route('salary-report.create') }}" class="btn btn-primary">
                <i class='bx bx-plus'></i> Buat Report
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class='bx bx-check-circle'></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter Section -->
    <div class="filter-section">
        <form action="{{ route('salary-report.index') }}" method="GET" style="display: flex; gap: 15px; align-items: end; flex-wrap: wrap; flex: 1;">
            <div class="filter-group">
                <label>Filter Jabatan</label>
                <select name="jabatan" onchange="this.form.submit()">
                    <option value="">Semua Jabatan</option>
                    @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan }}" {{ request('jabatan') == $jabatan ? 'selected' : '' }}>
                            {{ $jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="filter-group">
                <label>Filter Status</label>
                <select name="status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Filter Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="this.form.submit()">
            </div>

            @if(request('jabatan') || request('tanggal') || request('status'))
                <a href="{{ route('salary-report.index') }}" class="btn btn-secondary btn-sm">
                    <i class='bx bx-x'></i> Reset
                </a>
            @endif
        </form>

        <a href="{{ route('salary-report.export-pdf', ['jabatan' => request('jabatan'), 'tanggal' => request('tanggal'), 'status' => request('status')]) }}" class="btn btn-success">
            <i class='bx bx-download'></i> Export PDF
        </a>
    </div>

    <div class="table-card">
        <h3>Daftar Laporan Gaji</h3>
        
        @if($salaryReports->count() > 0)
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Karyawan</th>
                        <th>Tanggal</th>
                        <th>Gaji/Jam</th>
                        <th>Lama Bekerja</th>
                        <th>Bonus</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaryReports as $key => $report)
                    <tr>
                        <td><strong>{{ $key + 1 }}</strong></td>
                        <td>
                            <div class="karyawan-info">
                                <span class="karyawan-name">{{ $report->karyawan->nama_karyawan }}</span>
                                <span class="karyawan-id">{{ $report->karyawan->id_karyawan }}</span>
                                <span class="badge badge-{{ strtolower($report->karyawan->jabatan) }}">
                                    {{ $report->karyawan->jabatan }}
                                </span>
                            </div>
                        </td>
                        <td>{{ $report->tanggal->format('d M Y') }}</td>
                        <td><span class="price-tag">Rp {{ number_format($report->gaji_per_jam, 0, ',', '.') }}</span></td>
                        <td><strong>{{ $report->lama_bekerja }} jam</strong></td>
                        <td><span class="price-tag">Rp {{ number_format($report->bonus, 0, ',', '.') }}</span></td>
                        <td><span class="price-success">Rp {{ number_format($report->total, 0, ',', '.') }}</span></td>
                        <td>
                            <span class="badge badge-{{ $report->status ?? 'pending' }}">
                                {{ $report->status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                @if($report->canBePaid())
                                    <form action="{{ route('salary-report.mark-paid', $report->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm" title="Tandai Dibayar" onclick="return confirm('Tandai sebagai sudah dibayar?')">
                                            <i class='bx bx-check-circle'></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('salary-report.show', $report->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                                
                                @if($report->status !== 'paid')
                                    <a href="{{ route('salary-report.edit', $report->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                @endif
                                
                                <form action="{{ route('salary-report.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class='bx bx-wallet'></i>
            <h3>Belum ada Laporan Gaji</h3>
            <p>Klik tombol "Buat Report" untuk menambahkan data baru</p>
        </div>
        @endif
    </div>
</div>

@endsection