<?php

if (!function_exists('snowflake_id')) {
    function snowflake_id()
    {
        return app()->make('snowflake')->generateID();
    }
}

if (!function_exists('file_upload')) {

    function file_upload($file, $path)
    {
        $res = \Illuminate\Support\Facades\Storage::putFile($path, $file);

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

            $image = \Illuminate\Support\Facades\Storage::url($config_path . $filename);

            return $image;

        } elseif (str_contains($filename, 'http')) {

            return $filename;

        } else {

            return asset($config_path . $filename);

        }
    }
}