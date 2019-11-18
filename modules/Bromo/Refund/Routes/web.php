<?php

Route::name('refund.index')->get('/refund', 'RefundController@index');
Route::name('refund.list')->get('/list', 'RefundController@refundData');
Route::name('refund.refund-order')->put('/refund/refund-order/{id}', 'RefundController@refundOrder');
Route::name('refund.info')->get('/refund/info/{id}', 'RefundController@getRefundInfo');
