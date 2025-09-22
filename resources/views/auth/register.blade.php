@extends('auth.auth')

@section('content')
    <div class="container">
        <div class="banner-image">
            <h2>CV.AXEL DIGITAL CREATIVE</h2>
            <p>Bergabunglah dengan kami untuk solusi spanduk terbaik</p>
        </div>

        <div class="login-form">
            <div class="login-header">
                <h1>Daftar Sekarang</h1>
                <p>Silakan isi formulir untuk membuat akun baru</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Session Error -->
            @if (session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-times-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf

                <div class="input-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda"
                            value="{{ old('name') }}" class="@error('name') input-error @enderror" required>
                    </div>
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda"
                            value="{{ old('email') }}" class="@error('email') input-error @enderror" required>
                    </div>
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="phone">Nomor Telepon</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" id="phone" name="phone" placeholder="Contoh: 08123456789"
                            value="{{ old('phone') }}" class="@error('phone') input-error @enderror" required>
                    </div>
                    @error('phone')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                    <small class="input-help">Format: 08xxxxxxxxxx atau +62xxxxxxxxxx</small>
                </div>

                <div class="input-group">
                    <label for="address">Alamat Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-map-marker-alt input-icon"></i>
                        <textarea id="address" name="address" placeholder="Masukkan alamat lengkap Anda"
                            class="@error('address') input-error @enderror" rows="3" required>{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                    <small class="input-help">Alamat akan digunakan untuk keperluan data customer
                    </small>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Buat password Anda"
                            class="@error('password') input-error @enderror" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="toggleIconPassword"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                    <small class="input-help">Minimal 8 karakter, kombinasi huruf dan angka</small>
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Konfirmasi password Anda"
                            class="@error('password_confirmation') input-error @enderror" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="toggleIconPasswordConfirmation"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="login-button" id="registerBtn">
                    <span class="btn-text">Daftar Sekarang</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Sedang mendaftar...
                    </span>
                </button>

                <div class="register-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk Sekarang</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById('toggleIcon' + fieldId.charAt(0).toUpperCase() + fieldId.slice(1)
                .replace('_', ''));

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Form Submission with Loading State
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('registerBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');

            // Show loading state
            btnText.style.display = 'none';
            btnLoading.style.display = 'flex';
            submitBtn.disabled = true;

            // If form validation fails, restore button state
            setTimeout(() => {
                if (!this.checkValidity()) {
                    btnText.style.display = 'block';
                    btnLoading.style.display = 'none';
                    submitBtn.disabled = false;
                }
            }, 100);
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });

        // Real-time validation feedback
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value.trim();

            if (name && name.length < 2) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });

        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });

        document.getElementById('phone').addEventListener('input', function() {
            const phone = this.value;
            // Format nomor Indonesia
            const phoneRegex = /^(\+62|62|0)8[1-9][0-9]{6,9}$/;

            if (phone && !phoneRegex.test(phone.replace(/[\s-]/g, ''))) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });

        document.getElementById('address').addEventListener('input', function() {
            const address = this.value.trim();

            if (address && address.length < 10) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;

            if (password && password.length < 8) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;

            if (confirmation && password !== confirmation) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });

        // Auto-format phone number
        document.getElementById('phone').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');

            // Convert +62 to 0
            if (value.startsWith('62')) {
                value = '0' + value.substring(2);
            }

            // Ensure starts with 0
            if (value && !value.startsWith('0')) {
                value = '0' + value;
            }

            this.value = value;
        });
    </script>
@endsection
