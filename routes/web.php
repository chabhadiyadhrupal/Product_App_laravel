<?php

use App\Http\Controllers\addtocartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProductListController;


Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('collections', CollectionController::class);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('variants', VariantController::class);
    Route::resource('productlists',ProductListController::class);
    Route::resource('addtocarts',addtocartController::class);
    Route::post('/cart/add/{id}', [ProductlistController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ProductlistController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/remove/{id}', [ProductlistController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/order/buy/{id}', [ProductlistController::class, 'buyNow'])->name('order.buy');
    Route::post('/order', [ProductlistController::class, 'storeOrder'])->name('order.store');
    Route::get('/orders', [ProductlistController::class, 'allorders'])->name('allorders');
});
Auth::routes();



// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Auth::routes();
Route::delete('/variants/{variant}', [VariantController::class, 'destroy'])->name('variants.destroy');

