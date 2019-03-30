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

Route::name('order.index')->get('/order', 'OrderController@index');
Route::name('order.show')->get('/order/{id}', 'OrderController@show');
Route::name('order.new-order')->get('/new-order', 'OrderController@newOrder');
Route::name('order.process-order')->get('/process-order', 'OrderController@processOrder');
Route::name('order.delivery-order')->get('/delivery-order', 'OrderController@deliveryOrder');
Route::name('order.success-order')->get('/success-order', 'OrderController@successOrder');
Route::name('order.cancel-order')->get('/cancel-order', 'OrderController@cancelOrder');
Route::name('order.list-order')->get('/list-order', 'OrderController@listOrder');

#Route::name('product.show')->get('/product/{id}', 'ProductController@show');
#Route::name('product.submited')->get('/submited', 'ProductController@submited');
#Route::name('product.rejected')->get('/rejected', 'ProductController@rejected');
#Route::name('product.approved')->get('/approved', 'ProductController@approved');
#Route::name('product.unverified')->patch('/unverified/{id}', 'ProductController@unverified');
#Route::name('product.verified')->patch('/verified/{id}', 'ProductController@verified');
