<?php

return [
    'name' => 'Transaction',
    'path' => [
        'logo' => 'businesses/logos/',
        'buyer_avatar' => 'buyers/avatars/'
    ],
    'get_tracking_id_sleep' => env('TRACKING_ID_SLEEP', 3),
    'datatable_session_duration' => env('DATATABLE_SESSION_DURATION',3600)
];
