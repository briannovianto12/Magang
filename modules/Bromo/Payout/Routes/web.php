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

Route::prefix('payout')->group(function() {
    Route::name('payout.index')->get('/', 'PayoutController@index');
    Route::name('payout.list')->get('/list', 'PayoutController@getData');
    Route::name('payout.void')->post('/{id}/void', 'PayoutController@void');
    Route::name('payout.send-link')->post('/{id}/send-link', 'PayoutController@sendLink');
    Route::name('payout.form')->get('/create', 'PayoutController@form');
    Route::name('payout.create')->post('/', 'PayoutController@create');
    Route::name('payout.get-user')->get('/search-user','PayoutController@searchUser');
    Route::name('payout.approve')->post('/{id}/approve','PayoutController@approvePayout');
});
