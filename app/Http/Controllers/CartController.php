<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => auth()->id()]);
        }

        return $cart;
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = CartItem::with('product')
            ->where('cart_id', $cart->cart_id)
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0);

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();

        $item = CartItem::where('cart_id', $cart->cart_id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'cart_id'    => $cart->cart_id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $item = CartItem::where('cart_item_id', $id)->firstOrFail();
        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove($id)
    {
        CartItem::where('cart_item_id', $id)->firstOrFail()->delete();
        return back()->with('success', 'Item berhasil dihapus.');
    }
}