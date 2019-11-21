<?php

namespace Bromo\Banner;

use Route;

// Route::prefix('banner')->group(function() {
//     Route::get('/', 'BannerController@index');
// });

Route::resource('banner', 'BannerController');
