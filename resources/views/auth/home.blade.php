<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Loka</title>
    <link rel="stylesheet" href="{{ asset('css/Home.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- ===== HEADER ===== -->
    <header class="header">
        <div class="logoContent">
            <a href="{{ url('/') }}" class="logo"><img src="{{ asset('image/logo_loka.png') }}" alt="Logo Kedai loka"></a>
            <h2>{{ $setting->shop_name ?? 'Nama Toko' }}</h2>
        </div>

        <nav>
            <ul class="navbar-nav">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('tentangkami') }}">Tentang Kami</a>
                <a href="{{ url('/menu') }}">Menu</a>
                <a href="{{ url('/kontak') }}">Kontak</a>
            </ul>
        </nav>

        <div class="navbar-extra">
            <a href="#" id="search"><i data-feather="search"></i></a>
            <a href="#" id="shopping-cart"><i data-feather="shopping-cart"></i></a>
            <a href="#" id="user"><i data-feather="user"></i></a>
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </header>

    <!-- ===== SEARCH POPUP ===== -->
<div class="search-popup" id="searchPopup">
    <input type="text" id="searchInput" placeholder="Cari menu..." autocomplete="off">
    <ul id="searchResults"></ul>
</div>


    <!-- ===== USER POPUP ===== -->
<div id="userPopup" class="user-popup">
    <div class="popup-content">
        @auth
            <h4>{{ auth()->user()->name }}</h4>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i data-feather="log-out"></i> Logout
                </button>
            </form>
        @else
            <p>Silakan <a href="{{ route('login') }}">login</a></p>
        @endauth
    </div>
</div>

    <!-- CART MODAL -->
<div id="cart-modal" class="cart-modal">
    <div class="cart-content">
        <h2>Keranjang</h2>
        <ul id="cart-items"></ul>
        <div class="cart-total">
            Total: <span id="cart-total">Rp 0</span>
        </div>
        <div class="cart-buttons">
            <button id="checkout-btn">Pesan Sekarang</button>
            <button id="close-cart">Tutup</button>
        </div>
    </div>
</div>

<!-- PAYMENT MODAL -->
<div id="payment-modal" class="payment-modal">
    <div class="payment-content">
        <h2>Pembayaran QRIS</h2>
        <img src="{{ asset('image/qriss.jpg') }}" alt="QRIS" class="qris-image">
        <p>Silakan lakukan pembayaran melalui QRIS di atas.</p>
        <button id="done-payment">Selesai Bayar</button>
    </div>
</div>

<!-- THANKS MODAL -->
<div id="thanks-modal" class="thanks-modal">
    <div class="thanks-content">
        <h2>Terima kasih!</h2>
        <p>Pembayaran anda sedang diproses 😊</p>
    </div>
</div>

    <!-- ===== HERO SECTION ===== -->
    <section class="hero">
        <div class="hero-content">
            <h1>LØKA | Kedai Kecil <br>Penuh Harapan <br> <span> Coffee & Dimsum</span></h1>
            <p>Tempat bertemu, bercerita, dan <br>menemukan inspirasi baru.</p>
            <div class="buttons">
                <a href="{{ url('/menu') }}" class="order-btn">Order now</a>
            </div>
            <div class="social-icons">
                <a href="#" id="twitter"><i data-feather="twitter"></i></a>
                <a href="#" id="instagram"><i data-feather="instagram"></i></a>
                <a href="#" id="email"><i data-feather="mail"></i></a>
                <a href="#" id="facebook"><i data-feather="facebook"></i></a>
            </div>
        </div>
    </section>

    <!-- ===== ABOUT SECTION ===== -->
    <section class="about-section" id="tentangkami">
        <div class="about-container">
            <div class="about-image">
                <img src="{{ asset('image/kedai2.jpg') }}" alt="Kopi dan Dimsum Kedai Hope">
                <img src="{{ asset('image/kedai3.jpg') }}" alt="Kopi dan Dimsum Kedai Hope">
            </div>
            <div class="about-content">
                <h2>Tentang Kami</h2>
                <p>
                    <strong>Kedai LØKA</strong> adalah tempat yang menghadirkan kehangatan dalam setiap tegukan kopi dan rasa nyaman di setiap gigitan dimsum.
                    Berdiri sejak tahun <strong>2023</strong>, kami berkomitmen memberikan cita rasa terbaik dengan bahan berkualitas dan pelayanan yang ramah.
                </p>
                <p>
                    Nama “<strong>LØKA</strong>” melambangkan harapan — bahwa setiap pelanggan yang datang akan menemukan secercah semangat baru untuk melanjutkan hari.
                </p>
                <a href="{{ route('tentangkami') }}" class="btn-more">Kenali Lebih Dalam</a>
            </div>
        </div>
    </section>

    <!-- ===== MENU SECTION ===== -->
    <section class="menu-section" id="menu">
        <h2 class="menu-title">Our Menu</h2>

    <div class="menu-container">
        @forelse ($menuItems->take(8) as $item)
            <div class="menu-card">
                {{-- Tampilkan gambar produk jika ada, jika tidak gunakan default --}}
                <img src="{{ $item->image ? Storage::url($item->image) : asset('image/default-menu.png') }}" 
                     alt="{{ $item->name }}">

                <h4>{{ $item->name }}</h4>
                <p>{{ $item->description }}</p>

                <div class="menu-bottom">
                    <span class="price">
                        Rp {{ number_format($item->price,0,',','.') }}
                    </span>
                    <button class="buy-btn"
                        data-id="{{ $item->id }}"
                        data-name="{{ $item->name }}"
                        data-price="{{ $item->price }}">
                        Tambah
                    </button>
                </div>
            </div>
        @empty
            <p>Menu belum tersedia</p>
        @endforelse
    </div>

    {{-- Tombol lihat semua menu jika ada lebih dari 6 --}}
    @if($menuItems->count() > 6)
        <div class="see-all-menu">
            <a href="{{ url('/menu') }}" class="btn-more">Lihat Semua Menu</a>
        </div>
    @endif
</section>

    <!-- ===== LOCATION SECTION ===== -->
    <section class="location-section">
        <div class="location-text">
            <h2>Our Location</h2>
            <p>
                Kedai LØKA hadir di pusat kota untuk kamu yang ingin menikmati kopi dan dimsum dengan suasana nyaman. 
                Kami selalu siap menyajikan cita rasa terbaik dan pelayanan hangat.
            </p>
        </div>

        <div class="location-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6922.650626998054!2d107.89712917408966!3d-7.213874915733991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68b17f2ff1dc69%3A0xff24c3e77c2019c6!2sKedai%20Hope!5e1!3m2!1sid!2sid!4v1760585364741!5m2!1sid!2sid" 
                width="500"
                height="300"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section about">
                <h2 class="logo">KEDAI <span>LØKA</span></h2>
                <p>Tempat bertemu, bercerita, dan menemukan inspirasi baru dengan secangkir kopi dan dimsum hangat.</p>
            </div>

            <div class="footer-section">
                <h3>Product</h3>
                <ul>
                    <li><a href="#">Menu</a></li>
                    <li><a href="#">Spesial</a></li>
                    <li><a href="#">Paket Hemat</a></li>
                    <li><a href="#">Catering</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Information</h3>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">Informasi Nutrisi</a></li>
                    <li><a href="#">Allergen Info</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Company</h3>
                <ul>
                    <li><a href="#">Cerita Kami</a></li>
                    <li><a href="#">Karier</a></li>
                    <li><a href="#">Ketentuan Layanan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2025 {{ $setting->shop_name ?? 'Nama Toko' }} | All Rights Reserved</p>
        </div>
    </footer>

    <script src="{{ asset('js/Home.js') }}"></script>
    <script>
        feather.replace()
    </script>
</body>
</html>
