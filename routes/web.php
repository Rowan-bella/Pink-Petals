<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/admin/dashboard', [ProductController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::resource('products', ProductController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/users', UserController::class)
        ->names('admin.users');
});

Route::get('/shop/products', [ProductController::class, 'shopIndex'])->name('shop.products');
Route::get('/shop/category/{id}', [ProductController::class, 'shopByCategory'])->name('shop.category');


Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/shipping', [CheckoutController::class, 'processShipping'])->name('checkout.shipping.process');
Route::get('/checkout/payment', [CheckoutController::class, 'showPaymentForm'])->name('checkout.payment');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});