<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>
    <!-- CSS Dashboard -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pelanggan.css') }}">
    <!-- Font Awesome -->
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

    <div class="card">
        <h3>👥 Daftar Pelanggan</h3>

        <div class="product-table">
            <!-- Header -->
            <div class="product-row header">
                <span class="col">No</span>
                <span class="col">Nama</span>
                <span class="col">Email</span>
                <span class="col">Aksi</span>
            </div>

            <!-- Data Pelanggan -->
            @forelse($customers as $customer)
            <div class="product-row">
                <span class="col">#{{ $customer->id }}</span>
                <span class="col">{{ $customer->name }}</span>
                <span class="col">{{ $customer->email }}</span>
                <span class="col actions">
                    <a href="#" class="btn-edit"><i class="fas fa-edit"></i></a>
                    <form action="/pelanggan/hapus/{{ $customer->id }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </span>
            </div>
            @empty
            <div class="product-row">
                <span class="col" colspan="4">Belum ada pelanggan.</span>
            </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Edit -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <span class="close-modal" id="closeModal">&times;</span>
        <h3>Edit Pelanggan</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editId">
            <input type="text" name="name" id="editName" placeholder="Nama Pelanggan" required>
            <input type="email" name="email" id="editEmail" placeholder="Email" required>
            <button type="submit">Update Pelanggan</button>
        </form>
    </div>
</div>

<!-- JS Inline -->
<script>
const modal = document.getElementById('editModal');
const closeModal = document.getElementById('closeModal');
const editForm = document.getElementById('editForm');

// Tutup modal
closeModal.onclick = () => modal.style.display = 'none';
window.onclick = (e) => { if(e.target == modal) modal.style.display = 'none'; }

// Tombol edit
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();

        const row = btn.closest('.product-row');
        const id = row.querySelector('.col:nth-child(1)').innerText.replace('#','').trim();
        const name = row.querySelector('.col:nth-child(2)').innerText.trim();
        const email = row.querySelector('.col:nth-child(3)').innerText.trim();

        document.getElementById('editId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;

        editForm.action = `/pelanggan/update/${id}`;

        modal.style.display = 'flex';
    });
});
</script>
<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>
