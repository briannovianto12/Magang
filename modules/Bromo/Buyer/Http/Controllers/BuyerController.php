<?php

namespace Bromo\Buyer\Http\Controllers;

use Bromo\Buyer\DataTables\BuyerDataTable;
use Bromo\Buyer\Models\Buyer;
use Illuminate\Routing\Controller;

class BuyerController extends Controller
{
    protected $module;

    protected $model;
    protected $title;

    /**
     * Create a new controller instance.
     *
     * @param Buyer $buyer
     */
    public function __construct(Buyer $buyer)
    {
        $this->model = $buyer;
        $this->module = 'buyer';
        $this->title = ucwords($this->module);
        $this->middleware('auth');
    }

    public function index(BuyerDataTable $dataTable)
    {
        $data['title'] = $this->title;

        return $dataTable
            ->with([
                'module' => $this->module,
                'model' => $this->model
            ])
            ->render('buyer::list', $data);
    }
}
