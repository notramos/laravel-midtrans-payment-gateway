<!-- resources/views/livewire/cart/add.blade.php -->
<form wire:submit.prevent="addToCart">
    <div class="space-y-4">
        <div class="flex flex-col">
            <label for="quantity" class="mb-1 font-medium">Jumlah</label>
            <input type="number" id="quantity" wire:model.live="quantity" min="1" class="border rounded p-2">
            @error('quantity')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="design_notes" class="mb-1 font-medium">
                Catatan Desain <span class="text-red-500">*</span>
            </label>
            <textarea id="design_notes" wire:model.live="design_notes"
                class="border rounded p-2 {{ $errors->has('design_notes') ? 'border-red-500' : '' }}" rows="3"
                placeholder="Jelaskan detail desain yang Anda inginkan..."></textarea>
            @error('design_notes')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            @if (!$design_notes)
                <span class="text-orange-500 text-sm mt-1">
                    ⚠️ Catatan desain diperlukan untuk memproses pesanan Anda
                </span>
            @endif
        </div>

        <div class="flex flex-col">
            <label for="design_file" class="mb-1 font-medium">
                Upload Desain <span class="text-red-500">*</span>
            </label>
            <input type="file" id="design_file" wire:model.live="design_file"
                class="border rounded p-2 {{ $errors->has('design_file') ? 'border-red-500' : '' }}"
                accept="image/*,.pdf">
            @error('design_file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <div wire:loading wire:target="design_file" class="mt-2 text-sm text-blue-600">
                <div class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Mengunggah file...
                </div>
            </div>

            @if (!$design_file)
                <span class="text-orange-500 text-sm mt-1">
                    ⚠️ File desain diperlukan untuk memproses pesanan Anda
                </span>
            @endif

            <small class="text-gray-500 mt-1">
                Format yang didukung: JPG, PNG, PDF (Maks. 10MB)
            </small>
        </div>

        <!-- Peringatan jika belum lengkap -->
        @if (!$isValid)
            <div class="bg-yellow-50 border border-yellow-200 rounded p-3">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-2 text-yellow-600">
                        ⚠️
                    </div>
                    <div>
                        <h4 class="text-yellow-800 font-medium">Mohon lengkapi data berikut:</h4>
                        <ul class="text-yellow-700 text-sm mt-1 space-y-1">
                            @if (!$quantity || $quantity < 1)
                                <li>• Masukkan jumlah yang valid</li>
                            @endif
                            @if (!$design_notes || strlen(trim($design_notes)) < 10)
                                <li>• Isi catatan desain minimal 10 karakter</li>
                            @endif
                            @if (!$design_file)
                                <li>• Upload file desain</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (is_numeric($product->price) && is_numeric($quantity))
            <p class="font-medium">
                Total Harga: Rp {{ number_format($product->price * intval($quantity), 0, ',', '.') }}
            </p>
        @else
            <p class="text-red-500 text-sm">Harap masukkan jumlah yang valid untuk menghitung total harga.</p>
        @endif

        <button type="submit"
            class="w-full text-white py-2 px-4 rounded transition duration-200
                {{ $isValid && !$errors->any() ? 'bg-blue-500 hover:bg-blue-600 cursor-pointer' : 'bg-gray-400 cursor-not-allowed' }}"
            {{ !$isValid || $errors->any() ? 'disabled' : '' }} wire:loading.attr="disabled" wire:target="addToCart">
            <span wire:loading.remove wire:target="addToCart">
                {{ $isValid ? 'Tambahkan ke Keranjang' : 'Lengkapi Data Terlebih Dahulu' }}
            </span>
            <span wire:loading wire:target="addToCart" class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Memproses...
            </span>
        </button>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>
</form>
