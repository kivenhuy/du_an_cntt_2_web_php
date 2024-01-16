<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RequestForProductController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\OrderSellerController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\ShopController;
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
        Route::get('/seller/products/edit/{id}', 'edit')->name('seller.products.edit');
        Route::get('/seller/products/create', 'create')->name('seller.products.create');
        Route::get('/seller/products/data_ajax', 'data_ajax')->name('seller.products.data_ajax');
        Route::post('/seller/products/store', 'store')->name('seller.products.store');
        Route::post('/seller/products/published', 'published')->name('seller.products.published');
        Route::post('/seller/products/update/{product}', 'update')->name('seller.products.update');
        // Route::get('/seller/products', 'index')->name('seller.products');
    });

    Route::controller(RequestForProductController::class)->group(function () {
        Route::get('/seller/request_for_product', 'seller_index')->name('request_for_product.seller_index');
        Route::get('/seller/request_for_product/supermarket', 'seller_supermarket_index')->name('request_for_product.seller_supermarket_index');
        Route::get('/seller/request_for_product/seller_dataajax', 'seller_dataajax')->name('request_for_product.seller_dataajax');
        Route::get('/seller/request_for_product/seller_supermarket_dataajax', 'seller_supermarket_dataajax')->name('request_for_product.seller_supermarket_dataajax');
        Route::post('/seller/request_for_product/seller_update_price', 'seller_update_price')->name('seller.request_for_product.seller_update_price');
        Route::post('/seller/request_for_product/seller_accept_request', 'seller_accept_request')->name('seller.request_for_product.seller_accept_request');
    });

    Route::controller(ShopController::class)->group(function () {
        Route::get('/shop', 'index')->name('seller.shop.index');
        Route::post('/shop/update', 'update')->name('seller.shop.update');
        Route::get('/shop/apply_for_verification', 'verify_form')->name('seller.shop.verify');
        Route::post('/shop/verification_info_store', 'verify_form_store')->name('seller.shop.verify.store');
    });


    Route::controller(OrderSellerController::class)->group(function () {
        Route::get('/orders', 'index')->name('seller.orders.index');
        Route::get('/orders/detail/{id}', 'show')->name('seller.orders.show');
       
    });

});