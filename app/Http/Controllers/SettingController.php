<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'shop_name'   => 'Kedai Hope',
                'admin_email' => Auth::user()->email,
                'phone'       => null,
                'avatar'      => null, // default belum ada foto
            ]);
        }

        return view('auth.pengaturan', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $request->validate([
            'shop_name'   => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'avatar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'    => 'nullable|confirmed|min:6',
        ]);

        // update data setting
        $setting->update([
            'shop_name'   => $request->shop_name,
            'admin_email' => $request->admin_email,
            'phone'       => $request->phone,
        ]);

        // ===== UPLOAD AVATAR =====
        if ($request->hasFile('avatar')) {

            // hapus avatar lama
            if ($setting->avatar && Storage::exists($setting->avatar)) {
                Storage::delete($setting->avatar);
            }

            // simpan avatar baru
            $path = $request->file('avatar')->store('public/avatars');

            // update avatar di setting
            $setting->update([
                'avatar' => $path
            ]);

            // update avatar user login supaya profil ikut berubah
            Auth::user()->update([
                'avatar' => $path
            ]);
        }

        // update password user
        if ($request->filled('password')) {
            Auth::user()->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
