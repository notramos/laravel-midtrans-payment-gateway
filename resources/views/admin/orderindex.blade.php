<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
    <title>Kelola Pesanan</title>
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
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            <i class="fas fa-shopping-cart mr-3 text-blue-600"></i>Kelola Pesanan
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Dashboard untuk mengelola semua pesanan pelanggan
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                         <a href="/admin/dashboard" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                        </a>
                        <button 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition"
                            onclick="refreshOrders()">
                            <i class="fas fa-sync-alt mr-2"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Belum Dibayar</dt>
                                <dd class="text-lg font-medium text-gray-900" id="belumDibayarCount">5</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hourglass-half text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Konfirmasi</dt>
                                <dd class="text-lg font-medium text-gray-900" id="menungguKonfirmasiCount">8</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cog text-orange-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Sedang Diproses</dt>
                                <dd class="text-lg font-medium text-gray-900" id="sedangDiprosesCount">12</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                                <dd class="text-lg font-medium text-gray-900" id="selesaiCount">25</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white shadow rounded-lg">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <select id="tabs" name="tabs" class="block w-full focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md" onchange="showMobileTab(this.value)">
                    <option value="belum-dibayar">Belum Dibayar</option>
                    <option value="menunggu-konfirmasi">Menunggu Konfirmasi</option>
                    <option value="pesanan-diproses">Sedang Diproses</option>
                    <option value="pesanan-selesai">Selesai</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button onclick="showTab('belum-dibayar')" class="tab-button active border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fas fa-clock mr-2"></i>Belum Dibayar
                        </button>
                        <button onclick="showTab('menunggu-konfirmasi')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fas fa-hourglass-half mr-2"></i>Menunggu Konfirmasi
                        </button>
                        <button onclick="showTab('pesanan-diproses')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fas fa-cog mr-2"></i>Sedang Diproses
                        </button>
                        <button onclick="showTab('pesanan-selesai')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            <i class="fas fa-check-circle mr-2"></i>Selesai
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Contents -->
            <div class="p-6">
                <!-- Belum Dibayar Tab -->
                <div id="belum-dibayar-tab" class="tab-content">
                    <div class="space-y-4" id="belumDibayarOrders">
                        <!-- Orders will be loaded here -->
                    </div>
                </div>

                <!-- Menunggu Konfirmasi Tab -->
                <div id="menunggu-konfirmasi-tab" class="tab-content hidden">
                    <div class="space-y-4" id="menungguKonfirmasiOrders">
                        <!-- Orders will be loaded here -->
                    </div>
                </div>

                <!-- Pesanan Diproses Tab -->
                <div id="pesanan-diproses-tab" class="tab-content hidden">
                    <div class="space-y-4" id="pesananDiprosesOrders">
                        <!-- Orders will be loaded here -->
                    </div>
                </div>

                <!-- Pesanan Selesai Tab -->
                <div id="pesanan-selesai-tab" class="tab-content hidden">
                    <div class="space-y-4" id="pesananSelesaiOrders">
                        <!-- Orders will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Global variable untuk menyimpan data pesanan
    let ordersData = {};

    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getStatusBadge(status) {
        const statusClasses = {
            'belum dibayar': 'bg-yellow-100 text-yellow-800',
            'menunggu konfirmasi': 'bg-blue-100 text-blue-800',
            'pesanan diproses': 'bg-orange-100 text-orange-800',
            'pesanan selesai': 'bg-green-100 text-green-800'
        };
        
        return `<span class="inline-flex items-center justify-center rounded-full text-sm font-medium px-3 py-1 whitespace-nowrap ${statusClasses[status] || 'bg-gray-100 text-gray-800'}">
            ${status.charAt(0).toUpperCase() + status.slice(1)}
        </span>`;
    }

    function getActionButtons(order) {
        let buttons = `<a href="/admin/orders/${order.id}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition inline-block">
            <i class="fas fa-eye mr-2"></i>Detail
        </a>`;

        if (order.status === 'menunggu konfirmasi') {
            buttons = `<button 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition mr-2" 
                onclick="confirmOrder('${order.id}')">
                <i class="fas fa-check mr-2"></i>Konfirmasi
            </button>` + buttons;
        } else if (order.status === 'pesanan diproses') {
            buttons = `<button 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition mr-2" 
                onclick="markAsReady('${order.id}')">
                <i class="fas fa-check-circle mr-2"></i>Siap Diambil
            </button>` + buttons;
        }

        return buttons;
    }

    function createOrderCard(order) {
        const unreadIndicator = !order.is_read ? '<div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>' : '';
        
        return `
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <h3 class="text-lg font-semibold text-gray-900">${order.order_number}</h3>
                        ${unreadIndicator}
                    </div>
                    ${getStatusBadge(order.status)}
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Pelanggan</label>
                        <p class="text-sm text-gray-900">${order.user.name}</p>
                        <p class="text-xs text-gray-600">${order.user.email}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Total</label>
                        <p class="text-sm font-semibold text-gray-900">${formatCurrency(order.total_amount)}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Telepon</label>
                        <p class="text-sm text-gray-900">${order.phone_number}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tanggal</label>
                        <p class="text-sm text-gray-900">${formatDate(order.created_at)}</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm font-medium text-gray-500">Alamat Pengiriman</label>
                    <p class="text-sm text-gray-900">${order.shipping_address}</p>
                </div>
                
                <div class="flex justify-end space-x-2">
                    ${getActionButtons(order)}
                </div>
            </div>
        `;
    }

    // Fungsi untuk mengambil data pesanan dari database
    async function fetchOrdersData() {
        try {
            const response = await fetch('/orders/data', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                ordersData = data.orders;
                updateCounts(data.counts);
                renderOrders();
            } else {
                throw new Error(data.message || 'Gagal mengambil data pesanan');
            }
        } catch (error) {
            console.error('Error fetching orders:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Gagal mengambil data pesanan dari server.',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
    }

    function updateCounts(counts) {
        document.getElementById('belumDibayarCount').textContent = counts.belum_dibayar || 0;
        document.getElementById('menungguKonfirmasiCount').textContent = counts.menunggu_konfirmasi || 0;
        document.getElementById('sedangDiprosesCount').textContent = counts.sedang_diproses || 0;
        document.getElementById('selesaiCount').textContent = counts.selesai || 0;
    }

    function renderOrders() {
        const containerMap = {
            'belum dibayar': 'belumDibayarOrders',
            'menunggu konfirmasi': 'menungguKonfirmasiOrders',
            'pesanan diproses': 'pesananDiprosesOrders',
            'pesanan selesai': 'pesananSelesaiOrders'
        };
        
        Object.keys(containerMap).forEach(status => {
            const container = document.getElementById(containerMap[status]);
            const orders = ordersData[status] || [];
            
            if (orders.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan</h3>
                        <p class="text-sm text-gray-600">Belum ada pesanan dengan status ini</p>
                    </div>
                `;
            } else {
                container.innerHTML = orders.map(order => createOrderCard(order)).join('');
            }
        });
    }

    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab
        document.getElementById(`${tabName}-tab`).classList.remove('hidden');
        
        // Add active class to clicked button
        event.target.classList.remove('border-transparent', 'text-gray-500');
        event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
    }

    function showMobileTab(tabName) {
        showTab(tabName);
    }

    // Order action functions
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

    async function updateOrderStatus(orderId, status, successMessage) {
        try {
            const response = await fetch(`/admin/orders/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status
                })
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonColor: '#10b981'
                }).then(() => {
                    // Refresh data from server
                    refreshOrders();
                });
            } else {
                throw new Error(data.message || 'Something went wrong');
            }
        } catch (error) {
            console.error('Error updating order status:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat mengupdate status pesanan.',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
    }

    function refreshOrders() {
        fetchOrdersData().then(() => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data pesanan telah diperbarui.',
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        // Load initial data
        fetchOrdersData();
        
        // Auto-refresh every 30 seconds
        setInterval(() => {
            fetchOrdersData();
        }, 30000);
    });
    </script>
</body>
</html>