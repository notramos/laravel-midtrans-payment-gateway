<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Katalog Produk</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script
            defer
            src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"
        ></script>
         <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
    </head>
    <body class="bg-gray-100">
        @include('components.navbar')
        <div class="container mx-auto p-6">
            <div class="py-8">
                <h1 class="text-3xl font-bold mb-8">Katalog Produk</h1>     

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    @foreach($products as $product)
                    <div
                        x-data="{
            currentImageIndex: 0,
            totalImages: {{ $product->images->count() }},
            nextImage() {
                if (this.totalImages > 0) {
                    this.currentImageIndex = (this.currentImageIndex + 1) % this.totalImages;
                }
            },
            prevImage() {
                if (this.totalImages > 0) {
                    this.currentImageIndex = (this.currentImageIndex - 1 + this.totalImages) % this.totalImages;
                }
            },
            setImage(index) {
                if (index >= 0 && index < this.totalImages) {
                    this.currentImageIndex = index;
                }
            }
        }"
                        class="product-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
                    >
                        <div class="product-image-carousel relative">
                            @if($product->images->count() > 0)
                            <div
                                class="image-container h-48 overflow-hidden relative"
                            >
                                @foreach($product->images as $index => $image)
                                <img
                                    x-show="currentImageIndex === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    src="{{ asset('storage/'.$image->path) }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover absolute top-0 left-0"
                                />
                                @endforeach @if($product->images->count() > 1)
                                <button
                                    @click="prevImage()"
                                    class="carousel-arrow prev-arrow absolute left-2 top-1/2 -translate-y-1/2 bg-black/30 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/50"
                                >
                                    &larr;
                                </button>
                                <button
                                    @click="nextImage()"
                                    class="carousel-arrow next-arrow absolute right-2 top-1/2 -translate-y-1/2 bg-black/30 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/50"
                                >
                                    &rarr;
                                </button>

                                <div
                                    class="absolute bottom-2 left-0 right-0 flex justify-center gap-1"
                                >
                                    @foreach($product->images as $index =>
                                    $image)
                                    <button
                                        @click="setImage({{ $index }})"
                                        class="w-2 h-2 rounded-full bg-white/50 hover:bg-white/80 transition-colors"
                                        :class="{ 'bg-white': currentImageIndex === {{ $index }} }"
                                    ></button>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @else
                            <div
                                class="h-48 bg-gray-100 flex items-center justify-center text-gray-400"
                            >
                                No images available
                            </div>
                            @endif
                        </div>

                        <div class="product-info p-4">
                            <h3 class="product-name font-semibold text-lg mb-2">
                                {{ $product->name }}
                            </h3>
                            <p
                                class="product-description text-gray-600 text-sm mb-3 line-clamp-2"
                            >
                                {{ $product->description }}
                            </p>
                            <div class="flex justify-between items-center">
                                <div
                                    class="product-price font-bold text-indigo-600"
                                >
                                    Rp {{ number_format($product->price, 0, ',',
                                    '.') }}
                                </div>
                                <a
                                    href="{{ route('products.show', $product) }}"
                                    class="detail-button px-3 py-1 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700 transition-colors"
                                >
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
</html>
