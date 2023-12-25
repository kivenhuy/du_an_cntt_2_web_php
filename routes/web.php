<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\RequestForProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UploadsController;
use App\Models\RequestForProduct;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/login", [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post("/login", [LoginController::class, 'login'])->name('user.login');
Route::get("/user_registration", [LoginController::class, 'showRegisterForm'])->name('user.registration_form');
Route::post("/user_registration", [LoginController::class, 'storeRegisterForm'])->name('user.registration');
Route::post("/enterprise_registration", [LoginController::class, 'storeEnterpriseForm'])->name('enterprise.registration');
Route::resource('shops', ShopController::class);


Route::group(['middleware' => ['auth']], function () {
    Route::get("/logout", [LoginController::class, 'logout'])->name('user.logout');


    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('homepage');
        Route::get('/comming-soon', 'comming_soon')->name('comming-soon');
        Route::get('/dashboard', 'dashboard')->name('user.dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/product/{slug}', 'product')->name('product');
        Route::get('/terms', 'terms')->name('terms');
    });

    

    // Upload Image
    Route::controller(UploadsController::class)->group(function () {
        Route::post('/file-uploader', 'show_uploader');
        Route::post('/file-uploader/upload', 'upload');
        Route::get('/file-uploader/get_uploaded_files', 'get_uploaded_files');
        Route::post('/file-uploader/get_file_by_ids', 'get_preview_files');
        Route::get('/file-uploader/download/{id}', 'attachment_download')->name('download_attachment');
    });

    // Purchase History
    Route::resource('purchase_history', PurchaseHistoryController::class);

    // Cart
    Route::controller(CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart');
        Route::post('/cart/addToCart', 'addToCart')->name('cart.addToCart');
        Route::post('/cart/addToCart_RFP_request', 'addToCart_RFP_request')->name('cart.addToCart_RFP_request');
        Route::post('/cart/show-cart-modal', 'showCartModal')->name('cart.showCartModal');
        Route::post('/cart/removeFromCart', 'removeFromCart')->name('cart.removeFromCart');
        Route::post('/cart/update_select_item', 'update_select_item')->name('cart.update_select_item');
        Route::post('/cart/updateQuantity', 'updateQuantity')->name('cart.updateQuantity');
    });
    

    // Address
    Route::resource('addresses', AddressController::class);
    Route::controller(AddressController::class)->group(function () {
        
    });

    // Search
    Route::controller(SearchController::class)->group(function () {
        Route::get('/search', 'index')->name('search');
        Route::get('/search?keyword={search}', 'index')->name('suggestion.search');
        Route::post('/ajax-search', 'ajax_search')->name('search.ajax');
        // Route::get('/category/{category_slug}', 'listingByCategory')->name('products.category');
        // Route::get('/brand/{brand_slug}', 'listingByBrand')->name('products.brand');
    });

    // Request for Product
    Route::controller(RequestForProductController::class)->group(function () {
        Route::get('/request_for_product', 'index')->name('request_for_product.index');
        Route::post('/request_for_product/store', 'store')->name('request_for_product.store');
        Route::get('/request_for_product/data_ajax', 'customer_dataajax')->name('request_for_product.customer_dataajax');
        Route::get('/request_for_product/get_detail/{id}', 'get_details_data')->name('request_for_product.get_details_data');
        Route::post('/request_for_product/reject_price', 'reject_price')->name('request_for_product.reject_price');
        Route::post('/request_for_product/approve_price', 'approve_price')->name('request_for_product.approve_price');
    });
    

    // Address 
    Route::resource('addresses', AddressController::class);
    Route::controller(AddressController::class)->group(function () {
        Route::post('/addresses/update/{id}', 'update')->name('addresses.update');
        Route::get('/addresses/destroy/{id}', 'destroy')->name('addresses.destroy');
        Route::get('/addresses/set_default/{id}', 'set_default')->name('addresses.set_default');
    });

    // Checkout
    Route::group(['prefix' => 'checkout'], function () {
        Route::controller(CheckoutController::class)->group(function () {
            Route::get('/final', 'final_checkout')->name('checkout.final_checkout');
            Route::post('/update_shipping_fee', 'update_shipping_fee')->name('checkout.update_shipping_fee');
            Route::post('/update_total_shipping_fee', 'update_total_shipping_fee')->name('checkout.update_total_shipping_fee');
           
        });
    });


    
});


