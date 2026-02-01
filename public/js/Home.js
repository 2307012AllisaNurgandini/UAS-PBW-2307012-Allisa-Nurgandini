// ================= ICON FEATHER =================
document.addEventListener('DOMContentLoaded', function() {
    feather.replace();

    // ===== USER POPUP =====
    const userIcon = document.querySelector('#user');
    const userPopup = document.querySelector('#userPopup');

    if (userIcon && userPopup) {
        userIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            userPopup.classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!userPopup.contains(e.target) && e.target !== userIcon) {
                userPopup.classList.remove('show');
            }
        });
    }

    // ===== HAMBURGER MENU =====
    const navbarNav = document.querySelector('.navbar-nav');
    const hamburgerMenu = document.getElementById('hamburger-menu');
    if (navbarNav && hamburgerMenu) {
        hamburgerMenu.onclick = () => {
            navbarNav.classList.toggle('active');
        };
    }

    // ===== MENU SLIDER (opsional) =====
    window.slideRight = function() {
        const menuSlider = document.getElementById("menuSlider");
        if (menuSlider) menuSlider.scrollBy({ left: 150, behavior: "smooth" });
    };
    window.slideLeft = function() {
        const menuSlider = document.getElementById("menuSlider");
        if (menuSlider) menuSlider.scrollBy({ left: -150, behavior: "smooth" });
    };

    // ================= CART =================
   let cart = JSON.parse(localStorage.getItem('cart')) || [];

const cartIcon = document.getElementById('shopping-cart');
const cartModal = document.getElementById('cart-modal');
const cartItems = document.getElementById('cart-items');
const cartTotal = document.getElementById('cart-total');
const checkoutBtn = document.getElementById('checkout-btn');
const closeCart = document.getElementById('close-cart');

const paymentModal = document.getElementById('payment-modal');
const donePayment = document.getElementById('done-payment');
const thanksModal = document.getElementById('thanks-modal');

// Tampilkan jumlah item di icon cart
if (cartIcon) {
    const cartCount = document.createElement('span');
    cartCount.classList.add('cart-count');
    cartIcon.style.position = 'relative';
    cartIcon.appendChild(cartCount);
}

// Fungsi update cart
function updateCart() {
    if (!cartItems || !cartTotal) return;

    cartItems.innerHTML = '';
    let total = 0;

    if (cart.length === 0) {
        cartItems.innerHTML = '<li class="cart-empty">Keranjang kosong</li>';
    } else {
        cart.forEach((item, index) => {
            total += item.price * item.qty;
            cartItems.innerHTML += `
                <li class="cart-item">
                    <span>${item.name}</span>
                    <div class="cart-controls">
                        <button class="qty-btn minus" data-index="${index}">-</button>
                        <span class="qty">${item.qty}</span>
                        <button class="qty-btn plus" data-index="${index}">+</button>
                        <span class="item-price">Rp ${(item.price * item.qty).toLocaleString()}</span>
                        <button class="remove-btn" data-index="${index}">Hapus</button>
                    </div>
                </li>
            `;
        });
    }

    cartTotal.textContent = 'Rp ' + total.toLocaleString();

    // Update cart count icon
    if (cartIcon) {
        const cartCount = cartIcon.querySelector('.cart-count');
        cartCount.textContent = cart.reduce((s, i) => s + i.qty, 0);
        cartCount.style.display = cart.length ? 'flex' : 'none';
    }

    localStorage.setItem('cart', JSON.stringify(cart));

    // Event plus / minus / remove
    document.querySelectorAll('.plus').forEach(btn => {
        btn.onclick = e => {
            cart[e.target.dataset.index].qty++;
            updateCart();
        };
    });

    document.querySelectorAll('.minus').forEach(btn => {
        btn.onclick = e => {
            const i = e.target.dataset.index;
            if (cart[i].qty > 1) cart[i].qty--;
            else cart.splice(i, 1);
            updateCart();
        };
    });

    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.onclick = e => {
            cart.splice(e.target.dataset.index, 1);
            updateCart();
        };
    });
}

// Add to cart
document.querySelectorAll('.buy-btn').forEach(btn => {
    btn.onclick = () => {
        const card = btn.closest('.menu-card');
        if (!card) return;
        const name = card.querySelector('h4').textContent;
        const price = parseInt(card.querySelector('.price').textContent.replace(/\D/g, ''));
        const exist = cart.find(i => i.name === name);
        if (exist) exist.qty++;
        else cart.push({ name, price, qty: 1 });
        updateCart();
    };
});

// Toggle cart modal saat klik icon
if (cartIcon && cartModal) {
    cartIcon.addEventListener('click', e => {
        e.preventDefault();
        cartModal.style.display = cartModal.style.display === 'flex' ? 'none' : 'flex';
    });
}

// Tombol tutup modal
if (closeCart && cartModal) {
    closeCart.addEventListener('click', () => {
        cartModal.style.display = 'none';
    });
}

// Checkout modal
if (checkoutBtn && paymentModal && cartModal) {
    checkoutBtn.addEventListener('click', () => {
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        cartModal.style.display = 'none';
        paymentModal.style.display = 'flex';
    });
}

// Payment selesai
if (donePayment) {
    donePayment.addEventListener('click', () => {
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ cart })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                localStorage.removeItem('cart');
                cart = [];
                updateCart();

                if (paymentModal) paymentModal.style.display = 'none';
                if (thanksModal) thanksModal.style.display = 'flex';

                setTimeout(() => {
                    window.location.href = res.redirect;
                }, 1500);
            }
        });
    });
}


// Load cart awal
updateCart();


    // ===== SEARCH POPUP =====
const searchIcon = document.getElementById('search');
const searchPopup = document.getElementById('searchPopup');
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

if (searchIcon && searchPopup && searchInput && searchResults) {

    // toggle popup saat icon search diklik
    searchIcon.onclick = e => {
        e.preventDefault();
        searchPopup.style.display = searchPopup.style.display === 'flex' ? 'none' : 'flex';
        searchInput.focus();
    };

    // tutup popup saat klik di luar
    document.addEventListener('click', e => {
        if (!searchIcon.contains(e.target) && !searchPopup.contains(e.target)) {
            searchPopup.style.display = 'none';
        }
    });

    // event search saat tekan Enter
    searchInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') {
            e.preventDefault(); // cegah submit form atau reload

            const query = searchInput.value.trim();
            searchResults.innerHTML = '';

            if (query === '') return;

            fetch(`/search-menu?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        searchResults.innerHTML = '<li>Tidak ada hasil</li>';
                    } else {
                        // Buat container grid
                        const grid = document.createElement('div');
                        grid.classList.add('menu-grid'); // nanti styling pake CSS
                        
                        data.forEach(item => {
                            const card = document.createElement('div');
                            card.classList.add('menu-card');

                            card.innerHTML = `
                                <img src="${item.image || '/default-image.png'}" alt="${item.nama_produk}">
                                <h4>${item.nama_produk}</h4>
                                <p>${item.deskripsi || ''}</p>
                                <div class="menu-footer">
                                    <span class="price">Rp ${Number(item.harga).toLocaleString()}</span>
                                    <button class="buy-btn" data-id="${item.id}">Tambah</button>
                                </div>
                            `;

                            grid.appendChild(card);
                        });

                        searchResults.appendChild(grid);

                        // Event tombol tambah
                        grid.querySelectorAll('.buy-btn').forEach(btn => {
                            btn.onclick = () => {
                                const id = btn.dataset.id;
                                // panggil fungsi tambah ke cart
                                addToCart(id);
                            };
                        });
                    }
                })
                .catch(err => console.error(err));
        }
    });
}
function addToCart(id) {
    // logika tambah ke cart berdasarkan id menu
    console.log('Tambah ke cart menu ID:', id);
}

});
    

