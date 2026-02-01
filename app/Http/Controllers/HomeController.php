<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    // Pakai middleware auth supaya hanya login yang bisa akses
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    $menuItems = Product::latest()->get();
    return view('auth.home', compact('menuItems'));
}

}