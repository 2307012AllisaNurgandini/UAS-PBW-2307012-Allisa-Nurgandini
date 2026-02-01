<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = strtolower($request->q);

        // Jika keyword hanya "pesanan", tampilkan semua pesanan
        $showOrders    = str_contains($keyword, 'pesanan');
        $showProducts  = str_contains($keyword, 'produk');
        $showCustomers = str_contains($keyword, 'pelanggan');

        $products = $showProducts || !$showOrders && !$showCustomers
            ? Product::where('name', 'like', "%$keyword%")
                ->orWhere('description', 'like', "%$keyword%")
                ->get()
            : collect();

        $orders = $showOrders || !$showProducts && !$showCustomers
            ? Order::where('customer_name', 'like', "%$keyword%")
                ->orWhere('status', 'like', "%$keyword%")
                ->get()
            : collect();

        $customers = class_exists(Customer::class)
            ? Customer::where('name', 'like', "%$keyword%")->get()
            : collect();

        return view('auth.search', compact(
            'keyword',
            'products',
            'orders',
            'customers'
        ));
    }
}
