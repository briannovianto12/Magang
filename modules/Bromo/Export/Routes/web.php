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

    Route::prefix('export')->name('export.')->group(function () {
        Route::name('index')->get('/', 'ExportController@index');

        Route::name('order_list')->get('/order-list', 'ExportController@getExportOrderList');
        Route::name('order_list_export')->get('/order-list/export/xlsx', 'ExportController@export');

        // Route::name('order_list')->get('/order-list', 'ExportController@export');
        // Route::get('/order-list/export/xlsx', 'ExportController@export')->name('order-list.export');


    });
    
});
