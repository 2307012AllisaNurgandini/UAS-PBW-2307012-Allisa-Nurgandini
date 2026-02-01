<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Loka</title>
    <link rel="stylesheet" href="{{ asset('css/Home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">
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

    <!-- ===== BAGIAN KONTAK ===== -->
    <section class="contact-section">
        <h2>Hubungi Kami</h2>
        <p>Butuh bantuan atau ingin memesan? Silakan hubungi kami melalui form di bawah ini.</p>

        <div class="contact-container">
            <!-- FORMULIR KONTAK -->
            <form action="{{ route('kontak.kirim') }}" method="POST" class="contact-form">
    @csrf

    <label>Nama Lengkap</label>
    <input type="text" name="full_name" placeholder="Masukkan nama Anda" required>

    <label>Email</label>
    <input type="email" name="email" placeholder="Masukkan email Anda" required>

    <label>Pesan</label>
    <textarea name="message" placeholder="Tulis pesan Anda..." required></textarea>

    <button type="submit">Kirim Pesan</button>

    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif
</form>


            <!-- INFORMASI KONTAK -->
            <div class="contact-info">
                <h3>Informasi Kontak</h3>
                <p><strong>Alamat:</strong> Jl. Raya Garut No. 45, Garut Kota</p>
                <p><strong>Telepon:</strong> 0821-1234-5678</p>
                <p><strong>Email:</strong> info@kedaihope.com</p>
                <p><strong>Jam Operasional:</strong><br>Senin - Minggu: 09.00 - 22.00</p>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section about">
                <h2 class="logo">Kedai <span>Hope</span></h2>
                <p>Tempat bertemu, bercerita, dan menemukan inspirasi baru dengan secangkir kopi dan dimsum hangat.</p>
            </div>

            <div class="footer-section">
                <h3>Product</h3>
                <ul>
                    <li><a href="{{ url('/menu') }}">Menu</a></li>
                    <li><a href="#">Spesial</a></li>
                    <li><a href="#">Paket Hemat</a></li>
                    <li><a href="#">Catering</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Information</h3>
                <ul>
                    <li><a href="{{ url('/tentangkami') }}">Tentang Kami</a></li>
                    <li><a href="{{ url('/kontak') }}">Hubungi Kami</a></li>
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
            <p>© 2025 Kedai LØKA | All Rights Reserved</p>
        </div>
    </footer>

    <script>
        feather.replace();

        // Toggle menu mobile
        const navbarNav = document.querySelector('.navbar-nav');
        document.querySelector('#hamburger-menu').onclick = () => {
            navbarNav.classList.toggle('active');
        };
    </script>

    <script src="{{ asset('js/Home.js') }}"></script>
</body>
</html>
