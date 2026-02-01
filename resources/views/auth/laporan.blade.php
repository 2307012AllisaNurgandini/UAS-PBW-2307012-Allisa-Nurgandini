<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
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
      <a href="/dashboard"><i class="fas fa-home"></i> <span>Dashboard</span></a>
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

<!-- CONTENT -->
<div class="content">

    <!-- FILTER -->
    <div class="card">
        <h3>📅 Filter Laporan</h3>
        <form method="GET">
            <input type="date" name="start" value="{{ request('start') }}">
            <input type="date" name="end" value="{{ request('end') }}">
            <button class="btn">Tampilkan</button>
        </form>
    </div>

    <!-- STATISTIK -->
    <div class="card-row">
        <div class="card stat green">
            <span>Total Transaksi</span>
            <h2>{{ $totalTransaksi }}</h2>
        </div>

        <div class="card stat blue">
            <span>Total Pendapatan</span>
            <h2>Rp {{ number_format($totalPendapatan,0,',','.') }}</h2>
        </div>
    </div>

    <!-- TABEL -->
    <div class="card">
        <h3>📊 Data Penjualan</h3>

        <div class="product-table">
            <div class="product-header">
                <span>Tanggal</span>
                <span>Pelanggan</span>
                <span>Total</span>
                <span>Status</span>
            </div>

            @forelse($orders as $order)
            <div class="product-row">
                <span>{{ $order->created_at->format('d-m-Y') }}</span>
                <span>{{ $order->customer_name }}</span>
                <span class="price">
                    Rp {{ number_format($order->total,0,',','.') }}
                </span>
                <span class="badge done">{{ $order->status }}</span>
            </div>
            @empty
            <div class="product-row">
                <span>Belum ada data laporan</span>
            </div>
            @endforelse
        </div>
    </div>

</div>

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
