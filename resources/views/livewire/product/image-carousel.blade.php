<div class="relative">
    @if($product->images->count() > 0)
        <div class="relative">
            <img src="{{ asset('storage/' . $product->images[$currentImageIndex]->path) }}"
                 alt="{{ $product->name }}"
                 class="rounded-lg w-full h-auto">

            <!-- Prev button -->
            <button wire:click="prev"
                    class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white p-2 rounded-full shadow">
                &larr;
            </button>

            <!-- Next button -->
            <button wire:click="next"
                    class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white p-2 rounded-full shadow">
                &rarr;
            </button>
        </div>

        <!-- Indicators -->
        <div class="flex justify-center mt-2 space-x-1">
            @foreach($product->images as $index => $image)
                <button wire:click="setImage({{ $index }})"
                        class="w-3 h-3 rounded-full {{ $currentImageIndex === $index ? 'bg-blue-500' : 'bg-gray-300' }}">
                </button>
            @endforeach
        </div>
    @else
        <div class="bg-gray-200 h-64 flex items-center justify-center rounded">
            <span class="text-gray-500">Tidak ada gambar</span>
        </div>
    @endif
</div>