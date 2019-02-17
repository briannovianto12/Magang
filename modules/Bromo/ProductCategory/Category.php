<?php

namespace Bromo\ProductCategory;

use Bromo\ProductCategory\Models\ProductCategory;

class Category
{
    private $parents;

    private $children;

    private $result = [];

    private $columns;

    public function __construct()
    {
        $this->getColumn();
        $this->parents = $this->getModel()
            ->whereNull('parent_id')
            ->get()
            ->toArray();
        $this->children = $this->getModel()
            ->whereNotNull('parent_id')
            ->get()
            ->toArray();
    }

    private function getColumn()
    {
        $this->columns = ['id', 'ext_id', 'name', 'parent_id'];
    }

    private function getModel()
    {
        return ProductCategory::select($this->columns);
    }

    public function treeView()
    {
        if (count($this->parents) == 0) {
            return [];
        }

        foreach ($this->parents as $category) {
            if ($category['parent_id'] == null) {
                $this->result = $category;
                $this->result['child'] = $this->getChildren($category['id']);
            }
        }

        return $this->result;
    }

    private function getChildren($parentId)
    {
        $result = [];
        foreach ($this->children as $category) {
            if ($category['parent_id'] == $parentId) {
                $result[] = $category;
                $this->getChildren($category['id']);
            }
        }
        return $result;

    }

}