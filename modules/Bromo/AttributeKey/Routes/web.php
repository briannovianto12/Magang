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



Route::resource('attribute-key', 'AttributeKeyController');

Route::prefix('attribute-key')->name('attribute-key')->group(function () {

    Route::get('/', 'AttributeKeyController@index');
    Route::delete('/{attribute_key}/options/{options}', 'AttributeKeyController@attrOptions')
        ->name('.options.destroy');


});

