<?php

namespace Bromo\Seller\Http\Controllers;

use Bromo\Seller\DataTables\SellerDataTable;
use Bromo\Seller\Models\Shop;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class SellerController extends BaseResourceController
{
    public function __construct(Shop $model, SellerDataTable $dataTable)
    {
        $this->module = 'seller';
        $this->page = 'Shop';
        $this->title = 'Shop';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [
            'name' => [
                'required'
            ],
            'description' => [
                'required'
            ]
        ];
        $this->validateUpdateRules = [
            'name' => [
                'required'
            ],
            'description' => [
                'required'
            ]
        ];

        parent::__construct();
    }

}
