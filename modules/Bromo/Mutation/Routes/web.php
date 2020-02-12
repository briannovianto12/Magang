<?php

namespace Bromo\Mutation;

use Route;

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('mutation')->name('mutation.')->group(function () {
        Route::name('index')->get('/', 'MutationController@index');

        Route::name('payment-detail')->get('/payment-detail', 'PaymentController@index');
        Route::name('payment-detail-view')->get('/payment-detail/{id}', 'PaymentController@getPaymentDetail');
    });
});