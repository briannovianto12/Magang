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
Route::name('order.delivered-order')->get('/delivered-order', 'OrderController@deliveredOrder');
Route::name('order.success-order')->get('/success-order', 'OrderController@successOrder');
Route::name('order.cancel-order')->get('/cancel-order', 'OrderController@cancelOrder');
Route::name('order.list-order')->get('/list-order', 'OrderController@listOrder');
Route::name('order.rejected-order')->get('/rejected-order', 'OrderController@rejectedOrder');
Route::name('order.accepted-order')->get('/accepted-order', 'OrderController@acceptedOrder');
Route::name('order.paid-order')->get('/paid-order', 'OrderController@paidOrder');
Route::post('/order/{id}/', 'OrderController@changeStatusToDelivered');
Route::name('order.getInfo')->get('/order-info/{order_id}', 'OrderController@getOrderInfo');
Route::name('order.edit')->put('/order/update/{id}', 'OrderController@updateShippingManifest');
Route::name('order.shipped-delivery-order')->get('/delivery-order/shipped', 'OrderController@shippedDeliveryOrder');
Route::name('order.not-shipped-delivery-order')->get('/delivery-order/not-shipped', 'OrderController@notShippedDeliveryOrder');
Route::name('order.change-status')->get('/order/change-status/{id}/', 'OrderController@changeStatusToDelivered');
Route::name('order.change-picked-up')->get('/order/change-picked-up/{id}/', 'OrderController@changePickedUp');
Route::name('order.change-order-success')->get('/order/change-order-success/{id}/', 'OrderController@changeStatusToSuccess');
Route::name('order.getInfo')->get('/shipping-manifest-info/{order_id}', 'OrderController@getShippingManifestInfo');
Route::name('order.edit')->put('/order/update/{id}', 'OrderController@updateShippingManifest');
Route::name('order.getOrderInfo')->get('/order-info/{order_id}', 'OrderController@getOrderInfo');
Route::name('order.getOrderInternalNotes')->get('/internal-notes/{order_id}', 'OrderController@getOrderInternalNotes');
Route::name('order.getOrderInternalNotesTable')->get('/internal-notes/table/{order_id}', 'OrderController@getOrderInternalNotesTable');
Route::name('order.addOrderInternalNotes')->post('/internal-notes/{order_id}', 'OrderController@addNewInternalNotes');
Route::name('order.rejectOrder')->put('/order/reject-order/{order_id}', 'OrderController@rejectOrder');
Route::name('order.unRejectOrder')->get('/order/unreject-order/{order_id}', 'OrderController@unRejectOrder');

Route::name('order.pickup')->post('/order/pickup/{order_id}', 'OrderController@callPickupShipper');
Route::name('order.updateAwbShippingManifest')->post('/order/{order_id}/update-awb', 'OrderController@updateAwbShippingManifest');
Route::name('order.uploadAWBImage')->post('/upload-awb-image/{order_id}', 'OrderController@uploadAwbImage');
Route::name('order.updateWeightPackage')->post('/update-weight-package/{id}', 'OrderController@updateWeightPackage');
Route::name('order.updateShippingCost')->post('/update-shipping-cost/{id}', 'OrderController@updateShippingCost');

