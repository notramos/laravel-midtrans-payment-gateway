<div>
    <div class="mb-6">
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Kembali ke katalog
        </a>
    </div>
         
    <div class="bg-white rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
           <livewire:product.image-carousel :product="$product" />
                         
            <div>
                <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                <p class="text-xl font-bold mb-6">Rp {{ number_format($product->price, 0, ',', '.') }} / pcs</p>
                <livewire:cart.add :product="$product" />
            </div>
        </div>
    </div>
</div>