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

Route::name('login')->get('/login', 'LoginController@form');
//Route::name('post.login')->post('/login', 'LoginController@login');
Route::name('post.login')->post('/login', 'LoginController@login');

Route::group(['middleware' => 'auth'], function () {
    Route::name('logout')->post('/logout', 'LoginController@logout');

    Route::name('update-password')->get('/update-password', 'UpdatePasswordController@index');
    Route::name('post.update-password')->post('/update-password', 'UpdatePasswordController@create');

    Route::name('dashboard')->get('/dashboard', 'DashboardController@index');
});
