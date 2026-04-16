<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = CartItem::with('product')
            ->where('cart_id', $cart->cart_id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required|string|max:100',
            'phone'         => 'required|string|max:20',
            'full_address'  => 'required|string',
        ]);

        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = CartItem::with('product')
            ->where('cart_id', $cart->cart_id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Cek stok semua produk sebelum proses
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok '{$item->product->name}' tidak mencukupi. Tersisa: {$item->product->stock}");
            }
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $midtransOrderId = 'ORD-' . time() . '-' . auth()->id();

        // Buat order
        $order = Order::create([
            'user_id'       => auth()->id(),
            'receiver_name' => $request->receiver_name,
            'phone'         => $request->phone,
            'full_address'  => $request->full_address,
            'total_price'   => $total,
            'status'        => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->order_id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);

            Product::where('product_id', $item->product_id)
                ->decrement('stock', $item->quantity);
        }

        Payment::create([
            'order_id'          => $order->order_id,
            'midtrans_order_id' => $midtransOrderId,
            'method'            => 'ewallet',
            'amount'            => $total,
            'status'            => 'pending',
            'paid_at'           => null,
        ]);

        // Kosongkan cart
        CartItem::where('cart_id', $cart->cart_id)->delete();

        // Load ulang order
        $order->load(['items.product', 'payment']);
        session(['order' => $order]);

        // ── DEBUG: cek semua nilai sebelum request ke Midtrans ──
        $itemDetails = $cartItems->map(fn($item) => [
            'id'       => (string) $item->product_id,
            'price'    => (int) $item->product->price,
            'quantity' => (int) $item->quantity,
            'name'     => substr($item->product->name ?? 'Produk', 0, 50),
        ])->toArray();

        $itemTotal = collect($itemDetails)->sum(fn($i) => $i['price'] * $i['quantity']);

        $snapToken = $this->generateSnapToken($order, $midtransOrderId, $cartItems);

        return view('checkout.payment', compact('snapToken', 'order'));
    }

private function generateSnapToken(Order $order, string $midtransOrderId, $cartItems): string
{
   Config::$serverKey    = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized  = true;
    Config::$is3ds        = true;

    $params = [
        'transaction_details' => [
            'order_id'     => $midtransOrderId,
            'gross_amount' => (int) round($order->total_price),
        ],
        'customer_details' => [
            'first_name' => $order->receiver_name,
            'phone'      => $order->phone,
            'email'      => auth()->user()->email,
        ],
        'item_details' => $cartItems->map(fn($item) => [
            'id'       => (string) $item->product_id,
            'price'    => (int) round($item->product->price),
            'quantity' => (int) $item->quantity,
            'name'     => substr($item->product->name ?? 'Produk', 0, 50),
        ])->toArray(),
    ];

    return Snap::getSnapToken($params);
}

    public function success()
{
    $orderFromSession = session('order');

    if (!$orderFromSession) {
        return redirect()->route('shop.index');
    }

    // Load ulang dari DB agar status terbaru terbaca
    $order = Order::with(['items.product', 'payment'])
        ->find($orderFromSession->order_id);

    return view('checkout.success', compact('order'));
}
}