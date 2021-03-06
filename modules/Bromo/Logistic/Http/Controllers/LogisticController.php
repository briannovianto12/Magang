<?php

namespace Bromo\Logistic\Http\Controllers;

use Bromo\Logistic\DataTables\OrderDatatable;
use App\Http\Controllers\Controller;
use Bromo\Transaction\Models\Order;
use Bromo\Transaction\Models\OrderStatus;
use Bromo\Transaction\Models\OrderLog;
use Bromo\Transaction\Models\ShippingCourier;
use Bromo\Transaction\Models\OrderShippingManifest;
use Bromo\Auth\Models\Admin;

use Bromo\Logistic\Entities\TraditionalLogisticStatus;
use Bromo\Logistic\Entities\LogisticTrxImages;
use Bromo\Auth\Models\UserProfile;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Jenssegers\Date\Date;
use Modules\Bromo\HostToHost\Services\RequestService;
use Image;
use Illuminate\Support\Facades\Storage;

class LogisticController extends Controller
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
        $this->middleware('auth');
        $this->model = $model;
        $this->module = 'logistic';
        $this->title = 'Traiditonal Logistic';
    }

    /**
     * Load order datatable.
     *
     * @param $status
     * @return mixed
     */
    private function load(array $status)
    {
        $datatable = new OrderDatatable();

        return $datatable
            ->with([
                'model' => $this->model,
                'module' => $this->module,
                'status' => $status
            ])->render("$this->module::browse");
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
     * Display index page for mobile web.
     *
     * @return Factory|View
     */
    public function indexMobile()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("{$this->module}::browse-mobile", $data);
    }

    /**
     * Get confirmation order datatable.
     *
     * @return mixed
     */
    public function waitingConfirmation()
    {
        return $this->load([
            TraditionalLogisticStatus::WAITING_PICKUP,
        ]);
    }

    /**
     * Get process order datatable.
     *
     * @return mixed
     */
    public function process()
    {
        return $this->load([
            TraditionalLogisticStatus::IN_PROCESS_PICKUP,
        ]);
    }

    /**
     * Get sent order datatable.
     *
     * @return mixed
     */
    public function pickedUp()
    {
        return $this->load([
            TraditionalLogisticStatus::PICKED_UP,
        ]);
    }

    /**
     * Get transaction order datatable.
     *
     * @return mixed
     */
    public function traditionalLogistic()
    {
        return $this->load([
            TraditionalLogisticStatus::WAITING_PICKUP,
            TraditionalLogisticStatus::IN_PROCESS_PICKUP,
            TraditionalLogisticStatus::PICKED_UP,
        ]);
    }

    /**
     * Get detail info by order_id
     *
     */
    public function getDetailInfo ( $order_id ) {

        $order = Order::findOrFail( $order_id );
        $shipping_manifest = OrderShippingManifest::where( 'order_id', $order_id )->first();
        $admin = Admin::where('id', $shipping_manifest->user_admin_id)->first();
        // dd($shipping_manifest->pickup_details_snapshot);
        if($admin==null){
            $admin_name ='';
        } else {
            $admin_name = $admin->name;
        }

        $shop_info = DB::table('order_trx')
            ->select('shop.name as name', 'user_profile.msisdn as msisdn',
            "order_trx.notes as notes",
            "order_trx.orig_address_snapshot->building_name as building_name",
            "order_trx.orig_address_snapshot->address_line as address_line"
            )
            ->join('shop', 'order_trx.shop_id', '=', 'shop.id')
            ->join('business', 'shop.business_id', '=', 'business.id')
            ->join('business_member', 'shop.business_id', '=', 'business_member.business_id')
            ->join('user_profile', 'user_profile.id', '=', 'business_member.user_id')
            ->where('order_trx.id', $order_id)
            ->first();

        $pickup_details = json_decode($shipping_manifest->pickup_details_snapshot);
        $courier_info = [
            "courier_name" => $order->shipping_service_snapshot['shipper']['name'],
            "expected_date" => $pickup_details->pickup_date,
            "pickup_instruction" => $pickup_details->pickup_instruction,
        ];

        $destination_info = [
            "full_name" => $order->buyer_snapshot['full_name'],
            "msisdn" => $order->buyer_snapshot['msisdn'],
            "address_line" => $order->dest_address_snapshot['address_line'],
            "building_name" => $order->dest_address_snapshot['building_name']
        ];

        // Get order info
        $order_description = \DB::select("SELECT f_get_order_description ($order_id)");
        $order_info = [
            "description" => current($order_description)->f_get_order_description,
            "system_weight" => $shipping_manifest->weight * 0.001,
        ];

        $order_images = DB::table('order_trx_images')
            ->select( "filename as filename")
            ->where('order_trx_images.order_id', $order_id)
            ->get();

        $array_order_images = [];
        if(count($order_images) > 0) {
            foreach($order_images as $image) {
                $array_order_images[] = config('logistic.gcs_path') . '/orders/' . $image->filename;
            }
        }

        $data = [
            "order" => $order,
            "shop_info" => $shop_info,
            "courier_info" => $courier_info,
            "destination_info" => $destination_info,
            "order_info" => $order_info,
            "pickup_status" => $shipping_manifest->logistic_organizer_status,
            "penjemput" => $admin_name,
            "images" => $array_order_images,
        ];

        return view("{$this->module}::detail-mobile", $data);
    }

    /**
     * Request for accept logistic.
     *
     * @param $id
     * @return Response
     */
    public function acceptPickup( Request $request, $order_id )
    {
        try {
            $user_id = \Auth::user()->id;

            OrderShippingManifest::where('order_id', '=', $order_id)
            ->update([
                'logistic_organizer_status' => TraditionalLogisticStatus::IN_PROCESS_PICKUP,
                'user_admin_id' => $user_id
                ]
            );

            nbs_helper()->flashSuccess('Penjemputan Diterima.');

        } catch (\Exception $exception) {
            report($exception);

            nbs_helper()->flashError($exception->getMessage() ?? 'Something wen\'t wrong. Please contact Administrator');
        }

        if($request->ajax()){
            return response()->json([ "status" => "OK" ]);
        }

        return redirect()->route('logistic.show', $order_id);
    }

    /**
     * Request for accept logistic.
     *
     * @param $id
     * @return Response
     */
    public function cancelPickup( Request $request, $order_id )
    {
        try {
            $user_id = \Auth::user()->id;

            OrderShippingManifest::where('order_id', '=', $order_id)
            ->update([
                'logistic_organizer_status' => TraditionalLogisticStatus::WAITING_PICKUP,
                'user_admin_id' => null
                ]
            );

            nbs_helper()->flashSuccess('Penjemputan Dibatalkan.');

        } catch (\Exception $exception) {
            report($exception);

            nbs_helper()->flashError($exception->getMessage() ?? 'Something wen\'t wrong. Please contact Administrator');
        }

        if($request->ajax()){
            return response()->json([ "status" => "OK" ]);
        }

        return redirect()->route('logistic.show', $order_id);
    }

    /**
     * Request for process logistic.
     *
     * @param $id
     * @return Response
     */
    public function processPickup( Request $request, $order_id )
    {
        $order = Order::findOrFail($order_id);
        $shipping_manifest = OrderShippingManifest::where('order_id', '=', $order_id)->first();

        $data = [
            "order_id" => $order_id,
            "order_no" => $order->order_no,
            "shop_name" => $order->shop_snapshot['name'],
            "Ekspedisi" => $order->shipping_service_snapshot['shipper']['name'],
            "penerima" => $order->buyer_snapshot['full_name'],
            "address_line" => $order->dest_address_snapshot['address_line'],
            "building_name" => $order->dest_address_snapshot['building_name']
        ];

        return view("{$this->module}::form-mobile", $data);
    }

    /**
     * Request for process logistic.
     *
     * @param $id
     * @return Response
     */
    public function storePickupInfo( Request $request, $order_id )
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($order_id);

            $path = '/orders/';

            $file_paket = $request->file('paket_image');
            $ext = $file_paket->extension();
            $file_paket_name = $file_paket->getClientOriginalName();

            $image_paket = Image::make($file_paket);

            $file_awb = $request->file('awb_image');
            $ext = $file_awb->extension();
            $file_awb_name = $file_awb->getClientOriginalName();

            $image_awb = Image::make($file_awb);

            $upload_paket = Storage::put("$path/$order_id/$file_paket_name", $image_paket->stream());
            if ($upload_paket === false) {
                new Exception('Error on upload');
            }
            $upload_awb = Storage::put("$path/$order_id/$file_awb_name", $image_awb->stream());
            if ($upload_awb === false) {
                new Exception('Error on upload');
            }

            $data = [
                "weight" => $request->weight,
                "total_price" => str_replace('.', '', $request->total_price),
                "platform_discount" => str_replace('.', '', $request->platform_discount),
                "awb_filename" => "$order_id/$file_awb_name",
                "paket_filename" => "$order_id/$file_paket_name",
            ];

            $airwaybill = ($request->airwaybill) ? $request->airwaybill : '';

            OrderShippingManifest::where('order_id', '=', $order_id)
            ->update([
                'airwaybill' => $airwaybill,
                'logistic_details_snapshot' => json_encode($data),
                'logistic_organizer_status' => TraditionalLogisticStatus::PICKED_UP,
                ]
            );

            $order->shippedOrder();

            $logistic_images = new LogisticTrxImages;
            $logistic_images->order_id = $order_id;
            $logistic_images->filename = "$order_id/$file_paket_name";
            $logistic_images->save();

            $logistic_images = new LogisticTrxImages;
            $logistic_images->order_id = $order_id;
            $logistic_images->filename = "$order_id/$file_awb_name";
            $logistic_images->save();

            DB::commit();
            nbs_helper()->flashSuccess('Penjemputan Diterima.');

        } catch (\Exception $exception) {
            report($exception);
            DB::rollBack();

            nbs_helper()->flashError($exception->getMessage() ?? 'Something wen\'t wrong. Please contact Administrator');
        }

        return redirect()->route('logistic.mobile-index');
    }

    public function indexLogisticSpreadsheet()
    {
        $data['title'] = $this->title;
        return view("logistic::logistic-spreadsheet", $data);
    }

    public function getLogisticInfo(Request $request)
    {
        //get input value
        $value = $request->get('input');
        //get data order
        $order = Order::whereIn('order_no', $value)->get();

        if(!$order) {
            return response()->json([
                "status" => "Failed",
            ], 400);
        }

        //init new variable for respons
        $list = [];
        $message = "";

        foreach($order as $key => $value)
        {
            if($value->status < OrderStatus::SHIPPED){
                $message = "Seller didn't call pickup courier for this order";
            }

            if($value->status > OrderStatus::SHIPPED && $value->is_picked_up == true) {
                $message = "This order already on shipment";
            }

            if($value->status == OrderStatus::SHIPPED) {
                $message = "";
            }

            $temp = [
                "shop_name" => $value->shop_snapshot['name'],
                "system_price" => number_format($value->shipping_service_snapshot['shipper']['finalRate'], 0, 0, '.'),
                "system_weight" => ceil($value->shipping_weight/1000),
                "platform_discount" => number_format($value->shipping_service_snapshot['shipper']['platform_discount'], 0, 0, '.'),
                "status" => $value->status,
                "is_picked_up" => $value->is_picked_up,
                "real_weight" => 0,
                "real_price"=> 0,
                "message" => $message
            ];

            $list[] = $temp;
        }

        $result = [
            "status"    => "success",
            "data"      => $list
        ];

        return json_encode($result);
    }

    public function submitLogisticData(Request $request)
    {
        $user_id = \Auth::user()->id;
        $role_id = \Auth::user()->role_id;

        $data = $request['data'];
        \DB::beginTransaction();
        try {
            for($index = 0; $index < count($data); $index++) {
                $order_no = $data[$index]['order_no'];
                $airwaybill = $data[$index]['airwaybill'];
                $real_price = $data[$index]['real_price'];
                $real_weight = $data[$index]['real_weight']*1000;
                $message = $data[$index]['message'];

                Order::where('order_no',$data[$index]['order_no'])->update(['is_picked_up' => true]);
                $query_order_shipping_manifest = \DB::select("SELECT f_update_order_shipping_manifest('$order_no','$airwaybill',$real_price,$real_weight,$user_id)");
                $query_update_status = \DB::select("SELECT f_update_order_status_from_shipped_to_success('$order_no','Diinput lewat webadmin',$user_id,$role_id)");

            }
            \DB::commit();

        } catch (\Execption $e) {
            \DB::rollback();
        }

        return response()->json([
            "status" => "success",
            "message" => "data berhasil diproses"
        ]);
    }
}
