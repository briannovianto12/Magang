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

    Route::prefix('disbursement')->name('disbursement')->group(function () {
        Route::name('.index')->get('/', 'DisbursementController@index');
        Route::name('.index-item')->get('/item/{header_id}', 'DisbursementController@indexItem');

        Route::name('.header')->get('/header', 'DisbursementController@datatableHeader');
        Route::name('.item')->get('/item/data/{header_id}', 'DisbursementController@datatableItem');

        Route::name('.create')->post('/create', 'DisbursementController@createDisbursement');
        Route::name('.process')->get('/process/disb/{header_id}', 'DisbursementController@processDisbursement');
        Route::name('.retry')->get('/process/disb/{header_id}/retry', 'DisbursementController@retryPaymentDetailMigration');
    });
});
