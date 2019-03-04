<?php

namespace Bromo\Product\Http\Controllers;

use Bromo\Product\DataTables\ProductApprovedDatatable;
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

    public function show($id)
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;
        $data['data'] = Product::findOrFail($id);

        return view("{$this->module}::detail", $data);
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
            ->with([
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render("$this->module::list");
    }

    public function rejected(ProductRejectedDatatable $datatable)
    {
        return $datatable
            ->with([
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render("$this->module::list");
    }

    public function approved(ProductApprovedDatatable $datatable)
    {
        return $datatable
            ->with([
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render("$this->module::list");
    }
}
