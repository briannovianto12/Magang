<?php

namespace Bromo\Transaction\Http\Controllers;

use Bromo\Auth\Models\Admin;
use Bromo\Transaction\DataTables\AcceptedOrderDataTable;
use Bromo\Transaction\DataTables\CancelOrderDataTable;
use Bromo\Transaction\DataTables\DeliveredOrderDataTable;
use Bromo\Transaction\DataTables\DeliveryOrderDataTable;
use Bromo\Transaction\DataTables\ListOrderDataTable;
use Bromo\Transaction\DataTables\NewOrderDatatable;
use Bromo\Transaction\DataTables\OrderInternalNotesDataTable;
use Bromo\Transaction\DataTables\PaidOrderDataTable;
use Bromo\Transaction\DataTables\ProcessOrderDataTable;
use Bromo\Transaction\DataTables\RejectedOrderDataTable;
use Bromo\Transaction\DataTables\SuccessOrderDataTable;
use Bromo\Transaction\Models\Order;
use Bromo\Transaction\Models\OrderDeliveryTracking;
use Bromo\Transaction\Models\OrderInternalNotes;
use Bromo\Transaction\Models\OrderLog;
use Bromo\Transaction\Models\OrderShippingManifest;
use Bromo\Transaction\Models\OrderStatus;
use Bromo\Transaction\Models\ShippingCourier;
use Bromo\Transaction\Services\ShipperShippingApiService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Bromo\HostToHost\Services\RequestService;
use DB;
use Carbon\Carbon;

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
     * Get Order list where status is Rejected only.
     * @param RejectedOrderDataTable $datatable
     * @return JsonResponse
     */
    public function rejectedOrder(RejectedOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    public function acceptedOrder(AcceptedOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    public function paidOrder(PaidOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    public function shippedDeliveryOrder(DeliveryOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module,
            'is_shipped' => true
        ])->ajax();
    }

    public function notShippedDeliveryOrder(DeliveryOrderDataTable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module,
            'is_shipped' => false
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
        $data['deliveryTrackings'] = null;
        if($data['data']->shippingCourier->provider_id == ShippingCourier::SHIPPING_PROVIDER_KURIR_EKSPEDISI || $data['data']->shippingCourier->provider_id == ShippingCourier::SHIPPING_PROVIDER_NINJAVAN){
            $data['unsupportedShipper'] = true;
        }
        if(!empty($data['data']['shipping_service_snapshot']['shipper'])){
            if ( empty($data['data']['shipping_service_snapshot']['shipper']['use_insurance']) ) {
                $data['shippingInsuranceRate'] = 0;
            } else {
                $data['shippingInsuranceRate'] = $data['data']['shipping_service_snapshot']['shipper']['insuranceRate'];
            }

            $data['shipingCostDetails'] = [
                'shipping_gross_amount' => $data['data']['shipping_service_snapshot']['shipper']['provider_cost'],
                'shipping_discount' => $data['data']['shipping_service_snapshot']['shipper']['platform_discount'],
            ];
        }
        if(!empty(OrderDeliveryTracking::where('order_id', $id)->first())){
            $deliveryTrackings = OrderDeliveryTracking::where('order_id', $id)->orderBy('created_at')->get();
            foreach($deliveryTrackings as $key => $deliveryTracking){
                $deliveryTrackings[$key]['data_json'] = json_decode($deliveryTracking->data_json);
            }
            $data['deliveryTrackings'] = $deliveryTrackings;
        }
        if(!empty(OrderShippingManifest::where('order_id', $id)->first())){
            $data['shippingManifest'] = OrderShippingManifest::where('order_id', $id)->first();
        }
        
        return view("{$this->module}::detail", $data);
    }

    public function changeStatusToDelivered(Request $request, $id){

        $order = Order::findOrFail($id);
        DB::select("SELECT public.fs_change_order_to_delivered('$order->order_no')");

        $notes = "Order has been delivered";
        if(!empty($request->input('notes'))){
            $notes = $request->input('notes');
        }

        $log = OrderLog::select()
                        ->orderBy('updated_at', 'desc')
                        ->first();
        $log->modified_by = auth()->user()->id;
        $log->modifier_role = auth()->user()->role_id;
        $log->notes = $notes;
        $log->save();

        return response()->json([
            "status" => "Success",
        ]);
    }

    public function getOrderInfo($order_id){
        $orderShippingManifest = OrderShippingManifest::where('order_id', $order_id)->first();
        $order = Order::where('id', $order_id)->first();
        $currWeight = ceil($order->shipping_weight/1000);
        $currCost = $order->shipping_service_snapshot['shipper']['finalRate'];
        if(!empty($orderShippingManifest->weight_correction) && !empty($orderShippingManifest->shipping_cost_correction)){
            $currWeight = ceil($orderShippingManifest->weight_correction/1000);
            $currCost = $orderShippingManifest->shipping_cost_correction;
        }
        return response()->json([
            "data" => $orderShippingManifest,
            'order_no' => strval($order->no),
            "ids" => [
                'shipping_manifest_id' => strval($orderShippingManifest->id),
            ],
            "curr_detail" => [
                'curr_weight' => $currWeight,
                'curr_cost' => $currCost,
            ],
        ]);
    }

    public function updateShippingManifest(Request $request)
    {
        $orderShippingManifestId = $request->shippingmanifest;
        $newweight = $request->newweight;
        $newcost = $request->newcost;
        $shippingManifest = OrderShippingManifest::find($orderShippingManifestId);
        $shippingManifest->weight_correction = $newweight;
        $shippingManifest->shipping_cost_correction = $newcost;
        $shippingManifest->save();
        $service = new ShipperShippingApiService();
        try {
            $new_weight = $newweight/1000;
            return $service->updateOrder($shippingManifest->tracking_id, $new_weight);
        }catch (\Exception $exception) {
            report($exception);
            return response()->json([
                'status' => 'Failed',
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function rejectOrder(Request $request, $id){

        $notes = $request->input('reject_notes');

        $order = Order::findOrFail($id);
        $order->status = OrderStatus::REJECTED;
        
        $log = new OrderLog;
        $log_version = OrderLog::where('id', $id)->orderBy('version', 'desc')->first()->version;
        $log->id = $id;
        $log->version = $log_version+1;
        $log->modified_by = auth()->user()->id;
        $log->modifier_role = auth()->user()->role_id;
        $log->notes = $notes;
        
        $order->save();
        $log->save();

        return response()->json([
            "status" => "Success",
        ]);
    }

    public function getOrderInternalNotes($order_id, OrderInternalNotes $model, OrderInternalNotesDataTable $datatable)
    {
        //$internal_notes = OrderInternalNotes::where('order_id', $order_id)->orderBy('created_at', 'desc')->get();
        $order_no = Order::where('id', $order_id)->first()->order_no;

        return response()->json([
            "order_no" => $order_no
        ]);
    }

    public function getOrderInternalNotesTable($order_id, OrderInternalNotes $model, OrderInternalNotesDataTable $datatable){
        return $datatable->with([
            'model' => $model,
            'order_id' => $order_id,
        ])->ajax();
    }

    public function addNewInternalNotes(Request $request, $order_id)
    {
        $new_internal_notes = new OrderInternalNotes;
        $new_internal_notes->order_id = $order_id;
        $new_internal_notes->internal_notes = $request->input('notes');
        $new_internal_notes->inputted_by = auth()->user()->id;
        $new_internal_notes->inputter_role = auth()->user()->role_id;
        $new_internal_notes->save();

        return response()->json([
            "status" => "Success",
        ]);
    }

}

