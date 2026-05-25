@extends('layouts.main')

@section('title', 'Profil - RAYA-E')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 50%, #dbeafe 100%) !important;
    }

    .main-content {
        background: transparent !important;
    }

    .page-header-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.75rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1e3a8a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i { color: #2563EB; }

    .alert {
        border-radius: 14px;
        border: none;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08);
        border: 1px solid rgba(37, 99, 235, 0.1);
        margin-bottom: 2rem;
    }

    /* Avatar section */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding-bottom: 1.75rem;
        margin-bottom: 1.75rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        font-weight: 900;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.25);
    }

    .profile-name {
        font-size: 1.375rem;
        font-weight: 800;
        color: #1e3a8a;
        margin-bottom: 0.25rem;
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        background: rgba(37, 99, 235, 0.1);
        color: #2563EB;
    }

    /* Email display */
    .email-display {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.125rem;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        color: #475569;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .email-display i {
        color: #2563EB;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* Section title */
    .section-title-card {
        font-size: 1.125rem;
        font-weight: 800;
        color: #1e3a8a;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.3px;
    }

    .section-title-card::before {
        content: '';
        width: 4px;
        height: 24px;
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        border-radius: 4px;
        flex-shrink: 0;
    }

    .section-title-card i { color: #2563EB; }

    /* Form */
    .form-label {
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        padding: 0.875rem 1.125rem;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .invalid-feedback {
        font-weight: 600;
        font-size: 0.875rem;
        color: #ef4444;
    }

    .is-invalid { border-color: #ef4444 !important; }
    .is-invalid:focus { box-shadow: 0 0 0 4px rgba(239,68,68,0.1) !important; }

    .btn-primary {
        background: linear-gradient(135deg, #2563EB 0%, #1e40af 100%);
        border: none;
        padding: 0.875rem 2rem;
        font-weight: 700;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.3s ease;
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        color: white;
    }

    /* Password card accent */
    .password-card {
        position: relative;
        overflow: hidden;
    }

    .password-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
        border-radius: 16px 16px 0 0;
    }

    @media (max-width: 768px) {
        .profile-header { flex-direction: column; text-align: center; }
    }
</style>
@endsection

@section('content')

<div class="page-header-card">
    <h1 class="page-title">
        <i class="bi bi-person-circle"></i>
        Profil Saya
    </h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle-fill me-2"></i>
    {{ $errors->first() }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-7">

        {{-- Info Akun --}}
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="profile-name">{{ $user->name }}</div>
                    <span class="profile-role">
                        <i class="bi bi-shield-fill"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <h3 class="section-title-card">
                <i class="bi bi-envelope-fill"></i>
                Email Akun
            </h3>
            <div class="email-display">
                <i class="bi bi-envelope-at-fill"></i>
                <span>{{ $user->email }}</span>
            </div>
        </div>

        {{-- Ubah Password --}}
        <div class="profile-card password-card">
            <h3 class="section-title-card">
                <i class="bi bi-shield-lock-fill"></i>
                Ubah Password
            </h3>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password"
                           name="current_password"
                           class="form-control @error('current_password') is-invalid @enderror"
                           placeholder="Masukkan password lama"
                           required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimal 8 karakter"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Ulangi password baru"
                           required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-shield-check me-2"></i>Ubah Password
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
