<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class UserProductController extends Controller
{
    public function index()
    {
        $products = Produk::latest()->paginate(12);
        return view('user.products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Produk::with(['comments.user'])->findOrFail($id);
        return view('user.products.show', compact('product'));
    }
}
