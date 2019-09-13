<?php

namespace Bromo\Unverified;

use Illuminate\Database\Eloquent\Model;
use Route;

class Web extends Model {
    protected $data = 'data';
}

Route::name('unverified.index')->get('/unverified', 'UnverifiedController@index');
Route::get('/export/xlsx', 'UnverifiedController@export');