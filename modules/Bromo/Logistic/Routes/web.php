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
        Route::name('logistic.index')->get('/logistic', 'LogisticController@index');
        // Mobile Web
        Route::name('logistic.mobile-index')->get('/logistic-mobile', 'LogisticController@indexMobile');
        Route::name('logistic.show')->get('/logistic/{id}', 'LogisticController@show');
    
        Route::name('logistic.waiting-confirmation')->get('/waiting-confirmation', 'LogisticController@waitingConfirmation');
        Route::name('logistic.in-process')->get('/process', 'LogisticController@process');
        Route::name('logistic.picked-up')->get('/sent', 'LogisticController@pickedUp');
        Route::name('logistic.transaction')->get('/transaction', 'LogisticController@traditionalLogistic');

        // process
        Route::name('logistic.accept')->put('/accept/{id}', 'LogisticController@acceptPickup');
        Route::name('logistic.cancel')->put('/cancel/{id}', 'LogisticController@cancelPickup');
        Route::name('logistic.pickup')->get('/pickup/{id}', 'LogisticController@processPickup');
        Route::name('logistic.store')->post('/store-pickup/{id}', 'LogisticController@storePickupInfo');
        
        Route::name('logistic.showinfo')->get('/logistic-info/{id}', 'LogisticController@getDetailInfo');
        // Route::name('logistic.pickupinfo')->get('/pickup-info', 'LogisticController@getPickupInfo');
        // Route::name('logistic.pickup')->post('/pickup/{id}', 'LogisticController@callPickup');
    });
    