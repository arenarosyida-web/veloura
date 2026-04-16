<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Definisikan transisi yang diperbolehkan
        $allowedTransitions = match($order->status) {
            'pending'   => ['canceled'],
            'paid'      => ['shipped', 'completed', 'canceled'],
            'shipped'   => ['completed', 'canceled'],
            'completed' => [],
            'canceled'  => [],
            default     => [],
        };

        // Validasi status baru
        if (!in_array($request->status, $allowedTransitions)) {
            return redirect()->route('admin.orders.show', $id)
                ->with('error', "Status tidak bisa diubah dari '".ucfirst($order->status)."' ke '".ucfirst($request->status)."'.");
        }

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Status pesanan berhasil diperbarui ke ' . ucfirst($request->status) . '.');
    }
}