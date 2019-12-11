<?php

return [
    'name' => 'FreqAskedQuestion',
    'app_name' => env('APP_NAME','Grosenia'),
    'path' => [
        'faq' => 'faq/'
    ],
    'gcs_path' => env('GOOGLE_CLOUD_PUBLIC_URL_PREFIX','https://storage.cloud.google.com') . "/" . env('GOOGLE_CLOUD_STORAGE_BUCKET','bucket') ,
];
