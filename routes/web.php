<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Customer\OrderController as UserOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StockMovementController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cek-resi', [ResiController::class, 'index'])->name('resi.index');
Route::post('/cek-resi', [ResiController::class, 'check'])->name('resi.check');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{id}', [ShopController::class, 'product'])->name('shop.product');
Route::post('/midtrans/callback', [MidtransController::class, 'callback'])->name('midtrans.callback');

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::patch('/admin/payments/{id}/confirm', [PaymentController::class, 'confirm'])->name('admin.payments.confirm');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Stock Movements History
    Route::get('/admin/stock-movements', [StockMovementController::class, 'index'])->name('admin.stock-movements.index');
    Route::delete('/admin/stock-movements/{id}', [StockMovementController::class, 'destroy'])->name('admin.stock-movements.destroy');

    // Quick Update Stok Produk
    Route::patch('/admin/products/{product}/stock', [ProductController::class, 'updateStock'])->name('admin.products.updateStock');
});

// Customer routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::patch('/my-orders/{id}/cancel', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
    Route::get('/my-orders/{id}/pay', [UserOrderController::class, 'pay'])->name('user.orders.pay');
});

require __DIR__.'/auth.php';