<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('auth.dashboard', [
            // STATISTIK
            'totalProduk'     => Product::count(),
            'totalPesanan'    => Order::count(),
            'totalPelanggan'  => User::where('role', 'user')->count(),
            'totalPenjualan'  => Order::where('status','Selesai')->sum('total'),

            // DATA TABEL
            'produkTerbaru'   => Product::latest()->limit(5)->get(),
            'pesananTerbaru' => Order::latest()->limit(5)->get(),
        ]);
    }
}
