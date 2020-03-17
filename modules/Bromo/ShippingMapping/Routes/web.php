<?php

namespace Bromo\ShippingMapping;

use Route;

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('shippingmapping')->name('shippingmapping.')->group(function () {
        Route::name('city')->get('/city', 'ShippingMappingController@shippingmappingCity');
        Route::name('building')->get('/building', 'ShippingMappingController@shippingmappingBuilding');

        Route::name('get-logistic-city')->get('/city/search-logistic-provider','ShippingMappingController@searchLogisticCity');
        Route::name('get-logistic-building')->get('/building/search-logistic-provider','ShippingMappingController@searchLogisticBuilding');
        Route::name('get-city')->get('/city/search-city','ShippingMappingController@searchCity');
        Route::name('get-building')->get('/building/search-building','ShippingMappingController@searchBuilding');

        Route::name('create-city')->post('/city', 'ShippingMappingController@postShippingmappingCity');
        Route::name('create-building')->post('/building', 'ShippingMappingController@postShippingmappingBuilding');
        Route::name('form-city')->get('/city/form', 'ShippingMappingController@shippingmappingCityCreate');
        Route::name('form-building')->get('/building/form', 'ShippingMappingController@shippingmappingBuildingCreate');
    });
});