<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
    <title>Daftar Pesanan</title>
</head>

<body>
    @include('components.navbar')
    <div class="container mx-auto mt-4 p6" x-data="orderStatusPoller" x-init="init()">
        <h2 class ="text-xl md:text-2xl font-bold
        mb-4">Daftar Pesanan Saya</h2>

        @if ($orders->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-600">Anda belum memiliki pesanan.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Mulai Belanja
                </a>
            </div>
        @else
            <!-- Desktop Table View -->
            <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Pesanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span id="status-{{ $order->id }}"
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($order->status == 'belum dibayar') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'menunggu konfirmasi')
                                bg-blue-100 text-blue-800
                            @elseif($order->status == 'pesanan diproses')
                                bg-orange-100 text-orange-800
                            @elseif($order->status == 'pesanan selesai')
                                bg-green-100 text-green-800
                            @else
                                bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('orders.show', $order) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-lg shadow p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">
                                    {{ $order->order_number }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                            <span id="status-{{ $order->id }}" data-status="{{ $order->status }}"
                                class="status-badge px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-lg font-bold text-gray-900">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('orders.show', $order) }}"
                                class="px-3 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition-colors">
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($orders->hasPages())
                <div class="mt-6 flex justify-between items-center text-sm text-gray-700">
                    <div>
                        Menampilkan
                        <span class="font-semibold">{{ $orders->firstItem() }}</span>
                        sampai
                        <span class="font-semibold">{{ $orders->lastItem() }}</span>
                        dari
                        <span class="font-semibold">{{ $orders->total() }}</span> data
                    </div>

                    <div class="inline-flex rounded-md shadow-sm overflow-hidden border border-gray-200 bg-white">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                            <span class="px-3 py-2 text-gray-400 cursor-not-allowed">&laquo;</span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}"
                                class="px-3 py-2 hover:bg-blue-100 text-blue-600">&laquo;</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span class="px-3 py-2 bg-blue-600 text-white font-semibold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-2 hover:bg-blue-100 text-blue-600">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}"
                                class="px-3 py-2 hover:bg-blue-100 text-blue-600">&raquo;</a>
                        @else
                            <span class="px-3 py-2 text-gray-400 cursor-not-allowed">&raquo;</span>
                        @endif
                    </div>
                </div>
            @endif
        @endif
    </div>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("orderStatusPoller", () => ({
                intervalId: null,

                init() {
                    this.intervalId = setInterval(() => this.fetchStatuses(), 5000); // ✅ arrow function
                },

                fetchStatuses() {
                    fetch("{{ route('orders.status') }}")
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(order => {
                                const badge = document.querySelector(`#status-${order.id}`);
                                if (badge) {
                                    badge.textContent = this.capitalize(order.status);
                                    // optional update warna badge
                                    // badge.className = this.getBadgeClass(order.status);
                                    badge.classList.remove(
                                        'bg-yellow-100', 'text-yellow-800',
                                        'bg-blue-100', 'text-blue-800',
                                        'bg-orange-100', 'text-orange-800',
                                        'bg-green-100', 'text-green-800',
                                        'bg-gray-100', 'text-gray-800'
                                    );
                                    switch (order.status) {
                                        case 'belum dibayar':
                                            badge.classList.add('bg-yellow-100',
                                                'text-yellow-800');
                                            break;
                                        case 'menunggu konfirmasi':
                                            badge.classList.add('bg-blue-100',
                                                'text-blue-800');
                                            break;
                                        case 'pesanan diproses':
                                            badge.classList.add('bg-orange-100',
                                                'text-orange-800');
                                            break;
                                        case 'pesanan selesai':
                                            badge.classList.add('bg-green-100',
                                                'text-green-800');
                                            break;
                                        default:
                                            badge.classList.add('bg-gray-100',
                                                'text-gray-800');
                                    }
                                }
                            });
                        });
                },

                capitalize(str) {
                    return str.charAt(0).toUpperCase() + str.slice(1);
                },
            }));
        });
    </script>
</body>

</html>
