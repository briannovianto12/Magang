<?php

namespace Bromo\Logistic\DataTables;

use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use Bromo\Transaction\Models\OrderStatus;
use Bromo\Logistic\Entities\TraditionalLogisticStatus;
use Bromo\Logistic\Entities\PaymentStatus;

class OrderDatatable extends DataTable
{
    /**
     * Configure ajax response
     *
     * @return JsonResponse|mixed
     * @throws Exception
     */
    public function ajax()
    {
        return datatables($this->query())
            ->make(true);
    }

    /**
     * Query of process datatable.
     *
     * @return mixed
     */
    public function query()
    {
        $query = $this->model
            ->selectRaw( \DB::raw(
                'order_trx.id, ' .
                'order_trx.order_no, ' .
                'order_trx.updated_at, '.
                'f_get_order_description(order_trx.id) as item_desc, ' . 
                'shop.name as shop_name, '.
                'vw_business_contact_person.pickup_person_name as seller_full_name_name, '.
                'vw_business_contact_person.pickup_person_phone as seller_phone, ' .
                'order_trx.buyer_snapshot->>\'full_name\' as buyer_full_name, ' .

                // 'order_status.name as status, ' . 

                'COALESCE(order_shipping_manifest.etd_min,0) as etd_min, ' .
                'COALESCE(order_shipping_manifest.etd_max,0) as etd_max, ' .
                "COALESCE(order_shipping_manifest.airwaybill,'') as airwaybill, " .

                // Get the total order item
                'order_trx.payment_details->>\'total_order\' as total_order, ' .    
                'payment_method.name as payment_method, ' .

                // Get Courier name
                'order_trx.shipping_service_snapshot->\'shipper\'->>\'name\' as courier_name, ' .  

                // Order Status
                "(order_status.id = ".OrderStatus::CANCELED.") as is_cancelled, " .
                "(order_status.id = ".OrderStatus::REJECTED.") as is_rejected, " .
                
                // Notes
                "order_trx.notes, " .
                "order_trx.reject_notes, " .
                
                // logistic
                "(order_shipping_manifest.logistic_organizer_status = ".TraditionalLogisticStatus::WAITING_PICKUP.") as waiting_pickup, " .
                "(order_shipping_manifest.logistic_organizer_status = ".TraditionalLogisticStatus::IN_PROCESS_PICKUP.") as in_process, " .
                "(order_shipping_manifest.logistic_organizer_status = ".TraditionalLogisticStatus::PICKED_UP.") as picked_up, " .

                // "CONCAT(". config('logistic.gcs_path') . "/business/logos/" . ','. "business.logo_file) as logo_url," .

                "'". config('logistic.gcs_path'). "/businesses/logos/' as gcs_path," .
                'business.logo_file as logo, ' .

                "admin.name as penjemput, " .

                'logistic_organizer_status.name as status, ' .
                "order_shipping_manifest.pickup_details_snapshot->>'pickup_date' as expected_date" 
            ))
            ->join('payment_method', 'payment_method.id', '=', 'order_trx.payment_method_id')
            ->join('order_status', 'order_status.id', '=', 'order_trx.status')
            ->join('shop', 'shop.id', '=', 'order_trx.shop_id')
            ->join('business', 'business.id', '=', 'shop.business_id')
            ->join('vw_business_contact_person', 'business.id', '=', 'vw_business_contact_person.business_id')
            // ->join('business_member', 'business_member.business_id', '=', 'shop.business_id')
            // ->join('user_profile', 'user_profile.id', '=', 'business_member.user_id')
            ->join('shipping_courier', 'shipping_courier.id', '=', 'order_trx.shipping_courier_id')
            ->Join('order_shipping_manifest','order_trx.id','=','order_shipping_manifest.order_id')
            ->join('logistic_organizer_status', 'logistic_organizer_status.id', 'order_shipping_manifest.logistic_organizer_status' )
            ->leftjoin('admin','admin.id','=','order_shipping_manifest.user_admin_id')
            ->where('shipping_courier.provider_id', 3)
            ->whereIn('order_shipping_manifest.logistic_organizer_status', $this->status)
            ->orderBy('order_trx.created_at', 'desc');

            // id, order no, buyer name, shop name, payment method, status, updated at

            // nama order, nama toko, nama ekspedisi, status pesanan, tanggal siap kirim

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '150px', 'footer' => 'Action', 'exportable' => false, 'printable' => false])
            ->minifiedAjax()
            ->parameters([
                'order' => [
                    [3, 'asc'],
                    [6, 'desc']
                ],
                'scrollX' => true,
                'dom' => "<'row'<'col-sm-6 text-left'l><'col-sm-6 text-right'B>>" .
                    "<'row'<'col-sm-12'tr>>" .
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                'buttons' => [
                    [
                        'extend' => 'reload',
                        'text' => '<i class="la la-refresh"></i> <span>Reload</span>'
                    ]
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'title' => 'Product ID'],
            ['data' => 'order_no', 'name' => 'order_no', 'title' => 'Order Number'],
            ['data' => 'buyer_name', 'name' => 'buyer_name', 'title' => 'Buyer'],
            ['data' => 'shop_name', 'name' => 'shop_name', 'title' => 'Shop'],
            ['data' => 'payment_method', 'name' => 'payment_method', 'title' => 'Payment Method'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Date']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return $this->module . "_" . time();
    }
}