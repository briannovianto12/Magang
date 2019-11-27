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

    Route::post('verify-bank-account/{bank_account}', 'SellerController@verifyBankAccount')->name('.verify-bank-account');

});

Route::get('/balance', 'SellerController@getBalanceView')->name('seller.balance');
Route::get('/balance/export/xlsx', 'SellerController@export')->name('seller.export');

Route::prefix('popular-shop')->group(function () {
    Route::name('popular-shop.index')->get('/', 'PopularShopController@index');
    Route::name('popular-shop.search')->get('/search/{shop_name}', 'PopularShopController@getRegularShop');
    Route::name('popular-shop.get-list')->get('/get-list', 'PopularShopController@getPopularShop');
    Route::name('popular-shop.add')->post('/add', 'PopularShopController@addToPopularShop');
    Route::name('popular-shop.delete')->delete('/{shop_id}', 'PopularShopController@removeFromPopularShop');
    Route::name('popular-shop.update-index')->post('/update-index', 'PopularShopController@updatePopularShopIndex');
});