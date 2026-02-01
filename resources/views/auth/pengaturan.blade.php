<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
   <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">
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
  <div class="pengaturan-wrapper">

    <!-- ALERT -->
    @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
    @endif

    <!-- CARD PROFIL -->
    <div class="card">
        <h3>⚙️ Pengaturan Aplikasi</h3>
        <form action="{{ url('/pengaturan/update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama Toko</label>
    <input type="text" name="shop_name" value="{{ $setting->shop_name }}" required>

    <label>Email Admin</label>
    <input type="email" name="admin_email" value="{{ Auth::user()->email }}" required>

    <label>Nomor HP</label>
    <input type="text" name="phone" value="{{ $setting->phone }}" placeholder="08123456789">

    <label>Password Baru (Opsional)</label>
    <input type="password" name="password" placeholder="Isi jika ingin ganti password">
    <input type="password" name="password_confirmation" placeholder="Konfirmasi password">

    <label>Foto Profil</label>
    @if($setting->avatar)
        <img src="{{ Storage::url($setting->avatar) }}" width="100">
    @endif
    <input type="file" name="avatar" accept="image/*">

    <button type="submit" class="btn">Simpan</button>
</form>

    </div>

</div>


</div>
<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
