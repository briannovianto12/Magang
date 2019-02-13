<?php

namespace Bromo\Seller\Http\Controllers;

use Bromo\Seller\DataTables\SellerDataTable;
use Bromo\Seller\Models\Shop;
use Illuminate\Routing\Controller;

class SellerController extends Controller
{
    protected $module;
    protected $model;
    protected $title;

    /**
     * Create a new controller instance.
     *
     * @param Shop $shop
     */
    public function __construct(Shop $shop)
    {
        $this->model = $shop;
        $this->module = 'seller';
        $this->title = ucwords($this->module);
    }

    public function index(SellerDataTable $dataTable)
    {
        $data['title'] = $this->title;

        return $dataTable
            ->with([
                'module' => $this->module,
                'model' => $this->model
            ])
            ->render("{$this->module}::list", $data);
    }
}
