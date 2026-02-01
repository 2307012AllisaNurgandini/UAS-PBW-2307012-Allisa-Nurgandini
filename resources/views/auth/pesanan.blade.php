<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
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
<div class="content" id="content">
    <!-- Tabel Pesanan -->  
    <div class="card">
        <h3>📋 Daftar Pesanan</h3>

        <div class="product-table">
            <!-- Header -->
            <div class="product-row header">
                <span class="col">No</span>
                <span class="col">Nama Pelanggan</span>
                <span class="col">Total</span>
                <span class="col">Status</span>
                <span class="col">Aksi</span>
            </div>

            <!-- Data Pesanan -->
            @forelse($orders as $order)
            <div class="product-row">
                <span class="col">#{{ $order->id }}</span>
                <span class="col">{{ $order->customer_name }}</span>
                <span class="col">Rp {{ number_format($order->total,0,',','.') }}</span>
                <span class="col">{{ $order->status }}</span>
                <span class="col actions">
                    <!-- Update status via dropdown -->
                    <form action="{{ route('pesanan.updateStatus', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <select name="status" onchange="this.form.submit()">
                            <option value="Menunggu" {{ $order->status=='Menunggu'?'selected':'' }}>Menunggu</option>
                            <option value="Diproses" {{ $order->status=='Diproses'?'selected':'' }}>Diproses</option>
                            <option value="Selesai" {{ $order->status=='Selesai'?'selected':'' }}>Selesai</option>
                        </select>
                    </form>

                    <!-- Hapus pesanan -->
                    <form action="/pesanan/hapus/{{ $order->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </span>
            </div>
            @empty
            <div class="product-row">
                <span class="col" colspan="5">Belum ada pesanan.</span>
            </div>
            @endforelse
        </div>
    </div>

</div>

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
