<?php

if (!function_exists('snowflake_id')) {
    function snowflake_id()
    {
        return app()->make('snowflake')->generateID();
    }
}