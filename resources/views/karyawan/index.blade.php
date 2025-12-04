@extends('layouts.main')

@section('page-title', 'Data Karyawan')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 600;
    }

    .btn {
        padding: 12px 24px;
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
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    .table-card {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(15px);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: white;
        margin-top: 20px;
    }

    table thead {
        background: rgba(255,255,255,0.1);
    }

    table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid rgba(255,255,255,0.2);
    }

    table td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    table tbody tr {
        transition: 0.2s;
    }

    table tbody tr:hover {
        background: rgba(255,255,255,0.1);
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .badge-admin { background: #667eea; color: white; }
    .badge-produksi { background: #f093fb; color: white; }
    .badge-packing { background: #4facfe; color: white; }
    .badge-pengirim { background: #43e97b; color: white; }
    .badge-finishing { background: #fa709a; color: white; }

    .badge-laporan { background: #ffeaa7; color: #2d3436; }
    .badge-besar { background: #55efc4; color: #2d3436; }
    .badge-sedang { background: #74b9ff; color: white; }
    .badge-kecil { background: #fab1a0; color: white; }

    .actions {
        display: flex;
        gap: 8px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        opacity: 0.7;
    }

    .empty-state i {
        font-size: 80px;
        margin-bottom: 20px;
        opacity: 0.5;
    }
</style>

<div class="page-header">
    <h2>Data Karyawan</h2>
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
        <i class='bx bx-plus'></i> Tambah Karyawan
    </a>
</div>

<div class="table-card">
    <h3>Daftar Karyawan</h3>
    
    @if($karyawans->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Kategori</th>
                <th>Hasil</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawans as $key => $karyawan)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td><strong>{{ $karyawan->id_karyawan }}</strong></td>
                <td>{{ $karyawan->nama_karyawan }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($karyawan->jabatan) }}">
                        {{ $karyawan->jabatan }}
                    </span>
                </td>
                <td>
                    @php
                        $kategoriClass = match($karyawan->kategori) {
                            'Mencatat Laporan' => 'laporan',
                            'Besar' => 'besar',
                            'Sedang' => 'sedang',
                            'Kecil' => 'kecil',
                            default => 'laporan'
                        };
                    @endphp
                    <span class="badge badge-{{ $kategoriClass }}">
                        {{ $karyawan->kategori }}
                    </span>
                </td>
                <td>{{ $karyawan->hasil ?? '-' }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-warning btn-sm">
                            <i class='bx bx-edit'></i>
                        </a>
                        <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <i class='bx bx-user-x'></i>
        <h3>Belum ada data karyawan</h3>
        <p>Klik tombol "Tambah Karyawan" untuk menambahkan data baru</p>
    </div>
    @endif
</div>

@endsection