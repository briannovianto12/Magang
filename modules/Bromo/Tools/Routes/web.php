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
    Route::resource('shipping-simulation', 'ShippingSimulationController')->except('show');;
    Route::prefix('shipping-simulation')->group(function() {
        Route::name('shipping-simulation.simulateShipping')->get('/simulate', 'ShippingSimulationController@simulateShipping');
    });
});