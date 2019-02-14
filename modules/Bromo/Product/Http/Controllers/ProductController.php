<?php

namespace Bromo\Product\Http\Controllers;

use Bromo\Product\DataTables\ProductDataTable;
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

    public function index(ProductDataTable $dataTable)
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
