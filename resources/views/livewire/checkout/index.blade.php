<!-- resources/views/livewire/checkout/index.blade.php -->
<div>
    <h2 class="text-2xl font-bold mb-4">Checkout Pesanan</h2>
      @if($errorMessage)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $errorMessage }}
        </div>
     @endif
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">Informasi Customer</h3>
            
            <form wire:submit.prevent="checkout">
                <div class="mb-4">
                    <label for="shipping_address" class="block font-medium mb-1">Alamat Customer</label>
                    <textarea id="shipping_address" wire:model="shipping_address" class="w-full border rounded p-2" rows="3"></textarea>
                    @error('shipping_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="phone_number" class="block font-medium mb-1">Nomor Telepon</label>
                    <input type="number" id="phone_number" wire:model="phone_number" class="w-full border rounded p-2">
                    @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 cursor-pointer">
                    Lanjutkan ke Pembayaran
                </button>
            </form>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h3>
            
            <div class="space-y-4">
                @foreach($cart->cartItems as $item)
                    <div class="flex justify-between pb-3 border-b">
                        <div>
                            <h4 class="font-medium">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-600">
                                {{ $item->quantity }} pcs/m
                            </p>
                        </div>
                        <div class="font-semibold">
                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
                
                <div class="flex justify-between font-bold text-lg pt-2">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>