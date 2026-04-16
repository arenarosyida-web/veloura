<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
View::composer('*', function ($view) {
    if (Auth::check()) {
        $cart = \App\Models\Cart::where('user_id', Auth::id())->first();

        $cartCount = $cart
            ? \Illuminate\Support\Facades\DB::table('cart_items')
                ->where('cart_id', $cart->cart_id)
                ->sum('quantity')
            : 0;
    } else {
        $cartCount = 0;
    }

    $view->with('cartCount', $cartCount);
});
    }
}