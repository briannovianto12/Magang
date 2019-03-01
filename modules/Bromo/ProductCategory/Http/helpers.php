<?php

if (!function_exists('getCategoryTree')) {

    function getCategoryTree($level = 1, $depth = 0)
    {
        return app('category')->treeView($level, $depth);
    }

}
