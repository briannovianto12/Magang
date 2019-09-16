<?php

namespace Bromo\Unverified;

use Route;

Route::get('/export/xlsx', 'UnverifiedController@export');

Route::resource('unverified', 'UnverifiedController');
