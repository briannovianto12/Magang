<?php

namespace Nbs\BaseResource\Facades;

use Illuminate\Support\Facades\Facade;

class SnowFlake extends Facade
{
    /**
     * Get the registered name of component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'snowflake';
    }
}