<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin Penjualan Spanduk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar {
            width: 250px;
            height: calc(100vh - 64px);
            transition: all 0.3s ease;
        }
        .content {
            width: calc(100% - 250px);
            transition: all 0.3s ease;
            margin-left: 250px;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .content.expanded {
            width: calc(100% - 70px);
            margin-left: 70px;
        }
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .card-stats {
            transition: all 0.3s;
        }
        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .dark-blue {
            background-color: #1e3a8a;
        }
        .navy-blue {
            background-color: #172554;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full z-10">
        <div class="flex justify-between items-center px-6 h-16">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="mr-4 text-gray-600 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-xl font-bold text-blue-900">Admin</h1>
            </div>
            <div class="flex items-center">
                {{-- <div class="relative mr-4">
                    <input type="text" placeholder="Cari..." class="bg-gray-100 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-500"></i>
                </div> --}}
            <div class="relative mr-4" id="notification-container">
                <button id="notification-button" class="relative focus:outline-none">
                    <i class="fas fa-bell text-gray-600 text-2xl"></i>
                    <span id="notification-count" class="absolute -top-2 -right-2 bg-red-600 rounded-full w-5 h-5 text-xs text-white flex items-center justify-center hidden">0</span>
                </button>

                <div id="notification-dropdown" class="absolute right-0 mt-3 w-96 bg-white border border-gray-200 rounded-lg shadow-xl hidden z-50">
                    <div class="p-4 border-b font-semibold text-lg text-gray-700">Notifikasi Pesanan</div>
                    <ul id="notification-list" class="max-h-80 overflow-y-auto divide-y divide-gray-200"></ul>
                    <div id="no-notif" class="p-4 text-gray-500 text-sm hidden">Belum ada pesanan baru.</div>
                </div>
            </div>
                {{-- <div class="flex items-center">
                    <img src="/api/placeholder/40/40" alt="Admin" class="w-8 h-8 rounded-full mr-2">
                    <span class="text-gray-700 font-medium">Admin Utama</span>
                    <button class="ml-2 focus:outline-none">
                        <i class="fas fa-chevron-down text-gray-600 text-sm"></i>
                    </button>
                </div> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded transition cursor-pointer">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar navy-blue text-white overflow-y-auto fixed h-full">
            <div class="py-4">
                <div class="px-6 py-3">
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('storage/images/logo_CV.png') }}" alt="Logo" class="w-10 h-10 rounded-lg mr-3">
                        <span class="text-lg font-semibold sidebar-text">CV.AXEL DIGITAL CREATIVE</span>
                    </div>
                </div>
                <div class="space-y-1">
                    <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white bg-blue-900 border-l-4 border-blue-400">
                        <i class="fas fa-th-large w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.orders') }}" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-shopping-cart w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Pesanan</span>
                    </a>
                    {{-- <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-boxes w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Produk</span>
                    </a> --}}
                    {{-- <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Pelanggan</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-truck w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Pengiriman</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-chart-pie w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Laporan</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-credit-card w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Pembayaran</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-tag w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Diskon & Promo</span>
                    </a>
                    <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span class="ml-3 sidebar-text">Pengaturan</span>
                    </a> --}}
                </div>
            </div>
            <div class="absolute bottom-0 w-full">
                <a href="#" class="sidebar-link flex items-center px-6 py-3 text-gray-300 hover:text-white">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i>
                    <span class="ml-3 sidebar-text">Keluar</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div id="content" class="content px-6 py-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Dashboard Penjualan</h2>
                <p class="text-gray-600">Selamat datang kembali! Berikut adalah ringkasan penjualan terbaru</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card-stats bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg">Total Pesanan</h3>
                        <i class="fas fa-shopping-bag text-white text-opacity-80 text-2xl"></i>
                    </div>
                    <p id="total-orders" class="text-3xl font-bold mb-1">...</p>
                    <p class="text-sm flex items-center" id="order-percentage">
                        <i class="fas fa-arrow-up mr-1 text-white opacity-75"></i>
                        <span>+0% dari bulan lalu</span>
                    </p>
                    {{-- <p id="total-orders" class="text-3xl font-bold mb-1">...</p>
                    <p class="text-sm flex items-center">
                        <i class="fas fa-sync-alt animate-spin mr-1" id="order-refresh-icon"></i>
                        <span>Memuat data...</span>
                    </p> --}}
                </div>
                <div class="card-stats bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg">Pendapatan</h3>
                        <i class="fas fa-money-bill-wave text-white text-opacity-80 text-2xl"></i>
                    </div>
                    <p id="revenue-amount" class="text-3xl font-bold mb-1">Rp 0</p>
                    <p class="text-sm flex items-center" id="revenue-percentage">
                        <i class="fas fa-arrow-up mr-1 text-white opacity-75"></i>
                        <span>0% dari bulan lalu</span>
                    </p>
                </div>
                <div class="card-stats bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg">Pesanan Baru</h3>
                        <i class="fas fa-clipboard-list text-white text-opacity-80 text-2xl"></i>
                    </div>
                    <p id="new-orders-count" class="text-3xl font-bold mb-1">0</p>
                    <p class="text-sm flex items-center" id="new-orders-percentage">
                        <i class="fas fa-arrow-up mr-1 text-white opacity-75"></i>
                        <span>0% dari minggu lalu</span>
                    </p>
                </div>
               <div class="card-stats bg-gradient-to-r from-red-500 to-red-600 rounded-lg shadow-md p-6 text-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-lg">Pelanggan Baru</h3>
                        <i class="fas fa-user-plus text-white text-opacity-80 text-2xl"></i>
                    </div>
                    <p id="new-customers-count" class="text-3xl font-bold mb-1">0</p>
                    <p class="text-sm flex items-center" id="new-customers-percentage">
                        <i class="fas fa-arrow-up mr-1 text-white opacity-75"></i>
                        <span>0% dari bulan lalu</span>
                    </p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
               <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-semibold text-lg text-gray-800">Tren Penjualan</h3>
                        <div class="flex items-center">
                            <select id="sales-range" class="bg-gray-100 text-gray-700 py-1 px-3 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="30">30 Hari Terakhir</option>
                                <option value="90">3 Bulan Terakhir</option>
                                <option value="180">6 Bulan Terakhir</option>
                                <option value="365">1 Tahun Terakhir</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="salesChart" class="w-full h-full"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-semibold text-lg text-gray-800">Produk Terpopuler</h3>
                        <div class="flex items-center">
                            <select id="product-range" class="bg-gray-100 text-gray-700 py-1 px-3 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="30">Bulan Ini</option>
                                <option value="90">3 Bulan Terakhir</option>
                                <option value="180">6 Bulan Terakhir</option>
                                <option value="365">1 Tahun Terakhir</option>
                            </select>
                        </div>
                    </div>
                    <div class="h-64">
                        <canvas id="productChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            {{-- <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="font-semibold text-lg text-gray-800">Pesanan Terbaru</h3>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                     <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="order-table-body" class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td colspan="7" class="text-center py-4">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Menampilkan 5 dari 123 entri
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 disabled:opacity-50">
                            Sebelumnya
                        </button>
                        <button class="px-3 py-1 rounded border border-gray-300 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            1
                        </button>
                        <button class="px-3 py-1 rounded border border-gray-300 text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Berikutnya
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</body>
<script>
      function fetchOrderStats() {
        fetch('{{ route('dashboard.stats') }}')
            .then(response => response.json())
            .then(data => {
                const totalOrders = data.total_orders;
                const percentageChange = data.percentage_change;

                document.getElementById('total-orders').innerText = totalOrders.toLocaleString();

                const percentageElement = document.getElementById('order-percentage');
                const icon = percentageElement.querySelector('i');
                const text = percentageElement.querySelector('span');

                let arrow = 'fa-arrow-up';
                let textColor = 'text-green-300';
                let sign = '+';

                if (percentageChange < 0) {
                    arrow = 'fa-arrow-down';
                    textColor = 'text-red-300';
                    sign = '';
                }

                icon.className = `fas ${arrow} mr-1 ${textColor}`;
                text.innerText = `${sign}${percentageChange}% dari bulan lalu`;
            })
            .catch(error => {
                console.error('Gagal memuat statistik pesanan:', error);
            });
    }

    setInterval(fetchOrderStats, 10000);
    fetchOrderStats();
     function fetchRevenueStats() {
        fetch('{{ route('dashboard.revenue') }}')
            .then(response => response.json())
            .then(data => {
                const revenueAmount = data.revenue;
                const percentageChange = data.percentage_change;

                document.getElementById('revenue-amount').innerText = 'Rp ' + revenueAmount.toLocaleString('id-ID');

                const percentageElement = document.getElementById('revenue-percentage');
                const icon = percentageElement.querySelector('i');
                const text = percentageElement.querySelector('span');

                let arrow = 'fa-arrow-up';
                let textColor = 'text-green-300';
                let sign = '+';

                if (percentageChange < 0) {
                    arrow = 'fa-arrow-down';
                    textColor = 'text-red-300';
                    sign = '';
                }

                icon.className = `fas ${arrow} mr-1 ${textColor}`;
                text.innerText = `${sign}${percentageChange}% dari bulan lalu`;
            })
            .catch(error => {
                console.error('Gagal memuat statistik pendapatan:', error);
            });
    }

    // Panggil setiap 10 detik
    setInterval(fetchRevenueStats, 10000);
    fetchRevenueStats();
     function fetchNewOrders() {
        fetch('{{ route('dashboard.newOrders') }}')
            .then(res => res.json())
            .then(data => {
                const count = data.new_orders;
                const change = data.percentage_change;

                document.getElementById('new-orders-count').innerText = count.toLocaleString('id-ID');

                const icon = document.querySelector('#new-orders-percentage i');
                const text = document.querySelector('#new-orders-percentage span');

                let arrow = 'fa-arrow-up';
                let color = 'text-green-300';
                let sign = '+';

                if (change < 0) {
                    arrow = 'fa-arrow-down';
                    color = 'text-red-300';
                    sign = '';
                }

                icon.className = `fas ${arrow} mr-1 ${color}`;
                text.innerText = `${sign}${change}% dari minggu lalu`;
            });
    }

    function fetchNewCustomers() {
        fetch('{{ route('dashboard.newCustomers') }}')
            .then(res => res.json())
            .then(data => {
                const count = data.new_customers;
                const change = data.percentage_change;

                document.getElementById('new-customers-count').innerText = count.toLocaleString('id-ID');

                const icon = document.querySelector('#new-customers-percentage i');
                const text = document.querySelector('#new-customers-percentage span');

                let arrow = 'fa-arrow-up';
                let color = 'text-green-300';
                let sign = '+';

                if (change < 0) {
                    arrow = 'fa-arrow-down';
                    color = 'text-red-300';
                    sign = '';
                }

                icon.className = `fas ${arrow} mr-1 ${color}`;
                text.innerText = `${sign}${change}% dari bulan lalu`;
            });
    }

    // Auto fetch every 10s
    setInterval(() => {
        fetchNewOrders();
        fetchNewCustomers();
    }, 10000);

    // Initial load
    fetchNewOrders();
    fetchNewCustomers();


    let salesChart;
    const ctx = document.getElementById('salesChart').getContext('2d');

    function renderChart(labels, data) {
        if (salesChart) {
            salesChart.destroy();
        }

        salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan',
                    data: data,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    function fetchChartData(days = 30) {
        fetch(`{{ route('dashboard.sales.chart') }}?days=${days}`)
            .then(res => res.json())
            .then(data => {
                renderChart(data.labels, data.data);
            });
    }

    document.getElementById('sales-range').addEventListener('change', function () {
        fetchChartData(this.value);
    });

    // Initial load
    fetchChartData();

    let productChart;
    const ctxProduct = document.getElementById('productChart').getContext('2d');

    function renderProductChart(labels, data) {
        if (productChart) {
            productChart.destroy();
        }

        productChart = new Chart(ctxProduct, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Terjual',
                    data: data,
                    backgroundColor: '#3b82f6', // biru
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    function fetchPopularProducts(days = 30) {
        fetch(`{{ route('dashboard.popularProducts') }}?days=${days}`)
            .then(res => res.json())
            .then(data => {
                renderProductChart(data.labels, data.data);
            });
    }

    document.getElementById('product-range').addEventListener('change', function () {
        fetchPopularProducts(this.value);
    });

    // Load awal saat halaman pertama kali dibuka
    fetchPopularProducts();

   function loadOrders() {
    fetch('/dashboard/orders/data')
        .then(res => res.json())
        .then(res => {
            const tbody = document.getElementById('order-table-body');
            tbody.innerHTML = '';

            if (res.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-gray-500">Tidak ada pesanan</td></tr>`;
                return;
            }

            res.data.forEach(order => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 text-sm text-gray-900">${order.order_number}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(order.customer_name)}" class="w-8 h-8 rounded-full mr-2" />
                            <div>
                                <div class="text-sm font-medium">${order.customer_name}</div>
                                <div class="text-sm text-gray-500">${order.customer_email}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <ul class="list-disc ml-4">
                            ${order.product_list.map(p => `<p>${p}</p>`).join('')}
                        </ul>
                    </td>
                    <td class="px-6 py-4 text-sm">${order.date}</td>
                    <td class="px-6 py-4 text-sm">Rp ${order.total}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${order.status_class}">${order.status}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <button class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></button>
                    </td>`;
                tbody.appendChild(row);
            });
        });

    setTimeout(loadOrders, 10000); // Refresh tiap 10 detik
}
document.addEventListener('DOMContentLoaded', loadOrders);

document.addEventListener('DOMContentLoaded', () => {
    const button = document.getElementById('notification-button');
    const dropdown = document.getElementById('notification-dropdown');
    const list = document.getElementById('notification-list');
    const countBadge = document.getElementById('notification-count');
    const noNotif = document.getElementById('no-notif');

    button.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });
     // Tutup dropdown jika klik di luar dropdown
    document.addEventListener('click', (e) => {
        const target = e.target;
        if (!dropdown.contains(target) && !button.contains(target)) {
            dropdown.classList.add('hidden');
        }
    });

    function fetchNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                console.log(data)
                list.innerHTML = '';
                if (data.length > 0) {
                    countBadge.textContent = data.length;
                    countBadge.classList.remove('hidden');
                    noNotif.classList.add('hidden');

                    data.forEach(order => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <a href="/admin/orders/${order.id}" class="block px-4 py-3 hover:bg-gray-100 transition" data-order-id="${order.id}">
                            <div class="text-sm font-semibold text-gray-800">#${order.order_number}</div>
                            <div class="text-xs text-gray-500">Total: Rp${order.total_amount.toLocaleString()}</div>
                            <div class="text-xs text-gray-400 truncate">Alamat: ${order.shipping_address}</div>
                            <div class="text-xs text-gray-400">HP: ${order.phone_number}</div>
                        </a>
                    `;
                    list.appendChild(li);

                    // Tambahkan event listener untuk tandai dibaca
                    li.querySelector('a').addEventListener('click', (e) => {
                        e.preventDefault();
                        const orderId = e.currentTarget.getAttribute('data-order-id');
                        
                        // Tandai sebagai dibaca, lalu redirect
                        fetch(`/notifications/read/${orderId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            }
                        }).then(() => {
                            window.location.href = `/admin/orders/${orderId}`;
                        });
                    });
                });
                } else {
                    countBadge.classList.add('hidden');
                    noNotif.classList.remove('hidden');
                }
            });
    }

    // Fetch awal + polling 5 detik
    fetchNotifications();
    setInterval(fetchNotifications, 5000);
});
</script>  
