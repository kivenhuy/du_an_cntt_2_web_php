<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Api\CheckoutSupermarketController;
use App\Http\Controllers\Api\PersonalInformationShopController;
use App\Http\Controllers\Api\PurchaseHistoryController;
use App\Http\Controllers\Api\RequestForProductController;
use App\Http\Controllers\Api\RequestSendController;
use App\Http\Controllers\Api\SuggestProductController;
use App\Http\Controllers\Api\UploadsProductController;
use App\Http\Controllers\UploadsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v2'], function () {
    Route::controller(RequestSendController::class)->group(function () {
        Route::post('/send_request/store', 'store')->name('send_request.store');
        Route::get('/send_request/get_detail/{id}', 'show')->name('send_request.get_detail');
        Route::post('/send_request/get_all', 'index')->name('send_request.get_all');
        Route::post('/send_request/add_product_to_cart', 'approve_price')->name('send_request.approve_price');
        Route::post('/send_request/reject_price', 'reject_price')->name('send_request.reject_price');
    });

    Route::controller(SuggestProductController::class)->group(function () {
        Route::get('/suggest_for_supermarket', 'suggest_for_supermarket')->name('suggest_for_supermarket');
        Route::get('/suggest_for_farm', 'suggest_for_farm')->name('suggest_for_farm');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/get_all', 'get_all_for_farm_manage')->name('categories.get_all_for_farm_manage');
    });

    Route::controller(UploadsProductController::class)->group(function () {
        Route::post('/upload_product/store', 'add_product_from_farm')->name('upload_product.add_product_from_farm');
    });

    // Route::group(['prefix' => 'checkout_supermarket'], function () {
        Route::controller(CheckoutSupermarketController::class)->group(function () {
            Route::get('/checkout_supermarket/final/{id}', 'final_checkout')->name('checkout_supermarket.final_checkout');
            Route::get('/checkout_supermarket/get_cart/{id}', 'get_cart')->name('checkout_supermarket.get_cart');
            Route::post('/checkout_supermarket/update_shipping_fee', 'update_shipping_fee')->name('checkout_supermarket.update_shipping_fee');
            Route::post('/checkout_supermarket/update_select_item', 'update_select_item')->name('checkout_supermarket.update_select_item');
            Route::post('/checkout_supermarket/update_total_shipping_fee', 'update_total_shipping_fee')->name('checkout_supermarket.update_total_shipping_fee');
            Route::post('/checkout_supermarket/checkout', 'checkout')->name('checkout_supermarket');
            Route::get('/checkout_supermarket/order_confirmed', 'order_confirmed')->name('checkout_supermarket.order_confirmed');
        });
    // });

    Route::controller(PurchaseHistoryController::class)->group(function () {
        Route::post('/purchase_history/get_all', 'index')->name('purchase_history_supermarket.get_all');
        Route::get('/purchase_history/get_detail/{id}', 'get_detail')->name('purchase_history_supermarket.get_detail');
        Route::post('/purchase_history/product_review_modal', 'product_review_modal')->name('purchase_history_supermarket.product_review_modal');
        Route::post('/purchase_history/product_review_modal/store', 'store_review')->name('purchase_history_supermarket.store_review');
    });


    Route::controller(PersonalInformationShopController::class)->group(function () {
        Route::get('/personal_information/get_detail/{id}', 'index')->name('personal_information.index');
        Route::post('/personal_information/update', 'update')->name('personal_information.update');
    });
});

