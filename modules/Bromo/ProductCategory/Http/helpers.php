<?php

if (!function_exists('getCategoryTree')) {

    function getCategoryTree($level = 1, $depth = 0)
    {
        return app('category')->treeView($level, $depth);
    }

}


if (!function_exists('printTree')) {

    function printTree($tree, $value = null): string
    {
        if (!is_null($tree) && count($tree) > 0) {

            foreach ($tree as $node) {
                if (!is_null($value) && $value == $node->id) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                echo sprintf('<option id="%s" %s>%s %s</option>', $node->id, $selected, str_repeat('&mdash;', $node->level - 1), $node->name);
                if (isset($node->children)) {
                    printTree($node->children);
                }
            }

        }

        return '';
    }

}
