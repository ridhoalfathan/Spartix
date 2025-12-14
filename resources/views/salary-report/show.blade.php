@extends('layouts.main')

@section('page-title', 'Detail Salary Report')

@section('content')

<style>
    .detail-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(15px);
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        max-width: 800px;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .detail-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }

    .detail-header i {
        font-size: 32px;
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .detail-header h2 {
        margin: 0;
        font-size: 24px;
        flex: 1;
    }

    .detail-actions {
        display: flex;
        gap: 10px;
    }

    .employee-section {
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.3);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .employee-section h3 {
        margin: 0 0 15px 0;
        color: #a78bfa;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .employee-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .info-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 16px;
        color: white;
        font-weight: 500;
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
        background: rgba(139, 92, 246, 0.15);
        color: #a78bfa;
        border: 1px solid rgba(139, 92, 246, 0.3);
    }
    
    .badge-produksi { 
        background: rgba(236, 72, 153, 0.15);
        color: #f472b6;
        border: 1px solid rgba(236, 72, 153, 0.3);
    }
    
    .badge-packing { 
        background: rgba(6, 182, 212, 0.15);
        color: #22d3ee;
        border: 1px solid rgba(6, 182, 212, 0.3);
    }
    
    .badge-pengirim { 
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-finishing { 
        background: rgba(249, 115, 22, 0.15);
        color: #fb923c;
        border: 1px solid rgba(249, 115, 22, 0.3);
    }

    .salary-section {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .salary-section h3 {
        margin: 0 0 20px 0;
        color: #34d399;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .salary-breakdown {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .salary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }

    .salary-item-label {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
    }

    .salary-item-value {
        font-size: 16px;
        font-weight: 600;
        color: white;
    }

    .salary-item.total {
        background: rgba(16, 185, 129, 0.2);
        border: 2px solid rgba(16, 185, 129, 0.4);
        margin-top: 10px;
    }

    .salary-item.total .salary-item-label {
        font-size: 16px;
        font-weight: 600;
        color: #34d399;
    }

    .salary-item.total .salary-item-value {
        font-size: 24px;
        color: #34d399;
    }

    .calculation-formula {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.8);
    }

    .calculation-formula strong {
        color: #60a5fa;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid rgba(255,255,255,0.1);
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.6);
    }

    .btn-warning {
        background: linear-gradient(135deg, #ec4899, #db2777);
        color: white;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
    }

    .btn-secondary {
        background: rgba(255,255,255,0.1);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .detail-card {
            padding: 20px;
        }

        .employee-info {
            grid-template-columns: 1fr;
        }

        .detail-header {
            flex-wrap: wrap;
        }

        .detail-actions {
            width: 100%;
        }
    }
</style>

<div class="detail-card">
    <div class="detail-header">
        <i class='bx bx-file'></i>
        <h2>Detail Salary Report</h2>
        <div class="detail-actions">
            <a href="{{ route('salary-report.edit', $salaryReport->id) }}" class="btn btn-warning btn-sm">
                <i class='bx bx-edit'></i> Edit
            </a>
        </div>
    </div>

    <!-- Employee Information -->
    <div class="employee-section">
        <h3><i class='bx bx-user'></i> Informasi Karyawan</h3>
        <div class="employee-info">
            <div class="info-item">
                <span class="info-label">ID Karyawan</span>
                <span class="info-value">{{ $salaryReport->karyawan->id_karyawan }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Karyawan</span>
                <span class="info-value">{{ $salaryReport->karyawan->nama_karyawan }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jabatan</span>
                <span class="info-value">
                    <span class="badge badge-{{ strtolower($salaryReport->karyawan->jabatan) }}">
                        {{ $salaryReport->karyawan->jabatan }}
                    </span>
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal</span>
                <span class="info-value">{{ $salaryReport->tanggal->format('d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Salary Breakdown -->
    <div class="salary-section">
        <h3><i class='bx bx-money'></i> Rincian Gaji</h3>
        <div class="salary-breakdown">
            <div class="salary-item">
                <span class="salary-item-label">Gaji per Jam</span>
                <span class="salary-item-value">Rp {{ number_format($salaryReport->gaji_per_jam, 0, ',', '.') }}</span>
            </div>
            <div class="salary-item">
                <span class="salary-item-label">Lama Bekerja</span>
                <span class="salary-item-value">{{ $salaryReport->lama_bekerja }} Jam</span>
            </div>
            <div class="salary-item">
                <span class="salary-item-label">Subtotal (Gaji × Jam)</span>
                <span class="salary-item-value">
                    Rp {{ number_format($salaryReport->gaji_per_jam * $salaryReport->lama_bekerja, 0, ',', '.') }}
                </span>
            </div>
            <div class="salary-item">
                <span class="salary-item-label">Bonus</span>
                <span class="salary-item-value">Rp {{ number_format($salaryReport->bonus, 0, ',', '.') }}</span>
            </div>
            <div class="salary-item total">
                <span class="salary-item-label">TOTAL GAJI</span>
                <span class="salary-item-value">Rp {{ number_format($salaryReport->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="calculation-formula">
            <strong>📊 Rumus Perhitungan:</strong><br>
            Total = (Gaji per Jam × Lama Bekerja) + Bonus<br>
            Total = (Rp {{ number_format($salaryReport->gaji_per_jam, 0, ',', '.') }} × {{ $salaryReport->lama_bekerja }}) + Rp {{ number_format($salaryReport->bonus, 0, ',', '.') }}<br>
            Total = Rp {{ number_format($salaryReport->gaji_per_jam * $salaryReport->lama_bekerja, 0, ',', '.') }} + Rp {{ number_format($salaryReport->bonus, 0, ',', '.') }}<br>
            <strong>Total = Rp {{ number_format($salaryReport->total, 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('salary-report.index') }}" class="btn btn-secondary">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>
        <a href="{{ route('salary-report.edit', $salaryReport->id) }}" class="btn btn-primary">
            <i class='bx bx-edit'></i> Edit Report
        </a>
    </div>
</div>

@endsection