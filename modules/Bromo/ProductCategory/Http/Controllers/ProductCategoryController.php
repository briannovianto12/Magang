<?php

namespace Bromo\ProductCategory\Http\Controllers;

use Bromo\ProductCategory\DataTables\ProductCategoryDataTable;
use Bromo\ProductCategory\Models\ProductCategory;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class ProductCategoryController extends BaseResourceController
{
    public function __construct(ProductCategory $model, ProductCategoryDataTable $dataTable)
    {
        $this->module = 'product-category';
        $this->page = 'Product Category';
        $this->title = 'Product Category';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [];
        $this->validateUpdateRules = [];

        parent::__construct();
    }
}
