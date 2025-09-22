<div>
    <div class="relative" x-data="{ open: @entangle('showDropdown') }">
    <!-- Tombol Notifikasi -->
    <button 
        wire:click="toggleDropdown"
        @click.outside="open = false"
        class="p-2 rounded-full text-gray-700 hover:text-indigo-600 focus:outline-none"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Notifikasi -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
    >
        <div class="px-4 py-3 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-900">Notifikasi</h3>
        </div>
        
        <div class="max-h-64 overflow-y-auto">
            @forelse($notifications as $notification)
                @php
                    $isNew = !$notification->last_viewed_at || 
                             $notification->last_notified_at > $notification->last_viewed_at;
                @endphp
                
                <a 
                    wire:click="redirectToOrder({{ $notification->id }})"
                    class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 cursor-pointer {{ $isNew ? '' : 'opacity-75' }}"
                >
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 rounded-full mt-2 
                                @if($notification->status === 'menunggu dikonfirmasi') bg-blue-500 
                                @elseif($notification->status === 'pesanan diproses') bg-yellow-500 
                                @else bg-green-500 @endif">
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm text-gray-900">
                                @if($notification->status === 'menunggu konfirmasi')
                                    Pembayaran Diterima - Menunggu Konfirmasi
                                @elseif($notification->status === 'pesanan diproses')
                                    Pesanan Dikonfirmasi - Diproses
                                @else
                                    Pesanan Selesai - Silahkan Ambil di Tempat
                                @endif
                                #{{ $notification->order_number }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if($isNew)
                            <span class="bg-red-500 text-white text-xs rounded-full h-2 w-2 mt-1"></span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="px-4 py-3 text-sm text-gray-500">
                    Tidak ada notifikasi baru
                </div>
            @endforelse
        </div>
    </div>
</div>
</div>
