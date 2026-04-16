<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product', 'payment')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function cancel($id)
    {
        $order = Order::where('order_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('user.orders.index')
                ->with('error', 'Pesanan tidak dapat dibatalkan karena statusnya sudah ' . ucfirst($order->status) . '.');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                Product::where('product_id', $item->product_id)
                    ->increment('stock', $item->quantity);
            }
            $order->update(['status' => 'canceled']);
            $order->payment?->update(['status' => 'failed']);
        });

        return redirect()->route('user.orders.index')
            ->with('success', "Pesanan #ORD-{$order->order_id} berhasil dibatalkan.");
    }

    /**
     * Bayar ulang order yang masih pending
     */
    public function pay($id)
{
    $order = Order::with(['items.product', 'payment'])
        ->where('order_id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    if ($order->status !== 'pending' || !$order->payment) {
        return redirect()->route('user.orders.index')
            ->with('error', 'Pesanan ini tidak bisa dibayar ulang.');
    }

    // Generate midtrans_order_id BARU agar tidak konflik
    $newMidtransOrderId = 'ORD-' . $order->order_id . '-' . time();

    // Update di database
    $order->payment->update([
        'midtrans_order_id' => $newMidtransOrderId,
    ]);

    // Refresh relasi
    $order->load(['items.product', 'payment']);

    $snapToken = $this->generateSnapToken($order);

    session(['order' => $order]);

    return view('checkout.payment', compact('snapToken', 'order'));
}

    private function generateSnapToken(Order $order): string
{
    Config::$serverKey    = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized  = true;
    Config::$is3ds        = true;

    $params = [
        'transaction_details' => [
            'order_id'     => $order->payment->midtrans_order_id, // ← selalu ambil dari DB
            'gross_amount' => (int) round($order->total_price),
        ],
        'customer_details' => [
            'first_name' => $order->receiver_name,
            'phone'      => $order->phone,
            'email'      => auth()->user()->email,
        ],
        'item_details' => $order->items->map(fn($item) => [
            'id'       => (string) $item->product_id,
            'price'    => (int) round($item->price),
            'quantity' => (int) $item->quantity,
            'name'     => substr($item->product->name ?? 'Produk', 0, 50),
        ])->toArray(),
    ];

    return Snap::getSnapToken($params);
}
}