<?php

use App\Http\Controllers\Admin\CategoryController;
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

    // Route::controller(UploadsController::class)->group(function () {
    //     Route::post('/upload_product/store', 'add_product_from_farm')->name('upload_product.add_product_from_farm');
    // });
});

