<?php

/*
|--------------------------------------------------------------------------
| Product Category Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('product-brand', 'ProductBrandController');

Route::prefix('product-brand')->name('product-brand')->group(function () {

    Route::get('/', 'ProductBrandController@index');

});

