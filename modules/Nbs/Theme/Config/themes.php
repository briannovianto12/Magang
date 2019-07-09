<?php

return [
    'default' => 'metronic-admin-1',

    'themes' => [
        'metronic-admin-1' => [
            'name' => 'Metronic Admin 1',
            'views_path' => 'resources/themes/default/views',
            'assets_path' => 'themes',
        ],
    ],

    'base_format_date' => 'd-M-Y \a\t h:i A',

    'no_image' => env('NO_IMAGE', 'https://via.placeholder.com/320x320?text=No+Image'),

    'app_secure' => env('APP_SECURE', false)
];
