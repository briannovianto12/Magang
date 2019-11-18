<?php

namespace Bromo\Refund\DataTables;

use Bromo\Refund\Entities\RefundOrder;
use Exception;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class RefundDatatable extends DataTable
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
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
            })
            ->editColumn('order_refunded', function ($data) {
                $text = "false";
                if($data->order_refunded == true){
                    $text = "True";
                }
                else{
                    $text = "False";
                }
                return $text;
            })
            ->addColumn('action', function ($data) {
                if($data->order_refunded == false){
                    $action = [
                        'change_refund_status' => $data->id
                    ];
                } else {
                    $action = [
                    ];
                }
                return view('theme::layouts.includes.actions', $action);
            })
            ->rawColumns(['action'])
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
            ->selectRaw(\DB::raw(
                'order_refund.id as id, ' .
                'order_trx.order_no as order_no, ' .
                'shop.name as seller_name, ' .
                'user_profile.full_name as buyer_name, ' .
                'order_refund.amount as payment_amount, ' .
                'order_refund.notes as notes, ' .
                'order_refund.refund_date as refund_date, ' .
                'order_trx.updated_at as updated_at, ' .
                'order_refund.order_refunded as order_refunded'
            )
         )
        ->join('shop', 'shop.id', '=', 'order_refund.shop_id')
        ->join('user_profile', 'user_profile.id', '=', 'order_refund.buyer_id')
        ->join('order_trx', 'order_trx.id', '=', 'order_refund.order_id')
        ->orderBy('order_refund.id');

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
            //->addAction(['width' => '150px', 'footer' => 'Action', 'exportable' => false, 'printable' => false])
            ->minifiedAjax()
            ->parameters([
                'order' => [
                    [6, 'desc'],
                    [5, 'asc']
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
            ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
            ['data' => 'order_no', 'name' => 'order_no', 'title' => 'Order Number'],
            ['data' => 'seller_name', 'name' => 'seller_name', 'title' => 'Seller'],
            ['data' => 'buyer_name', 'name' => 'buyer_name', 'title' => 'Buyer'],
            ['data' => 'payment_amount', 'name' => 'payment_amount', 'title' => 'Payment Amount'],
            ['data' => 'notes', 'name' => 'notes', 'title' => 'Notes'],
            ['data' => 'refund_date', 'name' => 'refund_date', 'title' => 'Refund Date'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At'],
            ['data' => 'order_refunded', 'name' => 'order_refunded', 'title' => 'Refund'],
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