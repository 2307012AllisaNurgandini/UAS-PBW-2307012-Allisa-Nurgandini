<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Pencarian</title>

  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/search.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- ========== SIDEBAR ========== -->
<nav class="sidebar" id="sidebar">

  <div class="hamburger" id="hamburger">
    <i class="fas fa-bars"></i>
  </div>

  <div class="logo">
    <img src="{{ asset('image/logo_loka.png') }}">
    <h2>{{ $setting->shop_name ?? 'Nama Toko' }}</h2>
  </div>

  <div class="menu">
    <a href="/dashboard"><i class="fas fa-home"></i><span>Dashboard</span></a>
    <a href="/produk"><i class="fas fa-box"></i><span>Produk</span></a>
    <a href="/pesanan"><i class="fas fa-shopping-cart"></i><span>Pesanan</span></a>
    <a href="/pelanggan"><i class="fas fa-users"></i><span>Pelanggan</span></a>
    <a href="/messages"><i class="fas fa-envelope"></i><span>Pesan</span></a>
    <a href="/laporan"><i class="fas fa-file-alt"></i><span>Laporan</span></a>
    <a href="/pengaturan"><i class="fas fa-cog"></i><span>Pengaturan</span></a>
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

<!-- ========== CONTENT ========== -->
<div class="content" id="content">

  <!-- HEADER -->
  <div class="card welcome-card">
    <div class="welcome-left">
      <h1>🔍 Hasil Pencarian: "{{ $keyword }}"</h1>
    </div>
  </div>

  <!-- ========== PRODUK ========== -->
  @if($products->count())
  <div class="card">
    <h3>📦 Produk</h3>

    <table class="table">
      <thead>
        <tr>
          <th>Nama Produk</th>
          <th>Deskripsi</th>
          <th>Harga</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
        <tr>
          <td>{{ $product->name }}</td>
          <td>{{ $product->description }}</td>
          <td class="price">
            Rp {{ number_format($product->price,0,',','.') }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  <!-- ========== PESANAN ========== -->
  @if($orders->count())
  <div class="card">
    <h3>🚚 Pesanan</h3>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Pelanggan</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
        <tr>
          <td>#{{ $order->id }}</td>
          <td>{{ $order->customer_name }}</td>
          <td>
            <span class="badge
              {{ $order->status == 'Menunggu' ? 'wait' : '' }}
              {{ $order->status == 'Diproses' ? 'process' : '' }}
              {{ $order->status == 'Selesai' ? 'done' : '' }}">
              {{ $order->status }}
            </span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  <!-- ========== PELANGGAN ========== -->
  @if($customers->count())
  <div class="card">
    <h3>👥 Pelanggan</h3>

    <table class="table">
      <thead>
        <tr>
          <th>Nama Pelanggan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($customers as $customer)
        <tr>
          <td>{{ $customer->name }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  @if(
    !$products->count() &&
    !$orders->count() &&
    !$customers->count()
  )
    <div class="card">
      <p style="text-align:center;color:#777;">
        Tidak ada data ditemukan
      </p>
    </div>
  @endif

</div>

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
