<?php

namespace Bromo\Product\Http\Controllers;

use Bromo\Product\DataTables\ProductRejectedDatatable;
use Bromo\Product\DataTables\ProductSubmitedDatatable;
use Bromo\Product\Models\Product;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{

    protected $module;

    protected $model;

    protected $title;

    /**
     * Create a new controller instance.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
        $this->module = 'product';
        $this->title = ucwords($this->module);
        $this->middleware('auth');
    }

    public function index()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("{$this->module}::list", $data);
    }

    public function submited(ProductSubmitedDatatable $datatable)
    {
        return $datatable
            ->with('model', $this->model)
            ->render("$this->module::list");
    }

    public function rejected(ProductRejectedDatatable $datatable)
    {
        return $datatable
            ->with('model', $this->model)
            ->render("$this->module::list");
    }
}
