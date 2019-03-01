<?php

namespace Bromo\ProductCategory;

use Bromo\ProductCategory\Models\ProductCategory;

class Category
{
    private $categories;

    private $result = [];

    private $columns;

    private $level;

    private $depth;

    public function __construct()
    {
        $this->getColumn();
        $this->categories = $this->getModel()
            ->get();
    }

    private function getColumn()
    {
        $this->columns = ['id', 'parent_id', 'sku', 'name', 'level'];
    }

    private function getModel()
    {
        return ProductCategory::select($this->columns);
    }

    public function treeView($level = 1, $depth = 0)
    {
        if (count($this->categories) == 0) {
            return [];
        }

        if ($level) {
            $this->level = $level;
        }

        if ($level && $depth) {
            $this->level = $level;
            $this->depth = $depth;
        }

        foreach ($this->categories as $category) {
            if ($category['level'] == $this->level) {
                $data['id'] = $category['id'];
                $data['name'] = $category['name'];
                $data['sku'] = $category['sku'];
                $data['level'] = $category['level'];
                if (($category['level'] < $this->level + $this->depth - 1 || $this->depth == 0)) {
                    $children = $this->getChildren($category['id']);
                    if (count($children) > 0) {
                        $data['children'] = $children;
                    }
                }
                array_push($this->result, $data);
            }
        }

        return $this->result;
    }

    private function getChildren($parentId)
    {
        $result = [];
        foreach ($this->categories as $category) {

            if ($category['parent_id'] == $parentId) {
                $data['id'] = $category['id'];
                $data['name'] = $category['name'];
                $data['sku'] = $category['sku'];
                $data['level'] = $category['level'];

                if (($category['level'] < $this->level + $this->depth - 1 || $this->depth == 0)) {

                    $children = $this->getChildren($category['id']);
                    if (count($children) > 0) {
                        $data['children'] = $children;
                    }
                }

                array_push($result, $data);
            }

        }
        return $result;

    }

}