<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg'
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'image'       => $image,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock
        ]);

        if ($request->stock > 0) {
            StockMovement::create([
                'product_id'  => $product->product_id,
                'type'        => 'in',
                'quantity'    => $request->stock,
                'description' => 'Stok awal produk baru',
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);

            $image         = $request->file('image')->store('products', 'public');
            $product->image = $image;
        }

        $oldStock = $product->stock;

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock
        ]);

        $newStock = $request->stock;
        if ($newStock != $oldStock) {
            $difference = $newStock - $oldStock;
            StockMovement::create([
                'product_id'  => $product->product_id,
                'type'        => $difference > 0 ? 'in' : 'out',
                'quantity'    => abs($difference),
                'description' => 'Koreksi stok via Edit Produk',
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Tidak menghapus file gambar saat soft delete
        // agar gambar tetap muncul di riwayat pesanan
        $product->delete();

        return back()->with('success', 'Product deleted');
    }

    public function updateStock(Request $request, $product_id)
    {
        $request->validate([
            'action'      => 'required|in:add,reduce',
            'amount'      => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($product_id);
        $amount  = (int) $request->amount;
        $type    = $request->action === 'add' ? 'in' : 'out';

        if ($type === 'out' && $product->stock < $amount) {
            return back()->with('error', "Stok gagal dikurangi. Stok saat ini ({$product->stock}) lebih kecil dari jumlah pengurangan ({$amount}).");
        }

        if ($type === 'in') {
            $product->increment('stock', $amount);
        } else {
            $product->decrement('stock', $amount);
        }

        StockMovement::create([
            'product_id'  => $product->product_id,
            'type'        => $type,
            'quantity'    => $amount,
            'description' => $request->description ?: 'Koreksi Stok Cepat',
        ]);

        $label = $type === 'in' ? 'ditambah' : 'dikurangi';
        return back()->with('success', "Stok produk '{$product->name}' berhasil {$label} sebanyak {$amount}.");
    }
}