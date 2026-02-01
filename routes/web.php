<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;

// ---------- Login & Register ----------
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register']);
Route::post('/proses-login', [AuthController::class, 'prosesLogin']);
Route::post('/proses-register', [AuthController::class, 'prosesRegister']);

// ---------- Semua harus login ----------
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Checkout
    Route::post('/checkout', [OrderController::class, 'checkout']);

    // ---------- Admin Routes ----------
    Route::middleware('role:admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Produk
        Route::get('/produk', [ProductController::class, 'index']);
        Route::post('/produk/tambah', [ProductController::class, 'store']);
        Route::put('/produk/{id}', [ProductController::class, 'update']);
        Route::delete('/produk/{id}', [ProductController::class, 'destroy']);

        // Pesanan
        Route::get('/pesanan', [OrderController::class, 'index']);
        Route::post('/pesanan/{id}/status', [OrderController::class, 'updateStatus'])->name('pesanan.updateStatus');
        Route::delete('/pesanan/{id}', [OrderController::class, 'destroy']);

        // Pelanggan
        Route::get('/pelanggan', [CustomerController::class, 'index']);
        Route::put('/pelanggan/update/{id}', [CustomerController::class, 'update']);
        Route::delete('/pelanggan/hapus/{id}', [CustomerController::class, 'destroy']);

        // Messages
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{id}/edit', [MessageController::class, 'edit'])->name('messages.edit');
        Route::put('/messages/{id}', [MessageController::class, 'update'])->name('messages.update');
        Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index']);

        // Pengaturan
        Route::get('/pengaturan', [SettingController::class, 'index']);
        Route::post('/pengaturan/update', [SettingController::class, 'update']);

        // Search
        Route::get('/search', [SearchController::class, 'index'])->name('search');
    });

    // ---------- User / Pelanggan Routes ----------
    Route::middleware('role:user')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    });

    // Menu search (auth + user)
    Route::get('/search-menu', [MenuController::class, 'searchMenu']);

    // Tentang Kami (publik)
    Route::get('/tentang-kami', [TentangKamiController::class, 'index'])->name('tentangkami');

    // Kontak (publik)
    Route::get('/kontak', [ContactController::class, 'index'])->name('kontak');
    Route::post('/kontak/kirim', [ContactController::class, 'store'])->name('kontak.kirim');
});
