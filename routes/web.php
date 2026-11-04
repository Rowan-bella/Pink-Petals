<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

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
// Front-end Shop Page (Dashboard မှ Product များကို ဝင်ကြည့်ရန်)
Route::get('/shop/products', [ProductController::class, 'shopIndex'])->name('shop.products');
// Front-end Shop Page (Category အလိုက် စစ်ထုတ်ရန်)
Route::get('/shop/category/{id}', [ProductController::class, 'shopByCategory'])->name('shop.category');


// Cart Route (Auth စစ်ဆေးချက်ပါဝင်သည်)
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/order', [CheckoutController::class, 'store'])->name('checkout.store');

Route::post('/checkout/payment', [CheckoutController::class, 'paymentPage'])->name('checkout.payment');
Route::post('/checkout/store-order', [CheckoutController::class, 'storeOrder'])->name('checkout.store');