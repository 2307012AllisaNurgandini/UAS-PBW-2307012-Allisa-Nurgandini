<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // =========================
    // TAMPILKAN DATA PRODUK
    // =========================
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();

        return view('auth.produk', compact('products', 'categories'));
    }

    // =========================
    // TAMBAH PRODUK
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'price'       => 'required|string',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // konversi harga
        $price = (int) str_replace('.', '', $request->price);

        // upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('produk', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price'       => $price,
            'stock'       => $request->stock,
            'image'       => $imagePath
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // =========================
    // UPDATE PRODUK
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'price'       => 'required|string',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = Product::findOrFail($id);

        $price = (int) str_replace('.', '', $request->price);

        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price'       => $price,
            'stock'       => $request->stock,
            'image'       => $product->image // default tetap gambar lama
        ];

        // kalau upload gambar baru
        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        $product->update($data);

        return redirect('/produk')->with('success', 'Produk berhasil diperbarui!');
    }

    // =========================
    // HAPUS PRODUK
    // =========================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect('/produk')->with('success', 'Produk berhasil dihapus!');
    }
}
