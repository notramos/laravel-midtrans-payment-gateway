<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4">
    <div class="container mx-auto">
        <div class="max-w-2xl mx-auto">
            <!-- Header with animated gradient -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                    Pembayaran Pesanan
                </h1>
                <p class="text-lg text-gray-600 font-medium">#{{ $orderNumber }}</p>
            </div>

            <!-- Main Card with glassmorphism effect -->
            <div class="bg-white/80 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl overflow-hidden">
                
                @if ($isLoading)
                    <div class="p-12">
                        <div class="flex flex-col items-center justify-center">
                            <div class="relative">
                                <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-200"></div>
                                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500 absolute top-0 left-0"></div>
                            </div>
                            <div class="mt-6 text-center">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Memuat Data Pembayaran</h3>
                                <p class="text-gray-600">Mohon tunggu sebentar...</p>
                            </div>
                        </div>
                    </div>

                @elseif ($errorMessage)
                    <div class="p-8">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 rounded-lg p-6 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Pesanan
                            </a>
                        </div>
                    </div>

                @elseif ($paymentStatus === 'success')
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full mb-4 shadow-lg animate-pulse">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-green-800 mb-2">Pembayaran Berhasil!</h2>
                            <p class="text-green-700 text-lg">Terima kasih! Pembayaran Anda telah dikonfirmasi.</p>
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
                                        <p class="font-bold text-lg text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('orders.index') }}" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Kembali ke Daftar Pesanan
                            </a>
                        </div>
                    </div>

                @elseif ($paymentStatus === 'expired')
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full mb-4 shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-yellow-800 mb-2">Pembayaran Kadaluarsa</h2>
                            <p class="text-yellow-700 text-lg">Pembayaran untuk pesanan ini telah kadaluarsa.</p>
                            <p class="text-gray-600 mt-2">Silakan buat ulang pesanan atau pilih metode pembayaran lain.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button 
                                wire:click="retryPayment"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Coba Bayar Lagi
                            </button>
                            <a href="{{ route('orders.index') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Daftar Pesanan
                            </a>
                        </div>
                    </div>

                @else
                    <div class="p-8">
                        <!-- Order Details Card -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Detail Pesanan
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-emerald-500 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Status Pesanan</p>
                                        <p class="text-lg font-semibold text-gray-800 capitalize">{{ ucfirst($order->status) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message -->
                        @error('payment')
                            <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 rounded-lg p-4 mb-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-red-700 font-medium">{{ $message }}</p>
                                    </div>
                                </div>
                            </div>
                        @enderror

                        <!-- Payment Button -->
                        <div class="text-center">
                            <button 
                                wire:click="initPayment"
                                class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-300"
                            >
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Bayar Sekarang
                                <svg class="w-5 h-5 ml-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </button>
                            
                            <p class="text-sm text-gray-500 mt-4">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
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
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-sm">SSL Secured</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="text-sm">Data Protected</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="text-sm">Fast Processing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('initSnapPayment', function(data) {
            console.log('initSnapPayment dipanggil', data[0].snapToken);
            var snapToken = data[0].snapToken;
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log(result);
                    Livewire.dispatch('paymentFinished', {
                        result: JSON.stringify(result)
                    });
                },
                onPending: function(result) {
                    Livewire.dispatch('paymentFinished', {
                        result: JSON.stringify(result)
                    });
                },
                onError: function(result) {
                    Livewire.dispatch('paymentFinished', {
                        result: JSON.stringify(result)
                    });
                    console.log(result);
                },
                onClose: function() {
                    alert('you closed the popup without finishing the payment')
                }
            });
        });
    });
</script>
@endpush