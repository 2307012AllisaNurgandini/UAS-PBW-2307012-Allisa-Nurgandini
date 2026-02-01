<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'user')->get();
        return view('auth.pelanggan', compact('customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name','email'));

        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil diupdate!');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect('/pelanggan')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
