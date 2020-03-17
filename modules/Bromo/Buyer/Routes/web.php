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
Route::resource('buyer', 'BuyerController');

Route::prefix('buyer')->name('buyer')->group(function () {

    Route::get('/', 'BuyerController@index');   
    Route::get('/{id}/blacklist-user','BuyerController@blacklistUser')->name('.blacklist');
    
});

