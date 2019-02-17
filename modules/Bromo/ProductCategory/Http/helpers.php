<?php

if (!function_exists('getCategoryTree')) {

    function getCategoryTree()
    {
        return app('category')->treeView();
    }

}
