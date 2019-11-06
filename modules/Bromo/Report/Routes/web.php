<?php

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

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('report')->name('report.')->group(function () {
        Route::name('index')->get('/', 'ReportController@index');
        Route::name('product_published')->get('/product-published', 'ReportController@ReportProductPublished');

        Route::name('shop_with_few_product')->get('/few-product', 'ReportController@getStoreRWithFewProduct');
        Route::get('/few-product/export/xlsx', 'ReportController@export')->name('shop-with-few-product.export');

        Route::name('shop_has_product')->get('/has-product', 'ReportController@getStoreThatHasProduct');
        Route::get('/has_product/export/xlsx', 'ReportController@export')->name('shop_has_product.export');

        Route::name('product_over_half_kilo')->get('/product-over-half-kilo', 'ReportController@getProductOverHalfKilo');
        Route::get('/product-over-half-kilo/export/xlsx', 'ReportController@export')->name('product-over-half-kilo.export');

        Route::name('total_buy_count')->get('/total-buy-count', 'ReportController@getTotalBuyCount');
        Route::get('/total-buy-count/export/xlsx', 'ReportController@export')->name('total-buy-count.export');

        Route::name('shop_with_active_status')->get('/active-status', 'ReportController@getStoreWithActiveStatus');
        Route::get('/active-status/export/xlsx', 'ReportController@export')->name('shop-with-active-status.export');
    });
    
});
