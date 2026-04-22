<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Product;

/**
 * Controller StockMovementController
 *
 * Mengelola CRUD barang masuk & keluar di panel admin.
 * Route: /admin/stock-movements
 *
 * Method:
 *  - index()   → Menampilkan daftar semua stock movement (paginate 10)
 *  - create()  → Form tambah stock movement baru
 *  - store()   → Menyimpan stock movement + update stok produk
 *  - destroy() → Menghapus record stock movement
 */
class StockMovementController extends Controller
{
    /**
     * Menampilkan daftar barang masuk & keluar.
     * Filter berdasarkan type (in/out) jika ada query parameter.
     */
    public function index(Request $request)
    {
        $query = StockMovement::with('product')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $movements = $query->paginate(10);

        return view('admin.stock-movements.index', compact('movements'));
    }

    /**
     * Menghapus record stock movement.
     * TIDAK mengembalikan stok produk (hanya hapus record).
     */
    public function destroy($id)
    {
        $movement = StockMovement::findOrFail($id);
        $movement->delete();

        return back()->with('success', 'Record dihapus.');
    }
}