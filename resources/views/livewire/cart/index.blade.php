@extends('components.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 lg:py-8">
    <!-- Header -->
    <div class="mb-6 lg:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Keranjang Belanja</h1>
        <nav class="text-sm">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Beranda</a>
                    <span class="mx-2 text-gray-400">/</span>
                </li>
                <li class="text-gray-600">Keranjang</li>
            </ol>
        </nav>
    </div>

    <!-- Alert Messages -->
    <div id="alert-container"></div>

    @if(!$cart || $cart->cartItems->isEmpty())
        <!-- Empty Cart State -->
        <div class="text-center py-12 lg:py-16" id="empty-cart-state">
            <div class="max-w-md mx-auto px-4">
                <div class="w-20 h-20 lg:w-24 lg:h-24 mx-auto mb-4 lg:mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 lg:w-12 lg:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg lg:text-xl font-semibold text-gray-900 mb-2">Keranjang Anda Kosong</h3>
                <p class="text-gray-600 mb-6 text-sm lg:text-base">Belum ada produk dalam keranjang belanja Anda. Mari mulai berbelanja!</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-4 lg:px-6 py-2.5 lg:py-3 border border-transparent text-sm lg:text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Mulai Belanja
                </a>
            </div>
        </div>
    @else
        <div class="flex flex-col lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start space-y-6 lg:space-y-0" id="cart-content">
            <!-- Cart Items -->
            <div class="lg:col-span-8 order-2 lg:order-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Cart Header -->
                    <div class="bg-gray-50 px-4 lg:px-6 py-3 lg:py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base lg:text-lg font-semibold text-gray-900">
                                Item dalam Keranjang (<span id="cart-items-count">{{ $cart->cartItems->count() }}</span>)
                            </h2>
                            <button id="clear-cart-btn" 
                                    class="text-xs lg:text-sm text-red-600 hover:text-red-800 font-medium">
                                Kosongkan
                            </button>
                        </div>
                    </div>

                    <!-- Cart Items List -->
                    <div class="divide-y divide-gray-200" id="cart-items-container">
                        @foreach($cart->cartItems as $item)
                            <div class="p-4 lg:p-6" data-item-id="{{ $item->id }}" id="cart-item-{{ $item->id }}">
                                <div class="flex flex-col sm:flex-row sm:items-start space-y-3 sm:space-y-0 sm:space-x-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0 self-center sm:self-start">
                                        @if($item->design_file)
                                            <img src="{{ asset('storage/' . $item->design_file) }}"
                                                alt="{{ $item->design_file }}"
                                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg border border-gray-200"
                                                style="object-fit: contain; background: white;">
                                        @else
                                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="space-y-3">
                                            <div>
                                                <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-1">
                                                    {{ $item->product->name }}
                                                </h3>
                                                <p class="text-xs lg:text-sm text-gray-600 mb-2">
                                                    {{ $item->product->description ? Str::limit($item->product->description, 100) : 'Produk berkualitas tinggi' }}
                                                </p>
                                            </div>
                                            
                                            <!-- Design Notes -->
                                            @if($item->design_notes)
                                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-2 lg:p-3">
                                                    <div class="flex items-start">
                                                        <svg class="w-3 h-3 lg:w-4 lg:h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        <div>
                                                            <p class="text-xs font-medium text-blue-800 mb-1">Catatan Desain:</p>
                                                            <p class="text-xs lg:text-sm text-blue-700">{{ $item->design_notes }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Design File -->
                                            @if($item->design_file)
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 000-2.828z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                                                    </svg>
                                                    <a href="{{ asset('storage/' . $item->design_file) }}" 
                                                       target="_blank"
                                                       class="text-xs lg:text-sm text-green-600 hover:text-green-800 font-medium hover:underline">
                                                        📎 Lihat File Desain
                                                    </a>
                                                </div>
                                            @endif

                                            <!-- Price and Controls Section -->
                                            <div class="space-y-3">
                                                <!-- Price per unit -->
                                                <div class="text-sm text-gray-600">
                                                    <span class="font-medium text-gray-900">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                                    <span>/pcs</span>
                                                </div>

                                                <!-- Mobile Layout: Quantity and Actions -->
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                                                    <!-- Quantity Controls -->
                                                    <div class="flex items-center justify-between sm:justify-start">
                                                        <div class="flex items-center border border-gray-300 rounded-lg">
                                                            <button class="quantity-btn minus-btn px-2 lg:px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-l-lg transition-colors"
                                                                    data-item-id="{{ $item->id }}" 
                                                                    data-action="decrease"
                                                                    data-current-qty="{{ $item->quantity }}"
                                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                                <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                                </svg>
                                                            </button>
                                                            
                                                            <span class="quantity-display px-3 lg:px-4 py-1 text-sm font-medium text-gray-900 bg-gray-50 border-l border-r border-gray-300 min-w-[3rem] text-center"
                                                                  id="quantity-{{ $item->id }}">
                                                                {{ $item->quantity }}
                                                            </span>
                                                            
                                                            <button class="quantity-btn plus-btn px-2 lg:px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-r-lg transition-colors"
                                                                    data-item-id="{{ $item->id }}" 
                                                                    data-action="increase"
                                                                    data-current-qty="{{ $item->quantity }}">
                                                                <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <!-- Remove Button (Mobile) -->
                                                        <button class="remove-item-btn sm:hidden p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                                                data-item-id="{{ $item->id }}">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Subtotal and Remove (Desktop) -->
                                                    <div class="flex items-center justify-between sm:justify-end sm:space-x-4">
                                                        <div class="text-right">
                                                            <p class="text-base lg:text-lg font-bold text-gray-900" id="subtotal-{{ $item->id }}">
                                                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 quantity-calculation"
                                                               id="calculation-{{ $item->id }}"
                                                               style="{{ $item->quantity <= 1 ? 'display: none;' : '' }}">
                                                                {{ $item->quantity }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                        <!-- Remove Button (Desktop) -->
                                                        <button class="remove-item-btn hidden sm:block p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                                                data-item-id="{{ $item->id }}">
                                                            <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-4 order-1 lg:order-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 lg:sticky lg:top-8">
                    <div class="px-4 lg:px-6 py-3 lg:py-4 border-b border-gray-200">
                        <h3 class="text-base lg:text-lg font-semibold text-gray-900">Ringkasan Pesanan</h3>
                    </div>
                    
                    <div class="px-4 lg:px-6 py-4 space-y-4">
                        <!-- Summary Details -->
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal (<span id="summary-items-count">{{ $cart->cartItems->sum('quantity') }}</span> item)</span>
                                <span class="font-medium" id="summary-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Biaya Layanan</span>
                                <span class="font-medium text-green-600">Gratis</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-base lg:text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-lg lg:text-xl font-bold text-blue-600" id="summary-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3 pt-4">
                            <button id="checkout-btn" 
                                    class="w-full bg-blue-600 text-white text-center py-2.5 lg:py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center text-sm lg:text-base">
                                <span class="checkout-btn-text">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Lanjutkan ke Pembayaran
                                </span>
                                <span class="checkout-btn-loading hidden">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 inline animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>
                            
                            <a href="{{ route('products.index') }}" 
                               class="w-full bg-gray-100 text-gray-700 text-center py-2.5 lg:py-3 px-4 rounded-lg font-semibold hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center text-sm lg:text-base">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                </svg>
                                Lanjutkan Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
        <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-gray-700">Memproses...</span>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">Konfirmasi</h3>
                </div>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-500" id="modal-message">Apakah Anda yakin?</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" id="modal-cancel" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </button>
                <button type="button" id="modal-confirm" class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]'));
console.log('Checkout button:', document.getElementById('checkout-btn'));
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Elements
    const alertContainer = document.getElementById('alert-container');
    const loadingOverlay = document.getElementById('loading-overlay');
    const confirmationModal = document.getElementById('confirmation-modal');
    const emptyCartState = document.getElementById('empty-cart-state');
    const cartContent = document.getElementById('cart-content');
    
    // Modal elements
    const modalTitle = document.getElementById('modal-title');
    const modalMessage = document.getElementById('modal-message');
    const modalCancel = document.getElementById('modal-cancel');
    const modalConfirm = document.getElementById('modal-confirm');

    // Utility Functions
    function showAlert(message, type = 'success') {
        const alertClass = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800';
        const iconPath = type === 'success' 
            ? 'M5 13l4 4L19 7' 
            : 'M6 18L18 6M6 6l12 12';
        
        const alert = document.createElement('div');
        alert.className = `${alertClass} border px-4 py-3 rounded-lg mb-4 flex items-center`;
        alert.innerHTML = `
            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path>
            </svg>
            <span>${message}</span>
            <button type="button" class="ml-auto" onclick="this.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentElement) {
                alert.remove();
            }
        }, 5000);
    }

    function showLoading() {
        loadingOverlay.classList.remove('hidden');
    }

    function hideLoading() {
        loadingOverlay.classList.add('hidden');
    }

    function showModal(title, message, onConfirm) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        confirmationModal.classList.remove('hidden');
        
        modalConfirm.onclick = function() {
            confirmationModal.classList.add('hidden');
            onConfirm();
        };
    }

    function hideModal() {
        confirmationModal.classList.add('hidden');
    }

    function formatCurrency(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function updateCartUI(data) {
        // Update counters
        const cartItemsCount = document.getElementById('cart-items-count');
        const summaryItemsCount = document.getElementById('summary-items-count');
        const summarySubtotal = document.getElementById('summary-subtotal');
        const summaryTotal = document.getElementById('summary-total');
        
        if (cartItemsCount) cartItemsCount.textContent = data.total_items;
        if (summaryItemsCount) summaryItemsCount.textContent = data.total_items;
        if (summarySubtotal) summarySubtotal.textContent = data.formatted_total;
        if (summaryTotal) summaryTotal.textContent = data.formatted_total;

        // Check if cart is empty
        if (data.is_empty) {
            if (cartContent) cartContent.style.display = 'none';
            if (emptyCartState) emptyCartState.style.display = 'block';
        }
    }

    // Quantity Update Handler
    function updateQuantity(itemId, action, currentQty) {
        const newQty = action === 'increase' ? currentQty + 1 : Math.max(1, currentQty - 1);
        
        if (newQty === currentQty) return;

        showLoading();

        fetch('/cart/update-quantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                item_id: itemId,
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                // Update quantity display
                const quantityDisplay = document.getElementById(`quantity-${itemId}`);
                const subtotalDisplay = document.getElementById(`subtotal-${itemId}`);
                const calculationDisplay = document.getElementById(`calculation-${itemId}`);
                
                if (quantityDisplay) quantityDisplay.textContent = newQty;
              if (subtotalDisplay) subtotalDisplay.textContent = data.item_subtotal_formatted;
                if (calculationDisplay) {
                    calculationDisplay.textContent = `${newQty} × ${data.item_price_formatted}`;
                    calculationDisplay.style.display = newQty > 1 ? 'block' : 'none';
                }
                
                // Update quantity buttons data attributes
                const quantityBtns = document.querySelectorAll(`[data-item-id="${itemId}"]`);
                quantityBtns.forEach(btn => {
                    btn.setAttribute('data-current-qty', newQty);
                    if (btn.classList.contains('minus-btn')) {
                        btn.disabled = newQty <= 1;
                    }
                });
                
                // Update cart summary
                updateCartUI(data);
                
                showAlert(data.message);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat memperbarui jumlah item', 'error');
        });
    }

    // Remove Item Handler
    function removeItem(itemId) {
        showLoading();

        fetch('/cart/remove-item', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                item_id: itemId
            })
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                // Remove item from DOM
                const itemElement = document.getElementById(`cart-item-${itemId}`);
                if (itemElement) {
                    itemElement.style.opacity = '0';
                    itemElement.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        itemElement.remove();
                    }, 300);
                }
                
                // Update cart summary
                updateCartUI(data);
                
                showAlert(data.message);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat menghapus item', 'error');
        });
    }

    // Clear Cart Handler
    function clearCart() {
        showLoading();

        fetch('/cart/clear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            if (data.success) {
                // Hide cart content and show empty state
                if (cartContent) cartContent.style.display = 'none';
                if (emptyCartState) emptyCartState.style.display = 'block';
                
                showAlert(data.message);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat mengosongkan keranjang', 'error');
        });
    }

    // Checkout Handler
    function handleCheckout() {
        const checkoutBtn = document.getElementById('checkout-btn');
        const checkoutBtnText = checkoutBtn.querySelector('.checkout-btn-text');
        const checkoutBtnLoading = checkoutBtn.querySelector('.checkout-btn-loading');
        
        // Show loading state
        checkoutBtnText.classList.add('hidden');
        checkoutBtnLoading.classList.remove('hidden');
        checkoutBtn.disabled = true;

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to checkout page or payment gateway
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    showAlert('Checkout berhasil! Anda akan diarahkan ke halaman pembayaran.', 'success');
                    setTimeout(() => {
                        window.location.href = '/orders';
                    }, 2000);
                }
            } else {
                // Reset button state
                checkoutBtnText.classList.remove('hidden');
                checkoutBtnLoading.classList.add('hidden');
                checkoutBtn.disabled = false;
                
                showAlert(data.message || 'Terjadi kesalahan saat memproses checkout', 'error');
            }
        })
        .catch(error => {
            // Reset button state
            checkoutBtnText.classList.remove('hidden');
            checkoutBtnLoading.classList.add('hidden');
            checkoutBtn.disabled = false;
            
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat memproses checkout', 'error');
        });
    }

    // Event Listeners
    
    // Quantity buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.quantity-btn')) {
            const btn = e.target.closest('.quantity-btn');
            const itemId = parseInt(btn.getAttribute('data-item-id'));
            const action = btn.getAttribute('data-action');
            const currentQty = parseInt(btn.getAttribute('data-current-qty'));
            
            updateQuantity(itemId, action, currentQty);
        }
    });

    // Remove item buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            const btn = e.target.closest('.remove-item-btn');
            const itemId = parseInt(btn.getAttribute('data-item-id'));
            
            showModal(
                'Hapus Item',
                'Apakah Anda yakin ingin menghapus item ini dari keranjang?',
                () => removeItem(itemId)
            );
        }
    });

    // Clear cart button
    const clearCartBtn = document.getElementById('clear-cart-btn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            showModal(
                'Kosongkan Keranjang',
                'Apakah Anda yakin ingin mengosongkan seluruh keranjang belanja?',
                () => clearCart()
            );
        });
    }

    // Checkout button
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            handleCheckout();
        });
    }

    // Modal cancel button
    if (modalCancel) {
        modalCancel.addEventListener('click', hideModal);
    }

    // Close modal when clicking outside
    confirmationModal.addEventListener('click', function(e) {
        if (e.target === confirmationModal) {
            hideModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !confirmationModal.classList.contains('hidden')) {
            hideModal();
        }
    });

    // Auto-save cart changes (optional - for better UX)
    let autoSaveTimeout;
    function scheduleAutoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Sync cart with server if needed
            fetch('/cart/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.warn('Cart sync failed:', data.message);
                }
            })
            .catch(error => console.error('Auto-save error:', error));
        }, 2000);
    }

    // Handle online/offline status
    window.addEventListener('online', function() {
        showAlert('Koneksi internet kembali tersambung', 'success');
        scheduleAutoSave();
    });

    window.addEventListener('offline', function() {
        showAlert('Koneksi internet terputus. Perubahan akan disimpan saat koneksi kembali.', 'error');
    });

    // Smooth animations for quantity changes
    function animateQuantityChange(itemId) {
        const quantityDisplay = document.getElementById(`quantity-${itemId}`);
        if (quantityDisplay) {
            quantityDisplay.style.transform = 'scale(1.1)';
            quantityDisplay.style.transition = 'transform 0.2s ease';
            setTimeout(() => {
                quantityDisplay.style.transform = 'scale(1)';
            }, 200);
        }
    }

    // Add loading states to buttons during operations
    function setButtonLoading(button, isLoading) {
        if (isLoading) {
            button.disabled = true;
            button.style.opacity = '0.6';
            button.style.cursor = 'not-allowed';
        } else {
            button.disabled = false;
            button.style.opacity = '1';
            button.style.cursor = 'pointer';
        }
    }

    // Enhanced error handling with retry mechanism
    function retryOperation(operation, maxRetries = 3) {
        let retries = 0;
        
        function attempt() {
            return operation().catch(error => {
                retries++;
                if (retries < maxRetries) {
                    console.log(`Retrying operation... (${retries}/${maxRetries})`);
                    return new Promise(resolve => {
                        setTimeout(() => resolve(attempt()), 1000 * retries);
                    });
                } else {
                    throw error;
                }
            });
        }
        
        return attempt();
    }

    // Initialize tooltips for better user experience
    function initializeTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', function() {
                const tooltip = document.createElement('div');
                tooltip.className = 'absolute z-50 px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded shadow-lg';
                tooltip.textContent = this.getAttribute('data-tooltip');
                tooltip.style.top = this.offsetTop - 30 + 'px';
                tooltip.style.left = this.offsetLeft + 'px';
                this.parentElement.appendChild(tooltip);
                
                this.addEventListener('mouseleave', function() {
                    if (tooltip.parentElement) {
                        tooltip.remove();
                    }
                }, { once: true });
            });
        });
    }

    // Initialize on page load
    initializeTooltips();

    // Performance optimization: Debounce rapid clicks
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Apply debouncing to quantity changes
    const debouncedQuantityUpdate = debounce(updateQuantity, 300);

    console.log('Cart JavaScript initialized successfully');
});
</script>
