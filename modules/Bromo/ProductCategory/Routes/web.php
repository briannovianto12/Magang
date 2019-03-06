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

Route::resource('product-category', 'ProductCategoryController');

Route::prefix('product-category')->name('product-category')->group(function () {

    Route::get('/', 'ProductCategoryController@index');
    Route::get('/{product_category}/attributes', 'ProductCategoryController@attributes')->name('.attributes');
    Route::post('/{product_category}/attributes/{id}', 'ProductCategoryController@attachAttribute')
        ->name('.attributes.attach');
    Route::delete('/{product_category}/attributes/{id}', 'ProductCategoryController@detachAttribute')
        ->name('.attributes.detach');

});