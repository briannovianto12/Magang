<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('snowflake_id')) {
    function snowflake_id()
    {
        return app()->make('snowflake')->generateID();
    }
}

if (!function_exists('firebase')) {
    function firebase()
    {
        return app()->make('firebase');
    }
}

if (!function_exists('file_upload')) {

    function file_upload($file, $path)
    {
        $res = Storage::putFile($path, $file);

        $filename = str_replace($path . '/', '', $res);

        return $filename;
    }
}

if (!function_exists('file_attribute')) {

    function file_attribute($path, $filename)
    {
        $config_path = config($path);
        if (is_null($filename)) {
            return config('themes.no_image');
        }

        if (in_array(config('filesystems.default'), ['s3', 'minio', 'gcs'])) {

            $image = Storage::url($config_path . $filename);

            return $image;

        } elseif (str_contains($filename, 'http')) {

            return $filename;

        } else {

            return asset($config_path . $filename);

        }
    }
}


if (!function_exists('files_attribute')) {

    function files_attribute($field, string $path, string $key = null)
    {
        if (is_null($key)) {
            $key = 'filenames';
        }

        if (is_null($field)) {
            return $field;
        }

        $images = $field[$key] ?? null;


        if ($key != 'filenames' && is_null($images)) {
            return [];
        }

        if (is_null($images)) {
            return null;
        }

        $withUrls = [];

        foreach ($images as $image) {
            if (str_contains($image, 'http')) {
                $withUrls[] = $image;
            } else if (in_array(config('filesystems.default'), ['minio', 's3', 'gcs'])) {
                $withUrls[] = Storage::url($path . $image);
            }
        }

        return $withUrls;
    }
}

if (!function_exists('present')) {
    function present($string)
    {
        return $string !== null && $string !== '';

    }
}

if (!function_exists('presence')) {

    function presence($string, $valueIfBlank = null)
    {
        return present($string) ? $string : $valueIfBlank;
    }

}