<?php

namespace Bromo\Mutation;

use Route;

// Route::prefix('mutation')->group(function() {
//     Route::get('/', 'MutationController@index');
// });

Route::resource('mutation', 'MutationController');