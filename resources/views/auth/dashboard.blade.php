<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- SIDEBAR -->
<nav class="sidebar" id="sidebar">

  <div class="hamburger" id="hamburger">
    <i class="fas fa-bars"></i>
  </div>

  <div class="logo">
    <img src="{{ asset('image/logo_loka.png') }}" alt="Logo">
    <h2>{{ $setting->shop_name ?? 'Nama Toko' }}</h2>
  </div>

  <div class="menu">
    <a href="#"><i class="fas fa-home"></i> <span>Dashboard</span></a>
    <a href="/produk"><i class="fas fa-box"></i> <span>Produk</span></a>
    <a href="/pesanan"><i class="fas fa-shopping-cart"></i> <span>Pesanan</span></a>
    <a href="/pelanggan"><i class="fas fa-users"></i> <span>Pelanggan</span></a>
    <a href="/messages"><i class="fas fa-envelope"></i> <span>Pesan</span></a>
    <a href="/laporan"><i class="fas fa-file-alt"></i> <span>Laporan</span></a>
    <a href="/pengaturan"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
  </div>

  <div class="logout">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" style="background:none; border:none; cursor:pointer; color:inherit; font:inherit;">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </button>
    </form>
</div>

</nav>

<div class="content" id="content">

  <!-- Welcome Card -->
 <div class="card welcome-card">

  <!-- KIRI -->
  <div class="welcome-left">
    <h1>Selamat Datang, Hallo👋 {{ auth()->user()->name }}</h1>
  </div>

  <!-- KANAN -->
  <div class="welcome-right">

    <form action="{{ route('search') }}" method="GET" class="welcome-search">
  <input 
    type="text" 
    name="q" 
    placeholder="Cari produk / pesanan..." 
    value="{{ request('q') }}"
    required
  >
  <button type="submit">
    <i class="fas fa-search"></i>
  </button>
</form>


    <div class="avatar-wrapper">
      @if($setting && $setting->avatar)
        <img src="{{ asset(str_replace('public/', 'storage/', $setting->avatar)) }}" class="avatar">
      @else
        <img src="{{ asset('image/default-avatar.png') }}" class="avatar">
      @endif
    </div>

  </div>
</div>

  <!-- Statistik Card -->
  <div class="card-row">

    <div class="card stat orange">
      <i class="fas fa-box"></i>
      <div>
        <span>Total Produk</span>
        <h2>{{ $totalProduk }}</h2>
      </div>
    </div>

    <div class="card stat green">
      <i class="fas fa-shopping-cart"></i>
      <div>
        <span>Total Pesanan</span>
        <h2>{{ $totalPesanan }}</h2>
      </div>
    </div>

    <div class="card stat blue">
      <i class="fas fa-users"></i>
      <div>
        <span>Total Pelanggan</span>
        <h2>{{ $totalPelanggan }}</h2>
      </div>
    </div>

    <div class="card stat red">
      <i class="fas fa-chart-line"></i>
      <div>
        <span>Total Penjualan</span>
        <h2>Rp {{ number_format($totalPenjualan,0,',','.') }}</h2>
      </div>
    </div>

  </div>

  <!-- Layout Bawah -->
  <div class="dashboard-grid">

    <!-- Produk -->
    <div class="card">
      <h3>📦 Daftar Produk</h3>

      <div class="product-table">
        <div class="product-header">
          <span>Nama Produk</span>
          <span>Deskripsi</span>
          <span>Harga</span>
          <span>Stok</span>
        </div>

        @foreach($produkTerbaru as $produk)
          <div class="product-row">
            <span><strong>{{ $produk->name }}</strong></span>
            <span>{{ $produk->description }}</span>
            <span class="price">Rp {{ number_format($produk->price,0,',','.') }}</span>
            <span class="stock {{ $produk->stock <= 5 ? 'danger' : '' }}">
              {{ $produk->stock }}
            </span>
          </div>
        @endforeach
      </div>

      <a href="/produk" class="btn full">Kelola Produk</a>
    </div>

    <!-- Kanan -->
    <div>

      <div class="card">
        <h3>🚚 Pesanan Terbaru</h3>
        <ul class="list">
          @foreach($pesananTerbaru as $order)
            <li>
              #{{ $order->id }} {{ $order->customer_name }}
              <span class="badge 
                {{ $order->status == 'Menunggu' ? 'wait' : '' }}
                {{ $order->status == 'Diproses' ? 'process' : '' }}
                {{ $order->status == 'Selesai' ? 'done' : '' }}">
                {{ $order->status }}
              </span>
            </li>
          @endforeach
        </ul>
      </div>

      <div class="card">
        <h3>📦 Produk Terbaru</h3>
        <ul class="list">
          @forelse($produkTerbaru as $produk)
            <li>
              {{ $produk->name }}
              <span class="price">
                Rp {{ number_format($produk->price,0,',','.') }}
              </span>
            </li>
          @empty
            <li>Belum ada produk</li>
          @endforelse
        </ul>

        <div class="card-footer">
          <a href="/produk" class="btn btn-outline full">
            <i class="fas fa-box"></i> Lihat Semua Produk
          </a>
        </div>
      </div>

    </div>

  </div>
</div>

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
