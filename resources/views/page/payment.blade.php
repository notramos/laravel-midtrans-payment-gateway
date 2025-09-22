<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Payment</title>
</head>

<body class="bg-gray-100">
    @include('components.navbar')
    <div class="container mx-auto p-6">
        <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4">
            <div class="container mx-auto">
                <div class="max-w-2xl mx-auto">
                    <!-- Header with animated gradient -->
                    <div class="text-center mb-8">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h1
                            class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                            Pembayaran Pesanan
                        </h1>
                        <p class="text-lg text-gray-600 font-medium">#{{ $orderNumber ?? '' }}</p>
                    </div>

                    <!-- Main Card with glassmorphism effect -->
                    <div
                        class="bg-white/80 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl overflow-hidden">

                        <!-- Loading State -->
                        <div id="loading-section"
                            class="hidden fixed inset-0 z-50 bg-white bg-opacity-80 flex items-center justify-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="relative">
                                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-200"></div>
                                    <div
                                        class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 absolute top-0 left-0">
                                    </div>
                                </div>
                                <div class="mt-6 text-center">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Memuat Data Pembayaran</h3>
                                    <p class="text-gray-600">Mohon tunggu sebentar...</p>
                                </div>
                            </div>
                        </div>

                        @if (isset($errorMessage))
                            <!-- Error State -->
                            <div class="p-8">
                                <div
                                    class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 rounded-lg p-6 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-semibold text-red-800 mb-1">Terjadi Kesalahan</h3>
                                            <p class="text-red-700">{{ $errorMessage }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('orders.index') }}"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Kembali ke Pesanan
                                    </a>
                                </div>
                            </div>
                        @elseif(isset($paymentStatus) && $paymentStatus === 'success')
                            <!-- Success State -->
                            <div class="p-8">
                                <div class="text-center mb-8">
                                    <div
                                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full mb-4 shadow-lg animate-pulse">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold text-green-800 mb-2">Pembayaran Berhasil!</h2>
                                    <p class="text-green-700 text-lg">Terima kasih! Pembayaran Anda telah dikonfirmasi.
                                    </p>
                                </div>

                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 mb-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                            <div>
                                                <p class="text-sm text-gray-600">Nomor Pesanan</p>
                                                <p class="font-semibold text-gray-800">{{ $order->order_number }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-blue-400 rounded-full mr-3"></div>
                                            <div>
                                                <p class="text-sm text-gray-600">Total Pembayaran</p>
                                                <p class="font-bold text-lg text-gray-800">Rp
                                                    {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('orders.index') }}"
                                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        Kembali ke Daftar Pesanan
                                    </a>
                                </div>
                            </div>
                        @elseif(isset($paymentStatus) && $paymentStatus === 'expired')
                            <!-- Expired State -->
                            <div class="p-8">
                                <div class="text-center mb-8">
                                    <div
                                        class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full mb-4 shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold text-yellow-800 mb-2">Pembayaran Kadaluarsa</h2>
                                    <p class="text-yellow-700 text-lg">Pembayaran untuk pesanan ini telah kadaluarsa.
                                    </p>
                                    <p class="text-gray-600 mt-2">Silakan buat ulang pesanan atau pilih metode
                                        pembayaran lain.</p>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <a href="{{ route('payment.retry', $orderNumber) }}"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                            </path>
                                        </svg>
                                        Coba Bayar Lagi
                                    </a>
                                    <a href="{{ route('orders.index') }}"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                        </svg>
                                        Kembali ke Daftar Pesanan
                                    </a>
                                </div>
                            </div>
                        @elseif(isset($order))
                            <!-- Payment Form -->
                            <div class="p-8">
                                <!-- Order Details Card -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-8">
                                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        Detail Pesanan
                                    </h2>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="flex items-center">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-green-400 to-emerald-500 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                                                <p class="text-2xl font-bold text-gray-800">Rp
                                                    {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600 mb-1">Status Pesanan</p>
                                                <p class="text-lg font-semibold text-gray-800 capitalize">
                                                    {{ ucfirst($order->status) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Error Message -->
                                <div id="payment-error"
                                    class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 rounded-lg p-4 mb-6 hidden">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p id="payment-error-message" class="text-red-700 font-medium"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Button -->
                                <div class="text-center">
                                    <button id="payment-button" data-order-number="{{ $order->order_number }}"
                                        class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-300">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                        Bayar Sekarang
                                        <svg class="w-5 h-5 ml-2 animate-bounce" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </button>

                                    <p class="text-sm text-gray-500 mt-4">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                        Pembayaran aman dan terenkripsi
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-8 text-center">
                        <div class="flex items-center justify-center space-x-8 text-gray-500">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <span class="text-sm">SSL Secured</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span class="text-sm">Data Protected</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="text-sm">Fast Processing</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentButton = document.getElementById('payment-button');
                const errorDiv = document.getElementById('payment-error');
                const errorMessage = document.getElementById('payment-error-message');
                const loadingSection = document.getElementById('loading-section');

                // PERBAIKAN: Ambil orderNumber dari data attribute atau global variable
                const orderNumber = paymentButton ? paymentButton.getAttribute('data-order-number') : null;

                // Validation: pastikan orderNumber ada
                if (!orderNumber) {
                    console.error('Order number not found');
                    showError('Order number tidak ditemukan. Silakan refresh halaman.');
                    return;
                }

                // Function to show error messages
                function showError(message) {
                    if (errorMessage) {
                        errorMessage.textContent = message;
                    }
                    if (errorDiv) {
                        errorDiv.classList.remove('hidden');
                        errorDiv.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }

                // Function to show success messages
                function showSuccessMessage(message) {
                    const successDiv = document.createElement('div');
                    successDiv.className =
                        'bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 rounded-lg p-4 mb-6';
                    successDiv.innerHTML = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-green-700 font-medium">${message}</p>
                </div>
            </div>
        `;

                    if (paymentButton) {
                        const paymentSection = paymentButton.closest('.text-center');
                        if (paymentSection && paymentSection.parentNode) {
                            paymentSection.parentNode.insertBefore(successDiv, paymentSection);
                        }
                        successDiv.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }

                if (paymentButton) {
                    paymentButton.addEventListener('click', function() {
                        // Show loading
                        if (loadingSection) {
                            loadingSection.classList.remove('hidden');
                        }
                        paymentButton.disabled = true;
                        paymentButton.innerHTML = 'Memproses...';

                        // Hide previous errors
                        if (errorDiv) {
                            errorDiv.classList.add('hidden');
                        }

                        // PERBAIKAN: Buat URL secara dinamis
                        const initPaymentUrl = `/payment/init`; // Atau sesuaikan dengan route Anda

                        fetch(initPaymentUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    order_number: orderNumber
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Hide loading
                                if (loadingSection) {
                                    loadingSection.classList.add('hidden');
                                }
                                paymentButton.disabled = false;
                                paymentButton.innerHTML = `
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 003 3z"></path>
                    </svg>
                    Bayar Sekarang
                    <svg class="w-5 h-5 ml-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                `;

                                // Check redirect first jika sudah dibayar
                                if (!data.success && data.redirect) {
                                    window.location.href = data.redirect;
                                    return;
                                }

                                if (data.success && data.snapToken) {
                                    // Check if Midtrans Snap is loaded
                                    if (typeof window.snap === 'undefined') {
                                        showError(
                                            'Midtrans belum dimuat. Silakan refresh halaman dan coba lagi.'
                                            );
                                        return;
                                    }

                                    // Open Midtrans Snap popup
                                    window.snap.pay(data.snapToken, {
                                        onSuccess: function(result) {
                                            console.log('Payment success:', result);
                                            handlePaymentResult(result, 'success');
                                        },
                                        onPending: function(result) {
                                            console.log('Payment pending:', result);
                                            handlePaymentResult(result, 'pending');
                                        },
                                        onError: function(result) {
                                            console.log('Payment error:', result);
                                            handlePaymentResult(result, 'error');
                                        },
                                        onClose: function() {
                                            console.log('Payment popup closed');
                                            showError(
                                                'Pembayaran dibatalkan. Silakan coba lagi jika Anda ingin melanjutkan pembayaran.'
                                                );
                                        }
                                    });
                                } else {
                                    showError(data.message ||
                                        'Gagal memuat data pembayaran. Silakan coba lagi.');
                                }
                            })
                            .catch(error => {
                                // Hide loading
                                if (loadingSection) {
                                    loadingSection.classList.add('hidden');
                                }
                                paymentButton.disabled = false;
                                paymentButton.innerHTML = `
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 003 3z"></path>
                    </svg>
                    Bayar Sekarang
                    <svg class="w-5 h-5 ml-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                `;

                                console.error('Error:', error);
                                showError(
                                    'Terjadi kesalahan jaringan. Silakan periksa koneksi internet Anda dan coba lagi.'
                                    );
                            });
                    });
                }

                // PERBAIKAN: Function untuk handle payment result
                function handlePaymentResult(result, status) {
                    const resultUrl = `/payment/result`; // Atau sesuaikan dengan route Anda

                    fetch(resultUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                result: JSON.stringify(result)
                            })
                        })
                        .then(response => response.json())
                        .then(responseData => {
                            if (status === 'success') {
                                window.location.href = `/payment/${orderNumber}?status=success`;
                            } else if (status === 'pending') {
                                showSuccessMessage(
                                    'Pembayaran sedang diproses. Silakan cek status pembayaran Anda.');
                            } else {
                                showError(responseData.message ||
                                    'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                            }
                        })
                        .catch(error => {
                            console.error('Error processing payment result:', error);
                            if (status === 'success') {
                                window.location.reload();
                            } else if (status === 'pending') {
                                showSuccessMessage(
                                    'Pembayaran sedang diproses. Silakan cek status pembayaran Anda.');
                            } else {
                                showError('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                            }
                        });
                }

                // Auto-hide error messages after 10 seconds
                if (errorDiv && !errorDiv.classList.contains('hidden')) {
                    setTimeout(() => {
                        errorDiv.classList.add('hidden');
                    }, 10000);
                }

                // Handle page visibility change to refresh payment status
                document.addEventListener('visibilitychange', function() {
                    if (!document.hidden) {
                        const urlParams = new URLSearchParams(window.location.search);
                        if (urlParams.get('refresh') === 'true') {
                            window.location.href = window.location.pathname;
                        }
                    }
                });

                // Add hover effects to buttons
                const buttons = document.querySelectorAll('a[class*="bg-gradient"], button[class*="bg-gradient"]');
                buttons.forEach(button => {
                    button.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-2px) scale(1.02)';
                    });

                    button.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                    });
                });
            });
        </script>
    </div>
</body>

</html>
