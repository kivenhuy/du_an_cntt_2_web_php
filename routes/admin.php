<?php

use App\Http\Controllers\Admin\CarrierController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CommuneController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\PurchaseHistoryController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\ShipperController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\RequestForProductController;
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

    Route::controller(ProvinceController::class)->group(function () {
        Route::get('/province', 'index')->name('province.index');
        Route::get('/province/create', 'create')->name('province.create');
       
        Route::get('/province/data_ajax', 'data_ajax')->name('province.data_ajax');
        Route::post("/province/store",'store')->name('province.store'); 
    });

    Route::controller(DistrictController::class)->group(function () {
        Route::get('/district', 'index')->name('district.index');
        Route::get('/district/create', 'create')->name('district.create');
        Route::get('/district/data_ajax', 'data_ajax')->name('district.data_ajax');
        Route::post("/district/store",'store')->name('district.store'); 
    });

    Route::controller(CommuneController::class)->group(function () {
        Route::get('/commune', 'index')->name('commune.index');
        Route::get('/commune/create', 'create')->name('commune.create');
        Route::get('/commune/data_ajax', 'data_ajax')->name('commune.data_ajax');
        Route::post("/commune/store",'store')->name('commune.store'); 
    });


    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'index')->name('categories.index');
        Route::get('/category/create', 'create')->name('categories.create');
        Route::get('/category/data_ajax', 'data_ajax')->name('categories.data_ajax');
        Route::post("/category/store",'store')->name('categories.store'); 
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/all', 'index')->name('admin.products.index');
        Route::get('/products/edit/{id}', 'edit')->name('admin.products.edit');
        Route::get('/products/data_ajax', 'data_ajax')->name('admin.products.data_ajax');
        Route::post('/products/approved', 'approve')->name('admin.products.approved');
    });

    Route::controller(SellerController::class)->group(function () {
        Route::get('/sellers', 'index')->name('admin.sellers.index');
        Route::get('/sellers/data_ajax', 'data_ajax')->name('admin.sellers.data_ajax');
        Route::post('/sellers/approved', 'approve_seller')->name('admin.sellers.approved');
    });

    // Enterprise
    Route::controller(EnterpriseController::class)->group(function () {
        Route::get('/enterprise', 'index')->name('admin.enterprise.index');
        Route::get('/enterprise/data_ajax', 'data_ajax')->name('admin.enterprise.data_ajax');
    });

    Route::controller(RequestForProductController::class)->group(function () {
        Route::get('/request_for_product', 'admin_index')->name('request_for_product.admin_index');
        Route::get('/request_for_product/supermarket', 'admin_supermarket_index')->name('request_for_product.admin_supermarket_index');
        Route::post('/request_for_product/approved', 'admin_approved')->name('request_for_product.admin_approved');
        Route::get('/request_for_product/admin_dataajax', 'admin_dataajax')->name('request_for_product.admin_dataajax');
        Route::get('/request_for_product/admin_supermarket_dataajax', 'admin_supermarket_dataajax')->name('request_for_product.admin_supermarket_dataajax');
    });

    // Carrier
    Route::controller(CarrierController::class)->group(function () {
        Route::post('/carriers/update_status', 'updateStatus')->name('carriers.update_status');
        Route::post('/carriers/store', 'store')->name('carriers.store');
        Route::get('/carriers/create', 'create')->name('carriers.create');
        Route::get('/carriers', 'index')->name('carriers.index');
        Route::get('/carriers/data_ajax', 'data_ajax')->name('carriers.data_ajax');
    });

    Route::controller(PurchaseHistoryController::class)->group(function () {
        Route::get('/purchase_history/all_orders', 'index')->name('admin.purchase_history.all_orders');
        Route::post('/purchase_history/verify_payment', 'verify_payment')->name('admin.purchase_history.verify_payment');
        Route::get('/purchase_history/data_ajax', 'data_ajax')->name('admin.purchase_history.data_ajax');
        Route::get('/purchase_history/get_detail/{id}', 'get_detail')->name('admin.purchase_history.get_detail');
    });

    Route::controller(ShipperController::class)->group(function () {
        Route::get('/shipper/index', 'index')->name('admin.shipper.index');
        Route::post('/shipper/approved', 'approve_shipper')->name('admin.shipper.approved');
        Route::get('/shipper/shipper_detail/{id}', 'shipper_detail')->name('admin.shipper_detail');
    });

});

Route::controller(CityController::class)->group(function () {
    Route::post('/city/filter_by_country', 'filter_by_country')->name('city.filter_by_country');
});
Route::controller(DistrictController::class)->group(function () {
    Route::post('/district/filter_by_city', 'filter_by_city')->name('district.filter_by_city');
});



