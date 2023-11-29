<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\ProductController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/seller/dashboard', 'index')->name('seller.dashboard');
        Route::get('/seller/profile', 'profile')->name('seller.profile.index');
        Route::get('/seller/shop/verify', 'verify')->name('seller.shop.verify');
        Route::get("/seller/logout", [LoginController::class, 'logout'])->name('seller.logout'); 
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/seller/products', 'index')->name('seller.products');
        Route::get('/seller/products/create', 'create')->name('seller.products.create');
        Route::get('/seller/products/store', 'store')->name('seller.products.store');
        // Route::get('/seller/products', 'index')->name('seller.products');
    });
});