@extends('auth.auth')

@section('title', 'Reset Password - SpandukPro')

@section('content')
<div class="container">
    <div class="banner-image">
        <h2 id="banner-title">Reset Password</h2>
        <p id="banner-subtitle">Masukkan email dan nama lengkap untuk verifikasi</p>
    </div>
    
    <div class="login-form">
        <div class="login-header">
            <h1 id="form-title">Reset Password</h1>
            <p id="form-subtitle">Silakan masukkan email dan nama lengkap Anda</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active" id="step1-indicator">
                <span>1</span>
                <label>Verifikasi</label>
            </div>
            <div class="step" id="step2-indicator">
                <span>2</span>
                <label>Password Baru</label>
            </div>
            <div class="step" id="step3-indicator">
                <span>3</span>
                <label>Selesai</label>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alert-container" style="display: none;"></div>

        <!-- Step 1: Verifikasi Email dan Nama -->
        <div id="step1" class="form-step active">
            <form id="verifyForm">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           placeholder="Masukkan email Anda" required>
                    <span class="error" id="email-error"></span>
                </div>
                
                <div class="input-group">
                    <label for="full_name">Nama Lengkap</label>
                    <input type="text" id="full_name" name="full_name" 
                           placeholder="Masukkan nama lengkap Anda" required>
                    <span class="error" id="fullname-error"></span>
                </div>
                
                <button type="submit" class="login-button">
                    <span class="button-text">Verifikasi Data</span>
                    <span class="loading" style="display: none;">Memverifikasi...</span>
                </button>
            </form>
        </div>

        <!-- Step 2: Password Baru -->
        <div id="step2" class="form-step">
            <form id="passwordForm">
                @csrf
                <input type="hidden" id="verified_email" name="email">
                
                <div class="input-group">
                    <label for="new_password">Password Baru</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="new_password" name="password" 
                               placeholder="Masukkan password baru" minlength="8" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('new_password')">
                            👁️
                        </button>
                    </div>
                    <span class="error" id="password-error"></span>
                </div>
                
                <div class="input-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" id="confirm_password" name="password_confirmation" 
                               placeholder="Konfirmasi password baru" minlength="8" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('confirm_password')">
                            👁️
                        </button>
                    </div>
                    <span class="error" id="confirm-error"></span>
                </div>
                
                <div class="password-requirements">
                    <h4>Persyaratan Password:</h4>
                    <ul>
                        <li id="req-length">Minimal 8 karakter</li>
                        <li id="req-case">Mengandung huruf besar dan kecil</li>
                        <li id="req-number">Mengandung angka</li>
                        <li id="req-special">Mengandung karakter khusus (!@#$%^&*)</li>
                    </ul>
                </div>
                
                <button type="submit" class="login-button">
                    <span class="button-text">Update Password</span>
                    <span class="loading" style="display: none;">Memperbarui...</span>
                </button>
                
                <button type="button" class="secondary-button" onclick="goToStep(1)">
                    Kembali
                </button>
            </form>
        </div>

        <!-- Step 3: Sukses -->
        <div id="step3" class="form-step">
            <div class="success-message">
                <div class="success-icon">✅</div>
                <h3>Password Berhasil Diperbarui!</h3>
                <p>Password Anda telah berhasil diperbarui. Silakan login dengan password baru Anda.</p>
                
                <a href="{{ route('login') }}" class="login-button">
                    Login Sekarang
                </a>
            </div>
        </div>

        <div class="register-link">
            <a href="{{ route('login') }}">Kembali ke Login</a>
        </div>
    </div>
</div>

<style>
/* Step Indicator Styles */
.step-indicator {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
    gap: 20px;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    opacity: 0.5;
    transition: opacity 0.3s;
}

.step.active {
    opacity: 1;
}

.step span {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 5px;
    transition: background 0.3s;
}

.step.active span {
    background: #007bff;
    color: white;
}

.step label {
    font-size: 12px;
    text-align: center;
}

/* Form Step Styles */
.form-step {
    display: none;
}

.form-step.active {
    display: block;
}

/* Password Input Wrapper */
.password-input-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    opacity: 0.6;
}

.toggle-password:hover {
    opacity: 1;
}

/* Password Requirements */
.password-requirements {
    margin: 15px 0;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
    border-left: 4px solid #007bff;
}

.password-requirements h4 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 14px;
}

.password-requirements ul {
    margin: 0;
    padding-left: 20px;
}

.password-requirements li {
    margin: 5px 0;
    font-size: 12px;
    transition: color 0.3s;
}

.password-requirements li.valid {
    color: #28a745;
    font-weight: bold;
}

.password-requirements li.invalid {
    color: #dc3545;
}

/* Success Message */
.success-message {
    text-align: center;
    padding: 30px;
}

.success-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.success-message h3 {
    color: #28a745;
    margin-bottom: 15px;
}

.success-message p {
    color: #666;
    margin-bottom: 25px;
}

/* Secondary Button */
.secondary-button {
    width: 100%;
    padding: 12px;
    background: #6c757d;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
    transition: background 0.3s;
}

.secondary-button:hover {
    background: #5a6268;
}

/* Alert Styles */
.alert {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-size: 14px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Loading Animation */
.loading {
    display: inline-block;
}

.loading::after {
    content: '';
    width: 16px;
    height: 16px;
    border: 2px solid #ffffff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: inline-block;
    margin-left: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
let currentStep = 1;

// Step Navigation
function goToStep(step) {
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(el => {
        el.classList.remove('active');
    });
    
    // Hide all step indicators
    document.querySelectorAll('.step').forEach(el => {
        el.classList.remove('active');
    });
    
    // Show current step
    document.getElementById(`step${step}`).classList.add('active');
    document.getElementById(`step${step}-indicator`).classList.add('active');
    
    // Update titles
    const titles = {
        1: {
            banner: 'Reset Password',
            bannerSub: 'Masukkan email dan nama lengkap untuk verifikasi',
            form: 'Reset Password',
            formSub: 'Silakan masukkan email dan nama lengkap Anda'
        },
        2: {
            banner: 'Password Baru',
            bannerSub: 'Buat password baru yang aman',
            form: 'Buat Password Baru',
            formSub: 'Masukkan password baru untuk akun Anda'
        },
        3: {
            banner: 'Berhasil!',
            bannerSub: 'Password Anda telah berhasil diperbarui',
            form: 'Reset Password Selesai',
            formSub: 'Silakan login dengan password baru Anda'
        }
    };
    
    document.getElementById('banner-title').textContent = titles[step].banner;
    document.getElementById('banner-subtitle').textContent = titles[step].bannerSub;
    document.getElementById('form-title').textContent = titles[step].form;
    document.getElementById('form-subtitle').textContent = titles[step].formSub;
    
    currentStep = step;
}

// Show Alert
function showAlert(message, type = 'error') {
    const alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    alertContainer.style.display = 'block';
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        alertContainer.style.display = 'none';
    }, 5000);
}

// Toggle Password Visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;
}

// Password Validation
function validatePassword(password) {
    const requirements = {
        length: password.length >= 8,
        case: /[a-z]/.test(password) && /[A-Z]/.test(password),
        number: /\d/.test(password),
        special: /[!@#$%^&*]/.test(password)
    };
    
    // Update UI
    document.getElementById('req-length').className = requirements.length ? 'valid' : 'invalid';
    document.getElementById('req-case').className = requirements.case ? 'valid' : 'invalid';
    document.getElementById('req-number').className = requirements.number ? 'valid' : 'invalid';
    document.getElementById('req-special').className = requirements.special ? 'valid' : 'invalid';
    
    return Object.values(requirements).every(req => req);
}

// Form Handlers
document.getElementById('verifyForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const button = this.querySelector('button');
    const buttonText = button.querySelector('.button-text');
    const loading = button.querySelector('.loading');
    
    // Show loading
    buttonText.style.display = 'none';
    loading.style.display = 'inline';
    button.disabled = true;
    
    const formData = new FormData(this);
    
    try {
        // Simulate API call - replace with actual endpoint
        const response = await fetch('{{ route("password.reset.verify") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('verified_email').value = formData.get('email');
            showAlert('Verifikasi berhasil! Silakan buat password baru.', 'success');
            goToStep(2);
        } else {
            showAlert(data.message || 'Email atau nama lengkap tidak ditemukan.');
        }
    } catch (error) {
        showAlert('Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        // Hide loading
        buttonText.style.display = 'inline';
        loading.style.display = 'none';
        button.disabled = false;
    }
});

document.getElementById('passwordForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const password = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    // Validate password
    if (!validatePassword(password)) {
        showAlert('Password tidak memenuhi persyaratan.');
        return;
    }
    
    if (password !== confirmPassword) {
        showAlert('Konfirmasi password tidak cocok.');
        return;
    }
    
    const button = this.querySelector('button[type="submit"]');
    const buttonText = button.querySelector('.button-text');
    const loading = button.querySelector('.loading');
    
    // Show loading
    buttonText.style.display = 'none';
    loading.style.display = 'inline';
    button.disabled = true;
    
    const formData = new FormData(this);
    
    try {
        // Simulate API call - replace with actual endpoint
        const response = await fetch('{{ route("password.reset.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            goToStep(3);
        } else {
            showAlert(data.message || 'Terjadi kesalahan saat memperbarui password.');
        }
    } catch (error) {
        showAlert('Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        // Hide loading
        buttonText.style.display = 'inline';
        loading.style.display = 'none';
        button.disabled = false;
    }
});

// Real-time password validation
document.getElementById('new_password').addEventListener('input', function() {
    validatePassword(this.value);
});

// Real-time confirm password validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (password === confirmPassword && password.length > 0) {
        this.style.borderColor = '#28a745';
        document.getElementById('confirm-error').textContent = '';
    } else if (confirmPassword.length > 0) {
        this.style.borderColor = '#dc3545';
        document.getElementById('confirm-error').textContent = 'Password tidak cocok';
    } else {
        this.style.borderColor = '';
        document.getElementById('confirm-error').textContent = '';
    }
});
</script>
@endsection