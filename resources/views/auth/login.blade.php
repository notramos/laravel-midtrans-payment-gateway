@extends('auth.auth')

@section('content')
    <div class="container">
        <div class="banner-image">
            <h2>CV.AXEL DIGITAL CREATIVE</h2>
            <p>Solusi cepat dan tepat untuk kebutuhan spanduk Anda</p>
        </div>

        <div class="login-form">
            <div class="login-header">
                <h1>Selamat Datang</h1>
                <p>Silakan masuk untuk melanjutkan menu katalog</p>
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

            <!-- Session Error (for login attempts) -->
            @if (session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-times-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf

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
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password Anda"
                            class="@error('password') input-error @enderror" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="login-button" id="loginBtn">
                    <span class="btn-text">Masuk</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Sedang masuk...
                    </span>
                </button>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

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
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('loginBtn');
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
        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;

            if (password && password.length < 6) {
                this.classList.add('input-error');
            } else {
                this.classList.remove('input-error');
            }
        });
    </script>
@endsection
