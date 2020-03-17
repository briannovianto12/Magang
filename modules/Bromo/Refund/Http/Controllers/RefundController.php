<?php

namespace Bromo\Refund\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\Buyer\Models\Buyer;
use Bromo\Refund\Entities\OrderRefund;
use Bromo\Refund\Datatables\RefundDatatable;
use Bromo\Seller\Models\Shop;
use Bromo\Transaction\Models\Order;
use DB;
use Carbon\Carbon;

class RefundController extends Controller
{
    protected $module;
    protected $model;
    protected $title;

    /**
     * Create a new controller instance.
     *
     * @param Order $model
     */
    public function __construct(OrderRefund $model)
    {
        $this->model = $model;
        $this->module = 'refund';
        $this->title = 'Refund';
    }

     /**
     * Get User 
     * @return Response
     */
    public function user()
    {
        return $request->user();
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
        $mod = $this->model->id;
        
        return view("{$this->module}::browse", $data);
    }

    /**
     * Get New Order data.
     * @param RefundDatatable $datatable
     * @return JsonResponse
     */
    public function refundData(RefundDatatable $datatable)
    {
        return $datatable->with([
            'model' => $this->model,
            'module' => $this->module
        ])->ajax();
    }

    public function refundOrder(Request $request, $id){
        $order_refund = OrderRefund::find($id);
        $order_no = Order::find($order_refund->order_id)->order_no;
        $order_refund_status = $order_refund->order_refunded;
        $date_now = Carbon::now();
        $refunded_date = new Carbon($request->input('refundDate') . ' ' . $request->input('refundTime'));

        if($order_refund_status == false){
            $order_refund_status = true;
        }
        else if($order_refund_status == true){
            $order_refund_status = false;
        }

        DB::table('order_refund')
            ->where('id', $id)
            ->update([
                'order_refunded' => $order_refund_status,
                'refund_date' => $refunded_date,
                'updated_at' => $date_now,
                'notes' => $request->input('refundNotes')
            ]);
        
            return response()->json([
                "status" => "OK",
                "order_no" => $order_no
            ]);
    }

    public function getRefundInfo(Request $request, $id){

        $order_refund = OrderRefund::where('id', $id)->first();
        $order = Order::find($order_refund->order_id);

        return response()->json([
            'id' => $order_refund->id,
            'order_id' => $order_refund->order_id,
            'order_no' => $order->order_no,
            'shop_id' => $order_refund->shop_id,
            'shop_name' => $order->shop_snapshot['name'],
            'buyer_id' => $order_refund->buyer_id,
            'buyer_name' => $order->buyer_snapshot['full_name'],
            'amount' => $order_refund->amount,
            'refund_date' => $order_refund->refund_date,
            'updated_at' => $order_refund->updated_at,
            'order_refunded' => $order_refund->order_refunded
        ]);
    }

}

