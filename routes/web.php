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
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\ProductRatingController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\InventoryReportController;
use App\Http\Controllers\Admin\ActivityReportController;
use App\Http\Controllers\Admin\OrderReportController;
use App\Http\Controllers\Auth\GoogleController; 
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.alt'); 
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'my'], true)) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }

    $previous = url()->previous();

    if (!$previous || str_contains($previous, '/checkout/store')) {
        return redirect()->route('home');
    }

    return redirect($previous);
})->name('lang.switch');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');  
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');  
    Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');        
    Route::get('/admin/category/{id}/products', [ProductController::class, 'byCategory'])->name('admin.category.products');        
});

Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get('/admin/dashboard', [ProductController::class, 'dashboard'])->name('admin.dashboard');      
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::resource('products', ProductController::class);
    Route::get('/admin/coupons', [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('/admin/coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::post('/admin/coupons', [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('/admin/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::put('/admin/coupons/{coupon}', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('/admin/coupons/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/users', UserController::class)->names('admin.users');
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
Route::post('/apply-coupon-ajax', [CheckoutController::class, 'applyCouponAjax'])->name('coupon.apply.ajax');
Route::post('/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('coupon.remove');
Route::get('/orders/success/{order}', [CheckoutController::class, 'success']) ->middleware('auth')->name('orders.success');

Route::middleware(['auth', 'role:admin,manager,staff'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/export', [OrderController::class, 'export'])->name('admin.orders.export');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('user.orders');
    Route::patch('/my-orders/{id}/received', [OrderController::class, 'userReceived'])->name('user.order.received');
    Route::get('/my-orders/{id}/pdf', [OrderController::class, 'downloadPdf'])->name('user.order.pdf');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/products/{id}/rating', [ProductRatingController::class, 'store'])->name('products.rating.store');
    Route::get('/products/{id}/user-rating',[ProductRatingController::class, 'getUserRating']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports/sales', [SalesReportController::class, 'index'])->name('reports.sales');
    Route::get('/reports/sales/export', [SalesReportController::class, 'exportExcel'])->name('reports.sales.export');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports/inventory', [InventoryReportController::class, 'index'])->name('reports.inventory');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports/activity', [ActivityReportController::class, 'index'])->name('reports.activity');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports/orders', [OrderReportController::class, 'index'])->name('reports.orders');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/contact-messages', [ContactController::class, 'index'])->name('contacts.index');
    Route::delete('/contact-messages/{contactMessage}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});