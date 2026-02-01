<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/produk.css') }}">
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

    <!-- Tambah Produk -->
    <div class="card">
        <h3>Tambah Produk Baru</h3>
        <form action="{{ url('/produk/tambah') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name" placeholder="Nama Produk" required>
            <input type="text" name="description" placeholder="Deskripsi" required>
            <select name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <input type="text" name="price" placeholder="Harga" required>
            <input type="number" name="stock" placeholder="Stok" required>
            <input type="file" name="image" accept="image/*">
            <button type="submit">Tambah Produk</button>
        </form>
    </div>

    <!-- Tabel Produk -->
    <div class="card">
        <h3>📦 Daftar Produk</h3>
        <div class="product-table">

            <!-- Header -->
            <div class="product-row header">
                <span class="col">Nama Produk</span>
                <span class="col">Kategori</span>
                <span class="col">Deskripsi</span>
                <span class="col">Harga</span>
                <span class="col">Stok</span>
                <span class="col">Gambar</span>
                <span class="col">Aksi</span>
            </div>

            <!-- Data Produk -->
            @forelse($products as $product)
            <div class="product-row"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-description="{{ $product->description }}"
                data-category_id="{{ $product->category_id }}"
                data-price="{{ $product->price }}"
                data-stock="{{ $product->stock }}"
                data-image="{{ $product->image }}"
            >
                <span class="col">{{ $product->name }}</span>
                <span class="col">{{ $product->category->name ?? '-' }}</span>
                <span class="col">{{ $product->description }}</span>
                <span class="col">Rp {{ number_format($product->price,0,',','.') }}</span>
                <span class="col">{{ $product->stock }}</span>
                <span class="col">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" width="60">
                    @else
                        -
                    @endif
                </span>
                <span class="col actions">
                    <a href="#" class="btn-edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ url('/produk/' . $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </span>
            </div>
            @empty
            <div class="product-row">
                <span class="col">Belum ada produk</span>
            </div>
            @endforelse

        </div>
    </div>

</div>

<!-- Modal Edit Produk -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <span class="close-modal" id="closeModal">&times;</span>
        <h3>Edit Produk</h3>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" name="name" required>
            <input type="text" name="description" required>
            <select name="category_id" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
            <input type="text" name="price" required>
            <input type="number" name="stock" required>
            <input type="file" name="image">
            <img id="previewImage" src="" width="120" style="margin-top:10px; display:none;">
            <button type="submit">Update</button>
        </form>
    </div>
</div>

<!-- JS Modal -->
<script>
const modal = document.getElementById('editModal');
const closeModal = document.getElementById('closeModal');
const editForm = document.getElementById('editForm');

document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        const row = btn.closest('.product-row');
        const id = row.dataset.id;

        // 🔥 FIX: route sesuai web.php PUT /produk/{id}
        editForm.action = '/produk/' + id;

        editForm.name.value = row.dataset.name;
        editForm.description.value = row.dataset.description;
        editForm.category_id.value = row.dataset.category_id;
        editForm.price.value = row.dataset.price;
        editForm.stock.value = row.dataset.stock;

        if(row.dataset.image) {
            document.getElementById('previewImage').src = '/storage/' + row.dataset.image;
            document.getElementById('previewImage').style.display = 'block';
        } else {
            document.getElementById('previewImage').style.display = 'none';
        }

        modal.style.display = 'block';
    });
});

closeModal.onclick = function() {
    modal.style.display = 'none';
}
window.onclick = function(e) {
    if (e.target == modal) modal.style.display = 'none';
}
</script>

<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
