<?php


use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);


});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('order.destroy'); // Xóa đơn hàng
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

});

Route::get('/', function () {
    return redirect()->route('customer.products');
});
Route::get('/customer/products', [ProductController::class, 'indexUser'])->name('customer.products');
Route::get('/product/{id}', [ProductController::class, 'showCustomer'])->name('product.show');

// Các route liên quan đến giỏ hàng và thanh toán chỉ dành cho customer
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/cart/view', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/{id}/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{id}/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{id}/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/order-history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');

    Route::get('/cart/checkout', [CartController::class, 'checkoutForm'])->name('cart.checkout.form');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.processCheckout');
    // Route xem chi tiết đơn hàng
    Route::get('/order/{id}/details', [OrderController::class, 'showOrder'])->name('order.details');


});

