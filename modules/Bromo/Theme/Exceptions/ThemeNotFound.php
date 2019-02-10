<?php

namespace Bromo\Theme\Exceptions;

class ThemeNotFound extends \Exceptions
{
    public function __construct($name)
    {
        parent::__construct("Theme {$name} not Found", 1);
    }
}