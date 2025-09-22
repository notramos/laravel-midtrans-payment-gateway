<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-4 md:py-8 px-4">
    <div class="container mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 md:mb-8 bg-white/80 backdrop-blur-sm rounded-2xl p-4 md:p-6 shadow-lg border border-white/20">
            <div class="flex items-center mb-4 md:mb-0 w-full md:w-auto">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3 md:mr-4 shadow-lg flex-shrink-0">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-xl md:text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                        Detail Pesanan
                    </h2>
                    <p class="text-sm md:text-lg text-gray-600 font-medium truncate">#{{ $order->order_number }}</p>
                </div>
            </div>
            
            <a href="{{ route('orders.index') }}" 
               class="inline-flex items-center px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 w-full md:w-auto justify-center md:justify-start text-sm md:text-base">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali ke Daftar Pesanan</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>
        
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 md:gap-8">
            <!-- Main Content - Order Items & Shipping -->
            <div class="xl:col-span-2 space-y-6 md:space-y-8">
                <!-- Order Items Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-4 md:px-6 py-3 md:py-4">
                        <h3 class="text-lg md:text-xl font-bold text-white flex items-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Item Pesanan
                        </h3>
                    </div>
                    
                    <div class="p-4 md:p-6">
                        <div class="space-y-4 md:space-y-6">
                            @foreach($order->orderItems as $index => $item)
                                <div class="group hover:bg-gray-50/50 rounded-xl p-3 md:p-4 transition-all duration-200 border border-transparent hover:border-blue-200">
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-start space-y-3 md:space-y-0">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-3">
                                                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center mr-2 md:mr-3 shadow-md flex-shrink-0">
                                                    <span class="text-white font-bold text-xs md:text-sm">{{ $index + 1 }}</span>
                                                </div>
                                                <h4 class="text-base md:text-lg font-semibold text-gray-800 break-words">{{ $item->product->name }}</h4>
                                            </div>
                                            
                                            <div class="ml-10 md:ml-13 space-y-2">
                                                <div class="flex items-center text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    <span class="font-medium text-sm md:text-base">{{ $item->quantity }} pcs/m</span>
                                                </div>
                                                
                                                @if($item->design_notes)
                                                    <div class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded-r-lg">
                                                        <div class="flex items-start">
                                                            <svg class="w-4 h-4 mr-2 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                            <div class="min-w-0 flex-1">
                                                                <p class="font-medium text-amber-800 text-xs md:text-sm">Catatan Desain:</p>
                                                                <p class="text-amber-700 text-xs md:text-sm break-words">{{ $item->design_notes }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if($item->design_file)
                                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded-r-lg">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                            </svg>
                                                            <span class="font-medium text-blue-800 text-xs md:text-sm mr-2 flex-shrink-0">File Desain:</span>
                                                            <a href="{{ asset('storage/' . $item->design_file) }}" 
                                                               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-xs md:text-sm hover:underline transition-colors duration-200 min-w-0" 
                                                               target="_blank">
                                                                <span class="truncate">Lihat File</span>
                                                                <svg class="w-3 h-3 ml-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-center md:text-right md:ml-4 flex-shrink-0">
                                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-3 border border-green-200">
                                                <p class="text-lg md:text-2xl font-bold text-green-700">
                                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                </p>
                                                <p class="text-xs md:text-sm text-green-600">
                                                    @ Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if(!$loop->last)
                                    <div class="border-t border-gray-200"></div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Total Section -->
                        <div class="mt-6 md:mt-8 pt-4 md:pt-6 border-t-2 border-gray-200">
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-4 md:p-6 text-white">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                                    <div class="flex items-center justify-center sm:justify-start">
                                        <svg class="w-6 h-6 md:w-8 md:h-8 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <span class="text-lg md:text-2xl font-bold">Total Pesanan</span>
                                    </div>
                                    <span class="text-xl md:text-3xl font-bold text-center sm:text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Address Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-4 md:px-6 py-3 md:py-4">
                        <h3 class="text-lg md:text-xl font-bold text-white flex items-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat Pengiriman
                        </h3>
                    </div>
                    
                    <div class="p-4 md:p-6">
                        <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-4 md:p-6 border border-gray-200">
                            <div class="flex items-start mb-4">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-gray-800 font-medium leading-relaxed text-sm md:text-base break-words">{{ $order->shipping_address }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs md:text-sm text-gray-600 mb-1">Nomor Telepon</p>
                                    <p class="text-gray-800 font-semibold text-sm md:text-base break-all">{{ $order->phone_number }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar - Order Information -->
            <div class="xl:col-span-1">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden xl:sticky xl:top-8">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-4 md:px-6 py-3 md:py-4">
                        <h3 class="text-lg md:text-xl font-bold text-white flex items-center">
                            <svg class="w-5 h-5 md:w-6 md:h-6 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informasi Pesanan
                        </h3>
                    </div>
                    
                    <div class="p-4 md:p-6">
                        <div class="space-y-4 md:space-y-6">
                            <!-- Order Status -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-3 md:p-4 border border-blue-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center mr-2 md:mr-3 shadow-md flex-shrink-0">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-600 font-medium text-sm md:text-base">Status Pesanan</span>
                                    </div>
                                    <span class="px-2 md:px-3 py-1 bg-blue-100 text-blue-800 font-semibold rounded-full text-xs md:text-sm capitalize ml-10 sm:ml-0">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Order Date -->
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-3 md:p-4 border border-green-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-green-400 to-emerald-500 rounded-lg flex items-center justify-center mr-2 md:mr-3 shadow-md flex-shrink-0">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-gray-600 font-medium text-sm md:text-base">Tanggal Pemesanan</span>
                                    </div>
                                    <span class="text-gray-800 font-semibold text-xs md:text-base ml-10 sm:ml-0">{{ $order->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                            
                            @if($order->payment)
                                <!-- Payment Status -->
                                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl p-3 md:p-4 border border-amber-200">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 space-y-2 sm:space-y-0">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-r from-amber-400 to-yellow-500 rounded-lg flex items-center justify-center mr-2 md:mr-3 shadow-md flex-shrink-0">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-600 font-medium text-sm md:text-base">Status Pembayaran</span>
                                        </div>
                                        <span class="px-2 md:px-3 py-1 bg-amber-100 text-amber-800 font-semibold rounded-full text-xs md:text-sm capitalize ml-10 sm:ml-0">
                                            {{ ucfirst($order->payment->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-1 sm:space-y-0">
                                        <div class="flex items-center">
                                            <div class="w-5 h-5 md:w-6 md:h-6 bg-purple-100 rounded-md flex items-center justify-center mr-2 md:mr-3 flex-shrink-0">
                                                <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                </svg>
                                            </div>
                                            <span class="text-gray-600 text-xs md:text-sm">Tipe Pembayaran</span>
                                        </div>
                                        <span class="text-gray-800 font-medium text-xs md:text-sm capitalize ml-7 sm:ml-0">{{ ucfirst($order->payment->payment_type) }}</span>
                                    </div>
                                </div>
                                
                                @if($order->payment->status === 'pending')
                                    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-3 md:p-4 border border-red-200">
                                        <div class="text-center mb-4">
                                            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-r from-red-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg animate-pulse">
                                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-red-800 font-semibold mb-1 text-sm md:text-base">Pembayaran Tertunda</p>
                                            <p class="text-red-600 text-xs md:text-sm">Selesaikan pembayaran Anda</p>
                                        </div>
                                        
                                        <a href="{{ route('payments.show', ['orderNumber'=> $this->order->order_number]) }}" 
                                           class="block w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white text-center py-2 md:py-3 px-3 md:px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm md:text-base">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            <span class="hidden sm:inline">Selesaikan Pembayaran</span>
                                            <span class="sm:hidden">Bayar Sekarang</span>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>