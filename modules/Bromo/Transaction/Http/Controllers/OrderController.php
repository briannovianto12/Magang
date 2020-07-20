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
use Bromo\Transaction\Models\OrderPaymentInvoice;
use Bromo\Transaction\Models\OrderShippingManifest;
use Bromo\Transaction\Models\OrderShippingManifestLog;
use Bromo\Transaction\Models\OrderStatus;
use Bromo\Transaction\Models\ShippingCourier;
use Bromo\Transaction\Models\OrderImage;
use Bromo\Transaction\Services\ShipperShippingApiService;
use Bromo\Transaction\Helpers\ShippingAddressUtil;
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
use Auth;
use Image;
use Storage;


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
     * @param RejectedOrderDataTable $fidatatable
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
        $data['shippingManifest'] = null;
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

        if(!empty(Order::where('id', $id)->first()->paymentInvoice()->get())){
            $data['paymentInvoiceList'] = Order::find($id)
                                                ->paymentInvoice()
                                                ->select('order_payment_invoice.bank_account_number','order_payment_invoice.invoice_url','order_payment_invoice.status','order_payment_invoice.expiry_date')
                                                ->whereDate('order_payment_invoice.expiry_date','>',Carbon::now())
                                                ->where('order_payment_invoice.status', '=', 'PENDING')
                                                ->orderBy('order_payment_invoice.external_created_at','desc')
                                                ->get();
        }
        $data['shipping_weight'] = ceil($data['data']->shipping_weight/1000);

        $image_awb = OrderImage::where('order_trx_images.order_id', $id)
                    ->join('order_trx', 'order_trx.id', '=', 'order_trx_images.order_id')
                    ->first();
        if (!empty($image_awb)) {
            $dir = config('transaction.path.image_awb');
            $gcs_path = config('transaction.gcs_path');
            $filename = $image_awb->filename;
            $image_url = $gcs_path . $dir . $filename;
            $data['awb_image_url'] = $image_url;
        }

        if(isset($data['shippingManifest']) && $data['shippingManifest']['logistic_details_snapshot'] != null ){
            $snapshot = $data['shippingManifest']['logistic_details_snapshot'];
            $logistic_detail_snapshot = json_decode($snapshot);
            $weight = $logistic_detail_snapshot->weight;
            $shipping_cost = $logistic_detail_snapshot->total_price;
            $data['logisticDetail'] =
                [
                    'weightPackage' => $weight,
                ];
            $data['logisticDetailCost'] =
                [
                    'shippingCost' => $shipping_cost,
                ];
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

    public function changePickedUp(Request $request, $id){

        $order = Order::findOrFail($id);
        $notes = null;

        if(!empty($request->input('notes'))){
            $notes = $request->input('notes');
        }

        $user = Auth::user();
        $input_by = $user->id;
        $input_role = $user->role_id;

        DB::select("SELECT public.f_update_order_picked_up_from_false_to_true('$order->order_no','$notes','$input_by','$input_role')");

        return response()->json([
            "status" => "Success",
        ]);
    }

    public function changeStatusToSuccess(Request $request, $id){

        $order = Order::findOrFail($id);

        if($order->order_no != $request->input('orderNo')){
            return response()->json([
                "status" => "Error",
                "message" => "Order No. is not valid!"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $notes = null;
        if(!empty($request->input('notes'))){
            $notes = $request->input('notes');
        }

        $user = Auth::user();
        $input_by = $user->id;
        $input_role = $user->role_id;

        DB::select("SELECT public.f_update_order_status_from_delivered_to_success('$order->order_no','$notes','$input_by','$input_role')");

        return response()->json([
            "status" => "Success",
        ]);
    }

    public function getOrderInfo($order_id){
        $orderShippingManifest = null;
        if(OrderShippingManifest::where('order_id', $order_id)->first() != null){
            $orderShippingManifest = strval(OrderShippingManifest::where('order_id', $order_id)->first()->id);
        }

        $order = Order::where('id', $order_id)->first();
        $currWeight = ceil($order->shipping_weight/1000);
        $currCost = $order->shipping_service_snapshot['shipper']['finalRate'];
        if(!empty($orderShippingManifest)){
            if(!empty($orderShippingManifest->weight_correction) && !empty($orderShippingManifest->shipping_cost_correction)){
                $currWeight = ceil($orderShippingManifest->weight_correction/1000);
                $currCost = $orderShippingManifest->shipping_cost_correction;
            }
        }
        return response()->json([
            "data" => $orderShippingManifest,
            'order_no' => strval($order->order_no),
            "ids" => [
                'shipping_manifest_id' => $orderShippingManifest,
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

    /**
     * This one if implements using SHIPPER
     * Called by mobile to call pickup courier
     */
    public function callPickupShipper(Request $request, $order_id ) {

        $request->validate([
            'dimension_weight' => 'required',
        ]);

        // Prepare shipping api service
        $shippingServiceForShipper = new ShipperShippingApiService();

        $size = $shippingServiceForShipper->getSizeBasedOnWeight ($request->dimension_weight );
        $volume = $shippingServiceForShipper->getVolumeBasedOnSize($size);

        $user = Auth::user();

        $order = Order::findOrFail($order_id);

        $business_id = $order->shop_snapshot['business_id'];

        $seller_info = DB::select('SELECT owner_name, owner_phone FROM vw_business_contact_person as pic where business_id = ?', [$business_id]);
        $owner_name = $seller_info[0]->owner_name;
        $owner_phone = $seller_info[0]->owner_phone;

        $params = [
            // TODO PIC User only use seller id first
            // TODO No team management feature
            "shipment_pic" => $user->id, // seller id
            "pickup_date" => $request->pickup_date, // pickup date?
            "pickup_instruction" => $request->get("pickup_instruction", "-"),
            "delivery_instruction" => $request->get("delivery_instruction", "-"),
            "dimension_size" => $size,
            "dimension_weight" =>  $request->dimension_weight,
            "dimension_width" => $volume["w"],
            "dimension_height" => $volume["h"],
            "dimension_length" => $volume["l"],
            "consignee_name" => $owner_name,
            "consignee_phone_number" => $owner_phone,
        ];

        DB::beginTransaction();
        try {
            \Log::debug($order);
            \Log::debug("begin transaction");
            $shipping = OrderShippingManifest::where('order_id', $order_id)->first();
            // \Log::debug($shipping);
            // Create item shipment

            $order_params = $this->prepareOrderParams ( $order, $params );
            \Log::debug("Order params: ");
            \Log::debug($order_params);

            $orderManifest = $order->shippingManifest()->first();

            // call shipping v2 api
            $data = $this->processShipper($order_params);

            $shipper_order_id = $data['shipper_order_id'];
            $special_id = $data['special_id'];

            if($shipper_order_id == '') {
                \Log::alert('Call shipper failed with order no: '. $order->order_no);
                \Log::alert('In the meantime, please process the order manually');
            }

            if($special_id == '') {
                \Log::alert('Get shipper tracking ID failed with shipper order no: '. $shipper_order_id);
                \Log::alert('Special ID Order no: '. $order->order_no);
            }

            OrderShippingManifest::where('order_id', '=', $order_id)
            ->update([
                'tracking_id' =>  $shipper_order_id,
                'user_admin_id' => $user->id
                ]
            );

            $order->special_id = $special_id;
            $order->save();


            DB::commit();

            // nbs_helper()->flashSuccess('Manifest and item shipment has been created.');
            nbs_helper()->flashSuccess('Order has been shipped.');

            return response()->json([
                "status" => "OK",
                "airwaybill" => '', // Shipper uses special_id instead of airwaybill
                "special_id" => $special_id
            ]);

        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            \Log::info($order_params);
            report($exception);
            DB::rollBack();

            nbs_helper()->flashError('Something wen\'t wrong. Please contact Administrator');

            return response()->json([
                "status" => "FAIL",
                "error" => $exception->getMessage(),
            ]);
        }
    }

    private function processShipper ($order_params) {
        try {
            $data = [
                'shipper_order_id' => '',
                'special_id' => ''
            ];

            $shippingServiceForShipper = new ShipperShippingApiService();

            \Log::debug('Start create order');
            $shipper_order_id = $shippingServiceForShipper->createOrder($order_params);

            if($shipper_order_id == ''){
                \Log::debug('Order is not created');
                return $shipper_order_id;
            }

            $sleep_time = config('transaction.get_tracking_id_sleep');
            sleep($sleep_time);

            // get tracking id after activation
            \Log::debug('get tracking id');

            $special_id = $shippingServiceForShipper->getTrackingID($shipper_order_id);

            \Log::debug($shipper_order_id);
            if(isset($special_id)) {
                \Log::debug('Order tracking ID retrieved');
                \Log::debug('special_id:' . $special_id);

                $data = [
                    'shipper_order_id' => $shipper_order_id,
                    'special_id' => $special_id
                ];
            }

            // If successful activate the order
            \Log::debug('Start order activation');
            $activation_result = $shippingServiceForShipper->activateOrder($shipper_order_id);

            if(isset($activation_result) && isset($activation_result->status) ) {
                if ($activation_result->status != 'success') {
                    \Log::debug('Order is not activated');
                    // throw new Exception("Error activation order for Shipper: $shipper_order_id");
                }
                \Log::debug('Order activated');
                \Log::debug('Shipper order id:'. $shipper_order_id);

                // return $shipper_order_id;
            }

            return $data;

        } catch (Exception $exception){
            \Log::error($exception->getMessage());
            // Log::error
            return '';
        }
    }

    private function prepareOrderItems ( $order ) {
        $items = [];

        $order_items = $order->orderItems()->get();
        foreach ($order_items as $item){
            $items[] = [
                "name" => $item->product_name,
                "qty" => $item->qty,
                // The value if not affected by discount
                "value" => $item->payment_details->unit_price,
            ];
        }
        return $items;
    }

    private function prepareOrderParams ( $order, $params ) {
        $result = [];

        // Ignore the pickup_date

        // Set the origin location ID
        $result['o'] = ShippingAddressUtil::getLocationId($order->orig_address_snapshot);

        // Set the destination location ID
        $result['d'] = ShippingAddressUtil::getLocationId($order->dest_address_snapshot);

        // Set the length, width, height
        $result['l'] = $params['dimension_length'];
        $result['w'] = $params['dimension_width'];
        $result['h'] = $params['dimension_height'];

        // Set the weight
        $result['wt'] = $params['dimension_weight'];

        // Set the total item amount ( from $order )
        // TODO to do check if there is discount what happen
        $result['v'] = $order['payment_details']['total_gross'];

        // Set the rateID ( from order shipping_snapshot )
        $result['rateID'] = $order['shipping_service_snapshot']['shipper']['rate_id'];
        // Set the consignee info, name, phone number
        $result['consigneeName'] = $order['buyer_snapshot']['full_name'];
        $result['consigneePhoneNumber'] = $order['buyer_snapshot']['msisdn'];

        // Set the consigner info, name, phone number
        // Get from the PIC, one shop can have many PIC (user)
        $shipment_pic_id = $params['shipment_pic'];

        $result['consignerName'] = $params['consignee_name'];
        $result['consignerPhoneNumber'] = $params['consignee_phone_number'] ?? '';

        // Set the origin Address
        $result['originAddress'] = ShippingAddressUtil::getAddressDetails($order->orig_address_snapshot);

        // Set the destination Address
        $result['destinationAddress'] = ShippingAddressUtil::getAddressDetails($order->dest_address_snapshot);

        // Set the itemName as array of ( name, qty, value )
        $result['itemName'] = $this->prepareOrderItems( $order );

        // Set the contents (optional)
        $result['contents'] = '-';

        // Set the externalID - order_no
        $result['externalID'] = $order->order_no;

        // Set the packageType ( just use const SMALL_PACKAGE = 2)
        $result['packageType'] = ShipperShippingApiService::PACKAGE_TYPE_SMALL;

        // Set the cod flag to ( none - 0 )
        $result['cod'] = ShipperShippingApiService::COD_TYPE_NONE;

        // Set the useInsutance  ( from order shipping_snapshot )
        $result['useInsurance'] = $order['shipping_service_snapshot']['shipper']['use_insurance'];

        return $result;
    }

    public function updateAwbShippingManifest(Request $request, $order_id)
    {
        $new_airwaybill = $request->new_airwaybill;
        $order_no = $request->order_no;
        $id = $request->shipping_manifest_id;

        try {
            $update_airwaybill = DB::select("SELECT public.fs_update_awb_for_order_shipping_manifest('$order_no', '$new_airwaybill');");
            \Log::debug($update_airwaybill);

            if ($update_airwaybill[0]->fs_update_awb_for_order_shipping_manifest == 'OK') {


                $log = new OrderShippingManifestLog;
                $log_version = OrderShippingManifestLog::where('id', $id)->orderBy('version', 'desc')->first()->version;
                $log->id = $id;
                $log->version = $log_version+1;
                $log->modified_by = auth()->user()->id;
                $log->modifier_role = auth()->user()->role_id;
                $log->airwaybill = $new_airwaybill;
                $log->save();

                return response()->json([
                    "status" => "OK",
                    "message" => "Success! Airwaybill Updated!"
                ]);
            } else {
                return response()->json([
                    "status" => "Error",
                    "message" => "Error! Can Not Update Airwaybill!"
                ]);
            }

        } catch (\Exception $exception) {
            report($exception);
            return response()->json([
                'status' => 'Failed',
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updatePickupNumber(Request $request, $order_id)
    {
        $new_pickup_number = $request->new_pickup_number;

        DB::beginTransaction();
        try {
            $order = Order::find($order_id);
            $order->special_id = $new_pickup_number;

            $log = new OrderLog;
            $log_version = OrderLog::where('id', $order_id)->orderBy('version', 'desc')->first()->version;
            $log->id = $order_id;
            $log->version = $log_version+1;
            $log->is_picked_up = $order->is_picked_up;
            $log->special_id = $order->special_id;
            $log->modified_by = auth()->user()->id;
            $log->modifier_role = auth()->user()->role_id;
            $log->notes = 'Admin update pickup number';

            $order->save();
            $log->save();

            DB::commit();
            return response()->json([
                "status" => "OK",
                "message" => "Success! Pickup Number Updated!"
            ]);

        } catch (\Exception $exception) {
            report($exception);
            DB::rollback();

            return response()->json([
                'status' => 'Failed',
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function unRejectOrder($id){
        try{
            DB::select("SELECT f_unreject_order($id)");
            nbs_helper()->flashSuccess('Order has been unrejected.');
        }catch(\Illuminate\Database\QueryException $ex){
            nbs_helper()->flashError($ex->getMessage());
        }

        return redirect()->back();
    }

    public function uploadAwbImage($id, Request $request){
        try{
            $path = '/orders/';
            $file_awb = $request->file('file');
            $ext = $file_awb->extension();
            $file_awb_name = $file_awb->getClientOriginalName();

            //Maximum image width 800px, keep aspect ratio
            $image_awb = Image::make($file_awb);
            $image_awb->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $upload_awb = Storage::put("$path/$id/$file_awb_name", $image_awb->stream());
            if ($upload_awb === false) {
                new Exception('Error on upload');
            }

            $order_image = new OrderImage();
            $order_image->order_id = $id;
            $order_image->filename = "$id/$file_awb_name";
            $order_image->save();



            nbs_helper()->flashSuccess('Image has been uploaded.');
        } catch(Exception $e) {
            nbs_helper()->flashError($ex->getMessage());

        }
        return redirect()->back();
    }

    public function updateWeightPackage(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $shipping_courier = ShippingCourier::findOrFail($order->shipping_courier_id);

        $weight_in_kg = $request->get('weight_in_kg');
        $manifest = OrderShippingManifest::where('order_id', $order_id)->first();
        $logistic_detail_snapshot = json_decode($manifest->logistic_details_snapshot);

        if($logistic_detail_snapshot != null) {
            $shipping_fee_paid = $logistic_detail_snapshot->total_price;
            $platform_discount = $logistic_detail_snapshot->platform_discount;
            $awb_file_name = $logistic_detail_snapshot->awb_filename;
            $paket_filename = $logistic_detail_snapshot->paket_filename;

        } else {
            $shipping_fee_paid = 0;
            $platform_discount = 0;
            $awb_file_name = "-";
            $paket_filename = "";
        }

        $logistic_data = [
            "weight" => $weight_in_kg * 1000,
            "total_price" => $shipping_fee_paid,
            "platform_discount" => $platform_discount,
            "awb_filename" => $awb_file_name,
            "paket_filename" => $paket_filename,
        ];

        try {
             // weight_in_kg
            $manifest->logistic_details_snapshot = json_encode($logistic_data);
            $manifest->save();

            nbs_helper()->flashSuccess('Weight has been updated.');
        } catch(Exception $e) {
            nbs_helper()->flashError($e->getMessage());
        }
        return redirect()->back();

    }

    public function updateShippingCost(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $shipping_courier = ShippingCourier::findOrFail($order->shipping_courier_id);

        $shipping_fee_paid = $request->get('shipping_fee_paid');
        $manifest = OrderShippingManifest::where('order_id', $order_id)->first();
        $logistic_detail_snapshot = json_decode($manifest->logistic_details_snapshot);

        if($logistic_detail_snapshot != null) {
            $weight_in_kg = $logistic_detail_snapshot->weight;
            $platform_discount = $logistic_detail_snapshot->platform_discount;
            $awb_file_name = $logistic_detail_snapshot->awb_filename;
            $paket_filename = $logistic_detail_snapshot->paket_filename;

        } else {
            $weight_in_kg = '-';
            $platform_discount = 0;
            $awb_file_name = "-";
            $paket_filename = "";
        }

        $logistic_data = [
            "weight" => $weight_in_kg,
            "total_price" => $shipping_fee_paid,
            "platform_discount" => $platform_discount,
            "awb_filename" => $awb_file_name,
            "paket_filename" => $paket_filename,
        ];

        try {
             // shipping_cost
            $manifest->logistic_details_snapshot = json_encode($logistic_data);
            $manifest->save();

            nbs_helper()->flashSuccess('Shipping Cost has been updated.');
        } catch(Exception $e) {
            nbs_helper()->flashError($e->getMessage());
        }
        return redirect()->back();

    }
}

