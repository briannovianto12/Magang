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

use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('lel', function () {

//    $files = Storage::disk('gcs');

    dd(Storage::url('buyers/avatars/1094722516166905856.png'));
});