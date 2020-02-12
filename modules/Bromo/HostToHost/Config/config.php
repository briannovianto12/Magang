<?php

return [
    'api' => env('API_DOMAIN', 'localhost'),
    'credential' => env('CREDENTIAL', '1234567890'),
    'chat' => [
        'token' => env('SELLER_TOKEN', null),
        'app_id' => env('QISCUS_APP_ID', null)
    ],
    'seller_token' => env('SELLER_TOKEN', null)
];
