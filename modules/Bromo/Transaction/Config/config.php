<?php

return [
    'name' => 'Transaction',
    'path' => [
        'logo' => 'businesses/logos/',
        'buyer_avatar' => 'buyers/avatars/',
        'image_awb' => 'orders/'
    ],
    'get_tracking_id_sleep' => env('TRACKING_ID_SLEEP', 3),
    'datatable_session_duration' => env('DATATABLE_SESSION_DURATION',3600),
    'gcs_path' => env('GOOGLE_CLOUD_PUBLIC_URL_PREFIX','https://storage.googleapis.com') . "/" . env('GOOGLE_CLOUD_STORAGE_BUCKET','grosenia-dev-assets') . "/",
];
