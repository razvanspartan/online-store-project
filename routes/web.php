<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/products');
});
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('products/{id}', [ProductsController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/apply_coupon', [CartController::class, 'apply_coupon'])->name('cart.apply_coupon');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/order', [CheckoutController::class, 'checkout'] )->name('checkout.order');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
