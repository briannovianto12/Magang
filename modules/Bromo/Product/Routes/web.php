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

    Route::name('product.index')->get('/product', 'ProductController@index');
    Route::name('product.show')->get('/product/{id}', 'ProductController@show');
    Route::name('product.submited')->get('/submited', 'ProductController@submited');
    Route::name('product.rejected')->get('/rejected', 'ProductController@rejected');
    Route::name('product.approved')->get('/approved', 'ProductController@approved');

    Route::name('product.status')->put('/product-status/{id}', 'ProductController@status');

    Route::name('product.unverified')->patch('/unverified/{id}', 'ProductController@unverified');
    Route::name('product.verified')->patch('/verified/{id}', 'ProductController@verified');

    Route::resource('unit-type', 'UnitTypeController');
    Route::name('unit-type')->get('/unit-type', 'UnitTypeController@index');
    
    

});
