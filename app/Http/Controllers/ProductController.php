<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Produk::all();
        return view('products.index', compact('products'));
    }
    
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'deskripsi', 'harga', 'stok']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    
    public function show($id)
    {
        $product = Produk::findOrFail($id);
        return view('products.show', compact('product'));
    }
    
    public function edit($id)
    {
        $product = Produk::findOrFail($id);
        return view('products.edit', compact('product'));
    }
    
    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);
        
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'deskripsi', 'harga', 'stok']);

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $product = Produk::findOrFail($id);
        
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}