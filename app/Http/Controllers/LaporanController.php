<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter tanggal
        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('created_at', [
                $request->start . ' 00:00:00',
                $request->end . ' 23:59:59',
            ]);
        }

        // Ambil data
        $orders = $query->orderBy('created_at','desc')->get();

        // Statistik
        $totalTransaksi  = $orders->count();
        $totalPendapatan = $orders->sum('total');

        return view('auth.laporan', compact(
            'orders',
            'totalTransaksi',
            'totalPendapatan'
        ));
    }
}
