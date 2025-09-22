<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Form Pemesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
</head>

<body class="bg-gray-100">
    @include('components.navbar')
    <div class="container mx-auto p-6">
        <div class="mb-6">
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Kembali ke katalog
            </a>
        </div>
        @php
            $produkDenganUkuran = ['Spanduk / Baliho', 'Umbul-Umbul', 'Stiker'];
        @endphp
        <div class="bg-white rounded-lg shadow">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Image Carousel -->
                <div x-data="productCarousel({{ $product->images->count() }})">
                    @if ($product->images->count() > 0)
                        <div class="relative">
                            @foreach ($product->images as $index => $image)
                                <div x-show="currentIndex === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="w-full">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}"
                                        class="w-full h-auto rounded-lg" />
                                </div>
                                @endforeach @if ($product->images->count() > 1)
                                    <button @click="prev()"
                                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/30 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/50">
                                        &larr;
                                    </button>
                                    <button @click="next()"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/30 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-black/50">
                                        &rarr;
                                    </button>

                                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
                                        @foreach ($product->images as $index => $image)
                                            <button @click="setIndex({{ $index }})"
                                                class="w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-colors"
                                                :class="{ 'bg-white': currentIndex === {{ $index }} }"></button>
                                        @endforeach
                                    </div>
                                @endif
                        </div>
                    @else
                        <div class="bg-gray-100 h-64 flex items-center justify-center text-gray-500">
                            No images available
                        </div>
                    @endif
                </div>

                <div>
                    <h1 class="text-2xl font-bold mb-2">
                        {{ $product->name }}
                    </h1>
                    <p class="text-gray-600 mb-4">
                        {{ $product->description }}
                    </p>
                    <p class="text-xl font-bold mb-6">

                        Rp {{ number_format($product->price, 0, ',', '.') }}
                        /@if (in_array($product->name, $produkDenganUkuran))
                            Meter
                        @else
                            pcs
                        @endif
                    </p>

                    <!-- Design Guidelines -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-blue-800 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Panduan Desain
                        </h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• File desain harus beresolusi tinggi (minimal 300 DPI)</li>
                            <li>• Format yang disarankan: PNG, JPG, PDF, atau AI</li>
                            <li>• Ukuran file maksimal 10MB</li>
                            <li>• Sertakan catatan detail tentang warna, ukuran, dan posisi</li>
                            <li>• Jika ada teks, pastikan font yang digunakan jelas terbaca</li>
                        </ul>
                    </div>
                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST" x-init="init()"
                        enctype="multipart/form-data" x-data="cartForm()">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />

                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <label for="quantity" class="mb-1 font-medium">Jumlah</label>
                                <input type="number" id="quantity" name="quantity" x-model="quantity" min="1"
                                    class="border rounded p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required />
                            </div>
                            @if (in_array($product->name, $produkDenganUkuran))
                                <div class="flex gap-6">
                                    <div class="flex items-center gap-2">
                                        <input type="number" step="0.1" name="panjang" x-model="panjang"
                                            class="w-28 border rounded p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                        <label for="panjang" class="text-sm font-medium">Panjang (m)</label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="number" step="0.1" name="lebar" x-model="lebar"
                                            class="w-28 border rounded p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required>
                                        <label for="lebar" class="text-sm font-medium">Lebar (m)</label>
                                    </div>
                                </div>
                            @endif
                            <div class="flex flex-col">
                                <label for="design_notes" class="mb-1 font-medium">
                                    Catatan Desain
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea id="design_notes" name="design_notes" x-model="design_notes"
                                    class="border rounded p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    :class="{ 'border-red-300': design_notes.length > 0 && design_notes.length < 20 }" rows="4" required
                                    placeholder="Jelaskan detail desain yang Anda inginkan dengan jelas:
                                            - Ukuran produk yang diinginkan
                                            - Warna yang digunakan
                                            - Posisi desain (depan, belakang, samping)
                                            - Teks yang ingin ditambahkan
                                            - Gaya/tema desain
                                            - Referensi atau inspirasi (jika ada)"></textarea>
                                <div class="flex justify-between items-center mt-1">
                                    <small class="text-gray-500">
                                        Minimal 20 karakter untuk deskripsi yang jelas
                                    </small>
                                    <small class="text-sm"
                                        :class="design_notes.length >= 20 ? 'text-green-600' : 'text-red-500'"
                                        x-text="design_notes.length + '/20'"></small>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <label for="design_file" class="mb-1 font-medium">
                                    Upload Desain
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="file" id="design_file" name="design_file"
                                        class="border rounded p-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        accept="image/*,.pdf,.ai,.eps,.psd" required
                                        @change="handleFileChange($event)" />
                                    <div x-show="fileError" class="text-red-500 text-sm mt-1" x-text="fileError">
                                    </div>
                                    <div x-show="fileName" class="text-green-600 text-sm mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span x-text="fileName"></span>
                                    </div>
                                </div>
                                <small class="text-gray-500 mt-1">
                                    Format yang didukung: JPG, PNG, PDF, AI, EPS, PSD (Maks. 10MB)
                                </small>
                            </div>

                            <!-- File Preview -->
                            <div x-show="filePreview" class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preview File:</label>
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <img x-show="filePreview" :src="filePreview"
                                        class="max-w-full h-32 object-contain mx-auto rounded" alt="Preview desain" />
                                </div>
                            </div>

                            <!-- Validation Messages -->
                            <div x-show="showValidationMessage" class="border rounded-lg p-4"
                                :class="isValid ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-2">
                                        <span x-show="isValid" class="text-green-600">✅</span>
                                        <span x-show="!isValid" class="text-red-600">❌</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium" :class="isValid ? 'text-green-800' : 'text-red-800'"
                                            x-text="isValid ? 'Semua data telah lengkap!' : 'Mohon lengkapi data berikut:'">
                                        </h4>
                                        <ul x-show="!isValid" class="text-sm text-red-700 mt-1 space-y-1">
                                            <li x-show="quantity <= 0">• Jumlah harus lebih dari 0</li>
                                            <li x-show="design_notes.length < 20">• Catatan desain minimal 20 karakter
                                            </li>
                                            <li x-show="!hasValidFile">• File desain harus diupload</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Calculation -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Total Harga:</span>
                                    <span class="text-xl font-bold text-blue-600">
                                        Rp <span x-text="formatPrice(totalPrice())"></span>
                                    </span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full py-3 px-4 rounded-lg font-medium transition-all duration-200 flex items-center justify-center"
                                :class="isValid ? 'bg-blue-500 hover:bg-blue-600 text-white cursor-pointer' :
                                    'bg-gray-300 text-gray-500 cursor-not-allowed'"
                                :disabled="!isValid">
                                <svg x-show="isValid" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5 6m0 0h9M17 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2">
                                    </path>
                                </svg>
                                <svg x-show="!isValid" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 14.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                <span x-show="isValid">Tambahkan ke Keranjang</span>
                                <span x-show="!isValid">Lengkapi Data Terlebih Dahulu</span>
                            </button>

                            <!-- Additional Reminder -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h4 class="font-medium text-yellow-800 mb-2">💡 Tips untuk Hasil Terbaik:</h4>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• Kirim file dengan resolusi tinggi untuk hasil cetak yang tajam</li>
                                    <li>• Berikan catatan yang detail agar tim produksi memahami keinginan Anda</li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function productCarousel(totalImages) {
            return {
                currentIndex: 0,
                next() {
                    this.currentIndex =
                        (this.currentIndex + 1) % totalImages;
                },
                prev() {
                    this.currentIndex =
                        (this.currentIndex - 1 + totalImages) % totalImages;
                },
                setIndex(index) {
                    this.currentIndex = index;
                },
            };
        }

        function cartForm() {
            return {
                quantity: 1,
                panjang: 1,
                lebar: 1,
                design_notes: "",
                fileName: "",
                filePreview: "",
                fileError: "",
                hasValidFile: false,
                basePrice: {{ $product->price }},
                isValid: false,
                showValidationMessage: false,
                isUkuranBased: {{ in_array($product->name, ['Spanduk / Baliho', 'Umbul-Umbul', 'Stiker (Branding)']) ? 'true' : 'false' }},


                handleFileChange(event) {
                    const file = event.target.files[0];
                    this.fileError = "";
                    this.fileName = "";
                    this.filePreview = "";
                    this.hasValidFile = false;

                    if (!file) {
                        this.checkValidity();
                        return;
                    }

                    // Check file size (10MB = 10 * 1024 * 1024 bytes)
                    if (file.size > 10 * 1024 * 1024) {
                        this.fileError = "Ukuran file terlalu besar. Maksimal 10MB.";
                        event.target.value = "";
                        this.checkValidity();
                        return;
                    }

                    // Check file type
                    const allowedTypes = [
                        'image/jpeg', 'image/jpg', 'image/png', 'image/gif',
                        'application/pdf', 'application/postscript', 'image/vnd.adobe.photoshop'
                    ];

                    if (!allowedTypes.includes(file.type) && !file.name.toLowerCase().endsWith('.ai') && !file.name
                        .toLowerCase().endsWith('.eps')) {
                        this.fileError = "Format file tidak didukung. Gunakan JPG, PNG, PDF, AI, EPS, atau PSD.";
                        event.target.value = "";
                        this.checkValidity();
                        return;
                    }

                    this.fileName = file.name;
                    this.hasValidFile = true;

                    // Create preview for images
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.filePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }

                    this.checkValidity();
                },

                checkValidity() {
                    this.isValid =
                        this.quantity > 0 &&
                        this.design_notes.length >= 20 &&
                        this.hasValidFile;

                    // Show validation message after user starts interacting
                    if (this.quantity > 1 || this.design_notes.length > 0 || this.hasValidFile) {
                        this.showValidationMessage = true;
                    }
                },

                totalPrice() {
                    if (this.isUkuranBased) {
                        return this.basePrice * this.quantity * this.panjang * this.lebar;
                    }
                    return this.basePrice * this.quantity;
                },

                formatPrice(price) {
                    return new Intl.NumberFormat("id-ID").format(price);
                },

                init() {
                    // Watch for changes
                    this.$watch('quantity', () => {
                        this.checkValidity();
                    });
                    this.$watch('panjang', () => this.checkValidity());
                    this.$watch('lebar', () => this.checkValidity());
                    this.$watch('design_notes', () => {
                        this.checkValidity();
                    });
                    this.$watch('hasValidFile', () => {
                        this.checkValidity();
                    });

                    // Jalankan pengecekan awal
                    this.checkValidity();
                },
            };
        }
    </script>
</body>

</html>
