<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;

class MenuController extends Controller
{
   public function index()
{
    $minuman = Product::whereHas('category', function ($q) {
            $q->where('name', 'Minuman');
        })->latest()->get();

        $makanan = Product::whereHas('category', function ($q) {
            $q->where('name', 'Makanan');
        })->latest()->get();

        return view('auth.menu', compact('minuman', 'makanan'));
}

public function searchMenu(Request $request)
{
    $query = $request->get('q', '');

    // ambil data langsung dari Product
    $menuItems = \App\Models\Product::where('name', 'like', "%{$query}%")
        ->take(10)
        ->get()
        ->map(function($item) {
            return [
                'id' => $item->id,
                'nama_produk' => $item->name,
                'harga' => $item->price,
                'deskripsi' => $item->description,
                'image' => $item->image 
                    ? asset('storage/' . $item->image) // jika gambar di storage/app/public
                    : asset('images/default-product.png') // fallback default
            ];
        });

    return response()->json($menuItems);
}
}
