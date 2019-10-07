<?php

namespace Bromo\Unverified;

Route::prefix('contactcenter')->group(function() {
    Route::get('/', 'ContactCenterController@index');
});
