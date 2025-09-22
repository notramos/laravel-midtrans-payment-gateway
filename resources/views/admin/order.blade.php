<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pesanan #{{ $order->order_number }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center justify-between">
                    <button onclick="window.history.back()"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-900 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Status Badge -->
                        <span
                            class="inline-flex items-center justify-center rounded-full text-sm font-medium px-3 py-1 whitespace-nowrap
                            @if ($order->status === 'belum dibayar') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'menunggu konfirmasi')  bg-blue-100 text-blue-800
                            @elseif($order->status === 'pesanan diproses') bg-orange-100 text-orange-800
                            @elseif($order->status === 'pesanan selesai') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            @if ($order->status === 'menunggu konfirmasi')
                                <button
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition"
                                    onclick="confirmOrder('{{ $order->id }}')">
                                    <i class="fas fa-check mr-2"></i>Konfirmasi Pesanan
                                </button>
                            @elseif($order->status === 'pesanan diproses')
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition"
                                    onclick="markAsReady('{{ $order->id }}')">
                                    <i class="fas fa-check-circle mr-2"></i>Siap Diambil
                                </button>
                            @endif

                            <button
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition"
                                onclick="printOrder()">
                                <i class="fas fa-print mr-2"></i>Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->

            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-4">
                            @foreach ($order->orderItems as $item)
                                <div class="flex items-start space-x-4 p-4 border rounded-lg">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">
                                            {{ $item->product->name ?? 'Product Not Found' }}</h4>

                                        @if ($item->panjang && $item->lebar)
                                            @php
                                                $luas = $item->panjang * $item->lebar;
                                                $totalHarga = $item->price * $luas * $item->quantity;
                                            @endphp
                                            <p class="text-sm text-gray-600">
                                                Rp {{ number_format($item->price, 0, ',', '.') }} ×
                                                {{ $luas }} m²
                                                × {{ $item->quantity }} qty
                                            </p>
                                        @else
                                            @php
                                                $totalHarga = $item->price * $item->quantity;
                                            @endphp
                                            <p class="text-sm text-gray-600">
                                                Rp {{ number_format($item->price, 0, ',', '.') }} ×
                                                {{ $item->quantity }}
                                                qty
                                            </p>
                                        @endif

                                        @if ($item->product && $item->product->sku)
                                            <p class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</p>
                                        @endif

                                        <!-- Size Display -->
                                        @if ($item->panjang && $item->lebar)
                                            <div
                                                class="bg-gray-50 border border-gray-200 rounded p-2 text-xs lg:text-sm text-gray-700 mt-2">
                                                <span class="font-medium">Ukuran:</span> {{ $item->panjang }} m x
                                                {{ $item->lebar }} m
                                                <span class="text-gray-500 ml-2">({{ $luas }} m²)</span>
                                            </div>
                                        @endif

                                        <!-- Design File Section -->
                                        @if ($item->design_file)
                                            <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <i class="fas fa-file-image text-blue-600"></i>
                                                        <span class="text-sm font-medium text-blue-800">File
                                                            Desain</span>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <button
                                                            onclick="viewDesignFile('{{ asset('storage/' . $item->design_file) }}', '{{ basename($item->design_file) }}')"
                                                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded transition">
                                                            <i class="fas fa-eye mr-1"></i>Lihat
                                                        </button>
                                                        <a href="{{ asset('storage/' . $item->design_file) }}" download
                                                            class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded transition inline-block">
                                                            <i class="fas fa-download mr-1"></i>Download
                                                        </a>
                                                    </div>
                                                </div>
                                                <p class="text-xs text-blue-600 mt-1">
                                                    {{ basename($item->design_file) }}
                                                </p>
                                            </div>
                                        @else
                                            <div class="mt-3 bg-gray-50 border border-gray-200 rounded-lg p-3">
                                                <div class="flex items-center">
                                                    <i class="fas fa-info-circle text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-500">Tidak ada file desain</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">Rp
                                            {{ number_format($totalHarga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @if ($item->design_notes)
                                    <div class="mt-3 bg-amber-50 border border-amber-200 rounded-lg p-3">
                                        <div class="flex items-start space-x-2">
                                            <i class="fas fa-sticky-note text-amber-600 mt-0.5"></i>
                                            <div class="flex-1">
                                                <span class="text-sm font-medium text-amber-800">Catatan Desain</span>
                                                <p class="text-sm text-amber-700 mt-1">{{ $item->design_notes }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="mt-6 pt-6 border-t">
                            <div class="space-y-2">
                                <div class="flex justify-between text-base font-semibold pt-2 border-t">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-gray-900">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Name</label>
                                <p class="text-sm text-gray-900">{{ $order->user->name ?? 'Guest' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-sm text-gray-900">{{ $order->user->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Phone</label>
                                <p class="text-sm text-gray-900">{{ $order->phone_number == '' ?? '089383252528' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Customer Address</h3>
                        <div class="text-sm text-gray-900">
                            {{ $order->user->address ?? 'No shipping address provided' }}
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                @if ($order->payment)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Payment Method</label>
                                    <p class="text-sm text-gray-900">{{ $order->payment->payment_type ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Payment Status</label>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if ($order->payment->status === 'success') bg-green-100 text-green-800
                                    @elseif($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->payment->status) }}
                                    </span>
                                </div>
                                @if ($order->snap_token)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500">Snap Token</label>
                                        <p class="text-xs text-gray-900 break-all">{{ $order->snap_token }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Timeline -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Order Timeline</h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Order Placed</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y g:i A') }}
                                    </p>
                                </div>
                            </div>

                            @if ($order->status !== 'pending')
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Order Confirmed</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $order->updated_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (in_array($order->status, ['pesanan selesai']))
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Ready for Pickup</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $order->updated_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($order->status === 'pesanan selesai')
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Order Completed</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $order->updated_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Design File Modal -->
    <div id="designModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-full flex flex-col">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">File Desain</h3>
                <button onclick="closeDesignModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-auto p-4">
                <div id="modalContent" class="flex items-center justify-center min-h-96">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50 flex justify-between">
                <div class="text-sm text-gray-600" id="fileInfo"></div>
                <div class="flex space-x-2">
                    <a id="downloadLink" href="#" download
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                        <i class="fas fa-download mr-2"></i>Download
                    </a>
                    <button onclick="closeDesignModal()"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Design File Viewer Function
        function viewDesignFile(fileUrl, fileName) {
            const modal = document.getElementById('designModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            const fileInfo = document.getElementById('fileInfo');
            const downloadLink = document.getElementById('downloadLink');

            // Set modal title and download link
            modalTitle.textContent = `File Desain: ${fileName}`;
            downloadLink.href = fileUrl;
            downloadLink.download = fileName;

            // Get file extension
            const fileExtension = fileName.split('.').pop().toLowerCase();

            // Clear previous content
            modalContent.innerHTML = '';

            if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(fileExtension)) {
                // Image file
                const img = document.createElement('img');
                img.src = fileUrl;
                img.alt = fileName;
                img.className = 'max-w-full max-h-full object-contain rounded-lg shadow-lg';
                img.onload = function() {
                    fileInfo.textContent = `Gambar • ${this.naturalWidth}×${this.naturalHeight}px • ${fileName}`;
                };
                img.onerror = function() {
                    modalContent.innerHTML = `
                        <div class="text-center text-gray-500">
                            <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                            <p>Gagal memuat gambar</p>
                        </div>
                    `;
                };
                modalContent.appendChild(img);
            } else if (fileExtension === 'pdf') {
                // PDF file
                const iframe = document.createElement('iframe');
                iframe.src = fileUrl + '#toolbar=0';
                iframe.className = 'w-full h-96 border rounded-lg';
                iframe.onerror = function() {
                    modalContent.innerHTML = `
                        <div class="text-center text-gray-500">
                            <i class="fas fa-file-pdf text-4xl mb-4 text-red-500"></i>
                            <p class="mb-4">File PDF tidak dapat ditampilkan di browser ini</p>
                            <a href="${fileUrl}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                <i class="fas fa-external-link-alt mr-2"></i>Buka di Tab Baru
                            </a>
                        </div>
                    `;
                };
                modalContent.appendChild(iframe);
                fileInfo.textContent = `PDF • ${fileName}`;
            } else {
                // Other file types
                modalContent.innerHTML = `
                    <div class="text-center text-gray-500">
                        <i class="fas fa-file text-4xl mb-4"></i>
                        <p class="mb-4">File ini tidak dapat ditampilkan secara langsung</p>
                        <p class="text-sm text-gray-400 mb-4">Format: ${fileExtension.toUpperCase()}</p>
                        <a href="${fileUrl}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-download mr-2"></i>Download untuk Melihat
                        </a>
                    </div>
                `;
                fileInfo.textContent = `${fileExtension.toUpperCase()} • ${fileName}`;
            }

            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Close Design Modal
        function closeDesignModal() {
            const modal = document.getElementById('designModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('designModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDesignModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDesignModal();
            }
        });

        // Confirm Order Function
        function confirmOrder(orderId) {
            Swal.fire({
                title: 'Konfirmasi Pesanan',
                text: 'Apakah Anda yakin ingin mengkonfirmasi pesanan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Konfirmasi',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateOrderStatus(orderId, 'pesanan diproses', 'Pesanan berhasil dikonfirmasi!');
                }
            });
        }

        // Mark as Ready Function
        function markAsReady(orderId) {
            Swal.fire({
                title: 'Pesanan Siap Diambil',
                text: 'Apakah pesanan sudah siap untuk diambil?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Siap Diambil',
                cancelButtonText: 'Belum'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateOrderStatus(orderId, 'pesanan selesai', 'Pesanan sudah siap diambil!');
                }
            });
        }

        // Update Order Status Function
        function updateOrderStatus(orderId, status, successMessage) {
            console.log(status);
            fetch(`/admin/orders/${orderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: successMessage,
                            icon: 'success',
                            confirmButtonColor: '#10b981'
                        }).then(() => {
                            // Reload page to show updated status
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengupdate status pesanan.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                    console.error('Error:', error);
                });
        }

        // Print Order Function
        function printOrder() {
            window.print();
        }

        // Auto-refresh every 30 seconds if order is pending or confirmed
        @if (in_array($order->status, ['menunggu konfirmasi', 'pesanan diproses']))
            setInterval(() => {
                // Check for updates without full reload
                fetch(`/admin/orders/{{ $order->id }}/check-status`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== '{{ $order->status }}') {
                            location.reload();
                        }
                    })
                    .catch(error => console.log('Status check failed:', error));
            }, 30000); // 30 seconds
        @endif
    </script>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .shadow {
                box-shadow: none !important;
            }

            #designModal {
                display: none !important;
            }
        }

        /* Custom styles for SweetAlert */
        .swal2-html-container {
            text-align: left !important;
        }

        /* Modal styles */
        #designModal {
            backdrop-filter: blur(4px);
        }
    </style>
</body>

</html>
