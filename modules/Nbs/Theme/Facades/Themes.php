<?php

namespace Nbs\Theme\Facades;

use Illuminate\Support\Facades\Facade;

class Themes extends Facade
{
    /**
     * Get the registered name of component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'themes';
    }
}