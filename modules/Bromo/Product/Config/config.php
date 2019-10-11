<?php

return [
    'name' => 'Product',
    'path' => [
        'product' => 'products/'
    ],
    'gcs_path' => env('GOOGLE_CLOUD_PUBLIC_URL_PREFIX','https://storage.googleapis.com') . "/" . env('GOOGLE_CLOUD_STORAGE_BUCKET','bucket') ,
];
