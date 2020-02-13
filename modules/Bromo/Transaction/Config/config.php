<?php

return [
    'name' => 'Transaction',
    'path' => [
        'logo' => 'businesses/logos/',
        'buyer_avatar' => 'buyers/avatars/'
    ],
    'get_tracking_id_sleep' => env('TRACKING_ID_SLEEP', 3)
];
