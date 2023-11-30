<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth'],'prefix' => 'admin'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('admin.dashboard');
        Route::get("/logout", [LoginController::class, 'logout'])->name('admin.logout'); 
    });

    Route::controller(CountryController::class)->group(function () {
        Route::get('/country', 'index')->name('country.index');
        Route::get('/country/create', 'create')->name('country.create');
        Route::get('/country/data_ajax', 'data_ajax')->name('country.data_ajax');
        Route::post("/country/store",'store')->name('country.store'); 
    });

    Route::controller(CityController::class)->group(function () {
        Route::get('/city', 'index')->name('city.index');
        Route::get('/city/create', 'create')->name('city.create');
       
        Route::get('/city/data_ajax', 'data_ajax')->name('city.data_ajax');
        Route::post("/city/store",'store')->name('city.store'); 
    });

    Route::controller(DistrictController::class)->group(function () {
        Route::get('/district', 'index')->name('district.index');
        Route::get('/district/create', 'create')->name('district.create');
        Route::get('/district/data_ajax', 'data_ajax')->name('district.data_ajax');
        Route::post("/district/store",'store')->name('district.store'); 
    });


    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'index')->name('categories.index');
        Route::get('/category/create', 'create')->name('categories.create');
        Route::get('/category/data_ajax', 'data_ajax')->name('categories.data_ajax');
        Route::post("/category/store",'store')->name('categories.store'); 
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/all', 'index')->name('admin.products.index');
        Route::get('/products/data_ajax', 'data_ajax')->name('admin.products.data_ajax');
        Route::post('/products/approved', 'approve')->name('admin.products.approved');
    });

});

Route::controller(CityController::class)->group(function () {
    Route::post('/city/filter_by_country', 'filter_by_country')->name('city.filter_by_country');
});
Route::controller(DistrictController::class)->group(function () {
    Route::post('/district/filter_by_city', 'filter_by_city')->name('district.filter_by_city');
});
