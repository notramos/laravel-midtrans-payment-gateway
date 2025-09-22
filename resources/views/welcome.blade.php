<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo_CV.png') }}">
    <title>CV. AXEL DIGITAL CREATIVE - Percetakan Berkualitas Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/home.css', 'resources/js/app.js'])
    @endif
</head>

<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <!-- Fixed logo with placeholder image -->
                    <img src="{{ asset('storage/images/logo_CV.png') }}" alt="CV Axel Digital Creative"
                        class="logo-img">
                </div>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#produk">Produk</a></li>
                    <li><a href="#cara-kerja">Cara Kerja</a></li>
                    <li><a href="#testimonial">Testimonial</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
                <div class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <a href="{{ route('login') }}" class="btn">Pesan Sekarang</a>
            </nav>
        </div>
    </header>

    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1><span class="highlight">Digital Printing & Advertising </span></h1>
                    <p>CV. AXEL DIGITAL CREATIVE menghadirkan solusi percetakan terdepan dengan teknologi digital
                        terbaru, kualitas premium, dan layanan yang dapat diandalkan untuk kesuksesan bisnis Anda.</p>
                    <div class="hero-buttons">
                        <a href="#pesan" class="btn-primary">Konsultasi Gratis</a>
                        <a href="#produk" class="btn-secondary">Lihat Produk</a>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="hero-card">
                        <h3>🎨 Desain Profesional</h3>
                        <p>Tim desainer berpengalaman siap mewujudkan visi kreatif Anda</p>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <div class="stat-number">50+</div>
                                <div class="stat-label">Proyek Selesai</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">24H</div>
                                <div class="stat-label">Pengerjaan Cepat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Memilih AXEL Creative?</h2>
                <p>Keunggulan layanan percetakan yang akan membuat bisnis Anda tampil lebih profesional dan menarik</p>
            </div>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3>Kualitas Premium</h3>
                    <p>Menggunakan material berkualitas tinggi dan teknologi cetak terdepan untuk hasil yang tajam,
                        tahan lama, dan memukau.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Pengerjaan Express</h3>
                    <p>Layanan cetak kilat 24 jam untuk kebutuhan mendesak dengan kualitas yang tetap terjaga sempurna.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💎</div>
                    <h3>Harga Kompetitif</h3>
                    <p>Paket harga transparan dengan value terbaik di kelasnya, tanpa biaya tersembunyi dan garansi
                        kepuasan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h3>Desain Eksklusif</h3>
                    <p>Tim desainer profesional siap membantu mewujudkan konsep kreatif Anda menjadi karya visual yang
                        menawan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🚚</div>
                    <h3>Pengiriman Terpercaya</h3>
                    <p>Jaringan pengiriman ke seluruh Indonesia dengan kemasan aman dan tracking real-time untuk
                        ketenangan pikiran.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3>Layanan 24/7</h3>
                    <p>Tim customer service responsif siap membantu kapan saja untuk memberikan pengalaman terbaik bagi
                        Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works" id="cara-kerja">
        <div class="container">
            <div class="section-title">
                <h2>Proses Pemesanan Mudah</h2>
                <p>Hanya 4 langkah sederhana untuk mendapatkan produk percetakan berkualitas premium</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Pilih Produk</h3>
                    <p>Tentukan jenis produk, ukuran, bahan, dan finishing sesuai kebutuhan spesifik Anda.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Upload Desain</h3>
                    <p>Upload desain Anda untuk hasil optimal.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Konfirmasi & Bayar</h3>
                    <p>Review final desain, konfirmasi pesanan, dan lakukan pembayaran dengan mudah.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Terima Pesanan</h3>
                    <p>Produk berkualitas premium siap dikirim ke alamat Anda dengan packaging aman.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="products" id="produk">
        <div class="container">
            <div class="section-title">
                <h2>Produk Unggulan Kami</h2>
                <p>Rangkaian lengkap produk percetakan berkualitas premium untuk semua kebutuhan bisnis dan personal</p>
            </div>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">🎯</div>
                    <div class="product-info">
                        <h3>Spanduk/Baliho</h3>
                        <p>Spanduk outdoor berkualitas tinggi dengan bahan vinyl tahan cuaca dan warna yang tidak mudah
                            pudar.</p>
                        <div class="price">Mulai Rp 25.000/m</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">🏢</div>
                    <div class="product-info">
                        <h3>Papan Bunga Jumbo</h3>
                        <p>Solusi perfect untuk promosi indoor dengan kualitas cetak HD dan material premium.</p>
                        <div class="price">Rp 250.000</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">📊</div>
                    <div class="product-info">
                        <h3>Papan Bunga Standart</h3>
                        <p>Display portable profesional dengan stand berkualitas tinggi, ideal untuk event dan pameran.
                        </p>
                        <div class="price">Rp 150.000</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">🎪</div>
                    <div class="product-info">
                        <h3>X-Banner + Rangka</h3>
                        <p>Backdrop custom untuk berbagai acara dengan desain eksklusif dan instalasi profesional.</p>
                        <div class="price">Rp 175.000</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">🏪</div>
                    <div class="product-info">
                        <h3>Umbul - umbul</h3>
                        <p>Signage premium dengan lampu LED untuk tampilan yang menarik di malam hari.</p>
                        <div class="price">Rp 75.000/m²</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">📋</div>
                    <div class="product-info">
                        <h3>Sticker (Branding)</h3>
                        <p>Sticker custom dengan berbagai ukuran dan finishing untuk branding yang efektif.</p>
                        <div class="price">Rp 100.000/m</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials" id="testimonial">
        <div class="container">
            <div class="section-title">
                <h2>Testimoni Pelanggan</h2>
                <p>Kepercayaan dan kepuasan pelanggan adalah prioritas utama kami</p>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        "Kualitas cetak luar biasa! Warna spanduk sangat tajam dan tahan lama. Tim AXEL Creative sangat
                        profesional dan responsif. Sudah 3 kali order dan selalu puas dengan hasilnya."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">BS</div>
                        <div class="author-info">
                            <h4>Budi Santoso</h4>
                            <p>Owner Toko Elektronik Maju</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        "Pengalaman terbaik untuk cetak backdrop event! Desain yang dibuat tim sangat kreatif dan sesuai
                        dengan konsep acara. Pengerjaan cepat dan hasil memuaskan. Highly recommended!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">SN</div>
                        <div class="author-info">
                            <h4>Siti Nurhaliza</h4>
                            <p>Event Organizer Profesional</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        "Pelayanan 24/7 benar-benar membantu! Saat butuh banner dadakan untuk acara kampus, tim AXEL
                        Creative langsung siap bantu. Kualitas premium dengan harga yang sangat reasonable."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">RM</div>
                        <div class="author-info">
                            <h4>Reza Mahendra</h4>
                            <p>Ketua BEM Universitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta" id="pesan">
        <div class="container">
            <div class="cta-content">
                <h2>Siap Wujudkan Proyek Impian Anda?</h2>
                <p>Bergabunglah dengan ribuan pelanggan yang telah mempercayakan kebutuhan percetakan mereka kepada
                    kami. Dapatkan konsultasi gratis dan penawaran khusus hari ini!</p>
                <a href="#" class="btn-cta">Pesan Sekarang</a>
            </div>
        </div>
    </section>

    <footer id="kontak">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>CV. AXEL DIGITAL CREATIVE</h3>
                    <p>Partner terpercaya untuk solusi percetakan berkualitas premium. Kami berkomitmen memberikan
                        layanan terbaik untuk kesuksesan bisnis Anda dengan teknologi terdepan dan tim profesional.</p>
                </div>
                <div class="footer-column">
                    <h3>Produk Unggulan</h3>
                    <ul class="footer-links">
                        <li><a href="#">Spanduk/Baliho</a></li>
                        <li><a href="#">Papan Bunga Jumbo</a></li>
                        <li><a href="#">Papan Bunga Standart</a></li>
                        <li><a href="#">X-Banner + Rangka</a></li>
                        <li><a href="#">Umbul - Umbul</a></li>
                        <li><a href="#">Stiker ( Branding )</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Layanan</h3>
                    <ul class="footer-links">
                        <li><a href="#">Konsultasi Desain</a></li>
                        <li><a href="#">Cetak Express 24 Jam</a></li>
                        <li><a href="#">Instalasi Profesional</a></li>
                        <li><a href="#">Garansi Kualitas</a></li>
                        <li><a href="#">Pengiriman Nasional</a></li>
                        <li><a href="#">After Sales Service</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Hubungi Kami</h3>
                    <ul class="footer-links">
                        <li>📧 axel_advertising@yahoo.com</li>
                        <li>📱 WhatsApp: +62 822-7384-2714</li>
                        <li>☎️ Telepon: 0274-123456</li>
                        <li>📍 Perumahan Taman Griya Blok. Mawar 06 Lubuk Tukko, Pandan
                            Kab. Tapanuli Tengah</li>
                        <li>🕒 Buka 24/7 (Online)</li>
                        <li>🏪 Senin-Sabtu: 08:00-20:00</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 CV. AXEL DIGITAL CREATIVE. Semua Hak Dilindungi. | Solusi Percetakan Terpercaya</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header background on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.backdropFilter = 'blur(20px)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.backdropFilter = 'blur(20px)';
            }
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Apply animation to cards
        document.querySelectorAll('.feature-card, .product-card, .testimonial-card, .step').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Counter animation for stats
        function animateCounter(element, target) {
            let count = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    element.textContent = target + (element.textContent.includes('+') ? '+' : '');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(count) + (element.textContent.includes('+') ? '+' : '');
                }
            }, 20);
        }

        // Animate stats when in view
        const statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const numberElement = entry.target.querySelector('.stat-number');
                    const text = numberElement.textContent;
                    const number = parseInt(text.replace(/\D/g, ''));
                    animateCounter(numberElement, number);
                    statsObserver.unobserve(entry.target);
                }
            });
        });

        document.querySelectorAll('.stat-item').forEach(stat => {
            statsObserver.observe(stat);
        });
    </script>
</body>
{{-- <body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">CV.<span>AXEL DIGITAL CREATIVE</span></div>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#produk">Produk</a></li>
                    <li><a href="#cara-kerja">Cara Kerja</a></li>
                    <li><a href="#testimonial">Testimonial</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
                <a href="#pesan" class="btn">Pesan Sekarang</a>
            </nav>
        </div>
    </header>

    <section class="hero" id="beranda">
        <div class="container">
            <div class="hero-content">
                <h1>CV. AXEL DIGITAL CREATIVE <span>Berkualitas</span> dengan Cepat dan Mudah</h1>
                <p>CV. AXEL DIGITAL CREATIVE menyediakan layanan cetak spanduk online terbaik dengan harga terjangkau, bahan berkualitas, dan pengiriman cepat ke seluruh Indonesia.</p>
                <a href="#pesan" class="btn">Mulai Desain Sekarang</a>
            </div>
            <div class="hero-image">
                <img src="/api/placeholder/500/400" alt="Contoh Spanduk Berkualitas">
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Mengapa Memilih Kami?</h2>
                <p>Keunggulan layanan SpandukPro yang tidak akan Anda temukan di tempat lain</p>
            </div>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">★</div>
                    <h3>Kualitas Premium</h3>
                    <p>Menggunakan bahan vinyl berkualitas tinggi dengan ketahanan warna dan cuaca yang tahan lama.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Pengerjaan Cepat</h3>
                    <p>Proses cetak selesai dalam 1-2 hari kerja dan siap kirim ke seluruh Indonesia.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Harga Bersaing</h3>
                    <p>Harga transparan tanpa biaya tersembunyi dengan penawaran spesial untuk pemesanan dalam jumlah besar.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💻</div>
                    <h3>Desain Online</h3>
                    <p>Buat desain spanduk sendiri dengan editor online yang mudah digunakan atau upload file desain Anda.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📦</div>
                    <h3>Pengiriman Aman</h3>
                    <p>Dikemas dengan aman dan dikirim melalui kurir terpercaya ke seluruh Indonesia.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛠️</div>
                    <h3>Layanan Pelanggan</h3>
                    <p>Tim dukungan pelanggan siap membantu Anda 24/7 untuk semua pertanyaan dan kendala.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works" id="cara-kerja">
        <div class="container">
            <div class="section-title">
                <h2>Cara Pemesanan</h2>
                <p>Proses pemesanan spanduk yang mudah dan cepat</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Pilih Produk</h3>
                    <p>Pilih jenis spanduk, ukuran, dan finishing yang Anda inginkan.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Buat Desain</h3>
                    <p>Gunakan editor online atau upload file desain Anda sendiri.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Konfirmasi Pesanan</h3>
                    <p>Periksa desain dan lakukan pembayaran dengan metode yang tersedia.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Terima Pesanan</h3>
                    <p>Pesanan Anda akan dikirim dan segera sampai di lokasi Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="products" id="produk">
        <div class="container">
            <div class="section-title">
                <h2>Produk Kami</h2>
                <p>Berbagai pilihan spanduk berkualitas untuk kebutuhan Anda</p>
            </div>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/200" alt="Spanduk Outdoor">
                    </div>
                    <div class="product-info">
                        <h3>Spanduk Outdoor</h3>
                        <p>Bahan vinyl tahan cuaca dengan cetak digital resolusi tinggi.</p>
                        <div class="price">Mulai Rp 25.000/m²</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/200" alt="Spanduk Indoor">
                    </div>
                    <div class="product-info">
                        <h3>Spanduk Indoor</h3>
                        <p>Cetak kualitas premium untuk penggunaan dalam ruangan.</p>
                        <div class="price">Mulai Rp 20.000/m²</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/200" alt="Banner Roll Up">
                    </div>
                    <div class="product-info">
                        <h3>Banner Roll Up</h3>
                        <p>Ideal untuk pameran dan presentasi dengan stand portable.</p>
                        <div class="price">Mulai Rp 150.000/unit</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/200" alt="Spanduk Promosi">
                    </div>
                    <div class="product-info">
                        <h3>Spanduk Promosi</h3>
                        <p>Solusi terbaik untuk kampanye marketing dan promo bisnis.</p>
                        <div class="price">Mulai Rp 22.000/m²</div>
                        <a href="#pesan" class="btn">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials" id="testimonial">
        <div class="container">
            <div class="section-title">
                <h2>Apa Kata Pelanggan Kami</h2>
                <p>Pengalaman pelanggan yang telah menggunakan layanan SpandukPro</p>
            </div>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        "Kualitas cetakan sangat bagus, warna cerah dan tajam. Pengirimannya juga cepat, hanya 2 hari sudah sampai di toko saya. Pasti akan pesan lagi!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar"></div>
                        <div class="author-info">
                            <h4>Budi Santoso</h4>
                            <p>Pemilik Toko Elektronik</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        "Proses pemesanan sangat mudah dan cepat. Saya bisa membuat desain sendiri melalui website dan hasilnya sesuai dengan yang saya inginkan. Terima kasih SpandukPro!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar"></div>
                        <div class="author-info">
                            <h4>Siti Nurhaliza</h4>
                            <p>Event Organizer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        "Sudah 3 kali pesan spanduk untuk event kampus dan hasilnya selalu memuaskan. Harga juga sangat bersaing untuk kualitas yang diberikan. Recommended!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar"></div>
                        <div class="author-info">
                            <h4>Reza Mahendra</h4>
                            <p>Mahasiswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta" id="pesan">
        <div class="container">
            <h2>Siap Untuk Memesan Spanduk?</h2>
            <p>Dapatkan penawaran terbaik untuk kebutuhan spanduk Anda sekarang juga. Proses cepat, hasil berkualitas, harga terjangkau!</p>
            <a href="{{ route('login') }}" class="btn-white">Pesan Sekarang</a>
        </div>
    </section>

    <footer id="kontak">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>SpandukPro</h3>
                    <p>Solusi cetak spanduk online terbaik untuk kebutuhan promosi dan publikasi Anda dengan kualitas premium.</p>
                </div>
                <div class="footer-column">
                    <h3>Produk</h3>
                    <ul class="footer-links">
                        <li><a href="#">Spanduk Outdoor</a></li>
                        <li><a href="#">Spanduk Indoor</a></li>
                        <li><a href="#">Banner Roll Up</a></li>
                        <li><a href="#">Spanduk Promosi</a></li>
                        <li><a href="#">Spanduk Event</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Informasi</h3>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Cara Pemesanan</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Kontak</h3>
                    <ul class="footer-links">
                        <li>Email: info@spandukpro.id</li>
                        <li>Telepon: 0812-3456-7890</li>
                        <li>WhatsApp: 0812-3456-7890</li>
                        <li>Alamat: Jl. Merdeka No. 123, Jakarta</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 SpandukPro. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>
</body> --}}

</html>
