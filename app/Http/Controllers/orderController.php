<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ===== HALAMAN ADMIN PESANAN =====
    public function index()
    {
        $orders = Order::latest()->get();
        return view('auth.pesanan', compact('orders'));
    }

    // ===== CHECKOUT DARI HOME =====
    public function checkout(Request $request)
    {
        // VALIDASI DATA
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.name' => 'required|string',
            'cart.*.price' => 'required|numeric',
            'cart.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($request->cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $order = Order::create([
                'customer_name' => auth()->user()->name,
                'total' => $total,
                'status' => 'Menunggu'
            ]);

            foreach ($request->cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'nama_produk' => $item['name'],
                    'harga' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty']
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => url('/pesanan')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Checkout gagal'
            ], 500);
        }
    }

    // ===== UPDATE STATUS =====
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect('/pesanan')->with('success', 'Status diperbarui');
    }

    // ===== HAPUS PESANAN =====
    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect('/pesanan')->with('success', 'Pesanan dihapus');
    }
}
