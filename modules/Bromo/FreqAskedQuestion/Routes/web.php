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
Route::resource('faq', 'FreqAskedQuestionController');
Route::resource('faq-category', 'FAQCategoryController');
Route::prefix('faq')->group(function() {
    Route::get('/', 'FreqAskedQuestionController@index')->name('faq.index');
});
