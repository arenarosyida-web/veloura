<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Controller DashboardController
 *
 * Menampilkan halaman dashboard admin dengan:
 * - Statistik ringkasan (products, categories, orders, customers)
 * - Produk terbaru (5 item)
 * - Data grafik barang masuk & keluar per bulan (6 bulan terakhir)
 *
 * Perubahan dari revisi:
 * - Menghapus section "Aksi Cepat" (duplikat sidebar) → dashboard lebih efisien
 * - Menambahkan data grafik stock movements untuk Chart.js
 */
class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalOrders     = class_exists(Order::class) ? Order::count() : 0;
        $totalCustomers  = User::where('role', 'customer')->count();
        $recentProducts  = Product::with('category')->latest()->take(5)->get();

        // ── Data Grafik Barang Masuk & Keluar (6 bulan terakhir) ──
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }

        $chartLabels = $months->map(function ($m) {
            return Carbon::parse($m . '-01')->translatedFormat('M Y');
        })->values()->toArray();

        // Query barang masuk per bulan
        $stockIn = StockMovement::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(quantity) as total')
            )
            ->where('type', 'in')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month');

        // Query barang keluar per bulan
        $stockOut = StockMovement::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(quantity) as total')
            )
            ->where('type', 'out')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->pluck('total', 'month');

        $chartDataIn  = $months->map(fn($m) => (int) ($stockIn[$m] ?? 0))->values()->toArray();
        $chartDataOut = $months->map(fn($m) => (int) ($stockOut[$m] ?? 0))->values()->toArray();

        // Total masuk & keluar keseluruhan
        $totalStockIn  = StockMovement::where('type', 'in')->sum('quantity');
        $totalStockOut = StockMovement::where('type', 'out')->sum('quantity');

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalCustomers',
            'recentProducts',
            'chartLabels',
            'chartDataIn',
            'chartDataOut',
            'totalStockIn',
            'totalStockOut'
        ));
    }
}