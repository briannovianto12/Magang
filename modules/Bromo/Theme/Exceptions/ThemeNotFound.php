<?php

namespace Bromo\Theme\Exceptions;

use Exception;

class ThemeNotFound extends Exception
{
    public function __construct($name)
    {
        parent::__construct("Theme {$name} not Found", 1);
    }
}