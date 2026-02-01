<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pesan.css') }}">
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

<!-- CONTENT -->
<div class="content" id="content">

    <div class="card">
        <h3>📩 Daftar Message</h3>

        <div class="product-table">

            <!-- Header -->
            <div class="product-row header">
                <span class="col">No</span>
                <span class="col">Nama Lengkap</span>
                <span class="col">Email</span>
                <span class="col">Pesan</span>
                <span class="col">Aksi</span>
            </div>

            <!-- Data Message -->
            @forelse($messages as $message)
            <div class="product-row">
                <span class="col">#{{ $message->id }}</span>
                <span class="col full-name">{{ $message->full_name }}</span>
                <span class="col email">{{ $message->email }}</span>
                <span class="col message-text">{{ $message->message }}</span>

                <span class="col actions">
                    <a href="#" class="btn-edit"
                       data-id="{{ $message->id }}"
                       data-name="{{ $message->full_name }}"
                       data-email="{{ $message->email }}"
                       data-message="{{ $message->message }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('messages.destroy', $message->id) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn-delete"
                                onclick="return confirm('Yakin ingin menghapus message ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </span>
            </div>
            @empty
            <div class="product-row">
                <span class="col">Belum ada message.</span>
            </div>
            @endforelse

        </div>
    </div>

</div>

<!-- MODAL EDIT MESSAGE -->
<div class="modal" id="editModal">
    <div class="modal-content">
        <span class="close-modal" id="closeModal">&times;</span>
        <h3>Edit Message</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text" name="full_name" id="editName" placeholder="Full Name" required>
            <input type="email" name="email" id="editEmail" placeholder="Email" required>
            <textarea name="message" id="editMessage" placeholder="Message" required></textarea>

            <button type="submit">Update Message</button>
        </form>
    </div>
</div>

<!-- JS -->
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

        const id = this.dataset.id;
        const name = this.dataset.name;
        const email = this.dataset.email;
        const message = this.dataset.message;

        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editMessage').value = message;

        editForm.action = `/messages/${id}`;
        modal.style.display = 'flex';
    });
});
</script>

<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>
