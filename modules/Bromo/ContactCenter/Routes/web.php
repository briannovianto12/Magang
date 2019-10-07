<?php

namespace Bromo\ContactCenter;

use Route;

// Route::prefix('contactcenter')->group(function() {
//     Route::get('/', 'ContactCenterController@index');
// });

Route::resource('contactcenter', 'ContactCenterController');
