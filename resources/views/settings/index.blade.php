@extends('layouts.main')

@section('page-title', 'Settings')

@section('content')

<style>
    .settings-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .page-header i {
        font-size: 32px;
        color: white;
    }

    .page-header h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 600;
        color: white;
    }

    .settings-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        background: white;
        padding: 8px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .tab-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        background: transparent;
        color: #64748b;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab-btn:hover {
        background: #f8fafc;
        color: #2563eb;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .settings-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }

    .card-header i {
        font-size: 24px;
        color: #2563eb;
    }

    .card-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #334155;
        font-size: 14px;
    }

    .form-group label .required {
        color: #ef4444;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: #f8fafc;
        color: #1e293b;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        transition: 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2563eb;
        background: white;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-group input::placeholder {
        color: #94a3b8;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
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
    }

    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
    }

    .user-info-card {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid #bfdbfe;
    }

    .user-info-card .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: white;
        margin: 0 auto 15px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .user-info-card .user-name {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #1e293b;
    }

    .user-info-card .user-email {
        text-align: center;
        font-size: 14px;
        color: #64748b;
    }

    .password-strength {
        margin-top: 8px;
        font-size: 12px;
    }

    .password-strength .strength-bar {
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        margin-top: 5px;
        overflow: hidden;
    }

    .password-strength .strength-fill {
        height: 100%;
        width: 0;
        background: #10b981;
        transition: 0.3s;
        border-radius: 2px;
    }

    .password-requirements {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
        font-size: 12px;
        border: 1px solid #e5e7eb;
        color: #475569;
    }

    .password-requirements strong {
        color: #1e293b;
        display: block;
        margin-bottom: 8px;
    }

    .password-requirements ul {
        margin: 0;
        padding: 0 0 0 20px;
    }

    .password-requirements li {
        margin: 5px 0;
    }

    @media (max-width: 768px) {
        .settings-tabs {
            flex-direction: column;
        }

        .tab-btn {
            width: 100%;
            justify-content: center;
        }

        .settings-card {
            padding: 20px;
        }
    }
</style>

<div class="settings-container">
    <div class="page-header">
        <i class='bx bx-cog'></i>
        <h2>Settings</h2>
    </div>

    <!-- Tabs -->
    <div class="settings-tabs">
        <button class="tab-btn active" onclick="switchTab('profile')">
            <i class='bx bx-user'></i> Profile
        </button>
        <button class="tab-btn" onclick="switchTab('password')">
            <i class='bx bx-lock'></i> Ubah Password
        </button>
    </div>

    <!-- Profile Tab -->
    <div id="profile-tab" class="tab-content active">
        <div class="settings-card">
            <div class="user-info-card">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-email">{{ $user->email }}</div>
            </div>

            <div class="card-header">
                <i class='bx bx-user-circle'></i>
                <h3>Edit Profile</h3>
            </div>

            <form action="{{ route('settings.update-profile') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $user->name) }}"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                    @error('name')
                        <span class="error-message">
                            <i class='bx bx-error-circle'></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}"
                        placeholder="Masukkan email"
                        required
                    >
                    @error('email')
                        <span class="error-message">
                            <i class='bx bx-error-circle'></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-save'></i> Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Tab -->
    <div id="password-tab" class="tab-content">
        <div class="settings-card">
            <div class="card-header">
                <i class='bx bx-lock-alt'></i>
                <h3>Ubah Password</h3>
            </div>

            <form action="{{ route('settings.update-password') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="current_password">Password Lama <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        placeholder="Masukkan password lama"
                        required
                    >
                    @error('current_password')
                        <span class="error-message">
                            <i class='bx bx-error-circle'></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">Password Baru <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password" 
                        placeholder="Masukkan password baru"
                        required
                        oninput="checkPasswordStrength()"
                    >
                    @error('new_password')
                        <span class="error-message">
                            <i class='bx bx-error-circle'></i> {{ $message }}
                        </span>
                    @enderror
                    <div class="password-strength" id="passwordStrength" style="display: none;">
                        <span id="strengthText">Kekuatan: </span>
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Konfirmasi Password Baru <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="new_password_confirmation" 
                        name="new_password_confirmation" 
                        placeholder="Masukkan ulang password baru"
                        required
                    >
                </div>

                <div class="password-requirements">
                    <strong>Password harus memenuhi syarat:</strong>
                    <ul>
                        <li>Minimal 8 karakter</li>
                        <li>Kombinasi huruf dan angka lebih aman</li>
                        <li>Gunakan karakter khusus untuk password yang lebih kuat</li>
                    </ul>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-check'></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Switch Tab Function
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.closest('.tab-btn').classList.add('active');
}

// Check Password Strength
function checkPasswordStrength() {
    const password = document.getElementById('new_password').value;
    const strengthDiv = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');
    const strengthFill = document.getElementById('strengthFill');
    
    if (password.length === 0) {
        strengthDiv.style.display = 'none';
        return;
    }
    
    strengthDiv.style.display = 'block';
    
    let strength = 0;
    let strengthLabel = '';
    let color = '';
    
    // Check password length
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 25;
    
    // Check for numbers
    if (/\d/.test(password)) strength += 15;
    
    // Check for lowercase and uppercase
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 20;
    
    // Check for special characters
    if (/[^A-Za-z0-9]/.test(password)) strength += 15;
    
    // Determine label and color
    if (strength < 30) {
        strengthLabel = 'Lemah';
        color = '#ef4444';
    } else if (strength < 60) {
        strengthLabel = 'Sedang';
        color = '#f59e0b';
    } else if (strength < 80) {
        strengthLabel = 'Kuat';
        color = '#3b82f6';
    } else {
        strengthLabel = 'Sangat Kuat';
        color = '#10b981';
    }
    
    strengthText.textContent = 'Kekuatan: ' + strengthLabel;
    strengthText.style.color = color;
    strengthFill.style.width = strength + '%';
    strengthFill.style.background = color;
}
</script>

@endsection