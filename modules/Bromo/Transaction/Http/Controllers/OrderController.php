<?php

namespace Bromo\Transaction\Http\Controllers;

use Bromo\Transaction\DataTables\CancelOrderDataTable;
use Bromo\Transaction\DataTables\DeliveredOrderDataTable;
use Bromo\Transaction\DataTables\DeliveryOrderDataTable;
use Bromo\Transaction\DataTables\ListOrderDataTable;
use Bromo\Transaction\DataTables\NewOrderDatatable;
use Bromo\Transaction\DataTables\ProcessOrderDataTable;
use Bromo\Transaction\DataTables\SuccessOrderDataTable;
use Bromo\Transaction\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use DB;

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
        $this->module = 'transaction';
        $this->title = 'Transaction';
    }

    /**
     * Display index page.
     *
     * @return Factory|View
     */
    public function index()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("{$this->module}::browse", $data);
    }

    /**
     * Get New Order data.
     * @param NewOrderDatatable $datatable
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function deliveryOrder(DeliveryOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get Order list status in delivered only.
     * @param DeliveredOrderDataTable $datatable
     * @return JsonResponse
     */
    public function deliveredOrder(DeliveredOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    /**
     * Get Order list status in success only.
     * @param SuccessOrderDataTable $datatable
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @return JsonResponse
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
     * @return Factory|View
     */
    public function show($id)
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;
        $data['data'] = Order::findOrFail($id);
        //Get seller's data
        $data['sellerData'] = $data['data']->seller->business->getOwner();
        $data['shipingCostDetails'] = null;
        if(!empty($data['data']['shipping_service_snapshot']['shipper'])){
            $data['shipingCostDetails'] = [
                'shipping_gross_amount' => $data['data']['shipping_service_snapshot']['shipper']['provider_cost'],
                'shipping_discount' => $data['data']['shipping_service_snapshot']['shipper']['platform_discount'],
                'shipping_insurance_rate' => $data['data']['shipping_service_snapshot']['shipper']['insuranceRate'],
                'use_shipping_insurance' => $data['data']['shipping_service_snapshot']['shipper']['use_insurance'],
            ];
        }
        return view("{$this->module}::detail", $data);
    }

    public function changeStatusToDelivered($id){
        $order = Order::findOrFail($id);
        DB::select("SELECT public.fs_change_order_to_delivered('$order->order_no')");

        return back();
    }

}
