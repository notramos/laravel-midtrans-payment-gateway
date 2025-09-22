<div>
    <div class="product-card">
    <div class="product-image-carousel">
        @php $totalImages = $product->images->count(); @endphp

        @if($totalImages > 0)
            <div class="image-container">
                <img src="{{ asset('storage/'.$product->images[$currentImageIndex]->path) }}" 
                     alt="{{ $product->name }}" 
                     class="product-image">
                @if($totalImages > 1)
                    <button wire:click="previousImage" class="carousel-arrow prev-arrow">⟨</button>
                    <button wire:click="nextImage" class="carousel-arrow next-arrow">⟩</button>

                    <div class="carousel-indicators">
                        @foreach($product->images as $index => $image)
                            <button wire:click="setImage({{ $index }})"
                                    class="{{ $currentImageIndex === $index ? 'active' : '' }}">
                            </button>
                        @endforeach
                    </div>
                    <div class="image-counter">
                        {{ $currentImageIndex + 1 }} / {{ $totalImages }}
                    </div>
                @endif
            </div>
        @else
            <div class="no-image">No images available</div>
        @endif
    </div>
  <div class="product-info">
            <h3 class="product-name">{{ $product->name }}</h3>
            <p class="product-description">{{ $product->description }}</p>
            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <a href="{{ route('products.show', $product) }}" class="detail-button">
                Lihat Detail
            </a>
        </div>
    </div>
</div>
