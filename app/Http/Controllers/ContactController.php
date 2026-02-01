<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ContactController extends Controller
{
    // Menampilkan halaman kontak
    public function index()
    {
        return view('auth.kontak'); // pastikan file Blade ini ada
    }

    // Menyimpan pesan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Simpan ke database
        Message::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Pesan Anda telah terkirim!');
    }
}
