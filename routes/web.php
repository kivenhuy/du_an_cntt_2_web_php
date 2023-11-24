<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadsController;
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
Route::post("/user_registration", [LoginController::class, 'showRegisterForm'])->name('user.registration');



Route::group(['middleware' => ['auth']], function () {
    Route::get("/logout", [LoginController::class, 'logout'])->name('user.logout');


    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('homepage');
        Route::get('/product/{slug}', 'product')->name('product');
        Route::get('/terms', 'terms')->name('terms');
    });

    


    Route::controller(UploadsController::class)->group(function () {
        Route::post('/file-uploader', 'show_uploader');
        Route::post('/file-uploader/upload', 'upload');
        Route::get('/file-uploader/get_uploaded_files', 'get_uploaded_files');
        Route::post('/file-uploader/get_file_by_ids', 'get_preview_files');
        Route::get('/file-uploader/download/{id}', 'attachment_download')->name('download_attachment');
    });


    // Search
    Route::controller(SearchController::class)->group(function () {
        Route::get('/search', 'index')->name('search');
        Route::get('/search?keyword={search}', 'index')->name('suggestion.search');
        Route::post('/ajax-search', 'ajax_search')->name('search.ajax');
        // Route::get('/category/{category_slug}', 'listingByCategory')->name('products.category');
        // Route::get('/brand/{brand_slug}', 'listingByBrand')->name('products.brand');
    });


    
});


