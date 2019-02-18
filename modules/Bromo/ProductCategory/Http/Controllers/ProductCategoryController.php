<?php

namespace Bromo\ProductCategory\Http\Controllers;

use Bromo\ProductCategory\DataTables\ProductCategoryDataTable;
use Bromo\ProductCategory\Models\ProductCategory;
use Bromo\ProductCategory\Models\ProductCategoryLevel;
use Illuminate\Http\Request;
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
        $this->validateStoreRules = [
            'ext_id' => 'required',
            'name' => 'required',
            'parent_id' => 'nullable',
            'level' => 'required',
            'sku_code' => 'nullable'
        ];

        $this->validateUpdateRules = [
            'ext_id' => 'required',
            'name' => 'required',
            'parent_id' => 'nullable',
            'level' => 'required',
            'sku_code' => 'nullable'
        ];

        $this->requiredData = [
            'categories' => ProductCategory::query()->get(),
            'level' => ProductCategoryLevel::query()->get()
        ];

        parent::__construct();
    }

    protected function modifyWhenStore(array $inputData, Request $request): array
    {
        $parent = ProductCategory::find($inputData['parent_id']);

        if($parent) {
            $inputData['ext_id'] = $parent->ext_id . '-' . $request->ext_id;
        }

        return parent::modifyWhenStore($inputData, $request);
    }
}
