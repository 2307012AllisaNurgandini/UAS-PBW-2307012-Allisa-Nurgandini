<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Loka</title>
    <link rel="stylesheet" href="{{ asset('css/tentangkami.css') }}">
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

    <!-- ===== USER POPUP ===== -->
    <div class="user-popup" id="userPopup">
        <div class="popup-arrow"></div>
        <div class="popup-content">
            <h4>{{ auth()->user()->name }}</h4>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i data-feather="log-out"></i> Logout
                </button>
            </form>
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

<section class="hero-section">
    <img src="{{ asset('image/image2.avif') }}" class="hero-img" alt="Kedai LØKA">
    <div class="hero-overlay"></div>
    <h1 class="hero-title">Kedai LØKA</h1>
</section>

<section class="about-box">
    <div class="about-container">
        <div class="about-img">
            <img src="{{ asset('image/kedai.jpg') }}" alt="Foto Kedai LØKA">
        </div>

        <div class="about-text">
            <h2>Tentang Kedai LØKA</h2>
            <p>
                Kedai LØKA berdiri dengan tujuan menghadirkan suasana nongkrong yang nyaman 
                dan hangat untuk semua kalangan. Berawal dari sebuah ide sederhana untuk menyediakan 
                kopi dan makanan ringan yang berkualitas, kami terus berkembang menjadi tempat favorit 
                untuk bersantai, berdiskusi, dan menikmati hidangan.
            </p>
            <p>
                Dengan mengutamakan rasa, pelayanan terbaik dan harga yang terjangkau, 
                Kedai LØKA berkomitmen untuk menjadi tempat yang memberikan pengalaman berbeda 
                bagi setiap pengunjung.
            </p>
        </div>
    </div>
</section>

<section class="about-features">
    <div class="container">
        <h3 class="subheading">Keunggulan Kami</h3>
        <h1 class="main-heading">Mengapa Kedai LØKA Terbaik?</h1>

        <div class="features">
            <div class="feature">
                <div class="icon">
                    <img src="{{ asset('image/siomay udang.png') }}">
                </div>
                <h4>Kualitas Premium</h4>
                <p>Bahan segar dan pilihan terbaik.</p>
            </div>

            <div class="feature">
                <div class="icon">
                    <img src="{{ asset('image/caramel_latte.png') }}">
                </div>
                <h4>Aneka Pilihan Menu</h4>
                <p>Kopi, dimsum, hingga dessert.</p>
            </div>

            <div class="feature">
                <div class="icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/883/883407.png">
                </div>
                <h4>Pelayanan Cepat</h4>
                <p>Pesanan disajikan dengan cepat.</p>
            </div>
        </div>
    </div>
</section>

<section class="team-section" id="our-team">
    <div class="team-container">
        <h2 class="team-title">Our Team</h2>
        <span class="team-line"></span>

        <p class="team-desc">
             Di balik Kedai LØKA, terdapat tim yang bekerja dengan penuh semangat untuk
             menciptakan pengalaman terbaik bagi setiap pelanggan. Kami percaya bahwa
             pelayanan hangat dan rasa yang berkualitas berasal dari kerja sama yang solid.
        </p>

        <div class="team-cards">
            <div class="team-card">
                <img src="{{ asset('image/team1.jpg') }}" alt="Owner Kedai Hope">
                <h3>Nama Owner</h3>
                <p class="team-role">Owner & Founder</p>
            </div>

            <div class="team-card">
                <img src="{{ asset('image/team2.jpg') }}" alt="Barista">
                <h3>Nama Barista</h3>
                <p class="team-role">Head Barista</p>
            </div>

            <div class="team-card">
                <img src="{{ asset('image/team3.jpg') }}" alt="Chef Dimsum">
                <h3>Nama Chef</h3>
                <p class="team-role">Dimsum Specialist</p>
            </div>

            <div class="team-card">
                <img src="{{ asset('image/team4.jpg') }}" alt="Staff">
                <h3>Nama Staff</h3>
                <p class="team-role">Service Staff</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section about">
            <h2 class="logo">Kedai <span>LØKA</span></h2>
            <p>
                Tempat bertemu, bercerita, dan menemukan inspirasi baru
                dengan secangkir kopi dan dimsum hangat.
            </p>
        </div>

        <div class="footer-section">
            <h3>Product</h3>
            <ul>
                <li><a href="/menu">Menu</a></li>
                <li><a href="#">Spesial</a></li>
                <li><a href="#">Paket Hemat</a></li>
                <li><a href="#">Catering</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Information</h3>
            <ul>
                <li><a href="/tentangkami">Tentang Kami</a></li>
                <li><a href="/kontak">Hubungi Kami</a></li>
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

<script src="{{ asset('js/Home.js') }}"></script>

</body>
</html>
