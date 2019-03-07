<?php

namespace Bromo\ProductBrand\Http\Controllers;

use Bromo\ProductBrand\DataTables\ProductBrandDataTable;
use Bromo\ProductBrand\Models\ProductBrand;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class ProductBrandController extends BaseResourceController
{
    public function __construct(ProductBrand $model, ProductBrandDataTable $dataTable)
    {
        $this->module = 'product-brand';
        $this->page = 'Product Brand';
        $this->title = 'Product Brand';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [
            'name' => 'required|max:64',
            'sku_part' => 'max:4'
        ];
        $this->validateUpdateRules = [
            'name' => 'required|max:64',
            'sku_part' => 'max:4'
        ];

        parent::__construct();
    }

}
