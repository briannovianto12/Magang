<?php

/*
|--------------------------------------------------------------------------
| Seller Route
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('store', 'SellerController');

Route::prefix('store')->name('store')->group(function () {

    Route::get('/', 'SellerController@index');

    Route::post('{id}/verify', 'SellerController@verify')->name('.verify');
    
    Route::post('{id}/reject', 'SellerController@reject')->name('.reject');

    Route::post('/token', 'SellerController@requestJwt')->name('.token');

});

Route::get('/balance', 'SellerController@getBalanceView')->name('seller.balance');
Route::get('/balance/export/xlsx', 'SellerController@export')->name('seller.export');
