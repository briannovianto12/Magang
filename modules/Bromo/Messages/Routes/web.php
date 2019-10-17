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
Route::resource('messages', 'MessagesController');

Route::prefix('messages')->group(function() {
    Route::get('/', 'MessagesController@list')->name('messages.index');
    Route::get('/search', 'MessagesController@show')->name('messages.search');
});
