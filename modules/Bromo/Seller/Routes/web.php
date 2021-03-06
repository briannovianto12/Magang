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
    Route::name('.status')->put('/shop-status/{id}', 'SellerController@status');
    Route::name('.address-info')->get('{id}/business-address', 'SellerController@getBusinessAddress');
    Route::name('.edit-address-info')->put('/change-address/{id}', 'SellerController@postBusinessAddress');
    Route::name('.commission-info')->get('{id}/commission', 'SellerController@getCommissionInfo');
    Route::name('.edit-commission-info')->put('{id}/commission/post', 'SellerController@postCommission');
    Route::name('.temporary-closed')->post('{id}/temporary-closed', 'SellerController@temporaryClosed');
    Route::name('.re-open-shop')->post('{id}/re-open-shop', 'SellerController@reOpenShop');
    Route::name('.courier-info')->get('{id}/shipping-courier', 'SellerController@getShippingCourier');
    Route::name('.courier-info')->post('{id}/shipping-courier', 'SellerController@postShippingCourier');
    Route::name('.set-self-drop')->put('{id}/set-self-drop', 'SellerController@setSelfDrop');
    Route::name('.set-custom-courier')->put('{id}/set-custom-courier', 'SellerController@setCustomCourier');
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

Route::prefix('shop')->group(function () {

    Route::get('/', 'BuyerController@index');
    Route::name('description.post-table')->post('/shop/post/{id}', 'SellerController@shopDescription');
});

