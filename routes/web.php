<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// 💡 အရင်က LoginController သုံးထားသော Route များကို ဖယ်ရှားလိုက်ပါပြီ 
// (Laravel Fortify မှ /login, /register, /logout များကို အလိုအလျောက် ကိုင်တွယ်ပေးပါမည်)

// Admin, Manager, Staff
Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    Route::get('/admin/categories', [CategoryController::class, 'index'])
        ->name('admin.categories');

    Route::post('/admin/categories', [CategoryController::class, 'store'])
        ->name('admin.categories.store');

    Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])
        ->name('admin.categories.update');

    Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])
        ->name('admin.categories.destroy');

    Route::get('/admin/category/{id}/products', [ProductController::class, 'byCategory'])
        ->name('admin.category.products');
});

// Admin, Manager
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/admin/dashboard', [ProductController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::resource('products', ProductController::class);
});

// Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/users', UserController::class)
        ->names('admin.users');
});

// Front-end Shop Page
Route::get('/shop/products', [ProductController::class, 'shopIndex'])->name('shop.products');
Route::get('/shop/category/{id}', [ProductController::class, 'shopByCategory'])->name('shop.category');

// Cart Route
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// 💡 Checkout & Payment Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/shipping', [CheckoutController::class, 'processShipping'])->name('checkout.shipping.process');
Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentForm'])->name('checkout.payment');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

// Admin Orders
Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});