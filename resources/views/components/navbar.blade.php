<nav class="bg-white shadow-md" x-data="{ isMenuOpen: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <a href="{{ route('products.index') }}" class="text-xl sm:text-2xl font-bold text-indigo-600">
                    CV. AXEL DIGITAL CREATIVE
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}"
                        class="text-gray-700 hover:text-indigo-600 transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 sm:mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="hidden lg:inline">Lihat Keranjang Saya</span>
                        <span class="lg:hidden">Keranjang</span>
                    </a>

                    <a href="{{ route('orders.index') }}"
                        class="text-gray-700 hover:text-indigo-600 transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 sm:mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span class="hidden lg:inline">Lihat Pesanan Saya</span>
                        <span class="lg:hidden">Pesanan</span>
                    </a>

                    <!-- Tombol Notifikasi -->
                    {{-- <livewire:notification-bell /> --}}
                </div>

                <!-- User Info & Logout -->
                <div class="flex items-center space-x-4 border-l border-gray-200 pl-4">
                    <div class="text-gray-800 font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 sm:mr-2 text-gray-600"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="hidden xl:inline">{{ auth()->user()->name }}</span>
                        <span class="xl:hidden">{{ Str::limit(auth()->user()->name, 10) }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 cursor-pointer text-white py-2 px-3 lg:px-4 rounded transition duration-200">
                            <span class="hidden sm:inline">Logout</span>
                            <svg class="sm:hidden h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="isMenuOpen = !isMenuOpen"
                    class="text-gray-700 hover:text-indigo-600 focus:outline-none focus:text-indigo-600 transition duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="isMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div class="md:hidden" x-show="isMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2">

            <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200 bg-gray-50">
                <!-- User Info -->
                <div class="flex items-center px-3 py-2 text-gray-800 font-medium bg-white rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ auth()->user()->name }}
                </div>

                <!-- Mobile Navigation Links -->
                <a href="{{ route('cart.index') }}"
                    class="flex items-center px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-white rounded-md transition duration-200"
                    @click="isMenuOpen = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Lihat Keranjang Saya
                </a>

                <a href="{{ route('orders.index') }}"
                    class="flex items-center px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-white rounded-md transition duration-200"
                    @click="isMenuOpen = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Lihat Pesanan Saya
                </a>

                <!-- Mobile Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-3 py-2 text-left text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
