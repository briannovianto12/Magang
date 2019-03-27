<?php

namespace Bromo\Order\Http\Controllers;

use Bromo\Order\DataTables\CancelOrderDataTable;
use Bromo\Order\DataTables\DeliveryOrderDataTable;
use Bromo\Order\DataTables\ListOrderDataTable;
use Bromo\Order\DataTables\NewOrderDatatable;
use Bromo\Order\DataTables\ProcessOrderDataTable;
use Bromo\Order\DataTables\SuccessOrderDataTable;
use Bromo\Order\Models\Order;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    protected $module;
    protected $model;
    protected $title;

    /**
     * Create a new controller instance.
     *
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->module = 'order';
        $this->title = ucwords($this->module);
        $this->middleware('auth');
    }

    /**
     * Display index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("{$this->module}::list", $data);
    }

    /**
     * Get New Order data.
     * @param NewOrderDatatable $datatable
     * @return \Illuminate\Http\JsonResponse
     */
    public function newOrder(NewOrderDatatable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get Order list status in processed.
     * @param ProcessOrderDataTable $datatable
     * @return \Illuminate\Http\JsonResponse
     */
    public function processOrder(ProcessOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get Order list status in delivery only.
     * @param DeliveryOrderDataTable $datatable
     * @return \Illuminate\Http\JsonResponse
     */
    public function deliveryOrder(DeliveryOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get Order list status in success only.
     * @param SuccessOrderDataTable $datatable
     * @return \Illuminate\Http\JsonResponse
     */
    public function successOrder(SuccessOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get Order list status in success only.
     * @param CancelOrderDataTable $datatable
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(CancelOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get Order list status in success only.
     * @param ListOrderDataTable $datatable
     * @return \Illuminate\Http\JsonResponse
     */
    public function listOrder(ListOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get the detail of product.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;
        $data['data'] = Order::findOrFail($id);

        return view("{$this->module}::detail", $data);
    }


}
