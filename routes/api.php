<?php

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/search-menu', function(Request $request) {
    $query = $request->q;

    if(!$query) {
        return response()->json([]);
    }

    // Cari menu berdasarkan nama (LIKE)
    $results = Menu::where('name', 'like', "%{$query}%")
                    ->limit(10) // batasi max 10 hasil
                    ->get(['id', 'name', 'price', 'image']);

    return response()->json($results);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


