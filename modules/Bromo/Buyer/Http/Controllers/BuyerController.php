<?php

namespace Bromo\Buyer\Http\Controllers;

use Bromo\Buyer\DataTables\BuyerDataTable;
use Bromo\Buyer\Models\Buyer;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;

class BuyerController extends BaseResourceController
{
    public function __construct(Buyer $model, BuyerDataTable $dataTable)
    {
        $this->module = 'buyer';
        $this->page = 'Buyer';
        $this->title = 'Buyer';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [];
        $this->validateUpdateRules = [];

        parent::__construct();
    }
}
