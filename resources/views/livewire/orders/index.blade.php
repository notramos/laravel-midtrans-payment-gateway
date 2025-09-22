<div class="p-4 md:p-0">
    <h2 class="text-xl md:text-2xl font-bold mb-4">Daftar Pesanan Saya</h2>
    
    @if($orders->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-600">Anda belum memiliki pesanan.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
                    @foreach($orders as $order)
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
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($order->status == 'belum dibayar')
                                bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'menunggu konfirmasi')
                                bg-blue-100 text-blue-800
                            @elseif($order->status == 'pesanan diproses')
                                bg-orange-100 text-orange-800
                            @elseif($order->status == 'pesanan selesai')
                                bg-green-100 text-green-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">
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
            @foreach($orders as $order)
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
                        <span class="px-2 py-1 text-xs font-semibold text-center rounded-full
                        @if($order->status == 'belum dibayar')
                        bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'menunggu konfirmasi')
                        bg-blue-100 text-blue-800
                    @elseif($order->status == 'pesanan diproses')
                        bg-orange-100 text-orange-800
                    @elseif($order->status == 'pesanan selesai')
                        bg-green-100 text-green-800
                    @else
                        bg-gray-100 text-gray-800
                    @endif">
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
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>