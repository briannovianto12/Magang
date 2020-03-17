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

Route::prefix('tools')->group(function() {
    Route::name('tools.index')->get('/', 'ToolsController@index');
    Route::resource('postalCodeFinder', 'PostalCodeFinderController');
    Route::prefix('postalCodeFinder')->group(function() {
        Route::name('postalCodeFinder.getCities')->get('/province/{province_id}', 'PostalCodeFinderController@getCities');
        Route::name('postalCodeFinder.getDistricts')->get('/city/{city_id}', 'PostalCodeFinderController@getDistricts');
        Route::name('postalCodeFinder.getSubdistricts')->get('/district/{district_id}', 'PostalCodeFinderController@getSubdistricts');
        Route::name('postalCodeFinder.getPostalCode')->get('/subdistrict/{subdistrict_id}', 'PostalCodeFinderController@getPostalCode');
    });
    Route::resource('shipping-simulation', 'ShippingSimulationController')->except('show');
    Route::prefix('shipping-simulation')->group(function() {
        Route::name('shipping-simulation.simulateShipping')->get('/simulate', 'ShippingSimulationController@simulateShipping');
    });
    Route::resource('courier-business-mapping', 'CourierBusinessMappingController')->except('show');
    Route::prefix('courier-business-mapping')->group(function() {
        Route::name('courier-business-mapping.get-table')->get('/get-table', 'CourierBusinessMappingController@getTable');
        Route::name('courier-business-mapping.get-filtered-table')->get('/get-filtered-table/{courier_id}', 'CourierBusinessMappingController@getFilteredTable');
        Route::name('courier-business-mapping.get-expedition-couriers')->get('/get-expedition-couriers', 'CourierBusinessMappingController@getExpeditionCourierList');
        Route::name('courier-business-mapping.search-seller')->get('/search-seller/{keyword}', 'CourierBusinessMappingController@searchSeller');
        Route::name('courier-business-mapping.search-buyer')->get('/search-buyer/{shop_id}', 'CourierBusinessMappingController@searchBuyer');
    });

    Route::resource('blacklist-phone-number', 'BlacklistUserController')->except('show');
    Route::prefix('blacklist-phone-number')->group(function() {
        Route::name('blacklist-phone-number.get-table')->get('/blacklist-phone-number', 'BlacklistUserController@index');
        Route::name('blacklist-phone-number.post-table')->post('/blacklist-phone-number/post', 'BlacklistUserController@blacklistPhoneNumber');
    
    });
});